<?php 

	/**
	* Classe que controla os chamados por tecnico
	*/

	class chamados_tecnicos
	{
		private $total;
		private $firstname;
		private $solucionados;

		public function __Get($name){
			return $this->$name;
		}	

		public function __Set($name,$value){
			$this->$name = $value;
		}

	/**
	 * Função que substitui o nome do usuário
	 * @param string $name - Nome atual
	 * @return string - Novo nome
	 */
	private function AlterName($name){
		// if ($name == "Paulo") {
		// 	return "Gibimba";
		// }else{
			return $name;
		// }
	}

	/**
 * Função que retorna os chamados não solucionados, agrupados por técnico
 */
	public static function GetTotalChamados(){
		$pdo = conexao::conecta();
		$sql = funcoes::ExecutePDO(constants::SQL_TOTAL_TECNICO);

		return $sql->fetchAll(PDO::FETCH_CLASS, __CLASS__);
	}

	public static function SetToJson($array){
		foreach ($array as $key => $value) {
			$array_retorno[] = array('total' => $value->total, 'firstname' => chamados_tecnicos::AlterName($value->firstname), 'solucionados' => $value->solucionados);
		}

		return $array_retorno;
	}


}

?>