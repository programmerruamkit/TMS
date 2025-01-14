
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

$conditionDir = "  AND a.PersonCode = '" . $_GET["employeecode"] . "'";
$sql_seDir = "{call megEmployeeEHR_v2(?,?)}";
$params_seDir = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array($conditionDir, SQLSRV_PARAM_IN)
);
$query_seDir = sqlsrv_query($conn, $sql_seDir, $params_seDir);
$result_seDir = sqlsrv_fetch_array($query_seDir, SQLSRV_FETCH_ASSOC);

$condTenkomaster = " AND (a.TENKOMASTERDIRVERCODE1 = '" . $_GET['employeecode'] . "' OR a.TENKOMASTERDIRVERCODE2 = '" . $_GET['employeecode'] . "') AND a.TENKOMASTERID = '".$_GET['tenkomasterid']."'";
$sql_seTenkomaster = "{call megEdittenkomaster_v2(?,?)}";
$params_seTenkomaster = array(
    array('select_tenkomaster', SQLSRV_PARAM_IN),
    array($condTenkomaster, SQLSRV_PARAM_IN)
);
$query_seTenkomaster = sqlsrv_query($conn, $sql_seTenkomaster, $params_seTenkomaster);
$result_seTenkomaster = sqlsrv_fetch_array($query_seTenkomaster, SQLSRV_FETCH_ASSOC);

$condTenkobefor1 = " AND a.TENKOMASTERDIRVERCODE = '" . $_GET['employeecode'] . "' ";
$condTenkobefor2 = " AND a.TENKOMASTERID = '".$_GET['tenkomasterid']."'";
$sql_seTenkobefor = "{call megEdittenkobefore_v2(?,?,?,?)}";
$params_seTenkobefor = array(
    array('select_tenkobefore', SQLSRV_PARAM_IN),
    array($condTenkobefor1, SQLSRV_PARAM_IN),
    array($condTenkobefor2, SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seTenkobefor = sqlsrv_query($conn, $sql_seTenkobefor, $params_seTenkobefor);
$result_seTenkobefor = sqlsrv_fetch_array($query_seTenkobefor, SQLSRV_FETCH_ASSOC);

$TENKOBEFOREBY1 = ($result_seTenkobefor["MODIFIEDBY"]=="") ? $result_seTenkobefor["CREATEBY"] : $result_seTenkobefor["MODIFIEDBY"];

$conditionPlain = " AND a.VEHICLETRANSPORTPLANID = '" . $result_seTenkomaster['VEHICLETRANSPORTPLANID'] . "'";
$sql_sePlain = "{call megVehicletransportplan_v2(?,?)}";
$params_sePlain = array(
    array('select_vehicletransportplan', SQLSRV_PARAM_IN),
    array($conditionPlain, SQLSRV_PARAM_IN)
);
$query_sePlain = sqlsrv_query($conn, $sql_sePlain, $params_sePlain);
$result_sePlain = sqlsrv_fetch_array($query_sePlain, SQLSRV_FETCH_ASSOC);

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

$TENKOTARGET1 = ($result_seTenkomaster['TENKOTARGET1'] == '1')?"-ขับเว้นระยะห่าง 3 วิ":"";
$TENKOTARGET2 = ($result_seTenkomaster['TENKOTARGET2'] == '1')?"-ควบคุมพวงมาลัยให้คงที่":"";
$TENKOTARGET3 = ($result_seTenkomaster['TENKOTARGET3'] == '1')?"-ให้ใช้ความเร็วต่ำขณะผ่านที่ชุมชน":"";
$TENKOTARGET4 = ($result_seTenkomaster['TENKOTARGET4'] == '1')?"-ง่วงไม่ฝืนขับ":"";
$TENKOTARGET5 = ($result_seTenkomaster['TENKOTARGET5'] == '1')?"-ปฎิบัติงานตามขั้นตอน":"";
$TENKOTARGET6 = ($result_seTenkomaster['TENKOTARGET6'] == '1')?"-ขับขี่ตามกฎจราจร":"";
$TENKOTARGET7 = ($result_seTenkomaster['TENKOTARGET7'] == '1')?"-พบสิ่งผิดปกติให้ หยุด-เรียก-รอ":"";
$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';
$TENKOMASTERVEHICLE = "";
if($_GET['vehicletransportplanid'] == '' || $_GET['tenkomasterid'] != '')
{
    $TENKOMASTERVEHICLE = $result_seTenkomaster['TENKOMASTERVEHICLE'];
}
else
{
    $TENKOMASTERVEHICLE = $result_seTenkobefor['TENKOMASTERVEHICLE'];
}
$var_ka1 = "";
$var_ka2 = "";
$var_kaday = "";
$var_kanight = "";
if($result_seTenkomaster['TENKOMASTERKA'] != '')
{
    $var_ka1 = "<u>เปลี่ยนกะ</u>";
    $var_ka2 = "ไม่เปลี่ยนกะ";

    if($result_seTenkomaster['TENKOMASTERKA'] == 'เปลี่ยนกะกลางวัน')
    {
        $var_kaday = "<u>เปลี่ยนกะกลางวัน</u>";
        $var_kanight = "เปลี่ยนกะกลางคืน";
    }
    else
    {
        $var_kaday = "เปลี่ยนกะกลางคืน";
        $var_kanight = "<u>เปลี่ยนกะกลางคืน</u>";
    }
}
else
{
    $var_ka1 = "<u>ไม่เปลี่ยนกะ</u>";
    $var_ka2 = "เปลี่ยนกะ";
    $var_kaday = "เปลี่ยนกะกลางวัน";
    $var_kanight = "เปลี่ยนกะกลางคืน";
}
$table_headerDAY1 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>
    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkobefor['TENKOBEFOREDATE'] . '</th>
        <th colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">เอกสารเท็งโกะ</th>
        <th colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">Issue date 23 Jan 2017<br>          Toyota Transport (Thailand) Co.,LTD.</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th width="10%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">'.$var_ka1.'</th>
        <th width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">'.$var_kaday.'</th>
        <th width="10%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">'.$var_ka2.'</th>
        <th width="5%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">บริษัท</th>
        <th width="15%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTenkobefor['Company_NameT'] . '</th>
        <th width="5%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ชื่อพขร.</th>
        <th width="15%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seDir['nameT'] . '</th>
        <th width="10%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">หมายเลขรถ</th>
        <th width="20%" colspan="3" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOMASTERVEHICLE . '</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">'.$var_kanight.'</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="5" style="border-right:1px solid #000;padding:4px;text-align:left;">รายละเอียดงาน (เท็งโกะก่อนเริ่มงาน ข้อ 12.)</th>
        <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:left;">เป้าหมายการวิ่งงานวันนี้ (เท็งโกะก่อนเริ่มงาน ข้อ 16.)</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="5" style="border-right:1px solid #000;padding:4px;text-align:left;">'.$result_sePlain['JOBSTART'].'->'.$result_sePlain['JOBEND'].'</th>
        <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:left;"> </th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <th colspan="5" height="100" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkomaster['TENKOMASTERREMARKBEFORE'] . '</th>
        <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $TENKOTARGET1.'<br>'.$TENKOTARGET2.'<br>'.$TENKOTARGET3.'<br>'.$TENKOTARGET4.'<br>'.$TENKOTARGET5.'<br>'.$TENKOTARGET6.'<br>'.$TENKOTARGET7.'</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>';

$table_1DAY1 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
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
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ปรกติ</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ผิดปรกติ</th>
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
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;"> '. $result_seTenkobefor['TENKOBEFOREGREETREMARK'] . '</td>
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
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKORESTREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">5</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบชั่วโมงการนอนหลับ</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOSLEEPTIMECHECK . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;"><strong>การนอนปรกติ</strong><br>
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
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">บน : 90-140</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOPRESSUREDATA_90160'] . '</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOPRESSURERESULT1 . '</td>
        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOPRESSURERESULT0 . '</td>
        <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOPRESSUREREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ล่าง : 60-90</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOPRESSUREDATA_60100'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">อัตราการเต้นหัวใจ : 60-100</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOPRESSUREDATA_60110'] . '</td>
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
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ไม่มีหัวข้อผิดปรกติ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKODAILYTRAILERRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKODAILYTRAILERRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKODAILYTRAILERREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">11</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบของที่พกพา</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARRYCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">พก 3 ใบนี้ ใบขับขี่ - TLEP - Trailer</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARRYRESULT1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOCARRYRESULT0 . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seTenkobefor['TENKOCARRYREMARK'] . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">12</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจสอบรายละเอียดการทำงาน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $TENKOJOBDETAILCHECK . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">เข้าใจเส้นทาง - จุดพักรถ - รูปแบบการขับขี่ - ความสำคัญในการส่งรถ</td>
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
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">สามารถวิ่งงานได้ปรกติหรือไม่</td>
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
    </tbody></table>
';

$mpdf->WriteHTML($style);
 $mpdf->WriteHTML($table_headerDAY1);
$mpdf->WriteHTML($table_1DAY1);
$mpdf->Output();

sqlsrv_close($conn);
?>
