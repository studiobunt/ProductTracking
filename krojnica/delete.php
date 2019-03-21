<?php

//delete.php

include('../db/database_connection.php');

$message = '';

$form_data = json_decode(file_get_contents("php://input"));

$data = array(
 ':model'  => $form_data->model,
 ':boja' => $form_data->boja
);

$query = "DELETE FROM boje WHERE model_id = :model and boja=:boja";



$statement = $connect->prepare($query);
if($statement->execute($data))
{
 $message = 'Model je obrisan.';
}

$output = array(
 'message' => $message
);

echo json_encode($output);

?>