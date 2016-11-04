<?php
	header("Access-Control-Allow-Origin: http://localhost:8000");
	
        $host = "localhost";
        $user = "X32672684"; //katherine's account
        $password = "X32672684";
        $dbc = mysql_connect($host, $user, $password);
        $dbname = "X32628221"; //jack's account
        @mysql_select_db($dbname) or die ('Cannot connect to database ' . mysql_error());

        //put checked array into variable
        $str = $_GET['str'];

	if(strlen($str) == 0)
                echo "No text was entered.";
        else{
		//prevent SQL injection
		$str = mysql_real_escape_string($str);

		//only search book title, author, and ISBN
		$q = "SELECT * FROM StockBook WHERE Title LIKE '%$str%' OR Author LIKE '%$str%' OR ISBN LIKE '%$str%'";
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
