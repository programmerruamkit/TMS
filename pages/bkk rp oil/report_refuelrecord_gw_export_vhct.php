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
    
    // $date1 = $_POST["txt_datestartoilvhct"];
    // $start = explode("/", $date1);
    // $startd = $start[0];
    // $startif = $start[1];        
    //     if($startif=='01'){
    //         $selectmonth = "มกราคม";
    //     }else if($startif=='02'){
    //         $selectmonth = "กุมภาพันธ์";
    //     }else if($startif=='03'){
    //         $selectmonth = "มีนาคม";
    //     }else if($startif=='04'){
    //         $selectmonth = "เมษายน";
    //     }else if($startif=='05'){
    //         $selectmonth = "พฤษภาคม";
    //     }else if($startif=='06'){
    //         $selectmonth = "มิถุนายน";
    //     }else if($startif=='07'){
    //         $selectmonth = "กรกฎาคม";
    //     }else if($startif=='08'){
    //         $selectmonth = "สิงหาคม";
    //     }else if($startif=='09'){
    //         $selectmonth = "กันยายน";
    //     }else if($startif=='10'){
    //         $selectmonth = "ตุลาคม";
    //     }else if($startif=='11'){
    //         $selectmonth = "พฤศจิกายน";
    //     }else if($startif=='12'){
    //         $selectmonth = "ธันวาคม";
    //     }
    // $start_yen = $start[2];
    // $start_yth = $start[2]+543;
    // $start_ymd = $start[2].'-'.$start[1].'-'.$start[0];
    
    // $date2 = $_POST["txt_dateendoilvhct"];
    // $end = explode("/", $date2);
    // $endd = $end[0];
    // $endif = $end[1];
    //     if($endif=='01'){
    //         $selectmonth = "มกราคม";
    //     }else if($endif=='02'){
    //         $selectmonth = "กุมภาพันธ์";
    //     }else if($endif=='03'){
    //         $selectmonth = "มีนาคม";
    //     }else if($endif=='04'){
    //         $selectmonth = "เมษายน";
    //     }else if($endif=='05'){
    //         $selectmonth = "พฤษภาคม";
    //     }else if($endif=='06'){
    //         $selectmonth = "มิถุนายน";
    //     }else if($endif=='07'){
    //         $selectmonth = "กรกฎาคม";
    //     }else if($endif=='08'){
    //         $selectmonth = "สิงหาคม";
    //     }else if($endif=='09'){
    //         $selectmonth = "กันยายน";
    //     }else if($endif=='10'){
    //         $selectmonth = "ตุลาคม";
    //     }else if($endif=='11'){
    //         $selectmonth = "พฤศจิกายน";
    //     }else if($endif=='12'){
    //         $selectmonth = "ธันวาคม";
    //     }
    // $end_yen = $end[2];    
    // $end_yth = $end[2]+543;
    // $end_ymd = $end[2].'-'.$end[1].'-'.$end[0];

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
                    WHERE  VHCTPP.COMPANYCODE IN ('RCC','RATC')
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
                    $ROUNDAMOUNT=$objResult["ROUNDAMOUNT"];
                    $WORKTYPE=$objResult["WORKTYPE"];
                    $EMP1=$objResult["EMP1"];
                    $EMPN1=$objResult["EMPN1"];
                    $EMP2=$objResult["EMP2"];
                    $EMPN2=$objResult["EMPN2"];
                    $JNOIL=$objResult["JNOIL"];
                    $JNPLAN=$objResult["JNPLAN"];
                    $RS_OILREMARK=$objResult["RS_OILREMARK"];
                    if(isset($RS_OILREMARK)){
                        $RSREMARK = ' '.$RS_OILREMARK;
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
            ->setCellValue('H3', 'จำนวนลิตร')
            ->setCellValue('I3', 'ไมล์ต้น')
            ->setCellValue('J3', 'ไมล์ปลาย')
            ->setCellValue('K3', 'ระยะทาง')
            ->setCellValue('L3', 'ค่าเฉลี่ยที่ได้')
            ->setCellValue('M3', 'ต้นทาง')
            ->setCellValue('N3', 'เส้นทาง')
            ->setCellValue('O3', 'รอบวิ่งงาน')

            ->setCellValue('P3', 'พขร.1')
            ->setCellValue('P4', 'รหัส')
            ->setCellValue('Q4', 'ชื่อ-สกุล')
            ->setCellValue('R3', 'พขร.2')
            ->setCellValue('R4', 'รหัส')
            ->setCellValue('S4', 'ชื่อ-สกุล')
            ->setCellValue('T3', 'เลข JOB จากแผน')
            ->setCellValue('U3', 'เลข JOB จากน้ำมัน')
            ->setCellValue('V3', 'หมายเหตุ');
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
            $objPHPExcel->getActiveSheet()->mergeCells('P3:Q3');  
            $objPHPExcel->getActiveSheet()->mergeCells('R3:S3');   
            $objPHPExcel->getActiveSheet()->mergeCells('T3:T4');   
            $objPHPExcel->getActiveSheet()->mergeCells('U3:U4');  
            $objPHPExcel->getActiveSheet()->mergeCells('V3:V4');  
            
            $sheet->getStyle("A3:O4")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("P3:S3")->applyFromArray(array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("Q3:Q4")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("S3:S4")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("P4:R4")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle("S3:V4")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
        
            $sheet->getStyle('A3:U4')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '9ACD32'))));
            $sheet->getStyle('V3:V4')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FF8C00'))));
            $objPHPExcel->getActiveSheet()->getStyle('A3:V4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
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
            $sheet->getColumnDimension('P')->setWidth(8);
            $sheet->getColumnDimension('Q')->setWidth(20);
            $sheet->getColumnDimension('R')->setWidth(8);
            $sheet->getColumnDimension('S')->setWidth(20);
            $sheet->getColumnDimension('T')->setWidth(20);
            $sheet->getColumnDimension('U')->setWidth(20);
            $sheet->getColumnDimension('V')->setWidth(40);
            
            $sheet->getStyle("H5:H500")->getNumberFormat()->setFormatCode('0.00'); 
            $sheet->getStyle("L5:L500")->getNumberFormat()->setFormatCode('0.00'); 
            // $sheet->getStyle("Q10:S50")->getNumberFormat()->setFormatCode('0.00'); 
            $objPHPExcel->getActiveSheet()->getStyle('A:G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('H:J')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('K:L')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('O')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('T:U')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
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
                    WHERE VHCTPP.COMPANYCODE = 'RRC'
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
                    $ROUNDAMOUNT=$objResult["ROUNDAMOUNT"];
                    $WORKTYPE=$objResult["WORKTYPE"];
                    $EMP1=$objResult["EMP1"];
                    $EMPN1=$objResult["EMPN1"];
                    $EMP2=$objResult["EMP2"];
                    $EMPN2=$objResult["EMPN2"];
                    $JNOIL=$objResult["JNOIL"];
                    $JNPLAN=$objResult["JNPLAN"];
                    $RS_OILREMARK=$objResult["RS_OILREMARK"];
                    if(isset($RS_OILREMARK)){
                        $RSREMARK = ' '.$RS_OILREMARK;
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
                $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $EMP1);
                $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $EMPN1);
                $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $EMP2);
                $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $EMPN2);
                $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $JNPLAN);
                $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $JNOIL);
                $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $REMARK.$RSREMARK);
            $i++;
            }                    
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':G'.$i);
            $objPHPExcel->getActiveSheet()->mergeCells('I'.$i.':J'.$i);
            $objPHPExcel->getActiveSheet()->mergeCells('M'.$i.':V'.$i);
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, 'รวม');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold( true );                    
            $sheet->getStyle('H'.$i.':L'.$i)->getNumberFormat()->setFormatCode('0.00');

            $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, '=SUM(H5:H'.($i -1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, '=SUM(K5:K'.($i -1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, '=K'.$i.'/H'.$i);         

            $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A5:V'.$i)->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
            $sheet->getStyle('A'.$i.':V'.$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99'))));
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
                    $RS_OILREMARK=$objResult["RS_OILREMARK"];
                    if(isset($RS_OILREMARK)){
                        $RSREMARK = ' '.$RS_OILREMARK;
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
            
    $RENAME= "รายงานเติมน้ำมันแยกประเภท (GW) $selectmonth $start_yth";
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=$RENAME.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');

}else if($PDFVHCT != "") {  
    $mpdf = new mPDF('', 'A3-L', '', '', 15, 15,40); 

    $style = '<style>body{font-family: "angsana";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย}</style>';
    $defualt_header = '<table width="100%">
                            <tbody>
                                <tr>
                                    <td colspan="8" style="width:30%;border:0px solid #000;font-size:30px;text-align:center;">รายงานเติมน้ำมันแยกประเภท (GW) '.$selectmonth.' '.$start_yth.'</td>
                                </tr>
                            </tbody>
                        </table>';
    $table = '<table style="border-collapse: collapse;font-size:13px" width="100%">
                <thead>
                    <tr>
                        <td rowspan="2" style="background-color: #bfbfbf;width:4%;border:1px solid #000;padding:3px;text-align:center">ลำดับ</td>
                        <td rowspan="2" style="background-color: #bfbfbf;width:6%;border:1px solid #000;padding:3px;text-align:center">วันที่</div></td>
                        <td rowspan="2" style="background-color: #bfbfbf;width:5%;border:1px solid #000;padding:3px;text-align:center">เลขบัตร</div></td>
                        <td rowspan="2" style="background-color: #bfbfbf;width:5%;border:1px solid #000;padding:3px;text-align:center">ทะเบียนรถ</div></td>
                        <td rowspan="2" style="background-color: #bfbfbf;width:5%;border:1px solid #000;padding:3px;text-align:center">ประเภทรถ</div></td>
                        <td rowspan="2" style="background-color: #bfbfbf;width:5%;border:1px solid #000;padding:3px;text-align:center">น้ำมัน</div></td>
                        <td rowspan="2" style="background-color: #bfbfbf;width:6%;border:1px solid #000;padding:3px;text-align:center">จำนวนลิตร</div></td>
                        <td rowspan="2" style="background-color: #bfbfbf;width:5%;border:1px solid #000;padding:3px;text-align:center">ไมล์ต้น</div></td>
                        <td rowspan="2" style="background-color: #bfbfbf;width:5%;border:1px solid #000;padding:3px;text-align:center">ไมล์ปลาย</div></td>
                        <td rowspan="2" style="background-color: #bfbfbf;width:5%;border:1px solid #000;padding:3px;text-align:center">ระยะทาง</div></td>
                        <td rowspan="2" style="background-color: #bfbfbf;width:5%;border:1px solid #000;padding:3px;text-align:center">ค่าเฉลี่ยที่ได้</div></td>
                        <td rowspan="2" style="background-color: #bfbfbf;width:10%;border:1px solid #000;padding:3px;text-align:center">เส้นทาง</div></td>
                        <td rowspan="1" colspan="2" style="background-color: #bfbfbf;width:15%;border:1px solid #000;padding:3px;text-align:center">พขร.1</div></td>
                        <td rowspan="1" colspan="2" style="background-color: #bfbfbf;width:15%;border:1px solid #000;padding:3px;text-align:center">พขร.2</div></td>
                        <td rowspan="2" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">เลข JOB จากแผน</div></td>
                        <td rowspan="2" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">เลข JOB จากน้ำมัน</div></td>
                    </tr>
                    <tr>
                    <td colspan="1" style="background-color: #bfbfbf;width:5%;border:1px solid #000;padding:3px;text-align:center">รหัส</div></td>
                    <td colspan="1" style="background-color: #bfbfbf;width:10%;border:1px solid #000;padding:3px;text-align:center">ชื่อ-สกุล</div></td>
                    <td colspan="1" style="background-color: #bfbfbf;width:5%;border:1px solid #000;padding:3px;text-align:center">รหัส</div></td>
                    <td colspan="1" style="background-color: #bfbfbf;width:10%;border:1px solid #000;padding:3px;text-align:center">ชื่อ-สกุล</div></td>
                    </tr>
                </thead><tbody>';          
    $table_footer = '<table style="width: 100%;">
                        <tbody>
                            <tr>
                                <td colspan="4">&nbsp;&nbsp;&nbsp; แก้ไขครั้งที่:01&nbsp;&nbsp;&nbsp;มีผลบังคับใช้:20 ก.พ. 2566</td>
                            </tr>
                        </tbody>
                    </table>';
            
    $work_sheet=0;

    $CARTYPE4L = '4L';
    $CARTYPE8LNM = '8LNM';
    $CARTYPE8LSH = '8LSH';
    $CARTYPE8LNMSH = '8LNMSH';
    $CARTYPE10WDUMP = '10WDUMP';
    $CARTYPE10WVAN = '10WVAN';
    $CARTYPE22WDUMP = '22WDUMP';
    $CARTYPESEMITRAILER = 'SEMITRAILER';

    $mpdf->WriteHTML($style);
    $mpdf->SetHTMLHeader($defualt_header, 'O', true);
    $mpdf->SetHTMLFooter($table_footer);
    // $mpdf->WriteHTML($table_footer1);

        if($CARTYPE4L=="4L"){               
            $sql_4l = "SELECT
                    DISTINCT
                    OTSN.OILDATAID OILID,
                    CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                    OTSN.OIL_BILLNUMBER OBLNB,
                    OTSN.CARDNUMBER CNB,
                    OTSN.VEHICLEREGISNUMBER VHCRG,
                    VHCTPP.VEHICLETYPE VHCTPLAN,
                    OTSN.VEHICLETYPE VHCTOIL,
                    VHCIF.ENERGY ENGY,
                    OTSN.OIL_AMOUNT OAM,
                    OTSN.MILEAGESTART MST,
                    OTSN.MILEAGEEND MLE,
                    OTSN.DISTANCE DTE,
                    OTSN.OIL_AVERAGE OAVG,
                    OTSN.OIL_TARGET OTG,
                    VHCTPP.JOBEND,
                    VHCTPP.WORKTYPE,
                    VHCTPP.EMPLOYEECODE1 EMP1,
                    VHCTPP.EMPLOYEENAME1 EMPN1,
                    VHCTPP.EMPLOYEECODE2 EMP2,
                    VHCTPP.EMPLOYEENAME2 EMPN2,
                    OTSN.JOBNO JNOIL,
                    VHCTPP.JOBNO JNPLAN
                FROM TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN
                LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                WHERE OTSN.JOBNO IS NOT NULL
                AND VHCTPP.COMPANYCODE != 'RKR' AND VHCTPP.COMPANYCODE != 'RKS' AND VHCTPP.COMPANYCODE != 'RKL'
                AND OTSN.JOBNO != ''
                AND CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) BETWEEN '$start_ymd' AND '$end_ymd'
                AND VHCTPP.VEHICLETYPE = '4L'
                -- AND VHCTPP.WORKTYPE = ''
                ORDER BY OTSN.OILDATAID ASC";
            $query_4l = sqlsrv_query($conn, $sql_4l );
            $result_4l = sqlsrv_fetch_array($query_4l, SQLSRV_FETCH_ASSOC);
                $OID_4l=$result_4l["OILID"];                  
            if($OID_4l!=""){   
                while($result_4l = sqlsrv_fetch_array($query_4l)) {
                    $REFUEL_4L=$result_4l["REFUEL"];
                    $CONREFUEL_4L=explode("-", $REFUEL_4L);
                    $RSREFUEL_4L=$CONREFUEL_4L[2].'/'.$CONREFUEL_4L[1].'/'.$CONREFUEL_4L[0];
                    $OBLNB_4L=$result_4l["OBLNB"];
                    $CNB_4L=$result_4l["CNB"];
                    $VHCRG_4L=$result_4l["VHCRG"];
                    $VHCTPLAN_4L=$result_4l["VHCTPLAN"];
                    $VHCTOIL_4L=$result_4l["VHCTOIL"];
                    $ENGY_4L=$result_4l["ENGY"];
                    $OAM_4L=$result_4l["OAM"];
                    $MST_4L=$result_4l["MST"];
                    $MLE_4L=$result_4l["MLE"];
                    $DTE_4L=$result_4l["DTE"];
                    $OAVG_4L=$result_4l["OAVG"];
                    $OTG_4L=$result_4l["OTG"];
                    $JOBEND_4L=$result_4l["JOBEND"];
                    $WORKTYPE_4L=$result_4l["WORKTYPE"];
                    $EMP1_4L=$result_4l["EMP1"];
                    $EMPN1_4L=$result_4l["EMPN1"];
                    $EMP2_4L=$result_4l["EMP2"];
                    $EMPN2_4L=$result_4l["EMPN2"];
                    $JNOIL_4L=$result_4l["JNOIL"];
                    $JNPLAN_4L=$result_4l["JNPLAN"];
                    
                    $RSOAVG_4l=$DTE_4L/$OAM_4L;
                     
                    $ROAM_4l=$OAM_4L;
                        $QROAM_4l=$QROAM_4l+$ROAM_4l;    
                    $RDTE_4l=$RSDTE_4l;    
                        $QRDTE_4l=$QRDTE_4l+$DTE_4L;       
                    // $ROTG_4l=$OTG_4l; 
                    // $QCALOAM_4l=(($RDTE_4l/$ROTG_4l)-$ROAM_4l);     
                    //     $QRCALOAM_4l=$QRCALOAM_4l+$QCALOAM_4l; 
                    // $RC3_4l=$RSPRICE_4l;    
                    //     $QRC3_4l=$QRC3_4l+$RC3_4l;   
                    $arr_4l[] = $RSOAVG_4l; 

                $tbody_4l .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_4l.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSREFUEL_4L.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CNB_4L.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRG_4L.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCTPLAN_4L.'</td>
                                <td align="center" style="border:1px solid #000;">ดีเซล</td>
                                <td align="center" style="border:1px solid #000;">'.$OAM_4L.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_4L.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MLE_4L.'</td>
                                <td align="right" style="border:1px solid #000;">'.$DTE_4L.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OAVG_4L.'</td>
                                <td align="left" style="border:1px solid #000;">'.$JOBEND_4L.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMP1_4L.'</td>
                                <td align="left" style="border:1px solid #000;">'.$EMPN1_4L.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMP2_4L.'</td>
                                <td align="left" style="border:1px solid #000;">'.$EMPN2_4L.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JNPLAN_4L.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JNOIL_4L.'</td>
                            </tr>';                   
                        $number_4l++;
                }                            
                        $TOTALOAM_4l=$QROAM_4l;  
                        $TOTALDTE_4l=$QRDTE_4l;
                        // $TOTALCALOAM_4l=$QRCALOAM_4l;  
                        // $TOTALC3_4l=$QRC3_4l; 
                        function Average_4l($arr_4l) {
                            $array_size_4l = count($arr_4l);                
                            $total_4l = 0;
                            for ($number_4l = 0; $number_4l < $array_size_4l; $number_4l++) {
                                $total_4l += $arr_4l[$number_4l];
                            }                
                            $AVERAGE_4l = (float)($total_4l / $array_size_4l);
                            return $AVERAGE_4l;
                        }        
                $tfoot_4l = '</tbody><tfoot>
                        <tr>
                            <td colspan="6" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;">'.$TOTALOAM_4l.'</td>
                            <td colspan="2" style="border:1px solid #000;"></td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;">'.$QRDTE_4l.'</td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_4l($arr_4l), 2).'</td>
                            <td colspan="7" style="border:1px solid #000;"></td>
                        </tr></tfoot>';
                    
            }else{
                $tbody_4l .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
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
                $tfoot_4l = '</tbody><tfoot>
                        <tr>
                            <td colspan="6" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                            <td colspan="2" style="border:1px solid #000;"></td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                            <td colspan="7" style="border:1px solid #000;"></td>
                        </tr></tfoot>';
            }
            $table_end_4l = '</table>';    
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_4l);
            $mpdf->WriteHTML($tfoot_4l);
            $mpdf->WriteHTML($table_end_4l);  
            $mpdf->AddPage();  
        }

        if($CARTYPE8LNM=="8LNM"){               
            $sql_8lnm = "SELECT
                    DISTINCT
                    OTSN.OILDATAID OILID,
                    CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                    OTSN.OIL_BILLNUMBER OBLNB,
                    OTSN.CARDNUMBER CNB,
                    OTSN.VEHICLEREGISNUMBER VHCRG,
                    VHCTPP.VEHICLETYPE VHCTPLAN,
                    OTSN.VEHICLETYPE VHCTOIL,
                    VHCIF.ENERGY ENGY,
                    OTSN.OIL_AMOUNT OAM,
                    OTSN.MILEAGESTART MST,
                    OTSN.MILEAGEEND MLE,
                    OTSN.DISTANCE DTE,
                    OTSN.OIL_AVERAGE OAVG,
                    OTSN.OIL_TARGET OTG,
                    VHCTPP.JOBEND,
                    VHCTPP.WORKTYPE,
                    VHCTPP.EMPLOYEECODE1 EMP1,
                    VHCTPP.EMPLOYEENAME1 EMPN1,
                    VHCTPP.EMPLOYEECODE2 EMP2,
                    VHCTPP.EMPLOYEENAME2 EMPN2,
                    OTSN.JOBNO JNOIL,
                    VHCTPP.JOBNO JNPLAN
                FROM TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN
                LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                WHERE OTSN.JOBNO IS NOT NULL
                AND VHCTPP.COMPANYCODE != 'RKR' AND VHCTPP.COMPANYCODE != 'RKS' AND VHCTPP.COMPANYCODE != 'RKL'
                AND OTSN.JOBNO != ''
                AND CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) BETWEEN '$start_ymd' AND '$end_ymd'
                AND VHCTPP.VEHICLETYPE = '8L'
                AND VHCTPP.WORKTYPE = 'nm'
                ORDER BY OTSN.OILDATAID ASC";
            $query_8lnm = sqlsrv_query($conn, $sql_8lnm );
            $result_8lnm = sqlsrv_fetch_array($query_8lnm, SQLSRV_FETCH_ASSOC);
                $OID_8lnm=$result_8lnm["OILID"];                  
            if($OID_8lnm!=""){   
                while($result_8lnm = sqlsrv_fetch_array($query_8lnm)) {
                    $REFUEL_8LNM=$result_8lnm["REFUEL"];
                    $CONREFUEL_8LNM=explode("-", $REFUEL_8LNM);
                    $RSREFUEL_8LNM=$CONREFUEL_8LNM[2].'/'.$CONREFUEL_8LNM[1].'/'.$CONREFUEL_8LNM[0];
                    $OBLNB_8LNM=$result_8lnm["OBLNB"];
                    $CNB_8LNM=$result_8lnm["CNB"];
                    $VHCRG_8LNM=$result_8lnm["VHCRG"];
                    $VHCTPLAN_8LNM=$result_8lnm["VHCTPLAN"];
                    $VHCTOIL_8LNM=$result_8lnm["VHCTOIL"];
                    $ENGY_8LNM=$result_8lnm["ENGY"];
                    $OAM_8LNM=$result_8lnm["OAM"];
                    $MST_8LNM=$result_8lnm["MST"];
                    $MLE_8LNM=$result_8lnm["MLE"];
                    $DTE_8LNM=$result_8lnm["DTE"];
                    $OAVG_8LNM=$result_8lnm["OAVG"];
                    $OTG_8LNM=$result_8lnm["OTG"];
                    $JOBEND_8LNM=$result_8lnm["JOBEND"];
                    $WORKTYPE_8LNM=$result_8lnm["WORKTYPE"];
                    $EMP1_8LNM=$result_8lnm["EMP1"];
                    $EMPN1_8LNM=$result_8lnm["EMPN1"];
                    $EMP2_8LNM=$result_8lnm["EMP2"];
                    $EMPN2_8LNM=$result_8lnm["EMPN2"];
                    $JNOIL_8LNM=$result_8lnm["JNOIL"];
                    $JNPLAN_8LNM=$result_8lnm["JNPLAN"];
                    
                    $RSOAVG_8lnm=$DTE_8LNM/$OAM_8LNM;
                     
                    $ROAM_8lnm=$OAM_8LNM;
                        $QROAM_8lnm=$QROAM_8lnm+$ROAM_8lnm;    
                    $RDTE_8lnm=$RSDTE_8lnm;    
                        $QRDTE_8lnm=$QRDTE_8lnm+$DTE_8LNM;       
                    // $ROTG_8lnm=$OTG_8lnm; 
                    // $QCALOAM_8lnm=(($RDTE_8lnm/$ROTG_8lnm)-$ROAM_8lnm);     
                    //     $QRCALOAM_8lnm=$QRCALOAM_8lnm+$QCALOAM_8lnm; 
                    // $RC3_8lnm=$RSPRICE_8lnm;    
                    //     $QRC3_8lnm=$QRC3_8lnm+$RC3_8lnm;   
                    $arr_8lnm[] = $RSOAVG_8lnm; 

                $tbody_8lnm .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_8lnm.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSREFUEL_8LNM.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CNB_8LNM.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRG_8LNM.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCTPLAN_8LNM.'-'.$WORKTYPE_8LNM.'</td>
                                <td align="center" style="border:1px solid #000;">ดีเซล</td>
                                <td align="center" style="border:1px solid #000;">'.$OAM_8LNM.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_8LNM.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MLE_8LNM.'</td>
                                <td align="right" style="border:1px solid #000;">'.$DTE_8LNM.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OAVG_8LNM.'</td>
                                <td align="left" style="border:1px solid #000;">'.$JOBEND_8LNM.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMP1_8LNM.'</td>
                                <td align="left" style="border:1px solid #000;">'.$EMPN1_8LNM.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMP2_8LNM.'</td>
                                <td align="left" style="border:1px solid #000;">'.$EMPN2_8LNM.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JNPLAN_8LNM.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JNOIL_8LNM.'</td>
                            </tr>';                   
                        $number_8lnm++;
                }                            
                        $TOTALOAM_8lnm=$QROAM_8lnm;  
                        $TOTALDTE_8lnm=$QRDTE_8lnm;
                        // $TOTALCALOAM_8lnm=$QRCALOAM_8lnm;  
                        // $TOTALC3_8lnm=$QRC3_8lnm; 
                        function Average_8lnm($arr_8lnm) {
                            $array_size_8lnm = count($arr_8lnm);                
                            $total_8lnm = 0;
                            for ($number_8lnm = 0; $number_8lnm < $array_size_8lnm; $number_8lnm++) {
                                $total_8lnm += $arr_8lnm[$number_8lnm];
                            }                
                            $AVERAGE_8lnm = (float)($total_8lnm / $array_size_8lnm);
                            return $AVERAGE_8lnm;
                        }        
                $tfoot_8lnm = '</tbody><tfoot>
                        <tr>
                            <td colspan="6" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;">'.$TOTALOAM_8lnm.'</td>
                            <td colspan="2" style="border:1px solid #000;"></td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;">'.$QRDTE_8lnm.'</td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_8lnm($arr_8lnm), 2).'</td>
                            <td colspan="7" style="border:1px solid #000;"></td>
                        </tr></tfoot>';
                    
            }else{
                $tbody_8lnm .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
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
                $tfoot_8lnm = '</tbody><tfoot>
                        <tr>
                            <td colspan="6" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                            <td colspan="2" style="border:1px solid #000;"></td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                            <td colspan="7" style="border:1px solid #000;"></td>
                        </tr></tfoot>';
            }
            $table_end_8lnm = '</table>';    
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_8lnm);
            $mpdf->WriteHTML($tfoot_8lnm);
            $mpdf->WriteHTML($table_end_8lnm);  
            $mpdf->AddPage();  
        }

        if($CARTYPE8LSH=="8LSH"){               
            $sql_8lsh = "SELECT
                    DISTINCT
                    OTSN.OILDATAID OILID,
                    CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                    OTSN.OIL_BILLNUMBER OBLNB,
                    OTSN.CARDNUMBER CNB,
                    OTSN.VEHICLEREGISNUMBER VHCRG,
                    VHCTPP.VEHICLETYPE VHCTPLAN,
                    OTSN.VEHICLETYPE VHCTOIL,
                    VHCIF.ENERGY ENGY,
                    OTSN.OIL_AMOUNT OAM,
                    OTSN.MILEAGESTART MST,
                    OTSN.MILEAGEEND MLE,
                    OTSN.DISTANCE DTE,
                    OTSN.OIL_AVERAGE OAVG,
                    OTSN.OIL_TARGET OTG,
                    VHCTPP.JOBEND,
                    VHCTPP.WORKTYPE,
                    VHCTPP.EMPLOYEECODE1 EMP1,
                    VHCTPP.EMPLOYEENAME1 EMPN1,
                    VHCTPP.EMPLOYEECODE2 EMP2,
                    VHCTPP.EMPLOYEENAME2 EMPN2,
                    OTSN.JOBNO JNOIL,
                    VHCTPP.JOBNO JNPLAN
                FROM TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN
                LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                WHERE OTSN.JOBNO IS NOT NULL
                AND VHCTPP.COMPANYCODE != 'RKR' AND VHCTPP.COMPANYCODE != 'RKS' AND VHCTPP.COMPANYCODE != 'RKL'
                AND OTSN.JOBNO != ''
                AND CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) BETWEEN '$start_ymd' AND '$end_ymd'
                AND VHCTPP.VEHICLETYPE = '8L'
                AND VHCTPP.WORKTYPE = 'sh'
                ORDER BY OTSN.OILDATAID ASC";
            $query_8lsh = sqlsrv_query($conn, $sql_8lsh );
            $result_8lsh = sqlsrv_fetch_array($query_8lsh, SQLSRV_FETCH_ASSOC);
                $OID_8lsh=$result_8lsh["OILID"];                  
            if($OID_8lsh!=""){   
                while($result_8lsh = sqlsrv_fetch_array($query_8lsh)) {
                    $REFUEL_8LSH=$result_8lsh["REFUEL"];
                    $CONREFUEL_8LSH=explode("-", $REFUEL_8LSH);
                    $RSREFUEL_8LSH=$CONREFUEL_8LSH[2].'/'.$CONREFUEL_8LSH[1].'/'.$CONREFUEL_8LSH[0];
                    $OBLNB_8LSH=$result_8lsh["OBLNB"];
                    $CNB_8LSH=$result_8lsh["CNB"];
                    $VHCRG_8LSH=$result_8lsh["VHCRG"];
                    $VHCTPLAN_8LSH=$result_8lsh["VHCTPLAN"];
                    $VHCTOIL_8LSH=$result_8lsh["VHCTOIL"];
                    $ENGY_8LSH=$result_8lsh["ENGY"];
                    $OAM_8LSH=$result_8lsh["OAM"];
                    $MST_8LSH=$result_8lsh["MST"];
                    $MLE_8LSH=$result_8lsh["MLE"];
                    $DTE_8LSH=$result_8lsh["DTE"];
                    $OAVG_8LSH=$result_8lsh["OAVG"];
                    $OTG_8LSH=$result_8lsh["OTG"];
                    $JOBEND_8LSH=$result_8lsh["JOBEND"];
                    $WORKTYPE_8LSH=$result_8lsh["WORKTYPE"];
                    $EMP1_8LSH=$result_8lsh["EMP1"];
                    $EMPN1_8LSH=$result_8lsh["EMPN1"];
                    $EMP2_8LSH=$result_8lsh["EMP2"];
                    $EMPN2_8LSH=$result_8lsh["EMPN2"];
                    $JNOIL_8LSH=$result_8lsh["JNOIL"];
                    $JNPLAN_8LSH=$result_8lsh["JNPLAN"];
                    
                    $RSOAVG_8lsh=$DTE_8LSH/$OAM_8LSH;
                     
                    $ROAM_8lsh=$OAM_8LSH;
                        $QROAM_8lsh=$QROAM_8lsh+$ROAM_8lsh;    
                    $RDTE_8lsh=$RSDTE_8lsh;    
                        $QRDTE_8lsh=$QRDTE_8lsh+$DTE_8LSH;       
                    // $ROTG_8lsh=$OTG_8lsh; 
                    // $QCALOAM_8lsh=(($RDTE_8lsh/$ROTG_8lsh)-$ROAM_8lsh);     
                    //     $QRCALOAM_8lsh=$QRCALOAM_8lsh+$QCALOAM_8lsh; 
                    // $RC3_8lsh=$RSPRICE_8lsh;    
                    //     $QRC3_8lsh=$QRC3_8lsh+$RC3_8lsh;   
                    $arr_8lsh[] = $RSOAVG_8lsh; 

                $tbody_8lsh .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_8lsh.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSREFUEL_8LSH.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CNB_8LSH.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRG_8LSH.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCTPLAN_8LSH.'-'.$WORKTYPE_8LSH.'</td>
                                <td align="center" style="border:1px solid #000;">ดีเซล</td>
                                <td align="center" style="border:1px solid #000;">'.$OAM_8LSH.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_8LSH.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MLE_8LSH.'</td>
                                <td align="right" style="border:1px solid #000;">'.$DTE_8LSH.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OAVG_8LSH.'</td>
                                <td align="left" style="border:1px solid #000;">'.$JOBEND_8LSH.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMP1_8LSH.'</td>
                                <td align="left" style="border:1px solid #000;">'.$EMPN1_8LSH.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMP2_8LSH.'</td>
                                <td align="left" style="border:1px solid #000;">'.$EMPN2_8LSH.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JNPLAN_8LSH.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JNOIL_8LSH.'</td>
                            </tr>';                   
                        $number_8lsh++;
                }                            
                        $TOTALOAM_8lsh=$QROAM_8lsh;  
                        $TOTALDTE_8lsh=$QRDTE_8lsh;
                        // $TOTALCALOAM_8lsh=$QRCALOAM_8lsh;  
                        // $TOTALC3_8lsh=$QRC3_8lsh; 
                        function Average_8lsh($arr_8lsh) {
                            $array_size_8lsh = count($arr_8lsh);                
                            $total_8lsh = 0;
                            for ($number_8lsh = 0; $number_8lsh < $array_size_8lsh; $number_8lsh++) {
                                $total_8lsh += $arr_8lsh[$number_8lsh];
                            }                
                            $AVERAGE_8lsh = (float)($total_8lsh / $array_size_8lsh);
                            return $AVERAGE_8lsh;
                        }        
                $tfoot_8lsh = '</tbody><tfoot>
                        <tr>
                            <td colspan="6" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;">'.$TOTALOAM_8lsh.'</td>
                            <td colspan="2" style="border:1px solid #000;"></td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;">'.$QRDTE_8lsh.'</td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_8lsh($arr_8lsh), 2).'</td>
                            <td colspan="7" style="border:1px solid #000;"></td>
                        </tr></tfoot>';
                    
            }else{
                $tbody_8lsh .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
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
                $tfoot_8lsh = '</tbody><tfoot>
                        <tr>
                            <td colspan="6" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                            <td colspan="2" style="border:1px solid #000;"></td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                            <td colspan="7" style="border:1px solid #000;"></td>
                        </tr></tfoot>';
            }
            $table_end_8lsh = '</table>';    
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_8lsh);
            $mpdf->WriteHTML($tfoot_8lsh);
            $mpdf->WriteHTML($table_end_8lsh);  
            $mpdf->AddPage();  
        }

        if($CARTYPE8LNMSH=="8LNMSH"){               
            $sql_8lnmsh = "SELECT
                    DISTINCT
                    OTSN.OILDATAID OILID,
                    CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                    OTSN.OIL_BILLNUMBER OBLNB,
                    OTSN.CARDNUMBER CNB,
                    OTSN.VEHICLEREGISNUMBER VHCRG,
                    VHCTPP.VEHICLETYPE VHCTPLAN,
                    OTSN.VEHICLETYPE VHCTOIL,
                    VHCIF.ENERGY ENGY,
                    OTSN.OIL_AMOUNT OAM,
                    OTSN.MILEAGESTART MST,
                    OTSN.MILEAGEEND MLE,
                    OTSN.DISTANCE DTE,
                    OTSN.OIL_AVERAGE OAVG,
                    OTSN.OIL_TARGET OTG,
                    VHCTPP.JOBEND,
                    VHCTPP.WORKTYPE,
                    VHCTPP.EMPLOYEECODE1 EMP1,
                    VHCTPP.EMPLOYEENAME1 EMPN1,
                    VHCTPP.EMPLOYEECODE2 EMP2,
                    VHCTPP.EMPLOYEENAME2 EMPN2,
                    OTSN.JOBNO JNOIL,
                    VHCTPP.JOBNO JNPLAN
                FROM TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN
                LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                WHERE OTSN.JOBNO IS NOT NULL
                AND VHCTPP.COMPANYCODE != 'RKR' AND VHCTPP.COMPANYCODE != 'RKS' AND VHCTPP.COMPANYCODE != 'RKL'
                AND OTSN.JOBNO != ''
                AND CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) BETWEEN '$start_ymd' AND '$end_ymd'
                AND VHCTPP.VEHICLETYPE = '8L'
                -- AND VHCTPP.WORKTYPE = 'sh'
                ORDER BY OTSN.OILDATAID ASC";
            $query_8lnmsh = sqlsrv_query($conn, $sql_8lnmsh );
            $result_8lnmsh = sqlsrv_fetch_array($query_8lnmsh, SQLSRV_FETCH_ASSOC);
                $OID_8lnmsh=$result_8lnmsh["OILID"];                  
            if($OID_8lnmsh!=""){   
                while($result_8lnmsh = sqlsrv_fetch_array($query_8lnmsh)) {
                    $REFUEL_8LNMSH=$result_8lnmsh["REFUEL"];
                    $CONREFUEL_8LNMSH=explode("-", $REFUEL_8LNMSH);
                    $RSREFUEL_8LNMSH=$CONREFUEL_8LNMSH[2].'/'.$CONREFUEL_8LNMSH[1].'/'.$CONREFUEL_8LNMSH[0];
                    $OBLNB_8LNMSH=$result_8lnmsh["OBLNB"];
                    $CNB_8LNMSH=$result_8lnmsh["CNB"];
                    $VHCRG_8LNMSH=$result_8lnmsh["VHCRG"];
                    $VHCTPLAN_8LNMSH=$result_8lnmsh["VHCTPLAN"];
                    $VHCTOIL_8LNMSH=$result_8lnmsh["VHCTOIL"];
                    $ENGY_8LNMSH=$result_8lnmsh["ENGY"];
                    $OAM_8LNMSH=$result_8lnmsh["OAM"];
                    $MST_8LNMSH=$result_8lnmsh["MST"];
                    $MLE_8LNMSH=$result_8lnmsh["MLE"];
                    $DTE_8LNMSH=$result_8lnmsh["DTE"];
                    $OAVG_8LNMSH=$result_8lnmsh["OAVG"];
                    $OTG_8LNMSH=$result_8lnmsh["OTG"];
                    $JOBEND_8LNMSH=$result_8lnmsh["JOBEND"];
                    $WORKTYPE_8LNMSH=$result_8lnmsh["WORKTYPE"];
                    $EMP1_8LNMSH=$result_8lnmsh["EMP1"];
                    $EMPN1_8LNMSH=$result_8lnmsh["EMPN1"];
                    $EMP2_8LNMSH=$result_8lnmsh["EMP2"];
                    $EMPN2_8LNMSH=$result_8lnmsh["EMPN2"];
                    $JNOIL_8LNMSH=$result_8lnmsh["JNOIL"];
                    $JNPLAN_8LNMSH=$result_8lnmsh["JNPLAN"];
                    
                    $RSOAVG_8lnmsh=$DTE_8LNMSH/$OAM_8LNMSH;
                     
                    $ROAM_8lnmsh=$OAM_8LNMSH;
                        $QROAM_8lnmsh=$QROAM_8lnmsh+$ROAM_8lnmsh;    
                    $RDTE_8lnmsh=$RSDTE_8lnmsh;    
                        $QRDTE_8lnmsh=$QRDTE_8lnmsh+$DTE_8LNMSH;       
                    // $ROTG_8lnmsh=$OTG_8lnmsh; 
                    // $QCALOAM_8lnmsh=(($RDTE_8lnmsh/$ROTG_8lnmsh)-$ROAM_8lnmsh);     
                    //     $QRCALOAM_8lnmsh=$QRCALOAM_8lnmsh+$QCALOAM_8lnmsh; 
                    // $RC3_8lnmsh=$RSPRICE_8lnmsh;    
                    //     $QRC3_8lnmsh=$QRC3_8lnmsh+$RC3_8lnmsh;   
                    $arr_8lnmsh[] = $RSOAVG_8lnmsh; 

                $tbody_8lnmsh .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_8lnmsh.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSREFUEL_8LNMSH.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CNB_8LNMSH.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRG_8LNMSH.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCTPLAN_8LNMSH.'-'.$WORKTYPE_8LNMSH.'</td>
                                <td align="center" style="border:1px solid #000;">ดีเซล</td>
                                <td align="center" style="border:1px solid #000;">'.$OAM_8LNMSH.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_8LNMSH.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MLE_8LNMSH.'</td>
                                <td align="right" style="border:1px solid #000;">'.$DTE_8LNMSH.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OAVG_8LNMSH.'</td>
                                <td align="left" style="border:1px solid #000;">'.$JOBEND_8LNMSH.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMP1_8LNMSH.'</td>
                                <td align="left" style="border:1px solid #000;">'.$EMPN1_8LNMSH.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMP2_8LNMSH.'</td>
                                <td align="left" style="border:1px solid #000;">'.$EMPN2_8LNMSH.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JNPLAN_8LNMSH.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JNOIL_8LNMSH.'</td>
                            </tr>';                   
                        $number_8lnmsh++;
                }                            
                        $TOTALOAM_8lnmsh=$QROAM_8lnmsh;  
                        $TOTALDTE_8lnmsh=$QRDTE_8lnmsh;
                        // $TOTALCALOAM_8lnmsh=$QRCALOAM_8lnmsh;  
                        // $TOTALC3_8lnmsh=$QRC3_8lnmsh; 
                        function Average_8lnmsh($arr_8lnmsh) {
                            $array_size_8lnmsh = count($arr_8lnmsh);                
                            $total_8lnmsh = 0;
                            for ($number_8lnmsh = 0; $number_8lnmsh < $array_size_8lnmsh; $number_8lnmsh++) {
                                $total_8lnmsh += $arr_8lnmsh[$number_8lnmsh];
                            }                
                            $AVERAGE_8lnmsh = (float)($total_8lnmsh / $array_size_8lnmsh);
                            return $AVERAGE_8lnmsh;
                        }        
                $tfoot_8lnmsh = '</tbody><tfoot>
                        <tr>
                            <td colspan="6" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;">'.$TOTALOAM_8lnmsh.'</td>
                            <td colspan="2" style="border:1px solid #000;"></td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;">'.$QRDTE_8lnmsh.'</td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_8lnmsh($arr_8lnmsh), 2).'</td>
                            <td colspan="7" style="border:1px solid #000;"></td>
                        </tr></tfoot>';
                    
            }else{
                $tbody_8lnmsh .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
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
                $tfoot_8lnmsh = '</tbody><tfoot>
                        <tr>
                            <td colspan="6" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                            <td colspan="2" style="border:1px solid #000;"></td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                            <td colspan="7" style="border:1px solid #000;"></td>
                        </tr></tfoot>';
            }
            $table_end_8lnmsh = '</table>';    
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_8lnmsh);
            $mpdf->WriteHTML($tfoot_8lnmsh);
            $mpdf->WriteHTML($table_end_8lnmsh);  
            $mpdf->AddPage();  
        }

        if($CARTYPE10WDUMP=="10WDUMP"){               
            $sql_10wdump = "SELECT
                    DISTINCT
                    OTSN.OILDATAID OILID,
                    CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                    OTSN.OIL_BILLNUMBER OBLNB,
                    OTSN.CARDNUMBER CNB,
                    OTSN.VEHICLEREGISNUMBER VHCRG,
                    VHCTPP.VEHICLETYPE VHCTPLAN,
                    OTSN.VEHICLETYPE VHCTOIL,
                    VHCIF.ENERGY ENGY,
                    OTSN.OIL_AMOUNT OAM,
                    OTSN.MILEAGESTART MST,
                    OTSN.MILEAGEEND MLE,
                    OTSN.DISTANCE DTE,
                    OTSN.OIL_AVERAGE OAVG,
                    OTSN.OIL_TARGET OTG,
                    VHCTPP.JOBEND,
                    VHCTPP.WORKTYPE,
                    VHCTPP.EMPLOYEECODE1 EMP1,
                    VHCTPP.EMPLOYEENAME1 EMPN1,
                    VHCTPP.EMPLOYEECODE2 EMP2,
                    VHCTPP.EMPLOYEENAME2 EMPN2,
                    OTSN.JOBNO JNOIL,
                    VHCTPP.JOBNO JNPLAN
                FROM TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN
                LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                WHERE OTSN.JOBNO IS NOT NULL
                AND VHCTPP.COMPANYCODE != 'RKR' AND VHCTPP.COMPANYCODE != 'RKS' AND VHCTPP.COMPANYCODE != 'RKL'
                AND OTSN.JOBNO != ''
                AND CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) BETWEEN '$start_ymd' AND '$end_ymd'
                AND VHCTPP.VEHICLETYPE = '10W(Dump)'
                -- AND VHCTPP.WORKTYPE = 'nm'
                ORDER BY OTSN.OILDATAID ASC";
            $query_10wdump = sqlsrv_query($conn, $sql_10wdump );
            $result_10wdump = sqlsrv_fetch_array($query_10wdump, SQLSRV_FETCH_ASSOC);
                $OID_10wdump=$result_10wdump["OILID"];                  
            if($OID_10wdump!=""){   
                while($result_10wdump = sqlsrv_fetch_array($query_10wdump)) {
                    $REFUEL_10WDUMP=$result_10wdump["REFUEL"];
                    $CONREFUEL_10WDUMP=explode("-", $REFUEL_10WDUMP);
                    $RSREFUEL_10WDUMP=$CONREFUEL_10WDUMP[2].'/'.$CONREFUEL_10WDUMP[1].'/'.$CONREFUEL_10WDUMP[0];
                    $OBLNB_10WDUMP=$result_10wdump["OBLNB"];
                    $CNB_10WDUMP=$result_10wdump["CNB"];
                    $VHCRG_10WDUMP=$result_10wdump["VHCRG"];
                    $VHCTPLAN_10WDUMP=$result_10wdump["VHCTPLAN"];
                    $VHCTOIL_10WDUMP=$result_10wdump["VHCTOIL"];
                    $ENGY_10WDUMP=$result_10wdump["ENGY"];
                    $OAM_10WDUMP=$result_10wdump["OAM"];
                    $MST_10WDUMP=$result_10wdump["MST"];
                    $MLE_10WDUMP=$result_10wdump["MLE"];
                    $DTE_10WDUMP=$result_10wdump["DTE"];
                    $OAVG_10WDUMP=$result_10wdump["OAVG"];
                    $OTG_10WDUMP=$result_10wdump["OTG"];
                    $JOBEND_10WDUMP=$result_10wdump["JOBEND"];
                    $WORKTYPE_10WDUMP=$result_10wdump["WORKTYPE"];
                    $EMP1_10WDUMP=$result_10wdump["EMP1"];
                    $EMPN1_10WDUMP=$result_10wdump["EMPN1"];
                    $EMP2_10WDUMP=$result_10wdump["EMP2"];
                    $EMPN2_10WDUMP=$result_10wdump["EMPN2"];
                    $JNOIL_10WDUMP=$result_10wdump["JNOIL"];
                    $JNPLAN_10WDUMP=$result_10wdump["JNPLAN"];
                    
                    $RSOAVG_10wdump=$DTE_10WDUMP/$OAM_10WDUMP;
                     
                    $ROAM_10wdump=$OAM_10WDUMP;
                        $QROAM_10wdump=$QROAM_10wdump+$ROAM_10wdump;    
                    $RDTE_10wdump=$RSDTE_10wdump;    
                        $QRDTE_10wdump=$QRDTE_10wdump+$DTE_10WDUMP;       
                    // $ROTG_10wdump=$OTG_10wdump; 
                    // $QCALOAM_10wdump=(($RDTE_10wdump/$ROTG_10wdump)-$ROAM_10wdump);     
                    //     $QRCALOAM_10wdump=$QRCALOAM_10wdump+$QCALOAM_10wdump; 
                    // $RC3_10wdump=$RSPRICE_10wdump;    
                    //     $QRC3_10wdump=$QRC3_10wdump+$RC3_10wdump;   
                    $arr_10wdump[] = $RSOAVG_10wdump; 

                $tbody_10wdump .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_10wdump.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSREFUEL_10WDUMP.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CNB_10WDUMP.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRG_10WDUMP.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCTPLAN_10WDUMP.'</td>
                                <td align="center" style="border:1px solid #000;">ดีเซล</td>
                                <td align="center" style="border:1px solid #000;">'.$OAM_10WDUMP.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_10WDUMP.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MLE_10WDUMP.'</td>
                                <td align="right" style="border:1px solid #000;">'.$DTE_10WDUMP.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OAVG_10WDUMP.'</td>
                                <td align="left" style="border:1px solid #000;">'.$JOBEND_10WDUMP.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMP1_10WDUMP.'</td>
                                <td align="left" style="border:1px solid #000;">'.$EMPN1_10WDUMP.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMP2_10WDUMP.'</td>
                                <td align="left" style="border:1px solid #000;">'.$EMPN2_10WDUMP.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JNPLAN_10WDUMP.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JNOIL_10WDUMP.'</td>
                            </tr>';                   
                        $number_10wdump++;
                }                            
                        $TOTALOAM_10wdump=$QROAM_10wdump;  
                        $TOTALDTE_10wdump=$QRDTE_10wdump;
                        // $TOTALCALOAM_10wdump=$QRCALOAM_10wdump;  
                        // $TOTALC3_10wdump=$QRC3_10wdump; 
                        function Average_10wdump($arr_10wdump) {
                            $array_size_10wdump = count($arr_10wdump);                
                            $total_10wdump = 0;
                            for ($number_10wdump = 0; $number_10wdump < $array_size_10wdump; $number_10wdump++) {
                                $total_10wdump += $arr_10wdump[$number_10wdump];
                            }                
                            $AVERAGE_10wdump = (float)($total_10wdump / $array_size_10wdump);
                            return $AVERAGE_10wdump;
                        }        
                $tfoot_10wdump = '</tbody><tfoot>
                        <tr>
                            <td colspan="6" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;">'.$TOTALOAM_10wdump.'</td>
                            <td colspan="2" style="border:1px solid #000;"></td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;">'.$QRDTE_10wdump.'</td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_10wdump($arr_10wdump), 2).'</td>
                            <td colspan="7" style="border:1px solid #000;"></td>
                        </tr></tfoot>';
                    
            }else{
                $tbody_10wdump .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
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
                $tfoot_10wdump = '</tbody><tfoot>
                        <tr>
                            <td colspan="6" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                            <td colspan="2" style="border:1px solid #000;"></td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                            <td colspan="7" style="border:1px solid #000;"></td>
                        </tr></tfoot>';
            }
            $table_end_10wdump = '</table>';    
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_10wdump);
            $mpdf->WriteHTML($tfoot_10wdump);
            $mpdf->WriteHTML($table_end_10wdump);  
            $mpdf->AddPage();  
        }

        if($CARTYPE10WVAN=="10WVAN"){               
            $sql_10wvan = "SELECT
                    DISTINCT
                    OTSN.OILDATAID OILID,
                    CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                    OTSN.OIL_BILLNUMBER OBLNB,
                    OTSN.CARDNUMBER CNB,
                    OTSN.VEHICLEREGISNUMBER VHCRG,
                    VHCTPP.VEHICLETYPE VHCTPLAN,
                    OTSN.VEHICLETYPE VHCTOIL,
                    VHCIF.ENERGY ENGY,
                    OTSN.OIL_AMOUNT OAM,
                    OTSN.MILEAGESTART MST,
                    OTSN.MILEAGEEND MLE,
                    OTSN.DISTANCE DTE,
                    OTSN.OIL_AVERAGE OAVG,
                    OTSN.OIL_TARGET OTG,
                    VHCTPP.JOBEND,
                    VHCTPP.WORKTYPE,
                    VHCTPP.EMPLOYEECODE1 EMP1,
                    VHCTPP.EMPLOYEENAME1 EMPN1,
                    VHCTPP.EMPLOYEECODE2 EMP2,
                    VHCTPP.EMPLOYEENAME2 EMPN2,
                    OTSN.JOBNO JNOIL,
                    VHCTPP.JOBNO JNPLAN
                FROM TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN
                LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                WHERE OTSN.JOBNO IS NOT NULL
                AND VHCTPP.COMPANYCODE != 'RKR' AND VHCTPP.COMPANYCODE != 'RKS' AND VHCTPP.COMPANYCODE != 'RKL'
                AND OTSN.JOBNO != ''
                AND CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) BETWEEN '$start_ymd' AND '$end_ymd'
                AND VHCTPP.VEHICLETYPE = '10W (Van)'
                -- AND VHCTPP.WORKTYPE = 'nm'
                ORDER BY OTSN.OILDATAID ASC";
            $query_10wvan = sqlsrv_query($conn, $sql_10wvan );
            $result_10wvan = sqlsrv_fetch_array($query_10wvan, SQLSRV_FETCH_ASSOC);
                $OID_10wvan=$result_10wvan["OILID"];                  
            if($OID_10wvan!=""){   
                while($result_10wvan = sqlsrv_fetch_array($query_10wvan)) {
                    $REFUEL_10WVAN=$result_10wvan["REFUEL"];
                    $CONREFUEL_10WVAN=explode("-", $REFUEL_10WVAN);
                    $RSREFUEL_10WVAN=$CONREFUEL_10WVAN[2].'/'.$CONREFUEL_10WVAN[1].'/'.$CONREFUEL_10WVAN[0];
                    $OBLNB_10WVAN=$result_10wvan["OBLNB"];
                    $CNB_10WVAN=$result_10wvan["CNB"];
                    $VHCRG_10WVAN=$result_10wvan["VHCRG"];
                    $VHCTPLAN_10WVAN=$result_10wvan["VHCTPLAN"];
                    $VHCTOIL_10WVAN=$result_10wvan["VHCTOIL"];
                    $ENGY_10WVAN=$result_10wvan["ENGY"];
                    $OAM_10WVAN=$result_10wvan["OAM"];
                    $MST_10WVAN=$result_10wvan["MST"];
                    $MLE_10WVAN=$result_10wvan["MLE"];
                    $DTE_10WVAN=$result_10wvan["DTE"];
                    $OAVG_10WVAN=$result_10wvan["OAVG"];
                    $OTG_10WVAN=$result_10wvan["OTG"];
                    $JOBEND_10WVAN=$result_10wvan["JOBEND"];
                    $WORKTYPE_10WVAN=$result_10wvan["WORKTYPE"];
                    $EMP1_10WVAN=$result_10wvan["EMP1"];
                    $EMPN1_10WVAN=$result_10wvan["EMPN1"];
                    $EMP2_10WVAN=$result_10wvan["EMP2"];
                    $EMPN2_10WVAN=$result_10wvan["EMPN2"];
                    $JNOIL_10WVAN=$result_10wvan["JNOIL"];
                    $JNPLAN_10WVAN=$result_10wvan["JNPLAN"];
                    
                    $RSOAVG_10wvan=$DTE_10WVAN/$OAM_10WVAN;
                     
                    $ROAM_10wvan=$OAM_10WVAN;
                        $QROAM_10wvan=$QROAM_10wvan+$ROAM_10wvan;    
                    $RDTE_10wvan=$RSDTE_10wvan;    
                        $QRDTE_10wvan=$QRDTE_10wvan+$DTE_10WVAN;       
                    // $ROTG_10wvan=$OTG_10wvan; 
                    // $QCALOAM_10wvan=(($RDTE_10wvan/$ROTG_10wvan)-$ROAM_10wvan);     
                    //     $QRCALOAM_10wvan=$QRCALOAM_10wvan+$QCALOAM_10wvan; 
                    // $RC3_10wvan=$RSPRICE_10wvan;    
                    //     $QRC3_10wvan=$QRC3_10wvan+$RC3_10wvan;   
                    $arr_10wvan[] = $RSOAVG_10wvan; 

                $tbody_10wvan .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_10wvan.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSREFUEL_10WVAN.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CNB_10WVAN.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRG_10WVAN.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCTPLAN_10WVAN.'</td>
                                <td align="center" style="border:1px solid #000;">ดีเซล</td>
                                <td align="center" style="border:1px solid #000;">'.$OAM_10WVAN.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_10WVAN.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MLE_10WVAN.'</td>
                                <td align="right" style="border:1px solid #000;">'.$DTE_10WVAN.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OAVG_10WVAN.'</td>
                                <td align="left" style="border:1px solid #000;">'.$JOBEND_10WVAN.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMP1_10WVAN.'</td>
                                <td align="left" style="border:1px solid #000;">'.$EMPN1_10WVAN.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMP2_10WVAN.'</td>
                                <td align="left" style="border:1px solid #000;">'.$EMPN2_10WVAN.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JNPLAN_10WVAN.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JNOIL_10WVAN.'</td>
                            </tr>';                   
                        $number_10wvan++;
                }                            
                        $TOTALOAM_10wvan=$QROAM_10wvan;  
                        $TOTALDTE_10wvan=$QRDTE_10wvan;
                        // $TOTALCALOAM_10wvan=$QRCALOAM_10wvan;  
                        // $TOTALC3_10wvan=$QRC3_10wvan; 
                        function Average_10wvan($arr_10wvan) {
                            $array_size_10wvan = count($arr_10wvan);                
                            $total_10wvan = 0;
                            for ($number_10wvan = 0; $number_10wvan < $array_size_10wvan; $number_10wvan++) {
                                $total_10wvan += $arr_10wvan[$number_10wvan];
                            }                
                            $AVERAGE_10wvan = (float)($total_10wvan / $array_size_10wvan);
                            return $AVERAGE_10wvan;
                        }        
                $tfoot_10wvan = '</tbody><tfoot>
                        <tr>
                            <td colspan="6" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;">'.$TOTALOAM_10wvan.'</td>
                            <td colspan="2" style="border:1px solid #000;"></td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;">'.$QRDTE_10wvan.'</td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_10wvan($arr_10wvan), 2).'</td>
                            <td colspan="7" style="border:1px solid #000;"></td>
                        </tr></tfoot>';
                    
            }else{
                $tbody_10wvan .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
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
                $tfoot_10wvan = '</tbody><tfoot>
                        <tr>
                            <td colspan="6" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                            <td colspan="2" style="border:1px solid #000;"></td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                            <td colspan="7" style="border:1px solid #000;"></td>
                        </tr></tfoot>';
            }
            $table_end_10wvan = '</table>';    
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_10wvan);
            $mpdf->WriteHTML($tfoot_10wvan);
            $mpdf->WriteHTML($table_end_10wvan);  
            $mpdf->AddPage();  
        }

        if($CARTYPE22WDUMP=="22WDUMP"){               
            $sql_22wdump = "SELECT
                    DISTINCT
                    OTSN.OILDATAID OILID,
                    CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                    OTSN.OIL_BILLNUMBER OBLNB,
                    OTSN.CARDNUMBER CNB,
                    OTSN.VEHICLEREGISNUMBER VHCRG,
                    VHCTPP.VEHICLETYPE VHCTPLAN,
                    OTSN.VEHICLETYPE VHCTOIL,
                    VHCIF.ENERGY ENGY,
                    OTSN.OIL_AMOUNT OAM,
                    OTSN.MILEAGESTART MST,
                    OTSN.MILEAGEEND MLE,
                    OTSN.DISTANCE DTE,
                    OTSN.OIL_AVERAGE OAVG,
                    OTSN.OIL_TARGET OTG,
                    VHCTPP.JOBEND,
                    VHCTPP.WORKTYPE,
                    VHCTPP.EMPLOYEECODE1 EMP1,
                    VHCTPP.EMPLOYEENAME1 EMPN1,
                    VHCTPP.EMPLOYEECODE2 EMP2,
                    VHCTPP.EMPLOYEENAME2 EMPN2,
                    OTSN.JOBNO JNOIL,
                    VHCTPP.JOBNO JNPLAN
                FROM TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN
                LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                WHERE OTSN.JOBNO IS NOT NULL
                AND VHCTPP.COMPANYCODE != 'RKR' AND VHCTPP.COMPANYCODE != 'RKS' AND VHCTPP.COMPANYCODE != 'RKL'
                AND OTSN.JOBNO != ''
                AND CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) BETWEEN '$start_ymd' AND '$end_ymd'
                AND VHCTPP.VEHICLETYPE = '22W(Dump)'
                -- AND VHCTPP.WORKTYPE = 'nm'
                ORDER BY OTSN.OILDATAID ASC";
            $query_22wdump = sqlsrv_query($conn, $sql_22wdump );
            $result_22wdump = sqlsrv_fetch_array($query_22wdump, SQLSRV_FETCH_ASSOC);
                $OID_22wdump=$result_22wdump["OILID"];                  
            if($OID_22wdump!=""){   
                while($result_22wdump = sqlsrv_fetch_array($query_22wdump)) {
                    $REFUEL_22WDUMP=$result_22wdump["REFUEL"];
                    $CONREFUEL_22WDUMP=explode("-", $REFUEL_22WDUMP);
                    $RSREFUEL_22WDUMP=$CONREFUEL_22WDUMP[2].'/'.$CONREFUEL_22WDUMP[1].'/'.$CONREFUEL_22WDUMP[0];
                    $OBLNB_22WDUMP=$result_22wdump["OBLNB"];
                    $CNB_22WDUMP=$result_22wdump["CNB"];
                    $VHCRG_22WDUMP=$result_22wdump["VHCRG"];
                    $VHCTPLAN_22WDUMP=$result_22wdump["VHCTPLAN"];
                    $VHCTOIL_22WDUMP=$result_22wdump["VHCTOIL"];
                    $ENGY_22WDUMP=$result_22wdump["ENGY"];
                    $OAM_22WDUMP=$result_22wdump["OAM"];
                    $MST_22WDUMP=$result_22wdump["MST"];
                    $MLE_22WDUMP=$result_22wdump["MLE"];
                    $DTE_22WDUMP=$result_22wdump["DTE"];
                    $OAVG_22WDUMP=$result_22wdump["OAVG"];
                    $OTG_22WDUMP=$result_22wdump["OTG"];
                    $JOBEND_22WDUMP=$result_22wdump["JOBEND"];
                    $WORKTYPE_22WDUMP=$result_22wdump["WORKTYPE"];
                    $EMP1_22WDUMP=$result_22wdump["EMP1"];
                    $EMPN1_22WDUMP=$result_22wdump["EMPN1"];
                    $EMP2_22WDUMP=$result_22wdump["EMP2"];
                    $EMPN2_22WDUMP=$result_22wdump["EMPN2"];
                    $JNOIL_22WDUMP=$result_22wdump["JNOIL"];
                    $JNPLAN_22WDUMP=$result_22wdump["JNPLAN"];
                    
                    $RSOAVG_22wdump=$DTE_22WDUMP/$OAM_22WDUMP;
                     
                    $ROAM_22wdump=$OAM_22WDUMP;
                        $QROAM_22wdump=$QROAM_22wdump+$ROAM_22wdump;    
                    $RDTE_22wdump=$RSDTE_22wdump;    
                        $QRDTE_22wdump=$QRDTE_22wdump+$DTE_22WDUMP;       
                    // $ROTG_22wdump=$OTG_22wdump; 
                    // $QCALOAM_22wdump=(($RDTE_22wdump/$ROTG_22wdump)-$ROAM_22wdump);     
                    //     $QRCALOAM_22wdump=$QRCALOAM_22wdump+$QCALOAM_22wdump; 
                    // $RC3_22wdump=$RSPRICE_22wdump;    
                    //     $QRC3_22wdump=$QRC3_22wdump+$RC3_22wdump;   
                    $arr_22wdump[] = $RSOAVG_22wdump; 

                $tbody_22wdump .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_22wdump.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSREFUEL_22WDUMP.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CNB_22WDUMP.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRG_22WDUMP.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCTPLAN_22WDUMP.'</td>
                                <td align="center" style="border:1px solid #000;">ดีเซล</td>
                                <td align="center" style="border:1px solid #000;">'.$OAM_22WDUMP.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_22WDUMP.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MLE_22WDUMP.'</td>
                                <td align="right" style="border:1px solid #000;">'.$DTE_22WDUMP.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OAVG_22WDUMP.'</td>
                                <td align="left" style="border:1px solid #000;">'.$JOBEND_22WDUMP.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMP1_22WDUMP.'</td>
                                <td align="left" style="border:1px solid #000;">'.$EMPN1_22WDUMP.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMP2_22WDUMP.'</td>
                                <td align="left" style="border:1px solid #000;">'.$EMPN2_22WDUMP.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JNPLAN_22WDUMP.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JNOIL_22WDUMP.'</td>
                            </tr>';                   
                        $number_22wdump++;
                }                            
                        $TOTALOAM_22wdump=$QROAM_22wdump;  
                        $TOTALDTE_22wdump=$QRDTE_22wdump;
                        // $TOTALCALOAM_22wdump=$QRCALOAM_22wdump;  
                        // $TOTALC3_22wdump=$QRC3_22wdump; 
                        function Average_22wdump($arr_22wdump) {
                            $array_size_22wdump = count($arr_22wdump);                
                            $total_22wdump = 0;
                            for ($number_22wdump = 0; $number_22wdump < $array_size_22wdump; $number_22wdump++) {
                                $total_22wdump += $arr_22wdump[$number_22wdump];
                            }                
                            $AVERAGE_22wdump = (float)($total_22wdump / $array_size_22wdump);
                            return $AVERAGE_22wdump;
                        }        
                $tfoot_22wdump = '</tbody><tfoot>
                        <tr>
                            <td colspan="6" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;">'.$TOTALOAM_22wdump.'</td>
                            <td colspan="2" style="border:1px solid #000;"></td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;">'.$QRDTE_22wdump.'</td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_22wdump($arr_22wdump), 2).'</td>
                            <td colspan="7" style="border:1px solid #000;"></td>
                        </tr></tfoot>';
                    
            }else{
                $tbody_22wdump .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
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
                $tfoot_22wdump = '</tbody><tfoot>
                        <tr>
                            <td colspan="6" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                            <td colspan="2" style="border:1px solid #000;"></td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                            <td colspan="7" style="border:1px solid #000;"></td>
                        </tr></tfoot>';
            }
            $table_end_22wdump = '</table>';    
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_22wdump);
            $mpdf->WriteHTML($tfoot_22wdump);
            $mpdf->WriteHTML($table_end_22wdump);  
            $mpdf->AddPage();  
        }

        if($CARTYPESEMITRAILER=="SEMITRAILER"){               
            $sql_semitrailer = "SELECT
                    DISTINCT
                    OTSN.OILDATAID OILID,
                    CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                    OTSN.OIL_BILLNUMBER OBLNB,
                    OTSN.CARDNUMBER CNB,
                    OTSN.VEHICLEREGISNUMBER VHCRG,
                    VHCTPP.VEHICLETYPE VHCTPLAN,
                    OTSN.VEHICLETYPE VHCTOIL,
                    VHCIF.ENERGY ENGY,
                    OTSN.OIL_AMOUNT OAM,
                    OTSN.MILEAGESTART MST,
                    OTSN.MILEAGEEND MLE,
                    OTSN.DISTANCE DTE,
                    OTSN.OIL_AVERAGE OAVG,
                    OTSN.OIL_TARGET OTG,
                    VHCTPP.JOBEND,
                    VHCTPP.WORKTYPE,
                    VHCTPP.EMPLOYEECODE1 EMP1,
                    VHCTPP.EMPLOYEENAME1 EMPN1,
                    VHCTPP.EMPLOYEECODE2 EMP2,
                    VHCTPP.EMPLOYEENAME2 EMPN2,
                    OTSN.JOBNO JNOIL,
                    VHCTPP.JOBNO JNPLAN
                FROM TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN
                LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
                WHERE OTSN.JOBNO IS NOT NULL
                AND VHCTPP.COMPANYCODE != 'RKR' AND VHCTPP.COMPANYCODE != 'RKS' AND VHCTPP.COMPANYCODE != 'RKL'
                AND OTSN.JOBNO != ''
                AND CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) BETWEEN '$start_ymd' AND '$end_ymd'
                AND VHCTPP.VEHICLETYPE = 'Semitrailer'
                -- AND VHCTPP.WORKTYPE = 'nm'
                ORDER BY OTSN.OILDATAID ASC";
            $query_semitrailer = sqlsrv_query($conn, $sql_semitrailer );
            $result_semitrailer = sqlsrv_fetch_array($query_semitrailer, SQLSRV_FETCH_ASSOC);
                $OID_semitrailer=$result_semitrailer["OILID"];                  
            if($OID_semitrailer!=""){   
                while($result_semitrailer = sqlsrv_fetch_array($query_semitrailer)) {
                    $REFUEL_SEMITRAILER=$result_semitrailer["REFUEL"];
                    $CONREFUEL_SEMITRAILER=explode("-", $REFUEL_SEMITRAILER);
                    $RSREFUEL_SEMITRAILER=$CONREFUEL_SEMITRAILER[2].'/'.$CONREFUEL_SEMITRAILER[1].'/'.$CONREFUEL_SEMITRAILER[0];
                    $OBLNB_SEMITRAILER=$result_semitrailer["OBLNB"];
                    $CNB_SEMITRAILER=$result_semitrailer["CNB"];
                    $VHCRG_SEMITRAILER=$result_semitrailer["VHCRG"];
                    $VHCTPLAN_SEMITRAILER=$result_semitrailer["VHCTPLAN"];
                    $VHCTOIL_SEMITRAILER=$result_semitrailer["VHCTOIL"];
                    $ENGY_SEMITRAILER=$result_semitrailer["ENGY"];
                    $OAM_SEMITRAILER=$result_semitrailer["OAM"];
                    $MST_SEMITRAILER=$result_semitrailer["MST"];
                    $MLE_SEMITRAILER=$result_semitrailer["MLE"];
                    $DTE_SEMITRAILER=$result_semitrailer["DTE"];
                    $OAVG_SEMITRAILER=$result_semitrailer["OAVG"];
                    $OTG_SEMITRAILER=$result_semitrailer["OTG"];
                    $JOBEND_SEMITRAILER=$result_semitrailer["JOBEND"];
                    $WORKTYPE_SEMITRAILER=$result_semitrailer["WORKTYPE"];
                    $EMP1_SEMITRAILER=$result_semitrailer["EMP1"];
                    $EMPN1_SEMITRAILER=$result_semitrailer["EMPN1"];
                    $EMP2_SEMITRAILER=$result_semitrailer["EMP2"];
                    $EMPN2_SEMITRAILER=$result_semitrailer["EMPN2"];
                    $JNOIL_SEMITRAILER=$result_semitrailer["JNOIL"];
                    $JNPLAN_SEMITRAILER=$result_semitrailer["JNPLAN"];
                    
                    $RSOAVG_semitrailer=$DTE_SEMITRAILER/$OAM_SEMITRAILER;
                     
                    $ROAM_semitrailer=$OAM_SEMITRAILER;
                        $QROAM_semitrailer=$QROAM_semitrailer+$ROAM_semitrailer;    
                    $RDTE_semitrailer=$RSDTE_semitrailer;    
                        $QRDTE_semitrailer=$QRDTE_semitrailer+$DTE_SEMITRAILER;       
                    // $ROTG_semitrailer=$OTG_semitrailer; 
                    // $QCALOAM_semitrailer=(($RDTE_semitrailer/$ROTG_semitrailer)-$ROAM_semitrailer);     
                    //     $QRCALOAM_semitrailer=$QRCALOAM_semitrailer+$QCALOAM_semitrailer; 
                    // $RC3_semitrailer=$RSPRICE_semitrailer;    
                    //     $QRC3_semitrailer=$QRC3_semitrailer+$RC3_semitrailer;   
                    $arr_semitrailer[] = $RSOAVG_semitrailer; 

                $tbody_semitrailer .= '<tr>
                                <td align="center" style="border:1px solid #000;">'.++$numpage_semitrailer.'</td>
                                <td align="center" style="border:1px solid #000;">'.$RSREFUEL_SEMITRAILER.'</td>
                                <td align="center" style="border:1px solid #000;">'.$CNB_SEMITRAILER.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCRG_SEMITRAILER.'</td>
                                <td align="center" style="border:1px solid #000;">'.$VHCTPLAN_SEMITRAILER.'</td>
                                <td align="center" style="border:1px solid #000;">ดีเซล</td>
                                <td align="center" style="border:1px solid #000;">'.$OAM_SEMITRAILER.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MST_SEMITRAILER.'</td>
                                <td align="right" style="border:1px solid #000;">'.$MLE_SEMITRAILER.'</td>
                                <td align="right" style="border:1px solid #000;">'.$DTE_SEMITRAILER.'</td>
                                <td align="center" style="border:1px solid #000;">'.$OAVG_SEMITRAILER.'</td>
                                <td align="left" style="border:1px solid #000;">'.$JOBEND_SEMITRAILER.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMP1_SEMITRAILER.'</td>
                                <td align="left" style="border:1px solid #000;">'.$EMPN1_SEMITRAILER.'</td>
                                <td align="center" style="border:1px solid #000;">'.$EMP2_SEMITRAILER.'</td>
                                <td align="left" style="border:1px solid #000;">'.$EMPN2_SEMITRAILER.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JNPLAN_SEMITRAILER.'</td>
                                <td align="center" style="border:1px solid #000;">'.$JNOIL_SEMITRAILER.'</td>
                            </tr>';                   
                        $number_semitrailer++;
                }                            
                        $TOTALOAM_semitrailer=$QROAM_semitrailer;  
                        $TOTALDTE_semitrailer=$QRDTE_semitrailer;
                        // $TOTALCALOAM_semitrailer=$QRCALOAM_semitrailer;  
                        // $TOTALC3_semitrailer=$QRC3_semitrailer; 
                        function Average_semitrailer($arr_semitrailer) {
                            $array_size_semitrailer = count($arr_semitrailer);                
                            $total_semitrailer = 0;
                            for ($number_semitrailer = 0; $number_semitrailer < $array_size_semitrailer; $number_semitrailer++) {
                                $total_semitrailer += $arr_semitrailer[$number_semitrailer];
                            }                
                            $AVERAGE_semitrailer = (float)($total_semitrailer / $array_size_semitrailer);
                            return $AVERAGE_semitrailer;
                        }        
                $tfoot_semitrailer = '</tbody><tfoot>
                        <tr>
                            <td colspan="6" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;">'.$TOTALOAM_semitrailer.'</td>
                            <td colspan="2" style="border:1px solid #000;"></td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;">'.$QRDTE_semitrailer.'</td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average_semitrailer($arr_semitrailer), 2).'</td>
                            <td colspan="7" style="border:1px solid #000;"></td>
                        </tr></tfoot>';
                    
            }else{
                $tbody_semitrailer .= '<tr>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
                                <td align="center" style="border:1px solid #000;"></td>
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
                $tfoot_semitrailer = '</tbody><tfoot>
                        <tr>
                            <td colspan="6" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                            <td colspan="2" style="border:1px solid #000;"></td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                            <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                            <td colspan="7" style="border:1px solid #000;"></td>
                        </tr></tfoot>';
            }
            $table_end_semitrailer = '</table>';    
            $mpdf->WriteHTML($table);
            $mpdf->WriteHTML($tbody_semitrailer);
            $mpdf->WriteHTML($tfoot_semitrailer);
            $mpdf->WriteHTML($table_end_semitrailer);  
        }

    $work_sheet++;
    $mpdf->Output();

}else{
    echo "<h1>ไม่มีข้อมูล</h1>";
} 
sqlsrv_close($conn);
?>