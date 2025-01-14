<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");
$sumtotal = "";



$sql_getDate = "{call megGetdate_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

$companyth = ($_GET['companycode'] == 'RCC') ? 'บริษัท  ร่วมกิจรุ่งเรือง คาร์ แคริเออร์  จำกัด' : 'บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต จำกัด';
$companyen = ($_GET['companycode'] == 'RCC') ? 'Ruamkit Rungrueng Car Carrier Co., Ltd.' : 'Ruamkit  Automotive Transport Co., Ltd.';
$strExcelFileName = "รายงานค่าเที่ยว(บริษัท)ประจำเดือน" . $_GET['datestart'] . ".xls";


$condition1 = "  AND a.PersonCode = '" . $_GET["employeecode"] . "'";
$sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmployee = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
$result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);



header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");
?>
<style>
    input.largerCheckbox {
        width: 20px;
        height: 20px;
    }
</style>

<!-- ////////////////////////////////////////////////10W/STC///////////////////////////////////////////////// -->

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <?= $companyth ?><br><?= $companyen ?>
        <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">
            <thead>
                <tr style="border:1px solid #000;" >
                    <td colspan="24" style="border-right:1px solid #000;padding:3px;text-align:center;">
                        <b>ค่าเบี้ยเลียงและค่าอาหารการทํางานนอกสถานที่</b>
                    </td>

                </tr>
                <tr style="border:1px solid #000;" >
                    <td colspan="24" style="border-right:1px solid #000;padding:3px;text-align:center;">
                        <b>รหัส : <?= $_GET['employeecode'] ?> | ชื่อ : <?= $result_seEmployee['nameT'] ?> | สายงาน : Transportation | เดือน/ปี : <?= $_GET['datestart'] ?></b>
                    </td>

                </tr>
                <tr style="border:1px solid #000;background-color: #ccc" >
                    <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                        <b>ลำดับ</b>
                    </td>
                    <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                        <b>JOBNO</b>
                    </td>
                    <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                        <b>วันที่</b>
                    </td>
                    <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                        <b>จากบริษัท</b>
                    </td>
                    <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
                        <b>ถึงบริษัท</b>
                    </td>

                    <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                        <b>ทะเบียนรถ</b>
                    </td>
                    <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                        <b>กิโลเมตรที่เริ่มไป</b>
                    </td>

                    <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                        <b>กิโลเมตรที่กลับถึง</b>
                    </td>
                    <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                        <b>รวมระยะ ทาง</b>
                    </td>
                    <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
                        <b>จํานวนลิตร</b>
                    </td>
                    <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                        <b>ค่าเฉลี่ย นํ้ามัน</b>
                    </td>
                    <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                        <b>ค่าน้ำมัน</b>
                    </td>
                    <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
                        <b>ยอดที่จ่าย จริง</b>
                    </td>

                    <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                        <b>ค่าตีเปล่า</b>
                    </td>
                    <td rowspan="2" collapse="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                        <b>ค่าซ่อม</b>
                    </td>
                    <td rowspan="2" collapse="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                        <b>ค่าใช้จ่ายอื่นๆ</b>
                    </td>
                    <td rowspan="2" collapse="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                        <b>ค่าเที่ยวเพิ่มเติม</b>
                    </td>
                    <td rowspan="2" collapse="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                        <b>OT</b>
                    </td>
                    <td rowspan="2" collapse="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                        <b>ค่าเที่ยว</b>
                    </td>
                    <td rowspan="2" collapse="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                        <b>รายได้อื่นๆ</b>
                    </td>
                    <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                        <b>ผู้อนุมัติ</b>
                    </td>
                    <td rowspan="2" collapse="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                        <b>หมายเหตุ</b>
                    </td>

                </tr>
                <tr style="border:1px solid #000;background-color: #ccc" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Tenko</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>สายงาน</b></td>
                </tr>

            </thead><tbody>

                <?php
                $i = 1;
                $sql_seEmp = "SELECT a.VEHICLETRANSPORTPLANID,a.E1,a.C3,a.COMPANYCODE,a.VEHICLETYPE,a.O1,a.O4,a.JOBNO,CONVERT(NVARCHAR(10),a.DATEDEALERIN,103) AS 'DATEDEALERIN',a.JOBSTART,a.JOBEND,a.THAINAME FROM [dbo].[VEHICLETRANSPORTPLAN] a
                WHERE (EMPLOYEECODE1 = '" . $_GET['employeecode'] . "' OR EMPLOYEECODE2 = '" . $_GET['employeecode'] . "') AND CONVERT(DATE,a.DATEDEALERIN,103) BETWEEN CONVERT(DATE,'01/" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $result_getDate['ENDMONTH'] . '/' . $_GET['datestart'] . "',103)
                ORDER BY a.DATEDEALERIN ASC";
                $params_seEmp = array();
                $query_seEmp = sqlsrv_query($conn, $sql_seEmp, $params_seEmp);
                while ($result_seEmp = sqlsrv_fetch_array($query_seEmp, SQLSRV_FETCH_ASSOC)) {
                    $sql_seMileagestart = "SELECT MAX([MILEAGENUMBER]) AS 'MILEAGENUMBER' FROM [dbo].[MILEAGE] WHERE JOBNO = '".$result_seEmp['JOBNO']."' AND MILEAGETYPE = 'MILEAGESTART'";
                    $params_seMileagestart = array();
                    $query_seMileagestart = sqlsrv_query($conn, $sql_seMileagestart, $params_seMileagestart);
                    $result_seMileagestart = sqlsrv_fetch_array($query_seMileagestart, SQLSRV_FETCH_ASSOC);
                    
                    $sql_seMileageend = "SELECT MAX([MILEAGENUMBER]) AS 'MILEAGENUMBER' FROM [dbo].[MILEAGE] WHERE JOBNO = '".$result_seEmp['JOBNO']."' AND MILEAGETYPE = 'MILEAGEEND'";
                    $params_seMileageend = array();
                    $query_seMileageend = sqlsrv_query($conn, $sql_seMileageend, $params_seMileageend);
                    $result_seMileageend = sqlsrv_fetch_array($query_seMileageend, SQLSRV_FETCH_ASSOC);
                    
                    $sql_seOilaverage = "SELECT TOP 1 OILAVERAGE FROM [dbo].[OILAVERAGE] WHERE [VEHICLETYPE] = '".$result_seEmp['VEHICLETYPE']."' AND COMPANYCODE = '".$result_seEmp['COMPANYCODE']."'";
                    $params_seOilaverage = array();
                    $query_seOilaverage = sqlsrv_query($conn, $sql_seOilaverage, $params_seOilaverage);
                    $result_seOilaverage = sqlsrv_fetch_array($query_seOilaverage, SQLSRV_FETCH_ASSOC);
                    
                    $sql_seTrandriver = "SELECT TOP 1 COMPENSATIONEMPTY1,PAY_REPAIR,PAY_OTHER,OTHER FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] 
                    WHERE [VEHICLETRANSPORTPLANID] = '".$result_seEmp['VEHICLETRANSPORTPLANID']."'";
                    $params_seTrandriver = array();
                    $query_seTrandriver = sqlsrv_query($conn, $sql_seTrandriver, $params_seTrandriver);
                    $result_seTrandriver = sqlsrv_fetch_array($query_seTrandriver, SQLSRV_FETCH_ASSOC);
                    if($result_seEmp['C3'] < 0)
                    {
                        $priceoiln = $result_seEmp['C3'];
                    }
                    else
                    {
                        $priceoilp = $result_seEmp['C3'];
                    } 
                    $E = ($result_seEmp['E1'] != '') ? $result_seEmp['E1'] : $result_seEmp['E2'];
                    ?>
                    <tr style="border:1px solid #000;" >
                        <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $i ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seEmp['JOBNO']?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$result_seEmp['DATEDEALERIN']?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$result_seEmp['JOBSTART']?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$result_seEmp['JOBEND']?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$result_seEmp['THAINAME']?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= number_format($result_seMileagestart['MILEAGENUMBER'])?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= number_format($result_seMileageend['MILEAGENUMBER'])?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= number_format($result_seMileageend['MILEAGENUMBER']-$result_seMileagestart['MILEAGENUMBER'])?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$result_seEmp['O4']?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$result_seOilaverage['OILAVERAGE']?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$priceoilp?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$priceoiln?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$result_seTrandriver['COMPENSATIONEMPTY1']?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$result_seTrandriver['PAY_REPAIR']?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$result_seTrandriver['PAY_OTHER']?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$result_seEmp['O1']?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$E?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$result_seTrandriver['OTHER']?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ></td>
                    </tr>
                    <?php
                    $i++;
                     $SUME = $SUME+$E;
                     $sumpriceoilp = $sumpriceoilp+$priceoilp;
                    $sumpriceoiln = $sumpriceoiln+$priceoiln;
                }
               
                ?>

            </tbody>
            <tfoot>
                <tr style="border:1px solid #000;" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="5"><b>ค่าน้ำมัน</b></td>

                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=number_format($sumpriceoilp)?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=number_format($sumpriceoiln)?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= number_format($SUME)?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ></td>
                </tr>
            </tfoot>
        </table>




    </body>
</html>
