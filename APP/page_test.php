<?php $title_page = "Login"; ?>
<?php
if (require_once 'master.php') {
    
}
?>

<html>
    <head>

    </head>
    <body>

        <div class="col-lg-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">เลขอุปกรณ์</span>
                </div>
                <input class='form-control' type="text" id="order_eq" name='order_eq' placeholder="..." onkeyup="get_location_data(this.value)" maxlength="10" required>
            </div>
        </div>
        <div class="col-lg-6" id="data_location">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">สถานที่</span>
                </div>
                <div >
                    <input class='form-control' type="text" name='order_location' placeholder="..." maxlength="50" required>
                </div>
            </div>
        </div>

    </body>
</html>

