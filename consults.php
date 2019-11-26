<!DOCTYPE html>
<html>
<head>
	<title>Consults and Appointments</title>
</head>
<body>
	<h1>Consults and Appointments</h1>
	<?php
	$host="db.ist.utl.pt";
	$user="ist425355";	
	$password="emyg3992";
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
	echo("<p><b>Client - </b>");
	// Gets the VAT of the selected client
	if(isset($_REQUEST['VAT_client'])) {
		$VAT_client = $_REQUEST['VAT_client'];
		echo("VAT: ");
		echo($VAT_client);
	}
	// Gets the VAT of the selected client
	if(isset($_REQUEST['Client_Name'])) {
		$Client_Name = $_REQUEST['Client_Name'];
		echo(" Name: ");
		echo($Client_Name);
	}
	echo("</p>");
	$query = "SELECT * FROM appointment WHERE VAT_client = :VAT_client ORDER BY date_timestamp;";
    $queryVariables = array();
	$queryVariables[':VAT_client'] = $VAT_client;
	$sql = $connection->prepare($query);
	if(!$sql->execute($queryVariables)){
		$info = $connection->errorInfo();
		echo("<p>Error: {$info[2]}</p>");
		exit();
	}
	$result=$sql->fetchAll();
	if($result == 0) {
        $info = $sqls->errorInfo();
        echo("<p>Error: {$info[2]}</p>");
        exit();
    }
    $nrows = $sql->rowCount();
    if ($nrows == 0) {
        echo("<p>There are no appointments for this client.</p>");
    } 
	else {
		echo("<table border=\"1\">");
		echo("<tr><td>Appointment/Consultation Date</td><td>Doctor</td></tr>");
		foreach($result as $row) {
			echo("<tr><td><a href=\"../clientAppointment.php/?VAT_doctor=");
			echo($row['VAT_doctor']);
			echo("&date_timestamp=");
			echo($row['date_timestamp']);
			echo("\">");
			echo($row['date_timestamp']);
			echo("</a></td>");
			echo("<td>");
			echo($row['VAT_doctor']);
			echo("</td></tr>");
		}
		echo("</table>");
	}
	?>
	<form action="/ist425305/searchconsults.php" method="post">
		<h1>New Appointments</h1>
		<p>Date: <input type='date' name='date' required/></p>
		<p>Time: <input type='time' name='time' min="09:00" max="17:00" required/></p>
		<input type="hidden" name="VAT_client" value="<?php echo $VAT_client;?>"/>
		<input type="hidden" name="Client_Name" value="<?php echo $Client_Name;?>"/>
		<p><input type="submit" value="Search"/></p>
	</form>
	<?php
	$connection = null;
?>
</body>
</html>