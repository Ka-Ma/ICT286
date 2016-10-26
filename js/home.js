//global array for cart
var Cart = [];

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
	var backBtn = "<button type='button' onclick='javascript:loadPage(\""+oldDivID+"\")'>Continue Browsing</button>";
	
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
//function validateTradeIn(tititle, tiauthor, tiisbn, tiform, tidesc, tifrontImage, tibackImage, tispineImage, tipubInfoImage, tiotherImage) {
function validateTradeIn(formObj) {
	var t = formObj[0].value; //tititle;
	var a = formObj[1].value; //tiauthor;
	var i = formObj[2].value; //tiisbn;
	var f = formObj[3].value; //tiform;
	var d = formObj[4].value; //tidesc;
	var fi = formObj[5].value; //tifrontImage;
	var bi = formObj[6].value; //tibackImage;
	var si = formObj[7].value; //tispineImage;
	var pi = formObj[8].value; //tipubInfoImage;
	var oi = formObj[9].value; //tiotherImage;
	
	console.log("validate trade in: title "+t);
	
	//fields required: title, author, isbn, photos of front, back, spine & pubinfo
	if (t=="" || a=="" || i=="" || fi=="" || bi=="" || si=="" || pi=="")
	{ 
		alert("Title, Author, ISBN, and images for front, back, spine and publication information are required");
		return false;
	}
	//files must be smaller than 100kb
	else if (checkFileSize(fi)||checkFileSize(bi)||checkFileSize(si)||checkFileSize(pi)||checkFileSize(oi))
	{
		alert("File size too large, must be less than 100kb");
		return false;
	}
	//submit to db
	else 
	{
		console.log("children need to be tucked in");
		
	}
	
	
	
}

function checkFileSize(file) {
	var oFile = document.getElementById(file).files[0]; 
	if (oFile.size > 100000) //100kb
	{
		return true;
	}
}

function viewImage(image) {
	//get value from file field
	var imageLink = document.getElementsByName(image).value; //undefined?
	
	console.log(image);
	console.log(imageLink);
	
	document.getElementById(image).src = imageLink;
}
//***** end functions for trade-in page *****

//***** start functions for account page *****
function getAccountDetailsByStored() {
	var username = sessionStorage.username;  
	var id = sessionStorage.id;  
	
	console.log("username = "+username);
	console.log("id = "+id);
	
	getAccountInfo(username, id);
}

function getAccountInfo(cUsername, cId) {
	var username = cUsername; // customer username
	var id = cId;  //customer id
	
	console.log("username = "+username);
	console.log("id = "+id);
	
	var xhr= new XMLHttpRequest();
	xhr.onreadystatechange = function () {
		if(xhr.readyState = 4 && xhr.status == 200) {
			var result = xhr.responseText.split("^");
			
			document.getElementById("accDetails").innerHTML = result[0];
			document.getElementById("aWelcome").innerHTML = result[1];
			sessionStorage.forChecking = result[2];
			
			console.log("forchecking "+result[2]);
			
			sessionStorage.balance = result[3];
			
			console.log("balance "+result[3]);
		
		}
	}
	xhr.open("GET", "php/getAccountDetails.php?username="+username+"&id="+id, true);
	xhr.send();
}

function validateAccDetsChange(formObj) {
	var st = formObj[0].value;
	var sub = formObj[1].value;
	var state = formObj[2].value;
	var pc = formObj[3].value;
	var ph = formObj[4].value;
	var e = formObj[5].value;
	
	console.log("validating Account Details change ");
	
	//if any null discontinue
	if(st==""||sub==""||state==""||pc==""||ph==""||e=="")
	{
		alert("All fields must be complete");
	}
	else {
		updateAccountDetails(sessionStorage.username, st, sub, state, pc, ph, e);
	}
}

function updateAccountDetails(username, st, sub, state, pc, ph, e) {
		
	var xhr= new XMLHttpRequest();

	xhr.onreadystatechange = function () {
		if(xhr.readyState = 4 && xhr.status == 200) {
			var result = xhr.responseText;
			
			console.log(result);
			document.getElementById("accUpdated").innerHTML = result;
		}
	}
	
	xhr.open("GET", "php/updateAccountDetails.php?username="+username+"&st="+st+"&sub="+sub+"&state="+state+"&pc="+pc+"&ph="+ph+"&e="+e, true);
	xhr.send();
}

function validatePasswordChange(formObj) {
	var oPW = formObj[0].value;
	var nPW = formObj[1].value;
	var nPWA = formObj[2].value;
	
	console.log(formObj);
	console.log(formObj[0].value);
	console.log(formObj[1].value);
	console.log(formObj[2].value);

	console.log("will be comparing "+oPW+" to "+sessionStorage.forChecking);
	
	if(oPW != sessionStorage.forChecking)
	{
		alert("If you have forgotten your password please contact our friendly staff during office hours");
	}
	else if (nPW==oPW) //failed attempt
	{
		alert("Please choose a new password");
	}
	else if (nPW != nPWA) 
	{
		alert("Please make sure the two new passwords are the same");
	}
	else //success, update db
	{
		updatePWD(nPW);
	}
	
}

function updatePWD(nPwd) {
	var nPwd = nPwd;
	
	var xhr= new XMLHttpRequest();
	xhr.onreadystatechange = function () {
		if(xhr.readyState = 4 && xhr.status == 200) {
		var result = xhr.responseText;
		
		document.getElementById("passwordChange").innerHTML = result;
		}
	}
	xhr.open("GET", "php/updatePwd.php?nPwd="+nPwd+"&username="+sessionStorage.username, true);
	xhr.send();
}
//***** end functions for account page *****

//***** start function for cart *****
//checks to see if book is in stock.
//if yes, add to and update cart count, else display error message working on it
function addCart(bookID){
	//check that book is in stock
	var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
                if(xhr.readyState == 4 && xhr.status == 200) {
                        var result = xhr.responseText;

			//add book to cart if in stock
			if(result == "inStock") {
				 console.log("Book added");

			        //make sure bookID is integer
			        var number = parseInt(bookID);

			        //add book to cart if not already in there
			        if(Cart.indexOf(number) == -1)
                			Cart.push(number);

        			//get number of books in cart and display in header
        			var num = Cart.length;

        			if(Cart.length == 0) {
        			        document.getElementById("cart").innerHTML = "Cart";
        			}
        			else {
        			        document.getElementById("cart").innerHTML = "Cart (" + num + ")";
        			}
			}
			//display error message if out of stock
			else {
				console.log("out of stock");
				alert("Book is currently out of stock. We apologize for the inconvenience");
			}
                }
        }
        xhr.open("GET", "php/inStock.php?bookID=" + bookID, true);
        xhr.send();
}

function clearCart() {
	//clear cart count on screen
	document.getElementById("cart").innerHTML = "Cart";

	//reduce book quantity by 1 for each book in cart
	var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
                if(xhr.readyState == 4 && xhr.status == 200) {
		}
	}
	xhr.open("GET", "php/bookSold.php?Cart=" + JSON.stringify(Cart), true);
        xhr.send();

	//clear the cart
	while(Cart.length)
		Cart.pop();
}

function remove(bookID) {
	//make sure bookID is an integer
	var number = parseInt(bookID);
	
	//find index of book to remove, remove it
	var index = Cart.indexOf(number);
	Cart.splice(index, 1);
	
	//get number of books in cart and display in header
        var num = Cart.length;

        if(Cart.length == 0) {
                document.getElementById("cart").innerHTML = "Cart";
        }
        else {
                document.getElementById("cart").innerHTML = "Cart (" + num + ")";
        }
	
	//redisplay the cart
	displayCart();
}

function displayCart() {
	console.log("Viewing cart");

	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function () {
		if(xhr.readyState == 4 && xhr.status == 200) {
                        var result = xhr.responseText;
			document.getElementById("showCart").innerHTML = result;
		}
	}
	xhr.open("GET", "php/showCart.php?Cart=" + JSON.stringify(Cart), true);
        xhr.send();
}

//shows checkout/purchase page
function checkout(totalPrice) {
	//remove any previous notifications
        document.getElementById("payError").innerHTML = "";

	//finding old div's id
        var oldDiv = document.getElementsByClassName("active");
        var oldDivID = oldDiv[0].getAttribute("id") + "-page";
        //make old div invisible
        document.getElementById(oldDivID).style.display = "none";

        //make this div visible
	document.getElementById("purchase-page").style.display = "block";
	
	document.getElementById("payForm").innerHTML = "Total price = $" + totalPrice;
}

//handles the payment form
//checks for correct input before processing
function purchase() {
	var error = "Error!<br />"
	var err;
	var success = "Payment Successful!";

	//ensure a card has been selected
	var card = document.getElementById("purchasing").method;
	var cardSelect;

	for (var i=0;i<card.length; i++) {
		if (card[i].checked) {
			cardSelect = card[i].value;
			break;
		}
	} 

	//add to error message if card not selected
	if(cardSelect == undefined){
		err = "Please select a Payment Method <br />";
		error = error.concat(err);
	}

	//check all text fields
	var fname = document.getElementById("purchasing").fName.value;
	var lname = document.getElementById("purchasing").lName.value;

	if(fname.length == 0){
		err = "Please input a First Name <br />";
                error = error.concat(err);
	}
	if(lname.length == 0){
		err = "Please input a Last Name <br />";
                error = error.concat(err);
        }

	//check card details (crad must = 16 digits, CVV must = 3 digits)
	var card = document.getElementById("purchasing").cardNum.value;
        var cvv = document.getElementById("purchasing").cvv.value;
	if(card.toString().length !== 16) {
		err = "Please input a valid Card Number <br />";
                error = error.concat(err);
	}
	if(cvv.toString().length !== 3){
		err = "Please input a valid CVV <br />";
                error = error.concat(err);
	}	

	//expiration must be => current date
	var date = new Date();
	var day = date.getDate();
	var month = date.getMonth();
	var year = date.getFullYear();
	var index;
	var cardDay = document.getElementById("purchasing").expDay;
	var cardMonth = document.getElementById("purchasing").expMonth;
	var cardYear = document.getElementById("purchasing").expYear;

	index = cardYear.selectedIndex;
	var y = cardYear.options[index].text;
	if(y > year){}//do nothing
	else{
		index = cardMonth.selectedIndex;
                if(index > month+1) {}//do nothing
                else {
			index = cardDay.selectedIndex;
                        if(index < day-1){
                                err = "Please input a valid expiration date <br />";
                                error = error.concat(err);
                        }
                }
	}

	//show errors or success message and navigate back to home page
	if(error.length > 12)//initial size of error
		document.getElementById("payError").innerHTML = error;
	else{
		alert(success);

		//call function to remove 1 quantity of each book just purchased, and clear cart
		clearCart();

		//clear form for next time
		document.getElementById("purchasing").reset();

	        //make old div invisible
	        document.getElementById("purchase-page").style.display = "none";

	        //navigate to home page after delay
	        document.getElementById("home-page").style.display = "block";
		updateActive("home");
	}
}

//login as a staff or customer
function login(username, password) {
	var staffMember = "staff";
	var cust = "customer";	
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function () {
		if(xhr.readyState == 4 && xhr.status == 200) {
			var result = xhr.responseText;
			//display error if incorrect data
			document.getElementById("logFail").innerHTML = "Incorrect Username or Password.";
			
			//return user (customer or staff), username, and ID
			var comma = result.search(",");
			var user = result.substr(0,comma);
			var id = result.substr(comma+1, 8);
			var name = result.substr(comma+10);

			//set session storage
			sessionStorage.setItem('username', name);
			sessionStorage.setItem('id', id);

			//signed in as a customer
			if(user == "customer"){
				document.getElementById("logFail").innerHTML = "Successfully logged in as Customer.";
				console.log("in user if statement");
                		//navbar button visibility
                		document.getElementById("tradeIn").style.display="block";
        		        document.getElementById("account").style.display="block";
						document.getElementById("LO").style.display="block";
		                document.getElementById("LIR").style.display="none";
						
						//page functions & visibility
						//accounts page
						getAccountDetailsByStored();
			}
			//signed in as a staff member
			if(user == "staff"){
				document.getElementById("logFail").innerHTML = "Successfully logged in as Staff.";
				console.log("in staff if statement");
                                //navbar button visibility
                                document.getElementById("tradeIn").style.display="block";
                                document.getElementById("AED").style.display="block";
                                document.getElementById("account").style.display="block";
								document.getElementById("LO").style.display="block";
                                document.getElementById("LIR").style.display="none";

                                //page parts visibility (add staff elements to account & trade in pages)
								//accounts page
								document.getElementById("accSearch").style.display="block";
								document.getElementById("updateCB").style.display="block";
			}
		}
	}
	xhr.open("GET", "php/login.php?username="+username+"&password="+password, true);
	xhr.send();
}

//search for books (genres[0] - genres[18] [19 genres])
function search() {
	
	//find which genres were checked
	var genre;
	var genres = document.getElementById("SearchForm").elements;
	var checked = [];
	//document.writeln(checked);
	for (var i = 0; i < genres.length; i++) {
		if(genres[i].checked) {
			//add checked genres to array
			genre = genres[i].value;
			checked.push(genre);
		}
	}

	//get books with checked genres from database and display them
	var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
                if(xhr.readyState == 4 && xhr.status == 200) {
			var result = xhr.responseText;
			document.getElementById("searchBooks").innerHTML = result;
		}
	}
	xhr.open("GET", "php/search.php?checked=" + JSON.stringify(checked), true);
	xhr.send();
}
