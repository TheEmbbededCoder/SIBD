<html>
<head>
	<title>Add Prescription</title>
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
	  <form action='addprescription.php' method='post'>
		<h3>Add new Prescription:</h3>
	    <p>Medicine:
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
			  $allmeds = $meds . "_" . $lab;
			  echo("<option value=\"$allmeds\">$meds - $lab</option>");
			}
			?>
		  </select>
		</p>
	    <p>Dosage:</p>
	    <p><textarea type='text' style="width:250px;height:100px;" name='dosage'></textarea></p>
		<p>Description:</p>
	    <p><textarea type='text' style="width:250px;height:100px;" name='description'></textarea></p>
	    <input type="hidden" id="custId" name="VAT_client" value="<?=$VAT_client?>">
	    <input type="hidden" id="custId" name="VAT_doctor" value="<?=$VAT_doctor?>">
	    <input type="hidden" id="custId" name="date" value="<?=$date?>">
	    <input type="hidden" id="custId" name="time" value="<?=$time?>">
		<p><input type='submit' value='Add'/></p>
	  </form>

	  <?php
	$connection = null;
?>

</body>
</html>
<?php
if (!empty($_POST['medication']))
{	
	echo("<h3>New Prescription Added</h3>");
	echo("<p>Fill the form to add one more prescription or press back to return</p>");
	echo("<p>");
    echo($_POST['medication']);
    echo("<p></p>");
    echo($_POST['dosage']);
    echo("<p></p>");
    echo($_POST['description']);
    echo("<p></p>");
    echo($_POST['VAT_client']);
    echo("<p></p>");
    echo($_POST['VAT_doctor']);
    echo("<p></p>");
    echo($_POST['date']);
    echo("<p></p>");
    echo($_POST['time']);
	echo("</p>");
}
?>