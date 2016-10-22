function loadNav() {
	document.getElementById("navigation").innerHTML = "<ul> <li><a href='javascript:loadHome()'>Home</a></li><li><a href='javascript:loadAboutUs()'>About Us</a></li><li><a href='javascript:loadSearch()'>Search</a></li><li><a href='javascript:loadCart()'>Cart</a></li><li style= 'float: right'><a href='javascript:loadLIR()'>Login/Register</a></li></ul>";
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

function loadAboutUs() {
	console.log("Loading about us");
	document.getElementById("aboutUs-page").innerHTML = "<p>I have loaded the About Us page</p>";
}
