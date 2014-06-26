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
                    if(check_login($var)=="false"){ $action="Log In Needed";

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


                <p>To be Added!! (prepei na ginei prota to Order.php rest service...)</p>
                <?php }?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>

            </div>
        </div>
    </div>
</div>


<?php
/**
 * Created by PhpStorm.
 * User: George
 * Date: 6/25/14
 * Time: 12:12 PM
 */ 