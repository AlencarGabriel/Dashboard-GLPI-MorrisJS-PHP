<?php 

	/**
	* Classe que controla os chamados por tecnico
	*/

	class chamados_tecnicos
	{
		private $total;
		private $firstname;

		public function __Get($name){
			return $this->$name;
		}	

		public function __Set($name,$value){
			$this->$name = $value;
		}

	/**
 * Função que retorna os chamados não solucionados, agrupados por técnico
 */
	public static function GetTotalChamados(){
		$pdo = conexao::conecta();
		$sql = funcoes::ExecutePDO(constants::SQL_TOTAL_TECNICO, false);

		return $sql->fetchAll(PDO::FETCH_CLASS, __CLASS__);
	}

	public static function SetToJson($array){
		foreach ($array as $key => $value) {
			$array_retorno[] = array('total' => $value->total, 'firstname' => $value->firstname);
		}

		return $array_retorno;
	}

}

?>