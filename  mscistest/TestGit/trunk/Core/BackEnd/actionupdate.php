<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <script type="text/javascript" src="validate.js"></script>          //na doume ligo ti kanei ayto to validate
    <meta name="Description" content="Information architecture, Web Design, Web Standards." />
    <meta name="Keywords" content="your, keywords" />
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="Distribution" content="Global" />
    <meta name="Robots" content="index,follow" />

    <link rel="stylesheet" href="images/Azulmedia.css" type="text/css" />       //fantazomai edo prepei na valoume to css alla den ksero poio

    <title>Magazi Management v0.1 - oute ksero ti grafw</title>
</head>
<body>
<!-- wrap starts here -->
<div id="wrap">
    <div id="header">

        <h1 id="logo">Client<span class="gray">Management</span></h1>
        <h2 id="slogan">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Management of the database. . .  &nbsp;&nbsp;&nbsp;   efficiently!!</h2>

        <!-- Menu Tabs -->
        <div id="menu">
            <ul>
                <li id="current"><a href="index.html">Home</a></li>
                <li><a href="about.html">About</a></li>             //about??
            </ul>
        </div>

    </div>
    <!-- content-wrap starts here -->
    <div id="content-wrap">
        <div id="sidebar" >

            <h1 class="clear">Control Panel</h1>
            <ul class="sidemenu">
                <li><a href="insert.html">Insert</a></li>
                <li><a href="delete.php">Delete</a></li>
                <li><a href="update.php">Update</a></li>
            </ul>

            <h1>Display Panel</h1>
            <ul class="sidemenu">
                <li><a href="display.php">Display products</a></li>
            </ul>
        </div>

        <div id="main">
            <div class="box">
                <h3>Product for delete:</h3>                        // i diagrafi tou product
                <?php
                $code= $_REQUEST["code"];

                $con = mysql_connect("localhost","root","");
                if (!$con)
                {
                    die('Could not connect: ' . mysql_error());
                }

                mysql_select_db("product", $con);

                $sql= "select * from product where code='$code'";
                $result= mysql_query($sql);
                echo "<table border=0 cellspacing=5 cellpadding=5>";
                echo "<tr>";
                echo "<td>" . "<b>Code<b>". "</td>";                    //na do edo pera poia einai ta pedia pou exei mesa to product
                echo "<td>" . "<b>Surname<b>" . "</td>";                //kai na ta allakso antistoixa
                echo "<td>" . "<b>Name<b>" . "</td>";
                echo "<td>" . "<b>Credit<b>" . "</td>";
                echo "<td>" . "<b>Phone<b>" . "</td>";
                echo "<td>" . "<b>City<b>" . "</td>";
                echo "</tr>";
                while($row = mysql_fetch_array($result))
                {
                    echo "<tr>";
                    echo "<td>" . $row['code'] . "</td>";
                    echo "<td>" . $row['surname'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['credit'] . "</td>";
                    echo "<td>" . $row['phone'] . "</td>";
                    echo "<td>" . $row['city'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                mysql_close($con);
                ?>
                <form  name="form" action="deleteone.php" onsubmit="javascript:return ValidateForm(this)">          //ayto den exo ktlvei ti kanei
                    <p><strong>	Select the features you want to update:</strong>
                    <p>
                        <label>Features: </label>
                        <b>Code </b>&nbsp
                        <input name="code" type="checkbox" />&nbsp
                        <b>Surname </b>&nbsp
                        <input name="code" type="checkbox" />&nbsp
                        <b>Name </b>&nbsp
                        <input name="code" type="checkbox" />&nbsp
                        <b>Credit </b>&nbsp
                        <input name="code" type="checkbox" />&nbsp
                        <b>Phone </b>&nbsp
                        <input name="code" type="checkbox" />&nbsp
                        <b>City </b>&nbsp
                        <input name="code" type="checkbox" />&nbsp
                        <br>
                        <br />
                        <input class="button" type="submit" value = "Submit"/>
                    </p>
                </form>
            </div>
        </div>
        <!-- content-wrap ends here -->
    </div>
    <!-- wrap ends here -->
</div>
<!-- footer starts here -->
<div id="footer-wrap">
    <div class="footer-left">
        <p class="align-left">
            &copy; 2014 <strong>Ant&Bouts Corp.</strong>
        </p>
    </div>
</div>
<!-- footer ends here -->

</body>
</html>
