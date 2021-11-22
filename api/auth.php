<?php

/*
auth.php
Author: Sarah Myerson
11/21/2021

Authenticates an account
*/

require 'connect.php';

$email = $_POST['email'];
$password = $_POST['password'];

// Hash the password using SHA256
$password = hash('sha256', $password);

// Check if the account exists
$sql = "SELECT COUNT(email) AS num, professor_id, first_name, last_name FROM professors WHERE (email = :email AND password = :password)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email', $email);
$stmt->bindValue(':password', $password);

// Execute
$stmt->execute();

// Fetch the result
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// If it return num = 1, success!
if($row['num'] == 1)
{
  $array = array(
    "status"=>true,
    "professor_id"=>$row['professor_id'],
    "first_name"=>$row['first_name'],
    "last_name"=>$row['last_name']
  );
	echo json_encode($array);
}

else
{
  $array = array(
    "status"=>false,
    "message"=>"The email or username and/or password do not match our records.
Please try again."
  );
	echo json_encode($array);
}

?>
