<?php
require_once("../class/meg_function.php");
header("Content-type:text/html; charset=UTF-8");              
header("Cache-Control: no-store, no-cache, must-revalidate");             
header("Cache-Control: post-check=0, pre-check=0", false);   
function upimg($img,$imglocate){ // ฟังก์ชันสำหรับอัพโหลดรูปภาพอย่างง่าย
            global $file_up;
            if($img['name']!=''){
            $fileupload1=$img['tmp_name'];
            $g_img=explode(".",$img['name']);
            //$file_up=time().".".$g_img[1];
            $file_up=$img['name'];
            
                if($fileupload1){
                    $array_last=explode(".",$file_up);
                    $c=count($array_last)-1;
                    $lastname=strtolower($array_last[$c]);
                    if($lastname=="gif" or $lastname=="jpg" or $lastname=="jpeg" or $lastname=="swf" or $lastname=="png"){                  
                        @copy($fileupload1,$imglocate.$file_up);            
                    }   
                }               
            }
           
        return $file_up;
}
?>
<?php
if(count($_POST)>0){
    echo "<img src='../image_vehicleattribute/".$_POST['file_front']."' width='100' />";
    if(count($_FILES)>0){
        $upFile=upimg($_FILES['image_front'],"../image_vehicleattribute/");
        $upFile=upimg($_FILES['image_side'],"../image_vehicleattribute/");
        $upFile=upimg($_FILES['image_back'],"../image_vehicleattribute/");
        $upFile=upimg($_FILES['struc_image_front'],"../image_vehicleattribute/");
        $upFile=upimg($_FILES['struc_image_side'],"../image_vehicleattribute/");
        $upFile=upimg($_FILES['struc_image_back'],"../image_vehicleattribute/");
        $upFile=upimg($_FILES['image_in'],"../image_vehicleattribute/");
    }       
    exit;
}
?>