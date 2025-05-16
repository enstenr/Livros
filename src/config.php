<?php
// Include MongoDB library and connect to MongoDB
require_once __DIR__ . '/vendor/autoload.php';
$conn = mysqli_connect('db','root','','livros') or die('connection failed');
$databaseConnection = new MongoDB\Client("mongodb+srv://srajesh2712:Rajesh%4027121984@cluster0.aeu7m.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0");

// Select the database
$mongoDB = $databaseConnection->Livros;
$messageCollection = $mongoDB->messages;
?>