<?php

require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
$sql_seGetdate = "{call megStopwork(?)}";
$params_seGetdate = array(
    array('se_getdate', SQLSRV_PARAM_IN)
);
$query_seGetdate = sqlsrv_query($conn, $sql_seGetdate, $params_seGetdate);
$result_seGetdate = sqlsrv_fetch_array($query_seGetdate, SQLSRV_FETCH_ASSOC);

$condition2 = "";
$condition3 = "";
$company = "";
if ($_GET['datestart'] != "" || $_GET['dateend'] != "") {
    $condition2 = " AND ( a.DATEINPUT BETWEEN convert(date, '" . $_GET['datestart'] . "', 103) AND convert(date, '" . $_GET['dateend'] . "', 103))";
}
if ($_GET['comp'] != "") {
    $COMP_IN = str_replace(",", "','", $_GET['comp']);
    $condition3 = " AND a.COMPANYCODE IN ('" . $COMP_IN . "')";
    $company = $_GET['comp'];
} else {
    $condition3 = " AND a.COMPANYCODE IN ('RATC','RCC','RIT','RKL','RKP','RKR','RKS','RTC','RTD')";
    $company = 'RATC,RCC,RIT,RKL,RKP,RKR,RKS,RTC,RTD';
}
$condition1 = $condition2.$condition3;

$mpdf = new mPDF();

$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';
$title = '<h5 style="text-align:center">สถิติการขอหยุดรถของบริษัท ' . $company . ' ตั้งแต่วันที่ ' . $_GET['datestart'] . ' ถึง ' . $_GET['dateend'] . '</h5>';
$table = 'สถิติการขอหยุดรถมากสุด
<table id="table1" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
    <tr style="border:1px solid #000;padding:4px;">
        <td colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;"><b>สถิติการขอหยุดมากสุด (ครั้ง)</b></td>
    </tr>  
    <tr style="border:1px solid #000;padding:4px;">
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"><b>ลำดับ</b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>ชื่อ-นามสกุล</b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>จำนวนครั้ง</b></td>
    </tr><tbody>';

$i1 = 1;
$sql_seCountstop = "{call megStopwork_v2(?,?)}";
$params_seCountstop = array(
    array("select_countstop", SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seCountstop = sqlsrv_query($conn, $sql_seCountstop, $params_seCountstop);
$query_seCountstop1 = sqlsrv_query($conn, $sql_seCountstop, $params_seCountstop);
$result_seCountstop1 = sqlsrv_fetch_array($query_seCountstop1, SQLSRV_FETCH_ASSOC);

if ($result_seCountstop1['EMPLOYEENAME'] != "") {
    while ($result_seCountstop = sqlsrv_fetch_array($query_seCountstop, SQLSRV_FETCH_ASSOC)) {

        $table .= '
    
    <tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $i1 . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seCountstop['EMPLOYEENAME'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seCountstop['y'] . '</td>

    </tr>
    ';
        $i1++;
    }
} else {
    $table .= '
    
    <tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>

    </tr>
    ';
}
$table .= '</tbody></table>
    <br>
        <table id="table2" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
            <tr style="border:1px solid #000;padding:4px;">
                <td colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;"><b>สถิติการขอหยุดมากสุด (เวลา)</b></td>
            </tr>  
            <tr style="border:1px solid #000;padding:4px;">
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"><b>ลำดับ</b></td>
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>ชื่อ-นามสกุล</b></td>
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>เวลา(นาที)</b></td>
            </tr>
            <tbody>';

$i2 = 1;
$sql_seStartstop = "{call megStopwork_v2(?,?)}";
$params_seStartstop = array(
    array("select_startstop", SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seStartstop = sqlsrv_query($conn, $sql_seStartstop, $params_seStartstop);
$query_seStartstop1 = sqlsrv_query($conn, $sql_seStartstop, $params_seStartstop);
$result_seStartstop1 = sqlsrv_fetch_array($query_seStartstop1, SQLSRV_FETCH_ASSOC);

if ($result_seStartstop1['EMPLOYEENAME'] != "") {
    while ($result_seStartstop = sqlsrv_fetch_array($query_seStartstop, SQLSRV_FETCH_ASSOC)) {
 $table .= '
    
            <tr style="border:1px solid #000;">
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $i2 . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seStartstop['EMPLOYEENAME'] . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seStartstop['y'] . '</td>

                </tr>';
        $i2++;
    }
}
else {
    $table .= '
    
    <tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>

    </tr>
    ';
}
$table .= '</tbody></table><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        กระบวนการ​หยุ​ด
<table id="table3" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
            <tr style="border:1px solid #000;padding:4px;">
                <td colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;"><b>กระบวนการหยุด</b></td>
            </tr>  
            <tr style="border:1px solid #000;padding:4px;">
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"><b>ลำดับ</b></td>
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>กระบวนการ</b></td>
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>ครั้ง</b></td>
            </tr>
            <tbody>';
$i3 = 1;

$sql_seProcessstop = "{call megGraph_v2(?,?)}";
$params_seProcessstop = array(
    array("select_processstop", SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seProcessstop = sqlsrv_query($conn, $sql_seProcessstop, $params_seProcessstop);
$query_seProcessstop1 = sqlsrv_query($conn, $sql_seProcessstop, $params_seProcessstop);
$result_seProcessstop1 = sqlsrv_fetch_array($query_seProcessstop1, SQLSRV_FETCH_ASSOC);

if ($result_seProcessstop1['STOPPROCESS'] != "") {
    while ($result_seProcessstop = sqlsrv_fetch_array($query_seProcessstop, SQLSRV_FETCH_ASSOC)) {
 $table .= '
    
            <tr style="border:1px solid #000;">
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $i3 . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seProcessstop['STOPPROCESS'] . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seProcessstop['CNT'] . '</td>

                </tr>';
        $i3++;
    }
}
else {
    $table .= '
    
    <tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>

    </tr>
    ';
}

$table .= '</tbody></table><br>
<table id="table4" width="50%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
            <tr style="border:1px solid #000;padding:4px;">
                <td colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;"><b>จ่ายงาน</b></td>
            </tr>  
            <tr style="border:1px solid #000;padding:4px;">
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"><b>ลำดับ</b></td>
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>กระบวนการ</b></td>
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>ครั้ง</b></td>
            </tr>
            <tbody>';
$i4 = 1;
$condition4 = " AND a.STOPPROCESS = 'จ่ายงาน'".$condition1;
$sql_sePaywork = "{call megGraph_v2(?,?)}";
$params_sePaywork = array(
    array("select_countstop", SQLSRV_PARAM_IN),
    array($condition4, SQLSRV_PARAM_IN)
);
$query_sePaywork = sqlsrv_query($conn, $sql_sePaywork, $params_sePaywork);
$query_sePaywork1 = sqlsrv_query($conn, $sql_sePaywork, $params_sePaywork);
$result_sePaywork1 = sqlsrv_fetch_array($query_sePaywork1, SQLSRV_FETCH_ASSOC);

if ($result_sePaywork1['STOPPROCESS'] != "") {
    while ($result_sePaywork = sqlsrv_fetch_array($query_sePaywork, SQLSRV_FETCH_ASSOC)) {
 $table .= '
    
            <tr style="border:1px solid #000;">
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $i4 . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_sePaywork['STOPPROCESS'] . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_sePaywork['CNT'] . '</td>

                </tr>';
        $i4++;
    }
}
else {
    $table .= '
    
    <tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>

    </tr>
    ';
}

$table .= '</tbody></table><br><table id="table5" width="50%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
            <tr style="border:1px solid #000;padding:4px;">
                <td colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;"><b>เท็งโก๊ะ</b></td>
            </tr>  
            <tr style="border:1px solid #000;padding:4px;">
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"><b>ลำดับ</b></td>
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>กระบวนการ</b></td>
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>ครั้ง</b></td>
            </tr>
            <tbody>';
$i5 = 1;
$condition5 = " AND a.STOPPROCESS = 'เท็งโก๊ะ'".$condition1;
$sql_seTenko = "{call megGraph_v2(?,?)}";
$params_seTenko = array(
    array("select_countstop", SQLSRV_PARAM_IN),
    array($condition5, SQLSRV_PARAM_IN)
);
$query_seTenko = sqlsrv_query($conn, $sql_seTenko, $params_seTenko);
$query_seTenko1 = sqlsrv_query($conn, $sql_seTenko, $params_seTenko);
$result_seTenko1 = sqlsrv_fetch_array($query_seTenko1, SQLSRV_FETCH_ASSOC);

if ($result_seTenko1['STOPPROCESS'] != "") {
    while ($result_seTenko = sqlsrv_fetch_array($query_seTenko, SQLSRV_FETCH_ASSOC)) {
 $table .= '
    
            <tr style="border:1px solid #000;">
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $i5 . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seTenko['STOPPROCESS'] . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seTenko['CNT'] . '</td>

                </tr>';
        $i5++;
    }
}
else {
    $table .= '
    
    <tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>

    </tr>
    ';
}

$table .= '</tbody></table><br><table id="table6" width="50%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
            <tr style="border:1px solid #000;padding:4px;">
                <td colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ขับรถ</b></td>
            </tr>  
            <tr style="border:1px solid #000;padding:4px;">
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"><b>ลำดับ</b></td>
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>กระบวนการ</b></td>
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>ครั้ง</b></td>
            </tr>
            <tbody>';
$i6 = 1;
$condition6 = " AND a.STOPPROCESS = 'ขับรถ'".$condition1;
$sql_seDirver = "{call megGraph_v2(?,?)}";
$params_seDirver = array(
    array("select_countstop", SQLSRV_PARAM_IN),
    array($condition6, SQLSRV_PARAM_IN)
);
$query_seDirver = sqlsrv_query($conn, $sql_seDirver, $params_seDirver);
$query_seDirver1 = sqlsrv_query($conn, $sql_seDirver, $params_seDirver);
$result_seDirver1 = sqlsrv_fetch_array($query_seDirver1, SQLSRV_FETCH_ASSOC);

if ($result_seDirver1['STOPPROCESS'] != "") {
    while ($result_seDirver = sqlsrv_fetch_array($query_seDirver, SQLSRV_FETCH_ASSOC)) {
 $table .= '
    
            <tr style="border:1px solid #000;">
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $i6 . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seDirver['STOPPROCESS'] . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seDirver['CNT'] . '</td>

                </tr>';
        $i6++;
    }
}
else {
    $table .= '
    
    <tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>

    </tr>
    ';
}

$table .= '</tbody></table><br><table id="table9" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
            <tr style="border:1px solid #000;padding:4px;">
                <td colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;"><b>เหตุผล</b></td>
            </tr>  
            <tr style="border:1px solid #000;padding:4px;">
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"><b>ลำดับ</b></td>
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>เหตุผล</b></td>
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>ครั้ง</b></td>
            </tr>
            <tbody>';
$i7 = 1;
$condition7 = "".$condition1;
$sql_seReason = "{call megGraph_v2(?,?)}";
$params_seReason = array(
    array("select_countreason", SQLSRV_PARAM_IN),
    array($condition7, SQLSRV_PARAM_IN)
);
$query_seReason = sqlsrv_query($conn, $sql_seReason, $params_seReason);
$query_seReason1 = sqlsrv_query($conn, $sql_seReason, $params_seReason);
$result_seReason1 = sqlsrv_fetch_array($query_seReason1, SQLSRV_FETCH_ASSOC);

if ($result_seReason1['REASON'] != "") {
    while ($result_seReason = sqlsrv_fetch_array($query_seReason, SQLSRV_FETCH_ASSOC)) {
 $table .= '
    
            <tr style="border:1px solid #000;">
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $i7 . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seReason['REASON'] . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seReason['CNT'] . '</td>

                </tr>';
        $i7++;
    }
}
else {
    $table .= '
    
    <tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>

    </tr>
    ';
}

$table .= '</tbody></table><br><table id="table6" width="50%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
            <tr style="border:1px solid #000;padding:4px;">
                <td colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ง่วง</b></td>
            </tr>  
            <tr style="border:1px solid #000;padding:4px;">
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"><b>ลำดับ</b></td>
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>ชื่อผู้ขับขี่</b></td>
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>ครั้ง</b></td>
            </tr>
            <tbody>';
$i8 = 1;
$condition8 = " AND a.REASON = 'ง่วง'".$condition2;
$sql_seDirvername1 = "{call megGraph_v2(?,?)}";
$params_seDirvername1 = array(
    array("select_dirvername", SQLSRV_PARAM_IN),
    array($condition8, SQLSRV_PARAM_IN)
);
$query_seDirvername1 = sqlsrv_query($conn, $sql_seDirvername1, $params_seDirvername1);
$query_seDirvername11 = sqlsrv_query($conn, $sql_seDirvername1, $params_seDirvername1);
$result_seDirvername11 = sqlsrv_fetch_array($query_seDirvername11, SQLSRV_FETCH_ASSOC);

if ($result_seDirvername11['NAME'] != "") {
    while ($result_seDirvername1 = sqlsrv_fetch_array($query_seDirvername1, SQLSRV_FETCH_ASSOC)) {
 $table .= '
    
            <tr style="border:1px solid #000;">
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $i8 . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seDirvername1['NAME'] . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seDirvername1['CNT'] . '</td>

                </tr>';
        $i8++;
    }
}
else {
    $table .= '
    
    <tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>

    </tr>
    ';
}

$table .= '</tbody></table><br><table id="table6" width="50%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
            <tr style="border:1px solid #000;padding:4px;">
                <td colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;"><b>กินยา</b></td>
            </tr>  
            <tr style="border:1px solid #000;padding:4px;">
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"><b>ลำดับ</b></td>
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>ชื่อผู้ขับขี่</b></td>
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>ครั้ง</b></td>
            </tr>
            <tbody>';
$i9 = 1;
$condition9 = " AND a.REASON = 'กินยา'".$condition1;
$sql_seDirvername2 = "{call megGraph_v2(?,?)}";
$params_seDirvername2 = array(
    array("select_dirvername", SQLSRV_PARAM_IN),
    array($condition9, SQLSRV_PARAM_IN)
);
$query_seDirvername2 = sqlsrv_query($conn, $sql_seDirvername2, $params_seDirvername2);
$query_seDirvername22 = sqlsrv_query($conn, $sql_seDirvername2, $params_seDirvername2);
$result_seDirvername22= sqlsrv_fetch_array($query_seDirvername22, SQLSRV_FETCH_ASSOC);

if ($result_seDirvername22['NAME'] != "") {
    while ($result_seDirvername2 = sqlsrv_fetch_array($query_seDirvername2, SQLSRV_FETCH_ASSOC)) {
 $table .= '
    
            <tr style="border:1px solid #000;">
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $i9 . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seDirvername2['NAME'] . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seDirvername2['CNT'] . '</td>

                </tr>';
        $i9++;
    }
}
else {
    $table .= '
    
    <tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>

    </tr>
    ';
}

$table .= '</tbody></table><br><table id="table6" width="50%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
            <tr style="border:1px solid #000;padding:4px;">
                <td colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ความดัน</b></td>
            </tr>  
            <tr style="border:1px solid #000;padding:4px;">
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"><b>ลำดับ</b></td>
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>ชื่อผู้ขับขี่</b></td>
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>ครั้ง</b></td>
            </tr>
            <tbody>';
$i10 = 1;
$condition10 = " AND a.REASON = 'ความดัน'".$condition1;
$sql_seDirvername3 = "{call megGraph_v2(?,?)}";
$params_seDirvername3 = array(
    array("select_dirvername", SQLSRV_PARAM_IN),
    array($condition10, SQLSRV_PARAM_IN)
);
$query_seDirvername3 = sqlsrv_query($conn, $sql_seDirvername3, $params_seDirvername3);
$query_seDirvername33 = sqlsrv_query($conn, $sql_seDirvername3, $params_seDirvername3);
$result_seDirvername33= sqlsrv_fetch_array($query_seDirvername33, SQLSRV_FETCH_ASSOC);

if ($result_seDirvername33['NAME'] != "") {
    while ($result_seDirvername3 = sqlsrv_fetch_array($query_seDirvername3, SQLSRV_FETCH_ASSOC)) {
 $table .= '
    
            <tr style="border:1px solid #000;">
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $i10 . '</td>3
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seDirvername3['NAME'] . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seDirvername3['CNT'] . '</td>

                </tr>';
        $i10++;
    }
}
else {
    $table .= '
    
    <tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>

    </tr>
    ';
}

$table .= '</tbody></table><br><table id="table6" width="50%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
            <tr style="border:1px solid #000;padding:4px;">
                <td colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;"><b>เป็นไข้</b></td>
            </tr>  
            <tr style="border:1px solid #000;padding:4px;">
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"><b>ลำดับ</b></td>
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>ชื่อผู้ขับขี่</b></td>
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>ครั้ง</b></td>
            </tr>
            <tbody>';
$i11 = 1;
$condition11 = " AND a.REASON = 'เป็นไข้'".$condition1;
$sql_seDirvername4 = "{call megGraph_v2(?,?)}";
$params_seDirvername4 = array(
    array("select_dirvername", SQLSRV_PARAM_IN),
    array($condition11, SQLSRV_PARAM_IN)
);
$query_seDirvername4 = sqlsrv_query($conn, $sql_seDirvername4, $params_seDirvername4);
$query_seDirvername44 = sqlsrv_query($conn, $sql_seDirvername4, $params_seDirvername4);
$result_seDirvername44= sqlsrv_fetch_array($query_seDirvername44, SQLSRV_FETCH_ASSOC);

if ($result_seDirvername44['NAME'] != "") {
    while ($result_seDirvername4 = sqlsrv_fetch_array($query_seDirvername4, SQLSRV_FETCH_ASSOC)) {
 $table .= '
    
            <tr style="border:1px solid #000;">
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $i11 . '</td>3
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seDirvername4['NAME'] . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seDirvername4['CNT'] . '</td>

                </tr>';
        $i11++;
    }
}
else {
    $table .= '
    
    <tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>

    </tr>
    ';
}

$table .= '</tbody></table><br><table id="table6" width="50%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
            <tr style="border:1px solid #000;padding:4px;">
                <td colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ทานข้าว</b></td>
            </tr>  
            <tr style="border:1px solid #000;padding:4px;">
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"><b>ลำดับ</b></td>
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>ชื่อผู้ขับขี่</b></td>
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>ครั้ง</b></td>
            </tr>
            <tbody>';
$i12 = 1;
$condition12 = " AND a.REASON = 'ทานข้าว'".$condition1;
$sql_seDirvername5 = "{call megGraph_v2(?,?)}";
$params_seDirvername5 = array(
    array("select_dirvername", SQLSRV_PARAM_IN),
    array($condition12, SQLSRV_PARAM_IN)
);
$query_seDirvername5 = sqlsrv_query($conn, $sql_seDirvername5, $params_seDirvername5);
$query_seDirvername55 = sqlsrv_query($conn, $sql_seDirvername5, $params_seDirvername5);
$result_seDirvername55= sqlsrv_fetch_array($query_seDirvername55, SQLSRV_FETCH_ASSOC);

if ($result_seDirvername55['NAME'] != "") {
    while ($result_seDirvername5 = sqlsrv_fetch_array($query_seDirvername5, SQLSRV_FETCH_ASSOC)) {
 $table .= '
    
            <tr style="border:1px solid #000;">
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $i12 . '</td>3
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seDirvername5['NAME'] . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seDirvername5['CNT'] . '</td>

                </tr>';
        $i12++;
    }
}
else {
    $table .= '
    
    <tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>

    </tr>
    ';
}

$table .= '</tbody></table><br><table id="table6" width="50%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
            <tr style="border:1px solid #000;padding:4px;">
                <td colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ซื้อของ</b></td>
            </tr>  
            <tr style="border:1px solid #000;padding:4px;">
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"><b>ลำดับ</b></td>
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>ชื่อผู้ขับขี่</b></td>
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>ครั้ง</b></td>
            </tr>
            <tbody>';
$i13 = 1;
$condition13 = " AND a.REASON = 'ซื้อของ'".$condition1;
$sql_seDirvername6 = "{call megGraph_v2(?,?)}";
$params_seDirvername6 = array(
    array("select_dirvername", SQLSRV_PARAM_IN),
    array($condition13, SQLSRV_PARAM_IN)
);
$query_seDirvername6 = sqlsrv_query($conn, $sql_seDirvername6, $params_seDirvername6);
$query_seDirvername66 = sqlsrv_query($conn, $sql_seDirvername6, $params_seDirvername6);
$result_seDirvername66= sqlsrv_fetch_array($query_seDirvername66, SQLSRV_FETCH_ASSOC);

if ($result_seDirvername66['NAME'] != "") {
    while ($result_seDirvername6 = sqlsrv_fetch_array($query_seDirvername6, SQLSRV_FETCH_ASSOC)) {
 $table .= '
    
            <tr style="border:1px solid #000;">
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $i13 . '</td>3
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seDirvername6['NAME'] . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seDirvername6['CNT'] . '</td>

                </tr>';
        $i13++;
    }
}
else {
    $table .= '
    
    <tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>

    </tr>
    ';
}

$table .= '</tbody></table><br><table id="table6" width="50%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
            <tr style="border:1px solid #000;padding:4px;">
                <td colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;"><b>เข้าห้องน้ำ</b></td>
            </tr>  
            <tr style="border:1px solid #000;padding:4px;">
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"><b>ลำดับ</b></td>
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>ชื่อผู้ขับขี่</b></td>
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>ครั้ง</b></td>
            </tr>
            <tbody>';
$i14 = 1;
$condition14 = " AND a.REASON = 'เข้าห้องน้ำ'".$condition1;
$sql_seDirvername7 = "{call megGraph_v2(?,?)}";
$params_seDirvername7 = array(
    array("select_dirvername", SQLSRV_PARAM_IN),
    array($condition14, SQLSRV_PARAM_IN)
);
$query_seDirvername7 = sqlsrv_query($conn, $sql_seDirvername7, $params_seDirvername7);
$query_seDirvername77= sqlsrv_query($conn, $sql_seDirvername7, $params_seDirvername7);
$result_seDirvername77= sqlsrv_fetch_array($query_seDirvername77, SQLSRV_FETCH_ASSOC);

if ($result_seDirvername55['NAME'] != "") {
    while ($result_seDirvername7 = sqlsrv_fetch_array($query_seDirvername7, SQLSRV_FETCH_ASSOC)) {
 $table .= '
    
            <tr style="border:1px solid #000;">
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $i14 . '</td>3
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seDirvername7['NAME'] . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seDirvername7['CNT'] . '</td>

                </tr>';
        $i14++;
    }
}
else {
    $table .= '
    
    <tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>

    </tr>
    ';
}

$table .= '</tbody></table><br><table id="table6" width="50%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
            <tr style="border:1px solid #000;padding:4px;">
                <td colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;"><b>อื่นๆ</b></td>
            </tr>  
            <tr style="border:1px solid #000;padding:4px;">
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"><b>ลำดับ</b></td>
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>ชื่อผู้ขับขี่</b></td>
                <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="45%"><b>ครั้ง</b></td>
            </tr>
            <tbody>';
$i15 = 1;
$condition15 = " AND a.REASON = 'อื่นๆ'".$condition1;
$sql_seDirvername8 = "{call megGraph_v2(?,?)}";
$params_seDirvername8 = array(
    array("select_dirvername", SQLSRV_PARAM_IN),
    array($condition15, SQLSRV_PARAM_IN)
);
$query_seDirvername8 = sqlsrv_query($conn, $sql_seDirvername8, $params_seDirvername8);
$query_seDirvername88= sqlsrv_query($conn, $sql_seDirvername8, $params_seDirvername8);
$result_seDirvername88= sqlsrv_fetch_array($query_seDirvername88, SQLSRV_FETCH_ASSOC);

if ($result_seDirvername55['NAME'] != "") {
    while ($result_seDirvername8 = sqlsrv_fetch_array($query_seDirvername8, SQLSRV_FETCH_ASSOC)) {
 $table .= '
    
            <tr style="border:1px solid #000;">
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $i15 . '</td>3
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seDirvername8['NAME'] . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seDirvername8['CNT'] . '</td>

                </tr>';
        $i15++;
    }
}
else {
    $table .= '
    
    <tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >Null</td>

    </tr>
    ';
}

$table .= '</tbody></table>';
$mpdf->WriteHTML($style);
$mpdf->WriteHTML($title);
$mpdf->WriteHTML($table);
$mpdf->Output();

sqlsrv_close($conn);
?>

