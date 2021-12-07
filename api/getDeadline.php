<?php

/*
getDeadline.php
Author: Sarah Myerson
12/06/2021

Gets the current deadline
*/

require 'connect.php';

$sql = "SELECT deadline FROM deadlines WHERE deadline_id = 1 LIMIT 1";
$stmt = $pdo->prepare($sql);

// Execute
$result = $stmt->execute();

// If the execution failed, throw an error
if(!$result)
{
  $array = array("status"=>false,"message"=>"We could not load the page. Please try again.");
  echo json_encode($array);
  die();
}

// Fetch the result
$array = array();

$array['status'] = true;

while($row = $stmt->fetch(PDO::FETCH_ASSOC))
  $array['deadline'][] = $row;

echo json_encode($array);
