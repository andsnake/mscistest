<?php
/**
 * Created by PhpStorm.
 * User: George
 * Date: 6/13/14
 * Time: 7:29 PM
 * Class Model for uploading Images to database
 */

namespace CoreClasses;


class Images {
    private $conn=null;
    private $maxsize = 10000000; //set to approx 10 MB
    function __construct($con) {
        $this->conn=$con;
    }

    /*dokimastiki methodos gia na xeirizete to upload mias eikonas sti vasi dedomenwn*/
    function upload($file){
        $error=null;
        $Products=array();
        //file will be tha data from File[]
        if($file['image']['size'] < $this->maxsize){
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            if(strpos(finfo_file($finfo, $file['image']['tmp_name']),"image")===0){
                // prepare the image for insertion
                $imgData =addslashes (file_get_contents($file['image']['tmp_name']));

                $sql = "INSERT INTO image (file,caption) VALUES('{$imgData}', '{$_FILES['userfile']['name']}');";
                mysql_query($sql) or $error=("Error in Query: " . mysql_error());
                if($error==null){
                    $Products["success"]="Item Added!";
                    $Products["fileId"]=mysql_insert_id();
                    return $Products;
                }
                else {
                    return $Products["error"]=$error;
                }

            }
        }



    }

} 