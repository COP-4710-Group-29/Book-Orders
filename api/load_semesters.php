<?php

/*
load_semesters.php
Author: Sarah Myerson
11/25/2021

Loads a list of semesters
*/

require 'connect.php';

$sql = "SELECT semester_id, semester_name FROM semesters";
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
$semesterData = array();

$semesterData['status'] = true;

while($row = $stmt->fetch(PDO::FETCH_ASSOC))
  $semesterData['semesters'][] = $row;

echo json_encode($semesterData);
