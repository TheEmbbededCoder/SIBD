<html>
<head>
	<title>Updating Client</title>
	<script>
	function goBack() {
		window.history.back()
	}
	</script>
</head>
<body>
	<h1>Updating Client</h1>
	<p>Client with VAT = <?=$_REQUEST['VAT_client']?> and name = <?=$_REQUEST['Client_Name']?> will be updated</p>
	
	<form action='/ist425355/updatingclient.php' method='post'>
		<p><input type="hidden" name="vat" value="<?=$_REQUEST['VAT_client']?>"/></p>
		<p><input type="hidden" name="name"	value="<?=$_REQUEST['Client_Name']?>"/></p>
		<p>Birth Date: <input type='date' name='birth_date' required/></p>
		<p>Street: <input type='text' name='street' required/></p>
		<p>City: <input type='text' name='city' required/></p>
		<p>ZIP: <input type='text' name='zip' required/></p>
		<p>Gender: <select name="gender2">
			<option value="Female">Female</option>
			<option value="Male">Male</option>
			<option value="Other">Other</option>
		</select> </p>
		<p>CellPhone Number: <input type="tel" name="phone" pattern="[0-9]{9}" required/></p>
		<p><input type="submit" value="Submit"/></p>
	</form>
<button onclick="goBack()">Go Back</button>
<button><a href="../homepage.php">Homepage</button>
</body>
</html>