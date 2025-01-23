<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");





if ($_POST['txt_flg'] == "select_compensation") {

    $conditionEHR = " AND a.PersonID ='" . $_SESSION["EMPLOYEEID"] . "'";
    $sql_seEHR = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEHR = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($conditionEHR, SQLSRV_PARAM_IN)
    );
    $query_seEHR = sqlsrv_query($conn, $sql_seEHR, $params_seEHR);
    $result_seEHR = sqlsrv_fetch_array($query_seEHR, SQLSRV_FETCH_ASSOC);
    ?>



    <table style="height: 70px;"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
      <thead>
        <tr role="row">
          <th style="text-align: center;width: 100px">ข้อมูลย่อย</th>
          <th style="text-align: center;width: 100px">ลบแผน</th>
          <th style="text-align: center;width: 100px">คัดลอกแผน</th>
          <th style="width: 100px">สถานะ</th>
          <th style="width: 100px">ขาไป/กลับ</th>
          <th style="width: 100px">วันที่</th>
          <th style="width: 100px">รอบที่</th>
          <th style="width: 100px">รหัสพนักงาน(1)</th>
          <th style="width: 200px">ชื่อ-นามสกุล(1)</th>
          <th style="width: 100px">รหัสพนักงาน(2)</th>
          <th style="width: 200px">ชื่อ-นามสกุล(2)</th>                  
          <th style="width: 100px">รหัสพนักงาน(3)</th>
          <th style="width: 200px">ชื่อ-นามสกุล(3)</th>
          <th style="width: 150px">เบอร์รถ/ทะเบียน</th>
          <th style="width: 200px">ต้นทาง</th>
          <th style="width: 200px">ปลายทาง</th>
          <th style="width: 200px">เลข JOB</th>
          <th style="width: 100px">ประเภทวัสดุ</th>
          <th style="width: 100px">เลขไมล์ต้น</th>
          <th style="width: 100px">เลขไมล์ปลาย</th>
          <th style="width: 100px">จำนวนน้ำมันที่เติม</th>
          <th style="width: 100px">ค่าเที่ยวคนที่1</th>
          <th style="width: 100px">ค่าเที่ยวคนที่2</th>
          <th style="width: 100px">ค่าเฉลี่ยน้ำมัน</th>
          <th style="width: 100px">ทำงานวันหยุด(กลับก่อน 13:00)</th>
          <th style="width: 100px">ทำงานวันหยุด(กลับหลัง 13:00)</th>


        </tr>
      </thead>
      <tbody>

        <?php
        if ($_SESSION["ROLENAME"] != "ADMIN" && $_SESSION["ROLENAME"] != "PLANNING(AMT)" && $_SESSION["ROLENAME"] != "PLANNING(GW)" && $_SESSION["ROLENAME"] != "OIL(GW)") {

          // $sql_seChkjob = "SELECT TOP 1 JOBNO,COMPANYCODE,CUSTOMERCODE,JOBSTART,JOBEND 
          // FROM VEHICLETRANSPORTPLAN WHERE (EMPLOYEECODE1 ='".$_SESSION["USERNAME"]."' OR EMPLOYEECODE2 ='".$_SESSION["USERNAME"]."')
          // AND CONVERT(DATE,DATERETURN) = CONVERT(DATE,GETDATE())
          // ORDER BY JOBNO DESC";
          // $params_seChkjob = array();
          // $query_seChkjob = sqlsrv_query($conn, $sql_seChkjob, $params_seChkjob);
          // $result_seChkjob = sqlsrv_fetch_array($query_seChkjob, SQLSRV_FETCH_ASSOC);

          // if ($result_seChkjob['COMPANYCODE'] == 'RRC' && $result_seChkjob['CUSTOMERCODE'] == 'TTTC' && $result_seChkjob['JOBSTART'] == 'TCR'  ) {
          //       $conditionemp11 = " AND (CONVERT(DATE,a.DATERETURN) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103))";

          //       if ($_POST['selsuccess'] == "0" || $_POST['selsuccess'] == "" || $_POST['selsuccess'] == "NULL") {
          //         $conditionemp12 = " AND (a.DOCUMENTCODE IS NULL OR a.DOCUMENTCODE = '')";
          //       } else {
          //         $conditionemp12 = " AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''";
          //       }
            
          // }else {
          //       $conditionemp11 = " AND (CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103))";

          //       if ($_POST['selsuccess'] == "0" || $_POST['selsuccess'] == "" || $_POST['selsuccess'] == "NULL") {
          //         $conditionemp12 = " AND (a.DOCUMENTCODE IS NULL OR a.DOCUMENTCODE = '')";
          //       } else {
          //         $conditionemp12 = " AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''";
          //       }
          // }
          $conditionemp11 = " AND (CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103))";

          if ($_POST['selsuccess'] == "0" || $_POST['selsuccess'] == "" || $_POST['selsuccess'] == "NULL") {
            $conditionemp12 = " AND (a.DOCUMENTCODE IS NULL OR a.DOCUMENTCODE = '')";
          } else {
            $conditionemp12 = " AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''";
          }


          $conditionemp13 = " AND (a.EMPLOYEECODE1 ='" . $result_seEHR['PersonCode'] . "' OR a.EMPLOYEECODE2 ='" . $result_seEHR['PersonCode'] . "')";
          $sql_seVehicletransportplan = "{call megVehicletransportplan_v2(?,?,?,?)}";
          $params_seVehicletransportplan = array(
          array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
          array($conditionemp11, SQLSRV_PARAM_IN),
          array($conditionemp12, SQLSRV_PARAM_IN),
          array($conditionemp13, SQLSRV_PARAM_IN)
          );
          $query_seVehicletransportplan = sqlsrv_query($conn, $sql_seVehicletransportplan, $params_seVehicletransportplan);
          while ($result_seVehicletransportplan = sqlsrv_fetch_array($query_seVehicletransportplan, SQLSRV_FETCH_ASSOC)) {




            if ($result_seVehicletransportplan['COMPANYCODE'] == 'RATC' || $result_seVehicletransportplan['COMPANYCODE'] == 'RCC' || $result_seVehicletransportplan['COMPANYCODE'] == 'RRC') {
              $condMileagestart = " AND VEHICLEREGISNUMBER = '" . $result_seVehicletransportplan['VEHICLEREGISNUMBER1'] . "' AND MILEAGETYPE = 'MILEAGESTART' AND JOBNO = '" . $result_seVehicletransportplan['JOBNO'] . "'";
              $condMileageend = " AND VEHICLEREGISNUMBER = '" . $result_seVehicletransportplan['VEHICLEREGISNUMBER1'] . "' AND MILEAGETYPE = 'MILEAGEEND' AND JOBNO = '" . $result_seVehicletransportplan['JOBNO'] . "'";
            } else {
              $condMileagestart = " AND VEHICLEREGISNUMBER = '" . $result_seVehicletransportplan['THAINAME'] . "' AND MILEAGETYPE = 'MILEAGESTART' AND JOBNO = '" . $result_seVehicletransportplan['JOBNO'] . "'";
              $condMileageend = " AND VEHICLEREGISNUMBER = '" . $result_seVehicletransportplan['THAINAME'] . "' AND MILEAGETYPE = 'MILEAGEEND' AND JOBNO = '" . $result_seVehicletransportplan['JOBNO'] . "'";
            }

            $sql_seMileagestart = "{call megMileage_v2(?,?)}";
            $params_seMileagestart = array(
            array('select_maxmileage', SQLSRV_PARAM_IN),
            array($condMileagestart, SQLSRV_PARAM_IN)
            );
            $query_seMileagestart = sqlsrv_query($conn, $sql_seMileagestart, $params_seMileagestart);
            $result_seMileagestart = sqlsrv_fetch_array($query_seMileagestart, SQLSRV_FETCH_ASSOC);


            $sql_seMileageend = "{call megMileage_v2(?,?)}";
            $params_seMileageend = array(
            array('select_maxmileage', SQLSRV_PARAM_IN),
            array($condMileageend, SQLSRV_PARAM_IN)
            );
            $query_seMileageend = sqlsrv_query($conn, $sql_seMileageend, $params_seMileageend);
            $result_seMileageend = sqlsrv_fetch_array($query_seMileageend, SQLSRV_FETCH_ASSOC);

            if ($result_seVehicletransportplan['DOCUMENTCODE'] == "") {

              if ($result_seVehicletransportplan['C8'] == "return") {
                $statusdoc = "<font style='color: green'>งานรับกลับ(unsuccess)</font> ";
              } else {
                $statusdoc = "<font style='color: red'>unsuccess</font> ";
              }
            } else {
              if ($result_seVehicletransportplan['C8'] == "return") {
                $statusdoc = "<font style='color: green'>งานรับกลับ(success)</font> ";
              } else {
                $statusdoc = "<font style='color: green'>success</font>";
              }
            }
            $sql_seConfrimskb = "SELECT JOBEND FROM CONFRIMSKB WHERE VEHICLETRANSPORTPLANID = '" . $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'] . "'
            AND KM = (SELECT MAX(KM) FROM CONFRIMSKB WHERE VEHICLETRANSPORTPLANID = '" . $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'] . "') ";

            $query_seConfrimskb = sqlsrv_query($conn, $sql_seConfrimskb, $params_seConfrimskb);
            $result_seConfrimskb = sqlsrv_fetch_array($query_seConfrimskb, SQLSRV_FETCH_ASSOC);
            $VAR_JOBEND = ($result_seVehicletransportplan['CUSTOMERCODE'] == 'SKB') ? $result_seConfrimskb['JOBEND'] : $result_seVehicletransportplan['JOBEND'];
            ?>
            <tr class="gradeX odd" role="row"
            <?php
            if ($result_seVehicletransportplan['ACTUALPRICE'] == '' || $result_seVehicletransportplan['ACTUALPRICE'] == '0.00') {
              ?>
              style="color: red"
              <?php
            }
            ?>
            >
            <td style="text-align: center;width: 100px;height: 55px">
              <?php
              if ($result_seVehicletransportplan['ACTUALPRICE'] == '' || $result_seVehicletransportplan['ACTUALPRICE'] == '0.00') {
                echo"-";
              } else {
                ?>
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-chevron-down"></i>
                  </button>
                  <ul class="dropdown-menu slidedown">


                    <?php
                    if ($result_seVehicletransportplan['COMPANYCODE'] == 'RRC') {
                      ?>
                      <li>
                        <a href="#" onclick="dirverdocaddrrc('<?= $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seVehicletransportplan1['COMPANYCODE'] ?>', '<?= $result_seVehicletransportplan['EMPLOYEECODE1'] ?>', '<?= $result_seVehicletransportplan['EMPLOYEENAME1'] ?>')" data-toggle="modal"  data-target="#modal_dirverdocrrc">เพิ่มค่าตอบแทน1</a>
                      </li>
                      <?php
                    } else if ($result_seVehicletransportplan['COMPANYCODE'] == 'RCC' || $result_seVehicletransportplan['COMPANYCODE'] == 'RATC') {
                      //if ($result_seVehicletransportplan['C2'] == "") {
                        ?>
                        <li>
                          <a href="#" onclick="dirverdocaddrrc('<?= $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seVehicletransportplan['COMPANYCODE'] ?>', '<?= $result_seVehicletransportplan['EMPLOYEECODE1'] ?>', '<?= $result_seVehicletransportplan['EMPLOYEENAME1'] ?>')" data-toggle="modal"  data-target="#modal_dirverdocrrc">เพิ่มค่าตอบแทน2</a>
                          <li>
                            <li class="divider"></li>
                            <!--<li>
                              <a href="#" onclick="jobreturn('<?//= $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'] ?>')" data-toggle="modal"  data-target="#modal_jobreturn">งานรับกลับ</a>
                              <li>-->
                                <?php
                                //} else {
                                  ?>
                                  <!--<li>
                                    <a href="#" onclick="jobreturn('<?//= $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'] ?>')" data-toggle="modal"  data-target="#modal_jobreturn">งานรับกลับ</a>
                                  </li> -->
                                  <?php
                                  //}
                                } else {
                                  ?>
                                  <li>
                                    <a href="#" onclick="dirverdocaddrrc('<?= $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seVehicletransportplan['COMPANYCODE'] ?>', '<?= $result_seVehicletransportplan['EMPLOYEECODE1'] ?>', '<?= $result_seVehicletransportplan['EMPLOYEENAME1'] ?>')" data-toggle="modal"  data-target="#modal_dirverdocrrc">เพิ่มค่าตอบแทน3</a>
                                  </li>
                                  <?php
                                }
                                ?>






                              </ul>
                            </div>
                            <?php
                          }
                          ?>

                        </td>
                        <!-- delete แผนงาน -->
                        <td style="text-align: center;">
                            <button onclick="delete_vehicletransportplan('<?= $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'] ?>');" title="ลบแผนการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="fa fa-times"></span></button>
                        </td>
                        <!-- copy แผนงาน -->
                        <?php
                        if ($result_seVehicletransportplan['COMPANYCODE'] == 'RCC' || $result_seVehicletransportplan['COMPANYCODE'] == 'RATC') {
                        ?>
                            <td style="text-align: center;">
                                <button title="COPY JOB" type="button" onclick="select_copyjob('<?= $result_seVehicletransportplan['JOBNO'] ?>', '<?= $result_seVehicletransportplan['JOBSTART'] ?>', '<?= $result_seVehicletransportplan['JOBEND'] ?>', '<?= $result_seVehicletransportplan['DATEVLIN'] ?>');" class="btn btn-default btn-circle" data-toggle="modal"  data-target="#modal_copyjob"><span class="fa fa-copy"></span></button>
                            </td>
                        <?php
                        }else{
                        ?>
                            
                            <td style="width: 100px"></td>
                        <?php
                        }
                        ?>

                        <td style="width: 100px"><?= $statusdoc ?></td>
                        <!-- ขาไป/กลับ -->
                        <?php
                        if ($result_seVehicletransportplan['COMPANYCODE'] == 'RCC' || $result_seVehicletransportplan['COMPANYCODE'] == 'RATC') {
                        ?>
                            <td style="width: 100px">
                                <select id="txt_goreturn_rccratc" name="txt_goreturn_rccratc" class="form-control"  onchange="edit_planrccratc(this.value,'<?= $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'] ?>','goreturn')" >
                                    <option value disabled selected hidden>(<?= ($result_seVehicletransportplan['C2'] == '0' || $result_seVehicletransportplan['C2'] == '' || $result_seVehicletransportplanadmin['C8'] == 'go') ? "ขาไป" : "ขาไป(มีรับกลับ)" ?>)</option>
                                    <option value="go">ขาไป</option>
                                    <option value="return">ขาไป(มีรับกลับ)</option>
                                </select> 
                            <!-- (<?= ($result_seVehicletransportplan['C2'] != '' || $result_seVehicletransportplan['C8'] == 'return') ? "ขากลับ" : "ขาไป" ?>) -->
                            </td>
                        <?php
                        }else{
                        ?>
                            <td style="width: 100px">(<?= ($result_seVehicletransportplan['C2'] != '' || $result_seVehicletransportplan['C8'] == 'return') ? "ขากลับ" : "ขาไป" ?>)</td>
                        <?php
                        }
                        ?>
                        
                        <?php
                            if ($result_seVehicletransportplan['COMPANYCODE'] == 'RRC') {
                                if ($result_seVehicletransportplan['CUSTOMERCODE'] == 'GMT') {
                          ?>
                                <td style="width: 100px"><?= $result_seVehicletransportplan['DATEDEALERIN1'] ?></td>
                          <?php
                                }else if ($result_seVehicletransportplan['CUSTOMERCODE'] == 'TTTC') {
                                    if ($result_seVehicletransportplan['JOBSTART'] = 'TCR') {
                                  ?>
                                  <td style="width: 100px"><?= $result_seVehicletransportplan['DATE_RETURN'] ?></td> 
                                  <?php
                                    }else{
                                    ?>
                                    <td style="width: 100px"><?= $result_seVehicletransportplan['DATE_VLIN'] ?></td> 
                                    <?php
                                    }
                                }else {
                                  ?>
                                    <td style="width: 100px"><?= $result_seVehicletransportplan['DATE_VLIN'] ?></td>
                                  <?php
                                }
                            }else if ($result_seVehicletransportplan['COMPANYCODE'] == 'RCC' || $result_seVehicletransportplan['COMPANYCODE'] == 'RATC'){
                              ?>
                              <td style="width: 100px"><input type="text" onchange="save_daterk(this.value,'<?= $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datedef2" id="txt_editdaterk" name="txt_editdaterk" value="<?= $result_seVehicletransportplan['DATEWORKING'] ?>"></td>
                              <?php
                            }else {
                            ?>
                                <td style="width: 100px"><?= $result_seVehicletransportplan['DATE_VLIN'] ?></td>
                            <?php 
                            }
                        ?>
                        <!-- จำนวนรอบวิ่งงาน -->
                        <?php
                        if ($result_seVehicletransportplan['COMPANYCODE'] == 'RKS'  && $result_seVehicletransportplan['CUSTOMERCODE'] == 'STM') {
                        ?>
                        
                            <td style="text-align:left"><input  style="width:60px;height:35px;font-size:12pt;text-align:center" type="button"  width="480" height="480"   id="btn_roundamount" name="btn_roundamount" class="btn btn-default" onclick ="open_modalstmeditround('<?= $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'] ?>');" value="<?= $result_seVehicletransportplan['ROUNDAMOUNT'] ?>"></td>
                            
                        <?php
                        }else if ($result_seVehicletransportplan['COMPANYCODE'] == 'RCC' || $result_seVehicletransportplan['COMPANYCODE'] == 'RATC') {
                        ?>
                            <td style="text-align:left">
                                <select id="txt_roundamount_rccratc" name="txt_roundamount_rccratc" class="form-control"  onchange="edit_planrccratc(this.value,'<?= $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'] ?>','roundamount')" >
                                    <option value disabled selected hidden>รอบที่ <?= $result_seVehicletransportplan['ROUNDAMOUNT'] ?></option>
                                    <option value="1">รอบที่ 1</option>
                                    <option value="2">รอบที่ 2</option>
                                    <option value="3">รอบที่ 3</option>
                                    <option value="4">รอบที่ 4</option>
                                </select>  
                            </td>
                            <!-- <td style="text-align:left"><input  style="width:60px;height:35px;font-size:12pt;text-align:center" type="button"  width="480" height="480"   id="btn_editplanrccratc" name="btn_editplanrccratc" class="btn btn-default" onclick ="open_modaleditplanrccratc('<?= $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'] ?>');" value="<?= $result_seVehicletransportplan['ROUNDAMOUNT'] ?>"></td> -->
                            
                        <?php
                        }else {
                        ?>
                        
                            <td style="width: 100px"><?= $result_seVehicletransportplan['ROUNDAMOUNT'] ?></td>
                        
                        <?php
                        }
                        ?>

                        <!-- <td style="width: 100px"><?= $result_seVehicletransportplan['EMPLOYEECODE1'] ?></td>
                        <td style="width: 200px"><?= $result_seVehicletransportplan['EMPLOYEENAME1'] ?></td>
                        <td style="width: 100px"><?= $result_seVehicletransportplan['EMPLOYEECODE2'] ?></td>
                        <td style="width: 200px"><?= $result_seVehicletransportplan['EMPLOYEENAME2'] ?></td> -->

                        <!-- พขร.3 แสดงเฉพาะ  SKB-->
                        <!-- <?php
                        if ($result_seVehicletransportplan['COMPANYCODE'] == 'RKL' && $result_seVehicletransportplan['CUSTOMERCODE'] == 'SKB') {
                        ?>
                            <td style="width: 100px"><?= $result_seVehicletransportplan['EMPLOYEECODE3'] ?></td>
                            <td style="width: 200px"><?= $result_seVehicletransportplan['EMPLOYEENAME3'] ?></td>
                        <?php
                        }else{
                        ?>
                            <td style="width: 100px"></td>
                            <td style="width: 200px"></td>
                        <?php
                        }
                        ?> -->

                        <?php if(($_SESSION["ROLENAME"] == "ADMIN")||($_SESSION["ROLENAME"] == "PLANNING(AMT)")||($_SESSION["ROLENAME"] == "PLANNING(GW)")||($_SESSION["ROLENAME"] == "TENKO(AMT)")||($_SESSION["ROLENAME"] == "TENKO(GW)")||($_SESSION["ROLENAME"] == "OIL(GW)")){ ?>
                            <td style="width: 100px"><a href="meg_transportcompensation_admincheck.php?PSC=<?= $result_seVehicletransportplanadmin['EMPLOYEECODE1'] ?>&DATE=<?=$_POST['datestart']?>" target="_blank"><?= $result_seVehicletransportplanadmin['EMPLOYEECODE1'] ?></a></td>
                            <td style="width: 200px"><a href="meg_transportcompensation_admincheck.php?PSC=<?= $result_seVehicletransportplanadmin['EMPLOYEECODE1'] ?>&DATE=<?=$_POST['datestart']?>" target="_blank"><?= $result_seVehicletransportplanadmin['EMPLOYEENAME1'] ?></a></td>
                            <td style="width: 100px"><a href="meg_transportcompensation_admincheck.php?PSC=<?= $result_seVehicletransportplanadmin['EMPLOYEECODE2'] ?>&DATE=<?=$_POST['datestart']?>" target="_blank"><?= $result_seVehicletransportplanadmin['EMPLOYEECODE2'] ?></a></td>
                            <td style="width: 200px"><a href="meg_transportcompensation_admincheck.php?PSC=<?= $result_seVehicletransportplanadmin['EMPLOYEECODE2'] ?>&DATE=<?=$_POST['datestart']?>" target="_blank"><?= $result_seVehicletransportplanadmin['EMPLOYEENAME2'] ?></a></td>

                            <!-- พขร.3 แสดงเฉพาะ  SKB-->
                            <?php
                            if ($result_seVehicletransportplanadmin['COMPANYCODE'] == 'RKL' && $result_seVehicletransportplanadmin['CUSTOMERCODE'] == 'SKB') {
                            ?>
                                <td style="width: 100px"><?= $result_seVehicletransportplanadmin['EMPLOYEECODE3'] ?></td>
                                <td style="width: 200px"><?= $result_seVehicletransportplanadmin['EMPLOYEENAME3'] ?></td>
                            <?php
                            }else{
                            ?>
                                <td style="width: 100px"></td>
                                <td style="width: 200px"></td>
                            <?php
                            }
                            ?>

                            <script>                                                                    
                                function checkoil(jobno){
                                    $.ajax({
                                        type: 'post',
                                        url: 'meg_data2.php',
                                        data: {
                                            txt_flg: "select_checkoil", 
                                            jobno: jobno
                                        },
                                        success: function (response) {
                                            if (response) {
                                                document.getElementById("divcheckoil").innerHTML = response;             
                                                // alert(vehicletransportplanid)
                                            }
                                        }
                                    });
                                }                                          
                                function notactioncaloavg(){
                                    $.ajax({
                                        type: 'post',
                                        url: 'manage_oil/manage_oil.php',
                                        data: {
                                            txt_flg: "notactioncaloavg",
                                            datestart: document.getElementById('txt_datestart').value, 
                                            dateend: document.getElementById('txt_dateend').value
                                        },
                                        success: function (response) {
                                            if (response) {
                                                document.getElementById("divnotactioncaloavg").innerHTML = response;             
                                                // alert(vehicletransportplanid)
                                            }
                                        }
                                    });
                                }
                            </script>
                        <?php }else{ ?>
                            <td style="width: 100px"><?= $result_seVehicletransportplanadmin['EMPLOYEECODE1'] ?></td>
                            <td style="width: 200px"><?= $result_seVehicletransportplanadmin['EMPLOYEENAME1'] ?></td>
                            <td style="width: 100px"><?= $result_seVehicletransportplanadmin['EMPLOYEECODE2'] ?></td>
                            <td style="width: 200px"><?= $result_seVehicletransportplanadmin['EMPLOYEENAME2'] ?></td>
                            
                            <!-- พขร.3 แสดงเฉพาะ  SKB-->
                            <?php
                            if ($result_seVehicletransportplanadmin['COMPANYCODE'] == 'RKL' && $result_seVehicletransportplanadmin['CUSTOMERCODE'] == 'SKB') {
                            ?>
                                <td style="width: 100px"><?= $result_seVehicletransportplanadmin['EMPLOYEECODE3'] ?></td>
                                <td style="width: 200px"><?= $result_seVehicletransportplanadmin['EMPLOYEENAME3'] ?></td>
                            <?php
                            }else{
                            ?>
                                <td style="width: 100px"></td>
                                <td style="width: 200px"></td>
                            <?php
                            }
                            ?>
                        <?php } ?>
                        <!-- แก้ไขข้อมูลเบอร์รถ -->
                        <?php
                        if ($result_seVehicletransportplan['COMPANYCODE'] == 'RCC'  || $result_seVehicletransportplan['COMPANYCODE'] == 'RATC') {
                        ?>
                            <td style="width: 100px">
                                <input  type="button"     id="btn_thainame" name="btn_thainame" class="btn btn-default" onclick ="open_modalthainame('<?= $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'] ?>');" value="<?= str_replace("(4L)","",$result_seVehicletransportplan['THAINAME']); ?>">
                            </td>
                        <?php
                        }else{
                        ?>
                            <td style="width: 100px"><?= $result_seVehicletransportplan['THAINAME'] ?></td>
                        <?php
                        }
                        ?>
                        <!-- แก้ไขข้อมูลแผนงาน -->
                        <?php
                        if ($result_seVehicletransportplan['COMPANYCODE'] == 'RCC'  || $result_seVehicletransportplan['COMPANYCODE'] == 'RATC') {
                        ?>
                            <td style="width: 200px"><input  style="width:60px;height:35px;font-size:12pt;text-align:center" type="button"  width="480" height="480"   id="btn_editplanrccratc" name="btn_editplanrccratc" class="btn btn-default" onclick ="open_modaleditplanrccratc('<?= $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'] ?>','<?=$result_seVehicletransportplan['WORKTYPE']?>','<?=$result_seVehicletransportplan['JOBSTART']?>','<?=$VAR_JOBEND?>');" value="<?= $result_seVehicletransportplan['JOBSTART'] ?>"></td>
                        <?php
                        }else{
                        ?>
                            <td style="width: 200px"><?= $result_seVehicletransportplan['JOBSTART'] ?></td>
                        <?php
                        }
                        ?>
                        <td style="width: 200px"><?= $VAR_JOBEND ?></td>
                        <td style="width: 200px"><?= $result_seVehicletransportplan['JOBNO'] ?></td>
                        <td style="width: 100px"><?= $result_seVehicletransportplan['MATERIALTYPE'] ?></td>
                        <td style="width: 100px"><?= $result_seMileagestart['MAXMILEAGENUMBER'] ?></td>
                        <td style="width: 100px"><?= $result_seMileageend['MAXMILEAGENUMBER'] ?></td>
                        <td style="width: 100px"><?= $result_seVehicletransportplan['O4'] ?></td>

                        <td style="width: 100px"><?= $result_seVehicletransportplan['E1'] ?></td>
                        <td style="width: 100px"><?= $result_seVehicletransportplan['E2'] ?></td>

                        <td style="width: 100px"><?= ($result_seVehicletransportplan['C3']) ?></td>
                        <td style="width: 100px"><?= $result_seVehicletransportplan['C5'] ?></td>
                        <td style="width: 100px"><?= $result_seVehicletransportplan['C6'] ?></td>



                      </tr>



                      <?php
                    }
                  } else {
                    $condition21 = " AND (CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103))";
                    if ($_POST['selsuccess'] == "0" || $_POST['selsuccess'] == "" || $_POST['selsuccess'] == "NULL") {
                      $condition22 = " AND (a.DOCUMENTCODE IS NULL OR a.DOCUMENTCODE = '')";
                    } else {
                      $condition22 = " AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''";
                    }


                    $condition23 = "";
                    $sql_seVehicletransportplanadmin = "{call megVehicletransportplan_v2(?,?,?,?)}";
                    $params_seVehicletransportplanadmin = array(
                    array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
                    array($condition21, SQLSRV_PARAM_IN),
                    array($condition22, SQLSRV_PARAM_IN),
                    array($condition23, SQLSRV_PARAM_IN)
                    );
                    $query_seVehicletransportplanadmin = sqlsrv_query($conn, $sql_seVehicletransportplanadmin, $params_seVehicletransportplanadmin);
                    while ($result_seVehicletransportplanadmin = sqlsrv_fetch_array($query_seVehicletransportplanadmin, SQLSRV_FETCH_ASSOC)) {



                      if ($result_seVehicletransportplanadmin['COMPANYCODE'] == 'RATC' || $result_seVehicletransportplanadmin['COMPANYCODE'] == 'RCC' || $result_seVehicletransportplanadmin['COMPANYCODE'] == 'RRC') {
                        $condMileagestart = " AND VEHICLEREGISNUMBER = '" . $result_seVehicletransportplanadmin['VEHICLEREGISNUMBER1'] . "' AND MILEAGETYPE = 'MILEAGESTART' AND JOBNO = '" . $result_seVehicletransportplanadmin['JOBNO'] . "'";
                        $condMileageend = " AND VEHICLEREGISNUMBER = '" . $result_seVehicletransportplanadmin['VEHICLEREGISNUMBER1'] . "' AND MILEAGETYPE = 'MILEAGEEND' AND JOBNO = '" . $result_seVehicletransportplanadmin['JOBNO'] . "'";
                      } else {
                        $condMileagestart = " AND VEHICLEREGISNUMBER = '" . $result_seVehicletransportplanadmin['THAINAME'] . "' AND MILEAGETYPE = 'MILEAGESTART' AND JOBNO = '" . $result_seVehicletransportplanadmin['JOBNO'] . "'";
                        $condMileageend = " AND VEHICLEREGISNUMBER = '" . $result_seVehicletransportplanadmin['THAINAME'] . "' AND MILEAGETYPE = 'MILEAGEEND' AND JOBNO = '" . $result_seVehicletransportplanadmin['JOBNO'] . "'";
                      }
                      /*$sql_seMileagestart = "{call megMileage_v2(?,?)}";
                      $params_seMileagestart = array(
                      array('select_maxmileage', SQLSRV_PARAM_IN),
                      array($condMileagestart, SQLSRV_PARAM_IN)
                      );
                      $query_seMileagestart = sqlsrv_query($conn, $sql_seMileagestart, $params_seMileagestart);
                      $result_seMileagestart = sqlsrv_fetch_array($query_seMileagestart, SQLSRV_FETCH_ASSOC);


                      $sql_seMileageend = "{call megMileage_v2(?,?)}";
                      $params_seMileageend = array(
                      array('select_maxmileage', SQLSRV_PARAM_IN),
                      array($condMileageend, SQLSRV_PARAM_IN)
                      );
                      $query_seMileageend = sqlsrv_query($conn, $sql_seMileageend, $params_seMileageend);
                      $result_seMileageend = sqlsrv_fetch_array($query_seMileageend, SQLSRV_FETCH_ASSOC);*/

                      if ($result_seVehicletransportplanadmin['DOCUMENTCODE'] == "") {

                        if ($result_seVehicletransportplanadmin['C8'] == "return") {
                          $statusdoc = "<font style='color: green'>งานรับกลับ(unsuccess)</font> ";
                        } else {
                          $statusdoc = "<font style='color: red'>unsuccess</font> ";
                        }
                      } else {
                        if ($result_seVehicletransportplanadmin['C8'] == "return") {
                          $statusdoc = "<font style='color: green'>งานรับกลับ(success)</font> ";
                        } else {
                          $statusdoc = "<font style='color: green'>success</font>";
                        }
                      }

                      $sql_seConfrimskb = "SELECT JOBEND FROM CONFRIMSKB WHERE VEHICLETRANSPORTPLANID = '" . $result_seVehicletransportplanadmin['VEHICLETRANSPORTPLANID'] . "'
                      AND KM = (SELECT MAX(KM) FROM CONFRIMSKB WHERE VEHICLETRANSPORTPLANID = '" . $result_seVehicletransportplanadmin['VEHICLETRANSPORTPLANID'] . "') ";

                      $query_seConfrimskb = sqlsrv_query($conn, $sql_seConfrimskb, $params_seConfrimskb);
                      $result_seConfrimskb = sqlsrv_fetch_array($query_seConfrimskb, SQLSRV_FETCH_ASSOC);
                      $VAR_JOBEND = ($result_seVehicletransportplanadmin['CUSTOMERCODE'] == 'SKB') ? $result_seConfrimskb['JOBEND'] : $result_seVehicletransportplanadmin['JOBEND'];
                      ?>
                      <tr class="gradeX odd" role="row"
                      <?php
                      if ($result_seVehicletransportplanadmin['ACTUALPRICE'] == '' || $result_seVehicletransportplanadmin['ACTUALPRICE'] == '0.00') {
                        ?>
                        style="color: red"
                        <?php
                      }
                      ?>
                      >
                      <td style="text-align: center;width: 100px">
                        <?php
                        if ($result_seVehicletransportplanadmin['ACTUALPRICE'] == '' || $result_seVehicletransportplanadmin['ACTUALPRICE'] == '0.00') {
                          echo"-";
                        } else {
                          ?>
                          <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                              <i class="fa fa-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu slidedown">


                              <?php
                              if ($result_seVehicletransportplanadmin['COMPANYCODE'] == 'RRC') {
                                ?>
                                <li>
                                  <a href="#" onclick="dirverdocaddrrc('<?= $result_seVehicletransportplanadmin['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seVehicletransportplanadmin['COMPANYCODE'] ?>', '<?= $result_seVehicletransportplanadmin['EMPLOYEECODE1'] ?>', '<?= $result_seVehicletransportplanadmin['EMPLOYEENAME1'] ?>')" data-toggle="modal"  data-target="#modal_dirverdocrrc">เพิ่มค่าตอบแทน4</a>
                                </li>
                                <?php
                              } else if ($result_seVehicletransportplanadmin['COMPANYCODE'] == 'RCC' || $result_seVehicletransportplanadmin['COMPANYCODE'] == 'RATC') {
                                //if ($result_seVehicletransportplanadmin['C2'] == "") {
                                  ?>
                                  <li>
                                    <a href="#" onclick="dirverdocaddrrc('<?= $result_seVehicletransportplanadmin['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seVehicletransportplanadmin['COMPANYCODE'] ?>', '<?= $result_seVehicletransportplanadmin['EMPLOYEECODE1'] ?>', '<?= $result_seVehicletransportplanadmin['EMPLOYEENAME1'] ?>')" data-toggle="modal"  data-target="#modal_dirverdocrrc">เพิ่มค่าตอบแทน5</a>
                                  </li>
                                  <li class="divider"></li>
                                  <!--<li>
                                    <a href="#" onclick="jobreturn('<?//= $result_seVehicletransportplanadmin['VEHICLETRANSPORTPLANID'] ?>')" data-toggle="modal"  data-target="#modal_jobreturn">งานรับกลับ</a>
                                  </li>
                                -->
                                <?php
                                //} else {
                                  ?>
                                  <!--<li>
                                    <a href="#" onclick="jobreturn('<?//= $result_seVehicletransportplanadmin['VEHICLETRANSPORTPLANID'] ?>')" data-toggle="modal"  data-target="#modal_jobreturn">งานรับกลับ</a>
                                  </li> -->
                                  <?php
                                  //}
                                } else {
                                  ?>
                                  <li>
                                    <a href="#" onclick="dirverdocaddrrc('<?= $result_seVehicletransportplanadmin['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seVehicletransportplanadmin['COMPANYCODE'] ?>', '<?= $result_seVehicletransportplanadmin['EMPLOYEECODE1'] ?>', '<?= $result_seVehicletransportplanadmin['EMPLOYEENAME1'] ?>')" data-toggle="modal"  data-target="#modal_dirverdocrrc">เพิ่มค่าตอบแทน6</a>
                                  </li>
                                  <?php
                                }
                                ?>






                              </ul>
                            </div>

                            <?php
                          }
                          ?>
                        </td>
                        <!-- delete แผนงาน -->
                        <td style="text-align: center;">
                            <button onclick="delete_vehicletransportplan('<?= $result_seVehicletransportplanadmin['VEHICLETRANSPORTPLANID'] ?>');" title="ลบแผนการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="fa fa-times"></span></button>
                        </td>

                        <!-- copy แผนงาน -->
                        <?php
                        if ($result_seVehicletransportplanadmin['COMPANYCODE'] == 'RCC' || $result_seVehicletransportplanadmin['COMPANYCODE'] == 'RATC') {
                        ?>
                            <td style="text-align: center;">
                                <button title="COPY JOB" type="button" onclick="select_copyjob('<?= $result_seVehicletransportplanadmin['JOBNO'] ?>', '<?= $result_seVehicletransportplanadmin['JOBSTART'] ?>', '<?= $result_seVehicletransportplanadmin['JOBEND'] ?>', '<?= $result_seVehicletransportplanadmin['DATEVLIN'] ?>');" class="btn btn-default btn-circle" data-toggle="modal"  data-target="#modal_copyjob"><span class="fa fa-copy"></span></button>
                            </td>
                        <?php
                        }else{
                        ?>
                            <!--  -->
                            <td style="width: 100px"></td>
                        <?php
                        }
                        ?>
                        <td style="width: 100px"><?= $statusdoc ?></td>
                        <!-- ขาไป/กลับ -->
                        <?php
                        if ($result_seVehicletransportplanadmin['COMPANYCODE'] == 'RCC' || $result_seVehicletransportplanadmin['COMPANYCODE'] == 'RATC') {
                        ?>
                            <td style="width: 100px">
                                <select id="txt_goreturn_rccratc" name="txt_goreturn_rccratc" class="form-control"  onchange="edit_planrccratc(this.value,'<?= $result_seVehicletransportplanadmin['VEHICLETRANSPORTPLANID'] ?>','goreturn')" >
                                    <option value disabled selected hidden>(<?= ($result_seVehicletransportplanadmin['C2'] == '0' || $result_seVehicletransportplanadmin['C2'] == '' || $result_seVehicletransportplanadmin['C8'] == 'go') ? "ขาไป" : "ขาไป(มีรับกลับ)" ?>)</option>
                                    <option value="go">ขาไป</option>
                                    <option value="return">ขาไป(มีรับกลับ)</option>
                                </select> 
                            <!-- (<?= ($result_seVehicletransportplanadmin['C2'] != '' || $result_seVehicletransportplanadmin['C8'] == 'return') ? "ขากลับ" : "ขาไป" ?>) -->
                            </td>
                        <?php
                        }else{
                        ?>
                            <td style="width: 100px">(<?= ($result_seVehicletransportplanadmin['C2'] != '' || $result_seVehicletransportplanadmin['C8'] == 'return') ? "ขากลับ" : "ขาไป" ?>)</td>
                        <?php
                        }
                        ?>

                        <!-- แก้ไขวันที่ -->
                        <?php                           
                        if ($result_seVehicletransportplanadmin['COMPANYCODE'] == 'RRC' && $result_seVehicletransportplanadmin['CUSTOMERCODE'] == 'GMT') {
                        ?>
                        <td style="width: 100px"><?= $result_seVehicletransportplanadmin['DATEDEALERIN1'] ?></td>
                        <?php
                        }else if ($result_seVehicletransportplanadmin['COMPANYCODE'] == 'RCC' || $result_seVehicletransportplanadmin['COMPANYCODE'] == 'RATC'){
                            ?>
                            <td style="width: 100px"><input type="text" onchange="save_daterk(this.value,'<?= $result_seVehicletransportplanadmin['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datedef2" id="txt_editdaterk" name="txt_editdaterk" value="<?= $result_seVehicletransportplanadmin['DATEWORKING'] ?>"></td>
                            <?php
                        } else {
                        ?>
                        <td style="width: 100px"><?= $result_seVehicletransportplanadmin['DATE_VLIN'] ?></td>
                        <?php
                        }
                        ?>

                        <!-- จำนวนรอบวิ่งงาน -->
                        <?php
                        if ($result_seVehicletransportplanadmin['COMPANYCODE'] == 'RKS'  && $result_seVehicletransportplanadmin['CUSTOMERCODE'] == 'STM') {
                        ?>
                        
                            <td style="text-align:left"><input  style="width:60px;height:35px;font-size:12pt;text-align:center" type="button"  width="480" height="480"   id="btn_roundamount" name="btn_roundamount" class="btn btn-default" onclick ="open_modalstmeditround('<?= $result_seVehicletransportplanadmin['VEHICLETRANSPORTPLANID'] ?>');" value="<?= $result_seVehicletransportplanadmin['ROUNDAMOUNT'] ?>"></td>
                            
                        <?php
                        }else if ($result_seVehicletransportplanadmin['COMPANYCODE'] == 'RCC' || $result_seVehicletransportplanadmin['COMPANYCODE'] == 'RATC') {
                        ?>
                            <td style="text-align:left">
                                <select id="txt_roundamount_rccratc" name="txt_roundamount_rccratc" class="form-control"  onchange="edit_planrccratc(this.value,'<?= $result_seVehicletransportplanadmin['VEHICLETRANSPORTPLANID'] ?>','roundamount')" >
                                    <option value disabled selected hidden>รอบที่ <?= $result_seVehicletransportplanadmin['ROUNDAMOUNT'] ?></option>
                                    <option value="1">รอบที่ 1</option>
                                    <option value="2">รอบที่ 2</option>
                                    <option value="3">รอบที่ 3</option>
                                    <option value="4">รอบที่ 4</option>
                                </select>  
                            </td>
                            <!-- <td style="text-align:left"><input  style="width:60px;height:35px;font-size:12pt;text-align:center" type="button"  width="480" height="480"   id="btn_editplanrccratc" name="btn_editplanrccratc" class="btn btn-default" onclick ="open_modaleditplanrccratc('<?= $result_seVehicletransportplanadmin['VEHICLETRANSPORTPLANID'] ?>');" value="<?= $result_seVehicletransportplanadmin['ROUNDAMOUNT'] ?>"></td> -->
                            
                        <?php
                        }else {
                        ?>
                        
                            <td style="width: 100px"><?= $result_seVehicletransportplanadmin['ROUNDAMOUNT'] ?></td>
                        
                        <?php
                        }
                        ?>
                        
                        <?php if(($_SESSION["ROLENAME"] == "ADMIN")||($_SESSION["ROLENAME"] == "PLANNING(AMT)")||($_SESSION["ROLENAME"] == "PLANNING(GW)")||($_SESSION["ROLENAME"] == "TENKO(AMT)")||($_SESSION["ROLENAME"] == "TENKO(GW)")||($_SESSION["ROLENAME"] == "OIL(GW)")){ ?>
                                                                        <?php 
                            $DWK0=$result_seVehicletransportplanadmin["DATEWORKING_DB"];  
                            $STRDATE0 = str_replace('/', '-', $DWK0);
                            $realNEWDATE0 = date('d/m/Y', strtotime($STRDATE0));
                            // echo "dwk=".$realNEWDATE0;
                                                                        ?>
                            <td style="width: 100px"><a href="meg_transportcompensation_admincheck.php?PSC=<?= $result_seVehicletransportplanadmin['EMPLOYEECODE1'] ?>&DATE=<?=$realNEWDATE0?>" target="_blank"><?= $result_seVehicletransportplanadmin['EMPLOYEECODE1'] ?></a></td>
                            <td style="width: 200px"><a href="meg_transportcompensation_admincheck.php?PSC=<?= $result_seVehicletransportplanadmin['EMPLOYEECODE1'] ?>&DATE=<?=$realNEWDATE0?>" target="_blank"><?= $result_seVehicletransportplanadmin['EMPLOYEENAME1'] ?></a>
                              <div class="btn-group">
                                  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                      <i class="fa fa-chevron-down"></i>
                                  </button>
                                  <ul class="dropdown-menu slidedown">
                                      <li><a href="#" onclick="checkoil('<?=$result_seVehicletransportplanadmin['JOBNO'];?>')" data-toggle="modal"  data-target="#modal_checkoil">ตรวจสอบข้อมูลน้ำมัน<?=$result_seOilaverage['OILAVERAGE'];?></a></li>
                                  </ul>
                              </div>
                            </td>
                            <td style="width: 100px"><a href="meg_transportcompensation_admincheck.php?PSC=<?= $result_seVehicletransportplanadmin['EMPLOYEECODE2'] ?>&DATE=<?=$realNEWDATE0?>" target="_blank"><?= $result_seVehicletransportplanadmin['EMPLOYEECODE2'] ?></a></td>
                            <td style="width: 200px"><a href="meg_transportcompensation_admincheck.php?PSC=<?= $result_seVehicletransportplanadmin['EMPLOYEECODE2'] ?>&DATE=<?=$realNEWDATE0?>" target="_blank"><?= $result_seVehicletransportplanadmin['EMPLOYEENAME2'] ?></a></td>
                            <!-- พขร.3 แสดงเฉพาะ  SKB-->
                            <?php
                            if ($result_seVehicletransportplanadmin['COMPANYCODE'] == 'RKL' && $result_seVehicletransportplanadmin['CUSTOMERCODE'] == 'SKB') {
                            ?>
                                <td style="width: 100px"><?= $result_seVehicletransportplanadmin['EMPLOYEECODE3'] ?></td>
                                <td style="width: 200px"><?= $result_seVehicletransportplanadmin['EMPLOYEENAME3'] ?></td>
                            <?php
                            }else{
                            ?>
                                <td style="width: 100px"></td>
                                <td style="width: 200px"></td>
                            <?php
                            }
                            ?>

                        <?php }else{ ?>
                            <td style="width: 100px"><?= $result_seVehicletransportplanadmin['EMPLOYEECODE1'] ?></td>
                            <td style="width: 200px"><?= $result_seVehicletransportplanadmin['EMPLOYEENAME1'] ?></td>
                            <td style="width: 100px"><?= $result_seVehicletransportplanadmin['EMPLOYEECODE2'] ?></td>
                            <td style="width: 200px"><?= $result_seVehicletransportplanadmin['EMPLOYEENAME2'] ?></td>
                            <!-- พขร.3 แสดงเฉพาะ  SKB-->
                            <?php
                            if ($result_seVehicletransportplanadmin['COMPANYCODE'] == 'RKL' && $result_seVehicletransportplanadmin['CUSTOMERCODE'] == 'SKB') {
                            ?>
                                <td style="width: 100px"><?= $result_seVehicletransportplanadmin['EMPLOYEECODE3'] ?></td>
                                <td style="width: 200px"><?= $result_seVehicletransportplanadmin['EMPLOYEENAME3'] ?></td>
                            <?php
                            }else{
                            ?>
                                <td style="width: 100px"></td>
                                <td style="width: 200px"></td>
                            <?php
                            }
                            ?>
                        <?php } ?>
                        <!-- แก้ไขข้อมูลเบอร์รถ -->
                        <?php
                        if ($result_seVehicletransportplanadmin['COMPANYCODE'] == 'RCC'  || $result_seVehicletransportplanadmin['COMPANYCODE'] == 'RATC') {
                        ?>
                            <td style="width: 100px">
                                <input  type="button"     id="btn_thainame" name="btn_thainame" class="btn btn-default" onclick ="open_modalthainame('<?= $result_seVehicletransportplanadmin['VEHICLETRANSPORTPLANID'] ?>');" value="<?= str_replace("(4L)","",$result_seVehicletransportplanadmin['THAINAME']); ?>">
                            </td>
                        <?php
                        }else{
                        ?>
                            <td style="width: 100px"><?= $result_seVehicletransportplanadmin['THAINAME'] ?></td>
                        <?php
                        }
                        ?>
                        <!-- แก้ไขข้อมูลแผนงาน -->
                        <?php
                        if ($result_seVehicletransportplanadmin['COMPANYCODE'] == 'RCC'  || $result_seVehicletransportplanadmin['COMPANYCODE'] == 'RATC') {
                        ?>
                            <td style="width: 200px"><input  style="width:60px;height:35px;font-size:12pt;text-align:center" type="button"  width="480" height="480"   id="btn_editplanrccratc" name="btn_editplanrccratc" class="btn btn-default" onclick ="open_modaleditplanrccratc('<?= $result_seVehicletransportplanadmin['VEHICLETRANSPORTPLANID'] ?>','<?=$result_seVehicletransportplanadmin['WORKTYPE']?>','<?=$result_seVehicletransportplanadmin['JOBSTART']?>','<?=$VAR_JOBEND?>');" value="<?= $result_seVehicletransportplanadmin['JOBSTART'] ?>"></td>
                        <?php
                        }else{
                        ?>
                            <td style="width: 200px"><?= $result_seVehicletransportplanadmin['JOBSTART'] ?></td>
                        <?php
                        }
                        ?>
                        <td style="width: 200px"><?= $VAR_JOBEND ?></td>
                        <td style="width: 200px"><?= $result_seVehicletransportplanadmin['JOBNO'] ?></td>
                        <td style="width: 100px"><?= $result_seVehicletransportplanadmin['MATERIALTYPE'] ?></td>
                        <td style="width: 100px">-</td>
                        <td style="width: 100px">-</td>
                        <td style="width: 100px"><?= $result_seVehicletransportplanadmin['O4'] ?></td>

                        <td style="width: 100px"><?= $result_seVehicletransportplanadmin['E1'] ?></td>
                        <td style="width: 100px"><?= $result_seVehicletransportplanadmin['E2'] ?></td>

                        <td style="width: 100px"><?= ($result_seVehicletransportplanadmin['C3']) ?></td>

                        <td style="width: 100px"><?= $result_seVehicletransportplanadmin['C5'] ?></td>
                        <td style="width: 100px"><?= $result_seVehicletransportplanadmin['C6'] ?></td>




                      </tr>
                      <?php
                    }
                  }
                  ?>
                </tbody>
              </table>

              <?php
            }
if ($_POST['txt_flg'] == "select_tenko3emp1") {
    ?>


<?php
}      
?>
<?php
sqlsrv_close($conn);
?>
