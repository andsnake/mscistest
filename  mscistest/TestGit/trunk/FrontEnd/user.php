<?php
/**
 * Created by George Antoniou.
 * Date: 7/2/14
 * Time: 8:04 PM
 * user.php
 * To change this template use File | Settings | File Templates.
 */
//
if(isset($_POST['submit'])){
    //var_dump($_POST);
    //session_start();
    include "../Core/config.php";
    $u=getUser($_POST['username']);
    edit($_POST['username'],$_POST['password'],$_POST['name'],$_POST['surname'],$_POST['email'],$_POST['phone'],$_POST['UID'],$u['salt']);
}

if(isset($_SESSION['username']) && $_SESSION['username']!=null){
    $user=getUser($_SESSION['username']) ;
    $username=$_SESSION['username'];
    //var_dump($user);
    $form='<h2 class="form-signup-heading">Please fill in your details</h2>
    <form  id="userForm" method="post" action="index.php?page=user" class="form-horizontal">
        <div class="form-group">
            <label class="col-md-3 control-label">Username</label>
            <div class="col-md-5">
                <input disabled type="text" class="form-control" name="username" value="'.$username.'" />
                <input type="hidden" class="form-control" name="username" value="'.$username.'" />
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
                <input type="text" class="form-control" name="email"  value="'.$user['email'].'" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">First Name</label>
            <div class="col-md-5">
                <input type="text" class="form-control" name="name" value="'.$user['name'].'"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Surname</label>
            <div class="col-md-5">
                <input type="text" class="form-control" name="surname" value="'.$user['surname'].'" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Phone Number</label>
            <div class="col-md-5">
                <input type="text" class="form-control" name="phone" value="'.$user['phone'].'"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-5 col-md-offset-3">
                <button name ="submit" type="submit" id="submit" class="btn btn-primary">Submit Changes</button>
            </div>
        </div>
        <input type="hidden" value="'.$user['UID'].'" name="UID" />
    </form>';
    echo $form;
    $_SESSION['UID']=$user['UID'];




}


function getUser($username){
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
    $arr=null;
    foreach ($xml->user as $user) {
        $arr['salt']=htmlspecialchars($user->salt);
        $arr['password']=htmlspecialchars($user->password);
        $arr['name']=htmlspecialchars($user->name);
        $arr['surname']=htmlspecialchars($user->surname);
        $arr['email']=htmlspecialchars($user->email);
        $arr['phone']=htmlspecialchars($user->phone);
        $arr['UID']=htmlspecialchars($user->UID);
        $arr['username']=htmlspecialchars($user->username);
    }
    return $arr;

}

function edit($username,$password,$name,$surname,$email,$phone,$UID,$salt){
    $url = 'http://'.HOST.'/'.ROOT.'/Core/RestServices/User.php/user/edit/';
    $data = "<users>
                <user>
                    <UID>$UID</UID>
                    <username>$username</username>
                    <password>$password</password>
                    <email>$email</email>
                    <name>$name</name>
                    <surname>$surname</surname>
                    <phone>$phone</phone>
                    <salt>$salt</salt>
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
    <strong>User Information edited </strong> <pre>:) </pre>
    </div>";
    }
}