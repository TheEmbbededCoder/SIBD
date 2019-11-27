<html>
<head>
	<title>Information about Consultation</title>
	<script>
		function goBack() {
		window.history.back()
	}
	</script>
</head>
<body>
	<h1>Information about Consultation</h1>
	<p>Doctor with VAT = <?=$_REQUEST['VAT_doctor']?> is available.</p>
	<p>Date Consultation is <?=$_REQUEST['date']?> at <?=$_REQUEST['time']?> o'clock</p>
	<p>Client with VAT = <?=$_REQUEST['VAT_client']?></p>
	<form action='../insertappointment.php' method='post'>
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
<button onclick="goBack()">Go Back</button>
<button><a href="../homepage.php">Homepage</button>
</body>
</html>