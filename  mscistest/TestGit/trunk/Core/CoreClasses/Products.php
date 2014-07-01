<?php
/**
 * Created by PhpStorm.
 * User: George
 * Date: 6/5/14
 * Time: 6:10 PM
 */

namespace CoreClasses;
//include ("config.php");

class Products {
    private $conn=null;
    /*custom contructor */
    function __construct($conn) {
        $this->conn = $conn;
        if ($this->conn== null){
            die("error on db connection");
        }
        else
            mysql_select_db(DB);
    }
    function setConn(){
        $this->conn=initConn();
}
    function get_Product($SKU){
        $query="select * from Product where SKU='$SKU'";
        $error=null;
        $result = mysql_query($query) or $error=('Query failed: ' . mysql_error());
        $Products= array();
        if($error==null && mysql_num_rows($result)>0){
            /*get results and put them in an array*/
            while($row=mysql_fetch_array($result)){
                $Products[]=$row;
            }
            mysql_free_result($result);
            /* array usage>> $result_set[0]['column_name']; */
            return $Products;
        }
        else{
            if(mysql_num_rows($result)<0){
                $error="No item Found";
            }
            $Products['error']=$error;
            return $Products;
        }
    }

    /*returns the Products that belong to a certain Category*/
    function get_Cat_Products($category){
        $error=null;
        if($category!==null){
            //$cat=(stripcslashes($category));
            $query="select * from Product a where a.SKU in (Select b.SKU from Products_Categories b where b.CATID= '$category')";
            $result = mysql_query($query) or $error=('Query failed: ' . mysql_error());
            $Products= array();
            if($error==null){
                /*get results and put them in an array*/
                while($row=mysql_fetch_array($result)){
                    $Products[]=$row;
                }
                mysql_free_result($result);
                /* array usage>> $result_set[0]['column_name']; */
                return $Products;
            }
            else{
                $Products['error']=$error;
                return $Products;
            }


        }
    }

    function get_All_Products(){
        $query="select * from Product";
        $error=null;
        $result = mysql_query($query) or $error=('Query failed: ' . mysql_error());
        $Products= array();
        if($error==null){
            /*get results and put them in an array*/
            while($row=mysql_fetch_array($result)){
                $Products[]=$row;
            }
            mysql_free_result($result);
            /* array usage>> $result_set[0]['column_name']; */
            return $Products;
        }
        else{
            $Products['error']=$error;
            return $Products;
        }
    }

    /*Inserts  Products to DB*/
    function add_Product($details){
        $error=null;
        if($details!==null){
            $query="insert into Product(SKU,description,price,stock,date_added,name) values ('".$details["SKU"]."','".$details["description"]."','".$details["price"]."','".$details["stock"]."',NOW()),'".$details["name"]."'";
            $result = mysql_query($query) or $error=('Query failed: ' . mysql_error());
            $Products= array();

            if($error==null){
                if(array_key_exists('category', $details)){
                    $imageResult=$this->set_Product_Cat($details['SKU'],$details['category']);
                    if(array_key_exists('success',$imageResult)){
                        $Products["success"]="Item Added!";
                    }
                    else $Products["error"]=$error.$imageResult['error'];
                }
                else{
                    $Products["success"]="Item Added!";
                }
                return $Products;
            }
            else{
                $Products["error"]=$error;
                return $Products;
            }

        }
    }

    /* $cat= array of category id's a product will associate with*/
    function set_Product_Cat($SKU,$cat){
        $error=null;
        if(!is_array($cat)){
            $q="insert into products_categories(SKU,CATID) values('$SKU',$cat)";
            mysql_query($q) or $error=('Query failed: ' . mysql_error());
            if($error==null){
                $Products["success"]="Item Added!";
                return $Products;
            }
            else{
                $Products["error"]=$error.$SKU." -".$cat;
                return $Products;
            }
        }
        else{
            foreach($cat as $id){
                $error=null;
                try{
                    mysql_query("insert into products_categories(SKU,CATID) values('$SKU',$id)") or $error=('Query failed: ' . mysql_error());
                    if($error==null){
                        $Products["success"]="Item Added!";
                        return $Products;
                    }
                    else{
                        $Products["error"]=$error;
                        return $Products;
                    }
                }catch(Exception $e){
                    $error=('Query failed: ' . mysql_error());
                    $Products["error"]=$error;
                    return $Products;
                }
            }
        }
    }

    /*Deletes  Products from DB*/
    function delete_Product($SKU){
        $error=null;
        if($SKU!==null){
            $counter=mysql_query(" select count( *) as counter from Product where SKU='$SKU'");
            $row=mysql_fetch_array($counter);
            if($row['counter']>0){
                $query="delete from Product where SKU='$SKU'";
                $result = mysql_query($query) or $error=('Query failed: ' . mysql_error());
                $Products= array();
                if($result){
                    //mysql_free_result($result);
                    $Products["success"]="Item Deleted!".$counter;
                    return $Products;
                }
                else {
                    mysql_free_result($counter);
                    $Products["error"]=$error;
                    return $Products;
                }
            }
            else{
                $Products["error"]="Invalid Action!";
                return $Products;
            }
        }
    }

    function edit_Product($SKU,$details){
        $error=null;
        $Products=array();
        if($SKU!==null){
            $query="update product set description='".$details['description']."', price=".$details['price'].",stock= ".$details['stock']." where SKU='".$SKU."',name='".$details["name"]."'";
            $result = mysql_query($query) or $error=('Query failed: ' . mysql_error());
            if($result){
                $go=true;
                if(array_key_exists('category',$details)){
                    $r=$this->update_Product_Category($SKU,$details['category']);
                    if(is_array($r)){
                        if(array_key_exists('success',$r)){
                            $go= true;
                        }
                        else{
                            $go=false;
                            $Products["error"]="Item Not Edited! Invalid Action";
                        }
                    }
                }
                if($go){
                    //mysql_free_result($result);
                    $Products["success"]="Item Edited!";
                    return $Products;
                }
                else{
                    return $Products;
                }
            }
            else {
                mysql_free_result($result);
                $Products["error"]=$error;
                return $Products;
            }
        }

    }

    /**
     * @param $SKU
     * @param $cat
     * @return mixed
     *  Needs to be worked on.. Maybe do a cross check between previous
     *  categories and the categories that the user have selected and then delete
     *  those that do not exist in the new "array" of categories
     * ( for now lets assume that a product can belong only to one major category)
     */
    function update_Product_Category($SKU,$cat){
        $error=null;
        $Products=array();
       // $query="update products_categories set CATID=".$cat."where SKU='".$SKU."'";
        $query="update products_categories set CATID=$cat where SKU='$SKU'";
        $result = mysql_query($query) or $error=('Query failed: ' . mysql_error());
        if($error==null){
            //mysql_free_result($result);
            $Products["success"]="Item Edited!";
            return $Products;
        }
        else {
            //mysql_free_result($result);
            $Products["error"]=$error."WTF?";
            return $Products;
        }
    }

    function remove_Product_Category($SKU,$cats){
        $error=null;
        foreach($cats as $category){
            $query="delete from products_categories where SKU='".$SKU."' and CATID=".$category."";
            $result = mysql_query($query) or $error=('Query failed: ' . mysql_error());
            if($error!=null)
                $Products["error"]=$error;
            else {
                $Products["sucess"]="Category Removed";
            }
        }

        return $Products;
    }

    function getCategories(){
        $query="select * from category";
        $error=null;
        $array=array();
        $result=mysql_query($query) or $error=('Query failed: ' . mysql_error());
        if($error==null){
            while($row=mysql_fetch_array($result)){
                $array[]=$row;
            }
        }
        mysql_free_result($result);
        return $array;
    }

    function add_Category($details){
        $error=null;
        $Products=array();
        if($details!=null){
            $parent=0;
            $parent=$details['parent'];
            $name=$details['name'];
            if(empty($parent)|| $parent==""){
                $query="insert into category(cat_name) values ('$name')";
            }else{
               $query="insert into category(parent,cat_name) values ($parent,'$name')";
                //$query="insert into category(cat_name) values ('$name')";
            }
            $result=mysql_query($query)or $error=('Query failed: ' . mysql_error()." ".$query." ".$parent);
            if($error==null){
                //$Products["error"]=$error;
                $Products["success"]="Category Added";
            }
            else{
                $Products["error"]=$error;
            }
            return $Products;
        }
    }

    function edit_Category($details){
        $error=null;
        $Products=array();
        if($details!=null){
            $id=$details["id"];
            $parent=$details['parent'];
            $name=$details['name'];
            $query="select * from category where CATID=".$id;
            if(mysql_num_rows(mysql_query($query))>0){
                $query="update category set parent=".$parent.",cat_name='".$name."' where CATID=".$id;
                $result=mysql_query($query)or $error=('Query failed: ' . mysql_error());
                if($error==null){
                    $Products["success"]="Category Edited";
                }
                else{
                    $Products["error"]=$error;
                }
            }
            else{
                $Products["error"]="Invalid Action!";
            }

            return $Products;
        }
    }

    function delete_Category($id){
        $error=null;
        $Products=array();
        if($id!=null){
            $query="select * from category where CATID=".$id;
            if(mysql_num_rows(mysql_query($query))>0){
                $query="delete from category where CATID=".$id;
                $result=mysql_query($query)or $error=('Query failed: ' . mysql_error());
                if($error==null){
                    $Products["success"]="Category Deleted";
                }
                else{
                    $Products["error"]=$error;
                }
            }
            else{
                $Products["error"]="Invalid Action!";
            }

            return $Products;
        }
    }

    function get_Latest_Products(){
        $query="select * from Product order by date_added limit 15";
        $error=null;
        $result = mysql_query($query) or $error=('Query failed: ' . mysql_error());
        $Products= array();
        if($error==null){
            /*get results and put them in an array*/
            while($row=mysql_fetch_array($result)){
                $Products[]=$row;
            }
            mysql_free_result($result);
            /* array usage>> $result_set[0]['column_name']; */
            return $Products;
        }
        else{
            $Products['error']=$error;
            return $Products;
        }
    }

    function search($product,$CATID){
        if($CATID==null || $CATID==0){
            $query="select * from product where name like '%".$product."%' ";
        }
        else{
            $query="select * from product,products_categories where name like '%$product%' and products_categories.SKU=product.SKU and CATID=$CATID";
        }
        $error=null;
        $result = mysql_query($query) or $error=('Query failed: ' . mysql_error());
        $Products= array();
        if($error==null){
            /*get results and put them in an array*/
            while($row=mysql_fetch_array($result)){
                $Products[]=$row;
            }
            mysql_free_result($result);
            /* array usage>> $result_set[0]['column_name']; */
            //$Products["q"]=$query;
            return $Products;
        }
        else{
            $Products['error']=$error;
            return $Products;
        }


    }


} 