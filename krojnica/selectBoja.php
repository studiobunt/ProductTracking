<?php  

//selectBoja.php
 
include('../db/database_connection.php');

$query = "SELECT * FROM krojnica INNER JOIN boje ON krojnica.model=boje.model_id ORDER BY model DESC";
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