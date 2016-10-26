<?php
	$host = "localhost";
        $user = "X32672684"; //katherine's account
        $password = "X32672684";
        $dbc = mysql_connect($host, $user, $password);
        $dbname = "X32628221"; //jack's account
        @mysql_select_db($dbname) or die ('Cannot connect to database ' . mysql_error());

        //put checked array into variable
        $Cart = $_REQUEST['Cart'];
        $Cart = json_decode($Cart);
        $size = sizeof($Cart);

	//at least 1 book must be in the cart
        if($size == 0) {
		echo "<p class = \"text\">";
                echo "Cart is currently empty. Please add at least 1 book.";
		echo "</p>";
        }
	else {
		//query
		$q = "SELECT * from StockBook where BookID = ";
		$q2 = "OR BookID = ";
		$quote = "\"";

		//Ensure correct query string
	        for($i = 0; $i < $size; $i++) {
		 	if($i > 0) {
	                	$q .= $q2;
	                }
	                $book = $Cart[$i];
	                $q .= $quote;
	                $q .= $book;
	                $q .= $quote;
		}

		//return the result
		$result = mysql_query($q);

		//variables for total price and remove function
		$total = 0;
		$book;

		//display cart
		echo "<br />";
		echo "<table class = \"cart\"><th class = \"cart\">Cover</th><th class = \"cart\">Book Title</th>";
		echo "<th class = \"cart\">Author</th><th class = \"cart\">Form</th><th class = \"cart\">Type</th>";
		echo "<th class = \"cart\">Price</th><th class = \"cart\">Remove</th>";
		while($row=mysql_fetch_array($result)) {
			$book = $row['BookID'];
			echo "<tr><td class = \"cart\">";
			echo "<a href=\"javascript:getBookDetail('$book')\">";
			echo "<img src=\"";
	                echo $row['CoverImage'];
        	        echo "\"</img></a>";
			echo "</td><td class = \"cart\">";
			echo $row['Title'];
			echo "</td><td class = \"cart\">";
			echo $row['Author'];
			echo "</td><td class = \"cart\">";
			echo $row['Form'];
			echo "</td><td class = \"cart\">";
			echo $row['Type'];
			echo "</td><td class = \"cart\">";
			echo "\$";
			echo $row['Price'];
			echo "</td><td class = \"cart\">";
			echo "<button class = \"type1\" type = \"button\" value = \"Remove\" onclick = \"javascript:remove($book)\">Remove</button>";
			echo "</td></tr>";
			$total += $row['Price'];
		}
		echo "<tr><td></td><td></td><td></td><td></td>";
		echo "<td class = \"cart\">Total Price</td><td class = \"cart\">";
		echo "\$";
		echo $total;
		echo "</td><td class = \"cart\"><button class = \"type1\" type = \"button\" value = \"Purchase\" onclick = \"javascript:checkout($total)\">Purchase</button></td></tr>";
		echo "</table class = \"cart\">";
	}
?>
