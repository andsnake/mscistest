<?php
/**
 * Created by George Antoniou.
 * Date: 7/2/14
 * Time: 11:19 AM
 * Recommender.php
 * To change this template use File | Settings | File Templates.
 */

include "../config.php";
include "../CoreClasses/Recommender.php";

// Set the content type to text/xml
header ("Content-Type:text/xml");
$recommender=new CoreClasses\Recommender(initConn());
function get_from_users($username){
    global $recommender;
    $recommender->set_Current_User($username);
    //$recommender->set_UID($username);
    $recommender->set_Other_Users();
    $recommender->calculate_rankings();
    $products=$recommender->getRecomendations();
    echo"<recommendation>";
    foreach($products as $item){
        /*echo"<product>";
        echo"<SKU>$item</SKU>";
        echo"</product>";*/
        echo(get_item_details($item));
        //echo $item;
    }
    echo"</recommendation>";
    //echo $recommender->getError();
}

function get_item_details($item){
    $url = 'http://'.HOST.'/'.ROOT.'/Core/RestServices/Product.php/product/other/'.$item;
    $answer="false";
    $client = curl_init($url);
    curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($client);
    curl_close($client);
    //$xml = simplexml_load_string($response);
    $arr=null;
    return $response;
}

// Check for the path elements
$path = $_SERVER['PATH_INFO'];
if ($path != null) {
    $path_params = explode("/", $path);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    if ($path_params[1] != null && $path_params[2] != null){
        if($path_params[1]=="user"){
            get_from_users($path_params[2]);
        }
    }
    else{
        get_All_Products(); //done
    }
}