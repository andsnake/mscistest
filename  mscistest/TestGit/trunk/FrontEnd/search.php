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
            $product=htmlspecialchars(strip_Characters($_GET['item']));
            $product=sacarXss($product);
            $product=strip_tags(preg_replace("/[^[:alnum:][:punct:]]/","",htmlspecialchars($product)));
            $product=filter_var($product, FILTER_SANITIZE_STRING);
            $product=strip_Characters($product);
            //echo "in product";
        }
        search($product, null);

    }//return products that belong to a certain category
    elseif($_GET['mode']=="category"){
        if(isset($_GET['item']) && isset($_GET['cat']) ){
            $product=$_GET['item'];
            $category=$_GET['cat'];
            $product=strip_Characters($product);
            $category=strip_Characters($category);
        }
        search($product,$category);

    }elseif($_GET['mode']=="mixed"){

    }
}

function search($product, $category){
    if($category == null)
    {
        $url = 'http://'.HOST.'/'.ROOT.'/Core/RestServices/Product.php/search/'.$product."/0/";
    }
    else
    {
        $url = 'http://'.HOST.'/'.ROOT.'/Core/RestServices/Product.php/search/'.$product."/".$category."/";
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
    }
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
            <form class="navbar-search navbar-form" method="get" action="index.php?page=search">
                            <input class="form-control" placeholder="Search" value="'.$product.'" name="item" type="text"><button>Search</button>
                            <input hidden="hidden" name="page" value="search"/>
                            <input hidden="hidden" name="mode" value="product"/>

                        </form><br>
        ';
    }
    if($show){
        echo"<br><H3>Results:</H3><br>";
        foreach ($xml->product as $product) {
            echo'<div class="col-lg-4">
         <img class="img-circle"  data-src="holder.js/50x50" alt="50x50" data-toggle="tooltip" data-placement="left" src="uploads/'.$product->img.'" style="width: 100px; height: 100px;" title="'.htmlspecialchars($product->description).'"><h3>'.htmlspecialchars($product->name).'</h3><h4>'.htmlspecialchars($product->price).' &#8364;</h4> <button type="button" class="btn btn-success btn-xs" onClick="add_to_cart('."'".strip_tags($product->SKU)."','".strip_tags($product->price)."','add',"."'".strip_tags($product->name)."','null'".')"><span class="glyphicon glyphicon-shopping-cart"></span> Add</button>

        </div><!-- /.col-lg-4 -->';
            //echo "<tr> <td> " . htmlspecialchars($product->name) . "</td> "." </td></tr>";
        }
    }

}