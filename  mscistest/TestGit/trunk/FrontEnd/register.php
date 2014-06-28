<?php
/**
 * Created by PhpStorm.
 * User: George
 * Date: 6/26/14
 * Time: 8:42 PM
 */

$form='<h2 class="form-signup-heading">Please fill in your details</h2>
    <form  id="registerForm" method="post" class="form-horizontal">
        <div class="form-group">
            <label class="col-md-3 control-label">Username</label>
            <div class="col-md-5">
                <input type="text" class="form-control" name="username" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Password</label>
            <div class="col-md-5">
                <input type="password" class="form-control" name="password" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Email</label>
            <div class="col-md-5">
                <input type="text" class="form-control" name="email" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">First Name</label>
            <div class="col-md-5">
                <input type="text" class="form-control" name="name" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Surname</label>
            <div class="col-md-5">
                <input type="text" class="form-control" name="surname" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Phone Number</label>
            <div class="col-md-5">
                <input type="text" class="form-control" name="phone" />
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-5 col-md-offset-3">
                <button name ="login_submit" type="submit" class="btn btn-primary">Login</button>
            </div>
        </div>
    </form>';

if(isset($_SESSION['username'])){
    //redirect user to homepage ( or to profile page when that is done)
    header("Location: index.php");
}

//handle request(ajax etc...)
if(isset($_POST['username'])&& isset($_POST['password']) && ($_POST['username']!=null) && ($_POST['password'])!=null ){
    if( isset($_POST['email']) && ($_POST['email']!=null) && isset($_POST['phone']) && ($_POST['phone'])!=null && isset($_POST['name'])&& ($_POST['name']!=null)){
        //var_dump($_POST);
        include "../Core/config.php";
        $alert=false;
        $errors=array();
        //time for some basic validation
        $var= filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        if($var==false){
            //we just caught a malicious motherfucker!
            $alert=true;
        }
        else{
            $email=filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        }
        if(filter_var($_POST['phone'], FILTER_VALIDATE_INT)){
            $phone=filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_INT);
        }
        else{
            $alert=true;
        }
        if(check_invalid_input(strip_Characters($_POST['username'])) && check_invalid_input(strip_Characters($_POST['password'])) && check_invalid_input(strip_Characters($_POST['name'])) && check_invalid_input(strip_Characters($_POST['surname']))){
            $username=strip_Characters($_POST['username']);
            $password=strip_Characters($_POST['password']);
            $name=strip_Characters($_POST['name']);
            $surname=strip_Characters($_POST['surname']);
            $errors['username']=check_invalid_input(strip_Characters($_POST['username']));
            $errors['password']=check_invalid_input(strip_Characters($_POST['password']));
            $errors['name']=check_invalid_input(strip_Characters($_POST['name']));
            $errors['surname']=check_invalid_input(strip_Characters($_POST['surname']));
        }else $alert=true;

        if($alert==false){
            register($username,$password,$name,$surname,$email,$phone,$errors);
        }
        else{
            echo "    <div class='alert alert-warning'>
    <strong>OOOPS!</strong> We are sorry, something seemed not to be right with your request.. :(
    </div>";
            //echo $form;
        }
    }

}else{  echo $form;  //default action ==>show form?>

    <!--<script type="text/javascript" src="<?php echo BD; ?>/FrontEnd/sources/js/registerValidator.js"></script>-->
<?php } ?>
<?php

//send user data to REST service and add user to database
function register($username,$password,$name,$surname,$email,$phone,$errors){
    $url = 'http://'.HOST.'/'.ROOT.'/Core/RestServices/User.php/user/add/';
    $data = "<users>
                <user>
                    <username>$username</username>
                    <password>$password</password>
                    <email>$email</email>
                    <name>$name</name>
                    <surname>$surname</surname>
                    <phone>$phone</phone>
                </user>
             </users>";

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
    try{
        //$response='<test>'.$response.'/<test>';
        //echo $response;
        $xml = simplexml_load_string($response);
    }catch(Exception $e) {
        //echo $e->getMessage();
    }
    if(isset($xml->error)){
        echo "    <div class='alert alert-warning'>
    <strong>OOOPS!</strong> We are sorry, $xml->error.. :( Please Try Again...
    </div>";
    }
    else{
        //echo var_dump($xml);
        echo "    <div class='alert alert-info'>
    <strong>Welcome to our community :)</strong> <pre> You can now use your Credentials to login and Order!</pre>
    </div>";
    }
}