<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");

if ($_POST['txt_flg'] == "show_copydiagramcluster_compennm") {
  ?>
  <div class="dropdown bootstrap-select show-tick form-control">
    <select multiple="" id="cb_copydiagramcluster_rccratcnm" name="cb_copydiagramcluster_rccratcnm" class="selectpicker_rccratcnm form-control" data-container="body" data-live-search="true" title="เลือก คลัสเตอร์ รอบวิ่งงานที่ 1..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
      <?php
      $condiCluster11 = " AND WORKTYPE='".$_POST['worktype']."' AND COMPANYCODE ='".$_POST['companycode']."' AND CUSTOMERCODE = '".$_POST['customercode']."' ";
      $condiCluster12 = "";
      $condiCluster13 = "";
      $sql_seCluster1 = "{call megVehicletransportprice_v2(?,?,?,?)}";
      
      $params_seCluster1 = array(
      array('select_cluster_newrccratc', SQLSRV_PARAM_IN),
      array($condiCluster11, SQLSRV_PARAM_IN),
      array('', SQLSRV_PARAM_IN),
      array('', SQLSRV_PARAM_IN),
      array('', SQLSRV_PARAM_IN),

      );
      $query_seCluster1 = sqlsrv_query($conn, $sql_seCluster1, $params_seCluster1);
      while ($result_seCluster1 = sqlsrv_fetch_array($query_seCluster1, SQLSRV_FETCH_ASSOC)) {
        ?>
        <option value="<?= $result_seCluster1['CLUSTER'] ?>"><?= $result_seCluster1['CLUSTER'] ?></option>
        <?php
      }
      ?>
    </select>
    <input class="form-control" style="display:none"   id="txt_cluster_rccratcnm" name="txt_cluster_rccratcnm" maxlength="200" value="" >
    <div class="dropdown-menu open" role="combobox">
      <div class="bs-searchbox">
        <input type="text" class="form-control" autocomplete="off" role="textbox" aria-label="Search"></div>
        <div class="bs-actionsbox">
          <div class="btn-group btn-group-sm btn-block">
            <button type="button" class="actions-btn bs-select-all btn btn-default">Select All</button>
            <button type="button" class="actions-btn bs-deselect-all btn btn-default">Deselect All</button>
          </div>
        </div>
        <div class="inner open" role="listbox" aria-expanded="false" tabindex="-1">
          <ul class="dropdown-menu inner "></ul>
        </div>
      </div>
    </div>
    <?php
}
if ($_POST['txt_flg'] == "show_copydiagramcluster_compensh") {
  ?>
  <div class="dropdown bootstrap-select show-tick form-control">
    <select multiple="" id="cb_copydiagramcluster_rccratcsh" name="cb_copydiagramcluster_rccratcsh" class="selectpicker_rccratcsh form-control" data-container="body" data-live-search="true" title="เลือก คลัสเตอร์ รอบวิ่งงานที่ 1..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
      <?php
      $condiCluster11 = " AND WORKTYPE='".$_POST['worktype']."' AND COMPANYCODE ='".$_POST['companycode']."' AND CUSTOMERCODE = '".$_POST['customercode']."' ";
      $condiCluster12 = "";
      $condiCluster13 = "";
      $sql_seCluster1 = "{call megVehicletransportprice_v2(?,?,?,?)}";
      
      $params_seCluster1 = array(
      array('select_cluster_newrccratc', SQLSRV_PARAM_IN),
      array($condiCluster11, SQLSRV_PARAM_IN),
      array('', SQLSRV_PARAM_IN),
      array('', SQLSRV_PARAM_IN),
      array('', SQLSRV_PARAM_IN),

      );
      $query_seCluster1 = sqlsrv_query($conn, $sql_seCluster1, $params_seCluster1);
      while ($result_seCluster1 = sqlsrv_fetch_array($query_seCluster1, SQLSRV_FETCH_ASSOC)) {
        ?>
        <option value="<?= $result_seCluster1['CLUSTER'] ?>"><?= $result_seCluster1['CLUSTER'] ?></option>
        <?php
      }
      ?>
    </select>
    <input class="form-control" style="display:none"   id="txt_cluster_rccratcsh" name="txt_cluster_rccratcsh" maxlength="200" value="" >
    <div class="dropdown-menu open" role="combobox">
      <div class="bs-searchbox">
        <input type="text" class="form-control" autocomplete="off" role="textbox" aria-label="Search"></div>
        <div class="bs-actionsbox">
          <div class="btn-group btn-group-sm btn-block">
            <button type="button" class="actions-btn bs-select-all btn btn-default">Select All</button>
            <button type="button" class="actions-btn bs-deselect-all btn btn-default">Deselect All</button>
          </div>
        </div>
        <div class="inner open" role="listbox" aria-expanded="false" tabindex="-1">
          <ul class="dropdown-menu inner "></ul>
        </div>
      </div>
    </div>
    <?php
}
  if ($_POST['txt_flg'] == "show_copydiagramcluster_compen") {
    ?>
    <div class="dropdown bootstrap-select show-tick form-control">
      <select multiple="" id="cb_copydiagramcluster_rccratc" name="cb_copydiagramcluster_rccratc" class="selectpicker_rccratc form-control" data-container="body" data-live-search="true" title="เลือก คลัสเตอร์ รอบวิ่งงานที่ 1..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
        <?php
        $condiCluster11 = " AND WORKTYPE='".$_POST['worktype']."' AND COMPANYCODE ='".$_POST['companycode']."' AND CUSTOMERCODE = '".$_POST['customercode']."' ";
        $condiCluster12 = "";
        $condiCluster13 = "";
        $sql_seCluster1 = "{call megVehicletransportprice_v2(?,?,?,?)}";
        
        $params_seCluster1 = array(
        array('select_cluster_newrccratc', SQLSRV_PARAM_IN),
        array($condiCluster11, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),

        );
        $query_seCluster1 = sqlsrv_query($conn, $sql_seCluster1, $params_seCluster1);
        while ($result_seCluster1 = sqlsrv_fetch_array($query_seCluster1, SQLSRV_FETCH_ASSOC)) {
          ?>
          <option value="<?= $result_seCluster1['CLUSTER'] ?>"><?= $result_seCluster1['CLUSTER'] ?></option>
          <?php
        }
        ?>
      </select>
      <input class="form-control" style="display:none"   id="txt_cluster_rccratc" name="txt_cluster_rccratc" maxlength="200" value="" >
      <div class="dropdown-menu open" role="combobox">
        <div class="bs-searchbox">
          <input type="text" class="form-control" autocomplete="off" role="textbox" aria-label="Search"></div>
          <div class="bs-actionsbox">
            <div class="btn-group btn-group-sm btn-block">
              <button type="button" class="actions-btn bs-select-all btn btn-default">Select All</button>
              <button type="button" class="actions-btn bs-deselect-all btn btn-default">Deselect All</button>
            </div>
          </div>
          <div class="inner open" role="listbox" aria-expanded="false" tabindex="-1">
            <ul class="dropdown-menu inner "></ul>
          </div>
        </div>
      </div>
      <?php
}
if ($_POST['txt_flg'] == "show_copydiagramcluster1") {
  ?>
  <div class="dropdown bootstrap-select show-tick form-control" onclick="create_jobno('job1');">
    <select multiple=""   id="cb_copydiagramcluster1" name="cb_copydiagramcluster1" class="selectpicker_round1 form-control" data-container="body" data-live-search="true" title="เลือก คลัสเตอร์ รอบวิ่งงานที่ 1..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
      <?php
      $condiCluster11 = " AND WORKTYPE='".$_POST['worktype']."' AND COMPANYCODE ='".$_POST['companycode']."' AND CUSTOMERCODE = '".$_POST['customercode']."' ";
      $condiCluster12 = "";
      $condiCluster13 = "";
      $sql_seCluster1 = "{call megVehicletransportprice_v2(?,?,?,?)}";
      
      $params_seCluster1 = array(
      array('select_cluster_newrccratc', SQLSRV_PARAM_IN),
      array($condiCluster11, SQLSRV_PARAM_IN),
      array('', SQLSRV_PARAM_IN),
      array('', SQLSRV_PARAM_IN),
      array('', SQLSRV_PARAM_IN),

      );
      $query_seCluster1 = sqlsrv_query($conn, $sql_seCluster1, $params_seCluster1);
      while ($result_seCluster1 = sqlsrv_fetch_array($query_seCluster1, SQLSRV_FETCH_ASSOC)) {
        ?>
        <option value="<?= $result_seCluster1['CLUSTER'] ?>"><?= $result_seCluster1['CLUSTER'] ?></option>
        <?php
      }
      ?>
    </select>
    <input class="form-control" style="display:none"   id="txt_cluster_round1" name="txt_cluster_round1" maxlength="200" value="" >
    <div class="dropdown-menu open" role="combobox">
      <div class="bs-searchbox">
        <input type="text" class="form-control" autocomplete="off" role="textbox" aria-label="Search"></div>
        <div class="bs-actionsbox">
          <div class="btn-group btn-group-sm btn-block">
            <button type="button" class="actions-btn bs-select-all btn btn-default">Select All</button>
            <button type="button" class="actions-btn bs-deselect-all btn btn-default">Deselect All</button>
          </div>
        </div>
        <div class="inner open" role="listbox" aria-expanded="false" tabindex="-1">
          <ul class="dropdown-menu inner "></ul>
        </div>
      </div>
    </div>
    <?php
  }
if ($_POST['txt_flg'] == "show_copydiagramcluster2") {
  ?>
  <div class="dropdown bootstrap-select show-tick form-control" onclick="create_jobno('job2');">
    <select multiple="" id="cb_copydiagramcluster2" name="cb_copydiagramcluster2" class="selectpicker_round2 form-control" data-container="body" data-live-search="true" title="เลือก คลัสเตอร์ รอบวิ่งงานที่ 2..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
      <?php
      $condiCluster21 = " AND WORKTYPE='".$_POST['worktype']."' AND COMPANYCODE ='".$_POST['companycode']."' AND CUSTOMERCODE = '".$_POST['customercode']."' ";
      $condiCluster22 = "";
      $condiCluster23 = "";
      $sql_seCluster2 = "{call megVehicletransportprice_v2(?,?,?,?)}";
      $params_seCluster2 = array(
      array('select_cluster_newrccratc', SQLSRV_PARAM_IN),
      array($condiCluster21, SQLSRV_PARAM_IN),
      array('', SQLSRV_PARAM_IN),
      array('', SQLSRV_PARAM_IN),
      array('', SQLSRV_PARAM_IN),

      );
      $query_seCluster2 = sqlsrv_query($conn, $sql_seCluster2, $params_seCluster2);
      while ($result_seCluster2 = sqlsrv_fetch_array($query_seCluster2, SQLSRV_FETCH_ASSOC)) {
        ?>
        <option value="<?= $result_seCluster2['CLUSTER'] ?>"><?= $result_seCluster2['CLUSTER'] ?></option>
        <?php
      }
      ?>
    </select>
    <input class="form-control" style="display:none"   id="txt_cluster_round2" name="txt_cluster_round2" maxlength="200" value="" >
    <div class="dropdown-menu open" role="combobox">
      <div class="bs-searchbox">
        <input type="text" class="form-control" autocomplete="off" role="textbox" aria-label="Search"></div>
        <div class="bs-actionsbox">
          <div class="btn-group btn-group-sm btn-block">
            <button type="button" class="actions-btn bs-select-all btn btn-default">Select All</button>
            <button type="button" class="actions-btn bs-deselect-all btn btn-default">Deselect All</button>
          </div>
        </div>
        <div class="inner open" role="listbox" aria-expanded="false" tabindex="-1">
          <ul class="dropdown-menu inner "></ul>
        </div>
      </div>
    </div>
    <?php
  }
if ($_POST['txt_flg'] == "show_copydiagramcluster3") {
  ?>
  <div class="dropdown bootstrap-select show-tick form-control" onclick="create_jobno('job3');">

    <select multiple="" id="cb_copydiagramcluster3" name="cb_copydiagramcluster3" class="selectpicker_round3 form-control" data-container="body" data-live-search="true" title="เลือก คลัสเตอร์ รอบวิ่งงานที่ 3..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
      <?php
      $condiCluster31 = " AND WORKTYPE='".$_POST['worktype']."' AND COMPANYCODE ='".$_POST['companycode']."' AND CUSTOMERCODE = '".$_POST['customercode']."' ";
      $condiCluster32 = "";
      $condiCluster33 = "";
      $sql_seCluster3 = "{call megVehicletransportprice_v2(?,?,?,?)}";
      $params_seCluster3 = array(
      array('select_cluster_newrccratc', SQLSRV_PARAM_IN),
      array($condiCluster31, SQLSRV_PARAM_IN),
      array('', SQLSRV_PARAM_IN),
      array('', SQLSRV_PARAM_IN),
      array('', SQLSRV_PARAM_IN),

      );
      $query_seCluster3 = sqlsrv_query($conn, $sql_seCluster3, $params_seCluster3);
      while ($result_seCluster3 = sqlsrv_fetch_array($query_seCluster3, SQLSRV_FETCH_ASSOC)) {
        ?>
        <option value="<?= $result_seCluster3['CLUSTER'] ?>"><?= $result_seCluster3['CLUSTER'] ?></option>
        <?php
      }
      ?>
    </select>
    <input class="form-control" style="display:none"   id="txt_cluster_round3" name="txt_cluster_round3" maxlength="200" value="" >


    <div class="dropdown-menu open" role="combobox">
      <div class="bs-searchbox">
        <input type="text" class="form-control" autocomplete="off" role="textbox" aria-label="Search"></div>
        <div class="bs-actionsbox">
          <div class="btn-group btn-group-sm btn-block">
            <button type="button" class="actions-btn bs-select-all btn btn-default">Select All</button>
            <button type="button" class="actions-btn bs-deselect-all btn btn-default">Deselect All</button>
          </div>
        </div>
        <div class="inner open" role="listbox" aria-expanded="false" tabindex="-1">
          <ul class="dropdown-menu inner "></ul>
        </div>
      </div>
    </div>


    <?php
  }
if ($_POST['txt_flg'] == "show_copydiagramcluster4") {
  ?>
  <div class="dropdown bootstrap-select show-tick form-control" onclick="create_jobno('job4');">

    <select multiple="" id="cb_copydiagramcluster4" name="cb_copydiagramcluster4" class="selectpicker_round4 form-control" data-container="body" data-live-search="true" title="เลือก คลัสเตอร์ รอบวิ่งงานที่ 4..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
      <?php
      $condiCluster41 = " AND WORKTYPE='".$_POST['worktype']."' AND COMPANYCODE ='".$_POST['companycode']."' AND CUSTOMERCODE = '".$_POST['customercode']."' ";
      $condiCluster42 = "";
      $condiCluster43 = "";
      $sql_seCluster4 = "{call megVehicletransportprice_v2(?,?,?,?)}";
      $params_seCluster4 = array(
      array('select_cluster_newrccratc', SQLSRV_PARAM_IN),
      array($condiCluster41, SQLSRV_PARAM_IN),
      array('', SQLSRV_PARAM_IN),
      array('', SQLSRV_PARAM_IN),
      array('', SQLSRV_PARAM_IN),

      );
      $query_seCluster4 = sqlsrv_query($conn, $sql_seCluster4, $params_seCluster4);
      while ($result_seCluster4 = sqlsrv_fetch_array($query_seCluster4, SQLSRV_FETCH_ASSOC)) {
        ?>
        <option value="<?= $result_seCluster4['CLUSTER'] ?>"><?= $result_seCluster4['CLUSTER'] ?></option>
        <?php
      }
      ?>
    </select>
    <input class="form-control" style="display:none"   id="txt_cluster_round4" name="txt_cluster_round4" maxlength="200" value="" >


    <div class="dropdown-menu open" role="combobox">
      <div class="bs-searchbox">
        <input type="text" class="form-control" autocomplete="off" role="textbox" aria-label="Search"></div>
        <div class="bs-actionsbox">
          <div class="btn-group btn-group-sm btn-block">
            <button type="button" class="actions-btn bs-select-all btn btn-default">Select All</button>
            <button type="button" class="actions-btn bs-deselect-all btn btn-default">Deselect All</button>
          </div>
        </div>
        <div class="inner open" role="listbox" aria-expanded="false" tabindex="-1">
          <ul class="dropdown-menu inner "></ul>
        </div>
      </div>
    </div>


    <?php
  }if ($_POST['txt_flg'] == "create_jobno") {
    echo create_jobno(substr($_POST['companycode'], 0, 3), $_POST['jobdate']);
  }
  if ($_POST['txt_flg'] == "save_copydiagramvehicletransportplan") {

    $rs = insCopydiagramvehicletransportplan_new_rccratc(
    $_POST['txt_flg'], 
    $_POST['VEHICLETRANSPORTPLANID'], 
    $_POST['STARTDATE'], 
    $_POST['ENDDATE'], 
    $_POST['CUSTOMERCODE'], 
    $_POST['COMPANYCODE'], 
    $_POST['THAINAME'], 
    $_POST['JOBSTART'], 
    $_POST['CLUSTER'], 
    $_POST['JOBEND'], 
    $_POST['EMPLOYEENAME1'], 
    $_POST['EMPLOYEENAME2'], 
    $_POST['EMPLOYEENAME3'], 
    $_POST['JOBNO'], 
    $_POST['DATEINPUT'], 
    $_POST['DATEPRESENT'], 
    $_POST['DATEWORKING'], 
    $_POST['DATERK'], 
    $_POST['DATEVLIN'], 
    $_POST['DATEVLOUT'], 
    $_POST['DATEDEALERIN'], 
    $_POST['DATERETURN'], 
    $_POST['VEHICLETYPE'], 
    $_POST['MATERIALTYPE'], 
    $_POST['GORETURN'], 
    $_POST['WORKTYPE'], 
    $_POST['LOAD'], 
    $_POST['ROUTE'], 
    $_POST['UNIT'], 
    $_POST['ROUNDAMOUNT'], 
    $_POST['DN'], 
    $_POST['CARRYTYPE'], 
    $_POST['THAINAME2'], 
    $_POST['BILLING'], 
    $_POST['CREATEBY'],
    "",
    "",
    "");

    // if ($_POST['companycode'] == 'RCC' || $_POST['companycode'] == 'RATC' || $_POST['companycode'] == 'RRC') {
    //   updatevehicletransportplan_getway();
    //} else if ($_POST['companycode'] == 'RKS') {
    //  if ($_POST['customercode'] == 'STM' || $_POST['customercode'] == 'TMT' || $_POST['customercode'] == 'TAW' || $_POST['customercode'] == 'TGT') {
    //    updatevehicletransportplan_stmtmttawtgt();
    //  } else if ($_POST['customercode'] == 'DENSO-THAI') {
    //    updatevehicletransportplan_denso();
    //  }
    //}

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
  if ($_POST['txt_flg'] == "edit_vehicletransportplanrccratc") {
  
      if ($_POST['fieldname'] == 'ROUNDAMOUNT') {
          // echo "ROUNDAMOUNT";
          $sql_updatedata = "UPDATE VEHICLETRANSPORTPLAN
          SET ROUNDAMOUNT = '" . $_POST['editableObj'] . "' 
          WHERE VEHICLETRANSPORTPLANID ='" . $_POST['planid'] . "'";
          $query_updatedata  = sqlsrv_query($conn, $sql_updatedata, $params_updatedata);
          $result_updatedata = sqlsrv_fetch_array($query_updatedata, SQLSRV_FETCH_ASSOC);    
      }else if($_POST['fieldname'] == 'C8'){
          // echo "C8";
          $sql_updatedata = "UPDATE VEHICLETRANSPORTPLAN
          SET C8 = '" . $_POST['editableObj'] . "' 
          WHERE VEHICLETRANSPORTPLANID ='" . $_POST['planid'] . "'";
          $query_updatedata  = sqlsrv_query($conn, $sql_updatedata, $params_updatedata);
          $result_updatedata = sqlsrv_fetch_array($query_updatedata, SQLSRV_FETCH_ASSOC);
      }else if($_POST['fieldname'] == 'C2'){
        // echo "C8";
        $sql_updatedata = "UPDATE VEHICLETRANSPORTPLAN
        SET C2 = '" . $_POST['editableObj'] . "' 
        WHERE VEHICLETRANSPORTPLANID ='" . $_POST['planid'] . "'";
        $query_updatedata  = sqlsrv_query($conn, $sql_updatedata, $params_updatedata);
        $result_updatedata = sqlsrv_fetch_array($query_updatedata, SQLSRV_FETCH_ASSOC);
      }else{

      }
      //   echo $result['TIMEREST'];
  }
  if ($_POST['txt_flg'] == "edit_vehicletransportplanmix_newrccratc") {
    $rs = editCopydiagramvehicletransportplan_newrccratc($_POST['txt_flg'], $_POST['VEHICLETRANSPORTPLANID'], $_POST['EMPLOYEENAME1'], $_POST['EMPLOYEENAME2'], $_POST['VEHICLEINFO'], $_POST['CLUSTER'], $_POST['JOBEND'], $_POST['LOAD'], $_POST['copydiagramdaterkupd'], $_POST['copydiagramdatevlinupd'], $_POST['copydiagramdatevloutupd'], $_POST['copydiagramdatedealerinupd'], $_POST['copydiagramdatereturnupd'], $_POST['JOBSTART'], $_POST['WORKTYPE']);
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
  if ($_POST['txt_flg'] == "edit_vehicletransportplanmix_update") {
    $rs = editCopydiagramvehicletransportplan_newrccratc($_POST['txt_flg'], $_POST['VEHICLETRANSPORTPLANID'], $_POST['EMPLOYEENAME1'], $_POST['EMPLOYEENAME2'], $_POST['VEHICLEINFO'], $_POST['CLUSTER'], $_POST['JOBEND'], $_POST['LOAD'], $_POST['copydiagramdaterkupd'], $_POST['copydiagramdatevlinupd'], $_POST['copydiagramdatevloutupd'], $_POST['copydiagramdatedealerinupd'], $_POST['copydiagramdatereturnupd'], $_POST['JOBSTART'], $_POST['WORKTYPE']);
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
?>
<?php
sqlsrv_close($conn);
?>
