<?php
require "connectDB.php";

$userID = intval($_SESSION['userID']);

function Redirect($url, $permanent = false)
{
    if (headers_sent() === false)
    {
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}

$selectUser = "SELECT User_Rank FROM users_company WHERE User_ID =".$userID;
        
$nameObj = $connection->query($selectUser);

if($connection->connect_errno){
    die("Connection failed: " . $connection->connect_error);
}                
        
 if($nameObj->num_rows>0)
{
    while($singleRowU = $nameObj->fetch_assoc())
    {
        $userRank = $singleRowU['User_Rank'];
    
            if($userRank == "Administrator")
            {                                                  
                   Redirect('AddUser.php', false);
            }
            else
            {
                
               die("You do not have the permission to add users");
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Data management</title>    
<style>
</style>
</head>
<body>
    <?php
   
?>
    

</body>
</html>