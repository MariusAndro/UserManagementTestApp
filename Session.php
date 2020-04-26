<?php
   require('connectDB.php');
   session_start();
   
   $user_check = $_SESSION['login_user'];
   //echo $user_check;
   $ses_sql = $connection->query("select First_name from users where First_name = '$user_check' ");
   
   $row = $ses_sql->fetch_array(MYSQLI_ASSOC);
   
   $login_session = $row['First_name'];
   
   if(!isset($_SESSION['login_user'])){
      header("location:login.php");
      die();
   }
?>