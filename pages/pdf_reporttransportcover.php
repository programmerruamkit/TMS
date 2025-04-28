<?php

date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
$sumgmtweight = "";
$sumcusweight = "";
$sumamounttrip = "";
$sumtotal = "";
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $date_now = "";
} else {
    $date_now = $_GET['datestart'] . ' ถึง ' . $_GET['dateend'];
}
$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);


$condBilling1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condBilling2 = "";

$sql_seBillings = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seBillings = array(
    array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
    array($condBilling1, SQLSRV_PARAM_IN),
    array($condBilling2, SQLSRV_PARAM_IN)
);
$query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
$result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC);

$condInvoice1 = " AND INVOICECODE = '" . $_GET['invoicecode'] . "'";
$condInvoice2 = "";
$sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
$params_seInvoice = array(
    array('select_loginvoice', SQLSRV_PARAM_IN),
    array($condInvoice1, SQLSRV_PARAM_IN),
    array($condInvoice2, SQLSRV_PARAM_IN)
);
$query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
$result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC);

$condduedate1 = " AND INVOICECODE = '" . $_GET['invoicecode'] . "'";
$condduedate2 = "";
$sql_seduedate = "{call megLoginvoice_v2(?,?,?)}";
$params_seduedate = array(
    array('select_duedate', SQLSRV_PARAM_IN),
    array($condduedate1, SQLSRV_PARAM_IN),
    array($condduedate2, SQLSRV_PARAM_IN)
);
$query_seduedate = sqlsrv_query($conn, $sql_seduedate, $params_seduedate);
$result_seduedate = sqlsrv_fetch_array($query_seduedate, SQLSRV_FETCH_ASSOC);
//$invoicecode = create_invoice();
////////////////////DATE/////////////////////////////////////
$date  = $_GET['datestart'];
$dateplit = explode("/", $date);
// echo $dateplit[0]; echo '<br>';
// echo $dateplit[1]; echo '<br>';
// echo $dateplit[2]; echo '<br>';
// $year=(date("Y")+543);
$year=($dateplit[2]+543);
// echo $year;
// echo $jobendsplit[3]; echo '<br>';

$mpdf = new mPDF('', 'Letter', '', '', 15, 15, 35, 5, 5, 3);
$style = '
<style>
	body{
		font-family: "angsana";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';

if ($_GET['companycode'] == 'RKS') {
  $table_header3 = '<table  style="border-collapse: collapse;margin-top:8px;font-size:14px" width="50%">
                <tr>
                  <td colspan="2" rowspan="4" style="text-align:center; "><img src="../images/logonew.png" width="70" height="70"></td>

                  <td colspan="8" style="font-size:20px" ><b>Delivery Summary For Van Truck <b></td>
                  <tr style="border:1px solid #000;padding:3px;">
                      <td     style="width: 20%;border:1px solid #000;padding:3px;text-align:center"><b>Date</b></td>
                      <td     style="width: 20%;border:1px solid #000;padding:3px;text-align:center"><b>Month</td>
                      <td     style="width: 20%;border:1px solid #000;padding:3px;text-align:center"><b>Year</td>
                      <td     style="width: 20%;border:1px solid #000;padding:3px;text-align:center"><b>Customer</b></td>
                      <td     style="width: 20%;border:1px solid #000;padding:3px;text-align:center"><b>Issued by</b></td>
                      <td     style="width: 25%;border:1px solid #000;padding:3px;text-align:center"><b>Checked by</b></td>
                  <tr>
                      <td     style="width: 20%;border:1px solid #000;padding:3px;text-align:center">'.$dateplit[0].'</td>
                      <td     style="width: 20%;border:1px solid #000;padding:3px;text-align:center">'.$dateplit[1].'</td>
                      <td     style="width: 20%;border:1px solid #000;padding:3px;text-align:center">'.$year.'</td>
                      <td     style="width: 20%;border:1px solid #000;padding:3px;text-align:center">'.$_GET['customercode'].'</td>
                      <td     style="width: 20%;border:1px solid #000;padding:3px;text-align:center"></td>
                      <td     style="width: 25%; border:1px solid #000;padding:3px;text-align:center"></td>
                  </tr>
              </tr>

              <tr>
                      
                  <tr>
                      <td     style="width: 25%;padding:3px;text-align:center"></td>
                  </tr>
              </tr>
        </table><br>';

  $table_begin3 = '<table   style="border-collapse: collapse;margin-top:8px;font-size:30px" width="100%">';
  
  if ($_GET['customercode'] == 'TAW') {
  $thead3 = '<thead>

            <tr>
              <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center;">NO</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
              <td     style="width: 20%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">DRIVER.1</td>
              <td     style="width: 25%;border:1px solid #000;padding:4px;text-align:center">DRIVER.2</td>
              <td     style="width: 35%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">TO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">ROUTE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">NORMAL</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">DO/PO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
            </tr>
      </thead><tbody>';
    }else if ($_GET['customercode'] == 'TGT' ) {
      $thead3 = '<thead>
    
                <tr>
                  <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center;">NO</td>
                  <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
                  <td     style="width: 20%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
                  <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">DRIVER.1</td>
                  <td     style="width: 25%;border:1px solid #000;padding:4px;text-align:center">DRIVER.2</td>
                  <td     style="width: 35%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
                  <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">TO</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
                  <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">ROUTE</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">NORMAL</td>
                  <td     style="width: 20%;border:1px solid #000;padding:4px;text-align:center">DO/PO</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
                </tr>
          </thead><tbody>';
        }else if ($_GET['customercode'] == 'HINO' ) {
          $thead3 = '<thead>
        
                    <tr>
                      <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center;">NO</td>
                      <td     style="width: 20%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
                      <td     style="width: 20%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
                      <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">DRIVER.1</td>
                      <td     style="width: 25%;border:1px solid #000;padding:4px;text-align:center">DRIVER.2</td>
                      <td     style="width: 50%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
                      <td     style="width: 50%;border:1px solid #000;padding:4px;text-align:center">TO</td>
                      <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
                      <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">ROUTE</td>
                      <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">NORMAL</td>
                      <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">DO/PO</td>
                      <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
                      <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
                    </tr>
              </thead><tbody>';
            }else if ($_GET['customercode'] == 'THAITOHKEN') {
          $thead3 = '<thead>
        
                    <tr>
                      <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center;">NO</td>
                      <td     style="width: 20%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
                      <td     style="width: 20%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
                      <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">DRIVER.1</td>
                      <td     style="width: 25%;border:1px solid #000;padding:4px;text-align:center">DRIVER.2</td>
                      <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
                      <td     style="width: 50%;border:1px solid #000;padding:4px;text-align:center">TO</td>
                      <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
                      <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">ROUTE</td>
                      <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">NORMAL</td>
                      <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">DO/PO</td>
                      <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
                      <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
                    </tr>
              </thead><tbody>';
        }else if ($_GET['customercode'] == 'COPPERCORD') {
          $thead3 = '<thead>
        
                    <tr>
                      <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center;">NO</td>
                      <td     style="width: 17%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
                      <td     style="width: 20%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
                      <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">DRIVER.1</td>
                      <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">DRIVER.2</td>
                      <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
                      <td     style="width: 35%;border:1px solid #000;padding:4px;text-align:center">TO</td>
                      <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
                      <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">ROUTE</td>
                      <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">NORMAL</td>
                      <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">DO/PO</td>
                      <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
                      <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
                    </tr>
              </thead><tbody>';
        }else if ($_GET['customercode'] == 'GMT') {
          $thead3 = '<thead>
        
                    <tr>
                      <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center;">NO</td>
                      <td     style="width: 20%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
                      <td     style="width: 25%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
                      <td     style="width: 35%;border:1px solid #000;padding:4px;text-align:center">DRIVER.1</td>
                      <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">DRIVER.2</td>
                      <td     style="width: 40%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
                      <td     style="width: 60%;border:1px solid #000;padding:4px;text-align:center">TO</td>
                      <td     style="width: 12%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
                      <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">ROUTE</td>
                      <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">NORMAL</td>
                      <td     style="width: 50%;border:1px solid #000;padding:4px;text-align:center">DO/PO</td>
                      <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
                      <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
                    </tr>
              </thead><tbody>';
        }else if ($_GET['customercode'] == 'TTTC') {
          $thead3 = '<thead>
        
                    <tr>
                      <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center;">NO</td>
                      <td     style="width: 17%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
                      <td     style="width: 20%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
                      <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">DRIVER.1</td>
                      <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">DRIVER.2</td>
                      <td     style="width: 40%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
                      <td     style="width: 35%;border:1px solid #000;padding:4px;text-align:center">TO</td>
                      <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
                      <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">ROUTE</td>
                      <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">NORMAL</td>
                      <td     style="width: 31%;border:1px solid #000;padding:4px;text-align:center">DO/PO</td>
                      <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
                      <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
                    </tr>
              </thead><tbody>';
      }else  if ($_GET['customercode'] == 'STM'){
      $thead3 = '<thead>

            <tr>
              <td     style="width: 8%;border:1px solid #000;padding:4px;text-align:center;">NO</td>
              <td     style="width: 20%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
              <td     style="width: 20%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
              <td     style="width: 35%;border:1px solid #000;padding:4px;text-align:center">DRIVER.1</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">DRIVER.2</td>
              <td     style="width: 35%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">TO</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
              <td     style="width: 25%;border:1px solid #000;padding:4px;text-align:center">ROUTE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">NORMAL</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">DO/PO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
            </tr>
      </thead><tbody>';
      
    }else  if ($_GET['customercode'] == 'DAIKI'){
      $thead3 = '<thead>

            <tr>
              <td     style="width: 8%;border:1px solid #000;padding:4px;text-align:center;">NO</td>
              <td     style="width: 20%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
              <td     style="width: 25%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
              <td     style="width: 35%;border:1px solid #000;padding:4px;text-align:center">DRIVER.1</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">DRIVER.2</td>
              <td     style="width: 35%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">TO</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
              <td     style="width: 25%;border:1px solid #000;padding:4px;text-align:center">ROUTE</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">NORMAL</td>
              <td     style="width: 20%;border:1px solid #000;padding:4px;text-align:center">DO/PO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
            </tr>
      </thead><tbody>';
      
    }else if ($_GET['customercode'] == 'TKT') {
      $thead3 = '<thead>
    
                <tr>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center;">NO1</td>
                  <td     style="width: 20%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
                  <td     style="width: 20%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
                  <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">DRIVER.1</td>
                  <td     style="width: 25%;border:1px solid #000;padding:4px;text-align:center">DRIVER.2</td>
                  <td     style="width: 50%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
                  <td     style="width: 50%;border:1px solid #000;padding:4px;text-align:center">TO</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
                  <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">ROUTE</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">NORMAL</td>
                  <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">DO/PO</td>
                  <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
                </tr>
          </thead><tbody>';
    }else if ($_GET['customercode'] == 'TSAT') {
      $thead3 = '<thead>
    
                <tr>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center;">NO1</td>
                  <td     style="width: 25%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
                  <td     style="width: 25%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
                  <td     style="width: 40%;border:1px solid #000;padding:4px;text-align:center">DRIVER.1</td>
                  <td     style="width: 25%;border:1px solid #000;padding:4px;text-align:center">DRIVER.2</td>
                  <td     style="width: 50%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
                  <td     style="width: 50%;border:1px solid #000;padding:4px;text-align:center">TO</td>
                  <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
                  <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">ROUTE</td>
                  <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">NORMAL</td>
                  <td     style="width: 40%;border:1px solid #000;padding:4px;text-align:center">DO/PO</td>
                  <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
                  <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
                </tr>
          </thead><tbody>';
    }else{
      $thead3 = '<thead>

            <tr>
              <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center;">NO</td>
              <td     style="width: 20%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
              <td     style="width: 20%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">DRIVER.1</td>
              <td     style="width: 25%;border:1px solid #000;padding:4px;text-align:center">DRIVER.2</td>
              <td     style="width: 35%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">TO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
              <td     style="width: 20%;border:1px solid #000;padding:4px;text-align:center">ROUTE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">NORMAL</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">DO/PO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
            </tr>
      </thead><tbody>';
      
    }
      $i = 1;

      if ($_GET['customercode'] == 'TMT') {
        $sql_seBilling = "SELECT b.JOBNO AS 'JOBNO',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
        a.EMPLOYEENAME2 AS 'EMP2',a.JOBSTART AS 'JOBSTART', a.JOBEND AS 'JOBEND',b.ROUNDAMOUNT AS 'ROUND'
        ,LEFT(b.ROUNDAMOUNT,PATINDEX('%[^0-9]%',b.ROUNDAMOUNT)-1) AS 'Numerics'
        FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
        LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID

        WHERE a.ACTIVESTATUS = 1
        AND a.COMPANYCODE='RKS' AND a.CUSTOMERCODE='TMT'
        AND a.DOCUMENTCODE IS NOT NULL
        AND a.DOCUMENTCODE !=''
        AND b.STATUSNUMBER !='X' AND STATUSNUMBER !='0'
        AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
        
        GROUP BY b.JOBNO,b.THAINAME,b.VEHICLETYPE,a.EMPLOYEENAME1,a.EMPLOYEENAME2, a.JOBSTART,a.JOBEND,b.ROUNDAMOUNT
        ORDER BY LEN(LEFT(b.ROUNDAMOUNT,PATINDEX('%[^0-9]%',b.ROUNDAMOUNT)-1)),Numerics ASC";
        $params_seBilling = array();
        $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
      }else if ($_GET['customercode'] == 'STM') {
        $sql_seBilling = "SELECT b.JOBNO AS 'JOBNO',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
        a.EMPLOYEENAME2 AS 'EMP2',a.JOBSTART AS 'JOBSTART', a.JOBEND AS 'JOBEND',b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
        c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
        ,b.VEHICLETRANSPORTPLANID AS 'PLANID',c.ROUTEDESCRIPTION AS 'DENSOTO',a.DOCUMENTCODE AS 'DOCUMENTCODE'
        ,SUBSTRING(b.ROUNDAMOUNT, 1, 3)  AS 'ROUND'
        FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
        LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID
        
        WHERE a.ACTIVESTATUS = 1
        AND a.COMPANYCODE='RKS' AND a.CUSTOMERCODE='STM'
        AND a.DOCUMENTCODE IS NOT NULL
        AND a.DOCUMENTCODE !=''
        AND b.STATUSNUMBER !='X' AND STATUSNUMBER !='0'
        AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
        
        ORDER BY JOBSTART,SUBSTRING(b.ROUNDAMOUNT, 3, 3) ASC";
        $params_seBilling = array();
        $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
      }else if ($_GET['customercode'] == 'TGT') {
        $sql_seBilling = "SELECT b.JOBNO AS 'JOBNO',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
        a.EMPLOYEENAME2 AS 'EMP2',a.JOBSTART AS 'JOBSTART', a.JOBEND AS 'JOBEND',b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
        c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
        ,b.VEHICLETRANSPORTPLANID AS 'PLANID',c.ROUTEDESCRIPTION AS 'DENSOTO',a.DOCUMENTCODE AS 'DOCUMENTCODE'

        FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
        LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID

        WHERE a.ACTIVESTATUS = 1
        AND a.COMPANYCODE='".$_GET['companycode']."' AND a.CUSTOMERCODE='".$_GET['customercode']."'
        AND a.DOCUMENTCODE IS NOT NULL
        AND a.DOCUMENTCODE !=''
        AND a.DOCUMENTCODE !='LOAD'
        AND b.STATUSNUMBER !='X' AND STATUSNUMBER !='0'
        AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
        
        ORDER BY a.DOCUMENTCODE ASC";
        $params_seBilling = array();
        $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
      }else {
        $sql_seBilling = "SELECT b.JOBNO AS 'JOBNO',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
        a.EMPLOYEENAME2 AS 'EMP2',a.JOBSTART AS 'JOBSTART', a.JOBEND AS 'JOBEND',b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
        c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
        ,b.VEHICLETRANSPORTPLANID AS 'PLANID',c.ROUTEDESCRIPTION AS 'DENSOTO',a.DOCUMENTCODE AS 'DOCUMENTCODE'

        FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
        LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID

        WHERE a.ACTIVESTATUS = 1
        AND a.COMPANYCODE='".$_GET['companycode']."' AND a.CUSTOMERCODE='".$_GET['customercode']."'
        AND a.DOCUMENTCODE IS NOT NULL
        AND a.DOCUMENTCODE !=''
        AND a.DOCUMENTCODE !='LOAD'
        AND b.STATUSNUMBER !='X' AND STATUSNUMBER !='0'
        AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
        
        ORDER BY a.EMPLOYEENAME1 ASC ";
        $params_seBilling = array();
        $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
      }
      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

      ////////////////////////////////////////////////////////////////////////////////////////////////
      if ($_GET['companycode'] == 'RKS' && $_GET['customercode'] == 'STM') {
        $sql_seTripamount = "SELECT LEFT(a.ROUNDAMOUNT,PATINDEX('%[^0-9]%',a.ROUNDAMOUNT)-1) AS 'TRIPAMOUNT'
                             , SUBSTRING(a.JOBSTART, 21, 4)  AS 'JOBSTART',SUBSTRING(a.ROUNDAMOUNT, 1, 3)  AS 'ROUND'

                             FROM [dbo].[VEHICLETRANSPORTPLAN] a
                             WHERE a.ROUNDAMOUNT IS NOT NULL AND a.VEHICLETRANSPORTPLANID = '" . $result_seBilling['PLANID'] . "'";
        $query_seTripamount = sqlsrv_query($conn, $sql_seTripamount, $params_seTripamount);
        $result_seTripamount = sqlsrv_fetch_array($query_seTripamount, SQLSRV_FETCH_ASSOC);
      }else {
        // code...
      }

         //////////FROM////////
        if ($_GET['companycode'] == 'RKS') {
            if ($_GET['customercode'] == 'TAW') {
              $jobstart ='STM';
            }else if ($_GET['customercode'] == 'STM') {
              $jobstart ='STM';
            }else if ($_GET['customercode'] == 'DAIKI') {
              $jobstart ='DAIKI';
            }else if ($_GET['customercode'] == 'TGT') {
              if ($result_seBilling['JOBSTART'] == 'TGT1 (Amatanakorn IE.)') {
                $jobstart = 'TGT#1';
              }else if ($result_seBilling['JOBSTART'] == 'TGT2 (Amatanakorn IE.)') {
                $jobstart = 'TGT#2';
              }else if ($result_seBilling['JOBSTART'] == 'TGT3 (Amatanakorn IE.)') {
                $jobstart = 'TGT#3';
              }else if ($result_seBilling['JOBSTART'] == 'TGT3+TGT1 (Amatanakorn IE.)') {
                $jobstart = 'TGT#3+1';
              }else if ($result_seBilling['JOBSTART'] == 'TGT2+TGT3 (Amatanakorn IE.)') {
                $jobstart = 'TGT#2+3';
              }else  {
                $jobstart = $result_seBilling['JOBSTART'];
              }

            }else if ($_GET['customercode'] == 'TMT') {
              $jobstart = 'TMT';
            }else if ($_GET['customercode'] == 'DENSO-THAI') {
              $jobstart = 'DITH';
            }else if ($_GET['customercode'] == 'SWN') {
              $jobstart = $result_seBilling['JOBSTART'];
            }else {
              $jobstart = $result_seBilling['JOBSTART'];
            }

        }else {
           $jobstart ='';
        }

         //////////TO////////
        if ($_GET['companycode'] == 'RKS') {
            if ($_GET['customercode'] == 'TAW') {
              $jobend = 'TAW';
            }else if ($_GET['customercode'] == 'STM') {
              $jobend = 'STM';
            }else if ($_GET['customercode'] == 'DAIKI') {
              $jobend = 'DITH-C(B1)';
            }else if ($_GET['customercode'] == 'TGT') {
              $jobend = $result_seBilling['JOBEND'];
            }else if ($_GET['customercode'] == 'TMT') {
              $jobend = 'TMT';
            }else if ($_GET['customercode'] == 'DENSO-THAI') {
              $jobend = $result_seBilling['DENSOTO'];
            }else {
              $jobend = $result_seBilling['JOBEND'];
            }
        }else {
            $jobend = '';
        }

        ////////UNIT////////
      if ($_GET['companycode'] == 'RKS') {
        if ($_GET['customercode'] == 'STM') {
          $unit = number_format($result_seTripamount['TRIPAMOUNT'],2);
        }else {
          $unit = '1.00';
        }
      }else {
          $unit = '';
        }

      /////////ROUTE/////////
        if ($_GET['companycode'] == 'RKS') {
          if ($_GET['customercode'] == 'STM') {
            if ($result_seBilling['JOBSTART'] == 'STM(F.1)->STM(F.2) (IP01)') {
              $route = 'IP-01/';
            }else if ($result_seBilling['JOBSTART'] == 'STM(F.1)->STM(F.2) (IP02)') {
              $route = 'IP-02/';
            }else if ($result_seBilling['JOBSTART'] == 'STM(F.1)->STM(F.2) (IP03)') {
              $route = 'IP-03/';
            }else if ($result_seBilling['JOBSTART'] == 'STM(F.1)->STM(F.2) (IP04)') {
              $route = 'IP-04/';
            }else if ($result_seBilling['JOBSTART'] == 'STM(F.1)->STM(F.2) (IP05)') {
              $route = 'IP-05/';
            }else if ($result_seBilling['JOBSTART'] == 'STM(F.1)->STM(F.2) (IP06)') {
              $route = 'IP-06/';
            }else {
              $route =  '';
            }
          }else if ($_GET['customercode'] == 'TGT') {
              $route = 'TGT';
          }else if ($_GET['customercode'] == 'DENSO-THAI') {
              $route = $result_seBilling['JOBSTART'];
          }else {
              $route = '';
            }
          }else {
            $route = '';
          }

         /////NORMAL////////// -->
          if ($_GET['companycode'] == 'RKS' && $_GET['customercode'] == 'DENSO-THAI') {
              $normal = $result_seBilling['JOBEND'];
          }else {
              $normal = '';
          }

           /////////DO/PO/////////
          if ($result_seBilling['JOBSTART']) {
            if ($_GET['customercode'] == 'TAW') {
              $dopo = substr($result_seBilling['DOCUMENTCODE'],1,7);
          }else if ($_GET['customercode'] == 'STM') {
              $dopo = 'วิรัช';
          }else if ($_GET['customercode'] == 'DAIKI') {
              $dopo = $result_seBilling['DOCUMENTCODE'];
          }else if ($_GET['customercode'] == 'TGT') {
              $dopo = $result_seBilling['DOCUMENTCODE'];
          }else {
              $dopo = $result_seBilling['DOCUMENTCODE'];
            }
          }else {
              $dopo = '';
          }

          ////////////VEHICLETYPE//////////////////
          if ($_GET['customercode'] == 'SWN') {
            $vihicletype = substr($result_seBilling['VEHICLETYPE'],0,8);
          }else{
            $vihicletype = $result_seBilling['VEHICLETYPE'];
          }

          // PRICE
          if ($_GET['customercode'] == 'SWN') {
            $price = $result_seBilling['PRICE'];
          }else if ($_GET['customercode'] == 'GMT') {
            $price = $result_seBilling['PRICE'];
          }else if ($_GET['customercode'] == 'THAITOHKEN') {
            $price = $result_seBilling['PRICE'];
          }else if ($_GET['customercode'] == 'COPPERCORD') {
            $price = $result_seBilling['PRICE'];
          }else{
            $price = '';
          }

      $tbody3 .= '<tr>
          <td    style="border:1px solid #000;padding:4px;text-align:center;font-size:30px" >'.$i.'</td>
          <td    style="border:1px solid #000;padding:4px;text-align:center;font-size:30px">'.$result_seBilling['THAINAME'].'</td>
          <td    style="border:1px solid #000;padding:4px;text-align:center;font-size:30px">'.$vihicletype.'</td>
          <td    style="border:1px solid #000;padding:4px;text-align:center;font-size:30px">'.$result_seBilling['EMP1'].'</td>
          <td    style="border:1px solid #000;padding:4px;text-align:center;font-size:30px">'.$result_seBilling['EMP2'].'</td>
          <td    style="border:1px solid #000;padding:4px;text-align:center;font-size:30px">'.$jobstart.'</td>
          <td    style="border:1px solid #000;padding:4px;text-align:center;font-size:30px">'.$jobend.'</td>
          <td    style="border:1px solid #000;padding:4px;text-align:center;font-size:30px">'.$unit.'</td>
          <td    style="border:1px solid #000;padding:4px;text-align:center;font-size:30px">'.$route.''.$result_seBilling['ROUND'].'</td>
          <td    style="border:1px solid #000;padding:4px;text-align:center;font-size:30px">'.$normal.'</td>
          <td    style="border:1px solid #000;padding:4px;text-align:center;font-size:30px">'.$dopo.'</td>
          <td    style="border:1px solid #000;padding:4px;text-align:center;font-size:30px">'.$price.'</td>
          <td    style="border:1px solid #000;padding:4px;text-align:center;font-size:30px"></td>

          </tr>
      ';
      $sumtrip = $sumtrip+$unit;
      $i++;
  }


  if ($_GET['companycode'] == 'RKS' && $_GET['customercode'] == 'STM') {
  $tfoot3 = '</tbody><tfoot>
      <tr>
        <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:30px"></td>
        <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:30px"></td>
        <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:30px"></td>
        <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:30px"></td>
        <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:30px"></td>
        <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:30px"></td>
        <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:30px"></td>
        <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:30px">'.$sumtrip.'</td>
        <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:30px"></td>
        <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:30px"></td>
        <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:30px"></td>
        <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:30px"></td>
        <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:30px"></td>
      </tr>
      </tfoot>';
  }else{
  $tfoot3 = '</tbody><tfoot>
      
      </tfoot>';
}

  $table_end3 = '</table>';

  $table_footer3 = '<table style="width: 100%;">
      <tbody>
      <tr>
      <td colspan="4">FM-OPS-RKS14/09 &nbsp;&nbsp;&nbsp; แก้ไขครั้งที่:04&nbsp;&nbsp;&nbsp;มีผลบังคับใช้:1-04-63</td>
      </tr>
      </tbody>
  </table>';

////////////////////RKR AND RKL/////////////////////////////////
}else {
  if ($_GET['customercode'] == 'TTASTSTC') {
    $headercus = "STC-".''.$_GET['companycode'];
  }else if ($_GET['customercode'] == 'TTASTCS') {
    $headercus = "TTAST-".''.$_GET['companycode'];
  }else {
    $headercus = $_GET['customercode'];
  }
  $table_header3 = '<table  style="border-collapse: collapse;margin-top:8px;font-size:14px" width="50%">
                  <tr>
                  <td colspan="1" rowspan="4" style="text-align:center"><img src="../images/logonew.png" width="70" height="70"></td>

                  <td colspan="10" style="font-size:20px" ><b>Delivery Summary For Open Truck <b></td>

                  <label><b>Delivery Summary For Open Truck</b></label>
                  <tr style="border:1px solid #000;padding:3px;">
                      <td     style="width: 20%;border:1px solid #000;padding:3px;text-align:center"><b>Date</b></td>
                      <td     style="width: 20%;border:1px solid #000;padding:3px;text-align:center"><b>Month</td>
                      <td     style="width: 20%;border:1px solid #000;padding:3px;text-align:center"><b>Year</td>
                      <td     style="width: 20%;border:1px solid #000;padding:3px;text-align:center"><b>Customer</b></td>
                      <td     style="width: 20%;border:1px solid #000;padding:3px;text-align:center"><b>Issued by</b></td>
                      <td     style="width: 25%;border:1px solid #000;padding:3px;text-align:center"><b>Checked by</b></td>
                  <tr>
                      <td     style="width: 20%;border:1px solid #000;padding:3px;text-align:center">'.$dateplit[0].'</td>
                      <td     style="width: 20%;border:1px solid #000;padding:3px;text-align:center">'.$dateplit[1].'</td>
                      <td     style="width: 20%;border:1px solid #000;padding:3px;text-align:center">'.$year.'</td>
                      <td     style="width: 20%;border:1px solid #000;padding:3px;text-align:center">'.$headercus.' </td>
                      <td     style="width: 20%;border:1px solid #000;padding:3px;text-align:center"></td>
                      <td     style="width: 25%; border:1px solid #000;padding:3px;text-align:center"></td>
                  </tr>
              </tr>

              <tr>
                      
                  <tr>
                      <td     style="width: 25%;padding:3px;text-align:center"></td>
                  </tr>
              </tr>
        </table><br>';
 if ($_GET['companycode'] == 'RKR' && $_GET['customercode'] == 'TTAST' && $_GET['carrytype'] == 'trip') {
  $table_begin3 = '<table   style="border-collapse: collapse;margin-top:8px;font-size:20px" width="100%">';
  $thead3 = '<thead>
            <tr>
              <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center">NO</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
              <td     style="width: 20%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">FIRSTDRIVER</td>
              <td     style="width: 20%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
              <td     style="width: 40%;border:1px solid #000;padding:4px;text-align:center">TO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">ZONE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">WEIGHT(TON)</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">CHARGE</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">ACTUAL</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
            </tr>
      </thead><tbody>';
 }else if($_GET['companycode'] == 'RKL' && $_GET['customercode'] == 'TTAST' && $_GET['carrytype'] == 'trip'){
  $table_begin3 = '<table   style="border-collapse: collapse;margin-top:8px;font-size:25px" width="100%">';
  $thead3 = '<thead>
            <tr>
              <td     style="width: 7%;border:1px solid #000;padding:4px;text-align:center">NO</td>
              <td     style="width: 16%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
              <td     style="width: 20%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">FIRSTDRIVER</td>
              <td     style="width: 40%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
              <td     style="width: 25%;border:1px solid #000;padding:4px;text-align:center">TO</td>
              <td     style="width: 25%;border:1px solid #000;padding:4px;text-align:center">ZONE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
              <td     style="width: 17%;border:1px solid #000;padding:4px;text-align:center">WEIGHT(TON)</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">CHARGE</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">ACTUAL</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
            </tr>
      </thead><tbody>';
 }else if($_GET['customercode'] == 'TTAST' && $_GET['carrytype'] == 'weight'){
  $table_begin3 = '<table   style="border-collapse: collapse;margin-top:8px;font-size:20px" width="100%">';
  $thead3 = '<thead>
            <tr>
              <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center">NO</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
              <td     style="width: 20%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">FIRSTDRIVER</td>
              <td     style="width: 25%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
              <td     style="width: 25%;border:1px solid #000;padding:4px;text-align:center">TO</td>
              <td     style="width: 25%;border:1px solid #000;padding:4px;text-align:center">ZONE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">WEIGHT(TON)</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">CHARGE</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">ACTUAL</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
            </tr>
      </thead><tbody>';
 }else if($_GET['companycode'] == 'RKR' && $_GET['customercode'] == 'TTASTSTC' && $_GET['carrytype'] == 'weight'){
  $table_begin3 = '<table   style="border-collapse: collapse;margin-top:8px;font-size:25px" width="100%">';
  $thead3 = '<thead>
            <tr>
              <td     style="width: 7%;border:1px solid #000;padding:4px;text-align:center">NO</td>
              <td     style="width: 16%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
              <td     style="width: 22%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">FIRSTDRIVER</td>
              <td     style="width: 40%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
              <td     style="width: 25%;border:1px solid #000;padding:4px;text-align:center">TO</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">ZONE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
              <td     style="width: 17%;border:1px solid #000;padding:4px;text-align:center">WEIGHT(TON)</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">CHARGE</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">ACTUAL</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
            </tr>
      </thead><tbody>';
 }else if ($_GET['customercode'] == 'COPPERCORD' && $_GET['carrytype'] == 'trip') {
  $table_begin3 = '<table   style="border-collapse: collapse;margin-top:8px;font-size:20px" width="100%">';
  $thead3 = '<thead>
            <tr>
              <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center">NO</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
              <td     style="width: 20%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">FIRSTDRIVER</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">TO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">ZONE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">WEIGHT(TON)</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">CHARGE</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">ACTUAL</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
            </tr>
      </thead><tbody>';
 }else if ($_GET['customercode'] == 'YNP' && $_GET['carrytype'] == 'trip') {
  $table_begin3 = '<table   style="border-collapse: collapse;margin-top:8px;font-size:20px" width="100%">';
  $thead3 = '<thead>
            <tr>
              <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center">NO</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">FIRSTDRIVER</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">TO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">ZONE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">WEIGHT(TON)</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">CHARGE</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">ACTUAL</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
            </tr>
      </thead><tbody>';
 }else if ($_GET['customercode'] == 'RNSTEEL' && $_GET['carrytype'] == 'trip') {
  $table_begin3 = '<table   style="border-collapse: collapse;margin-top:8px;font-size:20px" width="100%">';
  $thead3 = '<thead>
            <tr>
              <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center">NO</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">FIRSTDRIVER</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
              <td     style="width: 50%;border:1px solid #000;padding:4px;text-align:center">TO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">ZONE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">WEIGHT(TON)</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">CHARGE</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">ACTUAL</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
            </tr>
      </thead><tbody>';
 }else if ($_GET['customercode'] == 'VUTEQ' && $_GET['carrytype'] == 'trip') {
  $table_begin3 = '<table   style="border-collapse: collapse;margin-top:8px;font-size:20px" width="100%">';
  $thead3 = '<thead>
            <tr>
              <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center">NO</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">FIRSTDRIVER</td>
              <td     style="width: 40%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
              <td     style="width: 50%;border:1px solid #000;padding:4px;text-align:center">TO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">ZONE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">WEIGHT(TON)</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">CHARGE</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">ACTUAL</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
            </tr>
      </thead><tbody>';
 }else if ($_GET['customercode'] == 'PJW' && $_GET['carrytype'] == 'trip') {
  $table_begin3 = '<table   style="border-collapse: collapse;margin-top:8px;font-size:20px" width="100%">';
  $thead3 = '<thead>
            <tr>
              <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center">NO</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">FIRSTDRIVER</td>
              <td     style="width: 40%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
              <td     style="width: 50%;border:1px solid #000;padding:4px;text-align:center">TO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">ZONE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">WEIGHT(TON)</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">CHARGE</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">ACTUAL</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
            </tr>
      </thead><tbody>';
 }else if ($_GET['customercode'] == 'TGT' && $_GET['carrytype'] == 'trip') {
  $table_begin3 = '<table   style="border-collapse: collapse;margin-top:8px;font-size:20px" width="100%">';
  $thead3 = '<thead>
            <tr>
              <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center">NO</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">FIRSTDRIVER</td>
              <td     style="width: 40%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
              <td     style="width: 55%;border:1px solid #000;padding:4px;text-align:center">TO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">ZONE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">WEIGHT(TON)</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">CHARGE</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">ACTUAL</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
            </tr>
      </thead><tbody>';
 }else if($_GET['companycode'] == 'RKR' && $_GET['customercode'] == 'TTASTCS' && $_GET['carrytype'] == 'weight'){
  $table_begin3 = '<table   style="border-collapse: collapse;margin-top:8px;font-size:25px" width="100%">';
  $thead3 = '<thead>
            <tr>
              <td     style="width: 7%;border:1px solid #000;padding:4px;text-align:center">NO</td>
              <td     style="width: 16%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
              <td     style="width: 22%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
              <td     style="width: 33%;border:1px solid #000;padding:4px;text-align:center">FIRSTDRIVER</td>
              <td     style="width: 40%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
              <td     style="width: 25%;border:1px solid #000;padding:4px;text-align:center">TO</td>
              <td     style="width: 25%;border:1px solid #000;padding:4px;text-align:center">ZONE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
              <td     style="width: 17%;border:1px solid #000;padding:4px;text-align:center">WEIGHT(TON)</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">CHARGE</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">ACTUAL</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
            </tr>
      </thead><tbody>';
 }else if($_GET['companycode'] == 'RKL' && $_GET['customercode'] == 'TTASTCS' && $_GET['carrytype'] == 'weight'){
  $table_begin3 = '<table   style="border-collapse: collapse;margin-top:8px;font-size:25px" width="100%">';
  $thead3 = '<thead>
            <tr>
              <td     style="width: 7%;border:1px solid #000;padding:4px;text-align:center">NO</td>
              <td     style="width: 16%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
              <td     style="width: 22%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
              <td     style="width: 33%;border:1px solid #000;padding:4px;text-align:center">FIRSTDRIVER</td>
              <td     style="width: 40%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
              <td     style="width: 25%;border:1px solid #000;padding:4px;text-align:center">TO</td>
              <td     style="width: 25%;border:1px solid #000;padding:4px;text-align:center">ZONE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
              <td     style="width: 17%;border:1px solid #000;padding:4px;text-align:center">WEIGHT(TON)</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">CHARGE</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">ACTUAL</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
            </tr>
      </thead><tbody>';
 }else if($_GET['companycode'] == 'RKL' && $_GET['customercode'] == 'TKT' && $_GET['carrytype'] == 'trip'){
  $table_begin3 = '<table   style="border-collapse: collapse;margin-top:8px;font-size:25px" width="100%">';
  $thead3 = '<thead>
            <tr>
              <td     style="width: 7%;border:1px solid #000;padding:4px;text-align:center">NO</td>
              <td     style="width: 20%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
              <td     style="width: 25%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
              <td     style="width: 33%;border:1px solid #000;padding:4px;text-align:center">FIRSTDRIVER</td>
              <td     style="width: 40%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
              <td     style="width: 60%;border:1px solid #000;padding:4px;text-align:center">TO</td>
              <td     style="width: 25%;border:1px solid #000;padding:4px;text-align:center">ZONE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
              <td     style="width: 20%;border:1px solid #000;padding:4px;text-align:center">WEIGHT(TON)</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">CHARGE</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">ACTUAL</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
            </tr>
      </thead><tbody>';
 }else {
  $table_begin3 = '<table   style="border-collapse: collapse;margin-top:8px;font-size:25px" width="100%">';
  $thead3 = '<thead>
            <tr>
              <td     style="width: 7%;border:1px solid #000;padding:4px;text-align:center">NO</td>
              <td     style="width: 16%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
              <td     style="width: 22%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">FIRSTDRIVER</td>
              <td     style="width: 40%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">TO</td>
              <td     style="width: 30%;border:1px solid #000;padding:4px;text-align:center">ZONE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
              <td     style="width: 17%;border:1px solid #000;padding:4px;text-align:center">WEIGHT(TON)</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">CHARGE</td>
              <td     style="width: 15%;border:1px solid #000;padding:4px;text-align:center">ACTUAL</td>
              <td     style="width: 20%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
            </tr>
      </thead><tbody>';
 }
  

      $i = 1;
      if ($_GET['customercode'] == 'TTASTCS') {
        $customercode = 'TTASTCS';
        $jobstart = 'TTAST-CS';
      }else if($_GET['customercode'] == 'TTASTSTC'){
        $customercode = 'TTASTSTC';
        $jobstart = 'TTAST-STC';
      }else if ($_GET['customercode'] == 'ACSE') {
        $customercode = 'ACSE';
      }else if ($_GET['customercode'] == 'DAIKI') {
        $customercode = 'DAIKI';
      }else if ($_GET['customercode'] == 'GMT') {
        $customercode = 'GMT';
      }else if ($_GET['customercode'] == 'HINO') {
        $customercode = 'HINO';
      }else if ($_GET['customercode'] == 'NITTSU') {
        $customercode = 'NITTSU';
      }else if ($_GET['customercode'] == 'NITTSUSHOJI') {
        $customercode = 'NITTSUSHOJI';
      }else if ($_GET['customercode'] == 'PARAGON') {
        $customercode = 'PARAGON';
        $jobstart = 'STC';
      }else if ($_GET['customercode'] == 'SUTT') {
        $customercode = 'SUTT';
      }else if ($_GET['customercode'] == 'TDEM') {
        $customercode = 'TDEM';
      }else if ($_GET['customercode'] == 'TGT') {
        $customercode = 'TGT';
      }else if ($_GET['customercode'] == 'TID') {
        $customercode = 'TID';
      }else if ($_GET['customercode'] == 'TKT') {
        $customercode = 'TKT';
      }else if ($_GET['customercode'] == 'TMT') {
        $customercode = 'TMT';
      }else if ($_GET['customercode'] == 'TSPT') {
        $customercode = 'TSPT';
      }else if ($_GET['customercode'] == 'TTAST') {
        $customercode = 'TTAST';
      }else if ($_GET['customercode'] == 'TTASTCS') {
        $customercode = 'TTASTCS';
        $jobstart = 'TTAST-CS';
      }else if ($_GET['customercode'] == 'TTASTSTC') {
        $customercode = 'TTASTSTC';
      }else if ($_GET['customercode'] == 'TTAT') {
        $customercode = 'TTAT';
      }else if ($_GET['customercode'] == 'CH-AUTO') {
        $customercode = 'CH-AUTO';
      }else if ($_GET['customercode'] == 'TTPRO') {
        $customercode = 'TTPRO';
      }else if ($_GET['customercode'] == 'TTPROSTC') {
        $customercode = 'TTPROSTC';
        $jobstart = 'TTTC (Amatanakorn)';
      }else if ($_GET['customercode'] == 'TTTC') {
        $customercode = 'TTTC';
      }else if ($_GET['customercode'] == 'TTTCSTC') {
        $customercode = 'TTTCSTC';
      }else if ($_GET['customercode'] == 'YNP') {
        $customercode = 'YNP';
      }else if ($_GET['customercode'] == 'TSAT') {
        $customercode = 'TSAT';
      }else if ($_GET['customercode'] == 'OLT') {
        $customercode = 'OLT';
      }else if ($_GET['customercode'] == 'COPPERCORD') {
        $customercode = 'COPPERCORD';
      }else if ($_GET['customercode'] == 'RNSTEEL') {
        $customercode = 'RNSTEEL';
      }else if ($_GET['customercode'] == 'VUTEQ') {
        $customercode = 'VUTEQ';
      }else if ($_GET['customercode'] == 'PJW') {
        $customercode = 'PJW';
      }else {
        $customercode = '';
        $from  = '';
      }

      if ($_GET['customercode'] == 'TTASTCS' || $_GET['customercode'] == 'TTASTSTC' 
          || $_GET['customercode'] == 'PARAGON'|| $_GET['customercode'] == 'TTPROSTC') {
        $sql_seBilling = "SELECT b.JOBNO AS 'JOBNO',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
        a.JOBEND AS 'JOBEND',a.JOBSTART AS 'JOBSTART',b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
        c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
        ,SUM( CONVERT(INT, a.WEIGHTIN)) AS 'WEISUM',b.VEHICLETRANSPORTPLANID AS 'PLANID',c.CARRYTYPE,b.C8
        ,ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY b.VEHICLETRANSPORTPLANID) AS 'ROWNUM'

        FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
        LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID

        WHERE a.ACTIVESTATUS = 1
        AND a.COMPANYCODE='" .$_GET['companycode'] ."' AND a.CUSTOMERCODE='".$customercode."'
        AND b.JOBSTART ='".$jobstart."'
        AND a.DOCUMENTCODE IS NOT NULL
        AND a.DOCUMENTCODE !=''
        AND a.WEIGHTIN IS NOT NULL
        AND a.WEIGHTIN !=''
        AND a.WEIGHTIN !='0' AND a.WEIGHTIN !='-'
        AND b.STATUSNUMBER !='X' AND STATUSNUMBER !='0'
        AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
        
        GROUP BY b.JOBNO,b.THAINAME,b.VEHICLETYPE,a.EMPLOYEENAME1, a.JOBEND,a.JOBSTART,b.VEHICLETRANSPORTPRICEID,c.VEHICLETRANSPORTPRICEID
        ,c.[LOCATION],b.CLUSTER,c.PRICE,b.VEHICLETRANSPORTPLANID,c.CARRYTYPE,b.C8
        ORDER BY a.EMPLOYEENAME1,b.JOBNO ASC";
        $params_seBilling = array();
        $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
      }else if ($_GET['customercode'] == 'TTTCSTC') {
        $sql_seBilling = "SELECT b.JOBNO AS 'JOBNO',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
        a.JOBEND AS 'JOBEND',a.JOBSTART AS 'JOBSTART',b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
        c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
        ,SUM( CONVERT(INT, a.WEIGHTIN)) AS 'WEISUM',b.VEHICLETRANSPORTPLANID AS 'PLANID',c.CARRYTYPE
        ,ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY b.VEHICLETRANSPORTPLANID) AS 'ROWNUM'
        FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
        LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID

        WHERE a.ACTIVESTATUS = 1
        AND a.COMPANYCODE='".$_GET['companycode']."' AND a.CUSTOMERCODE='".$customercode."'
        AND a.DOCUMENTCODE IS NOT NULL
        AND a.DOCUMENTCODE !=''
        AND a.WEIGHTIN IS NOT NULL
        AND a.WEIGHTIN !=''
        AND a.WEIGHTIN !='0' AND a.WEIGHTIN !='-'
        AND b.STATUSNUMBER !='X' AND STATUSNUMBER !='0'
        AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
        
        GROUP BY b.JOBNO,b.THAINAME,b.VEHICLETYPE,a.EMPLOYEENAME1, a.JOBEND,a.JOBSTART,b.VEHICLETRANSPORTPRICEID,c.VEHICLETRANSPORTPRICEID
        ,c.[LOCATION],b.CLUSTER,c.PRICE,b.VEHICLETRANSPORTPLANID,c.CARRYTYPE
        ORDER BY a.EMPLOYEENAME1,b.JOBNO ASC";
        $params_seBilling = array();
        $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
      }else if ($_GET['customercode'] == 'TTAST' && $_GET['carrytype'] == 'weight') {
        // งาน TTAST Other Trip  งานต้นทาง KIT1,KIT2 น้ำหนักลงข้อมูลเป็นทศนิยม
        $sql_seBilling = "SELECT b.JOBNO AS 'JOBNO',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
        a.JOBEND AS 'JOBEND',a.JOBSTART AS 'JOBSTART',b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
        c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
        ,SUM( CONVERT(DECIMAL(18,3), a.WEIGHTIN)) AS 'WEISUM',b.VEHICLETRANSPORTPLANID AS 'PLANID',c.CARRYTYPE
        ,ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY b.VEHICLETRANSPORTPLANID) AS 'ROWNUM'
        FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
        LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID

        WHERE a.ACTIVESTATUS = 1
        AND a.COMPANYCODE='".$_GET['companycode']."' AND a.CUSTOMERCODE='".$customercode."'
        AND a.DOCUMENTCODE IS NOT NULL
        AND a.DOCUMENTCODE !=''
        AND a.WEIGHTIN IS NOT NULL
        AND a.WEIGHTIN !=''
        AND a.WEIGHTIN !='0' AND a.WEIGHTIN !='-'
        AND b.STATUSNUMBER !='X' AND STATUSNUMBER !='0'
        AND c.CARRYTYPE ='weight'
        AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
        
        GROUP BY b.JOBNO,b.THAINAME,b.VEHICLETYPE,a.EMPLOYEENAME1, a.JOBEND,a.JOBSTART,b.VEHICLETRANSPORTPRICEID,c.VEHICLETRANSPORTPRICEID
        ,c.[LOCATION],b.CLUSTER,c.PRICE,b.VEHICLETRANSPORTPLANID,c.CARRYTYPE
        ORDER BY a.EMPLOYEENAME1,b.JOBNO ASC";
        $params_seBilling = array();
        $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
      }else if ($_GET['customercode'] == 'TTAST' && $_GET['carrytype'] == 'trip') {
        $sql_seBilling = "SELECT b.JOBNO AS 'JOBNO',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
        a.JOBEND AS 'JOBEND',a.JOBSTART AS 'JOBSTART',b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
        c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
        ,SUM( CONVERT(INT, a.WEIGHTIN)) AS 'WEISUM',b.VEHICLETRANSPORTPLANID AS 'PLANID',c.CARRYTYPE
        ,ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY b.VEHICLETRANSPORTPLANID) AS 'ROWNUM'
        FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
        LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID

        WHERE a.ACTIVESTATUS = 1
        AND a.COMPANYCODE='".$_GET['companycode']."' AND a.CUSTOMERCODE='".$customercode."'
        AND a.DOCUMENTCODE IS NOT NULL
        AND a.DOCUMENTCODE !=''
        AND b.STATUSNUMBER !='X' AND STATUSNUMBER !='0'
        AND c.CARRYTYPE ='trip'
        AND b.WORKTYPE = 'other'
        AND a.WEIGHTIN NOT LIKE '%.%'
        AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
        
        GROUP BY b.JOBNO,b.THAINAME,b.VEHICLETYPE,a.EMPLOYEENAME1, a.JOBEND,a.JOBSTART,b.VEHICLETRANSPORTPRICEID,c.VEHICLETRANSPORTPRICEID
        ,c.[LOCATION],b.CLUSTER,c.PRICE,b.VEHICLETRANSPORTPLANID,c.CARRYTYPE
        ORDER BY a.EMPLOYEENAME1,b.JOBNO ASC";
        $params_seBilling = array();
        $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
      }else if ($_GET['customercode'] == 'VUTEQ' && $_GET['carrytype'] == 'trip') {
        $sql_seBilling = "SELECT b.JOBNO AS 'JOBNO',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
        a.JOBEND AS 'JOBEND',a.JOBSTART AS 'JOBSTART',b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
        c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
        ,SUM( CONVERT(INT, a.WEIGHTIN)) AS 'WEISUM',b.VEHICLETRANSPORTPLANID AS 'PLANID',c.CARRYTYPE
        ,ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY b.VEHICLETRANSPORTPLANID) AS 'ROWNUM'
        FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
        LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID

        WHERE a.ACTIVESTATUS = 1
        AND a.COMPANYCODE='".$_GET['companycode']."' AND a.CUSTOMERCODE='".$customercode."'
        AND a.DOCUMENTCODE IS NOT NULL
        AND a.DOCUMENTCODE !=''
        AND b.STATUSNUMBER !='X' AND STATUSNUMBER !='0'
        AND c.CARRYTYPE ='trip'
        AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
        
        GROUP BY b.JOBNO,b.THAINAME,b.VEHICLETYPE,a.EMPLOYEENAME1, a.JOBEND,a.JOBSTART,b.VEHICLETRANSPORTPRICEID,c.VEHICLETRANSPORTPRICEID
        ,c.[LOCATION],b.CLUSTER,c.PRICE,b.VEHICLETRANSPORTPLANID,c.CARRYTYPE
        ORDER BY a.EMPLOYEENAME1,b.JOBNO ASC";
        $params_seBilling = array();
        $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
      }else if ($_GET['customercode'] == 'PJW' && $_GET['carrytype'] == 'trip') {
        $sql_seBilling = "SELECT b.JOBNO AS 'JOBNO',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
        a.JOBEND AS 'JOBEND',a.JOBSTART AS 'JOBSTART',b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
        c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
        ,SUM( CONVERT(INT, a.WEIGHTIN)) AS 'WEISUM',b.VEHICLETRANSPORTPLANID AS 'PLANID',c.CARRYTYPE
        ,ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY b.VEHICLETRANSPORTPLANID) AS 'ROWNUM'
        FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
        LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID

        WHERE a.ACTIVESTATUS = 1
        AND a.COMPANYCODE='".$_GET['companycode']."' AND a.CUSTOMERCODE='".$customercode."'
        AND a.DOCUMENTCODE IS NOT NULL
        AND a.DOCUMENTCODE !=''
        AND b.STATUSNUMBER !='X' AND STATUSNUMBER !='0'
        AND c.CARRYTYPE ='trip'
        AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
        
        GROUP BY b.JOBNO,b.THAINAME,b.VEHICLETYPE,a.EMPLOYEENAME1, a.JOBEND,a.JOBSTART,b.VEHICLETRANSPORTPRICEID,c.VEHICLETRANSPORTPRICEID
        ,c.[LOCATION],b.CLUSTER,c.PRICE,b.VEHICLETRANSPORTPLANID,c.CARRYTYPE
        ORDER BY a.EMPLOYEENAME1,b.JOBNO ASC";
        $params_seBilling = array();
        $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
      }else if ($_GET['customercode'] == 'DAIKI' ) {
        $sql_seBilling = "SELECT b.JOBNO AS 'JOBNO',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
        a.JOBEND AS 'JOBEND',a.JOBSTART AS 'JOBSTART',b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
        c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
        ,SUM( CONVERT(INT, a.WEIGHTIN)) AS 'WEISUM',b.VEHICLETRANSPORTPLANID AS 'PLANID',c.CARRYTYPE
        ,ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY b.VEHICLETRANSPORTPLANID) AS 'ROWNUM'
        FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
        LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID

        WHERE a.ACTIVESTATUS = 1
        AND a.COMPANYCODE='".$_GET['companycode']."' AND a.CUSTOMERCODE='".$customercode."'
        AND a.DOCUMENTCODE IS NOT NULL
        AND a.DOCUMENTCODE !=''
        AND a.WEIGHTIN IS NOT NULL
        AND a.WEIGHTIN !=''
        AND a.WEIGHTIN !='0' AND a.WEIGHTIN !='-'
        AND b.STATUSNUMBER !='X' AND STATUSNUMBER !='0'
        AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
        
        GROUP BY b.JOBNO,b.THAINAME,b.VEHICLETYPE,a.EMPLOYEENAME1, a.JOBEND,a.JOBSTART,b.VEHICLETRANSPORTPRICEID,c.VEHICLETRANSPORTPRICEID
        ,c.[LOCATION],b.CLUSTER,c.PRICE,b.VEHICLETRANSPORTPLANID,c.CARRYTYPE
        ORDER BY a.EMPLOYEENAME1,b.JOBNO ASC";
        $params_seBilling = array();
        $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
      }else {
        $sql_seBilling = "SELECT b.JOBNO AS 'JOBNO',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
        a.JOBSTART AS 'JOBSTART',a.JOBEND AS 'JOBEND',b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
        c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
        ,SUM( CONVERT(INT, a.WEIGHTIN)) AS 'WEISUM',b.VEHICLETRANSPORTPLANID AS 'PLANID',c.CARRYTYPE
        ,ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY b.VEHICLETRANSPORTPLANID) AS 'ROWNUM'

        FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
        LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID

        WHERE a.ACTIVESTATUS = 1
        AND a.COMPANYCODE='" .$_GET['companycode'] ."' AND a.CUSTOMERCODE='".$customercode."'
        AND a.DOCUMENTCODE IS NOT NULL
        AND a.DOCUMENTCODE !=''
        -- AND a.WEIGHTIN IS NOT NULL
        -- AND a.WEIGHTIN !=''
        -- AND a.WEIGHTIN !='0' AND a.WEIGHTIN !='-'
        AND b.STATUSNUMBER !='X' AND STATUSNUMBER !='0'
        AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
        
        GROUP BY b.JOBNO,b.THAINAME,b.VEHICLETYPE,a.EMPLOYEENAME1, a.JOBEND, a.JOBSTART,b.VEHICLETRANSPORTPRICEID
        ,c.VEHICLETRANSPORTPRICEID,c.[LOCATION],b.CLUSTER,c.PRICE,b.VEHICLETRANSPORTPLANID,c.CARRYTYPE
        ORDER BY a.EMPLOYEENAME1,b.JOBNO ASC";
        $params_seBilling = array();
        $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
      }

      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

        ////////////ราคา/////////////
        if ($_GET['customercode'] == 'TTASTCS' || $_GET['customercode'] == 'TTASTSTC' 
            || $_GET['customercode'] == 'PARAGON'|| $_GET['customercode'] == 'TTPROSTC') {
          $sql_sePrice = "SELECT PRICE AS 'PRICEAC',[LOCATION] AS 'LOCATION' FROM [dbo].[VEHICLETRANSPORTPRICE] WHERE ACTIVESTATUS = 1
          AND COMPANYCODE='" . $_GET['companycode'] . "' AND CUSTOMERCODE='".$customercode."'
          AND PRICE IS NOT NULL AND [FROM]='".$jobstart."' AND [TO] = '" . $result_seBilling['JOBEND'] . "'
          AND CONVERT(DATE,GETDATE()) BETWEEN CONVERT(DATE,STARTDATE) AND CONVERT(DATE,ENDDATE)";
          $params_sePrice = array();
          $query_sePrice = sqlsrv_query($conn, $sql_sePrice, $params_sePrice);
          $result_sePrice = sqlsrv_fetch_array($query_sePrice, SQLSRV_FETCH_ASSOC);
        }else {
          $sql_sePrice = "SELECT PRICE AS 'PRICEAC',[LOCATION] AS 'LOCATION' FROM [dbo].[VEHICLETRANSPORTPRICE] WHERE ACTIVESTATUS = 1
          AND COMPANYCODE='" . $_GET['companycode'] . "' AND CUSTOMERCODE='".$customercode."'
          AND PRICE IS NOT NULL AND [FROM]='" . $result_seBilling['JOBSTART'] . "' AND [TO] = '" . $result_seBilling['JOBEND'] . "'
          AND CONVERT(DATE,GETDATE()) BETWEEN CONVERT(DATE,STARTDATE) AND CONVERT(DATE,ENDDATE)";
          $params_sePrice = array();
          $query_sePrice = sqlsrv_query($conn, $sql_sePrice, $params_sePrice);
          $result_sePrice = sqlsrv_fetch_array($query_sePrice, SQLSRV_FETCH_ASSOC);
        }

      /////////คิดชาท10,ชาท7,ไม่คิดขั้นต่ำ
      $sql_seID = "SELECT  DISTINCT REMARK, REMARKHEAD,JOBEND,VEHICLETRANSPORTPLANID FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER]
                   WHERE VEHICLETRANSPORTPLANID = '".$result_seBilling['PLANID']."'
                   AND  JOBEND ='".$result_seBilling['JOBEND']."'";
      $params_seID = array();
      $query_seID = sqlsrv_query($conn, $sql_seID, $params_seID);
      $result_seID = sqlsrv_fetch_array($query_seID, SQLSRV_FETCH_ASSOC);

      ///////////////LOCATION/////////////
      $sql_seLocation = "SELECT VEHICLETRANSPORTPRICEID,[LOCATION] AS 'LOCATION' ,[TO] AS 'JOBEND' FROM [dbo].[VEHICLETRANSPORTPRICE]
      WHERE [TO] ='".$result_seBilling['JOBEND']."'
      AND COMPANYCODE ='".$_GET['companycode']."' AND CUSTOMERCODE='".$customercode."'
      AND CONVERT(DATE,GETDATE()) BETWEEN CONVERT(DATE,STARTDATE,103) AND CONVERT(DATE,ENDDATE,103)";
      $params_seLocation = array();
      $query_seLocation = sqlsrv_query($conn, $sql_seLocation, $params_seLocation);
      $result_seLocation = sqlsrv_fetch_array($query_seLocation, SQLSRV_FETCH_ASSOC);

          ///////////////////////////////////////////
          if ($result_seBilling['C8'] == 'return') {
            $C8 = 'งานรับกลับ';
          }else {
            $C8 = '';
          }

          //   /////////////////////////////////ZONE////////////////////////////////////////////////////////////
                if ($result_seLocation['LOCATION'] == 'พระประแดง/สำโรง' || $result_seLocation['LOCATION'] == 'สำโรง') {
                  $zone ="Samrong";
                } else if ($result_seLocation['LOCATION'] == 'บางพลี') {
                  $zone ="Bangplee";
                } else if ($result_seLocation['LOCATION'] == 'เทพารักษ์') {
                  if ($result_seLocation['JOBEND'] == 'HINO2') {
                   $zone ="Bangplee";
                  }else {
                   $zone ="Thepharak";
                  }

                } else if ($result_seLocation['LOCATION'] == 'ลาดกระบัง') {
                  $zone ="Ladkrabang";
                } else if ($result_seLocation['LOCATION'] == 'บางประกง') {
                  if ($result_seLocation['JOBEND'] == 'REFORM') {
                    $zone ="Wellgrow";
                  }else if ($result_seLocation['JOBEND'] == 'TOY') {
                    $zone ="Banpho";
                  }else {
                    $zone ="Bang Pakong";
                  }

                } else if ($result_seLocation['LOCATION'] == 'บ้านโพธิ์') {

                    $zone ="Banpho";

                } else if ($result_seLocation['LOCATION'] == 'แปลงยาว' || $result_seLocation['LOCATION'] == 'PlaengYao') {
                  if ($result_seLocation['JOBEND'] == 'NB-WOOD') {
                    $zone ="Phanat Nikhom";

                  }else {
                    $zone ="Gateway";
                  }

                } else if ($result_seLocation['LOCATION'] == 'บ้านบึง') {
                  $zone ="Banbueng";
                } else if ($result_seLocation['LOCATION'] == 'ศรีราชา') {
                  $zone ="Sriracha";
                } else if ($result_seLocation['LOCATION'] == 'ปลวกแดง') {
                  if ($result_seLocation['JOBEND'] == 'AHT2' || $result_seLocation['JOBEND'] == 'BHKT' || $result_seLocation['JOBEND'] == 'TBFST' || $result_seLocation['JOBEND'] == 'TBFST(BOI)' || $result_seLocation['JOBEND'] == 'FTS1' || $result_seLocation['JOBEND'] == 'FTS2') {
                    $zone ="Eastern Seaboard IE.";
                  }else if($result_seLocation['JOBEND'] == 'ALS') {
                    $zone ="Borwin";
                  }else {
                    $zone ="Rayong";
                  }

                } else if ($result_seLocation['LOCATION'] == 'อมตะนคร') {
                  $zone ="Amata City Chonburi";
                } else if ($result_seLocation['LOCATION'] == 'บางปะอิน') {
                  $zone ="Ayutthaya";
                } else if ($result_seLocation['LOCATION'] == 'กระทุ่มแบน') {
                  $zone ="Samutsakorn";
                }else if ($result_seLocation['LOCATION'] == 'เทพารักษ์') {
                  $zone ="Samutsakorn";
                }else if ($result_seLocation['LOCATION'] == 'กบินบุรี') {
                  if ($result_seLocation['JOBEND'] == 'HISADA') {
                    $zone ="Prachin Buri";
                  }else {
                    $zone ="Kabinburi";
                  }

                }else if ($result_seLocation['LOCATION'] == 'บางบ่อ/บางพลี') {
                  if ($result_seLocation['JOBEND'] == 'SIMA') {
                    $zone ="Bangplee";
                  }else {
                    $zone ="Bang-bo";
                  }

                } else if ($result_seLocation['LOCATION'] == 'เมือง'){
                  if ($result_seLocation['JOBEND'] == 'SARATHORN' || $result_seLocation['JOBEND'] == 'SUNSTEEL') {
                    $zone = "Samutsakorn";
                  }else if($result_seLocation['JOBEND'] == 'KEIHIN') {
                    $zone = "Lamphun";
                  }else {
                    $zone = "Mueang";
                  }

                } else if($result_seLocation['LOCATION'] == 'เวลโกรว์' || $result_seLocation['LOCATION'] == 'เวลล์โกร์') {
                  $zone = "Wellgrow";
                } else if($result_seLocation['LOCATION'] == 'สุขสวัสดิ์') {
                  $zone = "Sooksawat";
                } else if($result_seLocation['LOCATION'] == 'หนองแค') {
                  $zone = "Saraburi";
                }else if($result_seLocation['LOCATION'] == 'แปลงยาว' || $result_seLocation['LOCATION'] == 'เกตเวย์' || $result_seLocation['LOCATION'] == 'PlaengYao') {
                  $zone = "Gateway";
                }else if($result_seLocation['LOCATION'] == 'ปู่เจ้า') {
                  $zone = "Poochao";
                }else if($result_seLocation['LOCATION'] == 'ปิ่นทอง') {
                  $zone = "Pinthong";
                }else if($result_seLocation['LOCATION'] == 'ปทุมธานี') {
                  $zone = "Pathum Thani";
                }else if($result_seLocation['LOCATION'] == 'อยุธยา') {
                  $zone = "Ayutthaya";
                }else if($result_seLocation['LOCATION'] == 'พนัสนิคม') { 
                  $zone = "Phanat Nikhom";
                }else if($result_seLocation['LOCATION'] == 'อีสเทิร์น ซีบอร์ด' || $result_seLocation['LOCATION'] == 'อีสเทิร์นซีบอร์ด') {
                  if ($result_seLocation['JOBEND'] == 'SSSC3' || $result_seLocation['JOBEND'] == 'SSSC3 : Easternseaboard') {
                    $zone = "Rayong";
                  }else {
                    $zone = "Eastern Seaboard IE.";
                  }
                }else if($result_seLocation['LOCATION'] == 'ประชาอุทิศ') { 
                  $zone = "Pracha Uthid";
                }else if($result_seLocation['LOCATION'] == 'แหลมฉบัง') { 
                  $zone = "Laemchabang";
                }else if($result_seLocation['LOCATION'] == 'บางปู') { 
                  $zone = "Bang Pu";
                }else {
                  $zone = $result_seLocation['LOCATION'];
                }

          //   ////////////////////////////////////////JOBEND///////////////////////////////////////////////
              if ($result_seBilling['JOBEND'] == 'TMB') {
                $jobend = "TMB";
              }else if ($result_seBilling['JOBEND'] == 'APIGO') {
                $jobend = "AAPICO";
              }else if ($result_seBilling['JOBEND'] == 'ASNO') {
                $jobend = "ASNO1";
              }else if ($result_seBilling['JOBEND'] == 'TBFST' || $result_seBilling['JOBEND'] == 'TBFST(BOI)') {
                $jobend = "TBFST";
              }else if ($result_seBilling['JOBEND'] == 'TYP') {
                $jobend = "TYP";
              }else if ($result_seBilling['JOBEND'] == 'WFAN/R.Y.') {
                $jobend = "WFAN/R.Y.";
              }else if ($result_seBilling['JOBEND'] == 'TMG') {
                $jobend = "TMG";
              }else if ($result_seBilling['JOBEND'] == 'SSSC-02') {
                $jobend = "SSSC-2";
              }else if ($result_seBilling['JOBEND'] == 'TABT/DMK') {
                $jobend = "DMK";
              }else if ($result_seBilling['JOBEND'] == 'TMS') {
                $jobend = "TMS";
              }else if ($result_seBilling['JOBEND'] == 'SUNSTEEL') {
                $jobend = "SUNSTEEL";
              }else if ($result_seBilling['JOBEND'] == 'SRP') {
                $jobend = "S.R-P";
              }else if ($result_seBilling['JOBEND'] == 'KIT2/KIT') {
                $jobend = "KIT";
              }else if ($result_seBilling['JOBEND'] == 'SHI/SHI2') {
                $jobend = "SHI(2)";
              }else if ($result_seBilling['JOBEND'] == 'SHIROKI' || $result_seBilling['JOBEND'] == 'SHIROKI(1)') {
                $jobend = "SHIROKI";
              }else if ($result_seBilling['JOBEND'] == 'YMPPD/BT') {
                $jobend = "BTD";
              }else if ($result_seBilling['JOBEND'] == 'TTAST-PT') {   ////////////TTASTCS(OTHER)(WEIGHT)
                $jobend = "TTAST-PT";
              }else if ($result_seBilling['JOBEND'] == 'JOZU : Teparak') {
                $jobend = "JOZU";
              }else if ($result_seBilling['JOBEND'] == 'KSC : Nakhonratchasima') {
                $jobend = "KSC";
              }else if ($result_seBilling['JOBEND'] == 'CPS : Amatanakorn') {
                $jobend = "CPS";
              }else if ($result_seBilling['JOBEND'] == 'DCL : Banbung') {
                $jobend = "DCL";
              }else if ($result_seBilling['JOBEND'] == 'AAA : BanPho') {
                $jobend = "AAA";
              }else if ($result_seBilling['JOBEND'] == 'NB WOOD') {
                $jobend = "NB WOOD";
              }else if ($result_seBilling['JOBEND'] == 'OTC : Ladkrabang') {
                $jobend = "OTC";
              }else if ($result_seBilling['JOBEND'] == 'SAM : Laemchabang') {
                $jobend = "SAM";
              }else if ($result_seBilling['JOBEND'] == 'TATP : Pathum Thani') {
                $jobend = "TATP";
              }else if ($result_seBilling['JOBEND'] == 'KTAC:Phanat Nikhom') {
                $jobend = "KTAC";
              }else if ($result_seBilling['JOBEND'] == 'SYM : Banbung') {
                $jobend = "SYM";
              }else if ($result_seBilling['JOBEND'] == 'TSK : Amatanakorn') {
                $jobend = "TSK";
              }else if ($result_seBilling['JOBEND'] == 'YAMATO : Sriracha') {
                $jobend = "YAMATO";
              }else if ($result_seBilling['JOBEND'] == 'YKT : Eastern Seaboard IE.') {
                $jobend = "YKT";
              }else if ($result_seBilling['JOBEND'] == 'YNPN1 : Bangplee') {
                $jobend = "YNPN1";
              }else if ($result_seBilling['JOBEND'] == 'YNPN2 : Bangplee') {
                $jobend = "YNPN2";
              }else if ($result_seBilling['JOBEND'] == 'YNPN3 : Banpho') {
                $jobend = "YNPN3";
              }else if ($result_seBilling['JOBEND'] == 'YS PUND : Wellgrow') {
                $jobend = "YS PUND";
              }else if ($result_seBilling['JOBEND'] == 'JSA : Pathum Thani') {
                $jobend = "JSA";
              }else if ($result_seBilling['JOBEND'] == 'KCP : Bangpakong') {
                $jobend = "KCP";
              }else if ($result_seBilling['JOBEND'] == 'Korawit : Teparak') {
                $jobend = "Korawit";
              }else if ($result_seBilling['JOBEND'] == 'TOKAI : Amatanakorn') {
                $jobend = "TOKAI";
              }else if ($result_seBilling['JOBEND'] == 'BVS : Banpho') {
                $jobend = "BVS";
              }else if ($result_seBilling['JOBEND'] == 'VCS : Banpho') {
                $jobend = "VCS";
              }else if ($result_seBilling['JOBEND'] == 'SARATHORN') {
                $jobend = "SARATHORN";
              }else if ($result_seBilling['JOBEND'] == 'THAI NIPPON : Laemchabang') {
                $jobend = "THAI NIPPON";
              }else if ($result_seBilling['JOBEND'] == 'VORASAK : Ayutthaya') {
                $jobend = "VORASAK";
              }else if ($result_seBilling['JOBEND'] == 'SSSC2 : Poochao') {
                $jobend = "SSSC2";
              }else if ($result_seBilling['JOBEND'] == 'KEIHIN : Lamphun') {
                $jobend = "KEIHIN";
              }else if ($result_seBilling['JOBEND'] == 'KTAC : Samutsakorn') {
                $jobend = "KTAC";
              }else if ($result_seBilling['JOBEND'] == 'MONOSTEEL') {
                $jobend = "MONOSTEEL";
              }else if ($result_seBilling['JOBEND'] == 'SSSC3 : Easternseaboard') {
                $jobend = "SSSC3";
              }else if ($result_seBilling['JOBEND'] == 'UCC2 : Amata') {
                $jobend = "UCC2";
              }else if ($result_seBilling['JOBEND'] == 'STC : Amatanakorn') {
                $jobend = "STC";
              }else if ($result_seBilling['JOBEND'] == 'STE : Wellgrow') {
                $jobend = "STE";
              }else if ($result_seBilling['JOBEND'] == 'WWGF1 : Bangplee') {
                $jobend = "WWG";
              }else if ($result_seBilling['JOBEND'] == 'KORAWIT : Teparak') {
                $jobend = "KORAWIT";
              }else {
                $jobend = $result_seBilling['JOBEND'];
              }

          //     //////////////////////CHARGE///////////////////////
              if($result_seBilling['CARRYTYPE'] != 'trip' && ($_GET['customercode'] != 'TSAT' || $_GET['customercode'] != 'TTAST' )){
                
                //เงื่อนไขเดิม
                // งาน KIT จะไม่ปัดเศษของทศนิยม
                if ($result_seBilling['JOBSTART'] =='KIT1' || $result_seBilling['JOBSTART'] =='KIT2') {
                  if ($result_seID['REMARK'] == 'Charge 10') {
                    $charge = (10.000-($result_seBilling['WEISUM']/1000));
                  } if ($result_seID['REMARK'] == 'Charge 7') {
                    $charge = (7.000-($result_seBilling['WEISUM']/1000));
                  } if ($result_seID['REMARK'] == 'ไม่คิดขั้นต่ำ') {
                    $charge = '0.000';
                  } if ($result_seID['REMARK'] == 'CHARGE 12') {
                    $charge = (12.000-($result_seBilling['WEISUM']/1000));
                  } if ($result_seID['REMARK'] == 'NOT CHARGE') {
                    $charge = '0.000';
                  }
                }else{
                  if ($result_seID['REMARK'] == 'Charge 10') {
                    $charge = number_format((10.000-($result_seBilling['WEISUM']/1000)),3);
                  } if ($result_seID['REMARK'] == 'Charge 7') {
                    $charge = number_format((7.000-($result_seBilling['WEISUM']/1000)),3);
                  } if ($result_seID['REMARK'] == 'ไม่คิดขั้นต่ำ') {
                    $charge = '0.000';
                  } if ($result_seID['REMARK'] == 'CHARGE 12') {
                    $charge = number_format((12.000-($result_seBilling['WEISUM']/1000)),3);
                  } if ($result_seID['REMARK'] == 'NOT CHARGE') {
                    $charge = '0.000';
                  }
                }
              }else{
                $charge = '';
             }  
          //     ////////////////////ACTUAL/////////////////////////////
              if($result_seBilling['CARRYTYPE'] != 'trip' && ($_GET['customercode'] != 'TSAT' || $_GET['customercode'] != 'TTAST' )){
                //เงื่อนไขเดิม
                // งาน KIT จะไม่ปัดเศษของทศนิยม
                if ($result_seBilling['JOBSTART'] =='KIT1' || $result_seBilling['JOBSTART'] =='KIT2') {
                  if ($result_seID['REMARK'] == 'Charge 10') {
                    $actual = '10.000';
                  } if ($result_seID['REMARK'] == 'Charge 7'){
                    $actual = '7.000';
                  } if ($result_seID['REMARK'] == 'ไม่คิดขั้นต่ำ') {
                    $actual = ($result_seBilling['WEISUM']/1000);
                  } if ($result_seID['REMARK'] == 'CHARGE 12') {
                    $actual = '12.000';
                  } if ($result_seID['REMARK'] == 'NOT CHARGE') {
                    $actual = ($result_seBilling['WEISUM']/1000);
                  }
                }else{
                  if ($result_seID['REMARK'] == 'Charge 10') {
                    $actual = '10.000';
                  } if ($result_seID['REMARK'] == 'Charge 7'){
                    $actual = '7.000';
                  } if ($result_seID['REMARK'] == 'ไม่คิดขั้นต่ำ') {
                    $actual = number_format(($result_seBilling['WEISUM']/1000),3);
                  } if ($result_seID['REMARK'] == 'CHARGE 12') {
                    $actual = '12.000';
                  } if ($result_seID['REMARK'] == 'NOT CHARGE') {
                    $actual = number_format(($result_seBilling['WEISUM']/1000),3);
                  }
                }
              }else{
                   $actual = '';
              }
          //     ////////////////////๊UNIT/////////////////////////////
              if($result_seBilling['CARRYTYPE'] != 'trip' && ($_GET['customercode'] != 'TSAT' || $_GET['customercode'] != 'TTAST' )){
                $unit = '';
              }else{
                $unit = '1';
              }
          //     ////////////////////๊WEIGHTIN/////////////////////////////
              if($result_seBilling['CARRYTYPE'] != 'trip' && ($_GET['customercode'] != 'TSAT' || $_GET['customercode'] != 'TTAST' )){
                if($result_seBilling['JOBSTART'] =='KIT1' || $result_seBilling['JOBSTART'] =='KIT2'){
                  $weightin = ($result_seBilling['WEISUM']/1000);
                }else{
                  $weightin = number_format(($result_seBilling['WEISUM']/1000),3);
                }
              }else{
                $weightin = '';
              }
          //     ////////////NO///////////////////////
              
              if ($result_seBilling['ROWNUM'] > 1) {
                $i--;
                $NO = '';
              }else {
                $NO = $i;
              }

              //////////////from งานนอก///////////////////////

              if ($_GET['customercode'] == 'TTASTCS') {
                $from = 'CS Wellgrow';
              }else if($_GET['customercode'] == 'TTASTSTC'){
                $from  = 'STC Amata City Chonburi';
              }else if ($_GET['customercode'] == 'ACSE') {
                $from  = 'ACSE';
              }else if ($_GET['customercode'] == 'DAIKI') {
                $from  = $result_seBilling['JOBSTART'];
              }else if ($_GET['customercode'] == 'GMT') {
                $from  = $result_seBilling['JOBSTART'];
              }else if ($_GET['customercode'] == 'HINO') {
                $from  = $result_seBilling['JOBSTART'];
              }else if ($_GET['customercode'] == 'NITTSU') {
                $from  = $result_seBilling['JOBSTART'];
              }else if ($_GET['customercode'] == 'NITTSUSHOJI') {
                $from  = $result_seBilling['JOBSTART'];
              }else if ($_GET['customercode'] == 'PARAGON') {
                $from  = $result_seBilling['JOBSTART'];
              }else if ($_GET['customercode'] == 'SUTT') {
                $from  = $result_seBilling['JOBSTART'];
              }else if ($_GET['customercode'] == 'TDEM') {
                $from  = $result_seBilling['JOBSTART'];
              }else if ($_GET['customercode'] == 'TGT') {
                $from  = $result_seBilling['JOBSTART'];
              }else if ($_GET['customercode'] == 'TID') {
                $from  = $result_seBilling['JOBSTART'];;
              }else if ($_GET['customercode'] == 'TKT') {
                $from  = $result_seBilling['JOBSTART'];
              }else if ($_GET['customercode'] == 'TMT') {
                $from  = $result_seBilling['JOBSTART'];
              }else if ($_GET['customercode'] == 'TSPT') {
                $from  = $result_seBilling['JOBSTART'];
              }else if ($_GET['customercode'] == 'TSAT') {
                $from  = $result_seBilling['JOBSTART'];
              }else if ($_GET['customercode'] == 'TTAST') {
                $from  = $result_seBilling['JOBSTART'];
              }else if ($_GET['customercode'] == 'TTAT') {
                $from  = $result_seBilling['JOBSTART'];
              }else if ($_GET['customercode'] == 'TTPRO') {
                $from  = 'TTPRO';
              }else if ($_GET['customercode'] == 'TTPROSTC') {
                $from  = 'TTPROSTC';
              }else if ($_GET['customercode'] == 'TTTC') {
                $from  = 'TTTC';
              }else if ($_GET['customercode'] == 'TTTCSTC') {
                $from  = 'TTTCSTC';
              }else if ($_GET['customercode'] == 'YNP') {
                $from  = $result_seBilling['JOBSTART'];
              }else if ($_GET['customercode'] == 'OLT') {
                $from  = $result_seBilling['JOBSTART'];
              }else if ($_GET['customercode'] == 'CH-AUTO') {
                $from  = $result_seBilling['JOBSTART'];
              }else if ($_GET['customercode'] == 'COPPERCORD') {
                $from  = $result_seBilling['JOBSTART'];
              }else if ($_GET['customercode'] == 'RNSTEEL') {
                $from  = $result_seBilling['JOBSTART'];
              }else if ($_GET['customercode'] == 'VUTEQ') {
                $from  = $result_seBilling['JOBSTART'];
              }else if ($_GET['customercode'] == 'PJW') {
                $from  = $result_seBilling['JOBSTART'];
              }else {
                $from  = '' ;
              }

              

      $tbody3 .= '<tr>
      <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:30px">'.$NO.'</td>
      <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:30px">'.$result_seBilling['THAINAME'].'</td>
      <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:30px">'.$result_seBilling['VEHICLETYPE'].'</td>
      <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:30px">'.$result_seBilling['EMP1'].'</td>
      <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:30px">'.$from.'</td>
      <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:30px">'.$jobend.'</td>
      <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:30px">'.$zone.'</td>
      <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:30px">'.$unit.'</td>
      <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:30px">'.$result_sePrice['PRICEAC'].'</td>
      <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:30px">'.$weightin.'</td>
      <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:30px">'.$charge.'</td>
      <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:30px">'.$actual.'</td>
      <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:30px">'.$C8.'</td>
      </tr>';
      $i++;
  }



  $tfoot3 = '</tbody><tfoot>
      
      </tfoot>';


  $table_end3 = '</table>';

  if ($_GET['companycode'] == 'RKS') {
    $table_footer3 = '<table style="width: 100%;">
        <tbody>
        <tr>
        <td colspan="4">FM-OPS-RKS14/09 &nbsp;&nbsp;&nbsp; แก้ไขครั้งที่:04&nbsp;&nbsp;&nbsp;มีผลบังคับใช้:01-04-63</td>
        </tr>
        </tbody>
    </table>';
  }else {
    $table_footer3 = '<br><br><table style="width: 100%;">
        <tbody>
        <tr>
        <td colspan="4">FM-OPS-06/01 &nbsp;&nbsp;&nbsp; แก้ไขครั้งที่:10&nbsp;&nbsp;&nbsp;มีผลบังคับใช้:01-04-63</td>
        </tr>
        </tbody>
    </table>';
  }


}




$mpdf->WriteHTML($style);
$mpdf->SetHTMLHeader($table_header3, 'O', true);
$mpdf->WriteHTML($table_begin3);
$mpdf->WriteHTML($thead3);
$mpdf->WriteHTML($tbody3);
$mpdf->WriteHTML($tfoot3);
$mpdf->WriteHTML($table_end3);
// $mpdf->WriteHTML($table_footer3);
$mpdf->SetHTMLFooter($table_footer3);
$mpdf->Output();


sqlsrv_close($conn);
?>
