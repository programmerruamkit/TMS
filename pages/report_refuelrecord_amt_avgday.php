<?php

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

    $date1 = $_POST["txt_datestaravarageforday"];
    // $date1 = '23/01/2025';
    $start = explode("/", $date1);
    $startd = $start[0];
    $startif = $start[1];
        if($startif == "01"){
            $startm = ["มกราคม", "January"];
        }else if($startif == "02"){
            $startm = ["กุมภาพันธ์", "February"];
        }else if($startif == "03"){
            $startm = ["มีนาคม", "March"];
        }else if($startif == "04"){
            $startm = ["เมษายน", "April"];
        }else if($startif == "05"){
            $startm = ["พฤษภาคม", "May"];
        }else if($startif == "06"){
            $startm = ["มิถุนายน", "June"];
        }else if($startif == "07"){
            $startm = ["กรกฎาคม", "July"];
        }else if($startif == "08"){
            $startm = ["สิงหาคม", "August"];
        }else if($startif == "09"){
            $startm = ["กันยายน", "September"];
        }else if($startif == "10"){
            $startm = ["ตุลาคม", "October"];
        }else if($startif == "11"){
            $startm = ["พฤศจิกายน", "November"];
        }else if($startif == "12"){
            $startm = ["ธันวาคม", "December"];
        }
    
    $starty = $start[2]+543;
    $start_ymd = $start[2].'-'.$start[1].'-'.$start[0];

    $startsumth = $startd.' '.$startm[0].' '.$starty;
    $startsumen = $startd.' '.$startm[1].' '.$starty;
    $startsumSQL = $start[2].'-'.$start[1].'-'.$start[0];

    // $date2 = $_POST["txt_datestaravarageforday"];
    $date2 = $_POST["txt_dateendyavarageforday"];
    // $date2 = '25/01/2025';
    $end = explode("/", $date2);
    $endd = $end[0];
    $endif = $end[1];
        if($endif == "01"){
            $endm = ["มกราคม", "January"];
        }else if($endif == "02"){
            $endm = ["กุมภาพันธ์", "February"];
        }else if($endif == "03"){
            $endm = ["มีนาคม", "March"];
        }else if($endif == "04"){
            $endm = ["เมษายน", "April"];
        }else if($endif == "05"){
            $endm = ["พฤษภาคม", "May"];
        }else if($endif == "06"){
            $endm = ["มิถุนายน", "June"];
        }else if($endif == "07"){
            $endm = ["กรกฎาคม", "July"];
        }else if($endif == "08"){
            $endm = ["สิงหาคม", "August"];
        }else if($endif == "09"){
            $endm = ["กันยายน", "September"];
        }else if($endif == "10"){
            $endm = ["ตุลาคม", "October"];
        }else if($endif == "11"){
            $endm = ["พฤศจิกายน", "November"];
        }else if($endif == "12"){
            $endm = ["ธันวาคม", "December"];
        }
    $endy = $end[2]+543;
    $end_ymd = $end[2].'-'.$end[1].'-'.$end[0];
    
    $endsumth = $endd.' '.$endm[0].' '.$endy;
    $endsumen = $endd.' '.$endm[1].' '.$endy;
    $endsumSQL =  $end[2].'-'.$end[1].'-'.$end[0];
 
    $objPHPExcel = new PHPExcel();

    $work_sheet=0;
	while (strtotime($start_ymd) <= strtotime($end_ymd)) {
        $day = explode("-", $start_ymd);
        $chkday = $day[2];
        $start_ymd = date ("Y-m-d", strtotime("+1 day", strtotime($start_ymd)));
        $start_ymd_new = $start[2].'-'.$start[1].'-'.$chkday;

        // Day-------------------------------------------------------------------------------------------------------------------------------------------------

            $objPHPExcel->createSheet();
            $objPHPExcel->setActiveSheetIndex($work_sheet);
                // OPEN SECTION
                    $detail="สรุปค่าเฉลี่ยน้ำมันรายวันประจำวันที่ $chkday $startm[0] $starty";
                    
                    $objPHPExcel->getActiveSheet()->mergeCells('A1:Y1');
                    $sheet = $objPHPExcel->getActiveSheet();
                    $sheet->setCellValueByColumnAndRow(0,2,$detail);
                    $sheet->mergeCells('A2:Y2');
                    $objPHPExcel->getActiveSheet()->getStyle('A2:Y2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('A2:Y2')->applyFromArray(array('font' => array('bold' => true,'size' => 12)));

                    $sheet = $objPHPExcel->getActiveSheet();
                    $sheet->setCellValueByColumnAndRow(0,3,'');
                    $sheet->mergeCells('A3:Y3');
                    $objPHPExcel->getActiveSheet()->getStyle('A3:Y3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    
                    $objDrawing = new PHPExcel_Worksheet_HeaderFooterDrawing();
                    $objPHPExcel->getActiveSheet()->getHeaderFooter()->addImage($objDrawing, PHPExcel_Worksheet_HeaderFooter::IMAGE_HEADER_LEFT);
                    $styleText = array('font'  => array('bold'  => false,'color' => array('rgb' => '000000'),'size'  => 10,'name'  => 'Verdana'));  
                    $sheet->getDefaultStyle()->applyFromArray($styleText);
                    
                    $i = "10";
                    $numpage = "1";
                    /* Table_1 */
                        /* SQL QUERY */ 
                            // Query ใหม่ ดึงจาก Table TEMP_OILAVERAGE_AMT และ นำมาคำนวณ และ แสดงผล ใช้เวลาไม่ถึง 1 วินาที
                                ${"s_1".$work_sheet} = "SELECT DISTINCT * FROM TEMP_OILAVERAGE_AMT WHERE NUMBERROW='1' AND DWK='$start_ymd_new'"; 
                                ${"s_2".$work_sheet} = "SELECT DISTINCT * FROM TEMP_OILAVERAGE_AMT WHERE NUMBERROW='2' AND DWK='$start_ymd_new'";
                                ${"s_3".$work_sheet} = "SELECT DISTINCT * FROM TEMP_OILAVERAGE_AMT WHERE NUMBERROW='3' AND DWK='$start_ymd_new'";
                                ${"s_4".$work_sheet} = "SELECT DISTINCT * FROM TEMP_OILAVERAGE_AMT WHERE NUMBERROW='4' AND DWK='$start_ymd_new'";
                                ${"s_5".$work_sheet} = "SELECT DISTINCT * FROM TEMP_OILAVERAGE_AMT WHERE NUMBERROW='5' AND DWK='$start_ymd_new'";
                                ${"s_6".$work_sheet} = "SELECT DISTINCT * FROM TEMP_OILAVERAGE_AMT WHERE NUMBERROW='6' AND DWK='$start_ymd_new'";
                                ${"s_7".$work_sheet} = "SELECT DISTINCT * FROM TEMP_OILAVERAGE_AMT WHERE NUMBERROW='7' AND DWK='$start_ymd_new'";
                                ${"s_8".$work_sheet} = "SELECT DISTINCT * FROM TEMP_OILAVERAGE_AMT WHERE NUMBERROW='8' AND DWK='$start_ymd_new'";
                                ${"s_9".$work_sheet} = "SELECT DISTINCT * FROM TEMP_OILAVERAGE_AMT WHERE NUMBERROW='9' AND DWK='$start_ymd_new'";
                                ${"s_10".$work_sheet} = "SELECT DISTINCT * FROM TEMP_OILAVERAGE_AMT WHERE NUMBERROW='10' AND DWK='$start_ymd_new'";
                                ${"s_11".$work_sheet} = "SELECT DISTINCT * FROM TEMP_OILAVERAGE_AMT WHERE NUMBERROW='11' AND DWK='$start_ymd_new'";
                                ${"q_1".$work_sheet} = sqlsrv_query($conn, ${"s_1".$work_sheet});${"r_1".$work_sheet} = sqlsrv_fetch_array(${"q_1".$work_sheet}, SQLSRV_FETCH_ASSOC);
                                ${"q_2".$work_sheet} = sqlsrv_query($conn, ${"s_2".$work_sheet});${"r_2".$work_sheet} = sqlsrv_fetch_array(${"q_2".$work_sheet}, SQLSRV_FETCH_ASSOC);
                                ${"q_3".$work_sheet} = sqlsrv_query($conn, ${"s_3".$work_sheet});${"r_3".$work_sheet} = sqlsrv_fetch_array(${"q_3".$work_sheet}, SQLSRV_FETCH_ASSOC);
                                ${"q_4".$work_sheet} = sqlsrv_query($conn, ${"s_4".$work_sheet});${"r_4".$work_sheet} = sqlsrv_fetch_array(${"q_4".$work_sheet}, SQLSRV_FETCH_ASSOC);
                                ${"q_5".$work_sheet} = sqlsrv_query($conn, ${"s_5".$work_sheet});${"r_5".$work_sheet} = sqlsrv_fetch_array(${"q_5".$work_sheet}, SQLSRV_FETCH_ASSOC);
                                ${"q_6".$work_sheet} = sqlsrv_query($conn, ${"s_6".$work_sheet});${"r_6".$work_sheet} = sqlsrv_fetch_array(${"q_6".$work_sheet}, SQLSRV_FETCH_ASSOC);
                                ${"q_7".$work_sheet} = sqlsrv_query($conn, ${"s_7".$work_sheet});${"r_7".$work_sheet} = sqlsrv_fetch_array(${"q_7".$work_sheet}, SQLSRV_FETCH_ASSOC);
                                ${"q_8".$work_sheet} = sqlsrv_query($conn, ${"s_8".$work_sheet});${"r_8".$work_sheet} = sqlsrv_fetch_array(${"q_8".$work_sheet}, SQLSRV_FETCH_ASSOC);
                                ${"q_9".$work_sheet} = sqlsrv_query($conn, ${"s_9".$work_sheet});${"r_9".$work_sheet} = sqlsrv_fetch_array(${"q_9".$work_sheet}, SQLSRV_FETCH_ASSOC);
                                ${"q_10".$work_sheet} = sqlsrv_query($conn, ${"s_10".$work_sheet});${"r_10".$work_sheet} = sqlsrv_fetch_array(${"q_10".$work_sheet}, SQLSRV_FETCH_ASSOC);
                                ${"q_11".$work_sheet} = sqlsrv_query($conn, ${"s_11".$work_sheet});${"r_11".$work_sheet} = sqlsrv_fetch_array(${"q_11".$work_sheet}, SQLSRV_FETCH_ASSOC);
                            // Total_1
                                ${"totalTargetrow_1".$work_sheet}       = !empty(${"r_1".$work_sheet}['TARGET']) ? ${"r_1".$work_sheet}['TARGET'] : 0.00;
                                ${"totalTripsrow_1".$work_sheet}        = !empty(${"r_1".$work_sheet}['TRIPS']) ? ${"r_1".$work_sheet}['TRIPS'] : 0;
                                ${"totalMileagerow_1".$work_sheet}      = !empty(${"r_1".$work_sheet}['MILEAGE']) ? floatval(str_replace(',', '', ${"r_1".$work_sheet}['MILEAGE'])) : 0.00;
                                ${"totalLiterrow_1".$work_sheet}        = !empty(${"r_1".$work_sheet}['LITER']) ? floatval(str_replace(',', '', ${"r_1".$work_sheet}['LITER'])) : 0.00;
                                ${"actual_valuesrow_1".$work_sheet}     = [${"r_1".$work_sheet}['ACTUAL']];
                                ${"totalActualrow_1".$work_sheet}       = !empty(${"actual_valuesrow_1".$work_sheet}) ? array_sum(${"actual_valuesrow_1".$work_sheet}) / count(${"actual_valuesrow_1".$work_sheet}) : 0;
                                ${"min_valuesrow_1".$work_sheet}        = [${"r_1".$work_sheet}['MIN'] === '9,999,999,999.00' ? 0.00 : ${"r_1".$work_sheet}['MIN']];
                                ${"totalMinrow_1".$work_sheet}          = !empty(${"min_valuesrow_1".$work_sheet}) ? array_sum(${"min_valuesrow_1".$work_sheet}) / count(${"min_valuesrow_1".$work_sheet}) : 0;
                                ${"max_valuesrow_1".$work_sheet}        = [${"r_1".$work_sheet}['MAX'] === '-9,999,999,999.00' ? 0.00 : ${"r_1".$work_sheet}['MAX']];
                                ${"totalMaxrow_1".$work_sheet}          = !empty(${"max_valuesrow_1".$work_sheet}) ? array_sum(${"max_valuesrow_1".$work_sheet}) / count(${"max_valuesrow_1".$work_sheet}) : 0;
                                ${"totalOkrow_1".$work_sheet}           = !empty(${"r_1".$work_sheet}['OK']) ? ${"r_1".$work_sheet}['OK'] : 0;
                                ${"totalNgrow_1".$work_sheet}           = !empty(${"r_1".$work_sheet}['NG']) ? ${"r_1".$work_sheet}['NG'] : 0;
                                ${"percentage_valuesrow_1".$work_sheet} = [${"r_1".$work_sheet}['PERCENTAGE']];
                                ${"totalPercentagerow_1".$work_sheet}   = !empty(${"percentage_valuesrow_1".$work_sheet}) ? array_sum(${"percentage_valuesrow_1".$work_sheet}) / count(${"percentage_valuesrow_1".$work_sheet}) : 0;                                
                                ${"totalDriverrow_1".$work_sheet}       = !empty(${"r_1".$work_sheet}['DRIVER']) ? floatval(str_replace(',', '', ${"r_1".$work_sheet}['DRIVER'])) : 0.00;
                                
                                ${"total2groub_1".$work_sheet}          = ${"totalTripsrow_1".$work_sheet};
                                ${"total3groub_1".$work_sheet}          = ${"totalMileagerow_1".$work_sheet};
                                ${"total4groub_1".$work_sheet}          = ${"totalLiterrow_1".$work_sheet};
                                ${"total5groub_1".$work_sheet}          = ${"totalActualrow_1".$work_sheet};
                                ${"total6groub_1".$work_sheet}          = ${"totalMinrow_1".$work_sheet} ;
                                ${"total7groub_1".$work_sheet}          = ${"totalMaxrow_1".$work_sheet};
                                ${"total8groub_1".$work_sheet}          = ${"totalOkrow_1".$work_sheet};
                                ${"total9groub_1".$work_sheet}          = ${"totalNgrow_1".$work_sheet};
                                ${"total10groub_1".$work_sheet}         = round(${"totalPercentagerow_1".$work_sheet});
                                ${"total11groub_1".$work_sheet}         = ${"totalDriverrow_1".$work_sheet};
                            
                            // Total_2
                                ${"totalTargetrow_2".$work_sheet}       = !empty(${"r_2".$work_sheet}['TARGET']) ? ${"r_2".$work_sheet}['TARGET'] : 0.00;
                                ${"totalTripsrow_2".$work_sheet}        = !empty(${"r_2".$work_sheet}['TRIPS']) ? ${"r_2".$work_sheet}['TRIPS'] : 0;
                                ${"totalMileagerow_2".$work_sheet}      = !empty(${"r_2".$work_sheet}['MILEAGE']) ? floatval(str_replace(',', '', ${"r_2".$work_sheet}['MILEAGE'])) : 0.00;
                                ${"totalLiterrow_2".$work_sheet}        = !empty(${"r_2".$work_sheet}['LITER']) ? floatval(str_replace(',', '', ${"r_2".$work_sheet}['LITER'])) : 0.00;
                                ${"actual_valuesrow_2".$work_sheet}     = [${"r_2".$work_sheet}['ACTUAL']];
                                ${"totalActualrow_2".$work_sheet}       = !empty(${"actual_valuesrow_2".$work_sheet}) ? array_sum(${"actual_valuesrow_2".$work_sheet}) / count(${"actual_valuesrow_2".$work_sheet}) : 0;
                                ${"min_valuesrow_2".$work_sheet}        = [${"r_2".$work_sheet}['MIN'] === '9,999,999,999.00' ? 0.00 : ${"r_2".$work_sheet}['MIN']];
                                ${"totalMinrow_2".$work_sheet}          = !empty(${"min_valuesrow_2".$work_sheet}) ? array_sum(${"min_valuesrow_2".$work_sheet}) / count(${"min_valuesrow_2".$work_sheet}) : 0;
                                ${"max_valuesrow_2".$work_sheet}        = [${"r_2".$work_sheet}['MAX'] === '-9,999,999,999.00' ? 0.00 : ${"r_2".$work_sheet}['MAX']];
                                ${"totalMaxrow_2".$work_sheet}          = !empty(${"max_valuesrow_2".$work_sheet}) ? array_sum(${"max_valuesrow_2".$work_sheet}) / count(${"max_valuesrow_2".$work_sheet}) : 0;
                                ${"totalOkrow_2".$work_sheet}           = !empty(${"r_2".$work_sheet}['OK']) ? ${"r_2".$work_sheet}['OK'] : 0;
                                ${"totalNgrow_2".$work_sheet}           = !empty(${"r_2".$work_sheet}['NG']) ? ${"r_2".$work_sheet}['NG'] : 0;
                                ${"percentage_valuesrow_2".$work_sheet} = [${"r_2".$work_sheet}['PERCENTAGE']];
                                ${"totalPercentagerow_2".$work_sheet}   = !empty(${"percentage_valuesrow_2".$work_sheet}) ? array_sum(${"percentage_valuesrow_2".$work_sheet}) / count(${"percentage_valuesrow_2".$work_sheet}) : 0;
                                ${"totalDriverrow_2".$work_sheet}       = !empty(${"r_2".$work_sheet}['DRIVER']) ? floatval(str_replace(',', '', ${"r_2".$work_sheet}['DRIVER'])) : 0.00;

                                ${"totalTargetrow_3".$work_sheet}       = !empty(${"r_3".$work_sheet}['TARGET']) ? ${"r_3".$work_sheet}['TARGET'] : 0.00;
                                ${"totalTripsrow_3".$work_sheet}        = !empty(${"r_3".$work_sheet}['TRIPS']) ? ${"r_3".$work_sheet}['TRIPS'] : 0;
                                ${"totalMileagerow_3".$work_sheet}      = !empty(${"r_3".$work_sheet}['MILEAGE']) ? floatval(str_replace(',', '', ${"r_3".$work_sheet}['MILEAGE'])) : 0.00;
                                ${"totalLiterrow_3".$work_sheet}        = !empty(${"r_3".$work_sheet}['LITER']) ? floatval(str_replace(',', '', ${"r_3".$work_sheet}['LITER'])) : 0.00;
                                ${"actual_valuesrow_3".$work_sheet}     = [${"r_3".$work_sheet}['ACTUAL']];
                                ${"totalActualrow_3".$work_sheet}       = !empty(${"actual_valuesrow_3".$work_sheet}) ? array_sum(${"actual_valuesrow_3".$work_sheet}) / count(${"actual_valuesrow_3".$work_sheet}) : 0;
                                ${"min_valuesrow_3".$work_sheet}        = [${"r_3".$work_sheet}['MIN'] === '9,999,999,999.00' ? 0.00 : ${"r_3".$work_sheet}['MIN']];
                                ${"totalMinrow_3".$work_sheet}          = !empty(${"min_valuesrow_3".$work_sheet}) ? array_sum(${"min_valuesrow_3".$work_sheet}) / count(${"min_valuesrow_3".$work_sheet}) : 0;
                                ${"max_valuesrow_3".$work_sheet}        = [${"r_3".$work_sheet}['MAX'] === '-9,999,999,999.00' ? 0.00 : ${"r_3".$work_sheet}['MAX']];
                                ${"totalMaxrow_3".$work_sheet}          = !empty(${"max_valuesrow_3".$work_sheet}) ? array_sum(${"max_valuesrow_3".$work_sheet}) / count(${"max_valuesrow_3".$work_sheet}) : 0;
                                ${"totalOkrow_3".$work_sheet}           = !empty(${"r_3".$work_sheet}['OK']) ? ${"r_3".$work_sheet}['OK'] : 0;
                                ${"totalNgrow_3".$work_sheet}           = !empty(${"r_3".$work_sheet}['NG']) ? ${"r_3".$work_sheet}['NG'] : 0;
                                ${"percentage_valuesrow_3".$work_sheet} = [${"r_3".$work_sheet}['PERCENTAGE']];
                                ${"totalPercentagerow_3".$work_sheet}   = !empty(${"percentage_valuesrow_3".$work_sheet}) ? array_sum(${"percentage_valuesrow_3".$work_sheet}) / count(${"percentage_valuesrow_3".$work_sheet}) : 0;
                                ${"totalDriverrow_3".$work_sheet}       = !empty(${"r_3".$work_sheet}['DRIVER']) ? floatval(str_replace(',', '', ${"r_3".$work_sheet}['DRIVER'])) : 0.00;

                                ${"totalTargetrow_4".$work_sheet}       = !empty(${"r_4".$work_sheet}['TARGET']) ? ${"r_4".$work_sheet}['TARGET'] : 0.00;
                                ${"totalTripsrow_4".$work_sheet}        = !empty(${"r_4".$work_sheet}['TRIPS']) ? ${"r_4".$work_sheet}['TRIPS'] : 0;
                                ${"totalMileagerow_4".$work_sheet}      = !empty(${"r_4".$work_sheet}['MILEAGE']) ? floatval(str_replace(',', '', ${"r_4".$work_sheet}['MILEAGE'])) : 0.00;
                                ${"totalLiterrow_4".$work_sheet}        = !empty(${"r_4".$work_sheet}['LITER']) ? floatval(str_replace(',', '', ${"r_4".$work_sheet}['LITER'])) : 0.00;
                                ${"actual_valuesrow_4".$work_sheet}     = [${"r_4".$work_sheet}['ACTUAL']];
                                ${"totalActualrow_4".$work_sheet}       = !empty(${"actual_valuesrow_4".$work_sheet}) ? array_sum(${"actual_valuesrow_4".$work_sheet}) / count(${"actual_valuesrow_4".$work_sheet}) : 0;
                                ${"min_valuesrow_4".$work_sheet}        = [${"r_4".$work_sheet}['MIN'] === '9,999,999,999.00' ? 0.00 : ${"r_4".$work_sheet}['MIN']];
                                ${"totalMinrow_4".$work_sheet}          = !empty(${"min_valuesrow_4".$work_sheet}) ? array_sum(${"min_valuesrow_4".$work_sheet}) / count(${"min_valuesrow_4".$work_sheet}) : 0;
                                ${"max_valuesrow_4".$work_sheet}        = [${"r_4".$work_sheet}['MAX'] === '-9,999,999,999.00' ? 0.00 : ${"r_4".$work_sheet}['MAX']];
                                ${"totalMaxrow_4".$work_sheet}          = !empty(${"max_valuesrow_4".$work_sheet}) ? array_sum(${"max_valuesrow_4".$work_sheet}) / count(${"max_valuesrow_4".$work_sheet}) : 0;
                                ${"totalOkrow_4".$work_sheet}           = !empty(${"r_4".$work_sheet}['OK']) ? ${"r_4".$work_sheet}['OK'] : 0;
                                ${"totalNgrow_4".$work_sheet}           = !empty(${"r_4".$work_sheet}['NG']) ? ${"r_4".$work_sheet}['NG'] : 0;
                                ${"percentage_valuesrow_4".$work_sheet} = [${"r_4".$work_sheet}['PERCENTAGE']];
                                ${"totalPercentagerow_4".$work_sheet}   = !empty(${"percentage_valuesrow_4".$work_sheet}) ? array_sum(${"percentage_valuesrow_4".$work_sheet}) / count(${"percentage_valuesrow_4".$work_sheet}) : 0;
                                ${"totalDriverrow_4".$work_sheet}       = !empty(${"r_4".$work_sheet}['DRIVER']) ? floatval(str_replace(',', '', ${"r_4".$work_sheet}['DRIVER'])) : 0.00;

                                ${"totalTargetrow_5".$work_sheet}       = !empty(${"r_5".$work_sheet}['TARGET']) ? ${"r_5".$work_sheet}['TARGET'] : 0.00;
                                ${"totalTripsrow_5".$work_sheet}        = !empty(${"r_5".$work_sheet}['TRIPS']) ? ${"r_5".$work_sheet}['TRIPS'] : 0;
                                ${"totalMileagerow_5".$work_sheet}      = !empty(${"r_5".$work_sheet}['MILEAGE']) ? floatval(str_replace(',', '', ${"r_5".$work_sheet}['MILEAGE'])) : 0.00;
                                ${"totalLiterrow_5".$work_sheet}        = !empty(${"r_5".$work_sheet}['LITER']) ? floatval(str_replace(',', '', ${"r_5".$work_sheet}['LITER'])) : 0.00;
                                ${"actual_valuesrow_5".$work_sheet}     = [${"r_5".$work_sheet}['ACTUAL']];
                                ${"totalActualrow_5".$work_sheet}       = !empty(${"actual_valuesrow_5".$work_sheet}) ? array_sum(${"actual_valuesrow_5".$work_sheet}) / count(${"actual_valuesrow_5".$work_sheet}) : 0;
                                ${"min_valuesrow_5".$work_sheet}        = [${"r_5".$work_sheet}['MIN'] === '9,999,999,999.00' ? 0.00 : ${"r_5".$work_sheet}['MIN']];
                                ${"totalMinrow_5".$work_sheet}          = !empty(${"min_valuesrow_5".$work_sheet}) ? array_sum(${"min_valuesrow_5".$work_sheet}) / count(${"min_valuesrow_5".$work_sheet}) : 0;
                                ${"max_valuesrow_5".$work_sheet}        = [${"r_5".$work_sheet}['MAX'] === '-9,999,999,999.00' ? 0.00 : ${"r_5".$work_sheet}['MAX']];
                                ${"totalMaxrow_5".$work_sheet}          = !empty(${"max_valuesrow_5".$work_sheet}) ? array_sum(${"max_valuesrow_5".$work_sheet}) / count(${"max_valuesrow_5".$work_sheet}) : 0;
                                ${"totalOkrow_5".$work_sheet}           = !empty(${"r_5".$work_sheet}['OK']) ? ${"r_5".$work_sheet}['OK'] : 0;
                                ${"totalNgrow_5".$work_sheet}           = !empty(${"r_5".$work_sheet}['NG']) ? ${"r_5".$work_sheet}['NG'] : 0;
                                ${"percentage_valuesrow_5".$work_sheet} = [${"r_5".$work_sheet}['PERCENTAGE']];
                                ${"totalPercentagerow_5".$work_sheet}   = !empty(${"percentage_valuesrow_5".$work_sheet}) ? array_sum(${"percentage_valuesrow_5".$work_sheet}) / count(${"percentage_valuesrow_5".$work_sheet}) : 0;
                                ${"totalDriverrow_5".$work_sheet}       = !empty(${"r_5".$work_sheet}['DRIVER']) ? floatval(str_replace(',', '', ${"r_5".$work_sheet}['DRIVER'])) : 0.00;
                                
                                ${"total2groub_2".$work_sheet}          = ${"totalTripsrow_2".$work_sheet}+${"totalTripsrow_3".$work_sheet}+${"totalTripsrow_4".$work_sheet}+${"totalTripsrow_5".$work_sheet};
                                ${"total3groub_2".$work_sheet}          = ${"totalMileagerow_2".$work_sheet}+${"totalMileagerow_3".$work_sheet}+${"totalMileagerow_4".$work_sheet}+${"totalMileagerow_5".$work_sheet};
                                ${"total4groub_2".$work_sheet}          = ${"totalLiterrow_2".$work_sheet}+${"totalLiterrow_3".$work_sheet}+${"totalLiterrow_4".$work_sheet}+${"totalLiterrow_5".$work_sheet};
                                ${"total5groub_2".$work_sheet}          = (${"totalActualrow_2".$work_sheet}+${"totalActualrow_3".$work_sheet}+${"totalActualrow_4".$work_sheet}+${"totalActualrow_5".$work_sheet}) / 4;
                                ${"total6groub_2".$work_sheet}          = (${"totalMinrow_2".$work_sheet}+${"totalMinrow_3".$work_sheet}+${"totalMinrow_4".$work_sheet}+${"totalMinrow_5".$work_sheet}) / 4;
                                ${"total7groub_2".$work_sheet}          = (${"totalMaxrow_2".$work_sheet}+${"totalMaxrow_3".$work_sheet}+${"totalMaxrow_4".$work_sheet}+${"totalMaxrow_5".$work_sheet}) / 4;
                                ${"total8groub_2".$work_sheet}          = ${"totalOkrow_2".$work_sheet}+${"totalOkrow_3".$work_sheet}+${"totalOkrow_4".$work_sheet}+${"totalOkrow_5".$work_sheet};
                                ${"total9groub_2".$work_sheet}          = ${"totalNgrow_2".$work_sheet}+${"totalNgrow_3".$work_sheet}+${"totalNgrow_4".$work_sheet}+${"totalNgrow_5".$work_sheet};
                                ${"total10groub_2".$work_sheet}         = round((${"totalPercentagerow_2".$work_sheet}+${"totalPercentagerow_3".$work_sheet}+${"totalPercentagerow_4".$work_sheet}+${"totalPercentagerow_5".$work_sheet})/4);
                                ${"total11groub_2".$work_sheet}         = ${"totalDriverrow_2".$work_sheet}+${"totalDriverrow_3".$work_sheet}+${"totalDriverrow_4".$work_sheet}+${"totalDriverrow_5".$work_sheet};
                            
                            // Total_3
                                ${"totalTargetrow_6".$work_sheet}       = !empty(${"r_6".$work_sheet}['TARGET']) ? ${"r_6".$work_sheet}['TARGET'] : 0.00;
                                ${"totalTripsrow_6".$work_sheet}        = !empty(${"r_6".$work_sheet}['TRIPS']) ? ${"r_6".$work_sheet}['TRIPS'] : 0;
                                ${"totalMileagerow_6".$work_sheet}      = !empty(${"r_6".$work_sheet}['MILEAGE']) ? floatval(str_replace(',', '', ${"r_6".$work_sheet}['MILEAGE'])) : 0.00;
                                ${"totalLiterrow_6".$work_sheet}        = !empty(${"r_6".$work_sheet}['LITER']) ? floatval(str_replace(',', '', ${"r_6".$work_sheet}['LITER'])) : 0.00;
                                ${"actual_valuesrow_6".$work_sheet}     = [${"r_6".$work_sheet}['ACTUAL']];
                                ${"totalActualrow_6".$work_sheet}       = !empty(${"actual_valuesrow_6".$work_sheet}) ? array_sum(${"actual_valuesrow_6".$work_sheet}) / count(${"actual_valuesrow_6".$work_sheet}) : 0;
                                ${"min_valuesrow_6".$work_sheet}        = [${"r_6".$work_sheet}['MIN'] === '9,999,999,999.00' ? 0.00 : ${"r_6".$work_sheet}['MIN']];
                                ${"totalMinrow_6".$work_sheet}          = !empty(${"min_valuesrow_6".$work_sheet}) ? array_sum(${"min_valuesrow_6".$work_sheet}) / count(${"min_valuesrow_6".$work_sheet}) : 0;
                                ${"max_valuesrow_6".$work_sheet}        = [${"r_6".$work_sheet}['MAX'] === '-9,999,999,999.00' ? 0.00 : ${"r_6".$work_sheet}['MAX']];
                                ${"totalMaxrow_6".$work_sheet}          = !empty(${"max_valuesrow_6".$work_sheet}) ? array_sum(${"max_valuesrow_6".$work_sheet}) / count(${"max_valuesrow_6".$work_sheet}) : 0;
                                ${"totalOkrow_6".$work_sheet}           = !empty(${"r_6".$work_sheet}['OK']) ? ${"r_6".$work_sheet}['OK'] : 0;
                                ${"totalNgrow_6".$work_sheet}           = !empty(${"r_6".$work_sheet}['NG']) ? ${"r_6".$work_sheet}['NG'] : 0;
                                ${"percentage_valuesrow_6".$work_sheet} = [${"r_6".$work_sheet}['PERCENTAGE']];
                                ${"totalPercentagerow_6".$work_sheet}   = !empty(${"percentage_valuesrow_6".$work_sheet}) ? array_sum(${"percentage_valuesrow_6".$work_sheet}) / count(${"percentage_valuesrow_6".$work_sheet}) : 0;
                                ${"totalDriverrow_6".$work_sheet}       = !empty(${"r_6".$work_sheet}['DRIVER']) ? floatval(str_replace(',', '', ${"r_6".$work_sheet}['DRIVER'])) : 0.00;

                                ${"total2groub_3".$work_sheet}          = ${"totalTripsrow_6".$work_sheet};
                                ${"total3groub_3".$work_sheet}          = ${"totalMileagerow_6".$work_sheet};
                                ${"total4groub_3".$work_sheet}          = ${"totalLiterrow_6".$work_sheet};
                                ${"total5groub_3".$work_sheet}          = ${"totalActualrow_6".$work_sheet};
                                ${"total6groub_3".$work_sheet}          = ${"totalMinrow_6".$work_sheet} ;
                                ${"total7groub_3".$work_sheet}          = ${"totalMaxrow_6".$work_sheet};
                                ${"total8groub_3".$work_sheet}          = ${"totalOkrow_6".$work_sheet};
                                ${"total9groub_3".$work_sheet}          = ${"totalNgrow_6".$work_sheet};
                                ${"total10groub_3".$work_sheet}         = round(${"totalPercentagerow_6".$work_sheet});
                                ${"total11groub_3".$work_sheet}         = ${"totalDriverrow_6".$work_sheet};
                            
                            // Total_4
                                ${"totalTargetrow_7".$work_sheet}       = !empty(${"r_7".$work_sheet}['TARGET']) ? ${"r_7".$work_sheet}['TARGET'] : 0.00;
                                ${"totalTripsrow_7".$work_sheet}        = !empty(${"r_7".$work_sheet}['TRIPS']) ? ${"r_7".$work_sheet}['TRIPS'] : 0;
                                ${"totalMileagerow_7".$work_sheet}      = !empty(${"r_7".$work_sheet}['MILEAGE']) ? floatval(str_replace(',', '', ${"r_7".$work_sheet}['MILEAGE'])) : 0.00;
                                ${"totalLiterrow_7".$work_sheet}        = !empty(${"r_7".$work_sheet}['LITER']) ? floatval(str_replace(',', '', ${"r_7".$work_sheet}['LITER'])) : 0.00;
                                ${"actual_valuesrow_7".$work_sheet}     = [${"r_7".$work_sheet}['ACTUAL']];
                                ${"totalActualrow_7".$work_sheet}       = !empty(${"actual_valuesrow_7".$work_sheet}) ? array_sum(${"actual_valuesrow_7".$work_sheet}) / count(${"actual_valuesrow_7".$work_sheet}) : 0;
                                ${"min_valuesrow_7".$work_sheet}        = [${"r_7".$work_sheet}['MIN'] === '9,999,999,999.00' ? 0.00 : ${"r_7".$work_sheet}['MIN']];
                                ${"totalMinrow_7".$work_sheet}          = !empty(${"min_valuesrow_7".$work_sheet}) ? array_sum(${"min_valuesrow_7".$work_sheet}) / count(${"min_valuesrow_7".$work_sheet}) : 0;
                                ${"max_valuesrow_7".$work_sheet}        = [${"r_7".$work_sheet}['MAX'] === '-9,999,999,999.00' ? 0.00 : ${"r_7".$work_sheet}['MAX']];
                                ${"totalMaxrow_7".$work_sheet}          = !empty(${"max_valuesrow_7".$work_sheet}) ? array_sum(${"max_valuesrow_7".$work_sheet}) / count(${"max_valuesrow_7".$work_sheet}) : 0;
                                ${"totalOkrow_7".$work_sheet}           = !empty(${"r_7".$work_sheet}['OK']) ? ${"r_7".$work_sheet}['OK'] : 0;
                                ${"totalNgrow_7".$work_sheet}           = !empty(${"r_7".$work_sheet}['NG']) ? ${"r_7".$work_sheet}['NG'] : 0;
                                ${"percentage_valuesrow_7".$work_sheet} = [${"r_7".$work_sheet}['PERCENTAGE']];
                                ${"totalPercentagerow_7".$work_sheet}   = !empty(${"percentage_valuesrow_7".$work_sheet}) ? array_sum(${"percentage_valuesrow_7".$work_sheet}) / count(${"percentage_valuesrow_7".$work_sheet}) : 0;
                                ${"totalDriverrow_7".$work_sheet}       = !empty(${"r_7".$work_sheet}['DRIVER']) ? floatval(str_replace(',', '', ${"r_7".$work_sheet}['DRIVER'])) : 0.00;

                                ${"totalTargetrow_8".$work_sheet}       = !empty(${"r_8".$work_sheet}['TARGET']) ? ${"r_8".$work_sheet}['TARGET'] : 0.00;
                                ${"totalTripsrow_8".$work_sheet}        = !empty(${"r_8".$work_sheet}['TRIPS']) ? ${"r_8".$work_sheet}['TRIPS'] : 0;
                                ${"totalMileagerow_8".$work_sheet}      = !empty(${"r_8".$work_sheet}['MILEAGE']) ? floatval(str_replace(',', '', ${"r_8".$work_sheet}['MILEAGE'])) : 0.00;
                                ${"totalLiterrow_8".$work_sheet}        = !empty(${"r_8".$work_sheet}['LITER']) ? floatval(str_replace(',', '', ${"r_8".$work_sheet}['LITER'])) : 0.00;
                                ${"actual_valuesrow_8".$work_sheet}     = [${"r_8".$work_sheet}['ACTUAL']];
                                ${"totalActualrow_8".$work_sheet}       = !empty(${"actual_valuesrow_8".$work_sheet}) ? array_sum(${"actual_valuesrow_8".$work_sheet}) / count(${"actual_valuesrow_8".$work_sheet}) : 0;
                                ${"min_valuesrow_8".$work_sheet}        = [${"r_8".$work_sheet}['MIN'] === '9,999,999,999.00' ? 0.00 : ${"r_8".$work_sheet}['MIN']];
                                ${"totalMinrow_8".$work_sheet}          = !empty(${"min_valuesrow_8".$work_sheet}) ? array_sum(${"min_valuesrow_8".$work_sheet}) / count(${"min_valuesrow_8".$work_sheet}) : 0;
                                ${"max_valuesrow_8".$work_sheet}        = [${"r_8".$work_sheet}['MAX'] === '-9,999,999,999.00' ? 0.00 : ${"r_8".$work_sheet}['MAX']];
                                ${"totalMaxrow_8".$work_sheet}          = !empty(${"max_valuesrow_8".$work_sheet}) ? array_sum(${"max_valuesrow_8".$work_sheet}) / count(${"max_valuesrow_8".$work_sheet}) : 0;
                                ${"totalOkrow_8".$work_sheet}           = !empty(${"r_8".$work_sheet}['OK']) ? ${"r_8".$work_sheet}['OK'] : 0;
                                ${"totalNgrow_8".$work_sheet}           = !empty(${"r_8".$work_sheet}['NG']) ? ${"r_8".$work_sheet}['NG'] : 0;
                                ${"percentage_valuesrow_8".$work_sheet} = [${"r_8".$work_sheet}['PERCENTAGE']];
                                ${"totalPercentagerow_8".$work_sheet}   = !empty(${"percentage_valuesrow_8".$work_sheet}) ? array_sum(${"percentage_valuesrow_8".$work_sheet}) / count(${"percentage_valuesrow_8".$work_sheet}) : 0;
                                ${"totalDriverrow_8".$work_sheet}       = !empty(${"r_8".$work_sheet}['DRIVER']) ? floatval(str_replace(',', '', ${"r_8".$work_sheet}['DRIVER'])) : 0.00;
                            
                                ${"total2groub_4".$work_sheet}          = ${"totalTripsrow_7".$work_sheet}+${"totalTripsrow_8".$work_sheet};
                                ${"total3groub_4".$work_sheet}          = ${"totalMileagerow_7".$work_sheet}+${"totalMileagerow_8".$work_sheet};
                                ${"total4groub_4".$work_sheet}          = ${"totalLiterrow_7".$work_sheet}+${"totalLiterrow_8".$work_sheet};
                                ${"total5groub_4".$work_sheet}          = (${"totalActualrow_7".$work_sheet}+${"totalActualrow_8".$work_sheet}) / 2;
                                ${"total6groub_4".$work_sheet}          = (${"totalMinrow_7".$work_sheet}+${"totalMinrow_8".$work_sheet}) / 2;
                                ${"total7groub_4".$work_sheet}          = (${"totalMaxrow_7".$work_sheet}+${"totalMaxrow_8".$work_sheet}) / 2;
                                ${"total8groub_4".$work_sheet}          = ${"totalOkrow_7".$work_sheet}+${"totalOkrow_8".$work_sheet};
                                ${"total9groub_4".$work_sheet}          = ${"totalNgrow_7".$work_sheet}+${"totalNgrow_8".$work_sheet};
                                ${"total10groub_4".$work_sheet}         = round((${"totalPercentagerow_7".$work_sheet}+${"totalPercentagerow_8".$work_sheet})/2);
                                ${"total11groub_4".$work_sheet}         = ${"totalDriverrow_7".$work_sheet}+${"totalDriverrow_8".$work_sheet};

                            // Total_5
                                ${"totalTargetrow_9".$work_sheet}       = !empty(${"r_9".$work_sheet}['TARGET']) ? ${"r_9".$work_sheet}['TARGET'] : 0.00;
                                ${"totalTripsrow_9".$work_sheet}        = !empty(${"r_9".$work_sheet}['TRIPS']) ? ${"r_9".$work_sheet}['TRIPS'] : 0;
                                ${"totalMileagerow_9".$work_sheet}      = !empty(${"r_9".$work_sheet}['MILEAGE']) ? floatval(str_replace(',', '', ${"r_9".$work_sheet}['MILEAGE'])) : 0.00;
                                ${"totalLiterrow_9".$work_sheet}        = !empty(${"r_9".$work_sheet}['LITER']) ? floatval(str_replace(',', '', ${"r_9".$work_sheet}['LITER'])) : 0.00;
                                ${"actual_valuesrow_9".$work_sheet}     = [${"r_9".$work_sheet}['ACTUAL']];
                                ${"totalActualrow_9".$work_sheet}       = !empty(${"actual_valuesrow_9".$work_sheet}) ? array_sum(${"actual_valuesrow_9".$work_sheet}) / count(${"actual_valuesrow_9".$work_sheet}) : 0;
                                ${"min_valuesrow_9".$work_sheet}        = [${"r_9".$work_sheet}['MIN'] === '9,999,999,999.00' ? 0.00 : ${"r_9".$work_sheet}['MIN']];
                                ${"totalMinrow_9".$work_sheet}          = !empty(${"min_valuesrow_9".$work_sheet}) ? array_sum(${"min_valuesrow_9".$work_sheet}) / count(${"min_valuesrow_9".$work_sheet}) : 0;
                                ${"max_valuesrow_9".$work_sheet}        = [${"r_9".$work_sheet}['MAX'] === '-9,999,999,999.00' ? 0.00 : ${"r_9".$work_sheet}['MAX']];
                                ${"totalMaxrow_9".$work_sheet}          = !empty(${"max_valuesrow_9".$work_sheet}) ? array_sum(${"max_valuesrow_9".$work_sheet}) / count(${"max_valuesrow_9".$work_sheet}) : 0;
                                ${"totalOkrow_9".$work_sheet}           = !empty(${"r_9".$work_sheet}['OK']) ? ${"r_9".$work_sheet}['OK'] : 0;    
                                ${"totalNgrow_9".$work_sheet}           = !empty(${"r_9".$work_sheet}['NG']) ? ${"r_9".$work_sheet}['NG'] : 0;
                                ${"percentage_valuesrow_9".$work_sheet} = [${"r_9".$work_sheet}['PERCENTAGE']];
                                ${"totalPercentagerow_9".$work_sheet}   = !empty(${"percentage_valuesrow_9".$work_sheet}) ? array_sum(${"percentage_valuesrow_9".$work_sheet}) / count(${"percentage_valuesrow_9".$work_sheet}) : 0;
                                ${"totalDriverrow_9".$work_sheet}       = !empty(${"r_9".$work_sheet}['DRIVER']) ? floatval(str_replace(',', '', ${"r_9".$work_sheet}['DRIVER'])) : 0.00;

                                ${"totalTargetrow_10".$work_sheet}      = !empty(${"r_10".$work_sheet}['TARGET']) ? ${"r_10".$work_sheet}['TARGET'] : 0.00;
                                ${"totalTripsrow_10".$work_sheet}       = !empty(${"r_10".$work_sheet}['TRIPS']) ? ${"r_10".$work_sheet}['TRIPS'] : 0;
                                ${"totalMileagerow_10".$work_sheet}     = !empty(${"r_10".$work_sheet}['MILEAGE']) ? floatval(str_replace(',', '', ${"r_10".$work_sheet}['MILEAGE'])) : 0.00;
                                ${"totalLiterrow_10".$work_sheet}       = !empty(${"r_10".$work_sheet}['LITER']) ? floatval(str_replace(',', '', ${"r_10".$work_sheet}['LITER'])) : 0.00;
                                ${"actual_valuesrow_10".$work_sheet}    = [${"r_10".$work_sheet}['ACTUAL']];
                                ${"totalActualrow_10".$work_sheet}      = !empty(${"actual_valuesrow_10".$work_sheet}) ? array_sum(${"actual_valuesrow_10".$work_sheet}) / count(${"actual_valuesrow_10".$work_sheet}) : 0;
                                ${"min_valuesrow_10".$work_sheet}       = [${"r_10".$work_sheet}['MIN'] === '9,999,999,999.00' ? 0.00 : ${"r_10".$work_sheet}['MIN']];
                                ${"totalMinrow_10".$work_sheet}         = !empty(${"min_valuesrow_10".$work_sheet}) ? array_sum(${"min_valuesrow_10".$work_sheet}) / count(${"min_valuesrow_10".$work_sheet}) : 0;
                                ${"max_valuesrow_10".$work_sheet}       = [${"r_10".$work_sheet}['MAX'] === '-9,999,999,999.00' ? 0.00 : ${"r_10".$work_sheet}['MAX']];
                                ${"totalMaxrow_10".$work_sheet}         = !empty(${"max_valuesrow_10".$work_sheet}) ? array_sum(${"max_valuesrow_10".$work_sheet}) / count(${"max_valuesrow_10".$work_sheet}) : 0;
                                ${"totalOkrow_10".$work_sheet}          = !empty(${"r_10".$work_sheet}['OK']) ? ${"r_10".$work_sheet}['OK'] : 0;
                                ${"totalNgrow_10".$work_sheet}          = !empty(${"r_10".$work_sheet}['NG']) ? ${"r_10".$work_sheet}['NG'] : 0;
                                ${"percentage_valuesrow_10".$work_sheet}= [${"r_10".$work_sheet}['PERCENTAGE']];
                                ${"totalPercentagerow_10".$work_sheet}  = !empty(${"percentage_valuesrow_10".$work_sheet}) ? array_sum(${"percentage_valuesrow_10".$work_sheet}) / count(${"percentage_valuesrow_10".$work_sheet}) : 0;
                                ${"totalDriverrow_10".$work_sheet}      = !empty(${"r_10".$work_sheet}['DRIVER']) ? floatval(str_replace(',', '', ${"r_10".$work_sheet}['DRIVER'])) : 0.00;

                                ${"totalTargetrow_11".$work_sheet}      = !empty(${"r_11".$work_sheet}['TARGET']) ? ${"r_11".$work_sheet}['TARGET'] : 0.00;
                                ${"totalTripsrow_11".$work_sheet}       = !empty(${"r_11".$work_sheet}['TRIPS']) ? ${"r_11".$work_sheet}['TRIPS'] : 0;
                                ${"totalMileagerow_11".$work_sheet}     = !empty(${"r_11".$work_sheet}['MILEAGE']) ? floatval(str_replace(',', '', ${"r_11".$work_sheet}['MILEAGE'])) : 0.00;
                                ${"totalLiterrow_11".$work_sheet}       = !empty(${"r_11".$work_sheet}['LITER']) ? floatval(str_replace(',', '', ${"r_11".$work_sheet}['LITER'])) : 0.00;
                                ${"actual_valuesrow_11".$work_sheet}    = [${"r_11".$work_sheet}['ACTUAL']];
                                ${"totalActualrow_11".$work_sheet}      = !empty(${"actual_valuesrow_11".$work_sheet}) ? array_sum(${"actual_valuesrow_11".$work_sheet}) / count(${"actual_valuesrow_11".$work_sheet}) : 0;
                                ${"min_valuesrow_11".$work_sheet}       = [${"r_11".$work_sheet}['MIN'] === '9,999,999,999.00' ? 0.00 : ${"r_11".$work_sheet}['MIN']];
                                ${"totalMinrow_11".$work_sheet}         = !empty(${"min_valuesrow_11".$work_sheet}) ? array_sum(${"min_valuesrow_11".$work_sheet}) / count(${"min_valuesrow_11".$work_sheet}) : 0;
                                ${"max_valuesrow_11".$work_sheet}       = [${"r_11".$work_sheet}['MAX'] === '-9,999,999,999.00' ? 0.00 : ${"r_11".$work_sheet}['MAX']];
                                ${"totalMaxrow_11".$work_sheet}         = !empty(${"max_valuesrow_11".$work_sheet}) ? array_sum(${"max_valuesrow_11".$work_sheet}) / count(${"max_valuesrow_11".$work_sheet}) : 0;
                                ${"totalOkrow_11".$work_sheet}          = !empty(${"r_11".$work_sheet}['OK']) ? ${"r_11".$work_sheet}['OK'] : 0;
                                ${"totalNgrow_11".$work_sheet}          = !empty(${"r_11".$work_sheet}['NG']) ? ${"r_11".$work_sheet}['NG'] : 0;
                                ${"percentage_valuesrow_11".$work_sheet}= [${"r_11".$work_sheet}['PERCENTAGE']];
                                ${"totalPercentagerow_11".$work_sheet}  = !empty(${"percentage_valuesrow_11".$work_sheet}) ? array_sum(${"percentage_valuesrow_11".$work_sheet}) / count(${"percentage_valuesrow_11".$work_sheet}) : 0;
                                ${"totalDriverrow_11".$work_sheet}      = !empty(${"r_11".$work_sheet}['DRIVER']) ? floatval(str_replace(',', '', ${"r_11".$work_sheet}['DRIVER'])) : 0.00;

                                ${"total2groub_5".$work_sheet}          = ${"totalTripsrow_9".$work_sheet}+${"totalTripsrow_10".$work_sheet}+${"totalTripsrow_11".$work_sheet};
                                ${"total3groub_5".$work_sheet}          = ${"totalMileagerow_9".$work_sheet}+${"totalMileagerow_10".$work_sheet}+${"totalMileagerow_11".$work_sheet};
                                ${"total4groub_5".$work_sheet}          = ${"totalLiterrow_9".$work_sheet}+${"totalLiterrow_10".$work_sheet}+${"totalLiterrow_11".$work_sheet};
                                ${"total5groub_5".$work_sheet}          = (${"totalActualrow_9".$work_sheet}+${"totalActualrow_10".$work_sheet}+${"totalActualrow_11".$work_sheet}) / 3;
                                ${"total6groub_5".$work_sheet}          = (${"totalMinrow_9".$work_sheet}+${"totalMinrow_10".$work_sheet}+${"totalMinrow_11".$work_sheet}) / 3;
                                ${"total7groub_5".$work_sheet}          = (${"totalMaxrow_9".$work_sheet}+${"totalMaxrow_10".$work_sheet}+${"totalMaxrow_11".$work_sheet}) / 3;
                                ${"total8groub_5".$work_sheet}          = ${"totalOkrow_9".$work_sheet}+${"totalOkrow_10".$work_sheet}+${"totalOkrow_11".$work_sheet};
                                ${"total9groub_5".$work_sheet}          = ${"totalNgrow_9".$work_sheet}+${"totalNgrow_10".$work_sheet}+${"totalNgrow_11".$work_sheet};
                                ${"total10groub_5".$work_sheet}         = round((${"totalPercentagerow_9".$work_sheet}+${"totalPercentagerow_10".$work_sheet}+${"totalPercentagerow_11".$work_sheet})/3);
                                ${"total11groub_5".$work_sheet}         = ${"totalDriverrow_9".$work_sheet}+${"totalDriverrow_10".$work_sheet}+${"totalDriverrow_11".$work_sheet};

                            // Total_6
                                ${"alltotal2".$work_sheet}              = ${"total2groub_1".$work_sheet} + ${"total2groub_2".$work_sheet} + ${"total2groub_3".$work_sheet} + ${"total2groub_4".$work_sheet} + ${"total2groub_5".$work_sheet};
                                ${"alltotal3".$work_sheet}              = ${"total3groub_1".$work_sheet} + ${"total3groub_2".$work_sheet} + ${"total3groub_3".$work_sheet} + ${"total3groub_4".$work_sheet} + ${"total3groub_5".$work_sheet};
                                ${"alltotal4".$work_sheet}              = ${"total4groub_1".$work_sheet} + ${"total4groub_2".$work_sheet} + ${"total4groub_3".$work_sheet} + ${"total4groub_4".$work_sheet} + ${"total4groub_5".$work_sheet};
                                ${"alltotal5".$work_sheet}              = (${"total5groub_1".$work_sheet} + ${"total5groub_2".$work_sheet} + ${"total5groub_3".$work_sheet} + ${"total5groub_4".$work_sheet} + ${"total5groub_5".$work_sheet}) / 5;
                                ${"alltotal6".$work_sheet}              = (${"total6groub_1".$work_sheet} + ${"total6groub_2".$work_sheet} + ${"total6groub_3".$work_sheet} + ${"total6groub_4".$work_sheet} + ${"total6groub_5".$work_sheet}) / 5;
                                ${"alltotal7".$work_sheet}              = (${"total7groub_1".$work_sheet} + ${"total7groub_2".$work_sheet} + ${"total7groub_3".$work_sheet} + ${"total7groub_4".$work_sheet} + ${"total7groub_5".$work_sheet}) / 5;
                                ${"alltotal8".$work_sheet}              = ${"total8groub_1".$work_sheet} + ${"total8groub_2".$work_sheet} + ${"total8groub_3".$work_sheet} + ${"total8groub_4".$work_sheet} + ${"total8groub_5".$work_sheet};
                                ${"alltotal9".$work_sheet}              = ${"total9groub_1".$work_sheet} + ${"total9groub_2".$work_sheet} + ${"total9groub_3".$work_sheet} + ${"total9groub_4".$work_sheet} + ${"total9groub_5".$work_sheet};
                                ${"alltotal10".$work_sheet}             = round((${"total10groub_1".$work_sheet} + ${"total10groub_2".$work_sheet} + ${"total10groub_3".$work_sheet} + ${"total10groub_4".$work_sheet} + ${"total10groub_5".$work_sheet}) / 5);
                                ${"alltotal11".$work_sheet}             = ${"total11groub_1".$work_sheet} + ${"total11groub_2".$work_sheet} + ${"total11groub_3".$work_sheet} + ${"total11groub_4".$work_sheet} + ${"total11groub_5".$work_sheet};

                        /* Table Width */ 
                            $sheet->getColumnDimension('A')->setWidth(15);
                            $sheet->getColumnDimension('B')->setWidth(10);
                            $sheet->getColumnDimension('C')->setWidth(15);
                            $sheet->getColumnDimension('D')->setWidth(10);
                            $sheet->getColumnDimension('E')->setWidth(15);
                            $sheet->getColumnDimension('F')->setWidth(10);
                            $sheet->getColumnDimension('G')->setWidth(10);
                            $sheet->getColumnDimension('H')->setWidth(10);
                            $sheet->getColumnDimension('I')->setWidth(10);
                            $sheet->getColumnDimension('J')->setWidth(10);
                            $sheet->getColumnDimension('K')->setWidth(10);
                            $sheet->getColumnDimension('L')->setWidth(10);
                            $sheet->getColumnDimension('M')->setWidth(20);
                        /* Table Border */
                            $sheet->getStyle('A4:M23')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        /* Table Center */ 
                            $objPHPExcel->getActiveSheet()->getStyle('A4:M6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('A7:C24')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('D7:D26')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('E7:F26')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                            $objPHPExcel->getActiveSheet()->getStyle('G7:K26')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('L7:M26')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        /* Table Style */
                            $sheet->getStyle('A7:M23')->applyFromArray(array('font' => array('bold' => true)));
                            $sheet->getStyle('J7:J25')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '0000FF'))));
                            $sheet->getStyle('K7:K25')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => 'FF0000'))));
                            $sheet->getStyle('B7:B23')->getNumberFormat()->setFormatCode('0.00');
                            $sheet->getStyle('E7:I23')->getNumberFormat()->setFormatCode('0.00');
                            $sheet->getStyle('M7:M23')->getNumberFormat()->setFormatCode('0.00');
                        /* Head Value */ 
                            $objPHPExcel->getActiveSheet()->
                            setCellValue('A4', 'Type')->
                            setCellValue('B4', 'Target')->
                            setCellValue('C4', 'Route')->
                            setCellValue('D4', 'Trips')->
                            setCellValue('E4', $chkday.' '.$startm[1].' '.$starty)->
                            setCellValue('E5', 'Mileage')->
                            setCellValue('F5', 'Average(KM/Liter)')->
                            setCellValue('F6', 'Liter')->
                            setCellValue('G6', 'Actual')->
                            setCellValue('H6', 'Min')->
                            setCellValue('I6', 'Max')->
                            setCellValue('J5', 'Result')->
                            setCellValue('J6', 'OK')->
                            setCellValue('K6', 'NG')->
                            setCellValue('L5', '%')->
                            setCellValue('M5', 'Allowance(Bath)')->
                            setCellValue('M6', 'Driver');
                        /* HEAD Merge */ 
                            $objPHPExcel->getActiveSheet()->mergeCells('A4:A6');
                            $objPHPExcel->getActiveSheet()->mergeCells('B4:B6');
                            $objPHPExcel->getActiveSheet()->mergeCells('C4:C6');
                            $objPHPExcel->getActiveSheet()->mergeCells('D4:D6');
                            $objPHPExcel->getActiveSheet()->mergeCells('E4:M4');
                            $objPHPExcel->getActiveSheet()->mergeCells('E5:E6');
                            $objPHPExcel->getActiveSheet()->mergeCells('F5:I5');
                            $objPHPExcel->getActiveSheet()->mergeCells('J5:K5');
                            $objPHPExcel->getActiveSheet()->mergeCells('L5:L6');
                        /* HEAD Style */
                            $sheet->getStyle('A4:M6')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D3D3D3')),'font' => array('bold' => true)));

                        /* 6W */
                            $objPHPExcel->getActiveSheet()->setCellValue('A7','6W');
                            $objPHPExcel->getActiveSheet()->setCellValue('B7', number_format(${"totalTargetrow_1".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('C7','TGT');
                            $objPHPExcel->getActiveSheet()->setCellValue('D7', number_format(${"totalTripsrow_1".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('E7', number_format(${"totalMileagerow_1".$work_sheet},2));                      
                            $objPHPExcel->getActiveSheet()->setCellValue('F7', number_format(${"totalLiterrow_1".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('G7', number_format(${"totalActualrow_1".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('H7', number_format(${"totalMinrow_1".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('I7', number_format(${"totalMaxrow_1".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('J7', number_format(${"totalOkrow_1".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('K7', number_format(${"totalNgrow_1".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('L7', number_format(${"totalPercentagerow_1".$work_sheet}).'%');
                            $objPHPExcel->getActiveSheet()->setCellValue('M7', number_format(${"totalDriverrow_1".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('B8','Total');
                            $objPHPExcel->getActiveSheet()->setCellValue('D8', number_format(${"total2groub_1".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('E8', number_format(${"total3groub_1".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('F8', number_format(${"total4groub_1".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('G8', number_format(${"total5groub_1".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('H8', number_format(${"total6groub_1".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('I8', number_format(${"total7groub_1".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('J8', number_format(${"total8groub_1".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('K8', number_format(${"total9groub_1".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('L8', number_format(${"total10groub_1".$work_sheet}).'%');
                            $objPHPExcel->getActiveSheet()->setCellValue('M8', number_format(${"total11groub_1".$work_sheet},2));

                        /* 6W Merge */ 
                            $objPHPExcel->getActiveSheet()->mergeCells('A7:A8');
                            $objPHPExcel->getActiveSheet()->mergeCells('B8:C8');
                        /* 6W Style */
                            $sheet->getStyle('B8:M8')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D3D3D3')),'font' => array('bold' => true)));
                            $objPHPExcel->getActiveSheet()->getStyle('B8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVERTICAL(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                        /* 10W */
                            $objPHPExcel->getActiveSheet()->setCellValue('A9','10W');
                            $objPHPExcel->getActiveSheet()->setCellValue('B9', number_format(${"totalTargetrow_2".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('C9','STM-SR');
                            $objPHPExcel->getActiveSheet()->setCellValue('D9', number_format(${"totalTripsrow_2".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('E9', number_format(${"totalMileagerow_2".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('F9', number_format(${"totalLiterrow_2".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('G9', number_format(${"totalActualrow_2".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('H9', number_format(${"totalMinrow_2".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('I9', number_format(${"totalMaxrow_2".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('J9', number_format(${"totalOkrow_2".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('K9', number_format(${"totalNgrow_2".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('L9', number_format(${"totalPercentagerow_2".$work_sheet}).'%');
                            $objPHPExcel->getActiveSheet()->setCellValue('M9', number_format(${"totalDriverrow_2".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('B10', number_format(${"totalTargetrow_3".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('C10','T.TOHKEN');
                            $objPHPExcel->getActiveSheet()->setCellValue('D10', number_format(${"totalTripsrow_3".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('E10', number_format(${"totalMileagerow_3".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('F10', number_format(${"totalLiterrow_3".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('G10', number_format(${"totalActualrow_3".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('H10', number_format(${"totalMinrow_3".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('I10', number_format(${"totalMaxrow_3".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('J10', number_format(${"totalOkrow_3".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('K10', number_format(${"totalNgrow_3".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('L10', number_format(${"totalPercentagerow_3".$work_sheet}).'%');
                            $objPHPExcel->getActiveSheet()->setCellValue('M10', number_format(${"totalDriverrow_3".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('B11', number_format(${"totalTargetrow_4".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('C11','STC');
                            $objPHPExcel->getActiveSheet()->setCellValue('D11', number_format(${"totalTripsrow_4".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('E11', number_format(${"totalMileagerow_4".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('F11', number_format(${"totalLiterrow_4".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('G11', number_format(${"totalActualrow_4".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('H11', number_format(${"totalMinrow_4".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('I11', number_format(${"totalMaxrow_4".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('J11', number_format(${"totalOkrow_4".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('K11', number_format(${"totalNgrow_4".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('L11', number_format(${"totalPercentagerow_4".$work_sheet}).'%');
                            $objPHPExcel->getActiveSheet()->setCellValue('M11', number_format(${"totalDriverrow_4".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('B12', number_format(${"totalTargetrow_5".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('C12','CS');
                            $objPHPExcel->getActiveSheet()->setCellValue('D12', number_format(${"totalTripsrow_5".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('E12', number_format(${"totalMileagerow_5".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('F12', number_format(${"totalLiterrow_5".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('G12', number_format(${"totalActualrow_5".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('H12', number_format(${"totalMinrow_5".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('I12', number_format(${"totalMaxrow_5".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('J12', number_format(${"totalOkrow_5".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('K12', number_format(${"totalNgrow_5".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('L12', number_format(${"totalPercentagerow_5".$work_sheet}).'%');
                            $objPHPExcel->getActiveSheet()->setCellValue('M12', number_format(${"totalDriverrow_5".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('B13','Total');
                            $objPHPExcel->getActiveSheet()->setCellValue('D13', number_format(${"total2groub_2".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('E13', number_format(${"total3groub_2".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('F13', number_format(${"total4groub_2".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('G13', number_format(${"total5groub_2".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('H13', number_format(${"total6groub_2".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('I13', number_format(${"total7groub_2".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('J13', number_format(${"total8groub_2".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('K13', number_format(${"total9groub_2".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('L13', number_format(${"total10groub_2".$work_sheet}).'%');
                            $objPHPExcel->getActiveSheet()->setCellValue('M13', number_format(${"total11groub_2".$work_sheet},2));
                        /* 10W Merge */ 
                            $objPHPExcel->getActiveSheet()->mergeCells('A9:A13');
                            $objPHPExcel->getActiveSheet()->mergeCells('B13:C13');
                        /* 10W Style */
                            $sheet->getStyle('B13:M13')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D3D3D3')),'font' => array('bold' => true)));
                            $objPHPExcel->getActiveSheet()->getStyle('B13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVERTICAL(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        
                        /* 6W TL */
                            $objPHPExcel->getActiveSheet()->setCellValue('A14','6W TL');
                            $objPHPExcel->getActiveSheet()->setCellValue('B14', number_format(${"totalTargetrow_6".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('C14','KUBOTA');
                            $objPHPExcel->getActiveSheet()->setCellValue('D14', number_format(${"totalTripsrow_6".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('E14', number_format(${"totalMileagerow_6".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('F14', number_format(${"totalLiterrow_6".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('G14', number_format(${"totalActualrow_6".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('H14', number_format(${"totalMinrow_6".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('I14', number_format(${"totalMaxrow_6".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('J14', number_format(${"totalOkrow_6".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('K14', number_format(${"totalNgrow_6".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('L14', number_format(${"totalPercentagerow_6".$work_sheet}).'%');
                            $objPHPExcel->getActiveSheet()->setCellValue('M14', number_format(${"totalDriverrow_6".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('B15','Total');
                            $objPHPExcel->getActiveSheet()->setCellValue('D15', number_format(${"total2groub_3".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('E15', number_format(${"total3groub_3".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('F15', number_format(${"total4groub_3".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('G15', number_format(${"total5groub_3".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('H15', number_format(${"total6groub_3".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('I15', number_format(${"total7groub_3".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('J15', number_format(${"total8groub_3".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('K15', number_format(${"total9groub_3".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('L15', number_format(${"total10groub_3".$work_sheet}).'%');
                            $objPHPExcel->getActiveSheet()->setCellValue('M15', number_format(${"total11groub_3".$work_sheet},2));
                        /* 6W TL Merge */ 
                            $objPHPExcel->getActiveSheet()->mergeCells('A14:A15');
                            $objPHPExcel->getActiveSheet()->mergeCells('B15:C15');
                        /* 6W TL Style */
                            $sheet->getStyle('B15:M15')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D3D3D3')),'font' => array('bold' => true)));
                            $objPHPExcel->getActiveSheet()->getStyle('B15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVERTICAL(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                                                
                        /* 10W TL */
                            $objPHPExcel->getActiveSheet()->setCellValue('A16','10W TL');
                            $objPHPExcel->getActiveSheet()->setCellValue('B16', number_format(${"totalTargetrow_7".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('C16','STC-TL');
                            $objPHPExcel->getActiveSheet()->setCellValue('D16', number_format(${"totalTripsrow_7".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('E16', number_format(${"totalMileagerow_7".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('F16', number_format(${"totalLiterrow_7".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('G16', number_format(${"totalActualrow_7".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('H16', number_format(${"totalMinrow_7".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('I16', number_format(${"totalMaxrow_7".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('J16', number_format(${"totalOkrow_7".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('K16', number_format(${"totalNgrow_7".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('L16', number_format(${"totalPercentagerow_7".$work_sheet}).'%');
                            $objPHPExcel->getActiveSheet()->setCellValue('M16', number_format(${"totalDriverrow_7".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('B17', number_format(${"totalTargetrow_8".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('C17','KUBOTA');
                            $objPHPExcel->getActiveSheet()->setCellValue('D17', number_format(${"totalTripsrow_8".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('E17', number_format(${"totalMileagerow_8".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('F17', number_format(${"totalLiterrow_8".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('G17', number_format(${"totalActualrow_8".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('H17', number_format(${"totalMinrow_8".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('I17', number_format(${"totalMaxrow_8".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('J17', number_format(${"totalOkrow_8".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('K17', number_format(${"totalNgrow_8".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('L17', number_format(${"totalPercentagerow_8".$work_sheet}).'%');
                            $objPHPExcel->getActiveSheet()->setCellValue('M17', number_format(${"totalDriverrow_8".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('B18','Total');
                            $objPHPExcel->getActiveSheet()->setCellValue('D18', number_format(${"total2groub_4".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('E18', number_format(${"total3groub_4".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('F18', number_format(${"total4groub_4".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('G18', number_format(${"total5groub_4".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('H18', number_format(${"total6groub_4".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('I18', number_format(${"total7groub_4".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('J18', number_format(${"total8groub_4".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('K18', number_format(${"total9groub_4".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('L18', number_format(${"total10groub_4".$work_sheet}).'%');
                            $objPHPExcel->getActiveSheet()->setCellValue('M18', number_format(${"total11groub_4".$work_sheet},2));
                        /* 10W TL Merge */ 
                            $objPHPExcel->getActiveSheet()->mergeCells('A16:A18');
                            $objPHPExcel->getActiveSheet()->mergeCells('B18:C18');
                        /* 10W TL Style */
                            $sheet->getStyle('B18:M18')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D3D3D3')),'font' => array('bold' => true)));
                            $objPHPExcel->getActiveSheet()->getStyle('B18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVERTICAL(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                                          
                        /* Amata */
                            $objPHPExcel->getActiveSheet()->setCellValue('A19','Amata');
                            $objPHPExcel->getActiveSheet()->setCellValue('B19', number_format(${"totalTargetrow_9".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('C19','DAIKI');
                            $objPHPExcel->getActiveSheet()->setCellValue('D19', number_format(${"totalTripsrow_9".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('E19', number_format(${"totalMileagerow_9".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('F19', number_format(${"totalLiterrow_9".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('G19', number_format(${"totalActualrow_9".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('H19', number_format(${"totalMinrow_9".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('I19', number_format(${"totalMaxrow_9".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('J19', number_format(${"totalOkrow_9".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('K19', number_format(${"totalNgrow_9".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('L19', number_format(${"totalPercentagerow_9".$work_sheet}).'%');
                            $objPHPExcel->getActiveSheet()->setCellValue('M19', number_format(${"totalDriverrow_9".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('B20', number_format(${"totalTargetrow_10".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('C20','STC 10W');
                            $objPHPExcel->getActiveSheet()->setCellValue('D20', number_format(${"totalTripsrow_10".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('E20', number_format(${"totalMileagerow_10".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('F20', number_format(${"totalLiterrow_10".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('G20', number_format(${"totalActualrow_10".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('H20', number_format(${"totalMinrow_10".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('I20', number_format(${"totalMaxrow_10".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('J20', number_format(${"totalOkrow_10".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('K20', number_format(${"totalNgrow_10".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('L20', number_format(${"totalPercentagerow_10".$work_sheet}).'%');
                            $objPHPExcel->getActiveSheet()->setCellValue('M20', number_format(${"totalDriverrow_10".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('B21', number_format(${"totalTargetrow_10".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('C21','STC-TL');
                            $objPHPExcel->getActiveSheet()->setCellValue('D21', number_format(${"totalTripsrow_11".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('E21', number_format(${"totalMileagerow_11".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('F21', number_format(${"totalLiterrow_11".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('G21', number_format(${"totalActualrow_11".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('H21', number_format(${"totalMinrow_11".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('I21', number_format(${"totalMaxrow_11".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('J21', number_format(${"totalOkrow_11".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('K21', number_format(${"totalNgrow_11".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('L21', number_format(${"totalPercentagerow_11".$work_sheet}).'%');
                            $objPHPExcel->getActiveSheet()->setCellValue('M21', number_format(${"totalDriverrow_11".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('B22','Total');
                            $objPHPExcel->getActiveSheet()->setCellValue('D22', number_format(${"total2groub_5".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('E22', number_format(${"total3groub_5".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('F22', number_format(${"total4groub_5".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('G22', number_format(${"total5groub_5".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('H22', number_format(${"total6groub_5".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('I22', number_format(${"total7groub_5".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('J22', number_format(${"total8groub_5".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('K22', number_format(${"total9groub_5".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('L22', number_format(${"total10groub_5".$work_sheet}).'%');
                            $objPHPExcel->getActiveSheet()->setCellValue('M22', number_format(${"total11groub_5".$work_sheet},2));
                        /* Amata Merge */ 
                            $objPHPExcel->getActiveSheet()->mergeCells('A19:A22');
                            $objPHPExcel->getActiveSheet()->mergeCells('B22:C22');
                        /* Amata Style */
                            $sheet->getStyle('A19:A22')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF00')),'font' => array('bold' => true)));
                            $sheet->getStyle('B22:M22')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF00')),'font' => array('bold' => true)));
                            $sheet->getStyle('B19:M21')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF99')),'font' => array('bold' => true)));
                            $objPHPExcel->getActiveSheet()->getStyle('B22')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVERTICAL(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        
                        /* Total */
                            $objPHPExcel->getActiveSheet()->setCellValue('A23','Total All Type');
                            $objPHPExcel->getActiveSheet()->setCellValue('D23', number_format(${"alltotal2".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('E23', number_format(${"alltotal3".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('F23', number_format(${"alltotal4".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('G23', number_format(${"alltotal5".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('H23', number_format(${"alltotal6".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('I23', number_format(${"alltotal7".$work_sheet},2));
                            $objPHPExcel->getActiveSheet()->setCellValue('J23', number_format(${"alltotal8".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('K23', number_format(${"alltotal9".$work_sheet},0));
                            $objPHPExcel->getActiveSheet()->setCellValue('L23', number_format(${"alltotal10".$work_sheet},0).'%');
                            $objPHPExcel->getActiveSheet()->setCellValue('M23', number_format(${"alltotal11".$work_sheet},2));
                        /* Total Merge */ 
                            $objPHPExcel->getActiveSheet()->mergeCells('A23:C23');
                        /* Total Style */
                            $sheet->getStyle('A23:M23')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D3D3D3')),'font' => array('bold' => true)));
                            $objPHPExcel->getActiveSheet()->getStyle('B23')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVERTICAL(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        /* Check SQL */
                            // $objPHPExcel->getActiveSheet()->setCellValue('A28', ${"s_1".$work_sheet});
                            // $objPHPExcel->getActiveSheet()->setCellValue('A29', ${"s_2".$work_sheet});
                            // $objPHPExcel->getActiveSheet()->setCellValue('A30', ${"s_3".$work_sheet});
                            // $objPHPExcel->getActiveSheet()->setCellValue('A31', ${"s_4".$work_sheet});
                            // $objPHPExcel->getActiveSheet()->setCellValue('A32', ${"s_5".$work_sheet});
                            // $objPHPExcel->getActiveSheet()->setCellValue('A33', ${"s_6".$work_sheet});
                            // $objPHPExcel->getActiveSheet()->setCellValue('A34', ${"s_7".$work_sheet});
                            // $objPHPExcel->getActiveSheet()->setCellValue('A35', ${"s_8".$work_sheet});
                            // $objPHPExcel->getActiveSheet()->setCellValue('A36', ${"s_9".$work_sheet});
                            // $objPHPExcel->getActiveSheet()->setCellValue('A37', ${"s_10".$work_sheet});
                            // $objPHPExcel->getActiveSheet()->setCellValue('A38', ${"s_11".$work_sheet});
                            // $objPHPExcel->getActiveSheet()->setCellValue('A39', ${"s_12".$work_sheet});
                            // $objPHPExcel->getActiveSheet()->setCellValue('A40', ${"s_13".$work_sheet});
                            // $objPHPExcel->getActiveSheet()->setCellValue('A41', ${"s_14".$work_sheet});

                    
                    /* Table_2 */
                        /* SQL QUERY */ 
                            $sql_low = "SELECT DISTINCT PSC,NAME,SURNAME,[SECTION],NUMBER,ROUTE,TYPE,MILE,TARGET,ACTUAL,CAUSE,CPNC,CUSCODE,WOTY,DWK,NUMBERROW FROM dbo.TEMP_OILAVERAGE_AMT_LOW WHERE DWK='$start_ymd_new' ORDER BY NUMBERROW ASC";
                            $query_low = sqlsrv_query($conn, $sql_low);
                        /* Table Width */ 
                            $sheet->getColumnDimension('O')->setWidth(10);
                            $sheet->getColumnDimension('P')->setWidth(20);
                            $sheet->getColumnDimension('Q')->setWidth(20);
                            $sheet->getColumnDimension('R')->setWidth(15);
                            $sheet->getColumnDimension('S')->setWidth(20);
                            $sheet->getColumnDimension('T')->setWidth(15);
                            $sheet->getColumnDimension('U')->setWidth(15);
                            $sheet->getColumnDimension('V')->setWidth(10);
                            $sheet->getColumnDimension('W')->setWidth(10);
                            $sheet->getColumnDimension('X')->setWidth(10);
                            $sheet->getColumnDimension('Y')->setWidth(25);
                        /* Table Border */
                            $sheet->getStyle('O4:Y5')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                        /* Table Center */ 
                            $objPHPExcel->getActiveSheet()->getStyle('O4:Y5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        /* Head Value */ 
                            $objPHPExcel->getActiveSheet()->
                            setCellValue('O4', 'รายชื่อผู้ที่ทำค่าเฉลี่ยต่ำกว่าเป้าหมาย');
                            $objPHPExcel->getActiveSheet()->
                            setCellValue('O5', 'Items')->
                            setCellValue('P5', 'Name')->
                            setCellValue('Q5', 'Surname')->
                            setCellValue('R5', 'Section')->
                            setCellValue('S5', 'Number of trip')->
                            setCellValue('T5', 'Route')->
                            setCellValue('U5', 'Types')->
                            setCellValue('V5', 'Mile')->
                            setCellValue('W5', 'Target')->
                            setCellValue('X5', 'Actual')->
                            setCellValue('Y5', 'Cause');
                        /* HEAD Merge */ 
                            $objPHPExcel->getActiveSheet()->mergeCells('O4:Y4');
                        /* HEAD Style */
                            $sheet->getStyle('O4')->applyFromArray(array('font' => array('bold' => true,'size' => 12)));
                            $sheet->getStyle('O4:Y5')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D3D3D3')),'font' => array('bold' => true)));
                        /* Employee Low */    
                            $i2 = 6;
                            $LOW = 1;
                            while($resule_low = sqlsrv_fetch_array($query_low, SQLSRV_FETCH_ASSOC)){
                                $objPHPExcel->getActiveSheet()->setCellValue('O'.$i2, $LOW);
                                $objPHPExcel->getActiveSheet()->setCellValue('P'.$i2, $resule_low['NAME']);
                                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i2, $resule_low['SURNAME']);
                                $objPHPExcel->getActiveSheet()->setCellValue('R'.$i2, $resule_low['SECTION']);
                                $objPHPExcel->getActiveSheet()->setCellValue('S'.$i2, $resule_low['NUMBER']);
                                $objPHPExcel->getActiveSheet()->setCellValue('T'.$i2, $resule_low['ROUTE']);
                                $objPHPExcel->getActiveSheet()->setCellValue('U'.$i2, $resule_low['TYPE']);
                                $objPHPExcel->getActiveSheet()->setCellValue('V'.$i2, $resule_low['MILE']);
                                $objPHPExcel->getActiveSheet()->setCellValue('W'.$i2, $resule_low['TARGET']);
                                $objPHPExcel->getActiveSheet()->setCellValue('X'.$i2, $resule_low['ACTUAL']);
                                $objPHPExcel->getActiveSheet()->setCellValue('Y'.$i2, $resule_low['CAUSE']);
                                
                                
                                $objPHPExcel->getActiveSheet()->getStyle('O'.$i2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle('P'.$i2.':Q'.$i2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVERTICAL(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                                $objPHPExcel->getActiveSheet()->getStyle('R'.$i2.':X'.$i2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle('Y'.$i2.':Y'.$i2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVERTICAL(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                                $sheet->getStyle('O'.$i2.':Y'.$i2)->applyFromArray(array('font' => array('bold' => true)));
                                $sheet->getStyle('W'.$i2.':X'.$i2)->getNumberFormat()->setFormatCode('0.00');
                                $sheet->getStyle('O'.$i2.':Y'.$i2)->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
                                $sheet->getStyle('W'.$i2)->applyFromArray(array('font' => array('color' => array('rgb' => '0000FF'))));
                                $sheet->getStyle('X'.$i2)->applyFromArray(array('font' => array('color' => array('rgb' => 'FF0000'))));
                            $LOW++;$i2++;
                            }   

                // CLOSE SECTION 
            $objPHPExcel->getActiveSheet()->setTitle($chkday);

        // END-------------------------------------------------------------------------------------------------------------------------------------------------

        // $objPHPExcel->setActiveSheetIndex(0);
        $work_sheet++;
    }

    $objPHPExcel->createSheet();   
    $objPHPExcel->setActiveSheetIndex($work_sheet);
    // OPEN SECTION
        $detail="สรุปยอดรวมค่าเฉลี่ยน้ำมันรายวัน ช่วงวันที่ ".$startsumth." ถึง ".$endsumth;
                        
        $objPHPExcel->getActiveSheet()->mergeCells('A1:Y1');
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->setCellValueByColumnAndRow(0,2,$detail);
        $sheet->mergeCells('A2:Y2');
        $objPHPExcel->getActiveSheet()->getStyle('A2:Y2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('A2:Y2')->applyFromArray(array('font' => array('bold' => true,'size' => 12)));

        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->setCellValueByColumnAndRow(0,3,'');
        $sheet->mergeCells('A3:Y3');
        $objPHPExcel->getActiveSheet()->getStyle('A3:Y3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objDrawing = new PHPExcel_Worksheet_HeaderFooterDrawing();
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->addImage($objDrawing, PHPExcel_Worksheet_HeaderFooter::IMAGE_HEADER_LEFT);
        $styleText = array('font'  => array('bold'  => false,'color' => array('rgb' => '000000'),'size'  => 10,'name'  => 'Verdana'));  
        $sheet->getDefaultStyle()->applyFromArray($styleText);
        /* SQL QUERY */ 
            $s2_1 = "SELECT DISTINCT CPNC,TYPE,TARGET,ROUTE,WOTY,SUM(CAST(TRIPS AS INT)) AS TOTAL_TRIPS,FORMAT(SUM(CAST(REPLACE(MILEAGE,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_MILEAGE,FORMAT(SUM(CAST(REPLACE(LITER,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_LITER,FORMAT(ROUND(AVG(CAST(REPLACE(ACTUAL,',','') AS DECIMAL(18,2))), 2),'N2') AS TOTAL_ACTUAL,ROUND(AVG(CASE WHEN [MIN] = '9,999,999,999.00' THEN NULL ELSE CAST([MIN] AS FLOAT) END), 2) AS TOTAL_MIN,ROUND(AVG(CASE WHEN [MAX] = '-9,999,999,999.00' THEN NULL ELSE CAST([MAX] AS FLOAT) END), 2) AS TOTAL_MAX,FORMAT(SUM(CAST(REPLACE(OK,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_OK,FORMAT(SUM(CAST(REPLACE(NG,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_NG,CONCAT(CAST(ROUND(AVG(CAST(REPLACE(REPLACE(PERCENTAGE,',',''),'%','') AS DECIMAL(18,2))),0) AS INT),'%') AS TOTAL_PERCENTAGE,FORMAT(SUM(CAST(REPLACE(DRIVER,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_DRIVER FROM dbo.TEMP_OILAVERAGE_AMT WHERE NUMBERROW='1' AND DWK BETWEEN '$startsumSQL' AND '$endsumSQL' GROUP BY CPNC,TYPE,TARGET,ROUTE,WOTY"; 
            $s2_2 = "SELECT DISTINCT CPNC,TYPE,TARGET,ROUTE,WOTY,SUM(CAST(TRIPS AS INT)) AS TOTAL_TRIPS,FORMAT(SUM(CAST(REPLACE(MILEAGE,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_MILEAGE,FORMAT(SUM(CAST(REPLACE(LITER,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_LITER,FORMAT(ROUND(AVG(CAST(REPLACE(ACTUAL,',','') AS DECIMAL(18,2))), 2),'N2') AS TOTAL_ACTUAL,ROUND(AVG(CASE WHEN [MIN] = '9,999,999,999.00' THEN NULL ELSE CAST([MIN] AS FLOAT) END), 2) AS TOTAL_MIN,ROUND(AVG(CASE WHEN [MAX] = '-9,999,999,999.00' THEN NULL ELSE CAST([MAX] AS FLOAT) END), 2) AS TOTAL_MAX,FORMAT(SUM(CAST(REPLACE(OK,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_OK,FORMAT(SUM(CAST(REPLACE(NG,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_NG,CONCAT(CAST(ROUND(AVG(CAST(REPLACE(REPLACE(PERCENTAGE,',',''),'%','') AS DECIMAL(18,2))),0) AS INT),'%') AS TOTAL_PERCENTAGE,FORMAT(SUM(CAST(REPLACE(DRIVER,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_DRIVER FROM dbo.TEMP_OILAVERAGE_AMT WHERE NUMBERROW='2' AND DWK BETWEEN '$startsumSQL' AND '$endsumSQL' GROUP BY CPNC,TYPE,TARGET,ROUTE,WOTY"; 
            $s2_3 = "SELECT DISTINCT CPNC,TYPE,TARGET,ROUTE,WOTY,SUM(CAST(TRIPS AS INT)) AS TOTAL_TRIPS,FORMAT(SUM(CAST(REPLACE(MILEAGE,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_MILEAGE,FORMAT(SUM(CAST(REPLACE(LITER,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_LITER,FORMAT(ROUND(AVG(CAST(REPLACE(ACTUAL,',','') AS DECIMAL(18,2))), 2),'N2') AS TOTAL_ACTUAL,ROUND(AVG(CASE WHEN [MIN] = '9,999,999,999.00' THEN NULL ELSE CAST([MIN] AS FLOAT) END), 2) AS TOTAL_MIN,ROUND(AVG(CASE WHEN [MAX] = '-9,999,999,999.00' THEN NULL ELSE CAST([MAX] AS FLOAT) END), 2) AS TOTAL_MAX,FORMAT(SUM(CAST(REPLACE(OK,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_OK,FORMAT(SUM(CAST(REPLACE(NG,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_NG,CONCAT(CAST(ROUND(AVG(CAST(REPLACE(REPLACE(PERCENTAGE,',',''),'%','') AS DECIMAL(18,2))),0) AS INT),'%') AS TOTAL_PERCENTAGE,FORMAT(SUM(CAST(REPLACE(DRIVER,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_DRIVER FROM dbo.TEMP_OILAVERAGE_AMT WHERE NUMBERROW='3' AND DWK BETWEEN '$startsumSQL' AND '$endsumSQL' GROUP BY CPNC,TYPE,TARGET,ROUTE,WOTY"; 
            $s2_4 = "SELECT DISTINCT CPNC,TYPE,TARGET,ROUTE,WOTY,SUM(CAST(TRIPS AS INT)) AS TOTAL_TRIPS,FORMAT(SUM(CAST(REPLACE(MILEAGE,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_MILEAGE,FORMAT(SUM(CAST(REPLACE(LITER,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_LITER,FORMAT(ROUND(AVG(CAST(REPLACE(ACTUAL,',','') AS DECIMAL(18,2))), 2),'N2') AS TOTAL_ACTUAL,ROUND(AVG(CASE WHEN [MIN] = '9,999,999,999.00' THEN NULL ELSE CAST([MIN] AS FLOAT) END), 2) AS TOTAL_MIN,ROUND(AVG(CASE WHEN [MAX] = '-9,999,999,999.00' THEN NULL ELSE CAST([MAX] AS FLOAT) END), 2) AS TOTAL_MAX,FORMAT(SUM(CAST(REPLACE(OK,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_OK,FORMAT(SUM(CAST(REPLACE(NG,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_NG,CONCAT(CAST(ROUND(AVG(CAST(REPLACE(REPLACE(PERCENTAGE,',',''),'%','') AS DECIMAL(18,2))),0) AS INT),'%') AS TOTAL_PERCENTAGE,FORMAT(SUM(CAST(REPLACE(DRIVER,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_DRIVER FROM dbo.TEMP_OILAVERAGE_AMT WHERE NUMBERROW='4' AND DWK BETWEEN '$startsumSQL' AND '$endsumSQL' GROUP BY CPNC,TYPE,TARGET,ROUTE,WOTY"; 
            $s2_5 = "SELECT DISTINCT CPNC,TYPE,TARGET,ROUTE,WOTY,SUM(CAST(TRIPS AS INT)) AS TOTAL_TRIPS,FORMAT(SUM(CAST(REPLACE(MILEAGE,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_MILEAGE,FORMAT(SUM(CAST(REPLACE(LITER,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_LITER,FORMAT(ROUND(AVG(CAST(REPLACE(ACTUAL,',','') AS DECIMAL(18,2))), 2),'N2') AS TOTAL_ACTUAL,ROUND(AVG(CASE WHEN [MIN] = '9,999,999,999.00' THEN NULL ELSE CAST([MIN] AS FLOAT) END), 2) AS TOTAL_MIN,ROUND(AVG(CASE WHEN [MAX] = '-9,999,999,999.00' THEN NULL ELSE CAST([MAX] AS FLOAT) END), 2) AS TOTAL_MAX,FORMAT(SUM(CAST(REPLACE(OK,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_OK,FORMAT(SUM(CAST(REPLACE(NG,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_NG,CONCAT(CAST(ROUND(AVG(CAST(REPLACE(REPLACE(PERCENTAGE,',',''),'%','') AS DECIMAL(18,2))),0) AS INT),'%') AS TOTAL_PERCENTAGE,FORMAT(SUM(CAST(REPLACE(DRIVER,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_DRIVER FROM dbo.TEMP_OILAVERAGE_AMT WHERE NUMBERROW='5' AND DWK BETWEEN '$startsumSQL' AND '$endsumSQL' GROUP BY CPNC,TYPE,TARGET,ROUTE,WOTY"; 
            $s2_6 = "SELECT DISTINCT CPNC,TYPE,TARGET,ROUTE,WOTY,SUM(CAST(TRIPS AS INT)) AS TOTAL_TRIPS,FORMAT(SUM(CAST(REPLACE(MILEAGE,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_MILEAGE,FORMAT(SUM(CAST(REPLACE(LITER,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_LITER,FORMAT(ROUND(AVG(CAST(REPLACE(ACTUAL,',','') AS DECIMAL(18,2))), 2),'N2') AS TOTAL_ACTUAL,ROUND(AVG(CASE WHEN [MIN] = '9,999,999,999.00' THEN NULL ELSE CAST([MIN] AS FLOAT) END), 2) AS TOTAL_MIN,ROUND(AVG(CASE WHEN [MAX] = '-9,999,999,999.00' THEN NULL ELSE CAST([MAX] AS FLOAT) END), 2) AS TOTAL_MAX,FORMAT(SUM(CAST(REPLACE(OK,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_OK,FORMAT(SUM(CAST(REPLACE(NG,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_NG,CONCAT(CAST(ROUND(AVG(CAST(REPLACE(REPLACE(PERCENTAGE,',',''),'%','') AS DECIMAL(18,2))),0) AS INT),'%') AS TOTAL_PERCENTAGE,FORMAT(SUM(CAST(REPLACE(DRIVER,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_DRIVER FROM dbo.TEMP_OILAVERAGE_AMT WHERE NUMBERROW='6' AND DWK BETWEEN '$startsumSQL' AND '$endsumSQL' GROUP BY CPNC,TYPE,TARGET,ROUTE,WOTY"; 
            $s2_7 = "SELECT DISTINCT CPNC,TYPE,TARGET,ROUTE,WOTY,SUM(CAST(TRIPS AS INT)) AS TOTAL_TRIPS,FORMAT(SUM(CAST(REPLACE(MILEAGE,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_MILEAGE,FORMAT(SUM(CAST(REPLACE(LITER,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_LITER,FORMAT(ROUND(AVG(CAST(REPLACE(ACTUAL,',','') AS DECIMAL(18,2))), 2),'N2') AS TOTAL_ACTUAL,ROUND(AVG(CASE WHEN [MIN] = '9,999,999,999.00' THEN NULL ELSE CAST([MIN] AS FLOAT) END), 2) AS TOTAL_MIN,ROUND(AVG(CASE WHEN [MAX] = '-9,999,999,999.00' THEN NULL ELSE CAST([MAX] AS FLOAT) END), 2) AS TOTAL_MAX,FORMAT(SUM(CAST(REPLACE(OK,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_OK,FORMAT(SUM(CAST(REPLACE(NG,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_NG,CONCAT(CAST(ROUND(AVG(CAST(REPLACE(REPLACE(PERCENTAGE,',',''),'%','') AS DECIMAL(18,2))),0) AS INT),'%') AS TOTAL_PERCENTAGE,FORMAT(SUM(CAST(REPLACE(DRIVER,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_DRIVER FROM dbo.TEMP_OILAVERAGE_AMT WHERE NUMBERROW='7' AND DWK BETWEEN '$startsumSQL' AND '$endsumSQL' GROUP BY CPNC,TYPE,TARGET,ROUTE,WOTY"; 
            $s2_8 = "SELECT DISTINCT CPNC,TYPE,TARGET,ROUTE,WOTY,SUM(CAST(TRIPS AS INT)) AS TOTAL_TRIPS,FORMAT(SUM(CAST(REPLACE(MILEAGE,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_MILEAGE,FORMAT(SUM(CAST(REPLACE(LITER,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_LITER,FORMAT(ROUND(AVG(CAST(REPLACE(ACTUAL,',','') AS DECIMAL(18,2))), 2),'N2') AS TOTAL_ACTUAL,ROUND(AVG(CASE WHEN [MIN] = '9,999,999,999.00' THEN NULL ELSE CAST([MIN] AS FLOAT) END), 2) AS TOTAL_MIN,ROUND(AVG(CASE WHEN [MAX] = '-9,999,999,999.00' THEN NULL ELSE CAST([MAX] AS FLOAT) END), 2) AS TOTAL_MAX,FORMAT(SUM(CAST(REPLACE(OK,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_OK,FORMAT(SUM(CAST(REPLACE(NG,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_NG,CONCAT(CAST(ROUND(AVG(CAST(REPLACE(REPLACE(PERCENTAGE,',',''),'%','') AS DECIMAL(18,2))),0) AS INT),'%') AS TOTAL_PERCENTAGE,FORMAT(SUM(CAST(REPLACE(DRIVER,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_DRIVER FROM dbo.TEMP_OILAVERAGE_AMT WHERE NUMBERROW='8' AND DWK BETWEEN '$startsumSQL' AND '$endsumSQL' GROUP BY CPNC,TYPE,TARGET,ROUTE,WOTY"; 
            $s2_9 = "SELECT DISTINCT CPNC,TYPE,TARGET,ROUTE,WOTY,SUM(CAST(TRIPS AS INT)) AS TOTAL_TRIPS,FORMAT(SUM(CAST(REPLACE(MILEAGE,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_MILEAGE,FORMAT(SUM(CAST(REPLACE(LITER,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_LITER,FORMAT(ROUND(AVG(CAST(REPLACE(ACTUAL,',','') AS DECIMAL(18,2))), 2),'N2') AS TOTAL_ACTUAL,ROUND(AVG(CASE WHEN [MIN] = '9,999,999,999.00' THEN NULL ELSE CAST([MIN] AS FLOAT) END), 2) AS TOTAL_MIN,ROUND(AVG(CASE WHEN [MAX] = '-9,999,999,999.00' THEN NULL ELSE CAST([MAX] AS FLOAT) END), 2) AS TOTAL_MAX,FORMAT(SUM(CAST(REPLACE(OK,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_OK,FORMAT(SUM(CAST(REPLACE(NG,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_NG,CONCAT(CAST(ROUND(AVG(CAST(REPLACE(REPLACE(PERCENTAGE,',',''),'%','') AS DECIMAL(18,2))),0) AS INT),'%') AS TOTAL_PERCENTAGE,FORMAT(SUM(CAST(REPLACE(DRIVER,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_DRIVER FROM dbo.TEMP_OILAVERAGE_AMT WHERE NUMBERROW='9' AND DWK BETWEEN '$startsumSQL' AND '$endsumSQL' GROUP BY CPNC,TYPE,TARGET,ROUTE,WOTY"; 
            $s2_10 = "SELECT DISTINCT CPNC,TYPE,TARGET,ROUTE,WOTY,SUM(CAST(TRIPS AS INT)) AS TOTAL_TRIPS,FORMAT(SUM(CAST(REPLACE(MILEAGE,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_MILEAGE,FORMAT(SUM(CAST(REPLACE(LITER,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_LITER,FORMAT(ROUND(AVG(CAST(REPLACE(ACTUAL,',','') AS DECIMAL(18,2))), 2),'N2') AS TOTAL_ACTUAL,ROUND(AVG(CASE WHEN [MIN] = '9,999,999,999.00' THEN NULL ELSE CAST([MIN] AS FLOAT) END), 2) AS TOTAL_MIN,ROUND(AVG(CASE WHEN [MAX] = '-9,999,999,999.00' THEN NULL ELSE CAST([MAX] AS FLOAT) END), 2) AS TOTAL_MAX,FORMAT(SUM(CAST(REPLACE(OK,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_OK,FORMAT(SUM(CAST(REPLACE(NG,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_NG,CONCAT(CAST(ROUND(AVG(CAST(REPLACE(REPLACE(PERCENTAGE,',',''),'%','') AS DECIMAL(18,2))),0) AS INT),'%') AS TOTAL_PERCENTAGE,FORMAT(SUM(CAST(REPLACE(DRIVER,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_DRIVER FROM dbo.TEMP_OILAVERAGE_AMT WHERE NUMBERROW='10' AND DWK BETWEEN '$startsumSQL' AND '$endsumSQL' GROUP BY CPNC,TYPE,TARGET,ROUTE,WOTY"; 
            $s2_11 = "SELECT DISTINCT CPNC,TYPE,TARGET,ROUTE,WOTY,SUM(CAST(TRIPS AS INT)) AS TOTAL_TRIPS,FORMAT(SUM(CAST(REPLACE(MILEAGE,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_MILEAGE,FORMAT(SUM(CAST(REPLACE(LITER,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_LITER,FORMAT(ROUND(AVG(CAST(REPLACE(ACTUAL,',','') AS DECIMAL(18,2))), 2),'N2') AS TOTAL_ACTUAL,ROUND(AVG(CASE WHEN [MIN] = '9,999,999,999.00' THEN NULL ELSE CAST([MIN] AS FLOAT) END), 2) AS TOTAL_MIN,ROUND(AVG(CASE WHEN [MAX] = '-9,999,999,999.00' THEN NULL ELSE CAST([MAX] AS FLOAT) END), 2) AS TOTAL_MAX,FORMAT(SUM(CAST(REPLACE(OK,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_OK,FORMAT(SUM(CAST(REPLACE(NG,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_NG,CONCAT(CAST(ROUND(AVG(CAST(REPLACE(REPLACE(PERCENTAGE,',',''),'%','') AS DECIMAL(18,2))),0) AS INT),'%') AS TOTAL_PERCENTAGE,FORMAT(SUM(CAST(REPLACE(DRIVER,',','') AS DECIMAL(18,2))),'N2') AS TOTAL_DRIVER FROM dbo.TEMP_OILAVERAGE_AMT WHERE NUMBERROW='11' AND DWK BETWEEN '$startsumSQL' AND '$endsumSQL' GROUP BY CPNC,TYPE,TARGET,ROUTE,WOTY"; 
            $q2_1 = sqlsrv_query($conn, $s2_1);$r2_1 = sqlsrv_fetch_array($q2_1, SQLSRV_FETCH_ASSOC);
            $q2_2 = sqlsrv_query($conn, $s2_2);$r2_2 = sqlsrv_fetch_array($q2_2, SQLSRV_FETCH_ASSOC);
            $q2_3 = sqlsrv_query($conn, $s2_3);$r2_3 = sqlsrv_fetch_array($q2_3, SQLSRV_FETCH_ASSOC);
            $q2_4 = sqlsrv_query($conn, $s2_4);$r2_4 = sqlsrv_fetch_array($q2_4, SQLSRV_FETCH_ASSOC);
            $q2_5 = sqlsrv_query($conn, $s2_5);$r2_5 = sqlsrv_fetch_array($q2_5, SQLSRV_FETCH_ASSOC);
            $q2_6 = sqlsrv_query($conn, $s2_6);$r2_6 = sqlsrv_fetch_array($q2_6, SQLSRV_FETCH_ASSOC);
            $q2_7 = sqlsrv_query($conn, $s2_7);$r2_7 = sqlsrv_fetch_array($q2_7, SQLSRV_FETCH_ASSOC);
            $q2_8 = sqlsrv_query($conn, $s2_8);$r2_8 = sqlsrv_fetch_array($q2_8, SQLSRV_FETCH_ASSOC);
            $q2_9 = sqlsrv_query($conn, $s2_9);$r2_9 = sqlsrv_fetch_array($q2_9, SQLSRV_FETCH_ASSOC);
            $q2_10 = sqlsrv_query($conn, $s2_10);$r2_10 = sqlsrv_fetch_array($q2_10, SQLSRV_FETCH_ASSOC);
            $q2_11 = sqlsrv_query($conn, $s2_11);$r2_11 = sqlsrv_fetch_array($q2_11, SQLSRV_FETCH_ASSOC);
            // Total
            for($i21=1;$i21<=14;$i21++){$TOTAL_TRIPS += floatval(str_replace(',','', ${"r2_".$i21}['TOTAL_TRIPS']));}
            for($i22=1;$i22<=14;$i22++){$TOTAL_MILEAGE += floatval(str_replace(',','', ${"r2_".$i22}['TOTAL_MILEAGE']));}
            for($i23=1;$i23<=14;$i23++){$TOTAL_LITER += floatval(str_replace(',','', ${"r2_".$i23}['TOTAL_LITER']));}
            for($i24=1;$i24<=14;$i24++){$TOTAL_ACTUAL += floatval(str_replace(',','', ${"r2_".$i24}['TOTAL_ACTUAL']));}
            for($i25=1;$i25<=14;$i25++){$TOTAL_MIN += floatval(str_replace(',','', ${"r2_".$i25}['TOTAL_MIN']));}
            for($i26=1;$i26<=14;$i26++){$TOTAL_MAX += floatval(str_replace(',','', ${"r2_".$i26}['TOTAL_MAX']));}
            for($i27=1;$i27<=14;$i27++){$TOTAL_OK += floatval(str_replace(',','', ${"r2_".$i27}['TOTAL_OK']));}
            for($i28=1;$i28<=14;$i28++){$TOTAL_NG += floatval(str_replace(',','', ${"r2_".$i28}['TOTAL_NG']));}
            for($i29=1;$i29<=14;$i29++){$TOTAL_PERCENTAGE += floatval(str_replace(',','', ${"r2_".$i29}['TOTAL_PERCENTAGE']));}
            for($i30=1;$i30<=14;$i30++){$TOTAL_DRIVER += floatval(str_replace(',','', ${"r2_".$i30}['TOTAL_DRIVER']));}
                

        /* Table Width */ 
            $sheet->getColumnDimension('A')->setWidth(15);
            $sheet->getColumnDimension('B')->setWidth(10);
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->getColumnDimension('D')->setWidth(10);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(10);
            $sheet->getColumnDimension('G')->setWidth(10);
            $sheet->getColumnDimension('H')->setWidth(10);
            $sheet->getColumnDimension('I')->setWidth(10);
            $sheet->getColumnDimension('J')->setWidth(10);
            $sheet->getColumnDimension('K')->setWidth(10);
            $sheet->getColumnDimension('L')->setWidth(10);
            $sheet->getColumnDimension('M')->setWidth(20);
        /* Table Border */
            $sheet->getStyle('A4:M18')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
        /* Table Center */ 
            $objPHPExcel->getActiveSheet()->getStyle('A4:M6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A7:B24')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('D7:D26')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('E7:F26')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('G7:K26')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVERTICAL(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('L7:M26')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVERTICAL(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        /* Table Style */
            $sheet->getStyle('A7:M18')->applyFromArray(array('font' => array('bold' => true)));
            $sheet->getStyle('B7:B18')->getNumberFormat()->setFormatCode('0.00');
            $sheet->getStyle('E7:I18')->getNumberFormat()->setFormatCode('0.00');
            $sheet->getStyle('M7:M18')->getNumberFormat()->setFormatCode('0.00');
        /* Head Value */ 
            $objPHPExcel->getActiveSheet()->
            setCellValue('A4', 'Type')->
            setCellValue('B4', 'Target')->
            setCellValue('C4', 'Route')->
            setCellValue('D4', 'Trips')->
            setCellValue('E4', $startsumen.' - '.$endsumen)->
            setCellValue('E5', 'Mileage')->
            setCellValue('F5', 'Average(KM/Liter)')->
            setCellValue('F6', 'Liter')->
            setCellValue('G6', 'Actual')->
            setCellValue('H6', 'Min')->
            setCellValue('I6', 'Max')->
            setCellValue('J5', 'Result')->
            setCellValue('J6', 'OK')->
            setCellValue('K6', 'NG')->
            setCellValue('L5', '%')->
            setCellValue('M5', 'Allowance(Bath)')->
            setCellValue('M6', 'Driver');
        /* HEAD Merge */ 
            $objPHPExcel->getActiveSheet()->mergeCells('A4:A6');
            $objPHPExcel->getActiveSheet()->mergeCells('B4:B6');
            $objPHPExcel->getActiveSheet()->mergeCells('C4:C6');
            $objPHPExcel->getActiveSheet()->mergeCells('D4:D6');
            $objPHPExcel->getActiveSheet()->mergeCells('E4:M4');
            $objPHPExcel->getActiveSheet()->mergeCells('E5:E6');
            $objPHPExcel->getActiveSheet()->mergeCells('F5:I5');
            $objPHPExcel->getActiveSheet()->mergeCells('J5:K5');
            $objPHPExcel->getActiveSheet()->mergeCells('L5:L6');
        /* HEAD Style */
            $sheet->getStyle('A4:M6')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D3D3D3')),'font' => array('bold' => true)));

        /* 6W */
            $objPHPExcel->getActiveSheet()->setCellValue('A7','6W');
            $objPHPExcel->getActiveSheet()->setCellValue('B7', $r2_1['TARGET']);
            $objPHPExcel->getActiveSheet()->setCellValue('C7','TGT');
            $objPHPExcel->getActiveSheet()->setCellValue('D7', $r2_1['TOTAL_TRIPS']);
            $objPHPExcel->getActiveSheet()->setCellValue('E7', $r2_1['TOTAL_MILEAGE']);                      
            $objPHPExcel->getActiveSheet()->setCellValue('F7', $r2_1['TOTAL_LITER']);
            $objPHPExcel->getActiveSheet()->setCellValue('G7', $r2_1['TOTAL_ACTUAL']);
            $objPHPExcel->getActiveSheet()->setCellValue('H7', $r2_1['TOTAL_MIN']);
            $objPHPExcel->getActiveSheet()->setCellValue('I7', $r2_1['TOTAL_MAX']);
            $objPHPExcel->getActiveSheet()->setCellValue('J7', $r2_1['TOTAL_OK']);
            $objPHPExcel->getActiveSheet()->setCellValue('K7', $r2_1['TOTAL_NG']);
            $objPHPExcel->getActiveSheet()->setCellValue('L7', $r2_1['TOTAL_PERCENTAGE']);
            $objPHPExcel->getActiveSheet()->setCellValue('M7', $r2_1['TOTAL_DRIVER']);
        /* 10W */
            $objPHPExcel->getActiveSheet()->setCellValue('A8','10W');
            $objPHPExcel->getActiveSheet()->setCellValue('B8', $r2_2['TARGET']);
            $objPHPExcel->getActiveSheet()->setCellValue('C8','STM-SR');
            $objPHPExcel->getActiveSheet()->setCellValue('D8', $r2_2['TOTAL_TRIPS']);
            $objPHPExcel->getActiveSheet()->setCellValue('E8', $r2_2['TOTAL_MILEAGE']);
            $objPHPExcel->getActiveSheet()->setCellValue('F8', $r2_2['TOTAL_LITER']);
            $objPHPExcel->getActiveSheet()->setCellValue('G8', $r2_2['TOTAL_ACTUAL']);
            $objPHPExcel->getActiveSheet()->setCellValue('H8', $r2_2['TOTAL_MIN']);
            $objPHPExcel->getActiveSheet()->setCellValue('I8', $r2_2['TOTAL_MAX']);
            $objPHPExcel->getActiveSheet()->setCellValue('J8', $r2_2['TOTAL_OK']);
            $objPHPExcel->getActiveSheet()->setCellValue('K8', $r2_2['TOTAL_NG']);
            $objPHPExcel->getActiveSheet()->setCellValue('L8', $r2_2['TOTAL_PERCENTAGE']);
            $objPHPExcel->getActiveSheet()->setCellValue('M8', $r2_2['TOTAL_DRIVER']);
            $objPHPExcel->getActiveSheet()->setCellValue('B9', $r2_3['TARGET']);
            $objPHPExcel->getActiveSheet()->setCellValue('C9','T.TOHKEN');
            $objPHPExcel->getActiveSheet()->setCellValue('D9', $r2_3['TOTAL_TRIPS']);
            $objPHPExcel->getActiveSheet()->setCellValue('E9', $r2_3['TOTAL_MILEAGE']);
            $objPHPExcel->getActiveSheet()->setCellValue('F9', $r2_3['TOTAL_LITER']);
            $objPHPExcel->getActiveSheet()->setCellValue('G9', $r2_3['TOTAL_ACTUAL']);
            $objPHPExcel->getActiveSheet()->setCellValue('H9', $r2_3['TOTAL_MIN']);
            $objPHPExcel->getActiveSheet()->setCellValue('I9', $r2_3['TOTAL_MAX']);
            $objPHPExcel->getActiveSheet()->setCellValue('J9', $r2_3['TOTAL_OK']);
            $objPHPExcel->getActiveSheet()->setCellValue('K9', $r2_3['TOTAL_NG']);
            $objPHPExcel->getActiveSheet()->setCellValue('L9', $r2_3['TOTAL_PERCENTAGE']);
            $objPHPExcel->getActiveSheet()->setCellValue('M9', $r2_3['TOTAL_DRIVER']);
            $objPHPExcel->getActiveSheet()->setCellValue('B10', $r2_4['TARGET']);
            $objPHPExcel->getActiveSheet()->setCellValue('C10','STC');
            $objPHPExcel->getActiveSheet()->setCellValue('D10', $r2_4['TOTAL_TRIPS']);
            $objPHPExcel->getActiveSheet()->setCellValue('E10', $r2_4['TOTAL_MILEAGE']);
            $objPHPExcel->getActiveSheet()->setCellValue('F10', $r2_4['TOTAL_LITER']);
            $objPHPExcel->getActiveSheet()->setCellValue('G10', $r2_4['TOTAL_ACTUAL']);
            $objPHPExcel->getActiveSheet()->setCellValue('H10', $r2_4['TOTAL_MIN']);
            $objPHPExcel->getActiveSheet()->setCellValue('I10', $r2_4['TOTAL_MAX']);
            $objPHPExcel->getActiveSheet()->setCellValue('J10', $r2_4['TOTAL_OK']);
            $objPHPExcel->getActiveSheet()->setCellValue('K10', $r2_4['TOTAL_NG']);
            $objPHPExcel->getActiveSheet()->setCellValue('L10', $r2_4['TOTAL_PERCENTAGE']);
            $objPHPExcel->getActiveSheet()->setCellValue('M10', $r2_4['TOTAL_DRIVER']);
            $objPHPExcel->getActiveSheet()->setCellValue('B11', $r2_5['TARGET']);
            $objPHPExcel->getActiveSheet()->setCellValue('C11','CS');
            $objPHPExcel->getActiveSheet()->setCellValue('D11', $r2_5['TOTAL_TRIPS']);
            $objPHPExcel->getActiveSheet()->setCellValue('E11', $r2_5['TOTAL_MILEAGE']);
            $objPHPExcel->getActiveSheet()->setCellValue('F11', $r2_5['TOTAL_LITER']);
            $objPHPExcel->getActiveSheet()->setCellValue('G11', $r2_5['TOTAL_ACTUAL']);
            $objPHPExcel->getActiveSheet()->setCellValue('H11', $r2_5['TOTAL_MIN']);
            $objPHPExcel->getActiveSheet()->setCellValue('I11', $r2_5['TOTAL_MAX']);
            $objPHPExcel->getActiveSheet()->setCellValue('J11', $r2_5['TOTAL_OK']);
            $objPHPExcel->getActiveSheet()->setCellValue('K11', $r2_5['TOTAL_NG']);
            $objPHPExcel->getActiveSheet()->setCellValue('L11', $r2_5['TOTAL_PERCENTAGE']);
            $objPHPExcel->getActiveSheet()->setCellValue('M11', $r2_5['TOTAL_DRIVER']);
        /* 10W Merge */ 
            $objPHPExcel->getActiveSheet()->mergeCells('A8:A11');
        /* 6W TL */
            $objPHPExcel->getActiveSheet()->setCellValue('A12','6W TL');
            $objPHPExcel->getActiveSheet()->setCellValue('B12', $r2_6['TARGET']);
            $objPHPExcel->getActiveSheet()->setCellValue('C12','KUBOTA');
            $objPHPExcel->getActiveSheet()->setCellValue('D12', $r2_6['TOTAL_TRIPS']);
            $objPHPExcel->getActiveSheet()->setCellValue('E12', $r2_6['TOTAL_MILEAGE']);
            $objPHPExcel->getActiveSheet()->setCellValue('F12', $r2_6['TOTAL_LITER']);
            $objPHPExcel->getActiveSheet()->setCellValue('G12', $r2_6['TOTAL_ACTUAL']);
            $objPHPExcel->getActiveSheet()->setCellValue('H12', $r2_6['TOTAL_MIN']);
            $objPHPExcel->getActiveSheet()->setCellValue('I12', $r2_6['TOTAL_MAX']);
            $objPHPExcel->getActiveSheet()->setCellValue('J12', $r2_6['TOTAL_OK']);
            $objPHPExcel->getActiveSheet()->setCellValue('K12', $r2_6['TOTAL_NG']);
            $objPHPExcel->getActiveSheet()->setCellValue('L12', $r2_6['TOTAL_PERCENTAGE']);
            $objPHPExcel->getActiveSheet()->setCellValue('M12', $r2_6['TOTAL_DRIVER']);
                   
        /* 10W TL */
            $objPHPExcel->getActiveSheet()->setCellValue('A13','10W TL');
            $objPHPExcel->getActiveSheet()->setCellValue('B13', $r2_7['TARGET']);
            $objPHPExcel->getActiveSheet()->setCellValue('C13','STC-TL');
            $objPHPExcel->getActiveSheet()->setCellValue('D13', $r2_7['TOTAL_TRIPS']);
            $objPHPExcel->getActiveSheet()->setCellValue('E13', $r2_7['TOTAL_MILEAGE']);
            $objPHPExcel->getActiveSheet()->setCellValue('F13', $r2_7['TOTAL_LITER']);
            $objPHPExcel->getActiveSheet()->setCellValue('G13', $r2_7['TOTAL_ACTUAL']);
            $objPHPExcel->getActiveSheet()->setCellValue('H13', $r2_7['TOTAL_MIN']);
            $objPHPExcel->getActiveSheet()->setCellValue('I13', $r2_7['TOTAL_MAX']);
            $objPHPExcel->getActiveSheet()->setCellValue('J13', $r2_7['TOTAL_OK']);
            $objPHPExcel->getActiveSheet()->setCellValue('K13', $r2_7['TOTAL_NG']);
            $objPHPExcel->getActiveSheet()->setCellValue('L13', $r2_7['TOTAL_PERCENTAGE']);
            $objPHPExcel->getActiveSheet()->setCellValue('M13', $r2_7['TOTAL_DRIVER']);
            $objPHPExcel->getActiveSheet()->setCellValue('B14', $r2_8['TARGET']);
            $objPHPExcel->getActiveSheet()->setCellValue('C14','KUBOTA');
            $objPHPExcel->getActiveSheet()->setCellValue('D14', $r2_8['TOTAL_TRIPS']);
            $objPHPExcel->getActiveSheet()->setCellValue('E14', $r2_8['TOTAL_MILEAGE']);
            $objPHPExcel->getActiveSheet()->setCellValue('F14', $r2_8['TOTAL_LITER']);
            $objPHPExcel->getActiveSheet()->setCellValue('G14', $r2_8['TOTAL_ACTUAL']);
            $objPHPExcel->getActiveSheet()->setCellValue('H14', $r2_8['TOTAL_MIN']);
            $objPHPExcel->getActiveSheet()->setCellValue('I14', $r2_8['TOTAL_MAX']);
            $objPHPExcel->getActiveSheet()->setCellValue('J14', $r2_8['TOTAL_OK']);
            $objPHPExcel->getActiveSheet()->setCellValue('K14', $r2_8['TOTAL_NG']);
            $objPHPExcel->getActiveSheet()->setCellValue('L14', $r2_8['TOTAL_PERCENTAGE']);
            $objPHPExcel->getActiveSheet()->setCellValue('M14', $r2_8['TOTAL_DRIVER']);
        /* 10W TL Merge */ 
            $objPHPExcel->getActiveSheet()->mergeCells('A13:A14');
        
        /* Amata */
            $objPHPExcel->getActiveSheet()->setCellValue('A15','Amata');
            $objPHPExcel->getActiveSheet()->setCellValue('B15', $r2_9['TARGET']);
            $objPHPExcel->getActiveSheet()->setCellValue('C15','DAIKI');
            $objPHPExcel->getActiveSheet()->setCellValue('D15', $r2_9['TOTAL_TRIPS']);
            $objPHPExcel->getActiveSheet()->setCellValue('E15', $r2_9['TOTAL_MILEAGE']);
            $objPHPExcel->getActiveSheet()->setCellValue('F15', $r2_9['TOTAL_LITER']);
            $objPHPExcel->getActiveSheet()->setCellValue('G15', $r2_9['TOTAL_ACTUAL']);
            $objPHPExcel->getActiveSheet()->setCellValue('H15', $r2_9['TOTAL_MIN']);
            $objPHPExcel->getActiveSheet()->setCellValue('I15', $r2_9['TOTAL_MAX']);
            $objPHPExcel->getActiveSheet()->setCellValue('J15', $r2_9['TOTAL_OK']);
            $objPHPExcel->getActiveSheet()->setCellValue('K15', $r2_9['TOTAL_NG']);
            $objPHPExcel->getActiveSheet()->setCellValue('L15', $r2_9['TOTAL_PERCENTAGE']);
            $objPHPExcel->getActiveSheet()->setCellValue('M15', $r2_9['TOTAL_DRIVER']);
            $objPHPExcel->getActiveSheet()->setCellValue('B16', $r2_10['TARGET']);
            $objPHPExcel->getActiveSheet()->setCellValue('C16','STC 10W');
            $objPHPExcel->getActiveSheet()->setCellValue('D16', $r2_10['TOTAL_TRIPS']);
            $objPHPExcel->getActiveSheet()->setCellValue('E16', $r2_10['TOTAL_MILEAGE']);
            $objPHPExcel->getActiveSheet()->setCellValue('F16', $r2_10['TOTAL_LITER']);
            $objPHPExcel->getActiveSheet()->setCellValue('G16', $r2_10['TOTAL_ACTUAL']);
            $objPHPExcel->getActiveSheet()->setCellValue('H16', $r2_10['TOTAL_MIN']);
            $objPHPExcel->getActiveSheet()->setCellValue('I16', $r2_10['TOTAL_MAX']);
            $objPHPExcel->getActiveSheet()->setCellValue('J16', $r2_10['TOTAL_OK']);
            $objPHPExcel->getActiveSheet()->setCellValue('K16', $r2_10['TOTAL_NG']);
            $objPHPExcel->getActiveSheet()->setCellValue('L16', $r2_10['TOTAL_PERCENTAGE']);
            $objPHPExcel->getActiveSheet()->setCellValue('M16', $r2_10['TOTAL_DRIVER']);
            $objPHPExcel->getActiveSheet()->setCellValue('B17', $r2_11['TARGET']);
            $objPHPExcel->getActiveSheet()->setCellValue('C17','STC-TL');
            $objPHPExcel->getActiveSheet()->setCellValue('D17', $r2_11['TOTAL_TRIPS']);
            $objPHPExcel->getActiveSheet()->setCellValue('E17', $r2_11['TOTAL_MILEAGE']);
            $objPHPExcel->getActiveSheet()->setCellValue('F17', $r2_11['TOTAL_LITER']);
            $objPHPExcel->getActiveSheet()->setCellValue('G17', $r2_11['TOTAL_ACTUAL']);
            $objPHPExcel->getActiveSheet()->setCellValue('H17', $r2_11['TOTAL_MIN']);
            $objPHPExcel->getActiveSheet()->setCellValue('I17', $r2_11['TOTAL_MAX']);
            $objPHPExcel->getActiveSheet()->setCellValue('J17', $r2_11['TOTAL_OK']);
            $objPHPExcel->getActiveSheet()->setCellValue('K17', $r2_11['TOTAL_NG']);
            $objPHPExcel->getActiveSheet()->setCellValue('L17', $r2_11['TOTAL_PERCENTAGE']);
            $objPHPExcel->getActiveSheet()->setCellValue('M17', $r2_11['TOTAL_DRIVER']);
        /* Amata Merge */ 
            $objPHPExcel->getActiveSheet()->mergeCells('A15:A17');
        
        /* Total */
            $objPHPExcel->getActiveSheet()->setCellValue('A18','Total All Type');
            $objPHPExcel->getActiveSheet()->setCellValue('D18', number_format($TOTAL_TRIPS, 0));
            $objPHPExcel->getActiveSheet()->setCellValue('E18', number_format($TOTAL_MILEAGE, 0));
            $objPHPExcel->getActiveSheet()->setCellValue('F18', number_format($TOTAL_LITER, 0));
            $objPHPExcel->getActiveSheet()->setCellValue('G18', number_format($TOTAL_ACTUAL, 0));
            $objPHPExcel->getActiveSheet()->setCellValue('H18', round($TOTAL_MIN / 14, 2));
            $objPHPExcel->getActiveSheet()->setCellValue('I18', round($TOTAL_MAX / 14, 2));
            $objPHPExcel->getActiveSheet()->setCellValue('J18', $TOTAL_OK);
            $objPHPExcel->getActiveSheet()->setCellValue('K18', $TOTAL_NG);
            $objPHPExcel->getActiveSheet()->setCellValue('L18', number_format(round($TOTAL_PERCENTAGE / 14, 2), 0).'%');
            $objPHPExcel->getActiveSheet()->setCellValue('M18', number_format($TOTAL_DRIVER, 2));

        /* Total Merge */ 
            $objPHPExcel->getActiveSheet()->mergeCells('A18:C18');
        /* Total Style */
            $sheet->getStyle('A18:M18')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D3D3D3')),'font' => array('bold' => true)));
            $objPHPExcel->getActiveSheet()->getStyle('B18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVERTICAL(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        /* Check SQL */
            // $objPHPExcel->getActiveSheet()->setCellValue('A28',$s2_1);
            // $objPHPExcel->getActiveSheet()->setCellValue('A29',$s2_2);
            // $objPHPExcel->getActiveSheet()->setCellValue('A30',$s2_3);
            // $objPHPExcel->getActiveSheet()->setCellValue('A31',$s2_4);
            // $objPHPExcel->getActiveSheet()->setCellValue('A32',$s2_5);
            // $objPHPExcel->getActiveSheet()->setCellValue('A33',$s2_6);
            // $objPHPExcel->getActiveSheet()->setCellValue('A34',$s2_7);
            // $objPHPExcel->getActiveSheet()->setCellValue('A35',$s2_8);
            // $objPHPExcel->getActiveSheet()->setCellValue('A36',$s2_9);
            // $objPHPExcel->getActiveSheet()->setCellValue('A37',$s2_10);
            // $objPHPExcel->getActiveSheet()->setCellValue('A38',$s2_11);
            // $objPHPExcel->getActiveSheet()->setCellValue('A39',$s2_12);
            // $objPHPExcel->getActiveSheet()->setCellValue('A40',$s2_13);
            // $objPHPExcel->getActiveSheet()->setCellValue('A41',$s2_14);
    // CLOSE SECTION 
    $objPHPExcel->getActiveSheet()->setTitle('SUMMARY');


    $RENAME= "สรุปค่าเฉลี่ยน้ำมันรายวัน $date1 ถึง $date2";
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=$RENAME.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
    $objWriter->save('php://output');
    sqlsrv_close($conn);
?>