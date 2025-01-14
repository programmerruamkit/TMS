<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$condition2 = "";
$condition3 = "";
if ($_POST['type'] == 'infoamata') {
    if ($_POST['search'] != "") {
        $condition31 = " AND a.VEHICLETYPECODE = '" . $_POST['srtype'] . "' AND a.THAINAME NOT LIKE '%" . $_POST['search'] . "%' OR a.VEHICLEREGISNUMBER NOT LIKE '%" . $_POST['search'] . "%'";
        $condition32 = " AND (a.THAINAME  NOT LIKE '%R-%' OR a.THAINAME  NOT LIKE '%RA-%' OR a.THAINAME  NOT LIKE '%RP-%' OR a.THAINAME  NOT LIKE '%ดินแดง%'  ";
        $condition33 = " OR a.THAINAME  NOT LIKE '%อุทัยธานี%'  OR a.THAINAME  NOT LIKE '%คลองเขื่อน%' OR a.THAINAME  NOT LIKE '%ด่านช้าง%' OR a.THAINAME  NOT LIKE '%สวนผึ้ง%' ";
        $condition34 = " OR a.ENGNAME NOT LIKE '%Kerry%' OR a.THAINAME NOT NOT LIKE '%เขาชะเมา%' OR a.THAINAME NOT LIKE '%เฉลิมพระเกียรติ%' OR a.THAINAME NOT LIKE '%P35%')";
    } else {
        $condition31 = " AND a.VEHICLETYPECODE = '" . $_POST['srtype'] . "'";
        $condition32 = " AND (a.THAINAME  NOT LIKE '%R-%' OR a.THAINAME  NOT LIKE '%RA-%' OR a.THAINAME  NOT LIKE '%RP-%' OR a.THAINAME  NOT LIKE '%ดินแดง%'  ";
        $condition33 = " OR a.THAINAME  NOT LIKE '%อุทัยธานี%'  OR a.THAINAME  NOT LIKE '%คลองเขื่อน%' OR a.THAINAME  NOT LIKE '%ด่านช้าง%' OR a.THAINAME  NOT LIKE '%สวนผึ้ง%' ";
        $condition34 = " OR a.ENGNAME NOT LIKE '%Kerry%' OR a.THAINAME NOT LIKE '%เขาชะเมา%' OR a.THAINAME NOT LIKE '%เฉลิมพระเกียรติ%' OR a.THAINAME NOT LIKE '%P35%')";
    }
}
if ($_POST['type'] == 'infogetway') {
    if ($_POST['search'] != "") {
        $condition31 = " AND a.VEHICLETYPECODE = '" . $_POST['srtype'] . "' AND a.THAINAME LIKE '%" . $_POST['search'] . "%' OR a.VEHICLEREGISNUMBER LIKE '%" . $_POST['search'] . "%'";
        $condition32 = " AND (a.THAINAME  LIKE '%R-%' OR a.THAINAME  LIKE '%RA-%' OR a.THAINAME  LIKE '%RP-%' OR a.THAINAME  LIKE '%ดินแดง%'  ";
        $condition33 = " OR a.THAINAME  LIKE '%อุทัยธานี%'  OR a.THAINAME  LIKE '%คลองเขื่อน%' OR a.THAINAME  LIKE '%ด่านช้าง%' OR a.THAINAME  LIKE '%สวนผึ้ง%' ";
        $condition34 = " OR a.ENGNAME LIKE '%Kerry%' OR a.THAINAME LIKE '%เขาชะเมา%' OR a.THAINAME LIKE '%เฉลิมพระเกียรติ%' OR a.THAINAME LIKE '%P35%')";
    } else {
        $condition31 = " AND a.VEHICLETYPECODE = '" . $_POST['srtype'] . "'";
        $condition32 = " AND (a.THAINAME  LIKE '%R-%' OR a.THAINAME  LIKE '%RA-%' OR a.THAINAME  LIKE '%RP-%' OR a.THAINAME  LIKE '%ดินแดง%'  ";
        $condition33 = " OR a.THAINAME  LIKE '%อุทัยธานี%'  OR a.THAINAME  LIKE '%คลองเขื่อน%' OR a.THAINAME  LIKE '%ด่านช้าง%' OR a.THAINAME  LIKE '%สวนผึ้ง%' ";
        $condition34 = " OR a.ENGNAME LIKE '%Kerry%' OR a.THAINAME LIKE '%เขาชะเมา%' OR a.THAINAME LIKE '%เฉลิมพระเกียรติ%' OR a.THAINAME LIKE '%P35%')";
    }
}


$sql_srCar = "{call megVehicleinfo_v2(?,?,?,?,?)}";
$params_srCar = array(
    array('selectcond_vehicleinfo', SQLSRV_PARAM_IN),
    array($condition31, SQLSRV_PARAM_IN),
    array($condition32, SQLSRV_PARAM_IN),
    array($condition33, SQLSRV_PARAM_IN),
    array($condition34, SQLSRV_PARAM_IN)
);

$query_srCar = sqlsrv_query($conn, $sql_srCar, $params_srCar);
while ($result_srCar = sqlsrv_fetch_array($query_srCar, SQLSRV_FETCH_ASSOC)) {
    ?>
    <div class="col-lg-3 col-md-3">
        <div class="panel" style="background-color: #FFF;color: #000;border-color:#ccc ">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-12" style="text-align: center">
                        <?php
                        switch ($_POST['srtype']) {
                            case 'VT-1403-0417': {
                                    ?>
                                    <img src="../images/cartype/10 ล้อ (เปิด).png" style="width: 200px;height: 200px;">
                                    <?php
                                }
                                break;
                            case 'VT-1403-0596': {
                                    ?>
                                    <img src="../images/cartype/กึ่งพ่วงพื้นเรียบ 7 ม..png" style="width: 200px;height: 200px;">
                                    <?php
                                }
                                break;
                            case 'VT-1403-0691': {
                                    ?>
                                    <img src="../images/cartype/กึ่งพ่วงพื้นเรียบ 9 ม..png" style="width: 200px;height: 200px;">
                                    <?php
                                }
                                break;
                            case 'VT-1403-0761': {
                                    ?>
                                    <img src="../images/cartype/กึ่งพ่วงพื้นเรียบ 12 ม..png" style="width: 200px;height: 200px;">
                                    <?php
                                }
                                break;
                            case 'VT-1403-0853': {
                                    ?>
                                    <img src="../images/cartype/กึ่งพ่วงเฉพาะกิจ Flat Bed.png" style="width: 200px;height: 200px;">
                                    <?php
                                }
                                break;



                            case 'VT-1403-0878': {
                                    ?>
                                    <img src="../images/cartype/กึ่งพ่วงเฉพาะกิจ 2 ชั้น.png" style="width: 200px;height: 200px;">
                                    <?php
                                }
                                break;
                            case 'VT-1403-0974': {
                                    ?>
                                    <img src="../images/cartype/กระบะ 4 ล้อ (ตู้).png" style="width: 200px;height: 200px;">
                                    <?php
                                }
                                break;
                            case 'VT-1403-0985': {
                                    ?>
                                    <img src="../images/cartype/6 ล้อ (ตู้10ประตู).png" style="width: 200px;height: 200px;">
                                    <?php
                                }
                                break;
                            case 'VT-1404-0063': {
                                    ?>
                                    <img src="../images/cartype/6 ล้อ (ตู้กันวิงเหล็ก).png" style="width: 200px;height: 200px;">
                                    <?php
                                }
                                break;
                            case 'VT-1404-0283': {
                                    ?>
                                    <img src="../images/cartype/10 ล้อ (ตู้กันวิงผ้าใบ).png" style="width: 200px;height: 200px;">
                                    <?php
                                }
                                break;





                            case 'VT-1404-0992': {
                                    ?>
                                    <img src="../images/cartype/10 ล้อ (ตู้กันวิงเหล็ก).png" style="width: 200px;height: 200px;">
                                    <?php
                                }
                                break;
                            case 'VT-1405-0293': {
                                    ?>
                                    <img src="../images/cartype/พ่วง.png" style="width: 200px;height: 200px;">
                                    <?php
                                }
                                break;
                            case 'VT-1411-0194': {
                                    ?>
                                    <img src="../images/cartype/กระบะบรรทุก 4 ประตู.png" style="width: 200px;height: 200px;">
                                    <?php
                                }
                                break;
                            case 'VT-1411-0253': {
                                    ?>
                                    <img src="../images/cartype/กระบะบรรทุก 2 ประตู.png" style="width: 200px;height: 200px;">
                                    <?php
                                }
                                break;
                            case 'VT-1411-0384': {
                                    ?>
                                    <img src="../images/cartype/เก๋งสองตอน.png" style="width: 200px;height: 200px;">
                                    <?php
                                }
                                break;





                            case 'VT-1411-0830': {
                                    ?>
                                    <img src="../images/cartype/Full Trailer.png" style="width: 200px;height: 200px;">
                                    <?php
                                }
                                break;
                            case 'VT-1412-0472': {
                                    ?>
                                    <img src="../images/cartype/Semitrailer open truck.png" style="width: 200px;height: 200px;">
                                    <?php
                                }
                                break;
                            case 'VT-1412-0710': {
                                    ?>
                                    <img src="../images/cartype/นั่งสามตอน.png" style="width: 200px;height: 200px;">
                                    <?php
                                }
                                break;










                            case '4L': {
                                    ?>
                                    <img src="../images/cartype/4L.png" style="width: 200px;height: 200px;">
                                    <?php
                                }
                                break;
                            case '8L': {
                                    ?>
                                    <img src="../images/cartype/8L.png" style="width: 200px;height: 200px;">
                                    <?php
                                }
                                break;
                            case '10W': {
                                    ?>
                                    <img src="../images/cartype/10W.png" style="width: 200px;height: 200px;">
                                    <?php
                                }
                                break;
                            case '22W': {
                                    ?>
                                    <img src="../images/cartype/22W.png" style="width: 200px;height: 200px;">
                                    <?php
                                }
                                break;
                            case '10W(GMT)': {
                                    ?>
                                    <img src="../images/cartype/10W (GMT).png" style="width: 200px;height: 200px;">
                                    <?php
                                }
                                break;






                            case 'Semi trailer': {
                                    ?>
                                    <img src="../images/cartype/Semi Trailer.png" style="width: 200px;height: 200px;">
                                    <?php
                                }
                                break;
                            case '10W(TTAST)': {
                                    ?>
                                    <img src="../images/cartype/10W (TTAST).png" style="width: 200px;height: 200px;">
                                    <?php
                                }
                                break;
                        }
                        ?>

                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <font style="font-size: 16px;color:#000 ">ทะเบียน : <?= $result_srCar['VEHICLEREGISNUMBER'] ?></font>

                <span class="pull-right"> 
                    <?php
                    $type = ($_POST['type'] == 'infoamata') ? 'ข้อมูลรถ (อมตะ)' : 'ข้อมูลรถ (เกตุเวย์)';
                    $condition1 = " AND b.MENUID = 6 AND e.EMPLOYEEID =" . $_SESSION["EMPLOYEEID"] . " AND c.SUBMENUNAME = '" . $type . "'";
                    ;
                    $sql_seSubmenu = "{call megRolemenu_v2(?,?)}";
                    $params_seSubmenu = array(
                        array('show_submenu', SQLSRV_PARAM_IN),
                        array($condition1, SQLSRV_PARAM_IN)
                    );

                    $query_seSubmenu1 = sqlsrv_query($conn, $sql_seSubmenu, $params_seSubmenu);
                    $result_seSubmenu1 = sqlsrv_fetch_array($query_seSubmenu1, SQLSRV_FETCH_ASSOC);

                    if ($result_seSubmenu1['SUBMENUID'] != "") {
                        ?>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu slidedown">

                                <li>

                                    <?php
                                    $query_seSubmenu = sqlsrv_query($conn, $sql_seSubmenu, $params_seSubmenu);
                                    while ($result_seSubmenu = sqlsrv_fetch_array($query_seSubmenu, SQLSRV_FETCH_ASSOC)) {
                                        ?>
                                        <a href='<?= $result_seSubmenu['PATH'] ?>&vehicleinfoid=<?= $result_srCar['VEHICLEINFOID'] ?>&meg=edit'><?= $result_seSubmenu['SUBMENUNAME'] ?></a>
                                        <?php
                                    }
                                    ?>
                                </li>


                            </ul>
                        </div>


                        <?php
                    }
                    ?>

                </span>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <?php
}
sqlsrv_close($conn);
?>