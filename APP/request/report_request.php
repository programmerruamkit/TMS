<?php $title_page = "Report"; ?>

<?php
if (require_once '../master.php') {
    $oid = $_POST['order_id'];
    $n = 1;
    $table = "RKADB_TABLE_ORDER O, RKADB_TABLE_WORK W";
    $value = "*, O.CREATE_BY AS ORDER_BY";
    $condition = "WHERE W.[WORK_ORDER] = O.[ORDER_ID] AND O.[ORDER_ID] = '$oid'";
    $para = set_stored_para("SELECT", $table, $value, $condition);
    $qry = db_query_stored($oop->rkadb, $oop->sp1, $para);

    if ($bag = sqlsrv_fetch_object($qry)) {

        $com_id = select_once_data($oop->rkadb, $oop->sp1, $oop->tbperson, "COMPANY_ID", "WHERE ([PERSON_FIRST_NAME]+' '+[PERSON_LAST_NAME]) = '$bag->CREATE_BY'");
        $com_name = select_once_data($oop->rkadb, $oop->sp1, $oop->tbcompany, "C_NAME_T", "WHERE [C_ID] = '$com_id'");

        ob_start();
        ?>

        <div class="container" style="width: 100%; padding-left: 1%; padding-top: 1%;">
            <center>
                <table style="width: 100%; border: 5px">
                    <tr>
                        <td style="width: 10%;"></td> <td style="width: 30%;"></td> <td style="width: 50%;"></td> <td style="width: 10%;"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="2" style="text-align: center;">
                            <h3><b>ใบแจ้งคำร้องด้าน IT</b></h3> <br>
                            <h5><b>บริษัท <?= $com_name ?></b></h5> <br>
                            <h5><b>เลขที่ <?= $bag->ORDER_CODE ?></b></h5> <br>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="4"> <hr> </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><h6><b>ส่วนของผู้แจ้งคำร้อง</b></h6></td> <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>วันที่แจ้ง</td> <td><?= cover_date(format_datetime($bag->CREATE_DATE, 'date')) ?> | <?= format_datetime($bag->CREATE_DATE, 'time') ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>ผู้แจ้ง</td> <td><?= $bag->ORDER_BY ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>สถานที่</td> <td><?= $bag->LOCATION_NAME ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>แผนก</td> <td><?= $bag->DEPARTMENT_NAME ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>เรื่องที่แจ้ง</td> <td><?= $bag->ORDER_NAME ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>รายละเอียด</td> <td><?= $bag->ORDER_DETAIL ?></td>
                        <td></td>
                    </tr>
                    <?php if ($bag->ORDER_FILE != '') { ?>
                        <tr>
                            <td></td>
                            <td>รูปภาพแนบ</td> <td> <img src="<?= "$oop->file/requirement/" . $bag->ORDER_FILE ?>" style="width: 200px"> </td>
                            <td></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="4"> <hr> </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><h6><b>ส่วนของเจ้าหน้าที่</b></h6></td> <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>วันที่ดำเนินงาน</td> <td><?= cover_date(format_datetime($bag->WORK_START, 'date')) ?> | <?= format_datetime($bag->WORK_START, 'time') ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>วันที่แล้วเสร็จ</td> <td><?= cover_date(format_datetime($bag->WORK_END, 'date')) ?> | <?= format_datetime($bag->WORK_END, 'time') ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>ผู้ดำเนินงาน</td> <td><?= $bag->WORK_BY ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>การดำเนินงาน</td> <td><?= $bag->WORK_DETAIL ?></td>
                        <td></td>
                    </tr>
                    <?php if ($bag->WORK_FILE != '') { ?>
                        <tr>
                            <td></td>
                            <td>รูปภาพแนบ</td> <td> <img src="<?= "$oop->file/work/" . $bag->WORK_FILE ?>" style="width: 200px"> </td>
                            <td></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td></td>
                        <td>สถานะรับทราบ</td> <td>ผู้แจ้งได้ทำการยืนยันรับทราบการดำเนินงานแล้ว</td>
                        <td></td>
                    </tr>
                </table>
            </center>
        </div>

        <?php
        $html = ob_get_contents();

        $mpdf = new mPDF('th', 'A4', '0', '');

        $mpdf->WriteHTML($html);

        $mpdf->Output("../file/report/$bag->ORDER_CODE.pdf");
    }
    ?>

    <br>
    <br>

    <div class="container" style="width: 48%;">
        <a class="btn btn-dark" href="<?= $oop->file . "/report/" . $bag->ORDER_CODE . ".pdf" ?>"><i class="fas fa-download fa-sm text-white-50"></i> Download</a>
    </div>

<?php } ?>