<?php 

	/**
	* Classe que controla os chamados
	*/

	class chamados
	{
		private $Novos;
		private $N_Solucionados;
		private $N_Solucionados_User;
		private $Outros;
		private $Dt_hoje;
		private $Vencidos;
		private $N_Atribuidos;
		private $Internos;
		private $Venc_umdia;
		private $Venc_doisdia;
		private $Venc_tresdia;
		private $Venc_quatrodia;
		private $Venc_cincodia;
		private $Venc_seisdia;
		private $Venc_setedia;
		private $Venc_oitodia;
		private $Venc_novedia;
		private $Venc_dezdia;

		public function __Get($name){
			return $this->$name;
		}	

		public function __Set($name,$value){
			$this->$name = $value;
		}

	/**
 * Função que retorna os chamados não solucionados, novos, outros ou vencidos do banco
 */
	public static function GetTotalChamados(){
		$pdo = conexao::conecta();
		$sql = funcoes::ExecutePDO(constants::SQL_TOTAL_CHAMADOS, true);
		// $sql = $pdo->prepare(constants::SQL_TOTAL_TECNICO);		
		// $sql->bindValue(':ID', $id, PDO::PARAM_INT);		
		// $sql->execute();

		return $sql->fetchObject(__CLASS__);
	}
}

?>