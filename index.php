<?php
   require("connectDB.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
       if($connection->connect_errno){
            die("Connection failed: " . $connection->connect_error);
        } 
       
      $myusername = $connection->real_escape_string(test_input($_POST['username']));
      $mypassword = $connection->real_escape_string(test_input($_POST['password'])); 
      
      $sql = "SELECT * FROM users WHERE First_name = '".$myusername."' and password = '".$mypassword."'";
      $result = $connection->query($sql);
      //print_r($result);
      $row = $result->fetch_array(MYSQLI_ASSOC);
      //$active = $row['active'];
      
      $count = $result->num_rows;
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count == 1) {
         $_SESSION["myusername"];
         $_SESSION['login_user'] = $myusername;
         
         header("location: welcome.php");   
      }else {
         $error = "Your Login Name or Password is invalid";
      }
   }
   
  function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<html>
   
   <head>
      <title>Login Page</title>
      
      <style type = "text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }
         .box {
            border:#666666 solid 1px;
         }
      </style>
      
   </head>
   
   <body bgcolor = "#FFFFFF">
	
      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
				
            <div style = "margin:30px">
               
               <form action = "" method = "post">
                  <label>UserName  :</label><input type = "text" name = "username" class = "box"/><br /><br />
                  <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
                  <input type = "submit" value = " Submit "/><br />
               </form>
               
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php if(isset($error)){ echo $error; }?></div>
					
            </div>
				
         </div>
			
      </div>

   </body>
</html>