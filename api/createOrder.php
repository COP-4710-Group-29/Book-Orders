<?php

require 'connect.php';

// Make sure at least the course_id was passed
if(!isset($_POST['course_id']) && !isset($_POST['professor_id']))
{
  $array = array("status"=>false,"message"=>"Missing parameter(s).");
	echo json_encode($array);
  exit();
}

// Save the posted variables to local ones
$course_id = $_POST['course_id'];
$professor_id = $_POST['professor_id'];

// Check if the order already exists
$sql = "SELECT COUNT(course_id) AS num FROM orders WHERE course_id = :course_id AND professor_id = :professor_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':course_id', $course_id);
$stmt->bindValue(':professor_id', $professor_id);

// Execute
$stmt->execute();

// Fetch the result
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// If it returns anything > 0, throw an error
if($row['num'] > 0)
{
  $array = array("status"=>false,"message"=>"An order has already been created for this course");
	echo json_encode($array);
  die();
}

// Prepare the INSERT
$sql = "INSERT INTO orders
  (course_id, professor_id)
  VALUES (:course_id, :professor_id);";

$stmt = $pdo->prepare($sql);

// Bind the variable values to the PDO objects
$stmt->bindValue(':course_id', $course_id);
$stmt->bindValue(':professor_id', $professor_id);

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
