<!DOCTYPE HTML>  
<html>
<head>
    <title>Company update page</title>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php

require "connectDB.php";

$id = 8;

$selectCompany = "SELECT Company_Name, Company_rank FROM company WHERE Company_ID = ".$id;
        //echo $selectId;
$nameObj = $connection->query($selectCompany);
        
if($connection->connect_errno){
    die("Connection failed: " . $connection->connect_error);
}                
        
if($nameObj->num_rows>0)
{
    while($singleRowC = $nameObj->fetch_assoc())
    {
        $oldCompanyName = $singleRowC['Company_Name'];
        $oldCompanyRank = $singleRowC['Company_rank'];
    }
}

$selectAdress = "SELECT Main_Country, Main_City, Main_Street, Main_number, Secondary_Country, Secondary_City, Secondary_Street, Secondary_number"
        . " FROM company_adress WHERE Company_ID = ".$id;
        //echo $selectId;
$adressObj = $connection->query($selectAdress);
        
if($connection->connect_errno){
    die("Connection failed: " . $connection->connect_error);
}                
        
if($adressObj->num_rows>0)
{
    while($singleRowA = $adressObj->fetch_assoc())
    {
        $oldMainCountry = $singleRowA['Main_Country'];
        $oldMainCity = $singleRowA['Main_City'];
        $oldMainStreet = $singleRowA['Main_Street'];
        $oldMainNumber = $singleRowA['Main_number'];
        $oldSecCountry = $singleRowA['Secondary_Country'];
        $oldSecCity = $singleRowA['Secondary_City'];
        $oldSecStreet = $singleRowA['Secondary_Street'];
        $oldSecNumber = $singleRowA['Secondary_number'];
    }
}


$companyNameErr = $companyRankErr =  $mainCountryErr = $mainCityErr = $mainStreetErr = $mainNumberErr =
        $secondaryCountryErr = $secondaryCityErr = $secondaryStreetErr = $secondaryNumberErr ="";



$companyName = $oldCompanyName;
$companyRank = $oldCompanyRank;
$mainCountry = $oldMainCity;
$mainCity = $oldMainCity;
$mainStreet = $oldMainStreet;
$mainNumber = $oldMainNumber;
$secondaryCountry = $oldSecCountry;
$secondaryCity = $oldSecCity;
$secondaryStreet = $oldSecStreet;
$secondaryNumber = $oldSecNumber;

$checkCompany = true;
$queryExecuted = true;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    
    if (empty($_POST["companyName"]))
    {
    $companyNameErr = "Company name is required";
    $checkCompany = false;
    } 
    else {
    $companyName = test_input($_POST["companyName"]);
        if (!preg_match("/^[a-zA-Z ]*$/",$companyName)) {
          $companyNameErr = "Only letters and white space allowed";
        }
    }
    
    $companyRank = test_input($_POST["companyRank"]);
        
  
  if(empty($_POST["mainCity"])){
      $mainCityErr = "Main city is required";
      $checkCompany = false;      
  }
  else {
    $mainCity = test_input($_POST["mainCity"]);
    
    if (!preg_match("/^[a-zA-Z ]*$/",$mainCity)) {
      $mainCityErr = "Only letters and white space allowed";
    }
  }
  
  if(empty($_POST["mainCountry"])){
      $mainCountryErr = "Main country is required";
      $checkCompany = false;      
  }
  else {
    $mainCountry = test_input($_POST["mainCountry"]);    
    if (!preg_match("/^[a-zA-Z ]*$/",$mainCountry)) {
      $mainCountryErr = "Only letters and white space allowed";
    }
  }
  
  if(empty($_POST["mainStreet"])){
      $mainStreetErr = "Main Street is required";
      $checkCompany = false;      
  }
  else {
    $mainStreet = test_input($_POST["mainStreet"]);    
    if (!preg_match("/^[a-zA-Z ]*$/",$mainStreet)) {
      $mainStreetErr = "Only letters and white space allowed";
    }
  }
  
  if(empty($_POST["mainNumber"])){
      $mainNumberErr = "Main number is required";
      $checkCompany = false;      
  }
  else {
    $mainNumber = test_input($_POST["mainNumber"]);    
    if (!preg_match("/^[a-zA-Z ]*[0-9]*$/",$mainNumber)) {
      $mainNumberErr = "Only letters and white space allowed";
    }
  }
  
  $secondaryCountry = test_input($_POST["secondaryCountry"]);    
  if (!preg_match("/^[a-zA-Z ]*$/",$secondaryCountry)) {
      $secondaryCountryErr = "Only letters and white space allowed";
  }
  
  $secondaryCity = test_input($_POST["secondaryCity"]);    
  if (!preg_match("/^[a-zA-Z ]*$/",$secondaryCity)) {
      $secondaryCityErr = "Only letters and white space allowed";
  }
  
  $secondaryStreet = test_input($_POST["secondaryStreet"]);    
  if (!preg_match("/^[a-zA-Z ]*$/",$secondaryStreet)) {
      $secondaryStreetErr = "Only letters and white space allowed";
  }
  
  $secondaryNumber = test_input($_POST["secondaryNumber"]);    
  if (!preg_match("/^[a-zA-Z ]*[0-9]*$/",$secondaryNumber)) {
      $secondaryNumberErr = "Only letters and white space allowed";
  }
  
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


if(isset($_POST['submit']) && $checkCompany){
       
        
        $updateCompany = "UPDATE company SET Company_Name = ?, Company_rank =? WHERE Company_ID =?";
                
        $vCompanyName = $connection->real_escape_string($companyName);
        $vCompanyRank = $connection->real_escape_string($companyRank);
        //$vCompanyID = $connection->real_escape_string($companyID);
               
        $companyStmt = $connection->prepare($updateCompany);
        $companyStmt->bind_param("ssi",$vCompanyName,$vCompanyRank,$id);
        
        //print_r($companyStmt);
        //var_dump($checkCompany);
        
        if($checkCompany)
        {            
            $companyStmt->execute();
            echo "Executed";
        }
        else
        {
            echo "There is an error somewere";
        }
                
        
                      
        $vCompanyID = $id;
                //var_dump($vCompanyID);
                
        $updateCompanyAdress = "UPDATE company_adress SET Main_Country =?, Main_City=?, Main_Street=?, Main_number=?,"
                    . "Secondary_Country=?, Secondary_City=?, Secondary_Street=?, Secondary_number=? WHERE Company_ID=?";
                
        $vMainCountry = $connection->real_escape_string($mainCountry);
        $vMainCity = $connection->real_escape_string($mainCity);
        $vMainStreet = $connection->real_escape_string($mainStreet);
        $vMainNumber = $connection->real_escape_string($mainNumber);
        $vSecondaryCountry = $connection->real_escape_string($secondaryCountry);
        $vSecondaryCity = $connection->real_escape_string($secondaryCity);
        $vSecondaryStreet = $connection->real_escape_string($secondaryStreet);
        $vSecondaryNumber = $connection->real_escape_string($secondaryNumber);

        $companyAdressStmt = $connection->prepare($updateCompanyAdress);
        $companyAdressStmt->bind_param("ssssssssi",$vMainCountry, $vMainCity, $vMainStreet, $vMainNumber,
        $vSecondaryCountry, $vSecondaryCity, $vSecondaryStreet, $vSecondaryNumber,$id);

        
        if($checkCompany)
        {                    
            $companyAdressStmt->execute();
            $queryExecuted = true;
        }
        else
        {
            echo "Another kind of error";
        }                                                   
        
        if($queryExecuted == false)
        {
            $deleteCompany = "DELETE FROM company WHERE Company_Name = ".$vCompanyName." AND Company_rank =".$vCompanyRank.")";
            
            if($checkCompany)
            {            
                $connection->query($deleteCompany);
                echo "Record deleted successfully";
            }
            
        }
        
        $connection->close();
    }
?>

<h2>Company Registration page</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
       
  Company Name: <input type="text" name="companyName" value="<?php echo $companyName;?>">
  <span class="error">* <?php echo $companyNameErr;?></span>
  <br><br>
  
  Main Country: <input type="text" name="mainCountry" value="<?php echo $mainCountry;?>">
  <span class="error">* <?php echo $mainCountryErr;?></span>
  <br><br>
  
  Main City: <input type="text" name="mainCity" value="<?php echo $mainCity;?>">
  <span class="error">* <?php echo $mainCityErr;?></span>
  <br><br>
  
  Main Street: <input type="text" name="mainStreet" value="<?php echo $mainStreet;?>">
  <span class="error">*<?php echo $mainStreetErr;?></span>
  <br><br>
  
  Main number: <input type="text" name="mainNumber" value="<?php echo $mainStreet;?>">
  <span class="error">* <?php echo $mainStreetErr;?></span>
  <br><br>
  
  Secondary Country: <input type="text" name="secondaryCountry" value="<?php echo $secondaryCountry;?>">
  <span class="error"> <?php echo $secondaryCountryErr;?></span>
  <br><br>
  Secondary City: <input type="text" name="secondaryCity" value="<?php echo $secondaryCity;?>">
  <span class="error"><?php echo $secondaryCityErr;?></span>
  <br><br>
  
  Secondary Street: <input type="text" name="secondaryStreet" value="<?php echo $secondaryStreet;?>">
  <span class="error"> <?php echo $secondaryStreetErr;?></span>
  <br><br>
  Secondary Number: <input type="text" name="secondaryNumber" value="<?php echo $secondaryNumber;?>">
  <span class="error"><?php echo $secondaryNumberErr;?></span>
  <br><br>
  
  <select id="Company rank" name="companyRank">
        <option value="Principal">Principal</option>
        <option value="Secondary">Secondary</option>
       
  </select>  
  
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>

</body>
</html>

