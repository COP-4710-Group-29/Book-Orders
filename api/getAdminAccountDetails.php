<?php

/*
getAdminAccountDetails.php
Author: Sarah Myerson
12/06/2021

Gets account details of the given admin
*/

require 'connect.php';

if(!isset($_POST['admin_id']))
{
  $array = array("status"=>false,"message"=>"Missing parameter: admin_id.");
	echo json_encode($array);
  exit();
}

$admin_id = $_POST['admin_id'];

$sql = "SELECT email FROM admins WHERE admin_id = :admin_id LIMIT 1";
$stmt = $pdo->prepare($sql);

$stmt->bindValue(':admin_id', $admin_id);

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
$array = array();

$array['status'] = true;

while($row = $stmt->fetch(PDO::FETCH_ASSOC))
  $array['details'][] = $row;

echo json_encode($array);
