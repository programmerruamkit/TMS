
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
ini_set('max_execution_time', 300);
require_once("../class/meg_function.php");
$conn = connect("RTMS");

@unlink("D:/Downloads/img_transportplan.jpg");

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

$condiReporttransport1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)";
$condiReporttransport2 = " AND a.COMPANYCODE = '" . $_GET['companycode'] . "' AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "'";
$condiReporttransport3 = "";
$sql_seReporttransports = "{call megVehicletransportplan_v2(?,?,?,?)}";
$params_seReporttransports = array(
    array('select_reportvehicletransportplan', SQLSRV_PARAM_IN),
    array($condiReporttransport1, SQLSRV_PARAM_IN),
    array($condiReporttransport2, SQLSRV_PARAM_IN),
    array($condiReporttransport3, SQLSRV_PARAM_IN)
);
$query_seReporttransports = sqlsrv_query($conn, $sql_seReporttransports, $params_seReporttransports);
$result_seReporttransports = sqlsrv_fetch_array($query_seReporttransports, SQLSRV_FETCH_ASSOC);
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


    </head>

    <body>





        <table id="dataTables-example" border="1" width="100%" style="font-size:16px;">
            <thead>
                <tr style="padding:4px;">

                    <th colspan="8" style="padding:4px;text-align:left;width: 50%"><?= $result_seComp['Company_NameT'] ?> / <?= $result_seCustomer['NAMETH'] ?> : <?= $result_seReporttransports['JOBDATE'] ?></th>
                  

                </tr>
                <tr style="padding:4px;">

                    <th style="padding:4px;text-align:center;width: 10%">NO</th>
                    <th style="padding:4px;text-align:center;width: 15%">JOBNO</th>
                    <th style="padding:4px;text-align:center;width: 15%">VEHICLE</th>
                    <th style="padding:4px;text-align:center;width: 15%">DRIVER(1)</th>
                    <th style="padding:4px;text-align:center;width: 15%">DRIVER(2)</th>
                    <th style="padding:4px;text-align:center;width: 15%">TIME</th>
                    <th style="padding:4px;text-align:center;width: 15%">FROM</th>
                    <th style="padding:4px;text-align:center;width: 15%">TO</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;


                $sql_seReporttransport = "{call megVehicletransportplan_v2(?,?,?,?)}";
                $params_seReporttransport = array(
                    array('select_reportvehicletransportplan', SQLSRV_PARAM_IN),
                    array($condiReporttransport1, SQLSRV_PARAM_IN),
                    array($condiReporttransport2, SQLSRV_PARAM_IN),
                    array($condiReporttransport3, SQLSRV_PARAM_IN)
                );
                $query_seReporttransport = sqlsrv_query($conn, $sql_seReporttransport, $params_seReporttransport);
                while ($result_seReporttransport = sqlsrv_fetch_array($query_seReporttransport, SQLSRV_FETCH_ASSOC)) {
                    ?>

                    <tr style="padding:4px;">

                        <td style="padding:4px;text-align:center;"><?= $i ?></td>
                        <td style="padding:4px;text-align:center;"><?= $result_seReporttransport['BOOKNO'] ?></td>
                        <td style="padding:4px;text-align:left;"><?= $result_seReporttransport['VEHICLENO'] ?></td>
                        <td style="padding:4px;text-align:left;"><?= $result_seReporttransport['DRIVER(1)'] ?></td>
                        <td style="padding:4px;text-align:left;"><?= $result_seReporttransport['DRIVER(2)'] ?></td>
                        <td style="padding:4px;text-align:center;"><?= $result_seReporttransport['JOBTIME'] ?></td>
                        <td style="padding:4px;text-align:center;"><?= $result_seReporttransport['FROM'] ?></td>
                        <td style="padding:4px;text-align:center;"><?= $result_seReporttransport['TO'] ?></td>
                        


                    </tr>

                    <?php
                    $i++;
                }
                ?>




            </tbody>

        </table>




        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://zikro.gr/dbg/html/tableExport/tableExport.jquery.plugin/tableExport.js"></script>
        <script src="https://zikro.gr/dbg/html/tableExport/tableExport.jquery.plugin/html2canvas.js"></script>

        <script>



            $(document).ready(function () {


                html2canvas($('#dataTables-example'), {
                    onrendered: function (canvas) {

                        var saveAs = function (uri, filename) {
                            var link = document.createElement('a');
                            if (typeof link.download === 'string') {
                                document.body.appendChild(link); // Firefox requires the link to be in the body
                                link.download = filename;
                                link.href = uri;
                                link.click();
                                document.body.removeChild(link); // remove the link when done
                            } else {
                                location.replace(uri);
                            }
                        };

                        var img = canvas.toDataURL("image/jpg"),
                                uri = img.replace(/^data:image\/[^;]/, 'data:application/octet-stream');

                        saveAs(uri, 'img_transportplan.jpg');

                    }
                });
                window.close();

            });



        </script>

    </body>

</html>

<?php
sqlsrv_close($conn);
?>