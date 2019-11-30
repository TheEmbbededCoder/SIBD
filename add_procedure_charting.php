<html>
<head>
	<?php
	echo("<title>Procedure charting Information</title>");
		
	?>
	<script>
	function goBack() {
		window.history.back()
	}
	function goBack2() {
		window.history.go(-1)
	}
	</script>
</head>
<body>
	<?php
	echo("<h1>Procedure charting Information</h1>");
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

	if (isset($_POST['submit']))//to run PHP script on submit
	{	
		$Client_Name = $_REQUEST['Client_Name'];

		$name = 'Dental Charting';

		$VAT_doctor = $_REQUEST['VAT_doctor'];

		$date_timestamp = $_REQUEST['date_timestamp'];

		$quadrant1 = 'Lower Left';
		$quadrant2 = 'Lower Right';
		$quadrant3 = 'Upper Left';
		$quadrant4 = 'Upper Right';

		$i=0;
		for($k=1; $k<5; $k++){
			for($j=1; $j<9; $j++){

				$number = $j;
				$measure = $_REQUEST["measure$i"];
				$description = $_REQUEST["desc$i"];
				if($k==1){
					$query = "INSERT INTO procedure_charting VALUES ('$name', '$VAT_doctor', '$date_timestamp', '$quadrant1', '$number', '$description', '$measure')";
				}
				elseif($k==2){
					$query = "INSERT INTO procedure_charting VALUES ('$name', '$VAT_doctor', '$date_timestamp', '$quadrant2', '$number', '$description', '$measure')";
				}
				elseif($k==3){
					$query = "INSERT INTO procedure_charting VALUES ('$name', '$VAT_doctor', '$date_timestamp', '$quadrant3', '$number', '$description', '$measure')";
				}
				elseif ($k==4){
					$query = "INSERT INTO procedure_charting VALUES ('$name', '$VAT_doctor', '$date_timestamp', '$quadrant4', '$number', '$description', '$measure')";
				}
				$i=$i+1;
				$nrows = $connection->exec($query);
			}
		}

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

	$query = 'SELECT quadrant,number,description,measure FROM procedure_charting pc WHERE pc.date_timestamp=:date_timestamp AND pc.VAT=:VAT_doctor;';
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

		?>

		<form action='#' method='post'>
		<p><input type="hidden" name="VAT_doctor" value="<?=$_REQUEST['VAT_doctor']?>"/></p>
		<p><input type="hidden" name="date_timestamp"	value="<?=$_REQUEST['date_timestamp']?>"/></p>
		<p><input type="hidden" name="Client_Name"	value="<?=$_REQUEST['Client_Name']?>"/></p>
		<p><input type="hidden" name="VAT_client"	value="<?=$_REQUEST['VAT_client']?>"/></p>
		<?php
		$i = 0;
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
			echo("<INPUT TYPE='TEXT' NAME='desc$i' SIZE='20' REQUIRED>");
			echo("</td>");
			echo("<td>");
			echo("<INPUT TYPE='number' NAME='measure$i' REQUIRED>");
			echo("</td></tr>");
			$i=$i+1;
		}
		echo("</table>");
		?>
		<p><input type="submit" value="Submit" name="submit"/></p>
		</form>

		<?php
			
	} else{

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

	}
	echo("<button onclick=\"goBack2()\">Go Back</button>");
	echo("<button><a href=\"../homepage.php\">Homepage</button>");
	$connection = null;
?>
</body>
</html>