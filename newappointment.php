<html>
<head>
	<title>Information about Consultation</title>
</head>
<body>
	<h1>Information about Consultation</h1>
	<h2>Doctor with VAT = <?=$_REQUEST['VAT_doctor']?> is available. Date Consultation is <?=$_REQUEST['date']?> at <?=$_REQUEST['time']?> o'clock for the client with VAT = <?=$_REQUEST['VAT_client']?> </h2>
	<form action='/ist425305/insertappointment.php' method='post'>
	<p><input type="hidden" name="vat_doctor"
			value="<?=$_REQUEST['VAT_doctor']?>"/></p>
	<p><input type="hidden" name="date"
			value="<?=$_REQUEST['date']?>"/></p>
	<p><input type="hidden" name="time"
			value="<?=$_REQUEST['time']?>"/></p>
	<p><input type="hidden" name="vat_client"
			value="<?=$_REQUEST['VAT_client']?>"/></p>
	<p>Description: <input type='text' style="width:500px;height:50px;" name='description' required/></p>
	<p><input type="submit" value="Submit"/></p>
	<?php

	$connection = null;
?>

</body>
</html>