<?php 
include "../autoload.php";

try {
	// $timestamp = isset($_GET['timestamp']) ? $_GET['timestamp'] : null;
	// $json = funcoes::LongPooling($timestamp, constants::SQL_EXISTE_MODIFICACAO, function($timeconsulta){
	
	// Chama a função da classe que traz os chamados
	$chamados = chamados::GetTotalChamados();
	$chamados = (array) $chamados;
	// var_dump($chamados);

	// Cria um JSON com os chamados
	$array = array('chamados_analitico' => $chamados);
	$json = json_encode($array);
	// });
} catch (Exception $e) {
	
	echo $e;
	$json = constants::INV_REQ_DATA;	
}

echo str_replace(array('\u0000chamados_analitico\u0000', '\u0000chamados\u0000'), '', $json);

?>