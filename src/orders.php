<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>commande</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>vos commande</h3>
   <p> <a href="home.php">home</a> / orders </p>
</div>

<section class="placed-orders">

   <h1 class="title">commandes passées</h1>

   <div class="box-container">

      <?php
         $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($order_query) > 0){
            while($fetch_orders = mysqli_fetch_assoc($order_query)){
      ?>
      <div class="box">
         <p> date de commande: <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
         <p> nom prenom : <span><?php echo $fetch_orders['name']; ?></span> </p>
         <p> portable : <span><?php echo $fetch_orders['number']; ?></span> </p>
         <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
         <p> adresse : <span><?php echo $fetch_orders['address']; ?></span> </p>
         <p> mode de paiement: <span><?php echo $fetch_orders['method']; ?></span> </p>
         <p> vos commandes : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
         <p> prix total : <span>$<?php echo $fetch_orders['total_price']; ?>/-</span> </p>
         <p> statut de paiement : <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; } ?>;"><?php echo $fetch_orders['payment_status']; ?></span> </p>
         </div>
      <?php
       }
      }else{
         echo '<p class="empty">aucune commande passée pour le moment !</p>';
      }
      ?>
   </div>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>