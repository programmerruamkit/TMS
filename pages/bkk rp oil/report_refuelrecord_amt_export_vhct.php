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
    
    // RKR-------------------------------------------------------------------------------------------------------------------------------------------------
 
        // $objPHPExcel->createSheet();   
        $objPHPExcel->setActiveSheetIndex(0);
        // OPEN SECTION
            $detail="รายงานเติมน้ำมันแยกบริษัท (AMT)";

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
            ->setCellValue('H3', 'จำนวนลิตร')
            ->setCellValue('I3', 'ไมล์ต้น')
            ->setCellValue('J3', 'ไมล์ปลาย')
            ->setCellValue('K3', 'ระยะทาง')
            ->setCellValue('L3', 'ค่าเฉลี่ยที่ได้')
            ->setCellValue('M3', 'ต้นทาง')
            ->setCellValue('N3', 'เส้นทาง')
            ->setCellValue('O3', 'รอบวิ่งงาน')
            ->setCellValue('P3', 'ประเภทงาน')
            ->setCellValue('Q3', 'พขร.1')
            ->setCellValue('Q4', 'รหัส')
            ->setCellValue('R4', 'ชื่อ-สกุล')
            ->setCellValue('S3', 'พขร.2')
            ->setCellValue('S4', 'รหัส')
            ->setCellValue('T4', 'ชื่อ-สกุล')
            ->setCellValue('U3', 'เลข JOB จากแผน')
            ->setCellValue('V3', 'เลข JOB จากน้ำมัน')
            ->setCellValue('W3', 'หมายเหตุ');
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
            $objPHPExcel->getActiveSheet()->mergeCells('Q3:R3');  
            $objPHPExcel->getActiveSheet()->mergeCells('S3:T3');   
            $objPHPExcel->getActiveSheet()->mergeCells('U3:U4');   
            $objPHPExcel->getActiveSheet()->mergeCells('V3:V4');  
            $objPHPExcel->getActiveSheet()->mergeCells('W3:W4');    
            
            $sheet->getStyle("A3:P4")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("Q3:T3")->applyFromArray(array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("R3:R4")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("T3:T4")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("Q4:T4")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("U3:W4")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
        
            $sheet->getStyle('A3:V4')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '9ACD32'))));
            $sheet->getStyle('W3:W4')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FF8C00'))));
            $objPHPExcel->getActiveSheet()->getStyle('A3:W4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            // // foreach(range('A','Z') as $columnID) { $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);} 
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(12);
            $sheet->getColumnDimension('C')->setWidth(12);
            $sheet->getColumnDimension('D')->setWidth(12);
            $sheet->getColumnDimension('E')->setWidth(12);
            $sheet->getColumnDimension('F')->setWidth(12);
            $sheet->getColumnDimension('G')->setWidth(10);
            $sheet->getColumnDimension('H')->setWidth(12);
            $sheet->getColumnDimension('I')->setWidth(9);
            $sheet->getColumnDimension('J')->setWidth(9);
            $sheet->getColumnDimension('K')->setWidth(9);
            $sheet->getColumnDimension('L')->setWidth(12);
            $sheet->getColumnDimension('M')->setWidth(20);
            $sheet->getColumnDimension('N')->setWidth(20);
            $sheet->getColumnDimension('O')->setWidth(12);
            $sheet->getColumnDimension('P')->setWidth(12);
            $sheet->getColumnDimension('Q')->setWidth(8);
            $sheet->getColumnDimension('R')->setWidth(20);
            $sheet->getColumnDimension('S')->setWidth(8);
            $sheet->getColumnDimension('T')->setWidth(20);
            $sheet->getColumnDimension('U')->setWidth(20);
            $sheet->getColumnDimension('V')->setWidth(20);
            $sheet->getColumnDimension('W')->setWidth(40);
            
            $sheet->getStyle("H5:H500")->getNumberFormat()->setFormatCode('0.00'); 
            $sheet->getStyle("L5:L500")->getNumberFormat()->setFormatCode('0.00'); 
            // $sheet->getStyle("Q10:S50")->getNumberFormat()->setFormatCode('0.00'); 
            $objPHPExcel->getActiveSheet()->getStyle('A:G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('H:J')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('K:L')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('O:P')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('U:V')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            // $objPHPExcel->getActiveSheet()->getStyle('M10:P49')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            // $objPHPExcel->getActiveSheet()->getStyle('Q10:Q49')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $stmm = "SELECT
                        DISTINCT
                        OTSN.OILDATAID OILID,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.CARDNUMBER CNB,
                        OTSN.VEHICLEREGISNUMBER VHCRG,
                        VHCIF.THAINAME VHCTN,
                        VHCTPP.VEHICLETYPE VHCTPLAN,
                        OTSN.VEHICLETYPE VHCTOIL,
                        VHCIF.ENERGY ENGY,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.JOBSTART,
                        VHCTPP.JOBEND,
                        VHCTPP.ROUNDAMOUNT,
                        VHCTPP.WORKTYPE,
                        VHCTPP.EMPLOYEECODE1 EMP1,
                        VHCTPP.EMPLOYEENAME1 EMPN1,
                        VHCTPP.EMPLOYEECODE2 EMP2,
                        VHCTPP.EMPLOYEENAME2 EMPN2,
                        OTSN.JOBNO JNOIL,
                        VHCTPP.JOBNO JNPLAN,
                        VHCTPP.RS_OILREMARK
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = 'RKR'
                    AND OTSN.REFUELINGDATE BETWEEN '$startymd' AND '$endymd'
                    ORDER BY CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) ASC";
                    // ORDER BY VHCTPP.VEHICLETYPE,VHCTPP.EMPLOYEECODE1 ASC";
            $querystmm = sqlsrv_query($conn, $stmm );
            $i = 5;
            while($objResult = sqlsrv_fetch_array($querystmm)) {  
                    $REFUEL=$objResult["REFUEL"];
                    $CONREFUEL = explode("-", $REFUEL);
                    $RSREFUEL = $CONREFUEL[2].'/'.$CONREFUEL[1].'/'.$CONREFUEL[0];
                    $OBLNB=$objResult["OBLNB"];
                    $CNB=$objResult["CNB"];
                    $VHCRG=$objResult["VHCRG"];
                    $VHCTN=$objResult["VHCTN"];
                    $VHCTPLAN=$objResult["VHCTPLAN"];
                    $VHCTOIL=$objResult["VHCTOIL"];
                    $ENGY=$objResult["ENGY"];
                    $OAM=$objResult["OAM"];
                    $MST=$objResult["MST"];
                    $MLE=$objResult["MLE"];
                    $DTE=$objResult["DTE"];
                    $OAVG=$objResult["OAVG"];
                    $OTG=$objResult["OTG"];
                    $JOBSTART=$objResult["JOBSTART"];
                    $JOBEND=$objResult["JOBEND"];
                    $ROUNDAMOUNT='';
                    // $ROUNDAMOUNT=$objResult["ROUNDAMOUNT"];
                    $WORKTYPE='';
                    // $WORKTYPE=$objResult["WORKTYPE"];
                    $EMP1=$objResult["EMP1"];
                    $EMPN1=$objResult["EMPN1"];
                    $EMP2=$objResult["EMP2"];
                    $EMPN2=$objResult["EMPN2"];
                    $JNOIL=$objResult["JNOIL"];
                    $JNPLAN=$objResult["JNPLAN"];
                    $RS_OILREMARK=$objResult["RS_OILREMARK"];
                    if(isset($RS_OILREMARK)){
                        $RSREMARK = ' มีเติม PM '.$RS_OILREMARK.' ลิตร';
                    }else{
                        $RSREMARK = '';
                    }
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
                    $SQL_CHK_OUTSIDE="SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM 
                    FROM OUTSIDE_GAS_STATION
                    LEFT JOIN VEHICLETRANSPORTPLAN ON VEHICLETRANSPORTPLANID = OSGS_PLID
                    WHERE JOBNO = '$JNPLAN'";
                    $QUERY_CHK_OUTSIDE = sqlsrv_query($conn, $SQL_CHK_OUTSIDE );
                    $RS_CHK_OUTSIDE = sqlsrv_fetch_array($QUERY_CHK_OUTSIDE, SQLSRV_FETCH_ASSOC); 
                    if(isset($RS_CHK_OUTSIDE["OSGS_AM"])){
                        if($RS_CHK_OUTSIDE["OSGS_AM"] > 0){
                            $CALOAM=$OAM+$RS_CHK_OUTSIDE["OSGS_AM"];
                            $CALOAVG=number_format($DTE/$CALOAM,2);
                            // $REMARK='มีการเติมน้ำมันจากภายนอก';
                            $REMARK='เติมใน('.$OAM.') + เติมนอก('.$RS_CHK_OUTSIDE["OSGS_AM"].') = '.$CALOAM.' ลิตร';
                        }else{
                        $CALOAM=$OAM;
                        $CALOAVG=$OAVG;
                        $REMARK='';
                        }
                    }else{
                        $CALOAM=$OAM;
                        $CALOAVG=$OAVG;
                        $REMARK='';
                    }
                    
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, ++$SHEET1);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $RSCHKREFUEL);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $CNB);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $VHCRG);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $VHCTN);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $VHCTPLAN);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, 'ดีเซล');
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $CALOAM);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $MST);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $MLE);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $DTE);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $CALOAVG);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $JOBSTART);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $JOBEND);
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $ROUNDAMOUNT);
                $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $WORKTYPE);
                $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $EMP1);
                $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $EMPN1);
                $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $EMP2);
                $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $EMPN2);
                $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $JNPLAN);
                $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $JNOIL);
                $objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $REMARK.$RSREMARK);
            $i++;
            }                    
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':G'.$i);
            $objPHPExcel->getActiveSheet()->mergeCells('I'.$i.':J'.$i);
            $objPHPExcel->getActiveSheet()->mergeCells('M'.$i.':W'.$i);
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, 'รวม');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold( true );                    
            $sheet->getStyle('H'.$i.':L'.$i)->getNumberFormat()->setFormatCode('0.00');

            $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, '=SUM(H5:H'.($i -1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, '=SUM(K5:K'.($i -1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, '=K'.$i.'/H'.$i);            

            $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A5:W'.$i)->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle('A'.$i.':W'.$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));
        // CLOSE SECTION 
        $objPHPExcel->getActiveSheet()->setTitle('RKR');

    // RKL-------------------------------------------------------------------------------------------------------------------------------------------------
 
        $objPHPExcel->createSheet();   
        $objPHPExcel->setActiveSheetIndex(1);
        // OPEN SECTION
            $detail="รายงานเติมน้ำมันแยกบริษัท (AMT)";

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
            ->setCellValue('H3', 'จำนวนลิตร')
            ->setCellValue('I3', 'ไมล์ต้น')
            ->setCellValue('J3', 'ไมล์ปลาย')
            ->setCellValue('K3', 'ระยะทาง')
            ->setCellValue('L3', 'ค่าเฉลี่ยที่ได้')
            ->setCellValue('M3', 'ต้นทาง')
            ->setCellValue('N3', 'เส้นทาง')
            ->setCellValue('O3', 'รอบวิ่งงาน')
            ->setCellValue('P3', 'ประเภทงาน')
            ->setCellValue('Q3', 'พขร.1')
            ->setCellValue('Q4', 'รหัส')
            ->setCellValue('R4', 'ชื่อ-สกุล')
            ->setCellValue('S3', 'พขร.2')
            ->setCellValue('S4', 'รหัส')
            ->setCellValue('T4', 'ชื่อ-สกุล')
            ->setCellValue('U3', 'เลข JOB จากแผน')
            ->setCellValue('V3', 'เลข JOB จากน้ำมัน')
            ->setCellValue('W3', 'หมายเหตุ');
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
            $objPHPExcel->getActiveSheet()->mergeCells('Q3:R3');  
            $objPHPExcel->getActiveSheet()->mergeCells('S3:T3');   
            $objPHPExcel->getActiveSheet()->mergeCells('U3:U4');   
            $objPHPExcel->getActiveSheet()->mergeCells('V3:V4');  
            $objPHPExcel->getActiveSheet()->mergeCells('W3:W4');    
            
            $sheet->getStyle("A3:P4")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("Q3:T3")->applyFromArray(array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("R3:R4")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("T3:T4")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("Q4:T4")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("U3:W4")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
        
            $sheet->getStyle('A3:V4')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '9ACD32'))));
            $sheet->getStyle('W3:W4')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FF8C00'))));
            $objPHPExcel->getActiveSheet()->getStyle('A3:W4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            // // foreach(range('A','Z') as $columnID) { $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);} 
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(12);
            $sheet->getColumnDimension('C')->setWidth(12);
            $sheet->getColumnDimension('D')->setWidth(12);
            $sheet->getColumnDimension('E')->setWidth(12);
            $sheet->getColumnDimension('F')->setWidth(12);
            $sheet->getColumnDimension('G')->setWidth(10);
            $sheet->getColumnDimension('H')->setWidth(12);
            $sheet->getColumnDimension('I')->setWidth(9);
            $sheet->getColumnDimension('J')->setWidth(9);
            $sheet->getColumnDimension('K')->setWidth(9);
            $sheet->getColumnDimension('L')->setWidth(12);
            $sheet->getColumnDimension('M')->setWidth(20);
            $sheet->getColumnDimension('N')->setWidth(20);
            $sheet->getColumnDimension('O')->setWidth(12);
            $sheet->getColumnDimension('P')->setWidth(12);
            $sheet->getColumnDimension('Q')->setWidth(8);
            $sheet->getColumnDimension('R')->setWidth(20);
            $sheet->getColumnDimension('S')->setWidth(8);
            $sheet->getColumnDimension('T')->setWidth(20);
            $sheet->getColumnDimension('U')->setWidth(20);
            $sheet->getColumnDimension('V')->setWidth(20);
            $sheet->getColumnDimension('W')->setWidth(40);
            
            $sheet->getStyle("H5:H500")->getNumberFormat()->setFormatCode('0.00'); 
            $sheet->getStyle("L5:L500")->getNumberFormat()->setFormatCode('0.00'); 
            // $sheet->getStyle("Q10:S50")->getNumberFormat()->setFormatCode('0.00'); 
            $objPHPExcel->getActiveSheet()->getStyle('A:G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('H:J')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('K:L')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('O:P')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('U:V')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            // $objPHPExcel->getActiveSheet()->getStyle('M10:P49')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            // $objPHPExcel->getActiveSheet()->getStyle('Q10:Q49')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $stmm = "SELECT
                        DISTINCT
                        OTSN.OILDATAID OILID,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.CARDNUMBER CNB,
                        OTSN.VEHICLEREGISNUMBER VHCRG,
                        VHCIF.THAINAME VHCTN,
                        VHCTPP.VEHICLETYPE VHCTPLAN,
                        OTSN.VEHICLETYPE VHCTOIL,
                        VHCIF.ENERGY ENGY,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.JOBSTART,
                        VHCTPP.JOBEND,
                        VHCTPP.ROUNDAMOUNT,
                        VHCTPP.WORKTYPE,
                        VHCTPP.EMPLOYEECODE1 EMP1,
                        VHCTPP.EMPLOYEENAME1 EMPN1,
                        VHCTPP.EMPLOYEECODE2 EMP2,
                        VHCTPP.EMPLOYEENAME2 EMPN2,
                        OTSN.JOBNO JNOIL,
                        VHCTPP.JOBNO JNPLAN,
                        VHCTPP.RS_OILREMARK
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = 'RKL'
                    AND OTSN.REFUELINGDATE BETWEEN '$startymd' AND '$endymd'
                    ORDER BY CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) ASC";
                    // ORDER BY VHCTPP.VEHICLETYPE,VHCTPP.EMPLOYEECODE1 ASC";
            $querystmm = sqlsrv_query($conn, $stmm );
            $i = 5;
            while($objResult = sqlsrv_fetch_array($querystmm)) {  
                    $REFUEL=$objResult["REFUEL"];
                    $CONREFUEL = explode("-", $REFUEL);
                    $RSREFUEL = $CONREFUEL[2].'/'.$CONREFUEL[1].'/'.$CONREFUEL[0];
                    $OBLNB=$objResult["OBLNB"];
                    $CNB=$objResult["CNB"];
                    $VHCRG=$objResult["VHCRG"];
                    $VHCTN=$objResult["VHCTN"];
                    $VHCTPLAN=$objResult["VHCTPLAN"];
                    $VHCTOIL=$objResult["VHCTOIL"];
                    $ENGY=$objResult["ENGY"];
                    $OAM=$objResult["OAM"];
                    $MST=$objResult["MST"];
                    $MLE=$objResult["MLE"];
                    $DTE=$objResult["DTE"];
                    $OAVG=$objResult["OAVG"];
                    $OTG=$objResult["OTG"];
                    $JOBSTART=$objResult["JOBSTART"];
                    $JOBEND=$objResult["JOBEND"];
                    $ROUNDAMOUNT='';
                    // $ROUNDAMOUNT=$objResult["ROUNDAMOUNT"];
                    $WORKTYPE='';
                    // $WORKTYPE=$objResult["WORKTYPE"];
                    $EMP1=$objResult["EMP1"];
                    $EMPN1=$objResult["EMPN1"];
                    $EMP2=$objResult["EMP2"];
                    $EMPN2=$objResult["EMPN2"];
                    $JNOIL=$objResult["JNOIL"];
                    $JNPLAN=$objResult["JNPLAN"];
                    $RS_OILREMARK=$objResult["RS_OILREMARK"];
                    if(isset($RS_OILREMARK)){
                        $RSREMARK = ' มีเติม PM '.$RS_OILREMARK.' ลิตร';
                    }else{
                        $RSREMARK = '';
                    }
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
                    $SQL_CHK_OUTSIDE="SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM 
                    FROM OUTSIDE_GAS_STATION
                    LEFT JOIN VEHICLETRANSPORTPLAN ON VEHICLETRANSPORTPLANID = OSGS_PLID
                    WHERE JOBNO = '$JNPLAN'";
                    $QUERY_CHK_OUTSIDE = sqlsrv_query($conn, $SQL_CHK_OUTSIDE );
                    $RS_CHK_OUTSIDE = sqlsrv_fetch_array($QUERY_CHK_OUTSIDE, SQLSRV_FETCH_ASSOC); 
                    if(isset($RS_CHK_OUTSIDE["OSGS_AM"])){
                        if($RS_CHK_OUTSIDE["OSGS_AM"] > 0){
                            $CALOAM=$OAM+$RS_CHK_OUTSIDE["OSGS_AM"];
                            $CALOAVG=number_format($DTE/$CALOAM,2);
                            // $REMARK='มีการเติมน้ำมันจากภายนอก';
                            $REMARK='เติมใน('.$OAM.') + เติมนอก('.$RS_CHK_OUTSIDE["OSGS_AM"].') = '.$CALOAM.' ลิตร';
                        }else{
                        $CALOAM=$OAM;
                        $CALOAVG=$OAVG;
                        $REMARK='';
                        }
                    }else{
                        $CALOAM=$OAM;
                        $CALOAVG=$OAVG;
                        $REMARK='';
                    }
                    
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, ++$SHEET2);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $RSCHKREFUEL);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $CNB);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $VHCRG);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $VHCTN);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $VHCTPLAN);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, 'ดีเซล');
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $CALOAM);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $MST);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $MLE);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $DTE);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $CALOAVG);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $JOBSTART);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $JOBEND);
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $ROUNDAMOUNT);
                $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $WORKTYPE);
                $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $EMP1);
                $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $EMPN1);
                $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $EMP2);
                $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $EMPN2);
                $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $JNPLAN);
                $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $JNOIL);
                $objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $REMARK.$RSREMARK);
            $i++;
            }                    
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':G'.$i);
            $objPHPExcel->getActiveSheet()->mergeCells('I'.$i.':J'.$i);
            $objPHPExcel->getActiveSheet()->mergeCells('M'.$i.':W'.$i);
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, 'รวม');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold( true );                    
            $sheet->getStyle('H'.$i.':L'.$i)->getNumberFormat()->setFormatCode('0.00');

            $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, '=SUM(H5:H'.($i -1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, '=SUM(K5:K'.($i -1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, '=K'.$i.'/H'.$i);            

            $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A5:W'.$i)->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle('A'.$i.':W'.$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));
        // CLOSE SECTION 
        $objPHPExcel->getActiveSheet()->setTitle('RKL');

    // RKS-------------------------------------------------------------------------------------------------------------------------------------------------
 
        $objPHPExcel->createSheet();   
        $objPHPExcel->setActiveSheetIndex(2);
        // OPEN SECTION
            $detail="รายงานเติมน้ำมันแยกบริษัท (AMT)";

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
            ->setCellValue('H3', 'จำนวนลิตร')
            ->setCellValue('I3', 'ไมล์ต้น')
            ->setCellValue('J3', 'ไมล์ปลาย')
            ->setCellValue('K3', 'ระยะทาง')
            ->setCellValue('L3', 'ค่าเฉลี่ยที่ได้')
            ->setCellValue('M3', 'ต้นทาง')
            ->setCellValue('N3', 'เส้นทาง')
            ->setCellValue('O3', 'รอบวิ่งงาน')
            ->setCellValue('P3', 'ประเภทงาน')
            ->setCellValue('Q3', 'พขร.1')
            ->setCellValue('Q4', 'รหัส')
            ->setCellValue('R4', 'ชื่อ-สกุล')
            ->setCellValue('S3', 'พขร.2')
            ->setCellValue('S4', 'รหัส')
            ->setCellValue('T4', 'ชื่อ-สกุล')
            ->setCellValue('U3', 'เลข JOB จากแผน')
            ->setCellValue('V3', 'เลข JOB จากน้ำมัน')
            ->setCellValue('W3', 'หมายเหตุ');
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
            $objPHPExcel->getActiveSheet()->mergeCells('Q3:R3');  
            $objPHPExcel->getActiveSheet()->mergeCells('S3:T3');   
            $objPHPExcel->getActiveSheet()->mergeCells('U3:U4');   
            $objPHPExcel->getActiveSheet()->mergeCells('V3:V4');  
            $objPHPExcel->getActiveSheet()->mergeCells('W3:W4');    
            
            $sheet->getStyle("A3:P4")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("Q3:T3")->applyFromArray(array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("R3:R4")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("T3:T4")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("Q4:T4")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("U3:W4")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
        
            $sheet->getStyle('A3:V4')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '9ACD32'))));
            $sheet->getStyle('W3:W4')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FF8C00'))));
            $objPHPExcel->getActiveSheet()->getStyle('A3:W4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            // // foreach(range('A','Z') as $columnID) { $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);} 
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(12);
            $sheet->getColumnDimension('C')->setWidth(12);
            $sheet->getColumnDimension('D')->setWidth(12);
            $sheet->getColumnDimension('E')->setWidth(12);
            $sheet->getColumnDimension('F')->setWidth(12);
            $sheet->getColumnDimension('G')->setWidth(10);
            $sheet->getColumnDimension('H')->setWidth(12);
            $sheet->getColumnDimension('I')->setWidth(9);
            $sheet->getColumnDimension('J')->setWidth(9);
            $sheet->getColumnDimension('K')->setWidth(9);
            $sheet->getColumnDimension('L')->setWidth(12);
            $sheet->getColumnDimension('M')->setWidth(20);
            $sheet->getColumnDimension('N')->setWidth(20);
            $sheet->getColumnDimension('O')->setWidth(12);
            $sheet->getColumnDimension('P')->setWidth(12);
            $sheet->getColumnDimension('Q')->setWidth(8);
            $sheet->getColumnDimension('R')->setWidth(20);
            $sheet->getColumnDimension('S')->setWidth(8);
            $sheet->getColumnDimension('T')->setWidth(20);
            $sheet->getColumnDimension('U')->setWidth(20);
            $sheet->getColumnDimension('V')->setWidth(20);
            $sheet->getColumnDimension('W')->setWidth(40);
            
            $sheet->getStyle("H5:H500")->getNumberFormat()->setFormatCode('0.00'); 
            $sheet->getStyle("L5:L500")->getNumberFormat()->setFormatCode('0.00'); 
            // $sheet->getStyle("Q10:S50")->getNumberFormat()->setFormatCode('0.00'); 
            $objPHPExcel->getActiveSheet()->getStyle('A:G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('H:J')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('K:L')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('O:P')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('U:V')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            // $objPHPExcel->getActiveSheet()->getStyle('M10:P49')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            // $objPHPExcel->getActiveSheet()->getStyle('Q10:Q49')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $stmm = "SELECT
                        DISTINCT
                        OTSN.OILDATAID OILID,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.CARDNUMBER CNB,
                        OTSN.VEHICLEREGISNUMBER VHCRG,
                        VHCIF.THAINAME VHCTN,
                        VHCTPP.VEHICLETYPE VHCTPLAN,
                        OTSN.VEHICLETYPE VHCTOIL,
                        VHCIF.ENERGY ENGY,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        VHCTPP.JOBSTART,
                        VHCTPP.JOBEND,
                        VHCTPP.ROUNDAMOUNT,
                        VHCTPP.WORKTYPE,
                        VHCTPP.EMPLOYEECODE1 EMP1,
                        VHCTPP.EMPLOYEENAME1 EMPN1,
                        VHCTPP.EMPLOYEECODE2 EMP2,
                        VHCTPP.EMPLOYEENAME2 EMPN2,
                        OTSN.JOBNO JNOIL,
                        VHCTPP.JOBNO JNPLAN,
                        VHCTPP.RS_OILREMARK
                    FROM VEHICLETRANSPORTPLAN VHCTPP
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                    WHERE VHCTPP.COMPANYCODE = 'RKS'
                    AND OTSN.REFUELINGDATE BETWEEN '$startymd' AND '$endymd'
                    ORDER BY CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) ASC";
                    // ORDER BY VHCTPP.VEHICLETYPE,VHCTPP.EMPLOYEECODE1 ASC";
            $querystmm = sqlsrv_query($conn, $stmm );
            $i = 5;
            while($objResult = sqlsrv_fetch_array($querystmm)) {  
                    $REFUEL=$objResult["REFUEL"];
                    $CONREFUEL = explode("-", $REFUEL);
                    $RSREFUEL = $CONREFUEL[2].'/'.$CONREFUEL[1].'/'.$CONREFUEL[0];
                    $OBLNB=$objResult["OBLNB"];
                    $CNB=$objResult["CNB"];
                    $VHCRG=$objResult["VHCRG"];
                    $VHCTN=$objResult["VHCTN"];
                    $VHCTPLAN=$objResult["VHCTPLAN"];
                    $VHCTOIL=$objResult["VHCTOIL"];
                    $ENGY=$objResult["ENGY"];
                    $OAM=$objResult["OAM"];
                    $MST=$objResult["MST"];
                    $MLE=$objResult["MLE"];
                    $DTE=$objResult["DTE"];
                    $OAVG=$objResult["OAVG"];
                    $OTG=$objResult["OTG"];
                    $JOBSTART=$objResult["JOBSTART"];
                    $JOBEND=$objResult["JOBEND"];
                    $ROUNDAMOUNT='';
                    // $ROUNDAMOUNT=$objResult["ROUNDAMOUNT"];
                    $WORKTYPE='';
                    // $WORKTYPE=$objResult["WORKTYPE"];
                    $EMP1=$objResult["EMP1"];
                    $EMPN1=$objResult["EMPN1"];
                    $EMP2=$objResult["EMP2"];
                    $EMPN2=$objResult["EMPN2"];
                    $JNOIL=$objResult["JNOIL"];
                    $JNPLAN=$objResult["JNPLAN"];
                    $RS_OILREMARK=$objResult["RS_OILREMARK"];
                    if(isset($RS_OILREMARK)){
                        $RSREMARK = ' มีเติม PM '.$RS_OILREMARK.' ลิตร';
                    }else{
                        $RSREMARK = '';
                    }
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
                    $SQL_CHK_OUTSIDE="SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM 
                    FROM OUTSIDE_GAS_STATION
                    LEFT JOIN VEHICLETRANSPORTPLAN ON VEHICLETRANSPORTPLANID = OSGS_PLID
                    WHERE JOBNO = '$JNPLAN'";
                    $QUERY_CHK_OUTSIDE = sqlsrv_query($conn, $SQL_CHK_OUTSIDE );
                    $RS_CHK_OUTSIDE = sqlsrv_fetch_array($QUERY_CHK_OUTSIDE, SQLSRV_FETCH_ASSOC); 
                    if(isset($RS_CHK_OUTSIDE["OSGS_AM"])){
                        if($RS_CHK_OUTSIDE["OSGS_AM"] > 0){
                            $CALOAM=$OAM+$RS_CHK_OUTSIDE["OSGS_AM"];
                            $CALOAVG=number_format($DTE/$CALOAM,2);
                            // $REMARK='มีการเติมน้ำมันจากภายนอก';
                            $REMARK='เติมใน('.$OAM.') + เติมนอก('.$RS_CHK_OUTSIDE["OSGS_AM"].') = '.$CALOAM.' ลิตร';
                        }else{
                        $CALOAM=$OAM;
                        $CALOAVG=$OAVG;
                        $REMARK='';
                        }
                    }else{
                        $CALOAM=$OAM;
                        $CALOAVG=$OAVG;
                        $REMARK='';
                    }
                    
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, ++$SHEET3);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $RSCHKREFUEL);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $CNB);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $VHCRG);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $VHCTN);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $VHCTPLAN);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, 'ดีเซล');
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $CALOAM);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $MST);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $MLE);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $DTE);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $CALOAVG);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $JOBSTART);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $JOBEND);
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $ROUNDAMOUNT);
                $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $WORKTYPE);
                $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $EMP1);
                $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $EMPN1);
                $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $EMP2);
                $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $EMPN2);
                $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $JNPLAN);
                $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $JNOIL);
                $objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $REMARK.$RSREMARK);
            $i++;
            }                    
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':G'.$i);
            $objPHPExcel->getActiveSheet()->mergeCells('I'.$i.':J'.$i);
            $objPHPExcel->getActiveSheet()->mergeCells('M'.$i.':W'.$i);
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, 'รวม');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold( true );                    
            $sheet->getStyle('H'.$i.':L'.$i)->getNumberFormat()->setFormatCode('0.00');

            $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, '=SUM(H5:H'.($i -1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, '=SUM(K5:K'.($i -1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, '=K'.$i.'/H'.$i);            

            $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A5:W'.$i)->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle('A'.$i.':W'.$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));
        // CLOSE SECTION 
        $objPHPExcel->getActiveSheet()->setTitle('RKS');

    // CENTER-------------------------------------------------------------------------------------------------------------------------------------------------
  
        $objPHPExcel->createSheet();   
        $objPHPExcel->setActiveSheetIndex(3);
        // OPEN SECTION
            $detail="รายงานเติมน้ำมันแยกบริษัท (AMT)";

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
        
            $stmm = "SELECT
                        DISTINCT
                        OTSN.OILDATAID OILID,
                        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                        OTSN.OIL_BILLNUMBER OBLNB,
                        OTSN.CARDNUMBER CNB,
                        OTSN.VEHICLEREGISNUMBER VHCRG,
                        VHCIF.THAINAME VHCTN,
                        VHCT.VEHICLETYPEDESC VHCTPLAN,
                        OTSN.VEHICLETYPE VHCTOIL,
                        VHCIF.ENERGY ENGY,
                        OTSN.OIL_AMOUNT OAM,
                        OTSN.MILEAGESTART MST,
                        OTSN.MILEAGEEND MLE,
                        OTSN.DISTANCE DTE,
                        OTSN.OIL_AVERAGE OAVG,
                        OTSN.OIL_TARGET OTG,
                        '' JOBSTART,
                        '' JOBEND,
                        '' ROUNDAMOUNT,
                        '' WORKTYPE,
                        '' EMP1,
                        '' EMPN1,
                        '' EMP2,
                        '' EMPN2,
                        OTSN.JOBNO JNOIL,
                        '' JNPLAN
                    FROM VEHICLEINFO_CARPOOL VHCIF 
                    LEFT JOIN VEHICLETYPE VHCT ON VHCT.VEHICLETYPECODE = VHCIF.VEHICLETYPECODE
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    WHERE OTSN.REFUELINGDATE BETWEEN '$startymd' AND '$endymd'
                    ORDER BY CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) ASC";
                    // ORDER BY CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) ASC";
            $querystmm = sqlsrv_query($conn, $stmm );
            $i = 5;
            while($objResult = sqlsrv_fetch_array($querystmm)) {  
                    $REFUEL=$objResult["REFUEL"];
                    $CONREFUEL = explode("-", $REFUEL);
                    $RSREFUEL = $CONREFUEL[2].'/'.$CONREFUEL[1].'/'.$CONREFUEL[0];
                    $OBLNB=$objResult["OBLNB"];
                    $CNB=$objResult["CNB"];
                    $VHCRG=$objResult["VHCRG"];
                    $VHCTN=$objResult["VHCTN"];
                    $VHCTPLAN=$objResult["VHCTPLAN"];
                    $VHCTOIL=$objResult["VHCTOIL"];
                    $ENGY=$objResult["ENGY"];
                    $OAM=$objResult["OAM"];
                    $MST=$objResult["MST"];
                    $MLE=$objResult["MLE"];
                    $DTE=$objResult["DTE"];
                    $OAVG=$objResult["OAVG"];
                    $OTG=$objResult["OTG"];
                    $JOBSTART=$objResult["JOBSTART"];
                    $JOBEND=$objResult["JOBEND"];
                    $ROUNDAMOUNT=$objResult["ROUNDAMOUNT"];
                    $WORKTYPE=$objResult["WORKTYPE"];
                    $EMP1=$objResult["EMP1"];
                    $EMPN1=$objResult["EMPN1"];
                    $EMP2=$objResult["EMP2"];
                    $EMPN2=$objResult["EMPN2"];
                    $JNOIL=$objResult["JNOIL"];
                    $JNPLAN=$objResult["JNPLAN"];
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
                // $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $JOBSTART);
                // $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $JOBEND);
                // $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $ROUNDAMOUNT);
                // $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $EMP1);
                // $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $EMPN1);
                // $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $EMP2);
                // $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $EMPN2);
                // $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $JNPLAN);
                // $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $JNOIL);
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

    // END-------------------------------------------------------------------------------------------------------------------------------------------------
            // $objPHPExcel->setActiveSheetIndex(0);
            
    $RENAME= "รายงานเติมน้ำมันแยกบริษัท (AMT) $selectmonth $start_yth";
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