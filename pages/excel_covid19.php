<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $strExcelFileName = "รายงานตัวตรวจร่างกาย Covid 19.xls";
} else {
    $strExcelFileName = "รายงานตัวตรวจร่างกาย Covid 19" . $_GET['datestart'] . ' ถึง ' . $_GET['dateend'] . ".xls";
}
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
?>
<html>
    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <table border="1">
            <thead>
                <tr>
                    <th>บริษัท</th>
                    <th>ชื่อ-สกุล</th>
                    <th>อุณหภูมิ</th>
                    <th>ไอ/เจ็บคอ</th>
                    <th>มีน้ำมูก</th>
                    <th>หายใจเหนื่อยหอบ/หายใจลำบาก</th>
                    <th>รู้สึกไม่สบายตัว/คล้ายจะมึนหัว</th>
                    <th>วันที่</th>
                    <th>เวลา</th>
                    <th>ผู้ตรวจ</th>



                </tr>
            </thead>
            <tbody>
                <?php
                $condition1 = " AND CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE, '" . $_GET['datestart'] . "', 103) AND CONVERT(DATE, '" . $_GET['dateend'] . "', 103)";
                $condition2 = " AND COMPANYCODE != ''";
                $condition3 = "";



                $sql_seCovid19 = "{call megCovid19_v2(?,?,?,?)}";
                $params_seCovid19 = array(
                    array('select_covid19', SQLSRV_PARAM_IN),
                    array($condition1, SQLSRV_PARAM_IN),
                    array($condition2, SQLSRV_PARAM_IN),
                    array($condition3, SQLSRV_PARAM_IN)
                );

                $query_seCovid19 = sqlsrv_query($conn, $sql_seCovid19, $params_seCovid19);
                while ($result_seCovid19 = sqlsrv_fetch_array($query_seCovid19, SQLSRV_FETCH_ASSOC)) {
                    $condEmployeeehr = " AND a.PersonCode = '" . $result_seCovid19['EMPLOYEECODE'] . "'";
                    $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                    $params_seEmployeeehr = array(
                        array('select_employee', SQLSRV_PARAM_IN),
                        array($condEmployeeehr, SQLSRV_PARAM_IN)
                    );
                    $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                    $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);

                    $SYMPTOM1 = ($result_seCovid19['SYMPTOM1'] == '1') ? 'มี' : 'ไม่มี';
                    $SYMPTOM2 = ($result_seCovid19['SYMPTOM2'] == '1') ? 'มี' : 'ไม่มี';
                    $SYMPTOM3 = ($result_seCovid19['SYMPTOM3'] == '1') ? 'มี' : 'ไม่มี';
                    $SYMPTOM4 = ($result_seCovid19['SYMPTOM4'] == '1') ? 'มี' : 'ไม่มี';
                    ?>
                    <tr class="odd gradeX">
                        <td><?= $result_seCovid19['COMPANYCODE'] ?></td>
                        <td><?= $result_seEmployeeehr['nameT'] ?></td>
                        <td><?= $result_seCovid19['TEMPERATURE'] ?></td>
                        <td><?= $SYMPTOM1 ?></td>
                        <td><?= $SYMPTOM2 ?></td>
                        <td><?= $SYMPTOM3 ?></td>
                        <td><?= $SYMPTOM4 ?></td>
                        <td><?= $result_seCovid19['CREATEDATE'] ?></td>
                        <td><?= $result_seCovid19['CREATEธณ?ฎ'] ?></td>
                        <td><?= $result_seCovid19['REMARK'] ?></td>


                    </tr>
    <?php
}
?>

            </tbody>
        </table>
    </body>
</html>