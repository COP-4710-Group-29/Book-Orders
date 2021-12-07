<?php
require 'connect.php';

// Make sure at least the course_id was passed
if(!isset($_POST['book_id']))
{
  $array = array("status"=>false,"message"=>"Missing parameter(s).");
	echo json_encode($array);
  exit();
}

// Save the posted variables to local ones
$book_id = $_POST['book_id'];

// Prepare the INSERT
$sql = "DELETE FROM books AS b
  WHERE b.book_id = :book_id;";

$stmt = $pdo->prepare($sql);

// Bind the variable values to the PDO objects
$stmt->bindValue(':book_id', $book_id);

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
