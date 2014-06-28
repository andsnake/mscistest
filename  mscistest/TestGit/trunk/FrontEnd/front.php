<!-- Three columns of text below the carousel -->
<div class="row">
    <h2 class="featurette-heading">Νέες Αφίξεις.</h2>
    <?php
    $url = 'http://'.HOST.'/'.ROOT.'/Core/RestServices/Product.php/';

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
    foreach ($xml->product as $product) {
        echo'<div class="col-lg-4">
         <img class="img-circle"  data-src="holder.js/50x50" alt="50x50" data-toggle="tooltip" data-placement="left" src="FrontEnd/sources/img/figure1.jpg" style="width: 100px; height: 100px;" title="'.htmlspecialchars($product->description).'"><h3>'.htmlspecialchars($product->name).'</h3><h4>'.htmlspecialchars($product->price).' &#8364;</h4> <button type="button" class="btn btn-success btn-xs" onClick="add_to_cart('."'".strip_tags($product->SKU)."','".strip_tags($product->price)."','add',"."'".strip_tags($product->name)."','null'".')"><span class="glyphicon glyphicon-shopping-cart"></span> Add</button>

        </div><!-- /.col-lg-4 -->';
        //echo "<tr> <td> " . htmlspecialchars($product->name) . "</td> "." </td></tr>";
    }
    ?>
</div><!-- /.row -->

<?php
/**
 * Created by PhpStorm.
 * User: George
 * Date: 6/25/14
 * Time: 8:54 PM
 */
/*for($i=0;$i<=5;$i++)
    $cart[]=array("SKU"=>rand(),"quantity"=>rand());
var_dump($cart);
var_dump($_SESSION['cart']);*/