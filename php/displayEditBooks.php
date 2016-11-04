<?php
	header("Access-Control-Allow-Origin: http://localhost:8000");

	$host = "localhost";
        $user = "X32672684"; //katherine's account
        $password = "X32672684";
        $dbc = mysql_connect($host, $user, $password);
        $dbname = "X32628221"; //jack's account
        @mysql_select_db($dbname) or die ('Cannot connect to database ' . mysql_error());

        //put submitted bookID in variable
        $book = $_GET['book'];

        //prevent SQL injection
        $book = mysql_real_escape_string($book);

	//query
	$q = "SELECT * FROM StockBook where Title LIKE \"%$book%\"";
	$result = mysql_query($q);
	$result2 = mysql_query($q);
	$book;

	if($found = mysql_fetch_array($result2) > 0){
                echo "<table class = \"cart\"><th class = \"cart\">Cover</th><th class = \"cart\">Book Title</th>";
                echo "<th class = \"cart\">Author</th><th class = \"cart\">Edit</th>";
                while($books = mysql_fetch_array($result)) {
                        $book = $books['BookID'];
                        echo "<tr><td class = \"cart\">";
                        echo "<img class = \"book\" src=\"";
                        echo $books['CoverImage'];
                        echo "\"</img>";
                        echo "</td><td class = \"cart\">";
                        echo $books['Title'];
                        echo "</td><td class = \"cart\">";
                        echo $books['Author'];
                        echo "</td><td class = \"cart\">";
                        echo "<button class = \"type1\" type = \"button\" value = \"Edit\" onclick = \"javascript:editForm($book)\">Edit</button>";
                        echo "</td></tr>";
                }
	}else
		echo "not found";

	//clear up
        mysql_free_result($result);
	mysql_close();
?>
