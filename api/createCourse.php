<?php
require 'connect.php';

// Make sure at least the course_id was passed
if(!isset($_POST['course_code']) && !isset($_POST['course_name']) && !isset($_POST['semester_id']))
{
  $array = array("status"=>false,"message"=>"Missing parameter(s).");
	echo json_encode($array);
  exit();
}

// Save the posted variables to local ones
$semester_id = $_POST['semester_id'];
$professor_id = $_POST['professor_id'];
$course_name = $_POST['course_name'];
$course_code = $_POST['course_code'];

// Prepare the INSERT
$sql = "INSERT INTO courses
  (semester_id, professor_id, course_name, course_code)
  VALUES (:semester_id, :professor_id, :course_name, :course_code);";

$stmt = $pdo->prepare($sql);

// Bind the variable values to the PDO objects
$stmt->bindValue(':semester_id', $semester_id);
$stmt->bindValue(':professor_id', $professor_id);
$stmt->bindValue(':course_name', $course_name);
$stmt->bindValue(':course_code', $course_code);

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
