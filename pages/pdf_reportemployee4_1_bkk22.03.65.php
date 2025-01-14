
<?php

session_start();
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
//$mpdf = new mPDF();
$mpdf = new mPDF('th', 'A4', '0', '');

$condition1 = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
$sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmployee = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
$result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);

if ($_GET['vehicletransportplanid'] != '') {
    $conditionPlain = " AND a.VEHICLETRANSPORTPLANID = '" . $_GET['vehicletransportplanid'] . "'";
    $sql_sePlain = "{call megVehicletransportplan_v2(?,?)}";
    $params_sePlain = array(
        array('select_vehicletransportplan', SQLSRV_PARAM_IN),
        array($conditionPlain, SQLSRV_PARAM_IN)
    );
    $query_sePlain = sqlsrv_query($conn, $sql_sePlain, $params_sePlain);
    $result_sePlain = sqlsrv_fetch_array($query_sePlain, SQLSRV_FETCH_ASSOC);
}
$conditionDir = "  AND a.PersonCode = '" . $_GET["employeecode"] . "'";
$sql_seDir = "{call megEmployeeEHR_v2(?,?)}";
$params_seDir = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array($conditionDir, SQLSRV_PARAM_IN)
);
$query_seDir = sqlsrv_query($conn, $sql_seDir, $params_seDir);
$result_seDir = sqlsrv_fetch_array($query_seDir, SQLSRV_FETCH_ASSOC);

$condTenkomaster = " AND (a.TENKOMASTERDIRVERCODE1 = '" . $_GET['employeecode'] . "' OR a.TENKOMASTERDIRVERCODE2 = '" . $_GET['employeecode'] . "') AND a.TENKOMASTERID = '" . $_GET['tenkomasterid'] . "'";
$sql_seTenkomaster = "{call megEdittenkomaster_v2(?,?)}";
$params_seTenkomaster = array(
    array('select_tenkomaster', SQLSRV_PARAM_IN),
    array($condTenkomaster, SQLSRV_PARAM_IN)
);
$query_seTenkomaster = sqlsrv_query($conn, $sql_seTenkomaster, $params_seTenkomaster);
$result_seTenkomaster = sqlsrv_fetch_array($query_seTenkomaster, SQLSRV_FETCH_ASSOC);

$condTenkobefor1 = " AND a.TENKOMASTERDIRVERCODE = '" . $_GET['employeecode'] . "' ";
$condTenkobefor2 = " AND a.TENKOMASTERID = '" . $_GET['tenkomasterid'] . "'";
$sql_seTenkobefor = "{call megEdittenkobefore_v2(?,?,?,?)}";
$params_seTenkobefor = array(
    array('select_tenkobefore', SQLSRV_PARAM_IN),
    array($condTenkobefor1, SQLSRV_PARAM_IN),
    array($condTenkobefor2, SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seTenkobefor = sqlsrv_query($conn, $sql_seTenkobefor, $params_seTenkobefor);
$result_seTenkobefor = sqlsrv_fetch_array($query_seTenkobefor, SQLSRV_FETCH_ASSOC);

$TENKOBEFOREBY1 =  $result_seTenkobefor["CREATEBY"];

if ($_GET['vehicletransportplanid'] == '') {

    $conditionPlain = " AND a.VEHICLETRANSPORTPLANID = '" . $result_seTenkomaster['VEHICLETRANSPORTPLANID'] . "'";
    $sql_sePlain = "{call megVehicletransportplan_v2(?,?)}";
    $params_sePlain = array(
        array('select_vehicletransportplan', SQLSRV_PARAM_IN),
        array($conditionPlain, SQLSRV_PARAM_IN)
    );
    $query_sePlain = sqlsrv_query($conn, $sql_sePlain, $params_sePlain);
    $result_sePlain = sqlsrv_fetch_array($query_sePlain, SQLSRV_FETCH_ASSOC);
}
$sql_seChktenkorest = "SELECT DATEDIFF(HOUR,
                    (SELECT TOP 1 MODIFIEDDATE FROM [dbo].[TENKOAFTER] WHERE [TENKOMASTERDIRVERCODE] = '" . $_GET['employeecode'] . "' ORDER BY [MODIFIEDDATE]  DESC)
                    ,(SELECT GETDATE()))  AS 'TENKORESTDATA'";
$query_seChktenkorest = sqlsrv_query($conn, $sql_seChktenkorest, $params_seChktenkorest);
$result_seChktenkorest = sqlsrv_fetch_array($query_seChktenkorest, SQLSRV_FETCH_ASSOC);
//edit_tenkobeforetxt1($result_seChktenkorest['TENKORESTDATA'], 'TENKORESTDATA', $result_seTenkobefore['TENKOBEFOREID']);
//editTenkobefore('edit_tenkobefore', $result_seTenkobefore['TENKOBEFOREID'], 'TENKORESTDATA', $result_seChktenkorest['TENKORESTDATA']);
//editTenkobefore('edit_tenkobefore', $result_seTenkobefore['TENKOBEFOREID'], 'TENKORESTRESULT', 1);
$RS_TENKORESTDATA = ($result_seTenkobefor['TENKORESTDATA']);

$TENKOBEFOREGREETCHECK = ($result_seTenkobefor['TENKOBEFOREGREETCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOUNIFORMCHECK = ($result_seTenkobefor['TENKOUNIFORMCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOBODYCHECK = ($result_seTenkobefor['TENKOBODYCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKORESTCHECK = ($result_seTenkobefor['TENKORESTCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOSLEEPTIMECHECK = ($result_seTenkobefor['TENKOSLEEPTIMECHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOTEMPERATURECHECK = ($result_seTenkobefor['TENKOTEMPERATURECHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOPRESSURECHECK = ($result_seTenkobefor['TENKOPRESSURECHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOALCOHOLCHECK = ($result_seTenkobefor['TENKOALCOHOLCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOOXYGENCHECK = ($result_seTenkobefor['TENKOOXYGENCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOWORRYCHECK = ($result_seTenkobefor['TENKOWORRYCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKODAILYTRAILERCHECK = ($result_seTenkobefor['TENKODAILYTRAILERCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOCARRYCHECK = ($result_seTenkobefor['TENKOCARRYCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOJOBDETAILCHECK = ($result_seTenkobefor['TENKOJOBDETAILCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOLOADINFORMCHECK = ($result_seTenkobefor['TENKOLOADINFORMCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOAIRINFORMCHECK = ($result_seTenkobefor['TENKOAIRINFORMCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOYOKOTENCHECK = ($result_seTenkobefor['TENKOYOKOTENCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOCHIMOLATORCHECK = ($result_seTenkobefor['TENKOCHIMOLATORCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOTRANSPORTCHECK = ($result_seTenkobefor['TENKOTRANSPORTCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOAFTERGREETCHECK = ($result_seTenkobefor['TENKOAFTERGREETCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";

//ตรวจสอบปัฐหาสุขภาพ
$TENKOBEFORESHORTSIGHTCHECK = ($result_seTenkobefor['TENKOSHORTSIGHTCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOBEFORESHORTSIGHTRESULT1 = ($result_seTenkobefor['TENKOSHORTSIGHTRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOBEFORESHORTSIGHTRESULT0 = ($result_seTenkobefor['TENKOSHORTSIGHTRESULT'] != "1" ) ? "<img src='../images/ok.png' width='2%'>" : "";

$TENKOBEFORELONGSIGHTCHECK = ($result_seTenkobefor['TENKOLONGSIGHTCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOBEFORELONGSIGHTRESULT1 = ($result_seTenkobefor['TENKOLONGSIGHTRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOBEFORELONGSIGHTRESULT0 = ($result_seTenkobefor['TENKOLONGSIGHTRESULT'] != "1" ) ? "<img src='../images/ok.png' width='2%'>" : "";


$TENKOBEFOREOBLIQUESIGHTCHECK = ($result_seTenkobefor['TENKOOBLIQUESIGHTCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOBEFOREOBLIQUESIGHTRESULT1 = ($result_seTenkobefor['TENKOOBLIQUESIGHTRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOBEFOREOBLIQUESIGHTRESULT0 = ($result_seTenkobefor['TENKOOBLIQUESIGHTRESULT'] != "1" ) ? "<img src='../images/ok.png' width='2%'>" : "";








$TENKOBEFOREGREETRESULT1 = ($result_seTenkobefor['TENKOBEFOREGREETRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOUNIFORMRESULT1 = ($result_seTenkobefor['TENKOUNIFORMRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOBODYRESULT1 = ($result_seTenkobefor['TENKOBODYRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKORESTRESULT1 = ($result_seTenkobefor['TENKORESTDATA'] > 7) ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOSLEEPTIMERESULT1 = ($result_seTenkobefor['TENKOSLEEPTIMERESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOTEMPERATURERESULT1 = ($result_seTenkobefor['TENKOTEMPERATURERESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOPRESSURERESULT1 = ($result_seTenkobefor['TENKOPRESSURERESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOALCOHOLRESULT1 = ($result_seTenkobefor['TENKOALCOHOLRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOOXYGENRESULT1 = ($result_seTenkobefor['TENKOOXYGENRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOWORRYRESULT1 = ($result_seTenkobefor['TENKOWORRYRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKODAILYTRAILERRESULT1 = ($result_seTenkobefor['TENKODAILYTRAILERRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOCARRYRESULT1 = ($result_seTenkobefor['TENKOCARRYRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOJOBDETAILRESULT1 = ($result_seTenkobefor['TENKOJOBDETAILRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOLOADINFORMRESULT1 = ($result_seTenkobefor['TENKOLOADINFORMRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOAIRINFORMRESULT1 = ($result_seTenkobefor['TENKOAIRINFORMRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOYOKOTENRESULT1 = ($result_seTenkobefor['TENKOYOKOTENRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOCHIMOLATORRESULT1 = ($result_seTenkobefor['TENKOCHIMOLATORRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOTRANSPORTRESULT1 = ($result_seTenkobefor['TENKOTRANSPORTRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOAFTERGREETRESULT1 = ($result_seTenkobefor['TENKOAFTERGREETRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";

$TENKOBEFOREGREETRESULT0 = ($result_seTenkobefor['TENKOBEFOREGREETRESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOUNIFORMRESULT0 = ($result_seTenkobefor['TENKOUNIFORMRESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOBODYRESULT0 = ($result_seTenkobefor['TENKOBODYRESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKORESTRESULT0 = ($result_seTenkobefor['TENKORESTDATA'] < 8) ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOSLEEPTIMERESULT0 = ($result_seTenkobefor['TENKOSLEEPTIMERESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOTEMPERATURERESULT0 = ($result_seTenkobefor['TENKOTEMPERATURERESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOPRESSURERESULT0 = ($result_seTenkobefor['TENKOPRESSURERESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOALCOHOLRESULT0 = ($result_seTenkobefor['TENKOALCOHOLRESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOOXYGENRESULT0 = ($result_seTenkobefor['TENKOOXYGENRESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOWORRYRESULT0 = ($result_seTenkobefor['TENKOWORRYRESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKODAILYTRAILERRESULT0 = ($result_seTenkobefor['TENKODAILYTRAILERRESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOCARRYRESULT0 = ($result_seTenkobefor['TENKOCARRYRESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOJOBDETAILRESULT0 = ($result_seTenkobefor['TENKOJOBDETAILRESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOLOADINFORMRESULT0 = ($result_seTenkobefor['TENKOLOADINFORMRESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOAIRINFORMRESULT0 = ($result_seTenkobefor['TENKOAIRINFORMRESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOYOKOTENRESULT0 = ($result_seTenkobefor['TENKOYOKOTENRESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOCHIMOLATORRESULT0 = ($result_seTenkobefor['TENKOCHIMOLATORRESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOTRANSPORTRESULT0 = ($result_seTenkobefor['TENKOTRANSPORTRESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOAFTERGREETRESULT0 = ($result_seTenkobefor['TENKOAFTERGREETRESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";

$TENKOTARGET1 = ($result_seTenkomaster['TENKOTARGET1'] == '1') ? "-ขับเว้นระยะห่าง 3 วิ" : "";
$TENKOTARGET2 = ($result_seTenkomaster['TENKOTARGET2'] == '1') ? "-ควบคุมพวงมาลัยให้คงที่" : "";
$TENKOTARGET3 = ($result_seTenkomaster['TENKOTARGET3'] == '1') ? "-ให้ใช้ความเร็วต่ำขณะผ่านที่ชุมชน" : "";
$TENKOTARGET4 = ($result_seTenkomaster['TENKOTARGET4'] == '1') ? "-ง่วงไม่ฝืนขับ" : "";
$TENKOTARGET5 = ($result_seTenkomaster['TENKOTARGET5'] == '1') ? "-ปฎิบัติงานตามขั้นตอน" : "";
$TENKOTARGET6 = ($result_seTenkomaster['TENKOTARGET6'] == '1') ? "-ขับขี่ตามกฎจราจร" : "";
$TENKOTARGET7 = ($result_seTenkomaster['TENKOTARGET7'] == '1') ? "-พบสิ่งผิดปกติให้ หยุด-เรียก-รอ" : "";
$comp = '';
switch ($result_sePlain['COMPANYCODE']) {
    case 'RKR': {
            $comp = 'Ruamkit Rungrueng (1993) Co., Ltd.';
        }
        break;
    case 'RKL': {
            $comp = 'Ruamkit Rungrueng Logistics Co., Ltd.';
        }
        break;
    case 'RKS': {
            $comp = 'Ruamkit Rungrueng Service Co., Ltd.';
        }
        break;
    default : {
            $comp = 'Toyota Transport (Thailand) Co.,LTD.';
        }
        break;
}
$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';
$TENKOMASTERVEHICLE = "";
if ($_GET['vehicletransportplanid'] == '' || $_GET['tenkomasterid'] != '') {
    $TENKOMASTERVEHICLE = $result_seTenkomaster['TENKOMASTERVEHICLE'];
} else {
    $TENKOMASTERVEHICLE = $result_seTenkobefor['TENKOMASTERVEHICLE'];
}
$var_ka1 = "";
$var_ka2 = "";
$var_kaday = "";
$var_kanight = "";
if ($result_seTenkomaster['TENKOMASTERKA'] != '') {
    $var_ka1 = "<u>เปลี่ยนกะ</u>";
    $var_ka2 = "ไม่เปลี่ยนกะ";

    if ($result_seTenkomaster['TENKOMASTERKA'] == 'เปลี่ยนกะกลางวัน') {
        $var_kaday = "<u>เปลี่ยนกะกลางวัน</u>";
        $var_kanight = "เปลี่ยนกะกลางคืน";
    } else {
        $var_kaday = "เปลี่ยนกะกลางคืน";
        $var_kanight = "<u>เปลี่ยนกะกลางคืน</u>";
    }
} else {
    $var_ka1 = "<u>ไม่เปลี่ยนกะ</u>";
    $var_ka2 = "เปลี่ยนกะ";
    $var_kaday = "เปลี่ยนกะกลางวัน";
    $var_kanight = "เปลี่ยนกะกลางคืน";
}



$employee = " AND a.PersonCode = '" . $_GET['employeecode'] . "'";
$sql_seEmp = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmp = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array($employee, SQLSRV_PARAM_IN)
);
$query_seEmp = sqlsrv_query($conn, $sql_seEmp, $params_seEmp);
$result_seEmp = sqlsrv_fetch_array($query_seEmp, SQLSRV_FETCH_ASSOC);

$employee1 = " AND a.PersonCode = '" . $_GET['employeecode'] . "'";
$sql_seLicenDate = "{call megEmployeeEHR_v2(?,?)}";
$params_seLicenDate = array(
    array('select_LicenceDate', SQLSRV_PARAM_IN),
    array($employee1, SQLSRV_PARAM_IN)
);
$query_seLicenDate = sqlsrv_query($conn, $sql_seLicenDate, $params_seLicenDate);
$result_seLicenDate = sqlsrv_fetch_array($query_seLicenDate, SQLSRV_FETCH_ASSOC);


$sql_seDep = "SELECT DISTINCT b.DEPARTMENTNAME,b.DEPARTMENTCODE,a.SECTIONCODE
FROM [dbo].[ORGANIZATION] a
INNER JOIN [dbo].[DEPARTMENT_NEW] b ON a.DEPARTMENTCODE = b.DEPARTMENTCODE AND a.COMPANYCODE = b.COMPANYCODE
WHERE a.EMPLOYEECODE = '".$_GET['employeecode']."' ";
$query_seDep = sqlsrv_query($conn, $sql_seDep, $params_seDep);
$result_seDep = sqlsrv_fetch_array($query_seDep, SQLSRV_FETCH_ASSOC);

$sql_seSecID = "SELECT SECTIONID FROM [dbo].[SECTION_NEW]
WHERE  DEPARTMENTCODE = '".$result_seDep['DEPARTMENTCODE']."'
AND SECTIONCODE ='".$result_seDep['SECTIONCODE']."'";
$query_seSecID = sqlsrv_query($conn, $sql_seSecID, $params_seSecID);
$result_seSecID = sqlsrv_fetch_array($query_seSecID, SQLSRV_FETCH_ASSOC);


$sql_seSec = "SELECT b.SECTIONNAME FROM [dbo].[ORGANIZATION] a
INNER JOIN [dbo].SECTION_NEW b ON a.SECTIONCODE = b.SECTIONCODE
WHERE a.EMPLOYEECODE = '".$_GET['employeecode']."'
AND a.DEPARTMENTCODE = '".$result_seDep['DEPARTMENTCODE']."'
AND b.SECTIONCODE ='".$result_seDep['SECTIONCODE']."'
AND b.SECTIONID ='".$result_seSecID['SECTIONID']."'";
$query_seSec = sqlsrv_query($conn, $sql_seSec, $params_seSec);
$result_seSec = sqlsrv_fetch_array($query_seSec, SQLSRV_FETCH_ASSOC);

//HEARTRATE
if ($result_seTenkobefor['TENKOPRESSUREDATA_60110'] >= '60' && $result_seTenkobefor['TENKOPRESSUREDATA_60110'] <= '100') {
    $HEARTRATE = $result_seTenkobefor['TENKOPRESSUREDATA_60110'];
}else if ($result_seTenkobefor['TENKOPRESSUREDATA_60110_2'] >= '60' && $result_seTenkobefor['TENKOPRESSUREDATA_60110_2'] <= '100') {
    $HEARTRATE = $result_seTenkobefor['TENKOPRESSUREDATA_60110_2'];
}else if ($result_seTenkobefor['TENKOPRESSUREDATA_60110_3'] >= '60' && $result_seTenkobefor['TENKOPRESSUREDATA_60110_3'] <= '100'){
    $HEARTRATE = $result_seTenkobefor['TENKOPRESSUREDATA_60110_3'];
}else {
    $HEARTRATE = '';
}
//ความดันค่าบน
if ($result_seTenkobefor['TENKOPRESSUREDATA_90160'] >= '90' && $result_seTenkobefor['TENKOPRESSUREDATA_90160'] <=    '140') {
    $SYS = $result_seTenkobefor['TENKOPRESSUREDATA_90160'];
}else if ($result_seTenkobefor['TENKOPRESSUREDATA_90160_2'] >= '90' && $result_seTenkobefor['TENKOPRESSUREDATA_90160_2'] <= '140') {
    $SYS = $result_seTenkobefor['TENKOPRESSUREDATA_90160_2'];
}else if ($result_seTenkobefor['TENKOPRESSUREDATA_90160_3'] >= '90' && $result_seTenkobefor['TENKOPRESSUREDATA_90160_3'] <= '140'){
    $SYS = $result_seTenkobefor['TENKOPRESSUREDATA_90160_3'];
}else {
    $SYS = '';
}
//ความดันค่าล่าง
if ($result_seTenkobefor['TENKOPRESSUREDATA_60100'] >= '60' && $result_seTenkobefor['TENKOPRESSUREDATA_60100'] <= '90') {
    $DIA = $result_seTenkobefor['TENKOPRESSUREDATA_60100'];
}else if ($result_seTenkobefor['TENKOPRESSUREDATA_60100_2'] >= '60' && $result_seTenkobefor['TENKOPRESSUREDATA_60100_2'] <= '90') {
    $DIA = $result_seTenkobefor['TENKOPRESSUREDATA_60100_2'];
}else if ($result_seTenkobefor['TENKOPRESSUREDATA_60100_3'] >= '60' && $result_seTenkobefor['TENKOPRESSUREDATA_60100_3'] <= '90'){
    $DIA = $result_seTenkobefor['TENKOPRESSUREDATA_60100_3'];
}else {
    $DIA = '';
}

// 22222
///ข้อมูลจากการ Self Check
$sql_seSelfCheck = "SELECT TOP 1 SELFCHECKID,EMPLOYEECODE,EMPLOYEENAME,DATEJOBSTART,
SLEEPRESTSTART,SLEEPRESTEND,TIMESLEEPREST,
SLEEPNORMALSTART,SLEEPNORMALEND,TIMESLEEPNORMAL,
SLEEPEXTRASTART,SLEEPEXTRAEND,TIMESLEEPEXTRA
FROM DRIVERSELFCHECK WHERE SELFCHECKID ='".$_GET['selfcheckid']."' ";
$params_seSelfCheck = array();
$query_seSelfCheck = sqlsrv_query($conn, $sql_seSelfCheck, $params_seSelfCheck);
$result_seSelfCheck = sqlsrv_fetch_array($query_seSelfCheck, SQLSRV_FETCH_ASSOC);

$DATERESTSTART1 = str_replace("T"," ",$result_seSelfCheck['SLEEPRESTSTART']);
$DATERESTSTART = str_replace("-","/",$DATERESTSTART1);



$tablehistory = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>
<tr style=" padding:4px;">
     <th colspan="6" style=" padding:4px;text-align:center;"><b>' . $result_seEmp['Company_NameT'] . '</b></th>
    </tr>
    <tr style=" padding:4px;">
     <th colspan="6" style=" padding:4px;text-align:center;"><b>รายงานข้อมูลพนักงาน</b></th>
    </tr>
    <tr style=" padding:4px;">
     <th colspan="2" style=" padding:4px;text-align:left;"><b>ฝ่าย : </b> '.$result_seDep['DEPARTMENTNAME'].' </th>
     <th colspan="2" style=" padding:4px;text-align:left;"><b>แผนก : </b> '.$result_seSec['SECTIONNAME'].' </th>
     <th colspan="2" style=" padding:4px;text-align:left;"><b>ระดับพนักงาน : </b> '.$result_seEmp['PositionNameT'].' </th>
    </tr>
    </thead>';
    $tablehistory .= '<tbody>

    <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;" colspan="6"><hr /></td>
    </tr>
    <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;width: 15%">รหัสพนักงาน</td>
        <td style=" padding:4px;text-align:left;width: 20%">'.$result_seEmp['PersonCode'].'</td>
        <td style=" padding:4px;text-align:left;width: 15%">รหัสบัตรรูด</td>
        <td style=" padding:4px;text-align:left;width: 20%">'.$result_seEmp['PersonCode'].'</td>
        <td colspan="2" rowspan="7" style=" padding:4px;text-align:center;width: 15%"><img width="20%" src="../images/employee/'.$result_seEmp['PersonCode'].'.JPG"></td>
      </tr>
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;">ชื่อ-สกุล(ไทย)</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['nameT'].'</td>
        <td style=" padding:4px;text-align:left;">เพศ</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['SexT'].'</td>
      </tr>
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;">ชื่อ-สกุล(อังกฤษ)</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['nameE'].'</td>
        <td style=" padding:4px;text-align:left;">สถานภาพ</td>
        <td style=" padding:4px;text-align:left;">-</td>
      </tr>
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;">ฝ่าย</td>
        <td style=" padding:4px;text-align:left;">'.$result_seDep['DEPARTMENTNAME'].' </td>
        <td style=" padding:4px;text-align:left;">วันเกิด</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['BirthDate103'].'</td>
      </tr>



      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;">แผนก</td>
        <td style=" padding:4px;text-align:left;">'.$result_seSec['SECTIONNAME'].'</td>
        <td style=" padding:4px;text-align:left;">อายุ(ปี/เดือน/วัน)</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['yearb'].' ปี / '.$result_seEmp['monthb'].' เดือน / '.$result_seEmp['dayb'].' วัน</td>
      </tr>
       <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;">ระดับพนักงาน</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['PositionNameT'].' </td>
        <td style=" padding:4px;text-align:left;">วันที่เริ่มงาน</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['StartDate'].'</td>
      </tr>
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;">สถานที่ทำงาน</td>
        <td style=" padding:4px;text-align:left;">-</td>
        <td style=" padding:4px;text-align:left;">วันที่บรรจุ</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['PassDate'].'</td>
      </tr>
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;">ขอบเขตการทำงาน</td>
        <td style=" padding:4px;text-align:left;">-</td>
        <td style=" padding:4px;text-align:left;">จำนวนวันทดลองงาน</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['numProof'].'</td>
        <td style=" padding:4px;text-align:left;width: 15%">ประเภทพนักงาน</td>
        <td style=" padding:4px;text-align:left;">-</td>
      </tr>

      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;">กลุ่มอนุมัติ Web</td>
        <td style=" padding:4px;text-align:left;">-</td>
        <td style=" padding:4px;text-align:left;">อายุงาน(ปี/เดือน/วัน)</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['yearw'].' ปี / '.$result_seEmp['monthw'].' เดือน / '.$result_seEmp['dayw'].' วัน</td>
        <td style=" padding:4px;text-align:left;">วันที่สิ้นสุดสัญญา</td>
        <td style=" padding:4px;text-align:left;">-</td>
      </tr>
       <tr style="#000;padding:4px;">
        <td style=" padding:4px;text-align:left;">ตำแหน่ง</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['PositionNameOther'].'</td>
        <td style=" padding:4px;text-align:left;">วันที่ลาออก</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['EndDate'].'</td>
        <td style=" padding:4px;text-align:left;">ระดับพนักงาน</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['PositionNameT'].'</td>
      </tr>
       <tr style="#000;padding:4px;">
        <td style=" padding:4px;text-align:left;">ประเภทสัญญาจ้าง</td>
        <td style=" padding:4px;text-align:left;">-</td>
        <td style=" padding:4px;text-align:left;">วันที่เริ่มสัญญา</td>
        <td style=" padding:4px;text-align:left;">-</td>
        <td style=" padding:4px;text-align:left;">เลขที่บัตรผู้เสียภาษี</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['TaxID'].'</td>
      </tr>
       <tr style="#000;padding:4px;">
        <td style=" padding:4px;text-align:left;">เลขที่สัญญาจ้าง</td>
        <td style=" padding:4px;text-align:left;">-</td>
        <td style=" padding:4px;text-align:left;">ระดับ</td>
        <td style=" padding:4px;text-align:left;">-</td>
        <td style=" padding:4px;text-align:left;">เลขที่กองทุน</td>
        <td style=" padding:4px;text-align:left;">-</td>
      </tr>
       <tr style="#000;padding:4px;">
        <td style=" padding:4px;text-align:left;">เลขที่บัตรประชาชน</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['TaxID'].'</td>
        <td style=" padding:4px;text-align:left;">หมดอายุ</td>
        <td style=" padding:4px;text-align:left;">-</td>
        <td style=" padding:4px;text-align:left;">เงินเดือน</td>
        <td style=" padding:4px;text-align:left;">-</td>
      </tr>
       <tr style="padding:4px;">
        <td style=" padding:4px;text-align:left;">เลขที่ประกันสังคม</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['TaxID'].'</td>
        <td style=" padding:4px;text-align:left;">รพ.ประกันสังคม</td>
        <td style=" padding:4px;text-align:left;">-</td>
        <td style=" padding:4px;text-align:left;"></td>
        <td style=" padding:4px;text-align:left;"></td>
      </tr>
      <tr style="padding:4px;">
        <td style=" padding:4px;text-align:left;">เลขที่บัญชี</td>
        <td style=" padding:4px;text-align:left;">-</td>
        <td style=" padding:4px;text-align:left;">ชื่อธนาคาร</td>
        <td style=" padding:4px;text-align:left;">-</td>
        <td style=" padding:4px;text-align:left;"></td>
        <td style=" padding:4px;text-align:left;"></td>
      </tr>
      <tr style="padding:4px;">
        <td style=" padding:4px;text-align:left;">เลขที่ใบขับขี่</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['CarLicenceID'].'</td>
      </tr>
      <tr style="padding:4px;">
        <td style=" padding:4px;text-align:left;">วันอนุญาต</td>
        <td style=" padding:4px;text-align:left;">'.$result_seLicenDate['StartDate'].'</td>
      </tr>
      <tr style="padding:4px;">
        <td style=" padding:4px;text-align:left;">วันสิ้นอายุ</td>
        <td style=" padding:4px;text-align:left;">'.$result_seLicenDate['EndDate'].'</td>
      </tr>
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;" colspan="6"><hr /></td>
    </tr>
     <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;" colspan="6"></td>
    </tr>
</tbody></table>';

    
$table_headerDAY1 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>
    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkobefor['TENKOBEFOREDATE'] . '</th>
        <th colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">เอกสารเท็งโกะ</th>
        <th colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">
        '.$comp.'</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th width="10%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $var_ka1 . '</th>
        <th width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $var_kaday . '</th>
        <th width="10%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $var_ka2 . '</th>
        <th width="5%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">บริษัท</th>
        <th width="15%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkobefor['Company_NameT'] . '</th>
        <th width="5%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ชื่อพขร.</th>
        <th width="15%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seDir['nameT'] . '</th>
        <th width="10%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">หมายเลขรถ</th>
        <th width="20%" colspan="3" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOMASTERVEHICLE . '</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $var_kanight . '</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="5" style="border-right:1px solid #000;padding:4px;text-align:left;">รายละเอียดงาน (เท็งโกะก่อนเริ่มงาน ข้อ 12.)</th>
        <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:left;">เป้าหมายการวิ่งงานวันนี้ (เท็งโกะก่อนเริ่มงาน ข้อ 16.)</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="5" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_sePlain['JOBSTART'] . '->' . $result_sePlain['JOBEND'] . '</th>
        <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:left;"> </th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="5" height="100" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkomaster['TENKOMASTERREMARKBEFORE'] . '</th>
        <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $TENKOTARGET1 . '<br>' . $TENKOTARGET2 . '<br>' . $TENKOTARGET3 . '<br>' . $TENKOTARGET4 . '<br>' . $TENKOTARGET5 . '<br>' . $TENKOTARGET6 . '<br>' . $TENKOTARGET7 . '</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>';

$table_1DAY1 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>
    <tr style="border:1px solid #000;padding:4px;">
     <th style="border-right:1px solid #000;padding:4px;text-align:center;">เวลา<br />ทำเท็งโกะ</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['CREATEDATE'] . '</th>
      <th colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">เท็งโกะก่อนเริ่มงาน</th>
        <th width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">ลายเซ็น<br />เจ้าหน้าที่<br />เท็งโกะ</th>
        <th width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREBY1 . '</th>
        <th  width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">ลายเซ็น พขร.</th>
        <th  width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seDir['nameT'] . '</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th width="5%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ข้อ</th>
        <th width="25%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">หัวข้อ</th>
        <th width="10%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ช่องตรวจสอบ</th>
        <th width="20%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</th>
        <th width="20%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">เกณฑ์การตัดสิน</th>
        <th colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th  colspan="2" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">รายละเอียดและการแนะนำ</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ปกติ</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผิดปกติ</th>
    </tr>
    </thead>
    <tbody>
    <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">1</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">การทักทายก่อนเริ่มเท็งโกะ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREGREETCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ทักทายอย่างมีชีวิตชีวา</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREGREETRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREGREETRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;"> ' . $result_seTenkobefor['TENKOBEFOREGREETREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">2</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจเช็คยูนิฟอร์ม</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOUNIFORMCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">สวมชุดที่สอาด ไม่ใส่เครื่องประดับที่อาจทำให้เกิดรอย</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOUNIFORMRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOUNIFORMRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOUNIFORMREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">3</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบสภาพร่างกาย</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">สภาพร่างกายแข็งแรงดี</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOBODYREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">4</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบระยะการพักผ่อน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKORESTCHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตั้งแต่ 8 ชั่วโมง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $RS_TENKORESTDATA . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKORESTRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKORESTRESULT0 . '</td>
        // 11111
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKORESTREMARK'] . '</td> //เวลานอน8ชั่วโมง
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">5</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบชั่วโมงการนอนหลับ</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPTIMECHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;"><strong>การนอนปกติ</strong><br>
        ตั้งแต่ 6 ชั่วโมงขั้นไป</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOSLEEPTIMEDATA_AFTER6H'] . '</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPTIMERESULT1 . '</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPTIMERESULT0 . '</td>
        <td colspan="2" rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOSLEEPTIMEREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;"><strong>การนอนเพิ่ม</strong> (กะกลางคืน)<br>
        ตั้งแต่ 4.5 ชั่วโมงขึ้นไป</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">(___' . $result_seTenkobefor['TENKOSLEEPTIMEDATA_ADD45H'] . '___ชม.)</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">6</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจเช็คอุณหภูมิ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTEMPERATURECHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ต่ำกว่า 37.5 องศา</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOTEMPERATUREDATA'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTEMPERATURERESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTEMPERATURERESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOTEMPERATUREREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">7</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:left;">วัดความดัน</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOPRESSURECHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">บน : 90-150</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $SYS . '</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOPRESSURERESULT1 . '</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOPRESSURERESULT0 . '</td>
        <td colspan="2" rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOPRESSUREREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ล่าง : 60-95</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $DIA . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">อัตราการเต้นหัวใจ : 60-100 ครั้ง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $HEARTRATE . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">8</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ครวจเช็คแอลกอฮอล์</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOALCOHOLCHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">[0]</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOALCOHOLDATA'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOALCOHOLRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOALCOHOLRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOALCOHOLREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">9</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สอบถามเรื่องกังวลใจ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOWORRYCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ไม่มีเรื่องกังวลใจ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOWORRYRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOWORRYRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOWORRYREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">10</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ใบตรวจเทรลเลอร์ประจำวัน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKODAILYTRAILERCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ไม่มีหัวข้อผิดปกติ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKODAILYTRAILERRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKODAILYTRAILERRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKODAILYTRAILERREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">11</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบของที่พกพา</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARRYCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ใบอนุญาติขับขี่,ใบอนุญาติ (ผู้รับเหมา),ใบอนุญาติ (โฟล์คลิฟท์),ใบอนุญาติ (TLEP),ใบอนุญาติ (Trailer),โทรศัพท์,สายสมอลทอร์ค</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARRYRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARRYRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOCARRYREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">12</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบรายละเอียดการทำงาน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOJOBDETAILCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">เข้าใจเส้นทาง,จุดพักรถ,รูปแบบการขับขี่,ความสำคัญในการส่งรถ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOJOBDETAILRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOJOBDETAILRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOJOBDETAILREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">13</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">แจ้งสภาพถนน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADINFORMCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">เข้าใจเนื้อหาที่แจ้ง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADINFORMRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADINFORMRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOLOADINFORMREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">14</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">แจ้งสภาพอากาศ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRINFORMCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">เข้าใจเนื้อหาที่แจ้ง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRINFORMRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRINFORMRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOAIRINFORMREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">15</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">แจ้งเรื่องโยโกะเต็น</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOYOKOTENCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">เข้าใจเนื้อหาที่แจ้ง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOYOKOTENRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOYOKOTENRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOYOKOTENREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">16</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบเป้าหมายการขับขี่จากเครื่องมูเลเตอร์</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCHIMOLATORCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบกันทั้งสองฝ่าย</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCHIMOLATORRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCHIMOLATORRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOCHIMOLATORREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">17</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สามารถวิ่งงานได้ปกติหรือไม่</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRANSPORTCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ไม่มีข้อบกพร่องต่อการวิ่งงาน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRANSPORTRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRANSPORTRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOTRANSPORTREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">18</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">การทักทายหลังทำเท็งโกะเสร็จ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAFTERGREETCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ทักทายอย่างมีชีวิตชีวา</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAFTERGREETRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAFTERGREETRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOAFTERGREETREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">***</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจเช็คออกซิเจนเลือด</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOOXYGENCHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOOXYGENDATA'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOOXYGENRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOOXYGENRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOOXYGENREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td colspan="9" style="border-right:1px solid #000;padding:4px;text-align:center;">ตรวจเช็คปัญหาสุขภาพสายตา5</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">1</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สายตาสั้น</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORESHORTSIGHTCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">พนักงานพกแว่นสายตามาปฏิบัติงาน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORESHORTSIGHTRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORESHORTSIGHTRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOSHORTSIGHTREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">2</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สายตายาว</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORELONGSIGHTCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">พนักงานพกแว่นสายตามาปฏิบัติงาน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORELONGSIGHTRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORELONGSIGHTRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOLONGSIGHTREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">3</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สายตาเอียง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREOBLIQUESIGHTCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">พนักงานพกแว่นสายตามาปฏิบัติงาน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREOBLIQUESIGHTRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREOBLIQUESIGHTRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOOBLIQUESIGHTREMARK'] . '</td>
      </tr>
    </tbody></table>
';

$condTenkotransportDAY11 = " AND TENKOMASTERID = '" . $_GET['tenkomasterid'] . "' AND TENKOMASTERDIRVERCODE = '" . $_GET['employeecode'] . "'";
$condTenkotransportDAY12 = " AND CONVERT(DATE,TENKOTRANSPORTDATE) = CONVERT(DATE,'" . $result_seTenkomaster['DATEINPUT_F1'] . "',103)";
$sql_seTenkotransportDAY1 = "{call megEdittenkotransport_v2(?,?,?,?,?)}";
$params_seTenkotransportDAY1 = array(
    array('select_tenkotransport', SQLSRV_PARAM_IN),
    array($condTenkotransportDAY11, SQLSRV_PARAM_IN),
    array($condTenkotransportDAY12, SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seTenkotransportDAY1 = sqlsrv_query($conn, $sql_seTenkotransportDAY1, $params_seTenkotransportDAY1);
$result_seTenkotransportDAY1 = sqlsrv_fetch_array($query_seTenkotransportDAY1, SQLSRV_FETCH_ASSOC);

$conditionEHR1 = " AND a.PersonCode ='" . $result_seTenkotransportDAY1['MODIFIEDBY'] . "'";
$sql_seEHR1 = "{call megEmployeeEHR_v2(?,?)}";
$params_seEHR1 = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array($conditionEHR1, SQLSRV_PARAM_IN)
);
$query_seEHR1 = sqlsrv_query($conn, $sql_seEHR1, $params_seEHR1);
$result_seEHR1 = sqlsrv_fetch_array($query_seEHR1, SQLSRV_FETCH_ASSOC);


$TENKOLOADRESTCHECKDAY1 = ($result_seTenkotransportDAY1['TENKOLOADRESTCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOBODYSLEEPYCHECKDAY1 = ($result_seTenkotransportDAY1['TENKOBODYSLEEPYCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOCARNEWCHECKDAY1 = ($result_seTenkotransportDAY1['TENKOCARNEWCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOTRAILERCHECKDAY1 = ($result_seTenkotransportDAY1['TENKOTRAILERCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOROADCHECKDAY1 = ($result_seTenkotransportDAY1['TENKOROADCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOAIRCHECKDAY1 = ($result_seTenkotransportDAY1['TENKOAIRCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOSLEEPYCHECKDAY1 = ($result_seTenkotransportDAY1['TENKOSLEEPYCHECK'] == "1" || $result_seTenkotransportDAY1['TENKOSLEEPYCHECK'] == "0x") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";


if ($result_seTenkotransportDAY1['TENKOLOADRESTRESULT0'] == "1") {
    $TENKOLOADRESTRESULTDAY10 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOLOADRESTRESULT0'] == "0") {
    $TENKOLOADRESTRESULTDAY10 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOLOADRESTRESULT0'] == "x") {
    $TENKOLOADRESTRESULTDAY10 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOLOADRESTRESULT0'] == "-") {
    $TENKOLOADRESTRESULTDAY10 = "<img src='../images/circle_3.png' width='2%'>";
}



if ($result_seTenkotransportDAY1['TENKOLOADRESTRESULT1'] == "1") {
    $TENKOLOADRESTRESULTDAY11 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOLOADRESTRESULT1'] == "0") {
    $TENKOLOADRESTRESULTDAY11 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOLOADRESTRESULT1'] == "x") {
    $TENKOLOADRESTRESULTDAY11 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOLOADRESTRESULT1'] == "-") {
    $TENKOLOADRESTRESULTDAY11 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOLOADRESTRESULT2'] == "1") {
    $TENKOLOADRESTRESULTDAY12 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOLOADRESTRESULT2'] == "0") {
    $TENKOLOADRESTRESULTDAY12 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOLOADRESTRESULT2'] == "x") {
    $TENKOLOADRESTRESULTDAY12 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOLOADRESTRESULT2'] == "-") {
    $TENKOLOADRESTRESULTDAY12 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOLOADRESTRESULT3'] == "1") {
    $TENKOLOADRESTRESULTDAY13 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOLOADRESTRESULT3'] == "0") {
    $TENKOLOADRESTRESULTDAY13 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOLOADRESTRESULT3'] == "x") {
    $TENKOLOADRESTRESULTDAY13 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOLOADRESTRESULT3'] == "-") {
    $TENKOLOADRESTRESULTDAY13 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOLOADRESTRESULT4'] == "1") {
    $TENKOLOADRESTRESULTDAY14 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOLOADRESTRESULT4'] == "0") {
    $TENKOLOADRESTRESULTDAY14 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOLOADRESTRESULT4'] == "x") {
    $TENKOLOADRESTRESULTDAY14 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOLOADRESTRESULT4'] == "-") {
    $TENKOLOADRESTRESULTDAY14 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOLOADRESTRESULT5'] == "1") {
    $TENKOLOADRESTRESULTDAY15 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOLOADRESTRESULT5'] == "0") {
    $TENKOLOADRESTRESULTDAY15 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOLOADRESTRESULT5'] == "x") {
    $TENKOLOADRESTRESULTDAY15 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOLOADRESTRESULT5'] == "-") {
    $TENKOLOADRESTRESULTDAY15 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOLOADRESTRESULT6'] == "1") {
    $TENKOLOADRESTRESULTDAY16 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOLOADRESTRESULT6'] == "0") {
    $TENKOLOADRESTRESULTDAY16 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOLOADRESTRESULT6'] == "x") {
    $TENKOLOADRESTRESULTDAY16 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOLOADRESTRESULT6'] == "-") {
    $TENKOLOADRESTRESULTDAY16 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOBODYSLEEPYRESULT0'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY10 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOBODYSLEEPYRESULT0'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY10 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOBODYSLEEPYRESULT0'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY10 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOBODYSLEEPYRESULT0'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY10 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOBODYSLEEPYRESULT1'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY11 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOBODYSLEEPYRESULT1'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY11 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOBODYSLEEPYRESULT1'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY11 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOBODYSLEEPYRESULT1'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY11 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOBODYSLEEPYRESULT2'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY12 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOBODYSLEEPYRESULT2'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY12 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOBODYSLEEPYRESULT2'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY12 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOBODYSLEEPYRESULT2'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY12 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOBODYSLEEPYRESULT3'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY13 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOBODYSLEEPYRESULT3'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY13 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOBODYSLEEPYRESULT3'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY13 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOBODYSLEEPYRESULT3'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY13 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOBODYSLEEPYRESULT4'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY14 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOBODYSLEEPYRESULT4'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY14 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOBODYSLEEPYRESULT4'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY14 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOBODYSLEEPYRESULT4'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY14 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOBODYSLEEPYRESULT5'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY15 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOBODYSLEEPYRESULT5'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY15 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOBODYSLEEPYRESULT5'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY15 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOBODYSLEEPYRESULT5'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY15 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOBODYSLEEPYRESULT6'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY16 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOBODYSLEEPYRESULT6'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY16 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOBODYSLEEPYRESULT6'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY16 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOBODYSLEEPYRESULT6'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY16 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOCARNEWRESULT0'] == "1") {
    $TENKOCARNEWRESULTDAY10 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOCARNEWRESULT0'] == "0") {
    $TENKOCARNEWRESULTDAY10 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOCARNEWRESULT0'] == "x") {
    $TENKOCARNEWRESULTDAY10 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOCARNEWRESULT0'] == "-") {
    $TENKOCARNEWRESULTDAY10 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOCARNEWRESULT1'] == "1") {
    $TENKOCARNEWRESULTDAY11 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOCARNEWRESULT1'] == "0") {
    $TENKOCARNEWRESULTDAY11 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOCARNEWRESULT1'] == "x") {
    $TENKOCARNEWRESULTDAY11 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOCARNEWRESULT1'] == "-") {
    $TENKOCARNEWRESULTDAY11 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOCARNEWRESULT2'] == "1") {
    $TENKOCARNEWRESULTDAY12 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOCARNEWRESULT2'] == "0") {
    $TENKOCARNEWRESULTDAY12 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOCARNEWRESULT2'] == "x") {
    $TENKOCARNEWRESULTDAY12 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOCARNEWRESULT2'] == "-") {
    $TENKOCARNEWRESULTDAY12 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOCARNEWRESULT3'] == "1") {
    $TENKOCARNEWRESULTDAY13 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOCARNEWRESULT3'] == "0") {
    $TENKOCARNEWRESULTDAY13 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOCARNEWRESULT3'] == "x") {
    $TENKOCARNEWRESULTDAY13 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOCARNEWRESULT3'] == "-") {
    $TENKOCARNEWRESULTDAY13 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOCARNEWRESULT4'] == "1") {
    $TENKOCARNEWRESULTDAY14 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOCARNEWRESULT4'] == "0") {
    $TENKOCARNEWRESULTDAY14 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOCARNEWRESULT4'] == "x") {
    $TENKOCARNEWRESULTDAY14 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOCARNEWRESULT4'] == "-") {
    $TENKOCARNEWRESULTDAY14 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOCARNEWRESULT5'] == "1") {
    $TENKOCARNEWRESULTDAY15 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOCARNEWRESULT5'] == "0") {
    $TENKOCARNEWRESULTDAY15 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOCARNEWRESULT5'] == "x") {
    $TENKOCARNEWRESULTDAY15 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOCARNEWRESULT5'] == "-") {
    $TENKOCARNEWRESULTDAY15 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOCARNEWRESULT6'] == "1") {
    $TENKOCARNEWRESULTDAY16 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOCARNEWRESULT6'] == "0") {
    $TENKOCARNEWRESULTDAY16 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOCARNEWRESULT6'] == "x") {
    $TENKOCARNEWRESULTDAY16 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOCARNEWRESULT6'] == "-") {
    $TENKOCARNEWRESULTDAY16 = "<img src='../images/circle_3.png' width='2%'>";
}
if ($result_seTenkotransportDAY1['TENKOTRAILERRESULT0'] == "1") {
    $TENKOTRAILERRESULTDAY10 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOTRAILERRESULT0'] == "0") {
    $TENKOTRAILERRESULTDAY10 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOTRAILERRESULT0'] == "x") {
    $TENKOTRAILERRESULTDAY10 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOTRAILERRESULT0'] == "-") {
    $TENKOTRAILERRESULTDAY10 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOTRAILERRESULT1'] == "1") {
    $TENKOTRAILERRESULTDAY11 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOTRAILERRESULT1'] == "0") {
    $TENKOTRAILERRESULTDAY11 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOTRAILERRESULT1'] == "x") {
    $TENKOTRAILERRESULTDAY11 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOTRAILERRESULT1'] == "-") {
    $TENKOTRAILERRESULTDAY11 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOTRAILERRESULT2'] == "1") {
    $TENKOTRAILERRESULTDAY12 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOTRAILERRESULT2'] == "0") {
    $TENKOTRAILERRESULTDAY12 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOTRAILERRESULT2'] == "x") {
    $TENKOTRAILERRESULTDAY12 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOTRAILERRESULT2'] == "-") {
    $TENKOTRAILERRESULTDAY12 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOTRAILERRESULT3'] == "1") {
    $TENKOTRAILERRESULTDAY13 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOTRAILERRESULT3'] == "0") {
    $TENKOTRAILERRESULTDAY13 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOTRAILERRESULT3'] == "x") {
    $TENKOTRAILERRESULTDAY13 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOTRAILERRESULT3'] == "-") {
    $TENKOTRAILERRESULTDAY13 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOTRAILERRESULT4'] == "1") {
    $TENKOTRAILERRESULTDAY14 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOTRAILERRESULT4'] == "0") {
    $TENKOTRAILERRESULTDAY14 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOTRAILERRESULT4'] == "x") {
    $TENKOTRAILERRESULTDAY14 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOTRAILERRESULT4'] == "-") {
    $TENKOTRAILERRESULTDAY14 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOTRAILERRESULT5'] == "1") {
    $TENKOTRAILERRESULTDAY15 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOTRAILERRESULT5'] == "0") {
    $TENKOTRAILERRESULTDAY15 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOTRAILERRESULT5'] == "x") {
    $TENKOTRAILERRESULTDAY15 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOTRAILERRESULT5'] == "-") {
    $TENKOTRAILERRESULTDAY15 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOTRAILERRESULT6'] == "1") {
    $TENKOTRAILERRESULTDAY16 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOTRAILERRESULT6'] == "0") {
    $TENKOTRAILERRESULTDAY16 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOTRAILERRESULT6'] == "x") {
    $TENKOTRAILERRESULTDAY16 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOTRAILERRESULT6'] == "-") {
    $TENKOTRAILERRESULTDAY16 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOROADRESULT0'] == "1") {
    $TENKOROADRESULTDAY10 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOROADRESULT0'] == "0") {
    $TENKOROADRESULTDAY10 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOROADRESULT0'] == "x") {
    $TENKOROADRESULTDAY10 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOROADRESULT0'] == "-") {
    $TENKOROADRESULTDAY10 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOROADRESULT1'] == "1") {
    $TENKOROADRESULTDAY11 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOROADRESULT1'] == "0") {
    $TENKOROADRESULTDAY11 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOROADRESULT1'] == "x") {
    $TENKOROADRESULTDAY11 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOROADRESULT1'] == "-") {
    $TENKOROADRESULTDAY11 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOROADRESULT2'] == "1") {
    $TENKOROADRESULTDAY12 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOROADRESULT2'] == "0") {
    $TENKOROADRESULTDAY12 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOROADRESULT2'] == "x") {
    $TENKOROADRESULTDAY12 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOROADRESULT2'] == "-") {
    $TENKOROADRESULTDAY12 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOROADRESULT3'] == "1") {
    $TENKOROADRESULTDAY13 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOROADRESULT3'] == "0") {
    $TENKOROADRESULTDAY13 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOROADRESULT3'] == "x") {
    $TENKOROADRESULTDAY13 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOROADRESULT3'] == "-") {
    $TENKOROADRESULTDAY13 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOROADRESULT4'] == "1") {
    $TENKOROADRESULTDAY14 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOROADRESULT4'] == "0") {
    $TENKOROADRESULTDAY14 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOROADRESULT4'] == "x") {
    $TENKOROADRESULTDAY14 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOROADRESULT4'] == "-") {
    $TENKOROADRESULTDAY14 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOROADRESULT5'] == "1") {
    $TENKOROADRESULTDAY15 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOROADRESULT5'] == "0") {
    $TENKOROADRESULTDAY15 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOROADRESULT5'] == "x") {
    $TENKOROADRESULTDAY15 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOROADRESULT5'] == "-") {
    $TENKOROADRESULTDAY15 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOROADRESULT6'] == "1") {
    $TENKOROADRESULTDAY16 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOROADRESULT6'] == "0") {
    $TENKOROADRESULTDAY16 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOROADRESULT6'] == "x") {
    $TENKOROADRESULTDAY16 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOROADRESULT6'] == "-") {
    $TENKOROADRESULTDAY16 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOAIRRESULT0'] == "1") {
    $TENKOAIRRESULTDAY10 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOAIRRESULT0'] == "0") {
    $TENKOAIRRESULTDAY10 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOAIRRESULT0'] == "x") {
    $TENKOAIRRESULTDAY10 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOAIRRESULT0'] == "-") {
    $TENKOAIRRESULTDAY10 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOAIRRESULT1'] == "1") {
    $TENKOAIRRESULTDAY11 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOAIRRESULT1'] == "0") {
    $TENKOAIRRESULTDAY11 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOAIRRESULT1'] == "x") {
    $TENKOAIRRESULTDAY11 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOAIRRESULT1'] == "-") {
    $TENKOAIRRESULTDAY11 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOAIRRESULT2'] == "1") {
    $TENKOAIRRESULTDAY12 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOAIRRESULT2'] == "0") {
    $TENKOAIRRESULTDAY12 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOAIRRESULT2'] == "x") {
    $TENKOAIRRESULTDAY12 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOAIRRESULT2'] == "-") {
    $TENKOAIRRESULTDAY12 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOAIRRESULT3'] == "1") {
    $TENKOAIRRESULTDAY13 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOAIRRESULT3'] == "0") {
    $TENKOAIRRESULTDAY13 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOAIRRESULT3'] == "x") {
    $TENKOAIRRESULTDAY13 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOAIRRESULT3'] == "-") {
    $TENKOAIRRESULTDAY13 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOAIRRESULT4'] == "1") {
    $TENKOAIRRESULTDAY14 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOAIRRESULT4'] == "0") {
    $TENKOAIRRESULTDAY14 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOAIRRESULT4'] == "x") {
    $TENKOAIRRESULTDAY14 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOAIRRESULT4'] == "-") {
    $TENKOAIRRESULTDAY14 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOAIRRESULT5'] == "1") {
    $TENKOAIRRESULTDAY15 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOAIRRESULT5'] == "0") {
    $TENKOAIRRESULTDAY15 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOAIRRESULT5'] == "x") {
    $TENKOAIRRESULTDAY15 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOAIRRESULT5'] == "-") {
    $TENKOAIRRESULTDAY15 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOAIRRESULT6'] == "1") {
    $TENKOAIRRESULTDAY16 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOAIRRESULT6'] == "0") {
    $TENKOAIRRESULTDAY16 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOAIRRESULT6'] == "x") {
    $TENKOAIRRESULTDAY16 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOAIRRESULT6'] == "-") {
    $TENKOAIRRESULTDAY16 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOSLEEPYRESULT0'] == "1") {
    $TENKOSLEEPYRESULTDAY10 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOSLEEPYRESULT0'] == "0") {
    $TENKOSLEEPYRESULTDAY10 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOSLEEPYRESULT0'] == "x") {
    $TENKOSLEEPYRESULTDAY10 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOSLEEPYRESULT0'] == "-") {
    $TENKOSLEEPYRESULTDAY10 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOSLEEPYRESULT1'] == "1") {
    $TENKOSLEEPYRESULTDAY11 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOSLEEPYRESULT1'] == "0") {
    $TENKOSLEEPYRESULTDAY11 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOSLEEPYRESULT1'] == "x") {
    $TENKOSLEEPYRESULTDAY11 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOSLEEPYRESULT1'] == "-") {
    $TENKOSLEEPYRESULTDAY11 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOSLEEPYRESULT2'] == "1") {
    $TENKOSLEEPYRESULTDAY12 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOSLEEPYRESULT2'] == "0") {
    $TENKOSLEEPYRESULTDAY12 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOSLEEPYRESULT2'] == "x") {
    $TENKOSLEEPYRESULTDAY12 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOSLEEPYRESULT2'] == "-") {
    $TENKOSLEEPYRESULTDAY12 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOSLEEPYRESULT3'] == "1") {
    $TENKOSLEEPYRESULTDAY13 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOSLEEPYRESULT3'] == "0") {
    $TENKOSLEEPYRESULTDAY13 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOSLEEPYRESULT3'] == "x") {
    $TENKOSLEEPYRESULTDAY13 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOSLEEPYRESULT3'] == "-") {
    $TENKOSLEEPYRESULTDAY13 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOSLEEPYRESULT4'] == "1") {
    $TENKOSLEEPYRESULTDAY14 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOSLEEPYRESULT4'] == "0") {
    $TENKOSLEEPYRESULTDAY14 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOSLEEPYRESULT4'] == "x") {
    $TENKOSLEEPYRESULTDAY14 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOSLEEPYRESULT4'] == "-") {
    $TENKOSLEEPYRESULTDAY14 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOSLEEPYRESULT5'] == "1") {
    $TENKOSLEEPYRESULTDAY15 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOSLEEPYRESULT5'] == "0") {
    $TENKOSLEEPYRESULTDAY15 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOSLEEPYRESULT5'] == "x") {
    $TENKOSLEEPYRESULTDAY15 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOSLEEPYRESULT5'] == "-") {
    $TENKOSLEEPYRESULTDAY15 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY1['TENKOSLEEPYRESULT6'] == "1") {
    $TENKOSLEEPYRESULTDAY16 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOSLEEPYRESULT6'] == "0") {
    $TENKOSLEEPYRESULTDAY16 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOSLEEPYRESULT6'] == "x") {
    $TENKOSLEEPYRESULTDAY16 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY1['TENKOSLEEPYRESULT6'] == "-") {
    $TENKOSLEEPYRESULTDAY16 = "<img src='../images/circle_3.png' width='2%'>";
}
$VAR_MODIFIEDBY1 = ($result_seTenkotransportDAY1["MODIFIEDBY"] == "") ? $result_seTenkotransportDAY1["CREATEBY"] : $result_seTenkotransportDAY1["MODIFIEDBY"];
$table_2DAY1 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>
    <tr style="border:1px solid #000;padding:4px;">
    <th colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"></th>
    <th colspan="1" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY1['TENKOTRANSPORTDATE'] . '</th>
      <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;">เท็งโกะระหว่างทาง</th>
        <th colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">ลายเซนเจ้าหน้าที่เท็งโกะ</th>
        <th colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $VAR_MODIFIEDBY1 . '</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="12" style="border-right:1px solid #000;padding:4px;text-align:left;">เจ้าหน้าที่โทรไปไม่พบสิ่งผิดปกติ : 0 | พนักงานขับรถโทรมาไม่พบสิ่งผิดปกติ : 1 | พบสิ่งผิดปกติ : x</li></th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th width="5%" rowspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">ข้อ</th>
        <th rowspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">หัวข้อ</th>
        <th rowspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">ช่องตรวจสอบ</th>
        <th rowspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">เกณฑ์การตัดสิน</th>
        <th rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">โทรช่วง 06:00 - 24:00</th>
        <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;">Night Call Check</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">รายละเอียดการแนะนำ</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 1</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 2</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 3</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 4</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 5</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 6</th>
        <th rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY1['TENKOTIME0'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY1['TENKOTIME1'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY1['TENKOTIME2'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY1['TENKOTIME3'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY1['TENKOTIME4'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY1['TENKOTIME5'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY1['TENKOTIME6'] . '</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
    </tr>
    </thead>
    <tbody>
    <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">1</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">เส้นทางที่กำหนด - จุดพัก</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTCHECKDAY1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">เส้นทาง จุดพักที่กำหนด</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY10 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY10 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY10 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY10 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY10 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY10 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY10 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY1['TENKOLOADRESTREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">2</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจร่างกาย - อาการง่วง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYCHECKDAY1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">วิธีการพูดคุยต้องร่าเริง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY11 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY11 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY11 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY11 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY11 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY11 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY11 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY1['TENKOBODYSLEEPYREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">3</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจรถใหม่ (เฉพาะหยุดจอด)</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWCHECKDAY1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">มีการรายงานเกี่ยวกับรถใหม่ว่ามีสิ่งผิดปกติหรือไม่</td>
      <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY12 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY12 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY12 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY12 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY12 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY12 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY12 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY1['TENKOCARNEWREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">4</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจเทรลเลอร์</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERCHECKDAY1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ระหว่างวิ่งงานไม่มีสิ่งผิดปกติ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY13 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY13 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY13 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY13 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY13 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY13 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY13 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY1['TENKOTRAILERREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">5</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสภาพถนน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADCHECKDAY1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">รายงานสภาพถนน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY14 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY14 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY14 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY14 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY14 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY14 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY14 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY1['TENKOROADREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">6</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบสภาพอากาศ (ใช้ที่ปัดน้ำฝนระดับ 3 ให้หยุดรถ)</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRCHECKDAY1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">รายงานสภาพอากาศ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY15 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY15 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY15 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY15 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY15 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY15 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY15 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY1['TENKOAIRREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">7</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบอาการง่วงและย้ำให้ระมัดระวัง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYCHECKDAY1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สภาพที่สามารถวิ่งงานต่อได้</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY16 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY16 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY16 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY16 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY16 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY16 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY16 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY1['TENKOSLEEPYREMARK'] . '</td>
      </tr>
    </tbody></table>

';
$table_headerDAY2 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>
    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkobefor['TENKOBEFOREDATE'] . '</th>
        <th colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">เอกสารเท็งโกะ</th>
        <th colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">Issue date 23 Jan 2017<br>          Toyota Transport (Thailand) Co.,LTD.</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th width="10%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">เปลี่ยนกะ</th>
        <th width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">กลางวัน</th>
        <th width="10%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ไม่เปลี่ยนกะ</th>
        <th width="5%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">บริษัท</th>
        <th width="15%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkobefor['Company_NameT'] . '</th>
        <th width="5%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ชื่อพขร.</th>
        <th width="15%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seDir['nameT'] . '</th>
        <th width="10%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">หมายเลขรถ</th>
        <th width="20%" colspan="3" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkobefor['TENKOMASTERVEHICLE'] . '</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">กลางคืน</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="5" style="border-right:1px solid #000;padding:4px;text-align:left;">รายละเอียดงาน (เท็งโกะก่อนเริ่มงาน ข้อ 12.)</th>
        <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:left;">เป้าหมายการวิ่งงานวันนี้ (เท็งโกะก่อนเริ่มงาน ข้อ 16.)</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="5" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_sePlain['JOBSTART'] . '->' . $result_sePlain['JOBEND'] . '</th>
        <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:left;"> </th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="5" height="100" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkomaster['TENKOMASTERREMARKBEFORE'] . '</th>
        <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $TENKOTARGET1 . '<br>' . $TENKOTARGET2 . '<br>' . $TENKOTARGET3 . '<br>' . $TENKOTARGET4 . '<br>' . $TENKOTARGET5 . '<br>' . $TENKOTARGET6 . '<br>' . $TENKOTARGET7 . '</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>';

$table_1DAY2 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>
    <tr style="border:1px solid #000;padding:4px;">
     <th style="border-right:1px solid #000;padding:4px;text-align:center;">เวลา<br />ทำเท็งโกะ</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['CREATEDATE'] . '</th>
      <th colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">เท็งโกะก่อนเริ่มงาน</th>
        <th width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">ลายเซ็น<br />เจ้าหน้าที่<br />เท็งโกะ</th>
        <th width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREBY1 . '</th>
        <th  width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">ลายเซ็น พขร.</th>
        <th  width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seDir['nameT'] . '</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th width="5%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ข้อ</th>
        <th width="25%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">หัวข้อ</th>
        <th width="10%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ช่องตรวจสอบ</th>
        <th width="20%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</th>
        <th width="20%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">เกณฑ์การตัดสิน</th>
        <th colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th  colspan="2" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">รายละเอียดและการแนะนำ</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ปกติ</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผิดปกติ</th>
    </tr>
    </thead>
    <tbody>
    <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">1</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">การทักทายก่อนเริ่มเท็งโกะ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREGREETCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ทักทายอย่างมีชีวิตชีวา</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREGREETRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREGREETRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOBEFOREGREETREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">2</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจเช็คยูนิฟอร์ม</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOUNIFORMCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">สวมชุดที่สอาด ไม่ใส่เครื่องประดับที่อาจทำให้เกิดรอย</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOUNIFORMRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOUNIFORMRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOUNIFORMREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">3</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบสภาพร่างกาย</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">สภาพร่างกายแข็งแรงดี</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOBODYREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">4</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบระยะการพักผ่อน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKORESTCHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตั้งแต่ 8 ชั่วโมง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKORESTDATA'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKORESTRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKORESTRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKORESTREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">5</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบชั่วโมงการนอนหลับ</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPTIMECHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;"><strong>การนอนปกติ</strong><br>
        ตั้งแต่ 6 ชั่วโมงขั้นไป</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOSLEEPTIMEDATA_AFTER6H'] . '</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPTIMERESULT1 . '</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPTIMERESULT0 . '</td>
        <td colspan="2" rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOSLEEPTIMEREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;"><strong>การนอนเพิ่ม</strong> (กะกลางคืน)<br>
        ตั้งแต่ 4.5 ชั่วโมงขึ้นไป</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">(___' . $result_seTenkobefor['TENKOSLEEPTIMEDATA_ADD45H'] . '___ชม.)</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">6</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจเช็คอุณหภูมิ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTEMPERATURECHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ต่ำกว่า 37 องศา</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOTEMPERATUREDATA'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTEMPERATURERESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTEMPERATURERESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOTEMPERATUREREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">7</td>
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">วัดความดัน</td>
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOPRESSURECHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">บน : 90-160</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $SYS . '</td>
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOPRESSURERESULT1 . '</td>
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOPRESSURERESULT0 . '</td>
        <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOPRESSUREREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ล่าง : 60-100</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $DIA . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">อัตราการเต้นหัวใจ : 60-100 ครั้ง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $HEARTRATE . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">8</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ครวจเช็คแอลกอฮอล์</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOALCOHOLCHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">[0]</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOALCOHOLDATA'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOALCOHOLRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOALCOHOLRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOALCOHOLREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">9</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สอบถามเรื่องกังวลใจ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOWORRYCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ไม่มีเรื่องกังวลใจ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOWORRYRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOWORRYRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOWORRYREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">10</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ใบตรวจเทรลเลอร์ประจำวัน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKODAILYTRAILERCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ไม่มีหัวข้อผิดปกติ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKODAILYTRAILERRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKODAILYTRAILERRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKODAILYTRAILERREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">11</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบของที่พกพา</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARRYCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ใบอนุญาติขับขี่,ใบอนุญาติ (ผู้รับเหมา),ใบอนุญาติ (โฟล์คลิฟท์),ใบอนุญาติ (TLEP),ใบอนุญาติ (Trailer),โทรศัพท์,สายสมอลทอร์ค</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARRYRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARRYRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOCARRYREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">12</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบรายละเอียดการทำงาน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOJOBDETAILCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">เข้าใจเส้นทาง,จุดพักรถ,รูปแบบการขับขี่,ความสำคัญในการส่งรถ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOJOBDETAILRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOJOBDETAILRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOJOBDETAILREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">13</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">แจ้งสภาพถนน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADINFORMCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">เข้าใจเนื้อหาที่แจ้ง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADINFORMRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADINFORMRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOLOADINFORMREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">14</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">แจ้งสภาพอากาศ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRINFORMCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">เข้าใจเนื้อหาที่แจ้ง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRINFORMRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRINFORMRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOAIRINFORMREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">15</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">แจ้งเรื่องโยโกะเต็น</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOYOKOTENCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">เข้าใจเนื้อหาที่แจ้ง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOYOKOTENRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOYOKOTENRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOYOKOTENREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">16</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบเป้าหมายการขับขี่จากเครื่องมูเลเตอร์</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCHIMOLATORCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบกันทั้งสองฝ่าย</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCHIMOLATORRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCHIMOLATORRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOCHIMOLATORREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">17</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สามารถวิ่งงานได้ปกติหรือไม่</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRANSPORTCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ไม่มีข้อบกพร่องต่อการวิ่งงาน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRANSPORTRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRANSPORTRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOTRANSPORTREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">18</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">การทักทายหลังทำเท็งโกะเสร็จ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAFTERGREETCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ทักทายอย่างมีชีวิตชีวา</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAFTERGREETRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAFTERGREETRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOAFTERGREETREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">***</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจเช็คออกซิเจนเลือด</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOOXYGENCHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOOXYGENDATA'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOOXYGENRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOOXYGENRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOOXYGENREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td colspan="9" style="border-right:1px solid #000;padding:4px;text-align:center;">ตรวจเช็คปัญหาสุขภาพสายตา1</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">1</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สายตาสั้น</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORESHORTSIGHTCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">พนักงานพกแว่นสายตามาปฏิบัติงาน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORESHORTSIGHTRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORESHORTSIGHTRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOSHORTSIGHTREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">2</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สายตายาว</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORELONGSIGHTCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">พนักงานพกแว่นสายตามาปฏิบัติงาน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORELONGSIGHTRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORELONGSIGHTRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOLONGSIGHTREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">3</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สายตาเอียง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREOBLIQUESIGHTCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">พนักงานพกแว่นสายตามาปฏิบัติงาน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREOBLIQUESIGHTRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREOBLIQUESIGHTRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOOBLIQUESIGHTREMARK'] . '</td>
      </tr>
    </tbody></table>
';

$condTenkotransportDAY21 = " AND TENKOMASTERID = '" . $_GET['tenkomasterid'] . "' AND TENKOMASTERDIRVERCODE = '" . $_GET['employeecode'] . "'";
$condTenkotransportDAY22 = " AND CONVERT(DATE,TENKOTRANSPORTDATE) = CONVERT(DATE,'" . $result_seTenkomaster['DATEINPUT_F2'] . "',103)";
$sql_seTenkotransportDAY2 = "{call megEdittenkotransport_v2(?,?,?,?,?)}";
$params_seTenkotransportDAY2 = array(
    array('select_tenkotransport', SQLSRV_PARAM_IN),
    array($condTenkotransportDAY21, SQLSRV_PARAM_IN),
    array($condTenkotransportDAY22, SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seTenkotransportDAY2 = sqlsrv_query($conn, $sql_seTenkotransportDAY2, $params_seTenkotransportDAY2);
$result_seTenkotransportDAY2 = sqlsrv_fetch_array($query_seTenkotransportDAY2, SQLSRV_FETCH_ASSOC);

$conditionEHR2 = " AND a.PersonCode ='" . $result_seTenkotransportDAY2['MODIFIEDBY'] . "'";
$sql_seEHR2 = "{call megEmployeeEHR_v2(?,?)}";
$params_seEHR2 = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array($conditionEHR2, SQLSRV_PARAM_IN)
);
$query_seEHR2 = sqlsrv_query($conn, $sql_seEHR2, $params_seEHR2);
$result_seEHR2 = sqlsrv_fetch_array($query_seEHR2, SQLSRV_FETCH_ASSOC);

$TENKOLOADRESTCHECKDAY2 = ($result_seTenkotransportDAY2['TENKOLOADRESTCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOBODYSLEEPYCHECKDAY2 = ($result_seTenkotransportDAY2['TENKOBODYSLEEPYCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOCARNEWCHECKDAY2 = ($result_seTenkotransportDAY2['TENKOCARNEWCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOTRAILERCHECKDAY2 = ($result_seTenkotransportDAY2['TENKOTRAILERCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOROADCHECKDAY2 = ($result_seTenkotransportDAY2['TENKOROADCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOAIRCHECKDAY2 = ($result_seTenkotransportDAY2['TENKOAIRCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOSLEEPYCHECKDAY2 = ($result_seTenkotransportDAY2['TENKOSLEEPYCHECK'] == "1" || $result_seTenkotransportDAY2['TENKOSLEEPYCHECK'] == "0x") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";


if ($result_seTenkotransportDAY2['TENKOLOADRESTRESULT0'] == "1") {
    $TENKOLOADRESTRESULTDAY20 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOLOADRESTRESULT0'] == "0") {
    $TENKOLOADRESTRESULTDAY20 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOLOADRESTRESULT0'] == "x") {
    $TENKOLOADRESTRESULTDAY20 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOLOADRESTRESULT0'] == "-") {
    $TENKOLOADRESTRESULTDAY20 = "<img src='../images/circle_3.png' width='2%'>";
}



if ($result_seTenkotransportDAY2['TENKOLOADRESTRESULT1'] == "1") {
    $TENKOLOADRESTRESULTDAY21 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOLOADRESTRESULT1'] == "0") {
    $TENKOLOADRESTRESULTDAY21 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOLOADRESTRESULT1'] == "x") {
    $TENKOLOADRESTRESULTDAY21 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOLOADRESTRESULT1'] == "-") {
    $TENKOLOADRESTRESULTDAY21 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOLOADRESTRESULT2'] == "1") {
    $TENKOLOADRESTRESULTDAY22 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOLOADRESTRESULT2'] == "0") {
    $TENKOLOADRESTRESULTDAY22 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOLOADRESTRESULT2'] == "x") {
    $TENKOLOADRESTRESULTDAY22 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOLOADRESTRESULT2'] == "-") {
    $TENKOLOADRESTRESULTDAY22 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOLOADRESTRESULT3'] == "1") {
    $TENKOLOADRESTRESULTDAY23 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOLOADRESTRESULT3'] == "0") {
    $TENKOLOADRESTRESULTDAY23 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOLOADRESTRESULT3'] == "x") {
    $TENKOLOADRESTRESULTDAY23 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOLOADRESTRESULT3'] == "-") {
    $TENKOLOADRESTRESULTDAY23 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOLOADRESTRESULT4'] == "1") {
    $TENKOLOADRESTRESULTDAY24 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOLOADRESTRESULT4'] == "0") {
    $TENKOLOADRESTRESULTDAY24 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOLOADRESTRESULT4'] == "x") {
    $TENKOLOADRESTRESULTDAY24 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOLOADRESTRESULT4'] == "-") {
    $TENKOLOADRESTRESULTDAY24 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOLOADRESTRESULT5'] == "1") {
    $TENKOLOADRESTRESULTDAY25 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOLOADRESTRESULT5'] == "0") {
    $TENKOLOADRESTRESULTDAY25 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOLOADRESTRESULT5'] == "x") {
    $TENKOLOADRESTRESULTDAY25 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOLOADRESTRESULT5'] == "-") {
    $TENKOLOADRESTRESULTDAY25 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOLOADRESTRESULT6'] == "1") {
    $TENKOLOADRESTRESULTDAY26 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOLOADRESTRESULT6'] == "0") {
    $TENKOLOADRESTRESULTDAY26 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOLOADRESTRESULT6'] == "x") {
    $TENKOLOADRESTRESULTDAY26 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOLOADRESTRESULT6'] == "-") {
    $TENKOLOADRESTRESULTDAY26 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOBODYSLEEPYRESULT0'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY20 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOBODYSLEEPYRESULT0'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY20 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOBODYSLEEPYRESULT0'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY20 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOBODYSLEEPYRESULT0'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY20 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOBODYSLEEPYRESULT1'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY21 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOBODYSLEEPYRESULT1'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY21 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOBODYSLEEPYRESULT1'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY21 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOBODYSLEEPYRESULT1'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY21 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOBODYSLEEPYRESULT2'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY22 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOBODYSLEEPYRESULT2'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY22 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOBODYSLEEPYRESULT2'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY22 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOBODYSLEEPYRESULT2'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY22 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOBODYSLEEPYRESULT3'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY23 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOBODYSLEEPYRESULT3'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY23 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOBODYSLEEPYRESULT3'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY23 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOBODYSLEEPYRESULT3'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY23 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOBODYSLEEPYRESULT4'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY24 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOBODYSLEEPYRESULT4'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY24 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOBODYSLEEPYRESULT4'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY24 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOBODYSLEEPYRESULT4'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY24 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOBODYSLEEPYRESULT5'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY25 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOBODYSLEEPYRESULT5'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY25 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOBODYSLEEPYRESULT5'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY25 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOBODYSLEEPYRESULT5'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY25 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOBODYSLEEPYRESULT6'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY26 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOBODYSLEEPYRESULT6'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY26 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOBODYSLEEPYRESULT6'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY26 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOBODYSLEEPYRESULT6'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY26 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOCARNEWRESULT0'] == "1") {
    $TENKOCARNEWRESULTDAY20 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOCARNEWRESULT0'] == "0") {
    $TENKOCARNEWRESULTDAY20 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOCARNEWRESULT0'] == "x") {
    $TENKOCARNEWRESULTDAY20 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOCARNEWRESULT0'] == "-") {
    $TENKOCARNEWRESULTDAY20 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOCARNEWRESULT1'] == "1") {
    $TENKOCARNEWRESULTDAY21 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOCARNEWRESULT1'] == "0") {
    $TENKOCARNEWRESULTDAY21 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOCARNEWRESULT1'] == "x") {
    $TENKOCARNEWRESULTDAY21 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOCARNEWRESULT1'] == "-") {
    $TENKOCARNEWRESULTDAY21 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOCARNEWRESULT2'] == "1") {
    $TENKOCARNEWRESULTDAY22 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOCARNEWRESULT2'] == "0") {
    $TENKOCARNEWRESULTDAY22 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOCARNEWRESULT2'] == "x") {
    $TENKOCARNEWRESULTDAY22 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOCARNEWRESULT2'] == "-") {
    $TENKOCARNEWRESULTDAY22 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOCARNEWRESULT3'] == "1") {
    $TENKOCARNEWRESULTDAY23 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOCARNEWRESULT3'] == "0") {
    $TENKOCARNEWRESULTDAY23 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOCARNEWRESULT3'] == "x") {
    $TENKOCARNEWRESULTDAY23 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOCARNEWRESULT3'] == "-") {
    $TENKOCARNEWRESULTDAY23 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOCARNEWRESULT4'] == "1") {
    $TENKOCARNEWRESULTDAY24 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOCARNEWRESULT4'] == "0") {
    $TENKOCARNEWRESULTDAY24 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOCARNEWRESULT4'] == "x") {
    $TENKOCARNEWRESULTDAY24 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOCARNEWRESULT4'] == "-") {
    $TENKOCARNEWRESULTDAY24 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOCARNEWRESULT5'] == "1") {
    $TENKOCARNEWRESULTDAY25 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOCARNEWRESULT5'] == "0") {
    $TENKOCARNEWRESULTDAY25 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOCARNEWRESULT5'] == "x") {
    $TENKOCARNEWRESULTDAY25 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOCARNEWRESULT5'] == "-") {
    $TENKOCARNEWRESULTDAY25 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOCARNEWRESULT6'] == "1") {
    $TENKOCARNEWRESULTDAY26 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOCARNEWRESULT6'] == "0") {
    $TENKOCARNEWRESULTDAY26 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOCARNEWRESULT6'] == "x") {
    $TENKOCARNEWRESULTDAY26 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOCARNEWRESULT6'] == "-") {
    $TENKOCARNEWRESULTDAY26 = "<img src='../images/circle_3.png' width='2%'>";
}
if ($result_seTenkotransportDAY2['TENKOTRAILERRESULT0'] == "1") {
    $TENKOTRAILERRESULTDAY20 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOTRAILERRESULT0'] == "0") {
    $TENKOTRAILERRESULTDAY20 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOTRAILERRESULT0'] == "x") {
    $TENKOTRAILERRESULTDAY20 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOTRAILERRESULT0'] == "-") {
    $TENKOTRAILERRESULTDAY20 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOTRAILERRESULT1'] == "1") {
    $TENKOTRAILERRESULTDAY21 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOTRAILERRESULT1'] == "0") {
    $TENKOTRAILERRESULTDAY21 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOTRAILERRESULT1'] == "x") {
    $TENKOTRAILERRESULTDAY21 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOTRAILERRESULT1'] == "-") {
    $TENKOTRAILERRESULTDAY21 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOTRAILERRESULT2'] == "1") {
    $TENKOTRAILERRESULTDAY22 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOTRAILERRESULT2'] == "0") {
    $TENKOTRAILERRESULTDAY22 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOTRAILERRESULT2'] == "x") {
    $TENKOTRAILERRESULTDAY22 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOTRAILERRESULT2'] == "-") {
    $TENKOTRAILERRESULTDAY22 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOTRAILERRESULT3'] == "1") {
    $TENKOTRAILERRESULTDAY23 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOTRAILERRESULT3'] == "0") {
    $TENKOTRAILERRESULTDAY23 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOTRAILERRESULT3'] == "x") {
    $TENKOTRAILERRESULTDAY23 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOTRAILERRESULT3'] == "-") {
    $TENKOTRAILERRESULTDAY23 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOTRAILERRESULT4'] == "1") {
    $TENKOTRAILERRESULTDAY24 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOTRAILERRESULT4'] == "0") {
    $TENKOTRAILERRESULTDAY24 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOTRAILERRESULT4'] == "x") {
    $TENKOTRAILERRESULTDAY24 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOTRAILERRESULT4'] == "-") {
    $TENKOTRAILERRESULTDAY24 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOTRAILERRESULT5'] == "1") {
    $TENKOTRAILERRESULTDAY25 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOTRAILERRESULT5'] == "0") {
    $TENKOTRAILERRESULTDAY25 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOTRAILERRESULT5'] == "x") {
    $TENKOTRAILERRESULTDAY25 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOTRAILERRESULT5'] == "-") {
    $TENKOTRAILERRESULTDAY25 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOTRAILERRESULT6'] == "1") {
    $TENKOTRAILERRESULTDAY26 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOTRAILERRESULT6'] == "0") {
    $TENKOTRAILERRESULTDAY26 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOTRAILERRESULT6'] == "x") {
    $TENKOTRAILERRESULTDAY26 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOTRAILERRESULT6'] == "-") {
    $TENKOTRAILERRESULTDAY26 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOROADRESULT0'] == "1") {
    $TENKOROADRESULTDAY20 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOROADRESULT0'] == "0") {
    $TENKOROADRESULTDAY20 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOROADRESULT0'] == "x") {
    $TENKOROADRESULTDAY20 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOROADRESULT0'] == "-") {
    $TENKOROADRESULTDAY20 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOROADRESULT1'] == "1") {
    $TENKOROADRESULTDAY21 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOROADRESULT1'] == "0") {
    $TENKOROADRESULTDAY21 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOROADRESULT1'] == "x") {
    $TENKOROADRESULTDAY21 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOROADRESULT1'] == "-") {
    $TENKOROADRESULTDAY21 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOROADRESULT2'] == "1") {
    $TENKOROADRESULTDAY22 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOROADRESULT2'] == "0") {
    $TENKOROADRESULTDAY22 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOROADRESULT2'] == "x") {
    $TENKOROADRESULTDAY22 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOROADRESULT2'] == "-") {
    $TENKOROADRESULTDAY22 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOROADRESULT3'] == "1") {
    $TENKOROADRESULTDAY23 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOROADRESULT3'] == "0") {
    $TENKOROADRESULTDAY23 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOROADRESULT3'] == "x") {
    $TENKOROADRESULTDAY23 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOROADRESULT3'] == "-") {
    $TENKOROADRESULTDAY23 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOROADRESULT4'] == "1") {
    $TENKOROADRESULTDAY24 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOROADRESULT4'] == "0") {
    $TENKOROADRESULTDAY24 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOROADRESULT4'] == "x") {
    $TENKOROADRESULTDAY24 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOROADRESULT4'] == "-") {
    $TENKOROADRESULTDAY24 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOROADRESULT5'] == "1") {
    $TENKOROADRESULTDAY25 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOROADRESULT5'] == "0") {
    $TENKOROADRESULTDAY25 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOROADRESULT5'] == "x") {
    $TENKOROADRESULTDAY25 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOROADRESULT5'] == "-") {
    $TENKOROADRESULTDAY25 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOROADRESULT6'] == "1") {
    $TENKOROADRESULTDAY26 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOROADRESULT6'] == "0") {
    $TENKOROADRESULTDAY26 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOROADRESULT6'] == "x") {
    $TENKOROADRESULTDAY26 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOROADRESULT6'] == "-") {
    $TENKOROADRESULTDAY26 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOAIRRESULT0'] == "1") {
    $TENKOAIRRESULTDAY20 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOAIRRESULT0'] == "0") {
    $TENKOAIRRESULTDAY20 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOAIRRESULT0'] == "x") {
    $TENKOAIRRESULTDAY20 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOAIRRESULT0'] == "-") {
    $TENKOAIRRESULTDAY20 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOAIRRESULT1'] == "1") {
    $TENKOAIRRESULTDAY21 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOAIRRESULT1'] == "0") {
    $TENKOAIRRESULTDAY21 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOAIRRESULT1'] == "x") {
    $TENKOAIRRESULTDAY21 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOAIRRESULT1'] == "-") {
    $TENKOAIRRESULTDAY21 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOAIRRESULT2'] == "1") {
    $TENKOAIRRESULTDAY22 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOAIRRESULT2'] == "0") {
    $TENKOAIRRESULTDAY22 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOAIRRESULT2'] == "x") {
    $TENKOAIRRESULTDAY22 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOAIRRESULT2'] == "-") {
    $TENKOAIRRESULTDAY22 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOAIRRESULT3'] == "1") {
    $TENKOAIRRESULTDAY23 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOAIRRESULT3'] == "0") {
    $TENKOAIRRESULTDAY23 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOAIRRESULT3'] == "x") {
    $TENKOAIRRESULTDAY23 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOAIRRESULT3'] == "-") {
    $TENKOAIRRESULTDAY23 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOAIRRESULT4'] == "1") {
    $TENKOAIRRESULTDAY24 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOAIRRESULT4'] == "0") {
    $TENKOAIRRESULTDAY24 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOAIRRESULT4'] == "x") {
    $TENKOAIRRESULTDAY24 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOAIRRESULT4'] == "-") {
    $TENKOAIRRESULTDAY24 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOAIRRESULT5'] == "1") {
    $TENKOAIRRESULTDAY25 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOAIRRESULT5'] == "0") {
    $TENKOAIRRESULTDAY25 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOAIRRESULT5'] == "x") {
    $TENKOAIRRESULTDAY25 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOAIRRESULT5'] == "-") {
    $TENKOAIRRESULTDAY25 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOAIRRESULT6'] == "1") {
    $TENKOAIRRESULTDAY26 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOAIRRESULT6'] == "0") {
    $TENKOAIRRESULTDAY26 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOAIRRESULT6'] == "x") {
    $TENKOAIRRESULTDAY26 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOAIRRESULT6'] == "-") {
    $TENKOAIRRESULTDAY26 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOSLEEPYRESULT0'] == "1") {
    $TENKOSLEEPYRESULTDAY20 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOSLEEPYRESULT0'] == "0") {
    $TENKOSLEEPYRESULTDAY20 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOSLEEPYRESULT0'] == "x") {
    $TENKOSLEEPYRESULTDAY20 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOSLEEPYRESULT0'] == "-") {
    $TENKOSLEEPYRESULTDAY20 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOSLEEPYRESULT1'] == "1") {
    $TENKOSLEEPYRESULTDAY21 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOSLEEPYRESULT1'] == "0") {
    $TENKOSLEEPYRESULTDAY21 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOSLEEPYRESULT1'] == "x") {
    $TENKOSLEEPYRESULTDAY21 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOSLEEPYRESULT1'] == "-") {
    $TENKOSLEEPYRESULTDAY21 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOSLEEPYRESULT2'] == "1") {
    $TENKOSLEEPYRESULTDAY22 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOSLEEPYRESULT2'] == "0") {
    $TENKOSLEEPYRESULTDAY22 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOSLEEPYRESULT2'] == "x") {
    $TENKOSLEEPYRESULTDAY22 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOSLEEPYRESULT2'] == "-") {
    $TENKOSLEEPYRESULTDAY22 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOSLEEPYRESULT3'] == "1") {
    $TENKOSLEEPYRESULTDAY23 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOSLEEPYRESULT3'] == "0") {
    $TENKOSLEEPYRESULTDAY23 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOSLEEPYRESULT3'] == "x") {
    $TENKOSLEEPYRESULTDAY23 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOSLEEPYRESULT3'] == "-") {
    $TENKOSLEEPYRESULTDAY23 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOSLEEPYRESULT4'] == "1") {
    $TENKOSLEEPYRESULTDAY24 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOSLEEPYRESULT4'] == "0") {
    $TENKOSLEEPYRESULTDAY24 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOSLEEPYRESULT4'] == "x") {
    $TENKOSLEEPYRESULTDAY24 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOSLEEPYRESULT4'] == "-") {
    $TENKOSLEEPYRESULTDAY24 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOSLEEPYRESULT5'] == "1") {
    $TENKOSLEEPYRESULTDAY25 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOSLEEPYRESULT5'] == "0") {
    $TENKOSLEEPYRESULTDAY25 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOSLEEPYRESULT5'] == "x") {
    $TENKOSLEEPYRESULTDAY25 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOSLEEPYRESULT5'] == "-") {
    $TENKOSLEEPYRESULTDAY25 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY2['TENKOSLEEPYRESULT6'] == "1") {
    $TENKOSLEEPYRESULTDAY26 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOSLEEPYRESULT6'] == "0") {
    $TENKOSLEEPYRESULTDAY26 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOSLEEPYRESULT6'] == "x") {
    $TENKOSLEEPYRESULTDAY26 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY2['TENKOSLEEPYRESULT6'] == "-") {
    $TENKOSLEEPYRESULTDAY26 = "<img src='../images/circle_3.png' width='2%'>";
}
$VAR_MODIFIEDBY2 = ($result_seTenkotransportDAY2["MODIFIEDBY"] == "") ? $result_seTenkotransportDAY2["CREATEBY"] : $result_seTenkotransportDAY2["MODIFIEDBY"];
$table_2DAY2 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>
    <tr style="border:1px solid #000;padding:4px;">
    <th colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"></th>
    <th colspan="1" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY2['TENKOTRANSPORTDATE'] . '</th>
      <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;">เท็งโกะระหว่างทาง</th>
        <th colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">ลายเซนเจ้าหน้าที่เท็งโกะ</th>
        <th colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $VAR_MODIFIEDBY2 . '</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="12" style="border-right:1px solid #000;padding:4px;text-align:left;">เจ้าหน้าที่โทรไปไม่พบสิ่งผิดปกติ : 0 | พนักงานขับรถโทรมาไม่พบสิ่งผิดปกติ : 1 | พบสิ่งผิดปกติ : x</li></th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th width="5%" rowspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">ข้อ</th>
        <th rowspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">หัวข้อ</th>
        <th rowspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">ช่องตรวจสอบ</th>
        <th rowspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">เกณฑ์การตัดสิน</th>
        <th rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">โทรช่วง 06:00 - 24:00</th>
        <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;">Night Call Check</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">รายละเอียดการแนะนำ</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 1</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 2</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 3</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 4</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 5</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 6</th>
        <th rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY2['TENKOTIME0'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY2['TENKOTIME1'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY2['TENKOTIME2'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY2['TENKOTIME3'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY2['TENKOTIME4'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY2['TENKOTIME5'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY2['TENKOTIME6'] . '</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
    </tr>
    </thead>
    <tbody>
    <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">1</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">เส้นทางที่กำหนด - จุดพัก</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTCHECKDAY2 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">เส้นทาง จุดพักที่กำหนด</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY20 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY20 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY20 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY20 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY20 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY20 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY20 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY2['TENKOLOADRESTREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">2</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจร่างกาย - อาการง่วง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYCHECKDAY2 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">วิธีการพูดคุยต้องร่าเริง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY21 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY21 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY21 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY21 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY21 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY21 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY21 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY2['TENKOBODYSLEEPYREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">3</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจรถใหม่ (เฉพาะหยุดจอด)</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWCHECKDAY2 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">มีการรายงานเกี่ยวกับรถใหม่ว่ามีสิ่งผิดปกติหรือไม่</td>
      <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY22 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY22 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY22 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY22 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY22 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY22 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY22 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY2['TENKOCARNEWREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">4</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจเทรลเลอร์</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERCHECKDAY2 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ระหว่างวิ่งงานไม่มีสิ่งผิดปกติ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY23 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY23 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY23 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY23 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY23 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY23 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY23 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY2['TENKOTRAILERREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">5</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสภาพถนน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADCHECKDAY2 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">รายงานสภาพถนน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY24 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY24 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY24 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY24 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY24 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY24 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY24 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY2['TENKOROADREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">6</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบสภาพอากาศ (ใช้ที่ปัดน้ำฝนระดับ 3 ให้หยุดรถ)</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRCHECKDAY2 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">รายงานสภาพอากาศ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY25 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY25 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY25 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY25 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY25 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY25 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY25 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY2['TENKOAIRREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">7</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบอาการง่วงและย้ำให้ระมัดระวัง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYCHECKDAY2 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สภาพที่สามารถวิ่งงานต่อได้</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY26 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY26 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY26 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY26 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY26 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY26 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY26 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY2['TENKOSLEEPYREMARK'] . '</td>
      </tr>
    </tbody></table>

';

$table_headerDAY3 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>
    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkobefor['TENKOBEFOREDATE'] . '</th>
        <th colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">เอกสารเท็งโกะ</th>
        <th colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">Issue date 23 Jan 2017<br>          Toyota Transport (Thailand) Co.,LTD.</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th width="10%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">เปลี่ยนกะ</th>
        <th width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">กลางวัน</th>
        <th width="10%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ไม่เปลี่ยนกะ</th>
        <th width="5%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">บริษัท</th>
        <th width="15%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkobefor['Company_NameT'] . '</th>
        <th width="5%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ชื่อพขร.</th>
        <th width="15%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seDir['nameT'] . '</th>
        <th width="10%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">หมายเลขรถ</th>
        <th width="20%" colspan="3" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkobefor['TENKOMASTERVEHICLE'] . '</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">กลางคืน</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="5" style="border-right:1px solid #000;padding:4px;text-align:left;">รายละเอียดงาน (เท็งโกะก่อนเริ่มงาน ข้อ 12.)</th>
        <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:left;">เป้าหมายการวิ่งงานวันนี้ (เท็งโกะก่อนเริ่มงาน ข้อ 16.)</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="5" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_sePlain['JOBSTART'] . '->' . $result_sePlain['JOBEND'] . '</th>
        <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:left;"> </th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="5" height="100" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkomaster['TENKOMASTERREMARKBEFORE'] . '</th>
        <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $TENKOTARGET1 . '<br>' . $TENKOTARGET2 . '<br>' . $TENKOTARGET3 . '<br>' . $TENKOTARGET4 . '<br>' . $TENKOTARGET5 . '<br>' . $TENKOTARGET6 . '<br>' . $TENKOTARGET7 . '</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>';
$table_1DAY3 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>
    <tr style="border:1px solid #000;padding:4px;">
     <th style="border-right:1px solid #000;padding:4px;text-align:center;">เวลา<br />ทำเท็งโกะ</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOBEFOREDATE'] . '</th>
      <th colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">เท็งโกะก่อนเริ่มงาน</th>
        <th width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">ลายเซ็น<br />เจ้าหน้าที่<br />เท็งโกะ</th>
        <th width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREBY1 . '</th>
        <th  width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">ลายเซ็น พขร.</th>
        <th  width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seDir['nameT'] . '</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th width="5%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ข้อ</th>
        <th width="25%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">หัวข้อ</th>
        <th width="10%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ช่องตรวจสอบ</th>
        <th width="20%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</th>
        <th width="20%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">เกณฑ์การตัดสิน</th>
        <th colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th  colspan="2" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">รายละเอียดและการแนะนำ</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ปกติ</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผิดปกติ</th>
    </tr>
    </thead>
    <tbody>
    <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">1</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">การทักทายก่อนเริ่มเท็งโกะ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREGREETCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ทักทายอย่างมีชีวิตชีวา</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREGREETRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREGREETRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOBEFOREGREETREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">2</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจเช็คยูนิฟอร์ม</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOUNIFORMCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">สวมชุดที่สอาด ไม่ใส่เครื่องประดับที่อาจทำให้เกิดรอย</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOUNIFORMRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOUNIFORMRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOUNIFORMREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">3</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบสภาพร่างกาย</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">สภาพร่างกายแข็งแรงดี</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOBODYREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">4</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบระยะการพักผ่อน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKORESTCHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตั้งแต่ 8 ชั่วโมง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKORESTDATA'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKORESTRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKORESTRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKORESTREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">5</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบชั่วโมงการนอนหลับ</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPTIMECHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;"><strong>การนอนปกติ</strong><br>
        ตั้งแต่ 6 ชั่วโมงขั้นไป</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOSLEEPTIMEDATA_AFTER6H'] . '</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPTIMERESULT1 . '</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPTIMERESULT0 . '</td>
        <td colspan="2" rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOSLEEPTIMEREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;"><strong>การนอนเพิ่ม</strong> (กะกลางคืน)<br>
        ตั้งแต่ 4.5 ชั่วโมงขึ้นไป</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">(___' . $result_seTenkobefor['TENKOSLEEPTIMEDATA_ADD45H'] . '___ชม.)</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">6</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจเช็คอุณหภูมิ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTEMPERATURECHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ต่ำกว่า 37 องศา</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOTEMPERATUREDATA'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTEMPERATURERESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTEMPERATURERESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOTEMPERATUREREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">7</td>
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">วัดความดัน</td>
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOPRESSURECHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">บน : 90-160</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $SYS . '</td>
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOPRESSURERESULT1 . '</td>
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOPRESSURERESULT0 . '</td>
        <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOPRESSUREREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ล่าง : 60-100</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $DIA . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">อัตราการเต้นหัวใจ : 60-100 ครั้ง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $HEARTRATE . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">8</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ครวจเช็คแอลกอฮอล์</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOALCOHOLCHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">[0]</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOALCOHOLDATA'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOALCOHOLRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOALCOHOLRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOALCOHOLREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">9</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สอบถามเรื่องกังวลใจ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOWORRYCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ไม่มีเรื่องกังวลใจ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOWORRYRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOWORRYRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOWORRYREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">10</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ใบตรวจเทรลเลอร์ประจำวัน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKODAILYTRAILERCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ไม่มีหัวข้อผิดปกติ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKODAILYTRAILERRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKODAILYTRAILERRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKODAILYTRAILERREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">11</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบของที่พกพา</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARRYCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ใบอนุญาติขับขี่,ใบอนุญาติ (ผู้รับเหมา),ใบอนุญาติ (โฟล์คลิฟท์),ใบอนุญาติ (TLEP),ใบอนุญาติ (Trailer),โทรศัพท์,สายสมอลทอร์ค</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARRYRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARRYRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOCARRYREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">12</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบรายละเอียดการทำงาน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOJOBDETAILCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">เข้าใจเส้นทาง,จุดพักรถ,รูปแบบการขับขี่,ความสำคัญในการส่งรถ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOJOBDETAILRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOJOBDETAILRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOJOBDETAILREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">13</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">แจ้งสภาพถนน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADINFORMCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">เข้าใจเนื้อหาที่แจ้ง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADINFORMRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADINFORMRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOLOADINFORMREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">14</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">แจ้งสภาพอากาศ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRINFORMCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">เข้าใจเนื้อหาที่แจ้ง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRINFORMRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRINFORMRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOAIRINFORMREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">15</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">แจ้งเรื่องโยโกะเต็น</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOYOKOTENCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">เข้าใจเนื้อหาที่แจ้ง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOYOKOTENRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOYOKOTENRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOYOKOTENREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">16</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบเป้าหมายการขับขี่จากเครื่องมูเลเตอร์</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCHIMOLATORCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบกันทั้งสองฝ่าย</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCHIMOLATORRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCHIMOLATORRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOCHIMOLATORREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">17</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สามารถวิ่งงานได้ปกติหรือไม่</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRANSPORTCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ไม่มีข้อบกพร่องต่อการวิ่งงาน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRANSPORTRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRANSPORTRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOTRANSPORTREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">18</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">การทักทายหลังทำเท็งโกะเสร็จ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAFTERGREETCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ทักทายอย่างมีชีวิตชีวา</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAFTERGREETRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAFTERGREETRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOAFTERGREETREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">***</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจเช็คออกซิเจนเลือด</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOOXYGENCHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOOXYGENDATA'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOOXYGENRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOOXYGENRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOOXYGENREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td colspan="9" style="border-right:1px solid #000;padding:4px;text-align:center;">ตรวจเช็คปัญหาสุขภาพสายตา2</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">1</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สายตาสั้น</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORESHORTSIGHTCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">พนักงานพกแว่นสายตามาปฏิบัติงาน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORESHORTSIGHTRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORESHORTSIGHTRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOSHORTSIGHTREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">2</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สายตายาว</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORELONGSIGHTCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">พนักงานพกแว่นสายตามาปฏิบัติงาน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORELONGSIGHTRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORELONGSIGHTRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOLONGSIGHTREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">3</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สายตาเอียง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREOBLIQUESIGHTCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">พนักงานพกแว่นสายตามาปฏิบัติงาน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREOBLIQUESIGHTRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREOBLIQUESIGHTRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOOBLIQUESIGHTREMARK'] . '</td>
      </tr>
    </tbody></table>
';

$condTenkotransportDAY31 = " AND TENKOMASTERID = '" . $_GET['tenkomasterid'] . "' AND TENKOMASTERDIRVERCODE = '" . $_GET['employeecode'] . "'";
$condTenkotransportDAY32 = " AND CONVERT(DATE,TENKOTRANSPORTDATE) = CONVERT(DATE,'" . $result_seTenkomaster['DATEINPUT_F3'] . "',103)";
$sql_seTenkotransportDAY3 = "{call megEdittenkotransport_v2(?,?,?,?,?)}";
$params_seTenkotransportDAY3 = array(
    array('select_tenkotransport', SQLSRV_PARAM_IN),
    array($condTenkotransportDAY31, SQLSRV_PARAM_IN),
    array($condTenkotransportDAY32, SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seTenkotransportDAY3 = sqlsrv_query($conn, $sql_seTenkotransportDAY3, $params_seTenkotransportDAY3);
$result_seTenkotransportDAY3 = sqlsrv_fetch_array($query_seTenkotransportDAY3, SQLSRV_FETCH_ASSOC);

$conditionEHR3 = " AND a.PersonCode ='" . $result_seTenkotransportDAY3['MODIFIEDBY'] . "'";
$sql_seEHR3 = "{call megEmployeeEHR_v2(?,?)}";
$params_seEHR3 = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array($conditionEHR3, SQLSRV_PARAM_IN)
);
$query_seEHR3 = sqlsrv_query($conn, $sql_seEHR3, $params_seEHR3);
$result_seEHR3 = sqlsrv_fetch_array($query_seEHR3, SQLSRV_FETCH_ASSOC);

$TENKOLOADRESTCHECKDAY3 = ($result_seTenkotransportDAY3['TENKOLOADRESTCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOBODYSLEEPYCHECKDAY3 = ($result_seTenkotransportDAY3['TENKOBODYSLEEPYCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOCARNEWCHECKDAY3 = ($result_seTenkotransportDAY3['TENKOCARNEWCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOTRAILERCHECKDAY3 = ($result_seTenkotransportDAY3['TENKOTRAILERCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOROADCHECKDAY3 = ($result_seTenkotransportDAY3['TENKOROADCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOAIRCHECKDAY3 = ($result_seTenkotransportDAY3['TENKOAIRCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOSLEEPYCHECKDAY3 = ($result_seTenkotransportDAY3['TENKOSLEEPYCHECK'] == "1" || $result_seTenkotransportDAY3['TENKOSLEEPYCHECK'] == "0x") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";


if ($result_seTenkotransportDAY3['TENKOLOADRESTRESULT0'] == "1") {
    $TENKOLOADRESTRESULTDAY30 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOLOADRESTRESULT0'] == "0") {
    $TENKOLOADRESTRESULTDAY30 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOLOADRESTRESULT0'] == "x") {
    $TENKOLOADRESTRESULTDAY30 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOLOADRESTRESULT0'] == "-") {
    $TENKOLOADRESTRESULTDAY30 = "<img src='../images/circle_3.png' width='2%'>";
}



if ($result_seTenkotransportDAY3['TENKOLOADRESTRESULT1'] == "1") {
    $TENKOLOADRESTRESULTDAY31 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOLOADRESTRESULT1'] == "0") {
    $TENKOLOADRESTRESULTDAY31 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOLOADRESTRESULT1'] == "x") {
    $TENKOLOADRESTRESULTDAY31 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOLOADRESTRESULT1'] == "-") {
    $TENKOLOADRESTRESULTDAY31 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOLOADRESTRESULT2'] == "1") {
    $TENKOLOADRESTRESULTDAY32 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOLOADRESTRESULT2'] == "0") {
    $TENKOLOADRESTRESULTDAY32 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOLOADRESTRESULT2'] == "x") {
    $TENKOLOADRESTRESULTDAY32 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOLOADRESTRESULT2'] == "-") {
    $TENKOLOADRESTRESULTDAY32 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOLOADRESTRESULT3'] == "1") {
    $TENKOLOADRESTRESULTDAY33 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOLOADRESTRESULT3'] == "0") {
    $TENKOLOADRESTRESULTDAY33 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOLOADRESTRESULT3'] == "x") {
    $TENKOLOADRESTRESULTDAY33 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOLOADRESTRESULT3'] == "-") {
    $TENKOLOADRESTRESULTDAY33 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOLOADRESTRESULT4'] == "1") {
    $TENKOLOADRESTRESULTDAY34 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOLOADRESTRESULT4'] == "0") {
    $TENKOLOADRESTRESULTDAY34 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOLOADRESTRESULT4'] == "x") {
    $TENKOLOADRESTRESULTDAY34 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOLOADRESTRESULT4'] == "-") {
    $TENKOLOADRESTRESULTDAY34 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOLOADRESTRESULT5'] == "1") {
    $TENKOLOADRESTRESULTDAY35 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOLOADRESTRESULT5'] == "0") {
    $TENKOLOADRESTRESULTDAY35 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOLOADRESTRESULT5'] == "x") {
    $TENKOLOADRESTRESULTDAY35 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOLOADRESTRESULT5'] == "-") {
    $TENKOLOADRESTRESULTDAY35 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOLOADRESTRESULT6'] == "1") {
    $TENKOLOADRESTRESULTDAY36 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOLOADRESTRESULT6'] == "0") {
    $TENKOLOADRESTRESULTDAY36 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOLOADRESTRESULT6'] == "x") {
    $TENKOLOADRESTRESULTDAY36 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOLOADRESTRESULT6'] == "-") {
    $TENKOLOADRESTRESULTDAY36 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOBODYSLEEPYRESULT0'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY30 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOBODYSLEEPYRESULT0'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY30 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOBODYSLEEPYRESULT0'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY30 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOBODYSLEEPYRESULT0'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY30 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOBODYSLEEPYRESULT1'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY31 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOBODYSLEEPYRESULT1'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY31 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOBODYSLEEPYRESULT1'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY31 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOBODYSLEEPYRESULT1'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY31 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOBODYSLEEPYRESULT2'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY32 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOBODYSLEEPYRESULT2'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY32 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOBODYSLEEPYRESULT2'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY32 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOBODYSLEEPYRESULT2'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY32 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOBODYSLEEPYRESULT3'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY33 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOBODYSLEEPYRESULT3'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY33 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOBODYSLEEPYRESULT3'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY33 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOBODYSLEEPYRESULT3'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY33 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOBODYSLEEPYRESULT4'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY34 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOBODYSLEEPYRESULT4'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY34 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOBODYSLEEPYRESULT4'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY34 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOBODYSLEEPYRESULT4'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY34 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOBODYSLEEPYRESULT5'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY35 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOBODYSLEEPYRESULT5'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY35 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOBODYSLEEPYRESULT5'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY35 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOBODYSLEEPYRESULT5'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY35 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOBODYSLEEPYRESULT6'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY36 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOBODYSLEEPYRESULT6'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY36 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOBODYSLEEPYRESULT6'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY36 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOBODYSLEEPYRESULT6'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY36 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOCARNEWRESULT0'] == "1") {
    $TENKOCARNEWRESULTDAY30 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOCARNEWRESULT0'] == "0") {
    $TENKOCARNEWRESULTDAY30 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOCARNEWRESULT0'] == "x") {
    $TENKOCARNEWRESULTDAY30 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOCARNEWRESULT0'] == "-") {
    $TENKOCARNEWRESULTDAY30 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOCARNEWRESULT1'] == "1") {
    $TENKOCARNEWRESULTDAY31 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOCARNEWRESULT1'] == "0") {
    $TENKOCARNEWRESULTDAY31 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOCARNEWRESULT1'] == "x") {
    $TENKOCARNEWRESULTDAY31 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOCARNEWRESULT1'] == "-") {
    $TENKOCARNEWRESULTDAY31 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOCARNEWRESULT2'] == "1") {
    $TENKOCARNEWRESULTDAY32 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOCARNEWRESULT2'] == "0") {
    $TENKOCARNEWRESULTDAY32 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOCARNEWRESULT2'] == "x") {
    $TENKOCARNEWRESULTDAY32 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOCARNEWRESULT2'] == "-") {
    $TENKOCARNEWRESULTDAY32 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOCARNEWRESULT3'] == "1") {
    $TENKOCARNEWRESULTDAY33 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOCARNEWRESULT3'] == "0") {
    $TENKOCARNEWRESULTDAY33 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOCARNEWRESULT3'] == "x") {
    $TENKOCARNEWRESULTDAY33 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOCARNEWRESULT3'] == "-") {
    $TENKOCARNEWRESULTDAY33 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOCARNEWRESULT4'] == "1") {
    $TENKOCARNEWRESULTDAY34 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOCARNEWRESULT4'] == "0") {
    $TENKOCARNEWRESULTDAY34 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOCARNEWRESULT4'] == "x") {
    $TENKOCARNEWRESULTDAY34 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOCARNEWRESULT4'] == "-") {
    $TENKOCARNEWRESULTDAY34 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOCARNEWRESULT5'] == "1") {
    $TENKOCARNEWRESULTDAY35 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOCARNEWRESULT5'] == "0") {
    $TENKOCARNEWRESULTDAY35 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOCARNEWRESULT5'] == "x") {
    $TENKOCARNEWRESULTDAY35 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOCARNEWRESULT5'] == "-") {
    $TENKOCARNEWRESULTDAY35 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOCARNEWRESULT6'] == "1") {
    $TENKOCARNEWRESULTDAY36 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOCARNEWRESULT6'] == "0") {
    $TENKOCARNEWRESULTDAY36 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOCARNEWRESULT6'] == "x") {
    $TENKOCARNEWRESULTDAY36 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOCARNEWRESULT6'] == "-") {
    $TENKOCARNEWRESULTDAY36 = "<img src='../images/circle_3.png' width='2%'>";
}
if ($result_seTenkotransportDAY3['TENKOTRAILERRESULT0'] == "1") {
    $TENKOTRAILERRESULTDAY30 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOTRAILERRESULT0'] == "0") {
    $TENKOTRAILERRESULTDAY30 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOTRAILERRESULT0'] == "x") {
    $TENKOTRAILERRESULTDAY30 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOTRAILERRESULT0'] == "-") {
    $TENKOTRAILERRESULTDAY30 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOTRAILERRESULT1'] == "1") {
    $TENKOTRAILERRESULTDAY31 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOTRAILERRESULT1'] == "0") {
    $TENKOTRAILERRESULTDAY31 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOTRAILERRESULT1'] == "x") {
    $TENKOTRAILERRESULTDAY31 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOTRAILERRESULT1'] == "-") {
    $TENKOTRAILERRESULTDAY31 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOTRAILERRESULT2'] == "1") {
    $TENKOTRAILERRESULTDAY32 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOTRAILERRESULT2'] == "0") {
    $TENKOTRAILERRESULTDAY32 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOTRAILERRESULT2'] == "x") {
    $TENKOTRAILERRESULTDAY32 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOTRAILERRESULT2'] == "-") {
    $TENKOTRAILERRESULTDAY32 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOTRAILERRESULT3'] == "1") {
    $TENKOTRAILERRESULTDAY33 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOTRAILERRESULT3'] == "0") {
    $TENKOTRAILERRESULTDAY33 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOTRAILERRESULT3'] == "x") {
    $TENKOTRAILERRESULTDAY33 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOTRAILERRESULT3'] == "-") {
    $TENKOTRAILERRESULTDAY33 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOTRAILERRESULT4'] == "1") {
    $TENKOTRAILERRESULTDAY34 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOTRAILERRESULT4'] == "0") {
    $TENKOTRAILERRESULTDAY34 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOTRAILERRESULT4'] == "x") {
    $TENKOTRAILERRESULTDAY34 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOTRAILERRESULT4'] == "-") {
    $TENKOTRAILERRESULTDAY34 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOTRAILERRESULT5'] == "1") {
    $TENKOTRAILERRESULTDAY35 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOTRAILERRESULT5'] == "0") {
    $TENKOTRAILERRESULTDAY35 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOTRAILERRESULT5'] == "x") {
    $TENKOTRAILERRESULTDAY35 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOTRAILERRESULT5'] == "-") {
    $TENKOTRAILERRESULTDAY35 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOTRAILERRESULT6'] == "1") {
    $TENKOTRAILERRESULTDAY36 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOTRAILERRESULT6'] == "0") {
    $TENKOTRAILERRESULTDAY36 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOTRAILERRESULT6'] == "x") {
    $TENKOTRAILERRESULTDAY36 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOTRAILERRESULT6'] == "-") {
    $TENKOTRAILERRESULTDAY36 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOROADRESULT0'] == "1") {
    $TENKOROADRESULTDAY30 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOROADRESULT0'] == "0") {
    $TENKOROADRESULTDAY30 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOROADRESULT0'] == "x") {
    $TENKOROADRESULTDAY30 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOROADRESULT0'] == "-") {
    $TENKOROADRESULTDAY30 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOROADRESULT1'] == "1") {
    $TENKOROADRESULTDAY31 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOROADRESULT1'] == "0") {
    $TENKOROADRESULTDAY31 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOROADRESULT1'] == "x") {
    $TENKOROADRESULTDAY31 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOROADRESULT1'] == "-") {
    $TENKOROADRESULTDAY31 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOROADRESULT2'] == "1") {
    $TENKOROADRESULTDAY32 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOROADRESULT2'] == "0") {
    $TENKOROADRESULTDAY32 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOROADRESULT2'] == "x") {
    $TENKOROADRESULTDAY32 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOROADRESULT2'] == "-") {
    $TENKOROADRESULTDAY32 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOROADRESULT3'] == "1") {
    $TENKOROADRESULTDAY33 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOROADRESULT3'] == "0") {
    $TENKOROADRESULTDAY33 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOROADRESULT3'] == "x") {
    $TENKOROADRESULTDAY33 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOROADRESULT3'] == "-") {
    $TENKOROADRESULTDAY33 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOROADRESULT4'] == "1") {
    $TENKOROADRESULTDAY34 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOROADRESULT4'] == "0") {
    $TENKOROADRESULTDAY34 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOROADRESULT4'] == "x") {
    $TENKOROADRESULTDAY34 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOROADRESULT4'] == "-") {
    $TENKOROADRESULTDAY34 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOROADRESULT5'] == "1") {
    $TENKOROADRESULTDAY35 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOROADRESULT5'] == "0") {
    $TENKOROADRESULTDAY35 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOROADRESULT5'] == "x") {
    $TENKOROADRESULTDAY35 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOROADRESULT5'] == "-") {
    $TENKOROADRESULTDAY35 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOROADRESULT6'] == "1") {
    $TENKOROADRESULTDAY36 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOROADRESULT6'] == "0") {
    $TENKOROADRESULTDAY36 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOROADRESULT6'] == "x") {
    $TENKOROADRESULTDAY36 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOROADRESULT6'] == "-") {
    $TENKOROADRESULTDAY36 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOAIRRESULT0'] == "1") {
    $TENKOAIRRESULTDAY30 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOAIRRESULT0'] == "0") {
    $TENKOAIRRESULTDAY30 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOAIRRESULT0'] == "x") {
    $TENKOAIRRESULTDAY30 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOAIRRESULT0'] == "-") {
    $TENKOAIRRESULTDAY30 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOAIRRESULT1'] == "1") {
    $TENKOAIRRESULTDAY31 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOAIRRESULT1'] == "0") {
    $TENKOAIRRESULTDAY31 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOAIRRESULT1'] == "x") {
    $TENKOAIRRESULTDAY31 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOAIRRESULT1'] == "-") {
    $TENKOAIRRESULTDAY31 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOAIRRESULT2'] == "1") {
    $TENKOAIRRESULTDAY32 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOAIRRESULT2'] == "0") {
    $TENKOAIRRESULTDAY32 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOAIRRESULT2'] == "x") {
    $TENKOAIRRESULTDAY32 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOAIRRESULT2'] == "-") {
    $TENKOAIRRESULTDAY32 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOAIRRESULT3'] == "1") {
    $TENKOAIRRESULTDAY33 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOAIRRESULT3'] == "0") {
    $TENKOAIRRESULTDAY33 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOAIRRESULT3'] == "x") {
    $TENKOAIRRESULTDAY33 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOAIRRESULT3'] == "-") {
    $TENKOAIRRESULTDAY33 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOAIRRESULT4'] == "1") {
    $TENKOAIRRESULTDAY34 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOAIRRESULT4'] == "0") {
    $TENKOAIRRESULTDAY34 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOAIRRESULT4'] == "x") {
    $TENKOAIRRESULTDAY34 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOAIRRESULT4'] == "-") {
    $TENKOAIRRESULTDAY34 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOAIRRESULT5'] == "1") {
    $TENKOAIRRESULTDAY35 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOAIRRESULT5'] == "0") {
    $TENKOAIRRESULTDAY35 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOAIRRESULT5'] == "x") {
    $TENKOAIRRESULTDAY35 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOAIRRESULT5'] == "-") {
    $TENKOAIRRESULTDAY35 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOAIRRESULT6'] == "1") {
    $TENKOAIRRESULTDAY36 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOAIRRESULT6'] == "0") {
    $TENKOAIRRESULTDAY36 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOAIRRESULT6'] == "x") {
    $TENKOAIRRESULTDAY36 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOAIRRESULT6'] == "-") {
    $TENKOAIRRESULTDAY36 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOSLEEPYRESULT0'] == "1") {
    $TENKOSLEEPYRESULTDAY30 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOSLEEPYRESULT0'] == "0") {
    $TENKOSLEEPYRESULTDAY30 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOSLEEPYRESULT0'] == "x") {
    $TENKOSLEEPYRESULTDAY30 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOSLEEPYRESULT0'] == "-") {
    $TENKOSLEEPYRESULTDAY30 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOSLEEPYRESULT1'] == "1") {
    $TENKOSLEEPYRESULTDAY31 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOSLEEPYRESULT1'] == "0") {
    $TENKOSLEEPYRESULTDAY31 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOSLEEPYRESULT1'] == "x") {
    $TENKOSLEEPYRESULTDAY31 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOSLEEPYRESULT1'] == "-") {
    $TENKOSLEEPYRESULTDAY31 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOSLEEPYRESULT2'] == "1") {
    $TENKOSLEEPYRESULTDAY32 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOSLEEPYRESULT2'] == "0") {
    $TENKOSLEEPYRESULTDAY32 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOSLEEPYRESULT2'] == "x") {
    $TENKOSLEEPYRESULTDAY32 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOSLEEPYRESULT2'] == "-") {
    $TENKOSLEEPYRESULTDAY32 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOSLEEPYRESULT3'] == "1") {
    $TENKOSLEEPYRESULTDAY33 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOSLEEPYRESULT3'] == "0") {
    $TENKOSLEEPYRESULTDAY33 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOSLEEPYRESULT3'] == "x") {
    $TENKOSLEEPYRESULTDAY33 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOSLEEPYRESULT3'] == "-") {
    $TENKOSLEEPYRESULTDAY33 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOSLEEPYRESULT4'] == "1") {
    $TENKOSLEEPYRESULTDAY34 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOSLEEPYRESULT4'] == "0") {
    $TENKOSLEEPYRESULTDAY34 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOSLEEPYRESULT4'] == "x") {
    $TENKOSLEEPYRESULTDAY34 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOSLEEPYRESULT4'] == "-") {
    $TENKOSLEEPYRESULTDAY34 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOSLEEPYRESULT5'] == "1") {
    $TENKOSLEEPYRESULTDAY35 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOSLEEPYRESULT5'] == "0") {
    $TENKOSLEEPYRESULTDAY35 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOSLEEPYRESULT5'] == "x") {
    $TENKOSLEEPYRESULTDAY35 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOSLEEPYRESULT5'] == "-") {
    $TENKOSLEEPYRESULTDAY35 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY3['TENKOSLEEPYRESULT6'] == "1") {
    $TENKOSLEEPYRESULTDAY36 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOSLEEPYRESULT6'] == "0") {
    $TENKOSLEEPYRESULTDAY36 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOSLEEPYRESULT6'] == "x") {
    $TENKOSLEEPYRESULTDAY36 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY3['TENKOSLEEPYRESULT6'] == "-") {
    $TENKOSLEEPYRESULTDAY36 = "<img src='../images/circle_3.png' width='2%'>";
}
$VAR_MODIFIEDBY3 = ($result_seTenkotransportDAY3["MODIFIEDBY"] == "") ? $result_seTenkotransportDAY3["CREATEBY"] : $result_seTenkotransportDAY3["MODIFIEDBY"];
$table_2DAY3 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>
    <tr style="border:1px solid #000;padding:4px;">
    <th colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"></th>
    <th colspan="1" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY3['TENKOTRANSPORTDATE'] . '</th>
      <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;">เท็งโกะระหว่างทาง</th>
        <th colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">ลายเซนเจ้าหน้าที่เท็งโกะ</th>
        <th colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $VAR_MODIFIEDBY3 . '</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="12" style="border-right:1px solid #000;padding:4px;text-align:left;">เจ้าหน้าที่โทรไปไม่พบสิ่งผิดปกติ : 0 | พนักงานขับรถโทรมาไม่พบสิ่งผิดปกติ : 1 | พบสิ่งผิดปกติ : x</li></th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th width="5%" rowspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">ข้อ</th>
        <th rowspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">หัวข้อ</th>
        <th rowspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">ช่องตรวจสอบ</th>
        <th rowspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">เกณฑ์การตัดสิน</th>
        <th rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">โทรช่วง 06:00 - 24:00</th>
        <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;">Night Call Check</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">รายละเอียดการแนะนำ</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 1</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 2</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 3</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 4</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 5</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 6</th>
        <th rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY3['TENKOTIME0'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY3['TENKOTIME1'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY3['TENKOTIME2'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY3['TENKOTIME3'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY3['TENKOTIME4'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY3['TENKOTIME5'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY3['TENKOTIME6'] . '</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
    </tr>
    </thead>
    <tbody>
    <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">1</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">เส้นทางที่กำหนด - จุดพัก</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTCHECKDAY3 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">เส้นทาง จุดพักที่กำหนด</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY30 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY30 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY30 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY30 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY30 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY30 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY30 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY3['TENKOLOADRESTREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">2</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจร่างกาย - อาการง่วง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYCHECKDAY3 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">วิธีการพูดคุยต้องร่าเริง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY31 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY31 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY31 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY31 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY31 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY31 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY31 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY3['TENKOBODYSLEEPYREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">3</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจรถใหม่ (เฉพาะหยุดจอด)</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWCHECKDAY3 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">มีการรายงานเกี่ยวกับรถใหม่ว่ามีสิ่งผิดปกติหรือไม่</td>
      <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY32 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY32 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY32 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY32 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY32 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY32 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY32 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY3['TENKOCARNEWREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">4</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจเทรลเลอร์</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERCHECKDAY3 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ระหว่างวิ่งงานไม่มีสิ่งผิดปกติ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY33 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY33 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY33 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY33 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY33 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY33 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY33 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY3['TENKOTRAILERREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">5</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสภาพถนน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADCHECKDAY3 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">รายงานสภาพถนน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY34 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY34 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY34 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY34 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY34 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY34 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY34 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY3['TENKOROADREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">6</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบสภาพอากาศ (ใช้ที่ปัดน้ำฝนระดับ 3 ให้หยุดรถ)</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRCHECKDAY3 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">รายงานสภาพอากาศ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY35 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY35 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY35 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY35 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY35 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY35 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY35 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY3['TENKOAIRREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">7</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบอาการง่วงและย้ำให้ระมัดระวัง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYCHECKDAY3 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สภาพที่สามารถวิ่งงานต่อได้</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY36 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY36 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY36 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY36 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY36 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY36 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY36 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY3['TENKOSLEEPYREMARK'] . '</td>
      </tr>
    </tbody></table>

';


$table_headerDAY4 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>
    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkobefor['TENKOBEFOREDATE'] . '</th>
        <th colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">เอกสารเท็งโกะ</th>
        <th colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">Issue date 23 Jan 2017<br>          Toyota Transport (Thailand) Co.,LTD.</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th width="10%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">เปลี่ยนกะ</th>
        <th width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">กลางวัน</th>
        <th width="10%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ไม่เปลี่ยนกะ</th>
        <th width="5%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">บริษัท</th>
        <th width="15%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkobefor['Company_NameT'] . '</th>
        <th width="5%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ชื่อพขร.</th>
        <th width="15%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seDir['nameT'] . '</th>
        <th width="10%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">หมายเลขรถ</th>
        <th width="20%" colspan="3" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkobefor['TENKOMASTERVEHICLE'] . '</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">กลางคืน</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="5" style="border-right:1px solid #000;padding:4px;text-align:left;">รายละเอียดงาน (เท็งโกะก่อนเริ่มงาน ข้อ 12.)</th>
        <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:left;">เป้าหมายการวิ่งงานวันนี้ (เท็งโกะก่อนเริ่มงาน ข้อ 16.)</th>
    </tr>
   <tr style="border:1px solid #000;padding:4px;">
        <th colspan="5" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_sePlain['JOBSTART'] . '->' . $result_sePlain['JOBEND'] . '</th>
        <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:left;"> </th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="5" height="100" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkomaster['TENKOMASTERREMARKBEFORE'] . '</th>
        <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $TENKOTARGET1 . '<br>' . $TENKOTARGET2 . '<br>' . $TENKOTARGET3 . '<br>' . $TENKOTARGET4 . '<br>' . $TENKOTARGET5 . '<br>' . $TENKOTARGET6 . '<br>' . $TENKOTARGET7 . '</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>';
$table_1DAY4 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>
    <tr style="border:1px solid #000;padding:4px;">
     <th style="border-right:1px solid #000;padding:4px;text-align:center;">เวลา<br />ทำเท็งโกะ</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOBEFOREDATE'] . '</th>
      <th colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">เท็งโกะก่อนเริ่มงาน</th>
        <th width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">ลายเซ็น<br />เจ้าหน้าที่<br />เท็งโกะ</th>
        <th width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREBY1 . '</th>
        <th  width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">ลายเซ็น พขร.</th>
        <th  width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seDir['nameT'] . '</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th width="5%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ข้อ</th>
        <th width="25%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">หัวข้อ</th>
        <th width="10%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ช่องตรวจสอบ</th>
        <th width="20%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</th>
        <th width="20%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">เกณฑ์การตัดสิน</th>
        <th colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th  colspan="2" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">รายละเอียดและการแนะนำ</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ปกติ</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผิดปกติ</th>
    </tr>
    </thead>
    <tbody>
    <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">1</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">การทักทายก่อนเริ่มเท็งโกะ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREGREETCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ทักทายอย่างมีชีวิตชีวา</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREGREETRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREGREETRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOBEFOREGREETREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">2</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจเช็คยูนิฟอร์ม</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOUNIFORMCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">สวมชุดที่สอาด ไม่ใส่เครื่องประดับที่อาจทำให้เกิดรอย</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOUNIFORMRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOUNIFORMRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOUNIFORMREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">3</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบสภาพร่างกาย</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">สภาพร่างกายแข็งแรงดี</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOBODYREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">4</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบระยะการพักผ่อน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKORESTCHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตั้งแต่ 8 ชั่วโมง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKORESTDATA'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKORESTRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKORESTRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKORESTREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">5</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบชั่วโมงการนอนหลับ</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPTIMECHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;"><strong>การนอนปกติ</strong><br>
        ตั้งแต่ 6 ชั่วโมงขั้นไป</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOSLEEPTIMEDATA_AFTER6H'] . '</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPTIMERESULT1 . '</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPTIMERESULT0 . '</td>
        <td colspan="2" rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOSLEEPTIMEREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;"><strong>การนอนเพิ่ม</strong> (กะกลางคืน)<br>
        ตั้งแต่ 4.5 ชั่วโมงขึ้นไป</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">(___' . $result_seTenkobefor['TENKOSLEEPTIMEDATA_ADD45H'] . '___ชม.)</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">6</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจเช็คอุณหภูมิ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTEMPERATURECHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ต่ำกว่า 37 องศา</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOTEMPERATUREDATA'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTEMPERATURERESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTEMPERATURERESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOTEMPERATUREREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">7</td>
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">วัดความดัน</td>
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOPRESSURECHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">บน : 90-160</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $SYS . '</td>
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOPRESSURERESULT1 . '</td>
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOPRESSURERESULT0 . '</td>
        <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOPRESSUREREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ล่าง : 60-100</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $DIA . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">อัตราการเต้นหัวใจ : 60-100 ครั้ง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $HEARTRATE . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">8</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ครวจเช็คแอลกอฮอล์</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOALCOHOLCHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">[0]</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOALCOHOLDATA'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOALCOHOLRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOALCOHOLRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOALCOHOLREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">9</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สอบถามเรื่องกังวลใจ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOWORRYCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ไม่มีเรื่องกังวลใจ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOWORRYRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOWORRYRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOWORRYREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">10</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ใบตรวจเทรลเลอร์ประจำวัน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKODAILYTRAILERCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ไม่มีหัวข้อผิดปกติ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKODAILYTRAILERRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKODAILYTRAILERRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKODAILYTRAILERREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">11</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบของที่พกพา</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARRYCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ใบอนุญาติขับขี่,ใบอนุญาติ (ผู้รับเหมา),ใบอนุญาติ (โฟล์คลิฟท์),ใบอนุญาติ (TLEP),ใบอนุญาติ (Trailer),โทรศัพท์,สายสมอลทอร์ค</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARRYRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARRYRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOCARRYREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">12</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบรายละเอียดการทำงาน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOJOBDETAILCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">เข้าใจเส้นทาง,จุดพักรถ,รูปแบบการขับขี่,ความสำคัญในการส่งรถ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOJOBDETAILRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOJOBDETAILRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOJOBDETAILREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">13</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">แจ้งสภาพถนน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADINFORMCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">เข้าใจเนื้อหาที่แจ้ง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADINFORMRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADINFORMRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOLOADINFORMREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">14</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">แจ้งสภาพอากาศ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRINFORMCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">เข้าใจเนื้อหาที่แจ้ง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRINFORMRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRINFORMRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOAIRINFORMREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">15</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">แจ้งเรื่องโยโกะเต็น</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOYOKOTENCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">เข้าใจเนื้อหาที่แจ้ง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOYOKOTENRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOYOKOTENRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOYOKOTENREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">16</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบเป้าหมายการขับขี่จากเครื่องมูเลเตอร์</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCHIMOLATORCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบกันทั้งสองฝ่าย</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCHIMOLATORRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCHIMOLATORRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOCHIMOLATORREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">17</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สามารถวิ่งงานได้ปกติหรือไม่</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRANSPORTCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ไม่มีข้อบกพร่องต่อการวิ่งงาน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRANSPORTRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRANSPORTRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOTRANSPORTREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">18</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">การทักทายหลังทำเท็งโกะเสร็จ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAFTERGREETCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ทักทายอย่างมีชีวิตชีวา</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAFTERGREETRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAFTERGREETRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOAFTERGREETREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">***</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจเช็คออกซิเจนเลือด</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOOXYGENCHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOOXYGENDATA'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOOXYGENRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOOXYGENRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOOXYGENREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td colspan="9" style="border-right:1px solid #000;padding:4px;text-align:center;">ตรวจเช็คปัญหาสุขภาพสายตา3</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">1</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สายตาสั้น</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORESHORTSIGHTCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">พนักงานพกแว่นสายตามาปฏิบัติงาน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORESHORTSIGHTRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORESHORTSIGHTRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOSHORTSIGHTREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">2</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สายตายาว</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORELONGSIGHTCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">พนักงานพกแว่นสายตามาปฏิบัติงาน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORELONGSIGHTRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORELONGSIGHTRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOLONGSIGHTREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">3</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สายตาเอียง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREOBLIQUESIGHTCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">พนักงานพกแว่นสายตามาปฏิบัติงาน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREOBLIQUESIGHTRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREOBLIQUESIGHTRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOOBLIQUESIGHTREMARK'] . '</td>
      </tr>
    </tbody></table>
';

$condTenkotransportDAY41 = " AND TENKOMASTERID = '" . $_GET['tenkomasterid'] . "' AND TENKOMASTERDIRVERCODE = '" . $_GET['employeecode'] . "'";
$condTenkotransportDAY42 = " AND CONVERT(DATE,TENKOTRANSPORTDATE) = CONVERT(DATE,'" . $result_seTenkomaster['DATEINPUT_F4'] . "',103)";
$sql_seTenkotransportDAY4 = "{call megEdittenkotransport_v2(?,?,?,?,?)}";
$params_seTenkotransportDAY4 = array(
    array('select_tenkotransport', SQLSRV_PARAM_IN),
    array($condTenkotransportDAY41, SQLSRV_PARAM_IN),
    array($condTenkotransportDAY42, SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seTenkotransportDAY4 = sqlsrv_query($conn, $sql_seTenkotransportDAY4, $params_seTenkotransportDAY4);
$result_seTenkotransportDAY4 = sqlsrv_fetch_array($query_seTenkotransportDAY4, SQLSRV_FETCH_ASSOC);

$conditionEHR4 = " AND a.PersonCode ='" . $result_seTenkotransportDAY4['MODIFIEDBY'] . "'";
$sql_seEHR4 = "{call megEmployeeEHR_v2(?,?)}";
$params_seEHR4 = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array($conditionEHR4, SQLSRV_PARAM_IN)
);
$query_seEHR4 = sqlsrv_query($conn, $sql_seEHR4, $params_seEHR4);
$result_seEHR4 = sqlsrv_fetch_array($query_seEHR4, SQLSRV_FETCH_ASSOC);

$TENKOLOADRESTCHECKDAY4 = ($result_seTenkotransportDAY4['TENKOLOADRESTCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOBODYSLEEPYCHECKDAY4 = ($result_seTenkotransportDAY4['TENKOBODYSLEEPYCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOCARNEWCHECKDAY4 = ($result_seTenkotransportDAY4['TENKOCARNEWCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOTRAILERCHECKDAY4 = ($result_seTenkotransportDAY4['TENKOTRAILERCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOROADCHECKDAY4 = ($result_seTenkotransportDAY4['TENKOROADCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOAIRCHECKDAY4 = ($result_seTenkotransportDAY4['TENKOAIRCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOSLEEPYCHECKDAY4 = ($result_seTenkotransportDAY4['TENKOSLEEPYCHECK'] == "1" || $result_seTenkotransportDAY4['TENKOSLEEPYCHECK'] == "0x") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";


if ($result_seTenkotransportDAY4['TENKOLOADRESTRESULT0'] == "1") {
    $TENKOLOADRESTRESULTDAY40 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOLOADRESTRESULT0'] == "0") {
    $TENKOLOADRESTRESULTDAY40 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOLOADRESTRESULT0'] == "x") {
    $TENKOLOADRESTRESULTDAY40 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOLOADRESTRESULT0'] == "-") {
    $TENKOLOADRESTRESULTDAY40 = "<img src='../images/circle_3.png' width='2%'>";
}



if ($result_seTenkotransportDAY4['TENKOLOADRESTRESULT1'] == "1") {
    $TENKOLOADRESTRESULTDAY41 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOLOADRESTRESULT1'] == "0") {
    $TENKOLOADRESTRESULTDAY41 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOLOADRESTRESULT1'] == "x") {
    $TENKOLOADRESTRESULTDAY41 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOLOADRESTRESULT1'] == "-") {
    $TENKOLOADRESTRESULTDAY41 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOLOADRESTRESULT2'] == "1") {
    $TENKOLOADRESTRESULTDAY42 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOLOADRESTRESULT2'] == "0") {
    $TENKOLOADRESTRESULTDAY42 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOLOADRESTRESULT2'] == "x") {
    $TENKOLOADRESTRESULTDAY42 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOLOADRESTRESULT2'] == "-") {
    $TENKOLOADRESTRESULTDAY42 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOLOADRESTRESULT3'] == "1") {
    $TENKOLOADRESTRESULTDAY43 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOLOADRESTRESULT3'] == "0") {
    $TENKOLOADRESTRESULTDAY43 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOLOADRESTRESULT3'] == "x") {
    $TENKOLOADRESTRESULTDAY43 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOLOADRESTRESULT3'] == "-") {
    $TENKOLOADRESTRESULTDAY43 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOLOADRESTRESULT4'] == "1") {
    $TENKOLOADRESTRESULTDAY44 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOLOADRESTRESULT4'] == "0") {
    $TENKOLOADRESTRESULTDAY44 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOLOADRESTRESULT4'] == "x") {
    $TENKOLOADRESTRESULTDAY44 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOLOADRESTRESULT4'] == "-") {
    $TENKOLOADRESTRESULTDAY44 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOLOADRESTRESULT5'] == "1") {
    $TENKOLOADRESTRESULTDAY45 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOLOADRESTRESULT5'] == "0") {
    $TENKOLOADRESTRESULTDAY45 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOLOADRESTRESULT5'] == "x") {
    $TENKOLOADRESTRESULTDAY45 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOLOADRESTRESULT5'] == "-") {
    $TENKOLOADRESTRESULTDAY45 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOLOADRESTRESULT6'] == "1") {
    $TENKOLOADRESTRESULTDAY46 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOLOADRESTRESULT6'] == "0") {
    $TENKOLOADRESTRESULTDAY46 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOLOADRESTRESULT6'] == "x") {
    $TENKOLOADRESTRESULTDAY46 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOLOADRESTRESULT6'] == "-") {
    $TENKOLOADRESTRESULTDAY46 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOBODYSLEEPYRESULT0'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY40 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOBODYSLEEPYRESULT0'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY40 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOBODYSLEEPYRESULT0'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY40 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOBODYSLEEPYRESULT0'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY40 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOBODYSLEEPYRESULT1'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY41 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOBODYSLEEPYRESULT1'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY41 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOBODYSLEEPYRESULT1'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY41 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOBODYSLEEPYRESULT1'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY41 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOBODYSLEEPYRESULT2'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY42 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOBODYSLEEPYRESULT2'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY42 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOBODYSLEEPYRESULT2'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY42 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOBODYSLEEPYRESULT2'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY42 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOBODYSLEEPYRESULT3'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY43 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOBODYSLEEPYRESULT3'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY43 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOBODYSLEEPYRESULT3'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY43 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOBODYSLEEPYRESULT3'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY43 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOBODYSLEEPYRESULT4'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY44 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOBODYSLEEPYRESULT4'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY44 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOBODYSLEEPYRESULT4'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY44 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOBODYSLEEPYRESULT4'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY44 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOBODYSLEEPYRESULT5'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY45 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOBODYSLEEPYRESULT5'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY45 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOBODYSLEEPYRESULT5'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY45 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOBODYSLEEPYRESULT5'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY45 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOBODYSLEEPYRESULT6'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY46 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOBODYSLEEPYRESULT6'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY46 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOBODYSLEEPYRESULT6'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY46 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOBODYSLEEPYRESULT6'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY46 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOCARNEWRESULT0'] == "1") {
    $TENKOCARNEWRESULTDAY40 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOCARNEWRESULT0'] == "0") {
    $TENKOCARNEWRESULTDAY40 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOCARNEWRESULT0'] == "x") {
    $TENKOCARNEWRESULTDAY40 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOCARNEWRESULT0'] == "-") {
    $TENKOCARNEWRESULTDAY40 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOCARNEWRESULT1'] == "1") {
    $TENKOCARNEWRESULTDAY41 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOCARNEWRESULT1'] == "0") {
    $TENKOCARNEWRESULTDAY41 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOCARNEWRESULT1'] == "x") {
    $TENKOCARNEWRESULTDAY41 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOCARNEWRESULT1'] == "-") {
    $TENKOCARNEWRESULTDAY41 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOCARNEWRESULT2'] == "1") {
    $TENKOCARNEWRESULTDAY42 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOCARNEWRESULT2'] == "0") {
    $TENKOCARNEWRESULTDAY42 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOCARNEWRESULT2'] == "x") {
    $TENKOCARNEWRESULTDAY42 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOCARNEWRESULT2'] == "-") {
    $TENKOCARNEWRESULTDAY42 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOCARNEWRESULT3'] == "1") {
    $TENKOCARNEWRESULTDAY43 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOCARNEWRESULT3'] == "0") {
    $TENKOCARNEWRESULTDAY43 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOCARNEWRESULT3'] == "x") {
    $TENKOCARNEWRESULTDAY43 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOCARNEWRESULT3'] == "-") {
    $TENKOCARNEWRESULTDAY43 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOCARNEWRESULT4'] == "1") {
    $TENKOCARNEWRESULTDAY44 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOCARNEWRESULT4'] == "0") {
    $TENKOCARNEWRESULTDAY44 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOCARNEWRESULT4'] == "x") {
    $TENKOCARNEWRESULTDAY44 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOCARNEWRESULT4'] == "-") {
    $TENKOCARNEWRESULTDAY44 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOCARNEWRESULT5'] == "1") {
    $TENKOCARNEWRESULTDAY45 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOCARNEWRESULT5'] == "0") {
    $TENKOCARNEWRESULTDAY45 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOCARNEWRESULT5'] == "x") {
    $TENKOCARNEWRESULTDAY45 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOCARNEWRESULT5'] == "-") {
    $TENKOCARNEWRESULTDAY45 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOCARNEWRESULT6'] == "1") {
    $TENKOCARNEWRESULTDAY46 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOCARNEWRESULT6'] == "0") {
    $TENKOCARNEWRESULTDAY46 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOCARNEWRESULT6'] == "x") {
    $TENKOCARNEWRESULTDAY46 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOCARNEWRESULT6'] == "-") {
    $TENKOCARNEWRESULTDAY46 = "<img src='../images/circle_3.png' width='2%'>";
}
if ($result_seTenkotransportDAY4['TENKOTRAILERRESULT0'] == "1") {
    $TENKOTRAILERRESULTDAY40 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOTRAILERRESULT0'] == "0") {
    $TENKOTRAILERRESULTDAY40 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOTRAILERRESULT0'] == "x") {
    $TENKOTRAILERRESULTDAY40 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOTRAILERRESULT0'] == "-") {
    $TENKOTRAILERRESULTDAY40 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOTRAILERRESULT1'] == "1") {
    $TENKOTRAILERRESULTDAY41 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOTRAILERRESULT1'] == "0") {
    $TENKOTRAILERRESULTDAY41 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOTRAILERRESULT1'] == "x") {
    $TENKOTRAILERRESULTDAY41 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOTRAILERRESULT1'] == "-") {
    $TENKOTRAILERRESULTDAY41 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOTRAILERRESULT2'] == "1") {
    $TENKOTRAILERRESULTDAY42 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOTRAILERRESULT2'] == "0") {
    $TENKOTRAILERRESULTDAY42 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOTRAILERRESULT2'] == "x") {
    $TENKOTRAILERRESULTDAY42 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOTRAILERRESULT2'] == "-") {
    $TENKOTRAILERRESULTDAY42 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOTRAILERRESULT3'] == "1") {
    $TENKOTRAILERRESULTDAY43 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOTRAILERRESULT3'] == "0") {
    $TENKOTRAILERRESULTDAY43 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOTRAILERRESULT3'] == "x") {
    $TENKOTRAILERRESULTDAY43 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOTRAILERRESULT3'] == "-") {
    $TENKOTRAILERRESULTDAY43 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOTRAILERRESULT4'] == "1") {
    $TENKOTRAILERRESULTDAY44 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOTRAILERRESULT4'] == "0") {
    $TENKOTRAILERRESULTDAY44 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOTRAILERRESULT4'] == "x") {
    $TENKOTRAILERRESULTDAY44 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOTRAILERRESULT4'] == "-") {
    $TENKOTRAILERRESULTDAY44 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOTRAILERRESULT5'] == "1") {
    $TENKOTRAILERRESULTDAY45 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOTRAILERRESULT5'] == "0") {
    $TENKOTRAILERRESULTDAY45 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOTRAILERRESULT5'] == "x") {
    $TENKOTRAILERRESULTDAY45 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOTRAILERRESULT5'] == "-") {
    $TENKOTRAILERRESULTDAY45 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOTRAILERRESULT6'] == "1") {
    $TENKOTRAILERRESULTDAY46 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOTRAILERRESULT6'] == "0") {
    $TENKOTRAILERRESULTDAY46 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOTRAILERRESULT6'] == "x") {
    $TENKOTRAILERRESULTDAY46 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOTRAILERRESULT6'] == "-") {
    $TENKOTRAILERRESULTDAY46 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOROADRESULT0'] == "1") {
    $TENKOROADRESULTDAY40 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOROADRESULT0'] == "0") {
    $TENKOROADRESULTDAY40 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOROADRESULT0'] == "x") {
    $TENKOROADRESULTDAY40 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOROADRESULT0'] == "-") {
    $TENKOROADRESULTDAY40 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOROADRESULT1'] == "1") {
    $TENKOROADRESULTDAY41 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOROADRESULT1'] == "0") {
    $TENKOROADRESULTDAY41 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOROADRESULT1'] == "x") {
    $TENKOROADRESULTDAY41 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOROADRESULT1'] == "-") {
    $TENKOROADRESULTDAY41 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOROADRESULT2'] == "1") {
    $TENKOROADRESULTDAY42 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOROADRESULT2'] == "0") {
    $TENKOROADRESULTDAY42 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOROADRESULT2'] == "x") {
    $TENKOROADRESULTDAY42 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOROADRESULT2'] == "-") {
    $TENKOROADRESULTDAY42 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOROADRESULT3'] == "1") {
    $TENKOROADRESULTDAY43 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOROADRESULT3'] == "0") {
    $TENKOROADRESULTDAY43 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOROADRESULT3'] == "x") {
    $TENKOROADRESULTDAY43 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOROADRESULT3'] == "-") {
    $TENKOROADRESULTDAY43 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOROADRESULT4'] == "1") {
    $TENKOROADRESULTDAY44 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOROADRESULT4'] == "0") {
    $TENKOROADRESULTDAY44 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOROADRESULT4'] == "x") {
    $TENKOROADRESULTDAY44 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOROADRESULT4'] == "-") {
    $TENKOROADRESULTDAY44 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOROADRESULT5'] == "1") {
    $TENKOROADRESULTDAY45 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOROADRESULT5'] == "0") {
    $TENKOROADRESULTDAY45 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOROADRESULT5'] == "x") {
    $TENKOROADRESULTDAY45 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOROADRESULT5'] == "-") {
    $TENKOROADRESULTDAY45 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOROADRESULT6'] == "1") {
    $TENKOROADRESULTDAY46 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOROADRESULT6'] == "0") {
    $TENKOROADRESULTDAY46 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOROADRESULT6'] == "x") {
    $TENKOROADRESULTDAY46 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOROADRESULT6'] == "-") {
    $TENKOROADRESULTDAY46 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOAIRRESULT0'] == "1") {
    $TENKOAIRRESULTDAY40 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOAIRRESULT0'] == "0") {
    $TENKOAIRRESULTDAY40 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOAIRRESULT0'] == "x") {
    $TENKOAIRRESULTDAY40 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOAIRRESULT0'] == "-") {
    $TENKOAIRRESULTDAY40 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOAIRRESULT1'] == "1") {
    $TENKOAIRRESULTDAY41 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOAIRRESULT1'] == "0") {
    $TENKOAIRRESULTDAY41 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOAIRRESULT1'] == "x") {
    $TENKOAIRRESULTDAY41 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOAIRRESULT1'] == "-") {
    $TENKOAIRRESULTDAY41 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOAIRRESULT2'] == "1") {
    $TENKOAIRRESULTDAY42 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOAIRRESULT2'] == "0") {
    $TENKOAIRRESULTDAY42 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOAIRRESULT2'] == "x") {
    $TENKOAIRRESULTDAY42 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOAIRRESULT2'] == "-") {
    $TENKOAIRRESULTDAY42 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOAIRRESULT3'] == "1") {
    $TENKOAIRRESULTDAY43 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOAIRRESULT3'] == "0") {
    $TENKOAIRRESULTDAY43 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOAIRRESULT3'] == "x") {
    $TENKOAIRRESULTDAY43 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOAIRRESULT3'] == "-") {
    $TENKOAIRRESULTDAY43 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOAIRRESULT4'] == "1") {
    $TENKOAIRRESULTDAY44 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOAIRRESULT4'] == "0") {
    $TENKOAIRRESULTDAY44 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOAIRRESULT4'] == "x") {
    $TENKOAIRRESULTDAY44 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOAIRRESULT4'] == "-") {
    $TENKOAIRRESULTDAY44 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOAIRRESULT5'] == "1") {
    $TENKOAIRRESULTDAY45 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOAIRRESULT5'] == "0") {
    $TENKOAIRRESULTDAY45 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOAIRRESULT5'] == "x") {
    $TENKOAIRRESULTDAY45 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOAIRRESULT5'] == "-") {
    $TENKOAIRRESULTDAY45 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOAIRRESULT6'] == "1") {
    $TENKOAIRRESULTDAY46 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOAIRRESULT6'] == "0") {
    $TENKOAIRRESULTDAY46 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOAIRRESULT6'] == "x") {
    $TENKOAIRRESULTDAY46 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOAIRRESULT6'] == "-") {
    $TENKOAIRRESULTDAY46 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOSLEEPYRESULT0'] == "1") {
    $TENKOSLEEPYRESULTDAY40 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOSLEEPYRESULT0'] == "0") {
    $TENKOSLEEPYRESULTDAY40 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOSLEEPYRESULT0'] == "x") {
    $TENKOSLEEPYRESULTDAY40 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOSLEEPYRESULT0'] == "-") {
    $TENKOSLEEPYRESULTDAY40 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOSLEEPYRESULT1'] == "1") {
    $TENKOSLEEPYRESULTDAY41 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOSLEEPYRESULT1'] == "0") {
    $TENKOSLEEPYRESULTDAY41 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOSLEEPYRESULT1'] == "x") {
    $TENKOSLEEPYRESULTDAY41 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOSLEEPYRESULT1'] == "-") {
    $TENKOSLEEPYRESULTDAY41 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOSLEEPYRESULT2'] == "1") {
    $TENKOSLEEPYRESULTDAY42 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOSLEEPYRESULT2'] == "0") {
    $TENKOSLEEPYRESULTDAY42 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOSLEEPYRESULT2'] == "x") {
    $TENKOSLEEPYRESULTDAY42 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOSLEEPYRESULT2'] == "-") {
    $TENKOSLEEPYRESULTDAY42 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOSLEEPYRESULT3'] == "1") {
    $TENKOSLEEPYRESULTDAY43 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOSLEEPYRESULT3'] == "0") {
    $TENKOSLEEPYRESULTDAY43 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOSLEEPYRESULT3'] == "x") {
    $TENKOSLEEPYRESULTDAY43 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOSLEEPYRESULT3'] == "-") {
    $TENKOSLEEPYRESULTDAY43 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOSLEEPYRESULT4'] == "1") {
    $TENKOSLEEPYRESULTDAY44 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOSLEEPYRESULT4'] == "0") {
    $TENKOSLEEPYRESULTDAY44 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOSLEEPYRESULT4'] == "x") {
    $TENKOSLEEPYRESULTDAY44 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOSLEEPYRESULT4'] == "-") {
    $TENKOSLEEPYRESULTDAY44 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOSLEEPYRESULT5'] == "1") {
    $TENKOSLEEPYRESULTDAY45 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOSLEEPYRESULT5'] == "0") {
    $TENKOSLEEPYRESULTDAY45 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOSLEEPYRESULT5'] == "x") {
    $TENKOSLEEPYRESULTDAY45 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOSLEEPYRESULT5'] == "-") {
    $TENKOSLEEPYRESULTDAY45 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY4['TENKOSLEEPYRESULT6'] == "1") {
    $TENKOSLEEPYRESULTDAY46 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOSLEEPYRESULT6'] == "0") {
    $TENKOSLEEPYRESULTDAY46 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOSLEEPYRESULT6'] == "x") {
    $TENKOSLEEPYRESULTDAY46 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY4['TENKOSLEEPYRESULT6'] == "-") {
    $TENKOSLEEPYRESULTDAY46 = "<img src='../images/circle_3.png' width='2%'>";
}
$VAR_MODIFIEDBY4 = ($result_seTenkotransportDAY4["MODIFIEDBY"] == "") ? $result_seTenkotransportDAY4["CREATEBY"] : $result_seTenkotransportDAY4["MODIFIEDBY"];
$table_2DAY4 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>
    <tr style="border:1px solid #000;padding:4px;">
    <th colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"></th>
    <th colspan="1" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY4['TENKOTRANSPORTDATE'] . '</th>
      <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;">เท็งโกะระหว่างทาง</th>
        <th colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">ลายเซนเจ้าหน้าที่เท็งโกะ</th>
        <th colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $VAR_MODIFIEDBY4 . '</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="12" style="border-right:1px solid #000;padding:4px;text-align:left;">เจ้าหน้าที่โทรไปไม่พบสิ่งผิดปกติ : 0 | พนักงานขับรถโทรมาไม่พบสิ่งผิดปกติ : 1 | พบสิ่งผิดปกติ : x</li></th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th width="5%" rowspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">ข้อ</th>
        <th rowspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">หัวข้อ</th>
        <th rowspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">ช่องตรวจสอบ</th>
        <th rowspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">เกณฑ์การตัดสิน</th>
        <th rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">โทรช่วง 06:00 - 24:00</th>
        <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;">Night Call Check</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">รายละเอียดการแนะนำ</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 1</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 2</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 3</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 4</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 5</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 6</th>
        <th rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY4['TENKOTIME0'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY4['TENKOTIME1'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY4['TENKOTIME2'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY4['TENKOTIME3'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY4['TENKOTIME4'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY4['TENKOTIME5'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY4['TENKOTIME6'] . '</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
    </tr>
    </thead>
    <tbody>
    <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">1</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">เส้นทางที่กำหนด - จุดพัก</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTCHECKDAY4 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">เส้นทาง จุดพักที่กำหนด</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY40 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY40 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY40 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY40 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY40 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY40 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY40 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY4['TENKOLOADRESTREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">2</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจร่างกาย - อาการง่วง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYCHECKDAY4 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">วิธีการพูดคุยต้องร่าเริง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY41 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY41 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY41 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY41 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY41 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY41 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY41 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY4['TENKOBODYSLEEPYREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">3</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจรถใหม่ (เฉพาะหยุดจอด)</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWCHECKDAY4 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">มีการรายงานเกี่ยวกับรถใหม่ว่ามีสิ่งผิดปกติหรือไม่</td>
      <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY42 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY42 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY42 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY42 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY42 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY42 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY42 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY4['TENKOCARNEWREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">4</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจเทรลเลอร์</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERCHECKDAY4 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ระหว่างวิ่งงานไม่มีสิ่งผิดปกติ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY43 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY43 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY43 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY43 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY43 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY43 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY43 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY4['TENKOTRAILERREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">5</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสภาพถนน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADCHECKDAY4 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">รายงานสภาพถนน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY44 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY44 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY44 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY44 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY44 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY44 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY44 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY4['TENKOROADREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">6</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบสภาพอากาศ (ใช้ที่ปัดน้ำฝนระดับ 3 ให้หยุดรถ)</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRCHECKDAY4 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">รายงานสภาพอากาศ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY45 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY45 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY45 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY45 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY45 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY45 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY45 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY4['TENKOAIRREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">7</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบอาการง่วงและย้ำให้ระมัดระวัง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYCHECKDAY4 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สภาพที่สามารถวิ่งงานต่อได้</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY46 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY46 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY46 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY46 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY46 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY46 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY46 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY4['TENKOSLEEPYREMARK'] . '</td>
      </tr>
    </tbody></table>

';

$table_headerDAY5 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>
    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkobefor['TENKOBEFOREDATE'] . '</th>
        <th colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">เอกสารเท็งโกะ</th>
        <th colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">Issue date 23 Jan 2017<br>          Toyota Transport (Thailand) Co.,LTD.</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th width="10%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">เปลี่ยนกะ</th>
        <th width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">กลางวัน</th>
        <th width="10%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ไม่เปลี่ยนกะ</th>
        <th width="5%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">บริษัท</th>
        <th width="15%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkobefor['Company_NameT'] . '</th>
        <th width="5%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ชื่อพขร.</th>
        <th width="15%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seDir['nameT'] . '</th>
        <th width="10%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">หมายเลขรถ</th>
        <th width="20%" colspan="3" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkobefor['TENKOMASTERVEHICLE'] . '</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">กลางคืน</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="5" style="border-right:1px solid #000;padding:4px;text-align:left;">รายละเอียดงาน (เท็งโกะก่อนเริ่มงาน ข้อ 12.)</th>
        <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:left;">เป้าหมายการวิ่งงานวันนี้ (เท็งโกะก่อนเริ่มงาน ข้อ 16.)</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="5" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_sePlain['JOBSTART'] . '->' . $result_sePlain['JOBEND'] . '</th>
        <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:left;"> </th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="5" height="100" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkomaster['TENKOMASTERREMARKBEFORE'] . '</th>
        <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $TENKOTARGET1 . '<br>' . $TENKOTARGET2 . '<br>' . $TENKOTARGET3 . '<br>' . $TENKOTARGET4 . '<br>' . $TENKOTARGET5 . '<br>' . $TENKOTARGET6 . '<br>' . $TENKOTARGET7 . '</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>';
$table_1DAY5 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>
    <tr style="border:1px solid #000;padding:4px;">
     <th style="border-right:1px solid #000;padding:4px;text-align:center;">เวลา<br />ทำเท็งโกะ</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOBEFOREDATE'] . '</th>
      <th colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">เท็งโกะก่อนเริ่มงาน</th>
        <th width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">ลายเซ็น<br />เจ้าหน้าที่<br />เท็งโกะ</th>
        <th width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREBY1 . '</th>
        <th  width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">ลายเซ็น พขร.</th>
        <th  width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seDir['nameT'] . '</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th width="5%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ข้อ</th>
        <th width="25%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">หัวข้อ</th>
        <th width="10%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ช่องตรวจสอบ</th>
        <th width="20%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</th>
        <th width="20%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">เกณฑ์การตัดสิน</th>
        <th colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th  colspan="2" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">รายละเอียดและการแนะนำ</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ปกติ</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผิดปกติ</th>
    </tr>
    </thead>
    <tbody>
    <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">1</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">การทักทายก่อนเริ่มเท็งโกะ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREGREETCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ทักทายอย่างมีชีวิตชีวา</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREGREETRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREGREETRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOBEFOREGREETREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">2</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจเช็คยูนิฟอร์ม</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOUNIFORMCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">สวมชุดที่สอาด ไม่ใส่เครื่องประดับที่อาจทำให้เกิดรอย</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOUNIFORMRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOUNIFORMRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOUNIFORMREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">3</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบสภาพร่างกาย</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">สภาพร่างกายแข็งแรงดี</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOBODYREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">4</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบระยะการพักผ่อน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKORESTCHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตั้งแต่ 8 ชั่วโมง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKORESTDATA'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKORESTRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKORESTRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKORESTREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">5</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบชั่วโมงการนอนหลับ</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPTIMECHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;"><strong>การนอนปกติ</strong><br>
        ตั้งแต่ 6 ชั่วโมงขั้นไป</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOSLEEPTIMEDATA_AFTER6H'] . '</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPTIMERESULT1 . '</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPTIMERESULT0 . '</td>
        <td colspan="2" rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOSLEEPTIMEREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;"><strong>การนอนเพิ่ม</strong> (กะกลางคืน)<br>
        ตั้งแต่ 4.5 ชั่วโมงขึ้นไป</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">(___' . $result_seTenkobefor['TENKOSLEEPTIMEDATA_ADD45H'] . '___ชม.)</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">6</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจเช็คอุณหภูมิ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTEMPERATURECHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ต่ำกว่า 37 องศา</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOTEMPERATUREDATA'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTEMPERATURERESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTEMPERATURERESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOTEMPERATUREREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">7</td>
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">วัดความดัน</td>
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOPRESSURECHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">บน : 90-160</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $SYS . '</td>
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOPRESSURERESULT1 . '</td>
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOPRESSURERESULT0 . '</td>
        <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOPRESSUREREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ล่าง : 60-100</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $DIA . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">อัตราการเต้นหัวใจ : 60-100 ครั้ง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $HEARTRATE . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">8</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ครวจเช็คแอลกอฮอล์</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOALCOHOLCHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">[0]</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOALCOHOLDATA'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOALCOHOLRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOALCOHOLRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOALCOHOLREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">9</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สอบถามเรื่องกังวลใจ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOWORRYCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ไม่มีเรื่องกังวลใจ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOWORRYRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOWORRYRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOWORRYREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">10</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ใบตรวจเทรลเลอร์ประจำวัน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKODAILYTRAILERCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ไม่มีหัวข้อผิดปกติ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKODAILYTRAILERRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKODAILYTRAILERRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKODAILYTRAILERREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">11</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบของที่พกพา</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARRYCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ใบอนุญาติขับขี่,ใบอนุญาติ (ผู้รับเหมา),ใบอนุญาติ (โฟล์คลิฟท์),ใบอนุญาติ (TLEP),ใบอนุญาติ (Trailer),โทรศัพท์,สายสมอลทอร์ค</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARRYRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARRYRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOCARRYREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">12</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบรายละเอียดการทำงาน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOJOBDETAILCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">เข้าใจเส้นทาง,จุดพักรถ,รูปแบบการขับขี่,ความสำคัญในการส่งรถ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOJOBDETAILRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOJOBDETAILRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOJOBDETAILREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">13</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">แจ้งสภาพถนน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADINFORMCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">เข้าใจเนื้อหาที่แจ้ง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADINFORMRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADINFORMRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOLOADINFORMREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">14</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">แจ้งสภาพอากาศ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRINFORMCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">เข้าใจเนื้อหาที่แจ้ง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRINFORMRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRINFORMRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOAIRINFORMREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">15</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">แจ้งเรื่องโยโกะเต็น</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOYOKOTENCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">เข้าใจเนื้อหาที่แจ้ง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOYOKOTENRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOYOKOTENRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOYOKOTENREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">16</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบเป้าหมายการขับขี่จากเครื่องมูเลเตอร์</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCHIMOLATORCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบกันทั้งสองฝ่าย</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCHIMOLATORRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCHIMOLATORRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOCHIMOLATORREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">17</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สามารถวิ่งงานได้ปกติหรือไม่</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRANSPORTCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ไม่มีข้อบกพร่องต่อการวิ่งงาน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRANSPORTRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRANSPORTRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOTRANSPORTREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">18</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">การทักทายหลังทำเท็งโกะเสร็จ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAFTERGREETCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ทักทายอย่างมีชีวิตชีวา</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAFTERGREETRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAFTERGREETRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOAFTERGREETREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">***</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจเช็คออกซิเจนเลือด</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOOXYGENCHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOOXYGENDATA'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOOXYGENRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOOXYGENRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOOXYGENREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td colspan="9" style="border-right:1px solid #000;padding:4px;text-align:center;">ตรวจเช็คปัญหาสุขภาพสายตา4</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">1</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สายตาสั้น</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORESHORTSIGHTCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">พนักงานพกแว่นสายตามาปฏิบัติงาน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORESHORTSIGHTRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORESHORTSIGHTRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOSHORTSIGHTREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">2</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สายตายาว</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORELONGSIGHTCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">พนักงานพกแว่นสายตามาปฏิบัติงาน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORELONGSIGHTRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFORELONGSIGHTRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOLONGSIGHTREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">3</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สายตาเอียง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREOBLIQUESIGHTCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">พนักงานพกแว่นสายตามาปฏิบัติงาน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREOBLIQUESIGHTRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREOBLIQUESIGHTRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOOBLIQUESIGHTREMARK'] . '</td>
      </tr>
    </tbody></table>
';

$condTenkotransportDAY51 = " AND TENKOMASTERID = '" . $_GET['tenkomasterid'] . "' AND TENKOMASTERDIRVERCODE = '" . $_GET['employeecode'] . "'";
$condTenkotransportDAY52 = " AND CONVERT(DATE,TENKOTRANSPORTDATE) = CONVERT(DATE,'" . $result_seTenkomaster['DATEINPUT_F5'] . "',103)";
$sql_seTenkotransportDAY5 = "{call megEdittenkotransport_v2(?,?,?,?,?)}";
$params_seTenkotransportDAY5 = array(
    array('select_tenkotransport', SQLSRV_PARAM_IN),
    array($condTenkotransportDAY51, SQLSRV_PARAM_IN),
    array($condTenkotransportDAY52, SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seTenkotransportDAY5 = sqlsrv_query($conn, $sql_seTenkotransportDAY5, $params_seTenkotransportDAY5);
$result_seTenkotransportDAY5 = sqlsrv_fetch_array($query_seTenkotransportDAY5, SQLSRV_FETCH_ASSOC);

$conditionEHR5 = " AND a.PersonCode ='" . $result_seTenkotransportDAY5['MODIFIEDBY'] . "'";
$sql_seEHR5 = "{call megEmployeeEHR_v2(?,?)}";
$params_seEHR5 = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array($conditionEHR5, SQLSRV_PARAM_IN)
);
$query_seEHR5 = sqlsrv_query($conn, $sql_seEHR5, $params_seEHR5);
$result_seEHR5 = sqlsrv_fetch_array($query_seEHR5, SQLSRV_FETCH_ASSOC);

$TENKOLOADRESTCHECKDAY5 = ($result_seTenkotransportDAY5['TENKOLOADRESTCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOBODYSLEEPYCHECKDAY5 = ($result_seTenkotransportDAY5['TENKOBODYSLEEPYCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOCARNEWCHECKDAY5 = ($result_seTenkotransportDAY5['TENKOCARNEWCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOTRAILERCHECKDAY5 = ($result_seTenkotransportDAY5['TENKOTRAILERCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOROADCHECKDAY5 = ($result_seTenkotransportDAY5['TENKOROADCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOAIRCHECKDAY5 = ($result_seTenkotransportDAY5['TENKOAIRCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOSLEEPYCHECKDAY5 = ($result_seTenkotransportDAY5['TENKOSLEEPYCHECK'] == "1" || $result_seTenkotransportDAY5['TENKOSLEEPYCHECK'] == "0x") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";


if ($result_seTenkotransportDAY5['TENKOLOADRESTRESULT0'] == "1") {
    $TENKOLOADRESTRESULTDAY50 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOLOADRESTRESULT0'] == "0") {
    $TENKOLOADRESTRESULTDAY50 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOLOADRESTRESULT0'] == "x") {
    $TENKOLOADRESTRESULTDAY50 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOLOADRESTRESULT0'] == "-") {
    $TENKOLOADRESTRESULTDAY50 = "<img src='../images/circle_3.png' width='2%'>";
}



if ($result_seTenkotransportDAY5['TENKOLOADRESTRESULT1'] == "1") {
    $TENKOLOADRESTRESULTDAY51 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOLOADRESTRESULT1'] == "0") {
    $TENKOLOADRESTRESULTDAY51 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOLOADRESTRESULT1'] == "x") {
    $TENKOLOADRESTRESULTDAY51 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOLOADRESTRESULT1'] == "-") {
    $TENKOLOADRESTRESULTDAY51 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOLOADRESTRESULT2'] == "1") {
    $TENKOLOADRESTRESULTDAY52 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOLOADRESTRESULT2'] == "0") {
    $TENKOLOADRESTRESULTDAY52 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOLOADRESTRESULT2'] == "x") {
    $TENKOLOADRESTRESULTDAY52 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOLOADRESTRESULT2'] == "-") {
    $TENKOLOADRESTRESULTDAY52 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOLOADRESTRESULT3'] == "1") {
    $TENKOLOADRESTRESULTDAY53 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOLOADRESTRESULT3'] == "0") {
    $TENKOLOADRESTRESULTDAY53 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOLOADRESTRESULT3'] == "x") {
    $TENKOLOADRESTRESULTDAY53 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOLOADRESTRESULT3'] == "-") {
    $TENKOLOADRESTRESULTDAY53 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOLOADRESTRESULT4'] == "1") {
    $TENKOLOADRESTRESULTDAY54 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOLOADRESTRESULT4'] == "0") {
    $TENKOLOADRESTRESULTDAY54 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOLOADRESTRESULT4'] == "x") {
    $TENKOLOADRESTRESULTDAY54 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOLOADRESTRESULT4'] == "-") {
    $TENKOLOADRESTRESULTDAY54 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOLOADRESTRESULT5'] == "1") {
    $TENKOLOADRESTRESULTDAY55 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOLOADRESTRESULT5'] == "0") {
    $TENKOLOADRESTRESULTDAY55 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOLOADRESTRESULT5'] == "x") {
    $TENKOLOADRESTRESULTDAY55 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOLOADRESTRESULT5'] == "-") {
    $TENKOLOADRESTRESULTDAY55 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOLOADRESTRESULT6'] == "1") {
    $TENKOLOADRESTRESULTDAY56 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOLOADRESTRESULT6'] == "0") {
    $TENKOLOADRESTRESULTDAY56 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOLOADRESTRESULT6'] == "x") {
    $TENKOLOADRESTRESULTDAY56 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOLOADRESTRESULT6'] == "-") {
    $TENKOLOADRESTRESULTDAY56 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOBODYSLEEPYRESULT0'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY50 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOBODYSLEEPYRESULT0'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY50 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOBODYSLEEPYRESULT0'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY50 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOBODYSLEEPYRESULT0'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY50 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOBODYSLEEPYRESULT1'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY51 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOBODYSLEEPYRESULT1'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY51 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOBODYSLEEPYRESULT1'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY51 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOBODYSLEEPYRESULT1'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY51 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOBODYSLEEPYRESULT2'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY52 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOBODYSLEEPYRESULT2'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY52 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOBODYSLEEPYRESULT2'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY52 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOBODYSLEEPYRESULT2'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY52 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOBODYSLEEPYRESULT3'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY53 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOBODYSLEEPYRESULT3'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY53 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOBODYSLEEPYRESULT3'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY53 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOBODYSLEEPYRESULT3'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY53 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOBODYSLEEPYRESULT4'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY54 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOBODYSLEEPYRESULT4'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY54 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOBODYSLEEPYRESULT4'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY54 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOBODYSLEEPYRESULT4'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY54 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOBODYSLEEPYRESULT5'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY55 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOBODYSLEEPYRESULT5'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY55 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOBODYSLEEPYRESULT5'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY55 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOBODYSLEEPYRESULT5'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY55 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOBODYSLEEPYRESULT6'] == "1") {
    $TENKOBODYSLEEPYRESULTDAY56 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOBODYSLEEPYRESULT6'] == "0") {
    $TENKOBODYSLEEPYRESULTDAY56 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOBODYSLEEPYRESULT6'] == "x") {
    $TENKOBODYSLEEPYRESULTDAY56 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOBODYSLEEPYRESULT6'] == "-") {
    $TENKOBODYSLEEPYRESULTDAY56 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOCARNEWRESULT0'] == "1") {
    $TENKOCARNEWRESULTDAY50 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOCARNEWRESULT0'] == "0") {
    $TENKOCARNEWRESULTDAY50 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOCARNEWRESULT0'] == "x") {
    $TENKOCARNEWRESULTDAY50 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOCARNEWRESULT0'] == "-") {
    $TENKOCARNEWRESULTDAY50 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOCARNEWRESULT1'] == "1") {
    $TENKOCARNEWRESULTDAY51 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOCARNEWRESULT1'] == "0") {
    $TENKOCARNEWRESULTDAY51 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOCARNEWRESULT1'] == "x") {
    $TENKOCARNEWRESULTDAY51 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOCARNEWRESULT1'] == "-") {
    $TENKOCARNEWRESULTDAY51 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOCARNEWRESULT2'] == "1") {
    $TENKOCARNEWRESULTDAY52 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOCARNEWRESULT2'] == "0") {
    $TENKOCARNEWRESULTDAY52 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOCARNEWRESULT2'] == "x") {
    $TENKOCARNEWRESULTDAY52 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOCARNEWRESULT2'] == "-") {
    $TENKOCARNEWRESULTDAY52 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOCARNEWRESULT3'] == "1") {
    $TENKOCARNEWRESULTDAY53 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOCARNEWRESULT3'] == "0") {
    $TENKOCARNEWRESULTDAY53 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOCARNEWRESULT3'] == "x") {
    $TENKOCARNEWRESULTDAY53 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOCARNEWRESULT3'] == "-") {
    $TENKOCARNEWRESULTDAY53 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOCARNEWRESULT4'] == "1") {
    $TENKOCARNEWRESULTDAY54 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOCARNEWRESULT4'] == "0") {
    $TENKOCARNEWRESULTDAY54 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOCARNEWRESULT4'] == "x") {
    $TENKOCARNEWRESULTDAY54 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOCARNEWRESULT4'] == "-") {
    $TENKOCARNEWRESULTDAY54 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOCARNEWRESULT5'] == "1") {
    $TENKOCARNEWRESULTDAY55 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOCARNEWRESULT5'] == "0") {
    $TENKOCARNEWRESULTDAY55 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOCARNEWRESULT5'] == "x") {
    $TENKOCARNEWRESULTDAY55 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOCARNEWRESULT5'] == "-") {
    $TENKOCARNEWRESULTDAY55 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOCARNEWRESULT6'] == "1") {
    $TENKOCARNEWRESULTDAY56 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOCARNEWRESULT6'] == "0") {
    $TENKOCARNEWRESULTDAY56 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOCARNEWRESULT6'] == "x") {
    $TENKOCARNEWRESULTDAY56 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOCARNEWRESULT6'] == "-") {
    $TENKOCARNEWRESULTDAY56 = "<img src='../images/circle_3.png' width='2%'>";
}
if ($result_seTenkotransportDAY5['TENKOTRAILERRESULT0'] == "1") {
    $TENKOTRAILERRESULTDAY50 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOTRAILERRESULT0'] == "0") {
    $TENKOTRAILERRESULTDAY50 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOTRAILERRESULT0'] == "x") {
    $TENKOTRAILERRESULTDAY50 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOTRAILERRESULT0'] == "-") {
    $TENKOTRAILERRESULTDAY50 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOTRAILERRESULT1'] == "1") {
    $TENKOTRAILERRESULTDAY51 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOTRAILERRESULT1'] == "0") {
    $TENKOTRAILERRESULTDAY51 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOTRAILERRESULT1'] == "x") {
    $TENKOTRAILERRESULTDAY51 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOTRAILERRESULT1'] == "-") {
    $TENKOTRAILERRESULTDAY51 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOTRAILERRESULT2'] == "1") {
    $TENKOTRAILERRESULTDAY52 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOTRAILERRESULT2'] == "0") {
    $TENKOTRAILERRESULTDAY52 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOTRAILERRESULT2'] == "x") {
    $TENKOTRAILERRESULTDAY52 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOTRAILERRESULT2'] == "-") {
    $TENKOTRAILERRESULTDAY52 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOTRAILERRESULT3'] == "1") {
    $TENKOTRAILERRESULTDAY53 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOTRAILERRESULT3'] == "0") {
    $TENKOTRAILERRESULTDAY53 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOTRAILERRESULT3'] == "x") {
    $TENKOTRAILERRESULTDAY53 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOTRAILERRESULT3'] == "-") {
    $TENKOTRAILERRESULTDAY53 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOTRAILERRESULT4'] == "1") {
    $TENKOTRAILERRESULTDAY54 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOTRAILERRESULT4'] == "0") {
    $TENKOTRAILERRESULTDAY54 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOTRAILERRESULT4'] == "x") {
    $TENKOTRAILERRESULTDAY54 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOTRAILERRESULT4'] == "-") {
    $TENKOTRAILERRESULTDAY54 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOTRAILERRESULT5'] == "1") {
    $TENKOTRAILERRESULTDAY55 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOTRAILERRESULT5'] == "0") {
    $TENKOTRAILERRESULTDAY55 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOTRAILERRESULT5'] == "x") {
    $TENKOTRAILERRESULTDAY55 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOTRAILERRESULT5'] == "-") {
    $TENKOTRAILERRESULTDAY55 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOTRAILERRESULT6'] == "1") {
    $TENKOTRAILERRESULTDAY56 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOTRAILERRESULT6'] == "0") {
    $TENKOTRAILERRESULTDAY56 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOTRAILERRESULT6'] == "x") {
    $TENKOTRAILERRESULTDAY56 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOTRAILERRESULT6'] == "-") {
    $TENKOTRAILERRESULTDAY56 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOROADRESULT0'] == "1") {
    $TENKOROADRESULTDAY50 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOROADRESULT0'] == "0") {
    $TENKOROADRESULTDAY50 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOROADRESULT0'] == "x") {
    $TENKOROADRESULTDAY50 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOROADRESULT0'] == "-") {
    $TENKOROADRESULTDAY50 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOROADRESULT1'] == "1") {
    $TENKOROADRESULTDAY51 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOROADRESULT1'] == "0") {
    $TENKOROADRESULTDAY51 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOROADRESULT1'] == "x") {
    $TENKOROADRESULTDAY51 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOROADRESULT1'] == "-") {
    $TENKOROADRESULTDAY51 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOROADRESULT2'] == "1") {
    $TENKOROADRESULTDAY52 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOROADRESULT2'] == "0") {
    $TENKOROADRESULTDAY52 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOROADRESULT2'] == "x") {
    $TENKOROADRESULTDAY52 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOROADRESULT2'] == "-") {
    $TENKOROADRESULTDAY52 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOROADRESULT3'] == "1") {
    $TENKOROADRESULTDAY53 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOROADRESULT3'] == "0") {
    $TENKOROADRESULTDAY53 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOROADRESULT3'] == "x") {
    $TENKOROADRESULTDAY53 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOROADRESULT3'] == "-") {
    $TENKOROADRESULTDAY53 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOROADRESULT4'] == "1") {
    $TENKOROADRESULTDAY54 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOROADRESULT4'] == "0") {
    $TENKOROADRESULTDAY54 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOROADRESULT4'] == "x") {
    $TENKOROADRESULTDAY54 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOROADRESULT4'] == "-") {
    $TENKOROADRESULTDAY54 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOROADRESULT5'] == "1") {
    $TENKOROADRESULTDAY55 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOROADRESULT5'] == "0") {
    $TENKOROADRESULTDAY55 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOROADRESULT5'] == "x") {
    $TENKOROADRESULTDAY55 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOROADRESULT5'] == "-") {
    $TENKOROADRESULTDAY55 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOROADRESULT6'] == "1") {
    $TENKOROADRESULTDAY56 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOROADRESULT6'] == "0") {
    $TENKOROADRESULTDAY56 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOROADRESULT6'] == "x") {
    $TENKOROADRESULTDAY56 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOROADRESULT6'] == "-") {
    $TENKOROADRESULTDAY56 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOAIRRESULT0'] == "1") {
    $TENKOAIRRESULTDAY50 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOAIRRESULT0'] == "0") {
    $TENKOAIRRESULTDAY50 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOAIRRESULT0'] == "x") {
    $TENKOAIRRESULTDAY50 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOAIRRESULT0'] == "-") {
    $TENKOAIRRESULTDAY50 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOAIRRESULT1'] == "1") {
    $TENKOAIRRESULTDAY51 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOAIRRESULT1'] == "0") {
    $TENKOAIRRESULTDAY51 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOAIRRESULT1'] == "x") {
    $TENKOAIRRESULTDAY51 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOAIRRESULT1'] == "-") {
    $TENKOAIRRESULTDAY51 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOAIRRESULT2'] == "1") {
    $TENKOAIRRESULTDAY52 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOAIRRESULT2'] == "0") {
    $TENKOAIRRESULTDAY52 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOAIRRESULT2'] == "x") {
    $TENKOAIRRESULTDAY52 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOAIRRESULT2'] == "-") {
    $TENKOAIRRESULTDAY52 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOAIRRESULT3'] == "1") {
    $TENKOAIRRESULTDAY53 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOAIRRESULT3'] == "0") {
    $TENKOAIRRESULTDAY53 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOAIRRESULT3'] == "x") {
    $TENKOAIRRESULTDAY53 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOAIRRESULT3'] == "-") {
    $TENKOAIRRESULTDAY53 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOAIRRESULT4'] == "1") {
    $TENKOAIRRESULTDAY54 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOAIRRESULT4'] == "0") {
    $TENKOAIRRESULTDAY54 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOAIRRESULT4'] == "x") {
    $TENKOAIRRESULTDAY54 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOAIRRESULT4'] == "-") {
    $TENKOAIRRESULTDAY54 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOAIRRESULT5'] == "1") {
    $TENKOAIRRESULTDAY55 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOAIRRESULT5'] == "0") {
    $TENKOAIRRESULTDAY55 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOAIRRESULT5'] == "x") {
    $TENKOAIRRESULTDAY55 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOAIRRESULT5'] == "-") {
    $TENKOAIRRESULTDAY55 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOAIRRESULT6'] == "1") {
    $TENKOAIRRESULTDAY56 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOAIRRESULT6'] == "0") {
    $TENKOAIRRESULTDAY56 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOAIRRESULT6'] == "x") {
    $TENKOAIRRESULTDAY56 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOAIRRESULT6'] == "-") {
    $TENKOAIRRESULTDAY56 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOSLEEPYRESULT0'] == "1") {
    $TENKOSLEEPYRESULTDAY50 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOSLEEPYRESULT0'] == "0") {
    $TENKOSLEEPYRESULTDAY50 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOSLEEPYRESULT0'] == "x") {
    $TENKOSLEEPYRESULTDAY50 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOSLEEPYRESULT0'] == "-") {
    $TENKOSLEEPYRESULTDAY50 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOSLEEPYRESULT1'] == "1") {
    $TENKOSLEEPYRESULTDAY51 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOSLEEPYRESULT1'] == "0") {
    $TENKOSLEEPYRESULTDAY51 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOSLEEPYRESULT1'] == "x") {
    $TENKOSLEEPYRESULTDAY51 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOSLEEPYRESULT1'] == "-") {
    $TENKOSLEEPYRESULTDAY51 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOSLEEPYRESULT2'] == "1") {
    $TENKOSLEEPYRESULTDAY52 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOSLEEPYRESULT2'] == "0") {
    $TENKOSLEEPYRESULTDAY52 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOSLEEPYRESULT2'] == "x") {
    $TENKOSLEEPYRESULTDAY52 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOSLEEPYRESULT2'] == "-") {
    $TENKOSLEEPYRESULTDAY52 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOSLEEPYRESULT3'] == "1") {
    $TENKOSLEEPYRESULTDAY53 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOSLEEPYRESULT3'] == "0") {
    $TENKOSLEEPYRESULTDAY53 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOSLEEPYRESULT3'] == "x") {
    $TENKOSLEEPYRESULTDAY53 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOSLEEPYRESULT3'] == "-") {
    $TENKOSLEEPYRESULTDAY53 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOSLEEPYRESULT4'] == "1") {
    $TENKOSLEEPYRESULTDAY54 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOSLEEPYRESULT4'] == "0") {
    $TENKOSLEEPYRESULTDAY54 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOSLEEPYRESULT4'] == "x") {
    $TENKOSLEEPYRESULTDAY54 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOSLEEPYRESULT4'] == "-") {
    $TENKOSLEEPYRESULTDAY54 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOSLEEPYRESULT5'] == "1") {
    $TENKOSLEEPYRESULTDAY55 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOSLEEPYRESULT5'] == "0") {
    $TENKOSLEEPYRESULTDAY55 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOSLEEPYRESULT5'] == "x") {
    $TENKOSLEEPYRESULTDAY55 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOSLEEPYRESULT5'] == "-") {
    $TENKOSLEEPYRESULTDAY55 = "<img src='../images/circle_3.png' width='2%'>";
}

if ($result_seTenkotransportDAY5['TENKOSLEEPYRESULT6'] == "1") {
    $TENKOSLEEPYRESULTDAY56 = "<img src='../images/circle_2.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOSLEEPYRESULT6'] == "0") {
    $TENKOSLEEPYRESULTDAY56 = "<img src='../images/circle_1.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOSLEEPYRESULT6'] == "x") {
    $TENKOSLEEPYRESULTDAY56 = "<img src='../images/cancel.png' width='2%'>";
} else if ($result_seTenkotransportDAY5['TENKOSLEEPYRESULT6'] == "-") {
    $TENKOSLEEPYRESULTDAY56 = "<img src='../images/circle_3.png' width='2%'>";
}
$VAR_MODIFIEDBY5 = ($result_seTenkotransportDAY5["MODIFIEDBY"] == "") ? $result_seTenkotransportDAY5["CREATEBY"] : $result_seTenkotransportDAY5["MODIFIEDBY"];

$table_2DAY5 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>
   <tr style="border:1px solid #000;padding:4px;">
    <th colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"></th>
    <th colspan="1" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY5['TENKOTRANSPORTDATE'] . '</th>
      <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;">เท็งโกะระหว่างทาง</th>
        <th colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">ลายเซนเจ้าหน้าที่เท็งโกะ</th>
        <th colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $VAR_MODIFIEDBY5 . '</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="12" style="border-right:1px solid #000;padding:4px;text-align:left;">เจ้าหน้าที่โทรไปไม่พบสิ่งผิดปกติ : 0 | พนักงานขับรถโทรมาไม่พบสิ่งผิดปกติ : 1 | พบสิ่งผิดปกติ : x</li></th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th width="5%" rowspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">ข้อ</th>
        <th rowspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">หัวข้อ</th>
        <th rowspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">ช่องตรวจสอบ</th>
        <th rowspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">เกณฑ์การตัดสิน</th>
        <th rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">โทรช่วง 06:00 - 24:00</th>
        <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;">Night Call Check</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">รายละเอียดการแนะนำ</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 1</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 2</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 3</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 4</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 5</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้งที่ 6</th>
        <th rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY5['TENKOTIME0'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY5['TENKOTIME1'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY5['TENKOTIME2'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY5['TENKOTIME3'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY5['TENKOTIME4'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY5['TENKOTIME5'] . '</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkotransportDAY5['TENKOTIME6'] . '</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
    </tr>
    </thead>
    <tbody>
    <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">1</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">เส้นทางที่กำหนด - จุดพัก</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTCHECKDAY5 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">เส้นทาง จุดพักที่กำหนด</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY50 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY50 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY50 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY50 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY50 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY50 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY50 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY5['TENKOLOADRESTREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">2</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจร่างกาย - อาการง่วง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYCHECKDAY5 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">วิธีการพูดคุยต้องร่าเริง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY51 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY51 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY51 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY51 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY51 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY51 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY51 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY5['TENKOBODYSLEEPYREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">3</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจรถใหม่ (เฉพาะหยุดจอด)</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWCHECKDAY5 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">มีการรายงานเกี่ยวกับรถใหม่ว่ามีสิ่งผิดปกติหรือไม่</td>
      <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY52 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY52 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY52 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY52 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY52 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY52 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY52 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY5['TENKOCARNEWREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">4</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจเทรลเลอร์</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERCHECKDAY5 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ระหว่างวิ่งงานไม่มีสิ่งผิดปกติ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY53 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY53 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY53 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY53 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY53 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY53 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY53 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY5['TENKOTRAILERREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">5</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสภาพถนน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADCHECKDAY5 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">รายงานสภาพถนน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY54 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY54 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY54 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY54 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY54 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY54 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY54 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY5['TENKOROADREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">6</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบสภาพอากาศ (ใช้ที่ปัดน้ำฝนระดับ 3 ให้หยุดรถ)</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRCHECKDAY5 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">รายงานสภาพอากาศ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY55 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY55 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY55 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY55 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY55 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY55 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY55 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY5['TENKOAIRREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">7</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบอาการง่วงและย้ำให้ระมัดระวัง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYCHECKDAY5 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สภาพที่สามารถวิ่งงานต่อได้</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESTRESULTDAY56 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYSLEEPYRESULTDAY56 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULTDAY56 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULTDAY56 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOROADRESULTDAY56 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULTDAY56 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPYRESULTDAY56 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkotransportDAY5['TENKOSLEEPYREMARK'] . '</td>
      </tr>
    </tbody></table>

';


$mpdf->WriteHTML($style);
$mpdf->WriteHTML($tablehistory);
$mpdf->WriteHTML($table_headerDAY1);
$mpdf->WriteHTML($table_1DAY1);
$mpdf->WriteHTML($table_2DAY1);



if ($result_seTenkotransportDAY2['TENKOTIME0'] != '' || $result_seTenkotransportDAY2['TENKOTIME1'] != '' || $result_seTenkotransportDAY2['TENKOTIME2'] != '' || $result_seTenkotransportDAY2['TENKOTIME3'] != '' || $result_seTenkotransportDAY2['TENKOTIME4'] != '' || $result_seTenkotransportDAY2['TENKOTIME5'] != '' || $result_seTenkotransportDAY2['TENKOTIME6'] != '') {
    $mpdf->WriteHTML($table_headerDAY2);
    $mpdf->WriteHTML($table_1DAY2);
    $mpdf->WriteHTML($table_2DAY2);
}
if ($result_seTenkotransportDAY3['TENKOTIME0'] != '' || $result_seTenkotransportDAY3['TENKOTIME1'] != '' || $result_seTenkotransportDAY3['TENKOTIME2'] != '' || $result_seTenkotransportDAY3['TENKOTIME3'] != '' || $result_seTenkotransportDAY3['TENKOTIME4'] != '' || $result_seTenkotransportDAY3['TENKOTIME5'] != '' || $result_seTenkotransportDAY3['TENKOTIME6'] != '') {
    $mpdf->WriteHTML($table_headerDAY3);
    $mpdf->WriteHTML($table_1DAY3);
    $mpdf->WriteHTML($table_2DAY3);
}
if ($result_seTenkotransportDAY4['TENKOTIME0'] != '' || $result_seTenkotransportDAY4['TENKOTIME1'] != '' || $result_seTenkotransportDAY4['TENKOTIME2'] != '' || $result_seTenkotransportDAY4['TENKOTIME3'] != '' || $result_seTenkotransportDAY4['TENKOTIME4'] != '' || $result_seTenkotransportDAY4['TENKOTIME5'] != '' || $result_seTenkotransportDAY4['TENKOTIME6'] != '') {
    $mpdf->WriteHTML($table_headerDAY4);
    $mpdf->WriteHTML($table_1DAY4);
    $mpdf->WriteHTML($table_2DAY4);
}
if ($result_seTenkotransportDAY5['TENKOTIME0'] != '' || $result_seTenkotransportDAY5['TENKOTIME1'] != '' || $result_seTenkotransportDAY5['TENKOTIME2'] != '' || $result_seTenkotransportDAY5['TENKOTIME3'] != '' || $result_seTenkotransportDAY5['TENKOTIME4'] != '' || $result_seTenkotransportDAY5['TENKOTIME5'] != '' || $result_seTenkotransportDAY5['TENKOTIME6'] != '') {
    $mpdf->WriteHTML($table_headerDAY5);
    $mpdf->WriteHTML($table_1DAY5);
    $mpdf->WriteHTML($table_2DAY5);
}








$mpdf->AddPage();

$condTenkoafter1 = " AND TENKOMASTERDIRVERCODE = '" . $_GET['employeecode'] . "' ";
$condTenkoafter2 = " AND TENKOMASTERID = '" . $_GET['tenkomasterid'] . "'";

$sql_seTenkoafter = "{call megEdittenkoafter_v2(?,?,?,?)}";
$params_seTenkoafter = array(
    array('select_tenkoafter', SQLSRV_PARAM_IN),
    array($condTenkoafter1, SQLSRV_PARAM_IN),
    array($condTenkoafter2, SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seTenkoafter = sqlsrv_query($conn, $sql_seTenkoafter, $params_seTenkoafter);
$result_seTenkoafter = sqlsrv_fetch_array($query_seTenkoafter, SQLSRV_FETCH_ASSOC);

$TENKOBEFOREGREETCHECK1 = ($result_seTenkoafter['TENKOBEFOREGREETCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOUNIFORMCHECK1 = ($result_seTenkoafter['TENKOUNIFORMCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOBODYCHECK1 = ($result_seTenkoafter['TENKOBODYCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOALCOHOLCHECK1 = ($result_seTenkoafter['TENKOALCOHOLCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOCARNEWCHECK1 = ($result_seTenkoafter['TENKOCARNEWCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOTRAILERCHECK1 = ($result_seTenkoafter['TENKOTRAILERCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKORISKYCHECK1 = ($result_seTenkoafter['TENKORISKYCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOAIRCHECK1 = ($result_seTenkoafter['TENKOAIRCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOPATTERNDRIVERCHECK1 = ($result_seTenkoafter['TENKOPATTERNDRIVERCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKODAILYDRIVERCHECK1 = ($result_seTenkoafter['TENKODAILYDRIVERCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOHIYARIHATTOCHECK1 = ($result_seTenkoafter['TENKOHIYARIHATTOCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOYOKOTENCHECK1 = ($result_seTenkoafter['TENKOYOKOTENCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";
$TENKOAFTERGREETCHECK1 = ($result_seTenkoafter['TENKOAFTERGREETCHECK'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "<img src='../images/cancel.png' width='2%'>";

// ตรวจสอบสายตา



$TENKOBEFOREGREETRESULT11 = ($result_seTenkoafter['TENKOBEFOREGREETRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOUNIFORMRESULT11 = ($result_seTenkoafter['TENKOUNIFORMRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOBODYRESULT11 = ($result_seTenkoafter['TENKOBODYRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOALCOHOLRESULT11 = ($result_seTenkoafter['TENKOALCOHOLRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOCARNEWRESULT11 = ($result_seTenkoafter['TENKOCARNEWRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOTRAILERRESULT11 = ($result_seTenkoafter['TENKOTRAILERRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKORISKYRESULT11 = ($result_seTenkoafter['TENKORISKYRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOAIRRESULT11 = ($result_seTenkoafter['TENKOAIRRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOPATTERNDRIVERRESULT11 = ($result_seTenkoafter['TENKOPATTERNDRIVERRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKODAILYDRIVERRESULT11 = ($result_seTenkoafter['TENKODAILYDRIVERRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOHIYARIHATTORESULT11 = ($result_seTenkoafter['TENKOHIYARIHATTORESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOYOKOTENRESULT11 = ($result_seTenkoafter['TENKOYOKOTENRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOAFTERGREETRESULT11 = ($result_seTenkoafter['TENKOAFTERGREETRESULT'] == "1") ? "<img src='../images/ok.png' width='2%'>" : "";

$TENKOBEFOREGREETRESULT00 = ($result_seTenkoafter['TENKOBEFOREGREETRESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOUNIFORMRESULT00 = ($result_seTenkoafter['TENKOUNIFORMRESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOBODYRESULT00 = ($result_seTenkoafter['TENKOBODYRESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$ENKOALCOHOLRESULT00 = ($result_seTenkoafter['ENKOALCOHOLRESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOCARNEWRESULT00 = ($result_seTenkoafter['TENKOCARNEWRESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOTRAILERRESULT00 = ($result_seTenkoafter['TENKOTRAILERRESULT '] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKORISKYRESULT00 = ($result_seTenkoafter['TENKORISKYRESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOAIRRESULT00 = ($result_seTenkoafter['TENKOAIRRESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOPATTERNDRIVERRESULT00 = ($result_seTenkoafter['TENKOPATTERNDRIVERRESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKODAILYDRIVERRESULT00 = ($result_seTenkoafter['TENKODAILYDRIVERRESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOHIYARIHATTORESULT00 = ($result_seTenkoafter['TENKOHIYARIHATTORESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOYOKOTENRESULT00 = ($result_seTenkoafter['TENKOYOKOTENRESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";
$TENKOAFTERGREETRESULT00 = ($result_seTenkoafter['TENKOAFTERGREETRESULT'] == "0") ? "<img src='../images/ok.png' width='2%'>" : "";

$table_3 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>
    <tr style="border:1px solid #000;padding:4px;">
     <th style="border-right:1px solid #000;padding:4px;text-align:center;">เวลา<br />ทำเท็งโกะ</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkoafter['TENKOAFTERDATE'] . '</th>
      <th colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">เท็งโกะเลิกงาน</th>
        <th width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">ลายเซ็น<br />เจ้าหน้าที่<br />เท็งโกะ</th>
        <th width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkoafter["MODIFIEDBY"] . '</th>
        <th width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">ลายเซ็น พขร.</th>
        <th width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seDir['nameT'] . '</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th width="5%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ข้อ</th>
        <th width="25%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">หัวข้อ</th>
        <th width="5%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ช่องตรวจสอบ</th>
        <th width="25%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">เกณฑ์การตัดสิน</th>
        <th  colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th  colspan="2" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">รายละเอียดและการแนะนำ</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ปกติ</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผิดปกติ</th>
    </tr>
    </thead>
    <tbody>
    <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">1</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">การทักทายก่อนเริ่มเท็งโกะ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREGREETCHECK1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ทักทายอย่างมีชีวิตชีวา</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREGREETRESULT11 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBEFOREGREETRESULT00 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkoafter['TENKOBEFOREGREETREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">2</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจเช็คยูนิฟอร์ม</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOUNIFORMCHECK1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สวมชุดที่สอาด ไม่ใส่เครื่องประดับที่อาจทำให้เกิดรอย</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOUNIFORMRESULT11 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOUNIFORMRESULT00 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkoafter['TENKOUNIFORMREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">3</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบสภาพร่างกาย</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYCHECK1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สภาพร่างกายแข็งแรงดี</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYRESULT11 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOBODYRESULT00 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkoafter['TENKOBODYREMARK'] . '</td>
      </tr>
     <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">4</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจเช็คแอลกอฮอล์</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOALCOHOLCHECK1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">[0]</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOALCOHOLRESULT11 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOALCOHOLRESULT00 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkoafter['TENKOALCOHOLREMARK'] . '</td>
      </tr>

      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">5</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">มีความผิดปกติกับรถใหม่หรือไม่</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWCHECK1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">รายงานสิ่งผิดปกติของรถใหม่ว่ามีหรือไม่</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULT11 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWRESULT00 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkoafter['TENKOCARNEWREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">6</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ความผิดปกติของรถเทรลเลอร์</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERCHECK1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">รายงานสิ่งผิดปกติของเทรลเลอร์ว่ามีหรือไม่</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULT11 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERRESULT00 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkoafter['TENKOTRAILERREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">7</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">จุดเสี่ยงระหว่างเส้นทางการขนส่ง(ล่าง)</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKORISKYCHECK1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">รายงานว่ามีจุดเปลี่ยนแปลงที่ผิดปกติหรือไม่</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKORISKYRESULT11 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKORISKYRESULT00 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkoafter['TENKORISKYREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">8</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบสภาพอากาศ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRCHECK1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">รายงานสภาพอากาศ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULT11 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAIRRESULT00 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkoafter['TENKOAIRREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">9</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบรูปแบบการขับขี่</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOPATTERNDRIVERCHECK1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">รายงานรูปแแบการขับขี่</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOPATTERNDRIVERRESULT11 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOPATTERNDRIVERRESULT00 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkoafter['TENKOPATTERNDRIVERREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">10</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบข้อมูลการขับขี่ประจำวันจาก GPS เรคคอร์ด(ล่าง)</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKODAILYDRIVERCHECK1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">หัวข้อฝ่าฝืนเป็น [0]</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKODAILYDRIVERRESULT11 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKODAILYDRIVERRESULT00 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkoafter['TENKODAILYDRIVERREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">11</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ฮิยาริฮัตโตะนอกเหนือจากข้อ 7.</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOHIYARIHATTOCHECK1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">เหตุการณ์ที่ตกใจและเกือบเกิดอุบัติเหตุ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOHIYARIHATTORESULT11 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOHIYARIHATTORESULT00 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkoafter['TENKOHIYARIHATTOREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">12</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">แจ้งเรื่องโยโกะเต็น/แนะนำวิธีการจัดสรรชั่วโมงนอนหลับ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOYOKOTENCHECK1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">เข้าใจเนื้อหาและวิธีการต่างๆที่แจ้งไป</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOYOKOTENRESULT11 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOYOKOTENRESULT00 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkoafter['TENKOYOKOTENREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">13</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">การทักทายหลังทำเท็งโกะเสร็จ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAFTERGREETCHECK1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ทักทายอย่างมีชีวิตชีวา</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAFTERGREETRESULT11 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOAFTERGREETRESULT00 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkoafter['TENKOAFTERGREETREMARK'] . '</td>
      </tr>



    </tbody></table>

';
if ($result_sePlain['COMPANYCODE'] == 'RCC' || $result_sePlain['COMPANYCODE'] == 'RATC' || $result_sePlain['COMPANYCODE'] == 'RRC') {
    $condTenkorisky1 = " AND TENKOMASTERDIRVERCODE = '" . $_GET['employeecode'] . "' ";
    $condTenkorisky2 = " AND TENKOMASTERID = '" . $_GET['tenkomasterid'] . "'";

    $sql_seTenkorisky = "{call megEdittenkorisky_v2(?,?,?,?)}";
    $params_seTenkorisky = array(
        array('select_tenkorisky', SQLSRV_PARAM_IN),
        array($condTenkorisky1, SQLSRV_PARAM_IN),
        array($condTenkorisky2, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seTenkorisky = sqlsrv_query($conn, $sql_seTenkorisky, $params_seTenkorisky);
    $result_seTenkorisky = sqlsrv_fetch_array($query_seTenkorisky, SQLSRV_FETCH_ASSOC);

    $TENKORISKYBPRESULT = ($result_seTenkorisky['TENKORISKYBPRESULT'] == "1") ? "มี" : "ไม่มี";
    $TENKORISKYSRRESULT = ($result_seTenkorisky['TENKORISKYSRRESULT'] == "1") ? "มี" : "ไม่มี";
    $TENKORISKYGWRESULT = ($result_seTenkorisky['TENKORISKYGWRESULT'] == "1") ? "มี" : "ไม่มี";
    $TENKORISKYOTH1RESULT = ($result_seTenkorisky['TENKORISKYOTH1RESULT'] == "1") ? "มี" : "ไม่มี";
    $TENKORISKYBRANCHRESULT = ($result_seTenkorisky['TENKORISKYBRANCHRESULT'] == "1") ? "มี" : "ไม่มี";
    $TENKOWIRERESULT = ($result_seTenkorisky['TENKOWIRERESULT'] == "1") ? "มี" : "ไม่มี";
    $TENKOLOADRESULT = ($result_seTenkorisky['TENKOLOADRESULT'] == "1") ? "มี" : "ไม่มี";
    $TENKOTRAILERPARKINGRESULT = ($result_seTenkorisky['TENKOTRAILERPARKINGRESULT'] == "1") ? "มี" : "ไม่มี";
    $TENKOCARNEWPARKINGRESULT = ($result_seTenkorisky['TENKOCARNEWPARKINGRESULT'] == "1") ? "มี" : "ไม่มี";
    $TENKORISKYOTH2RESULT = ($result_seTenkorisky['TENKORISKYOTH2RESULT'] == "1") ? "มี" : "ไม่มี";
    $table_4 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>

    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="5" style="border-right:1px solid #000;padding:4px;text-align:center;">ข้อ 7.จุดเสี่ยงระหว่างเส้นทางการขนส่ง</th>
    </tr>
     <tr style="border:1px solid #000;padding:4px;">
        <th width="5%" style="border-right:1px solid #000;padding:4px;text-align:center;">ข้อ</th>
        <th width="20%" style="border-right:1px solid #000;padding:4px;text-align:center;">หัวข้อ</th>
        <th width="25%" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</th>
        <th width="25%" style="border-right:1px solid #000;padding:4px;text-align:center;">สิ่งผิดปกติ</th>
        <th width="25%" style="border-right:1px solid #000;padding:4px;text-align:center;">รายละเอียดสิ่งผิดปกติ</th>
    </tr>
    </thead>
    <tbody>

      <tr style="border:1px solid #000;padding:4px;">
        <td rowspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">1</td>
        <td rowspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">ในยาร์ด</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">บ้านโพธิ์</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKORISKYBPRESULT . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkorisky['TENKORISKYBPREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สำโรง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKORISKYSRRESULT . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkorisky['TENKORISKYSRREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">เกตุเวย์</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKORISKYGWRESULT . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkorisky['TENKORISKYGWREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">อื่นๆ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKORISKYOTH1RESULT . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkorisky['TENKORISKYOTH1REMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">2</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">บนถนน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">กิ่งไม้</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKORISKYBRANCHRESULT . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkorisky['TENKORISKYBRANCHREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สายไฟ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOWIRERESULT . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkorisky['TENKOWIREREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สภาพถนน,ก่อสร้าง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESULT . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkorisky['TENKOLOADREMARK'] . '</td>
      </tr>

      <tr style="border:1px solid #000;padding:4px;">
        <td rowspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">3</td>
        <td rowspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">ตัวแทนจำหน่าย</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">จุดจอดเทรลเลอร์</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOTRAILERPARKINGRESULT . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkorisky['TENKOTRAILERPARKINGREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">พื้นที่รับรถใหม่</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARNEWPARKINGRESULT . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkorisky['TENKOCARNEWPARKINGREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">อื่นๆ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKORISKYOTH2RESULT . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkorisky['TENKORISKYOTH2REMARK'] . '</td>
      </tr>

    </tbody></table>';
} else if ($result_sePlain['COMPANYCODE'] == 'RKS' || $result_sePlain['COMPANYCODE'] == 'RKL' || $result_sePlain['COMPANYCODE'] == 'RKR') {
    $condTenkorisky1 = " AND TENKOMASTERDIRVERCODE = '" . $_GET['employeecode'] . "' ";
    $condTenkorisky2 = " AND TENKOMASTERID = '" . $_GET['tenkomasterid'] . "'";

    $sql_seTenkorisky = "{call megEdittenkorisky_v2(?,?,?,?)}";
    $params_seTenkorisky = array(
        array('select_tenkorisky', SQLSRV_PARAM_IN),
        array($condTenkorisky1, SQLSRV_PARAM_IN),
        array($condTenkorisky2, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seTenkorisky = sqlsrv_query($conn, $sql_seTenkorisky, $params_seTenkorisky);
    $result_seTenkorisky = sqlsrv_fetch_array($query_seTenkorisky, SQLSRV_FETCH_ASSOC);


    $TENKORISKYBRANCHRESULT = ($result_seTenkorisky['TENKORISKYBRANCHRESULT'] == "1") ? "มี" : "ไม่มี";
    $TENKOWIRERESULT = ($result_seTenkorisky['TENKOWIRERESULT'] == "1") ? "มี" : "ไม่มี";
    $TENKOLOADRESULT = ($result_seTenkorisky['TENKOLOADRESULT'] == "1") ? "มี" : "ไม่มี";

    $TENKORISKYBRANCHRESULT_H = ($result_seTenkorisky['TENKORISKYBRANCHRESULT_H'] == "1") ? "มี" : "ไม่มี";
    $TENKOWIRERESULT_H = ($result_seTenkorisky['TENKOWIRERESULT_H'] == "1") ? "มี" : "ไม่มี";
    $TENKOLOADRESULT_H = ($result_seTenkorisky['TENKOLOADRESULT_H'] == "1") ? "มี" : "ไม่มี";

    $table_4 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>

    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="5" style="border-right:1px solid #000;padding:4px;text-align:center;">ข้อ 7.จุดเสี่ยงระหว่างเส้นทางการขนส่ง</th>
    </tr>
     <tr style="border:1px solid #000;padding:4px;">
        <th width="5%" style="border-right:1px solid #000;padding:4px;text-align:center;">ข้อ</th>
        <th width="20%" style="border-right:1px solid #000;padding:4px;text-align:center;">หัวข้อ</th>
        <th width="25%" style="border-right:1px solid #000;padding:4px;text-align:center;">สิ่งผิดปกติ</th>
        <th width="25%" style="border-right:1px solid #000;padding:4px;text-align:center;">ฮิยาริฮัตโตะ</th>
        <th width="25%" style="border-right:1px solid #000;padding:4px;text-align:center;">รายละเอียดสิ่งผิดปกติ</th>
    </tr>
    </thead>
    <tbody>

      
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">1</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">กิ่งไม้</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKORISKYBRANCHRESULT . '</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKORISKYBRANCHRESULT_H . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkorisky['TENKORISKYBRANCHREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
      <td style="border-right:1px solid #000;padding:4px;text-align:center;">2</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สายไฟ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOWIRERESULT . '</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOWIRERESULT_H . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkorisky['TENKOWIREREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
      <td style="border-right:1px solid #000;padding:4px;text-align:center;">3</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สภาพถนน,ก่อสร้าง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESULT . '</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOLOADRESULT_H . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkorisky['TENKOLOADREMARK'] . '</td>
      </tr>

    

    </tbody></table>';
}

$condTenkogps1 = " AND TENKOMASTERDIRVERCODE = '" . $_GET['employeecode'] . "' ";
$condTenkogps2 = " AND TENKOMASTERID = '" . $_GET['tenkomasterid'] . "'";
$sql_seTenkogps = "{call megEdittenkogps_v2(?,?,?,?)}";
$params_seTenkogps = array(
    array('select_tenkogps', SQLSRV_PARAM_IN),
    array($condTenkogps1, SQLSRV_PARAM_IN),
    array($condTenkogps2, SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seTenkogps = sqlsrv_query($conn, $sql_seTenkogps, $params_seTenkogps);
$result_seTenkogps = sqlsrv_fetch_array($query_seTenkogps, SQLSRV_FETCH_ASSOC);


$table_5 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>


     <tr style="border:1px solid #000;padding:4px;">
        <th colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">แผนที่</th>
    </tr>
    </thead>
    <tbody>
    <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ในยาร์ด</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">บนถนน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตัวแทนจำหน่าย</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td width="33%" style="border-right:1px solid #000;padding:4px;text-align:center;" height="200">&nbsp;</td>
        <td width="33%" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td width="33%" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
      </tr>
    </tbody></table>';
$table_6 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>

     <tr style="border:1px solid #000;padding:4px;">
        <th colspan="5" style="border-right:1px solid #000;padding:4px;text-align:center;">ข้อ 10.ตรวจสอบการฝ่าฝืนระบบ GPS</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th width="5%" style="border-right:1px solid #000;padding:4px;text-align:center;">ข้อ</th>
        <th width="25%" style="border-right:1px solid #000;padding:4px;text-align:center;">หัวข้อ</th>
        <th width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">จำนวน</th>
        <th width="50%" style="border-right:1px solid #000;padding:4px;text-align:center;">รายละเอียดการชี้แนะ</th>
        <th width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">ลายเซ็นพขร.</th>
    </tr>
    </thead>
    <tbody>

      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">1</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ความเร็วเกินกำหนด</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkogps['TENKOGPSSPEEDOVERAMOUNT'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkogps['TENKOGPSSPEEDOVERREMARK'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkogps['TENKOGPSSPEEDOVERDIRVER'] . '</td>
      </tr>
       <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">2</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">เบรคกระทันหัน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkogps['TENKOGPSBRAKEAMOUNT'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkogps['TENKOGPSBRAKEREMARK'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkogps['TENKOGPSBRAKEDIRVER'] . '</td>
      </tr>
       <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">3</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">รอบเครื่องเกินกำหนด</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkogps['TENKOGPSSPEEDMACHINEAMOUNT'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkogps['TENKOGPSSPEEDMACHINEREMARK'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkogps['TENKOGPSSPEEDMACHINEDIRVER'] . '</td>
      </tr>
       <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">4</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">วิ่งนอกเส้นทาง</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkogps['TENKOGPSOUTLINEAMOUNT'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkogps['TENKOGPSOUTLINEREMARK'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkogps['TENKOGPSOUTLINEDIRVER'] . '</td>
      </tr>
       <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">5</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ขับรถต่อเนื่อง 4 ชม.</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkogps['TENKOGPSCONTINUOUSAMOUNT'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkogps['TENKOGPSCONTINUOUSREMARK'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkogps['TENKOGPSCONTINUOUSDIRVER'] . '</td>
      </tr>
    </tbody></table>';



$mpdf->WriteHTML($table_3);
$mpdf->WriteHTML($table_4);
$mpdf->WriteHTML($table_5);
$mpdf->WriteHTML($table_6);
$mpdf->Output();

sqlsrv_close($conn);
?>
