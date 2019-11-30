
DELIMITER $$
DROP trigger IF EXISTS `set_age` $$
CREATE TRIGGER set_age after INSERT ON appointment
for each row
BEGIN
	declare birth date;
	SELECT birth_date into birth FROM client c 
		WHERE c.VAT = new.VAT_client;
	UPDATE client		
	SET client.age = round(datediff(
			date(CURRENT_TIMESTAMP()), birth) / 365, 0)
	WHERE client.VAT = new.VAT_client;
END $$
DELIMITER ;
