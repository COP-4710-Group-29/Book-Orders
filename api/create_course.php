<?php

/*
create_course.php
Author: Derek Murdza
12/01/2021

Creates a new course
*/

require 'connect.php';

$course_name = $_POST['course_name'];

// Prepare the INSERT
$sql = "INSERT INTO courses (course_name) VALUES (:course_name)";
$stmt = $pdo->prepare($sql);

$stmt->bindValue(':course_name', $course_name);

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

?>
