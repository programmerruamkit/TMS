<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $strExcelFileName = "รายงานการแจ้งหยุดรถทั้งหมด.xls";
} else {
    $strExcelFileName = "รายงานการแจ้งหยุดรถทั้งหมดตั้งแต่วันที่" . $_GET['datestart'] . ' ถึง ' . $_GET['dateend'] . ".xls";
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
            <tr >
                <td colspan="4"  >&nbsp;</td>
                <td colspan="48"  >Monday</td>
                <td colspan="48"  >Tuesday</td>
                <td colspan="48"  >Wednesday</td>
                <td colspan="48"  >thursday</td>
                <td colspan="48"  >Friday</td>
                <td colspan="48"  >Saturday</td>
                <td colspan="48"  >Sunday</td>

            </tr>
            <tr style="border:1px solid #000;padding:4px;">
                <td  >&nbsp;</td>
                <td  >Triler</td>
                <td  >Route</td>
                <td  >Driver</td>

                <td colspan="2"  >05:00</td>
                <td colspan="2"  >06:00</td>
                <td colspan="2"  >07:00</td>
                <td colspan="2"  >08:00</td>
                <td colspan="2"  >09:00</td>
                <td colspan="2"  >10:00</td>
                <td colspan="2"  >11:00</td>
                <td colspan="2"  >12:00</td>
                <td colspan="2"  >13:00</td>
                <td colspan="2"  >14:00</td>
                <td colspan="2"  >15:00</td>
                <td colspan="2"  >16:00</td>
                <td colspan="2"  >17:00</td>
                <td colspan="2"  >18:00</td>
                <td colspan="2"  >19:00</td>
                <td colspan="2"  >20:00</td>
                <td colspan="2"  >21:00</td>
                <td colspan="2"  >22:00</td>
                <td colspan="2"  >23:00</td>
                <td colspan="2"  >00:00</td>
                <td colspan="2"  >01:00</td>
                <td colspan="2"  >02:00</td>
                <td colspan="2"  >03:00</td>
                <td colspan="2"  >04:00</td>

                <td colspan="2"  >05:00</td>
                <td colspan="2"  >06:00</td>
                <td colspan="2"  >07:00</td>
                <td colspan="2"  >08:00</td>
                <td colspan="2"  >09:00</td>
                <td colspan="2"  >10:00</td>
                <td colspan="2"  >11:00</td>
                <td colspan="2"  >12:00</td>
                <td colspan="2"  >13:00</td>
                <td colspan="2"  >14:00</td>
                <td colspan="2"  >15:00</td>
                <td colspan="2"  >16:00</td>
                <td colspan="2"  >17:00</td>
                <td colspan="2"  >18:00</td>
                <td colspan="2"  >19:00</td>
                <td colspan="2"  >20:00</td>
                <td colspan="2"  >21:00</td>
                <td colspan="2"  >22:00</td>
                <td colspan="2"  >23:00</td>
                <td colspan="2"  >00:00</td>
                <td colspan="2"  >01:00</td>
                <td colspan="2"  >02:00</td>
                <td colspan="2"  >03:00</td>
                <td colspan="2"  >04:00</td>

                <td colspan="2"  >05:00</td>
                <td colspan="2"  >06:00</td>
                <td colspan="2"  >07:00</td>
                <td colspan="2"  >08:00</td>
                <td colspan="2"  >09:00</td>
                <td colspan="2"  >10:00</td>
                <td colspan="2"  >11:00</td>
                <td colspan="2"  >12:00</td>
                <td colspan="2"  >13:00</td>
                <td colspan="2"  >14:00</td>
                <td colspan="2"  >15:00</td>
                <td colspan="2"  >16:00</td>
                <td colspan="2"  >17:00</td>
                <td colspan="2"  >18:00</td>
                <td colspan="2"  >19:00</td>
                <td colspan="2"  >20:00</td>
                <td colspan="2"  >21:00</td>
                <td colspan="2"  >22:00</td>
                <td colspan="2"  >23:00</td>
                <td colspan="2"  >00:00</td>
                <td colspan="2"  >01:00</td>
                <td colspan="2"  >02:00</td>
                <td colspan="2"  >03:00</td>
                <td colspan="2"  >04:00</td>

                <td colspan="2"  >05:00</td>
                <td colspan="2"  >06:00</td>
                <td colspan="2"  >07:00</td>
                <td colspan="2"  >08:00</td>
                <td colspan="2"  >09:00</td>
                <td colspan="2"  >10:00</td>
                <td colspan="2"  >11:00</td>
                <td colspan="2"  >12:00</td>
                <td colspan="2"  >13:00</td>
                <td colspan="2"  >14:00</td>
                <td colspan="2"  >15:00</td>
                <td colspan="2"  >16:00</td>
                <td colspan="2"  >17:00</td>
                <td colspan="2"  >18:00</td>
                <td colspan="2"  >19:00</td>
                <td colspan="2"  >20:00</td>
                <td colspan="2"  >21:00</td>
                <td colspan="2"  >22:00</td>
                <td colspan="2"  >23:00</td>
                <td colspan="2"  >00:00</td>
                <td colspan="2"  >01:00</td>
                <td colspan="2"  >02:00</td>
                <td colspan="2"  >03:00</td>
                <td colspan="2"  >04:00</td>

                <td colspan="2"  >05:00</td>
                <td colspan="2"  >06:00</td>
                <td colspan="2"  >07:00</td>
                <td colspan="2"  >08:00</td>
                <td colspan="2"  >09:00</td>
                <td colspan="2"  >10:00</td>
                <td colspan="2"  >11:00</td>
                <td colspan="2"  >12:00</td>
                <td colspan="2"  >13:00</td>
                <td colspan="2"  >14:00</td>
                <td colspan="2"  >15:00</td>
                <td colspan="2"  >16:00</td>
                <td colspan="2"  >17:00</td>
                <td colspan="2"  >18:00</td>
                <td colspan="2"  >19:00</td>
                <td colspan="2"  >20:00</td>
                <td colspan="2"  >21:00</td>
                <td colspan="2"  >22:00</td>
                <td colspan="2"  >23:00</td>
                <td colspan="2"  >00:00</td>
                <td colspan="2"  >01:00</td>
                <td colspan="2"  >02:00</td>
                <td colspan="2"  >03:00</td>
                <td colspan="2"  >04:00</td>

                <td colspan="2"  >05:00</td>
                <td colspan="2"  >06:00</td>
                <td colspan="2"  >07:00</td>
                <td colspan="2"  >08:00</td>
                <td colspan="2"  >09:00</td>
                <td colspan="2"  >10:00</td>
                <td colspan="2"  >11:00</td>
                <td colspan="2"  >12:00</td>
                <td colspan="2"  >13:00</td>
                <td colspan="2"  >14:00</td>
                <td colspan="2"  >15:00</td>
                <td colspan="2"  >16:00</td>
                <td colspan="2"  >17:00</td>
                <td colspan="2"  >18:00</td>
                <td colspan="2"  >19:00</td>
                <td colspan="2"  >20:00</td>
                <td colspan="2"  >21:00</td>
                <td colspan="2"  >22:00</td>
                <td colspan="2"  >23:00</td>
                <td colspan="2"  >00:00</td>
                <td colspan="2"  >01:00</td>
                <td colspan="2"  >02:00</td>
                <td colspan="2"  >03:00</td>
                <td colspan="2"  >04:00</td>

                <td colspan="2"  >05:00</td>
                <td colspan="2"  >06:00</td>
                <td colspan="2"  >07:00</td>
                <td colspan="2"  >08:00</td>
                <td colspan="2"  >09:00</td>
                <td colspan="2"  >10:00</td>
                <td colspan="2"  >11:00</td>
                <td colspan="2"  >12:00</td>
                <td colspan="2"  >13:00</td>
                <td colspan="2"  >14:00</td>
                <td colspan="2"  >15:00</td>
                <td colspan="2"  >16:00</td>
                <td colspan="2"  >17:00</td>
                <td colspan="2"  >18:00</td>
                <td colspan="2"  >19:00</td>
                <td colspan="2"  >20:00</td>
                <td colspan="2"  >21:00</td>
                <td colspan="2"  >22:00</td>
                <td colspan="2"  >23:00</td>
                <td colspan="2"  >00:00</td>
                <td colspan="2"  >01:00</td>
                <td colspan="2"  >02:00</td>
                <td colspan="2"  >03:00</td>
                <td colspan="2"  >04:00</td>
            </tr>

            <tr >
                <td  >1</td>
                <td  >&nbsp;</td>
                <td  >&nbsp;</td>
                <td  >&nbsp;</td>

                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>

                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>

                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>

                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>

                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>

                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>

                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
                <td  ></td>
            </tr>
        </table>
    </body>
</html>