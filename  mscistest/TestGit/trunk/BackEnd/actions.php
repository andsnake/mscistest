<?php
/**
 * Created by George Antoniou.
 * Date: 7/6/14
 * Time: 6:54 PM
 * actions.php
 * To change this template use File | Settings | File Templates.
 */

function parse_admin_path() {
    if(isset( $_SERVER['REQUEST_URI'])){
        $path = $_SERVER['REQUEST_URI'];
    }
    if ($path != null) {
        $path_params = explode("/", $path);
    }

    if (isset($_GET['action'])){
        $path_params=$_GET['action'];
    }
    else $path_params=null;
    $path_params=strip_tags(preg_replace("/[^[:alnum:][:punct:]]/","",@htmlspecialchars($path_params)));
    $path_params=filter_var($path_params, FILTER_SANITIZE_STRING);
    $path_params=sacarXss($path_params);
    return $path_params;

}

function get_admin_page($path_info){
    //$path_info=preg_replace("/[^A-Za-z0-9]/","",$path_info);
    $path_info=preg_replace("/[^[:alnum:][:punct:]]/","",htmlspecialchars($path_info));
    $path_info=filter_var($path_info, FILTER_SANITIZE_STRING);
    if($path_info=="delete"){
        include 'pages/delete.php';
    }
    elseif($path_info=="search"){
        include 'pages/search.php';
    }
    elseif($path_info=="add"){
        include 'pages/add.php';
    }
    elseif($path_info=="edit"){
        include 'pages/edit.php';
    }
    elseif($path_info=="logout"){
        //include 'pages/edit.php';
        unset($_SESSION['admin']);
        header("location: index.php");
    }
    elseif($path_info=="images"){
        include 'pages/images.php';
    }
    elseif($path_info=="all"){
        include 'pages/all.php';
    }
    else{
        include 'pages/home.php';
    }
}