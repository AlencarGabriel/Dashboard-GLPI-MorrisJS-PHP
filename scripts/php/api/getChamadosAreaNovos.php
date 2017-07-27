<?php 
include "../autoload.php";

$json = null;

try {
	// $timestamp = isset($_GET['timestamp']) ? $_GET['timestamp'] : null;
	// $json = funcoes::LongPooling($timestamp, constants::SQL_EXISTE_MODIFICACAO, function($timeconsulta){

	// Chama a função da classe que traz os chamados, neste caso ele chama outra que já desserializa o array
	$chamados = chamados_area_novos::SetToJson(chamados_area_novos::GetTotalChamados());
	// var_dump($chamados);


	// Cria um JSON com os chamados
	$array = array('chamados_area_novos' => $chamados);	
	$json = json_encode($array);
	// });
} catch (Exception $e) {
	
	echo $e;
	$json = constants::INV_REQ_DATA;	
}

echo str_replace(array('\u0000chamados_area_novos\u0000', '\u0000chamados\u0000'), '', $json);

?>