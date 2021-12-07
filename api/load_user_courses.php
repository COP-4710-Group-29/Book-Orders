<?php

require 'connect.php';

if(!isset($_POST['professor_id']))
{
  $array = array("status"=>false,"message"=>"Missing parameter: professor_id.");
	echo json_encode($array);
  exit();
}

$professor_id = $_POST['professor_id'];


$sql = "SELECT c.course_id, c.course_name, c.course_code, s.semester_name
  FROM courses AS c
  INNER JOIN semesters AS s
    ON c.semester_id = s.semester_id AND c.professor_id = :professor_id";
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
$courseData = array();

$courseData['status'] = true;

while($row = $stmt->fetch(PDO::FETCH_ASSOC))
  $courseData['courses'][] = $row;

echo json_encode($courseData);
