<?php
    // echo"<pre>";
    // print_r($_POST);
    // echo"</pre>";
    // exit();
    $EXCELVHCT=$_POST['EXCELVHCT'];
    $PDFVHCT=$_POST['PDFVHCT'];
    
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
    use PhpOffice\PhpSpreadsheet\RichText\RichText;

    $datestartoil = $_POST["txt_datestartoilvhct"];
    $startdateoil = explode(" ", $datestartoil);
    $startdateoil1 = $startdateoil[0];
    $starttimeoil1 = $startdateoil[1];    
    $startdateoil2 = explode("/", $startdateoil1);
    $startd = $startdateoil2[0];
    $startif = $startdateoil2[1];
        if($startif == "01"){
            $selectmonth = "ม.ค.";
        }else if($startif == "02"){
            $selectmonth = "ก.พ.";
        }else if($startif == "03"){
            $selectmonth = "มี.ค.";
        }else if($startif == "04"){
            $selectmonth = "เม.ย.";
        }else if($startif == "05"){
            $selectmonth = "พ.ค.";
        }else if($startif == "06"){
            $selectmonth = "มิ.ย.";
        }else if($startif == "07"){
            $selectmonth = "ก.ค.";
        }else if($startif == "08"){
            $selectmonth = "ส.ค.";
        }else if($startif == "09"){
            $selectmonth = "ก.ย.";
        }else if($startif == "10"){
            $selectmonth = "ต.ค.";
        }else if($startif == "11"){
            $selectmonth = "พ.ย.";
        }else if($startif == "12"){
            $selectmonth = "ธ.ค.";
        }
    $starty = $startdateoil2[2]+543;
    $start_ymd = $startdateoil2[2].'-'.$startdateoil2[1].'-'.$startdateoil2[0];
    $startymd = $startdateoil2[2].'-'.$startdateoil2[1].'-'.$startdateoil2[0].' '.$starttimeoil1;

    $dateendoil = $_POST["txt_dateendoilvhct"];
    $enddateoil = explode(" ", $dateendoil);
    $enddateoil1 = $enddateoil[0];
    $endtimeoil1 = $enddateoil[1];
    $enddateoil2 = explode("/", $enddateoil1);
    $endd = $enddateoil2[0];
    $endif = $enddateoil2[1];
        if($endif == "01"){
            $selectmonth = "ม.ค.";
        }else if($endif == "02"){
            $selectmonth = "ก.พ.";
        }else if($endif == "03"){
            $selectmonth = "มี.ค.";
        }else if($endif == "04"){
            $selectmonth = "เม.ย.";
        }else if($endif == "05"){
            $selectmonth = "พ.ค.";
        }else if($endif == "06"){
            $selectmonth = "มิ.ย.";
        }else if($endif == "07"){
            $selectmonth = "ก.ค.";
        }else if($endif == "08"){
            $selectmonth = "ส.ค.";
        }else if($endif == "09"){
            $selectmonth = "ก.ย.";
        }else if($endif == "10"){
            $selectmonth = "ต.ค.";
        }else if($endif == "11"){
            $selectmonth = "พ.ย.";
        }else if($endif == "12"){
            $selectmonth = "ธ.ค.";
        }
    $endy = $enddateoil2[2]+543;
    $end_ymd = $enddateoil2[2].'-'.$enddateoil2[1].'-'.$enddateoil2[0];
    $endymd = $enddateoil2[2].'-'.$enddateoil2[1].'-'.$enddateoil2[0].' '.$endtimeoil1;

    $selcompany2='RKS';
    $selcustomer2=$_POST['selcustomer2'];
		    
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

    
if ($EXCELVHCT != "") { 
    $objPHPExcel = new PHPExcel();
    
    // RCC/RATC-------------------------------------------------------------------------------------------------------------------------------------------------
 
        // $objPHPExcel->createSheet();   
        $objPHPExcel->setActiveSheetIndex(0);
        // OPEN SECTION
            $detail="รายงานเติมน้ำมันแยกประเภท (GW)";

            $objPHPExcel->getActiveSheet()->mergeCells('A1:W1');
            $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(0, 1, $detail);$sheet->mergeCells('A1:R3');$objPHPExcel->getActiveSheet()->getStyle('A1:S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            $objDrawing = new PHPExcel_Worksheet_HeaderFooterDrawing();
            $objPHPExcel->getActiveSheet()->getHeaderFooter()->addImage($objDrawing, PHPExcel_Worksheet_HeaderFooter::IMAGE_HEADER_LEFT);

            $styleText = array('font'  => array('bold'  => false,'color' => array('rgb' => '000000'),'size'  => 10,'name'  => 'Verdana'));     
            $sheet->getDefaultStyle()->applyFromArray($styleText);

            $objPHPExcel->getActiveSheet()
            ->setCellValue('A3', 'ลำดับ')
            ->setCellValue('B3', 'วันที่')
            ->setCellValue('C3', 'เลขบัตร')
            ->setCellValue('D3', 'ทะเบียนรถ')
            ->setCellValue('E3', 'ชื่อรถ')
            ->setCellValue('F3', 'ประเภทรถ')
            ->setCellValue('G3', 'น้ำมัน')
            ->setCellValue('H3', 'เติมใน/ลิตร')
            ->setCellValue('I3', 'เติมนอก/ลิตร')
            ->setCellValue('J3', 'หัก PM')
            ->setCellValue('K3', 'รวมจำนวนลิตร')
            ->setCellValue('L3', 'ยอดเงิน')
            ->setCellValue('M3', 'ไมล์ต้น')
            ->setCellValue('N3', 'ไมล์ปลาย')
            ->setCellValue('O3', 'ระยะทาง')
            ->setCellValue('P3', 'มาตรฐานเรท : ค่าเฉลี่ยที่ได้')
            ->setCellValue('Q3', 'ต้นทาง')
            ->setCellValue('R3', 'เส้นทาง')
            ->setCellValue('S3', 'รอบวิ่งงาน')
            ->setCellValue('T3', 'ประเภทงาน')
            ->setCellValue('U3', 'พขร.1')
            ->setCellValue('U4', 'รหัส')
            ->setCellValue('V4', 'ชื่อ-สกุล')
            ->setCellValue('W3', 'พขร.2')
            ->setCellValue('W4', 'รหัส')
            ->setCellValue('X4', 'ชื่อ-สกุล')
            ->setCellValue('Y3', 'เลข JOB จากแผน')
            ->setCellValue('Z3', 'เลข JOB จากน้ำมัน')
            ->setCellValue('AA3', 'หมายเหตุ');
            $objPHPExcel->getActiveSheet()->mergeCells('A3:A4');
            $objPHPExcel->getActiveSheet()->mergeCells('B3:B4');
            $objPHPExcel->getActiveSheet()->mergeCells('C3:C4');
            $objPHPExcel->getActiveSheet()->mergeCells('D3:D4');
            $objPHPExcel->getActiveSheet()->mergeCells('E3:E4');
            $objPHPExcel->getActiveSheet()->mergeCells('F3:F4');
            $objPHPExcel->getActiveSheet()->mergeCells('G3:G4');
            $objPHPExcel->getActiveSheet()->mergeCells('H3:H4');
            $objPHPExcel->getActiveSheet()->mergeCells('I3:I4');
            $objPHPExcel->getActiveSheet()->mergeCells('J3:J4');
            $objPHPExcel->getActiveSheet()->mergeCells('K3:K4');
            $objPHPExcel->getActiveSheet()->mergeCells('L3:L4'); 
            $objPHPExcel->getActiveSheet()->mergeCells('M3:M4');
            $objPHPExcel->getActiveSheet()->mergeCells('N3:N4');
            $objPHPExcel->getActiveSheet()->mergeCells('O3:O4');
            $objPHPExcel->getActiveSheet()->mergeCells('P3:P4');
            $objPHPExcel->getActiveSheet()->mergeCells('Q3:Q4');
            $objPHPExcel->getActiveSheet()->mergeCells('R3:R4');
            $objPHPExcel->getActiveSheet()->mergeCells('S3:S4');
            $objPHPExcel->getActiveSheet()->mergeCells('T3:T4');  
            $objPHPExcel->getActiveSheet()->mergeCells('U3:V3');  
            $objPHPExcel->getActiveSheet()->mergeCells('W3:X3');   
            $objPHPExcel->getActiveSheet()->mergeCells('Y3:Y4');   
            $objPHPExcel->getActiveSheet()->mergeCells('Z3:Z4');  
            $objPHPExcel->getActiveSheet()->mergeCells('AA3:AA4');   
            
            $sheet->getStyle("A3:T4")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("U3:X3")->applyFromArray(array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("V3:V4")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("X3:X4")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("U4:X4")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("Y3:AA4")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
        
            $sheet->getStyle('A3:Z4')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '9ACD32'))));
            $sheet->getStyle('AA3:AA4')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FF8C00'))));
            $objPHPExcel->getActiveSheet()->getStyle('A3:AA4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(12);
            $sheet->getColumnDimension('C')->setWidth(12);
            $sheet->getColumnDimension('D')->setWidth(12);
            $sheet->getColumnDimension('E')->setWidth(12);
            $sheet->getColumnDimension('F')->setWidth(12);
            $sheet->getColumnDimension('G')->setWidth(10);
            $sheet->getColumnDimension('H')->setWidth(12);
            $sheet->getColumnDimension('I')->setWidth(12);
            $sheet->getColumnDimension('J')->setWidth(12);
            $sheet->getColumnDimension('K')->setWidth(12);
            $sheet->getColumnDimension('L')->setWidth(12);
            $sheet->getColumnDimension('M')->setWidth(12);
            $sheet->getColumnDimension('N')->setWidth(12);
            $sheet->getColumnDimension('O')->setWidth(12);
            $sheet->getColumnDimension('P')->setWidth(21);
            $sheet->getColumnDimension('Q')->setWidth(20);
            $sheet->getColumnDimension('R')->setWidth(20);
            $sheet->getColumnDimension('S')->setWidth(12);
            $sheet->getColumnDimension('T')->setWidth(12);
            $sheet->getColumnDimension('U')->setWidth(8);
            $sheet->getColumnDimension('V')->setWidth(20);
            $sheet->getColumnDimension('W')->setWidth(8);
            $sheet->getColumnDimension('X')->setWidth(20);
            $sheet->getColumnDimension('Y')->setWidth(20);
            $sheet->getColumnDimension('Z')->setWidth(20);
            $sheet->getColumnDimension('AA')->setWidth(50);
            
            $sheet->getStyle("H5:K500")->getNumberFormat()->setFormatCode('0.00'); 
            $objPHPExcel->getActiveSheet()->getStyle('A:G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('H:O')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('P:T')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('Y:Z')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $stmm1 = "SELECT * FROM vwRPRFE_VHCT_GW_RCCRATC WHERE REFUELINGDATE BETWEEN '$startymd' AND '$endymd' ORDER BY REFUEL ASC";
            $querystmm1 = sqlsrv_query($conn, $stmm1 );
            $i = 5;
            while($objResult1 = sqlsrv_fetch_array($querystmm1)) {  
                    $REFUEL=$objResult1["REFUEL"];
                    $CONREFUEL = explode("-", $REFUEL);
                    $RSREFUEL = $CONREFUEL[2].'/'.$CONREFUEL[1].'/'.$CONREFUEL[0];
                    $OBLNB=$objResult1["OBLNB"];
                    $CNB=$objResult1["CNB"];
                    $VHCRG=$objResult1["VHCRG"];
                    $VHCTN=$objResult1["VHCTN"];
                    $VHCTPLAN=$objResult1["VHCTPLAN"];
                    $VHCTOIL=$objResult1["VHCTOIL"];
                    $ENGY=$objResult1["ENGY"];
                    $OAM=$objResult1["OAM"];
                    $MONEY=$objResult1["MONEY"];
                    $MST=$objResult1["MST"];
                    $MLE=$objResult1["MLE"];
                    $DTE=$objResult1["DTE"];
                    $OAVG=$objResult1["OAVG"];
                    $OTG=$objResult1["OTG"];
                    $JOBSTART=$objResult1["JOBSTART"];
                    $JOBEND=$objResult1["JOBEND"];
                    $ROUNDAMOUNT=$objResult1["ROUNDAMOUNT"];
                    $WORKTYPE=$objResult1["WORKTYPE"];
                    $EMP1=$objResult1["EMP1"];
                    $EMPN1=$objResult1["EMPN1"];
                    $EMP2=$objResult1["EMP2"];
                    $EMPN2=$objResult1["EMPN2"];
                    $JNOIL=$objResult1["JNOIL"];
                    $JNPLAN=$objResult1["JNPLAN"];
                    $RS_OILREMARK=$objResult1["RS_OILREMARK"];
                    // $CAL1='=J'.$i.'-I'.$i;
                    // if($CAL1!=0){
                    //     $RSCAL1=$CAL1;
                    // }else{
                    //     $RSCAL1="";
                    // }
                    if($RSREFUEL!="//"){
                        $RSCHKREFUEL=$RSREFUEL;
                    }else{
                        $RSCHKREFUEL="";
                    }
                    if(isset($objResult1["OSGS_AM"])){
                        if($objResult1["OSGS_AM"] > 0){
                            $CHKOUT=$objResult1["OSGS_OUT"];
                            $CHKPM=$objResult1["OSGS_PM"];
                            $CALOAM=($OAM+$CHKOUT)-$CHKPM;
                            $CALOAVG=number_format($DTE/$CALOAM,2);
                            $CALMONEY=$MONEY;
                            $CHKRM=$objResult1["OSGS_RM"];                            
                            if(isset($CHKRM)){
                                $RSREMARK = ' ... '.$CHKRM;
                            }else{
                                $RSREMARK = '';
                            }
                            if(($OAM > 0) && ($CHKOUT > 0) && ($CHKPM > 0)){
                                $REMARK='(เติมใน+เติมนอก)-PM ... ('.$OAM.'+'.$CHKOUT.')-'.$CHKPM.' = '.$CALOAM.' ลิตร';
                            }else if(($OAM > 0) && ($CHKOUT > 0) && ($CHKPM == '0')){
                                    $REMARK='เติมใน+เติมนอก ... '.$OAM.'+'.$CHKOUT.' = '.$CALOAM.' ลิตร';
                            }else if(($OAM > 0) && ($CHKOUT == '0') && ($CHKPM > 0)){
                                    $REMARK='เติมใน-PM ... '.$OAM.'-'.$CHKPM.' = '.$CALOAM.' ลิตร';
                            }
                        }else{
                            $CALOAM=$OAM;
                            $CALOAVG=$OAVG;
                            $CALMONEY=$MONEY;
                            $CHKOUT='';
                            $CHKPM='';
                            $REMARK='';
                            $RSREMARK='';
                        }
                    }else{
                        $CALOAM=$OAM;
                        $CALOAVG=$OAVG;
                        $CALMONEY=$MONEY;
                        $CHKOUT='';
                        $CHKPM='';
                        $REMARK='';
                        $RSREMARK='';
                    }
                    
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, ++$SHEET1);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $RSCHKREFUEL);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $CNB);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $VHCRG);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $VHCTN);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $VHCTPLAN);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, 'ดีเซล');
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $OAM);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $CHKOUT);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $CHKPM);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $CALOAM);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $CALMONEY);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $MST);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $MLE);
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $DTE);
                $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $OTG.' : '.$CALOAVG);
                $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $JOBSTART);
                $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $JOBEND);
                $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $ROUNDAMOUNT);
                $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $WORKTYPE);
                $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $EMP1);
                $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $EMPN1);
                $objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $EMP2);
                $objPHPExcel->getActiveSheet()->setCellValue('X' . $i, $EMPN2);
                $objPHPExcel->getActiveSheet()->setCellValue('Y' . $i, $JNPLAN);
                $objPHPExcel->getActiveSheet()->setCellValue('Z' . $i, $JNOIL);
                $objPHPExcel->getActiveSheet()->setCellValue('AA' . $i, $REMARK.$RSREMARK);
            $i++;
            }                    
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':G'.$i);
            $objPHPExcel->getActiveSheet()->mergeCells('M'.$i.':N'.$i);
            $objPHPExcel->getActiveSheet()->mergeCells('Q'.$i.':AA'.$i);
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, 'รวม');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold( true );                    
            $sheet->getStyle('H'.$i.':P'.$i)->getNumberFormat()->setFormatCode('0.00');

            $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, '=SUM(H5:H'.($i -1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, '=SUM(I5:I'.($i -1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, '=SUM(J5:J'.($i -1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, '=SUM(K5:K'.($i -1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, '=SUM(L5:L'.($i -1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, '=SUM(O5:O'.($i -1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, '=O'.$i.'/K'.$i);           

            $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A5:AA'.$i)->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle('A'.$i.':AA'.$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));
        // CLOSE SECTION 
        $objPHPExcel->getActiveSheet()->setTitle('RCC-RATC');

    // RRC-------------------------------------------------------------------------------------------------------------------------------------------------
  
        $objPHPExcel->createSheet();   
        $objPHPExcel->setActiveSheetIndex(1);
        // OPEN SECTION
            $detail="รายงานเติมน้ำมันแยกประเภท (GW)";

            $objPHPExcel->getActiveSheet()->mergeCells('A1:V1');
            $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(0, 1, $detail);$sheet->mergeCells('A1:R3');$objPHPExcel->getActiveSheet()->getStyle('A1:S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            $objDrawing = new PHPExcel_Worksheet_HeaderFooterDrawing();
            $objPHPExcel->getActiveSheet()->getHeaderFooter()->addImage($objDrawing, PHPExcel_Worksheet_HeaderFooter::IMAGE_HEADER_LEFT);

            $styleText = array('font'  => array('bold'  => false,'color' => array('rgb' => '000000'),'size'  => 10,'name'  => 'Verdana'));     
            $sheet->getDefaultStyle()->applyFromArray($styleText);

            $objPHPExcel->getActiveSheet()
            ->setCellValue('A3', 'ลำดับ')
            ->setCellValue('B3', 'วันที่')
            ->setCellValue('C3', 'เลขบัตร')
            ->setCellValue('D3', 'ทะเบียนรถ')
            ->setCellValue('E3', 'ชื่อรถ')
            ->setCellValue('F3', 'ประเภทรถ')
            ->setCellValue('G3', 'น้ำมัน')
            ->setCellValue('H3', 'เติมใน/ลิตร')
            ->setCellValue('I3', 'เติมนอก/ลิตร')
            ->setCellValue('J3', 'หัก PM')
            ->setCellValue('K3', 'รวมจำนวนลิตร')
            ->setCellValue('L3', 'ยอดเงิน')
            ->setCellValue('M3', 'ไมล์ต้น')
            ->setCellValue('N3', 'ไมล์ปลาย')
            ->setCellValue('O3', 'ระยะทาง')
            ->setCellValue('P3', 'มาตรฐานเรท : ค่าเฉลี่ยที่ได้')
            ->setCellValue('Q3', 'ต้นทาง')
            ->setCellValue('R3', 'เส้นทาง')
            ->setCellValue('S3', 'รอบวิ่งงาน')
            ->setCellValue('T3', 'พขร.1')
            ->setCellValue('T4', 'รหัส')
            ->setCellValue('U4', 'ชื่อ-สกุล')
            ->setCellValue('V3', 'พขร.2')
            ->setCellValue('V4', 'รหัส')
            ->setCellValue('W4', 'ชื่อ-สกุล')
            ->setCellValue('X3', 'เลข JOB จากแผน')
            ->setCellValue('Y3', 'เลข JOB จากน้ำมัน')
            ->setCellValue('Z3', 'หมายเหตุ');
            $objPHPExcel->getActiveSheet()->mergeCells('A3:A4');
            $objPHPExcel->getActiveSheet()->mergeCells('B3:B4');
            $objPHPExcel->getActiveSheet()->mergeCells('C3:C4');
            $objPHPExcel->getActiveSheet()->mergeCells('D3:D4');
            $objPHPExcel->getActiveSheet()->mergeCells('E3:E4');
            $objPHPExcel->getActiveSheet()->mergeCells('F3:F4');
            $objPHPExcel->getActiveSheet()->mergeCells('G3:G4');
            $objPHPExcel->getActiveSheet()->mergeCells('H3:H4');
            $objPHPExcel->getActiveSheet()->mergeCells('I3:I4');
            $objPHPExcel->getActiveSheet()->mergeCells('J3:J4');
            $objPHPExcel->getActiveSheet()->mergeCells('K3:K4');
            $objPHPExcel->getActiveSheet()->mergeCells('L3:L4'); 
            $objPHPExcel->getActiveSheet()->mergeCells('M3:M4');
            $objPHPExcel->getActiveSheet()->mergeCells('N3:N4');
            $objPHPExcel->getActiveSheet()->mergeCells('O3:O4');
            $objPHPExcel->getActiveSheet()->mergeCells('P3:P4');
            $objPHPExcel->getActiveSheet()->mergeCells('Q3:Q4');
            $objPHPExcel->getActiveSheet()->mergeCells('R3:R4');
            $objPHPExcel->getActiveSheet()->mergeCells('S3:S4');
            $objPHPExcel->getActiveSheet()->mergeCells('T3:U3');  
            $objPHPExcel->getActiveSheet()->mergeCells('V3:W3');   
            $objPHPExcel->getActiveSheet()->mergeCells('X3:X4');   
            $objPHPExcel->getActiveSheet()->mergeCells('Y3:Y4');  
            $objPHPExcel->getActiveSheet()->mergeCells('Z3:Z4');
            
            $sheet->getStyle("A3:S4")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("T3:W3")->applyFromArray(array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("U3:U4")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("W3:W4")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("T4:W4")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("X3:Z4")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
        
            $sheet->getStyle('A3:Y4')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '9ACD32'))));
            $sheet->getStyle('Z3:Z4')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FF8C00'))));
            $objPHPExcel->getActiveSheet()->getStyle('A3:Z4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(12);
            $sheet->getColumnDimension('C')->setWidth(12);
            $sheet->getColumnDimension('D')->setWidth(12);
            $sheet->getColumnDimension('E')->setWidth(12);
            $sheet->getColumnDimension('F')->setWidth(12);
            $sheet->getColumnDimension('G')->setWidth(10);
            $sheet->getColumnDimension('H')->setWidth(12);
            $sheet->getColumnDimension('I')->setWidth(12);
            $sheet->getColumnDimension('J')->setWidth(12);
            $sheet->getColumnDimension('K')->setWidth(12);
            $sheet->getColumnDimension('L')->setWidth(12);
            $sheet->getColumnDimension('M')->setWidth(12);
            $sheet->getColumnDimension('N')->setWidth(12);
            $sheet->getColumnDimension('O')->setWidth(12);
            $sheet->getColumnDimension('P')->setWidth(21);
            $sheet->getColumnDimension('Q')->setWidth(20);
            $sheet->getColumnDimension('R')->setWidth(20);
            $sheet->getColumnDimension('S')->setWidth(12);
            $sheet->getColumnDimension('T')->setWidth(8);
            $sheet->getColumnDimension('U')->setWidth(20);
            $sheet->getColumnDimension('V')->setWidth(8);
            $sheet->getColumnDimension('W')->setWidth(20);
            $sheet->getColumnDimension('X')->setWidth(20);
            $sheet->getColumnDimension('Y')->setWidth(20);
            $sheet->getColumnDimension('Z')->setWidth(50);
            
            $sheet->getStyle("H5:K500")->getNumberFormat()->setFormatCode('0.00'); 
            $objPHPExcel->getActiveSheet()->getStyle('A:G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('H:O')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('P:S')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('X:Y')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $stmm2 = "SELECT * FROM vwRPRFE_VHCT_GW_RRC WHERE REFUELINGDATE BETWEEN '$startymd' AND '$endymd' ORDER BY REFUEL ASC";
                    // ORDER BY VHCTPP.VEHICLETYPE,VHCTPP.EMPLOYEECODE1 ASC";
            $querystmm2 = sqlsrv_query($conn, $stmm2 );
            $i = 5;
            while($objResult2 = sqlsrv_fetch_array($querystmm2)) {  
                    $REFUEL=$objResult2["REFUEL"];
                    $CONREFUEL = explode("-", $REFUEL);
                    $RSREFUEL = $CONREFUEL[2].'/'.$CONREFUEL[1].'/'.$CONREFUEL[0];
                    $OBLNB=$objResult2["OBLNB"];
                    $CNB=$objResult2["CNB"];
                    $VHCRG=$objResult2["VHCRG"];
                    $VHCTN=$objResult2["VHCTN"];
                    $VHCTPLAN=$objResult2["VHCTPLAN"];
                    $VHCTOIL=$objResult2["VHCTOIL"];
                    $ENGY=$objResult2["ENGY"];
                    $OAM=$objResult2["OAM"];
                    $MONEY=$objResult2["MONEY"];
                    $MST=$objResult2["MST"];
                    $MLE=$objResult2["MLE"];
                    $DTE=$objResult2["DTE"];
                    $OAVG=$objResult2["OAVG"];
                    $OTG=$objResult2["OTG"];
                    $JOBSTART=$objResult2["JOBSTART"];
                    $JOBEND=$objResult2["JOBEND"];
                    $ROUNDAMOUNT=$objResult2["ROUNDAMOUNT"];
                    $WORKTYPE=$objResult2["WORKTYPE"];
                    $EMP1=$objResult2["EMP1"];
                    $EMPN1=$objResult2["EMPN1"];
                    $EMP2=$objResult2["EMP2"];
                    $EMPN2=$objResult2["EMPN2"];
                    $JNOIL=$objResult2["JNOIL"];
                    $JNPLAN=$objResult2["JNPLAN"];
                    $RS_OILREMARK=$objResult2["RS_OILREMARK"];
                    // $CAL1='=J'.$i.'-I'.$i;
                    // if($CAL1!=0){
                    //     $RSCAL1=$CAL1;
                    // }else{
                    //     $RSCAL1="";
                    // }
                    if($RSREFUEL!="//"){
                        $RSCHKREFUEL=$RSREFUEL;
                    }else{
                        $RSCHKREFUEL="";
                    }
                    if(isset($objResult2["OSGS_AM"])){
                        if($objResult2["OSGS_AM"] > 0){
                            $CHKOUT=$objResult2["OSGS_OUT"];
                            $CHKPM=$objResult2["OSGS_PM"];
                            $CALOAM=($OAM+$CHKOUT)-$CHKPM;
                            $CALOAVG=number_format($DTE/$CALOAM,2);
                            $CALMONEY=$MONEY;
                            $CHKRM=$objResult2["OSGS_RM"];                            
                            if(isset($CHKRM)){
                                $RSREMARK = ' ... '.$CHKRM;
                            }else{
                                $RSREMARK = '';
                            }
                            if(($OAM > 0) && ($CHKOUT > 0) && ($CHKPM > 0)){
                                $REMARK='(เติมใน+เติมนอก)-PM ... ('.$OAM.'+'.$CHKOUT.')-'.$CHKPM.' = '.$CALOAM.' ลิตร';
                            }else if(($OAM > 0) && ($CHKOUT > 0) && ($CHKPM == '0')){
                                    $REMARK='เติมใน+เติมนอก ... '.$OAM.'+'.$CHKOUT.' = '.$CALOAM.' ลิตร';
                            }else if(($OAM > 0) && ($CHKOUT == '0') && ($CHKPM > 0)){
                                    $REMARK='เติมใน-PM ... '.$OAM.'-'.$CHKPM.' = '.$CALOAM.' ลิตร';
                            }
                        }else{
                            $CALOAM=$OAM;
                            $CALOAVG=$OAVG;
                            $CALMONEY=$MONEY;
                            $CHKOUT='';
                            $CHKPM='';
                            $REMARK='';
                            $RSREMARK='';
                        }
                    }else{
                        $CALOAM=$OAM;
                        $CALOAVG=$OAVG;
                        $CALMONEY=$MONEY;
                        $CHKOUT='';
                        $CHKPM='';
                        $REMARK='';
                        $RSREMARK='';
                    }
                    
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, ++$SHEET2);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $RSCHKREFUEL);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $CNB);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $VHCRG);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $VHCTN);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $VHCTPLAN);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, 'ดีเซล');
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $OAM);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $CHKOUT);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $CHKPM);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $CALOAM);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $CALMONEY);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $MST);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $MLE);
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $DTE);
                $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $OTG.' : '.$CALOAVG);
                $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $JOBSTART);
                $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $JOBEND);
                $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $ROUNDAMOUNT);
                $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $EMP1);
                $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $EMPN1);
                $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $EMP2);
                $objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $EMPN2);
                $objPHPExcel->getActiveSheet()->setCellValue('X' . $i, $JNPLAN);
                $objPHPExcel->getActiveSheet()->setCellValue('Y' . $i, $JNOIL);
                $objPHPExcel->getActiveSheet()->setCellValue('Z' . $i, $REMARK.$RSREMARK);
            $i++;
            }                    
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':G'.$i);
            $objPHPExcel->getActiveSheet()->mergeCells('M'.$i.':N'.$i);
            $objPHPExcel->getActiveSheet()->mergeCells('Q'.$i.':Z'.$i);
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, 'รวม');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold( true );                    
            $sheet->getStyle('H'.$i.':P'.$i)->getNumberFormat()->setFormatCode('0.00');

            $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, '=SUM(H5:H'.($i -1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, '=SUM(I5:I'.($i -1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, '=SUM(J5:J'.($i -1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, '=SUM(K5:K'.($i -1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, '=SUM(L5:L'.($i -1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, '=SUM(O5:O'.($i -1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, '=O'.$i.'/K'.$i);       

            $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A5:Z'.$i)->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle('A'.$i.':Z'.$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));
        // CLOSE SECTION 
        $objPHPExcel->getActiveSheet()->setTitle('RRC');

    // CENTER-------------------------------------------------------------------------------------------------------------------------------------------------
  
        $objPHPExcel->createSheet();   
        $objPHPExcel->setActiveSheetIndex(2);
        // OPEN SECTION
            $detail="รายงานเติมน้ำมันแยกประเภท (GW)";

            $objPHPExcel->getActiveSheet()->mergeCells('A1:R1');
            $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(0, 1, $detail);$sheet->mergeCells('A1:R3');$objPHPExcel->getActiveSheet()->getStyle('A1:S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            $objDrawing = new PHPExcel_Worksheet_HeaderFooterDrawing();
            $objPHPExcel->getActiveSheet()->getHeaderFooter()->addImage($objDrawing, PHPExcel_Worksheet_HeaderFooter::IMAGE_HEADER_LEFT);

            $styleText = array('font'  => array('bold'  => false,'color' => array('rgb' => '000000'),'size'  => 10,'name'  => 'Verdana'));     
            $sheet->getDefaultStyle()->applyFromArray($styleText);

            $objPHPExcel->getActiveSheet()
            ->setCellValue('A3', 'ลำดับ')
            ->setCellValue('B3', 'วันที่')
            ->setCellValue('C3', 'เลขบัตร')
            ->setCellValue('D3', 'ทะเบียนรถ')
            ->setCellValue('E3', 'ชื่อรถ')
            ->setCellValue('F3', 'ประเภทรถ')
            ->setCellValue('G3', 'น้ำมัน')
            ->setCellValue('H3', 'จำนวนลิตร')
            ->setCellValue('I3', 'ไมล์ต้น')
            ->setCellValue('J3', 'ไมล์ปลาย')
            ->setCellValue('K3', 'ระยะทาง')
            ->setCellValue('L3', 'ค่าเฉลี่ยที่ได้')
            ->setCellValue('M3', 'เลข JOB จากน้ำมัน');
            $objPHPExcel->getActiveSheet()->mergeCells('A3:A4');
            $objPHPExcel->getActiveSheet()->mergeCells('B3:B4');
            $objPHPExcel->getActiveSheet()->mergeCells('C3:C4');
            $objPHPExcel->getActiveSheet()->mergeCells('D3:D4');
            $objPHPExcel->getActiveSheet()->mergeCells('E3:E4');
            $objPHPExcel->getActiveSheet()->mergeCells('F3:F4');
            $objPHPExcel->getActiveSheet()->mergeCells('G3:G4');
            $objPHPExcel->getActiveSheet()->mergeCells('H3:H4');
            $objPHPExcel->getActiveSheet()->mergeCells('I3:I4');
            $objPHPExcel->getActiveSheet()->mergeCells('J3:J4');
            $objPHPExcel->getActiveSheet()->mergeCells('K3:K4');
            $objPHPExcel->getActiveSheet()->mergeCells('L3:L4'); 
            $objPHPExcel->getActiveSheet()->mergeCells('M3:M4');
            
            $sheet->getStyle("A3:M4")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle('A3:M4')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '9ACD32'))));
            $objPHPExcel->getActiveSheet()->getStyle('A3:M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(12);
            $sheet->getColumnDimension('C')->setWidth(12);
            $sheet->getColumnDimension('D')->setWidth(12);
            $sheet->getColumnDimension('E')->setWidth(12);
            $sheet->getColumnDimension('F')->setWidth(20);
            $sheet->getColumnDimension('G')->setWidth(10);
            $sheet->getColumnDimension('H')->setWidth(12);
            $sheet->getColumnDimension('I')->setWidth(9);
            $sheet->getColumnDimension('J')->setWidth(9);
            $sheet->getColumnDimension('K')->setWidth(9);
            $sheet->getColumnDimension('L')->setWidth(12);
            $sheet->getColumnDimension('M')->setWidth(25);
            
            $sheet->getStyle("H5:H500")->getNumberFormat()->setFormatCode('0.00'); 
            $sheet->getStyle("L5:L500")->getNumberFormat()->setFormatCode('0.00'); 
            $objPHPExcel->getActiveSheet()->getStyle('A:G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('H:J')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('K:L')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('M')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
            $stmm3 = "SELECT * FROM vwRPRFE_VHCT_GW_CENTER WHERE REFUELINGDATE BETWEEN '$startymd' AND '$endymd' ORDER BY REFUEL ASC";
            $querystmm3 = sqlsrv_query($conn, $stmm3 );
            $i = 5;
            while($objResult3 = sqlsrv_fetch_array($querystmm3)) {  
                    $REFUEL=$objResult3["REFUEL"];
                    $CONREFUEL = explode("-", $REFUEL);
                    $RSREFUEL = $CONREFUEL[2].'/'.$CONREFUEL[1].'/'.$CONREFUEL[0];
                    $OBLNB=$objResult3["OBLNB"];
                    $CNB=$objResult3["CNB"];
                    $VHCRG=$objResult3["VHCRG"];
                    $VHCTN=$objResult3["VHCTN"];
                    $VHCTPLAN=$objResult3["VHCTPLAN"];
                    $VHCTOIL=$objResult3["VHCTOIL"];
                    $ENGY=$objResult3["ENGY"];
                    $OAM=$objResult3["OAM"];
                    $MST=$objResult3["MST"];
                    $MLE=$objResult3["MLE"];
                    $DTE=$objResult3["DTE"];
                    $OAVG=$objResult3["OAVG"];
                    $OTG=$objResult3["OTG"];
                    $JOBSTART=$objResult3["JOBSTART"];
                    $JOBEND=$objResult3["JOBEND"];
                    $ROUNDAMOUNT=$objResult3["ROUNDAMOUNT"];
                    $WORKTYPE=$objResult3["WORKTYPE"];
                    $EMP1=$objResult3["EMP1"];
                    $EMPN1=$objResult3["EMPN1"];
                    $EMP2=$objResult3["EMP2"];
                    $EMPN2=$objResult3["EMPN2"];
                    $JNOIL=$objResult3["JNOIL"];
                    $JNPLAN=$objResult3["JNPLAN"];
                    $RS_OILREMARK=$objResult3["RS_OILREMARK"];
                    if($RSREFUEL!="//"){
                        $RSCHKREFUEL=$RSREFUEL;
                    }else{
                        $RSCHKREFUEL="";
                    }
                    
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, ++$SHEET3);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $RSCHKREFUEL);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $CNB);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $VHCRG);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $VHCTN);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $VHCTPLAN);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, 'ดีเซล');
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $OAM);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $MST);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $MLE);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $DTE);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $OAVG);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $JNOIL);
            $i++;
            }                    
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':G'.$i);
            $objPHPExcel->getActiveSheet()->mergeCells('I'.$i.':J'.$i);
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, 'รวม');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold( true );                    
            $sheet->getStyle('H'.$i.':L'.$i)->getNumberFormat()->setFormatCode('0.00');

            $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, '=SUM(H5:H'.($i -1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, '=SUM(K5:K'.($i -1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, '=K'.$i.'/H'.$i);         

            $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A5:M'.$i)->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle('A'.$i.':M'.$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));
        // CLOSE SECTION 
        $objPHPExcel->getActiveSheet()->setTitle('รถส่วนกลาง');

    // OUT-------------------------------------------------------------------------------------------------------------------------------------------------
  
        $objPHPExcel->createSheet();   
        $objPHPExcel->setActiveSheetIndex(3);
        // OPEN SECTION
            $detail="รายงานเติมน้ำมันแยกประเภท (GW)";

            $objPHPExcel->getActiveSheet()->mergeCells('A1:R1');
            $sheet = $objPHPExcel->getActiveSheet();$sheet->setCellValueByColumnAndRow(0, 1, $detail);$sheet->mergeCells('A1:R3');$objPHPExcel->getActiveSheet()->getStyle('A1:S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            $objDrawing = new PHPExcel_Worksheet_HeaderFooterDrawing();
            $objPHPExcel->getActiveSheet()->getHeaderFooter()->addImage($objDrawing, PHPExcel_Worksheet_HeaderFooter::IMAGE_HEADER_LEFT);

            $styleText = array('font'  => array('bold'  => false,'color' => array('rgb' => '000000'),'size'  => 10,'name'  => 'Verdana'));     
            $sheet->getDefaultStyle()->applyFromArray($styleText);

            $objPHPExcel->getActiveSheet()
            ->setCellValue('A3', 'ลำดับ')
            ->setCellValue('B3', 'วันที่')
            ->setCellValue('C3', 'เลขบัตร')
            ->setCellValue('D3', 'ทะเบียนรถ')
            ->setCellValue('E3', 'ชื่อรถ')
            ->setCellValue('F3', 'ประเภทรถ')
            ->setCellValue('G3', 'น้ำมัน')
            ->setCellValue('H3', 'จำนวนลิตร')
            ->setCellValue('I3', 'ไมล์ต้น')
            ->setCellValue('J3', 'ไมล์ปลาย')
            ->setCellValue('K3', 'ระยะทาง')
            ->setCellValue('L3', 'ค่าเฉลี่ยที่ได้')
            ->setCellValue('M3', 'เลข JOB จากน้ำมัน');
            $objPHPExcel->getActiveSheet()->mergeCells('A3:A4');
            $objPHPExcel->getActiveSheet()->mergeCells('B3:B4');
            $objPHPExcel->getActiveSheet()->mergeCells('C3:C4');
            $objPHPExcel->getActiveSheet()->mergeCells('D3:D4');
            $objPHPExcel->getActiveSheet()->mergeCells('E3:E4');
            $objPHPExcel->getActiveSheet()->mergeCells('F3:F4');
            $objPHPExcel->getActiveSheet()->mergeCells('G3:G4');
            $objPHPExcel->getActiveSheet()->mergeCells('H3:H4');
            $objPHPExcel->getActiveSheet()->mergeCells('I3:I4');
            $objPHPExcel->getActiveSheet()->mergeCells('J3:J4');
            $objPHPExcel->getActiveSheet()->mergeCells('K3:K4');
            $objPHPExcel->getActiveSheet()->mergeCells('L3:L4'); 
            $objPHPExcel->getActiveSheet()->mergeCells('M3:M4');
            
            $sheet->getStyle("A3:M4")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle('A3:M4')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '9ACD32'))));
            $objPHPExcel->getActiveSheet()->getStyle('A3:M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(12);
            $sheet->getColumnDimension('C')->setWidth(12);
            $sheet->getColumnDimension('D')->setWidth(12);
            $sheet->getColumnDimension('E')->setWidth(12);
            $sheet->getColumnDimension('F')->setWidth(20);
            $sheet->getColumnDimension('G')->setWidth(10);
            $sheet->getColumnDimension('H')->setWidth(12);
            $sheet->getColumnDimension('I')->setWidth(9);
            $sheet->getColumnDimension('J')->setWidth(9);
            $sheet->getColumnDimension('K')->setWidth(9);
            $sheet->getColumnDimension('L')->setWidth(12);
            $sheet->getColumnDimension('M')->setWidth(25);
            
            $sheet->getStyle("H5:H500")->getNumberFormat()->setFormatCode('0.00'); 
            $sheet->getStyle("L5:L500")->getNumberFormat()->setFormatCode('0.00'); 
            $objPHPExcel->getActiveSheet()->getStyle('A:G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('H:J')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('K:L')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('M')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
            $stmm4 = "SELECT * FROM vwRPRFE_VHCT_GW_OUTHER WHERE REFUELINGDATE BETWEEN '$startymd' AND '$endymd' ORDER BY REFUEL ASC";
            $querystmm4 = sqlsrv_query($conn, $stmm4 );
            $i = 5;
            while($objResult4 = sqlsrv_fetch_array($querystmm4)) {  
                    $REFUEL=$objResult4["REFUEL"];
                    $CONREFUEL = explode("-", $REFUEL);
                    $RSREFUEL = $CONREFUEL[2].'/'.$CONREFUEL[1].'/'.$CONREFUEL[0];
                    $OBLNB=$objResult4["OBLNB"];
                    $CNB=$objResult4["CNB"];
                    $VHCRG=$objResult4["VHCRG"];
                    $VHCTN=$objResult4["VHCTN"];
                    $VHCTPLAN=$objResult4["VHCTPLAN"];
                    $VHCTOIL=$objResult4["VHCTOIL"];
                    $ENGY=$objResult4["ENGY"];
                    $OAM=$objResult4["OAM"];
                    $MST=$objResult4["MST"];
                    $MLE=$objResult4["MLE"];
                    $DTE=$objResult4["DTE"];
                    $OAVG=$objResult4["OAVG"];
                    $OTG=$objResult4["OTG"];
                    $JOBSTART=$objResult4["JOBSTART"];
                    $JOBEND=$objResult4["JOBEND"];
                    $ROUNDAMOUNT=$objResult4["ROUNDAMOUNT"];
                    $WORKTYPE=$objResult4["WORKTYPE"];
                    $EMP1=$objResult4["EMP1"];
                    $EMPN1=$objResult4["EMPN1"];
                    $EMP2=$objResult4["EMP2"];
                    $EMPN2=$objResult4["EMPN2"];
                    $JNOIL=$objResult4["JNOIL"];
                    $JNPLAN=$objResult4["JNPLAN"];
                    $RS_OILREMARK=$objResult4["RS_OILREMARK"];
                    if($RSREFUEL!="//"){
                        $RSCHKREFUEL=$RSREFUEL;
                    }else{
                        $RSCHKREFUEL="";
                    }
                    
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, ++$SHEET4);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $RSCHKREFUEL);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $CNB);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $VHCRG);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $VHCTN);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $VHCTPLAN);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, 'ดีเซล');
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $OAM);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $MST);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $MLE);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $DTE);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $OAVG);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $JNOIL);
            $i++;
            }                    
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':G'.$i);
            $objPHPExcel->getActiveSheet()->mergeCells('I'.$i.':J'.$i);
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, 'รวม');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold( true );                    
            $sheet->getStyle('H'.$i.':L'.$i)->getNumberFormat()->setFormatCode('0.00');

            $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, '=SUM(H5:H'.($i -1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, '=SUM(K5:K'.($i -1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, '=K'.$i.'/H'.$i);         

            $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A5:M'.$i)->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle('A'.$i.':M'.$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));
        // CLOSE SECTION 
        $objPHPExcel->getActiveSheet()->setTitle('OTHER');

    // END-------------------------------------------------------------------------------------------------------------------------------------------------
            // $objPHPExcel->setActiveSheetIndex(0);
            
    $RENAME= "รายงานเติมน้ำมันแยกประเภท (GW) $selectmonth $start_yth";
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