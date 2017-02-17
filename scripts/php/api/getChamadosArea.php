<?php 
include "../autoload.php";

$result = "";
$json = null;

try {
	// Chama a função da classe que traz os chamados, neste caso ele chama outra que já desserializa o array
	$chamados = chamados_area::SetToJson(chamados_area::GetTotalChamados());
	// var_dump($chamados);
	
	// Cria um JSON com os chamados
	$array = array('chamados' => $chamados);
	$json = json_encode($array);
	
} catch (Exception $e) {
	
	echo $e;
	$result = constants::INV_REQ_DATA;	
}

echo str_replace('\u0000chamados\u0000', '', $json);



?>