<?php 
include "../autoload.php";

if (isset($_POST['tickets_id'])) {
	$ajuste = new ajustar();

	$ajuste->tickets_id = $_POST['tickets_id'];
	$ajuste->date 		= $_POST['date']; 
	$ajuste->new_status = $_POST['new_status']; 
	echo json_encode(array('ajuste' => $ajuste->Montar()->Inserir()));
}

	// $ajuste = new ajustar();
	// $ajuste->tickets_id = 1024;
	// $ajuste->date 		= '2017-08-25 12:45:00'; 
	// $ajuste->new_status = 3; 
	// echo json_encode(array('ajuste' => $ajuste->Montar()->Inserir()));
?>