<?php
/**
 * Created by PhpStorm.
 * User: George
 * Date: 6/23/14
 * Time: 1:34 PM
 */
include "../config.php";
include "../CoreClasses/Products.php";

// Set the content type to text/xml
header ("Content-Type:text/xml");
$products=new \CoreClasses\Products(initConn());

// Check for the path elements
$path = $_SERVER['PATH_INFO'];
if ($path != null) {
    $path_params = explode("/", $path);
}
function check_Response($answer){
    if(is_array($answer)){
        if(array_key_exists('success',$answer)){
            return true;
        }
        if(array_key_exists('error',$answer)){
            return false;
        }
    }
    else
        return false;
}

function add_Product(){
    $result=null;
    $input = file_get_contents("php://input");
    $xml = simplexml_load_string($input);
    $details=array();
    foreach ($xml->product as $product) {
        echo $product;
        $details=["SKU"=>$product->SKU,
            "description"=>$product->description,
            "price"=>$product->price,
            "stock"=>$product->stock,
            "category"=>array($product->category),
            "name"=>$product->name,
            "img"=>$product->img
        ];
        global $products;
        $result=$products->add_Product($details);
        if(check_Response($result)==true){
            echo "<response><success>'Item added'</success></response>";
        }
        else{
            $err=$result['error'];
            echo "<response><error>$err</error></response>";
        }

    }
}

function edit_Product(){
    global $products;
    $input = file_get_contents("php://input");
    $xml = simplexml_load_string($input);
    $details=array();
    foreach ($xml->product as $product) {

        $details=["SKU"=>$product->SKU,
            "description"=>$product->description,
            "price"=>$product->price,
            "stock"=>$product->stock,
            "category"=>$product->category,
            "name"=>$product->name,
            "img"=>$product->img
        ];
        global $products;
        $result=$products->edit_Product($details['SKU'],$details);
        if(check_Response($result)==true){
            echo "<response><success>'Item edited'</success></response>";
        }
        else{
            $err=$result['error'];
            echo "<response><error>$err</error></response>";
        }

    }
}

function get_Category_Products($catid){
    global $products;
    $array=$products->get_Cat_Products($catid);
    echo"<products>";
    foreach($array as $product){
        echo"<product>";
        echo"<SKU>$product[SKU]</SKU>";
        echo"<description>$product[description]</description>";
        echo"<price>$product[price]</price>";
        echo"<stock>$product[stock]</stock>";
        echo"<name>$product[name]</name>";
        echo"<img>$product[img]</img>";
        echo"</product>";
    }
    echo "</products>";
}
function get_Product($SKU){
    global $products;
    $array=$products->get_Product($SKU);
    echo"<products>";
    foreach($array as $product){
        if($product['SKU']!=null){
            echo"<product>";
            echo"<SKU>$product[SKU]</SKU>";
            echo"<name>$product[name]</name>";
            echo"<description>$product[description]</description>";
            echo"<price>$product[price]</price>";
            echo"<stock>$product[stock]</stock>";
            echo"<img>$product[img]</img>";
            echo"</product>";
        }
        else{
            echo"<error>No Product Found!</error>";
        }

    }
    echo "</products>";
}

function add_Category(){
    $result=null;
    $input = file_get_contents("php://input");
    $xml = simplexml_load_string($input);
    $details=array();
    foreach ($xml->category as $category) {
        $details=["parent"=>$category->parent,
            "name"=>$category->name

        ];
        global $products;
        $result=$products->add_Category($details);
        if(check_Response($result)==true){
            echo "<response><success>'Item added'</success></response>";
        }
        else{
            $err=$result['error'];
            echo "<response><error>$err</error></response>";
        }
       // print_r($details);

    }
}

function edit_Category(){
    global $products;
    $input = file_get_contents("php://input");
    $xml = simplexml_load_string($input);
    $details=array();
    foreach ($xml->category as $category) {

        $details=["parent"=>$category->parent,
            "name"=>$category->name,
            "id"=>$category->id
        ];
        $result=$products->edit_Category($details);
        if(check_Response($result)==true){
            echo "<response><success>'Item edited'</success></response>";
        }
        else{
            $err=$result['error'];
            echo "<response><error>$err</error></response>";
        }

    }
}

function delete_Product($SKU){
    global $products;
    $result=$products->delete_Product($SKU);
    if(check_Response($result)==true){
        echo "<response><success>'Item deleted'</success></response>";
    }else{
        $err=$result['error'];
        echo "<response><error>$err</error></response>";
    }

}

function delete_Category($id){
    global $products;
    $result=$products->delete_Category($id);
    if(check_Response($result)==true){
        echo "<response><success>'Item deleted'</success></response>";
    }else{
        $err=$result['error'];
        echo "<response><error>$err</error></response>";
    }

}

function get_All_Products(){
    global $products;
    $array=$products->get_All_Products();
    echo"<products>";
    foreach($array as $product){
        echo"<product>";
        echo"<SKU>$product[SKU]</SKU>";
        echo"<name>$product[name]</name>";
        echo"<description>$product[description]</description>";
        echo"<price>$product[price]</price>";
        echo"<stock>$product[stock]</stock>";
        echo"<img>$product[img]</img>";
        echo"</product>";
    }
    echo "</products>";
}

function  get_Categories(){
    global $products;
    $array=$products->getCategories();
    echo"<products>";
    foreach($array as $product){
        echo"<category>";
        echo"<ID>$product[CATID]</ID>";
        echo"<name>$product[cat_name]</name>";
        echo"<parent>$product[parent]</parent>";
        echo"</category>";
    }
    echo "</products>";
}

function get_Latest_Products(){
    global $products;
    $array=$products->get_Latest_Products();
    echo"<products>";
    foreach($array as $product){
        echo"<product>";
        echo"<SKU>$product[SKU]</SKU>";
        echo"<name>$product[name]</name>";
        echo"<description>$product[description]</description>";
        echo"<price>$product[price]</price>";
        echo"<stock>$product[stock]</stock>";
        echo"<img>$product[img]</img>";
        echo"</product>";
    }
    echo "</products>";
}

function search($name,$CATID){
    global $products;
    $array=$products->search($name,$CATID);
    echo"<products>";
    foreach($array as $product){
        echo"<product>";
        echo"<SKU>$product[SKU]</SKU>";
        echo"<name>$product[name]</name>";
        echo"<description>$product[description]</description>";
        echo"<price>$product[price]</price>";
        echo"<stock>$product[stock]</stock>";
        echo"<img>$product[img]</img>";
        echo"</product>";

    }
    echo "</products>";
    //debugging
    //var_dump($array);
    //echo "    ".$name;
}
function searchSKU($SKU){
    global $products;
    $array=$products->search_SKU($SKU);
    echo"<products>";
    foreach($array as $product){
        echo"<product>";
        echo"<SKU>$product[SKU]</SKU>";
        echo"<name>$product[name]</name>";
        echo"<description>$product[description]</description>";
        echo"<price>$product[price]</price>";
        echo"<stock>$product[stock]</stock>";
        echo"<img>$product[img]</img>";
        echo"</product>";

    }
    echo "</products>";
    //debugging
    //var_dump($array);
    //echo "    ".$name;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if ($path_params[1] != null && $path_params[2] != null ){
        if($path_params[1]=="product"){
            if($path_params[2]=="add"){
                add_Product(); //done
            }
            elseif($path_params[2]=="edit"){
                edit_Product(); //done
            }
        }
        elseif($path_params[1]=="category"){
            if($path_params[2]=="add"){
                add_Category();//done
            }
            elseif($path_params[2]=="edit"){
                edit_Category();
            }
        }

    }
}
elseif ($_SERVER['REQUEST_METHOD'] == 'GET'){
   //Print_r($path_params);
        if ($path_params[1] != null){
            if($path_params[2] != null && $path_params[3]!=null){
                if($path_params[2]=="category"){
                    get_Category_Products($path_params[3]); //done
                }
                elseif($path_params[1]=="search"){
                    search($path_params[2],$path_params[3]);
                }
                elseif($path_params[1]=="searchSKU"){
                    searchSKU($path_params[2]);
                }
                else {
                    get_Product($path_params[3]); //done
                }
            }
            elseif($path_params[2] != null && $path_params[2]=="latest"){
                get_Latest_Products();
            }
            elseif($path_params[2] != null && $path_params[2]=="category" && $path_params[3]==null){
                get_Categories();
            }
        }
        else{
            get_All_Products(); //done
        }
}
elseif($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    if ($path_params[1] != null && $path_params[2] != null  && $path_params[3]!=null){
        if($path_params[2]=="SKU"){
            delete_Product($path_params[3]);
        }
        elseif($path_params[2]="category"){
            delete_category($path_params[3]);
        }
    }

}
else{
    echo"<errors><error>Incorect usage of REST API Please read documentation!</error></errors>";

}

