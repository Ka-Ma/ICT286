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

        //query
        $q1 = "SELECT Username, Password FROM Registered WHERE Username = '$username' AND Password = '$password'";
	$q2 = "SELECT Staff.Username from Staff, Registered where Staff.Username = Registered.Username and Staff.Username = '$username'";
	$result1 = mysql_query($q1);
	$result2 = mysql_query($q2);

	//if username AND password combination not found, display error
	if($user=mysql_fetch_array($result1) == 0) {
		echo "incorrect";
	}
	//check if staff member or customer
	else {
		if($staff = mysql_fetch_array($result2)) {
		$staff = "staff";
			echo"staff";
//                header("location: ../home.html");
		}
		else {
			echo"customer";
		}
	}

	//clear up
	mysql_free_result($result1);
	mysql_free_result($result2);
	mysql_close();
?>
