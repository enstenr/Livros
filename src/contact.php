<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

require_once __DIR__ . '/vendor/autoload.php';

// Connect to MongoDB Database
$databaseConnection = new MongoDB\Client;

// Connecting to specific database in MongoDB
$myDatabase = $databaseConnection->Livros;

// Connecting to our MongoDB Collections
$userCollection = $myDatabase->messages;

// Initialize variables to prevent undefined variable warnings
$name = $email = $number = $msg = "";

// Check if the form is submitted and the fields are not empty
if (isset($_POST['send']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['number']) && !empty($_POST['message'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $msg = $_POST['message'];

    // Create an array with the data to insert
    $data = array(
        "name" => $name,
        "Email" => $email,
        "Number" => $number,
        "Message" => $msg
    );

    // Insert data into the database only if all fields are not empty
    $insert = $userCollection->insertOne($data);

    if ($insert) {
        echo '<center><h4 style="color: green;">Message envoyé avec succès</h4></center>';
    } else {
        echo '<center><h4 style="color: red;">Le message na pas été envoyé</h4></center>';
    }
} else {
    echo '<center><h4 style="color: red;">Veuillez remplir tous les champs du formulaire.</h4></center>';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Contactez-nous</h3>
   <p> <a href="home.php">home</a> / contact </p>
</div>

<section class="contact">

   <form action="" method="post">
      <h3>N'hésitez pas à nous envoyer un message!</h3>
      <input type="text" name="name" required placeholder="Saisissez votre nom prénom" class="box">
      <input type="email" name="email" required placeholder="Votre adresse email" class="box">
      <input type="number" name="number" required placeholder="Votre numéro de portable" class="box">
      <textarea name="message" class="box" placeholder="Écrivez votre message" id="" cols="30" rows="10"></textarea>
      <input type="submit" value="Envoyer" name="send" class="btn">
   </form>

</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
