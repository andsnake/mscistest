window.onload = initBannerLink;

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