<?php
/**
 * Created by PhpStorm.
 * User: George
 * Date: 6/25/14
 * Time: 1:37 PM
 */
session_start();
include "../Core/config.php";
$form="<h2 class='form-signin-heading'>Please sign in</h2>
                        <form  id='loginForm' method='post' class='form-horizontal'>
                            <div class='form-group'>
                                <label class='col-md-3 control-label'>Username</label>
                                <div class='col-md-5'>
                                    <input type='text' class='form-control' name='username' />
                                </div>
                            </div>
                            <div class='form-group'>
                                <label class='col-md-3 control-label'>Password</label>
                                <div class='col-md-5'>
                                    <input type='password' class='form-control' name='password' />
                                </div>
                            </div>
                            <div class='form-group'>
                                <div class='col-md-5 col-md-offset-3'>
                                    <button name ='login_submit' type='submit' class='btn btn-primary'>Login</button>
                                </div>
                            </div>
                        </form>";



function strip_Characters($var){
    $string = preg_replace('/[^\p{L}\p{N}\s]/u', '', $var);
    return $string;
}

function check_invalid_input($var){
    if(preg_match('[\W]',$var))//[^\w\*]
        return false;
    else return true;
}

if(isset($_POST['username'])&& isset($_POST['password']) && ($_POST['username']!=null) && ($_POST['password'])!=null ){
    if(empty($_POST['username']) || empty($_POST['password']) ){
        echo $form;
        echo " Please check your input and try again!";
    }
    else {
        $username=stripcslashes($_POST['username']);
        $password=stripcslashes($_POST['password']);
       /* if(check_invalid_input($username)==true || check_invalid_input($password)==true){
            echo $form;
            echo "Invalid characters where detected!".$username.$password;
        }
        else*/ {
            $result=check_login($username);
            if($result=="true"){
                if(get_answer($username,$password)=="true"){
                    if(!isset($_SESSION['checkout']) || empty($_SESSION['checkout'])){
                        echo "welcome back!";

                    }
                    else{
                        $_SESSION['checkout']=true;
                    }
                    $_SESSION['username']=$username;


                }
                else {
                    echo "Wrong Credentials Detected!";
                    echo $form;
                }
            }
        }
    }
}

function get_answer($username,$password){
    $url = 'http://'.HOST.'/'.ROOT.'/Core/RestServices/User.php/user/'.$username."/".$password."/";
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
        if($user->answer=="true"){
            $answer="true";
            break;
        }
    }

  return $answer;
}
