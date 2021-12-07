<?php

require 'connect.php';

// Make sure at least the course_id was passed
if(!isset($_POST['order_id']))
{
  $array = array("status"=>false,"message"=>"Missing parameter: order_id");
	echo json_encode($array);
  exit();
}

// Save the posted variables to local ones
$order_id = $_POST['order_id'];
$book_title = $_POST['book_title'];
$author = $_POST['author'];
$edition = $_POST['edition'];
$publisher = $_POST['publisher'];
$isbn = $_POST['isbn'];

// Prepare the INSERT
$sql = "INSERT INTO books
  (order_id, book_title, author, edition, publisher, isbn)
  VALUES (:order_id, :book_title, :author, :edition, :publisher, :isbn);";

$stmt = $pdo->prepare($sql);

// Bind the variable values to the PDO objects
$stmt->bindValue(':order_id', $order_id);
$stmt->bindValue(':book_title', $book_title);
$stmt->bindValue(':author', $author);
$stmt->bindValue(':edition', $edition);
$stmt->bindValue(':publisher', $publisher);
$stmt->bindValue(':isbn', $isbn);

$result = $stmt->execute();

// INSERT was successful
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
