<html>
<head>
	<title>Add Consult Information</title>
</head>
<body>
	<h1>Add Consult Information</h1>
	<?php
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
	if(isset($_REQUEST['VAT_client'])) {
		$VAT_client = $_REQUEST['VAT_doctor'];
		echo("VAT: ");
		echo($VAT_client);
	}
	echo("</p>");

	// Show the received appointment
	echo("<p><b>Appointment Date: </b>");
	// Gets the VAT of the selected client
	if(isset($_REQUEST['date'])) {
		$date = $_REQUEST['date'];
		echo($date);
	}
	// Gets the VAT of the selected client
	if(isset($_REQUEST['time'])) {
		$time = $_REQUEST['time'];
		echo(" at ");
		echo($time);
	}
	echo("</p>");
	
	?>
	  <p>The intersection of the 3 parameters is empty!</p>
	  <form action='addconsult.php' method='post'>
		<h3>Input the consult information:</h3>
		<p>VAT nurse:
			<select name="VAT_nurse">
			<?php
			$sql = "SELECT VAT FROM nurse ORDER BY VAT";
			$result = $connection->query($sql);
			if ($result == FALSE)
			{
			  $info = $connection->errorInfo();
			  echo("<p>Error: {$info[2]}</p>");
			  exit();
			}
			foreach($result as $row)
			{
			  $VAT_nurse = $row['VAT'];
			  echo("<option value=\"$VAT_nurse\">$VAT_nurse</option>");
			}
			?>
		  </select>
		</p>
		<p>Subjective:</p>
	    <p><textarea type='text' style="width:250px;height:100px;" name='s'></textarea></p>
	    <p>Objective:</p>
	    <p><textarea type='text' style="width:250px;height:100px;" name='o'></textarea></p>
	    <p>Assessment:</p>
	    <p><textarea type='text' style="width:250px;height:100px;" name='a'></textarea></p>
	    <p>Plan:</p>
	    <p><textarea type='text' style="width:250px;height:100px;" name='p'></textarea></p>
		<p>Diagnosis:<br/>
	    <?php
	      $sql = "SELECT * FROM diagnosis_code";
	      $result = $connection->query($sql);
	      if ($result == FALSE)
	      {
	        $info = $connection->errorInfo();
	        echo("<p>Error: {$info[2]}</p>");
	        exit();
	      }
	      foreach($result as $row)
	      {
	        $id = $row['ID'];
	        $desc = $row['description'];
	        echo("<input type='checkbox' name='diagnosis[]' value='$id'/>$description<br/>");
	      }
	    ?>
	    <p>Prescription:
			<select name="medication">
			<?php
			$sql = "SELECT * FROM medication ORDER BY name";
			$result = $connection->query($sql);
			if ($result == FALSE)
			{
			  $info = $connection->errorInfo();
			  echo("<p>Error: {$info[2]}</p>");
			  exit();
			}
			foreach($result as $row)
			{
			  $meds = $row['name'];
			  $lab = $row['lab'];
			  echo("<option value=\"$meds\">$meds - $lab</option>");
			}
			?>
		  </select>
		</p>
	    <p>Dosage:</p>
	    <p><textarea type='text' style="width:250px;height:100px;" name='dosage'></textarea></p>
		<p>Description:</p>
	    <p><textarea type='text' style="width:250px;height:100px;" name='description'></textarea></p>
		<p><input type='submit' value='Submit'/></p>
	  </form>

	  <?php
	$connection = null;
?>

</body>
</html>