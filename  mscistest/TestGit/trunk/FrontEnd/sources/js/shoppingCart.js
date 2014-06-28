// JavaScript Shopping Cart

function add_to_cart(item_SKU,item_price,status,item_name,root)
{
	/*$("div.checkout_user_info").hide();
	$("div#checkout_user_info").hide();
	$("div.shopping_cart_status").show();
	$("div#shopping_cart_status").show();*/
    if(root=="null"){
        uri="FrontEnd/shopping_cart.php";
    }
    else
        uri=root+"/FrontEnd/shopping_cart.php";
	
	var dataString = "item_SKU=" + item_SKU + "&item_price=" + item_price + "&page=add_to_cart"+"&item_name="+item_name;
	$.ajax({  
		type: "POST",  
		url: "FrontEnd/shopping_cart.php",
		data: dataString,
		beforeSend: function() 
		{
			//$('html, body').animate({scrollTop:0}, 'slow');
			$("#response").html('<img src="loading.gif" align="absmiddle" alt="Loading..."> Loading...<br clear="all" /><br clear="all" />');
		},  
		success: function(response)
		{
			$("#response").html(response);
		}
	});
}

function remove_from_cart(item_SKU)
{
    /*$("div.checkout_user_info").hide();
     $("div#checkout_user_info").hide();
     $("div.shopping_cart_status").show();
     $("div#shopping_cart_status").show();*/
    if(confirm("Are you sure that you really want to remove this item?")){
        var dataString = "item_SKU=" + item_SKU + "&page=remove_from_cart";;
        $.ajax({
            type: "POST",
            url: "FrontEnd/shopping_cart.php",
            data: dataString,
            beforeSend: function()
            {
                //$('html, body').animate({scrollTop:0}, 'slow');
                $("#response").html('<img src="loading.gif" align="absmiddle" alt="Loading..."> Loading...<br clear="all" /><br clear="all" />');
            },
            success: function(response)
            {
                $("#response").html(response);
            }
        });
    }

}

function show_cart(){
    var dataString = "page=show_cart";;
    $.ajax({
        type: "POST",
        url: "FrontEnd/shopping_cart.php",
        data: dataString,
        beforeSend: function()
        {
            //$('html, body').animate({scrollTop:0}, 'slow');
            $("#response").html('<img src="loading.gif" align="absmiddle" alt="Loading..."> Loading...<br clear="all" /><br clear="all" />');
        },
        success: function(response)
        {
            $("#response").html(response);
        }
    });
}

function clear_cart(){
    if(confirm("Are you sure that you really want to remove all items?")){
        var dataString = "&page=clear_cart";;
        $.ajax({
            type: "POST",
            url: "FrontEnd/shopping_cart.php",
            data: dataString,
            beforeSend: function()
            {
                //$('html, body').animate({scrollTop:0}, 'slow');
                $("#response").html('<img src="loading.gif" align="absmiddle" alt="Loading..."> Loading...<br clear="all" /><br clear="all" />');
            },
            success: function(response)
            {
                $("#response").html(response);
            }
        });
    }

}

function checkout_cart(status){
    if(status=="false"){
        //user is not logged in-show login promt
        $('#checkout_modal').modal('show');
    }
    else{
        if(status=="true"){
            var dataString = "&page=checkout_cart";;
            $.ajax({
                type: "POST",
                url: "FrontEnd/shopping_cart.php",
                data: dataString,
                beforeSend: function()
                {
                    //$('html, body').animate({scrollTop:0}, 'slow');
                    //$("#response").html('<img src="loading.gif" align="absmiddle" alt="Loading..."> Loading...<br clear="all" /><br clear="all" />');
                },
                success: function(response)
                {
                    $("#checkout_contents").html(response);
                }
            });
            $('#checkout_modal').modal('show');
        }
    }

}

