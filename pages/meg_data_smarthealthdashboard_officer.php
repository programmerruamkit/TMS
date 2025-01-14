<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");

if ($_POST['txt_flg'] == "select_smarthealthdashboard_officer") {
  ?>
  <table width="120%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
    <thead>
        <tr>
            <th colspan="4" style="">แผนก: <?=$_POST['section']?> | วันที่ <?= $_POST['datestart']?> ถึง <?= $_POST['dateend']?></th>
            <th style=""></th>
            <th style=""></th>
            <th style=""></th>
            <th style=""></th>
            <th style=""></th>
            <th style=""></th>
            <th style=""></th>
            <th style=""></th>
            <th style=""></th>
        </tr>
        <tr>
            <th style="width: 5px;">ลำดับ</th>
            <th style="width: 70px;">รหัสพนักงาน</th>
            <th style="width: 70px;">ชื่อ-นามสกุล</th>
            <th style="width: 70px;">ตำแหน่ง</th>
            <th style="width: 70px;">แผนก</th>
            <!--<th style="width: 40px;">เลขบัตร ปชช</th>
            <th style="width: 120px;">น้ำหนัก</th>
            <th style="width: 100px;">ส่วนสูง</th>
            <th style="width: 250px;">ดัชนีมวลกาย</th> -->
            <th style="width: 50px;">อุณหภูมิ</th>
            <th style="width: 50px;">ความดันบน</th>
            <th style="width: 50px;">ความดันล่าง</th>
            <th style="width: 50px;">อัตราเต้นหัวใจ</th>
            <th style="width: 40px;">ออกซิเจนในเลือด</th>
            <th style="width: 70px;">แอลกอฮอล์</th>
            <th style="width: 60px;">เวลาในการตรวจ</th>
            <th style="width: 50px;">จัดการ</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $sql_seOF = "SELECT STD_ID AS 'AMT_ID',MAXSYS,MINSYS,MAXDIA,MINDIA,MAXPULSE,MINPULSE,TEMP,OXYGEN,ALCOHOL,REMARK
    FROM STANDARDTENKODATA
    WHERE REMARK ='AMT'";
    $query_seOF = sqlsrv_query($conn, $sql_seOF, $params_seOF);
    $result_seOF = sqlsrv_fetch_array($query_seOF, SQLSRV_FETCH_ASSOC);

    // $condiReporttransport1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)";
    // $condiReporttransport2 = "";
    // $condiReporttransport3 = "";

    if ($_POST['drivercode'] == '' && $_POST['section'] == '' && $_POST['position'] == '') {

        $condition1 = "ORDER BY CONVERT(VARCHAR(16),a.CREATEDATE,103) DESC";
        // echo 'rrr';
    }else if ($_POST['drivercode'] != '' && $_POST['section'] != '' && $_POST['position'] != '') {  

        $condition1 = "AND b.PersonCode ='" . $_POST['drivercode'] . "' AND e.SECTIONNAME ='" . $_POST['section'] . "' AND b.PositionNameT ='" . $_POST['position'] . "' ORDER BY CONVERT(VARCHAR(16),a.CREATEDATE,103) DESC";
        // echo 'ddd';
    }else if ($_POST['drivercode'] != '' && $_POST['section'] == '' && $_POST['position'] == '') {  

        $condition1 = "AND b.PersonCode ='" . $_POST['drivercode'] . "' ORDER BY CONVERT(VARCHAR(16),a.CREATEDATE,103) DESC";
        // echo 'ddd';
    }else if ($_POST['drivercode'] != '' && $_POST['section'] != '' && $_POST['position'] == '') {  

        $condition1 = "AND b.PersonCode ='" . $_POST['drivercode'] . "' AND e.SECTIONNAME ='" . $_POST['section'] . "' ORDER BY CONVERT(VARCHAR(16),a.CREATEDATE,103) DESC";
        // echo 'aaa';
    }else if ($_POST['drivercode'] != '' && $_POST['section'] == '' && $_POST['position'] != '') {  

        $condition1 = "AND b.PersonCode ='" . $_POST['drivercode'] . "' AND b.PositionNameT ='" . $_POST['position'] . "' ORDER BY CONVERT(VARCHAR(16),a.CREATEDATE,103) DESC";
        // echo 'ddd';
    }else if ($_POST['drivercode'] == '' && $_POST['section'] == '' && $_POST['position'] != '') {  

        $condition1 = "AND b.PositionNameT ='" . $_POST['position'] . "' ORDER BY CONVERT(VARCHAR(16),a.CREATEDATE,103) DESC";
        // echo 'ddd';
    }else if ($_POST['drivercode'] == '' && $_POST['section'] != '' && $_POST['position'] != '') {  

        $condition1 = "AND e.SECTIONNAME ='" . $_POST['section'] . "' AND b.PositionNameT ='" . $_POST['position'] . "' ORDER BY CONVERT(VARCHAR(16),a.CREATEDATE,103) DESC";
        // echo 'ddd';
    }else if ($_POST['drivercode'] == '' && $_POST['section'] != '' && $_POST['position'] == '') {  

        $condition1 = "AND e.SECTIONNAME ='" . $_POST['section'] . "' ORDER BY CONVERT(VARCHAR(16),a.CREATEDATE,103) DESC";
        // echo 'ddd';
    }else{  

        $condition1 = "";
        // echo 'eee';
        
    }

    $i = 1;
    $sql_seData = "SELECT d.DEPARTMENTNAME,e.SECTIONNAME,b.PositionNameE,b.PositionNameT,b.Company_Code,b.nameT,b.TaxID,b.PersonCode,a.LABOTRONDATAID,CARDNUMBER,DRIVER_WEIGHT,DRIVER_HEIGHT,DRIVER_BMI,
        DRIVER_TEMPERATURE,DRIVER_SYS,DRIVER_DIA,DRIVER_PULSE,DRIVER_OXYGEN,DRIVER_ALCOHOL,
        a.CREATEBY,CONVERT(VARCHAR(16),a.CREATEDATE,103) AS 'CREATEDATE',CONVERT(VARCHAR(16),a.CREATEDATE,103) AS 'AC_CREATEDATE'
                                                                                                                                                                                            
        FROM LABOTRONWEBSERVICEDATA a 
        INNER JOIN EMPLOYEEEHR2 b ON b.TaxID = a.CREATEBY
        LEFT JOIN [dbo].[ORGANIZATION] c ON c.EMPLOYEECODE = b.PersonCode
        LEFT JOIN [dbo].[DEPARTMENT_NEW] d ON d.DEPARTMENTCODE = c.DEPARTMENTCODE AND d.COMPANYCODE = c.COMPANYCODE
        LEFT JOIN [dbo].[SECTION_NEW] e ON e.DEPARTMENTCODE = d.DEPARTMENTCODE AND e.SECTIONCODE = c.SECTIONCODE
        WHERE CONVERT(DATE,a.CREATEDATE) BETWEEN CONVERT(DATE,'".$_POST['datestart']."',103) AND CONVERT(DATE,'".$_POST['dateend']."',103)
        --WHERE CARDNUMBER IN ('5320890008815','1639900241323')
        --AND SUBSTRING(b.PersonCode, 1, 2) IN ('01','02','07','08','06','10')
        AND (b.PositionNameE IS NULL OR b.PositionNameE ='-')
        AND b.Company_NameE !='RKB'
        AND b.PositionNameT NOT IN ('พนักงานขับรถ/T-Tohken','Other')".$condition1;
    $params_seData = array();
    $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);
    while ($result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC)) {

        
        global $pageTitleTemp,$pageTitleSYS,$pageTitleDIA,$pageTitlePULSE,$pageTitleOXYGEN,$pageTitleALCOHOL;
        

        //อุณหภูมิ ไม่เกิน 37
        if ($result_seData['DRIVER_TEMPERATURE'] > $result_seOF['TEMP']  || $result_seData['DRIVER_TEMPERATURE'] == '' ) {
            $colortemp = "background-color: #FF6A66";
            $pageTitleTemp = "อุณหภูมิร่างกายสูงหรือต่ำเกินมาตรฐาน...";
        } else {
            $colortemp = "";
            $pageTitleTemp = "";
        }
        
        
        //ค่าความดันบน 60-150
        if ($result_seData['DRIVER_SYS'] < $result_seOF['MINSYS'] || $result_seData['DRIVER_SYS'] > $result_seOF['MAXSYS']) {
            $colorsys = "background-color: #FF6A66";
            $pageTitleSYS = "ความดันบนสูงหรือต่ำเกินมาตรฐาน...";
        } else {
            $colorsys = "";
            $pageTitleSYS = "";
        }

        //ค่าความดันล่าง 60-90
        if ($result_seData['DRIVER_DIA'] < $result_seOF['MINDIA'] || $result_seData['DRIVER_DIA'] > $result_seOF['MAXDIA']) {
            $colordia = "background-color: #FF6A66";
            $pageTitleDIA = "ความดันล่างสูงหรือต่ำเกินมาตรฐาน...";
        } else {
            $colordia = "";
            $pageTitleDIA = "";
        }

        //อัตตราการเต้นหัวใจ
        if ($result_seData['DRIVER_PULSE'] < $result_seOF['MINPULSE'] || $result_seData['DRIVER_PULSE'] > $result_seOF['MAXPULSE']) {
            $colorpulse = "background-color: #FF6A66";
            $pageTitlePULSE = "อัตราการเต้นของหัวใจสูงหรือต่ำเกินมาตรฐาน...";
        } else {
            $colorpulse = "";
            $pageTitlePULSE = "";
        }

        //ค่าออกซิเจนในเลือด
        if ($result_seData['DRIVER_OXYGEN'] < $result_seOF['OXYGEN']) {
            $coloroxygen = "background-color: #FF6A66";
            $pageTitleOXYGEN = "ออกซิเจนใจเลือดต่ำเกินมาตรฐาน...";
        } else {
            $coloroxygen = "";
            $pageTitleOXYGEN = "";
        }

        //ค่าแอลกอฮอล์
        if ($result_seData['DRIVER_ALCOHOL'] > $result_seOF['ALCOHOL'] || $result_seData['DRIVER_ALCOHOL'] == '') {
            $coloralcohol = "background-color: #FF6A66";
            $pageTitleALCOHOL = "แอลกอฮอล์ต้องเป็น 0 เท่านั้น...";
        } else {
            $coloralcohol = "";
            $pageTitleALCOHOL = "";
        }

            //ค่า BMI
            if ($result_seData['DRIVER_BMI'] > '0' && $result_seData['DRIVER_BMI'] < '18') {
            $colorbmi = "background-color: #66FAFF";
        } else if ($result_seData['DRIVER_BMI'] > '18' && $result_seData['DRIVER_BMI'] < '23') {
            $colorbmi = "background-color: #66FF72";
        }else if ($result_seData['DRIVER_BMI'] > '23'  && $result_seData['DRIVER_BMI'] < '25') {
            $colorbmi = "background-color: #FFA966";
        }else if ($result_seData['DRIVER_BMI'] > '25'  && $result_seData['DRIVER_BMI'] < '30') {
            $colorbmi = "background-color: #FF6A66";
        }else if ($result_seData['DRIVER_BMI']  == ''){
            $colorbmi = "";    
        }else{
            $colorbmi = "background-color: #FF6A66";    
        }

        // echo $result_seData['DRIVER_BMI'];
        // echo '<br>';
        ?>

        <tr>
            <td style="text-align: center"><?= $i ?></td>
            <td><?=$result_seData['PersonCode']?></td>
            <td><?=$result_seData['nameT']?></td>
            <td><?=$result_seData['PositionNameT']?></td>
            <td><?=$result_seData['SECTIONNAME']?></td>
            <!--<td><?=$result_seData['CREATEBY']?></td>
            <td><?=$result_seData['DRIVER_WEIGHT']?></td>
            <td><?=$result_seData['DRIVER_HEIGHT'];?></td>
            <td style="<?= $colorbmi ?>"><?=$result_seData['DRIVER_BMI'];?></td> -->
            <td title="<?=$pageTitleTemp?>"     style="<?= $colortemp ?>"><?=number_format($result_seData['DRIVER_TEMPERATURE'],2);?></td>
            <td title="<?=$pageTitleSYS?>"      style="<?= $colorsys ?>"><?=$result_seData['DRIVER_SYS'];?></td>
            <td title="<?=$pageTitleDIA?>"      style="<?= $colordia ?>"><?=$result_seData['DRIVER_DIA'];?></td>
            <td title="<?=$pageTitlePULSE?>"    style="<?= $colorpulse ?>"><?=$result_seData['DRIVER_PULSE'];?></td>
            <td title="<?=$pageTitleOXYGEN?>"   style="<?= $coloroxygen ?>"><?=$result_seData['DRIVER_OXYGEN']?></td>
            <td title="<?=$pageTitleALCOHOL?>"  style="<?= $coloralcohol ?>"><?=$result_seData['DRIVER_ALCOHOL']?></td>
            <td><?=$result_seData['CREATEDATE']?> </td>
            <td style="text-align: center;">
                <button onclick="delete_labotrondata('<?= $result_seData['LABOTRONDATAID'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="fa fa-times"></span></button>
            </td>
        </tr>
        <?php
        $i++;
        }
    ?>




    </tbody>

</table>
    <?php
}
?>
<?php
sqlsrv_close($conn);
?>
