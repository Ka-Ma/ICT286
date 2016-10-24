<?php
	$host = "localhost";
        $user = "X32672684"; //katherine's account
        $password = "X32672684";
        $dbc = mysql_connect($host, $user, $password);
        $dbname = "X32628221"; //jack's account
        @mysql_select_db($dbname) or die ('Cannot connect to database ' . mysql_error());

        //put submitted bookID in variable
        $username = $_GET['username'];
	$password = $_GET['password'];

        //prevent SQL injection
        $username = mysql_real_escape_string($username);
	$password = mysql_real_escape_string($password);

        //queries
        $q1 = "SELECT Username, Password FROM Registered WHERE Username = '$username' AND Password = '$password'";
	$q2 = "SELECT Staff.Username, StaffID from Staff, Registered where Staff.Username = Registered.Username and Staff.Username = '$username'";
	$q3 = "SELECT Customer.Username, CustID from Customer, Registered where Customer.Username = Registered.Username and Customer.Username = '$username'";
	$result1 = mysql_query($q1);
	$result2 = mysql_query($q2);
	$result3 = mysql_query($q3);

	//queries as arrays
	$user=mysql_fetch_array($result1);
	$staff = mysql_fetch_array($result2);
	$customer = mysql_fetch_array($result3);

	//if username AND password combination not found, display error
	if($user == 0) {
		echo "incorrect";
	}
	//check if staff member or customer
	else {
		if($staff) {
			//set StaffID and username as cookies
			$cookie_username = "username";
			$cookie_id = "id";
			$cookie_username_value = $staff["Username"];
			$cookie_id_value = $staff["StaffID"];
			setcookie($cookie_username, $cookie_username_value);
			setcookie($cookie_id, $cookie_id_value);
			echo"staff";
		}
		else {
			//setCustID and username as cookies
			$cookie_username = "username";
                        $cookie_id = "id";
			$cookie_username_value = $customer["Username"];
                        $cookie_id_value = $customer["CustID"];
                        setcookie($cookie_username, $cookie_username_value);
                        setcookie($cookie_id, $cookie_id_value);
			echo"customer";
		}
	}

	//clear up
	mysql_free_result($result1);
	mysql_free_result($result2);
	mysql_free_result($result3);
	mysql_close();
?>
