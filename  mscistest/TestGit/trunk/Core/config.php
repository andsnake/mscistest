<?php
/**
 * Created by PhpStorm.
 * User: George
 * Date: 6/5/14
 * Time: 6:00 PM
 * Database Configuration File
 */

include("xss.php");
define('HOST',"127.0.0.1");
define('USER',"root");
define('PASSWORD',"");
define('DB',"eshop");
define('ROOT',"TestGit");

/* opens the connection to the database*/
function initConn(){
    $conn = mysql_connect(HOST,USER,PASSWORD,DB);
       if (!$conn) {
           die('Could not connect: ' . mysql_error());
        }
        else {
            return $conn;
        }

}

/* close current connection */
function closeConn($conn){
    mysql_close($conn);
}
/* clean strings from special characters*/
function clean($string) {
    //$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}
function check_login($var){
    $v="false";
    $uname=null;
    if($var==null){
        if(isset($_SESSION['username'])){
            $uname=$_SESSION['username'];
        }

    }else{
        $uname=$var;
    }
    if($uname!=null){
        //$username=stripcslashes($_SESSION['username']);
        $username=stripcslashes($uname);
        $url = 'http://'.HOST.'/'.ROOT.'/Core/RestServices/User.php/user/'.$username."/";

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
        if(isset($xml->error))
            $v="false";
        else
            $v="true";

    }
    return $v;

}

function parse_path() {
    if(isset( $_SERVER['REQUEST_URI'])){
        $path = $_SERVER['REQUEST_URI'];
    }
    if ($path != null) {
        $path_params = explode("/", $path);
    }

    if (isset($_GET['page'])){
        $path_params=$_GET['page'];
    }
    else $path_params=null;
    $path_params=strip_tags(preg_replace("/[^[:alnum:][:punct:]]/","",htmlspecialchars($path_params)));
    $path_params=filter_var($path_params, FILTER_SANITIZE_STRING);
    $path_params=sacarXss($path_params);
    return $path_params;

}

function get_page($path_info){
    //$path_info=preg_replace("/[^A-Za-z0-9]/","",$path_info);
    $path_info=preg_replace("/[^[:alnum:][:punct:]]/","",htmlspecialchars($path_info));
    $path_info=filter_var($path_info, FILTER_SANITIZE_STRING);
    if($path_info=="category"){
        include 'FrontEnd/category.php';
    }
    elseif($path_info=="user"){
        include 'FrontEnd/user.php';
    }
    elseif($path_info=="register"){
        include 'FrontEnd/register.php';
    }
    elseif($path_info=="logout"){
        include 'FrontEnd/logout.php';
    }
    else{
        include 'FrontEnd/front.php';
    }
    /*switch($path_info) {
        case 'category': include BD.'/FrontEnd/category.php';
            break;
        case 'users': include BD.'/FrontEnd/users.php';
            break;
        case 'news': include BD.'/FrontEnd/news.php';
            break;
        case 'products': include BD.'/FrontEnd/products.php';
            break;
        case null:
            include 'FrontEnd/front.php'; break;
    }*/
}

define('DR', $_SERVER['DOCUMENT_ROOT']);
define('BD', str_replace(DR, '', dirname($_SERVER['SCRIPT_FILENAME'] . '/')));