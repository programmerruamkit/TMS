<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");


$condition1 = " AND (a.USERNAME ='" . $_SESSION["USERNAME"] . "' AND a.PASSWORD = '" . $_SESSION["PASSWORD"] . "') AND a.ACTIVESTATUS = 1";
$sql_seLogin = "{call megRoleaccount_v2(?,?)}";
$params_seLogin = array(
    array('select_roleaccount', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seLogin = sqlsrv_query($conn, $sql_seLogin, $params_seLogin);
$result_seLogin = sqlsrv_fetch_array($query_seLogin, SQLSRV_FETCH_ASSOC);

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

$billingcode = create_billing();

$condiCompany = " AND Company_Code = '" . $_GET['companycode'] . "'";
$sql_seCompany = "{call megCompany_v2(?,?)}";
$params_seCompany = array(
    array('select_company', SQLSRV_PARAM_IN),
    array($condiCompany, SQLSRV_PARAM_IN)
);
$query_seCompany = sqlsrv_query($conn, $sql_seCompany, $params_seCompany);
$result_seCompany = sqlsrv_fetch_array($query_seCompany, SQLSRV_FETCH_ASSOC);

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
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">


        <link href="../dist/css/buttons.dataTables.min.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">

        <style>

            .navbar-default {

                border-color: #ffcb0b;
            }
            #page-wrapper {

                border-left: 1px solid #ffcb0b;
            }

        </style>

        <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="js/jquery.form.min.js"></script>


        <link href="style/style.css" rel="stylesheet" type="text/css">

    </head>

    <body >



        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <?php
                include '../pages/meg_header.php';
                include '../pages/meg_leftmenu.php';
                ?>
            </nav>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="page-header"><i class="fa fa-file-text-o"></i>
                            รายงานเอกสารวางบิล
                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>


                <div class="row">


                    <div class="col-lg-2">

                        <div class="form-group">
                            <label>ค้นหาตามช่วงวันที่</label>
                            <input class="form-control dateen" readonly="" onchange="datetodate();" style="background-color: #f080802e" id="txt_datestart" name="txt_datestart" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">

                        </div>

                    </div>
                    <div class="col-lg-2">
                        <label>&nbsp;</label>
                        <div class="form-group">
                            <input type="text" class="form-control dateen" readonly="" style="background-color: #f080802e" id="txt_dateend" name="txt_dateend" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">

                        </div>
                    </div>


                    <div class="col-lg-2">
                        <label>&nbsp;</label>
                        <div class="form-group">
                            <button type="button" class="btn btn-default" onclick="select_logbilling();">ค้นหา <li class="fa fa-search"></li></button>
                        </div>

                    </div>

                </div>

                <div class="row" >
                    <div class="col-lg-12">
                        &nbsp;

                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-lg-6">


                                        <?php
                                        $meg = 'รายการเอกสารวางบิล';
                                        if ($_GET['companycode'] == 'RKL' || $_GET['companycode'] == 'RKS' || $_GET['companycode'] == 'RKR') {
                                            echo "<a href='report_companybillingamata.php?type=report'>บริษัท</a> / <a href='report_customerbillingamata.php?type=report&companycode=" . $_GET['companycode'] . "'>ลูกค้า</a>  / " . $meg;
                                            $link = "<a href='report_companybillingamata.php?type=report'>บริษัท</a> / <a href='report_customerbillingamata.php?type=report&companycode=" . $_GET['companycode'] . "'>ลูกค้า</a> ";
                                        } else {
                                            echo "<a href='report_companybillinggetway.php?type=report'>บริษัท</a> / <a href='report_customerbillinggetway.php?type=report&companycode=" . $_GET['companycode'] . "'>ลูกค้า</a>  / " . $meg;
                                            $link = "<a href='report_companybillinggetway.php?type=report'>บริษัท</a> / <a href='report_customerbillinggetway.php?type=report&companycode=" . $_GET['companycode'] . "'>ลูกค้า</a> ";
                                        }

                                        $_SESSION["link"] = $link;
                                        ?>
                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <?= $result_seCompany['Company_NameT'] ?> / <?= $result_seCustomer['NAMETH'] ?>
                                    </div>
                                </div>
                            </div>
                            <!-- /.panel-heading -->

                            <div class="panel-body">


                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                    <div id="datadef">
                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                            <thead>
                                                <tr>

                                                    <th style="text-align: center;width: 10%">ลำดับ</th>
                                                    <th>เลขที่</th>
                                                    <th style="text-align: center;width: 10%">ข้อมูลย่อย</th>
                                                    <th style="text-align: center;width: 10%"><a href="#" onclick="save_logbilling('<?= 'BI' . $billingcode ?>')">เพิ่มใบวางบิล</a></th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;

                                                $condLogbilling1 = " AND CONVERT(DATE,CREATEDATE) BETWEEN CONVERT(DATE,GETDATE(),103) AND CONVERT(DATE,GETDATE(),103)";
                                                $condLogbilling2 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "' ";
                                                $sql_seLogbilling = "{call megLogbilling_v2(?,?,?)}";
                                                $params_seLogbilling = array(
                                                    array('select_logbilling', SQLSRV_PARAM_IN),
                                                    array($condLogbilling1, SQLSRV_PARAM_IN),
                                                    array($condLogbilling2, SQLSRV_PARAM_IN)
                                                );


                                                $query_seLogbilling = sqlsrv_query($conn, $sql_seLogbilling, $params_seLogbilling);
                                                while ($result_seLogbilling = sqlsrv_fetch_array($query_seLogbilling, SQLSRV_FETCH_ASSOC)) {

                                                    $sql_Billing = "SELECT DISTINCT a.BILLING FROM [dbo].[LOGINVOICE] a
                                                    INNER JOIN [LOGBILLINGINVOICE] b ON a.INVOICECODE = b.INVOICECODE
                                                    WHERE b.BILLINGCODE = '" . $result_seLogbilling['BILLINGCODE'] . "'";
                                                    $query_seBilling = sqlsrv_query($conn, $sql_Billing, $params_seBilling);
                                                    $result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC);
                                                    
                                                    $sql_invoicecode1 = "SELECT TOP 1 INVOICECODE FROM [dbo].[LOGBILLINGINVOICE] 
                                                                        WHERE BILLINGCODE ='".$result_seLogbilling['BILLINGCODE']."'
                                                                        ORDER BY CREATEDATE ASC";
                                                    $params_invoicecode1 = array();
                                                    $query_invoicecode1 = sqlsrv_query($conn, $sql_invoicecode1, $params_invoicecode1);
                                                    $result_invoicecode1 = sqlsrv_fetch_array($query_invoicecode1, SQLSRV_FETCH_ASSOC);

                                                    $sql_invoicecode2 = "SELECT TOP 1 INVOICECODE FROM [dbo].[LOGBILLINGINVOICE] 
                                                                        WHERE BILLINGCODE ='".$result_seLogbilling['BILLINGCODE']."'
                                                                        ORDER BY CREATEDATE DESC";
                                                    $params_invoicecode2 = array();
                                                    $query_invoicecode2 = sqlsrv_query($conn, $sql_invoicecode2, $params_invoicecode2);
                                                    $result_invoicecode2 = sqlsrv_fetch_array($query_invoicecode2, SQLSRV_FETCH_ASSOC);

                                                    ?>
                                                    <tr class="odd gradeX">

                                                        <td style="text-align: center;width: 10%"><?= $i ?></td>
                                                        <td><?= $result_seLogbilling['BILLINGCODE'] ?><b>(<?=$result_invoicecode1['INVOICECODE']?>)</b>,<b>(<?=$result_invoicecode2['INVOICECODE']?>)</b></td>
                                                        <td style="text-align: center">
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                                    <i class="fa fa-chevron-down"></i>
                                                                </button>
                                                                <ul class="dropdown-menu slidedown">


                                                                    <li>
                                                                        <a href="meg_billing.php?billingcode=<?= $result_seLogbilling['BILLINGCODE'] ?>&companycode=<?= $_GET['companycode'] ?>&customercode=<?= $_GET['customercode'] ?>&carrytype=<?= $_GET['carrytype'] ?>">
                                                                            ใบส่งสินค้า
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                            </div>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <?php
                                                            if ($result_seBilling['BILLING'] == 'pallet') {
                                                                ?>
                                                                <button onclick="pdf_invoicepallet2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                <?php
                                                            } else {
                                                                if ($_GET['companycode'] == 'RRC') {
                                                                    if ($_GET['customercode'] == 'SWN') {
                                                                        ?>
                                                                        <button onclick="pdf_invoiceswn2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                        <?php
                                                                    }
                                                                    if ($_GET['customercode'] == 'GMT') {
                                                                        ?>
                                                                        <button onclick="pdf_invoicegmt2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                        <?php
                                                                    }
                                                                    if ($_GET['customercode'] == 'GMT-IB') {
                                                                        ?>
                                                                        <button onclick="pdf_invoicegmt_ib2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                        <?php
                                                                    }
                                                                    if ($_GET['customercode'] == 'BP') {
                                                                        ?>
                                                                        <button onclick="pdf_invoicebp2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                        <?php
                                                                    }
                                                                    if ($_GET['customercode'] == 'TTAST') {
                                                                        ?>
                                                                        <button onclick="pdf_invoicettast2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                        <?php
                                                                    }
                                                                     if ($_GET['customercode'] == 'TTTC') {
                                                                        ?>
                                                                        <button onclick="pdf_invoicetttc2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                        <?php
                                                                    }
                                                                    if ($_GET['customercode'] == 'THAIDAISEN') {
                                                                      ?>
                                                                      <button onclick="pdf_invoicethaidaisen2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                      <?php
                                                                   }
                                                                } else if ($_GET['companycode'] == 'RKS') {
                                                                    if ($_GET['customercode'] == 'TAW') {
                                                                        ?>
                                                                        <button onclick="pdf_invoicerkstaw2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                        <?php
                                                                    } else if ($_GET['customercode'] == 'TGT') {
                                                                        ?>
                                                                        <button onclick="pdf_invoicerkstgt2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                        <?php
                                                                    } else if ($_GET['customercode'] == 'TTTC') {
                                                                        ?>
                                                                        <button onclick="pdf_invoicerkstttc2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                        <?php
                                                                    } else if ($_GET['customercode'] == 'NITTSUSHOJI') {
                                                                        ?>
                                                                        <button onclick="pdf_invoicerksnittsushoji2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                        <?php
                                                                    } else if ($_GET['customercode'] == 'HINO') {
                                                                        ?>
                                                                        <button onclick="pdf_invoicerkshino2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                        <?php
                                                                    } else if ($_GET['customercode'] == 'DENSO-THAI') {
                                                                        ?>
                                                                        <button onclick="pdf_invoicerksdensothai2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                        <?php
                                                                    } else if ($_GET['customercode'] == 'TMT') {
                                                                        ?>
                                                                        <button onclick="pdf_invoicerkstmt2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                        <?php
                                                                    } else if ($_GET['customercode'] == 'STM') {
                                                                        ?>
                                                                        <button onclick="pdf_invoicerksstm2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                        <?php
                                                                    } else if ($_GET['customercode'] == 'DAIKI') {
                                                                        ?>
                                                                        <button onclick="pdf_invoicerksdaiki2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                        <button onclick="excel_invoicerksdaiki2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="fa fa-file-excel-o"></span></button>
                                                                        <?php
                                                                    } else if ($_GET['customercode'] == 'GMT') {
                                                                        ?>
                                                                        <button onclick="pdf_invoicerksgmt2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                        <?php
                                                                    } else if ($_GET['customercode'] == 'TKT') {
                                                                        ?>
                                                                        <button onclick="pdf_invoicerkstkt2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                        <?php
                                                                    }else if ($_GET['customercode'] == 'TDEM') {
                                                                        ?>
                                                                        <button onclick="pdf_invoicerkstdem2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                        <?php
                                                                    }
                                                                    else if ($_GET['customercode'] == 'SWN') {
                                                                        ?>
                                                                        <button onclick="pdf_invoicerksswn2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                        <?php
                                                                    }else if ($_GET['customercode'] == 'THAITOHKEN') {
                                                                        ?>
                                                                        <button onclick="pdf_invoicerksthaitohken2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                        <?php
                                                                    }else if ($_GET['customercode'] == 'COPPERCORD') {
                                                                        ?>
                                                                        <button onclick="pdf_invoicerkscoppercord2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                        <?php
                                                                    }else if ($_GET['customercode'] == 'TSAT') {
                                                                        ?>
                                                                        <button onclick="pdf_invoicerkstsat2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                        <?php
                                                                    }
                                                                } else if ($_GET['companycode'] == 'RKR') {
                                                                    if ($_GET['carrytype'] == 'trip') {
                                                                        if ($_GET['customercode'] == 'DAIKI') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkrdaiki2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'TTPRO') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkrttpro2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'TTAST') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkrttast2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'TTAT') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkrttat2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'TMT') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkrtmt2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'TGT') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkrtgt2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'TTTC') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkrtttc2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'YNP') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkrynp2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'GMT') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkrgmt2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        }
                                                                        else if ($_GET['customercode'] == 'SUTT') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkrsutt2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        }
                                                                        else if ($_GET['customercode'] == 'TKT') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkrtkt2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        }
                                                                        else if ($_GET['customercode'] == 'TID') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkrtid2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        }
                                                                        else if ($_GET['customercode'] == 'HINO') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkrhino2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        }
                                                                         else if ($_GET['customercode'] == 'NITTSUSHOJI') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkrnittsushoji2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        }
                                                                        else if ($_GET['customercode'] == 'CH-AUTO') {
                                                                           ?>
                                                                           <button onclick="pdf_invoicerkrchauto2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                           <?php
                                                                       }
                                                                       else if ($_GET['customercode'] == 'TDEM') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkrtdem2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        }
                                                                        else if ($_GET['customercode'] == 'RNSTEEL') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkrrnsteel2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        }
                                                                        else if ($_GET['customercode'] == 'PJW') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkrpjw2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        }else if ($_GET['customercode'] == 'TSAT') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkrtsat2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        }
                                                                    } else if ($_GET['carrytype'] == 'weight') {
                                                                        if ($_GET['customercode'] == 'PARAGON') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkrparagon2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } 
                                                                        else if ($_GET['customercode'] == 'TTPROSTC') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkrttprostc2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'TTASTSTC') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkrttaststc2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'TTASTCS') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkrttastcs2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'TTTCSTC') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkrtttcstc2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'TTAST') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkrttastotherweight('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        }  else if ($_GET['customercode'] == 'DAIKI') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkrdaikiton2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        }
                                                                    }
                                                                } else if ($_GET['companycode'] == 'RKL') {
                                                                    if ($_GET['carrytype'] == 'weight') {
                                                                        if ($_GET['customercode'] == 'DAIKI') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkldaikiton2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'TTPROSTC') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerklttprostc2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'TTASTSTC') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerklttaststc2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'TTASTCS') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerklttastcs2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'TTTCSTC') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkltttcstc2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        }
                                                                    } else if ($_GET['carrytype'] == 'trip') {
                                                                        if ($_GET['customercode'] == 'SKB') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerklskb2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'TTTC') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkltttc2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'CH-AUTO') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerklchauto2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'TDEM') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkltdem2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'TTAT') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerklttat2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'TKT') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkltkt2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'TSAT') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkltsat2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        }else if ($_GET['customercode'] == 'TSPT') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkltspt2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'YNP') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerklynp2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'WSBT') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerklwsbt2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'TMT') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkltmt2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'NITTSUSHOJI') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerklnittsushoji2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'COPPERCORD') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerklcoppercord2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'GMT') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerklgmt2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'SUTT') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerklsutt2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'TID') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerkltid2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'HINO') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerklhino2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'OLT') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerklolt2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'RNSTEEL') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerklrnsteel2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'VUTEQ') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerklvuteq2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        } else if ($_GET['customercode'] == 'PJW') {
                                                                            ?>
                                                                            <button onclick="pdf_invoicerklpjw2('<?= $result_seLogbilling['BILLINGCODE'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                            <button onclick="delete_billing('<?= $result_seLogbilling['LOGBILLINGID'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>



                                            </tbody>

                                        </table>

                                    </div>
                                    <div id="datasr"></div>
                                </div>

                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!--<script src="../vendor/jquery/jquery.min.js"></script>-->
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
        <script src="../dist/js/sb-admin-2.js"></script>
        <script src="../js/jquery.datetimepicker.full.js"></script>

        <script src="../dist/js/jszip.min.js"></script>
        <script src="../dist/js/dataTables.buttons.min.js"></script>
        <script src="../dist/js/buttons.html5.min.js"></script>
        <script src="../dist/js/buttons.print.min.js"></script>
        <script src="../dist/js/bootstrap-select.js"></script>
        <script src="../dist/js/jquery.autocomplete.js"></script>

        <script type="text/javascript">
            function save_logprocess(category, process, employeecode)
                                                    {
                                                        $.ajax({
                                                            url: 'meg_data.php',
                                                            type: 'POST',
                                                            data: {
                                                                txt_flg: "save_logprocess", category: category, process: process, employeecode: employeecode
                                                            },
                                                            success: function () {


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

                                                            function select_logbilling()
                                                            {

                                                                var datestart = document.getElementById('txt_datestart').value;
                                                                var dateend = document.getElementById('txt_dateend').value;

                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data.php',
                                                                    data: {
                                                                        txt_flg: "select_logbilling", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', datestart: datestart, dateend: dateend, carrytype: '<?= $_GET['carrytype'] ?>'
                                                                    },
                                                                    success: function (response) {
                                                                        if (response)
                                                                        {
                                                                            document.getElementById("datasr").innerHTML = response;
                                                                            document.getElementById("datadef").innerHTML = "";
                                                                        }

                                                                        $(document).ready(function () {
                                                                            $('#dataTables-example').DataTable({
                                                                                responsive: true
                                                                            });

                                                                        });
                                                                    }
                                                                });
                                                                //}
                                                            }
                                                            function delete_billing(logbillingid)
                                                            {


                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data.php',
                                                                    data: {
                                                                        txt_flg: "delete_billing", logbillingid: logbillingid
                                                                    },
                                                                    success: function () {

                                                                        alert('ลบข้อมูลเรียบร้อยแล้ว');
                                                                        window.location.reload();
                                                                        save_logprocess('Billing', 'Delete Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
                                                                    }
                                                                });
                                                                //}
                                                            }
                                                            function save_logbilling(billingcode)
                                                            {

                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data.php',
                                                                    data: {
                                                                        txt_flg: "save_logbilling", condition1: '', condition2: '', billingcode: billingcode, invoicecode: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>'
                                                                    },
                                                                    success: function () {

                                                                        window.location.reload();
                                                                        save_logprocess('Billing', 'Save Logbilling', '<?= $result_seLogin['PersonCode'] ?>');

                                                                    }
                                                                });

                                                            }
                                                            function pdf_invoicepallet2(billingcode)
                                                            {
                                                                window.open('pdf_invoicepallet2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicegmt2(billingcode)
                                                            {
                                                                window.open('pdf_invoicegmt2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicegmt_ib2(billingcode)
                                                            {
                                                                window.open('pdf_invoicegmt-ib2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoiceswn2(billingcode)
                                                            {
                                                                window.open('pdf_invoiceswn2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicebp2(billingcode)
                                                            {
                                                                window.open('pdf_invoicebp2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicettast2(billingcode)
                                                            {
                                                                window.open('pdf_invoicettast2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicetttc2(billingcode)
                                                            {
                                                                window.open('pdf_invoicetttc2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicethaidaisen2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerrc_thaidaisen2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkstaw2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkstaw2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkstgt2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkstgt2.php?billingcode=' + billingcode, '_blank');
                                                            }function pdf_invoicerkstttc2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkstttc2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkrtttc2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkrtttc2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerksdensothai2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerksdensothai2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkstmt2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkstmt2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerksstm2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerksstm2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerksdaiki2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerksdaiki2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function excel_invoicerksdaiki2(billingcode)
                                                            {
                                                                window.open('excel_billingrksdaiki2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerksgmt2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerksgmt2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkstkt2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkstkt2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkstdem2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkstdem2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerksswn2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerksswn2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerksthaitohken2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerksthaitohken2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkscoppercord2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkscoppercord2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkrdaiki2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkrdaiki2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkrttpro2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkrttpro2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkrttast2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkrttast2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkrttat2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkrttat2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkrtmt2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkrtmt2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkrtgt2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkrtgt2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkrynp2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkrynp2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkrgmt2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkrgmt2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkrsutt2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkrsutt2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkrtkt2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkrtkt2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkrtid2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkrtid2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkrhino2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkrhino2.php?billingcode=' + billingcode, '_blank');
                                                            }function pdf_invoicerkrnittsushoji2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkrnittsushoji2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkrchauto2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkrchauto2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkrtdem(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkrchauto2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkrrnsteel2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkrrnsteel2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerklrnsteel2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerklrnsteel2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerklvuteq2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerklvuteq2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerklpjw2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerklpjw2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkrpjw2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkrpjw2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkrtsat2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkrtsat2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                             function pdf_invoicerkrparagon2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkrparagon2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkrttprostc2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkrttprostc2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkrttaststc2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkrttaststc2.php?billingcode=' + billingcode, '_blank');
                                                                save_logprocess('Billing', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
                                                            }
                                                            function pdf_invoicerkrttastcs2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkrttastcs2.php?billingcode=' + billingcode, '_blank');
                                                            }function pdf_invoicerkrttastotherweight(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkrttastotherweight2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkrdaikiton2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkrdaikiton2.php?billingcode=' + billingcode, '_blank');
                                                            }

                                                            function pdf_invoicerkldaikiton2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkldaikiton2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerklttprostc2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerklttprostc2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerklttaststc2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerklttaststc2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerklttastcs2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerklttastcs2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkltttcstc2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkltttcstc2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerklskb2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerklskb2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkltttc2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkltttc2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerklchauto2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerklchauto2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkltdem2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkltdem2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerklttat2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerklttat2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkltkt2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkltkt2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkltsat2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkltsat2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkltspt2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkltspt2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerklynp2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerklynp2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerklwsbt2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerklwsbt2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkltmt2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkltmt2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerklnittsushoji2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerklnittsushoji2.php?billingcode=' + billingcode, '_blank');
                                                            } 
                                                            function pdf_invoicerkshino2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkshino2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerklcoppercord2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerklcoppercord2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerklgmt2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerklgmt2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerklsutt2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerklsutt2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerkltid2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerkltid2.php?billingcode=' + billingcode, '_blank');
                                                            }
                                                            function pdf_invoicerklhino2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerklhino2.php?billingcode=' + billingcode, '_blank');
                                                            }

                                                            function pdf_invoicerklolt2(billingcode)
                                                            {
                                                                window.open('pdf_invoicerklolt2.php?billingcode=' + billingcode, '_blank');
                                                            }


                                                            function gdatetodate()
                                                            {
                                                                document.getElementById('txt_gdateend').value = document.getElementById('txt_gdatestart').value;
                                                            }
                                                            function datetodate()
                                                            {
                                                                document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;

                                                            }

        </script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').DataTable({
                    responsive: true
                });
            });
        </script>

    </body>

</html>
<?php
sqlsrv_close($conn);
?>
