<div class="modal fade" id="checkout_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div id="modal-msg" class="modal-body">

                <?php
                    if(isset($_SESSION['username']))
                        $var=$_SESSION['username'];
                    else
                        $var=null;
                    if(check_login($var)=="false"){
                        $action="Log In Needed";

                ?>
                        <h2 class="form-signin-heading">Please sign in</h2>
                        <form  id="loginForm" method="post" class="form-horizontal">
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
                                <div class="col-md-5 col-md-offset-3">
                                    <button name ="login_submit" type="submit" class="btn btn-primary">Login</button>
                                </div>
                            </div>
                        </form>



                <?php    } else { ?>
                <h4>You have the following items in your shopping cart</h4>
                        <div id="checkout_contents">
                        </div>

                <?php $details=getUserDetails(); ?>
                <p class="alert alert-block alert-info">If you are ready to Order Submit the form below.<br><span>
                Please Note that if you wish to change your personal Information you can do it through the User Panel</span></p>
                <h2 class="form-signup-heading">Please Confirm your Details</h2>
                <form  id="checkoutForm" method="post" action="index.php?page=checkout" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-md-3 control-label">First Name</label>
                        <div class="col-md-5">
                            <input type="text" disabled class="form-control" name="username" value="<?= $details['name']?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Surname</label>
                        <div class="col-md-5">
                            <input type="text" disabled class="form-control" name="surname"value="<?= $details['surname']?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Email</label>
                        <div class="col-md-5">
                            <input type="text" disabled class="form-control" name="email" value="<?= $details['email']?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Phone Number</label>
                        <div class="col-md-5">
                            <input type="text" disabled class="form-control" name="phone" value="<?= $details['phone']?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Payment Method</label>
                        <div class="col-md-5">
                            <select id="selectbasic" name="selectbasic" class="input-large">
                                <option>Pay &amp; Pickup at the Store</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-5 col-md-offset-3" style="vertical-align: 200%">
                            <button name ="checkout_submit" type="submit" class="btn btn-primary">Order</button>
                        </div>
                    </div>
                </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
<?php }?>

<?php
/**
 * Created by PhpStorm.
 * User: George
 * Date: 6/25/14
 * Time: 12:12 PM
 */
function getUserDetails(){
    $username="";
    if(isset($_SESSION['username'])){
        $username=$_SESSION['username'];
    }
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
    foreach($xml->user as $users){
        $user['name']=$users->name;
        $user['surname']=$users->surname;
        $user['phone']=$users->phone;
        $user['email']=$users->email;
    }
    return $user;

}
