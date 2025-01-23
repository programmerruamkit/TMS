<?php
function connectEHR($db) {
    $serverName = "EHR";
    $userName = "sa";
    $userPassword = 'Fpce#9084';
    $dbName = $db;
    $connectionInfo = array("Database" => $dbName, "UID" => $userName, "PWD" => $userPassword, "MultipleActiveResultSets" => true, "CharacterSet" => 'UTF-8');
    $conn = sqlsrv_connect($serverName, $connectionInfo);
    return $conn;
}
function connect($db) {
//$serverName = "EHR\SQLEXPRESS,1433";
//$userName = "sa";
//$userPassword = 'tm$wa01';
//$dbName = $db;
//$connectionInfo = array("Database" => $dbName, "UID" => $userName, "PWD" => $userPassword, "MultipleActiveResultSets" => true, "CharacterSet" => 'UTF-8');
//$conn = sqlsrv_connect($serverName, $connectionInfo);
//return $conn;
	
    $serverName = "RK01";
    $userName = "sa";
    $userPassword = 'Fpce#9084';
    $dbName = $db;
    $connectionInfo = array("Database" => $dbName, "UID" => $userName, "PWD" => $userPassword, "MultipleActiveResultSets" => true, "CharacterSet" => 'UTF-8');
    $conn = sqlsrv_connect($serverName, $connectionInfo);
    return $conn;
}
function select_empautocomplateemprktc() {
    $conn = connect("RTMS");
    $data = "";
    $sql = "SELECT DISTINCT [MECHANIC] FROM RKTC WHERE 1=1 AND [MECHANIC] != ''";
    $params = array();
    $query = sqlsrv_query($conn, $sql, $params);
    while ($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $data .= "'" . $result['MECHANIC'] . "',";
    }
    return rtrim($data, ",");
}
function select_empautocomplatedetailrktc() {
    $conn = connect("RTMS");
    $data = "";
    $sql = "
    SELECT DISTINCT [TYPNAME] FROM RKTC 
    WHERE 1=1 AND [TYPNAME] != ''";
    $params = array();
    $query = sqlsrv_query($conn, $sql, $params);
    while ($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $data .= "'" . $result['TYPNAME'] . "',";
    }
    return rtrim($data, ",");
}
function updDiagramrrcgmt($FLG, $id,$actualprice, $cond7, $cond8, $condholiday,$customercode) {
    $conn = connect("RTMS");
    $sql = "{call megVehicletransportplancopydiagram_v2(?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($id, SQLSRV_PARAM_IN),
        array($actualprice, SQLSRV_PARAM_IN),
        array($cond7, SQLSRV_PARAM_IN),
        array($cond8, SQLSRV_PARAM_IN),
        array($condholiday, SQLSRV_PARAM_IN),
        array($customercode, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);

    sqlsrv_close($conn);
    return $result['RS'];
}
function delCheckplan($FLG, $companycode, $customercode, $vehicletype, $jobstart, $jobend, $employeename1) {
    $conn = connect("RTMS");
    $sql = "{call megCheckplan_v2(?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($companycode, SQLSRV_PARAM_IN),
        array($customercode, SQLSRV_PARAM_IN),
        array($vehicletype, SQLSRV_PARAM_IN),
        array($jobstart, SQLSRV_PARAM_IN),
        array($jobend, SQLSRV_PARAM_IN),
        array($employeename1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);

    sqlsrv_close($conn);
    return $result['RS'];
}
function commitRktc()
{
    $conn = connect("RTMS");
    $sql = "{call megRktc_v2(?)}";
    $params = array(
        array('commit_rktc', SQLSRV_PARAM_IN)
        
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);

    sqlsrv_close($conn);
    return $result['RS'];
}
function commitDcs1()
{
    $conn = connect("RTMS");
    $sql = "{call megDcs1_v2(?)}";
    $params = array(
        array('commit_dcs1', SQLSRV_PARAM_IN)
        
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);

    sqlsrv_close($conn);
    return $result['RS'];
}
function commitDcs2()
{
    $conn = connect("RTMS");
    $sql = "{call megDcs2_v2(?)}";
    $params = array(
        array('commit_dcs2', SQLSRV_PARAM_IN)
        
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);

    sqlsrv_close($conn);
    return $result['RS'];
}
function delDcs1()
{
    $conn = connect("RTMS");
    $sql = "{call megDcs1_v2(?)}";
    $params = array(
        array('delete_dcs1', SQLSRV_PARAM_IN)
        
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);

    sqlsrv_close($conn);
    return $result['RS'];
}
function delRktc()
{
    $conn = connect("RTMS");
    $sql = "{call megRktc_v2(?)}";
    $params = array(
        array('delete_rktc', SQLSRV_PARAM_IN)
        
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);

    sqlsrv_close($conn);
    return $result['RS'];
}
function delDcs2()
{
    $conn = connect("RTMS");
    $sql = "{call megDcs2_v2(?)}";
    $params = array(
        array('delete_dcs2', SQLSRV_PARAM_IN)
        
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);

    sqlsrv_close($conn);
    return $result['RS'];
}
function insRktc($FLG,$CONDITION1,$NICKNM, $CUSCOD, $OPENDATE, $CLOSEDATE,$TAXINVOICEDATEE, $REGNO, $CHASSIS, $MILEAGE, $JOBNO, $TYPNAME, $SPAREPARTSDETAIL, $NET, $COST, $SELLING, $SPAREPARTSSELLER,$SUMMARY, $WAGES, $MECHANIC, $WORKINGHOURS, $COLLECTIONHOURS)
{
    $conn = connect("RTMS");
    $sql = "{call megRktc_v2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($NICKNM, SQLSRV_PARAM_IN),
        array($CUSCOD, SQLSRV_PARAM_IN),
        array($OPENDATE, SQLSRV_PARAM_IN), 
        array($CLOSEDATE, SQLSRV_PARAM_IN),
        
        array($TAXINVOICEDATEE, SQLSRV_PARAM_IN),
        array($REGNO, SQLSRV_PARAM_IN),
        array($CHASSIS, SQLSRV_PARAM_IN),
        array($MILEAGE, SQLSRV_PARAM_IN),
        array($JOBNO, SQLSRV_PARAM_IN),
        
        array($TYPNAME, SQLSRV_PARAM_IN),
        array($SPAREPARTSDETAIL, SQLSRV_PARAM_IN),
        array($NET, SQLSRV_PARAM_IN),
        array($COST, SQLSRV_PARAM_IN),
        array($SELLING, SQLSRV_PARAM_IN),
        
        array($SPAREPARTSSELLER, SQLSRV_PARAM_IN),
        array($SUMMARY, SQLSRV_PARAM_IN),
        array($WAGES, SQLSRV_PARAM_IN),
        array($MECHANIC, SQLSRV_PARAM_IN),
        array($WORKINGHOURS, SQLSRV_PARAM_IN),
        
        array($COLLECTIONHOURS, SQLSRV_PARAM_IN)
        
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);

    sqlsrv_close($conn);
    return $result['RS'];
}
function insDcs1($FLG,$CONDITION1,$PLANNINGTERMYEARFROM, $PLANNINGTERMCDFROM, $RTEGRPCD, $RTEDATES, $RUNSEQ, $DRIVERACCSEQ, $LOGPT, $LOGPTCD, $PLANTCD, $DOCKCD, $DOORCD, $ARRDATES, $ARRVTIME, $DPTDATES, $DPTTIME)
{
    $conn = connect("RTMS");
    $sql = "{call megDcs1_v2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($PLANNINGTERMYEARFROM, SQLSRV_PARAM_IN),
        array($PLANNINGTERMCDFROM, SQLSRV_PARAM_IN),
        array($RTEGRPCD, SQLSRV_PARAM_IN),
        array($RTEDATES, SQLSRV_PARAM_IN),
        array($RUNSEQ, SQLSRV_PARAM_IN),
        array($DRIVERACCSEQ, SQLSRV_PARAM_IN),
        array($LOGPT, SQLSRV_PARAM_IN),
        array($LOGPTCD, SQLSRV_PARAM_IN),
        array($PLANTCD, SQLSRV_PARAM_IN),
        array($DOCKCD, SQLSRV_PARAM_IN),
        array($DOORCD, SQLSRV_PARAM_IN),
        array($ARRDATES, SQLSRV_PARAM_IN),
        array($ARRVTIME, SQLSRV_PARAM_IN),
        array($DPTDATES, SQLSRV_PARAM_IN),
        array($DPTTIME, SQLSRV_PARAM_IN)
        
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);

    sqlsrv_close($conn);
    return $result['RS'];
}
function insDcs2($FLG,$CONDITION1,$PLANNINGTERMYEARFROM, $PLANNINGTERMCDFROM, $PLANNINGTERMYEARTO, $PLANNINGTERMCDTO, $RTEGRPCD, $RTEDATES, $RUNSEQ, $LOGPTTO, $RCVCOMPCD, $RCVCOMPPLANTCD, $RCVCOMPDOCKCD, $LOGPTFROM, $SUPPCD, $SUPPPLANTCD, $SUPPDOCKCD, $LOGPTCDFROM, $PLANTCDFROM, $DOCKCDFROM, $LOGPTCDTO, $PLANTCDTO, $DOCKCDTO, $PHYPTFROM, $PHYLOGPTCDFROM, $PHYPLANTCDFROM, $PHYDOCKCDFROM, $PHYPTTO, $PHYLOGPTCDTO, $PHYPLANTCDTO, $PHYDOCKCDTO, $PARTEMPKBTYPECD, $ORDDATE, $ORDSEQS, $LOADMATRIXUNLOADSTRDATE, $LOADMATRIXUNLOADSTRTIME, $LOADMATRIXUNLOADENDDATE, $LOADMATRIXUNLOADENDIME)
{
    $conn = connect("RTMS");
    $sql = "{call megDcs2_v2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($PLANNINGTERMYEARFROM, SQLSRV_PARAM_IN), 
        array($PLANNINGTERMCDFROM, SQLSRV_PARAM_IN), 
        array($PLANNINGTERMYEARTO, SQLSRV_PARAM_IN), 
        array($PLANNINGTERMCDTO, SQLSRV_PARAM_IN), 
        array($RTEGRPCD, SQLSRV_PARAM_IN), 
        array($RTEDATES, SQLSRV_PARAM_IN), 
        array($RUNSEQ, SQLSRV_PARAM_IN), 
        array($LOGPTTO, SQLSRV_PARAM_IN), 
        array($RCVCOMPCD, SQLSRV_PARAM_IN), 
        array($RCVCOMPPLANTCD, SQLSRV_PARAM_IN), 
        array($RCVCOMPDOCKCD, SQLSRV_PARAM_IN), 
        array($LOGPTFROM, SQLSRV_PARAM_IN), 
        array($SUPPCD, SQLSRV_PARAM_IN), 
        array($SUPPPLANTCD, SQLSRV_PARAM_IN), 
        array($SUPPDOCKCD, SQLSRV_PARAM_IN), 
        array($LOGPTCDFROM, SQLSRV_PARAM_IN), 
        array($PLANTCDFROM, SQLSRV_PARAM_IN), 
        array($DOCKCDFROM, SQLSRV_PARAM_IN), 
        array($LOGPTCDTO, SQLSRV_PARAM_IN), 
        array($PLANTCDTO, SQLSRV_PARAM_IN), 
        array($DOCKCDTO, SQLSRV_PARAM_IN), 
        array($PHYPTFROM, SQLSRV_PARAM_IN), 
        array($PHYLOGPTCDFROM, SQLSRV_PARAM_IN), 
        array($PHYPLANTCDFROM, SQLSRV_PARAM_IN), 
        array($PHYDOCKCDFROM, SQLSRV_PARAM_IN), 
        array($PHYPTTO, SQLSRV_PARAM_IN), 
        array($PHYLOGPTCDTO, SQLSRV_PARAM_IN), 
        array($PHYPLANTCDTO, SQLSRV_PARAM_IN), 
        array($PHYDOCKCDTO, SQLSRV_PARAM_IN), 
        array($PARTEMPKBTYPECD, SQLSRV_PARAM_IN), 
        array($ORDDATE, SQLSRV_PARAM_IN), 
        array($ORDSEQS, SQLSRV_PARAM_IN), 
        array($LOADMATRIXUNLOADSTRDATE, SQLSRV_PARAM_IN), 
        array($LOADMATRIXUNLOADSTRTIME, SQLSRV_PARAM_IN), 
        array($LOADMATRIXUNLOADENDDATE, SQLSRV_PARAM_IN), 
        array($LOADMATRIXUNLOADENDIME, SQLSRV_PARAM_IN)
        
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);

    sqlsrv_close($conn);
    return $result['RS'];
}
function insMaintenanceplan($FLG,$CONDITION1,$COMPANY, $CUSTOMER, $VEHICLETYPE, $VEHICLEREGISNUMBER, $REPAIRAREA, $REPAIRAREADETAIL, $CARUSEDATE, $REPAIRTYPE, $CARPRODUCT, $DRIVINGSTATUS, $ANALYZEISSUE, $REPAIRSTATUS) {
    $conn = connect("RTMS");
    $sql = "{call megRepairplan_v2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($COMPANY, SQLSRV_PARAM_IN),
        array($CUSTOMER, SQLSRV_PARAM_IN),
        array($VEHICLETYPE, SQLSRV_PARAM_IN),
        array($VEHICLEREGISNUMBER, SQLSRV_PARAM_IN),
        array($REPAIRAREA, SQLSRV_PARAM_IN),
        array($REPAIRAREADETAIL, SQLSRV_PARAM_IN),
        array($CARUSEDATE, SQLSRV_PARAM_IN),
        array($REPAIRTYPE, SQLSRV_PARAM_IN),
        array($CARPRODUCT, SQLSRV_PARAM_IN),
        array($DRIVINGSTATUS, SQLSRV_PARAM_IN),
        array($ANALYZEISSUE, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array($REPAIRSTATUS, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);

    sqlsrv_close($conn);
    return $result['RS'];
}
function haversineGreatCircleDistance(
$latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000) {
// convert from degrees to radians
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);

    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;

    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
    return number_format((($angle * $earthRadius) / 1000), 2);
}
function editVehicletransportplanjobhome($FLG, $CONDITION1, $CUSTOMERCODE) {
    $conn = connect("RTMS");
    $sql = "{call megVehicletransportplan_v2(?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($CUSTOMERCODE, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function update_checkin($employeecode, $mapaddress, $workcheckinid) {
    $conn = connect("RTMS");

    $sql_seWorkcheckintime = "SELECT COUNT(*) AS 'CHKTIME' FROM [dbo].[WORKCHECKIN] WHERE
CONVERT(DATETIME,GETDATE(),103) BETWEEN CONVERT(DATETIME,CONVERT(NVARCHAR(10),CONVERT(DATETIME,GETDATE(),103),103) +' 13:00:00',103)
AND CONVERT(DATETIME,CONVERT(NVARCHAR(10),CONVERT(DATETIME,GETDATE(),103),103) +' 14:00:00',103)
AND EMPLOYEECODE = '" . $employeecode . "'";
    $query_seWorkcheckintime = sqlsrv_query($conn, $sql_seWorkcheckintime, $params_seWorkcheckintime);
    $result_seWorkcheckintime = sqlsrv_fetch_array($query_seWorkcheckintime, SQLSRV_FETCH_ASSOC);








    $sql_seAddress = "SELECT[EMPLOYEECODEMASTER],[LATIUDEMASTER],[LONGITUDEMASTER],[MAPADDRESSMASTER],RIGHT(MAPADDRESSMASTER,1) AS 'CHKEN' FROM [dbo].[WORKCHECKINMASTER] WHERE [EMPLOYEECODEMASTER] = '" . $employeecode . "'";
    $query_seAddress = sqlsrv_query($conn, $sql_seAddress, $params_seAddress);
    $result_seAddress = sqlsrv_fetch_array($query_seAddress, SQLSRV_FETCH_ASSOC);
    if (preg_match('/^[a-z]+$/i', $result_seAddress['CHKEN'])) {


        $sql_seProvincemaster = "SELECT VALUE FROM (
    SELECT
        ROW_NUMBER () OVER (
            ORDER BY (SELECT 1)
        ) RowNum,VALUE
    FROM
        STRING_SPLIT('" . $result_seAddress['MAPADDRESSMASTER'] . "',',')
) t
WHERE
    RowNum = (SELECT COUNT(*) FROM STRING_SPLIT('" . $result_seAddress['MAPADDRESSMASTER'] . "',','))-1";
        $query_seProvincemaster = sqlsrv_query($conn, $sql_seProvincemaster, $params_seProvincemaster);
        $result_seProvincemaster = sqlsrv_fetch_array($query_seProvincemaster, SQLSRV_FETCH_ASSOC);
    } else {

        $sql_seProvincemaster = "SELECT VALUE FROM (
    SELECT
        ROW_NUMBER () OVER (
            ORDER BY (SELECT 1)
        ) RowNum,VALUE
    FROM
        STRING_SPLIT('" . $result_seAddress['MAPADDRESSMASTER'] . "',' ')
) t
WHERE
    RowNum = (SELECT COUNT(*) FROM STRING_SPLIT('" . $result_seAddress['MAPADDRESSMASTER'] . "',' '))-2";
        $query_seProvincemaster = sqlsrv_query($conn, $sql_seProvincemaster, $params_seProvincemaster);
        $result_seProvincemaster = sqlsrv_fetch_array($query_seProvincemaster, SQLSRV_FETCH_ASSOC);
    }

    $sql_seWorkcheckinmax = "SELECT RIGHT('" . $mapaddress . "',1) AS 'CHKEN' ";
    $query_seWorkcheckinmax = sqlsrv_query($conn, $sql_seWorkcheckinmax, $params_seWorkcheckinmax);
    $result_seWorkcheckinmax = sqlsrv_fetch_array($query_seWorkcheckinmax, SQLSRV_FETCH_ASSOC);


    if (preg_match('/^[a-z]+$/i', $result_seWorkcheckinmax['CHKEN'])) {

        $sql_seProvince = "SELECT VALUE FROM (
    SELECT
        ROW_NUMBER () OVER (
            ORDER BY (SELECT 1)
        ) RowNum,VALUE
    FROM
        STRING_SPLIT('" . $mapaddress . "',',')
) t
WHERE
    RowNum = (SELECT COUNT(*) FROM STRING_SPLIT('" . $mapaddress . "',','))-1";
        $query_seProvince = sqlsrv_query($conn, $sql_seProvince, $params_seProvince);
        $result_seProvince = sqlsrv_fetch_array($query_seProvince, SQLSRV_FETCH_ASSOC);
    } else {

        $sql_seProvince = "SELECT VALUE FROM (
    SELECT
        ROW_NUMBER () OVER (
            ORDER BY (SELECT 1)
        ) RowNum,VALUE
    FROM
        STRING_SPLIT('" . $mapaddress . "',' ')
) t
WHERE
    RowNum = (SELECT COUNT(*) FROM STRING_SPLIT('" . $mapaddress . "',' '))-2";
        $query_seProvince = sqlsrv_query($conn, $sql_seProvince, $params_seProvince);
        $result_seProvince = sqlsrv_fetch_array($query_seProvince, SQLSRV_FETCH_ASSOC);
    }



    $remark = "";
    if ($result_seWorkcheckintime['CHKTIME'] == '0') {

        $remark = "1";
    } else {
        if ($result_seProvincemaster['VALUE'] != $result_seProvince['VALUE']) {
            $remark = "2";
        } else {
            $remark = "0";
        }
    }

    $sql = "{call megWorkcheckin_v2(?,?,?)}";
    $params = array(
        array('update_workcheckin', SQLSRV_PARAM_IN),
        array($workcheckinid, SQLSRV_PARAM_IN),
        array($remark, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
}

function getChart($val, $year) {
    $conn = connect("RTMS");

    $arr_data = array();
// คำสั่ง sql เปลี่ยนไปตามความเหมาะสม ขึ้นกับว่าเป็นข้อมูลประเภทไหน
// และต้องการใช้ข้อมูลในลักษณะใด ในที่นี้ เป็นการหายอดรวม ของสินค้า
// แต่ละรายการ ในแต่ละเดือน ของปี ที่ส่งค่าตัวแปรมา
    $sql_q = "
    SELECT
    SUM(quantity) as total_quantity
    FROM tbl_sale WHERE name='" . $val . "' AND date LIKE '" . $year . "%'
    ";
    $query_q = sqlsrv_query($conn, $sql_q, $params_q);
    while ($rs_q = sqlsrv_fetch_array($query_q, SQLSRV_FETCH_ASSOC)) {
        $arr_data[] = $rs_q['total_quantity'];
    }
    return $arr_data;  // ส่งค่ากลับชุด array ข้อมูล
}
function insEmployeemaintenanceplan($FLG, $CONDITION1, $EMPLOYEECODE, $EMPLOYEENAME) {
    $conn = connect("RTMS");
    $sql = "{call megRepairemployee_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($EMPLOYEECODE, SQLSRV_PARAM_IN),
        array($EMPLOYEENAME, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}
function insImagesmaintenanceplan($FLG, $CONDITION1, $TYPE, $PATH) {
    $conn = connect("RTMS");
    $sql = "{call megRepairimages_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($TYPE, SQLSRV_PARAM_IN),
        array($PATH, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delEmployeemaintenanceplan($FLG, $CONDITION1,$EMPLOYEECODE,$EMPLOYEENAME) {
    $conn = connect("RTMS");
    $sql = "{call megRepairemployee_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($EMPLOYEECODE, SQLSRV_PARAM_IN),
        array($EMPLOYEENAME, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}
function delEmployeemaintenanceplanall($FLG) {
    $conn = connect("RTMS");
    $sql = "{call megRepairemployee_v2(?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}
function show_cnttgt($JOBSTART, $JOBEND, $DD, $MM, $COND) {
    $conn = connect("RTMS");
    if ($JOBEND != '') {
        $sql = "SELECT COUNT(*) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN]
        WHERE ACTIVESTATUS = '1' AND COMPANYCODE = 'RKS' AND CUSTOMERCODE = 'TGT'
        AND JOBSTART = '" . $JOBSTART . "' AND JOBEND = '" . $JOBEND . "'
        AND CONVERT(VARCHAR(2),CREATEDATE,3) = '" . $DD . "' AND CONVERT(VARCHAR(2),CREATEDATE,1) = '" . $MM . "'
        AND CONVERT(VARCHAR(4),CREATEDATE,111) = CONVERT(VARCHAR(4),GETDATE(),111)";

        $query = sqlsrv_query($conn, $sql, $params);
        $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
        return $result['CNT'];
    } else {
        $sql = "SELECT COUNT(*) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN]
        WHERE ACTIVESTATUS = '1' AND COMPANYCODE = 'RKS' AND CUSTOMERCODE = 'TGT'
        AND JOBSTART = '" . $JOBSTART . "'
        AND CONVERT(VARCHAR(2),CREATEDATE,3) = '" . $DD . "' AND CONVERT(VARCHAR(2),CREATEDATE,1) = '" . $MM . "'
        AND CONVERT(VARCHAR(4),CREATEDATE,111) = CONVERT(VARCHAR(4),GETDATE(),111)";
        $query = sqlsrv_query($conn, $sql . $COND, $params);
        $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
        return $result['CNT'];
    }
}

function show_startdate() {
    $conn = connect("RTMS");

    $sql = "SELECT DATEADD(MONTH, DATEDIFF(MONTH, 0, getdate()), 0) AS 'STARTDATE'";

    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    return $result['STARTDATE'];
}

function show_enddate() {
    $conn = connect("RTMS");

    $sql = "SELECT DATEADD(d, -1, DATEADD(MONTH, DATEDIFF(MONTH, 0, GETDATE())+1, 0)) AS 'ENDDATE'";

    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    return $result['ENDDATE'];
}

function send_notify_message($message, $access_token) {
    $line_api = 'https://notify-api.line.me/api/notify';
    $imageFile = curl_file_create('D:/www/tms-dev/pages/images/dataTables-example.jpg', 'image/jpg', 'dataTables-example.jpg');

    $rs_message = ($message == '') ? 'แผนงานการขนส่ง' : $message;

    $message_data = array(
        'message' => $rs_message,
        'imageFile' => $imageFile
    );

    $headers = array('Method: POST', 'Content-type: multipart/form-data', 'Authorization: Bearer ' . $access_token);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $line_api);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $message_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);

    if (curl_error($ch)) {
        $return_array = array('status' => '000: send fail', 'message' => curl_error($ch));
    } else {
        $return_array = json_decode($result, true);
    }
    curl_close($ch);
    return $return_array;
}

function send_message($message, $access_token) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set("Asia/Bangkok");



    $chOne = curl_init();
    curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
    curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($chOne, CURLOPT_POST, 1);
    curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $message);
    $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $access_token . '',);
    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($chOne);

//Result error
//if(curl_error($chOne))
//{
//	echo 'error:' . curl_error($chOne);
//}
//else {
//	$result_ = json_decode($result, true);
//	echo "status : ".$result_['status']; echo "message : ". $result_['message'];
//}
    curl_close($chOne);
}

function send_workcheckin($message, $access_token) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set("Asia/Bangkok");



    $chOne = curl_init();
    curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
    curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($chOne, CURLOPT_POST, 1);
    curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $message);
    $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $access_token . '',);
    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
    curl_exec($chOne);

//Result error
//if(curl_error($chOne))
//{
//	echo 'error:' . curl_error($chOne);
//}
//else {
//	$result_ = json_decode($result, true);
//echo "รหัสพนักงาน : ".$result_['status']; echo "<br>";echo "ชื่อพนักงาน : ". $result_['message'];echo "<br>";echo "แผนที่ : https://www.google.com/maps/?q=13.4491517,101.0511075";
//}
//curl_close($chOne);
}

function updatevehicletransportplan_getwaye1($vehicletransportplanid, $E1) {
    $conn = connect("RTMS");
    $otbeforaffter = '';
    $ot = '';


    $condition = " AND a.VEHICLETRANSPORTPLANID = '" . $vehicletransportplanid . "'";
    $sql_seVehicletransportplan = "{call megVehicletransportplan_v2(?,?,?,?)}";
    $params_seVehicletransportplan = array(
        array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
        array($condition, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seVehicletransportplan = sqlsrv_query($conn, $sql_seVehicletransportplan, $params_seVehicletransportplan);
    $result_seVehicletransportplan = sqlsrv_fetch_array($query_seVehicletransportplan, SQLSRV_FETCH_ASSOC);
//echo $result_seVehicletransportplan['COMPANYCODE'];
    $condcompany2 = " AND Company_Code ='" . $result_seVehicletransportplan['COMPANYCODE'] . "'";
    $sql_seCompany2 = "{call megCompanyEHR_v2(?,?)}";
    $params_seCompany2 = array(
        array('select_company', SQLSRV_PARAM_IN),
        array($condcompany2, SQLSRV_PARAM_IN)
    );
    $query_seCompany2 = sqlsrv_query($conn, $sql_seCompany2, $params_seCompany2);
    $result_seCompany2 = sqlsrv_fetch_array($query_seCompany2, SQLSRV_FETCH_ASSOC);

    if ($result_seVehicletransportplan['COMPANYCODE'] == 'RRC') {
        $sql_seStartholidayrrc = "{call megHolidayEHR_v2(?,?,?,?)}";
        $params_seStartholidayrrc = array(
            array('start_holidayworkrrc', SQLSRV_PARAM_IN),
            array($result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
            array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
            array($result_seVehicletransportplan['DATEVLIN'], SQLSRV_PARAM_IN),
        );
        $query_seStartholidayrrc = sqlsrv_query($conn, $sql_seStartholidayrrc, $params_seStartholidayrrc);
        $result_seStartholidayrrc = sqlsrv_fetch_array($query_seStartholidayrrc, SQLSRV_FETCH_ASSOC);





        if ($result_seStartholidayrrc['HOLIDAYWORK'] != '0') {
            if ((($E1 * 1.5)-$E1) == '0') {
                editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'O1', '0');
                $ot = '0';
            } else {
                editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'O1', (($E1 * 1.5)-$E1));
                $ot = (($E1 * 1.5)-$E1);
            }
        } else {
            editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'O1', ($E1-$E1));
            $ot = ($E1-$E1);
        }
    } else {

        if ($result_seVehicletransportplan['COMPANYCODE'] == 'RCC' || $result_seVehicletransportplan['COMPANYCODE'] == 'RATC') {
            $sql_seStartholidayrcc = "{call megHolidayEHR_v2(?,?,?,?)}";
            $params_seStartholidayrcc = array(
                array('count_holiday', SQLSRV_PARAM_IN),
                array($result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
                array($result_seVehicletransportplan['DATERK'], SQLSRV_PARAM_IN),
            );
            $query_seStartholidayrcc = sqlsrv_query($conn, $sql_seStartholidayrcc, $params_seStartholidayrcc);
            $result_seStartholidayrcc = sqlsrv_fetch_array($query_seStartholidayrcc, SQLSRV_FETCH_ASSOC);
            
            $sql_seTenkoafter = "SELECT TOP 1 CONVERT(NVARCHAR(10),a.TENKOAFTERDATE,103) AS 'TENKOAFTERDATE' from [dbo].[TENKOAFTER] a
            INNER JOIN [dbo].[TENKOMASTER] b ON a.TENKOMASTERID = b.TENKOMASTERID
            WHERE b.VEHICLETRANSPORTPLANID = '".$result_seVehicletransportplan['VEHICLETRANSPORTPLANID']."'";
            $params_seTenkoafter = array();
            $query_seTenkoafter = sqlsrv_query($conn, $sql_seTenkoafter, $params_seTenkoafter);
            $result_seTenkoafter = sqlsrv_fetch_array($query_seTenkoafter, SQLSRV_FETCH_ASSOC);
            
            $sql_seStartholidaymondayrcc = "{call megHolidayEHR_v2(?,?,?,?)}";
            $params_seStartholidaymondayrcc = array(
                array('return_holidayworkrccmonday', SQLSRV_PARAM_IN),
                array($result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
                array($result_seTenkoafter['TENKOAFTERDATE'], SQLSRV_PARAM_IN),
            );
            $query_seStartholidaymondayrcc = sqlsrv_query($conn, $sql_seStartholidaymondayrcc, $params_seStartholidaymondayrcc);
            $result_seStartholidaymondayrcc = sqlsrv_fetch_array($query_seStartholidaymondayrcc, SQLSRV_FETCH_ASSOC);
            
            
            
                    
                    
            $sql_seBefore13holidayrcc = "{call megHolidayEHR_v2(?,?,?,?)}";
            $params_seBefore13holidayrcc = array(
                array('return_beforercc13', SQLSRV_PARAM_IN),
                array($result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
                array($result_seTenkoafter['TENKOAFTERDATE'], SQLSRV_PARAM_IN),
            );
            $query_seBefore13holidayrcc = sqlsrv_query($conn, $sql_seBefore13holidayrcc, $params_seBefore13holidayrcc);
            $result_seBefore13holidayrcc = sqlsrv_fetch_array($query_seBefore13holidayrcc, SQLSRV_FETCH_ASSOC);

            $sql_seAfter13holidayrcc = "{call megHolidayEHR_v2(?,?,?,?)}";
            $params_seAfter13holidayrcc = array(
                array('return_afterrcc13', SQLSRV_PARAM_IN),
                array($result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
                array($result_seTenkoafter['TENKOAFTERDATE'], SQLSRV_PARAM_IN),
            );
            $query_seAfter13holidayrcc = sqlsrv_query($conn, $sql_seAfter13holidayrcc, $params_seAfter13holidayrcc);
            $result_seAfter13holidayrcc = sqlsrv_fetch_array($query_seAfter13holidayrcc, SQLSRV_FETCH_ASSOC);


            $sql_seBefore13holidaymondayrcc = "{call megHolidayEHR_v2(?,?,?,?)}";
            $params_seBefore13holidaymondayrcc = array(
                array('return_beforemondayrcc13', SQLSRV_PARAM_IN),
                array($result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
                array($result_seTenkoafter['TENKOAFTERDATE'], SQLSRV_PARAM_IN),
            );
            $query_seBefore13holidaymondayrcc = sqlsrv_query($conn, $sql_seBefore13holidaymondayrcc, $params_seBefore13holidaymondayrcc);
            $result_seBefore13holidaymondayrcc = sqlsrv_fetch_array($query_seBefore13holidaymondayrcc, SQLSRV_FETCH_ASSOC);

            $sql_seAfter13holidaymondayrcc = "{call megHolidayEHR_v2(?,?,?,?)}";
            $params_seAfter13holidaymondayrcc = array(
                array('return_aftermondayrcc13', SQLSRV_PARAM_IN),
                array($result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
                array($result_seTenkoafter['TENKOAFTERDATE'], SQLSRV_PARAM_IN),
            );
            $query_seAfter13holidaymondayrcc = sqlsrv_query($conn, $sql_seAfter13holidaymondayrcc, $params_seAfter13holidaymondayrcc);
            $result_seAfter13holidaymondayrcc = sqlsrv_fetch_array($query_seAfter13holidaymondayrcc, SQLSRV_FETCH_ASSOC);

            if ($result_seStartholidaymondayrcc['HOLIDAYWORK'] != '0') {
                if ($result_seBefore13holidaymondayrcc['HOLIDAYWORK'] != '0') {
                    $otbeforaffter = "540";
                } else if ($result_seAfter13holidaymondayrcc['HOLIDAYWORK'] != '0') {
                    $otbeforaffter = "720";
                }
            } else {
                if ($result_seBefore13holidayrcc['HOLIDAYWORK'] != '0') {
                    $otbeforaffter = "180";
                } else if ($result_seAfter13holidayrcc['HOLIDAYWORK'] != '0') {
                    $otbeforaffter = "360";
                }
            }

            if ($result_seStartholidayrcc['HOLIDAYWORK'] != '0') {
                if ((($E1 * 1.5)-$E1) == '0') {
                    editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'O1', '0');
                    $ot = '0';
                } else {
                    editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'O1', (($E1 * 1.5)-$E1) + ($otbeforaffter));
                    $ot = (($E1 * 1.5)-$E1) + ($otbeforaffter);
                }
            } else {
                editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'O1', ($E1-$E1) + ($otbeforaffter));
                $ot = ($E1-$E1) + ($otbeforaffter);
            }


            //editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'C5', $otbefor + $otbeform);
            //editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'C6', $otaffter + $otbeform);
        }
        if ($E1 == '' || $E1 == '0') {
            echo '0';
            editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'O1', '0');
        } else {
            echo $ot;
        }
    }
}

function updatevehicletransportplan_getwaye2($vehicletransportplanid, $E1) {
    $conn = connect("RTMS");
    $otbeforaffter = '';
    $ot = '';


    $condition = " AND a.VEHICLETRANSPORTPLANID = '" . $vehicletransportplanid . "'";
    $sql_seVehicletransportplan = "{call megVehicletransportplan_v2(?,?,?,?)}";
    $params_seVehicletransportplan = array(
        array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
        array($condition, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seVehicletransportplan = sqlsrv_query($conn, $sql_seVehicletransportplan, $params_seVehicletransportplan);
    $result_seVehicletransportplan = sqlsrv_fetch_array($query_seVehicletransportplan, SQLSRV_FETCH_ASSOC);
//echo $result_seVehicletransportplan['COMPANYCODE'];
    $condcompany2 = " AND Company_Code ='" . $result_seVehicletransportplan['COMPANYCODE'] . "'";
    $sql_seCompany2 = "{call megCompanyEHR_v2(?,?)}";
    $params_seCompany2 = array(
        array('select_company', SQLSRV_PARAM_IN),
        array($condcompany2, SQLSRV_PARAM_IN)
    );
    $query_seCompany2 = sqlsrv_query($conn, $sql_seCompany2, $params_seCompany2);
    $result_seCompany2 = sqlsrv_fetch_array($query_seCompany2, SQLSRV_FETCH_ASSOC);

    if ($result_seVehicletransportplan['COMPANYCODE'] == 'RRC') {
        $sql_seStartholidayrrc = "{call megHolidayEHR_v2(?,?,?,?)}";
        $params_seStartholidayrrc = array(
            array('start_holidayworkrrc', SQLSRV_PARAM_IN),
            array($result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
            array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
            array($result_seVehicletransportplan['DATEVLIN'], SQLSRV_PARAM_IN),
        );
        $query_seStartholidayrrc = sqlsrv_query($conn, $sql_seStartholidayrrc, $params_seStartholidayrrc);
        $result_seStartholidayrrc = sqlsrv_fetch_array($query_seStartholidayrrc, SQLSRV_FETCH_ASSOC);





        if ($result_seStartholidayrrc['HOLIDAYWORK'] != '0') {
            if ((($E1 * 1.5)-$E1) == '0') {
                editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'O2', '0');
                $ot = '0';
            } else {
                editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'O2', (($E1 * 1.5)-$E1));
                $ot = (($E1 * 1.5)-$E1);
            }
        } else {
            editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'O2', ($E1-$E1));
            $ot = ($E1-$E1);
        }
    } else {

        if ($result_seVehicletransportplan['COMPANYCODE'] == 'RCC' || $result_seVehicletransportplan['COMPANYCODE'] == 'RATC') {
            $sql_seStartholidayrcc = "{call megHolidayEHR_v2(?,?,?,?)}";
            $params_seStartholidayrcc = array(
                array('count_holiday', SQLSRV_PARAM_IN),
                array($result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
                array($result_seVehicletransportplan['DATERK'], SQLSRV_PARAM_IN),
            );
            $query_seStartholidayrcc = sqlsrv_query($conn, $sql_seStartholidayrcc, $params_seStartholidayrcc);
            $result_seStartholidayrcc = sqlsrv_fetch_array($query_seStartholidayrcc, SQLSRV_FETCH_ASSOC);
            
            $sql_seTenkoafter = "SELECT TOP 1 CONVERT(NVARCHAR(10),a.TENKOAFTERDATE,103) AS 'TENKOAFTERDATE' from [dbo].[TENKOAFTER] a
            INNER JOIN [dbo].[TENKOMASTER] b ON a.TENKOMASTERID = b.TENKOMASTERID
            WHERE b.VEHICLETRANSPORTPLANID = '".$result_seVehicletransportplan['VEHICLETRANSPORTPLANID']."'";
            $params_seTenkoafter = array();
            $query_seTenkoafter = sqlsrv_query($conn, $sql_seTenkoafter, $params_seTenkoafter);
            $result_seTenkoafter = sqlsrv_fetch_array($query_seTenkoafter, SQLSRV_FETCH_ASSOC);
            
            $sql_seStartholidaymondayrcc = "{call megHolidayEHR_v2(?,?,?,?)}";
            $params_seStartholidaymondayrcc = array(
                array('return_holidayworkrccmonday', SQLSRV_PARAM_IN),
                array($result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
                array($result_seTenkoafter['TENKOAFTERDATE'], SQLSRV_PARAM_IN),
            );
            $query_seStartholidaymondayrcc = sqlsrv_query($conn, $sql_seStartholidaymondayrcc, $params_seStartholidaymondayrcc);
            $result_seStartholidaymondayrcc = sqlsrv_fetch_array($query_seStartholidaymondayrcc, SQLSRV_FETCH_ASSOC);

            $sql_seBefore13holidayrcc = "{call megHolidayEHR_v2(?,?,?,?)}";
            $params_seBefore13holidayrcc = array(
                array('return_beforercc13', SQLSRV_PARAM_IN),
                array($result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
                array($result_seTenkoafter['TENKOAFTERDATE'], SQLSRV_PARAM_IN),
            );
            $query_seBefore13holidayrcc = sqlsrv_query($conn, $sql_seBefore13holidayrcc, $params_seBefore13holidayrcc);
            $result_seBefore13holidayrcc = sqlsrv_fetch_array($query_seBefore13holidayrcc, SQLSRV_FETCH_ASSOC);

            $sql_seAfter13holidayrcc = "{call megHolidayEHR_v2(?,?,?,?)}";
            $params_seAfter13holidayrcc = array(
                array('return_afterrcc13', SQLSRV_PARAM_IN),
                array($result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
                array($result_seTenkoafter['TENKOAFTERDATE'], SQLSRV_PARAM_IN),
            );
            $query_seAfter13holidayrcc = sqlsrv_query($conn, $sql_seAfter13holidayrcc, $params_seAfter13holidayrcc);
            $result_seAfter13holidayrcc = sqlsrv_fetch_array($query_seAfter13holidayrcc, SQLSRV_FETCH_ASSOC);


            $sql_seBefore13holidaymondayrcc = "{call megHolidayEHR_v2(?,?,?,?)}";
            $params_seBefore13holidaymondayrcc = array(
                array('return_beforemondayrcc13', SQLSRV_PARAM_IN),
                array($result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
                array($result_seTenkoafter['TENKOAFTERDATE'], SQLSRV_PARAM_IN),
            );
            $query_seBefore13holidaymondayrcc = sqlsrv_query($conn, $sql_seBefore13holidaymondayrcc, $params_seBefore13holidaymondayrcc);
            $result_seBefore13holidaymondayrcc = sqlsrv_fetch_array($query_seBefore13holidaymondayrcc, SQLSRV_FETCH_ASSOC);

            $sql_seAfter13holidaymondayrcc = "{call megHolidayEHR_v2(?,?,?,?)}";
            $params_seAfter13holidaymondayrcc = array(
                array('return_aftermondayrcc13', SQLSRV_PARAM_IN),
                array($result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
                array($result_seTenkoafter['TENKOAFTERDATE'], SQLSRV_PARAM_IN),
            );
            $query_seAfter13holidaymondayrcc = sqlsrv_query($conn, $sql_seAfter13holidaymondayrcc, $params_seAfter13holidaymondayrcc);
            $result_seAfter13holidaymondayrcc = sqlsrv_fetch_array($query_seAfter13holidaymondayrcc, SQLSRV_FETCH_ASSOC);

            if ($result_seStartholidaymondayrcc['HOLIDAYWORK'] != '0') {
                if ($result_seBefore13holidaymondayrcc['HOLIDAYWORK'] != '0') {
                    $otbeforaffter = "540";
                } else if ($result_seAfter13holidaymondayrcc['HOLIDAYWORK'] != '0') {
                    $otbeforaffter = "720";
                }
            } else {
                if ($result_seBefore13holidayrcc['HOLIDAYWORK'] != '0') {
                    $otbeforaffter = "180";
                } else if ($result_seAfter13holidayrcc['HOLIDAYWORK'] != '0') {
                    $otbeforaffter = "360";
                }
            }

            if ($result_seStartholidayrcc['HOLIDAYWORK'] != '0') {
                if ((($E1 * 1.5)-$E1) == '0') {
                    editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'O2', '0');
                    $ot = '0';
                } else {
                    editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'O2', (($E1 * 1.5)-$E1) + ($otbeforaffter));
                    $ot = (($E1 * 1.5)-$E1) + ($otbeforaffter);
                }
            } else {
                editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'O2', ($E1-$E1) + ($otbeforaffter));
                $ot = ($E1-$E1) + ($otbeforaffter);
            }


            //editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'C5', $otbefor + $otbeform);
            //editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'C6', $otaffter + $otbeform);
        }
        if ($E1 == '' || $E1 == '0') {
            echo '0';
            editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'O2', '0');
        } else {
            echo $ot;
        }
    }
}

function updatevehicletransportplan_getwaye3($vehicletransportplanid, $E1) {
    $conn = connect("RTMS");
    $otbeforaffter = '';
    $ot = '';


    $condition = " AND a.VEHICLETRANSPORTPLANID = '" . $vehicletransportplanid . "'";
    $sql_seVehicletransportplan = "{call megVehicletransportplan_v2(?,?,?,?)}";
    $params_seVehicletransportplan = array(
        array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
        array($condition, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seVehicletransportplan = sqlsrv_query($conn, $sql_seVehicletransportplan, $params_seVehicletransportplan);
    $result_seVehicletransportplan = sqlsrv_fetch_array($query_seVehicletransportplan, SQLSRV_FETCH_ASSOC);
//echo $result_seVehicletransportplan['COMPANYCODE'];
    $condcompany2 = " AND Company_Code ='" . $result_seVehicletransportplan['COMPANYCODE'] . "'";
    $sql_seCompany2 = "{call megCompanyEHR_v2(?,?)}";
    $params_seCompany2 = array(
        array('select_company', SQLSRV_PARAM_IN),
        array($condcompany2, SQLSRV_PARAM_IN)
    );
    $query_seCompany2 = sqlsrv_query($conn, $sql_seCompany2, $params_seCompany2);
    $result_seCompany2 = sqlsrv_fetch_array($query_seCompany2, SQLSRV_FETCH_ASSOC);

    if ($result_seVehicletransportplan['COMPANYCODE'] == 'RRC') {
        $sql_seStartholidayrrc = "{call megHolidayEHR_v2(?,?,?,?)}";
        $params_seStartholidayrrc = array(
            array('start_holidayworkrrc', SQLSRV_PARAM_IN),
            array($result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
            array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
            array($result_seVehicletransportplan['DATEVLIN'], SQLSRV_PARAM_IN),
        );
        $query_seStartholidayrrc = sqlsrv_query($conn, $sql_seStartholidayrrc, $params_seStartholidayrrc);
        $result_seStartholidayrrc = sqlsrv_fetch_array($query_seStartholidayrrc, SQLSRV_FETCH_ASSOC);





        if ($result_seStartholidayrrc['HOLIDAYWORK'] != '0') {
            if ((($E1 * 1.5)-$E1) == '0') {
                editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'O3', '0');
                $ot = '0';
            } else {
                editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'O3', (($E1 * 1.5)-$E1));
                $ot = (($E1 * 1.5)-$E1);
            }
        } else {
            editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'O3', ($E1-$E1));
            $ot = ($E1-$E1);
        }
    } else {
        if ($result_seVehicletransportplan['COMPANYCODE'] == 'RCC' || $result_seVehicletransportplan['COMPANYCODE'] == 'RATC') {

            $sql_seStartholidayrcc = "{call megHolidayEHR_v2(?,?,?,?)}";
            $params_seStartholidayrcc = array(
                array('count_holiday', SQLSRV_PARAM_IN),
                array($result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
                array($result_seVehicletransportplan['DATERK'], SQLSRV_PARAM_IN),
            );
            $query_seStartholidayrcc = sqlsrv_query($conn, $sql_seStartholidayrcc, $params_seStartholidayrcc);
            $result_seStartholidayrcc = sqlsrv_fetch_array($query_seStartholidayrcc, SQLSRV_FETCH_ASSOC);
            
            $sql_seTenkoafter = "SELECT TOP 1 CONVERT(NVARCHAR(10),a.TENKOAFTERDATE,103) AS 'TENKOAFTERDATE' from [dbo].[TENKOAFTER] a
            INNER JOIN [dbo].[TENKOMASTER] b ON a.TENKOMASTERID = b.TENKOMASTERID
            WHERE b.VEHICLETRANSPORTPLANID = '".$result_seVehicletransportplan['VEHICLETRANSPORTPLANID']."'";
            $params_seTenkoafter = array();
            $query_seTenkoafter = sqlsrv_query($conn, $sql_seTenkoafter, $params_seTenkoafter);
            $result_seTenkoafter = sqlsrv_fetch_array($query_seTenkoafter, SQLSRV_FETCH_ASSOC);
            
            $sql_seStartholidaymondayrcc = "{call megHolidayEHR_v2(?,?,?,?)}";
            $params_seStartholidaymondayrcc = array(
                array('return_holidayworkrccmonday', SQLSRV_PARAM_IN),
                array($result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
                array($result_seTenkoafter['TENKOAFTERDATE'], SQLSRV_PARAM_IN),
            );
            $query_seStartholidaymondayrcc = sqlsrv_query($conn, $sql_seStartholidaymondayrcc, $params_seStartholidaymondayrcc);
            $result_seStartholidaymondayrcc = sqlsrv_fetch_array($query_seStartholidaymondayrcc, SQLSRV_FETCH_ASSOC);
            
            $sql_seBefore13holidayrcc = "{call megHolidayEHR_v2(?,?,?,?)}";
            $params_seBefore13holidayrcc = array(
                array('return_beforercc13', SQLSRV_PARAM_IN),
                array($result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
                array($result_seTenkoafter['TENKOAFTERDATE'], SQLSRV_PARAM_IN),
            );
            $query_seBefore13holidayrcc = sqlsrv_query($conn, $sql_seBefore13holidayrcc, $params_seBefore13holidayrcc);
            $result_seBefore13holidayrcc = sqlsrv_fetch_array($query_seBefore13holidayrcc, SQLSRV_FETCH_ASSOC);

            $sql_seAfter13holidayrcc = "{call megHolidayEHR_v2(?,?,?,?)}";
            $params_seAfter13holidayrcc = array(
                array('return_afterrcc13', SQLSRV_PARAM_IN),
                array($result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
                array($result_seTenkoafter['TENKOAFTERDATE'], SQLSRV_PARAM_IN),
            );
            $query_seAfter13holidayrcc = sqlsrv_query($conn, $sql_seAfter13holidayrcc, $params_seAfter13holidayrcc);
            $result_seAfter13holidayrcc = sqlsrv_fetch_array($query_seAfter13holidayrcc, SQLSRV_FETCH_ASSOC);


            $sql_seBefore13holidaymondayrcc = "{call megHolidayEHR_v2(?,?,?,?)}";
            $params_seBefore13holidaymondayrcc = array(
                array('return_beforemondayrcc13', SQLSRV_PARAM_IN),
                array($result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
                array($result_seTenkoafter['TENKOAFTERDATE'], SQLSRV_PARAM_IN),
            );
            $query_seBefore13holidaymondayrcc = sqlsrv_query($conn, $sql_seBefore13holidaymondayrcc, $params_seBefore13holidaymondayrcc);
            $result_seBefore13holidaymondayrcc = sqlsrv_fetch_array($query_seBefore13holidaymondayrcc, SQLSRV_FETCH_ASSOC);

            $sql_seAfter13holidaymondayrcc = "{call megHolidayEHR_v2(?,?,?,?)}";
            $params_seAfter13holidaymondayrcc = array(
                array('return_aftermondayrcc13', SQLSRV_PARAM_IN),
                array($result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
                array($result_seTenkoafter['TENKOAFTERDATE'], SQLSRV_PARAM_IN),
            );
            $query_seAfter13holidaymondayrcc = sqlsrv_query($conn, $sql_seAfter13holidaymondayrcc, $params_seAfter13holidaymondayrcc);
            $result_seAfter13holidaymondayrcc = sqlsrv_fetch_array($query_seAfter13holidaymondayrcc, SQLSRV_FETCH_ASSOC);

            if ($result_seStartholidaymondayrcc['HOLIDAYWORK'] != '0') {
                if ($result_seBefore13holidaymondayrcc['HOLIDAYWORK'] != '0') {
                    $otbeforaffter = "540";
                } else if ($result_seAfter13holidaymondayrcc['HOLIDAYWORK'] != '0') {
                    $otbeforaffter = "720";
                }
            } else {
                if ($result_seBefore13holidayrcc['HOLIDAYWORK'] != '0') {
                    $otbeforaffter = "180";
                } else if ($result_seAfter13holidayrcc['HOLIDAYWORK'] != '0') {
                    $otbeforaffter = "360";
                }
            }

            if ($result_seStartholidayrcc['HOLIDAYWORK'] != '0') {
                if ((($E1 * 1.5)-$E1) == '0') {
                    editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'O3', '0');
                    $ot = '0';
                } else {
                    editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'O3', (($E1 * 1.5)-$E1) + ($otbeforaffter));
                    $ot = (($E1 * 1.5)-$E1) + ($otbeforaffter);
                }
            } else {
                editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'O3', ($E1-$E1) + ($otbeforaffter));
                $ot = ($E1-$E1) + ($otbeforaffter);
            }


            //editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'C5', $otbefor + $otbeform);
            //editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'C6', $otaffter + $otbeform);
        }
        if ($E1 == '' || $E1 == '0') {
            echo '0';
            editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'O3', '0');
        } else {
            echo $ot;
        }
    }
}


function updatevehicletransportplan_stmtmttawtgt() {
    $compensation = "";
    $ot = "";
    $sum = "";
    $ap = "";
    $conn = connect("RTMS");
    $condition = " AND a.VEHICLETRANSPORTPLANID = (SELECT MAX(VEHICLETRANSPORTPLANID) FROM VEHICLETRANSPORTPLAN)";
    $sql_seVehicletransportplan = "{call megVehicletransportplan_v2(?,?,?,?)}";
    $params_seVehicletransportplan = array(
        array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
        array($condition, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seVehicletransportplan = sqlsrv_query($conn, $sql_seVehicletransportplan, $params_seVehicletransportplan);
    $result_seVehicletransportplan = sqlsrv_fetch_array($query_seVehicletransportplan, SQLSRV_FETCH_ASSOC);

    $condcompany = " AND Company_Code ='" . $result_seVehicletransportplan['COMPANYCODE'] . "'";
    $sql_seCompany = "{call megCompanyEHR_v2(?,?)}";
    $params_seCompany = array(
        array('select_company', SQLSRV_PARAM_IN),
        array($condcompany, SQLSRV_PARAM_IN)
    );
    $query_seCompany = sqlsrv_query($conn, $sql_seCompany, $params_seCompany);
    $result_seCompany = sqlsrv_fetch_array($query_seCompany, SQLSRV_FETCH_ASSOC);

    $sql_seStartholiday = "{call megHolidayEHR_v2(?,?,?,?)}";
    $params_seStartholiday = array(
        array('start_holidaywork', SQLSRV_PARAM_IN),
        array($result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
        array($result_seCompany['ID_Company'], SQLSRV_PARAM_IN),
        array($result_seVehicletransportplan['DATEVLIN'], SQLSRV_PARAM_IN),
    );
    $query_seStartholiday = sqlsrv_query($conn, $sql_seStartholiday, $params_seStartholiday);
    $result_seStartholiday = sqlsrv_fetch_array($query_seStartholiday, SQLSRV_FETCH_ASSOC);


    if ($result_seStartholiday['HOLIDAYWORK'] != '0') {
        $compensation = $result_seVehicletransportplan['E1'];
        $ot = $compensation;
        $sum = $compensation + $ot;
        $ap = '1000';
    } else {
        $compensation = $result_seVehicletransportplan['E1'];
        $ot = 0;
        $sum = $compensation + $ot;
        $ap = '0';
    }


    editVehicletransportdocumentplan('edit_vehicletransportdocumentplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'ACTUALPRICE', ceil($ap));
    editVehicletransportdocumentplan('edit_vehicletransportdocumentplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'COMPENSATION', ceil($compensation));
    editVehicletransportdocumentplan('edit_vehicletransportdocumentplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'OVERTIME', ceil($ot));


//editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'E2', $compensation);
    editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'O1', ceil($ot)); //OT
}

function updatevehicletransportplan_denso() {
    $compensation = "";
    $ot = "";
    $sum = "";
    $ap = "";
    $conn = connect("RTMS");
    $condition = " AND a.VEHICLETRANSPORTPLANID = (SELECT MAX(VEHICLETRANSPORTPLANID) FROM VEHICLETRANSPORTPLAN)";
    $sql_seVehicletransportplan = "{call megVehicletransportplan_v2(?,?,?,?)}";
    $params_seVehicletransportplan = array(
        array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
        array($condition, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seVehicletransportplan = sqlsrv_query($conn, $sql_seVehicletransportplan, $params_seVehicletransportplan);
    $result_seVehicletransportplan = sqlsrv_fetch_array($query_seVehicletransportplan, SQLSRV_FETCH_ASSOC);

    $condcompany = " AND Company_Code ='" . $result_seVehicletransportplan['COMPANYCODE'] . "'";
    $sql_seCompany = "{call megCompanyEHR_v2(?,?)}";
    $params_seCompany = array(
        array('select_company', SQLSRV_PARAM_IN),
        array($condcompany, SQLSRV_PARAM_IN)
    );
    $query_seCompany = sqlsrv_query($conn, $sql_seCompany, $params_seCompany);
    $result_seCompany = sqlsrv_fetch_array($query_seCompany, SQLSRV_FETCH_ASSOC);

    $sql_seStartholiday = "{call megHolidayEHR_v2(?,?,?,?)}";
    $params_seStartholiday = array(
        array('start_holidaywork', SQLSRV_PARAM_IN),
        array($result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
        array($result_seCompany['ID_Company'], SQLSRV_PARAM_IN),
        array($result_seVehicletransportplan['DATEVLIN'], SQLSRV_PARAM_IN),
    );
    $query_seStartholiday = sqlsrv_query($conn, $sql_seStartholiday, $params_seStartholiday);
    $result_seStartholiday = sqlsrv_fetch_array($query_seStartholiday, SQLSRV_FETCH_ASSOC);

    $query_e2 = sqlsrv_query($conn, "SELECT E1 FROM VEHICLETRANSPORTPLAN WHERE VEHICLETRANSPORTPLANID = '" . $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'] . "'", $params_e1);
    $result_e2 = sqlsrv_fetch_array($query_e2, SQLSRV_FETCH_ASSOC);
    $var_e2 = explode(",", $result_e2['E1']);

    if ($result_seVehicletransportplan['JOBSTART'] == 'SR' && $result_amtload['VEHICLETYPEAMOUNT'] == '4') {
        $compensation = $var_e2[0];
    }

    if ($result_seStartholiday['HOLIDAYWORK'] != '0') {
        $compensation = $compensation;
        $ot = $compensation;
        $sum = $compensation + $ot;
        $ap = '1000';
    } else {
        $compensation = $compensation;
        $ot = 0;
        $sum = $compensation + $ot;
        $ap = '0';
    }


    editVehicletransportdocumentplan('edit_vehicletransportdocumentplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'ACTUALPRICE', ceil($ap));
    editVehicletransportdocumentplan('edit_vehicletransportdocumentplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'COMPENSATION', ceil($compensation));
    editVehicletransportdocumentplan('edit_vehicletransportdocumentplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'OVERTIME', ceil($ot));

//if(substr($result_seVehicletransportplan['JOBSTART'], -3) == '(N)')
//{
//    editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'E1', $var_e2[1]);
//    editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'E2', $var_e2[1]);
//}
//else
//{
//    editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'E1', $var_e2[0]);
//    editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'E2', $var_e2[0]);
//}

    editVehicletransportplan('edit_vehicletransportplan', $result_seVehicletransportplan['VEHICLETRANSPORTPLANID'], 'O1', ceil($ot)); //OT
}

function convert($number) {
    $txtnum1 = array('ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า', 'สิบ');
    $txtnum2 = array('', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');
    $number = str_replace(",", "", $number);
    $number = str_replace(" ", "", $number);
    $number = str_replace("บาท", "", $number);
    $number = explode(".", $number);
    if (sizeof($number) > 2) {
        return 'ทศนิยมหลายตัวนะจ๊ะ';
        exit;
    }
    $strlen = strlen($number[0]);
    $convert = '';
    for ($i = 0; $i < $strlen; $i++) {
        $n = substr($number[0], $i, 1);
        if ($n != 0) {
            if ($i == ($strlen - 1) AND $n == 1) {
                $convert .= 'เอ็ด';
            } elseif ($i == ($strlen - 2) AND $n == 2) {
                $convert .= 'ยี่';
            } elseif ($i == ($strlen - 2) AND $n == 1) {
                $convert .= '';
            } else {
                $convert .= $txtnum1[$n];
            }
            $convert .= $txtnum2[$strlen - $i - 1];
        }
    }

    $convert .= 'บาท';
    if ($number[1] == '0' OR $number[1] == '00' OR
            $number[1] == '') {
        $convert .= 'ถ้วน';
    } else {
        $strlen = strlen($number[1]);
        for ($i = 0; $i < $strlen; $i++) {
            $n = substr($number[1], $i, 1);
            if ($n != 0) {
                if ($i == ($strlen - 1) AND $n == 1) {
                    $convert .= 'เอ็ด';
                } elseif ($i == ($strlen - 2) AND
                        $n == 2) {
                    $convert .= 'ยี่';
                } elseif ($i == ($strlen - 2) AND
                        $n == 1) {
                    $convert .= '';
                } else {
                    $convert .= $txtnum1[$n];
                }
                $convert .= $txtnum2[$strlen - $i - 1];
            }
        }
        $convert .= 'สตางค์';
    }
    return $convert;
}

function delMenu($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megMenu_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delConfrimskb($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megConfrimskb_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delConfrimtempskb($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megConfrimtempskb_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delVehicletransportdocumentdriver($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megVehicletransportdocumentdriver_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delVehicletransportdocumentdriverpallet($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportdocumentdriverpallet_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function select_jobautocomplate($STORED, $FLG, $CONDI) {
    $conn = connect("RTMS");
    $data = "";
    $sql = "{call " . $STORED . "(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDI, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    while ($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $data .= "'" . $result['BEGINJOB'] . "',";
    }
    return rtrim($data, ",");
}

function select_jobautocomplatestarttttsh($STORED, $FLG, $CONDI) {


    $data .= "'GW','BP','SR','OTH','TAC',";

    return rtrim($data, ",");
}

function select_jobautocomplatestartgetway($STORED, $FLG, $CONDI) {
    $conn = connect("RTMS");
    $data = "";
    $sql = "{call " . $STORED . "(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDI, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    while ($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $data .= "'" . $result['FROM'] . "',";
    }
    return rtrim($data, ",");
}

function select_jobautocomplateendgetway($STORED, $FLG, $CONDI) {
    $conn = connect("RTMS");
    $data = "";
    $sql = "{call " . $STORED . "(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDI, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    while ($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $data .= "'" . $result['TO'] . "',";
    }
    return rtrim($data, ",");
}

function select_jobautocomplatestartrks_denso($STORED, $FLG, $CONDI) {
    $conn = connect("RTMS");
    $data = "";
    $sql = "{call " . $STORED . "(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDI, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    while ($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $data .= "'" . $result['ROUTENO'] . "',";
    }
    return rtrim($data, ",");
}

function select_jobautocomplatestartrks_tgt($STORED, $FLG, $CONDI) {
    $conn = connect("RTMS");
    $data = "";
    $sql = "{call " . $STORED . "(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDI, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    while ($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $data .= "'" . $result['FROM'] . "',";
    }
    return rtrim($data, ",");
}

function select_jobautocomplateendrks_denso($STORED, $FLG, $CONDI) {
    $conn = connect("RTMS");
    $data = "";
    $sql = "{call " . $STORED . "(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDI, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    while ($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $data .= "'" . $result['ROUTETYPE'] . "',";
    }
    return rtrim($data, ",");
}

function select_empautocomplate($STORED, $FLG, $CONDI) {
    $conn = connect("RTMS");
    $data = "";
    $sql = "{call " . $STORED . "(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDI, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    while ($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $data .= "'" . $result['nameT'] . "',";
    }
    return rtrim($data, ",");
}

function select_carautocomplate($STORED, $FLG, $CONDI1, $CONDI2, $CONDI3, $CONDI4) {
    $conn = connect("RTMS");
    $data = "";
    $sql = "{call " . $STORED . "(?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDI1, SQLSRV_PARAM_IN),
        array($CONDI2, SQLSRV_PARAM_IN),
        array($CONDI3, SQLSRV_PARAM_IN),
        array($CONDI4, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    while ($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $data .= "'" . $result['THAINAME'] . "',";
    }
    return rtrim($data, ",");
}

function select_vehiclenumberautocomplate($STORED, $FLG, $CONDI) {
    $conn = connect("RTMS");
    $data = "";
    $sql = "{call " . $STORED . "(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDI, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    while ($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $data .= "'" . $result['VEHICLEREGISNUMBER'] . "',";
    }
    return rtrim($data, ",");
}

function select_clusterautocomplate($STORED, $FLG, $CONDI) {
    $conn = connect("RTMS");
    $data = "";
    $sql = "{call " . $STORED . "(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDI, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    while ($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $data .= "'" . $result['CLUSTER'] . "',";
    }
    return rtrim($data, ",");
}

function select_carnameautocomplate($STORED, $FLG, $CONDI) {
    $conn = connect("RTMS");
    $data = "";
    $sql = "{call " . $STORED . "(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDI, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    while ($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $data .= "'" . $result['THAINAME'] . "',";
    }
    return rtrim($data, ",");
}

function dateCheck($datepresent, $day, $time1, $time2) {
    $conn = connect("RTMS");
    $sql_seDatecheck = "{call megVehicletransportplanreport_v2(?,?,?,?,?,?)}";
    $params_seDatecheck = array(
        array("check_date", SQLSRV_PARAM_IN),
        array("", SQLSRV_PARAM_IN),
        array($datepresent, SQLSRV_PARAM_IN),
        array($day, SQLSRV_PARAM_IN),
        array($time1, SQLSRV_PARAM_IN),
        array($time2, SQLSRV_PARAM_IN)
    );
    $query_seDatecheck = sqlsrv_query($conn, $sql_seDatecheck, $params_seDatecheck);
    $result_seDatecheck = sqlsrv_fetch_array($query_seDatecheck, SQLSRV_FETCH_ASSOC);
    return $result_seDatecheck['CHKCOUNT'];
}

function deleteSelect($FLG, $LOGSELECT) {
    $conn = connect("RTMS");
    $sql = "{call megLogselect_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($LOGSELECT, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delLogselect($FLG, $LOGSELECT, $EMPLOYEECODE) {
    $conn = connect("RTMS");
    $sql = "{call megLogselect_v2(?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($LOGSELECT, SQLSRV_PARAM_IN),
        array($EMPLOYEECODE, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delIogbillinginvoice($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megLogbillinginvoice_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delOilprice($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megOilprice_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delOilaverage($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megOilaverage_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delInvoincepallet($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megLoginvoice_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delInvoince($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megLoginvoice_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delBilling($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megLogbilling_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delVehicleinfo($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megVehicleinfo_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delRoleaccount($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megRoleaccount_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delRole($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megRole_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delRolemenu($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megRolemenu_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delSubmenu($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megSubmenu_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delStopwork($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megStopwork_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delRepair($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megRepair_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delTenko($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megTenko_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delVehiclechangehistory($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megVehiclechangehistory_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function updUpdateworkcheckin($CONDITION1, $CONDITION2) {
    $conn = connect("RTMS");
    $sql = "{call megWorkcheckin_v2(?,?,?)}";
    $params = array(
        array('update_workcheckin', SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($CONDITION2, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delVehicleinsured($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megVehicleinsured_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delVehiclemaintenance($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megVehiclemaintenance_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delVehiclerepair($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megVehiclerepair_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delVehicletax($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megVehicletax_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delVehicleowner($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megVehicleowner_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delVehiclepurchase($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megVehiclepurchase_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delVehicleattribute($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megVehicleattribute_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delWarningdata($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megWarningdata_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function copyVehicletransportdocumentdriver($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportdocumentdriver_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function copyVehicletransportdocumentdriverpallet($FLG, $CONDITION1, $FIELDNAME) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportdocumentdriverpallet_v2(?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delVehicletransportdocument($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megVehicletransportdocument_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delVehicletransportplanrksstm($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megVehicletransportplan_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delVehicletransportplan($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megVehicletransportplan_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function updStatusjob($FLG) {
    $conn = connect("RTMS");
    $sql = "{call megEmployee3_v2(?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editTenkobeforepast(
        $FLG, 
        $ID,
        $TENKOBEFOREGREETCHECK,
        $TENKOUNIFORMCHECK,
        $TENKOBODYCHECK,
        
        $TENKORESTCHECK,
        $TENKOSLEEPTIMECHECK,
        $TENKOTEMPERATURECHECK,
        $TENKOPRESSURECHECK,
        $TENKOALCOHOLCHECK,
        
        $TENKOWORRYCHECK,
        $TENKODAILYTRAILERCHECK,
        $TENKOCARRYCHECK,
        $TENKOJOBDETAILCHECK,
        $TENKOLOADINFORMCHECK,
        
        $TENKOAIRINFORMCHECK,
        $TENKOYOKOTENCHECK,
        $TENKOCHIMOLATORCHECK,
        $TENKOTRANSPORTCHECK,
        $TENKOAFTERGREETCHECK,
        
        $TENKOOXYGENCHECK,
        $TENKOBEFOREGREETRESULT,
        $TENKOUNIFORMRESULT,
        $TENKOBODYRESULT,
        $TENKORESTRESULT,
        
        $TENKOSLEEPTIMERESULT,
        $TENKOTEMPERATURERESULT,
        $TENKOPRESSURERESULT,
        $TENKOALCOHOLRESULT,
        $TENKOWORRYRESULT,
        
        $TENKODAILYTRAILERRESULT,
        $TENKOCARRYRESULT,
        $TENKOJOBDETAILRESULT,
        $TENKOLOADINFORMRESULT,
        $TENKOAIRINFORMRESULT,
        
        $TENKOYOKOTENRESULT,
        $TENKOCHIMOLATORRESULT,
        $TENKOTRANSPORTRESULT,
        $TENKOAFTERGREETRESULT,
        $TENKOOXYGENRESULT,
        
        $TENKOBEFOREGREETREMARK,
        $TENKOUNIFORMREMARK,
        $TENKOBODYREMARK,
        $TENKORESTREMARK,
        $TENKOSLEEPTIMEREMARK,
        
        $TENKOTEMPERATUREREMARK,
        $TENKOPRESSUREREMARK,
        $TENKOALCOHOLREMARK,
        $TENKOWORRYREMARK,
        $TENKODAILYTRAILERREMARK,
        
        $TENKOCARRYREMARK,
        $TENKOJOBDETAILREMARK,
        $TENKOLOADINFORMREMARK,
        $TENKOAIRINFORMREMARK,
        $TENKOYOKOTENREMARK,
        
        $TENKOCHIMOLATORREMARK,
        $TENKOTRANSPORTREMARK,
        $TENKOAFTERGREETREMARK,
        $TENKOOXYGENREMARK,
        $TENKORESTDATA,
        
        $TENKOSLEEPTIMEDATA_AFTER6H,
        $TENKOSLEEPTIMEDATA_ADD45H,
        $TENKOTEMPERATUREDATA,
        $TENKOPRESSUREDATA_90160,
        $TENKOPRESSUREDATA_90160_2,
        
        $TENKOPRESSUREDATA_90160_3,
        $TENKOPRESSUREDATA_60100,
        $TENKOPRESSUREDATA_60100_2,
        $TENKOPRESSUREDATA_60100_3,
        $TENKOPRESSUREDATA_60110,
        
        $TENKOPRESSUREDATA_60110_2,
        $TENKOPRESSUREDATA_60110_3,
        $TENKOALCOHOLDATA,
        $TENKOOXYGENDATA,
        $MODIFIEDBY,
        $TENKOMASTERDIRVERCODE,
        $TENKOMASTERDIRVERNAME,
        $TENKOBEFOREDATE
        ) {
    $conn = connect("RTMS");
    $sql = "{call megEdittenkobeforepast_v2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($ID, SQLSRV_PARAM_IN),
        array($TENKOBEFOREGREETCHECK, SQLSRV_PARAM_IN),
        array($TENKOUNIFORMCHECK, SQLSRV_PARAM_IN),
        array($TENKOBODYCHECK, SQLSRV_PARAM_IN),
        
        array($TENKORESTCHECK, SQLSRV_PARAM_IN),
        array($TENKOSLEEPTIMECHECK, SQLSRV_PARAM_IN),
        array($TENKOTEMPERATURECHECK, SQLSRV_PARAM_IN),
        array($TENKOPRESSURECHECK, SQLSRV_PARAM_IN),
        array($TENKOALCOHOLCHECK, SQLSRV_PARAM_IN),
        
        array($TENKOWORRYCHECK, SQLSRV_PARAM_IN),
        array($TENKODAILYTRAILERCHECK, SQLSRV_PARAM_IN),
        array($TENKOCARRYCHECK, SQLSRV_PARAM_IN),
        array($TENKOJOBDETAILCHECK, SQLSRV_PARAM_IN),
        array($TENKOLOADINFORMCHECK, SQLSRV_PARAM_IN),
        
        array($TENKOAIRINFORMCHECK, SQLSRV_PARAM_IN),
        array($TENKOYOKOTENCHECK, SQLSRV_PARAM_IN),
        array($TENKOCHIMOLATORCHECK, SQLSRV_PARAM_IN),
        array($TENKOTRANSPORTCHECK, SQLSRV_PARAM_IN),
        array($TENKOAFTERGREETCHECK, SQLSRV_PARAM_IN),
        
        array($TENKOOXYGENCHECK, SQLSRV_PARAM_IN),
        array($TENKOBEFOREGREETRESULT, SQLSRV_PARAM_IN),
        array($TENKOUNIFORMRESULT, SQLSRV_PARAM_IN),
        array($TENKOBODYRESULT, SQLSRV_PARAM_IN),
        array($TENKORESTRESULT, SQLSRV_PARAM_IN),
        
        array($TENKOSLEEPTIMERESULT, SQLSRV_PARAM_IN),
        array($TENKOTEMPERATURERESULT, SQLSRV_PARAM_IN),
        array($TENKOPRESSURERESULT, SQLSRV_PARAM_IN),
        array($TENKOALCOHOLRESULT, SQLSRV_PARAM_IN),
        array($TENKOWORRYRESULT, SQLSRV_PARAM_IN),
        
        array($TENKODAILYTRAILERRESULT, SQLSRV_PARAM_IN),
        array($TENKOCARRYRESULT, SQLSRV_PARAM_IN),
        array($TENKOJOBDETAILRESULT, SQLSRV_PARAM_IN),
        array($TENKOLOADINFORMRESULT, SQLSRV_PARAM_IN),
        array($TENKOAIRINFORMRESULT, SQLSRV_PARAM_IN),
        
        array($TENKOYOKOTENRESULT, SQLSRV_PARAM_IN),
        array($TENKOCHIMOLATORRESULT, SQLSRV_PARAM_IN),
        array($TENKOTRANSPORTRESULT, SQLSRV_PARAM_IN),
        array($TENKOAFTERGREETRESULT, SQLSRV_PARAM_IN),
        array($TENKOOXYGENRESULT, SQLSRV_PARAM_IN),
        
        array($TENKOBEFOREGREETREMARK, SQLSRV_PARAM_IN),
        array($TENKOUNIFORMREMARK, SQLSRV_PARAM_IN),
        array($TENKOBODYREMARK, SQLSRV_PARAM_IN),
        array($TENKORESTREMARK, SQLSRV_PARAM_IN),
        array($TENKOSLEEPTIMEREMARK, SQLSRV_PARAM_IN),
        
        array($TENKOTEMPERATUREREMARK, SQLSRV_PARAM_IN),
        array($TENKOPRESSUREREMARK, SQLSRV_PARAM_IN),
        array($TENKOALCOHOLREMARK, SQLSRV_PARAM_IN),
        array($TENKOWORRYREMARK, SQLSRV_PARAM_IN),
        array($TENKODAILYTRAILERREMARK, SQLSRV_PARAM_IN),
        
        array($TENKOCARRYREMARK, SQLSRV_PARAM_IN),
        array($TENKOJOBDETAILREMARK, SQLSRV_PARAM_IN),
        array($TENKOLOADINFORMREMARK, SQLSRV_PARAM_IN),
        array($TENKOAIRINFORMREMARK, SQLSRV_PARAM_IN),
        array($TENKOYOKOTENREMARK, SQLSRV_PARAM_IN),
        
        array($TENKOCHIMOLATORREMARK, SQLSRV_PARAM_IN),
        array($TENKOTRANSPORTREMARK, SQLSRV_PARAM_IN),
        array($TENKOAFTERGREETREMARK, SQLSRV_PARAM_IN),
        array($TENKOOXYGENREMARK, SQLSRV_PARAM_IN),
        array($TENKORESTDATA, SQLSRV_PARAM_IN),
        
        array($TENKOSLEEPTIMEDATA_AFTER6H, SQLSRV_PARAM_IN),
        array($TENKOSLEEPTIMEDATA_ADD45H, SQLSRV_PARAM_IN),
        array($TENKOTEMPERATUREDATA, SQLSRV_PARAM_IN),
        array($TENKOPRESSUREDATA_90160, SQLSRV_PARAM_IN),
        array($TENKOPRESSUREDATA_90160_2, SQLSRV_PARAM_IN),
        
        array($TENKOPRESSUREDATA_90160_3, SQLSRV_PARAM_IN),
        array($TENKOPRESSUREDATA_60100, SQLSRV_PARAM_IN),
        array($TENKOPRESSUREDATA_60100_2, SQLSRV_PARAM_IN),
        array($TENKOPRESSUREDATA_60100_3, SQLSRV_PARAM_IN),
        array($TENKOPRESSUREDATA_60110, SQLSRV_PARAM_IN),
        
        array($TENKOPRESSUREDATA_60110_2, SQLSRV_PARAM_IN),
        array($TENKOPRESSUREDATA_60110_3, SQLSRV_PARAM_IN),
        array($TENKOALCOHOLDATA, SQLSRV_PARAM_IN),
        array($TENKOOXYGENDATA, SQLSRV_PARAM_IN),
        array($MODIFIEDBY, SQLSRV_PARAM_IN),
        array($TENKOMASTERDIRVERCODE, SQLSRV_PARAM_IN),
        array($TENKOMASTERDIRVERNAME, SQLSRV_PARAM_IN),
        array($TENKOBEFOREDATE, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}
function editTenkobefore2(
        $FLG, 
        $ID,
        $TENKOBEFOREGREETCHECK,
        $TENKOUNIFORMCHECK,
        $TENKOBODYCHECK,
        
        $TENKORESTCHECK,
        $TENKOSLEEPTIMECHECK,
        $TENKOTEMPERATURECHECK,
        $TENKOPRESSURECHECK,
        $TENKOALCOHOLCHECK,
        
        $TENKOWORRYCHECK,
        $TENKODAILYTRAILERCHECK,
        $TENKOCARRYCHECK,
        $TENKOJOBDETAILCHECK,
        $TENKOLOADINFORMCHECK,
        
        $TENKOAIRINFORMCHECK,
        $TENKOYOKOTENCHECK,
        $TENKOCHIMOLATORCHECK,
        $TENKOTRANSPORTCHECK,
        $TENKOAFTERGREETCHECK,
        
        $TENKOOXYGENCHECK,
        $TENKOBEFOREGREETRESULT,
        $TENKOUNIFORMRESULT,
        $TENKOBODYRESULT,
        $TENKORESTRESULT,
        
        $TENKOSLEEPTIMERESULT,
        $TENKOTEMPERATURERESULT,
        $TENKOPRESSURERESULT,
        $TENKOALCOHOLRESULT,
        $TENKOWORRYRESULT,
        
        $TENKODAILYTRAILERRESULT,
        $TENKOCARRYRESULT,
        $TENKOJOBDETAILRESULT,
        $TENKOLOADINFORMRESULT,
        $TENKOAIRINFORMRESULT,
        
        $TENKOYOKOTENRESULT,
        $TENKOCHIMOLATORRESULT,
        $TENKOTRANSPORTRESULT,
        $TENKOAFTERGREETRESULT,
        $TENKOOXYGENRESULT,
        
        $TENKOBEFOREGREETREMARK,
        $TENKOUNIFORMREMARK,
        $TENKOBODYREMARK,
        $TENKORESTREMARK,
        $TENKOSLEEPTIMEREMARK,
        
        $TENKOTEMPERATUREREMARK,
        $TENKOPRESSUREREMARK,
        $TENKOALCOHOLREMARK,
        $TENKOWORRYREMARK,
        $TENKODAILYTRAILERREMARK,
        
        $TENKOCARRYREMARK,
        $TENKOJOBDETAILREMARK,
        $TENKOLOADINFORMREMARK,
        $TENKOAIRINFORMREMARK,
        $TENKOYOKOTENREMARK,
        
        $TENKOCHIMOLATORREMARK,
        $TENKOTRANSPORTREMARK,
        $TENKOAFTERGREETREMARK,
        $TENKOOXYGENREMARK,
        $TENKORESTDATA,
        
        $TENKOSLEEPTIMEDATA_AFTER6H,
        $TENKOSLEEPTIMEDATA_ADD45H,
        $TENKOTEMPERATUREDATA,
        $TENKOPRESSUREDATA_90160,
        $TENKOPRESSUREDATA_90160_2,
        
        $TENKOPRESSUREDATA_90160_3,
        $TENKOPRESSUREDATA_60100,
        $TENKOPRESSUREDATA_60100_2,
        $TENKOPRESSUREDATA_60100_3,
        $TENKOPRESSUREDATA_60110,
        
        $TENKOPRESSUREDATA_60110_2,
        $TENKOPRESSUREDATA_60110_3,
        $TENKOALCOHOLDATA,
        $TENKOOXYGENDATA,
        $MODIFIEDBY,
        $TENKOMASTERDIRVERCODE,
        $TENKOMASTERDIRVERNAME
        ) {
    $conn = connect("RTMS");
    $sql = "{call megEdittenkobefore2_v2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($ID, SQLSRV_PARAM_IN),
        array($TENKOBEFOREGREETCHECK, SQLSRV_PARAM_IN),
        array($TENKOUNIFORMCHECK, SQLSRV_PARAM_IN),
        array($TENKOBODYCHECK, SQLSRV_PARAM_IN),
        
        array($TENKORESTCHECK, SQLSRV_PARAM_IN),
        array($TENKOSLEEPTIMECHECK, SQLSRV_PARAM_IN),
        array($TENKOTEMPERATURECHECK, SQLSRV_PARAM_IN),
        array($TENKOPRESSURECHECK, SQLSRV_PARAM_IN),
        array($TENKOALCOHOLCHECK, SQLSRV_PARAM_IN),
        
        array($TENKOWORRYCHECK, SQLSRV_PARAM_IN),
        array($TENKODAILYTRAILERCHECK, SQLSRV_PARAM_IN),
        array($TENKOCARRYCHECK, SQLSRV_PARAM_IN),
        array($TENKOJOBDETAILCHECK, SQLSRV_PARAM_IN),
        array($TENKOLOADINFORMCHECK, SQLSRV_PARAM_IN),
        
        array($TENKOAIRINFORMCHECK, SQLSRV_PARAM_IN),
        array($TENKOYOKOTENCHECK, SQLSRV_PARAM_IN),
        array($TENKOCHIMOLATORCHECK, SQLSRV_PARAM_IN),
        array($TENKOTRANSPORTCHECK, SQLSRV_PARAM_IN),
        array($TENKOAFTERGREETCHECK, SQLSRV_PARAM_IN),
        
        array($TENKOOXYGENCHECK, SQLSRV_PARAM_IN),
        array($TENKOBEFOREGREETRESULT, SQLSRV_PARAM_IN),
        array($TENKOUNIFORMRESULT, SQLSRV_PARAM_IN),
        array($TENKOBODYRESULT, SQLSRV_PARAM_IN),
        array($TENKORESTRESULT, SQLSRV_PARAM_IN),
        
        array($TENKOSLEEPTIMERESULT, SQLSRV_PARAM_IN),
        array($TENKOTEMPERATURERESULT, SQLSRV_PARAM_IN),
        array($TENKOPRESSURERESULT, SQLSRV_PARAM_IN),
        array($TENKOALCOHOLRESULT, SQLSRV_PARAM_IN),
        array($TENKOWORRYRESULT, SQLSRV_PARAM_IN),
        
        array($TENKODAILYTRAILERRESULT, SQLSRV_PARAM_IN),
        array($TENKOCARRYRESULT, SQLSRV_PARAM_IN),
        array($TENKOJOBDETAILRESULT, SQLSRV_PARAM_IN),
        array($TENKOLOADINFORMRESULT, SQLSRV_PARAM_IN),
        array($TENKOAIRINFORMRESULT, SQLSRV_PARAM_IN),
        
        array($TENKOYOKOTENRESULT, SQLSRV_PARAM_IN),
        array($TENKOCHIMOLATORRESULT, SQLSRV_PARAM_IN),
        array($TENKOTRANSPORTRESULT, SQLSRV_PARAM_IN),
        array($TENKOAFTERGREETRESULT, SQLSRV_PARAM_IN),
        array($TENKOOXYGENRESULT, SQLSRV_PARAM_IN),
        
        array($TENKOBEFOREGREETREMARK, SQLSRV_PARAM_IN),
        array($TENKOUNIFORMREMARK, SQLSRV_PARAM_IN),
        array($TENKOBODYREMARK, SQLSRV_PARAM_IN),
        array($TENKORESTREMARK, SQLSRV_PARAM_IN),
        array($TENKOSLEEPTIMEREMARK, SQLSRV_PARAM_IN),
        
        array($TENKOTEMPERATUREREMARK, SQLSRV_PARAM_IN),
        array($TENKOPRESSUREREMARK, SQLSRV_PARAM_IN),
        array($TENKOALCOHOLREMARK, SQLSRV_PARAM_IN),
        array($TENKOWORRYREMARK, SQLSRV_PARAM_IN),
        array($TENKODAILYTRAILERREMARK, SQLSRV_PARAM_IN),
        
        array($TENKOCARRYREMARK, SQLSRV_PARAM_IN),
        array($TENKOJOBDETAILREMARK, SQLSRV_PARAM_IN),
        array($TENKOLOADINFORMREMARK, SQLSRV_PARAM_IN),
        array($TENKOAIRINFORMREMARK, SQLSRV_PARAM_IN),
        array($TENKOYOKOTENREMARK, SQLSRV_PARAM_IN),
        
        array($TENKOCHIMOLATORREMARK, SQLSRV_PARAM_IN),
        array($TENKOTRANSPORTREMARK, SQLSRV_PARAM_IN),
        array($TENKOAFTERGREETREMARK, SQLSRV_PARAM_IN),
        array($TENKOOXYGENREMARK, SQLSRV_PARAM_IN),
        array($TENKORESTDATA, SQLSRV_PARAM_IN),
        
        array($TENKOSLEEPTIMEDATA_AFTER6H, SQLSRV_PARAM_IN),
        array($TENKOSLEEPTIMEDATA_ADD45H, SQLSRV_PARAM_IN),
        array($TENKOTEMPERATUREDATA, SQLSRV_PARAM_IN),
        array($TENKOPRESSUREDATA_90160, SQLSRV_PARAM_IN),
        array($TENKOPRESSUREDATA_90160_2, SQLSRV_PARAM_IN),
        
        array($TENKOPRESSUREDATA_90160_3, SQLSRV_PARAM_IN),
        array($TENKOPRESSUREDATA_60100, SQLSRV_PARAM_IN),
        array($TENKOPRESSUREDATA_60100_2, SQLSRV_PARAM_IN),
        array($TENKOPRESSUREDATA_60100_3, SQLSRV_PARAM_IN),
        array($TENKOPRESSUREDATA_60110, SQLSRV_PARAM_IN),
        
        array($TENKOPRESSUREDATA_60110_2, SQLSRV_PARAM_IN),
        array($TENKOPRESSUREDATA_60110_3, SQLSRV_PARAM_IN),
        array($TENKOALCOHOLDATA, SQLSRV_PARAM_IN),
        array($TENKOOXYGENDATA, SQLSRV_PARAM_IN),
        array($MODIFIEDBY, SQLSRV_PARAM_IN),
        array($TENKOMASTERDIRVERCODE, SQLSRV_PARAM_IN),
        array($TENKOMASTERDIRVERNAME, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}
function delVehicletransportprice($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megVehicletransportprice_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delVehicletransportpriceavgkm($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megVehicletransportpriceavgkm_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editDatevehicletransportplan($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ) {
    $conn = connect("RTMS");
    $sql = "{call megEditdatevehicletransportplan_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportplanjobstm($FLG, $CONDITION1, $CUSTOMERCODE) {
    $conn = connect("RTMS");
    $sql = "{call megVehicletransportplan_v2(?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($CUSTOMERCODE, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportplanjob($FLG, $CONDITION1, $STATUSNUMBER) {
    $conn = connect("RTMS");
    $sql = "{call megVehicletransportplan_v2(?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($STATUSNUMBER, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportjobendtemp($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ, $VEHICLETRANSPORTPLANID) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportjobendtemp_v2(?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN),
        array($VEHICLETRANSPORTPLANID, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);

    $rs1 = '';
    $CONDITION2 = " AND VEHICLETRANSPORTPLANID = '" . $VEHICLETRANSPORTPLANID . "' AND ACTIVESTATUS = '1'";
    $sql1 = "{call megVehicletransportjobendtemp_v2(?,?)}";
    $params1 = array(
        array('select_vehicletransportjobendtemp', SQLSRV_PARAM_IN),
        array($CONDITION2, SQLSRV_PARAM_IN)
    );
    $query1 = sqlsrv_query($conn, $sql1, $params1);
    while ($result1 = sqlsrv_fetch_array($query1, SQLSRV_FETCH_ASSOC)) {
        $rs1 .= $result1['JOBEND'] . ',';
    }


    $sql2 = "{call megEditvehicletransportplan_v2(?,?,?,?)}";
    $params2 = array(
        array('edit_vehicletransportplanjobend', SQLSRV_PARAM_IN),
        array($VEHICLETRANSPORTPLANID, SQLSRV_PARAM_IN),
        array('JOBEND', SQLSRV_PARAM_IN),
        array($rs1, SQLSRV_PARAM_IN)
    );
    sqlsrv_query($conn, $sql2, $params2);

    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportdocumentdriverconfrim($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportdocumentdriverconfrim_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportdocumentdriver($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ, $JOBSTART, $JOBEND, $LOCATION, $DOCUMENTCODE, $MODIFIEDBY) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportdocumentdriver_v2(?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN),
        array($JOBSTART, SQLSRV_PARAM_IN),
        array($JOBEND, SQLSRV_PARAM_IN),
        array($LOCATION, SQLSRV_PARAM_IN),
        array($DOCUMENTCODE, SQLSRV_PARAM_IN),
        array($MODIFIEDBY, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportdocumentdriverpallet($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ, $MODIFIEDBY) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportdocumentdriverpallet_v2(?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN),
        array($MODIFIEDBY, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportdocumentdriverdoc($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportdocumentdriver_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportdocumentplan($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportdocumentdriver_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportdocument($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportdocument_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportdocumentdrivergetway($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ, $VEHICLETRANSPORTPLANID, $COMPANYCODE, $EMPLOYEECODE, $EMPLOYEENAME) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportdocumentdrivergetway_v2(?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN),
        array($VEHICLETRANSPORTPLANID, SQLSRV_PARAM_IN),
        array($COMPANYCODE, SQLSRV_PARAM_IN),
        array($EMPLOYEECODE, SQLSRV_PARAM_IN),
        array($EMPLOYEENAME, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportdocumentdrivergetway1($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportdocumentdrivergetway_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportplanrksstm($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ, $ROUNDAMOUNT) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportplanrksstm_v2(?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN),
        array($ROUNDAMOUNT, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportplan($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportplan_v2(?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);

    $sql2 = "{call megEditvehicletransportplan_v2(?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params2 = array(
        array('edit_vehicletransportplanttaststc', SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query2 = sqlsrv_query($conn, $sql2, $params2);
    $result2 = sqlsrv_fetch_array($query2, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportplanconfrim($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportplan_v2(?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function Addtransportpricemaster($FLG, $CONDITION1, $CONDITION2, $CONDITION3, $VEHICLEDESCCODE, $WORKTYPE, $COMPANYCODE, $CUSTOMERCODE, $ACTIVESTATUS, $DATA_1, $DATA_2, $DATA_3, $DATA_4, $DATA_5) {
    $conn = connect("RTMS");
    $sql = "{call megVehicletransportpricemaster_v2(?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($CONDITION2, SQLSRV_PARAM_IN),
        array($CONDITION3, SQLSRV_PARAM_IN),
        array($VEHICLEDESCCODE, SQLSRV_PARAM_IN),
        array($WORKTYPE, SQLSRV_PARAM_IN),
        array($COMPANYCODE, SQLSRV_PARAM_IN),
        array($CUSTOMERCODE, SQLSRV_PARAM_IN),
        array($ACTIVESTATUS, SQLSRV_PARAM_IN),
        array($DATA_1, SQLSRV_PARAM_IN),
        array($DATA_2, SQLSRV_PARAM_IN),
        array($DATA_3, SQLSRV_PARAM_IN),
        array($DATA_4, SQLSRV_PARAM_IN),
        array($DATA_5, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function Copytransportprice($FLG, $CONDITION1, $CONDITION2, $CONDITION3, $COMPANYCODE, $CUSTOMERCODE, $WORKTYPE, $DATESTART, $DATEEND) {
    $conn = connect("RTMS");
    $sql = "{call megVehicletransportpricecopyprice_v2(?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($CONDITION2, SQLSRV_PARAM_IN),
        array($CONDITION3, SQLSRV_PARAM_IN),
        array($COMPANYCODE, SQLSRV_PARAM_IN),
        array($CUSTOMERCODE, SQLSRV_PARAM_IN),
        array($WORKTYPE, SQLSRV_PARAM_IN),
        array($DATESTART, SQLSRV_PARAM_IN),
        array($DATEEND, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function updMapaddress($FLG, $CONDITION1, $CONDITION2) {
    $conn = connect("RTMS");
    $sql = "{call megWorkcheckin_v2(?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($CONDITION2, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insWorkcheckin($FLG, $CONDITION1, $CONDITION2, $CONDITION3, $EMPLOYEECODE, $LATIUDE, $LONGITUDE, $PATHNAME, $BEFOREACTIVITY) {
    $conn = connect("RTMS");

    $sql = "{call megWorkcheckin_v2(?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($CONDITION2, SQLSRV_PARAM_IN),
        array($CONDITION3, SQLSRV_PARAM_IN),
        array($EMPLOYEECODE, SQLSRV_PARAM_IN),
        array($LATIUDE, SQLSRV_PARAM_IN),
        array($LONGITUDE, SQLSRV_PARAM_IN),
        array($PATHNAME, SQLSRV_PARAM_IN),
        array($BEFOREACTIVITY, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);

    sqlsrv_close($conn);
    return $result['RS'];
}

function insOilprice($FLG, $CONDITION1, $CONDITION2, $CONDITION3, $COMPANYCODE, $YEAR, $MONT, $PRICE, $REMARK) {
    $conn = connect("RTMS");
    $sql = "{call megOilprice_v2(?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($CONDITION2, SQLSRV_PARAM_IN),
        array($CONDITION3, SQLSRV_PARAM_IN),
        array($COMPANYCODE, SQLSRV_PARAM_IN),
        array($YEAR, SQLSRV_PARAM_IN),
        array($MONT, SQLSRV_PARAM_IN),
        array($PRICE, SQLSRV_PARAM_IN),
        array($REMARK, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insOilaverage($FLG, $CONDITION1, $CONDITION2, $CONDITION3, $COMPANYCODE, $CUSTOMERCODE, $VEHICLETYPE, $LOCATION, $OILAVERAGE, $REMARK) {
    $conn = connect("RTMS");
    $sql = "{call megOilaverage_v2(?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($CONDITION2, SQLSRV_PARAM_IN),
        array($CONDITION3, SQLSRV_PARAM_IN),
        array($COMPANYCODE, SQLSRV_PARAM_IN),
        array($CUSTOMERCODE, SQLSRV_PARAM_IN),
        array($VEHICLETYPE, SQLSRV_PARAM_IN),
        array($LOCATION, SQLSRV_PARAM_IN),
        array($OILAVERAGE, SQLSRV_PARAM_IN),
        array($REMARK, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function updConfrimjob($FLG, $CONDITION1, $EDITTABLEOBJ) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportplan_densodis_v2(?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function dropTempweightin($FLG) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportdocumentdriver_v2(?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function updTenkomaster1($FLG, $CONDITION1, $VEHICLETRANSPORTPLANID) {
    $conn = connect("RTMS");
    $sql = "{call megEdittenkomaster_v2(?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($VEHICLETRANSPORTPLANID, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function updTenkomaster($FLG, $CONDITION1, $VEHICLETRANSPORTPLANID, $TENKOMASTERKA, $TENKOMASTERSTATUS, $TENKOMASTERREMARK1, $TENKOMASTERREMARK2, $VEHICLEREGISNUMBER, $JOBSTART, $JOBEND1, $JOBEND2, $DAYONE, $TENKOTARGET1, $TENKOTARGET2, $TENKOTARGET3, $TENKOTARGET4, $TENKOTARGET5, $TENKOTARGET6, $TENKOTARGET7) {
    $conn = connect("RTMS");
    $sql = "{call megEdittenkomaster2_v2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($VEHICLETRANSPORTPLANID, SQLSRV_PARAM_IN),
        array($TENKOMASTERKA, SQLSRV_PARAM_IN),
        array($TENKOMASTERSTATUS, SQLSRV_PARAM_IN),
        array($TENKOMASTERREMARK1, SQLSRV_PARAM_IN),
        array($TENKOMASTERREMARK2, SQLSRV_PARAM_IN),
        array($VEHICLEREGISNUMBER, SQLSRV_PARAM_IN),
        array($JOBSTART, SQLSRV_PARAM_IN),
        array($JOBEND1, SQLSRV_PARAM_IN),
        array($JOBEND2, SQLSRV_PARAM_IN),
        array($DAYONE, SQLSRV_PARAM_IN),
        array($TENKOTARGET1, SQLSRV_PARAM_IN),
        array($TENKOTARGET2, SQLSRV_PARAM_IN),
        array($TENKOTARGET3, SQLSRV_PARAM_IN),
        array($TENKOTARGET4, SQLSRV_PARAM_IN),
        array($TENKOTARGET5, SQLSRV_PARAM_IN),
        array($TENKOTARGET6, SQLSRV_PARAM_IN),
        array($TENKOTARGET7, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insTenkomaster($FLG, $CONDITION1, $VEHICLETRANSPORTPLANID, $TENKOMASTERKA, $TENKOMASTERREMARKBEFORE, $TENKOMASTERREMARKAFTER, $ACTIVESTATUS, $OFFICER,$STATUSEMP) {
    $conn = connect("RTMS");
    $sql = "{call megEdittenkomaster_v2(?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($VEHICLETRANSPORTPLANID, SQLSRV_PARAM_IN),
        array($TENKOMASTERKA, SQLSRV_PARAM_IN),
        array($TENKOMASTERREMARKBEFORE, SQLSRV_PARAM_IN),
        array($TENKOMASTERREMARKAFTER, SQLSRV_PARAM_IN),
        array($ACTIVESTATUS, SQLSRV_PARAM_IN),
        array($OFFICER, SQLSRV_PARAM_IN),
        array($STATUSEMP, SQLSRV_PARAM_IN)
        
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $STATUSEMP;
}

function saveVehicletransportplanactual($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ, $STATUSNUMBER, $STATUS) {
    $conn = connect("RTMS");
    $sql = "{call megVehicletransportplanactual_v2(?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN),
        array($STATUSNUMBER, SQLSRV_PARAM_IN),
        array($STATUS, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}
function editTenkoafterpast($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ,$MODIFIEDBY) {
    $conn = connect("RTMS");
    $sql = "{call megEdittenkoafterpast_v2(?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN),
        array($MODIFIEDBY, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}
function editTenkoafter($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ,$MODIFIEDBY) {
    $conn = connect("RTMS");
    $sql = "{call megEdittenkoafter_v2(?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN),
        array($MODIFIEDBY, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editTenkogps($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ,$MODIFIEDBY) {
    $conn = connect("RTMS");
    $sql = "{call megEdittenkogps_v2(?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN),
        array($MODIFIEDBY, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editTenkorisky($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ,$MODIFIEDBY) {
    $conn = connect("RTMS");
    $sql = "{call megEdittenkorisky_v2(?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN),
        array($MODIFIEDBY, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}
function editTenkobeforeofficer($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ,$MODIFIEDBY) {
    $conn = connect("RTMS");
    $sql = "{call megEdittenkobeforeofficer_v2(?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN),
        array($MODIFIEDBY, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}
function editTenkobefore($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ,$MODIFIEDBY) {
    $conn = connect("RTMS");
    $sql = "{call megEdittenkobefore_v2(?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN),
        array($MODIFIEDBY, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editTenkotransport($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ, $TENKOBETRANSPORTDATE,$MODIFIEDBY) {
    $conn = connect("RTMS");
    $sql = "{call megEdittenkotransport_v2(?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN),
        array($TENKOBETRANSPORTDATE, SQLSRV_PARAM_IN),
        array($MODIFIEDBY, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportpricenew($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ, $MONTHST) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportpricenew_v2(?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN),
        array($MONTHST, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportprice($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportprice_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportpriceavgkm($FLG, $CONDITION1, $CONDITION2, $CONDITION3, $CONDITION4) {
    $conn = connect("RTMS");
    $sql = "{call megVehicletransportpriceavgkm_v2(?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($CONDITION2, SQLSRV_PARAM_IN),
        array($CONDITION3, SQLSRV_PARAM_IN),
        array($CONDITION4, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editInvoince($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ) {
    $conn = connect("RTMS");
    $sql = "{call megEditinvoince_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportpricerccttt2($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportpricerccttt2_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportpriceratcttt2($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportpriceratcttt2_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportpricerkstaw($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportpricerkstaw_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportpricerkstgt($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportpricerkstgt_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportpricerkrtgt($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportpricerkrtgt_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportpricerkrdaiki($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportpricerkrdaiki_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportpricerkldaiki($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportpricerkldaiki_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportpricerklttprostc($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportpricerklttprostc_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportpricerkrttprostc($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportpricerkrttprostc_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportpricerkrttaststc($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportpricerkrttaststc_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportpricerkrttastcs($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportpricerkrttastcs_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportpricerkrtttcstc($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportpricerkrtttcstc_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportpricerklttaststc($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportpricerklttaststc_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportpricerklttastcs($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportpricerklttastcs_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportpricerkltttcstc($FLG, $CONDITION1, $FIELDNAME, $EDITTABLEOBJ) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportpricerkltttcstc_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delCustomer($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megCustomer_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delWorkcheckin($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megWorkcheckin_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delEmployeeheal($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megEmployeehealth_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delPhone($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megPhone_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function delVehiclecostmodel($FLG, $CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megVehiclecostmodel_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insMileage($FLG, $CONDITION1, $VEHICLEREGISNUMBER, $JOBNO, $MILEAGENUMBER, $MILEAGETYPE, $ROUNDAMOUNT,$CREATEBY) {
    $conn = connect("RTMS");
    $sql = "{call megMileage_v2(?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($VEHICLEREGISNUMBER, SQLSRV_PARAM_IN),
        array($JOBNO, SQLSRV_PARAM_IN),
        array($MILEAGENUMBER, SQLSRV_PARAM_IN),
        array($MILEAGETYPE, SQLSRV_PARAM_IN),
        array($ROUNDAMOUNT, SQLSRV_PARAM_IN),
        array($CREATEBY, SQLSRV_PARAM_IN)

    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insPhone($FLG, $CONDITION1, $CONDITION2, $CONDITION3, $AREA, $NUMBER, $EMPLOYEECODE) {
    $conn = connect("RTMS");
    $sql = "{call megPhone_v2(?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($CONDITION2, SQLSRV_PARAM_IN),
        array($CONDITION3, SQLSRV_PARAM_IN),
        array($AREA, SQLSRV_PARAM_IN),
        array($NUMBER, SQLSRV_PARAM_IN),
        array($EMPLOYEECODE, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insHealth($FLG, $CONDITION1, $EMPLOYEECODE, $HEALTHISSUE, $SUGGESTION, $COMMENT) {
    $conn = connect("RTMS");
    $sql = "{call megEmployeehealth_v2(?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($EMPLOYEECODE, SQLSRV_PARAM_IN),
        array($HEALTHISSUE, SQLSRV_PARAM_IN),
        array($SUGGESTION, SQLSRV_PARAM_IN),
        array($COMMENT, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insCovid19($FLG, $CONDITION1, $CONDITION2, $CONDITION3, $COMPANYCODE, $EMPLOYEECODE, $TEMPERATURE, $ALCOHOL, $SYMPTOM1, $SYMPTOM2, $SYMPTOM3, $SYMPTOM4) {
    $conn = connect("RTMS");
    $sql = "{call megCovid19_v2(?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($CONDITION2, SQLSRV_PARAM_IN),
        array($CONDITION3, SQLSRV_PARAM_IN),
        array($COMPANYCODE, SQLSRV_PARAM_IN),
        array($EMPLOYEECODE, SQLSRV_PARAM_IN),
        array($TEMPERATURE, SQLSRV_PARAM_IN),
        array($ALCOHOL, SQLSRV_PARAM_IN),
        array($SYMPTOM1, SQLSRV_PARAM_IN),
        array($SYMPTOM2, SQLSRV_PARAM_IN),
        array($SYMPTOM3, SQLSRV_PARAM_IN),
        array($SYMPTOM4, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}
function insNewyearcheckin($FLG, $CONDITION1, $CONDITION2, $CONDITION3) {
    $conn = connect("RTMS");

    $sql = "{call megNewyearcheckin_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($CONDITION2, SQLSRV_PARAM_IN),
        array($CONDITION3, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);

    sqlsrv_close($conn);
    return $result['RS'];
}
function updPlanskb($FLG, $CONDITION1,$CONDITION2) {
    $conn = connect("RTMS");
    $sql = "{call megVehicletransportpriceavgkm_v2(?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($CONDITION2, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}
function insConfrimtempskb($FLG, $CONDITION1, $JOBSTART, $CLUSTER, $JOBEND, $KM, $COMPENSATION, $PRICEKM) {
    $conn = connect("RTMS");
    $sql = "{call megConfrimtempskb_v2(?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($JOBSTART, SQLSRV_PARAM_IN),
        array($CLUSTER, SQLSRV_PARAM_IN),
        array($JOBEND, SQLSRV_PARAM_IN),
        array($KM, SQLSRV_PARAM_IN),
        array($COMPENSATION, SQLSRV_PARAM_IN),
        array($PRICEKM, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insConfrimskb($FLG, $CONDITION1, $JOBSTART, $CLUSTER, $JOBEND, $KM, $COMPENSATION) {
    $conn = connect("RTMS");
    $sql = "{call megConfrimskb_v2(?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($JOBSTART, SQLSRV_PARAM_IN),
        array($CLUSTER, SQLSRV_PARAM_IN),
        array($JOBEND, SQLSRV_PARAM_IN),
        array($KM, SQLSRV_PARAM_IN),
        array($COMPENSATION, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insVehicletransportplan_temp($FLG, $DATA1, $DATA2, $DATA3, $DATA4, $DATA5, $DATA6, $DATA7, $DATA8, $DATA9, $DATA10, $DATA11, $DATA12, $DATA13, $DATA14, $DATA15, $DATA16, $DATA17, $DATA18, $DATA19, $DATA20, $DATA21, $DATA22, $DATA23, $DATA24, $DATA25, $DATA26, $DATA27, $DATA28, $DATA29, $DATA30, $DATA31, $DATA32) {
    $conn = connect("RTMS");
    $sql = "{call megVehicletransportplan_temp_v2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($DATA1, SQLSRV_PARAM_IN),
        array($DATA2, SQLSRV_PARAM_IN),
        array($DATA3, SQLSRV_PARAM_IN),
        array($DATA4, SQLSRV_PARAM_IN),
        array($DATA5, SQLSRV_PARAM_IN),
        array($DATA6, SQLSRV_PARAM_IN),
        array($DATA7, SQLSRV_PARAM_IN),
        array($DATA8, SQLSRV_PARAM_IN),
        array($DATA9, SQLSRV_PARAM_IN),
        array($DATA10, SQLSRV_PARAM_IN),
        array($DATA11, SQLSRV_PARAM_IN),
        array($DATA12, SQLSRV_PARAM_IN),
        array($DATA13, SQLSRV_PARAM_IN),
        array($DATA14, SQLSRV_PARAM_IN),
        array($DATA15, SQLSRV_PARAM_IN),
        array($DATA16, SQLSRV_PARAM_IN),
        array($DATA17, SQLSRV_PARAM_IN),
        array($DATA18, SQLSRV_PARAM_IN),
        array($DATA19, SQLSRV_PARAM_IN),
        array($DATA20, SQLSRV_PARAM_IN),
        array($DATA21, SQLSRV_PARAM_IN),
        array($DATA22, SQLSRV_PARAM_IN),
        array($DATA23, SQLSRV_PARAM_IN),
        array($DATA24, SQLSRV_PARAM_IN),
        array($DATA25, SQLSRV_PARAM_IN),
        array($DATA26, SQLSRV_PARAM_IN),
        array($DATA27, SQLSRV_PARAM_IN),
        array($DATA28, SQLSRV_PARAM_IN),
        array($DATA29, SQLSRV_PARAM_IN),
        array($DATA30, SQLSRV_PARAM_IN),
        array($DATA31, SQLSRV_PARAM_IN),
        array($DATA32, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insVehicleweigh($FLG, $CONDITION1, $VEHICLETRANSPORTPLANID, $CUSTOMECODE, $WEIGHNUMBER, $VEHICLEREGISNUMBER, $PRODUCTTYPE, $COMPANYCONTACT, $PRODUCTNAME, $WEIGHDATEIN, $WEIGHIN1, $WEIGHDATEOUT, $WEIGHIN2, $WEIGHOUT, $WEIGHSUM, $REMARK) {
    $conn = connect("RTMS");
    $sql = "{call megVehicleweigh_v2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($VEHICLETRANSPORTPLANID, SQLSRV_PARAM_IN),
        array($CUSTOMECODE, SQLSRV_PARAM_IN),
        array($WEIGHNUMBER, SQLSRV_PARAM_IN),
        array($VEHICLEREGISNUMBER, SQLSRV_PARAM_IN),
        array($PRODUCTTYPE, SQLSRV_PARAM_IN),
        array($COMPANYCONTACT, SQLSRV_PARAM_IN),
        array($PRODUCTNAME, SQLSRV_PARAM_IN),
        array($WEIGHDATEIN, SQLSRV_PARAM_IN),
        array($WEIGHIN1, SQLSRV_PARAM_IN),
        array($WEIGHDATEOUT, SQLSRV_PARAM_IN),
        array($WEIGHIN2, SQLSRV_PARAM_IN),
        array($WEIGHOUT, SQLSRV_PARAM_IN),
        array($WEIGHSUM, SQLSRV_PARAM_IN),
        array($REMARK, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insVehiclecostmodel($FLG, $CONDITION1, $MODELNAME, $CARTYPE, $OILTYPE, $CARLOAD, $CARNULL, $CARNOTNULL, $CARRUBBER, $CARENGINEOIL, $CARBRAKE, $CARBATTERY, $REMARK, $ACTIVESTATUS) {

    $conn = connect("RTMS");
    $sql = "{call megVehiclecostmodel_v2(?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($MODELNAME, SQLSRV_PARAM_IN),
        array($CARTYPE, SQLSRV_PARAM_IN),
        array($OILTYPE, SQLSRV_PARAM_IN),
        array($CARLOAD, SQLSRV_PARAM_IN),
        array($CARNULL, SQLSRV_PARAM_IN),
        array($CARNOTNULL, SQLSRV_PARAM_IN),
        array($CARRUBBER, SQLSRV_PARAM_IN),
        array($CARENGINEOIL, SQLSRV_PARAM_IN),
        array($CARBRAKE, SQLSRV_PARAM_IN),
        array($CARBATTERY, SQLSRV_PARAM_IN),
        array($REMARK, SQLSRV_PARAM_IN),
        array($ACTIVESTATUS, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insCustomer($FLG, $CONDITION1, $CUSTOMERCODE, $NAMETH, $NAMEENG, $BUSINESSTYPE, $COMPANYTYPE, $COMPANYSTATUS, $TAXCODE, $NATIONALITY, $RACE, $REGISTRATIONDATE, $CAPITAL, $PHONE, $FAX, $EMAILADDRESS1, $EMAILADDRESS2, $WEBSITE, $GRADE, $REMARK, $ACTIVESTATUS) {
    $conn = connect("RTMS");
    $sql = "{call megCustomer_v2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($CUSTOMERCODE, SQLSRV_PARAM_IN),
        array($NAMETH, SQLSRV_PARAM_IN),
        array($NAMEENG, SQLSRV_PARAM_IN),
        array($BUSINESSTYPE, SQLSRV_PARAM_IN),
        array($COMPANYTYPE, SQLSRV_PARAM_IN),
        array($COMPANYSTATUS, SQLSRV_PARAM_IN),
        array($TAXCODE, SQLSRV_PARAM_IN),
        array($NATIONALITY, SQLSRV_PARAM_IN),
        array($RACE, SQLSRV_PARAM_IN),
        array($REGISTRATIONDATE, SQLSRV_PARAM_IN),
        array($CAPITAL, SQLSRV_PARAM_IN),
        array($PHONE, SQLSRV_PARAM_IN),
        array($FAX, SQLSRV_PARAM_IN),
        array($EMAILADDRESS1, SQLSRV_PARAM_IN),
        array($EMAILADDRESS2, SQLSRV_PARAM_IN),
        array($WEBSITE, SQLSRV_PARAM_IN),
        array($GRADE, SQLSRV_PARAM_IN),
        array($REMARK, SQLSRV_PARAM_IN),
        array($ACTIVESTATUS, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function create_invoice() {
    $conn = connect("RTMS");
    $sql_seYYmmdd = "{call megGetdate_v2(?,?)}";
    $params_seYYmmdd = array(
        array('select_yymmdd', SQLSRV_PARAM_IN),
        array('GETDATE()', SQLSRV_PARAM_IN)
    );
    $query_seYYmmdd = sqlsrv_query($conn, $sql_seYYmmdd, $params_seYYmmdd);
    $result_seYYmmdd = sqlsrv_fetch_array($query_seYYmmdd, SQLSRV_FETCH_ASSOC);



    $condition1 = " AND SUBSTRING(INVOICECODE,3,6) = '" . $result_seYYmmdd['DATEYYMMDD'] . "'";
    $sql_seMaxjobno = "{call megLoginvoice_v2(?,?)}";
    $params_seMaxjobno = array(
        array('select_maxinvoicecode', SQLSRV_PARAM_IN),
        array($condition1, SQLSRV_PARAM_IN)
    );
    $query_seMaxjobno = sqlsrv_query($conn, $sql_seMaxjobno, $params_seMaxjobno);
    $result_seMaxjobno = sqlsrv_fetch_array($query_seMaxjobno, SQLSRV_FETCH_ASSOC);


    $nums = ++$result_seMaxjobno['maxinvoicecode'];
//$id = str_pad($nums,9,"000000",STR_PAD_LEFT);
    $maxjobno = sprintf("%03d", $nums);
    $run_jobno = $result_seYYmmdd['DATEYYMMDD'] . $result_seYYmmdd['DATEMMM'] . $maxjobno;
    sqlsrv_close($conn);
    return trim($run_jobno);
}

function create_billing() {
    $conn = connect("RTMS");
    $sql_seYYmmdd = "{call megGetdate_v2(?,?)}";
    $params_seYYmmdd = array(
        array('select_yymmdd', SQLSRV_PARAM_IN),
        array('GETDATE()', SQLSRV_PARAM_IN)
    );
    $query_seYYmmdd = sqlsrv_query($conn, $sql_seYYmmdd, $params_seYYmmdd);
    $result_seYYmmdd = sqlsrv_fetch_array($query_seYYmmdd, SQLSRV_FETCH_ASSOC);

    $condition1 = " AND SUBSTRING(BILLINGCODE,3,6) = '" . $result_seYYmmdd['DATEYYMMDD'] . "'";
    $sql_seMaxjobno = "{call megLogbilling_v2(?,?)}";
    $params_seMaxjobno = array(
        array('select_maxbillingcode', SQLSRV_PARAM_IN),
        array($condition1, SQLSRV_PARAM_IN)
    );
    $query_seMaxjobno = sqlsrv_query($conn, $sql_seMaxjobno, $params_seMaxjobno);
    $result_seMaxjobno = sqlsrv_fetch_array($query_seMaxjobno, SQLSRV_FETCH_ASSOC);


    $nums = ++$result_seMaxjobno['maxbillingcode'];
    $maxjobno = sprintf("%03d", $nums);
    $run_jobno = $result_seYYmmdd['DATEYYMMDD'] . $result_seYYmmdd['DATEMMM'] . $maxjobno;
    sqlsrv_close($conn);
    return trim($run_jobno);
}

function create_jobno($companycode, $jobdate) {
    $conn = connect("RTMS");
    $sql_seYYmmdd = "{call megGetdate_v2(?,?)}";
    $params_seYYmmdd = array(
        array('select_yymmdd', SQLSRV_PARAM_IN),
        array($jobdate, SQLSRV_PARAM_IN)
    );
    $query_seYYmmdd = sqlsrv_query($conn, $sql_seYYmmdd, $params_seYYmmdd);
    $result_seYYmmdd = sqlsrv_fetch_array($query_seYYmmdd, SQLSRV_FETCH_ASSOC);



    $condition1 = " AND SUBSTRING(a.JOBNO,1,3) = '" . $companycode . "' AND SUBSTRING(a.JOBNO,5,6) = '" . $result_seYYmmdd['DATEYYMMDD'] . "'";
    $sql_seMaxjobno = "{call megVehicletransportplan_v2(?,?)}";
    $params_seMaxjobno = array(
        array('select_maxjobno', SQLSRV_PARAM_IN),
        array($condition1, SQLSRV_PARAM_IN)
    );
    $query_seMaxjobno = sqlsrv_query($conn, $sql_seMaxjobno, $params_seMaxjobno);
    $result_seMaxjobno = sqlsrv_fetch_array($query_seMaxjobno, SQLSRV_FETCH_ASSOC);


    $nums = ++$result_seMaxjobno['maxjobno'];
//$id = str_pad($nums,9,"000000",STR_PAD_LEFT);
    $maxjobno = sprintf("%03d", $nums);
    $run_jobno = $companycode . '-' . $result_seYYmmdd['DATEYYMMDD'] . '-' . $result_seYYmmdd['DATEMMM'] . '-' . $maxjobno;
    sqlsrv_close($conn);
    return trim($run_jobno);
}

function saveJobreturn($FLG, $JOBNO, $JDOCUMENTCODE, $AMTUNIT) {


    $conn = connect("RTMS");
    $sql = "{call megVehicletransportplanjobreturn_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($JOBNO, SQLSRV_PARAM_IN),
        array($JDOCUMENTCODE, SQLSRV_PARAM_IN),
        array($AMTUNIT, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function saveCopyjobvehicletransportplan($FLG, $JOBNO, $ROWSAMOUNT) {


    $conn = connect("RTMS");
    $sql = "{call megVehicletransportplancopyjob_v2(?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($JOBNO, SQLSRV_PARAM_IN),
        array($ROWSAMOUNT, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insVehicletransportdocument($FLG, $CONDITION1, $VEHICLETRANSPORTPLANID, $DOCUMENTTYPE, $TRIPNUMBER, $AMOUNT, $UNIT, $STARTSTOPINCOME, $WARKINGSTOPINCOME, $BEFORE13INCOME, $AFTER13INCOME, $INCOME, $TOTALINCOME, $EXPRESSWAYCOSTS, $REPAIRCOSTS, $OTHERCOSTS, $REMARKCOSTS, $APPROVERSCOSTS, $ACTIVESTATUS, $REMARK) {


    $conn = connect("RTMS");
    $sql = "{call megVehicletransportdocument_v2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($VEHICLETRANSPORTPLANID, SQLSRV_PARAM_IN),
        array($DOCUMENTTYPE, SQLSRV_PARAM_IN),
        array($TRIPNUMBER, SQLSRV_PARAM_IN),
        array($AMOUNT, SQLSRV_PARAM_IN),
        array($UNIT, SQLSRV_PARAM_IN),
        array($STARTSTOPINCOME, SQLSRV_PARAM_IN),
        array($WARKINGSTOPINCOME, SQLSRV_PARAM_IN),
        array($BEFORE13INCOME, SQLSRV_PARAM_IN),
        array($AFTER13INCOME, SQLSRV_PARAM_IN),
        array($INCOME, SQLSRV_PARAM_IN),
        array($TOTALINCOME, SQLSRV_PARAM_IN),
        array($EXPRESSWAYCOSTS, SQLSRV_PARAM_IN),
        array($REPAIRCOSTS, SQLSRV_PARAM_IN),
        array($OTHERCOSTS, SQLSRV_PARAM_IN),
        array($REMARKCOSTS, SQLSRV_PARAM_IN),
        array($APPROVERSCOSTS, SQLSRV_PARAM_IN),
        array($ACTIVESTATUS, SQLSRV_PARAM_IN),
        array($REMARK, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insVehicletransportdocumentadmin($FLG, $CONDITION1, $VEHICLETRANSPORTPLANID, $DOCUMENTTYPE, $DOCUMENTNUMBER, $AMOUNT, $UNIT, $ACTIVESTATUS, $REMARK) {


    $conn = connect("RTMS");
    $sql = "{call megVehicletransportdocumentadmin_v2(?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($VEHICLETRANSPORTPLANID, SQLSRV_PARAM_IN),
        array($DOCUMENTTYPE, SQLSRV_PARAM_IN),
        array($DOCUMENTNUMBER, SQLSRV_PARAM_IN),
        array($AMOUNT, SQLSRV_PARAM_IN),
        array($UNIT, SQLSRV_PARAM_IN),
        array($ACTIVESTATUS, SQLSRV_PARAM_IN),
        array($REMARK, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editVehicletransportplanrrc($TXT_FLG, $CONDITION1, $EMPLOYEENAME1, $EMPLOYEENAME2, $VEHICLEINFO, $VEHICLETYPE, $C8, $MATERIALTYPE, $JOBSTART, $JOBEND, $COPYDIAGRAMDATEVLINUPD, $COPYDIAGRAMDATEVLOUTUPD, $COPYDIAGRAMDATEDEALERINUPD, $COPYDIAGRAMDATERETURNUPD) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportplanrrc_v2(?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($TXT_FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($EMPLOYEENAME1, SQLSRV_PARAM_IN),
        array($EMPLOYEENAME2, SQLSRV_PARAM_IN),
        array($VEHICLEINFO, SQLSRV_PARAM_IN),
        array($VEHICLETYPE, SQLSRV_PARAM_IN),
        array($C8, SQLSRV_PARAM_IN),
        array($MATERIALTYPE, SQLSRV_PARAM_IN),
        array($JOBSTART, SQLSRV_PARAM_IN),
        array($JOBEND, SQLSRV_PARAM_IN),
        array($COPYDIAGRAMDATEVLINUPD, SQLSRV_PARAM_IN),
        array($COPYDIAGRAMDATEVLOUTUPD, SQLSRV_PARAM_IN),
        array($COPYDIAGRAMDATEDEALERINUPD, SQLSRV_PARAM_IN),
        array($COPYDIAGRAMDATERETURNUPD, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editCopydiagramvehicletransportplannsh($TXT_FLG, $CONDITION1, $JOBSTARTSH, $JOBENDMAINSH, $JOBENDSH, $LOADSH) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportplannsh_v2(?,?,?,?,?,?)}";
    $params = array(
        array($TXT_FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($JOBSTARTSH, SQLSRV_PARAM_IN),
        array($JOBENDMAINSH, SQLSRV_PARAM_IN),
        array($JOBENDSH, SQLSRV_PARAM_IN),
        array($LOADSH, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function editCopydiagramvehicletransportplan($TXT_FLG, $CONDITION1, $EMPLOYEENAME1, $EMPLOYEENAME2, $VEHICLEINFO, $CLUSTER, $JOBEND, $LOAD, $copydiagramdaterkupd, $copydiagramdatevlinupd, $copydiagramdatevloutupd, $copydiagramdatedealerinupd, $copydiagramdatereturnupd, $JOBSTART,$WORKTYPE) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportplan_v2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($TXT_FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($EMPLOYEENAME1, SQLSRV_PARAM_IN),
        array($EMPLOYEENAME2, SQLSRV_PARAM_IN),
        array($VEHICLEINFO, SQLSRV_PARAM_IN),
        array($CLUSTER, SQLSRV_PARAM_IN),
        array($JOBEND, SQLSRV_PARAM_IN),
        array($LOAD, SQLSRV_PARAM_IN),
        array($copydiagramdaterkupd, SQLSRV_PARAM_IN),
        array($copydiagramdatevlinupd, SQLSRV_PARAM_IN),
        array($copydiagramdatevloutupd, SQLSRV_PARAM_IN),
        array($copydiagramdatedealerinupd, SQLSRV_PARAM_IN),
        array($copydiagramdatereturnupd, SQLSRV_PARAM_IN),
        array($JOBSTART, SQLSRV_PARAM_IN),
        array($WORKTYPE, SQLSRV_PARAM_IN),
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insUpdatebilling($TXT_FLG, $CONDITION1, $EMPLOYEENAME1, $EMPLOYEENAME2, $VEHICLEINFO, $FIELDNAME, $EDITTABLEOBJ, $LOAD, $copydiagramdaterkupd,$JOBEND) {
    $conn = connect("RTMS");
    $sql = "{call megEditvehicletransportplan_v2(?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($TXT_FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($EMPLOYEENAME1, SQLSRV_PARAM_IN),
        array($EMPLOYEENAME2, SQLSRV_PARAM_IN),
        array($VEHICLEINFO, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN),
        array($LOAD, SQLSRV_PARAM_IN),
        array($copydiagramdaterkupd, SQLSRV_PARAM_IN),
        array($JOBEND, SQLSRV_PARAM_IN)
        
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insCopydiagramvehicletransportplan(
$TXT_FLG, $CONDITION1, $STARTDATE, $ENDDATE, $CUSTOMERCODE, $COMPANYCODE, $THAINAME, $JOBSTART, $CLUSTER, $JOBEND, $EMPLOYEENAME1, $EMPLOYEENAME2, $EMPLOYEENAME3, $JOBNO, $DATEINPUT, $DATEPRESENT, $DATEWORKING, $DATERK, $DATEVLIN, $DATEVLOUT, $DATEDEALERIN, $DATERETURN, $VEHICLETYPE, $MATERIALTYPE, $GORETURN, $WORKTYPE, $LOAD, $ROUTE, $UNIT, $ROUNDAMOUNT, $DN, $CARRYTYPE, $THAINAME2, $BILLING, $CREATEBY, $NO7, $NO8, $HOLIDAY) {
    $conn = connect("RTMS");
    $sql = "{call megVehicletransportplancopydiagram_v2("
            . "?,?,?,?,?,"
            . "?,?,?,?,?,"
            . "?,?,?,?,?,"
            . "?,?,?,?,?,"
            . "?,?,?,?,?,"
            . "?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($TXT_FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($STARTDATE, SQLSRV_PARAM_IN),
        array($ENDDATE, SQLSRV_PARAM_IN),
        array($CUSTOMERCODE, SQLSRV_PARAM_IN),
        array($COMPANYCODE, SQLSRV_PARAM_IN),
        array($THAINAME, SQLSRV_PARAM_IN),
        array($JOBSTART, SQLSRV_PARAM_IN),
        array($CLUSTER, SQLSRV_PARAM_IN),
        array($JOBEND, SQLSRV_PARAM_IN),
        array($EMPLOYEENAME1, SQLSRV_PARAM_IN),
        array($EMPLOYEENAME2, SQLSRV_PARAM_IN),
        array($EMPLOYEENAME3, SQLSRV_PARAM_IN),
        array($JOBNO, SQLSRV_PARAM_IN),
        array($DATEINPUT, SQLSRV_PARAM_IN),
        array($DATEPRESENT, SQLSRV_PARAM_IN),
        array($DATEWORKING, SQLSRV_PARAM_IN),
        array($DATERK, SQLSRV_PARAM_IN),
        array($DATEVLIN, SQLSRV_PARAM_IN),
        array($DATEVLOUT, SQLSRV_PARAM_IN),
        array($DATEDEALERIN, SQLSRV_PARAM_IN),
        array($DATERETURN, SQLSRV_PARAM_IN),
        array($VEHICLETYPE, SQLSRV_PARAM_IN),
        array($MATERIALTYPE, SQLSRV_PARAM_IN),
        array($GORETURN, SQLSRV_PARAM_IN),
        array($WORKTYPE, SQLSRV_PARAM_IN),
        array($LOAD, SQLSRV_PARAM_IN),
        array($ROUTE, SQLSRV_PARAM_IN),
        array($UNIT, SQLSRV_PARAM_IN),
        array($ROUNDAMOUNT, SQLSRV_PARAM_IN),
        array($DN, SQLSRV_PARAM_IN),
        array($CARRYTYPE, SQLSRV_PARAM_IN),
        array($THAINAME2, SQLSRV_PARAM_IN),
        array($BILLING, SQLSRV_PARAM_IN),
        array($CREATEBY, SQLSRV_PARAM_IN),
        array($NO7, SQLSRV_PARAM_IN),
        array($NO8, SQLSRV_PARAM_IN),
        array($HOLIDAY, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insVehicletransportplan($FLG, $CONDITION1, $CUSTOMERCODE, $COMPANYCODE, $VEHICLEREGISNUMBER1, $VEHICLEREGISNUMBER2, $THAINAME, $ENGNAME, $VEHICLETRANSPORTPRICEID, $CLUSTER, $DEALERCODE, $NAME, $SRBASE4L, $SRBASE8L, $GWBASE4L, $GWBASE8L, $BPBASE4L, $BPBASE8L, $OTHBASE4L, $OTHBASE8L, $E1, $E2, $E3, $E4, $C1, $C2, $C3, $C4, $C5, $C6, $C7, $C8, $C9, $O1, $O2, $O3, $O4, $JOBSTART, $JOBEND, $EMPLOYEECODE1, $EMPLOYEENAME1, $EMPLOYEECODE2, $EMPLOYEENAME2, $EMPLOYEECODE3, $EMPLOYEENAME3, $EMPLOYEECODE4, $EMPLOYEENAME4, $JOBNO, $TRIPNO, $DATEINPUT, $DATEWORKING, $DATEWORKSUS, $DATEPRESENT, $DATEVLIN, $DATEVLOUT, $DATEDEALERIN, $DATERETURN, $STATUS, $ACTIVESTATUS, $REMARK) {
    $conn = connect("RTMS");
    $sql = "{call megVehicletransportplan_v2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($CUSTOMERCODE, SQLSRV_PARAM_IN),
        array($COMPANYCODE, SQLSRV_PARAM_IN),
        array($VEHICLEREGISNUMBER1, SQLSRV_PARAM_IN),
        array($VEHICLEREGISNUMBER2, SQLSRV_PARAM_IN),
        array($THAINAME, SQLSRV_PARAM_IN),
        array($ENGNAME, SQLSRV_PARAM_IN),
        array($VEHICLETRANSPORTPRICEID, SQLSRV_PARAM_IN),
        array($CLUSTER, SQLSRV_PARAM_IN),
        array($DEALERCODE, SQLSRV_PARAM_IN),
        array($NAME, SQLSRV_PARAM_IN),
        array($SRBASE4L, SQLSRV_PARAM_IN),
        array($SRBASE8L, SQLSRV_PARAM_IN),
        array($GWBASE4L, SQLSRV_PARAM_IN),
        array($GWBASE8L, SQLSRV_PARAM_IN),
        array($BPBASE4L, SQLSRV_PARAM_IN),
        array($BPBASE8L, SQLSRV_PARAM_IN),
        array($OTHBASE4L, SQLSRV_PARAM_IN),
        array($OTHBASE8L, SQLSRV_PARAM_IN),
        array($E1, SQLSRV_PARAM_IN),
        array($E2, SQLSRV_PARAM_IN),
        array($E3, SQLSRV_PARAM_IN),
        array($E4, SQLSRV_PARAM_IN),
        array($C1, SQLSRV_PARAM_IN),
        array($C2, SQLSRV_PARAM_IN),
        array($C3, SQLSRV_PARAM_IN),
        array($C4, SQLSRV_PARAM_IN),
        array($C5, SQLSRV_PARAM_IN),
        array($C6, SQLSRV_PARAM_IN),
        array($C7, SQLSRV_PARAM_IN),
        array($C8, SQLSRV_PARAM_IN),
        array($C9, SQLSRV_PARAM_IN),
        array($O1, SQLSRV_PARAM_IN),
        array($O2, SQLSRV_PARAM_IN),
        array($O3, SQLSRV_PARAM_IN),
        array($O4, SQLSRV_PARAM_IN),
        array($JOBSTART, SQLSRV_PARAM_IN),
        array($JOBEND, SQLSRV_PARAM_IN),
        array($EMPLOYEECODE1, SQLSRV_PARAM_IN),
        array($EMPLOYEENAME1, SQLSRV_PARAM_IN),
        array($EMPLOYEECODE2, SQLSRV_PARAM_IN),
        array($EMPLOYEENAME2, SQLSRV_PARAM_IN),
        array($EMPLOYEECODE3, SQLSRV_PARAM_IN),
        array($EMPLOYEENAME3, SQLSRV_PARAM_IN),
        array($EMPLOYEECODE4, SQLSRV_PARAM_IN),
        array($EMPLOYEENAME4, SQLSRV_PARAM_IN),
        array($JOBNO, SQLSRV_PARAM_IN),
        array($TRIPNO, SQLSRV_PARAM_IN),
        array($DATEINPUT, SQLSRV_PARAM_IN),
        array($DATEWORKING, SQLSRV_PARAM_IN),
        array($DATEWORKSUS, SQLSRV_PARAM_IN),
        array($DATEPRESENT, SQLSRV_PARAM_IN),
        array($DATEVLIN, SQLSRV_PARAM_IN),
        array($DATEVLOUT, SQLSRV_PARAM_IN),
        array($DATEDEALERIN, SQLSRV_PARAM_IN),
        array($DATERETURN, SQLSRV_PARAM_IN),
        array($STATUS, SQLSRV_PARAM_IN),
        array($ACTIVESTATUS, SQLSRV_PARAM_IN),
        array($REMARK, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insVehicletransportprice($FLG, $CONDITION1, $CONDITION2, $CONDITION3,$CONDITION4, $VEHICLEDESCCODE, $WORKTYPE, $COMPANYCODE, $CUSTOMERCODE, $MONTHST, $ACTIVESTATUS, $CARRYTYPE) {
    $conn = connect("RTMS");
    $sql = "{call megVehicletransportprice_v2(?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($CONDITION2, SQLSRV_PARAM_IN),
        array($CONDITION3, SQLSRV_PARAM_IN),
        array($CONDITION4, SQLSRV_PARAM_IN),
        array($VEHICLEDESCCODE, SQLSRV_PARAM_IN),
        array($WORKTYPE, SQLSRV_PARAM_IN),
        array($COMPANYCODE, SQLSRV_PARAM_IN),
        array($CUSTOMERCODE, SQLSRV_PARAM_IN),
        array($MONTHST, SQLSRV_PARAM_IN),
        array($ACTIVESTATUS, SQLSRV_PARAM_IN),
        array($CARRYTYPE, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insVehicleinfo($FLG, $CONDITION1, $VEHICLEREGISNUMBER, $VEHICLEGROUPCODE, $VEHICLETYPECODE, $BRANDCODE, $GEARTYPECODE, $COLORCODE, $SERIES, $THAINAME, $ENGNAME, $HORSEPOWER, $CC, $MACHINENUMBER, $CHASSISNUMBER, $ENERGY, $WEIGHT, $AXLETYPE, $PISTON, $MAXIMUMLOAD, $TRUCKDIMENSION, $CARGODIMENSION, $FUELTANKCAP, $SPEEDLIMIT, $USED, $VEHICLEBUYWHERE, $VEHICLEBUYDATE, $VEHICLEBUYPRICE, $VEHICLEBUYCONDITION, $VEHICLESTRUCTUREWHERE, $VEHICLESTRUCTUREDATE, $VEHICLESTRUCTUREPRICE, $VEHICLEREGISTERDATE, $VEHICLESPECIAL, $AFFCOMPANY, $REMARK, $ACTIVESTATUS) {
    $conn = connect("RTMS");
    $sql = "{call megVehicleinfo_v2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($VEHICLEREGISNUMBER, SQLSRV_PARAM_IN),
        array($VEHICLEGROUPCODE, SQLSRV_PARAM_IN),
        array($VEHICLETYPECODE, SQLSRV_PARAM_IN),
        array($BRANDCODE, SQLSRV_PARAM_IN),
        array($GEARTYPECODE, SQLSRV_PARAM_IN),
        array($COLORCODE, SQLSRV_PARAM_IN),
        array($SERIES, SQLSRV_PARAM_IN),
        array($THAINAME, SQLSRV_PARAM_IN),
        array($ENGNAME, SQLSRV_PARAM_IN),
        array($HORSEPOWER, SQLSRV_PARAM_IN),
        array($CC, SQLSRV_PARAM_IN),
        array($MACHINENUMBER, SQLSRV_PARAM_IN),
        array($CHASSISNUMBER, SQLSRV_PARAM_IN),
        array($ENERGY, SQLSRV_PARAM_IN),
        array($WEIGHT, SQLSRV_PARAM_IN),
        array($AXLETYPE, SQLSRV_PARAM_IN),
        array($PISTON, SQLSRV_PARAM_IN),
        array($MAXIMUMLOAD, SQLSRV_PARAM_IN),
        array($TRUCKDIMENSION, SQLSRV_PARAM_IN),
        array($CARGODIMENSION, SQLSRV_PARAM_IN),
        array($FUELTANKCAP, SQLSRV_PARAM_IN),
        array($SPEEDLIMIT, SQLSRV_PARAM_IN),
        array($USED, SQLSRV_PARAM_IN),
        array($VEHICLEBUYWHERE, SQLSRV_PARAM_IN),
        array($VEHICLEBUYDATE, SQLSRV_PARAM_IN),
        array($VEHICLEBUYPRICE, SQLSRV_PARAM_IN),
        array($VEHICLEBUYCONDITION, SQLSRV_PARAM_IN),
        array($VEHICLESTRUCTUREWHERE, SQLSRV_PARAM_IN),
        array($VEHICLESTRUCTUREDATE, SQLSRV_PARAM_IN),
        array($VEHICLESTRUCTUREPRICE, SQLSRV_PARAM_IN),
        array($VEHICLEREGISTERDATE, SQLSRV_PARAM_IN),
        array($VEHICLESPECIAL, SQLSRV_PARAM_IN),
        array($AFFCOMPANY, SQLSRV_PARAM_IN),
        array($REMARK, SQLSRV_PARAM_IN),
        array($ACTIVESTATUS, SQLSRV_PARAM_IN),
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insVehiclechangehistory($FLG, $CONDITION1, $VEHICLEINFOID, $VCHANGETYPESCODE, $CHANGEDATE, $CHANGECOST, $WHOPROCESS, $CURRENTSPAREPARTS, $CHANGETO, $PLACE, $REMARK, $ACTIVESTATUS) {
    $conn = connect("RTMS");
    $sql = "{call megVehiclechangehistory_v2(?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($VEHICLEINFOID, SQLSRV_PARAM_IN),
        array($VCHANGETYPESCODE, SQLSRV_PARAM_IN),
        array($CHANGEDATE, SQLSRV_PARAM_IN),
        array($CHANGECOST, SQLSRV_PARAM_IN),
        array($WHOPROCESS, SQLSRV_PARAM_IN),
        array($CURRENTSPAREPARTS, SQLSRV_PARAM_IN),
        array($CHANGETO, SQLSRV_PARAM_IN),
        array($PLACE, SQLSRV_PARAM_IN),
        array($REMARK, SQLSRV_PARAM_IN),
        array($ACTIVESTATUS, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insVehicleinsured($FLG, $CONDITION1, $VEHICLEINFOID, $POLICYNUMBER, $INSUREDGROUP, $INSUREDTYPE, $PRICETOTAL, $SUMINSURED, $STARTDATE, $EXPIREDDATE, $INSUREDNAME, $BROKERNAME, $INSUREDCOMPANY, $REMARK, $ACTIVESTATUS) {
    $conn = connect("RTMS");
    $sql = "{call megVehicleinsured_v2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($VEHICLEINFOID, SQLSRV_PARAM_IN),
        array($POLICYNUMBER, SQLSRV_PARAM_IN),
        array($INSUREDGROUP, SQLSRV_PARAM_IN),
        array($INSUREDTYPE, SQLSRV_PARAM_IN),
        array($PRICETOTAL, SQLSRV_PARAM_IN),
        array($SUMINSURED, SQLSRV_PARAM_IN),
        array($STARTDATE, SQLSRV_PARAM_IN),
        array($EXPIREDDATE, SQLSRV_PARAM_IN),
        array($INSUREDNAME, SQLSRV_PARAM_IN),
        array($BROKERNAME, SQLSRV_PARAM_IN),
        array($INSUREDCOMPANY, SQLSRV_PARAM_IN),
        array($REMARK, SQLSRV_PARAM_IN),
        array($ACTIVESTATUS, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insVehiclemaintenance($FLG, $CONDITION1, $VEHICLEINFOID, $MAINTENANCEDATE, $COMPLETEDATE, $MAINTENANCETYPE, $PLACE, $PRICE, $WHOPROCESS, $REMARK, $ACTIVESTATUS) {
    $conn = connect("RTMS");
    $sql = "{call megVehiclemaintenance_v2(?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($VEHICLEINFOID, SQLSRV_PARAM_IN),
        array($MAINTENANCEDATE, SQLSRV_PARAM_IN),
        array($COMPLETEDATE, SQLSRV_PARAM_IN),
        array($MAINTENANCETYPE, SQLSRV_PARAM_IN),
        array($PLACE, SQLSRV_PARAM_IN),
        array($PRICE, SQLSRV_PARAM_IN),
        array($WHOPROCESS, SQLSRV_PARAM_IN),
        array($REMARK, SQLSRV_PARAM_IN),
        array($ACTIVESTATUS, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insVehiclerepair($FLG, $CONDITION1, $VEHICLEINFOID, $REPAIRTYPECODE, $GARAGEREPAIRNUMBER, $GARAGENAME, $STARTDATE, $ENDDATE, $ACTUALENDDATE, $TOTALAMOUNT, $WHOPROCESS, $ACTIVESTATUS, $REASON, $REPAIRDETAIL, $REMARK) {
    $conn = connect("RTMS");
    $sql = "{call megVehiclerepair_v2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($VEHICLEINFOID, SQLSRV_PARAM_IN),
        array($REPAIRTYPECODE, SQLSRV_PARAM_IN),
        array($GARAGEREPAIRNUMBER, SQLSRV_PARAM_IN),
        array($GARAGENAME, SQLSRV_PARAM_IN),
        array($STARTDATE, SQLSRV_PARAM_IN),
        array($ENDDATE, SQLSRV_PARAM_IN),
        array($ACTUALENDDATE, SQLSRV_PARAM_IN),
        array($TOTALAMOUNT, SQLSRV_PARAM_IN),
        array($WHOPROCESS, SQLSRV_PARAM_IN),
        array($ACTIVESTATUS, SQLSRV_PARAM_IN),
        array($REASON, SQLSRV_PARAM_IN),
        array($REPAIRDETAIL, SQLSRV_PARAM_IN),
        array($REMARK, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insVehicletax($FLG, $CONDITION1, $VEHICLEINFOID, $TAXDATE, $EXPIREDDATE, $PRICE, $SERVICEFEE, $WHOPROCESS, $ACTIVESTATUS, $PLACE, $REMARK) {
    $conn = connect("RTMS");
    $sql = "{call megVehicletax_v2(?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($VEHICLEINFOID, SQLSRV_PARAM_IN),
        array($TAXDATE, SQLSRV_PARAM_IN),
        array($EXPIREDDATE, SQLSRV_PARAM_IN),
        array($PRICE, SQLSRV_PARAM_IN),
        array($SERVICEFEE, SQLSRV_PARAM_IN),
        array($WHOPROCESS, SQLSRV_PARAM_IN),
        array($ACTIVESTATUS, SQLSRV_PARAM_IN),
        array($PLACE, SQLSRV_PARAM_IN),
        array($REMARK, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insVehicleowner($FLG, $CONDITION1, $VEHICLEINFOID, $OWNERCOMPANYCODE, $POSSESSCOMPANYCODE, $PROJECTTOUSE, $FIRSTDRIVER, $SECONDDRIVER, $REMARK, $ACTIVESTATUS) {
    $conn = connect("RTMS");
    $sql = "{call megVehicleowner_v2(?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($VEHICLEINFOID, SQLSRV_PARAM_IN),
        array($OWNERCOMPANYCODE, SQLSRV_PARAM_IN),
        array($POSSESSCOMPANYCODE, SQLSRV_PARAM_IN),
        array($PROJECTTOUSE, SQLSRV_PARAM_IN),
        array($FIRSTDRIVER, SQLSRV_PARAM_IN),
        array($SECONDDRIVER, SQLSRV_PARAM_IN),
        array($REMARK, SQLSRV_PARAM_IN),
        array($ACTIVESTATUS, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insVehiclepurchase($FLG, $CONDITION1, $VEHICLEINFOID, $SUPPLIERCODE, $LEASINGNAME, $PURCHASEDATE, $PEICE, $INTERESTRATE, $PAYMENTTIMES, $FIRSTPAYMENTDATEL, $LASTPAYMENTDATE, $REMARK, $ACTIVESTATUS) {
    $conn = connect("RTMS");
    $sql = "{call megVehiclepurchase_v2(?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($VEHICLEINFOID, SQLSRV_PARAM_IN),
        array($SUPPLIERCODE, SQLSRV_PARAM_IN),
        array($LEASINGNAME, SQLSRV_PARAM_IN),
        array($PURCHASEDATE, SQLSRV_PARAM_IN),
        array($PEICE, SQLSRV_PARAM_IN),
        array($INTERESTRATE, SQLSRV_PARAM_IN),
        array($PAYMENTTIMES, SQLSRV_PARAM_IN),
        array($FIRSTPAYMENTDATEL, SQLSRV_PARAM_IN),
        array($LASTPAYMENTDATE, SQLSRV_PARAM_IN),
        array($REMARK, SQLSRV_PARAM_IN),
        array($ACTIVESTATUS, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function save_ownerdirver($FLG, $CONDITION1, $OWERDIRVER, $VALUES) {
    $conn = connect("RTMS");
    $sql = "{call megOwnerdirver_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($OWERDIRVER, SQLSRV_PARAM_IN),
        array($VALUES, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insLogselect($FLG, $LOGSELECT, $EMPLOYEECODE, $EMPLOYEECODECHK) {
    $conn = connect("RTMS");
    $sql = "{call megLogselect_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($LOGSELECT, SQLSRV_PARAM_IN),
        array($EMPLOYEECODE, SQLSRV_PARAM_IN),
        array($EMPLOYEECODECHK, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insInputttastrrr($FLG, $CONDITION1, $CONDITION2, $CONDITION3, $DATEINPUT, $EMPLOYEECODE, $VEHICLENUMBER, $VEHICLETYPE, $JOBSTART, $JOBEND, $ZONE, $DOCUMENTNUMBER, $WEIGHTIN, $REMARK, $SENDTYPE) {
    $conn = connect("RTMS");
    $sql = "{call megInputrkrttast_v2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($CONDITION2, SQLSRV_PARAM_IN),
        array($CONDITION3, SQLSRV_PARAM_IN),
        array($DATEINPUT, SQLSRV_PARAM_IN),
        array($EMPLOYEECODE, SQLSRV_PARAM_IN),
        array($VEHICLENUMBER, SQLSRV_PARAM_IN),
        array($VEHICLETYPE, SQLSRV_PARAM_IN),
        array($JOBSTART, SQLSRV_PARAM_IN),
        array($JOBEND, SQLSRV_PARAM_IN),
        array($ZONE, SQLSRV_PARAM_IN),
        array($DOCUMENTNUMBER, SQLSRV_PARAM_IN),
        array($WEIGHTIN, SQLSRV_PARAM_IN),
        array($REMARK, SQLSRV_PARAM_IN),
        array($SENDTYPE, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insLogbilling($FLG, $CONDITION1, $CONDITION2, $BILLINGCODE, $INVOICECODE, $COMPANYCODE, $CUSTOMERCODE) {
    $conn = connect("RTMS");
    $sql = "{call megLogbilling_v2(?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($CONDITION2, SQLSRV_PARAM_IN),
        array($BILLINGCODE, SQLSRV_PARAM_IN),
        array($INVOICECODE, SQLSRV_PARAM_IN),
        array($COMPANYCODE, SQLSRV_PARAM_IN),
        array($CUSTOMERCODE, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insLoginvoice($FLG, $CONDITION1, $CONDITION2, $DATE_VLIN, $COMPANYCODE, $CUSTOMERCODE, $INVOICECODE, $EXPRESSWAYCODE, $DOCUMENTCODE, $VEHICLETRANSPORTDOCUMENTDRIVERID, $JOBSTART, $BILLING, $DULYDATE, $INVOICECODE2, $INVOICEADTH, $INVOICEBPK1, $INVOICEBPK2, $INVOICEASTH, $INVOICEDSTH) {
    $conn = connect("RTMS");
    $sql = "{call megLoginvoice_v2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($CONDITION2, SQLSRV_PARAM_IN),
        array($DATE_VLIN, SQLSRV_PARAM_IN),
        array($COMPANYCODE, SQLSRV_PARAM_IN),
        array($CUSTOMERCODE, SQLSRV_PARAM_IN),
        array($INVOICECODE, SQLSRV_PARAM_IN),
        array($EXPRESSWAYCODE, SQLSRV_PARAM_IN),
        array($DOCUMENTCODE, SQLSRV_PARAM_IN),
        array($VEHICLETRANSPORTDOCUMENTDRIVERID, SQLSRV_PARAM_IN),
        array($JOBSTART, SQLSRV_PARAM_IN),
        array($BILLING, SQLSRV_PARAM_IN),
        array($DULYDATE, SQLSRV_PARAM_IN),
        array($INVOICECODE2, SQLSRV_PARAM_IN),
        array($INVOICEADTH, SQLSRV_PARAM_IN),
        array($INVOICEBPK1, SQLSRV_PARAM_IN),
        array($INVOICEBPK2, SQLSRV_PARAM_IN),
        array($INVOICEASTH, SQLSRV_PARAM_IN),
        array($INVOICEDSTH, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function updateremarkLoginvoice($FLG, $CONDITION1, $CONDITION2, $INVOICECODE) {
    $conn = connect("RTMS");
    $sql = "{call megLoginvoice_v2(?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($CONDITION2, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array($INVOICECODE, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insLogbillinginvoice($FLG, $CONDITION1, $CONDITION2, $COMPANYCODE, $CUSTOMERCODE, $BILLINGCODE, $INVOICECODE, $BILLINGDATE, $PAYMENTDATE, $DUEDATE, $PRPO1, $TRIP1, $PRPO2, $TRIP2, $SUMTOTAL) {
    $conn = connect("RTMS");
    $sql = "{call megLogbillinginvoice_v2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($CONDITION2, SQLSRV_PARAM_IN),
        array($COMPANYCODE, SQLSRV_PARAM_IN),
        array($CUSTOMERCODE, SQLSRV_PARAM_IN),
        array($BILLINGCODE, SQLSRV_PARAM_IN),
        array($INVOICECODE, SQLSRV_PARAM_IN),
        array($BILLINGDATE, SQLSRV_PARAM_IN),
        array($PAYMENTDATE, SQLSRV_PARAM_IN),
        array($DUEDATE, SQLSRV_PARAM_IN),
        array($PRPO1, SQLSRV_PARAM_IN),
        array($TRIP1, SQLSRV_PARAM_IN),
        array($PRPO2, SQLSRV_PARAM_IN),
        array($TRIP2, SQLSRV_PARAM_IN),
        array($SUMTOTAL, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insVehicleattribute($FLG, $CONDITION1, $VEHICLEINFOID, $FRONTIMAGE, $FRONTWIDTH, $FRONTLONG, $FRONTHIGH, $SIDEIMAGE, $SIDEWIDTH, $SIDELONG, $SIDEHIGH, $BACKIMAGE, $BACKWIDTH, $BACKTLONG, $BACKTHIGH, $STRUCFRONTIMAGE, $STRUCFRONTWIDTH, $STRUCFRONTLONG, $STRUCFRONTHIGH, $STRUCSIDEIMAGE, $STRUCSIDEWIDTH, $STRUCSIDELONG, $STRUCSIDEHIGH, $STRUCBACKIMAGE, $STRUCBACKWIDTH, $STRUCBACKTLONG, $STRUCBACKTHIGH, $INIMAGE, $ACTIVESTATUS, $REMARK) {
    $conn = connect("RTMS");
    $sql = "{call megVehicleattribute_v2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($VEHICLEINFOID, SQLSRV_PARAM_IN),
        array($FRONTIMAGE, SQLSRV_PARAM_IN),
        array($FRONTWIDTH, SQLSRV_PARAM_IN),
        array($FRONTLONG, SQLSRV_PARAM_IN),
        array($FRONTHIGH, SQLSRV_PARAM_IN),
        array($SIDEIMAGE, SQLSRV_PARAM_IN),
        array($SIDEWIDTH, SQLSRV_PARAM_IN),
        array($SIDELONG, SQLSRV_PARAM_IN),
        array($SIDEHIGH, SQLSRV_PARAM_IN),
        array($BACKIMAGE, SQLSRV_PARAM_IN),
        array($BACKWIDTH, SQLSRV_PARAM_IN),
        array($BACKTLONG, SQLSRV_PARAM_IN),
        array($BACKTHIGH, SQLSRV_PARAM_IN),
        array($STRUCFRONTIMAGE, SQLSRV_PARAM_IN),
        array($STRUCFRONTWIDTH, SQLSRV_PARAM_IN),
        array($STRUCFRONTLONG, SQLSRV_PARAM_IN),
        array($STRUCFRONTHIGH, SQLSRV_PARAM_IN),
        array($STRUCSIDEIMAGE, SQLSRV_PARAM_IN),
        array($STRUCSIDEWIDTH, SQLSRV_PARAM_IN),
        array($STRUCSIDELONG, SQLSRV_PARAM_IN),
        array($STRUCSIDEHIGH, SQLSRV_PARAM_IN),
        array($STRUCBACKIMAGE, SQLSRV_PARAM_IN),
        array($STRUCBACKWIDTH, SQLSRV_PARAM_IN),
        array($STRUCBACKTLONG, SQLSRV_PARAM_IN),
        array($STRUCBACKTHIGH, SQLSRV_PARAM_IN),
        array($INIMAGE, SQLSRV_PARAM_IN),
        array($ACTIVESTATUS, SQLSRV_PARAM_IN),
        array($REMARK, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function save_warningdata($FLG, $CONDITION1, $TYPEWARNING, $SUBJECT, $DISCRIPTION, $FROMNAME, $AREA, $EMAILTO, $EMAILCC, $EMAILEXTRA, $WARNINGDAY, $REMARK, $ACTIVESTATUS) {
    $conn = connect("RTMS");
    $sql = "{call megWarningdata_v2(?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($TYPEWARNING, SQLSRV_PARAM_IN),
        array($SUBJECT, SQLSRV_PARAM_IN),
        array($DISCRIPTION, SQLSRV_PARAM_IN),
        array($FROMNAME, SQLSRV_PARAM_IN),
        array($AREA, SQLSRV_PARAM_IN),
        array($EMAILTO, SQLSRV_PARAM_IN),
        array($EMAILCC, SQLSRV_PARAM_IN),
        array($EMAILEXTRA, SQLSRV_PARAM_IN),
        array($WARNINGDAY, SQLSRV_PARAM_IN),
        array($REMARK, SQLSRV_PARAM_IN),
        array($ACTIVESTATUS, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function update_warningdata($FLG) {
    $conn = connect("RTMS");
    $sql = "{call megWarningdata_v2(?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insStopwork($FLG, $CONDITION1, $EMPLOYEEID, $EMPLOYEENAME, $COMPANYCODE, $COMPANYNAME, $STOPPROCESS, $REASON, $CARTYPE, $CARSTATUS, $VEHICLEREGISNUMBER, $THAINAME, $PARKINGN, $STARTTIME, $STOPTIME, $TENKOTIME, $DATEINPUT, $JOBINPUT, $TIMEINPUT, $JOBINPUT2, $TIMEINPUT2, $PRODUCTNUMBER) {
    $conn = connect("RTMS");
    $sql = "{call megStopwork_v2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($EMPLOYEEID, SQLSRV_PARAM_IN),
        array($EMPLOYEENAME, SQLSRV_PARAM_IN),
        array($COMPANYCODE, SQLSRV_PARAM_IN),
        array($COMPANYNAME, SQLSRV_PARAM_IN),
        array($STOPPROCESS, SQLSRV_PARAM_IN),
        array($REASON, SQLSRV_PARAM_IN),
        array($CARTYPE, SQLSRV_PARAM_IN),
        array($CARSTATUS, SQLSRV_PARAM_IN),
        array($VEHICLEREGISNUMBER, SQLSRV_PARAM_IN),
        array($THAINAME, SQLSRV_PARAM_IN),
        array($PARKINGN, SQLSRV_PARAM_IN),
        array($STARTTIME, SQLSRV_PARAM_IN),
        array($STOPTIME, SQLSRV_PARAM_IN),
        array($TENKOTIME, SQLSRV_PARAM_IN),
        array($DATEINPUT, SQLSRV_PARAM_IN),
        array($JOBINPUT, SQLSRV_PARAM_IN),
        array($TIMEINPUT, SQLSRV_PARAM_IN),
        array($JOBINPUT2, SQLSRV_PARAM_IN),
        array($TIMEINPUT2, SQLSRV_PARAM_IN),
        array($PRODUCTNUMBER, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function line_notify($Token, $message) {
    $lineapi = $Token; // ใส่ token key ที่ได้มา
    $mms = trim($message); // ข้อความที่ต้องการส่ง
    date_default_timezone_set("Asia/Bangkok");
    $chOne = curl_init();
    curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
// SSL USE
    curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
//POST
    curl_setopt($chOne, CURLOPT_POST, 1);
    curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=$mms");
    curl_setopt($chOne, CURLOPT_FOLLOWLOCATION, 1);
    $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $lineapi . '',);
    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($chOne);
//Check error
    if (curl_error($chOne)) {
        echo 'error:' . curl_error($chOne);
    } else {
        $result_ = json_decode($result, true);
        echo "status : " . $result_['status'];
        echo "message : " . $result_['message'];
    }
    curl_close($chOne);
}

function insRepair($FLG, $CONDITION1, $DRIVERNAME, $VEHICLENAME, $TENKO_INFROM, $TENKO_ISSUE, $TENKO_BEFOREEDIT,$TENKO_BEFOREEDIT2,$TENKO_BEFOREEDIT3, $TEC_AFFTEREDIT,$TEC_AFFTEREDIT2,$TEC_AFFTEREDIT3, $TENKO_REMARK, $TEC_INFROM, $TEC_TECHNICIAN, $TEC_COMPLETED, $TEC_CAUSE, $TEC_EDIT, $TEC_PROTECT, $TEC_REMARK, $REPAIRSTATUS1, $REPAIRSTATUS2, $REMARK, $ACTIVESTATUS,$TENKO_CARUSEDATE,$TENKO_PRODUCT,$TENKO_RUNTYPE,$TENKO_REPAIRTYPE,$TEC_ANALYZE,$TEC_REPAIRAREA,$TEC_REPAIRAREADETAIL) {
    $conn = connect("RTMS");
    $sql = "{call megRepair_v2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($DRIVERNAME, SQLSRV_PARAM_IN),
        array($VEHICLENAME, SQLSRV_PARAM_IN),
        array($TENKO_INFROM, SQLSRV_PARAM_IN),
        array($TENKO_ISSUE, SQLSRV_PARAM_IN),
        array($TENKO_BEFOREEDIT, SQLSRV_PARAM_IN),
        array($TENKO_BEFOREEDIT2, SQLSRV_PARAM_IN),
        array($TENKO_BEFOREEDIT3, SQLSRV_PARAM_IN),
        array($TEC_AFFTEREDIT, SQLSRV_PARAM_IN),
        array($TEC_AFFTEREDIT2, SQLSRV_PARAM_IN),
        array($TEC_AFFTEREDIT3, SQLSRV_PARAM_IN),
        array($TENKO_REMARK, SQLSRV_PARAM_IN),
        array($TEC_INFROM, SQLSRV_PARAM_IN),
        array($TEC_TECHNICIAN, SQLSRV_PARAM_IN),
        array($TEC_COMPLETED, SQLSRV_PARAM_IN),
        array($TEC_CAUSE, SQLSRV_PARAM_IN),
        array($TEC_EDIT, SQLSRV_PARAM_IN),
        array($TEC_PROTECT, SQLSRV_PARAM_IN),
        array($TEC_REMARK, SQLSRV_PARAM_IN),
        array($REPAIRSTATUS1, SQLSRV_PARAM_IN),
        array($REPAIRSTATUS2, SQLSRV_PARAM_IN),
        array($REMARK, SQLSRV_PARAM_IN),
        array($ACTIVESTATUS, SQLSRV_PARAM_IN),
		array($TENKO_CARUSEDATE, SQLSRV_PARAM_IN),
        array($TENKO_PRODUCT, SQLSRV_PARAM_IN),
        array($TENKO_RUNTYPE, SQLSRV_PARAM_IN),
        array($TENKO_REPAIRTYPE, SQLSRV_PARAM_IN),
        array($TEC_ANALYZE, SQLSRV_PARAM_IN),
        array($TEC_REPAIRAREA, SQLSRV_PARAM_IN),
        array($TEC_REPAIRAREADETAIL, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}
function insRole($FLG, $CONDITION1, $PREMISSIONSNAME, $REMARKROLE, $ACTIVESTATUSROLE) {
    $conn = connect("RTMS");
    $sql = "{call megRole_v2(?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($PREMISSIONSNAME, SQLSRV_PARAM_IN),
        array($REMARKROLE, SQLSRV_PARAM_IN),
        array($ACTIVESTATUSROLE, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insPassword($FLG, $CONDITION1, $ROLEID, $PASSWORDNEW) {
    $conn = connect("RTMS");
    $sql = "{call megPassword_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($ROLEID, SQLSRV_PARAM_IN),
        array($PASSWORDNEW, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insMenu($FLG, $CONDITION1, $MENUNAME, $REMARKMENU, $ACTIVESTATUSMENU) {
    $conn = connect("RTMS");
    $sql = "{call megMenu_v2(?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($MENUNAME, SQLSRV_PARAM_IN),
        array($REMARKMENU, SQLSRV_PARAM_IN),
        array($ACTIVESTATUSMENU, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insSubmenu($FLG, $CONDITION1, $MENUID, $SUBMENUNAME, $SUBMENUPATH, $REMARKSUBMENU, $ACTIVESTATUSSUBMENU) {
    $conn = connect("RTMS");
    $sql = "{call megSubmenu_v2(?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($MENUID, SQLSRV_PARAM_IN),
        array($SUBMENUNAME, SQLSRV_PARAM_IN),
        array($SUBMENUPATH, SQLSRV_PARAM_IN),
        array($REMARKSUBMENU, SQLSRV_PARAM_IN),
        array($ACTIVESTATUSSUBMENU, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insRoleaccount($FLG, $CONDITION1, $ROLEID, $USERNAME, $PASSWORD, $EMPLOYEEID, $REMARK, $ACTIVESTATUSACCOUNT) {
    $conn = connect("RTMS");
    $sql = "{call megRoleaccount_v2(?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($ROLEID, SQLSRV_PARAM_IN),
        array($USERNAME, SQLSRV_PARAM_IN),
        array($PASSWORD, SQLSRV_PARAM_IN),
        array($EMPLOYEEID, SQLSRV_PARAM_IN),
        array($REMARK, SQLSRV_PARAM_IN),
        array($ACTIVESTATUSACCOUNT, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insRolemenu($FLG, $CONDITION1, $ROLEID, $MENUID, $SUBMENUID, $PERMISSIONS, $REMARK, $ACTIVESTATUS) {
    $conn = connect("RTMS");
    $sql = "{call megRolemenu_v2(?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($ROLEID, SQLSRV_PARAM_IN),
        array($MENUID, SQLSRV_PARAM_IN),
        array($SUBMENUID, SQLSRV_PARAM_IN),
        array($PERMISSIONS, SQLSRV_PARAM_IN),
        array($REMARK, SQLSRV_PARAM_IN),
        array($ACTIVESTATUS, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insTenko($FLG, $CONDITION1, $EMPLOYEEID, $EMPLOYEENAME, $COMPANYCODE, $COMPANYNAME, $SECTION, $ISSUE, $TENKO, $REFORMATION, $RESPONSIBLEPERSONID, $FINISHDATE, $DATEINPUT, $STATUS, $REMARK) {
    $conn = connect("RTMS");
    $sql = "{call megTenko_v2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($EMPLOYEEID, SQLSRV_PARAM_IN),
        array($EMPLOYEENAME, SQLSRV_PARAM_IN),
        array($COMPANYCODE, SQLSRV_PARAM_IN),
        array($COMPANYNAME, SQLSRV_PARAM_IN),
        array($SECTION, SQLSRV_PARAM_IN),
        array($ISSUE, SQLSRV_PARAM_IN),
        array($TENKO, SQLSRV_PARAM_IN),
        array($REFORMATION, SQLSRV_PARAM_IN),
        array($RESPONSIBLEPERSONID, SQLSRV_PARAM_IN),
        array($FINISHDATE, SQLSRV_PARAM_IN),
        array($DATEINPUT, SQLSRV_PARAM_IN),
        array($STATUS, SQLSRV_PARAM_IN),
        array($REMARK, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insEmployee($FLG, $CONDITION1, $CONDITION2, $CONDITION3, $CONDITION4, $CONDITION5, $TYPE_INS, $IMAGENAME, $FILENAME, $BLOODGROUP, $SEX, $PREFIXCODE, $FIRSTNAMETHAI, $LASTNAMETHAI, $FIRSTNAMEENG, $LASTNAMEENG, $BIRTHDAY, $WEIGHT, $HEIGHT, $NATIONALITY, $RACE, $RELIGION, $MOBILENUMBER1, $MOBILENUMBER2, $EMAILADDRESS, $ACTIVESTATUS_EMP, $CARDTYPECODE, $CARDNUMBER, $ISSUEDATE, $EXPIREDATE, $ISSUEPLACE, $ALERTDATE, $ALERTMESSAGE, $ALERTEMAILADDRESS, $ACTIVESTATUS_CARD, $EMPLOYEECODE, $COMPANYCODE, $DIVISIONCODE, $DEPARTMENTCODE, $POSITIONCODE, $STARTDATE, $ENDDATE, $REMARK, $ACTIVESTATUS_COMP, $COURSETYPECODE, $INSTITUTION, $AUTHENTICATE, $AUTHENTICATEYEAR, $COSTVALUES, $TRAININGREMARK, $ACTIVESTATUS_TRAINING, $ADDRESSTYPECODE, $ADDRESSNO, $VILLAGE, $FLOOR, $STREET, $SIDESTREET, $PHONE, $DISTRICTCODE, $PREFECTURECODE, $PROVINCECODE, $ZIPCODE, $FULLADDRESS, $DESCRIPTIONS, $ACTIVESTATUS_ADDRESS
) {
    $conn = connect("RTMS");
    $sql = "{call megEmployee(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($CONDITION2, SQLSRV_PARAM_IN),
        array($CONDITION3, SQLSRV_PARAM_IN),
        array($CONDITION4, SQLSRV_PARAM_IN),
        array($CONDITION5, SQLSRV_PARAM_IN),
        array($TYPE_INS, SQLSRV_PARAM_IN),
        array($IMAGENAME, SQLSRV_PARAM_IN),
        array($FILENAME, SQLSRV_PARAM_IN),
        array($BLOODGROUP, SQLSRV_PARAM_IN),
        array($SEX, SQLSRV_PARAM_IN),
        array($PREFIXCODE, SQLSRV_PARAM_IN),
        array($FIRSTNAMETHAI, SQLSRV_PARAM_IN),
        array($LASTNAMETHAI, SQLSRV_PARAM_IN),
        array($FIRSTNAMEENG, SQLSRV_PARAM_IN),
        array($LASTNAMEENG, SQLSRV_PARAM_IN),
        array($BIRTHDAY, SQLSRV_PARAM_IN),
        array($WEIGHT, SQLSRV_PARAM_IN),
        array($HEIGHT, SQLSRV_PARAM_IN),
        array($NATIONALITY, SQLSRV_PARAM_IN),
        array($RACE, SQLSRV_PARAM_IN),
        array($RELIGION, SQLSRV_PARAM_IN),
        array($MOBILENUMBER1, SQLSRV_PARAM_IN),
        array($MOBILENUMBER2, SQLSRV_PARAM_IN),
        array($EMAILADDRESS, SQLSRV_PARAM_IN),
        array($ACTIVESTATUS_EMP, SQLSRV_PARAM_IN),
        array($CARDTYPECODE, SQLSRV_PARAM_IN),
        array($CARDNUMBER, SQLSRV_PARAM_IN),
        array($ISSUEDATE, SQLSRV_PARAM_IN),
        array($EXPIREDATE, SQLSRV_PARAM_IN),
        array($ISSUEPLACE, SQLSRV_PARAM_IN),
        array($ALERTDATE, SQLSRV_PARAM_IN),
        array($ALERTEMAILADDRESS, SQLSRV_PARAM_IN),
        array($ALERTMESSAGE, SQLSRV_PARAM_IN),
        array($ACTIVESTATUS_CARD, SQLSRV_PARAM_IN),
        array($EMPLOYEECODE, SQLSRV_PARAM_IN),
        array($COMPANYCODE, SQLSRV_PARAM_IN),
        array($DIVISIONCODE, SQLSRV_PARAM_IN),
        array($DEPARTMENTCODE, SQLSRV_PARAM_IN),
        array($POSITIONCODE, SQLSRV_PARAM_IN),
        array($STARTDATE, SQLSRV_PARAM_IN),
        array($ENDDATE, SQLSRV_PARAM_IN),
        array($REMARK, SQLSRV_PARAM_IN),
        array($ACTIVESTATUS_COMP, SQLSRV_PARAM_IN),
        array($COURSETYPECODE, SQLSRV_PARAM_IN),
        array($INSTITUTION, SQLSRV_PARAM_IN),
        array($AUTHENTICATE, SQLSRV_PARAM_IN),
        array($AUTHENTICATEYEAR, SQLSRV_PARAM_IN),
        array($COSTVALUES, SQLSRV_PARAM_IN),
        array($TRAININGREMARK, SQLSRV_PARAM_IN),
        array($ACTIVESTATUS_TRAINING, SQLSRV_PARAM_IN),
        array($ADDRESSTYPECODE, SQLSRV_PARAM_IN),
        array($ADDRESSNO, SQLSRV_PARAM_IN),
        array($VILLAGE, SQLSRV_PARAM_IN),
        array($FLOOR, SQLSRV_PARAM_IN),
        array($STREET, SQLSRV_PARAM_IN),
        array($SIDESTREET, SQLSRV_PARAM_IN),
        array($PHONE, SQLSRV_PARAM_IN),
        array($DISTRICTCODE, SQLSRV_PARAM_IN),
        array($PREFECTURECODE, SQLSRV_PARAM_IN),
        array($PROVINCECODE, SQLSRV_PARAM_IN),
        array($ZIPCODE, SQLSRV_PARAM_IN),
        array($FULLADDRESS, SQLSRV_PARAM_IN),
        array($DESCRIPTIONS, SQLSRV_PARAM_IN),
        array($ACTIVESTATUS_ADDRESS, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

//--NITI 16/11/61
function Update_Time_Data($FLG) {
    $conn = connect("RTMS");
    $sql = "{call megTimeattendancedetailEHR_v2(?)}";
    $params = array(array($FLG, SQLSRV_PARAM_IN));
    sqlsrv_query($conn, $sql, $params);
    sqlsrv_close($conn);
}

function select_time_data($sel, $PID, $dateSelect1, $dateSelect2) {
    $count = 1;
    $data = "";
    $font = "";
    $conn = connect(RTMS);
//$sqlr = "SELECT * FROM TIMEINOUTDETAIL WHERE PID = ? AND DATELOG BETWEEN ? AND ?";
//$sqlr = "SELECT * FROM TIMEINOUTDETAIL WHERE PID = $PID AND DATELOG BETWEEN '$dateSelect1' AND '$dateSelect2' ORDER BY DATELOG ASC";
    $sqlr = "{call megTimeattendancedetailEHR_v2(?,?,?,?)}";
    $params = array(
        array($sel, SQLSRV_PARAM_IN),
        array($PID, SQLSRV_PARAM_IN),
        array($dateSelect1, SQLSRV_PARAM_IN),
        array($dateSelect2, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sqlr, $params);

    while ($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        if ($result['ST'] == 'OK') {
            $font = "<font color='blue'>OK</font>";
        } else {
            $font = "<font color='red'>LATE</font>";
        }

        $data .= "<tr><td>" . $count . "</td><td>" . $result['TIMELOG'] . "</td><td>" . $result['DATELOG'] . "</td><td>" . $font . "</td></tr>";
        $count++;
    }
    sqlsrv_close($conn);
    return $data;
}

?>
