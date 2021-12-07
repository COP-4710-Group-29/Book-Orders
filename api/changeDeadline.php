<?php

/*
changeDeadline.php
Author: Sarah Myerson
12/06/2021

Changes the deadline
*/

require 'connect.php';

if(!isset($_POST['deadline']))
{
  $array = array("status"=>false,"message"=>"Missing parameter: deadline.");
	echo json_encode($array);
  exit();
}

$deadline = $_POST['deadline'];

// Prepare the INSERT
$sql = "UPDATE deadlines AS d SET d.deadline = :deadline WHERE d.deadline_id = 1;";
$stmt = $pdo->prepare($sql);

$stmt->bindValue(':deadline', $deadline);

$result = $stmt->execute();

// INSERT was successful
if($result)
{
  $array = array("status"=>true);
	echo json_encode($array);
}

else
{
  $array = array("status"=>false,"message"=>"An internal error occured.");
	echo json_encode($array);
}
