<!doctype html>
<?php
//whether ip is from share internet
if (!empty($_SERVER['HTTP_CLIENT_IP']))   
  {
    $ip_address = $_SERVER['HTTP_CLIENT_IP'];
  }
//whether ip is from proxy
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
  {
    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
//whether ip is from remote address
else
  {
    $ip_address = $_SERVER['REMOTE_ADDR'];
  }
echo $ip_address;
?>
<html lang="en">
    <head>
        <link rel="shortcut icon" href="../images/icon.png" />
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <title>รายงานตัวปีใหม่</title>
    </head>
    <body>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <input  type="text" id="txt_latitude">
        <input  type="text" id="txt_longitude">
        <input  type="text" id="txt_ipaddress">
        <div class="panel panel-default">
            <div class="panel-heading" style="font-size: 50px;">
                <div class="row">&nbsp;</div>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <b>รายงานตัวปีใหม่</b>
                    </div>
                </div>
            </div>
            <div class="panel-body" style="font-size: 100px;">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <b><button type="button" class="btn btn-outline-info" onclick="take_snapshot()"><font style="font-size: 100px;">คลิก</font></button></b>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<script language="JavaScript">
    
    function take_snapshot() {

        getLocation();

    }

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        }
    }

    function showPosition(position) {

        document.getElementById('txt_latitude').value = position.coords.latitude;
        document.getElementById('txt_longitude').value = position.coords.longitude;
        document.getElementById('txt_ipaddress').value = '<?= $ip_address ?>';



        //save_workcheckin();
        //select_maxworkcheckin();

    }
    function save_workcheckin()
    {


        if (document.getElementById('txt_employeecode').value != '')
        {

            $.ajax({
                type: 'post',
                url: '../pages/meg_data.php',
                data: {
                    txt_flg: "save_workcheckin",
                    employeecode: document.getElementById('txt_employeecode').value,
                    latitude: document.getElementById('txt_latitude').value,
                    longitude: document.getElementById('txt_longitude').value,
                    pathname: document.getElementById('txt_pathname').value,
                    beforeactivity: document.getElementById('txt_beforeactivity').value

                },
                success: function () {



                    //window.location.reload();
                }
            });
        }
    }

    function select_maxworkcheckin()
    {

        $.ajax({
            type: 'post',
            url: '../pages/meg_data.php',
            data: {
                txt_flg: "select_maxworkcheckin", employeecode: document.getElementById('txt_employeecode').value


            },
            success: function (rs) {
                var time = document.getElementById('txt_time').value;
                if (document.getElementById('txt_employeecode').value != '')
                {
                    document.getElementById('p_maxtime').innerHTML = 'รายงานตัวเวลา ' + time + ' เรียบร้อยแล้ว';

                } else
                {
                    document.getElementById('p_maxtime').innerHTML = 'รหัสพนักงานเป็นค่าว่าง !';

                }

                //window.location.reload();
            }
        });
    }

</script>