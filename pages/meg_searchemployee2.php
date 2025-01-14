<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$condition2 = "";
$condition3 = "";

if ($_POST['search'] != "") {
    $condition3 = " AND d.Company_Code = '" . $_POST['srtype'] . "' AND (a.FnameT LIKE '%" . $_POST['search'] . "%' OR a.LnameT LIKE '%" . $_POST['search'] . "%' OR a.PersonCode LIKE '%" . $_POST['search'] . "%')";
} else {
    if ($_POST['srtype'] != "") {
        $condition2 = " AND d.Company_Code = '" . $_POST['srtype'] . "'";
    }
}
$condition1 = $condition2 . $condition3;
$sql_srEmp = "{call megEmployeeEHR_v2(?,?)}";
$params_srEmp = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);

$query_srEmp = sqlsrv_query($conn, $sql_srEmp, $params_srEmp);
while ($result_srEmp = sqlsrv_fetch_array($query_srEmp, SQLSRV_FETCH_ASSOC)) {
    ?>
    <div class="col-lg-3 col-md-3">
        <div class="panel" style="background-color: #FFF;color: #337ab7;border-color: #31708f">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-2" style="padding-right: 0px;padding-left: 5px">
                        <!--<img src="../tmlspictures/employees/<?//= $result_srEmp['PersonCode'] ?>.jpg" style="width: 60px;height: 60px;"><font style="font-size: 10px"><?//= $result_srEmp['PersonCode'] ?>-->
                        <img src="../images/noimage.jpg" style="width: 60px;height: 60px;">
                    
                    </div>
                    <div class="col-xs-10 text-right" style="padding-right: 5px;padding-left: 0px">
                        <div class="huge"></font> <font style="font-size: 12px"><?= $result_srEmp['nameT'] ?></font></div>

                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <span class="pull-left">เมนูย่อย</span>

                <span class="pull-right"> 
                                                       <?php
                                                        $condition1 = " AND b.MENUID = 9 AND e.EMPLOYEEID =" . $_SESSION["EMPLOYEEID"];
                                                        $sql_seSubmenu = "{call megRolemenu_v2(?,?)}";
                                                        $params_seSubmenu = array(
                                                            array('show_submenu', SQLSRV_PARAM_IN),
                                                            array($condition1, SQLSRV_PARAM_IN)
                                                        );

                                                        $query_seSubmenu1 = sqlsrv_query($conn, $sql_seSubmenu, $params_seSubmenu);
                                                        $result_seSubmenu1 = sqlsrv_fetch_array($query_seSubmenu1, SQLSRV_FETCH_ASSOC);
                                                        
                                                        if ($result_seSubmenu1['SUBMENUID'] != "") {
                                                            ?>
                                                            <a href="#" role="button" class="btn btn-default btn-circle" data-toggle="popover" title="" data-content="
                                                            <?php
                                                            $query_seSubmenu = sqlsrv_query($conn, $sql_seSubmenu, $params_seSubmenu);
                                                            while ($result_seSubmenu = sqlsrv_fetch_array($query_seSubmenu, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                   <a href='<?= $result_seSubmenu['PATH'] ?>&employeeid=<?= $result_srEmp['PersonCode'] ?>&meg=edit' class='list-group-item'><?=$result_seSubmenu['SUBMENUNAME'] ?></a><br>
                                                                <?php
                                                            }
                                                            ?>
                                                               "><i class="fa fa-list"></i></a>
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
?>