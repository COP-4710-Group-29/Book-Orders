<?php

/*
load_user_orders.php
Author: Sarah Myerson
12/06/2021

Loads all of a user's orders
*/

require 'connect.php';

if(!isset($_POST['professor_id']))
{
  $array = array("status"=>false,"message"=>"Missing parameter: professor_id");
	echo json_encode($array);
  die();
}

$professor_id = $_POST['professor_id'];

$sql = "SELECT o.order_id, p.professor_id, c.semester_id, s.semester_name, p.first_name, p.last_name, c.course_code, o.timestamp
  FROM professors AS p
  INNER JOIN courses AS c
    ON c.professor_id = p.professor_id AND c.professor_id = :professor_id
  INNER JOIN orders AS o
    ON o.professor_id = p.professor_id AND o.course_id = c.course_id
  INNER JOIN semesters AS s
    ON s.semester_id = c.semester_id
  ORDER BY o.order_id ASC";

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
$orderData = array();

if ($stmt->rowCount() > 0)
{
  $orderData['status'] = true;
  while($row = $stmt->fetch(PDO::FETCH_ASSOC))
  {
    $orderData['orders'][] = $row;
  }
}
else
{
  $orderData['status'] = false;
}

echo json_encode($orderData);
