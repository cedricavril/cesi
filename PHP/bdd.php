<?php 
echo 'test';
try {

	// Create connection
	$conn = new PDO("mysql:host=localhost;db=mydb","user1","pass");

	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "connected successfuly";


	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
echo "Connected successfully";
}
catch(PDOEXCEPTION $e) {
	die('erreur');
}

?>
