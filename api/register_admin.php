<?php

/*
register_admin.php
Author: Sarah Myerson
11/21/2021

Creates a new admin account
*/

require 'connect.php';

$email = $_POST['email'];
$password = $_POST['password'];

// Check if the email already exists
$sql = "SELECT COUNT(email) AS num FROM admins WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email', $email);

// Execute
$stmt->execute();

// Fetch the result
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// If it returns anything > 0, throw an error
if($row['num'] > 0)
{
  $array = array("status"=>false,"message"=>"An account with that email address already exists.");
	echo json_encode($array);
  die();
}

// Hash the password using SHA256
$password = hash('sha256', $password);

// Prepare the INSERT
$sql = "INSERT INTO admins (email, password) VALUES (:email, :password)";
$stmt = $pdo->prepare($sql);

$stmt->bindValue(':email', $email);
$stmt->bindValue(':password', $password);

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
