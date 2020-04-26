<!DOCTYPE html>
<html>
<head>
    <title>Company View</title>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
</head>
<body>
<?php

require "connectDB.php";
$check = true;

$selectUser = "SELECT a.personal_id_number, a.First_Name, a.Last_Name,a.Email,a.Company,a.User_rank, b.Country, b.City, b.Street, b.Number"
        . " FROM users a LEFT JOIN user_adress b ON a.personal_id_number=b.User_ID";
        //echo $selectId;
$nameObj = $connection->query($selectUser);
        
if($connection->connect_errno){
    die("Connection failed: " . $connection->connect_error);
}                
        
?>
<p>Edit users data</p>

<table style="width:100%">
  <tr>
      <th>Company Name</th>      
      <th>Main Country</th>
      <th>Main City</th>
      <th>Main Street</th>
      <th>Main Number</th>
      <th>Secondary Country</th>
      <th>Secondary City</th>
      <th>Secondary Street</th>
      <th>Secondary Number</th>
      <?php if($id == "Administrator") {?>
      <th> Edit </th>
      <?php } ?>
  </tr>
  
    <?php
    if($nameObj->num_rows>0)
    {
        while($singleRowU = $nameObj->fetch_assoc())
        {            
            $_SESSION['id'] = $singleRowU['personal_id_number'];
    ?>
  <tr>
      <td><?php echo $singleRowU['personal_id_number'];?></td>
      <td><?php echo $singleRowU['First_Name'];?></td>
      <td><?php echo $singleRowU['Last_Name'];?></td>
      <td><?php echo $singleRowU['Email'];?></td>
      <td><?php echo $singleRowU['Company'];?></td>
      <td><?php echo $singleRowU['User_rank'];?></td>
      <td><?php echo $singleRowU['Country'];?></td>
      <td><?php echo $singleRowU['City'];?></td>
      <td><?php echo $singleRowU['Street'];?></td>
      <td><?php echo $singleRowU['Number'];?></td> 
      <td><a href="EditUser.php?id=<?php echo $singleRowU['personal_id_number'];?>"> Edit</a></td>
  </tr>
        <?php
        }?>
 <?php
}
 ?>
</body>
</html>



