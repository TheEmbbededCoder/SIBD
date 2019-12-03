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

	echo("<p>A new appointment will be inserted.</p>");
	// Dado que os dados de inserção tem de estar correctos, a consulta sera sempre bem criada
	$stmt = $connection->prepare("INSERT INTO appointment (VAT_doctor, date_timestamp, description, VAT_client) VALUES (:VAT, :date_timestamp, :description, :VAT_client)");
	$stmt->bindParam(':VAT', $VAT_doctor);
	$stmt->bindParam(':date_timestamp', $datestr);
	$stmt->bindParam(':description', $description);
	$stmt->bindParam(':VAT_client', $VAT_client);
	$nrows = $stmt->execute();

	if($nrows == 1) {
		echo("Success !");
	}
	else {
		echo("Error on insertion !");
	}

	?>
	<form action='clients.php' method='post'>
	<p><input type="hidden" name="VAT_client" value="<?=$_REQUEST['vat_client']?>"/></p>
	<p><input type="submit" value="Continue"/></p>
	<?php
	$connection = null;
?>
</body>
</html>
