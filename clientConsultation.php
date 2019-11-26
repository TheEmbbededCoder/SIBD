<!DOCTYPE html>
<html>
<head>
	<title>Consults and Appointments</title>
</head>
<body>
	<h1>Consults and Appointments</h1>
	<?php
	$host="db.ist.utl.pt";
	$user="ist425362";	
	$password="txsq2828";
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

	// Show the received client
	echo("<p><b>Doctor - </b>");
	// Gets the VAT of the selected client
	if(isset($_REQUEST['VAT_doctor'])) {
		$VAT_doctor = $_REQUEST['VAT_doctor'];
		echo("VAT: ");
		echo($VAT_doctor);
	}
	// Gets the VAT of the selected client
	if(isset($_REQUEST['date_timestamp'])) {
		$date_timestamp = $_REQUEST['date_timestamp'];
		echo(" <b>date: </b>");
		echo($date_timestamp);
	}
	echo("</p>");


	//this is in the past
	//search consultations
	$query = 'SELECT * FROM consultation NATURAL JOIN consultation_assistant WHERE VAT_doctor = :VAT_doctor and date_timestamp=:date_timestamp;';
	$queryVariables = array();
	$queryVariables[':VAT_doctor'] = $VAT_doctor;
	$queryVariables[':date_timestamp'] = $date_timestamp;
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

    if ($sql->rowCount() == 0) {
		//No consult found
		echo("<p>No consultation found.</p>");
		echo("<p><a href=\"../clientConsultation.php/?VAT_doctor=");
		echo($VAT_doctor);
		echo("&date_timestamp=");
		echo($date_timestamp);
		echo("\">");
		echo("Create consultation</a></p>");
	}
	else {
		//display consultation info in table
		echo("<table border=\"1\">");
		echo("<tr><td>VAT_doctor</td><td>S</td><td>O</td><td>A</td><td>P</td><td>Nurse VAT</td></tr>");
		foreach ($result as $row) {
			echo("<tr><td>");
			echo($row['VAT_doctor']);
			echo("</td>");
			echo("<td>");
			echo($row['SOAP_S']);
			echo("</td>");
			echo("<td>");
			echo($row['SOAP_O']);
			echo("</td>");
			echo("<td>");
			echo($row['SOAP_A']);
			echo("</td>");
			echo("<td>");
			echo($row['SOAP_P']);
			echo("<td>");
			echo($row['VAT_nurse']);
			echo("</td></tr>");
		}
			
		echo("</table>");

		echo("<p><a href=\"../clientConsultation.php/?VAT_doctor=");
		echo($VAT_doctor);
		echo("&date_timestamp=");
		echo($date_timestamp);
		echo("\">");
		echo("Edit consultation</a></p>");
	}
	
	

	$connection = null;
	?>
