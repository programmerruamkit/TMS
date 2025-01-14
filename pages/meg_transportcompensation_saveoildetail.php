<?php

	date_default_timezone_set("Asia/Bangkok");
	require_once("../class/meg_function.php");
	$conn = connect("RTMS");
	if( $conn === false ) {
		die( print_r( sqlsrv_errors(), true));
	}
    session_start();

	// echo"<pre>";
	// print_r($_POST);
	// print_r($_SESSION);
	// echo"</pre>";
	// exit();

	date_default_timezone_set("Asia/Bangkok");
	if ($_POST['butsave'] != "") { 
		$data1=$_POST['resultVHCRGNB'];
		$data2=$_POST['realJOBNO'];
		$data3=$_POST['txt_mileagestart'];
		$data4=$_POST['txt_mileageend'];
		$data5="MILEAGESTART";
		$data6="MILEAGEEND";
		$data7=$_POST['realCOMPANYCODE'];
		$data8=$_POST['realVHCTPPID'];
		$data9=$_POST['txt_mileagestart'];
		$data10=$_POST['txt_mileageend'];
		$data11=$_POST['chkjn_oilbillnumber'];
		$data12=$_POST['txt_oilmonny'];
		$data13=$_POST['txt_oilmonny'];
		$data14=$_POST['txt_oil'];
		$data15=$_POST['realEMPLOYEECODE'];
		$data16=$_POST['realNEWDATE'];
		$data17=$_POST['CHKJN_MILEAGESTART'];
		$data18=$_POST['CHKJN_MILEAGEEND'];
		

		$data19=$_POST['selecttype1'];	
		$data23=$_POST['disabled1'];
		$data24=$_POST['disabled2'];
		$data25=$_POST['disabled3'];
		$data26=$_POST['disabled4'];	
		$data27=$_POST['disabled5'];

		$data20=$_POST['selecttype2'];
		$data28=$_POST['disabled6'];
		$data29=$_POST['disabled7'];
		$data30=$_POST['disabled8'];		
		$data31=$_POST['disabled9'];
		$data32=$_POST['disabled10'];

		$data21=$_POST['selecttype3'];
		$data33=$_POST['disabled11'];
		$data34=$_POST['disabled12'];
		$data35=$_POST['disabled13'];
		$data36=$_POST['disabled14'];
		$data37=$_POST['disabled15'];

		$data22=$_POST['selecttype4'];
		$data38=$_POST['disabled16'];
		$data39=$_POST['disabled17'];
		$data40=$_POST['disabled18'];
		$data41=$_POST['disabled19'];
		$data42=$_POST['disabled20'];

		$data43=$_POST['realOILAVERAGE_SHOW'];

		$ATSTT="1";
		$NOWDATE = date("Y-m-d H:i:s");
		$blank = "";
		// MILEAGE
		$sql1 = "INSERT INTO MILEAGE (VEHICLEREGISNUMBER,JOBNO,MILEAGENUMBER,MILEAGETYPE,REMARK,ACTIVESTATUS,CREATEBY,CREATEDATE) 
		VALUES (?,?,?,?,?,?,?,?)";
		$params1 = array($data1,$data2,$data3,$data5,$data7,$ATSTT,$data15,$NOWDATE);   
		$stmt1 = sqlsrv_query( $conn, $sql1, $params1);
		// MILEAGE
		$sql2 = "INSERT INTO MILEAGE (VEHICLEREGISNUMBER,JOBNO,MILEAGENUMBER,MILEAGETYPE,REMARK,ACTIVESTATUS,CREATEBY,CREATEDATE) 
		VALUES (?,?,?,?,?,?,?,?)";
		$params2 = array($data1,$data2,$data4,$data6,$data7,$ATSTT,$data15,$NOWDATE);   
		$stmt2 = sqlsrv_query( $conn, $sql2, $params2);
		
		// MILEAGE_SUMMARY
		$sql_chkjobno = "SELECT JOBNO FROM MILEAGE_SUMMARY WHERE JOBNO = '$data2'";
		$query_chkjobno = sqlsrv_query($conn, $sql_chkjobno);
		$result_chkjobno = sqlsrv_fetch_array($query_chkjobno, SQLSRV_FETCH_ASSOC);
		$chkjobno = $result_chkjobno["JOBNO"];
		if($chkjobno != $data2){
			// MILEAGE_SUMMARY
			$sql3 = "INSERT INTO MILEAGE_SUMMARY (VEHICLETRANSPORTPLANID,JOBNO,MILEAGESTART,MILEAGEEND,REMARK,ACTIVESTATUS,CREATEBY,CREATEDATE)
			VALUES (?,?,?,?,?,?,?,?)";
			$params3 = array($data8,$data2,$data3,$data4,$blank,$ATSTT,$data15,$NOWDATE);
			$stmt3 = sqlsrv_query( $conn, $sql3, $params3);
		}else if($chkjobno == $data2){
			// MILEAGE_SUMMARY
			$sql3 = "UPDATE MILEAGE_SUMMARY SET MILEAGESTART=?,MILEAGEEND=?,MODIFIEDBY=?,MODIFIEDDATE=?  WHERE JOBNO=?";
			$params3 = array($data3,$data4,$data15,$NOWDATE,$data2);
			$stmt3 = sqlsrv_query( $conn, $sql3, $params3);
		}
		// VEHICLETRANSPORTPLAN
		$sql4 = "UPDATE VEHICLETRANSPORTPLAN SET C3 =?, O4 =?, RS_OILAVERAGE=?, MODIFIEDBY=?, MODIFIEDDATE=? WHERE VEHICLETRANSPORTPLANID = ?";
		$params4 = array($data12,$data14,$data43,$data15,$NOWDATE,$data8);
		$stmt4 = sqlsrv_query( $conn, $sql4, $params4);
		// VEHICLETRANSPORTDOCUMENTDIRVER
		$sql5 = "UPDATE VEHICLETRANSPORTDOCUMENTDIRVER SET OILNUMBER=?,OILAVERAGE=?,  MODIFIEDBY=?, MODIFIEDDATE=? WHERE VEHICLETRANSPORTPLANID=?";
		$params5 = array($data11,$data12,$data15,$NOWDATE,$data8);
		$stmt5 = sqlsrv_query( $conn, $sql5, $params5);
		// VEHICLETRANSPORTDOCUMENTDIRVERPALLET
		$sql6 = "UPDATE VEHICLETRANSPORTDOCUMENTDIRVERPALLET SET OILNUMBER=?,OILAVERAGE=?,  MODIFIEDBY=?, MODIFIEDDATE=? WHERE VEHICLETRANSPORTPLANID=?";
		$params6 = array($data11,$data12,$data15,$NOWDATE,$data8);
		$stmt6 = sqlsrv_query( $conn, $sql6, $params6);
		
		// VEHICLETRANSPORTDOCUMENTDIRVER
		// VEHICLETRANSPORTPLAN
		$sql_rsvhctppnull = "SELECT
			VHCTPP.VEHICLETRANSPORTPLANID,
			VHCTPP.VEHICLEREGISNUMBER1,
			VHCTPP.THAINAME,
			VHCTPP.EMPLOYEECODE1,
			VHCTPP.C3,
			VHCTPP.O4,
			VHCTPPDV.OILNUMBER,
			VHCTPPDV.OILAVERAGE,
			CONVERT (VARCHAR(10), VHCTPP.DATEWORKING, 23) AS DATEWORKING
			FROM VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV
			LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
			WHERE (VHCTPP.VEHICLEREGISNUMBER1 = '$data1' OR VHCTPP.THAINAME = '$data1')
			AND VHCTPP.EMPLOYEECODE1 = '$data15'
			AND CONVERT (VARCHAR(10), VHCTPP.DATEWORKING, 23) = '$data16'
			AND VHCTPPDV.OILNUMBER IS NULL";
		$query_rsvhctppnull = sqlsrv_query($conn, $sql_rsvhctppnull);
		// $result_rsvhctppnull = sqlsrv_fetch_array($query_rsvhctppnull, SQLSRV_FETCH_ASSOC);
		while($result_rsvhctppnull = sqlsrv_fetch_array($query_rsvhctppnull, SQLSRV_FETCH_ASSOC)) {
			$nullVHCTPPID = $result_rsvhctppnull['VEHICLETRANSPORTPLANID'];
			$nullOILNUMBER = $result_rsvhctppnull['OILNUMBER'];	
			if($nullOILNUMBER == ""){
				// VEHICLETRANSPORTDOCUMENTDIRVER
				$sql7 = "UPDATE VEHICLETRANSPORTDOCUMENTDIRVER SET OILNUMBER=?, MODIFIEDBY=?, MODIFIEDDATE=? WHERE VEHICLETRANSPORTPLANID=?";
				$params7 = array($data11,$data15,$NOWDATE,$nullVHCTPPID);
				$stmt7 = sqlsrv_query( $conn, $sql7, $params7);
				// VEHICLETRANSPORTDOCUMENTDIRVERPALLET
				$sql8 = "UPDATE VEHICLETRANSPORTDOCUMENTDIRVERPALLET SET OILNUMBER=?, MODIFIEDBY=?, MODIFIEDDATE=? WHERE VEHICLETRANSPORTPLANID=?";
				$params8 = array($data11,$data15,$NOWDATE,$nullVHCTPPID);
				$stmt8 = sqlsrv_query( $conn, $sql8, $params8);
			}
		}

		if($data7=='RCC'||$data7=='RATC'||$data7=='RRC'){
			$tablefind = 'TEMP_RPAVGDAY_GW';
			$viewfind = 'vwRPAVGDAY_GW';
		}else{
			$tablefind = 'TEMP_RPAVGDAY';
			$viewfind = 'vwRPAVGDAY';
		}
		$check1 = "SELECT * FROM $tablefind WHERE VEHICLETRANSPORTPLANID = '$data8'";
		$querycheck1 = sqlsrv_query( $conn, $check1);
		$resultcheck1 = sqlsrv_fetch_array($querycheck1, SQLSRV_FETCH_ASSOC);
		$chk1null = $resultcheck1['VEHICLETRANSPORTPLANID'];      

		if($chk1null == ""){
			$sql_insert = "INSERT INTO $tablefind (C3OLD,C3PLUS,C3MINUS,C3ZERO,PersonCode,EMPLOYEECODE1,EMPLOYEECODE2,CUSTOMERCODE,JOBEND,VEHICLETRANSPORTPLANID,DATEWORKING)
				SELECT * FROM $viewfind A WHERE A.VEHICLETRANSPORTPLANID = '$data8'";
			$stmt_insert = sqlsrv_query($conn, $sql_insert);
		}else{			
			$sql_rpavgday="SELECT * FROM $viewfind A WHERE A.VEHICLETRANSPORTPLANID = '$data8'";
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

				$sql = "UPDATE $tablefind SET C3OLD=?,C3PLUS=?,C3MINUS=?,C3ZERO=?,DATEWORKING=? WHERE VEHICLETRANSPORTPLANID=?";
				$params = array($C3OLD,$C3PLUS,$C3MINUS,$C3ZERO,$DATEWORKING,$chk1null);
				$stmt = sqlsrv_query( $conn, $sql, $params);
			}
		}
		
		if($data19 == "1"){		
			$check1 = "SELECT TOP 1 * FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = ? AND OSGS_TY = ?";
			$paramscheck1 = array($data8,$data19);
			$querycheck1 = sqlsrv_query( $conn, $check1, $paramscheck1);
			$resultcheck1 = sqlsrv_fetch_array($querycheck1, SQLSRV_FETCH_ASSOC);
			$chk1null = $resultcheck1['OSGS_ID'];
			if($chk1null == ""){
				$sql9 = "INSERT INTO OUTSIDE_GAS_STATION (OSGS_PLID,OSGS_TY,OSGS_DRF,OSGS_BL,OSGS_AM,OSGS_PAY,OSGS_PR,OSGS_CAB,OSGS_CAD,OSGS_VHCRG) VALUES (?,?,?,?,?,?,?,?,?,?)";
				$params9 = array($data8,$data19,$data23,$data24,$data25,$data26,$data27,$data15,$NOWDATE,$data1);   
				$stmt9 = sqlsrv_query($conn, $sql9, $params9);
			}else{
				$sql9 = "UPDATE OUTSIDE_GAS_STATION SET OSGS_DRF=?,OSGS_BL=?,OSGS_AM=?,OSGS_PAY=?,OSGS_EDB=?,OSGS_EDD=? WHERE OSGS_ID=?";
				$params9 = array($data23,$data24,$data25,$data26,$data15,$NOWDATE,$chk1null);
				$stmt9 = sqlsrv_query( $conn, $sql9, $params9);
			}
		}
		if($data20 == "2"){
			$check2 = "SELECT TOP 1 * FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = ? AND OSGS_TY = ?";
			$paramscheck2 = array($data8,$data20);
			$querycheck2 = sqlsrv_query( $conn, $check2, $paramscheck2);
			$resultcheck2 = sqlsrv_fetch_array($querycheck2, SQLSRV_FETCH_ASSOC);
			$chk2null = $resultcheck2['OSGS_ID'];
			if($chk2null == ""){
				$sql10 = "INSERT INTO OUTSIDE_GAS_STATION (OSGS_PLID,OSGS_TY,OSGS_DRF,OSGS_BL,OSGS_AM,OSGS_PAY,OSGS_PR,OSGS_CAB,OSGS_CAD,OSGS_VHCRG) VALUES (?,?,?,?,?,?,?,?,?,?)";
				$params10 = array($data8,$data20,$data28,$data29,$data30,$data31,$data32,$data15,$NOWDATE,$data1);    
				$stmt10 = sqlsrv_query($conn, $sql10, $params10);
			}else{
				$sql10 = "UPDATE OUTSIDE_GAS_STATION SET OSGS_DRF=?,OSGS_BL=?,OSGS_AM=?,OSGS_PAY=?,OSGS_EDB=?,OSGS_EDD=? WHERE OSGS_ID=?";
				$params10 = array($data28,$data29,$data30,$data31,$data15,$NOWDATE,$chk2null);
				$stmt10 = sqlsrv_query( $conn, $sql10, $params10);
			}
		}
		if($data21 == "3"){
			$check3 = "SELECT TOP 1 * FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = ? AND OSGS_TY = ?";
			$paramscheck3 = array($data8,$data21);
			$querycheck3 = sqlsrv_query( $conn, $check3, $paramscheck3);
			$resultcheck3 = sqlsrv_fetch_array($querycheck3, SQLSRV_FETCH_ASSOC);
			$chk3null = $resultcheck3['OSGS_ID'];
			if($chk3null == ""){
				$sql11 = "INSERT INTO OUTSIDE_GAS_STATION (OSGS_PLID,OSGS_TY,OSGS_DRF,OSGS_BL,OSGS_AM,OSGS_PAY,OSGS_PR,OSGS_CAB,OSGS_CAD,OSGS_VHCRG) VALUES (?,?,?,?,?,?,?,?,?,?)";
				$params11 = array($data8,$data21,$data33,$data34,$data35,$data36,$data37,$data15,$NOWDATE,$data1);     
				$stmt11 = sqlsrv_query($conn, $sql11, $params11);
			}else{
				$sql11 = "UPDATE OUTSIDE_GAS_STATION SET OSGS_DRF=?,OSGS_BL=?,OSGS_AM=?,OSGS_PAY=?,OSGS_EDB=?,OSGS_EDD=? WHERE OSGS_ID=?";
				$params11 = array($data33,$data34,$data35,$data36,$data15,$NOWDATE,$chk3null);
				$stmt11 = sqlsrv_query( $conn, $sql11, $params11);
			}
		}
		if($data22 == "4"){
			$check4 = "SELECT TOP 1 * FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = ? AND OSGS_TY = ?";
			$paramscheck4 = array($data8,$data22);
			$querycheck4 = sqlsrv_query( $conn, $check4, $paramscheck4);
			$resultcheck4 = sqlsrv_fetch_array($querycheck4, SQLSRV_FETCH_ASSOC);
			$chk4null = $resultcheck4['OSGS_ID'];
			if($chk4null == ""){
				$sql12 = "INSERT INTO OUTSIDE_GAS_STATION (OSGS_PLID,OSGS_TY,OSGS_DRF,OSGS_BL,OSGS_AM,OSGS_PAY,OSGS_RM,OSGS_CAB,OSGS_CAD,OSGS_VHCRG) VALUES (?,?,?,?,?,?,?,?,?,?)";
				$params12 = array($data8,$data22,$data38,$data39,$data40,$data41,$data42,$data15,$NOWDATE,$data1);     
				$stmt12 = sqlsrv_query($conn, $sql12, $params12);
			}else{
				$sql12 = "UPDATE OUTSIDE_GAS_STATION SET OSGS_DRF=?,OSGS_BL=?,OSGS_AM=?,OSGS_PAY=?,OSGS_RM=?,OSGS_EDB=?,OSGS_EDD=? WHERE OSGS_ID=?";
				$params12 = array($data38,$data39,$data40,$data41,$data42,$data15,$NOWDATE,$chk4null);
				$stmt12 = sqlsrv_query( $conn, $sql12, $params12);
			}
		}
		if( ($stmt1 && $stmt2 && $stmt3 && $stmt4 && $stmt5 && $stmt6 && $stmt7 && $stmt8)  === false ) {
			die( print_r( sqlsrv_errors(), true));
		}else{
			echo "Record add successfully";
		}
	}

	if ($_POST['butupdate'] != "") { 		
		$update0=$_POST["oiltatid"];
		$update1=$_POST["jobnooil"];
		$update2=$_POST["mileagestart"];
		$update3=$_POST["mileageend"];
		$update4=$_POST["oilamout"];
		
		$update7=$_POST["oldjoboil"];

		$caldte=$update3 - $update2;
		$rscaldte=$caldte;

		$calavg=$caldte / $update4;
		$rscalavg=number_format($calavg, 2);
		
		if($update1!=$update7){
			$sqlupdateoldjob = "UPDATE VEHICLETRANSPORTPLAN SET C3 =?,O4=?,RS_OILAVERAGE=?,RS_OILREMARK=? WHERE JOBNO = ?";
			$paramsupdateoldjob = array('0','0',NULL,NULL,$update7);
			$stmtupdateoldjob = sqlsrv_query( $conn, $sqlupdateoldjob, $paramsupdateoldjob);
			
			$sql_delete_ml = "DELETE FROM MILEAGE WHERE JOBNO = ? ";
			$params_delete_ml = array($update7);
			$stmt_delete_ml = sqlsrv_query( $conn, $sql_delete_ml , $params_delete_ml);

			$sql_delete_mls = "DELETE FROM MILEAGE_SUMMARY WHERE JOBNO = ? ";
			$params_delete_mls = array($update7);
			$stmt_delete_mls = sqlsrv_query( $conn, $sql_delete_mls , $params_delete_mls);
			
			$sql_chkjobid = "SELECT COMPANYCODE,VEHICLETRANSPORTPLANID FROM VEHICLETRANSPORTPLAN WHERE JOBNO = '$update7'";
			$query_chkjobid = sqlsrv_query($conn, $sql_chkjobid);
			$result_chkjobid = sqlsrv_fetch_array($query_chkjobid, SQLSRV_FETCH_ASSOC);
			$chkjobid = $result_chkjobid["VEHICLETRANSPORTPLANID"];
			$chkcom = $result_chkjobid["COMPANYCODE"];
			if($chkjobid != ''){				
				if($chkcom=='RCC'||$chkcom=='RATC'||$chkcom=='RRC'){
					$tablefind = 'TEMP_RPAVGDAY_GW';
				}else{
					$tablefind = 'TEMP_RPAVGDAY';
				}
				$sql_update = "UPDATE $tablefind SET C3OLD=?,C3PLUS=?,C3MINUS=?,C3ZERO=? WHERE VEHICLETRANSPORTPLANID=?";
				$params_update = array(NULL,NULL,NULL,NULL,$chkjobid);
				$stmt_update = sqlsrv_query( $conn, $sql_update, $params_update);

				$sql5 = "UPDATE VEHICLETRANSPORTDOCUMENTDIRVER SET OILNUMBER=?,OILAVERAGE=? WHERE VEHICLETRANSPORTPLANID=?";
				$params5 = array(NULL,NULL,$chkjobid);
				$stmt5 = sqlsrv_query( $conn, $sql5, $params5);
				$sql6 = "UPDATE VEHICLETRANSPORTDOCUMENTDIRVERPALLET SET OILNUMBER=?,OILAVERAGE=? WHERE VEHICLETRANSPORTPLANID=?";
				$params6 = array(NULL,NULL,$chkjobid);
				$stmt6 = sqlsrv_query( $conn, $sql6, $params6);
			}
		}

		$sqlupdate = "UPDATE TEMP_TATSUNODATA.dbo.OIL_TATSUNO SET MILEAGEEND=?, DISTANCE=?, OIL_AVERAGE=?, JOBNO=? WHERE OILDATAID=?";
		$paramsupdate = array($update3,$rscaldte,$rscalavg,$update1,$update0);
		$stmtupdate = sqlsrv_query( $conn, $sqlupdate, $paramsupdate);
		
		$username=$_POST["username"];
		$data2=$_POST['realJOBNO'];
		$NOWDATEU3 = date("Y-m-d H:i:s");

		$insertupdate = "INSERT INTO TEMP_TATSUNODATA.dbo.UPDATE_JOBNO (PersonCode,OILDATAID,JOBNO,EDITDATE) VALUES (?,?,?,?)";
		$paramsinsertupdate = array($username,$update0,$update1,$NOWDATEU3);
		$stmtinsertupdate = sqlsrv_query( $conn, $insertupdate, $paramsinsertupdate);		
		if(($stmtupdate && $stmtinsertupdate)=== false ) { die( print_r( sqlsrv_errors(), true)); }else{ echo "Record add successfully"; }
	}
	
	if ($_POST['butupdate_byadmin'] != "") { 		
		$update0=$_POST["oiltatid"];
		$update1=$_POST["jobnooil"];
		$update2=$_POST["mileagestart"];
		$update3=$_POST["mileageend"];
		$update4=$_POST["oilamout"];
		$update5=$_POST["username"];
		$nowdateadmin=date("Y-m-d H:i:s");
		$update6=$_POST["oilremark"];
		$update7=$_POST["oldjoboil"];

		$caldte=$update3 - $update2;
		$rscaldte=$caldte;

		$calavg=$caldte / $update4;
		$rscalavg=number_format($calavg, 2);
		
		if($update1!=$update7){
			$sqlupdateoldjob = "UPDATE VEHICLETRANSPORTPLAN SET C3 =?,O4=?,RS_OILAVERAGE=?,RS_OILREMARK=? WHERE JOBNO = ?";
			$paramsupdateoldjob = array('0','0',NULL,NULL,$update7);
			$stmtupdateoldjob = sqlsrv_query( $conn, $sqlupdateoldjob, $paramsupdateoldjob);
			
			$sql_delete_ml = "DELETE FROM MILEAGE WHERE JOBNO = ? ";
			$params_delete_ml = array($update7);
			$stmt_delete_ml = sqlsrv_query( $conn, $sql_delete_ml , $params_delete_ml);

			$sql_delete_mls = "DELETE FROM MILEAGE_SUMMARY WHERE JOBNO = ? ";
			$params_delete_mls = array($update7);
			$stmt_delete_mls = sqlsrv_query( $conn, $sql_delete_mls , $params_delete_mls);
			
			$sql_chkjobid = "SELECT COMPANYCODE,VEHICLETRANSPORTPLANID FROM VEHICLETRANSPORTPLAN WHERE JOBNO = '$update7'";
			$query_chkjobid = sqlsrv_query($conn, $sql_chkjobid);
			$result_chkjobid = sqlsrv_fetch_array($query_chkjobid, SQLSRV_FETCH_ASSOC);
			$chkjobid = $result_chkjobid["VEHICLETRANSPORTPLANID"];
			$chkcom = $result_chkjobid["COMPANYCODE"];
			if($chkjobid != ''){
				if($chkcom=='RCC'||$chkcom=='RATC'||$chkcom=='RRC'){
					$tablefind = 'TEMP_RPAVGDAY_GW';
				}else{
					$tablefind = 'TEMP_RPAVGDAY';
				}
				$sql_update = "UPDATE $tablefind SET C3OLD=?,C3PLUS=?,C3MINUS=?,C3ZERO=? WHERE VEHICLETRANSPORTPLANID=?";
				$params_update = array(NULL,NULL,NULL,NULL,$chkjobid);
				$stmt_update = sqlsrv_query( $conn, $sql_update, $params_update);
				$sql5 = "UPDATE VEHICLETRANSPORTDOCUMENTDIRVER SET OILNUMBER=?,OILAVERAGE=? WHERE VEHICLETRANSPORTPLANID=?";
				$params5 = array(NULL,NULL,$chkjobid);
				$stmt5 = sqlsrv_query( $conn, $sql5, $params5);
				$sql6 = "UPDATE VEHICLETRANSPORTDOCUMENTDIRVERPALLET SET OILNUMBER=?,OILAVERAGE=? WHERE VEHICLETRANSPORTPLANID=?";
				$params6 = array(NULL,NULL,$chkjobid);
				$stmt6 = sqlsrv_query( $conn, $sql6, $params6);
			}
		}
		if($update6!=''){
			$sqlupdatenewjob = "UPDATE VEHICLETRANSPORTPLAN SET RS_OILREMARK=? WHERE JOBNO = ?";
			$paramsupdatenewjob = array($update6,$update1);
			$stmtupdatenewjob = sqlsrv_query( $conn, $sqlupdatenewjob, $paramsupdatenewjob);
		}else{			
			$sqlupdatenewjob = "UPDATE VEHICLETRANSPORTPLAN SET RS_OILREMARK=? WHERE JOBNO = ?";
			$paramsupdatenewjob = array(NULL,$update1);
			$stmtupdatenewjob = sqlsrv_query( $conn, $sqlupdatenewjob, $paramsupdatenewjob);
		}

		$sqlupdate = "UPDATE TEMP_TATSUNODATA.dbo.OIL_TATSUNO SET JOBNO=?, MILEAGESTART=?, MILEAGEEND=?, DISTANCE=?, OIL_AMOUNT=?, OIL_AVERAGE=? WHERE OILDATAID=?";
		$paramsupdate = array($update1,$update2,$update3,$rscaldte,$update4,$rscalavg,$update0);
		$stmtupdate = sqlsrv_query( $conn, $sqlupdate, $paramsupdate);		

		$insertupdate = "INSERT INTO TEMP_TATSUNODATA.dbo.UPDATE_JOBNO (PersonCode,OILDATAID,JOBNO,EDITDATE) VALUES (?,?,?,?)";
		$paramsinsertupdate = array($update5,$update0,$update1,$nowdateadmin);
		$stmtinsertupdate = sqlsrv_query( $conn, $insertupdate, $paramsinsertupdate);		
		if(($stmtupdate && $stmtinsertupdate)=== false ) { die( print_r( sqlsrv_errors(), true)); }else{ echo "Record add successfully"; }
	}

	if ($_POST['edit_osgsdrf'] != "") { 		
		$osgsid=$_POST["osgsid"];$editobj=$_POST["editobj"];$modifiedby=$_POST["modifiedby"];$NOWDATEOUT = date("Y-m-d H:i:s");
		$sqlupdateoutside = "UPDATE OUTSIDE_GAS_STATION SET OSGS_DRF=?,OSGS_EDB=?,OSGS_EDD=? WHERE OSGS_ID=?";
		$paramsupdateoutside = array($editobj,$modifiedby,$NOWDATEOUT,$osgsid);
		$stmtinsertupdateoutside = sqlsrv_query( $conn, $sqlupdateoutside, $paramsupdateoutside);		
		if($stmtinsertupdateoutside === false ) { die( print_r( sqlsrv_errors(), true));}else{echo "Record add successfully";}
	}	
	if ($_POST['edit_osgsbl'] != "") { 		
		$osgsid=$_POST["osgsid"];$editobj=$_POST["editobj"];$modifiedby=$_POST["modifiedby"];$NOWDATEOUT = date("Y-m-d H:i:s");
		$sqlupdateoutside = "UPDATE OUTSIDE_GAS_STATION SET OSGS_BL=?,OSGS_EDB=?,OSGS_EDD=? WHERE OSGS_ID=?";
		$paramsupdateoutside = array($editobj,$modifiedby,$NOWDATEOUT,$osgsid);
		$stmtinsertupdateoutside = sqlsrv_query( $conn, $sqlupdateoutside, $paramsupdateoutside);		
		if($stmtinsertupdateoutside === false ) { die( print_r( sqlsrv_errors(), true));}else{echo "Record add successfully";}
	}	
	if ($_POST['edit_osgsam'] != "") { 		
		$osgsid=$_POST["osgsid"];$editobj=$_POST["editobj"];$modifiedby=$_POST["modifiedby"];$NOWDATEOUT = date("Y-m-d H:i:s");
		$sqlupdateoutside = "UPDATE OUTSIDE_GAS_STATION SET OSGS_AM=?,OSGS_EDB=?,OSGS_EDD=? WHERE OSGS_ID=?";
		$paramsupdateoutside = array($editobj,$modifiedby,$NOWDATEOUT,$osgsid);
		$stmtinsertupdateoutside = sqlsrv_query( $conn, $sqlupdateoutside, $paramsupdateoutside);		
		if($stmtinsertupdateoutside === false ) { die( print_r( sqlsrv_errors(), true));}else{echo "Record add successfully";}
	}
	if ($_POST['edit_osgspay'] != "") { 		
		$osgsid=$_POST["osgsid"];$editobj=$_POST["editobj"];$modifiedby=$_POST["modifiedby"];$NOWDATEOUT = date("Y-m-d H:i:s");
		$sqlupdateoutside = "UPDATE OUTSIDE_GAS_STATION SET OSGS_PAY=?,OSGS_EDB=?,OSGS_EDD=? WHERE OSGS_ID=?";
		$paramsupdateoutside = array($editobj,$modifiedby,$NOWDATEOUT,$osgsid);
		$stmtinsertupdateoutside = sqlsrv_query( $conn, $sqlupdateoutside, $paramsupdateoutside);		
		if($stmtinsertupdateoutside === false ) { die( print_r( sqlsrv_errors(), true));}else{echo "Record add successfully";}
	}
	if ($_POST['edit_osgspr'] != "") { 		
		$osgsid=$_POST["osgsid"];$editobj=$_POST["editobj"];$modifiedby=$_POST["modifiedby"];$NOWDATEOUT = date("Y-m-d H:i:s");
		$sqlupdateoutside = "UPDATE OUTSIDE_GAS_STATION SET OSGS_PR=?,OSGS_EDB=?,OSGS_EDD=? WHERE OSGS_ID=?";
		$paramsupdateoutside = array($editobj,$modifiedby,$NOWDATEOUT,$osgsid);
		$stmtinsertupdateoutside = sqlsrv_query( $conn, $sqlupdateoutside, $paramsupdateoutside);		
		if($stmtinsertupdateoutside === false ) { die( print_r( sqlsrv_errors(), true));}else{echo "Record add successfully";}
	}
	if ($_POST['edit_osgsrm'] != "") { 		
		$osgsid=$_POST["osgsid"];$editobj=$_POST["editobj"];$modifiedby=$_POST["modifiedby"];$NOWDATEOUT = date("Y-m-d H:i:s");
		$sqlupdateoutside = "UPDATE OUTSIDE_GAS_STATION SET OSGS_RM=?,OSGS_EDB=?,OSGS_EDD=? WHERE OSGS_ID=?";
		$paramsupdateoutside = array($editobj,$modifiedby,$NOWDATEOUT,$osgsid);
		$stmtinsertupdateoutside = sqlsrv_query( $conn, $sqlupdateoutside, $paramsupdateoutside);		
		if($stmtinsertupdateoutside === false ) { die( print_r( sqlsrv_errors(), true));}else{echo "Record add successfully";}
	}
	
	if ($_POST['txt_flg'] == "select_finedataoil") { 		
		$finebill=$_POST["finebill"];
		$check = "SELECT *,
		CONVERT (VARCHAR (16),REFUELINGDATE,29) REFUELINGDATE1 FROM TEMP_TATSUNODATA.dbo.OIL_TATSUNO WHERE OIL_BILLNUMBER = ?";
		$paramscheck = array($finebill);
		$querycheck = sqlsrv_query( $conn, $check, $paramscheck);
		$resultcheck = sqlsrv_fetch_array($querycheck, SQLSRV_FETCH_ASSOC);		

		echo $resultcheck["JOBNO"].'|';
		echo $resultcheck["OIL_BILLNUMBER"].'|';
		echo $resultcheck["MILEAGESTART"].'|';
		echo $resultcheck["MILEAGEEND"].'|';
		echo $resultcheck["OIL_AMOUNT"].'|';
		echo $resultcheck["REFUELINGDATE1"].'|';
		echo $resultcheck["OILDATAID"].'|';
		echo $_SESSION["USERNAME"].'|';
		echo $resultcheck["JOBNO"];
	}

	if ($_POST['butnewcalgw'] == "newvalue") { 
		$data8=$_POST['realVHCTPPID'];
		$data12=$_POST['txt_oilmonny1'];
		$data43=$_POST['realOILAVERAGE_SHOW'];

		// VEHICLETRANSPORTPLAN
		$sql4 = "UPDATE VEHICLETRANSPORTPLAN SET C3 =?,RS_OILAVERAGE=? WHERE VEHICLETRANSPORTPLANID = ?";
		$params4 = array($data12,$data43,$data8);
		$stmt4 = sqlsrv_query( $conn, $sql4, $params4);
		
		$sql_rpavgday="SELECT * FROM vwRPAVGDAY_GW A WHERE A.VEHICLETRANSPORTPLANID = '$data8'";
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

			$sql = "UPDATE TEMP_RPAVGDAY_GW SET C3OLD=?,C3PLUS=?,C3MINUS=?,C3ZERO=?,DATEWORKING=? WHERE VEHICLETRANSPORTPLANID=?";
			$params = array($C3OLD,$C3PLUS,$C3MINUS,$C3ZERO,$DATEWORKING,$VEHICLETRANSPORTPLANID);
			$stmt = sqlsrv_query( $conn, $sql, $params);
		}

		if( $stmt4  === false ) {
			die( print_r( sqlsrv_errors(), true));
		}
		else
		{
			echo "Record add successfully";
		}
	}
 

	if ($_POST['butsavenotactioncaloavg'] == "newvalue") { 
		$realVHCTPPID=$_POST['realVHCTPPID'];
		
		$sql4 = "UPDATE VEHICLETRANSPORTPLAN SET SUBMITBUTTON =? WHERE VEHICLETRANSPORTPLANID = ?";
		$params4 = array(1,$realVHCTPPID);
		$stmt4 = sqlsrv_query( $conn, $sql4, $params4);

		if( $stmt4  === false ) {
			die( print_r( sqlsrv_errors(), true));
		}else{
			$chkplan="SELECT a.VEHICLETRANSPORTPLANID,a.COMPANYCODE,b.OIL_BILLNUMBER OBLNB,a.EMPLOYEECODE1,a.EMPLOYEENAME1,a.EMPLOYEECODE2,a.EMPLOYEENAME2,b.OIL_AMOUNT OAM,a.O4,a.C3,a.JOBNO,a.SUBMITBUTTON SMBT,
				CONVERT(VARCHAR(10),b.REFUELINGDATE,20) REFUEL20,
				CONVERT(VARCHAR(10),b.REFUELINGDATE,103) REFUEL103,
				CONVERT(VARCHAR(10),a.DATEWORKING,20) DWK20,
				CONVERT(VARCHAR(10),a.DATEWORKING,103) DWK103,	
				CASE WHEN a.SUBMITBUTTON = 1 THEN 'บันทึกค่าตอบแทนแล้ว' ELSE 'ยังไม่บันทึกค่าตอบแทน' END SUBMITBUTTON
				FROM TEMP_TATSUNODATA.dbo.OIL_TATSUNO b
				LEFT JOIN VEHICLETRANSPORTPLAN a ON a.JOBNO = b.JOBNO COLLATE Thai_CI_AI
				WHERE a.VEHICLETRANSPORTPLANID = '$realVHCTPPID' AND a.SUBMITBUTTON = 1 AND a.O4 IS NULL AND NOT a.JOBEND = 'คลังโคราช' AND NOT a.JOBSTART LIKE '%IP%'";
			$query_chkplan = sqlsrv_query($conn, $chkplan);
			$result_chkplan = sqlsrv_fetch_array($query_chkplan, SQLSRV_FETCH_ASSOC);	
			if(isset($result_chkplan['VEHICLETRANSPORTPLANID'])){
				if(($result_chkplan['COMPANYCODE']=='RKL')||($result_chkplan['COMPANYCODE']=='RKR')||($result_chkplan['COMPANYCODE']=='RKS')){
					$TOKEN="3icwuJ6YIpooT0DUcl0pVlyghmAHVqgxvL9xrYTof2y";  
				}else{
					$TOKEN="Dy59wHwNNH6z8zpVwilRLFTRf5SIMFZGOmtcAgEWJNL";  
				}
				$NOTI_LINE1=" ❌ ไม่กดคำนวณค่าเฉลี่ยน้ำมัน"."\n";
				$NOTI_LINE2="วันที่วิ่งงาน : ".$result_chkplan['DWK103'].""."\n";
				$NOTI_LINE3="หมายเลขแผน : ".$result_chkplan['JOBNO'].""."\n";
				$NOTI_LINE4="พขร.1 : ".$result_chkplan['EMPLOYEECODE1'].' - '.$result_chkplan['EMPLOYEENAME1'].""."\n";
				$NOTI_LINE5="พขร.2 : ".$result_chkplan['EMPLOYEECODE2'].' - '.$result_chkplan['EMPLOYEENAME2'].""."\n";
				$NOTI_LINE6="ค่าเฉลี่ยน้ำมัน : ❌ ไม่กดคำนวณค่าเฉลี่ยน้ำมัน"."\n";   
				$NOTI_LINE7="คีย์ค่าตอบแทน : ✅ ".$result_chkplan['SUBMITBUTTON']."";   
				$MESSAGE_NOTI_LINE=$NOTI_LINE1.$NOTI_LINE2.$NOTI_LINE3.$NOTI_LINE4.$NOTI_LINE5.$NOTI_LINE6.$NOTI_LINE7;	
					
				$chOne = curl_init(); 
				curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
				curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
				curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
				curl_setopt( $chOne, CURLOPT_POST, 1); 
				curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$MESSAGE_NOTI_LINE); 
				$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$TOKEN.'', );
				curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
				curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
				$result = curl_exec( $chOne ); 					
				curl_close($chOne);   
			}
		}
	}

	sqlsrv_close($conn);
?>