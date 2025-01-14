<?php

date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
require_once("lib/nusoap.php");

//Create a new soap server
$server = new soap_server();

//Define our namespace
$namespace = "http://localhost/nusoap/index.php";
$server->wsdl->schemaTargetNamespace = $namespace;

//Configure our WSDL
$server->configureWSDL("TTAST >> RRR");
$varname = array(
    'dateinput' => "xsd:string",
    'employeecode' => "xsd:string",
    'vehiclenumber' => "xsd:string",
    'vehicletype' => "xsd:string",
    'jobstart' => "xsd:string",
    'jobend' => "xsd:string",
    'zone' => "xsd:string",
    'documentnumber' => "xsd:string",
    'weightin' => "xsd:string",
    'remark' => "xsd:string"
);
$server->register('insPlanttastrrr', $varname, array('return' => 'xsd:string'));

function insPlanttastrrr($dateinput, $employeecode, $vehiclenumber, $vehicletype, $jobstart, $jobend, $zone, $documentnumber, $weightin, $remark) {
    if ($dateinput == '' || $employeecode == '' || $vehiclenumber == '' || $vehicletype == '' || $jobstart == '' || $jobend == '' || $zone == '' || $documentnumber == '' || $weightin == '' || $remark == '') {
        return "ข้อมูลเป็นค่าว่าง...";
    } else {
        $rs = insInputttastrrr('save_inputrkrttast', '', '', '', $dateinput, $employeecode, $vehiclenumber, $vehicletype, $jobstart, $jobend, $zone, $documentnumber, $weightin, $remark, 'service');
        switch ($rs) {
            case 'complete': {
                    return "บันทึกข้อมูลเรียบร้อย...";
                }
                break;
            case 'error': {
                    return "เกิดข้อผิดพลาดในการบันทึกข้อมูล !!!";
                }
                break;
            default : {
                    return $rs;
                }
                break;
        }
    }
}

// Get our posted data if the service is being consumed
// otherwise leave this data blank.
$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';

// pass our posted data (or nothing) to the soap service
$server->service($POST_DATA);
exit();
?>