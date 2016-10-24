//for banner
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

//to make div's visibile/hidden
function loadPage(page) {
	//finding old div's id
	var oldDiv = document.getElementsByClassName("active");
	var oldDivID = oldDiv[0].getAttribute("id") + "-page";
	
	//make old div invisible
	document.getElementById(oldDivID).style.display = "none";
	//incase it's the book-page
	document.getElementById("book-page").style.display = "none";
	
	//make this div visible
	document.getElementById(page).style.display = "block";
		
	//need to take -page off the end to updateActive
	page= page.slice(0, -5);
	updateActive(page);
}

//to change the background color of navbar link to be current page
function updateActive(current) {
	var oldPg = document.getElementsByClassName("active");
	var oldPgId = oldPg[0].getAttribute("id");
	var curPg = document.getElementById(current);
	
	document.getElementById(oldPgId).removeAttribute("class");
	curPg.setAttribute("class", "active");
}

//***** start functions for home page *****
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
//***** end functions for home page *****

//***** start functions for book-page *****
function getBookDetail(bookID) {
	//finding old div's id
	var oldDiv = document.getElementsByClassName("active");
	var oldDivID = oldDiv[0].getAttribute("id") + "-page";
	
	//make old div invisible
	document.getElementById(oldDivID).style.display = "none";
	//need to make a backBtn to oldDivID
	var backBtn = "<button type='button' onclick='javascript:loadPage("+oldDivID+")'>Continue Browsing</button>";
	
	//make this div visible
	document.getElementById("book-page").style.display = "block";
	
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function () {
		if (xhr.readyState == 4 && xhr.status == 200) {
			var result = xhr.responseText;
			
			document.getElementById("book-page").innerHTML = result + backBtn;
		}
	}
	xhr.open("GET", "php/getBookDetail.php?bookID=" + bookID, true);
	xhr.send();
}
//***** end functions for book-page *****

//***** start functions for trade-in page *****
function validateTradeIn() {
	console.log("children need to be tucked in");
	//fields required title, author, isbn, photos of front, back, spine & pubinfo
	//files must be smaller than 100kb
	//description but be less than x chars long
	
}
//***** end functions for trade-in page *****

//***** start function for cart *****
function addCart(bookID){
	console.log("i added the book, " + bookID + ", to the cart, yay me");
	//stub so my links don't break stuff
}

function login(username, password) {
	var staffMember = "staff";
	var cust = "customer";	
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function () {
		if(xhr.readyState == 4 && xhr.status == 200) {
			var result = xhr.responseText;
//			document.writeln(result);
			//display error if incorrect data
			document.getElementById("logFail").innerHTML = "Incorrect Username or Password.";
			
			//signed in as a customer
			if(result == "customer"){
				document.getElementById("logFail").innerHTML = "Successfully logged in as Customer.";
				console.log("in user if statement");
                		//navbar button visibility
                		document.getElementById("tradeIn").style.display="block";
        		        document.getElementById("account").style.display="block";
						document.getElementById("LO").style.display="block";
		                document.getElementById("LIR").style.display="none";
			}
			//signed in as a staff member
			if(result == "staff"){
				document.getElementById("logFail").innerHTML = "Successfully logged in as Staff.";
				console.log("in staff if statement");
                                //navbar button visibility
                                document.getElementById("tradeIn").style.display="block";
                                document.getElementById("AED").style.display="block";
                                document.getElementById("account").style.display="block";
								document.getElementById("LO").style.display="block";
                                document.getElementById("LIR").style.display="none";

                                //page parts visibility (add staff elements to account & trade in pages)
			}
		}
	}
	xhr.open("GET", "php/login.php?username="+username+"&password="+password, true);
	xhr.send();
}
