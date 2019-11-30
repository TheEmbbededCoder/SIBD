<html>
<head>
	<title>Procedure Charting Inserted</title>
	<script>
	function goBack() {
		window.history.back()
	}
	</script>
</head>
<body>
	<h1>Procedure Charting Inserted</h1>
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
	$Client_Name = $_REQUEST['Client_Name'];
	echo "$Client_Name";

	$name = 'Dental Charting';
	echo "$name";

	$VAT_doctor = $_REQUEST['VAT_doctor'];
	echo "$VAT_doctor";

	$date_timestamp = $_REQUEST['date_timestamp'];
	echo "$date_timestamp";

	

	$query = 'SELECT * FROM teeth;';
	$queryVariables = array();
	$sql = $connection->prepare($query);
	if(!$sql->execute($queryVariables)){
		$info = $connection->errorInfo();
		echo("<p>Error: {$info[2]}</p>");
		exit();
	}

	$result=$sql->fetchAll();

	if($result == 0) {
	    $info = $sql->errorInfo();
	    echo("<p>Error: {$info[2]}</p>");
	    exit();
	}

	$i = 0;
	foreach ($result as $row) {
		if($_REQUEST['desc$i'] != null){
			echo "entrei $i";
			$quadrant = $_REQUEST['quadrant'];

			$number = $_REQUEST['number'];

			$measure = $_REQUEST['measure$i'];

			$description = $_REQUEST['desc$i'];

			$query = "INSERT INTO procedure_charting VALUES ('$name', '$VAT_doctor', '$date_timestamp', '$quadrant', '$number', '$description', '$measure')";

			$nrows = $connection->exec($query);
			echo "$nrows";
		}
	}

	echo("<p>Will be inserted a procedure charting.</p>");

	echo("Success !");
?>
	<!--VER ISTOOOOO-->
	<form action='/ist425305/add_procedure_charting.php/?VAT_doctor=$VAT_doctor&date_timestamp=$date_timestamp&VAT_client=$VAT_client&Client_Name=$Client_Name' method='post'>
	<p><input type="hidden" name="VAT_client"
		value="<?=$_REQUEST['vat_client']?>"/></p>
	<p><input type="submit" value="Continue"/></p>
	
	<?php

	$connection = null;
?>
</body>
</html>
