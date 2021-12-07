<?php
require 'connect.php';

// Make sure at least the course_id was passed
if(!isset($_POST['book_id']))
{
  $array = array("status"=>false,"message"=>"Missing parameter: book_id.");
	echo json_encode($array);
  exit();
}

// Save the posted variables to local ones
$book_id = $_POST['book_id'];
$book_title = $_POST['book_title'];
$author = $_POST['author'];
$edition = $_POST['edition'];
$publisher = $_POST['publisher'];
$isbn = $_POST['isbn'];

// Prepare the UPDATE
$sql = "UPDATE books AS b
  SET b.book_title = :book_title, b.author = :author, b.edition = :edition, b.publisher = :publisher, b.isbn = :isbn
  WHERE b.book_id = :book_id;";

$stmt = $pdo->prepare($sql);

// Bind the variable values to the PDO objects
$stmt->bindValue(':book_id', $book_id);
$stmt->bindValue(':book_title', $book_title);
$stmt->bindValue(':author', $author);
$stmt->bindValue(':edition', $edition);
$stmt->bindValue(':publisher', $publisher);
$stmt->bindValue(':isbn', $isbn);

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
