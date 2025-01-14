<?php
    session_start();
    date_default_timezone_set("Asia/Bangkok");
    require_once("../../class/meg_function.php");
    ini_set('max_execution_time', 300); //300 seconds = 5 minutes
    ini_set('post_max_size','20M');
    ini_set('upload_max_filesize','2M');
    $conn = connect("RTMS");
?>
<?php
    $sql_rpavgday = "SELECT * FROM vwRPAVGDAY_GW";
    $query_rpavgday = sqlsrv_query($conn, $sql_rpavgday);
    while($result_rpavgday = sqlsrv_fetch_array($query_rpavgday, SQLSRV_FETCH_ASSOC)) {
        $PersonCode = $result_rpavgday['PersonCode'];
        $EMPLOYEECODE1 = $result_rpavgday['EMPLOYEECODE1'];
        $EMPLOYEECODE2 = $result_rpavgday['EMPLOYEECODE2'];
        $VEHICLETRANSPORTPLANID = $result_rpavgday['VEHICLETRANSPORTPLANID'];
        $DATEWORKING = $result_rpavgday['DATEWORKING'];
        $C3OLD = $result_rpavgday['C3OLD'];  
        $C3PLUS = $result_rpavgday['C3PLUS'];  
        $C3MINUS = $result_rpavgday['C3MINUS'];    
        $C3ZERO = $result_rpavgday['C3ZERO'];

        $check1 = "SELECT * FROM TEMP_RPAVGDAY_GW WHERE VEHICLETRANSPORTPLANID = '$VEHICLETRANSPORTPLANID' AND PersonCode = '$PersonCode' ";
        $querycheck1 = sqlsrv_query( $conn, $check1);
        $resultcheck1 = sqlsrv_fetch_array($querycheck1, SQLSRV_FETCH_ASSOC);
        $chk1null = $resultcheck1['RPAVGDAY_ID'];      

        if($chk1null == ""){
            $sql = "INSERT INTO TEMP_RPAVGDAY_GW (C3OLD,C3PLUS,C3MINUS,C3ZERO,PersonCode,EMPLOYEECODE1,EMPLOYEECODE2,CUSTOMERCODE,JOBEND,VEHICLETRANSPORTPLANID,DATEWORKING)
                SELECT * FROM vwRPAVGDAY_GW A WHERE NOT A.VEHICLETRANSPORTPLANID IN (SELECT DISTINCT B.VEHICLETRANSPORTPLANID FROM TEMP_RPAVGDAY_GW B WHERE B.VEHICLETRANSPORTPLANID = A.VEHICLETRANSPORTPLANID)";
            $stmt = sqlsrv_query($conn, $sql);
        }else{
            $sql = "UPDATE TEMP_RPAVGDAY_GW SET C3OLD=?,C3PLUS=?,C3MINUS=?,C3ZERO=? WHERE RPAVGDAY_ID=?";
            $params = array($C3OLD,$C3PLUS,$C3MINUS,$C3ZERO,$chk1null);
            $stmt = sqlsrv_query( $conn, $sql, $params);
        }
    }
    sqlsrv_close($conn);
?>
<script langauge="javascript">
    window.open('', '_self');
    self.close();
</script>