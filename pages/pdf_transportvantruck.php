<?php
ob_start();
session_start();
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
date_default_timezone_set("Asia/Bangkok");


ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");
//$mpdf = new mPDF();
$mpdf = new mPDF('th', 'A4-L', '0', '');
///////////////////////////////////////////////////////////////////////////////

$sql_seSystime = "{call megGetdate_v2(?)}";
$params_seSystime = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
$result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);

///////////////////////////////////////////////////////////////////////////////

$conditionEHR = " AND a.PersonID ='" . $_SESSION["EMPLOYEEID"] . "'";
$sql_seEHR = "{call megEmployeeEHR_v2(?,?)}";
$params_seEHR = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array($conditionEHR, SQLSRV_PARAM_IN)
);
$query_seEHR = sqlsrv_query($conn, $sql_seEHR, $params_seEHR);
$result_seEHR = sqlsrv_fetch_array($query_seEHR, SQLSRV_FETCH_ASSOC);

///////////////////////////////////////////////////////////////////////////////

$condcompany = " AND Company_Code ='" . $companycode . "'";
$sql_seCompany = "{call megCompanyEHR_v2(?,?)}";
$params_seCompany = array(
    array('select_company', SQLSRV_PARAM_IN),
    array($condcompany, SQLSRV_PARAM_IN)
);
$query_seCompany = sqlsrv_query($conn, $sql_seCompany, $params_seCompany);
$result_seCompany = sqlsrv_fetch_array($query_seCompany, SQLSRV_FETCH_ASSOC);

///////////////////////////////////////////////////////////////////////////////

$condition = " AND a.VEHICLETRANSPORTPLANID = '" . $_GET['vehicletransportplanid'] . "'";
$sql_seVehicletransportplan = "{call megVehicletransportplan_v2(?,?,?,?)}";
$params_seVehicletransportplan = array(
    array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
    array($condition, SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seVehicletransportplan = sqlsrv_query($conn, $sql_seVehicletransportplan, $params_seVehicletransportplan);
$result_seVehicletransportplan = sqlsrv_fetch_array($query_seVehicletransportplan, SQLSRV_FETCH_ASSOC);

////////////////////////////////////////////////////////////////////////////////

$condMileage = " AND  VEHICLEREGISNUMBER ='" . $result_seVehicletransportplan['VEHICLEREGISNUMBER1'] . "'";
$sql_seMileage = "{call megMileage_v2(?,?)}";
$params_seMileage = array(
    array('select_maxmileage', SQLSRV_PARAM_IN),
    array($condMileage, SQLSRV_PARAM_IN)
);
$query_seMileage = sqlsrv_query($conn, $sql_seMileage, $params_seMileage);
$result_seMileage = sqlsrv_fetch_array($query_seMileage, SQLSRV_FETCH_ASSOC);

////////////////////////////////////////////////////////////////////////////////
$empName2 = !empty($result_seVehicletransportplan['EMPLOYEENAME2']) ? '2.'.$result_seVehicletransportplan['EMPLOYEENAME2'] : '';

$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}

	input.big{
  height: 20em;
  width: 20em;
}
</style>';
$table0= '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
    <thead>
        <tr style="border:1px solid #000;padding:2px;">
            <th colspan="1"  style="padding:2px;text-align:center;"><img src="../images/logo.png" height="30"></th>
            <th colspan="7"  style="padding:2px;text-align:left;font-size:15;">TRANSPORT GOODS TIME FOR  VAN TRUCK</th>
            <th colspan="16"  style="border-right:1px solid #000;padding:2px;text-align:right;font-size:12;">บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด / 51 ม.4 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี 20160 Tel : 038-452824-5 Fax : 038-452826</th>

				</tr>
        <tr style="border:1px solid #000;padding:4px;">
            <th  colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;">
                <!--<input type="checkbox" <?//= $checkprojectttast ?> id="chk_projectttast"  onchange="chk_projectttast()"/>-->
                ต้นทาง
            </th>
            <th colspan="4" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;">
                '.$result_seVehicletransportplan['JOBSTART'].'
            </th>
            <th colspan="1" bgcolor="#CCCCCC"  style="padding:4px;text-align:right;">
                JOBNO
            </th>
            <th colspan="4" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;">
              :   '.$result_seVehicletransportplan['JOBNO'].'
            </th>
            <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">การทำงาน</th>
            <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">พขร.</th>
            <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ผช. พขร.</th>
            <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">รอบที่</th>
            <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">วัน-เดือน-ปี</th>
        </tr>

        <tr style="border:1px solid #000;padding:4px;">
            <th  colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;">
                <!--<input type="checkbox" <?//= $checkprojectttast ?> id="chk_projectttast"  onchange="chk_projectttast()"/>-->
                ปลายทาง
            </th>
            <th colspan="9" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;">
                '.$result_seVehicletransportplan['JOBEND'].'
            </th>

            <th  colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;">

                <input disabled=""  type="checkbox" '.$checkworkingd.' id="chk_workd" onchange="chk_workd()"/>
                D&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input disabled="" type="checkbox" '.$checkworkingn.'  id="chk_workn" onchange="chk_workn()"/>
                N</th>
            <th colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:left;">1.'.$result_seVehicletransportplan['EMPLOYEENAME1']  .'</th>
            <th colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:left;">'.$empName2.'</th>
            <th colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></th>
            <th colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seVehicletransportplan['DATE_VLIN'].'</th>

        </tr>

        <tr style="border:1px solid #000;padding:4px;">
            <th colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">
                <input disabled="" type="checkbox" id="chk_uniformcompany"  />
            </th>
            <th colspan="5"  style="border-right:1px solid #000;padding:4px;text-align:left;">แต่งกายด้วยชุดฟอร์มของบริษัทฯ</th>
            <th colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><input  disabled="" type="checkbox" id="chk_uniformsafety" /></th>
            <th colspan="5"  style="border-right:1px solid #000;padding:4px;text-align:left;">ใส่อุปกรณ์เซฟตี้ทุกครั้งขณะปฏิบัติงาน</th>
            <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ทะเบียนรถ</th>
            <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขไมล์ก่อนออก</th>
            <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขไมล์เสร็จ</th>
            <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">น้ำมัน (ลิตร)</th>
            <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">รวม (กม)</th>
        </tr>
        <tr style="border:1px solid #000;padding:4px;">
            <th colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><input  disabled="" type="checkbox" id="chk_vehicle" /></th>
            <th colspan="5"  style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจเช็คสภาพความพร้อมของรถก่อนใช้งาน</th>
            <th colspan="6"  style="border-right:1px solid #000;padding:4px;text-align:left;"></th>
            <th colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seVehicletransportplan['THAINAME'].'</th>
            <th colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;">  </th>
            <th colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;"></th>
            <th colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;">-</th>
            <th colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;"></th>
        </tr>

        <tr style="border:1px solid #000;padding:4px;">
            <th colspan="12" bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;">ต้นทาง</th>
            <th colspan="12" bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;">ปลายทาง</th>
        </tr>
        <tr style="border:1px solid #000;padding:4px;">
            <th width="3%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ที่</th>
						<th width="5%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">สถานที่</th>
            <th width="8%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขไมค์</th>
            <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เวลา</th>
            <th width="6%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขที่เอกสาร</th>
            <th width="4%" colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">จำนวน</th>
            <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">สภาพ</th>
            <th width="7%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ลูกค้าลงชื่อ</th>
						<th width="5%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">สถานที่</th>
            <th width="8%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขไมค์</th>
            <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เวลา</th>
            <th width="6%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขที่เอกสาร</th>
            <th width="4%" colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">จำนวน</th>
            <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">สภาพ</th>
            <th width="7%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ลูกค้าลงชื่อ</th>
						<th width="7%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">หมายเหตุ</th>
        </tr>
        <tr style="border:1px solid #000;padding:4px;">
            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เข้า</th>
            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ขึ้นสินค้า</th>
            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ออก</th>
						<th width="3%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">Pallet</th>
            <th width="3%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">Box</th>
            <th width="3%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">OK</th>
            <th width="3%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">NG</th>

						<th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เข้า</th>
            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ขึ้นสินค้า</th>
            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ออก</th>
						<th width="3%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">Pallet</th>
            <th width="3%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">Box</th>
            <th width="3%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">OK</th>
            <th width="3%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">NG</th>

        </tr>

    </thead>';
    $table1 = '<tbody>
        <tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;">RK</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
						<td bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
            <td bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"><input type="checkbox" id="chk_conditionok1"   /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"><input type="checkbox" id="chk_conditionno1"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>

            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ><input type="checkbox" id="chk_conditionok2"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ><input type="checkbox" id="chk_conditionno2"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
        </tr>

				<tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ><input type="checkbox" id="chk_conditionok3"   /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ><input type="checkbox" id="chk_conditionno3"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>

            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionok4"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionno4" /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
        </tr>


				<tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok5"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno5" /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>

            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok6"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno6"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
        </tr>


				<tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok7"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno7" /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>

            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok8"   /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno8"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
        </tr>


				<tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok9"   /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno9"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>

            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok10"   /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno10"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
        </tr>


				<tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok11"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno11"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>

            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok12"   /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno12" /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
        </tr>


				<tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok13"   /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno13"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>

            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok14"   /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno14"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
        </tr>


				<tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok15"   /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno15"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>

            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok16"   /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno16"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
        </tr>


				<tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok17"   /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno17"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>

            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok18"   /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno18"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
        </tr>


				<tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok19"   /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno19"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>

            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok20"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno20" /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
        </tr>


				<tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok21"   /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno21"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>

            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok22"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno22"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
        </tr>

				<tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok23"   /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno23"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>

            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok24"   /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno24"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
        </tr>

				<tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok25"   /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno25"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>

            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok26"   /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno26"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
        </tr>

				<tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok27"   /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno27"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>

            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok28"   /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno28"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
        </tr>


				<tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>14
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok29"   /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno29"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>

						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  >RK</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok30"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno30"  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
        </tr>


    </tbody>';

    $table_footer = '<tfoot>
        <tr bgcolor="#CCCCCC" style="border:1px solid #000;padding:4px;">
            <td colspan="24" style="border-right:1px solid #000;padding:4px;text-align:left;">หมายเหตุ :<i>
            เมื่อท่านได้ลงลายนิ้วมือชื่อในเอกสารนี้แล้ว เอกสารนี้สามารถยืนยันได้ว่าท่านได้รับสินค้าครบถ้วนสมบูรณ์ถูกต้องตามเอกสารนี้แล้ว</i>
             </td>
        </tr>
        <tr style="border:1px solid #000;padding:4px;">
            <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;"><b><u>ปัญหา :</u></b></td>
            <td colspan="12" style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
            <td colspan="3" bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;">พนักงานขับรถ</td>
            <td colspan="4" bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;">Checked By</td>
            <td colspan="3" bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;">Approved By</td>
        </tr>
        <tr style="border-left:1px solid #000;border-right:1px solid #000;padding:4px;">
            <td colspan="14" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;">นาย '.$result_seVehicletransportplan['EMPLOYEENAME1'].'</td>
            <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;">คุณ '.$result_seEHR['nameT'].'</td>
            <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;">คุณ '.$result_seEHR['nameT'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:4px;">
            <td colspan="14" style="border-right:1px solid #000;padding:4px;text-align:left;">&nbsp;</td>
            <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;">'.$result_seSystime['SYSDATE'].'</td>
            <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;">'.$result_seSystime['SYSDATE'].'</td>
            <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;">'.$result_seSystime['SYSDATE'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:4px;">
            <td colspan="24" style="border-right:1px solid #000;padding:2px;text-align:left;font-size:8;"><b>&nbsp;FM-OPS-RKS14/08 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; แก้ไขครัั้งที่ : 00 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; มีผลบังคับใช้ :1-2-54</b></td>
        </tr>
    </tfoot>
</table>';


$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table0);
$mpdf->WriteHTML($table1);
$mpdf->WriteHTML($table_footer);
$mpdf->Output();
sqlsrv_close($conn);
?>
