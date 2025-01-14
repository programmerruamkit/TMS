<?php
    // echo"<pre>";
    // print_r($_POST);
    // echo"</pre>";
    // exit();
    $EXCELMONTH=$_POST['EXCELMONTH'];
    $PDFMONTH=$_POST['PDFMONTH'];
    
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
    
    $date1 = $_POST["txt_datestartoilmonth"];
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
    
    $date2 = $_POST["txt_dateendoilmonth"];
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

    $selcompany2=$_POST['selcompany2'];
    $date4=$_POST['selcustomer2'];
                    
    if($date4 == "TTT4"){
        $selcustomer2="TTT";
        $findfeildPLAN="EHR.Company_Code = '$selcompany2' AND NOT EHR.PositionNameT LIKE '%8 LOAD%' ORDER BY EHR.PersonCode ASC";
    }else if($date4 == "TTT8"){
        $selcustomer2="TTT";
        $findfeildPLAN="EHR.Company_Code = '$selcompany2' AND NOT EHR.PositionNameT LIKE '%4 LOAD%' ORDER BY EHR.PersonCode ASC";
    }else{
        $selcustomer2=$_POST['selcustomer2'];
        $findfeildPLAN="1=1 ORDER BY EHR.PersonCode ASC";
        // AND EHR.Company_Code = 'RRC' AND NOT EHR.PositionNameT LIKE '%8 LOAD%' ORDER BY EHR.PersonCode ASC
    }
    
    if($selcustomer2 == 'TTT'){
        $QUERYWHERE1="EHR.PositionNameT LIKE '%TTT%' AND EHR.Company_Code = '$selcompany2'";
        $QUERYWHERE2="VHCTPP.CUSTOMERCODE IN('TTT')";
        $findcustomer = "1=1";
    }else if($selcustomer2 == 'GMT'){
        $QUERYWHERE1="EHR.PositionNameT LIKE '%GMT%' AND EHR.Company_Code = '$selcompany2'";
        $QUERYWHERE2="VHCTPP.CUSTOMERCODE LIKE '%GMT%'";
        // $QUERYWHERE2="VHCTPP.CUSTOMERCODE IN('GMT')";
        $findcustomer = "NOT VHCTPP.CUSTOMERCODE = 'TTAST'";
    }else if($selcustomer2 == 'TTAST'){
        $QUERYWHERE1="EHR.PositionNameT LIKE '%TTAST%' AND EHR.Company_Code = '$selcompany2'";
        $QUERYWHERE2="VHCTPP.CUSTOMERCODE IN('TTAST')";
        $findcustomer = "NOT VHCTPP.CUSTOMERCODE = 'GMT'";
    }   

    $sql_chkprice = "SELECT OLP.PRICE,OLP.COMPANYCODE,OLP.[MONTH],OLP.[YEAR]   
        FROM OILPEICE OLP WHERE OLP.COMPANYCODE = '$selcompany2' AND OLP.[YEAR] = '$start_yen' AND OLP.[MONTH] = '$selectmonth'";
        $query_chkprice = sqlsrv_query($conn, $sql_chkprice);
        $result_chkprice = sqlsrv_fetch_array($query_chkprice, SQLSRV_FETCH_ASSOC);
    
    $sql_chkcompany = "SELECT CPEHR.Company_NameT,CPEHR.Company_NameE,CPEHR.Company_Code,CPEHR.Company_Add,DISTRICT_NAME_TH,AP.AMPHUR_NAME_TH,PV.PROVINCE_NAME_TH,CPEHR.Company_PostalCode
        FROM COMPANYEHR CPEHR
        LEFT JOIN DISTRICTS DT ON CAST (Company_District AS INT) = DT.DISTRICT_ID
        LEFT JOIN AMPHURES AP ON CAST (Company_Amphur AS INT) = AP.AMPHUR_ID
        LEFT JOIN PROVINCES PV ON CAST (Company_Province AS INT) = PV.PROVINCE_ID
        WHERE CPEHR.Company_Code = '$selcompany2'";
        $query_chkcompany = sqlsrv_query($conn, $sql_chkcompany);
        $result_chkcompany = sqlsrv_fetch_array($query_chkcompany, SQLSRV_FETCH_ASSOC);
        
    $recomth='บริษัท '.$result_chkcompany["Company_NameT"].' จำกัด';
    $recomen=$result_chkcompany["Company_NameE"].' CO., LTD';
    $recomadd=$result_chkcompany["Company_Add"].' ต.'.$result_chkcompany["DISTRICT_NAME_TH"].' อ.'.$result_chkcompany["AMPHUR_NAME_TH"].' จ.'.$result_chkcompany["PROVINCE_NAME_TH"].' '.$result_chkcompany["Company_PostalCode"];
    
if ($EXCELMONTH != "") { 
    $objPHPExcel = new PHPExcel();

    $work_sheet=0;
	while (strtotime($start_ymd) <= strtotime($end_ymd)) {
        $day = explode("-", $start_ymd);
        $chkday = $day[2];
        // echo "$chkday<br>";
        $start_ymd = date ("Y-m-d", strtotime("+1 day", strtotime($start_ymd)));
        // echo "12123<br>";
    // Day-------------------------------------------------------------------------------------------------------------------------------------------------
            $objPHPExcel->createSheet();   
            $objPHPExcel->setActiveSheetIndex($work_sheet);
                // OPEN SECTION                                
                    $companyth=$recomth;
                    $companyen=$recomen;
                    $address=$recomadd;
                    $detail="สรุปโครงการใช้น้ำมันรายบุคคลประจำเดือน $selectmonth $start_yth";
                    $customer="สายงาน $selcustomer2";
                    
                    $objDrawing = new PHPExcel_Worksheet_Drawing();$objDrawing->setName('Image');$objDrawing->setDescription('Image');$objDrawing->setPath('../images/logonew.png');$objDrawing->setWidthAndHeight(100,70);$objDrawing->setCoordinates('L1');$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
                    $objPHPExcel->getActiveSheet()->mergeCells('A1:Y1');
                    $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(0, 2, $companyth);$sheet->mergeCells('A2:Y2');$objPHPExcel->getActiveSheet()->getStyle('A2:Y2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);$sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(0, 3, $companyen);$sheet->mergeCells('A3:Y3');$objPHPExcel->getActiveSheet()->getStyle('A3:Y3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);$sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(0, 4, $address);$sheet->mergeCells('A4:Y4');$objPHPExcel->getActiveSheet()->getStyle('A4:Y4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);$sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(0, 5, $detail);$sheet->mergeCells('A5:Y5');$objPHPExcel->getActiveSheet()->getStyle('A5:Y5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);$sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(0, 6, $customer);$sheet->mergeCells('A6:Y6');$objPHPExcel->getActiveSheet()->getStyle('A6:Y6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    
                    $objDrawing = new PHPExcel_Worksheet_HeaderFooterDrawing();
                    $objPHPExcel->getActiveSheet()->getHeaderFooter()->addImage($objDrawing, PHPExcel_Worksheet_HeaderFooter::IMAGE_HEADER_LEFT);
                    $styleText = array('font'  => array('bold'  => false,'color' => array('rgb' => '000000'),'size'  => 10,'name'  => 'Verdana'));     
                    $sheet->getDefaultStyle()->applyFromArray($styleText);

                    /* Value */ $objPHPExcel->getActiveSheet()->
                    setCellValue('A7', 'ลำดับ')->
                    setCellValue('B7', 'รหัส')->
                    setCellValue('C7', 'ชื่อ')->
                    setCellValue('D7', 'สกุล')->
                    setCellValue('E7', 'เบอร์รถ')->
                    setCellValue('F7', 'ประเภทรถ')->
                    setCellValue('G7', 'จำนวน')->
                    setCellValue('G8', 'เที่ยวที่')->
                    setCellValue('G9', 'วิ่งงาน')->
                    setCellValue('H7', 'วันที่วิ่งงาน')->
                    setCellValue('I7', 'วันที่ / เวลา เติมน้ำมัน')->
                    setCellValue('J7', 'ต้นทาง')->
                    setCellValue('K7', 'ปลายทาง')->
                    setCellValue('L7', 'ประเภทงาน')->
                    setCellValue('M7', 'OTHER')->
                    setCellValue('M8', 'ไมล์ต้น')->
                    setCellValue('N8', 'ไมล์ปลาย')->
                    setCellValue('O8', 'ระยะทาง')->
                    setCellValue('P8', 'เติมใน/ลิตร')->
                    setCellValue('Q8', 'เติมนอก/ลิตร')->
                    setCellValue('R8', 'หัก PM')->
                    setCellValue('S8', 'รวมน้ำมัน')->
                    setCellValue('T8', 'ค่าเฉลี่ยที่')->
                    setCellValue('T9', 'กำหนด')->
                    setCellValue('U8', 'ค่าเฉลี่ยที่ได้')->
                    setCellValue('V8', 'จำนวนน้ำมันที่')->
                    setCellValue('V9', 'เกินกว่ากำหนด')->
                    setCellValue('W8', 'จำนวนบาท/')->
                    setCellValue('W9', 'ลิตร')->
                    setCellValue('X8', 'จำนวนเงินที่ได้')->
                    setCellValue('X9', 'บาท')->
                    setCellValue('Y7', '*หมายเหตุ');
                    /* Merge */ 
                        $objPHPExcel->getActiveSheet()->mergeCells('A7:A9');
                        $objPHPExcel->getActiveSheet()->mergeCells('B7:B9');
                        $objPHPExcel->getActiveSheet()->mergeCells('C7:C9');
                        $objPHPExcel->getActiveSheet()->mergeCells('D7:D9');
                        $objPHPExcel->getActiveSheet()->mergeCells('E7:E9');
                        $objPHPExcel->getActiveSheet()->mergeCells('F7:F9');
                        $objPHPExcel->getActiveSheet()->mergeCells('H7:H9');
                        $objPHPExcel->getActiveSheet()->mergeCells('I7:I9');
                        $objPHPExcel->getActiveSheet()->mergeCells('J7:J9');
                        $objPHPExcel->getActiveSheet()->mergeCells('K7:K9');
                        $objPHPExcel->getActiveSheet()->mergeCells('L7:L9');
                        $objPHPExcel->getActiveSheet()->mergeCells('M7:X7');
                        $objPHPExcel->getActiveSheet()->mergeCells('M8:M9');
                        $objPHPExcel->getActiveSheet()->mergeCells('N8:N9');
                        $objPHPExcel->getActiveSheet()->mergeCells('O8:O9');
                        $objPHPExcel->getActiveSheet()->mergeCells('P8:P9');
                        $objPHPExcel->getActiveSheet()->mergeCells('Q8:Q9');
                        $objPHPExcel->getActiveSheet()->mergeCells('R8:R9');
                        $objPHPExcel->getActiveSheet()->mergeCells('S8:S9');
                        $objPHPExcel->getActiveSheet()->mergeCells('U8:U9');
                        $objPHPExcel->getActiveSheet()->mergeCells('Y7:Y9');                    
                    /* Border */
                        $sheet->getStyle('A7:F9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('G7:G9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('G7:G9')->applyFromArray(array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('H7:L9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('M7:X7')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('M8:P9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('Q7:Q9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('Q7:Q9')->applyFromArray(array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('A9:V9')->applyFromArray(array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('R8:R9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('S8:S9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('T8:T9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('U8:U9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('V8:V9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('W8:W9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('X8:X9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('Y7:Y9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('A7:L9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '9ACD32'))));//เขียว
                        $sheet->getStyle('M7:X7')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '9ACD32'))));//เขียว
                        $sheet->getStyle('M8:N9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '9ACD32'))));//เขียว
                        $sheet->getStyle('P8:R9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '9ACD32'))));//เขียว
                        $sheet->getStyle('T8:T9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '9ACD32'))));//เขียว
                        $sheet->getStyle('V8:W9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '9ACD32'))));//เขียว
                        $sheet->getStyle('O8:O9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));//เหลือง
                        $sheet->getStyle('S8:S9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));//เหลือง
                        $sheet->getStyle('U8:U9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));//เหลือง
                        $sheet->getStyle('X8:X9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));//เหลือง
                        $sheet->getStyle('Y7:Y9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FF8C00'))));//ส้ม
                    /* Style */ $objPHPExcel->getActiveSheet()->getStyle('A7:Y9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    /* Width */ 
                        $sheet->getColumnDimension('A')->setWidth(5);
                        $sheet->getColumnDimension('B')->setWidth(8); 
                        $sheet->getColumnDimension('C')->setWidth(12);
                        $sheet->getColumnDimension('D')->setWidth(12);
                        $sheet->getColumnDimension('E')->setWidth(10);
                        $sheet->getColumnDimension('F')->setWidth(12);
                        $sheet->getColumnDimension('G')->setWidth(6);
                        $sheet->getColumnDimension('H')->setWidth(14);
                        $sheet->getColumnDimension('I')->setWidth(18);
                        $sheet->getColumnDimension('J')->setWidth(12);
                        $sheet->getColumnDimension('K')->setWidth(12);
                        $sheet->getColumnDimension('L')->setWidth(10);
                        $sheet->getColumnDimension('M')->setWidth(9);
                        $sheet->getColumnDimension('N')->setWidth(9);
                        $sheet->getColumnDimension('O')->setWidth(9);
                        $sheet->getColumnDimension('P')->setWidth(10);
                        $sheet->getColumnDimension('Q')->setWidth(10);
                        $sheet->getColumnDimension('R')->setWidth(10);
                        $sheet->getColumnDimension('S')->setWidth(10);
                        $sheet->getColumnDimension('T')->setWidth(12);
                        $sheet->getColumnDimension('U')->setWidth(12);
                        $sheet->getColumnDimension('V')->setWidth(12);
                        $sheet->getColumnDimension('W')->setWidth(12);
                        $sheet->getColumnDimension('X')->setWidth(12);
                        $sheet->getColumnDimension('Y')->setWidth(50);

                    $newdate=$start_yen.'-'.$startif.'-'.$chkday;
                    $newdatestart=$start_yen.'-'.$startif.'-'.$chkday.' 07:00';
                    $newdateend=$start_ymd.' 07:00';
                
                    if($selcompany2 == "RRC"){
                        $findfield = "SCPT.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID AND ";
                    }else{
                        $findfield = "1=1 AND ";
                    }

                    $RESULT_PLAN = array();
                    $SQLPLAN="SELECT DISTINCT EHR.PersonCode EMPC,EHR.PositionNameT,EHR.FnameT,EHR.LnameT,EHR.nameT EMPN,VHCTPP.JOBNO,VHCTPP.COMPANYCODE COM,VHCTPP.CUSTOMERCODE CUS,OTSN.OILDATAID OILID,
                        VHCTPP.EMPLOYEECODE1 EMPC1,VHCTPP.EMPLOYEENAME1 EMPN1,VHCTPP.EMPLOYEECODE2 EMPC2,VHCTPP.EMPLOYEENAME2 EMPN2,
                        CASE 
                            WHEN EHR1.PositionNameT LIKE '%ปลอกเหลือง%' THEN 'yellow'
                            WHEN EHR1.PositionNameT LIKE '%ปลอกเขียว%' THEN 'green'
                            ELSE ''
                        END CHKPST1,
                        CASE 
                            WHEN EHR2.PositionNameT LIKE '%ปลอกเหลือง%' THEN 'yellow'
                            WHEN EHR2.PositionNameT LIKE '%ปลอกเขียว%' THEN 'green'
                            ELSE ''
                        END CHKPST2,
                        CONVERT ( VARCHAR ( 10 ), VHCTPP.DATEWORKING, 20 ) DW,
                        CONVERT ( VARCHAR ( 10 ), VHCTPP.DATEWORKING, 103 ) DATEWORKING_CON,
                        CONVERT ( VARCHAR ( 10 ), OTSN.REFUELINGDATE, 20 ) REFUEL,
                        CONVERT ( VARCHAR ( 10 ), OTSN.REFUELINGDATE, 103 ) REFUEL_CON,
                        SUBSTRING ( CONVERT ( VARCHAR ( 20 ), OTSN.REFUELINGDATE, 20 ), 12, 5 ) AS TIME,VHCTPP.THAINAME,
                        VHCTPP.WORKTYPE,OTSN.OIL_BILLNUMBER OBLNB,OTSN.VEHICLEREGISNUMBER VHCRGNB,OTSN.VEHICLETYPE CARTYPE,VHCTPP.VEHICLETYPE VHCTPLAN,VHCTPP.JOBSTART JOBSTART,VHCTPP.JOBEND JOBEND,
                        OTSN.MILEAGESTART MST,OTSN.MILEAGEEND MLE,OTSN.DISTANCE DTE,OTSN.OIL_AMOUNT,OTSN.OIL_AVERAGE OAVG,OTSN.OIL_TARGET OTG,VHCTPP.C2,VHCTPP.C3,VHCTPP.E1 MONEY,OTSN.JOBNO,VHCTPP.JOBNO,
                        (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID AND OSGS_TY IN(1,2,3)) AS OAMOUT,
                        (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID AND OSGS_TY = 4) AS OAMPM,VHCTPP.RS_OILAVERAGE,
                        STUFF((SELECT '+'+ CAST(SCPT.JOBSTART AS VARCHAR)+'->'+ CAST(SCPT.JOBEND AS VARCHAR) FROM VEHICLETRANSPORTPLAN SCPT WHERE ".$findfield." SCPT.COMPANYCODE = VHCTPP.COMPANYCODE AND SCPT.EMPLOYEECODE1 = VHCTPP.EMPLOYEECODE1 AND CONVERT(VARCHAR (10),SCPT.DATEWORKING,20) = CONVERT ( VARCHAR ( 10 ), VHCTPP.DATEWORKING, 20 ) FOR XML PATH(''), TYPE).value('.','VARCHAR(max)'), 1, 1, '') AS CHKJOBSTARTEND,
                        STUFF((SELECT ','+ CAST(WORKTYPE AS VARCHAR) FROM VEHICLETRANSPORTPLAN WHERE NOT STATUSNUMBER = 'X' AND EMPLOYEECODE1 = VHCTPP.EMPLOYEECODE1 AND CONVERT(VARCHAR(10),DATEWORKING,20) = CONVERT(VARCHAR(10),VHCTPP.DATEWORKING,20) ORDER BY ROUNDAMOUNT ASC FOR XML PATH(''), TYPE).value('.','VARCHAR(max)'), 1, 1, '') AS CHKWORK
                        FROM EMPLOYEEEHR2 EHR 
                        FULL OUTER JOIN VEHICLETRANSPORTPLAN VHCTPP ON (VHCTPP.EMPLOYEENAME1 = EHR.nameT OR VHCTPP.EMPLOYEENAME2 = EHR.nameT) 
                            AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' 
                            AND VHCTPP.O4 IS NOT NULL AND VHCTPP.C3 IS NOT NULL
                            AND $findcustomer
                        FULL OUTER JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI AND OTSN.OIL_BILLNUMBER IS NOT NULL
                        LEFT JOIN EMPLOYEEEHR2 EHR1 ON VHCTPP.EMPLOYEECODE1 = EHR1.PersonCode
                        LEFT JOIN EMPLOYEEEHR2 EHR2 ON VHCTPP.EMPLOYEECODE2 = EHR2.PersonCode
                        WHERE $QUERYWHERE1
                        UNION
                        SELECT DISTINCT EHR.PersonCode EMPC,EHR.PositionNameT,EHR.FnameT,EHR.LnameT,EHR.nameT EMPN,VHCTPP.JOBNO,VHCTPP.COMPANYCODE COM,VHCTPP.CUSTOMERCODE CUS,OTSN.OILDATAID OILID,
                        VHCTPP.EMPLOYEECODE1 EMPC1,VHCTPP.EMPLOYEENAME1 EMPN1,VHCTPP.EMPLOYEECODE2 EMPC2,VHCTPP.EMPLOYEENAME2 EMPN2,
                        CASE 
                            WHEN EHR1.PositionNameT LIKE '%ปลอกเหลือง%' THEN 'yellow'
                            WHEN EHR1.PositionNameT LIKE '%ปลอกเขียว%' THEN 'green'
                            ELSE ''
                        END CHKPST1,
                        CASE 
                            WHEN EHR2.PositionNameT LIKE '%ปลอกเหลือง%' THEN 'yellow'
                            WHEN EHR2.PositionNameT LIKE '%ปลอกเขียว%' THEN 'green'
                            ELSE ''
                        END CHKPST2,
                        CONVERT ( VARCHAR ( 10 ), VHCTPP.DATEWORKING, 20 ) DW,
                        CONVERT ( VARCHAR ( 10 ), VHCTPP.DATEWORKING, 103 ) DATEWORKING_CON,
                        CONVERT ( VARCHAR ( 10 ), OTSN.REFUELINGDATE, 20 ) REFUEL,
                        CONVERT ( VARCHAR ( 10 ), OTSN.REFUELINGDATE, 103 ) REFUEL_CON,
                        SUBSTRING ( CONVERT ( VARCHAR ( 20 ), OTSN.REFUELINGDATE, 20 ), 12, 5 ) AS TIME,VHCTPP.THAINAME,
                        VHCTPP.WORKTYPE,OTSN.OIL_BILLNUMBER OBLNB,OTSN.VEHICLEREGISNUMBER VHCRGNB,OTSN.VEHICLETYPE CARTYPE,VHCTPP.VEHICLETYPE VHCTPLAN,VHCTPP.JOBSTART JOBSTART,VHCTPP.JOBEND JOBEND,
                        OTSN.MILEAGESTART MST,OTSN.MILEAGEEND MLE,OTSN.DISTANCE DTE,OTSN.OIL_AMOUNT,OTSN.OIL_AVERAGE OAVG,OTSN.OIL_TARGET OTG,VHCTPP.C2,VHCTPP.C3,VHCTPP.E1 MONEY,OTSN.JOBNO,VHCTPP.JOBNO,
                        (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID AND OSGS_TY IN(1,2,3)) AS OAMOUT,
                        (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID AND OSGS_TY = 4) AS OAMPM,VHCTPP.RS_OILAVERAGE,
                        STUFF((SELECT '+'+ CAST(SCPT.JOBSTART AS VARCHAR)+'->'+ CAST(SCPT.JOBEND AS VARCHAR) FROM VEHICLETRANSPORTPLAN SCPT WHERE ".$findfield." SCPT.COMPANYCODE = VHCTPP.COMPANYCODE AND SCPT.EMPLOYEECODE1 = VHCTPP.EMPLOYEECODE1 AND CONVERT(VARCHAR (10),SCPT.DATEWORKING,20) = CONVERT ( VARCHAR ( 10 ), VHCTPP.DATEWORKING, 20 ) FOR XML PATH(''), TYPE).value('.','VARCHAR(max)'), 1, 1, '') AS CHKJOBSTARTEND,
                        STUFF((SELECT ','+ CAST(WORKTYPE AS VARCHAR) FROM VEHICLETRANSPORTPLAN WHERE NOT STATUSNUMBER = 'X' AND EMPLOYEECODE1 = VHCTPP.EMPLOYEECODE1 AND CONVERT(VARCHAR(10),DATEWORKING,20) = CONVERT(VARCHAR(10),VHCTPP.DATEWORKING,20) ORDER BY ROUNDAMOUNT ASC FOR XML PATH(''), TYPE).value('.','VARCHAR(max)'), 1, 1, '') AS CHKWORK
                        FROM VEHICLETRANSPORTPLAN VHCTPP 
                        LEFT JOIN EMPLOYEEEHR2 EHR ON (VHCTPP.EMPLOYEENAME1 = EHR.nameT OR VHCTPP.EMPLOYEENAME2 = EHR.nameT)
                        LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                        LEFT JOIN EMPLOYEEEHR2 EHR1 ON VHCTPP.EMPLOYEECODE1 = EHR1.PersonCode
                        LEFT JOIN EMPLOYEEEHR2 EHR2 ON VHCTPP.EMPLOYEECODE2 = EHR2.PersonCode
                        WHERE NOT (EHR.PositionNameT LIKE '%ปลอกเขียว%' OR EHR.PositionNameT LIKE '%ปลอกเหลือง%') AND OTSN.OIL_BILLNUMBER IS NOT NULL AND VHCTPP.O4 IS NOT NULL
                        AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' AND NOT EHR.Company_Code IN('RKR','RKL','RKS')
                        AND $QUERYWHERE2
                        AND $findfeildPLAN";
                        // WHERE (VHCTPP.EMPLOYEENAME1 = '$EMPN' OR VHCTPP.EMPLOYEENAME2 ='$EMPN') AND $QUERYIFELSE1";
                    $QUERYPLAN = sqlsrv_query($conn, $SQLPLAN );
                    $NO = "1";
                    $i = "10";
                    $numpage = "1";
                    // while($RSPLAN = sqlsrv_fetch_array($QUERYPLAN, SQLSRV_FETCH_ASSOC)){	
                    while($RESULTPLAN = sqlsrv_fetch_array($QUERYPLAN, SQLSRV_FETCH_ASSOC)){	
                        $RESULT_PLAN[] = array(
                            'EMPN'=>$RESULTPLAN['EMPN'],
                            'EMPC'=>$RESULTPLAN['EMPC'],
                            'COM'=>$RESULTPLAN['COM'],
                            'CUS'=>$RESULTPLAN['CUS'],
                            'VHCRGNB'=>$RESULTPLAN['VHCRGNB'],
                            'VHCTPLAN'=>$RESULTPLAN['VHCTPLAN'],
                            'JOBSTART'=>$RESULTPLAN['JOBSTART'],
                            'JOBEND'=>$RESULTPLAN['JOBEND'],
                            'MST'=>$RESULTPLAN['MST'],
                            'MLE'=>$RESULTPLAN['MLE'],
                            'DTE'=>$RESULTPLAN['DTE'],
                            'WORKTYPE'=>$RESULTPLAN['WORKTYPE'],
                            'THAINAME'=>$RESULTPLAN['THAINAME'],
                            'C3'=>$RESULTPLAN['C3'],
                            'ROWNUM'=>$RESULTPLAN['ROWNUM'],
                            'JOBNO'=>$RESULTPLAN['JOBNO'],
                            'C2'=>$RESULTPLAN['C2'],
                            'OIL_AMOUNT'=>$RESULTPLAN['OIL_AMOUNT'],
                            'OAMOUT'=>$RESULTPLAN['OAMOUT'],
                            'OAMPM'=>$RESULTPLAN['OAMPM'],
                            'OTG'=>$RESULTPLAN['OTG'],
                            'OAVG'=>$RESULTPLAN['OAVG'],
                            'EMPC1'=>$RESULTPLAN['EMPC1'],
                            'EMPC2'=>$RESULTPLAN['EMPC2'],
                            'CHKPST1'=>$RESULTPLAN["CHKPST1"],
                            'CHKPST2'=>$RESULTPLAN["CHKPST2"],
                            'DATEWORKING_CON'=>$RESULTPLAN['DATEWORKING_CON'],
                            'REFUEL_CON'=>$RESULTPLAN['REFUEL_CON'],
                            'TIME'=>$RESULTPLAN['TIME'],
                            'RS_OILAVERAGE'=>$RESULTPLAN['RS_OILAVERAGE'],
                            'CHKJOBSTARTEND'=>$RESULTPLAN['CHKJOBSTARTEND']
                        );
                    } 
                    foreach($RESULT_PLAN as $RSPLAN){    
                        
                        $pieces = explode(" ", $RSPLAN["EMPN"]);
                        $fname=$pieces[0];
                        $lname=$pieces[1];
                        $EMPN = $RSPLAN['EMPN'];
                        $EMPC = $RSPLAN["EMPC"]; 
                        $JOBNO = $RSPLAN["JOBNO"];                         
                        $COM=$RSPLAN["COM"];
                        $CUS=$RSPLAN["CUS"];
                        $VHCRGNB=$RSPLAN["VHCRGNB"];
                        $VHCTPLAN=$RSPLAN["VHCTPLAN"];
                        $JOBSTART=$RSPLAN["JOBSTART"];
                        $JOBEND=$RSPLAN["JOBEND"];
                        $MST=$RSPLAN["MST"];
                        $MLE=$RSPLAN["MLE"];
                        $DTE=$RSPLAN["DTE"];
                        $WORKTYPE=$RSPLAN["WORKTYPE"];
                        $VHCTHAINAME=$RSPLAN["THAINAME"]; 
                        $C3=$RSPLAN["C3"];   
                        $ROWNUM = $RSPLAN["ROWNUM"];                            

                        $C2IF=$RSPLAN["C2"];
                        if($C2IF>='0'){
                            $C2='NOTNULL';
                        }else{
                            $C2='NULL';
                        }
                        $CHKWORK=$objResult["CHKWORK"]; 
                        
                        if($CHKWORK==","){$CHKWORKIF="";}else if($CHKWORK==",,"){$CHKWORKIF="";}else if($CHKWORK==",,,"){$CHKWORKIF="";}else if($CHKWORK==",,,,"){$CHKWORKIF="";}else{$CHKWORKIF=$CHKWORK;}
                        
                        $CHKW = explode(",", $CHKWORK);
                        $RSCHKW1 = $CHKW[0];
                        $RSCHKW2 = $CHKW[1];
                        $RSCHKW3 = $CHKW[2];
                        $RSCHKW4 = $CHKW[3];
                        
                        if($RSPLAN["OIL_AMOUNT"]>0){
                            $OILAMOUNTLEFT=$RSPLAN["OIL_AMOUNT"];
                        }else{
                            $OILAMOUNTLEFT='';
                        }
                        if($RSPLAN["OAMOUT"]>0){
                            $OAMOUTLEFT=$RSPLAN["OAMOUT"];
                        }else{
                            $OAMOUTLEFT='';
                        }
                        if($RSPLAN["OAMPM"]>0){
                            $OAMPMLEFT=$RSPLAN["OAMPM"];
                        }else{
                            $OAMPMLEFT='';
                        }                        
                        if(($OILAMOUNTLEFT>0)&&($OAMOUTLEFT>0)&&($OAMPMLEFT>0)){
                            $OAM=($OILAMOUNTLEFT+$OAMOUTLEFT)-$OAMPMLEFT;
                            $OAM_RS='=(P'.$i.'+Q'.$i.')-R'.$i;
                            $REMARKOILLEFT='(เติมใน+เติมนอก)-PM ... ('.$OILAMOUNTLEFT.'+'.$OAMOUTLEFT.')-'.$OAMPMLEFT.' = '.$OAM.' ลิตร';
                        }else if(($OILAMOUNTLEFT>0)&&($OAMOUTLEFT>0)&&($OAMPMLEFT=='')){
                            $OAM=$OILAMOUNTLEFT+$OAMOUTLEFT;
                            $OAM_RS='=P'.$i.'+Q'.$i;
                            $REMARKOILLEFT='เติมใน+เติมนอก ... '.$OILAMOUNTLEFT.'+'.$OAMOUTLEFT.' = '.$OAM.' ลิตร';
                        }else if(($OILAMOUNTLEFT>0)&&($OAMOUTLEFT=='')&&($OAMPMLEFT>0)){
                            $OAM=$OILAMOUNTLEFT-$OAMPMLEFT;
                            $OAM_RS='=P'.$i.'-R'.$i;
                            $REMARKOILLEFT='เติมใน-PM ... '.$OILAMOUNTLEFT.'-'.$OAMPMLEFT.' = '.$OAM.' ลิตร';
                        }else{
                            $OAM=$OILAMOUNTLEFT;
                            $OAM_RS=$OILAMOUNTLEFT;
                            $REMARKOILLEFT='';
                        }

                        $OTG=$RSPLAN["OTG"];
                        $OAVG=$RSPLAN["OAVG"];                                  
                        $EMPC1=$RSPLAN["EMPC1"];
                        $EMPC2=$RSPLAN["EMPC2"];                                

                        $SQLPRICE = "SELECT OLP.PRICE,OLP.COMPANYCODE,OLP.[MONTH],OLP.[YEAR] FROM OILPEICE OLP WHERE OLP.COMPANYCODE = '$COM' AND OLP.[YEAR] = '$start_yen' AND OLP.[MONTH] = '$selectmonth'";
                        $QUERYPRICE = sqlsrv_query($conn, $SQLPRICE);
                        $RSPRICE = sqlsrv_fetch_array($QUERYPRICE, SQLSRV_FETCH_ASSOC);   
                            $PRICE=$RSPRICE["PRICE"];


                        $SQLROUND="SELECT COUNT(VHCTPP.EMPLOYEECODE1) AS ROUND FROM VEHICLETRANSPORTPLAN VHCTPP WHERE VHCTPP.COMPANYCODE = '$COM' AND (VHCTPP.EMPLOYEENAME1 = '$EMPN' OR VHCTPP.EMPLOYEENAME2 ='$EMPN') AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' GROUP BY VHCTPP.EMPLOYEECODE1 ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                        $QUERYROUND = sqlsrv_query($conn, $SQLROUND );
                        $RSROUND = sqlsrv_fetch_array($QUERYROUND, SQLSRV_FETCH_ASSOC);   
                            $ROUND=$RSROUND["ROUND"];    

                        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $numpage);
                        $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $EMPC);
                        $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $fname);
                        $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $lname);  
                        $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $VHCTHAINAME);
                        $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $VHCTPLAN);   
                        $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $ROUND);                                
                        $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $RSPLAN["DATEWORKING_CON"]);
                        $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $RSPLAN["REFUEL_CON"].' '.$RSPLAN["TIME"]);
                        $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $JOBSTART);
                        $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $JOBEND);
                        $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $WORKTYPE);
                        $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $MST);
                        $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $MLE);
                        $caldis=$MLE-$MST;
                        if($caldis>0){
                            $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, '=N'.$i.'-M'.$i);
                        }else{
                            $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, '');
                        }
                        $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $OILAMOUNTLEFT);
                        $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $OAMOUTLEFT);
                        $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $OAMPMLEFT);   
                        $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $OAM_RS);
                                             
                        if(isset($RSPLAN["RS_OILAVERAGE"])){
                            $OAVR=$RSPLAN["RS_OILAVERAGE"];
                            $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $OAVR);
                        }else{
                            if($selcustomer2=="TTT"){
                            $findfeildOIL="AND OILAVERAGE.REMARK = '$WORKTYPE'";
                            }else{
                                $findfeildOIL="";
                            }  
                            $SQLOAVG="SELECT DISTINCT OILAVERAGE.OILAVERAGE OAVR FROM OILAVERAGE WHERE OILAVERAGE.COMPANYCODE = '$COM' AND OILAVERAGE.CUSTOMERCODE = '$CUS' AND OILAVERAGE.VEHICLETYPE = '$VHCTPLAN' ".$findfeildOIL."";
                            $QUERYOAVG = sqlsrv_query($conn, $SQLOAVG ); while($RSOAVG = sqlsrv_fetch_array($QUERYOAVG)) {                                         
                                if ($VHCRGNB =='61-4454'||$VHCRGNB =='61-4456'||$VHCRGNB =='61-3440'||$VHCRGNB =='61-3441'||$VHCRGNB =='61-4453'||$VHCRGNB =='61-4457'||$VHCRGNB =='61-4912'||$VHCRGNB =='61-4913'||$VHCRGNB =='61-4546'||$VHCRGNB =='61-4547'||$VHCRGNB =='64-3452'||$VHCRGNB =='61-3445'||$VHCRGNB =='61-3439'||$VHCRGNB =='61-3443'||$VHCRGNB =='61-3834'||$VHCRGNB =='61-3835'||$VHCRGNB =='61-3438'||$VHCRGNB =='61-3437'||$VHCRGNB =='62-9288'||$VHCRGNB =='61-3836'||$VHCRGNB =='61-4458'||$VHCRGNB =='61-3444'||$VHCRGNB =='60-3868'||$VHCRGNB =='60-3870'||$VHCRGNB =='61-3437'||$VHCRGNB =='61-3452') {
                                    $OAVR = '4.0';    
                                }else if($VHCRGNB =='60-3871'||$VHCRGNB =='61-3442'||$VHCRGNB =='60-2391'||$VHCRGNB =='61-3444'||$VHCRGNB =='76-8919'||$VHCRGNB =='61-4458'||$VHCRGNB =='79-2521'||$VHCRGNB =='79-2522'||$VHCRGNB =='79-2525'||$VHCRGNB =='74-5653'||$VHCRGNB =='74-5684'||$VHCRGNB =='74-5684'||$VHCRGNB =='74-5654') {
                                    $OAVR = '3.5';           
                                }else if(($VHCTHAINAME=='T-001')||($VHCTHAINAME=='T-002')||($VHCTHAINAME=='T-003')||($VHCTHAINAME=='T-004')){     // ชื่อรถ T001 - T004
                                    if($CUS=='GMT'){                                                              // ถ้าเป็นลูกค้า GMT
                                        $OAVR='4.25';                                                               // คิด 4.25
                                    }else{                                                                              // ถ้าไม่ใช่ลูกค้า GMT
                                        $OAVR='5.00';                                                               // คิด 5.00
                                    }                                                                                     
                                }else if(($VHCTHAINAME=='T-005')||($VHCTHAINAME=='T-006')||($VHCTHAINAME=='T-007')||($VHCTHAINAME=='T-008')||($VHCTHAINAME=='T-009')){    // ชื่อรถ T001 - T004
                                    $OAVR='4.75';                                                                                            // คิด 4.75
                                }else if(($VHCTHAINAME=='G-001')||($VHCTHAINAME=='G-002')||($VHCTHAINAME=='G-003')||($VHCTHAINAME=='G-004')||($VHCTHAINAME=='G-005')||
                                        ($VHCTHAINAME=='G-006')||($VHCTHAINAME=='G-007')||($VHCTHAINAME=='G-008')||($VHCTHAINAME=='G-009')||($VHCTHAINAME=='G-010')||
                                        ($VHCTHAINAME=='G-011')||($VHCTHAINAME=='G-012')||($VHCTHAINAME=='G-013')){                                           // ชื่อรถ G001 - G0013
                                    if($VHCTPLAN=="10W(Dump)"){                                                                                 // ถ้าเป็นรถ 10W
                                        $OAVR='4.25';                                                                                       // คิด 4.25
                                    }else if($VHCTPLAN=="22W(Dump)"){                                                                           // ถ้าเป็นรถ 22W
                                        $OAVR='3.00';                                                                                       // คิด 3.00
                                    } 
                                }else if($C2=="NOTNULL"){                                          // ถ้าเป็นงานรับกลับ
                                    $OAVR='3.75';                                       // คิด 3.75
                                }else{
                                    if(($ROUND=='1')){                                   // 1 เที่ยว
                                        if($RSCHKW1=='sh'){
                                            $OAVR='4.25';                               // sh = 3.75 // แก้เป็น 4.25 วันที่ 6/9/2023
                                        }else if($RSCHKW1=='nm'){
                                            $OAVR='4.25';                               // nm = 4.25 
                                        }else{
                                            $OAVR=$RSOAVG["OAVR"];                // เรทปกติจากระบบ 
                                        }
                                    }else if($ROUND=='2'){                               // 2 เที่ยว                                                                   
                                        if(($RSCHKW1=='sh')&&($RSCHKW2=='sh')){ 
                                            $OAVR='3.75';                               // sh-sh = 3.75
                                        }else if(($RSCHKW1=='sh')&&($RSCHKW2=='nm')){
                                            $OAVR='4.25';                               // sh-nm = 4.25
                                        }else if(($RSCHKW1=='nm')&&($RSCHKW2=='sh')){
                                            $OAVR='3.75';                               // nm-sh = 3.75  
                                        }else if(($RSCHKW1=='nm')&&($RSCHKW2=='nm')){
                                            $OAVR='4.25';                               // nm-nm = 4.25                                                                        
                                        }else{
                                            $OAVR=$RSOAVG["OAVR"]; // เรทปกติจากระบบ                                                                    
                                        }
                                    }else{
                                        $OAVR=$RSOAVG["OAVR"];  // เรทปกติจากระบบ                                                                    
                                    }
                                    
                                }
                                $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $OAVR);
                            }
                        }  
                        if(($caldis>0) && ($OAM>0)){
                            $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, '=O'.$i.'/S'.$i);
                        }else{
                            $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, '');
                        }
                        if(($caldis>0) && ($OAM>0)){
                            $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, '=(O'.$i.'/T'.$i.')-S'.$i);
                        }else{
                            $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, '');
                        }
                        $objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $PRICE);
                    
                        $EMPC1=$RSPLAN["EMPC1"];
                        $EMPC2=$RSPLAN["EMPC2"];
                        $CHKPST1=$RSPLAN["CHKPST1"];
                        $CHKPST2=$RSPLAN["CHKPST2"];
                        // echo 'คนที่ 1 '.$EMP.'<br>';
                        // echo 'คนที่ 2 '.$EMPC2.'<br>';
                        if($EMPC2==$EMPC1){
                            $CALPRICE=$C3;
                        }else if($EMPC2!=$EMPC1){
                            if($COM=='RRC'){
                                $CALPRICE=$C3;
                            }else{
                                if(($CHKPST1=="green") || ($CHKPST1=="yellow")){
                                    $CALPRICE=$C3;
                                }else if(($CHKPST2=="green") || ($CHKPST2=="yellow")){
                                    $CALPRICE=$C3;
                                }else{
                                    if($EMPC2!=""){
                                        $CALPRICE=$C3/2;
                                    }else{
                                        $CALPRICE=$C3;
                                    }
                                }                                
                            }
                        }


                        // ไม่คิดเรทน้ำมัน          
                            $CHKJOBSTARTEND=$RSPLAN["CHKJOBSTARTEND"]; 
                            $CMPNC=$RSPLAN["COM"];
                            $CTMC=$RSPLAN["CUS"];
                            $JNST=$RSPLAN["JOBSTART"];
                            $JNED=$RSPLAN["JOBEND"];
                            $explodeJOB = explode("+", $CHKJOBSTARTEND);
                            $JOBONE = $explodeJOB[0];
                            $JOBTWO = $explodeJOB[1];                                  
                            if(($CMPNC=='RCC')||($CMPNC=='RATC')){
                                if($VHCTPLAN=='4L'){
                                    $MONEYTOTAL='0';
                                    $REMARK='ไม่คิดเรทน้ำมัน';
                                }else if($VHCTPLAN=='8L'){
                                    if($ROUND=='1'){
                                        if(($JOBONE=='GW->BP')||($JOBONE=='BP->GW')||($JOBONE=='BP->TAC')||($JOBONE=='GW->GMT2')){
                                            $MONEYTOTAL='0';
                                            $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else if($JOBONE=='GW->E3,E3'||$JOBONE=='GW->E3,E8'||$JOBONE=='GW->E3,I1'||$JOBONE=='GW->E3,I15'||
                                                 $JOBONE=='GW->E8,E3'||$JOBONE=='GW->E8,E8'||$JOBONE=='GW->E8,I1'||$JOBONE=='GW->E8,I15'||
                                                 $JOBONE=='GW->I1,E3'||$JOBONE=='GW->I1,E8'||$JOBONE=='GW->I1,I1'||$JOBONE=='GW->I1,I15'||
                                                 $JOBONE=='GW->I15,E3'||$JOBONE=='GW->I15,E8'||$JOBONE=='GW->I15,I1'||$JOBONE=='GW->I15,I15'||
                                                 $JOBONE=='GW->E3'||$JOBONE=='GW->E8'||$JOBONE=='GW->I1'||$JOBONE=='GW->I15'){
                                            $MONEYTOTAL='0';
                                            $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else if($JOBONE=='GW->LCB 3 เที่ยว'){
                                            $MONEYTOTAL='0';
                                            $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else if($JOBONE=='BP->SW'){
                                            $MONEYTOTAL='0';
                                            $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else if($JNST=='กัมพูชา'||$JNED=='กัมพูชา'){
                                            $MONEYTOTAL='0';
                                            $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else if($VHCTHAINAME=='R-401'||$VHCTHAINAME=='R-801'||$VHCTHAINAME=='R-802'){
                                            $MONEYTOTAL='0';
                                            $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else{
                                            //$MONEYTOTAL='=S'.$i.'*T'.$i;
                                            // $MONEYTOTAL=$C3;
                                            $MONEYTOTAL=$CALPRICE;                                                
                                            $REMARK='';
                                        }
                                    }else if($ROUND=='2'){
                                        if($JOBONE=='GW->BP' && ($JOBTWO=='BP->SW'||$JOBTWO=='BP->GW'||$JOBTWO=='GW->BP'||$JOBTWO=='SP->BP'||$JOBTWO=='BP->SP'||$JOBTWO=='GW->I1'||$JOBTWO=='GW->I15')){
                                                $MONEYTOTAL='0';
                                                $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else if($JOBONE=='BP->GW' && $JOBTWO=='BP->GW'){
                                            $MONEYTOTAL='0';    
                                            $REMARK='ไม่คิดเรทน้ำมัน'; 
                                        }else if(($JOBONE=='BP->TAC')&&($JOBTWO=='TAC->BP')){
                                                $MONEYTOTAL='0';    
                                                $REMARK='ไม่คิดเรทน้ำมัน';  
                                        }else if($JOBONE=='GW->LCB' && ($JOBTWO=='GW->I1'||$JOBTWO=='GW->I15'||$JOBTWO=='GW->I1,I15'||$JOBTWO=='GW->E3')){
                                                $MONEYTOTAL='0';
                                                $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else if(($JOBONE=='GW->LCB 3 เที่ยว')&&($JOBTWO=='GW->LCB 3 เที่ยว')){
                                            $MONEYTOTAL='0';
                                            $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else if($JNST=='กัมพูชา'||$JNED=='กัมพูชา'){
                                                $MONEYTOTAL='0';
                                                $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else if($VHCTHAINAME=='R-401'||$VHCTHAINAME=='R-801'||$VHCTHAINAME=='R-802'){
                                                $MONEYTOTAL='0';
                                                $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else{
                                            //$MONEYTOTAL='=S'.$i.'*T'.$i;
                                            // $MONEYTOTAL=$C3;
                                            $MONEYTOTAL=$CALPRICE;  
                                            $REMARK='';
                                        }
                                    }else{
                                        if($JOBONE=='GW->E3,E3'||$JOBONE=='GW->E3,E8'||$JOBONE=='GW->E3,I1'||$JOBONE=='GW->E3,I15'||
                                            $JOBONE=='GW->E8,E3'||$JOBONE=='GW->E8,E8'||$JOBONE=='GW->E8,I1'||$JOBONE=='GW->E8,I15'||
                                            $JOBONE=='GW->I1,E3'||$JOBONE=='GW->I1,E8'||$JOBONE=='GW->I1,I1'||$JOBONE=='GW->I1,I15'||
                                            $JOBONE=='GW->I15,E3'||$JOBONE=='GW->I15,E8'||$JOBONE=='GW->I15,I1'||$JOBONE=='GW->I15,I15'||
                                            $JOBONE=='GW->E3'||$JOBONE=='GW->E8'||$JOBONE=='GW->I1'||$JOBONE=='GW->I15'){
                                            $MONEYTOTAL='0';
                                            $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else if($JOBONE=='GW->LCB 3 เที่ยว'){
                                            $MONEYTOTAL='0';
                                            $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else if($JNST=='กัมพูชา'||$JNED=='กัมพูชา'){
                                            $MONEYTOTAL='0';
                                            $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else if($VHCTHAINAME=='R-401'||$VHCTHAINAME=='R-801'||$VHCTHAINAME=='R-802'){
                                            $MONEYTOTAL='0';
                                            $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else{
                                            //$MONEYTOTAL='=S'.$i.'*T'.$i;
                                            // $MONEYTOTAL=$C3;
                                            $MONEYTOTAL=$CALPRICE;  
                                            $REMARK='';
                                        }
                                    }
                                }
                            }else if($CMPNC=='RRC'){
                                if($JOBONE=='GMT->ICP1,ICP2'||$JOBONE=='GMT->ICP1,NTS'||$JOBONE=='GMT->ICP1,GJ'||$JOBONE=='GMT->ICP1,KIRIU'||
                                   $JOBONE=='GMT->ICP2,ICP1'||$JOBONE=='GMT->ICP2,NTS'||$JOBONE=='GMT->ICP2,GJ'||$JOBONE=='GMT->ICP2,KIRIU'||
                                   $JOBONE=='GMT->NTS,ICP1' ||$JOBONE=='GMT->NTS,ICP2'||$JOBONE=='GMT->NTS,GJ' ||$JOBONE=='GMT->NTS,KIRIU' ||
                                   $JOBONE=='GMT->GJ,ICP1'  ||$JOBONE=='GMT->GJ,ICP2' ||$JOBONE=='GMT->GJ,NTS' ||$JOBONE=='GMT->GJ,KIRIU'  ||
                                   $JOBONE=='GMT->ICP1'     ||$JOBONE=='GMT->ICP2'    ||$JOBONE=='GMT->NTS'    ||$JOBONE=='GMT->GJ'        ||
                                   $JOBONE=='GMT->KIRIU'    ||$JOBONE=='GMT->TSB'     ||$JOBONE=='GMT->TSMT สระบุรี'){
                                    // if($JOBONE=='GMT->ICP1'||$JOBONE=='GMT->ICP2'||$JOBONE=='GMT->NTS'||$JOBONE=='GMT->GJ'||$JOBONE=='GMT->KIRIU'||
                                    //    $JOBTWO=='GMT->ICP1'||$JOBTWO=='GMT->ICP2'||$JOBTWO=='GMT->NTS'||$JOBTWO=='GMT->GJ'||$JOBTWO=='GMT->KIRIU'){
                                    $MONEYTOTAL='0';   
                                    $REMARK='ไม่คิดเรทน้ำมัน';
                                }else if($JOBONE=='GMT 2->ICP1,ICP2'||$JOBONE=='GMT 2->ICP1,NTS'||$JOBONE=='GMT 2->ICP1,GJ'||$JOBONE=='GMT 2->ICP1,KIRIU'||
                                         $JOBONE=='GMT 2->ICP2,ICP1'||$JOBONE=='GMT 2->ICP2,NTS'||$JOBONE=='GMT 2->ICP2,GJ'||$JOBONE=='GMT 2->ICP2,KIRIU'||
                                         $JOBONE=='GMT 2->NTS,ICP1' ||$JOBONE=='GMT 2->NTS,ICP2'||$JOBONE=='GMT 2->NTS,GJ' ||$JOBONE=='GMT 2->NTS,KIRIU' ||
                                         $JOBONE=='GMT 2->GJ,ICP1'  ||$JOBONE=='GMT 2->GJ,ICP2' ||$JOBONE=='GMT 2->GJ,NTS' ||$JOBONE=='GMT 2->GJ,KIRIU'  ||
                                         $JOBONE=='GMT 2->ICP1'     ||$JOBONE=='GMT 2->ICP2'    ||$JOBONE=='GMT 2->NTS'    ||$JOBONE=='GMT 2->GJ'        ||
                                         $JOBONE=='GMT 2->KIRIU'    ||$JOBONE=='GMT 2->KIRIU กรณีตีเปล่า'  ||$JOBONE=='GMT 2->TSMT สระบุรี'  ||$JOBONE=='GMT 2->KIRIU กรณีตีเปล่า'){
                                        // }else if($JOBONE=='GMT 2->ICP1'||$JOBONE=='GMT 2->ICP2'||$JOBONE=='GMT 2->NTS'||$JOBONE=='GMT 2->GJ'||$JOBONE=='GMT 2->KIRIU'||
                                        //          $JOBTWO=='GMT 2->ICP1'||$JOBTWO=='GMT 2->ICP2'||$JOBTWO=='GMT 2->NTS'||$JOBTWO=='GMT 2->GJ'||$JOBTWO=='GMT 2->KIRIU'){
                                    $MONEYTOTAL='0';   
                                    $REMARK='ไม่คิดเรทน้ำมัน';
                                }else if(($JOBONE=='TTAST->STT')||($JOBONE=='TTAST->NB WOOD')||($JOBONE=='TTAST->CH')){
                                    $MONEYTOTAL='0';   
                                    $REMARK='ไม่คิดเรทน้ำมัน';
                                }else if($CTMC=='GMT-IB' && ($VHCTPLAN=='10W(กระบะสไลด์) (1 Trips/Trailer/Day)'||$VHCTPLAN=='10W(กระบะสไลด์) (2 Trips/Trailer/Day(GMT2))'||$VHCTPLAN=='10W(กระบะสไลด์) (2 Trips/Trailer/Day)'||$VHCTPLAN=='10W(กระบะสไลด์) (3 Trips/Trailer/Day(GMT2))'||$VHCTPLAN=='10W(กระบะสไลด์) (3 Trips/Trailer/Day)')){
                                    $MONEYTOTAL='0';  
                                    $REMARK='ไม่คิดเรทน้ำมัน';          
                                }else if(($CTMC=='TTAST') && ($VHCTPLAN=='Semitrailer')){
                                    $MONEYTOTAL='0';
                                    $REMARK='ไม่คิดเรทน้ำมัน';
                                }else if(($CTMC=='TTAST') && ($VHCTPLAN=='10W (Van)') && ($JOBONE=='TTAST->G-TEC (Zanzai)')){
                                    $MONEYTOTAL='0';
                                    $REMARK='ไม่คิดเรทน้ำมัน';
                                }else if(($JOBONE=='TTAST->G-TEC (Zanzai)')){
                                    $MONEYTOTAL='0';
                                    $REMARK='ไม่คิดเรทน้ำมัน';
                                }else if($VHCTHAINAME=='R-401'||$VHCTHAINAME=='R-801'||$VHCTHAINAME=='R-802'){
                                    $MONEYTOTAL='0';
                                    $REMARK='ไม่คิดเรทน้ำมัน';
                                }else if(($JOBONE=='โลหะกิจ->GMT 2')){
                                    $MONEYTOTAL='0';
                                    $REMARK='ไม่คิดเรทน้ำมัน';
                                }else{
                                    //$MONEYTOTAL='=S'.$i.'*T'.$i;
                                    // $MONEYTOTAL=$C3;
                                    $MONEYTOTAL=$CALPRICE;  
                                    $REMARK='';
                                }
                            }else{
                                //$MONEYTOTAL='=S'.$i.'*T'.$i;
                                // $MONEYTOTAL=$C3;
                                $MONEYTOTAL=$CALPRICE;  
                                $REMARK='';
                            } 
                        // echo 'ประเภทรถ: '.$VHCTPLAN.' งานที่ 1: '.$JOBONE.' รอบที่วิ่ง: '.$ROUNDAMOUNT;
                        // echo ' งานที่ 2: '.$JOBTWO.' รอบที่วิ่ง: '.$ROUNDAMOUNT.' จำนวนรอบวันนั้น: '.$ROUND.' ยอดเงินตามสูตรคำนวน: '.$MONEYTOTAL.'<br>'; 
                        
                        $objPHPExcel->getActiveSheet()->setCellValue('X' . $i, $MONEYTOTAL);
                        // $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, '=S'.$i.'*T'.$i);                         
                        $objPHPExcel->getActiveSheet()->setCellValue('Y' . $i, ' '.$REMARK.' '.$REMARKOILLEFT);
                        $sheet->getStyle('O'.$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));//เหลือง
                        $sheet->getStyle('S'.$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));//เหลือง
                        $sheet->getStyle('U'.$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));//เหลือง
                        $sheet->getStyle('X'.$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));//เหลือง
                        $NO++;
                        $numpage++; $i++;
                    }               
                    
                    $objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':N'.$i);
                    $objPHPExcel->getActiveSheet()->mergeCells('P'.$i.':R'.$i);
                    $objPHPExcel->getActiveSheet()->mergeCells('V'.$i.':W'.$i);
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, 'รวม');
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold( true );
                    
                    $sheet->getStyle('O'.$i.':P'.$i)->getNumberFormat()->setFormatCode('0.00');
                    $objPHPExcel->getActiveSheet()->setCellValue('O'.$i, '=SUM(O10:O'.($i -1).')');
                    // $objPHPExcel->getActiveSheet()->setCellValue('P'.$i, '=SUM(P10:P'.($i -1).')');
                    // $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, '=SUM(Q10:Q'.($i -1).')');
                    // $objPHPExcel->getActiveSheet()->setCellValue('R'.$i, '=SUM(R10:R'.($i -1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('S'.$i, '=SUM(S10:S'.($i -1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('U'.$i, '=O'.$i.'/S'.$i);
                    // $objPHPExcel->getActiveSheet()->setCellValue('V'.$i, '=SUM(V10:V'.($i -1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('X'.$i, '=SUM(X10:X'.($i -1).')');

                    $sheet->getStyle('O10:S'.$i)->getNumberFormat()->setFormatCode('0.00'); 
                    $sheet->getStyle('U10:V'.$i)->getNumberFormat()->setFormatCode('0.00'); 
                    $sheet->getStyle('X10:X'.$i)->getNumberFormat()->setFormatCode('0.00'); 
                    $sheet->getStyle('A10:Y'.$i)->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                    $objPHPExcel->getActiveSheet()->getStyle('A10:B'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('C10:E'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('F10:I'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('J10:K'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('L10:L'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('M10:U'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('W10:W'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('X10:X'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    // $objPHPExcel->getActiveSheet()->getStyle('Y10:Y'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    
                    $sheet->getStyle('A'.$i.':Y'.$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                // CLOSE SECTION 
            $objPHPExcel->getActiveSheet()->setTitle($chkday);

    // END-------------------------------------------------------------------------------------------------------------------------------------------------
            // $objPHPExcel->setActiveSheetIndex(0);
            $work_sheet++;
    }
    $RENAME= "สรุปโครงการใช้น้ำมันรายบุคคลประจำเดือน $selectmonth $start_yth";
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=$RENAME.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
            


}else{
    echo "<h1>ไม่มีข้อมูล</h1>";
} 
sqlsrv_close($conn);
?>