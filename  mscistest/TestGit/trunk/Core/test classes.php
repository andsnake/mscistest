<?php
/**
 * Created by PhpStorm.
 * User: George
 * Date: 6/5/14
 * Time: 7:18 PM
 */

include "CoreClasses/Products.php";
include "CoreClasses/Users.php";
include "CoreClasses/Orders.php";
include "config.php";
//$conn=initConn();
$products = new \CoreClasses\Products(initConn()); //using namespaces
$users=new \CoreClasses\Users(initConn());
$orders=new \CoreClasses\Orders(initConn());
$details=["SKU"=>"2234242wss23",
            "description"=>"test addition",
            "price"=>50,
            "stock"=>10,
            "category"=>array(1,2,3)
];
//$products->add_Product($details);
print_r( $products->delete_Product($details['SKU']) );
//print_r( $products->add_Product($details) );
print_r( $products->remove_Product_Category("aasefasr43432",array(2,3)) );
print_r( $products->set_Product_Cat("aasefasr43432",array(2,3)) );
print_r( $products->edit_Category(array("id"=>5,"parent"=>1, "name"=>"Horror")));
//$products->edit_Product("asdadadadaf8950",$details);

echo"How it looks using print_r \n";
//print_r($products->get_Cat_Products(1));

$cats[]=1;

/*$response=($products->set_Product_Cat($details['SKU'],$cats));
if (array_key_exists('error', $response)) {
    echo $response['error'];
}
else {
    echo $response['success'];
}*/
echo "\n";
echo "<table border='1'><tr><td>[SKU]</td><td>[description]</td><td>[price]</td><td>[stock]</td></tr>";
foreach($products->get_Cat_Products(1) as $p){
    echo " <tr><td>$p[SKU]</td><td>$p[description]</td><td>$p[price]</td><td>$p[stock]</td></tr>";
}
echo"</table>";

echo "<table border='1'><tr><td>[SKU]</td><td>[description]</td><td>[price]</td><td>[stock]</td></tr>";
foreach($products->get_All_Products() as $p){
    echo " <tr><td>$p[SKU]</td><td>$p[description]</td><td>$p[price]</td><td>$p[stock]</td></tr>";
}
//print_r($products->get_All_Products());
echo"</table>";
$details['username']="andsnake";
$salt = uniqid(mt_rand(), true);
$details['password']="unicorn";
$details['name']="george";
$details['surname']="antoniou";
$details['phone']=6947343012;
$details['email']="antoniougeo#gmail.com";

//print_r( $users->add_User($details) );
$details['UID']="10";
$salt = uniqid(mt_rand(), true);
$details['password']="unicorn";
$details['name']="george";
$details['surname']="antoniou";
$details['phone']=6947343012;
$details['email']="antoniougeo@gmail.com";
//print_r( $users->edit_User($details) );
//print_r( $users->get_User("andsnake") );
//print_r( $users->update_User_level("andsnake") );

$test=['0'=>array("SKU"=>"123456789AAA","quantity"=>2),
        '1'=>array("SKU"=>"2234242wss23","quantity"=>2)];
echo "<br>".date("Y-m-d H:i:s")." ----- ".date('Y-m-d H:i:s', strtotime("+4 days"))."</br>";


//print_r($orders->add_Order($test,1));
//if($test==true){echo"adasafsgsgs";}

/*if(is_array($test)==false) echo "Adasfastfqw";
print_r($orders->calculate_User_level(1));*/
$cclArray[0]['url']='test.html';
$cclArray[0]['entity_id']=9;
$cclArray[1]['url']='test1.html';
$cclArray[1]['entity_id']=10;
$cclArray[2]['url']='test2.html';
$cclArray[2]['entity_id']=11;


foreach ( $cclArray as $k => $array ) {
    if ( $array['url'] == 'test.html' ) {
        //unset($cclArray[$k]);
        $cclArray[$k]['url']="aaa";
    }
}


print_r($cclArray);

include "CoreClasses/Recommender.php";
$u=new \CoreClasses\Recommender(initConn());
var_dump($u->set_Current_User("andsnake3"));
//
var_dump($u->set_Other_Users());
echo"rankings :<br>";
$u->calculate_rankings();
var_dump($u->getOthers());
echo"recomendations <br>";
$p=($u->getRecomendations());
foreach($p as $i){
    echo "$i <br>";
}
echo"errors test-------------------- <br>";
/*var_dump*/($u->getError());
echo "-------------------- <br>";
//echo "users items <br>";
//var_dump( $u->getUserA()->getProducts() );

echo "-------------------- <br>";
