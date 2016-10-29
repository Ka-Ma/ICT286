<?php
	$host = "localhost";
	$user = "X32672684"; //katherine's account
	$password = "X32672684";
	$dbc = mysql_connect($host, $user, $password);
	$dbname = "X32628221"; //jack's account
	@mysql_select_db($dbname) or die ('Cannot connect to database ' . mysql_error());
	
	//put submitted in variables
	$custID = $_POST['CustID'];
	$title = $_POST['tititle'];
	$author = $_POST['tiauthor'];
	$isbn = $_POST['tiisbn'];
	$form = $_POST['tiform'];
	$desc = $_POST['tidesc'];
	$fi = $_FILES['tifrontImage']["name"];
	$bi = $_FILES['tibackImage']["name"];
	$si = $_FILES['tispineImage']["name"];
	$pi = $_FILES['tipubInfoImage']["name"];
	$oi = $_FILES['tiotherImage']["name"];
	
	var_dump($fi);
	
	//other variables
	$date = date("Y-m-d");
		
	//prevent SQL injection
	$custID = mysql_real_escape_string($custID);
	$title = mysql_real_escape_string($title);
	$author = mysql_real_escape_string($author);
	$isbn = mysql_real_escape_string($isbn);
	$desc = mysql_real_escape_string($desc);
	
	
	//query
	//what is next tiID
	$q1 = "SELECT MAX(TradeBookID) AS last FROM TradeBook";
	$result1 = mysql_query($q1);
	$tiID = mysql_fetch_array($result1)['last']+1;
	
	
	//set up for image upload  (upload stuff borrowed from w3schools (eventually after much drama))
	//directory being saved to "images/TradeIn/" . 
	$target_dir = "../images/TradeIn/";
	//files being uploaded
	$target_file1 = $target_dir . $tiID . basename($_FILES["tifrontImage"]["name"]);	
	$target_file2 = $target_dir . $tiID . basename($_FILES["tibackImage"]["name"]);
	$target_file3 = $target_dir . $tiID . basename($_FILES["tispineImage"]["name"]);
	$target_file4 = $target_dir . $tiID . basename($_FILES["tipubInfoImage"]["name"]);
	if($oi != "")
	$target_file5 = $target_dir . $tiID . basename($_FILES["tiotherImage"]["name"]);

	$uploadOk = 1;
	$imageFileType = pathinfo($target_file1,PATHINFO_EXTENSION);
	//real or fake
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["tifrontImage"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		}else{
			echo "File is not an image.";
			$uploadOk=0;
		}
	}
	// Check file size
	if ($_FILES["tifrontImage"]["size"] > 100000) {  //100kb 
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
	}
	
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {	
		if (move_uploaded_file($_FILES["tifrontImage"]["tmp_name"], $target_file1)) {
			echo "The file ". basename( $_FILES["tifrontImage"]["name"]). " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}
	
	//for db paths
	$fi = "images/TradeIn/" . $tiID . $fi;
	$bi = "images/TradeIn/" . $tiID . $bi;
	$si = "images/TradeIn/" . $tiID . $si;
	$pi = "images/TradeIn/" . $tiID . $pi;
	if($oi != "")
		$oi = "images/TradeIn/" . $tiID . $oi;
	
	//query
	//add to TradeBook table
	$q2 = "INSERT INTO TradeBook VALUES ('$tiID', '$custID', '$date', 'new', '$title', '$author', '$isbn', '$desc', '$form', '$fi', '$bi', '$si', '$pi', '$oi')";
	$result2 = mysql_query($q2);
	
	echo $q2;
	
	if($result2)
	{
		echo "Request recorded";
	}
	else
	{
		echo "something went wrong";
	}
	
	//clearing up
	mysql_free_result($result1);
	mysql_close();
?>