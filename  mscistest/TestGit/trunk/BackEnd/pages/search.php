<div class="panel panel-default">
    <div class="panel-heading">Items</div>
    <div class="panel-body">
<?php
/**
 * Created by PhpStorm.
 * User: George
 * Date: 6/28/14
 * Time: 8:24 PM
 */
//echo "Search page";
if(isset($_GET['mode'])){
    //to do search handling
    if($_GET['mode']=="product"){
        if(isset($_GET['item'])){
            $product=(($_GET['item']));
           // $product=sacarXss($product);
            //$product=strip_tags(preg_replace("/[^[:alnum:][:punct:]]/","",htmlspecialchars($product)));
            $product=filter_var($product, FILTER_SANITIZE_STRING);
            $product=strip_Characters($product);
            $product = preg_replace('/\s+/', '_', $product);
            //echo "in product";
        }
        search($product, null,null);

    }//return products that belong to a certain category
    elseif($_GET['mode']=="SKU"){
        if(isset($_GET['item']) ){
            $product=$_GET['item'];
            $product=strip_Characters($product);

        }
        search(null,null,$product);

    }elseif($_GET['mode']=="mixed"){

    }
}
if(!isset($_GET['mode']) || !isset($_GET['item'])){
    echo'<form class="navbar-search navbar-form" method="get" action="index.php?action=search">
                            <input class="form-control" placeholder="Search" name="item" type="text">
                            <!-- Select Basic -->

                              <label class="control-label" for="mode">Search By</label>

                                <select id="mode" name="mode" class="input-medium form-control">
                                  <option value="product">Product Name</option>
                                  <option value="SKU">Product SKU</option>
                                </select>
                                <button>Search</button>

                            <input hidden="hidden" name="action" value="search"/>
                           <!-- <input hidden="hidden" name="mode" value="product"/> -->

                        </form>












                        ';
}

function search($product, $category,$SKU){
    if($category == null && $SKU==null)
    {
        $url = 'http://'.HOST.'/'.ROOT.'/Core/RestServices/Product.php/search/'.$product."/0/";
    }
    elseif($product!=null)
    {
        $url = 'http://'.HOST.'/'.ROOT.'/Core/RestServices/Product.php/search/'.$product."/".$category."/";
    }
    else{
        $url = 'http://'.HOST.'/'.ROOT.'/Core/RestServices/Product.php/searchSKU/'.$SKU."/none";
    }
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
    } //var_dump($url);
    $show=true;
    if(!isset($xml->product)){
        $product=htmlspecialchars(strip_Characters($_GET['item']));
        $product=sacarXss($product);
        $product=strip_tags(preg_replace("/[^[:alnum:][:punct:]]/","",htmlspecialchars($product)));
        $product=filter_var($product, FILTER_SANITIZE_STRING);
        $product=strip_Characters($product);
        $show=false;
        echo '<p><div class="alert alert-danger" role="alert">0 Results found</div></p>';
        echo '
            <form class="navbar-search navbar-form" method="get" action="index.php?action=search">
                            <input class="form-control" placeholder="Search" value="'.$product.'" name="item" type="text"><button>Search</button>
                            <input hidden="hidden" name="action" value="search"/>
                            <input hidden="hidden" name="mode" value="product"/>

                        </form><br>
        ';
    }
    if($show){
        echo"<br><H3>Results:</H3><br>";
        foreach ($xml->product as $product) {
            echo'<div class="col-lg-4">
         <img class="img-circle"  data-src="holder.js/50x50" alt="50x50" data-toggle="tooltip" data-placement="left" src="../uploads/'.htmlspecialchars($product->img).'" style="width: 100px; height: 100px;" title="'.htmlspecialchars($product->description).'"><h3>'.htmlspecialchars($product->name).'</h3><h4>'.htmlspecialchars($product->price).' &#8364;</h4> <a href="index.php?action=edit&item='.strip_tags($product->SKU).'" type="button" class="btn btn-success btn-xs" )"><span class="glyphicon glyphicon-edit"></span> Edit</a>
         <a href="index.php?action=delete&item='.strip_tags($product->SKU).'" type="button" class="btn btn-danger btn-xs" ><span class="glyphicon glyphicon-delete"></span> Delete</a>

        </div><!-- /.col-lg-4 -->';
            //echo "<tr> <td> " . htmlspecialchars($product->name) . "</td> "." </td></tr>";
        }
    }

}
?>
    </div><!-- end products panel-->
</div>
