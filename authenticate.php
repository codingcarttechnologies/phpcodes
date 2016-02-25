<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "hell";
$dbname = "dan";
if(isset($_POST["action"])) $action = $_POST["action"];
if(isset($_POST["first_name"])) $first_name = $_POST["first_name"];
if(isset($_POST["last_name"])) $last_name = $_POST["last_name"];
if(isset($_POST["password"])) $password = $_POST["password"];
if(isset($_POST["email"])) $email = $_POST["email"];

// Create connection
$conn = new mysqli($servername, 'cct123', 'hell12', $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Creating a new ID and password
if( $action  == "new")
{
 $sql = "SELECT * FROM auth WHERE email='".$email."';";	
 $result = $conn->query($sql);
	if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "That email address is already in use<br>";
    }
	} else {
		$sql = "INSERT INTO auth (first_name, last_name, email, password) VALUES ('".$first_name."', '".$last_name."', '".$email."', '".$password."');";    
		if ($conn->query($sql) === TRUE) {
            header('Location: index.php');
      } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
      }      
	}
}
//Login with an existing account
elseif( $action  == "login")
{
 $sql = "SELECT  * FROM auth WHERE email = '".$email."' AND password = '".$password."';";	
 $result = $conn->query($sql);
 $followingdata = $result->fetch_assoc();
 	if ($followingdata > 0) {
    // output data of each row
	$_SESSION['id'] = $followingdata['id'];
		  setcookie('arientation_user',$email,time() + (86400 * 7)); // 86400 = 1 day
		 
		  
          header('Location: index1.php?id=' . $_SESSION['id']); 
          

	}
else {
header('Location: login.html'); 
}
}

$conn->close();
?> 

