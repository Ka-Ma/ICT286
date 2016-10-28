<?php
	$host = "localhost";
        $user = "X32672684"; //katherine's account
        $password = "X32672684";
        $dbc = mysql_connect($host, $user, $password);
        $dbname = "X32628221"; //jack's account
        @mysql_select_db($dbname) or die ('Cannot connect to database ' . mysql_error());

        //get variables
        $title = $_POST['title'];
        $au = $_POST['au'];
        $isbn = $_POST['isbn'];
        $syn = $_POST['syn'];
        $form = $_POST['form'];
        $pri = $_POST['pri'];
        $cov = $_POST['cov'];
        $type = $_POST['type'];
	$genre = $_POST['genre'];
	$genreCount = $_POST['len'];

	//prevent SQL injection
        $title = mysql_real_escape_string($title);
        $au = mysql_real_escape_string($au);
        $isbn = mysql_real_escape_string($isbn);
        $syn = mysql_real_escape_string($syn);
        $form = mysql_real_escape_string($form);
        $pri = mysql_real_escape_string($pri);
        $cov = mysql_real_escape_string($cov);
        $type = mysql_real_escape_string($type);

	//query to check that isbn doesn't match one already in database
	$q1 = "SELECT * FROM StockBook WHERE ISBN = '$isbn'";
	$q2 = "SELECT BookID From StockBook WHERE BookID = (SELECT MAX(BookID) FROM StockBook)";
        $result1 = mysql_query($q1);
	$result2 = mysql_query($q2);
        $stock=mysql_fetch_array($result1);

	//isbn not found
        if($stock['InStock'] == 0 ){
		$bookAdd = mysql_fetch_array($result2);
		$id = $bookAdd['BookID'];
		$id += 1;
		$Date = date("Y-m-d");
		$q3 = "INSERT INTO StockBook VALUES('$id', '$title', '$au', '$isbn', '$syn', '$form', '$pri', '$cov', '$type', '1', '$Date')";
		$result3 = mysql_query($q3);

		//add genres
		for($i = 0; $i < $genreCount; $i++){
			$gen = substr($genre, $i*8+$i, 8);
			$id = $bookAdd['BookID'];
			$id += 1;
			$q4 = "INSERT INTO BookGenre VALUES('$id', '$gen')";
			$result4 = mysql_query($q4);
		}
		echo "added";
        }
	//clear up
        mysql_free_result($result1);
	if($stock['InStock'] == 0 )
       		mysql_free_result($result2);
        mysql_close();
?>
