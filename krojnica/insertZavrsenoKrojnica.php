<?php  

//insertZavrsenoKrojnica.php

include('../db/database_connection.php');

$message = '';

$form_data = json_decode(file_get_contents("php://input"));

$data = array(
 ':model'  => $form_data->model
);

$query = "
 UPDATE krojnica 
 SET zavrsetak = CURDATE(), zavrseno = 1 
 WHERE model = '".$form_data->model."'
";

$statement = $connect->prepare($query);


$queryCheck = "SELECT * FROM sivara WHERE model= '".$form_data->model."'";

$statementCheck = $connect->prepare($queryCheck);

$statementCheck->execute();

$row = $statementCheck->fetch(PDO::FETCH_ASSOC);

if(!$row)
{

$query2 = "INSERT INTO sivara (model, dolazak) VALUES (:model, CURDATE())";

$statement2 = $connect->prepare($query2);
$statement2->execute($data);

}


$queryCheck = "SELECT * FROM boje_sivara WHERE model_id= '".$form_data->model."' AND boja= '".$form_data->boja."'";

$statementCheck = $connect->prepare($queryCheck);

$statementCheck->execute();

$row = $statementCheck->fetch(PDO::FETCH_ASSOC);

if(!$row)
{

$query3 = "INSERT INTO boje_sivara (boja, komad, model_id) SELECT boja, komad, model_id FROM boje WHERE model_id=:model";

$delete_query="DELETE a FROM boje_sivara a
  INNER JOIN boje_sivara a2
WHERE a.id < a2.id
AND   a.boja = a2.boja
AND   a.model_id  = a2.model_id";

$statement3 = $connect->prepare($query3);
$statement3->execute($data);

$statement4 = $connect->prepare($delete_query);
$statement4->execute();
}

if($statement->execute())
{
 $message = 'Model je uspešno prebačen u šivaru';
}

$output = array(
 'message' => $message
);

echo json_encode($output);

?>
