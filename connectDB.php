<?php

//session_start();
$_SESSION['userID'] = 2;


$dbPassword = "@dmin123";
$dbUserName = "Administrator";
$dbServer = "localhost";
$dbName = "usermanagement";

$connection = new mysqli($dbServer,$dbUserName,$dbPassword,$dbName);

if($connection->connect_errno)
{
    exit("Database connection failed. Reason:".$connection->connect_error);
}


//$connection->close();
