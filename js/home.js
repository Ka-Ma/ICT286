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

function loadHome() {
	console.log("Loading home page");
	//document.getElementById("home-page").innerHTML ="";
		
	updateActive("aboutUs");
}

function loadAboutUs() {
	console.log("Loading about us");
	/*document.getElementById("aboutUs-page").innerHTML = 
	"<p>Books Matters, Mann!</p>" +
	"<p>123 Pretend Street, Pretenderton, WA, 6210</p>" +
        "<p>Phone: 9123 8765</p>" +
	"<p>Email: <a href = \"mailto:admin@bmm.com.au\"> admin@bmm.com.au </a></p>" +
	"<p>Romeo and Juliette embraced their love of fiction and opened 'Books Matters, Mann!' in 1999, and it " + 
	"has been a family business ever since. Romeo and Juliette were both avid readers, seeking to read " +
	"as many books, from as wide a variety of genres as they could. After many years of fulfilling this dream, " +
	"they came up with another dream. To share the wonderful world of fiction with as many people as they " +
	"could. 17 years down the track and 'Books Matters, Mann!' is still fulfilling this dream. BMM is a small " +
	"business with a big heart. BMM provides homes for both new and used books. All of our used books are " +
	"traded to us by our loyal customers in exchange for credits, which they can use online or in store to " +
	"purchase from our wide range of books. We also stock new books from a variety of authors so that they " +
	"too may find a welcoming home. BMM is also a proud donator of used books to local schools, where " +
	"students of all ages may enjoy the stories they have to tell. For every 10 books that are purchased " +
	"from BMM, online or in store, we donate 1 used book. We have already donated over 4000 books to this " +
	"date. </p>";*/

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
