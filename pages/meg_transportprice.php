
<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

/* $condition1 = " AND COMPANYID = " . $_GET['companyid'];
  $sql_seCompany = "{call megCompany_v2(?,?)}";
  $params_seCompany = array(
  array('select_company', SQLSRV_PARAM_IN),
  array($condition1, SQLSRV_PARAM_IN)
  );
  $query_seCompany = sqlsrv_query($conn, $sql_seCompany, $params_seCompany);
  $result_seCompany = sqlsrv_fetch_array($query_seCompany, SQLSRV_FETCH_ASSOC);

  $condition1 = " AND CUSTOMERID = " . $_GET['customerid'];
  $sql_seCustomer = "{call megCustomer_v2(?,?)}";
  $params_seCustomer = array(
  array('select_customer', SQLSRV_PARAM_IN),
  array($condition1, SQLSRV_PARAM_IN)
  );
  $query_seCustomer = sqlsrv_query($conn, $sql_seCustomer, $params_seCustomer);
  $result_seCustomer = sqlsrv_fetch_array($query_seCustomer, SQLSRV_FETCH_ASSOC);
 */
$condition1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
$sql_seVehicledesc = "{call megVehicledesc_v2(?,?)}";
$params_seVehicledesc = array(
    array('select_vehicledesc', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seVehicledesc = sqlsrv_query($conn, $sql_seVehicledesc, $params_seVehicledesc);
$result_seVehicledesc = sqlsrv_fetch_array($query_seVehicledesc, SQLSRV_FETCH_ASSOC);

$condComp = " AND Company_Code = '" . $_GET['companycode'] . "'";
$sql_seComp = "{call megCompanyEHR_v2(?,?)}";
$params_seComp = array(
    array('select_company', SQLSRV_PARAM_IN),
    array($condComp, SQLSRV_PARAM_IN)
);
$query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
$result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC);

$condiCustomer = " AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "'";
$sql_seCustomer = "{call megCustomer_v2(?,?)}";
$params_seCustomer = array(
    array('select_customer', SQLSRV_PARAM_IN),
    array($condiCustomer, SQLSRV_PARAM_IN)
);
$query_seCustomer = sqlsrv_query($conn, $sql_seCustomer, $params_seCustomer);
$result_seCustomer = sqlsrv_fetch_array($query_seCustomer, SQLSRV_FETCH_ASSOC);
?>

<html lang="en">

    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>กลุ่มร่วมกิจรุ่งเรือง</title>
        <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
        <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <!--<link href="../dist/css/sb-admin-2.css" rel="stylesheet">-->
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
        <script>
            $(function () {
                $('[data-toggle="popover"]').popover({
                    html: true,
                    content: function () {
                        return $('#popover-content').html();
                    }
                });
            })
        </script>

        <style>

            .navbar-default {

                border-color: #ffcb0b;
            }
            #page-wrapper {

                border-left: 1px solid #ffcb0b;
            }
            .popover-content {
                padding: 10px 10px;
                width: 200px;
            }

            table.dataTable thead > tr > th {
                padding-left: 0px;
                padding-right: 0px;
            }
            table.dataTable{
                /* background-color: lightgoldenrodyellow; */
                background-color: #F9F9F9;
            }
            .textAlignVer{
                display: block;
                filter: flipv fliph;
                -webkit-transform: rotate(-90deg);
                -moz-transform: rotate(-90deg);
                transform: rotate(-90deg);
                position: relative;
                width:20px;
                white-space:nowrap;
                font-size:12px;
                margin-bottom:px;

            }
            .swal2-popup {
                font-size: 16px !important;
                padding: 17px;
                border: 1px solid #F0E1A1;
                display: block;
                margin: 22px;
                text-align: center;
                color: #61534e;
            }

        </style>
    </head>
    <body>
        <input type="text" style="display: none"   class="form-control " id="TXT_VEHICLETRANSPORTPRICEID" name="TXT_VEHICLETRANSPORTPRICEID">


        <div class="modal fade" id="modal_startenddate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 40%">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-lg-5">
                                <h5 class="modal-title" ><b>วันที่เริ่มต้น -> วันที่สิ้นสุด</b></h5>
                            </div>

                        </div>
                    </div>
                    <div class="modal-body">




                        <div class="row">
                            <div class="col-lg-6">
                                <label>วันที่เริ่มต้น  </label>
                                <input type="text"  readonly="" class="form-control dateen" id="txt_startdate" name="txt_startdate">

                            </div>
                            <div class="col-lg-6">
                                <label>วันที่สิ้นสุด  </label>
                                <input type="text"  readonly="" class="form-control dateen" id="txt_enddate" name="txt_enddate">

                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="save_startenddata()">บันทึก</button>
                    </div>





                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_addtransportprice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 40%">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-lg-5">
                                <h5 class="modal-title" id="title_copydiagram"><b>เพิ่มข้อมูลราคาขนส่ง</b></h5>
                            </div>

                        </div>
                    </div>
                    <div id="modaladdtransportpricesr"></div>

                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_compensationtransportprice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 40%">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-lg-5">
                                <h5 class="modal-title" id="title_copydiagram"><b>ข้อมูลค่าตอบแทน</b></h5>
                            </div>

                        </div>
                    </div>
                    <div class="modal-body">


                        <div class="row">
                            <input type="text" id="txt_ide1" name="txt_ide1" class="form-control" style="display: none">
                            <div class="col-lg-3">
                                <label>SR(4Lไป) :</label>
                                <input type="text" id="txt_sr4lg" name="txt_sr4lg" class="form-control">
                            </div>
                            <div class="col-lg-3">
                                <label>SR(4Lกลับ) :</label>
                                <input type="text" id="txt_sr4lt" name="txt_sr4lt" class="form-control">
                            </div>
                            <div class="col-lg-3">
                                <label>SR(8Lไป) :</label>
                                <input type="text" id="txt_sr8lg" name="txt_sr8lg" class="form-control">
                            </div>
                            <div class="col-lg-3">
                                <label>SR(8Lกลับ) :</label>
                                <input type="text" id="txt_sr8lt" name="txt_sr8lt" class="form-control">
                            </div>

                            <div class="col-lg-3">
                                <label>GW(4Lไป) :</label>
                                <input type="text" id="txt_gw4lg" name="txt_gw4lg" class="form-control">
                            </div>
                            <div class="col-lg-3">
                                <label>GW(4Lกลับ) :</label>
                                <input type="text" id="txt_gw4lt" name="txt_gw4lt" class="form-control">
                            </div>
                            <div class="col-lg-3">
                                <label>GW(8Lไป) :</label>
                                <input type="text" id="txt_gw8lg" name="txt_gw8lg" class="form-control">
                            </div>
                            <div class="col-lg-3">
                                <label>GW(8Lกลับ) :</label>
                                <input type="text" id="txt_gw8lt" name="txt_gw8lt" class="form-control">
                            </div>

                            <div class="col-lg-3">
                                <label>BP(4Lไป) :</label>
                                <input type="text" id="txt_bp4lg" name="txt_bp4lg" class="form-control">
                            </div>
                            <div class="col-lg-3">
                                <label>BP(4Lกลับ) :</label>
                                <input type="text" id="txt_bp4lt" name="txt_bp4lt" class="form-control">
                            </div>
                            <div class="col-lg-3">
                                <label>BP(8Lไป) :</label>
                                <input type="text" id="txt_bp8lg" name="txt_bp8lg" class="form-control">
                            </div>
                            <div class="col-lg-3">
                                <label>BP(8Lกลับ) :</label>
                                <input type="text" id="txt_bp8lt" name="txt_bp8lt" class="form-control">
                            </div>

                            <div class="col-lg-3">
                                <label>TAC(4Lไป) :</label>
                                <input type="text" id="txt_tac4lg" name="txt_tac4lg" class="form-control">
                            </div>
                            <div class="col-lg-3">
                                <label>TAC(4Lกลับ) :</label>
                                <input type="text" id="txt_tac4lt" name="txt_tac4lt" class="form-control">
                            </div>
                            <div class="col-lg-3">
                                <label>TAC(8Lไป) :</label>
                                <input type="text" id="txt_tac8lg" name="txt_tac8lg" class="form-control">
                            </div>
                            <div class="col-lg-3">
                                <label>TAC(8Lกลับ) :</label>
                                <input type="text" id="txt_tac8lt" name="txt_tac8lt" class="form-control">
                            </div>

                            <div class="col-lg-3">
                                <label>OTH(4Lไป) :</label>
                                <input type="text" id="txt_oth4lg" name="txt_oth4lg" class="form-control">
                            </div>
                            <div class="col-lg-3">
                                <label>OTH(4Lกลับ) :</label>
                                <input type="text" id="txt_oth4lt" name="txt_oth4lt" class="form-control">
                            </div>
                            <div class="col-lg-3">
                                <label>OTH(8Lไป) :</label>
                                <input type="text" id="txt_oth8lg" name="txt_oth8lg" class="form-control">
                            </div>
                            <div class="col-lg-3">
                                <label>OTH(8Lกลับ) :</label>
                                <input type="text" id="txt_oth8lt" name="txt_oth8lg" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">&nbsp;</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                        <button type="button" class="btn btn-primary" onclick="save_e1()">บันทึก</button>
                    </div>


                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_copytransportprice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 40%">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-lg-5">
                                <h5 class="modal-title" id="title_copydiagram"><b>คัดลอกข้อมูลราคาขนส่ง (ไตรมาสใหม่)</b></h5>
                            </div>

                        </div>
                    </div>
                    <div id="modalcopytransportpricesr"></div>

                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_addtransportpricemaster" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 40%">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-lg-5">
                                <h5 class="modal-title" id="title_copydiagram"><b>เพิ่มข้อมูลพื้นฐาน</b></h5>
                            </div>

                        </div>
                    </div>
                    <div id="modaladdtransportpricemastersr"></div>

                </div>
            </div>
        </div>

        <!-- Modal เพิ่มราคา SKB -->
        <div class="modal fade" id="modal_addtransportpricemaster_skb" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 60%">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 class="modal-title" id="title_copydiagram"><b>เพิ่มราคา SKB</b></h5>
                            </div>
                            <div><br></div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>ประเภทรถ :</label>
                                        <select  class="form-control"  title="" id="select_vehicletype"  >
                                            <option value="">เลือกประเภทรถ...</option>
                                            <option value="ADC-Dealer(SL2)">ADC-Dealer(SL2)</option>
                                            <option value="ADC-Dealer(FB)">ADC-Dealer(FB)</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>ต้นทาง :</label>
                                        <select  class="form-control"  title="" id="select_from"  >
                                            <option value="">เลือกต้นทาง...</option>
                                            <option value="ADC">ADC</option>
                                            <option value="Ruamkit">Ruamkit</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>ZONE (จังหวัด) :</label>
                                        <div class="dropdown bootstrap-select show-tick form-control" >
                                            <select  class="selectpicker form-control"   id="select_zone"  data-container="body" data-live-search="true" title="ตัวอย่างเช่น อุทัยธานี,นครราชสีมา,สกลนคร......" data-hide-disabled="true" data-actions-box="false" data-virtual-scroll="false" tabindex="-98"  >
                                                <option value=""></option>
                                                <?php
                                                // $condiCartype1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                                                $sql_seZone = "SELECT DISTINCT[ZONE] FROM VEHICLETRANSPORTPRICE WHERE COMPANYCODE ='RKL' AND CUSTOMERCODE ='SKB'
                                                                ORDER BY [ZONE] ASC";
                                                $params_seZone = array();
                                                $query_seZone = sqlsrv_query($conn, $sql_seZone, $params_seZone);
                                                while ($result_seZone = sqlsrv_fetch_array($query_seZone, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seZone['ZONE'] ?>"><?= $result_seZone['ZONE'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>    
                                    </div>
                                </div>
                                <div><br></div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label>LOCATION (อำเภอ) :</label>
                                        <div class="dropdown bootstrap-select show-tick form-control" >
                                            <select  class="selectpicker form-control"   id="select_location"  data-container="body" data-live-search="true" title="ตัวอย่างเช่น โพนทอง,แปดริ้ว,นางรอง......" data-hide-disabled="true" data-actions-box="false" data-virtual-scroll="false" tabindex="-98" >
                                                <option value=""></option>
                                                <?php
                                                // $condiCartype1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                                                $sql_seLocation = "SELECT DISTINCT[LOCATION] FROM VEHICLETRANSPORTPRICE WHERE COMPANYCODE ='RKL' AND CUSTOMERCODE ='SKB'
                                                                ORDER BY [LOCATION] ASC";
                                                $params_seLocation = array();
                                                $query_seLocation = sqlsrv_query($conn, $sql_seLocation, $params_seLocation);
                                                while ($result_seLocation = sqlsrv_fetch_array($query_seLocation, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seLocation['LOCATION'] ?>"><?= $result_seLocation['LOCATION'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>        
                                    </div>
                                    <div class="col-lg-6">
                                        <label>LOCATION (อำเภอ) : <font color="red">*กรณีไม่มีข้อมูลในระบบ</font></label>
                                        <input type="text" class="form-control"  id="txt_location" name="txt_location" placeholder='ตัวอย่างเช่น สอยดาว,ขุขันธ์,โพนทอง...'>
                                        
                                    </div>
                                </div>
                                <div><br></div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label>BILLING1 :</label>
                                        <div class="dropdown bootstrap-select show-tick form-control" >
                                        <select  class="selectpicker form-control"   id="select_billing1"  data-container="body" data-live-search="true" title="ตัวอย่างเช่น Krabi (กระบี่),Kanchanaburi (กาญจนบุรี)..." data-hide-disabled="true" data-actions-box="false" data-virtual-scroll="false" tabindex="-98" >
                                                
                                                <?php
                                                // $condiCartype1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                                                $sql_seBilling1 = "SELECT DISTINCT[BILLING1] FROM VEHICLETRANSPORTPRICE WHERE COMPANYCODE ='RKL' AND CUSTOMERCODE ='SKB'
                                                                    ORDER BY [BILLING1] ASC";
                                                $params_seBilling1 = array();
                                                $query_seBilling1 = sqlsrv_query($conn, $sql_seBilling1, $params_seBilling1);
                                                while ($result_seBilling1 = sqlsrv_fetch_array($query_seBilling1, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seBilling1['BILLING1'] ?>"><?= $result_seBilling1['BILLING1'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>BILLING2 :</label>
                                        <input type="text" class="form-control"  id="txt_billing2" name="txt_billing2" placeholder='ใส่ข้อมูล "ดีลเลอร์" ตัวอย่างเช่น บจก.เจริญชัยแทรกเตอร์,บจก.คูโบต้าทั่งทองพิจิตร'>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                                <button type="button" class="btn btn-primary" onclick="add_transportpricemaster_skb('1', '<?= $_GET['companycode'] ?>', '<?= $_GET['customercode'] ?>', '<?= $_GET['worktype'] ?>', '1')">บันทึก</button>
                            </div>
                        </div>
                    </div>
                    <div id="modaladdtransportpricemastersr_skb"></div>

                </div>
            </div>
        </div>    

        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

            <div class="navbar-header" >
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><font style="color: #000;font-size: 14px"><img src="../images/logo.ico" height="30"> <strong>Transport Management System</strong></font></a>
            </div>
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">

                        <li><a href="meg_logout.php"><i class="fa fa-sign-out fa-fw"></i> ออกจากระบบ</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>

        <div class="row" >
            <div class="col-lg-12">
                &nbsp;
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-lg-6" style="text-align: left">

                <div class="panel-heading" >
                    <a href="#" onclick="pdf_transportprice();" class="btn btn-default">PDF <li class="fa fa-print"></li></a></div>

            </div>
            <div class="col-lg-6" style="text-align: right">
                <input type="text" style="display: none" id="txt_monthst" name="txt_monthst">
                <input type="text" style="display: none" id="txt_yinjob" name="txt_yinjob">

                <?php
                if ($_GET['companycode'] =='RKL' && $_GET['customercode'] =='SKB') {
                ?>
                <button style="margin-right: 15px;display: none"  type="button" onclick="modalcopytransportprice()" data-toggle="modal" data-target="#modal_copytransportprice" id="addprice" name="addprice" class="btn btn-outline btn-default"><li class="fa fa-copy"></li> คัดลอกข้อมูลราคาขนส่ง (ไตรมาสใหม่)</button>
                <button style="margin-right: 15px;display: none"  type="button" data-toggle="modal" data-target="#modal_addtransportpricemaster_skb"  id="addrow" name="addrow" class="btn btn-outline btn-default"><li class="fa fa-plus-circle"></li> เพิ่มราคาขนส่ง SKB</button>
                <button style="margin-right: 15px;display: none"  type="button" data-toggle="modal" data-target="#modal_addtransportpricemaster" onclick="modaladdtransportpricemaster('<?= $_GET['companycode'] ?>', '<?= $_GET['customercode'] ?>')" id="addmasterdata" name="addmasterdata" class="btn btn-outline btn-default"><li class="fa fa-plus-circle"></li> เพิ่มข้อมูลพื้นฐาน SKB</button>
                <?php
                }else{
                ?>
                <button style="margin-right: 15px;display: none"  type="button" onclick="modalcopytransportprice()" data-toggle="modal" data-target="#modal_copytransportprice" id="addprice" name="addprice" class="btn btn-outline btn-default"><li class="fa fa-copy"></li> คัดลอกข้อมูลราคาขนส่ง (ไตรมาสใหม่)</button>
                <button style="margin-right: 15px;display: none"  type="button" onclick="save_vehicletransportprice('<?= $_GET['companycode'] ?>', '<?= $_GET['customercode'] ?>')"  id="addrow" name="addrow" class="btn btn-outline btn-default"><li class="fa fa-plus-circle"></li> เพิ่มราคาขนส่ง</button>
                <button style="margin-right: 15px;display: none"  type="button" data-toggle="modal" data-target="#modal_addtransportpricemaster" onclick="modaladdtransportpricemaster('<?= $_GET['companycode'] ?>', '<?= $_GET['customercode'] ?>')" id="addmasterdata" name="addmasterdata" class="btn btn-outline btn-default"><li class="fa fa-plus-circle"></li> เพิ่มข้อมูลพื้นฐาน</button>
                <?php
                }
                ?>

                


            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">&nbsp;</div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: #e7e7e7">
                        <div class="row">
                            <div class="col-lg-6 text-left">
                                <?php
                                $meg = 'ราคาขนส่ง';
                                if ($_GET['companycode'] == 'RRC' || $_GET['companycode'] == 'RCC' || $_GET['companycode'] == 'RATC') {
                                    echo "<a href='report_companypricegetway.php?type=report'>บริษัท</a> / <a href='report_customerpricegetway.php?type=report&companycode=" . $_GET['companycode'] . "'>ลูกค้า</a>  / " . $meg;
                                    $link = "<a href='report_companypricegetway.php?type=report'>บริษัท</a> / <a href='report_customerpricegetway.php?type=report&companycode=" . $_GET['companycode'] . "'>ลูกค้า</a> ";
                                } else {
                                    echo "<a href='report_companypriceamata.php?type=report'>บริษัท</a> / <a href='report_customerpriceamata.php?type=report&companycode=" . $_GET['companycode'] . "'>ลูกค้า</a>  / " . $meg;
                                    $link = "<a href='report_companypriceamata.php?type=report'>บริษัท</a> / <a href='report_customerpriceamata.php?type=report&companycode=" . $_GET['companycode'] . "'>ลูกค้า</a> ";
                                }

                                $_SESSION["link"] = $link;
                                ?>
                            </div>

                            <div class="col-lg-1 text-right">ชุดที่ :</div>
                            <div class="col-lg-2 text-right">
                                <?php
                                /*$condVehicletransportprice1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                                $condVehicletransportprice2 = "";
                                $condVehicletransportprice3 = "";
                                $sql_seVehicletransportprice = "{call megVehicletransportprice_v2(?,?,?,?)}";
                                $params_seVehicletransportprice = array(
                                    array('select_vehicletransportprice', SQLSRV_PARAM_IN),
                                    array($condVehicletransportprice1, SQLSRV_PARAM_IN),
                                    array($condVehicletransportprice2, SQLSRV_PARAM_IN),
                                    array($condVehicletransportprice3, SQLSRV_PARAM_IN)
                                );
                                $query_seVehicletransportprice = sqlsrv_query($conn, $sql_seVehicletransportprice, $params_seVehicletransportprice);
                                $result_seVehicletransportprice = sqlsrv_fetch_array($query_seVehicletransportprice, SQLSRV_FETCH_ASSOC);

                                $condYinjob1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                                $condYinjob2 = "";
                                $condYinjob3 = "";
                                $sql_seYinjob = "{call megVehicletransportprice_v2(?,?,?,?)}";
                                $params_seYinjob = array(
                                    array('select_yinjob', SQLSRV_PARAM_IN),
                                    array($condYinjob1, SQLSRV_PARAM_IN),
                                    array($condYinjob2, SQLSRV_PARAM_IN),
                                    array($condYinjob3, SQLSRV_PARAM_IN)
                                );
                                $query_seYinjob = sqlsrv_query($conn, $sql_seYinjob, $params_seYinjob);
                                $result_seYinjob = sqlsrv_fetch_array($query_seYinjob, SQLSRV_FETCH_ASSOC);
                                 * */
                         
                                ?>
                                <select  class="form-control" id="cb_group" name="cb_group" onchange="select_vehicletransportprice(this.value)">
                                    <option value="">เลือกชุดราคา</option>
                                    <?php
                                    if ($_GET['worktype'] == 'sh') {
                                        /*$condMonthst1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                                        $condMonthst2 = " AND WORKTYPE = 'sh' ";
                                        $condMonthst3 = "";
                                        $sql_seMonthst = "{call megVehicletransportprice_v2(?,?,?,?)}";
                                        $params_seMonthst = array(
                                            array('select_monthst', SQLSRV_PARAM_IN),
                                            array($condMonthst1, SQLSRV_PARAM_IN),
                                            array($condMonthst2, SQLSRV_PARAM_IN),
                                            array($condMonthst3, SQLSRV_PARAM_IN)
                                        );
                                         * 
                                         */
                                        $sql_seMonthst="SELECT COMPANYCODE+'-'+CUSTOMERCODE+'/'+MONTHST+'-'+CONVERT(NVARCHAR(4),STARTDATE,111) AS 'DATA1',CONVERT(NVARCHAR(4),STARTDATE,111)+','+MONTHST AS 'DATA2' FROM [dbo].[VEHICLETRANSPORTPRICE] 
                                        WHERE COMPANYCODE = '" . $_GET['companycode'] . "'
                                        AND CUSTOMERCODE = '" . $_GET['customercode'] . "' AND WORKTYPE = 'sh' AND CARRYTYPE = '".$_GET['carrytype']."'
                                        GROUP BY COMPANYCODE,CUSTOMERCODE,MONTHST,STARTDATE
                                        ORDER BY STARTDATE ASC";
                                        $params_seMonthst = array();
                                        $query_seMonthst = sqlsrv_query($conn, $sql_seMonthst, $params_seMonthst);
                                    } else {
                                        /*$condMonthst1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                                        $condMonthst2 = "";
                                        $condMonthst3 = "";
                                        $sql_seMonthst = "{call megVehicletransportprice_v2(?,?,?,?)}";
                                        $params_seMonthst = array(
                                            array('select_monthst', SQLSRV_PARAM_IN),
                                            array($condMonthst1, SQLSRV_PARAM_IN),
                                            array($condMonthst2, SQLSRV_PARAM_IN),
                                            array($condMonthst3, SQLSRV_PARAM_IN)
                                        );
                                        $query_seMonthst = sqlsrv_query($conn, $sql_seMonthst, $params_seMonthst);
                                         * 
                                         */
										 // เฉพาะปี 2024 ขี้นไป อัพเดทเงื่อนไขวันที่ 31/03/2025 
                                        $worktype = ($_GET['worktype'] == "")? "":" AND WORKTYPE = '".$_GET['worktype']."' ";
                                         $sql_seMonthst="SELECT A.DATA1,A.DATA2 FROM (
                                        SELECT COMPANYCODE+'-'+CUSTOMERCODE+'/'+MONTHST+'-'+CONVERT(NVARCHAR(4),STARTDATE,111)  AS 'DATA1',CONVERT(NVARCHAR(4),STARTDATE,111)+','+MONTHST AS 'DATA2',
                                        YEAR(STARTDATE) AS 'STARTDATE'
                                        FROM [dbo].[VEHICLETRANSPORTPRICE] 
                                        WHERE COMPANYCODE = '" . $_GET['companycode'] . "'
                                        AND CUSTOMERCODE = '" . $_GET['customercode']."'".$worktype." AND CARRYTYPE = '".$_GET['carrytype']."'
                                        AND YEAR(STARTDATE) >='2024'
                                        ) AS A GROUP BY A.DATA1,A.DATA2,A.STARTDATE ORDER BY A.DATA2 ASC";
                                        $params_seMonthst = array();
                                        $query_seMonthst = sqlsrv_query($conn, $sql_seMonthst, $params_seMonthst);
                                    }

                                    while ($result_seMonthst = sqlsrv_fetch_array($query_seMonthst, SQLSRV_FETCH_ASSOC)) {
                                        ?>
                                        <option value="<?= $result_seMonthst['DATA2'] ?>"><?= $result_seMonthst['DATA1'] ?></option>

                                        <?php
                                    }
                                    ?>

                                </select>

                            </div>
                            <div class="col-lg-3 text-right"><?= $result_seComp['Company_NameT'] ?> / <?= $result_seCustomer['NAMETH'] ?></div>



                        </div>
                    </div>
                    <!-- /.panel-heading -->

                    <div class="panel-body">
                        <div id="datadef">

                        </div>
                        <div id="datasr"></div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>
        </div>


        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
        <script src="../dist/js/sb-admin-2.js"></script>
        <script src="../js/jquery.datetimepicker.full.js"></script>
        <script src="../dist/js/bootstrap-select.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
        <script>    
                                    // function update_megtransportprice(value, fieldname, priceid, planid) {

                                    // // alert(value);
                                    // // alert(fieldname);
                                    // // alert(priceid);
                                    // // alert(planid);

                                    // $.ajax({
                                    //     url: 'meg_data.php',
                                    //     type: 'POST',
                                    //     data: {
                                    //         txt_flg: "update_megtransportprice", value: value, fieldname: fieldname, priceid: priceid, planid: ''
                                    //     },
                                    //     success: function (rs) {

                                    //         // window.location.reload();
                                    //     }
                                    // });


                                    // }
                                    function datetodate()
                                    {
                                        document.getElementById('txt_enddate').value = document.getElementById('txt_startdate').value;

                                    }
                                    $(function () {

                                        $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                        // กรณีใช้แบบ input
                                        $(".dateen").datetimepicker({
                                            timepicker: false,
                                            format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                            lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.

                                        });
                                    });
                                    function save_startenddata()
                                    {
                                        edit_vehicletransportprice(document.getElementById("txt_startdate").value, 'STARTDATE', document.getElementById("TXT_VEHICLETRANSPORTPRICEID").value);
                                        edit_vehicletransportprice(document.getElementById("txt_enddate").value, 'ENDDATE', document.getElementById("TXT_VEHICLETRANSPORTPRICEID").value);
                                        select_vehicletransportprice('<?= $result_seYinjob['yinjob'] ?>');
                                       
                                    }
                                    function editvar_startenddate(VEHICLETRANSPORTPRICEID, DATASTARTDATE, DATAENDDATE)
                                    {
                                        document.getElementById("TXT_VEHICLETRANSPORTPRICEID").value = VEHICLETRANSPORTPRICEID;
                                        document.getElementById("txt_startdate").value = DATASTARTDATE;
                                        document.getElementById("txt_enddate").value = DATAENDDATE;

                                    }
                                    function save_e1()
                                    {
                                        var rs_e1 = (document.getElementById("txt_sr4lg").value + ',' +
                                                document.getElementById("txt_sr4lt").value + ',' +
                                                document.getElementById("txt_sr8lg").value + ',' +
                                                document.getElementById("txt_sr8lt").value + ',' +
                                                document.getElementById("txt_gw4lg").value + ',' +
                                                document.getElementById("txt_gw4lt").value + ',' +
                                                document.getElementById("txt_gw8lg").value + ',' +
                                                document.getElementById("txt_gw8lt").value + ',' +
                                                document.getElementById("txt_bp4lg").value + ',' +
                                                document.getElementById("txt_bp4lt").value + ',' +
                                                document.getElementById("txt_bp8lg").value + ',' +
                                                document.getElementById("txt_bp8lt").value + ',' +
                                                document.getElementById("txt_tac4lg").value + ',' +
                                                document.getElementById("txt_tac4lt").value + ',' +
                                                document.getElementById("txt_tac8lg").value + ',' +
                                                document.getElementById("txt_tac8lt").value + ',' +
                                                document.getElementById("txt_oth4lg").value + ',' +
                                                document.getElementById("txt_oth4lt").value + ',' +
                                                document.getElementById("txt_oth8lg").value + ',' +
                                                document.getElementById("txt_oth8lt").value);


                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "edit_vehicletransportprice", editableObj: rs_e1, ID: document.getElementById("txt_ide1").value, fieldname: 'E1'

                                            },
                                            success: function () {

                                                alert("บันทึกข้อมูลเรียบร้อย...");
                                                window.location.reload();
                                            }

                                        });
                                    }
                                    function edit_e1(id, data)
                                    {
                                        document.getElementById("txt_ide1").value = id;
                                        var rs = data.split(",");
                                        var rs0 = "";
                                        var rs1 = "";
                                        var rs2 = "";
                                        var rs3 = "";

                                        var rs4 = "";
                                        var rs5 = "";
                                        var rs6 = "";
                                        var rs7 = "";

                                        var rs8 = "";
                                        var rs9 = "";
                                        var rs10 = "";
                                        var rs11 = "";

                                        var rs12 = "";
                                        var rs13 = "";
                                        var rs14 = "";
                                        var rs15 = "";

                                        var rs16 = "";
                                        var rs17 = "";
                                        var rs18 = "";
                                        var rs19 = "";

                                        rs0 = rs[0];
                                        rs1 = rs[1];
                                        rs2 = rs[2];
                                        rs3 = rs[3];

                                        rs4 = rs[4];
                                        rs5 = rs[5];
                                        rs6 = rs[6];
                                        rs7 = rs[7];

                                        rs8 = rs[8];
                                        rs9 = rs[9];
                                        rs10 = rs[10];
                                        rs11 = rs[11];

                                        rs12 = rs[12];
                                        rs13 = rs[13];
                                        rs14 = rs[14];
                                        rs15 = rs[15];

                                        rs16 = rs[16];
                                        rs17 = rs[17];
                                        rs18 = rs[18];
                                        rs19 = rs[19];






                                        document.getElementById("txt_sr4lg").value = (typeof rs0 === "" || typeof rs0 === "undefined" || typeof rs0 === "NULL") ? '-' : rs[0];
                                        document.getElementById("txt_sr4lt").value = (typeof rs1 === "" || typeof rs1 === "undefined" || typeof rs1 === "NULL") ? '-' : rs[1];
                                        document.getElementById("txt_sr8lg").value = (typeof rs2 === "" || typeof rs2 === "undefined" || typeof rs2 === "NULL") ? '-' : rs[2];
                                        document.getElementById("txt_sr8lt").value = (typeof rs3 === "" || typeof rs3 === "undefined" || typeof rs3 === "NULL") ? '-' : rs[3];

                                        document.getElementById("txt_gw4lg").value = (typeof rs4 === "" || typeof rs4 === "undefined" || typeof rs4 === "NULL") ? '-' : rs[4];
                                        document.getElementById("txt_gw4lt").value = (typeof rs5 === "" || typeof rs5 === "undefined" || typeof rs5 === "NULL") ? '-' : rs[5];
                                        document.getElementById("txt_gw8lg").value = (typeof rs6 === "" || typeof rs6 === "undefined" || typeof rs6 === "NULL") ? '-' : rs[6];
                                        document.getElementById("txt_gw8lt").value = (typeof rs7 === "" || typeof rs7 === "undefined" || typeof rs7 === "NULL") ? '-' : rs[7];

                                        document.getElementById("txt_bp4lg").value = (typeof rs8 === "" || typeof rs8 === "undefined" || typeof rs8 === "NULL") ? '-' : rs[8];
                                        document.getElementById("txt_bp4lt").value = (typeof rs9 === "" || typeof rs9 === "undefined" || typeof rs9 === "NULL") ? '-' : rs[9];
                                        document.getElementById("txt_bp8lg").value = (typeof rs10 === "" || typeof rs10 === "undefined" || typeof rs10 === "NULL") ? '-' : rs[10];
                                        document.getElementById("txt_bp8lt").value = (typeof rs11 === "" || typeof rs11 === "undefined" || typeof rs11 === "NULL") ? '-' : rs[11];

                                        document.getElementById("txt_tac4lg").value = (typeof rs12 === "" || typeof rs12 === "undefined" || typeof rs12 === "NULL") ? '-' : rs[12];
                                        document.getElementById("txt_tac4lt").value = (typeof rs13 === "" || typeof rs13 === "undefined" || typeof rs13 === "NULL") ? '-' : rs[13];
                                        document.getElementById("txt_tac8lg").value = (typeof rs14 === "" || typeof rs14 === "undefined" || typeof rs14 === "NULL") ? '-' : rs[14];
                                        document.getElementById("txt_tac8lt").value = (typeof rs15 === "" || typeof rs15 === "undefined" || typeof rs15 === "NULL") ? '-' : rs[15];

                                        document.getElementById("txt_oth4lg").value = (typeof rs16 === "" || typeof rs16 === "undefined" || typeof rs16 === "NULL") ? '-' : rs[16];
                                        document.getElementById("txt_oth4lt").value = (typeof rs17 === "" || typeof rs17 === "undefined" || typeof rs17 === "NULL") ? '-' : rs[17];
                                        document.getElementById("txt_oth8lg").value = (typeof rs18 === "" || typeof rs18 === "undefined" || typeof rs18 === "NULL") ? '-' : rs[18];
                                        document.getElementById("txt_oth8lt").value = (typeof rs19 === "" || typeof rs19 === "undefined" || typeof rs19 === "NULL") ? '-' : rs[19];

                                    }

                                    function edit_rrc(companycode, customercode, id, vehicletype, from, to)
                                    {

                                        //document.getElementById("cb_vehicletypedef" + id).style.display = 'none';


                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "show_vehicletyperrc", companycode: companycode, customercode: customercode, id: id, vehicletype: vehicletype, from: from, to: to
                                            },
                                            success: function (rs1) {
                                                document.getElementById("div_vehicletypesr" + id).innerHTML = rs1;
                                            }

                                        });

                                        document.getElementById("cb_fromdef" + id).style.display = 'none';


                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "show_fromrrc", companycode: companycode, customercode: customercode, id: id, vehicletype: vehicletype, from: from, to: to
                                            },
                                            success: function (rs2) {
                                                document.getElementById("div_fromsr" + id).innerHTML = rs2;
                                            }

                                        });

                                        document.getElementById("cb_todef" + id).style.display = 'none';


                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "show_torrc", companycode: companycode, customercode: customercode, id: id, vehicletype: vehicletype, from: from, to: to
                                            },
                                            success: function (rs3) {
                                                document.getElementById("div_tosr" + id).innerHTML = rs3;
                                            }

                                        });


                                    }
                                    function edit_rccttt(companycode, customercode, id, cluster, from, to)
                                    {

                                        document.getElementById("cb_cluster" + id).style.display = 'none';


                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "show_clusterrccttt", companycode: companycode, customercode: customercode, id: id, cluster: cluster, from: from, to: to
                                            },
                                            success: function (rs1) {
                                                document.getElementById("div_clustersr" + id).innerHTML = rs1;
                                            }

                                        });

                                        document.getElementById("cb_from" + id).style.display = 'none';


                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "show_fromrccttt", companycode: companycode, customercode: customercode, id: id, cluster: cluster, from: from, to: to
                                            },
                                            success: function (rs1) {
                                                document.getElementById("div_fromsr" + id).innerHTML = rs1;
                                            }

                                        });

                                        document.getElementById("cb_to" + id).style.display = 'none';

                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "show_torccttt", companycode: companycode, customercode: customercode, id: id, cluster: cluster, from: from, to: to
                                            },
                                            success: function (rs1) {
                                                document.getElementById("div_tosr" + id).innerHTML = rs1;
                                            }

                                        });








                                    }
                                    function edit_rks(companycode, customercode, id, vehicletype, from, to)
                                    {

                                        document.getElementById("cb_vehicletypedef" + id).style.display = 'none';


                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "show_vehicletyperks", companycode: companycode, customercode: customercode, id: id, vehicletype: vehicletype, from: from, to: to
                                            },
                                            success: function (rs1) {
                                                document.getElementById("div_vehicletypesr" + id).innerHTML = rs1;
                                            }

                                        });

                                        document.getElementById("cb_fromdef" + id).style.display = 'none';


                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "show_fromrks", companycode: companycode, customercode: customercode, id: id, vehicletype: vehicletype, from: from, to: to
                                            },
                                            success: function (rs2) {
                                                document.getElementById("div_fromsr" + id).innerHTML = rs2;
                                            }

                                        });

                                        document.getElementById("cb_todef" + id).style.display = 'none';


                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "show_torks", companycode: companycode, customercode: customercode, id: id, vehicletype: vehicletype, from: from, to: to
                                            },
                                            success: function (rs3) {
                                                document.getElementById("div_tosr" + id).innerHTML = rs3;
                                            }

                                        });


                                    }
                                    function edit_rkr(companycode, customercode, id, vehicletype, from, to, zone, location, billing1, billing2, billing3)
                                    {

                                        document.getElementById("cb_vehicletypedef" + id).style.display = 'none';


                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "show_vehicletyperkr", companycode: companycode, customercode: customercode, id: id, vehicletype: vehicletype, from: from, to: to, zone: zone, location: location, billing1: billing1, billing2: billing2, billing3: billing3
                                            },
                                            success: function (rs1) {
                                                document.getElementById("div_vehicletypesr" + id).innerHTML = rs1;
                                            }

                                        });

                                        document.getElementById("cb_fromdef" + id).style.display = 'none';


                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "show_fromrkr", companycode: companycode, customercode: customercode, id: id, vehicletype: vehicletype, from: from, to: to, zone: zone, location: location, billing1: billing1, billing2: billing2, billing3: billing3
                                            },
                                            success: function (rs2) {
                                                document.getElementById("div_fromsr" + id).innerHTML = rs2;
                                            }

                                        });


                                        document.getElementById("cb_todef" + id).style.display = 'none';


                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "show_torkr", companycode: companycode, customercode: customercode, id: id, vehicletype: vehicletype, from: from, to: to, zone: zone, location: location, billing1: billing1, billing2: billing2, billing3: billing3
                                            },
                                            success: function (rs3) {
                                                document.getElementById("div_tosr" + id).innerHTML = rs3;
                                            }

                                        });

                                        document.getElementById("cb_zonedef" + id).style.display = 'none';


                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "show_zonerkr", companycode: companycode, customercode: customercode, id: id, vehicletype: vehicletype, from: from, to: to, zone: zone, location: location, billing1: billing1, billing2: billing2, billing3: billing3
                                            },
                                            success: function (rs4) {
                                                document.getElementById("div_zonesr" + id).innerHTML = rs4;
                                            }

                                        });

                                        document.getElementById("cb_locationdef" + id).style.display = 'none';


                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "show_locationrkr", companycode: companycode, customercode: customercode, id: id, vehicletype: vehicletype, from: from, to: to, zone: zone, location: location, billing1: billing1, billing2: billing2, billing3: billing3
                                            },
                                            success: function (rs5) {
                                                document.getElementById("div_locationsr" + id).innerHTML = rs5;
                                            }

                                        });

                                        document.getElementById("cb_billing1def" + id).style.display = 'none';


                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "show_billing1rkr", companycode: companycode, customercode: customercode, id: id, vehicletype: vehicletype, from: from, to: to, zone: zone, location: location, billing1: billing1, billing2: billing2, billing3: billing3
                                            },
                                            success: function (rs6) {
                                                document.getElementById("div_billing1sr" + id).innerHTML = rs6;
                                            }

                                        });

                                        document.getElementById("cb_billing2def" + id).style.display = 'none';


                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "show_billing2rkr", companycode: companycode, customercode: customercode, id: id, vehicletype: vehicletype, from: from, to: to, zone: zone, location: location, billing1: billing1, billing2: billing2, billing3: billing3
                                            },
                                            success: function (rs7) {
                                                document.getElementById("div_billing2sr" + id).innerHTML = rs7;
                                            }

                                        });

                                        document.getElementById("cb_billing3def" + id).style.display = 'none';


                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "show_billing3rkr", companycode: companycode, customercode: customercode, id: id, vehicletype: vehicletype, from: from, to: to, zone: zone, location: location, billing1: billing1, billing2: billing2, billing3: billing3
                                            },
                                            success: function (rs8) {
                                                document.getElementById("div_billing3sr" + id).innerHTML = rs8;
                                            }

                                        });




                                    }
                                    function edit_rkl(companycode, customercode, id, vehicletype, from, to, zone, location, billing1, billing2, billing3)
                                    {

                                        document.getElementById("cb_vehicletypedef" + id).style.display = 'none';


                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "show_vehicletyperkl", companycode: companycode, customercode: customercode, id: id, vehicletype: vehicletype, from: from, to: to, zone: zone, location: location, billing1: billing1, billing2: billing2, billing3: billing3
                                            },
                                            success: function (rs1) {
                                                document.getElementById("div_vehicletypesr" + id).innerHTML = rs1;
                                            }

                                        });

                                        document.getElementById("cb_fromdef" + id).style.display = 'none';


                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "show_fromrkl", companycode: companycode, customercode: customercode, id: id, vehicletype: vehicletype, from: from, to: to, zone: zone, location: location, billing1: billing1, billing2: billing2, billing3: billing3
                                            },
                                            success: function (rs2) {
                                                document.getElementById("div_fromsr" + id).innerHTML = rs2;
                                            }

                                        });


                                        document.getElementById("cb_todef" + id).style.display = 'none';


                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "show_torkl", companycode: companycode, customercode: customercode, id: id, vehicletype: vehicletype, from: from, to: to, zone: zone, location: location, billing1: billing1, billing2: billing2, billing3: billing3
                                            },
                                            success: function (rs3) {
                                                document.getElementById("div_tosr" + id).innerHTML = rs3;
                                            }

                                        });

                                        document.getElementById("cb_zonedef" + id).style.display = 'none';


                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "show_zonerkl", companycode: companycode, customercode: customercode, id: id, vehicletype: vehicletype, from: from, to: to, zone: zone, location: location, billing1: billing1, billing2: billing2, billing3: billing3
                                            },
                                            success: function (rs4) {
                                                document.getElementById("div_zonesr" + id).innerHTML = rs4;
                                            }

                                        });

                                        document.getElementById("cb_locationdef" + id).style.display = 'none';


                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "show_locationrkl", companycode: companycode, customercode: customercode, id: id, vehicletype: vehicletype, from: from, to: to, zone: zone, location: location, billing1: billing1, billing2: billing2, billing3: billing3
                                            },
                                            success: function (rs5) {
                                                document.getElementById("div_locationsr" + id).innerHTML = rs5;
                                            }

                                        });

                                        document.getElementById("cb_billing1def" + id).style.display = 'none';


                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "show_billing1rkl", companycode: companycode, customercode: customercode, id: id, vehicletype: vehicletype, from: from, to: to, zone: zone, location: location, billing1: billing1, billing2: billing2, billing3: billing3
                                            },
                                            success: function (rs6) {
                                                document.getElementById("div_billing1sr" + id).innerHTML = rs6;
                                            }

                                        });

                                        document.getElementById("cb_billing2def" + id).style.display = 'none';


                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "show_billing2rkl", companycode: companycode, customercode: customercode, id: id, vehicletype: vehicletype, from: from, to: to, zone: zone, location: location, billing1: billing1, billing2: billing2, billing3: billing3
                                            },
                                            success: function (rs7) {
                                                document.getElementById("div_billing2sr" + id).innerHTML = rs7;
                                            }

                                        });

                                        document.getElementById("cb_billing3def" + id).style.display = 'none';


                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "show_billing3rkl", companycode: companycode, customercode: customercode, id: id, vehicletype: vehicletype, from: from, to: to, zone: zone, location: location, billing1: billing1, billing2: billing2, billing3: billing3
                                            },
                                            success: function (rs8) {
                                                document.getElementById("div_billing3sr" + id).innerHTML = rs8;
                                            }

                                        });




                                    }
                                    function edit_rcctttsh(companycode, customercode, id, to)
                                    {



                                        document.getElementById("cb_tosh" + id).style.display = 'none';

                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "show_torcctttsh", companycode: companycode, customercode: customercode, id: id, to: to
                                            },
                                            success: function (rs1) {
                                                document.getElementById("div_toshsr" + id).innerHTML = rs1;
                                            }

                                        });






                                    }
                                    function copytransportprice(companycode, customercode, worktype)
                                    {
											// var datestart = document.getElementById("txt_datestart").value;

                                            // alert(companycode);
                                            // alert(customercode);
                                            // alert(worktype);

                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "copy_vehicletransportprice", companycode: companycode, customercode: customercode, worktype: worktype, datestart: document.getElementById("txt_datestart").value, dateend: document.getElementById("txt_dateend").value
                                            },
                                            success: function (rs) {
                                                // alert(rs);
                                                window.location.reload();
                                            }

                                        });
                                    }
                                    function add_transportpricemaster_skb(vehicledesccode, companycode, customercode, worktype, activestatus){

                                        var vehicletype = document.getElementById("select_vehicletype").value;
                                        var from        = document.getElementById("select_from").value;
                                        var zone        = document.getElementById("select_zone").value;
                                        var locationchk = document.getElementById("select_location").value;
                                            // กรณีถ้า location ไม่มีให้เลือกจะให้เพิ่มข้อมูลเอง
                                            if (locationchk != '') {
                                                var location = document.getElementById("select_location").value;
                                            }else{
                                                var location = document.getElementById("txt_location").value;
                                            }
                                        var billing1    = document.getElementById("select_billing1").value;

                                        var billing2chk    = document.getElementById("txt_billing2").value;
                                        var billing2 = location+"/"+billing2chk;
                                    
                                        // alert(vehicledesccode);
                                        // alert(companycode);
                                        // alert(customercode);
                                        // alert(worktype);
                                        // alert(activestatus);
                                        // alert(vehicletype);
                                        // alert(from);
                                        // alert(zone);
                                        // alert(location);
                                        // alert(billing1);
                                        // alert(billing2);
                                        
                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data2.php',
                                            data: {

                                                txt_flg: "Addtransportpricemaster_skb", 
                                                condition1: vehicletype,
                                                condition2: '',
                                                condition3: '',
                                                vehicledesccode: vehicledesccode, 
                                                worktype: worktype, 
                                                companycode: companycode, 
                                                customercode: customercode, 
                                                activestatus: activestatus, 
                                                data1: from, 
                                                data2: zone, 
                                                data3: location, 
                                                data4: billing1, 
                                                data5: billing2

                                            },
                                            success: function (rs) {
                                                // alert(rs);
                                                // window.location.reload();
                                                swal.fire({
                                                    title: "Good Job!",
                                                    text: "บันทึกข้อมูลเรียบร้อย !",
                                                    icon: "success",
                                                    showConfirmButton: false,
                                                    allowOutsideClick: false,
                                                });
                                                // alert(rs);   
                                                setTimeout(() => {
                                                    document.location.reload();
                                                }, 1600);
                                            }

                                        });

                                    }
                                    function add_transportpricemaster(vehicledesccode, companycode, customercode, worktype, activestatus)
                                    {

                                        if (companycode == 'RKS')
                                        {
                                            if (customercode == 'STM' || customercode == 'TAW' || customercode == 'TMT'  || customercode == 'DAIKI' )
                                            {

                                                $.ajax({
                                                    type: 'post',
                                                    url: 'meg_data.php',
                                                    data: {

                                                        txt_flg: "save_vehicletransportpricemaster", vehicledesccode: vehicledesccode, worktype: worktype, companycode: companycode, customercode: customercode, activestatus: activestatus, data1: document.getElementById("txt_vehicletype").value, data2: document.getElementById("txt_from").value, data3: '<?= $_GET['carrytype'] ?>', data4: document.getElementById("txt_monthst").value, data5: ''

                                                    },
                                                    success: function (rs) {
                                                        alert(rs);
                                                        window.location.reload();
                                                    }

                                                });
                                            } 
                                            else if (customercode == 'TTTC' || customercode == 'NITTSUSHOJI' || customercode == 'TGT' || customercode == 'THAITOHKEN' || customercode == 'GMT' || customercode == 'TTAT'|| customercode == 'SWN' || customercode == 'TDEM' || customercode == 'TKT' || customercode == 'HINO'|| customercode == 'COPPERCORD'|| customercode == 'TSAT')
                                            {
                                               
                                                $.ajax({
                                                    type: 'post',
                                                    url: 'meg_data.php',
                                                    data: {

                                                        txt_flg: "save_vehicletransportpricemaster", vehicledesccode: vehicledesccode, worktype: worktype, companycode: companycode, customercode: customercode, activestatus: activestatus, data1: document.getElementById("txt_vehicletype").value, data2: document.getElementById("txt_from").value, data3: document.getElementById("txt_to").value, data4: '<?= $_GET['carrytype'] ?>', data5: document.getElementById("txt_monthst").value

                                                    },
                                                    success: function (rs) {
                                                        alert(rs);
                                                        window.location.reload();
                                                    }

                                                });
                                            } else if (customercode == 'DENSO-THAI')
                                            {
                                                $.ajax({
                                                    type: 'post',
                                                    url: 'meg_data.php',
                                                    data: {

                                                        txt_flg: "save_vehicletransportpricemaster", vehicledesccode: vehicledesccode, worktype: worktype, companycode: companycode, customercode: customercode, activestatus: activestatus, data1: document.getElementById("txt_vehicletype").value, data2: document.getElementById("txt_routeno").value, data3: document.getElementById("txt_routedescription").value, data4: document.getElementById("txt_routetype").value, data5: document.getElementById("txt_monthst").value

                                                    },
                                                    success: function (rs) {
                                                        alert(rs);
                                                        window.location.reload();
                                                    }

                                                });
                                            }
                                        } else if (companycode == 'RCC' || companycode == 'RATC')
                                        {
                                            if (worktype == 'sh')
                                            {
                                                $.ajax({
                                                    type: 'post',
                                                    url: 'meg_data.php',
                                                    data: {

                                                        txt_flg: "save_vehicletransportpricemaster", vehicledesccode: vehicledesccode, worktype: worktype, companycode: companycode, customercode: customercode, activestatus: activestatus, data1: '', data2: '', data3: document.getElementById("txt_to").value, data4: '', data5: document.getElementById("txt_monthst").value

                                                    },
                                                    success: function (rs) {
                                                        alert(rs);
                                                        window.location.reload();
                                                    }

                                                });
                                            } else
                                            {
                                                $.ajax({
                                                    type: 'post',
                                                    url: 'meg_data.php',
                                                    data: {

                                                        txt_flg: "save_vehicletransportpricemaster", vehicledesccode: vehicledesccode, worktype: worktype, companycode: companycode, customercode: customercode, activestatus: activestatus, data1: document.getElementById("txt_cluster").value, data2: document.getElementById("txt_name").value, data3: '', data4: '', data5: document.getElementById("txt_monthst").value

                                                    },
                                                    success: function (rs) {
                                                        alert(rs);
                                                        window.location.reload();
                                                    }

                                                });
                                            }
                                        } else
                                        {
                                            $.ajax({
                                                type: 'post',
                                                url: 'meg_data.php',
                                                data: {

                                                    txt_flg: "save_vehicletransportpricemaster", vehicledesccode: vehicledesccode, worktype: worktype, companycode: companycode, customercode: customercode, activestatus: activestatus, data1: document.getElementById("txt_vehicletype").value, data2: document.getElementById("txt_from").value, data3: document.getElementById("txt_to").value, data4: '<?= $_GET['carrytype'] ?>', data5: ''

                                                },
                                                success: function (rs) {
                                                    alert(rs);
                                                    window.location.reload();
                                                }

                                            });
                                        }

                                    }
                                    function modaladdtransportpricemaster()
                                    {
                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "modal_addtransportpricemaster", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', worktype: '<?= $_GET['worktype'] ?>'
                                            },
                                            success: function (rs) {
                                                document.getElementById("modaladdtransportpricemastersr").innerHTML = rs;
                                            }


                                        });
                                    }
                                    function modalcopytransportprice()
                                    {
                                        // alert('<?= $_GET['worktype'] ?>');
                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "modal_copytransportprice", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', worktype: '<?= $_GET['worktype'] ?>'
                                            },
                                            success: function (rs) {
                                                document.getElementById("modalcopytransportpricesr").innerHTML = rs;
                                                $(function () {

                                                    $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                    // กรณีใช้แบบ input
                                                    $(".dateen").datetimepicker({
                                                        timepicker: false,
                                                        format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                        lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.

                                                    });
                                                });
                                            }


                                        });
                                    }
                                    function modaladdtransportprice()
                                    {
                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "modal_addtransportprice", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>'
                                            },
                                            success: function (rs) {
                                                document.getElementById("modaladdtransportpricesr").innerHTML = rs;
                                                $(function () {

                                                    $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                    // กรณีใช้แบบ input
                                                    $(".dateen").datetimepicker({
                                                        timepicker: false,
                                                        format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                        lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.

                                                    });
                                                });
                                            }


                                        });
                                    }

                                    function select_vehicletransportprice(yinjob)
                                    {
                                        
                                        document.getElementById("txt_monthst").value = document.getElementById("cb_group").value;
                                        document.getElementById("txt_yinjob").value = yinjob;
                                        if (document.getElementById("cb_group").value != '')
                                        {
                                            document.getElementById("addrow").style.display = '';
                                            document.getElementById("addprice").style.display = '';
                                            document.getElementById("addmasterdata").style.display = '';
                                        } else
                                        {
                                            document.getElementById("addrow").style.display = 'none';
                                            document.getElementById("addprice").style.display = 'none';
                                            document.getElementById("addmasterdata").style.display = 'none';
                                        }
                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data_vehicletransportprice.php',
                                            data: {
                                                txt_flg: "select_vehicletransportprice", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', monthst: document.getElementById("cb_group").value, worktype: '<?= $_GET['worktype'] ?>', carrytype: '<?= $_GET['carrytype'] ?>'
                                            },
                                            success: function (response) {
                                                if (response)
                                                {
                                                    document.getElementById("datasr").innerHTML = response;
                                                    document.getElementById("datadef").innerHTML = "";
                                                }
                                                $(document).ready(function () {
                                                    if ('<?=$_GET['companycode']?>' == 'RKL' && '<?=$_GET['customercode']?>' == 'SKB') {
                                                        
                                                        $('#dataTables-example').DataTable({
                                                            order: [[4, "asc"]],
                                                            scrollX: true
                                                        });  
                                                          
                                                    }else{

                                                        $('#dataTables-example').DataTable({
                                                            order: [[0, "desc"]],
                                                            scrollX: true
                                                        }); 
                                                    }
                                                });
                                            }
                                        });
                                    }
        </script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').DataTable({

                    order: [[0, "desc"]],
                    scrollX: true


                });
            });
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                        .columns.adjust()
                        .responsive.recalc();
            });
        </script>
        <script>
            function pdf_transportprice()
            {

                window.open('pdf_transportprice.php', '_blank');
            }

        </script>
        <script>

            // append row to the HTML table
            function appendRow() {
                var tbl = document.getElementById('dataTables-example'), // table reference
                        row = tbl.insertRow(tbl.rows.length), // append table row
                        i;
                // insert table cells to the new row
                for (i = 0; i < tbl.rows[2].cells.length; i++) {
                    createCell(row.insertCell(i), '', 'row');
                }
            }

// create DIV element and append to the table cell
            function createCell(cell, text, style) {
                var div = document.createElement('div'), // create DIV element
                        txt = document.createTextNode(text); // create text node
                div.appendChild(txt); // append text node to the DIV
                div.setAttribute('class', style); // set DIV class attribute
                div.setAttribute('className', style); // set DIV class attribute for IE (?!)
                cell.appendChild(div); // append DIV to the table cell
            }
// append column to the HTML table
            function appendColumn() {
                var tbl = document.getElementById('dataTables-example'), // table reference
                        i;
                // open loop for each row and append cell
                for (i = 0; i < tbl.rows.length; i++) {
                    createCell(tbl.rows[i].insertCell(tbl.rows[i].cells.length), '', 'col');
                }
            }
// delete table rows with index greater then 0
            function deleteRows() {
                var tbl = document.getElementById('dataTables-example'), // table reference
                        lastRow = tbl.rows.length - 1, // set the last row index
                        i;
                // delete rows with index greater then 0
                for (i = lastRow; i > 2; i--) {
                    tbl.deleteRow(i);
                }
            }

// delete table columns with index greater then 0
            function deleteColumns() {
                var tbl = document.getElementById('dataTables-example'), // table reference
                        lastCol = tbl.rows[0].cells.length - 1, // set the last column index
                        i, j;
                // delete cells with index greater then 0 (for each row)
                for (i = 0; i < tbl.rows.length; i++) {
                    for (j = lastCol; j > 5; j--) {
                        tbl.rows[i].deleteCell(j);
                    }
                }
            }
        </script>
        <script>
            function save_vehicletransportprice(companycode, customercode)
            {
               

                var rs1 = document.getElementById("txt_yinjob").value.split(",");
                var rs2 = document.getElementById("txt_monthst").value.split(",");
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "save_vehicletransportprice",
                        CONDITION1: rs1[0],
                        CONDITION2: '',
                        CONDITION3: '',
                        CONDITION4: '',
                        VEHICLEDESCCODE: '1',
                        WORKTYPE: '<?= $_GET['worktype'] ?>',
                        COMPANYCODE: companycode,
                        CUSTOMERCODE: customercode,
                        MONTHST: rs2[1],
                        ACTIVESTATUS: '1',
                        CARRYTYPE: '<?= $_GET['carrytype'] ?>'

                    },
                    success: function (rs) {

                        alert(rs);
                        select_vehicletransportprice();

                    }
                });
            }


            function delete_vehicletransportprice(vehicletransportpriceid)
            {

                var confirmation = confirm("ต้องการลบข้อมูล ?");
                if (confirmation) {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "delete_vehicletransportprice", vehicletransportpriceid: vehicletransportpriceid
                        },
                        success: function () {

                            select_vehicletransportprice();
                            window.location.reload();
                        }
                    });
                }
            }
            function delete_vehicletransportpriceavgkm(vehicletransportpriceid)
            {

                var confirmation = confirm("ต้องการลบข้อมูล ?");
                if (confirmation) {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "delete_vehicletransportpriceavgkm", vehicletransportpriceid: vehicletransportpriceid
                        },
                        success: function () {

                            select_vehicletransportprice();
                        }
                    });
                }
            }
        </script>
        <script>

            function editvar_vehicletransportprice(editableObj, fieldname, ID) {
                var rs = document.getElementById("txt_monthst").value.split(",");
              
                var dataedit = editableObj.innerHTML;
                $.ajax({
                    url: 'meg_data.php',
                    type: 'POST',
                    data: {
                        txt_flg: "edit_vehicletransportpricenew", editableObj: dataedit, ID: ID, fieldname: fieldname, monthst: rs[1]
                    },
                    success: function () {
                        
                    }
                });
            }

            function edit_vehicletransportprice(editableObj, fieldname, ID) {


                $.ajax({
                    url: 'meg_data.php',
                    type: 'POST',
                    data: {
                        txt_flg: "edit_vehicletransportprice", editableObj: editableObj, ID: ID, fieldname: fieldname
                    },
                    success: function () {

                    }
                });
            }
            function edit_vehicletransportpriceavgkm(editableObj, fieldname, ID, vehicletype) {

                $.ajax({
                    url: 'meg_data.php',
                    type: 'POST',
                    data: {
                        txt_flg: "edit_vehicletransportpriceavgkm", editableObj: editableObj, ID: ID, fieldname: fieldname, vehicletype: vehicletype
                    },
                    success: function () {

                    }
                });
            }
        </script>
        <script>
            function editnum_vehicletransportprice(editableObj, fieldname, ID) {


                var dataedit;
                if (editableObj.innerHTML == "")
                {
                    dataedit = "0";
                } else if (isNaN(editableObj.innerHTML))
                {
                    alert("กรอกได้เฉพาะตัวเลข !!!");
                    editableObj.innerHTML = "0";
                    dataedit = "0";
                } else
                {
                    dataedit = editableObj.innerHTML;
                }
                $.ajax({
                    url: 'meg_data.php',
                    type: 'POST',
                    data: {
                        txt_flg: "edit_vehicletransportprice", editableObj: dataedit, ID: ID, fieldname: fieldname
                    },
                    success: function () {

                    }
                });
            }
        </script>
    </body>


</html>
<?php
sqlsrv_close($conn);
?>
