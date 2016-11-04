<?php
header("Access-Control-Allow-Origin: http://localhost:8000");

	$host = "localhost";
        $user = "X32672684"; //katherine's account
        $password = "X32672684";
        $dbc = mysql_connect($host, $user, $password);
        $dbname = "X32628221"; //jack's account
        @mysql_select_db($dbname) or die ('Cannot connect to database ' . mysql_error());

        //put checked array into variable
        $checked = $_REQUEST['checked'];
	$checked = json_decode($checked);
	$size = sizeof($checked);
	
	//at least 1 genre must be selected
	if($size == 0)
		echo "Please select at least 1 genre.";
	else {
		//queries
		$q = "SELECT StockBook.*, Genre FROM StockBook, BookGenre, Genre WHERE StockBook.BookID = BookGenre.BookID AND BookGenre.GenreID = Genre.GenreID AND Genre = ";
		$q2 = "(SELECT BookID from BookGenre, Genre where BookGenre.GenreID = Genre.GenreID AND Genre = ";
		$and = " AND BookGenre.BookID in ";
		$quote = "\"";
		$bracket = ")";

		//Ensure correct query string
		for($i = 0; $i < $size; $i++) {
			if($i > 0) {
				$q .= $and;
				$q .= $q2;
			}

			$genre = $checked[$i];
			$q .= $quote;
			$q .= $genre;
			$q .= $quote;
		}
		//add ending brackets
		for($i = 1; $i < $size; $i++)
			$q .= $bracket;

		//get results from query
		$result = mysql_query($q);

		//returning books with ALL selected genre's
		$column = 4;
		$mod = 0;
	        echo "<table class = \"search\">";
		echo "<th class = \"search\" /><th class = \"search\" /><th class = \"search\" /><th class = \"search\" /><tr class = \"search\">";
	        while ($row=mysql_fetch_array($result)) {
			$bookID = $row["BookID"];
			if($mod % $column == 0)
	                	echo "</tr><tr class = \"search\">";
	                echo "<td class = \"search\">";
			echo "<p class = \"bookSearch\">";
			echo $row['Title'];
			echo "</p>";
			echo "<a href=\"javascript:getBookDetail('$bookID')\">";
	                echo "<img class = \"book\" src=\"";
			echo  $row['CoverImage'];
	                echo "\"</img></a></br>";
	                echo "<button type='button' onclick=\"javascript:addCart('$bookID')\">Add to Cart</button></td>";
	                echo "</td>";
			$mod++;
	        }
	        echo "</tr></table>";

	        //clearing up
	        mysql_free_result($result);
        	mysql_close();
	}
?>
