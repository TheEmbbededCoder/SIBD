<html>
<head>
	<title>Clients</title>
</head>
<body>
	<h1>Clients</h1>
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

	if(!empty($_REQUEST['all'])) {
		$all = $_REQUEST['all'];
	}

	$queryVariables = array();
	if($all == 0) {
		$query = "SELECT * FROM client natural join phone_number_client WHERE ";

		$first = True;

		if(!empty($_REQUEST['VAT_client'])) {
			$VAT_client = $_REQUEST['VAT_client'];
			if($first == True) {
				$first = False;
			}
			else {
				$query = $query . " AND "; 
			}
			$query = $query . "VAT = '$VAT_client' "; 
		}
		if(!empty($_REQUEST['client_name'])) {
			$client_name = $_REQUEST['client_name'];
			if($first == True) {
				$first = False;
			}
			else {
				$query = $query . " AND "; 
			}
			$query = $query . "name LIKE '%$client_name%' ";
		}
		if(!empty($_REQUEST['client_address_street'])) {
			$client_address_street = $_REQUEST['client_address_street'];
			if($first == True) {
				$first = False;
			}
			else {
				$query = $query . " AND "; 
			}
			$query = $query . "street LIKE '%$client_address_street%' ";
		}
		if(!empty($_REQUEST['client_address_city'])) {
			$client_address_city = $_REQUEST['client_address_city'];
			if($first == True) {
				$first = False;
			}
			else {
				$query = $query . " AND "; 
			}
			$query = $query . "city LIKE '%$client_address_city%' ";
		}
		if(!empty($_REQUEST['client_address_zip'])) {
			$client_address_zip = $_REQUEST['client_address_zip'];
			if($first == True) {
				$first = False;
			}
			else {
				$query = $query . " AND "; 
			}
			$query = $query . "zip LIKE '%$client_address_zip%' ";
		}

		$query = $query . "ORDER BY VAT;";
	}
	else {
		$query = "SELECT * FROM client natural join phone_number_client ORDER BY name;";
	}

	$sql = $connection->prepare($query);
	if(!$sql->execute($queryVariables)) {
		$info = $connection->errorInfo();
		echo("<p>Error: {$info[2]}</p>");
		exit();
	}

	$result=$sql->fetchAll();

	if($result == 0) {
		$info = $sqls->errorInfo();
		echo("<p>Error: {$info[2]}</p>");
		exit();
	}

	echo("<h3>Found Clients</h3>");

	// Checks if there are clients with the given parameters
	$nrows = $sql->rowCount();
	if ($nrows == 0) {
		echo("<p>There is no client for the given input.</p>");
	}
	else {
		echo("<table border=\"1\">");
		echo("<tr><td>VAT</td><td>Name</td><td>Phone Number</td><td>Birth Date</td><td>Street</td><td>City</td><td>ZIP</td><td>Gender</td><td>Age</td></tr>");
		foreach($result as $row)
		{
			echo("<tr><td>");
			echo($row['VAT']);
			echo("</td><td>");
			echo($row['name']);
			echo("</td><td>");
			echo($row['phone']);
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
			echo("</td></td>");
			echo("<td><a href=\"consults.php/?VAT_client=");
			echo($row['VAT']);
        	echo("&Client_Name=");
        	echo($row['name']);
			echo("\">View client</a></td></td>");
			echo("</td></td>");
			echo("<td><a href=\"updateclient.php/?VAT_client=");
			echo($row['VAT']);
        	echo("&Client_Name=");
        	echo($row['name']);
			echo("\">Update</a></td></tr>\n");
			echo("</td></tr>");
		}
		echo("</table>");
	}

	// Allows for the addition of new clients
	?>

	<form action='insertclient.php' method='post'>
	<h3>New client</h3>
	<h4>Input the new client information</h4>
	<p>VAT: <input type='text' name='vat' required /></p>
	<p>Name: <input type='text' name='name' required/></p>
	<?php
	// Limitação da data de nascimento à data atual
	echo("<p>Birth Date: <input type='date' name='birth_date' max=" . date("Y-m-d") . " required/></p>");
	?>
	<p>Street: <input type='text' name='street' required/></p>
	<p>City: <input type='text' name='city' required/></p>
	<p>ZIP: <input type='text' name='zip' required/></p>
	<p>Gender: <select name="gender2">
		<option value="Female">Female</option>
		<option value="Male">Male</option>
		<option value="Other">Other</option>
	</select> </p>
	<p>CellPhone Number: <input type="tel" name="phone" pattern="[0-9]{9}" required/></p>
	<p><input type="submit" value="Submit"/></p>

	<?php
	$connection = null;
?>
<button><a href="homepage.php">Homepage</button>
</body>
</html>