<html>
<head>
	<?php
	if(isset($_REQUEST['Edit'])) {
		$Edit = $_REQUEST['Edit'];
		if($Edit) {
			echo("<title>Edit Consult Information</title>");
		}
		else {
			echo("<title>Add Consult Information</title>");
		}
	}
	
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
	if(isset($_REQUEST['Edit'])) {
		$Edit = $_REQUEST['Edit'];
		if($Edit) {
			echo("<h1>Edit Consult Information</h1>");
		}
		else {
			echo("<h1>Add Consult Information</h1>");
		}
	}
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
	
	?>
	  <form action="#" method='post'>
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
	    <p><textarea type='text' style="width:250px;height:100px;" name='s' required></textarea></p>
	    <p>Objective:</p>
	    <p><textarea type='text' style="width:250px;height:100px;" name='o' required></textarea></p>
	    <p>Assessment:</p>
	    <p><textarea type='text' style="width:250px;height:100px;" name='a' required></textarea></p>
	    <p>Plan:</p>
	    <p><textarea type='text' style="width:250px;height:100px;" name='p' required></textarea></p>
		<p>Diagnosis:<br/>
	    <?php
	      $sql = "SELECT * FROM diagnostic_code";
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
	        echo("<input type='checkbox' name='diagnosis[]' value='$id'> $desc<br>");
	      }

	    if (empty($_POST['s'])) {
	    	echo("<p><input type=\"submit\" name=\"submit\" value=\"Submit\"/></p>");
		}
	    ?>
	    <input type="hidden" name="VAT_client" value="<?php echo($VAT_client);?>">
	    <input type="hidden" name="VAT_doctor" value="<?php echo($VAT_doctor);?>">
	    <input type="hidden" name="date_timestamp" value="<?php echo($date_timestamp);?>">
	    <input type="hidden" name="Client_Name" value="<?php echo($Client_Name);?>">
	    <input type="hidden" name="Edit" value="<?php echo($Edit);?>">
	  </form>

	  <?php

if (isset($_POST['submit']))//to run PHP script on submit
{	
	$Edit = $_POST['Edit'];
	$s = $_POST['s'];
	$o = $_POST['o'];
	$a = $_POST['a'];
	$p = $_POST['p'];
	$VAT_client = $_POST['VAT_client'];
	$VAT_doctor = $_POST['VAT_doctor'];
	$VAT_nurse = $_POST['VAT_nurse'];
	$date_timestamp = $_POST['date_timestamp'];
	if($Edit) {
		echo("<h3>Consultation Eddited</h3>");
		echo("<p>press Go Back to return.</p>");
		
		echo("<button onclick=\"goBack2()\">Go Back</button>");
		echo("<button><a href=\"../homepage.php\">Homepage</button>");

		// Insert consultation
		$sql = "UPDATE consultation SET SOAP_S = '$s', SOAP_O = '$o', SOAP_A = '$a', SOAP_P = '$p' WHERE VAT_doctor ='$VAT_doctor' AND date_timestamp = '$date_timestamp'";
		$nrows = $connection->exec($sql);
		if($nrows != 0) {
			echo("<p>Sucessfully changed consultation</p>");
		}

		// Insert consultation assistant
		$sql = "UPDATE consultation_assistant SET VAT_nurse = '$VAT_nurse' WHERE VAT_doctor ='$VAT_doctor' AND date_timestamp = '$date_timestamp'";
		$nrows = $connection->exec($sql);
		if($nrows != 0) {
			echo("<p>Sucessfully changed consultation assistant</p>");
		}

		if(!empty($_POST['diagnosis'])){
			echo("<p>Sucessfully added consultation diagnostic - ");
			// Loop to store and display values of individual checked checkbox.
			foreach($_POST['diagnosis'] as $selected){
				// Insert consultation assistant
				$sql = "INSERT INTO consultation_diagnostic VALUES ('$VAT_doctor', '$date_timestamp', '$selected')";
				$nrows = $connection->exec($sql);
				if($nrows != 0) {
					echo($selected);
					echo("</p>");
				}
			}
		}
	}
	else {
		echo("<h3>New Consultation Added</h3>");
		echo("<p>press Go Back to return.</p>");
		
		echo("<button onclick=\"goBack2()\">Go Back</button>");
		echo("<button><a href=\"../homepage.php\">Homepage</button>");

		// Insert consultation
		$sql = "INSERT INTO consultation VALUES ('$VAT_doctor', '$date_timestamp', '$s', '$o', '$a', '$p')";
		$nrows = $connection->exec($sql);
		if($nrows != 0) {
			echo("<p>Sucessfully added consultation</p>");
		}

		// Insert consultation assistant
		$sql = "INSERT INTO consultation_assistant VALUES ('$VAT_doctor', '$date_timestamp', '$VAT_nurse')";
		$nrows = $connection->exec($sql);
		if($nrows != 0) {
			echo("<p>Sucessfully added consultation assistant</p>");
		}

		if(!empty($_POST['diagnosis'])){
			echo("<p>Sucessfully added consultation diagnostic - ");
			// Loop to store and display values of individual checked checkbox.
			foreach($_POST['diagnosis'] as $selected){
				// Insert consultation assistant
				$sql = "INSERT INTO consultation_diagnostic VALUES ('$VAT_doctor', '$date_timestamp', '$VAT_nurse')";
				$nrows = $connection->exec($sql);
				if($nrows != 0) {
					echo($selected);
					echo("</p>");
				}
			}
		}
	}
	
}
else {
	echo("<button onclick=\"goBack()\">Go Back</button>");
	echo("<button><a href=\"../homepage.php\">Homepage</button>");
}

	$connection = null;
?>
</body>
</html>