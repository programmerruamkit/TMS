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
$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';

$sql_seSystime = "{call megGetdate_v2(?)}";
$params_seSystime = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
$result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);


$conditionEHR = " AND a.PersonID ='" . $_SESSION["EMPLOYEEID"] . "'";
$sql_seEHR = "{call megEmployeeEHR_v2(?,?)}";
$params_seEHR = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array($conditionEHR, SQLSRV_PARAM_IN)
);
$query_seEHR = sqlsrv_query($conn, $sql_seEHR, $params_seEHR);
$result_seEHR = sqlsrv_fetch_array($query_seEHR, SQLSRV_FETCH_ASSOC);

$condVehicledocumentrrc = " AND VEHICLETRANSPORTPLANID ='" . $_GET['vehicletransportplanid'] . "'";
$sql_seVehicledocumentrrc = "{call megVehicletransportdocumentrrc_v2(?,?)}";
$params_seVehicledocumentrrc = array(
    array('select_vehicletransportdocumentrrc', SQLSRV_PARAM_IN),
    array($condVehicledocumentrrc, SQLSRV_PARAM_IN)
);
$query_seVehicledocumentrrc = sqlsrv_query($conn, $sql_seVehicledocumentrrc, $params_seVehicledocumentrrc);
$result_seVehicledocumentrrc = sqlsrv_fetch_array($query_seVehicledocumentrrc, SQLSRV_FETCH_ASSOC);

$condCounttripnumber = " AND VEHICLETRANSPORTPLANID ='" . $_GET['vehicletransportplanid'] . "'";
$sql_seCounttripnumber = "{call megVehicletransportdocumentrrc_v2(?,?)}";
$params_seCounttripnumber = array(
    array('select_counttripnumber', SQLSRV_PARAM_IN),
    array($condCounttripnumber, SQLSRV_PARAM_IN)
);
$query_seCounttripnumber = sqlsrv_query($conn, $sql_seCounttripnumber, $params_seCounttripnumber);
$result_seCounttripnumber = sqlsrv_fetch_array($query_seCounttripnumber, SQLSRV_FETCH_ASSOC);

if ($_GET['vehicletransportplanid'] != "") {
    $condition2_1 = " AND a.VEHICLETRANSPORTPLANID = '" . $_GET['vehicletransportplanid'] . "'";
    $condition2_2 = "";
    $condition2_3 = "";
} else {
    $condition2_1 = " AND (a.EMPLOYEECODE1 ='" . $result_seEHR['PersonCode'] . "' OR a.EMPLOYEECODE2 ='" . $result_seEHR['PersonCode'] . "')";
    $condition2_2 = " AND (CONVERT(DATE,a.DATEPRESENT) BETWEEN CONVERT(DATE,GETDATE(),103) AND CONVERT(DATE,GETDATE(),103))";
    $condition2_3 = "";
}
$sql_seVehicletransportplan2 = "{call megVehicletransportplan_v2(?,?,?,?)}";
$params_seVehicletransportplan2 = array(
    array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
    array($condition2_1, SQLSRV_PARAM_IN),
    array($condition2_2, SQLSRV_PARAM_IN),
    array($condition2_3, SQLSRV_PARAM_IN)
);
$query_seVehicletransportplan2 = sqlsrv_query($conn, $sql_seVehicletransportplan2, $params_seVehicletransportplan2);
$result_seVehicletransportplan2 = sqlsrv_fetch_array($query_seVehicletransportplan2, SQLSRV_FETCH_ASSOC);
$var_employee2 = ($result_seVehicletransportplan['EMPLOYEENAME2']!="")? '2.'.$result_seVehicletransportplan['EMPLOYEENAME2']:'';

$employeecode = "";
$employeename = "";
$vehicletransportplan = $result_seVehicletransportplan2['VEHICLETRANSPORTPLANID'];
$companycode = $result_seVehicletransportplan2['COMPANYCODE'];
$datevlin = $result_seVehicletransportplan2['DATEVLIN'];
$jobend = $result_seVehicletransportplan2['JOBNO'];
$E1 = "";
if ($result_seEHR['PersonCode'] == $result_seVehicletransportplan2['EMPLOYEECODE1']) {
    $E1 = $result_seVehicletransportplan2['E1'];
} else {
    $E1 = $result_seVehicletransportplan2['E2'];
}
$E3 = $result_seVehicletransportplan2['E3'];
$E4 = $result_seVehicletransportplan2['E4'];
$C1 = $result_seVehicletransportplan2['C1'];
$C2 = $result_seVehicletransportplan2['C2'];
$C3 = $result_seVehicletransportplan2['C3'];
$C4 = $result_seVehicletransportplan2['C4'];
$C5 = $result_seVehicletransportplan2['C5'];
$C6 = $result_seVehicletransportplan2['C6'];
$C9 = $result_seVehicletransportplan2['C9'];
if ($result_seEHR['PersonCode'] == $result_seVehicletransportplan2['EMPLOYEECODE1']) {
    $employeecode = $result_seVehicletransportplan2['EMPLOYEECODE1'];
    $employeename = $result_seVehicletransportplan2['EMPLOYEENAME1'];
} else {
    $employeecode = $result_seVehicletransportplan2['EMPLOYEECODE2'];
    $employeename = $result_seVehicletransportplan2['EMPLOYEENAME2'];
}

$condition_doc = " AND VEHICLETRANSPORTPLANID ='" . $vehicletransportplan . "'";
$sql_seDoc = "{call megVehicletransportdocument_v2(?,?)}";
$params_seDoc = array(
    array('select_vehicletransportdocument', SQLSRV_PARAM_IN),
    array($condition_doc, SQLSRV_PARAM_IN)
);
$query_seDoc = sqlsrv_query($conn, $sql_seDoc, $params_seDoc);
$result_seDoc = sqlsrv_fetch_array($query_seDoc, SQLSRV_FETCH_ASSOC);

$condMileage = " AND VEHICLEREGISNUMBER ='" . $result_seVehicletransportplan2['VEHICLEREGISNUMBER1'] . "'";
$sql_seMileage = "{call megMileage_v2(?,?)}";
$params_seMileage = array(
    array('select_maxmileage', SQLSRV_PARAM_IN),
    array($condMileage, SQLSRV_PARAM_IN)
);
$query_seMileage = sqlsrv_query($conn, $sql_seMileage, $params_seMileage);
$result_seMileage = sqlsrv_fetch_array($query_seMileage, SQLSRV_FETCH_ASSOC);


$condcompany = " AND Company_Code ='" . $companycode . "'";
$sql_seCompany = "{call megCompanyEHR_v2(?,?)}";
$params_seCompany = array(
    array('select_company', SQLSRV_PARAM_IN),
    array($condcompany, SQLSRV_PARAM_IN)
);
$query_seCompany = sqlsrv_query($conn, $sql_seCompany, $params_seCompany);
$result_seCompany = sqlsrv_fetch_array($query_seCompany, SQLSRV_FETCH_ASSOC);

$checkprojectttast = ($result_seVehicledocumentrrc['PROJECTNAME'] == 'TTAST') ? "checked='true'" : "";
$checkprojectother = ($result_seVehicledocumentrrc['PROJECTNAME'] != 'TTAST') ? "checked='true'" : "";
$checkcompanysab = ($result_seVehicledocumentrrc['COMPANYNAME'] == 'SAB') ? "checked='true'" : "";
$checkcompanyynp = ($result_seVehicledocumentrrc['COMPANYNAME'] == 'YNP') ? "checked='true'" : "";
$checkcompanych = ($result_seVehicledocumentrrc['COMPANYNAME'] == 'CH') ? "checked='true'" : "";
$checkcompanytoy = ($result_seVehicledocumentrrc['COMPANYNAME'] == 'TOY') ? "checked='true'" : "";
$checkcompanyhino = ($result_seVehicledocumentrrc['COMPANYNAME'] == 'HINO') ? "checked='true'" : "";
$checkcompanyotc = ($result_seVehicledocumentrrc['COMPANYNAME'] == 'OTC') ? "checked='true'" : "";
$checkcompanytsa = ($result_seVehicledocumentrrc['COMPANYNAME'] == 'TSA') ? "checked='true'" : "";
$checkcompanyother = ($result_seVehicledocumentrrc['COMPANYNAME'] == 'SAB' || $result_seVehicledocumentrrc['COMPANYNAME'] == 'YNP' || $result_seVehicledocumentrrc['COMPANYNAME'] == 'CH' || $result_seVehicledocumentrrc['COMPANYNAME'] == 'TOY' || $result_seVehicledocumentrrc['COMPANYNAME'] == 'HINO' || $result_seVehicledocumentrrc['COMPANYNAME'] == 'OTC' || $result_seVehicledocumentrrc['COMPANYNAME'] == 'TSA') ? "" : "checked='true'";
$checkworkingd = ($result_seVehicledocumentrrc['WORKING'] == 'D') ? "checked='true'" : "";
$checkworkingn = ($result_seVehicledocumentrrc['WORKING'] == 'N') ? "checked='true'" : "";
$checkuniformcompany = ($result_seVehicledocumentrrc['UNIFORMCOMPANYDATA'] == 'แต่งกายด้วยชุดฟอร์มของบริษัทฯ') ? "checked='true'" : "";
$checkuniformsafety = ($result_seVehicledocumentrrc['UNIFORMSAFETYDATA'] == 'ใส่อุปกรณ์เซฟตี้ทุกครั้งขณะปฏิบัติงาน') ? "checked='true'" : "";
$checkvehicle = ($result_seVehicledocumentrrc['VEHICLEDATA'] == 'ตรวจเช็คสภาพความพร้อมของรถก่อนใช้งาน') ? "checked='true'" : "";
$checkregularity = ($result_seVehicledocumentrrc['REGULARITYDATA'] == 'ปฏิบัติตามกฏระเบียบของลูกค้าอย่างเคร่งครัด') ? "checked='true'" : "";
$checkconditionok1 = ($result_seVehicledocumentrrc['BEGIN_CONDITION1'] == '1') ? "checked='true'" : "";
$checkconditionno1 = ($result_seVehicledocumentrrc['BEGIN_CONDITION1'] == '0') ? "checked='true'" : "";
$checkconditionok2 = ($result_seVehicledocumentrrc['BEGIN_CONDITION2'] == '1') ? "checked='true'" : "";
$checkconditionno2 = ($result_seVehicledocumentrrc['BEGIN_CONDITION2'] == '0') ? "checked='true'" : "";
$checkconditionok3 = ($result_seVehicledocumentrrc['BEGIN_CONDITION3'] == '1') ? "checked='true'" : "";
$checkconditionno3 = ($result_seVehicledocumentrrc['BEGIN_CONDITION3'] == '0') ? "checked='true'" : "";
$checkconditionok4 = ($result_seVehicledocumentrrc['BEGIN_CONDITION4'] == '1') ? "checked='true'" : "";
$checkconditionno4 = ($result_seVehicledocumentrrc['BEGIN_CONDITION4'] == '0') ? "checked='true'" : "";
$checkconditionok5 = ($result_seVehicledocumentrrc['BEGIN_CONDITION5'] == '1') ? "checked='true'" : "";
$checkconditionno5 = ($result_seVehicledocumentrrc['BEGIN_CONDITION5'] == '0') ? "checked='true'" : "";
$checkconditionok6 = ($result_seVehicledocumentrrc['BEGIN_CONDITION6'] == '1') ? "checked='true'" : "";
$checkconditionno6 = ($result_seVehicledocumentrrc['BEGIN_CONDITION6'] == '0') ? "checked='true'" : "";
$checkconditionok7 = ($result_seVehicledocumentrrc['BEGIN_CONDITION7'] == '1') ? "checked='true'" : "";
$checkconditionno7 = ($result_seVehicledocumentrrc['BEGIN_CONDITION7'] == '0') ? "checked='true'" : "";
$checkconditionok8 = ($result_seVehicledocumentrrc['BEGIN_CONDITION8'] == '1') ? "checked='true'" : "";
$checkconditionno8 = ($result_seVehicledocumentrrc['BEGIN_CONDITION8'] == '0') ? "checked='true'" : "";
$checkconditionok9 = ($result_seVehicledocumentrrc['BEGIN_CONDITION9'] == '1') ? "checked='true'" : "";
$checkconditionno9 = ($result_seVehicledocumentrrc['BEGIN_CONDITION9'] == '0') ? "checked='true'" : "";
$checkconditionok10 = ($result_seVehicledocumentrrc['BEGIN_CONDITION10'] == '1') ? "checked='true'" : "";
$checkconditionno10 = ($result_seVehicledocumentrrc['BEGIN_CONDITION10'] == '0') ? "checked='true'" : "";
$checkconditionok11 = ($result_seVehicledocumentrrc['BEGIN_CONDITION11'] == '1') ? "checked='true'" : "";
$checkconditionno11 = ($result_seVehicledocumentrrc['BEGIN_CONDITION11'] == '0') ? "checked='true'" : "";
$checkconditionok12 = ($result_seVehicledocumentrrc['BEGIN_CONDITION12'] == '1') ? "checked='true'" : "";
$checkconditionno12 = ($result_seVehicledocumentrrc['BEGIN_CONDITION12'] == '0') ? "checked='true'" : "";
$checkconditionok13 = ($result_seVehicledocumentrrc['BEGIN_CONDITION13'] == '1') ? "checked='true'" : "";
$checkconditionno13 = ($result_seVehicledocumentrrc['BEGIN_CONDITION13'] == '0') ? "checked='true'" : "";
$checkconditionok14 = ($result_seVehicledocumentrrc['BEGIN_CONDITION14'] == '1') ? "checked='true'" : "";
$checkconditionno14 = ($result_seVehicledocumentrrc['BEGIN_CONDITION14'] == '0') ? "checked='true'" : "";
$checkconditionok15 = ($result_seVehicledocumentrrc['BEGIN_CONDITION15'] == '1') ? "checked='true'" : "";
$checkconditionno15 = ($result_seVehicledocumentrrc['BEGIN_CONDITION15'] == '0') ? "checked='true'" : "";

$txt_companyother = ($result_seVehicledocumentrrc['COMPANYNAME'] == "SAB" || $result_seVehicledocumentrrc['COMPANYNAME'] == "YNP" || $result_seVehicledocumentrrc['COMPANYNAME'] == "CH" || $result_seVehicledocumentrrc['COMPANYNAME'] == "TOY" || $result_seVehicledocumentrrc['COMPANYNAME'] == "HINO" || $result_seVehicledocumentrrc['COMPANYNAME'] == "OTC" || $result_seVehicledocumentrrc['COMPANYNAME'] == "TSA") ? "" : $result_seVehicledocumentrrc['COMPANYNAME'];
$txt_projectother = ($result_seVehicledocumentrrc['PROJECTNAME'] == "TTAST") ? "" : $result_seVehicledocumentrrc['PROJECTNAME'];
$table1 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
    <thead>

        <tr style="border:1px solid #000;padding:4px;">
            <th  style="border-right:1px solid #000;padding:4px;text-align:center;"><img src="../images/logo.png" height="30"></th>
            <th colspan="5"  style="border-right:1px solid #000;padding:4px;text-align:center;">TRANSPORT GOODS TIME FOR TTAST</th>
            <th colspan="10"  style="border-right:1px solid #000;padding:4px;text-align:center;">บริษัท ร่วมกิจ รีไซเคิล แคริเออร์ จำกัด / 109 / 1 ม.9 ต.หัวสำโรง อ.แปลงยาว จ.ฉะเชิงเทรา 24190 Tel : 038-589225 Fax : 038-086720</th>
        </tr>
        <tr style="border:1px solid #000;padding:4px;">
        <th  bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">
            <!--<input type="checkbox" <?//= $checkprojectttast ?> id="chk_projectttast"  onchange="chk_projectttast()"/>-->
            ต้นทาง
        </th>
        <th colspan="5" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;">
            '.$result_seVehicletransportplan2['JOBSTART'].'
        </th>

        <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">การทำงาน</th>
        <th colspan="4" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">พขร.</th>
        <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ทะเบียน</th>
        <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">วัน-เดือน-ปี</th>
        <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">JOBNO</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th  bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">
            <!--<input type="checkbox" <?//= $checkprojectttast ?> id="chk_projectttast"  onchange="chk_projectttast()"/>-->
            ปลายทาง
        </th>
        <th colspan="5" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;">
            '.$result_seVehicletransportplan2['JOBEND'].'
        </th>

        <th  style="border-right:1px solid #000;padding:4px;text-align:center;">

            <input type="checkbox" '.$checkworkingd.' id="chk_workd" onchange="chk_workd()"/>
            D&nbsp;
            <input type="checkbox" '.$checkworkingn.' id="chk_workn" onchange="chk_workn()"/>
            N</th>
        <th colspan="4"  style="border-right:1px solid #000;padding:4px;text-align:left;">1.'.$result_seVehicletransportplan2['EMPLOYEENAME1'].''.$var_employee2.'</th>
        <th colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seVehicletransportplan2['VEHICLEREGISNUMBER1'].'</th>
        <th colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seVehicletransportplan2['DATE_VLIN'].'</th>
        <th  style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seVehicletransportplan2['JOBNO'].'</th>
    </tr>
        <tr style="border:1px solid #000;padding:4px;">
            <th  style="border-right:1px solid #000;padding:4px;text-align:center;">
                <input type="checkbox" id="chk_uniformcompany"  '.$checkuniformcompany.' />        
            </th>
            <th colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:left;">แต่งกายด้วยชุดฟอร์มของบริษัทฯ</th>
            <th  style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_uniformsafety" '.$checkuniformsafety.' /></th>
            <th colspan="4"  style="border-right:1px solid #000;padding:4px;text-align:left;">ใส่อุปกรณ์เซฟตี้ทุกครั้งขณะปฏิบัติงาน</th>
            <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขไมล์ก่อนออก</th>
            <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขไมล์เสร็จ</th>
            <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">น้ำมัน (ลิตร)</th>
            <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">รวม (กม)</th>
        </tr>
        <tr style="border:1px solid #000;padding:4px;">
            <th  style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_vehicle" '.$checkuniformsafety.' /></th>
            <th colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจเช็คสภาพความพร้อมของรถก่อนใช้งาน</th>
            <th  style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_regularity"  '.$checkregularity.' /></th>
            <th colspan="4"  style="border-right:1px solid #000;padding:4px;text-align:left;">ปฏิบัติตามกฏระเบียบของลูกค้าอย่างเคร่งครัด</th>
            <th colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;"   >'.$result_seMileage['MAXMILEAGENUMBER'].'</th>
            <th colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;"  ></th>
            <th colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;">-</th>
            <th  style="border-right:1px solid #000;padding:4px;text-align:center;"><div id="kmsum"></div></th>
        </tr>
        <tr style="border:1px solid #000;padding:4px;">
            <th colspan="11"  style="border-right:1px solid #000;padding:4px;text-align:center;">ต้นทาง</th>
            <th colspan="5"  style="border-right:1px solid #000;padding:4px;text-align:center;">ปลายทาง</th>
        </tr>
        <tr style="border:1px solid #000;padding:4px;">
            <th width="5%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ที่</th>
            <th width="10%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขไมค์ต้นทาง</th>
            <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เวลา</th>
            <th width="5%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ลำดับ</th>
            <th width="5%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขที่เอกสาร</th>
            <th width="5%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">น้ำหนัก</th>
            <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">สภาพ</th>
            <th width="10%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ลายเซนต์ลูกค้าต้นทาง</th>
            <th width="10%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขไมค์ปลายทาง</th>
            <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เวลา</th>
            <th width="10%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ลายเซนต์ลูกค้าปลายทาง</th>
        </tr>
        <tr style="border:1px solid #000;padding:4px;">
            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เข้า</th>
            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ขึ้นสินค้า</th>
            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ออก</th>
            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">OK</th>
            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">NG</th>
            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เข้า</th>
            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ลงสินค้า</th>
            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ออก</th>
        </tr>
    </thead>';
    $table2 = '<tbody>
        <tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">1</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;">'.$result_seMileage['MAXMILEAGENUMBER'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEIN1'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT1'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEOUT1'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">1</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER1'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_WEIGHT1'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok1" '.$checkconditionok1.'  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno1" '.$checkconditionno1.' /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_CUSTOMER1'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_MILES1'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEIN1'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEINPRODUCT1'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEOUT1'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_CUSTOMER1'].'</td>

        </tr><tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">2</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEIN2'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT2'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEOUT2'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">2</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER2'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_WEIGHT2'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok2" '.$checkconditionok2.'  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno2" '.$checkconditionno2.' /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_CUSTOMER2'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_MILES2'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEIN2'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEINPRODUCT2'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEOUT2'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_CUSTOMER2'].'</td>
        </tr><tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">3</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEIN3'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT3'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEOUT3'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">3</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER3'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_WEIGHT3'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok3" '.$checkconditionok3.'  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno3" '.$checkconditionno3.' /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_CUSTOMER3'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_MILES3'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEIN3'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEINPRODUCT3'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEOUT3'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_CUSTOMER3'].'</td>
        </tr><tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">4</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEIN4'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT4'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEOUT4'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">4</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER4'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_WEIGHT4'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok4" '.$checkconditionok4.' /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno4" '.$checkconditionno4.' /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_CUSTOMER4'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_MILES4'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEIN4'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEINPRODUCT4'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEOUT4'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_CUSTOMER4'].'</td>
        </tr><tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">5</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEIN5'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT5'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEOUT5'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">5</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER5'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_WEIGHT5'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok5" '.$checkconditionok5.'  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno5" '.$checkconditionno5.' /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_CUSTOMER5'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_MILES5'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEIN5'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEINPRODUCT5'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEOUT5'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_CUSTOMER5'].'</td>
        </tr>';
        $table3 = '<tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">6</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEIN6'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT6'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEOUT6'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">6</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER6'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_WEIGHT6'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok6" '.$checkconditionok6.'  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno6" '.$checkconditionno6.' /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_CUSTOMER6'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_MILES6'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEIN6'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEINPRODUCT6'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEOUT6'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_CUSTOMER6'].'</td>
        </tr><tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">7</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEIN7'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT7'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEOUT7'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">7</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER7'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_WEIGHT7'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok7" '.$checkconditionok7.'  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno7" '.$checkconditionno7.' /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_CUSTOMER7'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_MILES7'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEIN7'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEINPRODUCT7'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEOUT7'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_CUSTOMER7'].'</td>
        </tr><tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">8</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEIN8'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT8'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEOUT8'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">8</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER8'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_WEIGHT8'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok8" '.$checkconditionok8.'  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno8" '.$checkconditionno8.' /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_CUSTOMER8'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_MILES8'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEIN8'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEINPRODUCT8'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEOUT8'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_CUSTOMER8'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">9</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEIN9'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT9'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEOUT9'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">9</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER9'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_WEIGHT9'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok9" '.$checkconditionok9.'  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno9" '.$checkconditionno9.' /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_CUSTOMER9'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_MILES9'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEIN9'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEINPRODUCT9'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEOUT9'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_CUSTOMER9'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">10</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEIN10'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT10'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEOUT10'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">10</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER10'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_WEIGHT10'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok10" '.$checkconditionok10.'  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno10" '.$checkconditionno10.' /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_CUSTOMER10'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_MILES10'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEIN10'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEINPRODUCT10'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEOUT10'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_CUSTOMER10'].'</td>
        </tr>';
        
        $table4 = '<tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">11</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEIN11'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT11'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEOUT11'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">11</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER11'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_WEIGHT11'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok11" '.$checkconditionok11.'  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno11" '.$checkconditionno11.' /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_CUSTOMER11'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_MILES11'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEIN11'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEINPRODUCT11'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEOUT11'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_CUSTOMER11'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">12</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEIN12'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT12'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEOUT12'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">12</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER12'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_WEIGHT12'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok12" '.$checkconditionok12.'  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno12" '.$checkconditionno12.' /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_CUSTOMER12'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_MILES12'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEIN12'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEINPRODUCT12'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEOUT12'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_CUSTOMER12'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">13</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEIN13'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT13'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEOUT13'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">13</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER13'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_WEIGHT13'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok13" '.$checkconditionok13.'  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno13" '.$checkconditionno13.' /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_CUSTOMER13'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_MILES13'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEIN13'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEINPRODUCT13'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEOUT13'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_CUSTOMER13'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">14</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEIN14'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT14'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEOUT14'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">14</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER14'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_WEIGHT14'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok14" '.$checkconditionok14.'  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno14" '.$checkconditionno14.' /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_CUSTOMER14'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_MILES14'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEIN14'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEINPRODUCT14'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEOUT14'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_CUSTOMER14'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">15</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEIN15'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT15'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_TIMEOUT15'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">15</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER15'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_WEIGHT15'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok15" '.$checkconditionok15.'  /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno15" '.$checkconditionno15.' /></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['BEGIN_CUSTOMER15'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_MILES15'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEIN15'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEINPRODUCT15'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_TIMEOUT15'].'</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"  >'.$result_seVehicledocumentrrc['END_CUSTOMER15'].'</td>
        </tr>
    </tbody>';
        
    $table5 = '<tfoot>
        <tr style="border:1px solid #000;padding:4px;">
            <td colspan="16" style="border-right:1px solid #000;padding:4px;text-align:left;">&nbsp;</td>
        </tr>
        <tr style="border:1px solid #000;padding:4px;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ปัญหา :</b></td>
            <td colspan="7" style="border-right:1px solid #000;padding:4px;text-align:left;">'.$result_seVehicledocumentrrc['REMARK'].'</td>
            <td colspan="3" bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;">พนักงานขับรถ</td>
            <td colspan="2" bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;">Checked By</td>
            <td colspan="3" bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;">Approved By</td>
        </tr>
        <tr style="border:1px solid #000;padding:4px;">
            <td colspan="8" style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
            <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">นาย '.$employeename.'</td>
            <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">คุณ '.$result_seEHR['nameT'].'</td>
            <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">คุณ '.$result_seEHR['nameT'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:4px;">
            <td colspan="8" style="border-right:1px solid #000;padding:4px;text-align:left;">&nbsp;</td>
            <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seSystime['SYSDATE'].'</td>
            <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seSystime['SYSDATE'].'</td>
            <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seSystime['SYSDATE'].'</td>
        </tr>
    </tfoot>
</table>';


$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table1);
$mpdf->WriteHTML($table2);
$mpdf->WriteHTML($table3);
$mpdf->WriteHTML($table4);
$mpdf->WriteHTML($table5);
$mpdf->Output();
sqlsrv_close($conn);
?>

