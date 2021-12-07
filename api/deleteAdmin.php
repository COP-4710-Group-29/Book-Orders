<?php
require 'connect.php';

// Make sure at least the course_id was passed
if(!isset($_POST['admin_id']))
{
  $array = array("status"=>false,"message"=>"Missing parameter(s).");
	echo json_encode($array);
  exit();
}

// Save the posted variables to local ones
$admin_id = $_POST['admin_id'];

// Prepare the INSERT
$sql = "DELETE FROM admins AS a
  WHERE a.admin_id = :admin_id";

$stmt = $pdo->prepare($sql);

// Bind the variable values to the PDO objects
$stmt->bindValue(':admin_id', $admin_id);

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
