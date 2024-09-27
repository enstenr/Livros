<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `message` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_contacts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>messages</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php 
include 'admin_header.php'; 

require_once __DIR__ . '/vendor/autoload.php'; // MongoDB PHP Library

// Connect to MongoDB
$databaseConnection = new MongoDB\Client;
$myDatabase = $databaseConnection->Livros; 
$messageCollection = $myDatabase->messages; 

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
      <p> User ID: <span><?php echo $message['_id']; ?></span></p> <!-- MongoDB auto-generated ID -->
      <p> Nom Prénom: <span><?php echo htmlspecialchars($message['name']); ?></span></p>
      <p> Numéro: <span><?php echo htmlspecialchars($message['Number']); ?></span></p>
      <p> Email: <span><?php echo htmlspecialchars($message['Email']); ?></span></p>
      <p> Message: <span><?php echo htmlspecialchars($message['Message']); ?></span></p>
      <a href="admin_contacts.php?delete=<?php echo $message['_id']; ?>" onclick="return confirm('Supprimer ce message ?');" class="delete-btn">Supprimer le message</a>
   </div>
   <?php }  ?>
   
   </div>
</section>

<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>