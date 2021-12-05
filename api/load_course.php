<?php

/*
load_courses.php
Author: Sarah Myerson
11/25/2021

Loads a list of courses
*/

require 'connect.php';

$sql = "SELECT course_id, course_name, course_code FROM courses";
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
$courseData = array();

$courseData['status'] = true;

while($row = $stmt->fetch(PDO::FETCH_ASSOC))
  $courseData['courses'][] = $row;

echo json_encode($courseData);
