<?php
/* Shopping Cart File. Responsible for handling all the nessessary Cart Functions
*/
session_start(); //Start a session which should always be at the very top of your page as defined here
include("../Core/config.php");
if(isset($_POST['page']) && !empty($_POST['page'])){
	if($_POST['page']=="add_to_cart" && isset($_POST['item_name']) && !empty($_POST['item_name']) && isset($_POST['item_price']) && !empty($_POST['item_price'])){
        if(isset($_SESSION['cart']) && empty($_SESSION['cart'])){
            unset($_SESSION['cart']);
            }
		//check if user already has a shopping cart available
		if(!isset($_SESSION['cart'])){
			$_SESSION['cart'] = array();
			$SKU=$_POST['item_SKU'];
            $name=$_POST['item_name'];
				$q=1;
				$price=$_POST['item_price'];

			    $_SESSION['cart'][]=array("SKU"=>$SKU,"quantity"=>1,"price"=>$price,"name"=>$name);
		}
		else{
			//check if user has clicked the add and that there are valid values in it(no null)
			if(isset($_POST['item_name']) && !empty($_POST['item_name']) && isset($_POST['item_price']) && !empty($_POST['item_price'])){
				$SKU=$_POST['item_SKU'];
                $name=$_POST['item_name'];
				$q=1;
				$price=$_POST['item_price'];
                $insert=true;
				//if item already exists in shopping cart increase quantity by one and add it again.
				if(isset($_SESSION['cart']) && $_SESSION['cart']!=null ){
					foreach($_SESSION['cart'] as $p=>$array){
						if($array['SKU']==$SKU){
							//$_SESSION['cart'] [$p]['quantity']=$q++;
                            $q=$array['quantity']+1;
                            unset($_SESSION['cart'] [$p]);
                            $_SESSION['cart'][]=array("SKU"=>$SKU,"quantity"=>$q,"price"=>$price,"name"=>$name);
                            $insert=false;
                            break;
						}
                        else{
                            //$_SESSION['cart'][]=array("SKU"=>$SKU,"quantity"=>1,"price"=>$price);
                        }
					} if($insert==true) $_SESSION['cart'][]=array("SKU"=>$SKU,"quantity"=>1,"price"=>$price,"name"=>$name);
				}
			}
		}
		//show cart
		if(isset($_SESSION['cart']) && $_SESSION['cart']!=null ){
            print_Cart();
		}
				
	}
    if($_POST['page']=="remove_from_cart" && isset($_POST['item_SKU']) && !empty($_POST['item_SKU'])){
        if(isset($_SESSION['cart']) && $_SESSION['cart']!=null ){
            $SKU=$_POST['item_SKU'];
            foreach($_SESSION['cart'] as $p=>$array){
                if($array['SKU']==$SKU){
                    //$_SESSION['cart'] [$p]['quantity']=$q++;
                    $q=$array['quantity']+1;
                    unset($_SESSION['cart'] [$p]);
                    //$_SESSION['cart'][]=array("SKU"=>$SKU,"quantity"=>$q,"price"=>$price,"name"=>$name);
                    $insert=false;
                    break;
                }
                else{
                    //$_SESSION['cart'][]=array("SKU"=>$SKU,"quantity"=>1,"price"=>$price);
                }
            }
            print_Cart();
        }

    }
}
if(isset($_POST['page']) && $_POST['page']=="submit_cart"){
    //print_Cart();
    // call to Order REST servie to add the order into database

}

if(isset($_POST['page']) && $_POST['page']=="clear_cart"){
    if(isset($_SESSION['cart'])){
        /*foreach($_SESSION['cart'] as $p=>$array){
            unset($_SESSION['cart'] [$p]);
        }*/
        unset($_SESSION['cart']);
    }
    print_Cart();
}

if((isset($_POST['page']) && $_POST['page']=="show_cart")){
    print_Cart();
}

function print_Cart(){
    //var_dump($_SESSION);
    if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
        echo'<div id="vpb_shopping_cart_is_currently_empty" align="left">
    Hello There, <br /><br />Your shopping cart is empty at the moment. <br />Please click on the add to cart buttons at the bottom of each item to add an item of your choice to cart.<br /><br />Thank You...
    </div>';
    }
    else{
        echo '<table class="table table-bordered table-striped">
		  <thead>
			  <tr>
				<th>Remove</th>
				<th>Image</th>
				<th>Product Name</th>
				<th>Model</th>
				<th>Quantity</th>
				<th>Unit Price</th>
				<th>Total</th>
			  </tr>
			</thead>
			<tbody>';
        $total=0;
        foreach($_SESSION['cart'] as $cart){
            echo '<tr>
				<td class=""><input value="option1" id="optionsCheckbox"  onchange="remove_from_cart('."'".$cart["SKU"]."'".')" type="checkbox"></td>
				<td class="muted center_text"><a href="/product/'.$cart["SKU"].'"><img src="css/images/macbook-pro.jpg"></a></td>
				<td>'.$cart["name"].'</td>
				<td>Product 18</td>
				<td><input placeholder="'.$cart["quantity"].'" class="input-mini" type="text"></td>
				<td>$'.$cart["price"].'</td>
				<td>$'.$cart["price"]*$cart["quantity"].'</td>
			  </tr>	';
            $total+=$cart["price"]*$cart["quantity"];
        }
        if(check_login(null)=="false"){
            $button="Login to Order";
            $colour="btn-info";
        }
        else{
            $button="Checkout";
            $colour="btn-success";
        }
        echo '<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><strong>$'.$total.'</strong></td>
			  </tr>
			  <tr>
			  <td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td></td>
				<td>
				<button type="button" class="btn btn-warning btn-sm"
				onClick="clear_cart()"><span class="glyphicon glyphicon-remove"></span> Clear Cart</button>
				<button type="button" class="btn '.$colour.' btn-sm"
				onClick="checkout_cart('."'".check_login(null)."')".'"><span class="glyphicon glyphicon-shopping-cart"></span> '.$button.'</button></td>
				<td></td>
			  </tr>
			</tbody>
		  </table>';

    }

}

