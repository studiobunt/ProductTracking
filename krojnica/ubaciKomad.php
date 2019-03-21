<?php  

//insert.php

include('../db/database_connection.php');

$message = '';

$form_data = json_decode(file_get_contents("php://input"));


$query = "SELECT komad FROM boje WHERE model_id='".$form_data->model."' and boja='".$form_data->boja."'";


$statement = $connect->prepare($query);

if($statement->execute())
{
  while($row = $statement->fetch(PDO::FETCH_ASSOC))
  {
    $data[] = $row;
  }
  echo json_encode($data);
}

?>
