<?php

include 'config.php';

session_start();

// Ensure the admin is logged in
$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
   exit();  // Ensure script halts after redirect
}

// Include MongoDB PHP Library and connect to MongoDB
require_once __DIR__ . '/vendor/autoload.php'; // MongoDB PHP Library
$databaseConnection = new MongoDB\Client;
$myDatabase = $databaseConnection->Livros; 
$messageCollection = $myDatabase->messages;

// Check if a message is being deleted
if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];

   try {
      
       $result = $messageCollection->deleteOne([
           '_id' => new MongoDB\BSON\ObjectId($delete_id ) 
       ]);

       if ($result->getDeletedCount() === 1) {
          
           header('location:admin_contacts.php');
           exit();
       } else {
           echo "Impossible de supprimer le message.";
       }
   } catch (Exception $e) {
       
       echo "Erreur: " . $e->getMessage();
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Messages</title>

   <!-- Font awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom admin CSS file link -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php 
include 'admin_header.php';  // Include the admin header only once

?>

<section class="messages">
   <h1 class="title">Messages</h1>
   <div class="box-container">

   <?php
   // Fetch all messages from MongoDB
   $messages = $messageCollection->find();

   foreach ($messages as $message) {
   ?>
   <div class="box">
      <p> User ID: <span><?php echo (string)$message['_id']; ?></span></p> <!-- Cast ObjectId to string -->
      <p> Nom Prénom: <span><?php echo htmlspecialchars($message['name']); ?></span></p>
      <p> Numéro: <span><?php echo htmlspecialchars($message['Number']); ?></span></p>
      <p> Email: <span><?php echo htmlspecialchars($message['Email']); ?></span></p>
      <p> Message: <span><?php echo htmlspecialchars($message['Message']); ?></span></p>
      <a href="admin_contacts.php?delete=<?php echo (string)$message['_id']; ?>" onclick="return confirm('Supprimer ce message ?');" class="delete-btn">Supprimer le message</a>
   </div>
   <?php } ?>
   
   </div>
</section>

<!-- Custom admin JS file link -->
<script src="js/admin_script.js"></script>

</body>
</html>
