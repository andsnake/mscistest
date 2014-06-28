<?php
/**
 * Created by PhpStorm.
 * User: George
 * Date: 6/27/14
 * Time: 5:34 PM
 */
include "../config.php";
include "../CoreClasses/Orders.php";

// Set the content type to text/xml
header ("Content-Type:text/xml");
$orders=new \CoreClasses\Orders(initConn());

function add_Order($UID){
    global $orders;
    $result=null;
    $err=null;
    $input = file_get_contents("php://input");
    libxml_use_internal_errors(true);
    try{
        $xml = simplexml_load_string($input);
    }catch(Exception $e){
        $xml=null;
    }

    $cart=array();
    //recreate cart array;
    if($xml==null || $xml===false){
        die("<response><error>No Valid Data Send</error></response>");
    }
    foreach ($xml->item as $item) {
        if(empty($item->SKU) ||empty($item->quantity) || !isset($item->SKU) || !isset($item->quantity)){
            die("<response><error>No Valid Data Send</error></response>");
        }
        $cart[]=array("SKU"=>$item->SKU,"quantity"=>$item->quantity);

    }// die(print_r($cart));
    $result=$orders->add_Order($cart,$UID);
    if(array_key_exists('success',$result)){//return the order code
        echo"<response>
                <success>".$result['success']."</success>
                <code>".$result['code']."</code>
             </response>";
    }
    else{
        echo "<response><error>".$result['error']."</error></response>";
    }
}

function get_Order($code){
    global $orders;
    $result=$orders->get_Order($code);
    if(array_key_exists('error',$result)){
        die("<response><error>".$result['error']."</error></response>");
    }
    echo"<orders><order>";
    echo"<details><total>".$result[0]['total']."</total><UID>".$result[0]['UID']."</UID><status>".$result[0]['status']."</status><OID>".$result[0]['OID']."</OID>";
    echo"</details>";
    foreach($result as $order){
        echo"<product>".$order['name']."</product><SKU>".$order['SKU']."</SKU>";

    }
    echo"</order></orders>";
}

// Check for the path elements
$path = $_SERVER['PATH_INFO'];
if ($path != null) {
    $path_params = explode("/", $path);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if ($path_params[1] != null && $path_params[2] != null){
        if($path_params[1]=="add"){
            add_Order($path_params[2]);
        }
        if($path_params[1] != null && $path_params[2] != null ){
            if($path_params[1]=="edit"){
                edit_Order(); //not that u can actually edit an order.. we just set the status here..(regards the management page..)
            }
        }
    }
}
elseif ($_SERVER['REQUEST_METHOD'] == 'GET'){
    if ($path_params[1] != null && $path_params[2] != null ){
        if($path_params[1]=="search"){
            get_Order($path_params[2]);
        }
        else{
            //get_User($path_params[2]); //done
        }
    }
}