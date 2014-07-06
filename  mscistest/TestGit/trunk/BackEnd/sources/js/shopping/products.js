   //Jquery Basket javascript code
    $(function () {

		// jQuery UI Draggable
		$("#product li").draggable({
		
			// brings the item back to its place when dragging is over
			revert:true,
		
			// once the dragging starts, we decrease the opactiy of other items
			// Appending a class as we do that with CSS
			drag:function () {
				$(this).addClass("active");
				$(this).closest("#product").addClass("active");
			},
		
			// removing the CSS classes once dragging is over.
			stop:function () {
				$(this).removeClass("active").closest("#product").removeClass("active");
			}
		});

        // jQuery Ui Droppable
		$(".basket").droppable({
		
			// The class that will be appended to the to-be-dropped-element (basket)
			activeClass:"active",
		
			// The class that will be appended once we are hovering the to-be-dropped-element (basket)
			hoverClass:"hover",
		
			// The acceptance of the item once it touches the to-be-dropped-element basket
			// For different values http://api.jqueryui.com/droppable/#option-tolerance
			tolerance:"touch",
			drop:function (event, ui) {
		
				var basket = $(this),
						move = ui.draggable,
						itemId = basket.find("ul li[data-id='" + move.attr("data-id") + "']");
						
						var product=move.find("h3").text();
						var productId =move.attr("data-id");
						var quantity;						
					
		
				// To increase the value by +1 if the same item is already in the basket
				if (itemId.html() != null) {
					itemId.find("input").val(parseInt(itemId.find("input").val()) + 1);	
					//increase item counter
					quantity=itemId.find("input").val();		
					//alert( product +" "+productId + " "+quantity );	
				}
				else {
					// Add the dragged item to the basket
					addBasket(basket, move);
					var quantity = 1;	
					//alert( product +" "+productId + " "+quantity );	
					//ajaxBasket(product,productId,quantity);			
		
					// Updating the quantity by +1" rather than adding it to the basket
					move.find("input").val(parseInt(move.find("input").val()) + 1);
				}
			}
		});

        // This function runs once an item is added to the basket
        function addBasket(basket, move) {
			basket.find("ul").append('<li data-id="' + move.attr("data-id") + '">'
					+ '<span class="name">' + move.find("h3").html() + '</span>'
					+ '<input class="count" value="1" type="text">'
					+ '<button class="delete">&#10005;</button>');
		}
		
		/*function removeBasket(){
			// The function that is triggered once delete button is pressed
        $(".basket ul li button.delete").live("click", function () {
			$(this).closest("li").remove();
		});
			
		}*/
		
		/*$( ".basket ul li button.delete" ).live( "click", function() {
  			alert( "Goodbye!" ); // jQuery 1.3+
		});*/
        $(".basket").on('click', 'ul li button.delete', function () {
			$(this).closest("li").remove();
		});
		
		function ajaxBasket(product,id,quantity){
			var postData = [
				{ "id":id, "product":product, "quantity": quantity}			 
			  ];
			  //window.location.url = "?id=" + $(this).val(id)+"&product="+$(this).val(product)+"&quantity="+$(this).val(quantity);
			  
			 /* $("#response").load("ajax/addtocart.html?"+ $.param({
        			product: product,
        			id: id,
					quantity:quantity
					})
				);*/
				//window.location.url = "?id=" + $(this).val(id)+"&product="+$(this).val(product)+"&quantity="+$(this).val(quantity);
				jQuery.param.querystring(window.location.href, "?id=" +(id)+"&product="+(product)+"&quantity="+(quantity));
				var parameters = { "id":id, "product":product, "quantity": quantity};
				$.get( "ajax/addtocart.html"
					,parameters, function(data) {
 					$('#response').html(data);});
				
			  //$("#response").html('<object data="ajax/addtocart.html?product='+product+'&id='+id+'&quantity='+quantity+'">');
			  //alert( product +" "+id + " "+quantity );
			/*$.ajax({
			   type: "GET",
			   //contentType: 'application/json',
			   url: "ajax/test.js",
			   data:{"product":product, "quantity":quantity,"id":id}, 
			   //data: JSON.stringify(postData),
			   dataType: 'script',
			   success: function(data, textStatus){
				   //alert( "Entering Ajax sucess function "+msg );				   
            			$('#response').html("adasdasd");
				   
				   /*
				   //useless code..not working
				   if(parseInt(msg.status)!=1) {
					   alert("Hi:"+msg.html());
						return false;
					}
					else {
						//call function to recreate basket						
						alert("Hi:"+msg.html());
					}*/
			   /*},
			   error: function (xhr, status) {
            		alert("Sorry, there was a problem!");
			   }
			   
			});*/
			/*$.getScript( "ajax/test.js", function( data, textStatus, jqxhr ) {
			  console.log( data ); // Data returned
			  console.log( textStatus ); // Success
			  console.log( jqxhr.status ); // 200
			  console.log( "Load was performed." );
			});*/
			
			
			
		}
		

    });