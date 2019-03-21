<?php

//select.php


include('../db/database_connection.php');

$form_data = json_decode(file_get_contents("php://input"));

$query = '';
$data = array();

if(isset($form_data->search_query))
{
 $search_query = $form_data->search_query;
 $query = "
 SELECT * FROM krojnica 
 WHERE model LIKE '%$search_query%'
 ";
}
else
{
 $query = "SELECT * FROM krojnica ORDER BY dolazak DESC";
}

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
