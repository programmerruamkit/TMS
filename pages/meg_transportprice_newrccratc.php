
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

        <!-- MODAL เพิ่มข้อมูลพื้นฐาน -->
        <div class="modal fade" id="modal_addtransportpricemaster" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 30%">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 class="modal-title" id="title_copydiagram"><b>เพิ่มข้อมูลพื้นฐาน</b></h5>
                            </div>

                        </div>
                    </div>
                    <div id="modaladdtransportpricemastersr"></div>

                </div>
            </div>
        </div>
        <!-- END MODAL -->
        
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
            <div class="col-lg-12" style="text-align: right">
                <div class="panel-heading" >
                    <!-- <a href="#" onclick="pdf_transportprice();" class="btn btn-default">PDF <li class="fa fa-print"></li></a> -->
                </div>
            </div>
            <div class="col-lg-12" style="text-align: right">
                <button style="margin-right: 15px;"  type="button" onclick="edit_masterjobstart()"  id="addprice" name="addprice" class="btn btn-outline btn-default"><li class="fa fa-copy"></li> จัดการข้อมูลมาสเตอร์ต้นทาง</button>
                <!-- <button style="margin-right: 15px;"  type="button" onclick="save_vehicletransportprice('<?= $_GET['companycode'] ?>', '<?= $_GET['customercode'] ?>')"  id="addrow" name="addrow" class="btn btn-outline btn-default"><li class="fa fa-plus-circle"></li> เพิ่มราคาขนส่ง</button> -->
                <button style="margin-right: 15px;"  type="button" data-toggle="modal" data-target="#modal_addtransportpricemaster" onclick="modaladdtransportpricemaster('<?= $_GET['companycode'] ?>', '<?= $_GET['customercode'] ?>')" id="addmasterdata" name="addmasterdata" class="btn btn-outline btn-default"><li class="fa fa-plus-circle"></li> เพิ่มข้อมูลพื้นฐาน</button>
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
                                
                                    echo "<a href='report_newcompanypricegetway.php?type=report'>บริษัท</a> / <a href='report_newcustomerpricegetway.php?type=report&companycode=" . $_GET['companycode'] . "'>ลูกค้า</a>  / " . $meg;
                                    $link = "<a href='report_newcompanypricegetway.php?type=report'>บริษัท</a> / <a href='report_newcustomerpricegetway.php?type=report&companycode=" . $_GET['companycode'] . "'>ลูกค้า</a> ";
                               

                                $_SESSION["link"] = $link;
                                ?>
                            </div>

                            <div class="col-lg-1 text-right"></div>
                            <div class="col-lg-1 text-right"></div>
                            <div class="col-lg-1 text-right"></div>
                            <div class="col-lg-3 text-right">ประเภทงาน (<?= $_GET['worktype'] ?>) / <?= $result_seCustomer['NAMETH'] ?></div>



                        </div>
                    </div>
                    <!-- /.panel-heading -->

                    <div class="panel-body">
                        <div id="datadef">
                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer" >
                                <table  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example" >
                                    
                                        <thead >
                                            <tr>
                                                <th title="ID" style="text-align: center;width: 100px">ID6</th>
                                                <th title="จัดการ" style="text-align: center;width: 100px">จัดการ</th>
                                                <th title="VEHICLEDESCCODE" style="text-align: center;width: 200px">VEHICLEDESCCODE</th>
                                                <th title="COMPANYCODE" style="text-align: center;width: 200px">COMPANYCODE</th>
                                                <th title="CUSTOMERCODE" style="text-align: center;width: 200px">CUSTOMERCODE</th>
                                                <th title="REGION" style="text-align: center;width: 200px">WORKTYPE</th>
                                                <th title="CLUSTER" style="text-align: center;width: 200px">CARRYTYPE</th>
                                                <th title="CLUSTER_TH" style="text-align: center;width: 200px">CLUSTER</th>
                                                <th title="DEALERCODE" style="text-align: center;width: 200px">DEALERCODE</th>
                                                <th title="BEGINJOB" style="text-align: center;width: 200px">BASE4L</th>
                                                <th title="NAME" style="text-align: center;width: 200px">INCENTIVE4L</th>
                                                <th title="BEGINJOB" style="text-align: center;width: 200px">BASE8L</th>
                                                <th title="NAME" style="text-align: center;width: 200px">INCENTIVE8L</th>
                                                <th title="E1" style="text-align: center;width: 200px">E1</th>
                                                <th title="E1" style="text-align: center;width: 200px">E2</th>
                                                <th title="ACTIVESTATUS" style="text-align: center;width: 200px">ACTIVESTATUS</th>
                                                <th title="REMARK" style="text-align: center;width: 200px">REMARK</th>
                                                <th title="CREATEBY" style="text-align: center;width: 200px">CREATEBY</th>
                                                <th title="CREATEDATE" style="text-align: center;width: 200px">CREATEDATE</th>
                                                <th title="MODIFIEDBY" style="text-align: center;width: 200px">MODIFIEDBY</th>
                                                <th title="MODIFIEDDATE" style="text-align: center;width: 200px">MODIFIEDDATE</th>
                                            </tr>
                                        </thead>
                                    <tbody>
                                        <?php
                                        
                                            // $data = explode(",",$_POST['monthst']);
                                            
                                            $condVehicletransportprice1 = " AND COMPANYCODE ='" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                                            $condVehicletransportprice2 = " AND WORKTYPE = '" . $_GET['worktype'] . "' AND CARRYTYPE = 'trip' AND ACTIVESTATUS = 1";
                                         
                                          
                                            $sql_seVehicletransportprice = "{call megVehicletransportprice_v2(?,?,?,?)}";
                                            $params_seVehicletransportprice = array(
                                            array('select_vehicletransportprice_new_rccratc', SQLSRV_PARAM_IN),
                                            array($condVehicletransportprice1, SQLSRV_PARAM_IN),
                                            array($condVehicletransportprice2, SQLSRV_PARAM_IN),
                                            array('', SQLSRV_PARAM_IN)
                                            );
                                            
                                            $query_seVehicletransportprice = sqlsrv_query($conn, $sql_seVehicletransportprice, $params_seVehicletransportprice);
                                            while ($result_seVehicletransportprice = sqlsrv_fetch_array($query_seVehicletransportprice, SQLSRV_FETCH_ASSOC)) {
                                            ?>
                                            <tr >
                                                <td style="text-align: center;">
                                                    <?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>
                                                </td>
                                                <td style="text-align: center;">
                                                    <button onclick="confirm_delete('<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                                    <!-- <button onclick="edit_rrc('<?= $result_seVehicletransportprice['COMPANYCODE'] ?>', '<?= $result_seVehicletransportprice['CUSTOMERCODE'] ?>', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>', '<?= $result_seVehicletransportprice['VEHICLETYPE'] ?>', '<?= $result_seVehicletransportprice['FROM'] ?>', '<?= $result_seVehicletransportprice['TO'] ?>')" title="แก้ไขข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></span></button> -->
                                                    <!-- <button onclick="edit_rcctttsh('<?= $result_seVehicletransportprice['COMPANYCODE'] ?>', '<?= $result_seVehicletransportprice['CUSTOMERCODE'] ?>', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>', '<?= $result_seVehicletransportprice['TO'] ?>')" title="แก้ไขข้อมูล" type="button" class="btn btn-default btn-circle" ><span class="glyphicon glyphicon-wrench"></span></button> -->
                                                </td>
                                                <td style="background-color:#f080802e"><?= $result_seVehicletransportprice['VEHICLEDESCCODE'] ?></td>
                                                <td style="background-color:#f080802e"><?= $result_seVehicletransportprice['COMPANYCODE'] ?></td>
                                                <td style="background-color:#f080802e"><?= $result_seVehicletransportprice['CUSTOMERCODE'] ?></td>
                                                <td style="background-color:#f080802e"><?= $result_seVehicletransportprice['WORKTYPE'] ?></td>
                                                <td style="background-color:#f080802e"><?= $result_seVehicletransportprice['CARRYTYPE'] ?></td>
                                                <td style="text-align: center;">
                                                    <select disabled=""  class="form-control" id="cb_cluster<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" name="cb_cluster<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>">
                                                    <option value ="<?= $result_seVehicletransportprice['CLUSTER'] ?>"><?= $result_seVehicletransportprice['CLUSTER'] ?></option>
                                                    </select>
                                                    <div id="div_clustersr<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>"></div>
                                                </td>
                                                <td style="background-color:#f080802e "><?= $result_seVehicletransportprice['DEALERCODE'] ?></td>
                                               
                                                <td  contenteditable="false" style="background-color:#f080802e" onkeyup="editvar_vehicletransportprice(this, 'BASE4L', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['BASE4L'] ?></td>
                                                <td  contenteditable="false" style="background-color:#f080802e" onkeyup="editvar_vehicletransportprice(this, 'INCENTIVE4L', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['INCENTIVE4L'] ?></td>
                                                <td  contenteditable="false" style="background-color:#f080802e" onkeyup="editvar_vehicletransportprice(this, 'BASE8L', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['BASE8L'] ?></td>
                                                <td  contenteditable="false" style="background-color:#f080802e" onkeyup="editvar_vehicletransportprice(this, 'INCENTIVE8L', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['INCENTIVE8L'] ?></td>
                                                
                                                <td contenteditable="true"  style="text-align: center;" onkeyup="editvar_vehicletransportprice(this, 'E1', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['E1'] ?></td>
                                               
                                                <td contenteditable="true"  style="text-align: center;" onkeyup="editvar_vehicletransportprice(this, 'E2', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['E2'] ?></td>
                                               
                                                <td style="background-color:#f080802e" ><?= $result_seVehicletransportprice['ACTIVESTATUS'] ?></td>
                                                <td style="background-color:#f080802e" contenteditable="false"  onkeyup="editvar_vehicletransportprice(this, 'REMARK', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['REMARK'] ?></td>
                                                <td style="background-color:#f080802e"><?= $result_seVehicletransportprice['CREATEBY'] ?></td>
                                                <td style="background-color:#f080802e"><?= $result_seVehicletransportprice['CREATEDATE'] ?></td>
                                                <td style="background-color:#f080802e"><?= $result_seVehicletransportprice['MODIFIEDBY'] ?></td>
                                                <td style="background-color:#f080802e"><?= $result_seVehicletransportprice['MODIFIEDDATE'] ?></td>
                                            </tr>
                                        <?php
                                        }
                                    
                                    ?>
                                    </tbody>
                                </table>
                                </div>         
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
                                    

                                    function add_transportpricemaster(vehicledesccode, companycode, customercode, worktype, activestatus)
                                    {

                                        // alert(vehicledesccode);
                                        // alert(companycode);
                                        // alert(customercode);
                                        // alert(worktype);
                                        // alert(activestatus);
                                        let cluster = $("#txt_cluster").val();
                                        // alert(cluster);
                                        if (cluster == '') {
                                            swal.fire({
                                                title: "Warning!",
                                                text: "ข้อมูลคลัสเตอร์เป็นค่าว่าง!!",
                                                icon: "warning",
                                                showConfirmButton: true,
                                            });
                                        }else{

                                            $.ajax({
                                                type: 'post',
                                                url: 'meg_data_transportprice_newrccratc.php',
                                                data: {

                                                    txt_flg: "save_vehicletransportpricemaster_newrccratc", vehicledesccode: vehicledesccode, worktype: worktype, companycode: companycode, customercode: customercode, activestatus: activestatus, data1: document.getElementById("txt_cluster").value, data2: '', data3: '', data4: '', data5: ''

                                                },
                                                success: function (rs) {
                                                    // alert(rs);
                                                    swal.fire({
                                                        title: "Good Job!",
                                                        text: "บันทึกข้อมูลเรียบร้อย",
                                                        icon: "success",
                                                        showConfirmButton: false,
                                                    });
                                                    setTimeout(function(){
                                                        window.location.reload();
                                                    }, 1200);
                                                    // window.location.reload();
                                                }
                                            }); 
                                        }   
                                    }
                                    function modaladdtransportpricemaster()
                                    {
                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data_transportprice_newrccratc.php',
                                            data: {
                                                txt_flg: "modal_addtransportpricemaster", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', worktype: '<?= $_GET['worktype'] ?>'
                                            },
                                            success: function (rs) {
                                                document.getElementById("modaladdtransportpricemastersr").innerHTML = rs;
                                            }


                                        });
                                    }

                                    function edit_masterjobstart()
                                    {
                                        // alert('<?= $_GET['worktype'] ?>');
                                        window.open("meg_editmasterpricerccratc.php");
                                    }
                                    function confirm_delete(vehicletransportpriceid)
                                    {
                                        Swal.fire({
                                            title: 'ต้องการลบข้อมูล?',
                                            text: "กรุณากด 'ตกลง' เพื่อยืนยันการลบข้อมูล!!!",
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: 'ตกลง',
                                            cancelButtonText: 'ยกเลิก'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                // Swal.fire(
                                                // 'Deleted!',
                                                // 'Your file has been deleted.',
                                                // 'success'
                                                // )
                                                delete_vehicletransportprice(vehicletransportpriceid);   
                                            }else{
                                                // window.location.reload();
                                            }
                                        })
                                    }
                                    function delete_vehicletransportprice(vehicletransportpriceid)
                                    {
                                    
                                        // alert(vehicletransportpriceid);
                                        // var confirmation = confirm("ต้องการลบข้อมูล ?");
                                        // if (confirmation) {
                                            $.ajax({
                                                type: 'post',
                                                url: 'meg_data_transportprice_newrccratc.php',
                                                data: {
                                                    txt_flg: "delete_vehicletransportprice_newrccratc", vehicletransportpriceid: vehicletransportpriceid
                                                },
                                                success: function () {
                                                    swal.fire({
                                                        title: "Deleted!",
                                                        text: "ลบข้อมูลเรียบร้อย",
                                                        icon: "success",
                                                        showConfirmButton: false,
                                                    });
                                                    setTimeout(function(){
                                                        window.location.reload();
                                                    }, 1200);
                                                    // select_vehicletransportprice();
                                                    // window.location.reload();
                                                }
                                            });
                                        // }
                                    }
                                    function editvar_vehicletransportprice(editableObj, fieldname, priceid) 
                                    {
                                      
                                        var dataedit = editableObj.innerHTML;
                                        // alert(dataedit);
                                        // alert(fieldname);
                                        // alert(priceid);

                                        $.ajax({
                                            url: 'meg_data_transportprice_newrccratc.php',
                                            type: 'POST',
                                            data: {
                                                txt_flg: "edit_vehicletransportprice_new_rccratc", editableObj: dataedit,fieldname: fieldname, priceid: priceid 
                                            },
                                            success: function (rs) {
                                                // alert(rs);
                                            }
                                        });
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

                                    $(document).ready(function () {
                                        $('#dataTables-example').DataTable({
                                            order: [[0, "desc"]],
                                            scrollX: true
                                        });
                                    });

                                    // $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                                    //     $($.fn.dataTable.tables(true)).DataTable()
                                    //     .columns.adjust()
                                    //     .responsive.recalc();
                                    // });
            
        </script>
    </body>


</html>
<?php
sqlsrv_close($conn);
?>
