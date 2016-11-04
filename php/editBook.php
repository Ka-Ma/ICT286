<?php
	header("Access-Control-Allow-Origin: http://localhost:8000");
	
	$host = "localhost";
        $user = "X32672684"; //katherine's account
        $password = "X32672684";
        $dbc = mysql_connect($host, $user, $password);
        $dbname = "X32628221"; //jack's account
        @mysql_select_db($dbname) or die ('Cannot connect to database ' . mysql_error());

        //get variables
	$id = $_GET['id'];
        $title = $_GET['title'];
        $au = $_GET['au'];
        $isbn = $_GET['isbn'];
        $syn = $_GET['syn'];
        $form = $_GET['form'];
        $pri = $_GET['price'];
        $cov = $_GET['cover'];
        $type = $_GET['type'];
	$qty = $_GET['qty'];
        $genres = $_GET['genres'];

	//put checked array into variable
        $genres = json_decode($genres);
        $size = sizeof($genres);

        //prevent SQL injection
        $id = mysql_real_escape_string($id);
        $title = mysql_real_escape_string($title);
        $au = mysql_real_escape_string($au);
        $isbn = mysql_real_escape_string($isbn);
        $syn = mysql_real_escape_string($syn);
        $form = mysql_real_escape_string($form);
        $pri = mysql_real_escape_string($pri);
        $cov = mysql_real_escape_string($cov);
        $type = mysql_real_escape_string($type);
	$qty  = mysql_real_escape_string($qty);

        //query - check that entered ISBN doesn't match that of another book
	$q1 = "SELECT BookID FROM StockBook WHERE ISBN = '$isbn'";
	$result1 = mysql_query($q1);
	$taken = mysql_fetch_array($result1);

	//edit book
	if($taken['BookID'] == $id || $taken == 0){
		$q2 = "UPDATE StockBook SET Title = '$title', Author = '$au', ISBN = '$isbn', Synopsis = '$syn', Form = '$form', Price = '$pri', CoverImage = '$cov', Type = '$type', InStock = '$qty' WHERE BookID = $id";
                $result2 = mysql_query($q2);

		//delete current genres, then add new ones
		$q3 = "DELETE FROM BookGenre WHERE BookID = $id";
		$result3 = mysql_query($q3);

		for($i=0;$i<$size;$i++){
			$q4 = "INSERT INTO BookGenre VALUES('$id', '$genres[$i]')";
			$result4 = mysql_query($q4);
		}
                echo "success";
	}
	//else entered ISBN matches another book's ISBN
	else{
		echo "error";
	}
	//clear up
	mysql_free_result($result1);
	mysql_close();
?>
