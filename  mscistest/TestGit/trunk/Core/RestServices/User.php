<?php
/**
 * Created by PhpStorm.
 * User: George
 * Date: 6/24/14
 * Time: 2:00 PM
 */
include "../config.php";
include "../CoreClasses/Users.php";

// Set the content type to text/xml
header ("Content-Type:text/xml");
$users=new \CoreClasses\Users(initConn());

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

function VerifyMailAddress($address){
    $Syntax='#^[w.-]+@[w.-]+.[a-zA-Z]{2,5}$#';
    if(preg_match($Syntax,$address))
        return true;
    else
        return false;
}


function add_User(){
    global $users;
    $result=null;
    $err=null;
    $input = file_get_contents("php://input");
    $xml = simplexml_load_string($input);
    $details=array();
    foreach ($xml->user as $user) {
        $details['username']=$user->username;
        $details['password']=htmlspecialchars($user->password);
        $details['email']=$user->email;
        $details["name"]=$user->name;
        $details["surname"]=$user->surname;
        $details["phone"]=$user->phone;
        if(empty($details['username']) || empty($details['password']) || empty($details['email'])){
            $err="Required values were empty";
        }
        elseif(!filter_var($details['email'], FILTER_VALIDATE_EMAIL)){
            $err="Not a valid email format ".$details['email'];
        }
        elseif(!preg_match("/^[0-9]+$/", $details['phone'])){
            $err="Not a valid phone format".ctype_digit($details['phone']);
        }
        if($err==null){
            $result=$users->add_User($details);
            if(check_Response($result)==true){
                echo "<response>
                         <success>'User added'</success>
                      </response>";
            }
            else{
                $err=$result['error'];
                echo "<response><error>$err</error></response>";
            }
        }else{
            echo "<response><error>$err</error></response>";
        }
    }
}

function edit_User(){
    global $users;
    $result=null;
    $err=null;
    $input = file_get_contents("php://input");
    $xml = simplexml_load_string($input);
    $details=array();
    foreach ($xml->user as $user) {
        $details['UID']=$user->UID;
        $details['username']=$user->username;
        $details['password']=$user->password;
        $details['email']=$user->email;
        $details["name"]=$user->name;
        $details["surname"]=$user->surname;
        $details["phone"]=$user->phone;
        if(empty($details['username']) || empty($details['password']) || empty($details['email'])){
            $err="Required values were empty";
        }
        elseif(!filter_var($details['email'], FILTER_VALIDATE_EMAIL)){
            $err="Not a valid email format ".$details['email'];
        }
        elseif(!preg_match("/^[0-9]+$/", $details['phone'])){
            $err="Not a valid phone format";
        }
        elseif(!preg_match("/^[0-9]+$/", $details['UID'])){
            $err="Invalid Action";
        }
        if($err==null){
            $result=$users->edit_User($details);
            if(check_Response($result)==true){
                echo "<response><success>'User edited'</success></response>";
            }
            else{
                $err=$result['error'];
                echo "<response><error>$err</error></response>";
            }
        }else{
            echo "<response><error>$err</error></response>";
        }
    }
}

function get_User($username){
    global $users;
    $user=$users->get_User($username) ;
   // print_r( $array);
    echo"<users>";
    if(is_array($user)){
        if(array_key_exists('success',$user)){
            $uname=$user['username'];
            /*foreach($array as $user)*/{
                if($uname!=null){
                    echo"<user>";
                    echo"<UID>$user[UID]</UID>";
                    echo"<username>".$user['username']."</username>";
                    echo"<saltedpassword>".md5(htmlspecialchars($user['password']).$user['salt'])."</saltedpassword>";
                    echo"<saltedpassword>".md5($user['password'].$user['salt'])."</saltedpassword>";
                    echo"<password>$user[password]</password>";
                    echo"<salt>$user[salt]</salt>";
                    echo"<email>$user[email]</email>";
                    echo"<name>$user[name]</name>";
                    echo"<surname>$user[surname]</surname>";
                    echo"<phone>$user[phone]</phone>";
                    echo"<level>$user[level]</level>";
                    echo"</user>";
                }
                else{
                    echo"<error>Invalid Action!</error>";
                }

            }
        }
    }

    echo "</users>";
}
function check_if_exists($username,$password){
    global $users;
    $result= $users->get_User_Exists($username,$password);
    echo"<users>
            <user>";
    if($result=="false"){
        echo"<error>WTF?</error>";
    }
                echo"<answer>".$result.
                "</answer>
            </user>
        </users>";

}

function delete_User($username){
    global $users;
    $result=$users->delete_User($username);
    if(check_Response($result)==true){
        echo "<response><success>'User deleted'</success></response>";
    }else{
        $err=$result['error'];
        echo "<response><error>$err</error></response>";
    }

}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if ($path_params[1] != null && $path_params[2] != null ){
        if($path_params[1]=="user"){
            if($path_params[2]=="add"){
                add_User(); //done
            }
            elseif($path_params[2]=="edit"){
                edit_User(); //done
            }
        }
    }
}
elseif ($_SERVER['REQUEST_METHOD'] == 'GET'){
    if ($path_params[1] != null && $path_params[2] != null ){
        if($path_params[3]!=null){
            check_if_exists($path_params[2],$path_params[3]);
        }
        else{
            get_User($path_params[2]); //done
        }
    }
}
elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    if ($path_params[1] != null && $path_params[2] != null  && $path_params[3]!=null){
        if($path_params[2]=="remove"){
            delete_User($path_params[3]);
        }
    }
}