<?php
	header("Access-Control-Allow-Origin: http://localhost:8000");
	
	$host = "localhost";
        $user = "X32672684"; //katherine's account
        $password = "X32672684";
        $dbc = mysql_connect($host, $user, $password);
        $dbname = "X32628221"; //jack's account
        @mysql_select_db($dbname) or die ('Cannot connect to database ' . mysql_error());

	//get variables
	$un = $_POST['un'];
	$pw = $_POST['pw'];
	$fn = $_POST['fn'];
	$ln = $_POST['ln'];
	$str = $_POST['str'];
	$sub = $_POST['sub'];
	$sta = $_POST['sta'];
	$pc = $_POST['pc'];
	$em = $_POST['em'];
	$ph = $_POST['ph'];

	//prevent SQL injection
	$un = mysql_real_escape_string($un);
	$pw = mysql_real_escape_string($pw);
	$fn = mysql_real_escape_string($fn);
	$ln = mysql_real_escape_string($ln);
        $str = mysql_real_escape_string($str);
        $sub = mysql_real_escape_string($sub);
        $sta = mysql_real_escape_string($sta);
        $pc = mysql_real_escape_string($pc);
        $em = mysql_real_escape_string($em);
        $ph = mysql_real_escape_string($ph);

	//queries
	$q1 = "SELECT Username FROM Registered WHERE Username = '$un'";
	$q2 = "INSERT INTO Registered VALUES('$un', '$fn', '$ln', '$str', '$sub', '$sta', '$pc', '$ph', '$em', '$pw')";
	$q3 = "SELECT count(*) From Customer";
	$result1 = mysql_query($q1);
	$result3 = mysql_query($q3);
	$exist = mysql_fetch_array($result1);

	//add user to database
	if($exist == 0){
		//add to Registered
		$result2 = mysql_query($q2);

		//add to Customer
		$custAdd = mysql_fetch_array($result3);
		$id = $custAdd['count(*)'];
		$id += 11111111;
		$q4 = "INSERT INTO Customer VALUES('$id', '$un', '0.00')";
		$result4 = mysql_query($q4);

		echo "Successfully registered!";
	}
	else{ //username taken, show error
		echo "taken";
	}
	//clear up
        mysql_free_result($result1);
        mysql_free_result($result3);
        mysql_close();

?>
