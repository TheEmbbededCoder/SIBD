<html>
<body>
	<?php
	$host="db.ist.utl.pt";
	$user="ist425355";	
	$password="emyg3992";
	$dsn = "mysql:host=$host;dbname=$user";
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

	$query = "SELECT * FROM client WHERE ";
	$queryVariables = array();

	$first = True;

	if(!empty($_REQUEST['VAT_client'])) {
		$VAT_client = $_REQUEST['VAT_client'];
		if($first == True) {
			$first = False;
		}
		else {
			$query = $query . " AND "; 
		}
		$query = $query . "VAT = :VAT_client "; 
		$queryVariables[':VAT_client'] = $VAT_client;
	}
	if(!empty($_REQUEST['client_name'])) {
		$client_name = $_REQUEST['client_name'];
		if($first == True) {
			$first = False;
		}
		else {
			$query = $query . " AND "; 
		}
		$query = $query . "name = :client_name ";
		$queryVariables[':client_name'] = $client_name;
	}
	if(!empty($_REQUEST['client_address_street'])) {
		$client_address_street = $_REQUEST['client_address_street'];
		if($first == True) {
			$first = False;
		}
		else {
			$query = $query . " AND "; 
		}
		$query = $query . "street = :client_address_street ";
		$queryVariables[':client_address_street'] = $client_address_street;
	}
	if(!empty($_REQUEST['client_address_city'])) {
		$client_address_city = $_REQUEST['client_address_city'];
		if($first == True) {
			$first = False;
		}
		else {
			$query = $query . " AND "; 
		}
		$query = $query . "city = :client_address_city ";
		$queryVariables[':client_address_city'] = $client_address_city;
	}
	if(!empty($_REQUEST['client_address_zip'])) {
		$client_address_zip = $_REQUEST['client_address_zip'];
		if($first == True) {
			$first = False;
		}
		else {
			$query = $query . " AND "; 
		}
		$query = $query . "zip = :client_address_zip ";
		$queryVariables[':client_address_zip'] = $client_address_zip;
	}

	$query = $query . ";";
	
	/* // DEBUG
	echo("<p>$query</p>");
	print_r($queryVariables);*/

	$sql = $connection->prepare($query);
	if(!$sql->execute($queryVariables)) {
		$info = $connection->errorInfo();
		echo("<p>Error: {$info[2]}</p>");
		exit();
	}

	$result=$sql->fetchAll();

	echo("<table border=\"1\">");
	echo("<tr><td>VAT</td><td>Name</td><td>Birth Date</td><td>Street</td><td>City</td><td>ZIP</td><td>Gender</td><td>Age</td></tr>");
	foreach($result as $row)
	{
		echo("<tr><td>");
		echo($row['VAT']);
		echo("</td><td>");
		echo($row['name']);
		echo("</td><td>");
		echo($row['birth_date']);
		echo("</td><td>");
		echo($row['street']);
		echo("</td><td>");
		echo($row['city']);
		echo("</td><td>");
		echo($row['zip']);
		echo("</td><td>");
		echo($row['gender']);
		echo("</td><td>");
		echo($row['age']);
		echo("</td></tr>");
		echo($row['age']);
		echo("</td></tr>");
	}
	echo("</table>");


	$connection = null;
?>

</body>
</html>