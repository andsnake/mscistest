<?php
/**
 * Created by George Antoniou.
 * Date: 7/2/14
 * Time: 12:34 PM
 * recommend.php
 * To change this template use File | Settings | File Templates.
 */
include("../Core/config.php");

if(isset($_POST['username'])){
    $item=$_POST['username'];
    show($item);

}

function show($username){
    $url = 'http://'.HOST.'/'.ROOT.'/Core/RestServices/Recommender.php/user/'.$username;
    $answer="false";
    $client = curl_init($url);
    curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($client);
    curl_close($client);
    $xml = simplexml_load_string($response);
    $arr=null;
    //print_r($response);
    // var_dump($xml);
    echo '<div class="scroll-pane ui-widget ui-widget-header ui-corner-all" style="background-color: #ffffff">
    <div class="scroll-content">';
    echo '<h2 class="featurette-heading">Recommended for you</h2>';
    foreach ($xml->products as $products) {
        foreach($products->product as $product){
            echo'<div class="col-lg-4 scroll-content-item ui-widget-header" style="background-color: #ffffff">
         <img class="img-circle"  data-src="holder.js/50x50" alt="50x50" data-toggle="tooltip" data-placement="left" src="uploads/'.$product->img.'" style="width: 100px; height: 100px;" title="'.htmlspecialchars($product->description).'"><h5>'.htmlspecialchars($product->name).'</h5><h4>'.htmlspecialchars($product->price).' &#8364;</h4> <button type="button" class="btn btn-success btn-xs" onClick="add_to_cart('."'".strip_tags($product->SKU)."','".strip_tags($product->price)."','add',"."'".strip_tags($product->name)."','null'".')"><span class="glyphicon glyphicon-shopping-cart"></span> Add</button>

        </div><!-- /.col-lg-4 -->';
        }

        //echo "<tr> <td> " . htmlspecialchars($product->name) . "</td> "." </td></tr>";
    }
    echo "</div>
</div>";

}


?>

<Script>$(document).ready(function (){
    $('[data-toggle="tooltip"]').tooltip({'placement': 'right'});
  }); </script>
