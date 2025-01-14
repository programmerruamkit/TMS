<?php
date_default_timezone_set("Asia/Bangkok");

for ($d = 0; $d < 31; $d++) {
    if ($d <= 30) {
        $day = $d + 1;
        $a = 1;
        $b = $d + 50;
    } else {
        $day = $d;
    }

    $dataBar[$d] = array("label" => $day, "y" => $a);
    $dataLine[$d] = array("label" => $day, "y" => $b);
};
?>
<!DOCTYPE HTML>
<html>
    <head> 
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
        <script>
            window.onload = function () {

                var chart = new CanvasJS.Chart("chart_display", {
                    animationEnabled: true,
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
                            indexLabelPlacement: "inside",
                            indexLabel: "{y}",
                            toolTipContent: "วันที่: {x} <br>{name}: {y} คน",
                            showInLegend: true,
                            dataPoints: <?php echo json_encode($dataBar, JSON_NUMERIC_CHECK); ?>
                        }, {
                            type: "line",
                            color: "#0000FF",
                            axisYType: "secondary",
                            name: "Total",
                            indexLabel: "{y}",
                            markerSize: 0,
                            toolTipContent: "วันที่: {x} <br>{name}: {y} คน",
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
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <center>
                        <h1>สภาพร่างกาย</h1>
                        <h1>Physical Condition</h1>
                    </center>
                </div>
                <div class="col-sm-3">
                    <h4>วันที่จัดทำ <?= date("d-m-Y") ?></h4>
                    <h4>การแก้ไขครั้งที่ 0</h4>
                    <h5>Date issue <?= date("d-m-Y") ?></h5>
                    <h5>Rev.0</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <table class="table table-borderless">
                        <tr>
                            <td>วัตถุประสงค์ :<br>Purpose :</td> <td>เพื่อตรวจสอบความเหนื่อยล้าของร่างกาย หลังจากกลับมา<br>To Check Driver fatigue after finished job.</td>
                        </tr>
                        <tr>
                            <td>เกณฑ์การตัดสินใจ :<br>Judge Criteria :</td> <td>1.)ทักทายอย่างมีชีวิตชีวา<br>1.)Bouncy Greeting.</td>
                        </tr>
                        <tr>
                            <td>ข้อมูลที่ใช้ :<br>Data Source :</td> <td>เอกสารเท็งโกะ<br>Tenko Check Sheet.</td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-3"></div>
                <div class="col-sm-3">
                    <br>
                    <h5>เวลาปรับปรุงข้อมูล : ทุกวันเวลา 10:00 น.</h5>
                    <h5>Time Adjust Data : Daily at 10:00 am</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-borderless">
                        <tr>
                            <td><div style="height: 400px;" id="chart_display"></div></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <table class="table table-borderless">
                        <tr>
                            <td>กรณี NG :<br>IF Found NG :</td> <td>แนะนำ และติดตามพนักงานคนนั้นเป็นพิเศษ<br>Instruct and Follow by Each Driver.</td>
                        </tr>
                        <tr>
                            <td></td> <td>1.)ถ้าดวงตาหรือใบหน้าไม่ปกติสอบถามถึงความผิดปกติ<br>1.)IF Eye or Face is not Bright, Must ask to driver have problem or not<td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    </body>
</html>  