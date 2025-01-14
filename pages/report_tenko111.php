<?php

function db_connect() {
    $coninfo = array("Database" => "RKADB", "UID" => "sa", "PWD" => 'tm$wa01', "MultipleActiveResultSets" => true, "CharacterSet" => 'UTF-8');
    $conn = sqlsrv_connect("203.150.29.241\SQLEXPRESS,1433", $coninfo);

    if ($conn) {
        return $conn;
    } else {
        return die(print_r(sqlsrv_errors(), true));
    }
}

function call_stored() {
    $var_sto = "{call [REPORT_TENKO] (?,?,?,?)}";
    return $var_sto;
}

function set_stored_para($selection, $dd, $mm, $yy) {
    $var_para = array(
        array($selection, SQLSRV_PARAM_IN),
        array($dd, SQLSRV_PARAM_IN),
        array($mm, SQLSRV_PARAM_IN),
        array($yy, SQLSRV_PARAM_IN)
    );
    return $var_para;
}

function db_query_stored($conn, $sto, $para) {
    $var_qry = sqlsrv_query($conn, $sto, $para);

    if ($var_qry === false) {
        return false;
    } else {
        return $var_qry;
    }
}

function get_item($conn, $sto, $select, $dd, $mm, $yy) {
    $para = set_stored_para($select, $dd, $mm, $yy, $con, $con_ng);
    $qry = db_query_stored($conn, $sto, $para);
    $item = sqlsrv_fetch_object($qry);
    return $item->SC;
}

function day_of_mount($mm,$yy){
    $day_count = cal_days_in_month(CAL_GREGORIAN, $mm, $yy);
    return $day_count;
}

$conn = db_connect();
$sto = call_stored();

date_default_timezone_set("Asia/Bangkok");
$date = date("d-m-Y");

$mm = 2; //$mm = $_GET['month'];
$yy = 2019; //$yy = $_GET['year'];
$day_count = day_of_mount($mm,$yy);
$type_condition = "Alcohol";

if($type_condition == "Physical"){
    //1
    $report_title_t = "สภาพร่างกาย";
    $report_title_e = "Physical Condition";
    $report_detail = "  <tr><td>วัตถุประสงค์ :<br>Purpose :</td> <td>เพื่อตรวจสอบความเหนื่อยล้าของร่างกาย หลังจากกลับมา<br>To Check Driver fatigue after finished job.</td></tr>
                        <tr><td>เกณฑ์การตัดสินใจ :<br>Judge Criteria :</td> <td>1.)ทักทายอย่างมีชีวิตชีวา<br>1.)Bouncy Greeting.</td></tr>
                        <tr><td>ข้อมูลที่ใช้ :<br>Data Source :</td> <td>เอกสารเท็งโกะ<br>Tenko Check Sheet.</td></tr>";
    $report_ng_detail = "   <tr><td>กรณี NG :<br>IF Found NG :</td>
                            <td>แนะนำ และติดตามพนักงานคนนั้นเป็นพิเศษ<br>Instruct and Follow by Each Driver.<br>1.)ถ้าดวงตาหรือใบหน้าไม่ปกติสอบถามถึงความผิดปกติ<br>1.)IF Eye or Face is not Bright, Must ask to driver have problem or not</td></tr>";
    $select_type = "REPORT_NG_PHYSICAL";
}else if($type_condition == "Workover"){
    //2
    $report_title_t = "ทำงานคนเดียวไม่เกิน 14 ชั่วโมง";
    $report_title_e = "Working not over 14 hrs.";
    $report_detail = "  <tr><td>วัตถุประสงค์ :<br>Purpose :</td> <td>เพื่อไม่ให้พนักงานทำงานเหนื่อยล้าเกินไป (ตามกฏหมาย)<br>To Driver working to tried over. (Thai Law)</td></tr>
                        <tr><td>เกณฑ์การตัดสินใจ :<br>Judge Criteria :</td> <td>นับเวลาตั้งแต่ตรวจร่างกายเริ่มงาน จนถึงจรวจร่างกายหลังจากเสร็จงาน เมื่อรวมแล้วต้องไม่เกิน 14 ชม.<br>Start from Tenko Start to Tenko Finish and Check Summary work not over 14 hrs.</td></tr>
                        <tr><td>ข้อมูลที่ใช้ :<br>Data Source :</td> <td>เวลาตรวจร่างกายในข้อมูล Tenko<br>Tenko data.</td></tr>";
    $report_ng_detail = "   <tr><td>กรณี NG :<br>IF Found NG :</td>
                            <td>แนะนำถึงความเสี่ยงหรืออุบัติเหตุที่อาจจะเกิดขึ้น พร้อมทั้งผลกระทบ<br>Instruct risk or accident to drive and effect to him, family company or etc.<br>2.ลงบันทึกข้อมูล และเพิ่มเวลาในวันถัดไปหรือลดจำนวนการวิ่งงาน<br>Record data and adjust time for next day or reduce job volume</td></tr>";
    $select_type = "REPORT_NG_WORKOVER";
}else if($type_condition == "Trailer"){
    //3
    $report_title_t = "ตรวจเทรลเลอร์ประจำวัน";
    $report_title_e = "Trailer Readiness Check";
    $report_detail = "  <tr><td>วัตถุประสงค์ :<br>Purpose :</td> <td>เพื่อเตรียมความพร้อมของเทรลเลอร์ ก่อนวิ่งงาน<br>To Perpare Trailler before receive Job<br>เพื่อป้องกันอุบัติเหตุ ทั้งจากการทำงาน หรือ ระหว่างขับขี่<br>To Prevent Accident entire with Operation or Driving</td></tr>
                        <tr><td>เกณฑ์การตัดสินใจ :<br>Judge Criteria :</td> <td>ต้องไม่มีหัวข้อ NG ในการตรวจรถ<br>No NG Check</td></tr>
                        <tr><td>ข้อมูลที่ใช้ :<br>Data Source :</td> <td>ใบตรวจเช็คเทรลเลอร์ ประจำวัน / สุ่มตรวจสอบ 1 ครั้งต่อสัปดาห์ โดยหัวหน้างาน<br>Trailer Readliness Sheet / Samplay Check 1 time/week by leader</td></tr>";
    $report_ng_detail = "   <tr><td>กรณี NG :<br>IF Found NG :</td>
                            <td>เปลี่ยนรถเทรลเลอร์<br>Change Trailrt<br>แจ้งซ่อม<br>Repair</td></tr>";
    $select_type = "REPORT_NG_TRAILER";
}else if($type_condition == "Nervousness"){
    //4
    $report_title_t = "ความกระวนกระวาย";
    $report_title_e = "Nervousness";
    $report_detail = "  <tr><td>วัตถุประสงค์ :<br>Purpose :</td> <td>เพื่อตรวจสอบสภาพจิตใจ ว่าพร้อมทำงานหรือไม่<br>To Check Driver Mental Status that can Receive job or not on today</td></tr>
                        <tr><td>เกณฑ์การตัดสินใจ :<br>Judge Criteria :</td> <td>ต้องไม่มีหัวข้อ NG ในการตรวจ<br>No NG Check</td></tr>
                        <tr><td>ข้อมูลที่ใช้ :<br>Data Source :</td> <td>ใบตรวจสุขภาพด้วยตนเอง / สอบถามพนักงานโดยตรง<br>Self check sheet and asking Driver himself</td></tr>";
    $report_ng_detail = "   <tr><td>กรณี NG :<br>IF Found NG :</td>
                            <td>ไม่จ่ายงานให้พนักงาน<br>Don't give Job to Driver<br>ติดตามปัญหาของพนักงานขับรถ<br>Follow Driver's problem</td></tr>";
    $select_type = "REPORT_NG_NERVOUSNESS";
}else if($type_condition == "Rest"){
    //5
    $report_title_t = "จอดพักจากการขับต่อเนื่อง";
    $report_title_e = "Drive and Rest";
    $report_detail = "  <tr><td>วัตถุประสงค์ :<br>Purpose :</td> <td>เพื่อไม่ให้พนักงานขับรถขับอย่างต่อเนื่องนานจนเกินไปจนเกิดความเหนื่อยล้า หรือการหลับในจนเกิดอุบัติเหตุ<br>For protect driver to long drive and accident from dozy</td></tr>
                        <tr><td>เกณฑ์การตัดสินใจ :<br>Judge Criteria :</td> <td>นับเวลาตั้งแต่ขับรถจนถึงจอดพัก เมื่อรวมแล้วต้องไม่เกิน 4 ชม. และจิดพัก 30 นาที หากเปลี่ยนคนขับต้องพักอย่างน้อย 15 นาที<br>Start from Begin Drive to Rest Point to summary drive hour not over 4 hrs. and rest 30 min, If want to change driver must rest at least 15 min.</td></tr>
                        <tr><td>ข้อมูลที่ใช้ :<br>Data Source :</td> <td>การเตือนจากระบบ GPS หรือเอกสาร GPS<br>Warning from GPS system or GPS Document</td></tr>";
    $report_ng_detail = "   <tr><td>กรณี NG :<br>IF Found NG :</td>
                            <td>บอกถึงปัญหา และความเสี่ยงที่ตามมา จากการขับขี่หลับใน<br>Instruct risk of dozy drive and effect to Driver</td></tr>";
    $select_type = "REPORT_NG_REST";
}else if($type_condition == "Limit"){
    //6
    $report_title_t = "ขับขี่ความเร็วไม่เกิน 60 กิโลเมตร/ชั่วโมง";
    $report_title_e = "Speed not over 60 km/hr.";
    $report_detail = "  <tr><td>วัตถุประสงค์ :<br>Purpose :</td> <td>เพื่อลดความเสี่ยงในการเกิดอุบัติเหตุขณะขับขี่<br>To reduce the risk of driving accidents.</td></tr>
                        <tr><td>เกณฑ์การตัดสินใจ :<br>Judge Criteria :</td> <td>ใช้ความเร็วในการขับขี่ ต่ำกว่า 60 กิโลเมตร/ชั่วโมง<br> Use speed during driving lower 60 km/hrs.</td></tr>
                        <tr><td>ข้อมูลที่ใช้ :<br>Data Source :</td> <td> ข้อมูลจาก จีพีเอส<br>GPS system</td></tr>";
    $report_ng_detail = "   <tr><td>กรณี NG :<br>IF Found NG :</td>
                            <td> สอบถามพนักงานขับรถ และ ให้คำแนะนำในกรณีที่เจอสถานะการดังกล่าวเพื่อให้สามารถควบคุมความเร็วได้<br> Ask driver why driving speed over and explain about how to do on this situation for can control speed</td></tr>";
    $select_type = "REPORT_NG_LIMIT";
}else if($type_condition == "Patrol"){
    //7
    $report_title_t = "มาตรฐานการทำงาน";
    $report_title_e = "Activity SSA & Patrol check";
    $report_detail = "  <tr><td>วัตถุประสงค์ :<br>Purpose :</td> <td>เพื่อลดความเสี่ยงในการเกิดอุบัติเหตุขณะปฏิบัติงาน<br> To reduce the risk of operation accidents.</td></tr>
                        <tr><td>เกณฑ์การตัดสินใจ :<br>Judge Criteria :</td> <td>พนักงานปฏิบัติงานตามขั้นตอน<br> Driver follow STD operation</td></tr>
                        <tr><td>ข้อมูลที่ใช้ :<br>Data Source :</td> <td> เอกสารตรวจสอบขั้นตอนการทำงานของคอนโทรลเลอร์ /สตาฟ<br>Yard controler and staff check sheet and Audit activity SSA</td></tr>";
    $report_ng_detail = "   <tr><td>กรณี NG :<br>IF Found NG :</td>
                            <td> แนะนำพนักงานในขั้นตอนที่ไม่ถูกต้องและ แนะนำให้พนักงานทราบขั้นตอนที่ถูกต้อง เพื่อทำการปรับปรุง<br> Comment to driver of mistake process and Instruction to driver for acknowledge about collect process follow STD</td></tr>";
    $select_type = "REPORT_NG_PATROL";
}else if($type_condition == "Patrol"){
    //8
    $report_title_t = "มาตรฐานการทำงาน";
    $report_title_e = "Activity SSA & Patrol check";
    $report_detail = "  <tr><td>วัตถุประสงค์ :<br>Purpose :</td> <td>เพื่อลดความเสี่ยงในการเกิดอุบัติเหตุขณะปฏิบัติงาน<br> To reduce the risk of operation accidents.</td></tr>
                        <tr><td>เกณฑ์การตัดสินใจ :<br>Judge Criteria :</td> <td>พนักงานปฏิบัติงานตามขั้นตอน<br> Driver follow STD operation</td></tr>
                        <tr><td>ข้อมูลที่ใช้ :<br>Data Source :</td> <td> เอกสารตรวจสอบขั้นตอนการทำงานของคอนโทรลเลอร์ /สตาฟ<br>Yard controler and staff check sheet and Audit activity SSA</td></tr>";
    $report_ng_detail = "   <tr><td>กรณี NG :<br>IF Found NG :</td>
                            <td> แนะนำพนักงานในขั้นตอนที่ไม่ถูกต้องและ แนะนำให้พนักงานทราบขั้นตอนที่ถูกต้อง เพื่อทำการปรับปรุง<br> Comment to driver of mistake process and Instruction to driver for acknowledge about collect process follow STD</td></tr>";
    $select_type = "REPORT_NG_PATROL";
}else if($type_condition == "Feelsleep"){
    //9
    $report_title_t = "ง่วงขับรถ";
    $report_title_e = "Feel Sleep";
    $report_detail = "  <tr><td>วัตถุประสงค์ :<br>Purpose :</td> <td>เพื่อป้องกันปัญหาการง่วงขณะขับขี่<br>To Prevent Dozy Driving of Driver</td></tr>
                        <tr><td>เกณฑ์การตัดสินใจ :<br>Judge Criteria :</td> <td>ต้องไม่มี หัวข้อ NG (จากเอกสารเช็ค)<br>No NG (From Exr)</td></tr>
                        <tr><td>ข้อมูลที่ใช้ :<br>Data Source :</td> <td>กล้องติดรถ, กล้อง IP, กล้องจับลูกตา<br>CCTV, IP Camera, Eye Catcher</td></tr>";
    $report_ng_detail = "   <tr><td>กรณี NG :<br>IF Found NG :</td>
                            <td>แนะนำ และ ติดตาม พนักงาน คนนั้น เป็นพิเศษ<br>Instruct and Follow by Each Driver<br>1. โทร เน้นย้ำ พนักงาน คนที่มีความเสี่ยง / Call to Emphasize Risky Driver<br>2. แยกกลุ่ม ที่มีความเสี่ยง ออกจากกลุ่มปกติ / Split Group Risky & Normal Group</td></tr>";
    $select_type = "REPORT_NG_FEELSLEEP";
}else if($type_condition == "Unload"){
    //10
    $report_title_t = "มาตรฐานการทำงานในการโหลดสินค้าลง";
    $report_title_e = "Standard unloading operation";
    $report_detail = "  <tr><td>วัตถุประสงค์ :<br>Purpose :</td> <td>เพื่อลดความเสี่ยงในการเกิดอุบัติเหตุขณะปฏิบัติงาน<br> To reduce the risk of operation accidents.</td></tr>
                        <tr><td>เกณฑ์การตัดสินใจ :<br>Judge Criteria :</td> <td>พนักงานปฏิบัติงานตามขั้นตอน<br>Driver follow STD operation</td></tr>
                        <tr><td>ข้อมูลที่ใช้ :<br>Data Source :</td> <td>ภาพจากกล้อง และกิจกรรมการออกตรวจสอบหน้างาน<br>Truck's camera and Genba operation.</td></tr>";
    $report_ng_detail = "   <tr><td>กรณี NG :<br>IF Found NG :</td>
                            <td>แนะนำพนักงานในขั้นตอนที่ไม่ถูกต้องและ แนะนำให้พนักงานทราบขั้นตอนที่ถูกต้อง เพื่อทำการปรับปรุง<br>Comment to driver of mistake process and Instruction to driver for acknowledge about collect process follow STD</td></tr>";
    $select_type = "REPORT_NG_UNLOAD";
}else if($type_condition == "Alcohol"){
    //11
    $report_title_t = "แอลกอฮอล์";
    $report_title_e = "Alcohol";
    $report_detail = "  <tr><td>วัตถุประสงค์ :<br>Purpose :</td> <td>เพื่อตรวจสอบแอลกอฮอล์ของพนักงานขับรถ ในระหว่างการขับ มีการดื่มหรือไม่<br>To check that driver drink during drive or not.</td></tr>
                        <tr><td>เกณฑ์การตัดสินใจ :<br>Judge Criteria :</td> <td>ค่าของแอลกอฮอล์ต้องเป็น 0 เท่านั้น<br>Alcohol = 0</td></tr>
                        <tr><td>ข้อมูลที่ใช้ :<br>Data Source :</td> <td>เครื่องมือตรวจสอบแอลกอฮอล์ (แบบเป่า) และใบเท็นโกะ<br>Tool Check Alcohol and TENKO sheet.</td></tr>";
    $report_ng_detail = "   <tr><td>กรณี NG :<br>IF Found NG :</td>
                            <td>1. งดมอบหมายงานในวันถัดไป/Stop work next day.<br>2. แนะนำถึงความเสี่ยงหรืออุบัติเหตุที่อาจจะเกิดขึ้น พร้อมทั้งผลกระทบ/Instruct risk or accident to drive and effect to him, family, company.<br>3. ลงบันทึกข้อมูล/Record data.</td></tr>";
    $select_type = "REPORT_NG_UNLOAD";
}

for ($dd = 0; $dd < $day_count; $dd++) {
    $day = $dd + 1;
    $DR = get_item($conn, $sto, "REPORT_DRIVER", $day, $mm, $yy);
    if ($DR != 0) {
        $dataLine[$dd] = array("label" => $day, "y" => $DR);
        $NG = get_item($conn, $sto, $select_type, $day, $mm, $yy);
        $dataBar[$dd] = array("label" => $day, "y" => $NG);
    } else {
        $dataLine[$dd] = array("label" => $day, "y" => '');
        $dataBar[$dd] = array("label" => $day, "y" => '');
    }
};

sqlsrv_close($conn);

if (isset($dataBar) && isset($dataLine)) {
    ?>
    <!DOCTYPE HTML>
    <html>
        <head> 
            <meta charset="UTF-8"> 
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">

            <!-- Latest compiled JavaScript -->
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

            <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

            <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
            <script>
                function create_chart() {

                    var chart = new CanvasJS.Chart("chart_display", {
                        animationEnabled: false,
                        theme: "light2",
                        title: {
                            text: ""
                        },
                        axisX: {
                            title: "",
                            interval: 1
                        },
                        axisY: {
                            title: "NG",
                            maximum: 10,
                            includeZero: false
                        },
                        axisY2: {
                            title: "Total(Driver)",
                            maximum: 130,
                            interval: 13,
                            includeZero: false
                        },
                        legend: {
                            cursor: "pointer",
                            itemclick: toggleDataSeries
                        },
                        data: [{
                                type: "column",
                                color: "#E7823A",
                                name: "NG",
                                indexLabelPlacement: "top",
                                indexLabel: "{y}",
                                toolTipContent: "วันที่: {label} <br>{name}: {y} คน",
                                showInLegend: true,
                                dataPoints: <?php echo json_encode($dataBar, JSON_NUMERIC_CHECK); ?>
                            }, {
                                type: "line",
                                color: "#0000FF",
                                axisYType: "secondary",
                                name: "Total",
                                indexLabel: "{y}",
                                markerSize: 0,
                                toolTipContent: "วันที่: {label} <br>{name}: {y} คน",
                                showInLegend: true,
                                dataPoints: <?php echo json_encode($dataLine, JSON_NUMERIC_CHECK); ?>
                            }]
                    });
                    chart.render();

                    function toggleDataSeries(e) {
                        if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                            e.dataSeries.visible = false;
                        } else {
                            e.dataSeries.visible = true;
                        }
                        chart.render();
                    }

                }
            </script>
            <style type="text/css" media="print">
                @media print {
                    html,body{height:100%;width:100%;margin:0;padding:0;}
                    @page {
                        size: A4 landscape;
                        max-height:100%;
                        max-width:100%;
                    }
                }
            </style>
        </head>
        <body onload="create_chart()">
            <div class="container-fluid" style="height: 900px; width: 1600px; margin-top: 25px;">
                <div class="w3-row">
                    <div class="w3-col m3 w3-border-0">No.<?php echo $mm . '-' . $yy ?></div>
                    <div class="w3-col m6 w3-center">
                        <center>
                            <h1><?=$report_title_t?></h1>
                            <h1><?=$report_title_e?></h1>
                        </center>
                    </div>
                    <div class="w3-col m3 w3-right">
                        <h4>วันที่จัดทำ <?= $date ?></h4>
                        <h4>การแก้ไขครั้งที่ 0</h4>
                        <h5>Date issue <?= $date ?></h5>
                        <h5>Rev.0</h5>
                    </div>
                </div>
                <div class="w3-row">
                    <div class="w3-col m6">
                        <table class="w3-table">
                            <?=$report_detail?>
                        </table>
                    </div>
                    <div class="w3-col m3"></div>
                    <div class="w3-col m3 w3-right">
                        <br>
                        <h5>เวลาปรับปรุงข้อมูล : ทุกวันเวลา 10:00 น.</h5>
                        <h5>Time Adjust Data : Daily at 10:00 am</h5>
                    </div>
                </div>
                <div class="w3-row">
                    <div class="w3-col m12">
                        <table class="w3-table">
                            <tr>
                                <td><div style="height: 400px;" id="chart_display"></div></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="w3-row">
                    <div class="w3-col m12">
                        <table class="w3-table">
                            <tr>
                                <?=$report_ng_detail?>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>   
        </body>
    </html> 
<?php } ?>