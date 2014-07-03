<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <script type="text/javascript" src="validate.js"></script>
    <meta name="Description" content="Product administration, product, admin." />
    <meta name="Keywords" content="your, keywords" />
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="Distribution" content="Global" />
    <meta name="Robots" content="index,follow" />
    <link rel="stylesheet" href="images/Azulmedia.css" type="text/css" />                   //CSS
    <title>Magazi Management v0.1</title>
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
                <li><a href="about.html">About</a></li>
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
                <li><a href="display.php">Display clients</a></li>
            </ul>
        </div>
        <div id="main">
            <div class="box">
                <h3>Your products are : </h3>
                <?php

                $con = mysql_connect("localhost","root","");
                if (!$con)
                {
                    die('Could not connect: ' . mysql_error());
                }
                mysql_select_db("product", $con);
                $sql= "SELECT code, surname, name, phone FROM clients order by code";           //uhmmm, xreiazomai na do ligo pos einai i vasi mas to product
                $result=mysql_query($sql);
                echo "<table border=0 cellspacing=5 cellpadding=5>";
                echo "<tr>";
                echo "<td>" . "<b>Code<b>". "</td>";
                echo "<td>" . "<b>Surname<b>" . "</td>";
                echo "<td>" . "<b>Name<b>" . "</td>";
                echo "<td>" . "<b>Phone<b>" . "</td>";
                echo "</tr>";
                while($row = mysql_fetch_array($result))
                {
                    echo "<tr>";
                    echo "<td>" . $row['code'] . "</td>";
                    echo "<td>" . $row['surname'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['phone'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                mysql_close();
                ?>
                <form  name="form" action="deleteone.php" onsubmit="javascript:return ValidateForm(this)">
                    <p><strong>	Delete one product</strong>
                    <p>
                        <label>Enter the Code for delete: </label>
                        <input name="code" type="text" size="30" />

                        <br>
                        <br />
                        <input class="button" type="submit" value = "Submit"/>
                    </p>
                </form>
                <p>
                <form  name="form" action="sdelete.php" onsubmit="javascript:return ValidateForm2(this)">
                    <p><strong>	Delete products from a code range:</strong>                                     //do we need such thing?
                    <p>
                        <label>Enter Code Start</label>
                        <input name="start" type="text" size="30" />
                        <label>Enter Code End</label>
                        <input name="end"  type="text" size="30" />
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
