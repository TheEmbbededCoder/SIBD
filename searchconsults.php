<html>
<head>
	<title>Search Available Doctors</title>
	<script>
		function goBack() {
		window.history.back()
	}
	</script>
</head>
<body>
	<h1>Search Available Doctors</h1>
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
	// Show the received client
	echo("<p><b>Date: </b>");
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
	$datestr = '"' . $date . " " . substr($time, 0, 2) . '"';
	$query = "SELECT VAT, name, specialization FROM doctor natural join employee WHERE VAT not in ( SELECT VAT_doctor FROM appointment WHERE date_timestamp = $datestr);";
	$result = $connection->query($query);
	if($result == FALSE) {
		$info = $connection->errorInfo();
		echo("<p>Error: {$info[2]}</p>");
		exit();
	}
	echo("<h3>Available Doctors:</h3>");
	echo("<p>press \"Make appointment\" to select the desired doctor:</p>");
	echo("<table border=\"1\">");
	echo("<tr><td>Name</td><td>Specialization</td></tr>");
	foreach($result as $row)
	{
		echo("<tr><td>");
		echo($row['name']);
		echo("</td><td>");
		echo($row['specialization']);
		echo("<td><a href=\"newappointment.php/?VAT_doctor=");
		echo($row['VAT']);
		echo("&VAT_client=");
        echo($VAT_client);
		echo("&date=");
        echo($date);
        echo("&time=");
        echo(substr($time, 0, 2));
		echo("\">Make appointment</a></td></tr>\n");
		echo("</td></tr>");
	}
	echo("</table>");
	
	$connection = null;
?>
<p> </p>
<button onclick="goBack()">Go Back</button>
<button><a href="../homepage.php">Homepage</button>
</body>
</html>