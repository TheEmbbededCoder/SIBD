<html>
<head>
	<title>Client Insertion</title>
</head>
<body>
	<h1>Client Insertion</h1>
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

	$VAT = $_REQUEST['vat'];
	$name = $_REQUEST['name'];

	$birth_date = $_REQUEST['birth_date'];
	$time=strtotime($birth_date);
	$year=date("Y",$time);
	$month=date("m",$time);
	$day=date("d",$time);


	$dateActual = date("Y-m-d");
	$time=strtotime($dateActual);
	$yearActual = date("Y",$time);
	$monthActual=date("m",$time);
	$dayActual=date("d",$time);

	if($monthActual > $month){
		$age = $yearActual - $year;
	}
	elseif($monthActual < $month){
		$age = $yearActual - $year - 1;
	}
	elseif($monthActual == $month){
		if($dayActual>=$day){
			$age = $yearActual - $year;
		}
		else{
			$age = $yearActual - $year - 1;
		}
	}

	$street = $_REQUEST['street'];
	$city = $_REQUEST['city'];
	$zip = $_REQUEST['zip'];
	$gender = $_REQUEST['gender2'];
	$phone = $_REQUEST['phone'];

	echo("<p>New client being inserted.</p>");
	try {
		$stmt = $connection->prepare("INSERT INTO client (VAT, name, birth_date, street, city, zip, gender, age) VALUES (:VAT, :name, :birth_date, :street, :city, :zip, :gender, :age)");
		$stmt->bindParam(':VAT', $VAT);
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':birth_date', $birth_date);
		$stmt->bindParam(':street', $street);
		$stmt->bindParam(':city', $city);
		$stmt->bindParam(':zip', $zip);
		$stmt->bindParam(':gender', $gender);
		$stmt->bindParam(':age', $age);
		$nrows = $stmt->execute();
		
		$stmt = $connection->prepare("INSERT INTO phone_number_client (VAT, phone) VALUES (:VAT, :phone)");
		$stmt->bindParam(':VAT', $VAT);
		$stmt->bindParam(':phone', $phone);
		$nrows1 = $stmt->execute();

		if($nrows == 0 || $nrows1 == 0) {
			echo "Error ! - Client already exist with given VAT";
		}
		else {
			echo "Success !";
		}
	}
	catch(Exception $exception) {
		echo 'Caught exception: ',  $exception->getMessage(), "\n";
	}

	?>
	<form action='clients.php' method='post'>
		<p><input type="hidden" name="VAT_client" value="<?=$_REQUEST['vat']?>"/></p>
		<p><input type="hidden" name="client_name" value="<?=$_REQUEST['name']?>"/></p>
		<p><input type="submit" value="Continue"/></p>
	</form>
	<?php
	$connection = null;
	?>
</body>
</html>
