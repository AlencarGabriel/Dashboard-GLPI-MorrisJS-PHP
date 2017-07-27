<?php 
include "../autoload.php";

function GetContent($file /*, $timestamp*/){
	global $caminho;
	$json_url = $caminho . "scripts/php/api" .  DIRECTORY_SEPARATOR . $file; //. "?timestamp=" . $timestamp;

	return file_get_contents($json_url);
}

try {
	$timestamp = isset($_GET['timestamp']) ? $_GET['timestamp'] : null;

	$json = funcoes::LongPooling($timestamp, constants::SQL_EXISTE_MODIFICACAO, function($timeconsulta){
		$ajson[] = json_decode(GetContent("getChamados.php"));
		$ajson[] = json_decode(GetContent("getChamadosArea.php"));
		$ajson[] = json_decode(GetContent("getChamadosAreaNovos.php"));
		$ajson[] = json_decode(GetContent("getChamadosTecnicos.php"));

		return array('chamados' => $ajson, 'timestamp' => $timeconsulta); 
	});

} catch (Exception $e) {
	
	echo $e;
	$json = constants::INV_REQ_DATA;	
}

echo json_encode($json);

?>