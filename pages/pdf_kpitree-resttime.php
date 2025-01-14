<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");


if ($_GET['area'] == 'amata') {
    $sql_seSystime = "SELECT REPLACE(CONVERT(VARCHAR,CONVERT(DATE,'" . $_GET['startdate'] . "',103), 106),SUBSTRING(CONVERT(VARCHAR,CONVERT(DATE,'" . $_GET['startdate'] . "',103), 106),1,3),'') AS 'MMYYY'";
    $params_seSystime = array();
    $query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
    $result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_1 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_1 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('01 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_1 = sqlsrv_query($conn, $sql_seResttime_1, $params_seResttime_1);
    $result_seResttime_1 = sqlsrv_fetch_array($query_seResttime_1, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_2 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_2 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('02 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_2 = sqlsrv_query($conn, $sql_seResttime_2, $params_seResttime_2);
    $result_seResttime_2 = sqlsrv_fetch_array($query_seResttime_2, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_3 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_3 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('03 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_3 = sqlsrv_query($conn, $sql_seResttime_3, $params_seResttime_3);
    $result_seResttime_3 = sqlsrv_fetch_array($query_seResttime_3, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_4 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_4 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('04 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_4 = sqlsrv_query($conn, $sql_seResttime_4, $params_seResttime_4);
    $result_seResttime_4 = sqlsrv_fetch_array($query_seResttime_4, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_5 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_5 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('05 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_5 = sqlsrv_query($conn, $sql_seResttime_5, $params_seResttime_5);
    $result_seResttime_5 = sqlsrv_fetch_array($query_seResttime_5, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_6 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_6 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('06 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_6 = sqlsrv_query($conn, $sql_seResttime_6, $params_seResttime_6);
    $result_seResttime_6 = sqlsrv_fetch_array($query_seResttime_6, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_7 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_7 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('07 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_7 = sqlsrv_query($conn, $sql_seResttime_7, $params_seResttime_7);
    $result_seResttime_7 = sqlsrv_fetch_array($query_seResttime_7, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_8 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_8 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('08 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_8 = sqlsrv_query($conn, $sql_seResttime_8, $params_seResttime_8);
    $result_seResttime_8 = sqlsrv_fetch_array($query_seResttime_8, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_9 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_9 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('09 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_9 = sqlsrv_query($conn, $sql_seResttime_9, $params_seResttime_9);
    $result_seResttime_9 = sqlsrv_fetch_array($query_seResttime_9, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_10 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_10 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('10 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_10 = sqlsrv_query($conn, $sql_seResttime_10, $params_seResttime_10);
    $result_seResttime_10 = sqlsrv_fetch_array($query_seResttime_10, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_11 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_11 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('11 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_11 = sqlsrv_query($conn, $sql_seResttime_11, $params_seResttime_11);
    $result_seResttime_11 = sqlsrv_fetch_array($query_seResttime_11, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_12 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_12 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('12 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_12 = sqlsrv_query($conn, $sql_seResttime_12, $params_seResttime_12);
    $result_seResttime_12 = sqlsrv_fetch_array($query_seResttime_12, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_13 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_13 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('13 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_13 = sqlsrv_query($conn, $sql_seResttime_13, $params_seResttime_13);
    $result_seResttime_13 = sqlsrv_fetch_array($query_seResttime_13, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_14 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_14 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('14 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_14 = sqlsrv_query($conn, $sql_seResttime_14, $params_seResttime_14);
    $result_seResttime_14 = sqlsrv_fetch_array($query_seResttime_14, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_15 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_15 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('15 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_15 = sqlsrv_query($conn, $sql_seResttime_15, $params_seResttime_15);
    $result_seResttime_15 = sqlsrv_fetch_array($query_seResttime_15, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_16 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_16 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('16 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_16 = sqlsrv_query($conn, $sql_seResttime_16, $params_seResttime_16);
    $result_seResttime_16 = sqlsrv_fetch_array($query_seResttime_16, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_17 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_17 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('17 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_17 = sqlsrv_query($conn, $sql_seResttime_17, $params_seResttime_17);
    $result_seResttime_17 = sqlsrv_fetch_array($query_seResttime_17, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_18 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_18 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('18 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_18 = sqlsrv_query($conn, $sql_seResttime_18, $params_seResttime_18);
    $result_seResttime_18 = sqlsrv_fetch_array($query_seResttime_18, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_19 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_19 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('19 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_19 = sqlsrv_query($conn, $sql_seResttime_19, $params_seResttime_19);
    $result_seResttime_19 = sqlsrv_fetch_array($query_seResttime_19, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_20 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_20 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('20 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_20 = sqlsrv_query($conn, $sql_seResttime_20, $params_seResttime_20);
    $result_seResttime_20 = sqlsrv_fetch_array($query_seResttime_20, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_21 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_21 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('21 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_21 = sqlsrv_query($conn, $sql_seResttime_21, $params_seResttime_21);
    $result_seResttime_21 = sqlsrv_fetch_array($query_seResttime_21, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_22 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_22 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('22 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_22 = sqlsrv_query($conn, $sql_seResttime_22, $params_seResttime_22);
    $result_seResttime_22 = sqlsrv_fetch_array($query_seResttime_22, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_23 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_23 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('23 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_23 = sqlsrv_query($conn, $sql_seResttime_23, $params_seResttime_23);
    $result_seResttime_23 = sqlsrv_fetch_array($query_seResttime_23, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_24 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_24 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('24 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_24 = sqlsrv_query($conn, $sql_seResttime_24, $params_seResttime_24);
    $result_seResttime_24 = sqlsrv_fetch_array($query_seResttime_24, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_25 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_25 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('25 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_25 = sqlsrv_query($conn, $sql_seResttime_25, $params_seResttime_25);
    $result_seResttime_25 = sqlsrv_fetch_array($query_seResttime_25, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_26 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_26 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('26 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_26 = sqlsrv_query($conn, $sql_seResttime_26, $params_seResttime_26);
    $result_seResttime_26 = sqlsrv_fetch_array($query_seResttime_26, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_27 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_27 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('27 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_27 = sqlsrv_query($conn, $sql_seResttime_27, $params_seResttime_27);
    $result_seResttime_27 = sqlsrv_fetch_array($query_seResttime_27, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_28 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_28 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('28 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_28 = sqlsrv_query($conn, $sql_seResttime_28, $params_seResttime_28);
    $result_seResttime_28 = sqlsrv_fetch_array($query_seResttime_28, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_29 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_29 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('29 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_29 = sqlsrv_query($conn, $sql_seResttime_29, $params_seResttime_29);
    $result_seResttime_29 = sqlsrv_fetch_array($query_seResttime_29, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_30 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_30 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('30 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_30 = sqlsrv_query($conn, $sql_seResttime_30, $params_seResttime_30);
    $result_seResttime_30 = sqlsrv_fetch_array($query_seResttime_30, SQLSRV_FETCH_ASSOC);

    $sql_seResttime_31 = "{call megKpitree_v2(?,?)}";
    $params_seResttime_31 = array(
        array('select_resttime', SQLSRV_PARAM_IN),
        array('31 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttime_31 = sqlsrv_query($conn, $sql_seResttime_31, $params_seResttime_31);
    $result_seResttime_31 = sqlsrv_fetch_array($query_seResttime_31, SQLSRV_FETCH_ASSOC);



    $sql_seResttimeng_1 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_1 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('01 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_1 = sqlsrv_query($conn, $sql_seResttimeng_1, $params_seResttimeng_1);
    $result_seResttimeng_1 = sqlsrv_fetch_array($query_seResttimeng_1, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_2 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_2 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('02 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_2 = sqlsrv_query($conn, $sql_seResttimeng_2, $params_seResttimeng_2);
    $result_seResttimeng_2 = sqlsrv_fetch_array($query_seResttimeng_2, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_3 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_3 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('03 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_3 = sqlsrv_query($conn, $sql_seResttimeng_3, $params_seResttimeng_3);
    $result_seResttimeng_3 = sqlsrv_fetch_array($query_seResttimeng_3, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_4 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_4 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('04 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_4 = sqlsrv_query($conn, $sql_seResttimeng_4, $params_seResttimeng_4);
    $result_seResttimeng_4 = sqlsrv_fetch_array($query_seResttimeng_4, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_5 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_5 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('05 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_5 = sqlsrv_query($conn, $sql_seResttimeng_5, $params_seResttimeng_5);
    $result_seResttimeng_5 = sqlsrv_fetch_array($query_seResttimeng_5, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_6 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_6 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('06 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_6 = sqlsrv_query($conn, $sql_seResttimeng_6, $params_seResttimeng_6);
    $result_seResttimeng_6 = sqlsrv_fetch_array($query_seResttimeng_6, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_7 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_7 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('07 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_7 = sqlsrv_query($conn, $sql_seResttimeng_7, $params_seResttimeng_7);
    $result_seResttimeng_7 = sqlsrv_fetch_array($query_seResttimeng_7, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_8 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_8 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('08 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_8 = sqlsrv_query($conn, $sql_seResttimeng_8, $params_seResttimeng_8);
    $result_seResttimeng_8 = sqlsrv_fetch_array($query_seResttimeng_8, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_9 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_9 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('09 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_9 = sqlsrv_query($conn, $sql_seResttimeng_9, $params_seResttimeng_9);
    $result_seResttimeng_9 = sqlsrv_fetch_array($query_seResttimeng_9, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_10 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_10 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('10 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_10 = sqlsrv_query($conn, $sql_seResttimeng_10, $params_seResttimeng_10);
    $result_seResttimeng_10 = sqlsrv_fetch_array($query_seResttimeng_10, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_11 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_11 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('11 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_11 = sqlsrv_query($conn, $sql_seResttimeng_11, $params_seResttimeng_11);
    $result_seResttimeng_11 = sqlsrv_fetch_array($query_seResttimeng_11, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_12 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_12 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('12 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_12 = sqlsrv_query($conn, $sql_seResttimeng_12, $params_seResttimeng_12);
    $result_seResttimeng_12 = sqlsrv_fetch_array($query_seResttimeng_12, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_13 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_13 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('13 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_13 = sqlsrv_query($conn, $sql_seResttimeng_13, $params_seResttimeng_13);
    $result_seResttimeng_13 = sqlsrv_fetch_array($query_seResttimeng_13, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_14 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_14 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('14 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_14 = sqlsrv_query($conn, $sql_seResttimeng_14, $params_seResttimeng_14);
    $result_seResttimeng_14 = sqlsrv_fetch_array($query_seResttimeng_14, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_15 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_15 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('15 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_15 = sqlsrv_query($conn, $sql_seResttimeng_15, $params_seResttimeng_15);
    $result_seResttimeng_15 = sqlsrv_fetch_array($query_seResttimeng_15, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_16 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_16 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('16 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_16 = sqlsrv_query($conn, $sql_seResttimeng_16, $params_seResttimeng_16);
    $result_seResttimeng_16 = sqlsrv_fetch_array($query_seResttimeng_16, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_17 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_17 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('17 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_17 = sqlsrv_query($conn, $sql_seResttimeng_17, $params_seResttimeng_17);
    $result_seResttimeng_17 = sqlsrv_fetch_array($query_seResttimeng_17, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_18 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_18 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('18 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_18 = sqlsrv_query($conn, $sql_seResttimeng_18, $params_seResttimeng_18);
    $result_seResttimeng_18 = sqlsrv_fetch_array($query_seResttimeng_18, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_19 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_19 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('19 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_19 = sqlsrv_query($conn, $sql_seResttimeng_19, $params_seResttimeng_19);
    $result_seResttimeng_19 = sqlsrv_fetch_array($query_seResttimeng_19, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_20 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_20 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('20 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_20 = sqlsrv_query($conn, $sql_seResttimeng_20, $params_seResttimeng_20);
    $result_seResttimeng_20 = sqlsrv_fetch_array($query_seResttimeng_20, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_21 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_21 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('21 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_21 = sqlsrv_query($conn, $sql_seResttimeng_21, $params_seResttimeng_21);
    $result_seResttimeng_21 = sqlsrv_fetch_array($query_seResttimeng_21, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_22 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_22 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('22 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_22 = sqlsrv_query($conn, $sql_seResttimeng_22, $params_seResttimeng_22);
    $result_seResttimeng_22 = sqlsrv_fetch_array($query_seResttimeng_22, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_23 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_23 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('23 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_23 = sqlsrv_query($conn, $sql_seResttimeng_23, $params_seResttimeng_23);
    $result_seResttimeng_23 = sqlsrv_fetch_array($query_seResttimeng_23, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_24 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_24 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('24 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_24 = sqlsrv_query($conn, $sql_seResttimeng_24, $params_seResttimeng_24);
    $result_seResttimeng_24 = sqlsrv_fetch_array($query_seResttimeng_24, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_25 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_25 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('25 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_25 = sqlsrv_query($conn, $sql_seResttimeng_25, $params_seResttimeng_25);
    $result_seResttimeng_25 = sqlsrv_fetch_array($query_seResttimeng_25, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_26 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_26 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('26 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_26 = sqlsrv_query($conn, $sql_seResttimeng_26, $params_seResttimeng_26);
    $result_seResttimeng_26 = sqlsrv_fetch_array($query_seResttimeng_26, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_27 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_27 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('27 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_27 = sqlsrv_query($conn, $sql_seResttimeng_27, $params_seResttimeng_27);
    $result_seResttimeng_27 = sqlsrv_fetch_array($query_seResttimeng_27, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_28 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_28 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('28 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_28 = sqlsrv_query($conn, $sql_seResttimeng_28, $params_seResttimeng_28);
    $result_seResttimeng_28 = sqlsrv_fetch_array($query_seResttimeng_28, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_29 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_29 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('29 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_29 = sqlsrv_query($conn, $sql_seResttimeng_29, $params_seResttimeng_29);
    $result_seResttimeng_29 = sqlsrv_fetch_array($query_seResttimeng_29, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_30 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_30 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('30 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_30 = sqlsrv_query($conn, $sql_seResttimeng_30, $params_seResttimeng_30);
    $result_seResttimeng_30 = sqlsrv_fetch_array($query_seResttimeng_30, SQLSRV_FETCH_ASSOC);

    $sql_seResttimeng_31 = "{call megKpitree_v2(?,?)}";
    $params_seResttimeng_31 = array(
        array('select_resttimeng', SQLSRV_PARAM_IN),
        array('31 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_seResttimeng_31 = sqlsrv_query($conn, $sql_seResttimeng_31, $params_seResttimeng_31);
    $result_seResttimeng_31 = sqlsrv_fetch_array($query_seResttimeng_31, SQLSRV_FETCH_ASSOC);
}
?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<figure class="highcharts-figure">
    <table style="width: 100%;font-size: 12px">
        <tbody>
            <tr>
                <td colspan="4">
                    <h3 style="text-align: center">< เวลาพักผ่อน Rest Time > <?= $result_seSystime['MMYYY'] ?></h3>
                </td>

            </tr>
            <tr>
                <td colspan="4" style="width: 20%">
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td colspan="4" style="width: 20%">
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td style="width: 20%">

                </td>
                <td style="width: 50%">

                </td>
                <td style="width: 10%">

                </td>
                <td style="width: 20%">
                    วันที่จัดทำ 1 เมษายน 2562
                </td>
            </tr>
            <tr>
                <td style="width: 20%">
                    วัตถุประสงค์
                </td>
                <td style="width: 50%">
                    : เพื่อให้พนักงานขับรถได้พักผ่อนและฟื้นฟูร่างกายให้พร้อมทำงาน
                </td>
                <td style="width: 10%">

                </td>
                <td style="width: 20%">
                    การแก้ไขครั้งที่ 1
                </td>
            </tr>
            <tr>
                <td style="width: 20%">
                    Purpose
                </td>
                <td style="width: 50%">
                    : To let driver rest and recover his fatigue for Ready to Work on Today
                </td>
                <td style="width: 10%">

                </td>
                <td style="width: 20%">
                    Date issue 1 Apr'2019
                </td>
            </tr>
            <tr>
                <td style="width: 20%">

                </td>
                <td style="width: 50%">

                </td>
                <td style="width: 10%">

                </td>
                <td style="width: 20%">
                    Rev.1
                </td>
            </tr>
            <tr>
                <td style="width: 20%">
                    เกณฑ์การตัดสินใจ
                </td>
                <td style="width: 50%">
                    : พักผ่อนไม่น้อยกว่า 8 ชั่วโมง
                </td>
                <td style="width: 10%">
                    เวลาปรับข้อมูล
                </td>
                <td style="width: 20%">
                    : ทุกวัน เวลา 10:00 am
                </td>
            </tr>
            <tr>
                <td style="width: 20%">
                    Data Source
                </td>
                <td style="width: 50%">
                    : Finish time from Self Check Sheet (Last Job) - Current Start Tenko Time
                </td>
                <td style="width: 10%">

                </td>
                <td style="width: 20%">
                    : Daily @ 10:00 am
                </td>
            </tr>
            <tr>
                <td colspan="4" style="width: 20%">
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td colspan="4" style="width: 20%">
                    &nbsp;
                </td>
            </tr>
        </tbody>
    </table>




    <div id="container"></div>

    <table style="width: 100%;font-size: 12px">
        <tbody>

            <tr>
                <td colspan="4" style="width: 20%">
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td colspan="4" style="width: 20%">
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td style="width: 20%">
                    กรณีมี NG
                </td>
                <td style="width: 80%">
                    : แนะนำและติดตามพนักงานคนนั้นเป็นพิเศษ
                </td>

            </tr>
            <tr>
                <td style="width: 20%">
                    If found NG
                </td>
                <td style="width: 80%">
                    : Instruct and Follow by Each Driver
                </td>

            </tr>
            <tr>
                <td style="width: 20%">

                </td>
                <td style="width: 80%">
                    1. ไม่จ่ายงานให้ พนักงาน / Don't Give Job to Driver
                </td>

            </tr>
            <tr>
                <td style="width: 20%">

                </td>
                <td style="width: 80%">
                    2. คอยติดตามปัญหาของ พนักงานขับรถคนนั้น / Follow Problem of Each Driver
                </td>

            </tr>
            <tr>
                <td colspan="4" style="width: 20%">
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td colspan="4" style="width: 20%">
                    &nbsp;
                </td>
            </tr>
        </tbody>
    </table>


</figure>

<style>
    .highcharts-figure, .highcharts-data-table table {
        min-width: 500px; 
        max-width: 800px;
        margin: 1em auto;
    }

    #container {
        height: 400px;
    }

    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #EBEBEB;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }
    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }
    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }
    .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
        padding: 0.5em;
    }
    .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }
    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }

</style>
<script>
    Highcharts.chart('container', {
        chart: {
            zoomType: 'xy'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: [{
                categories: ['1', '2', '3', '4', '5', '6',
                    '7', '8', '9', '10', '11', '12',
                    '13', '14', '15', '15', '16', '17',
                    '18', '19', '20', '21', '22', '23',
                    '24', '25', '26', '27', '28', '29', '30', '31'],
                crosshair: true
            }],
        yAxis: [{// Primary yAxis
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: 'Total (Driver)',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, {// Secondary yAxis
                title: {
                    text: 'NG',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }],
        tooltip: {
            shared: true
        },
        legend: {
            layout: 'vertical',
            align: 'left',
            x: 120,
            verticalAlign: 'top',
            y: 100,
            floating: true,
            backgroundColor:
                    Highcharts.defaultOptions.legend.backgroundColor || // theme
                    'rgba(255,255,255,0.25)'
        },
        series: [{
                name: 'NG',
                type: 'column',
                yAxis: 1,
                data: [<?= $result_seResttimeng_1['CNT'] ?>, <?= $result_seResttimeng_2['CNT'] ?>, <?= $result_seResttimeng_3['CNT'] ?>,
<?= $result_seResttimeng_4['CNT'] ?>, <?= $result_seResttimeng_5['CNT'] ?>, <?= $result_seResttimeng_6['CNT'] ?>,
<?= $result_seResttimeng_7['CNT'] ?>, <?= $result_seResttimeng_8['CNT'] ?>, <?= $result_seResttimeng_9['CNT'] ?>,
<?= $result_seResttimeng_10['CNT'] ?>, <?= $result_seResttimeng_11['CNT'] ?>, <?= $result_seResttimeng_12['CNT'] ?>,
<?= $result_seResttimeng_13['CNT'] ?>, <?= $result_seResttimeng_14['CNT'] ?>, <?= $result_seResttimeng_15['CNT'] ?>,
<?= $result_seResttimeng_16['CNT'] ?>, <?= $result_seResttimeng_17['CNT'] ?>, <?= $result_seResttimeng_18['CNT'] ?>,
<?= $result_seResttimeng_19['CNT'] ?>, <?= $result_seResttimeng_20['CNT'] ?>, <?= $result_seResttimeng_21['CNT'] ?>,
<?= $result_seResttimeng_22['CNT'] ?>, <?= $result_seResttimeng_23['CNT'] ?>, <?= $result_seResttimeng_24['CNT'] ?>,
<?= $result_seResttimeng_25['CNT'] ?>, <?= $result_seResttimeng_26['CNT'] ?>, <?= $result_seResttimeng_27['CNT'] ?>,
<?= $result_seResttimeng_28['CNT'] ?>, <?= $result_seResttimeng_29['CNT'] ?>, <?= $result_seResttimeng_30['CNT'] ?>,
<?= $result_seResttimeng_31['CNT'] ?>],
                tooltip: {
                    valueSuffix: ' mm'
                }

            }, {
                name: 'Total (Driver)',
                type: 'spline',

                data: [<?= $result_seResttime_1['CNT'] ?>, <?= $result_seResttime_2['CNT'] ?>, <?= $result_seResttime_3['CNT'] ?>,
<?= $result_seResttime_4['CNT'] ?>, <?= $result_seResttime_5['CNT'] ?>, <?= $result_seResttime_6['CNT'] ?>,
<?= $result_seResttime_7['CNT'] ?>, <?= $result_seResttime_8['CNT'] ?>, <?= $result_seResttime_9['CNT'] ?>,
<?= $result_seResttime_10['CNT'] ?>, <?= $result_seResttime_11['CNT'] ?>, <?= $result_seResttime_12['CNT'] ?>,
<?= $result_seResttime_13['CNT'] ?>, <?= $result_seResttime_14['CNT'] ?>, <?= $result_seResttime_15['CNT'] ?>,
<?= $result_seResttime_16['CNT'] ?>, <?= $result_seResttime_17['CNT'] ?>, <?= $result_seResttime_18['CNT'] ?>,
<?= $result_seResttime_19['CNT'] ?>, <?= $result_seResttime_20['CNT'] ?>, <?= $result_seResttime_21['CNT'] ?>,
<?= $result_seResttime_22['CNT'] ?>, <?= $result_seResttime_23['CNT'] ?>, <?= $result_seResttime_24['CNT'] ?>,
<?= $result_seResttime_25['CNT'] ?>, <?= $result_seResttime_26['CNT'] ?>, <?= $result_seResttime_27['CNT'] ?>,
<?= $result_seResttime_28['CNT'] ?>, <?= $result_seResttime_29['CNT'] ?>, <?= $result_seResttime_30['CNT'] ?>,
<?= $result_seResttime_31['CNT'] ?>],
                tooltip: {
                    valueSuffix: '°C'
                }
            }]
    });
</script>