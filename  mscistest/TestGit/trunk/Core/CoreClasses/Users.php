<?php
/**
 * Created by PhpStorm.
 * User: George
 * Date: 6/22/14
 * Time: 2:38 PM
 */

namespace CoreClasses;


class Users {
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

    function check_Username($user){
        if(mysql_num_rows(mysql_query("select * from user where username='$user'"))>0){
            return true;
        }
    }
    function check_Credentials($user,$password){
        $a="select * from user where username='$user' and password='$password'";
        $t=mysql_query($a) or $t=mysql_error();
        $est=mysql_num_rows($t);
        /*if($t=mysql_num_rows(mysql_query("select * from user where username='$user' and password='$password'"))==1){
            return $t;
        }
        else return false;*/
        if($est==1)
            return true;
        else return false;
    }
    function check_Email($email){
        if(mysql_num_rows(mysql_query("select * from user where email='$email'"))>0){
            return true;
        }
    }


    function add_User($details){
        $error=null;
        $Users= array();
        if($details!=null){
            $username=$details['username'];
            $salt = uniqid(mt_rand(), true);
            $password=md5($details['password'].$salt);
            $name=$details['name'];
            $surname=$details['surname'];
            $phone=$details['phone'];
            $email=$details['email'];

            if($this->check_Email($email)==true || $this->check_Username($username)==true){
                $Users['error']="User already exists";
            }
            else{
                $query="insert into user(username,password,email,salt,name,surname,phone,level,access) values ('$username','$password','$email','$salt','$name','$surname',$phone,0,0)";
                $result=mysql_query($query) or $error=('Query failed: ' . mysql_error());
                if($error==null){
                    $Users['success']="User Added ";
                }
                else {
                    $Users['error']=$error;
                }
            }
            return $Users;
        }
    }

    function edit_User($details){
        $error=null;
        if($details!=null){
            $id=$details['UID'];
            $username=$details['username'];
            $salt = $details['salt'];//uniqid(mt_rand(), true);
            $password=md5($details['password'].$salt);
            $name=$details['name'];
            $surname=$details['surname'];
            $phone=$details['phone'];
            $email=$details['email'];

            $counter=mysql_query("select count(*) as counter from user where username='$username'");
            $row=mysql_fetch_array($counter);

            if($row['counter']==0){
                $Users['error']="Invalid Action";
            }
            else{
                $query="update user set password='$password', email='$email', name='$name',phone=$phone, surname='$surname' where username='$username'";
                $result=mysql_query($query) or $error=('Query failed: ' . mysql_error());
                if($error==null){
                    $Users['success']="User Edited";
                }
                else {
                    $Users['error']=$error;
                }
            }
            return $Users;
        }

    }

    function get_User($username){
        $user=array();
        $error=null;
        if($this->check_Username($username)!=true){
            $user['error']="User does not exist";
        }
        else{
            $query="select * from user where username='$username'";
            $result=mysql_query($query) or $error=('Query failed: ' . mysql_error());
            if($error==null){
                if($this->check_Username($username)==true){}
                else{$user['error']="No user exists";}
                $row=mysql_fetch_array($result)  ;

                $user['UID']=$row['UID'];
                $user['username']=$row['username'];
                $user['password']=$row['password'];
                $user['salt']=$row['salt'];
                $user['email']=$row['email'];
                $user['name']=$row['name'];
                $user['surname']=$row['surname'];
                $user['phone']=$row['phone'];
                $user['level']=$row['level'];
                $user['access']=$row['access'];
                $user['success']="user found";
                mysql_free_result($result);
                return $user;
            }else{
                $user['error']=$error;
                return $user;
            }

        }
        return $user;
    }
    function get_User_Exists($username,$password){
        $user=false;
        $answer=false;
        $error=null;
        if($this->check_Username($username)!=true){
            $user="false";
        }
        else{
            $query="select * from user where username='$username'";
            $result=mysql_query($query) or $error=('Query failed: ' . mysql_error());
            if($error==null){
                $row=mysql_fetch_array($result)  ;
                $user['username']=$row['username'];
                $user['password']=$row['password'];
                $user['salt']=$row['salt'];
                mysql_free_result($result);
                $passwordNew=md5($password.$user['salt']);
                $user['answer']=$this->check_Credentials($username,$passwordNew);
                /*if($this->check_Credentials($username,$passwordNew)==true){
                    $answer= "true";
                }*/
                if($user['password']==$passwordNew){
                    $answer="true";
                }
                //return $user;
            }else{
                $user['error']=$error;
                $answer= "false";
            }

        }
        return $answer;
    }

    function update_User_level($username){
        $error=null;
        $user=array();
        if($this->check_Username($username)==true){
            $query="update user set level=1 where username ='$username'";
            mysql_query($query) or $error=('Query failed: ' . mysql_error());
            if($error==null){
                $user['success']="level updated";
            }
            else{
                $user['error']=$error;
            }
            return $user;
        }else{
            $user['error']="Invalid Action";
            return $user;
        }
    }

    function delete_User($username){
        $error=null;
        if($this->check_Username($username)==true){
            mysql_query("delete from user where username ='$username'") or $error=('Query failed: ' . mysql_error());
            if($error==null){
                $user['success']="user deleted";
            }
            else{
                $user['error']=$error;
            }
            return $user;
        }else{
            $user['error']="Invalid Action";
            return $user;
        }
    }

} 