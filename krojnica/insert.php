<?php  

//insert.php

include('../db/database_connection.php');

$message = '';

$form_data = json_decode(file_get_contents("php://input"));

$data = array(
 ':model'  => $form_data->model,
 ':boja' => $form_data->boja,
 ':kilaza'  => $form_data->kilaza,
 ':datum_dolaska' => $form_data->datum_dolaska
);

$data2 = array(
 ':model'  => $form_data->model,
 ':boja' => $form_data->boja,
 ':kilaza'  => $form_data->kilaza
);

$queryCheck = "SELECT * FROM krojnica WHERE model= '".$form_data->model."'";

$statementCheck = $connect->prepare($queryCheck);

$statementCheck->execute();

$row = $statementCheck->fetch(PDO::FETCH_ASSOC);

if(!$row)
{
$query = "
 INSERT INTO krojnica 
 (model, boja, komad, dolazak) VALUES 
 (:model, :boja, :kilaza, :datum_dolaska)
";

$query2 = "INSERT INTO boje (boja, komad, model_id) VALUES (:boja, :kilaza, :model)";


$statement = $connect->prepare($query);

$statement2 = $connect->prepare($query2);

$statement2->execute($data2);


if($statement->execute($data))
{
 $message = 'Model je uspešno ubacen';
}

$output = array(
 'message' => $message
);

echo json_encode($output);
} else {
	$query2 = "INSERT INTO boje (boja, komad, model_id) VALUES (:boja, :kilaza, :model)";
	$statement2 = $connect->prepare($query2);
	if($statement2->execute($data2))
		{
		 $message = 'Model je uspešno ubacen';
		}

		$output = array(
		'message' => $message
		);

		echo json_encode($output);
		}
?>
