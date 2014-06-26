<?php
/*$url = 'http://'.HOST.'/'.ROOT.'/Core/RestServices/Product.php/product/category/';
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
$parents=array();
foreach ($xml->category as $category) {
    if(empty($category->parent)){
        $parents[htmlspecialchars($category->ID)]['ID']=htmlspecialchars($category->ID);
        $parents[htmlspecialchars($category->ID)]['name']=htmlspecialchars($category->name);
    }else{
        if(htmlspecialchars($category->parent)==$parents[htmlspecialchars($category->parent)]['ID']){
            $sorted[htmlspecialchars($category->parent)]['child']=array(htmlspecialchars($category->ID),htmlspecialchars($category->name));
            $sorted[htmlspecialchars($category->parent)]['name']=$parents[htmlspecialchars($category->parent)]['name'];
            $sorted[htmlspecialchars($category->parent)]['ID']=$parents[htmlspecialchars($category->parent)]['ID'];
        }
    }
    $childs[]=($category->ID);
    //echo '<li><a href="index.php/"'.$category->ID.'>'.$category->name.'</a></li>';
}   //var_dump($sorted); var_dump($parents);

foreach($sorted as $category){
    echo '<li class="dropdown-submenu">';
    echo '<a tabindex="-1" href="#'.$category['ID'].'>'.$category['name'].'</a>';
    echo '<ul class="dropdown-menu"><li></li></ul>';
    foreach($category['child'] as $cat){
        echo' <li><a tabindex="-1" href="#'.$cat[0].'">'.$cat.'</a></li>';
        //echo var_dump($cat);
    }
    echo'</li>';


}

*/
?>
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><i class="icon-home icon-white"> </i> RESTful Shop						</a>
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav"><li class="menu-item "><a href="index.php">Home Page</a></li>
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Categories <span class="caret"></span></a>

                        <ul class="dropdown-menu">
                            <?php menu()?>

                        </ul>
                    </li>
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Lorem Ipsum <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">2nd Level Sub-Menu 1</a>
                                <ul class="dropdown-menu">
                                    <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">3rd Level Sub-Menu 1</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">3rd level link #1</a></li>
                                            <li><a href="#">3rd level link #2</a></li>
                                            <li><a href="#">3rd level link #3</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">3rd Level Sub-Menu 2</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">3rd level link #1</a></li>
                                            <li><a href="#">3rd level link #2</a></li>
                                            <li><a href="#">3rd level link #3</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">2nd Level Sub-Menu 2</a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">2rd level link #1</a></li>
                                    <li><a href="#">2rd level link #2</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><form class="navbar-search navbar-form" method="get" action="">
                            <input class="form-control" placeholder="Search" name="s" type="text">
                        </form>
                    </li>
                    <li>
                        <a href="#" title="Subscribe to the RSS feed">
                            <i class="icon-rss"> </i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

<?php
/**
 * Created by PhpStorm.
 * User: George
 * Date: 6/25/14
 * Time: 5:28 PM
 */
function menu(){
    $url = 'http://'.HOST.'/'.ROOT.'/Core/RestServices/Product.php/product/category/';
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
    $parents=array();
    foreach ($xml->category as $category) {
        if(empty($category->parent)){
            $parents[htmlspecialchars($category->ID)]['ID']=htmlspecialchars($category->ID);
            $parents[htmlspecialchars($category->ID)]['name']=htmlspecialchars($category->name);
        }else{
            if(htmlspecialchars($category->parent)==$parents[htmlspecialchars($category->parent)]['ID']){
                $sorted[htmlspecialchars($category->parent)]['child'][]=array(htmlspecialchars($category->ID),htmlspecialchars($category->name));
                $sorted[htmlspecialchars($category->parent)]['name']=$parents[htmlspecialchars($category->parent)]['name'];
                $sorted[htmlspecialchars($category->parent)]['ID']=$parents[htmlspecialchars($category->parent)]['ID'];
            }
        }
        $childs[]=($category->ID);
        //echo '<li><a href="index.php/"'.$category->ID.'>'.$category->name.'</a></li>';
    }   //print_r($sorted); //var_dump($parents);

    foreach($sorted as $category){

        echo "<li class='dropdown-submenu'>"."\r\n";
        echo "<a class='dropdown-toggle' data-toggle='dropdown' href='#'".$category['ID']."> ".$category['name']." </a>"."\r\n";
        echo "<ul class='dropdown-menu'>"."\r\n";
        foreach($category['child'] as $cat){
            echo"<li><a  href='index.php?page=category&category=".$cat[0]."'>".$cat[1]."</a></li>"."\r\n";
            //echo var_dump($cat);
        }
        echo"</ul>"."\r\n"."</li>"."\r\n";


    }
;
}
?>
