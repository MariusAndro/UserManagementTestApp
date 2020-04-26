<!DOCTYPE HTML>  
<html>
<head>
    <title>User update page</title>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>
    
<?php

require "connectDB.php";

$check = true;
$globalID = intval($_SESSION['userID']);
$id = $_GET['id'];
$uRank = $_GET['uRank'];



//Update of user rank made by Administrator
$selectCompany = "SELECT a.User_ID, a.First_Name, a.Last_Name, b.Company_Name, c.User_Rank
FROM users a LEFT JOIN 
(SELECT a.Company_ID, a.Company_Name, a.Company_rank, b.User_ID, b.User_Rank FROM company a
LEFT JOIN users_company b ON a.Company_ID = b.Company_ID 
) b ON a.User_ID=b.User_ID
LEFT JOIN users_company c ON a.User_ID=c.User_ID WHERE a.User_ID = ".$id;
        //echo $selectId;
$nameObj = $connection->query($selectCompany);
        
if($connection->connect_errno){
    die("Connection failed: " . $connection->connect_error);
}                
        
if($nameObj->num_rows>0)
{
    while($singleRowU = $nameObj->fetch_assoc())
    {        
        $oldUserRank = $singleRowU['User_Rank'];
       
    }
}
//Update for user's information
$selectAdress = "SELECT a.User_ID, a. personal_id_number, a.First_Name, a.Last_Name, a.Email, a.Password, b.Country, b.City, b.Street, b.Number FROM users a
LEFT JOIN users_adress b on a.User_ID = b.User_ID
WHERE a.User_ID = ".$id;
        //echo $selectId;
$adressObj = $connection->query($selectAdress);
        
if($connection->connect_errno){
    die("Connection failed: " . $connection->connect_error);
}                
        
if($adressObj->num_rows>0)
{
    while($singleRowA = $adressObj->fetch_assoc())
    {
        $oldPersonalId = $singleRowA['personal_id_number'];
        $oldFirstName = $singleRowA['First_Name'];
        $oldLastName = $singleRowA['Last_Name'];
        $oldEmail = $singleRowA['Email'];
        $oldPassword = $singleRowA['Password'];
        $oldCountry = $singleRowA['Country'];
        $oldCity = $singleRowA['City'];
        $oldStreet = $singleRowA['Street'];
        $oldNumber = $singleRowA['Number'];
        
    }
}
// define variables and set to empty values
$firstNameErr = $lastNameErr = $companyErr = $vCNPerr = $emailErr = $rankErr = $vPswdErr = $countryErr = $cityErr = $streetErr = $numberErr = "";
$firstName = $oldFirstName;
$lastName = $oldLastName;
$CNP = $oldPersonalId;
$email = $oldEmail;
$vPswd = $oldPassword;
$country = $oldCountry;
$city = $oldCity;
$street = $oldStreet;
$number = $oldNumber;
$newRank = $oldUserRank;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if($uRank == "User" || $id == $globalID){
        if (empty($_POST["firstName"])) {
        $firstNameErr = "First name is required";
        $check = false;
      } else {
        $firstName = test_input($_POST["firstName"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$firstName)) {
          $firstNameErr = "Only letters and white space allowed";
        }
      }

      if (empty($_POST["lastName"])) {
        $lastNameErr = "Last name is required";
        $check = false;
      } else {
        $lastName = test_input($_POST["lastName"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$lastName)) {
          $lastNameErr = "Only letters and white space allowed";
        }
      }    

      if (empty($_POST["cnp"])) {
        $vCNPerr = "CNP is required";
        $check = false;
      } else {
        $CNP = test_input($_POST["cnp"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[0-9]*$/",$CNP)) {
          $vCNPerr = "Only numbers allowed";
        }
      }

      if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $check = false;
      } else {
        $email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $emailErr = "Invalid email format";
        }
      }

      if (empty($_POST["password"])) {
        $vPswdErr = "Password is required";
        $check = false;
      } else {
        $vPswd = test_input($_POST["password"]);    
    //    if (!preg_match("'/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/'",$vPswd)) {
    //      $vPswdErr = "Invalid password";
    //    }
      }
      if (empty($_POST["country"])) {
        $countryErr = "Country is Required";
        $check = false;
      } else {
        $country = test_input($_POST["country"]);
      }

      if (empty($_POST["city"])) {
        $cityErr = "City is required";
        $check = false;
      } else {
        $city = test_input($_POST["city"]);
      }

      if (empty($_POST["street"])) {
        $streetErr = "Street is required";
        $check = false;
      } else {
        $street = test_input($_POST["street"]);
      }

      if (empty($_POST["number"])) {
        $numberErr = "Street number is required";
        $check = false;
      } else {
        $number = test_input($_POST["number"]);
      }
    }
    elseif($uRank == "Administrator"){
        if (empty($_POST["rank"])) {
          $rankErr = "Rank is Required";
          $check = false;
        } else {
          $rank = test_input($_POST["rank"]);
      }
    }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if(isset($_POST['submit']) && $check){
       
        if($uRank=="Administrator"){
            
            $updateUser = "UPDATE users_company SET User_Rank = ? WHERE User_ID = ?";
            
            $vRank = $connection->real_escape_string($_POST['rank']);

            $userStmt = $connection->prepare($updateUser);
            $userStmt->bind_param("si",$vRank,$id);

            if($check)
            {
                //var_dump($userStmt->execute());
                $userStmt->execute();
                echo "Executed admin update";
            }
            else
            {
                echo "First error";
                //var_dump($userStmt->execute());
            }
        }
        if($uRank=="User"){
            $updateUserAdress = "UPDATE users, users_adress "
                    . "SET users.personal_id_number=?,users.Firs_Name =?,users.Last_Name,users.Email=?, users.Password=?"
                    . " users_adress.Country =?, users_adress.City =?, users_adress.Street =?, users_adress.Number =? "
                    . "WHERE users.User_ID =? AND users_adress.User_ID=?";        

            $vCNP = $connection->real_escape_string($_POST['cnp']);
            $vFirstName = $connection->real_escape_string($_POST['firstname']);
            $vLastName = $connection->real_escape_string($_POST['lastname']);
            $vEmail = $connection->real_escape_string($_POST['email']);
            $vPassword = $connection->real_escape_string($_POST['password']);
            $vCountry = $connection->real_escape_string($_POST['country']);
            $vCity = $connection->real_escape_string($_POST['city']);
            $vStreet = $connection->real_escape_string($_POST['street']);
            $vNumber = $connection->real_escape_string($_POST['number']);        

            $userAdressStmt = $connection->prepare($updateUserAdress);
            $userAdressStmt->bind_param("sssssssssi",$vCNP,$vFirstName,$vLastName,$vEmail,$vPassword,$vCountry,$vCity,$vStreet,$vNumber,$id);

            if($check)
            {
                //var_dump($userAdressStmt->execute());
                $userAdressStmt->execute();
                echo "Executed user update";
            }
            else
            {
                echo "Second error";
                //var_dump($userAdressStmt->execute());
            }
        }
        
        $connection->close();
    }    
?>

<h2>User Edit page</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
    
  <?php if($uRank == "User" || $id == $globalID){?>CNP: <input type="text" name="cnp" value="<?php echo $CNP;?>">
  <span class="error">* <?php echo $vCNPerr;?></span>
  <br><br><?php }?>
    
  First Name: <?php if($uRank == "User"|| $id == $globalID){?><input type="text" name="firstName" value="<?php echo $firstName;?>">
  <span class="error">* <?php echo $firstNameErr;?></span>
  <br><br><?php } else{echo $firstName;?> <br> <?php }?>
  
  Last Name: <?php if($uRank == "User"|| $id == $globalID){?><input type="text" name="lastName" value="<?php echo $lastName;?>">
  <span class="error">* <?php echo $lastNameErr;?></span>
  <br><br><?php } else{echo $lastName;?> <br><br> <?php }?>
  
  <?php if($uRank == "User"|| $id == $globalID){?>E-mail: <input type="text" name="email" value="<?php echo $email;?>">
  <span class="error">* <?php echo $emailErr;?></span>
  <br><br><?php }?>
  
  <?php if($uRank == "User"|| $id == $globalID){?>Password: <input type="password" name="password" value="<?php echo $vPswd;?>">
  <span class="error">*<?php echo $vPswdErr;?></span>
  <br><br><?php }?>
  
<!--  Company: <input type="text" name="company" value="<?php echo $company;?>">
  <span class="error">* <?php echo $companyErr;?></span>
  <br><br>-->
  
  <?php if($uRank == "User"|| $id == $globalID){?>Country: <input type="text" name="country" value="<?php echo $country;?>">
  <span class="error">* <?php echo $countryErr;?></span>
  <br><br>
  City: <input type="text" name="city" value="<?php echo $city;?>">
  <span class="error">*<?php echo $cityErr;?></span>
  <br><br><?php }?>
  
  <?php if($uRank == "User"|| $id == $globalID){?>Street: <input type="text" name="street" value="<?php echo $street;?>">
  <span class="error">* <?php echo $streetErr;?></span>
  <br><br><?php }?>
  
  <?php if($uRank == "User"|| $id == $globalID){?>Number: <input type="text" name="number" value="<?php echo $number;?>">
  <span class="error">*<?php echo $numberErr;?></span>
  <br><br><?php }?>
  
  <?php if($uRank == "Administrator"){?>
  <select id="rank" name="rank">
        <option value="Administrator">Administrator</option>
        <option value="Normal">Normal</option>
        <span class="error">* <?php echo $rankErr;?></span>
  </select>  <?php }?>
  
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>

</body>
</html>