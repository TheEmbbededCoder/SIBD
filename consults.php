<!DOCTYPE html>
<html>
<head>
	<title>Consults</title>
</head>
<body>
	<?php
	$host="db.ist.utl.pt";
	$user="ist425355";	
	$password="emyg3992";
	$dbname = $user;	

	// Try to connect to the database
	try	{
		$connection = new PDO("mysql:host=" . $host. ";dbname=" . $dbname, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

	}
	catch(PDOException $exception) {
		echo("<p>Error: ");
		echo($exception->getMessage());
		echo("</p>");
		exit();
	}

	$query = "SELECT * FROM client WHERE "
	$queryVariables = array();

	if(isset($_REQUEST['VAT_client'])) {
		$VAT_client = $_REQUEST['VAT_client'];
		$query = $query . "VAT = :VAT_client "
		$queryVariables[':VAT_client'] => $VAT_client
	}
	if(isset($_REQUEST['client_name'])) {
		$client_name = $_REQUEST['client_name'];
		$query = $query . "name = :client_name "
		$queryVariables[':client_name'] => $client_name
	}
	if(isset($_REQUEST['client_address_street'])) {
		$client_address_street = $_REQUEST['client_address_street'];
		$query = $query . "street = :client_address_street "
		$queryVariables[':client_address_street'] => $client_address_street
	}
	if(isset($_REQUEST['client_address_city']) {
		$client_address_city = $_REQUEST['client_address_city'];
		$query = $query . "city = :client_address_city "
		$queryVariables[':client_address_city'] => $client_address_city
	}
	if(isset($_REQUEST['client_address_zip'])) {
		$client_address_zip = $_REQUEST['client_address_zip'];
		$query = $query . "zip = :client_address_zip "
		$queryVariables[':client_address_zip'] => $client_address_zip
	}

	$query = $query . ";"
	echo $query

	$sql = $connection->prepare($query);
	if(!$sql->execute($queryVariables){
		$info = $connection->errorInfo();
		echo("<p>Error: {$info[2]}</p>");
		exit();
	}


</body>
</html>