<?php
session_start();
include "../Core/config.php";
include "actions.php";
$menu=false;
//unset($_SESSION['admin']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Off Canvas Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="sources/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="sources/css/offcanvas.css" rel="stylesheet">
    <link href="sources/css/shopping/products.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]> -->
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <link rel="stylesheet" href="../FrontEnd/sources/css/bootstrapValidator.min.css"/>
    <script type="text/javascript" src="../FrontEnd/sources/js/bootstrapValidator.js"></script>
    <![endif]-->
</head>

<body>
<div class="navbar-wrapper">
    <div class="container">

        <?php
        include "pages/upper_menu.php";
        ?>
    </div>
</div>
<div class="container">

    <div class="row row-offcanvas row-offcanvas-right">
        <!--main column -->
        <div class="col-xs-12 col-sm-9">
            <!-- toggle  menu button -->
            <p class="pull-right visible-xs">
                <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Μενού</button>
            </p>
            <!-- toggle  menu button  end-->
            <!-- jumbbotton start- (display welcoming messages etc place) -->
            <div class="jumbotron">
                <?php

                if (!isset($_SESSION['admin']) || $_SESSION['admin']==null){
                    include "pages/login.php";
                }

                else { //echo "asdadasdad";var_dump($_SESSION);
                    $menu=true;
                    //include"pages/home.php";
                    $path_info = parse_admin_path();
                    get_admin_page( $path_info);
                } ?>
                <div id="response"> </div>

            </div>

            <!-- welcoming place end-->
            <!-- Products Grid-->

            <!--/span--><!--/span--><!--/span--><!--/span--><!--/span--><!--/span-->

        </div><!--/span-->

        <?php if($menu!=false){ ?>

        <!--products Menu -->
        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
            <div class="list-group">
                <!-- Shopping Cart Start -->

                <!-- Cart End -->
                <a href="#" class="list-group-item active">Options</a>
                <a href="#" class="list-group-item">Add Item</a>
                <a href="index.php?action=search" class="list-group-item">Search Item</a>
                <a href="#" class="list-group-item">Link</a>
                <a href="#" class="list-group-item">Link</a>
                <a href="#" class="list-group-item">Link</a>
                <a href="#" class="list-group-item">Link</a>
                <a href="#" class="list-group-item">Link</a>
                <a href="#" class="list-group-item">Link</a>
                <a href="#" class="list-group-item">Link</a>
            </div>
        </div><!--/span-->
        <!-- products menu end -->
        <?php } ?>
    </div><!--/row-->

    <hr>

    <footer>
        <p>&copy; Company 2014</p>
    </footer>

</div><!--/.container-->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Πληροφορίες</h4>
            </div>
            <div class="modal-body">
                <p>Είμαστε ο Γιώργος Αντωνίου και ο Ηλίας Μπουτσικάκης.
                    Ελπίζουμε οι ασκήσεις να είναι υλοποιημένες με τρόπο ικανοποιητικό.
                    Ευχαριστούμε που πατήσατε για να δείτε ποιοι έφτιαξαν αυτές τις σελίδες</p>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>

            </div>
        </div>
    </div>
</div>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="http://code.jquery.com/jquery-1.11.0.min.js" ></script>  -->
<script src="sources/js/jquery-ui-1.10.4.custom.min.js"></script>
<script src="sources/js/bootstrap.min.js"></script>
<script src="sources/js/offcanvas.js"></script>
<script src="sources/js/shopping/products.js"></script>
<script type="application/javascript">
    function show (elem) {
        elem.style.display="block";
    }
    function hide (elem) {
        elem.style.display="";
    }
    //enable tooltips
    $(document).ready(function (){
        $('[data-toggle="tooltip"]').tooltip({'placement': 'right'});
    });
</script>

</body>
</html>
