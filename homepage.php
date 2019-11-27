<html>
<head>
	<title>Dental Clinic</title>
</head>
<body>
  <form name="client_form" action="clients.php" method="post">
  	<h1>Dental Clinic</h1>
    <h2>Check client</h2>
    <p>If clients is not present on the database, press "List all clients" and fill the form to add client.</p>
    <p>VAT client: <input type="text" name="VAT_client" required/></p>
    <p>Client Name: <input type="text" name="client_name"/></p>
    <h4>Client Address</h4>
    <p>   Street: <input type="text" name="client_address_street" /></p>
    <p>   City: <input type="text" name="client_address_city" /></p>
    <p>   Zip-Code: <input type="text" name="client_address_zip" /></p>
    <input type="hidden" name="all" value="0">
    <p><input type="button" value="Submit" onclick="validateAndSend()"/></p>
  </form>
  <form action="clients.php" method="post">
    <input type="hidden" name="all" value="1">
    <p><input type="submit" value="List all clients"></p>
  </form>
  <script>
    function validateAndSend() {
      if (client_form.VAT_client.value != '' && client_form.client_name.value != '') {
          client_form.submit();
      }
      else if (client_form.VAT_client.value != '' && client_form.client_address_street.value != '') {
          client_form.submit();
      }
      else if (client_form.VAT_client.value != '' && client_form.client_address_city.value != '') {
          client_form.submit();
      }
      else if (client_form.VAT_client.value != '' && client_form.client_address_zip.value != '') {
          client_form.submit();
      }
      else {
          alert('You have to fill VAT and either the Client Name and/or the address.');
          return false;
        }
    }
  </script>
</body>
</html>