<html>
<head>
	<title>Add Prescription</title>
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
	<h1>Add Prescription</h1>
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
	if(isset($_REQUEST['VAT_doctor'])) {
		$VAT_doctor = $_REQUEST['VAT_doctor'];
		echo("VAT: ");
		echo($VAT_doctor);
	}
	echo("</p>");

	// Show the received appointment
	echo("<p><b>Consultation Date: </b>");
	// Gets the VAT of the selected client
	if(isset($_REQUEST['date_timestamp'])) {
		$date_timestamp = $_REQUEST['date_timestamp'];
		echo($date_timestamp);
	}
	echo("</p>");
	
	?>
	  <form action='#' method='post'>
		<h3>Add new Procedure:</h3>
	    <p>Procedure Name:
			<select name="procedure">
			<?php
			$sql = "SELECT * FROM _procedure ORDER BY name";
			$result = $connection->query($sql);
			if ($result == FALSE)
			{
			  $info = $connection->errorInfo();
			  echo("<p>Error: {$info[2]}</p>");
			  exit();
			}
			foreach($result as $row)
			{
			  $name = $row['name'];
			  $type = $row['type'];
			  echo("<option  name=\"$name\" value=\"$name\">$name</option>");
			}
			?>
		  </select>
		</p>
		<p>Description:</p>
	    <p><textarea type='text' style="width:250px;height:100px;" name='description' required></textarea></p>
	    <input type="hidden" name="VAT_client" value="<?=$VAT_client?>">
	    <input type="hidden" name="VAT_doctor" value="<?=$VAT_doctor?>">
	    <input type="hidden" name="date_timestamp" value="<?=$date_timestamp?>">
		<?php
	    if (empty($_POST['dosage'])) {
	    	echo("<p><input type=\"submit\" name=\"add\" value=\"Submit\"/></p>");
		}
		?>
	  </form>

	  <?php

if (isset($_POST['add']))//to run PHP script on submit
{	
	$name = $_POST['procedure'];
	$description = $_POST['description'];
	$VAT_client = $_POST['VAT_client'];
	$VAT_doctor = $_POST['VAT_doctor'];
	$date_timestamp = $_POST['date_timestamp'];
	echo("<h3>New Procedure Added</h3>");
	
	// Insert _procedure
	$sql = "INSERT INTO procedure_in_consultation VALUES ('$name', '$VAT_doctor', '$date_timestamp', '$description')";
	$nrows = $connection->exec($sql);
	if($nrows != 0) {
		echo("<p>Sucessfully added procedure!</p>");
	}

	echo("<button onclick=\"goBack2()\">Go Back</button>");
	echo("<button><a href=\"../homepage.php\">Homepage</button>");
}

else {
	echo("<button onclick=\"goBack()\">Go Back</button>");
	echo("<button><a href=\"../homepage.php\">Homepage</button>");
}

	$connection = null;
?>
</body>
</html>