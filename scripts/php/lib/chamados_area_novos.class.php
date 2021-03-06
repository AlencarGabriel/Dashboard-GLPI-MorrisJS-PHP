<?php 

	/**
	* Classe que controla os chamados por area
	*/

	class chamados_area_novos
	{
		private $total;
		private $area;

		public function __Get($name){
			return $this->$name;
		}	

		public function __Set($name,$value){
			$this->$name = $value;
		}

	/**
 * Função que retorna os chamados
 */
	public static function GetTotalChamados(){
		$pdo = conexao::conecta();
		$sql = funcoes::ExecutePDO(constants::SQL_TOTAL_AREA_NOVOS);

		return $sql->fetchAll(PDO::FETCH_CLASS, __CLASS__);
	}

	public static function SetToJson($array){
		foreach ($array as $key => $value) {
			$array_retorno[] = array('total' => $value->total, 'area' => $value->area);
		}

		return $array_retorno;
	}

}

?>