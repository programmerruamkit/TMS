<?php

date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
$sumtotal = "";
$mms = "";
switch ((int) substr($_GET['datestart'], 4, 2)) {
    case '1': {
            $mms = "มกราคม";
        }
        break;
    case '2': {
            $mms = "กุมภาพันธ์";
        }
        break;
    case '3': {
            $mms = "มีนาคม";
        }
        break;
    case '4': {
            $mms = "เมษายน";
        }
        break;
    case '5': {
            $mms = "พฤษภาคม";
        }
        break;
    case '6': {
            $mms = "มิถุนายน";
        }
        break;
    case '7': {
            $mms = "กรกฎาคม";
        }
        break;
    case '8': {
            $mms = "สิงหาคม";
        }
        break;
    case '9': {
            $mms = "กันยายน";
        }
        break;
    case '10': {
            $mms = "ตุลาคม";
        }
        break;
    case '11': {
            $mms = "พฤศจิกายน";
        }
        break;
    default : {
            $mms = "ธันวาคม";
        }
        break;
}



$mme = "";
switch ((int) substr($_GET['dateend'], 4, 2)) {
    case '1': {
            $mme = "มกราคม";
        }
        break;
    case '2': {
            $mme = "กุมภาพันธ์";
        }
        break;
    case '3': {
            $mme = "มีนาคม";
        }
        break;
    case '4': {
            $mme = "เมษายน";
        }
        break;
    case '5': {
            $mme = "พฤษภาคม";
        }
        break;
    case '6': {
            $mme = "มิถุนายน";
        }
        break;
    case '7': {
            $mme = "กรกฎาคม";
        }
        break;
    case '8': {
            $mme = "สิงหาคม";
        }
        break;
    case '9': {
            $mme = "กันยายน";
        }
        break;
    case '10': {
            $mme = "ตุลาคม";
        }
        break;
    case '11': {
            $mme = "พฤศจิกายน";
        }
        break;
    default : {
            $mme = "ธันวาคม";
        }
        break;
}


if ($mms == $mme) {
  $month = $mms;
}else {
  $month = $mms."-".$mme;
}



$mpdf = new mPDF('th', 'A4', '0', '');
$style = '
<style>
	body{
		font-family: "Garuda";font-size:12px//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';
if ($_GET['customercode'] == 'TMT') {
	$table_header2 = '<table width="100%" >
	<tbody>
	    <tr>
	      <td colspan="1" rowspan="4" style="text-align:center"><img src="../images/logonew.png"></td>
	        <td colspan="7" style="font-size:16px" ><b>บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICES CO.,LTD.)<b></td>
	   </tr>
	   <tr>
	      <td colspan="7" style="font-size:14px">เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง  จังหวัดชลบุรี 20160</td>
	   </tr>
	    <tr>
	      <td colspan="7" style="font-size:14px">โทรศัพท์: 038-452824-5 โทรสาร : 038-210396</td>
	   </tr>
	   <tr>
	      <td colspan="8" style="text-align:center;">&nbsp;</td>
	   </tr>



	</tbody>
	</table>';

	$table_begin2 = '<br><br><br><table width="100%" style="border-collapse: collapse;margin-top:8px;">';
	$thead2 = '<thead>
	<tr>
	    <th colspan ="7" bgcolor="#CCCCCC" style="text-align: center;border:1px solid #000;padding:4px;" >รายงานข้อมูลจำนวนเครื่องยนต์ที่ขนส่งให้กับ บริษัท โตโยต้า มอเตอร์ ประเทศไทย (สำนักงานใหญ่)</th>
	</tr>
	<tr>
	    <th colspan ="2" bgcolor="#CCCCCC" style="text-align: left;border:1px solid #000;padding:4px;" >สรุปข้อมูลจำนวนเครื่องยนต์ที่ขนส่งประจำ</th>
	    <th colspan ="2" bgcolor="#CCCCCC" style="text-align: left;border:1px solid #000;padding:4px;" >เดือน '.$month.'</th>
	    <th colspan ="3" bgcolor="#CCCCCC" style="text-align: left;border:1px solid #000;padding:4px;" >วันที่ '.$_GET['datestart'].' ถึง '.$_GET['dateend'].'</th>
	</tr>
	<tr>

	    <th style="text-align: center;border:1px solid #000;padding:4px;" rowspan="2">ลำดับ</th>
	    <th style="text-align: center;border:1px solid #000;padding:4px;" rowspan="2">ทะเบียนรถ</th>
	    <th style="text-align: center;border:1px solid #000;padding:4px;" colspan="3">PLANT (จำนวนเครื่องยนต์)</th>
	    <th style="text-align: center;border:1px solid #000;padding:4px;" colspan="2" rowspan="2">Total</th>

	    </th>

	</tr>
	<tr>
	    <th style="text-align: center;border:1px solid #000;">STM1-A</th>
	    <th style="text-align: center;border:1px solid #000;">STM1-E</th>
	    <th style="text-align: center;border:1px solid #000;">STM1-F</th>

	</tr>
	  </thead><tbody>';
	      $i = 1;
	      $sql_seThainame = "SELECT  DISTINCT(THAINAME) AS 'THAINAME' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE COMPANYCODE  ='RKS' AND CUSTOMERCODE = 'TMT'
	      AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
	      AND THAINAME !='' AND THAINAME IS NOT NULL
	      ORDER BY THAINAME ASC";
	      $params_seThainame = array();
	      $query_seThainame = sqlsrv_query($conn, $sql_seThainame, $params_seThainame);
	      while ($result_seThainame = sqlsrv_fetch_array($query_seThainame, SQLSRV_FETCH_ASSOC)) {

	        $sql_sumtripg = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT)) AS 'SUMG' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
	                    INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
	                    WHERE a.COMPANYCODE = 'RKS' AND a.CUSTOMERCODE = 'TMT'
	                    AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != '' AND a.DOCUMENTCODE != '-'
	                    AND SUBSTRING(a.DOCUMENTCODE,1,1)  = 'G'
	                    AND THAINAME = '".$result_seThainame['THAINAME']."'
	                    AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)";
	        $params_sumtripg = array();
	        $query_sumtripg = sqlsrv_query($conn, $sql_sumtripg, $params_sumtripg);
	        $result_sumtripg = sqlsrv_fetch_array($query_sumtripg, SQLSRV_FETCH_ASSOC);

	        $sql_sumtriph = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT)) AS 'SUMH' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
	                    INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
	                    WHERE a.COMPANYCODE = 'RKS' AND a.CUSTOMERCODE = 'TMT'
	                    AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != '' AND a.DOCUMENTCODE != '-'
	                    AND SUBSTRING(a.DOCUMENTCODE,1,1)  = 'H'
	                    AND THAINAME = '".$result_seThainame['THAINAME']."'
	                    AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)";
	        $params_sumtriph = array();
	        $query_sumtriph = sqlsrv_query($conn, $sql_sumtriph, $params_sumtriph);
	        $result_sumtriph = sqlsrv_fetch_array($query_sumtriph, SQLSRV_FETCH_ASSOC);

	        $sql_sumtripf = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT)) AS 'SUMF' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
	                    INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
	                    WHERE a.COMPANYCODE = 'RKS' AND a.CUSTOMERCODE = 'TMT'
	                    AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != '' AND a.DOCUMENTCODE != '-'
	                    AND SUBSTRING(a.DOCUMENTCODE,1,1)  = 'F'
	                    AND THAINAME = '".$result_seThainame['THAINAME']."'
	                    AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)";
	        $params_sumtripf = array();
	        $query_sumtripf = sqlsrv_query($conn, $sql_sumtripf, $params_sumtripf);
	        $result_sumtripf = sqlsrv_fetch_array($query_sumtripf, SQLSRV_FETCH_ASSOC);

	        $sumg = $sumg + $result_sumtripg['SUMG'];
	        $sumh = $sumh + $result_sumtriph['SUMH'];
	        $sumf = $sumf + $result_sumtripf['SUMF'];
	        $sumghf = $result_sumtripg['SUMG']+$result_sumtriph['SUMH']+$result_sumtripf['SUMF'];
					$sumallghf = $sumallghf+$sumghf;


	    $tbody2 .= '<tr style="">
	        <td style="border:1px solid #000;border-left:1px solid #000;padding:4px;text-align:center;">'.$i.'</td>
	        <td style="border:1px solid #000;padding:4px;text-align:center;">'.$result_seThainame['THAINAME'].'</td>
	        <td style="border:1px solid #000;padding:4px;text-align:center;">'.$result_sumtripg['SUMG'].'</td>
	        <td style="border:1px solid #000;padding:4px;text-align:center;">'.$result_sumtriph['SUMH'].'</td>
	        <td style="border:1px solid #000;padding:4px;text-align:center;">'.$result_sumtripf['SUMF'].'</td>
	        <td colspan ="2" style="border:1px solid #000;padding:4px;text-align:center;">'.$sumghf.'</td>

	      </tr>
	';

	$i++;
	  }


	$tfoot2 = '</tbody>
	    <tfoot >
	    <tr>
	    <td colspan="2" style="border:1px solid #000;padding:4px;text-align:center;font-size:14px;">รวม</td>
	    <td style="border:1px solid #000;padding:4px;text-align:center;font-size:14px;">'.$sumg.'</td>
	    <td style="border:1px solid #000;padding:4px;text-align:center;font-size:14px;">'.$sumh.'</td>
	    <td style="border:1px solid #000;padding:4px;text-align:center;font-size:14px;">'.$sumf.'</td>
	    <td colspan="2" style="border:1px solid #000;padding:4px;text-align:center;font-size:14px;">'.$sumallghf.'</td>
	    </tr>
	    </tfoot>';

	$table_end2 = '</table>';
}if ($_GET['customercode'] == 'TAW') {
	$table_header2 = '<table width="100%" >
	<tbody>
	    <tr>
	      <td colspan="1" rowspan="4" style="text-align:center"><img src="../images/logonew.png"></td>
	        <td colspan="7" style="font-size:16px" ><b>บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICES CO.,LTD.)<b></td>
	   </tr>
	   <tr>
	      <td colspan="7" style="font-size:14px">เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง  จังหวัดชลบุรี 20160</td>
	   </tr>
	    <tr>
	      <td colspan="7" style="font-size:14px">โทรศัพท์: 038-452824-5 โทรสาร : 038-210396</td>
	   </tr>
	   <tr>
	      <td colspan="8" style="text-align:center;">&nbsp;</td>
	   </tr>



	</tbody>
	</table>';

	$table_begin2 = '<br><br><br><table width="100%" style="border-collapse: collapse;margin-top:8px;">';
	$thead2 = '<thead>
	<tr>
	    <th colspan ="7" bgcolor="#CCCCCC" style="text-align: center;border:1px solid #000;padding:4px;" >รายงานข้อมูลจำนวนเครื่องยนต์ที่ขนส่งให้กับ บริษัท โตโยต้า ออโต้ เวิคส จำกัด</th>
	</tr>
	<tr>
	    <th colspan ="2" bgcolor="#CCCCCC" style="text-align: left;border:1px solid #000;padding:4px;" >สรุปข้อมูลจำนวนเครื่องยนต์ที่ขนส่งประจำ</th>
	    <th colspan ="2" bgcolor="#CCCCCC" style="text-align: left;border:1px solid #000;padding:4px;" >เดือน '.$month.'</th>
	    <th colspan ="3" bgcolor="#CCCCCC" style="text-align: left;border:1px solid #000;padding:4px;" >วันที่ '.$_GET['datestart'].' ถึง '.$_GET['dateend'].'</th>
	</tr>
	<tr>

	    <th style="text-align: center;border:1px solid #000;padding:4px;" rowspan="2">ลำดับ</th>
	    <th style="text-align: center;border:1px solid #000;padding:4px;" rowspan="2">ทะเบียนรถ</th>
	    <th style="text-align: center;border:1px solid #000;padding:4px;" colspan="3">PLANT (จำนวนเครื่องยนต์)</th>
	    <th style="text-align: center;border:1px solid #000;padding:4px;" colspan="2" rowspan="2">Total</th>

	    </th>

	</tr>
	<tr>
	    <th style="text-align: center;border:1px solid #000;">STM1-A</th>
	    <th style="text-align: center;border:1px solid #000;">STM1-E</th>
	    <th style="text-align: center;border:1px solid #000;">STM1-F</th>

	</tr>
	  </thead><tbody>';
	      $i = 1;
	      $sql_seThainame = "SELECT  DISTINCT(THAINAME) AS 'THAINAME' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE COMPANYCODE  ='RKS' AND CUSTOMERCODE = 'TAW'
	      AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
	      AND THAINAME !='' AND THAINAME IS NOT NULL
	      ORDER BY THAINAME ASC";
	      $params_seThainame = array();
	      $query_seThainame = sqlsrv_query($conn, $sql_seThainame, $params_seThainame);
	      while ($result_seThainame = sqlsrv_fetch_array($query_seThainame, SQLSRV_FETCH_ASSOC)) {

	        $sql_sumtripg = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT)) AS 'SUMG' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
	                    INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
	                    WHERE a.COMPANYCODE = 'RKS' AND a.CUSTOMERCODE = 'TAW'
	                    AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != '' AND a.DOCUMENTCODE != '-'
	                    AND SUBSTRING(a.DOCUMENTCODE,1,1)  = 'G'
	                    AND THAINAME = '".$result_seThainame['THAINAME']."'
	                    AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)";
	        $params_sumtripg = array();
	        $query_sumtripg = sqlsrv_query($conn, $sql_sumtripg, $params_sumtripg);
	        $result_sumtripg = sqlsrv_fetch_array($query_sumtripg, SQLSRV_FETCH_ASSOC);

	        $sql_sumtriph = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT)) AS 'SUMH' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
	                    INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
	                    WHERE a.COMPANYCODE = 'RKS' AND a.CUSTOMERCODE = 'TAW'
	                    AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != '' AND a.DOCUMENTCODE != '-'
	                    AND SUBSTRING(a.DOCUMENTCODE,1,1)  = 'H'
	                    AND THAINAME = '".$result_seThainame['THAINAME']."'
	                    AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)";
	        $params_sumtriph = array();
	        $query_sumtriph = sqlsrv_query($conn, $sql_sumtriph, $params_sumtriph);
	        $result_sumtriph = sqlsrv_fetch_array($query_sumtriph, SQLSRV_FETCH_ASSOC);

	        $sql_sumtripf = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT)) AS 'SUMF' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
	                    INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
	                    WHERE a.COMPANYCODE = 'RKS' AND a.CUSTOMERCODE = 'TAW'
	                    AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != '' AND a.DOCUMENTCODE != '-'
	                    AND SUBSTRING(a.DOCUMENTCODE,1,1)  = 'F'
	                    AND THAINAME = '".$result_seThainame['THAINAME']."'
	                    AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)";
	        $params_sumtripf = array();
	        $query_sumtripf = sqlsrv_query($conn, $sql_sumtripf, $params_sumtripf);
	        $result_sumtripf = sqlsrv_fetch_array($query_sumtripf, SQLSRV_FETCH_ASSOC);

	        $sumg = $sumg + $result_sumtripg['SUMG'];
	        $sumh = $sumh + $result_sumtriph['SUMH'];
	        $sumf = $sumf + $result_sumtripf['SUMF'];
	        $sumghf = $result_sumtripg['SUMG']+$result_sumtriph['SUMH']+$result_sumtripf['SUMF'];
					$sumallghf = $sumallghf + $sumghf;

	    $tbody2 .= '<tr style="">
	        <td style="border:1px solid #000;border-left:1px solid #000;padding:4px;text-align:center;">'.$i.'</td>
	        <td style="border:1px solid #000;padding:4px;text-align:center;">'.$result_seThainame['THAINAME'].'</td>
	        <td style="border:1px solid #000;padding:4px;text-align:center;">'.$result_sumtripg['SUMG'].'</td>
	        <td style="border:1px solid #000;padding:4px;text-align:center;">'.$result_sumtriph['SUMH'].'</td>
	        <td style="border:1px solid #000;padding:4px;text-align:center;">'.$result_sumtripf['SUMF'].'</td>
	        <td colspan ="2" style="border:1px solid #000;padding:4px;text-align:center;">'.$sumghf.'</td>

	      </tr>
	';

	$i++;
	  }


	$tfoot2 = '</tbody>
	    <tfoot >
	    <tr>
	    <td colspan="2" style="border:1px solid #000;padding:4px;text-align:center;font-size:14px;">รวม</td>
	    <td style="border:1px solid #000;padding:4px;text-align:center;font-size:14px;">'.$sumg.'</td>
	    <td style="border:1px solid #000;padding:4px;text-align:center;font-size:14px;">'.$sumh.'</td>
	    <td style="border:1px solid #000;padding:4px;text-align:center;font-size:14px;">'.$sumf.'</td>
	    <td colspan="2" style="border:1px solid #000;padding:4px;text-align:center;font-size:14px;">'.$sumallghf.'</td>
	    </tr>
	    </tfoot>';

	$table_end2 = '</table>';
}if ($_GET['customercode'] == 'STM') {
	// code...
}








$mpdf->WriteHTML($style);
$mpdf->SetHTMLHeader($table_header2, 'O', true);
$mpdf->WriteHTML($table_begin2);
$mpdf->WriteHTML($thead2);
$mpdf->WriteHTML($tbody2);
$mpdf->WriteHTML($tfoot2);
$mpdf->WriteHTML($table_end2);




$mpdf->Output();



sqlsrv_close($conn);
?>
