<?php
	session_start();
	date_default_timezone_set("Asia/Bangkok");
	require_once("../class/meg_function.php");
	$conn = connect("RTMS");
	if( $conn === false ) {
		die( print_r( sqlsrv_errors(), true));
	}

	// echo"<pre>";
	// print_r($_POST);
	// echo"</pre>";
	// exit();

	if ($_POST['txt_flg']=="save_accident_car") { 
		$data1=$_POST['regiscar'];
		$data2=$_POST['employee'];
		// $employee_name=$_POST['employee_name'];
		
		$sql_accicar = "SELECT PersonCode,nameT FROM EMPLOYEEEHR2 WHERE PersonCode = '".$data2."' ";
		$query_accicar = sqlsrv_query($conn, $sql_accicar);
		$result_accicar = sqlsrv_fetch_array($query_accicar, SQLSRV_FETCH_ASSOC);
		$employeename2=$result_accicar["nameT"];

		if($employeename2==""){
			$employee_name=$_POST['employee_name'];
		}else{
			$employee_name=$result_accicar['nameT'];
		}

		$data3=$_POST['daycaraccident'];
		$data4=$_POST['locationcaraccident'];
		$data5=$_POST['problemcaraccident'];
		$data6=$_POST['repairby'];
		$data7=$_POST['garageout'];
		$data8=$_POST['problemrepair'];
		$data9=$_POST['createby'];
		$data10=$_POST['area'];
		$NOWDATE=date("Y-m-d H:i:s");

		$sql = "INSERT INTO ACCIDENTHISTORY_CAR (RG_CAR,EMP_CODE,DT_ACCI,LC_ACCI,PB_ACCI,RP_INOUT,RP_OUT_GR,RP_OUT_GR_PB,CREATE_BY,CREATE_DATE,AREA,EMP_NAME) 
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
		$params = array($data1,$data2,$data3,$data4,$data5,$data6,$data7,$data8,$data9,$NOWDATE,$data10,$employee_name);   
		$stmt = sqlsrv_query( $conn, $sql, $params);

		if($stmt===false) {
			die(print_r(sqlsrv_errors(),true));
		}else{
			echo "Record add successfully";
		}
	}

	if ($_POST['txt_flg']=="update_accident_car") { 
		$data20=$_POST['accicar_id'];		
		$data1=$_POST['regiscar'];
		$data2=$_POST['employee'];
		$employee_name=$_POST['employee_name'];
		$data3=$_POST['daycaraccident'];
		$data4=$_POST['locationcaraccident'];
		$data5=$_POST['problemcaraccident'];
		$data6=$_POST['repairby'];
		$data7=$_POST['garageout'];
		$data8=$_POST['problemrepair'];
		$data10=$_POST['area'];
		$data11=$_SESSION["USERNAME"];
		$NOWDATE=date("Y-m-d H:i:s");

		$sql = "UPDATE ACCIDENTHISTORY_CAR SET RG_CAR=?,EMP_CODE=?,DT_ACCI=?,LC_ACCI=?,PB_ACCI=?,RP_INOUT=?,RP_OUT_GR=?,RP_OUT_GR_PB=?,AREA=?,EDIT_BY=?,EMP_NAME=?,EDIT_DATE=? WHERE ACCICAR_ID=?";
		$params = array($data1,$data2,$data3,$data4,$data5,$data6,$data7,$data8,$data10,$data11,$employee_name,$NOWDATE,$data20);   
		$stmt = sqlsrv_query( $conn, $sql, $params);

		if($stmt===false) {
			die(print_r(sqlsrv_errors(),true));
		}else{
			echo "Record update successfully";
		}
	}
	
	if ($_POST['txt_flg']=="delete_accident") { 
		$data1=$_POST['id'];
		$data2=$_SESSION["USERNAME"];
		$data3=date("Y-m-d H:i:s");		
		$sql = "UPDATE ACCIDENTHISTORY_CAR SET STATUS=?,EDIT_BY=?,EDIT_DATE=? WHERE ACCICAR_ID=?";
		$params = array('0',$data2,$data3,$data1);
		$stmtinsert = sqlsrv_query( $conn, $sql, $params);		
		if($stmtinsert === false ) { 
			die( print_r( sqlsrv_errors(), true));
		}else{
			echo "Record delete successfully";
		}
	}
	sqlsrv_close($conn);
?>