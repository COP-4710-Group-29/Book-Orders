<?php
require 'connect.php';

// Make sure at least the course_id was passed
if(!isset($_POST['course_id']))
{
  $array = array("status"=>false,"message"=>"Missing parameter: course_id.");
	echo json_encode($array);
  exit();
}

// Save the posted variables to local ones
$course_id = $_POST['course_id'];
$course_name = $_POST['course_name'];
$course_code = $_POST['course_code'];
$semester_id = $_POST['semester_id'];

// Prepare the INSERT
$sql = "UPDATE courses AS c
  SET c.course_name = :course_name, c.course_code = :course_code, c.semester_id = :semester_id
  WHERE c.course_id = :course_id;";

$stmt = $pdo->prepare($sql);

// Bind the variable values to the PDO objects
$stmt->bindValue(':course_id', $course_id);
$stmt->bindValue(':course_name', $course_name);
$stmt->bindValue(':course_code', $course_code);
$stmt->bindValue(':semester_id', $semester_id);

$result = $stmt->execute();

// UPDATE was successful
if($result)
{
  $array = array("status"=>true);
	echo json_encode($array);
}

// Something went wrong
else
{
  $array = array("status"=>false,"message"=>"An internal error occured.");
	echo json_encode($array);
}
