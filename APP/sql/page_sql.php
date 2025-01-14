<?php
$title_page = "SQL";
if (require_once '../master.php') {

    if ($_POST['select_type'] == 'Login') {
        $id = $_POST['rk_user_id'];
        $pass = data_encrypt($_POST['rk_user_pass']);

        $condition = "WHERE ([PERSON_USERNAME] = '$id' AND [PERSON_PASSWORD] = '$pass') AND [ITEM_STATUS] = 1";
        $value = "[PERSON_ID],[PERSON_FIRST_NAME],[PERSON_LAST_NAME],[PERSON_EMAIL],[PERSON_LEVEL],[PERSON_TYPE],[PERSON_PICTURE],[COMPANY_ID]";

        $para = set_stored_para('select', $oop->tbperson, $value, $condition);
        $qry = db_query_stored($oop->rkadb, $oop->sp1, $para);
        if ($item = sqlsrv_fetch_object($qry)) {
            $para = set_stored_para('update', $oop->tbperson, '[PERSON_LASTTIME] = GETDATE()', "[PERSON_ID] = $uid");
            if (db_query_stored($oop->rkadb, $oop->sp1, $para)) {
                if ($item->PERSON_PICTURE != NULL) {
                    $pic = $item->PERSON_PICTURE;
                } else {
                    $pic = "no_pic_user.jpg";
                }

                $dir = "/";
                $name = $item->PERSON_FIRST_NAME . " " . $item->PERSON_LAST_NAME;

                setcookie('LOGON_STATUS', 'Y', time() + (3600 * 4), $dir);
                setcookie('RK_USER_ID', $item->PERSON_ID, time() + (3600 * 4), $dir);
                setcookie('RK_USER_FIRSTNAME', $item->PERSON_FIRST_NAME, time() + (3600 * 4), $dir);
                setcookie('RK_USER_LASTNAME', $item->PERSON_LAST_NAME, time() + (3600 * 4), $dir);
                setcookie('RK_USER_EMAIL', $item->PERSON_EMAIL, time() + (3600 * 4), $dir);
                setcookie('RK_USER_LEVEL', $item->PERSON_LEVEL, time() + (3600 * 4), $dir);
                setcookie('RK_USER_TYPE', $item->PERSON_TYPE, time() + (3600 * 4), $dir);
                setcookie('RK_USER_COM', $item->COMPANY_ID, time() + (3600 * 4), $dir);
                setcookie('RK_USER_NAME', $name, time() + (3600 * 8), $dir);
                setcookie('RK_USER_PIC', $oop->file . "/person/pic/$pic", time() + (3600 * 4), $dir);

                header("refresh: 0; url=$oop->apphome");
                echo '<script>window.alert("ยินดีต้อนรับคุณ : ' . $name . '");</script>';
                exit(0);
            }
        } else {
            header("refresh: 0; url=$oop->apphome/login.php");
            echo '<script>window.alert("Username หรือ Password ไม่ถูกต้อง!!!");</script>';
            exit(0);
        }
    } else if ($_POST['select_type'] == 'Logout') {
        $uid = $_COOKIE['RK_USER_ID'];
        $para = set_stored_para('UPDATE', $oop->tbperson, '[PERSON_LASTTIME] = GETDATE()', "[PERSON_ID] = $uid");
        if (db_query_stored($oop->rkadb, $oop->sp1, $para)) {

            $dir = '/';
            setcookie('LOGON_STATUS', 'N', time() + 3600, $dir);
            setcookie('RK_USER_ID', null, -1, $dir);
            setcookie('RK_USER_FIRSTNAME', null, -1, $dir);
            setcookie('RK_USER_LASTNAME', null, -1, $dir);
            setcookie('RK_USER_EMAIL', null, -1, $dir);
            setcookie('RK_USER_LEVEL', null, -1, $dir);
            setcookie('RK_USER_TYPE', null, -1, $dir);
            setcookie('RK_USER_COM', null, -1, $dir);
            setcookie('RK_USER_NAME', null, -1, $dir);
            setcookie('RK_USER_PIC', null, -1, $dir);

            header("refresh: 0; url=$oop->apphome/index.php");

            if (isset($_COOKIE['LOGON_STATUS'])) {
                echo '<script>window.alert("ออกจากระบบแล้ว!!");</script>';
            } else {
                echo '<script>window.alert("Not Set!!!");</script>';
            }

            exit(0);
        }
    } else if ($_POST['select_type'] == 'Request') {
        if ($_POST['sub_type'] == 'Add') {
            $order_type = $_POST['order_type'];
            $order_company = strtoupper($_POST['order_company']);
            $order_eq = strtoupper($_POST['order_eq']);
            $order_location = strtoupper($_POST['order_location']);
            $order_dept = strtoupper($_POST['order_dept']);
            $order_detail = $_POST['order_detail'];
            $name_add = $_COOKIE['RK_USER_NAME'];

            $dmy = set_format_date($oop->serverdate);
            $order_code = $order_type . "-" . $dmy . "-" . get_max_id($oop->rkadb, $oop->sp1, $oop->tborder, "[ORDER_CODE]", "[ORDER_CODE] LIKE '$order_type-$dmy%'");
            $order_name = select_once_data($oop->rkadb, $oop->sp1, $oop->tbtype, "TYPE_NAME", "WHERE [TYPE_CODE] = '$order_type'");

            if ($_FILES['order_file']["name"] != '') {
                $order_file = $order_code . "." . strtolower(pathinfo($_FILES["order_file"]["name"], PATHINFO_EXTENSION));
                $target_dir = "../file/requirement/";
                $target_file = $target_dir . $order_file;
                $file_part = "<a href='$oop->host/file/requirement/$order_file'>ไฟล์แนบ</a>";
            } else {
                $file_part = "NULL";
            }

            $condition = "[ORDER_EQ],[ORDER_CODE],[ORDER_NAME],[ORDER_TYPE],[ORDER_DETAIL],[ORDER_STATUS],[ORDER_FILE],[LOCATION_NAME],[DEPARTMENT_NAME],[COMPANY_ID],[CREATE_BY]";
            $value = "'$order_eq','$order_code','$order_name','$order_type','$order_detail','0','$order_file','$order_location','$order_dept','$order_company','$name_add'";

            $para = set_stored_para("INSERT", $oop->tborder, $value, $condition);
            if (db_query_stored($oop->rkadb, $oop->sp1, $para)) {

                if ($_FILES['order_file']["name"] != '') {
                    copy($_FILES["order_file"]["tmp_name"], $target_file);
                }

                $text = "<h1>แจ้งเตือน คำร้องในระบบ</h1> <br><hr>";
                $text .= "<table style='width: 50%; border: 0px'>";
                $text .= "<tr><td><b>เลขที่เอกสาร :</b></td> <td><a href='$oop->host/app/management/frm_add_order.php?order_item=$order_code'>$order_code</a></td></tr>";
                $text .= "<tr><td><b>เรื่อง :</b></td> <td>$order_name</td></tr>";
                $text .= "<tr><td><hr></td> <td><hr></td></tr>";
                $text .= "<tr><td><b>ผู้แจ้ง :</b></td> <td>$name_add</td></tr>";
                $text .= "<tr><td><b>เลขที่เครื่อง :</b></td> <td>$order_eq</td></tr>";
                $text .= "<tr><td><b>สถานที่ :</b></td> <td>$order_location</td></tr>";
                $text .= "<tr><td><b>แผนก :</b></td> <td>$order_dept</td></tr>";
                $text .= "<tr><td><b>รายละเอียด :</b></td> <td>$order_detail</td></tr>";
                $text .= "<tr><td><b>เอกสารแนบ :</b></td> <td>$file_part</td></tr>";
                $text .= "</table>";
                $text .= "<br><hr>";
                $text .= "ระบบแจ้งข้อความอัตโนมัน (Auto Mail)";

                mail_trigger($_COOKIE['RK_USER_EMAIL'], '', 'IT REQUEST', $text, $order_name);
                header("refresh: 0; url=$oop->apprequest/frm_add_request.php");
                echo '<script>window.alert("บันทึก!!");</script>';
                exit(0);
            } else {
                header("refresh: 0; url=$oop->apprequest/frm_add_request.php");
                echo '<script>window.alert("ผิดพลาด!!!");</script>';
                exit(0);
            }
        } else if ($_POST['sub_type'] == 'Edit') {
            $order_code = $_POST['order_code'];
            $order_eq = strtoupper($_POST['order_eq']);
            $order_location = strtoupper($_POST['order_location']);
            $order_dept = strtoupper($_POST['order_dept']);
            $order_detail = $_POST['order_detail'];

            $condition = "[ORDER_CODE] = '$order_code'";
            $value = "[ORDER_EQ] = '$order_eq', [LOCATION_NAME] = '$order_location', [DEPARTMENT_NAME] = '$order_dept', [ORDER_DETAIL] = '$order_detail'";

            $para = set_stored_para("UPDATE", $oop->tborder, $value, $condition);
            if (db_query_stored($oop->rkadb, $oop->sp1, $para)) {
                if ($_FILES['order_file']["name"] != '') {
                    $order_file = $order_code . "." . strtolower(pathinfo($_FILES["order_file"]["name"], PATHINFO_EXTENSION));
                    $target_dir = "../file/requirement/";
                    $target_file = $target_dir . $order_file;

                    $condition = "[ORDER_CODE] = '$order_code'";
                    $value = "[ORDER_FILE] = '$order_file'";
                    $para = set_stored_para("UPDATE", $oop->tborder, $value, $condition);
                    if (db_query_stored($oop->rkadb, $oop->sp1, $para)) {
                        copy($_FILES["order_file"]["tmp_name"], $target_file);
                        header("refresh: 0; url=$oop->apprequest/frm_edit_request.php");
                        echo '<script>window.alert("แก้ไขแล้ว!!");</script>';
                        exit(0);
                    }
                }
                header("refresh: 0; url=$oop->apprequest/frm_edit_request.php");
                echo '<script>window.alert("แก้ไขแล้ว!!");</script>';
                exit(0);
            }
        } else if ($_POST['sub_type'] == 'Del') {
            $order_id = $_POST['del_data_item'];
            if ($_COOKIE['RK_USER_TYPE'] == 'ADMIN') {
                $order_status = 6;
            } else {
                $order_status = 5;
            }
            $para = set_stored_para('UPDATE', $oop->tborder, "[ITEM_STATUS] = 0,[ORDER_STATUS] = $order_status", "[ORDER_ID] = '$order_id'");
            if (db_query_stored($oop->rkadb, $oop->sp1, $para)) {
                header("refresh: 0; url=$oop->apprequest/frm_edit_request.php");
                echo '<script>window.alert("ยกเลิกแล้ว!!");</script>';
                exit(0);
            }
        } else if ($_POST['sub_type'] == 'Check') {
            $order_id = $_POST['order_id'];
            $para = set_stored_para('UPDATE', $oop->tborder, "[ORDER_CHECK] = 1", "[ORDER_ID] = $order_id");
            if (db_query_stored($oop->rkadb, $oop->sp1, $para)) {
                header("refresh: 0; url=$oop->apprequest/frm_edit_request.php");
                echo '<script>window.alert("ยืนยันแล้ว!!");</script>';
                exit(0);
            }
        }
    } else if ($_POST['select_type'] == 'Management') {
        if ($_POST['sub_type'] == 'Add') {
            $order_id = $_POST['work_order'];
            $order_type = $_POST['work_type'];
            $order_eq = $_POST['work_eq'];
            $work_by = $_COOKIE['RK_USER_NAME'];

            $value_work = "'$work_by','$order_id','$order_eq','$order_type',GETDATE(),'$work_by'";
            $condition_work = "[WORK_BY],[WORK_ORDER],[WORK_EQ],[WORK_TYPE],[WORK_START],[CREATE_BY]";

            $para_work = set_stored_para('INSERT', $oop->tbwork, $value_work, $condition_work);

            if (db_query_stored($oop->rkadb, $oop->sp1, $para_work)) {
                $value_order = "[ORDER_STATUS] = 1";
                $condition_order = "[ORDER_ID] = $order_id";
                $para_order = set_stored_para('UPDATE', $oop->tborder, $value_order, $condition_order);
                if (db_query_stored($oop->rkadb, $oop->sp1, $para_order)) {
                    header("refresh: 0; url=$oop->appmanagement/frm_add_order.php");
                    echo '<script>window.alert("บันทึก!!");</script>';
                    exit(0);
                }
            }
        }if ($_POST['sub_type'] == 'Edit') {
            $work_id = $_POST['work_id'];
            $order_id = $_POST['order_id'];
            $work_status = $_POST['work_status'];
            $work_detail = $_POST['work_detail'];
            $work_by = $_COOKIE['RK_USER_NAME'];
            $work_name = work_status_name($work_status);

            $name_by = select_once_data($oop->rkadb, $oop->sp1, $oop->tborder, "CREATE_BY", "WHERE [ORDER_ID] = '$order_id'");
            $email = person_email_data($oop->rkadb, $oop->sp1, $name_by);

            $order_name = select_once_data($oop->rkadb, $oop->sp1, $oop->tborder, "ORDER_NAME", "WHERE [ORDER_ID] = '$order_id'");
            $order_code = select_once_data($oop->rkadb, $oop->sp1, $oop->tborder, "ORDER_CODE", "WHERE [ORDER_ID] = '$order_id'");

            if ($work_status == 1) {
                $item_status = 0;
                $order_status = 2;
            } else if ($work_status == 2) {
                $item_status = 0;
                $order_status = 3;
            } else {
                $item_status = 1;
                $order_status = 4;
            }

            if ($_FILES['work_file']["name"] != '') {
                $work_file = "WORK-FILE-" . $work_id . "." . strtolower(pathinfo($_FILES["work_file"]["name"], PATHINFO_EXTENSION));
                $target_dir = "../file/work/";
                $target_file = $target_dir . $work_file;
                $file_part = "<a href='$oop->host/file/work/$work_file'>ไฟล์แนบ</a>";
            } else {
                $file_part = null;
            }

            $text = "<h1>แจ้ง การดำเนินงาน</h1> <br><hr>";
            $text .= "<table style='width: 50%; border: 0px'>";
            $text .= "<tr><td><b>เลขที่เอกสาร :</b></td> <td><a href='$oop->host/app/management/frm_add_order.php?order_item=$order_code'>$order_code</a></td></tr>";
            $text .= "<tr><td><b>เรื่อง :</b></td> <td>$order_name</td></tr>";
            $text .= "<tr><td><hr></td> <td><hr></td></tr>";
            $text .= "<tr><td><b>ผู้ดำเนินงาน :</b></td> <td>$work_by</td></tr>";
            $text .= "<tr><td><b>สถานะ :</b></td> <td>$work_name</td></tr>";
            $text .= "<tr><td><b>รายละเอียด :</b></td> <td>$work_detail</td></tr>";
            $text .= "<tr><td><b>เอกสารแนบ :</b></td> <td>$file_part</td></tr>";
            $text .= "</table>";
            $text .= "<br><hr>";
            $text .= "ระบบแจ้งข้อความอัตโนมัน (Auto Mail)";

            $value = "[WORK_DETAIL] = '$work_detail', [WORK_END] = GETDATE(), [WORK_STATUS] = '$work_status', [WORK_FILE] = '$work_file', [ITEM_STATUS] = '$item_status'";
            $condition = "[WORK_ID] = $work_id";
            $para = set_stored_para('UPDATE', $oop->tbwork, $value, $condition);
            if (db_query_stored($oop->rkadb, $oop->sp1, $para)) {
                if ($_FILES['work_file']["name"] != '') {
                    copy($_FILES["work_file"]["tmp_name"], $target_file);
                }
                $value = "[ORDER_STATUS] = $order_status, [ITEM_STATUS] = '$item_status'";
                $condition = "[ORDER_ID] = '$order_id'";
                $para = set_stored_para('UPDATE', $oop->tborder, $value, $condition);
                if (db_query_stored($oop->rkadb, $oop->sp1, $para)) {
                    mail_trigger($_COOKIE['RK_USER_EMAIL'], $email, "USER REQUEST $name_by", $text, $order_name);

                    header("refresh: 0; url=$oop->appmanagement/frm_edit_work.php");
                    echo '<script>window.alert("บันทึก!!");</script>';
                    exit(0);
                }
            }
        }
    } else if ($_POST['select_type'] == 'Type') {
        $name_add = $_COOKIE['RK_USER_FIRSTNAME'];

        if ($_POST['sub_type'] == 'Add') {
            $type_code = strtoupper($_POST['type_code']);
            if (re_check_data($oop->rkadb, $oop->sp1, $oop->tbtype, "WHERE [TYPE_CODE] = '$type_code'") == false) {
                $type_name = $_POST['type_name'];
                $value = "'$type_code','$type_name','$name_add'";
                $condition = "[TYPE_CODE],[TYPE_NAME],[CREATE_BY]";
                $para = set_stored_para('INSERT', $oop->tbtype, $value, $condition);
                if (db_query_stored($oop->rkadb, $oop->sp1, $para)) {
                    header("refresh: 0; url=$oop->appadmin/frm_add_type.php");
                    echo '<script>window.alert("บันทึก!!");</script>';
                    exit(0);
                } else {
                    header("refresh: 0; url=$oop->appadmin/frm_add_type.php");
                    echo '<script>window.alert("ผิดพลาด!!!");</script>';
                    exit(0);
                }
            } else {
                header("refresh: 0; url=$oop->appadmin/frm_add_type.php");
                echo '<script>window.alert("ซ้ำ!!!");</script>';
                exit(0);
            }
        }
    } else if ($_POST['select_type'] == 'Regis') {
        $name_add = $_COOKIE['RK_USER_FIRSTNAME'];

        if ($_POST['sub_type'] == 'Add') {
            $person_code = $_POST['person_code'];
            $person_first_name = $_POST['person_firstname'];
            $person_last_name = $_POST['person_lastname'];
            $person_sex = $_POST['person_sex'];
            $person_phone = $_POST['person_phone'];
            $person_email = $_POST['person_email'];
            $person_level = $_POST['person_level'];
            $person_type = $_POST['person_type'];
            $person_user = $_POST['person_username'];
            $person_pass = data_encrypt($_POST['person_password']);
            $person_position = $_POST['position_id'];
            $person_dept = '';
            $person_com = $_POST['company_id'];
            $person_area = $_POST['area_id'];

            $condition = "[PERSON_CODE],[PERSON_FIRST_NAME],[PERSON_LAST_NAME],[PERSON_SEX],[PERSON_PHONE],[PERSON_EMAIL],[PERSON_PICTURE],[PERSON_LEVEL],[PERSON_TYPE],[PERSON_USERNAME],[PERSON_PASSWORD],[POSITION_ID],[DEPARTMENT_ID],[COMPANY_ID],[AREA_ID],[CREATE_BY]";

            if ($_FILES['person_pic']["name"] != '') {
                $person_pic = $person_code . "." . strtolower(pathinfo($_FILES["person_pic"]["name"], PATHINFO_EXTENSION));
                $target_dir = "../file/person/pic/";
                $target_file = $target_dir . $person_pic;
            }

            if (re_check_data($oop->rkadb, $oop->sp1, $oop->tbperson, "WHERE [PERSON_CODE] = '$person_code'") == false) {
                $value = "'$person_code','$person_first_name','$person_last_name','$person_sex','$person_phone','$person_email','$person_pic','$person_level','$person_type','$person_user','$person_pass','$person_position','$person_dept','$person_com','$person_area','$name_add'";
                $para = set_stored_para('INSERT', $oop->tbperson, $value, $condition);
                if (db_query_stored($oop->rkadb, $oop->sp1, $para)) {
                    if ($_FILES['person_pic']["name"] != '') {
                        copy($_FILES["person_pic"]["tmp_name"], $target_file);
                    }
                    header("refresh: 0; url=$oop->appadmin/frm_add_register.php");
                    echo '<script>window.alert("บันทึก!!");</script>';
                    exit(0);
                } else {
                    header("refresh: 0; url=$oop->appadmin/frm_add_register.php");
                    echo '<script>window.alert("ผิดพลาด!!!");</script>';
                    exit(0);
                }
            } else {
                header("refresh: 0; url=$oop->appadmin/frm_add_register.php");
                echo '<script>window.alert("ซ้ำ!!!");</script>';
                exit(0);
            }
        }
    } else if ($_POST['select_type'] == 'Equipment') {
        $name_add = $_COOKIE['RK_USER_FIRSTNAME'];
        $e_id = $_POST['e_id'];
        if ($_POST['sub_type'] == 'Add') {
            $e_type = $_POST['e_type'];
            $e_code = strtoupper($_POST['e_code']);
            $ac_code = strtoupper($_POST['ac_code']);
            $e_name = strtoupper($_POST['e_name']);
            $e_comein = $_POST['e_comein'];
            $e_detail = $_POST['e_detail'];
            $waranty = $_POST['waranty'];

            if ($_POST['e_price'] != '') {
                $e_price = $_POST['e_price'];
            } else {
                $e_price = 0.00;
            }

            $sum_time = $e_comein . "+" . $waranty . "Months";
            $str_time = strtotime($sum_time);
            $waranty_end = date("Y-m-d", $str_time);

            if ($_FILES['e_pic']["name"] != '') {
                $e_pic = $e_type . "-" . $e_code . "." . strtolower(pathinfo($_FILES["e_pic"]["name"], PATHINFO_EXTENSION));
                $target_dir = "../file/equipment/";
                $target_file = $target_dir . $e_pic;
            } else {
                $e_pic = NULL;
            }

            if (re_check_data($oop->rkadb, $oop->sp1, $oop->tbequipment, "WHERE [E_CODE] = '$e_code'") == false) {
                $value = "'$e_code','$ac_code','$e_name','$e_detail','$e_price','$e_type','$e_comein','$waranty','$waranty_end','$e_pic','0','$name_add','5','BTC','IT','Server Room'";
                $condition = "[E_CODE],[AC_CODE],[E_NAME],[E_DETAIL],[E_PRICE],[E_TYPE],[E_COMEIN],[WARANTY],[WARANTY_END],[E_PIC],[E_STATUS],[CREATE_BY],[COMPANY_ID],[LOCATION_NAME],[DEPARTMENT_NAME],[POINT_NAME]";
                $para = set_stored_para('INSERT', $oop->tbequipment, $value, $condition);
                if (db_query_stored($oop->rkadb, $oop->sp1, $para)) {
                    if ($_FILES['e_pic']["name"] != '') {
                        copy($_FILES['e_pic']["tmp_name"], $target_file);
                    }
                    header("refresh: 0; url=$oop->appequipment/frm_manage_equipment.php");
                    echo '<script>window.alert("บันทึก!!");</script>';
                    exit(0);
                } else {
                    header("refresh: 0; url=$oop->appequipment/frm_manage_equipment.php");
                    echo '<script>window.alert("ผิดพลาด!!!");</script>';
                    exit(0);
                }
            } else {
                header("refresh: 0; url=$oop->appequipment/frm_manage_equipment.php");
                echo '<script>window.alert("ซ้ำ!!!");</script>';
                exit(0);
            }
        } else if ($_POST['sub_type'] == 'Edit') {
            $e_type = $_POST['e_type'];
            $e_code = strtoupper($_POST['e_code']);
            $ac_code = strtoupper($_POST['ac_code']);
            $e_name = strtoupper($_POST['e_name']);
            $e_comein = $_POST['e_comein'];
            $e_detail = $_POST['e_detail'];
            $waranty = $_POST['waranty'];

            if ($_POST['e_price'] != '') {
                $e_price = $_POST['e_price'];
            } else {
                $e_price = 0.00;
            }

            $sum_time = $e_comein . "+" . $waranty . "Months";
            $str_time = strtotime($sum_time);
            $waranty_end = date("Y-m-d", $str_time);

            if ($_FILES['e_pic']["name"] != '') {
                $e_pic = $e_type . "-" . $e_code . "." . strtolower(pathinfo($_FILES["e_pic"]["name"], PATHINFO_EXTENSION));
                $target_dir = "../file/equipment/";
                $target_file = $target_dir . $e_pic;
            } else {
                $e_pic = $_POST['e_pic'];
            }

            $value = "[E_CODE] = '$e_code', [AC_CODE] = '$ac_code', [E_NAME] = '$e_name', [E_DETAIL] = '$e_detail', [E_PRICE] = '$e_price', [E_TYPE] = '$e_type', [E_COMEIN] = '$e_comein', [WARANTY] = '$waranty', [WARANTY_END] = '$waranty_end', [E_PIC] = '$e_pic'";
            $condition = "[E_ID] = '$e_id'";
            $para = set_stored_para("UPDATE", $oop->tbequipment, $value, $condition);

            if (db_query_stored($oop->rkadb, $oop->sp1, $para) != false) {
                if ($_FILES['e_pic']["name"] != '') {
                    copy($_FILES['e_pic']["tmp_name"], $target_file);
                }
                header("refresh: 0; url=$oop->appequipment/frm_manage_equipment.php");
                echo '<script>window.alert("แก้ไข!!");</script>';
                exit(0);
            } else {
                header("refresh: 0; url=$oop->appequipment/frm_manage_equipment.php");
                echo '<script>window.alert("ผิดพลาด!!!");</script>';
                exit(0);
            }
        } else if ($_POST['sub_type'] == 'Manage') {
            $company_id = $_POST['company_id'];
            $location = strtoupper($_POST['location']);
            $department = strtoupper($_POST['department']);
            $point = strtoupper($_POST['point']);
            $ip = $_POST['ip'];

            $value = "[COMPANY_ID] = '$company_id', [LOCATION_NAME] = '$location', [DEPARTMENT_NAME] = '$department', [POINT_NAME] = '$point', [IP_ADDRESS] = '$ip', [E_STATUS] = 1";
            $condition = "[E_ID] = '$e_id'";
            $para = set_stored_para("UPDATE", $oop->tbequipment, $value, $condition);

            if (db_query_stored($oop->rkadb, $oop->sp1, $para) != false) {
                header("refresh: 0; url=$oop->appequipment/frm_manage_equipment.php");
                echo '<script>window.alert("ดำเนินการแล้ว!!");</script>';
                exit(0);
            } else {
                header("refresh: 0; url=$oop->appequipment/frm_manage_equipment.php");
                echo '<script>window.alert("ผิดพลาด!!!");</script>';
                exit(0);
            }
        } else if ($_POST['sub_type'] == 'Del') {
            $e_status = $_POST['e_status'];
            $company_id = 5;
            $location = '';
            $department = '';
            $point = '';
            $ip = '';

            if ($e_status == 4) {
                $item_status = 0;
            } else {
                $item_status = 1;
            }

            $value = "[COMPANY_ID] = '$company_id', [LOCATION_NAME] = '$location', [DEPARTMENT_NAME] = '$department', [POINT_NAME] = '$point', [IP_ADDRESS] = '$ip', [E_STATUS] = '$e_status', [ITEM_STATUS] = '$item_status'";
            $condition = "[E_ID] = '$e_id'";

            $para = set_stored_para("UPDATE", $oop->tbequipment, $value, $condition);

            if (db_query_stored($oop->rkadb, $oop->sp1, $para) != false) {
                header("refresh: 0; url=$oop->appequipment/frm_manage_equipment.php");
                echo '<script>window.alert("เปลี่ยนสถานะแล้ว!!");</script>';
                exit(0);
            } else {
                header("refresh: 0; url=$oop->appequipment/frm_manage_equipment.php");
                echo '<script>window.alert("ผิดพลาด!!!");</script>';
                exit(0);
            }
        }
    } else {
        header("refresh: 0; url=$oop->apphome");
        exit(0);
    }
}
?>

