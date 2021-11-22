<?php

/*
connect.php
Author: Sarah Myerson
11/21/2021

Connects to MySQL using the PDO object.
*/

define('MYSQL_USER', 'universal');
define('MYSQL_PASSWORD', 'knights');
define('MYSQL_HOST', 'localhost');
define('MYSQL_DATABASE', 'Bookstore');

// PDO options
$pdoOptions = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
);

// Connect to the database
$pdo = new PDO(
    "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE, //DSN
    MYSQL_USER, //Username
    MYSQL_PASSWORD, //Password
    $pdoOptions //Options
);
