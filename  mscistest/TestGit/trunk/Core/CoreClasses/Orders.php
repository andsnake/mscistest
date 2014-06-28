<?php
/**
 * Created by PhpStorm.
 * User: George
 * Date: 6/22/14
 * Time: 4:03 PM
 */

namespace CoreClasses;


/**
 * Class Orders
 * @package CoreClasses
 */
class Orders {
    /**
     * @var null
     */
    private $conn=null;
    private $test;
    /*custom contructor */
    /**
     * @param $conn
     */
    function __construct($conn) {
        $this->conn = $conn;
        if ($this->conn== null){
            die("error on db connection");
        }
        else
            mysql_select_db(DB);
    }
    /*
     * @order this is the 2d array containing the product SKU's of the order
     * $order=['sku1'=>array("SKU"=>"adsasdasdasd","quantity"=>2),
     *   'sku2'=>array("SKU"=>"adsadafagwgwgw","quantity"=>2)
     *   ];
     *
     */
    /**
     * @param $order
     * @param $UID
     * @return array
     */
    function add_Order($orders,$UID){
        $error=null;
        $Orders=array();
        $date_made=date("Y-m-d H:i:s");
        $date_due=date('Y-m-d H:i:s', strtotime("+3 days"));
        $total=$this->calculate_Total($orders,$UID);//apply discounts
        $code=uniqid();
        $add=false; $count=0;
        foreach($orders as $order){
            if($this->check_SKU($order['SKU'])==false){
                $count++;
            }
        }
        if($count!=0){
            $Orders['error']="Invalid Products in Query:";
            return $Orders;
        }

        //mysql_insert_id();
        //$query="insert into `order`(date_made,date_due,UID,total,status) values ($date_made,$date_due,$UID,$total,'Collecting')";
        $query="insert into  `order`(UID,total,date_made,date_due,status,code) values ($UID,$total,'$date_made','$$date_due',0,'$code')";
        $result=mysql_query($query) or $error=('Query failed: ' . mysql_error());
        if($error==null){
            $id=mysql_insert_id();
            $result2=$this->set_Order_Products($orders,$id);//
            if(is_array($result)==false){
                $Orders['success']="Order Completed " ;
                $Orders['code']=$code;
                //$Orders['error'].=", ".$result2['error'];
            }
            else{
                $Orders['error'].=", ".$result2['error'];
            }
        }
        else{
            $Orders['error']=$error;
        }
        return $Orders;

    }
    /*
     * @order this is the 2d array containing the product SKU's of the order
     * $order=['sku1'=>array("SKU"=>"adsasdasdasd","quantity"=>2),
     *   'sku2'=>array("SKU"=>"adsadafagwgwgw","quantity"=>2)
     *   ];
     * Thinking of sending directly the total amount in the array(calculated by javascript
     * instead of this..
     */
    /**
     * @param $order
     * @param $UID
     * @return int|null|string
     */
    private function calculate_Total($order,$UID){
        $error=null;
        $total=0;
        foreach($order as $product){
            $SKU=$product['SKU'];
            $query="select price from product where SKU='$SKU'";
            $result=mysql_query($query) or $error=('Query failed: ' . mysql_error());
            if($error==null){
                $row=mysql_fetch_array($result);
                $total+=($row['price']*$product['quantity']);
            }
        }
        //get user level and apply discount if applicable
        if($this->calculate_User_level($UID)==true){
            //apply standard gold discount
            $total=$total-$total*0.10;//10% discount might be too much...
        }
        if($error!=null) $total=$error;
        return $total;
    }

    //adds values to order_products intermidiate database table
    /**
     * @param $order
     * @param $OID
     * @return bool
     */
    private function set_Order_Products($order,$OID){
        $error=null;
        $done=false;
        foreach($order as $product){
            $SKU=htmlspecialchars($product['SKU']);
            $quantity=htmlspecialchars($product['quantity']);
            $query="insert into products_orders(OID,SKU,quantity) values ($OID,'$SKU',$quantity)";
            $result=mysql_query($query) or $error=('Query failed: ' . mysql_error());
        }
        if($error==null){
           $done= true;
        }
        else {
            //$this->test=$error. " query=".$query." ".print_r($order);
            $orders['error']=$error;
            $done= $orders;
        }
        return $done;
    }

    /**
     * @param $UID
     * @return bool
     */
    function calculate_User_level($UID){
        $error=null;
        $query="select count(*) as count  from  `order` where UID=$UID";
        $result=mysql_query($query)  or $error=('Query failed: ' . mysql_error());
        $row=mysql_fetch_array($result);
        if($error==null){
            if($row['count']>=5){
                return true;
            }
            else {
                return false;
            }
        }
        else {
            $err['error']=$error;
            return $err;
        }
    }

    /**
     * @param $SKU
     * @return bool
     * check if valid SKU
     */
    function check_SKU($SKU){
        $error=null;
        $query="select count(*)as counter from product where SKU='$SKU'";
        $result=mysql_query($query) or $error=('Query failed: ' . mysql_error());
        if($error==null){
            $counter=mysql_fetch_array($result);
            if($counter['counter']>0){
                mysql_free_result($result);
                //SKU is valid
                return true;
            }
            else{
                mysql_free_result($result);
                $this->test=$error;
                return false;
            }

        }
        else{
            $this->test=$error;
            return false;
        }
    }

    function get_Order($code){
        $error=null;
        $order=array();
        $query="select count(*) as counter  from `order`  where code='$code'";
        $result=mysql_query($query) or $error=('Query failed: ' . mysql_error());
        if($error==null){
            $counter=mysql_fetch_array($result);
            if($counter['counter']>0){
                mysql_free_result($result);
                //order exists and is valid
                $query="select  p.name,o.OID,o.date_made,o.UID,o.`status`,o.`code`,o.total,pr.SKU,pr.quantity from `order` as o, products_orders as pr , product as p  where code='$code' and o.OID=pr.OID and p.SKU=pr.SKU";
                $result=mysql_query($query) or $error=('Query failed: ' . mysql_error());
                if($error==null){
                    while($row=mysql_fetch_array($result)){
                        $order[]=$row;
                    }
                    return $order;
                }else{
                    $order['error']=$error;
                    return $order;
                }
            }
            else{
                mysql_free_result($result);
                $order['error']="Nothing Found";
                return $order;
            }
        }else{
            $order['error']=$error;
            return  $order;
        }

    }

} //end of class