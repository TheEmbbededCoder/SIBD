
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



###### trigers 2a
DELIMITER $$
DROP trigger IF EXISTS `check_nurse` $$
CREATE TRIGGER check_nurse before INSERT ON nurse
for each row
BEGIN
	declare docCount integer;
	SELECT count(VAT) into docCount FROM doctor WHERE new.VAT = doctor.VAT;
	if docCount != 0 then
		SIGNAL SQLSTATE '02000' SET MESSAGE_TEXT = 'Warning: This person is a doctor!';
	end if;
END $$
DELIMITER ;

DELIMITER $$
DROP trigger IF EXISTS `check_receptionist` $$
CREATE TRIGGER check_receptionist before INSERT ON receptionist
for each row
BEGIN
	declare docCount integer;
	SELECT count(VAT) into docCount FROM doctor WHERE new.VAT = doctor.VAT;
	if docCount != 0 then
		SIGNAL SQLSTATE '02000' SET MESSAGE_TEXT = 'Warning: This person is a doctor!';
	end if;
END $$
DELIMITER ;

###### trigers 2b
DELIMITER $$
DROP trigger IF EXISTS `check_perm_doctor` $$
CREATE TRIGGER check_perm_doctor before INSERT ON permanent_doctor
for each row
BEGIN
	declare traineeCount integer;
	SELECT count(VAT) into traineeCount FROM trainee_doctor WHERE new.VAT = trainee_doctor.VAT;
	if traineeCount != 0 then
		SIGNAL SQLSTATE '02001' SET MESSAGE_TEXT = 'Warning: This person is a trainee doctor!';
	end if;
END $$
DELIMITER ;

DELIMITER $$
DROP trigger IF EXISTS `check_train_doctor` $$
CREATE TRIGGER check_train_doctor before INSERT ON trainee_doctor
for each row
BEGIN
	declare permCount integer;
	SELECT count(VAT) into permCount FROM permanent_doctor WHERE new.VAT = permanent_doctor.VAT;
	if permCount != 0 then
		SIGNAL SQLSTATE '02001' SET MESSAGE_TEXT = 'Warning: This person is a permanent doctor!';
	end if;
END $$
DELIMITER ;


#ponto 4

delimiter $$
DROP FUNCTION IF EXISTS `no_show_number`$$
CREATE FUNCTION no_show_number(gndr varchar(25), minAge integer, maxAge integer, y integer)
returns integer 
BEGIN 
    declare cntTotal integer;
    declare cntConsults integer;

    SELECT COUNT(a.VAT_doctor) INTO cntConsults
	FROM appointment a NATURAL JOIN consultation INNER JOIN client c ON a.VAT_client = c.VAT 
	WHERE date_timestamp < date(CURRENT_TIMESTAMP()) AND year(date_timestamp) = y
	AND c.gender = gndr AND age >= minAge AND age <= maxAge;

	SELECT COUNT(a.VAT_doctor) INTO cntTotal
	FROM appointment a INNER JOIN client c ON a.VAT_client = c.VAT 
	WHERE date_timestamp < date(CURRENT_TIMESTAMP()) AND year(date_timestamp) = y
	AND c.gender = gndr AND age >= minAge AND age <= maxAge;

	return cntTotal - cntConsults;
END $$
delimiter ;

/* Como usar função:
set @count = no_show_number('Mulher', 10, 70, 2019);
select @count;
*/

#ponto 5


delimiter $$
DROP PROCEDURE IF EXISTS `update_salaries`$$
CREATE PROCEDURE update_salaries(IN yrs integer)
BEGIN
  	UPDATE employee e, permanent_doctor d
	SET e.salary = e.salary * 1.1
	WHERE e.VAT = d.VAT and d.years > yrs and d.VAT IN (
		SELECT a.VAT_doctor from appointment a 
		GROUP BY a.VAT_doctor 
		HAVING COUNT(a.VAT_doctor) > 100
		);

	UPDATE employee e, permanent_doctor d
	SET e.salary = e.salary * 1.05
	WHERE e.VAT = d.VAT and d.years > yrs and d.VAT IN (
		SELECT a.VAT_doctor from appointment a 
		GROUP BY a.VAT_doctor 
		HAVING COUNT(a.VAT_doctor) <= 100
		);
END $$
delimiter ;

/*

VER SALÁRIOS E ANOS ANTES DO UPDATE: 
SELECT * from permanent_doctor natural join employee;

VERIFICAR QUAIS DOS DOUTORES TÊM MAIS DE 100 CONSULTAS:
SELECT a.VAT_doctor from appointment a 
		GROUP BY a.VAT_doctor 
		HAVING COUNT(a.VAT_doctor) > 100;

call update_salaries(x)

VER SALÁRIOS E ANOS DEPOIS DO UPDATE: 
SELECT * from permanent_doctor natural join employee;
VERIFICAR QUE FORAM MUDADOS OS SALÁRIOS DOS DOUTORES COM MAIS DO QUE x ANOS
E DE ACORDO COM O Nº DE CONSULTAS
*/






