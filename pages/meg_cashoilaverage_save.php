<?php

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

	date_default_timezone_set("Asia/Bangkok");

	// if ($_POST['butupdate'] != "") { 
		// $data1=$_POST["planid"];
		// $data2=$_POST["oiltatid"];
		// $data3=$_POST["personcode"];	
		// $data4=$_POST["distance"];	
		// $data5=$_POST["oam"];
		// $data6=$_POST["oavg"];
		// $data7=$_POST["oavgtg"];
		// $data8=$_POST["oiltg"];
		// $data9=$_POST["diffoil"];
		// $data10=$_POST["price"];
		// $data11=$_POST["status"];
		
		$data1=$_POST["WDOAVG_PLANID"];
		$data2=$_POST["WDOAVG_OILTATID"];
		$data3=$_POST["WDOAVG_PERSONCODE"];	
		$data4=$_POST["WDOAVG_DISTANCE"];	
		$data5=$_POST["WDOAVG_OAM"];
		$data6=$_POST["WDOAVG_OAVG"];
		$data7=$_POST["WDOAVG_OAVGTG"];
		$data8=$_POST["WDOAVG_OILTG"];
		$data9=$_POST["WDOAVG_DIFFOIL"];
		$data10=$_POST["WDOAVG_PRICE"];
		$data11=$_POST["WDOAVG_STATUS"];
        
		$WHOINSERT = $_POST["username"];
		$NOWDATE = date("Y-m-d H:i:s");

		$sql_rsvhctppnull = "SELECT VEHICLETRANSPORTPLANID, EMPLOYEECODE1, EMPLOYEENAME1, EMPLOYEECODE2, EMPLOYEENAME2
			FROM VEHICLETRANSPORTPLAN AS VHCTPP
			LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
			WHERE VEHICLETRANSPORTPLANID = $data1";
		$query_rsvhctppnull = sqlsrv_query($conn, $sql_rsvhctppnull);
		// $result_rsvhctppnull = sqlsrv_fetch_array($query_rsvhctppnull, SQLSRV_FETCH_ASSOC);
		while($result_rsvhctppnull = sqlsrv_fetch_array($query_rsvhctppnull, SQLSRV_FETCH_ASSOC)) {
			$nullVHCTPPID = $result_rsvhctppnull['VEHICLETRANSPORTPLANID'];
			$EMPLOYEECODE1 = $result_rsvhctppnull['EMPLOYEECODE1'];
			$EMPLOYEECODE2 = $result_rsvhctppnull['EMPLOYEECODE2'];

			if($EMPLOYEECODE1 != ""){
				$insertupdate = "INSERT INTO WITHDRAW_OILAVG (WDOAVG_PLANID,WDOAVG_OILTATID,WDOAVG_PERSONCODE,WDOAVG_DISTANCE,WDOAVG_OAM,WDOAVG_OAVG,WDOAVG_OAVGTG,WDOAVG_OILTG,WDOAVG_DIFFOIL,WDOAVG_PRICE,WDOAVG_STATUS,WDOAVG_CREATE_BY,WDOAVG_CREATE_DATE)
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
				$paramsinsertupdate = array($data1,$data2,$EMPLOYEECODE1,$data4,$data5,$data6,$data7,$data8,$data9,$data10,$data11,$WHOINSERT,$NOWDATE);
				$stmtinsertupdate = sqlsrv_query( $conn, $insertupdate, $paramsinsertupdate);
			}
			if($EMPLOYEECODE2 != ""){
				$insertupdate = "INSERT INTO WITHDRAW_OILAVG (WDOAVG_PLANID,WDOAVG_OILTATID,WDOAVG_PERSONCODE,WDOAVG_DISTANCE,WDOAVG_OAM,WDOAVG_OAVG,WDOAVG_OAVGTG,WDOAVG_OILTG,WDOAVG_DIFFOIL,WDOAVG_PRICE,WDOAVG_STATUS,WDOAVG_CREATE_BY,WDOAVG_CREATE_DATE)
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
				$paramsinsertupdate = array($data1,$data2,$EMPLOYEECODE2,$data4,$data5,$data6,$data7,$data8,$data9,$data10,$data11,$WHOINSERT,$NOWDATE);
				$stmtinsertupdate = sqlsrv_query( $conn, $insertupdate, $paramsinsertupdate);
			}
		}

		
		if($stmtinsertupdate === false ) {
			die( print_r( sqlsrv_errors(), true));
		}
		else
		{
			echo "Record add successfully";
		}
	// }
	sqlsrv_close($conn);
?>