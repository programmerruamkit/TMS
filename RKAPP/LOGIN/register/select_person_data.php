<?php
$page_title = "REGISTER";
if (require_once '../../application.php') {
    if ($_SESSION['LEVEL'] == 9) {
        if ($_GET['type'] == 'search' && $_GET['data'] != '') {
            $search = cover_string($_GET['data']);
            $condition = "WHERE [PersonCode] LIKE '%$search%' OR [PersonCardID] LIKE '%$search%' OR [FnameT] LIKE '%$search'";
            $para = set_stored_para('SELECT_EHR', "", "", $condition);
            $qry = db_query_stored($rki->conn, $rki->stmanagement, $para);
            $i = 1;
            ?>
            <table class="table table-hover">
                <tr>
                    <td></td> <td>P_FNAME</td> <td>P_LNAME</td> <td></td>
                </tr>
                <?php
                while ($item = sqlsrv_fetch_object($qry)) {
                    echo "<tr>";
                    echo "<td>$i</td>";
                    echo "<td>$item->FnameT</td>";
                    echo "<td>$item->LnameT</td>";
                    ?> <td><button class="btn btn-info" type="button" data-toggle='modal' data-target='#popup_modal' onclick="display_change('modal_display', 'select', <?= $item->PersonID ?>, '/RKAPP/LOGIN/register/select_person_data.php')">SELECT</button></td> <?php
                    echo "</tr>";
                    $i++;
                }
                ?> </table> <?php
        } else if ($_GET['type'] == 'select') {
            $p_id = cover_string($_GET['data']);
            $condition = "WHERE [PersonID] = '$p_id' ";
            $para = set_stored_para('SELECT_EHR', "", "", $condition);
            $qry = db_query_stored($rki->conn, $rki->stmanagement, $para);
            if ($item = sqlsrv_fetch_object($qry)) {
                ?>
                <form id="add_person" name="add_person" method="post" action="/RKAPP/TOOL/sql/sql_person_data.php" onsubmit="return conf_send_data()">
                    <input type="hidden" id="selection" name="selection" value="insert">
                    <input type="hidden" id="person_id" name="person_id" value="<?= $p_id ?>">
                    <input type="hidden" id="company_id" name="company_id" value="<?= $item->CompanyID ?>">
                    <input type="hidden" id="position_id" name="position_id" value="<?= $item->PositionID ?>">
                    <input type="hidden" id='person_sex' name='person_sex' value="<?php if($item->SexID == 1){echo 'M';}else{echo 'F';} ?>">
                    <div class="modal-header">
                        <button type="button" class="close w3-red" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">เพิ่มข้อมูลผู้ใช้งาน</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="input-group w3-margin-bottom"><span class="input-group-addon">รหัสพนักงาน</span>
                                    <input class='form-control' type="text" id='person_card' name='person_card' value="<?= $item->PersonCardID ?>" readonly>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="input-group w3-margin-bottom"><span class="input-group-addon">ชื่อ</span>
                                    <input class='form-control' type="text" id='person_fname' name='person_fname' value="<?= $item->FnameT ?>" readonly>
                                </div> 
                            </div>
                            <div class="col-lg-6">
                                <div class="input-group w3-margin-bottom"><span class="input-group-addon">นามสกุล</span>
                                    <input class='form-control' type="text" id='person_lname' name='person_lname' value="<?= $item->LnameT ?>" readonly>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="input-group w3-margin-bottom"><span class="input-group-addon">Username</span>
                                    <input class='form-control' type="text" id="user_id" name="user_id" value="<?= $item->PersonCardID ?>" maxlength="20">
                                </div> 
                            </div>
                            <div class="col-lg-12">
                                <div class="input-group w3-margin-bottom"><span class="input-group-addon">Password</span>
                                    <input class='form-control' type="text" id="pass_id" name="pass_id" value="<?= $item->PersonCardID ?>" maxlength="20">
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="input-group w3-margin-bottom"><span class="input-group-addon">LEVEL</span>
                                    <input class='form-control' type="number" id="level" name="level" min="1" max="9">
                                </div> 
                            </div>
                            <div class="col-lg-12">
                                <div class="input-group w3-margin-bottom"><span class="input-group-addon">TYPE</span>
                                    <input class='form-control' type="text" id="position_type" name="position_type" maxlength="5">
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Save</button>
                    </div>
                </form>
                <?php
            }
        }
    } else {
        echo '<script type="text/javascript">window.alert("สิทธิ์ไม่ได้รับอนุญาตให้ใช้งาน!!!");</script>';
        header("refresh: 0; url=/RKAPP/");
        exit(0);
    }
} else {
    header("refresh: 0; url=/RKAPP/");
    exit(0);
}
?>

