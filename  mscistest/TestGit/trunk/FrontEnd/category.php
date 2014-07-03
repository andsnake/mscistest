<?php
/**
 * Created by PhpStorm.
 * User: George
 * Date: 6/25/14
 * Time: 10:08 PM
 */

if(isset($_GET['category'])){
	$catid=filter_var($_GET['category'], FILTER_SANITIZE_STRING);
    $catid=sacarXss($_GET['category']);
    if (is_numeric($catid)  ) {
        //echo $catid;
        $url = 'http://'.HOST.'/'.ROOT.'/Core/RestServices/Product.php/product/category/'.$catid;

        $client = curl_init($url);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($client);
        curl_close($client);
        try{
            //$response='<test>'.$response.'/<test>';
            //echo $response;
            $xml = simplexml_load_string($response);
        }catch(Exception $e) {
            //echo $e->getMessage();
        }
        echo "<div><h3>Query Results</h3></div><hr>";
        foreach ($xml->product as $product) {
            echo'<div class="col-lg-4">
         <img class="img-circle"  data-src="holder.js/50x50" alt="50x50" data-toggle="tooltip" data-placement="left" src="uploads/'.$product->img.'" style="width: 100px; height: 100px;" title="'.htmlspecialchars($product->description).'"><h3>'.htmlspecialchars($product->name).'</h3><h4>'.htmlspecialchars($product->price).' &#8364;</h4> <button type="button" class="btn btn-success btn-xs" onClick="add_to_cart('."'".strip_tags($product->SKU)."','".strip_tags($product->price)."','add',"."'".strip_tags($product->name)."','".null."'".')"><span class="glyphicon glyphicon-shopping-cart"></span> Add</button>

        </div><!-- /.col-lg-4 -->';
            //echo "<tr> <td> " . htmlspecialchars($product->name) . "</td> "." </td></tr>";
        }
        if(empty($xml)){
            echo "    <div class='alert alert-info'>
    <strong>OOOPS!</strong> We are sorry, this category is empty :(
    </div>";
        }
    }
	else echo "    <div class='alert alert-warning'>
    <strong>OOOPS!</strong> We are sorry, why have you tried this??.. :(
    </div>";


}
else
    echo "AHAHAHA";