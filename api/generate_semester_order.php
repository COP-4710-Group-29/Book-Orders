<?php

/*
generate_semester_order.php
Author: Sarah Myerson
12/06/2021

Gets all data related to orders for a given semester
*/

require 'connect.php';

if(!isset($_GET['semester_id']))
{
  $array = array("status"=>false,"message"=>"Missing parameter: semester_id");
	echo json_encode($array);
  die();
}

$sql = "SELECT o.order_id, p.professor_id, c.semester_id, s.semester_name, p.first_name, p.last_name, c.course_code
  FROM professors AS p
  INNER JOIN courses AS c
    ON c.professor_id = p.professor_id
  INNER JOIN orders AS o
    ON o.professor_id = c.professor_id AND o.course_id = c.course_id
  INNER JOIN semesters AS s
    ON s.semester_id = c.semester_id
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
