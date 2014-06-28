<?php 
include "Core/config.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project eShop</title>
	<!-- Include External non-boostrap related js -->
    <script src="<?php echo BD; ?>/FrontEnd/sources/js/bannersJS.js"></script>
    <script src="<?php echo BD; ?>/FrontEnd/sources/js/shoppingCart.js"></script>
    <!-- Bootstrap -->
    <!-- <link href="<?php echo BD; ?>/FrontEnd/sources/css/bootstrap.min.css" rel="stylesheet">-->
    <link rel="stylesheet" href="<?php echo BD; ?>/FrontEnd/sources/css/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo BD; ?>/FrontEnd/sources/css/bootstrapValidator.min.css"/>
    <!--link href="FrontEnd/sources/css/CSStooltip.css" rel="stylesheet" -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <script src="<?php echo BD; ?>/FrontEnd/sources/js/menus.js"></script>

    <![endif]-->
    <!-- Custom styles for this template -->
    <link href="<?php echo BD; ?>/FrontEnd/sources/css/carousel.css" rel="stylesheet">
    <!--<link href="sources/css/shoppingCart.css" rel="stylesheet">-->
  </head>
  <body onload="show_cart()">
  <div id="upperwrapper" class="jumbotron" data-ride="carousel">
    <?php include "FrontEnd/index_menu.php" ?>
  </div>
    <!-- Carousel
    ================================================== -->
    <?php //include "FrontEnd/index_carousel.php"; ?>
    <!-- Carousel End
    ================================================== -->
    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->
        <div class="container marketing">
            <?php //unset($_SESSION['cart']); $counter=0;
            /*foreach($_SESSION['cart'] as $p=>$array){
                if($array['SKU']=="123456789AAA"){
                    $_SESSION['cart'] [$p]['quantity']=$_SESSION['cart'] [$p]['quantity']++;
                    $counter++;
                    break;
                }
                else{
                    $_SESSION['cart'][]=array("SKU"=>$SKU,"quantity"=>1,"price"=>$price);
                }
            }*/
            //var_dump($_SESSION['cart']);


            ?>


        <div id="response" align="center"></div>
        <div class="col-sm-3 col-md-3 pull-right breadcrumb alert-info">
            <form class="navbar-form" role="search">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                </div>
            </div>
            </form>
            </div>
	  <div id="Content">
          <?php  $path_info = parse_path();
          //echo '<pre>'.print_r($path_info, true).'</pre>';
          //echo sacarXss("testeando javascript:alert('hola');");
          ?>
          <div id="page-content"><?php get_page( $path_info);?></div>
      <!-- START THE FEATURETTES -->

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">Το πρώτο μας Διαφημιστικό banner. <span class="text-muted">It will (not) blow your mind.</span></h2>          
          <div class="centered">
        <!--layer for the banner rotator-->
        
        <div id="placeholderlayer"></div><div id="placeholderdiv"></div>
     </div>          
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette"></div>
      <div class="row featurette"></div>

      <!-- /END THE FEATURETTES -->


      <!-- FOOTER -->
      <footer>
        <p class="pull-right"><a href="#">Back to top</a></p>
        <p>© 2014 Company, Inc. · <a href="#">Privacy</a> · <a href="#">Terms</a></p>


      </footer>

    </div>
    </div><!--/.Content -->
    <!-- /.container -->

    <!-- Actions Modal(login etc) -->
    <?php include("FrontEnd/action_modal.php"); ?>


    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="FrontEnd/sources/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo BD; ?>/FrontEnd/sources/js/bootstrapValidator.js"></script>
    <script type="text/javascript" src="<?php echo BD; ?>/FrontEnd/sources/js/loginValidator.js"></script>
    <script type="text/javascript" src="<?php echo BD; ?>/FrontEnd/sources/js/registerValidator.js"></script>
    <script type="application/javascript">
	function show (elem) {  
    	elem.style.display="block";
	}
	function hide (elem) { 
		elem.style.display=""; 
	}
	$(document).ready(function (){
    $('[data-toggle="tooltip"]').tooltip({'placement': 'right'});
  });
</script>

    
  </body>
</html>