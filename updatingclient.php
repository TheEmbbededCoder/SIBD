<html>
<head>
	<title>Update Client</title>
</head>
	<body>
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

		$query = "UPDATE client SET birth_date = '$birth_date' WHERE VAT ='$VAT' AND name = '$name' ";
		$query1 = "UPDATE client SET age = '$age' WHERE VAT ='$VAT' AND name = '$name' ";
		$query2 = "UPDATE client SET street = '$street' WHERE VAT ='$VAT' AND name = '$name' ";
		$query3 = "UPDATE client SET city = '$city' WHERE VAT ='$VAT' AND name = '$name' ";
		$query4 = "UPDATE client SET zip = '$zip' WHERE VAT ='$VAT' AND name = '$name' ";
		$query5 = "UPDATE client SET gender = '$gender' WHERE VAT ='$VAT' AND name = '$name' ";

		$query6 = "UPDATE phone_number_client SET phone = '$phone' WHERE VAT ='$VAT' ";

		echo("<h3>The client will be updated.</h3>");

		$nrows = $connection->exec($query);
		$nrows1 = $connection->exec($query1);
		$nrows2 = $connection->exec($query2);
		$nrows3 = $connection->exec($query3);
		$nrows4 = $connection->exec($query4);
		$nrows5 = $connection->exec($query5);
		$nrows6 = $connection->exec($query6);

		if($nrows == 1 || $nrows1 == 1 || $nrows2 ==1 || $nrows3 == 1 || $nrows4 == 1 || $nrows5 == 1 || $nrows6 == 1 ) {
			echo "Values updated !";
		}
		else {
			echo "Client found, but no data changed";
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