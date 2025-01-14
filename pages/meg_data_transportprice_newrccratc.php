<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");


if ($_POST['txt_flg'] == "modal_addtransportpricemaster") {
    ?>
    <div class="modal-body">
          <div class="row">
            <div class="col-lg-6">
              <label>CLUSTER (คลัสเตอร์) :</label>
              <input type="text" id="txt_cluster" name="txt_cluster" class="form-control">
            </div>
            <!-- <div class="col-lg-4">
              <label>NAME :</label>
              <input type="text" id="txt_name" name="txt_name" class="form-control">
            </div> -->
          </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
        <button type="button" class="btn btn-primary" onclick="add_transportpricemaster('1', '<?= $_POST['companycode'] ?>', '<?= $_POST['customercode'] ?>', '<?= $_POST['worktype'] ?>', '1')">บันทึก</button>
    </div>

    <?php
  }
  if ($_POST['txt_flg'] == "modal_addjobstartmaster") {
      ?>
      <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
                <label>JOBSTART (ต้นทาง) :</label>
                <input type="text" id="txt_jobstart" name="txt_jobstart" class="form-control">
              </div>
              <!-- <div class="col-lg-4">
                <label>NAME :</label>
                <input type="text" id="txt_name" name="txt_name" class="form-control">
              </div> -->
            </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
          <button type="button" class="btn btn-primary" onclick="add_jobstartmaster('1')">บันทึก</button>
      </div>
  
      <?php
    }  
    if ($_POST['txt_flg'] == "save_vehicletransportpricemaster_newrccratc") {
      $rs = Addtransportpricemaster($_POST['txt_flg'], '', '', '', $_POST['vehicledesccode'], $_POST['worktype'], $_POST['companycode'], $_POST['customercode'], $_POST['activestatus'], $_POST['data1'], $_POST['data2'], $_POST['data3'], $_POST['data4'], $_POST['data5']);
      switch ($rs) {
        case 'complete': {
          echo "บันทึกข้อมูลเรียบร้อย...";
        }
        break;
        case 'error': {
          echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล !!!";
        }
        break;
        default : {
          echo $rs;
        }
        break;
      }
  }  
  if ($_POST['txt_flg'] == "save_jobstartmaster") {
    $rs = Addtransportpricemaster($_POST['txt_flg'], '', '', '', '', '', '', '', $_POST['activestatus'], $_POST['data1'], '', '', '', '');
    switch ($rs) {
      case 'complete': {
        echo "บันทึกข้อมูลเรียบร้อย...";
      }
      break;
      case 'error': {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล !!!";
      }
      break;
      default : {
        echo $rs;
      }
      break;
    }
  }
  if ($_POST['txt_flg'] == "delete_vehicletransportprice_newrccratc") {
    $rs = delVehicletransportprice(
    'delete_vehicletransportprice_newrccratc', $_POST['vehicletransportpriceid']);

    switch ($rs) {
      case 'complete': {
        echo "บันทึกข้อมูลเรียบร้อย...";
      }
      break;
      case 'error': {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล !!!";
      }
      break;
      default : {
        echo $rs;
      }
      break;
    }
  } 
  if ($_POST['txt_flg'] == "delete_jobstartmaster") {
    $rs = delVehicletransportprice(
    'delete_jobstartmaster', $_POST['jobstartid']);

    switch ($rs) {
      case 'complete': {
        echo "บันทึกข้อมูลเรียบร้อย...";
      }
      break;
      case 'error': {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล !!!";
      }
      break;
      default : {
        echo $rs;
      }
      break;
    }
  }
  if ($_POST['txt_flg'] == "edit_vehicletransportprice_new_rccratc") {
    
    $editableObj = ltrim(rtrim($_POST['editableObj']));

    if ($_POST['fieldname'] == 'E1') {

      $sql_updatedata = "UPDATE dbo.VEHICLETRANSPORTPRICE_NEW_RCCRATC SET E1 = '".$editableObj."' WHERE  VEHICLETRANSPORTPRICEID = '".$_POST['priceid']."'";
      $query_updatedata  = sqlsrv_query($conn, $sql_updatedata, $params_updatedata);
      $result_updatedata = sqlsrv_fetch_array($query_updatedata, SQLSRV_FETCH_ASSOC);  
    }else if($_POST['fieldname'] == 'E2'){

      $sql_updatedata = "UPDATE dbo.VEHICLETRANSPORTPRICE_NEW_RCCRATC SET E2 = '".$editableObj."' WHERE  VEHICLETRANSPORTPRICEID = '".$_POST['priceid']."'";
      $query_updatedata  = sqlsrv_query($conn, $sql_updatedata, $params_updatedata);
      $result_updatedata = sqlsrv_fetch_array($query_updatedata, SQLSRV_FETCH_ASSOC);  
    }else{

    }
    
  }       
?>
<?php
sqlsrv_close($conn);
?>
