<?php
    // echo"<pre>";
    // print_r($_POST);
    // echo"</pre>";
    // exit();

    $EXCELCASH=$_POST['EXCELCASH'];
    
    session_start();
    date_default_timezone_set("Asia/Bangkok");
    ini_set('max_execution_time', 300);
    require_once("../mpdf/autoload.php");
    require_once("../class/meg_function.php");
    $conn = connect("RTMS");
    $sql_seSystime = "{call megGetdate_v2(?)}";
    $params_seSystime = array(array('select_getdate', SQLSRV_PARAM_IN));
    $query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
    $result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);

    require_once 'PHPExcel-1.8/Classes/PHPExcel.php';
    require_once 'PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
    
    $date1 = $_POST["txt_datestartoilcashreport"];
    $start = explode("/", $date1);
    $startd = $start[0];
    $startif = $start[1];        
        if($startif=='01'){
            $selectmonth = "มกราคม";
        }else if($startif=='02'){
            $selectmonth = "กุมภาพันธ์";
        }else if($startif=='03'){
            $selectmonth = "มีนาคม";
        }else if($startif=='04'){
            $selectmonth = "เมษายน";
        }else if($startif=='05'){
            $selectmonth = "พฤษภาคม";
        }else if($startif=='06'){
            $selectmonth = "มิถุนายน";
        }else if($startif=='07'){
            $selectmonth = "กรกฎาคม";
        }else if($startif=='08'){
            $selectmonth = "สิงหาคม";
        }else if($startif=='09'){
            $selectmonth = "กันยายน";
        }else if($startif=='10'){
            $selectmonth = "ตุลาคม";
        }else if($startif=='11'){
            $selectmonth = "พฤศจิกายน";
        }else if($startif=='12'){
            $selectmonth = "ธันวาคม";
        }
    $start_yen = $start[2];
    $start_yth = $start[2]+543;
    $start_ymd = $start[2].'-'.$start[1].'-'.$start[0];
    
    $date2 = $_POST["txt_dateendoilcashreport"];
    $end = explode("/", $date2);
    $endd = $end[0];
    $endif = $end[1];
        if($endif=='01'){
            $selectmonth = "มกราคม";
        }else if($endif=='02'){
            $selectmonth = "กุมภาพันธ์";
        }else if($endif=='03'){
            $selectmonth = "มีนาคม";
        }else if($endif=='04'){
            $selectmonth = "เมษายน";
        }else if($endif=='05'){
            $selectmonth = "พฤษภาคม";
        }else if($endif=='06'){
            $selectmonth = "มิถุนายน";
        }else if($endif=='07'){
            $selectmonth = "กรกฎาคม";
        }else if($endif=='08'){
            $selectmonth = "สิงหาคม";
        }else if($endif=='09'){
            $selectmonth = "กันยายน";
        }else if($endif=='10'){
            $selectmonth = "ตุลาคม";
        }else if($endif=='11'){
            $selectmonth = "พฤศจิกายน";
        }else if($endif=='12'){
            $selectmonth = "ธันวาคม";
        }
    $end_yen = $end[2];    
    $end_yth = $end[2]+543;
    $end_ymd = $end[2].'-'.$end[1].'-'.$end[0];

    // $selcompany2=$_POST['selcompany2'];
    $customer2=$_POST['selcustomer2'];

    if(isset($_POST['EXCELCASH'])) { 
        if ($_SESSION["ROLENAME"] == "ADMIN" || $_SESSION["ROLENAME"] == "PLANNING(GW)") {
            $USERNAME=$_SESSION["USERNAME"];
            $ROLE=" AND 1=1 ";
        }else{
            $USERNAME=$_SESSION["USERNAME"];
            $ROLE=" AND EMP.PersonCode = '$USERNAME' ";
        }
        
        if($customer2=="REPORT1"){
            $selcompany2="'RCC'";
            $querywherecustomer="VHCTPP.CUSTOMERCODE = 'TTT' ";
            $querywherecustomer1="EMPVH.Company_Code = 'RCC' ".$ROLE."";
            // $querywherecustomer1="VHCTPP.CUSTOMERCODE = 'TTT' AND EMPVH.Company_Code = 'RCC' ".$ROLE."";
        }else if($customer2=="REPORT2"){
            $selcompany2="'RRC'";
            $querywherecustomer="VHCTPP.CUSTOMERCODE IN ('BP','GMT','GMT-IB') ";
            $querywherecustomer1="VHCTPP.CUSTOMERCODE IN ('BP','GMT','GMT-IB') AND EMPVH.Company_Code = 'RRC' ".$ROLE."";
        }else if($customer2=="REPORT3"){
            $selcompany2="'RRC'";
            $querywherecustomer="VHCTPP.CUSTOMERCODE IN ('TTAST','TTTC') ";
            $querywherecustomer1="VHCTPP.CUSTOMERCODE IN ('TTAST','TTTC') AND EMPVH.Company_Code = 'RRC' ".$ROLE."";
        }else if($customer2=="REPORT4"){
            $selcompany2="'RATC'";
            $querywherecustomer="VHCTPP.CUSTOMERCODE = 'TTT' ";
            $querywherecustomer1="EMPVH.Company_Code = 'RATC' ".$ROLE."";
            // $querywherecustomer1="VHCTPP.CUSTOMERCODE = 'TTT' AND EMPVH.Company_Code = 'RATC' ".$ROLE."";
        }
        
        $sql_chkprice = "SELECT OLP.PRICE,OLP.COMPANYCODE,OLP.[MONTH],OLP.[YEAR]   
        FROM OILPEICE OLP WHERE OLP.COMPANYCODE = $selcompany2 AND OLP.[YEAR] = '$start_yen' AND OLP.[MONTH] = '$selectmonth'";
        $query_chkprice = sqlsrv_query($conn, $sql_chkprice);
        $result_chkprice = sqlsrv_fetch_array($query_chkprice, SQLSRV_FETCH_ASSOC);

        $sql_chkcompany = "SELECT CPEHR.Company_NameT,CPEHR.Company_NameE,CPEHR.Company_Code,CPEHR.Company_Add,DISTRICT_NAME_TH,AP.AMPHUR_NAME_TH,PV.PROVINCE_NAME_TH,CPEHR.Company_PostalCode
            FROM COMPANYEHR CPEHR
            LEFT JOIN DISTRICTS DT ON CAST (Company_District AS INT) = DT.DISTRICT_ID
            LEFT JOIN AMPHURES AP ON CAST (Company_Amphur AS INT) = AP.AMPHUR_ID
            LEFT JOIN PROVINCES PV ON CAST (Company_Province AS INT) = PV.PROVINCE_ID
            WHERE CPEHR.Company_Code = $selcompany2";
            $query_chkcompany = sqlsrv_query($conn, $sql_chkcompany);
            $result_chkcompany = sqlsrv_fetch_array($query_chkcompany, SQLSRV_FETCH_ASSOC);
            
            $recomth='บริษัท '.$result_chkcompany["Company_NameT"].' จำกัด';
            $recomen=$result_chkcompany["Company_NameE"].' CO., LTD';
            $recomadd=$result_chkcompany["Company_Add"].' ต.'.$result_chkcompany["DISTRICT_NAME_TH"].' อ.'.$result_chkcompany["AMPHUR_NAME_TH"].' จ.'.$result_chkcompany["PROVINCE_NAME_TH"].' '.$result_chkcompany["Company_PostalCode"];
            // $recomen='RUAMKIT RUNG RUENG (AMATA CITY)';
            // $recomadd='51 ม.4 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี 20160';

    if ($EXCELCASH != "") { 
        $objPHPExcel = new PHPExcel();

        $work_sheet=0;
        while (strtotime($start_ymd) <= strtotime($end_ymd)) {
            $day = explode("-", $start_ymd);
            $chkday = $day[2];// echo "$chkday<br>";
            $start_ymd = date ("Y-m-d", strtotime("+1 day", strtotime($start_ymd)));// echo "12123<br>";
        // Day-------------------------------------------------------------------------------------------------------------------------------------------------
    
            $objPHPExcel->createSheet();   
            $objPHPExcel->setActiveSheetIndex($work_sheet);
                // OPEN SECTION
                    $companyth=$recomth;
                    $companyen=$recomen;
                    $address=$recomadd;
                    $detail="สรุปโครงการใช้น้ำมันรายบุคคลประจำเดือน $selectmonth $start_yth";
                    $customer="สายงาน $selcustomer2";

                    $objDrawing = new PHPExcel_Worksheet_Drawing();$objDrawing->setName('Image');$objDrawing->setDescription('Image');$objDrawing->setPath('../images/logonew.png');$objDrawing->setWidthAndHeight(100,70);$objDrawing->setCoordinates('G1');$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());$objDrawing->setOffsetX(70);
                    $objPHPExcel->getActiveSheet()->mergeCells('A1:S1');
                    $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(0, 2, $companyth);$sheet->mergeCells('A2:S2');$objPHPExcel->getActiveSheet()->getStyle('A2:S2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(0, 3, $companyen);$sheet->mergeCells('A3:S3');$objPHPExcel->getActiveSheet()->getStyle('A3:S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(0, 4, $address);$sheet->mergeCells('A4:S4');$objPHPExcel->getActiveSheet()->getStyle('A4:S4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(0, 5, $detail);$sheet->mergeCells('A5:S5');$objPHPExcel->getActiveSheet()->getStyle('A5:S5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(0, 6, $customer);$sheet->mergeCells('A6:S6');$objPHPExcel->getActiveSheet()->getStyle('A6:S6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    
                    $objDrawing = new PHPExcel_Worksheet_HeaderFooterDrawing();
                    $objPHPExcel->getActiveSheet()->getHeaderFooter()->addImage($objDrawing, PHPExcel_Worksheet_HeaderFooter::IMAGE_HEADER_LEFT);

                    $styleText = array('font'  => array('bold'  => false,'color' => array('rgb' => '000000'),'size'  => 10,'name'  => 'Verdana'));     
                    $sheet->getDefaultStyle()->applyFromArray($styleText);

                    $objPHPExcel->getActiveSheet()
                        ->setCellValue('A7', 'ลำดับ')
                        ->setCellValue('B7', 'รหัส')
                        ->setCellValue('C7', 'ชื่อ')
                        ->setCellValue('D7', 'สกุล')
                        ->setCellValue('E7', 'วันที่เติมน้ำมัน')
                        ->setCellValue('F7', 'ทะเบียนรถ / ชื่อรถ')
                        ->setCellValue('G7', 'ประเภทรถ')
                        ->setCellValue('H7', 'ต้นทาง')
                        ->setCellValue('I7', 'งานที่ขนส่ง')
                        ->setCellValue('J7', 'รายละเอียด')
                        ->setCellValue('J8', 'ไมล์ต้น')
                        ->setCellValue('K8', 'ไมล์ปลาย')
                        ->setCellValue('L8', 'ระยะทาง')
                        ->setCellValue('M8', 'น้ำมันที่เติม')
                        ->setCellValue('N8', 'ค่าเฉลี่ยที่')->setCellValue('N9', 'กำหนด')
                        ->setCellValue('O8', 'ค่าเฉลี่ยที่ได้')
                        ->setCellValue('P8', 'น้ำมัน')->setCellValue('P9', 'กำหนด')
                        ->setCellValue('Q8', 'ส่วนต่าง')->setCellValue('Q9', 'น้ำมัน')
                        ->setCellValue('R8', 'จำนวนเงินบาท')->setCellValue('R9', 'ลิตร')
                        ->setCellValue('S8', 'จำนวนเงินที่ได้')->setCellValue('S9', 'บาท')
                        ->setCellValue('T7', 'รวมเงิน')
                        ->setCellValue('U7', 'ผู้จ่ายเงิน')
                        ->setCellValue('V7', 'หมายเลข JOB');

                    $objPHPExcel->getActiveSheet()->mergeCells('A7:A9');
                        $objPHPExcel->getActiveSheet()->mergeCells('B7:B9');
                        $objPHPExcel->getActiveSheet()->mergeCells('C7:C9');
                        $objPHPExcel->getActiveSheet()->mergeCells('D7:D9');
                        $objPHPExcel->getActiveSheet()->mergeCells('E7:E9');
                        $objPHPExcel->getActiveSheet()->mergeCells('F7:F9');
                        $objPHPExcel->getActiveSheet()->mergeCells('G7:G9');
                        $objPHPExcel->getActiveSheet()->mergeCells('H7:H9');
                        $objPHPExcel->getActiveSheet()->mergeCells('I7:I9');
                        $objPHPExcel->getActiveSheet()->mergeCells('J7:S7');
                        $objPHPExcel->getActiveSheet()->mergeCells('J8:J9');
                        $objPHPExcel->getActiveSheet()->mergeCells('K8:K9');
                        $objPHPExcel->getActiveSheet()->mergeCells('L8:L9');
                        $objPHPExcel->getActiveSheet()->mergeCells('M8:M9');
                        $objPHPExcel->getActiveSheet()->mergeCells('O8:O9');  
                        $objPHPExcel->getActiveSheet()->mergeCells('T7:T9');
                        $objPHPExcel->getActiveSheet()->mergeCells('U7:U9'); 
                        $objPHPExcel->getActiveSheet()->mergeCells('V7:V9');    
                    
                    $sheet->getStyle('A7:I9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('J7:S7')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('J8:M9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('O8:O9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        
                        $sheet->getStyle('P8:P9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('Q8:Q9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('R8:R9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('J9:S9')->applyFromArray(array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('T7:V9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        
                        $sheet->getStyle('A7:D9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFD700'))));                
                        $sheet->getStyle('E7:S9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '9ACD32'))));
                        $sheet->getStyle('T7:U9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FF8C00'))));             
                        $sheet->getStyle('V7:V9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '9ACD32'))));
                    $objPHPExcel->getActiveSheet()->getStyle('A7:V9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    // foreach(range('A','Z') as $columnID) { $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);} 
                    $sheet->getColumnDimension('A')->setWidth(5);
                        $sheet->getColumnDimension('B')->setWidth(8);
                        $sheet->getColumnDimension('C')->setWidth(12);
                        $sheet->getColumnDimension('D')->setWidth(12);
                        $sheet->getColumnDimension('E')->setWidth(15);
                        $sheet->getColumnDimension('F')->setWidth(20);
                        $sheet->getColumnDimension('G')->setWidth(15);
                        $sheet->getColumnDimension('H')->setWidth(20);
                        $sheet->getColumnDimension('I')->setWidth(20);
                        $sheet->getColumnDimension('J')->setWidth(10);
                        $sheet->getColumnDimension('K')->setWidth(10);
                        $sheet->getColumnDimension('L')->setWidth(10);
                        $sheet->getColumnDimension('M')->setWidth(10);
                        $sheet->getColumnDimension('N')->setWidth(10);
                        $sheet->getColumnDimension('O')->setWidth(10);
                        $sheet->getColumnDimension('P')->setWidth(10);
                        $sheet->getColumnDimension('Q')->setWidth(10);
                        $sheet->getColumnDimension('R')->setWidth(10);
                        $sheet->getColumnDimension('S')->setWidth(12);
                        $sheet->getColumnDimension('T')->setWidth(10);
                        $sheet->getColumnDimension('U')->setWidth(20);
                        $sheet->getColumnDimension('V')->setWidth(25);

                    $stm_count = "SELECT DISTINCT COUNT	(OTSN.OILDATAID) OILID 
                    FROM dbo.WITHDRAW_OILAVG AS WDO 
                    LEFT JOIN	dbo.VEHICLETRANSPORTPLAN AS VHCTPP ON VHCTPP.VEHICLETRANSPORTPLANID = WDO.WDOAVG_PLANID 
                    LEFT JOIN   TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN	dbo.EMPLOYEEEHR2 AS EMPVH	ON EMPVH.PersonCode = WDO.WDOAVG_PERSONCODE
                    WHERE EMPVH.Company_Code = $selcompany2
                        AND $querywherecustomer
                        AND OTSN.OIL_BILLNUMBER IS NOT NULL
                        AND CONVERT(VARCHAR (10),WDO.WDOAVG_CREATE_DATE,20) = '$start_yen-$startif-$chkday'";
                    //  WHERE VHCTPP.COMPANYCODE = $selcompany2
                    $querystm_count = sqlsrv_query($conn, $stm_count );
                    $result_stm_count = sqlsrv_fetch_array($querystm_count, SQLSRV_FETCH_ASSOC);
                        $OILID=$result_stm_count["OILID"];   
                    $stmm = "SELECT
                        DISTINCT
                        WDO.WDOAVG_ID WDOID, 
                        WDO.WDOAVG_PLANID PLID, 
                        WDO.WDOAVG_OILTATID OILID, 
                        EMPVH.PersonCode EMPC, 
                        EMPVH.nameT EMPN, 
                        OTSN.REFUELINGDATE,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DWK,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        VHCTPP.THAINAME VHCTN,
                        OTSN.VEHICLENAME VHCN,
                        VHCTPP.VEHICLETYPE VHCTPLAN,
                        VHCTPP.CUSTOMERCODE VHCTPPCUS,
                        VHCTPP.JOBSTART,
                        VHCTPP.JOBEND,
                        OTSN.MILEAGESTART MLS,
                        OTSN.MILEAGEEND MLE,
                        WDO.WDOAVG_DISTANCE DTE, 
                        WDO.WDOAVG_OAM OAM, 
                        WDO.WDOAVG_OAVG OAVG, 
                        WDO.WDOAVG_OAVGTG OAVGTG, 
                        WDO.WDOAVG_OILTG OTG, 
                        WDO.WDOAVG_DIFFOIL DFO, 
                        WDO.WDOAVG_PRICE PR, 
                        WDO.WDOAVG_STATUS ST, 
                        VHCTPP.JOBNO JN, 
                        VHCTPP.WORKTYPE WT, 
                        VHCTPP.ROUNDAMOUNT RAM, 
                        WDO.WDOAVG_EDIT_BY EDB, 
                        EMP.PersonCode PAYERCODE, 
                        EMP.nameT PAYERNAME
                    FROM
                        dbo.WITHDRAW_OILAVG AS WDO
                    LEFT JOIN	dbo.VEHICLETRANSPORTPLAN AS VHCTPP ON VHCTPP.VEHICLETRANSPORTPLANID = WDO.WDOAVG_PLANID
                    LEFT JOIN	dbo.EMPLOYEEEHR2 AS EMPVH	ON EMPVH.PersonCode = WDO.WDOAVG_PERSONCODE
                    LEFT JOIN	dbo.EMPLOYEEEHR2 AS EMP	ON EMP.PersonCode = WDO.WDOAVG_CREATE_BY
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    WHERE 
                        -- VHCTPP.COMPANYCODE = $selcompany2 AND 
                        $querywherecustomer1 AND 
                        OTSN.OIL_BILLNUMBER IS NOT NULL AND 
                        CONVERT(VARCHAR (10),WDO.WDOAVG_CREATE_DATE,20) = '$start_yen-$startif-$chkday'
                        ORDER BY EMPVH.PersonCode ASC";
                    $querystmm = sqlsrv_query($conn, $stmm );       
                    if($OILID!="0"){   
                        $i = "10";
                        $numpage = "1";
                        while($objResult = sqlsrv_fetch_array($querystmm)) {    
                                $REFUEL=$objResult["REFUEL"];
                                $CONREFUEL = explode("-", $REFUEL);
                                $RSREFUEL = $CONREFUEL[2].'/'.$CONREFUEL[1].'/'.$CONREFUEL[0];  
                                $pieces = explode(" ", $objResult["EMPN"]);
                                $fname=$pieces[0];
                                $lname=$pieces[1];
                                $EMPC=$objResult["EMPC"];
                                $VHCRGNB=$objResult["VHCRGNB"];
                                $VHCTN=$objResult["VHCTN"];
                                $VHCTPLAN=$objResult["VHCTPLAN"];
                                $JOBSTART=$objResult["JOBSTART"];
                                $JOBEND=$objResult["JOBEND"];
                                $MLS=$objResult["MLS"];
                                $MLE=$objResult["MLE"];
                                $DTE=$objResult["DTE"];
                                $OAM=$objResult["OAM"];
                                $VHCTPPCUS=$objResult["VHCTPPCUS"];
                                $DWK=$objResult["DWK"];  
                                                                                                    
                                $SQLCHKWORK="SELECT SCPT.EMPLOYEECODE1,STRING_AGG([WORKTYPE],',') AS [CHKWORK] FROM VEHICLETRANSPORTPLAN SCPT  WHERE
                                ( SCPT.EMPLOYEECODE1 = '$EMPC' OR SCPT.EMPLOYEECODE2 = '$EMPC' ) 
                                AND CONVERT ( VARCHAR ( 10 ), SCPT.DATEWORKING, 20 ) = '$DWK' AND NOT STATUSNUMBER = 'X'
                                GROUP BY SCPT.EMPLOYEECODE1";
                                $QUERYCHKWORK= sqlsrv_query($conn, $SQLCHKWORK );  
                                $RESULTCHKWORK = sqlsrv_fetch_array($QUERYCHKWORK, SQLSRV_FETCH_ASSOC);
                                $CHKWORK=$RESULTCHKWORK["CHKWORK"]; 
                                
                                if($CHKWORK==","){$CHKWORKIF="";}else if($CHKWORK==",,"){$CHKWORKIF="";}else if($CHKWORK==",,,"){$CHKWORKIF="";}else if($CHKWORK==",,,,"){$CHKWORKIF="";}else{$CHKWORKIF=$CHKWORK;}
                                
                                $CHKW = explode(",", $CHKWORK);
                                $RSCHKW1 = $CHKW[0];
                                $RSCHKW2 = $CHKW[1];
                                $RSCHKW3 = $CHKW[2];
                                $RSCHKW4 = $CHKW[3]; 
                                                                                                                
                                $SQLCHKROUND="SELECT COUNT( VHCTPP.EMPLOYEECODE1 ) COUNTROUNDAMOUT FROM VEHICLETRANSPORTPLAN VHCTPP 
                                WHERE (VHCTPP.EMPLOYEECODE1 = '$EMPC' OR VHCTPP.EMPLOYEECODE2 = '$EMPC') AND CONVERT ( VARCHAR ( 10 ), VHCTPP.DATEWORKING, 20 ) = '$DWK' AND NOT STATUSNUMBER = 'X'";
                                $QUERYROUND = sqlsrv_query($conn, $SQLCHKROUND );  
                                // while($objResult = sqlsrv_fetch_array($querystmm)) {
                                $RESULTROUND = sqlsrv_fetch_array($QUERYROUND, SQLSRV_FETCH_ASSOC);
                                $CALROUND=$RESULTROUND["COUNTROUNDAMOUT"];

                                if(($VHCTN=='T-001')||($VHCTN=='T-002')||($VHCTN=='T-003')||($VHCTN=='T-004')){     // ชื่อรถ T001 - T004
                                    if($VHCTPPCUS=='GMT'){                                                              // ถ้าเป็นลูกค้า GMT
                                        $OAVGTG='4.25';                                                               // คิด 4.25
                                    }else{                                                                              // ถ้าไม่ใช่ลูกค้า GMT
                                        $OAVGTG='5.00';                                                               // คิด 5.00
                                    }                                                                                     
                                }else if(($VHCTN=='T-005')||($VHCTN=='T-006')||($VHCTN=='T-007')||($VHCTN=='T-008')||($VHCTN=='T-009')){    // ชื่อรถ T005 - T009
                                    $OAVGTG='4.75';                                                                                       // คิด 4.75  
                                }else if($C2!=""){                                          // ถ้าเป็นงานรับกลับ
                                    $OAVGTG='3.75';                                       // คิด 3.75
                                }else{
                                    if(($CALROUND=='1')){                                   // 1 เที่ยว
                                        if($RSCHKW1=='sh'){
                                            $OAVGTG='3.75';                               // sh = 3.75
                                        }else if($RSCHKW1=='nm'){
                                            $OAVGTG='4.25';                               // nm = 4.25 
                                        }else{
                                            $OAVGTG=$objResult["OAVGTG"];                // เรทปกติจากระบบ 
                                        }
                                    }else if($CALROUND=='2'){                               // 2 เที่ยว                                                                   
                                        if(($RSCHKW1=='sh')&&($RSCHKW2=='sh')){ 
                                            $OAVGTG='3.75';                               // sh-sh = 3.75
                                        }else if(($RSCHKW1=='sh')&&($RSCHKW2=='nm')){
                                            $OAVGTG='4.25';                               // sh-nm = 4.25
                                        }else if(($RSCHKW1=='nm')&&($RSCHKW2=='sh')){
                                            $OAVGTG='3.75';                               // nm-sh = 3.75  
                                        }else if(($RSCHKW1=='nm')&&($RSCHKW2=='nm')){
                                            $OAVGTG='4.25';                               // nm-nm = 4.25                                                                        
                                        }else{
                                            $OAVGTG=$objResult["OAVGTG"]; // เรทปกติจากระบบ                                                                    
                                        }
                                    }else{
                                        $OAVGTG=$objResult["OAVGTG"]; // เรทปกติจากระบบ                                                                    
                                    }
                                }
                                // $OAVGTG=$objResult["OAVGTG"];  

                                $OAVG=$objResult["OAVG"];
                                $OTG=$objResult["OTG"];
                                $DFO=$objResult["DFO"];
                                $PR=$objResult["PR"];
                                
                                $PRICE = explode(",", $PR);
                                $CHKP1=$PRICE[0];
                                $CHKP2=$PRICE[1];
                                $RSPRICE=$CHKP1.$CHKP2;

                                $PAYERNAME=$objResult["PAYERNAME"]; 
                                $JN=$objResult["JN"];                           

                            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $numpage);
                            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $EMPC);
                            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $fname);
                            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $lname);
                            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $RSREFUEL);
                            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $VHCRGNB.' / '.$VHCTN);
                            $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $VHCTPLAN);
                            $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $JOBSTART);
                            $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $JOBEND);
                            $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $MLS);
                            $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $MLE);
                            $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $DTE);
                            $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $OAM);
                            $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $OAVGTG);
                            $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $OAVG);
                            $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $OTG);
                            $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $DFO);
                            $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $result_chkprice["PRICE"]);
                            $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $RSPRICE);
                            $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, '=S'.$i.'*1');
                            $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $PAYERNAME);
                            $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $JN);
                        $numpage++; $i++;
                        }
                    }else{                         
                        $i = "10";$i++;
                    }
                    
                    $objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':K'.$i);
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, 'รวม');
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold( true );

                    $sheet->getStyle('L'.$i.':S'.$i)->getNumberFormat()->setFormatCode('0.00');
                    $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, '=SUM(L10:L'.($i -1).')');
                    // $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, '=SUM(L10:L'.($i -1).')');
                    // $objPHPExcel->getActiveSheet()->setCellValue('N'.$i, '=K'.$i.'/L'.$i);
                    $objPHPExcel->getActiveSheet()->setCellValue('O'.$i, '=SUM(O10:O'.($i -1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('P'.$i, '=SUM(P10:P'.($i -1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('R'.$i, '=SUM(R10:R'.($i -1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('S'.$i, '=SUM(S10:S'.($i -1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('T'.$i, '=SUM(T10:T'.($i -1).')');

                    $sheet->getStyle('M10:T'.$i)->getNumberFormat()->setFormatCode('0.00'); 
                    $sheet->getStyle('A10:V'.$i)->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                    $objPHPExcel->getActiveSheet()->getStyle('A10:B'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('C10:D'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('E10:F'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('G10:I'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('J10:R'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('U10:V'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    
                    $sheet->getStyle('A'.$i.':V'.$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                // CLOSE SECTION 
            $objPHPExcel->getActiveSheet()->setTitle($chkday);

        // END-------------------------------------------------------------------------------------------------------------------------------------------------
                // $objPHPExcel->setActiveSheetIndex(0);
                $work_sheet++;
        }
        $RENAME= "สรุปโครงการใช้น้ำมันรายบุคคลประจำเดือน $selectmonth $start_yth สายงาน $selcustomer2";
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=$RENAME.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

    }else{
        echo "<h1>ไม่มีข้อมูล</h1>";
    } 
}?>

<?php
if ($_GET["type"] == "table") {
    echo "<h1>Connect</h1>";
    $conn  = connect('RTMS');
    echo "Server Name: $serverName<br>";
    echo "Username: $userName<br>";
    echo "Password: $userPassword<br>";
    echo "Database Name: $dbName<br>";

    $sqlTables = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' ORDER BY TABLE_NAME ASC";
    $queryTables = sqlsrv_query($conn, $sqlTables);

    echo "<h1>รายการตารางในฐานข้อมูล</h1>";
    echo '$_GET["type"] ที่ใช้ได้: 
    <a href="meg_cashoilaverage_report.php?type=table">table</a>,
    <a href="meg_cashoilaverage_report.php?type=rand">rand</a>
    <br><br>';

    echo '<table border="1" cellpadding="10" cellspacing="0">';
    echo '<thead>
            <tr>
                <th>ลำดับ</th>
                <th>ชื่อตาราง</th>
                <th>คอลัมน์ในตาราง</th>
            </tr>
        </thead>';
    echo '<tbody>';

    $i = 1;
    while ($rowTable = sqlsrv_fetch_array($queryTables, SQLSRV_FETCH_ASSOC)) {
        $tableName = $rowTable['TABLE_NAME'];
        $sqlColumns = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = ?";
        $params = array($tableName);
        $queryColumns = sqlsrv_query($conn, $sqlColumns, $params);

        $columns = [];
        while ($rowColumn = sqlsrv_fetch_array($queryColumns, SQLSRV_FETCH_ASSOC)) {
            $columns[] = $rowColumn['COLUMN_NAME'];
        }
        $columnsList = implode(', ', $columns);

        echo "<tr>";
        echo "<td>" . $i++ . "</td>";
        echo "<td>" . htmlspecialchars($tableName) . "</td>";
        echo "<td>" . htmlspecialchars($columnsList) . "</td>";
        echo "</tr>";
    }

    echo '</tbody>';
    echo '</table>';

}
    
if ($_GET["type"] == "rand") {
        echo '$_GET["type"] ที่ใช้ได้: 
        <a href="meg_cashoilaverage_report.php?type=table">table</a>,
        <a href="meg_cashoilaverage_report.php?type=rand">rand</a>
        <br><br>';
    if (isset($_POST['start'])) {
        $tableName = $_POST['tablename'];
        $columnName = $_POST['columnname'];
        $whereColumn = $_POST['wherecolumn'];
        $selectCondition = trim($_POST['selectcondition']); // เงื่อนไข SELECT เพิ่มเติม

        $sql_loop = "SELECT * FROM $tableName";
        if (!empty($selectCondition)) {
            $sql_loop .= " WHERE $selectCondition";
        }
        $query_loop = sqlsrv_query($conn, $sql_loop);
        while ($result_loop = sqlsrv_fetch_array($query_loop, SQLSRV_FETCH_ASSOC)) {        
            // สุ่มข้อความ
            $characters = '0123456789!@#$%^&*()_-+=<>?:;,.|{}[]';
            $randomString = '';

            $randomLength = rand(3, 10); // 👉 สุ่มความยาวระหว่าง 3 ถึง 10 ตัว
            for ($i = 0; $i < $randomLength; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }

            // อัปเดตข้อมูลตามที่พิมพ์
            $sql = "UPDATE $tableName SET $columnName = ? WHERE $whereColumn";
            $params = array($randomString, $result_loop[$whereColumn]);
            $stmt = sqlsrv_query($conn, $sql, $params);

            if ($stmt) {
                echo "<h1><p style='color: green;'>บันทึกข้อมูลเรียบร้อย: $randomString</p></h1>";
            } else {
                echo "<h1><p style='color: red;'>เกิดข้อผิดพลาดในการบันทึกข้อมูล</p></h1>";
            }
        }
    } else {
        echo "<h1>กรุณากรอกข้อมูลและกดปุ่ม Start เพื่อเริ่มทำงาน</h1>";
    }
    
    echo '
        <form method="post">
            <label>Table Name:</label><br>
            <input type="text" name="tablename" required><br><br>

            <label>Select Condition (เงื่อนไขสำหรับตอน SELECT):</label><br>
            <input type="text" name="selectcondition" placeholder="เช่น status = 1"><br><br>

            <label>Column Name (ที่จะอัปเดต):</label><br>
            <input type="text" name="columnname" required><br><br>

            <label>Where Column (คอลัมน์ที่ใช้ WHERE ตอนอัปเดต):</label><br>
            <input type="text" name="wherecolumn" required><br><br>
            
            <button type="submit" name="start">Start</button>
        </form>
    ';
    
    echo '<br><a href="meg_cashoilaverage_report.php?type=rand">โหลดหน้าใหม่</a>';
}
?>




<?php
sqlsrv_close($conn);
?>
