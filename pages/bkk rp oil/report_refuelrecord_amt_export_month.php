<?php
    // echo"<pre>";
    // print_r($_POST);
    // echo"</pre>";
    // exit();
    $EXCELMONTH=$_POST['EXCELMONTH'];
    $EXCELCOVER=$_POST['EXCELCOVER'];
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
    $customer=$_POST['selcustomer2'];

    // $sql_chkcompany = "SELECT CPEHR.Company_NameT,CPEHR.Company_NameE,CPEHR.Company_Code,CPEHR.Company_Add,DISTRICT_NAME_TH,AP.AMPHUR_NAME_TH,PV.PROVINCE_NAME_TH,CPEHR.Company_PostalCode
    //     FROM COMPANYEHR CPEHR
    //     LEFT JOIN DISTRICTS DT ON CAST (Company_District AS INT) = DT.DISTRICT_ID
    //     LEFT JOIN AMPHURES AP ON CAST (Company_Amphur AS INT) = AP.AMPHUR_ID
    //     LEFT JOIN PROVINCES PV ON CAST (Company_Province AS INT) = PV.PROVINCE_ID
    //     WHERE CPEHR.Company_Code = '$selcompany2'";
    //     $query_chkcompany = sqlsrv_query($conn, $sql_chkcompany);
    //     $result_chkcompany = sqlsrv_fetch_array($query_chkcompany, SQLSRV_FETCH_ASSOC);
        
        // $recomth='บริษัท '.$result_chkcompany["Company_NameT"].' จำกัด';
        // $recomen=$result_chkcompany["Company_NameE"].' CO., LTD';
        // $recomadd=$result_chkcompany["Company_Add"].' ต.'.$result_chkcompany["DISTRICT_NAME_TH"].' อ.'.$result_chkcompany["AMPHUR_NAME_TH"].' จ.'.$result_chkcompany["PROVINCE_NAME_TH"].' '.$result_chkcompany["Company_PostalCode"];
        
        $recomth='บริษัท ร่วมกิจรุ่งเรือง (อมตะซิตี้)';
        $recomen='RUAMKIT RUNG RUENG (AMATA CITY)';
        $recomadd='51 ม.4 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี 20160';
    
if ($EXCELMONTH != "") { 
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
                    if($customer == 'CS'){
                        $selcustomer2='CS';
                    }else if($customer == 'SCCL'){
                        $selcustomer2='STC TL';
                    }else if($customer == 'KBT'){
                        $selcustomer2='KUBOTA';
                    }else if($customer == 'SMIP'){
                        $selcustomer2='STM - IP';
                    }else if($customer == 'TTKN'){
                        $selcustomer2='T.TOHKEN';
                    }else if($customer == 'SC10'){
                        $selcustomer2='STC 10 W';
                    }else if($customer == 'TTDK'){
                        $selcustomer2='TGT/DAIKI';
                    }else if($customer == 'SRTW'){
                        $selcustomer2='STM - TMT SR / TAW';
                    }
                    $companyth=$recomth;
                    $companyen=$recomen;
                    $address=$recomadd;
                    $detail="สรุปโครงการใช้น้ำมันรายบุคคลประจำเดือน $selectmonth $start_yth";
                    $customer="สายงาน $selcustomer2";

                    if(($selcustomer2 == 'CS') || ($selcustomer2 == 'T.TOHKEN') || ($selcustomer2 == 'STM - IP')){
                        $objDrawing = new PHPExcel_Worksheet_Drawing();$objDrawing->setName('Image');$objDrawing->setDescription('Image');$objDrawing->setPath('../images/logonew.png');$objDrawing->setWidthAndHeight(100,70);$objDrawing->setCoordinates('H1');$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
                        $objPHPExcel->getActiveSheet()->mergeCells('A1:S1');
                        $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(0, 2, $companyth);$sheet->mergeCells('A2:S2');$objPHPExcel->getActiveSheet()->getStyle('A2:S2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(0, 3, $companyen);$sheet->mergeCells('A3:S3');$objPHPExcel->getActiveSheet()->getStyle('A3:S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(0, 4, $address);$sheet->mergeCells('A4:S4');$objPHPExcel->getActiveSheet()->getStyle('A4:S4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(0, 5, $detail);$sheet->mergeCells('A5:S5');$objPHPExcel->getActiveSheet()->getStyle('A5:S5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(0, 6, $customer);$sheet->mergeCells('A6:S6');$objPHPExcel->getActiveSheet()->getStyle('A6:S6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    }else if(($selcustomer2 == 'KUBOTA') || ($selcustomer2 == 'TGT/DAIKI') || ($selcustomer2 == 'STM - TMT SR / TAW') || ($selcustomer2 == 'STC 10 W') || ($selcustomer2 == 'STC TL')){
                        $objDrawing = new PHPExcel_Worksheet_Drawing();$objDrawing->setName('Image');$objDrawing->setDescription('Image');$objDrawing->setPath('../images/logonew.png');$objDrawing->setWidthAndHeight(100,70);$objDrawing->setCoordinates('N1');$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
                        $objPHPExcel->getActiveSheet()->mergeCells('A1:AE1');
                        $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(0, 2, $companyth);$sheet->mergeCells('A2:AE2');$objPHPExcel->getActiveSheet()->getStyle('A2:AE2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(0, 3, $companyen);$sheet->mergeCells('A3:AE3');$objPHPExcel->getActiveSheet()->getStyle('A3:AE3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(0, 4, $address);$sheet->mergeCells('A4:AE4');$objPHPExcel->getActiveSheet()->getStyle('A4:AE4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(0, 5, $detail);$sheet->mergeCells('A5:AE5');$objPHPExcel->getActiveSheet()->getStyle('A5:AE5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(0, 6, $customer);$sheet->mergeCells('A6:AE6');$objPHPExcel->getActiveSheet()->getStyle('A6:AE6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    }

                    $objDrawing = new PHPExcel_Worksheet_HeaderFooterDrawing();
                    $objPHPExcel->getActiveSheet()->getHeaderFooter()->addImage($objDrawing, PHPExcel_Worksheet_HeaderFooter::IMAGE_HEADER_LEFT);

                    $styleText = array('font'  => array('bold'  => false,'color' => array('rgb' => '000000'),'size'  => 10,'name'  => 'Verdana'));     
                    $sheet->getDefaultStyle()->applyFromArray($styleText);
                
                    $objPHPExcel->getActiveSheet()->setCellValue('A7', 'ลำดับ')->setCellValue('B7', 'รหัส')->setCellValue('C7', 'ชื่อ')->setCellValue('D7', 'สกุล')->setCellValue('E7', 'จำนวน')->setCellValue('E8', 'เที่ยวที่')->setCellValue('E9', 'วิ่งงาน')->setCellValue('F7', 'ทะเบียนรถ')->setCellValue('G7', 'ประเภทรถ')->setCellValue('H7', 'งานที่ขนส่ง')->setCellValue('I8', 'ไมล์ต้น')->setCellValue('J8', 'ไมล์ปลาย')->setCellValue('K8', 'ระยะทาง')->setCellValue('L8', 'น้ำมันที่เติม')->setCellValue('M8', 'ค่าเฉลี่ยที่')->setCellValue('M9', 'กำหนด')->setCellValue('N8', 'ค่าเฉลี่ยที่ได้')->setCellValue('O8', 'จำนวนน้ำมันที่')->setCellValue('O9', 'เกินกว่ากำหนด')->setCellValue('P8', 'จำนวนบาท/')->setCellValue('P9', 'ลิตร')->setCellValue('Q8', 'จำนวนเงินที่ได้')->setCellValue('Q9', 'บาท');                 
                    
                    $objPHPExcel->getActiveSheet()->mergeCells('A7:A9');$objPHPExcel->getActiveSheet()->mergeCells('B7:B9');$objPHPExcel->getActiveSheet()->mergeCells('C7:C9');$objPHPExcel->getActiveSheet()->mergeCells('D7:D9');$objPHPExcel->getActiveSheet()->mergeCells('F7:F9');$objPHPExcel->getActiveSheet()->mergeCells('G7:G9');$objPHPExcel->getActiveSheet()->mergeCells('H7:H9');$objPHPExcel->getActiveSheet()->mergeCells('I7:Q7');$objPHPExcel->getActiveSheet()->mergeCells('I8:I9');$objPHPExcel->getActiveSheet()->mergeCells('J8:J9');$objPHPExcel->getActiveSheet()->mergeCells('K8:K9');$objPHPExcel->getActiveSheet()->mergeCells('L8:L9');$objPHPExcel->getActiveSheet()->mergeCells('N8:N9');   
                    
                    $sheet->getStyle('A7:D9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));$sheet->getStyle('E7:E9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));$sheet->getStyle('E7:E9')->applyFromArray(array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));$sheet->getStyle('E7:E9')->applyFromArray(array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));$sheet->getStyle('F7:G9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));$sheet->getStyle('H7:H9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));$sheet->getStyle('I7:Q7')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));$sheet->getStyle('I8:L9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));$sheet->getStyle('M8:M9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));$sheet->getStyle('N8:N9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));$sheet->getStyle('O8:O9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));$sheet->getStyle('P8:P9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));$sheet->getStyle('Q8:Q9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));$sheet->getStyle('Q8:Q9')->applyFromArray(array('borders' => array('left' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));$sheet->getStyle('I9:Q9')->applyFromArray(array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                    
                    $sheet->getStyle('A7:E9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFD700'))));$sheet->getStyle('F7:Q9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '9ACD32'))));$objPHPExcel->getActiveSheet()->getStyle('A7:AE9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    // foreach(range('A','Z') as $columnID) { $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);} 
                    $sheet->getColumnDimension('A')->setWidth(5);$sheet->getColumnDimension('B')->setWidth(8);$sheet->getColumnDimension('C')->setWidth(12);$sheet->getColumnDimension('D')->setWidth(12);$sheet->getColumnDimension('E')->setWidth(6);$sheet->getColumnDimension('F')->setWidth(10);$sheet->getColumnDimension('G')->setWidth(15);$sheet->getColumnDimension('H')->setWidth(20);$sheet->getColumnDimension('I')->setWidth(12);$sheet->getColumnDimension('J')->setWidth(12);$sheet->getColumnDimension('K')->setWidth(12);$sheet->getColumnDimension('L')->setWidth(12);$sheet->getColumnDimension('M')->setWidth(8);$sheet->getColumnDimension('N')->setWidth(12);$sheet->getColumnDimension('O')->setWidth(12);$sheet->getColumnDimension('P')->setWidth(12);$sheet->getColumnDimension('Q')->setWidth(12);                      

                    if(($selcustomer2 == 'CS') || ($selcustomer2 == 'T.TOHKEN') || ($selcustomer2 == 'STM - IP')){
                        if($selcustomer2 == 'CS'){
                            $objPHPExcel->getActiveSheet()->setCellValue('I7', '10 W / OTHER');
                            $QUERYWHERE1="EHR.PositionNameT LIKE '%CS%'";
                            $QUERYWHERE2="VHCTPP.CUSTOMERCODE IN('TTASTCS','TTTCSTC') AND NOT (EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเขียว' OR EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเหลือง') AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' ORDER BY EHR.PositionNameT ASC";
                            $QUERYIFELSE1="OTSN.OIL_BILLNUMBER IS NOT NULL AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday'";
                        }else if($selcustomer2 == 'T.TOHKEN'){
                            $objPHPExcel->getActiveSheet()->setCellValue('I7', '10 W / T.TOHKEN');
                            $QUERYWHERE1="EHR.PositionNameT LIKE '%T-Tohken%'";
                            $QUERYWHERE2="VHCTPP.CUSTOMERCODE = 'THAITOHKEN' AND NOT (EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเขียว' OR EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเหลือง') AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' ORDER BY EHR.PositionNameT DESC";
                            $QUERYIFELSE1="OTSN.OIL_BILLNUMBER IS NOT NULL AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday'";
                        }else if($selcustomer2 == 'STM - IP'){
                            $objPHPExcel->getActiveSheet()->setCellValue('I7', 'IP');
                            $QUERYWHERE1="EHR.PositionNameT LIKE '%STM-IP%'";
                            $QUERYWHERE2="VHCTPP.CUSTOMERCODE = 'STM' AND NOT (EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเขียว' OR EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเหลือง') AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' ORDER BY EHR.PositionNameT ASC";
                            $QUERYIFELSE1="OTSN.OIL_BILLNUMBER IS NOT NULL AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday'";
                        }                        
                        $objPHPExcel->getActiveSheet()->setCellValue('R7', 'รวมน้ำมัน')->setCellValue('S7', 'รวมเงิน');  
                        $objPHPExcel->getActiveSheet()->mergeCells('R7:R9');
                        $objPHPExcel->getActiveSheet()->mergeCells('S7:S9');    
                        $sheet->getStyle('R7:S9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('R7:S9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FF8C00'))));
                        $sheet->getColumnDimension('R')->setWidth(12);
                        $sheet->getColumnDimension('S')->setWidth(12);

                    }else if(($selcustomer2 == 'KUBOTA') || ($selcustomer2 == 'TGT/DAIKI') || ($selcustomer2 == 'STM - TMT SR / TAW') || ($selcustomer2 == 'STC 10 W') || ($selcustomer2 == 'STC TL')){
                        if($selcustomer2 == 'KUBOTA'){
                            $objPHPExcel->getActiveSheet()->setCellValue('I7', 'TL OTHER 2')->setCellValue('U7', 'TL OTHER FB');
                            $QUERYWHERE1="EHR.PositionNameT LIKE '%KUBOTA%'";
                            $QUERYWHERE2="VHCTPP.CUSTOMERCODE = 'SKB' AND NOT (EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเขียว' OR EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเหลือง') AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' ORDER BY EHR.PositionNameT ASC";
                            $QUERYIFELSE1="OTSN.OIL_BILLNUMBER IS NOT NULL AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' AND VHCTPP.VEHICLETYPE IN ('ADC-Dealer(SL2)','ADC-Dealer(FB)')";
                            $QUERYIFELSE2="OTSN.OIL_BILLNUMBER IS NOT NULL AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' AND VHCTPP.VEHICLETYPE IN ('ADC-Dealer(SL2)','ADC-Dealer(FB)')";
                        }else if($selcustomer2 == 'TGT/DAIKI'){
                            $objPHPExcel->getActiveSheet()->setCellValue('I7', 'OTHER')->setCellValue('U7', 'Long Route');
                            $QUERYWHERE1="EHR.PositionNameT LIKE '%TGT%'";
                            $QUERYWHERE2="VHCTPP.CUSTOMERCODE IN('TGT','DAIKI') AND NOT VHCTPP.COMPANYCODE = 'RKR' AND NOT (EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเขียว' OR EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเหลือง') AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' ORDER BY EHR.PositionNameT DESC";
                            $QUERYIFELSE1="OTSN.OIL_BILLNUMBER IS NOT NULL AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' AND VHCTPP.CUSTOMERCODE IN ('TGT','GMT')";
                            $QUERYIFELSE2="OTSN.OIL_BILLNUMBER IS NOT NULL AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' AND VHCTPP.CUSTOMERCODE = 'DAIKI'";
                        }else if($selcustomer2 == 'STM - TMT SR / TAW'){
                            $objPHPExcel->getActiveSheet()->setCellValue('I7', '10 W / เครื่องยนต์ (TMT/SR)')->setCellValue('U7', '6 W TAW / TMT SR');
                            $QUERYWHERE1="EHR.PositionNameT LIKE '%STM-SR%'";
                            $QUERYWHERE2="VHCTPP.CUSTOMERCODE IN ('TMT','TAW') AND NOT (EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเขียว' OR EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเหลือง') AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' ORDER BY EHR.PositionNameT DESC";
                            $QUERYIFELSE1="OTSN.OIL_BILLNUMBER IS NOT NULL AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' AND VHCTPP.VEHICLETYPE = '10W'";
                            $QUERYIFELSE2="OTSN.OIL_BILLNUMBER IS NOT NULL AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' AND VHCTPP.VEHICLETYPE = '6W'";
                        }else if($selcustomer2 == 'STC 10 W'){
                            $objPHPExcel->getActiveSheet()->setCellValue('I7', '10 W / WELLGROW-OTHER')->setCellValue('U7', '10 W / AMATA');
                            $QUERYWHERE1="EHR.PositionNameT LIKE '%พนักงานขับรถ%' AND EHR.Company_Code = 'RKR' AND NOT EHR.PositionNameT IN ('พนักงานขับรถ/CS','พนักงานขับรถ/RKL-STC') AND NOT EHR.PositionNameT LIKE '%KUBOTA%'";
                            $QUERYWHERE2="VHCTPP.CUSTOMERCODE IN('TTASTSTC','GMT') AND NOT EHR.Company_Code IN ('RCC','RRC','RATC') AND NOT VHCTPP.COMPANYCODE IN('RKL') AND NOT (EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเขียว' OR EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเหลือง' OR EHR.PositionNameT LIKE '%RKL-STC%')  AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' ORDER BY EHR.PositionNameT DESC";
                            $QUERYIFELSE1="OTSN.OIL_BILLNUMBER IS NOT NULL AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' AND VHCTPP.VEHICLETYPE LIKE '10W%' AND NOT VHCTPP.VEHICLETYPE LIKE '%10W(AMT)%'";
                            $QUERYIFELSE2="OTSN.OIL_BILLNUMBER IS NOT NULL AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' AND VHCTPP.VEHICLETYPE = '10W(AMT)'";
                        }else if($selcustomer2 == 'STC TL'){
                            $objPHPExcel->getActiveSheet()->setCellValue('I7', 'TL OTHER')->setCellValue('U7', 'TL AMATA');
                            $QUERYWHERE1="EHR.PositionNameT LIKE '%พนักงานขับรถ/RKL-STC%' AND EHR.Company_Code = 'RKL' ";
                            // $QUERYWHERE2="NOT VHCTPP.CUSTOMERCODE = 'SKB' AND NOT EHR.Company_Code IN('RKR','RCC','RATC','RRC')  AND NOT (EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเขียว' OR EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเหลือง')  AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' ORDER BY EHR.PositionNameT DESC";
                            $QUERYWHERE2="VHCTPP.CUSTOMERCODE IN('TTASTSTC','CH-AUTO','GMT','TTAT') AND VHCTPP.VEHICLETYPE LIKE '%Trailer%' AND NOT EHR.Company_Code IN ('RKR','RCC','RRC','RATC') AND NOT (EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเขียว' OR EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเหลือง')  AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' ORDER BY EHR.PositionNameT DESC";
                            $QUERYIFELSE1="OTSN.OIL_BILLNUMBER IS NOT NULL AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' AND NOT VHCTPP.VEHICLETYPE LIKE '%Trailer(AMT)%'";
                            $QUERYIFELSE2="OTSN.OIL_BILLNUMBER IS NOT NULL AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' AND VHCTPP.VEHICLETYPE = 'Trailer(AMT)'";
                        }
                        $objPHPExcel->getActiveSheet()->mergeCells('R7:R9');$objPHPExcel->getActiveSheet()->mergeCells('S7:S9');$objPHPExcel->getActiveSheet()->mergeCells('T7:T9');$objPHPExcel->getActiveSheet()->mergeCells('U7:AC7');$objPHPExcel->getActiveSheet()->mergeCells('U8:U9');$objPHPExcel->getActiveSheet()->mergeCells('V8:V9');$objPHPExcel->getActiveSheet()->mergeCells('W8:W9');$objPHPExcel->getActiveSheet()->mergeCells('X8:X9');$objPHPExcel->getActiveSheet()->mergeCells('Z8:Z9');$objPHPExcel->getActiveSheet()->mergeCells('AD7:AD9');$objPHPExcel->getActiveSheet()->mergeCells('AE7:AE9');  
                        $objPHPExcel->getActiveSheet()->setCellValue('R7', 'ทะเบียนรถ')->setCellValue('S7', 'ประเภทรถ')->setCellValue('T7', 'งานที่ขนส่ง')->setCellValue('U8', 'ไมล์ต้น')->setCellValue('V8', 'ไมล์ปลาย')->setCellValue('W8', 'ระยะทาง')->setCellValue('X8', 'น้ำมันที่เติม')->setCellValue('Y8', 'ค่าเฉลี่ยที่')->setCellValue('Y9', 'กำหนด')->setCellValue('Z8', 'ค่าเฉลี่ยที่ได้')->setCellValue('AA8', 'จำนวนน้ำมันที่')->setCellValue('AA9', 'เกินกว่ากำหนด')->setCellValue('AB8', 'จำนวนบาท/')->setCellValue('AB9', 'ลิตร')->setCellValue('AC8', 'จำนวนเงินที่ได้')->setCellValue('AC9', 'บาท')->setCellValue('AD7', 'รวมน้ำมัน')->setCellValue('AE7', 'รวมเงิน');                 
                        $sheet->getColumnDimension('R')->setWidth(10);$sheet->getColumnDimension('S')->setWidth(15);$sheet->getColumnDimension('T')->setWidth(20);$sheet->getColumnDimension('U')->setWidth(12);$sheet->getColumnDimension('V')->setWidth(12);$sheet->getColumnDimension('W')->setWidth(12);$sheet->getColumnDimension('X')->setWidth(12);$sheet->getColumnDimension('Y')->setWidth(8);$sheet->getColumnDimension('Z')->setWidth(12);$sheet->getColumnDimension('AA')->setWidth(12);$sheet->getColumnDimension('AB')->setWidth(12);$sheet->getColumnDimension('AC')->setWidth(12);$sheet->getColumnDimension('AD')->setWidth(12);$sheet->getColumnDimension('AE')->setWidth(12);
                        $sheet->getStyle('R7:AC9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '8FBC8F'))));$sheet->getStyle('AD7:AE9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FF8C00'))));$sheet->getStyle('R7:T9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));$sheet->getStyle('AD7:AE9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));$sheet->getStyle('U7:AC7')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));$sheet->getStyle('U8:X9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));$sheet->getStyle('X8:X9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));$sheet->getStyle('Z8:Z9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));$sheet->getStyle('AA8:AA9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));$sheet->getStyle('AB8:AB9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                    }

                    $SQLEMP_CENTER = "SELECT DISTINCT EHR.PersonCode EMPC,EHR.Company_Code,EHR.Company_NameT,EHR.PositionNameT,EHR.FnameT,EHR.LnameT,EHR.nameT EMPN
                        FROM EMPLOYEEEHR2 EHR WHERE $QUERYWHERE1
                        UNION
                        SELECT DISTINCT EHR.PersonCode EMPC,EHR.Company_Code,EHR.Company_NameT,EHR.PositionNameT,EHR.FnameT,EHR.LnameT,EHR.nameT EMPN
                        FROM EMPLOYEEEHR2 EHR
                        LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON (VHCTPP.EMPLOYEECODE1 = EHR.PersonCode OR VHCTPP.EMPLOYEECODE2 = EHR.PersonCode)
                        WHERE $QUERYWHERE2";
                        $QUERYEMP_CENTER = sqlsrv_query($conn, $SQLEMP_CENTER );     
                        $i = "10";
                        $numpage = "1";
                        while($RSEMP_CENTER = sqlsrv_fetch_array($QUERYEMP_CENTER)) {      
                                $pieces = explode(" ", $RSEMP_CENTER["EMPN"]);
                                $fname=$pieces[0];
                                $lname=$pieces[1];
                                $EMPC=$RSEMP_CENTER["EMPC"];   
                                        
                            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $numpage);
                            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $EMPC);
                            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $fname);
                            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $lname);        
                        
                        if($selcustomer2 != 'KUBOTA'){
                            // (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID) + OIL_AMOUNT AS OAM
                            $SQLPLAN_LEFT="SELECT DISTINCT TOP 1 PositionNameT PSTN,VHCTPP.COMPANYCODE COM,VHCTPP.CUSTOMERCODE CUS,OTSN.OILDATAID OILID,VHCTPP.EMPLOYEECODE1 EMPC1,VHCTPP.EMPLOYEENAME1 EMPN1,VHCTPP.EMPLOYEECODE2 EMPC2,VHCTPP.EMPLOYEENAME2 EMPN2,CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) DW,CONVERT (VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,OTSN.OIL_BILLNUMBER OBLNB,OTSN.VEHICLEREGISNUMBER VHCRGNB,OTSN.VEHICLETYPE CARTYPE,VHCTPP.VEHICLETYPE VHCTPLAN,VHCTPP.JOBSTART JOBSTART,VHCTPP.JOBEND JOBEND,OTSN.MILEAGESTART MST,OTSN.MILEAGEEND MLE,OTSN.DISTANCE DTE,OTSN.OIL_AMOUNT,OTSN.OIL_AVERAGE OAVG,OTSN.OIL_TARGET OTG,VHCTPP.C3 AVG,VHCTPP.E1 MONEY,OTSN.JOBNO,VHCTPP.JOBNO,(SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID) AS OAM
                                FROM EMPLOYEEEHR2 EHR
                                LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON (VHCTPP.EMPLOYEECODE1 = EHR.PersonCode OR VHCTPP.EMPLOYEECODE2 = EHR.PersonCode)
                                LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                                WHERE (VHCTPP.EMPLOYEECODE1 = '$EMPC' OR VHCTPP.EMPLOYEECODE2 = '$EMPC') AND $QUERYIFELSE1";
                                $QUERYPLAN_LEFT = sqlsrv_query($conn, $SQLPLAN_LEFT );
                                while($RSPLAN_LEFT = sqlsrv_fetch_array($QUERYPLAN_LEFT)) {                                 
                                    $COM_LEFT=$RSPLAN_LEFT["COM"];
                                    $CUS_LEFT=$RSPLAN_LEFT["CUS"];
                                    $VHCRGNB_LEFT=$RSPLAN_LEFT["VHCRGNB"];
                                    $VHCTPLAN_LEFT=$RSPLAN_LEFT["VHCTPLAN"];
                                    $JOBSTART_LEFT=$RSPLAN_LEFT["JOBSTART"];
                                    $JOBEND_LEFT=$RSPLAN_LEFT["JOBEND"];
                                    if($JOBEND_LEFT!=""){
                                        $RSJOB_LEFT=$JOBEND_LEFT;
                                    }else{
                                        $RSJOB_LEFT=$JOBSTART_LEFT;
                                    }
                                    $MST_LEFT=$RSPLAN_LEFT["MST"];
                                    $MLE_LEFT=$RSPLAN_LEFT["MLE"];
                                    $DTE_LEFT=$RSPLAN_LEFT["DTE"];
                                    
                                    $OILAMOUNTLEFT=$RSPLAN_LEFT["OIL_AMOUNT"];
                                    $OAMLEFT=$RSPLAN_LEFT["OAM"];
                                    $OAM_LEFT=$OILAMOUNTLEFT+$OAMLEFT;

                                    $OTG_LEFT=$RSPLAN_LEFT["OTG"];
                                    $OAVG_LEFT=$RSPLAN_LEFT["OAVG"];                                  
                                    $EMPC1_LEFT=$RSPLAN_LEFT["EMPC1"];
                                    $EMPC2_LEFT=$RSPLAN_LEFT["EMPC2"];                                
        
                                    $SQLPRICE_LEFT = "SELECT OLP.PRICE,OLP.COMPANYCODE,OLP.[MONTH],OLP.[YEAR] FROM OILPEICE OLP WHERE OLP.COMPANYCODE = '$COM_LEFT' AND OLP.[YEAR] = '$start_yen' AND OLP.[MONTH] = '$selectmonth'";
                                    $QUERYPRICE_LEFT = sqlsrv_query($conn, $SQLPRICE_LEFT);
                                    $RSPRICE_LEFT = sqlsrv_fetch_array($QUERYPRICE_LEFT, SQLSRV_FETCH_ASSOC);   
                                        $PRICE_LEFT=$RSPRICE_LEFT["PRICE"];

                                    $SQLROUND_LEFT="SELECT COUNT(VHCTPP.EMPLOYEECODE1) AS ROUND FROM VEHICLETRANSPORTPLAN VHCTPP WHERE VHCTPP.COMPANYCODE = '$COM_LEFT' AND (VHCTPP.EMPLOYEECODE1 = '$EMPC' OR VHCTPP.EMPLOYEECODE2 = '$EMPC') AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' GROUP BY VHCTPP.EMPLOYEECODE1 ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                        $QUERYROUND_LEFT = sqlsrv_query($conn, $SQLROUND_LEFT ); while($RSROUND_LEFT = sqlsrv_fetch_array($QUERYROUND_LEFT)) { $ROUND=$RSROUND_LEFT["ROUND"];   
                                            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $ROUND);
                                        }
                                
                                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $VHCRGNB_LEFT);
                                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $VHCTPLAN_LEFT);

                                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $RSJOB_LEFT);
                                    $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $MST_LEFT);
                                    $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $MLE_LEFT);
                                    $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, '=J'.$i.'-I'.$i);
                                    $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $OAM_LEFT);                                           
                                    $SQLOAVG_LEFT="SELECT DISTINCT OILAVERAGE.OILAVERAGE OAVR FROM OILAVERAGE WHERE OILAVERAGE.COMPANYCODE = '$COM_LEFT' AND OILAVERAGE.CUSTOMERCODE = '$CUS_LEFT' AND OILAVERAGE.VEHICLETYPE = '$VHCTPLAN_LEFT'";
                                        $QUERYOAVG_LEFT = sqlsrv_query($conn, $SQLOAVG_LEFT ); while($RSOAVG_LEFT = sqlsrv_fetch_array($QUERYOAVG_LEFT)) {                                         
                                            if ($VHCRGNB_LEFT =='61-4454'||$VHCRGNB_LEFT =='61-4456'||$VHCRGNB_LEFT =='61-3440'||$VHCRGNB_LEFT =='61-3441'||$VHCRGNB_LEFT =='61-4453'||$VHCRGNB_LEFT =='61-4457'||$VHCRGNB_LEFT =='61-4912'||$VHCRGNB_LEFT =='61-4913'||$VHCRGNB_LEFT =='61-4546'||$VHCRGNB_LEFT =='61-4547'||$VHCRGNB_LEFT =='64-3452'||$VHCRGNB_LEFT =='61-3445'||$VHCRGNB_LEFT =='61-3439'||$VHCRGNB_LEFT =='61-3443'||$VHCRGNB_LEFT =='61-3834'||$VHCRGNB_LEFT =='61-3835'||$VHCRGNB_LEFT =='61-3438'||$VHCRGNB_LEFT =='61-3437'||$VHCRGNB_LEFT =='62-9288'||$VHCRGNB_LEFT =='61-3836'||$VHCRGNB_LEFT =='61-4458'||$VHCRGNB_LEFT =='61-3444'||$VHCRGNB_LEFT =='60-3868'||$VHCRGNB_LEFT =='60-3870'||$VHCRGNB_LEFT =='61-3437'||$VHCRGNB_LEFT =='61-3452') {
                                                $OAVR_LEFT = 4.0;    
                                            }else if($VHCRGNB_LEFT =='60-3871'||$VHCRGNB_LEFT =='61-3442'||$VHCRGNB_LEFT =='60-2391'||$VHCRGNB_LEFT =='61-3444'||$VHCRGNB_LEFT =='76-8919'||$VHCRGNB_LEFT =='61-4458'||$VHCRGNB_LEFT =='79-2521'||$VHCRGNB_LEFT =='79-2522'||$VHCRGNB_LEFT =='79-2525'||$VHCRGNB_LEFT =='74-5653'||$VHCRGNB_LEFT =='74-5684'||$VHCRGNB_LEFT =='74-5684'||$VHCRGNB_LEFT =='74-5654') {
                                                $OAVR_LEFT = 3.5;  
                                            }else{
                                                $OAVR_LEFT=$RSOAVG_LEFT["OAVR"]; 
                                            }

                                            $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $OAVR_LEFT);
                                        }
                                           
                                    // $KCOLUMN=$DTE_LEFT / $OAM_LEFT ;
                                    // $OCOLUMN=($DTE_LEFT / $OAVR_LEFT) - $OAM_LEFT ;
                                    // $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $KCOLUMN);
                                    // $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, round($OCOLUMN)); 
                                    $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, '=K'.$i.'/L'.$i);
                                    // $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, '=ROUND(((K'.$i.'/M'.$i.')-L'.$i.'),0)');  
                                    $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, '=ROUND((ROUND((K'.$i.'/M'.$i.'),2)-L'.$i.'),0)');
                                    $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $PRICE_LEFT);
                                    
                                    if($EMPC2_LEFT != ""){                                        
                                        if($EMPC2_LEFT==$EMPC1_LEFT){
                                            $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, '=O'.$i.'*P'.$i); 
                                        }else if($EMPC2_LEFT!=$EMPC1_LEFT){
                                            if( ($selcustomer2 == 'KUBOTA') || (($RSJOB_LEFT=="TAKANO")||($RSJOB_LEFT=="KEIHIN")||($RSJOB_LEFT=="KEIHIN,TAKANO")||($RSJOB_LEFT=="INGY")||($RSJOB_LEFT=="BJKC + INGY")) ){
                                                $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, '=(O'.$i.'*P'.$i.')/2');  
                                            }else{
                                                $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, '=O'.$i.'*P'.$i); 
                                            }
                                        }
                                    }else{
                                        $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, '=O'.$i.'*P'.$i); 
                                    }  
                                    // $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, '=O'.$i.'*P'.$i);                            
                                    if(($selcustomer2 == 'CS') || ($selcustomer2 == 'T.TOHKEN') || ($selcustomer2 == 'STM - IP')){
                                        $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, '=O'.$i.'*1');                                                                                    
                                        $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, '=ROUND((Q'.$i.'*1),0)');
                                    }else if(($selcustomer2 == 'KUBOTA') || ($selcustomer2 == 'TGT/DAIKI') || ($selcustomer2 == 'STM - TMT SR / TAW') || ($selcustomer2 == 'STC 10 W') || ($selcustomer2 == 'STC TL')){
                                        $objPHPExcel->getActiveSheet()->setCellValue('AD' . $i, '=O'.$i.'+AA'.$i);
                                        $objPHPExcel->getActiveSheet()->setCellValue('AE' . $i, '=ROUND((Q'.$i.'+AC'.$i.'),0)');
                                    }
                                }
                            if(($selcustomer2 == 'TGT/DAIKI') || ($selcustomer2 == 'STM - TMT SR / TAW') || ($selcustomer2 == 'STC 10 W') || ($selcustomer2 == 'STC TL')){
                                        // (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID) + OIL_AMOUNT AS OAM
                                    $SQLPLAN_RIGHT="SELECT DISTINCT PositionNameT PSTN,VHCTPP.COMPANYCODE COM,VHCTPP.CUSTOMERCODE CUS,OTSN.OILDATAID OILID,VHCTPP.EMPLOYEECODE1 EMPC1,VHCTPP.EMPLOYEENAME1 EMPN1,VHCTPP.EMPLOYEECODE2 EMPC2,CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) DW,CONVERT (VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,OTSN.OIL_BILLNUMBER OBLNB,OTSN.VEHICLEREGISNUMBER VHCRGNB,OTSN.VEHICLETYPE CARTYPE,VHCTPP.VEHICLETYPE VHCTPLAN,VHCTPP.JOBSTART JOBSTART,VHCTPP.JOBEND JOBEND,OTSN.MILEAGESTART MST,OTSN.MILEAGEEND MLE,OTSN.DISTANCE DTE,OTSN.OIL_AMOUNT,OTSN.OIL_AVERAGE OAVG,OTSN.OIL_TARGET OTG,VHCTPP.C3 AVG,VHCTPP.E1 MONEY,OTSN.JOBNO,VHCTPP.JOBNO,(SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID) AS OAM
                                    FROM EMPLOYEEEHR2 EHR
                                    LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON (VHCTPP.EMPLOYEECODE1 = EHR.PersonCode OR VHCTPP.EMPLOYEECODE2 = EHR.PersonCode)
                                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                                    WHERE (VHCTPP.EMPLOYEECODE1 = '$EMPC' OR VHCTPP.EMPLOYEECODE2 = '$EMPC') AND $QUERYIFELSE2";
                                    $QUERYPLAN_RIGHT = sqlsrv_query($conn, $SQLPLAN_RIGHT );
                                    while($RSPLAN_RIGHT = sqlsrv_fetch_array($QUERYPLAN_RIGHT)) {                                 
                                        $COM_RIGHT=$RSPLAN_RIGHT["COM"];
                                        $CUS_RIGHT=$RSPLAN_RIGHT["CUS"];
                                        $VHCRGNB_RIGHT=$RSPLAN_RIGHT["VHCRGNB"];
                                        $VHCTPLAN_RIGHT=$RSPLAN_RIGHT["VHCTPLAN"];
                                        $JOBSTART_RIGHT=$RSPLAN_RIGHT["JOBSTART"];
                                        $JOBEND_RIGHT=$RSPLAN_RIGHT["JOBEND"];
                                        if($JOBEND_RIGHT!=""){
                                            $RSJOB_RIGHT=$JOBEND_RIGHT;
                                        }else{
                                            $RSJOB_RIGHT=$JOBSTART_RIGHT;
                                        }
                                        $MST_RIGHT=$RSPLAN_RIGHT["MST"];
                                        $MLE_RIGHT=$RSPLAN_RIGHT["MLE"];
                                        $DTE_RIGHT=$RSPLAN_RIGHT["DTE"];
                                        
                                        $OILAMOUNTRIGHT=$RSPLAN_RIGHT["OIL_AMOUNT"];
                                        $OAMRIGHT=$RSPLAN_RIGHT["OAM"];
                                        $OAM_RIGHT=$OILAMOUNTRIGHT+$OAMRIGHT;

                                        $OTG_RIGHT=$RSPLAN_RIGHT["OTG"];
                                        $OAVG_RIGHT=$RSPLAN_RIGHT["OAVG"];                               
                                        $EMPC1_RIGHT=$RSPLAN_RIGHT["EMPC1"];
                                        $EMPC2_RIGHT=$RSPLAN_RIGHT["EMPC2"];                                    
            
                                $SQLPRICE_RIGHT = "SELECT OLP.PRICE,OLP.COMPANYCODE,OLP.[MONTH],OLP.[YEAR]   
                                FROM OILPEICE OLP WHERE OLP.COMPANYCODE = '$COM_RIGHT' AND OLP.[YEAR] = '$start_yen' AND OLP.[MONTH] = '$selectmonth'"; 
                                $QUERYPRICE_RIGHT = sqlsrv_query($conn, $SQLPRICE_RIGHT);
                                $RSPRICE_RIGHT = sqlsrv_fetch_array($QUERYPRICE_RIGHT, SQLSRV_FETCH_ASSOC);   
                                    $PRICE_RIGHT=$RSPRICE_RIGHT["PRICE"];

                                    $SQLROUND_RIGHT="SELECT COUNT(VHCTPP.EMPLOYEECODE1) AS ROUND FROM VEHICLETRANSPORTPLAN VHCTPP WHERE VHCTPP.COMPANYCODE = '$COM_RIGHT' AND (VHCTPP.EMPLOYEECODE1 = '$EMPC' OR VHCTPP.EMPLOYEECODE2 = '$EMPC') AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' GROUP BY VHCTPP.EMPLOYEECODE1 ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYROUND_RIGHT = sqlsrv_query($conn, $SQLROUND_RIGHT ); while($RSROUND_RIGHT = sqlsrv_fetch_array($QUERYROUND_RIGHT)) { $ROUND=$RSROUND_RIGHT["ROUND"];   
                                        $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $ROUND);
                                    }

                                    $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $VHCRGNB_RIGHT);
                                    $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $VHCTPLAN_RIGHT);

                                    $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $RSJOB_RIGHT);
                                    $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $MST_RIGHT);
                                    $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $MLE_RIGHT);
                                    $objPHPExcel->getActiveSheet()->setCellValue('W' . $i, '=V'.$i.'-U'.$i);
                                    $objPHPExcel->getActiveSheet()->setCellValue('X' . $i, $OAM_RIGHT);                                           
                                    $SQLOAVG_RIGHT="SELECT DISTINCT OILAVERAGE.OILAVERAGE OAVR FROM OILAVERAGE WHERE OILAVERAGE.COMPANYCODE = '$COM_RIGHT' AND OILAVERAGE.CUSTOMERCODE = '$CUS_RIGHT' AND OILAVERAGE.VEHICLETYPE = '$VHCTPLAN_RIGHT'";
                                    $QUERYOAVG_RIGHT = sqlsrv_query($conn, $SQLOAVG_RIGHT ); while($RSOAVG_RIGHT = sqlsrv_fetch_array($QUERYOAVG_RIGHT)) {                                         
                                        if ($VHCRGNB_RIGHT =='61-4454'||$VHCRGNB_RIGHT =='61-4456'||$VHCRGNB_RIGHT =='61-3440'||$VHCRGNB_RIGHT =='61-3441'||$VHCRGNB_RIGHT =='61-4453'||$VHCRGNB_RIGHT =='61-4457'||$VHCRGNB_RIGHT =='61-4912'||$VHCRGNB_RIGHT =='61-4913'||$VHCRGNB_RIGHT =='61-4546'||$VHCRGNB_RIGHT =='61-4547'||$VHCRGNB_RIGHT =='64-3452'||$VHCRGNB_RIGHT =='61-3445'||$VHCRGNB_RIGHT =='61-3439'||$VHCRGNB_RIGHT =='61-3443'||$VHCRGNB_RIGHT =='61-3834'||$VHCRGNB_RIGHT =='61-3835'||$VHCRGNB_RIGHT =='61-3438'||$VHCRGNB_RIGHT =='61-3437'||$VHCRGNB_RIGHT =='62-9288'||$VHCRGNB_RIGHT =='61-3836'||$VHCRGNB_RIGHT =='61-4458'||$VHCRGNB_RIGHT =='61-3444'||$VHCRGNB_RIGHT =='60-3868'||$VHCRGNB_RIGHT =='60-3870'||$VHCRGNB_RIGHT =='61-3437'||$VHCRGNB_RIGHT =='61-3452') {
                                            $OAVR_RIGHT = 4.0;    
                                        }else if($VHCRGNB_RIGHT =='60-3871'||$VHCRGNB_RIGHT =='61-3442'||$VHCRGNB_RIGHT =='60-2391'||$VHCRGNB_RIGHT =='61-3444'||$VHCRGNB_RIGHT =='76-8919'||$VHCRGNB_RIGHT =='61-4458'||$VHCRGNB_RIGHT =='79-2521'||$VHCRGNB_RIGHT =='79-2522'||$VHCRGNB_RIGHT =='79-2525'||$VHCRGNB_RIGHT =='74-5653'||$VHCRGNB_RIGHT =='74-5684'||$VHCRGNB_RIGHT =='74-5684'||$VHCRGNB_RIGHT =='74-5654') {
                                            $OAVR_RIGHT = 3.5;  
                                        }else{
                                            $OAVR_RIGHT=$RSOAVG_RIGHT["OAVR"];
                                        }
                                        
                                        $objPHPExcel->getActiveSheet()->setCellValue('Y' . $i, $OAVR_RIGHT);
                                    }
                                    
                                    // $ZCOLUMN=$DTE_RIGHT / $OAM_RIGHT ;
                                    // $AACOLUMN=($DTE_RIGHT / $OAVR_RIGHT) - $OAM_RIGHT ;
                                    // $objPHPExcel->getActiveSheet()->setCellValue('Z' . $i, $ZCOLUMN);
                                    // $objPHPExcel->getActiveSheet()->setCellValue('AA' . $i, round($AACOLUMN));
                                    $objPHPExcel->getActiveSheet()->setCellValue('Z' . $i, '=W'.$i.'/X'.$i);    
                                    // $objPHPExcel->getActiveSheet()->setCellValue('AA' . $i, '=ROUND(((W'.$i.'/Y'.$i.')-X'.$i.'),0)');
                                    $objPHPExcel->getActiveSheet()->setCellValue('AA' . $i, '=ROUND((ROUND((W'.$i.'/Y'.$i.'),2)-X'.$i.'),0)');                                                                                                            
                                    $objPHPExcel->getActiveSheet()->setCellValue('AB' . $i, $PRICE_RIGHT);
                                    
                                    if($EMPC2_RIGHT != ""){
                                        if($EMPC2_RIGHT==$EMPC1_RIGHT){
                                            $objPHPExcel->getActiveSheet()->setCellValue('AC' . $i, '=AA'.$i.'*AB'.$i); 
                                        }else if($EMPC2_RIGHT!=$EMPC1_RIGHT){
                                            if( ($selcustomer2 == 'KUBOTA') || (($RSJOB_RIGHT=="TAKANO")||($RSJOB_RIGHT=="KEIHIN")||($RSJOB_RIGHT=="KEIHIN,TAKANO")||($RSJOB_RIGHT=="INGY")||($RSJOB_RIGHT=="BJKC + INGY")) ){
                                                $objPHPExcel->getActiveSheet()->setCellValue('AC' . $i, '=(AA'.$i.'*AB'.$i.')/2'); 
                                            }else{
                                                $objPHPExcel->getActiveSheet()->setCellValue('AC' . $i, '=AA'.$i.'*AB'.$i); 
                                            }
                                        }
                                    }else{
                                        $objPHPExcel->getActiveSheet()->setCellValue('AC' . $i, '=AA'.$i.'*AB'.$i); 
                                    }  
                                    // $objPHPExcel->getActiveSheet()->setCellValue('AC' . $i, '=AA'.$i.'*AB'.$i);                            
                                    if(($selcustomer2 == 'CS') || ($selcustomer2 == 'T.TOHKEN') || ($selcustomer2 == 'STM - IP')){
                                        // $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, '=U'.$i.'*1');
                                        $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, '=O'.$i.'*1');                                                                       
                                        $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, '=ROUND((Q'.$i.'*1),0)');
                                    }else if(($selcustomer2 == 'KUBOTA') || ($selcustomer2 == 'TGT/DAIKI') || ($selcustomer2 == 'STM - TMT SR / TAW') || ($selcustomer2 == 'STC 10 W') || ($selcustomer2 == 'STC TL')){
                                        $objPHPExcel->getActiveSheet()->setCellValue('AD' . $i, '=O'.$i.'+AA'.$i);
                                        $objPHPExcel->getActiveSheet()->setCellValue('AE' . $i, '=ROUND((Q'.$i.'+AC'.$i.'),0)');
                                    }
                                }
                            }
                        }else if($selcustomer2 == 'KUBOTA'){
                            $SQLPLANCHKVHCRG="SELECT DISTINCT OTSN.VEHICLEREGISNUMBER CHKVHCRGNB,VHCTPP.JOBNO
                            FROM EMPLOYEEEHR2 EHR
                            LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON (VHCTPP.EMPLOYEECODE1 = EHR.PersonCode OR VHCTPP.EMPLOYEECODE2 = EHR.PersonCode)
                            LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                            WHERE (VHCTPP.EMPLOYEECODE1 = '$EMPC' OR VHCTPP.EMPLOYEECODE2 = '$EMPC') AND $QUERYIFELSE1";
                            $QUERYPLANCHKVHCRG = sqlsrv_query($conn, $SQLPLANCHKVHCRG );
                            while($RSPLANCHKVHCRG = sqlsrv_fetch_array($QUERYPLANCHKVHCRG)) {
                                $CHKTABIEANROD=$RSPLANCHKVHCRG["CHKVHCRGNB"];
                                if ($CHKTABIEANROD =='61-4454'||$CHKTABIEANROD =='61-4456'||$CHKTABIEANROD =='61-3440'||$CHKTABIEANROD =='61-3441'||$CHKTABIEANROD =='61-4453'||$CHKTABIEANROD =='61-4457'||$CHKTABIEANROD =='61-4912'||$CHKTABIEANROD =='61-4913'||$CHKTABIEANROD =='61-4546'||$CHKTABIEANROD =='61-4547'||$CHKTABIEANROD =='64-3452'||$CHKTABIEANROD =='61-3445'||$CHKTABIEANROD =='61-3439'||$CHKTABIEANROD =='61-3443'||$CHKTABIEANROD =='61-3834'||$CHKTABIEANROD =='61-3835'||$CHKTABIEANROD =='61-3438'||$CHKTABIEANROD =='61-3437'||$CHKTABIEANROD =='62-9288'||$CHKTABIEANROD =='61-3836'||$CHKTABIEANROD =='61-4458'||$CHKTABIEANROD =='61-3444'||$CHKTABIEANROD =='60-3868'||$CHKTABIEANROD =='60-3870'||$CHKTABIEANROD =='61-3437'||$CHKTABIEANROD =='61-3452') {
                                    $OAVR_KUBOTA = 4.0;
                                    // (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID) + OIL_AMOUNT AS OAM
                                    $SQLPLAN_LEFT="SELECT DISTINCT PositionNameT PSTN,VHCTPP.COMPANYCODE COM,VHCTPP.CUSTOMERCODE CUS,OTSN.OILDATAID OILID,VHCTPP.EMPLOYEECODE1 EMPC1,VHCTPP.EMPLOYEENAME1 EMPN1,VHCTPP.EMPLOYEECODE2 EMPC2,VHCTPP.EMPLOYEENAME2 EMPN2,CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) DW,CONVERT (VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,OTSN.OIL_BILLNUMBER OBLNB,OTSN.VEHICLEREGISNUMBER VHCRGNB,OTSN.VEHICLETYPE CARTYPE,VHCTPP.VEHICLETYPE VHCTPLAN,VHCTPP.JOBSTART JOBSTART,VHCTPP.JOBEND JOBEND,OTSN.MILEAGESTART MST,OTSN.MILEAGEEND MLE,OTSN.DISTANCE DTE,OTSN.OIL_AMOUNT,OTSN.OIL_AVERAGE OAVG,OTSN.OIL_TARGET OTG,VHCTPP.C3 AVG,VHCTPP.E1 MONEY,OTSN.JOBNO,VHCTPP.JOBNO,(SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID) AS OAM
                                    FROM EMPLOYEEEHR2 EHR
                                    LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON (VHCTPP.EMPLOYEECODE1 = EHR.PersonCode OR VHCTPP.EMPLOYEECODE2 = EHR.PersonCode)
                                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                                    WHERE (VHCTPP.EMPLOYEECODE1 = '$EMPC' OR VHCTPP.EMPLOYEECODE2 = '$EMPC') AND $QUERYIFELSE1";
                                    $QUERYPLAN_LEFT = sqlsrv_query($conn, $SQLPLAN_LEFT );
                                    while($RSPLAN_LEFT = sqlsrv_fetch_array($QUERYPLAN_LEFT)) {                                 
                                        $COM_LEFT=$RSPLAN_LEFT["COM"];
                                        $CUS_LEFT=$RSPLAN_LEFT["CUS"];
                                        $VHCRGNB_LEFT=$RSPLAN_LEFT["VHCRGNB"];
                                        $VHCTPLAN_LEFT=$RSPLAN_LEFT["VHCTPLAN"];
                                        $JOBSTART_LEFT=$RSPLAN_LEFT["JOBSTART"];
                                        $JOBEND_LEFT=$RSPLAN_LEFT["JOBEND"];
                                        if($JOBEND_LEFT!=""){
                                            $RSJOB_LEFT=$JOBEND_LEFT;
                                        }else{
                                            $RSJOB_LEFT=$JOBSTART_LEFT;
                                        }
                                        $MST_LEFT=$RSPLAN_LEFT["MST"];
                                        $MLE_LEFT=$RSPLAN_LEFT["MLE"];
                                        $DTE_LEFT=$RSPLAN_LEFT["DTE"];
                                        $OAM_LEFT=$RSPLAN_LEFT["OAM"];
                                        $OTG_LEFT=$RSPLAN_LEFT["OTG"];
                                        $OAVG_LEFT=$RSPLAN_LEFT["OAVG"];                                  
                                        $EMPC1_LEFT=$RSPLAN_LEFT["EMPC1"];
                                        $EMPC2_LEFT=$RSPLAN_LEFT["EMPC2"];
                                        $SQLPRICE_LEFT = "SELECT OLP.PRICE,OLP.COMPANYCODE,OLP.[MONTH],OLP.[YEAR] FROM OILPEICE OLP WHERE OLP.COMPANYCODE = '$COM_LEFT' AND OLP.[YEAR] = '$start_yen' AND OLP.[MONTH] = '$selectmonth'";
                                        $QUERYPRICE_LEFT = sqlsrv_query($conn, $SQLPRICE_LEFT);
                                        $RSPRICE_LEFT = sqlsrv_fetch_array($QUERYPRICE_LEFT, SQLSRV_FETCH_ASSOC);   
                                            $PRICE_LEFT=$RSPRICE_LEFT["PRICE"];
                                        $SQLROUND_LEFT="SELECT COUNT(VHCTPP.EMPLOYEECODE1) AS ROUND FROM VEHICLETRANSPORTPLAN VHCTPP WHERE VHCTPP.COMPANYCODE = '$COM_LEFT' AND (VHCTPP.EMPLOYEECODE1 = '$EMPC' OR VHCTPP.EMPLOYEECODE2 = '$EMPC') AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' GROUP BY VHCTPP.EMPLOYEECODE1 ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                            $QUERYROUND_LEFT = sqlsrv_query($conn, $SQLROUND_LEFT ); while($RSROUND_LEFT = sqlsrv_fetch_array($QUERYROUND_LEFT)) { $ROUND=$RSROUND_LEFT["ROUND"];   
                                                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $ROUND);
                                            }
                                        $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $VHCRGNB_LEFT);
                                        $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $VHCTPLAN_LEFT);
                                        $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $RSJOB_LEFT);
                                        $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $MST_LEFT);
                                        $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $MLE_LEFT);
                                        $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, '=J'.$i.'-I'.$i);
                                        $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $OAM_LEFT);                                         
                                        $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $OAVR_KUBOTA);    
                                        
                                        // $KCOLUMN=$DTE_LEFT / $OAM_LEFT ;
                                        // $OCOLUMN=($DTE_LEFT / $OAVR_LEFT) - $OAM_LEFT ;
                                        // $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $KCOLUMN);
                                        // $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, round($OCOLUMN));
                                        $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, '=K'.$i.'/L'.$i);
                                        // $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, '=ROUND(((K'.$i.'/M'.$i.')-L'.$i.'),0)');  
                                        $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, '=ROUND((ROUND((K'.$i.'/M'.$i.'),2)-L'.$i.'),0)');    
                                        $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $PRICE_LEFT);                                        
                                        if($EMPC2_LEFT != ""){
                                            if($EMPC2_LEFT==$EMPC1_LEFT){
                                                $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, '=O'.$i.'*P'.$i); 
                                            }else if($EMPC2_LEFT!=$EMPC1_LEFT){
                                                if( ($selcustomer2 == 'KUBOTA') || (($RSJOB_LEFT=="TAKANO")||($RSJOB_LEFT=="KEIHIN")||($RSJOB_LEFT=="KEIHIN,TAKANO")||($RSJOB_LEFT=="INGY")||($RSJOB_LEFT=="BJKC + INGY")) ){
                                                    if($RSJOB_LEFT == "คลังโคราช"){
                                                        $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, '0.00'); 
                                                    }else{
                                                        $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, '=(O'.$i.'*P'.$i.')/2'); 
                                                    }
                                                }else{
                                                    $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, '=O'.$i.'*P'.$i); 
                                                }
                                            }
                                        }else{
                                            $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, '=O'.$i.'*P'.$i); 
                                        }  
                                        // $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, '=O'.$i.'*P'.$i);                            
                                        if(($selcustomer2 == 'CS') || ($selcustomer2 == 'T.TOHKEN') || ($selcustomer2 == 'STM - IP')){
                                            $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, '=O'.$i.'*1');                                                                       
                                            $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, '=ROUND((Q'.$i.'*1),0)');
                                        }else if(($selcustomer2 == 'KUBOTA') || ($selcustomer2 == 'TGT/DAIKI') || ($selcustomer2 == 'STM - TMT SR / TAW') || ($selcustomer2 == 'STC 10 W') || ($selcustomer2 == 'STC TL')){
                                            $objPHPExcel->getActiveSheet()->setCellValue('AD' . $i, '=O'.$i.'+AA'.$i);
                                            $objPHPExcel->getActiveSheet()->setCellValue('AE' . $i, '=ROUND((Q'.$i.'+AC'.$i.'),0)');
                                        }
                                    }
                                }else if($CHKTABIEANROD =='60-3871'||$CHKTABIEANROD =='61-3442'||$CHKTABIEANROD =='60-2391'||$CHKTABIEANROD =='61-3444'||$CHKTABIEANROD =='76-8919'||$CHKTABIEANROD =='61-4458'||$CHKTABIEANROD =='79-2521'||$CHKTABIEANROD =='79-2522'||$CHKTABIEANROD =='79-2525'||$CHKTABIEANROD =='74-5653'||$CHKTABIEANROD =='74-5684'||$CHKTABIEANROD =='74-5684'||$CHKTABIEANROD =='74-5654') {
                                    $OAVR_KUBOTA = 3.5;  
                                    // (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID) + OIL_AMOUNT AS OAM
                                    $SQLPLAN_RIGHT="SELECT DISTINCT PositionNameT PSTN,VHCTPP.COMPANYCODE COM,VHCTPP.CUSTOMERCODE CUS,OTSN.OILDATAID OILID,VHCTPP.EMPLOYEECODE1 EMPC1,VHCTPP.EMPLOYEENAME1 EMPN1,VHCTPP.EMPLOYEECODE2 EMPC2,CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) DW,CONVERT (VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,OTSN.OIL_BILLNUMBER OBLNB,OTSN.VEHICLEREGISNUMBER VHCRGNB,OTSN.VEHICLETYPE CARTYPE,VHCTPP.VEHICLETYPE VHCTPLAN,VHCTPP.JOBSTART JOBSTART,VHCTPP.JOBEND JOBEND,OTSN.MILEAGESTART MST,OTSN.MILEAGEEND MLE,OTSN.DISTANCE DTE,OTSN.OIL_AMOUNT,OTSN.OIL_AVERAGE OAVG,OTSN.OIL_TARGET OTG,VHCTPP.C3 AVG,VHCTPP.E1 MONEY,OTSN.JOBNO,VHCTPP.JOBNO,(SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID) AS OAM
                                    FROM EMPLOYEEEHR2 EHR
                                    LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON (VHCTPP.EMPLOYEECODE1 = EHR.PersonCode OR VHCTPP.EMPLOYEECODE2 = EHR.PersonCode)
                                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                                    WHERE (VHCTPP.EMPLOYEECODE1 = '$EMPC' OR VHCTPP.EMPLOYEECODE2 = '$EMPC') AND $QUERYIFELSE2";
                                    $QUERYPLAN_RIGHT = sqlsrv_query($conn, $SQLPLAN_RIGHT );
                                    while($RSPLAN_RIGHT = sqlsrv_fetch_array($QUERYPLAN_RIGHT)) {                                 
                                        $COM_RIGHT=$RSPLAN_RIGHT["COM"];
                                        $CUS_RIGHT=$RSPLAN_RIGHT["CUS"];
                                        $VHCRGNB_RIGHT=$RSPLAN_RIGHT["VHCRGNB"];
                                        $VHCTPLAN_RIGHT=$RSPLAN_RIGHT["VHCTPLAN"];
                                        $JOBSTART_RIGHT=$RSPLAN_RIGHT["JOBSTART"];
                                        $JOBEND_RIGHT=$RSPLAN_RIGHT["JOBEND"];
                                        if($JOBEND_RIGHT!=""){
                                            $RSJOB_RIGHT=$JOBEND_RIGHT;
                                        }else{
                                            $RSJOB_RIGHT=$JOBSTART_RIGHT;
                                        }
                                        $MST_RIGHT=$RSPLAN_RIGHT["MST"];
                                        $MLE_RIGHT=$RSPLAN_RIGHT["MLE"];
                                        $DTE_RIGHT=$RSPLAN_RIGHT["DTE"];
                                        
                                        $OILAMOUNTRIGHT=$RSPLAN_RIGHT["OIL_AMOUNT"];
                                        $OAMRIGHT=$RSPLAN_RIGHT["OAM"];
                                        $OAM_RIGHT=$OILAMOUNTRIGHT+$OAMRIGHT;

                                        $OTG_RIGHT=$RSPLAN_RIGHT["OTG"];
                                        $OAVG_RIGHT=$RSPLAN_RIGHT["OAVG"];                               
                                        $EMPC1_RIGHT=$RSPLAN_RIGHT["EMPC1"];
                                        $EMPC2_RIGHT=$RSPLAN_RIGHT["EMPC2"];                                    
                                
                                        $SQLPRICE_RIGHT = "SELECT OLP.PRICE,OLP.COMPANYCODE,OLP.[MONTH],OLP.[YEAR]   
                                        FROM OILPEICE OLP WHERE OLP.COMPANYCODE = '$COM_RIGHT' AND OLP.[YEAR] = '$start_yen' AND OLP.[MONTH] = '$selectmonth'"; 
                                        $QUERYPRICE_RIGHT = sqlsrv_query($conn, $SQLPRICE_RIGHT);
                                        $RSPRICE_RIGHT = sqlsrv_fetch_array($QUERYPRICE_RIGHT, SQLSRV_FETCH_ASSOC);   
                                            $PRICE_RIGHT=$RSPRICE_RIGHT["PRICE"];                                
                                        $SQLROUND_RIGHT="SELECT COUNT(VHCTPP.EMPLOYEECODE1) AS ROUND FROM VEHICLETRANSPORTPLAN VHCTPP WHERE VHCTPP.COMPANYCODE = '$COM_RIGHT' AND (VHCTPP.EMPLOYEECODE1 = '$EMPC' OR VHCTPP.EMPLOYEECODE2 = '$EMPC') AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' GROUP BY VHCTPP.EMPLOYEECODE1 ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                        $QUERYROUND_RIGHT = sqlsrv_query($conn, $SQLROUND_RIGHT ); while($RSROUND_RIGHT = sqlsrv_fetch_array($QUERYROUND_RIGHT)) { $ROUND=$RSROUND_RIGHT["ROUND"];   
                                            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $ROUND);
                                        }                                
                                        $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $VHCRGNB_RIGHT);
                                        $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $VHCTPLAN_RIGHT);                                
                                        $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $RSJOB_RIGHT);
                                        $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $MST_RIGHT);
                                        $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $MLE_RIGHT);
                                        $objPHPExcel->getActiveSheet()->setCellValue('W' . $i, '=V'.$i.'-U'.$i);
                                        $objPHPExcel->getActiveSheet()->setCellValue('X' . $i, $OAM_RIGHT);       
                                        $objPHPExcel->getActiveSheet()->setCellValue('Y' . $i, $OAVR_KUBOTA);   
                                        // $ZCOLUMN=$DTE_RIGHT / $OAM_RIGHT ;
                                        // $AACOLUMN=($DTE_RIGHT / $OAVR_RIGHT) - $OAM_RIGHT ;
                                        // $objPHPExcel->getActiveSheet()->setCellValue('Z' . $i, $ZCOLUMN);
                                        // $objPHPExcel->getActiveSheet()->setCellValue('AA' . $i, round($AACOLUMN));
                                        $objPHPExcel->getActiveSheet()->setCellValue('Z' . $i, '=W'.$i.'/X'.$i);
                                        // $objPHPExcel->getActiveSheet()->setCellValue('AA' . $i, '=ROUND(((W'.$i.'/Y'.$i.')-X'.$i.'),0)');
                                        $objPHPExcel->getActiveSheet()->setCellValue('AA' . $i, '=ROUND((ROUND((W'.$i.'/Y'.$i.'),2)-X'.$i.'),0)');        
                                        $objPHPExcel->getActiveSheet()->setCellValue('AB' . $i, $PRICE_RIGHT);                                        
                                        if($EMPC2_RIGHT != ""){
                                            if($EMPC2_RIGHT==$EMPC1_RIGHT){
                                                $objPHPExcel->getActiveSheet()->setCellValue('AC' . $i, '=AA'.$i.'*AB'.$i); 
                                            }else if($EMPC2_RIGHT!=$EMPC1_RIGHT){
                                                if( ($selcustomer2 == 'KUBOTA') || (($RSJOB_RIGHT=="TAKANO")||($RSJOB_RIGHT=="KEIHIN")||($RSJOB_RIGHT=="KEIHIN,TAKANO")||($RSJOB_RIGHT=="INGY")||($RSJOB_RIGHT=="BJKC + INGY")) ){
                                                    if($RSJOB_RIGHT == "คลังโคราช"){
                                                        $objPHPExcel->getActiveSheet()->setCellValue('AC' . $i, '0.00'); 
                                                    }else{
                                                        $objPHPExcel->getActiveSheet()->setCellValue('AC' . $i, '=(AA'.$i.'*AB'.$i.')/2'); 
                                                    }
                                                }else{
                                                    $objPHPExcel->getActiveSheet()->setCellValue('AC' . $i, '=AA'.$i.'*AB'.$i);  
                                                }
                                            }
                                        }else{
                                            $objPHPExcel->getActiveSheet()->setCellValue('AC' . $i, '=AA'.$i.'*AB'.$i); 
                                        }                             
                                        if(($selcustomer2 == 'CS') || ($selcustomer2 == 'T.TOHKEN') || ($selcustomer2 == 'STM - IP')){
                                            // $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, '=U'.$i.'*1');
                                            $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, '=O'.$i.'*1');                                                                       
                                            $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, '=ROUND((Q'.$i.'*1),0)');
                                        }else if(($selcustomer2 == 'KUBOTA') || ($selcustomer2 == 'TGT/DAIKI') || ($selcustomer2 == 'STM - TMT SR / TAW') || ($selcustomer2 == 'STC 10 W') || ($selcustomer2 == 'STC TL')){
                                            $objPHPExcel->getActiveSheet()->setCellValue('AD' . $i, '=O'.$i.'+AA'.$i);
                                            $objPHPExcel->getActiveSheet()->setCellValue('AE' . $i, '=ROUND((Q'.$i.'+AC'.$i.'),0)');
                                        }
                                    }
                                }else{
                                    // (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID) + OIL_AMOUNT AS OAM
                                    $SQLPLAN_LEFT="SELECT DISTINCT PositionNameT PSTN,VHCTPP.COMPANYCODE COM,VHCTPP.CUSTOMERCODE CUS,OTSN.OILDATAID OILID,VHCTPP.EMPLOYEECODE1 EMPC1,VHCTPP.EMPLOYEENAME1 EMPN1,VHCTPP.EMPLOYEECODE2 EMPC2,VHCTPP.EMPLOYEENAME2 EMPN2,CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) DW,CONVERT (VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,OTSN.OIL_BILLNUMBER OBLNB,OTSN.VEHICLEREGISNUMBER VHCRGNB,OTSN.VEHICLETYPE CARTYPE,VHCTPP.VEHICLETYPE VHCTPLAN,VHCTPP.JOBSTART JOBSTART,VHCTPP.JOBEND JOBEND,OTSN.MILEAGESTART MST,OTSN.MILEAGEEND MLE,OTSN.DISTANCE DTE,OTSN.OIL_AMOUNT,OTSN.OIL_AVERAGE OAVG,OTSN.OIL_TARGET OTG,VHCTPP.C3 AVG,VHCTPP.E1 MONEY,OTSN.JOBNO,VHCTPP.JOBNO,(SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID) AS OAM
                                    FROM EMPLOYEEEHR2 EHR
                                    LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON (VHCTPP.EMPLOYEECODE1 = EHR.PersonCode OR VHCTPP.EMPLOYEECODE2 = EHR.PersonCode)
                                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                                    WHERE (VHCTPP.EMPLOYEECODE1 = '$EMPC' OR VHCTPP.EMPLOYEECODE2 = '$EMPC') AND $QUERYIFELSE1";
                                    $QUERYPLAN_LEFT = sqlsrv_query($conn, $SQLPLAN_LEFT );
                                    while($RSPLAN_LEFT = sqlsrv_fetch_array($QUERYPLAN_LEFT)) {                                 
                                        $COM_LEFT=$RSPLAN_LEFT["COM"];
                                        $CUS_LEFT=$RSPLAN_LEFT["CUS"];
                                        $VHCRGNB_LEFT=$RSPLAN_LEFT["VHCRGNB"];
                                        $VHCTPLAN_LEFT=$RSPLAN_LEFT["VHCTPLAN"];
                                        $JOBSTART_LEFT=$RSPLAN_LEFT["JOBSTART"];
                                        $JOBEND_LEFT=$RSPLAN_LEFT["JOBEND"];
                                        if($JOBEND_LEFT!=""){
                                            $RSJOB_LEFT=$JOBEND_LEFT;
                                        }else{
                                            $RSJOB_LEFT=$JOBSTART_LEFT;
                                        }
                                        $MST_LEFT=$RSPLAN_LEFT["MST"];
                                        $MLE_LEFT=$RSPLAN_LEFT["MLE"];
                                        $DTE_LEFT=$RSPLAN_LEFT["DTE"];                                        
                                    
                                        $OILAMOUNTLEFT=$RSPLAN_LEFT["OIL_AMOUNT"];
                                        $OAMLEFT=$RSPLAN_LEFT["OAM"];
                                        $OAM_LEFT=$OILAMOUNTLEFT+$OAMLEFT;

                                        $OTG_LEFT=$RSPLAN_LEFT["OTG"];
                                        $OAVG_LEFT=$RSPLAN_LEFT["OAVG"];                                  
                                        $EMPC1_LEFT=$RSPLAN_LEFT["EMPC1"];
                                        $EMPC2_LEFT=$RSPLAN_LEFT["EMPC2"];                                

                                        $SQLPRICE_LEFT = "SELECT OLP.PRICE,OLP.COMPANYCODE,OLP.[MONTH],OLP.[YEAR] FROM OILPEICE OLP WHERE OLP.COMPANYCODE = '$COM_LEFT' AND OLP.[YEAR] = '$start_yen' AND OLP.[MONTH] = '$selectmonth'";
                                        $QUERYPRICE_LEFT = sqlsrv_query($conn, $SQLPRICE_LEFT);
                                        $RSPRICE_LEFT = sqlsrv_fetch_array($QUERYPRICE_LEFT, SQLSRV_FETCH_ASSOC);   
                                            $PRICE_LEFT=$RSPRICE_LEFT["PRICE"];

                                        $SQLROUND_LEFT="SELECT COUNT(VHCTPP.EMPLOYEECODE1) AS ROUND FROM VEHICLETRANSPORTPLAN VHCTPP WHERE VHCTPP.COMPANYCODE = '$COM_LEFT' AND (VHCTPP.EMPLOYEECODE1 = '$EMPC' OR VHCTPP.EMPLOYEECODE2 = '$EMPC') AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' GROUP BY VHCTPP.EMPLOYEECODE1 ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                            $QUERYROUND_LEFT = sqlsrv_query($conn, $SQLROUND_LEFT ); while($RSROUND_LEFT = sqlsrv_fetch_array($QUERYROUND_LEFT)) { $ROUND=$RSROUND_LEFT["ROUND"];   
                                                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $ROUND);
                                            }

                                        $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $VHCRGNB_LEFT);
                                        $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $VHCTPLAN_LEFT);

                                        $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $RSJOB_LEFT);
                                        $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $MST_LEFT);
                                        $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $MLE_LEFT);
                                        $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, '=J'.$i.'-I'.$i);
                                        $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $OAM_LEFT);                                           
                                        $SQLOAVG_LEFT="SELECT DISTINCT OILAVERAGE.OILAVERAGE OAVR FROM OILAVERAGE WHERE OILAVERAGE.COMPANYCODE = '$COM_LEFT' AND OILAVERAGE.CUSTOMERCODE = '$CUS_LEFT' AND OILAVERAGE.VEHICLETYPE = '$VHCTPLAN_LEFT'";
                                            $QUERYOAVG_LEFT = sqlsrv_query($conn, $SQLOAVG_LEFT ); while($RSOAVG_LEFT = sqlsrv_fetch_array($QUERYOAVG_LEFT)) {                                         
                                                if ($VHCRGNB_LEFT =='61-4454'||$VHCRGNB_LEFT =='61-4456'||$VHCRGNB_LEFT =='61-3440'||$VHCRGNB_LEFT =='61-3441'||$VHCRGNB_LEFT =='61-4453'||$VHCRGNB_LEFT =='61-4457'||$VHCRGNB_LEFT =='61-4912'||$VHCRGNB_LEFT =='61-4913'||$VHCRGNB_LEFT =='61-4546'||$VHCRGNB_LEFT =='61-4547'||$VHCRGNB_LEFT =='64-3452'||$VHCRGNB_LEFT =='61-3445'||$VHCRGNB_LEFT =='61-3439'||$VHCRGNB_LEFT =='61-3443'||$VHCRGNB_LEFT =='61-3834'||$VHCRGNB_LEFT =='61-3835'||$VHCRGNB_LEFT =='61-3438'||$VHCRGNB_LEFT =='61-3437'||$VHCRGNB_LEFT =='62-9288'||$VHCRGNB_LEFT =='61-3836'||$VHCRGNB_LEFT =='61-4458'||$VHCRGNB_LEFT =='61-3444'||$VHCRGNB_LEFT =='60-3868'||$VHCRGNB_LEFT =='60-3870'||$VHCRGNB_LEFT =='61-3437'||$VHCRGNB_LEFT =='61-3452') {
                                                    $OAVR_LEFT = 4.0;    
                                                }else if($VHCRGNB_LEFT =='60-3871'||$VHCRGNB_LEFT =='61-3442'||$VHCRGNB_LEFT =='60-2391'||$VHCRGNB_LEFT =='61-3444'||$VHCRGNB_LEFT =='76-8919'||$VHCRGNB_LEFT =='61-4458'||$VHCRGNB_LEFT =='79-2521'||$VHCRGNB_LEFT =='79-2522'||$VHCRGNB_LEFT =='79-2525'||$VHCRGNB_LEFT =='74-5653'||$VHCRGNB_LEFT =='74-5684'||$VHCRGNB_LEFT =='74-5684'||$VHCRGNB_LEFT =='74-5654') {
                                                    $OAVR_LEFT = 3.5;  
                                                }else{
                                                    $OAVR_LEFT=$RSOAVG_LEFT["OAVR"]; 
                                                }

                                                $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $OAVR_LEFT);
                                            }

                                        // $KCOLUMN=$DTE_LEFT / $OAM_LEFT ;
                                        // $OCOLUMN=($DTE_LEFT / $OAVR_LEFT) - $OAM_LEFT ;
                                        // $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $KCOLUMN);
                                        // $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, round($OCOLUMN));
                                        $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, '=K'.$i.'/L'.$i);
                                        // $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, '=ROUND(((K'.$i.'/M'.$i.')-L'.$i.'),0)');  
                                        $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, '=ROUND((ROUND((K'.$i.'/M'.$i.'),2)-L'.$i.'),0)');
                                        $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $PRICE_LEFT);
                                        
                                        if($EMPC2_LEFT != ""){
                                            if($EMPC2_LEFT==$EMPC1_LEFT){
                                                $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, '=O'.$i.'*P'.$i); 
                                            }else if($EMPC2_LEFT!=$EMPC1_LEFT){
                                                if( ($selcustomer2 == 'KUBOTA') || (($RSJOB_LEFT=="TAKANO")||($RSJOB_LEFT=="KEIHIN")||($RSJOB_LEFT=="KEIHIN,TAKANO")||($RSJOB_LEFT=="INGY")||($RSJOB_LEFT=="BJKC + INGY")) ){
                                                    if($RSJOB_LEFT == "คลังโคราช"){
                                                        $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, '0.00'); 
                                                    }else{
                                                        $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, '=(O'.$i.'*P'.$i.')/2'); 
                                                    }
                                                }else{
                                                    $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, '=O'.$i.'*P'.$i); 
                                                }
                                            }
                                        }else{
                                            $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, '=O'.$i.'*P'.$i); 
                                        }  
                                        // $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, '=O'.$i.'*P'.$i);                            
                                        if(($selcustomer2 == 'CS') || ($selcustomer2 == 'T.TOHKEN') || ($selcustomer2 == 'STM - IP')){
                                            $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, '=O'.$i.'*1');                                                                       
                                            $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, '=ROUND((Q'.$i.'*1),0)');
                                        }else if(($selcustomer2 == 'KUBOTA') || ($selcustomer2 == 'TGT/DAIKI') || ($selcustomer2 == 'STM - TMT SR / TAW') || ($selcustomer2 == 'STC 10 W') || ($selcustomer2 == 'STC TL')){
                                            $objPHPExcel->getActiveSheet()->setCellValue('AD' . $i, '=O'.$i.'+AA'.$i);
                                            $objPHPExcel->getActiveSheet()->setCellValue('AE' . $i, '=ROUND((Q'.$i.'+AC'.$i.'),0)');
                                        }
                                    }
                                }
                            }
                        }
                        $numpage++; $i++;
                    }                     
                    
                    $objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':J'.$i);
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, 'รวม');
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold( true );
                    
                    $sheet->getStyle('K'.$i.':L'.$i)->getNumberFormat()->setFormatCode('0.00');
                    if($selcustomer2 == 'KUBOTA'){
                        $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, '=SUM(K10:K'.($i -1).')/2');
                        $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, '=SUM(L10:L'.($i -1).')/2');
                    }else{
                        $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, '=SUM(K10:K'.($i -1).')');
                        $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, '=SUM(L10:L'.($i -1).')');
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue('N'.$i, '=K'.$i.'/L'.$i);
                    $objPHPExcel->getActiveSheet()->setCellValue('O'.$i, '=SUM(O10:O'.($i -1).')');
                    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, '=SUM(Q10:Q'.($i -1).')');
                    
                    $sheet->getStyle('L10:L'.$i)->getNumberFormat()->setFormatCode('0.00'); 
                    $sheet->getStyle('N10:O'.$i)->getNumberFormat()->setFormatCode('0.00'); 
                    
                    $objPHPExcel->getActiveSheet()->getStyle('A10:B'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('C10:D'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('E10:G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('H10:H'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('I10:L'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('M10:M'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('N10:O'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('P10:P'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('Q10:Q'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                    if(($selcustomer2 == 'CS') || ($selcustomer2 == 'T.TOHKEN') || ($selcustomer2 == 'STM - IP')){      
                        $sheet->getStyle('Q10:S'.$i)->getNumberFormat()->setFormatCode('0.00');                   
                        $objPHPExcel->getActiveSheet()->setCellValue('R'.$i, '=SUM(R10:R'.($i -1).')');
                        $objPHPExcel->getActiveSheet()->setCellValue('S'.$i, '=SUM(S10:S'.($i -1).')');
                        $sheet->getStyle('A'.$i.':S'.$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));
                        $sheet->getStyle('A10:S'.$i)->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                    }else if(($selcustomer2 == 'KUBOTA') || ($selcustomer2 == 'TGT/DAIKI') || ($selcustomer2 == 'STM - TMT SR / TAW') || ($selcustomer2 == 'STC 10 W') || ($selcustomer2 == 'STC TL')){

                        $sheet->getStyle('Q10:Q'.$i)->getNumberFormat()->setFormatCode('0.00');
                        $objPHPExcel->getActiveSheet()->mergeCells('R'.$i.':V'.$i);                      
                        $sheet->getStyle('U'.$i.':AC'.$i)->getNumberFormat()->setFormatCode('0.00');
                        if($selcustomer2 == 'KUBOTA'){
                            $objPHPExcel->getActiveSheet()->setCellValue('W'.$i, '=SUM(W10:W'.($i -1).')/2');
                            $objPHPExcel->getActiveSheet()->setCellValue('X'.$i, '=SUM(X10:X'.($i -1).')/2');
                        }else{
                            $objPHPExcel->getActiveSheet()->setCellValue('W'.$i, '=SUM(W10:W'.($i -1).')');
                            $objPHPExcel->getActiveSheet()->setCellValue('X'.$i, '=SUM(X10:X'.($i -1).')');
                        }
                        $objPHPExcel->getActiveSheet()->setCellValue('Z'.$i, '=W'.$i.'/X'.$i);
                        $objPHPExcel->getActiveSheet()->setCellValue('AA'.$i, '=SUM(AA10:AA'.($i -1).')');
                        $objPHPExcel->getActiveSheet()->setCellValue('AC'.$i, '=SUM(AC10:AC'.($i -1).')');
                        
                        $sheet->getStyle('X10:X'.$i)->getNumberFormat()->setFormatCode('0.00'); 
                        $sheet->getStyle('Z10:AA'.$i)->getNumberFormat()->setFormatCode('0.00'); 
                        $sheet->getStyle('AC10:AE'.$i)->getNumberFormat()->setFormatCode('0.00'); 
                        
                        $objPHPExcel->getActiveSheet()->getStyle('R10:S'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('T10:T'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('U10:X'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('Y10:Y'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('Z10:AA'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('AB10:AB'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('AC10:AE'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                        $objPHPExcel->getActiveSheet()->setCellValue('AD'.$i, '=SUM(AD10:AD'.($i -1).')');
                        $objPHPExcel->getActiveSheet()->setCellValue('AE'.$i, '=SUM(AE10:AE'.($i -1).')');
                        $sheet->getStyle('A'.$i.':AE'.$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));
                        $sheet->getStyle('A10:AE'.$i)->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));

                    }


























                    
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

}else if($PDFMONTH != "") {  
    $mpdf = new mPDF('', 'A4-L', '', '', 15, 15,40); 

    $style = '<style>body{font-family: "angsana";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย}</style>';
    $defualt_header = '<table width="100%">
                            <tbody>
                                <tr>
                                    <td colspan="3.5" style="width:25%;border:0px solid #000;"></td>
                                    <td colspan="1"   style="width:10%;border:0px solid #000;text-align:center;"><img src="../images/logonew.png" width="90" height="90"></td>
                                    <td colspan="1"   style="width:30%;border:0px solid #000;font-size:15px;text-align:center;">'.$recomth.'<br>'.$recomen.'<br>'.$recomadd.'<br>สรุปโครงการใช้น้ำมันรายบุคคลประจำเดือน '.$selectmonth.' '.$start_yth.'<br>สายงาน '.$selcustomer2.'</td>
                                    <td colspan="4.5" style="width:35%;border:0px solid #000;"></td>
                                </tr>
                            </tbody>
                        </table>';
    $table = '<table style="border-collapse: collapse;font-size:13px" width="100%">
                <thead>
                    <tr>
                        <td rowspan="2" style="background-color: #bfbfbf;width:5%;border:1px solid #000;padding:3px;text-align:center">ลำดับ</td>
                        <td rowspan="2" style="background-color: #bfbfbf;width:5%;border:1px solid #000;padding:3px;text-align:center">รหัส</div></td>
                        <td rowspan="2" style="background-color: #bfbfbf;width:10%;border:1px solid #000;padding:3px;text-align:center">ชื่อ</div></td>
                        <td rowspan="2" style="background-color: #bfbfbf;width:10%;border:1px solid #000;padding:3px;text-align:center">สกุล</div></td>
                        <td rowspan="2" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">ทะเบียนรถ</div></td>
                        <td rowspan="2" style="background-color: #bfbfbf;width: 7%;border:1px solid #000;padding:3px;text-align:center">ประเภทรถ</div></td>
                        <td rowspan="2" style="background-color: #bfbfbf;width:6%;border:1px solid #000;padding:3px;text-align:center">จำนวนเที่ยวที่วิ่งงาน</div></td>
                        <td rowspan="2" style="background-color: #bfbfbf;width:10%;border:1px solid #000;padding:3px;text-align:center">งานที่ขนส่ง</div></td>
                        <td rowspan="1" colspan="9" style="background-color: #bfbfbf;width:15%;border:1px solid #000;padding:3px;text-align:center">OTHER</div></td>
                        <td rowspan="2" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">รวมน้ำมัน</div></td>
                        <td rowspan="2" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">รวมเงิน</div></td>
                    </tr>
                    <tr>
                    <td colspan="1" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">ไมล์ต้น</div></td>
                    <td colspan="1" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">ไมล์ปลาย</div></td>
                    <td colspan="1" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">ระยะทาง</div></td>
                    <td colspan="1" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">น้ำมันที่เติม</div></td>
                    <td colspan="1" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">ค่าเฉลี่ยที่กำหนด</div></td>
                    <td colspan="1" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">ค่าเฉลี่ยที่ได้</div></td>
                    <td colspan="1" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">จำนวนน้ำมันเกินกว่ากำหนด</div></td>
                    <td colspan="1" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">จำนวนบาท/ลิตร</div></td>
                    <td colspan="1" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">จำนวนเงินที่ได้/บาท</div></td>
                    </tr>
                </thead><tbody>';          
    $table_footer = '<table style="width: 100%;">
                        <tbody>
                            <tr>
                                <td colspan="4">&nbsp;&nbsp;&nbsp; แก้ไขครั้งที่:01&nbsp;&nbsp;&nbsp;มีผลบังคับใช้:16-02-66</td>
                            </tr>
                        </tbody>
                    </table>';
            
    $work_sheet=0;
    $countday = round(abs(strtotime("$start_ymd") - strtotime("$end_ymd"))/60/60/24);
	while (strtotime($start_ymd) <= strtotime($end_ymd)) {
        $day = explode("-", $start_ymd);
        $chkday = $day[2];
        // echo "$chkday<br>";
        $start_ymd = date ("Y-m-d", strtotime("+1 day", strtotime($start_ymd)));
        // echo "12123<br>";

        $mpdf->WriteHTML($style);
        $mpdf->SetHTMLHeader($defualt_header, 'O', true);
        $mpdf->SetHTMLFooter($table_footer);
        // $mpdf->WriteHTML($table_footer1);

        if($chkday=="01"){      
            $datedata_stm01 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm01 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-01'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm01 = sqlsrv_query($conn, $sql_stm01 );
                $result_stm01 = sqlsrv_fetch_array($query_stm01, SQLSRV_FETCH_ASSOC);
                $OID_stm01=$result_stm01["OID"];
                $number_stm01 = 10;  
            if($OID_stm01!=""){   
                            while($result_stm01 = sqlsrv_fetch_array($query_stm01)) {      
                                    $pieces_stm01 = explode(" ", $result_stm01["EMPN"]);
                                    $fname_stm01=$pieces_stm01[0];
                                    $lname_stm01=$pieces_stm01[1];
                                    $EMPC_stm01=$result_stm01["EMPC"];
                                    $VHCRGNB_stm01=$result_stm01["VHCRGNB"];
                                    $CARTYPE_stm01=$result_stm01["CARTYPE"];
                                    $JOBEND_stm01=$result_stm01["JOBEND"];
                                    $MST_stm01=$result_stm01["MST"];
                                    $MSE_stm01=$result_stm01["MLE"];
                                    $OAM_stm01=$result_stm01["OAM"];
                                    $OTG_stm01=$result_stm01["OTG"];
                                    $CAL1_stm01=$MSE_stm01-$MST_stm01;
                                    $RSDTE_stm01=number_format($CAL1_stm01, 2);
                                    $CAL2_stm01=$CAL1_stm01/$OAM_stm01;
                                    $RSOAVG_stm01=number_format($CAL2_stm01, 2);
                                    $CAL3_stm01=($CAL1_stm01/$OTG_stm01)-$OAM_stm01;
                                    $RSOVER_stm01=number_format($CAL3_stm01, 2);
                                    $PRICE_stm01=$result_chkprice["PRICE"];
                                    $CAL4_stm01=$RSOVER_stm01*$PRICE_stm01;
                                    $RSPRICE_stm01=number_format($CAL4_stm01, 2);
                                    $CAL5_stm01=$OAM_stm01*1;
                                    $CAL6_stm01=$RSPRICE_stm01*1;
                                    
                                    $RDTE_stm01=$RSDTE_stm01;    
                                        $QRDTE_stm01=$QRDTE_stm01+$RDTE_stm01;       
                                    $ROAM_stm01=$OAM_stm01;
                                        $QROAM_stm01=$QROAM_stm01+$ROAM_stm01;     
                                    $ROTG_stm01=$OTG_stm01; 
                                    $QCALOAM_stm01=(($RDTE_stm01/$ROTG_stm01)-$ROAM_stm01);     
                                        $QRCALOAM_stm01=$QRCALOAM_stm01+$QCALOAM_stm01; 
                                    $RC3_stm01=$RSPRICE_stm01;    
                                        $QRC3_stm01=$QRC3_stm01+$RC3_stm01;   
                                    $arr_stm01[] = $RSOAVG_stm01;    
                                $SQLCHK_stm01="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm01'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-01'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm01 = sqlsrv_query($conn, $SQLCHK_stm01 );
                                    while($RSCHK_stm01 = sqlsrv_fetch_array($QUERYCHK_stm01)) { 
                                    $ROUND_stm01=$RSCHK_stm01["ROUND"]; 

                $tbody_stm01 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm01.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm01.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm01.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm01.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm01.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm01.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm01.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm01.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm01.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm01.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm01.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm01.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm01.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm01.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm01.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm01.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm01.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm01.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm01.'</td>
                            </tr>';                   
                            $number_stm01++;
                            } }  
                            $TOTALDTE_stm01=$QRDTE_stm01;
                            $TOTALOAM_stm01=$QROAM_stm01;  
                            $TOTALCALOAM_stm01=$QRCALOAM_stm01;  
                            $TOTALC3_stm01=$QRC3_stm01; 
                            function Average_stm01($arr_stm01) {
                                $array_size_stm01 = count($arr_stm01);                
                                $total_stm01 = 0;
                                for ($number_stm01 = 0; $number_stm01 < $array_size_stm01; $number_stm01++) {
                                    $total_stm01 += $arr_stm01[$number_stm01];
                                }                
                                $AVERAGE_stm01 = (float)($total_stm01 / $array_size_stm01);
                                return $AVERAGE_stm01;
                            }        
                $tfoot_stm01 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm01, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm01, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm01($arr_stm01), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm01, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm01, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm01, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm01, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm01 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm01 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm01 = '</table>';    
            $mpdf->WriteHTML($datedata_stm01);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm01);
            $mpdf->WriteHTML($tfoot_stm01);
            $mpdf->WriteHTML($table_end_stm01); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="02"){      
            $datedata_stm02 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm02 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-02'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm02 = sqlsrv_query($conn, $sql_stm02 );
                $result_stm02 = sqlsrv_fetch_array($query_stm02, SQLSRV_FETCH_ASSOC);
                $OID_stm02=$result_stm02["OID"];
                $number_stm02 = 10;  
            if($OID_stm02!=""){   
                            while($result_stm02 = sqlsrv_fetch_array($query_stm02)) {      
                                    $pieces_stm02 = explode(" ", $result_stm02["EMPN"]);
                                    $fname_stm02=$pieces_stm02[0];
                                    $lname_stm02=$pieces_stm02[1];
                                    $EMPC_stm02=$result_stm02["EMPC"];
                                    $VHCRGNB_stm02=$result_stm02["VHCRGNB"];
                                    $CARTYPE_stm02=$result_stm02["CARTYPE"];
                                    $JOBEND_stm02=$result_stm02["JOBEND"];
                                    $MST_stm02=$result_stm02["MST"];
                                    $MSE_stm02=$result_stm02["MLE"];
                                    $OAM_stm02=$result_stm02["OAM"];
                                    $OTG_stm02=$result_stm02["OTG"];
                                    $CAL1_stm02=$MSE_stm02-$MST_stm02;
                                    $RSDTE_stm02=number_format($CAL1_stm02, 2);
                                    $CAL2_stm02=$CAL1_stm02/$OAM_stm02;
                                    $RSOAVG_stm02=number_format($CAL2_stm02, 2);
                                    $CAL3_stm02=($CAL1_stm02/$OTG_stm02)-$OAM_stm02;
                                    $RSOVER_stm02=number_format($CAL3_stm02, 2);
                                    $PRICE_stm02=$result_chkprice["PRICE"];
                                    $CAL4_stm02=$RSOVER_stm02*$PRICE_stm02;
                                    $RSPRICE_stm02=number_format($CAL4_stm02, 2);
                                    $CAL5_stm02=$OAM_stm02*1;
                                    $CAL6_stm02=$RSPRICE_stm02*1;
                                    
                                    $RDTE_stm02=$RSDTE_stm02;    
                                        $QRDTE_stm02=$QRDTE_stm02+$RDTE_stm02;       
                                    $ROAM_stm02=$OAM_stm02;
                                        $QROAM_stm02=$QROAM_stm02+$ROAM_stm02;     
                                    $ROTG_stm02=$OTG_stm02; 
                                    $QCALOAM_stm02=(($RDTE_stm02/$ROTG_stm02)-$ROAM_stm02);     
                                        $QRCALOAM_stm02=$QRCALOAM_stm02+$QCALOAM_stm02; 
                                    $RC3_stm02=$RSPRICE_stm02;    
                                        $QRC3_stm02=$QRC3_stm02+$RC3_stm02;   
                                    $arr_stm02[] = $RSOAVG_stm02;    
                                $SQLCHK_stm02="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm02'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-02'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm02 = sqlsrv_query($conn, $SQLCHK_stm02 );
                                    while($RSCHK_stm02 = sqlsrv_fetch_array($QUERYCHK_stm02)) { 
                                    $ROUND_stm02=$RSCHK_stm02["ROUND"]; 

                $tbody_stm02 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm02.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm02.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm02.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm02.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm02.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm02.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm02.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm02.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm02.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm02.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm02.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm02.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm02.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm02.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm02.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm02.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm02.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm02.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm02.'</td>
                            </tr>';                   
                            $number_stm02++;
                            } }  
                            $TOTALDTE_stm02=$QRDTE_stm02;
                            $TOTALOAM_stm02=$QROAM_stm02;  
                            $TOTALCALOAM_stm02=$QRCALOAM_stm02;  
                            $TOTALC3_stm02=$QRC3_stm02; 
                            function Average_stm02($arr_stm02) {
                                $array_size_stm02 = count($arr_stm02);                
                                $total_stm02 = 0;
                                for ($number_stm02 = 0; $number_stm02 < $array_size_stm02; $number_stm02++) {
                                    $total_stm02 += $arr_stm02[$number_stm02];
                                }                
                                $AVERAGE_stm02 = (float)($total_stm02 / $array_size_stm02);
                                return $AVERAGE_stm02;
                            }        
                $tfoot_stm02 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm02, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm02, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm02($arr_stm02), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm02, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm02, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm02, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm02, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm02 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm02 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm02 = '</table>';    
            $mpdf->WriteHTML($datedata_stm02);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm02);
            $mpdf->WriteHTML($tfoot_stm02);
            $mpdf->WriteHTML($table_end_stm02); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="03"){      
            $datedata_stm03 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm03 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-03'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm03 = sqlsrv_query($conn, $sql_stm03 );
                $result_stm03 = sqlsrv_fetch_array($query_stm03, SQLSRV_FETCH_ASSOC);
                $OID_stm03=$result_stm03["OID"];
                $number_stm03 = 10;  
            if($OID_stm03!=""){   
                            while($result_stm03 = sqlsrv_fetch_array($query_stm03)) {      
                                    $pieces_stm03 = explode(" ", $result_stm03["EMPN"]);
                                    $fname_stm03=$pieces_stm03[0];
                                    $lname_stm03=$pieces_stm03[1];
                                    $EMPC_stm03=$result_stm03["EMPC"];
                                    $VHCRGNB_stm03=$result_stm03["VHCRGNB"];
                                    $CARTYPE_stm03=$result_stm03["CARTYPE"];
                                    $JOBEND_stm03=$result_stm03["JOBEND"];
                                    $MST_stm03=$result_stm03["MST"];
                                    $MSE_stm03=$result_stm03["MLE"];
                                    $OAM_stm03=$result_stm03["OAM"];
                                    $OTG_stm03=$result_stm03["OTG"];
                                    $CAL1_stm03=$MSE_stm03-$MST_stm03;
                                    $RSDTE_stm03=number_format($CAL1_stm03, 2);
                                    $CAL2_stm03=$CAL1_stm03/$OAM_stm03;
                                    $RSOAVG_stm03=number_format($CAL2_stm03, 2);
                                    $CAL3_stm03=($CAL1_stm03/$OTG_stm03)-$OAM_stm03;
                                    $RSOVER_stm03=number_format($CAL3_stm03, 2);
                                    $PRICE_stm03=$result_chkprice["PRICE"];
                                    $CAL4_stm03=$RSOVER_stm03*$PRICE_stm03;
                                    $RSPRICE_stm03=number_format($CAL4_stm03, 2);
                                    $CAL5_stm03=$OAM_stm03*1;
                                    $CAL6_stm03=$RSPRICE_stm03*1;
                                    
                                    $RDTE_stm03=$RSDTE_stm03;    
                                        $QRDTE_stm03=$QRDTE_stm03+$RDTE_stm03;       
                                    $ROAM_stm03=$OAM_stm03;
                                        $QROAM_stm03=$QROAM_stm03+$ROAM_stm03;     
                                    $ROTG_stm03=$OTG_stm03; 
                                    $QCALOAM_stm03=(($RDTE_stm03/$ROTG_stm03)-$ROAM_stm03);     
                                        $QRCALOAM_stm03=$QRCALOAM_stm03+$QCALOAM_stm03; 
                                    $RC3_stm03=$RSPRICE_stm03;    
                                        $QRC3_stm03=$QRC3_stm03+$RC3_stm03;   
                                    $arr_stm03[] = $RSOAVG_stm03;    
                                $SQLCHK_stm03="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm03'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-03'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm03 = sqlsrv_query($conn, $SQLCHK_stm03 );
                                    while($RSCHK_stm03 = sqlsrv_fetch_array($QUERYCHK_stm03)) { 
                                    $ROUND_stm03=$RSCHK_stm03["ROUND"]; 

                $tbody_stm03 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm03.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm03.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm03.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm03.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm03.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm03.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm03.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm03.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm03.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm03.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm03.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm03.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm03.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm03.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm03.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm03.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm03.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm03.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm03.'</td>
                            </tr>';                   
                            $number_stm03++;
                            } }  
                            $TOTALDTE_stm03=$QRDTE_stm03;
                            $TOTALOAM_stm03=$QROAM_stm03;  
                            $TOTALCALOAM_stm03=$QRCALOAM_stm03;  
                            $TOTALC3_stm03=$QRC3_stm03; 
                            function Average_stm03($arr_stm03) {
                                $array_size_stm03 = count($arr_stm03);                
                                $total_stm03 = 0;
                                for ($number_stm03 = 0; $number_stm03 < $array_size_stm03; $number_stm03++) {
                                    $total_stm03 += $arr_stm03[$number_stm03];
                                }                
                                $AVERAGE_stm03 = (float)($total_stm03 / $array_size_stm03);
                                return $AVERAGE_stm03;
                            }        
                $tfoot_stm03 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm03, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm03, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm03($arr_stm03), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm03, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm03, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm03, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm03, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm03 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm03 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm03 = '</table>';    
            $mpdf->WriteHTML($datedata_stm03);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm03);
            $mpdf->WriteHTML($tfoot_stm03);
            $mpdf->WriteHTML($table_end_stm03); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="04"){      
            $datedata_stm04 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm04 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-04'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm04 = sqlsrv_query($conn, $sql_stm04 );
                $result_stm04 = sqlsrv_fetch_array($query_stm04, SQLSRV_FETCH_ASSOC);
                $OID_stm04=$result_stm04["OID"];
                $number_stm04 = 10;  
            if($OID_stm04!=""){   
                            while($result_stm04 = sqlsrv_fetch_array($query_stm04)) {      
                                    $pieces_stm04 = explode(" ", $result_stm04["EMPN"]);
                                    $fname_stm04=$pieces_stm04[0];
                                    $lname_stm04=$pieces_stm04[1];
                                    $EMPC_stm04=$result_stm04["EMPC"];
                                    $VHCRGNB_stm04=$result_stm04["VHCRGNB"];
                                    $CARTYPE_stm04=$result_stm04["CARTYPE"];
                                    $JOBEND_stm04=$result_stm04["JOBEND"];
                                    $MST_stm04=$result_stm04["MST"];
                                    $MSE_stm04=$result_stm04["MLE"];
                                    $OAM_stm04=$result_stm04["OAM"];
                                    $OTG_stm04=$result_stm04["OTG"];
                                    $CAL1_stm04=$MSE_stm04-$MST_stm04;
                                    $RSDTE_stm04=number_format($CAL1_stm04, 2);
                                    $CAL2_stm04=$CAL1_stm04/$OAM_stm04;
                                    $RSOAVG_stm04=number_format($CAL2_stm04, 2);
                                    $CAL3_stm04=($CAL1_stm04/$OTG_stm04)-$OAM_stm04;
                                    $RSOVER_stm04=number_format($CAL3_stm04, 2);
                                    $PRICE_stm04=$result_chkprice["PRICE"];
                                    $CAL4_stm04=$RSOVER_stm04*$PRICE_stm04;
                                    $RSPRICE_stm04=number_format($CAL4_stm04, 2);
                                    $CAL5_stm04=$OAM_stm04*1;
                                    $CAL6_stm04=$RSPRICE_stm04*1;
                                    
                                    $RDTE_stm04=$RSDTE_stm04;    
                                        $QRDTE_stm04=$QRDTE_stm04+$RDTE_stm04;       
                                    $ROAM_stm04=$OAM_stm04;
                                        $QROAM_stm04=$QROAM_stm04+$ROAM_stm04;     
                                    $ROTG_stm04=$OTG_stm04; 
                                    $QCALOAM_stm04=(($RDTE_stm04/$ROTG_stm04)-$ROAM_stm04);     
                                        $QRCALOAM_stm04=$QRCALOAM_stm04+$QCALOAM_stm04; 
                                    $RC3_stm04=$RSPRICE_stm04;    
                                        $QRC3_stm04=$QRC3_stm04+$RC3_stm04;   
                                    $arr_stm04[] = $RSOAVG_stm04;    
                                $SQLCHK_stm04="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm04'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-04'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm04 = sqlsrv_query($conn, $SQLCHK_stm04 );
                                    while($RSCHK_stm04 = sqlsrv_fetch_array($QUERYCHK_stm04)) { 
                                    $ROUND_stm04=$RSCHK_stm04["ROUND"]; 

                $tbody_stm04 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm04.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm04.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm04.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm04.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm04.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm04.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm04.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm04.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm04.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm04.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm04.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm04.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm04.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm04.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm04.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm04.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm04.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm04.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm04.'</td>
                            </tr>';                   
                            $number_stm04++;
                            } }  
                            $TOTALDTE_stm04=$QRDTE_stm04;
                            $TOTALOAM_stm04=$QROAM_stm04;  
                            $TOTALCALOAM_stm04=$QRCALOAM_stm04;  
                            $TOTALC3_stm04=$QRC3_stm04; 
                            function Average_stm04($arr_stm04) {
                                $array_size_stm04 = count($arr_stm04);                
                                $total_stm04 = 0;
                                for ($number_stm04 = 0; $number_stm04 < $array_size_stm04; $number_stm04++) {
                                    $total_stm04 += $arr_stm04[$number_stm04];
                                }                
                                $AVERAGE_stm04 = (float)($total_stm04 / $array_size_stm04);
                                return $AVERAGE_stm04;
                            }        
                $tfoot_stm04 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm04, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm04, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm04($arr_stm04), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm04, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm04, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm04, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm04, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm04 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm04 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm04 = '</table>';    
            $mpdf->WriteHTML($datedata_stm04);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm04);
            $mpdf->WriteHTML($tfoot_stm04);
            $mpdf->WriteHTML($table_end_stm04); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="05"){      
            $datedata_stm05 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm05 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-05'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm05 = sqlsrv_query($conn, $sql_stm05 );
                $result_stm05 = sqlsrv_fetch_array($query_stm05, SQLSRV_FETCH_ASSOC);
                $OID_stm05=$result_stm05["OID"];
                $number_stm05 = 10;  
            if($OID_stm05!=""){   
                            while($result_stm05 = sqlsrv_fetch_array($query_stm05)) {      
                                    $pieces_stm05 = explode(" ", $result_stm05["EMPN"]);
                                    $fname_stm05=$pieces_stm05[0];
                                    $lname_stm05=$pieces_stm05[1];
                                    $EMPC_stm05=$result_stm05["EMPC"];
                                    $VHCRGNB_stm05=$result_stm05["VHCRGNB"];
                                    $CARTYPE_stm05=$result_stm05["CARTYPE"];
                                    $JOBEND_stm05=$result_stm05["JOBEND"];
                                    $MST_stm05=$result_stm05["MST"];
                                    $MSE_stm05=$result_stm05["MLE"];
                                    $OAM_stm05=$result_stm05["OAM"];
                                    $OTG_stm05=$result_stm05["OTG"];
                                    $CAL1_stm05=$MSE_stm05-$MST_stm05;
                                    $RSDTE_stm05=number_format($CAL1_stm05, 2);
                                    $CAL2_stm05=$CAL1_stm05/$OAM_stm05;
                                    $RSOAVG_stm05=number_format($CAL2_stm05, 2);
                                    $CAL3_stm05=($CAL1_stm05/$OTG_stm05)-$OAM_stm05;
                                    $RSOVER_stm05=number_format($CAL3_stm05, 2);
                                    $PRICE_stm05=$result_chkprice["PRICE"];
                                    $CAL4_stm05=$RSOVER_stm05*$PRICE_stm05;
                                    $RSPRICE_stm05=number_format($CAL4_stm05, 2);
                                    $CAL5_stm05=$OAM_stm05*1;
                                    $CAL6_stm05=$RSPRICE_stm05*1;
                                    
                                    $RDTE_stm05=$RSDTE_stm05;    
                                        $QRDTE_stm05=$QRDTE_stm05+$RDTE_stm05;       
                                    $ROAM_stm05=$OAM_stm05;
                                        $QROAM_stm05=$QROAM_stm05+$ROAM_stm05;     
                                    $ROTG_stm05=$OTG_stm05; 
                                    $QCALOAM_stm05=(($RDTE_stm05/$ROTG_stm05)-$ROAM_stm05);     
                                        $QRCALOAM_stm05=$QRCALOAM_stm05+$QCALOAM_stm05; 
                                    $RC3_stm05=$RSPRICE_stm05;    
                                        $QRC3_stm05=$QRC3_stm05+$RC3_stm05;   
                                    $arr_stm05[] = $RSOAVG_stm05;    
                                $SQLCHK_stm05="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm05'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-05'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm05 = sqlsrv_query($conn, $SQLCHK_stm05 );
                                    while($RSCHK_stm05 = sqlsrv_fetch_array($QUERYCHK_stm05)) { 
                                    $ROUND_stm05=$RSCHK_stm05["ROUND"]; 

                $tbody_stm05 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm05.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm05.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm05.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm05.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm05.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm05.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm05.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm05.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm05.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm05.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm05.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm05.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm05.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm05.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm05.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm05.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm05.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm05.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm05.'</td>
                            </tr>';                   
                            $number_stm05++;
                            } }  
                            $TOTALDTE_stm05=$QRDTE_stm05;
                            $TOTALOAM_stm05=$QROAM_stm05;  
                            $TOTALCALOAM_stm05=$QRCALOAM_stm05;  
                            $TOTALC3_stm05=$QRC3_stm05; 
                            function Average_stm05($arr_stm05) {
                                $array_size_stm05 = count($arr_stm05);                
                                $total_stm05 = 0;
                                for ($number_stm05 = 0; $number_stm05 < $array_size_stm05; $number_stm05++) {
                                    $total_stm05 += $arr_stm05[$number_stm05];
                                }                
                                $AVERAGE_stm05 = (float)($total_stm05 / $array_size_stm05);
                                return $AVERAGE_stm05;
                            }        
                $tfoot_stm05 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm05, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm05, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm05($arr_stm05), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm05, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm05, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm05, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm05, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm05 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm05 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm05 = '</table>';    
            $mpdf->WriteHTML($datedata_stm05);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm05);
            $mpdf->WriteHTML($tfoot_stm05);
            $mpdf->WriteHTML($table_end_stm05); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="06"){      
            $datedata_stm06 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm06 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-06'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm06 = sqlsrv_query($conn, $sql_stm06 );
                $result_stm06 = sqlsrv_fetch_array($query_stm06, SQLSRV_FETCH_ASSOC);
                $OID_stm06=$result_stm06["OID"];
                $number_stm06 = 10;  
            if($OID_stm06!=""){   
                            while($result_stm06 = sqlsrv_fetch_array($query_stm06)) {      
                                    $pieces_stm06 = explode(" ", $result_stm06["EMPN"]);
                                    $fname_stm06=$pieces_stm06[0];
                                    $lname_stm06=$pieces_stm06[1];
                                    $EMPC_stm06=$result_stm06["EMPC"];
                                    $VHCRGNB_stm06=$result_stm06["VHCRGNB"];
                                    $CARTYPE_stm06=$result_stm06["CARTYPE"];
                                    $JOBEND_stm06=$result_stm06["JOBEND"];
                                    $MST_stm06=$result_stm06["MST"];
                                    $MSE_stm06=$result_stm06["MLE"];
                                    $OAM_stm06=$result_stm06["OAM"];
                                    $OTG_stm06=$result_stm06["OTG"];
                                    $CAL1_stm06=$MSE_stm06-$MST_stm06;
                                    $RSDTE_stm06=number_format($CAL1_stm06, 2);
                                    $CAL2_stm06=$CAL1_stm06/$OAM_stm06;
                                    $RSOAVG_stm06=number_format($CAL2_stm06, 2);
                                    $CAL3_stm06=($CAL1_stm06/$OTG_stm06)-$OAM_stm06;
                                    $RSOVER_stm06=number_format($CAL3_stm06, 2);
                                    $PRICE_stm06=$result_chkprice["PRICE"];
                                    $CAL4_stm06=$RSOVER_stm06*$PRICE_stm06;
                                    $RSPRICE_stm06=number_format($CAL4_stm06, 2);
                                    $CAL5_stm06=$OAM_stm06*1;
                                    $CAL6_stm06=$RSPRICE_stm06*1;
                                    
                                    $RDTE_stm06=$RSDTE_stm06;    
                                        $QRDTE_stm06=$QRDTE_stm06+$RDTE_stm06;       
                                    $ROAM_stm06=$OAM_stm06;
                                        $QROAM_stm06=$QROAM_stm06+$ROAM_stm06;     
                                    $ROTG_stm06=$OTG_stm06; 
                                    $QCALOAM_stm06=(($RDTE_stm06/$ROTG_stm06)-$ROAM_stm06);     
                                        $QRCALOAM_stm06=$QRCALOAM_stm06+$QCALOAM_stm06; 
                                    $RC3_stm06=$RSPRICE_stm06;    
                                        $QRC3_stm06=$QRC3_stm06+$RC3_stm06;   
                                    $arr_stm06[] = $RSOAVG_stm06;    
                                $SQLCHK_stm06="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm06'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-06'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm06 = sqlsrv_query($conn, $SQLCHK_stm06 );
                                    while($RSCHK_stm06 = sqlsrv_fetch_array($QUERYCHK_stm06)) { 
                                    $ROUND_stm06=$RSCHK_stm06["ROUND"]; 

                $tbody_stm06 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm06.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm06.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm06.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm06.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm06.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm06.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm06.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm06.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm06.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm06.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm06.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm06.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm06.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm06.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm06.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm06.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm06.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm06.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm06.'</td>
                            </tr>';                   
                            $number_stm06++;
                            } }  
                            $TOTALDTE_stm06=$QRDTE_stm06;
                            $TOTALOAM_stm06=$QROAM_stm06;  
                            $TOTALCALOAM_stm06=$QRCALOAM_stm06;  
                            $TOTALC3_stm06=$QRC3_stm06; 
                            function Average_stm06($arr_stm06) {
                                $array_size_stm06 = count($arr_stm06);                
                                $total_stm06 = 0;
                                for ($number_stm06 = 0; $number_stm06 < $array_size_stm06; $number_stm06++) {
                                    $total_stm06 += $arr_stm06[$number_stm06];
                                }                
                                $AVERAGE_stm06 = (float)($total_stm06 / $array_size_stm06);
                                return $AVERAGE_stm06;
                            }        
                $tfoot_stm06 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm06, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm06, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm06($arr_stm06), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm06, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm06, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm06, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm06, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm06 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm06 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm06 = '</table>';    
            $mpdf->WriteHTML($datedata_stm06);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm06);
            $mpdf->WriteHTML($tfoot_stm06);
            $mpdf->WriteHTML($table_end_stm06); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="07"){      
            $datedata_stm07 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm07 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-07'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm07 = sqlsrv_query($conn, $sql_stm07 );
                $result_stm07 = sqlsrv_fetch_array($query_stm07, SQLSRV_FETCH_ASSOC);
                $OID_stm07=$result_stm07["OID"];
                $number_stm07 = 10;  
            if($OID_stm07!=""){   
                            while($result_stm07 = sqlsrv_fetch_array($query_stm07)) {      
                                    $pieces_stm07 = explode(" ", $result_stm07["EMPN"]);
                                    $fname_stm07=$pieces_stm07[0];
                                    $lname_stm07=$pieces_stm07[1];
                                    $EMPC_stm07=$result_stm07["EMPC"];
                                    $VHCRGNB_stm07=$result_stm07["VHCRGNB"];
                                    $CARTYPE_stm07=$result_stm07["CARTYPE"];
                                    $JOBEND_stm07=$result_stm07["JOBEND"];
                                    $MST_stm07=$result_stm07["MST"];
                                    $MSE_stm07=$result_stm07["MLE"];
                                    $OAM_stm07=$result_stm07["OAM"];
                                    $OTG_stm07=$result_stm07["OTG"];
                                    $CAL1_stm07=$MSE_stm07-$MST_stm07;
                                    $RSDTE_stm07=number_format($CAL1_stm07, 2);
                                    $CAL2_stm07=$CAL1_stm07/$OAM_stm07;
                                    $RSOAVG_stm07=number_format($CAL2_stm07, 2);
                                    $CAL3_stm07=($CAL1_stm07/$OTG_stm07)-$OAM_stm07;
                                    $RSOVER_stm07=number_format($CAL3_stm07, 2);
                                    $PRICE_stm07=$result_chkprice["PRICE"];
                                    $CAL4_stm07=$RSOVER_stm07*$PRICE_stm07;
                                    $RSPRICE_stm07=number_format($CAL4_stm07, 2);
                                    $CAL5_stm07=$OAM_stm07*1;
                                    $CAL6_stm07=$RSPRICE_stm07*1;
                                    
                                    $RDTE_stm07=$RSDTE_stm07;    
                                        $QRDTE_stm07=$QRDTE_stm07+$RDTE_stm07;       
                                    $ROAM_stm07=$OAM_stm07;
                                        $QROAM_stm07=$QROAM_stm07+$ROAM_stm07;     
                                    $ROTG_stm07=$OTG_stm07; 
                                    $QCALOAM_stm07=(($RDTE_stm07/$ROTG_stm07)-$ROAM_stm07);     
                                        $QRCALOAM_stm07=$QRCALOAM_stm07+$QCALOAM_stm07; 
                                    $RC3_stm07=$RSPRICE_stm07;    
                                        $QRC3_stm07=$QRC3_stm07+$RC3_stm07;   
                                    $arr_stm07[] = $RSOAVG_stm07;    
                                $SQLCHK_stm07="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm07'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-07'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm07 = sqlsrv_query($conn, $SQLCHK_stm07 );
                                    while($RSCHK_stm07 = sqlsrv_fetch_array($QUERYCHK_stm07)) { 
                                    $ROUND_stm07=$RSCHK_stm07["ROUND"]; 

                $tbody_stm07 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm07.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm07.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm07.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm07.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm07.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm07.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm07.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm07.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm07.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm07.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm07.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm07.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm07.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm07.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm07.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm07.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm07.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm07.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm07.'</td>
                            </tr>';                   
                            $number_stm07++;
                            } }  
                            $TOTALDTE_stm07=$QRDTE_stm07;
                            $TOTALOAM_stm07=$QROAM_stm07;  
                            $TOTALCALOAM_stm07=$QRCALOAM_stm07;  
                            $TOTALC3_stm07=$QRC3_stm07; 
                            function Average_stm07($arr_stm07) {
                                $array_size_stm07 = count($arr_stm07);                
                                $total_stm07 = 0;
                                for ($number_stm07 = 0; $number_stm07 < $array_size_stm07; $number_stm07++) {
                                    $total_stm07 += $arr_stm07[$number_stm07];
                                }                
                                $AVERAGE_stm07 = (float)($total_stm07 / $array_size_stm07);
                                return $AVERAGE_stm07;
                            }        
                $tfoot_stm07 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm07, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm07, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm07($arr_stm07), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm07, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm07, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm07, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm07, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm07 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm07 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm07 = '</table>';    
            $mpdf->WriteHTML($datedata_stm07);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm07);
            $mpdf->WriteHTML($tfoot_stm07);
            $mpdf->WriteHTML($table_end_stm07); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="08"){      
            $datedata_stm08 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm08 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-08'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm08 = sqlsrv_query($conn, $sql_stm08 );
                $result_stm08 = sqlsrv_fetch_array($query_stm08, SQLSRV_FETCH_ASSOC);
                $OID_stm08=$result_stm08["OID"];
                $number_stm08 = 10;  
            if($OID_stm08!=""){   
                            while($result_stm08 = sqlsrv_fetch_array($query_stm08)) {      
                                    $pieces_stm08 = explode(" ", $result_stm08["EMPN"]);
                                    $fname_stm08=$pieces_stm08[0];
                                    $lname_stm08=$pieces_stm08[1];
                                    $EMPC_stm08=$result_stm08["EMPC"];
                                    $VHCRGNB_stm08=$result_stm08["VHCRGNB"];
                                    $CARTYPE_stm08=$result_stm08["CARTYPE"];
                                    $JOBEND_stm08=$result_stm08["JOBEND"];
                                    $MST_stm08=$result_stm08["MST"];
                                    $MSE_stm08=$result_stm08["MLE"];
                                    $OAM_stm08=$result_stm08["OAM"];
                                    $OTG_stm08=$result_stm08["OTG"];
                                    $CAL1_stm08=$MSE_stm08-$MST_stm08;
                                    $RSDTE_stm08=number_format($CAL1_stm08, 2);
                                    $CAL2_stm08=$CAL1_stm08/$OAM_stm08;
                                    $RSOAVG_stm08=number_format($CAL2_stm08, 2);
                                    $CAL3_stm08=($CAL1_stm08/$OTG_stm08)-$OAM_stm08;
                                    $RSOVER_stm08=number_format($CAL3_stm08, 2);
                                    $PRICE_stm08=$result_chkprice["PRICE"];
                                    $CAL4_stm08=$RSOVER_stm08*$PRICE_stm08;
                                    $RSPRICE_stm08=number_format($CAL4_stm08, 2);
                                    $CAL5_stm08=$OAM_stm08*1;
                                    $CAL6_stm08=$RSPRICE_stm08*1;
                                    
                                    $RDTE_stm08=$RSDTE_stm08;    
                                        $QRDTE_stm08=$QRDTE_stm08+$RDTE_stm08;       
                                    $ROAM_stm08=$OAM_stm08;
                                        $QROAM_stm08=$QROAM_stm08+$ROAM_stm08;     
                                    $ROTG_stm08=$OTG_stm08; 
                                    $QCALOAM_stm08=(($RDTE_stm08/$ROTG_stm08)-$ROAM_stm08);     
                                        $QRCALOAM_stm08=$QRCALOAM_stm08+$QCALOAM_stm08; 
                                    $RC3_stm08=$RSPRICE_stm08;    
                                        $QRC3_stm08=$QRC3_stm08+$RC3_stm08;   
                                    $arr_stm08[] = $RSOAVG_stm08;    
                                $SQLCHK_stm08="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm08'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-08'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm08 = sqlsrv_query($conn, $SQLCHK_stm08 );
                                    while($RSCHK_stm08 = sqlsrv_fetch_array($QUERYCHK_stm08)) { 
                                    $ROUND_stm08=$RSCHK_stm08["ROUND"]; 

                $tbody_stm08 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm08.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm08.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm08.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm08.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm08.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm08.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm08.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm08.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm08.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm08.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm08.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm08.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm08.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm08.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm08.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm08.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm08.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm08.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm08.'</td>
                            </tr>';                   
                            $number_stm08++;
                            } }  
                            $TOTALDTE_stm08=$QRDTE_stm08;
                            $TOTALOAM_stm08=$QROAM_stm08;  
                            $TOTALCALOAM_stm08=$QRCALOAM_stm08;  
                            $TOTALC3_stm08=$QRC3_stm08; 
                            function Average_stm08($arr_stm08) {
                                $array_size_stm08 = count($arr_stm08);                
                                $total_stm08 = 0;
                                for ($number_stm08 = 0; $number_stm08 < $array_size_stm08; $number_stm08++) {
                                    $total_stm08 += $arr_stm08[$number_stm08];
                                }                
                                $AVERAGE_stm08 = (float)($total_stm08 / $array_size_stm08);
                                return $AVERAGE_stm08;
                            }        
                $tfoot_stm08 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm08, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm08, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm08($arr_stm08), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm08, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm08, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm08, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm08, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm08 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm08 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm08 = '</table>';    
            $mpdf->WriteHTML($datedata_stm08);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm08);
            $mpdf->WriteHTML($tfoot_stm08);
            $mpdf->WriteHTML($table_end_stm08); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="09"){      
            $datedata_stm09 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm09 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-09'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm09 = sqlsrv_query($conn, $sql_stm09 );
                $result_stm09 = sqlsrv_fetch_array($query_stm09, SQLSRV_FETCH_ASSOC);
                $OID_stm09=$result_stm09["OID"];
                $number_stm09 = 10;  
            if($OID_stm09!=""){   
                            while($result_stm09 = sqlsrv_fetch_array($query_stm09)) {      
                                    $pieces_stm09 = explode(" ", $result_stm09["EMPN"]);
                                    $fname_stm09=$pieces_stm09[0];
                                    $lname_stm09=$pieces_stm09[1];
                                    $EMPC_stm09=$result_stm09["EMPC"];
                                    $VHCRGNB_stm09=$result_stm09["VHCRGNB"];
                                    $CARTYPE_stm09=$result_stm09["CARTYPE"];
                                    $JOBEND_stm09=$result_stm09["JOBEND"];
                                    $MST_stm09=$result_stm09["MST"];
                                    $MSE_stm09=$result_stm09["MLE"];
                                    $OAM_stm09=$result_stm09["OAM"];
                                    $OTG_stm09=$result_stm09["OTG"];
                                    $CAL1_stm09=$MSE_stm09-$MST_stm09;
                                    $RSDTE_stm09=number_format($CAL1_stm09, 2);
                                    $CAL2_stm09=$CAL1_stm09/$OAM_stm09;
                                    $RSOAVG_stm09=number_format($CAL2_stm09, 2);
                                    $CAL3_stm09=($CAL1_stm09/$OTG_stm09)-$OAM_stm09;
                                    $RSOVER_stm09=number_format($CAL3_stm09, 2);
                                    $PRICE_stm09=$result_chkprice["PRICE"];
                                    $CAL4_stm09=$RSOVER_stm09*$PRICE_stm09;
                                    $RSPRICE_stm09=number_format($CAL4_stm09, 2);
                                    $CAL5_stm09=$OAM_stm09*1;
                                    $CAL6_stm09=$RSPRICE_stm09*1;
                                    
                                    $RDTE_stm09=$RSDTE_stm09;    
                                        $QRDTE_stm09=$QRDTE_stm09+$RDTE_stm09;       
                                    $ROAM_stm09=$OAM_stm09;
                                        $QROAM_stm09=$QROAM_stm09+$ROAM_stm09;     
                                    $ROTG_stm09=$OTG_stm09; 
                                    $QCALOAM_stm09=(($RDTE_stm09/$ROTG_stm09)-$ROAM_stm09);     
                                        $QRCALOAM_stm09=$QRCALOAM_stm09+$QCALOAM_stm09; 
                                    $RC3_stm09=$RSPRICE_stm09;    
                                        $QRC3_stm09=$QRC3_stm09+$RC3_stm09;   
                                    $arr_stm09[] = $RSOAVG_stm09;    
                                $SQLCHK_stm09="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm09'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-09'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm09 = sqlsrv_query($conn, $SQLCHK_stm09 );
                                    while($RSCHK_stm09 = sqlsrv_fetch_array($QUERYCHK_stm09)) { 
                                    $ROUND_stm09=$RSCHK_stm09["ROUND"]; 

                $tbody_stm09 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm09.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm09.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm09.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm09.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm09.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm09.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm09.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm09.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm09.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm09.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm09.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm09.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm09.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm09.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm09.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm09.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm09.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm09.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm09.'</td>
                            </tr>';                   
                            $number_stm09++;
                            } }  
                            $TOTALDTE_stm09=$QRDTE_stm09;
                            $TOTALOAM_stm09=$QROAM_stm09;  
                            $TOTALCALOAM_stm09=$QRCALOAM_stm09;  
                            $TOTALC3_stm09=$QRC3_stm09; 
                            function Average_stm09($arr_stm09) {
                                $array_size_stm09 = count($arr_stm09);                
                                $total_stm09 = 0;
                                for ($number_stm09 = 0; $number_stm09 < $array_size_stm09; $number_stm09++) {
                                    $total_stm09 += $arr_stm09[$number_stm09];
                                }                
                                $AVERAGE_stm09 = (float)($total_stm09 / $array_size_stm09);
                                return $AVERAGE_stm09;
                            }        
                $tfoot_stm09 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm09, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm09, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm09($arr_stm09), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm09, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm09, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm09, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm09, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm09 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm09 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm09 = '</table>';    
            $mpdf->WriteHTML($datedata_stm09);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm09);
            $mpdf->WriteHTML($tfoot_stm09);
            $mpdf->WriteHTML($table_end_stm09); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="10"){      
            $datedata_stm10 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm10 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-10'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm10 = sqlsrv_query($conn, $sql_stm10 );
                $result_stm10 = sqlsrv_fetch_array($query_stm10, SQLSRV_FETCH_ASSOC);
                $OID_stm10=$result_stm10["OID"];
                $number_stm10 = 10;  
            if($OID_stm10!=""){   
                            while($result_stm10 = sqlsrv_fetch_array($query_stm10)) {      
                                    $pieces_stm10 = explode(" ", $result_stm10["EMPN"]);
                                    $fname_stm10=$pieces_stm10[0];
                                    $lname_stm10=$pieces_stm10[1];
                                    $EMPC_stm10=$result_stm10["EMPC"];
                                    $VHCRGNB_stm10=$result_stm10["VHCRGNB"];
                                    $CARTYPE_stm10=$result_stm10["CARTYPE"];
                                    $JOBEND_stm10=$result_stm10["JOBEND"];
                                    $MST_stm10=$result_stm10["MST"];
                                    $MSE_stm10=$result_stm10["MLE"];
                                    $OAM_stm10=$result_stm10["OAM"];
                                    $OTG_stm10=$result_stm10["OTG"];
                                    $CAL1_stm10=$MSE_stm10-$MST_stm10;
                                    $RSDTE_stm10=number_format($CAL1_stm10, 2);
                                    $CAL2_stm10=$CAL1_stm10/$OAM_stm10;
                                    $RSOAVG_stm10=number_format($CAL2_stm10, 2);
                                    $CAL3_stm10=($CAL1_stm10/$OTG_stm10)-$OAM_stm10;
                                    $RSOVER_stm10=number_format($CAL3_stm10, 2);
                                    $PRICE_stm10=$result_chkprice["PRICE"];
                                    $CAL4_stm10=$RSOVER_stm10*$PRICE_stm10;
                                    $RSPRICE_stm10=number_format($CAL4_stm10, 2);
                                    $CAL5_stm10=$OAM_stm10*1;
                                    $CAL6_stm10=$RSPRICE_stm10*1;
                                    
                                    $RDTE_stm10=$RSDTE_stm10;    
                                        $QRDTE_stm10=$QRDTE_stm10+$RDTE_stm10;       
                                    $ROAM_stm10=$OAM_stm10;
                                        $QROAM_stm10=$QROAM_stm10+$ROAM_stm10;     
                                    $ROTG_stm10=$OTG_stm10; 
                                    $QCALOAM_stm10=(($RDTE_stm10/$ROTG_stm10)-$ROAM_stm10);     
                                        $QRCALOAM_stm10=$QRCALOAM_stm10+$QCALOAM_stm10; 
                                    $RC3_stm10=$RSPRICE_stm10;    
                                        $QRC3_stm10=$QRC3_stm10+$RC3_stm10;   
                                    $arr_stm10[] = $RSOAVG_stm10;    
                                $SQLCHK_stm10="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm10'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-10'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm10 = sqlsrv_query($conn, $SQLCHK_stm10 );
                                    while($RSCHK_stm10 = sqlsrv_fetch_array($QUERYCHK_stm10)) { 
                                    $ROUND_stm10=$RSCHK_stm10["ROUND"]; 

                $tbody_stm10 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm10.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm10.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm10.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm10.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm10.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm10.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm10.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm10.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm10.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm10.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm10.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm10.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm10.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm10.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm10.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm10.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm10.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm10.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm10.'</td>
                            </tr>';                   
                            $number_stm10++;
                            } }  
                            $TOTALDTE_stm10=$QRDTE_stm10;
                            $TOTALOAM_stm10=$QROAM_stm10;  
                            $TOTALCALOAM_stm10=$QRCALOAM_stm10;  
                            $TOTALC3_stm10=$QRC3_stm10; 
                            function Average_stm10($arr_stm10) {
                                $array_size_stm10 = count($arr_stm10);                
                                $total_stm10 = 0;
                                for ($number_stm10 = 0; $number_stm10 < $array_size_stm10; $number_stm10++) {
                                    $total_stm10 += $arr_stm10[$number_stm10];
                                }                
                                $AVERAGE_stm10 = (float)($total_stm10 / $array_size_stm10);
                                return $AVERAGE_stm10;
                            }        
                $tfoot_stm10 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm10, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm10, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm10($arr_stm10), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm10, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm10, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm10, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm10, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm10 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm10 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm10 = '</table>';    
            $mpdf->WriteHTML($datedata_stm10);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm10);
            $mpdf->WriteHTML($tfoot_stm10);
            $mpdf->WriteHTML($table_end_stm10); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="11"){      
            $datedata_stm11 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm11 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-11'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm11 = sqlsrv_query($conn, $sql_stm11 );
                $result_stm11 = sqlsrv_fetch_array($query_stm11, SQLSRV_FETCH_ASSOC);
                $OID_stm11=$result_stm11["OID"];
                $number_stm11 = 10;  
            if($OID_stm11!=""){   
                            while($result_stm11 = sqlsrv_fetch_array($query_stm11)) {      
                                    $pieces_stm11 = explode(" ", $result_stm11["EMPN"]);
                                    $fname_stm11=$pieces_stm11[0];
                                    $lname_stm11=$pieces_stm11[1];
                                    $EMPC_stm11=$result_stm11["EMPC"];
                                    $VHCRGNB_stm11=$result_stm11["VHCRGNB"];
                                    $CARTYPE_stm11=$result_stm11["CARTYPE"];
                                    $JOBEND_stm11=$result_stm11["JOBEND"];
                                    $MST_stm11=$result_stm11["MST"];
                                    $MSE_stm11=$result_stm11["MLE"];
                                    $OAM_stm11=$result_stm11["OAM"];
                                    $OTG_stm11=$result_stm11["OTG"];
                                    $CAL1_stm11=$MSE_stm11-$MST_stm11;
                                    $RSDTE_stm11=number_format($CAL1_stm11, 2);
                                    $CAL2_stm11=$CAL1_stm11/$OAM_stm11;
                                    $RSOAVG_stm11=number_format($CAL2_stm11, 2);
                                    $CAL3_stm11=($CAL1_stm11/$OTG_stm11)-$OAM_stm11;
                                    $RSOVER_stm11=number_format($CAL3_stm11, 2);
                                    $PRICE_stm11=$result_chkprice["PRICE"];
                                    $CAL4_stm11=$RSOVER_stm11*$PRICE_stm11;
                                    $RSPRICE_stm11=number_format($CAL4_stm11, 2);
                                    $CAL5_stm11=$OAM_stm11*1;
                                    $CAL6_stm11=$RSPRICE_stm11*1;
                                    
                                    $RDTE_stm11=$RSDTE_stm11;    
                                        $QRDTE_stm11=$QRDTE_stm11+$RDTE_stm11;       
                                    $ROAM_stm11=$OAM_stm11;
                                        $QROAM_stm11=$QROAM_stm11+$ROAM_stm11;     
                                    $ROTG_stm11=$OTG_stm11; 
                                    $QCALOAM_stm11=(($RDTE_stm11/$ROTG_stm11)-$ROAM_stm11);     
                                        $QRCALOAM_stm11=$QRCALOAM_stm11+$QCALOAM_stm11; 
                                    $RC3_stm11=$RSPRICE_stm11;    
                                        $QRC3_stm11=$QRC3_stm11+$RC3_stm11;   
                                    $arr_stm11[] = $RSOAVG_stm11;    
                                $SQLCHK_stm11="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm11'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-11'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm11 = sqlsrv_query($conn, $SQLCHK_stm11 );
                                    while($RSCHK_stm11 = sqlsrv_fetch_array($QUERYCHK_stm11)) { 
                                    $ROUND_stm11=$RSCHK_stm11["ROUND"]; 

                $tbody_stm11 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm11.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm11.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm11.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm11.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm11.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm11.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm11.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm11.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm11.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm11.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm11.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm11.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm11.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm11.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm11.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm11.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm11.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm11.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm11.'</td>
                            </tr>';                   
                            $number_stm11++;
                            } }  
                            $TOTALDTE_stm11=$QRDTE_stm11;
                            $TOTALOAM_stm11=$QROAM_stm11;  
                            $TOTALCALOAM_stm11=$QRCALOAM_stm11;  
                            $TOTALC3_stm11=$QRC3_stm11; 
                            function Average_stm11($arr_stm11) {
                                $array_size_stm11 = count($arr_stm11);                
                                $total_stm11 = 0;
                                for ($number_stm11 = 0; $number_stm11 < $array_size_stm11; $number_stm11++) {
                                    $total_stm11 += $arr_stm11[$number_stm11];
                                }                
                                $AVERAGE_stm11 = (float)($total_stm11 / $array_size_stm11);
                                return $AVERAGE_stm11;
                            }        
                $tfoot_stm11 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm11, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm11, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm11($arr_stm11), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm11, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm11, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm11, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm11, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm11 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm11 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm11 = '</table>';    
            $mpdf->WriteHTML($datedata_stm11);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm11);
            $mpdf->WriteHTML($tfoot_stm11);
            $mpdf->WriteHTML($table_end_stm11); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="12"){      
            $datedata_stm12 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm12 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-12'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm12 = sqlsrv_query($conn, $sql_stm12 );
                $result_stm12 = sqlsrv_fetch_array($query_stm12, SQLSRV_FETCH_ASSOC);
                $OID_stm12=$result_stm12["OID"];
                $number_stm12 = 10;  
            if($OID_stm12!=""){   
                            while($result_stm12 = sqlsrv_fetch_array($query_stm12)) {      
                                    $pieces_stm12 = explode(" ", $result_stm12["EMPN"]);
                                    $fname_stm12=$pieces_stm12[0];
                                    $lname_stm12=$pieces_stm12[1];
                                    $EMPC_stm12=$result_stm12["EMPC"];
                                    $VHCRGNB_stm12=$result_stm12["VHCRGNB"];
                                    $CARTYPE_stm12=$result_stm12["CARTYPE"];
                                    $JOBEND_stm12=$result_stm12["JOBEND"];
                                    $MST_stm12=$result_stm12["MST"];
                                    $MSE_stm12=$result_stm12["MLE"];
                                    $OAM_stm12=$result_stm12["OAM"];
                                    $OTG_stm12=$result_stm12["OTG"];
                                    $CAL1_stm12=$MSE_stm12-$MST_stm12;
                                    $RSDTE_stm12=number_format($CAL1_stm12, 2);
                                    $CAL2_stm12=$CAL1_stm12/$OAM_stm12;
                                    $RSOAVG_stm12=number_format($CAL2_stm12, 2);
                                    $CAL3_stm12=($CAL1_stm12/$OTG_stm12)-$OAM_stm12;
                                    $RSOVER_stm12=number_format($CAL3_stm12, 2);
                                    $PRICE_stm12=$result_chkprice["PRICE"];
                                    $CAL4_stm12=$RSOVER_stm12*$PRICE_stm12;
                                    $RSPRICE_stm12=number_format($CAL4_stm12, 2);
                                    $CAL5_stm12=$OAM_stm12*1;
                                    $CAL6_stm12=$RSPRICE_stm12*1;
                                    
                                    $RDTE_stm12=$RSDTE_stm12;    
                                        $QRDTE_stm12=$QRDTE_stm12+$RDTE_stm12;       
                                    $ROAM_stm12=$OAM_stm12;
                                        $QROAM_stm12=$QROAM_stm12+$ROAM_stm12;     
                                    $ROTG_stm12=$OTG_stm12; 
                                    $QCALOAM_stm12=(($RDTE_stm12/$ROTG_stm12)-$ROAM_stm12);     
                                        $QRCALOAM_stm12=$QRCALOAM_stm12+$QCALOAM_stm12; 
                                    $RC3_stm12=$RSPRICE_stm12;    
                                        $QRC3_stm12=$QRC3_stm12+$RC3_stm12;   
                                    $arr_stm12[] = $RSOAVG_stm12;    
                                $SQLCHK_stm12="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm12'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-12'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm12 = sqlsrv_query($conn, $SQLCHK_stm12 );
                                    while($RSCHK_stm12 = sqlsrv_fetch_array($QUERYCHK_stm12)) { 
                                    $ROUND_stm12=$RSCHK_stm12["ROUND"]; 

                $tbody_stm12 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm12.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm12.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm12.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm12.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm12.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm12.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm12.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm12.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm12.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm12.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm12.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm12.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm12.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm12.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm12.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm12.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm12.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm12.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm12.'</td>
                            </tr>';                   
                            $number_stm12++;
                            } }  
                            $TOTALDTE_stm12=$QRDTE_stm12;
                            $TOTALOAM_stm12=$QROAM_stm12;  
                            $TOTALCALOAM_stm12=$QRCALOAM_stm12;  
                            $TOTALC3_stm12=$QRC3_stm12; 
                            function Average_stm12($arr_stm12) {
                                $array_size_stm12 = count($arr_stm12);                
                                $total_stm12 = 0;
                                for ($number_stm12 = 0; $number_stm12 < $array_size_stm12; $number_stm12++) {
                                    $total_stm12 += $arr_stm12[$number_stm12];
                                }                
                                $AVERAGE_stm12 = (float)($total_stm12 / $array_size_stm12);
                                return $AVERAGE_stm12;
                            }        
                $tfoot_stm12 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm12, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm12, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm12($arr_stm12), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm12, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm12, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm12, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm12, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm12 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm12 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm12 = '</table>';    
            $mpdf->WriteHTML($datedata_stm12);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm12);
            $mpdf->WriteHTML($tfoot_stm12);
            $mpdf->WriteHTML($table_end_stm12); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="13"){      
            $datedata_stm13 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm13 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-13'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm13 = sqlsrv_query($conn, $sql_stm13 );
                $result_stm13 = sqlsrv_fetch_array($query_stm13, SQLSRV_FETCH_ASSOC);
                $OID_stm13=$result_stm13["OID"];
                $number_stm13 = 10;  
            if($OID_stm13!=""){   
                            while($result_stm13 = sqlsrv_fetch_array($query_stm13)) {      
                                    $pieces_stm13 = explode(" ", $result_stm13["EMPN"]);
                                    $fname_stm13=$pieces_stm13[0];
                                    $lname_stm13=$pieces_stm13[1];
                                    $EMPC_stm13=$result_stm13["EMPC"];
                                    $VHCRGNB_stm13=$result_stm13["VHCRGNB"];
                                    $CARTYPE_stm13=$result_stm13["CARTYPE"];
                                    $JOBEND_stm13=$result_stm13["JOBEND"];
                                    $MST_stm13=$result_stm13["MST"];
                                    $MSE_stm13=$result_stm13["MLE"];
                                    $OAM_stm13=$result_stm13["OAM"];
                                    $OTG_stm13=$result_stm13["OTG"];
                                    $CAL1_stm13=$MSE_stm13-$MST_stm13;
                                    $RSDTE_stm13=number_format($CAL1_stm13, 2);
                                    $CAL2_stm13=$CAL1_stm13/$OAM_stm13;
                                    $RSOAVG_stm13=number_format($CAL2_stm13, 2);
                                    $CAL3_stm13=($CAL1_stm13/$OTG_stm13)-$OAM_stm13;
                                    $RSOVER_stm13=number_format($CAL3_stm13, 2);
                                    $PRICE_stm13=$result_chkprice["PRICE"];
                                    $CAL4_stm13=$RSOVER_stm13*$PRICE_stm13;
                                    $RSPRICE_stm13=number_format($CAL4_stm13, 2);
                                    $CAL5_stm13=$OAM_stm13*1;
                                    $CAL6_stm13=$RSPRICE_stm13*1;
                                    
                                    $RDTE_stm13=$RSDTE_stm13;    
                                        $QRDTE_stm13=$QRDTE_stm13+$RDTE_stm13;       
                                    $ROAM_stm13=$OAM_stm13;
                                        $QROAM_stm13=$QROAM_stm13+$ROAM_stm13;     
                                    $ROTG_stm13=$OTG_stm13; 
                                    $QCALOAM_stm13=(($RDTE_stm13/$ROTG_stm13)-$ROAM_stm13);     
                                        $QRCALOAM_stm13=$QRCALOAM_stm13+$QCALOAM_stm13; 
                                    $RC3_stm13=$RSPRICE_stm13;    
                                        $QRC3_stm13=$QRC3_stm13+$RC3_stm13;   
                                    $arr_stm13[] = $RSOAVG_stm13;    
                                $SQLCHK_stm13="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm13'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-13'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm13 = sqlsrv_query($conn, $SQLCHK_stm13 );
                                    while($RSCHK_stm13 = sqlsrv_fetch_array($QUERYCHK_stm13)) { 
                                    $ROUND_stm13=$RSCHK_stm13["ROUND"]; 

                $tbody_stm13 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm13.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm13.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm13.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm13.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm13.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm13.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm13.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm13.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm13.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm13.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm13.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm13.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm13.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm13.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm13.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm13.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm13.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm13.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm13.'</td>
                            </tr>';                   
                            $number_stm13++;
                            } }  
                            $TOTALDTE_stm13=$QRDTE_stm13;
                            $TOTALOAM_stm13=$QROAM_stm13;  
                            $TOTALCALOAM_stm13=$QRCALOAM_stm13;  
                            $TOTALC3_stm13=$QRC3_stm13; 
                            function Average_stm13($arr_stm13) {
                                $array_size_stm13 = count($arr_stm13);                
                                $total_stm13 = 0;
                                for ($number_stm13 = 0; $number_stm13 < $array_size_stm13; $number_stm13++) {
                                    $total_stm13 += $arr_stm13[$number_stm13];
                                }                
                                $AVERAGE_stm13 = (float)($total_stm13 / $array_size_stm13);
                                return $AVERAGE_stm13;
                            }        
                $tfoot_stm13 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm13, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm13, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm13($arr_stm13), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm13, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm13, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm13, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm13, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm13 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm13 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm13 = '</table>';    
            $mpdf->WriteHTML($datedata_stm13);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm13);
            $mpdf->WriteHTML($tfoot_stm13);
            $mpdf->WriteHTML($table_end_stm13); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="14"){      
            $datedata_stm14 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm14 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-14'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm14 = sqlsrv_query($conn, $sql_stm14 );
                $result_stm14 = sqlsrv_fetch_array($query_stm14, SQLSRV_FETCH_ASSOC);
                $OID_stm14=$result_stm14["OID"];
                $number_stm14 = 10;  
            if($OID_stm14!=""){   
                            while($result_stm14 = sqlsrv_fetch_array($query_stm14)) {      
                                    $pieces_stm14 = explode(" ", $result_stm14["EMPN"]);
                                    $fname_stm14=$pieces_stm14[0];
                                    $lname_stm14=$pieces_stm14[1];
                                    $EMPC_stm14=$result_stm14["EMPC"];
                                    $VHCRGNB_stm14=$result_stm14["VHCRGNB"];
                                    $CARTYPE_stm14=$result_stm14["CARTYPE"];
                                    $JOBEND_stm14=$result_stm14["JOBEND"];
                                    $MST_stm14=$result_stm14["MST"];
                                    $MSE_stm14=$result_stm14["MLE"];
                                    $OAM_stm14=$result_stm14["OAM"];
                                    $OTG_stm14=$result_stm14["OTG"];
                                    $CAL1_stm14=$MSE_stm14-$MST_stm14;
                                    $RSDTE_stm14=number_format($CAL1_stm14, 2);
                                    $CAL2_stm14=$CAL1_stm14/$OAM_stm14;
                                    $RSOAVG_stm14=number_format($CAL2_stm14, 2);
                                    $CAL3_stm14=($CAL1_stm14/$OTG_stm14)-$OAM_stm14;
                                    $RSOVER_stm14=number_format($CAL3_stm14, 2);
                                    $PRICE_stm14=$result_chkprice["PRICE"];
                                    $CAL4_stm14=$RSOVER_stm14*$PRICE_stm14;
                                    $RSPRICE_stm14=number_format($CAL4_stm14, 2);
                                    $CAL5_stm14=$OAM_stm14*1;
                                    $CAL6_stm14=$RSPRICE_stm14*1;
                                    
                                    $RDTE_stm14=$RSDTE_stm14;    
                                        $QRDTE_stm14=$QRDTE_stm14+$RDTE_stm14;       
                                    $ROAM_stm14=$OAM_stm14;
                                        $QROAM_stm14=$QROAM_stm14+$ROAM_stm14;     
                                    $ROTG_stm14=$OTG_stm14; 
                                    $QCALOAM_stm14=(($RDTE_stm14/$ROTG_stm14)-$ROAM_stm14);     
                                        $QRCALOAM_stm14=$QRCALOAM_stm14+$QCALOAM_stm14; 
                                    $RC3_stm14=$RSPRICE_stm14;    
                                        $QRC3_stm14=$QRC3_stm14+$RC3_stm14;   
                                    $arr_stm14[] = $RSOAVG_stm14;    
                                $SQLCHK_stm14="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm14'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-14'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm14 = sqlsrv_query($conn, $SQLCHK_stm14 );
                                    while($RSCHK_stm14 = sqlsrv_fetch_array($QUERYCHK_stm14)) { 
                                    $ROUND_stm14=$RSCHK_stm14["ROUND"]; 

                $tbody_stm14 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm14.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm14.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm14.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm14.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm14.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm14.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm14.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm14.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm14.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm14.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm14.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm14.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm14.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm14.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm14.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm14.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm14.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm14.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm14.'</td>
                            </tr>';                   
                            $number_stm14++;
                            } }  
                            $TOTALDTE_stm14=$QRDTE_stm14;
                            $TOTALOAM_stm14=$QROAM_stm14;  
                            $TOTALCALOAM_stm14=$QRCALOAM_stm14;  
                            $TOTALC3_stm14=$QRC3_stm14; 
                            function Average_stm14($arr_stm14) {
                                $array_size_stm14 = count($arr_stm14);                
                                $total_stm14 = 0;
                                for ($number_stm14 = 0; $number_stm14 < $array_size_stm14; $number_stm14++) {
                                    $total_stm14 += $arr_stm14[$number_stm14];
                                }                
                                $AVERAGE_stm14 = (float)($total_stm14 / $array_size_stm14);
                                return $AVERAGE_stm14;
                            }        
                $tfoot_stm14 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm14, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm14, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm14($arr_stm14), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm14, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm14, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm14, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm14, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm14 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm14 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm14 = '</table>';    
            $mpdf->WriteHTML($datedata_stm14);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm14);
            $mpdf->WriteHTML($tfoot_stm14);
            $mpdf->WriteHTML($table_end_stm14); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="15"){      
            $datedata_stm15 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm15 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-15'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm15 = sqlsrv_query($conn, $sql_stm15 );
                $result_stm15 = sqlsrv_fetch_array($query_stm15, SQLSRV_FETCH_ASSOC);
                $OID_stm15=$result_stm15["OID"];
                $number_stm15 = 10;  
            if($OID_stm15!=""){   
                            while($result_stm15 = sqlsrv_fetch_array($query_stm15)) {      
                                    $pieces_stm15 = explode(" ", $result_stm15["EMPN"]);
                                    $fname_stm15=$pieces_stm15[0];
                                    $lname_stm15=$pieces_stm15[1];
                                    $EMPC_stm15=$result_stm15["EMPC"];
                                    $VHCRGNB_stm15=$result_stm15["VHCRGNB"];
                                    $CARTYPE_stm15=$result_stm15["CARTYPE"];
                                    $JOBEND_stm15=$result_stm15["JOBEND"];
                                    $MST_stm15=$result_stm15["MST"];
                                    $MSE_stm15=$result_stm15["MLE"];
                                    $OAM_stm15=$result_stm15["OAM"];
                                    $OTG_stm15=$result_stm15["OTG"];
                                    $CAL1_stm15=$MSE_stm15-$MST_stm15;
                                    $RSDTE_stm15=number_format($CAL1_stm15, 2);
                                    $CAL2_stm15=$CAL1_stm15/$OAM_stm15;
                                    $RSOAVG_stm15=number_format($CAL2_stm15, 2);
                                    $CAL3_stm15=($CAL1_stm15/$OTG_stm15)-$OAM_stm15;
                                    $RSOVER_stm15=number_format($CAL3_stm15, 2);
                                    $PRICE_stm15=$result_chkprice["PRICE"];
                                    $CAL4_stm15=$RSOVER_stm15*$PRICE_stm15;
                                    $RSPRICE_stm15=number_format($CAL4_stm15, 2);
                                    $CAL5_stm15=$OAM_stm15*1;
                                    $CAL6_stm15=$RSPRICE_stm15*1;
                                    
                                    $RDTE_stm15=$RSDTE_stm15;    
                                        $QRDTE_stm15=$QRDTE_stm15+$RDTE_stm15;       
                                    $ROAM_stm15=$OAM_stm15;
                                        $QROAM_stm15=$QROAM_stm15+$ROAM_stm15;     
                                    $ROTG_stm15=$OTG_stm15; 
                                    $QCALOAM_stm15=(($RDTE_stm15/$ROTG_stm15)-$ROAM_stm15);     
                                        $QRCALOAM_stm15=$QRCALOAM_stm15+$QCALOAM_stm15; 
                                    $RC3_stm15=$RSPRICE_stm15;    
                                        $QRC3_stm15=$QRC3_stm15+$RC3_stm15;   
                                    $arr_stm15[] = $RSOAVG_stm15;    
                                $SQLCHK_stm15="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm15'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-15'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm15 = sqlsrv_query($conn, $SQLCHK_stm15 );
                                    while($RSCHK_stm15 = sqlsrv_fetch_array($QUERYCHK_stm15)) { 
                                    $ROUND_stm15=$RSCHK_stm15["ROUND"]; 

                $tbody_stm15 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm15.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm15.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm15.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm15.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm15.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm15.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm15.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm15.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm15.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm15.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm15.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm15.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm15.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm15.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm15.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm15.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm15.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm15.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm15.'</td>
                            </tr>';                   
                            $number_stm15++;
                            } }  
                            $TOTALDTE_stm15=$QRDTE_stm15;
                            $TOTALOAM_stm15=$QROAM_stm15;  
                            $TOTALCALOAM_stm15=$QRCALOAM_stm15;  
                            $TOTALC3_stm15=$QRC3_stm15; 
                            function Average_stm15($arr_stm15) {
                                $array_size_stm15 = count($arr_stm15);                
                                $total_stm15 = 0;
                                for ($number_stm15 = 0; $number_stm15 < $array_size_stm15; $number_stm15++) {
                                    $total_stm15 += $arr_stm15[$number_stm15];
                                }                
                                $AVERAGE_stm15 = (float)($total_stm15 / $array_size_stm15);
                                return $AVERAGE_stm15;
                            }        
                $tfoot_stm15 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm15, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm15, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm15($arr_stm15), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm15, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm15, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm15, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm15, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm15 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm15 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm15 = '</table>';    
            $mpdf->WriteHTML($datedata_stm15);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm15);
            $mpdf->WriteHTML($tfoot_stm15);
            $mpdf->WriteHTML($table_end_stm15); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="16"){      
            $datedata_stm16 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm16 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-16'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm16 = sqlsrv_query($conn, $sql_stm16 );
                $result_stm16 = sqlsrv_fetch_array($query_stm16, SQLSRV_FETCH_ASSOC);
                $OID_stm16=$result_stm16["OID"];
                $number_stm16 = 10;  
            if($OID_stm16!=""){   
                            while($result_stm16 = sqlsrv_fetch_array($query_stm16)) {      
                                    $pieces_stm16 = explode(" ", $result_stm16["EMPN"]);
                                    $fname_stm16=$pieces_stm16[0];
                                    $lname_stm16=$pieces_stm16[1];
                                    $EMPC_stm16=$result_stm16["EMPC"];
                                    $VHCRGNB_stm16=$result_stm16["VHCRGNB"];
                                    $CARTYPE_stm16=$result_stm16["CARTYPE"];
                                    $JOBEND_stm16=$result_stm16["JOBEND"];
                                    $MST_stm16=$result_stm16["MST"];
                                    $MSE_stm16=$result_stm16["MLE"];
                                    $OAM_stm16=$result_stm16["OAM"];
                                    $OTG_stm16=$result_stm16["OTG"];
                                    $CAL1_stm16=$MSE_stm16-$MST_stm16;
                                    $RSDTE_stm16=number_format($CAL1_stm16, 2);
                                    $CAL2_stm16=$CAL1_stm16/$OAM_stm16;
                                    $RSOAVG_stm16=number_format($CAL2_stm16, 2);
                                    $CAL3_stm16=($CAL1_stm16/$OTG_stm16)-$OAM_stm16;
                                    $RSOVER_stm16=number_format($CAL3_stm16, 2);
                                    $PRICE_stm16=$result_chkprice["PRICE"];
                                    $CAL4_stm16=$RSOVER_stm16*$PRICE_stm16;
                                    $RSPRICE_stm16=number_format($CAL4_stm16, 2);
                                    $CAL5_stm16=$OAM_stm16*1;
                                    $CAL6_stm16=$RSPRICE_stm16*1;
                                    
                                    $RDTE_stm16=$RSDTE_stm16;    
                                        $QRDTE_stm16=$QRDTE_stm16+$RDTE_stm16;       
                                    $ROAM_stm16=$OAM_stm16;
                                        $QROAM_stm16=$QROAM_stm16+$ROAM_stm16;     
                                    $ROTG_stm16=$OTG_stm16; 
                                    $QCALOAM_stm16=(($RDTE_stm16/$ROTG_stm16)-$ROAM_stm16);     
                                        $QRCALOAM_stm16=$QRCALOAM_stm16+$QCALOAM_stm16; 
                                    $RC3_stm16=$RSPRICE_stm16;    
                                        $QRC3_stm16=$QRC3_stm16+$RC3_stm16;   
                                    $arr_stm16[] = $RSOAVG_stm16;    
                                $SQLCHK_stm16="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm16'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-16'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm16 = sqlsrv_query($conn, $SQLCHK_stm16 );
                                    while($RSCHK_stm16 = sqlsrv_fetch_array($QUERYCHK_stm16)) { 
                                    $ROUND_stm16=$RSCHK_stm16["ROUND"]; 

                $tbody_stm16 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm16.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm16.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm16.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm16.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm16.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm16.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm16.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm16.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm16.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm16.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm16.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm16.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm16.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm16.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm16.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm16.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm16.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm16.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm16.'</td>
                            </tr>';                   
                            $number_stm16++;
                            } }  
                            $TOTALDTE_stm16=$QRDTE_stm16;
                            $TOTALOAM_stm16=$QROAM_stm16;  
                            $TOTALCALOAM_stm16=$QRCALOAM_stm16;  
                            $TOTALC3_stm16=$QRC3_stm16; 
                            function Average_stm16($arr_stm16) {
                                $array_size_stm16 = count($arr_stm16);                
                                $total_stm16 = 0;
                                for ($number_stm16 = 0; $number_stm16 < $array_size_stm16; $number_stm16++) {
                                    $total_stm16 += $arr_stm16[$number_stm16];
                                }                
                                $AVERAGE_stm16 = (float)($total_stm16 / $array_size_stm16);
                                return $AVERAGE_stm16;
                            }        
                $tfoot_stm16 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm16, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm16, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm16($arr_stm16), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm16, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm16, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm16, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm16, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm16 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm16 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm16 = '</table>';    
            $mpdf->WriteHTML($datedata_stm16);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm16);
            $mpdf->WriteHTML($tfoot_stm16);
            $mpdf->WriteHTML($table_end_stm16); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="17"){      
            $datedata_stm17 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm17 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-17'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm17 = sqlsrv_query($conn, $sql_stm17 );
                $result_stm17 = sqlsrv_fetch_array($query_stm17, SQLSRV_FETCH_ASSOC);
                $OID_stm17=$result_stm17["OID"];
                $number_stm17 = 10;  
            if($OID_stm17!=""){   
                            while($result_stm17 = sqlsrv_fetch_array($query_stm17)) {      
                                    $pieces_stm17 = explode(" ", $result_stm17["EMPN"]);
                                    $fname_stm17=$pieces_stm17[0];
                                    $lname_stm17=$pieces_stm17[1];
                                    $EMPC_stm17=$result_stm17["EMPC"];
                                    $VHCRGNB_stm17=$result_stm17["VHCRGNB"];
                                    $CARTYPE_stm17=$result_stm17["CARTYPE"];
                                    $JOBEND_stm17=$result_stm17["JOBEND"];
                                    $MST_stm17=$result_stm17["MST"];
                                    $MSE_stm17=$result_stm17["MLE"];
                                    $OAM_stm17=$result_stm17["OAM"];
                                    $OTG_stm17=$result_stm17["OTG"];
                                    $CAL1_stm17=$MSE_stm17-$MST_stm17;
                                    $RSDTE_stm17=number_format($CAL1_stm17, 2);
                                    $CAL2_stm17=$CAL1_stm17/$OAM_stm17;
                                    $RSOAVG_stm17=number_format($CAL2_stm17, 2);
                                    $CAL3_stm17=($CAL1_stm17/$OTG_stm17)-$OAM_stm17;
                                    $RSOVER_stm17=number_format($CAL3_stm17, 2);
                                    $PRICE_stm17=$result_chkprice["PRICE"];
                                    $CAL4_stm17=$RSOVER_stm17*$PRICE_stm17;
                                    $RSPRICE_stm17=number_format($CAL4_stm17, 2);
                                    $CAL5_stm17=$OAM_stm17*1;
                                    $CAL6_stm17=$RSPRICE_stm17*1;
                                    
                                    $RDTE_stm17=$RSDTE_stm17;    
                                        $QRDTE_stm17=$QRDTE_stm17+$RDTE_stm17;       
                                    $ROAM_stm17=$OAM_stm17;
                                        $QROAM_stm17=$QROAM_stm17+$ROAM_stm17;     
                                    $ROTG_stm17=$OTG_stm17; 
                                    $QCALOAM_stm17=(($RDTE_stm17/$ROTG_stm17)-$ROAM_stm17);     
                                        $QRCALOAM_stm17=$QRCALOAM_stm17+$QCALOAM_stm17; 
                                    $RC3_stm17=$RSPRICE_stm17;    
                                        $QRC3_stm17=$QRC3_stm17+$RC3_stm17;   
                                    $arr_stm17[] = $RSOAVG_stm17;    
                                $SQLCHK_stm17="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm17'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-17'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm17 = sqlsrv_query($conn, $SQLCHK_stm17 );
                                    while($RSCHK_stm17 = sqlsrv_fetch_array($QUERYCHK_stm17)) { 
                                    $ROUND_stm17=$RSCHK_stm17["ROUND"]; 

                $tbody_stm17 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm17.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm17.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm17.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm17.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm17.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm17.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm17.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm17.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm17.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm17.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm17.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm17.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm17.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm17.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm17.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm17.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm17.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm17.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm17.'</td>
                            </tr>';                   
                            $number_stm17++;
                            } }  
                            $TOTALDTE_stm17=$QRDTE_stm17;
                            $TOTALOAM_stm17=$QROAM_stm17;  
                            $TOTALCALOAM_stm17=$QRCALOAM_stm17;  
                            $TOTALC3_stm17=$QRC3_stm17; 
                            function Average_stm17($arr_stm17) {
                                $array_size_stm17 = count($arr_stm17);                
                                $total_stm17 = 0;
                                for ($number_stm17 = 0; $number_stm17 < $array_size_stm17; $number_stm17++) {
                                    $total_stm17 += $arr_stm17[$number_stm17];
                                }                
                                $AVERAGE_stm17 = (float)($total_stm17 / $array_size_stm17);
                                return $AVERAGE_stm17;
                            }        
                $tfoot_stm17 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm17, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm17, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm17($arr_stm17), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm17, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm17, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm17, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm17, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm17 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm17 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm17 = '</table>';    
            $mpdf->WriteHTML($datedata_stm17);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm17);
            $mpdf->WriteHTML($tfoot_stm17);
            $mpdf->WriteHTML($table_end_stm17); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="18"){      
            $datedata_stm18 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm18 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-18'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm18 = sqlsrv_query($conn, $sql_stm18 );
                $result_stm18 = sqlsrv_fetch_array($query_stm18, SQLSRV_FETCH_ASSOC);
                $OID_stm18=$result_stm18["OID"];
                $number_stm18 = 10;  
            if($OID_stm18!=""){   
                            while($result_stm18 = sqlsrv_fetch_array($query_stm18)) {      
                                    $pieces_stm18 = explode(" ", $result_stm18["EMPN"]);
                                    $fname_stm18=$pieces_stm18[0];
                                    $lname_stm18=$pieces_stm18[1];
                                    $EMPC_stm18=$result_stm18["EMPC"];
                                    $VHCRGNB_stm18=$result_stm18["VHCRGNB"];
                                    $CARTYPE_stm18=$result_stm18["CARTYPE"];
                                    $JOBEND_stm18=$result_stm18["JOBEND"];
                                    $MST_stm18=$result_stm18["MST"];
                                    $MSE_stm18=$result_stm18["MLE"];
                                    $OAM_stm18=$result_stm18["OAM"];
                                    $OTG_stm18=$result_stm18["OTG"];
                                    $CAL1_stm18=$MSE_stm18-$MST_stm18;
                                    $RSDTE_stm18=number_format($CAL1_stm18, 2);
                                    $CAL2_stm18=$CAL1_stm18/$OAM_stm18;
                                    $RSOAVG_stm18=number_format($CAL2_stm18, 2);
                                    $CAL3_stm18=($CAL1_stm18/$OTG_stm18)-$OAM_stm18;
                                    $RSOVER_stm18=number_format($CAL3_stm18, 2);
                                    $PRICE_stm18=$result_chkprice["PRICE"];
                                    $CAL4_stm18=$RSOVER_stm18*$PRICE_stm18;
                                    $RSPRICE_stm18=number_format($CAL4_stm18, 2);
                                    $CAL5_stm18=$OAM_stm18*1;
                                    $CAL6_stm18=$RSPRICE_stm18*1;
                                    
                                    $RDTE_stm18=$RSDTE_stm18;    
                                        $QRDTE_stm18=$QRDTE_stm18+$RDTE_stm18;       
                                    $ROAM_stm18=$OAM_stm18;
                                        $QROAM_stm18=$QROAM_stm18+$ROAM_stm18;     
                                    $ROTG_stm18=$OTG_stm18; 
                                    $QCALOAM_stm18=(($RDTE_stm18/$ROTG_stm18)-$ROAM_stm18);     
                                        $QRCALOAM_stm18=$QRCALOAM_stm18+$QCALOAM_stm18; 
                                    $RC3_stm18=$RSPRICE_stm18;    
                                        $QRC3_stm18=$QRC3_stm18+$RC3_stm18;   
                                    $arr_stm18[] = $RSOAVG_stm18;    
                                $SQLCHK_stm18="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm18'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-18'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm18 = sqlsrv_query($conn, $SQLCHK_stm18 );
                                    while($RSCHK_stm18 = sqlsrv_fetch_array($QUERYCHK_stm18)) { 
                                    $ROUND_stm18=$RSCHK_stm18["ROUND"]; 

                $tbody_stm18 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm18.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm18.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm18.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm18.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm18.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm18.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm18.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm18.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm18.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm18.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm18.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm18.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm18.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm18.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm18.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm18.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm18.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm18.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm18.'</td>
                            </tr>';                   
                            $number_stm18++;
                            } }  
                            $TOTALDTE_stm18=$QRDTE_stm18;
                            $TOTALOAM_stm18=$QROAM_stm18;  
                            $TOTALCALOAM_stm18=$QRCALOAM_stm18;  
                            $TOTALC3_stm18=$QRC3_stm18; 
                            function Average_stm18($arr_stm18) {
                                $array_size_stm18 = count($arr_stm18);                
                                $total_stm18 = 0;
                                for ($number_stm18 = 0; $number_stm18 < $array_size_stm18; $number_stm18++) {
                                    $total_stm18 += $arr_stm18[$number_stm18];
                                }                
                                $AVERAGE_stm18 = (float)($total_stm18 / $array_size_stm18);
                                return $AVERAGE_stm18;
                            }        
                $tfoot_stm18 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm18, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm18, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm18($arr_stm18), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm18, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm18, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm18, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm18, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm18 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm18 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm18 = '</table>';    
            $mpdf->WriteHTML($datedata_stm18);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm18);
            $mpdf->WriteHTML($tfoot_stm18);
            $mpdf->WriteHTML($table_end_stm18); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="19"){      
            $datedata_stm19 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm19 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-19'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm19 = sqlsrv_query($conn, $sql_stm19 );
                $result_stm19 = sqlsrv_fetch_array($query_stm19, SQLSRV_FETCH_ASSOC);
                $OID_stm19=$result_stm19["OID"];
                $number_stm19 = 10;  
            if($OID_stm19!=""){   
                            while($result_stm19 = sqlsrv_fetch_array($query_stm19)) {      
                                    $pieces_stm19 = explode(" ", $result_stm19["EMPN"]);
                                    $fname_stm19=$pieces_stm19[0];
                                    $lname_stm19=$pieces_stm19[1];
                                    $EMPC_stm19=$result_stm19["EMPC"];
                                    $VHCRGNB_stm19=$result_stm19["VHCRGNB"];
                                    $CARTYPE_stm19=$result_stm19["CARTYPE"];
                                    $JOBEND_stm19=$result_stm19["JOBEND"];
                                    $MST_stm19=$result_stm19["MST"];
                                    $MSE_stm19=$result_stm19["MLE"];
                                    $OAM_stm19=$result_stm19["OAM"];
                                    $OTG_stm19=$result_stm19["OTG"];
                                    $CAL1_stm19=$MSE_stm19-$MST_stm19;
                                    $RSDTE_stm19=number_format($CAL1_stm19, 2);
                                    $CAL2_stm19=$CAL1_stm19/$OAM_stm19;
                                    $RSOAVG_stm19=number_format($CAL2_stm19, 2);
                                    $CAL3_stm19=($CAL1_stm19/$OTG_stm19)-$OAM_stm19;
                                    $RSOVER_stm19=number_format($CAL3_stm19, 2);
                                    $PRICE_stm19=$result_chkprice["PRICE"];
                                    $CAL4_stm19=$RSOVER_stm19*$PRICE_stm19;
                                    $RSPRICE_stm19=number_format($CAL4_stm19, 2);
                                    $CAL5_stm19=$OAM_stm19*1;
                                    $CAL6_stm19=$RSPRICE_stm19*1;
                                    
                                    $RDTE_stm19=$RSDTE_stm19;    
                                        $QRDTE_stm19=$QRDTE_stm19+$RDTE_stm19;       
                                    $ROAM_stm19=$OAM_stm19;
                                        $QROAM_stm19=$QROAM_stm19+$ROAM_stm19;     
                                    $ROTG_stm19=$OTG_stm19; 
                                    $QCALOAM_stm19=(($RDTE_stm19/$ROTG_stm19)-$ROAM_stm19);     
                                        $QRCALOAM_stm19=$QRCALOAM_stm19+$QCALOAM_stm19; 
                                    $RC3_stm19=$RSPRICE_stm19;    
                                        $QRC3_stm19=$QRC3_stm19+$RC3_stm19;   
                                    $arr_stm19[] = $RSOAVG_stm19;    
                                $SQLCHK_stm19="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm19'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-19'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm19 = sqlsrv_query($conn, $SQLCHK_stm19 );
                                    while($RSCHK_stm19 = sqlsrv_fetch_array($QUERYCHK_stm19)) { 
                                    $ROUND_stm19=$RSCHK_stm19["ROUND"]; 

                $tbody_stm19 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm19.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm19.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm19.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm19.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm19.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm19.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm19.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm19.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm19.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm19.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm19.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm19.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm19.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm19.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm19.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm19.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm19.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm19.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm19.'</td>
                            </tr>';                   
                            $number_stm19++;
                            } }  
                            $TOTALDTE_stm19=$QRDTE_stm19;
                            $TOTALOAM_stm19=$QROAM_stm19;  
                            $TOTALCALOAM_stm19=$QRCALOAM_stm19;  
                            $TOTALC3_stm19=$QRC3_stm19; 
                            function Average_stm19($arr_stm19) {
                                $array_size_stm19 = count($arr_stm19);                
                                $total_stm19 = 0;
                                for ($number_stm19 = 0; $number_stm19 < $array_size_stm19; $number_stm19++) {
                                    $total_stm19 += $arr_stm19[$number_stm19];
                                }                
                                $AVERAGE_stm19 = (float)($total_stm19 / $array_size_stm19);
                                return $AVERAGE_stm19;
                            }        
                $tfoot_stm19 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm19, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm19, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm19($arr_stm19), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm19, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm19, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm19, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm19, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm19 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm19 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm19 = '</table>';    
            $mpdf->WriteHTML($datedata_stm19);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm19);
            $mpdf->WriteHTML($tfoot_stm19);
            $mpdf->WriteHTML($table_end_stm19); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="20"){      
            $datedata_stm20 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm20 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-20'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm20 = sqlsrv_query($conn, $sql_stm20 );
                $result_stm20 = sqlsrv_fetch_array($query_stm20, SQLSRV_FETCH_ASSOC);
                $OID_stm20=$result_stm20["OID"];
                $number_stm20 = 10;  
            if($OID_stm20!=""){   
                            while($result_stm20 = sqlsrv_fetch_array($query_stm20)) {      
                                    $pieces_stm20 = explode(" ", $result_stm20["EMPN"]);
                                    $fname_stm20=$pieces_stm20[0];
                                    $lname_stm20=$pieces_stm20[1];
                                    $EMPC_stm20=$result_stm20["EMPC"];
                                    $VHCRGNB_stm20=$result_stm20["VHCRGNB"];
                                    $CARTYPE_stm20=$result_stm20["CARTYPE"];
                                    $JOBEND_stm20=$result_stm20["JOBEND"];
                                    $MST_stm20=$result_stm20["MST"];
                                    $MSE_stm20=$result_stm20["MLE"];
                                    $OAM_stm20=$result_stm20["OAM"];
                                    $OTG_stm20=$result_stm20["OTG"];
                                    $CAL1_stm20=$MSE_stm20-$MST_stm20;
                                    $RSDTE_stm20=number_format($CAL1_stm20, 2);
                                    $CAL2_stm20=$CAL1_stm20/$OAM_stm20;
                                    $RSOAVG_stm20=number_format($CAL2_stm20, 2);
                                    $CAL3_stm20=($CAL1_stm20/$OTG_stm20)-$OAM_stm20;
                                    $RSOVER_stm20=number_format($CAL3_stm20, 2);
                                    $PRICE_stm20=$result_chkprice["PRICE"];
                                    $CAL4_stm20=$RSOVER_stm20*$PRICE_stm20;
                                    $RSPRICE_stm20=number_format($CAL4_stm20, 2);
                                    $CAL5_stm20=$OAM_stm20*1;
                                    $CAL6_stm20=$RSPRICE_stm20*1;
                                    
                                    $RDTE_stm20=$RSDTE_stm20;    
                                        $QRDTE_stm20=$QRDTE_stm20+$RDTE_stm20;       
                                    $ROAM_stm20=$OAM_stm20;
                                        $QROAM_stm20=$QROAM_stm20+$ROAM_stm20;     
                                    $ROTG_stm20=$OTG_stm20; 
                                    $QCALOAM_stm20=(($RDTE_stm20/$ROTG_stm20)-$ROAM_stm20);     
                                        $QRCALOAM_stm20=$QRCALOAM_stm20+$QCALOAM_stm20; 
                                    $RC3_stm20=$RSPRICE_stm20;    
                                        $QRC3_stm20=$QRC3_stm20+$RC3_stm20;   
                                    $arr_stm20[] = $RSOAVG_stm20;    
                                $SQLCHK_stm20="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm20'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-20'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm20 = sqlsrv_query($conn, $SQLCHK_stm20 );
                                    while($RSCHK_stm20 = sqlsrv_fetch_array($QUERYCHK_stm20)) { 
                                    $ROUND_stm20=$RSCHK_stm20["ROUND"]; 

                $tbody_stm20 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm20.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm20.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm20.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm20.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm20.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm20.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm20.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm20.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm20.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm20.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm20.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm20.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm20.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm20.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm20.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm20.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm20.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm20.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm20.'</td>
                            </tr>';                   
                            $number_stm20++;
                            } }  
                            $TOTALDTE_stm20=$QRDTE_stm20;
                            $TOTALOAM_stm20=$QROAM_stm20;  
                            $TOTALCALOAM_stm20=$QRCALOAM_stm20;  
                            $TOTALC3_stm20=$QRC3_stm20; 
                            function Average_stm20($arr_stm20) {
                                $array_size_stm20 = count($arr_stm20);                
                                $total_stm20 = 0;
                                for ($number_stm20 = 0; $number_stm20 < $array_size_stm20; $number_stm20++) {
                                    $total_stm20 += $arr_stm20[$number_stm20];
                                }                
                                $AVERAGE_stm20 = (float)($total_stm20 / $array_size_stm20);
                                return $AVERAGE_stm20;
                            }        
                $tfoot_stm20 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm20, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm20, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm20($arr_stm20), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm20, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm20, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm20, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm20, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm20 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm20 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm20 = '</table>';    
            $mpdf->WriteHTML($datedata_stm20);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm20);
            $mpdf->WriteHTML($tfoot_stm20);
            $mpdf->WriteHTML($table_end_stm20); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="21"){      
            $datedata_stm21 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm21 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-21'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm21 = sqlsrv_query($conn, $sql_stm21 );
                $result_stm21 = sqlsrv_fetch_array($query_stm21, SQLSRV_FETCH_ASSOC);
                $OID_stm21=$result_stm21["OID"];
                $number_stm21 = 10;  
            if($OID_stm21!=""){   
                            while($result_stm21 = sqlsrv_fetch_array($query_stm21)) {      
                                    $pieces_stm21 = explode(" ", $result_stm21["EMPN"]);
                                    $fname_stm21=$pieces_stm21[0];
                                    $lname_stm21=$pieces_stm21[1];
                                    $EMPC_stm21=$result_stm21["EMPC"];
                                    $VHCRGNB_stm21=$result_stm21["VHCRGNB"];
                                    $CARTYPE_stm21=$result_stm21["CARTYPE"];
                                    $JOBEND_stm21=$result_stm21["JOBEND"];
                                    $MST_stm21=$result_stm21["MST"];
                                    $MSE_stm21=$result_stm21["MLE"];
                                    $OAM_stm21=$result_stm21["OAM"];
                                    $OTG_stm21=$result_stm21["OTG"];
                                    $CAL1_stm21=$MSE_stm21-$MST_stm21;
                                    $RSDTE_stm21=number_format($CAL1_stm21, 2);
                                    $CAL2_stm21=$CAL1_stm21/$OAM_stm21;
                                    $RSOAVG_stm21=number_format($CAL2_stm21, 2);
                                    $CAL3_stm21=($CAL1_stm21/$OTG_stm21)-$OAM_stm21;
                                    $RSOVER_stm21=number_format($CAL3_stm21, 2);
                                    $PRICE_stm21=$result_chkprice["PRICE"];
                                    $CAL4_stm21=$RSOVER_stm21*$PRICE_stm21;
                                    $RSPRICE_stm21=number_format($CAL4_stm21, 2);
                                    $CAL5_stm21=$OAM_stm21*1;
                                    $CAL6_stm21=$RSPRICE_stm21*1;
                                    
                                    $RDTE_stm21=$RSDTE_stm21;    
                                        $QRDTE_stm21=$QRDTE_stm21+$RDTE_stm21;       
                                    $ROAM_stm21=$OAM_stm21;
                                        $QROAM_stm21=$QROAM_stm21+$ROAM_stm21;     
                                    $ROTG_stm21=$OTG_stm21; 
                                    $QCALOAM_stm21=(($RDTE_stm21/$ROTG_stm21)-$ROAM_stm21);     
                                        $QRCALOAM_stm21=$QRCALOAM_stm21+$QCALOAM_stm21; 
                                    $RC3_stm21=$RSPRICE_stm21;    
                                        $QRC3_stm21=$QRC3_stm21+$RC3_stm21;   
                                    $arr_stm21[] = $RSOAVG_stm21;    
                                $SQLCHK_stm21="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm21'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-21'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm21 = sqlsrv_query($conn, $SQLCHK_stm21 );
                                    while($RSCHK_stm21 = sqlsrv_fetch_array($QUERYCHK_stm21)) { 
                                    $ROUND_stm21=$RSCHK_stm21["ROUND"]; 

                $tbody_stm21 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm21.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm21.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm21.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm21.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm21.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm21.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm21.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm21.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm21.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm21.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm21.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm21.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm21.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm21.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm21.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm21.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm21.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm21.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm21.'</td>
                            </tr>';                   
                            $number_stm21++;
                            } }  
                            $TOTALDTE_stm21=$QRDTE_stm21;
                            $TOTALOAM_stm21=$QROAM_stm21;  
                            $TOTALCALOAM_stm21=$QRCALOAM_stm21;  
                            $TOTALC3_stm21=$QRC3_stm21; 
                            function Average_stm21($arr_stm21) {
                                $array_size_stm21 = count($arr_stm21);                
                                $total_stm21 = 0;
                                for ($number_stm21 = 0; $number_stm21 < $array_size_stm21; $number_stm21++) {
                                    $total_stm21 += $arr_stm21[$number_stm21];
                                }                
                                $AVERAGE_stm21 = (float)($total_stm21 / $array_size_stm21);
                                return $AVERAGE_stm21;
                            }        
                $tfoot_stm21 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm21, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm21, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm21($arr_stm21), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm21, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm21, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm21, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm21, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm21 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm21 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm21 = '</table>';    
            $mpdf->WriteHTML($datedata_stm21);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm21);
            $mpdf->WriteHTML($tfoot_stm21);
            $mpdf->WriteHTML($table_end_stm21); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="22"){      
            $datedata_stm22 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm22 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-22'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm22 = sqlsrv_query($conn, $sql_stm22 );
                $result_stm22 = sqlsrv_fetch_array($query_stm22, SQLSRV_FETCH_ASSOC);
                $OID_stm22=$result_stm22["OID"];
                $number_stm22 = 10;  
            if($OID_stm22!=""){   
                            while($result_stm22 = sqlsrv_fetch_array($query_stm22)) {      
                                    $pieces_stm22 = explode(" ", $result_stm22["EMPN"]);
                                    $fname_stm22=$pieces_stm22[0];
                                    $lname_stm22=$pieces_stm22[1];
                                    $EMPC_stm22=$result_stm22["EMPC"];
                                    $VHCRGNB_stm22=$result_stm22["VHCRGNB"];
                                    $CARTYPE_stm22=$result_stm22["CARTYPE"];
                                    $JOBEND_stm22=$result_stm22["JOBEND"];
                                    $MST_stm22=$result_stm22["MST"];
                                    $MSE_stm22=$result_stm22["MLE"];
                                    $OAM_stm22=$result_stm22["OAM"];
                                    $OTG_stm22=$result_stm22["OTG"];
                                    $CAL1_stm22=$MSE_stm22-$MST_stm22;
                                    $RSDTE_stm22=number_format($CAL1_stm22, 2);
                                    $CAL2_stm22=$CAL1_stm22/$OAM_stm22;
                                    $RSOAVG_stm22=number_format($CAL2_stm22, 2);
                                    $CAL3_stm22=($CAL1_stm22/$OTG_stm22)-$OAM_stm22;
                                    $RSOVER_stm22=number_format($CAL3_stm22, 2);
                                    $PRICE_stm22=$result_chkprice["PRICE"];
                                    $CAL4_stm22=$RSOVER_stm22*$PRICE_stm22;
                                    $RSPRICE_stm22=number_format($CAL4_stm22, 2);
                                    $CAL5_stm22=$OAM_stm22*1;
                                    $CAL6_stm22=$RSPRICE_stm22*1;
                                    
                                    $RDTE_stm22=$RSDTE_stm22;    
                                        $QRDTE_stm22=$QRDTE_stm22+$RDTE_stm22;       
                                    $ROAM_stm22=$OAM_stm22;
                                        $QROAM_stm22=$QROAM_stm22+$ROAM_stm22;     
                                    $ROTG_stm22=$OTG_stm22; 
                                    $QCALOAM_stm22=(($RDTE_stm22/$ROTG_stm22)-$ROAM_stm22);     
                                        $QRCALOAM_stm22=$QRCALOAM_stm22+$QCALOAM_stm22; 
                                    $RC3_stm22=$RSPRICE_stm22;    
                                        $QRC3_stm22=$QRC3_stm22+$RC3_stm22;   
                                    $arr_stm22[] = $RSOAVG_stm22;    
                                $SQLCHK_stm22="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm22'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-22'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm22 = sqlsrv_query($conn, $SQLCHK_stm22 );
                                    while($RSCHK_stm22 = sqlsrv_fetch_array($QUERYCHK_stm22)) { 
                                    $ROUND_stm22=$RSCHK_stm22["ROUND"]; 

                $tbody_stm22 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm22.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm22.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm22.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm22.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm22.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm22.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm22.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm22.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm22.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm22.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm22.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm22.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm22.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm22.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm22.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm22.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm22.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm22.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm22.'</td>
                            </tr>';                   
                            $number_stm22++;
                            } }  
                            $TOTALDTE_stm22=$QRDTE_stm22;
                            $TOTALOAM_stm22=$QROAM_stm22;  
                            $TOTALCALOAM_stm22=$QRCALOAM_stm22;  
                            $TOTALC3_stm22=$QRC3_stm22; 
                            function Average_stm22($arr_stm22) {
                                $array_size_stm22 = count($arr_stm22);                
                                $total_stm22 = 0;
                                for ($number_stm22 = 0; $number_stm22 < $array_size_stm22; $number_stm22++) {
                                    $total_stm22 += $arr_stm22[$number_stm22];
                                }                
                                $AVERAGE_stm22 = (float)($total_stm22 / $array_size_stm22);
                                return $AVERAGE_stm22;
                            }        
                $tfoot_stm22 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm22, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm22, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm22($arr_stm22), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm22, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm22, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm22, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm22, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm22 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm22 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm22 = '</table>';    
            $mpdf->WriteHTML($datedata_stm22);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm22);
            $mpdf->WriteHTML($tfoot_stm22);
            $mpdf->WriteHTML($table_end_stm22); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="23"){      
            $datedata_stm23 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm23 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-23'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm23 = sqlsrv_query($conn, $sql_stm23 );
                $result_stm23 = sqlsrv_fetch_array($query_stm23, SQLSRV_FETCH_ASSOC);
                $OID_stm23=$result_stm23["OID"];
                $number_stm23 = 10;  
            if($OID_stm23!=""){   
                            while($result_stm23 = sqlsrv_fetch_array($query_stm23)) {      
                                    $pieces_stm23 = explode(" ", $result_stm23["EMPN"]);
                                    $fname_stm23=$pieces_stm23[0];
                                    $lname_stm23=$pieces_stm23[1];
                                    $EMPC_stm23=$result_stm23["EMPC"];
                                    $VHCRGNB_stm23=$result_stm23["VHCRGNB"];
                                    $CARTYPE_stm23=$result_stm23["CARTYPE"];
                                    $JOBEND_stm23=$result_stm23["JOBEND"];
                                    $MST_stm23=$result_stm23["MST"];
                                    $MSE_stm23=$result_stm23["MLE"];
                                    $OAM_stm23=$result_stm23["OAM"];
                                    $OTG_stm23=$result_stm23["OTG"];
                                    $CAL1_stm23=$MSE_stm23-$MST_stm23;
                                    $RSDTE_stm23=number_format($CAL1_stm23, 2);
                                    $CAL2_stm23=$CAL1_stm23/$OAM_stm23;
                                    $RSOAVG_stm23=number_format($CAL2_stm23, 2);
                                    $CAL3_stm23=($CAL1_stm23/$OTG_stm23)-$OAM_stm23;
                                    $RSOVER_stm23=number_format($CAL3_stm23, 2);
                                    $PRICE_stm23=$result_chkprice["PRICE"];
                                    $CAL4_stm23=$RSOVER_stm23*$PRICE_stm23;
                                    $RSPRICE_stm23=number_format($CAL4_stm23, 2);
                                    $CAL5_stm23=$OAM_stm23*1;
                                    $CAL6_stm23=$RSPRICE_stm23*1;
                                    
                                    $RDTE_stm23=$RSDTE_stm23;    
                                        $QRDTE_stm23=$QRDTE_stm23+$RDTE_stm23;       
                                    $ROAM_stm23=$OAM_stm23;
                                        $QROAM_stm23=$QROAM_stm23+$ROAM_stm23;     
                                    $ROTG_stm23=$OTG_stm23; 
                                    $QCALOAM_stm23=(($RDTE_stm23/$ROTG_stm23)-$ROAM_stm23);     
                                        $QRCALOAM_stm23=$QRCALOAM_stm23+$QCALOAM_stm23; 
                                    $RC3_stm23=$RSPRICE_stm23;    
                                        $QRC3_stm23=$QRC3_stm23+$RC3_stm23;   
                                    $arr_stm23[] = $RSOAVG_stm23;    
                                $SQLCHK_stm23="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm23'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-23'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm23 = sqlsrv_query($conn, $SQLCHK_stm23 );
                                    while($RSCHK_stm23 = sqlsrv_fetch_array($QUERYCHK_stm23)) { 
                                    $ROUND_stm23=$RSCHK_stm23["ROUND"]; 

                $tbody_stm23 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm23.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm23.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm23.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm23.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm23.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm23.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm23.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm23.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm23.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm23.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm23.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm23.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm23.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm23.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm23.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm23.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm23.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm23.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm23.'</td>
                            </tr>';                   
                            $number_stm23++;
                            } }  
                            $TOTALDTE_stm23=$QRDTE_stm23;
                            $TOTALOAM_stm23=$QROAM_stm23;  
                            $TOTALCALOAM_stm23=$QRCALOAM_stm23;  
                            $TOTALC3_stm23=$QRC3_stm23; 
                            function Average_stm23($arr_stm23) {
                                $array_size_stm23 = count($arr_stm23);                
                                $total_stm23 = 0;
                                for ($number_stm23 = 0; $number_stm23 < $array_size_stm23; $number_stm23++) {
                                    $total_stm23 += $arr_stm23[$number_stm23];
                                }                
                                $AVERAGE_stm23 = (float)($total_stm23 / $array_size_stm23);
                                return $AVERAGE_stm23;
                            }        
                $tfoot_stm23 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm23, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm23, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm23($arr_stm23), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm23, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm23, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm23, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm23, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm23 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm23 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm23 = '</table>';    
            $mpdf->WriteHTML($datedata_stm23);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm23);
            $mpdf->WriteHTML($tfoot_stm23);
            $mpdf->WriteHTML($table_end_stm23); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="24"){      
            $datedata_stm24 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm24 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-24'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm24 = sqlsrv_query($conn, $sql_stm24 );
                $result_stm24 = sqlsrv_fetch_array($query_stm24, SQLSRV_FETCH_ASSOC);
                $OID_stm24=$result_stm24["OID"];
                $number_stm24 = 10;  
            if($OID_stm24!=""){   
                            while($result_stm24 = sqlsrv_fetch_array($query_stm24)) {      
                                    $pieces_stm24 = explode(" ", $result_stm24["EMPN"]);
                                    $fname_stm24=$pieces_stm24[0];
                                    $lname_stm24=$pieces_stm24[1];
                                    $EMPC_stm24=$result_stm24["EMPC"];
                                    $VHCRGNB_stm24=$result_stm24["VHCRGNB"];
                                    $CARTYPE_stm24=$result_stm24["CARTYPE"];
                                    $JOBEND_stm24=$result_stm24["JOBEND"];
                                    $MST_stm24=$result_stm24["MST"];
                                    $MSE_stm24=$result_stm24["MLE"];
                                    $OAM_stm24=$result_stm24["OAM"];
                                    $OTG_stm24=$result_stm24["OTG"];
                                    $CAL1_stm24=$MSE_stm24-$MST_stm24;
                                    $RSDTE_stm24=number_format($CAL1_stm24, 2);
                                    $CAL2_stm24=$CAL1_stm24/$OAM_stm24;
                                    $RSOAVG_stm24=number_format($CAL2_stm24, 2);
                                    $CAL3_stm24=($CAL1_stm24/$OTG_stm24)-$OAM_stm24;
                                    $RSOVER_stm24=number_format($CAL3_stm24, 2);
                                    $PRICE_stm24=$result_chkprice["PRICE"];
                                    $CAL4_stm24=$RSOVER_stm24*$PRICE_stm24;
                                    $RSPRICE_stm24=number_format($CAL4_stm24, 2);
                                    $CAL5_stm24=$OAM_stm24*1;
                                    $CAL6_stm24=$RSPRICE_stm24*1;
                                    
                                    $RDTE_stm24=$RSDTE_stm24;    
                                        $QRDTE_stm24=$QRDTE_stm24+$RDTE_stm24;       
                                    $ROAM_stm24=$OAM_stm24;
                                        $QROAM_stm24=$QROAM_stm24+$ROAM_stm24;     
                                    $ROTG_stm24=$OTG_stm24; 
                                    $QCALOAM_stm24=(($RDTE_stm24/$ROTG_stm24)-$ROAM_stm24);     
                                        $QRCALOAM_stm24=$QRCALOAM_stm24+$QCALOAM_stm24; 
                                    $RC3_stm24=$RSPRICE_stm24;    
                                        $QRC3_stm24=$QRC3_stm24+$RC3_stm24;   
                                    $arr_stm24[] = $RSOAVG_stm24;    
                                $SQLCHK_stm24="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm24'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-24'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm24 = sqlsrv_query($conn, $SQLCHK_stm24 );
                                    while($RSCHK_stm24 = sqlsrv_fetch_array($QUERYCHK_stm24)) { 
                                    $ROUND_stm24=$RSCHK_stm24["ROUND"]; 

                $tbody_stm24 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm24.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm24.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm24.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm24.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm24.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm24.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm24.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm24.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm24.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm24.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm24.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm24.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm24.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm24.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm24.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm24.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm24.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm24.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm24.'</td>
                            </tr>';                   
                            $number_stm24++;
                            } }  
                            $TOTALDTE_stm24=$QRDTE_stm24;
                            $TOTALOAM_stm24=$QROAM_stm24;  
                            $TOTALCALOAM_stm24=$QRCALOAM_stm24;  
                            $TOTALC3_stm24=$QRC3_stm24; 
                            function Average_stm24($arr_stm24) {
                                $array_size_stm24 = count($arr_stm24);                
                                $total_stm24 = 0;
                                for ($number_stm24 = 0; $number_stm24 < $array_size_stm24; $number_stm24++) {
                                    $total_stm24 += $arr_stm24[$number_stm24];
                                }                
                                $AVERAGE_stm24 = (float)($total_stm24 / $array_size_stm24);
                                return $AVERAGE_stm24;
                            }        
                $tfoot_stm24 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm24, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm24, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm24($arr_stm24), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm24, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm24, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm24, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm24, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm24 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm24 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm24 = '</table>';    
            $mpdf->WriteHTML($datedata_stm24);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm24);
            $mpdf->WriteHTML($tfoot_stm24);
            $mpdf->WriteHTML($table_end_stm24); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="25"){      
            $datedata_stm25 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm25 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-25'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm25 = sqlsrv_query($conn, $sql_stm25 );
                $result_stm25 = sqlsrv_fetch_array($query_stm25, SQLSRV_FETCH_ASSOC);
                $OID_stm25=$result_stm25["OID"];
                $number_stm25 = 10;  
            if($OID_stm25!=""){   
                            while($result_stm25 = sqlsrv_fetch_array($query_stm25)) {      
                                    $pieces_stm25 = explode(" ", $result_stm25["EMPN"]);
                                    $fname_stm25=$pieces_stm25[0];
                                    $lname_stm25=$pieces_stm25[1];
                                    $EMPC_stm25=$result_stm25["EMPC"];
                                    $VHCRGNB_stm25=$result_stm25["VHCRGNB"];
                                    $CARTYPE_stm25=$result_stm25["CARTYPE"];
                                    $JOBEND_stm25=$result_stm25["JOBEND"];
                                    $MST_stm25=$result_stm25["MST"];
                                    $MSE_stm25=$result_stm25["MLE"];
                                    $OAM_stm25=$result_stm25["OAM"];
                                    $OTG_stm25=$result_stm25["OTG"];
                                    $CAL1_stm25=$MSE_stm25-$MST_stm25;
                                    $RSDTE_stm25=number_format($CAL1_stm25, 2);
                                    $CAL2_stm25=$CAL1_stm25/$OAM_stm25;
                                    $RSOAVG_stm25=number_format($CAL2_stm25, 2);
                                    $CAL3_stm25=($CAL1_stm25/$OTG_stm25)-$OAM_stm25;
                                    $RSOVER_stm25=number_format($CAL3_stm25, 2);
                                    $PRICE_stm25=$result_chkprice["PRICE"];
                                    $CAL4_stm25=$RSOVER_stm25*$PRICE_stm25;
                                    $RSPRICE_stm25=number_format($CAL4_stm25, 2);
                                    $CAL5_stm25=$OAM_stm25*1;
                                    $CAL6_stm25=$RSPRICE_stm25*1;
                                    
                                    $RDTE_stm25=$RSDTE_stm25;    
                                        $QRDTE_stm25=$QRDTE_stm25+$RDTE_stm25;       
                                    $ROAM_stm25=$OAM_stm25;
                                        $QROAM_stm25=$QROAM_stm25+$ROAM_stm25;     
                                    $ROTG_stm25=$OTG_stm25; 
                                    $QCALOAM_stm25=(($RDTE_stm25/$ROTG_stm25)-$ROAM_stm25);     
                                        $QRCALOAM_stm25=$QRCALOAM_stm25+$QCALOAM_stm25; 
                                    $RC3_stm25=$RSPRICE_stm25;    
                                        $QRC3_stm25=$QRC3_stm25+$RC3_stm25;   
                                    $arr_stm25[] = $RSOAVG_stm25;    
                                $SQLCHK_stm25="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm25'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-25'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm25 = sqlsrv_query($conn, $SQLCHK_stm25 );
                                    while($RSCHK_stm25 = sqlsrv_fetch_array($QUERYCHK_stm25)) { 
                                    $ROUND_stm25=$RSCHK_stm25["ROUND"]; 

                $tbody_stm25 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm25.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm25.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm25.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm25.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm25.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm25.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm25.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm25.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm25.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm25.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm25.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm25.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm25.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm25.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm25.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm25.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm25.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm25.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm25.'</td>
                            </tr>';                   
                            $number_stm25++;
                            } }  
                            $TOTALDTE_stm25=$QRDTE_stm25;
                            $TOTALOAM_stm25=$QROAM_stm25;  
                            $TOTALCALOAM_stm25=$QRCALOAM_stm25;  
                            $TOTALC3_stm25=$QRC3_stm25; 
                            function Average_stm25($arr_stm25) {
                                $array_size_stm25 = count($arr_stm25);                
                                $total_stm25 = 0;
                                for ($number_stm25 = 0; $number_stm25 < $array_size_stm25; $number_stm25++) {
                                    $total_stm25 += $arr_stm25[$number_stm25];
                                }                
                                $AVERAGE_stm25 = (float)($total_stm25 / $array_size_stm25);
                                return $AVERAGE_stm25;
                            }        
                $tfoot_stm25 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm25, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm25, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm25($arr_stm25), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm25, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm25, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm25, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm25, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm25 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm25 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm25 = '</table>';    
            $mpdf->WriteHTML($datedata_stm25);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm25);
            $mpdf->WriteHTML($tfoot_stm25);
            $mpdf->WriteHTML($table_end_stm25); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="26"){      
            $datedata_stm26 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm26 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-26'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm26 = sqlsrv_query($conn, $sql_stm26 );
                $result_stm26 = sqlsrv_fetch_array($query_stm26, SQLSRV_FETCH_ASSOC);
                $OID_stm26=$result_stm26["OID"];
                $number_stm26 = 10;  
            if($OID_stm26!=""){   
                            while($result_stm26 = sqlsrv_fetch_array($query_stm26)) {      
                                    $pieces_stm26 = explode(" ", $result_stm26["EMPN"]);
                                    $fname_stm26=$pieces_stm26[0];
                                    $lname_stm26=$pieces_stm26[1];
                                    $EMPC_stm26=$result_stm26["EMPC"];
                                    $VHCRGNB_stm26=$result_stm26["VHCRGNB"];
                                    $CARTYPE_stm26=$result_stm26["CARTYPE"];
                                    $JOBEND_stm26=$result_stm26["JOBEND"];
                                    $MST_stm26=$result_stm26["MST"];
                                    $MSE_stm26=$result_stm26["MLE"];
                                    $OAM_stm26=$result_stm26["OAM"];
                                    $OTG_stm26=$result_stm26["OTG"];
                                    $CAL1_stm26=$MSE_stm26-$MST_stm26;
                                    $RSDTE_stm26=number_format($CAL1_stm26, 2);
                                    $CAL2_stm26=$CAL1_stm26/$OAM_stm26;
                                    $RSOAVG_stm26=number_format($CAL2_stm26, 2);
                                    $CAL3_stm26=($CAL1_stm26/$OTG_stm26)-$OAM_stm26;
                                    $RSOVER_stm26=number_format($CAL3_stm26, 2);
                                    $PRICE_stm26=$result_chkprice["PRICE"];
                                    $CAL4_stm26=$RSOVER_stm26*$PRICE_stm26;
                                    $RSPRICE_stm26=number_format($CAL4_stm26, 2);
                                    $CAL5_stm26=$OAM_stm26*1;
                                    $CAL6_stm26=$RSPRICE_stm26*1;
                                    
                                    $RDTE_stm26=$RSDTE_stm26;    
                                        $QRDTE_stm26=$QRDTE_stm26+$RDTE_stm26;       
                                    $ROAM_stm26=$OAM_stm26;
                                        $QROAM_stm26=$QROAM_stm26+$ROAM_stm26;     
                                    $ROTG_stm26=$OTG_stm26; 
                                    $QCALOAM_stm26=(($RDTE_stm26/$ROTG_stm26)-$ROAM_stm26);     
                                        $QRCALOAM_stm26=$QRCALOAM_stm26+$QCALOAM_stm26; 
                                    $RC3_stm26=$RSPRICE_stm26;    
                                        $QRC3_stm26=$QRC3_stm26+$RC3_stm26;   
                                    $arr_stm26[] = $RSOAVG_stm26;    
                                $SQLCHK_stm26="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm26'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-26'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm26 = sqlsrv_query($conn, $SQLCHK_stm26 );
                                    while($RSCHK_stm26 = sqlsrv_fetch_array($QUERYCHK_stm26)) { 
                                    $ROUND_stm26=$RSCHK_stm26["ROUND"]; 

                $tbody_stm26 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm26.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm26.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm26.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm26.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm26.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm26.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm26.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm26.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm26.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm26.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm26.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm26.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm26.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm26.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm26.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm26.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm26.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm26.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm26.'</td>
                            </tr>';                   
                            $number_stm26++;
                            } }  
                            $TOTALDTE_stm26=$QRDTE_stm26;
                            $TOTALOAM_stm26=$QROAM_stm26;  
                            $TOTALCALOAM_stm26=$QRCALOAM_stm26;  
                            $TOTALC3_stm26=$QRC3_stm26; 
                            function Average_stm26($arr_stm26) {
                                $array_size_stm26 = count($arr_stm26);                
                                $total_stm26 = 0;
                                for ($number_stm26 = 0; $number_stm26 < $array_size_stm26; $number_stm26++) {
                                    $total_stm26 += $arr_stm26[$number_stm26];
                                }                
                                $AVERAGE_stm26 = (float)($total_stm26 / $array_size_stm26);
                                return $AVERAGE_stm26;
                            }        
                $tfoot_stm26 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm26, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm26, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm26($arr_stm26), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm26, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm26, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm26, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm26, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm26 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm26 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm26 = '</table>';    
            $mpdf->WriteHTML($datedata_stm26);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm26);
            $mpdf->WriteHTML($tfoot_stm26);
            $mpdf->WriteHTML($table_end_stm26); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="27"){      
            $datedata_stm27 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm27 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-27'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm27 = sqlsrv_query($conn, $sql_stm27 );
                $result_stm27 = sqlsrv_fetch_array($query_stm27, SQLSRV_FETCH_ASSOC);
                $OID_stm27=$result_stm27["OID"];
                $number_stm27 = 10;  
            if($OID_stm27!=""){   
                            while($result_stm27 = sqlsrv_fetch_array($query_stm27)) {      
                                    $pieces_stm27 = explode(" ", $result_stm27["EMPN"]);
                                    $fname_stm27=$pieces_stm27[0];
                                    $lname_stm27=$pieces_stm27[1];
                                    $EMPC_stm27=$result_stm27["EMPC"];
                                    $VHCRGNB_stm27=$result_stm27["VHCRGNB"];
                                    $CARTYPE_stm27=$result_stm27["CARTYPE"];
                                    $JOBEND_stm27=$result_stm27["JOBEND"];
                                    $MST_stm27=$result_stm27["MST"];
                                    $MSE_stm27=$result_stm27["MLE"];
                                    $OAM_stm27=$result_stm27["OAM"];
                                    $OTG_stm27=$result_stm27["OTG"];
                                    $CAL1_stm27=$MSE_stm27-$MST_stm27;
                                    $RSDTE_stm27=number_format($CAL1_stm27, 2);
                                    $CAL2_stm27=$CAL1_stm27/$OAM_stm27;
                                    $RSOAVG_stm27=number_format($CAL2_stm27, 2);
                                    $CAL3_stm27=($CAL1_stm27/$OTG_stm27)-$OAM_stm27;
                                    $RSOVER_stm27=number_format($CAL3_stm27, 2);
                                    $PRICE_stm27=$result_chkprice["PRICE"];
                                    $CAL4_stm27=$RSOVER_stm27*$PRICE_stm27;
                                    $RSPRICE_stm27=number_format($CAL4_stm27, 2);
                                    $CAL5_stm27=$OAM_stm27*1;
                                    $CAL6_stm27=$RSPRICE_stm27*1;
                                    
                                    $RDTE_stm27=$RSDTE_stm27;    
                                        $QRDTE_stm27=$QRDTE_stm27+$RDTE_stm27;       
                                    $ROAM_stm27=$OAM_stm27;
                                        $QROAM_stm27=$QROAM_stm27+$ROAM_stm27;     
                                    $ROTG_stm27=$OTG_stm27; 
                                    $QCALOAM_stm27=(($RDTE_stm27/$ROTG_stm27)-$ROAM_stm27);     
                                        $QRCALOAM_stm27=$QRCALOAM_stm27+$QCALOAM_stm27; 
                                    $RC3_stm27=$RSPRICE_stm27;    
                                        $QRC3_stm27=$QRC3_stm27+$RC3_stm27;   
                                    $arr_stm27[] = $RSOAVG_stm27;    
                                $SQLCHK_stm27="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm27'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-27'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm27 = sqlsrv_query($conn, $SQLCHK_stm27 );
                                    while($RSCHK_stm27 = sqlsrv_fetch_array($QUERYCHK_stm27)) { 
                                    $ROUND_stm27=$RSCHK_stm27["ROUND"]; 

                $tbody_stm27 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm27.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm27.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm27.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm27.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm27.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm27.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm27.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm27.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm27.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm27.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm27.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm27.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm27.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm27.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm27.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm27.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm27.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm27.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm27.'</td>
                            </tr>';                   
                            $number_stm27++;
                            } }  
                            $TOTALDTE_stm27=$QRDTE_stm27;
                            $TOTALOAM_stm27=$QROAM_stm27;  
                            $TOTALCALOAM_stm27=$QRCALOAM_stm27;  
                            $TOTALC3_stm27=$QRC3_stm27; 
                            function Average_stm27($arr_stm27) {
                                $array_size_stm27 = count($arr_stm27);                
                                $total_stm27 = 0;
                                for ($number_stm27 = 0; $number_stm27 < $array_size_stm27; $number_stm27++) {
                                    $total_stm27 += $arr_stm27[$number_stm27];
                                }                
                                $AVERAGE_stm27 = (float)($total_stm27 / $array_size_stm27);
                                return $AVERAGE_stm27;
                            }        
                $tfoot_stm27 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm27, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm27, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm27($arr_stm27), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm27, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm27, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm27, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm27, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm27 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm27 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm27 = '</table>';    
            $mpdf->WriteHTML($datedata_stm27);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm27);
            $mpdf->WriteHTML($tfoot_stm27);
            $mpdf->WriteHTML($table_end_stm27); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="28"){      
            $datedata_stm28 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm28 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-28'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm28 = sqlsrv_query($conn, $sql_stm28 );
                $result_stm28 = sqlsrv_fetch_array($query_stm28, SQLSRV_FETCH_ASSOC);
                $OID_stm28=$result_stm28["OID"];
                $number_stm28 = 10;  
            if($OID_stm28!=""){   
                            while($result_stm28 = sqlsrv_fetch_array($query_stm28)) {      
                                    $pieces_stm28 = explode(" ", $result_stm28["EMPN"]);
                                    $fname_stm28=$pieces_stm28[0];
                                    $lname_stm28=$pieces_stm28[1];
                                    $EMPC_stm28=$result_stm28["EMPC"];
                                    $VHCRGNB_stm28=$result_stm28["VHCRGNB"];
                                    $CARTYPE_stm28=$result_stm28["CARTYPE"];
                                    $JOBEND_stm28=$result_stm28["JOBEND"];
                                    $MST_stm28=$result_stm28["MST"];
                                    $MSE_stm28=$result_stm28["MLE"];
                                    $OAM_stm28=$result_stm28["OAM"];
                                    $OTG_stm28=$result_stm28["OTG"];
                                    $CAL1_stm28=$MSE_stm28-$MST_stm28;
                                    $RSDTE_stm28=number_format($CAL1_stm28, 2);
                                    $CAL2_stm28=$CAL1_stm28/$OAM_stm28;
                                    $RSOAVG_stm28=number_format($CAL2_stm28, 2);
                                    $CAL3_stm28=($CAL1_stm28/$OTG_stm28)-$OAM_stm28;
                                    $RSOVER_stm28=number_format($CAL3_stm28, 2);
                                    $PRICE_stm28=$result_chkprice["PRICE"];
                                    $CAL4_stm28=$RSOVER_stm28*$PRICE_stm28;
                                    $RSPRICE_stm28=number_format($CAL4_stm28, 2);
                                    $CAL5_stm28=$OAM_stm28*1;
                                    $CAL6_stm28=$RSPRICE_stm28*1;
                                    
                                    $RDTE_stm28=$RSDTE_stm28;    
                                        $QRDTE_stm28=$QRDTE_stm28+$RDTE_stm28;       
                                    $ROAM_stm28=$OAM_stm28;
                                        $QROAM_stm28=$QROAM_stm28+$ROAM_stm28;     
                                    $ROTG_stm28=$OTG_stm28; 
                                    $QCALOAM_stm28=(($RDTE_stm28/$ROTG_stm28)-$ROAM_stm28);     
                                        $QRCALOAM_stm28=$QRCALOAM_stm28+$QCALOAM_stm28; 
                                    $RC3_stm28=$RSPRICE_stm28;    
                                        $QRC3_stm28=$QRC3_stm28+$RC3_stm28;   
                                    $arr_stm28[] = $RSOAVG_stm28;    
                                $SQLCHK_stm28="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm28'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-28'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm28 = sqlsrv_query($conn, $SQLCHK_stm28 );
                                    while($RSCHK_stm28 = sqlsrv_fetch_array($QUERYCHK_stm28)) { 
                                    $ROUND_stm28=$RSCHK_stm28["ROUND"]; 

                $tbody_stm28 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm28.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm28.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm28.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm28.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm28.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm28.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm28.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm28.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm28.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm28.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm28.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm28.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm28.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm28.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm28.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm28.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm28.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm28.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm28.'</td>
                            </tr>';                   
                            $number_stm28++;
                            } }  
                            $TOTALDTE_stm28=$QRDTE_stm28;
                            $TOTALOAM_stm28=$QROAM_stm28;  
                            $TOTALCALOAM_stm28=$QRCALOAM_stm28;  
                            $TOTALC3_stm28=$QRC3_stm28; 
                            function Average_stm28($arr_stm28) {
                                $array_size_stm28 = count($arr_stm28);                
                                $total_stm28 = 0;
                                for ($number_stm28 = 0; $number_stm28 < $array_size_stm28; $number_stm28++) {
                                    $total_stm28 += $arr_stm28[$number_stm28];
                                }                
                                $AVERAGE_stm28 = (float)($total_stm28 / $array_size_stm28);
                                return $AVERAGE_stm28;
                            }        
                $tfoot_stm28 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm28, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm28, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm28($arr_stm28), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm28, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm28, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm28, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm28, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm28 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm28 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm28 = '</table>';    
            $mpdf->WriteHTML($datedata_stm28);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm28);
            $mpdf->WriteHTML($tfoot_stm28);
            $mpdf->WriteHTML($table_end_stm28); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="29"){      
            $datedata_stm29 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm29 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-29'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm29 = sqlsrv_query($conn, $sql_stm29 );
                $result_stm29 = sqlsrv_fetch_array($query_stm29, SQLSRV_FETCH_ASSOC);
                $OID_stm29=$result_stm29["OID"];
                $number_stm29 = 10;  
            if($OID_stm29!=""){   
                            while($result_stm29 = sqlsrv_fetch_array($query_stm29)) {      
                                    $pieces_stm29 = explode(" ", $result_stm29["EMPN"]);
                                    $fname_stm29=$pieces_stm29[0];
                                    $lname_stm29=$pieces_stm29[1];
                                    $EMPC_stm29=$result_stm29["EMPC"];
                                    $VHCRGNB_stm29=$result_stm29["VHCRGNB"];
                                    $CARTYPE_stm29=$result_stm29["CARTYPE"];
                                    $JOBEND_stm29=$result_stm29["JOBEND"];
                                    $MST_stm29=$result_stm29["MST"];
                                    $MSE_stm29=$result_stm29["MLE"];
                                    $OAM_stm29=$result_stm29["OAM"];
                                    $OTG_stm29=$result_stm29["OTG"];
                                    $CAL1_stm29=$MSE_stm29-$MST_stm29;
                                    $RSDTE_stm29=number_format($CAL1_stm29, 2);
                                    $CAL2_stm29=$CAL1_stm29/$OAM_stm29;
                                    $RSOAVG_stm29=number_format($CAL2_stm29, 2);
                                    $CAL3_stm29=($CAL1_stm29/$OTG_stm29)-$OAM_stm29;
                                    $RSOVER_stm29=number_format($CAL3_stm29, 2);
                                    $PRICE_stm29=$result_chkprice["PRICE"];
                                    $CAL4_stm29=$RSOVER_stm29*$PRICE_stm29;
                                    $RSPRICE_stm29=number_format($CAL4_stm29, 2);
                                    $CAL5_stm29=$OAM_stm29*1;
                                    $CAL6_stm29=$RSPRICE_stm29*1;
                                    
                                    $RDTE_stm29=$RSDTE_stm29;    
                                        $QRDTE_stm29=$QRDTE_stm29+$RDTE_stm29;       
                                    $ROAM_stm29=$OAM_stm29;
                                        $QROAM_stm29=$QROAM_stm29+$ROAM_stm29;     
                                    $ROTG_stm29=$OTG_stm29; 
                                    $QCALOAM_stm29=(($RDTE_stm29/$ROTG_stm29)-$ROAM_stm29);     
                                        $QRCALOAM_stm29=$QRCALOAM_stm29+$QCALOAM_stm29; 
                                    $RC3_stm29=$RSPRICE_stm29;    
                                        $QRC3_stm29=$QRC3_stm29+$RC3_stm29;   
                                    $arr_stm29[] = $RSOAVG_stm29;    
                                $SQLCHK_stm29="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm29'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-29'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm29 = sqlsrv_query($conn, $SQLCHK_stm29 );
                                    while($RSCHK_stm29 = sqlsrv_fetch_array($QUERYCHK_stm29)) { 
                                    $ROUND_stm29=$RSCHK_stm29["ROUND"]; 

                $tbody_stm29 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm29.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm29.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm29.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm29.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm29.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm29.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm29.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm29.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm29.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm29.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm29.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm29.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm29.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm29.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm29.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm29.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm29.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm29.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm29.'</td>
                            </tr>';                   
                            $number_stm29++;
                            } }  
                            $TOTALDTE_stm29=$QRDTE_stm29;
                            $TOTALOAM_stm29=$QROAM_stm29;  
                            $TOTALCALOAM_stm29=$QRCALOAM_stm29;  
                            $TOTALC3_stm29=$QRC3_stm29; 
                            function Average_stm29($arr_stm29) {
                                $array_size_stm29 = count($arr_stm29);                
                                $total_stm29 = 0;
                                for ($number_stm29 = 0; $number_stm29 < $array_size_stm29; $number_stm29++) {
                                    $total_stm29 += $arr_stm29[$number_stm29];
                                }                
                                $AVERAGE_stm29 = (float)($total_stm29 / $array_size_stm29);
                                return $AVERAGE_stm29;
                            }        
                $tfoot_stm29 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm29, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm29, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm29($arr_stm29), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm29, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm29, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm29, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm29, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm29 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm29 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm29 = '</table>';    
            $mpdf->WriteHTML($datedata_stm29);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm29);
            $mpdf->WriteHTML($tfoot_stm29);
            $mpdf->WriteHTML($table_end_stm29); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="30"){      
            $datedata_stm30 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm30 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-30'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm30 = sqlsrv_query($conn, $sql_stm30 );
                $result_stm30 = sqlsrv_fetch_array($query_stm30, SQLSRV_FETCH_ASSOC);
                $OID_stm30=$result_stm30["OID"];
                $number_stm30 = 10;  
            if($OID_stm30!=""){   
                            while($result_stm30 = sqlsrv_fetch_array($query_stm30)) {      
                                    $pieces_stm30 = explode(" ", $result_stm30["EMPN"]);
                                    $fname_stm30=$pieces_stm30[0];
                                    $lname_stm30=$pieces_stm30[1];
                                    $EMPC_stm30=$result_stm30["EMPC"];
                                    $VHCRGNB_stm30=$result_stm30["VHCRGNB"];
                                    $CARTYPE_stm30=$result_stm30["CARTYPE"];
                                    $JOBEND_stm30=$result_stm30["JOBEND"];
                                    $MST_stm30=$result_stm30["MST"];
                                    $MSE_stm30=$result_stm30["MLE"];
                                    $OAM_stm30=$result_stm30["OAM"];
                                    $OTG_stm30=$result_stm30["OTG"];
                                    $CAL1_stm30=$MSE_stm30-$MST_stm30;
                                    $RSDTE_stm30=number_format($CAL1_stm30, 2);
                                    $CAL2_stm30=$CAL1_stm30/$OAM_stm30;
                                    $RSOAVG_stm30=number_format($CAL2_stm30, 2);
                                    $CAL3_stm30=($CAL1_stm30/$OTG_stm30)-$OAM_stm30;
                                    $RSOVER_stm30=number_format($CAL3_stm30, 2);
                                    $PRICE_stm30=$result_chkprice["PRICE"];
                                    $CAL4_stm30=$RSOVER_stm30*$PRICE_stm30;
                                    $RSPRICE_stm30=number_format($CAL4_stm30, 2);
                                    $CAL5_stm30=$OAM_stm30*1;
                                    $CAL6_stm30=$RSPRICE_stm30*1;
                                    
                                    $RDTE_stm30=$RSDTE_stm30;    
                                        $QRDTE_stm30=$QRDTE_stm30+$RDTE_stm30;       
                                    $ROAM_stm30=$OAM_stm30;
                                        $QROAM_stm30=$QROAM_stm30+$ROAM_stm30;     
                                    $ROTG_stm30=$OTG_stm30; 
                                    $QCALOAM_stm30=(($RDTE_stm30/$ROTG_stm30)-$ROAM_stm30);     
                                        $QRCALOAM_stm30=$QRCALOAM_stm30+$QCALOAM_stm30; 
                                    $RC3_stm30=$RSPRICE_stm30;    
                                        $QRC3_stm30=$QRC3_stm30+$RC3_stm30;   
                                    $arr_stm30[] = $RSOAVG_stm30;    
                                $SQLCHK_stm30="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm30'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-30'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm30 = sqlsrv_query($conn, $SQLCHK_stm30 );
                                    while($RSCHK_stm30 = sqlsrv_fetch_array($QUERYCHK_stm30)) { 
                                    $ROUND_stm30=$RSCHK_stm30["ROUND"]; 

                $tbody_stm30 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm30.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm30.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm30.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm30.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm30.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm30.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm30.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm30.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm30.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm30.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm30.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm30.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm30.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm30.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm30.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm30.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm30.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm30.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm30.'</td>
                            </tr>';                   
                            $number_stm30++;
                            } }  
                            $TOTALDTE_stm30=$QRDTE_stm30;
                            $TOTALOAM_stm30=$QROAM_stm30;  
                            $TOTALCALOAM_stm30=$QRCALOAM_stm30;  
                            $TOTALC3_stm30=$QRC3_stm30; 
                            function Average_stm30($arr_stm30) {
                                $array_size_stm30 = count($arr_stm30);                
                                $total_stm30 = 0;
                                for ($number_stm30 = 0; $number_stm30 < $array_size_stm30; $number_stm30++) {
                                    $total_stm30 += $arr_stm30[$number_stm30];
                                }                
                                $AVERAGE_stm30 = (float)($total_stm30 / $array_size_stm30);
                                return $AVERAGE_stm30;
                            }        
                $tfoot_stm30 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm30, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm30, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm30($arr_stm30), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm30, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm30, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm30, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm30, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm30 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm30 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm30 = '</table>';    
            $mpdf->WriteHTML($datedata_stm30);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm30);
            $mpdf->WriteHTML($tfoot_stm30);
            $mpdf->WriteHTML($table_end_stm30); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        } 
        if($chkday=="31"){      
            $datedata_stm31 = 'วันที่ '.$chkday.' '.$selectmonth.' '.$start_yth;            
                $sql_stm31 = "SELECT
                        DISTINCT                                
                        OTSN.OILDATAID OID,
                        VHCTPP.EMPLOYEECODE1 EMPC,
                        VHCTPP.EMPLOYEENAME1 EMPN,
                        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) DW,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.VEHICLEREGISNUMBER VHCRGNB,
                        OTSN.VEHICLETYPE CARTYPE,
                        VHCTPP.JOBEND,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.C3 AVG,
                        VHCTPP.E1 MONEY,
                        OTSN.JOBNO JOB,
                        VHCTPP.JOBNO
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                    AND VHCTPP.CUSTOMERCODE = '$selcustomer2'
                    AND OTSN.OIL_BILLNUMBER IS NOT NULL
                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-31'
                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $query_stm31 = sqlsrv_query($conn, $sql_stm31 );
                $result_stm31 = sqlsrv_fetch_array($query_stm31, SQLSRV_FETCH_ASSOC);
                $OID_stm31=$result_stm31["OID"];
                $number_stm31 = 10;  
            if($OID_stm31!=""){   
                            while($result_stm31 = sqlsrv_fetch_array($query_stm31)) {      
                                    $pieces_stm31 = explode(" ", $result_stm31["EMPN"]);
                                    $fname_stm31=$pieces_stm31[0];
                                    $lname_stm31=$pieces_stm31[1];
                                    $EMPC_stm31=$result_stm31["EMPC"];
                                    $VHCRGNB_stm31=$result_stm31["VHCRGNB"];
                                    $CARTYPE_stm31=$result_stm31["CARTYPE"];
                                    $JOBEND_stm31=$result_stm31["JOBEND"];
                                    $MST_stm31=$result_stm31["MST"];
                                    $MSE_stm31=$result_stm31["MLE"];
                                    $OAM_stm31=$result_stm31["OAM"];
                                    $OTG_stm31=$result_stm31["OTG"];
                                    $CAL1_stm31=$MSE_stm31-$MST_stm31;
                                    $RSDTE_stm31=number_format($CAL1_stm31, 2);
                                    $CAL2_stm31=$CAL1_stm31/$OAM_stm31;
                                    $RSOAVG_stm31=number_format($CAL2_stm31, 2);
                                    $CAL3_stm31=($CAL1_stm31/$OTG_stm31)-$OAM_stm31;
                                    $RSOVER_stm31=number_format($CAL3_stm31, 2);
                                    $PRICE_stm31=$result_chkprice["PRICE"];
                                    $CAL4_stm31=$RSOVER_stm31*$PRICE_stm31;
                                    $RSPRICE_stm31=number_format($CAL4_stm31, 2);
                                    $CAL5_stm31=$OAM_stm31*1;
                                    $CAL6_stm31=$RSPRICE_stm31*1;
                                    
                                    $RDTE_stm31=$RSDTE_stm31;    
                                        $QRDTE_stm31=$QRDTE_stm31+$RDTE_stm31;       
                                    $ROAM_stm31=$OAM_stm31;
                                        $QROAM_stm31=$QROAM_stm31+$ROAM_stm31;     
                                    $ROTG_stm31=$OTG_stm31; 
                                    $QCALOAM_stm31=(($RDTE_stm31/$ROTG_stm31)-$ROAM_stm31);     
                                        $QRCALOAM_stm31=$QRCALOAM_stm31+$QCALOAM_stm31; 
                                    $RC3_stm31=$RSPRICE_stm31;    
                                        $QRC3_stm31=$QRC3_stm31+$RC3_stm31;   
                                    $arr_stm31[] = $RSOAVG_stm31;    
                                $SQLCHK_stm31="SELECT
                                    COUNT(VHCTPP.EMPLOYEENAME1) AS ROUND,
                                    VHCTPP.EMPLOYEECODE1,
                                    VHCTPP.EMPLOYEENAME1
                                    FROM VEHICLETRANSPORTPLAN VHCTPP
                                    WHERE VHCTPP.COMPANYCODE = '$selcompany2'
                                    -- AND VHCTPP.CUSTOMERCODE = 'TGT'
                                    AND VHCTPP.EMPLOYEECODE1 = '$EMPC_stm31'
                                    AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-31'
                                    GROUP BY VHCTPP.EMPLOYEECODE1,VHCTPP.EMPLOYEENAME1
                                    ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYCHK_stm31 = sqlsrv_query($conn, $SQLCHK_stm31 );
                                    while($RSCHK_stm31 = sqlsrv_fetch_array($QUERYCHK_stm31)) { 
                                    $ROUND_stm31=$RSCHK_stm31["ROUND"]; 

                $tbody_stm31 .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_stm31.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMPC_stm31.'</td>
                                <td align="left" style="border:1px solid #000;">'.$fname_stm31.'</td>
                                <td align="left" style="border:1px solid #000;">'.$lname_stm31.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRGNB_stm31.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CARTYPE_stm31.'</td>
                                <td align="center" style="border:1px solid #000;">'.$ROUND_stm31.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JOBEND_stm31.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_stm31.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MSE_stm31.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSDTE_stm31.'</td>
                                <td align="right" style="border:1px solid #000;">'.$OAM_stm31.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OTG_stm31.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOAVG_stm31.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSOVER_stm31.'</td>
                                <td align="center" style="border:1px solid #000;">'.$PRICE_stm31.'</td>
                                <td align="right" style="border:1px solid #000;">'.$RSPRICE_stm31.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL5_stm31.'</td>
                                <td align="right" style="border:1px solid #000;">'.$CAL6_stm31.'</td>
                            </tr>';                   
                            $number_stm31++;
                            } }  
                            $TOTALDTE_stm31=$QRDTE_stm31;
                            $TOTALOAM_stm31=$QROAM_stm31;  
                            $TOTALCALOAM_stm31=$QRCALOAM_stm31;  
                            $TOTALC3_stm31=$QRC3_stm31; 
                            function Average_stm31($arr_stm31) {
                                $array_size_stm31 = count($arr_stm31);                
                                $total_stm31 = 0;
                                for ($number_stm31 = 0; $number_stm31 < $array_size_stm31; $number_stm31++) {
                                    $total_stm31 += $arr_stm31[$number_stm31];
                                }                
                                $AVERAGE_stm31 = (float)($total_stm31 / $array_size_stm31);
                                return $AVERAGE_stm31;
                            }        
                $tfoot_stm31 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE_stm31, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm31, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_stm31($arr_stm31), 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM_stm31, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm31, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM_stm31, 2).'</td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3_stm31, 2).'</td>
                    </tr></tfoot>';
            }else{
                $tbody_stm31 .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                            </tr>';     
                $tfoot_stm31 = '</tbody><tfoot>
                    <tr>
                        <td colspan="10" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                        <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                    </tr></tfoot>';
            }
            $table_end_stm31 = '</table>';    
            $mpdf->WriteHTML($datedata_stm31);
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_stm31);
            $mpdf->WriteHTML($tfoot_stm31);
            $mpdf->WriteHTML($table_end_stm31); 
            if($countday >= "1"){ 
                $mpdf->AddPage();  
            }        
        }        
        
        
    $work_sheet++;
}
    $mpdf->Output();
}else if($EXCELCOVER != ""){
        
    $date1 = $_POST["txt_datestartoilmonth"];
    $start = explode("/", $date1);
    $startd = $start[0];
    $startif = $start[1];        
        if($startif=='01'){
            $selectmonthstart = "ม.ค.";
        }else if($startif=='02'){
            $selectmonthstart = "ก.พ.";
        }else if($startif=='03'){
            $selectmonthstart = "มี.ค.";
        }else if($startif=='04'){
            $selectmonthstart = "เม.ย.";
        }else if($startif=='05'){
            $selectmonthstart = "พ.ค.";
        }else if($startif=='06'){
            $selectmonthstart = "มิ.ย.";
        }else if($startif=='07'){
            $selectmonthstart = "ก.ค.";
        }else if($startif=='08'){
            $selectmonthstart = "ส.ค.";
        }else if($startif=='09'){
            $selectmonthstart = "ก.ย.";
        }else if($startif=='10'){
            $selectmonthstart = "ต.ค.";
        }else if($startif=='11'){
            $selectmonthstart = "พ.ย.";
        }else if($startif=='12'){
            $selectmonthstart = "ธ.ค.";
        }
    $start_yen = $start[2];
    $start_yth = $start[2]+543;
    $start_ymd = $start[2].'-'.$start[1].'-'.$start[0];
    
    $date2 = $_POST["txt_dateendoilmonth"];
    $end = explode("/", $date2);
    $endd = $end[0];
    $endif = $end[1];
        if($startif=='01'){
            $selectmonthend = "ม.ค.";
        }else if($startif=='02'){
            $selectmonthend = "ก.พ.";
        }else if($startif=='03'){
            $selectmonthend = "มี.ค.";
        }else if($startif=='04'){
            $selectmonthend = "เม.ย.";
        }else if($startif=='05'){
            $selectmonthend = "พ.ค.";
        }else if($startif=='06'){
            $selectmonthend = "มิ.ย.";
        }else if($startif=='07'){
            $selectmonthend = "ก.ค.";
        }else if($startif=='08'){
            $selectmonthend = "ส.ค.";
        }else if($startif=='09'){
            $selectmonthend = "ก.ย.";
        }else if($startif=='10'){
            $selectmonthend = "ต.ค.";
        }else if($startif=='11'){
            $selectmonthend = "พ.ย.";
        }else if($startif=='12'){
            $selectmonthend = "ธ.ค.";
        }
    $end_yen = $end[2];    
    $end_yth = $end[2]+543;
    $end_ymd = $end[2].'-'.$end[1].'-'.$end[0];

    $objPHPExcel = new PHPExcel();
    // -------------------------------------------------------------------------------------------------------------------------------------------------
            $objPHPExcel->setActiveSheetIndex(0);
                // OPEN SECTION
                    $headtotal="สรุปค่าเฉลี่ยน้ำมัน";
                    $subjecttotal="สรุปยอดเบิกค่าเฉลี่ยน้ำมัน วันที่ $startd $selectmonthstart $start_yth - $endd $selectmonthend $end_yth";                    

                    $styleText = array('font'  => array('bold'  => false,'color' => array('rgb' => '000000'),'size'  => 18,'name'  => 'Angsana New'));     
                    $objPHPExcel->getDefaultStyle()->applyFromArray($styleText);     
                    $objPHPExcel->getActiveSheet()->getStyle('B4:C4')->getFont()->setBold( true );
                    $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(1, 4, $headtotal);$sheet->mergeCells('B4:C4');
                    $objPHPExcel->getActiveSheet()->getStyle('B4:C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('B5:C5')->getFont()->setBold( false );
                    $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(1, 5, $subjecttotal);$sheet->mergeCells('B5:C5');
                    $objPHPExcel->getActiveSheet()->getStyle('B5:C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('B6:C6')->getFont()->setBold( true );
                    $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(1, 6, 'บริษัท')->setCellValueByColumnAndRow(2, 6, 'จำนวนเงินเบิก');
                    $objPHPExcel->getActiveSheet()->getStyle('B6:C6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);                                    
                    $sheet->getDefaultStyle()->applyFromArray($styleText);
                    $sheet->getStyle("B6:C9")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                    $sheet->getStyle("C10")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));                    
                    $objPHPExcel->getActiveSheet()->getStyle('B6:B9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('B10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('C7:C10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);                    
                    $sheet->getColumnDimension('A')->setWidth(20);$sheet->getColumnDimension('B')->setWidth(30);$sheet->getColumnDimension('C')->setWidth(30);$sheet->getColumnDimension('D')->setWidth(20);
                    
                    
                    // $SQL_RKR="SELECT C3 FROM VEHICLETRANSPORTPLAN WHERE COMPANYCODE = 'RKR' AND CUSTOMERCODE IN ('TTASTSTC','TTASTCS') AND CONVERT(VARCHAR (10),DATEWORKING,20) BETWEEN '$start_ymd' AND '$end_ymd' AND C3 IS NOT NULL AND NOT C3 LIKE '%-%'";
                    // $QUERY_RKR = sqlsrv_query($conn, $SQL_RKR );while($RS_RKR = sqlsrv_fetch_array($QUERY_RKR)){$RRKR=$RS_RKR["C3"];$RSRKR=$RSRKR+$RRKR;}$TOTALRS_RKR=$RSRKR; 
                    // $SQL_RKL="SELECT C3 FROM VEHICLETRANSPORTPLAN WHERE COMPANYCODE = 'RKL' AND CUSTOMERCODE IN ('TTASTSTC','SKB') AND CONVERT(VARCHAR (10),DATEWORKING,20) BETWEEN '$start_ymd' AND '$end_ymd' AND C3 IS NOT NULL AND NOT C3 LIKE '%-%'";
                    // $QUERY_RKL = sqlsrv_query($conn, $SQL_RKL );while($RS_RKL = sqlsrv_fetch_array($QUERY_RKL)){$RRKL=$RS_RKL["C3"];$RSRKL=$RSRKL+$RRKL;}$TOTALRS_RKL=$RSRKL; 
                    // $SQL_RKS="SELECT C3 FROM VEHICLETRANSPORTPLAN WHERE COMPANYCODE = 'RKS' AND CUSTOMERCODE IN ('TGT','DAIKI','TMT','TAW') AND CONVERT(VARCHAR (10),DATEWORKING,20) BETWEEN '$start_ymd' AND '$end_ymd' AND C3 IS NOT NULL AND NOT C3 LIKE '%-%'";
                    // $QUERY_RKS = sqlsrv_query($conn, $SQL_RKS );while($RS_RKS = sqlsrv_fetch_array($QUERY_RKS)){$RRKS=$RS_RKS["C3"];$RSRKS=$RSRKS+$RRKS;}$TOTALRS_RKS=$RSRKS; 

                    $SQL_RKRPLUS="SELECT SUM(ISNULL(CAST(C3 AS DECIMAL(6,2)),0)) AS RKRPLUS FROM VEHICLETRANSPORTPLAN WHERE COMPANYCODE = 'RKR' AND CUSTOMERCODE IN ('TTASTSTC','TTASTCS') AND CONVERT(VARCHAR (10),DATEWORKING,20) BETWEEN '$start_ymd' AND '$end_ymd' AND C3 IS NOT NULL AND NOT C3 LIKE '%-%'";
                    $QUERY_RKRPLUS = sqlsrv_query($conn, $SQL_RKRPLUS );$RS_RKRPLUS = sqlsrv_fetch_array($QUERY_RKRPLUS, SQLSRV_FETCH_ASSOC);$RKRPLUS=$RS_RKRPLUS["RKRPLUS"];
                    $SQL_RKRMINUS="SELECT SUM(ISNULL(CAST(C3 AS DECIMAL(6,2)),0)) AS RKRMINUS FROM VEHICLETRANSPORTPLAN WHERE COMPANYCODE = 'RKR' AND CUSTOMERCODE IN ('TTASTSTC','TTASTCS') AND CONVERT(VARCHAR (10),DATEWORKING,20) BETWEEN '$start_ymd' AND '$end_ymd' AND C3 IS NOT NULL AND C3 LIKE '%-%'";
                    $QUERY_RKRMINUS = sqlsrv_query($conn, $SQL_RKRMINUS );$RS_RKRMINUS = sqlsrv_fetch_array($QUERY_RKRMINUS, SQLSRV_FETCH_ASSOC);$RKRMINUS=$RS_RKRMINUS["RKRMINUS"];
                    $TOTALRS_RKR=$RKRPLUS+$RKRMINUS;
                    
                    $SQL_RKLPLUS="SELECT SUM(ISNULL(CAST(C3 AS DECIMAL(6,2)),0)) AS RKLPLUS FROM VEHICLETRANSPORTPLAN WHERE COMPANYCODE = 'RKL' AND CUSTOMERCODE IN ('TTASTSTC','SKB') AND CONVERT(VARCHAR (10),DATEWORKING,20) BETWEEN '$start_ymd' AND '$end_ymd' AND C3 IS NOT NULL AND NOT C3 LIKE '%-%'";
                    $QUERY_RKLPLUS = sqlsrv_query($conn, $SQL_RKLPLUS );$RS_RKLPLUS = sqlsrv_fetch_array($QUERY_RKLPLUS, SQLSRV_FETCH_ASSOC);$RKLPLUS=$RS_RKLPLUS["RKLPLUS"];
                    $SQL_RKLMINUS="SELECT SUM(ISNULL(CAST(C3 AS DECIMAL(6,2)),0)) AS RKLMINUS FROM VEHICLETRANSPORTPLAN WHERE COMPANYCODE = 'RKL' AND CUSTOMERCODE IN ('TTASTSTC','SKB') AND CONVERT(VARCHAR (10),DATEWORKING,20) BETWEEN '$start_ymd' AND '$end_ymd' AND C3 IS NOT NULL AND C3 LIKE '%-%'";
                    $QUERY_RKLMINUS = sqlsrv_query($conn, $SQL_RKLMINUS );$RS_RKLMINUS = sqlsrv_fetch_array($QUERY_RKLMINUS, SQLSRV_FETCH_ASSOC);$RKLMINUS=$RS_RKLMINUS["RKLMINUS"];
                    $TOTALRS_RKL=$RKLPLUS+$RKLMINUS;
                                        
                    $SQL_RKSPLUS="SELECT SUM(ISNULL(CAST(C3 AS DECIMAL(6,2)),0)) AS RKSPLUS FROM VEHICLETRANSPORTPLAN WHERE COMPANYCODE = 'RKS' AND CUSTOMERCODE IN ('TGT','DAIKI','TMT','TAW') AND CONVERT(VARCHAR (10),DATEWORKING,20) BETWEEN '$start_ymd' AND '$end_ymd' AND C3 IS NOT NULL AND NOT C3 LIKE '%-%'";
                    $QUERY_RKSPLUS = sqlsrv_query($conn, $SQL_RKSPLUS );$RS_RKSPLUS = sqlsrv_fetch_array($QUERY_RKSPLUS, SQLSRV_FETCH_ASSOC);$RKSPLUS=$RS_RKSPLUS["RKSPLUS"];
                    $SQL_RKSMINUS="SELECT SUM(ISNULL(CAST(C3 AS DECIMAL(6,2)),0)) AS RKSMINUS FROM VEHICLETRANSPORTPLAN WHERE COMPANYCODE = 'RKS' AND CUSTOMERCODE IN ('TGT','DAIKI','TMT','TAW') AND CONVERT(VARCHAR (10),DATEWORKING,20) BETWEEN '$start_ymd' AND '$end_ymd' AND C3 IS NOT NULL AND C3 LIKE '%-%'";
                    $QUERY_RKSMINUS = sqlsrv_query($conn, $SQL_RKSMINUS );$RS_RKSMINUS = sqlsrv_fetch_array($QUERY_RKSMINUS, SQLSRV_FETCH_ASSOC);$RKSMINUS=$RS_RKSMINUS["RKSMINUS"];
                    $TOTALRS_RKS=$RKSPLUS+$RKSMINUS;

                    $RKRRKLRKS=$TOTALRS_RKR+$TOTALRS_RKL+$TOTALRS_RKS;
                    $objPHPExcel->getActiveSheet()->setCellValue('B7', 'RKR')->setCellValue('C7', number_format($TOTALRS_RKR, 2));
                    $objPHPExcel->getActiveSheet()->setCellValue('B8', 'RKL')->setCellValue('C8', number_format($TOTALRS_RKL, 2));
                    $objPHPExcel->getActiveSheet()->setCellValue('B9', 'RKS')->setCellValue('C9', number_format($TOTALRS_RKS, 2));
                    $objPHPExcel->getActiveSheet()->getStyle('B10')->getFont()->setBold( true );
                    $objPHPExcel->getActiveSheet()->setCellValue('B10', 'รวมยอดเบิกสุทธิ')->setCellValue('C10', number_format($RKRRKLRKS, 2));

                // CLOSE SECTION 
                $objPHPExcel->getActiveSheet()->setTitle('ปะหน้ารวม');
    // -------------------------------------------------------------------------------------------------------------------------------------------------
            $objPHPExcel->createSheet();
            $objPHPExcel->setActiveSheetIndex(1);
            // OPEN SECTION
                $rkr='บริษัท ร่วมกิจรุ่งเรือง 1993 จำกัด';
                $rkl='บริษัท ร่วมกิจรุ่งเรือง โลจิสติคส์ จำกัด';
                $rks='บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด';
                $subjectsplit="สรุปยอดเบิกค่าเฉลี่ยน้ำมัน เดือน $selectmonth $start_yth";     

                // RKR-------------------------------------------------------------------------------------------------------------------------------------------------   
                    $styleText = array('font'  => array('bold'  => false,'color' => array('rgb' => '000000'),'size'  => 18,'name'  => 'Angsana New'));     
                    $objPHPExcel->getDefaultStyle()->applyFromArray($styleText); 
                    $objPHPExcel->getActiveSheet()->getStyle('B2:F2')->getFont()->setBold( true );
                    $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(1, 2, $rkr);$sheet->mergeCells('B2:F2');
                    $objPHPExcel->getActiveSheet()->getStyle('B2:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('B3:F3')->getFont()->setBold( true );
                    $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(1, 3, $subjectsplit);$sheet->mergeCells('B3:F3');
                    $objPHPExcel->getActiveSheet()->getStyle('B3:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('B5:F5')->getFont()->setBold( true );
                    $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(1, 5, 'ลำดับ')->setCellValueByColumnAndRow(2, 5, 'สายงาน')->setCellValueByColumnAndRow(3, 5, 'รวมยอดเงินบวก')->setCellValueByColumnAndRow(4, 5, 'รวมยอดเงินติดลบ')->setCellValueByColumnAndRow(5, 5, 'จำนวนเงินเบิก');
                    $objPHPExcel->getActiveSheet()->getStyle('B5:F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $sheet->getDefaultStyle()->applyFromArray($styleText);
                    $sheet->getStyle("B5:F7")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                    $sheet->getStyle("D8:F8")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));                
                    $objPHPExcel->getActiveSheet()->getStyle('B5:F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('B6:B7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('C6:C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('D6:F8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('C8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);                
                    $sheet->getColumnDimension('A')->setWidth(5);$sheet->getColumnDimension('B')->setWidth(10);$sheet->getColumnDimension('C')->setWidth(20);$sheet->getColumnDimension('D')->setWidth(20);$sheet->getColumnDimension('E')->setWidth(20);$sheet->getColumnDimension('F')->setWidth(20);$sheet->getColumnDimension('G')->setWidth(5);
                    $objPHPExcel->getActiveSheet()->setCellValue('B6', '1')->setCellValue('C6', 'STC 10 W');
                    $objPHPExcel->getActiveSheet()->setCellValue('B7', '2')->setCellValue('C7', 'CS');
                    $objPHPExcel->getActiveSheet()->getStyle('C8:F8')->getFont()->setBold( true );
                    $styleArray = array('font'  => array('color' => array('rgb' => 'FF0000')));$objPHPExcel->getActiveSheet()->getStyle('E5:E8')->applyFromArray($styleArray);                    
                    $SQL_STC10WPLUS="SELECT C3 FROM VEHICLETRANSPORTPLAN WHERE COMPANYCODE = 'RKR' AND CUSTOMERCODE = 'TTASTSTC' AND CONVERT(VARCHAR (10),DATEWORKING,20) BETWEEN '$start_ymd' AND '$end_ymd' AND C3 IS NOT NULL AND NOT C3 LIKE '%-%'";
                    $QUERY_STC10WPLUS = sqlsrv_query($conn, $SQL_STC10WPLUS );while($RS_STC10WPLUS = sqlsrv_fetch_array($QUERY_STC10WPLUS)){$RSTC10WPLUS=$RS_STC10WPLUS["C3"];$RSSTC10WPLUS=$RSSTC10WPLUS+$RSTC10WPLUS;}$TOTALRS_STC10WPLUS=$RSSTC10WPLUS;                    
                    $SQL_STC10WMINUS="SELECT C3 FROM VEHICLETRANSPORTPLAN WHERE COMPANYCODE = 'RKR' AND CUSTOMERCODE = 'TTASTSTC' AND CONVERT(VARCHAR (10),DATEWORKING,20) BETWEEN '$start_ymd' AND '$end_ymd' AND C3 IS NOT NULL AND C3 LIKE '%-%'";
                    $QUERY_STC10WMINUS = sqlsrv_query($conn, $SQL_STC10WMINUS );while($RS_STC10WMINUS = sqlsrv_fetch_array($QUERY_STC10WMINUS)){$RSTC10WMINUS=$RS_STC10WMINUS["C3"];$RSSTC10WMINUS=$RSSTC10WMINUS+$RSTC10WMINUS;}$TOTALRS_STC10WMINUS=$RSSTC10WMINUS;
                    $SQL_CSPLUS="SELECT C3 FROM VEHICLETRANSPORTPLAN WHERE COMPANYCODE = 'RKR' AND CUSTOMERCODE = 'TTASTCS' AND CONVERT(VARCHAR (10),DATEWORKING,20) BETWEEN '$start_ymd' AND '$end_ymd' AND C3 IS NOT NULL AND NOT C3 LIKE '%-%'";
                    $QUERY_CSPLUS = sqlsrv_query($conn, $SQL_CSPLUS );while($RS_CSPLUS = sqlsrv_fetch_array($QUERY_CSPLUS)){$RCSPLUS=$RS_CSPLUS["C3"];$RSCSPLUS=$RSCSPLUS+$RCSPLUS;}$TOTALRS_CSPLUS=$RSCSPLUS;
                    $SQL_CSMINUS="SELECT C3 FROM VEHICLETRANSPORTPLAN WHERE COMPANYCODE = 'RKR' AND CUSTOMERCODE = 'TTASTCS' AND CONVERT(VARCHAR (10),DATEWORKING,20) BETWEEN '$start_ymd' AND '$end_ymd' AND C3 IS NOT NULL AND C3 LIKE '%-%'";
                    $QUERY_CSMINUS = sqlsrv_query($conn, $SQL_CSMINUS );while($RS_CSMINUS = sqlsrv_fetch_array($QUERY_CSMINUS)){$RCSMINUS=$RS_CSMINUS["C3"];$RSCSMINUS=$RSCSMINUS+$RCSMINUS;}$TOTALRS_CSMINUS=$RSCSMINUS;
                    $SUMD6D7=$TOTALRS_STC10WPLUS+$TOTALRS_CSPLUS;
                    $SUME6E7=$TOTALRS_STC10WMINUS+$TOTALRS_CSMINUS;
                    $SUMD6E6=$TOTALRS_STC10WPLUS+$TOTALRS_STC10WMINUS;
                    $SUMD7E7=$TOTALRS_CSPLUS+$TOTALRS_CSMINUS;
                    $SUMD8E8=$SUMD6D7+$SUME6E7;
                    $objPHPExcel->getActiveSheet()->setCellValue('D6', number_format($TOTALRS_STC10WPLUS, 2))->setCellValue('E6', number_format($TOTALRS_STC10WMINUS, 2))->setCellValue('F6', number_format($SUMD6E6, 2));
                    $objPHPExcel->getActiveSheet()->setCellValue('D7', number_format($TOTALRS_CSPLUS, 2))->setCellValue('E7', number_format($TOTALRS_CSMINUS, 2))->setCellValue('F7', number_format($SUMD7E7, 2));
                    $objPHPExcel->getActiveSheet()->setCellValue('D8', number_format($SUMD6D7, 2))->setCellValue('E8', number_format($SUME6E7, 2))->setCellValue('F8', number_format($SUMD8E8, 2));
                    $objPHPExcel->getActiveSheet()->setCellValue('C8', 'รวมสุทธิ');
                    $objPHPExcel->getActiveSheet()->setCellValue('C11', '..............................')->setCellValue('D11', '..............................')->setCellValue('E11', '..............................')->setCellValue('F11', '..............................');
                    $objPHPExcel->getActiveSheet()->setCellValue('C12', '(คุณภิญญาพัชญ์ โตป๊อก)')->setCellValue('D12', '(คุณอุสาห์ ทองใบ)')->setCellValue('E12', '(คุณนรินทร์ พิลึก)')->setCellValue('F12', '(คุณอรัณย์ ศรีสุวรรณ)');
                    $objPHPExcel->getActiveSheet()->setCellValue('C13', 'ผู้จัดทำ')->setCellValue('D13', 'ผู้ตรวจสอบ')->setCellValue('E13', 'ผู้ตรวจสอบ')->setCellValue('F13', 'ผู้อนุมัติ');
                    $objPHPExcel->getActiveSheet()->setCellValue('C14', '(......./......./.......)')->setCellValue('D14', '(......./......./.......)')->setCellValue('E14', '(......./......./.......)')->setCellValue('F14', '(......./......./.......)');
                    $objPHPExcel->getActiveSheet()->getStyle('C11:F14')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                // RKL-------------------------------------------------------------------------------------------------------------------------------------------------
                    $styleText = array('font'  => array('bold'  => false,'color' => array('rgb' => '000000'),'size'  => 18,'name'  => 'Angsana New'));     
                    $objPHPExcel->getDefaultStyle()->applyFromArray($styleText); 
                    $objPHPExcel->getActiveSheet()->getStyle('B20:F20')->getFont()->setBold( true );
                    $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(1, 20, $rkl);$sheet->mergeCells('B20:F20');
                    $objPHPExcel->getActiveSheet()->getStyle('B20:F20')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('B21:F21')->getFont()->setBold( true );
                    $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(1, 21, $subjectsplit);$sheet->mergeCells('B21:F21');
                    $objPHPExcel->getActiveSheet()->getStyle('B21:F21')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('B23:F23')->getFont()->setBold( true );
                    $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(1, 23, 'ลำดับ')->setCellValueByColumnAndRow(2, 23, 'สายงาน')->setCellValueByColumnAndRow(3, 23, 'รวมยอดเงินบวก')->setCellValueByColumnAndRow(4, 23, 'รวมยอดเงินติดลบ')->setCellValueByColumnAndRow(5, 23, 'จำนวนเงินเบิก');
                    $objPHPExcel->getActiveSheet()->getStyle('B23:F23')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $sheet->getDefaultStyle()->applyFromArray($styleText);
                    $sheet->getStyle("B23:F25")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                    $sheet->getStyle("D26:F26")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));                
                    $objPHPExcel->getActiveSheet()->getStyle('B23:F23')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('B24:B25')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('C24:C25')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('D24:F26')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('C26')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);                
                    $sheet->getColumnDimension('A')->setWidth(5);$sheet->getColumnDimension('B')->setWidth(10);$sheet->getColumnDimension('C')->setWidth(20);$sheet->getColumnDimension('D')->setWidth(20);$sheet->getColumnDimension('E')->setWidth(20);$sheet->getColumnDimension('F')->setWidth(20);$sheet->getColumnDimension('G')->setWidth(5);
                    $objPHPExcel->getActiveSheet()->setCellValue('B24', '1')->setCellValue('C24', 'STC-TL');
                    $objPHPExcel->getActiveSheet()->setCellValue('B25', '2')->setCellValue('C25', 'KUBOTA');
                    $objPHPExcel->getActiveSheet()->getStyle('C26:F26')->getFont()->setBold( true );
                    $styleArray = array('font'  => array('color' => array('rgb' => 'FF0000')));$objPHPExcel->getActiveSheet()->getStyle('E23:E26')->applyFromArray($styleArray);         
                    $SQL_STCTLPLUS="SELECT C3 FROM VEHICLETRANSPORTPLAN WHERE COMPANYCODE = 'RKL' AND CUSTOMERCODE = 'TTASTSTC' AND CONVERT(VARCHAR (10),DATEWORKING,20) BETWEEN '$start_ymd' AND '$end_ymd' AND C3 IS NOT NULL AND NOT C3 LIKE '%-%'";
                    $QUERY_STCTLPLUS = sqlsrv_query($conn, $SQL_STCTLPLUS );while($RS_STCTLPLUS = sqlsrv_fetch_array($QUERY_STCTLPLUS)){$RSTCTLPLUS=$RS_STCTLPLUS["C3"];$RSSTCTLPLUS=$RSSTCTLPLUS+$RSTCTLPLUS;}$TOTALRS_STCTLPLUS=$RSSTCTLPLUS;                    
                    $SQL_STCTLMINUS="SELECT C3 FROM VEHICLETRANSPORTPLAN WHERE COMPANYCODE = 'RKL' AND CUSTOMERCODE = 'TTASTSTC' AND CONVERT(VARCHAR (10),DATEWORKING,20) BETWEEN '$start_ymd' AND '$end_ymd' AND C3 IS NOT NULL AND C3 LIKE '%-%'";
                    $QUERY_STCTLMINUS = sqlsrv_query($conn, $SQL_STCTLMINUS );while($RS_STCTLMINUS = sqlsrv_fetch_array($QUERY_STCTLMINUS)){$RSTCTLMINUS=$RS_STCTLMINUS["C3"];$RSSTCTLMINUS=$RSSTCTLMINUS+$RSTCTLMINUS;}$TOTALRS_STCTLMINUS=$RSSTCTLMINUS;
                    $SQL_KUBOTAPLUS="SELECT C3 FROM VEHICLETRANSPORTPLAN WHERE COMPANYCODE = 'RKL' AND CUSTOMERCODE = 'SKB' AND CONVERT(VARCHAR (10),DATEWORKING,20) BETWEEN '$start_ymd' AND '$end_ymd' AND C3 IS NOT NULL AND NOT C3 LIKE '%-%'";
                    $QUERY_KUBOTAPLUS = sqlsrv_query($conn, $SQL_KUBOTAPLUS );while($RS_KUBOTAPLUS = sqlsrv_fetch_array($QUERY_KUBOTAPLUS)){$RKUBOTAPLUS=$RS_KUBOTAPLUS["C3"];$RSKUBOTAPLUS=$RSKUBOTAPLUS+$RKUBOTAPLUS;}$TOTALRS_KUBOTAPLUS=$RSKUBOTAPLUS;
                    $SQL_KUBOTAMINUS="SELECT C3 FROM VEHICLETRANSPORTPLAN WHERE COMPANYCODE = 'RKL' AND CUSTOMERCODE = 'SKB' AND CONVERT(VARCHAR (10),DATEWORKING,20) BETWEEN '$start_ymd' AND '$end_ymd' AND C3 IS NOT NULL AND C3 LIKE '%-%'";
                    $QUERY_KUBOTAMINUS = sqlsrv_query($conn, $SQL_KUBOTAMINUS );while($RS_KUBOTAMINUS = sqlsrv_fetch_array($QUERY_KUBOTAMINUS)){$RKUBOTAMINUS=$RS_KUBOTAMINUS["C3"];$RSKUBOTAMINUS=$RSKUBOTAMINUS+$RKUBOTAMINUS;}$TOTALRS_KUBOTAMINUS=$RSKUBOTAMINUS;
                    $SUMD24D25=$TOTALRS_STCTLPLUS+$TOTALRS_KUBOTAPLUS;
                    $SUME24E25=$TOTALRS_STCTLMINUS+$TOTALRS_KUBOTAMINUS;
                    $SUMD24E24=$TOTALRS_STCTLPLUS+$TOTALRS_STCTLMINUS;
                    $SUMD25E25=$TOTALRS_KUBOTAPLUS+$TOTALRS_KUBOTAMINUS;
                    $SUMD26E26=$SUMD24D25+$SUME24E25;
                    $objPHPExcel->getActiveSheet()->setCellValue('D24', number_format($TOTALRS_STCTLPLUS, 2))->setCellValue('E24', number_format($TOTALRS_STCTLMINUS, 2))->setCellValue('F24', number_format($SUMD24E24, 2));
                    $objPHPExcel->getActiveSheet()->setCellValue('D25', number_format($TOTALRS_KUBOTAPLUS, 2))->setCellValue('E25', number_format($TOTALRS_KUBOTAMINUS, 2))->setCellValue('F25', number_format($SUMD25E25, 2));
                    $objPHPExcel->getActiveSheet()->setCellValue('D26', number_format($SUMD24D25, 2))->setCellValue('E26', number_format($SUME24E25, 2))->setCellValue('F26', number_format($SUMD24E24+$SUMD25E25, 2));
                    $objPHPExcel->getActiveSheet()->setCellValue('C26', 'รวมสุทธิ');
                    $objPHPExcel->getActiveSheet()->setCellValue('C29', '..............................')->setCellValue('D29', '..............................')->setCellValue('E29', '..............................')->setCellValue('F29', '..............................');
                    $objPHPExcel->getActiveSheet()->setCellValue('C30', '(คุณภิญญาพัชญ์ โตป๊อก)')->setCellValue('D30', '(คุณอุสาห์ ทองใบ)')->setCellValue('E30', '(คุณนรินทร์ พิลึก)')->setCellValue('F30', '(คุณอรัณย์ ศรีสุวรรณ)');
                    $objPHPExcel->getActiveSheet()->setCellValue('C31', 'ผู้จัดทำ')->setCellValue('D31', 'ผู้ตรวจสอบ')->setCellValue('E31', 'ผู้ตรวจสอบ')->setCellValue('F31', 'ผู้อนุมัติ');
                    $objPHPExcel->getActiveSheet()->setCellValue('C32', '(......./......./.......)')->setCellValue('D32', '(......./......./.......)')->setCellValue('E32', '(......./......./.......)')->setCellValue('F32', '(......./......./.......)');
                    $objPHPExcel->getActiveSheet()->getStyle('C29:F32')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                // RKS-------------------------------------------------------------------------------------------------------------------------------------------------
                    $styleText = array('font'  => array('bold'  => false,'color' => array('rgb' => '000000'),'size'  => 18,'name'  => 'Angsana New'));     
                    $objPHPExcel->getDefaultStyle()->applyFromArray($styleText); 
                    $objPHPExcel->getActiveSheet()->getStyle('B38:F38')->getFont()->setBold( true );
                    $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(1, 38, $rks);$sheet->mergeCells('B38:F38');
                    $objPHPExcel->getActiveSheet()->getStyle('B38:F38')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('B39:F39')->getFont()->setBold( true );
                    $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(1, 39, $subjectsplit);$sheet->mergeCells('B39:F39');
                    $objPHPExcel->getActiveSheet()->getStyle('B39:F39')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('B41:F41')->getFont()->setBold( true );
                    $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(1, 41, 'ลำดับ')->setCellValueByColumnAndRow(2, 41, 'สายงาน')->setCellValueByColumnAndRow(3, 41, 'รวมยอดเงินบวก')->setCellValueByColumnAndRow(4, 41, 'รวมยอดเงินติดลบ')->setCellValueByColumnAndRow(5, 41, 'จำนวนเงินเบิก');
                    $objPHPExcel->getActiveSheet()->getStyle('B41:F41')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $sheet->getDefaultStyle()->applyFromArray($styleText);
                    $sheet->getStyle("B41:F44")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                    $sheet->getStyle("D45:F45")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));                
                    $objPHPExcel->getActiveSheet()->getStyle('B41:F41')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('B42:B44')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('C42:C44')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('D42:F45')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('C45')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);                
                    $sheet->getColumnDimension('A')->setWidth(5);$sheet->getColumnDimension('B')->setWidth(10);$sheet->getColumnDimension('C')->setWidth(20);$sheet->getColumnDimension('D')->setWidth(20);$sheet->getColumnDimension('E')->setWidth(20);$sheet->getColumnDimension('F')->setWidth(20);$sheet->getColumnDimension('G')->setWidth(5);
                    $objPHPExcel->getActiveSheet()->setCellValue('B42', '1')->setCellValue('C42', 'TGT');
                    $objPHPExcel->getActiveSheet()->setCellValue('B43', '2')->setCellValue('C43', 'DENSO');
                    $objPHPExcel->getActiveSheet()->setCellValue('B44', '3')->setCellValue('C44', 'STM-TMT S/R,TAW');
                    $objPHPExcel->getActiveSheet()->getStyle('C45:F45')->getFont()->setBold( true );
                    $styleArray = array('font'  => array('color' => array('rgb' => 'FF0000')));$objPHPExcel->getActiveSheet()->getStyle('E41:E45')->applyFromArray($styleArray);         
                    $SQL_TGTPLUS="SELECT C3 FROM VEHICLETRANSPORTPLAN WHERE COMPANYCODE = 'RKS' AND CUSTOMERCODE = 'TGT' AND CONVERT(VARCHAR (10),DATEWORKING,20) BETWEEN '$start_ymd' AND '$end_ymd' AND C3 IS NOT NULL AND NOT C3 LIKE '%-%'";
                    $QUERY_TGTPLUS = sqlsrv_query($conn, $SQL_TGTPLUS );while($RS_TGTPLUS = sqlsrv_fetch_array($QUERY_TGTPLUS)){$RTGTPLUS=$RS_TGTPLUS["C3"];$RSTGTPLUS=$RSTGTPLUS+$RTGTPLUS;}$TOTALRS_TGTPLUS=$RSTGTPLUS;                    
                    $SQL_TGTMINUS="SELECT C3 FROM VEHICLETRANSPORTPLAN WHERE COMPANYCODE = 'RKS' AND CUSTOMERCODE = 'TGT' AND CONVERT(VARCHAR (10),DATEWORKING,20) BETWEEN '$start_ymd' AND '$end_ymd' AND C3 IS NOT NULL AND C3 LIKE '%-%'";
                    $QUERY_TGTMINUS = sqlsrv_query($conn, $SQL_TGTMINUS );while($RS_TGTMINUS = sqlsrv_fetch_array($QUERY_TGTMINUS)){$RTGTMINUS=$RS_TGTMINUS["C3"];$RSTGTMINUS=$RSTGTMINUS+$RTGTMINUS;}$TOTALRS_TGTMINUS=$RSTGTMINUS;
                    $SQL_DAIKIPLUS="SELECT C3 FROM VEHICLETRANSPORTPLAN WHERE COMPANYCODE = 'RKS' AND CUSTOMERCODE = 'DAIKI' AND CONVERT(VARCHAR (10),DATEWORKING,20) BETWEEN '$start_ymd' AND '$end_ymd' AND C3 IS NOT NULL AND NOT C3 LIKE '%-%'";
                    $QUERY_DAIKIPLUS = sqlsrv_query($conn, $SQL_DAIKIPLUS );while($RS_DAIKIPLUS = sqlsrv_fetch_array($QUERY_DAIKIPLUS)){$RDAIKIPLUS=$RS_DAIKIPLUS["C3"];$RSDAIKIPLUS=$RSDAIKIPLUS+$RDAIKIPLUS;}$TOTALRS_DAIKIPLUS=$RSDAIKIPLUS;
                    $SQL_DAIKIMINUS="SELECT C3 FROM VEHICLETRANSPORTPLAN WHERE COMPANYCODE = 'RKS' AND CUSTOMERCODE = 'DAIKI' AND CONVERT(VARCHAR (10),DATEWORKING,20) BETWEEN '$start_ymd' AND '$end_ymd' AND C3 IS NOT NULL AND C3 LIKE '%-%'";
                    $QUERY_DAIKIMINUS = sqlsrv_query($conn, $SQL_DAIKIMINUS );while($RS_DAIKIMINUS = sqlsrv_fetch_array($QUERY_DAIKIMINUS)){$RDAIKIMINUS=$RS_DAIKIMINUS["C3"];$RSDAIKIMINUS=$RSDAIKIMINUS+$RDAIKIMINUS;}$TOTALRS_DAIKIMINUS=$RSDAIKIMINUS;
                    $SQL_TMTPLUS="SELECT C3 FROM VEHICLETRANSPORTPLAN WHERE COMPANYCODE = 'RKS' AND CUSTOMERCODE IN ('TMT','TAW') AND CONVERT(VARCHAR (10),DATEWORKING,20) BETWEEN '$start_ymd' AND '$end_ymd' AND C3 IS NOT NULL AND NOT C3 LIKE '%-%'";
                    $QUERY_TMTPLUS = sqlsrv_query($conn, $SQL_TMTPLUS );while($RS_TMTPLUS = sqlsrv_fetch_array($QUERY_TMTPLUS)){$RTMTPLUS=$RS_TMTPLUS["C3"];$RSTMTPLUS=$RSTMTPLUS+$RTMTPLUS;}$TOTALRS_TMTPLUS=$RSTMTPLUS;
                    $SQL_TMTMINUS="SELECT C3 FROM VEHICLETRANSPORTPLAN WHERE COMPANYCODE = 'RKS' AND CUSTOMERCODE IN ('TMT','TAW') AND CONVERT(VARCHAR (10),DATEWORKING,20) BETWEEN '$start_ymd' AND '$end_ymd' AND C3 IS NOT NULL AND C3 LIKE '%-%'";
                    $QUERY_TMTMINUS = sqlsrv_query($conn, $SQL_TMTMINUS );while($RS_TMTMINUS = sqlsrv_fetch_array($QUERY_TMTMINUS)){$RTMTMINUS=$RS_TMTMINUS["C3"];$RSTMTMINUS=$RSTMTMINUS+$RTMTMINUS;}$TOTALRS_TMTMINUS=$RSTMTMINUS;
                    $SUMD42D43D44=$TOTALRS_TGTPLUS+$TOTALRS_DAIKIPLUS+$TOTALRS_TMTPLUS;
                    $SUME42E43E44=$TOTALRS_TGTMINUS+$TOTALRS_DAIKIMINUS+$TOTALRS_TMTMINUS;
                    $SUMD42E42=$TOTALRS_TGTPLUS+$TOTALRS_TGTMINUS;
                    $SUMD43E43=$TOTALRS_DAIKIPLUS+$TOTALRS_DAIKIMINUS;
                    $SUMD44E44=$TOTALRS_TMTPLUS+$TOTALRS_TMTMINUS;
                    $SUMD45E45=$SUMD42D43D44+$SUME42E43E44;
                    $objPHPExcel->getActiveSheet()->setCellValue('D42', number_format($TOTALRS_TGTPLUS, 2))->setCellValue('E42', number_format($TOTALRS_TGTMINUS, 2))->setCellValue('F42', number_format($SUMD42E42, 2));
                    $objPHPExcel->getActiveSheet()->setCellValue('D43', number_format($TOTALRS_DAIKIPLUS, 2))->setCellValue('E43', number_format($TOTALRS_DAIKIMINUS, 2))->setCellValue('F43', number_format($SUMD43E43, 2));
                    $objPHPExcel->getActiveSheet()->setCellValue('D44', number_format($TOTALRS_TMTPLUS, 2))->setCellValue('E44', number_format($TOTALRS_TMTMINUS, 2))->setCellValue('F44', number_format($SUMD44E44, 2));
                    $objPHPExcel->getActiveSheet()->setCellValue('D45', number_format($SUMD42D43D44, 2))->setCellValue('E45', number_format($SUME42E43E44, 2))->setCellValue('F45', number_format($SUMD45E45, 2));
                    $objPHPExcel->getActiveSheet()->setCellValue('C45', 'รวมสุทธิ');
                    $objPHPExcel->getActiveSheet()->setCellValue('C48', '..............................')->setCellValue('D48', '..............................')->setCellValue('E48', '..............................')->setCellValue('F48', '..............................');
                    $objPHPExcel->getActiveSheet()->setCellValue('C49', '(คุณภิญญาพัชญ์ โตป๊อก)')->setCellValue('D49', '(คุณอุสาห์ ทองใบ)')->setCellValue('E49', '(คุณนรินทร์ พิลึก)')->setCellValue('F49', '(คุณอรัณย์ ศรีสุวรรณ)');
                    $objPHPExcel->getActiveSheet()->setCellValue('C50', 'ผู้จัดทำ')->setCellValue('D50', 'ผู้ตรวจสอบ')->setCellValue('E50', 'ผู้ตรวจสอบ')->setCellValue('F50', 'ผู้อนุมัติ');
                    $objPHPExcel->getActiveSheet()->setCellValue('C51', '(......./......./.......)')->setCellValue('D51', '(......./......./.......)')->setCellValue('E51', '(......./......./.......)')->setCellValue('F51', '(......./......./.......)');
                    $objPHPExcel->getActiveSheet()->getStyle('C48:F51')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            // CLOSE SECTION 
            $objPHPExcel->getActiveSheet()->setTitle('ปะหน้า แยกสายงาน');
// END-------------------------------------------------------------------------------------------------------------------------------------------------
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->setActiveSheetIndex(0);
    $RENAME= "ใบปะหน้าประจำเดือน $selectmonth $start_yth";
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