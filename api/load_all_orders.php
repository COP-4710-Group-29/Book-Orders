<?php

/*
load_all_orders.php
Author: Sarah Myerson
11/30/2021

Loads a list of users (non-admins)
*/

require 'connect.php';

$sql = "SELECT o.order_id, p.professor_id, p.first_name, p.last_name, c.course_code, o.timestamp
  FROM professors AS p
  INNER JOIN courses AS c
    ON c.professor_id = p.professor_id
  INNER JOIN orders AS o
    ON o.professor_id = c.professor_id AND o.course_id = c.course_id
  ORDER BY o.order_id ASC";

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
$orderData = array();

$orderData['status'] = true;

while($row = $stmt->fetch(PDO::FETCH_ASSOC))
  $orderData['orders'][] = $row;

echo json_encode($orderData);
