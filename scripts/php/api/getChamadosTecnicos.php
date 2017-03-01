<?php 
include "../autoload.php";

$json = null;

try {
	$timestamp = isset($_GET['timestamp']) ? $_GET['timestamp'] : null;
	$json = funcoes::LongPooling($timestamp, constants::SQL_EXISTE_MODIFICACAO, function($timeconsulta){
		// Chama a função da classe que traz os chamados, neste caso ele chama outra que já desserializa o array
		$chamados = chamados_tecnicos::SetToJson(chamados_tecnicos::GetTotalChamados());
		// var_dump($chamados);
		

		// Cria um JSON com os chamados
		$array = array('chamados' => $chamados, 'timestamp' => $timeconsulta);
		return json_encode($array);
	});
} catch (Exception $e) {
	
	echo $e;
	$json = constants::INV_REQ_DATA;	
}

echo str_replace('\u0000chamados\u0000', '', $json);

?>