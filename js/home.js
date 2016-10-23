function loadNav() {
	document.getElementById("navigation").innerHTML = "<ul> <li><a id='home' class='active' href='javascript:loadPage(\"home-page\")'>Home</a></li><li><a id='aboutUs' href='javascript:loadPage(\"aboutUs-page\")'>About Us</a></li><li><a id='search'  href='javascript:loadPage(\"search-page\")'>Search</a></li><li><a id='cart'  href='javascript:loadPage(\"cart-page\")'>Cart</a></li><li style= 'float: right'><a id='LIR'  href='javascript:loadPage(\"LIR-page\")'>Login/Register</a></li></ul>";
}

function carousel() {
    var i;
    var x = document.getElementsByClassName("coInfo");
    for (i = 0; i < x.length; i++) {
      x[i].style.display = "none"; 
    }
    slideIndex++;
    if (slideIndex > x.length) {slideIndex = 1} 
    x[slideIndex-1].style.display = "block"; 
    setTimeout(carousel, 3000); // Change image every 3 seconds
}

function loadPage(page) {
	//finding old div's id
	var oldDiv = document.getElementsByClassName("active");
	var oldDivID = oldDiv[0].getAttribute("id") + "-page";
	
	//make old div invisible
	document.getElementById(oldDivID).style.display = "none";
	
	//make this div visible
	document.getElementById(page).style.display = "block";
		
	//need to take -page off the end to updateActive
	page= page.slice(0, -5);
	updateActive(page);
}

function updateActive(current) {
	var oldPg = document.getElementsByClassName("active");
	var oldPgId = oldPg[0].getAttribute("id");
	var curPg = document.getElementById(current);
	
	document.getElementById(oldPgId).removeAttribute("class");
	curPg.setAttribute("class", "active");
}

function showBookOfWk(bookID) {
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function () {
		if (xhr.readyState == 4 && xhr.status == 200){
			var result = xhr.responseText;
			
			document.getElementById("bookOfWk").innerHTML = "<h1>Book of the Week</h1>" + result;
		}
	}
	xhr.open("GET", "php/getBook.php?bookID=" + bookID, true);
	xhr.send();
}

function showRecentBooks() {
	var date = new Date(); //today's date
	date.setDate(date.getDate() - 7); // set date to 7 days ago
	
	//convert date to string for sql
	var dM = date.getMonth() + 1;
	var dateSQL = date.getFullYear() +"-"+ dM +"-" + date.getDate();
			
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function () {
		if (xhr.readyState == 4 && xhr.status == 200) {
			var result = xhr.responseText;
			
			document.getElementById("recentBooks").innerHTML = "<h1>Recently Added Books</h1>"+result;
			delete date;
		}
	}
	xhr.open("GET", "php/getRecentBk.php?date=" + dateSQL, true);
	xhr.send();
}

function displayQuotes() {
    var i;
    var x = document.getElementsByClassName("aQuote");
    for (i = 0; i < x.length; i++) {
      x[i].style.display = "none"; 
    }
    quoteIndex++;
    if (quoteIndex > x.length) {quoteIndex = 1} 
    x[quoteIndex-1].style.display = "block"; 
    setTimeout(displayQuotes, 10000); // Change image every 10 seconds
}