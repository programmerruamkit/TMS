<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");





if ($_POST['txt_flg'] == "select_tenkotelcheckemp1") {

        // $conditionPlain = " AND a.VEHICLETRANSPORTPLANID = '" . $_POST['vehicletransportplanid'] . "'";
        // $sql_sePlain = "{call megVehicletransportplan_v2(?,?)}";
        // $params_sePlain = array(
        //     array('select_vehicletransportplan', SQLSRV_PARAM_IN),
        //     array($conditionPlain, SQLSRV_PARAM_IN)
        // );
        // $query_sePlain = sqlsrv_query($conn, $sql_sePlain, $params_sePlain);
        // $result_sePlain = sqlsrv_fetch_array($query_sePlain, SQLSRV_FETCH_ASSOC);

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

        // $conditionTenkomaster = " AND a.TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "'";
        // $sql_seTenkomaster = "{call megEdittenkomaster_v2(?,?)}";
        // $params_seTenkomaster = array(
        //     array('select_tenkomaster', SQLSRV_PARAM_IN),
        //     array($conditionTenkomaster, SQLSRV_PARAM_IN)
        // );
        // $query_seTenkomaster = sqlsrv_query($conn, $sql_seTenkomaster, $params_seTenkomaster);
        // $result_seTenkomaster = sqlsrv_fetch_array($query_seTenkomaster, SQLSRV_FETCH_ASSOC);

       
            $sql_seTelcheckD1 = "SELECT TELCHECKID AS 'COUNT',TELCHECKID,SELFCHECKID, VEHICLETRANSPORTPLANID,TENKOMASTERID,EMPLOYEECODE,
            CURRENTUSING_DATE,STOPUSING_DATE,ALLTIMEUSING,ALLTIMESLEEP,
            GROUP1,GROUP2,GROUP3,GROUP4,GROUP5,RANKDRIVER,REMARK
            FROM DRIVERTELCHECK 
            -- อันเดิมเช็ค planid ด้วย 
            -- แต่เจอปัญหากรณีมีหลาย  JOB
            -- อันใหม่ เช็คแค่ tenkomasterid เพราะ สามารถมีหลาย JOB(planid) ได้ แต่จะมี tenkomasterid ได้แค่ 1 ไอดี
            -- WHERE VEHICLETRANSPORTPLANID ='" . $_GET['vehicletransportplanid'] . "'
            WHERE TENKOMASTERID ='" . $result_seTenkomaster_temp['TENKOMASTERID'] . "'
            AND EMPLOYEECODE = '" . $_POST['employeecode1'] . "'";
            $query_seTelcheckD1 = sqlsrv_query($conn, $sql_seTelcheckD1, $params_seTelcheckD1);
            $result_seTelcheckD1 = sqlsrv_fetch_array($query_seTelcheckD1, SQLSRV_FETCH_ASSOC);   
            
            //เช็คข้อมูลจาก DATABASE
            // GROUP1 [A],[B]
            if($result_seTelcheckD1['GROUP1'] == 'A'){
                $rsgroup1AD1 = "checked";
            }else{
                $rsgroup1AD1 = "";
            }

            if($result_seTelcheckD1['GROUP1'] == 'B'){
                $rsgroup1BD1 = "checked";
            }else{
                $rsgroup1BD1 = "";
            }
            ///////////////////////////
            // GROUP2 [C],[D]
            if($result_seTelcheckD1['GROUP2'] == 'C'){
                $rsgroup2CD1 = "checked";
            }else{
                $rsgroup2CD1 = "";
            }
            
            if($result_seTelcheckD1['GROUP2'] == 'D'){
                $rsgroup2DD1 = "checked";
            }else{
                $rsgroup2DD1 = "";
            }
            ///////////////////////////
            // GROUP3 [E],[F]
            if($result_seTelcheckD1['GROUP3'] == 'E'){
                $rsgroup3ED1 = "checked";
            }else{
                $rsgroup3ED1 = "";
            }
            
            if($result_seTelcheckD1['GROUP3'] == 'F'){
                $rsgroup3FD1 = "checked";
            }else{
                $rsgroup3FD1 = "";
            }
             ///////////////////////////
            // GROUP3 [G],[H],[I]
            if($result_seTelcheckD1['GROUP4'] == 'G'){
                $rsgroup4GD1 = "checked";
            }else{
                $rsgroup4GD1 = "";
            }
            
            if($result_seTelcheckD1['GROUP4'] == 'H'){
                $rsgroup4HD1 = "checked";
            }else{
                $rsgroup4HD1 = "";
            }
            
            if($result_seTelcheckD1['GROUP4'] == 'I'){
                $rsgroup4ID1 = "checked";
            }else{
                $rsgroup4ID1 = "";
            }
            ///////////////////////////
            // GROUP3 [J],[K]
            if($result_seTelcheckD1['GROUP5'] == 'J'){
                $rsgroup5JD1 = "checked";
            }else{
                $rsgroup5JD1 = "";
            }
            
            if($result_seTelcheckD1['GROUP5'] == 'K'){
                $rsgroup5KD1 = "checked";
            }else{
                $rsgroup5KD1 = "";
            }
             ///////////////////////////
           
            //ใส่ สีใน TD ของแต่ละ RANK

            if ($result_seTelcheckD1['RANKDRIVER'] == 'ER') {
                $tdcolorD1 ="background-color: #349aff";
            }else if ($result_seTelcheckD1['RANKDRIVER'] == 'A'){
                $tdcolorD1 ="background-color: #ff3434";
            }else if ($result_seTelcheckD1['RANKDRIVER'] == 'B'){
                $tdcolorD1 ="background-color: #ffad33";
            }else if ($result_seTelcheckD1['RANKDRIVER'] == 'C'){
                $tdcolorD1 ="background-color: #ffff66";
            }else if ($result_seTelcheckD1['RANKDRIVER'] == 'D'){
                $tdcolorD1 ="background-color: #5cd65c";
            }else{
                $tdcolorD1 ="background-color: #ffffff";
            }
       
            ?>
            
            <div class="panel-body">
                <table  width="100%" style= "border-collapse: collapse;" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                    <thead>
                        <tr>
                            <th style="text-align: center;background-color: #349aff;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:20px"><b>Rank ER</b></th>
                            <th style="text-align: center;background-color: #ff3434;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:20px"><b>Rank A</b></th>
                            <th style="text-align: center;background-color: #ffad33;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:20px"><b>Rank B</b></th>
                            <th style="text-align: center;background-color: #ffff66;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:20px"><b>Rank C<b></th>
                            <th style="text-align: center;background-color: #5cd65c;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:20px"><b>Rank D</b></th>
                        </tr>
                        <tr>
                          
                            <th style="text-align: center;font-size:20px">เลือกข้อมูลไม่ถูกต้อง</th>
                            <th style="text-align: center;font-size:20px">(วิ่งงานไม่ได้)</th>
                            <th style="text-align: center;font-size:18px">(โทรติดตาม 6 ชั่วโมงแรก<br>หลังโหลดเสร็จหากขับขี่)</th>
                            <th style="text-align: center;font-size:18px">(โทรติดตาม 3 ชั่วโมงแรก<br>หลังโหลดเสร็จหากขับขี่)</th>
                            <th style="text-align: center;font-size:20px">(ผ่าน)</th>
                        </tr>
                    </thead>
                    
                    <!-- <thead>
                        <tr>
                            <th style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:18px"><b>Formula condition Rank ER</b></th>
                            <th style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:18px"><b>Formula condition Rank A</b></th>
                            <th style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:18px"><b>Formula condition Rank B</b></th>
                            <th style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:18px"><b>Formula condition Rank C<b></th>
                            <th style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:18px"><b>Formula condition Rank D</b></th>
                        </tr>
                        <tr>
                            <th style="text-align: left;font-size:14px">
                                Case1: ER จะแสดงกรณีเลือกข้อมูลไม่ถูกต้อง <br>
                                Case2: - 
                            </th>
                            <th style="text-align: left;font-size:18px">
                                Case1: [A]->[C]->[E]->[G]->[J] <br>
                                Case2: - 
                            </th>
                            <th style="text-align: left;font-size:18px">
                                Case1: [A]->[C]->[E]->[I] <br>
                                Case2: [B]
                            </th>
                            <th style="text-align: left;font-size:18px">
                                Case1: [A]->[C]->[E]->[G]->[K] <br>
                                Case2: [A]->[D]

                            </th>
                            <th style="text-align: left;font-size:18px">
                                Case1: [A]->[C]->[F] <br>
                                Case2: [A]->[C]->[E]->[H] 

                            </th>
                        </tr>
                    </thead> -->
                </table>
                <br>
                <table  width="100%" style= "border-collapse: collapse;" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                    <thead>
                        <tr>
                            <th style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;">ข้อ</th>
                            <th colspan ="2" style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;">หัวข้อ.1</th>
                            <th colspan ="2" style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;">หัวข้อ.2</th>
                            <th colspan ="2" style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;">หัวข้อ.3</th>
                            <th colspan ="2" style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;">หัวข้อ.4</th>
                            <th colspan ="2" style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;">หัวข้อ.5</th>
                        </tr>
                        <tr>
                            <th style="text-align: center">&nbsp;</th>
                            <th style="text-align: center;width:5%"></th>
                            <th style="text-align: center"></th>
                            <th style="text-align: center;width:5%"></th>
                            <th style="text-align: center"></th>
                            <th style="text-align: center;width:5%"></th>
                            <th style="text-align: center"></th>
                            <th style="text-align: center;width:5%"></th>
                            <th style="text-align: center"></th>
                            <th style="text-align: center;width:5%"></th>
                            <th style="text-align: center"></th>
                        </tr>
                    </thead>
                    <tbody>


                        <tr>
                            <td style="text-align: center">1</td>
                            <td style="text-align: center"><input type="checkbox"  <?=$rsgroup1AD1?> class="group1D1" onchange="edit_telAD1('1', '2')"  style="transform: scale(2)" id="chk_rstelAD1" name="chk_rstelAD1" />&nbsp;&nbsp;&nbsp;[A]</td>
                            <td style="text-align: center">ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  <?=$rsgroup2CD1?> class="group2D1" onchange="edit_telCD1('1', '2')"  style="transform: scale(2)" id="chk_rstelCD1" name="chk_rstelCD1" />&nbsp;&nbsp;&nbsp;[ฺC]</td>
                            <td style="text-align: center">โทรศัพท์ดูได้</td>
                            <td style="text-align: center"><input type="checkbox"  <?=$rsgroup3ED1?> class="group3D1" onchange="edit_telED1('1', '2')"  style="transform: scale(2)" id="chk_rstelED1" name="chk_rstelED1" />&nbsp;&nbsp;&nbsp;[ฺE]</td>
                            <td style="text-align: center">ไม่ตรงกับข้อมูลที่ พขร.แจ้ง</td>
                            <td style="text-align: center"><input type="checkbox"  <?=$rsgroup4GD1?> class="group4D1" onchange="edit_telGD1('1', '2')"  style="transform: scale(2)" id="chk_rstelGD1" name="chk_rstelGD1" />&nbsp;&nbsp;&nbsp;[ฺG]</td>
                            <td style="text-align: center">น้อยกว่า พชร.แจ้ง</td>
                            <td style="text-align: center"><input type="checkbox"  <?=$rsgroup5JD1?> class="group5D1" onchange="edit_telJD1('1', '2')"  style="transform: scale(2)" id="chk_rstelJD1" name="chk_rstelJD1" />&nbsp;&nbsp;&nbsp;[ฺJ]</td>
                            <td style="text-align: center">ไม่ได้นอนจริงๆ</td>

                        </tr>
                        <tr>
                            <td style="text-align: center">2</td>
                            <td style="text-align: center"><input type="checkbox"  <?=$rsgroup1BD1?> class="group1D1"  onchange="edit_telBD1('1', '2')"  style="transform: scale(2)" id="chk_rstelBD1" name="chk_rstelBD1" />&nbsp;&nbsp;&nbsp;[B]</td>
                            <td style="text-align: center">ไม่ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  <?=$rsgroup2DD1?> class="group2D1" onchange="edit_telDD1('1', '2')"  style="transform: scale(2)" id="chk_rstelDD1" name="chk_rstelDD1" />&nbsp;&nbsp;&nbsp;[ฺD]</td>
                            <td style="text-align: center">โทรศัพท์ดูไม่ได้</td>
                            <td style="text-align: center"><input type="checkbox"  <?=$rsgroup3FD1?> class="group3D1" onchange="edit_telFD1('1', '2')"  style="transform: scale(2)" id="chk_rstelFD1" name="chk_rstelFD1" />&nbsp;&nbsp;&nbsp;[ฺF]</td>
                            <td style="text-align: center">ตรงกับข้อมูลที่ พขร.แจ้ง</td>
                            <td style="text-align: center"><input type="checkbox"  <?=$rsgroup4HD1?> class="group4D1" onchange="edit_telHD1('1', '2')"  style="transform: scale(2)" id="chk_rstelHD1" name="chk_rstelHD1" />&nbsp;&nbsp;&nbsp;[ฺH]</td>
                            <td style="text-align: center">มากกว่า พชร.แจ้ง</td>
                            <td style="text-align: center"><input type="checkbox"  <?=$rsgroup5KD1?> class="group5D1" onchange="edit_telKD1('1', '2')"  style="transform: scale(2)" id="chk_rstelKD1" name="chk_rstelKD1" />&nbsp;&nbsp;&nbsp;[ฺK]</td>
                            <td style="text-align: center">เหตุผลอื่นๆ</td>

                        </tr>
                        <tr>
                            <td style="text-align: center">3</td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"><input type="checkbox" <?=$rsgroup4ID1?> class="group4D1" onchange="edit_telID1('1', '2')"  style="transform: scale(2)" id="chk_rstelID1" name="chk_rstelID1" />&nbsp;&nbsp;&nbsp;[ฺI]</td>
                            <td style="text-align: center">ไม่ใช้งานงานเป็นระยะเวลานอน > 12 Hrs</td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>

                        </tr>
                        <!-- <tr>
                            <td style="text-align: center">2</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelB" name="chk_rstelB" />&nbsp;&nbsp;&nbsp;[B]&nbsp;ไม่ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2);text-align: center" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺD]&nbsp;ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                        </tr> -->

                    </tbody>
                    <tbody>
                        <tr>
                            <td colspan = "11" style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 15px;"></td>

                        </tr>
                        <tr>
                            <td style="text-align: center;background-color: #c9c9c9"></td>
                            <td style="text-align: center;background-color: #c9c9c9;"><b>หมายเหตุ</b></td>
                            <td colspan="6" style="text-align: center;background-color: #c9c9c9;"><input type="text" id="txt_remarkD1" name="txt_remarkD1" class="form-control" value="<?= $result_seTelcheckD1['REMARK'] ?>"></td>
                           
                            <td style="text-align: center;background-color: #c9c9c9;font-size:24px"><b>เกณฑ์ที่ได้ Rank</b></td>    
                            <td colspan = "2" rowspan = "2" id="rankD1" id="rankD1" style="text-align: center;<?=$tdcolorD1?>;font-size:60px"><b><?= $result_seTelcheckD1['RANKDRIVER'] ?></b></td>
                        </tr>
                        <tr>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"><b>ตรวจสอบ</b></td>
                            <td style="text-align: center"><button type="button" style="height:50px; width:130px" class="btn btn-primary btn-lg" onclick ="se_graphteldataD1('<?= $_POST['employeecode1'] ?>');">ดูกราฟข้อมูล</button></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"><button type="button" style="height:50px; width:300px" class="btn btn-primary btn-lg" onclick ="cal_telcheckD1('<?=$result_seTelcheckD1['COUNT']?>','<?=$result_seTelcheckD1['TELCHECKID']?>');">กดคำนวณและบันทึกข้อมูล พขร.1</button></td>

                        </tr>
                        <!-- <tr>
                            <td style="text-align: center">2</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelB" name="chk_rstelB" />&nbsp;&nbsp;&nbsp;[B]&nbsp;ไม่ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2);text-align: center" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺD]&nbsp;ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                        </tr> -->

                    </tbody>
                </table>
            </div>

            <?php
        
}
if ($_POST['txt_flg'] == "select_tenkotelcheckemp2") {

            // $conditionPlain = " AND a.VEHICLETRANSPORTPLANID = '" . $_POST['vehicletransportplanid'] . "'";
            // $sql_sePlain = "{call megVehicletransportplan_v2(?,?)}";
            // $params_sePlain = array(
            //     array('select_vehicletransportplan', SQLSRV_PARAM_IN),
            //     array($conditionPlain, SQLSRV_PARAM_IN)
            // );
            // $query_sePlain = sqlsrv_query($conn, $sql_sePlain, $params_sePlain);
            // $result_sePlain = sqlsrv_fetch_array($query_sePlain, SQLSRV_FETCH_ASSOC);

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

            // $conditionTenkomaster = " AND a.TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "'";
            // $sql_seTenkomaster = "{call megEdittenkomaster_v2(?,?)}";
            // $params_seTenkomaster = array(
            //     array('select_tenkomaster', SQLSRV_PARAM_IN),
            //     array($conditionTenkomaster, SQLSRV_PARAM_IN)
            // );
            // $query_seTenkomaster = sqlsrv_query($conn, $sql_seTenkomaster, $params_seTenkomaster);
            // $result_seTenkomaster = sqlsrv_fetch_array($query_seTenkomaster, SQLSRV_FETCH_ASSOC);

        

            $sql_seTelcheckD2 = "SELECT TELCHECKID AS 'COUNT',TELCHECKID,SELFCHECKID, VEHICLETRANSPORTPLANID,TENKOMASTERID,EMPLOYEECODE,
            CURRENTUSING_DATE,STOPUSING_DATE,ALLTIMEUSING,ALLTIMESLEEP,
            GROUP1,GROUP2,GROUP3,GROUP4,GROUP5,RANKDRIVER,REMARK
            FROM DRIVERTELCHECK 
            -- อันเดิมเช็ค planid ด้วย 
            -- แต่เจอปัญหากรณีมีหลาย  JOB
            -- อันใหม่ เช็คแค่ tenkomasterid เพราะ สามารถมีหลาย JOB(planid) ได้ แต่จะมี tenkomasterid ได้แค่ 1 ไอดี
            -- WHERE VEHICLETRANSPORTPLANID ='" . $_GET['vehicletransportplanid'] . "'
            WHERE TENKOMASTERID ='" . $result_seTenkomaster_temp['TENKOMASTERID'] . "'
            AND EMPLOYEECODE = '" . $_POST['employeecode2'] . "'";
            $query_seTelcheckD2 = sqlsrv_query($conn, $sql_seTelcheckD2, $params_seTelcheckD2);
            $result_seTelcheckD2 = sqlsrv_fetch_array($query_seTelcheckD2, SQLSRV_FETCH_ASSOC);   
            
            //เช็คข้อมูลจาก DATABASE
            // GROUP1 [A],[B]
            if($result_seTelcheckD2['GROUP1'] == 'A'){
                $rsgroup1AD2 = "checked";
            }else{
                $rsgroup1AD2 = "";
            }

            if($result_seTelcheckD2['GROUP1'] == 'B'){
                $rsgroup1BD2 = "checked";
            }else{
                $rsgroup1BD2 = "";
            }
            ///////////////////////////
            // GROUP2 [C],[D]
            if($result_seTelcheckD2['GROUP2'] == 'C'){
                $rsgroup2CD2 = "checked";
            }else{
                $rsgroup2CD2 = "";
            }
            
            if($result_seTelcheckD2['GROUP2'] == 'D'){
                $rsgroup2DD2 = "checked";
            }else{
                $rsgroup2DD2 = "";
            }
            ///////////////////////////
            // GROUP3 [E],[F]
            if($result_seTelcheckD2['GROUP3'] == 'E'){
                $rsgroup3ED2 = "checked";
            }else{
                $rsgroup3ED2 = "";
            }
            
            if($result_seTelcheckD2['GROUP3'] == 'F'){
                $rsgroup3FD2 = "checked";
            }else{
                $rsgroup3FD2 = "";
            }
                ///////////////////////////
            // GROUP3 [G],[H],[I]
            if($result_seTelcheckD2['GROUP4'] == 'G'){
                $rsgroup4GD2 = "checked";
            }else{
                $rsgroup4GD2 = "";
            }
            
            if($result_seTelcheckD2['GROUP4'] == 'H'){
                $rsgroup4HD1 = "checked";
            }else{
                $rsgroup4HD1 = "";
            }
            
            if($result_seTelcheckD2['GROUP4'] == 'I'){
                $rsgroup4ID2 = "checked";
            }else{
                $rsgroup4ID2 = "";
            }
            ///////////////////////////
            // GROUP3 [J],[K]
            if($result_seTelcheckD2['GROUP5'] == 'J'){
                $rsgroup5JD2 = "checked";
            }else{
                $rsgroup5JD2 = "";
            }
            
            if($result_seTelcheckD2['GROUP5'] == 'K'){
                $rsgroup5KD2 = "checked";
            }else{
                $rsgroup5KD2 = "";
            }
                ///////////////////////////
            
            //ใส่ สีใน TD ของแต่ละ RANK

            if ($result_seTelcheckD2['RANKDRIVER'] == 'ER') {
                $tdcolorD2 ="background-color: #349aff";
            }else if ($result_seTelcheckD2['RANKDRIVER'] == 'A'){
                $tdcolorD2 ="background-color: #ff3434";
            }else if ($result_seTelcheckD2['RANKDRIVER'] == 'B'){
                $tdcolorD2 ="background-color: #ffad33";
            }else if ($result_seTelcheckD2['RANKDRIVER'] == 'C'){
                $tdcolorD2 ="background-color: #ffff66";
            }else if ($result_seTelcheckD2['RANKDRIVER'] == 'D'){
                $tdcolorD2 ="background-color: #5cd65c";
            }else{
                $tdcolorD2 ="background-color: #ffffff";
            }

            
        ?>
        
        <div class="panel-body">
                <table  width="100%" style= "border-collapse: collapse;" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                    <thead>
                        <tr>
                            <th style="text-align: center;background-color: #349aff;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:20px"><b>Rank ER</b></th>
                            <th style="text-align: center;background-color: #ff3434;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:20px"><b>Rank A</b></th>
                            <th style="text-align: center;background-color: #ffad33;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:20px"><b>Rank B</b></th>
                            <th style="text-align: center;background-color: #ffff66;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:20px"><b>Rank C<b></th>
                            <th style="text-align: center;background-color: #5cd65c;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:20px"><b>Rank D</b></th>
                        </tr>
                        <tr>
                            <th style="text-align: center;font-size:20px">เลือกข้อมูลไม่ถูกต้อง</th>
                            <th style="text-align: center;font-size:20px">(วิ่งงานไม่ได้)</th>
                            <th style="text-align: center;font-size:18px">(โทรติดตาม 6 ชั่วโมงแรก<br>หลังโหลดเสร็จหากขับขี่)</th>
                            <th style="text-align: center;font-size:18px">(โทรติดตาม 3 ชั่วโมงแรก<br>หลังโหลดเสร็จหากขับขี่)</th>
                            <th style="text-align: center;font-size:20px">(ผ่าน)</th>
                        </tr>
                    </thead>
                    <!-- <thead>
                        <tr>
                            <th style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:18px"><b>Formula condition Rank ER</b></th>
                            <th style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:18px"><b>Formula condition Rank A</b></th>
                            <th style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:18px"><b>Formula condition Rank B</b></th>
                            <th style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:18px"><b>Formula condition Rank C<b></th>
                            <th style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:18px"><b>Formula condition Rank D</b></th>
                        </tr>
                        <tr>
                            <th style="text-align: left;font-size:14px">
                                Case1: ER จะแสดงกรณีเลือกข้อมูลไม่ถูกต้อง <br>
                                Case2: - 
                            </th>
                            <th style="text-align: left;font-size:18px">
                                Case1: [A]->[C]->[E]->[G]->[J] <br>
                                Case2: - 
                            </th>
                            <th style="text-align: left;font-size:18px">
                                Case1: [A]->[C]->[E]->[I] <br>
                                Case2: [B]
                            </th>
                            <th style="text-align: left;font-size:18px">
                                Case1: [A]->[C]->[E]->[G]->[K] <br>
                                Case2: [A]->[D]

                            </th>
                            <th style="text-align: left;font-size:18px">
                                Case1: [A]->[C]->[F] <br>
                                Case2: [A]->[C]->[E]->[H] 

                            </th>
                        </tr>
                    </thead> -->
                </table>

                <table  width="100%" style= "border-collapse: collapse;" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                    <thead>
                        <tr>
                            <th style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;">ข้อ</th>
                            <th colspan ="2" style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;">หัวข้อ.1</th>
                            <th colspan ="2" style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;">หัวข้อ.2</th>
                            <th colspan ="2" style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;">หัวข้อ.3</th>
                            <th colspan ="2" style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;">หัวข้อ.4</th>
                            <th colspan ="2" style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;">หัวข้อ.5</th>
                        </tr>
                        <tr>
                            <th style="text-align: center">&nbsp;</th>
                            <th style="text-align: center;width:5%"></th>
                            <th style="text-align: center"></th>
                            <th style="text-align: center;width:5%"></th>
                            <th style="text-align: center"></th>
                            <th style="text-align: center;width:5%"></th>
                            <th style="text-align: center"></th>
                            <th style="text-align: center;width:5%"></th>
                            <th style="text-align: center"></th>
                            <th style="text-align: center;width:5%"></th>
                            <th style="text-align: center"></th>
                        </tr>
                    </thead>
                    <tbody>


                        <tr>
                            <td style="text-align: center">1</td>
                            <td style="text-align: center"><input type="checkbox"  <?= $rsgroup1AD2 ?> class="group1D2" onchange="edit_telAD2('1', '2')"  style="transform: scale(2)" id="chk_rstelAD2" name="chk_rstelAD2" />&nbsp;&nbsp;&nbsp;[A]</td>
                            <td style="text-align: center">ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  <?= $rsgroup2CD2 ?> class="group2D2" onchange="edit_telCD2('1', '2')"  style="transform: scale(2)" id="chk_rstelCD2" name="chk_rstelCD2" />&nbsp;&nbsp;&nbsp;[ฺC]</td>
                            <td style="text-align: center">โทรศัพท์ดูได้</td>
                            <td style="text-align: center"><input type="checkbox"  <?= $rsgroup3ED2 ?> class="group3D2" onchange="edit_telED2('1', '2')"  style="transform: scale(2)" id="chk_rstelED2" name="chk_rstelED2" />&nbsp;&nbsp;&nbsp;[ฺE]</td>
                            <td style="text-align: center">ไม่ตรงกับข้อมูลที่ พขร.แจ้ง</td>
                            <td style="text-align: center"><input type="checkbox"  <?= $rsgroup4GD2 ?> class="group4D2" onchange="edit_telGD2('1', '2')"  style="transform: scale(2)" id="chk_rstelGD2" name="chk_rstelGD2" />&nbsp;&nbsp;&nbsp;[ฺG]</td>
                            <td style="text-align: center">น้อยกว่า พชร.แจ้ง</td>
                            <td style="text-align: center"><input type="checkbox"  <?= $rsgroup5JD2 ?> class="group5D2" onchange="edit_telJD2('1', '2')"  style="transform: scale(2)" id="chk_rstelJD2" name="chk_rstelJD2" />&nbsp;&nbsp;&nbsp;[ฺJ]</td>
                            <td style="text-align: center">ไม่ได้นอนจริงๆ</td>

                        </tr>
                        <tr>
                            <td style="text-align: center">2</td>
                            <td style="text-align: center"><input type="checkbox"  <?= $rsgroup1BD2 ?> class="group1D2"  onchange="edit_telBD2('1', '2')"  style="transform: scale(2)" id="chk_rstelBD2" name="chk_rstelBD2" />&nbsp;&nbsp;&nbsp;[B]</td>
                            <td style="text-align: center">ไม่ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  <?= $rsgroup2DD2 ?> class="group2D2" onchange="edit_telDD2('1', '2')"  style="transform: scale(2)" id="chk_rstelDD2" name="chk_rstelDD2" />&nbsp;&nbsp;&nbsp;[ฺD]</td>
                            <td style="text-align: center">โทรศัพท์ดูไม่ได้</td>
                            <td style="text-align: center"><input type="checkbox"  <?= $rsgroup3FD2 ?> class="group3D2" onchange="edit_telFD2('1', '2')"  style="transform: scale(2)" id="chk_rstelFD2" name="chk_rstelFD2" />&nbsp;&nbsp;&nbsp;[ฺF]</td>
                            <td style="text-align: center">ตรงกับข้อมูลที่ พขร.แจ้ง</td>
                            <td style="text-align: center"><input type="checkbox"  <?= $rsgroup4HD2 ?> class="group4D2" onchange="edit_telHD2('1', '2')"  style="transform: scale(2)" id="chk_rstelHD2" name="chk_rstelHD2" />&nbsp;&nbsp;&nbsp;[ฺH]</td>
                            <td style="text-align: center">มากกว่า พชร.แจ้ง</td>
                            <td style="text-align: center"><input type="checkbox"  <?= $rsgroup5KD2 ?> class="group5D2" onchange="edit_telKD2('1', '2')"  style="transform: scale(2)" id="chk_rstelKD2" name="chk_rstelKD2" />&nbsp;&nbsp;&nbsp;[ฺK]</td>
                            <td style="text-align: center">เหตุผลอื่นๆ</td>

                        </tr>
                        <tr>
                            <td style="text-align: center">3</td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"><input type="checkbox" <?= $rsgroup4ID2 ?> class="group4D2" onchange="edit_telID2('1', '2')"  style="transform: scale(2)" id="chk_rstelID2" name="chk_rstelID2" />&nbsp;&nbsp;&nbsp;[ฺI]</td>
                            <td style="text-align: center">ไม่ใช้งานงานเป็นระยะเวลานอน > 12 Hrs</td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>

                        </tr>
                        <!-- <tr>
                            <td style="text-align: center">2</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelB" name="chk_rstelB" />&nbsp;&nbsp;&nbsp;[B]&nbsp;ไม่ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2);text-align: center" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺD]&nbsp;ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                        </tr> -->

                    </tbody>
                    <tbody>


                        <tr>
                            <td colspan = "11" style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 15px;"></td>

                        </tr>
                        <tr>
                            <td style="text-align: center;background-color: #c9c9c9"></td>
                            <td style="text-align: center;background-color: #c9c9c9;"><b>หมายเหตุ</b></td>
                            <td colspan="6" style="text-align: center;background-color: #c9c9c9;"><input type="text" id="txt_remarkD2" name="txt_remarkD2" class="form-control" value="<?= $result_seTelcheckD2['REMARK'] ?>"></td>
                            
                            <td style="text-align: center;background-color: #c9c9c9;font-size:24px"><b>เกณฑ์ที่ได้ Rank</b></td>    
                            <td colspan = "2" rowspan = "2" id="rankD2" id="rankD2" style="text-align: center;<?=$tdcolorD2?>;font-size:60px"><b><?= $result_seTelcheckD2['RANKDRIVER'] ?></b></td>
                        </tr>
                        <tr>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"><b>ตรวจสอบ</b></td>
                            <td style="text-align: center"><button type="button" style="height:50px; width:130px" class="btn btn-primary btn-lg" onclick ="se_graphteldataD2('<?= $_POST['employeecode2'] ?>');">ดูกราฟข้อมูล</button></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"><button type="button" style="height:50px; width:300px" class="btn btn-primary btn-lg" onclick ="cal_telcheckD2('<?=$result_seTelcheckD2['COUNT']?>','<?=$result_seTelcheckD2['TELCHECKID']?>');">กดคำนวณและบันทึกข้อมูล พขร.2</button></td>

                        </tr>
                        <!-- <tr>
                            <td style="text-align: center">2</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelB" name="chk_rstelB" />&nbsp;&nbsp;&nbsp;[B]&nbsp;ไม่ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2);text-align: center" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺD]&nbsp;ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                            <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                        </tr> -->

                    </tbody>
                </table>
                
            </div>

        <?php
    
}
if ($_POST['txt_flg'] == "select_tenkotelcheckemp3") {

    // $conditionPlain = " AND a.VEHICLETRANSPORTPLANID = '" . $_POST['vehicletransportplanid'] . "'";
    // $sql_sePlain = "{call megVehicletransportplan_v2(?,?)}";
    // $params_sePlain = array(
    //     array('select_vehicletransportplan', SQLSRV_PARAM_IN),
    //     array($conditionPlain, SQLSRV_PARAM_IN)
    // );
    // $query_sePlain = sqlsrv_query($conn, $sql_sePlain, $params_sePlain);
    // $result_sePlain = sqlsrv_fetch_array($query_sePlain, SQLSRV_FETCH_ASSOC);

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

    // $conditionTenkomaster = " AND a.TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "'";
    // $sql_seTenkomaster = "{call megEdittenkomaster_v2(?,?)}";
    // $params_seTenkomaster = array(
    //     array('select_tenkomaster', SQLSRV_PARAM_IN),
    //     array($conditionTenkomaster, SQLSRV_PARAM_IN)
    // );
    // $query_seTenkomaster = sqlsrv_query($conn, $sql_seTenkomaster, $params_seTenkomaster);
    // $result_seTenkomaster = sqlsrv_fetch_array($query_seTenkomaster, SQLSRV_FETCH_ASSOC);



    $sql_seTelcheckD3 = "SELECT TELCHECKID AS 'COUNT',TELCHECKID,SELFCHECKID, VEHICLETRANSPORTPLANID,TENKOMASTERID,EMPLOYEECODE,
    CURRENTUSING_DATE,STOPUSING_DATE,ALLTIMEUSING,ALLTIMESLEEP,
    GROUP1,GROUP2,GROUP3,GROUP4,GROUP5,RANKDRIVER,REMARK
    FROM DRIVERTELCHECK 
    -- อันเดิมเช็ค planid ด้วย 
    -- แต่เจอปัญหากรณีมีหลาย  JOB
    -- อันใหม่ เช็คแค่ tenkomasterid เพราะ สามารถมีหลาย JOB(planid) ได้ แต่จะมี tenkomasterid ได้แค่ 1 ไอดี
    -- WHERE VEHICLETRANSPORTPLANID ='" . $_GET['vehicletransportplanid'] . "'
    WHERE TENKOMASTERID ='" . $result_seTenkomaster_temp['TENKOMASTERID'] . "'
    AND EMPLOYEECODE = '" . $_POST['employeecode3'] . "'";
    $query_seTelcheckD3 = sqlsrv_query($conn, $sql_seTelcheckD3, $params_seTelcheckD3);
    $result_seTelcheckD3 = sqlsrv_fetch_array($query_seTelcheckD3, SQLSRV_FETCH_ASSOC);   
    
    //เช็คข้อมูลจาก DATABASE
    // GROUP1 [A],[B]
    if($result_seTelcheckD3['GROUP1'] == 'A'){
        $rsgroup1AD3 = "checked";
    }else{
        $rsgroup1AD3 = "";
    }

    if($result_seTelcheckD3['GROUP1'] == 'B'){
        $rsgroup1BD3 = "checked";
    }else{
        $rsgroup1BD3 = "";
    }
    ///////////////////////////
    // GROUP2 [C],[D]
    if($result_seTelcheckD3['GROUP2'] == 'C'){
        $rsgroup2CD3 = "checked";
    }else{
        $rsgroup2CD3 = "";
    }
    
    if($result_seTelcheckD3['GROUP2'] == 'D'){
        $rsgroup2DD3 = "checked";
    }else{
        $rsgroup2DD3 = "";
    }
    ///////////////////////////
    // GROUP3 [E],[F]
    if($result_seTelcheckD3['GROUP3'] == 'E'){
        $rsgroup3ED3 = "checked";
    }else{
        $rsgroup3ED3 = "";
    }
    
    if($result_seTelcheckD3['GROUP3'] == 'F'){
        $rsgroup3FD3 = "checked";
    }else{
        $rsgroup3FD3 = "";
    }
        ///////////////////////////
    // GROUP3 [G],[H],[I]
    if($result_seTelcheckD3['GROUP4'] == 'G'){
        $rsgroup4GD3 = "checked";
    }else{
        $rsgroup4GD3 = "";
    }
    
    if($result_seTelcheckD3['GROUP4'] == 'H'){
        $rsgroup4HD3 = "checked";
    }else{
        $rsgroup4HD3 = "";
    }
    
    if($result_seTelcheckD3['GROUP4'] == 'I'){
        $rsgroup4ID3 = "checked";
    }else{
        $rsgroup4ID3 = "";
    }
    ///////////////////////////
    // GROUP3 [J],[K]
    if($result_seTelcheckD3['GROUP5'] == 'J'){
        $rsgroup5JD3 = "checked";
    }else{
        $rsgroup5JD3 = "";
    }
    
    if($result_seTelcheckD3['GROUP5'] == 'K'){
        $rsgroup5KD3 = "checked";
    }else{
        $rsgroup5KD3 = "";
    }
        ///////////////////////////
    
    //ใส่ สีใน TD ของแต่ละ RANK

    if ($result_seTelcheckD3['RANKDRIVER'] == 'ER') {
        $tdcolorD3 ="background-color: #349aff";
    }else if ($result_seTelcheckD3['RANKDRIVER'] == 'A'){
        $tdcolorD3 ="background-color: #ff3434";
    }else if ($result_seTelcheckD3['RANKDRIVER'] == 'B'){
        $tdcolorD3 ="background-color: #ffad33";
    }else if ($result_seTelcheckD3['RANKDRIVER'] == 'C'){
        $tdcolorD3 ="background-color: #ffff66";
    }else if ($result_seTelcheckD3['RANKDRIVER'] == 'D'){
        $tdcolorD3 ="background-color: #5cd65c";
    }else{
        $tdcolorD3 ="background-color: #ffffff";
    }

    
?>

<div class="panel-body">
        <table  width="100%" style= "border-collapse: collapse;" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
            <thead>
                <tr>
                    <th style="text-align: center;background-color: #349aff;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:20px"><b>Rank ER</b></th>
                    <th style="text-align: center;background-color: #ff3434;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:20px"><b>Rank A</b></th>
                    <th style="text-align: center;background-color: #ffad33;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:20px"><b>Rank B</b></th>
                    <th style="text-align: center;background-color: #ffff66;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:20px"><b>Rank C<b></th>
                    <th style="text-align: center;background-color: #5cd65c;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:20px"><b>Rank D</b></th>
                </tr>
                <tr>
                    <th style="text-align: center;font-size:20px">เลือกข้อมูลไม่ถูกต้อง</th>
                    <th style="text-align: center;font-size:20px">(วิ่งงานไม่ได้)</th>
                    <th style="text-align: center;font-size:18px">(โทรติดตาม 6 ชั่วโมงแรก<br>หลังโหลดเสร็จหากขับขี่)</th>
                    <th style="text-align: center;font-size:18px">(โทรติดตาม 3 ชั่วโมงแรก<br>หลังโหลดเสร็จหากขับขี่)</th>
                    <th style="text-align: center;font-size:20px">(ผ่าน)</th>
                </tr>
            </thead>
            <!-- <thead>
                <tr>
                    <th style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:18px"><b>Formula condition Rank ER</b></th>
                    <th style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:18px"><b>Formula condition Rank A</b></th>
                    <th style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:18px"><b>Formula condition Rank B</b></th>
                    <th style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:18px"><b>Formula condition Rank C<b></th>
                    <th style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;height:30px;width:50px;font-size:18px"><b>Formula condition Rank D</b></th>
                </tr>
                <tr>
                    <th style="text-align: left;font-size:14px">
                        Case1: ER จะแสดงกรณีเลือกข้อมูลไม่ถูกต้อง <br>
                        Case2: - 
                    </th>
                    <th style="text-align: left;font-size:18px">
                        Case1: [A]->[C]->[E]->[G]->[J] <br>
                        Case2: - 
                    </th>
                    <th style="text-align: left;font-size:18px">
                        Case1: [A]->[C]->[E]->[I] <br>
                        Case2: [B]
                    </th>
                    <th style="text-align: left;font-size:18px">
                        Case1: [A]->[C]->[E]->[G]->[K] <br>
                        Case2: [A]->[D]

                    </th>
                    <th style="text-align: left;font-size:18px">
                        Case1: [A]->[C]->[F] <br>
                        Case2: [A]->[C]->[E]->[H] 

                    </th>
                </tr>
            </thead> -->
        </table>

        <table  width="100%" style= "border-collapse: collapse;" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
            <thead>
                <tr>
                    <th style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;">ข้อ</th>
                    <th colspan ="2" style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;">หัวข้อ.1</th>
                    <th colspan ="2" style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;">หัวข้อ.2</th>
                    <th colspan ="2" style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;">หัวข้อ.3</th>
                    <th colspan ="2" style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;">หัวข้อ.4</th>
                    <th colspan ="2" style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 7px;">หัวข้อ.5</th>
                </tr>
                <tr>
                    <th style="text-align: center">&nbsp;</th>
                    <th style="text-align: center;width:5%"></th>
                    <th style="text-align: center"></th>
                    <th style="text-align: center;width:5%"></th>
                    <th style="text-align: center"></th>
                    <th style="text-align: center;width:5%"></th>
                    <th style="text-align: center"></th>
                    <th style="text-align: center;width:5%"></th>
                    <th style="text-align: center"></th>
                    <th style="text-align: center;width:5%"></th>
                    <th style="text-align: center"></th>
                </tr>
            </thead>
            <tbody>


                <tr>
                    <td style="text-align: center">1</td>
                    <td style="text-align: center"><input type="checkbox"  <?= $rsgroup1AD3 ?> class="group1D3" onchange="edit_telAD3('1', '2')"  style="transform: scale(2)" id="chk_rstelAD3" name="chk_rstelAD3" />&nbsp;&nbsp;&nbsp;[A]</td>
                    <td style="text-align: center">ยินยอมให้ตรวจ</td>
                    <td style="text-align: center"><input type="checkbox"  <?= $rsgroup2CD3 ?> class="group2D3" onchange="edit_telCD3('1', '2')"  style="transform: scale(2)" id="chk_rstelCD3" name="chk_rstelCD3" />&nbsp;&nbsp;&nbsp;[ฺC]</td>
                    <td style="text-align: center">โทรศัพท์ดูได้</td>
                    <td style="text-align: center"><input type="checkbox"  <?= $rsgroup3ED3 ?> class="group3D3" onchange="edit_telED3('1', '2')"  style="transform: scale(2)" id="chk_rstelED3" name="chk_rstelED3" />&nbsp;&nbsp;&nbsp;[ฺE]</td>
                    <td style="text-align: center">ไม่ตรงกับข้อมูลที่ พขร.แจ้ง</td>
                    <td style="text-align: center"><input type="checkbox"  <?= $rsgroup4GD3 ?> class="group4D3" onchange="edit_telGD3('1', '2')"  style="transform: scale(2)" id="chk_rstelGD3" name="chk_rstelGD3" />&nbsp;&nbsp;&nbsp;[ฺG]</td>
                    <td style="text-align: center">น้อยกว่า พชร.แจ้ง</td>
                    <td style="text-align: center"><input type="checkbox"  <?= $rsgroup5JD3 ?> class="group5D3" onchange="edit_telJD3('1', '2')"  style="transform: scale(2)" id="chk_rstelJD3" name="chk_rstelJD3" />&nbsp;&nbsp;&nbsp;[ฺJ]</td>
                    <td style="text-align: center">ไม่ได้นอนจริงๆ</td>

                </tr>
                <tr>
                    <td style="text-align: center">2</td>
                    <td style="text-align: center"><input type="checkbox"  <?= $rsgroup1BD3 ?> class="group1D3" onchange="edit_telBD3('1', '2')"  style="transform: scale(2)" id="chk_rstelBD3" name="chk_rstelBD3" />&nbsp;&nbsp;&nbsp;[B]</td>
                    <td style="text-align: center">ไม่ยินยอมให้ตรวจ</td>
                    <td style="text-align: center"><input type="checkbox"  <?= $rsgroup2DD3 ?> class="group2D3" onchange="edit_telDD3('1', '2')"  style="transform: scale(2)" id="chk_rstelDD3" name="chk_rstelDD3" />&nbsp;&nbsp;&nbsp;[ฺD]</td>
                    <td style="text-align: center">โทรศัพท์ดูไม่ได้</td>
                    <td style="text-align: center"><input type="checkbox"  <?= $rsgroup3FD3 ?> class="group3D3" onchange="edit_telFD3('1', '2')"  style="transform: scale(2)" id="chk_rstelFD3" name="chk_rstelFD3" />&nbsp;&nbsp;&nbsp;[ฺF]</td>
                    <td style="text-align: center">ตรงกับข้อมูลที่ พขร.แจ้ง</td>
                    <td style="text-align: center"><input type="checkbox"  <?= $rsgroup4HD3 ?> class="group4D3" onchange="edit_telHD3('1', '2')"  style="transform: scale(2)" id="chk_rstelHD3" name="chk_rstelHD3" />&nbsp;&nbsp;&nbsp;[ฺH]</td>
                    <td style="text-align: center">มากกว่า พชร.แจ้ง</td>
                    <td style="text-align: center"><input type="checkbox"  <?= $rsgroup5KD3 ?> class="group5D3" onchange="edit_telKD3('1', '2')"  style="transform: scale(2)" id="chk_rstelKD3" name="chk_rstelKD3" />&nbsp;&nbsp;&nbsp;[ฺK]</td>
                    <td style="text-align: center">เหตุผลอื่นๆ</td>

                </tr>
                <tr>
                    <td style="text-align: center">3</td>
                    <td style="text-align: center"></td>
                    <td style="text-align: center"></td>
                    <td style="text-align: center"></td>
                    <td style="text-align: center"></td>
                    <td style="text-align: center"></td>
                    <td style="text-align: center"></td>
                    <td style="text-align: center"><input type="checkbox" <?= $rsgroup4ID3 ?> class="group4D3" onchange="edit_telID3('1', '2')"  style="transform: scale(2)" id="chk_rstelID3" name="chk_rstelID3" />&nbsp;&nbsp;&nbsp;[ฺI]</td>
                    <td style="text-align: center">ไม่ใช้งานงานเป็นระยะเวลานอน > 12 Hrs</td>
                    <td style="text-align: center"></td>
                    <td style="text-align: center"></td>

                </tr>
                <!-- <tr>
                    <td style="text-align: center">2</td>
                    <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelB" name="chk_rstelB" />&nbsp;&nbsp;&nbsp;[B]&nbsp;ไม่ยินยอมให้ตรวจ</td>
                    <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2);text-align: center" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺD]&nbsp;ยินยอมให้ตรวจ</td>
                    <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                    <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                    <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                    <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                    <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                    <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                </tr> -->

            </tbody>
            <tbody>


                <tr>
                    <td colspan = "11" style="text-align: center;background-color: #c9c9c9;border: 0.5px solid gray;padding: 15px;"></td>

                </tr>
                <tr>
                    <td style="text-align: center;background-color: #c9c9c9"></td>
                    <td style="text-align: center;background-color: #c9c9c9;"><b>หมายเหตุ</b></td>
                    <td colspan="6" style="text-align: center;background-color: #c9c9c9;"><input type="text" id="txt_remarkD3" name="txt_remarkD3" class="form-control" value="<?= $result_seTelcheckD3['REMARK'] ?>"></td>
                    
                    <td style="text-align: center;background-color: #c9c9c9;font-size:24px"><b>เกณฑ์ที่ได้ Rank</b></td>    
                    <td colspan = "2" rowspan = "2" id="rankD3" id="rankD3" style="text-align: center;<?=$tdcolorD3?>;font-size:60px"><b><?= $result_seTelcheckD3['RANKDRIVER'] ?></b></td>
                </tr>
                <tr>
                    <td style="text-align: center"></td>
                    <td style="text-align: center"><b>ตรวจสอบ</b></td>
                    <td style="text-align: center"><button type="button" style="height:50px; width:130px" class="btn btn-primary btn-lg" onclick ="se_graphteldataD3('<?= $_POST['employeecode3'] ?>');">ดูกราฟข้อมูล</button></td>
                    <td style="text-align: center"></td>
                    <td style="text-align: center"></td>
                    <td style="text-align: center"></td>
                    <td style="text-align: center"></td>
                    <td style="text-align: center"></td>
                    <td style="text-align: center"><button type="button" style="height:50px; width:300px" class="btn btn-primary btn-lg" onclick ="cal_telcheckD3('<?=$result_seTelcheckD3['COUNT']?>','<?=$result_seTelcheckD3['TELCHECKID']?>');">กดคำนวณและบันทึกข้อมูล พขร.3</button></td>

                </tr>
                <!-- <tr>
                    <td style="text-align: center">2</td>
                    <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelB" name="chk_rstelB" />&nbsp;&nbsp;&nbsp;[B]&nbsp;ไม่ยินยอมให้ตรวจ</td>
                    <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2);text-align: center" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺD]&nbsp;ยินยอมให้ตรวจ</td>
                    <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                    <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                    <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                    <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                    <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                    <td style="text-align: center"><input type="checkbox"  onchange="edit_telA('1', '2')"  style="transform: scale(2)" id="chk_rstelA" name="chk_rstelA" />&nbsp;&nbsp;&nbsp;[ฺB]&nbsp;ยินยอมให้ตรวจ</td>
                </tr> -->

            </tbody>
        </table>
        
    </div>

<?php

}
if ($_POST['txt_flg'] == "save_telcheck") {
  ?>

  <?php

  $sql_savetelcheck = "{call megTelCheck(?,?,?,?,?,?,?,?,?,?,
                                         ?,?,?,?,?,?,?,?,?,?,
                                         ?,?,?)}"; 
  $params_savetelcheck = array(
  array('save_telcheck', SQLSRV_PARAM_IN),
  array($_POST['id'], SQLSRV_PARAM_IN),
  array($_POST['selfcheckid'], SQLSRV_PARAM_IN),
  array($_POST['planid'], SQLSRV_PARAM_IN),
  array($_POST['tenkomasterid'], SQLSRV_PARAM_IN),
  array($_POST['employeecode'], SQLSRV_PARAM_IN),
  array($_POST['currentusingdate'], SQLSRV_PARAM_IN),
  array($_POST['stopusingdate'], SQLSRV_PARAM_IN),
  array($_POST['alltimenormal'], SQLSRV_PARAM_IN),
  array($_POST['alltimeusing'], SQLSRV_PARAM_IN),
  array($_POST['alltimesleep'], SQLSRV_PARAM_IN),

  array($_POST['group1'], SQLSRV_PARAM_IN),
  array($_POST['group2'], SQLSRV_PARAM_IN),
  array($_POST['group3'], SQLSRV_PARAM_IN),
  array($_POST['group4'], SQLSRV_PARAM_IN),
  array($_POST['group5'], SQLSRV_PARAM_IN),
  array($_POST['rank'], SQLSRV_PARAM_IN),

  array($_POST['remark'], SQLSRV_PARAM_IN),
  array($_POST['activestatus'], SQLSRV_PARAM_IN),
  array($_POST['createby'], SQLSRV_PARAM_IN),
  array($_POST['createdate'], SQLSRV_PARAM_IN),
  array($_POST['modifiedby'], SQLSRV_PARAM_IN),
  array($_POST['modifieddate'], SQLSRV_PARAM_IN)
  );

  $query_savetelcheck = sqlsrv_query($conn, $sql_savetelcheck, $params_savetelcheck);
  $result_savetelcheck = sqlsrv_fetch_array($query_savetelcheck, SQLSRV_FETCH_ASSOC);
  ?>



  <?php
}
if ($_POST['txt_flg'] == "update_telcheck") {
  ?>

  <?php

  $sql_updatetelcheck = "{call megTelCheck(?,?,?,?,?,?,?,?,?,?,
                                         ?,?,?,?,?,?,?,?,?,?,
                                         ?,?,?)}"; 
  $params_updatetelcheck = array(
  array('update_telcheck', SQLSRV_PARAM_IN),
  array($_POST['id'], SQLSRV_PARAM_IN),
  array($_POST['selfcheckid'], SQLSRV_PARAM_IN),
  array($_POST['planid'], SQLSRV_PARAM_IN),
  array($_POST['tenkomasterid'], SQLSRV_PARAM_IN),
  array($_POST['employeecode'], SQLSRV_PARAM_IN),
  array($_POST['currentusingdate'], SQLSRV_PARAM_IN),
  array($_POST['stopusingdate'], SQLSRV_PARAM_IN),
  array($_POST['alltimenormal'], SQLSRV_PARAM_IN),
  array($_POST['alltimeusing'], SQLSRV_PARAM_IN),
  array($_POST['alltimesleep'], SQLSRV_PARAM_IN),

  array($_POST['group1'], SQLSRV_PARAM_IN),
  array($_POST['group2'], SQLSRV_PARAM_IN),
  array($_POST['group3'], SQLSRV_PARAM_IN),
  array($_POST['group4'], SQLSRV_PARAM_IN),
  array($_POST['group5'], SQLSRV_PARAM_IN),
  array($_POST['rank'], SQLSRV_PARAM_IN),

  array($_POST['remark'], SQLSRV_PARAM_IN),
  array($_POST['activestatus'], SQLSRV_PARAM_IN),
  array($_POST['createby'], SQLSRV_PARAM_IN),
  array($_POST['createdate'], SQLSRV_PARAM_IN),
  array($_POST['modifiedby'], SQLSRV_PARAM_IN),
  array($_POST['modifieddate'], SQLSRV_PARAM_IN)
  );

  $query_updatetelcheck = sqlsrv_query($conn, $sql_updatetelcheck, $params_updatetelcheck);
  $result_updatetelcheck = sqlsrv_fetch_array($query_updatetelcheck, SQLSRV_FETCH_ASSOC);
  ?>



  <?php
}
?>
<?php
sqlsrv_close($conn);
?>

