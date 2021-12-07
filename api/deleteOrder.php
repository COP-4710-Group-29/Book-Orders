<?php
require 'connect.php';

// Make sure at least the order_id was passed
if(!isset($_POST['order_id']))
{
  $array = array("status"=>false,"message"=>"Missing parameter(s).");
	echo json_encode($array);
  exit();
}

// Save the posted variables to local ones
$order_id = $_POST['order_id'];

// Prepare the INSERT
$sql = "DELETE FROM orders AS o
  WHERE o.order_id = :order_id;";

$stmt = $pdo->prepare($sql);

// Bind the variable values to the PDO objects
$stmt->bindValue(':order_id', $order_id);

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
