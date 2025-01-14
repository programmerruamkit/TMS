<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");

if ($_POST['txt_flg'] == "select_transportplan_incentive_check_amtdata") {
  ?>
  <table style="" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
    
    <thead>
        <tr style="border:1px solid #000;background-color: #ccc" >
          <td style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>ลำดับ</b>
          </td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>วันที่</b>
          </td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;width: 10%">
              <b>หมายเลขงาน</b>
          </td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;width: 10%">
              <b>พขร.1</b>
          </td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;width: 10%">
              <b>พขร.2</b>
          </td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;width: 15%">
              <b>ต้นทาง</b>
          </td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>โซน</b>
          </td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>ปลายทาง</b>
          </td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>รอบวิ่ง</b>
          </td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;width: 5%">
              <b>ทะเบียนรถ</b>
          </td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>ไมล์ต้น</b>
          </td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>ไมล์ปลาย</b>
          </td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>รวมระยะทาง</b>
          </td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>จำนวนลิตร</b>
          </td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>ค่าเฉลี่ยน้ำมัน</b>
          </td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>ค่าน้ำมัน</b>
          </td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>จำนวน<br>พาเลท</be></b>
          </td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>ค่า<br>พาเลท</be></b>
          </td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>ค่า<br>ตีเปล่า</b>
          </td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>ค่า<br>เทรนนิ่ง</b>
          </td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>ค่า<br>โอเจที</b>
          </td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>ค่า<br>มัลติสกิล</b>
          </td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>ค่าเที่ยว พขร.1</b>
          </td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>ค่าเที่ยว พขร.2</b>
          </td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>รวมรายได้</b>
          </td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>หมายเหตุ</b>
          </td> 
          <td style="border-right:1px solid #000;padding:3px;text-align:center;width: 5%">
              <b>ผู้อนุมัติ</b>
          </td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;width: 10%">
              <b>สถานะ</b>
          </td>
          </td> <td style="border-right:1px solid #000;padding:3px;text-align:center;width: 15%">
              <b>จัดการข้อมูล</b>
          </td> 
        </tr>
    </thead>
    <!-- rowspan="2"  -->
    <tbody>
      <?php
      $i = 1;

        if ($_POST['customercode'] == 'ALL' && $_POST['status'] == 'ALL') {

        $condition1 = "ORDER BY CONVERT(DATE,DATEWORKING,103),a.COMPANYCODE,a.CUSTOMERCODE,JOBNO  ASC";

        }else if ($_POST['customercode'] == 'ALL' && $_POST['status'] != 'ALL'){

        $condition1 = "AND a.APPROVESTATUS ='" . $_POST['status'] . "' ORDER BY CONVERT(DATE,DATEWORKING,103),a.COMPANYCODE,a.CUSTOMERCODE,JOBNO  ASC";
      
        }else if ($_POST['customercode'] != 'ALL' && $_POST['status'] == 'ALL'){

        $condition1 = "AND a.CUSTOMERCODE ='" . $_POST['customercode'] . "' ORDER BY CONVERT(DATE,DATEWORKING,103),a.COMPANYCODE,a.CUSTOMERCODE,JOBNO  ASC";
     
        }else{  

        $condition1 = "AND a.CUSTOMERCODE ='" . $_POST['customercode'] . "' AND a.APPROVESTATUS ='" . $_POST['status'] . "' ORDER BY CONVERT(DATE,DATEWORKING,103),a.COMPANYCODE,a.CUSTOMERCODE,JOBNO  ASC";
        
        }

    //   if ($_POST['status'] == 'ALL') {
    //     $condiStatus = "ORDER BY CONVERT(DATE,DATEWORKING,103),a.COMPANYCODE,a.CUSTOMERCODE,JOBNO  ASC";
    //   }else{
    //     $condiStatus = "AND a.APPROVESTATUS ='" . $_POST['status'] . "' ORDER BY CONVERT(DATE,DATEWORKING,103),a.COMPANYCODE,a.CUSTOMERCODE,JOBNO  ASC";
    //   }

      $sql_seComp = "SELECT CONVERT(NVARCHAR(10),DATEWORKING,103) AS 'DATEWORKING', JOBSTART,CLUSTER,JOBEND,a.JOBNO,a.VEHICLETYPE
        ,a.VEHICLETRANSPORTPLANID,a.EMPLOYEENAME1,a.EMPLOYEECODE1,d.PositionNameT AS 'POS1',a.EMPLOYEENAME2,a.EMPLOYEECODE2,e.PositionNameT  AS 'POS2',THAINAME,a.COMPANYCODE,a.CUSTOMERCODE,DOCUMENTCODE,C3,
        CASE WHEN CONVERT(DECIMAL,C3) >= 0 THEN C3 END AS 'C3PLUS',
        CASE WHEN CONVERT(DECIMAL,C3) < 0  THEN C3 END AS 'C3MINUS',
                
        CASE WHEN ((EMPLOYEECODE1 !='' OR EMPLOYEECODE1 != NULL) AND (EMPLOYEECODE2 !='' OR EMPLOYEECODE2 != NULL)) THEN '2' 
        ELSE '1'
        END AS 'COUNTEMP',b.OILAVERAGE AS 'OILAVERAGE',
        -- c.MILEAGESTART,c.MILEAGEEND,O4,
        f.MILEAGESTART,f.MILEAGEEND,f.OIL_AMOUNT AS 'O4',a.APPROVEBY,a.APPROVESTATUS,g.FnameT,a.ROUNDAMOUNT
                
                
        FROM [dbo].[VEHICLETRANSPORTPLAN] a
        LEFT JOIN [dbo].[OILAVERAGE] b ON b.COMPANYCODE = a.COMPANYCODE AND b.CUSTOMERCODE = a.CUSTOMERCODE AND b.VEHICLETYPE = a.VEHICLETYPE
        LEFT JOIN [dbo].[MILEAGE_SUMMARY] c ON c.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID 
        LEFT JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE1
        LEFT JOIN [dbo].[EMPLOYEEEHR2] e ON e.PersonCode = a.EMPLOYEECODE2
        LEFT JOIN [dbo].[EMPLOYEEEHR2] g ON g.PersonCode = a.APPROVEBY
        LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO f ON a.JOBNO = f.JOBNO COLLATE Thai_CI_AI 
                            
        WHERE CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
        --AND (EMPLOYEECODE1 = '" . $_GET['employeecode'] . "' OR EMPLOYEECODE2 = '" . $_GET['employeecode'] . "')
        AND (VEHICLETRANSPORTPRICEID IS NOT NULL AND VEHICLETRANSPORTPRICEID != '')
        AND (JOBSTART IS NOT NULL AND JOBSTART != '')
        AND (DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !='')
        AND a.COMPANYCODE ='" . $_POST['companycode'] . "'".$condition1;

      $query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
      while ($result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC)) {
        
        //ค่าพาเลท ถ้าเป็นงาน TTAST-STC ทุก ROUTE คิด 5 บาท
        //ค่าพาเลท ถ้าเป็นงานบริษัท TTAST-Other(Trip)ทุก ROUTE คิด 10 บาท
        if (($result_seComp['COMPANYCODE'] == 'RKR' || $result_seComp['COMPANYCODE'] == 'RKL') && $result_seComp['COMPANYCODE'] == 'TTAST-STC') {
            $PALLETMONEY = '5';
        }else if(($result_seComp['COMPANYCODE'] == 'RKR' || $result_seComp['COMPANYCODE'] == 'RKL') && $result_seComp['COMPANYCODE'] == 'TTAST') {
            $PALLETMONEY = '10';
        }else {
            $PALLETMONEY = '0';
        }

        //จำนวนพาเลท
        $sql_sePallet    = "SELECT SUM(CONVERT(INT,TRIPAMOUNT_PALLET)) AS 'PALLET',DOCUMENTCODE_PALLET AS 'DOPALLET'
            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] 
            WHERE VEHICLETRANSPORTPLANID ='" . $result_seComp['VEHICLETRANSPORTPLANID'] . "'
            GROUP BY TRIPAMOUNT_PALLET,DOCUMENTCODE_PALLET";
        $query_sePallet  = sqlsrv_query($conn, $sql_sePallet, $params_sePallet);
        $result_sePallet = sqlsrv_fetch_array($query_sePallet, SQLSRV_FETCH_ASSOC);

        
         //ค่าเที่ยว
         // SELECT_4LOAD2 คือ กรณีพนักงานคนที่ 1 เป็นเทรนเนอร์ ได้รับเงินเพิ่ม 100 บาท/วัน ในหน้าคีย์ค่าตอบแทน
         // SELECT_4LOAD5 คือ กรณีพนักงานคนที่ 2 เป็นพนักงาน(OJT) ได้รับเงินเพิ่ม 100 บาท/วัน ในหน้าคีย์ค่าตอบแทน
         // SELECT_8LOAD2 คือ กรณีพนักงานคนที่ 2 เป็นพนักงานเพิ่มทักษะทำงาน(Multiskills) ได้รับเงินเพิ่ม 200 บาท/วัน	 ในหน้าคีย์ค่าตอบแทน
        $sql_seCompensation1 = "SELECT COMPENSATION,COMPENSATION1,COMPENSATION2,COMPENSATION3,TOTALCOMPEN,
                                 COMPENSATIONEMPTY,COMPENSATIONEMPTY1,COMPENSATIONEMPTY2,COMPENSATIONEMPTY3,
                                 SELECT_4LOAD2,SELECT_4LOAD5,SELECT_8LOAD2,
                                 PAY_REPAIR,PAY_OTHER,PAY_CONDITION,OTHER
                                 FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] 
                                 WHERE VEHICLETRANSPORTPLANID = '" . $result_seComp['VEHICLETRANSPORTPLANID'] . "'
                                 AND (COMPENSATION IS NOT NULL OR COMPENSATION != '')
                                 AND (COMPENSATION1 IS NOT NULL OR COMPENSATION1 != '')
                                 AND (COMPENSATION2 IS NOT NULL OR COMPENSATION2 != '')
                                 --AND (COMPENSATION3 IS NOT NULL OR COMPENSATION3 != '')
                                 ORDER BY COMPENSATION DESC";
         $query_seCompensation1 = sqlsrv_query($conn, $sql_seCompensation1, $params_seCompensation1);
         $result_seCompensation1 = sqlsrv_fetch_array($query_seCompensation1, SQLSRV_FETCH_ASSOC);

         $COMPENDATION1 = $result_seCompensation1['COMPENSATION1'];
         $COMPENDATION2 = $result_seCompensation1['COMPENSATION2'];
         $COMPENSATIONEMPLY   = $result_seCompensation1['COMPENSATIONEMPTY'];
         $TOTALCOMPEN   = $result_seCompensation1['TOTALCOMPEN'];

         if ($result_seComp['APPROVESTATUS'] == 'A') {
            $approvestatus = 'อนุมัติ';
            $color = "background-color: #A6FB97";
         }else{
            $approvestatus = 'ไม่อนุมัติ';
            $color = "background-color: #FB9797";
         }
        ?>

        <tr>
          <td  style="border-right:1px solid #000;padding:3px;text-align:center;"><?= $i ?></td>
          <td  style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seComp['DATEWORKING'] ?></td>
          <td  style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seComp['JOBNO'] ?></td>
          <td  style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seComp['EMPLOYEENAME1'] ?></td>
          <td  style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seComp['EMPLOYEENAME2'] ?></td>
          <td  style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seComp['JOBSTART'] ?></td>
          <td  style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seComp['CLUSTER'] ?></td>
          <td  style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seComp['JOBEND'] ?></td>
          <td  style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seComp['ROUNDAMOUNT'] ?></td>
          <td  style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seComp['THAINAME'] ?></td>
          <td  style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($result_seComp['MILEAGESTART']) ?></td>
          <td  style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($result_seComp['MILEAGEEND']) ?></td>
          <td  style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($result_seComp['MILEAGEEND'] - $result_seComp['MILEAGESTART']) ?></td>
          <td  style="border-right:1px solid #000;padding:3px;text-align:left;"><?= ($result_seComp['O4'] == '' ? '0':$result_seComp['O4']) ?></td>            
          <td  style="border-right:1px solid #000;padding:3px;text-align:left;"><?= ($result_seComp['OILAVERAGE'] == '' ? '0':$result_seComp['OILAVERAGE']) ?></td>   
          <td  style="border-right:1px solid #000;padding:3px;text-align:center;"><?= $result_seComp['C3'] ?></td>
          <td  style="border-right:1px solid #000;padding:3px;text-align:center;"><?= ($result_sePallet['PALLET'] =='' ? '0':$result_sePallet['PALLET']) ?></td> 
          <td  style="border-right:1px solid #000;padding:3px;text-align:center;"><?= ($result_sePallet['PALLET'] =='' ? '0':$result_sePallet['PALLET']* $PALLETMONEY ) ?></td>  
          <td  style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($COMPENSATIONEMPLY) ?></td>
          <td  style="border-right:1px solid #000;padding:3px;text-align:left;"><?= ($result_seCompensation1['SELECT_4LOAD2'] == '' ? '0':$result_seCompensation1['SELECT_4LOAD2']) ?></td>
          <td  style="border-right:1px solid #000;padding:3px;text-align:left;"><?= ($result_seCompensation1['SELECT_4LOAD5'] == '' ? '0':$result_seCompensation1['SELECT_4LOAD5']) ?></td> 
          <td  style="border-right:1px solid #000;padding:3px;text-align:left;"><?= ($result_seCompensation1['SELECT_8LOAD2'] == '' ? '0':$result_seCompensation1['SELECT_8LOAD2']) ?></td>
          <td  style="border-right:1px solid #000;padding:3px;text-align:left;"><?= ($COMPENDATION1 == '' ? '':number_format($COMPENDATION1, 0)) ?></td>   
          <td  style="border-right:1px solid #000;padding:3px;text-align:left;"><?= ($COMPENDATION2 == '' ? '':number_format($COMPENDATION2, 0)) ?></td>
          <td  style="border-right:1px solid #000;padding:3px;text-align:left;"><?= ($TOTALCOMPEN == '' ? '':number_format($TOTALCOMPEN, 0)) ?></td>
          <td  style="border-right:1px solid #000;padding:3px;text-align:left;"></td>
          <td  style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seComp['FnameT'] ?></td>
          <td  style="border-right:1px solid #000;padding:3px;text-align:left;<?=$color?>"><?= $approvestatus ?></td>
          <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <button onclick="approve_plan('<?= $result_seComp['VEHICLETRANSPORTPLANID'] ?>');" style="width: 40px;height: 40px;" title="อนุมัติ" type="button" class="btn btn-default btn-circle btn-success"><span class="fa fa-check"></span></button>
            <button onclick="disapprove_adv('<?= $result_seComp['VEHICLETRANSPORTPLANID'] ?>');" style="width: 40px;height: 40px;" title="ไม่อนุมัติ" type="button" class="btn btn-default btn-circle btn-danger"><span class="fa fa-times"></span></button>
          </td>
          <!-- <td  style="border-right:1px solid #000;padding:3px;text-align:left;"></td>
            <button onclick="approve_adv('<?= $result_seClashAdv['CLASHID'] ?>');" style="width: 40px;height: 40px;" title="อนุมัติ" type="button" class="btn btn-default btn-circle btn-success"><span class="fa fa-check"></span></button>
            <button onclick="disapprove_adv('<?= $result_seClashAdv['CLASHID'] ?>');" style="width: 40px;height: 40px;" title="ไม่อนุมัติ" type="button" class="btn btn-default btn-circle btn-warning"><span class="fa fa-times"></span></button>
            <button onclick="delete_adv('<?= $result_seClashAdv['CLASHID'] ?>');" style="width: 40px;height: 40px;" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle btn-danger"><span class="fa fa-trash-o"></span></button>
          </td> -->
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
