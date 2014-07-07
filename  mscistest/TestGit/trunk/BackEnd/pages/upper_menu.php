<div class="navbar navbar-inverse navbar-static-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Administrate your eShop</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="index.php">Home</a></li>
                <?php
                if(isset($_SESSION['admin'])){
                    ?>
                    <li><a href="?action=logout">Logout</a></li>
                    </li>


                <?php } else {?>

                <?php }?>
                <li><a data-toggle="modal" data-target="#myModal" href="#about">Πληροφορίες για εμάς</a></li>
            </ul>
        </div>
    </div>
</div>
<?php
/**
 * Created by George Antoniou.
 * Date: 7/6/14
 * Time: 5:04 PM
 * upper_menu.php
 * To change this template use File | Settings | File Templates.
 */
