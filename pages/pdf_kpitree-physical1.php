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

    $sql_sePhysical1_1 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_1 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('01 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_1 = sqlsrv_query($conn, $sql_sePhysical1_1, $params_sePhysical1_1);
    $result_sePhysical1_1 = sqlsrv_fetch_array($query_sePhysical1_1, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_2 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_2 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('02 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_2 = sqlsrv_query($conn, $sql_sePhysical1_2, $params_sePhysical1_2);
    $result_sePhysical1_2 = sqlsrv_fetch_array($query_sePhysical1_2, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_3 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_3 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('03 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_3 = sqlsrv_query($conn, $sql_sePhysical1_3, $params_sePhysical1_3);
    $result_sePhysical1_3 = sqlsrv_fetch_array($query_sePhysical1_3, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_4 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_4 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('04 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_4 = sqlsrv_query($conn, $sql_sePhysical1_4, $params_sePhysical1_4);
    $result_sePhysical1_4 = sqlsrv_fetch_array($query_sePhysical1_4, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_5 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_5 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('05 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_5 = sqlsrv_query($conn, $sql_sePhysical1_5, $params_sePhysical1_5);
    $result_sePhysical1_5 = sqlsrv_fetch_array($query_sePhysical1_5, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_6 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_6 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('06 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_6 = sqlsrv_query($conn, $sql_sePhysical1_6, $params_sePhysical1_6);
    $result_sePhysical1_6 = sqlsrv_fetch_array($query_sePhysical1_6, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_7 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_7 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('07 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_7 = sqlsrv_query($conn, $sql_sePhysical1_7, $params_sePhysical1_7);
    $result_sePhysical1_7 = sqlsrv_fetch_array($query_sePhysical1_7, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_8 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_8 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('08 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_8 = sqlsrv_query($conn, $sql_sePhysical1_8, $params_sePhysical1_8);
    $result_sePhysical1_8 = sqlsrv_fetch_array($query_sePhysical1_8, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_9 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_9 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('09 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_9 = sqlsrv_query($conn, $sql_sePhysical1_9, $params_sePhysical1_9);
    $result_sePhysical1_9 = sqlsrv_fetch_array($query_sePhysical1_9, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_10 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_10 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('10 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_10 = sqlsrv_query($conn, $sql_sePhysical1_10, $params_sePhysical1_10);
    $result_sePhysical1_10 = sqlsrv_fetch_array($query_sePhysical1_10, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_11 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_11 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('11 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_11 = sqlsrv_query($conn, $sql_sePhysical1_11, $params_sePhysical1_11);
    $result_sePhysical1_11 = sqlsrv_fetch_array($query_sePhysical1_11, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_12 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_12 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('12 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_12 = sqlsrv_query($conn, $sql_sePhysical1_12, $params_sePhysical1_12);
    $result_sePhysical1_12 = sqlsrv_fetch_array($query_sePhysical1_12, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_13 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_13 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('13 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_13 = sqlsrv_query($conn, $sql_sePhysical1_13, $params_sePhysical1_13);
    $result_sePhysical1_13 = sqlsrv_fetch_array($query_sePhysical1_13, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_14 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_14 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('14 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_14 = sqlsrv_query($conn, $sql_sePhysical1_14, $params_sePhysical1_14);
    $result_sePhysical1_14 = sqlsrv_fetch_array($query_sePhysical1_14, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_15 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_15 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('15 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_15 = sqlsrv_query($conn, $sql_sePhysical1_15, $params_sePhysical1_15);
    $result_sePhysical1_15 = sqlsrv_fetch_array($query_sePhysical1_15, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_16 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_16 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('16 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_16 = sqlsrv_query($conn, $sql_sePhysical1_16, $params_sePhysical1_16);
    $result_sePhysical1_16 = sqlsrv_fetch_array($query_sePhysical1_16, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_17 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_17 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('17 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_17 = sqlsrv_query($conn, $sql_sePhysical1_17, $params_sePhysical1_17);
    $result_sePhysical1_17 = sqlsrv_fetch_array($query_sePhysical1_17, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_18 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_18 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('18 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_18 = sqlsrv_query($conn, $sql_sePhysical1_18, $params_sePhysical1_18);
    $result_sePhysical1_18 = sqlsrv_fetch_array($query_sePhysical1_18, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_19 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_19 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('19 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_19 = sqlsrv_query($conn, $sql_sePhysical1_19, $params_sePhysical1_19);
    $result_sePhysical1_19 = sqlsrv_fetch_array($query_sePhysical1_19, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_20 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_20 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('20 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_20 = sqlsrv_query($conn, $sql_sePhysical1_20, $params_sePhysical1_20);
    $result_sePhysical1_20 = sqlsrv_fetch_array($query_sePhysical1_20, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_21 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_21 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('21 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_21 = sqlsrv_query($conn, $sql_sePhysical1_21, $params_sePhysical1_21);
    $result_sePhysical1_21 = sqlsrv_fetch_array($query_sePhysical1_21, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_22 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_22 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('22 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_22 = sqlsrv_query($conn, $sql_sePhysical1_22, $params_sePhysical1_22);
    $result_sePhysical1_22 = sqlsrv_fetch_array($query_sePhysical1_22, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_23 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_23 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('23 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_23 = sqlsrv_query($conn, $sql_sePhysical1_23, $params_sePhysical1_23);
    $result_sePhysical1_23 = sqlsrv_fetch_array($query_sePhysical1_23, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_24 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_24 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('24 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_24 = sqlsrv_query($conn, $sql_sePhysical1_24, $params_sePhysical1_24);
    $result_sePhysical1_24 = sqlsrv_fetch_array($query_sePhysical1_24, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_25 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_25 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('25 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_25 = sqlsrv_query($conn, $sql_sePhysical1_25, $params_sePhysical1_25);
    $result_sePhysical1_25 = sqlsrv_fetch_array($query_sePhysical1_25, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_26 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_26 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('26 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_26 = sqlsrv_query($conn, $sql_sePhysical1_26, $params_sePhysical1_26);
    $result_sePhysical1_26 = sqlsrv_fetch_array($query_sePhysical1_26, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_27 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_27 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('27 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_27 = sqlsrv_query($conn, $sql_sePhysical1_27, $params_sePhysical1_27);
    $result_sePhysical1_27 = sqlsrv_fetch_array($query_sePhysical1_27, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_28 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_28 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('28 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_28 = sqlsrv_query($conn, $sql_sePhysical1_28, $params_sePhysical1_28);
    $result_sePhysical1_28 = sqlsrv_fetch_array($query_sePhysical1_28, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_29 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_29 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('29 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_29 = sqlsrv_query($conn, $sql_sePhysical1_29, $params_sePhysical1_29);
    $result_sePhysical1_29 = sqlsrv_fetch_array($query_sePhysical1_29, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_30 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_30 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('30 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_30 = sqlsrv_query($conn, $sql_sePhysical1_30, $params_sePhysical1_30);
    $result_sePhysical1_30 = sqlsrv_fetch_array($query_sePhysical1_30, SQLSRV_FETCH_ASSOC);

    $sql_sePhysical1_31 = "{call megKpitree_v2(?,?)}";
    $params_sePhysical1_31 = array(
        array('select_physical1', SQLSRV_PARAM_IN),
        array('31 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysical1_31 = sqlsrv_query($conn, $sql_sePhysical1_31, $params_sePhysical1_31);
    $result_sePhysical1_31 = sqlsrv_fetch_array($query_sePhysical1_31, SQLSRV_FETCH_ASSOC);



    $sql_sePhysicalng1_1 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_1 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('01 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_1 = sqlsrv_query($conn, $sql_sePhysicalng1_1, $params_sePhysicalng1_1);
    $result_sePhysicalng1_1 = sqlsrv_fetch_array($query_sePhysicalng1_1, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_2 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_2 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('02 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_2 = sqlsrv_query($conn, $sql_sePhysicalng1_2, $params_sePhysicalng1_2);
    $result_sePhysicalng1_2 = sqlsrv_fetch_array($query_sePhysicalng1_2, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_3 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_3 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('03 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_3 = sqlsrv_query($conn, $sql_sePhysicalng1_3, $params_sePhysicalng1_3);
    $result_sePhysicalng1_3 = sqlsrv_fetch_array($query_sePhysicalng1_3, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_4 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_4 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('04 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_4 = sqlsrv_query($conn, $sql_sePhysicalng1_4, $params_sePhysicalng1_4);
    $result_sePhysicalng1_4 = sqlsrv_fetch_array($query_sePhysicalng1_4, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_5 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_5 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('05 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_5 = sqlsrv_query($conn, $sql_sePhysicalng1_5, $params_sePhysicalng1_5);
    $result_sePhysicalng1_5 = sqlsrv_fetch_array($query_sePhysicalng1_5, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_6 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_6 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('06 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_6 = sqlsrv_query($conn, $sql_sePhysicalng1_6, $params_sePhysicalng1_6);
    $result_sePhysicalng1_6 = sqlsrv_fetch_array($query_sePhysicalng1_6, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_7 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_7 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('07 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_7 = sqlsrv_query($conn, $sql_sePhysicalng1_7, $params_sePhysicalng1_7);
    $result_sePhysicalng1_7 = sqlsrv_fetch_array($query_sePhysicalng1_7, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_8 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_8 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('08 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_8 = sqlsrv_query($conn, $sql_sePhysicalng1_8, $params_sePhysicalng1_8);
    $result_sePhysicalng1_8 = sqlsrv_fetch_array($query_sePhysicalng1_8, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_9 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_9 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('09 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_9 = sqlsrv_query($conn, $sql_sePhysicalng1_9, $params_sePhysicalng1_9);
    $result_sePhysicalng1_9 = sqlsrv_fetch_array($query_sePhysicalng1_9, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_10 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_10 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('10 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_10 = sqlsrv_query($conn, $sql_sePhysicalng1_10, $params_sePhysicalng1_10);
    $result_sePhysicalng1_10 = sqlsrv_fetch_array($query_sePhysicalng1_10, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_11 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_11 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('11 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_11 = sqlsrv_query($conn, $sql_sePhysicalng1_11, $params_sePhysicalng1_11);
    $result_sePhysicalng1_11 = sqlsrv_fetch_array($query_sePhysicalng1_11, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_12 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_12 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('12 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_12 = sqlsrv_query($conn, $sql_sePhysicalng1_12, $params_sePhysicalng1_12);
    $result_sePhysicalng1_12 = sqlsrv_fetch_array($query_sePhysicalng1_12, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_13 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_13 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('13 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_13 = sqlsrv_query($conn, $sql_sePhysicalng1_13, $params_sePhysicalng1_13);
    $result_sePhysicalng1_13 = sqlsrv_fetch_array($query_sePhysicalng1_13, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_14 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_14 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('14 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_14 = sqlsrv_query($conn, $sql_sePhysicalng1_14, $params_sePhysicalng1_14);
    $result_sePhysicalng1_14 = sqlsrv_fetch_array($query_sePhysicalng1_14, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_15 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_15 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('15 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_15 = sqlsrv_query($conn, $sql_sePhysicalng1_15, $params_sePhysicalng1_15);
    $result_sePhysicalng1_15 = sqlsrv_fetch_array($query_sePhysicalng1_15, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_16 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_16 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('16 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_16 = sqlsrv_query($conn, $sql_sePhysicalng1_16, $params_sePhysicalng1_16);
    $result_sePhysicalng1_16 = sqlsrv_fetch_array($query_sePhysicalng1_16, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_17 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_17 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('17 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_17 = sqlsrv_query($conn, $sql_sePhysicalng1_17, $params_sePhysicalng1_17);
    $result_sePhysicalng1_17 = sqlsrv_fetch_array($query_sePhysicalng1_17, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_18 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_18 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('18 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_18 = sqlsrv_query($conn, $sql_sePhysicalng1_18, $params_sePhysicalng1_18);
    $result_sePhysicalng1_18 = sqlsrv_fetch_array($query_sePhysicalng1_18, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_19 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_19 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('19 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_19 = sqlsrv_query($conn, $sql_sePhysicalng1_19, $params_sePhysicalng1_19);
    $result_sePhysicalng1_19 = sqlsrv_fetch_array($query_sePhysicalng1_19, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_20 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_20 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('20 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_20 = sqlsrv_query($conn, $sql_sePhysicalng1_20, $params_sePhysicalng1_20);
    $result_sePhysicalng1_20 = sqlsrv_fetch_array($query_sePhysicalng1_20, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_21 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_21 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('21 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_21 = sqlsrv_query($conn, $sql_sePhysicalng1_21, $params_sePhysicalng1_21);
    $result_sePhysicalng1_21 = sqlsrv_fetch_array($query_sePhysicalng1_21, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_22 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_22 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('22 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_22 = sqlsrv_query($conn, $sql_sePhysicalng1_22, $params_sePhysicalng1_22);
    $result_sePhysicalng1_22 = sqlsrv_fetch_array($query_sePhysicalng1_22, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_23 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_23 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('23 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_23 = sqlsrv_query($conn, $sql_sePhysicalng1_23, $params_sePhysicalng1_23);
    $result_sePhysicalng1_23 = sqlsrv_fetch_array($query_sePhysicalng1_23, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_24 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_24 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('24 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_24 = sqlsrv_query($conn, $sql_sePhysicalng1_24, $params_sePhysicalng1_24);
    $result_sePhysicalng1_24 = sqlsrv_fetch_array($query_sePhysicalng1_24, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_25 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_25 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('25 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_25 = sqlsrv_query($conn, $sql_sePhysicalng1_25, $params_sePhysicalng1_25);
    $result_sePhysicalng1_25 = sqlsrv_fetch_array($query_sePhysicalng1_25, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_26 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_26 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('26 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_26 = sqlsrv_query($conn, $sql_sePhysicalng1_26, $params_sePhysicalng1_26);
    $result_sePhysicalng1_26 = sqlsrv_fetch_array($query_sePhysicalng1_26, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_27 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_27 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('27 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_27 = sqlsrv_query($conn, $sql_sePhysicalng1_27, $params_sePhysicalng1_27);
    $result_sePhysicalng1_27 = sqlsrv_fetch_array($query_sePhysicalng1_27, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_28 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_28 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('28 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_28 = sqlsrv_query($conn, $sql_sePhysicalng1_28, $params_sePhysicalng1_28);
    $result_sePhysicalng1_28 = sqlsrv_fetch_array($query_sePhysicalng1_28, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_29 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_29 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('29 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_29 = sqlsrv_query($conn, $sql_sePhysicalng1_29, $params_sePhysicalng1_29);
    $result_sePhysicalng1_29 = sqlsrv_fetch_array($query_sePhysicalng1_29, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_30 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_30 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('30 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_30 = sqlsrv_query($conn, $sql_sePhysicalng1_30, $params_sePhysicalng1_30);
    $result_sePhysicalng1_30 = sqlsrv_fetch_array($query_sePhysicalng1_30, SQLSRV_FETCH_ASSOC);

    $sql_sePhysicalng1_31 = "{call megKpitree_v2(?,?)}";
    $params_sePhysicalng1_31 = array(
        array('select_physicalng1', SQLSRV_PARAM_IN),
        array('31 ' . $result_seSystime['MMYYY'], SQLSRV_PARAM_IN)
    );
    $query_sePhysicalng1_31 = sqlsrv_query($conn, $sql_sePhysicalng1_31, $params_sePhysicalng1_31);
    $result_sePhysicalng1_31 = sqlsrv_fetch_array($query_sePhysicalng1_31, SQLSRV_FETCH_ASSOC);
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
                    <h3 style="text-align: center">< สภาพร่างกาย Physical Condition > <?= $result_seSystime['MMYYY'] ?></h3>
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
                    : เพื่อตรวจสอบความพร้อมของร่างกายก่อนรับงาน
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
                    : To Check Driver Condition Before Receive Job
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
                    : 1.) ทักทายอย่างมีชีวิตชีวา 2.) ดวงตาสดใส 3.) ใบหน้าสดใส
                </td>
                <td style="width: 10%">

                </td>
                <td style="width: 20%">

                </td>
            </tr>
            <tr>
                <td style="width: 20%">
                    Judge Criteria
                </td>
                <td style="width: 50%">
                    : 1.) Bouncy 2.) Bright Eye Contack 3.) Bright Face
                </td>
                <td style="width: 10%">

                </td>
                <td style="width: 20%">

                </td>
            </tr>
            <tr>
                <td style="width: 20%">
                    ข้อมูลที่ใช้
                </td>
                <td style="width: 50%">
                    : เอกสารเท็งโกะ
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
                    : Tenko Check Sheet
                </td>
                <td style="width: 10%">
                    Time Adjust data
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
                    1. ถ้าดวงตาหรือใบหน้า ถ้าไม่ปรกติให้พัก 15 นาที,ทำครั้งที่ 2 ไม่ผ่านเชิญกลับ
                </td>

            </tr>
            <tr>
                <td style="width: 20%">

                </td>
                <td style="width: 80%">
                    1. If Eye or Face is not bright,Rest 15 min.Then 2nd,If not pass cancel job.
                </td>

            </tr>
            <tr>
                <td style="width: 20%">

                </td>
                <td style="width: 80%">
                    2. แจ้งหน้างานเพื่อหารถเทรลเลอร์ทดแทน
                </td>

            </tr>
            <tr>
                <td style="width: 20%">

                </td>
                <td style="width: 80%">
                    2. Inform to job assign to find other trailer to replace
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
                    '13', '14', '15', '16', '17',
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
                data: [<?= $result_sePhysicalng1_1['CNT'] ?>, <?= $result_sePhysicalng1_2['CNT'] ?>, <?= $result_sePhysicalng1_3['CNT'] ?>,
<?= $result_sePhysicalng1_4['CNT'] ?>, <?= $result_sePhysicalng1_5['CNT'] ?>, <?= $result_sePhysicalng1_6['CNT'] ?>,
<?= $result_sePhysicalng1_7['CNT'] ?>, <?= $result_sePhysicalng1_8['CNT'] ?>, <?= $result_sePhysicalng1_9['CNT'] ?>,
<?= $result_sePhysicalng1_10['CNT'] ?>, <?= $result_sePhysicalng1_11['CNT'] ?>, <?= $result_sePhysicalng1_12['CNT'] ?>,
<?= $result_sePhysicalng1_13['CNT'] ?>, <?= $result_sePhysicalng1_14['CNT'] ?>, <?= $result_sePhysicalng1_15['CNT'] ?>,
<?= $result_sePhysicalng1_16['CNT'] ?>, <?= $result_sePhysicalng1_17['CNT'] ?>, <?= $result_sePhysicalng1_18['CNT'] ?>,
<?= $result_sePhysicalng1_19['CNT'] ?>, <?= $result_sePhysicalng1_20['CNT'] ?>, <?= $result_sePhysicalng1_21['CNT'] ?>,
<?= $result_sePhysicalng1_22['CNT'] ?>, <?= $result_sePhysicalng1_23['CNT'] ?>, <?= $result_sePhysicalng1_24['CNT'] ?>,
<?= $result_sePhysicalng1_25['CNT'] ?>, <?= $result_sePhysicalng1_26['CNT'] ?>, <?= $result_sePhysicalng1_27['CNT'] ?>,
<?= $result_sePhysicalng1_28['CNT'] ?>, <?= $result_sePhysicalng1_29['CNT'] ?>, <?= $result_sePhysicalng1_30['CNT'] ?>,
<?= $result_sePhysicalng1_31['CNT'] ?>],
                tooltip: {
                    valueSuffix: ' NG'
                }

            }, {
                name: 'Total (Driver)',
                type: 'spline',

                data: [<?= $result_sePhysical1_1['CNT'] ?>, <?= $result_sePhysical1_2['CNT'] ?>, <?= $result_sePhysical1_3['CNT'] ?>,
<?= $result_sePhysical1_4['CNT'] ?>, <?= $result_sePhysical1_5['CNT'] ?>, <?= $result_sePhysical1_6['CNT'] ?>,
<?= $result_sePhysical1_7['CNT'] ?>, <?= $result_sePhysical1_8['CNT'] ?>, <?= $result_sePhysical1_9['CNT'] ?>,
<?= $result_sePhysical1_10['CNT'] ?>, <?= $result_sePhysical1_11['CNT'] ?>, <?= $result_sePhysical1_12['CNT'] ?>,
<?= $result_sePhysical1_13['CNT'] ?>, <?= $result_sePhysical1_14['CNT'] ?>, <?= $result_sePhysical1_15['CNT'] ?>,
<?= $result_sePhysical1_16['CNT'] ?>, <?= $result_sePhysical1_17['CNT'] ?>, <?= $result_sePhysical1_18['CNT'] ?>,
<?= $result_sePhysical1_19['CNT'] ?>, <?= $result_sePhysical1_20['CNT'] ?>, <?= $result_sePhysical1_21['CNT'] ?>,
<?= $result_sePhysical1_22['CNT'] ?>, <?= $result_sePhysical1_23['CNT'] ?>, <?= $result_sePhysical1_24['CNT'] ?>,
<?= $result_sePhysical1_25['CNT'] ?>, <?= $result_sePhysical1_26['CNT'] ?>, <?= $result_sePhysical1_27['CNT'] ?>,
<?= $result_sePhysical1_28['CNT'] ?>, <?= $result_sePhysical1_29['CNT'] ?>, <?= $result_sePhysical1_30['CNT'] ?>,
<?= $result_sePhysical1_31['CNT'] ?>],
                tooltip: {
                    valueSuffix: ' Total (Driver)'
                }
            }]
    });
</script>