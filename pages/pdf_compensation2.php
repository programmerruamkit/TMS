<?php

require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
//$mpdf = new mPDF();
$mpdf = new mPDF('th', 'A4-L', '0', '');
$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';
if ($_GET['emp'] == "") {
    $h2 = '<h5>เอกสารรายงานค่าตอบแทน ตั้งแต่วันที่ ' . $_GET['datestart'] . ' ถึงวันที่ ' . $_GET['dateend'] . '</h5>';
} else {
    $h2 = '<h5>เอกสารรายงานค่าตอบแทนของคุณ' . $_GET['emp'] . ' ตั้งแต่วันที่ ' . $_GET['datestart'] . ' ถึงวันที่ ' . $_GET['dateend'] . '</h5>';
}
$table_begin = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">';
$tr = '<tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%">รหัสพนักงาน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:20%">ชื่อ-นามสกุล</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%">วันที่</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:20%">เลข JOB</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%">ค่าเที่ยว</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%">ค่า OT</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%">ค่าอาหาร</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%">รถ 4 Load วิ่งมากว่า 3 Deler</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%">รถ 8 Load วิ่งมากว่า 4 Deler</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%">รถ 4 Load วิ่งมากว่า 1 Job</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%">รถ 4 Load (Metro) ค่าเที่ยวน้อยกว่า 300 บาท</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%">ทำงานวันหยุด(กลับก่อน 13:00)</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%">ทำงานวันหยุด(กลับหลัง 13:00)</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%">รายได้รวม</td>
    </tr>';
$condition1 = "";
$condition2 = "";
if ($_GET['emp'] != "") {
    $condition1 = " AND (a.EMPLOYEENAME1 = '" . $_GET['emp'] . "' OR a.EMPLOYEENAME2 = '" . $_GET['emp'] . "')";
    $condition2 = " AND ( CONVERT(DATE,a.DATEPRESENT) BETWEEN convert(date, '" . $_GET['datestart'] . "', 103) AND convert(date, '" . $_GET['dateend'] . "', 103))";
} else {
    $condition1 = "";
    $condition2 = " AND ( CONVERT(DATE,a.DATEPRESENT) BETWEEN convert(date, '" . $_GET['datestart'] . "', 103) AND convert(date, '" . $_GET['dateend'] . "', 103))";
}

$sumE1_1 = 0;
$sumE1_2 = 0;
$sumOT_1 = 0;
$sumOT_2 = 0;
$sumC9_1 = 0;
$sumC9_2 = 0;
$sum4L3DL_1 = 0;
$sum4L3DL_2 = 0;
$sum8L4DL_1 = 0;
$sum8L4DL_2 = 0;
$sum4L1JOB_1 = 0;
$sum4L1JOB_2 = 0;
$sum4L300_1 = 0;
$sum4L300_2 = 0;
$sumC5_1 = 0;
$sumC5_2 = 0;
$sumC6_1 = 0;
$sumC6_2 = 0;
$sum_1 = 0;
$sum_2 = 0;
$sql_seVehicletransportplan1 = "{call megVehicletransportplan_v2(?,?,?,?,?)}";
$params_seVehicletransportplan1 = array(
    array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN),
    array($condition2, SQLSRV_PARAM_IN),
    array("", SQLSRV_PARAM_IN),
    array("", SQLSRV_PARAM_IN)
);



$td = '';
$query_seVehicletransportplan1 = sqlsrv_query($conn, $sql_seVehicletransportplan1, $params_seVehicletransportplan1);
while ($result_seVehicletransportplan1 = sqlsrv_fetch_array($query_seVehicletransportplan1, SQLSRV_FETCH_ASSOC)) {

    $condi4L3DL = $result_seVehicletransportplan1['DATE_RETURNACTUAL'];
    $sql_se4L3DL = "{call megVehicletransportprice_v2(?,?)}";
    $params_se4L3DL = array(
        array('select_4L3DL', SQLSRV_PARAM_IN),
        array($condi4L3DL, SQLSRV_PARAM_IN)
    );
    $query_se4L3DL = sqlsrv_query($conn, $sql_se4L3DL, $params_se4L3DL);
    $result_se4L3DL = sqlsrv_fetch_array($query_se4L3DL, SQLSRV_FETCH_ASSOC);

    $condi8L4DL = $result_seVehicletransportplan1['DATE_RETURNACTUAL'];
    $sql_se8L4DL = "{call megVehicletransportprice_v2(?,?)}";
    $params_se8L4DL = array(
        array('select_8L4DL', SQLSRV_PARAM_IN),
        array($condi8L4DL, SQLSRV_PARAM_IN)
    );
    $query_se8L4DL = sqlsrv_query($conn, $sql_se8L4DL, $params_se8L4DL);
    $result_se8L4DL = sqlsrv_fetch_array($query_se8L4DL, SQLSRV_FETCH_ASSOC);

    $condi4L1JOB = $result_seVehicletransportplan1['DATE_RETURNACTUAL'];
    $sql_se4L1JOB = "{call megVehicletransportprice_v2(?,?)}";
    $params_se4L1JOB = array(
        array('select_4L1JOB', SQLSRV_PARAM_IN),
        array($condi4L1JOB, SQLSRV_PARAM_IN)
    );
    $query_se4L1JOB = sqlsrv_query($conn, $sql_se4L1JOB, $params_se4L1JOB);
    $result_se4L1JOB = sqlsrv_fetch_array($query_se4L1JOB, SQLSRV_FETCH_ASSOC);

    $condi4L300 = $result_seVehicletransportplan1['DATE_RETURNACTUAL'];
    $sql_se4L300 = "{call megVehicletransportprice_v2(?,?)}";
    $params_se4L300 = array(
        array('select_4L300', SQLSRV_PARAM_IN),
        array($condi4L3DL, SQLSRV_PARAM_IN)
    );
    $query_se4L300 = sqlsrv_query($conn, $sql_se4L300, $params_se4L300);
    $result_se4L300 = sqlsrv_fetch_array($query_se4L300, SQLSRV_FETCH_ASSOC);

    $E1 = "";
    if ($result_seEHR['PersonCode'] == $result_seVehicletransportplan1['EMPLOYEECODE1']) {
        $E1 = $result_seVehicletransportplan1['E1'];
    } else {
        $E1 = $result_seVehicletransportplan1['E2'];
    }


    $condcompany = " AND Company_Code ='" . $result_seVehicletransportplan1['COMPANYCODE'] . "'";
    $sql_seCompany = "{call megCompanyEHR_v2(?,?)}";
    $params_seCompany = array(
        array('select_company', SQLSRV_PARAM_IN),
        array($condcompany, SQLSRV_PARAM_IN)
    );
    $query_seCompany = sqlsrv_query($conn, $sql_seCompany, $params_seCompany);
    $result_seCompany = sqlsrv_fetch_array($query_seCompany, SQLSRV_FETCH_ASSOC);



    $sql_seCountholiday = "{call megHolidayEHR_v2(?,?,?,?)}";
    $params_seCountholiday = array(
        array('count_holiday', SQLSRV_PARAM_IN),
        array($result_seVehicletransportplan1['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
        array($result_seCompany['ID_Company'], SQLSRV_PARAM_IN),
        array($result_seVehicletransportplan1['DATEVLIN'], SQLSRV_PARAM_IN),
    );
    $query_seCountholiday = sqlsrv_query($conn, $sql_seCountholiday, $params_seCountholiday);
    $result_seCountholiday = sqlsrv_fetch_array($query_seCountholiday, SQLSRV_FETCH_ASSOC);

    $sql_seStartholiday = "{call megHolidayEHR_v2(?,?,?,?)}";
    $params_seStartholiday = array(
        array('start_holidaywork', SQLSRV_PARAM_IN),
        array($result_seVehicletransportplan1['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
        array($result_seCompany['ID_Company'], SQLSRV_PARAM_IN),
        array($result_seVehicletransportplan1['DATEVLIN'], SQLSRV_PARAM_IN),
    );
    $query_seStartholiday = sqlsrv_query($conn, $sql_seStartholiday, $params_seStartholiday);
    $result_seStartholiday = sqlsrv_fetch_array($query_seStartholiday, SQLSRV_FETCH_ASSOC);



    $sql_seBefore13holiday = "{call megHolidayEHR_v2(?,?,?,?)}";
    $params_seBefore13holiday = array(
        array('return_before13', SQLSRV_PARAM_IN),
        array($result_seVehicletransportplan1['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
        array($result_seCompany['ID_Company'], SQLSRV_PARAM_IN),
        array($result_seVehicletransportplan1['DATEVLIN'], SQLSRV_PARAM_IN),
    );
    $query_seBefore13holiday = sqlsrv_query($conn, $sql_seBefore13holiday, $params_seBefore13holiday);
    $result_seBefore13holiday = sqlsrv_fetch_array($query_seBefore13holiday, SQLSRV_FETCH_ASSOC);

    $sql_seAfter13holiday = "{call megHolidayEHR_v2(?,?,?,?)}";
    $params_seAfter13holiday = array(
        array('return_after13', SQLSRV_PARAM_IN),
        array($result_seVehicletransportplan1['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
        array($result_seCompany['ID_Company'], SQLSRV_PARAM_IN),
        array($result_seVehicletransportplan1['DATEVLIN'], SQLSRV_PARAM_IN),
    );
    $query_seAfter13holiday = sqlsrv_query($conn, $sql_seAfter13holiday, $params_seAfter13holiday);
    $result_seAfter13holiday = sqlsrv_fetch_array($query_seAfter13holiday, SQLSRV_FETCH_ASSOC);

    $conditionDN = " AND VEHICLETRANSPORTPLANID ='" . $result_seVehicletransportplan1['VEHICLETRANSPORTPLANID'] . "'";
    $sql_seDN = "{call megEditvehicletransportdocument_v2(?,?)}";
    $params_seDN = array(
        array('select_vehicletransportdocument', SQLSRV_PARAM_IN),
        array($conditionDN, SQLSRV_PARAM_IN)
    );
    $query_seDN = sqlsrv_query($conn, $sql_seDN, $params_seDN);
    $result_seDN = sqlsrv_fetch_array($query_seDN, SQLSRV_FETCH_ASSOC);
    $rsot = ($result_seDN['WARKINGSTOPINCOME'] == "" ? 1 : $result_seDN['WARKINGSTOPINCOME']);

    $sumincome = "";
    $ot = "";
    $befor13 = "";
    $affter13 = "";
    if ($result_seStartholiday['HOLIDAYWORK'] != '0') {
        $ot = (($result_seVehicletransportplan1['E1'] * $rsot) * 1.5) - $result_seVehicletransportplan1['E1'];
        if ($result_seBefore13holiday['HOLIDAYWORK'] != '0') {
            $sumincome = ($E1 + $ot + $result_seVehicletransportplan1['C9'] + $result_seVehicletransportplan1['C5']);
            $befor13 = $result_seVehicletransportplan1['C5'];
            $affter13 = "";
        } else if ($result_seAfter13holiday['HOLIDAYWORK'] != '0') {
            $sumincome = ($E1 + $ot + $result_seVehicletransportplan1['C9'] + $result_seVehicletransportplan1['C6']);
            $befor13 = "";
            $affter13 = $result_seVehicletransportplan1['C6'];
        }
    } else {
        //$sumincome = ($E1 + $C6 + $C9) * $rsot;
        //$ot = ($result_seVehicletransportplan1['E1'] * $rsot) - $result_seVehicletransportplan1['E1'];
        $ot = ($result_seVehicletransportplan1['E1'] - $result_seVehicletransportplan1['E1']);
        $sumincome = ($E1 + $result_seVehicletransportplan1['C9']);
    }
if($result_seVehicletransportplan1['EMPLOYEENAME1'] != "")
    {
    $td .= '<tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seVehicletransportplan1['EMPLOYEECODE1'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . $result_seVehicletransportplan1['EMPLOYEENAME1'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . $result_seVehicletransportplan1['DATE_PRESENT'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . $result_seVehicletransportplan1['JOBNO'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . $result_seVehicletransportplan1['E1'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . $ot . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . $result_seVehicletransportplan1['C9'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . $result_se4L300['CHKDATA'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . $result_se8L4DL['CHKDATA'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . $result_se4L1JOB['CHKDATA'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . $result_se4L300['CHKDATA'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . $befor13 . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . $affter13 . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . $sumincome . '</td>
    </tr>';
    }
    $sumE1_1 = $sumE1_1 + $result_seVehicletransportplan1['E1'];
    $sumOT_1 = $sumOT_1 + $ot;
    $sumC9_1 = $sumC9_1 + $result_seVehicletransportplan1['C9'];
    $sum4L3DL_1 = $sum4L3DL_1 + $result_se4L300['CHKDATA'];
    $sum8L4DL_1 = $sum8L4DL_1 + $result_se8L4DL['CHKDATA'];
    $sum4L1JOB_1 = $sum4L1JOB_1 + $result_se4L1JOB['CHKDATA'];
    $sum4L300_1 = $sum4L300_1 + $result_se4L300['CHKDATA'];
    $sumC5_1 = $sumC5_1 + $befor13;
    $sumC6_1 = $sumC6_1 + $affter13;
    $sum_1 = $sum_1 + $sumincome;
}

$sql_seVehicletransportplan2 = "{call megVehicletransportplan_v2(?,?,?,?,?)}";
$params_seVehicletransportplan2 = array(
    array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN),
    array($condition2, SQLSRV_PARAM_IN),
    array("", SQLSRV_PARAM_IN),
    array("", SQLSRV_PARAM_IN)
);



$query_seVehicletransportplan2 = sqlsrv_query($conn, $sql_seVehicletransportplan2, $params_seVehicletransportplan2);
while ($result_seVehicletransportplan2 = sqlsrv_fetch_array($query_seVehicletransportplan2, SQLSRV_FETCH_ASSOC)) {


    $condi4L3DL = $result_seVehicletransportplan2['DATE_RETURNACTUAL'];
    $sql_se4L3DL = "{call megVehicletransportprice_v2(?,?)}";
    $params_se4L3DL = array(
        array('select_4L3DL', SQLSRV_PARAM_IN),
        array($condi4L3DL, SQLSRV_PARAM_IN)
    );
    $query_se4L3DL = sqlsrv_query($conn, $sql_se4L3DL, $params_se4L3DL);
    $result_se4L3DL = sqlsrv_fetch_array($query_se4L3DL, SQLSRV_FETCH_ASSOC);

    $condi8L4DL = $result_seVehicletransportplan2['DATE_RETURNACTUAL'];
    $sql_se8L4DL = "{call megVehicletransportprice_v2(?,?)}";
    $params_se8L4DL = array(
        array('select_8L4DL', SQLSRV_PARAM_IN),
        array($condi8L4DL, SQLSRV_PARAM_IN)
    );
    $query_se8L4DL = sqlsrv_query($conn, $sql_se8L4DL, $params_se8L4DL);
    $result_se8L4DL = sqlsrv_fetch_array($query_se8L4DL, SQLSRV_FETCH_ASSOC);

    $condi4L1JOB = $result_seVehicletransportplan2['DATE_RETURNACTUAL'];
    $sql_se4L1JOB = "{call megVehicletransportprice_v2(?,?)}";
    $params_se4L1JOB = array(
        array('select_4L1JOB', SQLSRV_PARAM_IN),
        array($condi4L1JOB, SQLSRV_PARAM_IN)
    );
    $query_se4L1JOB = sqlsrv_query($conn, $sql_se4L1JOB, $params_se4L1JOB);
    $result_se4L1JOB = sqlsrv_fetch_array($query_se4L1JOB, SQLSRV_FETCH_ASSOC);

    $condi4L300 = $result_seVehicletransportplan2['DATE_RETURNACTUAL'];
    $sql_se4L300 = "{call megVehicletransportprice_v2(?,?)}";
    $params_se4L300 = array(
        array('select_4L300', SQLSRV_PARAM_IN),
        array($condi4L3DL, SQLSRV_PARAM_IN)
    );
    $query_se4L300 = sqlsrv_query($conn, $sql_se4L300, $params_se4L300);
    $result_se4L300 = sqlsrv_fetch_array($query_se4L300, SQLSRV_FETCH_ASSOC);



    $E1 = "";
    if ($result_seEHR['PersonCode'] == $result_seVehicletransportplan2['EMPLOYEECODE1']) {
        $E1 = $result_seVehicletransportplan2['E1'];
    } else {
        $E1 = $result_seVehicletransportplan2['E2'];
    }


    $condcompany = " AND Company_Code ='" . $result_seVehicletransportplan2['COMPANYCODE'] . "'";
    $sql_seCompany = "{call megCompanyEHR_v2(?,?)}";
    $params_seCompany = array(
        array('select_company', SQLSRV_PARAM_IN),
        array($condcompany, SQLSRV_PARAM_IN)
    );
    $query_seCompany = sqlsrv_query($conn, $sql_seCompany, $params_seCompany);
    $result_seCompany = sqlsrv_fetch_array($query_seCompany, SQLSRV_FETCH_ASSOC);



    $sql_seCountholiday = "{call megHolidayEHR_v2(?,?,?,?)}";
    $params_seCountholiday = array(
        array('count_holiday', SQLSRV_PARAM_IN),
        array($result_seVehicletransportplan2['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
        array($result_seCompany['ID_Company'], SQLSRV_PARAM_IN),
        array($result_seVehicletransportplan2['DATEVLIN'], SQLSRV_PARAM_IN),
    );
    $query_seCountholiday = sqlsrv_query($conn, $sql_seCountholiday, $params_seCountholiday);
    $result_seCountholiday = sqlsrv_fetch_array($query_seCountholiday, SQLSRV_FETCH_ASSOC);

    $sql_seStartholiday = "{call megHolidayEHR_v2(?,?,?,?)}";
    $params_seStartholiday = array(
        array('start_holidaywork', SQLSRV_PARAM_IN),
        array($result_seVehicletransportplan2['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
        array($result_seCompany['ID_Company'], SQLSRV_PARAM_IN),
        array($result_seVehicletransportplan2['DATEVLIN'], SQLSRV_PARAM_IN),
    );
    $query_seStartholiday = sqlsrv_query($conn, $sql_seStartholiday, $params_seStartholiday);
    $result_seStartholiday = sqlsrv_fetch_array($query_seStartholiday, SQLSRV_FETCH_ASSOC);



    $sql_seBefore13holiday = "{call megHolidayEHR_v2(?,?,?,?)}";
    $params_seBefore13holiday = array(
        array('return_before13', SQLSRV_PARAM_IN),
        array($result_seVehicletransportplan2['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
        array($result_seCompany['ID_Company'], SQLSRV_PARAM_IN),
        array($result_seVehicletransportplan2['DATEVLIN'], SQLSRV_PARAM_IN),
    );
    $query_seBefore13holiday = sqlsrv_query($conn, $sql_seBefore13holiday, $params_seBefore13holiday);
    $result_seBefore13holiday = sqlsrv_fetch_array($query_seBefore13holiday, SQLSRV_FETCH_ASSOC);

    $sql_seAfter13holiday = "{call megHolidayEHR_v2(?,?,?,?)}";
    $params_seAfter13holiday = array(
        array('return_after13', SQLSRV_PARAM_IN),
        array($result_seVehicletransportplan2['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
        array($result_seCompany['ID_Company'], SQLSRV_PARAM_IN),
        array($result_seVehicletransportplan2['DATEVLIN'], SQLSRV_PARAM_IN),
    );
    $query_seAfter13holiday = sqlsrv_query($conn, $sql_seAfter13holiday, $params_seAfter13holiday);
    $result_seAfter13holiday = sqlsrv_fetch_array($query_seAfter13holiday, SQLSRV_FETCH_ASSOC);

    $conditionDN = " AND VEHICLETRANSPORTPLANID ='" . $result_seVehicletransportplan2['VEHICLETRANSPORTPLANID'] . "'";
    $sql_seDN = "{call megEditvehicletransportdocument_v2(?,?)}";
    $params_seDN = array(
        array('select_vehicletransportdocument', SQLSRV_PARAM_IN),
        array($conditionDN, SQLSRV_PARAM_IN)
    );
    $query_seDN = sqlsrv_query($conn, $sql_seDN, $params_seDN);
    $result_seDN = sqlsrv_fetch_array($query_seDN, SQLSRV_FETCH_ASSOC);
    $rsot = ($result_seDN['WARKINGSTOPINCOME'] == "" ? 1 : $result_seDN['WARKINGSTOPINCOME']);

    $sumincome = "";
    $ot = "";
    $befor13 = "";
    $affter13 = "";
    if ($result_seStartholiday['HOLIDAYWORK'] != '0') {
        $ot = (($result_seVehicletransportplan2['E1'] * $rsot) * 1.5) - $result_seVehicletransportplan2['E1'];
        if ($result_seBefore13holiday['HOLIDAYWORK'] != '0') {
            $sumincome = ($E1 + $ot + $result_seVehicletransportplan2['C9'] + $result_seVehicletransportplan2['C5']);
            $befor13 = $result_seVehicletransportplan2['C5'];
            $affter13 = "";
        } else if ($result_seAfter13holiday['HOLIDAYWORK'] != '0') {
            $sumincome = ($E1 + $ot + $result_seVehicletransportplan2['C9'] + $result_seVehicletransportplan2['C6']);
            $befor13 = "";
            $affter13 = $result_seVehicletransportplan2['C6'];
        }
    } else {
        //$sumincome = ($E1 + $C6 + $C9) * $rsot;
        //$ot = ($result_seVehicletransportplan2['E1'] * $rsot) - $result_seVehicletransportplan2['E1'];
        $ot = ($result_seVehicletransportplan2['E1'] - $result_seVehicletransportplan2['E1']);
        $sumincome = ($E1 + $result_seVehicletransportplan2['C9']);
    }
if($result_seVehicletransportplan1['EMPLOYEENAME2'] != "")
    {
    $td .= '<tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seVehicletransportplan2['EMPLOYEECODE2'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . $result_seVehicletransportplan2['EMPLOYEENAME2'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . $result_seVehicletransportplan2['DATE_PRESENT'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . $result_seVehicletransportplan2['JOBNO'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . $result_seVehicletransportplan2['E1'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . $ot . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . $result_seVehicletransportplan2['C9'] . '</td>
               <td style="border-right:1px solid #000;padding:3px;" >' . $result_se4L300['CHKDATA'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . $result_se8L4DL['CHKDATA'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . $result_se4L1JOB['CHKDATA'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . $result_se4L300['CHKDATA'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . $befor13 . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . $affter13 . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . $sumincome . '</td>
    </tr>';
    }
    $sumE1_2 = $sumE1_2 + $result_seVehicletransportplan2['E1'];
    $sumOT_2 = $sumOT_2 + $ot;
    $sumC9_2 = $sumC9_2 + $result_seVehicletransportplan2['C9'];
    $sum4L3DL_2 = $sum4L3DL_2 + $result_se4L300['CHKDATA'];
    $sum8L4DL_2 = $sum8L4DL_2 + $result_se8L4DL['CHKDATA'];
    $sum4L1JOB_2 = $sum4L1JOB_2 + $result_se4L1JOB['CHKDATA'];
    $sum4L300_2 = $sum4L300_2 + $result_se4L300['CHKDATA'];
    $sumC5_2 = $sumC5_2 + $befor13;
    $sumC6_2= $sumC6_2 + $affter13;
    $sum_2 = $sum_2 + $sumincome;
}
$td .= '<tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
            <td style="border-right:1px solid #000;padding:3px;" >' . number_format(($sumE1_1 + $sumE1_2), 2) . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . number_format(($sumOT_1 + $sumOT_2), 2) . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . number_format(($sumC9_1 + $sumC9_2), 2) . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . number_format(($sum4L3DL_1 + $sum4L3DL_2), 2) . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . number_format(($sum8L4DL_1 + $sum8L4DL_2), 2) . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . number_format(($sum4L1JOB_1 + $sum4L1JOB_2), 2) . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . number_format(($sum4L300_1 + $sum4L300_2), 2) . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . number_format(($sumC5_1 + $sumC5_2), 2) . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . number_format(($sumC6_1 + $sumC6_2), 2) . '</td>
            <td style="border-right:1px solid #000;padding:3px;" >' . number_format(($sum_1 + $sum_2), 2) . '</td>
    </tr>';


$table_end = '</table>';
$mpdf->WriteHTML($style);
$mpdf->WriteHTML($h2);
$mpdf->WriteHTML($table_begin);
$mpdf->WriteHTML($tr);
$mpdf->WriteHTML($td);
$mpdf->WriteHTML($table_end);
$mpdf->Output();

sqlsrv_close($conn);
?>

