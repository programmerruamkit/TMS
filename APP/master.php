<?php

//session_start();
//error_reporting(65);
date_default_timezone_set("Asia/Bangkok");

class object {

    function object() {
        //APPLICATION
        //---------------------------------------------------------------------
        $this->application = "";
        $this->application_name = "";
        $this->version = "0.2";
        //DATA BASE
        //---------------------------------------------------------------------
        $this->dbhost = "203.150.29.241\SQLEXPRESS,1433";
        $this->dbname = "RKADB";
        $this->dbuser = "sa";
        $this->dbpass = 'tm$wa01';
        //TABLE
        //---------------------------------------------------------------------
        $this->tblogin = "TB_RKUSER_LOGINDATA";
        $this->tbtype = "RKADB_TABLE_TYPE";
        $this->tbcompany = "TB_RKDATA_COMPANYDATA";
        $this->tbperson = "RKADB_TABLE_PERSON";
        $this->tbequipment = "RKADB_TABLE_EQUIPMENT";
        $this->tborder = "RKADB_TABLE_ORDER";
        $this->tbwork = "RKADB_TABLE_WORK";
        //PART FORDER
        //---------------------------------------------------------------------
        //$this->host = "http://localhost";
        $this->host = "http://203.150.29.241:8080";
        $this->apphome = $this->host . "/app";
        $this->appadmin = $this->apphome . "/admin";
        $this->appmanagement = $this->apphome . "/management";
        $this->apprequest = $this->apphome . "/request";
        $this->appequipment = $this->apphome . "/equipment";
        $this->file = $this->apphome . "/file";
        $this->tool = "/tools";
        $this->temp = $this->apphome . "/tools/template/";
        //SQL
        //---------------------------------------------------------------------
        $this->sql = $this->apphome . "/sql/page_sql.php";
        //SYSTEM
        //---------------------------------------------------------------------
        $this->repair_system = 0;
    }

};

$oop = new object;

// = SYSTEM FILES ==============================================================
require_once($oop->tool . "/dbconnect" . "/function_sql_connect.php");
require_once($oop->tool . "/php_function" . "/tophp.php");
require_once($oop->tool . "/php_function" . "/tosql.php");
require_once($oop->tool . "/mpdf" . "/autoload.php");
require_once($oop->tool . "/src" . "/header.php");
require_once($oop->tool . "/src" . "/modal.php");
require_once($oop->tool . "/mailer" . "/class.phpmailer.php");

// = CONNECTION DATABASE =======================================================
$oop->rkadb = db_connect($oop->dbhost, $oop->dbname, $oop->dbuser, $oop->dbpass);

// = STORED PROCEDURE =========================================================
$oop->sp1 = call_stored("DATA_MANAGEMENT");

// = DATE TIME SERVER ==========================================================
$oop->serverdate = set_datetime_server($oop->rkadb, 'date');
$oop->servertime = set_datetime_server($oop->rkadb, 'time');

//header("Refresh:300");

if($_COOKIE['LOGON_STATUS'] == 'N' || $_COOKIE['LOGON_STATUS'] == ''){
    if($title_page == 'Login'){
        
    }else if($title_page == 'SQL'){
        
    }else if($title_page == '404'){
        
    }else{
        $oop->path = this_path_url();
        header("refresh: 0; url=/app/login.php");
        exit(0);
    }
}else if($_COOKIE['LOGON_STATUS'] == 'Y'){
    if($title_page == 'Login'){
        
    }else if($title_page == 'SQL'){
        
    }else if($title_page == '404'){
        
    }else{
        $oop->path = this_path_url();
    }
}

?>