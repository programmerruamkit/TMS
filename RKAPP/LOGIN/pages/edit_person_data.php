<?php
$page_title = "REGISTER";
if (require_once '../../application.php') {
    if ($_SESSION['PERSON_ID'] != '') {
        $pid = $_SESSION['PERSON_ID'];
        $lid = $_SESSION['LOGIN_ID'];
        $condition = "WHERE [P_ID] = $pid";
        $para = set_stored_para('select', $rki->tbperson, "[P_PHONE],[P_EMAIL]", $condition);
        $qry = db_query_stored($rki->conn, $rki->stmanagement, $para);
        $item = sqlsrv_fetch_object($qry);
        ?>
        <form id="" name="" action="" method="" onsubmit="">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="input-group w3-margin-bottom"><span class="input-group-addon">E-Mail</span>
                            <input class='form-control' type="email" id='person_email' name='person_email' value="<?= $item->P_EMAIL ?>" maxlength="100">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="input-group w3-margin-bottom"><span class="input-group-addon">Phone</span>
                            <input class='form-control' type="tel" id='person_phone' name='person_phone' value="<?= $item->P_PHONE ?>" maxlength="11" onkeypress="auto_format(data, 'tel')">
                        </div>
                    </div>
                </div>>
            </div>
        </form>
        <?php
    }
}
?>

