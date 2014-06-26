var howOften = 5; //number often in seconds to rotate
var current = 0; //start the counter at 0
var ns6 = document.getElementById&&!document.all; //detect netscape 6

// Array of images, text, etc for the banners
var items = new Array();
    items[0]="<a href='http://itunes.com' ><img alt='image0 (9K)' src='FrontEnd/sources/img/banners/apple.jpg' border='0' /></a>"; //a linked image
    items[1]="<a href='http://youtube.com'><img alt='image1 (9K)' src='FrontEnd/sources/img/banners/youtube.gif' border='0' /></a>"; //a linked image
    items[2]="<a href='http://vimeo.com'><img alt='image2 (9K)' src='FrontEnd/sources/img/banners/vimeo.gif' border='0' /></a>"; //a linked image


/*  rotate between the array elements
* 	
*/
function rotater() {    
    if(ns6)document.getElementById("placeholderdiv").innerHTML=items[current]
        if(document.all)
            placeholderdiv.innerHTML=items[current];

    current = (current==items.length-1) ? 0 : current + 1; //increment or reset
    setTimeout("rotater()",howOften*1000);
}
window.onload=rotater;
//-->




/* The Code below works fine on file but when on local host it just doesnt display anything so it is not being used ..*/


//window.onload = initBannerLink;

var adImages = new Array("sources/img/banners/apple.jpg","sources/img/banners/youtube.gif","sources/img/banners/vimeo.gif");
var adURL = new Array("itunes.com","youtube.com","vimeo.com");
var thisAd = 0;

/*
Set Timer for rotation and change image source
*/
function rotate() {
	thisAd++;
	if (thisAd == adImages.length) {
		thisAd = 0;
	}
	document.getElementById("adBanner").src = adImages[thisAd];

	setTimeout("rotate()", 6 * 1000);
}
/*
Change the href of the link
*/
function newLocation() {
	document.location.href = "http://www." + adURL[thisAd];
	return false;
}
/*
Search the document for the tag with id adBanner and add the click url
*/
function initBannerLink() {
	if (document.getElementById("adBanner").parentNode.tagName == "A") {
		document.getElementById("adBanner").parentNode.onclick = newLocation;
	}
	
	rotate();
}