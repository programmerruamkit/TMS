<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");





if ($_POST['txt_flg'] == "select_tenkotransport") {

  ?>
    <div class="row">
        <div class="col-lg-8">&nbsp;</div>
        <!-- <div class="col-lg-2" style="text-align: right">
            <input class="btn btn-default" type="button" style="background-color: red;border:solid 2px white" id="btn_srquotation" name="btn_srquotation" value=""><font style="color:red"> * ไม่พบราคาขนส่ง </font> 
        </div> -->
        <!-- <div class="col-lg-2" style="text-align: right">
            <input class="btn btn-default" type="button" style="background-color: black;border:solid 2px white" id="btn_srquotation" name="btn_srquotation" value=""><font style="color:black"> * ยังไม่ได้ตรวจ </font>
        </div> -->
        <!-- <div class="col-lg-2" style="text-align: right">
            <input class="btn btn-default" type="button" style="background-color: green;border:solid 2px white" id="btn_srquotation" name="btn_srquotation" value=""><font style="color:green"> * ตรวจเรียบร้อย </font> 
        </div> -->
    </div>
    <div class="row">&nbsp;</div>
    <div class="row">

        <div class="col-md-12" >
            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example_tenkotransport" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                        <tr>

                            <th style="text-align: center;width:5%" >จัดการ1</th>



                            <th style="text-align: center;width:15%">เลขที่งาน</th>
                            <th style="text-align: center;width:10%">ทะเบียน/ชื่อรถ</th>

                            <th style="text-align: center;width:15%">พนักงาน(1)</th>
                            <th style="text-align: center;width:15%">พนักงาน(2)</th>

                            <th style="text-align: center;width:10%">ต้นทาง</th>
                            <th style="text-align: center;width:10%">ปลายทาง</th>

                            <th style="text-align: center;width:5%">รายงานตัว</th>
                            <th style="text-align: center;width:5%">ทำงาน</th>

                            <th style="text-align: center;width:5%">เข้าวีแอล</th>
                            <th style="text-align: center;width:5%">ออกวีแอล</th>

                            <th style="text-align: center;width:5%">เข้าดีลเลอร์</th>
                            <th style="text-align: center;width:5%">กลับบริษัท</th>





                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $sql_seOps2 = "{call megVehicletransportplan_v2(?,?,?,?)}";

                        $condOps21 = " AND a.COMPANYCODE IN ('RKR','RKL','RKS')";
                        $condOps22 = " AND a.STATUSNUMBER = '1'";
                        $condOps23 = " AND CONVERT(DATE,DATEVLIN) BETWEEN CONVERT(DATE,DATEADD(DAY,-5,GETDATE())) AND CONVERT(DATE,GETDATE())";
                        $params_seOps2 = array(
                            array('select_tenkodatafortenkodocumentamata', SQLSRV_PARAM_IN),
                            array($condOps21, SQLSRV_PARAM_IN),
                            array($condOps22, SQLSRV_PARAM_IN),
                            array($condOps23, SQLSRV_PARAM_IN)
                        );



                        $i = 1;
                        $query_seOps2 = sqlsrv_query($conn, $sql_seOps2, $params_seOps2);
                        while ($result_seOps2 = sqlsrv_fetch_array($query_seOps2, SQLSRV_FETCH_ASSOC)) {

                            
                            ?>


                            <tr  <?php
                            if ($result_seOps2['ACTUALPRICE'] == '' || $result_seOps2['ACTUALPRICE'] == '0.00') {
                                ?>
                                    style="color: red"
                                    <?php
                                }  else {
                                    ?>
                                    style="color: black"
                                    <?php
                                }
                                ?>>


                                <td style="text-align: center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                            <i class="fa fa-chevron-down"></i>
                                        </button>
                                        <ul class="dropdown-menu slidedown" style="width: 300px">
                                            <?php
                                            if ($result_seOps2['ACTUALPRICE'] != "") {
                                                ?>
                                                <li>
                                                    รายงานตัวตรวจร่างกาย (เท็งโกะระหว่างทาง)
                                                    <!--<a tabindex="-1" href='#' onclick="save_tenkomaster('<?= $result_seOps2['VEHICLETRANSPORTPLANID'] ?>', '')" >รายงานตัวตรวจร่างกาย (เท็งโกะระหว่างทาง)</a>-->
                                                    <a tabindex="-1" href='#' onclick="save_tenkomaster2('<?= $result_seOps2['VEHICLETRANSPORTPLANID'] ?>', '', '<?= $result_seOps2['EMPLOYEECODE1'] ?>', '1')" ><?= $result_seOps2['EMPLOYEENAME1'] ?></a>
                                                    <a tabindex="-1" href='#' onclick="save_tenkomaster2('<?= $result_seOps2['VEHICLETRANSPORTPLANID'] ?>', '', '<?= $result_seOps2['EMPLOYEECODE2'] ?>', '2')" ><?= $result_seOps2['EMPLOYEENAME2'] ?></a>

                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    รายงานตัวตรวจร่างกาย (เท็งโกะเลิกงาน)
                                                    <!--<a tabindex="-1" href='#' onclick="save_tenkomaster('<?= $result_seOps2['VEHICLETRANSPORTPLANID'] ?>', '')" >รายงานตัวตรวจร่างกาย (เท็งโกะเลิกงาน)</a>-->
                                                    <a tabindex="-1" href='#' onclick="save_tenkomaster2('<?= $result_seOps2['VEHICLETRANSPORTPLANID'] ?>', '', '<?= $result_seOps2['EMPLOYEECODE1'] ?>', '1')" ><?= $result_seOps2['EMPLOYEENAME1'] ?></a>
                                                    <a tabindex="-1" href='#' onclick="save_tenkomaster2('<?= $result_seOps2['VEHICLETRANSPORTPLANID'] ?>', '', '<?= $result_seOps2['EMPLOYEECODE2'] ?>', '2')" ><?= $result_seOps2['EMPLOYEENAME2'] ?></a>

                                                </li>


                                                <?php
                                            } else {
                                                ?>
                                                <li>-</li>
                                                <?php
                                            }
                                            ?>







                                        </ul>
                                    </div>

                                </td>




                                <td ><?= $result_seOps2['JOBNO'] ?></td>
                                <td ><?= $result_seOps2['THAINAME'] ?></td>
                                <td ><?= ($result_seOps2['EMPLOYEENAME1']) ? $result_seOps2['EMPLOYEENAME1'] . '(' . $result_seOps2['EMPLOYEECODE1'] . ')' : '' ?> </td>
                                <td ><?= ($result_seOps2['EMPLOYEENAME2']) ? $result_seOps2['EMPLOYEENAME2'] . '(' . $result_seOps2['EMPLOYEECODE2'] . ')' : '' ?></td>
                                <td><?= $result_seOps2['JOBSTART'] ?></td>
                                <td><?= $result_seOps2['JOBEND'] ?></td>
                                <td><?= $result_seOps2['DATEPRESENT'] ?></td>
                                <td><?= $result_seOps2['DATERK'] ?></td>
                                <td><?= $result_seOps2['DATEVLIN'] ?></td>
                                <td><?= $result_seOps2['DATEVLOUT'] ?></td>
                                <td><?= $result_seOps2['DATEDEALERIN'] ?></td>
                                <td><?= $result_seOps2['DATERETURN'] ?></td>




                            </tr>
                            <?php
                            $i++;
                        }
                        ?>

                    </tbody>
                </table>

            </div>
        </div>

        <!-- /.panel-body -->
    </div>


  <?php
 }
 if ($_POST['txt_flg'] == "select_tenkoafter") {

    ?>
    <div class="row">
        <div class="col-lg-8">&nbsp;</div>
        <div class="col-lg-2" style="text-align: right">
            <input class="btn btn-default" type="button" style="background-color: red;border:solid 2px white" id="btn_srquotation" name="btn_srquotation" value=""><font style="color:red"> * แผนงานไม่มีราคา </font> 
        </div>
        <div class="col-lg-2" style="text-align: right">
            <input class="btn btn-default" type="button" style="background-color: #FF8F00;border:solid 2px white" id="btn_srquotation" name="btn_srquotation" value=""><font style="color:#FF8F00"> * แผนงานตัดงาน  </font>
        </div>
        <!-- <div class="col-lg-2" style="text-align: right">
            <input class="btn btn-default" type="button" style="background-color: black;border:solid 2px white" id="btn_srquotation" name="btn_srquotation" value=""><font style="color:black"> * ยังไม่ได้ตรวจ </font>
        </div> -->
        <!-- <div class="col-lg-2" style="text-align: right">
            <input class="btn btn-default" type="button" style="background-color: green;border:solid 2px white" id="btn_srquotation" name="btn_srquotation" value=""><font style="color:green"> * ตรวจเรียบร้อย </font> 
        </div> -->
    </div>
    <div class="row">&nbsp;</div>
    <div class="row">

        <div class="col-md-12" >
            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example_tenkoafter" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                        <tr>

                            <th style="text-align: center;width:5%" >จัดการ1</th>



                            <th style="text-align: center;width:15%">เลขที่งาน</th>
                            <th style="text-align: center;width:10%">ทะเบียน/ชื่อรถ</th>

                            <th style="text-align: center;width:15%">พนักงาน(1)</th>
                            <th style="text-align: center;width:15%">พนักงาน(2)</th>

                            <th style="text-align: center;width:10%">ต้นทาง</th>
                            <th style="text-align: center;width:10%">ปลายทาง</th>

                            <th style="text-align: center;width:5%">รายงานตัว</th>
                            <th style="text-align: center;width:5%">ทำงาน</th>

                            <th style="text-align: center;width:5%">เข้าวีแอล</th>
                            <th style="text-align: center;width:5%">ออกวีแอล</th>

                            <th style="text-align: center;width:5%">เข้าดีลเลอร์</th>
                            <th style="text-align: center;width:5%">กลับบริษัท</th>





                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $sql_seOps3 = "{call megVehicletransportplan_v2(?,?,?,?)}";

                        $condOps31 = " AND a.COMPANYCODE IN ('RKR','RKL','RKS') ";
                        $condOps32 = " AND a.STATUSNUMBER IN ('T','X')";
                        $condOps33 = " AND CONVERT(DATE,DATEVLIN) BETWEEN CONVERT(DATE,DATEADD(DAY,-5,GETDATE())) AND CONVERT(DATE,GETDATE())";
                        $params_seOps3 = array(
                            array('select_tenkodatafortenkodocumentamata', SQLSRV_PARAM_IN),
                            array($condOps31, SQLSRV_PARAM_IN),
                            array($condOps32, SQLSRV_PARAM_IN),
                            array($condOps33, SQLSRV_PARAM_IN)
                        );



                        $i = 1;
                        $query_seOps3 = sqlsrv_query($conn, $sql_seOps3, $params_seOps3);
                        while ($result_seOps3 = sqlsrv_fetch_array($query_seOps3, SQLSRV_FETCH_ASSOC)) {
                            
                            ?>


                            <tr 
                        <?php
                        if ( $result_seOps3['ACTUALPRICE'] == '0.00'  || $result_seOps3['ACTUALPRICE'] == '0'  || $result_seOps3['ACTUALPRICE'] == '') {
                        ?>
                                style="color: red"
                        <?php
                        }if ($result_seOps3['STATUSNUMBER'] == 'X' ) {
                        ?>
                            style="color: #FF8F00"
                        <?php
                        } else {
                        ?>
                            style="color: black"
                        <?php
                        }
                        ?>>


                                <td style="text-align: center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                            <i class="fa fa-chevron-down"></i>
                                        </button>
                                        <ul class="dropdown-menu slidedown" style="width: 300px">
                                            <?php
                                            if ($result_seOps3['ACTUALPRICE'] != "") {
                                                ?>
                                                <li>
                                                    <!--<a tabindex="-1" href='#' onclick="save_tenkomaster('<?//= $result_seOps3['VEHICLETRANSPORTPLANID'] ?>', '',)" >รายงานตัวตรวจร่างกาย</a>-->
                                                    <a tabindex="-1" href='#' onclick="save_tenkomaster2('<?= $result_seOps3['VEHICLETRANSPORTPLANID'] ?>', '', '<?= $result_seOps3['EMPLOYEECODE1'] ?>', '1')" ><?= $result_seOps3['EMPLOYEENAME1'] ?></a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a tabindex="-1" href='#' onclick="save_tenkomaster2('<?= $result_seOps3['VEHICLETRANSPORTPLANID'] ?>', '', '<?= $result_seOps3['EMPLOYEECODE2'] ?>', '2')" ><?= $result_seOps3['EMPLOYEENAME2'] ?></a>
                                                </li>


                                                <?php
                                            } else {
                                                ?>
                                                <li>-</li>
                                                <?php
                                            }
                                            ?>







                                        </ul>
                                    </div>

                                </td>




                                <td ><?= $result_seOps3['JOBNO'] ?></td>

                                <td ><?= $result_seOps3['THAINAME'] ?></td>
                                <td ><?= ($result_seOps3['EMPLOYEENAME1']) ? $result_seOps3['EMPLOYEENAME1'] . '(' . $result_seOps3['EMPLOYEECODE1'] . ')' : '' ?> </td>
                                <td ><?= ($result_seOps3['EMPLOYEENAME2']) ? $result_seOps3['EMPLOYEENAME2'] . '(' . $result_seOps3['EMPLOYEECODE2'] . ')' : '' ?></td>
                                <td><?= $result_seOps3['JOBSTART'] ?></td>
                                <td><?= $result_seOps3['JOBEND'] ?></td>
                                <td><?= $result_seOps3['DATEPRESENT'] ?></td>
                                <td><?= $result_seOps3['DATERK'] ?></td>
                                <td><?= $result_seOps3['DATEVLIN'] ?></td>
                                <td><?= $result_seOps3['DATEVLOUT'] ?></td>
                                <td><?= $result_seOps3['DATEDEALERIN'] ?></td>
                                <td><?= $result_seOps3['DATERETURN'] ?></td>




                            </tr>
                            <?php
                            $i++;
                        }
                        ?>

                    </tbody>
                </table>

            </div>
        </div>

        
    </div>
  
    <?php
   }
   if ($_POST['txt_flg'] == "select_tenkoclosejob") {
  
      ?>
        <div class="row">
            <div class="col-lg-8">&nbsp;</div>
            <!-- <div class="col-lg-2" style="text-align: right">
                <input class="btn btn-default" type="button" style="background-color: red;border:solid 2px white" id="btn_srquotation" name="btn_srquotation" value=""><font style="color:red"> * ไม่พบราคาขนส่ง </font> 
            </div> -->
            <!-- <div class="col-lg-2" style="text-align: right">
                <input class="btn btn-default" type="button" style="background-color: black;border:solid 2px white" id="btn_srquotation" name="btn_srquotation" value=""><font style="color:black"> * ยังไม่ได้ปิดงาน </font>
            </div> -->
            <!-- <div class="col-lg-2" style="text-align: right">
                <input class="btn btn-default" type="button" style="background-color: green;border:solid 2px white" id="btn_srquotation" name="btn_srquotation" value=""><font style="color:green"> * ปิดงานเรียบร้อย </font> 
            </div> -->
        </div>
        <div class="row">&nbsp;</div>
        <div class="row">

            <div class="col-md-12" >
                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example_tenkoclosejob" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                        <thead>
                            <tr>

                                <th style="text-align: center;width:5%" >จัดการ1</th>



                                <th style="text-align: center;width:15%">เลขที่งาน</th>
                                <th style="text-align: center;width:10%">ทะเบียน/ชื่อรถ</th>

                                <th style="text-align: center;width:15%">พนักงาน(1)</th>
                                <th style="text-align: center;width:15%">พนักงาน(2)</th>

                                <th style="text-align: center;width:10%">ต้นทาง</th>
                                <th style="text-align: center;width:10%">ปลายทาง</th>

                                <th style="text-align: center;width:5%">รายงานตัว</th>
                                <th style="text-align: center;width:5%">ทำงาน</th>

                                <th style="text-align: center;width:5%">เข้าวีแอล</th>
                                <th style="text-align: center;width:5%">ออกวีแอล</th>

                                <th style="text-align: center;width:5%">เข้าดีลเลอร์</th>
                                <th style="text-align: center;width:5%">กลับบริษัท</th>





                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $sql_seOps4 = "{call megVehicletransportplan_v2(?,?,?,?)}";

                            $condOps41 = " AND a.COMPANYCODE IN ('RKR','RKL','RKS') ";
                            $condOps42 = " AND a.STATUSNUMBER = '2'";
                            $condOps43 = " AND CONVERT(DATE,a.DATEVLIN,103) BETWEEN CONVERT(DATE,DATEADD(DAY,-4,GETDATE()),103) AND CONVERT(DATE,DATEADD(DAY,4,GETDATE()),103)";
                            $params_seOps4 = array(
                                array('select_tenkodatafortenkodocumentamata', SQLSRV_PARAM_IN),
                                array($condOps41, SQLSRV_PARAM_IN),
                                array($condOps42, SQLSRV_PARAM_IN),
                                array($condOps43, SQLSRV_PARAM_IN)
                            );



                            $i = 1;
                            $query_seOps4 = sqlsrv_query($conn, $sql_seOps4, $params_seOps4);
                            while ($result_seOps4 = sqlsrv_fetch_array($query_seOps4, SQLSRV_FETCH_ASSOC)) {

                                
                                ?>


                                <tr <?php
                            if ($result_seOps4['ACTUALPRICE'] == '' || $result_seOps4['ACTUALPRICE'] == '0.00') {
                                    ?>
                                        style="color: red"
                                        <?php
                                    } else {
                                        ?>
                                        style="color: black"
                                        <?php
                                    }
                                    ?>>


                                    <td style="text-align: center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-chevron-down"></i>
                                            </button>
                                            <ul class="dropdown-menu slidedown" style="width: 300px">
                                                <?php
                                                if ($result_seOps4['ACTUALPRICE'] != "") {
                                                    ?>
                                                    <li>
                                                        <!--<a tabindex="-1" href='#' onclick="save_tenkomaster('<?= $result_seOps4['VEHICLETRANSPORTPLANID'] ?>', '')" >รายงานตัวตรวจร่างกาย</a>-->
                                                        <a tabindex="-1" href='#' onclick="save_tenkomaster2('<?= $result_seOps4['VEHICLETRANSPORTPLANID'] ?>', '', '<?= $result_seOps4['EMPLOYEECODE1'] ?>', '1')" ><?= $result_seOps4['EMPLOYEENAME1'] ?></a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a tabindex="-1" href='#' onclick="save_tenkomaster2('<?= $result_seOps4['VEHICLETRANSPORTPLANID'] ?>', '', '<?= $result_seOps4['EMPLOYEECODE2'] ?>', '2')" ><?= $result_seOps4['EMPLOYEENAME2'] ?></a>
                                                    </li>


                                                    <?php
                                                } else {
                                                    ?>
                                                    <li>-</li>
                                                    <?php
                                                }
                                                ?>







                                            </ul>
                                        </div>

                                    </td>




                                    <td ><?= $result_seOps4['JOBNO'] ?></td>

                                    <td ><?= $result_seOps4['THAINAME'] ?></td>
                                    <td ><?= ($result_seOps4['EMPLOYEENAME1']) ? $result_seOps4['EMPLOYEENAME1'] . '(' . $result_seOps4['EMPLOYEECODE1'] . ')' : '' ?> </td>
                                    <td ><?= ($result_seOps4['EMPLOYEENAME2']) ? $result_seOps4['EMPLOYEENAME2'] . '(' . $result_seOps4['EMPLOYEECODE2'] . ')' : '' ?></td>
                                    <td><?= $result_seOps4['JOBSTART'] ?></td>
                                    <td><?= $result_seOps4['JOBEND'] ?></td>
                                    <td><?= $result_seOps4['DATEPRESENT'] ?></td>
                                    <td><?= $result_seOps4['DATERK'] ?></td>
                                    <td><?= $result_seOps4['DATEVLIN'] ?></td>
                                    <td><?= $result_seOps4['DATEVLOUT'] ?></td>
                                    <td><?= $result_seOps4['DATEDEALERIN'] ?></td>
                                    <td><?= $result_seOps4['DATERETURN'] ?></td>




                                </tr>
                                <?php
                                $i++;
                            }
                            ?>

                        </tbody>
                    </table>

                </div>
            </div>

            
        </div>
    
    
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
