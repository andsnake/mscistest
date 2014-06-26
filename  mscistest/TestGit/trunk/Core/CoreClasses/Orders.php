<?php
/**
 * Created by PhpStorm.
 * User: George
 * Date: 6/22/14
 * Time: 4:03 PM
 */

namespace CoreClasses;


class Orders {
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
    /*
     * @order this is the 2d array containing the product SKU's of the order
     * $order=['sku1'=>array("SKU"=>"adsasdasdasd","quantity"=>2),
     *   'sku2'=>array("SKU"=>"adsadafagwgwgw","quantity"=>2)
     *   ];
     *
     */
    function add_Order($order,$UID){
        $error=null;
        $Orders=array();
        $date_made=date("Y-m-d H:i:s");
        $date_due=date('Y-m-d H:i:s', strtotime("+3 days"));
        $total=$this->calculate_Total($order);
        $code=uniqid();
        //mysql_insert_id();
        //$query="insert into `order`(date_made,date_due,UID,total,status) values ($date_made,$date_due,$UID,$total,'Collecting')";
        $query="insert into  `order`(UID,total,date_made,date_due,status,code) values ($UID,$total,'$date_made','$$date_due',0,'$code')";
        $result=mysql_query($query) or $error=('Query failed: ' . mysql_error());
        if($error==null){
            $id=mysql_insert_id();
            $result2=$this->set_Order_Products($order,$id);
            if(is_array($result)==false){
                $Orders['success']="Order Completed";
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
    private function calculate_Total($order){
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
        if($error!=null) $total=$error;
        return $total;
    }

    private function set_Order_Products($order,$OID){
        $error=null;
        $done=false;
        foreach($order as $product){
            $SKU=$product['SKU'];
            $query="insert into products_orders(OID,SKU) values ($OID,'$SKU')";
            $result=mysql_query($query) or $error=('Query failed: ' . mysql_error());
        }
        if($error==null){
           $done= true;
        }
        else {
            $orders['error']=$error;
            $done= $orders;
        }
        return $done;
    }

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

} 