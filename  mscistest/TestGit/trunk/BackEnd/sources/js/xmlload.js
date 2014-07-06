// JavaScript Document
var xnlObject;
var Connect = GetXmlHttpObject();
var temp_description;

//create the xmlHTTPRequest Object to read the xml file
function GetXmlHttpObject(){
	var xmlHttp=null;
	try
  {
  	// Firefox, Opera 8.0+, Safari
  	xmlHttp=new XMLHttpRequest();
  }
	catch (e)
  {
  	// Internet Explorer
  	try
    {
    	xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
  	catch (e)
    {
    	xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
	return xmlHttp;
}

function openFile(){
	var error=false;
	try{
		Connect.open("GET", "xml/products.xml", false);
		Connect.setRequestHeader("Content-Type", "text/xml");
		Connect.send(null);
		if( (Connect.readyState!=4) || (Connect.status=="404")) {
			throw new exception();
		}		
	}catch(exception){
		//alert(error);
		error= true;
	}
	return error;	
	
}


/*
*  Reads from xml file using ajax and loads it's contents
*/
function preload(){	
	if(openFile()!=true){
		
		// Place the response in an XML document.
	  	var TheDocument = Connect.responseXML;
		// Place the root node in an element.
		var Products = TheDocument.childNodes[0];
		var str;
		for (var i = 0; i < Products.children.length; i++){
		   var list= Products.children[i];
		  
		   // Access each of the data values.
		   var title = list.getElementsByTagName("title");
		   var img = list.getElementsByTagName("image");
		   var description = list.getElementsByTagName("description");
		   var price = list.getElementsByTagName("price");	
		   	  var temp="'"+title[0].textContent.toString()+"'";
		   
		   str='<div class="row" style=" border-style:dashed; border-width:1px; border-color:black;">'+
			  '<div class="col-md-3" id="'+title[0].textContent.toString()+'-title">'+title[0].textContent.toString()+'</div>'+
			  '<div class="col-md-4" id="'+title[0].textContent.toString()+'-description">'+description[0].textContent.toString()+'</div>'+
			  /*'<div class="col-md-2">'+price[0].textContent.toString()+'</div>'+*/
			  '<div class="col-md-1" id="'+title[0].textContent.toString()+'-img"><img class="img-circle" data-src="holder.js/70x70" alt="140x140"  style="width: 70px; height: 70px;" src="'+img[0].textContent.toString()+'"></div>'+
			  '<div class="col-md-2"><button type="button" class="btn btn-info btn-xs" onClick="edit('+temp+')"><span class="glyphicon glyphicon-pencil"></span> Edit</button> <button type="button" class="btn btn-danger btn-xs" onClick="deleteProduct('+temp+')"><span class="glyphicon glyphicon-remove"></span> Delete</button></div>'+
			'</div>';
			document.getElementById('productlist').innerHTML += str;
		   
	  	}//end for
		
	}//end if
	
	
}//end preload()

//shows the selected element
function show(fs){	
	if(fs!=null){
		var button=document.getElementById("f_button");		
		var str= ' <p id="upload" name="upload" class="btn btn-primary" onClick="addProduct()">Προσθήκη</p>';
		button.innerHTML=str;
		
	}
	document.getElementById("productForm").style.visibility="visible";
}

//add a product to DOM
function addProduct(){
	var imgFile = document.getElementById('image');
	var mainDiv=document.getElementById("productlist");
	//alert(imgFile.name);
	//return false;
	var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png"];
	var blnValid = false; 
	
	// filter for image files
    var rFilter = /^(image\/bmp|image\/gif|image\/jpeg|image\/png|image\/tiff)$/i;
    if (! rFilter.test(imgFile.files[0].type)) {
		alert("invalid file type");        
        blnValid=false;
    }
	else blnValid=true;
	
	
	if (imgFile.files && imgFile.files[0] && blnValid==true) {
		var width;
		var height;
		var fileSize;
		var reader = new FileReader();
		reader.onload = function(event) {
			var dataUri = event.target.result,
			img = document.createElement("img");
			img.src = dataUri;
			width = img.width;
			height = img.height;
			fileSize = imgFile.files[0].size;
			
	   };
	  
	   reader.onerror = function(event) {
		   console.error("File could not be read! Code " + event.target.error.code);
	   };
	   reader.readAsDataURL(imgFile.files[0]);
	   //title is a unigue identifier for each product
	   var title=new Date().getTime().toString();
	   var image=document.getElementById("image");	
	   var description=document.getElementById("description").value;	
	   var img_src=image.value.split(/[\\/]/).pop();
	   var temp="'"+title.toString()+"'";
	   
	   var element = str='<div class="row" style=" border-style:dashed; border-width:1px; border-color:black;">'+
			  '<div class="col-md-3" id="'+title+'-title">'+title.toString()+'</div>'+
			  '<div class="col-md-4" id="'+title+'-description">'+description.toString()+'</div>'+
			  /*'<div class="col-md-2">'+price[0].textContent.toString()+'</div>'+*/
			  '<div class="col-md-1"  id="'+title+'-img"><img class="img-circle" data-src="holder.js/70x70" alt="140x140"  style="width: 100px; height: 100px;" src="'+img_src+'"></div>'+
			  '<div class="col-md-2"><button type="button" class="btn btn-info btn-xs" onClick="edit('+temp+')"><span class="glyphicon glyphicon-pencil"></span> Edit</button> <button type="button" class="btn btn-danger btn-xs" onClick="deleteProduct('+temp+')"><span class="glyphicon glyphicon-remove"></span> Delete</button></div>'+
			'</div>';
	   document.getElementById('productlist').innerHTML += str;
	  
 
	}
	
}
//get values from DOM and change them
function edit(element){
	var t=document.getElementById(element+"-title");
	var d=document.getElementById(element+"-description");
	var img=document.getElementById(element+"-img");
	var button=document.getElementById("f_button");
	var id="'"+element+"'";
	var str= ' <p id="upload" name="upload" class="btn btn-primary" onClick="save('+id+')">Ενημέρωση</p>';
	button.innerHTML=str;
	//alert (t.innerText+"\n"+d.innerText+"\n"+img.getElementsByTagName('img')[0].src+"\n");
	changeFormValues(t,d,img);
	show(null);
	//save(img,d,t);	
}

//used on edit to change the values of the form elements with the existing ones
function changeFormValues(title,description,img){
	var d=document.getElementById("description");
	d.value=description.innerText;	
}
/* used to "save"(append) the new element values
*  image must be stored in same folder as the html file in order for this to work
*  If we used a server side scripting language( ex PHP), we could have use ajax to store the image on the server
*  and then retrieve it from there, but since this is a demo using only javascript we can't do that...
*/
function save(id/*,img,description,title*/){	
	var t=document.getElementById(id+"-title");
	var d=document.getElementById(id+"-description");
	var img=document.getElementById(id+"-img");
	var msg=document.getElementById("description");
	
	var image=document.getElementById("image");	
	img.getElementsByTagName('img')[0].src=image.value.split(/[\\/]/).pop();
	
	d.innerHTML=msg.value;
	//alert(temp_description);
}

function deleteProduct(element){
	var subDiv;
	var listDiv;
	var t=document.getElementById(element+"-title");
	var d=document.getElementById(element+"-description");
	var img=document.getElementById(element+"-img");
	subDiv=t.parentNode;
	listDiv=subDiv.parentNode;
	listDiv.removeChild(subDiv);
	
}

/*
* If we could write inside the xml to update it's values only with javascript we could have 
* simply used this function to re-read the xml file and re post it's contents on each addProduct, Edit od Delete.
* Since we cannot do that and instead we play only with the DOM elements(meaning each time the page refreshes all changes are lost)
* this function is useless...
*/
function loadXMLDoc(filename)
{
if (window.XMLHttpRequest)
  {
  xhttp=new XMLHttpRequest();
  }
else // code for IE5 and IE6
  {
  xhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xhttp.open("GET",filename,false);
xhttp.send();
return xhttp.responseXML;
}

//get text area new value; Only for testing purposes
function chv(v){	
	//alert(v.value);
	temp_description=v.value;
}

function chooseFunction(f){
	if(f=="addPRoduct")
		addProduct();
	if(f=="edit")
		edit();
	
	
}



