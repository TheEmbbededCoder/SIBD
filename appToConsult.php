<html>
<head>
	<title>Add Consult Information</title>
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

	    if (!empty($_POST['s'])) {
	   		echo("<p><input type='submit' value='Edit'/></p>");
		}
	    else {
	    	echo("<p><input type='submit' value='Add'/></p>");
		}
	    ?>
	    <input type="hidden" name="VAT_client" value="<?php echo($VAT_client);?>">
	    <input type="hidden" name="VAT_doctor" value="<?php echo($VAT_doctor);?>">
	    <input type="hidden" name="date_timestamp" value="<?php echo($date_timestamp);?>">
	    <input type="hidden" name="Client_Name" value="<?php echo($Client_Name);?>">
	  </form>

	  <?php

if (!empty($_POST['s']))
{	
	$s = $_POST['s'];
	$o = $_POST['o'];
	$a = $_POST['a'];
	$p = $_POST['p'];
	echo("<h3>New Consultation Added</h3>");
	echo("<p>Fill the form again if you want to edit the consultation - Press Edit to confirm the changes.</p>");
	echo("<p>press Go Back to return.</p>");
	echo("<p>");
    echo($s);
    echo("<p></p>");
    echo($o);
    echo("<p></p>");
    echo($a);
    echo("<p></p>");
    echo($p);
    echo("<p></p>");
    echo($_POST['VAT_nurse']);
    echo("<p></p>");
    echo($_POST['VAT_client']);
    echo("<p></p>");
    echo($_POST['VAT_doctor']);
    echo("<p></p>");
    echo($_POST['date_timestamp']);
	echo("</p>");
	echo("<button onclick=\"goBack2()\">Go Back</button>");
	echo("<button><a href=\"../homepage.php\">Homepage</button>");

	$query1 = "INSERT INTO consultation VALUES (':VAT_doctor', ':date_timestamp', ':s', ':o', ':a', ':p');";
	$queryvariables = array([':VAT_doctor' => $VAT_doctor, 
							':date_timestamp' => $date_timestamp, 
							':s' => $s, 
							':o' => $o, 
							':a' => $a, 
							':p' => $p
							]);
	$sql = $connection->prepare($query1);
	echo("<p>");
	echo($sql);
	echo("</p>");
	if (!$sql->execute($queryvariables)) {
		$info = $connection->errorInfo();
		echo("<p>Error: {$info[2]}</p>");
		exit();
	}

	$query2 = "INSERT INTO consultation_assistant VALUES (':VAT_doctor', ':date_timestamp', ':VAT_nurse');";
	echo("<p>");
	echo($query2);
	echo("</p>");
	$queryvariables = array([':VAT_doctor' => $VAT_doctor, 
							':date_timestamp' => $date_timestamp, 
							':VAT_nurse' => $VAT_nurse]);
	$sql = $connection->prepare($query2);
	if (!$sql->execute($queryvariables)) {
		$info = $connection->errorInfo();
		echo("<p>Error: {$info[2]}</p>");
		exit();
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