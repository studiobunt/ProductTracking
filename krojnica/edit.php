<?php  

//edit.php

include('../db/database_connection.php');

$message = '';

$form_data = json_decode(file_get_contents("php://input"));

$data = array(
 ':model'  => $form_data->model,
 ':boja' => $form_data->boja,
 ':kilaza'  => $form_data->komad,
 ':datum_dolaska' => $form_data->dolazak
);

$data2 = array(
 ':model'  => $form_data->model,
 ':boja' => $form_data->boja,
 ':kilaza'  => $form_data->komad
);

$query = "
 UPDATE krojnica 
 SET model = :model, boja = :boja, komad = :kilaza, dolazak = :datum_dolaska 
 WHERE model = :model
";

$query2 = "UPDATE boje SET boja=:boja, komad=:kilaza WHERE boja=:boja AND model_id=:model";

$statement2 = $connect->prepare($query2);

$statement2->execute($data2);

$statement = $connect->prepare($query);
if($statement->execute($data))
{
 $message = 'Podaci su izmenjeni';
}

$output = array(
 'message' => $message
);

echo json_encode($output);

?>