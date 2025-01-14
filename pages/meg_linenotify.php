<!DOCTYPE html>
<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
?>
<html lang="en">
    <head>



    </head>
    <body>
        <?php
        /* -------------line noti---------------------- */
        $line_api = 'https://notify-api.line.me/api/notify';
        $access_token = 'token_code';

        $message = 'test';    //text max 1,000 charecter
        $image_thumbnail_url = 'https://dummyimage.com/1024x1024/f598f5/fff.jpg';  // max size 240x240px JPEG
        $image_fullsize_url = 'https://dummyimage.com/1024x1024/844334/fff.jpg'; //max size 1024x1024px JPEG
        $imageFile = 'copy/240.jpg';
        $sticker_package_id = '';  // Package ID sticker
        $sticker_id = '';    // ID sticker

        $message_data = array(
        'imageThumbnail' => $image_thumbnail_url,
        'imageFullsize' => $image_fullsize_url,
        'message' => $message,
        'imageFile' => $imageFile,
        'stickerPackageId' => $sticker_package_id,
        'stickerId' => $sticker_id
        );

        $result = send_notify_message($line_api, $access_token, $message_data);

        echo '<pre>';
        print_r($result);
        echo '</pre>';
      
        /* -------------line noti---------------------- */



        function send_notify_message($line_api, $access_token, $message_data){
        $headers = array('Method: POST', 'Content-type: multipart/form-data', 'Authorization: Bearer '.$access_token );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $line_api);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $message_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        // Check Error
        if(curl_error($ch))
        {
        $return_array = array( 'status' => '000: send fail', 'message' => curl_error($ch) );
        }
        else
        {
        $return_array = json_decode($result, true);
        }
        curl_close($ch);
        return $return_array;
        }
        ?>


    </body>

</html>
<?php
sqlsrv_close($conn);
?>