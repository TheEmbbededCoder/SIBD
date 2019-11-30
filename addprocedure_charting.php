<html>
<head>
	<?php
	echo("<title>Add procedure charting Information</title>");
		
	?>
	<script>
	function goBack() {
		window.history.back()
	}
	function goBack2() {
		window.history.go(-2)
	}
	</script>
</head>
<body>
	<?php
	echo("<h1>Add procedure charting Information</h1>");
	$host="db.ist.utl.pt";
	$user="ist425355";  
	$password="emyg3992";
	$dsn = "mysql:host=$host;dbname=$user";
	$dbname = $user;  

	// Try to connect to the database
	try {
		$connection = new PDO("mysql:host=" . $host. ";dbname=" . $dbname, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

	}
	catch(PDOException $exception) {
		echo("<p>Error: ");
		echo($exception->getMessage());
		echo("</p>");
		exit();
	}

	// Show the received client
	echo("<p><b>Client: </b>");
	// Gets the VAT of the selected client
	if(isset($_REQUEST['VAT_client'])) {
		$VAT_client = $_REQUEST['VAT_client'];
		echo("VAT: ");
		echo($VAT_client);
	}
	// Gets the VAT of the selected client
	if(isset($_REQUEST['Client_Name'])) {
		$Client_Name = $_REQUEST['Client_Name'];
		echo(" - Name: ");
		echo($Client_Name);
	}
	echo("</p>");

	// Show the received doctor
	echo("<p><b>Doctor: </b>");
	// Gets the VAT of the selected client
	if(isset($_REQUEST['VAT_doctor'])) {
		$VAT_doctor = $_REQUEST['VAT_doctor'];
		echo("VAT: ");
		echo($VAT_doctor);
	}
	echo("</p>");

	// Show the received appointment
	echo("<p><b>Appointment Date: </b>");
	// Gets the VAT of the selected client
	if(isset($_REQUEST['date_timestamp'])) {
		$date_timestamp = $_REQUEST['date_timestamp'];
		echo($date_timestamp);
	}
	// Gets the VAT of the selected client
	if(isset($_REQUEST['time'])) {
		$time = $_REQUEST['time'];
		echo(" at ");
		echo($time);
	}
	echo("</p>");

	$query = 'SELECT quadrant,number,description,measure FROM procedure_charting pc WHERE pc.date_timestamp=:date_timestamp AND pc.VAT=:VAT_doctor;'
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
			//No diagnosis found
		echo("<p>No dental procedures charting found.</p>");
		
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
		echo('<FORM METHOD="POST" ACTION="addprocedure_charting.php">');
		echo("<table border=\"1\">");
		echo("<tr><td>Quadrant</td><td>Number</td><td>Description</td><td>Measure</td></tr>");
		foreach ($result as $row) {
			echo("<tr><td>");
			echo($row['quadrant']);
			echo("</td>");
			echo("<td>");
			echo($row['number']);
			echo("</td>");
			echo("<td>");
			echo('<INPUT TYPE="TEXT" NAME="desc$i" SIZE="20">');
			echo("</td>");
			echo("<td>");
			echo('<INPUT TYPE="number" NAME="measure$i">');
			echo("</td></tr>");
			$i=$i+1;
		}
		echo("</table>");
		echo('<p><input type="submit" value="Submit"/></p>');
		echo("</FORM>");
			
	} else{

		echo('<FORM METHOD="POST" ACTION="addprocedure_charting.php">');
		echo("<table border=\"1\">");
		echo("<tr><td>Quadrant</td><td>Number</td><td>Description</td><td>Measure</td></tr>");
		foreach ($result as $row) {
			echo("<tr><td>");
			echo($row['quadrant']);
			echo("</td>");
			echo("<td>");
			echo($row['number']);
			echo("</td>");
			echo("<td>");
			echo($row['description']);
			echo("</td>");
			echo("<td>");
			echo($row['measure']);
			echo("</td></tr>");
		}
		echo("</table>");
		echo('<p><input type="submit" value="Submit"/></p>');
		echo("</FORM>");


	}
	echo("<button onclick=\"goBack()\">Go Back</button>");
	echo("<button><a href=\"../homepage.php\">Homepage</button>");

	$connection = null;
?>
</body>
</html>