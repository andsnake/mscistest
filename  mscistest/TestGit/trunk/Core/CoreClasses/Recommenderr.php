<?php
/**
 * Created by PhpStorm.
 * User: George
 * Date: 6/30/14
 * Time: 6:35 PM
 */

namespace CoreClasses;


class Recommender {
    private $con;
    private $UID_A;
    private $User_A;
    private $Others;
    private $error;

    /**
     * @return array
     */
    public function getOthers()
    {
        return $this->Others;
    }

    /**
     * @return mixed
     */
    public function getUIDA()
    {
        return $this->UID_A;
    }

    /**
     * @return \CoreClasses\User
     */
    public function getUserA()
    {
        return $this->User_A;
    }

    function __construct($con){
        $this->con=$con;
        $this->Others=array();
        $this->User_A=new User(null);
        mysql_select_db(DB);
    }

    function getError(){
        //$this->error="masadas";
        return $this->error;
    }

    function set_UID($id){
        $this->UID_A=$id;
    }

    function set_Current_User($username){
        $query="select UID,level from user where username='$username'" ;
        $this->error=$query;
        $result=mysql_query($query)or $this->error=(mysql_error());;
        if(mysql_num_rows($result)>0){
            $row=mysql_fetch_array($result);
            $this->User_A=new User($this->UID_A);
            $this->set_UID($row['UID']);
            $this->User_A->set_level($row['level']);
            mysql_free_result($result);
            $id=$this->UID_A;
            $query="select `user`.UID, `user`.username,`user`.`level`,product.SKU, products_orders.quantity from `user`,product,`order`,products_orders where product.SKU=products_orders.SKU and `order`.OID=products_orders.OID and `order`.UID = $id and `user`.UID=`order`.UID  group by `user`.UID,product.SKU
";
            $result=mysql_query($query) or $this->error=(mysql_error());;;
            $this->error.=$query;
            //set current User's Products
            while($row=mysql_fetch_array($result)){
                $this->User_A->set_Product($row['SKU']);
            }
            mysql_free_result($result);
            //

        }
    }

    function set_Other_Users(){
        $id=$this->UID_A;
        $lvl=$this->User_A->getLevel();
        $query="select `user`.UID, `user`.username,`user`.`level`,product.SKU,product.name,product.price, products_orders.quantity from `user`,product,`order`,products_orders where product.SKU=products_orders.SKU and `order`.OID=products_orders.OID and `order`.UID !=$id and `user`.UID=`order`.UID and `user`.`level`=$lvl group by `user`.UID,product.SKU
";
        $result=mysql_query($query) or $this->error=mysql_error();
        $tempUser=null;
        $previous= new User(null);
        $i=0;
        $all=array();
        $this->error.="  ".$query;
        while($row=mysql_fetch_array($result)){
            $tempUser=new User($row['UID']);
            $tempUser->set_Product($row['SKU']/*array($row['SKU'],$row['name'], $row['price'])*/);
            $tempUser->set_level($row['level']);
            $this->Others[]=$tempUser;
        }

        $all=$this->Others;
        $temp=$this->Others;
        $array=array();
        //merge array of products for ech other user
        foreach($all as $u){
            if(!in_array($u,$array)){
                foreach($temp as $r){
                    $i=0;
                    if($u->getUID()==$r->getUID()){
                        $u->set_Product($r->getProducts()[$i]);
                    }
                }$array[]=$u; $i++;
            }
        }
        $this->Others=array_unique($array);//update other's array

    }

    function calculate_rankings(){

        foreach($this->Others as $other){
            foreach($this->User_A->getProducts() as $pA){
                $counter=0;
                $numItems=0;
                if(in_array($pA,$other->getProducts())){
                   $counter++;
                    //calculate similarity based on items bought
                   $other->set_Rank(($other->getRank()+1));
                }
            }
            $other->set_Rank(($other->getRank()/count($other->getProducts())));
            //$this->error=$this->Others;

        }
    }

    function getRecomendations(){
        //usort($this->Others, array($this, "cmp"));
        //sort users
        $this->sort();
        $recomentationList=array();
        $counter=0;
        foreach($this->Others as $users){
            if($counter>10 ){//this means we have 10 products limit in recommendation
                break;
            }
            foreach($users->getProducts() as $pO){
                if(in_array($pO,$this->User_A->getProducts())){
                    //do nothing;
                }
                else{
                    $recomentationList[]=$pO;
                    $counter++;
                }
            }

        }
        return $recomentationList;
    }
   private static function cmp($a, $b)
    {
        if ($a->getRank() == $b->getRank()) {
            return 0;
        }
        return ($a > $b) ? -1 : 1;
    }

    private function sort(){
        $arr=array_values($this->getOthers());
        $min=0;
        $max=0;
        $count=count($arr);
        for($i=0;$i<$count-1;$i++){
            echo $i;
            if($arr[$i+1]->getRank()>$arr[$i]->getRank()){
                $max=$arr[$i]->getRank();
                $big=$arr[$i];
                $small=$arr[$i+1];
                $arr[$i+1]=$big;
                $arr[$i]=$small;
            }
        }
        $this->Others=$arr;

}

}

class User {
    protected $UID;
    protected $products;
    protected $rank;
    protected $similarProducts;
    protected $level;

    function __construct($UID) {
        $this->UID = $UID;
        $this->products = array();
        $this->similarProducts=array();
        $this->rank = 0;
    }

    /**
     * @param mixed $UID
     */
    public function setUID($UID) {
        $this->UID = $UID;
    }

    function set_Product($product){ //$product is an array of SKU
        $this->products[]=$product;
    }
    function set_Rank($rank){
        $this->rank=$rank;
    }
    function set_Similar_Products($similar){//similar is an array of SKU,UID, where UID is the user this product is similar to
        $this->similarProducts[]=$similar;
    }
    function set_level($lvl){
        $this->level=$lvl;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @return mixed
     */
    public function getUID()
    {
        return $this->UID;
    }

    /**
     * @return mixed
     * Returns an array with all the products a user has bought
     * ( $product=array( array(SKU,name,price) ) ) >> [0]=sku, [1]=name, [2]=price
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @return mixed
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @return mixed
     */
    public function getSimilarProducts()
    {
        return $this->similarProducts;
    }

    public function __toString() {
        return strval($this->UID);
    }


}


