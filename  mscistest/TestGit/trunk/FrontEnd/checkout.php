<?php
/**
 * Created by PhpStorm.
 * User: George
 * Date: 6/28/14
 * Time: 12:26 AM
 */

//handle ajax reguest
if(isset($_POST['checkout_submit'])){
    if(isset($_SESSION['cart']) && $_SESSION['cart']!=null && isset($_SESSION['username']) && $_SESSION['username']!=null){
        $url = 'http://'.HOST.'/'.ROOT.'/Core/RestServices/Order.php/add/'.get_User_ID($_SESSION['username']);
        $data = "<order>";
        foreach($_SESSION['cart'] as $item){
            $data.="<item>
                    <SKU>".$item['SKU']."</SKU>
                    <quantity>".$item['quantity']."</quantity>
                </item>";
        }
        $data.="</order>";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);
        //debugging stuff..
        /*echo var_dump($response);
        echo var_dump($data);
        echo $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        */
        curl_close($ch);
        $xml = simplexml_load_string($response);
        if(isset($xml->success)){
            header("Location: index.php?page=checkout&code=".htmlspecialchars($xml->code));
            //$_SESSION['OrderCode']=htmlspecialchars($xml->code);
            //echo "<div class='alert alert-info'>Order Added!. Here is your Order Code:".$xml->code."</div>";
            //$_POST=null;
        }
    }
}
if(isset($_GET['code'])){
    echo "<div class='alert alert-info'>Order Added!. Here is your Order Code:".$_GET['code']."</div>";
}
//var_dump($_GET);
function get_User_ID($username){
    $url = 'http://'.HOST.'/'.ROOT.'/Core/RestServices/User.php/user/'.$username."/";
    $answer="false";
    $client = curl_init($url);
    curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($client);
    curl_close($client);
    try{
        //$response='<test>'.$response.'/<test>';
        //echo $response;
        $xml = simplexml_load_string($response);
    }catch(Exception $e) {
        echo $e->getMessage();
    }
    foreach ($xml->user as $user) {
        $answer=$user->UID;
        break;
    }
    return $answer;
}