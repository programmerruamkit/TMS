<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $strExcelFileName = "รายงานแผนการขนส่ง.xls";
} else {
    $strExcelFileName = "รายงานแผนการขนส่งตั้งแต่วันที่" . $_GET['datestart'] . ' ถึง ' . $_GET['dateend'] . ".xls";
}

$sql_seYY = "{call megGetdate_v2(?,?)}";
$params_seYY = array(
    array('select_getdate', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seYY = sqlsrv_query($conn, $sql_seYY, $params_seYY);
$result_seYY = sqlsrv_fetch_array($query_seYY, SQLSRV_FETCH_ASSOC);


        
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
                    <th colspan="36" style="text-align: left">Summary delivery result Aug'<?=$result_seYY['YY']?></th>
                    
                </tr>
                <tr style="background-color: #999">
                    <th rowspan="2">NO</th>
                    <th rowspan="2">Plant</th>
                    <th rowspan="2" colspan="2">Route</th>
                    <th colspan="32">Aug-<?=$result_seYY['YY']?></th>
                    
                </tr>
                <tr style="background-color: #999">
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>
                    <th>4</th>
                    <th>5</th>
                    <th>6</th>
                    <th>7</th>
                    <th>8</th>
                    <th>9</th>
                    <th>10</th>
                    <th>11</th>
                    <th>12</th>
                    <th>13</th>
                    <th>14</th>
                    <th>15</th>
                    <th>16</th>
                    <th>17</th>
                    <th>18</th>
                    <th>19</th>
                    <th>20</th>
                    <th>21</th>
                    <th>22</th>
                    <th>23</th>
                    <th>24</th>
                    <th>25</th>
                    <th>26</th>
                    <th>27</th>
                    <th>28</th>
                    <th>29</th>
                    <th>30</th>
                    <th>31</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
              

                    <tr>
                        <td rowspan="2">1</td>
                        <td rowspan="2">TG#2</td>
                        <td rowspan="2">BJKC+Energy</td>
                        <td>Plan</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Actual</td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','01','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','02','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','03','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','04','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','05','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','06','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','07','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','08','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','09','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','10','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','11','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','12','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','13','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','14','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','15','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','16','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','17','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','18','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','19','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','20','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','21','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','22','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','23','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','24','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','25','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','26','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','27','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','28','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','29','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','30','08','');?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','31','08','');?></td>
                        <td><?=(int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','01','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','02','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','03','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','04','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','05','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','06','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','07','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','08','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','09','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','10','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','11','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','12','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','13','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','14','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','15','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','16','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','17','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','18','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','19','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','20','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','21','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','22','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','23','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','24','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','25','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','26','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','27','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','28','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','29','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','30','08','')+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','BJKC + INGY','31','08','');?></td>
                    </tr>
                    <tr>
                        <td rowspan="2">2</td>
                        <td rowspan="2">TG#2</td>
                        <td rowspan="2">Domestic HP</td>
                        <td>Plan</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Actual</td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','01','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','02','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','03','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','04','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','05','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','06','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','07','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','08','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','09','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','10','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','11','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','12','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','13','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','14','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','15','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','16','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','17','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','18','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','19','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','20','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','21','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','22','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','23','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','24','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','25','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','26','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','27','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','28','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','29','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','30','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','31','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=(int)show_cnttgt('TGT2 (Amatanakorn IE.)','','01','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','02','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','03','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','04','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','05','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','06','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','07','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','08','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','09','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','10','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','11','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','12','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','13','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','14','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','15','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','16','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','17','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','18','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','19','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','20','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','21','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','22','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','23','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','24','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','25','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','26','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','27','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','28','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','29','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','30','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','31','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                    </tr>
                    <tr>
                        <td rowspan="2">3</td>
                        <td rowspan="2">TG#2</td>
                        <td rowspan="2">Export HP</td>
                        <td>Plan</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Actual</td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','01','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','02','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','03','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','04','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','05','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','06','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','07','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','08','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','09','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','10','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','11','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','12','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','13','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','14','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','15','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','16','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','17','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','18','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','19','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','20','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','21','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','22','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','23','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','24','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','25','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','26','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','27','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','28','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','29','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','30','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','31','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=(int)show_cnttgt('TGT2 (Amatanakorn IE.)','','01','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','02','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','03','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','04','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','05','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','06','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','07','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','08','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','09','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','10','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','11','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','12','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','13','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','14','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','15','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','16','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','17','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','18','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','19','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','20','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','21','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','22','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','23','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','24','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','25','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','26','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','27','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','28','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','29','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','30','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','31','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                    </tr>
                    <tr>
                        <td rowspan="3">4</td>
                        <td rowspan="3">Total</td>
                        <td rowspan="3">Dometic&Export HP</td>
                        <td>Plan</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                  
                    <tr>
                        <td>Actual</td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','01','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','01','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','02','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','02','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','03','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','03','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','04','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','04','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','05','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','05','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','06','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','06','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','07','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','07','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','08','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','08','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','09','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','09','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','10','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','10','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','11','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','11','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','12','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','12','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','13','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','13','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','14','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','14','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','15','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','15','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','16','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','16','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','17','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','17','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','18','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','18','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','19','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','19','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','20','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','20','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','21','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','21','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','22','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','22','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','23','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','23','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','24','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','24','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','25','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','25','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','26','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','26','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','27','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','27','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','28','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','28','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','29','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','29','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','30','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','30','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','31','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','31','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=((int)show_cnttgt('TGT2 (Amatanakorn IE.)','','01','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','02','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','03','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','04','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','05','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','06','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','07','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','08','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','09','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','10','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','11','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','12','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','13','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','14','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','15','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','16','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','17','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','18','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','19','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','20','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','21','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','22','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','23','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','24','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','25','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','26','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','27','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','28','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','29','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','30','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','31','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'"))+
                        ((int)show_cnttgt('TGT2 (Amatanakorn IE.)','','01','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','02','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','03','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','04','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','05','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','06','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','07','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','08','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','09','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','10','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','11','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','12','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','13','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','14','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','15','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','16','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','17','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','18','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','19','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','20','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','21','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','22','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','23','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','24','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','25','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','26','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','27','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','28','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','29','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','30','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','31','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')"));?></td>
                    </tr>
                    <tr>
                        <td>% ( Ac/Pl)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td rowspan="2">5</td>
                        <td rowspan="2">TG#3+1</td>
                        <td rowspan="2">Domestic HP</td>
                        <td>Plan</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Actual</td>
                         <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','01','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','02','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','03','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','04','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','05','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','06','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','07','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','08','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','09','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','10','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','11','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','12','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','13','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','14','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','15','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','16','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','17','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','18','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','19','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','20','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','21','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','22','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','23','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','24','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','25','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','26','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','27','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','28','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','29','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','30','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','31','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                        <td><?=(int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','01','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','02','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','03','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','04','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','05','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','06','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','07','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','08','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','09','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','10','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','11','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','12','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','13','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','14','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','15','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','16','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','17','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','18','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','19','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','20','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','21','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','22','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','23','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','24','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','25','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','26','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','27','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','28','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','29','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','30','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','31','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'");?></td>
                    </tr>
                    <tr>
                        <td rowspan="2">6</td>
                        <td rowspan="2">TG#3+1</td>
                        <td rowspan="2">Export HP</td>
                        <td>Plan</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Actual</td>
                         <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','01','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','02','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','03','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','04','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','05','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','06','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','07','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','08','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','09','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','10','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','11','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','12','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','13','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','14','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','15','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','16','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','17','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','18','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','19','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','20','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','21','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','22','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','23','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','24','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','25','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','26','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','27','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','28','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','29','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','30','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','31','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=(int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','01','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','02','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','03','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','04','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','05','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','06','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','07','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','08','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','09','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','10','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','11','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','12','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','13','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','14','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','15','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','16','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','17','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','18','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','19','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','20','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','21','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','22','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','23','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','24','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','25','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','26','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','27','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','28','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','29','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','30','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','31','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                    </tr>
                    <tr>
                        <td rowspan="3">7</td>
                        <td rowspan="3">Total</td>
                        <td rowspan="3">Dometic&Export HP</td>
                        <td>Plan</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                   <tr>
                        <td>Actual</td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','01','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','01','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','02','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','02','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','03','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','03','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','04','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','04','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','05','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','05','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','06','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','06','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','07','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','07','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','08','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','08','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','09','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','09','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','10','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','10','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','11','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','11','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','12','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','12','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','13','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','13','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','14','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','14','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','15','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','15','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','16','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','16','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','17','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','17','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','18','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','18','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','19','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','19','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','20','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','20','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','21','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','21','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','22','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','22','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','23','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','23','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','24','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','24','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','25','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','25','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','26','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','26','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','27','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','27','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','28','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','28','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','29','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','29','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','30','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','30','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','31','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','31','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=((int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','01','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','02','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','03','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','04','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','05','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','06','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','07','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','08','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','09','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','10','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','11','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','12','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','13','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','14','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','15','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','16','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','17','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','18','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','19','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','20','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','21','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','22','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','23','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','24','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','25','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','26','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','27','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','28','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','29','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','30','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','31','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'"))+
                        ((int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','01','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','02','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','03','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','04','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','05','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','06','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','07','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','08','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','09','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','10','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','11','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','12','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','13','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','14','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','15','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','16','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','17','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','18','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','19','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','20','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','21','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','22','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','23','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','24','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','25','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','26','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','27','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','28','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','29','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','30','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','31','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')"))?></td>
                    </tr>
                    <tr>
                        <td>% ( Ac/Pl)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td rowspan="4">8</td>
                        <td rowspan="4">G.Total</td>
                        <td rowspan="4">Domestic & Export</td>
                        <td>Plan</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Actual</td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','01','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','01','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','01','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','01','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','02','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','02','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','02','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','02','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','03','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','03','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','03','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','03','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','04','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','04','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','04','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','04','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','05','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','05','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','05','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','05','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','06','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','06','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','06','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','06','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','07','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','07','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','07','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','07','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','08','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','08','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','08','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','08','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','09','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','09','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','09','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','09','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','10','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','10','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','10','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','10','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','11','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','11','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','11','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','11','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','12','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','12','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','12','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','12','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','13','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','13','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','13','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','13','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','14','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','14','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','14','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','14','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','15','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','15','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','15','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','15','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','16','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','16','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','16','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','16','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','17','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','17','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','17','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','17','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','18','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','18','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','18','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','18','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','19','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','19','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','19','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','19','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','20','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','20','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','20','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','20','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','21','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','21','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','21','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','21','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','22','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','22','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','22','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','22','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','23','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','23','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','23','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','23','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','24','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','24','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','24','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','24','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','25','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','25','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','25','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','25','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','26','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','26','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','26','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','26','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','27','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','27','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','27','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','27','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','28','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','28','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','28','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','28','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','29','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','29','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','29','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','29','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','30','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','30','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','30','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','30','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=show_cnttgt('TGT2 (Amatanakorn IE.)','','31','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT2 (Amatanakorn IE.)','','31','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','31','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','31','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')");?></td>
                        <td><?=(((int)show_cnttgt('TGT2 (Amatanakorn IE.)','','01','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','02','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','03','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','04','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','05','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','06','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','07','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','08','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','09','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','10','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','11','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','12','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','13','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','14','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','15','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','16','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','17','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','18','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','19','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','20','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','21','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','22','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','23','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','24','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','25','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','26','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','27','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','28','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','29','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','30','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','31','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'"))+
                        ((int)show_cnttgt('TGT2 (Amatanakorn IE.)','','01','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','02','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','03','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','04','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','05','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','06','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','07','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','08','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','09','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','10','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','11','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','12','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','13','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','14','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','15','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','16','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','17','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','18','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','19','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','20','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','21','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','22','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','23','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','24','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','25','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','26','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','27','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','28','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','29','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','30','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT2 (Amatanakorn IE.)','','31','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")))+
                        (((int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','01','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','02','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','03','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','04','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','05','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','06','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','07','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','08','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','09','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','10','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','11','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','12','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','13','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','14','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','15','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','16','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','17','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','18','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','19','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','20','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','21','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','22','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','23','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','24','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','25','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','26','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','27','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','28','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','29','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','30','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','31','08'," AND JOBEND != 'BJKC + INGY' AND ROUNDAMOUNT NOT LIKE '%RD96%' AND ROUNDAMOUNT NOT LIKE '%AL03%' AND ROUNDAMOUNT NOT LIKE '%KD50%'"))+
                        ((int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','01','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','02','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','03','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','04','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','05','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','06','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','07','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','08','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','09','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','10','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','11','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','12','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','13','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','14','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','15','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','16','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','17','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','18','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','19','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','20','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','21','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','22','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','23','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','24','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','25','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','26','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','27','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','28','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','29','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','30','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")+
                        (int)show_cnttgt('TGT3+TGT1 (Amatanakorn IE.)','','31','08'," AND JOBEND != 'BJKC + INGY' AND (ROUNDAMOUNT LIKE '%RD96%' OR ROUNDAMOUNT LIKE '%AL03%' OR ROUNDAMOUNT LIKE '%KD50%')")))?></td>
                    </tr>
                     <tr>
                        <td>Diff.(Ac-Pl )</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                     <tr>
                        <td>% ( Ac/Pl)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
            </tbody>
        </table>
       
    </body>
</html>