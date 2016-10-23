function loadNav() {
	document.getElementById("navigation").innerHTML = "<ul> <li><a id='home' class='active' href='javascript:loadHome()'>Home</a></li><li><a id='aboutUs' href='javascript:loadAboutUs()'>About Us</a></li><li><a id='search'  href='javascript:loadSearch()'>Search</a></li><li><a id='cart'  href='javascript:loadCart()'>Cart</a></li><li style= 'float: right'><a id='login'  href='javascript:loadLIR()'>Login/Register</a></li></ul>";
}

function carousel(indx, classNm) {
	var slideIndex = indx;
    var i;
    var x = document.getElementsByClassName(classNm);
    for (i = 0; i < x.length; i++) {
      x[i].style.display = "none"; 
    }
    slideIndex++;
    if (slideIndex > x.length) {slideIndex = 1} 
    x[slideIndex-1].style.display = "block"; 
    setTimeout(carousel, 3000); // Change image every 3 seconds
}

function loadAboutUs() {
	console.log("Loading about us");
	document.getElementById("aboutUs-page").innerHTML = "<p>I have loaded the About Us page</p>";
	
	updateActive("aboutUs");
}

function updateActive(current) {
	var oldPg = document.getElementsByClassName("active");
	var oldPgId = oldPg[0].getAttribute("id");
	var curPg = document.getElementById(current);
	
	console.log(oldPg);
	console.log(oldPgId);
		
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
	console.log("readyState after creation: "+xhr.readyState);
	xhr.onreadystatechange = function () {
		console.log("readystate = " + xhr.readyState);
		if (xhr.readyState == 4 && xhr.status == 200) {
			var result = xhr.responseText;
			
			document.getElementById("recentBooks").innerHTML = "<h1>Recently Added Books</h1>"+result;
			delete date;
		}
	}
	xhr.open("GET", "php/getRecentBk.php?date=" + dateSQL, true);
	xhr.send();
}