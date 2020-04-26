<?php

require "connectDB.php";

$globalID = intval($_SESSION['userID']);

$id = $_GET['id'];

$selectUserDetail = "SELECT Company_ID, User_Rank FROM users_company WHERE User_ID =".$globalID;
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

if($uR == "Administrator")
        {
            $deleteUser = "DELETE FROM users WHERE User_ID = ".$id;
                       
            {            
                $connection->query($deleteUser);
                echo "Record deleted successfully from users";
            }
            
            $deleteUserFromAdress = "DELETE FROM users_adress WHERE user_ID =".$id;
            {            
                $connection->query($deleteUserFromAdress);
                echo "Record deleted successfully from users_adress";
            }
            
            $deleteFromUsersCompany = "DELETE FROM users_company WHERE user_ID=".$id;
            {            
                $connection->query($deleteFromUsersCompany);
                echo "Record deleted successfully from users_company";
            }
            
        }
else {
    die("You are not allowed to delete users");
}