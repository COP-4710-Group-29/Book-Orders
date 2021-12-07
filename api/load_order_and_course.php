<?php

/*
load_order_details.php.php
Author: Sarah Myerson
12/05/2021

Loads the selected order details
*/

require 'connect.php';

if(!isset($_GET['order_id']))
{
  $array = array("status"=>false,"message"=>"Missing required parameter: Order ID.");
	echo json_encode($array);
  die();
}

$order_id = $_GET['order_id'];

$sql = "SELECT o.order_id, o.professor_id, c.course_name, c.course_code
  FROM orders AS o, courses AS c
  WHERE
  o.order_id = ". $order_id ." AND c.course_id = o.course_id";

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
