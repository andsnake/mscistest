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
      <link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">

      <style>
          .scroll-pane { overflow: auto; width: 99%; float:left; }
          .scroll-content { width: 2000px; height:500px ; float: left; }
          .scroll-content-item { width: 150px; height: 100px; float: left; margin: 10px; font-size: 3em;/* line-height: 96px; text-align: center;*/ }
          .scroll-bar-wrap { clear: left; padding: 0 4px 0 2px; margin: 0 -1px -1px -1px; }
          .scroll-bar-wrap .ui-slider { background: none; border:0; height: 2em; margin: 0 auto; }
          .scroll-bar-wrap .ui-handle-helper-parent { position: relative; width: 100%; height: 100%; margin: 0 auto; }
          .scroll-bar-wrap .ui-slider-handle { top:.2em; height: 1.5em; }
          .scroll-bar-wrap .ui-slider-handle .ui-icon { margin: -8px auto 0; position: relative; top: 50%; }
          .ui-widget textarea, .ui-widget button {
              font-family: Verdana,Arial,sans-serif;
              font-size: 1.5rem;
          }
          .ui-widget-header {
              border: 1px solid #AAA;
              background: url('') repeat-x scroll 50% 50% #CCC;
              color: #222;
              font-weight: bold;
          }
      </style>
    <!--link href="FrontEnd/sources/css/CSStooltip.css" rel="stylesheet" -->
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
      <script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>


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
            <!-- <div class="col-sm-3 col-md-3 pull-right breadcrumb alert-info">
             <!-- <form class="navbar-form" role="search">
                 <div class="input-group">
                     <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">
                     <div class="input-group-btn">
                         <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                     </div>
                 </div>
                 </form>
                 </div>-->
	  <div id="Content">
          <?php if(isset($_SESSION['username']) && $_SESSION['username']!=null){?>
          <script>
              $( document ).ready(function() {
                  show_Recomendations('<?= $_SESSION['username'] ?>');
              });
          </script>
          <?php } ?>
          <?php  $path_info = parse_path();
          //echo '<pre>'.print_r($path_info, true).'</pre>';
          //echo sacarXss("testeando javascript:alert('hola');");
          ?>
          <div id="page-content"><?php get_page( $path_info);?></div>
      <!-- START THE FEATURETTES -->

      <hr class="featurette-divider">

      <div class="row featurette">
          <div class="row"><div id="recommendations" ></div></div>
        <div class="col-md-7">
          <h2 class="featurette-heading">Adverstiments. <span class="text-muted"></span></h2>
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
        <?php
        //testing encyption
        /*$key = 'AESF#$%>13557SEEDg';
        $string = 5000.055;

        $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
        $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5($key))), "\0");

        var_dump($encrypted);
        var_dump($decrypted);*/
        ?>

      </footer>

    </div>
    </div><!--/.Content -->
    <!-- /.container -->

    <!-- Actions Modal(login etc) -->
    <?php include("FrontEnd/action_modal.php"); ?>




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
    //enable tooltips
	$(document).ready(function (){
    $('[data-toggle="tooltip"]').tooltip({'placement': 'right'});
  });
    function show_Recomendations(user){
        var dataString = "username="+user;
        $.ajax({
            type: "POST",
            url: "FrontEnd/recommend.php",
            data: dataString,
            beforeSend: function()
            {
                //$('html, body').animate({scrollTop:0}, 'slow');
                $("#recommendations").html('<img src="loading.gif" align="absmiddle" alt="Loading..."> Loading...<br clear="all" /><br clear="all" />');
            },
            success: function(response)
            {
                $("#recommendations").html(response);
                //alert(response);
            },
            error: function(xhr, textStatus, errorThrown){
                //alert('request failed'+errorThrown);
            }
        });
    }



</script>

  <script>
      //Recommender Slider
      $(function() {
//scrollpane parts
          var scrollPane = $( ".scroll-pane" ),
              scrollContent = $( ".scroll-content" );
//build slider
          var scrollbar = $( ".scroll-bar" ).slider({
              slide: function( event, ui ) {
                  if ( scrollContent.width() > scrollPane.width() ) {
                      scrollContent.css( "margin-left", Math.round(
                          ui.value / 100 * ( scrollPane.width() - scrollContent.width() )
                      ) + "px" );
                  } else {
                      scrollContent.css( "margin-left", 0 );
                  }
              }
          });
//append icon to handle
          var handleHelper = scrollbar.find( ".ui-slider-handle" )
              .mousedown(function() {
                  scrollbar.width( handleHelper.width() );
              })
              .mouseup(function() {
                  scrollbar.width( "100%" );
              })
              .append( "<span class='ui-icon ui-icon-grip-dotted-vertical'></span>" )
              .wrap( "<div class='ui-handle-helper-parent'></div>" ).parent();
//change overflow to hidden now that slider handles the scrolling
          scrollPane.css( "overflow", "hidden" );
//size scrollbar and handle proportionally to scroll distance
          function sizeScrollbar() {
              var remainder = scrollContent.width() - scrollPane.width();
              var proportion = remainder / scrollContent.width();
              var handleSize = scrollPane.width() - ( proportion * scrollPane.width() );
              scrollbar.find( ".ui-slider-handle" ).css({
                  width: handleSize,
                  "margin-left": -handleSize / 2
              });
              handleHelper.width( "" ).width( scrollbar.width() - handleSize );
          }
//reset slider value based on scroll content position
          function resetValue() {
              var remainder = scrollPane.width() - scrollContent.width();
              var leftVal = scrollContent.css( "margin-left" ) === "auto" ? 0 :
                  parseInt( scrollContent.css( "margin-left" ) );
              var percentage = Math.round( leftVal / remainder * 100 );
              scrollbar.slider( "value", percentage );
          }
//if the slider is 100% and window gets larger, reveal content
          function reflowContent() {
              var showing = scrollContent.width() + parseInt( scrollContent.css( "margin-left" ), 10 );
              var gap = scrollPane.width() - showing;
              if ( gap > 0 ) {
                  scrollContent.css( "margin-left", parseInt( scrollContent.css( "margin-left" ), 10 ) + gap );
              }
          }
//change handle position on window resize
          $( window ).resize(function() {
              resetValue();
              sizeScrollbar();
              reflowContent();
          });
//init scrollbar size
          setTimeout( sizeScrollbar, 10 );//safari wants a timeout
      });
  </script>


  </body>
</html>