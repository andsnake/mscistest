<?php
/**
 * Created by George Antoniou.
 * Date: 7/6/14
 * Time: 6:58 PM
 * delete.php
 * To change this template use File | Settings | File Templates.
 */

if(isset($_GET['item'])){
    $item=$_GET['item'];
    $url = 'http://'.HOST.'/'.ROOT.'/Core/RestServices/Product.php/products/SKU/'.$item."/";

    $client = curl_init($url);
    curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($client, CURLOPT_CUSTOMREQUEST, "DELETE");
    $response = curl_exec($client);
    curl_close($client);
    try{
        //$response='<test>'.$response.'/<test>';
        //echo $response;
        $xml = simplexml_load_string($response);
    }catch(Exception $e) {
        //echo $e->getMessage();
    }
    if(isset($xml->success))
        echo "Item deleted";
    else echo " You cannot delete a item if an order exists for it!";
}