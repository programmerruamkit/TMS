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
                
                    /* Value */
                    $objPHPExcel->getActiveSheet()->
                    setCellValue('A7', 'ลำดับ')->
                    setCellValue('B7', 'รหัส')->
                    setCellValue('C7', 'ชื่อ')->
                    setCellValue('D7', 'สกุล')->
                    setCellValue('E7', 'จำนวน')->
                    setCellValue('E8', 'เที่ยวที่')->
                    setCellValue('E9', 'วิ่งงาน')->
                    setCellValue('F7', 'ทะเบียนรถ')->
                    setCellValue('G7', 'ประเภทรถ')->
                    setCellValue('H7', 'งานที่ขนส่ง')->
                    setCellValue('I8', 'ไมล์ต้น')->
                    setCellValue('J8', 'ไมล์ปลาย')->
                    setCellValue('K8', 'ระยะทาง')->
                    setCellValue('L8', 'เติมใน/ลิตร')->
                    setCellValue('M8', 'เติมนอก/ลิตร')->
                    setCellValue('N8', 'หัก PM')->
                    setCellValue('O8', 'รวมจำนวนลิตร')->
                    setCellValue('P8', 'ค่าเฉลี่ยที่')->
                    setCellValue('P9', 'กำหนด')->
                    setCellValue('Q8', 'ค่าเฉลี่ยที่ได้')->
                    setCellValue('R8', 'จำนวนน้ำมันที่')->
                    setCellValue('R9', 'เกินกว่ากำหนด')->
                    setCellValue('S8', 'จำนวนบาท/')->
                    setCellValue('S9', 'ลิตร')->
                    setCellValue('T8', 'จำนวนเงินที่ได้')->
                    setCellValue('T9', 'บาท');                 
                    /* Merge */ 
                        $objPHPExcel->getActiveSheet()->mergeCells('A7:A9');
                        $objPHPExcel->getActiveSheet()->mergeCells('B7:B9');
                        $objPHPExcel->getActiveSheet()->mergeCells('C7:C9');
                        $objPHPExcel->getActiveSheet()->mergeCells('D7:D9');
                        $objPHPExcel->getActiveSheet()->mergeCells('F7:F9');
                        $objPHPExcel->getActiveSheet()->mergeCells('G7:G9');
                        $objPHPExcel->getActiveSheet()->mergeCells('H7:H9');
                        $objPHPExcel->getActiveSheet()->mergeCells('I7:T7');
                        $objPHPExcel->getActiveSheet()->mergeCells('I8:I9');
                        $objPHPExcel->getActiveSheet()->mergeCells('J8:J9');
                        $objPHPExcel->getActiveSheet()->mergeCells('K8:K9');
                        $objPHPExcel->getActiveSheet()->mergeCells('L8:L9');
                        $objPHPExcel->getActiveSheet()->mergeCells('M8:M9');
                        $objPHPExcel->getActiveSheet()->mergeCells('N8:N9');
                        $objPHPExcel->getActiveSheet()->mergeCells('O8:O9');
                        $objPHPExcel->getActiveSheet()->mergeCells('Q8:Q9');
                    /* Border */
                        $sheet->getStyle('A7:D9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('E7:E9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('E7:E9')->applyFromArray(array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('E7:E9')->applyFromArray(array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('F7:G9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('H7:H9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('I7:T7')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('I8:L9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('M8:M9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('N8:N9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('O8:O9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('P8:P9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('Q8:Q9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('Q8:Q9')->applyFromArray(array('borders' => array('left' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('R8:R9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('S8:S9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('I9:T9')->applyFromArray(array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                    /* Style */
                        $sheet->getStyle('A7:E9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFD700'))));//เหลืองหม่น
                        $sheet->getStyle('F7:H9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '9ACD32'))));//เขียว
                        $sheet->getStyle('I7:T7')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '9ACD32'))));//เขียว
                        $sheet->getStyle('I8:J9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '9ACD32'))));//เขียว          
                        $sheet->getStyle('K8:K9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));//เหลือง
                        $sheet->getStyle('L8:N9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '9ACD32'))));//เขียว         
                        $sheet->getStyle('O8:O9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));//เหลือง
                        $sheet->getStyle('P8:S9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '9ACD32'))));//เขียว 
                        $sheet->getStyle('T8:T9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));//เหลือง
                        $objPHPExcel->getActiveSheet()->getStyle('A7:AL9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    /* Width */
                        $sheet->getColumnDimension('A')->setWidth(5);
                        $sheet->getColumnDimension('B')->setWidth(8);
                        $sheet->getColumnDimension('C')->setWidth(12);
                        $sheet->getColumnDimension('D')->setWidth(12);
                        $sheet->getColumnDimension('E')->setWidth(6);
                        $sheet->getColumnDimension('F')->setWidth(10);
                        $sheet->getColumnDimension('G')->setWidth(15);
                        $sheet->getColumnDimension('H')->setWidth(20);
                        $sheet->getColumnDimension('I')->setWidth(12);
                        $sheet->getColumnDimension('J')->setWidth(12);
                        $sheet->getColumnDimension('K')->setWidth(12);
                        $sheet->getColumnDimension('L')->setWidth(12);
                        $sheet->getColumnDimension('M')->setWidth(12);
                        $sheet->getColumnDimension('N')->setWidth(12);
                        $sheet->getColumnDimension('O')->setWidth(12);
                        $sheet->getColumnDimension('P')->setWidth(8);
                        $sheet->getColumnDimension('Q')->setWidth(12);            
                        $sheet->getColumnDimension('R')->setWidth(12);
                        $sheet->getColumnDimension('S')->setWidth(12);
                        $sheet->getColumnDimension('T')->setWidth(12);          

                    if(($selcustomer2 == 'CS') || ($selcustomer2 == 'T.TOHKEN') || ($selcustomer2 == 'STM - IP')){
                        if($selcustomer2 == 'CS'){
                            $objPHPExcel->getActiveSheet()->setCellValue('I7', '10 W / OTHER');
                            $QUERYWHERE1="EHR.PositionNameT LIKE '%CS%'";
                            $QUERYWHERE2="VHCTPP.CUSTOMERCODE IN('TTASTCS','TTTCSTC') AND NOT (EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเขียว' OR EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเหลือง') AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' ORDER BY EHR.PositionNameT ASC";
                            $QUERYIFELSE1="OTSN.OIL_BILLNUMBER IS NOT NULL AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday'";
                            $CUSTOMERCODE="";
                        }else if($selcustomer2 == 'T.TOHKEN'){
                            $objPHPExcel->getActiveSheet()->setCellValue('I7', '10 W / T.TOHKEN');
                            $QUERYWHERE1="EHR.PositionNameT LIKE '%T-Tohken%'";
                            $QUERYWHERE2="VHCTPP.CUSTOMERCODE = 'THAITOHKEN' AND NOT (EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเขียว' OR EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเหลือง') AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' ORDER BY EHR.PositionNameT DESC";
                            $QUERYIFELSE1="OTSN.OIL_BILLNUMBER IS NOT NULL AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday'";
                            $CUSTOMERCODE="";
                        }else if($selcustomer2 == 'STM - IP'){
                            $objPHPExcel->getActiveSheet()->setCellValue('I7', 'IP');
                            $QUERYWHERE1="EHR.PositionNameT LIKE '%STM-IP%'";
                            $QUERYWHERE2="VHCTPP.CUSTOMERCODE = 'STM' AND NOT (EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเขียว' OR EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเหลือง') AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' ORDER BY EHR.PositionNameT ASC";
                            $QUERYIFELSE1="OTSN.OIL_BILLNUMBER IS NOT NULL AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday'";
                            $CUSTOMERCODE="";
                        }                        
                        $objPHPExcel->getActiveSheet()->setCellValue('U7', 'รวมน้ำมัน')->setCellValue('V7', 'รวมเงิน')->setCellValue('W7', 'หมายเหตุ');   
                        $objPHPExcel->getActiveSheet()->mergeCells('U7:U9');
                        $objPHPExcel->getActiveSheet()->mergeCells('V7:V9');    
                        $objPHPExcel->getActiveSheet()->mergeCells('W7:W9');    
                        $sheet->getStyle('U7:W9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('U7:W9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FF8C00'))));
                        $sheet->getColumnDimension('U')->setWidth(12);
                        $sheet->getColumnDimension('V')->setWidth(12);
                        $sheet->getColumnDimension('W')->setWidth(50);

                    }else if(($selcustomer2 == 'KUBOTA') || ($selcustomer2 == 'TGT/DAIKI') || ($selcustomer2 == 'STM - TMT SR / TAW') || ($selcustomer2 == 'STC 10 W') || ($selcustomer2 == 'STC TL')){
                        if($selcustomer2 == 'KUBOTA'){
                            $objPHPExcel->getActiveSheet()->setCellValue('I7', 'TL OTHER 2')->setCellValue('X7', 'TL OTHER FB');
                            $QUERYWHERE1="EHR.PositionNameT LIKE '%KUBOTA%'";
                            $QUERYWHERE2="VHCTPP.CUSTOMERCODE = 'SKB' AND NOT (EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเขียว' OR EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเหลือง') AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' ORDER BY EHR.PositionNameT ASC";
                            $QUERYIFELSE1="OTSN.OIL_BILLNUMBER IS NOT NULL AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' AND VHCTPP.VEHICLETYPE IN ('ADC-Dealer(SL2)','ADC-Dealer(FB)')";
                            $QUERYIFELSE2="OTSN.OIL_BILLNUMBER IS NOT NULL AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' AND VHCTPP.VEHICLETYPE IN ('ADC-Dealer(SL2)','ADC-Dealer(FB)')";
                            $CUSTOMERCODE="AND VHCTPP.CUSTOMERCODE = 'SKB'";
                        }else if($selcustomer2 == 'TGT/DAIKI'){
                            $objPHPExcel->getActiveSheet()->setCellValue('I7', 'OTHER')->setCellValue('X7', 'Long Route');
                            $QUERYWHERE1="EHR.PositionNameT LIKE '%TGT%'";
                            $QUERYWHERE2="VHCTPP.CUSTOMERCODE IN('TGT','GMT','DAIKI') AND NOT VHCTPP.COMPANYCODE = 'RKR' AND NOT (EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเขียว' OR EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเหลือง') AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' ORDER BY EHR.PositionNameT DESC";
                            $QUERYIFELSE1="OTSN.OIL_BILLNUMBER IS NOT NULL AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' AND VHCTPP.CUSTOMERCODE IN ('TGT','GMT','TKT','TSAT')";
                            $QUERYIFELSE2="OTSN.OIL_BILLNUMBER IS NOT NULL AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' AND VHCTPP.CUSTOMERCODE = 'DAIKI'";
                            $CUSTOMERCODE="AND VHCTPP.CUSTOMERCODE IN ('TGT','GMT','TKT','DAIKI') AND NOT EHR.Company_Code IN('RCC','RATC','RRC')";
                        }else if($selcustomer2 == 'STM - TMT SR / TAW'){
                            $objPHPExcel->getActiveSheet()->setCellValue('I7', '10 W / เครื่องยนต์ (TMT/SR)')->setCellValue('X7', '6 W TAW / TMT SR');
                            $QUERYWHERE1="EHR.PositionNameT LIKE '%STM-SR%'";
                            $QUERYWHERE2="VHCTPP.CUSTOMERCODE IN ('TMT','TAW') AND NOT (EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเขียว' OR EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเหลือง') AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' ORDER BY EHR.PositionNameT DESC";
                            $QUERYIFELSE1="OTSN.OIL_BILLNUMBER IS NOT NULL AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' AND VHCTPP.VEHICLETYPE = '10W'";
                            $QUERYIFELSE2="OTSN.OIL_BILLNUMBER IS NOT NULL AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' AND VHCTPP.VEHICLETYPE = '6W'";
                            $CUSTOMERCODE="AND VHCTPP.VEHICLETYPE = '10W'";
                        }else if($selcustomer2 == 'STC 10 W'){
                            $objPHPExcel->getActiveSheet()->setCellValue('I7', '10 W / WELLGROW-OTHER')->setCellValue('X7', '10 W / AMATA');
                            $QUERYWHERE1="EHR.PositionNameT LIKE '%พนักงานขับรถ%' AND EHR.Company_Code = 'RKR' AND NOT EHR.PositionNameT IN ('พนักงานขับรถ/CS','พนักงานขับรถ/RKL-STC') AND NOT EHR.PositionNameT LIKE '%KUBOTA%'";
                            $QUERYWHERE2="VHCTPP.CUSTOMERCODE IN('TTASTSTC','GMT') AND NOT EHR.Company_Code IN ('RCC','RRC','RATC') AND NOT VHCTPP.COMPANYCODE IN('RKL') AND NOT (EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเขียว' OR EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเหลือง' OR EHR.PositionNameT LIKE '%RKL-STC%')  AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' ORDER BY EHR.PositionNameT DESC";
                            $QUERYIFELSE1="OTSN.OIL_BILLNUMBER IS NOT NULL AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' AND VHCTPP.VEHICLETYPE LIKE '10W%' AND NOT VHCTPP.VEHICLETYPE LIKE '%10W(AMT)%'";
                            $QUERYIFELSE2="OTSN.OIL_BILLNUMBER IS NOT NULL AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' AND VHCTPP.VEHICLETYPE = '10W(AMT)'";
                            $CUSTOMERCODE="AND VHCTPP.VEHICLETYPE LIKE '10W%'";
                            // $CUSTOMERCODE="AND VHCTPP.VEHICLETYPE LIKE '10W%' AND NOT VHCTPP.VEHICLETYPE LIKE '%10W(AMT)%'";
                        }else if($selcustomer2 == 'STC TL'){
                            $objPHPExcel->getActiveSheet()->setCellValue('I7', 'TL OTHER')->setCellValue('X7', 'TL AMATA');
                            $QUERYWHERE1="(EHR.PositionNameT LIKE '%พนักงานขับรถ/RKL-STC%' OR EHR.PositionNameT LIKE '%พนักงานขับรถ/Other RKL%') AND EHR.Company_Code = 'RKL' ";
                            // $QUERYWHERE2="NOT VHCTPP.CUSTOMERCODE = 'SKB' AND NOT EHR.Company_Code IN('RKR','RCC','RATC','RRC')  AND NOT (EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเขียว' OR EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเหลือง')  AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' ORDER BY EHR.PositionNameT DESC";
                            $QUERYWHERE2="VHCTPP.CUSTOMERCODE IN('TTASTSTC','CH-AUTO','GMT','TKT','TTAT') AND VHCTPP.VEHICLETYPE LIKE '%Trailer%' AND NOT EHR.Company_Code IN ('RKR','RCC','RRC','RATC') AND NOT (EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเขียว' OR EHR.PositionNameT LIKE 'พนักงานขับรถ/ปลอกเหลือง')  AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' ORDER BY EHR.PositionNameT DESC";
                            $QUERYIFELSE1="OTSN.OIL_BILLNUMBER IS NOT NULL AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' AND NOT VHCTPP.VEHICLETYPE LIKE '%Trailer(AMT)%'";
                            $QUERYIFELSE2="OTSN.OIL_BILLNUMBER IS NOT NULL AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' AND VHCTPP.VEHICLETYPE = 'Trailer(AMT)'";
                            $CUSTOMERCODE="AND NOT VHCTPP.CUSTOMERCODE IN('SKB')";
                            // $CUSTOMERCODE="AND NOT VHCTPP.VEHICLETYPE LIKE '%Trailer(AMT)%' AND NOT VHCTPP.CUSTOMERCODE IN('SKB')";
                        }
                        $objPHPExcel->getActiveSheet()->mergeCells('U7:U9');
                        $objPHPExcel->getActiveSheet()->mergeCells('V7:V9');
                        $objPHPExcel->getActiveSheet()->mergeCells('W7:W9');
                        $objPHPExcel->getActiveSheet()->mergeCells('X7:AI7');
                        $objPHPExcel->getActiveSheet()->mergeCells('X8:X9');
                        $objPHPExcel->getActiveSheet()->mergeCells('Y8:Y9');
                        $objPHPExcel->getActiveSheet()->mergeCells('Z8:Z9');
                        $objPHPExcel->getActiveSheet()->mergeCells('AA8:AA9');
                        $objPHPExcel->getActiveSheet()->mergeCells('AB8:AB9');
                        $objPHPExcel->getActiveSheet()->mergeCells('AC8:AC9');
                        $objPHPExcel->getActiveSheet()->mergeCells('AD8:AD9');
                        $objPHPExcel->getActiveSheet()->mergeCells('AF8:AF9');
                        $objPHPExcel->getActiveSheet()->mergeCells('AJ7:AJ9');
                        $objPHPExcel->getActiveSheet()->mergeCells('AK7:AK9');  
                        $objPHPExcel->getActiveSheet()->mergeCells('AL7:AL9');  
                        $objPHPExcel->getActiveSheet()
                        ->setCellValue('U7', 'ทะเบียนรถ') 
                        ->setCellValue('V7', 'ประเภทรถ')
                        ->setCellValue('W7', 'งานที่ขนส่ง')
                        ->setCellValue('X8', 'ไมล์ต้น')
                        ->setCellValue('Y8', 'ไมล์ปลาย')
                        ->setCellValue('Z8', 'ระยะทาง')
                        ->setCellValue('AA8', 'เติมใน/ลิตร')
                        ->setCellValue('AB8', 'เติมนอก/ลิตร')
                        ->setCellValue('AC8', 'หัก PM')
                        ->setCellValue('AD8', 'รวมจำนวนลิตร')
                        ->setCellValue('AE8', 'ค่าเฉลี่ยที่')
                        ->setCellValue('AE9', 'กำหนด')
                        ->setCellValue('AF8', 'ค่าเฉลี่ยที่ได้')
                        ->setCellValue('AG8', 'จำนวนน้ำมันที่')
                        ->setCellValue('AG9', 'เกินกว่ากำหนด')
                        ->setCellValue('AH8', 'จำนวนบาท/')
                        ->setCellValue('AH9', 'ลิตร')
                        ->setCellValue('AI8', 'จำนวนเงินที่ได้')
                        ->setCellValue('AI9', 'บาท')
                        ->setCellValue('AJ7', 'รวมน้ำมัน')
                        ->setCellValue('AK7', 'รวมเงิน')
                        ->setCellValue('AL7', 'หมายเหตุ');                 
                        $sheet->getColumnDimension('U')->setWidth(10);
                        $sheet->getColumnDimension('V')->setWidth(15);
                        $sheet->getColumnDimension('W')->setWidth(20);
                        $sheet->getColumnDimension('X')->setWidth(12);
                        $sheet->getColumnDimension('Y')->setWidth(12);
                        $sheet->getColumnDimension('Z')->setWidth(12);
                        $sheet->getColumnDimension('AA')->setWidth(12);
                        $sheet->getColumnDimension('AB')->setWidth(12);
                        $sheet->getColumnDimension('AC')->setWidth(12);
                        $sheet->getColumnDimension('AD')->setWidth(12);
                        $sheet->getColumnDimension('AE')->setWidth(8);
                        $sheet->getColumnDimension('AF')->setWidth(12);
                        $sheet->getColumnDimension('AG')->setWidth(12);
                        $sheet->getColumnDimension('AH')->setWidth(12);
                        $sheet->getColumnDimension('AI')->setWidth(12);
                        $sheet->getColumnDimension('AJ')->setWidth(12);
                        $sheet->getColumnDimension('AK')->setWidth(12);
                        $sheet->getColumnDimension('AL')->setWidth(50);
                        $sheet->getStyle('U7:W9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '8FBC8F'))));//เขียว
                        $sheet->getStyle('X7:AI7')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '8FBC8F'))));//เขียว
                        $sheet->getStyle('X8:Y9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '8FBC8F'))));//เขียว
                        $sheet->getStyle('Z8:Z9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));//เหลือง
                        $sheet->getStyle('AA8:AC9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '8FBC8F'))));//เขียว
                        $sheet->getStyle('AD8:AD9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));//เหลือง
                        $sheet->getStyle('AE8:AH9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '8FBC8F'))));//เขียว
                        $sheet->getStyle('AI8:AI9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));//เหลือง
                        $sheet->getStyle('AJ7:AL9')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FF8C00'))));//ส้ม
                        $sheet->getStyle('U7:W9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('AJ7:AL9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('X7:AI7')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('X8:AD9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('AD8:AD9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('AF8:AF9')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('AG8:AG9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        $sheet->getStyle('AH8:AH9')->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                    }

                    // ส่วนที่ 1 ปิดใช้ O4 และ JOBNO สำหรับการแสดงข้อมูลเติมน้ำมัน 2 รอบ และปิดสำหรับสายงานด้านล่าง เนื่องงจากมีตารางฝั่งซ้ายและฝั่งขวา ถ้ามีเติมทั้งซ้ายและขวา ข้อมูลจะแสดงทั้ง 2 บรรทัด ทั้งๆที่ผู้ใช้งานต้องการให้แสดงแค่บรรทัดเดียว
                    if($selcustomer2 == 'TGT/DAIKI'){
                        $DOUBLEFIELD="EHR.nameT EMPN";
                    }else{
                        $DOUBLEFIELD="EHR.nameT EMPN,VHCTPP.O4,VHCTPP.JOBNO";
                    }
                    $SQLEMP_CENTER = "SELECT DISTINCT EHR.PersonCode EMPC,EHR.Company_Code,EHR.Company_NameT,EHR.PositionNameT,EHR.FnameT,EHR.LnameT,".$DOUBLEFIELD."
                        FROM vwEMPLOYEEEHR2 EHR 
                        FULL OUTER JOIN VEHICLETRANSPORTPLAN VHCTPP ON (VHCTPP.EMPLOYEENAME1 = EHR.nameT OR VHCTPP.EMPLOYEENAME2 = EHR.nameT) 
                            AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' 
                            AND VHCTPP.O4 IS NOT NULL AND VHCTPP.C3 IS NOT NULL ".$CUSTOMERCODE."
                        FULL OUTER JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI AND OTSN.OIL_BILLNUMBER IS NOT NULL
                        WHERE $QUERYWHERE1
                        UNION
                        SELECT DISTINCT EHR.PersonCode EMPC,EHR.Company_Code,EHR.Company_NameT,EHR.PositionNameT,EHR.FnameT,EHR.LnameT,".$DOUBLEFIELD."
                        FROM vwEMPLOYEEEHR2 EHR
                        LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON (VHCTPP.EMPLOYEENAME1 = EHR.nameT OR VHCTPP.EMPLOYEENAME2 = EHR.nameT) AND VHCTPP.O4 IS NOT NULL ".$CUSTOMERCODE."
                        WHERE $QUERYWHERE2";
                        $QUERYEMP_CENTER = sqlsrv_query($conn, $SQLEMP_CENTER );     
                        $i = "10";
                        $numpage = "1";
                        while($RSEMP_CENTER = sqlsrv_fetch_array($QUERYEMP_CENTER)) {      
                                $pieces = explode(" ", $RSEMP_CENTER["EMPN"]);
                                $fname=$pieces[0];
                                $lname=$pieces[1];
                                $EMPN=$RSEMP_CENTER["EMPN"];  
                                $EMPC=$RSEMP_CENTER["EMPC"];   
                                $JOBNO=$RSEMP_CENTER["JOBNO"];   
                                        
                            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $numpage);
                            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $EMPC);
                            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $fname);
                            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $lname);  

                        // ส่วนที่ 2 ปิดใช้ O4 และ JOBNO สำหรับการแสดงข้อมูลเติมน้ำมัน 2 รอบ และปิดสำหรับสายงานด้านล่าง เนื่องงจากมีตารางฝั่งซ้ายและฝั่งขวา ถ้ามีเติมทั้งซ้ายและขวา ข้อมูลจะแสดงทั้ง 2 บรรทัด ทั้งๆที่ผู้ใช้งานต้องการให้แสดงแค่บรรทัดเดียว
                        if($selcustomer2 == 'TGT/DAIKI'){
                            $DOUBLEFUEL="(VHCTPP.EMPLOYEENAME1 = '$EMPN' OR VHCTPP.EMPLOYEENAME2 ='$EMPN')";
                        }else{
                            $DOUBLEFUEL="VHCTPP.JOBNO = '$JOBNO'";
                        }
                        if($selcustomer2 != 'KUBOTA'){
                            $SQLPLAN_LEFT="SELECT DISTINCT PositionNameT PSTN,VHCTPP.COMPANYCODE COM,VHCTPP.CUSTOMERCODE CUS,OTSN.OILDATAID OILID,VHCTPP.EMPLOYEECODE1 EMPC1,VHCTPP.EMPLOYEENAME1 EMPN1,VHCTPP.EMPLOYEECODE2 EMPC2,VHCTPP.EMPLOYEENAME2 EMPN2,CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) DW,CONVERT (VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,OTSN.OIL_BILLNUMBER OBLNB,OTSN.VEHICLEREGISNUMBER VHCRGNB,OTSN.VEHICLETYPE CARTYPE,VHCTPP.VEHICLETYPE VHCTPLAN,VHCTPP.JOBSTART JOBSTART,VHCTPP.JOBEND JOBEND,OTSN.MILEAGESTART MST,OTSN.MILEAGEEND MLE,OTSN.DISTANCE DTE,OTSN.OIL_AMOUNT,OTSN.OIL_AVERAGE OAVG,OTSN.OIL_TARGET OTG,VHCTPP.C3 AVG,VHCTPP.E1 MONEY,OTSN.JOBNO,VHCTPP.JOBNO,
                            (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID) AS OAM,
                            (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID AND OSGS_TY IN(1,2,3)) AS OAMOUT,
                            (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID AND OSGS_TY = 4) AS OAMPM
                                FROM vwEMPLOYEEEHR2 EHR
                                LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON (VHCTPP.EMPLOYEENAME1 = EHR.nameT OR VHCTPP.EMPLOYEENAME2 = EHR.nameT)
                                LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                                WHERE ".$DOUBLEFUEL." AND $QUERYIFELSE1";
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
                                    
                                    if($RSPLAN_LEFT["OIL_AMOUNT"]>0){
                                        $OILAMOUNTLEFT=$RSPLAN_LEFT["OIL_AMOUNT"];
                                    }else{
                                        $OILAMOUNTLEFT='';
                                    }
                                    if($RSPLAN_LEFT["OAMOUT"]>0){
                                        $OAMOUTLEFT=$RSPLAN_LEFT["OAMOUT"];
                                    }else{
                                        $OAMOUTLEFT='';
                                    }
                                    if($RSPLAN_LEFT["OAMPM"]>0){
                                        $OAMPMLEFT=$RSPLAN_LEFT["OAMPM"];
                                    }else{
                                        $OAMPMLEFT='';
                                    }
                                    if(($OILAMOUNTLEFT>0)&&($OAMOUTLEFT>0)&&($OAMPMLEFT>0)){
                                        $OAM_LEFT=($OILAMOUNTLEFT+$OAMOUTLEFT)-$OAMPMLEFT;
                                        $OAM_RSLEFT='=(L'.$i.'+M'.$i.')-N'.$i;
                                        $REMARKOILLEFT='(เติมใน+เติมนอก)-PM ... ('.$OILAMOUNTLEFT.'+'.$OAMOUTLEFT.')-'.$OAMPMLEFT.' = '.$OAM_LEFT.' ลิตร';
                                    }else if(($OILAMOUNTLEFT>0)&&($OAMOUTLEFT>0)&&($OAMPMLEFT=='')){
                                        $OAM_LEFT=$OILAMOUNTLEFT+$OAMOUTLEFT;
                                        $OAM_RSLEFT='=L'.$i.'+M'.$i;
                                        $REMARKOILLEFT='เติมใน+เติมนอก ... '.$OILAMOUNTLEFT.'+'.$OAMOUTLEFT.' = '.$OAM_LEFT.' ลิตร';
                                    }else if(($OILAMOUNTLEFT>0)&&($OAMOUTLEFT=='')&&($OAMPMLEFT>0)){
                                        $OAM_LEFT=$OILAMOUNTLEFT-$OAMPMLEFT;
                                        $OAM_RSLEFT='=L'.$i.'-N'.$i;
                                        $REMARKOILLEFT='เติมใน-PM ... '.$OILAMOUNTLEFT.'-'.$OAMPMLEFT.' = '.$OAM_LEFT.' ลิตร';
                                    }else{
                                        $OAM_LEFT=$OILAMOUNTLEFT;
                                        $OAM_RSLEFT=$OILAMOUNTLEFT;
                                        $REMARKOILLEFT='';
                                    }
                                    // $OILAMOUNTLEFT=$RSPLAN_LEFT["OIL_AMOUNT"];
                                    // $OAMRIGHT=$RSPLAN_LEFT["OAM"];
                                    // $OAM_LEFT=$OILAMOUNTLEFT+$OAMRIGHT;

                                    $OTG_LEFT=$RSPLAN_LEFT["OTG"];
                                    $OAVG_LEFT=$RSPLAN_LEFT["OAVG"];                                  
                                    $EMPC1_LEFT=$RSPLAN_LEFT["EMPC1"];
                                    $EMPC2_LEFT=$RSPLAN_LEFT["EMPC2"];                                
        
                                    $SQLPRICE_LEFT = "SELECT OLP.PRICE,OLP.COMPANYCODE,OLP.[MONTH],OLP.[YEAR] FROM OILPEICE OLP WHERE OLP.COMPANYCODE = '$COM_LEFT' AND OLP.[YEAR] = '$start_yen' AND OLP.[MONTH] = '$selectmonth'";
                                    $QUERYPRICE_LEFT = sqlsrv_query($conn, $SQLPRICE_LEFT);
                                    $RSPRICE_LEFT = sqlsrv_fetch_array($QUERYPRICE_LEFT, SQLSRV_FETCH_ASSOC);   
                                        $PRICE_LEFT=$RSPRICE_LEFT["PRICE"];

                                    $SQLROUND_LEFT="SELECT COUNT(VHCTPP.EMPLOYEECODE1) AS ROUND FROM VEHICLETRANSPORTPLAN VHCTPP WHERE VHCTPP.COMPANYCODE = '$COM_LEFT' AND (VHCTPP.EMPLOYEENAME1 = '$EMPN' OR VHCTPP.EMPLOYEENAME2 ='$EMPN') AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' GROUP BY VHCTPP.EMPLOYEECODE1 ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                        $QUERYROUND_LEFT = sqlsrv_query($conn, $SQLROUND_LEFT ); while($RSROUND_LEFT = sqlsrv_fetch_array($QUERYROUND_LEFT)) { $ROUND=$RSROUND_LEFT["ROUND"];   
                                            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $ROUND); // แก้แล้ว;
                                        }
                                
                                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $VHCRGNB_LEFT); // แก้แล้ว;
                                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $VHCTPLAN_LEFT); // แก้แล้ว;

                                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $RSJOB_LEFT); // แก้แล้ว;
                                    $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $MST_LEFT); // แก้แล้ว;
                                    $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $MLE_LEFT); // แก้แล้ว;
                                    $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, '=J'.$i.'-I'.$i); // แก้แล้ว;
                                    $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $OILAMOUNTLEFT); // แก้แล้ว;            
                                    $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $OAMOUTLEFT); // แก้แล้ว;            
                                    $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $OAMPMLEFT); // แก้แล้ว;            
                                    // $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $OAM_RSLEFT); // แก้แล้ว;    
                                    $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, '=(L'.$i.'+M'.$i.')-N'.$i); // แก้แล้ว;                                              
                                    $SQLOAVG_LEFT="SELECT DISTINCT OILAVERAGE.OILAVERAGE OAVR FROM OILAVERAGE WHERE OILAVERAGE.COMPANYCODE = '$COM_LEFT' AND OILAVERAGE.CUSTOMERCODE = '$CUS_LEFT' AND OILAVERAGE.VEHICLETYPE = '$VHCTPLAN_LEFT'";
                                        $QUERYOAVG_LEFT = sqlsrv_query($conn, $SQLOAVG_LEFT ); while($RSOAVG_LEFT = sqlsrv_fetch_array($QUERYOAVG_LEFT)) {                                         
                                            if ($VHCRGNB_LEFT =='61-4456' || $VHCRGNB_LEFT =='61-3441' || $VHCRGNB_LEFT =='61-4457' ||
                                                $VHCRGNB_LEFT =='61-4913' || $VHCRGNB_LEFT =='61-4547' || $VHCRGNB_LEFT =='64-3452' || 
                                                $VHCRGNB_LEFT =='61-3445' || $VHCRGNB_LEFT =='61-3443' || $VHCRGNB_LEFT =='62-9288' || 
                                                $VHCRGNB_LEFT =='61-3836' || $VHCRGNB_LEFT =='61-4458' )
                                            {
                                                $OAVR_LEFT = 4.0;
                                            }else if($VHCRGNB_LEFT =='61-3442' || $VHCRGNB_LEFT =='61-3444' || $VHCRGNB_LEFT =='76-8919' || 
                                                    $VHCRGNB_LEFT =='61-4458' || $VHCRGNB_LEFT =='79-2521' || $VHCRGNB_LEFT =='79-2522' || 
                                                    $VHCRGNB_LEFT =='79-2525' || $VHCRGNB_LEFT =='74-5654') 
                                            {
                                                $OAVR_LEFT = 3.5;  
                                            }else if($VHCRGNB_LEFT =='61-3440' || $VHCRGNB_LEFT =='60-3868' || $VHCRGNB_LEFT =='61-3439' ||
                                                    $VHCRGNB_LEFT =='61-4546' || $VHCRGNB_LEFT =='60-3870' || $VHCRGNB_LEFT =='61-4912' ||
                                                    $VHCRGNB_LEFT =='61-3452' || $VHCRGNB_LEFT =='61-3835' || $VHCRGNB_LEFT =='61-4454' ||
                                                    $VHCRGNB_LEFT =='61-3437' || $VHCRGNB_LEFT =='61-3438' || $VHCRGNB_LEFT =='61-3834' ||
                                                    $VHCRGNB_LEFT =='61-4453' ||
                                                    $VHCRGNB_LEFT =='74-5610' || $VHCRGNB_LEFT =='74-5611' || $VHCRGNB_LEFT =='74-5612' ||
                                                    $VHCRGNB_LEFT =='74-5613' || $VHCRGNB_LEFT =='74-5658' || $VHCRGNB_LEFT =='74-5660' ||
                                                    $VHCRGNB_LEFT =='74-5675' || $VHCRGNB_LEFT =='74-5676' || $VHCRGNB_LEFT =='74-5677' ||
                                                    $VHCRGNB_LEFT =='74-5678' || $VHCRGNB_LEFT =='74-5679' || $VHCRGNB_LEFT =='74-5688' ||
                                                    $VHCRGNB_LEFT =='74-5690' ) 
                                            {
                                                if($JOBEND_LEFT=='คลังโคราช'){
                                                    $OAVR_LEFT = 3.75; // คลังโคราช ประเภทรถ 6W ใช้เรท 3.75
                                                }else{
                                                    $OAVR_LEFT = 4.25; // งานขายทั่วประเทศ ประเภทรถ 6W ใช้เรท 4.25
                                                }
                                            }else if($VHCRGNB_LEFT =='60-3871' || $VHCRGNB_LEFT =='60-2391' ||
                                                    $VHCRGNB_LEFT =='74-5653' || $VHCRGNB_LEFT =='74-5684' ) 
                                            {
                                                if($JOBEND_LEFT=='คลังโคราช'){
                                                    $OAVR_LEFT = 3.00; // คลังโคราช ประเภทรถ 10W ใช้เรท 3.00 มีทะเบียน 74-5653 และ 74-5684
                                                }else{
                                                    $OAVR_LEFT = 3.75; // งานขายทั่วประเทศ ประเภทรถ 10W ใช้เรท 3.75 มีทะเบียน 74-5653 และ 74-5684
                                                }
                                            }else{
                                                if($JOBEND_LEFT=='BJKC + INGY' || $JOBEND_LEFT=='INGY' || 
                                                    $JOBEND_LEFT=='INGY (Rayong)' || $JOBEND_LEFT=='INGY+BJKC (Rayong)' ){
                                                        $OAVR_LEFT = 6.50;
                                                }else{
                                                    $OAVR_LEFT = $RSOAVG_LEFT["OAVR"]; 
                                                }
                                            }

                                            $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $OAVR_LEFT); // แก้แล้ว;
                                        }
                                           
                                    // $KCOLUMN=$DTE_LEFT / $OAM_LEFT ;
                                    // $OCOLUMN=($DTE_LEFT / $OAVR_LEFT) - $OAM_LEFT ;
                                    // $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $KCOLUMN); // แก้แล้ว;
                                    // $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, round($OCOLUMN)); // แก้แล้ว; 
                                    $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, '=K'.$i.'/O'.$i); // แก้แล้ว;
                                    // $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, '=ROUND(((K'.$i.'/P'.$i.')-O'.$i.'),0)'); // แก้แล้ว;  
                                    $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, '=ROUND((ROUND((K'.$i.'/P'.$i.'),2)-O'.$i.'),0)'); // แก้แล้ว;
                                    $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $PRICE_LEFT); // แก้แล้ว;
                                    
                                    if($EMPC2_LEFT != ""){                                        
                                        if($EMPC2_LEFT==$EMPC1_LEFT){
                                            $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, '=R'.$i.'*S'.$i); // แก้แล้ว; 
                                        }else if($EMPC2_LEFT!=$EMPC1_LEFT){
                                            if( ($selcustomer2 == 'KUBOTA') || (($RSJOB_LEFT=="TAKANO")||($RSJOB_LEFT=="KEIHIN")||($RSJOB_LEFT=="KEIHIN,TAKANO")||($RSJOB_LEFT=="INGY")||($RSJOB_LEFT=="BJKC + INGY")) ){
                                                $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, '=(R'.$i.'*S'.$i.')/2'); // แก้แล้ว;  
                                            }else{
                                                $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, '=R'.$i.'*S'.$i); // แก้แล้ว; 
                                            }
                                        }
                                    }else{
                                        $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, '=R'.$i.'*S'.$i); // แก้แล้ว; 
                                    }  
                                    // $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, '=R'.$i.'*S'.$i); // แก้แล้ว;                            
                                    if(($selcustomer2 == 'CS') || ($selcustomer2 == 'T.TOHKEN') || ($selcustomer2 == 'STM - IP')){
                                        $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, '=R'.$i.'*1'); // แก้แล้ว;                                                                                   
                                        $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, '=ROUND((T'.$i.'*1),0)'); // แก้แล้ว;
                                        $objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $REMARKOILLEFT); // แก้แล้ว;
                                    }else if(($selcustomer2 == 'KUBOTA') || ($selcustomer2 == 'TGT/DAIKI') || ($selcustomer2 == 'STM - TMT SR / TAW') || ($selcustomer2 == 'STC 10 W') || ($selcustomer2 == 'STC TL')){
                                        $objPHPExcel->getActiveSheet()->setCellValue('AJ' . $i, '=R'.$i.'+AG'.$i); // แก้แล้ว;
                                        $objPHPExcel->getActiveSheet()->setCellValue('AK' . $i, '=ROUND((T'.$i.'+AI'.$i.'),0)'); // แก้แล้ว;
                                        $objPHPExcel->getActiveSheet()->setCellValue('AL' . $i, $REMARKOILRIGHT); // แก้แล้ว;
                                    }
                                }
                            if(($selcustomer2 == 'TGT/DAIKI') || ($selcustomer2 == 'STM - TMT SR / TAW') || ($selcustomer2 == 'STC 10 W') || ($selcustomer2 == 'STC TL')){
                                    $SQLPLAN_RIGHT="SELECT DISTINCT PositionNameT PSTN,VHCTPP.COMPANYCODE COM,VHCTPP.CUSTOMERCODE CUS,OTSN.OILDATAID OILID,VHCTPP.EMPLOYEECODE1 EMPC1,VHCTPP.EMPLOYEENAME1 EMPN1,VHCTPP.EMPLOYEECODE2 EMPC2,CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) DW,CONVERT (VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,OTSN.OIL_BILLNUMBER OBLNB,OTSN.VEHICLEREGISNUMBER VHCRGNB,OTSN.VEHICLETYPE CARTYPE,VHCTPP.VEHICLETYPE VHCTPLAN,VHCTPP.JOBSTART JOBSTART,VHCTPP.JOBEND JOBEND,OTSN.MILEAGESTART MST,OTSN.MILEAGEEND MLE,OTSN.DISTANCE DTE,OTSN.OIL_AMOUNT,OTSN.OIL_AVERAGE OAVG,OTSN.OIL_TARGET OTG,VHCTPP.C3 AVG,VHCTPP.E1 MONEY,OTSN.JOBNO,VHCTPP.JOBNO,
                                    (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID) AS OAM,
                                    (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID AND OSGS_TY IN(1,2,3)) AS OAMOUT,
                                    (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID AND OSGS_TY = 4) AS OAMPM
                                    FROM vwEMPLOYEEEHR2 EHR
                                    LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON (VHCTPP.EMPLOYEENAME1 = EHR.nameT OR VHCTPP.EMPLOYEENAME2 = EHR.nameT)
                                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                                    WHERE ".$DOUBLEFUEL." AND $QUERYIFELSE2";
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
                                        
                                        if($RSPLAN_RIGHT["OIL_AMOUNT"]>0){
                                            $OILAMOUNTRIGHT=$RSPLAN_RIGHT["OIL_AMOUNT"];
                                        }else{
                                            $OILAMOUNTRIGHT='';
                                        }
                                        if($RSPLAN_RIGHT["OAMOUT"]>0){
                                            $OAMOUTRIGHT=$RSPLAN_RIGHT["OAMOUT"];
                                        }else{
                                            $OAMOUTRIGHT='';
                                        }
                                        if($RSPLAN_RIGHT["OAMPM"]>0){
                                            $OAMPMRIGHT=$RSPLAN_RIGHT["OAMPM"];
                                        }else{
                                            $OAMPMRIGHT='';
                                        }
                                        if(($OILAMOUNTRIGHT>0)&&($OAMOUTRIGHT>0)&&($OAMPMRIGHT>0)){
                                            $OAM_RIGHT=($OILAMOUNTRIGHT+$OAMOUTRIGHT)-$OAMPMRIGHT;
                                            $OAM_RSRIGHT='=(AA'.$i.'+AB'.$i.')-AC'.$i;
                                            $REMARKOILRIGHT='(เติมใน+เติมนอก)-PM ... ('.$OILAMOUNTRIGHT.'+'.$OAMOUTRIGHT.')-'.$OAMPMRIGHT.' = '.$OAM_RIGHT.' ลิตร';
                                        }else if(($OILAMOUNTRIGHT>0)&&($OAMOUTRIGHT>0)&&($OAMPMRIGHT=='')){
                                            $OAM_RIGHT=$OILAMOUNTRIGHT+$OAMOUTRIGHT;
                                            $OAM_RSRIGHT='=AA'.$i.'+AB'.$i;
                                            $REMARKOILRIGHT='เติมใน+เติมนอก ... '.$OILAMOUNTRIGHT.'+'.$OAMOUTRIGHT.' = '.$OAM_RIGHT.' ลิตร';
                                        }else if(($OILAMOUNTRIGHT>0)&&($OAMOUTRIGHT=='')&&($OAMPMRIGHT>0)){
                                            $OAM_RIGHT=$OILAMOUNTRIGHT-$OAMPMRIGHT;
                                            $OAM_RSRIGHT='=AA'.$i.'-AC'.$i;
                                            $REMARKOILRIGHT='เติมใน-PM ... '.$OILAMOUNTRIGHT.'-'.$OAMPMRIGHT.' = '.$OAM_RIGHT.' ลิตร';
                                        }else{
                                            $OAM_RIGHT=$OILAMOUNTRIGHT;
                                            $OAM_RSRIGHT=$OILAMOUNTRIGHT;
                                            $REMARKOILRIGHT='';
                                        }
                                        // $OILAMOUNTRIGHT=$RSPLAN_RIGHT["OIL_AMOUNT"];
                                        // $OAMRIGHT=$RSPLAN_RIGHT["OAM"];
                                        // $OAM_RIGHT=$OILAMOUNTRIGHT+$OAMRIGHT;

                                        $OTG_RIGHT=$RSPLAN_RIGHT["OTG"];
                                        $OAVG_RIGHT=$RSPLAN_RIGHT["OAVG"];                               
                                        $EMPC1_RIGHT=$RSPLAN_RIGHT["EMPC1"];
                                        $EMPC2_RIGHT=$RSPLAN_RIGHT["EMPC2"];                                    
            
                                $SQLPRICE_RIGHT = "SELECT OLP.PRICE,OLP.COMPANYCODE,OLP.[MONTH],OLP.[YEAR]   
                                FROM OILPEICE OLP WHERE OLP.COMPANYCODE = '$COM_RIGHT' AND OLP.[YEAR] = '$start_yen' AND OLP.[MONTH] = '$selectmonth'"; 
                                $QUERYPRICE_RIGHT = sqlsrv_query($conn, $SQLPRICE_RIGHT);
                                $RSPRICE_RIGHT = sqlsrv_fetch_array($QUERYPRICE_RIGHT, SQLSRV_FETCH_ASSOC);   
                                    $PRICE_RIGHT=$RSPRICE_RIGHT["PRICE"];

                                    $SQLROUND_RIGHT="SELECT COUNT(VHCTPP.EMPLOYEECODE1) AS ROUND FROM VEHICLETRANSPORTPLAN VHCTPP WHERE VHCTPP.COMPANYCODE = '$COM_RIGHT' AND (VHCTPP.EMPLOYEENAME1 = '$EMPN' OR VHCTPP.EMPLOYEENAME2 ='$EMPN') AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' GROUP BY VHCTPP.EMPLOYEECODE1 ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                    $QUERYROUND_RIGHT = sqlsrv_query($conn, $SQLROUND_RIGHT ); while($RSROUND_RIGHT = sqlsrv_fetch_array($QUERYROUND_RIGHT)) { $ROUND=$RSROUND_RIGHT["ROUND"];   
                                        $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $ROUND); // แก้แล้ว;
                                    }

                                    $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $VHCRGNB_RIGHT); // แก้แล้ว;
                                    $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $VHCTPLAN_RIGHT); // แก้แล้ว;

                                    $objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $RSJOB_RIGHT); // แก้แล้ว;
                                    $objPHPExcel->getActiveSheet()->setCellValue('X' . $i, $MST_RIGHT); // แก้แล้ว;
                                    $objPHPExcel->getActiveSheet()->setCellValue('Y' . $i, $MLE_RIGHT); // แก้แล้ว;
                                    $objPHPExcel->getActiveSheet()->setCellValue('Z' . $i, '=Y'.$i.'-X'.$i); // แก้แล้ว;
                                    $objPHPExcel->getActiveSheet()->setCellValue('AA' . $i, $OILAMOUNTRIGHT);  // แก้แล้ว;
                                    $objPHPExcel->getActiveSheet()->setCellValue('AB' . $i, $OAMOUTRIGHT); // แก้แล้ว;
                                    $objPHPExcel->getActiveSheet()->setCellValue('AC' . $i, $OAMPMRIGHT); // แก้แล้ว;
                                    // $objPHPExcel->getActiveSheet()->setCellValue('AD' . $i, $OAM_RSRIGHT); // แก้แล้ว;  
                                    $objPHPExcel->getActiveSheet()->setCellValue('AD' . $i, '=(AA'.$i.'+AB'.$i.')-AC'.$i); // แก้แล้ว;                                           
                                    $SQLOAVG_RIGHT="SELECT DISTINCT OILAVERAGE.OILAVERAGE OAVR FROM OILAVERAGE WHERE OILAVERAGE.COMPANYCODE = '$COM_RIGHT' AND OILAVERAGE.CUSTOMERCODE = '$CUS_RIGHT' AND OILAVERAGE.VEHICLETYPE = '$VHCTPLAN_RIGHT'";
                                    $QUERYOAVG_RIGHT = sqlsrv_query($conn, $SQLOAVG_RIGHT ); while($RSOAVG_RIGHT = sqlsrv_fetch_array($QUERYOAVG_RIGHT)) {                                         
                                        if ($VHCRGNB_RIGHT =='61-4456' || $VHCRGNB_RIGHT =='61-3441' || $VHCRGNB_RIGHT =='61-4457' ||
                                            $VHCRGNB_RIGHT =='61-4913' || $VHCRGNB_RIGHT =='61-4547' || $VHCRGNB_RIGHT =='64-3452' || 
                                            $VHCRGNB_RIGHT =='61-3445' || $VHCRGNB_RIGHT =='61-3443' || $VHCRGNB_RIGHT =='62-9288' || 
                                            $VHCRGNB_RIGHT =='61-3836' || $VHCRGNB_RIGHT =='61-4458' )
                                        {
                                        $OAVR_RIGHT = 4.0;
                                        }else if($VHCRGNB_RIGHT =='61-3442' || $VHCRGNB_RIGHT =='61-3444' || $VHCRGNB_RIGHT =='76-8919' || 
                                                $VHCRGNB_RIGHT =='61-4458' || $VHCRGNB_RIGHT =='79-2521' || $VHCRGNB_RIGHT =='79-2522' || 
                                                $VHCRGNB_RIGHT =='79-2525' || $VHCRGNB_RIGHT =='74-5654') 
                                        {
                                        $OAVR_RIGHT = 3.5;  
                                        }else if($VHCRGNB_RIGHT =='61-3440' || $VHCRGNB_RIGHT =='60-3868' || $VHCRGNB_RIGHT =='61-3439' ||
                                                $VHCRGNB_RIGHT =='61-4546' || $VHCRGNB_RIGHT =='60-3870' || $VHCRGNB_RIGHT =='61-4912' ||
                                                $VHCRGNB_RIGHT =='61-3452' || $VHCRGNB_RIGHT =='61-3835' || $VHCRGNB_RIGHT =='61-4454' ||
                                                $VHCRGNB_RIGHT =='61-3437' || $VHCRGNB_RIGHT =='61-3438' || $VHCRGNB_RIGHT =='61-3834' ||
                                                $VHCRGNB_RIGHT =='61-4453' ||
                                                $VHCRGNB_RIGHT =='74-5610' || $VHCRGNB_RIGHT =='74-5611' || $VHCRGNB_RIGHT =='74-5612' ||
                                                $VHCRGNB_RIGHT =='74-5613' || $VHCRGNB_RIGHT =='74-5658' || $VHCRGNB_RIGHT =='74-5660' ||
                                                $VHCRGNB_RIGHT =='74-5675' || $VHCRGNB_RIGHT =='74-5676' || $VHCRGNB_RIGHT =='74-5677' ||
                                                $VHCRGNB_RIGHT =='74-5678' || $VHCRGNB_RIGHT =='74-5679' || $VHCRGNB_RIGHT =='74-5688' ||
                                                $VHCRGNB_RIGHT =='74-5690' ) 
                                        {
                                            if($JOBEND_RIGHT=='คลังโคราช'){
                                                $OAVR_RIGHT = 3.75; // คลังโคราช ประเภทรถ 6W ใช้เรท 3.75
                                            }else{
                                                $OAVR_RIGHT = 4.25; // งานขายทั่วประเทศ ประเภทรถ 6W ใช้เรท 4.25
                                            }
                                        }else if($VHCRGNB_RIGHT =='60-3871' || $VHCRGNB_RIGHT =='60-2391' ||
                                        $VHCRGNB_RIGHT =='74-5653' || $VHCRGNB_RIGHT =='74-5684' ) 
                                        {
                                            if($JOBEND_RIGHT=='คลังโคราช'){
                                                $OAVR_RIGHT = 3.00; // คลังโคราช ประเภทรถ 10W ใช้เรท 3.00 มีทะเบียน 74-5653 และ 74-5684
                                            }else{
                                                $OAVR_RIGHT = 3.75; // งานขายทั่วประเทศ ประเภทรถ 10W ใช้เรท 3.75 มีทะเบียน 74-5653 และ 74-5684
                                            }
                                        }else{
                                            if($JOBEND_RIGHT=='BJKC + INGY' || $JOBEND_RIGHT=='INGY' || 
                                                $JOBEND_RIGHT=='INGY (Rayong)' || $JOBEND_RIGHT=='INGY+BJKC (Rayong)' ){
                                                    $OAVR_RIGHT = 6.50;
                                            }else{
                                                $OAVR_RIGHT = $RSOAVG_RIGHT["OAVR"]; 
                                            }
                                        }
                                        
                                        $objPHPExcel->getActiveSheet()->setCellValue('AE' . $i, $OAVR_RIGHT); // แก้แล้ว;
                                    }
                                    
                                    // $ZCOLUMN=$DTE_RIGHT / $OAM_RIGHT ;
                                    // $AACOLUMN=($DTE_RIGHT / $OAVR_RIGHT) - $OAM_RIGHT ;
                                    // $objPHPExcel->getActiveSheet()->setCellValue('AF' . $i, $ZCOLUMN); // แก้แล้ว;
                                    // $objPHPExcel->getActiveSheet()->setCellValue('AG' . $i, round($AACOLUMN)); // แก้แล้ว;
                                    $objPHPExcel->getActiveSheet()->setCellValue('AF' . $i, '=Z'.$i.'/AD'.$i); // แก้แล้ว;    
                                    // $objPHPExcel->getActiveSheet()->setCellValue('AG' . $i, '=ROUND(((Z'.$i.'/AE'.$i.')-AD'.$i.'),0)'); // แก้แล้ว;
                                    $objPHPExcel->getActiveSheet()->setCellValue('AG' . $i, '=ROUND((ROUND((Z'.$i.'/AE'.$i.'),2)-AD'.$i.'),0)'); // แก้แล้ว;                                                                                                            
                                    $objPHPExcel->getActiveSheet()->setCellValue('AH' . $i, $PRICE_RIGHT); // แก้แล้ว;
                                    
                                    if($EMPC2_RIGHT != ""){
                                        if($EMPC2_RIGHT==$EMPC1_RIGHT){
                                            $objPHPExcel->getActiveSheet()->setCellValue('AI' . $i, '=AG'.$i.'*AH'.$i); // แก้แล้ว; 
                                        }else if($EMPC2_RIGHT!=$EMPC1_RIGHT){
                                            if( ($selcustomer2 == 'KUBOTA') || (($RSJOB_RIGHT=="TAKANO")||($RSJOB_RIGHT=="KEIHIN")||($RSJOB_RIGHT=="KEIHIN,TAKANO")||($RSJOB_RIGHT=="INGY")||($RSJOB_RIGHT=="BJKC + INGY")) ){
                                                $objPHPExcel->getActiveSheet()->setCellValue('AI' . $i, '=(AG'.$i.'*AH'.$i.')/2'); // แก้แล้ว;
                                            }else{
                                                $objPHPExcel->getActiveSheet()->setCellValue('AI' . $i, '=AG'.$i.'*AH'.$i); // แก้แล้ว; 
                                            }
                                        }
                                    }else{
                                        $objPHPExcel->getActiveSheet()->setCellValue('AI' . $i, '=AG'.$i.'*AH'.$i); // แก้แล้ว; 
                                    }  
                                    // $objPHPExcel->getActiveSheet()->setCellValue('AI' . $i, '=AG'.$i.'*AH'.$i); // แก้แล้ว;                            
                                    if(($selcustomer2 == 'CS') || ($selcustomer2 == 'T.TOHKEN') || ($selcustomer2 == 'STM - IP')){
                                        // $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, '=U'.$i.'*1'); // แก้แล้ว;
                                        $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, '=R'.$i.'*1'); // แก้แล้ว;                                                                      
                                        $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, '=ROUND((T'.$i.'*1),0)'); // แก้แล้ว;
                                        $objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $REMARKOILLEFT); // แก้แล้ว;
                                    }else if(($selcustomer2 == 'KUBOTA') || ($selcustomer2 == 'TGT/DAIKI') || ($selcustomer2 == 'STM - TMT SR / TAW') || ($selcustomer2 == 'STC 10 W') || ($selcustomer2 == 'STC TL')){
                                        $objPHPExcel->getActiveSheet()->setCellValue('AJ' . $i, '=R'.$i.'+AG'.$i); // แก้แล้ว;
                                        $objPHPExcel->getActiveSheet()->setCellValue('AK' . $i, '=ROUND((T'.$i.'+AI'.$i.'),0)'); // แก้แล้ว;
                                        $objPHPExcel->getActiveSheet()->setCellValue('AL' . $i, $REMARKOILRIGHT); // แก้แล้ว;
                                    }
                                }
                            }
                        }else if($selcustomer2 == 'KUBOTA'){
                            $SQLPLANCHKVHCRG="SELECT DISTINCT OTSN.VEHICLEREGISNUMBER CHKVHCRGNB,VHCTPP.JOBNO
                            FROM vwEMPLOYEEEHR2 EHR
                            LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON (VHCTPP.EMPLOYEENAME1 = EHR.nameT OR VHCTPP.EMPLOYEENAME2 = EHR.nameT)
                            LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                            WHERE ".$DOUBLEFUEL." AND $QUERYIFELSE1";
                            $QUERYPLANCHKVHCRG = sqlsrv_query($conn, $SQLPLANCHKVHCRG );
                            while($RSPLANCHKVHCRG = sqlsrv_fetch_array($QUERYPLANCHKVHCRG)) {
                                $CHKTABIEANROD=$RSPLANCHKVHCRG["CHKVHCRGNB"];
                                if ($CHKTABIEANROD =='61-4454'||$CHKTABIEANROD =='61-4456'||$CHKTABIEANROD =='61-3440'||$CHKTABIEANROD =='61-3441'||
                                $CHKTABIEANROD =='61-4453'||$CHKTABIEANROD =='61-4457'||$CHKTABIEANROD =='61-4912'||$CHKTABIEANROD =='61-4913'||
                                $CHKTABIEANROD =='61-4546'||$CHKTABIEANROD =='61-4547'||$CHKTABIEANROD =='64-3452'||$CHKTABIEANROD =='61-3445'||
                                $CHKTABIEANROD =='61-3439'||$CHKTABIEANROD =='61-3443'||$CHKTABIEANROD =='61-3834'||$CHKTABIEANROD =='61-3835'||
                                $CHKTABIEANROD =='61-3438'||$CHKTABIEANROD =='61-3437'||$CHKTABIEANROD =='62-9288'||$CHKTABIEANROD =='61-3836'||
                                $CHKTABIEANROD =='61-4458'||$CHKTABIEANROD =='61-3444'||$CHKTABIEANROD =='60-3868'||$CHKTABIEANROD =='60-3870'||
                                $CHKTABIEANROD =='61-3437'||$CHKTABIEANROD =='61-3452') {
                                    $OAVR_KUBOTA = 4.0;
                                    $SQLPLAN_LEFT="SELECT DISTINCT PositionNameT PSTN,VHCTPP.COMPANYCODE COM,VHCTPP.CUSTOMERCODE CUS,OTSN.OILDATAID OILID,VHCTPP.EMPLOYEECODE1 EMPC1,VHCTPP.EMPLOYEENAME1 EMPN1,VHCTPP.EMPLOYEECODE2 EMPC2,VHCTPP.EMPLOYEENAME2 EMPN2,CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) DW,CONVERT (VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,OTSN.OIL_BILLNUMBER OBLNB,OTSN.VEHICLEREGISNUMBER VHCRGNB,OTSN.VEHICLETYPE CARTYPE,VHCTPP.VEHICLETYPE VHCTPLAN,VHCTPP.JOBSTART JOBSTART,VHCTPP.JOBEND JOBEND,OTSN.MILEAGESTART MST,OTSN.MILEAGEEND MLE,OTSN.DISTANCE DTE,OTSN.OIL_AMOUNT,OTSN.OIL_AVERAGE OAVG,OTSN.OIL_TARGET OTG,VHCTPP.C3 AVG,VHCTPP.E1 MONEY,OTSN.JOBNO,VHCTPP.JOBNO,
                                    (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID) AS OAM,
                                    (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID AND OSGS_TY IN(1,2,3)) AS OAMOUT,
                                    (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID AND OSGS_TY = 4) AS OAMPM
                                    FROM vwEMPLOYEEEHR2 EHR
                                    LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON (VHCTPP.EMPLOYEENAME1 = EHR.nameT OR VHCTPP.EMPLOYEENAME2 = EHR.nameT)
                                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                                    WHERE ".$DOUBLEFUEL." AND $QUERYIFELSE1";
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
                                        if($RSPLAN_LEFT["OIL_AMOUNT"]>0){
                                            $OILAMOUNTLEFT=$RSPLAN_LEFT["OIL_AMOUNT"];
                                        }else{
                                            $OILAMOUNTLEFT='';
                                        }
                                        if($RSPLAN_LEFT["OAMOUT"]>0){
                                            $OAMOUTLEFT=$RSPLAN_LEFT["OAMOUT"];
                                        }else{
                                            $OAMOUTLEFT='';
                                        }
                                        if($RSPLAN_LEFT["OAMPM"]>0){
                                            $OAMPMLEFT=$RSPLAN_LEFT["OAMPM"];
                                        }else{
                                            $OAMPMLEFT='';
                                        }
                                        if(($OILAMOUNTLEFT>0)&&($OAMOUTLEFT>0)&&($OAMPMLEFT>0)){
                                            $OAM_LEFT=($OILAMOUNTLEFT+$OAMOUTLEFT)-$OAMPMLEFT;
                                            $OAM_RSLEFT='=(L'.$i.'+M'.$i.')-N'.$i;
                                            $REMARKOILLEFT='(เติมใน+เติมนอก)-PM ... ('.$OILAMOUNTLEFT.'+'.$OAMOUTLEFT.')-'.$OAMPMLEFT.' = '.$OAM_LEFT.' ลิตร';
                                        }else if(($OILAMOUNTLEFT>0)&&($OAMOUTLEFT>0)&&($OAMPMLEFT=='')){
                                            $OAM_LEFT=$OILAMOUNTLEFT+$OAMOUTLEFT;
                                            $OAM_RSLEFT='=L'.$i.'+M'.$i;
                                            $REMARKOILLEFT='เติมใน+เติมนอก ... '.$OILAMOUNTLEFT.'+'.$OAMOUTLEFT.' = '.$OAM_LEFT.' ลิตร';
                                        }else if(($OILAMOUNTLEFT>0)&&($OAMOUTLEFT=='')&&($OAMPMLEFT>0)){
                                            $OAM_LEFT=$OILAMOUNTLEFT-$OAMPMLEFT;
                                            $OAM_RSLEFT='=L'.$i.'-N'.$i;
                                            $REMARKOILLEFT='เติมใน-PM ... '.$OILAMOUNTLEFT.'-'.$OAMPMLEFT.' = '.$OAM_LEFT.' ลิตร';
                                        }else{
                                            $OAM_LEFT=$OILAMOUNTLEFT;
                                            $OAM_RSLEFT=$OILAMOUNTLEFT;
                                            $REMARKOILLEFT='';
                                        }
                                        // $OAM_LEFT=$RSPLAN_LEFT["OAM"];
                                        $OTG_LEFT=$RSPLAN_LEFT["OTG"];
                                        $OAVG_LEFT=$RSPLAN_LEFT["OAVG"];                                  
                                        $EMPC1_LEFT=$RSPLAN_LEFT["EMPC1"];
                                        $EMPC2_LEFT=$RSPLAN_LEFT["EMPC2"];
                                        $SQLPRICE_LEFT = "SELECT OLP.PRICE,OLP.COMPANYCODE,OLP.[MONTH],OLP.[YEAR] FROM OILPEICE OLP WHERE OLP.COMPANYCODE = '$COM_LEFT' AND OLP.[YEAR] = '$start_yen' AND OLP.[MONTH] = '$selectmonth'";
                                        $QUERYPRICE_LEFT = sqlsrv_query($conn, $SQLPRICE_LEFT);
                                        $RSPRICE_LEFT = sqlsrv_fetch_array($QUERYPRICE_LEFT, SQLSRV_FETCH_ASSOC);   
                                            $PRICE_LEFT=$RSPRICE_LEFT["PRICE"];
                                        $SQLROUND_LEFT="SELECT COUNT(VHCTPP.EMPLOYEECODE1) AS ROUND FROM VEHICLETRANSPORTPLAN VHCTPP WHERE VHCTPP.COMPANYCODE = '$COM_LEFT' AND (VHCTPP.EMPLOYEENAME1 = '$EMPN' OR VHCTPP.EMPLOYEENAME2 ='$EMPN') AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' GROUP BY VHCTPP.EMPLOYEECODE1 ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                            $QUERYROUND_LEFT = sqlsrv_query($conn, $SQLROUND_LEFT ); while($RSROUND_LEFT = sqlsrv_fetch_array($QUERYROUND_LEFT)) { $ROUND=$RSROUND_LEFT["ROUND"];   
                                                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $ROUND); // แก้แล้ว;
                                            }
                                        $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $VHCRGNB_LEFT); // แก้แล้ว;
                                        $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $VHCTPLAN_LEFT); // แก้แล้ว;
                                        $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $RSJOB_LEFT); // แก้แล้ว;
                                        $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $MST_LEFT); // แก้แล้ว;
                                        $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $MLE_LEFT); // แก้แล้ว;
                                        $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, '=J'.$i.'-I'.$i); // แก้แล้ว;
                                        $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $OILAMOUNTLEFT); // แก้แล้ว;            
                                        $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $OAMOUTLEFT); // แก้แล้ว;            
                                        $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $OAMPMLEFT); // แก้แล้ว;  
                                        // $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $OAM_RSLEFT); // แก้แล้ว;    
                                        $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, '=(L'.$i.'+M'.$i.')-N'.$i); // แก้แล้ว;                                     
                                        $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $OAVR_KUBOTA); // แก้แล้ว;    
                                        
                                        // $KCOLUMN=$DTE_LEFT / $OAM_LEFT ;
                                        // $OCOLUMN=($DTE_LEFT / $OAVR_LEFT) - $OAM_LEFT ;
                                        // $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $KCOLUMN); // แก้แล้ว;
                                        // $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, round($OCOLUMN)); // แก้แล้ว;
                                        $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, '=K'.$i.'/O'.$i); // แก้แล้ว;
                                        // $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, '=ROUND(((K'.$i.'/P'.$i.')-O'.$i.'),0)'); // แก้แล้ว;  
                                        $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, '=ROUND((ROUND((K'.$i.'/P'.$i.'),2)-O'.$i.'),0)'); // แก้แล้ว;    
                                        $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $PRICE_LEFT); // แก้แล้ว;                                        
                                        if($EMPC2_LEFT != ""){
                                            if($EMPC2_LEFT==$EMPC1_LEFT){
                                                $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, '=R'.$i.'*S'.$i); // แก้แล้ว; 
                                            }else if($EMPC2_LEFT!=$EMPC1_LEFT){
                                                if( ($selcustomer2 == 'KUBOTA') || (($RSJOB_LEFT=="TAKANO")||($RSJOB_LEFT=="KEIHIN")||($RSJOB_LEFT=="KEIHIN,TAKANO")||($RSJOB_LEFT=="INGY")||($RSJOB_LEFT=="BJKC + INGY")) ){
                                                    if($RSJOB_LEFT == "คลังโคราช"){
                                                        // $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, '0.00'); // แก้แล้ว; 
                                                        $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, '=(R'.$i.'*S'.$i.')/2'); // แก้แล้ว; 03/03/2568
                                                    }else{
                                                        $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, '=(R'.$i.'*S'.$i.')/2'); // แก้แล้ว; 
                                                    }
                                                }else{
                                                    $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, '=R'.$i.'*S'.$i); // แก้แล้ว; 
                                                }
                                            }
                                        }else{
                                            $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, '=R'.$i.'*S'.$i); // แก้แล้ว; 
                                        }  
                                        // $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, '=R'.$i.'*S'.$i); // แก้แล้ว;                            
                                        if(($selcustomer2 == 'CS') || ($selcustomer2 == 'T.TOHKEN') || ($selcustomer2 == 'STM - IP')){
                                            $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, '=R'.$i.'*1'); // แก้แล้ว;                                                                      
                                            $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, '=ROUND((T'.$i.'*1),0)'); // แก้แล้ว;
                                            $objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $REMARKOILLEFT); // แก้แล้ว;
                                        }else if(($selcustomer2 == 'KUBOTA') || ($selcustomer2 == 'TGT/DAIKI') || ($selcustomer2 == 'STM - TMT SR / TAW') || ($selcustomer2 == 'STC 10 W') || ($selcustomer2 == 'STC TL')){
                                            $objPHPExcel->getActiveSheet()->setCellValue('AJ' . $i, '=R'.$i.'+AG'.$i); // แก้แล้ว;
                                            $objPHPExcel->getActiveSheet()->setCellValue('AK' . $i, '=ROUND((T'.$i.'+AI'.$i.'),0)'); // แก้แล้ว;
                                            $objPHPExcel->getActiveSheet()->setCellValue('AL' . $i, $REMARKOILRIGHT); // แก้แล้ว;
                                        }
                                    }
                                }else if($CHKTABIEANROD =='74-5653'||$CHKTABIEANROD =='74-5684') {
                                    $SQLPLAN_RIGHT="SELECT DISTINCT PositionNameT PSTN,VHCTPP.COMPANYCODE COM,VHCTPP.CUSTOMERCODE CUS,OTSN.OILDATAID OILID,VHCTPP.EMPLOYEECODE1 EMPC1,VHCTPP.EMPLOYEENAME1 EMPN1,VHCTPP.EMPLOYEECODE2 EMPC2,CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) DW,CONVERT (VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,OTSN.OIL_BILLNUMBER OBLNB,OTSN.VEHICLEREGISNUMBER VHCRGNB,OTSN.VEHICLETYPE CARTYPE,VHCTPP.VEHICLETYPE VHCTPLAN,VHCTPP.JOBSTART JOBSTART,VHCTPP.JOBEND JOBEND,OTSN.MILEAGESTART MST,OTSN.MILEAGEEND MLE,OTSN.DISTANCE DTE,OTSN.OIL_AMOUNT,OTSN.OIL_AVERAGE OAVG,OTSN.OIL_TARGET OTG,VHCTPP.C3 AVG,VHCTPP.E1 MONEY,OTSN.JOBNO,VHCTPP.JOBNO,
                                    (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID) AS OAM,
                                    (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID AND OSGS_TY IN(1,2,3)) AS OAMOUT,
                                    (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID AND OSGS_TY = 4) AS OAMPM
                                    FROM vwEMPLOYEEEHR2 EHR
                                    LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON (VHCTPP.EMPLOYEENAME1 = EHR.nameT OR VHCTPP.EMPLOYEENAME2 = EHR.nameT)
                                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                                    WHERE ".$DOUBLEFUEL." AND $QUERYIFELSE2";
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
                                        if($JOBEND_RIGHT=='คลังโคราช'){
                                            $OAVR_KUBOTA = 3.00;
                                        }else{
                                            $OAVR_KUBOTA = 3.75;
                                        }
                                        $MST_RIGHT=$RSPLAN_RIGHT["MST"];
                                        $MLE_RIGHT=$RSPLAN_RIGHT["MLE"];
                                        $DTE_RIGHT=$RSPLAN_RIGHT["DTE"];

                                        if($RSPLAN_RIGHT["OIL_AMOUNT"]>0){
                                            $OILAMOUNTRIGHT=$RSPLAN_RIGHT["OIL_AMOUNT"];
                                        }else{
                                            $OILAMOUNTRIGHT='';
                                        }
                                        if($RSPLAN_RIGHT["OAMOUT"]>0){
                                            $OAMOUTRIGHT=$RSPLAN_RIGHT["OAMOUT"];
                                        }else{
                                            $OAMOUTRIGHT='';
                                        }
                                        if($RSPLAN_RIGHT["OAMPM"]>0){
                                            $OAMPMRIGHT=$RSPLAN_RIGHT["OAMPM"];
                                        }else{
                                            $OAMPMRIGHT='';
                                        }
                                        if(($OILAMOUNTRIGHT>0)&&($OAMOUTRIGHT>0)&&($OAMPMRIGHT>0)){
                                            $OAM_RIGHT=($OILAMOUNTRIGHT+$OAMOUTRIGHT)-$OAMPMRIGHT;
                                            $OAM_RSRIGHT='=(AA'.$i.'+AB'.$i.')-AC'.$i;
                                            $REMARKOILRIGHT='(เติมใน+เติมนอก)-PM ... ('.$OILAMOUNTRIGHT.'+'.$OAMOUTRIGHT.')-'.$OAMPMRIGHT.' = '.$OAM_RIGHT.' ลิตร';
                                        }else if(($OILAMOUNTRIGHT>0)&&($OAMOUTRIGHT>0)&&($OAMPMRIGHT=='')){
                                            $OAM_RIGHT=$OILAMOUNTRIGHT+$OAMOUTRIGHT;
                                            $OAM_RSRIGHT='=AA'.$i.'+AB'.$i;
                                            $REMARKOILRIGHT='เติมใน+เติมนอก ... '.$OILAMOUNTRIGHT.'+'.$OAMOUTRIGHT.' = '.$OAM_RIGHT.' ลิตร';
                                        }else if(($OILAMOUNTRIGHT>0)&&($OAMOUTRIGHT=='')&&($OAMPMRIGHT>0)){
                                            $OAM_RIGHT=$OILAMOUNTRIGHT-$OAMPMRIGHT;
                                            $OAM_RSRIGHT='=AA'.$i.'-AC'.$i;
                                            $REMARKOILRIGHT='เติมใน-PM ... '.$OILAMOUNTRIGHT.'-'.$OAMPMRIGHT.' = '.$OAM_RIGHT.' ลิตร';
                                        }else{
                                            $OAM_RIGHT=$OILAMOUNTRIGHT;
                                            $OAM_RSRIGHT=$OILAMOUNTRIGHT;
                                            $REMARKOILRIGHT='';
                                        }
                                        // $OILAMOUNTRIGHT=$RSPLAN_RIGHT["OIL_AMOUNT"];
                                        // $OAMRIGHT=$RSPLAN_RIGHT["OAM"];
                                        // $OAM_RIGHT=$OILAMOUNTRIGHT+$OAMRIGHT;

                                        $OTG_RIGHT=$RSPLAN_RIGHT["OTG"];
                                        $OAVG_RIGHT=$RSPLAN_RIGHT["OAVG"];                               
                                        $EMPC1_RIGHT=$RSPLAN_RIGHT["EMPC1"];
                                        $EMPC2_RIGHT=$RSPLAN_RIGHT["EMPC2"];                                    
                                
                                        $SQLPRICE_RIGHT = "SELECT OLP.PRICE,OLP.COMPANYCODE,OLP.[MONTH],OLP.[YEAR]   
                                        FROM OILPEICE OLP WHERE OLP.COMPANYCODE = '$COM_RIGHT' AND OLP.[YEAR] = '$start_yen' AND OLP.[MONTH] = '$selectmonth'"; 
                                        $QUERYPRICE_RIGHT = sqlsrv_query($conn, $SQLPRICE_RIGHT);
                                        $RSPRICE_RIGHT = sqlsrv_fetch_array($QUERYPRICE_RIGHT, SQLSRV_FETCH_ASSOC);   
                                            $PRICE_RIGHT=$RSPRICE_RIGHT["PRICE"];                                
                                        $SQLROUND_RIGHT="SELECT COUNT(VHCTPP.EMPLOYEECODE1) AS ROUND FROM VEHICLETRANSPORTPLAN VHCTPP WHERE VHCTPP.COMPANYCODE = '$COM_RIGHT' AND (VHCTPP.EMPLOYEENAME1 = '$EMPN' OR VHCTPP.EMPLOYEENAME2 ='$EMPN') AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' GROUP BY VHCTPP.EMPLOYEECODE1 ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                        $QUERYROUND_RIGHT = sqlsrv_query($conn, $SQLROUND_RIGHT ); while($RSROUND_RIGHT = sqlsrv_fetch_array($QUERYROUND_RIGHT)) { $ROUND=$RSROUND_RIGHT["ROUND"];   
                                            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $ROUND); // แก้แล้ว;
                                        }                                
                                        $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $VHCRGNB_RIGHT); // แก้แล้ว;
                                        $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $VHCTPLAN_RIGHT); // แก้แล้ว;                                
                                        $objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $RSJOB_RIGHT); // แก้แล้ว;
                                        $objPHPExcel->getActiveSheet()->setCellValue('X' . $i, $MST_RIGHT); // แก้แล้ว;
                                        $objPHPExcel->getActiveSheet()->setCellValue('Y' . $i, $MLE_RIGHT); // แก้แล้ว;
                                        $objPHPExcel->getActiveSheet()->setCellValue('Z' . $i, '=Y'.$i.'-X'.$i); // แก้แล้ว;
                                        $objPHPExcel->getActiveSheet()->setCellValue('AA' . $i, $OILAMOUNTRIGHT);  // แก้แล้ว;
                                        $objPHPExcel->getActiveSheet()->setCellValue('AB' . $i, $OAMOUTRIGHT); // แก้แล้ว;
                                        $objPHPExcel->getActiveSheet()->setCellValue('AC' . $i, $OAMPMRIGHT); // แก้แล้ว;
                                        // $objPHPExcel->getActiveSheet()->setCellValue('AD' . $i, $OAM_RSRIGHT); // แก้แล้ว;  
                                        $objPHPExcel->getActiveSheet()->setCellValue('AD' . $i, '=(AA'.$i.'+AB'.$i.')-AC'.$i); // แก้แล้ว;      
                                        $objPHPExcel->getActiveSheet()->setCellValue('AE' . $i, $OAVR_KUBOTA); // แก้แล้ว;   
                                        // $ZCOLUMN=$DTE_RIGHT / $OAM_RIGHT ;
                                        // $AACOLUMN=($DTE_RIGHT / $OAVR_RIGHT) - $OAM_RIGHT ;
                                        // $objPHPExcel->getActiveSheet()->setCellValue('AF' . $i, $ZCOLUMN); // แก้แล้ว;
                                        // $objPHPExcel->getActiveSheet()->setCellValue('AG' . $i, round($AACOLUMN)); // แก้แล้ว;
                                        $objPHPExcel->getActiveSheet()->setCellValue('AF' . $i, '=Z'.$i.'/AD'.$i); // แก้แล้ว;
                                        // $objPHPExcel->getActiveSheet()->setCellValue('AG' . $i, '=ROUND(((Z'.$i.'/AE'.$i.')-AD'.$i.'),0)'); // แก้แล้ว;
                                        $objPHPExcel->getActiveSheet()->setCellValue('AG' . $i, '=ROUND((ROUND((Z'.$i.'/AE'.$i.'),2)-AD'.$i.'),0)'); // แก้แล้ว;        
                                        $objPHPExcel->getActiveSheet()->setCellValue('AH' . $i, $PRICE_RIGHT); // แก้แล้ว;                                        
                                        if($EMPC2_RIGHT != ""){
                                            if($EMPC2_RIGHT==$EMPC1_RIGHT){
                                                $objPHPExcel->getActiveSheet()->setCellValue('AI' . $i, '=AG'.$i.'*AH'.$i); // แก้แล้ว; 
                                            }else if($EMPC2_RIGHT!=$EMPC1_RIGHT){
                                                if( ($selcustomer2 == 'KUBOTA') || (($RSJOB_RIGHT=="TAKANO")||($RSJOB_RIGHT=="KEIHIN")||($RSJOB_RIGHT=="KEIHIN,TAKANO")||($RSJOB_RIGHT=="INGY")||($RSJOB_RIGHT=="BJKC + INGY")) ){
                                                    if($RSJOB_RIGHT == "คลังโคราช"){
                                                        // $objPHPExcel->getActiveSheet()->setCellValue('AI' . $i, '0.00'); // แก้แล้ว; 
                                                        $objPHPExcel->getActiveSheet()->setCellValue('AI' . $i, '=(AG'.$i.'*AH'.$i.')/2'); // แก้แล้ว; 03/03/2568
                                                    }else{
                                                        $objPHPExcel->getActiveSheet()->setCellValue('AI' . $i, '=(AG'.$i.'*AH'.$i.')/2'); // แก้แล้ว;
                                                    }
                                                }else{
                                                    $objPHPExcel->getActiveSheet()->setCellValue('AI' . $i, '=AG'.$i.'*AH'.$i); // แก้แล้ว;  
                                                }
                                            }
                                        }else{
                                            $objPHPExcel->getActiveSheet()->setCellValue('AI' . $i, '=AG'.$i.'*AH'.$i); // แก้แล้ว; 
                                        }                             
                                        if(($selcustomer2 == 'CS') || ($selcustomer2 == 'T.TOHKEN') || ($selcustomer2 == 'STM - IP')){
                                            // $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, '=U'.$i.'*1'); // แก้แล้ว;
                                            $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, '=R'.$i.'*1'); // แก้แล้ว;                                                                      
                                            $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, '=ROUND((T'.$i.'*1),0)'); // แก้แล้ว;
                                            $objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $REMARKOILLEFT); // แก้แล้ว;
                                        }else if(($selcustomer2 == 'KUBOTA') || ($selcustomer2 == 'TGT/DAIKI') || ($selcustomer2 == 'STM - TMT SR / TAW') || ($selcustomer2 == 'STC 10 W') || ($selcustomer2 == 'STC TL')){
                                            $objPHPExcel->getActiveSheet()->setCellValue('AJ' . $i, '=R'.$i.'+AG'.$i); // แก้แล้ว;
                                            $objPHPExcel->getActiveSheet()->setCellValue('AK' . $i, '=ROUND((T'.$i.'+AI'.$i.'),0)'); // แก้แล้ว;
                                            $objPHPExcel->getActiveSheet()->setCellValue('AL' . $i, $REMARKOILRIGHT); // แก้แล้ว;
                                        }
                                    }
                                }else{
                                    $SQLPLAN_LEFT="SELECT DISTINCT PositionNameT PSTN,VHCTPP.COMPANYCODE COM,VHCTPP.CUSTOMERCODE CUS,OTSN.OILDATAID OILID,VHCTPP.EMPLOYEECODE1 EMPC1,VHCTPP.EMPLOYEENAME1 EMPN1,VHCTPP.EMPLOYEECODE2 EMPC2,VHCTPP.EMPLOYEENAME2 EMPN2,CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) DW,CONVERT (VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,OTSN.OIL_BILLNUMBER OBLNB,OTSN.VEHICLEREGISNUMBER VHCRGNB,OTSN.VEHICLETYPE CARTYPE,VHCTPP.VEHICLETYPE VHCTPLAN,VHCTPP.JOBSTART JOBSTART,VHCTPP.JOBEND JOBEND,OTSN.MILEAGESTART MST,OTSN.MILEAGEEND MLE,OTSN.DISTANCE DTE,OTSN.OIL_AMOUNT,OTSN.OIL_AVERAGE OAVG,OTSN.OIL_TARGET OTG,VHCTPP.C3 AVG,VHCTPP.E1 MONEY,OTSN.JOBNO,VHCTPP.JOBNO,
                                    (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID) AS OAM,
                                    (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID AND OSGS_TY IN(1,2,3)) AS OAMOUT,
                                    (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID AND OSGS_TY = 4) AS OAMPM
                                    FROM vwEMPLOYEEEHR2 EHR
                                    LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON (VHCTPP.EMPLOYEENAME1 = EHR.nameT OR VHCTPP.EMPLOYEENAME2 = EHR.nameT)
                                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                                    WHERE ".$DOUBLEFUEL." AND $QUERYIFELSE1";
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
                                    
                                        if($RSPLAN_LEFT["OIL_AMOUNT"]>0){
                                            $OILAMOUNTLEFT=$RSPLAN_LEFT["OIL_AMOUNT"];
                                        }else{
                                            $OILAMOUNTLEFT='';
                                        }
                                        if($RSPLAN_LEFT["OAMOUT"]>0){
                                            $OAMOUTLEFT=$RSPLAN_LEFT["OAMOUT"];
                                        }else{
                                            $OAMOUTLEFT='';
                                        }
                                        if($RSPLAN_LEFT["OAMPM"]>0){
                                            $OAMPMLEFT=$RSPLAN_LEFT["OAMPM"];
                                        }else{
                                            $OAMPMLEFT='';
                                        }
                                        if(($OILAMOUNTLEFT>0)&&($OAMOUTLEFT>0)&&($OAMPMLEFT>0)){
                                            $OAM_LEFT=($OILAMOUNTLEFT+$OAMOUTLEFT)-$OAMPMLEFT;
                                            $OAM_RSLEFT='=(L'.$i.'+M'.$i.')-N'.$i;
                                            $REMARKOILLEFT='(เติมใน+เติมนอก)-PM ... ('.$OILAMOUNTLEFT.'+'.$OAMOUTLEFT.')-'.$OAMPMLEFT.' = '.$OAM_LEFT.' ลิตร';
                                        }else if(($OILAMOUNTLEFT>0)&&($OAMOUTLEFT>0)&&($OAMPMLEFT=='')){
                                            $OAM_LEFT=$OILAMOUNTLEFT+$OAMOUTLEFT;
                                            $OAM_RSLEFT='=L'.$i.'+M'.$i;
                                            $REMARKOILLEFT='เติมใน+เติมนอก ... '.$OILAMOUNTLEFT.'+'.$OAMOUTLEFT.' = '.$OAM_LEFT.' ลิตร';
                                        }else if(($OILAMOUNTLEFT>0)&&($OAMOUTLEFT=='')&&($OAMPMLEFT>0)){
                                            $OAM_LEFT=$OILAMOUNTLEFT-$OAMPMLEFT;
                                            $OAM_RSLEFT='=L'.$i.'-N'.$i;
                                            $REMARKOILLEFT='เติมใน-PM ... '.$OILAMOUNTLEFT.'-'.$OAMPMLEFT.' = '.$OAM_LEFT.' ลิตร';
                                        }else{
                                            $OAM_LEFT=$OILAMOUNTLEFT;
                                            $OAM_RSLEFT=$OILAMOUNTLEFT;
                                            $REMARKOILLEFT='';
                                        }
                                        // $OILAMOUNTLEFT=$RSPLAN_LEFT["OIL_AMOUNT"];
                                        // $OAMLEFT=$RSPLAN_LEFT["OAM"];
                                        // $OAM_LEFT=$OILAMOUNTLEFT+$OAMLEFT;

                                        $OTG_LEFT=$RSPLAN_LEFT["OTG"];
                                        $OAVG_LEFT=$RSPLAN_LEFT["OAVG"];                                  
                                        $EMPC1_LEFT=$RSPLAN_LEFT["EMPC1"];
                                        $EMPC2_LEFT=$RSPLAN_LEFT["EMPC2"];                                

                                        $SQLPRICE_LEFT = "SELECT OLP.PRICE,OLP.COMPANYCODE,OLP.[MONTH],OLP.[YEAR] FROM OILPEICE OLP WHERE OLP.COMPANYCODE = '$COM_LEFT' AND OLP.[YEAR] = '$start_yen' AND OLP.[MONTH] = '$selectmonth'";
                                        $QUERYPRICE_LEFT = sqlsrv_query($conn, $SQLPRICE_LEFT);
                                        $RSPRICE_LEFT = sqlsrv_fetch_array($QUERYPRICE_LEFT, SQLSRV_FETCH_ASSOC);   
                                            $PRICE_LEFT=$RSPRICE_LEFT["PRICE"];

                                        $SQLROUND_LEFT="SELECT COUNT(VHCTPP.EMPLOYEECODE1) AS ROUND FROM VEHICLETRANSPORTPLAN VHCTPP WHERE VHCTPP.COMPANYCODE = '$COM_LEFT' AND (VHCTPP.EMPLOYEENAME1 = '$EMPN' OR VHCTPP.EMPLOYEENAME2 ='$EMPN') AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$start_yen-$startif-$chkday' GROUP BY VHCTPP.EMPLOYEECODE1 ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                                            $QUERYROUND_LEFT = sqlsrv_query($conn, $SQLROUND_LEFT ); while($RSROUND_LEFT = sqlsrv_fetch_array($QUERYROUND_LEFT)) { $ROUND=$RSROUND_LEFT["ROUND"];   
                                                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $ROUND); // แก้แล้ว;
                                            }

                                        $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $VHCRGNB_LEFT); // แก้แล้ว;
                                        $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $VHCTPLAN_LEFT); // แก้แล้ว;

                                        $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $RSJOB_LEFT); // แก้แล้ว;
                                        $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $MST_LEFT); // แก้แล้ว;
                                        $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $MLE_LEFT); // แก้แล้ว;
                                        $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, '=J'.$i.'-I'.$i); // แก้แล้ว;
                                        $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $OILAMOUNTLEFT); // แก้แล้ว;            
                                        $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $OAMOUTLEFT); // แก้แล้ว;            
                                        $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $OAMPMLEFT); // แก้แล้ว; 
                                        // $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $OAM_RSLEFT); // แก้แล้ว;    
                                        $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, '=(L'.$i.'+M'.$i.')-N'.$i); // แก้แล้ว;                                         
                                        $SQLOAVG_LEFT="SELECT DISTINCT OILAVERAGE.OILAVERAGE OAVR FROM OILAVERAGE WHERE OILAVERAGE.COMPANYCODE = '$COM_LEFT' AND OILAVERAGE.CUSTOMERCODE = '$CUS_LEFT' AND OILAVERAGE.VEHICLETYPE = '$VHCTPLAN_LEFT'";
                                            $QUERYOAVG_LEFT = sqlsrv_query($conn, $SQLOAVG_LEFT ); while($RSOAVG_LEFT = sqlsrv_fetch_array($QUERYOAVG_LEFT)) {                                         
                                                if ($VHCRGNB_LEFT =='61-4456' || $VHCRGNB_LEFT =='61-3441' || $VHCRGNB_LEFT =='61-4457' ||
                                                    $VHCRGNB_LEFT =='61-4913' || $VHCRGNB_LEFT =='61-4547' || $VHCRGNB_LEFT =='64-3452' || 
                                                    $VHCRGNB_LEFT =='61-3445' || $VHCRGNB_LEFT =='61-3443' || $VHCRGNB_LEFT =='62-9288' || 
                                                    $VHCRGNB_LEFT =='61-3836' || $VHCRGNB_LEFT =='61-4458' ){
                                                    $OAVR_LEFT = 4.0;
                                                }else if($VHCRGNB_LEFT =='61-3442' || $VHCRGNB_LEFT =='61-3444' || $VHCRGNB_LEFT =='76-8919' || 
                                                        $VHCRGNB_LEFT =='61-4458' || $VHCRGNB_LEFT =='79-2521' || $VHCRGNB_LEFT =='79-2522' || 
                                                        $VHCRGNB_LEFT =='79-2525' || $VHCRGNB_LEFT =='74-5654'){
                                                    $OAVR_LEFT = 3.5;  
                                                }else if($VHCRGNB_LEFT =='61-3440' || $VHCRGNB_LEFT =='60-3868' || $VHCRGNB_LEFT =='61-3439' ||
                                                        $VHCRGNB_LEFT =='61-4546' || $VHCRGNB_LEFT =='60-3870' || $VHCRGNB_LEFT =='61-4912' ||
                                                        $VHCRGNB_LEFT =='61-3452' || $VHCRGNB_LEFT =='61-3835' || $VHCRGNB_LEFT =='61-4454' ||
                                                        $VHCRGNB_LEFT =='61-3437' || $VHCRGNB_LEFT =='61-3438' || $VHCRGNB_LEFT =='61-3834' ||
                                                        $VHCRGNB_LEFT =='61-4453' ||
                                                        $VHCRGNB_LEFT =='74-5610' || $VHCRGNB_LEFT =='74-5611' || $VHCRGNB_LEFT =='74-5612' ||
                                                        $VHCRGNB_LEFT =='74-5613' || $VHCRGNB_LEFT =='74-5658' || $VHCRGNB_LEFT =='74-5660' ||
                                                        $VHCRGNB_LEFT =='74-5675' || $VHCRGNB_LEFT =='74-5676' || $VHCRGNB_LEFT =='74-5677' ||
                                                        $VHCRGNB_LEFT =='74-5678' || $VHCRGNB_LEFT =='74-5679' || $VHCRGNB_LEFT =='74-5688' ||
                                                        $VHCRGNB_LEFT =='74-5690' ){
                                                    if($JOBEND_LEFT=='คลังโคราช'){
                                                        $OAVR_LEFT = 3.75; // คลังโคราช ประเภทรถ 6W ใช้เรท 3.75
                                                    }else{
                                                        $OAVR_LEFT = 4.25; // งานขายทั่วประเทศ ประเภทรถ 6W ใช้เรท 4.25
                                                    }
                                                }else if($VHCRGNB_LEFT =='60-3871' || $VHCRGNB_LEFT =='60-2391' ||
                                                        $VHCRGNB_LEFT =='74-5653' || $VHCRGNB_LEFT =='74-5684' ){
                                                    if($JOBEND_LEFT=='คลังโคราช'){
                                                        $OAVR_LEFT = 3.00; // คลังโคราช ประเภทรถ 10W ใช้เรท 3.00 มีทะเบียน 74-5653 และ 74-5684
                                                    }else{
                                                        $OAVR_LEFT = 3.75; // งานขายทั่วประเทศ ประเภทรถ 10W ใช้เรท 3.75 มีทะเบียน 74-5653 และ 74-5684
                                                    }
                                                }else{
                                                    if($JOBEND_LEFT=='BJKC + INGY' || $JOBEND_LEFT=='INGY' || 
                                                        $JOBEND_LEFT=='INGY (Rayong)' || $JOBEND_LEFT=='INGY+BJKC (Rayong)' ){
                                                            $OAVR_LEFT = 6.50;
                                                    }else{
                                                        $OAVR_LEFT = $RSOAVG_LEFT["OAVR"]; 
                                                    }
                                                }

                                                $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $OAVR_LEFT); // แก้แล้ว;
                                            }

                                        // $KCOLUMN=$DTE_LEFT / $OAM_LEFT ;
                                        // $OCOLUMN=($DTE_LEFT / $OAVR_LEFT) - $OAM_LEFT ;
                                        // $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $KCOLUMN); // แก้แล้ว; 
                                        // $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, round($OCOLUMN)); // แก้แล้ว; 
                                        $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, '=K'.$i.'/O'.$i); // แก้แล้ว; 
                                        // $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, '=ROUND(((K'.$i.'/P'.$i.')-O'.$i.'),0)');  // แก้แล้ว; 
                                        $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, '=ROUND((ROUND((K'.$i.'/P'.$i.'),2)-O'.$i.'),0)'); // แก้แล้ว; 
                                        $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $PRICE_LEFT); // แก้แล้ว; 
                                        
                                        if($EMPC2_LEFT != ""){
                                            if($EMPC2_LEFT==$EMPC1_LEFT){
                                                $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, '=R'.$i.'*S'.$i); // แก้แล้ว; 
                                            }else if($EMPC2_LEFT!=$EMPC1_LEFT){
                                                if( ($selcustomer2 == 'KUBOTA') || (($RSJOB_LEFT=="TAKANO")||($RSJOB_LEFT=="KEIHIN")||($RSJOB_LEFT=="KEIHIN,TAKANO")||($RSJOB_LEFT=="INGY")||($RSJOB_LEFT=="BJKC + INGY")) ){
                                                    if($RSJOB_LEFT == "คลังโคราช"){
                                                        // $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, '0.00'); // แก้แล้ว;  
                                                        $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, '=(R'.$i.'*S'.$i.')/2'); // แก้แล้ว;  03/03/2568
                                                    }else{
                                                        $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, '=(R'.$i.'*S'.$i.')/2'); // แก้แล้ว;  
                                                    }
                                                }else{
                                                    $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, '=R'.$i.'*S'.$i); // แก้แล้ว; 
                                                }
                                            }
                                        }else{
                                            $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, '=R'.$i.'*S'.$i); // แก้แล้ว; 
                                        }  
                                        // $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, '=R'.$i.'*S'.$i); // แก้แล้ว;                            
                                        if(($selcustomer2 == 'CS') || ($selcustomer2 == 'T.TOHKEN') || ($selcustomer2 == 'STM - IP')){
                                            $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, '=R'.$i.'*1'); // แก้แล้ว;                                                                        
                                            $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, '=ROUND((T'.$i.'*1),0)'); // แก้แล้ว; 
                                            $objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $REMARKOILLEFT); // แก้แล้ว;
                                        }else if(($selcustomer2 == 'KUBOTA') || ($selcustomer2 == 'TGT/DAIKI') || ($selcustomer2 == 'STM - TMT SR / TAW') || ($selcustomer2 == 'STC 10 W') || ($selcustomer2 == 'STC TL')){
                                            $objPHPExcel->getActiveSheet()->setCellValue('AJ' . $i, '=R'.$i.'+AG'.$i); // แก้แล้ว; 
                                            $objPHPExcel->getActiveSheet()->setCellValue('AK' . $i, '=ROUND((T'.$i.'+AI'.$i.'),0)'); // แก้แล้ว; 
                                            $objPHPExcel->getActiveSheet()->setCellValue('AL' . $i, $REMARKOILRIGHT); // แก้แล้ว;
                                        }
                                    }
                                }
                            }
                        }
                                           
                        if(($selcustomer2 == 'CS') || ($selcustomer2 == 'T.TOHKEN') || ($selcustomer2 == 'STM - IP')){      
                            $sheet->getStyle('K'.$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));//เหลือง
                            $sheet->getStyle('O'.$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));//เหลือง
                            $sheet->getStyle('T'.$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));//เหลือง
                        }else if(($selcustomer2 == 'KUBOTA') || ($selcustomer2 == 'TGT/DAIKI') || ($selcustomer2 == 'STM - TMT SR / TAW') || ($selcustomer2 == 'STC 10 W') || ($selcustomer2 == 'STC TL')){
                            $sheet->getStyle('K'.$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));//เหลือง
                            $sheet->getStyle('O'.$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));//เหลือง
                            $sheet->getStyle('T'.$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));//เหลือง
                            $sheet->getStyle('Z'.$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));//เหลือง
                            $sheet->getStyle('AD'.$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));//เหลือง
                            $sheet->getStyle('AI'.$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));//เหลือง
                        }
                        $numpage++; $i++;
                    }                     
                    
                    $objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':J'.$i);
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, 'รวม');
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold( true );
                    
                    $sheet->getStyle('K'.$i.':O'.$i)->getNumberFormat()->setFormatCode('0.00');
                    if($selcustomer2 == 'KUBOTA'){
                        $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, '=SUM(K10:K'.($i -1).')/2');
                        $objPHPExcel->getActiveSheet()->setCellValue('O'.$i, '=SUM(O10:O'.($i -1).')/2');
                        $objPHPExcel->getActiveSheet()->setCellValue('R'.$i, '=SUM(R10:R'.($i -1).')/2');
                    }else{
                        $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, '=SUM(K10:K'.($i -1).')');
                        $objPHPExcel->getActiveSheet()->setCellValue('O'.$i, '=SUM(O10:O'.($i -1).')');
                        $objPHPExcel->getActiveSheet()->setCellValue('R'.$i, '=SUM(R10:R'.($i -1).')');
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, '=K'.$i.'/O'.$i);
                    $objPHPExcel->getActiveSheet()->setCellValue('T'.$i, '=SUM(T10:T'.($i -1).')');
                    
                    $sheet->getStyle('O10:O'.$i)->getNumberFormat()->setFormatCode('0.00'); 
                    $sheet->getStyle('Q10:R'.$i)->getNumberFormat()->setFormatCode('0.00'); 
                    
                    $objPHPExcel->getActiveSheet()->getStyle('A10:B'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('C10:D'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('E10:G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('H10:H'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('I10:O'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('P10:P'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('Q10:R'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('S10:S'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('T10:T'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    
                    if(($selcustomer2 == 'CS') || ($selcustomer2 == 'T.TOHKEN') || ($selcustomer2 == 'STM - IP')){      
                        $sheet->getStyle('Q10:V'.$i)->getNumberFormat()->setFormatCode('0.00');                   
                        $objPHPExcel->getActiveSheet()->setCellValue('U'.$i, '=SUM(U10:U'.($i -1).')');
                        $objPHPExcel->getActiveSheet()->setCellValue('V'.$i, '=SUM(V10:V'.($i -1).')');
                        $sheet->getStyle('A'.$i.':W'.$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));
                        $sheet->getStyle('A10:W'.$i)->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                    }else if(($selcustomer2 == 'KUBOTA') || ($selcustomer2 == 'TGT/DAIKI') || ($selcustomer2 == 'STM - TMT SR / TAW') || ($selcustomer2 == 'STC 10 W') || ($selcustomer2 == 'STC TL')){

                        $sheet->getStyle('Q10:Q'.$i)->getNumberFormat()->setFormatCode('0.00');
                        $objPHPExcel->getActiveSheet()->mergeCells('U'.$i.':W'.$i);                      
                        $sheet->getStyle('U'.$i.':AC'.$i)->getNumberFormat()->setFormatCode('0.00');
                        if($selcustomer2 == 'KUBOTA'){
                            $objPHPExcel->getActiveSheet()->setCellValue('Z'.$i, '=SUM(Z10:Z'.($i -1).')/2');
                            $objPHPExcel->getActiveSheet()->setCellValue('AD'.$i, '=SUM(AD10:AD'.($i -1).')/2');
                            $objPHPExcel->getActiveSheet()->setCellValue('AG'.$i, '=SUM(AG10:AG'.($i -1).')/2');
                            $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$i, '=SUM(AJ10:AJ'.($i -1).')/2');
                        }else{
                            $objPHPExcel->getActiveSheet()->setCellValue('Z'.$i, '=SUM(Z10:Z'.($i -1).')');
                            $objPHPExcel->getActiveSheet()->setCellValue('AD'.$i, '=SUM(AD10:AD'.($i -1).')');
                            $objPHPExcel->getActiveSheet()->setCellValue('AG'.$i, '=SUM(AG10:AG'.($i -1).')');
                            $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$i, '=SUM(AJ10:AJ'.($i -1).')');
                        }
                        $objPHPExcel->getActiveSheet()->setCellValue('AF'.$i, '=Z'.$i.'/AD'.$i);
                        
                        $sheet->getStyle('AD10:AD'.$i)->getNumberFormat()->setFormatCode('0.00'); 
                        $sheet->getStyle('W10:AG'.$i)->getNumberFormat()->setFormatCode('0.00'); 
                        $sheet->getStyle('AI10:AK'.$i)->getNumberFormat()->setFormatCode('0.00'); 
                        
                        $objPHPExcel->getActiveSheet()->getStyle('U10:V'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('W10:W'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('X10:AD'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('AE10:AE'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('AF10:AG'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('AH10:AH'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('AI10:AK'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                        $objPHPExcel->getActiveSheet()->setCellValue('AI'.$i, '=SUM(AI10:AI'.($i -1).')');
                        $objPHPExcel->getActiveSheet()->setCellValue('AK'.$i, '=SUM(AK10:AK'.($i -1).')');
                        $sheet->getStyle('A'.$i.':AL'.$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));
                        $sheet->getStyle('A10:AL'.$i)->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));

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