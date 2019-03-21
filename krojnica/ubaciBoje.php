<?php  

//ubaciBoje.php

include('../db/database_connection.php');

$message = '';

$form_data = json_decode(file_get_contents("php://input"));

$query = "SELECT boje.boja, boje.komad FROM krojnica, boje WHERE krojnica.model=boje.model_id and krojnica.model = '".$form_data->model."'";

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
