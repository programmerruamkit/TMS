<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");




// select_tenko2emp1 ย้ายไป meg_data_tenkotransport
if ($_POST['txt_flg'] == "select_tenko2emp1") {
    $condition1 = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
    $sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEmployee = array(
        array('select_employeeehr2', SQLSRV_PARAM_IN),
        array($condition1, SQLSRV_PARAM_IN)
    );
    $query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
    $result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);

    $conditionPlain = " AND a.VEHICLETRANSPORTPLANID = '" . $_POST['vehicletransportplanid'] . "'";
    $sql_sePlain = "{call megVehicletransportplan_v2(?,?)}";
    $params_sePlain = array(
        array('select_vehicletransportplan', SQLSRV_PARAM_IN),
        array($conditionPlain, SQLSRV_PARAM_IN)
    );
    $query_sePlain = sqlsrv_query($conn, $sql_sePlain, $params_sePlain);
    $result_sePlain = sqlsrv_fetch_array($query_sePlain, SQLSRV_FETCH_ASSOC);

    $conditionTenkomaster_temp = " AND VEHICLETRANSPORTPLANID = '" . $_POST['vehicletransportplanid'] . "'";
    $sql_seTenkomaster_temp = "{call megVehicletransportplan_v2(?,?,?,?)}";
    $params_seTenkomaster_temp = array(
        array('select_vehicletransporttenko', SQLSRV_PARAM_IN),
        array($conditionTenkomaster_temp, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seTenkomaster_temp = sqlsrv_query($conn, $sql_seTenkomaster_temp, $params_seTenkomaster_temp);
    $result_seTenkomaster_temp = sqlsrv_fetch_array($query_seTenkomaster_temp, SQLSRV_FETCH_ASSOC);

    $conditionTenkomaster = " AND a.TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "'";
    $sql_seTenkomaster = "{call megEdittenkomaster_v2(?,?)}";
    $params_seTenkomaster = array(
        array('select_tenkomaster', SQLSRV_PARAM_IN),
        array($conditionTenkomaster, SQLSRV_PARAM_IN)
    );
    $query_seTenkomaster = sqlsrv_query($conn, $sql_seTenkomaster, $params_seTenkomaster);
    $result_seTenkomaster = sqlsrv_fetch_array($query_seTenkomaster, SQLSRV_FETCH_ASSOC);

    $sql_checkSexT = "SELECT SexT AS 'SexT' FROM EMPLOYEEEHR2 WHERE PersonCode ='".$result_sePlain['EMPLOYEENAME1']."'";
    $params_checkSexT = array();
    $query_checkSexT = sqlsrv_query($conn, $sql_checkSexT, $params_checkSexT);
    $result_checkSexT = sqlsrv_fetch_array($query_checkSexT, SQLSRV_FETCH_ASSOC);

    if ($result_checkSexT['SexT'] == 'หญิง') {
        $sex = 'นางสาว';
    }else{
        $sex = 'นาย';
    }

    
    ?>

    <div class="panel-body">
        <!-- Nav tabs -->
        
        <ul class="nav nav-tabs">
            <li class="active"><a href="#day1" data-toggle="tab"><?= $result_seTenkomaster['DATEINPUT_F1'] ?></a></li>
            <?php
            // บริษัท RRC tenko ระหว่างทางสูงสุดได้ 4 วัน
            if ($result_sePlain['COMPANYCODE'] == 'RRC') {
            ?>  
                <li><a href="#day2" data-toggle="tab"><?= $result_seTenkomaster['DATEINPUT_F2'] ?></a></li>
                <li><a href="#day3" data-toggle="tab"><?= $result_seTenkomaster['DATEINPUT_F3'] ?></a></li>
                <li><a href="#day4" data-toggle="tab"><?= $result_seTenkomaster['DATEINPUT_F4'] ?></a></li>
            </li>
                <?php
            } else {
                if ($result_sePlain['CUSTOMERCODE'] == 'SKB' || $result_sePlain['CUSTOMERCODE'] == 'TTT' 
                || $result_sePlain['CUSTOMERCODE'] == 'GMT' || $result_sePlain['CUSTOMERCODE'] == 'TTASTCS' 
                || $result_sePlain['CUSTOMERCODE'] == 'TTTCSTC') {
                ?>
                <li><a href="#day2" data-toggle="tab"><?= $result_seTenkomaster['DATEINPUT_F2'] ?></a></li>
                <li><a href="#day3" data-toggle="tab"><?= $result_seTenkomaster['DATEINPUT_F3'] ?></a></li>
                <li><a href="#day4" data-toggle="tab"><?= $result_seTenkomaster['DATEINPUT_F4'] ?></a></li>
                <li><a href="#day5" data-toggle="tab"><?= $result_seTenkomaster['DATEINPUT_F5'] ?></a></li>
                <?php
                }
            }
            ?>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane fade in active" id="day1">
                <?php
                // echo $result_seTenkomaster_temp['TENKOMASTERID'];
                //echo $result_seTenkomaster['DATEINPUT_F1'];
                $conditionTenkotransport11 = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_POST['employeecode1'] . "' ";
                $conditionTenkotransport12 = " AND CONVERT(DATE,TENKOTRANSPORTDATE) = CONVERT(DATE,'" . $result_seTenkomaster['DATEINPUT_F1'] . "',103)";
                $sql_seTenkotransport1 = "{call megEdittenkotransport_v2(?,?,?)}";
                $params_seTenkotransport1 = array(
                    array('select_tenkotransport', SQLSRV_PARAM_IN),
                    array($conditionTenkotransport11, SQLSRV_PARAM_IN),
                    array($conditionTenkotransport12, SQLSRV_PARAM_IN)
                );
                $query_seTenkotransport1 = sqlsrv_query($conn, $sql_seTenkotransport1, $params_seTenkotransport1);
                $result_seTenkotransport1 = sqlsrv_fetch_array($query_seTenkotransport1, SQLSRV_FETCH_ASSOC);


                $rs1d1 = ($result_seTenkotransport1['TENKOLOADRESTCHECK'] == '1') ? "checked" : "";
                $rs2d1 = ($result_seTenkotransport1['TENKOBODYSLEEPYCHECK'] == '1') ? "checked" : "";
                $rs3d1 = ($result_seTenkotransport1['TENKOCARNEWCHECK'] == '1') ? "checked" : "";
                $rs4d1 = ($result_seTenkotransport1['TENKOTRAILERCHECK'] == '1') ? "checked" : "";
                $rs5d1 = ($result_seTenkotransport1['TENKOROADCHECK'] == '1') ? "checked" : "";
                $rs6d1 = ($result_seTenkotransport1['TENKOAIRCHECK'] == '1') ? "checked" : "";
                $rs7d1 = ($result_seTenkotransport1['TENKOSLEEPYCHECK'] == '1') ? "checked" : "";
                ?>
                <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                    <thead>
                        <tr>
                           
                            <!-- Commit_Emp1Day1 -->
                            <th colspan="6" ><input type="button" onclick="commit_2('<?= $result_seTenkomaster_temp['TENKOMASTERID'] ?>','<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>', '<?= $result_seEmployee['nameT'] ?>')"   class="btn btn-success" value="Commit1_Day1"> <font style="color: green">พนักงานขับรถ : <?= $sex?> <?= $result_sePlain['EMPLOYEENAME1'] ?></font></th>
                           
                            <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะก่อนเริ่มงาน</th>
                            <th style="text-align: center;"><?= $result_seTenkotransport1["CREATEBY"] ?></th>
                            <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะปฎิบัติงาน</th>
                            <th style="text-align: center;"><?= $result_seEmployee['nameT'] ?></th>
                        </tr>
                        <tr>

                            <th colspan="12">เจ้าหน้าที่โทรไปไม่พบสิ่งผิดปกติ : <font style="color: red">0</font>  | พนักงานขับรถโทรมาไม่พบสิ่งผิดปกติ : <font style="color: red">1</font> | พบสิ่งผิดปกติ : <font style="color: red">x</font></th>
                        </tr>
                        <tr>

                            <th rowspan="4" style="text-align: center;">ข้อ</th>
                            <th rowspan="4" style="text-align: center;">หัวข้อ</th>
                            <th rowspan="4" style="text-align: center;">ช่องตรวจ</th>
                            <th rowspan="4" style="text-align: center;">เกณฑ์การตัดสิน</th>
                            <th rowspan="2" style="text-align: center;"><p>โทรช่วง </p>
                                <p>00:01 - 23:59</p></th>
                            <th colspan="6" style="text-align: center">Night Call Check</th>
                            <th rowspan="4"style="text-align: center;">รายละเอียดการแนะนำของเจ้าหน้าที่</th>
                        </tr>
                        <tr>

                            <th style="text-align: center;">ครั้งที่ 1</th>
                            <th style="text-align: center;">ครั้งที่ 2</th>
                            <th style="text-align: center;">ครั้งที่ 3</th>
                            <th style="text-align: center;">ครั้งที่ 4</th>
                            <th style="text-align: center;">ครั้งที่ 5</th>
                            <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">ครั้งที่ 6</th>
                        </tr>
                        <tr>

                            <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME0', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control timeen" id="txt_time0" name="txt_time0" value="<?= $result_seTenkotransport1['TENKOTIME0'] ?>"></th>
                            <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME1', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control timeen" id="txt_time1" name="txt_time1" value="<?= $result_seTenkotransport1['TENKOTIME1'] ?>"></th>
                            <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME2', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control timeen" id="txt_time2" name="txt_time2" value="<?= $result_seTenkotransport1['TENKOTIME2'] ?>"></th>
                            <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME3', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control timeen" id="txt_time3" name="txt_time3" value="<?= $result_seTenkotransport1['TENKOTIME3'] ?>"></th>
                            <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME4', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control timeen" id="txt_time4" name="txt_time4" value="<?= $result_seTenkotransport1['TENKOTIME4'] ?>"></th>
                            <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME5', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control timeen" id="txt_time5" name="txt_time5" value="<?= $result_seTenkotransport1['TENKOTIME5'] ?>"></th>
                            <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME6', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control timeen" id="txt_time6" name="txt_time6" value="<?= $result_seTenkotransport1['TENKOTIME6'] ?>"></th>
                        </tr>
                        <tr>

                            <th style="text-align: center;">ผล</th>
                            <th style="text-align: center;">ผล</th>
                            <th style="text-align: center;">ผล</th>
                            <th style="text-align: center;">ผล</th>
                            <th style="text-align: center;">ผล</th>
                            <th style="text-align: center;">ผล</th>
                            <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">ผล</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: center">1</td>
                            <td>เส้นทางที่กำหนด - จุดพัก</td>
                            <td style="text-align: center"><input type="checkbox" <?= $rs1d1 ?> onchange="edit_check1d1('TENKOLOADRESTCHECK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" style="transform: scale(2)" id="chk_1d1" name="chk_1d1" /></td>
                            <td>เส้นทาง จุดพักที่กำหนด</td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT0', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT0" name="TXT_TENKOLOADRESTRESULT0" value="<?= $result_seTenkotransport1['TENKOLOADRESTRESULT0'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT0', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT0" name="TXT_TENKOBODYSLEEPYRESULT0" value="<?= $result_seTenkotransport1['TENKOBODYSLEEPYRESULT0'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT0', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT0" name="TXT_TENKOCARNEWRESULT0" value="<?= $result_seTenkotransport1['TENKOCARNEWRESULT0'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT0', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT0" name="TXT_TENKOTRAILERRESULT0" value="<?= $result_seTenkotransport1['TENKOTRAILERRESULT0'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT0', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOROADRESULT0" name="TXT_TENKOROADRESULT0" value="<?= $result_seTenkotransport1['TENKOROADRESULT0'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT0', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT0" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport1['TENKOAIRRESULT0'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT0', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT0" name="TXT_TENKOSLEEPYRESULT0" value="<?= $result_seTenkotransport1['TENKOSLEEPYRESULT0'] ?>"></td>
                            <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOLOADRESTREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"  class="form-control" value="<?= $result_seTenkotransport1['TENKOLOADRESTREMARK'] ?>"></td>
                            <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOLOADRESTREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"><?= $result_seTenkotransport1['TENKOLOADRESTREMARK'] ?></td> -->
                        </tr>
                        <tr>
                            <td style="text-align: center">2</td>
                            <td>ตรวจร่างกาย - อาการง่วง</td>
                            <td style="text-align: center"><input type="checkbox" <?= $rs2d1 ?> onchange="edit_check2d1('TENKOBODYSLEEPYCHECK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" style="transform: scale(2)"  id="chk_2d1" name="chk_2d1"/></td>
                            <td>วิธีการพูดคุยต้องร่าเริง</td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT1', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT1" name="TXT_TENKOLOADRESTRESULT1" value="<?= $result_seTenkotransport1['TENKOLOADRESTRESULT1'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT1', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT1" name="TXT_TENKOBODYSLEEPYRESULT1" value="<?= $result_seTenkotransport1['TENKOBODYSLEEPYRESULT1'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT1', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT1" name="TXT_TENKOCARNEWRESULT1" value="<?= $result_seTenkotransport1['TENKOCARNEWRESULT1'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT1', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT1" name="TXT_TENKOTRAILERRESULT1" value="<?= $result_seTenkotransport1['TENKOTRAILERRESULT1'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT1', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOROADRESULT1" name="TXT_TENKOROADRESULT1" value="<?= $result_seTenkotransport1['TENKOROADRESULT1'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT1', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT1" name="TXT_TENKOAIRRESULT1" value="<?= $result_seTenkotransport1['TENKOAIRRESULT1'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT1', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT1" name="TXT_TENKOSLEEPYRESULT1" value="<?= $result_seTenkotransport1['TENKOSLEEPYRESULT1'] ?>"></td>
                            <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOBODYSLEEPYREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"  class="form-control" value="<?= $result_seTenkotransport1['TENKOBODYSLEEPYREMARK'] ?>"></td>
                            <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOBODYSLEEPYREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"><?= $result_seTenkotransport1['TENKOBODYSLEEPYREMARK'] ?></td> -->
                        </tr>
                        <tr>
                            <td style="text-align: center">3</td>
                            <td>ตรวจรถใหม่ (เฉพาะหยุดรถ)</td>
                            <td style="text-align: center"><input type="checkbox" <?= $rs3d1 ?> onchange="edit_check3d1('TENKOCARNEWCHECK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" style="transform: scale(2)"  id="chk_3d1" name="chk_3d1"/></td>
                            <td>มีการรายงานเกี่ยวกับรถใหม่ว่ามีสิ่งผิดปกติหรือไม่</td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT2', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT2" name="TXT_TENKOLOADRESTRESULT2" value="<?= $result_seTenkotransport1['TENKOLOADRESTRESULT2'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT2', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT2" name="TXT_TENKOBODYSLEEPYRESULT2" value="<?= $result_seTenkotransport1['TENKOBODYSLEEPYRESULT2'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT2', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT2" name="TXT_TENKOCARNEWRESULT2" value="<?= $result_seTenkotransport1['TENKOCARNEWRESULT2'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT2', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT2" name="TXT_TENKOTRAILERRESULT2" value="<?= $result_seTenkotransport1['TENKOTRAILERRESULT2'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT2', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOROADRESULT2" name="TXT_TENKOROADRESULT2" value="<?= $result_seTenkotransport1['TENKOROADRESULT2'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT2', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT2" name="TXT_TENKOAIRRESULT2" value="<?= $result_seTenkotransport1['TENKOAIRRESULT2'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT2', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT2" name="TXT_TENKOSLEEPYRESULT2" value="<?= $result_seTenkotransport1['TENKOSLEEPYRESULT2'] ?>"></td>
                            <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOCARNEWREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"  class="form-control" value="<?= $result_seTenkotransport1['TENKOCARNEWREMARK'] ?>"></td>
                            <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOCARNEWREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"><?= $result_seTenkotransport1['TENKOCARNEWREMARK'] ?></td> -->
                        </tr>
                        <tr>
                            <td style="text-align: center">4</td>
                            <td>ตรวจเทรลเลอร์</td>
                            <td style="text-align: center"><input type="checkbox" <?= $rs4d1 ?> onchange="edit_check4d1('TENKOTRAILERCHECK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" style="transform: scale(2)"  id="chk_4d1" name="chk_4d1"/></td>
                            <td>ระหว่างวิ่งงานไม่มีสิ่งผิดปกติ</td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT3', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT3" name="TXT_TENKOLOADRESTRESULT3" value="<?= $result_seTenkotransport1['TENKOLOADRESTRESULT3'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT3', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT3" name="TXT_TENKOBODYSLEEPYRESULT3" value="<?= $result_seTenkotransport1['TENKOBODYSLEEPYRESULT3'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT3', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT3" name="TXT_TENKOCARNEWRESULT3" value="<?= $result_seTenkotransport1['TENKOCARNEWRESULT3'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT3', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT3" name="TXT_TENKOTRAILERRESULT3" value="<?= $result_seTenkotransport1['TENKOTRAILERRESULT3'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT3', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOROADRESULT3" name="TXT_TENKOROADRESULT3" value="<?= $result_seTenkotransport1['TENKOROADRESULT3'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT3', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT3" name="TXT_TENKOAIRRESULT3" value="<?= $result_seTenkotransport1['TENKOAIRRESULT3'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT3', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT3" name="TXT_TENKOSLEEPYRESULT3" value="<?= $result_seTenkotransport1['TENKOSLEEPYRESULT3'] ?>"></td>
                            <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOTRAILERREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"  class="form-control" value="<?= $result_seTenkotransport1['TENKOTRAILERREMARK'] ?>"></td>
                            <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOTRAILERREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"><?= $result_seTenkotransport1['TENKOTRAILERREMARK'] ?></td> -->
                        </tr>
                        <tr>
                            <td style="text-align: center">5</td>
                            <td>ตรวจสภาพถนน</td>
                            <td style="text-align: center"><input type="checkbox" <?= $rs5d1 ?> onchange="edit_check5d1('TENKOROADCHECK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" style="transform: scale(2)"  id="chk_5d1" name="chk_5d1"/></td>
                            <td>รายงานสภาพถนน</td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT4', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT4" name="TXT_TENKOLOADRESTRESULT4" value="<?= $result_seTenkotransport1['TENKOLOADRESTRESULT4'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT4', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT4" name="TXT_TENKOBODYSLEEPYRESULT4" value="<?= $result_seTenkotransport1['TENKOBODYSLEEPYRESULT4'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT4', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT4" name="TXT_TENKOCARNEWRESULT4" value="<?= $result_seTenkotransport1['TENKOCARNEWRESULT4'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT4', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT4" name="TXT_TENKOTRAILERRESULT4" value="<?= $result_seTenkotransport1['TENKOTRAILERRESULT4'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT4', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOROADRESULT4" name="TXT_TENKOROADRESULT4" value="<?= $result_seTenkotransport1['TENKOROADRESULT4'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT4', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT4" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport1['TENKOAIRRESULT4'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT4', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT4" name="TXT_TENKOSLEEPYRESULT4" value="<?= $result_seTenkotransport1['TENKOSLEEPYRESULT4'] ?>"></td>
                            <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOROADREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"  class="form-control" value="<?= $result_seTenkotransport1['TENKOROADREMARK'] ?>"></td>
                            <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOROADREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"><?= $result_seTenkotransport1['TENKOROADREMARK'] ?></td> -->
                        </tr>
                        <tr>
                            <td style="text-align: center">6</td>
                            <td>ตรวจสภาพอากาศ (ใช้ที่ปัดน้ำฝนระดับ 3 ให้หยุดรถ)</td>
                            <td style="text-align: center"><input type="checkbox" <?= $rs6d1 ?> onchange="edit_check6d1('TENKOAIRCHECK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" style="transform: scale(2)"  id="chk_6d1" name="chk_6d1"/></td>
                            <td>รายงานสภาพอากาศ1</td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT5', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT5" name="TXT_TENKOLOADRESTRESULT5" value="<?= $result_seTenkotransport1['TENKOLOADRESTRESULT5'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT5', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT5" name="TXT_TENKOBODYSLEEPYRESULT5" value="<?= $result_seTenkotransport1['TENKOBODYSLEEPYRESULT5'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT5', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT5" name="TXT_TENKOCARNEWRESULT5" value="<?= $result_seTenkotransport1['TENKOCARNEWRESULT5'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT5', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT5" name="TXT_TENKOTRAILERRESULT5" value="<?= $result_seTenkotransport1['TENKOTRAILERRESULT5'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT5', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOROADRESULT5" name="TXT_TENKOROADRESULT5" value="<?= $result_seTenkotransport1['TENKOROADRESULT5'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT5', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT5" name="TXT_TENKOAIRRESULT5" value="<?= $result_seTenkotransport1['TENKOAIRRESULT5'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT5', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT5" name="TXT_TENKOSLEEPYRESULT5" value="<?= $result_seTenkotransport1['TENKOSLEEPYRESULT5'] ?>"></td>
                            <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOAIRREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"  class="form-control" value="<?= $result_seTenkotransport1['TENKOAIRREMARK'] ?>"></td>
                            <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOAIRREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"><?= $result_seTenkotransport1['TENKOAIRREMARK'] ?></td> -->
                        </tr>
                        <tr>
                            <td style="text-align: center">7</td>
                            <td>ตรวจสอบอาการง่วงและย้ำให้ระมัดระวัง</td>
                            <td style="text-align: center"><input type="checkbox" <?= $rs7d1 ?> onchange="edit_check7d1('TENKOSLEEPYCHECK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" style="transform: scale(2)" id="chk_7d1" name="chk_7d1" /></td>
                            <td>สภาพที่สามารถวิ่งงานต่อได้</td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT6', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT6" name="TXT_TENKOLOADRESTRESULT6" value="<?= $result_seTenkotransport1['TENKOLOADRESTRESULT6'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT6', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT6" name="TXT_TENKOBODYSLEEPYRESULT6" value="<?= $result_seTenkotransport1['TENKOBODYSLEEPYRESULT6'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT6', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT6" name="TXT_TENKOCARNEWRESULT6" value="<?= $result_seTenkotransport1['TENKOCARNEWRESULT6'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT6', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT6" name="TXT_TENKOTRAILERRESULT6" value="<?= $result_seTenkotransport1['TENKOTRAILERRESULT6'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT6', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOROADRESULT6" name="TXT_TENKOROADRESULT6" value="<?= $result_seTenkotransport1['TENKOROADRESULT6'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT6', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT6" name="TXT_TENKOAIRRESULT6" value="<?= $result_seTenkotransport1['TENKOAIRRESULT6'] ?>"></td>
                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT6', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT6" name="TXT_TENKOSLEEPYRESULT6" value="<?= $result_seTenkotransport1['TENKOSLEEPYRESULT6'] ?>"></td>
                            <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOSLEEPYREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"  class="form-control" value="<?= $result_seTenkotransport1['TENKOSLEEPYREMARK'] ?>"></td>
                            <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOSLEEPYREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"><?= $result_seTenkotransport1['TENKOSLEEPYREMARK'] ?></td> -->
                        </tr>
                    </tbody>
                </table>

            </div>
            
                <div class="tab-pane" id="day2">
                    <?php
                    //echo $result_seTenkomaster['DATEINPUT_F2'];
                    $conditionTenkotransport21 = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_POST['employeecode1'] . "' ";
                    $conditionTenkotransport22 = " AND CONVERT(DATE,TENKOTRANSPORTDATE) = CONVERT(DATE,'" . $result_seTenkomaster['DATEINPUT_F2'] . "',103)";
                    $sql_seTenkotransport2 = "{call megEdittenkotransport_v2(?,?,?)}";
                    $params_seTenkotransport2 = array(
                        array('select_tenkotransport', SQLSRV_PARAM_IN),
                        array($conditionTenkotransport21, SQLSRV_PARAM_IN),
                        array($conditionTenkotransport22, SQLSRV_PARAM_IN)
                    );
                    $query_seTenkotransport2 = sqlsrv_query($conn, $sql_seTenkotransport2, $params_seTenkotransport2);
                    $result_seTenkotransport2 = sqlsrv_fetch_array($query_seTenkotransport2, SQLSRV_FETCH_ASSOC);

                    $rs1d2 = ($result_seTenkotransport2['TENKOLOADRESTCHECK'] == '1') ? "checked" : "";
                    $rs2d2 = ($result_seTenkotransport2['TENKOBODYSLEEPYCHECK'] == '1') ? "checked" : "";
                    $rs3d2 = ($result_seTenkotransport2['TENKOCARNEWCHECK'] == '1') ? "checked" : "";
                    $rs4d2 = ($result_seTenkotransport2['TENKOTRAILERCHECK'] == '1') ? "checked" : "";
                    $rs5d2 = ($result_seTenkotransport2['TENKOROADCHECK'] == '1') ? "checked" : "";
                    $rs6d2 = ($result_seTenkotransport2['TENKOAIRCHECK'] == '1') ? "checked" : "";
                    $rs7d2 = ($result_seTenkotransport2['TENKOSLEEPYCHECK'] == '1') ? "checked" : "";
                    ?>
                    <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                        <thead>
                            <tr>
                               
                                <!-- Commit_Emp1Day2 -->
                                <th colspan="6" ><input type="button" onclick="commit_2('<?= $result_seTenkomaster_temp['TENKOMASTERID'] ?>','<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>', '<?= $result_seEmployee['nameT'] ?>')"   class="btn btn-success" value="Commit1_Day2"> <font style="color: green">พนักงานขับรถ : <?= $sex?> <?= $result_sePlain['EMPLOYEENAME1'] ?></font></th>
               
                                <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะก่อนเริ่มงาน</th>
                                <th style="text-align: center;"><?= $result_seTenkotransport1["CREATEBY"] ?></th>
                                <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะปฎิบัติงาน</th>
                                <th style="text-align: center;"><?= $result_seEmployee["nameT"] ?></th>
                            </tr>
                            <tr>

                                <th colspan="12">เจ้าหน้าที่โทรไปไม่พบสิ่งผิดปกติ : <font style="color: red">0</font>  | พนักงานขับรถโทรมาไม่พบสิ่งผิดปกติ : <font style="color: red">1</font> | พบสิ่งผิดปกติ : <font style="color: red">x</font></th>
                            </tr>
                            <tr>

                                <th rowspan="4" style="text-align: center;">ข้อ</th>
                                <th rowspan="4" style="text-align: center;">หัวข้อ</th>
                                <th rowspan="4" style="text-align: center;">ช่องตรวจ</th>
                                <th rowspan="4" style="text-align: center;">เกณฑ์การตัดสิน</th>
                                <th rowspan="2" style="text-align: center;"><p>โทรช่วง </p>
                                    <p>00:01 - 23:59</p></th>
                                <th colspan="6" style="text-align: center">Night Call Check</th>
                                <th rowspan="4" style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">รายละเอียดการแนะนำของเจ้าหน้าที่</th>
                            </tr>
                            <tr>

                                <th style="text-align: center;">ครั้งที่ 1</th>
                                <th style="text-align: center;">ครั้งที่ 2</th>
                                <th style="text-align: center;">ครั้งที่ 3</th>
                                <th style="text-align: center;">ครั้งที่ 4</th>
                                <th style="text-align: center;">ครั้งที่ 5</th>
                                <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">ครั้งที่ 6</th>
                            </tr>
                            <tr>

                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME0', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control timeen" id="txt_time0" name="txt_time0" value="<?= $result_seTenkotransport2['TENKOTIME0'] ?>"></th>
                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME1', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control timeen" id="txt_time1" name="txt_time1" value="<?= $result_seTenkotransport2['TENKOTIME1'] ?>"></th>
                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME2', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control timeen" id="txt_time2" name="txt_time2" value="<?= $result_seTenkotransport2['TENKOTIME2'] ?>"></th>
                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME3', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control timeen" id="txt_time3" name="txt_time3" value="<?= $result_seTenkotransport2['TENKOTIME3'] ?>"></th>
                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME4', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control timeen" id="txt_time4" name="txt_time4" value="<?= $result_seTenkotransport2['TENKOTIME4'] ?>"></th>
                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME5', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control timeen" id="txt_time5" name="txt_time5" value="<?= $result_seTenkotransport2['TENKOTIME5'] ?>"></th>
                                <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME6', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control timeen" id="txt_time6" name="txt_time6" value="<?= $result_seTenkotransport2['TENKOTIME6'] ?>"></th>
                            </tr>
                            <tr>

                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">ผล</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center">1</td>
                                <td>เส้นทางที่กำหนด - จุดพัก</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs1d2 ?> onchange="edit_check1d2('TENKOLOADRESTCHECK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" style="transform: scale(2)" id="chk_1d2" name="chk_1d2" /></td>
                                <td>เส้นทาง จุดพักที่กำหนด</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT0', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT0" name="TXT_TENKOLOADRESTRESULT0" value="<?= $result_seTenkotransport2['TENKOLOADRESTRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT0', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT0" name="TXT_TENKOBODYSLEEPYRESULT0" value="<?= $result_seTenkotransport2['TENKOBODYSLEEPYRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT0', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT0" name="TXT_TENKOCARNEWRESULT0" value="<?= $result_seTenkotransport2['TENKOCARNEWRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT0', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT0" name="TXT_TENKOTRAILERRESULT0" value="<?= $result_seTenkotransport2['TENKOTRAILERRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT0', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOROADRESULT0" name="TXT_TENKOROADRESULT0" value="<?= $result_seTenkotransport2['TENKOROADRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT0', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT0" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport2['TENKOAIRRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT0', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT0" name="TXT_TENKOSLEEPYRESULT0" value="<?= $result_seTenkotransport2['TENKOSLEEPYRESULT0'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOLOADRESTREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"  class="form-control" value="<?= $result_seTenkotransport2['TENKOLOADRESTREMARK'] ?>"></td>
                                
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOLOADRESTREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"><?= $result_seTenkotransport2['TENKOLOADRESTREMARK'] ?></td> -->
                            </tr>
                             <tr>
                                <td style="text-align: center">2</td>
                                <td>ตรวจร่างกาย - อาการง่วง</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs2d2 ?> onchange="edit_check2d2('TENKOBODYSLEEPYCHECK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" style="transform: scale(2)"  id="chk_2d2" name="chk_2d2"/></td>
                                <td>วิธีการพูดคุยต้องร่าเริง</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT1', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT1" name="TXT_TENKOLOADRESTRESULT1" value="<?= $result_seTenkotransport2['TENKOLOADRESTRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT1', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT1" name="TXT_TENKOBODYSLEEPYRESULT1" value="<?= $result_seTenkotransport2['TENKOBODYSLEEPYRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT1', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT1" name="TXT_TENKOCARNEWRESULT1" value="<?= $result_seTenkotransport2['TENKOCARNEWRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT1', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT1" name="TXT_TENKOTRAILERRESULT1" value="<?= $result_seTenkotransport2['TENKOTRAILERRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT1', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOROADRESULT1" name="TXT_TENKOROADRESULT1" value="<?= $result_seTenkotransport2['TENKOROADRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT1', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT1" name="TXT_TENKOAIRRESULT1" value="<?= $result_seTenkotransport2['TENKOAIRRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT1', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT1" name="TXT_TENKOSLEEPYRESULT1" value="<?= $result_seTenkotransport2['TENKOSLEEPYRESULT1'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOBODYSLEEPYREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"  class="form-control" value="<?= $result_seTenkotransport2['TENKOBODYSLEEPYREMARK'] ?>"></td>
                                
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOBODYSLEEPYREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"><?= $result_seTenkotransport2['TENKOBODYSLEEPYREMARK'] ?></td> -->
                            </tr>
                            <tr>
                                <td style="text-align: center">3</td>
                                <td>ตรวจรถใหม่ (เฉพาะหยุดรถ)</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs3d2 ?> onchange="edit_check3d2('TENKOCARNEWCHECK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" style="transform: scale(2)"  id="chk_3d2" name="chk_3d2"/></td>
                                <td>มีการรายงานเกี่ยวกับรถใหม่ว่ามีสิ่งผิดปกติหรือไม่</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT2', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT2" name="TXT_TENKOLOADRESTRESULT2" value="<?= $result_seTenkotransport2['TENKOLOADRESTRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT2', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT2" name="TXT_TENKOBODYSLEEPYRESULT2" value="<?= $result_seTenkotransport2['TENKOBODYSLEEPYRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT2', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT2" name="TXT_TENKOCARNEWRESULT2" value="<?= $result_seTenkotransport2['TENKOCARNEWRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT2', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT2" name="TXT_TENKOTRAILERRESULT2" value="<?= $result_seTenkotransport2['TENKOTRAILERRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT2', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOROADRESULT2" name="TXT_TENKOROADRESULT2" value="<?= $result_seTenkotransport2['TENKOROADRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT2', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT2" name="TXT_TENKOAIRRESULT2" value="<?= $result_seTenkotransport2['TENKOAIRRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT2', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT2" name="TXT_TENKOSLEEPYRESULT2" value="<?= $result_seTenkotransport2['TENKOSLEEPYRESULT2'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOCARNEWREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"  class="form-control" value="<?= $result_seTenkotransport2['TENKOCARNEWREMARK'] ?>"></td>  
                                
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOCARNEWREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"><?= $result_seTenkotransport2['TENKOCARNEWREMARK'] ?></td> -->
                            </tr> 
                             <tr>
                                <td style="text-align: center">4</td>
                                <td>ตรวจเทรลเลอร์</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs4d2 ?> onchange="edit_check4d2('TENKOTRAILERCHECK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" style="transform: scale(2)"  id="chk_4d2" name="chk_4d2"/></td>
                                <td>ระหว่างวิ่งงานไม่มีสิ่งผิดปกติ</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT3', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT3" name="TXT_TENKOLOADRESTRESULT3" value="<?= $result_seTenkotransport2['TENKOLOADRESTRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT3', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT3" name="TXT_TENKOBODYSLEEPYRESULT3" value="<?= $result_seTenkotransport2['TENKOBODYSLEEPYRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT3', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT3" name="TXT_TENKOCARNEWRESULT3" value="<?= $result_seTenkotransport2['TENKOCARNEWRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT3', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT3" name="TXT_TENKOTRAILERRESULT3" value="<?= $result_seTenkotransport2['TENKOTRAILERRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT3', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOROADRESULT3" name="TXT_TENKOROADRESULT3" value="<?= $result_seTenkotransport2['TENKOROADRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT3', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT3" name="TXT_TENKOAIRRESULT3" value="<?= $result_seTenkotransport2['TENKOAIRRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT3', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT3" name="TXT_TENKOSLEEPYRESULT3" value="<?= $result_seTenkotransport2['TENKOSLEEPYRESULT3'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOTRAILERREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"  class="form-control" value="<?= $result_seTenkotransport2['TENKOTRAILERREMARK'] ?>"></td>  
                                
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOTRAILERREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"><?= $result_seTenkotransport2['TENKOTRAILERREMARK'] ?></td> -->
                            </tr>
                            <tr>
                                <td style="text-align: center">5</td>
                                <td>ตรวจสภาพถนน</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs5d2 ?> onchange="edit_check5d2('TENKOROADCHECK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" style="transform: scale(2)"  id="chk_5d2" name="chk_5d2"/></td>
                                <td>รายงานสภาพถนน</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT4', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT4" name="TXT_TENKOLOADRESTRESULT4" value="<?= $result_seTenkotransport2['TENKOLOADRESTRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT4', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT4" name="TXT_TENKOBODYSLEEPYRESULT4" value="<?= $result_seTenkotransport2['TENKOBODYSLEEPYRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT4', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT4" name="TXT_TENKOCARNEWRESULT4" value="<?= $result_seTenkotransport2['TENKOCARNEWRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT4', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT4" name="TXT_TENKOTRAILERRESULT4" value="<?= $result_seTenkotransport2['TENKOTRAILERRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT4', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOROADRESULT4" name="TXT_TENKOROADRESULT4" value="<?= $result_seTenkotransport2['TENKOROADRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT4', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT4" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport2['TENKOAIRRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT4', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT4" name="TXT_TENKOSLEEPYRESULT4" value="<?= $result_seTenkotransport2['TENKOSLEEPYRESULT4'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOROADREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"  class="form-control" value="<?= $result_seTenkotransport2['TENKOROADREMARK'] ?>"></td>  
                                
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOROADREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"><?= $result_seTenkotransport2['TENKOROADREMARK'] ?></td> -->
                            </tr>
                            <tr>
                                <td style="text-align: center">6</td>
                                <td>ตรวจสภาพอากาศ (ใช้ที่ปัดน้ำฝนระดับ 3 ให้หยุดรถ)</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs6d2 ?> onchange="edit_check6d2('TENKOAIRCHECK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" style="transform: scale(2)"  id="chk_6d2" name="chk_6d2"/></td>
                                <td>รายงานสภาพอากาศ2</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT5', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT5" name="TXT_TENKOLOADRESTRESULT5" value="<?= $result_seTenkotransport2['TENKOLOADRESTRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT5', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT5" name="TXT_TENKOBODYSLEEPYRESULT5" value="<?= $result_seTenkotransport2['TENKOBODYSLEEPYRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT5', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT5" name="TXT_TENKOCARNEWRESULT5" value="<?= $result_seTenkotransport2['TENKOCARNEWRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT5', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT5" name="TXT_TENKOTRAILERRESULT5" value="<?= $result_seTenkotransport2['TENKOTRAILERRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT5', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOROADRESULT5" name="TXT_TENKOROADRESULT5" value="<?= $result_seTenkotransport2['TENKOROADRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT5', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT5" name="TXT_TENKOAIRRESULT5" value="<?= $result_seTenkotransport2['TENKOAIRRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT5', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT5" name="TXT_TENKOSLEEPYRESULT5" value="<?= $result_seTenkotransport2['TENKOSLEEPYRESULT5'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOAIRREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"  class="form-control" value="<?= $result_seTenkotransport2['TENKOAIRREMARK'] ?>"></td>  
                                
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOAIRREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"><?= $result_seTenkotransport2['TENKOAIRREMARK'] ?></td> -->
                            </tr>
                            <tr>
                                <td style="text-align: center">7</td>
                                <td>ตรวจสอบอาการง่วงและย้ำให้ระมัดระวัง</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs7d2 ?> onchange="edit_check7d2('TENKOSLEEPYCHECK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" style="transform: scale(2)" id="chk_7d2" name="chk_7d2" /></td>
                                <td>สภาพที่สามารถวิ่งงานต่อได้</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT6', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT6" name="TXT_TENKOLOADRESTRESULT6" value="<?= $result_seTenkotransport2['TENKOLOADRESTRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT6', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT6" name="TXT_TENKOBODYSLEEPYRESULT6" value="<?= $result_seTenkotransport2['TENKOBODYSLEEPYRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT6', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT6" name="TXT_TENKOCARNEWRESULT6" value="<?= $result_seTenkotransport2['TENKOCARNEWRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT6', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT6" name="TXT_TENKOTRAILERRESULT6" value="<?= $result_seTenkotransport2['TENKOTRAILERRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT6', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOROADRESULT6" name="TXT_TENKOROADRESULT6" value="<?= $result_seTenkotransport2['TENKOROADRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT6', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT6" name="TXT_TENKOAIRRESULT6" value="<?= $result_seTenkotransport2['TENKOAIRRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT6', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT6" name="TXT_TENKOSLEEPYRESULT6" value="<?= $result_seTenkotransport2['TENKOSLEEPYRESULT6'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOSLEEPYREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"  class="form-control" value="<?= $result_seTenkotransport2['TENKOSLEEPYREMARK'] ?>"></td>  
                                
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOSLEEPYREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"><?= $result_seTenkotransport2['TENKOSLEEPYREMARK'] ?></td> -->
                            </tr> 
                        </tbody>
                    </table>

                </div>
                <div class="tab-pane" id="day3">
                    <?php
                    $conditionTenkotransport31 = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_POST['employeecode1'] . "' ";
                    $conditionTenkotransport32 = " AND CONVERT(DATE,TENKOTRANSPORTDATE) = CONVERT(DATE,'" . $result_seTenkomaster['DATEINPUT_F3'] . "',103)";
                    $sql_seTenkotransport3 = "{call megEdittenkotransport_v2(?,?,?)}";
                    $params_seTenkotransport3 = array(
                        array('select_tenkotransport', SQLSRV_PARAM_IN),
                        array($conditionTenkotransport31, SQLSRV_PARAM_IN),
                        array($conditionTenkotransport32, SQLSRV_PARAM_IN)
                    );
                    $query_seTenkotransport3 = sqlsrv_query($conn, $sql_seTenkotransport3, $params_seTenkotransport3);
                    $result_seTenkotransport3 = sqlsrv_fetch_array($query_seTenkotransport3, SQLSRV_FETCH_ASSOC);

                    $rs1d3 = ($result_seTenkotransport3['TENKOLOADRESTCHECK'] == '1') ? "checked" : "";
                    $rs2d3 = ($result_seTenkotransport3['TENKOBODYSLEEPYCHECK'] == '1') ? "checked" : "";
                    $rs3d3 = ($result_seTenkotransport3['TENKOCARNEWCHECK'] == '1') ? "checked" : "";
                    $rs4d3 = ($result_seTenkotransport3['TENKOTRAILERCHECK'] == '1') ? "checked" : "";
                    $rs5d3 = ($result_seTenkotransport3['TENKOROADCHECK'] == '1') ? "checked" : "";
                    $rs6d3 = ($result_seTenkotransport3['TENKOAIRCHECK'] == '1') ? "checked" : "";
                    $rs7d3 = ($result_seTenkotransport3['TENKOSLEEPYCHECK'] == '1') ? "checked" : "";
                    ?>
                    <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                        <thead>
                            <tr>

                                
                                <!-- Commit_Emp1Day3 -->
                                <th colspan="6" ><input type="button" onclick="commit_2('<?= $result_seTenkomaster_temp['TENKOMASTERID'] ?>','<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>', '<?= $result_seEmployee['nameT'] ?>')"   class="btn btn-success" value="Commit1_Day3"> <font style="color: green">พนักงานขับรถ : <?= $sex?> <?= $result_sePlain['EMPLOYEENAME1'] ?></font></th>

                                <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะก่อนเริ่มงาน</th>
                                <th style="text-align: center;"><?= $result_seTenkotransport1["CREATEBY"] ?></th>
                                <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะปฎิบัติงาน</th>
                                <th style="text-align: center;"><?= $result_seEmployee["nameT"] ?></th>
                            </tr>
                            <tr>

                                <th colspan="12">เจ้าหน้าที่โทรไปไม่พบสิ่งผิดปกติ : <font style="color: red">0</font>  | พนักงานขับรถโทรมาไม่พบสิ่งผิดปกติ : <font style="color: red">1</font> | พบสิ่งผิดปกติ : <font style="color: red">x</font></th>
                            </tr>
                            <tr>

                                <th rowspan="4" style="text-align: center;">ข้อ</th>
                                <th rowspan="4" style="text-align: center;">หัวข้อ</th>
                                <th rowspan="4" style="text-align: center;">ช่องตรวจ</th>
                                <th rowspan="4" style="text-align: center;">เกณฑ์การตัดสิน</th>
                                <th rowspan="2" style="text-align: center;"><p>โทรช่วง </p>
                                    <p>00:01 - 23:59</p></th>
                                <th colspan="6" style="text-align: center">Night Call Check</th>
                                <th rowspan="4"style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">รายละเอียดการแนะนำของเจ้าหน้าที่</th>
                            </tr>
                            <tr>

                                <th style="text-align: center;">ครั้งที่ 1</th>
                                <th style="text-align: center;">ครั้งที่ 2</th>
                                <th style="text-align: center;">ครั้งที่ 3</th>
                                <th style="text-align: center;">ครั้งที่ 4</th>
                                <th style="text-align: center;">ครั้งที่ 5</th>
                                <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">ครั้งที่ 6</th>
                            </tr>
                            <tr>

                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME0', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control timeen" id="txt_time0" name="txt_time0" value="<?= $result_seTenkotransport3['TENKOTIME0'] ?>"></th>
                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME1', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control timeen" id="txt_time1" name="txt_time1" value="<?= $result_seTenkotransport3['TENKOTIME1'] ?>"></th>
                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME2', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control timeen" id="txt_time2" name="txt_time2" value="<?= $result_seTenkotransport3['TENKOTIME2'] ?>"></th>
                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME3', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control timeen" id="txt_time3" name="txt_time3" value="<?= $result_seTenkotransport3['TENKOTIME3'] ?>"></th>
                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME4', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control timeen" id="txt_time4" name="txt_time4" value="<?= $result_seTenkotransport3['TENKOTIME4'] ?>"></th>
                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME5', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control timeen" id="txt_time5" name="txt_time5" value="<?= $result_seTenkotransport3['TENKOTIME5'] ?>"></th>
                                <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME6', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control timeen" id="txt_time6" name="txt_time6" value="<?= $result_seTenkotransport3['TENKOTIME6'] ?>"></th>
                            </tr>
                            <tr>

                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">ผล</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center">1</td>
                                <td>เส้นทางที่กำหนด - จุดพัก</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs1d3 ?> onchange="edit_check1d3('TENKOLOADRESTCHECK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" style="transform: scale(2)" id="chk_1d3" name="chk_1d3" /></td>
                                <td>เส้นทาง จุดพักที่กำหนด</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT0', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT0" name="TXT_TENKOLOADRESTRESULT0" value="<?= $result_seTenkotransport3['TENKOLOADRESTRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT0', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT0" name="TXT_TENKOBODYSLEEPYRESULT0" value="<?= $result_seTenkotransport3['TENKOBODYSLEEPYRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT0', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT0" name="TXT_TENKOCARNEWRESULT0" value="<?= $result_seTenkotransport3['TENKOCARNEWRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT0', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT0" name="TXT_TENKOTRAILERRESULT0" value="<?= $result_seTenkotransport3['TENKOTRAILERRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT0', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOROADRESULT0" name="TXT_TENKOROADRESULT0" value="<?= $result_seTenkotransport3['TENKOROADRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT0', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT0" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport3['TENKOAIRRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT0', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT0" name="TXT_TENKOSLEEPYRESULT0" value="<?= $result_seTenkotransport3['TENKOSLEEPYRESULT0'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOLOADRESTREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"  class="form-control" value="<?= $result_seTenkotransport2['TENKOLOADRESTREMARK'] ?>"></td>
                                
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOLOADRESTREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"><?= $result_seTenkotransport3['TENKOLOADRESTREMARK'] ?></td> -->
                            </tr>
                            <tr>
                                <td style="text-align: center">2</td>
                                <td>ตรวจร่างกาย - อาการง่วง</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs2d3 ?> onchange="edit_check2d3('TENKOBODYSLEEPYCHECK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" style="transform: scale(2)"  id="chk_2d3" name="chk_2d3"/></td>
                                <td>วิธีการพูดคุยต้องร่าเริง</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT1', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT1" name="TXT_TENKOLOADRESTRESULT1" value="<?= $result_seTenkotransport3['TENKOLOADRESTRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT1', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT1" name="TXT_TENKOBODYSLEEPYRESULT1" value="<?= $result_seTenkotransport3['TENKOBODYSLEEPYRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT1', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT1" name="TXT_TENKOCARNEWRESULT1" value="<?= $result_seTenkotransport3['TENKOCARNEWRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT1', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT1" name="TXT_TENKOTRAILERRESULT1" value="<?= $result_seTenkotransport3['TENKOTRAILERRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT1', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOROADRESULT1" name="TXT_TENKOROADRESULT1" value="<?= $result_seTenkotransport3['TENKOROADRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT1', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT1" name="TXT_TENKOAIRRESULT1" value="<?= $result_seTenkotransport3['TENKOAIRRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT1', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT1" name="TXT_TENKOSLEEPYRESULT1" value="<?= $result_seTenkotransport3['TENKOSLEEPYRESULT1'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOBODYSLEEPYREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"  class="form-control" value="<?= $result_seTenkotransport3['TENKOBODYSLEEPYREMARK'] ?>"></td>
                                
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOBODYSLEEPYREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"><?= $result_seTenkotransport3['TENKOBODYSLEEPYREMARK'] ?></td> -->
                            </tr>
                            <tr>
                                <td style="text-align: center">3</td>
                                <td>ตรวจรถใหม่ (เฉพาะหยุดรถ)</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs3d3 ?> onchange="edit_check3d3('TENKOCARNEWCHECK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" style="transform: scale(2)"  id="chk_3d3" name="chk_3d3"/></td>
                                <td>มีการรายงานเกี่ยวกับรถใหม่ว่ามีสิ่งผิดปกติหรือไม่</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT2', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT2" name="TXT_TENKOLOADRESTRESULT2" value="<?= $result_seTenkotransport3['TENKOLOADRESTRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT2', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT2" name="TXT_TENKOBODYSLEEPYRESULT2" value="<?= $result_seTenkotransport3['TENKOBODYSLEEPYRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT2', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT2" name="TXT_TENKOCARNEWRESULT2" value="<?= $result_seTenkotransport3['TENKOCARNEWRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT2', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT2" name="TXT_TENKOTRAILERRESULT2" value="<?= $result_seTenkotransport3['TENKOTRAILERRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT2', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOROADRESULT2" name="TXT_TENKOROADRESULT2" value="<?= $result_seTenkotransport3['TENKOROADRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT2', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT2" name="TXT_TENKOAIRRESULT2" value="<?= $result_seTenkotransport3['TENKOAIRRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT2', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT2" name="TXT_TENKOSLEEPYRESULT2" value="<?= $result_seTenkotransport3['TENKOSLEEPYRESULT2'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOCARNEWREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"  class="form-control" value="<?= $result_seTenkotransport3['TENKOCARNEWREMARK'] ?>"></td>
                                
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOCARNEWREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"><?= $result_seTenkotransport3['TENKOCARNEWREMARK'] ?></td> -->
                            </tr>
                            <tr>
                                <td style="text-align: center">4</td>
                                <td>ตรวจเทรลเลอร์</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs4d3 ?> onchange="edit_check4d3('TENKOTRAILERCHECK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" style="transform: scale(2)"  id="chk_4d3" name="chk_4d3"/></td>
                                <td>ระหว่างวิ่งงานไม่มีสิ่งผิดปกติ</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT3', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT3" name="TXT_TENKOLOADRESTRESULT3" value="<?= $result_seTenkotransport3['TENKOLOADRESTRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT3', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT3" name="TXT_TENKOBODYSLEEPYRESULT3" value="<?= $result_seTenkotransport3['TENKOBODYSLEEPYRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT3', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT3" name="TXT_TENKOCARNEWRESULT3" value="<?= $result_seTenkotransport3['TENKOCARNEWRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT3', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT3" name="TXT_TENKOTRAILERRESULT3" value="<?= $result_seTenkotransport3['TENKOTRAILERRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT3', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOROADRESULT3" name="TXT_TENKOROADRESULT3" value="<?= $result_seTenkotransport3['TENKOROADRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT3', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT3" name="TXT_TENKOAIRRESULT3" value="<?= $result_seTenkotransport3['TENKOAIRRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT3', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT3" name="TXT_TENKOSLEEPYRESULT3" value="<?= $result_seTenkotransport3['TENKOSLEEPYRESULT3'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOTRAILERREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"  class="form-control" value="<?= $result_seTenkotransport3['TENKOTRAILERREMARK'] ?>"></td>
                                
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOTRAILERREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"><?= $result_seTenkotransport3['TENKOTRAILERREMARK'] ?></td> -->
                            </tr>
                            <tr>
                                <td style="text-align: center">5</td>
                                <td>ตรวจสภาพถนน</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs5d3 ?> onchange="edit_check5d3('TENKOROADCHECK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" style="transform: scale(2)"  id="chk_5d3" name="chk_5d3"/></td>
                                <td>รายงานสภาพถนน</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT4', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT4" name="TXT_TENKOLOADRESTRESULT4" value="<?= $result_seTenkotransport3['TENKOLOADRESTRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT4', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT4" name="TXT_TENKOBODYSLEEPYRESULT4" value="<?= $result_seTenkotransport3['TENKOBODYSLEEPYRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT4', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT4" name="TXT_TENKOCARNEWRESULT4" value="<?= $result_seTenkotransport3['TENKOCARNEWRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT4', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT4" name="TXT_TENKOTRAILERRESULT4" value="<?= $result_seTenkotransport3['TENKOTRAILERRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT4', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOROADRESULT4" name="TXT_TENKOROADRESULT4" value="<?= $result_seTenkotransport3['TENKOROADRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT4', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT4" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport3['TENKOAIRRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT4', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT4" name="TXT_TENKOSLEEPYRESULT4" value="<?= $result_seTenkotransport3['TENKOSLEEPYRESULT4'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOROADREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"  class="form-control" value="<?= $result_seTenkotransport3['TENKOROADREMARK'] ?>"></td>
                                
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOROADREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"><?= $result_seTenkotransport3['TENKOROADREMARK'] ?></td> -->
                            </tr>
                            <tr>
                                <td style="text-align: center">6</td>
                                <td>ตรวจสภาพอากาศ (ใช้ที่ปัดน้ำฝนระดับ 3 ให้หยุดรถ)</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs6d3 ?> onchange="edit_check6d3('TENKOAIRCHECK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" style="transform: scale(2)"  id="chk_6d3" name="chk_6d3"/></td>
                                <td>รายงานสภาพอากาศ3</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT5', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT5" name="TXT_TENKOLOADRESTRESULT5" value="<?= $result_seTenkotransport3['TENKOLOADRESTRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT5', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT5" name="TXT_TENKOBODYSLEEPYRESULT5" value="<?= $result_seTenkotransport3['TENKOBODYSLEEPYRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT5', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT5" name="TXT_TENKOCARNEWRESULT5" value="<?= $result_seTenkotransport3['TENKOCARNEWRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT5', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT5" name="TXT_TENKOTRAILERRESULT5" value="<?= $result_seTenkotransport3['TENKOTRAILERRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT5', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOROADRESULT5" name="TXT_TENKOROADRESULT5" value="<?= $result_seTenkotransport3['TENKOROADRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT5', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT5" name="TXT_TENKOAIRRESULT5" value="<?= $result_seTenkotransport3['TENKOAIRRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT5', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT5" name="TXT_TENKOSLEEPYRESULT5" value="<?= $result_seTenkotransport3['TENKOSLEEPYRESULT5'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOAIRREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"  class="form-control" value="<?= $result_seTenkotransport3['TENKOAIRREMARK'] ?>"></td>
                                
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOAIRREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"><?= $result_seTenkotransport3['TENKOAIRREMARK'] ?></td> -->
                            </tr>
                            <tr>
                                <td style="text-align: center">7</td>
                                <td>ตรวจสอบอาการง่วงและย้ำให้ระมัดระวัง</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs7d3 ?> onchange="edit_check7d3('TENKOSLEEPYCHECK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" style="transform: scale(2)" id="chk_7d3" name="chk_7d3" /></td>
                                <td>สภาพที่สามารถวิ่งงานต่อได้</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT6', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT6" name="TXT_TENKOLOADRESTRESULT6" value="<?= $result_seTenkotransport3['TENKOLOADRESTRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT6', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT6" name="TXT_TENKOBODYSLEEPYRESULT6" value="<?= $result_seTenkotransport3['TENKOBODYSLEEPYRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT6', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT6" name="TXT_TENKOCARNEWRESULT6" value="<?= $result_seTenkotransport3['TENKOCARNEWRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT6', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT6" name="TXT_TENKOTRAILERRESULT6" value="<?= $result_seTenkotransport3['TENKOTRAILERRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT6', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOROADRESULT6" name="TXT_TENKOROADRESULT6" value="<?= $result_seTenkotransport3['TENKOROADRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT6', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT6" name="TXT_TENKOAIRRESULT6" value="<?= $result_seTenkotransport3['TENKOAIRRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT6', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT6" name="TXT_TENKOSLEEPYRESULT6" value="<?= $result_seTenkotransport3['TENKOSLEEPYRESULT6'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOSLEEPYREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"  class="form-control" value="<?= $result_seTenkotransport3['TENKOSLEEPYREMARK'] ?>"></td>
                                
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOSLEEPYREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"><?= $result_seTenkotransport3['TENKOSLEEPYREMARK'] ?></td> -->
                            </tr>
                        </tbody>
                    </table>

                </div>
                <div class="tab-pane" id="day4">
                    <?php
                    $conditionTenkotransport41 = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_POST['employeecode1'] . "' ";
                    $conditionTenkotransport42 = " AND CONVERT(DATE,TENKOTRANSPORTDATE) = CONVERT(DATE,'" . $result_seTenkomaster['DATEINPUT_F4'] . "',103)";
                    $sql_seTenkotransport4 = "{call megEdittenkotransport_v2(?,?,?)}";
                    $params_seTenkotransport4 = array(
                        array('select_tenkotransport', SQLSRV_PARAM_IN),
                        array($conditionTenkotransport41, SQLSRV_PARAM_IN),
                        array($conditionTenkotransport42, SQLSRV_PARAM_IN)
                    );
                    $query_seTenkotransport4 = sqlsrv_query($conn, $sql_seTenkotransport4, $params_seTenkotransport4);
                    $result_seTenkotransport4 = sqlsrv_fetch_array($query_seTenkotransport4, SQLSRV_FETCH_ASSOC);

                    $rs1d4 = ($result_seTenkotransport4['TENKOLOADRESTCHECK'] == '1') ? "checked" : "";
                    $rs2d4 = ($result_seTenkotransport4['TENKOBODYSLEEPYCHECK'] == '1') ? "checked" : "";
                    $rs3d4 = ($result_seTenkotransport4['TENKOCARNEWCHECK'] == '1') ? "checked" : "";
                    $rs4d4 = ($result_seTenkotransport4['TENKOTRAILERCHECK'] == '1') ? "checked" : "";
                    $rs5d4 = ($result_seTenkotransport4['TENKOROADCHECK'] == '1') ? "checked" : "";
                    $rs6d4 = ($result_seTenkotransport4['TENKOAIRCHECK'] == '1') ? "checked" : "";
                    $rs7d4 = ($result_seTenkotransport4['TENKOSLEEPYCHECK'] == '1') ? "checked" : "";
                    ?>
                    <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                        <thead>
                            <tr>

                               
                                <!-- Commit_Emp1Day4 -->
                                <th colspan="6" ><input type="button" onclick="commit_2('<?= $result_seTenkomaster_temp['TENKOMASTERID'] ?>','<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>', '<?= $result_seEmployee['nameT'] ?>')"   class="btn btn-success" value="Commit1_Day4"> <font style="color: green">พนักงานขับรถ : <?= $sex?> <?= $result_sePlain['EMPLOYEENAME1'] ?></font></th>

                                <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะก่อนเริ่มงาน</th>
                                <th style="text-align: center;"><?= $result_seTenkotransport1["CREATEBY"] ?></th>
                                <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะปฎิบัติงาน</th>
                                <th style="text-align: center;"><?= $result_seEmployee["nameT"] ?></th>
                            </tr>
                            <tr>

                                <th colspan="12">เจ้าหน้าที่โทรไปไม่พบสิ่งผิดปกติ : <font style="color: red">0</font>  | พนักงานขับรถโทรมาไม่พบสิ่งผิดปกติ : <font style="color: red">1</font> | พบสิ่งผิดปกติ : <font style="color: red">x</font></th>
                            </tr>
                            <tr>

                                <th rowspan="4" style="text-align: center;">ข้อ</th>
                                <th rowspan="4" style="text-align: center;">หัวข้อ</th>
                                <th rowspan="4" style="text-align: center;">ช่องตรวจ</th>
                                <th rowspan="4" style="text-align: center;">เกณฑ์การตัดสิน</th>
                                <th rowspan="2" style="text-align: center;"><p>โทรช่วง </p>
                                    <p>00:01 - 23:59</p></th>
                                <th colspan="6" style="text-align: center">Night Call Check</th>
                                <th rowspan="4"style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">รายละเอียดการแนะนำของเจ้าหน้าที่</th>
                            </tr>
                            <tr>

                                <th style="text-align: center;">ครั้งที่ 1</th>
                                <th style="text-align: center;">ครั้งที่ 2</th>
                                <th style="text-align: center;">ครั้งที่ 3</th>
                                <th style="text-align: center;">ครั้งที่ 4</th>
                                <th style="text-align: center;">ครั้งที่ 5</th>
                                <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">ครั้งที่ 6</th>
                            </tr>
                            <tr>

                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME0', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control timeen" id="txt_time0" name="txt_time0" value="<?= $result_seTenkotransport4['TENKOTIME0'] ?>"></th>
                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME1', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control timeen" id="txt_time1" name="txt_time1" value="<?= $result_seTenkotransport4['TENKOTIME1'] ?>"></th>
                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME2', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control timeen" id="txt_time2" name="txt_time2" value="<?= $result_seTenkotransport4['TENKOTIME2'] ?>"></th>
                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME3', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control timeen" id="txt_time3" name="txt_time3" value="<?= $result_seTenkotransport4['TENKOTIME3'] ?>"></th>
                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME4', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control timeen" id="txt_time4" name="txt_time4" value="<?= $result_seTenkotransport4['TENKOTIME4'] ?>"></th>
                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME5', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control timeen" id="txt_time5" name="txt_time5" value="<?= $result_seTenkotransport4['TENKOTIME5'] ?>"></th>
                                <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME6', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control timeen" id="txt_time6" name="txt_time6" value="<?= $result_seTenkotransport4['TENKOTIME6'] ?>"></th>
                            </tr>
                            <tr>

                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">ผล</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center">1</td>
                                <td>เส้นทางที่กำหนด - จุดพัก</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs1d4 ?> onchange="edit_check1d4('TENKOLOADRESTCHECK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" style="transform: scale(2)" id="chk_1d4" name="chk_1d4" /></td>
                                <td>เส้นทาง จุดพักที่กำหนด</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT0', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT0" name="TXT_TENKOLOADRESTRESULT0" value="<?= $result_seTenkotransport4['TENKOLOADRESTRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT0', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT0" name="TXT_TENKOBODYSLEEPYRESULT0" value="<?= $result_seTenkotransport4['TENKOBODYSLEEPYRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT0', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT0" name="TXT_TENKOCARNEWRESULT0" value="<?= $result_seTenkotransport4['TENKOCARNEWRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT0', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT0" name="TXT_TENKOTRAILERRESULT0" value="<?= $result_seTenkotransport4['TENKOTRAILERRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT0', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOROADRESULT0" name="TXT_TENKOROADRESULT0" value="<?= $result_seTenkotransport4['TENKOROADRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT0', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT0" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport4['TENKOAIRRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT0', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT0" name="TXT_TENKOSLEEPYRESULT0" value="<?= $result_seTenkotransport4['TENKOSLEEPYRESULT0'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOLOADRESTREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"  class="form-control" value="<?= $result_seTenkotransport4['TENKOLOADRESTREMARK'] ?>"></td>
                                
                                
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOLOADRESTREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"><?= $result_seTenkotransport4['TENKOLOADRESTREMARK'] ?></td> -->
                            </tr>
                            <tr>
                                <td style="text-align: center">2</td>
                                <td>ตรวจร่างกาย - อาการง่วง</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs2d4 ?> onchange="edit_check2d4('TENKOBODYSLEEPYCHECK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" style="transform: scale(2)"  id="chk_2d4" name="chk_2d4"/></td>
                                <td>วิธีการพูดคุยต้องร่าเริง</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT1', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT1" name="TXT_TENKOLOADRESTRESULT1" value="<?= $result_seTenkotransport4['TENKOLOADRESTRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT1', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT1" name="TXT_TENKOBODYSLEEPYRESULT1" value="<?= $result_seTenkotransport4['TENKOBODYSLEEPYRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT1', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT1" name="TXT_TENKOCARNEWRESULT1" value="<?= $result_seTenkotransport4['TENKOCARNEWRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT1', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT1" name="TXT_TENKOTRAILERRESULT1" value="<?= $result_seTenkotransport4['TENKOTRAILERRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT1', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOROADRESULT1" name="TXT_TENKOROADRESULT1" value="<?= $result_seTenkotransport4['TENKOROADRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT1', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT1" name="TXT_TENKOAIRRESULT1" value="<?= $result_seTenkotransport4['TENKOAIRRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT1', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT1" name="TXT_TENKOSLEEPYRESULT1" value="<?= $result_seTenkotransport4['TENKOSLEEPYRESULT1'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOBODYSLEEPYREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"  class="form-control" value="<?= $result_seTenkotransport4['TENKOBODYSLEEPYREMARK'] ?>"></td>
                                
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOBODYSLEEPYREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"><?= $result_seTenkotransport4['TENKOBODYSLEEPYREMARK'] ?></td> -->
                            </tr>
                            <tr>
                                <td style="text-align: center">3</td>
                                <td>ตรวจรถใหม่ (เฉพาะหยุดรถ)</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs3d4 ?> onchange="edit_check3d4('TENKOCARNEWCHECK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" style="transform: scale(2)"  id="chk_3d4" name="chk_3d4"/></td>
                                <td>มีการรายงานเกี่ยวกับรถใหม่ว่ามีสิ่งผิดปกติหรือไม่</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT2', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT2" name="TXT_TENKOLOADRESTRESULT2" value="<?= $result_seTenkotransport4['TENKOLOADRESTRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT2', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT2" name="TXT_TENKOBODYSLEEPYRESULT2" value="<?= $result_seTenkotransport4['TENKOBODYSLEEPYRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT2', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT2" name="TXT_TENKOCARNEWRESULT2" value="<?= $result_seTenkotransport4['TENKOCARNEWRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT2', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT2" name="TXT_TENKOTRAILERRESULT2" value="<?= $result_seTenkotransport4['TENKOTRAILERRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT2', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOROADRESULT2" name="TXT_TENKOROADRESULT2" value="<?= $result_seTenkotransport4['TENKOROADRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT2', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT2" name="TXT_TENKOAIRRESULT2" value="<?= $result_seTenkotransport4['TENKOAIRRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT2', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT2" name="TXT_TENKOSLEEPYRESULT2" value="<?= $result_seTenkotransport4['TENKOSLEEPYRESULT2'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOCARNEWREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"  class="form-control" value="<?= $result_seTenkotransport4['TENKOCARNEWREMARK'] ?>"></td>
                                
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOCARNEWREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"><?= $result_seTenkotransport4['TENKOCARNEWREMARK'] ?></td> -->
                            </tr>
                            <tr>
                                <td style="text-align: center">4</td>
                                <td>ตรวจเทรลเลอร์</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs4d4 ?> onchange="edit_check4d4('TENKOTRAILERCHECK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" style="transform: scale(2)"  id="chk_4d4" name="chk_4d4"/></td>
                                <td>ระหว่างวิ่งงานไม่มีสิ่งผิดปกติ</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT3', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT3" name="TXT_TENKOLOADRESTRESULT3" value="<?= $result_seTenkotransport4['TENKOLOADRESTRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT3', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT3" name="TXT_TENKOBODYSLEEPYRESULT3" value="<?= $result_seTenkotransport4['TENKOBODYSLEEPYRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT3', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT3" name="TXT_TENKOCARNEWRESULT3" value="<?= $result_seTenkotransport4['TENKOCARNEWRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT3', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT3" name="TXT_TENKOTRAILERRESULT3" value="<?= $result_seTenkotransport4['TENKOTRAILERRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT3', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOROADRESULT3" name="TXT_TENKOROADRESULT3" value="<?= $result_seTenkotransport4['TENKOROADRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT3', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT3" name="TXT_TENKOAIRRESULT3" value="<?= $result_seTenkotransport4['TENKOAIRRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT3', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT3" name="TXT_TENKOSLEEPYRESULT3" value="<?= $result_seTenkotransport4['TENKOSLEEPYRESULT3'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOTRAILERREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"  class="form-control" value="<?= $result_seTenkotransport4['TENKOTRAILERREMARK'] ?>"></td>
                                
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOTRAILERREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"><?= $result_seTenkotransport4['TENKOTRAILERREMARK'] ?></td> -->
                            </tr>
                            <tr>
                                <td style="text-align: center">5</td>
                                <td>ตรวจสภาพถนน</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs5d4 ?> onchange="edit_check5d4('TENKOROADCHECK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" style="transform: scale(2)"  id="chk_5d4" name="chk_5d4"/></td>
                                <td>รายงานสภาพถนน</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT4', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT4" name="TXT_TENKOLOADRESTRESULT4" value="<?= $result_seTenkotransport4['TENKOLOADRESTRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT4', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT4" name="TXT_TENKOBODYSLEEPYRESULT4" value="<?= $result_seTenkotransport4['TENKOBODYSLEEPYRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT4', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT4" name="TXT_TENKOCARNEWRESULT4" value="<?= $result_seTenkotransport4['TENKOCARNEWRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT4', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT4" name="TXT_TENKOTRAILERRESULT4" value="<?= $result_seTenkotransport4['TENKOTRAILERRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT4', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOROADRESULT4" name="TXT_TENKOROADRESULT4" value="<?= $result_seTenkotransport4['TENKOROADRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT4', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT4" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport4['TENKOAIRRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT4', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT4" name="TXT_TENKOSLEEPYRESULT4" value="<?= $result_seTenkotransport4['TENKOSLEEPYRESULT4'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOROADREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"  class="form-control" value="<?= $result_seTenkotransport4['TENKOTRAILERREMARK'] ?>"></td>
                                
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOROADREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"><?= $result_seTenkotransport4['TENKOROADREMARK'] ?></td> -->
                            </tr>
                            <tr>
                                <td style="text-align: center">6</td>
                                <td>ตรวจสภาพอากาศ (ใช้ที่ปัดน้ำฝนระดับ 3 ให้หยุดรถ)</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs6d4 ?> onchange="edit_check6d4('TENKOAIRCHECK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" style="transform: scale(2)"  id="chk_6d4" name="chk_6d4"/></td>
                                <td>รายงานสภาพอากาศ4</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT5', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT5" name="TXT_TENKOLOADRESTRESULT5" value="<?= $result_seTenkotransport4['TENKOLOADRESTRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT5', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT5" name="TXT_TENKOBODYSLEEPYRESULT5" value="<?= $result_seTenkotransport4['TENKOBODYSLEEPYRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT5', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT5" name="TXT_TENKOCARNEWRESULT5" value="<?= $result_seTenkotransport4['TENKOCARNEWRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT5', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT5" name="TXT_TENKOTRAILERRESULT5" value="<?= $result_seTenkotransport4['TENKOTRAILERRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT5', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOROADRESULT5" name="TXT_TENKOROADRESULT5" value="<?= $result_seTenkotransport4['TENKOROADRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT5', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT5" name="TXT_TENKOAIRRESULT5" value="<?= $result_seTenkotransport4['TENKOAIRRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT5', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT5" name="TXT_TENKOSLEEPYRESULT5" value="<?= $result_seTenkotransport4['TENKOSLEEPYRESULT5'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOAIRREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"  class="form-control" value="<?= $result_seTenkotransport4['TENKOTRAILERREMARK'] ?>"></td>
                                
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOAIRREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"><?= $result_seTenkotransport4['TENKOAIRREMARK'] ?></td> -->
                            </tr>
                            <tr>
                                <td style="text-align: center">7</td>
                                <td>ตรวจสอบอาการง่วงและย้ำให้ระมัดระวัง</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs7d4 ?> onchange="edit_check7d4('TENKOSLEEPYCHECK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" style="transform: scale(2)" id="chk_7d4" name="chk_7d4" /></td>
                                <td>สภาพที่สามารถวิ่งงานต่อได้</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT6', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT6" name="TXT_TENKOLOADRESTRESULT6" value="<?= $result_seTenkotransport4['TENKOLOADRESTRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT6', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT6" name="TXT_TENKOBODYSLEEPYRESULT6" value="<?= $result_seTenkotransport4['TENKOBODYSLEEPYRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT6', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT6" name="TXT_TENKOCARNEWRESULT6" value="<?= $result_seTenkotransport4['TENKOCARNEWRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT6', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT6" name="TXT_TENKOTRAILERRESULT6" value="<?= $result_seTenkotransport4['TENKOTRAILERRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT6', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOROADRESULT6" name="TXT_TENKOROADRESULT6" value="<?= $result_seTenkotransport4['TENKOROADRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT6', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT6" name="TXT_TENKOAIRRESULT6" value="<?= $result_seTenkotransport4['TENKOAIRRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT6', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT6" name="TXT_TENKOSLEEPYRESULT6" value="<?= $result_seTenkotransport4['TENKOSLEEPYRESULT6'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOSLEEPYREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"  class="form-control" value="<?= $result_seTenkotransport4['TENKOTRAILERREMARK'] ?>"></td>
                                
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOSLEEPYREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"><?= $result_seTenkotransport4['TENKOSLEEPYREMARK'] ?></td> -->
                            </tr>
                        </tbody>
                    </table>

                </div>
                <div class="tab-pane" id="day5">
                    <?php
                    $conditionTenkotransport51 = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_POST['employeecode1'] . "' ";
                    $conditionTenkotransport52 = " AND CONVERT(DATE,TENKOTRANSPORTDATE) = CONVERT(DATE,'" . $result_seTenkomaster['DATEINPUT_F5'] . "',103)";
                    $sql_seTenkotransport5 = "{call megEdittenkotransport_v2(?,?,?)}";
                    $params_seTenkotransport5 = array(
                        array('select_tenkotransport', SQLSRV_PARAM_IN),
                        array($conditionTenkotransport51, SQLSRV_PARAM_IN),
                        array($conditionTenkotransport52, SQLSRV_PARAM_IN)
                    );
                    $query_seTenkotransport5 = sqlsrv_query($conn, $sql_seTenkotransport5, $params_seTenkotransport5);
                    $result_seTenkotransport5 = sqlsrv_fetch_array($query_seTenkotransport5, SQLSRV_FETCH_ASSOC);

                    $rs1d5 = ($result_seTenkotransport5['TENKOLOADRESTCHECK'] == '1') ? "checked" : "";
                    $rs2d5 = ($result_seTenkotransport5['TENKOBODYSLEEPYCHECK'] == '1') ? "checked" : "";
                    $rs3d5 = ($result_seTenkotransport5['TENKOCARNEWCHECK'] == '1') ? "checked" : "";
                    $rs4d5 = ($result_seTenkotransport5['TENKOTRAILERCHECK'] == '1') ? "checked" : "";
                    $rs5d5 = ($result_seTenkotransport5['TENKOROADCHECK'] == '1') ? "checked" : "";
                    $rs6d5 = ($result_seTenkotransport5['TENKOAIRCHECK'] == '1') ? "checked" : "";
                    $rs7d5 = ($result_seTenkotransport5['TENKOSLEEPYCHECK'] == '1') ? "checked" : "";
                    ?>
                    <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                        <thead>
                            <tr>

                   
                                <!-- Commit_Emp1Day5 -->
                                <th colspan="6" ><input type="button" onclick="commit_2('<?= $result_seTenkomaster_temp['TENKOMASTERID'] ?>','<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>', '<?= $result_seEmployee['nameT'] ?>')"   class="btn btn-success" value="Commit1_Day5"> <font style="color: green">พนักงานขับรถ : <?= $sex?> <?= $result_sePlain['EMPLOYEENAME1'] ?></font></th>

                                <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะก่อนเริ่มงาน</th>
                                <th style="text-align: center;"><?= $result_seTenkotransport1["CREATEBY"] ?></th>
                                <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะปฎิบัติงาน</th>
                                <th style="text-align: center;"><?= $result_seEmployee["nameT"] ?></th>
                            </tr>
                            <tr>

                                <th colspan="12">เจ้าหน้าที่โทรไปไม่พบสิ่งผิดปกติ : <font style="color: red">0</font>  | พนักงานขับรถโทรมาไม่พบสิ่งผิดปกติ : <font style="color: red">1</font> | พบสิ่งผิดปกติ : <font style="color: red">x</font></th>
                            </tr>
                            <tr>

                                <th rowspan="4" style="text-align: center;">ข้อ</th>
                                <th rowspan="4" style="text-align: center;">หัวข้อ</th>
                                <th rowspan="4" style="text-align: center;">ช่องตรวจ</th>
                                <th rowspan="4" style="text-align: center;">เกณฑ์การตัดสิน</th>
                                <th rowspan="2" style="text-align: center;"><p>โทรช่วง </p>
                                    <p>00:01 - 23:59</p></th>
                                <th colspan="6" style="text-align: center">Night Call Check</th>
                                <th rowspan="4"style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">รายละเอียดการแนะนำของเจ้าหน้าที่</th>
                            </tr>
                            <tr>

                                <th style="text-align: center;">ครั้งที่ 1</th>
                                <th style="text-align: center;">ครั้งที่ 2</th>
                                <th style="text-align: center;">ครั้งที่ 3</th>
                                <th style="text-align: center;">ครั้งที่ 4</th>
                                <th style="text-align: center;">ครั้งที่ 5</th>
                                <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">ครั้งที่ 6</th>
                            </tr>
                            <tr>

                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME0', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control timeen" id="txt_time0" name="txt_time0" value="<?= $result_seTenkotransport5['TENKOTIME0'] ?>"></th>
                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME1', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control timeen" id="txt_time1" name="txt_time1" value="<?= $result_seTenkotransport5['TENKOTIME1'] ?>"></th>
                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME2', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control timeen" id="txt_time2" name="txt_time2" value="<?= $result_seTenkotransport5['TENKOTIME2'] ?>"></th>
                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME3', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control timeen" id="txt_time3" name="txt_time3" value="<?= $result_seTenkotransport5['TENKOTIME3'] ?>"></th>
                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME4', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control timeen" id="txt_time4" name="txt_time4" value="<?= $result_seTenkotransport5['TENKOTIME4'] ?>"></th>
                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME5', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control timeen" id="txt_time5" name="txt_time5" value="<?= $result_seTenkotransport5['TENKOTIME5'] ?>"></th>
                                <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME6', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control timeen" id="txt_time6" name="txt_time6" value="<?= $result_seTenkotransport5['TENKOTIME6'] ?>"></th>
                            </tr>
                            <tr>

                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">ผล</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center">1</td>
                                <td>เส้นทางที่กำหนด - จุดพัก</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs1d5 ?> onchange="edit_check1d5('TENKOLOADRESTCHECK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" style="transform: scale(2)" id="chk_1d5" name="chk_1d5" /></td>
                                <td>เส้นทาง จุดพักที่กำหนด</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT0', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT0" name="TXT_TENKOLOADRESTRESULT0" value="<?= $result_seTenkotransport5['TENKOLOADRESTRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT0', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT0" name="TXT_TENKOBODYSLEEPYRESULT0" value="<?= $result_seTenkotransport5['TENKOBODYSLEEPYRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT0', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT0" name="TXT_TENKOCARNEWRESULT0" value="<?= $result_seTenkotransport5['TENKOCARNEWRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT0', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT0" name="TXT_TENKOTRAILERRESULT0" value="<?= $result_seTenkotransport5['TENKOTRAILERRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT0', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOROADRESULT0" name="TXT_TENKOROADRESULT0" value="<?= $result_seTenkotransport5['TENKOROADRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT0', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT0" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport5['TENKOAIRRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT0', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT0" name="TXT_TENKOSLEEPYRESULT0" value="<?= $result_seTenkotransport5['TENKOSLEEPYRESULT0'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOLOADRESTREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"  class="form-control" value="<?= $result_seTenkotransport5['TENKOLOADRESTREMARK'] ?>"></td>
                                
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOLOADRESTREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"><?= $result_seTenkotransport5['TENKOLOADRESTREMARK'] ?></td> -->
                            </tr>
                            <tr>
                                <td style="text-align: center">2</td>
                                <td>ตรวจร่างกาย - อาการง่วง</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs2d5 ?> onchange="edit_check2d5('TENKOBODYSLEEPYCHECK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" style="transform: scale(2)"  id="chk_2d5" name="chk_2d5"/></td>
                                <td>วิธีการพูดคุยต้องร่าเริง</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT1', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT1" name="TXT_TENKOLOADRESTRESULT1" value="<?= $result_seTenkotransport5['TENKOLOADRESTRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT1', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT1" name="TXT_TENKOBODYSLEEPYRESULT1" value="<?= $result_seTenkotransport5['TENKOBODYSLEEPYRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT1', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT1" name="TXT_TENKOCARNEWRESULT1" value="<?= $result_seTenkotransport5['TENKOCARNEWRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT1', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT1" name="TXT_TENKOTRAILERRESULT1" value="<?= $result_seTenkotransport5['TENKOTRAILERRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT1', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOROADRESULT1" name="TXT_TENKOROADRESULT1" value="<?= $result_seTenkotransport5['TENKOROADRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT1', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT1" name="TXT_TENKOAIRRESULT1" value="<?= $result_seTenkotransport5['TENKOAIRRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT1', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT1" name="TXT_TENKOSLEEPYRESULT1" value="<?= $result_seTenkotransport5['TENKOSLEEPYRESULT1'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOBODYSLEEPYREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"  class="form-control" value="<?= $result_seTenkotransport5['TENKOBODYSLEEPYREMARK'] ?>"></td>
                                
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOBODYSLEEPYREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"><?= $result_seTenkotransport5['TENKOBODYSLEEPYREMARK'] ?></td> -->
                            </tr>
                            <tr>
                                <td style="text-align: center">3</td>
                                <td>ตรวจรถใหม่ (เฉพาะหยุดรถ)</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs3d5 ?> onchange="edit_check3d5('TENKOCARNEWCHECK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" style="transform: scale(2)"  id="chk_3d5" name="chk_3d5"/></td>
                                <td>มีการรายงานเกี่ยวกับรถใหม่ว่ามีสิ่งผิดปกติหรือไม่</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT2', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT2" name="TXT_TENKOLOADRESTRESULT2" value="<?= $result_seTenkotransport5['TENKOLOADRESTRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT2', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT2" name="TXT_TENKOBODYSLEEPYRESULT2" value="<?= $result_seTenkotransport5['TENKOBODYSLEEPYRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT2', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT2" name="TXT_TENKOCARNEWRESULT2" value="<?= $result_seTenkotransport5['TENKOCARNEWRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT2', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT2" name="TXT_TENKOTRAILERRESULT2" value="<?= $result_seTenkotransport5['TENKOTRAILERRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT2', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOROADRESULT2" name="TXT_TENKOROADRESULT2" value="<?= $result_seTenkotransport5['TENKOROADRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT2', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT2" name="TXT_TENKOAIRRESULT2" value="<?= $result_seTenkotransport5['TENKOAIRRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT2', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT2" name="TXT_TENKOSLEEPYRESULT2" value="<?= $result_seTenkotransport5['TENKOSLEEPYRESULT2'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOCARNEWREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"  class="form-control" value="<?= $result_seTenkotransport5['TENKOCARNEWREMARK'] ?>"></td>
                                
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOCARNEWREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"><?= $result_seTenkotransport5['TENKOCARNEWREMARK'] ?></td> -->
                            </tr>
                            <tr>
                                <td style="text-align: center">4</td>
                                <td>ตรวจเทรลเลอร์</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs4d5 ?> onchange="edit_check4d5('TENKOTRAILERCHECK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" style="transform: scale(2)"  id="chk_4d5" name="chk_4d5"/></td>
                                <td>ระหว่างวิ่งงานไม่มีสิ่งผิดปกติ</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT3', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT3" name="TXT_TENKOLOADRESTRESULT3" value="<?= $result_seTenkotransport5['TENKOLOADRESTRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT3', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT3" name="TXT_TENKOBODYSLEEPYRESULT3" value="<?= $result_seTenkotransport5['TENKOBODYSLEEPYRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT3', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT3" name="TXT_TENKOCARNEWRESULT3" value="<?= $result_seTenkotransport5['TENKOCARNEWRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT3', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT3" name="TXT_TENKOTRAILERRESULT3" value="<?= $result_seTenkotransport5['TENKOTRAILERRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT3', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOROADRESULT3" name="TXT_TENKOROADRESULT3" value="<?= $result_seTenkotransport5['TENKOROADRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT3', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT3" name="TXT_TENKOAIRRESULT3" value="<?= $result_seTenkotransport5['TENKOAIRRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT3', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT3" name="TXT_TENKOSLEEPYRESULT3" value="<?= $result_seTenkotransport5['TENKOSLEEPYRESULT3'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOTRAILERREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"  class="form-control" value="<?= $result_seTenkotransport5['TENKOTRAILERREMARK'] ?>"></td>
                                
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOTRAILERREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"><?= $result_seTenkotransport5['TENKOTRAILERREMARK'] ?></td> -->
                            </tr>
                            <tr>
                                <td style="text-align: center">5</td>
                                <td>ตรวจสภาพถนน</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs5d5 ?> onchange="edit_check5d5('TENKOROADCHECK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" style="transform: scale(2)"  id="chk_5d5" name="chk_5d5"/></td>
                                <td>รายงานสภาพถนน</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT4', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT4" name="TXT_TENKOLOADRESTRESULT4" value="<?= $result_seTenkotransport5['TENKOLOADRESTRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT4', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT4" name="TXT_TENKOBODYSLEEPYRESULT4" value="<?= $result_seTenkotransport5['TENKOBODYSLEEPYRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT4', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT4" name="TXT_TENKOCARNEWRESULT4" value="<?= $result_seTenkotransport5['TENKOCARNEWRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT4', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT4" name="TXT_TENKOTRAILERRESULT4" value="<?= $result_seTenkotransport5['TENKOTRAILERRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT4', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOROADRESULT4" name="TXT_TENKOROADRESULT4" value="<?= $result_seTenkotransport5['TENKOROADRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT4', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT4" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport5['TENKOAIRRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT4', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT4" name="TXT_TENKOSLEEPYRESULT4" value="<?= $result_seTenkotransport5['TENKOSLEEPYRESULT4'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOROADREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"  class="form-control" value="<?= $result_seTenkotransport5['TENKOROADREMARK'] ?>"></td>
                                
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOROADREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"><?= $result_seTenkotransport5['TENKOROADREMARK'] ?></td> -->
                            </tr>
                            <tr>
                                <td style="text-align: center">6</td>
                                <td>ตรวจสภาพอากาศ (ใช้ที่ปัดน้ำฝนระดับ 3 ให้หยุดรถ)</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs6d5 ?> onchange="edit_check6d5('TENKOAIRCHECK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" style="transform: scale(2)"  id="chk_6d5" name="chk_6d5"/></td>
                                <td>รายงานสภาพอากาศ5</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT5', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT5" name="TXT_TENKOLOADRESTRESULT5" value="<?= $result_seTenkotransport5['TENKOLOADRESTRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT5', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT5" name="TXT_TENKOBODYSLEEPYRESULT5" value="<?= $result_seTenkotransport5['TENKOBODYSLEEPYRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT5', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT5" name="TXT_TENKOCARNEWRESULT5" value="<?= $result_seTenkotransport5['TENKOCARNEWRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT5', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT5" name="TXT_TENKOTRAILERRESULT5" value="<?= $result_seTenkotransport5['TENKOTRAILERRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT5', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOROADRESULT5" name="TXT_TENKOROADRESULT5" value="<?= $result_seTenkotransport5['TENKOROADRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT5', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT5" name="TXT_TENKOAIRRESULT5" value="<?= $result_seTenkotransport5['TENKOAIRRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT5', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT5" name="TXT_TENKOSLEEPYRESULT5" value="<?= $result_seTenkotransport5['TENKOSLEEPYRESULT5'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOAIRREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"  class="form-control" value="<?= $result_seTenkotransport5['TENKOAIRREMARK'] ?>"></td>
                                
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOAIRREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"><?= $result_seTenkotransport5['TENKOAIRREMARK'] ?></td> -->
                            </tr>
                            <tr>
                                <td style="text-align: center">7</td>
                                <td>ตรวจสอบอาการง่วงและย้ำให้ระมัดระวัง</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs7d5 ?> onchange="edit_check7d5('TENKOSLEEPYCHECK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" style="transform: scale(2)" id="chk_7d5" name="chk_7d5" /></td>
                                <td>สภาพที่สามารถวิ่งงานต่อได้</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT6', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT6" name="TXT_TENKOLOADRESTRESULT6" value="<?= $result_seTenkotransport5['TENKOLOADRESTRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT6', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT6" name="TXT_TENKOBODYSLEEPYRESULT6" value="<?= $result_seTenkotransport5['TENKOBODYSLEEPYRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT6', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT6" name="TXT_TENKOCARNEWRESULT6" value="<?= $result_seTenkotransport5['TENKOCARNEWRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT6', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT6" name="TXT_TENKOTRAILERRESULT6" value="<?= $result_seTenkotransport5['TENKOTRAILERRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT6', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOROADRESULT6" name="TXT_TENKOROADRESULT6" value="<?= $result_seTenkotransport5['TENKOROADRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT6', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT6" name="TXT_TENKOAIRRESULT6" value="<?= $result_seTenkotransport5['TENKOAIRRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT6', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT6" name="TXT_TENKOSLEEPYRESULT6" value="<?= $result_seTenkotransport5['TENKOSLEEPYRESULT6'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOSLEEPYREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"  class="form-control" value="<?= $result_seTenkotransport5['TENKOSLEEPYREMARK'] ?>"></td>
                                
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOSLEEPYREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"><?= $result_seTenkotransport5['TENKOSLEEPYREMARK'] ?></td> -->
                            </tr>
                        </tbody>
                    </table>

                </div>
             
        </div>
        
    </div>

    <?php
}
if ($_POST['txt_flg'] == "select_tenko3emp1") {
    $condition1 = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
    $sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEmployee = array(
        array('select_employeeehr2', SQLSRV_PARAM_IN),
        array($condition1, SQLSRV_PARAM_IN)
    );
    $query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
    $result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);
    
    $conditionPlain = " AND a.VEHICLETRANSPORTPLANID = '" . $_POST['vehicletransportplanid'] . "'";
    $sql_sePlain = "{call megVehicletransportplan_v2(?,?)}";
    $params_sePlain = array(
        array('select_vehicletransportplan', SQLSRV_PARAM_IN),
        array($conditionPlain, SQLSRV_PARAM_IN)
    );
    $query_sePlain = sqlsrv_query($conn, $sql_sePlain, $params_sePlain);
    $result_sePlain = sqlsrv_fetch_array($query_sePlain, SQLSRV_FETCH_ASSOC);

    $conditionTenkomaster_temp = " AND VEHICLETRANSPORTPLANID = '" . $_POST['vehicletransportplanid'] . "'";
    $sql_seTenkomaster_temp = "{call megVehicletransportplan_v2(?,?,?,?)}";
    $params_seTenkomaster_temp = array(
        array('select_vehicletransporttenko', SQLSRV_PARAM_IN),
        array($conditionTenkomaster_temp, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seTenkomaster_temp = sqlsrv_query($conn, $sql_seTenkomaster_temp, $params_seTenkomaster_temp);
    $result_seTenkomaster_temp = sqlsrv_fetch_array($query_seTenkomaster_temp, SQLSRV_FETCH_ASSOC);

    $conditionTenkomaster = " AND a.TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "'";
    $sql_seTenkomaster = "{call megEdittenkomaster_v2(?,?)}";
    $params_seTenkomaster = array(
        array('select_tenkomaster', SQLSRV_PARAM_IN),
        array($conditionTenkomaster, SQLSRV_PARAM_IN)
    );
    $query_seTenkomaster = sqlsrv_query($conn, $sql_seTenkomaster, $params_seTenkomaster);
    $result_seTenkomaster = sqlsrv_fetch_array($query_seTenkomaster, SQLSRV_FETCH_ASSOC);

    $conditionTenkoafter = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_POST['employeecode1'] . "'";
    $sql_seTenkoafter = "{call megEdittenkoafter_v2(?,?,?)}";
    $params_seTenkoafter = array(
        array('select_tenkoafter', SQLSRV_PARAM_IN),
        array($conditionTenkoafter, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seTenkoafter = sqlsrv_query($conn, $sql_seTenkoafter, $params_seTenkoafter);
    $result_seTenkoafter = sqlsrv_fetch_array($query_seTenkoafter, SQLSRV_FETCH_ASSOC);

    $chk31 = ($result_seTenkoafter['TENKOBEFOREGREETCHECK'] == '1') ? "checked" : "";
    $chk32 = ($result_seTenkoafter['TENKOUNIFORMCHECK'] == '1') ? "checked" : "";
    $chk33 = ($result_seTenkoafter['TENKOBODYCHECK'] == '1') ? "checked" : "";
    $chk34 = ($result_seTenkoafter['TENKOALCOHOLCHECK'] == '1') ? "checked" : "";
    $chk35 = ($result_seTenkoafter['TENKOCARNEWCHECK'] == '1') ? "checked" : "";
    $chk36 = ($result_seTenkoafter['TENKOTRAILERCHECK'] == '1') ? "checked" : "";
    $chk37 = ($result_seTenkoafter['TENKORISKYCHECK'] == '1') ? "checked" : "";
    $chk38 = ($result_seTenkoafter['TENKOAIRCHECK'] == '1') ? "checked" : "";
    $chk39 = ($result_seTenkoafter['TENKOPATTERNDRIVERCHECK'] == '1') ? "checked" : "";
    $chk310 = ($result_seTenkoafter['TENKODAILYDRIVERCHECK'] == '1') ? "checked" : "";
    $chk311 = ($result_seTenkoafter['TENKOHIYARIHATTOCHECK'] == '1') ? "checked" : "";
    $chk312 = ($result_seTenkoafter['TENKOYOKOTENCHECK'] == '1') ? "checked" : "";
    $chk313 = ($result_seTenkoafter['TENKOAFTERGREETCHECK'] == '1') ? "checked" : "";

    $rs311 = ($result_seTenkoafter['TENKOBEFOREGREETRESULT'] == '1') ? "checked" : "";
    $rs321 = ($result_seTenkoafter['TENKOUNIFORMRESULT'] == '1') ? "checked" : "";
    $rs331 = ($result_seTenkoafter['TENKOBODYRESULT'] == '1') ? "checked" : "";
    $rs341 = ($result_seTenkoafter['TENKOALCOHOLRESULT'] == '1') ? "checked" : "";
    $rs351 = ($result_seTenkoafter['TENKOCARNEWRESULT'] == '1') ? "checked" : "";
    $rs361 = ($result_seTenkoafter['TENKOTRAILERRESULT'] == '1') ? "checked" : "";
    $rs371 = ($result_seTenkoafter['TENKORISKYRESULT'] == '1') ? "checked" : "";
    $rs381 = ($result_seTenkoafter['TENKOAIRRESULT'] == '1') ? "checked" : "";
    $rs391 = ($result_seTenkoafter['TENKOPATTERNDRIVERRESULT'] == '1') ? "checked" : "";
    $rs3101 = ($result_seTenkoafter['TENKODAILYDRIVERRESULT'] == '1') ? "checked" : "";
    $rs3111 = ($result_seTenkoafter['TENKOHIYARIHATTORESULT'] == '1') ? "checked" : "";
    $rs3121 = ($result_seTenkoafter['TENKOYOKOTENRESULT'] == '1') ? "checked" : "";
    $rs3131 = ($result_seTenkoafter['TENKOAFTERGREETRESULT'] == '1') ? "checked" : "";

    $rs310 = ($result_seTenkoafter['TENKOBEFOREGREETRESULT'] == '0') ? "checked" : "";
    $rs320 = ($result_seTenkoafter['TENKOUNIFORMRESULT'] == '0') ? "checked" : "";
    $rs330 = ($result_seTenkoafter['TENKOBODYRESULT'] == '0') ? "checked" : "";
    $rs340 = ($result_seTenkoafter['TENKOALCOHOLRESULT'] == '0') ? "checked" : "";
    $rs350 = ($result_seTenkoafter['TENKOCARNEWRESULT'] == '0') ? "checked" : "";
    $rs360 = ($result_seTenkoafter['TENKOTRAILERRESULT'] == '0') ? "checked" : "";
    $rs370 = ($result_seTenkoafter['TENKORISKYRESULT'] == '0') ? "checked" : "";
    $rs380 = ($result_seTenkoafter['TENKOAIRRESULT'] == '0') ? "checked" : "";
    $rs390 = ($result_seTenkoafter['TENKOPATTERNDRIVERRESULT'] == '0') ? "checked" : "";
    $rs3100 = ($result_seTenkoafter['TENKODAILYDRIVERRESULT'] == '0') ? "checked" : "";
    $rs3110 = ($result_seTenkoafter['TENKOHIYARIHATTORESULT'] == '0') ? "checked" : "";
    $rs3120 = ($result_seTenkoafter['TENKOYOKOTENRESULT'] == '0') ? "checked" : "";
    $rs3130 = ($result_seTenkoafter['TENKOAFTERGREETRESULT'] == '0') ? "checked" : "";
    ?>

    <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
        <thead>
            <tr>

                <th colspan="6" ><input type="button" onclick="commit_3('<?= $result_seTenkomaster_temp['TENKOMASTERID'] ?>','<?= $result_seTenkoafter['TENKOAFTERID'] ?>','<?= $result_seEmployee['nameT'] ?>')" class="btn btn-success" value="Commit1_After"> <font style="color: green">พนักงานขับรถ :  <?= $result_sePlain['EMPLOYEENAME1'] ?></font></th>
                <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะก่อนเริ่มงาน</th>
                <th style="text-align: center;"><?= $result_seTenkotransport1["CREATEBY"] ?></th>
                <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะปฎิบัติงาน</th>
                <th style="text-align: center;"><?= $result_seEmployee["nameT"] ?></th>
            </tr>
            <tr>
                <th rowspan="2" style="text-align: center;">ข้อ</th>
                <th rowspan="2" style="text-align: center;">หัวข้อ</th>
                <th rowspan="2" style="text-align: center;">ช่องตรวจสอบ</th>
                <th rowspan="2" style="text-align: center;">เกณฑ์การตัดสิน</th>
                <th colspan="2" style="text-align: center;">ผล</th>
                <th colspan="4" rowspan="2" style="text-align: center;">รายละเอียดและการแนะนำ</th>
            </tr>
            <tr>
                <th style="text-align: center;">ปกติ</th>
                <th style="text-align: center;">ไม่ปกติ</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center">1</td>
                <td>การทักทายก่อนเริ่มเท็งโกะ</td>
                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk31 ?> onchange="edit_check31('TENKOBEFOREGREETCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_31" name="chk_31"/></td>
                <td>ทักทายอย่างมีชีวิตชีวา</td>
                <td style="text-align:center"><input type="checkbox" <?= $rs311 ?> style="transform: scale(2)" id="chk_rs311" name="chk_rs311" onchange="edit_rs311('TENKOBEFOREGREETRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td style="text-align:center"><input type="checkbox" <?= $rs310 ?> style="transform: scale(2)" id="chk_rs310" name="chk_rs310" onchange="edit_rs310('TENKOBEFOREGREETRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOBEFOREGREETREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOBEFOREGREETREMARK'] ?></td>
            </tr>
            <tr>
                <td style="text-align: center">2</td>
                <td>ตรวจเช็คยูนิฟอร์ม</td>
                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk32 ?> onchange="edit_check32('TENKOUNIFORMCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_32" name="chk_32"/></td>
                <td>ไม่มีคราบสกปรก</td>
                <td style="text-align:center"><input type="checkbox" <?= $rs321 ?> style="transform: scale(2)" id="chk_rs321" name="chk_rs321" onchange="edit_rs321('TENKOUNIFORMRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td style="text-align:center"><input type="checkbox" <?= $rs320 ?> style="transform: scale(2)" id="chk_rs320" name="chk_rs320" onchange="edit_rs320('TENKOUNIFORMRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOUNIFORMREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOUNIFORMREMARK'] ?></td>
            </tr>
            <tr>
                <td style="text-align: center">3</td>
                <td>ตรวจสภาพร่างกาย</td>
                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk33 ?> onchange="edit_check33('TENKOBODYCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_33" name="chk_33"/></td>
                <td>สภาพร่างกายแข็งแรงดี</td>
                <td style="text-align:center"><input type="checkbox" <?= $rs331 ?> style="transform: scale(2)" id="chk_rs331" name="chk_rs331" onchange="edit_rs331('TENKOBODYRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td style="text-align:center"><input type="checkbox" <?= $rs330 ?> style="transform: scale(2)" id="chk_rs330" name="chk_rs330" onchange="edit_rs330('TENKOBODYRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOBODYREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOBODYREMARK'] ?></td>
            </tr>
            <tr>
                <td style="text-align: center">4</td>
                <td>ตรวจเช็คแอลกอฮอล์</td>
                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk34 ?> onchange="edit_check34('TENKOALCOHOLCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_34" name="chk_34"/></td>
                <td>[0]</td>
                <td style="text-align:center"><input type="checkbox" <?= $rs341 ?> style="transform: scale(2)" id="chk_rs341" name="chk_rs341" onchange="edit_rs341('TENKOALCOHOLRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td style="text-align:center"><input type="checkbox"  <?= $rs340 ?> style="transform: scale(2)" id="chk_rs340" name="chk_rs340" onchange="edit_rs340('TENKOALCOHOLRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOALCOHOLREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOALCOHOLREMARK'] ?></td>
            </tr>
            <tr>
                <td style="text-align: center">5</td>
                <td>มีความผิดปกติกับรถใหม่หรือไม่</td>
                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk35 ?> onchange="edit_check35('TENKOCARNEWCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_35" name="chk_35"/></td>
                <td>รายงานสิ่งผิดปกติของรถใหม่ว่ามีหรือไม่</td>
                <td style="text-align:center"><input type="checkbox" <?= $rs351 ?> style="transform: scale(2)" id="chk_rs351" name="chk_rs351" onchange="edit_rs351('TENKOCARNEWRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td style="text-align:center"><input type="checkbox" <?= $rs350 ?> style="transform: scale(2)" id="chk_rs350" name="chk_rs350" onchange="edit_rs350('TENKOCARNEWRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOCARNEWREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOCARNEWREMARK'] ?></td>
            </tr>
            <tr>
                <td style="text-align: center">6</td>
                <td>ความผิดปกติของรถเทรลเลอร์</td>
                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk36 ?> onchange="edit_check36('TENKOTRAILERCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_36" name="chk_36"/></td>
                <td>รายงานสิ่งผิดปกติของเทรลเลอร์ว่ามีหรือไม่</td>
                <td style="text-align:center"><input type="checkbox" <?= $rs361 ?> style="transform: scale(2)" id="chk_rs361" name="chk_rs361" onchange="edit_rs361('TENKOTRAILERRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td style="text-align:center"><input type="checkbox" <?= $rs360 ?> style="transform: scale(2)" id="chk_rs360" name="chk_rs360" onchange="edit_rs360('TENKOTRAILERRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOTRAILERREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOTRAILERREMARK'] ?></td>
            </tr>
            <tr>
                <td style="text-align: center">7</td>
                <td>จุดเสี่ยงระหว่างเส้นทางการขนส่ง(ล่าง)</td>
                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk37 ?> onchange="edit_check37('TENKORISKYCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_37" name="chk_37"/></td>
                <td>รายงานว่ามีจุดเปลี่ยนแปลงที่ผิดปกติหรือไม่</td>
                <td style="text-align:center"><input type="checkbox" <?= $rs371 ?> style="transform: scale(2)" id="chk_rs371" name="chk_rs371" onchange="edit_rs371('TENKORISKYRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td style="text-align:center"><input type="checkbox" <?= $rs370 ?> style="transform: scale(2)" id="chk_rs370" name="chk_rs370" onchange="edit_rs370('TENKORISKYRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKORISKYREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKORISKYREMARK'] ?></td>
            </tr>
            <tr>
                <td style="text-align: center">8</td>
                <td>ตรวจสอบสภาพอากาศ</td>
                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk38 ?> onchange="edit_check38('TENKOAIRCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_38" name="chk_38"/></td>
                <td>รายงานสภาพอากาศ6</td>
                <td style="text-align:center"><input type="checkbox" <?= $rs381 ?> style="transform: scale(2)" id="chk_rs381" name="chk_rs381" onchange="edit_rs381('TENKOAIRRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td style="text-align:center"><input type="checkbox" <?= $rs380 ?> style="transform: scale(2)" id="chk_rs380" name="chk_rs380" onchange="edit_rs380('TENKOAIRRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOAIRREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOAIRREMARK'] ?></td>
            </tr>
            <tr>
                <td style="text-align: center">9</td>
                <td>ตรวจสอบรูปแบบการขับขี่</td>
                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk39 ?> onchange="edit_check39('TENKOPATTERNDRIVERCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_39" name="chk_39"/></td>
                <td>รายงานรูปแบบการขับขี่</td>
                <td style="text-align:center"><input type="checkbox" <?= $rs391 ?> style="transform: scale(2)" id="chk_rs391" name="chk_rs391" onchange="edit_rs391('TENKOPATTERNDRIVERRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td style="text-align:center"><input type="checkbox" <?= $rs390 ?> style="transform: scale(2)" id="chk_rs390" name="chk_rs390" onchange="edit_rs390('TENKOPATTERNDRIVERRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOPATTERNDRIVERREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOPATTERNDRIVERREMARK'] ?></td>
            </tr>
            <tr>
                <td style="text-align: center">10</td>
                <td>ตรวจสอบข้อมูลการขับขี่ประจำวันจาก GPS เรคคอร์ด(ล่าง)</td>
                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk310 ?> onchange="edit_check310('TENKODAILYDRIVERCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"  id="chk_310" name="chk_310"/></td>
                <td>หัวข้อฝ่าฝืนเป็น [0]</td>
                <td style="text-align:center"><input type="checkbox" <?= $rs3101 ?> style="transform: scale(2)" id="chk_rs3101" name="chk_rs3101" onchange="edit_rs3101('TENKODAILYDRIVERRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td style="text-align:center"><input type="checkbox" <?= $rs3100 ?> style="transform: scale(2)" id="chk_rs3100" name="chk_rs3100" onchange="edit_rs3100('TENKODAILYDRIVERRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKODAILYDRIVERREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKODAILYDRIVERREMARK'] ?></td>
            </tr>
            <tr>
                <td style="text-align: center">11</td>
                <td>ฮิยาริฮัตโตะนอกเหนือจากข้อ 7.</td>
                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk311 ?> onchange="edit_check311('TENKOHIYARIHATTOCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_311" name="chk_311"/></td>
                <td>เหตุการณ์ที่ตกใจและเกือบเกิดอุบัติเหตุ</td>
                <td style="text-align:center"><input type="checkbox" <?= $rs3111 ?> style="transform: scale(2)" id="chk_rs3111" name="chk_rs3111" onchange="edit_rs3111('TENKOHIYARIHATTORESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td style="text-align:center"><input type="checkbox" <?= $rs3110 ?> style="transform: scale(2)" id="chk_rs3110" name="chk_rs3110" onchange="edit_rs3110('TENKOHIYARIHATTORESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOHIYARIHATTOREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOHIYARIHATTOREMARK'] ?></td>
            </tr>
            <tr>
                <td style="text-align: center">12</td>
                <td>แจ้งเรื่องโยโกะเต็น/แนะนำวิธีการจัดสรรชั่วโมงนอนหลับ</td>
                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk312 ?> onchange="edit_check312('TENKOYOKOTENCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_312" name="chk_312"/></td>
                <td>เข้าใจเนื้อหาและวิธีการต่างๆที่แจ้งไป</td>
                <td style="text-align:center"><input type="checkbox" <?= $rs3121 ?> style="transform: scale(2)" id="chk_rs3121" name="chk_rs3121" onchange="edit_rs3121('TENKOYOKOTENRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td style="text-align:center"><input type="checkbox" <?= $rs3120 ?> style="transform: scale(2)" id="chk_rs3120" name="chk_rs3120" onchange="edit_rs3120('TENKOYOKOTENRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOYOKOTENREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOYOKOTENREMARK'] ?></td>
            </tr>
            <tr>
                <td style="text-align: center">13</td>
                <td>การทักทายหลังทำเท็งโกะเสร็จ</td>
                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk313 ?> onchange="edit_check313('TENKOAFTERGREETCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_313" name="chk_313"/></td>
                <td>ทักทายอย่างมีชีวิตชีวา</td>
                <td style="text-align:center"><input type="checkbox" <?= $rs3131 ?> style="transform: scale(2)" id="chk_rs3131" name="chk_rs3131" onchange="edit_rs3131('TENKOAFTERGREETRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td style="text-align:center"><input type="checkbox" <?= $rs3130 ?> style="transform: scale(2)" id="chk_rs3130" name="chk_rs3130" onchange="edit_rs3130('TENKOAFTERGREETRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOAFTERGREETREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOAFTERGREETREMARK'] ?></td>
            </tr>
        </tbody>
    </table>

    <?php
}
if ($_POST['txt_flg'] == "select_tenko4emp1-1") {
    $condition1 = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
    $sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEmployee = array(
        array('select_employeeehr2', SQLSRV_PARAM_IN),
        array($condition1, SQLSRV_PARAM_IN)
    );
    $query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
    $result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);
    
    $conditionPlain = " AND a.VEHICLETRANSPORTPLANID = '" . $_POST['vehicletransportplanid'] . "'";
    $sql_sePlain = "{call megVehicletransportplan_v2(?,?)}";
    $params_sePlain = array(
        array('select_vehicletransportplan', SQLSRV_PARAM_IN),
        array($conditionPlain, SQLSRV_PARAM_IN)
    );
    $query_sePlain = sqlsrv_query($conn, $sql_sePlain, $params_sePlain);
    $result_sePlain = sqlsrv_fetch_array($query_sePlain, SQLSRV_FETCH_ASSOC);

    $conditionTenkomaster_temp = " AND VEHICLETRANSPORTPLANID = '" . $_POST['vehicletransportplanid'] . "'";
    $sql_seTenkomaster_temp = "{call megVehicletransportplan_v2(?,?,?,?)}";
    $params_seTenkomaster_temp = array(
        array('select_vehicletransporttenko', SQLSRV_PARAM_IN),
        array($conditionTenkomaster_temp, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seTenkomaster_temp = sqlsrv_query($conn, $sql_seTenkomaster_temp, $params_seTenkomaster_temp);
    $result_seTenkomaster_temp = sqlsrv_fetch_array($query_seTenkomaster_temp, SQLSRV_FETCH_ASSOC);

    $conditionTenkomaster = " AND a.TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "'";
    $sql_seTenkomaster = "{call megEdittenkomaster_v2(?,?)}";
    $params_seTenkomaster = array(
        array('select_tenkomaster', SQLSRV_PARAM_IN),
        array($conditionTenkomaster, SQLSRV_PARAM_IN)
    );
    $query_seTenkomaster = sqlsrv_query($conn, $sql_seTenkomaster, $params_seTenkomaster);
    $result_seTenkomaster = sqlsrv_fetch_array($query_seTenkomaster, SQLSRV_FETCH_ASSOC);

    if ($result_sePlain['COMPANYCODE'] == 'RRC' || $result_sePlain['COMPANYCODE'] == 'RCC' || $result_sePlain['COMPANYCODE'] == 'RATC') {
        $conditionTenkorisky = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_POST['employeecode1'] . "'";
        $sql_seTenkorisky = "{call megEdittenkorisky_v2(?,?,?)}";
        $params_seTenkorisky = array(
            array('select_tenkorisky', SQLSRV_PARAM_IN),
            array($conditionTenkorisky, SQLSRV_PARAM_IN),
            array('', SQLSRV_PARAM_IN)
        );
        $query_seTenkorisky = sqlsrv_query($conn, $sql_seTenkorisky, $params_seTenkorisky);
        $result_seTenkorisky = sqlsrv_fetch_array($query_seTenkorisky, SQLSRV_FETCH_ASSOC);

        $rs411 = ($result_seTenkorisky['TENKORISKYBPRESULT'] == '1') ? "checked" : "";
        $rs421 = ($result_seTenkorisky['TENKORISKYSRRESULT'] == '1') ? "checked" : "";
        $rs431 = ($result_seTenkorisky['TENKORISKYGWRESULT'] == '1') ? "checked" : "";
        $rs441 = ($result_seTenkorisky['TENKORISKYOTH1RESULT'] == '1') ? "checked" : "";
        $rs451 = ($result_seTenkorisky['TENKORISKYBRANCHRESULT'] == '1') ? "checked" : "";
        $rs461 = ($result_seTenkorisky['TENKOWIRERESULT'] == '1') ? "checked" : "";
        $rs471 = ($result_seTenkorisky['TENKOLOADRESULT'] == '1') ? "checked" : "";
        $rs481 = ($result_seTenkorisky['TENKOTRAILERPARKINGRESULT'] == '1') ? "checked" : "";
        $rs491 = ($result_seTenkorisky['TENKOCARNEWPARKINGRESULT'] == '1') ? "checked" : "";
        $rs4101 = ($result_seTenkorisky['TENKORISKYOTH2RESULT'] == '1') ? "checked" : "";


        $rs410 = ($result_seTenkorisky['TENKORISKYBPRESULT'] == '0') ? "checked" : "";
        $rs420 = ($result_seTenkorisky['TENKORISKYSRRESULT'] == '0') ? "checked" : "";
        $rs430 = ($result_seTenkorisky['TENKORISKYGWRESULT'] == '0') ? "checked" : "";
        $rs440 = ($result_seTenkorisky['TENKORISKYOTH1RESULT'] == '0') ? "checked" : "";
        $rs450 = ($result_seTenkorisky['TENKORISKYBRANCHRESULT'] == '0') ? "checked" : "";
        $rs460 = ($result_seTenkorisky['TENKOWIRERESULT'] == '0') ? "checked" : "";
        $rs470 = ($result_seTenkorisky['TENKOLOADRESULT'] == '0') ? "checked" : "";
        $rs480 = ($result_seTenkorisky['TENKOTRAILERPARKINGRESULT'] == '0') ? "checked" : "";
        $rs490 = ($result_seTenkorisky['TENKOCARNEWPARKINGRESULT'] == '0') ? "checked" : "";
        $rs4100 = ($result_seTenkorisky['TENKORISKYOTH2RESULT'] == '0') ? "checked" : "";
        ?>

        <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
            <thead>
                <tr>

                    <th colspan="6" ><font style="color: green">พนักงานขับรถ :  <?= $result_sePlain['EMPLOYEENAME1'] ?></font></th>
                </tr>
                <tr>
                    <th style="text-align: center">ข้อ</th>
                    <th style="text-align: center" colspan="2">หัวข้อ</th>
                    <th colspan="2" style="text-align: center">สิ่งผิดปกติ</th>
                    <th style="text-align: center">รายละเอียดสิ่งผิดปกติ</th>
                </tr>
                <tr>
                    <th style="text-align: center">&nbsp;</th>
                    <th style="text-align: center" colspan="2">&nbsp;</th>
                    <th style="text-align: center">มี</th>
                    <th style="text-align: center">ไม่มี</th>
                    <th style="text-align: center">&nbsp;</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td rowspan="4" style="text-align: center">1</td>
                    <td rowspan="4">ในยาร์ด</td>
                    <td>บ้านโพธิ์</td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs411 ?> onchange="edit_rs411('TENKORISKYBPRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"  style="transform: scale(2)" id="chk_rs411" name="chk_rs411" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs410 ?> onchange="edit_rs410('TENKORISKYBPRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs410" name="chk_rs410" /></td>
                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKORISKYBPREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKORISKYBPREMARK'] ?></td>
                </tr>
                <tr>
                    <td>สำโรง</td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs421 ?> onchange="edit_rs421('TENKORISKYSRRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs421" name="chk_rs421" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs420 ?>  onchange="edit_rs420('TENKORISKYSRRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs420" name="chk_rs420" /></td>
                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKORISKYSRREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKORISKYSRREMARK'] ?></td>
                </tr>
                <tr>
                    <td>เกตุเวย์</td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs431 ?> onchange="edit_rs431('TENKORISKYGWRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs431" name="chk_rs431" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs430 ?> onchange="edit_rs430('TENKORISKYGWRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs430" name="chk_rs430" /></td>
                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKORISKYGWREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKORISKYGWREMARK'] ?></td>
                </tr>
                <tr>
                    <td>อื่นๆ</td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs441 ?> onchange="edit_rs441('TENKORISKYOTH1RESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" style="transform: scale(2)" id="chk_rs441" name="chk_rs441" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs440 ?> onchange="edit_rs440('TENKORISKYOTH1RESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" style="transform: scale(2)" id="chk_rs440" name="chk_rs440" /></td>
                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKORISKYOTH1REMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKORISKYOTH1REMARK'] ?></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align: center">2</td>
                    <td rowspan="3">บนถนน</td>
                    <td>กิ่งไม้</td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs451 ?> onchange="edit_rs451('TENKORISKYBRANCHRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs451" name="chk_rs451" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs450 ?> onchange="edit_rs450('TENKORISKYBRANCHRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs450" name="chk_rs450" /></td>
                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKORISKYBRANCHREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKORISKYBRANCHREMARK'] ?></td>
                </tr>
                <tr>
                    <td>สายไฟ</td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs461 ?> onchange="edit_rs461('TENKOWIRERESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs461" name="chk_rs461" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs460 ?> onchange="edit_rs460('TENKOWIRERESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs460" name="chk_rs460" /></td>
                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKOWIREREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKOWIREREMARK'] ?></td>
                </tr>
                <tr>
                    <td>สภาพถนน,ก่อสร้าง</td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs471 ?> onchange="edit_rs471('TENKOLOADRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs471" name="chk_rs471" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs470 ?> onchange="edit_rs470('TENKOLOADRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs470" name="chk_rs470" /></td>
                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKOLOADREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKOLOADREMARK'] ?></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align: center">3</td>
                    <td rowspan="3">ตัวแทนจำหน่ย</td>
                    <td>จุดจอดเทรลเลอร์</td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs481 ?> onchange="edit_rs481('TENKOTRAILERPARKINGRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs481" name="chk_rs481" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs480 ?> onchange="edit_rs480('TENKOTRAILERPARKINGRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs480" name="chk_rs480" /></td>
                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKOTRAILERPARKINGREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKOTRAILERPARKINGREMARK'] ?></td>
                </tr>
                <tr>
                    <td>พื้นที่รับรถใหม่</td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs491 ?> onchange="edit_rs491('TENKOCARNEWPARKINGRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs491" name="chk_rs491" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs490 ?> onchange="edit_rs490('TENKOCARNEWPARKINGRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs490" name="chk_rs490" /></td>
                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKOCARNEWPARKINGREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKOCARNEWPARKINGREMARK'] ?></td>
                </tr>
                <tr>
                    <td>อื่นๆ</td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs4101 ?> onchange="edit_rs4101('TENKORISKYOTH2RESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs4101" name="chk_rs4101" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs4100 ?> onchange="edit_rs4100('TENKORISKYOTH2RESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs4100" name="chk_rs4100" /></td>
                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKORISKYOTH2REMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKORISKYOTH2REMARK'] ?></td>
                </tr>
            </tbody>
        </table>

        <?php
    }
}
if ($_POST['txt_flg'] == "select_tenko4emp1-2") {
    $conditionPlain = " AND a.VEHICLETRANSPORTPLANID = '" . $_POST['vehicletransportplanid'] . "'";
    $sql_sePlain = "{call megVehicletransportplan_v2(?,?)}";
    $params_sePlain = array(
        array('select_vehicletransportplan', SQLSRV_PARAM_IN),
        array($conditionPlain, SQLSRV_PARAM_IN)
    );
    $query_sePlain = sqlsrv_query($conn, $sql_sePlain, $params_sePlain);
    $result_sePlain = sqlsrv_fetch_array($query_sePlain, SQLSRV_FETCH_ASSOC);

    $conditionTenkomaster_temp = " AND VEHICLETRANSPORTPLANID = '" . $_POST['vehicletransportplanid'] . "'";
    $sql_seTenkomaster_temp = "{call megVehicletransportplan_v2(?,?,?,?)}";
    $params_seTenkomaster_temp = array(
        array('select_vehicletransporttenko', SQLSRV_PARAM_IN),
        array($conditionTenkomaster_temp, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seTenkomaster_temp = sqlsrv_query($conn, $sql_seTenkomaster_temp, $params_seTenkomaster_temp);
    $result_seTenkomaster_temp = sqlsrv_fetch_array($query_seTenkomaster_temp, SQLSRV_FETCH_ASSOC);

    $conditionTenkomaster = " AND a.TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "'";
    $sql_seTenkomaster = "{call megEdittenkomaster_v2(?,?)}";
    $params_seTenkomaster = array(
        array('select_tenkomaster', SQLSRV_PARAM_IN),
        array($conditionTenkomaster, SQLSRV_PARAM_IN)
    );
    $query_seTenkomaster = sqlsrv_query($conn, $sql_seTenkomaster, $params_seTenkomaster);
    $result_seTenkomaster = sqlsrv_fetch_array($query_seTenkomaster, SQLSRV_FETCH_ASSOC);

    if ($result_sePlain['COMPANYCODE'] == 'RKR' || $result_sePlain['COMPANYCODE'] == 'RKS' || $result_sePlain['COMPANYCODE'] == 'RKL') {
        $conditionTenkorisky = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_POST['employeecode1'] . "'";
        $sql_seTenkorisky = "{call megEdittenkorisky_v2(?,?,?)}";
        $params_seTenkorisky = array(
            array('select_tenkorisky', SQLSRV_PARAM_IN),
            array($conditionTenkorisky, SQLSRV_PARAM_IN),
            array('', SQLSRV_PARAM_IN)
        );
        $query_seTenkorisky = sqlsrv_query($conn, $sql_seTenkorisky, $params_seTenkorisky);
        $result_seTenkorisky = sqlsrv_fetch_array($query_seTenkorisky, SQLSRV_FETCH_ASSOC);

        $rs451 = ($result_seTenkorisky['TENKORISKYBRANCHRESULT'] == '1') ? "checked" : "";
        $rs461 = ($result_seTenkorisky['TENKOWIRERESULT'] == '1') ? "checked" : "";
        $rs471 = ($result_seTenkorisky['TENKOLOADRESULT'] == '1') ? "checked" : "";
        $rs451_h = ($result_seTenkorisky['TENKORISKYBRANCHRESULT_H'] == '1') ? "checked" : "";
        $rs461_h = ($result_seTenkorisky['TENKOWIRERESULT_H'] == '1') ? "checked" : "";
        $rs471_h = ($result_seTenkorisky['TENKOLOADRESULT_H'] == '1') ? "checked" : "";



        $rs450 = ($result_seTenkorisky['TENKORISKYBRANCHRESULT'] == '0') ? "checked" : "";
        $rs460 = ($result_seTenkorisky['TENKOWIRERESULT'] == '0') ? "checked" : "";
        $rs470 = ($result_seTenkorisky['TENKOLOADRESULT'] == '0') ? "checked" : "";
        $rs450_h = ($result_seTenkorisky['TENKORISKYBRANCHRESULT_H'] == '0') ? "checked" : "";
        $rs460_h = ($result_seTenkorisky['TENKOWIRERESULT_H'] == '0') ? "checked" : "";
        $rs470_h = ($result_seTenkorisky['TENKOLOADRESULT_H'] == '0') ? "checked" : "";
        ?>
        
        <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
            <thead>
                <tr>

                    <th colspan="7" ><font style="color: green">พนักงานขับรถ :  <?= $result_sePlain['EMPLOYEENAME1'] ?></font></th>
                </tr>
                <tr>
                    <th style="text-align: center">ข้อ</th>
                    <th style="text-align: center" >หัวข้อ</th>
                    <th colspan="2" style="text-align: center">สิ่งผิดปกติ</th>
                    <th colspan="2" style="text-align: center">ฮิยาริฮัตโตะ</th>
                    <th style="text-align: center">รายละเอียดสิ่งผิดปกติ</th>
                </tr>
                <tr>
                    <th style="text-align: center">&nbsp;</th>
                    <th style="text-align: center">&nbsp;</th>
                    <th style="text-align: center">มี</th>
                    <th style="text-align: center">ไม่มี</th>
                    <th style="text-align: center">มี</th>
                    <th style="text-align: center">ไม่มี</th>
                    <th style="text-align: center">&nbsp;</th>
                </tr>
            </thead>
            <tbody>


                <tr>
                    <td style="text-align: center">1</td>

                    <td>กิ่งไม้</td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs451 ?> onchange="edit_rs451('TENKORISKYBRANCHRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs451" name="chk_rs451" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs450 ?> onchange="edit_rs450('TENKORISKYBRANCHRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs450" name="chk_rs450" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs451_h ?> onchange="edit_rs451_h('TENKORISKYBRANCHRESULT_H', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"  style="transform: scale(2)" id="chk_rs451_h" name="chk_rs451_h" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs450_h ?> onchange="edit_rs450_h('TENKORISKYBRANCHRESULT_H', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs450_h" name="chk_rs450_h" /></td>
                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKORISKYBRANCHREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKORISKYBRANCHREMARK'] ?></td>

                </tr>
                <tr>
                    <td style="text-align: center">2</td>
                    <td>สายไฟ</td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs461 ?> onchange="edit_rs461('TENKOWIRERESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs461" name="chk_rs461" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs460 ?> onchange="edit_rs460('TENKOWIRERESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs460" name="chk_rs460" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs461_h ?> onchange="edit_rs461_h('TENKOWIRERESULT_H', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"  style="transform: scale(2)" id="chk_rs461_h" name="chk_rs461_h" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs460_h ?> onchange="edit_rs460_h('TENKOWIRERESULT_H', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs460_h" name="chk_rs460_h" /></td>
                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKOWIREREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKOWIREREMARK'] ?></td>
                </tr>
                <tr>
                    <td style="text-align: center">3</td>
                    <td>สภาพถนน,ก่อสร้าง</td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs471 ?> onchange="edit_rs471('TENKOLOADRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs471" name="chk_rs471" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs470 ?> onchange="edit_rs470('TENKOLOADRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs470" name="chk_rs470" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs471_h ?> onchange="edit_rs471_h('TENKOLOADRESULT_H', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"  style="transform: scale(2)" id="chk_rs471_h" name="chk_rs471_h" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs470_h ?> onchange="edit_rs470_h('TENKOLOADRESULT_H', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs470_h" name="chk_rs470_h" /></td>
                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKOLOADREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKOLOADREMARK'] ?></td>
                </tr>

            </tbody>
        </table>

        <?php
    }
}
if ($_POST['txt_flg'] == "select_tenko5emp1") {
    $conditionPlain = " AND a.VEHICLETRANSPORTPLANID = '" . $_POST['vehicletransportplanid'] . "'";
    $sql_sePlain = "{call megVehicletransportplan_v2(?,?)}";
    $params_sePlain = array(
        array('select_vehicletransportplan', SQLSRV_PARAM_IN),
        array($conditionPlain, SQLSRV_PARAM_IN)
    );
    $query_sePlain = sqlsrv_query($conn, $sql_sePlain, $params_sePlain);
    $result_sePlain = sqlsrv_fetch_array($query_sePlain, SQLSRV_FETCH_ASSOC);
    ?>



    <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
        <thead>

            <tr>

                <th colspan="6" ><font style="color: green">พนักงานขับรถ :  <?= $result_sePlain['EMPLOYEENAME1'] ?></font></th>

            </tr>

        </thead>
        <tbody>

            <tr>
                <td style="text-align: center">
                    &nbsp;
                </td>
                <td style="text-align: center" >
                    <img src="../images/noimage.jpg" width="200"/>
                </td>
                <td style="text-align: center">
                    <img src="../images/noimage.jpg" width="200"/>
                </td>
                <td style="text-align: center">
                    <img src="../images/noimage.jpg" width="200"/>
                </td>
                <td style="text-align: center">
                    <img src="../images/noimage.jpg" width="200"/>
                </td>
                <td style="text-align: center">
                    <img src="../images/noimage.jpg" width="200"/>
                </td>
                <!--<td width="20%" style="text-align:center">
                    <img src="../upload_imagemap/<?//= $_POST['vehicletransportplanid'] . $_POST['employeecode1'] ?>1.jpg" width="200"/>

                </td>
                <td width="20%" style="text-align:center">
                    <img src="../upload_imagemap/<?//= $_POST['vehicletransportplanid'] . $_POST['employeecode1'] ?>2.jpg" width="200"/>

                </td>
                <td width="20%" style="text-align:center">
                    <img src="../upload_imagemap/<?//= $_POST['vehicletransportplanid'] . $_POST['employeecode1'] ?>3.jpg" width="200"/>

                </td>
                <td width="20%" style="text-align:center">
                    <img src="../upload_imagemap/<?//= $_POST['vehicletransportplanid'] . $_POST['employeecode1'] ?>4.jpg" width="200"/>

                </td>
                <td width="20%" style="text-align:center">
                    <img src="../upload_imagemap/<?//= $_POST['vehicletransportplanid'] . $_POST['employeecode1'] ?>5.jpg" width="200"/>

                </td>
                -->
            </tr>
        </tbody>
    </table>
    <!--</form>-->

    <?php
}
if ($_POST['txt_flg'] == "select_tenko6emp1") {
    $condition1 = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
    $sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEmployee = array(
        array('select_employeeehr2', SQLSRV_PARAM_IN),
        array($condition1, SQLSRV_PARAM_IN)
    );
    $query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
    $result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);
    
    $conditionPlain = " AND a.VEHICLETRANSPORTPLANID = '" . $_POST['vehicletransportplanid'] . "'";
    $sql_sePlain = "{call megVehicletransportplan_v2(?,?)}";
    $params_sePlain = array(
        array('select_vehicletransportplan', SQLSRV_PARAM_IN),
        array($conditionPlain, SQLSRV_PARAM_IN)
    );
    $query_sePlain = sqlsrv_query($conn, $sql_sePlain, $params_sePlain);
    $result_sePlain = sqlsrv_fetch_array($query_sePlain, SQLSRV_FETCH_ASSOC);

    $conditionTenkomaster_temp = " AND VEHICLETRANSPORTPLANID = '" . $_POST['vehicletransportplanid'] . "'";
    $sql_seTenkomaster_temp = "{call megVehicletransportplan_v2(?,?,?,?)}";
    $params_seTenkomaster_temp = array(
        array('select_vehicletransporttenko', SQLSRV_PARAM_IN),
        array($conditionTenkomaster_temp, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seTenkomaster_temp = sqlsrv_query($conn, $sql_seTenkomaster_temp, $params_seTenkomaster_temp);
    $result_seTenkomaster_temp = sqlsrv_fetch_array($query_seTenkomaster_temp, SQLSRV_FETCH_ASSOC);

    $conditionTenkomaster = " AND a.TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "'";
    $sql_seTenkomaster = "{call megEdittenkomaster_v2(?,?)}";
    $params_seTenkomaster = array(
        array('select_tenkomaster', SQLSRV_PARAM_IN),
        array($conditionTenkomaster, SQLSRV_PARAM_IN)
    );
    $query_seTenkomaster = sqlsrv_query($conn, $sql_seTenkomaster, $params_seTenkomaster);
    $result_seTenkomaster = sqlsrv_fetch_array($query_seTenkomaster, SQLSRV_FETCH_ASSOC);

    $conditionTenkogps = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_POST['employeecode1'] . "'";
    $sql_seTenkogps = "{call megEdittenkogps_v2(?,?,?)}";
    $params_seTenkogps = array(
        array('select_tenkogps', SQLSRV_PARAM_IN),
        array($conditionTenkogps, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seTenkogps = sqlsrv_query($conn, $sql_seTenkogps, $params_seTenkogps);
    $result_seTenkogps = sqlsrv_fetch_array($query_seTenkogps, SQLSRV_FETCH_ASSOC);
    ?>

    <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
        <thead>

            <tr>

                <th colspan="5" ><font style="color: green">พนักงานขับรถ :  <?= $result_sePlain['EMPLOYEENAME1'] ?></font></th>
            </tr>
            <tr>
                <th style="text-align: center;">ข้อ</th>
                <th style="text-align: center;height: 35px; width:100px;">หัวข้อ</th>
                <th style="text-align: center;height: 35px; width:100px;">จำนวน</th>
                <th style="text-align: center;height: 35px; width:300px;">รายละเอียดการชี้แนะ</th>
                <th style="text-align: center;height: 35px; width:180px;">ลายเซ็น พขร.</th>
            </tr>
        </thead>
        <tbody>
            <!-- <tr>
                <td style="text-align: center;">1</td>
                <td>ความเร็วเกินกำหนด</td>
                <td contenteditable="true" onkeyup="edit_tenkogps(this, 'TENKOGPSSPEEDOVERAMOUNT', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"><?= $result_seTenkogps['TENKOGPSSPEEDOVERAMOUNT'] ?></td>
                <td contenteditable="true" onkeyup="edit_tenkogps(this, 'TENKOGPSSPEEDOVERREMARK', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"><?= $result_seTenkogps['TENKOGPSSPEEDOVERREMARK'] ?></td>
                <td contenteditable="true" onkeyup="edit_tenkogps(this, 'TENKOGPSSPEEDOVERDIRVER', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"><?= $result_seTenkogps['TENKOGPSSPEEDOVERDIRVER'] ?></td>
            </tr> -->
            <tr>
                <td style="text-align: center;height: 35px; width:100px;">1</td>
                <td>ความเร็วเกินกำหนด</td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSSPEEDOVERAMOUNT', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:150px;" class="form-control"  type="text" name="txt_speedoveramountemp1" id="txt_speedoveramountemp1" value="<?= $result_seTenkogps['TENKOGPSSPEEDOVERAMOUNT'] ?>"></td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSSPEEDOVERREMARK', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:500px;" class="form-control"  type="text" name="txt_speedoverremarkemp1" id="txt_speedoverremarkemp1" value="<?= $result_seTenkogps['TENKOGPSSPEEDOVERREMARK'] ?>"></td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSSPEEDOVERDIRVER', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:180px;" class="form-control"  type="text" name="txt_speedoverdriveremp1" id="txt_speedoverdriveremp1" value="<?= $result_seTenkogps['TENKOGPSSPEEDOVERDIRVER'] ?>"></td>
            </tr>
            <tr>
                <td style="text-align: center;height: 35px; width:100px;">2</td>
                <td>เบรคกระทันหัน</td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSBRAKEAMOUNT', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:150px;" class="form-control"  type="text" name="txt_brakeamountemp1" id="txt_brakeamountemp1" value="<?= $result_seTenkogps['TENKOGPSBRAKEAMOUNT'] ?>"></td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSBRAKEREMARK', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:500px;" class="form-control"  type="text" name="txt_brakeremarkemp1" id="txt_brakeremarkemp1" value="<?= $result_seTenkogps['TENKOGPSBRAKEREMARK'] ?>"></td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSBRAKEDIRVER', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:180px;" class="form-control"  type="text" name="txt_brakedriveremp1" id="txt_brakedriveremp1" value="<?= $result_seTenkogps['TENKOGPSBRAKEDIRVER'] ?>"></td>
            </tr>
            <tr>
                <td style="text-align: center;height: 35px; width:100px;">3</td>
                <td>รอบเครื่องเกินกำหนด</td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSSPEEDMACHINEAMOUNT', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:150px;" class="form-control"  type="text" name="txt_gpsspeedmechineamountemp1" id="txt_gpsspeedmechineamountemp1" value="<?= $result_seTenkogps['TENKOGPSSPEEDMACHINEAMOUNT'] ?>"></td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSSPEEDMACHINEREMARK', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:500px;" class="form-control"  type="text" name="txt_gpsspeedmechineremarkemp1" id="txt_gpsspeedmechineremarkemp1" value="<?= $result_seTenkogps['TENKOGPSSPEEDMACHINEREMARK'] ?>"></td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSSPEEDMACHINEDIRVER', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:180px;" class="form-control"  type="text" name="txt_gpsspeedmechinedriveremp1" id="txt_gpsspeedmechinedriveremp1" value="<?= $result_seTenkogps['TENKOGPSSPEEDMACHINEDIRVER'] ?>"></td>
            </tr>
            <tr>
                <td style="text-align: center;height: 35px; width:100px;">4</td>
                <td>วิ่งนอกเส้นทาง</td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSOUTLINEAMOUNT', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:150px;" class="form-control"  type="text" name="txt_outlineamountemp1" id="txt_outlineamountemp1" value="<?= $result_seTenkogps['TENKOGPSOUTLINEAMOUNT'] ?>"></td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSOUTLINEREMARK', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:500px;" class="form-control"  type="text" name="txt_outlineremarkemp1" id="txt_outlineremarkemp1" value="<?= $result_seTenkogps['TENKOGPSOUTLINEREMARK'] ?>"></td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSOUTLINEDIRVER', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:180px;" class="form-control"  type="text" name="txt_outlinedriveremp1" id="txt_outlinedriveremp1" value="<?= $result_seTenkogps['TENKOGPSOUTLINEDIRVER'] ?>"></td>
            </tr>
            <tr>
                <td style="text-align: center;height: 35px; width:100px;">5</td>
                <td>ขับรถต่อเนื่อง 4 ชม.</td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSCONTINUOUSAMOUNT', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:150px;" class="form-control"  type="text" name="txt_continuousamountemp1" id="txt_continuousamountemp1" value="<?= $result_seTenkogps['TENKOGPSCONTINUOUSAMOUNT'] ?>"></td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSCONTINUOUSREMARK', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:500px;" class="form-control"  type="text" name="txt_continuousremarkemp1" id="txt_continuousremarkemp1" value="<?= $result_seTenkogps['TENKOGPSCONTINUOUSREMARK'] ?>"></td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSCONTINUOUSDIRVER', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:180px;" class="form-control"  type="text" name="txt_continuousdriveremp1" id="txt_continuousdriveremp1" value="<?= $result_seTenkogps['TENKOGPSCONTINUOUSDIRVER'] ?>"></td>
            </tr>
 
        </tbody>
    </table>

    <?php
}
if ($_POST['txt_flg'] == "check_gpspointemp1") {
    ?>

            <div style="text-align: center;">
                <?php
                    $sql_CheckPoint = "SELECT TENKOGPSSPEEDOVERAMOUNT,TENKOGPSBRAKEAMOUNT,TENKOGPSSPEEDMACHINEAMOUNT,
                    TENKOGPSOUTLINEAMOUNT,TENKOGPSCONTINUOUSAMOUNT,GRADEDRIVER,POINTDRIVER
                    FROM TENKOGPS WHERE TENKOMASTERID ='".$_POST['tenkomasterid']."'
                    AND TENKOMASTERDIRVERCODE ='".$_POST['employeecode']."'";
                    $params_CheckPoint = array();
                    $query_CheckPoint = sqlsrv_query($conn, $sql_CheckPoint, $params_CheckPoint);
                    $result_CheckPoint = sqlsrv_fetch_array($query_CheckPoint, SQLSRV_FETCH_ASSOC);

            

                    //	ความเร็วเกินกำหนด
                    if ($result_CheckPoint['TENKOGPSSPEEDOVERAMOUNT'] == '' || $result_CheckPoint['TENKOGPSSPEEDOVERAMOUNT'] == NULL || $result_CheckPoint['TENKOGPSSPEEDOVERAMOUNT'] == '-') {
                        $speedoverpoint = '100';
                    }else {
                        $speedoverpoint = $result_CheckPoint['TENKOGPSSPEEDOVERAMOUNT'];
                    }
                    
                    // 	เบรคกระทันหัน
                    if ($result_CheckPoint['TENKOGPSBRAKEAMOUNT'] == '' || $result_CheckPoint['TENKOGPSBRAKEAMOUNT'] == NULL || $result_CheckPoint['TENKOGPSSPEEDOVERAMOUNT'] == '-') {
                        $gpsbrakepoint = '100';
                    }else {
                        $gpsbrakepoint = $result_CheckPoint['TENKOGPSBRAKEAMOUNT'];
                    }
                    
                    // รอบเครื่องเกินกำหนด
                    if ($result_CheckPoint['TENKOGPSSPEEDMACHINEAMOUNT'] == '' || $result_CheckPoint['TENKOGPSSPEEDMACHINEAMOUNT'] == NULL || $result_CheckPoint['TENKOGPSSPEEDOVERAMOUNT'] == '-') {
                        $speedmechinepoint = '100';
                    }else {
                        $speedmechinepoint = $result_CheckPoint['TENKOGPSSPEEDMACHINEAMOUNT'];
                    }
                    
                    //	วิ่งนอกเส้นทาง
                    if ($result_CheckPoint['TENKOGPSOUTLINEAMOUNT'] == '' || $result_CheckPoint['TENKOGPSOUTLINEAMOUNT'] == NULL || $result_CheckPoint['TENKOGPSSPEEDOVERAMOUNT'] == '-') {
                        $outlinepoint = '100';
                    }else {
                        $outlinepoint = $result_CheckPoint['TENKOGPSOUTLINEAMOUNT'];
                    }
                    
                    //	ขับรถต่อเนื่อง 4 ชม.
                    if ($result_CheckPoint['TENKOGPSCONTINUOUSAMOUNT'] == '' || $result_CheckPoint['TENKOGPSCONTINUOUSAMOUNT'] == NULL || $result_CheckPoint['TENKOGPSSPEEDOVERAMOUNT'] == '-') {
                        $continuepoint = '100';
                    }else {
                        $continuepoint = $result_CheckPoint['TENKOGPSCONTINUOUSAMOUNT'];
                    }

                    // ถ้าทำผิดหัก ครั้งละ 2 คะแนน                    
                    $maxpoint = 100;
                    $sumpoint = ($speedoverpoint+$gpsbrakepoint+$speedmechinepoint+$outlinepoint+$continuepoint)*2;

                    if($sumpoint == '1000'){
                        $allpoint = 'ไม่มีผลคะแนน';
                    }else {
                        $allpoint = ($maxpoint)-($sumpoint);
                    }

                    

                    if ($allpoint == '100') {
                        $grade = 'A';
                    }else if(($allpoint >= '80') && ($allpoint <= '99')){
                        $grade = 'B';
                    }else if(($allpoint >= '60') && ($allpoint <= '79')){
                        $grade = 'C';
                    }else if(($allpoint >= '40') && ($allpoint <= '59')){
                        $grade = 'D';
                    }else if(($allpoint >= '0') && ($allpoint <= '39')){
                        $grade = 'E';
                    }else {
                        $grade = 'ไม่มีผลการประเมิน';
                    }
                ?>
                <tr>
                    <input type="text" name="txt_gradeemp1" id="txt_gradeemp1" value="<?= $grade ?>" style="display:none">
                    <input type="text" name="txt_pointemp1" id="txt_pointemp1" value="<?= $allpoint ?>" style="display:none">
                    <!-- <td colspan = "4" style="border: 1px solid black;border-collapse: collapse;background-color: #c9c9c9;text-align: center;padding: 5px"><?=$grade?></td>
                    <td colspan = "4" style="border: 1px solid black;border-collapse: collapse;background-color: #c9c9c9;text-align: center;padding: 5px"><?=$allpoint?></td> -->
                </tr>
            </div>
        
    <?php
}
if ($_POST['txt_flg'] == "check_gpspointemp2") {
    ?>

            <div style="text-align: center;">
                <?php
                    $sql_CheckPoint = "SELECT TENKOGPSSPEEDOVERAMOUNT,TENKOGPSBRAKEAMOUNT,TENKOGPSSPEEDMACHINEAMOUNT,
                    TENKOGPSOUTLINEAMOUNT,TENKOGPSCONTINUOUSAMOUNT,GRADEDRIVER,POINTDRIVER
                    FROM TENKOGPS WHERE TENKOMASTERID ='".$_POST['tenkomasterid']."'
                    AND TENKOMASTERDIRVERCODE ='".$_POST['employeecode']."'";
                    $params_CheckPoint = array();
                    $query_CheckPoint = sqlsrv_query($conn, $sql_CheckPoint, $params_CheckPoint);
                    $result_CheckPoint = sqlsrv_fetch_array($query_CheckPoint, SQLSRV_FETCH_ASSOC);

            

                    //	ความเร็วเกินกำหนด
                    if ($result_CheckPoint['TENKOGPSSPEEDOVERAMOUNT'] == '' || $result_CheckPoint['TENKOGPSSPEEDOVERAMOUNT'] == NULL || $result_CheckPoint['TENKOGPSSPEEDOVERAMOUNT'] == '-') {
                        $speedoverpoint = '100';
                    }else {
                        $speedoverpoint = $result_CheckPoint['TENKOGPSSPEEDOVERAMOUNT'];
                    }
                    
                    // 	เบรคกระทันหัน
                    if ($result_CheckPoint['TENKOGPSBRAKEAMOUNT'] == '' || $result_CheckPoint['TENKOGPSBRAKEAMOUNT'] == NULL || $result_CheckPoint['TENKOGPSSPEEDOVERAMOUNT'] == '-') {
                        $gpsbrakepoint = '100';
                    }else {
                        $gpsbrakepoint = $result_CheckPoint['TENKOGPSBRAKEAMOUNT'];
                    }
                    
                    // รอบเครื่องเกินกำหนด
                    if ($result_CheckPoint['TENKOGPSSPEEDMACHINEAMOUNT'] == '' || $result_CheckPoint['TENKOGPSSPEEDMACHINEAMOUNT'] == NULL || $result_CheckPoint['TENKOGPSSPEEDOVERAMOUNT'] == '-') {
                        $speedmechinepoint = '100';
                    }else {
                        $speedmechinepoint = $result_CheckPoint['TENKOGPSSPEEDMACHINEAMOUNT'];
                    }
                    
                    //	วิ่งนอกเส้นทาง
                    if ($result_CheckPoint['TENKOGPSOUTLINEAMOUNT'] == '' || $result_CheckPoint['TENKOGPSOUTLINEAMOUNT'] == NULL || $result_CheckPoint['TENKOGPSSPEEDOVERAMOUNT'] == '-') {
                        $outlinepoint = '100';
                    }else {
                        $outlinepoint = $result_CheckPoint['TENKOGPSOUTLINEAMOUNT'];
                    }
                    
                    //	ขับรถต่อเนื่อง 4 ชม.
                    if ($result_CheckPoint['TENKOGPSCONTINUOUSAMOUNT'] == '' || $result_CheckPoint['TENKOGPSCONTINUOUSAMOUNT'] == NULL || $result_CheckPoint['TENKOGPSSPEEDOVERAMOUNT'] == '-') {
                        $continuepoint = '100';
                    }else {
                        $continuepoint = $result_CheckPoint['TENKOGPSCONTINUOUSAMOUNT'];
                    }
                    

                    // ถ้าทำผิดหัก ครั้งละ 2 คะแนน
                    $maxpoint = 100;
                    $sumpoint = ($speedoverpoint+$gpsbrakepoint+$speedmechinepoint+$outlinepoint+$continuepoint)*2;

                    if($sumpoint == '1000'){
                        $allpoint = 'ไม่มีผลคะแนน';
                    }else {
                        $allpoint = ($maxpoint)-($sumpoint);
                    }

                    

                    if ($allpoint == '100') {
                        $grade = 'A';
                    }else if(($allpoint >= '80') && ($allpoint <= '99')){
                        $grade = 'B';
                    }else if(($allpoint >= '60') && ($allpoint <= '79')){
                        $grade = 'C';
                    }else if(($allpoint >= '40') && ($allpoint <= '59')){
                        $grade = 'D';
                    }else if(($allpoint >= '0') && ($allpoint <= '39')){
                        $grade = 'E';
                    }else {
                        $grade = 'ไม่มีผลการประเมิน';
                    }
                ?>
                <tr>
                    <input type="text" name="txt_gradeemp2" id="txt_gradeemp2" value="<?= $grade ?>" style="display:none">
                    <input type="text" name="txt_pointemp2" id="txt_pointemp2" value="<?= $allpoint ?>" style="display:none">
                    <!-- <td colspan = "4" style="border: 1px solid black;border-collapse: collapse;background-color: #c9c9c9;text-align: center;padding: 5px"><?=$grade?></td>
                    <td colspan = "4" style="border: 1px solid black;border-collapse: collapse;background-color: #c9c9c9;text-align: center;padding: 5px"><?=$allpoint?></td> -->
                </tr>
            </div>
        
    <?php
}
if ($_POST['txt_flg'] == "update_tenkogpsGradePoint") {
  ?>

  <?php

  $sql_updateGradePoint = "{call megEdittenkogps_v2(?,?,?,?,?)}";
  $params_updateGradePoint = array(
  array('update_tenkogpsGradePoint', SQLSRV_PARAM_IN),
  array($_POST['grade'], SQLSRV_PARAM_IN),
  array($_POST['point'], SQLSRV_PARAM_IN),
  array($_POST['tenkomasterid'], SQLSRV_PARAM_IN),
  array($_POST['tenkomasterdrivercode'], SQLSRV_PARAM_IN)
  );

  $query_updateGradePoint = sqlsrv_query($conn, $sql_updateGradePoint, $params_updateGradePoint);
  $result_updateGradePoint = sqlsrv_fetch_array($query_updateGradePoint, SQLSRV_FETCH_ASSOC);
  ?>

  <?php
}
// select_tenko2emp2 ย้ายไป meg_data_tenkotransport
if ($_POST['txt_flg'] == "select_tenko2emp2") {
    $condition1 = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
    $sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEmployee = array(
        array('select_employeeehr2', SQLSRV_PARAM_IN),
        array($condition1, SQLSRV_PARAM_IN)
    );
    $query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
    $result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);
    
    $conditionPlain = " AND a.VEHICLETRANSPORTPLANID = '" . $_POST['vehicletransportplanid'] . "'";
    $sql_sePlain = "{call megVehicletransportplan_v2(?,?)}";
    $params_sePlain = array(
        array('select_vehicletransportplan', SQLSRV_PARAM_IN),
        array($conditionPlain, SQLSRV_PARAM_IN)
    );
    $query_sePlain = sqlsrv_query($conn, $sql_sePlain, $params_sePlain);
    $result_sePlain = sqlsrv_fetch_array($query_sePlain, SQLSRV_FETCH_ASSOC);


    $sql_checkSexT = "SELECT SexT AS 'SexT' FROM EMPLOYEEEHR2 WHERE PersonCode ='".$result_sePlain['EMPLOYEENAME2']."'";
    $params_checkSexT = array();
    $query_checkSexT = sqlsrv_query($conn, $sql_checkSexT, $params_checkSexT);
    $result_checkSexT = sqlsrv_fetch_array($query_checkSexT, SQLSRV_FETCH_ASSOC);

    if ($result_checkSexT['SexT'] == 'หญิง') {
        $sex = 'นางสาว';
    }else{
        $sex = 'นาย';
    }

    $conditionTenkomaster_temp = " AND VEHICLETRANSPORTPLANID = '" . $_POST['vehicletransportplanid'] . "'";
    $sql_seTenkomaster_temp = "{call megVehicletransportplan_v2(?,?,?,?)}";
    $params_seTenkomaster_temp = array(
        array('select_vehicletransporttenko', SQLSRV_PARAM_IN),
        array($conditionTenkomaster_temp, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seTenkomaster_temp = sqlsrv_query($conn, $sql_seTenkomaster_temp, $params_seTenkomaster_temp);
    $result_seTenkomaster_temp = sqlsrv_fetch_array($query_seTenkomaster_temp, SQLSRV_FETCH_ASSOC);

    $conditionTenkomaster = " AND a.TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "'";
    $sql_seTenkomaster = "{call megEdittenkomaster_v2(?,?)}";
    $params_seTenkomaster = array(
        array('select_tenkomaster', SQLSRV_PARAM_IN),
        array($conditionTenkomaster, SQLSRV_PARAM_IN)
    );
    $query_seTenkomaster = sqlsrv_query($conn, $sql_seTenkomaster, $params_seTenkomaster);
    $result_seTenkomaster = sqlsrv_fetch_array($query_seTenkomaster, SQLSRV_FETCH_ASSOC);
    ?>

        <div class="panel-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="active"><a href="#day1" data-toggle="tab"><?= $result_seTenkomaster['DATEINPUT_F1'] ?></a></li>
                <?php
                // บริษัท RRC tenko ระหว่างทางสูงสุดได้ 4 วัน
                if ($result_sePlain['COMPANYCODE'] == 'RRC') {
                ?>  
                    <li><a href="#day2" data-toggle="tab"><?= $result_seTenkomaster['DATEINPUT_F2'] ?></a></li>
                    <li><a href="#day3" data-toggle="tab"><?= $result_seTenkomaster['DATEINPUT_F3'] ?></a></li>
                    <li><a href="#day4" data-toggle="tab"><?= $result_seTenkomaster['DATEINPUT_F4'] ?></a></li>
                </li>
                    <?php
                } else {
                    if ($result_sePlain['CUSTOMERCODE'] == 'SKB' || $result_sePlain['CUSTOMERCODE'] == 'TTT' 
                    || $result_sePlain['CUSTOMERCODE'] == 'GMT' || $result_sePlain['CUSTOMERCODE'] == 'TTAST' 
                    || $result_sePlain['CUSTOMERCODE'] == 'TTASTCS' || $result_sePlain['CUSTOMERCODE'] == 'TTTCSTC') {
                    ?>
                    <li><a href="#day2" data-toggle="tab"><?= $result_seTenkomaster['DATEINPUT_F2'] ?></a></li>
                    <li><a href="#day3" data-toggle="tab"><?= $result_seTenkomaster['DATEINPUT_F3'] ?></a></li>
                    <li><a href="#day4" data-toggle="tab"><?= $result_seTenkomaster['DATEINPUT_F4'] ?></a></li>
                    <li><a href="#day5" data-toggle="tab"><?= $result_seTenkomaster['DATEINPUT_F5'] ?></a></li>
                    <?php
                    }
                }
                ?>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane fade in active" id="day1">
                    <?php
                    $conditionTenkotransport11 = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_POST['employeecode2'] . "' ";
                    $conditionTenkotransport12 = " AND CONVERT(DATE,TENKOTRANSPORTDATE) = CONVERT(DATE,'" . $result_seTenkomaster['DATEINPUT_F1'] . "',103)";
                    $sql_seTenkotransport1 = "{call megEdittenkotransport_v2(?,?,?)}";
                    $params_seTenkotransport1 = array(
                        array('select_tenkotransport', SQLSRV_PARAM_IN),
                        array($conditionTenkotransport11, SQLSRV_PARAM_IN),
                        array($conditionTenkotransport12, SQLSRV_PARAM_IN)
                    );
                    $query_seTenkotransport1 = sqlsrv_query($conn, $sql_seTenkotransport1, $params_seTenkotransport1);
                    $result_seTenkotransport1 = sqlsrv_fetch_array($query_seTenkotransport1, SQLSRV_FETCH_ASSOC);


                    $rs1d1 = ($result_seTenkotransport1['TENKOLOADRESTCHECK'] == '1') ? "checked" : "";
                    $rs2d1 = ($result_seTenkotransport1['TENKOBODYSLEEPYCHECK'] == '1') ? "checked" : "";
                    $rs3d1 = ($result_seTenkotransport1['TENKOCARNEWCHECK'] == '1') ? "checked" : "";
                    $rs4d1 = ($result_seTenkotransport1['TENKOTRAILERCHECK'] == '1') ? "checked" : "";
                    $rs5d1 = ($result_seTenkotransport1['TENKOROADCHECK'] == '1') ? "checked" : "";
                    $rs6d1 = ($result_seTenkotransport1['TENKOAIRCHECK'] == '1') ? "checked" : "";
                    $rs7d1 = ($result_seTenkotransport1['TENKOSLEEPYCHECK'] == '1') ? "checked" : "";
                    ?>
                    <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                        <thead>
                            <tr>

                               
                                <!-- Commit_Emp2Day1 -->
                                <th colspan="6" ><input type="button" onclick="commit_2('<?= $result_seTenkomaster_temp['TENKOMASTERID'] ?>','<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>', '<?= $result_seEmployee['nameT'] ?>')"   class="btn btn-success" value="Commit2_Day1"> <font style="color: green">พนักงานขับรถ : <?= $sex?> <?= $result_sePlain['EMPLOYEENAME2'] ?></font></th>

                                <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะก่อนเริ่มงาน</th>
                                <th style="text-align: center;"><?= $result_seTenkotransport1["CREATEBY"] ?></th>
                                <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะปฎิบัติงาน</th>
                                <th style="text-align: center;"><?= $result_seEmployee["nameT"] ?></th>
                            </tr>
                            <tr>

                                <th colspan="12">เจ้าหน้าที่โทรไปไม่พบสิ่งผิดปกติ : <font style="color: red">0</font>  | พนักงานขับรถโทรมาไม่พบสิ่งผิดปกติ : <font style="color: red">1</font> | พบสิ่งผิดปกติ : <font style="color: red">x</font></th>
                            </tr>
                            <tr>

                                <th rowspan="4" style="text-align: center;">ข้อ</th>
                                <th rowspan="4" style="text-align: center;">หัวข้อ</th>
                                <th rowspan="4" style="text-align: center;">ช่องตรวจ</th>
                                <th rowspan="4" style="text-align: center;">เกณฑ์การตัดสิน</th>
                                <th rowspan="2" style="text-align: center;"><p>โทรช่วง </p>
                                    <p>00:01 - 23:59</p></th>
                                <th colspan="6" style="text-align: center">Night Call Check</th>
                                <th rowspan="4"style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">รายละเอียดการแนะนำของเจ้าหน้าที่</th>
                            </tr>
                            <tr>

                                <th style="text-align: center;">ครั้งที่ 1</th>
                                <th style="text-align: center;">ครั้งที่ 2</th>
                                <th style="text-align: center;">ครั้งที่ 3</th>
                                <th style="text-align: center;">ครั้งที่ 4</th>
                                <th style="text-align: center;">ครั้งที่ 5</th>
                                <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">ครั้งที่ 6</th>
                            </tr>
                            <tr>

                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME0', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control timeen" id="txt_time0" name="txt_time0" value="<?= $result_seTenkotransport1['TENKOTIME0'] ?>"></th>
                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME1', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control timeen" id="txt_time1" name="txt_time1" value="<?= $result_seTenkotransport1['TENKOTIME1'] ?>"></th>
                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME2', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control timeen" id="txt_time2" name="txt_time2" value="<?= $result_seTenkotransport1['TENKOTIME2'] ?>"></th>
                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME3', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control timeen" id="txt_time3" name="txt_time3" value="<?= $result_seTenkotransport1['TENKOTIME3'] ?>"></th>
                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME4', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control timeen" id="txt_time4" name="txt_time4" value="<?= $result_seTenkotransport1['TENKOTIME4'] ?>"></th>
                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME5', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control timeen" id="txt_time5" name="txt_time5" value="<?= $result_seTenkotransport1['TENKOTIME5'] ?>"></th>
                                <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME6', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control timeen" id="txt_time6" name="txt_time6" value="<?= $result_seTenkotransport1['TENKOTIME6'] ?>"></th>
                            </tr>
                            <tr>

                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;">ผล</th>
                                <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">ผล</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center">1</td>
                                <td>เส้นทางที่กำหนด - จุดพัก</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs1d1 ?> onchange="edit_check1d1('TENKOLOADRESTCHECK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" style="transform: scale(2)" id="chk_1d1" name="chk_1d1" /></td>
                                <td>เส้นทาง จุดพักที่กำหนด</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT0', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT0" name="TXT_TENKOLOADRESTRESULT0" value="<?= $result_seTenkotransport1['TENKOLOADRESTRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT0', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT0" name="TXT_TENKOBODYSLEEPYRESULT0" value="<?= $result_seTenkotransport1['TENKOBODYSLEEPYRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT0', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT0" name="TXT_TENKOCARNEWRESULT0" value="<?= $result_seTenkotransport1['TENKOCARNEWRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT0', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT0" name="TXT_TENKOTRAILERRESULT0" value="<?= $result_seTenkotransport1['TENKOTRAILERRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT0', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOROADRESULT0" name="TXT_TENKOROADRESULT0" value="<?= $result_seTenkotransport1['TENKOROADRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT0', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT0" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport1['TENKOAIRRESULT0'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT0', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT0" name="TXT_TENKOSLEEPYRESULT0" value="<?= $result_seTenkotransport1['TENKOSLEEPYRESULT0'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOLOADRESTREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"  class="form-control" value="<?= $result_seTenkotransport1['TENKOLOADRESTREMARK'] ?>"></td>
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOLOADRESTREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"><?= $result_seTenkotransport1['TENKOLOADRESTREMARK'] ?></td> -->
                            </tr>
                            <tr>
                                <td style="text-align: center">2</td>
                                <td>ตรวจร่างกาย - อาการง่วง</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs2d1 ?> onchange="edit_check2d1('TENKOBODYSLEEPYCHECK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" style="transform: scale(2)"  id="chk_2d1" name="chk_2d1"/></td>
                                <td>วิธีการพูดคุยต้องร่าเริง</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT1', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT1" name="TXT_TENKOLOADRESTRESULT1" value="<?= $result_seTenkotransport1['TENKOLOADRESTRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT1', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT1" name="TXT_TENKOBODYSLEEPYRESULT1" value="<?= $result_seTenkotransport1['TENKOBODYSLEEPYRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT1', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT1" name="TXT_TENKOCARNEWRESULT1" value="<?= $result_seTenkotransport1['TENKOCARNEWRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT1', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT1" name="TXT_TENKOTRAILERRESULT1" value="<?= $result_seTenkotransport1['TENKOTRAILERRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT1', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOROADRESULT1" name="TXT_TENKOROADRESULT1" value="<?= $result_seTenkotransport1['TENKOROADRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT1', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT1" name="TXT_TENKOAIRRESULT1" value="<?= $result_seTenkotransport1['TENKOAIRRESULT1'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT1', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT1" name="TXT_TENKOSLEEPYRESULT1" value="<?= $result_seTenkotransport1['TENKOSLEEPYRESULT1'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOBODYSLEEPYREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"  class="form-control" value="<?= $result_seTenkotransport1['TENKOBODYSLEEPYREMARK'] ?>"></td>
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOBODYSLEEPYREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"><?= $result_seTenkotransport1['TENKOBODYSLEEPYREMARK'] ?></td> -->
                            </tr>
                            <tr>
                                <td style="text-align: center">3</td>
                                <td>ตรวจรถใหม่ (เฉพาะหยุดรถ)</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs3d1 ?> onchange="edit_check3d1('TENKOCARNEWCHECK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" style="transform: scale(2)"  id="chk_3d1" name="chk_3d1"/></td>
                                <td>มีการรายงานเกี่ยวกับรถใหม่ว่ามีสิ่งผิดปกติหรือไม่</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT2', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT2" name="TXT_TENKOLOADRESTRESULT2" value="<?= $result_seTenkotransport1['TENKOLOADRESTRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT2', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT2" name="TXT_TENKOBODYSLEEPYRESULT2" value="<?= $result_seTenkotransport1['TENKOBODYSLEEPYRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT2', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT2" name="TXT_TENKOCARNEWRESULT2" value="<?= $result_seTenkotransport1['TENKOCARNEWRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT2', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT2" name="TXT_TENKOTRAILERRESULT2" value="<?= $result_seTenkotransport1['TENKOTRAILERRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT2', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOROADRESULT2" name="TXT_TENKOROADRESULT2" value="<?= $result_seTenkotransport1['TENKOROADRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT2', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT2" name="TXT_TENKOAIRRESULT2" value="<?= $result_seTenkotransport1['TENKOAIRRESULT2'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT2', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT2" name="TXT_TENKOSLEEPYRESULT2" value="<?= $result_seTenkotransport1['TENKOSLEEPYRESULT2'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOCARNEWREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"  class="form-control" value="<?= $result_seTenkotransport1['TENKOCARNEWREMARK'] ?>"></td>
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOCARNEWREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"><?= $result_seTenkotransport1['TENKOCARNEWREMARK'] ?></td> -->
                            </tr>
                            <tr>
                                <td style="text-align: center">4</td>
                                <td>ตรวจเทรลเลอร์</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs4d1 ?> onchange="edit_check4d1('TENKOTRAILERCHECK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" style="transform: scale(2)"  id="chk_4d1" name="chk_4d1"/></td>
                                <td>ระหว่างวิ่งงานไม่มีสิ่งผิดปกติ</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT3', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT3" name="TXT_TENKOLOADRESTRESULT3" value="<?= $result_seTenkotransport1['TENKOLOADRESTRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT3', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT3" name="TXT_TENKOBODYSLEEPYRESULT3" value="<?= $result_seTenkotransport1['TENKOBODYSLEEPYRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT3', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT3" name="TXT_TENKOCARNEWRESULT3" value="<?= $result_seTenkotransport1['TENKOCARNEWRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT3', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT3" name="TXT_TENKOTRAILERRESULT3" value="<?= $result_seTenkotransport1['TENKOTRAILERRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT3', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOROADRESULT3" name="TXT_TENKOROADRESULT3" value="<?= $result_seTenkotransport1['TENKOROADRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT3', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT3" name="TXT_TENKOAIRRESULT3" value="<?= $result_seTenkotransport1['TENKOAIRRESULT3'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT3', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT3" name="TXT_TENKOSLEEPYRESULT3" value="<?= $result_seTenkotransport1['TENKOSLEEPYRESULT3'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOTRAILERREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"  class="form-control" value="<?= $result_seTenkotransport1['TENKOTRAILERREMARK'] ?>"></td>
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOTRAILERREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"><?= $result_seTenkotransport1['TENKOTRAILERREMARK'] ?></td> -->
                            </tr>
                            <tr>
                                <td style="text-align: center">5</td>
                                <td>ตรวจสภาพถนน</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs5d1 ?> onchange="edit_check5d1('TENKOROADCHECK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" style="transform: scale(2)"  id="chk_5d1" name="chk_5d1"/></td>
                                <td>รายงานสภาพถนน</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT4', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT4" name="TXT_TENKOLOADRESTRESULT4" value="<?= $result_seTenkotransport1['TENKOLOADRESTRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT4', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT4" name="TXT_TENKOBODYSLEEPYRESULT4" value="<?= $result_seTenkotransport1['TENKOBODYSLEEPYRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT4', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT4" name="TXT_TENKOCARNEWRESULT4" value="<?= $result_seTenkotransport1['TENKOCARNEWRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT4', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT4" name="TXT_TENKOTRAILERRESULT4" value="<?= $result_seTenkotransport1['TENKOTRAILERRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT4', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOROADRESULT4" name="TXT_TENKOROADRESULT4" value="<?= $result_seTenkotransport1['TENKOROADRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT4', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT4" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport1['TENKOAIRRESULT4'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT4', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT4" name="TXT_TENKOSLEEPYRESULT4" value="<?= $result_seTenkotransport1['TENKOSLEEPYRESULT4'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOROADREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"  class="form-control" value="<?= $result_seTenkotransport1['TENKOROADREMARK'] ?>"></td>
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOROADREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"><?= $result_seTenkotransport1['TENKOROADREMARK'] ?></td> -->
                            </tr>
                            <tr>
                                <td style="text-align: center">6</td>
                                <td>ตรวจสภาพอากาศ (ใช้ที่ปัดน้ำฝนระดับ 3 ให้หยุดรถ)</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs6d1 ?> onchange="edit_check6d1('TENKOAIRCHECK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" style="transform: scale(2)"  id="chk_6d1" name="chk_6d1"/></td>
                                <td>รายงานสภาพอากาศ1</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT5', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT5" name="TXT_TENKOLOADRESTRESULT5" value="<?= $result_seTenkotransport1['TENKOLOADRESTRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT5', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT5" name="TXT_TENKOBODYSLEEPYRESULT5" value="<?= $result_seTenkotransport1['TENKOBODYSLEEPYRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT5', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT5" name="TXT_TENKOCARNEWRESULT5" value="<?= $result_seTenkotransport1['TENKOCARNEWRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT5', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT5" name="TXT_TENKOTRAILERRESULT5" value="<?= $result_seTenkotransport1['TENKOTRAILERRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT5', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOROADRESULT5" name="TXT_TENKOROADRESULT5" value="<?= $result_seTenkotransport1['TENKOROADRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT5', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT5" name="TXT_TENKOAIRRESULT5" value="<?= $result_seTenkotransport1['TENKOAIRRESULT5'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT5', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT5" name="TXT_TENKOSLEEPYRESULT5" value="<?= $result_seTenkotransport1['TENKOSLEEPYRESULT5'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOAIRREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"  class="form-control" value="<?= $result_seTenkotransport1['TENKOAIRREMARK'] ?>"></td>
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOAIRREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"><?= $result_seTenkotransport1['TENKOAIRREMARK'] ?></td> -->
                            </tr>
                            <tr>
                                <td style="text-align: center">7</td>
                                <td>ตรวจสอบอาการง่วงและย้ำให้ระมัดระวัง</td>
                                <td style="text-align: center"><input type="checkbox" <?= $rs7d1 ?> onchange="edit_check7d1('TENKOSLEEPYCHECK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" style="transform: scale(2)" id="chk_7d1" name="chk_7d1" /></td>
                                <td>สภาพที่สามารถวิ่งงานต่อได้</td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT6', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT6" name="TXT_TENKOLOADRESTRESULT6" value="<?= $result_seTenkotransport1['TENKOLOADRESTRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT6', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT6" name="TXT_TENKOBODYSLEEPYRESULT6" value="<?= $result_seTenkotransport1['TENKOBODYSLEEPYRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT6', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT6" name="TXT_TENKOCARNEWRESULT6" value="<?= $result_seTenkotransport1['TENKOCARNEWRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT6', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT6" name="TXT_TENKOTRAILERRESULT6" value="<?= $result_seTenkotransport1['TENKOTRAILERRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT6', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOROADRESULT6" name="TXT_TENKOROADRESULT6" value="<?= $result_seTenkotransport1['TENKOROADRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT6', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT6" name="TXT_TENKOAIRRESULT6" value="<?= $result_seTenkotransport1['TENKOAIRRESULT6'] ?>"></td>
                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT6', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT6" name="TXT_TENKOSLEEPYRESULT6" value="<?= $result_seTenkotransport1['TENKOSLEEPYRESULT6'] ?>"></td>
                                <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOSLEEPYREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"  class="form-control" value="<?= $result_seTenkotransport1['TENKOSLEEPYREMARK'] ?>"></td>
                                <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOSLEEPYREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"><?= $result_seTenkotransport1['TENKOSLEEPYREMARK'] ?></td> -->
                            </tr>
                        </tbody>
                    </table>

                </div>
                    <div class="tab-pane" id="day2">
                        <?php
                        $conditionTenkotransport21 = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_POST['employeecode2'] . "' ";
                        $conditionTenkotransport22 = " AND CONVERT(DATE,TENKOTRANSPORTDATE) = CONVERT(DATE,'" . $result_seTenkomaster['DATEINPUT_F2'] . "',103)";
                        $sql_seTenkotransport2 = "{call megEdittenkotransport_v2(?,?,?)}";
                        $params_seTenkotransport2 = array(
                            array('select_tenkotransport', SQLSRV_PARAM_IN),
                            array($conditionTenkotransport21, SQLSRV_PARAM_IN),
                            array($conditionTenkotransport22, SQLSRV_PARAM_IN)
                        );
                        $query_seTenkotransport2 = sqlsrv_query($conn, $sql_seTenkotransport2, $params_seTenkotransport2);
                        $result_seTenkotransport2 = sqlsrv_fetch_array($query_seTenkotransport2, SQLSRV_FETCH_ASSOC);

                        $rs1d2 = ($result_seTenkotransport2['TENKOLOADRESTCHECK'] == '1') ? "checked" : "";
                        $rs2d2 = ($result_seTenkotransport2['TENKOBODYSLEEPYCHECK'] == '1') ? "checked" : "";
                        $rs3d2 = ($result_seTenkotransport2['TENKOCARNEWCHECK'] == '1') ? "checked" : "";
                        $rs4d2 = ($result_seTenkotransport2['TENKOTRAILERCHECK'] == '1') ? "checked" : "";
                        $rs5d2 = ($result_seTenkotransport2['TENKOROADCHECK'] == '1') ? "checked" : "";
                        $rs6d2 = ($result_seTenkotransport2['TENKOAIRCHECK'] == '1') ? "checked" : "";
                        $rs7d2 = ($result_seTenkotransport2['TENKOSLEEPYCHECK'] == '1') ? "checked" : "";
                        ?>
                        <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                            <thead>
                                <tr>

                                    
                                    <!-- Commit_Emp2Day2 -->
                                    <th colspan="6" ><input type="button" onclick="commit_2('<?= $result_seTenkomaster_temp['TENKOMASTERID'] ?>','<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>', '<?= $result_seEmployee['nameT'] ?>')"   class="btn btn-success" value="Commit2_Day2"> <font style="color: green">พนักงานขับรถ : <?= $sex?> <?= $result_sePlain['EMPLOYEENAME2'] ?></font></th>

                                    <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะก่อนเริ่มงาน</th>
                                    <th style="text-align: center;"><?= $result_seTenkotransport1["CREATEBY"] ?></th>
                                    <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะปฎิบัติงาน</th>
                                    <th style="text-align: center;"><?= $result_seEmployee["nameT"] ?></th>
                                </tr>
                                <tr>

                                    <th colspan="12">เจ้าหน้าที่โทรไปไม่พบสิ่งผิดปกติ : <font style="color: red">0</font>  | พนักงานขับรถโทรมาไม่พบสิ่งผิดปกติ : <font style="color: red">1</font> | พบสิ่งผิดปกติ : <font style="color: red">x</font></th>
                                </tr>
                                <tr>

                                    <th rowspan="4" style="text-align: center;">ข้อ</th>
                                    <th rowspan="4" style="text-align: center;">หัวข้อ</th>
                                    <th rowspan="4" style="text-align: center;">ช่องตรวจ</th>
                                    <th rowspan="4" style="text-align: center;">เกณฑ์การตัดสิน</th>
                                    <th rowspan="2" style="text-align: center;"><p>โทรช่วง </p>
                                        <p>00:01 - 23:59</p></th>
                                    <th colspan="6" style="text-align: center">Night Call Check</th>
                                    <th rowspan="4"style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">รายละเอียดการแนะนำของเจ้าหน้าที่</th>
                                </tr>
                                <tr>

                                    <th style="text-align: center;">ครั้งที่ 1</th>
                                    <th style="text-align: center;">ครั้งที่ 2</th>
                                    <th style="text-align: center;">ครั้งที่ 3</th>
                                    <th style="text-align: center;">ครั้งที่ 4</th>
                                    <th style="text-align: center;">ครั้งที่ 5</th>
                                    <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">ครั้งที่ 6</th>
                                </tr>
                                <tr>

                                    <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME0', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control timeen" id="txt_time0" name="txt_time0" value="<?= $result_seTenkotransport2['TENKOTIME0'] ?>"></th>
                                    <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME1', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control timeen" id="txt_time1" name="txt_time1" value="<?= $result_seTenkotransport2['TENKOTIME1'] ?>"></th>
                                    <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME2', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control timeen" id="txt_time2" name="txt_time2" value="<?= $result_seTenkotransport2['TENKOTIME2'] ?>"></th>
                                    <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME3', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control timeen" id="txt_time3" name="txt_time3" value="<?= $result_seTenkotransport2['TENKOTIME3'] ?>"></th>
                                    <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME4', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control timeen" id="txt_time4" name="txt_time4" value="<?= $result_seTenkotransport2['TENKOTIME4'] ?>"></th>
                                    <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME5', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control timeen" id="txt_time5" name="txt_time5" value="<?= $result_seTenkotransport2['TENKOTIME5'] ?>"></th>
                                    <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME6', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control timeen" id="txt_time6" name="txt_time6" value="<?= $result_seTenkotransport2['TENKOTIME6'] ?>"></th>
                                </tr>
                                <tr>

                                    <th style="text-align: center;">ผล</th>
                                    <th style="text-align: center;">ผล</th>
                                    <th style="text-align: center;">ผล</th>
                                    <th style="text-align: center;">ผล</th>
                                    <th style="text-align: center;">ผล</th>
                                    <th style="text-align: center;">ผล</th>
                                    <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">ผล</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align: center">1</td>
                                    <td>เส้นทางที่กำหนด - จุดพัก</td>
                                    <td style="text-align: center"><input type="checkbox" <?= $rs1d2 ?> onchange="edit_check1d2('TENKOLOADRESTCHECK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" style="transform: scale(2)" id="chk_1d2" name="chk_1d2" /></td>
                                    <td>เส้นทาง จุดพักที่กำหนด</td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT0', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT0" name="TXT_TENKOLOADRESTRESULT0" value="<?= $result_seTenkotransport2['TENKOLOADRESTRESULT0'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT0', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT0" name="TXT_TENKOBODYSLEEPYRESULT0" value="<?= $result_seTenkotransport2['TENKOBODYSLEEPYRESULT0'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT0', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT0" name="TXT_TENKOCARNEWRESULT0" value="<?= $result_seTenkotransport2['TENKOCARNEWRESULT0'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT0', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT0" name="TXT_TENKOTRAILERRESULT0" value="<?= $result_seTenkotransport2['TENKOTRAILERRESULT0'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT0', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOROADRESULT0" name="TXT_TENKOROADRESULT0" value="<?= $result_seTenkotransport2['TENKOROADRESULT0'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT0', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT0" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport2['TENKOAIRRESULT0'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT0', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT0" name="TXT_TENKOSLEEPYRESULT0" value="<?= $result_seTenkotransport2['TENKOSLEEPYRESULT0'] ?>"></td>
                                    <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOLOADRESTREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"  class="form-control" value="<?= $result_seTenkotransport2['TENKOLOADRESTREMARK'] ?>"></td>
                                    
                                    <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOLOADRESTREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"><?= $result_seTenkotransport2['TENKOLOADRESTREMARK'] ?></td> -->
                                </tr>
                                <tr>
                                    <td style="text-align: center">2</td>
                                    <td>ตรวจร่างกาย - อาการง่วง</td>
                                    <td style="text-align: center"><input type="checkbox" <?= $rs2d2 ?> onchange="edit_check2d2('TENKOBODYSLEEPYCHECK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" style="transform: scale(2)"  id="chk_2d2" name="chk_2d2"/></td>
                                    <td>วิธีการพูดคุยต้องร่าเริง</td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT1', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT1" name="TXT_TENKOLOADRESTRESULT1" value="<?= $result_seTenkotransport2['TENKOLOADRESTRESULT1'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT1', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT1" name="TXT_TENKOBODYSLEEPYRESULT1" value="<?= $result_seTenkotransport2['TENKOBODYSLEEPYRESULT1'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT1', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT1" name="TXT_TENKOCARNEWRESULT1" value="<?= $result_seTenkotransport2['TENKOCARNEWRESULT1'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT1', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT1" name="TXT_TENKOTRAILERRESULT1" value="<?= $result_seTenkotransport2['TENKOTRAILERRESULT1'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT1', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOROADRESULT1" name="TXT_TENKOROADRESULT1" value="<?= $result_seTenkotransport2['TENKOROADRESULT1'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT1', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT1" name="TXT_TENKOAIRRESULT1" value="<?= $result_seTenkotransport2['TENKOAIRRESULT1'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT1', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT1" name="TXT_TENKOSLEEPYRESULT1" value="<?= $result_seTenkotransport2['TENKOSLEEPYRESULT1'] ?>"></td>
                                    <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOBODYSLEEPYREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"  class="form-control" value="<?= $result_seTenkotransport2['TENKOBODYSLEEPYREMARK'] ?>"></td>
                                    
                                    <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOBODYSLEEPYREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"><?= $result_seTenkotransport2['TENKOBODYSLEEPYREMARK'] ?></td> -->
                                </tr>
                                <tr>
                                    <td style="text-align: center">3</td>
                                    <td>ตรวจรถใหม่ (เฉพาะหยุดรถ)</td>
                                    <td style="text-align: center"><input type="checkbox" <?= $rs3d2 ?> onchange="edit_check3d2('TENKOCARNEWCHECK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" style="transform: scale(2)"  id="chk_3d2" name="chk_3d2"/></td>
                                    <td>มีการรายงานเกี่ยวกับรถใหม่ว่ามีสิ่งผิดปกติหรือไม่</td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT2', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT2" name="TXT_TENKOLOADRESTRESULT2" value="<?= $result_seTenkotransport2['TENKOLOADRESTRESULT2'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT2', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT2" name="TXT_TENKOBODYSLEEPYRESULT2" value="<?= $result_seTenkotransport2['TENKOBODYSLEEPYRESULT2'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT2', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT2" name="TXT_TENKOCARNEWRESULT2" value="<?= $result_seTenkotransport2['TENKOCARNEWRESULT2'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT2', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT2" name="TXT_TENKOTRAILERRESULT2" value="<?= $result_seTenkotransport2['TENKOTRAILERRESULT2'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT2', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOROADRESULT2" name="TXT_TENKOROADRESULT2" value="<?= $result_seTenkotransport2['TENKOROADRESULT2'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT2', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT2" name="TXT_TENKOAIRRESULT2" value="<?= $result_seTenkotransport2['TENKOAIRRESULT2'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT2', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT2" name="TXT_TENKOSLEEPYRESULT2" value="<?= $result_seTenkotransport2['TENKOSLEEPYRESULT2'] ?>"></td>
                                    <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOCARNEWREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"  class="form-control" value="<?= $result_seTenkotransport2['TENKOCARNEWREMARK'] ?>"></td>
                                    
                                    <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOCARNEWREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"><?= $result_seTenkotransport2['TENKOCARNEWREMARK'] ?></td> -->
                                </tr>
                                <tr>
                                    <td style="text-align: center">4</td>
                                    <td>ตรวจเทรลเลอร์</td>
                                    <td style="text-align: center"><input type="checkbox" <?= $rs4d2 ?> onchange="edit_check4d2('TENKOTRAILERCHECK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" style="transform: scale(2)"  id="chk_4d2" name="chk_4d2"/></td>
                                    <td>ระหว่างวิ่งงานไม่มีสิ่งผิดปกติ</td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT3', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT3" name="TXT_TENKOLOADRESTRESULT3" value="<?= $result_seTenkotransport2['TENKOLOADRESTRESULT3'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT3', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT3" name="TXT_TENKOBODYSLEEPYRESULT3" value="<?= $result_seTenkotransport2['TENKOBODYSLEEPYRESULT3'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT3', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT3" name="TXT_TENKOCARNEWRESULT3" value="<?= $result_seTenkotransport2['TENKOCARNEWRESULT3'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT3', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT3" name="TXT_TENKOTRAILERRESULT3" value="<?= $result_seTenkotransport2['TENKOTRAILERRESULT3'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT3', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOROADRESULT3" name="TXT_TENKOROADRESULT3" value="<?= $result_seTenkotransport2['TENKOROADRESULT3'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT3', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT3" name="TXT_TENKOAIRRESULT3" value="<?= $result_seTenkotransport2['TENKOAIRRESULT3'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT3', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT3" name="TXT_TENKOSLEEPYRESULT3" value="<?= $result_seTenkotransport2['TENKOSLEEPYRESULT3'] ?>"></td>
                                    <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOTRAILERREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"  class="form-control" value="<?= $result_seTenkotransport2['TENKOTRAILERREMARK'] ?>"></td>
                                    
                                    
                                    <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOTRAILERREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"><?= $result_seTenkotransport2['TENKOTRAILERREMARK'] ?></td> -->
                                </tr>
                                <tr>
                                    <td style="text-align: center">5</td>
                                    <td>ตรวจสภาพถนน</td>
                                    <td style="text-align: center"><input type="checkbox" <?= $rs5d2 ?> onchange="edit_check5d2('TENKOROADCHECK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" style="transform: scale(2)"  id="chk_5d2" name="chk_5d2"/></td>
                                    <td>รายงานสภาพถนน</td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT4', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT4" name="TXT_TENKOLOADRESTRESULT4" value="<?= $result_seTenkotransport2['TENKOLOADRESTRESULT4'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT4', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT4" name="TXT_TENKOBODYSLEEPYRESULT4" value="<?= $result_seTenkotransport2['TENKOBODYSLEEPYRESULT4'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT4', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT4" name="TXT_TENKOCARNEWRESULT4" value="<?= $result_seTenkotransport2['TENKOCARNEWRESULT4'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT4', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT4" name="TXT_TENKOTRAILERRESULT4" value="<?= $result_seTenkotransport2['TENKOTRAILERRESULT4'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT4', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOROADRESULT4" name="TXT_TENKOROADRESULT4" value="<?= $result_seTenkotransport2['TENKOROADRESULT4'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT4', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT4" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport2['TENKOAIRRESULT4'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT4', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT4" name="TXT_TENKOSLEEPYRESULT4" value="<?= $result_seTenkotransport2['TENKOSLEEPYRESULT4'] ?>"></td>
                                    <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOROADREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"  class="form-control" value="<?= $result_seTenkotransport2['TENKOROADREMARK'] ?>"></td>
                                    
                                    
                                    <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOROADREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"><?= $result_seTenkotransport2['TENKOROADREMARK'] ?></td> -->
                                </tr>
                                <tr>
                                    <td style="text-align: center">6</td>
                                    <td>ตรวจสภาพอากาศ (ใช้ที่ปัดน้ำฝนระดับ 3 ให้หยุดรถ)</td>
                                    <td style="text-align: center"><input type="checkbox" <?= $rs6d2 ?> onchange="edit_check6d2('TENKOAIRCHECK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" style="transform: scale(2)"  id="chk_6d2" name="chk_6d2"/></td>
                                    <td>รายงานสภาพอากาศ2</td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT5', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT5" name="TXT_TENKOLOADRESTRESULT5" value="<?= $result_seTenkotransport2['TENKOLOADRESTRESULT5'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT5', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT5" name="TXT_TENKOBODYSLEEPYRESULT5" value="<?= $result_seTenkotransport2['TENKOBODYSLEEPYRESULT5'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT5', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT5" name="TXT_TENKOCARNEWRESULT5" value="<?= $result_seTenkotransport2['TENKOCARNEWRESULT5'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT5', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT5" name="TXT_TENKOTRAILERRESULT5" value="<?= $result_seTenkotransport2['TENKOTRAILERRESULT5'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT5', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOROADRESULT5" name="TXT_TENKOROADRESULT5" value="<?= $result_seTenkotransport2['TENKOROADRESULT5'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT5', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT5" name="TXT_TENKOAIRRESULT5" value="<?= $result_seTenkotransport2['TENKOAIRRESULT5'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT5', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT5" name="TXT_TENKOSLEEPYRESULT5" value="<?= $result_seTenkotransport2['TENKOSLEEPYRESULT5'] ?>"></td>
                                    <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOAIRREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"  class="form-control" value="<?= $result_seTenkotransport2['TENKOAIRREMARK'] ?>"></td>
                                    
                                    <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOAIRREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"><?= $result_seTenkotransport2['TENKOAIRREMARK'] ?></td> -->
                                </tr>
                                <tr>
                                    <td style="text-align: center">7</td>
                                    <td>ตรวจสอบอาการง่วงและย้ำให้ระมัดระวัง</td>
                                    <td style="text-align: center"><input type="checkbox" <?= $rs7d2 ?> onchange="edit_check7d2('TENKOSLEEPYCHECK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" style="transform: scale(2)" id="chk_7d2" name="chk_7d2" /></td>
                                    <td>สภาพที่สามารถวิ่งงานต่อได้</td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT6', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT6" name="TXT_TENKOLOADRESTRESULT6" value="<?= $result_seTenkotransport2['TENKOLOADRESTRESULT6'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT6', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT6" name="TXT_TENKOBODYSLEEPYRESULT6" value="<?= $result_seTenkotransport2['TENKOBODYSLEEPYRESULT6'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT6', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT6" name="TXT_TENKOCARNEWRESULT6" value="<?= $result_seTenkotransport2['TENKOCARNEWRESULT6'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT6', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT6" name="TXT_TENKOTRAILERRESULT6" value="<?= $result_seTenkotransport2['TENKOTRAILERRESULT6'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT6', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOROADRESULT6" name="TXT_TENKOROADRESULT6" value="<?= $result_seTenkotransport2['TENKOROADRESULT6'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT6', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT6" name="TXT_TENKOAIRRESULT6" value="<?= $result_seTenkotransport2['TENKOAIRRESULT6'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT6', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT6" name="TXT_TENKOSLEEPYRESULT6" value="<?= $result_seTenkotransport2['TENKOSLEEPYRESULT6'] ?>"></td>
                                    <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOSLEEPYREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"  class="form-control" value="<?= $result_seTenkotransport2['TENKOSLEEPYREMARK'] ?>"></td>
                                    
                                    <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOSLEEPYREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"><?= $result_seTenkotransport2['TENKOSLEEPYREMARK'] ?></td> -->
                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <div class="tab-pane" id="day3">
                        <?php
                        $conditionTenkotransport31 = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_POST['employeecode2'] . "' ";
                        $conditionTenkotransport32 = " AND CONVERT(DATE,TENKOTRANSPORTDATE) = CONVERT(DATE,'" . $result_seTenkomaster['DATEINPUT_F3'] . "',103)";
                        $sql_seTenkotransport3 = "{call megEdittenkotransport_v2(?,?,?)}";
                        $params_seTenkotransport3 = array(
                            array('select_tenkotransport', SQLSRV_PARAM_IN),
                            array($conditionTenkotransport31, SQLSRV_PARAM_IN),
                            array($conditionTenkotransport32, SQLSRV_PARAM_IN)
                        );
                        $query_seTenkotransport3 = sqlsrv_query($conn, $sql_seTenkotransport3, $params_seTenkotransport3);
                        $result_seTenkotransport3 = sqlsrv_fetch_array($query_seTenkotransport3, SQLSRV_FETCH_ASSOC);

                        $rs1d3 = ($result_seTenkotransport3['TENKOLOADRESTCHECK'] == '1') ? "checked" : "";
                        $rs2d3 = ($result_seTenkotransport3['TENKOBODYSLEEPYCHECK'] == '1') ? "checked" : "";
                        $rs3d3 = ($result_seTenkotransport3['TENKOCARNEWCHECK'] == '1') ? "checked" : "";
                        $rs4d3 = ($result_seTenkotransport3['TENKOTRAILERCHECK'] == '1') ? "checked" : "";
                        $rs5d3 = ($result_seTenkotransport3['TENKOROADCHECK'] == '1') ? "checked" : "";
                        $rs6d3 = ($result_seTenkotransport3['TENKOAIRCHECK'] == '1') ? "checked" : "";
                        $rs7d3 = ($result_seTenkotransport3['TENKOSLEEPYCHECK'] == '1') ? "checked" : "";
                        ?>
                        <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                            <thead>
                                <tr>

                                    
                                    <!-- Commit_Emp2Day3 -->
                                    <th colspan="6" ><input type="button" onclick="commit_2('<?= $result_seTenkomaster_temp['TENKOMASTERID'] ?>','<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>', '<?= $result_seEmployee['nameT'] ?>')"   class="btn btn-success" value="Commit2_Day3"> <font style="color: green">พนักงานขับรถ : <?= $sex?> <?= $result_sePlain['EMPLOYEENAME2'] ?></font></th>

                                    <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะก่อนเริ่มงาน</th>
                                    <th style="text-align: center;"><?= $result_seTenkotransport1["CREATEBY"] ?></th>
                                    <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะปฎิบัติงาน</th>
                                    <th style="text-align: center;"><?= $result_seEmployee["nameT"] ?></th>
                                </tr>
                                <tr>

                                    <th colspan="12">เจ้าหน้าที่โทรไปไม่พบสิ่งผิดปกติ : <font style="color: red">0</font>  | พนักงานขับรถโทรมาไม่พบสิ่งผิดปกติ : <font style="color: red">1</font> | พบสิ่งผิดปกติ : <font style="color: red">x</font></th>
                                </tr>
                                <tr>

                                    <th rowspan="4" style="text-align: center;">ข้อ</th>
                                    <th rowspan="4" style="text-align: center;">หัวข้อ</th>
                                    <th rowspan="4" style="text-align: center;">ช่องตรวจ</th>
                                    <th rowspan="4" style="text-align: center;">เกณฑ์การตัดสิน</th>
                                    <th rowspan="2" style="text-align: center;"><p>โทรช่วง </p>
                                        <p>00:01 - 23:59</p></th>
                                    <th colspan="6" style="text-align: center">Night Call Check</th>
                                    <th rowspan="4"style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">รายละเอียดการแนะนำของเจ้าหน้าที่</th>
                                </tr>
                                <tr>

                                    <th style="text-align: center;">ครั้งที่ 1</th>
                                    <th style="text-align: center;">ครั้งที่ 2</th>
                                    <th style="text-align: center;">ครั้งที่ 3</th>
                                    <th style="text-align: center;">ครั้งที่ 4</th>
                                    <th style="text-align: center;">ครั้งที่ 5</th>
                                    <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">ครั้งที่ 6</th>
                                </tr>
                                <tr>

                                    <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME0', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control timeen" id="txt_time0" name="txt_time0" value="<?= $result_seTenkotransport3['TENKOTIME0'] ?>"></th>
                                    <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME1', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control timeen" id="txt_time1" name="txt_time1" value="<?= $result_seTenkotransport3['TENKOTIME1'] ?>"></th>
                                    <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME2', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control timeen" id="txt_time2" name="txt_time2" value="<?= $result_seTenkotransport3['TENKOTIME2'] ?>"></th>
                                    <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME3', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control timeen" id="txt_time3" name="txt_time3" value="<?= $result_seTenkotransport3['TENKOTIME3'] ?>"></th>
                                    <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME4', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control timeen" id="txt_time4" name="txt_time4" value="<?= $result_seTenkotransport3['TENKOTIME4'] ?>"></th>
                                    <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME5', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control timeen" id="txt_time5" name="txt_time5" value="<?= $result_seTenkotransport3['TENKOTIME5'] ?>"></th>
                                    <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME6', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control timeen" id="txt_time6" name="txt_time6" value="<?= $result_seTenkotransport3['TENKOTIME6'] ?>"></th>
                                </tr>
                                <tr>

                                    <th style="text-align: center;">ผล</th>
                                    <th style="text-align: center;">ผล</th>
                                    <th style="text-align: center;">ผล</th>
                                    <th style="text-align: center;">ผล</th>
                                    <th style="text-align: center;">ผล</th>
                                    <th style="text-align: center;">ผล</th>
                                    <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">ผล</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align: center">1</td>
                                    <td>เส้นทางที่กำหนด - จุดพัก</td>
                                    <td style="text-align: center"><input type="checkbox" <?= $rs1d3 ?> onchange="edit_check1d3('TENKOLOADRESTCHECK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" style="transform: scale(2)" id="chk_1d3" name="chk_1d3" /></td>
                                    <td>เส้นทาง จุดพักที่กำหนด</td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT0', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT0" name="TXT_TENKOLOADRESTRESULT0" value="<?= $result_seTenkotransport3['TENKOLOADRESTRESULT0'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT0', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT0" name="TXT_TENKOBODYSLEEPYRESULT0" value="<?= $result_seTenkotransport3['TENKOBODYSLEEPYRESULT0'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT0', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT0" name="TXT_TENKOCARNEWRESULT0" value="<?= $result_seTenkotransport3['TENKOCARNEWRESULT0'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT0', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT0" name="TXT_TENKOTRAILERRESULT0" value="<?= $result_seTenkotransport3['TENKOTRAILERRESULT0'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT0', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOROADRESULT0" name="TXT_TENKOROADRESULT0" value="<?= $result_seTenkotransport3['TENKOROADRESULT0'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT0', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT0" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport3['TENKOAIRRESULT0'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT0', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT0" name="TXT_TENKOSLEEPYRESULT0" value="<?= $result_seTenkotransport3['TENKOSLEEPYRESULT0'] ?>"></td>
                                    <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOLOADRESTREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"  class="form-control" value="<?= $result_seTenkotransport3['TENKOLOADRESTREMARK'] ?>"></td>
                                    
                                    <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOLOADRESTREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"><?= $result_seTenkotransport3['TENKOLOADRESTREMARK'] ?></td> -->
                                </tr>
                                <tr>
                                    <td style="text-align: center">2</td>
                                    <td>ตรวจร่างกาย - อาการง่วง</td>
                                    <td style="text-align: center"><input type="checkbox" <?= $rs2d3 ?> onchange="edit_check2d3('TENKOBODYSLEEPYCHECK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" style="transform: scale(2)"  id="chk_2d3" name="chk_2d3"/></td>
                                    <td>วิธีการพูดคุยต้องร่าเริง</td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT1', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT1" name="TXT_TENKOLOADRESTRESULT1" value="<?= $result_seTenkotransport3['TENKOLOADRESTRESULT1'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT1', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT1" name="TXT_TENKOBODYSLEEPYRESULT1" value="<?= $result_seTenkotransport3['TENKOBODYSLEEPYRESULT1'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT1', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT1" name="TXT_TENKOCARNEWRESULT1" value="<?= $result_seTenkotransport3['TENKOCARNEWRESULT1'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT1', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT1" name="TXT_TENKOTRAILERRESULT1" value="<?= $result_seTenkotransport3['TENKOTRAILERRESULT1'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT1', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOROADRESULT1" name="TXT_TENKOROADRESULT1" value="<?= $result_seTenkotransport3['TENKOROADRESULT1'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT1', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT1" name="TXT_TENKOAIRRESULT1" value="<?= $result_seTenkotransport3['TENKOAIRRESULT1'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT1', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT1" name="TXT_TENKOSLEEPYRESULT1" value="<?= $result_seTenkotransport3['TENKOSLEEPYRESULT1'] ?>"></td>
                                    <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOBODYSLEEPYREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"  class="form-control" value="<?= $result_seTenkotransport3['TENKOBODYSLEEPYREMARK'] ?>"></td>
                                    
                                    <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOBODYSLEEPYREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"><?= $result_seTenkotransport3['TENKOBODYSLEEPYREMARK'] ?></td> -->
                                </tr>
                                <tr>
                                    <td style="text-align: center">3</td>
                                    <td>ตรวจรถใหม่ (เฉพาะหยุดรถ)</td>
                                    <td style="text-align: center"><input type="checkbox" <?= $rs3d3 ?> onchange="edit_check3d3('TENKOCARNEWCHECK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" style="transform: scale(2)"  id="chk_3d3" name="chk_3d3"/></td>
                                    <td>มีการรายงานเกี่ยวกับรถใหม่ว่ามีสิ่งผิดปกติหรือไม่</td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT2', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT2" name="TXT_TENKOLOADRESTRESULT2" value="<?= $result_seTenkotransport3['TENKOLOADRESTRESULT2'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT2', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT2" name="TXT_TENKOBODYSLEEPYRESULT2" value="<?= $result_seTenkotransport3['TENKOBODYSLEEPYRESULT2'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT2', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT2" name="TXT_TENKOCARNEWRESULT2" value="<?= $result_seTenkotransport3['TENKOCARNEWRESULT2'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT2', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT2" name="TXT_TENKOTRAILERRESULT2" value="<?= $result_seTenkotransport3['TENKOTRAILERRESULT2'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT2', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOROADRESULT2" name="TXT_TENKOROADRESULT2" value="<?= $result_seTenkotransport3['TENKOROADRESULT2'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT2', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT2" name="TXT_TENKOAIRRESULT2" value="<?= $result_seTenkotransport3['TENKOAIRRESULT2'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT2', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT2" name="TXT_TENKOSLEEPYRESULT2" value="<?= $result_seTenkotransport3['TENKOSLEEPYRESULT2'] ?>"></td>
                                    <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOBODYSLEEPYREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"  class="form-control" value="<?= $result_seTenkotransport3['TENKOBODYSLEEPYREMARK'] ?>"></td>
                                    
                                    
                                    <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOCARNEWREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"><?= $result_seTenkotransport3['TENKOCARNEWREMARK'] ?></td> -->
                                </tr>
                                <tr>
                                    <td style="text-align: center">4</td>
                                    <td>ตรวจเทรลเลอร์</td>
                                    <td style="text-align: center"><input type="checkbox" <?= $rs4d3 ?> onchange="edit_check4d3('TENKOTRAILERCHECK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" style="transform: scale(2)"  id="chk_4d3" name="chk_4d3"/></td>
                                    <td>ระหว่างวิ่งงานไม่มีสิ่งผิดปกติ</td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT3', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT3" name="TXT_TENKOLOADRESTRESULT3" value="<?= $result_seTenkotransport3['TENKOLOADRESTRESULT3'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT3', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT3" name="TXT_TENKOBODYSLEEPYRESULT3" value="<?= $result_seTenkotransport3['TENKOBODYSLEEPYRESULT3'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT3', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT3" name="TXT_TENKOCARNEWRESULT3" value="<?= $result_seTenkotransport3['TENKOCARNEWRESULT3'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT3', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT3" name="TXT_TENKOTRAILERRESULT3" value="<?= $result_seTenkotransport3['TENKOTRAILERRESULT3'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT3', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOROADRESULT3" name="TXT_TENKOROADRESULT3" value="<?= $result_seTenkotransport3['TENKOROADRESULT3'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT3', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT3" name="TXT_TENKOAIRRESULT3" value="<?= $result_seTenkotransport3['TENKOAIRRESULT3'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT3', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT3" name="TXT_TENKOSLEEPYRESULT3" value="<?= $result_seTenkotransport3['TENKOSLEEPYRESULT3'] ?>"></td>
                                    <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOBODYSLEEPYREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"  class="form-control" value="<?= $result_seTenkotransport3['TENKOBODYSLEEPYREMARK'] ?>"></td>
                                    
                                    
                                    <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOTRAILERREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"><?= $result_seTenkotransport3['TENKOTRAILERREMARK'] ?></td> -->
                                </tr>
                                <tr>
                                    <td style="text-align: center">5</td>
                                    <td>ตรวจสภาพถนน</td>
                                    <td style="text-align: center"><input type="checkbox" <?= $rs5d3 ?> onchange="edit_check5d3('TENKOROADCHECK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" style="transform: scale(2)"  id="chk_5d3" name="chk_5d3"/></td>
                                    <td>รายงานสภาพถนน</td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT4', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT4" name="TXT_TENKOLOADRESTRESULT4" value="<?= $result_seTenkotransport3['TENKOLOADRESTRESULT4'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT4', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT4" name="TXT_TENKOBODYSLEEPYRESULT4" value="<?= $result_seTenkotransport3['TENKOBODYSLEEPYRESULT4'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT4', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT4" name="TXT_TENKOCARNEWRESULT4" value="<?= $result_seTenkotransport3['TENKOCARNEWRESULT4'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT4', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT4" name="TXT_TENKOTRAILERRESULT4" value="<?= $result_seTenkotransport3['TENKOTRAILERRESULT4'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT4', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOROADRESULT4" name="TXT_TENKOROADRESULT4" value="<?= $result_seTenkotransport3['TENKOROADRESULT4'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT4', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT4" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport3['TENKOAIRRESULT4'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT4', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT4" name="TXT_TENKOSLEEPYRESULT4" value="<?= $result_seTenkotransport3['TENKOSLEEPYRESULT4'] ?>"></td>
                                    <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOBODYSLEEPYREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"  class="form-control" value="<?= $result_seTenkotransport3['TENKOBODYSLEEPYREMARK'] ?>"></td>
                                    
                                    
                                    <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOROADREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"><?= $result_seTenkotransport3['TENKOROADREMARK'] ?></td> -->
                                </tr>
                                <tr>
                                    <td style="text-align: center">6</td>
                                    <td>ตรวจสภาพอากาศ (ใช้ที่ปัดน้ำฝนระดับ 3 ให้หยุดรถ)</td>
                                    <td style="text-align: center"><input type="checkbox" <?= $rs6d3 ?> onchange="edit_check6d3('TENKOAIRCHECK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" style="transform: scale(2)"  id="chk_6d3" name="chk_6d3"/></td>
                                    <td>รายงานสภาพอากาศ3</td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT5', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT5" name="TXT_TENKOLOADRESTRESULT5" value="<?= $result_seTenkotransport3['TENKOLOADRESTRESULT5'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT5', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT5" name="TXT_TENKOBODYSLEEPYRESULT5" value="<?= $result_seTenkotransport3['TENKOBODYSLEEPYRESULT5'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT5', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT5" name="TXT_TENKOCARNEWRESULT5" value="<?= $result_seTenkotransport3['TENKOCARNEWRESULT5'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT5', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT5" name="TXT_TENKOTRAILERRESULT5" value="<?= $result_seTenkotransport3['TENKOTRAILERRESULT5'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT5', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOROADRESULT5" name="TXT_TENKOROADRESULT5" value="<?= $result_seTenkotransport3['TENKOROADRESULT5'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT5', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT5" name="TXT_TENKOAIRRESULT5" value="<?= $result_seTenkotransport3['TENKOAIRRESULT5'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT5', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT5" name="TXT_TENKOSLEEPYRESULT5" value="<?= $result_seTenkotransport3['TENKOSLEEPYRESULT5'] ?>"></td>
                                    <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOAIRREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"  class="form-control" value="<?= $result_seTenkotransport3['TENKOAIRREMARK'] ?>"></td>
                                    
                                    
                                    <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOAIRREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"><?= $result_seTenkotransport3['TENKOAIRREMARK'] ?></td> -->
                                </tr>
                                <tr>
                                    <td style="text-align: center">7</td>
                                    <td>ตรวจสอบอาการง่วงและย้ำให้ระมัดระวัง</td>
                                    <td style="text-align: center"><input type="checkbox" <?= $rs7d3 ?> onchange="edit_check7d3('TENKOSLEEPYCHECK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" style="transform: scale(2)" id="chk_7d3" name="chk_7d3" /></td>
                                    <td>สภาพที่สามารถวิ่งงานต่อได้</td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT6', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT6" name="TXT_TENKOLOADRESTRESULT6" value="<?= $result_seTenkotransport3['TENKOLOADRESTRESULT6'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT6', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT6" name="TXT_TENKOBODYSLEEPYRESULT6" value="<?= $result_seTenkotransport3['TENKOBODYSLEEPYRESULT6'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT6', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT6" name="TXT_TENKOCARNEWRESULT6" value="<?= $result_seTenkotransport3['TENKOCARNEWRESULT6'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT6', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT6" name="TXT_TENKOTRAILERRESULT6" value="<?= $result_seTenkotransport3['TENKOTRAILERRESULT6'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT6', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOROADRESULT6" name="TXT_TENKOROADRESULT6" value="<?= $result_seTenkotransport3['TENKOROADRESULT6'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT6', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT6" name="TXT_TENKOAIRRESULT6" value="<?= $result_seTenkotransport3['TENKOAIRRESULT6'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT6', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT6" name="TXT_TENKOSLEEPYRESULT6" value="<?= $result_seTenkotransport3['TENKOSLEEPYRESULT6'] ?>"></td>
                                    <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOSLEEPYREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"  class="form-control" value="<?= $result_seTenkotransport3['TENKOSLEEPYREMARK'] ?>"></td>
                                    
                                    
                                    <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOSLEEPYREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"><?= $result_seTenkotransport3['TENKOSLEEPYREMARK'] ?></td> -->
                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <div class="tab-pane" id="day4">
                        <?php
                        $conditionTenkotransport41 = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_POST['employeecode2'] . "' ";
                        $conditionTenkotransport42 = " AND CONVERT(DATE,TENKOTRANSPORTDATE) = CONVERT(DATE,'" . $result_seTenkomaster['DATEINPUT_F4'] . "',103)";
                        $sql_seTenkotransport4 = "{call megEdittenkotransport_v2(?,?,?)}";
                        $params_seTenkotransport4 = array(
                            array('select_tenkotransport', SQLSRV_PARAM_IN),
                            array($conditionTenkotransport41, SQLSRV_PARAM_IN),
                            array($conditionTenkotransport42, SQLSRV_PARAM_IN)
                        );
                        $query_seTenkotransport4 = sqlsrv_query($conn, $sql_seTenkotransport4, $params_seTenkotransport4);
                        $result_seTenkotransport4 = sqlsrv_fetch_array($query_seTenkotransport4, SQLSRV_FETCH_ASSOC);

                        $rs1d4 = ($result_seTenkotransport4['TENKOLOADRESTCHECK'] == '1') ? "checked" : "";
                        $rs2d4 = ($result_seTenkotransport4['TENKOBODYSLEEPYCHECK'] == '1') ? "checked" : "";
                        $rs3d4 = ($result_seTenkotransport4['TENKOCARNEWCHECK'] == '1') ? "checked" : "";
                        $rs4d4 = ($result_seTenkotransport4['TENKOTRAILERCHECK'] == '1') ? "checked" : "";
                        $rs5d4 = ($result_seTenkotransport4['TENKOROADCHECK'] == '1') ? "checked" : "";
                        $rs6d4 = ($result_seTenkotransport4['TENKOAIRCHECK'] == '1') ? "checked" : "";
                        $rs7d4 = ($result_seTenkotransport4['TENKOSLEEPYCHECK'] == '1') ? "checked" : "";
                        ?>
                        <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                            <thead>
                                <tr>

                                    
                                    <!-- Commit_Emp2Day4 -->
                                    <th colspan="6" ><input type="button" onclick="commit_2('<?= $result_seTenkomaster_temp['TENKOMASTERID'] ?>','<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>', '<?= $result_seEmployee['nameT'] ?>')"   class="btn btn-success" value="Commit2_Day4"> <font style="color: green">พนักงานขับรถ : <?= $sex?> <?= $result_sePlain['EMPLOYEENAME2'] ?></font></th>

                                    <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะก่อนเริ่มงาน</th>
                                    <th style="text-align: center;"><?= $result_seTenkotransport1["CREATEBY"] ?></th>
                                    <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะปฎิบัติงาน</th>
                                    <th style="text-align: center;"><?= $result_seEmployee["nameT"] ?></th>
                                </tr>
                                <tr>

                                    <th colspan="12">เจ้าหน้าที่โทรไปไม่พบสิ่งผิดปกติ : <font style="color: red">0</font>  | พนักงานขับรถโทรมาไม่พบสิ่งผิดปกติ : <font style="color: red">1</font> | พบสิ่งผิดปกติ : <font style="color: red">x</font></th>
                                </tr>
                                <tr>

                                    <th rowspan="4" style="text-align: center;">ข้อ</th>
                                    <th rowspan="4" style="text-align: center;">หัวข้อ</th>
                                    <th rowspan="4" style="text-align: center;">ช่องตรวจ</th>
                                    <th rowspan="4" style="text-align: center;">เกณฑ์การตัดสิน</th>
                                    <th rowspan="2" style="text-align: center;"><p>โทรช่วง </p>
                                        <p>00:01 - 23:59</p></th>
                                    <th colspan="6" style="text-align: center">Night Call Check</th>
                                    <th rowspan="4"style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">รายละเอียดการแนะนำของเจ้าหน้าที่</th>
                                </tr>
                                <tr>

                                    <th style="text-align: center;">ครั้งที่ 1</th>
                                    <th style="text-align: center;">ครั้งที่ 2</th>
                                    <th style="text-align: center;">ครั้งที่ 3</th>
                                    <th style="text-align: center;">ครั้งที่ 4</th>
                                    <th style="text-align: center;">ครั้งที่ 5</th>
                                    <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">ครั้งที่ 6</th>
                                </tr>
                                <tr>

                                    <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME0', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control timeen" id="txt_time0" name="txt_time0" value="<?= $result_seTenkotransport4['TENKOTIME0'] ?>"></th>
                                    <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME1', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control timeen" id="txt_time1" name="txt_time1" value="<?= $result_seTenkotransport4['TENKOTIME1'] ?>"></th>
                                    <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME2', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control timeen" id="txt_time2" name="txt_time2" value="<?= $result_seTenkotransport4['TENKOTIME2'] ?>"></th>
                                    <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME3', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control timeen" id="txt_time3" name="txt_time3" value="<?= $result_seTenkotransport4['TENKOTIME3'] ?>"></th>
                                    <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME4', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control timeen" id="txt_time4" name="txt_time4" value="<?= $result_seTenkotransport4['TENKOTIME4'] ?>"></th>
                                    <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME5', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control timeen" id="txt_time5" name="txt_time5" value="<?= $result_seTenkotransport4['TENKOTIME5'] ?>"></th>
                                    <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME6', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control timeen" id="txt_time6" name="txt_time6" value="<?= $result_seTenkotransport4['TENKOTIME6'] ?>"></th>
                                </tr>
                                <tr>

                                    <th style="text-align: center;">ผล</th>
                                    <th style="text-align: center;">ผล</th>
                                    <th style="text-align: center;">ผล</th>
                                    <th style="text-align: center;">ผล</th>
                                    <th style="text-align: center;">ผล</th>
                                    <th style="text-align: center;">ผล</th>
                                    <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">ผล</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align: center">1</td>
                                    <td>เส้นทางที่กำหนด - จุดพัก</td>
                                    <td style="text-align: center"><input type="checkbox" <?= $rs1d4 ?> onchange="edit_check1d4('TENKOLOADRESTCHECK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" style="transform: scale(2)" id="chk_1d4" name="chk_1d4" /></td>
                                    <td>เส้นทาง จุดพักที่กำหนด</td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT0', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT0" name="TXT_TENKOLOADRESTRESULT0" value="<?= $result_seTenkotransport4['TENKOLOADRESTRESULT0'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT0', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT0" name="TXT_TENKOBODYSLEEPYRESULT0" value="<?= $result_seTenkotransport4['TENKOBODYSLEEPYRESULT0'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT0', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT0" name="TXT_TENKOCARNEWRESULT0" value="<?= $result_seTenkotransport4['TENKOCARNEWRESULT0'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT0', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT0" name="TXT_TENKOTRAILERRESULT0" value="<?= $result_seTenkotransport4['TENKOTRAILERRESULT0'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT0', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOROADRESULT0" name="TXT_TENKOROADRESULT0" value="<?= $result_seTenkotransport4['TENKOROADRESULT0'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT0', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT0" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport4['TENKOAIRRESULT0'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT0', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT0" name="TXT_TENKOSLEEPYRESULT0" value="<?= $result_seTenkotransport4['TENKOSLEEPYRESULT0'] ?>"></td>
                                    <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOLOADRESTREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"  class="form-control" value="<?= $result_seTenkotransport4['TENKOLOADRESTREMARK'] ?>"></td>
                                    

                                    <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOLOADRESTREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"><?= $result_seTenkotransport4['TENKOLOADRESTREMARK'] ?></td> -->
                                </tr>
                                <tr>
                                    <td style="text-align: center">2</td>
                                    <td>ตรวจร่างกาย - อาการง่วง</td>
                                    <td style="text-align: center"><input type="checkbox" <?= $rs2d4 ?> onchange="edit_check2d4('TENKOBODYSLEEPYCHECK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" style="transform: scale(2)"  id="chk_2d4" name="chk_2d4"/></td>
                                    <td>วิธีการพูดคุยต้องร่าเริง</td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT1', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT1" name="TXT_TENKOLOADRESTRESULT1" value="<?= $result_seTenkotransport4['TENKOLOADRESTRESULT1'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT1', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT1" name="TXT_TENKOBODYSLEEPYRESULT1" value="<?= $result_seTenkotransport4['TENKOBODYSLEEPYRESULT1'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT1', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT1" name="TXT_TENKOCARNEWRESULT1" value="<?= $result_seTenkotransport4['TENKOCARNEWRESULT1'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT1', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT1" name="TXT_TENKOTRAILERRESULT1" value="<?= $result_seTenkotransport4['TENKOTRAILERRESULT1'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT1', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOROADRESULT1" name="TXT_TENKOROADRESULT1" value="<?= $result_seTenkotransport4['TENKOROADRESULT1'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT1', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT1" name="TXT_TENKOAIRRESULT1" value="<?= $result_seTenkotransport4['TENKOAIRRESULT1'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT1', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT1" name="TXT_TENKOSLEEPYRESULT1" value="<?= $result_seTenkotransport4['TENKOSLEEPYRESULT1'] ?>"></td>
                                    <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOBODYSLEEPYREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"  class="form-control" value="<?= $result_seTenkotransport4['TENKOBODYSLEEPYREMARK'] ?>"></td>
                                    
                                    
                                    <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOBODYSLEEPYREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"><?= $result_seTenkotransport4['TENKOBODYSLEEPYREMARK'] ?></td> -->
                                </tr>
                                <tr>
                                    <td style="text-align: center">3</td>
                                    <td>ตรวจรถใหม่ (เฉพาะหยุดรถ)</td>
                                    <td style="text-align: center"><input type="checkbox" <?= $rs3d4 ?> onchange="edit_check3d4('TENKOCARNEWCHECK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" style="transform: scale(2)"  id="chk_3d4" name="chk_3d4"/></td>
                                    <td>มีการรายงานเกี่ยวกับรถใหม่ว่ามีสิ่งผิดปกติหรือไม่</td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT2', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT2" name="TXT_TENKOLOADRESTRESULT2" value="<?= $result_seTenkotransport4['TENKOLOADRESTRESULT2'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT2', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT2" name="TXT_TENKOBODYSLEEPYRESULT2" value="<?= $result_seTenkotransport4['TENKOBODYSLEEPYRESULT2'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT2', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT2" name="TXT_TENKOCARNEWRESULT2" value="<?= $result_seTenkotransport4['TENKOCARNEWRESULT2'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT2', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT2" name="TXT_TENKOTRAILERRESULT2" value="<?= $result_seTenkotransport4['TENKOTRAILERRESULT2'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT2', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOROADRESULT2" name="TXT_TENKOROADRESULT2" value="<?= $result_seTenkotransport4['TENKOROADRESULT2'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT2', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT2" name="TXT_TENKOAIRRESULT2" value="<?= $result_seTenkotransport4['TENKOAIRRESULT2'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT2', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT2" name="TXT_TENKOSLEEPYRESULT2" value="<?= $result_seTenkotransport4['TENKOSLEEPYRESULT2'] ?>"></td>
                                    <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOCARNEWREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"  class="form-control" value="<?= $result_seTenkotransport4['TENKOCARNEWREMARK'] ?>"></td>
                                    

                                    <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOCARNEWREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"><?= $result_seTenkotransport4['TENKOCARNEWREMARK'] ?></td> -->
                                </tr>
                                <tr>
                                    <td style="text-align: center">4</td>
                                    <td>ตรวจเทรลเลอร์</td>
                                    <td style="text-align: center"><input type="checkbox" <?= $rs4d4 ?> onchange="edit_check4d4('TENKOTRAILERCHECK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" style="transform: scale(2)"  id="chk_4d4" name="chk_4d4"/></td>
                                    <td>ระหว่างวิ่งงานไม่มีสิ่งผิดปกติ</td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT3', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT3" name="TXT_TENKOLOADRESTRESULT3" value="<?= $result_seTenkotransport4['TENKOLOADRESTRESULT3'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT3', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT3" name="TXT_TENKOBODYSLEEPYRESULT3" value="<?= $result_seTenkotransport4['TENKOBODYSLEEPYRESULT3'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT3', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT3" name="TXT_TENKOCARNEWRESULT3" value="<?= $result_seTenkotransport4['TENKOCARNEWRESULT3'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT3', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT3" name="TXT_TENKOTRAILERRESULT3" value="<?= $result_seTenkotransport4['TENKOTRAILERRESULT3'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT3', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOROADRESULT3" name="TXT_TENKOROADRESULT3" value="<?= $result_seTenkotransport4['TENKOROADRESULT3'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT3', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT3" name="TXT_TENKOAIRRESULT3" value="<?= $result_seTenkotransport4['TENKOAIRRESULT3'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT3', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT3" name="TXT_TENKOSLEEPYRESULT3" value="<?= $result_seTenkotransport4['TENKOSLEEPYRESULT3'] ?>"></td>
                                    <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOTRAILERREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"  class="form-control" value="<?= $result_seTenkotransport4['TENKOTRAILERREMARK'] ?>"></td>
                                    
                                    <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOTRAILERREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"><?= $result_seTenkotransport4['TENKOTRAILERREMARK'] ?></td> -->
                                </tr>
                                <tr>
                                    <td style="text-align: center">5</td>
                                    <td>ตรวจสภาพถนน</td>
                                    <td style="text-align: center"><input type="checkbox" <?= $rs5d4 ?> onchange="edit_check5d4('TENKOROADCHECK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" style="transform: scale(2)"  id="chk_5d4" name="chk_5d4"/></td>
                                    <td>รายงานสภาพถนน</td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT4', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT4" name="TXT_TENKOLOADRESTRESULT4" value="<?= $result_seTenkotransport4['TENKOLOADRESTRESULT4'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT4', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT4" name="TXT_TENKOBODYSLEEPYRESULT4" value="<?= $result_seTenkotransport4['TENKOBODYSLEEPYRESULT4'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT4', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT4" name="TXT_TENKOCARNEWRESULT4" value="<?= $result_seTenkotransport4['TENKOCARNEWRESULT4'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT4', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT4" name="TXT_TENKOTRAILERRESULT4" value="<?= $result_seTenkotransport4['TENKOTRAILERRESULT4'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT4', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOROADRESULT4" name="TXT_TENKOROADRESULT4" value="<?= $result_seTenkotransport4['TENKOROADRESULT4'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT4', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT4" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport4['TENKOAIRRESULT4'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT4', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT4" name="TXT_TENKOSLEEPYRESULT4" value="<?= $result_seTenkotransport4['TENKOSLEEPYRESULT4'] ?>"></td>
                                    <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOROADREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"  class="form-control" value="<?= $result_seTenkotransport4['TENKOROADREMARK'] ?>"></td>
                                    
                                    <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOROADREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"><?= $result_seTenkotransport4['TENKOROADREMARK'] ?></td> -->
                                </tr>
                                <tr>
                                    <td style="text-align: center">6</td>
                                    <td>ตรวจสภาพอากาศ (ใช้ที่ปัดน้ำฝนระดับ 3 ให้หยุดรถ)</td>
                                    <td style="text-align: center"><input type="checkbox" <?= $rs6d4 ?> onchange="edit_check6d4('TENKOAIRCHECK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" style="transform: scale(2)"  id="chk_6d4" name="chk_6d4"/></td>
                                    <td>รายงานสภาพอากาศ4</td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT5', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT5" name="TXT_TENKOLOADRESTRESULT5" value="<?= $result_seTenkotransport4['TENKOLOADRESTRESULT5'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT5', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT5" name="TXT_TENKOBODYSLEEPYRESULT5" value="<?= $result_seTenkotransport4['TENKOBODYSLEEPYRESULT5'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT5', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT5" name="TXT_TENKOCARNEWRESULT5" value="<?= $result_seTenkotransport4['TENKOCARNEWRESULT5'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT5', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT5" name="TXT_TENKOTRAILERRESULT5" value="<?= $result_seTenkotransport4['TENKOTRAILERRESULT5'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT5', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOROADRESULT5" name="TXT_TENKOROADRESULT5" value="<?= $result_seTenkotransport4['TENKOROADRESULT5'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT5', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT5" name="TXT_TENKOAIRRESULT5" value="<?= $result_seTenkotransport4['TENKOAIRRESULT5'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT5', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT5" name="TXT_TENKOSLEEPYRESULT5" value="<?= $result_seTenkotransport4['TENKOSLEEPYRESULT5'] ?>"></td>
                                    <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOAIRREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"  class="form-control" value="<?= $result_seTenkotransport4['TENKOAIRREMARK'] ?>"></td>
                                    
                                    <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOAIRREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"><?= $result_seTenkotransport4['TENKOAIRREMARK'] ?></td> -->
                                </tr>
                                <tr>
                                    <td style="text-align: center">7</td>
                                    <td>ตรวจสอบอาการง่วงและย้ำให้ระมัดระวัง</td>
                                    <td style="text-align: center"><input type="checkbox" <?= $rs7d4 ?> onchange="edit_check7d4('TENKOSLEEPYCHECK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" style="transform: scale(2)" id="chk_7d4" name="chk_7d4" /></td>
                                    <td>สภาพที่สามารถวิ่งงานต่อได้</td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT6', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT6" name="TXT_TENKOLOADRESTRESULT6" value="<?= $result_seTenkotransport4['TENKOLOADRESTRESULT6'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT6', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT6" name="TXT_TENKOBODYSLEEPYRESULT6" value="<?= $result_seTenkotransport4['TENKOBODYSLEEPYRESULT6'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT6', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT6" name="TXT_TENKOCARNEWRESULT6" value="<?= $result_seTenkotransport4['TENKOCARNEWRESULT6'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT6', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT6" name="TXT_TENKOTRAILERRESULT6" value="<?= $result_seTenkotransport4['TENKOTRAILERRESULT6'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT6', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOROADRESULT6" name="TXT_TENKOROADRESULT6" value="<?= $result_seTenkotransport4['TENKOROADRESULT6'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT6', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT6" name="TXT_TENKOAIRRESULT6" value="<?= $result_seTenkotransport4['TENKOAIRRESULT6'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT6', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT6" name="TXT_TENKOSLEEPYRESULT6" value="<?= $result_seTenkotransport4['TENKOSLEEPYRESULT6'] ?>"></td>
                                    <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOSLEEPYREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"  class="form-control" value="<?= $result_seTenkotransport4['TENKOSLEEPYREMARK'] ?>"></td>
                                    
                                    <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOSLEEPYREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"><?= $result_seTenkotransport4['TENKOSLEEPYREMARK'] ?></td> -->
                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <div class="tab-pane" id="day5">
                        <?php
                        $conditionTenkotransport51 = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_POST['employeecode2'] . "' ";
                        $conditionTenkotransport52 = " AND CONVERT(DATE,TENKOTRANSPORTDATE) = CONVERT(DATE,'" . $result_seTenkomaster['DATEINPUT_F5'] . "',103)";
                        $sql_seTenkotransport5 = "{call megEdittenkotransport_v2(?,?,?)}";
                        $params_seTenkotransport5 = array(
                            array('select_tenkotransport', SQLSRV_PARAM_IN),
                            array($conditionTenkotransport51, SQLSRV_PARAM_IN),
                            array($conditionTenkotransport52, SQLSRV_PARAM_IN)
                        );
                        $query_seTenkotransport5 = sqlsrv_query($conn, $sql_seTenkotransport5, $params_seTenkotransport5);
                        $result_seTenkotransport5 = sqlsrv_fetch_array($query_seTenkotransport5, SQLSRV_FETCH_ASSOC);

                        $rs1d5 = ($result_seTenkotransport5['TENKOLOADRESTCHECK'] == '1') ? "checked" : "";
                        $rs2d5 = ($result_seTenkotransport5['TENKOBODYSLEEPYCHECK'] == '1') ? "checked" : "";
                        $rs3d5 = ($result_seTenkotransport5['TENKOCARNEWCHECK'] == '1') ? "checked" : "";
                        $rs4d5 = ($result_seTenkotransport5['TENKOTRAILERCHECK'] == '1') ? "checked" : "";
                        $rs5d5 = ($result_seTenkotransport5['TENKOROADCHECK'] == '1') ? "checked" : "";
                        $rs6d5 = ($result_seTenkotransport5['TENKOAIRCHECK'] == '1') ? "checked" : "";
                        $rs7d5 = ($result_seTenkotransport5['TENKOSLEEPYCHECK'] == '1') ? "checked" : "";
                        ?>
                        <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                            <thead>
                                <tr>

                                    
                                    <!-- Commit_Emp2Day5 -->
                                    <th colspan="6" ><input type="button" onclick="commit_2('<?= $result_seTenkomaster_temp['TENKOMASTERID'] ?>','<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>', '<?= $result_seEmployee['nameT'] ?>')"   class="btn btn-success" value="Commit2_Day5"> <font style="color: green">พนักงานขับรถ : <?= $sex?> <?= $result_sePlain['EMPLOYEENAME2'] ?></font></th>

                                    <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะก่อนเริ่มงาน</th>
                                    <th style="text-align: center;"><?= $result_seTenkotransport1["CREATEBY"] ?></th>
                                    <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะปฎิบัติงาน</th>
                                    <th style="text-align: center;"><?= $result_seEmployee["nameT"] ?></th>
                                </tr>
                                <tr>

                                    <th colspan="12">เจ้าหน้าที่โทรไปไม่พบสิ่งผิดปกติ : <font style="color: red">0</font>  | พนักงานขับรถโทรมาไม่พบสิ่งผิดปกติ : <font style="color: red">1</font> | พบสิ่งผิดปกติ : <font style="color: red">x</font></th>
                                </tr>
                                <tr>

                                    <th rowspan="4" style="text-align: center;">ข้อ</th>
                                    <th rowspan="4" style="text-align: center;">หัวข้อ</th>
                                    <th rowspan="4" style="text-align: center;">ช่องตรวจ</th>
                                    <th rowspan="4" style="text-align: center;">เกณฑ์การตัดสิน</th>
                                    <th rowspan="2" style="text-align: center;"><p>โทรช่วง </p>
                                        <p>00:01 - 23:59</p></th>
                                    <th colspan="6" style="text-align: center">Night Call Check</th>
                                    <th rowspan="4"style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">รายละเอียดการแนะนำของเจ้าหน้าที่</th>
                                </tr>
                                <tr>

                                    <th style="text-align: center;">ครั้งที่ 1</th>
                                    <th style="text-align: center;">ครั้งที่ 2</th>
                                    <th style="text-align: center;">ครั้งที่ 3</th>
                                    <th style="text-align: center;">ครั้งที่ 4</th>
                                    <th style="text-align: center;">ครั้งที่ 5</th>
                                    <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">ครั้งที่ 6</th>
                                </tr>
                                <tr>

                                    <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME0', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control timeen" id="txt_time0" name="txt_time0" value="<?= $result_seTenkotransport5['TENKOTIME0'] ?>"></th>
                                    <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME1', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control timeen" id="txt_time1" name="txt_time1" value="<?= $result_seTenkotransport5['TENKOTIME1'] ?>"></th>
                                    <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME2', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control timeen" id="txt_time2" name="txt_time2" value="<?= $result_seTenkotransport5['TENKOTIME2'] ?>"></th>
                                    <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME3', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control timeen" id="txt_time3" name="txt_time3" value="<?= $result_seTenkotransport5['TENKOTIME3'] ?>"></th>
                                    <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME4', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control timeen" id="txt_time4" name="txt_time4" value="<?= $result_seTenkotransport5['TENKOTIME4'] ?>"></th>
                                    <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME5', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control timeen" id="txt_time5" name="txt_time5" value="<?= $result_seTenkotransport5['TENKOTIME5'] ?>"></th>
                                    <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME6', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control timeen" id="txt_time6" name="txt_time6" value="<?= $result_seTenkotransport5['TENKOTIME6'] ?>"></th>
                                </tr>
                                <tr>

                                    <th style="text-align: center;">ผล</th>
                                    <th style="text-align: center;">ผล</th>
                                    <th style="text-align: center;">ผล</th>
                                    <th style="text-align: center;">ผล</th>
                                    <th style="text-align: center;">ผล</th>
                                    <th style="text-align: center;">ผล</th>
                                    <th style="text-align: center;border: solid;border-color: #E5E5E5;border-width: thin;">ผล</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align: center">1</td>
                                    <td>เส้นทางที่กำหนด - จุดพัก</td>
                                    <td style="text-align: center"><input type="checkbox" <?= $rs1d5 ?> onchange="edit_check1d5('TENKOLOADRESTCHECK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" style="transform: scale(2)" id="chk_1d5" name="chk_1d5" /></td>
                                    <td>เส้นทาง จุดพักที่กำหนด</td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT0', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT0" name="TXT_TENKOLOADRESTRESULT0" value="<?= $result_seTenkotransport5['TENKOLOADRESTRESULT0'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT0', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT0" name="TXT_TENKOBODYSLEEPYRESULT0" value="<?= $result_seTenkotransport5['TENKOBODYSLEEPYRESULT0'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT0', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT0" name="TXT_TENKOCARNEWRESULT0" value="<?= $result_seTenkotransport5['TENKOCARNEWRESULT0'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT0', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT0" name="TXT_TENKOTRAILERRESULT0" value="<?= $result_seTenkotransport5['TENKOTRAILERRESULT0'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT0', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOROADRESULT0" name="TXT_TENKOROADRESULT0" value="<?= $result_seTenkotransport5['TENKOROADRESULT0'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT0', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT0" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport5['TENKOAIRRESULT0'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT0', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT0" name="TXT_TENKOSLEEPYRESULT0" value="<?= $result_seTenkotransport5['TENKOSLEEPYRESULT0'] ?>"></td>
                                    <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOLOADRESTREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"  class="form-control" value="<?= $result_seTenkotransport5['TENKOLOADRESTREMARK'] ?>"></td>
                                    
                                    <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOLOADRESTREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"><?= $result_seTenkotransport5['TENKOLOADRESTREMARK'] ?></td> -->
                                </tr>
                                <tr>
                                    <td style="text-align: center">2</td>
                                    <td>ตรวจร่างกาย - อาการง่วง</td>
                                    <td style="text-align: center"><input type="checkbox" <?= $rs2d5 ?> onchange="edit_check2d5('TENKOBODYSLEEPYCHECK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" style="transform: scale(2)"  id="chk_2d5" name="chk_2d5"/></td>
                                    <td>วิธีการพูดคุยต้องร่าเริง</td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT1', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT1" name="TXT_TENKOLOADRESTRESULT1" value="<?= $result_seTenkotransport5['TENKOLOADRESTRESULT1'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT1', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT1" name="TXT_TENKOBODYSLEEPYRESULT1" value="<?= $result_seTenkotransport5['TENKOBODYSLEEPYRESULT1'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT1', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT1" name="TXT_TENKOCARNEWRESULT1" value="<?= $result_seTenkotransport5['TENKOCARNEWRESULT1'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT1', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT1" name="TXT_TENKOTRAILERRESULT1" value="<?= $result_seTenkotransport5['TENKOTRAILERRESULT1'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT1', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOROADRESULT1" name="TXT_TENKOROADRESULT1" value="<?= $result_seTenkotransport5['TENKOROADRESULT1'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT1', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT1" name="TXT_TENKOAIRRESULT1" value="<?= $result_seTenkotransport5['TENKOAIRRESULT1'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT1', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT1" name="TXT_TENKOSLEEPYRESULT1" value="<?= $result_seTenkotransport5['TENKOSLEEPYRESULT1'] ?>"></td>
                                    <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOBODYSLEEPYREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"  class="form-control" value="<?= $result_seTenkotransport5['TENKOBODYSLEEPYREMARK'] ?>"></td>
                                    
                                    
                                    <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOBODYSLEEPYREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"><?= $result_seTenkotransport5['TENKOBODYSLEEPYREMARK'] ?></td> -->
                                </tr>
                                <tr>
                                    <td style="text-align: center">3</td>
                                    <td>ตรวจรถใหม่ (เฉพาะหยุดรถ)</td>
                                    <td style="text-align: center"><input type="checkbox" <?= $rs3d5 ?> onchange="edit_check3d5('TENKOCARNEWCHECK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" style="transform: scale(2)"  id="chk_3d5" name="chk_3d5"/></td>
                                    <td>มีการรายงานเกี่ยวกับรถใหม่ว่ามีสิ่งผิดปกติหรือไม่</td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT2', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT2" name="TXT_TENKOLOADRESTRESULT2" value="<?= $result_seTenkotransport5['TENKOLOADRESTRESULT2'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT2', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT2" name="TXT_TENKOBODYSLEEPYRESULT2" value="<?= $result_seTenkotransport5['TENKOBODYSLEEPYRESULT2'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT2', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT2" name="TXT_TENKOCARNEWRESULT2" value="<?= $result_seTenkotransport5['TENKOCARNEWRESULT2'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT2', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT2" name="TXT_TENKOTRAILERRESULT2" value="<?= $result_seTenkotransport5['TENKOTRAILERRESULT2'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT2', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOROADRESULT2" name="TXT_TENKOROADRESULT2" value="<?= $result_seTenkotransport5['TENKOROADRESULT2'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT2', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT2" name="TXT_TENKOAIRRESULT2" value="<?= $result_seTenkotransport5['TENKOAIRRESULT2'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT2', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT2" name="TXT_TENKOSLEEPYRESULT2" value="<?= $result_seTenkotransport5['TENKOSLEEPYRESULT2'] ?>"></td>
                                    <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOCARNEWREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"  class="form-control" value="<?= $result_seTenkotransport5['TENKOCARNEWREMARK'] ?>"></td>
                                    
                                    
                                    <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOCARNEWREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"><?= $result_seTenkotransport5['TENKOCARNEWREMARK'] ?></td> -->
                                </tr>
                                <tr>
                                    <td style="text-align: center">4</td>
                                    <td>ตรวจเทรลเลอร์</td>
                                    <td style="text-align: center"><input type="checkbox" <?= $rs4d5 ?> onchange="edit_check4d5('TENKOTRAILERCHECK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" style="transform: scale(2)"  id="chk_4d5" name="chk_4d5"/></td>
                                    <td>ระหว่างวิ่งงานไม่มีสิ่งผิดปกติ</td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT3', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT3" name="TXT_TENKOLOADRESTRESULT3" value="<?= $result_seTenkotransport5['TENKOLOADRESTRESULT3'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT3', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT3" name="TXT_TENKOBODYSLEEPYRESULT3" value="<?= $result_seTenkotransport5['TENKOBODYSLEEPYRESULT3'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT3', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT3" name="TXT_TENKOCARNEWRESULT3" value="<?= $result_seTenkotransport5['TENKOCARNEWRESULT3'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT3', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT3" name="TXT_TENKOTRAILERRESULT3" value="<?= $result_seTenkotransport5['TENKOTRAILERRESULT3'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT3', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOROADRESULT3" name="TXT_TENKOROADRESULT3" value="<?= $result_seTenkotransport5['TENKOROADRESULT3'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT3', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT3" name="TXT_TENKOAIRRESULT3" value="<?= $result_seTenkotransport5['TENKOAIRRESULT3'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT3', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT3" name="TXT_TENKOSLEEPYRESULT3" value="<?= $result_seTenkotransport5['TENKOSLEEPYRESULT3'] ?>"></td>
                                    <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOTRAILERREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"  class="form-control" value="<?= $result_seTenkotransport5['TENKOTRAILERREMARK'] ?>"></td>
                                    
                                    
                                    <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOTRAILERREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"><?= $result_seTenkotransport5['TENKOTRAILERREMARK'] ?></td> -->
                                </tr>
                                <tr>
                                    <td style="text-align: center">5</td>
                                    <td>ตรวจสภาพถนน</td>
                                    <td style="text-align: center"><input type="checkbox" <?= $rs5d5 ?> onchange="edit_check5d5('TENKOROADCHECK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" style="transform: scale(2)"  id="chk_5d5" name="chk_5d5"/></td>
                                    <td>รายงานสภาพถนน</td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT4', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT4" name="TXT_TENKOLOADRESTRESULT4" value="<?= $result_seTenkotransport5['TENKOLOADRESTRESULT4'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT4', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT4" name="TXT_TENKOBODYSLEEPYRESULT4" value="<?= $result_seTenkotransport5['TENKOBODYSLEEPYRESULT4'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT4', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT4" name="TXT_TENKOCARNEWRESULT4" value="<?= $result_seTenkotransport5['TENKOCARNEWRESULT4'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT4', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT4" name="TXT_TENKOTRAILERRESULT4" value="<?= $result_seTenkotransport5['TENKOTRAILERRESULT4'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT4', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOROADRESULT4" name="TXT_TENKOROADRESULT4" value="<?= $result_seTenkotransport5['TENKOROADRESULT4'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT4', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT4" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport5['TENKOAIRRESULT4'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT4', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT4" name="TXT_TENKOSLEEPYRESULT4" value="<?= $result_seTenkotransport5['TENKOSLEEPYRESULT4'] ?>"></td>
                                    <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOROADREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"  class="form-control" value="<?= $result_seTenkotransport5['TENKOROADREMARK'] ?>"></td>
                                    
                                    
                                    <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOROADREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"><?= $result_seTenkotransport5['TENKOROADREMARK'] ?></td> -->
                                </tr>
                                <tr>
                                    <td style="text-align: center">6</td>
                                    <td>ตรวจสภาพอากาศ (ใช้ที่ปัดน้ำฝนระดับ 3 ให้หยุดรถ)</td>
                                    <td style="text-align: center"><input type="checkbox" <?= $rs6d5 ?> onchange="edit_check6d5('TENKOAIRCHECK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" style="transform: scale(2)"  id="chk_6d5" name="chk_6d5"/></td>
                                    <td>รายงานสภาพอากาศ5</td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT5', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT5" name="TXT_TENKOLOADRESTRESULT5" value="<?= $result_seTenkotransport5['TENKOLOADRESTRESULT5'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT5', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT5" name="TXT_TENKOBODYSLEEPYRESULT5" value="<?= $result_seTenkotransport5['TENKOBODYSLEEPYRESULT5'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT5', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT5" name="TXT_TENKOCARNEWRESULT5" value="<?= $result_seTenkotransport5['TENKOCARNEWRESULT5'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT5', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT5" name="TXT_TENKOTRAILERRESULT5" value="<?= $result_seTenkotransport5['TENKOTRAILERRESULT5'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT5', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOROADRESULT5" name="TXT_TENKOROADRESULT5" value="<?= $result_seTenkotransport5['TENKOROADRESULT5'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT5', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT5" name="TXT_TENKOAIRRESULT5" value="<?= $result_seTenkotransport5['TENKOAIRRESULT5'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT5', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT5" name="TXT_TENKOSLEEPYRESULT5" value="<?= $result_seTenkotransport5['TENKOSLEEPYRESULT5'] ?>"></td>
                                    <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOAIRREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"  class="form-control" value="<?= $result_seTenkotransport5['TENKOAIRREMARK'] ?>"></td>
                                    
                                    
                                    <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOAIRREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"><?= $result_seTenkotransport5['TENKOAIRREMARK'] ?></td> -->
                                </tr>
                                <tr>
                                    <td style="text-align: center">7</td>
                                    <td>ตรวจสอบอาการง่วงและย้ำให้ระมัดระวัง</td>
                                    <td style="text-align: center"><input type="checkbox" <?= $rs7d5 ?> onchange="edit_check7d5('TENKOSLEEPYCHECK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" style="transform: scale(2)" id="chk_7d5" name="chk_7d5" /></td>
                                    <td>สภาพที่สามารถวิ่งงานต่อได้</td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT6', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT6" name="TXT_TENKOLOADRESTRESULT6" value="<?= $result_seTenkotransport5['TENKOLOADRESTRESULT6'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT6', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT6" name="TXT_TENKOBODYSLEEPYRESULT6" value="<?= $result_seTenkotransport5['TENKOBODYSLEEPYRESULT6'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT6', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT6" name="TXT_TENKOCARNEWRESULT6" value="<?= $result_seTenkotransport5['TENKOCARNEWRESULT6'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT6', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT6" name="TXT_TENKOTRAILERRESULT6" value="<?= $result_seTenkotransport5['TENKOTRAILERRESULT6'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT6', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOROADRESULT6" name="TXT_TENKOROADRESULT6" value="<?= $result_seTenkotransport5['TENKOROADRESULT6'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT6', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT6" name="TXT_TENKOAIRRESULT6" value="<?= $result_seTenkotransport5['TENKOAIRRESULT6'] ?>"></td>
                                    <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT6', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT6" name="TXT_TENKOSLEEPYRESULT6" value="<?= $result_seTenkotransport5['TENKOSLEEPYRESULT6'] ?>"></td>
                                    <td><input type="text" onchange="edit_tenkotransport(this.value, 'TENKOSLEEPYREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"  class="form-control" value="<?= $result_seTenkotransport5['TENKOSLEEPYREMARK'] ?>"></td>
                                    
                                    
                                    <!-- <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOSLEEPYREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"><?= $result_seTenkotransport5['TENKOSLEEPYREMARK'] ?></td> -->
                                </tr>
                            </tbody>
                        </table>

                    </div>
                  
            </div>
        </div>
   
    <?php
}
if ($_POST['txt_flg'] == "select_tenko3emp2") {
    $condition1 = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
    $sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEmployee = array(
        array('select_employeeehr2', SQLSRV_PARAM_IN),
        array($condition1, SQLSRV_PARAM_IN)
    );
    $query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
    $result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);
    
    $conditionPlain = " AND a.VEHICLETRANSPORTPLANID = '" . $_POST['vehicletransportplanid'] . "'";
    $sql_sePlain = "{call megVehicletransportplan_v2(?,?)}";
    $params_sePlain = array(
        array('select_vehicletransportplan', SQLSRV_PARAM_IN),
        array($conditionPlain, SQLSRV_PARAM_IN)
    );
    $query_sePlain = sqlsrv_query($conn, $sql_sePlain, $params_sePlain);
    $result_sePlain = sqlsrv_fetch_array($query_sePlain, SQLSRV_FETCH_ASSOC);

    $conditionTenkomaster_temp = " AND VEHICLETRANSPORTPLANID = '" . $_POST['vehicletransportplanid'] . "'";
    $sql_seTenkomaster_temp = "{call megVehicletransportplan_v2(?,?,?,?)}";
    $params_seTenkomaster_temp = array(
        array('select_vehicletransporttenko', SQLSRV_PARAM_IN),
        array($conditionTenkomaster_temp, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seTenkomaster_temp = sqlsrv_query($conn, $sql_seTenkomaster_temp, $params_seTenkomaster_temp);
    $result_seTenkomaster_temp = sqlsrv_fetch_array($query_seTenkomaster_temp, SQLSRV_FETCH_ASSOC);

    $conditionTenkomaster = " AND a.TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "'";
    $sql_seTenkomaster = "{call megEdittenkomaster_v2(?,?)}";
    $params_seTenkomaster = array(
        array('select_tenkomaster', SQLSRV_PARAM_IN),
        array($conditionTenkomaster, SQLSRV_PARAM_IN)
    );
    $query_seTenkomaster = sqlsrv_query($conn, $sql_seTenkomaster, $params_seTenkomaster);
    $result_seTenkomaster = sqlsrv_fetch_array($query_seTenkomaster, SQLSRV_FETCH_ASSOC);

    $conditionTenkoafter = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_POST['employeecode2'] . "'";
    $sql_seTenkoafter = "{call megEdittenkoafter_v2(?,?,?)}";
    $params_seTenkoafter = array(
        array('select_tenkoafter', SQLSRV_PARAM_IN),
        array($conditionTenkoafter, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seTenkoafter = sqlsrv_query($conn, $sql_seTenkoafter, $params_seTenkoafter);
    $result_seTenkoafter = sqlsrv_fetch_array($query_seTenkoafter, SQLSRV_FETCH_ASSOC);

    $chk31 = ($result_seTenkoafter['TENKOBEFOREGREETCHECK'] == '1') ? "checked" : "";
    $chk32 = ($result_seTenkoafter['TENKOUNIFORMCHECK'] == '1') ? "checked" : "";
    $chk33 = ($result_seTenkoafter['TENKOBODYCHECK'] == '1') ? "checked" : "";
    $chk34 = ($result_seTenkoafter['TENKOALCOHOLCHECK'] == '1') ? "checked" : "";
    $chk35 = ($result_seTenkoafter['TENKOCARNEWCHECK'] == '1') ? "checked" : "";
    $chk36 = ($result_seTenkoafter['TENKOTRAILERCHECK'] == '1') ? "checked" : "";
    $chk37 = ($result_seTenkoafter['TENKORISKYCHECK'] == '1') ? "checked" : "";
    $chk38 = ($result_seTenkoafter['TENKOAIRCHECK'] == '1') ? "checked" : "";
    $chk39 = ($result_seTenkoafter['TENKOPATTERNDRIVERCHECK'] == '1') ? "checked" : "";
    $chk310 = ($result_seTenkoafter['TENKODAILYDRIVERCHECK'] == '1') ? "checked" : "";
    $chk311 = ($result_seTenkoafter['TENKOHIYARIHATTOCHECK'] == '1') ? "checked" : "";
    $chk312 = ($result_seTenkoafter['TENKOYOKOTENCHECK'] == '1') ? "checked" : "";
    $chk313 = ($result_seTenkoafter['TENKOAFTERGREETCHECK'] == '1') ? "checked" : "";

    $rs311 = ($result_seTenkoafter['TENKOBEFOREGREETRESULT'] == '1') ? "checked" : "";
    $rs321 = ($result_seTenkoafter['TENKOUNIFORMRESULT'] == '1') ? "checked" : "";
    $rs331 = ($result_seTenkoafter['TENKOBODYRESULT'] == '1') ? "checked" : "";
    $rs341 = ($result_seTenkoafter['TENKOALCOHOLRESULT'] == '1') ? "checked" : "";
    $rs351 = ($result_seTenkoafter['TENKOCARNEWRESULT'] == '1') ? "checked" : "";
    $rs361 = ($result_seTenkoafter['TENKOTRAILERRESULT'] == '1') ? "checked" : "";
    $rs371 = ($result_seTenkoafter['TENKORISKYRESULT'] == '1') ? "checked" : "";
    $rs381 = ($result_seTenkoafter['TENKOAIRRESULT'] == '1') ? "checked" : "";
    $rs391 = ($result_seTenkoafter['TENKOPATTERNDRIVERRESULT'] == '1') ? "checked" : "";
    $rs3101 = ($result_seTenkoafter['TENKODAILYDRIVERRESULT'] == '1') ? "checked" : "";
    $rs3111 = ($result_seTenkoafter['TENKOHIYARIHATTORESULT'] == '1') ? "checked" : "";
    $rs3121 = ($result_seTenkoafter['TENKOYOKOTENRESULT'] == '1') ? "checked" : "";
    $rs3131 = ($result_seTenkoafter['TENKOAFTERGREETRESULT'] == '1') ? "checked" : "";

    $rs310 = ($result_seTenkoafter['TENKOBEFOREGREETRESULT'] == '0') ? "checked" : "";
    $rs320 = ($result_seTenkoafter['TENKOUNIFORMRESULT'] == '0') ? "checked" : "";
    $rs330 = ($result_seTenkoafter['TENKOBODYRESULT'] == '0') ? "checked" : "";
    $rs340 = ($result_seTenkoafter['TENKOALCOHOLRESULT'] == '0') ? "checked" : "";
    $rs350 = ($result_seTenkoafter['TENKOCARNEWRESULT'] == '0') ? "checked" : "";
    $rs360 = ($result_seTenkoafter['TENKOTRAILERRESULT'] == '0') ? "checked" : "";
    $rs370 = ($result_seTenkoafter['TENKORISKYRESULT'] == '0') ? "checked" : "";
    $rs380 = ($result_seTenkoafter['TENKOAIRRESULT'] == '0') ? "checked" : "";
    $rs390 = ($result_seTenkoafter['TENKOPATTERNDRIVERRESULT'] == '0') ? "checked" : "";
    $rs3100 = ($result_seTenkoafter['TENKODAILYDRIVERRESULT'] == '0') ? "checked" : "";
    $rs3110 = ($result_seTenkoafter['TENKOHIYARIHATTORESULT'] == '0') ? "checked" : "";
    $rs3120 = ($result_seTenkoafter['TENKOYOKOTENRESULT'] == '0') ? "checked" : "";
    $rs3130 = ($result_seTenkoafter['TENKOAFTERGREETRESULT'] == '0') ? "checked" : "";
    ?>

    <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
        <thead>
            <tr>

                <th colspan="6" ><input type="button" onclick="commit_3('<?= $result_seTenkomaster_temp['TENKOMASTERID'] ?>','<?= $result_seTenkoafter['TENKOAFTERID'] ?>','<?= $result_seEmployee['nameT'] ?>')" class="btn btn-success" value="Commit2_After"> <font style="color: green">พนักงานขับรถ :  <?= $result_sePlain['EMPLOYEENAME2'] ?></font></th>
                <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะก่อนเริ่มงาน</th>
                <th style="text-align: center;"><?= $result_seTenkotransport1["CREATEBY"] ?></th>
                <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะปฎิบัติงาน</th>
                <th style="text-align: center;"><?= $result_seEmployee["nameT"] ?></th>
            </tr>
            <tr>
                <th rowspan="2" style="text-align: center;">ข้อ</th>
                <th rowspan="2" style="text-align: center;">หัวข้อ</th>
                <th rowspan="2" style="text-align: center;">ช่องตรวจสอบ</th>
                <th rowspan="2" style="text-align: center;">เกณฑ์การตัดสิน</th>
                <th colspan="2" style="text-align: center;">ผล</th>
                <th colspan="4" rowspan="2" style="text-align: center;">รายละเอียดและการแนะนำ</th>
            </tr>
            <tr>
                <th style="text-align: center;">ปกติ</th>
                <th style="text-align: center;">ไม่ปกติ</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center">1</td>
                <td>การทักทายก่อนเริ่มเท็งโกะ</td>
                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk31 ?> onchange="edit_check31('TENKOBEFOREGREETCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_31" name="chk_31"/></td>
                <td>ทักทายอย่างมีชีวิตชีวา</td>
                <td style="text-align:center"><input type="checkbox" <?= $rs311 ?> style="transform: scale(2)" id="chk_rs311" name="chk_rs311" onchange="edit_rs311('TENKOBEFOREGREETRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td style="text-align:center"><input type="checkbox" <?= $rs310 ?> style="transform: scale(2)" id="chk_rs310" name="chk_rs310" onchange="edit_rs310('TENKOBEFOREGREETRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOBEFOREGREETREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOBEFOREGREETREMARK'] ?></td>
            </tr>
            <tr>
                <td style="text-align: center">2</td>
                <td>ตรวจเช็คยูนิฟอร์ม</td>
                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk32 ?> onchange="edit_check32('TENKOUNIFORMCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_32" name="chk_32"/></td>
                <td>ไม่มีคราบสกปรก</td>
                <td style="text-align:center"><input type="checkbox" <?= $rs321 ?> style="transform: scale(2)" id="chk_rs321" name="chk_rs321" onchange="edit_rs321('TENKOUNIFORMRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td style="text-align:center"><input type="checkbox" <?= $rs320 ?> style="transform: scale(2)" id="chk_rs320" name="chk_rs320" onchange="edit_rs320('TENKOUNIFORMRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOUNIFORMREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOUNIFORMREMARK'] ?></td>
            </tr>
            <tr>
                <td style="text-align: center">3</td>
                <td>ตรวจสภาพร่างกาย</td>
                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk33 ?> onchange="edit_check33('TENKOBODYCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_33" name="chk_33"/></td>
                <td>สภาพร่างกายแข็งแรงดี</td>
                <td style="text-align:center"><input type="checkbox" <?= $rs331 ?> style="transform: scale(2)" id="chk_rs331" name="chk_rs331" onchange="edit_rs331('TENKOBODYRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td style="text-align:center"><input type="checkbox" <?= $rs330 ?> style="transform: scale(2)" id="chk_rs330" name="chk_rs330" onchange="edit_rs330('TENKOBODYRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOBODYREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOBODYREMARK'] ?></td>
            </tr>
            <tr>
                <td style="text-align: center">4</td>
                <td>ตรวจเช็คแอลกอฮอล์</td>
                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk34 ?> onchange="edit_check34('TENKOALCOHOLCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_34" name="chk_34"/></td>
                <td>[0]</td>
                <td style="text-align:center"><input type="checkbox" <?= $rs341 ?> style="transform: scale(2)" id="chk_rs341" name="chk_rs341" onchange="edit_rs341('TENKOALCOHOLRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td style="text-align:center"><input type="checkbox"  <?= $rs340 ?> style="transform: scale(2)" id="chk_rs340" name="chk_rs340" onchange="edit_rs340('TENKOALCOHOLRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOALCOHOLREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOALCOHOLREMARK'] ?></td>
            </tr>
            <tr>
                <td style="text-align: center">5</td>
                <td>มีความผิดปกติกับรถใหม่หรือไม่</td>
                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk35 ?> onchange="edit_check35('TENKOCARNEWCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_35" name="chk_35"/></td>
                <td>รายงานสิ่งผิดปกติของรถใหม่ว่ามีหรือไม่</td>
                <td style="text-align:center"><input type="checkbox" <?= $rs351 ?> style="transform: scale(2)" id="chk_rs351" name="chk_rs351" onchange="edit_rs351('TENKOCARNEWRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td style="text-align:center"><input type="checkbox" <?= $rs350 ?> style="transform: scale(2)" id="chk_rs350" name="chk_rs350" onchange="edit_rs350('TENKOCARNEWRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOCARNEWREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOCARNEWREMARK'] ?></td>
            </tr>
            <tr>
                <td style="text-align: center">6</td>
                <td>ความผิดปกติของรถเทรลเลอร์</td>
                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk36 ?> onchange="edit_check36('TENKOTRAILERCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_36" name="chk_36"/></td>
                <td>รายงานสิ่งผิดปกติของเทรลเลอร์ว่ามีหรือไม่</td>
                <td style="text-align:center"><input type="checkbox" <?= $rs361 ?> style="transform: scale(2)" id="chk_rs361" name="chk_rs361" onchange="edit_rs361('TENKOTRAILERRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td style="text-align:center"><input type="checkbox" <?= $rs360 ?> style="transform: scale(2)" id="chk_rs360" name="chk_rs360" onchange="edit_rs360('TENKOTRAILERRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOTRAILERREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOTRAILERREMARK'] ?></td>
            </tr>
            <tr>
                <td style="text-align: center">7</td>
                <td>จุดเสี่ยงระหว่างเส้นทางการขนส่ง(ล่าง)</td>
                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk37 ?> onchange="edit_check37('TENKORISKYCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_37" name="chk_37"/></td>
                <td>รายงานว่ามีจุดเปลี่ยนแปลงที่ผิดปกติหรือไม่</td>
                <td style="text-align:center"><input type="checkbox" <?= $rs371 ?> style="transform: scale(2)" id="chk_rs371" name="chk_rs371" onchange="edit_rs371('TENKORISKYRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td style="text-align:center"><input type="checkbox" <?= $rs370 ?> style="transform: scale(2)" id="chk_rs370" name="chk_rs370" onchange="edit_rs370('TENKORISKYRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKORISKYREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKORISKYREMARK'] ?></td>
            </tr>
            <tr>
                <td style="text-align: center">8</td>
                <td>ตรวจสอบสภาพอากาศ</td>
                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk38 ?> onchange="edit_check38('TENKOAIRCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_38" name="chk_38"/></td>
                <td>รายงานสภาพอากาศ6</td>
                <td style="text-align:center"><input type="checkbox" <?= $rs381 ?> style="transform: scale(2)" id="chk_rs381" name="chk_rs381" onchange="edit_rs381('TENKOAIRRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td style="text-align:center"><input type="checkbox" <?= $rs380 ?> style="transform: scale(2)" id="chk_rs380" name="chk_rs380" onchange="edit_rs380('TENKOAIRRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOAIRREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOAIRREMARK'] ?></td>
            </tr>
            <tr>
                <td style="text-align: center">9</td>
                <td>ตรวจสอบรูปแบบการขับขี่</td>
                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk39 ?> onchange="edit_check39('TENKOPATTERNDRIVERCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_39" name="chk_39"/></td>
                <td>รายงานรูปแบบการขับขี่</td>
                <td style="text-align:center"><input type="checkbox" <?= $rs391 ?> style="transform: scale(2)" id="chk_rs391" name="chk_rs391" onchange="edit_rs391('TENKOPATTERNDRIVERRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td style="text-align:center"><input type="checkbox" <?= $rs390 ?> style="transform: scale(2)" id="chk_rs390" name="chk_rs390" onchange="edit_rs390('TENKOPATTERNDRIVERRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOPATTERNDRIVERREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOPATTERNDRIVERREMARK'] ?></td>
            </tr>
            <tr>
                <td style="text-align: center">10</td>
                <td>ตรวจสอบข้อมูลการขับขี่ประจำวันจาก GPS เรคคอร์ด(ล่าง)</td>
                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk310 ?> onchange="edit_check310('TENKODAILYDRIVERCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"  id="chk_310" name="chk_310"/></td>
                <td>หัวข้อฝ่าฝืนเป็น [0]</td>
                <td style="text-align:center"><input type="checkbox" <?= $rs3101 ?> style="transform: scale(2)" id="chk_rs3101" name="chk_rs3101" onchange="edit_rs3101('TENKODAILYDRIVERRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td style="text-align:center"><input type="checkbox" <?= $rs3100 ?> style="transform: scale(2)" id="chk_rs3100" name="chk_rs3100" onchange="edit_rs3100('TENKODAILYDRIVERRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKODAILYDRIVERREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKODAILYDRIVERREMARK'] ?></td>
            </tr>
            <tr>
                <td style="text-align: center">11</td>
                <td>ฮิยาริฮัตโตะนอกเหนือจากข้อ 7.</td>
                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk311 ?> onchange="edit_check311('TENKOHIYARIHATTOCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_311" name="chk_311"/></td>
                <td>เหตุการณ์ที่ตกใจและเกือบเกิดอุบัติเหตุ</td>
                <td style="text-align:center"><input type="checkbox" <?= $rs3111 ?> style="transform: scale(2)" id="chk_rs3111" name="chk_rs3111" onchange="edit_rs3111('TENKOHIYARIHATTORESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td style="text-align:center"><input type="checkbox" <?= $rs3110 ?> style="transform: scale(2)" id="chk_rs3110" name="chk_rs3110" onchange="edit_rs3110('TENKOHIYARIHATTORESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOHIYARIHATTOREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOHIYARIHATTOREMARK'] ?></td>
            </tr>
            <tr>
                <td style="text-align: center">12</td>
                <td>แจ้งเรื่องโยโกะเต็น/แนะนำวิธีการจัดสรรชั่วโมงนอนหลับ</td>
                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk312 ?> onchange="edit_check312('TENKOYOKOTENCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_312" name="chk_312"/></td>
                <td>เข้าใจเนื้อหาและวิธีการต่างๆที่แจ้งไป</td>
                <td style="text-align:center"><input type="checkbox" <?= $rs3121 ?> style="transform: scale(2)" id="chk_rs3121" name="chk_rs3121" onchange="edit_rs3121('TENKOYOKOTENRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td style="text-align:center"><input type="checkbox" <?= $rs3120 ?> style="transform: scale(2)" id="chk_rs3120" name="chk_rs3120" onchange="edit_rs3120('TENKOYOKOTENRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOYOKOTENREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOYOKOTENREMARK'] ?></td>
            </tr>
            <tr>
                <td style="text-align: center">13</td>
                <td>การทักทายหลังทำเท็งโกะเสร็จ</td>
                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk313 ?> onchange="edit_check313('TENKOAFTERGREETCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_313" name="chk_313"/></td>
                <td>ทักทายอย่างมีชีวิตชีวา</td>
                <td style="text-align:center"><input type="checkbox" <?= $rs3131 ?> style="transform: scale(2)" id="chk_rs3131" name="chk_rs3131" onchange="edit_rs3131('TENKOAFTERGREETRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td style="text-align:center"><input type="checkbox" <?= $rs3130 ?> style="transform: scale(2)" id="chk_rs3130" name="chk_rs3130" onchange="edit_rs3130('TENKOAFTERGREETRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOAFTERGREETREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOAFTERGREETREMARK'] ?></td>
            </tr>
        </tbody>
    </table>

    <?php
}
if ($_POST['txt_flg'] == "select_tenko4emp2-1") {
    $conditionPlain = " AND a.VEHICLETRANSPORTPLANID = '" . $_POST['vehicletransportplanid'] . "'";
    $sql_sePlain = "{call megVehicletransportplan_v2(?,?)}";
    $params_sePlain = array(
        array('select_vehicletransportplan', SQLSRV_PARAM_IN),
        array($conditionPlain, SQLSRV_PARAM_IN)
    );
    $query_sePlain = sqlsrv_query($conn, $sql_sePlain, $params_sePlain);
    $result_sePlain = sqlsrv_fetch_array($query_sePlain, SQLSRV_FETCH_ASSOC);

    $conditionTenkomaster_temp = " AND VEHICLETRANSPORTPLANID = '" . $_POST['vehicletransportplanid'] . "'";
    $sql_seTenkomaster_temp = "{call megVehicletransportplan_v2(?,?,?,?)}";
    $params_seTenkomaster_temp = array(
        array('select_vehicletransporttenko', SQLSRV_PARAM_IN),
        array($conditionTenkomaster_temp, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seTenkomaster_temp = sqlsrv_query($conn, $sql_seTenkomaster_temp, $params_seTenkomaster_temp);
    $result_seTenkomaster_temp = sqlsrv_fetch_array($query_seTenkomaster_temp, SQLSRV_FETCH_ASSOC);

    $conditionTenkomaster = " AND a.TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "'";
    $sql_seTenkomaster = "{call megEdittenkomaster_v2(?,?)}";
    $params_seTenkomaster = array(
        array('select_tenkomaster', SQLSRV_PARAM_IN),
        array($conditionTenkomaster, SQLSRV_PARAM_IN)
    );
    $query_seTenkomaster = sqlsrv_query($conn, $sql_seTenkomaster, $params_seTenkomaster);
    $result_seTenkomaster = sqlsrv_fetch_array($query_seTenkomaster, SQLSRV_FETCH_ASSOC);

    if ($result_sePlain['COMPANYCODE'] == 'RRC' || $result_sePlain['COMPANYCODE'] == 'RCC' || $result_sePlain['COMPANYCODE'] == 'RATC') {
        $conditionTenkorisky = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_POST['employeecode2'] . "'";
        $sql_seTenkorisky = "{call megEdittenkorisky_v2(?,?,?)}";
        $params_seTenkorisky = array(
            array('select_tenkorisky', SQLSRV_PARAM_IN),
            array($conditionTenkorisky, SQLSRV_PARAM_IN),
            array('', SQLSRV_PARAM_IN)
        );
        $query_seTenkorisky = sqlsrv_query($conn, $sql_seTenkorisky, $params_seTenkorisky);
        $result_seTenkorisky = sqlsrv_fetch_array($query_seTenkorisky, SQLSRV_FETCH_ASSOC);

        $rs411 = ($result_seTenkorisky['TENKORISKYBPRESULT'] == '1') ? "checked" : "";
        $rs421 = ($result_seTenkorisky['TENKORISKYSRRESULT'] == '1') ? "checked" : "";
        $rs431 = ($result_seTenkorisky['TENKORISKYGWRESULT'] == '1') ? "checked" : "";
        $rs441 = ($result_seTenkorisky['TENKORISKYOTH1RESULT'] == '1') ? "checked" : "";
        $rs451 = ($result_seTenkorisky['TENKORISKYBRANCHRESULT'] == '1') ? "checked" : "";
        $rs461 = ($result_seTenkorisky['TENKOWIRERESULT'] == '1') ? "checked" : "";
        $rs471 = ($result_seTenkorisky['TENKOLOADRESULT'] == '1') ? "checked" : "";
        $rs481 = ($result_seTenkorisky['TENKOTRAILERPARKINGRESULT'] == '1') ? "checked" : "";
        $rs491 = ($result_seTenkorisky['TENKOCARNEWPARKINGRESULT'] == '1') ? "checked" : "";
        $rs4101 = ($result_seTenkorisky['TENKORISKYOTH2RESULT'] == '1') ? "checked" : "";


        $rs410 = ($result_seTenkorisky['TENKORISKYBPRESULT'] == '0') ? "checked" : "";
        $rs420 = ($result_seTenkorisky['TENKORISKYSRRESULT'] == '0') ? "checked" : "";
        $rs430 = ($result_seTenkorisky['TENKORISKYGWRESULT'] == '0') ? "checked" : "";
        $rs440 = ($result_seTenkorisky['TENKORISKYOTH1RESULT'] == '0') ? "checked" : "";
        $rs450 = ($result_seTenkorisky['TENKORISKYBRANCHRESULT'] == '0') ? "checked" : "";
        $rs460 = ($result_seTenkorisky['TENKOWIRERESULT'] == '0') ? "checked" : "";
        $rs470 = ($result_seTenkorisky['TENKOLOADRESULT'] == '0') ? "checked" : "";
        $rs480 = ($result_seTenkorisky['TENKOTRAILERPARKINGRESULT'] == '0') ? "checked" : "";
        $rs490 = ($result_seTenkorisky['TENKOCARNEWPARKINGRESULT'] == '0') ? "checked" : "";
        $rs4100 = ($result_seTenkorisky['TENKORISKYOTH2RESULT'] == '0') ? "checked" : "";
        ?>

        <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
            <thead>
                <tr>

                    <th colspan="6" ><font style="color: green">พนักงานขับรถ :  <?= $result_sePlain['EMPLOYEENAME2'] ?></font></th>
                </tr>
                <tr>
                    <th style="text-align: center">ข้อ</th>
                    <th style="text-align: center" colspan="2">หัวข้อ</th>
                    <th colspan="2" style="text-align: center">สิ่งผิดปกติ</th>
                    <th style="text-align: center">รายละเอียดสิ่งผิดปกติ</th>
                </tr>
                <tr>
                    <th style="text-align: center">&nbsp;</th>
                    <th style="text-align: center" colspan="2">&nbsp;</th>
                    <th style="text-align: center">มี</th>
                    <th style="text-align: center">ไม่มี</th>
                    <th style="text-align: center">&nbsp;</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td rowspan="4" style="text-align: center">1</td>
                    <td rowspan="4">ในยาร์ด</td>
                    <td>บ้านโพธิ์</td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs411 ?> onchange="edit_rs411('TENKORISKYBPRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"  style="transform: scale(2)" id="chk_rs411" name="chk_rs411" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs410 ?> onchange="edit_rs410('TENKORISKYBPRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs410" name="chk_rs410" /></td>
                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKORISKYBPREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKORISKYBPREMARK'] ?></td>
                </tr>
                <tr>
                    <td>สำโรง</td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs421 ?> onchange="edit_rs421('TENKORISKYSRRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs421" name="chk_rs421" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs420 ?>  onchange="edit_rs420('TENKORISKYSRRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs420" name="chk_rs420" /></td>
                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKORISKYSRREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKORISKYSRREMARK'] ?></td>
                </tr>
                <tr>
                    <td>เกตุเวย์</td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs431 ?> onchange="edit_rs431('TENKORISKYGWRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs431" name="chk_rs431" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs430 ?> onchange="edit_rs430('TENKORISKYGWRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs430" name="chk_rs430" /></td>
                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKORISKYGWREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKORISKYGWREMARK'] ?></td>
                </tr>
                <tr>
                    <td>อื่นๆ</td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs441 ?> onchange="edit_rs441('TENKORISKYOTH1RESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" style="transform: scale(2)" id="chk_rs441" name="chk_rs441" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs440 ?> onchange="edit_rs440('TENKORISKYOTH1RESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" style="transform: scale(2)" id="chk_rs440" name="chk_rs440" /></td>
                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKORISKYOTH1REMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKORISKYOTH1REMARK'] ?></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align: center">2</td>
                    <td rowspan="3">บนถนน</td>
                    <td>กิ่งไม้</td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs451 ?> onchange="edit_rs451('TENKORISKYBRANCHRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs451" name="chk_rs451" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs450 ?> onchange="edit_rs450('TENKORISKYBRANCHRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs450" name="chk_rs450" /></td>
                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKORISKYBRANCHREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKORISKYBRANCHREMARK'] ?></td>
                </tr>
                <tr>
                    <td>สายไฟ</td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs461 ?> onchange="edit_rs461('TENKOWIRERESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs461" name="chk_rs461" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs460 ?> onchange="edit_rs460('TENKOWIRERESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs460" name="chk_rs460" /></td>
                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKOWIREREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKOWIREREMARK'] ?></td>
                </tr>
                <tr>
                    <td>สภาพถนน,ก่อสร้าง</td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs471 ?> onchange="edit_rs471('TENKOLOADRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs471" name="chk_rs471" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs470 ?> onchange="edit_rs470('TENKOLOADRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs470" name="chk_rs470" /></td>
                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKOLOADREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKOLOADREMARK'] ?></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align: center">3</td>
                    <td rowspan="3">ตัวแทนจำหน่ย</td>
                    <td>จุดจอดเทรลเลอร์</td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs481 ?> onchange="edit_rs481('TENKOTRAILERPARKINGRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs481" name="chk_rs481" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs480 ?> onchange="edit_rs480('TENKOTRAILERPARKINGRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs480" name="chk_rs480" /></td>
                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKOTRAILERPARKINGREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKOTRAILERPARKINGREMARK'] ?></td>
                </tr>
                <tr>
                    <td>พื้นที่รับรถใหม่</td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs491 ?> onchange="edit_rs491('TENKOCARNEWPARKINGRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs491" name="chk_rs491" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs490 ?> onchange="edit_rs490('TENKOCARNEWPARKINGRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs490" name="chk_rs490" /></td>
                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKOCARNEWPARKINGREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKOCARNEWPARKINGREMARK'] ?></td>
                </tr>
                <tr>
                    <td>อื่นๆ</td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs4101 ?> onchange="edit_rs4101('TENKORISKYOTH2RESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs4101" name="chk_rs4101" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs4100 ?> onchange="edit_rs4100('TENKORISKYOTH2RESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs4100" name="chk_rs4100" /></td>
                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKORISKYOTH2REMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKORISKYOTH2REMARK'] ?></td>
                </tr>
            </tbody>
        </table>

        <?php
    }
}
if ($_POST['txt_flg'] == "select_tenko4emp2-2") {
    $condition1 = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
    $sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEmployee = array(
        array('select_employeeehr2', SQLSRV_PARAM_IN),
        array($condition1, SQLSRV_PARAM_IN)
    );
    $query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
    $result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);
    
    $conditionPlain = " AND a.VEHICLETRANSPORTPLANID = '" . $_POST['vehicletransportplanid'] . "'";
    $sql_sePlain = "{call megVehicletransportplan_v2(?,?)}";
    $params_sePlain = array(
        array('select_vehicletransportplan', SQLSRV_PARAM_IN),
        array($conditionPlain, SQLSRV_PARAM_IN)
    );
    $query_sePlain = sqlsrv_query($conn, $sql_sePlain, $params_sePlain);
    $result_sePlain = sqlsrv_fetch_array($query_sePlain, SQLSRV_FETCH_ASSOC);

    $conditionTenkomaster_temp = " AND VEHICLETRANSPORTPLANID = '" . $_POST['vehicletransportplanid'] . "'";
    $sql_seTenkomaster_temp = "{call megVehicletransportplan_v2(?,?,?,?)}";
    $params_seTenkomaster_temp = array(
        array('select_vehicletransporttenko', SQLSRV_PARAM_IN),
        array($conditionTenkomaster_temp, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seTenkomaster_temp = sqlsrv_query($conn, $sql_seTenkomaster_temp, $params_seTenkomaster_temp);
    $result_seTenkomaster_temp = sqlsrv_fetch_array($query_seTenkomaster_temp, SQLSRV_FETCH_ASSOC);

    $conditionTenkomaster = " AND a.TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "'";
    $sql_seTenkomaster = "{call megEdittenkomaster_v2(?,?)}";
    $params_seTenkomaster = array(
        array('select_tenkomaster', SQLSRV_PARAM_IN),
        array($conditionTenkomaster, SQLSRV_PARAM_IN)
    );
    $query_seTenkomaster = sqlsrv_query($conn, $sql_seTenkomaster, $params_seTenkomaster);
    $result_seTenkomaster = sqlsrv_fetch_array($query_seTenkomaster, SQLSRV_FETCH_ASSOC);

    if ($result_sePlain['COMPANYCODE'] == 'RKR' || $result_sePlain['COMPANYCODE'] == 'RKS' || $result_sePlain['COMPANYCODE'] == 'RKL') {
        $conditionTenkorisky = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_POST['employeecode2'] . "'";
        $sql_seTenkorisky = "{call megEdittenkorisky_v2(?,?,?)}";
        $params_seTenkorisky = array(
            array('select_tenkorisky', SQLSRV_PARAM_IN),
            array($conditionTenkorisky, SQLSRV_PARAM_IN),
            array('', SQLSRV_PARAM_IN)
        );
        $query_seTenkorisky = sqlsrv_query($conn, $sql_seTenkorisky, $params_seTenkorisky);
        $result_seTenkorisky = sqlsrv_fetch_array($query_seTenkorisky, SQLSRV_FETCH_ASSOC);

        $rs451 = ($result_seTenkorisky['TENKORISKYBRANCHRESULT'] == '1') ? "checked" : "";
        $rs461 = ($result_seTenkorisky['TENKOWIRERESULT'] == '1') ? "checked" : "";
        $rs471 = ($result_seTenkorisky['TENKOLOADRESULT'] == '1') ? "checked" : "";
        $rs451_h = ($result_seTenkorisky['TENKORISKYBRANCHRESULT_H'] == '1') ? "checked" : "";
        $rs461_h = ($result_seTenkorisky['TENKOWIRERESULT_H'] == '1') ? "checked" : "";
        $rs471_h = ($result_seTenkorisky['TENKOLOADRESULT_H'] == '1') ? "checked" : "";



        $rs450 = ($result_seTenkorisky['TENKORISKYBRANCHRESULT'] == '0') ? "checked" : "";
        $rs460 = ($result_seTenkorisky['TENKOWIRERESULT'] == '0') ? "checked" : "";
        $rs470 = ($result_seTenkorisky['TENKOLOADRESULT'] == '0') ? "checked" : "";
        $rs450_h = ($result_seTenkorisky['TENKORISKYBRANCHRESULT_H'] == '0') ? "checked" : "";
        $rs460_h = ($result_seTenkorisky['TENKOWIRERESULT_H'] == '0') ? "checked" : "";
        $rs470_h = ($result_seTenkorisky['TENKOLOADRESULT_H'] == '0') ? "checked" : "";
        ?>

        <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
            <thead>
                <tr>

                    <th colspan="7" ><font style="color: green">พนักงานขับรถ :  <?= $result_sePlain['EMPLOYEENAME2'] ?></font></th>
                </tr>
                <tr>
                    <th style="text-align: center">ข้อ</th>
                    <th style="text-align: center" >หัวข้อ</th>
                    <th colspan="2" style="text-align: center">สิ่งผิดปกติ</th>
                    <th colspan="2" style="text-align: center">ฮิยาริฮัตโตะ</th>
                    <th style="text-align: center">รายละเอียดสิ่งผิดปกติ</th>
                </tr>
                <tr>
                    <th style="text-align: center">&nbsp;</th>
                    <th style="text-align: center">&nbsp;</th>
                    <th style="text-align: center">มี</th>
                    <th style="text-align: center">ไม่มี</th>
                    <th style="text-align: center">มี</th>
                    <th style="text-align: center">ไม่มี</th>
                    <th style="text-align: center">&nbsp;</th>
                </tr>
            </thead>
            <tbody>


                <tr>
                    <td style="text-align: center">1</td>

                    <td>กิ่งไม้</td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs451 ?> onchange="edit_rs451('TENKORISKYBRANCHRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs451" name="chk_rs451" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs450 ?> onchange="edit_rs450('TENKORISKYBRANCHRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs450" name="chk_rs450" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs451_h ?> onchange="edit_rs451_h('TENKORISKYBRANCHRESULT_H', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"  style="transform: scale(2)" id="chk_rs451_h" name="chk_rs451_h" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs450_h ?> onchange="edit_rs450_h('TENKORISKYBRANCHRESULT_H', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs450_h" name="chk_rs450_h" /></td>
                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKORISKYBRANCHREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKORISKYBRANCHREMARK'] ?></td>

                </tr>
                <tr>
                    <td style="text-align: center">2</td>
                    <td>สายไฟ</td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs461 ?> onchange="edit_rs461('TENKOWIRERESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs461" name="chk_rs461" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs460 ?> onchange="edit_rs460('TENKOWIRERESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs460" name="chk_rs460" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs461_h ?> onchange="edit_rs461_h('TENKOWIRERESULT_H', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"  style="transform: scale(2)" id="chk_rs461_h" name="chk_rs461_h" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs460_h ?> onchange="edit_rs460_h('TENKOWIRERESULT_H', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs460_h" name="chk_rs460_h" /></td>
                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKOWIREREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKOWIREREMARK'] ?></td>
                </tr>
                <tr>
                    <td style="text-align: center">3</td>
                    <td>สภาพถนน,ก่อสร้าง</td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs471 ?> onchange="edit_rs471('TENKOLOADRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs471" name="chk_rs471" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs470 ?> onchange="edit_rs470('TENKOLOADRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs470" name="chk_rs470" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs471_h ?> onchange="edit_rs471_h('TENKOLOADRESULT_H', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"  style="transform: scale(2)" id="chk_rs471_h" name="chk_rs471_h" /></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rs470_h ?> onchange="edit_rs470_h('TENKOLOADRESULT_H', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs470_h" name="chk_rs470_h" /></td>
                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKOLOADREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKOLOADREMARK'] ?></td>
                </tr>

            </tbody>
        </table>

        <?php
    }
}
if ($_POST['txt_flg'] == "select_tenko5emp2") {
    $conditionPlain = " AND a.VEHICLETRANSPORTPLANID = '" . $_POST['vehicletransportplanid'] . "'";
    $sql_sePlain = "{call megVehicletransportplan_v2(?,?)}";
    $params_sePlain = array(
        array('select_vehicletransportplan', SQLSRV_PARAM_IN),
        array($conditionPlain, SQLSRV_PARAM_IN)
    );
    $query_sePlain = sqlsrv_query($conn, $sql_sePlain, $params_sePlain);
    $result_sePlain = sqlsrv_fetch_array($query_sePlain, SQLSRV_FETCH_ASSOC);
    ?>



    <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
        <thead>

            <tr>

                <th colspan="6" ><font style="color: green">พนักงานขับรถ : <?= $result_sePlain['EMPLOYEENAME2'] ?></font></th>

            </tr>

        </thead>
        <tbody>

            <tr>
                <td style="text-align: center">
                    &nbsp;
                </td>
                <td style="text-align: center" >
                    <img src="../images/noimage.jpg" width="200"/>
                </td>
                <td style="text-align: center">
                    <img src="../images/noimage.jpg" width="200"/>
                </td>
                <td style="text-align: center">
                    <img src="../images/noimage.jpg" width="200"/>
                </td>
                <td style="text-align: center">
                    <img src="../images/noimage.jpg" width="200"/>
                </td>
                <td style="text-align: center">
                    <img src="../images/noimage.jpg" width="200"/>
                </td>
                <!--<td width="20%" style="text-align:center">
                    <img src="../upload_imagemap/<?//= $_POST['vehicletransportplanid'] . $_POST['employeecode2'] ?>1.jpg" width="200"/>

                </td>
                <td width="20%" style="text-align:center">
                    <img src="../upload_imagemap/<?//= $_POST['vehicletransportplanid'] . $_POST['employeecode2'] ?>2.jpg" width="200"/>

                </td>
                <td width="20%" style="text-align:center">
                    <img src="../upload_imagemap/<?//= $_POST['vehicletransportplanid'] . $_POST['employeecode2'] ?>3.jpg" width="200"/>

                </td>
                <td width="20%" style="text-align:center">
                    <img src="../upload_imagemap/<?//= $_POST['vehicletransportplanid'] . $_POST['employeecode2'] ?>4.jpg" width="200"/>

                </td>
                <td width="20%" style="text-align:center">
                    <img src="../upload_imagemap/<?//= $_POST['vehicletransportplanid'] . $_POST['employeecode2'] ?>5.jpg" width="200"/>

                </td>
                -->
            </tr>
        </tbody>
    </table>
    <!--</form>-->

    <?php
}
if ($_POST['txt_flg'] == "select_tenko6emp2") {
    $condition1 = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
    $sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEmployee = array(
        array('select_employeeehr2', SQLSRV_PARAM_IN),
        array($condition1, SQLSRV_PARAM_IN)
    );
    $query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
    $result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);
    
    $conditionPlain = " AND a.VEHICLETRANSPORTPLANID = '" . $_POST['vehicletransportplanid'] . "'";
    $sql_sePlain = "{call megVehicletransportplan_v2(?,?)}";
    $params_sePlain = array(
        array('select_vehicletransportplan', SQLSRV_PARAM_IN),
        array($conditionPlain, SQLSRV_PARAM_IN)
    );
    $query_sePlain = sqlsrv_query($conn, $sql_sePlain, $params_sePlain);
    $result_sePlain = sqlsrv_fetch_array($query_sePlain, SQLSRV_FETCH_ASSOC);

    $conditionTenkomaster_temp = " AND VEHICLETRANSPORTPLANID = '" . $_POST['vehicletransportplanid'] . "'";
    $sql_seTenkomaster_temp = "{call megVehicletransportplan_v2(?,?,?,?)}";
    $params_seTenkomaster_temp = array(
        array('select_vehicletransporttenko', SQLSRV_PARAM_IN),
        array($conditionTenkomaster_temp, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seTenkomaster_temp = sqlsrv_query($conn, $sql_seTenkomaster_temp, $params_seTenkomaster_temp);
    $result_seTenkomaster_temp = sqlsrv_fetch_array($query_seTenkomaster_temp, SQLSRV_FETCH_ASSOC);

    $conditionTenkomaster = " AND a.TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "'";
    $sql_seTenkomaster = "{call megEdittenkomaster_v2(?,?)}";
    $params_seTenkomaster = array(
        array('select_tenkomaster', SQLSRV_PARAM_IN),
        array($conditionTenkomaster, SQLSRV_PARAM_IN)
    );
    $query_seTenkomaster = sqlsrv_query($conn, $sql_seTenkomaster, $params_seTenkomaster);
    $result_seTenkomaster = sqlsrv_fetch_array($query_seTenkomaster, SQLSRV_FETCH_ASSOC);

    $conditionTenkogps = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_POST['employeecode2'] . "'";
    $sql_seTenkogps = "{call megEdittenkogps_v2(?,?,?)}";
    $params_seTenkogps = array(
        array('select_tenkogps', SQLSRV_PARAM_IN),
        array($conditionTenkogps, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seTenkogps = sqlsrv_query($conn, $sql_seTenkogps, $params_seTenkogps);
    $result_seTenkogps = sqlsrv_fetch_array($query_seTenkogps, SQLSRV_FETCH_ASSOC);
    ?>

    <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
        <thead>

            <tr>

                <th colspan="5" ><font style="color: green">พนักงานขับรถ :  <?= $result_sePlain['EMPLOYEENAME2'] ?></font></th>
            </tr>
            <tr>
                <th style="text-align: center;">ข้อ</th>
                <th style="text-align: center;height: 35px; width:200px;">หัวข้อ</th>
                <th style="text-align: center;height: 35px; width:180px;">จำนวน</th>
                <th style="text-align: center;">รายละเอียดการชี้แนะ</th>
                <th style="text-align: center;">ลายเซ็น พขร.</th>
            </tr>
        </thead>
        <tbody>
        <tr>
                <td style="text-align: center;height: 35px; width:100px;">1</td>
                <td>ความเร็วเกินกำหนด</td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSSPEEDOVERAMOUNT', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:150px;" class="form-control"  type="text" name="txt_speedoveramountemp1" id="txt_speedoveramountemp1" value="<?= $result_seTenkogps['TENKOGPSSPEEDOVERAMOUNT'] ?>"></td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSSPEEDOVERREMARK', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:500px;" class="form-control"  type="text" name="txt_speedoverremarkemp1" id="txt_speedoverremarkemp1" value="<?= $result_seTenkogps['TENKOGPSSPEEDOVERREMARK'] ?>"></td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSSPEEDOVERDIRVER', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:180px;" class="form-control"  type="text" name="txt_speedoverdriveremp1" id="txt_speedoverdriveremp1" value="<?= $result_seTenkogps['TENKOGPSSPEEDOVERDIRVER'] ?>"></td>
            </tr>
            <tr>
                <td style="text-align: center;height: 35px; width:100px;">2</td>
                <td>เบรคกระทันหัน</td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSBRAKEAMOUNT', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:150px;" class="form-control"  type="text" name="txt_brakeamountemp1" id="txt_brakeamountemp1" value="<?= $result_seTenkogps['TENKOGPSBRAKEAMOUNT'] ?>"></td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSBRAKEREMARK', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:500px;" class="form-control"  type="text" name="txt_brakeremarkemp1" id="txt_brakeremarkemp1" value="<?= $result_seTenkogps['TENKOGPSBRAKEREMARK'] ?>"></td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSBRAKEDIRVER', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:180px;" class="form-control"  type="text" name="txt_brakedriveremp1" id="txt_brakedriveremp1" value="<?= $result_seTenkogps['TENKOGPSBRAKEDIRVER'] ?>"></td>
            </tr>
            <tr>
                <td style="text-align: center;height: 35px; width:100px;">3</td>
                <td>รอบเครื่องเกินกำหนด</td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSSPEEDMACHINEAMOUNT', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:150px;" class="form-control"  type="text" name="txt_gpsspeedmechineamountemp1" id="txt_gpsspeedmechineamountemp1" value="<?= $result_seTenkogps['TENKOGPSSPEEDMACHINEAMOUNT'] ?>"></td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSSPEEDMACHINEREMARK', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:500px;" class="form-control"  type="text" name="txt_gpsspeedmechineremarkemp1" id="txt_gpsspeedmechineremarkemp1" value="<?= $result_seTenkogps['TENKOGPSSPEEDMACHINEREMARK'] ?>"></td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSSPEEDMACHINEDIRVER', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:180px;" class="form-control"  type="text" name="txt_gpsspeedmechinedriveremp1" id="txt_gpsspeedmechinedriveremp1" value="<?= $result_seTenkogps['TENKOGPSSPEEDMACHINEDIRVER'] ?>"></td>
            </tr>
            <tr>
                <td style="text-align: center;height: 35px; width:100px;">4</td>
                <td>วิ่งนอกเส้นทาง</td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSOUTLINEAMOUNT', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:150px;" class="form-control"  type="text" name="txt_outlineamountemp1" id="txt_outlineamountemp1" value="<?= $result_seTenkogps['TENKOGPSOUTLINEAMOUNT'] ?>"></td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSOUTLINEREMARK', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:500px;" class="form-control"  type="text" name="txt_outlineremarkemp1" id="txt_outlineremarkemp1" value="<?= $result_seTenkogps['TENKOGPSOUTLINEREMARK'] ?>"></td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSOUTLINEDIRVER', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:180px;" class="form-control"  type="text" name="txt_outlinedriveremp1" id="txt_outlinedriveremp1" value="<?= $result_seTenkogps['TENKOGPSOUTLINEDIRVER'] ?>"></td>
            </tr>
            <tr>
                <td style="text-align: center;height: 35px; width:100px;">5</td>
                <td>ขับรถต่อเนื่อง 4 ชม.</td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSCONTINUOUSAMOUNT', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:150px;" class="form-control"  type="text" name="txt_continuousamountemp1" id="txt_continuousamountemp1" value="<?= $result_seTenkogps['TENKOGPSCONTINUOUSAMOUNT'] ?>"></td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSCONTINUOUSREMARK', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:500px;" class="form-control"  type="text" name="txt_continuousremarkemp1" id="txt_continuousremarkemp1" value="<?= $result_seTenkogps['TENKOGPSCONTINUOUSREMARK'] ?>"></td>
                <td contenteditable="true" ><input autocomplete="off" onchange="edit_tenkogps(this.value, 'TENKOGPSCONTINUOUSDIRVER', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"  style="height: 35px; width:180px;" class="form-control"  type="text" name="txt_continuousdriveremp1" id="txt_continuousdriveremp1" value="<?= $result_seTenkogps['TENKOGPSCONTINUOUSDIRVER'] ?>"></td>
            </tr>
        </tbody>
    </table>

    <?php
}if ($_POST['txt_flg'] == "save_healthfortenko") {
    ?>

    <?php

    // $sql_savehealthtenko = "{call megEditHealthForTenko(?,?,?,?,?,?,?,?,?,?,?,?)}";
    // $params_savehealthtenko = array(
    // array('save_healthfortenko', SQLSRV_PARAM_IN),
    // array($_POST['TENKOMASTERID'], SQLSRV_PARAM_IN),
    // array($_POST['TENKOMASTERDIRVERCODE'], SQLSRV_PARAM_IN),
    // array($_POST['TENKOSHORTSIGHTCHECK'], SQLSRV_PARAM_IN),
    // array($_POST['TENKOSHORTSIGHTRESULT'], SQLSRV_PARAM_IN),
    // array($_POST['TENKOSHORTSIGHTREMARK'], SQLSRV_PARAM_IN),
    // array($_POST['TENKOLONGSIGHTCHECK'], SQLSRV_PARAM_IN),
    // array($_POST['TENKOLONGSIGHTRESULT'], SQLSRV_PARAM_IN),
    // array($_POST['TENKOLONGSIGHTREMARK'], SQLSRV_PARAM_IN),
    // array($_POST['TENKOOBLIQUESIGHTCHECK'], SQLSRV_PARAM_IN),
    // array($_POST['TENKOOBLIQUESIGHTRESULT'], SQLSRV_PARAM_IN),
    // array($_POST['TENKOOBLIQUESIGHTREMARK'], SQLSRV_PARAM_IN)
    // );

    // $query_savehealthtenko= sqlsrv_query($conn, $sql_savehealthtenko, $params_savehealthtenko);
    // $result_savehealthtenko = sqlsrv_fetch_array($query_savehealthtenko, SQLSRV_FETCH_ASSOC);

    $sql_savehealthtenko = "{call megEditHealthForTenko(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params_savehealthtenko = array(
    array('save_healthfortenko_eyeproblem', SQLSRV_PARAM_IN),
    array($_POST['TENKOMASTERID'], SQLSRV_PARAM_IN),
    array($_POST['TENKOMASTERDIRVERCODE'], SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array($_POST['TENKOEYEPROBLEMCHECK'], SQLSRV_PARAM_IN),
    array($_POST['TENKOEYEPROBLEMRESULT'], SQLSRV_PARAM_IN),
    array($_POST['TENKOEYEPROBLEMREMARK'], SQLSRV_PARAM_IN)
    );

    $query_savehealthtenko= sqlsrv_query($conn, $sql_savehealthtenko, $params_savehealthtenko);
    $result_savehealthtenko = sqlsrv_fetch_array($query_savehealthtenko, SQLSRV_FETCH_ASSOC);

    ?>



    <?php
  }
  if ($_POST['txt_flg'] == "select_reportdatetimetenkocheck") {
    ?>

<table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
      <thead>
      <tr>
        <th>NO11</th>
        <th>COMPANYCODE</th>
        <th>CUSTOMERCODE</th>
        <th>WORKTYPE</th>
        <th>CARRYTYPE</th>
        <th>DRIVER(1)(คน)</th>
        <th>DRIVER(2)(คน)</th>
        <th>PRESENT(คน)</th>
        
    </tr>
      </thead>
      <tbody>
      
        <?php
       
        $sql_sePlan = "SELECT COUNT(VEHICLETRANSPORTPLANID) AS 'COUNTPLAN'
        FROM VEHICLETRANSPORTPLAN 
        WHERE COMPANYCODE ='" . $_POST['companycode'] . "'  
        AND EMPLOYEECODE1 IS NOT NULL
        AND CONVERT(VARCHAR(10),DATEWORKING,103) = CONVERT(VARCHAR(10),'" . $_POST['startdate'] . "',103)";
        $query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
        $result_sePlan = sqlsrv_fetch_array($query_sePlan, SQLSRV_FETCH_ASSOC);          
            
        $i = 1;
        $emp1 = 0;
        $emp2 = 0;
        $empintime1 = 0;
        $sql_seData = "SELECT DISTINCT COMPANYCODE,CUSTOMERCODE,WORKTYPE,CARRYTYPE
        FROM VEHICLETRANSPORTPRICE WHERE COMPANYCODE ='" . $_POST['companycode'] . "' 
        ORDER BY CUSTOMERCODE ASC";
        $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);
        while ($result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC)) {

        //นับพนักงานคนที่1
        $sql_seDisemp1 = "SELECT COUNT(DISTINCT EMPLOYEECODE1) AS 'EMP1'
        FROM VEHICLETRANSPORTPLAN 
        WHERE COMPANYCODE ='" . $_POST['companycode'] . "'  
        AND CUSTOMERCODE ='".$result_seData['CUSTOMERCODE']."'
        AND EMPLOYEECODE1 IS NOT NULL
        AND CONVERT(VARCHAR(10),DATEWORKING,103) = CONVERT(VARCHAR(10),'" . $_POST['startdate'] . "',103)";
        $query_seDisemp1 = sqlsrv_query($conn, $sql_seDisemp1, $params_seDisemp1);
        $result_seDisemp1 = sqlsrv_fetch_array($query_seDisemp1, SQLSRV_FETCH_ASSOC);
        
        
        
        //นับพนักงานคนที่2
        $sql_seDisemp2 = "SELECT COUNT(DISTINCT EMPLOYEECODE2) AS 'EMP2'
        FROM VEHICLETRANSPORTPLAN 
        WHERE COMPANYCODE ='" . $_POST['companycode'] . "'  
        AND CUSTOMERCODE ='".$result_seData['CUSTOMERCODE']."'
        AND EMPLOYEECODE2 IS NOT NULL
        AND CONVERT(VARCHAR(10),DATEWORKING,103) = CONVERT(VARCHAR(10),'" . $_POST['startdate'] . "',103)";
        $query_seDisemp2 = sqlsrv_query($conn, $sql_seDisemp2, $params_seDisemp2);
        $result_seDisemp2 = sqlsrv_fetch_array($query_seDisemp2, SQLSRV_FETCH_ASSOC);
         

        // $sql_seDisemp11 = "SELECT COUNT(DISTINCT a.EMPLOYEECODE1) AS 'COUNTINTIME1'
        // FROM VEHICLETRANSPORTPLAN a
        // INNER JOIN [203.150.225.30].[TigerWebServer].dbo.ZFP_TimeInOut b ON a.EMPLOYEECODE1 = b.PersonCardID
        // WHERE a.COMPANYCODE ='" . $_POST['companycode'] . "'  
        // AND a.CUSTOMERCODE ='".$result_seData['CUSTOMERCODE']."'
        // AND a.EMPLOYEECODE1 IS NOT NULL
        // AND CONVERT(VARCHAR(10),a.DATEWORKING,103) BETWEEN CONVERT(VARCHAR(10),'" . $_POST['startdate'] . "',103) AND CONVERT(VARCHAR(10),'" . $_POST['startdate'] . "',103)
        // AND CONVERT(VARCHAR(10),b.TimeInout,103)  = '" . $_POST['startdate'] . "'
        // AND b.InOutMode = 'I'";
        // $query_seDisemp11 = sqlsrv_query($conn, $sql_seDisemp11, $params_seDisemp11);
        // $result_seDisemp11 = sqlsrv_fetch_array($query_seDisemp11, SQLSRV_FETCH_ASSOC);
        

        // $sql_seDisemp12 = "SELECT COUNT(DISTINCT a.EMPLOYEECODE2) AS 'COUNTINTIME2'
        // FROM VEHICLETRANSPORTPLAN a
        // INNER JOIN [203.150.225.30].[TigerWebServer].dbo.ZFP_TimeInOut b ON a.EMPLOYEECODE1 = b.PersonCardID
        // WHERE a.COMPANYCODE ='" . $_POST['companycode'] . "'  
        // AND a.CUSTOMERCODE ='".$result_seData['CUSTOMERCODE']."'
        // AND a.EMPLOYEECODE2 IS NOT NULL
        // AND CONVERT(VARCHAR(10),a.DATEWORKING,103) BETWEEN CONVERT(VARCHAR(10),'" . $_POST['startdate'] . "',103) AND CONVERT(VARCHAR(10),'" . $_POST['startdate'] . "',103)
        // AND CONVERT(VARCHAR(10),b.TimeInout,103)  = '" . $_POST['startdate'] . "'
        // AND b.InOutMode = 'I'";
        // $query_seDisemp12 = sqlsrv_query($conn, $sql_seDisemp12, $params_seDisemp12);
        // $result_seDisemp12 = sqlsrv_fetch_array($query_seDisemp12, SQLSRV_FETCH_ASSOC);

         ?>

              <tr>
                <td style="text-align: center"><?=$i?></td>
                <td><?=$result_seData['COMPANYCODE']?></td>
                <td><?=$result_seData['CUSTOMERCODE']?></td>
                <td><?=$result_seData['WORKTYPE']?></td>
                <td><?=$result_seData['CARRYTYPE']?></td>
                <td><?=$result_seDisemp1['EMP1']?></td>
                <td><?=$result_seDisemp2['EMP2']?></td>
                <td><?=$result_seDisemp11['COUNTINTIME1']+$result_seDisemp12['COUNTINTIME2']?></td>
              </tr>
              <?php
              $i++; 
              $emp1 = $emp1+$result_seDisemp1['EMP1'];
              $emp2 = $emp2+$result_seDisemp2['EMP2'];  


            }
            ?>
          </tbody>
        </table>
        <div class="col-lg-12">
            <input type="text" name="se_plan" id="se_plan" value="<?=$result_sePlan['COUNTPLAN']?>" style="display:none">
            <input type="text" name="se_driver1" id="se_driver1" value="<?=$emp1?>" style="display:none">
            <input type="text"  name="se_driver2" id="se_driver2" value="<?=$emp2?>" style="display:none">
            
        </div>
    <?php
    }
    if ($_POST['txt_flg'] == "select_dateworkinggrater14hour") {
   ?>
   
       <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example2" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
           <thead>
               <tr>
                   <th>ลำดับ</th>
                   <th  width="10%">รหัสแจ้งสุขภาพ</th>
                   <th  width="10%">รหัสพนักงาน</th>
                   <th  width="15%">ชื่อ-นามสกุล</th>
                   <th  width="25%">เลขที่งาน</th>
                   <th  width="15%">ต้นทาง</th>
                   <th  width="15%">ปลายทาง</th>
                   <!-- <th>ต้นทาง(แผนสอง)</th>
                   <th>ปลายทาง(แผนสอง)</th> -->
                   <th width="15%">วันที่</th>
                   <th width="50%">เวลาเริ่มงาน</th>
                   <th width="20%">เวลาเลิกงาน</th>
                   <th width="20%">รวมเวลาปฎิบัติงาน</th>
               </tr>
           </thead>
           <tbody>
         
                   <?php
                   $i = 1;

                   
                   $sql_seRoute = "SELECT  JOBNO,JOBSTART,JOBEND,ROW_NUMBER() OVER(ORDER BY JOBNO ASC) AS 'ROW' FROM VEHICLETRANSPORTPLAN 
                        WHERE CONVERT(DATE,DATEWORKING,103) = CONVERT(DATE,'" . $_POST['startdate'] . "',103)
                        AND (EMPLOYEECODE1 ='" . $_POST['drivercode'] . "' OR EMPLOYEECODE2 ='" . $_POST['drivercode'] . "' )
                        ORDER BY JOBNO ASC";
                   $query_seRoute = sqlsrv_query($conn, $sql_seRoute, $params_seRoute);
                   while ($result_seRoute = sqlsrv_fetch_array($query_seRoute, SQLSRV_FETCH_ASSOC)) {          
                       
                   
                   //ค้นหาข้อมูลแผนงานประจำวันที่นั้นๆ แผนงานแรก
                   $sql_seData = "SELECT a.SELFCHECKID,a.EMPLOYEECODE,a.EMPLOYEENAME,a.DATEWORKING,
                    REPLACE(a.SLEEPRESTEND, 'T', ' ') AS 'DATETIMESTARTWORKING',
                    REPLACE(a.KEYDROPTIME, 'T', ' ') AS 'DATETIMEENDWORKING',
                    a.TIMEWORKING,a.TIMEWORKINGSTATUS,b.PositionNameT
                    FROM DRIVERSELFCHECK a 
                    INNER JOIN EMPLOYEEEHR2 b ON b.PersonCode = a.EMPLOYEECODE
                    WHERE  a.EMPLOYEECODE ='" . $_POST['drivercode'] . "'
                    AND CONVERT(DATE,DATEWORKING,103) = CONVERT(DATE,'" . $_POST['startdate'] . "',103) 
                    ORDER BY CONVERT(DATE,a.DATEWORKING,103),a.EMPLOYEECODE,b.PositionNameT ASC";
                   $query_seData = sqlsrv_query($conn, $sql_seData, $params_seseData);
                   $result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC);
                   
                   
                     //ค้นหาข้อมูลแผนงานประจำวันที่นั้นๆ แผนงานที่สอง
                   // $sql_seRoute2 = "SELECT TOP 1 JOBNO,JOBSTART,JOBEND FROM VEHICLETRANSPORTPLAN 
                   // WHERE  CONVERT(DATE,DATEWORKING,103) = CONVERT(DATE,'".$result_seData['DATEWORKING']."',103)
                   // AND (EMPLOYEECODE1 ='".$result_seData['EMPLOYEECODE']."' OR EMPLOYEECODE2 ='".$result_seData['EMPLOYEECODE']."' )
                   // ORDER BY JOBNO DESC";
                   // $query_seRoute2 = sqlsrv_query($conn, $sql_seRoute2, $params_seRoute2);
                   // $result_seRoute2 = sqlsrv_fetch_array($query_seRoute2, SQLSRV_FETCH_ASSOC);

                   
           
                   ?>
   
                 <tr>
                   <td style="text-align: center"><?=$i?></td>
                   <td><?=$result_seData['SELFCHECKID']?></td>
                   <td><?=$result_seData['EMPLOYEECODE']?></td>
                   <td><?=$result_seData['EMPLOYEENAME']?></td>
                   <td><?=$result_seRoute['JOBNO']?></td>
                   <td><?=$result_seRoute['JOBSTART']?></td>
                   <td><?=$result_seRoute['JOBEND']?></td>
                   <td><?=$result_seData['DATEWORKING']?></td>
                   <td width="10%"><?=$result_seData['DATETIMESTARTWORKING']?></td>
                   <td width="10%"><?=$result_seData['DATETIMEENDWORKING']?></td>
                   <?php
                   if ($result_seData['TIMEWORKINGSTATUS'] == 'OK') {
                   ?>
                   <td style="color:green;"><?=$result_seData['TIMEWORKING']?></td>
                   <?php
                   }else{
                   ?>
                   <td style="color:red;"><?=$result_seData['TIMEWORKING']?></td>
                   <?php
                   }
                   ?>
                   
                 </tr>
                 <?php
                 $i++; 
               //   $emp1 = $emp1+$result_seDisemp1['EMP1'];
               //   $emp2 = $emp2+$result_seDisemp2['EMP2'];  
   
   
               }
               ?>
           </tbody>
       </table>
       
       <?php
       }
     if ($_POST['txt_flg'] == "select_datetimeworking") {
    ?>
    
        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>รหัสแจ้งสุขภาพ</th>
                    <th>รหัสพนักงาน</th>
                    <th>ชื่อ-นามสกุล</th>
                    <th>ต้นทาง</th>
                    <th>ปลายทาง</th>
                    <!-- <th>ต้นทาง(แผนสอง)</th>
                    <th>ปลายทาง(แผนสอง)</th> -->
                    <th>วันที่</th>
                    <th>เวลาเริ่มงาน</th>
                    <th>เวลาเลิกงาน</th>
                    <th>รวมเวลาปฎิบัติงาน</th>
                </tr>
            </thead>
            <tbody>
          
                    <?php
                    $i = 1;

                    if ($_POST['area'] == 'amt') {

                        if ($_POST['companycode'] == '00') {
                            # 00 คือ บริษัททั้งหมด RKS,RKR,RKL
                            $sql_seData = "SELECT a.SELFCHECKID,a.EMPLOYEECODE,a.EMPLOYEENAME,a.DATEWORKING,
                                REPLACE(a.SLEEPRESTEND, 'T', ' ') AS 'DATETIMESTARTWORKING',
                                REPLACE(a.KEYDROPTIME, 'T', ' ') AS 'DATETIMEENDWORKING',
                                a.TIMEWORKING,a.TIMEWORKINGSTATUS,b.PositionNameT
                                FROM DRIVERSELFCHECK a 
                                INNER JOIN EMPLOYEEEHR2 b ON b.PersonCode = a.EMPLOYEECODE
                                WHERE   SUBSTRING(a.EMPLOYEECODE, 0, 3) IN ('01','02','07')
                                AND CONVERT(DATE,a.DATEWORKING,103) BETWEEN CONVERT(DATE,'".$_POST['startdate']."',103) AND CONVERT(DATE,'".$_POST['enddate']."',103)
                                ORDER BY CONVERT(DATE,a.DATEWORKING,103),a.EMPLOYEECODE,b.PositionNameT ASC";

                        }else{
                            $sql_seData = "SELECT a.SELFCHECKID,a.EMPLOYEECODE,a.EMPLOYEENAME,a.DATEWORKING,
                                REPLACE(a.SLEEPRESTEND, 'T', ' ') AS 'DATETIMESTARTWORKING',
                                REPLACE(a.KEYDROPTIME, 'T', ' ') AS 'DATETIMEENDWORKING',
                                a.TIMEWORKING,a.TIMEWORKINGSTATUS,b.PositionNameT
                                FROM DRIVERSELFCHECK a 
                                INNER JOIN EMPLOYEEEHR2 b ON b.PersonCode = a.EMPLOYEECODE
                                WHERE   SUBSTRING(a.EMPLOYEECODE, 0, 3) ='".$_POST['companycode']."'
                                AND CONVERT(DATE,a.DATEWORKING,103) BETWEEN CONVERT(DATE,'".$_POST['startdate']."',103) AND CONVERT(DATE,'".$_POST['enddate']."',103)
                                ORDER BY CONVERT(DATE,a.DATEWORKING,103),a.EMPLOYEECODE,b.PositionNameT ASC";


                        }

                    }else {

                        if ($_POST['companycode'] == '00') {
                            # 00 คือ บริษัททั้งหมด RKS,RKR,RKL
                            $sql_seData = "SELECT a.SELFCHECKID,a.EMPLOYEECODE,a.EMPLOYEENAME,a.DATEWORKING,
                                REPLACE(a.SLEEPRESTEND, 'T', ' ') AS 'DATETIMESTARTWORKING',
                                REPLACE(a.KEYDROPTIME, 'T', ' ') AS 'DATETIMEENDWORKING',
                                a.TIMEWORKING,a.TIMEWORKINGSTATUS,b.PositionNameT
                                FROM DRIVERSELFCHECK a 
                                INNER JOIN EMPLOYEEEHR2 b ON b.PersonCode = a.EMPLOYEECODE
                                WHERE   SUBSTRING(a.EMPLOYEECODE, 0, 3) IN ('04','05','09')
                                AND CONVERT(DATE,a.DATEWORKING,103) BETWEEN CONVERT(DATE,'".$_POST['startdate']."',103) AND CONVERT(DATE,'".$_POST['enddate']."',103)
                                ORDER BY CONVERT(DATE,a.DATEWORKING,103),a.EMPLOYEECODE,b.PositionNameT ASC";

                        }else{
                            $sql_seData = "SELECT a.SELFCHECKID,a.EMPLOYEECODE,a.EMPLOYEENAME,a.DATEWORKING,
                                REPLACE(a.SLEEPRESTEND, 'T', ' ') AS 'DATETIMESTARTWORKING',
                                REPLACE(a.KEYDROPTIME, 'T', ' ') AS 'DATETIMEENDWORKING',
                                a.TIMEWORKING,a.TIMEWORKINGSTATUS,b.PositionNameT
                                FROM DRIVERSELFCHECK a 
                                INNER JOIN EMPLOYEEEHR2 b ON b.PersonCode = a.EMPLOYEECODE
                                WHERE   SUBSTRING(a.EMPLOYEECODE, 0, 3) ='".$_POST['companycode']."'
                                AND CONVERT(DATE,a.DATEWORKING,103) BETWEEN CONVERT(DATE,'".$_POST['startdate']."',103) AND CONVERT(DATE,'".$_POST['enddate']."',103)
                                ORDER BY CONVERT(DATE,a.DATEWORKING,103),a.EMPLOYEECODE,b.PositionNameT ASC";


                        }
                    }
                            

                    
                    
                    $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);
                    while ($result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC)) {          
                        
                    
            
                    //ค้นหาข้อมูลแผนงานประจำวันที่นั้นๆ แผนงานแรก
                    $sql_seRoute1 = "SELECT TOP 1 JOBNO,JOBSTART,JOBEND FROM VEHICLETRANSPORTPLAN 
                    WHERE CONVERT(DATE,DATEWORKING,103) = CONVERT(DATE,'".$result_seData['DATEWORKING']."',103)
                    AND (EMPLOYEECODE1 ='".$result_seData['EMPLOYEECODE']."' OR EMPLOYEECODE2 ='".$result_seData['EMPLOYEECODE']."' )
                    ORDER BY JOBNO ASC";
                    $query_seRoute1 = sqlsrv_query($conn, $sql_seRoute1, $params_seRoute1);
                    $result_seRoute1 = sqlsrv_fetch_array($query_seRoute1, SQLSRV_FETCH_ASSOC);
                    
                    
                      //ค้นหาข้อมูลแผนงานประจำวันที่นั้นๆ แผนงานที่สอง
                    // $sql_seRoute2 = "SELECT TOP 1 JOBNO,JOBSTART,JOBEND FROM VEHICLETRANSPORTPLAN 
                    // WHERE  CONVERT(DATE,DATEWORKING,103) = CONVERT(DATE,'".$result_seData['DATEWORKING']."',103)
                    // AND (EMPLOYEECODE1 ='".$result_seData['EMPLOYEECODE']."' OR EMPLOYEECODE2 ='".$result_seData['EMPLOYEECODE']."' )
                    // ORDER BY JOBNO DESC";
                    // $query_seRoute2 = sqlsrv_query($conn, $sql_seRoute2, $params_seRoute2);
                    // $result_seRoute2 = sqlsrv_fetch_array($query_seRoute2, SQLSRV_FETCH_ASSOC);

                    
            
                    ?>
    
                  <tr>
                    <td style="text-align: center"><?=$i?></td>
                    <td><?=$result_seData['SELFCHECKID']?></td>
                    <td><?=$result_seData['EMPLOYEECODE']?></td>
                    <td><?=$result_seData['EMPLOYEENAME']?></td>
                    <td><?=$result_seRoute1['JOBSTART']?></td>
                    <td><?=$result_seRoute1['JOBEND']?></td>
                    <!-- <td><?=$result_seRoute2['JOBSTART']?></td>
                    <td><?=$result_seRoute2['JOBEND']?></td> -->
                    <td><?=$result_seData['DATEWORKING']?></td>
                    <td><?=$result_seData['DATETIMESTARTWORKING']?></td>
                    <td><?=$result_seData['DATETIMEENDWORKING']?></td>
                    <?php
                    if ($result_seData['TIMEWORKINGSTATUS'] == 'OK') {
                    ?>
                    <td style="color:green;"><?=$result_seData['TIMEWORKING']?></td>
                    <?php
                    }else{
                    ?>
                    <td style="color:red;"><?=$result_seData['TIMEWORKING']?></td>
                    <?php
                    }
                    ?>
                    
                  </tr>
                  <?php
                  $i++; 
                //   $emp1 = $emp1+$result_seDisemp1['EMP1'];
                //   $emp2 = $emp2+$result_seDisemp2['EMP2'];  
    
    
                }
                ?>
            </tbody>
        </table>
        <div class="col-lg-12">
            <input type="text" name="se_plan" id="se_plan" value="<?=$result_sePlan['COUNTPLAN']?>" style="display:none">
            <input type="text" name="se_driver1" id="se_driver1" value="<?=$emp1?>" style="display:none">
            <input type="text"  name="se_driver2" id="se_driver2" value="<?=$emp2?>" style="display:none">
            
        </div>
        <?php
        }
  if ($_POST['txt_flg'] == "select_driverchecking") {
    ?>

  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
      <thead>
          <tr>
              <th>ทะเบียนรถ</th>
              <th>วันที่</th>
              <th>ตรวจสอบ</th>
              <th>เลขที่</th>
              <th>พนักงานคนที่1</th>
              <th>พนักงานคนที่2</th>
             
          </tr>
      </thead>
      <tbody>
      <?php
      $sql_seData = "SELECT TENKOMASTERID,TENKOBEFOREID,TENKOTRANSPORTID,FORMAT (DATEWORKING, 'dd-MM-yyyy') AS 'DATE',
        TENKOAFTERID,VEHICLETRANSPORTPLANID,JOBNO,EMPLOYEECODE1,EMPLOYEENAME1,EMPLOYEECODE2,EMPLOYEENAME2
        FROM [dbo].[VEHICLETRANSPORTPLAN] 
        WHERE  CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'".$_POST['datestart']."',103)
        AND( VEHICLEREGISNUMBER1 ='".$_POST['thainame']."' OR THAINAME ='".$_POST['thainame']."')";
      $params_seData = array();
      $query_seData  = sqlsrv_query($conn, $sql_seData, $params_seData);
      while ($result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC)){
      
      ?>

      <tr>
          <td><?=$_POST['thainame']?></td>
          <td><?=$result_seData['DATE']?></td>
          <td style="text-align: center;" ><button type="button" class="btn btn-info btn-md" name="myBtn" id ="myBtn" data-toggle="modal" data-target="#myModal" onclick="checking_data('<?= $result_seData['TENKOMASTERID'] ?>','<?= $result_seData['EMPLOYEECODE1'] ?>','<?= $result_seData['EMPLOYEECODE2'] ?>','<?= $result_seData['JOBNO'] ?>','<?= $_POST['thainame'] ?>');" >ดูรายละเอียด</button></td>
          <td><?=$result_seData['JOBNO']?></td>
          <td><?=$result_seData['EMPLOYEENAME1']?></td>
          <td><?=$result_seData['EMPLOYEENAME2']?></td>
      </tr>
      <?php
          $i++;
        }
      ?>
      </tbody>
  </table>

    <?php
}
if ($_POST['txt_flg'] == "save_actualdate_tenkobefore") {

    
    $sql_chkdata = "SELECT ACTUALTENKODATE AS 'ACTUALDATECHK' FROM TENKOBEFORE 
        WHERE TENKOMASTERID ='" . $_POST['tenkomasterid'] . "'
        AND TENKOBEFOREID ='" . $_POST['tenkobeforeid'] . "'";
    $query_chkdata= sqlsrv_query($conn, $sql_chkdata, $params_chkdata);
    $result_chkdata = sqlsrv_fetch_array($query_chkdata, SQLSRV_FETCH_ASSOC);
    
    if ($result_chkdata['ACTUALDATECHK'] == NULL || $result_chkdata['ACTUALDATECHK'] == '' ) {
        // echo "1";
        $sql_updatedata = "UPDATE TENKOBEFORE
            SET ACTUALTENKOBY = '" . $_POST['actualtenkoby'] . "' ,ACTUALTENKODATE = GETDATE()
            WHERE TENKOMASTERID ='" . $_POST['tenkomasterid'] . "'
            AND TENKOBEFOREID ='" . $_POST['tenkobeforeid'] . "'";
        $query_updatedata  = sqlsrv_query($conn, $sql_updatedata, $params_updatedata);
        $result_updatedata = sqlsrv_fetch_array($query_updatedata, SQLSRV_FETCH_ASSOC);    
    }else {
        // echo "2";
    }
    //   echo $result['TIMEREST'];
    
}
if ($_POST['txt_flg'] == "save_actualdate_tenkotransport") {

    $sql_chkdata = "SELECT ACTUALTENKODATE AS 'ACTUALDATECHK' FROM TENKOTRANSPORT WHERE TENKOMASTERID ='" . $_POST['tenkomasterid'] . "'
        AND TENKOTRANSPORTID ='" . $_POST['tenkotransportid'] . "'";
    $query_chkdata= sqlsrv_query($conn, $sql_chkdata, $params_chkdata);
    $result_chkdata = sqlsrv_fetch_array($query_chkdata, SQLSRV_FETCH_ASSOC);
    
    if ($result_chkdata['ACTUALDATECHK'] == NULL || $result_chkdata['ACTUALDATECHK'] == '' ) {
        // echo "1";
        $sql_updatedata = "UPDATE TENKOTRANSPORT
            SET ACTUALTENKOBY = '" . $_POST['actualtenkoby'] . "' ,ACTUALTENKODATE = GETDATE()
            WHERE TENKOMASTERID ='" . $_POST['tenkomasterid'] . "'
            AND TENKOTRANSPORTID ='" . $_POST['tenkotransportid'] . "'";
        $query_updatedata  = sqlsrv_query($conn, $sql_updatedata, $params_updatedata);
        $result_updatedata = sqlsrv_fetch_array($query_updatedata, SQLSRV_FETCH_ASSOC);    
    }else {
        // echo "2";
    }
    //   echo $result['TIMEREST'];
    
}
if ($_POST['txt_flg'] == "save_keydroptime_test") {

    
        $sql_updatedata = "UPDATE DRIVERSELFCHECK 
        SET KEYDROPTIME='',TIMEWORKING=''
        WHERE SELFCHECKID ='" . $_POST['selfcheckid'] . "'";
        $query_updatedata  = sqlsrv_query($conn, $sql_updatedata, $params_updatedata);
        $result_updatedata = sqlsrv_fetch_array($query_updatedata, SQLSRV_FETCH_ASSOC);    
    
    //   echo $result['TIMEREST'];
    
}
if ($_POST['txt_flg'] == "save_actualdate_tenkoafter") {

    $sql_chkdata = "SELECT ACTUALTENKODATE AS 'ACTUALDATECHK' FROM TENKOAFTER WHERE TENKOMASTERID ='" . $_POST['tenkomasterid'] . "'
    AND TENKOAFTERID ='" . $_POST['tenkoafterid'] . "'";
    $query_chkdata= sqlsrv_query($conn, $sql_chkdata, $params_chkdata);
    $result_chkdata = sqlsrv_fetch_array($query_chkdata, SQLSRV_FETCH_ASSOC);
    
    if ($result_chkdata['ACTUALDATECHK'] == NULL || $result_chkdata['ACTUALDATECHK'] == '' ) {
        // echo "1";
        $sql_updatedata = "UPDATE TENKOAFTER
            SET ACTUALTENKOBY = '" . $_POST['actualtenkoby'] . "' ,ACTUALTENKODATE = GETDATE()
            WHERE TENKOMASTERID ='" . $_POST['tenkomasterid'] . "'
            AND TENKOAFTERID ='" . $_POST['tenkoafterid'] . "'";
        $query_updatedata  = sqlsrv_query($conn, $sql_updatedata, $params_updatedata);
        $result_updatedata = sqlsrv_fetch_array($query_updatedata, SQLSRV_FETCH_ASSOC);    
    }else {
        // echo "2";
    }
    //   echo $result['TIMEREST'];
    
}
if ($_POST['txt_flg'] == "update_selfcheck") {

    $sqlselfcheckupdate = "UPDATE DRIVERSELFCHECK
        SET ".$_POST['fieldname']." = '" . $_POST['editableObj'] . "'
        WHERE SELFCHECKID = '" . $_POST['selfcheckid'] . "'";
    $queryselfcheckupdate = sqlsrv_query($conn, $sqlselfcheckupdate, $paramsselfcheckupdate);
    $resultselfcheckupdate = sqlsrv_fetch_array($queryselfcheckupdate, SQLSRV_FETCH_ASSOC);
      
    //   echo $result['TIMEREST'];
      
  }
if ($_POST['txt_flg'] == "select_resttimeselfcheck") {
  //$sql = "SELECT DATEDIFF(HOUR,'" . $_POST['startsleep'] . "','" . $_POST['endsleep'] . "')  AS 'TIMEREST'";
  //$sql = "SELECT DATEDIFF(HOUR,'" . $_POST['startsleep'] . "','" . $_POST['endsleep'] . "')  AS 'TIMEREST',
  //          RIGHT(CONVERT(VARCHAR(5), DATEADD(MINUTE, DATEDIFF(MINUTE, '" . $_POST['startsleep'] . "', '" . $_POST['endsleep'] . "'), 0), 114),2) AS 'TIMEREST2'";
  //$sql = "SELECT CONVERT(VARCHAR(5), DATEADD(MINUTE, DATEDIFF(MINUTE, '" . $_POST['startrest'] . "', '" . $_POST['endrest'] . "'), 0), 114) AS 'TIMEREST'";
   // $sql = "SELECT CASE WHEN CONVERT(VARCHAR(3), DATEDIFF(MINUTE, '" . $_POST['startsleep'] . "', '" . $_POST['endsleep'] . "') / 60) > 59 THEN CONVERT(VARCHAR(3), DATEDIFF(MINUTE, '" . $_POST['startsleep'] . "', '" . $_POST['endsleep'] . "') / 60) ELSE CONVERT(VARCHAR(3), DATEDIFF(MINUTE, '" . $_POST['startsleep'] . "', '" . $_POST['endsleep'] . "') / 60 % 60) END+':'+CONVERT(VARCHAR(3), DATEDIFF(MINUTE, '" . $_POST['startsleep'] . "', '" . $_POST['endsleep'] . "') % 60) AS 'TIMEREST'";
    $sql = "SELECT CASE WHEN CONVERT(VARCHAR(3), DATEDIFF(MINUTE, CONVERT(NVARCHAR(10),'" . $_POST['startsleep'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['startsleep'] . "',14),5), CONVERT(NVARCHAR(10),'" . $_POST['endsleep'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['endsleep'] . "',14),5)) / 60) > 59 THEN CONVERT(VARCHAR(3), 
    DATEDIFF(MINUTE, CONVERT(NVARCHAR(10),'" . $_POST['startsleep'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['startsleep'] . "',14),5), CONVERT(NVARCHAR(10),'" . $_POST['endsleep'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['endsleep'] . "',14),5)) / 60) ELSE CONVERT(VARCHAR(3), 
    DATEDIFF(MINUTE, CONVERT(NVARCHAR(10),'" . $_POST['startsleep'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['startsleep'] . "',14),5), CONVERT(NVARCHAR(10),'" . $_POST['endsleep'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['endsleep'] . "',14),5)) / 60 % 60) END+':'
    +CONVERT(VARCHAR(3), DATEDIFF(MINUTE, CONVERT(NVARCHAR(10),'" . $_POST['startsleep'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['startsleep'] . "',14),5), CONVERT(NVARCHAR(10),'" . $_POST['endsleep'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['endsleep'] . "',14),5)) % 60) AS 'TIMEREST'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    
    echo $result['TIMEREST'];
    
}
if ($_POST['txt_flg'] == "save_timeworking") {
  
    $sql = "UPDATE DRIVERSELFCHECK 
    SET TIMEWORKING = '" . $_POST['value'] . "',TIMEWORKINGSTATUS = '" . $_POST['status'] . "' 
    WHERE SELFCHECKID ='" . $_POST['selfcheckid'] . "'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    
    // echo $result['TIMEREST'];
    
}if ($_POST['txt_flg'] == "update_keydroptimebyofficer") {

    $sqlcheck = "SELECT TOP 1  SELFCHECKID AS 'SELFCHECKID' 
    FROM DRIVERSELFCHECK WHERE EMPLOYEECODE ='" . $_POST['employeecode'] . "' 
    AND SELFCHECKID < '" . $_POST['selfchkid'] . "'
	AND ACTIVESTATUS ='1'
    ORDER BY SELFCHECKID DESC";
    $querycheck = sqlsrv_query($conn, $sqlcheck, $paramscheck);
    $resultcheck = sqlsrv_fetch_array($querycheck, SQLSRV_FETCH_ASSOC);

    $sqlupdate = "UPDATE DRIVERSELFCHECK
        SET KEYDROPTIME ='" . $_POST['dsreststartchk'] . "'
        WHERE EMPLOYEECODE ='" . $_POST['employeecode'] . "'
        AND SELFCHECKID = '" . $resultcheck['SELFCHECKID'] . "'";
    $queryupdate = sqlsrv_query($conn, $sqlupdate, $paramsupdate);
    $resultupdate = sqlsrv_fetch_array($queryupdate, SQLSRV_FETCH_ASSOC);
      
    //   echo $result['TIMEREST'];
      
  }

  if ($_POST['txt_flg'] == "update_dateselfcheck_byadmin") {

        if ( $_POST['feildname'] == 'DATEWORKING') {

            $sql = "UPDATE DRIVERSELFCHECK 
            SET DATEWORKING = '" . $_POST['value'] . "'
            WHERE SELFCHECKID ='" . $_POST['selfcheckid'] . "'";
            $query = sqlsrv_query($conn, $sql, $params);
            $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);

        }else {
            $sql = "UPDATE DRIVERSELFCHECK 
            SET DATEPRESENT = '" . $_POST['value'] . "'
            WHERE SELFCHECKID ='" . $_POST['selfcheckid'] . "'";
            $query = sqlsrv_query($conn, $sql, $params);
            $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);

        }
    
    // echo $result['TIMEREST'];
    
}
if ($_POST['txt_flg'] == "save_selfcheckdetail") {
  ?>

  <?php

  $sql_saveselfcheck = "{call megSelfCheck(?,?,?,?,?,?,?,?,?,?,
                                            ?,?,?,?,?,?,?,?,?,?,
                                            ?,?,?,?,?,?,?,?,?,?,
                                            ?,?,?,?,?,?,?,?,?,?,
                                            ?,?,?,?,?,?,?,?,?,?,
                                            ?,?,?,?,?,?,?,?,?,?,
                                            ?,?,?,?,?,?,?,?,?)}"; 
  $params_saveselfcheck = array(
  array('save_selfcheckdetail', SQLSRV_PARAM_IN),
  array($_POST['id'], SQLSRV_PARAM_IN),
  array($_POST['employeecode'], SQLSRV_PARAM_IN),
  array($_POST['employeename'], SQLSRV_PARAM_IN),
  array($_POST['datejobstart'], SQLSRV_PARAM_IN),
  array($_POST['dateworking'], SQLSRV_PARAM_IN),
  array($_POST['datepresent'], SQLSRV_PARAM_IN),
  array($_POST['tierdyeschk'], SQLSRV_PARAM_IN),
  array($_POST['tierdnochk'], SQLSRV_PARAM_IN),
  array($_POST['illnessyeschk'], SQLSRV_PARAM_IN),

  array($_POST['illnessnochk'], SQLSRV_PARAM_IN),
  array($_POST['drowseyeschk'], SQLSRV_PARAM_IN),
  array($_POST['drowsenochk'], SQLSRV_PARAM_IN),
  array($_POST['injuryyeschk'], SQLSRV_PARAM_IN),
  array($_POST['injurynochk'], SQLSRV_PARAM_IN),
  array($_POST['takemedicineyeschk'], SQLSRV_PARAM_IN),
  array($_POST['takemedicinenochk'], SQLSRV_PARAM_IN),
  array($_POST['healthyyeschk'], SQLSRV_PARAM_IN),
  array($_POST['healthynochk'], SQLSRV_PARAM_IN),
  array($_POST['sleepreststart'], SQLSRV_PARAM_IN),

  array($_POST['sleeprestend'], SQLSRV_PARAM_IN),
  array($_POST['timesleeprest'], SQLSRV_PARAM_IN),
  array($_POST['sleepnormalstart'], SQLSRV_PARAM_IN),
  array($_POST['sleepnormalend'], SQLSRV_PARAM_IN),
  array($_POST['timesleepnormal'], SQLSRV_PARAM_IN),
  array($_POST['sleepnormalyes'], SQLSRV_PARAM_IN),
  array($_POST['sleepnormalno'], SQLSRV_PARAM_IN),
  array($_POST['sleepextrastart'], SQLSRV_PARAM_IN),
  array($_POST['sleepextraend'], SQLSRV_PARAM_IN),
  array($_POST['timesleepextra'], SQLSRV_PARAM_IN),

  array($_POST['sleepextrayes'], SQLSRV_PARAM_IN),
  array($_POST['sleepextrano'], SQLSRV_PARAM_IN),
  array($_POST['disease'], SQLSRV_PARAM_IN),
  array($_POST['seedoctoryes'], SQLSRV_PARAM_IN),
  array($_POST['seedoctorno'], SQLSRV_PARAM_IN),
  array($_POST['drugname'], SQLSRV_PARAM_IN),
  array($_POST['drugtime'], SQLSRV_PARAM_IN),
  array($_POST['worryyes'], SQLSRV_PARAM_IN),
  array($_POST['worryno'], SQLSRV_PARAM_IN),
  array($_POST['householdyes'], SQLSRV_PARAM_IN),

  array($_POST['householdno'], SQLSRV_PARAM_IN),
  array($_POST['temperature'], SQLSRV_PARAM_IN),
  array($_POST['sysvalue1'], SQLSRV_PARAM_IN),
  array($_POST['sysvalue2'], SQLSRV_PARAM_IN),
  array($_POST['sysvalue3'], SQLSRV_PARAM_IN),
  array($_POST['diavalue1'], SQLSRV_PARAM_IN),
  array($_POST['diavalue2'], SQLSRV_PARAM_IN),
  array($_POST['diavalue3'], SQLSRV_PARAM_IN),
  array($_POST['pulsevalue1'], SQLSRV_PARAM_IN),
  array($_POST['pulsevalue2'], SQLSRV_PARAM_IN),

  array($_POST['pulsevalue3'], SQLSRV_PARAM_IN),
  array($_POST['oxygenvalue'], SQLSRV_PARAM_IN),
  array($_POST['eyeproblemyes'], SQLSRV_PARAM_IN),
  array($_POST['eyeproblemno'], SQLSRV_PARAM_IN),
  array($_POST['selfeyeglassesyes'], SQLSRV_PARAM_IN),
  array($_POST['selfeyeglassesno'], SQLSRV_PARAM_IN),
  array($_POST['selfcarryeyeglassesyes'], SQLSRV_PARAM_IN),
  array($_POST['selfcarryeyeglassesno'], SQLSRV_PARAM_IN),
  array($_POST['selfcarryhearingaidyes'], SQLSRV_PARAM_IN),
  array($_POST['selfcarryhearingaidno'], SQLSRV_PARAM_IN),
  array($_POST['alcoholtype'], SQLSRV_PARAM_IN),
  array($_POST['alcoholtime'], SQLSRV_PARAM_IN),

  array($_POST['alcoholvolume'], SQLSRV_PARAM_IN),
  array($_POST['activestatus'], SQLSRV_PARAM_IN),
  array($_POST['remark'], SQLSRV_PARAM_IN),
  array($_POST['createby'], SQLSRV_PARAM_IN),
  array($_POST['createdate'], SQLSRV_PARAM_IN),
  array($_POST['modifiedby'], SQLSRV_PARAM_IN),
  array($_POST['modifieddate'], SQLSRV_PARAM_IN)
  );

  $query_saveselfcheck = sqlsrv_query($conn, $sql_saveselfcheck, $params_saveselfcheck);
  $result_saveselfcheck = sqlsrv_fetch_array($query_saveselfcheck, SQLSRV_FETCH_ASSOC);
  ?>



  <?php
}
if ($_POST['txt_flg'] == "update_selfcheckdetail_driver") {
  ?>

  <?php

  $sql_saveselfcheck = "{call megSelfCheck(?,?,?,?,?,?,?,?,?,?,
                                            ?,?,?,?,?,?,?,?,?,?,
                                            ?,?,?,?,?,?,?,?,?,?,
                                            ?,?,?,?,?,?,?,?,?,?,
                                            ?,?,?,?,?,?,?,?,?,?,
                                            ?,?,?,?,?,?,?,?,?,?
                                            ,?,?,?,?,?,?,?)}";
  $params_saveselfcheck = array(
  array('update_selfcheckdetail_driver', SQLSRV_PARAM_IN),
  array($_POST['id'], SQLSRV_PARAM_IN),
  array($_POST['employeecode'], SQLSRV_PARAM_IN),
  array($_POST['employeename'], SQLSRV_PARAM_IN),
  array($_POST['datejobstart'], SQLSRV_PARAM_IN),
  array($_POST['dateworking'], SQLSRV_PARAM_IN),
  array($_POST['datepresent'], SQLSRV_PARAM_IN),
  array($_POST['tierdyeschk'], SQLSRV_PARAM_IN),
  array($_POST['tierdnochk'], SQLSRV_PARAM_IN),
  array($_POST['illnessyeschk'], SQLSRV_PARAM_IN),
  array($_POST['illnessnochk'], SQLSRV_PARAM_IN),
  array($_POST['drowseyeschk'], SQLSRV_PARAM_IN),
  array($_POST['drowsenochk'], SQLSRV_PARAM_IN),
  array($_POST['injuryyeschk'], SQLSRV_PARAM_IN),
  array($_POST['injurynochk'], SQLSRV_PARAM_IN),
  array($_POST['takemedicineyeschk'], SQLSRV_PARAM_IN),
  array($_POST['takemedicinenochk'], SQLSRV_PARAM_IN),
  array($_POST['healthyyeschk'], SQLSRV_PARAM_IN),
  array($_POST['healthynochk'], SQLSRV_PARAM_IN),
  array($_POST['sleepreststart'], SQLSRV_PARAM_IN),
  array($_POST['sleeprestend'], SQLSRV_PARAM_IN),
  array($_POST['timesleeprest'], SQLSRV_PARAM_IN),
  array($_POST['sleepnormalstart'], SQLSRV_PARAM_IN),
  array($_POST['sleepnormalend'], SQLSRV_PARAM_IN),
  array($_POST['timesleepnormal'], SQLSRV_PARAM_IN),
  array($_POST['sleepnormalyes'], SQLSRV_PARAM_IN),
  array($_POST['sleepnormalno'], SQLSRV_PARAM_IN),
  array($_POST['sleepextrastart'], SQLSRV_PARAM_IN),
  array($_POST['sleepextraend'], SQLSRV_PARAM_IN),
  array($_POST['timesleepextra'], SQLSRV_PARAM_IN),
  array($_POST['sleepextrayes'], SQLSRV_PARAM_IN),
  array($_POST['sleepextrano'], SQLSRV_PARAM_IN),
  array($_POST['disease'], SQLSRV_PARAM_IN),
  array($_POST['seedoctoryes'], SQLSRV_PARAM_IN),
  array($_POST['seedoctorno'], SQLSRV_PARAM_IN),
  array($_POST['drugname'], SQLSRV_PARAM_IN),
  array($_POST['drugtime'], SQLSRV_PARAM_IN),
  array($_POST['worryyes'], SQLSRV_PARAM_IN),
  array($_POST['worryno'], SQLSRV_PARAM_IN),
  array($_POST['householdyes'], SQLSRV_PARAM_IN),
  array($_POST['householdno'], SQLSRV_PARAM_IN),
  array($_POST['temperature'], SQLSRV_PARAM_IN),
  array($_POST['sysvalue1'], SQLSRV_PARAM_IN),
  array($_POST['sysvalue2'], SQLSRV_PARAM_IN),
  array($_POST['sysvalue3'], SQLSRV_PARAM_IN),
  array($_POST['diavalue1'], SQLSRV_PARAM_IN),
  array($_POST['diavalue2'], SQLSRV_PARAM_IN),
  array($_POST['diavalue3'], SQLSRV_PARAM_IN),
  array($_POST['pulsevalue1'], SQLSRV_PARAM_IN),
  array($_POST['pulsevalue2'], SQLSRV_PARAM_IN),
  array($_POST['pulsevalue3'], SQLSRV_PARAM_IN),
  array($_POST['oxygenvalue'], SQLSRV_PARAM_IN),
  array($_POST['eyeproblemyes'], SQLSRV_PARAM_IN),
  array($_POST['eyeproblemno'], SQLSRV_PARAM_IN),
  array($_POST['selfeyeglassesyes'], SQLSRV_PARAM_IN),
  array($_POST['selfeyeglassesno'], SQLSRV_PARAM_IN),
  array($_POST['selfcarryeyeglassesyes'], SQLSRV_PARAM_IN),
  array($_POST['selfcarryeyeglassesno'], SQLSRV_PARAM_IN),
  array($_POST['alcoholtype'], SQLSRV_PARAM_IN),
  array($_POST['alcoholtime'], SQLSRV_PARAM_IN),
  array($_POST['alcoholvolume'], SQLSRV_PARAM_IN),
  array($_POST['activestatus'], SQLSRV_PARAM_IN),
  array($_POST['remark'], SQLSRV_PARAM_IN),
  array($_POST['createby'], SQLSRV_PARAM_IN),
  array($_POST['createdate'], SQLSRV_PARAM_IN),
  array($_POST['modifiedby'], SQLSRV_PARAM_IN),
  array($_POST['modifieddate'], SQLSRV_PARAM_IN)
  );

  $query_saveselfcheck = sqlsrv_query($conn, $sql_saveselfcheck, $params_saveselfcheck);
  $result_saveselfcheck = sqlsrv_fetch_array($query_saveselfcheck, SQLSRV_FETCH_ASSOC);
  ?>



  <?php
}
if ($_POST['txt_flg'] == "update_selfcheckdetail") {
  ?>

  <?php

  $sql_saveselfcheck = "{call megSelfCheck(?,?,?,?,?,?,?,?,?,?,
                                            ?,?,?,?,?,?,?,?,?,?,
                                            ?,?,?,?,?,?,?,?,?,?,
                                            ?,?,?,?,?,?,?,?,?,?,
                                            ?,?,?,?,?,?,?,?,?,?,
                                            ?,?,?,?,?,?,?,?,?,?,
                                            ?,?,?,?,?,?,?,?,?)}";
  $params_saveselfcheck = array(
  array('update_selfcheckdetail', SQLSRV_PARAM_IN),
  array($_POST['id'], SQLSRV_PARAM_IN),
  array($_POST['employeecode'], SQLSRV_PARAM_IN),
  array($_POST['employeename'], SQLSRV_PARAM_IN),
  array($_POST['datejobstart'], SQLSRV_PARAM_IN),
  array($_POST['dateworking'], SQLSRV_PARAM_IN),
  array($_POST['datepresent'], SQLSRV_PARAM_IN),
  array($_POST['tierdyeschk'], SQLSRV_PARAM_IN),
  array($_POST['tierdnochk'], SQLSRV_PARAM_IN),
  array($_POST['illnessyeschk'], SQLSRV_PARAM_IN),
  array($_POST['illnessnochk'], SQLSRV_PARAM_IN),
  array($_POST['drowseyeschk'], SQLSRV_PARAM_IN),
  array($_POST['drowsenochk'], SQLSRV_PARAM_IN),
  array($_POST['injuryyeschk'], SQLSRV_PARAM_IN),
  array($_POST['injurynochk'], SQLSRV_PARAM_IN),
  array($_POST['takemedicineyeschk'], SQLSRV_PARAM_IN),
  array($_POST['takemedicinenochk'], SQLSRV_PARAM_IN),
  array($_POST['healthyyeschk'], SQLSRV_PARAM_IN),
  array($_POST['healthynochk'], SQLSRV_PARAM_IN),
  array($_POST['sleepreststart'], SQLSRV_PARAM_IN),
  array($_POST['sleeprestend'], SQLSRV_PARAM_IN),
  array($_POST['timesleeprest'], SQLSRV_PARAM_IN),
  array($_POST['sleepnormalstart'], SQLSRV_PARAM_IN),
  array($_POST['sleepnormalend'], SQLSRV_PARAM_IN),
  array($_POST['timesleepnormal'], SQLSRV_PARAM_IN),
  array($_POST['sleepnormalyes'], SQLSRV_PARAM_IN),
  array($_POST['sleepnormalno'], SQLSRV_PARAM_IN),
  array($_POST['sleepextrastart'], SQLSRV_PARAM_IN),
  array($_POST['sleepextraend'], SQLSRV_PARAM_IN),
  array($_POST['timesleepextra'], SQLSRV_PARAM_IN),
  array($_POST['sleepextrayes'], SQLSRV_PARAM_IN),
  array($_POST['sleepextrano'], SQLSRV_PARAM_IN),
  array($_POST['disease'], SQLSRV_PARAM_IN),
  array($_POST['seedoctoryes'], SQLSRV_PARAM_IN),
  array($_POST['seedoctorno'], SQLSRV_PARAM_IN),
  array($_POST['drugname'], SQLSRV_PARAM_IN),
  array($_POST['drugtime'], SQLSRV_PARAM_IN),
  array($_POST['worryyes'], SQLSRV_PARAM_IN),
  array($_POST['worryno'], SQLSRV_PARAM_IN),
  array($_POST['householdyes'], SQLSRV_PARAM_IN),
  array($_POST['householdno'], SQLSRV_PARAM_IN),
  array($_POST['temperature'], SQLSRV_PARAM_IN),
  array($_POST['sysvalue1'], SQLSRV_PARAM_IN),
  array($_POST['sysvalue2'], SQLSRV_PARAM_IN),
  array($_POST['sysvalue3'], SQLSRV_PARAM_IN),
  array($_POST['diavalue1'], SQLSRV_PARAM_IN),
  array($_POST['diavalue2'], SQLSRV_PARAM_IN),
  array($_POST['diavalue3'], SQLSRV_PARAM_IN),
  array($_POST['pulsevalue1'], SQLSRV_PARAM_IN),
  array($_POST['pulsevalue2'], SQLSRV_PARAM_IN),
  array($_POST['pulsevalue3'], SQLSRV_PARAM_IN),
  array($_POST['oxygenvalue'], SQLSRV_PARAM_IN),
  array($_POST['eyeproblemyes'], SQLSRV_PARAM_IN),
  array($_POST['eyeproblemno'], SQLSRV_PARAM_IN),
  array($_POST['selfeyeglassesyes'], SQLSRV_PARAM_IN),
  array($_POST['selfeyeglassesno'], SQLSRV_PARAM_IN),
  array($_POST['selfcarryeyeglassesyes'], SQLSRV_PARAM_IN),
  array($_POST['selfcarryeyeglassesno'], SQLSRV_PARAM_IN),
  array($_POST['selfcarryhearingaidyes'], SQLSRV_PARAM_IN),
  array($_POST['selfcarryhearingaidno'], SQLSRV_PARAM_IN),
  array($_POST['alcoholtype'], SQLSRV_PARAM_IN),
  array($_POST['alcoholtime'], SQLSRV_PARAM_IN),
  array($_POST['alcoholvolume'], SQLSRV_PARAM_IN),
  array($_POST['activestatus'], SQLSRV_PARAM_IN),
  array($_POST['remark'], SQLSRV_PARAM_IN),
  array($_POST['createby'], SQLSRV_PARAM_IN),
  array($_POST['createdate'], SQLSRV_PARAM_IN),
  array($_POST['modifiedby'], SQLSRV_PARAM_IN),
  array($_POST['modifieddate'], SQLSRV_PARAM_IN)
  );

  $query_saveselfcheck = sqlsrv_query($conn, $sql_saveselfcheck, $params_saveselfcheck);
  $result_saveselfcheck = sqlsrv_fetch_array($query_saveselfcheck, SQLSRV_FETCH_ASSOC);
  ?>



  <?php
}
if ($_POST['txt_flg'] == "confirm_selfcheck") {
  ?>

  <?php

  $sql_confirmselfcheck = "{call megSelfCheck(  ?,?,?,?,?,?,?,?,?,?,
                                                ?,?,?,?,?,?,?,?,?,?,
                                                ?,?,?,?,?,?,?,?,?,?,
                                                ?,?,?,?,?,?,?,?,?,?,
                                                ?,?,?,?,?,?,?,?,?,?,
                                                ?,?,?,?,?,?,?,?,?,?,
                                                ?,?,?,?,?,?,?,?,?,?,?)}";
  $params_confirmselfcheck = array(
  array('confirm_selfcheck', SQLSRV_PARAM_IN),
  array($_POST['selfcheckid'], SQLSRV_PARAM_IN),
  array($_POST['officerconfirm'], SQLSRV_PARAM_IN), // employeecode ใน Stored
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN)
  );

  $query_confirmselfcheck = sqlsrv_query($conn, $sql_confirmselfcheck, $params_confirmselfcheck);
  $result_confirmselfcheck = sqlsrv_fetch_array($query_confirmselfcheck, SQLSRV_FETCH_ASSOC);
  ?>



  <?php
}
if ($_POST['txt_flg'] == "delete_selfcheck") {
?>

<?php

$sqldelete = "DELETE DRIVERSELFCHECK WHERE SELFCHECKID= '".$_POST['id']."'";
$querydelete = sqlsrv_query($conn, $sqldelete, $paramsdelete);
$resultdelete = sqlsrv_fetch_array($querydelete, SQLSRV_FETCH_ASSOC);

//   echo "ลบแล้ว";
?>



<?php
}
if ($_POST['txt_flg'] == "edit_password") {
  
    $sql = "UPDATE ROLEACCOUNT 
    SET [PASSWORD] = '" . $_POST['editvalue'] . "' 
    WHERE ROLEACCOUNTID ='" . $_POST['roleid'] . "'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    
    // echo $result['TIMEREST'];
    
}
if ($_POST['txt_flg'] == "insert_timeworkingdatang") {
  
    $sql = "UPDATE DRIVERSELFCHECK 
    SET [TIMEWORKINGDATANG1] = '" . $_POST['data1'] . "',
    [TIMEWORKINGDATANG2] = '" . $_POST['data2'] . "',
    [TIMEWORKINGDATANG3] = '" . $_POST['data3'] . "',
    [TIMEWORKINGDATANG4] = '" . $_POST['data4'] . "',
    [TIMEWORKINGDATANG5] = '" . $_POST['data5'] . "',
    [TIMEWORKINGDATANG6] = '" . $_POST['data6'] . "'
    WHERE SELFCHECKID ='" . $_POST['selfcheckid'] . "'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    
    // echo $result['TIMEREST'];
    
}
if ($_POST['txt_flg'] == "commitupdate_selfcheck") {
  
    $sql = "UPDATE DRIVERSELFCHECK 
    SET TEMPERATURE = '" . $_POST['temp'] . "' ,
    SYSVALUE1 = '" . $_POST['sysvalue1'] . "' ,
    SYSVALUE2 = '" . $_POST['sysvalue2'] . "' ,
    SYSVALUE3 = '" . $_POST['sysvalue3'] . "' ,
    DIAVALUE1 = '" . $_POST['diavalue1'] . "' ,
    DIAVALUE2 = '" . $_POST['diavalue2'] . "' ,
    DIAVALUE3 = '" . $_POST['diavalue3'] . "' ,
    PULSEVALUE1 = '" . $_POST['pulsevalue1'] . "' ,
    PULSEVALUE2 = '" . $_POST['pulsevalue2'] . "' ,
    PULSEVALUE3 = '" . $_POST['pulsevalue3'] . "' ,
    OXYGENVALUE = '" . $_POST['oxygenvalue'] . "',
    ALCOHOLVOLUME = '" . $_POST['alcoholvalue'] . "'
    WHERE SELFCHECKID ='" . $_POST['selfcheckid'] . "'
    AND ACTIVESTATUS ='1'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    
    // echo $result['TIMEREST'];
    
}if ($_POST['txt_flg'] == "save_incomeandexpenseaccount") {
    ?>

    <?php

    $sql_savehealthtenko = "{call megEditHealthForTenko(?,?,?,?,?,?,?,?,?,?,
                                                        ?,?,?,?,?,?,?,?,?,?,
                                                        ,?,?)}";
    $params_savehealthtenko = array(
    array('save_incomeandexpenseaccount', SQLSRV_PARAM_IN),
    array($_POST['id'], SQLSRV_PARAM_IN),
    array($_POST['sparepartrepair_cost'], SQLSRV_PARAM_IN),
    array($_POST['tirerepair_cost'], SQLSRV_PARAM_IN),
    array($_POST['outsiderepair_cost'], SQLSRV_PARAM_IN),
    array($_POST['truckrent_cost'], SQLSRV_PARAM_IN),
    array($_POST['gps_cost'], SQLSRV_PARAM_IN),
    array($_POST['insurance_cost'], SQLSRV_PARAM_IN),
    array($_POST['depreciation_cost'], SQLSRV_PARAM_IN),
    array($_POST['interesthirepurchase_cost'], SQLSRV_PARAM_IN),
    array($_POST['consumables_cost'], SQLSRV_PARAM_IN),
    array($_POST['taxesandfees_cost'], SQLSRV_PARAM_IN),
    array($_POST['salary_cost'], SQLSRV_PARAM_IN),
    array($_POST['bonusmoney_cost'], SQLSRV_PARAM_IN),
    array($_POST['empservice_cost'], SQLSRV_PARAM_IN),
    array($_POST['socialsecurity_cost'], SQLSRV_PARAM_IN),
    array($_POST['providentfund_cost'], SQLSRV_PARAM_IN),
    array($_POST['welfare_cost'], SQLSRV_PARAM_IN),
    array($_POST['telephone_cost'], SQLSRV_PARAM_IN),
    array($_POST['trainning_cost'], SQLSRV_PARAM_IN),
    array($_POST['createby'], SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)

    );

    $query_savehealthtenko= sqlsrv_query($conn, $sql_savehealthtenko, $params_savehealthtenko);
    $result_savehealthtenko = sqlsrv_fetch_array($query_savehealthtenko, SQLSRV_FETCH_ASSOC);
    ?>



    <?php
 } 
 if ($_POST['txt_flg'] == "select_selfcheckdata") {
   ?>

   <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
     <thead>
        <tr>
                <th>NO</th>
                <th>SELFCHECKID</th>
                <th>CREATEDATE</th>
                <th>EMPLOYEECODE</th>
                <th>EMPLOYEENAME</th>
                <th>DETAIL</th>
            <?php
            if ($_SESSION["ROLENAME"] == "ADMIN") {
            ?>
                <th>ACTIVESTATUS</th>
                <th>CONFIRMBY</th>
                <th>DATEWORKING</th>
                <th>DATEPRESENT</th>
                <th>EDIT</th>
            <?php
            }else {
            ?>
            
                <th>ACTIVESTATUS</th>
                <th>CONFIRMBY</th>
            <?php
            }
            ?>
        </tr>
     </thead>
     <tbody>
        <?php
            $i = 1;
            $DATE = date("d/m/Y");

            if ($_SESSION["ROLENAME"] == "ADMIN") {

                // ถ้า ADMIN เป็นคนเข้ามาดูจะโชว์แผนงานที่ ACTIVESTATUS ='0' และ CONFIRM BY เป็นค่า NULL หรือ ค่าว่าง ด้วย
                $sql_seSelfCheck = "SELECT SELFCHECKID,EMPLOYEECODE,EMPLOYEENAME,DATEJOBSTART,DATEWORKING,DATEPRESENT,
                    CONVERT(VARCHAR(10),CREATEDATE,103) AS 'CREATEDATE',ACTIVESTATUS,CONFIRMEDBY
                    FROM DRIVERSELFCHECK
                    WHERE  CONVERT(DATE,CREATEDATE) BETWEEN CONVERT(DATE,'".$_POST['datestart']."',103) AND CONVERT(DATE,'".$_POST['dateend']."',103) 
                    --AND ACTIVESTATUS = '1'
                    --AND CONFIRMEDBY IS NOT NULL
                    ORDER BY ACTIVESTATUS,SELFCHECKID ASC";
                $params_seSelfCheck = array();
                $query_seSelfCheck = sqlsrv_query($conn, $sql_seSelfCheck, $params_seSelfCheck);
              
            }else {
                
                
                //  USER ทั่วไปจะเห็น ACTIVESTATUS = 0 และ CONFIRM  NULL ด้วย
                $sql_seSelfCheck = "SELECT SELFCHECKID,EMPLOYEECODE,EMPLOYEENAME,DATEJOBSTART,DATEWORKING,DATEPRESENT,
                    CONVERT(VARCHAR(10),CREATEDATE,103) AS 'CREATEDATE',ACTIVESTATUS,CONFIRMEDBY
                    FROM DRIVERSELFCHECK
                    WHERE  CONVERT(DATE,CREATEDATE) BETWEEN CONVERT(DATE,'".$_POST['datestart']."',103) AND CONVERT(DATE,'".$_POST['dateend']."',103) 
                    --AND ACTIVESTATUS = '1'
                    --AND CONFIRMEDBY IS NOT NULL
                    ORDER BY ACTIVESTATUS,SELFCHECKID ASC";
                $params_seSelfCheck = array();
                $query_seSelfCheck = sqlsrv_query($conn, $sql_seSelfCheck, $params_seSelfCheck);
            }
            
            

            while ($result_seSelfCheck = sqlsrv_fetch_array($query_seSelfCheck, SQLSRV_FETCH_ASSOC)) {
        ?>

            <tr>
                <td style="text-align:center"><?=$i?></td>
                <td style="text-align:center"><?=$result_seSelfCheck['SELFCHECKID']?></td>
                <td style="text-align:left"><?=$result_seSelfCheck['CREATEDATE']?></td>
                <td style="text-align:left"><?=$result_seSelfCheck['EMPLOYEECODE']?></td>
                <td style="text-align:left"><?=$result_seSelfCheck['EMPLOYEENAME']?></td>
                <td style="text-align:center"><button type="button" class="btn btn-primary" name="myBtn" id ="myBtn" data-toggle="" data-target="" onclick="checking_selfcheckdata('<?= $result_seSelfCheck['SELFCHECKID'] ?>','<?= $result_seSelfCheck['EMPLOYEECODE'] ?>','<?= $result_seSelfCheck['EMPLOYEENAME'] ?>','<?= $result_seSelfCheck['DATEJOBSTART'] ?>','<?= $result_seSelfCheck['DATEWORKING'] ?>','<?= $result_seSelfCheck['DATEPRESENT'] ?>');" >ตรวจสอบข้อมูล</button></td>
                
                <!--Active status , edit  และ Confirmby เห็นได้เฉพาะ Admin เท่านั้น  -->
                <?php
                if ($_SESSION["ROLENAME"] == "ADMIN") {
                ?>
                    <!-- <td style="text-align:center"><?=$result_seSelfCheck['ACTIVESTATUS']?></td> -->
                    <td style="text-align:center" contenteditable="true"  onkeyup="edit_status(this,'<?= $result_seSelfCheck['SELFCHECKID'] ?>')"><?= $result_seSelfCheck['ACTIVESTATUS'] ?></td>
                    <td style="text-align:center"><?=$result_seSelfCheck['CONFIRMEDBY']?></td>
                    <td style="text-align:center"><input style="height:35px; width:200px" class="form-control dateen_admin" readonly=""  onchange="update_dateselfcheck_byadmin('<?=$result_seSelfCheck['SELFCHECKID']?>','DATEWORKING',this.value);"  id="txt_dateworkingconfirm" name="txt_dateworkingconfirm" value="<?= $result_seSelfCheck['DATEWORKING']; ?>" placeholder="DATEWORKING"></td>
                    <td style="text-align:center"><input style="height:35px; width:200px" class="form-control dateen_admin" readonly=""  onchange="update_dateselfcheck_byadmin('<?=$result_seSelfCheck['SELFCHECKID']?>','DATEPRESENT',this.value);"  id="txt_datepresentconfirm" name="txt_datepresentconfirm" value="<?= $result_seSelfCheck['DATEPRESENT']; ?>" placeholder="DATEPRESENT"></td>
                    <?php
                    if ($result_seSelfCheck['ACTIVESTATUS'] == '0') {
                    ?>
                        <td style="text-align:center"><button type="button" class="btn btn-primary" name="myBtn" id ="myBtn" data-toggle="" data-target="" onclick="alert('เปลี่ยน ACTIVESTATUS เป็น  1 ก่อน');" >แก้ไขข้อมูล(เฉพาะแอดมิน)</button></td>
                    <?php
                    }else {
                    ?>
                        <td style="text-align:center"><button type="button" class="btn btn-primary" name="myBtn" id ="myBtn" data-toggle="" data-target="" onclick="checking_selfcheckdata_admin('<?= $result_seSelfCheck['SELFCHECKID'] ?>','<?= $result_seSelfCheck['EMPLOYEECODE'] ?>','<?= $result_seSelfCheck['EMPLOYEENAME'] ?>','<?= $result_seSelfCheck['DATEJOBSTART'] ?>','<?= $result_seSelfCheck['DATEWORKING'] ?>','<?= $result_seSelfCheck['DATEPRESENT'] ?>');" >แก้ไขข้อมูล(เฉพาะแอดมิน)</button></td>
                    <?php   
                    }
                    ?>

                    
                <?php
                }else {
                ?>
                        
                    <td style="text-align:center"><?= $result_seSelfCheck['ACTIVESTATUS'] ?></td>
                    <td style="text-align:center"><?=$result_seSelfCheck['CONFIRMEDBY']?></td>
                <?php
                }
                ?>

            </tr>
         <?php
         $i++;
       }
       ?>
     </tbody>

   </table>

   <?php
 } if ($_POST['txt_flg'] == "select_tapkpi2") {
    ?>
 
    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example4" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
      <thead>
         <tr>
            <th style="text-align: center;">No</th>
            <th style="text-align: center;">TenkoNG ID</th>
            <th style="text-align: center;">Date</th>
            <th style="text-align: center;">DriverName</th>
            <th style="text-align: center;width:10px;height:30px">TenkoNG</th>
            <th style="text-align: center;width:10px;height:30px">Annual leave</th>
            <th style="text-align: center;width:10px;height:30px">Sick leave</th>
            <th style="text-align: center;width:10px;height:30px">Cause</th>
            <th style="text-align: center;width:10px;height:30px">Action</th>
            <th style="text-align: center;width:10px;height:30px">EDIT</th>
            </th>
        </tr>
      </thead>
      <tbody>
      <?php
        $i = 1;

        $sql_seTenkoNG = "SELECT TENKONG_ID,DATE_PROCESS,DRIVERNAME,TENKONG
        ,ANNUALLEAVE,SICKLEAVE,CAUSE_DATA,ACTION_DATA,REMARK_MONTH,REMARK_YEARS
        FROM DIGITALTENKO_TENKONG
        WHERE REMARK_MONTH ='".$_POST['month']."' AND REMARK_YEARS='".$_POST['years']."'
        ORDER BY DATE_PROCESS ASC";
        // $sql_seTenkoNG = "SELECT TENKONG_ID,DATE_PROCESS,DRIVERNAME,TENKONG
        // ,ANNUALLEAVE,SICKLEAVE,CAUSE_DATA,ACTION_DATA 
        // FROM DIGITALTENKO_TENKONG";
        $params_seTenkoNG = array();
        $query_seTenkoNG = sqlsrv_query($conn, $sql_seTenkoNG, $params_seTenkoNG);
        while ($result_seTenkoNG = sqlsrv_fetch_array($query_seTenkoNG, SQLSRV_FETCH_ASSOC)) {
            ?>
            <tr>
                <td style="text-align: center;"><?= $i ?></td>
                <td style="text-align: center;"><?= $result_seTenkoNG['TENKONG_ID'] ?></td>
                <td><?= $result_seTenkoNG['DATE_PROCESS'] ?></td>
                <td><?= $result_seTenkoNG['DRIVERNAME'] ?></td>
                <td style="text-align: center;"><input type="text" class="form-control" style="width:100px;height:30px" id="txt_tenkong" onchange="update_tenkong('<?=$result_seTenkoNG['TENKONG_ID']?>',this.value,'TENKONG');" value="<?= $result_seTenkoNG['TENKONG'] ?>"></td>
                <td style="text-align: center;"><input type="text" class="form-control" style="width:100px;height:30px" id="txt_tenkong" onchange="update_tenkong('<?=$result_seTenkoNG['TENKONG_ID']?>',this.value,'ANNUALLEAVE');" value="<?= $result_seTenkoNG['ANNUALLEAVE'] ?>"></td>
                <td style="text-align: center;"><input type="text" class="form-control" style="width:100px;height:30px" id="txt_tenkong" onchange="update_tenkong('<?=$result_seTenkoNG['TENKONG_ID']?>',this.value,'SICKLEAVE');" value="<?= $result_seTenkoNG['SICKLEAVE'] ?>"></td>
                <td style="text-align: center;"><input type="text" class="form-control" style="width:100px;height:30px" id="txt_tenkong" onchange="update_tenkong('<?=$result_seTenkoNG['TENKONG_ID']?>',this.value,'CAUSE_DATA');" value="<?= $result_seTenkoNG['CAUSE_DATA'] ?>"></td>
                <td style="text-align: center;"><input type="text" class="form-control" style="width:100px;height:30px" id="txt_tenkong" onchange="update_tenkong('<?=$result_seTenkoNG['TENKONG_ID']?>',this.value,'ACTION_DATA');" value="<?= $result_seTenkoNG['ACTION_DATA'] ?>"></td>
                <td style="text-align: center;"><input type="text" class="btn btn-primary" data-confirm ="กรุณากด 'ตกลง (OK)' เพื่อยืนยันการลบข้อมูล?" name="btnDelete" id="btnDelete" value="ลบข้อมูลไอดีที่:<?=$result_seTenkoNG['TENKONG_ID']?>" ></td>
            </tr>
            <?php
            $i++;

            
        }
        ?>
      </tbody>
 
    </table>
 
    <?php
  }
 if ($_POST['txt_flg'] == "select_compensationperson") {
   ?>

   <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
     <thead>
        <tr>
            <th style="width:  10%">ลำดับ1</th>
            <th>วันที่</th>
            <th>ชื่อ-สกุล</th>
            <th>ต้นทาง</th>
            <th>ปลายทาง</th>
            <th>ทะเบียนรถ</th>
            <th>ค่าเที่ยวปกติ</th>
            <th>OT วันหยุด</th>
            <th>OT 1.5 เท่า</th>
            <th>รายได้อื่นๆ</th>
            <th>รวม</th>
        </tr>
     </thead>
     <tbody>
       <?php

       $i = 1;


       if ($_POST['companycode'] == 'RCC') {
        ///ค้นหาข้อมูลสายงาน RCC
        ///ทะเบียนรถต้องไม่เท่ากับ RA หรือ ต้องเท่ากับ R
        $sql_sedriverchk = "SELECT a.EMPLOYEECODE1 AS 'EMPCODE', a.EMPLOYEENAME1 AS 'EMPNAME'
        FROM [dbo].[VEHICLETRANSPORTPLAN] a
        WHERE a.COMPANYCODE IN ('RATC','RCC') AND a.CUSTOMERCODE ='TTT'
        AND a.DOCUMENTCODE IS NOT NULL
        AND a.DOCUMENTCODE !=''
        AND (a.EMPLOYEECODE1 IS NOT NULL OR a.EMPLOYEECODE1 !='') 
        AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'01/06/2021',103) AND CONVERT(DATE,'08/06/2021',103)
        AND SUBSTRING(a.THAINAME, 1, 2) != 'RA'
        UNION
        SELECT EMPLOYEECODE2 AS 'EMPCODE' , EMPLOYEENAME2 AS 'EMPNAME'
        FROM [dbo].[VEHICLETRANSPORTPLAN] a
        WHERE a.COMPANYCODE IN ('RATC','RCC') AND a.CUSTOMERCODE ='TTT'
        AND a.DOCUMENTCODE IS NOT NULL
        AND a.DOCUMENTCODE !=''
        AND (a.EMPLOYEECODE2 IS NOT NULL OR a.EMPLOYEECODE2 !='') 
        AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'01/06/2021',103) AND CONVERT(DATE,'08/06/2021',103)
        AND SUBSTRING(a.THAINAME, 1, 2) != 'RA'
        ORDER BY a.EMPLOYEENAME1 ASC";
        // ORDER BY a.JOBSTART,b.DATEWORKING ASC
      $query_sedriverchk = sqlsrv_query($conn, $sql_sedriverchk, $params_sedriverchk);
  }else {
      ///ค้นหาข้อมูลสายงาน RATC
      ///ทะเบียนรถต้องเท่ากับ RA 
      $sql_sedriverchk = "SELECT a.EMPLOYEECODE1 AS 'EMPCODE', a.EMPLOYEENAME1 AS 'EMPNAME'
      FROM [dbo].[VEHICLETRANSPORTPLAN] a
      WHERE a.COMPANYCODE IN ('RATC','RCC') AND a.CUSTOMERCODE ='TTT'
      AND a.DOCUMENTCODE IS NOT NULL
      AND a.DOCUMENTCODE !=''
      AND (a.EMPLOYEECODE1 IS NOT NULL OR a.EMPLOYEECODE1 !='') 
      AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'01/06/2021',103) AND CONVERT(DATE,'08/06/2021',103)
      AND SUBSTRING(a.THAINAME, 1, 2) = 'RA'
      UNION
      SELECT EMPLOYEECODE2 AS 'EMPCODE' , EMPLOYEENAME2 AS 'EMPNAME'
      FROM [dbo].[VEHICLETRANSPORTPLAN] a
      WHERE a.COMPANYCODE IN ('RATC','RCC') AND a.CUSTOMERCODE ='TTT'
      AND a.DOCUMENTCODE IS NOT NULL
      AND a.DOCUMENTCODE !=''
      AND (a.EMPLOYEECODE2 IS NOT NULL OR a.EMPLOYEECODE2 !='') 
      AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'01/06/2021',103) AND CONVERT(DATE,'08/06/2021',103)
      AND SUBSTRING(a.THAINAME, 1, 2) = 'RA'
      ORDER BY a.EMPLOYEENAME1 ASC";
      // ORDER BY a.JOBSTART,b.DATEWORKING ASC
    $query_sedriverchk = sqlsrv_query($conn, $sql_sedriverchk, $params_sedriverchk);
  }
    while ($result_sedriverchk = sqlsrv_fetch_array($query_sedriverchk, SQLSRV_FETCH_ASSOC)) {
       
        if ($_POST['companycode'] == 'RCC') {
            ///ค้นหาข้อมูลสายงาน RCC
            ///ทะเบียนรถต้องไม่เท่ากับ RA หรือ ต้องเท่ากับ R
            $sql_secompensationperson = "SELECT ROW_NUMBER() OVER (PARTITION BY CONVERT(VARCHAR(30), c.DATEWORKING, 103) 
            ORDER BY CONVERT(VARCHAR(30), c.DATEWORKING, 103),c.JOBNO ASC) AS 'ROWNUM' ,c.DATEWORKING AS 'DATE',
            c.EMPCODE1 AS 'EMPLOYEECODE1',c.EMPNAME1 AS 'EMPLOYEENAME1',c.[FROM] AS 'FROM',c.[TO] AS 'TO',
            c.CLUSTER AS 'CLUSTER',c.THAINAME AS 'THAINAME',c.JOBNO AS 'JOBNO'
            
            FROM (
            SELECT DISTINCT
            CONVERT(VARCHAR(30), b.DATEWORKING, 103)  AS 'DATEWORKING',b.JOBNO AS 'JOBNO',
            a.JOBSTART AS 'FROM' ,a.JOBEND AS 'TO' ,b.CLUSTER AS 'CLUSTER',b.THAINAME AS 'THAINAME',
            a.EMPLOYEECODE1 AS 'EMPCODE1',a.EMPLOYEENAME1 AS 'EMPNAME1',
            a.EMPLOYEECODE2 AS 'EMPCODE2',a.EMPLOYEENAME2 AS 'EMPNAME2',
            b.VEHICLETRANSPORTPLANID AS 'PLANID',
            b.WORKTYPE,b.C2,b.VEHICLETRANSPORTPRICEID
            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
            AND a.COMPANYCODE IN ('RATC','RCC') AND a.CUSTOMERCODE ='TTT'
            AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'01/06/2021',103) AND CONVERT(DATE,'08/06/2021',103)
            AND b.VEHICLEREGISNUMBER1 IS NOT NULL
            AND b.VEHICLEREGISNUMBER1 !=''
            AND b.DOCUMENTCODE IS NOT NULL
            AND b.DOCUMENTCODE !=''
            AND a.TRIPAMOUNT IS NOT NULL
            AND a.TRIPAMOUNT !=''
            AND SUBSTRING(b.THAINAME, 1, 2) != 'RA'
            AND (a.EMPLOYEECODE1 ='".$result_sedriverchk['EMPCODE']."' OR a.EMPLOYEECODE2 ='".$result_sedriverchk['EMPCODE']."')
            
            ) AS c";
            // ORDER BY a.JOBSTART,b.DATEWORKING ASC
          $query_secompensationperson = sqlsrv_query($conn, $sql_secompensationperson, $params_secompensationperson);
          $result_secompensationperson = sqlsrv_fetch_array($query_secompensationperson, SQLSRV_FETCH_ASSOC);  
        }else {
          ///ค้นหาข้อมูลสายงาน RATC
          ///ทะเบียนรถต้องเท่ากับ RA 
          $sql_secompensationperson = "SELECT ROW_NUMBER() OVER (PARTITION BY CONVERT(VARCHAR(30), c.DATEWORKING, 103) 
          ORDER BY CONVERT(VARCHAR(30), c.DATEWORKING, 103),c.JOBNO ASC) AS 'ROWNUM',c.DATEWORKING AS 'DATE',
          c.EMPCODE1 AS 'EMPLOYEECODE1',c.EMPNAME1 AS 'EMPLOYEENAME1',c.[FROM] AS 'FROM',c.[TO] AS 'TO',
          c.CLUSTER AS 'CLUSTER',c.THAINAME AS 'THAINAME',c.JOBNO AS 'JOBNO'
          
          FROM (
          SELECT DISTINCT
          CONVERT(VARCHAR(30), b.DATEWORKING, 103)  AS 'DATEWORKING',b.JOBNO AS 'JOBNO',
          a.JOBSTART AS 'FROM' ,a.JOBEND AS 'TO' ,b.CLUSTER AS 'CLUSTER',b.THAINAME AS 'THAINAME',
          a.EMPLOYEECODE1 AS 'EMPCODE1',a.EMPLOYEENAME1 AS 'EMPNAME1',
          a.EMPLOYEECODE2 AS 'EMPCODE2',a.EMPLOYEENAME2 AS 'EMPNAME2',
          b.VEHICLETRANSPORTPLANID AS 'PLANID',
          b.WORKTYPE,b.C2,b.VEHICLETRANSPORTPRICEID
          FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
          INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
          AND a.COMPANYCODE IN ('RATC','RCC') AND a.CUSTOMERCODE ='TTT'
          AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'01/06/2021',103) AND CONVERT(DATE,'08/06/2021',103)
          AND b.VEHICLEREGISNUMBER1 IS NOT NULL
          AND b.VEHICLEREGISNUMBER1 !=''
          AND b.DOCUMENTCODE IS NOT NULL
          AND b.DOCUMENTCODE !=''
          AND a.TRIPAMOUNT IS NOT NULL
          AND a.TRIPAMOUNT !=''
          AND SUBSTRING(b.THAINAME, 1, 2) = 'RA'
          AND (a.EMPLOYEECODE1 ='".$result_sedriverchk['EMPCODE']."' OR a.EMPLOYEECODE2 ='".$result_sedriverchk['EMPCODE']."')
          
          ) AS c";
          // ORDER BY a.JOBSTART,b.DATEWORKING ASC
        $query_secompensationperson = sqlsrv_query($conn, $sql_secompensationperson, $params_secompensationperson);
        $result_secompensationperson = sqlsrv_fetch_array($query_secompensationperson, SQLSRV_FETCH_ASSOC);
      }
         




          
           ?>
           <tr>
             <td style="text-align:center" ><?= $i ?></td>
             <td ><?= $result_secompensationperson['ROWNUM'] ?></td>
             <td ><?= $result_secompensationperson['EMPLOYEENAME1'] ?></td>
             <td ><?= $result_seFood['Company_Code'] ?></td>
             <td ><?= $result_seFood['PersonCode'] ?></td>
             <td ><?= $result_seFood['nameFL'] ?></td>
             <td ><?= $result_seFood3['MONNY'] ?></td>
             <td ><?= $result_seFood2['DATEN'] ?></td>
             <td ><?= $result_seFood3['TII'] ?></td>
             <td ><?= $result_seFood3['TOO'] ?></td>
             <td ><?= $result_seFood3['REMARK'] ?></td>
           </tr>
           <?php
         
         $i++;
       }
       ?>
     </tbody>
   </table>
   <?php
 }
 if ($_POST['txt_flg'] == "select_trainingdata") {
   ?>

   <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
     <thead>
        <tr>
            <th>ลำดับ</th>
            <!-- <th>รหัสพนักงาน</th>
            <th>ชื่อ-สกุล</th>
            <th>ตำแหน่ง</th> -->
            <th>วันที่อบรม</th>
            <th>หัวข้อการอบรม</th>
            <th>รายละเอียดเพิ่มเติม</th>
            <th>ชั่วโมงการอบรม</th>
            <th>ผู้ฝึกอบรม</th>
        </tr>
     </thead>
     <tbody>
       <?php
       $i = 1;

       // $condiReporttransport1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)";
       // $condiReporttransport2 = "";
       // $condiReporttransport3 = "";

    //    $sql_seTrainingData = "SELECT e.Company_NameT, b.PersonID, 
    //    c.PersonCode, d.PositionNameT, 
    //    c.FnameT, c.LnameT,a.Patern_Name,a.Patern_descrition, 
    //    a.Patern_Budget,a.Patern_Hour,
    //    b.pretest_point, b.posttest_point,g.Professor_NameT,
    //    a.Patern_Date,CONVERT(VARCHAR(10), a.Patern_Date, 103)  AS 'PATTERNDATE', 
    //    a.Patern_End,CONVERT(VARCHAR(10), a.Patern_End, 103)  AS 'PATTERNEND'
    //    FROM [203.150.225.30].[TigerE-HR].dbo.TN_Patern__Course a
    //    INNER JOIN [203.150.225.30].[TigerE-HR].dbo.TN_TrainPerson b ON b.Patern_ID = a.Patern_ID
    //    INNER JOIN [203.150.225.30].[TigerE-HR].dbo.PNT_Person c ON c.PersonID = b.PersonID
    //    INNER JOIN [203.150.225.30].[TigerE-HR].dbo.PNM_Position d ON d.PositionID = c.PositionID
    //    INNER JOIN [203.150.225.30].[TigerE-HR].dbo.COM_Company e ON e.ID_Company = c.CompanyID
    //    INNER JOIN [203.150.225.30].[TigerE-HR].dbo.TN_Patern_Professor f ON f.Patern_ID = a.Patern_ID
    //    INNER JOIN [203.150.225.30].[TigerE-HR].dbo.TN_Professor g ON g.Professor_ID = f.Professor_ID
    //    WHERE c.PersonCode ='".$_POST['employeecode']."'
    //    ORDER BY  a.Patern_Date ASC";
    //    $params_seTrainingData = array();
    //    $query_seTrainingData = sqlsrv_query($conn, $sql_seTrainingData, $params_seTrainingData);
    //    while ($result_seTrainingData = sqlsrv_fetch_array($query_seTrainingData, SQLSRV_FETCH_ASSOC)) {
        
        $employeecode = $_POST['employeecode'];
            $sql_seTrainingData = "SELECT DISTINCT
            H.PersonCode COLLATE Thai_CI_AI,
            H.COURSE_NAMETH COLLATE Thai_CI_AI TC_CN,
            H.COURSESUB_NAMETH COLLATE Thai_CI_AI Patern_Name,
            H.COURSE_PRICE_PER_PERSON COLLATE Thai_CI_AI Patern_Budget,
            H.HOURxDAYS COLLATE Thai_CI_AI Patern_Hour,
            H.COURSE_DATESTART COLLATE Thai_CI_AI PY_CDS,
            SUBSTRING ( COURSE_DATESTART COLLATE Thai_CI_AI, 9, 10 ) AS PY_CDSSUB,
            H.COURSE_DATEEND COLLATE Thai_CI_AI PY_CDE,
            SUBSTRING ( COURSE_DATEEND COLLATE Thai_CI_AI, 9, 10 ) AS PY_CDESUB,
            H.TEACHER COLLATE Thai_CI_AI Professor_NameT 
            FROM [eTraining].[dbo].HISTORY_TRAINING H WHERE H.PersonCode = '".$employeecode."'
            UNION ALL
            SELECT
                VH.PYE_PSC,VH.TC_CN,VH.TCS_CSNT,VH.TCS_CPPPS + VH.TC_CPPPS CPPPS,VH.PY_HXD,
                VH.PY_CDS,SUBSTRING (PY_CDS, 9, 10) AS PY_CDSSUB,VH.PY_CDE,
                SUBSTRING (PY_CDE, 9, 10) AS PY_CDESUB,VH.EMP3_COMCODE + '/' + VH.EMP3_FNT TEACHER
            FROM [eTraining].[dbo].vwREPORTTRAININGHISTORY VH WHERE VH.PYE_PSC = '".$employeecode."' ORDER BY PY_CDS ASC";
            $params_seTrainingData = array();
            $query_seTrainingData = sqlsrv_query($conn, $sql_seTrainingData, $params_seTrainingData);
            while ($result_seTrainingData = sqlsrv_fetch_array($query_seTrainingData, SQLSRV_FETCH_ASSOC)) {
                $PATTERNDATE =$result_seTrainingData['PY_CDS'];
                $PATTERNEND =$result_seTrainingData['PY_CDE'];
          
                $DSSUB = explode("-", $PATTERNDATE);
                $PY_CDSSUB=$DSSUB[2].'/'.$DSSUB[1].'/'.$DSSUB[0];
                $DESUB = explode("-", $PATTERNEND);
                $PY_CDESUB=$DESUB[2].'/'.$DESUB[1].'/'.$DESUB[0];         
         ?>

         <tr>

           <td style="text-align: center"><?= $i ?></td>
           <!-- <td><?= $result_seTrainingData['PersonCode'] ?></td>
           <td><?= $result_seTrainingData['FnameT'] ?> <?= $result_seTrainingData['LnameT'] ?></td>
           <td><?= $result_seTrainingData['PositionNameT'] ?></td> -->
           <td><?= $PY_CDSSUB; ?></td>
           <td><?= $result_seTrainingData['Patern_Name'] ?></td>
           <td><?= $result_seTrainingData['Patern_descrition'] ?></td>
           <td><?= $result_seTrainingData['Patern_Hour'] ?></td>
           <td><?= $result_seTrainingData['Professor_NameT'] ?></td>

         </tr>
         <?php
         $i++;
       }
       ?>




     </tbody>

   </table>

   <?php
 }
 if ($_POST['txt_flg'] == "select_customercompensationdetail") {
   // echo $_POST['planid'];
   ?>
   <?php
   $sql_ChkData = "SELECT DISTINCT a.COMPANYCODE,a.CUSTOMERCODE,b.C2
   FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
   INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
   WHERE a.VEHICLETRANSPORTPLANID ='" . $_POST['planid'] . "' ";
   $params_ChkData = array();
   $query_ChkData = sqlsrv_query($conn, $sql_ChkData, $params_ChkData);
   $result_ChkData = sqlsrv_fetch_array($query_ChkData, SQLSRV_FETCH_ASSOC);
   ?>
   <!-- /////////ข้อมูลแถวแรก//////////// -->
   <th>  (<?= ($result_ChkData['C2'] != '') ? "ขากลับ" : "ขาไป" ?>)</th>

   <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
     <thead>
       <tr>
         <?php
         if ($result_ChkData['COMPANYCODE'] =='RRC' || $result_ChkData['COMPANYCODE'] =='RCC' || $result_ChkData['COMPANYCODE'] =='RATC' ) {
           ?>
           <th >เลขทริป(GW)DATA2</th>
           <th >เลขทริป(BP)</th>
           <th >เลขทริป(SR)</th>
           <th >ศุลกากรใน</th>
           <th >ศุลกากรนอก</th>

           <?php
         }else {
           ?>

           <?php
         }
         ?>


       </tr>
     </thead>
     <tbody>
       <?php
       $i = 1;
       $sql_seCompensationdetail = "SELECT DISTINCT  a.VEHICLETRANSPORTPLANID,b.THAINAME,a.EMPLOYEENAME1,a.EMPLOYEENAME2,b.JOBNO,b.C2
       FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
       INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
       WHERE a.VEHICLETRANSPORTPLANID ='" . $_POST['planid'] . "' ";
       $params_seCompensationdetail = array();
       $query_seCompensationdetail = sqlsrv_query($conn, $sql_seCompensationdetail, $params_seCompensationdetail);
       while ($result_seCompensationdetail = sqlsrv_fetch_array($query_seCompensationdetail, SQLSRV_FETCH_ASSOC)) {

         $sql_seTripNo = "SELECT DISTINCT a.VEHICLETRANSPORTPLANID,a.VEHICLETRANSPORTDOCUMENTDRIVERID,
         a.TRIPNUMBER,a.TRIPNUMBER2,a.TRIPNUMBER3,a.TRIPNUMBER4,a.TRIPNUMBER5
         FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
         WHERE a.VEHICLETRANSPORTPLANID ='" . $_POST['planid'] . "'
         AND (TRIPNUMBER IS NOT NULL
         OR TRIPNUMBER2 IS NOT NULL
         OR TRIPNUMBER3 IS NOT NULL
         OR TRIPNUMBER4 IS NOT NULL
         OR TRIPNUMBER5 IS NOT NULL)";
         $params_seTripNo = array();
         $query_seTripNo = sqlsrv_query($conn, $sql_seTripNo, $params_seTripNo);
         $result_seTripNo = sqlsrv_fetch_array($query_seTripNo, SQLSRV_FETCH_ASSOC);


         ?>
         <tr>
           <?php
           if ($result_ChkData['COMPANYCODE'] =='RRC' || $result_ChkData['COMPANYCODE'] =='RCC' || $result_ChkData['COMPANYCODE'] =='RATC' ) {
             ?>

             <td style="width: 20%"><input type="text" class="form-control" name = "txt_tripnumber" id="txt_tripnumber" onchange="edit_job(this.value,'TRIPNUMBER', '<?=$result_seTripNo['VEHICLETRANSPORTDOCUMENTDRIVERID']?>', '<?=$result_seTripNo['VEHICLETRANSPORTPLANID']?>')" value="<?= $result_seTripNo['TRIPNUMBER']?>"></td>
             <td style="width: 20%"><input type="text" class="form-control" name = "txt_tripnumber2" id="txt_tripnumber2" onchange="edit_job(this.value,'TRIPNUMBER2', '<?=$result_seTripNo['VEHICLETRANSPORTDOCUMENTDRIVERID']?>', '<?=$result_seTripNo['VEHICLETRANSPORTPLANID']?>')" value="<?= $result_seTripNo['TRIPNUMBER2']?>"></td>
             <td style="width: 20%"><input type="text" class="form-control" name = "txt_tripnumber3" id="txt_tripnumber3" onchange="edit_job(this.value,'TRIPNUMBER3', '<?=$result_seTripNo['VEHICLETRANSPORTDOCUMENTDRIVERID']?>', '<?=$result_seTripNo['VEHICLETRANSPORTPLANID']?>')" value="<?= $result_seTripNo['TRIPNUMBER3']?>"></td>
             <td style="width: 20%"><input type="text" class="form-control" name = "txt_tripnumber4" id="txt_tripnumber4" onchange="edit_job(this.value,'TRIPNUMBER4', '<?=$result_seTripNo['VEHICLETRANSPORTDOCUMENTDRIVERID']?>', '<?=$result_seTripNo['VEHICLETRANSPORTPLANID']?>')" value="<?= $result_seTripNo['TRIPNUMBER4']?>"></td>
             <td style="width: 20%"><input type="text" class="form-control" name = "txt_tripnumber5" id="txt_tripnumber5" onchange="edit_job(this.value,'TRIPNUMBER5', '<?=$result_seTripNo['VEHICLETRANSPORTDOCUMENTDRIVERID']?>', '<?=$result_seTripNo['VEHICLETRANSPORTPLANID']?>')" value="<?= $result_seTripNo['TRIPNUMBER5']?>"></td>
             <?php
           }else {
             ?>

             <?php
           }
           ?>


         </tr>
         <?php
         $i++;
       }
       ?>
     </tbody>

   </table>
   <br>
   <!-- /////////ข้อมูลแถวสอง//////////// -->
   <table style="background-color: #e7e7e7" width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
     <thead>
       <tr>
         <?php
         if ($result_ChkData['COMPANYCODE'] =='RRC' || $result_ChkData['COMPANYCODE'] =='RCC' || $result_ChkData['COMPANYCODE'] =='RATC' ) {
           ?>
           <th >JOBNO</th>
           <th >ทะเบียนรถ</th>
           <th >พขร.คนที่1</th>
           <th >พขร.คนที่2</th>
           <?php
         }else {
           ?>
           <th >ทะเบียนรถ</th>
           <th >พขร.คนที่1</th>
           <th >พขร.คนที่2</th>
           <?php
         }
         ?>


       </tr>
     </thead>
     <tbody>
       <?php
       $i = 1;
       $sql_seCompensationdetail = "SELECT DISTINCT  a.VEHICLETRANSPORTPLANID,b.THAINAME,a.EMPLOYEENAME1,a.EMPLOYEENAME2,b.JOBNO
       FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
       INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
       WHERE a.VEHICLETRANSPORTPLANID ='" . $_POST['planid'] . "' ";
       $params_seCompensationdetail = array();
       $query_seCompensationdetail = sqlsrv_query($conn, $sql_seCompensationdetail, $params_seCompensationdetail);
       while ($result_seCompensationdetail = sqlsrv_fetch_array($query_seCompensationdetail, SQLSRV_FETCH_ASSOC)) {
         ?>
         <tr>
           <?php
           if ($result_ChkData['COMPANYCODE'] =='RRC' || $result_ChkData['COMPANYCODE'] =='RCC' || $result_ChkData['COMPANYCODE'] =='RATC' ) {
             ?>
             <td><?= $result_seCompensationdetail['JOBNO']?></td>
             <td><?= $result_seCompensationdetail['THAINAME'] ?></td>
             <td><?= $result_seCompensationdetail['EMPLOYEENAME1'] ?></td>
             <td><?= $result_seCompensationdetail['EMPLOYEENAME2'] ?></td>
             <?php
           }else {
             ?>
             <td><?= $result_seCompensationdetail['THAINAME'] ?></td>
             <td><?= $result_seCompensationdetail['EMPLOYEENAME1'] ?></td>
             <td><?= $result_seCompensationdetail['EMPLOYEENAME2'] ?></td>
             <?php
           }
           ?>


         </tr>
         <?php
         $i++;
       }
       ?>
     </tbody>

   </table>
   <br>
   <!-- /////////ข้อมูลแถวสาม//////////// -->
   <table style="background-color: #e7e7e7" width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
     <thead>
       <tr>
         <?php
         if ($result_ChkData['COMPANYCODE'] =='RRC' || $result_ChkData['COMPANYCODE'] =='RCC'|| $result_ChkData['COMPANYCODE'] =='RATC') {
           ?>
           <th>ต้นทาง</th>
           <th>CLUSTER/JOBEND</th>
           <th>หมายเลขเอกสาร</th>
           <th>จำนวน</th>
           <?php
         }else {
           ?>
           <th>ต้นทาง</th>
           <th>ปลายทาง</th>
           <th>หมายเลขเอกสาร</th>
           <th>น้ำหนัก1</th>
           <?php
         }

         ?>

       </tr>
     </thead>
     <tbody>
       <?php
       $i = 1;
       if ($result_ChkData['COMPANYCODE'] =='RKS' && $result_ChkData['CUSTOMERCODE'] =='TGT') {
         $sql_seCompensationdetail1 = "SELECT DISTINCT TOP 1  a.JOBSTART,a.JOBEND,a.DOCUMENTCODE,a.WEIGHTIN,a.COMPANYCODE,a.CUSTOMERCODE
         FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
         INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
         WHERE a.VEHICLETRANSPORTPLANID ='" . $_POST['planid'] . "' ";
         $params_seCompensationdetail1 = array();
         $query_seCompensationdetail1 = sqlsrv_query($conn, $sql_seCompensationdetail1, $params_seCompensationdetail1);
       }else if ($result_ChkData['COMPANYCODE'] =='RRC' || $result_ChkData['COMPANYCODE'] =='RCC'|| $result_ChkData['COMPANYCODE'] =='RATC' ){
         $sql_seCompensationdetail1 = "SELECT  a.JOBSTART,a.JOBEND,a.DOCUMENTCODE,a.WEIGHTIN,a.COMPANYCODE,a.CUSTOMERCODE,a.TRIPAMOUNT,a.VEHICLETRANSPORTDOCUMENTDRIVERID
         FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
         INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
         WHERE a.VEHICLETRANSPORTPLANID ='" . $_POST['planid'] . "'
         ORDER BY a.VEHICLETRANSPORTDOCUMENTDRIVERID ASC ";
         $params_seCompensationdetail1 = array();
         $query_seCompensationdetail1 = sqlsrv_query($conn, $sql_seCompensationdetail1, $params_seCompensationdetail1);
       }else {
         //////RKR RKL
         $sql_seCompensationdetail1 = "SELECT  a.JOBSTART,a.JOBEND,a.DOCUMENTCODE,a.WEIGHTIN,a.COMPANYCODE,a.CUSTOMERCODE
         FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
         INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
         WHERE a.VEHICLETRANSPORTPLANID ='" . $_POST['planid'] . "'";
         $params_seCompensationdetail1 = array();
         $query_seCompensationdetail1 = sqlsrv_query($conn, $sql_seCompensationdetail1, $params_seCompensationdetail1);
       }

       while ($result_seCompensationdetail1 = sqlsrv_fetch_array($query_seCompensationdetail1, SQLSRV_FETCH_ASSOC)) {



         $sql_seMileageTGT = "SELECT DISTINCT  TOP 1 a.COMPANYCODE,a.CUSTOMERCODE, a.JOBSTART,a.JOBEND,a.DOCUMENTCODE,b.JOBNO,c.MILEAGENUMBER AS 'MILEAGENUMBERSTART',c.MILEAGETYPE
         FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
         INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
         INNER JOIN [dbo].[MILEAGE] c ON c.JOBNO = b.JOBNO
         WHERE a.VEHICLETRANSPORTPLANID ='" . $_POST['planid'] . "'
         AND c.MILEAGETYPE='MILEAGESTART'
         AND c.MILEAGENUMBER != '0'
         AND c.MILEAGENUMBER IS NOT NULL
         ORDER BY c.MILEAGENUMBER DESC";
         $params_seMileageTGT = array();
         $query_seMileageTGT = sqlsrv_query($conn, $sql_seMileageTGT, $params_seMileageTGT);
         $result_seMileageTGT = sqlsrv_fetch_array($query_seMileageTGT, SQLSRV_FETCH_ASSOC);

         $sql_seMileageendTGT = "SELECT DISTINCT  TOP 1 c.MILEAGENUMBER AS 'MILEAGENUMBEREND',c.MILEAGETYPE
         FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
         INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
         INNER JOIN [dbo].[MILEAGE] c ON c.JOBNO = b.JOBNO
         WHERE a.VEHICLETRANSPORTPLANID ='" . $_POST['planid'] . "'
         AND c.MILEAGETYPE='MILEAGEEND'
         AND c.MILEAGENUMBER != '0'
         AND c.MILEAGENUMBER IS NOT NULL
         ORDER BY c.MILEAGENUMBER DESC";
         $params_seMileageendTGT = array();
         $query_seMileageendTGTT = sqlsrv_query($conn, $sql_seMileageendTGT, $params_seMileageendTGT);
         $result_seMileageendTGT = sqlsrv_fetch_array($query_seMileageendTGTT, SQLSRV_FETCH_ASSOC);
         ?>

         <tr>
           <?php
           if ($result_seCompensationdetail1['CUSTOMERCODE'] == 'TGT') {
             if ($result_seMileageTGT['MILEAGENUMBERSTART'] != '' && $result_seMileageendTGT['MILEAGENUMBEREND'] != '') {
               ?>
               <td><?= $result_seCompensationdetail1['JOBSTART'] ?></td>
               <td><?= $result_seCompensationdetail1['JOBEND'] ?></td>
               <td><?= $result_seMileageTGT['MILEAGENUMBERSTART'] ?> - <?= $result_seMileageendTGT['MILEAGENUMBEREND'] ?> (ไมล์ต้น-ไม่ล์ปลาย) </td>
               <td>-</td>
               <?php
             } else {
               ?>
               <td style="color:red;"><?= $result_seCompensationdetail1['JOBSTART'] ?></td>
               <td style="color:red;"><?= $result_seCompensationdetail1['JOBEND'] ?></td>
               <td style="color:red;"><?= $result_seMileageTGT['MILEAGENUMBER'] ?></td>
               <td style="color:red;">-</td>
               <?php
             }
             ?>

             <?php
           } else if ($result_seCompensationdetail1['COMPANYCODE'] == 'RKR') {
             if ($result_seCompensationdetail1['DOCUMENTCODE'] != '' || $result_seCompensationdetail1['WEIGHTIN'] != '') {
               ?>
               <td><?= $result_seCompensationdetail1['JOBSTART'] ?></td>
               <td><?= $result_seCompensationdetail1['JOBEND'] ?></td>
               <td><?= $result_seCompensationdetail1['DOCUMENTCODE'] ?></td>
               <td><?= $result_seCompensationdetail1['WEIGHTIN'] ?></td>
               <?php
             } else {
               ?>
               <td style="color:red;"><?= $result_seCompensationdetail1['JOBSTART'] ?></td>
               <td style="color:red;"><?= $result_seCompensationdetail1['JOBEND'] ?></td>
               <td style="color:red;"><?= $result_seCompensationdetail1['DOCUMENTCODE'] ?></td>
               <td style="color:red;"><?= $result_seCompensationdetail1['WEIGHTIN'] ?></td>
               <?php
             }
             ?>

             <?php
           } else if ($result_seCompensationdetail1['COMPANYCODE'] == 'RKL') {
             if ($result_seCompensationdetail1['DOCUMENTCODE'] != '' || $result_seCompensationdetail1['WEIGHTIN'] != '') {
               ?>
               <td><?= $result_seCompensationdetail1['JOBSTART'] ?></td>
               <td><?= $result_seCompensationdetail1['JOBEND'] ?></td>
               <td><?= $result_seCompensationdetail1['DOCUMENTCODE'] ?></td>
               <td><?= $result_seCompensationdetail1['WEIGHTIN'] ?></td>
               <?php
             } else {
               ?>
               <td style="color:red;"><?= $result_seCompensationdetail1['JOBSTART'] ?></td>
               <td style="color:red;"><?= $result_seCompensationdetail1['JOBEND'] ?></td>
               <td style="color:red;"><?= $result_seCompensationdetail1['DOCUMENTCODE'] ?></td>
               <td style="color:red;"><?= $result_seCompensationdetail1['WEIGHTIN'] ?></td>
               <?php
             }
             ?>

             <?php
           } else if ($result_seCompensationdetail1['COMPANYCODE'] == 'RRC' || $result_seCompensationdetail1['COMPANYCODE'] == 'RCC' || $result_seCompensationdetail1['COMPANYCODE'] == 'RATC') {
             ?>
             <td><?= $result_seCompensationdetail1['JOBSTART'] ?></td>
             <td><?= $result_seCompensationdetail1['JOBEND'] ?></td>
             <td><input type="text" class="form-control" name = "txt_documentcode" id="txt_documentcode" onchange="edit_jobdo(this.value,'DOCUMENTCODE', '<?=$result_seCompensationdetail1['VEHICLETRANSPORTDOCUMENTDRIVERID']?>', '<?=$result_seTripNo['VEHICLETRANSPORTPLANID']?>')" value="<?= $result_seCompensationdetail1['DOCUMENTCODE'] ?>"></td>
             <td><input type="text" class="form-control" name = "txt_tripamount" id="txt_tripamount" onchange="edit_jobdo(this.value,'TRIPAMOUNT', '<?=$result_seCompensationdetail1['VEHICLETRANSPORTDOCUMENTDRIVERID']?>', '<?=$result_seTripNo['VEHICLETRANSPORTPLANID']?>')" value="<?= $result_seCompensationdetail1['TRIPAMOUNT'] ?>"></td>


             <?php
           } else {
             if ($result_seCompensationdetail1['DOCUMENTCODE'] != '') {
               ?>
               <td><?= $result_seCompensationdetail1['JOBSTART'] ?></td>
               <td><?= $result_seCompensationdetail1['JOBEND'] ?></td>
               <td><?= $result_seCompensationdetail1['DOCUMENTCODE'] ?></td>
               <td>-</td>
               <?php
             } else {
               ?>
               <td style="color:red;"><?= $result_seCompensationdetail1['JOBSTART'] ?></td>
               <td style="color:red;"><?= $result_seCompensationdetail1['JOBEND'] ?></td>
               <td style="color:red;"><?= $result_seCompensationdetail1['DOCUMENTCODE'] ?></td>
               <td style="color:red;">-</td>
               <?php
             }
             ?>
             <?php
           }
           ?>
         </tr>
         <?php
         $i++;
       } //loop while
       ?>

     </tbody>

   </table>
   <br>
   <!-- /////////ข้อมูลแถวสี่//////////// -->
   <table style="background-color: #e7e7e7" width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
     <thead>
       <tr>
         <?php
         if ($result_ChkData['COMPANYCODE'] =='RRC' || $result_ChkData['COMPANYCODE'] =='RCC'|| $result_ChkData['COMPANYCODE'] =='RATC') {
           ?>
           <th>ค่าเที่ยวพขร.คนที่11</th>
           <th>ค่าเที่ยวพขร.คนที่2</th>
           <th>ค่าเที่ยวพขร.คนที่3</th>
           <th>รวมสุทธิค่าเที่ยว</th>
           <th>ค่าเฉลี่ยน้ำมัน</th>
           <?php
         }else {
           ?>
           <th>ค่าเที่ยวพขร.คนที่1</th>
           <th>ค่าเที่ยวพขร.คนที่2</th>
           <th>ค่าเที่ยวพขร.คนที่3</th>
           <th>ค่าทางด่วน</th>
           <th>ค่าเฉลี่ยน้ำมัน</th>
           <?php
         }
         ?>



       </tr>
     </thead>
     <tbody>
       <?php
       $i = 1;
       $sql_sePayrepair = "SELECT SUM(CONVERT(INT,PAY_REPAIR)) AS 'PAYREPAIR'
       FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
       INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
       WHERE a.VEHICLETRANSPORTPLANID = '" . $_POST['planid'] . "'";
       $query_sePayrepair = sqlsrv_query($conn, $sql_sePayrepair, $params_sePayrepair);
       $result_sePayrepair = sqlsrv_fetch_array($query_sePayrepair, SQLSRV_FETCH_ASSOC);


       $sql_seCompensationdetail = "SELECT DISTINCT TOP 1 a.COMPENSATION1,a.COMPENSATION2,a.COMPENSATION3,a.TOTALNET,b.C3 AS 'AVGOIL'
       FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
       INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
       WHERE a.COMPENSATION1 IS NOT NULL
       AND a.COMPENSATION2 IS NOT NULL
       AND a.VEHICLETRANSPORTPLANID = '" . $_POST['planid'] . "' ";
	   // AND a.COMPENSATION3 IS NOT NULL
       $params_seCompensationdetail = array();
       $query_seCompensationdetail = sqlsrv_query($conn, $sql_seCompensationdetail, $params_seCompensationdetail);
       while ($result_seCompensationdetail = sqlsrv_fetch_array($query_seCompensationdetail, SQLSRV_FETCH_ASSOC)) {
         ?>
         <tr>

           <td><?= $result_seCompensationdetail['COMPENSATION1'] ?></td>
           <td><?= $result_seCompensationdetail['COMPENSATION2'] ?></td>
           <td><?= $result_seCompensationdetail['COMPENSATION3'] ?></td>
           <?php
           if ($result_ChkData['COMPANYCODE'] =='RKR' || $result_ChkData['COMPANYCODE'] =='RKL') {
             ?>
             <td><?= $result_sePayother['PAYOTHER'] ?></td>
             <?php
           }else if($result_ChkData['COMPANYCODE'] =='RKS') {
             ?>
             <td><?= $result_seExpressway['SUMEXPRESSWAY'] ?></td>
             <?php
           }else {
             ?>
              <td><?= $result_seCompensationdetail['TOTALNET'] ?></td>  
             <?php
           }
           ?>

           <td><?= $result_seCompensationdetail['AVGOIL'] ?></td>

         </tr>
         <?php
         $i++;
       }
       ?>
     </tbody>

   </table>
   <br>
   <!-- /////////ข้อมูลแถวห้า//////////// -->
   <table style="background-color: #e7e7e7" width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
     <thead>
       <tr>
         <?php
         if ($result_ChkData['COMPANYCODE'] =='RRC' || $result_ChkData['COMPANYCODE'] =='RCC'|| $result_ChkData['COMPANYCODE'] =='RATC') {
           ?>
           <th>ค่าซ่อม</th>
           <th>ค่าตีเปล่าพขร.คนที่1</th>
           <th>ค่าตีเปล่าพขร.คนที่2</th>
           <th>ค่าตีเปล่าพขร.คนที่3</th>
           <?php
         }else {
           ?>

           <?php
         }
         ?>



       </tr>
     </thead>
     <tbody>
       <?php
       $i = 1;
       $sql_sePayrepair = "SELECT SUM(CONVERT(INT,PAY_REPAIR)) AS 'PAYREPAIR'
       FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
       INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
       WHERE a.VEHICLETRANSPORTPLANID = '" . $_POST['planid'] . "'";
       $query_sePayrepair = sqlsrv_query($conn, $sql_sePayrepair, $params_sePayrepair);
       $result_sePayrepair = sqlsrv_fetch_array($query_sePayrepair, SQLSRV_FETCH_ASSOC);


       $sql_sePayEmply = "SELECT a.EEMPTY1,a.EEMPTY2,a.EEMPTY3
       FROM [dbo].[VEHICLETRANSPORTPLAN] a
       WHERE a.VEHICLETRANSPORTPLANID = '" . $_POST['planid'] . "'";
       $query_sePayEmply = sqlsrv_query($conn, $sql_sePayEmply, $params_sePayEmply );
       $result_sePayEmply = sqlsrv_fetch_array($query_sePayEmply, SQLSRV_FETCH_ASSOC);


       ?>
       <tr>
         <?php
         if ($result_ChkData['COMPANYCODE'] =='RRC' || $result_ChkData['COMPANYCODE'] =='RCC'|| $result_ChkData['COMPANYCODE'] =='RATC') {
           ?>
           <td><?= $result_sePayrepair['PAYREPAIR'] ?></td>
           <td><?= $result_sePayEmply['EEMPTY1'] ?></td>
           <td><?= $result_sePayEmply['EEMPTY2'] ?></td>
           <td><?= $result_sePayEmply['EEMPTY3'] ?></td>
           <?php
         }else {
           ?>

           <?php
         }
         ?>


       </tr>


     </tbody>
   </table>
   <!-- /////////ข้อมูลแถวหก//////////// -->
   <table style="background-color: #e7e7e7" width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
     <thead>
       <tr>
         <?php
         if ($result_ChkData['COMPANYCODE'] =='RRC' || $result_ChkData['COMPANYCODE'] =='RCC' || $result_ChkData['COMPANYCODE'] =='RATC' ) {
           ?>
           <th >ค่าอื่นๆ</th>
           <th >หมายเหตุ</th>
           <?php
         }else {
           ?>

           <?php
         }
         ?>


       </tr>
     </thead>
     <tbody>
       <?php
       $i = 1;
       $sql_seOther = "SELECT DISTINCT a.OTHER,a.PAY_REMARK
       FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
       WHERE a.VEHICLETRANSPORTPLANID ='" . $_POST['planid'] . "' ";
       $params_seOther = array();
       $query_seOther  = sqlsrv_query($conn, $sql_seOther, $params_seOther);
       $result_seOther  = sqlsrv_fetch_array($query_seOther, SQLSRV_FETCH_ASSOC);
       ?>
       <tr>
         <?php
         if ($result_ChkData['COMPANYCODE'] =='RRC' || $result_ChkData['COMPANYCODE'] =='RCC' || $result_ChkData['COMPANYCODE'] =='RATC' ) {
           ?>
           <td><?= $result_seOther['OTHER'] == 'NULL' ? '':$result_seOther['OTHER']?></td>
           <td><?= $result_seOther['PAY_REMARK'] ?></td>

           <?php
         }else {
           ?>

           <?php
         }
         ?>

       </tr>
     </tbody>
   </table>
   <!-- ปิดงาน และแก้ไขงาน -->
   <?php
   $sql_ChkOpenJob = "SELECT [STATUS],STATUSNUMBER
   FROM  [dbo].[VEHICLETRANSPORTPLAN]
   WHERE VEHICLETRANSPORTPLANID = '" . $_POST['planid'] . "'";
   $query_ChkOpenJob = sqlsrv_query($conn, $sql_ChkOpenJob, $params_ChkOpenJob);
   $result_ChkOpenJob = sqlsrv_fetch_array($query_ChkOpenJob, SQLSRV_FETCH_ASSOC);
   ?>
   <?php
   if ($result_ChkOpenJob['STATUSNUMBER'] == '1' OR $result_ChkOpenJob['STATUSNUMBER'] == 'T') {
   ?>
    <table style="background-color: #e7e7e7" width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
     <thead>
       <tr>
           <th >แก้ไขงาน</th>
           <th >ปิดงาน</th>
       </tr>
     </thead>
     <tbody>
       <tr>
           <td><button style="height:40px;width:400px" type="button" class="btn btn-warning btn-md" name="editjob_btn" id ="editjob_btn"  onclick="editjob('<?= $_POST['companycode'] ?>','<?= $_POST['customercode'] ?>','<?= $_POST['planid'] ?>','<?= $_POST['statusnumber'] ?>','<?= $_POST['datestart'] ?>','<?= $_POST['dateend'] ?>');" >แก้ไขงาน</button></td>
           <td><button style="height:40px;width:400px" type="button" class="btn btn-success btn-md" name="closejob_btn" id ="closejob_btn"  onclick="closejob('<?= $_POST['planid'] ?>');" >ปิดงาน</button></td>
       </tr>
     </tbody>
   </table>

   <?php
   }else {
    ?>
    <table style="background-color: #e7e7e7" width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
     <thead>
       <tr>
           <th >แก้ไขงาน</th>
           <th ></th>
       </tr>
     </thead>
     <tbody>
       <tr>
       <td><button style="height:40px;width:400px" type="button" class="btn btn-warning btn-md" name="editjob_btn" id ="editjob_btn"  onclick="editjob('<?= $_POST['companycode'] ?>','<?= $_POST['customercode'] ?>','<?= $_POST['planid'] ?>','<?= $_POST['statusnumber'] ?>','<?= $_POST['datestart'] ?>','<?= $_POST['dateend'] ?>');" >แก้ไขงาน</button></td>
           <td></td>
       </tr>
     </tbody>
   </table>
    <?php
   }
   
   ?>

   <?php
 }
 if ($_POST['txt_flg'] == "select_keylogger") {
   // echo $_POST['planid'];
   ?>
   
    <div class="col-lg-6"  >
        <div class="row">
            <div class="form-group" style="text-align: center;"> <h2>ทะเบียนรถ: <u><?=$_POST['regisnumber']?></u></h2></div>
        </div>
    </div>
    <div class="col-lg-6" >
        <div class="row">
            <?php
            if ($_POST['truckstatus'] == 'รถวิ่งงาน') {
            ?>
                <div class="form-group" style="text-align: center;"> 
                    <h2>สถานะ: <u><?=$_POST['truckstatus']?></u></h2>
                </div>
            <?php
            }else if ($_POST['truckstatus'] == 'พร้อมใช้งาน') {
            ?>
                <div class="form-group" style="text-align: center;"> 
                    <h2>สถานะ: <u><?=$_POST['truckstatus']?></u></h2>
                </div>
            <?php
            }else if ($_POST['truckstatus'] == 'แจ้งซ่อม') {
            ?>
                <div class="form-group" style="text-align: center;"> 
                    <h2>สถานะ: <u>รถซ่อม</u></h2>
                </div>
            <?php
            }else if ($_POST['truckstatus'] == 'หยุดรถ') {
            ?>
                <div class="form-group" style="text-align: center;"> 
                    <h2>สถานะ: <u><?=$_POST['truckstatus']?></u></h2>
                </div>
            <?php
            }else if ($_POST['truckstatus'] == 'ตรวจรถ') {
            ?>
                <div class="form-group" style="text-align: center;"> 
                    <h2>สถานะ: <u><?=$_POST['truckstatus']?></u></h2>
                </div>
            <?php
            }else if ($_POST['truckstatus'] == 'ล้างรถ') {
            ?>
                <div class="form-group" style="text-align: center;"> 
                    <h2>สถานะ: <u><?=$_POST['truckstatus']?></u></h2>
                </div>
            <?php
            }else{
            ?>

            <?php
            }
            ?>
            
        </div>
    </div>
    <!-- รูปรถสถานะ -->
    <div class="col-lg-12" >
        <div class="row">
            <?php
            if ($_POST['truckstatus'] == 'รถวิ่งงาน') {
            ?>
               <div class="form-group" style="text-align: center;background-color:#f4f786">
                    <img src="../images/keylogger/working.png" width="120" height="100" >
                </div>
            <?php
            }else if ($_POST['truckstatus'] == 'พร้อมใช้งาน') {
            ?>
                <div class="form-group" style="text-align: center;background-color:#93f786"> 
                   <img src="../images/keylogger/ready_truck.png" width="120" height="100">
                </div>
            <?php
            }else if ($_POST['truckstatus'] == 'แจ้งซ่อม') {
            ?>
                <div class="form-group" style="text-align: center;background-color:#f79986"> 
                    <img src="../images/keylogger/repair2.png" width="120" height="100" >
                </div>
            <?php
            }else if ($_POST['truckstatus'] == 'หยุดรถ') {
            ?>
                <div class="form-group" style="text-align: center;background-color:#fa3c3c"> 
                    <img src="../images/keylogger/stop1.png" width="120" height="100" >
                </div>
            <?php
            }else if ($_POST['truckstatus'] == 'ตรวจรถ') {
            ?>
                <div class="form-group" style="text-align: center;background-color:#f7c086">
                    <img src="../images/keylogger/checklist1.png" width="120" height="100" >
                </div>
            <?php
            }else if ($_POST['truckstatus'] == 'ล้างรถ') {
            ?>
                <div class="form-group" style="text-align: center;background-color:#86d5f7"> 
                    <img src="../images/keylogger/wash.png" width="120" height="100" >
                </div>
            <?php
            }else{
            ?>

            <?php
            }
            ?>
            
        </div>
    </div>
    <div class="col-lg-12">
        
        <input type="text" name="se_regisnumber" id="se_regisnumber" value="<?= $_POST['regisnumber'] ?>" style="display:none">
        <input type="text" name="se_regisid" id="se_regisid" value="<?= $_POST['regisid'] ?>" style="display:none">
        <input type="text" name="se_jobno" id="se_jobno" value="<?= $_POST['jobno'] ?>" style="display:none">
        
    </div>
   <br>
   

   <?php
 }
 if ($_POST['txt_flg'] == "select_reporttransportroutehistory") {
   ?>
   <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
    <thead>
          <tr>
              <th>ลำดับ</th>
              <th>วันที่</th>
              <th>ทะเบียน</th>
              <th>ประเภทรถ</th>
              <th>ต้นทาง</th>
              <th>คลัสเตอร์</th>
              <th>ปลายทาง</th>
              <th>พขร.1</th>
              <th>พขร.2</th>
              <th>เลขไมค์ต้น</th>
              <th>เลขไมค์ปลาย</th>
              <th>กิโลเมตรที่วิ่งงาน</th>
              <th>เลขที่แผนงาน</th>
          </tr>
        </thead>
        <tbody>
       <?php
       
       //เช็คข้อมูลทะเบียนรถ
       $sql_checkthainame = "SELECT VEHICLEREGISNUMBER,THAINAME 
                            FROM VEHICLEINFO WHERE VEHICLEREGISNUMBER ='".$_POST['thainame']."'";
       $query_checkthainame  = sqlsrv_query($conn, $sql_checkthainame, $params_checkthainame);
       $result_checkthainame = sqlsrv_fetch_array($query_checkthainame, SQLSRV_FETCH_ASSOC);
       
       $i = 1;
       if($_POST['check'] == 'driverandthaiisnull'){
          $sql_seReporttransport = "SELECT CONVERT(VARCHAR(10),DATEWORKING,103) AS 'DATE',VEHICLETRANSPORTPLANID,JOBNO,
                CUSTOMERCODE,COMPANYCODE,THAINAME,THAINAME2,VEHICLETYPE,
                CLUSTER,JOBSTART,JOBEND,EMPLOYEECODE1,EMPLOYEENAME1,EMPLOYEECODE2,EMPLOYEENAME2
                FROM  [dbo].[VEHICLETRANSPORTPLAN] 
                WHERE  CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_POST['datestart']."',103) AND CONVERT(DATE,'".$_POST['dateend']."',103)
                ORDER BY DATEWORKING ASC";
          $query_seReporttransport = sqlsrv_query($conn, $sql_seReporttransport, $params_seReporttransport);
       }else if($_POST['check'] == 'driverisnull'){
            // $test = "driver";
            $sql_seReporttransport = "SELECT CONVERT(VARCHAR(10),DATEWORKING,103) AS 'DATE',VEHICLETRANSPORTPLANID,JOBNO,
                CUSTOMERCODE,COMPANYCODE,THAINAME,THAINAME2,VEHICLETYPE,
                CLUSTER,JOBSTART,JOBEND,EMPLOYEECODE1,EMPLOYEENAME1,EMPLOYEECODE2,EMPLOYEENAME2
                FROM  [dbo].[VEHICLETRANSPORTPLAN] 
                WHERE (THAINAME ='".$result_checkthainame['THAINAME']."' OR THAINAME ='".$result_checkthainame['VEHICLEREGISNUMBER']."')
                AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_POST['datestart']."',103) AND CONVERT(DATE,'".$_POST['dateend']."',103)
                ORDER BY DATEWORKING ASC";
            $query_seReporttransport = sqlsrv_query($conn, $sql_seReporttransport, $params_seReporttransport);
        }else if ($_POST['check'] == 'thainameisnull') {
            // $test = "thainame";
            $sql_seReporttransport = "SELECT CONVERT(VARCHAR(10),DATEWORKING,103) AS 'DATE',VEHICLETRANSPORTPLANID,JOBNO,
                CUSTOMERCODE,COMPANYCODE,THAINAME,THAINAME2,VEHICLETYPE,
                CLUSTER,JOBSTART,JOBEND,EMPLOYEECODE1,EMPLOYEENAME1,EMPLOYEECODE2,EMPLOYEENAME2 
                FROM  [dbo].[VEHICLETRANSPORTPLAN] 
                WHERE (EMPLOYEECODE1 ='".$_POST['drivername']."' OR EMPLOYEECODE2 = '".$_POST['drivername']."')
                AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_POST['datestart']."',103) AND CONVERT(DATE,'".$_POST['dateend']."',103)
                ORDER BY DATEWORKING ASC";
            $query_seReporttransport = sqlsrv_query($conn, $sql_seReporttransport, $params_seReporttransport);
        }else{
            // $test = "complete";
            $sql_seReporttransport = "SELECT CONVERT(VARCHAR(10),DATEWORKING,103) AS 'DATE',VEHICLETRANSPORTPLANID,JOBNO,
                CUSTOMERCODE,COMPANYCODE,THAINAME,THAINAME2,VEHICLETYPE,
                CLUSTER,JOBSTART,JOBEND,EMPLOYEECODE1,EMPLOYEENAME1,EMPLOYEECODE2,EMPLOYEENAME2
                FROM  [dbo].[VEHICLETRANSPORTPLAN] 
                WHERE (EMPLOYEECODE1 ='".$_POST['drivername']."' OR EMPLOYEECODE2 = '".$_POST['drivername']."')
                AND (THAINAME ='".$result_checkthainame['THAINAME']."' OR THAINAME ='".$result_checkthainame['VEHICLEREGISNUMBER']."')
                AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_POST['datestart']."',103) AND CONVERT(DATE,'".$_POST['dateend']."',103)
                ORDER BY DATEWORKING ASC";
            $query_seReporttransport = sqlsrv_query($conn, $sql_seReporttransport, $params_seReporttransport);
        }
       while ($result_seReporttransport = sqlsrv_fetch_array($query_seReporttransport, SQLSRV_FETCH_ASSOC)) {

            //ไมล์ต้น
            $sql_mileagestart = "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGESTART',JOBNO 
            FROM MILEAGE WHERE JOBNO ='".$result_seReporttransport['JOBNO']."'
            AND MILEAGETYPE ='MILEAGESTART'
            ORDER BY CREATEDATE DESC";
            $query_mileagestart  = sqlsrv_query($conn, $sql_mileagestart, $params_mileagestart);
            $result_mileagestart = sqlsrv_fetch_array($query_mileagestart, SQLSRV_FETCH_ASSOC);    
            //ไมล์ปลาย
            $sql_mileageend = "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGEEND',JOBNO 
            FROM MILEAGE WHERE JOBNO ='".$result_seReporttransport['JOBNO']."'
            AND MILEAGETYPE ='MILEAGEEND'
            ORDER BY CREATEDATE DESC";
            $query_mileageend  = sqlsrv_query($conn, $sql_mileageend, $params_mileageend);
            $result_mileageend = sqlsrv_fetch_array($query_mileageend, SQLSRV_FETCH_ASSOC);    
   
             ?>

             <tr>
               <!-- <td style="text-align: center"><?=$test?></td>   -->
               <td style="text-align: center"><?=$i?></td>
               <td><?=$result_seReporttransport['DATE']?></td>
               <td><?=$result_seReporttransport['THAINAME']?></td>
               <td><?=$result_seReporttransport['VEHICLETYPE']?></td>
               <td><?=$result_seReporttransport['JOBSTART']?></td>
               <td><?=$result_seReporttransport['CLUSTER']?></td>
               <td><?=$result_seReporttransport['JOBEND']?></td>
               <td><?=$result_seReporttransport['EMPLOYEENAME1']?></td>
               <td><?=$result_seReporttransport['EMPLOYEENAME2']?></td>
               <td><?=$result_mileagestart['MILEAGESTART']?></td>
               <td><?=$result_mileageend['MILEAGEEND']?></td>
               <td><?=$result_mileageend['MILEAGEEND']-$result_mileagestart['MILEAGESTART']?></td>
               <td><?=$result_seReporttransport['JOBNO']?></td>
             </tr>
             <?php
             $i++;
           }
           ?>
         </tbody>
   <?php
 }
 if ($_POST['txt_flg'] == "select_checkingdetail") {
//    echo $_POST['jobno'];
   ?>
   <?php
   $sql_ChkData = "SELECT EMPLOYEECODE1,EMPLOYEENAME1,EMPLOYEECODE2,EMPLOYEENAME2
   ,THAINAME,THAINAME2,[STATUS],STATUSNUMBER,JOBSTART,CLUSTER,JOBEND
   FROM [dbo].[VEHICLETRANSPORTPLAN] a
   WHERE a.JOBNO ='".$_POST['jobno']."' ";
   $params_ChkData = array();
   $query_ChkData = sqlsrv_query($conn, $sql_ChkData, $params_ChkData);
   $result_ChkData = sqlsrv_fetch_array($query_ChkData, SQLSRV_FETCH_ASSOC);
// echo $result_ChkData['EMPLOYEECODE1'];

   //เช็คการทำ Tenko พขร.คนที่1
   $sql_ChkDataTenko1 = "SELECT CONVERT(INT, TENKOAFTERGREETCHECK)+CONVERT(INT, TENKOUNIFORMCHECK)+CONVERT(INT, TENKOBODYCHECK)
   +CONVERT(INT, TENKORESTCHECK)+CONVERT(INT, TENKOSLEEPTIMECHECK)+CONVERT(INT, TENKOTEMPERATUREREMARK)
   +CONVERT(INT, TENKOPRESSURECHECK)+CONVERT(INT, TENKOALCOHOLCHECK)+CONVERT(INT, TENKOOXYGENCHECK)
   +CONVERT(INT, TENKOWORRYCHECK)+CONVERT(INT, TENKODAILYTRAILERCHECK)+CONVERT(INT, TENKOCARRYCHECK)
   +CONVERT(INT, TENKOJOBDETAILCHECK)+CONVERT(INT, TENKOLOADINFORMCHECK)+CONVERT(INT, TENKOAIRINFORMCHECK)
   +CONVERT(INT, TENKOYOKOTENCHECK)+CONVERT(INT, TENKOCHIMOLATORCHECK)+CONVERT(INT, TENKOTRANSPORTCHECK)
   +CONVERT(INT, TENKOSHORTSIGHTCHECK)+CONVERT(INT, TENKOLONGSIGHTCHECK)+CONVERT(INT, TENKOOBLIQUESIGHTCHECK) AS 'CHKTENKO'
    FROM TENKOBEFORE WHERE TENKOMASTERID ='".$_POST['tenkomasterid']."'
    AND TENKOMASTERDIRVERCODE ='".$result_ChkData['EMPLOYEECODE1']."'";
   $params_ChkDataTenko1 = array();
   $query_ChkDataTenko1 = sqlsrv_query($conn, $sql_ChkDataTenko1, $params_ChkDataTenko1);
   $result_ChkDataTenko1 = sqlsrv_fetch_array($query_ChkDataTenko1, SQLSRV_FETCH_ASSOC);
    //   echo $result_ChkDataTenko1['CHKTENKO'];

   //เช็คการทำ Tenko พขร.คนที่2
   $sql_ChkDataTenko2 = "SELECT CONVERT(INT, TENKOAFTERGREETCHECK)+CONVERT(INT, TENKOUNIFORMCHECK)+CONVERT(INT, TENKOBODYCHECK)
   +CONVERT(INT, TENKORESTCHECK)+CONVERT(INT, TENKOSLEEPTIMECHECK)+CONVERT(INT, TENKOTEMPERATUREREMARK)
   +CONVERT(INT, TENKOPRESSURECHECK)+CONVERT(INT, TENKOALCOHOLCHECK)+CONVERT(INT, TENKOOXYGENCHECK)
   +CONVERT(INT, TENKOWORRYCHECK)+CONVERT(INT, TENKODAILYTRAILERCHECK)+CONVERT(INT, TENKOCARRYCHECK)
   +CONVERT(INT, TENKOJOBDETAILCHECK)+CONVERT(INT, TENKOLOADINFORMCHECK)+CONVERT(INT, TENKOAIRINFORMCHECK)
   +CONVERT(INT, TENKOYOKOTENCHECK)+CONVERT(INT, TENKOCHIMOLATORCHECK)+CONVERT(INT, TENKOTRANSPORTCHECK)
   +CONVERT(INT, TENKOSHORTSIGHTCHECK)+CONVERT(INT, TENKOLONGSIGHTCHECK)+CONVERT(INT, TENKOOBLIQUESIGHTCHECK) AS 'CHKTENKO'
    FROM TENKOBEFORE WHERE TENKOMASTERID ='".$_POST['tenkomasterid']."'
    AND TENKOMASTERDIRVERCODE ='".$result_ChkData['EMPLOYEECODE2']."'";
   $params_ChkDataTenko2 = array();
   $query_ChkDataTenko2 = sqlsrv_query($conn, $sql_ChkDataTenko2, $params_ChkDataTenko2);
   $result_ChkDataTenko2 = sqlsrv_fetch_array($query_ChkDataTenko2, SQLSRV_FETCH_ASSOC);
//    echo $result_ChkDataTenko2['CHKTENKO'];

   ?>
   <!-- /////////ข้อมูลแถวแรก//////////// -->
   <th> เลขที่งาน: <b><u><?= $_POST['jobno']?> </u></b></th><br>
   <th> ทะเบียนรถ(ทะเบียนหัว): <b><u><?= $result_ChkData['THAINAME']?> </u></b></th><br>
   <th> ทะเบียนรถ(ทะเบียนหาง): <b><u><?= $result_ChkData['THAINAME2']?> </u></b></th>
    
   <br><br>
   <!--สถานะการตรวจร่างกาย  -->
   <th><b><u>สถานะการตรวจร่างกาย</u></b></th>
   <table style="background-color: #e7e7e7" width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info">
     <thead>
       <tr>
           <th >พขร.คนที่1 <br><b><u><?= $result_ChkData['EMPLOYEENAME1'] ?> </u></b></th>
           <th >พขร.คนที่2 <br><b><u><?= $result_ChkData['EMPLOYEENAME2'] ?> </u></b></th>
       </tr>
     </thead>
     <tbody>
         <tr>
            <!-- <td  style=" padding:4px;text-align:center;width: 15%" ><img data-lightbox="roadtrip" id="myImg" width="20%" src="../images/employee/<?=$result_ChkData['EMPLOYEECODE1']?>.JPG"></td> -->
            <!-- <td  style=" padding:4px;text-align:center;width: 15%" ><img  onclick="chkpic1();" width="20%" class="example-image" src="../images/employee/<?=$result_ChkData['EMPLOYEECODE1']?>.JPG" alt="Pic_Driver1" /></td> -->
            <!-- <p>
                <img style=" padding:4px;text-align:center;width: 15%" src="img/trees.jpg" data-action="zoom">
            </p> -->
            <!-- <td  style=" padding:4px;text-align:center;width: 15%" ><img  width="20%" class="example-image" src="../images/employee/<?=$result_ChkData['EMPLOYEECODE1']?>.JPG" alt="Pic_Driver1" /></td>
            <td  style=" padding:4px;text-align:center;width: 15%" ><img  width="20%" class="example-image" src="../images/employee/<?=$result_ChkData['EMPLOYEECODE2']?>.JPG" alt="Pic_Driver2" /></td>  -->

            <td  style=" padding:4px;text-align:center;width: 15%" ><img  style=" padding:4px;text-align:center;width: 20%" src="../images/employee/<?=$result_ChkData['EMPLOYEECODE1']?>.JPG" data-action="zoom" alt="Pic_Driver1" ></td>
            <td  style=" padding:4px;text-align:center;width: 15%" ><img  style=" padding:4px;text-align:center;width: 20%" src="../images/employee/<?=$result_ChkData['EMPLOYEECODE2']?>.JPG" data-action="zoom" alt="Pic_Driver2" ></td>
         </tr>
        
     
     </tbody>

   </table>
   <br><br>
   <!--สถานะการตรวจร่างกาย  -->
   <th><b><u>สถานะการตรวจร่างกาย</u></b></th>
   <table style="background-color: #e7e7e7" width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
     <thead>
       <tr>
           <th >พขร.คนที่1 <br><b><u><?= $result_ChkData['EMPLOYEENAME1'] ?> </u></b></th>
           <th >พขร.คนที่2 <br><b><u><?= $result_ChkData['EMPLOYEENAME2'] ?> </u></b></th>
       </tr>
     </thead>
     <tbody>
         <tr>
             <?php
             if ($result_ChkDataTenko1['CHKTENKO'] == '20' && $result_ChkDataTenko2['CHKTENKO'] == '20') {
             ?>
                <td style="background-color:#72FB66;text-align: center;"><span class="glyphicon glyphicon-ok"  style="color: green"></span></td>
                <td style="background-color:#72FB66;text-align: center;"><span class="glyphicon glyphicon-ok"  style="color: green"></span></td>
             <?php
             }else if ($result_ChkDataTenko1['CHKTENKO'] != '20' && $result_ChkDataTenko2['CHKTENKO'] == '20'){
             ?>
                <td style="background-color:#FB7866;text-align: center;"><span class="glyphicon glyphicon-remove" style="color: red"></span></td>
                <td style="background-color:#72FB66;text-align: center;"><span class="glyphicon glyphicon-ok"     style="color: green"></span></td>
             <?php
             }else if ($result_ChkDataTenko1['CHKTENKO'] == '20' && $result_ChkDataTenko2['CHKTENKO'] != '20'){
              ?>
                <td style="background-color:#72FB66;text-align: center;"><span class="glyphicon glyphicon-ok"     style="color: green"></span></td>
                <td style="background-color:#FB7866;text-align: center;"><span class="glyphicon glyphicon-remove" style="color: red"></span></td>    
            <?php
            }else{
             ?>
                <td style="background-color:#FB7866;text-align: center;"><span class="glyphicon glyphicon-remove"  style="color: red"></span></td>
                <td style="background-color:#FB7866;text-align: center;"><span class="glyphicon glyphicon-remove"  style="color: red"></span></td>
            <?php
            }
             ?>
             
         </tr>
        
     
     </tbody>

   </table>
   <br><br>
   <!-- สถานะการเปิดงาน -->
   <th><b><u>สถานะการเปิดงาน</u></b></th>
   <table style="background-color: #e7e7e7" width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
     <thead>
       <tr>
           <th>สถานะ</th>
           <th>เลขที่สถานะ</th>
           <th>ตรวจสอบ</th>
       </tr>
     </thead>
     <tbody>
         <tr>
             <?php
             if (($result_ChkData['STATUS'] =='แผนงานเปิดงาน' && $result_ChkData['STATUSNUMBER'] == '1')||($result_ChkData['STATUS'] =='แผนงานปิดงาน' && $result_ChkData['STATUSNUMBER'] == '2') || ($result_ChkData['STATUS'] =='แผนงานรอปิดงาน' && $result_ChkData['STATUSNUMBER'] == 'T') ) {
             ?>
                <td style="background-color:#72FB66;text-align: left;"><?= $result_ChkData['STATUS'] ?></td>
                <td style="background-color:#72FB66;text-align: left;"><?= $result_ChkData['STATUSNUMBER'] ?></td>
                <td style="background-color:#72FB66;text-align: left;"><span class="glyphicon glyphicon-ok"  style="color: green"></span></td>
             <?php
             }else {
            ?>
                <td style="background-color:#FB7866;text-align: left;"><?= $result_ChkData['STATUS'] ?></td>
                <td style="background-color:#FB7866;text-align: left;"><?= $result_ChkData['STATUSNUMBER'] ?></td>
                <td style="background-color:#FB7866;text-align: left;"><span class="glyphicon glyphicon-remove"  style="color: red"></span></td>   
            <?php
             }
             ?>
            
        </tr>
     </tbody>
   </table>
   <br><br>
   <!-- ข้อมูลการวิ่งงาน -->
   <th><b><u>ข้อมูลการวิ่งงาน</u></b></th>
   <table style="background-color: #e7e7e7" width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
     <thead>
       <tr>
           <th>ต้นทาง</th>
           <th>คลัสเตอร์</th>
           <th>ปลายทาง</th>
       </tr>
     </thead>
     <tbody>
         <tr>
                <td ><?= $result_ChkData['JOBSTART'] ?></td>
                <td ><?= $result_ChkData['CLUSTER'] ?></td>
                <td ><?= $result_ChkData['JOBEND'] ?></td>
        </tr>
     </tbody>
   </table>
   <br>
   
   <?php
 }
if ($_POST['txt_flg'] == "select_checkingKPI") {
//    echo $_POST['jobno'];
  ?>
    <!-- ข้อมูล TenkoNG -->
    <th><b><u><h3>ข้อมูล TenkoNG ประจำวันที่ <?=$_POST['date']?></h3></u></b></th>
    <div class="table-responsive">
    <table id="example" class="table table-striped table-hover responsive">
    </div>
  <!-- /////////ข้อมูลแถวแรก//////////// -->
  <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <div id="datadef">
    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;font-size:14px">
        <thead>
        <tr>
            <th style="text-align: center;">No</th>
            <th style="text-align: center;">Date</th>
            <th style="text-align: center;">DriverName</th>
            <th style="text-align: center;">TenkoNG</th>
            <th style="text-align: center;">Annual leave</th>
            <th style="text-align: center;">Sick leave</th>
            <th style="text-align: center;">Cause</th>
            <th style="text-align: center;">Action</th>
            </th>
        </tr>

        </thead>
    <tbody>
    <?php
    $i = 1;

    $sql_seTenkoNG = "SELECT TENKONG_ID,DATE_PROCESS,DRIVERNAME,TENKONG
    ,ANNUALLEAVE,SICKLEAVE,CAUSE_DATA,ACTION_DATA 
    FROM DIGITALTENKO_TENKONG
    WHERE DATE_PROCESS ='".$_POST['date']."'";
    $params_seTenkoNG = array();
    $query_seTenkoNG = sqlsrv_query($conn, $sql_seTenkoNG, $params_seTenkoNG);
    while ($result_seTenkoNG = sqlsrv_fetch_array($query_seTenkoNG, SQLSRV_FETCH_ASSOC)) {
        ?>
        <tr>
        <td style="text-align: center"><?= $i ?></td>
        <td><?= $result_seTenkoNG['DATE_PROCESS'] ?></td>
        <td><?= $result_seTenkoNG['DRIVERNAME'] ?></td>

        <!--TENKONG -->
        <?php
        if ($result_seTenkoNG['TENKONG'] == '1') {
        ?>  
            <!-- เครื่องหมายถูก -->
            <td style="padding:4px;text-align:center;font-size:14px;font-weight:bold;">&#10004;</td>
        <?php
        }else{
        ?>
            <!-- เครื่องหมายผิด -->
            <td style="padding:4px;text-align:center;font-size:18px;font-weight:bold;">&#120;</td>
        <?php
        }
        ?>

        <!--ANNUALLEAVE -->
        <?php
        if ($result_seTenkoNG['ANNUALLEAVE'] == '1') {
        ?>  
            <!-- เครื่องหมายถูก -->
            <td style="padding:4px;text-align:center;font-size:14px;font-weight:bold;">&#10004;</td>
        <?php
        }else{
        ?>
            <!-- เครื่องหมายผิด -->
            <td style="padding:4px;text-align:center;font-size:18px;font-weight:bold;">&#120;</td>
        <?php
        }
        ?>

        <!--SICKLEAVE -->
        <?php
        if ($result_seTenkoNG['SICKLEAVE'] == '1') {
        ?>  
            <!-- เครื่องหมายถูก -->
            <td style="padding:4px;text-align:center;font-size:14px;font-weight:bold;">&#10004;</td>
        <?php
        }else{
        ?>
            <!-- เครื่องหมายผิด -->
            <td style="padding:4px;text-align:center;font-size:18px;font-weight:bold;">&#120;</td>
        <?php
        }
        ?>
        <td><?= $result_seTenkoNG['CAUSE_DATA'] ?></td>
        <td><?= $result_seTenkoNG['ACTION_DATA'] ?></td>
        </tr>
        <?php
        $i++;

        
    }
    ?>
    </tbody>
    </table>
    </div>
    <div id="datasr"></div>
    </div>
  
  <?php
}
if ($_POST['txt_flg'] == "recheck_driver1") {
  
    // $sql = "UPDATE DRIVERSELFCHECK 
    // SET TEMPERATURE='".$_POST['temperature'] ."',SYSVALUE1='".$_POST['sysvalue'] ."',
    //     DIAVALUE1 ='".$_POST['diavalue'] ."',PULSEVALUE1='".$_POST['pulsevalue'] ."',
    //     OXYGENVALUE='".$_POST['oxygenvalue'] ."',ALCOHOLVOLUME='".$_POST['alcoholvalue'] ."'
    // WHERE SELFCHECKID ='".$_POST['selfcheckid'] ."'";
    // $query = sqlsrv_query($conn, $sql, $params);
    // $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
   
    $sql_Recheck_Dri1 = "{call megEditDriverSelfcheck(?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params_Recheck_Dri1 = array(
    array('recheck_driver1', SQLSRV_PARAM_IN),
    array($_POST['selfcheckid'], SQLSRV_PARAM_IN),
    array($_POST['temperature'], SQLSRV_PARAM_IN),
    array($_POST['sysvalue'], SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array($_POST['diavalue'], SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array($_POST['pulsevalue'], SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array($_POST['oxygenvalue'], SQLSRV_PARAM_IN),
    array($_POST['alcoholvalue'], SQLSRV_PARAM_IN)
    );
    $query_Recheck_Dri1 = sqlsrv_query($conn, $sql_Recheck_Dri1, $params_Recheck_Dri1);
    $result_Recheck_Dri1 = sqlsrv_fetch_array($query_Recheck_Dri1, SQLSRV_FETCH_ASSOC);
    

    // echo $result['TIMEREST'];
    
}
if ($_POST['txt_flg'] == "recheck_driver2") {
  
    // $sql = "UPDATE DRIVERSELFCHECK 
    // SET TEMPERATURE ='".$_POST['temperature'] ."',SYSVALUE1 ='".$_POST['sysvalue'] ."',
    //     DIAVALUE1 ='".$_POST['diavalue'] ."',PULSEVALUE1 ='".$_POST['pulsevalue'] ."',
    //     OXYGENVALUE ='".$_POST['oxygenvalue'] ."',ALCOHOLVOLUME ='".$_POST['alcoholvalue'] ."'
    // WHERE SELFCHECKID ='".$_POST['selfcheckid'] ."'";
    // $query = sqlsrv_query($conn, $sql, $params);
    // $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    
    // echo $result['TIMEREST'];
    
    $sql_Recheck_Dri2 = "{call megEditDriverSelfcheck(?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params_Recheck_Dri2 = array(
    array('recheck_driver2', SQLSRV_PARAM_IN),
    array($_POST['selfcheckid'], SQLSRV_PARAM_IN),
    array($_POST['temperature'], SQLSRV_PARAM_IN),
    array($_POST['sysvalue'], SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array($_POST['diavalue'], SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array($_POST['pulsevalue'], SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array($_POST['oxygenvalue'], SQLSRV_PARAM_IN),
    array($_POST['alcoholvalue'], SQLSRV_PARAM_IN)
    );
    $query_Recheck_Dri2 = sqlsrv_query($conn, $sql_Recheck_Dri2, $params_Recheck_Dri2);
    $result_Recheck_Dri2 = sqlsrv_fetch_array($query_Recheck_Dri2, SQLSRV_FETCH_ASSOC);

}
if ($_POST['txt_flg'] == "confirm_driverdetail") {
  
    $sql = "UPDATE TENKOBEFORE 
    SET CONFIRMDETAILBY ='".$_POST['confirmby'] ."',CONFIRMDETAILDATE = GETDATE()
    WHERE TENKOMASTERID = '".$_POST['tenkomasteridconfirm'] ."'
    AND TENKOMASTERDIRVERCODE = '".$_POST['employeecodeconfirm'] ."'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    
    // echo $result['TIMEREST'];
    
}
if ($_POST['txt_flg'] == "update_selfcheckdetail_fromtenko") {
  
    $sql = "UPDATE DRIVERSELFCHECK
    SET DATEWORKING='".$_POST['dateworking'] ."',DATEPRESENT='".$_POST['datepresent'] ."',
    TEMPERATURE='".$_POST['temperature'] ."',SYSVALUE1='".$_POST['sysvalue'] ."',
    DIAVALUE1 ='".$_POST['diavalue'] ."',PULSEVALUE1='".$_POST['pulsevalue'] ."',
    OXYGENVALUE='".$_POST['oxygenvalue'] ."',ALCOHOLVOLUME='".$_POST['alcoholvalue'] ."',
    CONFIRMEDBY='".$_POST['confirmby'] ."',CONFIRMEDDATE= GETDATE()
    WHERE SELFCHECKID = '".$_POST['selfcheckid'] ."'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    
    // echo $result['TIMEREST'];
    
}
if ($_POST['txt_flg'] == "select_timeline") {

  ?>

    <?php 
    $employee1 = " AND a.PersonCode = '" . $_POST['employeecode'] . "'";
    $sql_seEmp1 = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEmp1 = array(
        array('select_employeeehr2', SQLSRV_PARAM_IN),
        array($employee1, SQLSRV_PARAM_IN)
    );
    $query_seEmp1 = sqlsrv_query($conn, $sql_seEmp1, $params_seEmp1);
    $result_seEmp1 = sqlsrv_fetch_array($query_seEmp1, SQLSRV_FETCH_ASSOC);
    
    ///คำนวนหาอายุงาน
    // $datework = $result_seEmp['StartDate'];

    $day =  substr($result_seEmp1['StartDate'],0,2);
    $month =  substr($result_seEmp1['StartDate'],3,2);
    $year =  substr($result_seEmp1['StartDate'],6);

    $datework = $month."/".$day."/".$year;


    $sql_CalculateWork = "{call megCalculatorDate(?,?)}";
    $params_CalculateWork = array(
        array('calculate_work', SQLSRV_PARAM_IN),
        array($datework, SQLSRV_PARAM_IN)
    );
    $query_CalculateWork = sqlsrv_query($conn, $sql_CalculateWork, $params_CalculateWork);
    $result_CalculateWork = sqlsrv_fetch_array($query_CalculateWork, SQLSRV_FETCH_ASSOC);
    // echo $result_CalculateWork['RS'];

    ///คำนวนหาอายุตน
    $dayAge =  substr($result_seEmp1['BirthDate103'],0,2);
    $monthAge =  substr($result_seEmp1['BirthDate103'],3,2);
    $yearAge =  substr($result_seEmp1['BirthDate103'],6);

    $dateworkAge = $monthAge."/".$dayAge."/".$yearAge;


    $sql_CalculateAge = "{call megCalculatorDate(?,?)}";
    $params_CalculateAge = array(
        array('calculate_work', SQLSRV_PARAM_IN),
        array($dateworkAge, SQLSRV_PARAM_IN)
    );
    $query_CalculateAge = sqlsrv_query($conn, $sql_CalculateAge, $params_CalculateAge);
    $result_CalculateAge = sqlsrv_fetch_array($query_CalculateAge, SQLSRV_FETCH_ASSOC);
    // echo $result_CalculateAge['RS'];

    ?>

    <table style="width:100%;border:1px solid black;">
        <tr>
                <td colspan ="4" rowspan="4" style="border:1px solid black;text-align: center;font-size: 18px;width:60px;"><img width="100%"   src="../images/employee/<?= $_POST['employeecode'] ?>.JPG"></td>
          
            
        </tr>
        <tr>
            <td colspan ="3" style="border:1px solid black;text-align:left;font-size: 16px;"> &nbsp;<b>รหัสพนักงาน</b></td>
            <td colspan ="4" style="border:1px solid black;font-size: 14px;">&nbsp; <?=$_POST['employeecode']?></td>
            <td colspan ="3" style="border:1px solid black;text-align:left;font-size: 16px;">&nbsp;<b>ชื่อพนักงาน</b></td>
            <td colspan ="4" style="border:1px solid black;font-size: 14px;">&nbsp; <?=$result_seEmp1['nameT']?></td>
            
        </tr>
        <tr>
            <td colspan ="3" style="border:1px solid black;text-align:left;font-size: 16px;">&nbsp;<b>อายุงาน</b></td>
            <td colspan ="4" style="border:1px solid black;font-size: 14px;">&nbsp; <?=$result_CalculateWork['RS'] ?> </td>
            <td colspan ="3" style="border:1px solid black;text-align:left;font-size: 16px;">&nbsp;<b>อายุตน</b></td>
            <td colspan ="4" style="border:1px solid black;font-size: 14px;">&nbsp; <?=$result_CalculateAge['RS'] ?> </td>
            
        </tr>
        <tr>
            <td colspan ="3" style="border:1px solid black;text-align:left;font-size: 16px;">&nbsp;<b>บริษัท</b></td>
            <td colspan ="18" style="border:1px solid black;font-size: 14px;">&nbsp;  <?= $result_seEmp1['Company_NameT'] ?></td>
        </tr>
        <tr>
            <td colspan ="21" style="font-size: 14px;">&nbsp;<b></b></td>
        </tr>
    </table>
    <!-- ข้อมูล TenkoNG -->
    <th><b><u><h3>ข้อมูล TimeLine ประจำวันที่ <?=$_POST['date']?></h3></u></b></th>
    <div class="table-responsive">
    <table id="example" class="table table-striped table-hover responsive">
    </div>
  <!-- /////////ข้อมูลแถวแรก//////////// -->
  <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <div id="datadef">
    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;font-size:14px">
        <thead>
        <tr>
            <th style="text-align: center;">ว/ด/ป</th>
            <th style="height:30px; width:10px;text-align:center">เวลาเริ่ม</th>
            <th style="height:30px; width:10px;text-align:center">เวลาสิ้นสุด</th>
            <th style="height:30px; width:10px;text-align:center">สถานที่</th>
            <th style="height:30px; width:10px;text-align:center">รายละเอียด</th>
            <th style="height:30px; width:10px;text-align:center">ผู้ใกล้ชิด</th>
        </tr>

        </thead>
    <tbody>
    <?php
    $i = 1;

    $sql_seTimeLine = "SELECT TIMELINE_ID,DATE_START,CONVERT(VARCHAR(10),DATE_START,103) AS 'DATESTART',CONVERT(VARCHAR(5), DATE_START, 108) AS 'TIMESTART' ,
    DATE_END,CONVERT(VARCHAR(10),DATE_END,103) AS 'DATEEND',CONVERT(VARCHAR(5), DATE_END, 108) AS 'TIMEEND' ,
    [LOCATION],DETAIL,CLOSEPERSON,DATEISO8601START,DATEISO8601END
    FROM TIMELINEHISTORY
    WHERE  EMPLOYEECODE = '".$_POST['employeecode']."'
   AND CONVERT(DATE,'".$_POST['date']."',103) BETWEEN CONVERT(DATE,DATE_START,103) AND CONVERT(DATE,DATE_END,103)
    -- AND CONVERT(VARCHAR,DATE_START,103) ='".$_POST['date']."'
    ORDER BY DATE_START ASC";
    $params_seTimeLine = array();
    $query_seTimeLine = sqlsrv_query($conn, $sql_seTimeLine, $params_seTimeLine);
    while ($result_seTimeLine = sqlsrv_fetch_array($query_seTimeLine, SQLSRV_FETCH_ASSOC)) {
        
        $DATECHKSTART1 = str_replace("T"," ",$result_seTimeLine['DATEISO8601START']);
        $DATECHKSTART = str_replace("-","/",$DATECHKSTART1);

        $DATECHKEND1 = str_replace("T"," ",$result_seTimeLine['DATEISO8601END']);
        $DATECHKEND = str_replace("-","/",$DATECHKEND1);
        
        ?>
        <!-- <tr>
            <td><?= $result_eTimeLine['DATESTART'] ?></td>
            <td><?= $result_eTimeLine['TIMESTART'] ?><input class="form-control dateen" style="height:40px; width:240px" id="daysleep_restend" name="daysleep_restend" value="<?= $DATERESTEND ?>" min="" max=""  autocomplete="off"></td>
            <td><?= $result_eTimeLine['TIMEEND'] ?></td>
            <td><?= $result_eTimeLine['LOCATION'] ?></td>
            <td><?= $result_eTimeLine['DETAIL'] ?></td>
            <td><?= $result_eTimeLine['CLOSEPERSON'] ?></td>
        </tr> -->
        <tr>
            <td><?= $result_seTimeLine['DATESTART'] ?></td>
            <td style="height:40px; width:15px;text-align:center"><input class="form-control dateen"    style="height:30px; width:150px;text-align:center" id="date_startchk"       name="date_startchk"        value="<?= $DATECHKSTART ?>"                     onchange="update_datestart('<?=$result_seTimeLine['TIMELINE_ID']?>','DATESTART',this.value)"     min="" max=""  autocomplete="off"></td>
            <td style="height:40px; width:15px;text-align:center"><input class="form-control dateen"    style="height:30px; width:150px;text-align:center" id="date_endchk"         name="date_endchk"          value="<?= $DATECHKEND ?>"                       onchange="update_dateend('<?=$result_seTimeLine['TIMELINE_ID']?>','DATEEND',this.value)"         min="" max=""  autocomplete="off"></td>
            <td style="height:40px; width:15px;text-align:center"><input class="form-control"           style="height:30px; width:150px;text-align:left" id="date_locationchk"    name="date_locationchk"     value="<?= $result_seTimeLine['LOCATION'] ?>"    onchange="update_location('<?=$result_seTimeLine['TIMELINE_ID']?>','LOCATION',this.value)"       min="" max=""  autocomplete="off"></td>
            <td style="height:40px; width:15px;text-align:center"><input class="form-control"           style="height:30px; width:150px;text-align:left" id="date_detailchk"      name="date_detailchk"       value="<?= $result_seTimeLine['DETAIL'] ?>"      onchange="update_detail('<?=$result_seTimeLine['TIMELINE_ID']?>','DETAIL',this.value)"           min="" max=""  autocomplete="off"></td>
            <td style="height:40px; width:15px;text-align:center"><input class="form-control"           style="height:30px; width:150px;text-align:left" id="date_closepersonchk" name="date_closepersonchk"  value="<?= $result_seTimeLine['CLOSEPERSON'] ?>" onchange="update_closeperson('<?=$result_seTimeLine['TIMELINE_ID']?>','CLOSEPERSON',this.value)" min="" max=""  autocomplete="off"></td>
           
        </tr>
        <?php
        $i++;

        
    }
    ?>
    </tbody>
    </table>
    </div>
    <div id="datasr"></div>
    </div>
  
  <?php
}
if ($_POST['txt_flg'] == "checking_dataplan") {
//    echo $_POST['jobno'];
  ?>
    <!-- ข้อมูล TenkoNG -->
    <th><b><u><h3>ข้อมูลการวิ่งงาน 7 วันย้อนหลัง ทะเบียนรถ: <?=$_POST['regisnumber']?> &nbsp;/&nbsp;ชื่อรถ: <?=$_POST['thainame']?> </h3></u></b></th>
    <div class="table-responsive">
    <table id="example" class="table table-striped table-hover responsive">
    </div>
  <!-- /////////ข้อมูลแถวแรก//////////// -->
  <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <div id="dataplandef">
    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example3" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;font-size:14px">
        <thead>
        <tr>
            <th style="text-align: center;">ลำดับ</th>
            <th style="text-align: center;">วันที่</th>
            <th style="text-align: center;">พขร.1</th>
            <th style="text-align: center;">พขร.2</th>
            <th style="text-align: center;">ต้นทาง</th>
            <th style="text-align: center;">คลัสเตอร์</th>
            <th style="text-align: center;">ปลายทาง</th>
            <th style="text-align: center;">ไมล์ต้น</th>
            <th style="text-align: center;">ไมล์ปลาย</th>
            <th style="text-align: center;">ระยะทาง</th>
            </th>
        </tr>

        </thead>
    <tbody>
    <?php
    $i = 1;
    $sql_lastmileage= "SELECT  TOP 1 a.JOBNO,b.MILEAGENUMBER
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN MILEAGE b ON b.JOBNO = a.JOBNO
        WHERE (THAINAME ='".$_POST['regisnumber']."' OR THAINAME ='".$_POST['thainame']."') AND
        CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,DATEADD(DAY,-7,GETDATE())) AND CONVERT(DATE,GETDATE())
        AND MILEAGETYPE ='MILEAGEEND'
        ORDER BY b.CREATEDATE DESC";
    $query_lastmileage  = sqlsrv_query($conn, $sql_lastmileage, $params_lastmileage);
    $result_lastmileage = sqlsrv_fetch_array($query_lastmileage, SQLSRV_FETCH_ASSOC);

    $sql_seDataPlan = "SELECT JOBNO,CONVERT(VARCHAR(10),DATEWORKING,103) AS 'DATE',JOBSTART,CLUSTER,JOBEND,EMPLOYEENAME1,EMPLOYEENAME2 
    FROM VEHICLETRANSPORTPLAN 
    WHERE (THAINAME ='".$_POST['regisnumber']."' OR THAINAME ='".$_POST['thainame']."') 
    AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,DATEADD(DAY,-7,GETDATE())) AND CONVERT(DATE,GETDATE())
    ORDER BY DATEWORKING DESC";
    $params_seDataPlan = array();
    $query_seDataPlan = sqlsrv_query($conn, $sql_seDataPlan, $params_seDataPlan);
    while ($result_seDataPlan = sqlsrv_fetch_array($query_seDataPlan, SQLSRV_FETCH_ASSOC)) {


        $sql_mileagestart = "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGESTART',JOBNO 
            FROM MILEAGE WHERE JOBNO ='".$result_seDataPlan['JOBNO']."'
            AND MILEAGETYPE ='MILEAGESTART'
            ORDER BY CREATEDATE DESC";
        $query_mileagestart  = sqlsrv_query($conn, $sql_mileagestart, $params_mileagestart);
        $result_mileagestart = sqlsrv_fetch_array($query_mileagestart, SQLSRV_FETCH_ASSOC);    
        //ไมล์ปลาย
        $sql_mileageend = "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGEEND',JOBNO 
            FROM MILEAGE WHERE JOBNO ='".$result_seDataPlan['JOBNO']."'
            AND MILEAGETYPE ='MILEAGEEND'
            ORDER BY CREATEDATE DESC";
        $query_mileageend  = sqlsrv_query($conn, $sql_mileageend, $params_mileageend);
        $result_mileageend = sqlsrv_fetch_array($query_mileageend, SQLSRV_FETCH_ASSOC);

        

        ?>
        <tr>
        <td style="text-align: center"><?= $i ?></td>
        <td><?= $result_seDataPlan['DATE'] ?></td>
        <td><?= $result_seDataPlan['EMPLOYEENAME1'] ?></td>
        <td><?= $result_seDataPlan['EMPLOYEENAME2'] ?></td>
        <td><?= $result_seDataPlan['JOBSTART'] ?></td>
        <td><?= $result_seDataPlan['CLUSTER'] ?></td>
        <td><?= $result_seDataPlan['JOBEND'] ?></td>
        <td><?= $result_mileagestart['MILEAGESTART'] ?></td>
        <td><?= $result_mileageend['MILEAGEEND'] ?></td>
        <td><?= $result_mileageend['MILEAGEEND']-$result_mileagestart['MILEAGESTART'] ?></td>
        </tr>
        <?php
        $i++;
        
        $kilo = $kilo + ($result_mileageend['MILEAGEEND']-$result_mileagestart['MILEAGESTART']);
        $avgkilo = $kilo /($i-1);
    }
    ?>
    </tbody>
    <tfoot>
        <tr style="text-align: center;background-color: #c9c9c9;">
            <td colspan="6" ></td>
            <td><b>เลขไมล์ล่าสุด</b></td>
            <td><b><u><?=$result_lastmileage['MILEAGENUMBER']?><u></b></td>
            <td><b>ระยะทางเฉลี่ย</b></td>
            <td><b><u><?=number_format($avgkilo,2) ?><u></b></td>
        </tr>
    </tfoot>
    </table>  
        
    </div>
    <div id="dataplansr"></div>
    </div>
  
  <?php
}
if ($_POST['txt_flg'] == "checking_zoneskb") {
//    echo $_POST['jobno'];
  ?>
  <?php

    $sql_seChkZone = "SELECT ZONESKB_ID,PROVINCE,[ZONE] FROM ZONEFORSKB 
        WHERE  ZONESKB_ID ='".$_POST['zoneid']."'
        ORDER BY PROVINCE ASC";
    $params_seChkZone = array();
    $query_seChkZone = sqlsrv_query($conn, $sql_seChkZone, $params_seChkZone);
    $result_seChkZone = sqlsrv_fetch_array($query_seChkZone, SQLSRV_FETCH_ASSOC);

  ?>
  
    <br>
    <div id="dataplandef">
        <div class="row" style="text-align: left;">
            <div class="form-group">
                <div class="col-lg-4" >
                    <label>จังหวัด</label>
                    <input type="text"  class="form-control"  style="width: 200px; height: 40px;text-align: center;"  id="txt_province" name="txt_province" onchange="edit_provinceskb(this.value,'<?=$result_seChkZone['ZONESKB_ID']?>','<?=$_SESSION['USERNAME']?>');" value="<?=$result_seChkZone['PROVINCE']?>" placeholder="">
                </div>
                
                <div class="col-lg-4">
                    <label>ภาค</label>
                    <input type="text"  class="form-control"  style="width: 200px; height: 40px;text-align: center;"  id="txt_zone" name="txt_zone" onchange="edit_zoneskb(this.value,'<?=$result_seChkZone['ZONESKB_ID']?>','<?=$_SESSION['USERNAME']?>');" value="<?=$result_seChkZone['ZONE']?>" placeholder="">
                </div>

                <div class="col-lg-4">
                    <label>ปุ่มบันทึกข้อมูล</label>
                    <input type="button"  class="btn btn-primary"  style="width: 200px; height: 40px;text-align: center;"  onclick="reload();" value="บันทึกข้อมูล" id="txt_action" name="txt_action"  placeholder="">
                </div>
            </div>
        </div>
        <br>
        <div class="row" >
            <div class="col-lg-6">
                <label for="" style="color:red;">* ตรวจสอบข้อมูลให้ถูกต้องทุกครั้งก่อนกดบันทึก</label>
            </div>
        </div>  
    </div>
    <div id="dataplansr"></div>

  
  <?php
}
if ($_POST['txt_flg'] == "checking_datarepair") {
//    echo $_POST['jobno'];
  ?>
    <!-- ข้อมูล TenkoNG -->
    <th><b><u><h3>ข้อมูลการซ่อมรถล่าสุดย้อนหลัง ทะเบียนรถ: <?=$_POST['regisnumber']?> &nbsp;/&nbsp;ชื่อรถ: <?=$_POST['thainame']?> </h3></u></b></th>
    <div class="table-responsive">
    <table id="example" class="table table-striped table-hover responsive">
    </div>
  <!-- /////////ข้อมูลแถวแรก//////////// -->
  <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <div id="datarepairdef">
    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example4" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;font-size:14px">
        <thead>
        <tr>
            <th style="text-align: center;">ลำดับ</th>
            <th style="text-align: center;">วันที่และเวลา</th>
            <th style="text-align: center;">ช่างซ่อมบำรุง</th>
            <th style="text-align: center;">ประเภทงาน</th>
            <th style="text-align: center;">รายละเอียด</th>
            </th>
        </tr>

        </thead>
    <tbody>
    <?php
    $i1 = 1;
    $i2 = 1;
    $sql_seRepairplanID = "SELECT TOP 1 REPAIRPLANID,VEHICLEREGISNUMBER1,CARINPUTDATE,RANKPMAC,RANKPMNEXT,RANKPM 
        FROM  [RK01\MSSQLMAINTENANCE,1435].RTMS.[dbo].[REPAIRPLAN]
        WHERE VEHICLEREGISNUMBER1 ='".$_POST['regisnumber']."'
        ORDER BY CARINPUTDATE DESC";
    $params_seRepairplanID = array();
    $query_seRepairplanID = sqlsrv_query($conn, $sql_seRepairplanID, $params_seRepairplanID);
    while ($result_seRepairplanID = sqlsrv_fetch_array($query_seRepairplanID, SQLSRV_FETCH_ASSOC)) {
        
        $sql_seData = "SELECT  DISTINCT CONVERT(VARCHAR(10),CARINPUTDATE,103) AS 'DATE',
            CONVERT(VARCHAR(5),CARINPUTDATE,108) AS 'TIME',a.REPAIRPLANID,b.EMPLOYEENAME,b.REPAIRTYPE,b.REPAIRDETAIL
            FROM  [RK01\MSSQLMAINTENANCE,1435].RTMS.[dbo].[REPAIRCAUSE] a
            INNER JOIN [RK01\MSSQLMAINTENANCE,1435].RTMS.[dbo].[REPAIREMPLOYEE] b ON b.REPAIRPLANID = a.REPAIRPLANID
            WHERE a.REPAIRPLANID ='".$result_seRepairplanID['REPAIRPLANID']."'";
        $query_seData  = sqlsrv_query($conn, $sql_seData, $params_seData);
        while ( $result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC)) { 
        
        
        ?>
        <tr>
        <td style="text-align: center"><?= $i1 ?></td>
        <td><?= $result_seData['DATE'] ?> : <?= $result_seData['TIME'] ?> </td>
        <td><?= $result_seData['EMPLOYEENAME'] ?></td>
        <td><?= $result_seData['REPAIRTYPE'] ?></td>
        <td><?= $result_seData['REPAIRDETAIL'] ?></td>
        </tr>
        <?php
        $i1++;
        }    
        $i2++;

        $RANKPMAC = $result_seRepairplanID['RANKPMAC'];
        $RANKPMNEXT =$result_seRepairplanID['RANKPMNEXT'];
    }
    ?>
    </tbody>
    <tfoot>
        <tr style="text-align: center;background-color: #c9c9c9;">
            <td><b>PM ครั้งล่าสุด</b></td>
            <td><b><u><?=$RANKPMAC?><u></b></td>
            <td><b>PM ครั้งต่อไป</b></td>
            <td><b><u><?=$RANKPMNEXT?><u></b></td>
            <td></td>
        </tr>
    </tfoot>
    </table>
    </div>
    <div id="datarepairsr"></div>
    </div>
  
  <?php
}
if ($_POST['txt_flg'] == "select_zoneforskb") {
  ?>




  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
    <thead>
        <tr>
            <th>ลำดับ</th>
            <th>จังหวัด</th>
            <th>ภาค</th>
            <th>แก้ไข</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $i = 1;
            $sql_seZoneData = "SELECT ZONESKB_ID,PROVINCE,[ZONE] FROM ZONEFORSKB 
            WHERE [ZONE] ='".$_POST['zone']."'
            ORDER BY PROVINCE ASC";
            $params_seZoneData = array();
            $query_seZoneData = sqlsrv_query($conn, $sql_seZoneData, $params_seZoneData);
            while ($result_seZoneData = sqlsrv_fetch_array($query_seZoneData, SQLSRV_FETCH_ASSOC)) {
                ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $result_seZoneData['PROVINCE']?></td>
                    <td><?= $result_seZoneData['ZONE']?></td>
                    <td> <button type="button" class="btn btn-primary" name="myBtn" id ="myBtn" data-toggle="modal" data-target="#myModalshowzoneskb"   onclick="checking_zoneskb('<?=$result_seZoneData['ZONESKB_ID']?>');">แก้ไขข้อมูล</button></td>
                </tr>
                <?php
                $i++;
            }
        ?>
    </tbody>

  </table>

  <?php
}
 if ($_POST['txt_flg'] == "edit_vehicletransportdocumenteditjobdo") {
   ?>

   <?php
   $sql_addAdv = "{call megEditvehicletransportdocumentdriver_v2(?,?,?,?,?,?,?,?,?)}";
   $params_addAdv = array(
   array('edit_vehicletransportdocumenteditjobdo', SQLSRV_PARAM_IN),
   array($_POST['ID'], SQLSRV_PARAM_IN),
   array($_POST['fieldname'], SQLSRV_PARAM_IN),
   array($_POST['editableObj'], SQLSRV_PARAM_IN),
   array($_POST['doid'], SQLSRV_PARAM_IN),
   array('', SQLSRV_PARAM_IN),
   array('', SQLSRV_PARAM_IN),
   array('', SQLSRV_PARAM_IN),
   array('', SQLSRV_PARAM_IN)
   );

   $query_addAdv = sqlsrv_query($conn, $sql_addAdv, $params_addAdv);
   $result_addAdv = sqlsrv_fetch_array($query_addAdv, SQLSRV_FETCH_ASSOC);
   ?>



   <?php
 }
 if ($_POST['txt_flg'] == "update_accident") {
   ?>

   <?php

   $sql_addAcci = "{call megEditAccident(?,?,?,?,?)}";
   $params_addAcci = array(
   array('update_accident', SQLSRV_PARAM_IN),
   array($_POST['value'], SQLSRV_PARAM_IN),
   array($_POST['fieldname'], SQLSRV_PARAM_IN),
   array($_POST['acciid'], SQLSRV_PARAM_IN),
   array($_POST['modifyby'], SQLSRV_PARAM_IN)
   );

   $query_addAcci  = sqlsrv_query($conn, $sql_addAcci, $params_addAcci);
   $result_addAcci = sqlsrv_fetch_array($query_addAcci, SQLSRV_FETCH_ASSOC);
   ?>



   <?php
 }
 if ($_POST['txt_flg'] == "save_accident") {
   ?>

   <?php

   $sql_saveaccidenthistory = "{call megAccidentHistory(?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
   $params_saveaccidenthistory = array(
   array('save_accidenthistory', SQLSRV_PARAM_IN),
   array($_POST['id'], SQLSRV_PARAM_IN),
   array($_POST['drivername'], SQLSRV_PARAM_IN),
   array($_POST['years'], SQLSRV_PARAM_IN),
   array($_POST['datetimeacci'], SQLSRV_PARAM_IN),
   array($_POST['locationacci'], SQLSRV_PARAM_IN),
   array($_POST['problemacci'], SQLSRV_PARAM_IN),
   array($_POST['detailman'], SQLSRV_PARAM_IN),
   array($_POST['detailmethod'], SQLSRV_PARAM_IN),
   array($_POST['detailmechine'], SQLSRV_PARAM_IN),
   array($_POST['detailenvironment'], SQLSRV_PARAM_IN),
   array($_POST['remark'], SQLSRV_PARAM_IN),
   array($_POST['type'], SQLSRV_PARAM_IN),
   array($_POST['createby'], SQLSRV_PARAM_IN)
   );

   $query_saveaccidenthistory = sqlsrv_query($conn, $sql_saveaccidenthistory, $params_saveaccidenthistory);
   $result_saveaccidenthistory = sqlsrv_fetch_array($query_saveaccidenthistory, SQLSRV_FETCH_ASSOC);
   ?>



   <?php
}
if ($_POST['txt_flg'] == "delete_accident") {
  ?>

  <?php

  $sql_saveaccidenthistory = "{call megAccidentHistory(?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
  $params_saveaccidenthistory = array(
  array('delete_accidenthistory', SQLSRV_PARAM_IN),
  array($_POST['id'], SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN)
  );

  $query_saveaccidenthistory = sqlsrv_query($conn, $sql_saveaccidenthistory, $params_saveaccidenthistory);
  $result_saveaccidenthistory = sqlsrv_fetch_array($query_saveaccidenthistory, SQLSRV_FETCH_ASSOC);
  ?>



  <?php
}
if ($_POST['txt_flg'] == "update_simulator") {
  ?>

  <?php

  $sql_addSimu = "{call megEditSimulator(?,?,?,?,?)}";
  $params_addSimu = array(
  array('update_simulator', SQLSRV_PARAM_IN),
  array($_POST['value'], SQLSRV_PARAM_IN),
  array($_POST['fieldname'], SQLSRV_PARAM_IN),
  array($_POST['simuid'], SQLSRV_PARAM_IN),
  array($_POST['modifyby'], SQLSRV_PARAM_IN)
  );

  $query_addSimu  = sqlsrv_query($conn, $sql_addSimu, $params_addSimu);
  $result_addSimu = sqlsrv_fetch_array($query_addSimu, SQLSRV_FETCH_ASSOC);
  ?>



  <?php
}
if ($_POST['txt_flg'] == "save_simulator") {
  ?>

  <?php

  $sql_savesimulatorhistory = "{call megSimulatorHistory(?,?,?,?,?,?,?,?,?,?,?)}";
  $params_savesimulatorhistory = array(
  array('save_simuatorhistory', SQLSRV_PARAM_IN),
  array($_POST['id'], SQLSRV_PARAM_IN),
  array($_POST['drivercode'], SQLSRV_PARAM_IN),
  array($_POST['yearssimu'], SQLSRV_PARAM_IN),
  array($_POST['tlepfirstpass'], SQLSRV_PARAM_IN),
  array($_POST['tleppass'], SQLSRV_PARAM_IN),
  array($_POST['simudata1'], SQLSRV_PARAM_IN),
  array($_POST['simudata2'], SQLSRV_PARAM_IN),
  array($_POST['simudata3'], SQLSRV_PARAM_IN),
  array($_POST['tlepwearglasses'], SQLSRV_PARAM_IN),
  array($_POST['createby'], SQLSRV_PARAM_IN)
  );

  $query_savesimulatorhistory = sqlsrv_query($conn, $sql_savesimulatorhistory, $params_savesimulatorhistory);
  $result_savesimulatorhistory = sqlsrv_fetch_array($query_savesimulatorhistory, SQLSRV_FETCH_ASSOC);
  ?>



  <?php
}
if ($_POST['txt_flg'] == "delete_simulator") {
  ?>

  <?php

  $sql_savesimulatorhistory = "{call megSimulatorHistory(?,?,?,?,?,?,?,?)}";
  $params_savesimulatorhistory = array(
  array('delete_simulator', SQLSRV_PARAM_IN),
  array($_POST['id'], SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN)
  );

  $query_savesimulatorhistory = sqlsrv_query($conn, $sql_savesimulatorhistory, $params_savesimulatorhistory);
  $result_savesimulatorhistory = sqlsrv_fetch_array($query_savesimulatorhistory, SQLSRV_FETCH_ASSOC);
  ?>



  <?php
}
if ($_POST['txt_flg'] == "save_driverranking") {
  ?>

  <?php

  $sql_savedriverranking = "{call megDriverRanking(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
  $params_savedriverranking = array(
  array('save_driverranking', SQLSRV_PARAM_IN),
  array($_POST['id'], SQLSRV_PARAM_IN),
  array($_POST['drivername'], SQLSRV_PARAM_IN),
  array($_POST['monththai'], SQLSRV_PARAM_IN),
  array($_POST['montheng'], SQLSRV_PARAM_IN),
  array($_POST['years'], SQLSRV_PARAM_IN),
  array($_POST['yearscheck'], SQLSRV_PARAM_IN),
  array($_POST['area'], SQLSRV_PARAM_IN),
  array($_POST['accidenttruckchk'], SQLSRV_PARAM_IN),
  array($_POST['accidentproductchk'], SQLSRV_PARAM_IN),
  array($_POST['workcheckingchk'], SQLSRV_PARAM_IN),
  array($_POST['drivingbehaviorchk'], SQLSRV_PARAM_IN),
  array($_POST['operationdriverchk'], SQLSRV_PARAM_IN),
  array($_POST['complainfromcuschk'], SQLSRV_PARAM_IN),
  array($_POST['truckreadychk'], SQLSRV_PARAM_IN),
  array($_POST['companyregulationchk'], SQLSRV_PARAM_IN),
  array($_POST['attendancechk'], SQLSRV_PARAM_IN),
  array($_POST['comingtoworkchk'], SQLSRV_PARAM_IN),
  array($_POST['allpoint'], SQLSRV_PARAM_IN),
  array($_POST['rank'], SQLSRV_PARAM_IN),
  array($_POST['createby'], SQLSRV_PARAM_IN),
  array($_POST['createdate'], SQLSRV_PARAM_IN),
  array($_POST['modifyby'], SQLSRV_PARAM_IN),
  array($_POST['modifydate'], SQLSRV_PARAM_IN)
  );

  $query_savedriverranking = sqlsrv_query($conn, $sql_savedriverranking, $params_savedriverranking);
  $result_savedriverranking = sqlsrv_fetch_array($query_savedriverranking, SQLSRV_FETCH_ASSOC);
  ?>



  <?php
}
if ($_POST['txt_flg'] == "delete_oilprice") {
  ?>

  <?php

  $sql_deleteoilprice = "{call megOilprice_v2(?,?,?,?,?,?,?,?,?,?)}";
  $params_deleteoilprice = array(
  array('delete_oilprice', SQLSRV_PARAM_IN),
  array($_POST['oilpriceid'], SQLSRV_PARAM_IN),
  array($_POST['condition2'], SQLSRV_PARAM_IN),
  array($_POST['condition3'], SQLSRV_PARAM_IN),
  array($_POST['company'], SQLSRV_PARAM_IN),
  array($_POST['year'], SQLSRV_PARAM_IN),
  array($_POST['month'], SQLSRV_PARAM_IN),
  array($_POST['price'], SQLSRV_PARAM_IN),
  array($_POST['remark'], SQLSRV_PARAM_IN),
  array($_POST['createby'], SQLSRV_PARAM_IN)
  );

  $query_deleteoilprice = sqlsrv_query($conn, $sql_deleteoilprice, $params_deleteoilprice);
  $result_deleteoilprice = sqlsrv_fetch_array($query_deleteoilprice, SQLSRV_FETCH_ASSOC);
  ?>



  <?php
}
if ($_POST['txt_flg'] == "save_safetyfocustheme") {
  ?>

  <?php

  $sql_safetyfocustheme = "{call megSafetyfocustheme(?,?,?,?,?,?,?,?,?)}";
  $params_safetyfocustheme = array(
  array('save_safetyfocustheme', SQLSRV_PARAM_IN),
  array($_POST['id'], SQLSRV_PARAM_IN),
  array($_POST['monththai'], SQLSRV_PARAM_IN),
  array($_POST['montheng'], SQLSRV_PARAM_IN),
  array($_POST['yearssafety'], SQLSRV_PARAM_IN),
  array($_POST['yearscheck'], SQLSRV_PARAM_IN),
  array($_POST['safetydata'], SQLSRV_PARAM_IN),
  array($_POST['area'], SQLSRV_PARAM_IN),
  array($_POST['createby'], SQLSRV_PARAM_IN)
  );

  $query_safetyfocustheme  = sqlsrv_query($conn, $sql_safetyfocustheme, $params_safetyfocustheme);
  $result_safetyfocustheme = sqlsrv_fetch_array($query_safetyfocustheme, SQLSRV_FETCH_ASSOC);
  ?>



  <?php
}
if ($_POST['txt_flg'] == "update_safetyfocustheme") {
  ?>

  <?php

  $sql_editsafety = "{call megEditSafetyFocusTheme(?,?,?,?,?)}";
  $params_editsafety = array(
  array('update_safety', SQLSRV_PARAM_IN),
  array($_POST['value'], SQLSRV_PARAM_IN),
  array($_POST['fieldname'], SQLSRV_PARAM_IN),
  array($_POST['safetyid'], SQLSRV_PARAM_IN),
  array($_POST['modifyby'], SQLSRV_PARAM_IN)
  );

  $query_editsafety   = sqlsrv_query($conn, $sql_editsafety, $params_editsafety);
  $result_editsafety  = sqlsrv_fetch_array($query_editsafety, SQLSRV_FETCH_ASSOC);
  ?>



  <?php
}
if ($_POST['txt_flg'] == "delete_safetyfocustheme") {
  ?>

  <?php

  $sql_deletesafetyfocustheme = "{call megSafetyfocustheme(?,?,?,?,?,?,?,?)}";
  $params_deletesafetyfocustheme = array(
    array('delete_simulator', SQLSRV_PARAM_IN),
    array($_POST['id'], SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
  );

  $query_deletesafetyfocustheme = sqlsrv_query($conn, $sql_deletesafetyfocustheme, $params_deletesafetyfocustheme);
  $result_deletesafetyfocustheme = sqlsrv_fetch_array($query_deletesafetyfocustheme, SQLSRV_FETCH_ASSOC);
  ?>



  <?php
}
if ($_POST['txt_flg'] == "save_truckcameracheck") {
  ?>

  <?php

  $sql_savetruckcamcheck = "{call megTruckCameraCheck(?,?,?,?,?,?,?)}";
  $params_savetruckcamcheck  = array(
  array('save_truckcameracheck', SQLSRV_PARAM_IN),
  array($_POST['id'], SQLSRV_PARAM_IN),
  array($_POST['drivercode'], SQLSRV_PARAM_IN),
  array($_POST['yearstruckcamcheck'], SQLSRV_PARAM_IN),
  array($_POST['datetruckcamcheck'], SQLSRV_PARAM_IN),
  array($_POST['datatruckcamcheck'], SQLSRV_PARAM_IN),
  array($_POST['createby'], SQLSRV_PARAM_IN)
  );

  $query_savetruckcamcheck  = sqlsrv_query($conn, $sql_savetruckcamcheck, $params_savetruckcamcheck);
  $result_savetruckcamcheck  = sqlsrv_fetch_array($query_savetruckcamcheck, SQLSRV_FETCH_ASSOC);
  ?>



  <?php
}
if ($_POST['txt_flg'] == "update_truckcamcheck") {
  ?>

  <?php

  $sql_addSimu = "{call megEditTruckCamCheck(?,?,?,?,?)}";
  $params_addSimu = array(
  array('update_truckcamcheck', SQLSRV_PARAM_IN),
  array($_POST['value'], SQLSRV_PARAM_IN),
  array($_POST['fieldname'], SQLSRV_PARAM_IN),
  array($_POST['truckcamcheckid'], SQLSRV_PARAM_IN),
  array($_POST['modifyby'], SQLSRV_PARAM_IN)
  );

  $query_addSimu  = sqlsrv_query($conn, $sql_addSimu, $params_addSimu);
  $result_addSimu = sqlsrv_fetch_array($query_addSimu, SQLSRV_FETCH_ASSOC);
  ?>



  <?php
}
if ($_POST['txt_flg'] == "delete_truckcamcheck") {
  ?>

  <?php

  $sql_deletetruckcamcheck = "{call megEditTruckCamCheck(?,?,?,?,?)}";
  $params_deletetruckcamcheck = array(
  array('delete_truckcamcheck', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array($_POST['id'], SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN)
  );

  $query_deletetruckcamcheck = sqlsrv_query($conn, $sql_deletetruckcamcheck, $params_deletetruckcamcheck);
  $result_deletetruckcamcheck = sqlsrv_fetch_array($query_deletetruckcamcheck, SQLSRV_FETCH_ASSOC);
  ?>



  <?php
}
if ($_POST['txt_flg'] == "delete_vehicleinfo_statusnotuse") {
  ?>

  <?php

  $sql_deletevehicle_notuse = "{call megVehicleinfo_statusnotuse_v2(?,?)}";
  $params_deletevehicle_notuse = array(
  array('delete_vehicleinfo', SQLSRV_PARAM_IN),
  array($_POST['vehicleinfoid'], SQLSRV_PARAM_IN)
  );

  $query_deletevehicle_notuse = sqlsrv_query($conn, $sql_deletevehicle_notuse, $params_deletevehicle_notuse);
  $result_deletevehicle_notuse = sqlsrv_fetch_array($query_deletevehicle_notuse, SQLSRV_FETCH_ASSOC);
  ?>



  <?php
}
if ($_POST['txt_flg'] == "update_vehicleinfo_statusnotuse") {
    ?>
  
    <?php
  
    $sql_updatevehicle_notuse = "{call megVehicleinfo_statusnotuse_v2(?,?)}";
    $params_updatevehicle_notuse = array(
    array('update_vehicleinfo_status', SQLSRV_PARAM_IN),
    array($_POST['vehicleinfoid'], SQLSRV_PARAM_IN)
    );
  
    $query_updatevehicle_notuse = sqlsrv_query($conn, $sql_updatevehicle_notuse, $params_updatevehicle_notuse);
    $result_updatevehicle_notuse = sqlsrv_fetch_array($query_updatevehicle_notuse, SQLSRV_FETCH_ASSOC);
    ?>
  
  
  
    <?php
  }
  if ($_POST['txt_flg'] == "update_selfcheckstatus") {
      ?>
    
      <?php
    
    $sql_updatedata = "UPDATE DRIVERSELFCHECK
        SET ACTIVESTATUS = '" . $_POST['activestatus'] . "' 
        WHERE SELFCHECKID ='" . $_POST['selfcheckid'] . "'";
    $query_updatedata  = sqlsrv_query($conn, $sql_updatedata, $params_updatedata);
    $result_updatedata = sqlsrv_fetch_array($query_updatedata, SQLSRV_FETCH_ASSOC); 
      ?>
    
    
    
      <?php
    } 
if ($_POST['txt_flg'] == "save_workingissue") {
  ?>

  <?php

  $sql_saveworkingissue = "{call megWorkingIssue(?,?,?,?,?,?,?)}";
  $params_saveworkingissue  = array(
  array('save_workingissue', SQLSRV_PARAM_IN),
  array($_POST['id'], SQLSRV_PARAM_IN),
  array($_POST['drivercode'], SQLSRV_PARAM_IN),
  array($_POST['yearsworkingissue'], SQLSRV_PARAM_IN),
  array($_POST['dateworkingissue'], SQLSRV_PARAM_IN),
  array($_POST['dataworkingissue'], SQLSRV_PARAM_IN),
  array($_POST['createby'], SQLSRV_PARAM_IN)
  );

  $query_saveworkingissue  = sqlsrv_query($conn, $sql_saveworkingissue, $params_saveworkingissue);
  $result_saveworkingissue  = sqlsrv_fetch_array($query_saveworkingissue, SQLSRV_FETCH_ASSOC);
  ?>



  <?php
}
if ($_POST['txt_flg'] == "update_workingissue") {
  ?>

  <?php

  $sql_updateworkingissue = "{call megEditWorkingIssue(?,?,?,?,?)}";
  $params_updateworkingissue = array(
  array('update_workingissue', SQLSRV_PARAM_IN),
  array($_POST['value'], SQLSRV_PARAM_IN),
  array($_POST['fieldname'], SQLSRV_PARAM_IN),
  array($_POST['workingissueid'], SQLSRV_PARAM_IN),
  array($_POST['modifyby'], SQLSRV_PARAM_IN)
  );

  $query_updateworkingissue  = sqlsrv_query($conn, $sql_updateworkingissue, $params_updateworkingissue);
  $result_updateworkingissue = sqlsrv_fetch_array($query_updateworkingissue, SQLSRV_FETCH_ASSOC);
  ?>



  <?php
}
if ($_POST['txt_flg'] == "delete_workingissue") {
  ?>

  <?php

  $sql_deleteworkingissue = "{call megEditWorkingIssue(?,?,?,?,?)}";
  $params_deleteworkingissue = array(
  array('delete_workingissue', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array($_POST['id'], SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN)
  );

  $query_deleteworkingissue = sqlsrv_query($conn, $sql_deleteworkingissue, $params_deleteworkingissue);
  $result_deleteworkingissue = sqlsrv_fetch_array($query_deleteworkingissue, SQLSRV_FETCH_ASSOC);
  ?>



  <?php
}
if ($_POST['txt_flg'] == "save_timeline") {
  ?>

  <?php

  $sql_savetimelinehistory = "{call megTimeLineHistory(?,?,?,?,?,?,?,?,?,?,?,?,?)}";
  $params_savetimelinehistory = array(
  array('save_timeline', SQLSRV_PARAM_IN),
  array($_POST['id'], SQLSRV_PARAM_IN),
  array($_POST['employeecode'], SQLSRV_PARAM_IN),
  array($_POST['drivername'], SQLSRV_PARAM_IN),
  array($_POST['datestart'], SQLSRV_PARAM_IN),
  array($_POST['dateend'], SQLSRV_PARAM_IN),
  array($_POST['dateiso8601start'], SQLSRV_PARAM_IN),
  array($_POST['dateiso8601end'], SQLSRV_PARAM_IN),
  array($_POST['location'], SQLSRV_PARAM_IN),
  array($_POST['detail'], SQLSRV_PARAM_IN),
  array($_POST['closeperson'], SQLSRV_PARAM_IN),
  array($_POST['createby'], SQLSRV_PARAM_IN),
  array($_POST['createdate'], SQLSRV_PARAM_IN)
  );

  $query_savetimelinehistory = sqlsrv_query($conn, $sql_savetimelinehistory, $params_savetimelinehistory);
  $result_savetimelinehistory = sqlsrv_fetch_array($query_savetimelinehistory, SQLSRV_FETCH_ASSOC);
  ?>
  <?php
}
if ($_POST['txt_flg'] == "update_timeline") {
  ?>

  <?php

  $sql_updatetimelinehistory = "{call megTimeLineHistory(?,?,?,?,?,?,?,?,?,?,?,?,?)}";
  $params_updatetimelinehistory = array(
  array('update_timeline', SQLSRV_PARAM_IN),
  array($_POST['id'], SQLSRV_PARAM_IN),
  array($_POST['employeecode'], SQLSRV_PARAM_IN),
  array($_POST['employeename'], SQLSRV_PARAM_IN),
  array($_POST['datestart'], SQLSRV_PARAM_IN),
  array($_POST['dateend'], SQLSRV_PARAM_IN),
  array($_POST['dateiso8601start'], SQLSRV_PARAM_IN),
  array($_POST['dateiso8601end'], SQLSRV_PARAM_IN),
  array($_POST['location'], SQLSRV_PARAM_IN),
  array($_POST['detail'], SQLSRV_PARAM_IN),
  array($_POST['closeperson'], SQLSRV_PARAM_IN),
  array($_POST['createby'], SQLSRV_PARAM_IN),
  array($_POST['createdate'], SQLSRV_PARAM_IN)
  );

  $query_updatetimelinehistory = sqlsrv_query($conn, $sql_updatetimelinehistory, $params_updatetimelinehistory);
  $result_updatetimelinehistory = sqlsrv_fetch_array($query_updatetimelinehistory, SQLSRV_FETCH_ASSOC);
  ?>
  <?php
}
 if ($_POST['txt_flg'] == "edit_vehicletransportdocumentplan") {
   $rs = editVehicletransportdocumentplan(
   'edit_vehicletransportdocumentplan', $_POST['ID'], $_POST['fieldname'], $_POST['editableObj']);
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
 if ($_POST['txt_flg'] == "edit_vehicletransportdocumentplanclosejob") {
   $rs = editVehicletransportdocumentplan(
   'edit_vehicletransportdocumentplanclosejob', $_POST['ID'], $_POST['fieldname'], $_POST['editableObj']);
   
}
if ($_POST['txt_flg'] == "edit_vehicletransportdocumentsavethainame") {
  $rs = editVehicletransportdocumentplan(
  'edit_vehicletransportdocumentsavethainame', $_POST['ID'], $_POST['fieldname'], $_POST['editableObj']);
}
if ($_POST['txt_flg'] == "edit_vehicletransportdocumentclear4load8loadall") {
    $rs = editVehicletransportdocumentplan(
    'edit_vehicletransportdocumentclear4load8loadall', $_POST['ID'], $_POST['fieldname'], $_POST['editableObj']);
    
}
if ($_POST['txt_flg'] == "edit_vehicletransportdocumentclearclearchk4load8loadallwhenOT15chk") {
    $rs = editVehicletransportdocumentplan(
    'edit_vehicletransportdocumentclearclearchk4load8loadallwhenOT15chk', $_POST['ID'], $_POST['fieldname'], $_POST['editableObj']);
    
}
if ($_POST['txt_flg'] == "edit_vehicletransportdocumentsavestmround") {
    // function Update รอบวิ่งงานสายงาน STM
    $sql_savestmroundamount = "UPDATE VEHICLETRANSPORTPLAN
    SET ROUNDAMOUNT = '" . $_POST['editableObj'] . "'
    WHERE VEHICLETRANSPORTPLANID ='" . $_POST['ID'] . "'";
    $query_savestmroundamount  = sqlsrv_query($conn, $sql_savestmroundamount, $params_savestmroundamount);
    $result_savestmroundamount = sqlsrv_fetch_array($query_savestmroundamount, SQLSRV_FETCH_ASSOC);   

    // Update เมื่อมีการแก้ไขรอบวิ่งงานจากหน้า แผนปฎิบัติงาน และ หน้าคีย์ค่าตอบแทน 
    //จะทำการอัพเดท COMPENSATION ,COMPENSATION1,COMPENSATION2,TOTALCOMPEN เป็นค่า NULL
    $sql_updatecompensationstm = "UPDATE VEHICLETRANSPORTDOCUMENTDIRVER
    SET COMPENSATION = NULL,COMPENSATION1 = NULL,COMPENSATION2 = NULL,TOTALCOMPEN = NULL
    WHERE VEHICLETRANSPORTPLANID ='" . $_POST['ID'] . "'";
    $query_updatecompensationstm  = sqlsrv_query($conn, $sql_updatecompensationstm, $params_updatecompensationstm);
    $result_updatecompensationstm = sqlsrv_fetch_array($query_updatecompensationstm, SQLSRV_FETCH_ASSOC);   
}
if ($_POST['txt_flg'] == "edit_savetdemprpo") {
?>

    <?php
    $sql_savetdemprpo = "{call megEditvehicletransportdocumentdriver_v2(?,?,?,?,?,?,?,?,?)}";
    $params_savetdemprpo = array(
    array('edit_savetdemprpo', SQLSRV_PARAM_IN),
    array($_POST['invoicecode'], SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array($_POST['editableObj'], SQLSRV_PARAM_IN),
    array($_POST['companycode'], SQLSRV_PARAM_IN),
    array($_POST['customercode'], SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
    );

    $query_savetdemprpo = sqlsrv_query($conn, $sql_savetdemprpo, $params_savetdemprpo);
    $result_savetdemprpo = sqlsrv_fetch_array($query_savetdemprpo, SQLSRV_FETCH_ASSOC);
    ?>

<?php
}
if ($_POST['txt_flg'] == "clear_keydroptime") {
    // function เครียข้อมูลเวลาวางกุญแจ กรณีข้อมูลผิดพลาด
    $sql_clearkeydroptime = "UPDATE DRIVERSELFCHECK
        SET KEYDROPTIME = NULL,TIMEWORKING = NULL ,TIMEWORKINGSTATUS = NULL,
        CLEARKEYDROPTIMEBY = '" . $_POST['clearby'] . "',CLEARKEYDROPTIMEDATE = GETDATE()
        WHERE SELFCHECKID ='" . $_POST['selfcheckid'] . "'";
    $query_clearkeydroptime  = sqlsrv_query($conn, $sql_clearkeydroptime, $params_clearkeydroptime);
    $result_clearkeydroptime = sqlsrv_fetch_array($query_clearkeydroptime, SQLSRV_FETCH_ASSOC);   
}

if ($_POST['txt_flg'] == "save_keydroptime") {
    $rs = editVehicletransportdocumentplan(
    'save_keydroptime', $_POST['ID'], $_POST['fieldname'], $_POST['editableObj']);  
}
if ($_POST['txt_flg'] == "save_digitaltenkokpi") {
?>

    <?php
    $sql_savetdigitaltenkokpi = "{call megDigitalTenko_KPI(?,?,?,?,?,?,?,?,?)}";
    $params_savetdigitaltenkokpi = array(
    array('save_digitaltenkokpi', SQLSRV_PARAM_IN),
    array($_POST['id'], SQLSRV_PARAM_IN),
    array($_POST['date'], SQLSRV_PARAM_IN),
    array($_POST['value'], SQLSRV_PARAM_IN),
    array($_POST['remark'], SQLSRV_PARAM_IN),
    array($_POST['remark_month'], SQLSRV_PARAM_IN),
    array($_POST['remark_year'], SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array($_POST['createby'], SQLSRV_PARAM_IN)
    );

    $query_savetdigitaltenkokpi = sqlsrv_query($conn, $sql_savetdigitaltenkokpi, $params_savetdigitaltenkokpi);
    $result_savetdigitaltenkokpi = sqlsrv_fetch_array($query_savetdigitaltenkokpi, SQLSRV_FETCH_ASSOC);
    ?>

<?php
}
if ($_POST['txt_flg'] == "save_digitaltenko_truckreadiness_kpi") {
?>

    <?php
    $sql_savetdigitaltenkokpi = "{call megDigitalTenko_TruckReadiness_KPI(?,?,?,?,?,?,?,?,?)}";
    $params_savetdigitaltenkokpi = array(
    array('save_digitaltenko_truckrediness_kpi', SQLSRV_PARAM_IN),
    array($_POST['id'], SQLSRV_PARAM_IN),
    array($_POST['date'], SQLSRV_PARAM_IN),
    array($_POST['value'], SQLSRV_PARAM_IN),
    array($_POST['remark'], SQLSRV_PARAM_IN),
    array($_POST['remark_month'], SQLSRV_PARAM_IN),
    array($_POST['remark_year'], SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array($_POST['createby'], SQLSRV_PARAM_IN)
    );

    $query_savetdigitaltenkokpi = sqlsrv_query($conn, $sql_savetdigitaltenkokpi, $params_savetdigitaltenkokpi);
    $result_savetdigitaltenkokpi = sqlsrv_fetch_array($query_savetdigitaltenkokpi, SQLSRV_FETCH_ASSOC);
    ?>

<?php
}
if ($_POST['txt_flg'] == "save_digitaltenko_truckcameracheck_kpi") {
?>

    <?php
    $sql_savedigitaltenkokpi = "{call megDigitalTenko_TruckCameraCheck_KPI(?,?,?,?,?,?,?,?,?)}";
    $params_savedigitaltenkokpi = array(
    array('save_digitaltenko_truckcameracheck_kpi', SQLSRV_PARAM_IN),
    array($_POST['id'], SQLSRV_PARAM_IN),
    array($_POST['date'], SQLSRV_PARAM_IN),
    array($_POST['value'], SQLSRV_PARAM_IN),
    array($_POST['remark'], SQLSRV_PARAM_IN),
    array($_POST['remark_month'], SQLSRV_PARAM_IN),
    array($_POST['remark_year'], SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array($_POST['createby'], SQLSRV_PARAM_IN)
    );

    $query_savedigitaltenkokpi = sqlsrv_query($conn, $sql_savedigitaltenkokpi, $params_savedigitaltenkokpi);
    $result_savedigitaltenkokpi = sqlsrv_fetch_array($query_savedigitaltenkokpi, SQLSRV_FETCH_ASSOC);
    ?>

<?php
}
if ($_POST['txt_flg'] == "save_digitaltenko_stopcallwait_kpi") {
?>

    <?php
    $sql_savestopcallwaitkpi = "{call megDigitalTenko_StopCallWait_KPI(?,?,?,?,?,?,?,?,?)}";
    $params_savestopcallwaitkpi = array(
    array('save_digitaltenko_stopcallwait_kpi', SQLSRV_PARAM_IN),
    array($_POST['id'], SQLSRV_PARAM_IN),
    array($_POST['date'], SQLSRV_PARAM_IN),
    array($_POST['value'], SQLSRV_PARAM_IN),
    array($_POST['remark'], SQLSRV_PARAM_IN),
    array($_POST['remark_month'], SQLSRV_PARAM_IN),
    array($_POST['remark_year'], SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array($_POST['createby'], SQLSRV_PARAM_IN)
    );

    $query_savestopcallwaitkpi = sqlsrv_query($conn, $sql_savestopcallwaitkpi, $params_savestopcallwaitkpi);
    $result_savestopcallwaitkpi = sqlsrv_fetch_array($query_savestopcallwaitkpi, SQLSRV_FETCH_ASSOC);
    ?>

<?php
}
if ($_POST['txt_flg'] == "save_digitaltenkoNG") {
?>

    <?php
    $sql_savetdigitaltenkoNG = "{call megDigitalTenko_NG(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params_savetdigitaltenkoNG = array(
    array('save_digitaltenkoNG', SQLSRV_PARAM_IN),
    array($_POST['id'], SQLSRV_PARAM_IN),
    array($_POST['date'], SQLSRV_PARAM_IN),
    array($_POST['drivername'], SQLSRV_PARAM_IN),
    array($_POST['tenkong'], SQLSRV_PARAM_IN),
    array($_POST['annualleave'], SQLSRV_PARAM_IN),
    array($_POST['sickleave'], SQLSRV_PARAM_IN),
    array($_POST['cause_data'], SQLSRV_PARAM_IN),
    array($_POST['action_data'], SQLSRV_PARAM_IN),
    array($_POST['remark_month'], SQLSRV_PARAM_IN),
    array($_POST['remark_year'], SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array($_POST['createby'], SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
    );

    $query_savetdigitaltenkoNG = sqlsrv_query($conn, $sql_savetdigitaltenkoNG, $params_savetdigitaltenkoNG);
    $result_savetdigitaltenkoNG = sqlsrv_fetch_array($query_savetdigitaltenkoNG, SQLSRV_FETCH_ASSOC);
    ?>

<?php
}
if ($_POST['txt_flg'] == "save_zoneforskb") {
?>

    <?php
    $sql_savezoneforskb = "{call megZoneForSKB(?,?,?,?,?,?,?,?)}";
    $params_savezoneforskb = array(
    array('save_zoneforskb', SQLSRV_PARAM_IN),
    array($_POST['id'], SQLSRV_PARAM_IN),
    array($_POST['province'], SQLSRV_PARAM_IN),
    array($_POST['zone'], SQLSRV_PARAM_IN),
    array($_POST['createby'], SQLSRV_PARAM_IN),
    array($_POST['createdate'], SQLSRV_PARAM_IN),
    array($_POST['modifyby'], SQLSRV_PARAM_IN),
    array($_POST['modifydate'], SQLSRV_PARAM_IN)
    );

    $query_savezoneforskb = sqlsrv_query($conn, $sql_savezoneforskb, $params_savezoneforskb);
    $result_savezoneforskb = sqlsrv_fetch_array($query_savezoneforskb, SQLSRV_FETCH_ASSOC);
    ?>

<?php
}
if ($_POST['txt_flg'] == "update_zoneforskb") {
?>

    <?php
    $sql_savezoneforskb = "{call megZoneForSKB(?,?,?,?,?,?,?,?)}";
    $params_savezoneforskb = array(
    array('update_zoneforskb', SQLSRV_PARAM_IN),
    array($_POST['id'], SQLSRV_PARAM_IN),
    array($_POST['province'], SQLSRV_PARAM_IN),
    array($_POST['zone'], SQLSRV_PARAM_IN),
    array($_POST['createby'], SQLSRV_PARAM_IN),
    array($_POST['createdate'], SQLSRV_PARAM_IN),
    array($_POST['modifyby'], SQLSRV_PARAM_IN),
    array($_POST['modifydate'], SQLSRV_PARAM_IN)
    );

    $query_savezoneforskb = sqlsrv_query($conn, $sql_savezoneforskb, $params_savezoneforskb);
    $result_savezoneforskb = sqlsrv_fetch_array($query_savezoneforskb, SQLSRV_FETCH_ASSOC);
    ?>

<?php
}
if ($_POST['txt_flg'] == "update_provinceforskb") {
?>

    <?php
    $sql_savezoneforskb = "{call megZoneForSKB(?,?,?,?,?,?,?,?)}";
    $params_savezoneforskb = array(
    array('update_provinceforskb', SQLSRV_PARAM_IN),
    array($_POST['id'], SQLSRV_PARAM_IN),
    array($_POST['province'], SQLSRV_PARAM_IN),
    array($_POST['zone'], SQLSRV_PARAM_IN),
    array($_POST['createby'], SQLSRV_PARAM_IN),
    array($_POST['createdate'], SQLSRV_PARAM_IN),
    array($_POST['modifyby'], SQLSRV_PARAM_IN),
    array($_POST['modifydate'], SQLSRV_PARAM_IN)
    );

    $query_savezoneforskb = sqlsrv_query($conn, $sql_savezoneforskb, $params_savezoneforskb);
    $result_savezoneforskb = sqlsrv_fetch_array($query_savezoneforskb, SQLSRV_FETCH_ASSOC);
    ?>

<?php
}
if ($_POST['txt_flg'] == "save_keylocker") {
?>

    <?php
    $sql_savetdigitaltenkoNG = "{call megKeyLocker(?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params_savetdigitaltenkoNG = array(
    array('save_keylocker', SQLSRV_PARAM_IN),
    array($_POST['id'], SQLSRV_PARAM_IN),
    array($_POST['regisid'], SQLSRV_PARAM_IN),
    array($_POST['regisnumber'], SQLSRV_PARAM_IN),
    array($_POST['jobno'], SQLSRV_PARAM_IN),
    array($_POST['keylogstatus'], SQLSRV_PARAM_IN),
    array($_POST['datepickup'], SQLSRV_PARAM_IN),
    array($_POST['datereturn'], SQLSRV_PARAM_IN),
    array($_POST['keypicker'], SQLSRV_PARAM_IN),
    array($_POST['keyreturnperson'], SQLSRV_PARAM_IN),
    array($_POST['keylogdetail'], SQLSRV_PARAM_IN),
    array($_POST['keylogremark'], SQLSRV_PARAM_IN),
    array($_POST['createdate'], SQLSRV_PARAM_IN),
    array($_POST['createby'], SQLSRV_PARAM_IN)
    );

    $query_savetdigitaltenkoNG = sqlsrv_query($conn, $sql_savetdigitaltenkoNG, $params_savetdigitaltenkoNG);
    $result_savetdigitaltenkoNG = sqlsrv_fetch_array($query_savetdigitaltenkoNG, SQLSRV_FETCH_ASSOC);
    ?>


<?php
}
if ($_POST['txt_flg'] == "save_keylockerclose") {
?>

    <?php
    $sql_savetdigitaltenkoNG = "{call megKeyLocker(?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params_savetdigitaltenkoNG = array(
    array('save_keylockerclose', SQLSRV_PARAM_IN),
    array($_POST['id'], SQLSRV_PARAM_IN),
    array($_POST['regisid'], SQLSRV_PARAM_IN),
    array($_POST['regisnumber'], SQLSRV_PARAM_IN),
    array($_POST['jobno'], SQLSRV_PARAM_IN),
    array($_POST['keylogstatus'], SQLSRV_PARAM_IN),
    array($_POST['datepickup'], SQLSRV_PARAM_IN),
    array($_POST['datereturn'], SQLSRV_PARAM_IN),
    array($_POST['keypicker'], SQLSRV_PARAM_IN),
    array($_POST['keyreturnperson'], SQLSRV_PARAM_IN),
    array($_POST['keylogdetail'], SQLSRV_PARAM_IN),
    array($_POST['keylogremark'], SQLSRV_PARAM_IN),
    array($_POST['createdate'], SQLSRV_PARAM_IN),
    array($_POST['createby'], SQLSRV_PARAM_IN)
    );

    $query_savetdigitaltenkoNG = sqlsrv_query($conn, $sql_savetdigitaltenkoNG, $params_savetdigitaltenkoNG);
    $result_savetdigitaltenkoNG = sqlsrv_fetch_array($query_savetdigitaltenkoNG, SQLSRV_FETCH_ASSOC);
    ?>

<?php
}
if ($_POST['txt_flg'] == "save_drivercheckbf") {
?>

    <?php
    $sql_savetdigitaltenkoNG = "{call megKeyLocker(?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params_savetdigitaltenkoNG = array(
    array('save_drivercheckbf', SQLSRV_PARAM_IN),
    array($_POST['id'], SQLSRV_PARAM_IN),
    array($_POST['regisid'], SQLSRV_PARAM_IN),
    array($_POST['regisnumber'], SQLSRV_PARAM_IN),
    array($_POST['jobno'], SQLSRV_PARAM_IN),
    array($_POST['keylogstatus'], SQLSRV_PARAM_IN),
    array($_POST['datepickup'], SQLSRV_PARAM_IN),
    array($_POST['datereturn'], SQLSRV_PARAM_IN),
    array($_POST['keypicker'], SQLSRV_PARAM_IN),
    array($_POST['keyreturnperson'], SQLSRV_PARAM_IN),
    array($_POST['keylogdetail'], SQLSRV_PARAM_IN),
    array($_POST['keylogremark'], SQLSRV_PARAM_IN),
    array($_POST['createdate'], SQLSRV_PARAM_IN),
    array($_POST['createby'], SQLSRV_PARAM_IN)
    );

    $query_savetdigitaltenkoNG = sqlsrv_query($conn, $sql_savetdigitaltenkoNG, $params_savetdigitaltenkoNG);
    $result_savetdigitaltenkoNG = sqlsrv_fetch_array($query_savetdigitaltenkoNG, SQLSRV_FETCH_ASSOC);
    ?>

<?php
}
if ($_POST['txt_flg'] == "save_drivercheckaf") {
?>

    <?php
    $sql_savetdigitaltenkoNG = "{call megKeyLocker(?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params_savetdigitaltenkoNG = array(
    array('save_drivercheckaf', SQLSRV_PARAM_IN),
    array($_POST['id'], SQLSRV_PARAM_IN),
    array($_POST['regisid'], SQLSRV_PARAM_IN),
    array($_POST['regisnumber'], SQLSRV_PARAM_IN),
    array($_POST['jobno'], SQLSRV_PARAM_IN),
    array($_POST['keylogstatus'], SQLSRV_PARAM_IN),
    array($_POST['datepickup'], SQLSRV_PARAM_IN),
    array($_POST['datereturn'], SQLSRV_PARAM_IN),
    array($_POST['keypicker'], SQLSRV_PARAM_IN),
    array($_POST['keyreturnperson'], SQLSRV_PARAM_IN),
    array($_POST['keylogdetail'], SQLSRV_PARAM_IN),
    array($_POST['keylogremark'], SQLSRV_PARAM_IN),
    array($_POST['createdate'], SQLSRV_PARAM_IN),
    array($_POST['createby'], SQLSRV_PARAM_IN)
    );

    $query_savetdigitaltenkoNG = sqlsrv_query($conn, $sql_savetdigitaltenkoNG, $params_savetdigitaltenkoNG);
    $result_savetdigitaltenkoNG = sqlsrv_fetch_array($query_savetdigitaltenkoNG, SQLSRV_FETCH_ASSOC);
    ?>

<?php
}
if ($_POST['txt_flg'] == "save_keylockerrwc") {
?>

    <?php
    $sql_savetdigitaltenkoNG = "{call megKeyLocker(?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params_savetdigitaltenkoNG = array(
    array('save_keylockerrwc', SQLSRV_PARAM_IN),
    array($_POST['id'], SQLSRV_PARAM_IN),
    array($_POST['regisid'], SQLSRV_PARAM_IN),
    array($_POST['regisnumber'], SQLSRV_PARAM_IN),
    array($_POST['jobno'], SQLSRV_PARAM_IN),
    array($_POST['keylogstatus'], SQLSRV_PARAM_IN),
    array($_POST['datepickup'], SQLSRV_PARAM_IN),
    array($_POST['datereturn'], SQLSRV_PARAM_IN),
    array($_POST['keypicker'], SQLSRV_PARAM_IN),
    array($_POST['keyreturnperson'], SQLSRV_PARAM_IN),
    array($_POST['keylogdetail'], SQLSRV_PARAM_IN),
    array($_POST['keylogremark'], SQLSRV_PARAM_IN),
    array($_POST['createdate'], SQLSRV_PARAM_IN),
    array($_POST['createby'], SQLSRV_PARAM_IN)
    );

    $query_savetdigitaltenkoNG = sqlsrv_query($conn, $sql_savetdigitaltenkoNG, $params_savetdigitaltenkoNG);
    $result_savetdigitaltenkoNG = sqlsrv_fetch_array($query_savetdigitaltenkoNG, SQLSRV_FETCH_ASSOC);
    ?>

<?php
}
if ($_POST['txt_flg'] == "update_mileageEM") {
?>

    <?php
    $sql_updatemileageEM = "{call megMileage_v2(?,?,?,?,?,?,?)}";
    $params_updatemileageEM = array(
    array('update_mileageEM', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array($_POST['vehicleregisternumber1'], SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array($_POST['mileagenumber'], SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
    );

    $query_updatemileageEM = sqlsrv_query($conn, $sql_updatemileageEM, $params_updatemileageEM);
    $result_updatemileageEM = sqlsrv_fetch_array($query_updatemileageEM, SQLSRV_FETCH_ASSOC);
    ?>

<?php
}
if ($_POST['txt_flg'] == "update_stopvehicle") {
?>

    <?php
    $sql_savetdigitaltenkoNG = "{call megKeyLocker(?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params_savetdigitaltenkoNG = array(
    array('update_stopvehicle', SQLSRV_PARAM_IN),
    array($_POST['id'], SQLSRV_PARAM_IN),
    array($_POST['regisid'], SQLSRV_PARAM_IN),
    array($_POST['regisnumber'], SQLSRV_PARAM_IN),
    array($_POST['jobno'], SQLSRV_PARAM_IN),
    array($_POST['keylogstatus'], SQLSRV_PARAM_IN),
    array($_POST['datepickup'], SQLSRV_PARAM_IN),
    array($_POST['datereturn'], SQLSRV_PARAM_IN),
    array($_POST['keypicker'], SQLSRV_PARAM_IN),
    array($_POST['keyreturnperson'], SQLSRV_PARAM_IN),
    array($_POST['keylogdetail'], SQLSRV_PARAM_IN),
    array($_POST['keylogremark'], SQLSRV_PARAM_IN),
    array($_POST['createdate'], SQLSRV_PARAM_IN),
    array($_POST['createby'], SQLSRV_PARAM_IN)
    );

    $query_savetdigitaltenkoNG = sqlsrv_query($conn, $sql_savetdigitaltenkoNG, $params_savetdigitaltenkoNG);
    $result_savetdigitaltenkoNG = sqlsrv_fetch_array($query_savetdigitaltenkoNG, SQLSRV_FETCH_ASSOC);
    ?>

<?php
}
if ($_POST['txt_flg'] == "check_thainame") {
?>

    <?php
    $sql = "SELECT RTRIM(VEHICLEINFOID) ,RTRIM(VEHICLEREGISNUMBER) AS 'REGIS',
    RTRIM(STATUSTRUCK) AS 'STATUS'
    FROM VEHICLEINFO WHERE  VEHICLEREGISNUMBER ='".$_POST['thainame']."'";

    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['STATUS'];
    ?>


<?php
}
if ($_POST['txt_flg'] == "check_thainamercc") {
?>

    <?php
    $sql = "SELECT RTRIM(VEHICLEINFOID) ,RTRIM(VEHICLEREGISNUMBER) AS 'REGIS',RTRIM(THAINAME) AS 'THAINAME',
    RTRIM(STATUSTRUCK) AS 'STATUS'
    FROM VEHICLEINFO WHERE  THAINAME ='".$_POST['thainame']."'";

    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['STATUS'];
    ?>


<?php
}
if ($_POST['txt_flg'] == "update_digitaltenkoNG") {
?>

    <?php
    $sql_savetdigitaltenkoNG = "{call megDigitalTenko_NG(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params_savetdigitaltenkoNG = array(
    array('update_digitaltenkoNG', SQLSRV_PARAM_IN),
    array($_POST['id'], SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array($_POST['createby'], SQLSRV_PARAM_IN),
    array($_POST['checkcolunm'], SQLSRV_PARAM_IN),
    array($_POST['editobj'], SQLSRV_PARAM_IN)
    );

    $query_savetdigitaltenkoNG = sqlsrv_query($conn, $sql_savetdigitaltenkoNG, $params_savetdigitaltenkoNG);
    $result_savetdigitaltenkoNG = sqlsrv_fetch_array($query_savetdigitaltenkoNG, SQLSRV_FETCH_ASSOC);
    ?>

<?php
}
if ($_POST['txt_flg'] == "delete_digitaltenkoNG") {
?>

    <?php
    $sql_savetdigitaltenkoNG = "{call megDigitalTenko_NG(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params_savetdigitaltenkoNG = array(
    array('delete_digitaltenkoNG', SQLSRV_PARAM_IN),
    array($_POST['id'], SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
    );

    $query_savetdigitaltenkoNG = sqlsrv_query($conn, $sql_savetdigitaltenkoNG, $params_savetdigitaltenkoNG);
    $result_savetdigitaltenkoNG = sqlsrv_fetch_array($query_savetdigitaltenkoNG, SQLSRV_FETCH_ASSOC);
    ?>

<?php
}
if ($_POST['txt_flg'] == "insert_organization") {
  ?>

  <?php

  $sql_insertorganization = "{call megEditOrganization(?,?,?,?,?,?,?,?,?,?,?)}";
  $params_insertorganization = array(
  array('insert_organization', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array($_POST['employeecode'], SQLSRV_PARAM_IN),
  array($_POST['area'], SQLSRV_PARAM_IN),
  array($_POST['companycode'], SQLSRV_PARAM_IN),
  array($_POST['departmentcode'], SQLSRV_PARAM_IN),
  array($_POST['sectioncode'], SQLSRV_PARAM_IN),
  array($_POST['createby'], SQLSRV_PARAM_IN)
  );

  $query_insertorganization = sqlsrv_query($conn, $sql_insertorganization, $params_insertorganization);
  $result_insertorganization = sqlsrv_fetch_array($query_insertorganization, SQLSRV_FETCH_ASSOC);
  ?>



  <?php
}
if ($_POST['txt_flg'] == "update_organization") {
  ?>

  <?php

  $sql_UpdateORG = "{call megEditOrganization(?,?,?,?,?,?,?,?,?,?,?)}";
  $params_UpdateORG = array(
  array('update_organization', SQLSRV_PARAM_IN),
  array($_POST['value'], SQLSRV_PARAM_IN),
  array($_POST['fieldname'], SQLSRV_PARAM_IN),
  array($_POST['organizationid'], SQLSRV_PARAM_IN),
  array($_POST['modifiedby'], SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN)
  );

  $query_UpdateORG  = sqlsrv_query($conn, $sql_UpdateORG, $params_UpdateORG);
  $result_UpdateORG = sqlsrv_fetch_array($query_UpdateORG, SQLSRV_FETCH_ASSOC);
  ?>



  <?php
}
if ($_POST['txt_flg'] == "delete_organization") {
  ?>

  <?php

  $sql_deleteorganization = "{call megEditOrganization(?,?,?,?,?,?,?,?,?,?,?)}";
  $params_deleteorganization = array(
  array('delete_organization', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array($_POST['id'], SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN),
  array('', SQLSRV_PARAM_IN)
  );

  $query_deleteorganization = sqlsrv_query($conn, $sql_deleteorganization, $params_deleteorganization);
  $result_deleteorganization = sqlsrv_fetch_array($query_deleteorganization, SQLSRV_FETCH_ASSOC);
  ?>



  <?php
}
if ($_POST['txt_flg'] == "select_customercompensation") {
  ?>
  <select  class="form-control"  title="เลือกลูกค้า..." id='select_cus' >
    <option value="ALL">เลือกทั้งหมด</option>
    <?php
    $sql_seCus = "SELECT DISTINCT CUSTOMERCODE FROM [dbo].[VEHICLETRANSPORTPRICE] WHERE CUSTOMERCODE IS NOT NULL AND CUSTOMERCODE != '' AND COMPANYCODE = '" . $_POST['companycode'] . "'";

    $query_seCus = sqlsrv_query($conn, $sql_seCus, $params_seCus);
    while ($result_seCus = sqlsrv_fetch_array($query_seCus, SQLSRV_FETCH_ASSOC)) {
      ?>
      <option value="<?= $result_seCus['CUSTOMERCODE'] ?>" ><?= $result_seCus['CUSTOMERCODE'] ?></option>
      <?php
    }
    ?>
  </select>
  <?php
}
if ($_POST['txt_flg'] == "select_customercompensation_rrcratc_day") {
  ?>
  
    <?php
    if ($_POST['companycode'] == 'RCC') {
    ?>
            <select  class="form-control"  title="เลือกข้อมูล..." id='txt_data_day' >
                <option value="">เลือกข้อมูล...</option>
                <?php
                $sql_seCus = "SELECT DISTINCT PositionNameT
                FROM EMPLOYEEEHR2 WHERE Company_Code ='RCC'
                AND PositionNameT IN('พนักงานขนส่งยานยนต์/RCC 4 LOAD','พนักงานขนส่งยานยนต์/RCC 8 LOAD')
                ORDER BY PositionNameT ASC";

                $query_seCus = sqlsrv_query($conn, $sql_seCus, $params_seCus);
                while ($result_seCus = sqlsrv_fetch_array($query_seCus, SQLSRV_FETCH_ASSOC)) {
                ?>
                <option value="<?= $result_seCus['PositionNameT'] ?>" ><?= $result_seCus['PositionNameT'] ?></option>
                <?php
                }
                ?>
                <option value="OTHER">ตำแหน่งอื่นๆ</option>
            </select>
    <?php
    }else{
    ?>
            <select  class="form-control"  title="เลือกข้อมูล..." id='txt_data_day' >
                <option value="">เลือกข้อมูล...</option>
                <?php
                $sql_seCus = "SELECT DISTINCT PositionNameT
                FROM EMPLOYEEEHR2 WHERE Company_Code ='RATC'
                AND PositionNameT IN('พนักงานขนส่งยานยนต์/RATC 4 LOAD','พนักงานขนส่งยานยนต์/RATC 8 LOAD')
                ORDER BY PositionNameT ASC";

                $query_seCus = sqlsrv_query($conn, $sql_seCus, $params_seCus);
                while ($result_seCus = sqlsrv_fetch_array($query_seCus, SQLSRV_FETCH_ASSOC)) {
                ?>
                <option value="<?= $result_seCus['PositionNameT'] ?>" ><?= $result_seCus['PositionNameT'] ?></option>
                <?php
                }
                ?>
                <option value="OTHER">ตำแหน่งอื่นๆ</option>
            </select>
    <?php
    }
    ?>
  
  <?php
}
if ($_POST['txt_flg'] == "select_customercompensation_rrcratc_month") {
  ?>
  
    <?php
    if ($_POST['companycode'] == 'RCC') {
    ?>
            <select  class="form-control"  title="เลือกข้อมูล..." id='txt_data_month' >
                <option value="">เลือกข้อมูล...</option>
                <?php
                $sql_seCus = "SELECT DISTINCT PositionNameT
                FROM EMPLOYEEEHR2 WHERE Company_Code ='RCC'
                AND PositionNameT IN('พนักงานขนส่งยานยนต์/RCC 4 LOAD','พนักงานขนส่งยานยนต์/RCC 8 LOAD')
                ORDER BY PositionNameT ASC";

                $query_seCus = sqlsrv_query($conn, $sql_seCus, $params_seCus);
                while ($result_seCus = sqlsrv_fetch_array($query_seCus, SQLSRV_FETCH_ASSOC)) {
                ?>
                <option value="<?= $result_seCus['PositionNameT'] ?>" ><?= $result_seCus['PositionNameT'] ?></option>
                <?php
                }
                ?>
                <option value="OTHER">ตำแหน่งอื่นๆ</option>
            </select>
    <?php
    }else{
    ?>
            <select  class="form-control"  title="เลือกข้อมูล..." id='txt_data_month' >
                <option value="">เลือกข้อมูล...</option>
                <?php
                $sql_seCus = "SELECT DISTINCT PositionNameT
                FROM EMPLOYEEEHR2 WHERE Company_Code ='RATC'
                AND PositionNameT IN('พนักงานขนส่งยานยนต์/RATC 4 LOAD','พนักงานขนส่งยานยนต์/RATC 8 LOAD')
                ORDER BY PositionNameT ASC";

                $query_seCus = sqlsrv_query($conn, $sql_seCus, $params_seCus);
                while ($result_seCus = sqlsrv_fetch_array($query_seCus, SQLSRV_FETCH_ASSOC)) {
                ?>
                <option value="<?= $result_seCus['PositionNameT'] ?>" ><?= $result_seCus['PositionNameT'] ?></option>
                <?php
                }
                ?>
                <option value="OTHER">ตำแหน่งอื่นๆ</option>
            </select>
    <?php
    }
    ?>
  
  <?php
}
if ($_POST['txt_flg'] == "select_reporttenko") {
  ?>
    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
        <thead>
            <tr>
                <th style="width: 45px">เลขที่งาน1</th>
                <th style="width: 10px">บริษัท</th>
                <th style="width: 10px">ลูกค้า</th>
                <th style="width: 10px">ต้นทาง</th>
                <th style="width: 10px">ปลายทาง</th>
                <th style="width: 10px">พนักงานที่ 1</th>
                <th style="width: 60px">รายงาน พขร.1</th>
                <th style="width: 10px">พนักงานที่ 2</th>
                <th style="width: 60px">รายงาน พขร.2</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // $condition2 = "AND a.Company_Code IN ('RKS','RKR','RKL')
            // AND a.PersonCode NOT IN('070117','070116','021541','021483','021300','011661','010001')
            // ORDER BY a.PersonCode ASC";
            // $condition3 = "";

            if ($_POST['area'] == 'amt') {
                $sql_seData = "SELECT VEHICLETRANSPORTPLANID,JOBNO,COMPANYCODE,CUSTOMERCODE,JOBSTART,JOBEND,
                EMPLOYEENAME1,EMPLOYEECODE1,EMPLOYEENAME2,EMPLOYEECODE2,DATEWORKING,TENKOMASTERID
                FROM VEHICLETRANSPORTPLAN
                WHERE CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_POST['datestart']."',103) AND CONVERT(DATE,'".$_POST['dateend']."',103)
                AND COMPANYCODE IN ('RKR','RKL','RKS')
                AND (TENKOMASTERID IS NOT NULL OR TENKOMASTERID !='')";
                $params_seData = array();
            }else{
                $sql_seData = "SELECT VEHICLETRANSPORTPLANID,JOBNO,COMPANYCODE,CUSTOMERCODE,JOBSTART,JOBEND,
                EMPLOYEENAME1,EMPLOYEECODE1,EMPLOYEENAME2,EMPLOYEECODE2,DATEWORKING,TENKOMASTERID
                FROM VEHICLETRANSPORTPLAN
                WHERE CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_POST['datestart']."',103) AND CONVERT(DATE,'".$_POST['dateend']."',103)
                AND COMPANYCODE IN ('RCC','RRC','RATC')
                AND (TENKOMASTERID IS NOT NULL OR TENKOMASTERID !='')";
                $params_seData = array();
            }
            


            $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);
            while ($result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC)) {


                ?>
                <tr class="odd gradeX">
                    <td><?= $result_seData['JOBNO'] ?></td>
                    <td><?= $result_seData['COMPANYCODE'] ?></td>
                    <td><?= $result_seData['CUSTOMERCODE'] ?></td>
                    <td><?= $result_seData['JOBSTART'] ?></td>
                    <td><?= $result_seData['JOBEND'] ?></td>
                    <td><?= $result_seData['EMPLOYEENAME1'] ?></td>
                    <td style="text-align: center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu slidedown">
                                <li>
                                    <a  data-toggle="modal"  href="#" onclick="print_dataemployee1('<?= $result_seData['EMPLOYEECODE1'] ?>','<?= $result_seData['TENKOMASTERID'] ?>','<?= $result_seData['VEHICLETRANSPORTPLANID'] ?>')">
                                        เอกสารเท็งโกะ พขร.1
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                    <td><?= $result_seData['EMPLOYEENAME2'] ?></td>
                    <td style="text-align: center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu slidedown">
                                <li>
                                    <a  data-toggle="modal"  href="#" onclick="print_dataemployee1('<?= $result_seData['EMPLOYEECODE2'] ?>','<?= $result_seData['TENKOMASTERID'] ?>','<?= $result_seData['VEHICLETRANSPORTPLANID'] ?>')">
                                        เอกสารเท็งโกะ พขร.2
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>



                </tr>

                <?php
            }
            ?>
        </tbody>
    </table>
  <?php
}
if ($_POST['txt_flg'] == "savemileagesummary") {

    $sql_jobnochk    = "SELECT JOBNO AS 'JOBNO' FROM  VEHICLETRANSPORTPLAN WHERE VEHICLETRANSPORTPLANID ='".$_POST['planid']."'";
    $query_jobnochk  = sqlsrv_query($conn, $sql_jobnochk, $params_jobnochk);
    $result_jobnochk = sqlsrv_fetch_array($query_jobnochk, SQLSRV_FETCH_ASSOC);
    
    // เช็คข้อมูลในตารางเลขไมล์ dbo.MILEAGE

    $sql_chkmileagedata    = "SELECT  COUNT('".$result_jobnochk['JOBNO']."') AS 'COUNT' FROM MILEAGE_SUMMARY";
    $query_chkmileagedata  = sqlsrv_query($conn, $sql_chkmileagedata, $params_chkmileagedata);
    $result_chkmileagedata = sqlsrv_fetch_array($query_chkmileagedata, SQLSRV_FETCH_ASSOC);


    // เลขไมค์ต้น
            // $sql_seMileagestart = "SELECT TOP 1 MILEAGENUMBER FROM [dbo].[MILEAGE] 
            // WHERE MILEAGETYPE = 'MILEAGESTART' AND JOBNO = '" . $result_jobnochk['JOBNO'] . "' 
            // AND CONVERT(NVARCHAR,CREATEDATE,120) = (SELECT TOP 1 CONVERT(NVARCHAR,CREATEDATE,120) 
            // FROM [dbo].[MILEAGE] WHERE MILEAGETYPE = 'MILEAGESTART' 
            // AND JOBNO = '" . $result_jobnochk['JOBNO'] . "' 
            // ORDER BY CREATEDATE DESC) ORDER BY CREATEDATE DESC";
        $sql_seMileagestart = "SELECT TOP 1 MILEAGESTART AS MILEAGENUMBER FROM [TEMP_TATSUNODATA].[dbo].OIL_TATSUNO WHERE JOBNO = '" . $result_jobnochk['JOBNO'] . "'";
        $query_seMileagestart = sqlsrv_query($conn, $sql_seMileagestart, $params_seMileagestart);
        $result_seMileagestart = sqlsrv_fetch_array($query_seMileagestart, SQLSRV_FETCH_ASSOC);

    // เลขไมค์ปลาย
            // $sql_seMileageend = "SELECT TOP 1 MILEAGENUMBER FROM [dbo].[MILEAGE] 
            // WHERE MILEAGETYPE = 'MILEAGEEND' AND JOBNO = '" . $result_jobnochk['JOBNO'] . "' 
            // AND CONVERT(NVARCHAR,CREATEDATE,120) = (SELECT TOP 1 CONVERT(NVARCHAR,CREATEDATE,120) 
            // FROM [dbo].[MILEAGE] WHERE MILEAGETYPE = 'MILEAGEEND' 
            // AND JOBNO = '" . $result_jobnochk['JOBNO'] . "' ORDER BY CREATEDATE DESC) 
            // ORDER BY CREATEDATE DESC";
        $sql_seMileageend = "SELECT TOP 1 MILEAGEEND AS MILEAGENUMBER FROM [TEMP_TATSUNODATA].[dbo].OIL_TATSUNO WHERE JOBNO = '" . $result_jobnochk['JOBNO'] . "'";
        $query_seMileageend = sqlsrv_query($conn, $sql_seMileageend, $params_seMileageend);
        $result_seMileageend = sqlsrv_fetch_array($query_seMileageend, SQLSRV_FETCH_ASSOC);

    $sql_insertmileage = "{call megMileageSummary_v2(?,?,?,?,?,?,?,?,?,?,?)}";
    $params_insertmileage = array(
        array('save_mileage', SQLSRV_PARAM_IN),
        array($_POST['planid'], SQLSRV_PARAM_IN),
        array($result_jobnochk['JOBNO'], SQLSRV_PARAM_IN),
        array($result_seMileagestart['MILEAGENUMBER'], SQLSRV_PARAM_IN),
        array($result_seMileageend['MILEAGENUMBER'], SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array($_POST['createby'], SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_insertmileage = sqlsrv_query($conn, $sql_insertmileage, $params_insertmileage);
    $result_insertmileage = sqlsrv_fetch_array($query_insertmileage, SQLSRV_FETCH_ASSOC);
    
    //   echo $result['TIMEREST'];
    
}  
if ($_POST['txt_flg'] == "save_vehicletransportweightin_stc_cs") {
    //function save น้ำหนักของแต่ละ DO
    //onchange ในแต่ละ DocumentdriverID
?>

    <?php
        $sql_saveweightin_stc_cs = "{call megEditvehicletransportdocumentdriver_stc_cs_v2(?,?,?,?,?,?,?,?,?)}";
        $params_saveweightin_stc_cs = array(
        array('save_vehicletransportweightin_stc_cs', SQLSRV_PARAM_IN),
        array($_POST['condition1'], SQLSRV_PARAM_IN),
        array($_POST['fieldname'], SQLSRV_PARAM_IN),
        array($_POST['editableObj'], SQLSRV_PARAM_IN),
        array($_POST['jobstart'], SQLSRV_PARAM_IN),
        array($_POST['jobend'], SQLSRV_PARAM_IN),
        array($_POST['location'], SQLSRV_PARAM_IN),
        array($_POST['documentcode'], SQLSRV_PARAM_IN),
        array($_POST['modifyby'], SQLSRV_PARAM_IN)
        );

        $query_saveweightin_stc_cs = sqlsrv_query($conn, $sql_saveweightin_stc_cs, $params_saveweightin_stc_cs);
        $result_saveweightin_stc_cs = sqlsrv_fetch_array($query_saveweightin_stc_cs, SQLSRV_FETCH_ASSOC);
    ?>

<?php
}
if ($_POST['txt_flg'] == "update_compendata") {
  ?>

  <?php

    //อัพเดทค่าเที่ยวพนักงานคนที่ 1 และ 2 ในแผนเป็นค่า 0
    $sql_updatePlandata = "UPDATE VEHICLETRANSPORTPLAN
    SET E1 = '0' ,E2 = '0',C4 = '0',C5 = '0'
    WHERE VEHICLETRANSPORTPLANID ='".$_POST['planid']."'";
    $query_updatePlandata  = sqlsrv_query($conn, $sql_updatePlandata, $params_updatePlandata);
    $result_updatePlandata = sqlsrv_fetch_array($query_updatePlandata, SQLSRV_FETCH_ASSOC);

    //อัพเดทค่าเที่ยวพนักงานคนที่ 1 และ 2 ,ค่าใช้จ่ายอื่นๆ,ค่าเที่ยวรวม เป็นค่า ว่าง  และ ล้างข้อมูลการเลือกเช็คทั้งหมดให้เป็นค่า NULL
    $sql_updateDriverdata = "UPDATE VEHICLETRANSPORTDOCUMENTDIRVER
    SET COMPENSATION = '0',COMPENSATION1 = '0',COMPENSATION2 = '0',TOTALCOMPEN = '0',OTHER = '0',
    SELECT_4LOAD1 = NULL,PAY_4LOAD1REMARK = NULL,
    SELECT_4LOAD2 = NULL,PAY_4LOAD2REMARK = NULL,
    SELECT_4LOAD3 = NULL,PAY_4LOAD3REMARK = NULL,
    SELECT_4LOAD4 = NULL,PAY_4LOAD4REMARK = NULL,
    SELECT_4LOAD5 = NULL,PAY_4LOAD5REMARK = NULL,
    SELECT_4LOAD6 = NULL,PAY_4LOAD6REMARK = NULL,
    SELECT_8LOAD1 = NULL,PAY_8LOAD1REMARK = NULL,
    SELECT_8LOAD2 = NULL,PAY_8LOAD2REMARK = NULL
    WHERE VEHICLETRANSPORTPLANID ='".$_POST['planid']."'";
    $query_updateDriverdata  = sqlsrv_query($conn, $sql_updateDriverdata, $params_updateDriverdata);
    $result_updateDriverdata = sqlsrv_fetch_array($query_updateDriverdata, SQLSRV_FETCH_ASSOC);
  ?>



  <?php
}
if ($_POST['txt_flg'] == "save_stdtenkodata") {
  ?>

  <?php

  $sql_standardtenkodata = "{call megStandardTenkoData(?,?,?,?,?,?,?,?,?,?,?,?,?)}";
  $params_standardtenkodata = array(
  array('save_stdtenkodata', SQLSRV_PARAM_IN),
  array($_POST['ID'], SQLSRV_PARAM_IN),
  array($_POST['MAXSYS'], SQLSRV_PARAM_IN),
  array($_POST['MINSYS'], SQLSRV_PARAM_IN),
  array($_POST['MAXDIA'], SQLSRV_PARAM_IN),
  array($_POST['MINDIA'], SQLSRV_PARAM_IN),
  array($_POST['MAXPULSE'], SQLSRV_PARAM_IN),
  array($_POST['MINPULSE'], SQLSRV_PARAM_IN),
  array($_POST['TEMP'], SQLSRV_PARAM_IN),
  array($_POST['OXYGEN'], SQLSRV_PARAM_IN),
  array($_POST['ALCOHOL'], SQLSRV_PARAM_IN),
  array($_POST['REMARK'], SQLSRV_PARAM_IN),
  array($_POST['CREATEBY'], SQLSRV_PARAM_IN)
  );

  $query_standardtenkodata = sqlsrv_query($conn, $sql_standardtenkodata, $params_standardtenkodata);
  $result_standardtenkodata = sqlsrv_fetch_array($query_standardtenkodata, SQLSRV_FETCH_ASSOC);
  ?>



  <?php
}
if ($_POST['txt_flg'] == "update_stdtenkodata") {
  ?>

  <?php

  $sql_update_standardtenkodata = "{call megStandardTenkoData(?,?,?,?,?,?,?,?,?,?,?,?,?)}";
  $params_update_standardtenkodata = array(
  array('update_stdtenkodata', SQLSRV_PARAM_IN),
  array($_POST['ID'], SQLSRV_PARAM_IN),
  array($_POST['MAXSYS'], SQLSRV_PARAM_IN),
  array($_POST['MINSYS'], SQLSRV_PARAM_IN),
  array($_POST['MAXDIA'], SQLSRV_PARAM_IN),
  array($_POST['MINDIA'], SQLSRV_PARAM_IN),
  array($_POST['MAXPULSE'], SQLSRV_PARAM_IN),
  array($_POST['MINPULSE'], SQLSRV_PARAM_IN),
  array($_POST['TEMP'], SQLSRV_PARAM_IN),
  array($_POST['OXYGEN'], SQLSRV_PARAM_IN),
  array($_POST['ALCOHOL'], SQLSRV_PARAM_IN),
  array($_POST['REMARK'], SQLSRV_PARAM_IN),
  array($_POST['CREATEBY'], SQLSRV_PARAM_IN)
  );

  $query_update_standardtenkodata = sqlsrv_query($conn, $sql_update_standardtenkodata, $params_update_standardtenkodata);
  $result_update_standardtenkodata = sqlsrv_fetch_array($query_update_standardtenkodata, SQLSRV_FETCH_ASSOC);
  ?>



  <?php
}
if ($_POST['txt_flg'] == "edit_documentdriver_returncase") {

    if ($_POST['COMPENSATION2'] == '0') {
        $sql_updatedata = "UPDATE VEHICLETRANSPORTDOCUMENTDIRVER 
            SET COMPENSATION ='".$_POST['COMPENSATION']."',COMPENSATION1 ='".$_POST['COMPENSATION1']."',COMPENSATION2 = NULL,
            RETURNPRICE1 ='".$_POST['RETURNPRICE1']."',RETURNPRICE2 ='".$_POST['RETURNPRICE2']."'
            WHERE VEHICLETRANSPORTPLANID ='".$_POST['PLAN_ID']."'
            AND VEHICLETRANSPORTDOCUMENTDRIVERID ='".$_POST['DOCUMENTDRIVER_ID']."'";
        $query_updatedata  = sqlsrv_query($conn, $sql_updatedata, $params_updatedata);
        $result_updatedata = sqlsrv_fetch_array($query_updatedata, SQLSRV_FETCH_ASSOC);   
    }else {
        $sql_updatedata = "UPDATE VEHICLETRANSPORTDOCUMENTDIRVER 
            SET COMPENSATION ='".$_POST['COMPENSATION']."',COMPENSATION1 ='".$_POST['COMPENSATION1']."',COMPENSATION2 ='".$_POST['COMPENSATION2']."',
            RETURNPRICE1 ='".$_POST['RETURNPRICE1']."',RETURNPRICE2 ='".$_POST['RETURNPRICE2']."'
            WHERE VEHICLETRANSPORTPLANID ='".$_POST['PLAN_ID']."'
            AND VEHICLETRANSPORTDOCUMENTDRIVERID ='".$_POST['DOCUMENTDRIVER_ID']."'";
        $query_updatedata  = sqlsrv_query($conn, $sql_updatedata, $params_updatedata);
        $result_updatedata = sqlsrv_fetch_array($query_updatedata, SQLSRV_FETCH_ASSOC);  
    }  

}
if ($_POST['txt_flg'] == "update_dateworking_bydriver") {

      
    $sql = "UPDATE VEHICLETRANSPORTPLAN
    SET DATEWORKING ='".$_POST['dateworking']."',DATERK ='".$_POST['dateworking']."',DATEVLIN ='".$_POST['datevlin']."'
    WHERE VEHICLETRANSPORTPLANID ='".$_POST['vehicletransportplanid']."'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);

   
  
  // echo $result['TIMEREST'];
  
}
if ($_POST['txt_flg'] == "update_thainame_bydriver") {

      
    $sql_seVehicleregisnumber = "SELECT VEHICLEREGISNUMBER FROM VEHICLEINFO WHERE THAINAME ='".$_POST['thainame']."'";
    $query_seVehicleregisnumber  = sqlsrv_query($conn, $sql_seVehicleregisnumber, $params_seVehicleregisnumber);
    $result_seVehicleregisnumber = sqlsrv_fetch_array($query_seVehicleregisnumber, SQLSRV_FETCH_ASSOC);

    $sql_UpdatePlan = "UPDATE VEHICLETRANSPORTPLAN
    SET THAINAME ='".$_POST['thainame']."',VEHICLEREGISNUMBER1 ='".$result_seVehicleregisnumber['VEHICLEREGISNUMBER']."'
    WHERE VEHICLETRANSPORTPLANID ='".$_POST['vehicletransportplanid']."'";
    $query_UpdatePlan = sqlsrv_query($conn, $sql_UpdatePlan, $params_UpdatePlan);
    $result_UpdatePlan = sqlsrv_fetch_array($query_UpdatePlan, SQLSRV_FETCH_ASSOC);
  
    $sql_UpdateDOtable = "UPDATE VEHICLETRANSPORTDOCUMENTDIRVER
    SET VEHICLEREGISNUMBER ='".$result_seVehicleregisnumber['VEHICLEREGISNUMBER']."'
    WHERE VEHICLETRANSPORTPLANID ='".$_POST['vehicletransportplanid']."'";
    $query_UpdateDOtable = sqlsrv_query($conn, $sql_UpdateDOtable, $params_UpdateDOtable);
    $result_UpdateDOtable = sqlsrv_fetch_array($query_UpdateDOtable, SQLSRV_FETCH_ASSOC);

//   echo $result_seVehicleregisnumber['VEHICLEREGISNUMBER'];
  
}
if ($_POST['txt_flg'] == "update_selfcheckfromtenko") {

    if ($_POST['checkfeild'] == 'SLEEPREST') {
        // echo "1";
        //checkfeild = 'SLEEPREST' จะอัพเดทเวลาเลิกงาน, วันที่เวลาเริ่มปฏิบัติงาน, ระยะเวลาที่พักผ่อน
        $sql_updateselfcheck = "UPDATE DRIVERSELFCHECK 
            SET SLEEPRESTSTART ='" . $_POST['startsleep'] . "',SLEEPRESTEND ='" . $_POST['endsleep'] . "',TIMESLEEPREST='" . $_POST['timesleep'] . "'
            WHERE SELFCHECKID ='" . $_POST['selfcheckid'] . "'";
        $query_updateselfcheck  = sqlsrv_query($conn, $sql_updateselfcheck, $params_updateselfcheck);
        $result_updateselfcheck = sqlsrv_fetch_array($query_updateselfcheck, SQLSRV_FETCH_ASSOC);    
        
        // echo "complete sleeprest";    
    }else if ($_POST['checkfeild'] == 'SLEEPNORMAL') {
        $sql_updateselfcheck = "UPDATE DRIVERSELFCHECK 
            SET SLEEPNORMALSTART ='" . $_POST['startsleep'] . "',SLEEPNORMALEND ='" . $_POST['endsleep'] . "',TIMESLEEPNORMAL='" . $_POST['timesleep'] . "'
            WHERE SELFCHECKID ='" . $_POST['selfcheckid'] . "'";
        $query_updateselfcheck  = sqlsrv_query($conn, $sql_updateselfcheck, $params_updateselfcheck);
        $result_updateselfcheck = sqlsrv_fetch_array($query_updateselfcheck, SQLSRV_FETCH_ASSOC);  
        // echo "complete sleepnormal";
    }else{
        $sql_updateselfcheck = "UPDATE DRIVERSELFCHECK 
            SET SLEEPEXTRASTART ='" . $_POST['startsleep'] . "',SLEEPEXTRAEND ='" . $_POST['endsleep'] . "',TIMESLEEPEXTRA='" . $_POST['timesleep'] . "'
            WHERE SELFCHECKID ='" . $_POST['selfcheckid'] . "'";
        $query_updateselfcheck  = sqlsrv_query($conn, $sql_updateselfcheck, $params_updateselfcheck);
        $result_updateselfcheck = sqlsrv_fetch_array($query_updateselfcheck, SQLSRV_FETCH_ASSOC);  
        // echo "complete sleepextra";
    }

    
    
    
}
if ($_POST['txt_flg'] == "save_tenkobeforeofficer") {

        $sql_updatetenkoofficerdata = "UPDATE TENKOBEFORE 
        SET TENKOTEMPERATUREDATA ='" . $_POST['tempval'] . "',TENKOPRESSUREDATA_90160 ='" . $_POST['sysval'] . "',
        TENKOPRESSUREDATA_60100 ='" . $_POST['diaval'] . "',TENKOPRESSUREDATA_60110 ='" . $_POST['pulseval'] . "',
        TENKOALCOHOLDATA = '" . $_POST['alcoholval'] . "',TENKOOXYGENDATA = '" . $_POST['oxygenval'] . "'
        WHERE TENKOMASTERID ='" . $_POST['tenkomasterid'] . "'
        AND TENKOBEFOREID ='" . $_POST['tenkobeforeid'] . "'
        AND TENKOMASTERDIRVERCODE ='" . $_POST['employeecode'] . "'";
        $query_updatetenkoofficerdata  = sqlsrv_query($conn, $sql_updatetenkoofficerdata, $params_updatetenkoofficerdata);
        $result_updatetenkoofficerdata = sqlsrv_fetch_array($query_updatetenkoofficerdata, SQLSRV_FETCH_ASSOC);    
    
    //   echo "complete !!!";
}
if ($_POST['txt_flg'] == "save_copyjobvehicletransportplan_newrccratc") {
  $rs = save_copyjobvehicletransportplan_newrccratc(
  'save_copyjobvehicletransportplan_newrccratc', $_POST['JOBNO'], $_POST['ROWSAMOUNT']);
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
if ($_POST['txt_flg'] == "delete_labotrondata") {

        $sql_deletelabotrondata = "DELETE LABOTRONWEBSERVICEDATA WHERE LABOTRONDATAID = '" . $_POST['labotrondataid'] . "'";
        $query_deletelabotrondata = sqlsrv_query($conn, $sql_deletelabotrondata, $params_deletelabotrondata);
        $result_deletelabotrondata =  sqlsrv_fetch_array($query_deletelabotrondata, SQLSRV_FETCH_ASSOC);    
    
    //   echo "complete !!!";
}
if ($_POST['txt_flg'] == "select_smarthealth_use") {
  ?>

    <?php
        $i = 1;
        $sql_seAmt = "SELECT COUNT(DISTINCT b.PersonCode) AS 'COUT_AMT'                                                                                                                                 FROM LABOTRONWEBSERVICEDATA a 
                    INNER JOIN EMPLOYEEEHR2 b ON b.TaxID = a.CREATEBY
                    WHERE CONVERT(DATE,CREATEDATE) BETWEEN CONVERT(DATE,'".$_POST['datestart']."',103) AND CONVERT(DATE,'".$_POST['dateend']."',103)
                    --WHERE CARDNUMBER IN ('5320890008815','1639900241323')
                    AND SUBSTRING(b.PersonCode, 1, 2) IN ('01','02','07','08')
                    AND (PositionNameE ='Driver' OR PositionNameT IN('Controller','Dispatcher'))";
        $params_seAmt = array();
        $query_seAmt  = sqlsrv_query($conn, $sql_seAmt, $params_seAmt);
        $result_seAmt = sqlsrv_fetch_array($query_seAmt, SQLSRV_FETCH_ASSOC);


        $sql_seGw = "SELECT COUNT(DISTINCT b.PersonCode) AS 'COUT_GW'                                                                                                                                                        
                FROM LABOTRONWEBSERVICEDATA a 
                INNER JOIN EMPLOYEEEHR2 b ON b.TaxID = a.CREATEBY
                WHERE CONVERT(DATE,CREATEDATE) BETWEEN CONVERT(DATE,'".$_POST['datestart']."',103) AND CONVERT(DATE,'".$_POST['dateend']."',103)
                --WHERE CARDNUMBER IN ('5320890008815','1639900241323')
                AND SUBSTRING(b.PersonCode, 1, 2) IN ('04','05','09','08')
                AND (PositionNameE ='Driver' OR PositionNameT IN('Controller','Dispatcher'))";
        $params_seGw = array();
        $query_seGw  = sqlsrv_query($conn, $sql_seGw, $params_seGw);
        $result_seGw = sqlsrv_fetch_array($query_seGw, SQLSRV_FETCH_ASSOC);
    ?>

    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
        <thead>
            <tr>
                <th style="width:50%;text-align:center;font-size: 20px;">พื้นที่ AMT1</th>
                <th style="width:50%;text-align:center;font-size: 20px;">พื้นที่ GW1</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align:center;vertical-align: center;font-size: 100px;"><b><?= $result_seAmt['COUT_AMT']?></b></td>
                <td style="text-align:center;vertical-align: center;font-size: 100px;"><b><?= $result_seGw['COUT_GW']?></b></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td style="text-align:center;font-size: 20px;" colspan ="2">ข้อมูลวันที่: <?=$_POST['datestart']?> - <?=$_POST['dateend']?></td>
            </tr>
        </tfoot>

    </table> 

  <?php
}
if ($_POST['txt_flg'] == "select_invoice_rrcdetail") {
  ?>

    <table style="" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example_rrcttast_detail" role="grid" aria-describedby="dataTables-example_info" >
        <thead>
            <tr>
                <th style="text-align: center">ลำดับ</th>
                <th style="text-align: center;width:60px">วันที่</th>
                <th style="text-align: center">ทะเบียนรถ</th>
                <th style="text-align: center">พนักงาน</th>
                <th style="text-align: center">จาก</th>
                <th style="text-align: center">ถึง</th>
                <th style="text-align: center">จำนวนแพ็ค</th>
                <th style="text-align: center">น้ำหนักรวม</th>
                <th style="text-align: center">หมายเลข DO.1</th>
                <th style="text-align: center">หมายเลข DO.2</th>
                <th style="text-align: center">หมายเลข DO.3</th>
                <th style="text-align: center">หมายเลข DO.4</th>
                <th style="text-align: center">หมายเลข DO.5</th>
                <th style="text-align: center">หมายเลข DO.6</th>
                <th style="text-align: center">หมายเลข DO.7</th>
                <th style="text-align: center">หมายเลข DO.8</th>
                <th style="text-align: center">จำนวนเงิน</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            // $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)";
            // $condBilling2 = " AND b.COMPANYCODE = '" . $_POST['companycode'] . "' AND b.CUSTOMERCODE = '" . $_POST['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

            $sql_seBilling = "SELECT 
            SS.VEHICLETRANSPORTPLANID,REPLACE(CONVERT(NVARCHAR(6),CONVERT(DATE,SS.DATEWORKING,103),3)+''+RIGHT(CONVERT(NVARCHAR(4),CONVERT(DATE,SS.DATEWORKING,103))+543,4),'/','-') AS 'DATE',
            SS.VEHICLEREGISNUMBER1,SS.EMPLOYEENAME1,SS.JOBSTART,SS.JOBEND,SS.ACTUALPRICE,SS.C8,
            STUFF((SELECT ',' + US.DOCUMENTCODE 
                   FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] US
                   WHERE US.VEHICLETRANSPORTPLANID = SS.VEHICLETRANSPORTPLANID
                   ORDER BY US.DOCUMENTCODE ASC
                   FOR XML PATH('')), 1, 1, '') [DOCUMENTCODE_CHK]

            FROM VEHICLETRANSPORTPLAN SS
            INNER JOIN [VEHICLETRANSPORTDOCUMENTDIRVER] A ON A.VEHICLETRANSPORTPLANID = SS.VEHICLETRANSPORTPLANID
            WHERE SS.COMPANYCODE ='".$_POST['companycode']."' AND SS.CUSTOMERCODE ='".$_POST['customercode']."'
            AND CONVERT(DATE,SS.DATEWORKING) BETWEEN CONVERT(DATE,'".$_POST['datestart']."',103) AND CONVERT(DATE,'".$_POST['dateend']."',103)
            AND (SS.DOCUMENTCODE !='' OR SS.DOCUMENTCODE IS NOT NULL)  
            GROUP BY SS.VEHICLETRANSPORTPLANID,CONVERT(DATE,SS.DATEWORKING,103),SS.VEHICLEREGISNUMBER1,SS.EMPLOYEENAME1,SS.JOBSTART,SS.JOBEND,SS.ACTUALPRICE,SS.C8
            ORDER BY SS.JOBEND,CONVERT(DATE,SS.DATEWORKING,103),SS.JOBSTART,1 ASC";
            $params_seBilling = array();


            $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
            while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

            $employeename  = $result_seBilling['EMPLOYEENAME1'];
            $employeenamesplit = explode(" ", $employeename);

            $documentcode = $result_seBilling['DOCUMENTCODE_CHK'];
            $documentcodesplit = explode(",", $documentcode);
            
            if ($result_seBilling['C8'] == 'return') {
                $DO1 = 'งานรับกลับ';
                $DO2 = '';
                $DO3 = '';
                $DO4 = '';
                $DO5 = '';
                $DO6 = '';
                $DO7 = '';
                $DO8 = '';
            }else {
                $DO1 = $documentcodesplit[0];
                $DO2 = $documentcodesplit[1];
                $DO3 = $documentcodesplit[2];
                $DO4 = $documentcodesplit[3];
                $DO5 = $documentcodesplit[4];
                $DO6 = $documentcodesplit[5];
                $DO7 = $documentcodesplit[6];
                $DO8 = $documentcodesplit[7];
            }


            $sql_seSumData = "SELECT SUM(CONVERT(INT,WEIGHTIN)) AS 'WEIGHT',SUM(CONVERT(INT,TRIPAMOUNT)) AS 'AMOUNT' 
                FROM VEHICLETRANSPORTDOCUMENTDIRVER 
                WHERE VEHICLETRANSPORTPLANID ='".$result_seBilling['VEHICLETRANSPORTPLANID']."'";
            $params_seSumData = array();
            $query_seSumData  = sqlsrv_query($conn, $sql_seSumData, $params_seSumData);
            $result_seSumData = sqlsrv_fetch_array($query_seSumData, SQLSRV_FETCH_ASSOC);

            // $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
            // $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
            // $params_seEmployeeehr = array(
            // array('select_employeeehr2', SQLSRV_PARAM_IN),
            // array($condEmployeeehr1, SQLSRV_PARAM_IN)
            // );
            // $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
            // $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);

            ?>
                <tr>
                    <td style="text-align: center"><?= $i ?></td>
                    <td style="text-align: center"><?= $result_seBilling['DATE'] ?></td>
                    <td><?= $result_seBilling['VEHICLEREGISNUMBER1'] ?></td>
                    <td><?= $employeenamesplit[0] ?></td>
                    <td><?= $result_seBilling['JOBSTART'] ?></td>
                    <td><?= $result_seBilling['JOBEND'] ?></td>
                    <td><?= $result_seSumData['WEIGHT'] ?></td>
                    <td><?= $result_seSumData['AMOUNT'] ?></td>
                    <td><?= $DO1 ?></td>
                    <td><?= $DO2 ?></td>
                    <td><?= $DO3 ?></td>
                    <td><?= $DO4 ?></td>
                    <td><?= $DO5 ?></td>
                    <td><?= $DO6 ?></td>
                    <td><?= $DO7 ?></td>
                    <td><?= $DO8 ?></td>
                    <td><?= $result_seBilling['ACTUALPRICE'] ?></td>


                </tr>
            <?php
                $i++;
            }
            ?>
        </tbody>
    </table> 

  <?php
}
if ($_POST['txt_flg'] == "select_invoice_rrcsummary") {
  ?>

    <table style="width: 100%;" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example_rrcttast_summary" role="grid" aria-describedby="dataTables-example_info" >
        <thead>
            <tr>
                <th style="text-align: center">วันที่ใบแจ้งหนี้</th>
                <th style="text-align: center">หมายเลขบัญชี</th>
                <th style="text-align: center">ใบแจ้งหนี้</th>
                <th style="text-align: center">จาก</th>
                <th style="text-align: center">ถึง</th>
                <th style="text-align: center">หน่วยละ</th>
                <th style="text-align: center">Sum of QT.</th>
                <th style="text-align: center">Sum of <br>จำนวนแพ็ค/เที่ยว</th>
                <th style="text-align: center">Sum of <br>น้ำหนักรวม/เที่ยว</th>
                <th style="text-align: center">Sum of <br>จำนวนเงิน(บาท)</th>
                <th style="text-align: center">Remark</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            // $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)";
            // $condBilling2 = " AND b.COMPANYCODE = '" . $_POST['companycode'] . "' AND b.CUSTOMERCODE = '" . $_POST['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

            $sql_seBilling = "SELECT DISTINCT JOBSTART,JOBEND,b.PRICE AS 'ACTUALPRICE' FROM VEHICLETRANSPORTPLAN a
            INNER JOIN VEHICLETRANSPORTPRICE b ON b.VEHICLETRANSPORTPRICEID = a.VEHICLETRANSPORTPRICEID
            WHERE a.COMPANYCODE ='RRC' AND a.CUSTOMERCODE ='TTAST' 
            AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_POST['datestart']."',103) AND CONVERT(DATE,'".$_POST['dateend']."',103)
            ORDER BY JOBSTART,JOBEND ASC";
            $params_seBilling = array();
            $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
            while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {


            $sql_seSumData = "SELECT SUM(CONVERT(INT,WEIGHTIN)) AS 'WEIGHT',SUM(CONVERT(INT,b.TRIPAMOUNT)) AS 'AMOUNT'
                FROM VEHICLETRANSPORTPLAN a
                INNER JOIN VEHICLETRANSPORTDOCUMENTDIRVER b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
                WHERE a.COMPANYCODE ='RRC' AND a.CUSTOMERCODE ='TTAST' 
                AND a.JOBSTART ='".$result_seBilling['JOBSTART']."'
                AND a.JOBEND ='".$result_seBilling['JOBEND']."'
                AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'".$_POST['datestart']."',103) AND CONVERT(DATE,'".$_POST['dateend']."',103)";
            $params_seSumData = array();
            $query_seSumData  = sqlsrv_query($conn, $sql_seSumData, $params_seSumData);
            $result_seSumData = sqlsrv_fetch_array($query_seSumData, SQLSRV_FETCH_ASSOC);

            $sql_seSumTripData = "SELECT COUNT(VEHICLETRANSPORTPLANID) AS 'COUNT_PLAN'
                FROM VEHICLETRANSPORTPLAN 
                WHERE COMPANYCODE ='RRC' AND CUSTOMERCODE ='TTAST' 
                AND JOBSTART ='".$result_seBilling['JOBSTART']."'
                AND JOBEND ='".$result_seBilling['JOBEND']."'
                AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_POST['datestart']."',103) AND CONVERT(DATE,'".$_POST['dateend']."',103)";
            $params_seSumTripData = array();
            $query_seSumTripData  = sqlsrv_query($conn, $sql_seSumTripData, $params_seSumTripData);
            $result_seSumTripData = sqlsrv_fetch_array($query_seSumTripData, SQLSRV_FETCH_ASSOC);


            // $employeename  = $result_seBilling['EMPLOYEENAME1'];
            // $employeenamesplit = explode(" ", $employeename);

            // $documentcode = $result_seBilling['DOCUMENTCODE_CHK'];
            // $documentcodesplit = explode(",", $documentcode);
            
            if ($result_seBilling['JOBSTART'] == 'TTAST' && ($result_seBilling['JOBEND'] == 'TTAST' || $result_seBilling['JOBEND'] == 'Move Coil')) {
                $SUMOFPRICE = $result_seBilling['ACTUALPRICE'];
                $REMARK = 'เหมาจ่าย';
            }else if($result_seBilling['JOBSTART'] == 'TTAST' && $result_seBilling['JOBEND'] == 'G-TEC (Zanzai)' ){
                $SUMOFPRICE = ($result_seBilling['ACTUALPRICE']*$result_seSumTripData['COUNT_PLAN']);
                $REMARK = '10 W';
            }else if($result_seBilling['JOBSTART'] != 'TTAST'){
                $SUMOFPRICE = ($result_seBilling['ACTUALPRICE']*$result_seSumTripData['COUNT_PLAN']);
                $REMARK = 'งานรับกลับ';
            }else {
                $SUMOFPRICE = ($result_seBilling['ACTUALPRICE']*$result_seSumTripData['COUNT_PLAN']);
                $REMARK = '';
            }


            // $sql_seSumData = "SELECT SUM(CONVERT(INT,WEIGHTIN)) AS 'WEIGHT',SUM(CONVERT(INT,TRIPAMOUNT)) AS 'AMOUNT' 
            //     FROM VEHICLETRANSPORTDOCUMENTDIRVER 
            //     WHERE VEHICLETRANSPORTPLANID ='".$result_seBilling['VEHICLETRANSPORTPLANID']."'";
            // $params_seSumData = array();
            // $query_seSumData  = sqlsrv_query($conn, $sql_seSumData, $params_seSumData);
            // $result_seSumData = sqlsrv_fetch_array($query_seSumData, SQLSRV_FETCH_ASSOC);

            // $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
            // $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
            // $params_seEmployeeehr = array(
            // array('select_employeeehr2', SQLSRV_PARAM_IN),
            // array($condEmployeeehr1, SQLSRV_PARAM_IN)
            // );
            // $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
            // $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);

            ?>
                <tr>
                    <td style="text-align: center"></td>
                    <td style="text-align: center"></td>
                    <td></td>
                    <td><?= $result_seBilling['JOBSTART'] ?></td>
                    <td><?= $result_seBilling['JOBEND'] ?></td>
                    <td><?= number_format($result_seBilling['ACTUALPRICE']) ?></td>
                    <td><?= $result_seSumTripData['COUNT_PLAN'] ?></td>
                    <td><?= $result_seSumData['AMOUNT'] ?></td>
                    <td><?= number_format($result_seSumData['WEIGHT']) ?></td>
                    <td><?= number_format($SUMOFPRICE) ?></td>
                    <td><?= $REMARK ?></td>
                </tr>
            <?php
                $i++;
            }
            ?>
        </tbody>
    </table> 

  <?php
}
if ($_POST['txt_flg'] == "approve_planamt") {

    
    $sql_ApprovePlan = "{call megApprovePlan(?,?,?,?)}";
    $params_ApprovePlan = array(
    array('approve_planamt', SQLSRV_PARAM_IN),
    array($_POST['planid'], SQLSRV_PARAM_IN),
    array($_POST['approveby'], SQLSRV_PARAM_IN),
    array($_POST['status'], SQLSRV_PARAM_IN)
    );

    $query_ApprovePlan   = sqlsrv_query($conn, $sql_ApprovePlan, $params_ApprovePlan);
    $result_ApprovePlan  = sqlsrv_fetch_array($query_ApprovePlan, SQLSRV_FETCH_ASSOC);

    // echo "1";
    // $sql_updatePlandata = "UPDATE TENKOBEFORE
    //     SET ACTUALTENKOBY = '" . $_POST['actualtenkoby'] . "' ,ACTUALTENKODATE = GETDATE()
        
    //     WHERE TENKOMASTERID ='" . $_POST['tenkomasterid'] . "'
    //     AND TENKOBEFOREID ='" . $_POST['tenkobeforeid'] . "'";
    // $query_updatePlandata  = sqlsrv_query($conn, $sql_updatePlandata, $params_updatePlandata);
    // $result_updatePlandata = sqlsrv_fetch_array($query_updatePlandata, SQLSRV_FETCH_ASSOC);    
    
    //   echo $result['TIMEREST'];
    
}
if ($_POST['txt_flg'] == "disapprove_planamt") {

    
    $sql_DisApprovePlan = "{call megApprovePlan(?,?,?,?)}";
    $params_DisApprovePlan = array(
    array('disapprove_planamt', SQLSRV_PARAM_IN),
    array($_POST['planid'], SQLSRV_PARAM_IN),
    array($_POST['disapproveby'], SQLSRV_PARAM_IN),
    array($_POST['status'], SQLSRV_PARAM_IN)
    );

    $query_DisApprovePlan   = sqlsrv_query($conn, $sql_DisApprovePlan, $params_DisApprovePlan);
    $result_DisApprovePlan  = sqlsrv_fetch_array($query_DisApprovePlan, SQLSRV_FETCH_ASSOC);

    // echo "1";
    // $sql_updatePlandata = "UPDATE TENKOBEFORE
    //     SET ACTUALTENKOBY = '" . $_POST['actualtenkoby'] . "' ,ACTUALTENKODATE = GETDATE()
        
    //     WHERE TENKOMASTERID ='" . $_POST['tenkomasterid'] . "'
    //     AND TENKOBEFOREID ='" . $_POST['tenkobeforeid'] . "'";
    // $query_updatePlandata  = sqlsrv_query($conn, $sql_updatePlandata, $params_updatePlandata);
    // $result_updatePlandata = sqlsrv_fetch_array($query_updatePlandata, SQLSRV_FETCH_ASSOC);    
    
    //   echo $result['TIMEREST'];
    
}
if ($_POST['txt_flg'] == "save_materialtype") {

    $sql_InsertMaterialtype = "{call megStatus_v2(?,?)}";
    $params_InsertMaterialtype = array(
    array('save_materialtype', SQLSRV_PARAM_IN),
    array($_POST['materialtype'], SQLSRV_PARAM_IN),
    );

    $query_InsertMaterialtype   = sqlsrv_query($conn, $sql_InsertMaterialtype, $params_InsertMaterialtype);
    $result_InsertMaterialtype  = sqlsrv_fetch_array($query_InsertMaterialtype, SQLSRV_FETCH_ASSOC);
    
}
if ($_POST['txt_flg'] == "delete_materialtype") {

    $sql_DeleteMaterialtype = "{call megStatus_v2(?,?)}";
    $params_DeleteMaterialtype = array(
    array('delete_materialtype', SQLSRV_PARAM_IN),
    array($_POST['id'], SQLSRV_PARAM_IN),
    );

    $query_DeleteMaterialtype   = sqlsrv_query($conn, $sql_DeleteMaterialtype, $params_DeleteMaterialtype);
    $result_DeleteMaterialtype  = sqlsrv_fetch_array($query_DeleteMaterialtype, SQLSRV_FETCH_ASSOC);
    
}
if ($_POST['txt_flg'] == "Addtransportpricemaster_skb") {

    $sql = "{call megVehicletransportpricemaster_v2(?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array('save_vehicletransportpricemaster', SQLSRV_PARAM_IN),
        array($_POST['condition1'], SQLSRV_PARAM_IN),
        array($_POST['condition2'], SQLSRV_PARAM_IN),
        array($_POST['condition3'], SQLSRV_PARAM_IN),
        array($_POST['vehicledesccode'], SQLSRV_PARAM_IN),
        array($_POST['worktype'], SQLSRV_PARAM_IN),
        array($_POST['companycode'], SQLSRV_PARAM_IN),
        array($_POST['customercode'], SQLSRV_PARAM_IN),
        array($_POST['activestatus'], SQLSRV_PARAM_IN),
        array($_POST['data1'], SQLSRV_PARAM_IN),
        array($_POST['data2'], SQLSRV_PARAM_IN),
        array($_POST['data3'], SQLSRV_PARAM_IN),
        array($_POST['data4'], SQLSRV_PARAM_IN),
        array($_POST['data5'], SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
    
}
?>




<?php if ($_POST['txt_flg'] == "select_joboil") { 
    $conditionEHR = " AND a.PersonID ='" . $_SESSION["EMPLOYEEID"] . "'";
    $sql_seEHR = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEHR = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($conditionEHR, SQLSRV_PARAM_IN)
    );
    $query_seEHR = sqlsrv_query($conn, $sql_seEHR, $params_seEHR);
    $result_seEHR = sqlsrv_fetch_array($query_seEHR, SQLSRV_FETCH_ASSOC);
                                                 
    date_default_timezone_set('Asia/Bangkok');
    $datestartoil=$_POST['datestartoil'];
    $dateendoil=$_POST['dateendoil'];
    // echo $datestartoil;
    // ECHO "<br>";
    // echo $dateendoil;
    // ECHO "<br>";
    $DATESTART = str_replace('/', '-', $datestartoil);
    $CONVERTDATESTART = date("Y-m-d", strtotime($DATESTART) );
    // ECHO "<br>";
    $DATEEND = str_replace('/', '-', $dateendoil);
    $CONVERTDATEEND = date("Y-m-d", strtotime($DATEEND) );

    $EHR_PHC = $result_seEHR['PersonCode'];
        
    $stmt_chkjob = "SELECT 
        OILT.OILDATAID OILTID,
        CHKPLCAR.VEHICLETRANSPORTPLANID VHCTPPID,
        CHKPLCAR.JOBNO JOBNOPLAN,
        OILT.JOBNO OILTJN,
        OILT.VEHICLEREGISNUMBER VHCRGNB,
        CHKIFCAR.THAINAME,
        OILT.VEHICLETYPE OILTTE,
        CHKPLCAR.EMPLOYEECODE1,
        OILT.MILEAGESTART,
        OILT.MILEAGEEND,
        OILT.OIL_AMOUNT,
        OILT.OIL_BILLNUMBER,
        CONVERT (VARCHAR (10),OILT.REFUELINGDATE,20) OILTDWK,
        CONVERT (VARCHAR (16),OILT.REFUELINGDATE,29) RFD
    FROM RTMS.dbo.VEHICLETRANSPORTPLAN CHKPLCAR
    LEFT JOIN RTMS.dbo.VEHICLEINFO CHKIFCAR ON (CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.VEHICLEREGISNUMBER1 OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.VEHICLEREGISNUMBER2 OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.THAINAME OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.THAINAME2)
    LEFT JOIN RTMS.dbo.VEHICLETYPE CHKTYCAR ON CHKTYCAR.VEHICLETYPECODE = CHKIFCAR.VEHICLETYPECODE
    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OILT ON (CHKPLCAR.JOBNO = OILT.JOBNO COLLATE Thai_CI_AI)
    WHERE (CHKPLCAR.EMPLOYEECODE1 = '$EHR_PHC' OR CHKPLCAR.EMPLOYEECODE2 = '$EHR_PHC')
    AND CONVERT (VARCHAR (10),CHKPLCAR.DATEWORKING,20) BETWEEN '$CONVERTDATESTART' AND '$CONVERTDATEEND'
    AND OILT.JOBNO IS NOT NULL
    ORDER BY CHKPLCAR.JOBNO ASC";
    $query_chkjob = sqlsrv_query($conn, $stmt_chkjob);
    $result = sqlsrv_fetch_array($query_chkjob);
    $data1 = $result["JOBNOPLAN"];
    $data2 = $result["OILTJN"];
    // echo $data1;
    // echo "<br>";
    // echo $data2;

?>
    <table  style="height:70px;width:100px" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-oiltat" role="grid" aria-describedby="dataTables-example_info" >
        <thead>
            <tr role="row">
                <th style="text-align:center;width:100px">จัดการ</th>
                <th style="text-align:center;width:100px">สถานะข้อมูล</th>
                <th style="text-align:center;width:200px">เลข Job จากแผน</th>
                <th style="text-align:center;width:200px">คีย์เลข Job จากเติมน้ำมัน</th>
                <th style="text-align:center;width:100px">เลขใบกำกับน้ำมัน</th>
                <th style="text-align:center;width:100px">ทะเบียนรถ</th>
                <th style="text-align:center;width:100px">ชื่อรถ</th>
                <th style="text-align:center;width:100px">ประเภทรถ</th>
                <th style="text-align:center;width:100px">เลขไมล์ต้น</th>
                <th style="text-align:center;width:100px">เลขไมล์ปลาย</th>
                <th style="text-align:center;width:100px">ระยะทาง</th>
                <th style="text-align:center;width:100px">จำนวนน้ำมัน(ลิตร)</th>
                <th style="text-align:center;width:100px">วันที่เติมน้ำมัน</th>
            </tr>
        </thead>
        <tbody>
            <?php       
                $stmt_oildataresult = "SELECT 
                    OILT.OILDATAID OILTID,
                    CHKPLCAR.VEHICLETRANSPORTPLANID VHCTPPID,
                    CHKPLCAR.JOBNO JOBNOPLAN,
                    OILT.JOBNO OILTJN,
                    OILT.VEHICLEREGISNUMBER VHCRGNB,
                    CHKIFCAR.THAINAME,
                    OILT.VEHICLETYPE OILTTE,
                    CHKPLCAR.EMPLOYEECODE1,
                    OILT.MILEAGESTART,
                    OILT.MILEAGEEND,
                    OILT.OIL_AMOUNT,
                    OILT.OIL_BILLNUMBER,
                    CONVERT (VARCHAR (10),OILT.REFUELINGDATE,20) OILTDWK,
                    CONVERT (VARCHAR (16),OILT.REFUELINGDATE,29) RFD
                FROM RTMS.dbo.VEHICLETRANSPORTPLAN CHKPLCAR
                -- LEFT JOIN RTMS.dbo.VEHICLEINFO CHKIFCAR ON (CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.VEHICLEREGISNUMBER1 OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.VEHICLEREGISNUMBER2 OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.THAINAME OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.THAINAME2)
                -- LEFT JOIN RTMS.dbo.VEHICLETYPE CHKTYCAR ON CHKTYCAR.VEHICLETYPECODE = CHKIFCAR.VEHICLETYPECODE
                LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OILT ON (CHKPLCAR.JOBNO = OILT.JOBNO COLLATE Thai_CI_AI)
                LEFT JOIN RTMS.dbo.VEHICLEINFO CHKIFCAR ON CHKIFCAR.VEHICLEREGISNUMBER = OILT.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                LEFT JOIN RTMS.dbo.VEHICLETYPE CHKTYCAR ON CHKTYCAR.VEHICLETYPECODE = CHKIFCAR.VEHICLETYPECODE 
                WHERE (CHKPLCAR.EMPLOYEECODE1 = '$EHR_PHC' OR CHKPLCAR.EMPLOYEECODE2 = '$EHR_PHC')
                AND CONVERT (VARCHAR (10),CHKPLCAR.DATEWORKING,20) BETWEEN '$CONVERTDATESTART' AND '$CONVERTDATEEND'
                ORDER BY CHKPLCAR.JOBNO ASC";
                $query_oildataresult = sqlsrv_query($conn, $stmt_oildataresult);
                while($result_oildataresult = sqlsrv_fetch_array($query_oildataresult, SQLSRV_FETCH_ASSOC)) {
                    $OILTID = $result_oildataresult["OILTID"];
                    $JOBNOPLAN = $result_oildataresult["JOBNOPLAN"];
                    $OILTJN = $result_oildataresult["OILTJN"];
                    $VHCRGNB = $result_oildataresult["VHCRGNB"];
                    $THAINAME = $result_oildataresult["THAINAME"];
                    $OILTTE = $result_oildataresult["OILTTE"];
                    $MLST = $result_oildataresult["MILEAGESTART"];
                    $MLED = $result_oildataresult["MILEAGEEND"];
                    $DTE = $MLED-$MLST;
                    $OBNB = $result_oildataresult["OIL_BILLNUMBER"];
                    $OAM = $result_oildataresult["OIL_AMOUNT"];
                    $OILTATDWK = $result_oildataresult["OILTATDWK"];
                    $RFD = $result_oildataresult["RFD"];

                    $stmt_rsbill = "SELECT 
                        COUNT(OIL_BILLNUMBER) AS CHKCOUNT,
                        CHKPLCAR.JOBNO JOBNOPLAN,
                        OILT.JOBNO OILTJN,
                        OILT.OIL_BILLNUMBER
                    FROM RTMS.dbo.VEHICLETRANSPORTPLAN CHKPLCAR
                    -- LEFT JOIN RTMS.dbo.VEHICLEINFO CHKIFCAR ON (CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.VEHICLEREGISNUMBER1 OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.VEHICLEREGISNUMBER2 OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.THAINAME OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.THAINAME2)
                    -- LEFT JOIN RTMS.dbo.VEHICLETYPE CHKTYCAR ON CHKTYCAR.VEHICLETYPECODE = CHKIFCAR.VEHICLETYPECODE
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OILT ON (CHKPLCAR.JOBNO = OILT.JOBNO COLLATE Thai_CI_AI)
                    LEFT JOIN RTMS.dbo.VEHICLEINFO CHKIFCAR ON CHKIFCAR.VEHICLEREGISNUMBER = OILT.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN RTMS.dbo.VEHICLETYPE CHKTYCAR ON CHKTYCAR.VEHICLETYPECODE = CHKIFCAR.VEHICLETYPECODE 
                    WHERE (CHKPLCAR.EMPLOYEECODE1 = '$EHR_PHC' OR CHKPLCAR.EMPLOYEECODE2 = '$EHR_PHC')
                    AND CONVERT (VARCHAR (10),CHKPLCAR.DATEWORKING,20) BETWEEN '$CONVERTDATESTART' AND '$CONVERTDATEEND'
                    AND OILT.JOBNO IS NOT NULL
                    GROUP BY
                        CHKPLCAR.JOBNO,
                        OILT.JOBNO,
                        OILT.OIL_BILLNUMBER
                    ORDER BY CHKPLCAR.JOBNO ASC";
                    $query_rsbill = sqlsrv_query($conn, $stmt_rsbill);
                    $result_rsbill = sqlsrv_fetch_array($query_rsbill);
                    $CHKCOUNT = $result_rsbill["CHKCOUNT"];
                    $RSBILL = $result_rsbill["OIL_BILLNUMBER"];
                    // echo $CHKCOUNT;

                    if($OILTID == ""){
                        $RSOILID="";
                    }else{
                        $RSOILID=$OILTID;
                    }
                    if($OILTJN == ""){
                        if($CHKCOUNT!=""){                                                                                                                    
                            // $CHKJN = '<b><font color="blue">ไม่มีข้อมูลการเติมน้ำมัน</font></b>';
                            // $RSJOBNO = "-";
                            // $RSJOBNO2= "";
                            $CHKJN = 'OK';
                            $RSJOBNO = '-';
                            $RSJOBNO2= "";
                            if($CHKJN=='OK'){
                                $bgcolor1='bgcolor="#D5F5E3"';
                                $bgcolor2='';
                                $bgcolor4='';
                            }
                        }else{
                            $RSJOBNO = '-';
                            $CHKJN = '<b><font color="blue">ไม่มีข้อมูลการเติมน้ำมัน</font></b>';
                        }
                    }else{
                        $CHKJN = 'OK';
                        $RSJOBNO = $OILTJN;
                        $RSJOBNO2=$OILTJN;
                        if($CHKJN=='OK'){
                            $bgcolor1='bgcolor="#D5F5E3"';
                        }
                    }
                    if($RSBILL!=""){
                        $bgcolor3='bgcolor="#D5F5E3"';
                    } 
                    if($JOBNOPLAN==$OILTJN){
                        $bgcolor2='bgcolor="#D5F5E3"';
                        $bgcolor4='bgcolor="#D5F5E3"';
                    }
                    if($VHCRGNB == ""){
                        $RSVHCRGNB="-";
                        $RSTHAINAME="-";
                        $RSOILTTE="-";
                    }else{
                        $RSVHCRGNB=$VHCRGNB;
                        $RSTHAINAME=$THAINAME;
                        $RSOILTTE=$OILTTE;
                    } 
                    if($MLST == ""){
                        $RSMLST="-";
                    }else{
                        $RSMLST=$MLST;
                    }
                    if($MLED == ""){
                        $RSMLED="-";
                    }else{
                        $RSMLED=$MLED;
                    }
                    if($DTE == "0"){
                        $RSDTE="-";
                    }else{
                        $RSDTE=$DTE;
                    }
                    if($OBNB == ""){
                        $RSOBNB=$RSBILL;
                    }else{
                        $RSOBNB=$OBNB;
                    }
                    if($OAM == ""){
                        $RSOAM="-";
                    }else{
                        $RSOAM=$OAM;
                    }
                    if($RFD == ""){
                        $RSRFD="-";
                    }else{
                        $RSRFD=$RFD;
                    }
            ?>       
            <tr class="gradeX odd" role="row">
                <td style="text-align: center;width: 100px;height: 55px">
                    <div class="btn-group">
                        <?php if($JOBNOPLAN==$RSJOBNO2){ ?>
                            <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-chevron-down"></i></button>
                            <ul class="dropdown-menu slidedown">
                                <li><a href="#" onclick="editdataoiltatsuno('<?=$RSOILID;?>','<?=$JOBNOPLAN;?>','<?=$RSJOBNO2;?>','<?=$OBNB;?>','<?=$MLST;?>','<?=$MLED;?>','<?=$OAM;?>','<?=$RFD;?>')" data-toggle="modal"  data-target="#modal_editdataoiltatsuno">แก้ไขข้อมูล</a></li>
                            </ul>                                                                                                                                   
                        <?php }else if(($JOBNOPLAN!=$RSJOBNO2) && ($OILTDWK!="")){   ?>        
                            <button type="button" class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-chevron-down"></i></button>
                            <ul class="dropdown-menu slidedown">
                                <li><a href="#" onclick="editdataoiltatsuno('<?=$RSOILID;?>','<?=$JOBNOPLAN;?>','<?=$RSJOBNO2;?>','<?=$OBNB;?>','<?=$MLST;?>','<?=$MLED;?>','<?=$OAM;?>','<?=$RFD;?>')" data-toggle="modal"  data-target="#modal_editdataoiltatsuno">แก้ไขข้อมูล</a></li>
                            </ul>  
                        <?php }else{  
                                $JOBOIL = $RSJOBNO2;
                                $JOBPLAN  = $JOBNOPLAN;
                                $POS = strpos($JOBOIL, $JOBPLAN);
                                if ($POS === false) { 
                        ?>
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-chevron-down"></i></button>
                            <ul class="dropdown-menu slidedown">
                                <li><a href="#" onclick="fineandeditdataoiltatsuno('<?=$JOBNOPLAN;?>')" data-toggle="modal"  data-target="#modal_editdataoiltatsuno">แก้ไขข้อมูล</a></li>
                            </ul> 
                        <?php } else { ?>
                            <button type="button" class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-chevron-down"></i></button>
                            <ul class="dropdown-menu slidedown">
                                <li><a href="#" onclick="editdataoiltatsuno('<?=$RSOILID;?>','<?=$JOBNOPLAN;?>','<?=$RSJOBNO2;?>','<?=$OBNB;?>','<?=$MLST;?>','<?=$MLED;?>','<?=$OAM;?>','<?=$RFD;?>')" data-toggle="modal"  data-target="#modal_editdataoiltatsuno">แก้ไขข้อมูล</a></li>
                            </ul>    
                        <?php } } ?>
                    </div>
                </td>
                <td style="text-align:center;width:100px" <?=$bgcolor1;?>><b><?=$CHKJN;?></b></td>
                <td style="text-align:center;width:200px" <?=$bgcolor4;?>><b><?=$JOBNOPLAN;?></b></td>
                <td style="text-align:center;width:200px" <?=$bgcolor2;?>><b><?=$RSJOBNO;?></b></td>
                <td style="text-align:center;width:100px" <?=$bgcolor3;?>><b><?=$RSOBNB;?></b></td>
                <td style="text-align:center;width:100px"><?=$RSVHCRGNB;?></td>
                <td style="text-align:center;width:100px"><?=$RSTHAINAME;?></td>
                <td style="text-align:center;width:100px"><?=$RSOILTTE;?></td>
                <td style="text-align:center;width:100px"><?=$RSMLST;?></td>
                <td style="text-align:center;width:100px"><?=$RSMLED;?></td>
                <td style="text-align:center;width:100px"><?=$RSDTE;?></td>
                <td style="text-align:center;width:100px"><?=$RSOAM;?></td>
                <td style="text-align:center;width:100px"><?=$RSRFD;?></td>
            </tr>       
            <?php } ?>
        </tbody>
    </table>
<?php } ?>
<?php if ($_POST['txt_flg'] == "select_joboil_admin") { 
    
    $EHR_PHC=$_POST['personcode'];

    $conditionEHR = " AND a.PersonCode ='" . $EHR_PHC . "'";
    $sql_seEHR = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEHR = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($conditionEHR, SQLSRV_PARAM_IN)
    );
    $query_seEHR = sqlsrv_query($conn, $sql_seEHR, $params_seEHR);
    $result_seEHR = sqlsrv_fetch_array($query_seEHR, SQLSRV_FETCH_ASSOC);
                                                 
    date_default_timezone_set('Asia/Bangkok');
    $datestartoil=$_POST['datestartoil'];
    $dateendoil=$_POST['dateendoil'];
    // echo $datestartoil;
    // ECHO "<br>";
    // echo $dateendoil;
    // ECHO "<br>";
    $DATESTART = str_replace('/', '-', $datestartoil);
    $CONVERTDATESTART = date("Y-m-d", strtotime($DATESTART) );
    // ECHO "<br>";
    $DATEEND = str_replace('/', '-', $dateendoil);
    $CONVERTDATEEND = date("Y-m-d", strtotime($DATEEND) );
        
    $stmt_chkjob = "SELECT 
        OILT.OILDATAID OILTID,
        CHKPLCAR.VEHICLETRANSPORTPLANID VHCTPPID,
        CHKPLCAR.JOBNO JOBNOPLAN,
        OILT.JOBNO OILTJN,
        OILT.VEHICLEREGISNUMBER VHCRGNB,
        CHKIFCAR.THAINAME,
        OILT.VEHICLETYPE OILTTE,
        CHKPLCAR.EMPLOYEECODE1,
        OILT.MILEAGESTART,
        OILT.MILEAGEEND,
        OILT.OIL_AMOUNT,
        OILT.OIL_BILLNUMBER,
        CONVERT (VARCHAR (10),OILT.REFUELINGDATE,20) OILTDWK,
        CONVERT (VARCHAR (16),OILT.REFUELINGDATE,29) RFD
    FROM RTMS.dbo.VEHICLETRANSPORTPLAN CHKPLCAR
    LEFT JOIN RTMS.dbo.VEHICLEINFO CHKIFCAR ON (CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.VEHICLEREGISNUMBER1 OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.VEHICLEREGISNUMBER2 OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.THAINAME OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.THAINAME2)
    LEFT JOIN RTMS.dbo.VEHICLETYPE CHKTYCAR ON CHKTYCAR.VEHICLETYPECODE = CHKIFCAR.VEHICLETYPECODE
    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OILT ON (CHKPLCAR.JOBNO = OILT.JOBNO COLLATE Thai_CI_AI)
    WHERE (CHKPLCAR.EMPLOYEECODE1 = '$EHR_PHC' OR CHKPLCAR.EMPLOYEECODE2 = '$EHR_PHC')
    AND CONVERT (VARCHAR (10),CHKPLCAR.DATEWORKING,20) BETWEEN '$CONVERTDATESTART' AND '$CONVERTDATEEND'
    AND OILT.JOBNO IS NOT NULL
    ORDER BY CHKPLCAR.JOBNO ASC";
    $query_chkjob = sqlsrv_query($conn, $stmt_chkjob);
    $result = sqlsrv_fetch_array($query_chkjob);
    $data1 = $result["JOBNOPLAN"];
    $data2 = $result["OILTJN"];
    // echo $data1;
    // echo "<br>";
    // echo $data2;

?>
    <table  style="height:70px;width:100px" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-oiltat" role="grid" aria-describedby="dataTables-example_info" >
        <thead>
            <tr role="row">
                <th style="text-align:center;width:100px">จัดการ</th>
                <th style="text-align:center;width:100px">สถานะข้อมูล</th>
                <th style="text-align:center;width:200px">เลข Job จากแผน</th>
                <th style="text-align:center;width:200px">คีย์เลข Job จากเติมน้ำมัน</th>
                <th style="text-align:center;width:100px">เลขใบกำกับน้ำมัน</th>
                <th style="text-align:center;width:100px">ทะเบียนรถ</th>
                <th style="text-align:center;width:100px">ชื่อรถ</th>
                <th style="text-align:center;width:100px">ประเภทรถ</th>
                <th style="text-align:center;width:100px">เลขไมล์ต้น</th>
                <th style="text-align:center;width:100px">เลขไมล์ปลาย</th>
                <th style="text-align:center;width:100px">ระยะทาง</th>
                <th style="text-align:center;width:100px">จำนวนน้ำมัน(ลิตร)</th>
                <th style="text-align:center;width:100px">วันที่เติมน้ำมัน</th>
            </tr>
        </thead>
        <tbody>
            <?php       
                $stmt_oildataresult = "SELECT 
                    OILT.OILDATAID OILTID,
                    CHKPLCAR.VEHICLETRANSPORTPLANID VHCTPPID,
                    CHKPLCAR.JOBNO JOBNOPLAN,
                    OILT.JOBNO OILTJN,
                    OILT.VEHICLEREGISNUMBER VHCRGNB,
                    CHKIFCAR.THAINAME,
                    OILT.VEHICLETYPE OILTTE,
                    CHKPLCAR.EMPLOYEECODE1,
                    OILT.MILEAGESTART,
                    OILT.MILEAGEEND,
                    OILT.OIL_AMOUNT,
                    OILT.OIL_BILLNUMBER,
                    CHKPLCAR.RS_OILREMARK,
                    CONVERT (VARCHAR (10),OILT.REFUELINGDATE,20) OILTDWK,
                    CONVERT (VARCHAR (16),OILT.REFUELINGDATE,29) RFD
                FROM RTMS.dbo.VEHICLETRANSPORTPLAN CHKPLCAR
                -- LEFT JOIN RTMS.dbo.VEHICLEINFO CHKIFCAR ON (CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.VEHICLEREGISNUMBER1 OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.VEHICLEREGISNUMBER2 OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.THAINAME OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.THAINAME2)
                -- LEFT JOIN RTMS.dbo.VEHICLETYPE CHKTYCAR ON CHKTYCAR.VEHICLETYPECODE = CHKIFCAR.VEHICLETYPECODE
                LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OILT ON (CHKPLCAR.JOBNO = OILT.JOBNO COLLATE Thai_CI_AI)
                LEFT JOIN RTMS.dbo.VEHICLEINFO CHKIFCAR ON CHKIFCAR.VEHICLEREGISNUMBER = OILT.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                LEFT JOIN RTMS.dbo.VEHICLETYPE CHKTYCAR ON CHKTYCAR.VEHICLETYPECODE = CHKIFCAR.VEHICLETYPECODE 
                WHERE (CHKPLCAR.EMPLOYEECODE1 = '$EHR_PHC' OR CHKPLCAR.EMPLOYEECODE2 = '$EHR_PHC')
                AND CONVERT (VARCHAR (10),CHKPLCAR.DATEWORKING,20) BETWEEN '$CONVERTDATESTART' AND '$CONVERTDATEEND'
                ORDER BY CHKPLCAR.JOBNO ASC";
                $query_oildataresult = sqlsrv_query($conn, $stmt_oildataresult);
                while($result_oildataresult = sqlsrv_fetch_array($query_oildataresult, SQLSRV_FETCH_ASSOC)) {
                    $OILTID = $result_oildataresult["OILTID"];
                    $JOBNOPLAN = $result_oildataresult["JOBNOPLAN"];
                    $OILTJN = $result_oildataresult["OILTJN"];
                    $VHCRGNB = $result_oildataresult["VHCRGNB"];
                    $THAINAME = $result_oildataresult["THAINAME"];
                    $OILTTE = $result_oildataresult["OILTTE"];
                    $MLST = $result_oildataresult["MILEAGESTART"];
                    $MLED = $result_oildataresult["MILEAGEEND"];
                    $DTE = $MLED-$MLST;
                    $OBNB = $result_oildataresult["OIL_BILLNUMBER"];
                    $OAM = $result_oildataresult["OIL_AMOUNT"];
                    $OILTATDWK = $result_oildataresult["OILTATDWK"];
                    $RFD = $result_oildataresult["RFD"];
                    $RS_OILREMARK = $result_oildataresult["RS_OILREMARK"];

                    $stmt_rsbill = "SELECT 
                        COUNT(OIL_BILLNUMBER) AS CHKCOUNT,
                        CHKPLCAR.JOBNO JOBNOPLAN,
                        OILT.JOBNO OILTJN,
                        OILT.OIL_BILLNUMBER
                    FROM RTMS.dbo.VEHICLETRANSPORTPLAN CHKPLCAR
                    -- LEFT JOIN RTMS.dbo.VEHICLEINFO CHKIFCAR ON (CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.VEHICLEREGISNUMBER1 OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.VEHICLEREGISNUMBER2 OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.THAINAME OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.THAINAME2)
                    -- LEFT JOIN RTMS.dbo.VEHICLETYPE CHKTYCAR ON CHKTYCAR.VEHICLETYPECODE = CHKIFCAR.VEHICLETYPECODE
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OILT ON (CHKPLCAR.JOBNO = OILT.JOBNO COLLATE Thai_CI_AI)
                    LEFT JOIN RTMS.dbo.VEHICLEINFO CHKIFCAR ON CHKIFCAR.VEHICLEREGISNUMBER = OILT.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN RTMS.dbo.VEHICLETYPE CHKTYCAR ON CHKTYCAR.VEHICLETYPECODE = CHKIFCAR.VEHICLETYPECODE 
                    WHERE (CHKPLCAR.EMPLOYEECODE1 = '$EHR_PHC' OR CHKPLCAR.EMPLOYEECODE2 = '$EHR_PHC')
                    AND CONVERT (VARCHAR (10),CHKPLCAR.DATEWORKING,20) BETWEEN '$CONVERTDATESTART' AND '$CONVERTDATEEND'
                    AND OILT.JOBNO IS NOT NULL
                    GROUP BY
                        CHKPLCAR.JOBNO,
                        OILT.JOBNO,
                        OILT.OIL_BILLNUMBER
                    ORDER BY CHKPLCAR.JOBNO ASC";
                    $query_rsbill = sqlsrv_query($conn, $stmt_rsbill);
                    $result_rsbill = sqlsrv_fetch_array($query_rsbill);
                    $CHKCOUNT = $result_rsbill["CHKCOUNT"];
                    $RSBILL = $result_rsbill["OIL_BILLNUMBER"];
                    // echo $CHKCOUNT;

                    if($OILTID == ""){
                        $RSOILID="";
                    }else{
                        $RSOILID=$OILTID;
                    }
                    if($OILTJN == ""){
                        if($CHKCOUNT!=""){                                                                                                                    
                            // $CHKJN = '<b><font color="blue">ไม่มีข้อมูลการเติมน้ำมัน</font></b>';
                            // $RSJOBNO = "-";
                            // $RSJOBNO2= "";
                            $CHKJN = 'OK';
                            $RSJOBNO = '-';
                            $RSJOBNO2= "";
                            if($CHKJN=='OK'){
                                $bgcolor1='bgcolor="#D5F5E3"';
                                $bgcolor2='';
                                $bgcolor4='';
                            }
                        }else{
                            $RSJOBNO = '-';
                            $CHKJN = '<b><font color="blue">ไม่มีข้อมูลการเติมน้ำมัน</font></b>';
                        }
                    }else{
                        $CHKJN = 'OK';
                        $RSJOBNO = $OILTJN;
                        $RSJOBNO2=$OILTJN;
                        if($CHKJN=='OK'){
                            $bgcolor1='bgcolor="#D5F5E3"';
                        }
                    }
                    if($RSBILL!=""){
                        $bgcolor3='bgcolor="#D5F5E3"';
                    } 
                    if($JOBNOPLAN==$OILTJN){
                        $bgcolor2='bgcolor="#D5F5E3"';
                        $bgcolor4='bgcolor="#D5F5E3"';
                    }
                    if($VHCRGNB == ""){
                        $RSVHCRGNB="-";
                        $RSTHAINAME="-";
                        $RSOILTTE="-";
                    }else{
                        $RSVHCRGNB=$VHCRGNB;
                        $RSTHAINAME=$THAINAME;
                        $RSOILTTE=$OILTTE;
                    } 
                    if($MLST == ""){
                        $RSMLST="-";
                    }else{
                        $RSMLST=$MLST;
                    }
                    if($MLED == ""){
                        $RSMLED="-";
                    }else{
                        $RSMLED=$MLED;
                    }
                    if($DTE == "0"){
                        $RSDTE="-";
                    }else{
                        $RSDTE=$DTE;
                    }
                    if($OBNB == ""){
                        $RSOBNB=$RSBILL;
                    }else{
                        $RSOBNB=$OBNB;
                    }
                    if($OAM == ""){
                        $RSOAM="-";
                    }else{
                        $RSOAM=$OAM;
                    }
                    if($RFD == ""){
                        $RSRFD="-";
                    }else{
                        $RSRFD=$RFD;
                    }
            ?>       
            <tr class="gradeX odd" role="row">
                <td style="text-align: center;width: 100px;height: 55px">
                    <div class="btn-group">
                        <?php if($JOBNOPLAN==$RSJOBNO2){ ?>
                            <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-chevron-down"></i></button>
                            <ul class="dropdown-menu slidedown">
                                <li><a href="#" onclick="editdataoiltatsuno('<?=$RSOILID;?>','<?=$JOBNOPLAN;?>','<?=$RSJOBNO2;?>','<?=$OBNB;?>','<?=$MLST;?>','<?=$MLED;?>','<?=$OAM;?>','<?=$RS_OILREMARK;?>','<?=$RFD;?>')" data-toggle="modal"  data-target="#modal_editdataoiltatsuno">แก้ไขข้อมูล</a></li>
                            </ul>                                                                                                                                   
                        <?php }else if(($JOBNOPLAN!=$RSJOBNO2) && ($OILTDWK!="")){   ?>        
                            <button type="button" class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-chevron-down"></i></button>
                            <ul class="dropdown-menu slidedown">
                                <li><a href="#" onclick="editdataoiltatsuno('<?=$RSOILID;?>','<?=$JOBNOPLAN;?>','<?=$RSJOBNO2;?>','<?=$OBNB;?>','<?=$MLST;?>','<?=$MLED;?>','<?=$OAM;?>','<?=$RS_OILREMARK;?>','<?=$RFD;?>')" data-toggle="modal"  data-target="#modal_editdataoiltatsuno">แก้ไขข้อมูล</a></li>
                            </ul>  
                        <?php }else{  
                                $JOBOIL = $RSJOBNO2;
                                $JOBPLAN  = $JOBNOPLAN;
                                $POS = strpos($JOBOIL, $JOBPLAN);
                                if ($POS === false) { 
                        ?>
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-chevron-down"></i></button>
                            <ul class="dropdown-menu slidedown">
                                <li><a href="#" onclick="fineandeditdataoiltatsuno('<?=$JOBNOPLAN;?>')" data-toggle="modal"  data-target="#modal_editdataoiltatsuno">แก้ไขข้อมูล</a></li>
                            </ul> 
                        <?php } else { ?>
                            <button type="button" class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-chevron-down"></i></button>
                            <ul class="dropdown-menu slidedown">
                                <li><a href="#" onclick="editdataoiltatsuno('<?=$RSOILID;?>','<?=$JOBNOPLAN;?>','<?=$RSJOBNO2;?>','<?=$OBNB;?>','<?=$MLST;?>','<?=$MLED;?>','<?=$OAM;?>','<?=$RS_OILREMARK;?>','<?=$RFD;?>')" data-toggle="modal"  data-target="#modal_editdataoiltatsuno">แก้ไขข้อมูล</a></li>
                            </ul>    
                        <?php } } ?>
                    </div>
                </td>
                <td style="text-align:center;width:100px" <?=$bgcolor1;?>><b><?=$CHKJN;?></b></td>
                <td style="text-align:center;width:200px" <?=$bgcolor4;?>><b><?=$JOBNOPLAN;?></b></td>
                <td style="text-align:center;width:200px" <?=$bgcolor2;?>><b><?=$RSJOBNO;?></b></td>
                <td style="text-align:center;width:100px" <?=$bgcolor3;?>><b><?=$RSOBNB;?></b></td>
                <td style="text-align:center;width:100px"><?=$RSVHCRGNB;?></td>
                <td style="text-align:center;width:100px"><?=$RSTHAINAME;?></td>
                <td style="text-align:center;width:100px"><?=$RSOILTTE;?></td>
                <td style="text-align:center;width:100px"><?=$RSMLST;?></td>
                <td style="text-align:center;width:100px"><?=$RSMLED;?></td>
                <td style="text-align:center;width:100px"><?=$RSDTE;?></td>
                <td style="text-align:center;width:100px"><?=$RSOAM;?></td>
                <td style="text-align:center;width:100px"><?=$RSRFD;?></td>
            </tr>       
            <?php } ?>
        </tbody>
    </table>
    <center>
        <button type="button" class="btn btn-default btn-md" data-dismiss="modal" onClick="javascript:location.reload();">อัพเดท</button>
        <a href="meg_transportcompensation.php" class="btn btn-danger btn-md">ย้อนกลับ</a>
    </center>
<?php } ?>
<?php if ($_POST['txt_flg'] == "select_editdataoiltatsuno") {
    $OILTID=$_POST['oiltatid'];
    $JOBNOPLAN=$_POST['oiljobnoplan'];
    $RSJOBNO2=$_POST['oiljobnotat'];
    $OILTOBNB=$_POST['oilbillno'];
    $OILTMLST=$_POST['mileagestart'];
    $OILTMLED=$_POST['mileageend'];
    $OILTOAM=$_POST['oilamount'];
    $OILTRFD=$_POST['refueldate'];
    $USERNAME=$_SESSION["USERNAME"];
?>
    <div class="row">
        <div class="col-lg-12">
            <div style="text-align: right">
                <input class="btn btn-default" type="button" style="background-color:#FFFFFF;border:solid 2px"> * ช่องสำหรับแก้ไข
                <input class="btn btn-default" type="button" style="background-color:#CCCCCC;border:solid 2px"> * ไม่สามารถแก้ไขได้
            </div>  <br>
            <!-- <form name="form1" id="fupForm" action="meg_transportcompensation_saveoildetail.php" method="post"> -->
            <form id="fupForm" name="form1" method="post">                            
                <table id="bg-table" width="100%" style="" border="1">
                    <thead>
                        <tr>
                            <th colspan="6" bgcolor="#CCCCCC" style="text-align: center"><b>ข้อมูลน้ำมัน</b></th>
                        </tr>                    
                    </thead>
                    <tbody>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลข Job จากแผน&nbsp;&nbsp;</th>
                            <th colspan="2" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%;font-weight:bold;" id="jobnoplan" name="jobnoplan" value="<?=$JOBNOPLAN;?>" disabled></th>
                            <th colspan="1" rowspan="2" bgcolor="#CCCCCC" style="text-align:center;"><button type="button" onclick="copyjob()">คัดลอก</button></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลข Job น้ำมัน&nbsp;&nbsp;</th>
                            <th colspan="2" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="jobnooil" name="jobnooil" value="<?=$RSJOBNO2;?>"></th>
                            <th colspan="1" rowspan="2" bgcolor="#CCCCCC" style="text-align:right;"></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลขใบกำกับน้ำมัน&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="oilbill" name="oilbill" value="<?=$OILTOBNB;?>" disabled></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลขไมล์ต้น&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="" name="" value="<?=$OILTMLST;?>" disabled></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลขไมล์ปลาย&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="mileageend" name="mileageend" value="<?=$OILTMLED;?>" ></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">จำนวนน้ำมัน(ลิตร)&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="" name="" value="<?=$OILTOAM;?>" disabled></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">วันที่เติมน้ำมัน&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="daterefuel" name="daterefuel" value="<?=$OILTRFD;?>" disabled></th>
                        </tr>
                    </tbody>
                </table>
                <!-- <font color="red"><small>***ข้อมูลจะแสดงเมื่อเลข JOB ตรงกัน</small></font> -->
                <input type="hidden" name="oldjoboil" id="oldjoboil" value="<?=$RSJOBNO2;?>">
                <input type="hidden" name="mileagestart" id="mileagestart" value="<?=$OILTMLST;?>">
                <input type="hidden" name="oilamout" id="oilamout" value="<?=$OILTOAM;?>">
                <input type="hidden" name="oiltatid" id="oiltatid" value="<?=$OILTID;?>">
                <input type="hidden" name="username" id="username" value="<?=$USERNAME;?>">
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" name="updatejob" onclick="updateoiltatsuno()" value="updatejob" id="butupdate"><span class="fa fa-save"></span> บันทึกการแก้ไข</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onClick="javascript:location.reload();"><span class="fa fa-close"></span> ปิด</button>
                </div>
            </form>
        </div>
    </div>
<?php } ?>
<?php if ($_POST['txt_flg'] == "select_editdataoiltatsuno_byadmin") { 
    $OILTID=$_POST['oiltatid'];
    $JOBNOPLAN=$_POST['oiljobnoplan'];
    $RSJOBNO2=$_POST['oiljobnotat'];
    $OILTOBNB=$_POST['oilbillno'];
    $OILTMLST=$_POST['mileagestart'];
    $OILTMLED=$_POST['mileageend'];
    $OILTOAM=$_POST['oilamount'];
    $RS_OILREMARK=$_POST['oilremark'];
    $OILTRFD=$_POST['refueldate'];
    $USERNAME=$_SESSION["USERNAME"];
?>
    <div class="row">
        <div class="col-lg-12">
            <div style="text-align: right">
                <input class="btn btn-default" type="button" style="background-color:#FFFFFF;border:solid 2px"> * ช่องสำหรับแก้ไข
                <input class="btn btn-default" type="button" style="background-color:#CCCCCC;border:solid 2px"> * ไม่สามารถแก้ไขได้
            </div>  <br>
            <form id="fupForm" name="form1" method="post">                            
                <table id="bg-table" width="100%" style="" border="1">
                    <thead>
                        <tr>
                            <th colspan="6" bgcolor="#CCCCCC" style="text-align: center"><b>ข้อมูลน้ำมัน</b></th>
                        </tr>                    
                    </thead>
                    <tbody>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลข Job จากแผน&nbsp;&nbsp;</th>
                            <th colspan="2" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%;font-weight:bold;" id="jobnoplan" name="jobnoplan" value="<?=$JOBNOPLAN;?>" disabled></th>
                            <th colspan="1" rowspan="2" bgcolor="#CCCCCC" style="text-align:center;"><button type="button" onclick="copyjob()">คัดลอก</button></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลข Job น้ำมัน&nbsp;&nbsp;</th>
                            <th colspan="2" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="jobnooil" name="jobnooil" value="<?=$RSJOBNO2;?>"></th>
                            <th colspan="1" rowspan="2" bgcolor="#CCCCCC" style="text-align:right;"></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลขใบกำกับน้ำมัน&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="oilbill" name="oilbill" value="<?=$OILTOBNB;?>" disabled></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลขไมล์ต้น&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="mileagestart" name="mileagestart" value="<?=$OILTMLST;?>" <?php if($_SESSION["ROLENAME"] != "ADMIN" && $_SESSION["ROLENAME"] != "PLANNING(AMT)" && $_SESSION["ROLENAME"] != "PLANNING(GW)"){ ?> disabled <?php } ?>></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลขไมล์ปลาย&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="mileageend" name="mileageend" value="<?=$OILTMLED;?>" ></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">จำนวนน้ำมัน(ลิตร)&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="oilamout" name="oilamout" value="<?=$OILTOAM;?>" <?php if($_SESSION["ROLENAME"] != "ADMIN" && $_SESSION["ROLENAME"] != "PLANNING(AMT)" && $_SESSION["ROLENAME"] != "PLANNING(GW)"){ ?> disabled <?php } ?>></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">วันที่เติมน้ำมัน&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="daterefuel" name="daterefuel" value="<?=$OILTRFD;?>" disabled></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">หมายเหตุ&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="oilremark" name="oilremark" value="<?=$RS_OILREMARK;?>" <?php if($_SESSION["ROLENAME"] != "ADMIN" && $_SESSION["ROLENAME"] != "PLANNING(AMT)" && $_SESSION["ROLENAME"] != "PLANNING(GW)"){ ?> disabled <?php } ?>></th>
                        </tr>
                    </tbody>
                </table>
                <!-- <font color="red"><small>***ข้อมูลจะแสดงเมื่อเลข JOB ตรงกัน</small></font> -->
                <input type="hidden" name="oldjoboil" id="oldjoboil" value="<?=$RSJOBNO2;?>">
                <input type="hidden" name="oiltatid" id="oiltatid" value="<?=$OILTID;?>">
                <input type="hidden" name="username" id="username" value="<?=$USERNAME;?>">
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" name="updatejob" onclick="updateoiltatsuno_byadmin()" value="butupdate_byadmin" id="butupdate_byadmin"><span class="fa fa-save"></span> บันทึกการแก้ไข</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onClick="javascript:location.reload();"><span class="fa fa-close"></span> ปิด</button>
                </div>
            </form>
        </div>
    </div>
<?php } ?>
<?php if ($_POST['txt_flg'] == "select_fineandeditdataoiltatsuno") {     
    $JOBNOPLAN=$_POST['oiljobnoplan'];
?>
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-4">
                    <div style="text-align: left">
                        <label>ค้นหาเลขบิล</label>
                        <form id="fupForm" name="form1" method="post">  
                            <div class="row">
                                <div class="col-md-9">
                                    <input type="number" class="form-control" style="border-style:solid;border-width: 1px;" id="finebill" name="finebill" value="<?=$finebill;?>" require>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-primary btn-md" onclick="finedataoil()">ค้นหา</button>
                                </div>
                            </div>          
                        </form>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div style="text-align: right">
                        <input class="btn btn-default" type="button" style="background-color:#FFFFFF;border:solid 2px"> * ช่องสำหรับแก้ไข
                        <input class="btn btn-default" type="button" style="background-color:#CCCCCC;border:solid 2px"> * ไม่สามารถแก้ไขได้
                    </div>
                </div>
            </div>
            <br>
            <form id="fupForm" name="form1" method="post">                            
                <table id="bg-table" width="100%" style="" border="1">
                    <thead>
                        <tr>
                            <th colspan="6" bgcolor="#CCCCCC" style="text-align: center"><b>ข้อมูลน้ำมัน</b></th>
                        </tr>                    
                    </thead>
                    <tbody>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลข Job จากแผน&nbsp;&nbsp;</th>
                            <th colspan="2" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%;font-weight:bold;" id="jobnoplan" name="jobnoplan" value="<?=$JOBNOPLAN;?>" disabled></th>
                            <th colspan="1" rowspan="2" bgcolor="#CCCCCC" style="text-align:center;"><button type="button" onclick="copyjob()">คัดลอก</button></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลข Job น้ำมัน&nbsp;&nbsp;</th>
                            <th colspan="2" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="jobnooil" name="jobnooil" value="<?=$RSJOBNO2;?>" autocomplete="off"></th>
                            <th colspan="1" rowspan="2" bgcolor="#CCCCCC" style="text-align:right;"></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลขใบกำกับน้ำมัน&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="oilbill" name="oilbill" value="<?=$OILTOBNB;?>" disabled></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลขไมล์ต้น&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="mileagestart" name="mileagestart" value="<?=$OILTMLST;?>" <?php if($_SESSION["ROLENAME"] != "ADMIN" && $_SESSION["ROLENAME"] != "PLANNING(AMT)" && $_SESSION["ROLENAME"] != "PLANNING(GW)"){ ?> disabled <?php } ?>></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลขไมล์ปลาย&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="mileageend" name="mileageend" value="<?=$OILTMLED;?>" ></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">จำนวนน้ำมัน(ลิตร)&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="oilamout" name="oilamout" value="<?=$OILTOAM;?>" <?php if($_SESSION["ROLENAME"] != "ADMIN" && $_SESSION["ROLENAME"] != "PLANNING(AMT)" && $_SESSION["ROLENAME"] != "PLANNING(GW)"){ ?> disabled <?php } ?>></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">วันที่เติมน้ำมัน&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="daterefuel" name="daterefuel" value="<?=$OILTRFD;?>" disabled></th>
                        </tr>
                        <?php if($_SESSION['ROLENAME']=="ADMIN" || $_SESSION["ROLENAME"] == "PLANNING(AMT)" || $_SESSION["ROLENAME"] == "PLANNING(GW)"){ ?>
                            <tr>
                                <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">หมายเหตุ&nbsp;&nbsp;</th>
                                <th colspan="3" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="oilremark" name="oilremark" value="<?=$RS_OILREMARK;?>" <?php if($_SESSION["ROLENAME"] != "ADMIN" && $_SESSION["ROLENAME"] != "PLANNING(AMT)" && $_SESSION["ROLENAME"] != "PLANNING(GW)"){ ?> disabled <?php } ?>></th>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <input type="hidden" name="oldjoboil" id="oldjoboil" value="<?=$RSJOBNO2;?>">
                <input type="hidden" name="oiltatid" id="oiltatid" value="<?=$OILTID;?>">
                <input type="hidden" name="username" id="username" value="<?=$USERNAME;?>">
                <div class="modal-footer">
                    <?php if($_SESSION['ROLENAME']=="ADMIN" || $_SESSION["ROLENAME"] == "PLANNING(AMT)" || $_SESSION["ROLENAME"] == "PLANNING(GW)"){ ?>
                        <button type="button" class="btn btn-primary" name="updatejob" onclick="updateoiltatsuno_byadmin()" value="butupdate_byadmin" id="butupdate_byadmin"><span class="fa fa-save"></span> บันทึกการแก้ไข</button>
                    <?php }else{ ?>
                        <button type="button" class="btn btn-primary" name="updatejob" onclick="updateoiltatsuno()" value="updatejob" id="butupdate"><span class="fa fa-save"></span> บันทึกการแก้ไข</button>
                    <?php } ?>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onClick="javascript:location.reload();"><span class="fa fa-close"></span> ปิด</button>
                </div>
            </form>
        </div>
    </div>
<?php } ?>
<?php if ($_POST['txt_flg'] == "select_checkoil") {     
    $jobno=$_POST['jobno'];
    // echo $jobno.'<br>';
    $SQLCHKOIL = "SELECT *,
        CASE WHEN (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VEHICLETRANSPORTPLANID AND OSGS_TY IN(1,2,3)) > 0 THEN (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VEHICLETRANSPORTPLANID AND OSGS_TY IN(1,2,3))
            ELSE 0 END OSGS_OUT,
        CASE WHEN (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VEHICLETRANSPORTPLANID AND OSGS_TY = 4) > 0 THEN (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VEHICLETRANSPORTPLANID AND OSGS_TY = 4)
            ELSE 0 END OSGS_PM,
        CONVERT (VARCHAR (16),OILT.REFUELINGDATE,29) CONREFUELINGDATE FROM RTMS.dbo.VEHICLETRANSPORTPLAN VHCTPP
        LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OILT ON (VHCTPP.JOBNO = OILT.JOBNO COLLATE Thai_CI_AI)
        WHERE VHCTPP.JOBNO = '$jobno'";
    $QUERYOIL = sqlsrv_query($conn, $SQLCHKOIL );  
    $RESULTOIL = sqlsrv_fetch_array($QUERYOIL, SQLSRV_FETCH_ASSOC);
    $OAM=$RESULTOIL["OIL_AMOUNT"];
    $CHKOUT=$RESULTOIL["OSGS_OUT"];
    $CHKPM=$RESULTOIL["OSGS_PM"];
    if(($OAM > 0) && ($CHKOUT > 0) && ($CHKPM > 0)){
        $CALOAM=($OAM+$CHKOUT)-$CHKPM;
        $REMARK='(เติมใน+เติมนอก)-PM';
    }else if(($OAM > 0) && ($CHKOUT > 0) && ($CHKPM == '0')){
        $CALOAM=$OAM+$CHKOUT;
        $REMARK='เติมใน+เติมนอก';
    }else if(($OAM > 0) && ($CHKOUT == '0') && ($CHKPM > 0)){
        $CALOAM=$OAM-$CHKPM;
        $REMARK='เติมใน-PM';
    }else{        
        $REMARK='ลิตร';
        $CALOAM=$OAM;
    }
    if(isset($RESULTOIL["DISTANCE"])){
        $DISTANCE=$RESULTOIL["DISTANCE"];
        $CALAVG= $DISTANCE / $CALOAM;
        $RSCALAVG=number_format($CALAVG, 2);
    }else{
        $DISTANCE='';
        $CALAVG='';
        $RSCALAVG='';
    }

?>
<div class="row">
    <div class="col-lg-12">                      
        <table id="bg-table" width="100%" style="" border="1">
            <thead>
                <tr>
                    <th colspan="6" bgcolor="#CCCCCC" style="text-align: center"><b>ข้อมูลน้ำมัน</b></th>
                </tr>                    
            </thead>
            <tbody>
                <tr>
                    <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลข Job&nbsp;&nbsp;</th>
                    <th colspan="3" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%;" value="<?=$jobno;?>" disabled></th>
                </tr>
                <tr>
                    <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลขใบกำกับน้ำมัน&nbsp;&nbsp;</th>
                    <th colspan="3" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" value="<?=$RESULTOIL["OIL_BILLNUMBER"];?>" disabled></th>
                </tr>
                <tr>
                    <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลขไมล์ต้น&nbsp;&nbsp;</th>
                    <th colspan="3" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" value="<?=$RESULTOIL["MILEAGESTART"];?>" disabled></th>
                </tr>
                <tr>
                    <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลขไมล์ปลาย&nbsp;&nbsp;</th>
                    <th colspan="3" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" value="<?=$RESULTOIL["MILEAGEEND"];?>" disabled></th>
                </tr>
                <tr>
                    <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">ระยะทางรวม&nbsp;&nbsp;</th>
                    <th colspan="3" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" value="<?=$RESULTOIL["DISTANCE"];?>" disabled></th>
                </tr>
                <tr>
                    <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">จำนวนน้ำมัน(<small><?=$REMARK;?></small>)&nbsp;&nbsp;</th>
                    <th colspan="3" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" value="<?=$CALOAM;?>" disabled></th>
                </tr>
                <tr>
                    <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">วันที่เติมน้ำมัน&nbsp;&nbsp;</th>
                    <th colspan="3" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" value="<?=$RESULTOIL["CONREFUELINGDATE"];?>" disabled></th>
                </tr>
                <tr>
                    <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">ค่าเฉลี่ยมาตรฐานที่กำหนด&nbsp;&nbsp;</th>
                    <th colspan="3" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" value="<?=$RESULTOIL['RS_OILAVERAGE'];?>" disabled></th>
                </tr>
                <tr>
                    <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">ค่าเฉลี่ยน้ำมันที่ได้&nbsp;&nbsp;</th>
                    <th colspan="3" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" value="<?=$RSCALAVG;?>" disabled></th>
                </tr>
                <tr>
                    <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">ยอดเงินที่ได้&nbsp;&nbsp;</th>
                    <th colspan="3" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" value="<?=$RESULTOIL["C3"];?>" disabled></th>
                </tr>
            </tbody>
        </table>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
        </div>
    </div>
</div>
<?php } ?>

<?php if ($_POST['txt_flg'] == "select_cashoil") { 
    $conditionEHR = " AND a.PersonID ='" . $_SESSION["EMPLOYEEID"] . "'";
    $sql_seEHR = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEHR = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($conditionEHR, SQLSRV_PARAM_IN)
    );
    $query_seEHR = sqlsrv_query($conn, $sql_seEHR, $params_seEHR);
    $result_seEHR = sqlsrv_fetch_array($query_seEHR, SQLSRV_FETCH_ASSOC);
                                                 
    date_default_timezone_set('Asia/Bangkok');
    $datestartoil=$_POST['datestartoil'];
    $dateendoil=$_POST['dateendoil'];

    $date1 = $datestartoil;
    $start = explode("/", $date1);
    $startd = $start[0];
    $startif = $start[1];        
        if($startif=='01'){
            $selectmonth = "มกราคม";
            $selectmonthstart = "ม.ค.";
        }else if($startif=='02'){
            $selectmonth = "กุมภาพันธ์";
            $selectmonthstart = "ก.พ.";
        }else if($startif=='03'){
            $selectmonth = "มีนาคม";
            $selectmonthstart = "มี.ค.";
        }else if($startif=='04'){
            $selectmonth = "เมษายน";
            $selectmonthstart = "เม.ย.";
        }else if($startif=='05'){
            $selectmonth = "พฤษภาคม";
            $selectmonthstart = "พ.ค.";
        }else if($startif=='06'){
            $selectmonth = "มิถุนายน";
            $selectmonthstart = "มิ.ย.";
        }else if($startif=='07'){
            $selectmonth = "กรกฎาคม";
            $selectmonthstart = "ก.ค.";
        }else if($startif=='08'){
            $selectmonth = "สิงหาคม";
            $selectmonthstart = "ส.ค.";
        }else if($startif=='09'){
            $selectmonth = "กันยายน";
            $selectmonthstart = "ก.ย.";
        }else if($startif=='10'){
            $selectmonth = "ตุลาคม";
            $selectmonthstart = "ต.ค.";
        }else if($startif=='11'){
            $selectmonth = "พฤศจิกายน";
            $selectmonthstart = "พ.ย.";
        }else if($startif=='12'){
            $selectmonth = "ธันวาคม";
            $selectmonthstart = "ธ.ค.";
        }
    $start_yen = $start[2];
    $start_yth = $start[2]+543;
    $start_ymd = $start[2].'-'.$start[1].'-'.$start[0];

    $date2 = $dateendoil;
    $end = explode("/", $date2);
    $endd = $end[0];
    $endif = $end[1];            
        if($startif=='01'){
            $selectmonth = "มกราคม";
            $selectmonthend = "ม.ค.";
        }else if($startif=='02'){
            $selectmonth = "กุมภาพันธ์";
            $selectmonthend = "ก.พ.";
        }else if($startif=='03'){
            $selectmonth = "มีนาคม";
            $selectmonthend = "มี.ค.";
        }else if($startif=='04'){
            $selectmonth = "เมษายน";
            $selectmonthend = "เม.ย.";
        }else if($startif=='05'){
            $selectmonth = "พฤษภาคม";
            $selectmonthend = "พ.ค.";
        }else if($startif=='06'){
            $selectmonth = "มิถุนายน";
            $selectmonthend = "มิ.ย.";
        }else if($startif=='07'){
            $selectmonth = "กรกฎาคม";
            $selectmonthend = "ก.ค.";
        }else if($startif=='08'){
            $selectmonth = "สิงหาคม";
            $selectmonthend = "ส.ค.";
        }else if($startif=='09'){
            $selectmonth = "กันยายน";
            $selectmonthend = "ก.ย.";
        }else if($startif=='10'){
            $selectmonth = "ตุลาคม";
            $selectmonthend = "ต.ค.";
        }else if($startif=='11'){
            $selectmonth = "พฤศจิกายน";
            $selectmonthend = "พ.ย.";
        }else if($startif=='12'){
            $selectmonth = "ธันวาคม";
            $selectmonthend = "ธ.ค.";
        }
    $end_yen = $end[2];
    $end_yth = $end[2]+543;
    $end_ymd = $end[2].'-'.$end[1].'-'.$end[0];
    // echo $datestartoil;
    // echo "<br>";
    // echo $dateendoil;
    // echo "<br>";
    // echo"<pre>";
    // print_r($_POST);
    // echo"</pre>";
    // exit();
    $DATESTART = str_replace('/', '-', $datestartoil);
    $CONVERTDATESTART = date("Y-m-d", strtotime($DATESTART) );
    // ECHO "<br>";
    $DATEEND = str_replace('/', '-', $dateendoil);
    $CONVERTDATEEND = date("Y-m-d", strtotime($DATEEND) );

    $EHR_PHC = $result_seEHR['PersonCode'];

?>
    <center><h3>ข้อมูลระหว่างวันที่ <?=$start[0].' '.$selectmonthstart.' '.$start_yth;?> -  <?=$end[0].' '.$selectmonthend.' '.$end_yth;?></h3></center>
    <table width="100%" class="table" >
        <thead>
            <tr>
                <?php
                $SQLPRICE = "SELECT DISTINCT OLP.PRICE, OLP.MONTH, OLP.YEAR FROM OILPEICE OLP WHERE OLP.COMPANYCODE IN('RCC','RATC','RRC') AND OLP.[YEAR] = '$start_yen' AND OLP.[MONTH] = '$selectmonth'";
                $QUERYPRICE = sqlsrv_query($conn, $SQLPRICE);
                $RSPRICE = sqlsrv_fetch_array($QUERYPRICE, SQLSRV_FETCH_ASSOC);   
                    $PRICE=$RSPRICE["PRICE"]; 
                ?>
                <th colspan="10" style="text-align: right">ราคาน้ำมันเดือน <?=$selectmonth?> = <?=$PRICE?> บาท</th>
                <th colspan="1" style="text-align: left"></th>
            </tr>
        </thead>
    </table>
    <table style="height: 100px;" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-tablecashoil" role="grid" aria-describedby="dataTables-example_info">
        <thead>
            <tr>
                <th style="text-align: center;width: 20px">ลำดับ</th>
                <!-- <th style="text-align: center;width: 120px">สถานะการจ่ายเงิน</th> -->
                <th style="text-align: center;width: 100px">วันที่เติมน้ำมัน</th>
                <th style="text-align: center;width: 80px">เลขบิลน้ำมัน</th>
                <th style="text-align: center;width: 70px">รหัสพนักงาน</th>
                <th style="text-align: center;width: 110px">ชื่อ-สกุล</th>
                <th style="text-align: center;width: 80px">ทะเบียนรถ</th>
                <th style="text-align: center;width: 80px">ชื่อรถ</th>
                <th style="text-align: center;width: 120px">ประเภทรถ</th>
                <th style="text-align: center;width: 150px">ต้นทาง</th>
                <th style="text-align: center;width: 150px">ปลายทาง</th>
                <th style="text-align: center;width: 70px">ไมล์ต้น</th>
                <th style="text-align: center;width: 70px">ไมล์ปลาย</th>
                <th style="text-align: center;width: 60px">ระยะทาง</th>
                <th style="text-align: center;width: 80px">น้ำมันที่ใช้</th>
                <th style="text-align: center;width: 100px">ค่าเฉลี่ยที่ได้</th>
                <th style="text-align: center;width: 120px">ค่าเฉลี่ยที่กำหนด</th>
                <th style="text-align: center;width: 100px">น้ำมันที่กำหนด</th>
                <th style="text-align: center;width: 100px">ส่วนต่างน้ำมัน</th>
                <th style="text-align: center;width: 100px">จำนวนเงินบาท</th>
                <th style="text-align: center;width: 200px">หมายเลขแผน</th>
                <th style="text-align: center;width: 70px">จำนวนเที่ยว</th>
                <th style="text-align: center;width: 70px">ประเภทงาน</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $stmm = "SELECT DISTINCT *
                FROM TEMP_CHAVGGW WHERE REFUEL BETWEEN '$CONVERTDATESTART' AND '$CONVERTDATEEND'                                                                         
                ORDER BY OBLNB ASC";
                $querystmm = sqlsrv_query($conn, $stmm );  
                $i = 1;
                $DTP = 0;
                while($objResult = sqlsrv_fetch_array($querystmm)) {       
                    $REFUEL=$objResult["REFUEL"];
                    $CONREFUEL = explode("-", $REFUEL);
                    $RSREFUEL = $CONREFUEL[2].'/'.$CONREFUEL[1].'/'.$CONREFUEL[0];
                    if($RSREFUEL!="//"){
                        $RSREFUEL=$RSREFUEL;
                    }else{
                        $RSCHKREFUEL="";
                    }
                    $OBLNB=$objResult["OBLNB"];
                    $EMP=$objResult["EMP"];
                    $EMPN=$objResult["EMPN"];
                    $VHCRG=$objResult["VHCRG"];
                    $VHCTN=$objResult["VHCTN"];
                    $VHCTPLAN=$objResult["VHCTPLAN"];
                    $JOBSTART=$objResult["JOBSTART"];
                    $JOBEND=$objResult["JOBEND"];
                    $MST=$objResult["MST"];
                    $MLE=$objResult["MLE"];
                    $DTE=$objResult["DTE"];
                    $CALDTE=$MLE-$MST;
                    $OAM=$objResult["OAM"];
                    $O4=$objResult["O4"];
                                                                
                    // $SQLC2IF="SELECT C2IF.EMPLOYEECODE1,STRING_AGG([C2],',') AS [C2] FROM VEHICLETRANSPORTPLAN C2IF  WHERE
                    // ( C2IF.EMPLOYEECODE1 = '$EMP' OR C2IF.EMPLOYEECODE2 = '$EMP' ) 
                    // AND CONVERT ( VARCHAR ( 10 ), C2IF.DATEWORKING, 20 ) = '$DWK' AND NOT STATUSNUMBER = 'X'      
                    // GROUP BY C2IF.EMPLOYEECODE1";
                    // $QUERYC2IF= sqlsrv_query($conn, $SQLC2IF );  
                    // $RESULTC2IF = sqlsrv_fetch_array($QUERYC2IF, SQLSRV_FETCH_ASSOC);
                    // $C2IF=$RESULTC2IF["C2"];

                    $C2IF=$objResult["C2"];
                    if($C2IF==','){
                        $C2='';
                    }else if($C2IF==''){
                        $C2='';
                    }else{
                        $C2='NOTNULL';
                    }
                    $C3=$objResult["C3"];
                    // $OAVG=$objResult["OAVG"];
                    $CALOAVG=$CALDTE/$OAM;
                    $OAVG=number_format($CALOAVG, 2);
                    
                    $DWK=$objResult["DWK"];   
                                                                                                
                    // $SQLCHKWORK="SELECT SCPT.EMPLOYEECODE1,STRING_AGG([WORKTYPE],',') AS [CHKWORK] FROM VEHICLETRANSPORTPLAN SCPT  WHERE
                    // ( SCPT.EMPLOYEECODE1 = '$EMP' OR SCPT.EMPLOYEECODE2 = '$EMP' ) 
                    // AND CONVERT ( VARCHAR ( 10 ), SCPT.DATEWORKING, 20 ) = '$DWK' AND NOT STATUSNUMBER = 'X' 
                    // GROUP BY SCPT.EMPLOYEECODE1";
                    // $QUERYCHKWORK= sqlsrv_query($conn, $SQLCHKWORK );  
                    // $RESULTCHKWORK = sqlsrv_fetch_array($QUERYCHKWORK, SQLSRV_FETCH_ASSOC);
                    // $CHKWORK=$RESULTCHKWORK["CHKWORK"]; 
                    $CHKWORK=$objResult["CHKWORK"]; 

                    if($CHKWORK==","){$CHKWORKIF="";}else if($CHKWORK==",,"){$CHKWORKIF="";}else if($CHKWORK==",,,"){$CHKWORKIF="";}else if($CHKWORK==",,,,"){$CHKWORKIF="";}else{$CHKWORKIF=$CHKWORK;}
                    
                    
                    $CHKW = explode(",", $CHKWORK);
                    $RSCHKW1 = $CHKW[0];
                    $RSCHKW2 = $CHKW[1];
                    $RSCHKW3 = $CHKW[2];
                    $RSCHKW4 = $CHKW[3];

                    $VHCTPPCOM=$objResult["VHCTPPCOM"];
                    $VHCTPPCUS=$objResult["VHCTPPCUS"];
                                                                
                    // $SQLCHKROUND="SELECT COUNT( VHCTPP.EMPLOYEECODE1 ) COUNTROUNDAMOUT FROM VEHICLETRANSPORTPLAN VHCTPP 
                    // WHERE (VHCTPP.EMPLOYEECODE1 = '$EMP' OR VHCTPP.EMPLOYEECODE2 = '$EMP') AND CONVERT ( VARCHAR ( 10 ), VHCTPP.DATEWORKING, 20 ) = '$DWK' AND NOT STATUSNUMBER = 'X'";
                    // $QUERYROUND = sqlsrv_query($conn, $SQLCHKROUND );  
                    // // while($objResult = sqlsrv_fetch_array($querystmm)) {
                    // $RESULTROUND = sqlsrv_fetch_array($QUERYROUND, SQLSRV_FETCH_ASSOC);
                    // $CALROUND=$RESULTROUND["COUNTROUNDAMOUT"];
                    $CALROUND=$objResult["COUNTROUNDAMOUT"];
                    
                    if(($VHCTN=='T-001')||($VHCTN=='T-002')||($VHCTN=='T-003')||($VHCTN=='T-004')){                             // ชื่อรถ T001 - T004
                        if($VHCTPPCUS=='GMT'){                                                                                      // ถ้าเป็นลูกค้า GMT
                            $RSCHKWORKAVG='4.25';                                                                                       // คิด 4.25
                        }else{                                                                                                      // ถ้าไม่ใช่ลูกค้า GMT
                            $RSCHKWORKAVG='5.00';                                                                                       // คิด 5.00
                        }                                                                                     
                    }else if(($VHCTN=='T-005')||($VHCTN=='T-006')||($VHCTN=='T-007')||($VHCTN=='T-008')||($VHCTN=='T-009')){    // ชื่อรถ T001 - T004
                        $RSCHKWORKAVG='4.75';                                                                                            // คิด 4.75
                    }else if(($VHCTN=='G-001')||($VHCTN=='G-002')||($VHCTN=='G-003')||($VHCTN=='G-004')||($VHCTN=='G-005')||
                            ($VHCTN=='G-006')||($VHCTN=='G-007')||($VHCTN=='G-008')||($VHCTN=='G-009')||($VHCTN=='G-010')||
                            ($VHCTN=='G-011')||($VHCTN=='G-012')||($VHCTN=='G-013')){                                           // ชื่อรถ G001 - G0013
                        if($VHCTPLAN=="10W(Dump)"){                                                                                 // ถ้าเป็นรถ 10W
                            $RSCHKWORKAVG='4.25';                                                                                       // คิด 4.25
                        }else if($VHCTPLAN=="22W(Dump)"){                                                                           // ถ้าเป็นรถ 22W
                            $RSCHKWORKAVG='3.00';                                                                                       // คิด 3.00
                        }                                                                                     
                    }else if($C2!=""){                                          // ถ้าเป็นงานรับกลับ
                        $RSCHKWORKAVG='3.75';                                       // 3.75
                    }else{
                        if(($CALROUND=='1')){                                   // 1 เที่ยว
                            if($RSCHKW1=='sh'){
                                $RSCHKWORKAVG='4.25';                               // sh = 3.75 // แก้เป็น 4.25 วันที่ 6/9/2023
                            }else if($RSCHKW1=='nm'){
                                $RSCHKWORKAVG='4.25';                               // nm = 4.25 
                            }else{
                                $RSCHKWORKAVG=$objResult["OTG"];                // เรทปกติจากระบบ 
                            }
                        }else if($CALROUND=='2'){                               // 2 เที่ยว                                                                   
                            if(($RSCHKW1=='sh')&&($RSCHKW2=='sh')){ 
                                $RSCHKWORKAVG='3.75';                               // sh-sh = 3.75
                            }else if(($RSCHKW1=='sh')&&($RSCHKW2=='nm')){
                                $RSCHKWORKAVG='4.25';                               // sh-nm = 4.25
                            }else if(($RSCHKW1=='nm')&&($RSCHKW2=='sh')){
                                $RSCHKWORKAVG='3.75';                               // nm-sh = 3.75  
                            }else if(($RSCHKW1=='nm')&&($RSCHKW2=='nm')){
                                $RSCHKWORKAVG='4.25';                               // nm-nm = 4.25                                                                        
                            }else{
                                $RSCHKWORKAVG=$objResult["OTG"]; // เรทปกติจากระบบ                                                                    
                            }
                        }else{
                            $RSCHKWORKAVG=$objResult["OTG"]; // เรทปกติจากระบบ                                                                    
                        }
                    }

                    $OTG=$objResult["OTG"];
                    $CALOTG=$CALDTE/$RSCHKWORKAVG;
                    $CALOTG2=number_format($CALOTG, 2);
                    $CALDO=$CALOTG-$OAM;
                    $DIFFOIL=round($CALDO);
                    $DIFFOIL2=number_format($DIFFOIL, 2);
                    
                    
                    $EMP=$objResult["EMP"];
                    $EMP222=$objResult["EMP222"];
                    // echo 'คนที่ 1 '.$EMP.'<br>';
                    // echo 'คนที่ 2 '.$EMP222.'<br>';
                    if($EMP222==$EMP){
                        $CALPRICE=$DIFFOIL2*$PRICE;
                        // echo 'รหัส 1 ตรงกับรหัส 2 = ส่วนต่าง*ราคา = '.$CALPRICE.'<br>';
                    }else if($EMP222!=$EMP){
                        if($EMP222!=""){
                            $CALPRICE=($DIFFOIL2*$PRICE)/2;
                            // echo 'รหัส 1 ไม่ตรงกับรหัส 2 = (ส่วนต่าง*ราคา)/2 = '.$CALPRICE.'<br>';
                        }else{
                            $CALPRICE=$DIFFOIL2*$PRICE;
                            // echo 'รหัส 1 ไม่ตรงกับรหัส 2 แต่ไปคนเดียว = ส่วนต่าง*ราคา = '.$CALPRICE.'<br>';
                        }
                    }

                    $CONFIRM=$objResult["CONFIRM"];
                    $WDOAVG_CREATE_DATE=$objResult["WDOAVG_CREATE_DATE"];
                    $WDOAVG_CAD = explode("-", $WDOAVG_CREATE_DATE);
                    if($CONFIRM!=""){
                        $RSCAD=$WDOAVG_CAD[2].'/'.$WDOAVG_CAD[1].'/'.$WDOAVG_CAD[0];
                    }else{
                        $RSCAD="";
                    }
                    
                    $OILID=$objResult["OILID"];
                    $VHCTPPID=$objResult["VHCTPPID"];
                    $CNB=$objResult["CNB"];
                    $VHCTOIL=$objResult["VHCTOIL"];
                    $ENGY=$objResult["ENGY"];
                    $WORKTYPE=$objResult["WORKTYPE"];
                    $JNOIL=$objResult["JNOIL"];
                    $JNPLAN=$objResult["JNPLAN"];
                    
                    $WDOAVG_ID=$objResult["WDOAVG_ID"];


                    if($WDOAVG_ID==""){
                        $RSWDOAVG_ID = 'style="text-align: center;background-color: #F79646"';
                    }else if($WDOAVG_ID!=""){
                        $RSWDOAVG_ID = 'style="text-align: center;background-color: #449D44"';
                    }
                    
            ?>
            <tr>
                <td style="text-align: center;"><?=$i?></td>
                <!-- <td <?=$RSWDOAVG_ID?>>
                    <?php if($WDOAVG_ID==""){ ?> 
                        <a href="javascript:;"
                            data-refuel="<?=$RSREFUEL;?>"
                            data-oblnb="<?=$OBLNB;?>"
                            data-empn="<?=$EMPN;?>"
                            data-vhcrg="<?=$VHCRG;?>"
                            data-jobend="<?=$JOBEND;?>"
                            data-vhcth="<?=$VHCTN;?>"
                            data-oam="<?=$OAM;?>"
                            data-calprice="<?=number_format($CALPRICE, 2);?>"
                            data-mst="<?=$MST;?>"
                            data-mle="<?=$MLE;?>"
                            data-caldte="<?=$CALDTE;?>"
                            data-emp="<?=$EMP;?>"
                            data-vhcttpid="<?=$VHCTPPID;?>"
                            data-oilid="<?=$OILID;?>"
                            data-oavg="<?=$OAVG;?>"
                            data-otg="<?=$OTG;?>"
                            data-calotg="<?=number_format($CALOTG, 2);?>"
                            data-diffoil="<?=number_format($DIFFOIL, 2);?>"
                            data-status="1"
                            data-session="<?=$_SESSION["USERNAME"];?>"
                            data-toggle="modal" data-target="#CONFIRM_APPROVE"><font color="black"><b> รอจ่าย</b></font>
                        </a>  
                    <?php }else if($WDOAVG_ID!=""){ ?> 
                        <a href="#" data-toggle="modal" data-target="#DETAILPLANTOTAL_<?=$DTP?>"><font color="black"><b> จ่ายแล้ว</b></font></a>  
                    <?php } ?>  
                </td> -->
                <td style="text-align: center;"><?=$RSREFUEL?></td>
                <td style="text-align: center;"><?=$OBLNB?></td>
                <td style="text-align: center;"><?=$EMP?></td>
                <td style="text-align: left;"><?=$EMPN?></td>
                <td style="text-align: center;"><?=$VHCRG?></td>
                <td style="text-align: center;"><?=$VHCTN?></td>
                <!-- <td style="text-align: center;">[<?=$CALDTE?>] [<?=$CALOTG2?>] [<?=$DIFFOIL2?>] [<?=$CALPRICE?>]</td> -->
                <td style="text-align: center;"><?=$VHCTPLAN?></td>
                <td style="text-align: center;"><?=$JOBSTART?></td>
                <td style="text-align: center;"><?=$JOBEND?></td>
                <td style="text-align: center;"><?=$MST?></td>
                <td style="text-align: center;"><?=$MLE?></td>
                <td style="text-align: center;"><?=$CALDTE?></td>
                <td style="text-align: center;"><?=$OAM?></td>
                <td style="text-align: center;"><?=$OAVG?></td>
                <td style="text-align: center;"><?=$RSCHKWORKAVG?></td>
                <td style="text-align: center;"><?=number_format($CALOTG, 2)?></td>
                <td style="text-align: center;"><?=number_format($DIFFOIL, 2)?></td>
                <td style="text-align: center;"><?=number_format($CALPRICE, 2)?></td>
                <td style="text-align: center;"><?=$JNPLAN?></td>
                <td style="text-align: center;"><?=$CALROUND?></td>
                <td style="text-align: center;"><?=$CHKWORKIF?></td>
            </tr>                                                                
            <div class="modal fade" id="DETAILPLANTOTAL_<?=$DTP?>"><!-- data-backdrop="static" -->
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">รายละเอียด : <small><?=$JNPLAN?></small></h4>
                        </div>
                        <div class="modal-body">                                                                                
                            <div class="row">
                                <!-- <form name="form1" action="meg_cashoilaverage_save.php" target="_blank" method="post"> -->
                                <form id="fupForm" name="form1" method="post">
                                    <div class="col-lg-6">
                                        <p class="col-xl-6 text-muted"><b>วันที่เติมน้ำมัน : <?=$RSREFUEL?></b></p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="col-xl-6 text-muted"><b>รหัสพนักงาน : <?=$EMP?></b></p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="col-xl-6 text-muted"><b>เลขบิลน้ำมัน : <?=$OBLNB?></b></p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="col-xl-6 text-muted"><b>ชื่อ-สกุล : <?=$EMPN?></b></p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="col-xl-6 text-muted"><b>ทะเบียนรถ : <?=$VHCRG?></b></p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="col-xl-6 text-muted"><b>งานที่ขนส่ง : <?=$JOBEND?></b></p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="col-xl-6 text-muted"><b>ชื่อรถ : <?=$VHCTN?></b></p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="col-xl-6 text-muted"><b>ระยะทาง : <?=$CALDTE?></b></p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="col-xl-6 text-muted"><b>น้ำมันที่ใช้ : <?=$OAM?></b></p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="col-xl-6 text-muted"><b>จำนวนเงิน : <?=number_format($CALPRICE, 2)?></b></p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="col-xl-6 text-muted"><b>ผู้จ่ายเงิน : <?=$CONFIRM?></b></p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="col-xl-6 text-muted"><b>วันที่จ่ายเงิน : <?=$RSCAD?></b></p>
                                    </div>
                                </div>                                                                                    
                                <input type="hidden" name="WDOAVG_OAM" id="WDOAVG_OAM" value="<?=$OAM;?>">
                                <input type="hidden" name="WDOAVG_PRICE" id="WDOAVG_PRICE" value="<?=number_format($CALPRICE, 2);?>">
                                <input type="hidden" name="WDOAVG_DISTANCE" id="WDOAVG_DISTANCE" value="<?=$CALDTE;?>">
                                <input type="hidden" name="WDOAVG_PERSONCODE" id="WDOAVG_PERSONCODE" value="<?=$EMP;?>">
                                <input type="hidden" name="WDOAVG_PLANID" id="WDOAVG_PLANID" value="<?=$VHCTPPID;?>">
                                <input type="hidden" name="WDOAVG_OILTATID" id="WDOAVG_OILTATID" value="<?=$OILID;?>">
                                <input type="hidden" name="WDOAVG_OAVG" id="WDOAVG_OAVG" value="<?=$OAVG;?>">
                                <input type="hidden" name="WDOAVG_OAVGTG" id="WDOAVG_OAVGTG" value="<?=$OTG;?>">
                                <input type="hidden" name="WDOAVG_OILTG" id="WDOAVG_OILTG" value="<?=number_format($CALOTG, 2);?>">
                                <input type="hidden" name="WDOAVG_DIFFOIL" id="WDOAVG_DIFFOIL" value="<?=number_format($DIFFOIL, 2);?>">
                                <input type="hidden" name="WDOAVG_STATUS" id="WDOAVG_STATUS" value="1">
                                <input type="hidden" name="username" id="username" value="<?=$_SESSION["USERNAME"];?>">
                                <center>                               
                                        <div class="col-12">
                                            <!-- <button type="submit" class="btn btn-success btn-md" name="updatejob" onclick="updateoiltatsuno()" value="updatejob" id="butupdate">ยืนยันการจ่ายเงิน</button>&nbsp;&nbsp;&nbsp;&nbsp; -->
                                            <button type="button" class="btn btn-danger btn-md" data-dismiss="modal" onClick="javascript:location.reload();">ยกเลิก</button><!-- onClick="javascript:location.reload();" -->
                                        </div>
                                </center>   
                            </form>                                                                             
                        </div>
                    </div>
                </div>
            </div>
            <?php $DTP++; $i++; } ?>
        </tbody>
    </table>
<?php } ?>

<?php if ($_POST['txt_flg'] == "select_oilmonthavarage") { 
    $conditionEHR = " AND a.PersonID ='" . $_SESSION["EMPLOYEEID"] . "'";
    $sql_seEHR = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEHR = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($conditionEHR, SQLSRV_PARAM_IN)
    );
    $query_seEHR = sqlsrv_query($conn, $sql_seEHR, $params_seEHR);
    $result_seEHR = sqlsrv_fetch_array($query_seEHR, SQLSRV_FETCH_ASSOC);
                                                 
    date_default_timezone_set('Asia/Bangkok');
    $datestartoil=$_POST['datestartoilmonthavarage'];
    $dateendoil=$_POST['dateendoilmonthavarage'];
    
    $LINEOFWORK=$_POST['lineofworkmonth'];
    if($LINEOFWORK!=""){
        if($LINEOFWORK == 'CS'){
            $QUERYWHERE1="OTSN.JOBNO != '' AND EHR.PositionNameT LIKE '%CS%'";
        }else if($LINEOFWORK == 'TTKN'){
            $QUERYWHERE1="OTSN.JOBNO != '' AND EHR.PositionNameT LIKE '%T-Tohken%'";
        }else if($LINEOFWORK == 'STM'){
            $QUERYWHERE1="OTSN.JOBNO != '' AND EHR.PositionNameT LIKE '%STM%'";
        }else if($LINEOFWORK == 'KBT'){
            $QUERYWHERE1="OTSN.JOBNO != '' AND EHR.PositionNameT LIKE '%KUBOTA%'";
        }else if($LINEOFWORK == 'TTDK'){
            $QUERYWHERE1="OTSN.JOBNO != '' AND EHR.PositionNameT LIKE '%TGT%'";
        }else if($LINEOFWORK == 'SC10'){
            $QUERYWHERE1="OTSN.JOBNO != '' AND EHR.PositionNameT LIKE '%พนักงานขับรถ%' AND EHR.Company_Code = 'RKR' AND NOT EHR.PositionNameT IN ('พนักงานขับรถ/CS','พนักงานขับรถ/RKL-STC')";
        }else if($LINEOFWORK == 'SCCL'){
            $QUERYWHERE1="OTSN.JOBNO != '' AND EHR.PositionNameT LIKE '%พนักงานขับรถ/RKL-STC%' AND EHR.Company_Code = 'RKL' ";
        }else if($LINEOFWORK == 'OTHER'){
            $QUERYWHERE1="OTSN.JOBNO != '' AND NOT EHR.PositionNameT LIKE '%พนักงานขับรถ%' AND NOT EHR.PositionNameT LIKE '%KUBOTA%' ";
        }
    }else{
        $QUERYWHERE1="OTSN.JOBNO != ''";
    }

    $date1 = $datestartoil;
    $start = explode("/", $date1);
    $startd = $start[0];
    $startif = $start[1];        
        if($startif=='01'){
            $selectmonth = "มกราคม";
            $selectmonthstart = "ม.ค.";
        }else if($startif=='02'){
            $selectmonth = "กุมภาพันธ์";
            $selectmonthstart = "ก.พ.";
        }else if($startif=='03'){
            $selectmonth = "มีนาคม";
            $selectmonthstart = "มี.ค.";
        }else if($startif=='04'){
            $selectmonth = "เมษายน";
            $selectmonthstart = "เม.ย.";
        }else if($startif=='05'){
            $selectmonth = "พฤษภาคม";
            $selectmonthstart = "พ.ค.";
        }else if($startif=='06'){
            $selectmonth = "มิถุนายน";
            $selectmonthstart = "มิ.ย.";
        }else if($startif=='07'){
            $selectmonth = "กรกฎาคม";
            $selectmonthstart = "ก.ค.";
        }else if($startif=='08'){
            $selectmonth = "สิงหาคม";
            $selectmonthstart = "ส.ค.";
        }else if($startif=='09'){
            $selectmonth = "กันยายน";
            $selectmonthstart = "ก.ย.";
        }else if($startif=='10'){
            $selectmonth = "ตุลาคม";
            $selectmonthstart = "ต.ค.";
        }else if($startif=='11'){
            $selectmonth = "พฤศจิกายน";
            $selectmonthstart = "พ.ย.";
        }else if($startif=='12'){
            $selectmonth = "ธันวาคม";
            $selectmonthstart = "ธ.ค.";
        }
    $start_yen = $start[2];
    $start_yth = $start[2]+543;
    $start_ymd = $start[2].'-'.$start[1].'-'.$start[0];

    $date2 = $dateendoil;
    $end = explode("/", $date2);
    $endd = $end[0];
    $endif = $end[1];            
        if($startif=='01'){
            $selectmonth = "มกราคม";
            $selectmonthend = "ม.ค.";
        }else if($startif=='02'){
            $selectmonth = "กุมภาพันธ์";
            $selectmonthend = "ก.พ.";
        }else if($startif=='03'){
            $selectmonth = "มีนาคม";
            $selectmonthend = "มี.ค.";
        }else if($startif=='04'){
            $selectmonth = "เมษายน";
            $selectmonthend = "เม.ย.";
        }else if($startif=='05'){
            $selectmonth = "พฤษภาคม";
            $selectmonthend = "พ.ค.";
        }else if($startif=='06'){
            $selectmonth = "มิถุนายน";
            $selectmonthend = "มิ.ย.";
        }else if($startif=='07'){
            $selectmonth = "กรกฎาคม";
            $selectmonthend = "ก.ค.";
        }else if($startif=='08'){
            $selectmonth = "สิงหาคม";
            $selectmonthend = "ส.ค.";
        }else if($startif=='09'){
            $selectmonth = "กันยายน";
            $selectmonthend = "ก.ย.";
        }else if($startif=='10'){
            $selectmonth = "ตุลาคม";
            $selectmonthend = "ต.ค.";
        }else if($startif=='11'){
            $selectmonth = "พฤศจิกายน";
            $selectmonthend = "พ.ย.";
        }else if($startif=='12'){
            $selectmonth = "ธันวาคม";
            $selectmonthend = "ธ.ค.";
        }
    $end_yen = $end[2];
    $end_yth = $end[2]+543;
    $end_ymd = $end[2].'-'.$end[1].'-'.$end[0];
    // echo $datestartoil;
    // echo "<br>";
    // echo $dateendoil;
    // echo "<br>";
    // echo"<pre>";
    // print_r($_POST);
    // echo"</pre>";
    // exit();
    $DATESTART = str_replace('/', '-', $datestartoil);
    $CONVERTDATESTART = date("Y-m-d", strtotime($DATESTART) );
    // ECHO "<br>";
    $DATEEND = str_replace('/', '-', $dateendoil);
    $CONVERTDATEEND = date("Y-m-d", strtotime($DATEEND) );

    $EHR_PHC = $result_seEHR['PersonCode'];

?>
<table style="height: 70px;" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables_oilmonthavarage" role="grid" aria-describedby="dataTables-example_info" >
    <thead>
        <tr>
            <th style="text-align: center;width: 20px">ลำดับ</th>
            <th style="text-align: center;width: 110px">รหัสพนักงาน</th>
            <th style="text-align: center;width: 110px">ชื่อ-สกุล</th>
            <th style="text-align: center;width: 110px">จำนวนเที่ยว</th>
            <th style="text-align: center;width: 110px">ทะเบียนรถ</th>
            <th style="text-align: center;width: 120px">ปลายทาง</th>
            <th style="text-align: center;width: 100px">งานที่ขนส่ง</th>
            <th style="text-align: center;width: 80px">ไมล์ต้น</th>
            <th style="text-align: center;width: 80px">ไมล์ปลาย</th>
            <th style="text-align: center;width: 80px">ระยะทาง</th>
            <th style="text-align: center;width: 80px">น้ำมันที่ใช้</th>
            <th style="text-align: center;width: 120px">ค่าเฉลี่ยที่กำหนด</th>
            <th style="text-align: center;width: 110px">ค่าเฉลี่ยที่ได้</th>
            <th style="text-align: center;width: 110px">รวมเงิน</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $sql="SELECT
                    DISTINCT
                    OTSN.OILDATAID OILID,
                    CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                    OTSN.JOBNO JN1,
                    VHCTPP.EMPLOYEECODE1 EMP1,
                    VHCTPP.EMPLOYEENAME1 EMPN1,
                    EHR.PositionNameT,
                    CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) WORK,
                    OTSN.OIL_BILLNUMBER OBLNB,
                    OTSN.CARDNUMBER CNB,
                    OTSN.VEHICLEREGISNUMBER VHCRG,
                    OTSN.VEHICLETYPE VHCT,
                    VHCTPP.VEHICLETYPE VHCTPLAN,
                    VHCIF.ENERGY ENGY,
                    OTSN.OIL_AMOUNT OAM,
                    OTSN.MILEAGESTART MST,
                    OTSN.MILEAGEEND MLE,
                    OTSN.DISTANCE DTE,
                    OTSN.OIL_AVERAGE OAVG,
                    OTSN.OIL_TARGET OTG,
                    VHCTPP.C3,
                    VHCTPP.E1
                FROM TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN
                LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                LEFT JOIN EMPLOYEEEHR2 EHR ON EHR.PersonCode = VHCTPP.EMPLOYEECODE1
                WHERE OTSN.JOBNO IS NOT NULL
                AND VHCTPP.COMPANYCODE != 'RRC' AND VHCTPP.COMPANYCODE != 'RATC' AND VHCTPP.COMPANYCODE != 'RCC'
                AND $QUERYWHERE1
                AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) BETWEEN '$CONVERTDATESTART' AND '$CONVERTDATEEND'  
                UNION
                SELECT
                    DISTINCT
                    OTSN.OILDATAID OILID,
                    CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                    OTSN.JOBNO JN1,
                    VHCTPP.EMPLOYEECODE2 EMP1,
                    VHCTPP.EMPLOYEENAME2 EMPN1,
                    EHR.PositionNameT,
                    CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) WORK,
                    OTSN.OIL_BILLNUMBER OBLNB,
                    OTSN.CARDNUMBER CNB,
                    OTSN.VEHICLEREGISNUMBER VHCRG,
                    OTSN.VEHICLETYPE VHCT,
                    VHCTPP.VEHICLETYPE VHCTPLAN,
                    VHCIF.ENERGY ENGY,
                    OTSN.OIL_AMOUNT OAM,
                    OTSN.MILEAGESTART MST,
                    OTSN.MILEAGEEND MLE,
                    OTSN.DISTANCE DTE,
                    OTSN.OIL_AVERAGE OAVG,
                    OTSN.OIL_TARGET OTG,
                    VHCTPP.C3,
                    VHCTPP.E1
                FROM TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN
                LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                LEFT JOIN EMPLOYEEEHR2 EHR ON EHR.PersonCode = VHCTPP.EMPLOYEECODE2
                WHERE OTSN.JOBNO IS NOT NULL
                AND VHCTPP.COMPANYCODE != 'RRC' AND VHCTPP.COMPANYCODE != 'RATC' AND VHCTPP.COMPANYCODE != 'RCC'
                AND $QUERYWHERE1
                AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) BETWEEN '$CONVERTDATESTART' AND '$CONVERTDATEEND'  
                ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $i = 1;
                $result = sqlsrv_query($conn, $sql );  
                while($row = sqlsrv_fetch_array($result)) {                          
                    $OILID=$row["OILID"];         
                    $REFUEL=$row["REFUEL"];                             
                    $CRF = explode("-", $REFUEL);
                    $DT1 = $CRF[0];
                    $DT2 = $CRF[1];
                    $DT3 = $CRF[2]; 
                    $CONREFUEL = $DT3.'/'.$DT2.'/'.$DT1; 
                    $JN1=$row["JN1"];           
                    $EMP1=$row["EMP1"];        
                    $EMPN1=$row["EMPN1"];                 
                    $EMP2=$row["EMP2"];      
                    $EMPN2=$row["EMPN2"];   
                    $WORK=$row["WORK"];          
                    $OBLNB=$row["OBLNB"];   
                    $CNB=$row["CNB"]; 
                    $VHCRG=$row["VHCRG"];                  
                    $VHCT=$row["VHCT"];       
                    $VHCTPLAN=$row["VHCTPLAN"];                     
                    $ENGY=$row["ENGY"];                  
                    $OAM=$row["OAM"];                  
                    $MST=$row["MST"];                
                    $MLE=$row["MLE"];                  
                    $DTE=$row["DTE"];                       
                    $OAVG=$row["OAVG"];                     
                    $OTG=$row["OTG"];                 
                    $C3=$row["C3"];                   
                    $E1=$row["E1"];    
                    
                    $SQLCHKROUND="SELECT COUNT( VHCTPP.EMPLOYEECODE1 ) COUNTROUNDAMOUT FROM VEHICLETRANSPORTPLAN VHCTPP 
                    WHERE (VHCTPP.EMPLOYEECODE1 = '$EMP1' OR VHCTPP.EMPLOYEECODE2 = '$EMP1') AND CONVERT ( VARCHAR ( 10 ), VHCTPP.DATEWORKING, 20 ) = '$WORK' AND NOT STATUSNUMBER = 'X'";
                    $QUERYROUND = sqlsrv_query($conn, $SQLCHKROUND );  
                    // while($objResult = sqlsrv_fetch_array($querystmm)) {
                    $RESULTROUND = sqlsrv_fetch_array($QUERYROUND, SQLSRV_FETCH_ASSOC);
                    $CALROUND=$RESULTROUND["COUNTROUNDAMOUT"];

                    $stmm="SELECT
                        VHCTPPEMP.COMPANYCODE CMPNC,
                        VHCTPPEMP.CUSTOMERCODE CTMC,
                        VHCTPPEMP.JOBSTART JNST,
                        VHCTPPEMP.JOBEND JNED,
                        VHCTPPEMP.JOBNO JN2,
                        VHCTPPEMP.EMPLOYEECODE1 EMP1,
                        VHCTPPEMP.EMPLOYEENAME1 EMPN1,
                        VHCTPPEMP.EMPLOYEECODE2 EMP2,
                        VHCTPPEMP.EMPLOYEENAME2 EMPN2,
                        CONVERT (VARCHAR (10),VHCTPPEMP.DATEWORKING,20) WORK
                    FROM RTMS.dbo.VEHICLETRANSPORTPLAN VHCTPPEMP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPPEMP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    WHERE OTSN.JOBNO IS NOT NULL
                    AND (VHCTPPEMP.EMPLOYEECODE1 = '$EMP1' OR VHCTPPEMP.EMPLOYEECODE2 = '$EMP1')
                    AND CONVERT(VARCHAR (10),VHCTPPEMP.DATEWORKING,20) = '$WORK'";
                    $querystmm = sqlsrv_query($conn, $stmm );
                    // $resultvalue = sqlsrv_fetch_array($querystmm, SQLSRV_FETCH_ASSOC);                         
                    while($resultvalue = sqlsrv_fetch_array($querystmm)) { 
                        $JOBNOPLAN=$resultvalue["JN2"];  
                        $CMPNC=$resultvalue["CMPNC"];    
                        $CTMC=$resultvalue["CTMC"];           
                        $JNST=$resultvalue["JNST"];       
                        $JNED=$resultvalue["JNED"];   
                
                    $SQLCHKOAVG="SELECT DISTINCT OILAVERAGE.OILAVERAGE OAVR
                    FROM OILAVERAGE 
                    WHERE OILAVERAGE.COMPANYCODE = '$CMPNC'
                    AND OILAVERAGE.CUSTOMERCODE = '$CTMC'
                    AND OILAVERAGE.VEHICLETYPE = '$VHCTPLAN'";
                    $QUERYCHKOAVG = sqlsrv_query($conn, $SQLCHKOAVG );
                    while($RSCHKOAVG = sqlsrv_fetch_array($QUERYCHKOAVG)) { 
                        if ($VHCRG =='61-4454'||$VHCRG =='61-4456'||$VHCRG =='61-3440'||$VHCRG =='61-3441'||$VHCRG =='61-4453'||$VHCRG =='61-4457'||$VHCRG =='61-4912'||$VHCRG =='61-4913'||$VHCRG =='61-4546'||$VHCRG =='61-4547'||$VHCRG =='64-3452'||$VHCRG =='61-3445'||$VHCRG =='61-3439'||$VHCRG =='61-3443'||$VHCRG =='61-3834'||$VHCRG =='61-3835'||$VHCRG =='61-3438'||$VHCRG =='61-3437'||$VHCRG =='62-9288'||$VHCRG =='61-3836'||$VHCRG =='61-4458'||$VHCRG =='61-3444'||$VHCRG =='60-3868'||$VHCRG =='60-3870'||$VHCRG =='61-3437'||$VHCRG =='61-3452') {
                            $OAVR = 4.0;    
                        }else if($VHCRG =='60-3871'||$VHCRG =='61-3442'||$VHCRG =='60-2391'||$VHCRG =='61-3444'||$VHCRG =='76-8919'||$VHCRG =='61-4458'||$VHCRG =='79-2521'||$VHCRG =='79-2522'||$VHCRG =='79-2525'||$VHCRG =='74-5653'||$VHCRG =='74-5684'||$VHCRG =='74-5684'||$VHCRG =='74-5654') {
                            $OAVR = 3.5;  
                        }else{
                            $OAVR = $RSCHKOAVG["OAVR"];
                        }
                        // $OAVR=$RSCHKOAVG["OAVR"];

                        $RDTE=$row["DTE"];    $QRDTE=$QRDTE+$RDTE;       
                        $ROAM=$row["OAM"];    $QROAM=$QROAM+$ROAM;     
                        $ROTG=$RSCHKOAVG["OAVR"]; 
                        $QCALOAM=(($RDTE/$ROAM)-$ROTG);     
                        $QRCALOAM=$QRCALOAM+$QCALOAM;   
                        $RC3=$row["C3"];    $QRC3=$QRC3+$RC3;   
                        $arr[] = $row["OAVG"]; 

                        if($JN1==$JOBNOPLAN){
                            $RSCONREFUEL=$CONREFUEL;
                            $RSJOBOIL=$JN1;
                            $RSCNB=$CNB;
                            $RSVHCRG=$VHCRG;
                            $RSVHCT=$VHCT;
                            // $RSENGY=$ENGY;
                            $RSENGY='ดีเซล';
                            $RSOAM=number_format($OAM, 2);
                            $RSMST=$MST;
                            $RSMLE=$MLE;
                            $RSDTE=number_format($DTE, 2);
                            $RSOAVG=number_format($OAVG, 2);
                            $RSOTG=number_format($OAVR, 2);
                            $RSC3=$C3;
                            $CALOAM=(($DTE/$OAM)-$OAVR);
                            $RSCALOAM=number_format($CALOAM, 2);
                        }else{
                            $RSCONREFUEL="";
                            $RSJOBOIL="";
                            $RSCNB="";
                            $RSVHCRG="";
                            $RSVHCT="";
                            $RSENGY="";
                            $RSOAM="";
                            $RSMST="";
                            $RSMLE="";
                            $RSDTE="";
                            $RSOAVG="";
                            $RSOTG="";
                            $RSC3="";
                            $RSCALOAM="";
                        } 
        ?>
        <tr>
            <td align="center"><?=$i?></td>
            <td align="center"><?=$EMP1?></td>
            <td align="left"><?=$EMPN1?></td>
            <td align="center"><?=$CALROUND?></td>
            <td align="center"><?=$RSVHCRG;?></td>
            <td align="center"><?=$RSVHCT;?></td>
            <td align="center"><?=$JNED;?></td>
            <td align="right"><?=$RSMST;?></td>
            <td align="right"><?=$RSMLE;?></td>
            <td align="right"><?=$RSDTE;?></td>
            <td align="right"><?=$RSOAM;?></td>
            <td align="right"><?=$RSOTG;?></td>
            <td align="right"><?=$RSOAVG;?></td>
            <td align="right"><?=$RSC3;?></td>
        </tr>    
        <?php $i++; } } } ?>
    </tbody>
</table>
<?php } ?>
<?php
sqlsrv_close($conn);
?>

