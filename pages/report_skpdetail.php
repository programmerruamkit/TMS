<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");


// Driving Pattern แผนขาไป
if ($_POST['txt_flg'] == "create_drivingpatterngoplanid") {


  $sql_creategoplanid = "{call megDrivingPatternDriver(?,?,?,?,?,?,?)}"; 
  $params_creategoplanid = array(
  array('create_drivingpatterngoplanid', SQLSRV_PARAM_IN),
  array($_POST['employeecode'], SQLSRV_PARAM_IN),
  array($_POST['condition1'], SQLSRV_PARAM_IN),
  array($_POST['condition2'], SQLSRV_PARAM_IN),
  array($_POST['condition3'], SQLSRV_PARAM_IN),
  array($_POST['condition4'], SQLSRV_PARAM_IN),
  array($_POST['condition5'], SQLSRV_PARAM_IN)
  );

  $query_creategoplanid = sqlsrv_query($conn, $sql_creategoplanid, $params_creategoplanid);
  $result_creategoplanid = sqlsrv_fetch_array($query_creategoplanid, SQLSRV_FETCH_ASSOC);
  echo $result_creategoplanid['RS'];

}
if ($_POST['txt_flg'] == "save_drivingpatternplango") {

    // COUNT PARAM 89
    $sql_saveDrivingPlanGo = "{call megEditDrivingPatternDriver(?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?
                                                                )}"; 
    $params_saveDrivingPlanGo = array(
    array('save_drivingpatternplango', SQLSRV_PARAM_IN),
    array($_POST['drivingplangoid'], SQLSRV_PARAM_IN),
    array($_POST['employeecode1'], SQLSRV_PARAM_IN),
    array($_POST['employeename1'], SQLSRV_PARAM_IN),
    array($_POST['employeecode2'], SQLSRV_PARAM_IN),
    array($_POST['employeename2'], SQLSRV_PARAM_IN),
    array($_POST['thainame'], SQLSRV_PARAM_IN),
    array($_POST['planningroute'], SQLSRV_PARAM_IN),
    array($_POST['actualroute'], SQLSRV_PARAM_IN),
    array($_POST['officercheck'], SQLSRV_PARAM_IN),

    array($_POST['planid1'], SQLSRV_PARAM_IN),
    array($_POST['planid2'], SQLSRV_PARAM_IN),
    array($_POST['drivingdate'], SQLSRV_PARAM_IN),
    array($_POST['tnkp_check'], SQLSRV_PARAM_IN),
    array($_POST['tubon_check'], SQLSRV_PARAM_IN),
    array($_POST['tthaiyen_check'], SQLSRV_PARAM_IN),
    array($_POST['tkan_check'], SQLSRV_PARAM_IN),
    array($_POST['jobstartplan'], SQLSRV_PARAM_IN),
    array($_POST['datestartplan'], SQLSRV_PARAM_IN),

    array($_POST['drivernamep1'], SQLSRV_PARAM_IN),
    array($_POST['datestartplanp1'], SQLSRV_PARAM_IN),
    array($_POST['parkngtime_plan_4hurs_p1'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_4hurs_p1'], SQLSRV_PARAM_IN),
    array($_POST['location4hurp1'], SQLSRV_PARAM_IN),
    array($_POST['parkngtime_plan_2hurs_p1'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_2hurs_p1'], SQLSRV_PARAM_IN),
    array($_POST['location2hurp1'], SQLSRV_PARAM_IN),

    array($_POST['drivernamep2'], SQLSRV_PARAM_IN),
    array($_POST['datestartplanp2'], SQLSRV_PARAM_IN),
    array($_POST['parkngtime_plan_4hurs_p2'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_4hurs_p2'], SQLSRV_PARAM_IN),
    array($_POST['location4hurp2'], SQLSRV_PARAM_IN),
    array($_POST['parkngtime_plan_2hurs_p2'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_2hurs_p2'], SQLSRV_PARAM_IN),
    array($_POST['location2hurp2'], SQLSRV_PARAM_IN),

    array($_POST['drivernamep3'], SQLSRV_PARAM_IN),
    array($_POST['datestartplanp3'], SQLSRV_PARAM_IN),
    array($_POST['parkngtime_plan_4hurs_p3'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_4hurs_p3'], SQLSRV_PARAM_IN),
    array($_POST['location4hurp3'], SQLSRV_PARAM_IN),
    array($_POST['parkngtime_plan_2hurs_p3'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_2hurs_p3'], SQLSRV_PARAM_IN),
    array($_POST['location2hurp3'], SQLSRV_PARAM_IN),

    array($_POST['drivernamep4'], SQLSRV_PARAM_IN),
    array($_POST['datestartplanp4'], SQLSRV_PARAM_IN),
    array($_POST['parkngtime_plan_4hurs_p4'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_4hurs_p4'], SQLSRV_PARAM_IN),
    array($_POST['location4hurp4'], SQLSRV_PARAM_IN),
    array($_POST['parkngtime_plan_2hurs_p4'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_2hurs_p4'], SQLSRV_PARAM_IN),
    array($_POST['location2hurp4'], SQLSRV_PARAM_IN),

    array($_POST['drivernamep5'], SQLSRV_PARAM_IN),
    array($_POST['datestartplanp5'], SQLSRV_PARAM_IN),
    array($_POST['parkngtime_plan_4hurs_p5'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_4hurs_p5'], SQLSRV_PARAM_IN),
    array($_POST['location4hurp5'], SQLSRV_PARAM_IN),
    array($_POST['parkngtime_plan_2hurs_p5'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_2hurs_p5'], SQLSRV_PARAM_IN),
    array($_POST['location2hurp5'], SQLSRV_PARAM_IN),

    array($_POST['drivernamep6'], SQLSRV_PARAM_IN),
    array($_POST['datestartplanp6'], SQLSRV_PARAM_IN),
    array($_POST['parkngtime_plan_4hurs_p6'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_4hurs_p6'], SQLSRV_PARAM_IN),
    array($_POST['location4hurp6'], SQLSRV_PARAM_IN),
    array($_POST['parkngtime_plan_2hurs_p6'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_2hurs_p6'], SQLSRV_PARAM_IN),
    array($_POST['location2hurp6'], SQLSRV_PARAM_IN),

    array($_POST['dealer1plan'], SQLSRV_PARAM_IN),
    array($_POST['sumtimedealer1'], SQLSRV_PARAM_IN),
    array($_POST['parkingtime_plan_dealer1'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_dealer1'], SQLSRV_PARAM_IN),
    
    array($_POST['dealer2plan'], SQLSRV_PARAM_IN),
    array($_POST['sumtimedealer2'], SQLSRV_PARAM_IN),
    array($_POST['parkingtime_plan_dealer2'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_dealer2'], SQLSRV_PARAM_IN),

    array($_POST['dealer3plan'], SQLSRV_PARAM_IN),
    array($_POST['sumtimedealer3'], SQLSRV_PARAM_IN),
    array($_POST['parkingtime_plan_dealer3'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_dealer3'], SQLSRV_PARAM_IN),

    array($_POST['dealer4plan'], SQLSRV_PARAM_IN),
    array($_POST['sumtimedealer4'], SQLSRV_PARAM_IN),
    array($_POST['parkingtime_plan_dealer4'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_dealer4'], SQLSRV_PARAM_IN),

    array($_POST['createby'], SQLSRV_PARAM_IN),
    array($_POST['createdate'], SQLSRV_PARAM_IN),
    array($_POST['modifiedby'], SQLSRV_PARAM_IN),
    array($_POST['modifieddate'], SQLSRV_PARAM_IN),
    array($_POST['confirmedby'], SQLSRV_PARAM_IN),
    array($_POST['confirmgddate'], SQLSRV_PARAM_IN)

    );
  
    $query_saveDrivingPlanGo  = sqlsrv_query($conn, $sql_saveDrivingPlanGo, $params_saveDrivingPlanGo);
    $result_saveDrivingPlanGo = sqlsrv_fetch_array($query_saveDrivingPlanGo, SQLSRV_FETCH_ASSOC);
    // echo $result_saveDrivingPlanGo['RS'];
  
}
// START TIMECHECK P1
if ($_POST['txt_flg'] == "cal_parkingtime_plan_4hrs_p1") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
if ($_POST['txt_flg'] == "cal_parkingtime_plan_2hrs_p1") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
// START TIMECHECK P2
if ($_POST['txt_flg'] == "cal_parkingtime_plan_4hrs_p2") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
if ($_POST['txt_flg'] == "cal_parkingtime_plan_2hrs_p2") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
// START TIMECHECK P3
if ($_POST['txt_flg'] == "cal_parkingtime_plan_4hrs_p3") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
if ($_POST['txt_flg'] == "cal_parkingtime_plan_2hrs_p3") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
// START TIMECHECK P4
if ($_POST['txt_flg'] == "cal_parkingtime_plan_4hrs_p4") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
if ($_POST['txt_flg'] == "cal_parkingtime_plan_2hrs_p4") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
// START TIMECHECK P5
if ($_POST['txt_flg'] == "cal_parkingtime_plan_4hrs_p5") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
if ($_POST['txt_flg'] == "cal_parkingtime_plan_2hrs_p5") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
// START TIMECHECK P6
if ($_POST['txt_flg'] == "cal_parkingtime_plan_4hrs_p6") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
if ($_POST['txt_flg'] == "cal_parkingtime_plan_2hrs_p6") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
if ($_POST['txt_flg'] == "select_timedealer") {
    //$sql = "SELECT DATEDIFF(HOUR,'" . $_POST['startsleep'] . "','" . $_POST['endsleep'] . "')  AS 'TIMEREST'";
    //$sql = "SELECT DATEDIFF(HOUR,'" . $_POST['startsleep'] . "','" . $_POST['endsleep'] . "')  AS 'TIMEREST',
    //          RIGHT(CONVERT(VARCHAR(5), DATEADD(MINUTE, DATEDIFF(MINUTE, '" . $_POST['startsleep'] . "', '" . $_POST['endsleep'] . "'), 0), 114),2) AS 'TIMEREST2'";
    //$sql = "SELECT CONVERT(VARCHAR(5), DATEADD(MINUTE, DATEDIFF(MINUTE, '" . $_POST['startrest'] . "', '" . $_POST['endrest'] . "'), 0), 114) AS 'TIMEREST'";
     // $sql = "SELECT CASE WHEN CONVERT(VARCHAR(3), DATEDIFF(MINUTE, '" . $_POST['startsleep'] . "', '" . $_POST['endsleep'] . "') / 60) > 59 THEN CONVERT(VARCHAR(3), DATEDIFF(MINUTE, '" . $_POST['startsleep'] . "', '" . $_POST['endsleep'] . "') / 60) ELSE CONVERT(VARCHAR(3), DATEDIFF(MINUTE, '" . $_POST['startsleep'] . "', '" . $_POST['endsleep'] . "') / 60 % 60) END+':'+CONVERT(VARCHAR(3), DATEDIFF(MINUTE, '" . $_POST['startsleep'] . "', '" . $_POST['endsleep'] . "') % 60) AS 'TIMEREST'";
      $sql = "SELECT CASE WHEN CONVERT(VARCHAR(3), DATEDIFF(MINUTE, CONVERT(NVARCHAR(10),'" . $_POST['parkingtimechk'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['parkingtimechk'] . "',14),5), CONVERT(NVARCHAR(10),'" . $_POST['departuretimechk'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['departuretimechk'] . "',14),5)) / 60) > 59 THEN CONVERT(VARCHAR(3), 
      DATEDIFF(MINUTE, CONVERT(NVARCHAR(10),'" . $_POST['parkingtimechk'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['parkingtimechk'] . "',14),5), CONVERT(NVARCHAR(10),'" . $_POST['departuretimechk'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['departuretimechk'] . "',14),5)) / 60) ELSE CONVERT(VARCHAR(3), 
      DATEDIFF(MINUTE, CONVERT(NVARCHAR(10),'" . $_POST['parkingtimechk'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['parkingtimechk'] . "',14),5), CONVERT(NVARCHAR(10),'" . $_POST['departuretimechk'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['departuretimechk'] . "',14),5)) / 60 % 60) END+':'
      +CONVERT(VARCHAR(3), DATEDIFF(MINUTE, CONVERT(NVARCHAR(10),'" . $_POST['parkingtimechk'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['parkingtimechk'] . "',14),5), CONVERT(NVARCHAR(10),'" . $_POST['departuretimechk'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['departuretimechk'] . "',14),5)) % 60) AS 'TIMEREST'";
      $query = sqlsrv_query($conn, $sql, $params);
      $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
      
      echo $result['TIMEREST'];
      
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
// START TIMECHECK ACTUAL P1
if ($_POST['txt_flg'] == "cal_parkingtime_actual_4hrs_p1") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
if ($_POST['txt_flg'] == "cal_parkingtime_actual_2hrs_p1") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
// START TIMECHECK ACTUAL P2
if ($_POST['txt_flg'] == "cal_parkingtime_actual_4hrs_p2") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
if ($_POST['txt_flg'] == "cal_parkingtime_actual_2hrs_p2") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
// START TIMECHECK ACTUAL P3
if ($_POST['txt_flg'] == "cal_parkingtime_actual_4hrs_p3") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
if ($_POST['txt_flg'] == "cal_parkingtime_actual_2hrs_p3") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
// START TIMECHECK ACTUAL P4
if ($_POST['txt_flg'] == "cal_parkingtime_actual_4hrs_p4") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
if ($_POST['txt_flg'] == "cal_parkingtime_actual_2hrs_p4") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
// START TIMECHECK ACTUAL P5
if ($_POST['txt_flg'] == "cal_parkingtime_actual_4hrs_p5") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
if ($_POST['txt_flg'] == "cal_parkingtime_actual_2hrs_p5") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
// START TIMECHECK ACTUAL P6
if ($_POST['txt_flg'] == "cal_parkingtime_actual_4hrs_p6") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
if ($_POST['txt_flg'] == "cal_parkingtime_actual_2hrs_p6") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
if ($_POST['txt_flg'] == "select_timedealeractual") {
    //$sql = "SELECT DATEDIFF(HOUR,'" . $_POST['startsleep'] . "','" . $_POST['endsleep'] . "')  AS 'TIMEREST'";
    //$sql = "SELECT DATEDIFF(HOUR,'" . $_POST['startsleep'] . "','" . $_POST['endsleep'] . "')  AS 'TIMEREST',
    //          RIGHT(CONVERT(VARCHAR(5), DATEADD(MINUTE, DATEDIFF(MINUTE, '" . $_POST['startsleep'] . "', '" . $_POST['endsleep'] . "'), 0), 114),2) AS 'TIMEREST2'";
    //$sql = "SELECT CONVERT(VARCHAR(5), DATEADD(MINUTE, DATEDIFF(MINUTE, '" . $_POST['startrest'] . "', '" . $_POST['endrest'] . "'), 0), 114) AS 'TIMEREST'";
     // $sql = "SELECT CASE WHEN CONVERT(VARCHAR(3), DATEDIFF(MINUTE, '" . $_POST['startsleep'] . "', '" . $_POST['endsleep'] . "') / 60) > 59 THEN CONVERT(VARCHAR(3), DATEDIFF(MINUTE, '" . $_POST['startsleep'] . "', '" . $_POST['endsleep'] . "') / 60) ELSE CONVERT(VARCHAR(3), DATEDIFF(MINUTE, '" . $_POST['startsleep'] . "', '" . $_POST['endsleep'] . "') / 60 % 60) END+':'+CONVERT(VARCHAR(3), DATEDIFF(MINUTE, '" . $_POST['startsleep'] . "', '" . $_POST['endsleep'] . "') % 60) AS 'TIMEREST'";
      $sql = "SELECT CASE WHEN CONVERT(VARCHAR(3), DATEDIFF(MINUTE, CONVERT(NVARCHAR(10),'" . $_POST['parkingtimechk'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['parkingtimechk'] . "',14),5), CONVERT(NVARCHAR(10),'" . $_POST['departuretimechk'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['departuretimechk'] . "',14),5)) / 60) > 59 THEN CONVERT(VARCHAR(3), 
      DATEDIFF(MINUTE, CONVERT(NVARCHAR(10),'" . $_POST['parkingtimechk'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['parkingtimechk'] . "',14),5), CONVERT(NVARCHAR(10),'" . $_POST['departuretimechk'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['departuretimechk'] . "',14),5)) / 60) ELSE CONVERT(VARCHAR(3), 
      DATEDIFF(MINUTE, CONVERT(NVARCHAR(10),'" . $_POST['parkingtimechk'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['parkingtimechk'] . "',14),5), CONVERT(NVARCHAR(10),'" . $_POST['departuretimechk'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['departuretimechk'] . "',14),5)) / 60 % 60) END+':'
      +CONVERT(VARCHAR(3), DATEDIFF(MINUTE, CONVERT(NVARCHAR(10),'" . $_POST['parkingtimechk'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['parkingtimechk'] . "',14),5), CONVERT(NVARCHAR(10),'" . $_POST['departuretimechk'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['departuretimechk'] . "',14),5)) % 60) AS 'TIMEREST'";
      $query = sqlsrv_query($conn, $sql, $params);
      $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
      
      echo $result['TIMEREST'];
      
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Driving Pattern แผนขากลับ
if ($_POST['txt_flg'] == "create_drivingpatternbackplanid") {


    $sql_createbackplanid = "{call megDrivingPatternDriver(?,?,?,?,?,?,?)}"; 
    $params_createbackplanid = array(
    array('create_drivingpatternbackplanid', SQLSRV_PARAM_IN),
    array($_POST['employeecode'], SQLSRV_PARAM_IN),
    array($_POST['condition1'], SQLSRV_PARAM_IN),
    array($_POST['condition2'], SQLSRV_PARAM_IN),
    array($_POST['condition3'], SQLSRV_PARAM_IN),
    array($_POST['condition4'], SQLSRV_PARAM_IN),
    array($_POST['condition5'], SQLSRV_PARAM_IN)
    );
  
    $query_createbackplanid = sqlsrv_query($conn, $sql_createbackplanid, $params_createbackplanid);
    $result_createbackplanid = sqlsrv_fetch_array($query_createbackplanid, SQLSRV_FETCH_ASSOC);
    echo $result_createbackplanid['RS'];
  
}
if ($_POST['txt_flg'] == "save_drivingpatternplanback") {

    // COUNT PARAM 89
    $sql_saveDrivingPlanBack = "{call megEditDrivingPatternDriver(?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?
                                                                )}"; 
    $params_saveDrivingPlanBack = array(
    array('save_drivingpatternplanback', SQLSRV_PARAM_IN),
    array($_POST['drivingplanbackid'], SQLSRV_PARAM_IN),
    array($_POST['employeecode1'], SQLSRV_PARAM_IN),
    array($_POST['employeename1'], SQLSRV_PARAM_IN),
    array($_POST['employeecode2'], SQLSRV_PARAM_IN),
    array($_POST['employeename2'], SQLSRV_PARAM_IN),
    array($_POST['thainame'], SQLSRV_PARAM_IN),
    array($_POST['planningroute'], SQLSRV_PARAM_IN),
    array($_POST['actualroute'], SQLSRV_PARAM_IN),
    array($_POST['officercheck'], SQLSRV_PARAM_IN),

    array($_POST['planid1'], SQLSRV_PARAM_IN),
    array($_POST['planid2'], SQLSRV_PARAM_IN),
    array($_POST['drivingdate'], SQLSRV_PARAM_IN),
    array($_POST['tnkp_check'], SQLSRV_PARAM_IN),
    array($_POST['tubon_check'], SQLSRV_PARAM_IN),
    array($_POST['tthaiyen_check'], SQLSRV_PARAM_IN),
    array($_POST['tkan_check'], SQLSRV_PARAM_IN),
    array($_POST['jobstartplan'], SQLSRV_PARAM_IN),
    array($_POST['datestartplan'], SQLSRV_PARAM_IN),

    array($_POST['drivernamep1'], SQLSRV_PARAM_IN),
    array($_POST['datestartplanp1'], SQLSRV_PARAM_IN),
    array($_POST['parkngtime_plan_4hurs_p1'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_4hurs_p1'], SQLSRV_PARAM_IN),
    array($_POST['location4hurp1'], SQLSRV_PARAM_IN),
    array($_POST['parkngtime_plan_2hurs_p1'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_2hurs_p1'], SQLSRV_PARAM_IN),
    array($_POST['location2hurp1'], SQLSRV_PARAM_IN),

    array($_POST['drivernamep2'], SQLSRV_PARAM_IN),
    array($_POST['datestartplanp2'], SQLSRV_PARAM_IN),
    array($_POST['parkngtime_plan_4hurs_p2'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_4hurs_p2'], SQLSRV_PARAM_IN),
    array($_POST['location4hurp2'], SQLSRV_PARAM_IN),
    array($_POST['parkngtime_plan_2hurs_p2'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_2hurs_p2'], SQLSRV_PARAM_IN),
    array($_POST['location2hurp2'], SQLSRV_PARAM_IN),

    array($_POST['drivernamep3'], SQLSRV_PARAM_IN),
    array($_POST['datestartplanp3'], SQLSRV_PARAM_IN),
    array($_POST['parkngtime_plan_4hurs_p3'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_4hurs_p3'], SQLSRV_PARAM_IN),
    array($_POST['location4hurp3'], SQLSRV_PARAM_IN),
    array($_POST['parkngtime_plan_2hurs_p3'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_2hurs_p3'], SQLSRV_PARAM_IN),
    array($_POST['location2hurp3'], SQLSRV_PARAM_IN),

    array($_POST['drivernamep4'], SQLSRV_PARAM_IN),
    array($_POST['datestartplanp4'], SQLSRV_PARAM_IN),
    array($_POST['parkngtime_plan_4hurs_p4'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_4hurs_p4'], SQLSRV_PARAM_IN),
    array($_POST['location4hurp4'], SQLSRV_PARAM_IN),
    array($_POST['parkngtime_plan_2hurs_p4'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_2hurs_p4'], SQLSRV_PARAM_IN),
    array($_POST['location2hurp4'], SQLSRV_PARAM_IN),

    array($_POST['drivernamep5'], SQLSRV_PARAM_IN),
    array($_POST['datestartplanp5'], SQLSRV_PARAM_IN),
    array($_POST['parkngtime_plan_4hurs_p5'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_4hurs_p5'], SQLSRV_PARAM_IN),
    array($_POST['location4hurp5'], SQLSRV_PARAM_IN),
    array($_POST['parkngtime_plan_2hurs_p5'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_2hurs_p5'], SQLSRV_PARAM_IN),
    array($_POST['location2hurp5'], SQLSRV_PARAM_IN),

    array($_POST['drivernamep6'], SQLSRV_PARAM_IN),
    array($_POST['datestartplanp6'], SQLSRV_PARAM_IN),
    array($_POST['parkngtime_plan_4hurs_p6'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_4hurs_p6'], SQLSRV_PARAM_IN),
    array($_POST['location4hurp6'], SQLSRV_PARAM_IN),
    array($_POST['parkngtime_plan_2hurs_p6'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_2hurs_p6'], SQLSRV_PARAM_IN),
    array($_POST['location2hurp6'], SQLSRV_PARAM_IN),

    array($_POST['dealer1plan'], SQLSRV_PARAM_IN),
    array($_POST['sumtimedealer1'], SQLSRV_PARAM_IN),
    array($_POST['parkingtime_plan_dealer1'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_dealer1'], SQLSRV_PARAM_IN),
    
    array($_POST['dealer2plan'], SQLSRV_PARAM_IN),
    array($_POST['sumtimedealer2'], SQLSRV_PARAM_IN),
    array($_POST['parkingtime_plan_dealer2'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_dealer2'], SQLSRV_PARAM_IN),

    array($_POST['dealer3plan'], SQLSRV_PARAM_IN),
    array($_POST['sumtimedealer3'], SQLSRV_PARAM_IN),
    array($_POST['parkingtime_plan_dealer3'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_dealer3'], SQLSRV_PARAM_IN),

    array($_POST['dealer4plan'], SQLSRV_PARAM_IN),
    array($_POST['sumtimedealer4'], SQLSRV_PARAM_IN),
    array($_POST['parkingtime_plan_dealer4'], SQLSRV_PARAM_IN),
    array($_POST['departuretime_plan_dealer4'], SQLSRV_PARAM_IN),

    array($_POST['createby'], SQLSRV_PARAM_IN),
    array($_POST['createdate'], SQLSRV_PARAM_IN),
    array($_POST['modifiedby'], SQLSRV_PARAM_IN),
    array($_POST['modifieddate'], SQLSRV_PARAM_IN),
    array($_POST['confirmedby'], SQLSRV_PARAM_IN),
    array($_POST['confirmgddate'], SQLSRV_PARAM_IN)

    );
  
    $query_saveDrivingPlanBack  = sqlsrv_query($conn, $sql_saveDrivingPlanBack, $params_saveDrivingPlanBack);
    $result_saveDrivingPlanBack = sqlsrv_fetch_array($query_saveDrivingPlanBack, SQLSRV_FETCH_ASSOC);
    // echo $result_saveDrivingPlanGo['RS'];
  
}
// START TIMECHECK P1
if ($_POST['txt_flg'] == "cal_parkingtime_plan_4hrs_p1_back") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
if ($_POST['txt_flg'] == "cal_parkingtime_plan_2hrs_p1_back") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
// START TIMECHECK P2
if ($_POST['txt_flg'] == "cal_parkingtime_plan_4hrs_p2_back") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
if ($_POST['txt_flg'] == "cal_parkingtime_plan_2hrs_p2_back") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
// START TIMECHECK P3
if ($_POST['txt_flg'] == "cal_parkingtime_plan_4hrs_p3_back") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
if ($_POST['txt_flg'] == "cal_parkingtime_plan_2hrs_p3_back") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
// START TIMECHECK P4
if ($_POST['txt_flg'] == "cal_parkingtime_plan_4hrs_p4_back") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
if ($_POST['txt_flg'] == "cal_parkingtime_plan_2hrs_p4_back") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
// START TIMECHECK P5
if ($_POST['txt_flg'] == "cal_parkingtime_plan_4hrs_p5_back") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
if ($_POST['txt_flg'] == "cal_parkingtime_plan_2hrs_p5_back") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
// START TIMECHECK P6
if ($_POST['txt_flg'] == "cal_parkingtime_plan_4hrs_p6_back") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
if ($_POST['txt_flg'] == "cal_parkingtime_plan_2hrs_p6_back") {


    // $conn = connect("RTMS");

    $sql = "SELECT FORMAT (CONVERT(DATETIME,DATEADD(MINUTE,30,'" . $_POST['startdatetimechk'] . "'),103), 'yyyy/MM/dd HH:mm')   AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo $result['RS'];
  
}
if ($_POST['txt_flg'] == "select_timevl") {
    //$sql = "SELECT DATEDIFF(HOUR,'" . $_POST['startsleep'] . "','" . $_POST['endsleep'] . "')  AS 'TIMEREST'";
    //$sql = "SELECT DATEDIFF(HOUR,'" . $_POST['startsleep'] . "','" . $_POST['endsleep'] . "')  AS 'TIMEREST',
    //          RIGHT(CONVERT(VARCHAR(5), DATEADD(MINUTE, DATEDIFF(MINUTE, '" . $_POST['startsleep'] . "', '" . $_POST['endsleep'] . "'), 0), 114),2) AS 'TIMEREST2'";
    //$sql = "SELECT CONVERT(VARCHAR(5), DATEADD(MINUTE, DATEDIFF(MINUTE, '" . $_POST['startrest'] . "', '" . $_POST['endrest'] . "'), 0), 114) AS 'TIMEREST'";
     // $sql = "SELECT CASE WHEN CONVERT(VARCHAR(3), DATEDIFF(MINUTE, '" . $_POST['startsleep'] . "', '" . $_POST['endsleep'] . "') / 60) > 59 THEN CONVERT(VARCHAR(3), DATEDIFF(MINUTE, '" . $_POST['startsleep'] . "', '" . $_POST['endsleep'] . "') / 60) ELSE CONVERT(VARCHAR(3), DATEDIFF(MINUTE, '" . $_POST['startsleep'] . "', '" . $_POST['endsleep'] . "') / 60 % 60) END+':'+CONVERT(VARCHAR(3), DATEDIFF(MINUTE, '" . $_POST['startsleep'] . "', '" . $_POST['endsleep'] . "') % 60) AS 'TIMEREST'";
      $sql = "SELECT CASE WHEN CONVERT(VARCHAR(3), DATEDIFF(MINUTE, CONVERT(NVARCHAR(10),'" . $_POST['parkingtimechk'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['parkingtimechk'] . "',14),5), CONVERT(NVARCHAR(10),'" . $_POST['departuretimechk'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['departuretimechk'] . "',14),5)) / 60) > 59 THEN CONVERT(VARCHAR(3), 
      DATEDIFF(MINUTE, CONVERT(NVARCHAR(10),'" . $_POST['parkingtimechk'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['parkingtimechk'] . "',14),5), CONVERT(NVARCHAR(10),'" . $_POST['departuretimechk'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['departuretimechk'] . "',14),5)) / 60) ELSE CONVERT(VARCHAR(3), 
      DATEDIFF(MINUTE, CONVERT(NVARCHAR(10),'" . $_POST['parkingtimechk'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['parkingtimechk'] . "',14),5), CONVERT(NVARCHAR(10),'" . $_POST['departuretimechk'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['departuretimechk'] . "',14),5)) / 60 % 60) END+':'
      +CONVERT(VARCHAR(3), DATEDIFF(MINUTE, CONVERT(NVARCHAR(10),'" . $_POST['parkingtimechk'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['parkingtimechk'] . "',14),5), CONVERT(NVARCHAR(10),'" . $_POST['departuretimechk'] . "',103)+' '+RIGHT(CONVERT(NVARCHAR(30),'" . $_POST['departuretimechk'] . "',14),5)) % 60) AS 'TIMEREST'";
      $query = sqlsrv_query($conn, $sql, $params);
      $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
      
      echo $result['TIMEREST'];
      
}
// CONFIRMED BUTTON 
if ($_POST['txt_flg'] == "save_confirm_p1") {


    $sql_confirmp1 = "{call megDrivingPatternDriver(?,?,?,?,?,?,?)}"; 
    $params_confirmp1 = array(
    array('save_confirm_p1', SQLSRV_PARAM_IN),
    array($_POST['employeecode'], SQLSRV_PARAM_IN),
    array($_POST['condition1'], SQLSRV_PARAM_IN),
    array($_POST['condition2'], SQLSRV_PARAM_IN),
    array($_POST['condition3'], SQLSRV_PARAM_IN),
    array($_POST['condition4'], SQLSRV_PARAM_IN),
    array($_POST['condition5'], SQLSRV_PARAM_IN)
    );
  
    $query_confirmp1 = sqlsrv_query($conn, $sql_confirmp1, $params_confirmp1);
    $result_confirmp1 = sqlsrv_fetch_array($query_confirmp1, SQLSRV_FETCH_ASSOC);
    echo $result_confirmp1['RS'];
  
}
// CONFIRMED BUTTON 
if ($_POST['txt_flg'] == "save_confirm_p2") {


    $sql_confirmp2 = "{call megDrivingPatternDriver(?,?,?,?,?,?,?)}"; 
    $params_confirmp2 = array(
    array('save_confirm_p2', SQLSRV_PARAM_IN),
    array($_POST['employeecode'], SQLSRV_PARAM_IN),
    array($_POST['condition1'], SQLSRV_PARAM_IN),
    array($_POST['condition2'], SQLSRV_PARAM_IN),
    array($_POST['condition3'], SQLSRV_PARAM_IN),
    array($_POST['condition4'], SQLSRV_PARAM_IN),
    array($_POST['condition5'], SQLSRV_PARAM_IN)
    );
  
    $query_confirmp2 = sqlsrv_query($conn, $sql_confirmp2, $params_confirmp2);
    $result_confirmp2 = sqlsrv_fetch_array($query_confirmp2, SQLSRV_FETCH_ASSOC);
    echo $result_confirmp2['RS'];
  
}
// CONFIRMED BUTTON 
if ($_POST['txt_flg'] == "save_confirm_p3") {


    $sql_confirmp3 = "{call megDrivingPatternDriver(?,?,?,?,?,?,?)}"; 
    $params_confirmp3 = array(
    array('save_confirm_p3', SQLSRV_PARAM_IN),
    array($_POST['employeecode'], SQLSRV_PARAM_IN),
    array($_POST['condition1'], SQLSRV_PARAM_IN),
    array($_POST['condition2'], SQLSRV_PARAM_IN),
    array($_POST['condition3'], SQLSRV_PARAM_IN),
    array($_POST['condition4'], SQLSRV_PARAM_IN),
    array($_POST['condition5'], SQLSRV_PARAM_IN)
    );
  
    $query_confirmp3 = sqlsrv_query($conn, $sql_confirmp3, $params_confirmp3);
    $result_confirmp3 = sqlsrv_fetch_array($query_confirmp3, SQLSRV_FETCH_ASSOC);
    echo $result_confirmp3['RS'];
  
}
// CONFIRMED BUTTON 
if ($_POST['txt_flg'] == "save_confirm_p4") {


    $sql_confirmp4 = "{call megDrivingPatternDriver(?,?,?,?,?,?,?)}"; 
    $params_confirmp4 = array(
    array('save_confirm_p4', SQLSRV_PARAM_IN),
    array($_POST['employeecode'], SQLSRV_PARAM_IN),
    array($_POST['condition1'], SQLSRV_PARAM_IN),
    array($_POST['condition2'], SQLSRV_PARAM_IN),
    array($_POST['condition3'], SQLSRV_PARAM_IN),
    array($_POST['condition4'], SQLSRV_PARAM_IN),
    array($_POST['condition5'], SQLSRV_PARAM_IN)
    );
  
    $query_confirmp4 = sqlsrv_query($conn, $sql_confirmp4, $params_confirmp4);
    $result_confirmp4 = sqlsrv_fetch_array($query_confirmp4, SQLSRV_FETCH_ASSOC);
    echo $result_confirmp4['RS'];
  
}
// CONFIRMED BUTTON 
if ($_POST['txt_flg'] == "save_confirm_p5") {


    $sql_confirmp5 = "{call megDrivingPatternDriver(?,?,?,?,?,?,?)}"; 
    $params_confirmp5 = array(
    array('save_confirm_p5', SQLSRV_PARAM_IN),
    array($_POST['employeecode'], SQLSRV_PARAM_IN),
    array($_POST['condition1'], SQLSRV_PARAM_IN),
    array($_POST['condition2'], SQLSRV_PARAM_IN),
    array($_POST['condition3'], SQLSRV_PARAM_IN),
    array($_POST['condition4'], SQLSRV_PARAM_IN),
    array($_POST['condition5'], SQLSRV_PARAM_IN)
    );
  
    $query_confirmp5 = sqlsrv_query($conn, $sql_confirmp5, $params_confirmp5);
    $result_confirmp5 = sqlsrv_fetch_array($query_confirmp5, SQLSRV_FETCH_ASSOC);
    echo $result_confirmp5['RS'];
  
}
// CONFIRMED BUTTON 
if ($_POST['txt_flg'] == "save_confirm_p6") {


    $sql_confirmp6 = "{call megDrivingPatternDriver(?,?,?,?,?,?,?)}"; 
    $params_confirmp6 = array(
    array('save_confirm_p6', SQLSRV_PARAM_IN),
    array($_POST['employeecode'], SQLSRV_PARAM_IN),
    array($_POST['condition1'], SQLSRV_PARAM_IN),
    array($_POST['condition2'], SQLSRV_PARAM_IN),
    array($_POST['condition3'], SQLSRV_PARAM_IN),
    array($_POST['condition4'], SQLSRV_PARAM_IN),
    array($_POST['condition5'], SQLSRV_PARAM_IN)
    );
  
    $query_confirmp6 = sqlsrv_query($conn, $sql_confirmp6, $params_confirmp6);
    $result_confirmp6 = sqlsrv_fetch_array($query_confirmp6, SQLSRV_FETCH_ASSOC);
    echo $result_confirmp6['RS'];
  
}
// CONFIRMED BUTTON 
if ($_POST['txt_flg'] == "save_confirm_actualload") {


    $sql_confirmactualload = "{call megDrivingPatternDriver(?,?,?,?,?,?,?)}"; 
    $params_confirmactualload = array(
    array('save_confirm_actualload', SQLSRV_PARAM_IN),
    array($_POST['employeecode'], SQLSRV_PARAM_IN),
    array($_POST['condition1'], SQLSRV_PARAM_IN),
    array($_POST['condition2'], SQLSRV_PARAM_IN),
    array($_POST['condition3'], SQLSRV_PARAM_IN),
    array($_POST['condition4'], SQLSRV_PARAM_IN),
    array($_POST['condition5'], SQLSRV_PARAM_IN)
    );
  
    $query_confirmactualload = sqlsrv_query($conn, $sql_confirmactualload, $params_confirmactualload);
    $result_confirmactualload = sqlsrv_fetch_array($query_confirmactualload, SQLSRV_FETCH_ASSOC);
    echo $result_confirmactualload['RS'];
  
}
// SAVE ACTUAL P1
if ($_POST['txt_flg'] == "save_actualp1") {


    $sql_confirmactualp1 = "{call megSaveDrivingPatternDriverGO(?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?)}"; 
    $params_confirmactualp1 = array(
    array('save_actualp1', SQLSRV_PARAM_IN),
    array($_POST['drivingpatterngoid'], SQLSRV_PARAM_IN),
    array($_POST['condition1'], SQLSRV_PARAM_IN),
    array($_POST['condition2'], SQLSRV_PARAM_IN),
    array($_POST['condition3'], SQLSRV_PARAM_IN),
    array($_POST['condition4'], SQLSRV_PARAM_IN),
    array($_POST['condition5'], SQLSRV_PARAM_IN),
    array($_POST['condition6'], SQLSRV_PARAM_IN),
    array($_POST['condition7'], SQLSRV_PARAM_IN),
    array($_POST['condition8'], SQLSRV_PARAM_IN),
    array($_POST['condition9'], SQLSRV_PARAM_IN),
    array($_POST['condition10'], SQLSRV_PARAM_IN),
    array($_POST['condition11'], SQLSRV_PARAM_IN),
    array($_POST['condition12'], SQLSRV_PARAM_IN),
    array($_POST['condition13'], SQLSRV_PARAM_IN),
    array($_POST['condition14'], SQLSRV_PARAM_IN),
    array($_POST['condition15'], SQLSRV_PARAM_IN),
    array($_POST['condition16'], SQLSRV_PARAM_IN),
    array($_POST['condition17'], SQLSRV_PARAM_IN),
    array($_POST['condition18'], SQLSRV_PARAM_IN),
    array($_POST['condition19'], SQLSRV_PARAM_IN),
    array($_POST['condition20'], SQLSRV_PARAM_IN),
    array($_POST['condition21'], SQLSRV_PARAM_IN),
    array($_POST['condition22'], SQLSRV_PARAM_IN),
    array($_POST['condition23'], SQLSRV_PARAM_IN),
    array($_POST['condition24'], SQLSRV_PARAM_IN),
    array($_POST['condition25'], SQLSRV_PARAM_IN),
    array($_POST['condition26'], SQLSRV_PARAM_IN),
    array($_POST['condition27'], SQLSRV_PARAM_IN),
    array($_POST['condition28'], SQLSRV_PARAM_IN),
    array($_POST['condition29'], SQLSRV_PARAM_IN),
    array($_POST['condition30'], SQLSRV_PARAM_IN),
    array($_POST['condition31'], SQLSRV_PARAM_IN),
    array($_POST['condition32'], SQLSRV_PARAM_IN)
    );
  
    $query_confirmactualp1 = sqlsrv_query($conn, $sql_confirmactualp1, $params_confirmactualp1);
    $result_confirmactualp1 = sqlsrv_fetch_array($query_confirmactualp1, SQLSRV_FETCH_ASSOC);
    // echo $result_confirmactualp1['RS'];

//     $sql_updatedata = "UPDATE DRIVINGPATTERN_GO 
//         SET JOBSTARTACTUAL ='RRR'
//         WHERE DRIVINGPATTERNGO_ID = '8'";
// $query_updatedata  = sqlsrv_query($conn, $sql_updatedata, $params_updatedata);
// $result_updatedata = sqlsrv_fetch_array($query_updatedata, SQLSRV_FETCH_ASSOC); 
  
}
// SAVE ACTUAL P2
if ($_POST['txt_flg'] == "save_actualp2") {


    $sql_confirmactualp2 = "{call megSaveDrivingPatternDriverGO(?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?)}"; 
    $params_confirmactualp2 = array(
    array('save_actualp2', SQLSRV_PARAM_IN),
    array($_POST['drivingpatterngoid'], SQLSRV_PARAM_IN),
    array($_POST['condition1'], SQLSRV_PARAM_IN),
    array($_POST['condition2'], SQLSRV_PARAM_IN),
    array($_POST['condition3'], SQLSRV_PARAM_IN),
    array($_POST['condition4'], SQLSRV_PARAM_IN),
    array($_POST['condition5'], SQLSRV_PARAM_IN),
    array($_POST['condition6'], SQLSRV_PARAM_IN),
    array($_POST['condition7'], SQLSRV_PARAM_IN),
    array($_POST['condition8'], SQLSRV_PARAM_IN),
    array($_POST['condition9'], SQLSRV_PARAM_IN),
    array($_POST['condition10'], SQLSRV_PARAM_IN),
    array($_POST['condition11'], SQLSRV_PARAM_IN),
    array($_POST['condition12'], SQLSRV_PARAM_IN),
    array($_POST['condition13'], SQLSRV_PARAM_IN),
    array($_POST['condition14'], SQLSRV_PARAM_IN),
    array($_POST['condition15'], SQLSRV_PARAM_IN),
    array($_POST['condition16'], SQLSRV_PARAM_IN),
    array($_POST['condition17'], SQLSRV_PARAM_IN),
    array($_POST['condition18'], SQLSRV_PARAM_IN),
    array($_POST['condition19'], SQLSRV_PARAM_IN),
    array($_POST['condition20'], SQLSRV_PARAM_IN),
    array($_POST['condition21'], SQLSRV_PARAM_IN),
    array($_POST['condition22'], SQLSRV_PARAM_IN),
    array($_POST['condition23'], SQLSRV_PARAM_IN),
    array($_POST['condition24'], SQLSRV_PARAM_IN),
    array($_POST['condition25'], SQLSRV_PARAM_IN),
    array($_POST['condition26'], SQLSRV_PARAM_IN),
    array($_POST['condition27'], SQLSRV_PARAM_IN),
    array($_POST['condition28'], SQLSRV_PARAM_IN),
    array($_POST['condition29'], SQLSRV_PARAM_IN),
    array($_POST['condition30'], SQLSRV_PARAM_IN),
    array($_POST['condition31'], SQLSRV_PARAM_IN),
    array($_POST['condition32'], SQLSRV_PARAM_IN)
    );
  
    $query_confirmactualp2 = sqlsrv_query($conn, $sql_confirmactualp2, $params_confirmactualp2);
    $result_confirmactualp2 = sqlsrv_fetch_array($query_confirmactualp2, SQLSRV_FETCH_ASSOC);
    // echo $result_confirmactualp1['RS'];

//     $sql_updatedata = "UPDATE DRIVINGPATTERN_GO 
//         SET JOBSTARTACTUAL ='RRR'
//         WHERE DRIVINGPATTERNGO_ID = '8'";
// $query_updatedata  = sqlsrv_query($conn, $sql_updatedata, $params_updatedata);
// $result_updatedata = sqlsrv_fetch_array($query_updatedata, SQLSRV_FETCH_ASSOC); 
  
}
// SAVE ACTUAL P3
if ($_POST['txt_flg'] == "save_actualp3") {


    $sql_confirmactualp3 = "{call megSaveDrivingPatternDriverGO(?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?)}"; 
    $params_confirmactualp3 = array(
    array('save_actualp3', SQLSRV_PARAM_IN),
    array($_POST['drivingpatterngoid'], SQLSRV_PARAM_IN),
    array($_POST['condition1'], SQLSRV_PARAM_IN),
    array($_POST['condition2'], SQLSRV_PARAM_IN),
    array($_POST['condition3'], SQLSRV_PARAM_IN),
    array($_POST['condition4'], SQLSRV_PARAM_IN),
    array($_POST['condition5'], SQLSRV_PARAM_IN),
    array($_POST['condition6'], SQLSRV_PARAM_IN),
    array($_POST['condition7'], SQLSRV_PARAM_IN),
    array($_POST['condition8'], SQLSRV_PARAM_IN),
    array($_POST['condition9'], SQLSRV_PARAM_IN),
    array($_POST['condition10'], SQLSRV_PARAM_IN),
    array($_POST['condition11'], SQLSRV_PARAM_IN),
    array($_POST['condition12'], SQLSRV_PARAM_IN),
    array($_POST['condition13'], SQLSRV_PARAM_IN),
    array($_POST['condition14'], SQLSRV_PARAM_IN),
    array($_POST['condition15'], SQLSRV_PARAM_IN),
    array($_POST['condition16'], SQLSRV_PARAM_IN),
    array($_POST['condition17'], SQLSRV_PARAM_IN),
    array($_POST['condition18'], SQLSRV_PARAM_IN),
    array($_POST['condition19'], SQLSRV_PARAM_IN),
    array($_POST['condition20'], SQLSRV_PARAM_IN),
    array($_POST['condition21'], SQLSRV_PARAM_IN),
    array($_POST['condition22'], SQLSRV_PARAM_IN),
    array($_POST['condition23'], SQLSRV_PARAM_IN),
    array($_POST['condition24'], SQLSRV_PARAM_IN),
    array($_POST['condition25'], SQLSRV_PARAM_IN),
    array($_POST['condition26'], SQLSRV_PARAM_IN),
    array($_POST['condition27'], SQLSRV_PARAM_IN),
    array($_POST['condition28'], SQLSRV_PARAM_IN),
    array($_POST['condition29'], SQLSRV_PARAM_IN),
    array($_POST['condition30'], SQLSRV_PARAM_IN),
    array($_POST['condition31'], SQLSRV_PARAM_IN),
    array($_POST['condition32'], SQLSRV_PARAM_IN)
    );
  
    $query_confirmactualp3 = sqlsrv_query($conn, $sql_confirmactualp3, $params_confirmactualp3);
    $result_confirmactualp3 = sqlsrv_fetch_array($query_confirmactualp3, SQLSRV_FETCH_ASSOC);
    // echo $result_confirmactualp1['RS'];

//     $sql_updatedata = "UPDATE DRIVINGPATTERN_GO 
//         SET JOBSTARTACTUAL ='RRR'
//         WHERE DRIVINGPATTERNGO_ID = '8'";
// $query_updatedata  = sqlsrv_query($conn, $sql_updatedata, $params_updatedata);
// $result_updatedata = sqlsrv_fetch_array($query_updatedata, SQLSRV_FETCH_ASSOC); 
  
}
// SAVE ACTUAL P4
if ($_POST['txt_flg'] == "save_actualp4") {


    $sql_confirmactualp4 = "{call megSaveDrivingPatternDriverGO(?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?)}"; 
    $params_confirmactualp4 = array(
    array('save_actualp4', SQLSRV_PARAM_IN),
    array($_POST['drivingpatterngoid'], SQLSRV_PARAM_IN),
    array($_POST['condition1'], SQLSRV_PARAM_IN),
    array($_POST['condition2'], SQLSRV_PARAM_IN),
    array($_POST['condition3'], SQLSRV_PARAM_IN),
    array($_POST['condition4'], SQLSRV_PARAM_IN),
    array($_POST['condition5'], SQLSRV_PARAM_IN),
    array($_POST['condition6'], SQLSRV_PARAM_IN),
    array($_POST['condition7'], SQLSRV_PARAM_IN),
    array($_POST['condition8'], SQLSRV_PARAM_IN),
    array($_POST['condition9'], SQLSRV_PARAM_IN),
    array($_POST['condition10'], SQLSRV_PARAM_IN),
    array($_POST['condition11'], SQLSRV_PARAM_IN),
    array($_POST['condition12'], SQLSRV_PARAM_IN),
    array($_POST['condition13'], SQLSRV_PARAM_IN),
    array($_POST['condition14'], SQLSRV_PARAM_IN),
    array($_POST['condition15'], SQLSRV_PARAM_IN),
    array($_POST['condition16'], SQLSRV_PARAM_IN),
    array($_POST['condition17'], SQLSRV_PARAM_IN),
    array($_POST['condition18'], SQLSRV_PARAM_IN),
    array($_POST['condition19'], SQLSRV_PARAM_IN),
    array($_POST['condition20'], SQLSRV_PARAM_IN),
    array($_POST['condition21'], SQLSRV_PARAM_IN),
    array($_POST['condition22'], SQLSRV_PARAM_IN),
    array($_POST['condition23'], SQLSRV_PARAM_IN),
    array($_POST['condition24'], SQLSRV_PARAM_IN),
    array($_POST['condition25'], SQLSRV_PARAM_IN),
    array($_POST['condition26'], SQLSRV_PARAM_IN),
    array($_POST['condition27'], SQLSRV_PARAM_IN),
    array($_POST['condition28'], SQLSRV_PARAM_IN),
    array($_POST['condition29'], SQLSRV_PARAM_IN),
    array($_POST['condition30'], SQLSRV_PARAM_IN),
    array($_POST['condition31'], SQLSRV_PARAM_IN),
    array($_POST['condition32'], SQLSRV_PARAM_IN)
    );
  
    $query_confirmactualp4 = sqlsrv_query($conn, $sql_confirmactualp4, $params_confirmactualp4);
    $result_confirmactualp4 = sqlsrv_fetch_array($query_confirmactualp4, SQLSRV_FETCH_ASSOC);
    // echo $result_confirmactualp1['RS'];

//     $sql_updatedata = "UPDATE DRIVINGPATTERN_GO 
//         SET JOBSTARTACTUAL ='RRR'
//         WHERE DRIVINGPATTERNGO_ID = '8'";
// $query_updatedata  = sqlsrv_query($conn, $sql_updatedata, $params_updatedata);
// $result_updatedata = sqlsrv_fetch_array($query_updatedata, SQLSRV_FETCH_ASSOC); 
  
}
// SAVE ACTUAL P5
if ($_POST['txt_flg'] == "save_actualp5") {


    $sql_confirmactualp5 = "{call megSaveDrivingPatternDriverGO(?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?)}"; 
    $params_confirmactualp5 = array(
    array('save_actualp5', SQLSRV_PARAM_IN),
    array($_POST['drivingpatterngoid'], SQLSRV_PARAM_IN),
    array($_POST['condition1'], SQLSRV_PARAM_IN),
    array($_POST['condition2'], SQLSRV_PARAM_IN),
    array($_POST['condition3'], SQLSRV_PARAM_IN),
    array($_POST['condition4'], SQLSRV_PARAM_IN),
    array($_POST['condition5'], SQLSRV_PARAM_IN),
    array($_POST['condition6'], SQLSRV_PARAM_IN),
    array($_POST['condition7'], SQLSRV_PARAM_IN),
    array($_POST['condition8'], SQLSRV_PARAM_IN),
    array($_POST['condition9'], SQLSRV_PARAM_IN),
    array($_POST['condition10'], SQLSRV_PARAM_IN),
    array($_POST['condition11'], SQLSRV_PARAM_IN),
    array($_POST['condition12'], SQLSRV_PARAM_IN),
    array($_POST['condition13'], SQLSRV_PARAM_IN),
    array($_POST['condition14'], SQLSRV_PARAM_IN),
    array($_POST['condition15'], SQLSRV_PARAM_IN),
    array($_POST['condition16'], SQLSRV_PARAM_IN),
    array($_POST['condition17'], SQLSRV_PARAM_IN),
    array($_POST['condition18'], SQLSRV_PARAM_IN),
    array($_POST['condition19'], SQLSRV_PARAM_IN),
    array($_POST['condition20'], SQLSRV_PARAM_IN),
    array($_POST['condition21'], SQLSRV_PARAM_IN),
    array($_POST['condition22'], SQLSRV_PARAM_IN),
    array($_POST['condition23'], SQLSRV_PARAM_IN),
    array($_POST['condition24'], SQLSRV_PARAM_IN),
    array($_POST['condition25'], SQLSRV_PARAM_IN),
    array($_POST['condition26'], SQLSRV_PARAM_IN),
    array($_POST['condition27'], SQLSRV_PARAM_IN),
    array($_POST['condition28'], SQLSRV_PARAM_IN),
    array($_POST['condition29'], SQLSRV_PARAM_IN),
    array($_POST['condition30'], SQLSRV_PARAM_IN),
    array($_POST['condition31'], SQLSRV_PARAM_IN),
    array($_POST['condition32'], SQLSRV_PARAM_IN)
    );
  
    $query_confirmactualp5 = sqlsrv_query($conn, $sql_confirmactualp5, $params_confirmactualp5);
    $result_confirmactualp5 = sqlsrv_fetch_array($query_confirmactualp5, SQLSRV_FETCH_ASSOC);
    // echo $result_confirmactualp1['RS'];

//     $sql_updatedata = "UPDATE DRIVINGPATTERN_GO 
//         SET JOBSTARTACTUAL ='RRR'
//         WHERE DRIVINGPATTERNGO_ID = '8'";
// $query_updatedata  = sqlsrv_query($conn, $sql_updatedata, $params_updatedata);
// $result_updatedata = sqlsrv_fetch_array($query_updatedata, SQLSRV_FETCH_ASSOC); 
  
}
// SAVE ACTUAL P5
if ($_POST['txt_flg'] == "save_actualp6") {


    $sql_confirmactualp6 = "{call megSaveDrivingPatternDriverGO(?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?)}"; 
    $params_confirmactualp6 = array(
    array('save_actualp6', SQLSRV_PARAM_IN),
    array($_POST['drivingpatterngoid'], SQLSRV_PARAM_IN),
    array($_POST['condition1'], SQLSRV_PARAM_IN),
    array($_POST['condition2'], SQLSRV_PARAM_IN),
    array($_POST['condition3'], SQLSRV_PARAM_IN),
    array($_POST['condition4'], SQLSRV_PARAM_IN),
    array($_POST['condition5'], SQLSRV_PARAM_IN),
    array($_POST['condition6'], SQLSRV_PARAM_IN),
    array($_POST['condition7'], SQLSRV_PARAM_IN),
    array($_POST['condition8'], SQLSRV_PARAM_IN),
    array($_POST['condition9'], SQLSRV_PARAM_IN),
    array($_POST['condition10'], SQLSRV_PARAM_IN),
    array($_POST['condition11'], SQLSRV_PARAM_IN),
    array($_POST['condition12'], SQLSRV_PARAM_IN),
    array($_POST['condition13'], SQLSRV_PARAM_IN),
    array($_POST['condition14'], SQLSRV_PARAM_IN),
    array($_POST['condition15'], SQLSRV_PARAM_IN),
    array($_POST['condition16'], SQLSRV_PARAM_IN),
    array($_POST['condition17'], SQLSRV_PARAM_IN),
    array($_POST['condition18'], SQLSRV_PARAM_IN),
    array($_POST['condition19'], SQLSRV_PARAM_IN),
    array($_POST['condition20'], SQLSRV_PARAM_IN),
    array($_POST['condition21'], SQLSRV_PARAM_IN),
    array($_POST['condition22'], SQLSRV_PARAM_IN),
    array($_POST['condition23'], SQLSRV_PARAM_IN),
    array($_POST['condition24'], SQLSRV_PARAM_IN),
    array($_POST['condition25'], SQLSRV_PARAM_IN),
    array($_POST['condition26'], SQLSRV_PARAM_IN),
    array($_POST['condition27'], SQLSRV_PARAM_IN),
    array($_POST['condition28'], SQLSRV_PARAM_IN),
    array($_POST['condition29'], SQLSRV_PARAM_IN),
    array($_POST['condition30'], SQLSRV_PARAM_IN),
    array($_POST['condition31'], SQLSRV_PARAM_IN),
    array($_POST['condition32'], SQLSRV_PARAM_IN)
    );
  
    $query_confirmactualp6 = sqlsrv_query($conn, $sql_confirmactualp6, $params_confirmactualp6);
    $result_confirmactualp6 = sqlsrv_fetch_array($query_confirmactualp6, SQLSRV_FETCH_ASSOC);
    // echo $result_confirmactualp1['RS'];

//     $sql_updatedata = "UPDATE DRIVINGPATTERN_GO 
//         SET JOBSTARTACTUAL ='RRR'
//         WHERE DRIVINGPATTERNGO_ID = '8'";
// $query_updatedata  = sqlsrv_query($conn, $sql_updatedata, $params_updatedata);
// $result_updatedata = sqlsrv_fetch_array($query_updatedata, SQLSRV_FETCH_ASSOC); 
  
}
// SAVE ACTUAL P5
if ($_POST['txt_flg'] == "save_actualload") {


    $sql_confirmactualp6 = "{call megSaveDrivingPatternDriverGO(?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?,?,?,?,?,?,?,
                                                                ?,?,?,?)}"; 
    $params_confirmactualp6 = array(
    array('save_actualload', SQLSRV_PARAM_IN),
    array($_POST['drivingpatterngoid'], SQLSRV_PARAM_IN),
    array($_POST['condition1'], SQLSRV_PARAM_IN),
    array($_POST['condition2'], SQLSRV_PARAM_IN),
    array($_POST['condition3'], SQLSRV_PARAM_IN),
    array($_POST['condition4'], SQLSRV_PARAM_IN),
    array($_POST['condition5'], SQLSRV_PARAM_IN),
    array($_POST['condition6'], SQLSRV_PARAM_IN),
    array($_POST['condition7'], SQLSRV_PARAM_IN),
    array($_POST['condition8'], SQLSRV_PARAM_IN),
    array($_POST['condition9'], SQLSRV_PARAM_IN),
    array($_POST['condition10'], SQLSRV_PARAM_IN),
    array($_POST['condition11'], SQLSRV_PARAM_IN),
    array($_POST['condition12'], SQLSRV_PARAM_IN),
    array($_POST['condition13'], SQLSRV_PARAM_IN),
    array($_POST['condition14'], SQLSRV_PARAM_IN),
    array($_POST['condition15'], SQLSRV_PARAM_IN),
    array($_POST['condition16'], SQLSRV_PARAM_IN),
    array($_POST['condition17'], SQLSRV_PARAM_IN),
    array($_POST['condition18'], SQLSRV_PARAM_IN),
    array($_POST['condition19'], SQLSRV_PARAM_IN),
    array($_POST['condition20'], SQLSRV_PARAM_IN),
    array($_POST['condition21'], SQLSRV_PARAM_IN),
    array($_POST['condition22'], SQLSRV_PARAM_IN),
    array($_POST['condition23'], SQLSRV_PARAM_IN),
    array($_POST['condition24'], SQLSRV_PARAM_IN),
    array($_POST['condition25'], SQLSRV_PARAM_IN),
    array($_POST['condition26'], SQLSRV_PARAM_IN),
    array($_POST['condition27'], SQLSRV_PARAM_IN),
    array($_POST['condition28'], SQLSRV_PARAM_IN),
    array($_POST['condition29'], SQLSRV_PARAM_IN),
    array($_POST['condition30'], SQLSRV_PARAM_IN),
    array($_POST['condition31'], SQLSRV_PARAM_IN),
    array($_POST['condition32'], SQLSRV_PARAM_IN)
    );
  
    $query_confirmactualp6 = sqlsrv_query($conn, $sql_confirmactualp6, $params_confirmactualp6);
    $result_confirmactualp6 = sqlsrv_fetch_array($query_confirmactualp6, SQLSRV_FETCH_ASSOC);
    // echo $result_confirmactualp1['RS'];

//     $sql_updatedata = "UPDATE DRIVINGPATTERN_GO 
//         SET JOBSTARTACTUAL ='RRR'
//         WHERE DRIVINGPATTERNGO_ID = '8'";
// $query_updatedata  = sqlsrv_query($conn, $sql_updatedata, $params_updatedata);
// $result_updatedata = sqlsrv_fetch_array($query_updatedata, SQLSRV_FETCH_ASSOC); 
  
}
if ($_POST['txt_flg'] == "confirm_actual_go") {


    $sql_confirm_actual_go = "{call megDrivingPatternDriver(?,?,?,?,?,?,?)}"; 
    $params_confirm_actual_go = array(
    array('confirm_actual_go', SQLSRV_PARAM_IN),
    array($_POST['employeecode'], SQLSRV_PARAM_IN),
    array($_POST['condition1'], SQLSRV_PARAM_IN),
    array($_POST['condition2'], SQLSRV_PARAM_IN),
    array($_POST['condition3'], SQLSRV_PARAM_IN),
    array($_POST['condition4'], SQLSRV_PARAM_IN),
    array($_POST['condition5'], SQLSRV_PARAM_IN)
    );
  
    $query_confirm_actual_go = sqlsrv_query($conn, $sql_confirm_actual_go, $params_confirm_actual_go);
    $result_confirm_actual_go = sqlsrv_fetch_array($query_confirm_actual_go, SQLSRV_FETCH_ASSOC);
    echo $result_confirm_actual_go['RS'];
  
}

// Driving Pattern แผนขากลับ
if ($_POST['txt_flg'] == "save_dealermaster") {


    $sql_savedealermaster    = "{call megDrivingPatternDriver(?,?,?,?,?,?,?)}"; 
    $params_savedealermaster = array(
    array('save_dealermaster', SQLSRV_PARAM_IN),
    array($_POST['employeecode'], SQLSRV_PARAM_IN),
    array($_POST['condition1'], SQLSRV_PARAM_IN),
    array($_POST['condition2'], SQLSRV_PARAM_IN),
    array($_POST['condition3'], SQLSRV_PARAM_IN),
    array($_POST['condition4'], SQLSRV_PARAM_IN),
    array($_POST['condition5'], SQLSRV_PARAM_IN)
    );
  
    $query_savedealermaster     = sqlsrv_query($conn, $sql_savedealermaster, $params_savedealermaster);
    $result_savedealermaster    = sqlsrv_fetch_array($query_savedealermaster, SQLSRV_FETCH_ASSOC);
    // echo $result_savedealermaster['RS'];
  
}

// Driving Pattern แผนขากลับ
if ($_POST['txt_flg'] == "delete_dealermaster") {


    $sql_deletedealermaster     = "{call megDrivingPatternDriver(?,?,?,?,?,?,?)}"; 
    $params_deletedealermaster  = array(
    array('delete_dealermaster', SQLSRV_PARAM_IN),
    array($_POST['employeecode'], SQLSRV_PARAM_IN),
    array($_POST['condition1'], SQLSRV_PARAM_IN),
    array($_POST['condition2'], SQLSRV_PARAM_IN),
    array($_POST['condition3'], SQLSRV_PARAM_IN),
    array($_POST['condition4'], SQLSRV_PARAM_IN),
    array($_POST['condition5'], SQLSRV_PARAM_IN)
    );
  
    $query_deletedealermaster = sqlsrv_query($conn, $sql_deletedealermaster, $params_deletedealermaster);
    $result_deletedealermaster = sqlsrv_fetch_array($query_deletedealermaster, SQLSRV_FETCH_ASSOC);
    // echo $result_deletedealermaster['RS'];
  
}
// Driving Pattern แผนขากลับ
if ($_POST['txt_flg'] == "select_drivingpatternskp") {
?>
    <div class="row">
        <div class="col-lg-12">
            <table  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example" style="width: 100%;">
                <thead>
                    <tr>    
                        <th><label style="width: 100px">เลขที่แผนงาน1</label></th>
                        <th><label style="width: 100px">พนักงานคนที่1</label></th>
                        <th><label style="width: 100px">พนักงานคนที่2</label></th>
                        <th><label style="width: 100px">บริษัทสังกัด</label></th>
                        <th><label style="width: 100px">สายงานสังกัด</label></th>
                        <th><label style="width: 100px">ชื่อรถ (ไทย)</label></th>
                        <th><label style="width: 100px">เลขทะเบียนรถ</label></th>
                        <th><label style="width: 100px;text-align: center">Driving <br>Pattern</label></th>
                        <th><label style="width: 100px;text-align: center">ปลดล็อคแผน<br>วิ่งจริงขาไป</label></th>
                        <th><label style="width: 100px;text-align: center">ปลดล็อคแผน<br>วิ่งจริงขากลับ</label></th>
                        <th><label style="width: 100px;text-align: center">สถานะ <br>ขาไป</label></th>
                        <th><label style="width: 100px;text-align: center">สถานะ <br>ขากลับ</label></th>
                        <th><label style="width: 100px;text-align: center">วันที่วิ่งงาน</label></th>
                    </tr>
                </thead>
                <tbody>

                <?php
                // $condition1 = " AND (a.THAINAME NOT LIKE '%R-%' OR a.THAINAME NOT LIKE '%RA-%' OR a.THAINAME NOT LIKE '%RP-%'";
                // $condition2 = " OR a.THAINAME NOT LIKE '%คลองเขื่อน%'  OR a.THAINAME NOT LIKE '%ด่านช้าง%'  OR a.THAINAME NOT LIKE '%สวนผึ้ง%' ";
                // $condition3 = " OR a.ENGNAME NOT LIKE '%ดินแดง%' OR a.ENGNAME NOT LIKE '%อุทัยธานี%' OR a.ENGNAME NOT LIKE '%Kerry%'";
                // $condition4 = " OR a.THAINAME NOT LIKE '%เขาชะเมา%' OR a.THAINAME NOT LIKE '%เฉลิมพระเกียรติ%' OR a.THAINAME NOT LIKE '%P35%' )";

                $condition1 = "AND c.VEHICLEGROUPCODE !='VG-1403-0755' AND c.AFFCOMPANY IN ('RRC','RCC','RATC') 
                               AND CONVERT(DATE,a.DATEWORKING,103) BETWEEN CONVERT(DATE,'".$_POST['datestart']."',103) AND CONVERT(DATE,'".$_POST['dateend']."',103)
                               AND (a.EMPLOYEECODE1 ='".$_POST["employeecode"]."' OR a.EMPLOYEECODE2 ='".$_POST["employeecode"]."')
                               ORDER BY a.DATEWORKING,c.AFFCOMPANY,c.AFFCUSTOMER,a.THAINAME ASC";
                $condition2 = "";
                $condition3 = "";
                $condition4 = "";
                $condition5 = "";
                $sql_infolist = "{call megDrivingPatternDriver(?,?,?,?,?,?,?)}";
                $params_infolist = array(
                array('select_vehicleinfo_drivingpattern', SQLSRV_PARAM_IN),
                array('', SQLSRV_PARAM_IN),
                array($condition1, SQLSRV_PARAM_IN),
                array($condition2, SQLSRV_PARAM_IN),
                array($condition3, SQLSRV_PARAM_IN),
                array($condition4, SQLSRV_PARAM_IN),
                array($condition5, SQLSRV_PARAM_IN)
                );

                $query_infolist = sqlsrv_query($conn, $sql_infolist, $params_infolist);
                while ($result_infolist = sqlsrv_fetch_array($query_infolist, SQLSRV_FETCH_ASSOC)) {

                // สถานะแผนขาไป
                if ($result_infolist['DRIVINGPATTERNGO_STATUS'] == 'inprogess') {
                $bgcolorgo ="background-color: #f5f2a6";
                $statustextgo = "อยู่ระหว่างดำเนินการ";
                }else{
                $bgcolorgo ="background-color: #b3f5a6";
                $statustextgo = "ดำเนินการเรียบร้อย";
                }

                // สถานะแผนขากลับ
                if ($result_infolist['DRIVINGPATTERNRETURN_STATUS'] == 'inprogess') {
                $bgcolorback ="background-color: #f5f2a6";
                $statustextback = "อยู่ระหว่างดำเนินการ";
                }else{
                $bgcolorback ="background-color: #b3f5a6";
                $statustextback = "ดำเนินการเรียบร้อย";
                }
                ?>
                <tr>
                    <td style="width: 100px"><?= $result_infolist['VEHICLETRANSPORTPLANID'] ?></td>
                    <td style="width: 100px"><?= $result_infolist['EMPLOYEENAME1'] ?></td>
                    <td style="width: 100px"><?= $result_infolist['EMPLOYEENAME2'] ?></td>
                    <td style="width: 100px"><?= $result_infolist['AFFCOMPANY'] ?></td>
                    <td style="width: 100px"><?= $result_infolist['AFFCUSTOMER'] ?></td>
                    <td style="width: 100px"><?= str_replace("(4L)","",$result_infolist['THAINAME']) ?></td>
                    <td style="width: 100px"><?= $result_infolist['VEHICLEREGISNUMBER'] ?></td>
                    <td style="text-align: center;width: 100px">
                        <a style="background-color: #e0e0e0;" href='meg_drivingpattern_officer.php?drivinggoplanid=<?= $result_infolist['DRIVINGPATTERNGO_ID'] ?>&drivingbackplanid=<?= $result_infolist['DRIVINGPATTERNRETURN_ID'] ?>' target="_bank" class='list-group-item'><span class="glyphicon glyphicon-list-alt"></span></a>
                    </td>
                    <td style="text-align: center;width: 70px">
                        <a style="background-color: #e0e0e0;" href='meg_drivingpattern_gounlock.php?drivinggoplanid=<?= $result_infolist['DRIVINGPATTERNGO_ID'] ?>&drivingbackplanid=<?= $result_infolist['DRIVINGPATTERNRETURN_ID'] ?>' target="_bank" class='list-group-item'><span class="glyphicon glyphicon-open-file"></span></a>
                    </td>
                    <td style="text-align: center">
                        <a style="background-color: #e0e0e0;" href='meg_drivingpattern_backunlock.php?drivinggoplanid=<?= $result_infolist['DRIVINGPATTERNGO_ID'] ?>&drivingbackplanid=<?= $result_infolist['DRIVINGPATTERNRETURN_ID'] ?>' target="_bank" class='list-group-item'><span class="glyphicon glyphicon-save-file"></span></a>
                    </td>
                    <td style="text-align: center;width: 100px;<?=$bgcolorgo?>"><?= $statustextgo ?></td>
                    <td style="text-align: center;width: 100px;<?=$bgcolorback?>"><?= $statustextback ?></td>
                    <td style="width: 100px"><?= $result_infolist['DATEWORKING'] ?></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </div>
    </div>
<?php
}
// Driving Pattern สำหรับพนักงานลงข้อมูล
if ($_POST['txt_flg'] == "select_drivingpattern_driverselect") {
?>
    <div class="row">
        <div class="col-lg-12">
            <table  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example" style="width: 100%;">
                <thead>
                    <tr>    
                        <th><label style="width: 100px;text-align: center">ลงข้อมูล</label></th>
                        <th><label style="width: 100px">เลขที่แผนงาน</label></th>
                        <th><label style="width: 100px">พนักงานคนที่1</label></th>
                        <th><label style="width: 100px">พนักงานคนที่2</label></th>
                        <th><label style="width: 100px">บริษัทสังกัด</label></th>
                        <th><label style="width: 100px">สายงานสังกัด</label></th>
                        <th><label style="width: 100px">ชื่อรถ (ไทย)</label></th>
                        <th><label style="width: 100px">เลขทะเบียนรถ</label></th>
                        <th><label style="width: 100px;text-align: center">สถานะ <br>ขาไป</label></th>
                        <th><label style="width: 100px;text-align: center">สถานะ <br>ขากลับ</label></th>
                        <th><label style="width: 100px;text-align: center">วันที่วิ่งงาน</label></th>
                    </tr>
                </thead>
                <tbody>

                <?php
                // $condition1 = " AND (a.THAINAME NOT LIKE '%R-%' OR a.THAINAME NOT LIKE '%RA-%' OR a.THAINAME NOT LIKE '%RP-%'";
                // $condition2 = " OR a.THAINAME NOT LIKE '%คลองเขื่อน%'  OR a.THAINAME NOT LIKE '%ด่านช้าง%'  OR a.THAINAME NOT LIKE '%สวนผึ้ง%' ";
                // $condition3 = " OR a.ENGNAME NOT LIKE '%ดินแดง%' OR a.ENGNAME NOT LIKE '%อุทัยธานี%' OR a.ENGNAME NOT LIKE '%Kerry%'";
                // $condition4 = " OR a.THAINAME NOT LIKE '%เขาชะเมา%' OR a.THAINAME NOT LIKE '%เฉลิมพระเกียรติ%' OR a.THAINAME NOT LIKE '%P35%' )";

                $condition1 = "AND c.VEHICLEGROUPCODE !='VG-1403-0755' AND c.AFFCOMPANY IN ('RRC','RCC','RATC') 
                               AND CONVERT(DATE,a.DATEWORKING,103) BETWEEN CONVERT(DATE,'".$_POST['datestart']."',103) AND CONVERT(DATE,'".$_POST['dateend']."',103)
                               AND (a.EMPLOYEECODE1 ='".$_POST["employeecode"]."' OR a.EMPLOYEECODE2 ='".$_POST["employeecode"]."')
                               ORDER BY a.DATEWORKING,c.AFFCOMPANY,c.AFFCUSTOMER,a.THAINAME ASC";
                $condition2 = "";
                $condition3 = "";
                $condition4 = "";
                $condition5 = "";
                $sql_infolist = "{call megDrivingPatternDriver(?,?,?,?,?,?,?)}";
                $params_infolist = array(
                array('select_vehicleinfo_drivingpattern', SQLSRV_PARAM_IN),
                array('', SQLSRV_PARAM_IN),
                array($condition1, SQLSRV_PARAM_IN),
                array($condition2, SQLSRV_PARAM_IN),
                array($condition3, SQLSRV_PARAM_IN),
                array($condition4, SQLSRV_PARAM_IN),
                array($condition5, SQLSRV_PARAM_IN)
                );

                $query_infolist = sqlsrv_query($conn, $sql_infolist, $params_infolist);
                while ($result_infolist = sqlsrv_fetch_array($query_infolist, SQLSRV_FETCH_ASSOC)) {

                // สถานะแผนขาไป
                if ($result_infolist['DRIVINGPATTERNGO_STATUS'] == 'inprogess') {
                $bgcolorgo ="background-color: #f5f2a6";
                $statustextgo = "อยู่ระหว่างดำเนินการ";
                }else{
                $bgcolorgo ="background-color: #b3f5a6";
                $statustextgo = "ดำเนินการเรียบร้อย";
                }

                // สถานะแผนขากลับ
                if ($result_infolist['DRIVINGPATTERNRETURN_STATUS'] == 'inprogess') {
                $bgcolorback ="background-color: #f5f2a6";
                $statustextback = "อยู่ระหว่างดำเนินการ";
                }else{
                $bgcolorback ="background-color: #b3f5a6";
                $statustextback = "ดำเนินการเรียบร้อย";
                }
                ?>
                <tr>
                    <td style="text-align: center;width: 100px">
                        <a style="background-color: #e0e0e0;" href='meg_drivingpattern_driveractual.php?drivinggoplanid=<?= $result_infolist['DRIVINGPATTERNGO_ID'] ?>&drivingbackplanid=<?= $result_infolist['DRIVINGPATTERNRETURN_ID'] ?>' target="_bank" class='list-group-item'><span class="glyphicon glyphicon-list-alt"></span></a>
                    </td>
                    <td style="width: 100px"><?= $result_infolist['VEHICLETRANSPORTPLANID'] ?></td>
                    <td style="width: 100px"><?= $result_infolist['EMPLOYEENAME1'] ?></td>
                    <td style="width: 100px"><?= $result_infolist['EMPLOYEENAME2'] ?></td>
                    <td style="width: 100px"><?= $result_infolist['AFFCOMPANY'] ?></td>
                    <td style="width: 100px"><?= $result_infolist['AFFCUSTOMER'] ?></td>
                    <td style="width: 100px"><?= str_replace("(4L)","",$result_infolist['THAINAME']) ?></td>
                    <td style="width: 100px"><?= $result_infolist['VEHICLEREGISNUMBER'] ?></td>
                    <td style="text-align: center;width: 100px;<?=$bgcolorgo?>"><?= $statustextgo ?></td>
                    <td style="text-align: center;width: 100px;<?=$bgcolorback?>"><?= $statustextback ?></td>
                    <td style="width: 100px"><?= $result_infolist['DATEWORKING'] ?></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </div>
    </div>
<?php
// Function สำหรับล Actual 
// Tracking Current Time P1
}
if ($_POST['txt_flg'] == "checkin4hurp1") {
    
      $sql = "SELECT REPLACE(CONVERT(VARCHAR(16),GETDATE(),120), ' ', 'T') AS 'RS'";
      $query = sqlsrv_query($conn, $sql, $params);
      $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
      
      echo $result['RS'];
      
}if ($_POST['txt_flg'] == "checkout4hurp1") {
    
    $sql = "SELECT REPLACE(CONVERT(VARCHAR(16),GETDATE(),120), ' ', 'T') AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    
    echo $result['RS'];
    
}
if ($_POST['txt_flg'] == "checkin2hurp1") {
    
      $sql = "SELECT REPLACE(CONVERT(VARCHAR(16),GETDATE(),120), ' ', 'T') AS 'RS'";
      $query = sqlsrv_query($conn, $sql, $params);
      $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
      
      echo $result['RS'];
      
}if ($_POST['txt_flg'] == "checkout2hurp1") {
    
    $sql = "SELECT REPLACE(CONVERT(VARCHAR(16),GETDATE(),120), ' ', 'T') AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    
    echo $result['RS'];
    
}

// Tracking Current Time P2
if ($_POST['txt_flg'] == "checkin4hurp2") {
    
      $sql = "SELECT REPLACE(CONVERT(VARCHAR(16),GETDATE(),120), ' ', 'T') AS 'RS'";
      $query = sqlsrv_query($conn, $sql, $params);
      $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
      
      echo $result['RS'];
      
}if ($_POST['txt_flg'] == "checkout4hurp2") {
    
    $sql = "SELECT REPLACE(CONVERT(VARCHAR(16),GETDATE(),120), ' ', 'T') AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    
    echo $result['RS'];
    
}
if ($_POST['txt_flg'] == "checkin2hurp2") {
    
      $sql = "SELECT REPLACE(CONVERT(VARCHAR(16),GETDATE(),120), ' ', 'T') AS 'RS'";
      $query = sqlsrv_query($conn, $sql, $params);
      $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
      
      echo $result['RS'];
      
}if ($_POST['txt_flg'] == "checkout2hurp2") {
    
    $sql = "SELECT REPLACE(CONVERT(VARCHAR(16),GETDATE(),120), ' ', 'T') AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    
    echo $result['RS'];
    
}

// Tracking Current Time P3
if ($_POST['txt_flg'] == "checkin4hurp3") {
    
    $sql = "SELECT REPLACE(CONVERT(VARCHAR(16),GETDATE(),120), ' ', 'T') AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    
    echo $result['RS'];
    
}if ($_POST['txt_flg'] == "checkout4hurp3") {
  
  $sql = "SELECT REPLACE(CONVERT(VARCHAR(16),GETDATE(),120), ' ', 'T') AS 'RS'";
  $query = sqlsrv_query($conn, $sql, $params);
  $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
  
  echo $result['RS'];
  
}
if ($_POST['txt_flg'] == "checkin2hurp3") {
  
    $sql = "SELECT REPLACE(CONVERT(VARCHAR(16),GETDATE(),120), ' ', 'T') AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    
    echo $result['RS'];
    
}if ($_POST['txt_flg'] == "checkout2hurp3") {
  
  $sql = "SELECT REPLACE(CONVERT(VARCHAR(16),GETDATE(),120), ' ', 'T') AS 'RS'";
  $query = sqlsrv_query($conn, $sql, $params);
  $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
  
  echo $result['RS'];
  
}

// Tracking Current Time P4
if ($_POST['txt_flg'] == "checkin4hurp4") {
    
    $sql = "SELECT REPLACE(CONVERT(VARCHAR(16),GETDATE(),120), ' ', 'T') AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    
    echo $result['RS'];
    
}if ($_POST['txt_flg'] == "checkout4hurp4") {
  
  $sql = "SELECT REPLACE(CONVERT(VARCHAR(16),GETDATE(),120), ' ', 'T') AS 'RS'";
  $query = sqlsrv_query($conn, $sql, $params);
  $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
  
  echo $result['RS'];
  
}
if ($_POST['txt_flg'] == "checkin2hurp4") {
  
    $sql = "SELECT REPLACE(CONVERT(VARCHAR(16),GETDATE(),120), ' ', 'T') AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    
    echo $result['RS'];
    
}if ($_POST['txt_flg'] == "checkout2hurp4") {
  
  $sql = "SELECT REPLACE(CONVERT(VARCHAR(16),GETDATE(),120), ' ', 'T') AS 'RS'";
  $query = sqlsrv_query($conn, $sql, $params);
  $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
  
  echo $result['RS'];
  
}

// Tracking Current Time P5
if ($_POST['txt_flg'] == "checkin4hurp5") {
    
    $sql = "SELECT REPLACE(CONVERT(VARCHAR(16),GETDATE(),120), ' ', 'T') AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    
    echo $result['RS'];
    
}if ($_POST['txt_flg'] == "checkout4hurp5") {
  
  $sql = "SELECT REPLACE(CONVERT(VARCHAR(16),GETDATE(),120), ' ', 'T') AS 'RS'";
  $query = sqlsrv_query($conn, $sql, $params);
  $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
  
  echo $result['RS'];
  
}
if ($_POST['txt_flg'] == "checkin2hurp5") {
  
    $sql = "SELECT REPLACE(CONVERT(VARCHAR(16),GETDATE(),120), ' ', 'T') AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    
    echo $result['RS'];
    
}if ($_POST['txt_flg'] == "checkout2hurp5") {
  
  $sql = "SELECT REPLACE(CONVERT(VARCHAR(16),GETDATE(),120), ' ', 'T') AS 'RS'";
  $query = sqlsrv_query($conn, $sql, $params);
  $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
  
  echo $result['RS'];
  
}

// Tracking Current Time P6
if ($_POST['txt_flg'] == "checkin4hurp6") {
    
    $sql = "SELECT REPLACE(CONVERT(VARCHAR(16),GETDATE(),120), ' ', 'T') AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    
    echo $result['RS'];
    
}if ($_POST['txt_flg'] == "checkout4hurp6") {
  
  $sql = "SELECT REPLACE(CONVERT(VARCHAR(16),GETDATE(),120), ' ', 'T') AS 'RS'";
  $query = sqlsrv_query($conn, $sql, $params);
  $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
  
  echo $result['RS'];
  
}
if ($_POST['txt_flg'] == "checkin2hurp6") {
  
    $sql = "SELECT REPLACE(CONVERT(VARCHAR(16),GETDATE(),120), ' ', 'T') AS 'RS'";
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    
    echo $result['RS'];
    
}if ($_POST['txt_flg'] == "checkout2hurp6") {
  
  $sql = "SELECT REPLACE(CONVERT(VARCHAR(16),GETDATE(),120), ' ', 'T') AS 'RS'";
  $query = sqlsrv_query($conn, $sql, $params);
  $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
  
  echo $result['RS'];
  
}
// CONFIRMED BUTTON 
if ($_POST['txt_flg'] == "save_confirm_driver_p1") {


    $sql_confirmp1 = "{call megDrivingPatternDriverNewV2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}"; 
    $params_confirmp1 = array(
    array('save_confirm_driver_p1', SQLSRV_PARAM_IN),
    array($_POST['employeecode'], SQLSRV_PARAM_IN),
    array($_POST['condition1'], SQLSRV_PARAM_IN),
    array($_POST['condition2'], SQLSRV_PARAM_IN),
    array($_POST['condition3'], SQLSRV_PARAM_IN),
    array($_POST['condition4'], SQLSRV_PARAM_IN),
    array($_POST['condition5'], SQLSRV_PARAM_IN),
    array($_POST['condition6'], SQLSRV_PARAM_IN),
    array($_POST['condition7'], SQLSRV_PARAM_IN),
    array($_POST['condition8'], SQLSRV_PARAM_IN),
    array($_POST['condition9'], SQLSRV_PARAM_IN),
    array($_POST['condition10'], SQLSRV_PARAM_IN),
    array($_POST['condition11'], SQLSRV_PARAM_IN),
    array($_POST['condition12'], SQLSRV_PARAM_IN),
    array($_POST['condition13'], SQLSRV_PARAM_IN),
    array($_POST['condition14'], SQLSRV_PARAM_IN),
    array($_POST['condition15'], SQLSRV_PARAM_IN),
    array($_POST['condition16'], SQLSRV_PARAM_IN),
    array($_POST['condition17'], SQLSRV_PARAM_IN),
    array($_POST['condition18'], SQLSRV_PARAM_IN)
    );
  
    $query_confirmp1 = sqlsrv_query($conn, $sql_confirmp1, $params_confirmp1);
    $result_confirmp1 = sqlsrv_fetch_array($query_confirmp1, SQLSRV_FETCH_ASSOC);
    echo $result_confirmp1['RS'];
  
}
// CONFIRMED BUTTON 
if ($_POST['txt_flg'] == "save_confirm_driver_p2") {

    $sql_confirmp2 = "{call megDrivingPatternDriverNewV2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}"; 
    $params_confirmp2 = array(
    array('save_confirm_driver_p2', SQLSRV_PARAM_IN),
    array($_POST['employeecode'], SQLSRV_PARAM_IN),
    array($_POST['condition1'], SQLSRV_PARAM_IN),
    array($_POST['condition2'], SQLSRV_PARAM_IN),
    array($_POST['condition3'], SQLSRV_PARAM_IN),
    array($_POST['condition4'], SQLSRV_PARAM_IN),
    array($_POST['condition5'], SQLSRV_PARAM_IN),
    array($_POST['condition6'], SQLSRV_PARAM_IN),
    array($_POST['condition7'], SQLSRV_PARAM_IN),
    array($_POST['condition8'], SQLSRV_PARAM_IN),
    array($_POST['condition9'], SQLSRV_PARAM_IN),
    array($_POST['condition10'], SQLSRV_PARAM_IN),
    array($_POST['condition11'], SQLSRV_PARAM_IN),
    array($_POST['condition12'], SQLSRV_PARAM_IN),
    array($_POST['condition13'], SQLSRV_PARAM_IN),
    array($_POST['condition14'], SQLSRV_PARAM_IN),
    array($_POST['condition15'], SQLSRV_PARAM_IN),
    array($_POST['condition16'], SQLSRV_PARAM_IN),
    array($_POST['condition17'], SQLSRV_PARAM_IN),
    array($_POST['condition18'], SQLSRV_PARAM_IN)
    );
  
    $query_confirmp2 = sqlsrv_query($conn, $sql_confirmp2, $params_confirmp2);
    $result_confirmp2 = sqlsrv_fetch_array($query_confirmp2, SQLSRV_FETCH_ASSOC);
    echo $result_confirmp2['RS'];
  
}
// CONFIRMED BUTTON 
if ($_POST['txt_flg'] == "save_confirm_driver_p3") {


    $sql_confirmp3 = "{call megDrivingPatternDriverNewV2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}"; 
    $params_confirmp3 = array(
    array('save_confirm_driver_p3', SQLSRV_PARAM_IN),
    array($_POST['employeecode'], SQLSRV_PARAM_IN),
    array($_POST['condition1'], SQLSRV_PARAM_IN),
    array($_POST['condition2'], SQLSRV_PARAM_IN),
    array($_POST['condition3'], SQLSRV_PARAM_IN),
    array($_POST['condition4'], SQLSRV_PARAM_IN),
    array($_POST['condition5'], SQLSRV_PARAM_IN),
    array($_POST['condition6'], SQLSRV_PARAM_IN),
    array($_POST['condition7'], SQLSRV_PARAM_IN),
    array($_POST['condition8'], SQLSRV_PARAM_IN),
    array($_POST['condition9'], SQLSRV_PARAM_IN),
    array($_POST['condition10'], SQLSRV_PARAM_IN),
    array($_POST['condition11'], SQLSRV_PARAM_IN),
    array($_POST['condition12'], SQLSRV_PARAM_IN),
    array($_POST['condition13'], SQLSRV_PARAM_IN),
    array($_POST['condition14'], SQLSRV_PARAM_IN),
    array($_POST['condition15'], SQLSRV_PARAM_IN),
    array($_POST['condition16'], SQLSRV_PARAM_IN),
    array($_POST['condition17'], SQLSRV_PARAM_IN),
    array($_POST['condition18'], SQLSRV_PARAM_IN)
    );
  
    $query_confirmp3 = sqlsrv_query($conn, $sql_confirmp3, $params_confirmp3);
    $result_confirmp3 = sqlsrv_fetch_array($query_confirmp3, SQLSRV_FETCH_ASSOC);
    echo $result_confirmp3['RS'];
  
}
// CONFIRMED BUTTON 
if ($_POST['txt_flg'] == "save_confirm_driver_p4") {


    $sql_confirmp4 = "{call megDrivingPatternDriverNewV2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}"; 
    $params_confirmp4 = array(
    array('save_confirm_driver_p4', SQLSRV_PARAM_IN),
    array($_POST['employeecode'], SQLSRV_PARAM_IN),
    array($_POST['condition1'], SQLSRV_PARAM_IN),
    array($_POST['condition2'], SQLSRV_PARAM_IN),
    array($_POST['condition3'], SQLSRV_PARAM_IN),
    array($_POST['condition4'], SQLSRV_PARAM_IN),
    array($_POST['condition5'], SQLSRV_PARAM_IN),
    array($_POST['condition6'], SQLSRV_PARAM_IN),
    array($_POST['condition7'], SQLSRV_PARAM_IN),
    array($_POST['condition8'], SQLSRV_PARAM_IN),
    array($_POST['condition9'], SQLSRV_PARAM_IN),
    array($_POST['condition10'], SQLSRV_PARAM_IN),
    array($_POST['condition11'], SQLSRV_PARAM_IN),
    array($_POST['condition12'], SQLSRV_PARAM_IN),
    array($_POST['condition13'], SQLSRV_PARAM_IN),
    array($_POST['condition14'], SQLSRV_PARAM_IN),
    array($_POST['condition15'], SQLSRV_PARAM_IN),
    array($_POST['condition16'], SQLSRV_PARAM_IN),
    array($_POST['condition17'], SQLSRV_PARAM_IN),
    array($_POST['condition18'], SQLSRV_PARAM_IN)
    );
  
    $query_confirmp4 = sqlsrv_query($conn, $sql_confirmp4, $params_confirmp4);
    $result_confirmp4 = sqlsrv_fetch_array($query_confirmp3, SQLSRV_FETCH_ASSOC);
    echo $result_confirmp4['RS'];
  
}
// CONFIRMED BUTTON 
if ($_POST['txt_flg'] == "save_confirm_driver_p5") {


    $sql_confirmp5 = "{call megDrivingPatternDriverNewV2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}"; 
    $params_confirmp5 = array(
    array('save_confirm_driver_p5', SQLSRV_PARAM_IN),
    array($_POST['employeecode'], SQLSRV_PARAM_IN),
    array($_POST['condition1'], SQLSRV_PARAM_IN),
    array($_POST['condition2'], SQLSRV_PARAM_IN),
    array($_POST['condition3'], SQLSRV_PARAM_IN),
    array($_POST['condition4'], SQLSRV_PARAM_IN),
    array($_POST['condition5'], SQLSRV_PARAM_IN),
    array($_POST['condition6'], SQLSRV_PARAM_IN),
    array($_POST['condition7'], SQLSRV_PARAM_IN),
    array($_POST['condition8'], SQLSRV_PARAM_IN),
    array($_POST['condition9'], SQLSRV_PARAM_IN),
    array($_POST['condition10'], SQLSRV_PARAM_IN),
    array($_POST['condition11'], SQLSRV_PARAM_IN),
    array($_POST['condition12'], SQLSRV_PARAM_IN),
    array($_POST['condition13'], SQLSRV_PARAM_IN),
    array($_POST['condition14'], SQLSRV_PARAM_IN),
    array($_POST['condition15'], SQLSRV_PARAM_IN),
    array($_POST['condition16'], SQLSRV_PARAM_IN),
    array($_POST['condition17'], SQLSRV_PARAM_IN),
    array($_POST['condition18'], SQLSRV_PARAM_IN)
    );
  
    $query_confirmp5 = sqlsrv_query($conn, $sql_confirmp5, $params_confirmp5);
    $result_confirmp5 = sqlsrv_fetch_array($query_confirmp5, SQLSRV_FETCH_ASSOC);
    echo $result_confirmp5['RS'];
  
}
// CONFIRMED BUTTON 
if ($_POST['txt_flg'] == "save_confirm_driver_p6") {


    $sql_confirmp6 = "{call megDrivingPatternDriverNewV2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}"; 
    $params_confirmp6 = array(
    array('save_confirm_driver_p6', SQLSRV_PARAM_IN),
    array($_POST['employeecode'], SQLSRV_PARAM_IN),
    array($_POST['condition1'], SQLSRV_PARAM_IN),
    array($_POST['condition2'], SQLSRV_PARAM_IN),
    array($_POST['condition3'], SQLSRV_PARAM_IN),
    array($_POST['condition4'], SQLSRV_PARAM_IN),
    array($_POST['condition5'], SQLSRV_PARAM_IN),
    array($_POST['condition6'], SQLSRV_PARAM_IN),
    array($_POST['condition7'], SQLSRV_PARAM_IN),
    array($_POST['condition8'], SQLSRV_PARAM_IN),
    array($_POST['condition9'], SQLSRV_PARAM_IN),
    array($_POST['condition10'], SQLSRV_PARAM_IN),
    array($_POST['condition11'], SQLSRV_PARAM_IN),
    array($_POST['condition12'], SQLSRV_PARAM_IN),
    array($_POST['condition13'], SQLSRV_PARAM_IN),
    array($_POST['condition14'], SQLSRV_PARAM_IN),
    array($_POST['condition15'], SQLSRV_PARAM_IN),
    array($_POST['condition16'], SQLSRV_PARAM_IN),
    array($_POST['condition17'], SQLSRV_PARAM_IN),
    array($_POST['condition18'], SQLSRV_PARAM_IN)
    );
  
    $query_confirmp6 = sqlsrv_query($conn, $sql_confirmp6, $params_confirmp6);
    $result_confirmp6 = sqlsrv_fetch_array($query_confirmp6, SQLSRV_FETCH_ASSOC);
    echo $result_confirmp6['RS'];
  
}
// SAVE ACTUAL ALL LOAD
if ($_POST['txt_flg'] == "save_confirm_driver_allload") {


    $sql_confirmactualallload = "{call megDrivingPatternDriverNewV2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}"; 
    $params_confirmactualallload = array(
        array('save_confirm_driver_allload', SQLSRV_PARAM_IN),
        array($_POST['employeecode'], SQLSRV_PARAM_IN),
        array($_POST['condition1'], SQLSRV_PARAM_IN),
        array($_POST['condition2'], SQLSRV_PARAM_IN),
        array($_POST['condition3'], SQLSRV_PARAM_IN),
        array($_POST['condition4'], SQLSRV_PARAM_IN),
        array($_POST['condition5'], SQLSRV_PARAM_IN),
        array($_POST['condition6'], SQLSRV_PARAM_IN),
        array($_POST['condition7'], SQLSRV_PARAM_IN),
        array($_POST['condition8'], SQLSRV_PARAM_IN),
        array($_POST['condition9'], SQLSRV_PARAM_IN),
        array($_POST['condition10'], SQLSRV_PARAM_IN),
        array($_POST['condition11'], SQLSRV_PARAM_IN),
        array($_POST['condition12'], SQLSRV_PARAM_IN),
        array($_POST['condition13'], SQLSRV_PARAM_IN),
        array($_POST['condition14'], SQLSRV_PARAM_IN),
        array($_POST['condition15'], SQLSRV_PARAM_IN),
        array($_POST['condition16'], SQLSRV_PARAM_IN),
        array($_POST['condition17'], SQLSRV_PARAM_IN),
        array($_POST['condition18'], SQLSRV_PARAM_IN)
        );
  
    $query_confirmactualallload = sqlsrv_query($conn, $sql_confirmactualallload, $params_confirmactualallload);
    $result_confirmactualallload = sqlsrv_fetch_array($query_confirmactualallload, SQLSRV_FETCH_ASSOC);
    echo $result_confirmactualallload['RS'];

//     $sql_updatedata = "UPDATE DRIVINGPATTERN_GO 
//         SET JOBSTARTACTUAL ='RRR'
//         WHERE DRIVINGPATTERNGO_ID = '8'";
// $query_updatedata  = sqlsrv_query($conn, $sql_updatedata, $params_updatedata);
// $result_updatedata = sqlsrv_fetch_array($query_updatedata, SQLSRV_FETCH_ASSOC); 
  
}
// UNLOCK P1
if ($_POST['txt_flg'] == "unlockP1") {


$sql_updatedata = "UPDATE  DRIVINGPATTERN_GO
    SET STATUS_UNLOCK_P1 ='YES',UNLOCK_BY_P1='" . $_POST['unlockby'] . "',UNLOCK_DATE_P1 = GETDATE()
    WHERE DRIVINGPATTERNGO_ID ='" . $_POST['drivinggoplanid'] . "'";
$query_updatedata  = sqlsrv_query($conn, $sql_updatedata, $params_updatedata);
$result_updatedata = sqlsrv_fetch_array($query_updatedata, SQLSRV_FETCH_ASSOC);    
  
}
// UNLOCK P2
if ($_POST['txt_flg'] == "unlockP2") {


$sql_updatedata = "UPDATE  DRIVINGPATTERN_GO
    SET STATUS_UNLOCK_P2 ='YES',UNLOCK_BY_P2 ='" . $_POST['unlockby'] . "',UNLOCK_DATE_P2 = GETDATE()
    WHERE DRIVINGPATTERNGO_ID ='" . $_POST['drivinggoplanid'] . "'";
$query_updatedata  = sqlsrv_query($conn, $sql_updatedata, $params_updatedata);
$result_updatedata = sqlsrv_fetch_array($query_updatedata, SQLSRV_FETCH_ASSOC);      
  
}
// UNLOCK P3
if ($_POST['txt_flg'] == "unlockP3") {


$sql_updatedata = "UPDATE  DRIVINGPATTERN_GO
    SET STATUS_UNLOCK_P3 ='YES',UNLOCK_BY_P3 ='" . $_POST['unlockby'] . "',UNLOCK_DATE_P3 = GETDATE()
    WHERE DRIVINGPATTERNGO_ID ='" . $_POST['drivinggoplanid'] . "'";
$query_updatedata  = sqlsrv_query($conn, $sql_updatedata, $params_updatedata);
$result_updatedata = sqlsrv_fetch_array($query_updatedata, SQLSRV_FETCH_ASSOC);      
  
}
// UNLOCK P4
if ($_POST['txt_flg'] == "unlockP4") {


$sql_updatedata = "UPDATE  DRIVINGPATTERN_GO
    SET STATUS_UNLOCK_P4 ='YES',UNLOCK_BY_P4 ='" . $_POST['unlockby'] . "',UNLOCK_DATE_P4 = GETDATE()
    WHERE DRIVINGPATTERNGO_ID ='" . $_POST['drivinggoplanid'] . "'";
$query_updatedata  = sqlsrv_query($conn, $sql_updatedata, $params_updatedata);
$result_updatedata = sqlsrv_fetch_array($query_updatedata, SQLSRV_FETCH_ASSOC);      
  
}
// UNLOCK P5
if ($_POST['txt_flg'] == "unlockP5") {


$sql_updatedata = "UPDATE  DRIVINGPATTERN_GO
    SET STATUS_UNLOCK_P5 ='YES',UNLOCK_BY_P5 ='" . $_POST['unlockby'] . "',UNLOCK_DATE_P5 = GETDATE()
    WHERE DRIVINGPATTERNGO_ID ='" . $_POST['drivinggoplanid'] . "'";
$query_updatedata  = sqlsrv_query($conn, $sql_updatedata, $params_updatedata);
$result_updatedata = sqlsrv_fetch_array($query_updatedata, SQLSRV_FETCH_ASSOC);      
  
}
// UNLOCK P6
if ($_POST['txt_flg'] == "unlockP6") {


$sql_updatedata = "UPDATE  DRIVINGPATTERN_GO
    SET STATUS_UNLOCK_P6 ='YES',UNLOCK_BY_P6 ='" . $_POST['unlockby'] . "',UNLOCK_DATE_P6 = GETDATE()
    WHERE DRIVINGPATTERNGO_ID ='" . $_POST['drivinggoplanid'] . "'";
$query_updatedata  = sqlsrv_query($conn, $sql_updatedata, $params_updatedata);
$result_updatedata = sqlsrv_fetch_array($query_updatedata, SQLSRV_FETCH_ASSOC);      
  
}
?>


<?php
sqlsrv_close($conn);
?>

