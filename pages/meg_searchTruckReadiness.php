<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

ini_set('max_execution_time', 300); //300 seconds = 5 minutes

$monthnumeric  = $_POST['monthnumeric']; //เดือนที่เป็นตัวเลช
$month  = $_POST['month']; //เดือนที่เป็นอักษร
$years  = $_POST['years'];
$truckdatachk = $_POST['truckdata'];

if ($truckdatachk == 'TotalTruck') {
    $truckdata = 'Total Truck';
}else if ($truckdatachk == 'SpareTruck') {
    $truckdata = 'Spare Truck';
}else if ($truckdatachk == 'Requirement') {
    $truckdata = 'Requirement';
}else if ($truckdatachk == 'TruckAtt') {
    $truckdata = 'Truck  attend';
}else if ($truckdatachk == 'TruckAttper') {
    $truckdata = 'Truck attendance %';
}else if ($truckdatachk == 'TruckOK') {
    $truckdata = 'Truck OK';
}else if ($truckdatachk == 'Truck_NG') {
    $truckdata = 'NG';
}else if ($truckdatachk == 'WheelandTcon') {
    $truckdata = 'Wheel & tire condition';
}else if ($truckdatachk == 'SpareWheel') {
    $truckdata = 'Spare wheel';
}else if ($truckdatachk == 'WarningLight') {
    $truckdata = 'Warning light at dashboard';
}else if ($truckdatachk == 'DrainWater') {
    $truckdata = 'Drain water from air tank';
}else if ($truckdatachk == 'SafetyEqup') {
    $truckdata = 'Safety equipment';
}else if ($truckdatachk == 'EngineNoise') {
    $truckdata = 'Engine noise';
}else if ($truckdatachk == 'BrakeSystem') {
    $truckdata = 'Brake system';
}else if ($truckdatachk == 'LightingSystem') {
    $truckdata = 'Lighting system';
}else if ($truckdatachk == 'WiperSystem') {
    $truckdata = 'Wiper system';
}else if ($truckdatachk == 'AirHose') {
    $truckdata = 'Air hose for semi-trailer';
}else{
    $truckdata = 'Camera';
}
?>
<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="../dist/css/bootstrap-select.css" rel="stylesheet">

            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12" style="font-size: 40px;">เลือกเมนูที่จะลงข้อมูล:</div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12" style="text-align: center;">
                <b style="font-size: 18px"></b>
                &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_searchTruckReadiness('TotalTruck')">Total Truck</button>
                &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_searchTruckReadiness('SpareTruck')">Spare Truck</button>
                &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_searchTruckReadiness('Requirement')">Requirement</button>
                &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_searchTruckReadiness('TruckAtt')">Truck  attend</button>
            </div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12" style="text-align: center;">
                <b style="font-size: 18px"></b>
                &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_searchTruckReadiness('TruckAttper')">Truck attendance %</button>
                &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_searchTruckReadiness('TruckOK')">Truck OK</button>
                &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_searchTruckReadiness('Truck_NG')">NG</button>
                &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_searchTruckReadiness('WheelandTcon')">Wheel & tire condition</button>
            </div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12" style="text-align: center;">
                <b style="font-size: 18px"></b>
                &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_searchTruckReadiness('SpareWheel')">Spare wheel</button>
                &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_searchTruckReadiness('WarningLight')">Warning light at dashboard</button>
                &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_searchTruckReadiness('DrainWater')">Drain water from air tank</button>
                &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_searchTruckReadiness('SafetyEqup')">Safety equipment</button>
            </div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12" style="text-align: center;">
                <b style="font-size: 18px"></b>
                &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_searchTruckReadiness('EngineNoise')">Engine noise</button>
                &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_searchTruckReadiness('BrakeSystem')">Brake system</button>
                &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_searchTruckReadiness('LightingSystem')">Lighting system</button>
                &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_searchTruckReadiness('WiperSystem')">Wiper system</button>
            </div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12" style="text-align: center;">
                <b style="font-size: 18px"></b>
                &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_searchTruckReadiness('AirHose')">Air hose for semi-trailer</button>
                &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_searchTruckReadiness('Camera')">Camera</button>
            </div>                
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12">&nbsp;</div>
            
        
        <!-- START ROW1 Total Truck -->
        <div class="row" >
            <div class="col-lg-12" >
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: #ffc400;">
                        <label><font style="font-size: 20px"><b><u><?=$truckdata?></u></b>&nbsp;&nbsp;Month:</font> <font style="font-size: 20px"><b><u><?= $month ?></u></b>&nbsp;<b><u><?= $years ?></u></b></font></label>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                            <div class = "row">
                                <!-- //OK Driver colunm1  -->
                                <!-- QueryData -->
                                <?php
                                $sql_seData = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA13',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA14',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA15',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA16',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA17',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA18',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA19',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA20',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA21',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA22',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA23',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA24',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA25',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA26',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA27',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA28',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA29',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA30',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA31'";
                                $params_seData  = array();
                                $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);
                                $result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC);

                                ?>
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >วันที่ 1</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('01/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 2</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('02/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 3</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('03/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 4</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('04/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 5</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('05/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 6</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('06/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 7</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('07/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 8</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('08/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 9</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('09/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 10</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('10/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 11</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('11/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 12</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('12/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //OK Driver colunm2  -->
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >วันที่ 13</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('13/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data13" name="txt_data13" value= "<?=$result_seData['DATA13']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 14</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('14/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data14" name="txt_data14" value= "<?=$result_seData['DATA14']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 15</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('15/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data15" name="txt_data15" value= "<?=$result_seData['DATA15']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 16</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('16/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data16" name="txt_data16" value= "<?=$result_seData['DATA16']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 17</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('17/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data17" name="txt_data17" value= "<?=$result_seData['DATA17']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 18</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('18/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data18" name="txt_data18" value= "<?=$result_seData['DATA18']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 19</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('19/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data19" name="txt_data19" value= "<?=$result_seData['DATA19']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 20</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('20/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data20" name="txt_data20" value= "<?=$result_seData['DATA20']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 21</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('21/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data21" name="txt_data21" value= "<?=$result_seData['DATA21']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 22</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('22/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data22" name="txt_data22" value= "<?=$result_seData['DATA22']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 23</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('23/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data23" name="txt_data23" value= "<?=$result_seData['DATA23']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 24</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('24/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data24" name="txt_data24" value= "<?=$result_seData['DATA24']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //OK Driver colunm3  -->
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >วันที่ 25</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('25/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data25" name="txt_data25" value= "<?=$result_seData['DATA25']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 26</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('26/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data26" name="txt_data26" value= "<?=$result_seData['DATA26']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 27</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('27/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data27" name="txt_data27" value= "<?=$result_seData['DATA27']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 28</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('28/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data28" name="txt_data28" value= "<?=$result_seData['DATA28']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 29</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('29/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data29" name="txt_data29" value= "<?=$result_seData['DATA29']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 30</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('30/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data30" name="txt_data30" value= "<?=$result_seData['DATA30']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 31</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('31/<?=$monthnumeric?>/<?=$years?>',this.value,'<?=$truckdatachk?>','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data31" name="txt_data31" value= "<?=$result_seData['DATA31']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                            </div> <!-- END TOP ROW-->

                        </div>
                    </div>
                    <!-- .panel-body -->
                </div>
                <!-- /.panel -->
            </div>
        </div>
            <!-- END ROW2 OK Driver -->
