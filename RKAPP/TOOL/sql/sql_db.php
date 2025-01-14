<?php
/*SELECT ALL DATA COLUMN*/
function select_once_data($conn, $sto, $table, $value, $condition){
    $para = set_stored_para('select', $table, $value, $condition);
    $qry = db_query_stored($conn, $sto, $para);
    $item = sqlsrv_fetch_object($qry);
    return $item->$value;
    db_close($conn);
}
/*GET DATE TIME FROM SERVER*/
function set_datetime_server($conn, $selection){
    if($selection == 'date'){$sql = "SELECT CONVERT(DATE,GETDATE()) AS DATAITEM";}
    if($selection == 'time'){$sql = "SELECT CONVERT(TIME,GETDATE()) AS DATAITEM";}
    if($selection == 'datetime'){$sql = "SELECT GETDATE() AS DATAITEM";}
    $qry = db_query($conn, $sql);
    while($bag = sqlsrv_fetch_object($qry)){return format_datetime($bag->DATAITEM, $selection);}
    db_close($conn);
}

function select_data($conn, $table, $condition){
    $sql = "SELECT * FROM ".$table." WHERE STATUS_USE = 1";
    if($condition != ''){$sql .= "AND ".$condition;}
    $qry = db_query($conn, $sql);
    return $qry;
    db_close($conn);
}

function re_check_data($conn, $sto, $table, $value, $condition) {
    $para = set_stored_para('select', $table, $value, $condition);
    $qry = db_query_stored($conn, $sto, $para);
    if($bag = sqlsrv_fetch_object($qry)){
        return true;
    }else{
        return false;
    }
    db_close($conn);
}

function select_all_data($conn, $sto, $table, $value, $condition){
    $para = set_stored_para('select', $table, $value, $condition);
    $qry = db_query_stored($conn, $sto, $para);
    if($qry == false){
        return false;
    }else{
        return $qry;
    }
    db_close($conn);
}

function select_max_id($conn, $sto, $table, $value, $condition){
    $para = set_stored_para('maxid', $table, $value, $condition);
    $qry = db_query_stored($conn, $sto, $para);
    if($bag = sqlsrv_fetch_object($qry)){
        $item = sprintf("%04d",substr($bag->MAXID,-3)+1);
    }else{
        $item = sprintf("%04d",1);
    }
    return $item;
    db_close($conn);
}

function select_head_type($conn, $condi){
    $sql = "SELECT T_CODE,T_NAME FROM TB_RKDATA_TYPEDATA";
    $item = "";
    if($condi == ''){
        $sql .= " WHERE STATUS_USE = 1 ORDER BY T_CODE"; 
    }else if($condi == 'eq'){
        $sql .= " WHERE T_CODE LIKE 'EQ%' AND STATUS_USE = 1 ORDER BY T_CODE";
    }else if($condi == 'it'){
        $sql .= " WHERE T_CODE LIKE 'IT%' AND STATUS_USE = 1 ORDER BY T_CODE";
    }
    
    $item .= "<option value=''>ทั้งหมด</option>";
    $qry = db_query($conn, $sql);
    while($bag = sqlsrv_fetch_object($qry)){
        $item .= "<option value='$bag->T_CODE'>$bag->T_NAME</option>";
    }
    return $item;
    db_close($conn);
}

function select_data_list($conn, $col, $table, $condi){
    $sql = "SELECT $col FROM $table WHERE STATUS_USE = 1";
    $item = "";
    if($condi != ''){
        $sql .= " AND ".$condi."ORDER BY EQ_ID"; 
    }else{
        $sql .= "ORDER BY EQ_ID";
    }
    
    $qry = db_query($conn, $sql);
    while($bag = sqlsrv_fetch_object($qry)){
        $item .= "<option value='$bag->EQ_ID'>";
    }
    return $item;
    db_close($conn);
}

function count_order($conn, $sto, $table, $value, $condition){
    $para = set_stored_para('COUNT', $table, $value, $condition);
    $qry = db_query_stored($conn, $sto, $para);
    $bag = sqlsrv_fetch_object($qry);
    return $bag->COUNT_NUMBER;
    db_close($conn);
}

function get_user_it_name ($conn,$sto){
    $para = set_stored_para('SELECT', "TB_RKUSER_LOGINDATA", "P_ID", "WHERE [POSITION_TYPE] = 'IT'");
    $qry = db_query_stored($conn, $sto, $para);
    while ($bag = sqlsrv_fetch_object($qry)){
        $para = set_stored_para('SELECT', "TB_RKDATA_PERSONDATA", "P_ID,P_FNAME,P_LNAME", "WHERE [P_ID] = '$bag->P_ID'");
        $qry_p = db_query_stored($conn, $sto, $para);
        while ($bag_p = sqlsrv_fetch_object($qry_p)){
            echo "<option value='$bag_p->P_ID'>$bag_p->P_FNAME $bag_p->P_LNAME</option>";
        }
    }
}

function row_count_number($conn, $sto, $table, $value, $condition){
    $para = set_stored_para('ROW', $table, $value, $condition);
    $qry = db_query_stored($conn, $sto, $para);
    while ($bag = sqlsrv_fetch_object($qry)){
        $item = $bag->ROW_ID;
    }
    return $item;
}

?>

