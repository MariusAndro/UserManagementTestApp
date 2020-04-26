<!DOCTYPE HTML>  
<html>
<head>
    <title>User registration page</title>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php

// define variables and set to empty values
$check = true;
$firstNameErr = $lastNameErr = $companyErr = $vCNPerr = $emailErr = $rankErr = $vPswdErr = $countryErr = $cityErr = $streetErr = $numberErr = "";
$firstName = $lastName = $company = $CNP = $email = $vPswd = $country = $city = $street = $number = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
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
  
  if (empty($_POST["company"])) {
    $companyErr = "Company is required";
    $check = false;
  } else {
    $company = test_input($_POST["company"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$company)) {
      $companyErr = "Only letters and white space allowed";
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

  if (empty($_POST["rank"])) {
    $rankErr = "Rank is Required";
    $check = false;
  } else {
    $rank = test_input($_POST["rank"]);
  }
  if (empty($_POST["country"])) {
    $countryErr = "Country is Required";
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

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

require "connectDB.php";

if(isset($_POST['submit']) && $check){
       
        
        $insertUser = "INSERT INTO users (personal_id_number,First_name, Last_name, Email, Password)"
        . "VALUES (?,?,?,?,?)";
        
        $vCNP = $connection->real_escape_string($_POST['cnp']);
        $vFirstName = $connection->real_escape_string($_POST['firstName']);
        $vLastName = $connection->real_escape_string($_POST['lastName']);
        $vEmail = $connection->real_escape_string($_POST['email']);
        $vPswd = $connection->real_escape_string($_POST['password']);
//        $vCompany = $connection->real_escape_string($_POST['company']);
//        $vRank = $connection->real_escape_string($_POST['rank']);
               
        $userStmt = $connection->prepare($insertUser);
        $userStmt->bind_param("sssss",$vCNP,$vFirstName,$vLastName,$vEmail,$vPswd);
                
        
        if($check)
        {
            
            //var_dump($userStmt->execute());
            $userStmt->execute();
            echo "Executed";
        }
        else
        {
            //var_dump($userStmt->execute());
        }
        
        //Extract the User ID
        $selectUserDetail = "SELECT User_ID FROM users WHERE personal_id_number = ".$vCNP;
        $iobj = $connection->query($selectUserDetail);

        if($connection->connect_errno){
            die("Connection failed: " . $connection->connect_error);
        } 

        if($iobj->num_rows>0)
        {
            while($s = $iobj->fetch_assoc())
            {                  
                $ui = $s['User_ID'];
            }
        }
        
        $insertUserAdress = "INSERT INTO users_adress (User_ID,Country, City, Street, Number)"
        . "VALUES (?,?,?,?,?)";
        
        $vUserId = $ui;
        $vCountry = $connection->real_escape_string($_POST['country']);
        $vCity = $connection->real_escape_string($_POST['city']);
        $vStreet = $connection->real_escape_string($_POST['street']);
        $vNumber = $connection->real_escape_string($_POST['number']);        
               
        $userAdressStmt = $connection->prepare($insertUserAdress);
        $userAdressStmt->bind_param("issss",$vUserId,$vCountry,$vCity,$vStreet,$vNumber);
                
        if($check)
        {
            //var_dump($userAdressStmt->execute());
            $userAdressStmt->execute();
            echo "Executed adress";
        }
        else
        {
            //var_dump($userAdressStmt->execute());
        }
        //Extract the Company ID
        
        $selectUserDetail = "SELECT Company_ID FROM company WHERE Company_Name = '".$company."'";        
        $cobj = $connection->query($selectUserDetail);

        if($connection->connect_errno){
            die("Connection failed: " . $connection->connect_error);
        } 

        if($cobj->num_rows>0)
        {
            while($s = $cobj->fetch_assoc())
            {                  
                $uc = $s['Company_ID'];
            }
        }
        else{
            echo "Add company";
        }                        
        
        $insertUserCompany = "INSERT INTO users_company (User_ID, Company_ID, User_Rank)"
        . "VALUES (?,?,?)";
        
        $vUId = $ui;
        $vCompanyId = $uc; 
        $vRank = $connection->real_escape_string($_POST['rank']);
        
        //echo $ui;
        //echo $uc;
        $userCompanyStmt = $connection->prepare($insertUserCompany);
        $userCompanyStmt->bind_param("iis",$vUId, $vCompanyId,$vRank);
                
        if($check)
        {
            //var_dump($userAdressStmt->execute());
            $userCompanyStmt->execute();
            echo "Executed company";
        }
        else
        {
            //var_dump($userAdressStmt->execute());
        }
        
        
        $connection->close();
    }
?>

<h2>User Registration page</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
    
  CNP: <input type="text" name="cnp" value="<?php echo $CNP;?>">
  <span class="error">* <?php echo $vCNPerr;?></span>
  <br><br>
    
  First Name: <input type="text" name="firstName" value="<?php echo $firstName;?>">
  <span class="error">* <?php echo $firstNameErr;?></span>
  <br><br>
  
  Last Name: <input type="text" name="lastName" value="<?php echo $lastName;?>">
  <span class="error">* <?php echo $lastNameErr;?></span>
  <br><br>
  
  E-mail: <input type="text" name="email" value="<?php echo $email;?>">
  <span class="error">* <?php echo $emailErr;?></span>
  <br><br>
  Password: <input type="password" name="password" value="<?php echo $vPswd;?>">
  <span class="error">*<?php echo $vPswdErr;?></span>
  <br><br>
  
  Company: <input type="text" name="company" value="<?php echo $company;?>">
  <span class="error">* <?php echo $companyErr;?></span>
  <br><br>
  
  Country: <input type="text" name="country" value="<?php echo $country;?>">
  <span class="error">* <?php echo $countryErr;?></span>
  <br><br>
  City: <input type="text" name="city" value="<?php echo $city;?>">
  <span class="error">*<?php echo $cityErr;?></span>
  <br><br>
  
  Street: <input type="text" name="street" value="<?php echo $street;?>">
  <span class="error">* <?php echo $streetErr;?></span>
  <br><br>
  Number: <input type="text" name="number" value="<?php echo $number;?>">
  <span class="error">*<?php echo $numberErr;?></span>
  <br><br>
  
  <select id="rank" name="rank">
        <option value="Administrator">Administrator</option>
        <option value="Normal">Normal</option>
        <span class="error">* <?php echo $rankErr;?></span>
  </select>  
  
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>

</body>
</html>
