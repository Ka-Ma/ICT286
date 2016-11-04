<?php
	header("Access-Control-Allow-Origin: http://localhost:8000");
	
	//put submitted in variables
	$custE = $_GET['tiCustE'];
	$sbj = $_GET['sbj'];
	$msg = $_GET['msg'];
			
	// use wordwrap() if lines are longer than 70 characters
	//$msg = wordwrap($msg,70);
	
	// send email
	mail($custE,$sbj,$msg);
	
	echo "<p>Mail Sent</p>";
?>