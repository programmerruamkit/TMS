<?php

session_start();
//error_reporting(65);
date_default_timezone_set("Asia/Bangkok");

class object {

    function object() {
        //APPLICATION
        //---------------------------------------------------------------------
        $this->application = "";
        $this->application_name = "";
        $this->version = "0";
        //DATA BASE
        //---------------------------------------------------------------------
        $this->dbhost = "203.150.29.241\SQLEXPRESS,1433";
        $this->dbname = "RKADB";
        $this->dbuser = "sa";
        $this->dbpass = 'tm$wa01';
        //TABLE
        //---------------------------------------------------------------------
        $this->tbapplication = "TB_RKAPP_APPLICATIONDATA";
        $this->tblogin = "TB_RKUSER_LOGINDATA";
        $this->tbtype = "TB_RKDATA_TYPEDATA";
        $this->tbcompany = "TB_RKDATA_COMPANYDATA";
        $this->tbperson = "TB_RKDATA_PERSONDATA";
        $this->tbequipment = "TB_RKEQU_EQUIPMENTDATA";
        $this->tborder = "TB_RKITR_ORDERDATA";
        $this->tbwork = "TB_RKITM_WORKDATA";
        //PART FORDER
        //---------------------------------------------------------------------
        $this->rkapp = "/RKAPP";
        $this->appitr = $this->rkapp . "/ITR";
        $this->appitm = $this->rkapp . "/ITM";
        $this->appequ = $this->rkapp . "/EQU";
        $this->applogin = $this->rkapp . "/LOGIN";
        $this->apptool = $this->rkapp . "/TOOL";
        $this->appback = $this->rkapp . "/BACKOFFICE";
        $this->file = $this->rkapp . "/FILE";
        $this->sbadmin = $this->apptool . "/SBADMIN";
        $this->tool = "/TOOL";
        //SQL
        //---------------------------------------------------------------------
        $this->sql = $this->apptool."/SQL";
        $this->sqlperson = $this->sql."/SQL_PERSON_DATA.php";
        $this->sqltype = $this->sql."/SQL_TYPE_DATA.php";
        $this->sqlequipment = $this->sql."/SQL_EQUIPMENT_DATA.php";
        $this->sqlorder = $this->sql."/SQL_ORDER_DATA.php";
        $this->sqlwork = $this->sql."/SQL_WORK_DATA.php";
        //SYSTEM
        //---------------------------------------------------------------------
        $this->repair_system = 0;
    }

}

;

$rki = new object;

// = SYSTEM FILES ==============================================================
require_once($rki->tool . "/CONNECTION" . "/CONNECTION_DATABASE.php");
require_once($rki->tool . "/FUNCTION" . "/FUNCTION_SQL.php");
require_once($rki->tool . "/FUNCTION" . "/FUNCTION_PHP.php");
require_once($rki->tool . "/PAGE" . "/PAGE_HEAD.php");
require_once($rki->tool . "/PAGE" . "/PAGE_MODAL.php");
//require_once("../../" . $rki->tool . "/PAGE" . "/PAGE_FOOTER.php");

// = CONNECTION DATABASE =======================================================
$rki->conn = db_connect($rki->dbhost, $rki->dbname, $rki->dbuser, $rki->dbpass);

// = STORED PROCEDURE =========================================================
$rki->stmanagement = call_stored("ST_RKADB_MANAGEMENT");
$rki->sto = call_stored("ST_RKADB_MANAGEMENT");

// = DATE TIME SERVER ==========================================================
$rki->serverdate = set_datetime_server($rki->conn, 'date');
$rki->servertime = set_datetime_server($rki->conn, 'time');

require_once($rki->tool . "/PAGE" . "/PAGE_FOOTER.php");

if ($rki->repair_system == 1) {
    if ($page_title != "Maintenance") {
        header("refresh: 0; url=".$rki->rkapp."/maintenance.php");
        exit(0);
    }
} else {
    if ($_SESSION['TIME_TO_LOGIN'] != '') {
        if ($_SESSION['TIME_TO_LOGIN'] > date("H:i", strtotime("+1 hours"))) {
            echo '<script type="text/javascript">window.alert("ท่านอยู่ในระบบนานเกินไป กรุณา Login ใหม่");</script>';
            header("refresh: 0; url=/RKAPP/LOGIN/pages/check_logout.php");
            exit(0);
        } else if ($_SESSION['TIME_TO_LOGIN'] < date("H:i", strtotime("+1 hours"))) {
            
        }
    }
    if ($_SESSION['LOGIN_STATUS'] == '') {
        if ($page_title == "Login") {
            
        } else if ($page_title == "Modal") {
            
        } else if ($page_title == "Logout") {
            
        } else {
            $_SESSION['PAGE_LINK'] = $_SERVER['PHP_SELF'];
            echo '<script type="text/javascript">window.alert("กรุณา [เข้าสู่ระบบ] ก่อน!!");</script>';
            header("refresh: 0; url=/RKAPP/LOGIN/");
            exit(0);
        }
    } else {
        if ($page_title == "Login") {
            header("refresh: 0; url=/RKAPP/");
            exit(0);
        }
    }
}
?>