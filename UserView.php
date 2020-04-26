<?php
//session_start();
require "connectDB.php";


$check = true;
$uID = intval($_SESSION['userID']);
//$uR = "Administrator";

$selectUserDetail = "SELECT Company_ID, User_Rank FROM users_company WHERE User_ID =".$uID;
$cobj = $connection->query($selectUserDetail);

if($connection->connect_errno){
    die("Connection failed: " . $connection->connect_error);
} 

if($cobj->num_rows>0)
    {
        while($s = $cobj->fetch_assoc())
        {  
            $uR = $s['User_Rank'];
            $uc = $s['Company_ID'];
        }
    }

$selectUser = "SELECT a.User_ID, a. personal_id_number, a.First_Name, a.Last_Name, a.Email, b.Country, b.City, b.Street, b.Number, c.Company_Name, c.User_Rank, c.Company_ID FROM users a
LEFT JOIN users_adress b on a.User_ID = b.User_ID
LEFT JOIN 
(SELECT a.Company_ID, a.Company_Name, a.Company_rank, b.User_ID, b.User_Rank FROM company a
LEFT JOIN users_company b ON a.Company_ID = b.Company_ID 
) c ON a.User_ID = c.User_ID WHERE c.Company_ID =".$uc;
        //echo $selectId;
$nameObj = $connection->query($selectUser);
        
if($connection->connect_errno){
    die("Connection failed: " . $connection->connect_error);
}                
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data management</title>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
</head>
<body>

<table style="width:100%">
  <tr>
      <th>CNP</th>
      <th>First Name</th>
      <th>Last Name</th> 
      <th>Email</th>
      <th>Company</th>
      <th>User rank</th>
      <th>Country</th>
      <th>City</th>
      <th>Street</th>
      <th>Number</th>
      <th>Edit</th>
      <?php if($uR == "Administrator"){?><th>Delete</th><?php }?> 
  </tr>
  
    <?php
    if($nameObj->num_rows>0)
    {
        while($singleRowU = $nameObj->fetch_assoc())
        {                          
    ?>
  <tr>
      <td><?php echo $singleRowU['personal_id_number'];?></td>
      <td><?php echo $singleRowU['First_Name'];?></td>
      <td><?php echo $singleRowU['Last_Name'];?></td>
      <td><?php echo $singleRowU['Email'];?></td>
      <td><?php echo $singleRowU['Company_Name'];?></td>
      <td><?php echo $singleRowU['User_Rank'];?></td>
      <td><?php echo $singleRowU['Country'];?></td>
      <td><?php echo $singleRowU['City'];?></td>
      <td><?php echo $singleRowU['Street'];?></td>
      <td><?php echo $singleRowU['Number'];?></td>
      
      <?php if($singleRowU['User_ID'] == $uID){ ?>
      <td><a href="EditUser.php?id=<?php  echo $singleRowU['User_ID'];?>&uRank=<?php echo $uR ;?>"> Edit</a></td>
      <?php } 
      elseif($uR == "Administrator"){?>
      <td><a href="EditUser.php?id=<?php  echo $singleRowU['User_ID'];?>&uRank=<?php echo $uR ;?>"> Edit</a></td>
      <?php }?>
      
      <?php if($uR == "Administrator"){?>
      <td><a href="DeleteUser.php" onclick="return confirm('Are you sure you want to delete the user?');">Delete</a><?php }?>


  </tr>
        <?php
        }?>
 <?php
}
 ?>
</body>
</html>

