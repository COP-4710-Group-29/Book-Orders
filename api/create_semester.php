<?php

/*
create_semester.php
Author: Sarah Myerson
11/25/2021

Creates a new semester
*/

require 'connect.php';

$semester_name = $_POST['semester_name'];

// Prepare the INSERT
$sql = "INSERT INTO semesters (semester_name) VALUES (:semester_name)";
$stmt = $pdo->prepare($sql);

$stmt->bindValue(':semester_name', $semester_name);

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
