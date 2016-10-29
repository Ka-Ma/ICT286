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
	$filename = array($_FILES['tifrontImage']["name"], $bi = $_FILES['tibackImage']["name"], $si = $_FILES['tispineImage']["name"], $pi = $_FILES['tipubInfoImage']["name"], $oi = $_FILES['tiotherImage']["name"]);
	$filetmpname = array($_FILES['tifrontImage']["tmp_name"], $bi = $_FILES['tibackImage']["tmp_name"], $si = $_FILES['tispineImage']["tmp_name"], $pi = $_FILES['tipubInfoImage']["tmp_name"], $oi = $_FILES['tiotherImage']["tmp_name"]);
	$filesize = array($_FILES['tifrontImage']["size"], $bi = $_FILES['tibackImage']["size"], $si = $_FILES['tispineImage']["size"], $pi = $_FILES['tipubInfoImage']["size"], $oi = $_FILES['tiotherImage']["size"]);
	$length = count($filename);
	$target_file = array();
		
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
	for ($i = 0; $i < $length; $i++){
		if ($filename[$i] != "")
		{
			$temp = $target_dir . $tiID . basename($filename[$i]);	
			array_push($target_file, $temp);
		
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file[$i],PATHINFO_EXTENSION);
			//real or fake
			if(isset($_POST["submit"])) {
				$check = getimagesize($filetmpname[$i]);
				if($check !== false) {
					echo "File is an image - " . $check["mime"] . ".";
					$uploadOk = 1;
				}else{
					echo "File is not an image.";
					$uploadOk=0;
				}
			}
			// Check file size
			if ($filesize[$i] > 100000) {  //100kb 
				echo "Sorry, your file is too large.";
				$uploadOk = 0;
			}
		
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			} else {	
				if (move_uploaded_file($filetmpname[$i], $target_file[$i])) {
					echo "The file ". basename($filename[$i]). " has been uploaded.";
				} else {
					echo "Sorry, there was an error uploading your file.";
				}
			}
		
			//for db paths
			$filename[$i] = "images/TradeIn/" . $tiID . $filename[$i];
		}
	}
	
	//query
	//add to TradeBook table
	$q2 = "INSERT INTO TradeBook VALUES ('$tiID', '$custID', '$date', 'new', '$title', '$author', '$isbn', '$desc', '$form', '$filename[0]', '$filename[1]', '$filename[2]', '$filename[3]', '$filename[4]')";
	$result2 = mysql_query($q2);
	
	echo $q2;
	
	if($result2)
	{
		echo "Request recorded";
	}
	else
	{
		echo "Something went wrong";
	}
	
	//clearing up
	mysql_free_result($result1);
	mysql_close();
?>