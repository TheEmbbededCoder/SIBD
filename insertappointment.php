<html>
<head>
	<title>Appointment Inserted</title>
	<script>
	function goBack() {
		window.history.back()
	}
	</script>
</head>
<body>
	<h1>Appointment Inserted</h1>
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

	$VAT_doctor = $_REQUEST['vat_doctor'];

	$date = $_REQUEST['date'];
	$time = $_REQUEST['time'];

	$datestr = '' . $date . " " . substr($time, 0, 2) . ':00:00';
	echo "$datestr";

	$VAT_client = $_REQUEST['vat_client'];

	$description = $_REQUEST['description'];


	$query = "INSERT INTO appointment VALUES ('$VAT_doctor', '$datestr', '$description', '$VAT_client')";
	
	echo("<p>Will be inserted a new appointment.</p>");

	$nrows = $connection->exec($query);

	echo("Success !");
?>
	<form action='clients.php' method='post'>
	<p><input type="hidden" name="VAT_client"
		value="<?=$_REQUEST['vat_client']?>"/></p>
	<p><input type="submit" value="Continue"/></p>
	
	<?php

	$connection = null;
?>
</body>
</html>
