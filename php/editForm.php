<?php
	$host = "localhost";
        $user = "X32672684"; //katherine's account
        $password = "X32672684";
        $dbc = mysql_connect($host, $user, $password);
        $dbname = "X32628221"; //jack's account
        @mysql_select_db($dbname) or die ('Cannot connect to database ' . mysql_error());

        //put submitted bookID in variable
        $id = $_GET['id'];
	$ID = $id;

        //prevent SQL injection
        $id = mysql_real_escape_string($id);

	//query
	$q = "SELECT * FROM StockBook WHERE BookID = $id";
	$result = mysql_query($q);

	//get data
	$bookData = mysql_fetch_array($result);
	$title = $bookData['Title'];
	$author= $bookData['Author'];
	$isbn = $bookData['ISBN'];
	$synopsis = $bookData['Synopsis'];
	$form = $bookData['Form'];
	$price = $bookData['Price'];
	$cover = $bookData['CoverImage'];
	$type = $bookData['Type'];
	$qty = $bookData['InStock'];

	//display current data of book
	echo "<form id = \"formEdit\">";
	echo "<label> Title: </label><input type = \"text\" value = \"$title\" id = \"bookTitle\" name = \"bookTitle\" /><br />";
        echo "<label> Author: </label><input type = \"text\" value = \"$author\" id = \"bookAuthor\" name = \"bookAuthor\" /><br />";
        echo "<label> ISBN: </label><input type = \"text\" value = \"$isbn\" id = \"bookISBN\" name = \"bookISBN\" /><br />";
        echo "<label> Synopsis: </label><textarea id = \"bookSyn\" name = \"bookSyn\" cols = \"100\" rows = \"10\">$synopsis</textarea><br />";
        echo "<label> Form: </label><input type = \"text\" value = \"$form\" id = \"bookForm\" name = \"bookForm\" /><br />";
        echo "<label> Price: </label><input type = \"number\" value = \"$price\" id = \"bookPrice\" name = \"bookPrice\" /><br />";
        echo "<label> Cover Image: </label><input type = \"file\" id = \"bookCover\" name = \"bookCover\" accept = \"image/*\"/><br />";
        echo "<label> Type: </label><input type = \"text\" value = \"$type\" id = \"bookType\" name = \"bookType\" /><br />";
	echo "<label> In Stock: </label><input type = \"number\" value = \"$qty\" id = \"inStock\" name = \"inStock\"/><br /><br />";
	echo "<table><caption class = \"searchTable\" /><tbody><tr><td><label>Drama: <input type = \"checkbox\" value = \"11111111\" name = \"genre\" /></label>";
        echo "</td><td><label>Fantasy: <input type = \"checkbox\" value = \"11111112\" name = \"genre\" /></label></td><td>";
        echo "<label>Mystery: <input type = \"checkbox\" value = \"11111113\" name = \"genre\" /></label></td><td><label>Thriller: <input type = \"checkbox\" value = \"11111114\" name = \"genre\" /></label>";
        echo "</td><td><label>Bildungsroman: <input type = \"checkbox\" value = \"111111115\" name = \"genre2\" /></label></td></tr><tr><td>";
        echo "<label>Young Adult Fiction: <input type = \"checkbox\" value = \"11111116\" name = \"genre2\" /></label></td><td><label>Children's Fiction: <input type = \"checkbox\" value = \"11111117\" name = \"genre2\" /></label>";
        echo "</td><td><label>Adventure: <input type = \"checkbox\" value = \"11111118\" name = \"genre2\" /></label></td><td><label>Animals: <input type = \"checkbox\" value = \"11111119\" name = \"genre2\" /></label>";
        echo "</td><td><label>Humour: <input type = \"checkbox\" value = \"11111120\" name = \"genre2\" /></label></td></tr><tr><td><label>Classic: <input type = \"checkbox\" value = \"11111121\" name = \"genre2\" /></label>";
        echo "</td><td><label>Short Stories: <input type = \"checkbox\" value = \"11111122\" name = \"genre2\" /></label></td><td><label>Traditional: <input type = \"checkbox\" value = \"11111123\" name = \"genre2\" /></label>";
        echo "</td><td><label>Children's: <input type = \"checkbox\" value = \"11111124\" name = \"genre2\" /></label></td><td><label>Historical Fiction: <input type = \"checkbox\" value = \"11111125\" name = \"genre2\" /></label>";
        echo "</td></tr><tr><td><label>Philosophical Fiction: <input type = \"checkbox\" value = \"11111126\" name = \"genre2\" /></label></td><td>";
        echo "<label>Science Fiction: <input type = \"checkbox\" value = \"11111127\" name = \"genre2\" /></label></td><td><label>Romance: <input type = \"checkbox\" value = \"11111128\" name = \"genre2\" /></label>";
        echo "</td><td><label>Horror: <input type = \"checkbox\" value = \"11111129\" name = \"genre2\" /></label></td><td></td></tr></tbody></table><br />";
	echo "<button type = \"button\" onclick = \"javascript:editBook($ID)\"\">Edit Book</button>";
        echo "</form>";
?>
