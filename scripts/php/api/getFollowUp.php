<?php 
include "../autoload.php";

$json = null;

try {
	// passsa o timestamp do dia atual com a primeira hora caso o parametro venha nulo, para que venha somente os follow ups do dia atual
	$timestamp = isset($_GET['timestamp']) ? $_GET['timestamp'] : date("Y-m-d") . " 00:00:00";
	$timestamp = $timestamp == "" ? date("Y-m-d") . " 00:00:00" : $timestamp; // nao pode avaliar na linha acima, pois se "timestamp" for NULL, não é possivel avaliar
	$json = funcoes::LongPooling($timestamp, constants::SQL_EXISTE_MODIFICACAO_FOLLOW, function($timeconsulta, $timeEntrada){
		// Chama a função da classe que traz os follow-ups, neste caso ele chama outra que já desserializa o array
		sleep(2);
		$followups = followup::SetToJson(followup::GetTotalFollowUp($timeEntrada));
		// var_dump($followups);
		

		// Cria um JSON com os follow-ups
		$array = array('followups' => $followups, 'timestamp' => $timeconsulta);
		return json_encode($array);
	});
} catch (Exception $e) {
	
	echo $e;
	$json = constants::INV_REQ_DATA;	
}

echo str_replace('\u0000followups\u0000', '', $json);

?>