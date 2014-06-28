<?php
/**
 * Created by PhpStorm.
 * User: George
 * Date: 6/25/14
 * Time: 1:37 PM
 */
session_start();
include "../Core/config.php";
$script="<script type='text/javascript'>$(document).ready(function() {
    $('#loginForm').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        submitHandler: function(validator, form, submitButton) {
            login();
            //$('#checkout_modal').modal('show');
            return false;
            /*$.post(form.attr('action'), form.serialize(), function(result) {
                // The result is a JSON formatted by your back-end
                // I assume the format is as following:
                //  {
                //      valid: true,          // false if the account is not found
                //      username: 'Username', // null if the account is not found
                //  }
                if (result.valid == true || result.valid == 'true') {
                    // You can reload the current location
                    window.location.reload();

                    // Or use Javascript to update your page, such as showing the account name
                    // $('#welcome').html('Hello ' + result.username);
                } else {
                    // The account is not found
                    // Show the errors
                    $('#errors').html('The account is not found').removeClass('hide');

                    // Enable the submit buttons
                    $('#loginForm').bootstrapValidator('disableSubmitButtons', false);
                }
            }, 'json');*/
        },
        fields: {
            username: {
                validators: {
                    notEmpty: {
                        message: 'The username is required'
                    },
                    stringLength: {
                        min: 6,
                        max: 12,
                        message: 'The username must be more than 6 and less than 12 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_]+$/,
                        message: 'The username can only consist of alphabetical, number and underscore'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'The password is required'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The password must be more than 6 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_]+$/,
                        message: 'The password can only consist of alphabetical, number and underscore'
                    }
                }
            }
        }
    });
    //login();
});</script>";
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
                        </form>".$script;



/*function strip_Characters($var){
    $string = preg_replace('/[^\p{L}\p{N}\s]/u', '', $var);
    return $string;
}

function check_invalid_input($var){
    if(preg_match('[\W]',$var))//[^\w\*]
        return false;
    else return true;
}*/

if(isset($_POST['username'])&& isset($_POST['password']) && ($_POST['username']!=null) && ($_POST['password'])!=null ){
    if(empty($_POST['username']) || empty($_POST['password']) ){
        echo $form;
        echo " Please check your input and try again!";
    }
    else {
        $username=stripslashes($_POST['username']);
        $password=stripslashes($_POST['password']);
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
            else{
                echo "Wrong Credentials Detected!".get_answer($username,$password);
                echo $form;
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
