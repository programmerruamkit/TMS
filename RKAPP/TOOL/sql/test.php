<?php
if ($_FILES['order_file']["name"] != '') {
    $target_dir = "../../FILE/ITRORDER/";
    $target_file = $target_dir . "RKcode".".".strtolower(pathinfo($_FILES["order_file"]["name"],PATHINFO_EXTENSION));
    if (move_uploaded_file($_FILES["order_file"]["tmp_name"], $target_file)) {
        echo '<script type="text/javascript">window.alert("บันทึกไฟล์แนบแล้ว!! \n'.$target_file.'");</script>';
    }
}
?>
<meta charset="ISO-8859-1">
<body>
    <img src="/RKAPP/file/itrorder/RKcode.png">
   <form id="add_order" name="add_order" method="post" enctype="multipart/form-data" action="/RKAPP/TOOL/SQL/test.php" onsubmit="return conf_send_data()">
    <div class="col-lg-6">
        <div class="input-group"><span class="input-group-addon">รูปภาพประกอบ</span>
            <input class='form-control' type="file" name="order_file" id="order_file" maxlength="100" accept=".png, .jpg, .jpeg">
        </div> 
    </div>
    <div class="row w3-margin-top">
        <div class="modal-footer">
            <button type="submit" class="btn btn-success" data-dismiss="modal"><span class="fa fa-save"></span> Save</button>
            <button type="reset" class="btn btn-danger">CANCEL</button>
        </div>
    </div>
</form> 
</body>