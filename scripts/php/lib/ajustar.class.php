<?php 	

/**
* Classe que irá controlar o ajuste do tempo
*/
class ajustar
{
	private $tickets_id;
	private $date; // deve estar neste formato no PHP: "Y-m-d H:i:s" e vir do JS: "yyyy-mm-dd hh:ii:ss"
	private $old_status;
	private $new_status = 3; // Por padrão, será utilizado o status 3 como status de "Em Atendimento"
	private $delay;

	/* Dados do chamado e Ultima informação do Timeline */
	private $ticket = null;
	private $oldData = null;

	public function __Get($name){
		return $this->$name;
	}	

	public function __Set($name,$value){
		$this->$name = $value;
	}

	/**
	 * Função para buscar os dados de Ticket e o ultimo registro do Timeline.
	 * Deve ser chamada antes da função Inserir()
	 * @return type
	 */
	public function Montar(){
		$this->ticket = $this->getTicketData();
		$this->oldData = $this->getOldData();

		return $this;
	}

	/**
	 * Função para obter as informações do ultimo status
	 * @return type
	 */
	private function getOldData(){
		$dbh = conexao::conecta();
		$stmt = $dbh->prepare(constants::SQL_OLD_DATA_TIMELINE);
		$stmt->bindValue(':tickets_id', $this->tickets_id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetchObject(__CLASS__);
	}

	/**
	 * Função para obter as informações do chamado
	 * @return type
	 */
	private function getTicketData(){
		$dbh = conexao::conecta();
		$stmt = $dbh->prepare(constants::SQL_TICKET_DATA);
		$stmt->bindValue(':id', $this->tickets_id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetchObject(__CLASS__);
	}

	/**
	 * Calcular o Delay entre o ultimo status e o novo
	 * @return type
	 */
	private function calcDelay(){
		return (strtotime($this->date) - strtotime($this->oldData->date));
	}

	/**
	 * Função para preencher a classe com os dados do status
	 * @return type
	 */
	private function setData(){
		$this->old_status = $this->oldData->new_status;
		$this->delay = $this->calcDelay();
	}

	/**
	 * Função para validar o ajuste, e não quebrar a integridade do chamado
	 * @return type | array Devolve um arrau, se foi validado e a mensagem
	 */
	private function validaAjuste(){
		$valido = true;
		$mensagem = '';

		// validar se ticket existe
		if (empty($this->ticket) || empty($this->oldData)) {
			$valido = false;
			$mensagem .= "O chamado informado não existe; \r\n";
		}else{
			$this->setData();

			// validar se o chamado não esta solucionado
			if (!is_null($this->ticket->solvedate)){
				$valido = false;	
				$mensagem .= "O chamado já está solucionado; \r\n";
			}

			// validar se o status é permitido (3 ou 4)
			if (!in_array($this->new_status, [3, 4])) {
				$valido = false;
				$mensagem .= "Está querendo passar a perna né? \r\n O status deve ser: Chamado em Atendimento ou Pendente; \r\n";
			}		

			// validar se o status é diferente do ultimo
			if ($this->oldData->new_status == $this->new_status) {
				$valido = false;
				$mensagem .= "O novo status não pode ser igual ao último; \r\n";		
			}

			// validar se o tempo é maior que o ultimo
			if ($this->delay <= 0) {
				$valido = false;	
				$mensagem .= "O tempo não é superior ao da última alteração; \r\n";
			}
		}
		return array($valido, $mensagem);
	}

	/**
	 * Função para inserir o registro do acerto do tempo
	 * @return type
	 */
	public function Inserir(){		
		$return = $this->validaAjuste();

		if ($return[0]) {
			$dbh = conexao::conecta();
			$dbh->beginTransaction();
			try{

				$stmt = $dbh->prepare(constants::SQL_INSERT_TIMELINE);
				$stmt->bindValue(':tickets_id', $this->tickets_id,	PDO::PARAM_INT);
				$stmt->bindValue(':date', 		$this->date, 		PDO::PARAM_STR);
				$stmt->bindValue(':old_status', $this->old_status,	PDO::PARAM_STR);
				$stmt->bindValue(':new_status', $this->new_status, 	PDO::PARAM_STR);
				$stmt->bindValue(':delay', 		$this->delay, 		PDO::PARAM_INT);

				$stmt->execute();

				// Set Status novo na tabela de tickets
				$stmt = $dbh->prepare(constants::SQL_UPDATE_TICKET);
				$stmt->bindValue(':status', $this->new_status, 	PDO::PARAM_STR);
				$stmt->bindValue(':id', 	$this->tickets_id,	PDO::PARAM_INT);

				$stmt->execute();

				_TESTE_ ? $dbh->rollBack() : $dbh->commit();

				$return[1] = $return[1] . 'OK' . "\r\n";
				$return[2] = json_encode($this);

			} catch (Exception $e){
				$return[0] = false;
				$return[1] = $return[1] . 'Exception: ' . $e->getMessage() . "\r\n";
				$dbh->rollBack();
			}
		}

		return $return;
	}


}

?>