<?php 

	/**
	* Classe que controla os follow-ups
	*/

	class followup
	{
		private $ticket;
		private $date;
		private $content;
		private $realname;
		private $name;
		private $is_tecnico;
		private $is_ator;

		public function __Get($name){			
			return $this->$name;
		}	

		public function __Set($name,$value){
			$this->$name = $value;
		}

	/**
 * Função que retorna os Follow-ups
 */
	public static function GetTotalFollowUp($timestamp){
		$pdo = conexao::conecta();
		$sql = funcoes::ExecutePDO(constants::SQL_FOLLOW_UP . funcoes::QuotedStr($timestamp), true);

		return $sql->fetchAll(PDO::FETCH_CLASS, __CLASS__);
	}

	public static function SetToJson($array){
		foreach ($array as $key => $value) {
			$array_retorno[] = array('UUID' => funcoes::GetUUID(), 'ticket' => $value->ticket, 'date' => $value->date, 'content' => $value->content, 'realname' => $value->realname, 'name' => $value->name, 'is_tecnico' => $value->is_tecnico, 'is_ator' => $value->is_ator);
		}

		return $array_retorno;
	}
}

?>