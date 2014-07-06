<h1>Howdy <?=$_SESSION['admin'] ?></h1>
<p>Here's latest products</p>
<!-- Products Panel-->
<div class="panel panel-default">
    <div class="panel-heading">Items</div>
    <div class="panel-body">
        <!--<div class="row">
            <div class="col-xs-6 col-md-4 productPanel">ΚΑΤΑΣΚΕΥΑΣΤΗΣ:</div>
            <div class=".col-xs-12 col-md-8"><span class="label label-default">KONAMI</span> <span class="label label-default">NITENDO</span> <span class="label label-default">SONY</span> <span class="label label-default">MS</span>   </div>
        </div>-->


<?php
$url = 'http://'.HOST.'/'.ROOT.'/Core/RestServices/Product.php/products/latest/';

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
         <img class="img-circle"  data-src="holder.js/50x50" alt="50x50" data-toggle="tooltip" data-placement="left" src="../uploads/'.htmlspecialchars($product->img).'" style="width: 100px; height: 100px;" title="'.htmlspecialchars($product->description).'"><h3>'.htmlspecialchars($product->name).'</h3><h4>'.htmlspecialchars($product->price).' &#8364;</h4> <button type="button" class="btn btn-success btn-xs" onClick="add_to_cart('."'".strip_tags($product->SKU)."','".strip_tags($product->price)."','add',"."'".strip_tags($product->name)."','null'".')"><span class="glyphicon glyphicon-edit"></span> Edit</button>
         <a href="index.php?action=delete&item='.strip_tags($product->SKU).'" type="button" class="btn btn-danger btn-xs" ><span class="glyphicon glyphicon-delete"></span> Delete</a>

        </div><!-- /.col-lg-4 -->';
    //echo "<tr> <td> " . htmlspecialchars($product->name) . "</td> "." </td></tr>";
}
?>
    </div><!-- end products panel-->
</div>

<?php
/**
 * Created by George Antoniou.
 * Date: 7/6/14
 * Time: 6:30 PM
 * home.php
 * To change this template use File | Settings | File Templates.
 */
