<?php

/*
getAccountDetails.php
Author: Sarah Myerson
12/06/2021

Gets account details of the given user
*/

require 'connect.php';

if(!isset($_POST['professor_id']))
{
  $array = array("status"=>false,"message"=>"Missing parameter: professor_id.");
	echo json_encode($array);
  exit();
}

$professor_id = $_POST['professor_id'];

$sql = "SELECT professor_id, email, first_name, last_name FROM professors WHERE professor_id = :professor_id LIMIT 1";
$stmt = $pdo->prepare($sql);

$stmt->bindValue(':professor_id', $professor_id);

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
  $array['details'][] = $row;

echo json_encode($array);
