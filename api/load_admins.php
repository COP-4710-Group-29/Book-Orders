<?php

/*
load_admins.php
Author: Sarah Myerson
11/30/2021

Loads a list of users (non-admins)
*/

require 'connect.php';

$sql = "SELECT admin_id, email FROM admins";
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
$userData = array();

$userData['status'] = true;

while($row = $stmt->fetch(PDO::FETCH_ASSOC))
  $userData['admins'][] = $row;

echo json_encode($userData);
