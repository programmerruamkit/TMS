<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");

if ($_POST['txt_flg'] == "select_smarthealthdashboard_gw") {
  ?>
  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
    <thead>
        <tr>
            <th style="width: 5px;">ลำดับGW</th>
            <th style="width: 40px;">รหัสพนักงาน</th>
            <th style="width: 70px;">ชื่อ-นามสกุล</th>
            <th style="width: 70px;">ตำแหน่ง</th>
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
    $sql_seGW = "SELECT STD_ID AS 'GW_ID',MAXSYS,MINSYS,MAXDIA,MINDIA,MAXPULSE,MINPULSE,TEMP,OXYGEN,ALCOHOL,REMARK
    FROM STANDARDTENKODATA
    WHERE REMARK ='GW'";
    $query_seGW = sqlsrv_query($conn, $sql_seGW, $params_seGW);
    $result_seGW = sqlsrv_fetch_array($query_seGW, SQLSRV_FETCH_ASSOC);

    // $condiReporttransport1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)";
    // $condiReporttransport2 = "";
    // $condiReporttransport3 = "";

    if ($_POST['drivercode'] == '') {

    $condition1 = "ORDER BY CONVERT(VARCHAR(16),a.CREATEDATE,103) DESC";

    }else{  

    $condition1 = "AND b.PersonCode ='" . $_POST['drivercode'] . "' ORDER BY CONVERT(VARCHAR(16),a.CREATEDATE,103) DESC";
    
    }

    $i = 1;
    $sql_seData = "SELECT b.PositionNameE,b.PositionNameT,b.nameT,b.TaxID,b.PersonCode,a.LABOTRONDATAID,CARDNUMBER,DRIVER_WEIGHT,DRIVER_HEIGHT,DRIVER_BMI,
    DRIVER_TEMPERATURE,DRIVER_SYS,DRIVER_DIA,DRIVER_PULSE,DRIVER_OXYGEN,DRIVER_ALCOHOL,
    a.CREATEBY,CONVERT(VARCHAR(16),a.CREATEDATE,103) AS 'CREATEDATE',CONVERT(VARCHAR(16),a.CREATEDATE,103) AS 'AC_CREATEDATE'
                                                                                                                                                                                        
    FROM LABOTRONWEBSERVICEDATA a 
    INNER JOIN EMPLOYEEEHR2 b ON b.TaxID = a.CREATEBY
    WHERE CONVERT(DATE,a.CREATEDATE) BETWEEN CONVERT(DATE,'".$_POST['datestart']."',103) AND CONVERT(DATE,'".$_POST['dateend']."',103)
    --WHERE CARDNUMBER IN ('5320890008815','1639900241323')
    AND SUBSTRING(b.PersonCode, 1, 2) IN ('04','05','09')
    AND (b.PositionNameE ='Driver' OR b.PositionNameT IN ('Controller/RCC 8 LOAD','Controller/RCC 4 LOAD','Controller/RATC 4 LOAD','Controller/RATC 8 LOAD'
    ,'เจ้าหน้าที่ คปป./RCC 4 LOAD','เจ้าหน้าที่ คปป./RCC 8 LOAD','เจ้าหน้าที่ คปป./RATC 4 LOAD','เจ้าหน้าที่ คปป./RATC 8 LOAD','เจ้าหน้าที่ คปป./GMT'))".$condition1;
    $params_seData = array();
    $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);
    while ($result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC)) {

        
        global $pageTitleTemp,$pageTitleSYS,$pageTitleDIA,$pageTitlePULSE,$pageTitleOXYGEN,$pageTitleALCOHOL;
        

        //อุณหภูมิ ไม่เกิน 37
        if ($result_seData['DRIVER_TEMPERATURE'] > $result_seGW['TEMP']  || $result_seData['DRIVER_TEMPERATURE'] == '' ) {
            $colortemp = "background-color: #FF6A66";
            $pageTitleTemp = "อุณหภูมิร่างกายสูงหรือต่ำเกินมาตรฐาน...";
        } else {
            $colortemp = "";
            $pageTitleTemp = "";
        }
        
        
        //ค่าความดันบน 60-150
        if ($result_seData['DRIVER_SYS'] < $result_seGW['MINSYS'] || $result_seData['DRIVER_SYS'] > $result_seGW['MAXSYS']) {
            $colorsys = "background-color: #FF6A66";
            $pageTitleSYS = "ความดันบนสูงหรือต่ำเกินมาตรฐาน...";
        } else {
            $colorsys = "";
            $pageTitleSYS = "";
        }

        //ค่าความดันล่าง 60-90
        if ($result_seData['DRIVER_DIA'] < $result_seGW['MINDIA'] || $result_seData['DRIVER_DIA'] > $result_seGW['MAXDIA']) {
            $colordia = "background-color: #FF6A66";
            $pageTitleDIA = "ความดันล่างสูงหรือต่ำเกินมาตรฐาน...";
        } else {
            $colordia = "";
            $pageTitleDIA = "";
        }

        //อัตตราการเต้นหัวใจ
        if ($result_seData['DRIVER_PULSE'] < $result_seGW['MINPULSE'] || $result_seData['DRIVER_PULSE'] > $result_seGW['MAXPULSE']) {
            $colorpulse = "background-color: #FF6A66";
            $pageTitlePULSE = "อัตราการเต้นของหัวใจสูงหรือต่ำเกินมาตรฐาน...";
        } else {
            $colorpulse = "";
            $pageTitlePULSE = "";
        }

        //ค่าออกซิเจนในเลือด
        if ($result_seData['DRIVER_OXYGEN'] < $result_seGW['OXYGEN']) {
            $coloroxygen = "background-color: #FF6A66";
            $pageTitleOXYGEN = "ออกซิเจนใจเลือดต่ำเกินมาตรฐาน...";
        } else {
            $coloroxygen = "";
            $pageTitleOXYGEN = "";
        }

        //ค่าแอลกอฮอล์
        if ($result_seData['DRIVER_ALCOHOL'] > $result_seGW['ALCOHOL'] || $result_seData['DRIVER_ALCOHOL'] == '') {
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
            <td style="text-align: center"><?= $i ?>  </td>
            <td><?=$result_seData['PersonCode']?></td>
            <td><?=$result_seData['nameT']?></td>
            <td><?=$result_seData['PositionNameT']?></td>
            <!--<td><?=$result_seData['CREATEBY']?>     </td>
            <td><?=$result_seData['DRIVER_WEIGHT']?>  </td>
            <td><?=$result_seData['DRIVER_HEIGHT'];?> </td>
            <td style="<?= $colorbmi ?>"><?=$result_seData['DRIVER_BMI'];?></td> -->
            <td title="<?=$pageTitleTemp?>"     style="<?= $colortemp ?>"><?=number_format($result_seData['DRIVER_TEMPERATURE'],2);?> </td>
            <td title="<?=$pageTitleSYS?>"      style="<?= $colorsys ?>"><?=$result_seData['DRIVER_SYS'];?>    </td>
            <td title="<?=$pageTitleDIA?>"      style="<?= $colordia ?>"><?=$result_seData['DRIVER_DIA'];?>    </td>
            <td title="<?=$pageTitlePULSE?>"    style="<?= $colorpulse ?>"><?=$result_seData['DRIVER_PULSE'];?>  </td>
            <td title="<?=$pageTitleOXYGEN?>"   style="<?= $coloroxygen ?>"><?=$result_seData['DRIVER_OXYGEN']?>  </td>
            <td title="<?=$pageTitleALCOHOL?>"  style="<?= $coloralcohol ?>"><?=$result_seData['DRIVER_ALCOHOL']?> </td>
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
if ($_POST['txt_flg'] == "select_smarthealthdashboard_amt") {
    ?>
    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
      <thead>
          <tr>
              <th style="width: 5px;">ลำดับAMT</th>
              <th style="width: 40px;">รหัสพนักงาน</th>
              <th style="width: 70px;">ชื่อ-นามสกุล</th>
              <th style="width: 70px;">ตำแหน่ง</th>
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
      $sql_seAMT = "SELECT STD_ID AS 'AMT_ID',MAXSYS,MINSYS,MAXDIA,MINDIA,MAXPULSE,MINPULSE,TEMP,OXYGEN,ALCOHOL,REMARK
      FROM STANDARDTENKODATA
      WHERE REMARK ='AMT'";
      $query_seAMT = sqlsrv_query($conn, $sql_seAMT, $params_seAMT);
      $result_seAMT = sqlsrv_fetch_array($query_seAMT, SQLSRV_FETCH_ASSOC);
  
      // $condiReporttransport1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)";
      // $condiReporttransport2 = "";
      // $condiReporttransport3 = "";
  
      if ($_POST['drivercode'] == '') {
  
      $condition1 = "ORDER BY CONVERT(VARCHAR(16),a.CREATEDATE,103) DESC";
  
      }else{  
  
      $condition1 = "AND b.PersonCode ='" . $_POST['drivercode'] . "' ORDER BY CONVERT(VARCHAR(16),a.CREATEDATE,103) DESC";
      
      }
  
      $i = 1;
      $sql_seData = "SELECT b.PositionNameE,b.PositionNameT,b.nameT,b.TaxID,b.PersonCode,a.LABOTRONDATAID,CARDNUMBER,DRIVER_WEIGHT,DRIVER_HEIGHT,DRIVER_BMI,
        DRIVER_TEMPERATURE,DRIVER_SYS,DRIVER_DIA,DRIVER_PULSE,DRIVER_OXYGEN,DRIVER_ALCOHOL,
        a.CREATEBY,CONVERT(VARCHAR(16),a.CREATEDATE,103) AS 'CREATEDATE',CONVERT(VARCHAR(16),a.CREATEDATE,103) AS 'AC_CREATEDATE'
                                                                                                                                                                                            
        FROM LABOTRONWEBSERVICEDATA a 
        INNER JOIN EMPLOYEEEHR2 b ON b.TaxID = a.CREATEBY
        WHERE CONVERT(DATE,a.CREATEDATE) BETWEEN CONVERT(DATE,'".$_POST['datestart']."',103) AND CONVERT(DATE,'".$_POST['dateend']."',103)
        --WHERE CARDNUMBER IN ('5320890008815','1639900241323')
        AND SUBSTRING(b.PersonCode, 1, 2) IN ('01','02','07','08')
        AND (b.PositionNameE ='Driver' OR b.PositionNameT IN ('ผู้ฝึกสอน','Dispatcher','Controller'))".$condition1;
      $params_seData = array();
      $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);
      while ($result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC)) {
  
          
          global $pageTitleTemp,$pageTitleSYS,$pageTitleDIA,$pageTitlePULSE,$pageTitleOXYGEN,$pageTitleALCOHOL;
          
  
          //อุณหภูมิ ไม่เกิน 37
          if ($result_seData['DRIVER_TEMPERATURE'] > $result_seAMT['TEMP']  || $result_seData['DRIVER_TEMPERATURE'] == '' ) {
              $colortemp = "background-color: #FF6A66";
              $pageTitleTemp = "อุณหภูมิร่างกายสูงหรือต่ำเกินมาตรฐาน...";
          } else {
              $colortemp = "";
              $pageTitleTemp = "";
          }
          
          
          //ค่าความดันบน 60-150
          if ($result_seData['DRIVER_SYS'] < $result_seAMT['MINSYS'] || $result_seData['DRIVER_SYS'] > $result_seAMT['MAXSYS']) {
              $colorsys = "background-color: #FF6A66";
              $pageTitleSYS = "ความดันบนสูงหรือต่ำเกินมาตรฐาน...";
          } else {
              $colorsys = "";
              $pageTitleSYS = "";
          }
  
          //ค่าความดันล่าง 60-90
          if ($result_seData['DRIVER_DIA'] < $result_seAMT['MINDIA'] || $result_seData['DRIVER_DIA'] > $result_seAMT['MAXDIA']) {
              $colordia = "background-color: #FF6A66";
              $pageTitleDIA = "ความดันล่างสูงหรือต่ำเกินมาตรฐาน...";
          } else {
              $colordia = "";
              $pageTitleDIA = "";
          }
  
          //อัตตราการเต้นหัวใจ
          if ($result_seData['DRIVER_PULSE'] < $result_seAMT['MINPULSE'] || $result_seData['DRIVER_PULSE'] > $result_seAMT['MAXPULSE']) {
              $colorpulse = "background-color: #FF6A66";
              $pageTitlePULSE = "อัตราการเต้นของหัวใจสูงหรือต่ำเกินมาตรฐาน...";
          } else {
              $colorpulse = "";
              $pageTitlePULSE = "";
          }
  
          //ค่าออกซิเจนในเลือด
          if ($result_seData['DRIVER_OXYGEN'] < $result_seAMT['OXYGEN']) {
              $coloroxygen = "background-color: #FF6A66";
              $pageTitleOXYGEN = "ออกซิเจนใจเลือดต่ำเกินมาตรฐาน...";
          } else {
              $coloroxygen = "";
              $pageTitleOXYGEN = "";
          }
  
          //ค่าแอลกอฮอล์
          if ($result_seData['DRIVER_ALCOHOL'] > $result_seAMT['ALCOHOL'] || $result_seData['DRIVER_ALCOHOL'] == '') {
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
              <td style="text-align: center"><?= $i ?>  </td>
              <td><?=$result_seData['PersonCode']?></td>
              <td><?=$result_seData['nameT']?></td>
              <td><?=$result_seData['PositionNameT']?></td>
              <!--<td><?=$result_seData['CREATEBY']?>     </td>
              <td><?=$result_seData['DRIVER_WEIGHT']?>  </td>
              <td><?=$result_seData['DRIVER_HEIGHT'];?> </td>
              <td style="<?= $colorbmi ?>"><?=$result_seData['DRIVER_BMI'];?></td> -->
              <td title="<?=$pageTitleTemp?>"     style="<?= $colortemp ?>"><?=number_format($result_seData['DRIVER_TEMPERATURE'],2);?> </td>
              <td title="<?=$pageTitleSYS?>"      style="<?= $colorsys ?>"><?=$result_seData['DRIVER_SYS'];?>    </td>
              <td title="<?=$pageTitleDIA?>"      style="<?= $colordia ?>"><?=$result_seData['DRIVER_DIA'];?>    </td>
              <td title="<?=$pageTitlePULSE?>"    style="<?= $colorpulse ?>"><?=$result_seData['DRIVER_PULSE'];?>  </td>
              <td title="<?=$pageTitleOXYGEN?>"   style="<?= $coloroxygen ?>"><?=$result_seData['DRIVER_OXYGEN']?>  </td>
              <td title="<?=$pageTitleALCOHOL?>"  style="<?= $coloralcohol ?>"><?=$result_seData['DRIVER_ALCOHOL']?> </td>
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
