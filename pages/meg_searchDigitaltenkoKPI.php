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

if ($truckdatachk == 'DriverAttend') {
    $truckdata = 'Driver Attend';
}else if ($truckdatachk == 'OKDriver') {
    $truckdata = 'OK Driver';
}else if ($truckdatachk == 'DriverAttendPer') {
    $truckdata = 'Driver attendance %';
}else if ($truckdatachk == 'TotalDriver') {
    $truckdata = 'Total Driver';
}else if ($truckdatachk == 'Requirement') {
    $truckdata = 'Requirement';
}else if ($truckdatachk == 'AbsenceLeave') {
    $truckdata = 'Absence/Leave';
}else if ($truckdatachk == 'TenkoNG') {
    $truckdata = 'Tenko : NG';
}else if ($truckdatachk == 'BloodPressure') {
    $truckdata = 'Blood Pressure';
}else if ($truckdatachk == 'Alcohol') {
    $truckdata = 'Alcohol';
}else if ($truckdatachk == 'Resttimeless6hrs') {
    $truckdata = 'Rest time < 6 hrs';
}else if ($truckdatachk == 'HealthProblem') {
    $truckdata = 'Health Problem';
}else{
    $truckdata = 'Other';
}
?>
        <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
        <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">

        
        <!-- modal บันทึกข้อมูล TenkoNG -->
         
        
        <div class="col-lg-12">&nbsp;</div>
        <div class="col-lg-12" style="font-size: 40px;">เลือกเมนูที่จะลงข้อมูล:</div>
        <div class="col-lg-12">&nbsp;</div>
        <div class="col-lg-12">&nbsp;</div>
        <div class="col-lg-12" style="text-align: center;">
            <b style="font-size: 18px"></b>
            &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_DigitalTenkoKPI('DriverAttend')">Driver Attend</button>
            &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_DigitalTenkoKPI('OKDriver')">OK Driver</button>
            &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_DigitalTenkoKPI('DriverAttendPer')">Driver attendance %</button>
            &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_DigitalTenkoKPI('TotalDriver')">Total Driver</button>
        </div>
        <div class="col-lg-12">&nbsp;</div>
        <div class="col-lg-12" style="text-align: center;">
            <b style="font-size: 18px"></b>
            &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_DigitalTenkoKPI('Requirement')">Requirement</button>
            &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_DigitalTenkoKPI('AbsenceLeave')">Absence/Leave</button>
            &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_DigitalTenkoKPI('TenkoNG')">Tenko : NG</button>
            &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_DigitalTenkoKPI('BloodPressure')">Blood Pressure</button>
        </div>
        <div class="col-lg-12">&nbsp;</div>
        <div class="col-lg-12" style="text-align: center;">
            <b style="font-size: 18px"></b>
            &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_DigitalTenkoKPI('Alcohol')">Alcohol</button>
            &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_DigitalTenkoKPI('Resttimeless6hrs')">Rest time < 6 hrs</button>
            &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_DigitalTenkoKPI('HealthProblem')">Health problem</button>
        </div>
        <div class="col-lg-12">&nbsp;</div>
        <div class="col-lg-12">&nbsp;</div>
            
        <?php
        if ($truckdatachk == 'DriverAttend') {
        ?>
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
                                $sql_seData = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA13',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA14',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA15',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA16',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA17',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA18',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA19',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA20',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA21',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA22',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA23',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA24',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA25',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA26',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA27',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA28',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA29',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA30',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend' 
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
                                           <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('01/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 2</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('02/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 3</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('03/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 4</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('04/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 5</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('05/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 6</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('06/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 7</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('07/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 8</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('08/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 9</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('09/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 10</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('10/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 11</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('11/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 12</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('12/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //OK Driver colunm2  -->
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >วันที่ 13</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('13/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data13" name="txt_data13" value= "<?=$result_seData['DATA13']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 14</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('14/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data14" name="txt_data14" value= "<?=$result_seData['DATA14']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 15</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('15/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data15" name="txt_data15" value= "<?=$result_seData['DATA15']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 16</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('16/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data16" name="txt_data16" value= "<?=$result_seData['DATA16']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 17</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('17/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data17" name="txt_data17" value= "<?=$result_seData['DATA17']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 18</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('18/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data18" name="txt_data18" value= "<?=$result_seData['DATA18']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 19</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('19/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data19" name="txt_data19" value= "<?=$result_seData['DATA19']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 20</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('20/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data20" name="txt_data20" value= "<?=$result_seData['DATA20']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 21</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('21/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data21" name="txt_data21" value= "<?=$result_seData['DATA21']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 22</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('22/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data22" name="txt_data22" value= "<?=$result_seData['DATA22']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 23</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('23/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data23" name="txt_data23" value= "<?=$result_seData['DATA23']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 24</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('24/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data24" name="txt_data24" value= "<?=$result_seData['DATA24']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //OK Driver colunm3  -->
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >วันที่ 25</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('25/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data25" name="txt_data25" value= "<?=$result_seData['DATA25']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 26</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('26/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data26" name="txt_data26" value= "<?=$result_seData['DATA26']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 27</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('27/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data27" name="txt_data27" value= "<?=$result_seData['DATA27']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 28</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('28/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data28" name="txt_data28" value= "<?=$result_seData['DATA28']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 29</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('29/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data29" name="txt_data29" value= "<?=$result_seData['DATA29']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 30</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('30/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data30" name="txt_data30" value= "<?=$result_seData['DATA30']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 31</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('31/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data31" name="txt_data31" value= "<?=$result_seData['DATA31']?>" autocomplete="off">
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

        <?php
        }else if($truckdatachk == 'OKDriver') {
        ?>
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
                                $sql_seData = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA13',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA14',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA15',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA16',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA17',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA18',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA19',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA20',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA21',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA22',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA23',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA24',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA25',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA26',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA27',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA28',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA29',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA30',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
                                AND REMARK ='OK_Driver' 
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
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('01/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 2</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('02/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 3</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('03/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 4</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('04/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 5</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('05/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 6</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('06/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 7</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('07/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 8</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('08/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 9</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('09/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 10</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('10/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 11</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('11/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 12</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('12/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //OK Driver colunm2  -->
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >วันที่ 13</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('13/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data13" name="txt_data13" value= "<?=$result_seData['DATA13']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 14</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('14/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data14" name="txt_data14" value= "<?=$result_seData['DATA14']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 15</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('15/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data15" name="txt_data15" value= "<?=$result_seData['DATA15']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 16</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('16/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data16" name="txt_data16" value= "<?=$result_seData['DATA16']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 17</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('17/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data17" name="txt_data17" value= "<?=$result_seData['DATA17']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 18</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('18/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data18" name="txt_data18" value= "<?=$result_seData['DATA18']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 19</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('19/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data19" name="txt_data19" value= "<?=$result_seData['DATA19']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 20</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('20/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data20" name="txt_data20" value= "<?=$result_seData['DATA20']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 21</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('21/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data21" name="txt_data21" value= "<?=$result_seData['DATA21']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 22</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('22/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data22" name="txt_data22" value= "<?=$result_seData['DATA22']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 23</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('23/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data23" name="txt_data23" value= "<?=$result_seData['DATA23']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 24</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('24/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data24" name="txt_data24" value= "<?=$result_seData['DATA24']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //OK Driver colunm3  -->
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >วันที่ 25</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('25/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data25" name="txt_data25" value= "<?=$result_seData['DATA25']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 26</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('26/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data26" name="txt_data26" value= "<?=$result_seData['DATA26']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 27</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('27/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data27" name="txt_data27" value= "<?=$result_seData['DATA27']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 28</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('28/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data28" name="txt_data28" value= "<?=$result_seData['DATA28']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 29</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('29/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data29" name="txt_data29" value= "<?=$result_seData['DATA29']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 30</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('30/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data30" name="txt_data30" value= "<?=$result_seData['DATA30']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 31</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('31/<?=$monthnumeric?>/<?=$years?>',this.value,'OK_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data31" name="txt_data31" value= "<?=$result_seData['DATA31']?>" autocomplete="off">
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

        <?php
        }else if($truckdatachk == 'DriverAttendPer') {
        ?>
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
                                $sql_seData = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA13',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA14',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA15',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA16',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA17',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA18',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA19',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA20',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA21',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA22',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA23',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA24',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA25',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA26',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA27',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA28',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA29',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA30',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
                                AND REMARK ='Driver_Attend_Per' 
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
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('01/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 2</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('02/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 3</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('03/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 4</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('04/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 5</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('05/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 6</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('06/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 7</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('07/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 8</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('08/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 9</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('09/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 10</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('10/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 11</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('11/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 12</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('12/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //OK Driver colunm2  -->
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >วันที่ 13</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('13/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data13" name="txt_data13" value= "<?=$result_seData['DATA13']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 14</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('14/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data14" name="txt_data14" value= "<?=$result_seData['DATA14']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 15</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('15/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data15" name="txt_data15" value= "<?=$result_seData['DATA15']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 16</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('16/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data16" name="txt_data16" value= "<?=$result_seData['DATA16']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 17</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('17/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data17" name="txt_data17" value= "<?=$result_seData['DATA17']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 18</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('18/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data18" name="txt_data18" value= "<?=$result_seData['DATA18']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 19</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('19/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data19" name="txt_data19" value= "<?=$result_seData['DATA19']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 20</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('20/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data20" name="txt_data20" value= "<?=$result_seData['DATA20']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 21</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('21/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data21" name="txt_data21" value= "<?=$result_seData['DATA21']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 22</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('22/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data22" name="txt_data22" value= "<?=$result_seData['DATA22']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 23</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('23/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data23" name="txt_data23" value= "<?=$result_seData['DATA23']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 24</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('24/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data24" name="txt_data24" value= "<?=$result_seData['DATA24']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //OK Driver colunm3  -->
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >วันที่ 25</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('25/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data25" name="txt_data25" value= "<?=$result_seData['DATA25']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 26</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('26/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data26" name="txt_data26" value= "<?=$result_seData['DATA26']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 27</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('27/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data27" name="txt_data27" value= "<?=$result_seData['DATA27']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 28</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('28/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data28" name="txt_data28" value= "<?=$result_seData['DATA28']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 29</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('29/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data29" name="txt_data29" value= "<?=$result_seData['DATA29']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 30</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('30/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data30" name="txt_data30" value= "<?=$result_seData['DATA30']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 31</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('31/<?=$monthnumeric?>/<?=$years?>',this.value,'Driver_Attend_Per','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data31" name="txt_data31" value= "<?=$result_seData['DATA31']?>" autocomplete="off">
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

        <?php
        }else if($truckdatachk == 'TotalDriver') {
        ?>
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
                                $sql_seData = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA13',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA14',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA15',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA16',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA17',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA18',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA19',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA20',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA21',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA22',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA23',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA24',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA25',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA26',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA27',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA28',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA29',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA30',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
                                AND REMARK ='Total_Driver' 
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
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('01/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 2</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('02/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 3</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('03/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 4</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('04/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 5</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('05/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 6</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('06/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 7</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('07/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 8</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('08/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 9</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('09/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 10</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('10/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 11</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('11/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 12</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('12/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //OK Driver colunm2  -->
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >วันที่ 13</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('13/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data13" name="txt_data13" value= "<?=$result_seData['DATA13']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 14</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('14/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data14" name="txt_data14" value= "<?=$result_seData['DATA14']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 15</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('15/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data15" name="txt_data15" value= "<?=$result_seData['DATA15']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 16</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('16/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data16" name="txt_data16" value= "<?=$result_seData['DATA16']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 17</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('17/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data17" name="txt_data17" value= "<?=$result_seData['DATA17']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 18</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('18/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data18" name="txt_data18" value= "<?=$result_seData['DATA18']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 19</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('19/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data19" name="txt_data19" value= "<?=$result_seData['DATA19']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 20</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('20/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data20" name="txt_data20" value= "<?=$result_seData['DATA20']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 21</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('21/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data21" name="txt_data21" value= "<?=$result_seData['DATA21']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 22</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('22/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data22" name="txt_data22" value= "<?=$result_seData['DATA22']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 23</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('23/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data23" name="txt_data23" value= "<?=$result_seData['DATA23']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 24</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('24/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data24" name="txt_data24" value= "<?=$result_seData['DATA24']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //OK Driver colunm3  -->
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >วันที่ 25</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('25/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data25" name="txt_data25" value= "<?=$result_seData['DATA25']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 26</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('26/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data26" name="txt_data26" value= "<?=$result_seData['DATA26']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 27</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('27/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data27" name="txt_data27" value= "<?=$result_seData['DATA27']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 28</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('28/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data28" name="txt_data28" value= "<?=$result_seData['DATA28']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 29</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('29/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data29" name="txt_data29" value= "<?=$result_seData['DATA29']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 30</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('30/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data30" name="txt_data30" value= "<?=$result_seData['DATA30']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 31</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('31/<?=$monthnumeric?>/<?=$years?>',this.value,'Total_Driver','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data31" name="txt_data31" value= "<?=$result_seData['DATA31']?>" autocomplete="off">
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

        <?php
        }else if($truckdatachk == 'Requirement') {
        ?>
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
                                $sql_seData = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA13',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA14',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA15',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA16',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA17',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA18',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA19',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA20',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA21',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA22',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA23',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA24',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA25',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA26',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA27',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA28',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA29',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA30',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
                                AND REMARK ='Requirement' 
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
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('01/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 2</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('02/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 3</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('03/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 4</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('04/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 5</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('05/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 6</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('06/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 7</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('07/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 8</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('08/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 9</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('09/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 10</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('10/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 11</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('11/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 12</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('12/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //OK Driver colunm2  -->
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >วันที่ 13</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('13/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data13" name="txt_data13" value= "<?=$result_seData['DATA13']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 14</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('14/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data14" name="txt_data14" value= "<?=$result_seData['DATA14']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 15</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('15/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data15" name="txt_data15" value= "<?=$result_seData['DATA15']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 16</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('16/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data16" name="txt_data16" value= "<?=$result_seData['DATA16']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 17</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('17/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data17" name="txt_data17" value= "<?=$result_seData['DATA17']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 18</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('18/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data18" name="txt_data18" value= "<?=$result_seData['DATA18']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 19</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('19/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data19" name="txt_data19" value= "<?=$result_seData['DATA19']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 20</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('20/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data20" name="txt_data20" value= "<?=$result_seData['DATA20']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 21</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('21/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data21" name="txt_data21" value= "<?=$result_seData['DATA21']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 22</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('22/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data22" name="txt_data22" value= "<?=$result_seData['DATA22']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 23</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('23/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data23" name="txt_data23" value= "<?=$result_seData['DATA23']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 24</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('24/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data24" name="txt_data24" value= "<?=$result_seData['DATA24']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //OK Driver colunm3  -->
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >วันที่ 25</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('25/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data25" name="txt_data25" value= "<?=$result_seData['DATA25']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 26</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('26/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data26" name="txt_data26" value= "<?=$result_seData['DATA26']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 27</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('27/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data27" name="txt_data27" value= "<?=$result_seData['DATA27']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 28</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('28/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data28" name="txt_data28" value= "<?=$result_seData['DATA28']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 29</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('29/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data29" name="txt_data29" value= "<?=$result_seData['DATA29']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 30</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('30/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data30" name="txt_data30" value= "<?=$result_seData['DATA30']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 31</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('31/<?=$monthnumeric?>/<?=$years?>',this.value,'Requirement','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data31" name="txt_data31" value= "<?=$result_seData['DATA31']?>" autocomplete="off">
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

        <?php
        }else if($truckdatachk == 'AbsenceLeave') {
        ?>
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
                                $sql_seData = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA13',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA14',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA15',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA16',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA17',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA18',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA19',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA20',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA21',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA22',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA23',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA24',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA25',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA26',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA27',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA28',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA29',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA30',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
                                AND REMARK ='AbsenceLeave' 
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
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('01/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 2</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('02/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 3</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('03/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 4</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('04/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 5</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('05/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 6</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('06/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 7</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('07/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 8</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('08/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 9</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('09/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 10</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('10/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 11</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('11/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 12</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('12/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //OK Driver colunm2  -->
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >วันที่ 13</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('13/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data13" name="txt_data13" value= "<?=$result_seData['DATA13']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 14</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('14/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data14" name="txt_data14" value= "<?=$result_seData['DATA14']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 15</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('15/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data15" name="txt_data15" value= "<?=$result_seData['DATA15']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 16</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('16/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data16" name="txt_data16" value= "<?=$result_seData['DATA16']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 17</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('17/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data17" name="txt_data17" value= "<?=$result_seData['DATA17']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 18</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('18/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data18" name="txt_data18" value= "<?=$result_seData['DATA18']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 19</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('19/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data19" name="txt_data19" value= "<?=$result_seData['DATA19']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 20</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('20/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data20" name="txt_data20" value= "<?=$result_seData['DATA20']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 21</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('21/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data21" name="txt_data21" value= "<?=$result_seData['DATA21']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 22</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('22/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data22" name="txt_data22" value= "<?=$result_seData['DATA22']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 23</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('23/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data23" name="txt_data23" value= "<?=$result_seData['DATA23']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 24</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('24/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data24" name="txt_data24" value= "<?=$result_seData['DATA24']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //OK Driver colunm3  -->
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >วันที่ 25</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('25/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data25" name="txt_data25" value= "<?=$result_seData['DATA25']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 26</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('26/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data26" name="txt_data26" value= "<?=$result_seData['DATA26']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 27</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('27/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data27" name="txt_data27" value= "<?=$result_seData['DATA27']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 28</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('28/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data28" name="txt_data28" value= "<?=$result_seData['DATA28']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 29</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('29/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data29" name="txt_data29" value= "<?=$result_seData['DATA29']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 30</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('30/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data30" name="txt_data30" value= "<?=$result_seData['DATA30']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 31</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('31/<?=$monthnumeric?>/<?=$years?>',this.value,'AbsenceLeave','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data31" name="txt_data31" value= "<?=$result_seData['DATA31']?>" autocomplete="off">
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

        <?php
        }else if($truckdatachk == 'TenkoNG') {
        ?>
        <!-- START ROW1 Total Truck -->
        <div class="row" >
        <div class="col-lg-12" >
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color: #ffc400;">
                <label><font style="font-size: 20px"><b><u>Tenko : NG</u></b>&nbsp;&nbsp;Month:</font> <font style="font-size: 20px"><b><u><?= $month ?></u></b>&nbsp;<b><u><?= $years ?></u></b></font></label>&nbsp;&nbsp;<button type="button" class="btn btn-primary btn-md" name="myBtn" id ="myBtn" data-toggle="modal" data-target="#myModalinsert"  >บันทึกข้อมูล Tenko NG</button>
                </div>
                <div class ="row">
                <br>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label>ค้นหาตามช่วงวันที่</label>
                        <input class="form-control dateen" readonly="" onchange="datetodate();" style=""  id="txt_datestart" name="txt_datestart" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                    </div>
                </div>
                <div class="col-lg-2">
                    <label>&nbsp;</label>
                    <div class="form-group">
                        <input type="text" class="form-control dateen"  readonly=""  style="" id="txt_dateend" name="txt_dateend" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">
                    </div>
                </div>
                <div class="col-lg-2">
                    <label>&nbsp;</label>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary btn-md" name="btn_printexceltenkong" id ="btn_printexceltenkong" onclick="print_tenkong();"  >พิมพ์ข้อมูล TenkoNG</button>
                        </div>
                    </div>
                </div>
                
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                        <div class = "row">
                            <!-- //Tenko : NG colunm1  -->
                            <!-- QueryData -->
                            <?php
                            $sql_seTenkoNG = "SELECT (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG1',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG2',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG3',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG4',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG5',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG6',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG7',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG8',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG9',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG10',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG11',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG12',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG13',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG14',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG15',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG16',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG17',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG18',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG19',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG20',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG21',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG22',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG23',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG24',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG25',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG26',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG27',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG28',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG29',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG30',
                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                            WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
                            AND REMARK ='Tenko_NG' 
                            AND REMARK_MONTH ='".$month."' 
                            AND REMARK_YEARS ='".$years."') AS 'TenkoNG31'";
                            $params_seTenkoNG = array();
                            $query_seTenkoNG = sqlsrv_query($conn, $sql_seTenkoNG, $params_seTenkoNG);
                            $result_seTenkoNG = sqlsrv_fetch_array($query_seTenkoNG, SQLSRV_FETCH_ASSOC);

                            ?>
                            <div class="scol-lg-2">
                                <form class="form-inline">
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('01/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 1</u></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('01/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG1" name="txt_TenkoNG1" value= "<?=$result_seTenkoNG['TenkoNG1']?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('02/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 2</u></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('02/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG2" name="txt_TenkoNG2" value= "<?=$result_seTenkoNG['TenkoNG2']?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('03/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 3</u></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('03/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG3" name="txt_TenkoNG3" value= "<?=$result_seTenkoNG['TenkoNG3']?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('04/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 4</u></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('04/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG4" name="txt_TenkoNG4" value= "<?=$result_seTenkoNG['TenkoNG4']?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('05/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 5</u></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('05/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG5" name="txt_TenkoNG5" value= "<?=$result_seTenkoNG['TenkoNG5']?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('06/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 6</u></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('06/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG6" name="txt_TenkoNG6" value= "<?=$result_seTenkoNG['TenkoNG6']?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('07/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 7</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('07/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG7" name="txt_TenkoNG7" value= "<?=$result_seTenkoNG['TenkoNG7']?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('08/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 8</u></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('08/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG8" name="txt_TenkoNG8" value= "<?=$result_seTenkoNG['TenkoNG8']?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('09/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 9</u></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('09/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG9" name="txt_TenkoNG9" value= "<?=$result_seTenkoNG['TenkoNG9']?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('10/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 10</u></label>&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('10/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG10" name="txt_TenkoNG10" value= "<?=$result_seTenkoNG['TenkoNG10']?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('11/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 11</u></label>&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('11/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG11" name="txt_TenkoNG11" value= "<?=$result_seTenkoNG['TenkoNG11']?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('12/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 12</u></label>&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('12/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG12" name="txt_TenkoNG12" value= "<?=$result_seTenkoNG['TenkoNG12']?>" autocomplete="off">
                                    </div>
                                </form>
                            </div>
                            <br>
                            <!-- //Tenko : NG colunm2  -->
                            <div class="scol-lg-2">
                                <form class="form-inline">
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('13/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 13</u></label>&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('13/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG13" name="txt_TenkoNG13" value= "<?=$result_seTenkoNG['TenkoNG13']?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('14/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 14</u></label>&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('14/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG14" name="txt_TenkoNG14" value= "<?=$result_seTenkoNG['TenkoNG14']?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('15/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 15</u></label>&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('15/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG15" name="txt_TenkoNG15" value= "<?=$result_seTenkoNG['TenkoNG15']?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('16/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 16</u></label>&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('16/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG16" name="txt_TenkoNG16" value= "<?=$result_seTenkoNG['TenkoNG16']?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('17/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 17</u></label>&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('17/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG17" name="txt_TenkoNG17" value= "<?=$result_seTenkoNG['TenkoNG17']?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('18/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 18</u></label>&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('18/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG18" name="txt_TenkoNG18" value= "<?=$result_seTenkoNG['TenkoNG18']?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('19/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 19</u></label>&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('19/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG19" name="txt_TenkoNG19" value= "<?=$result_seTenkoNG['TenkoNG19']?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('20/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 20</u></label>&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('20/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG20" name="txt_TenkoNG20" value= "<?=$result_seTenkoNG['TenkoNG20']?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('21/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 21</u></label>&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('21/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG21" name="txt_TenkoNG21" value= "<?=$result_seTenkoNG['TenkoNG21']?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('22/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 22</u></label>&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('22/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG22" name="txt_TenkoNG22" value= "<?=$result_seTenkoNG['TenkoNG22']?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('23/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 23</u></label>&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('23/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG23" name="txt_TenkoNG23" value= "<?=$result_seTenkoNG['TenkoNG23']?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('24/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 24</u></label>&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('24/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG24" name="txt_TenkoNG24" value= "<?=$result_seTenkoNG['TenkoNG24']?>" autocomplete="off">
                                    </div>
                                </form>
                            </div>
                            <br>
                            <!-- //Tenko : NG colunm3  -->
                            <div class="scol-lg-2">
                                <form class="form-inline">
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('25/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 25</u></label>&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('25/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG25" name="txt_TenkoNG25" value= "<?=$result_seTenkoNG['TenkoNG25']?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('26/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 26</u></label>&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('26/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG26" name="txt_TenkoNG26" value= "<?=$result_seTenkoNG['TenkoNG26']?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('27/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 27</u></label>&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('27/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG27" name="txt_TenkoNG27" value= "<?=$result_seTenkoNG['TenkoNG27']?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('28/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 28</u></label>&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('28/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG28" name="txt_TenkoNG28" value= "<?=$result_seTenkoNG['TenkoNG28']?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('29/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 29</u></label>&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('29/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG29" name="txt_TenkoNG29" value= "<?=$result_seTenkoNG['TenkoNG29']?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('30/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 30</u></label>&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('30/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG30" name="txt_TenkoNG30" value= "<?=$result_seTenkoNG['TenkoNG30']?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label data-toggle="modal" data-target="#myModal" onclick="checking_dataKPI('31/<?=$monthnumeric?>/<?=$years?>');"><u>วันที่ 31</u></label>&nbsp;&nbsp;
                                        <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('31/<?=$monthnumeric?>/<?=$years?>',this.value,'Tenko_NG','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_TenkoNG31" name="txt_TenkoNG31" value= "<?=$result_seTenkoNG['TenkoNG31']?>" autocomplete="off">
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

        <?php
        }else if($truckdatachk == 'BloodPressure') {
        ?>
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
                                $sql_seData = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA13',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA14',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA15',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA16',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA17',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA18',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA19',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA20',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA21',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA22',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA23',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA24',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA25',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA26',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA27',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA28',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA29',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA30',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
                                AND REMARK ='Blood_Pressure' 
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
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('01/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 2</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('02/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 3</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('03/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 4</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('04/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 5</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('05/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 6</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('06/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 7</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('07/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 8</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('08/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 9</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('09/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 10</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('10/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 11</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('11/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 12</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('12/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //OK Driver colunm2  -->
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >วันที่ 13</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('13/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data13" name="txt_data13" value= "<?=$result_seData['DATA13']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 14</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('14/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data14" name="txt_data14" value= "<?=$result_seData['DATA14']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 15</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('15/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data15" name="txt_data15" value= "<?=$result_seData['DATA15']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 16</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('16/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data16" name="txt_data16" value= "<?=$result_seData['DATA16']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 17</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('17/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data17" name="txt_data17" value= "<?=$result_seData['DATA17']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 18</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('18/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data18" name="txt_data18" value= "<?=$result_seData['DATA18']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 19</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('19/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data19" name="txt_data19" value= "<?=$result_seData['DATA19']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 20</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('20/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data20" name="txt_data20" value= "<?=$result_seData['DATA20']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 21</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('21/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data21" name="txt_data21" value= "<?=$result_seData['DATA21']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 22</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('22/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data22" name="txt_data22" value= "<?=$result_seData['DATA22']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 23</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('23/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data23" name="txt_data23" value= "<?=$result_seData['DATA23']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 24</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('24/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data24" name="txt_data24" value= "<?=$result_seData['DATA24']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //OK Driver colunm3  -->
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >วันที่ 25</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('25/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data25" name="txt_data25" value= "<?=$result_seData['DATA25']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 26</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('26/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data26" name="txt_data26" value= "<?=$result_seData['DATA26']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 27</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('27/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data27" name="txt_data27" value= "<?=$result_seData['DATA27']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 28</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('28/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data28" name="txt_data28" value= "<?=$result_seData['DATA28']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 29</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('29/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data29" name="txt_data29" value= "<?=$result_seData['DATA29']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 30</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('30/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data30" name="txt_data30" value= "<?=$result_seData['DATA30']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 31</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('31/<?=$monthnumeric?>/<?=$years?>',this.value,'Blood_Pressure','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data31" name="txt_data31" value= "<?=$result_seData['DATA31']?>" autocomplete="off">
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

        <?php
        }else if($truckdatachk == 'Alcohol') {
        ?>
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
                                $sql_seData = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA13',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA14',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA15',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA16',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA17',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA18',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA19',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA20',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA21',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA22',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA23',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA24',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA25',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA26',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA27',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA28',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA29',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA30',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
                                AND REMARK ='Alcohol' 
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
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('01/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 2</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('02/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 3</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('03/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 4</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('04/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 5</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('05/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 6</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('06/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 7</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('07/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 8</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('08/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 9</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('09/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 10</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('10/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 11</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('11/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 12</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('12/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //OK Driver colunm2  -->
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >วันที่ 13</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('13/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data13" name="txt_data13" value= "<?=$result_seData['DATA13']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 14</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('14/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data14" name="txt_data14" value= "<?=$result_seData['DATA14']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 15</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('15/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data15" name="txt_data15" value= "<?=$result_seData['DATA15']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 16</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('16/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data16" name="txt_data16" value= "<?=$result_seData['DATA16']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 17</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('17/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data17" name="txt_data17" value= "<?=$result_seData['DATA17']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 18</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('18/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data18" name="txt_data18" value= "<?=$result_seData['DATA18']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 19</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('19/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data19" name="txt_data19" value= "<?=$result_seData['DATA19']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 20</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('20/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data20" name="txt_data20" value= "<?=$result_seData['DATA20']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 21</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('21/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data21" name="txt_data21" value= "<?=$result_seData['DATA21']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 22</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('22/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data22" name="txt_data22" value= "<?=$result_seData['DATA22']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 23</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('23/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data23" name="txt_data23" value= "<?=$result_seData['DATA23']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 24</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('24/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data24" name="txt_data24" value= "<?=$result_seData['DATA24']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //OK Driver colunm3  -->
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >วันที่ 25</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('25/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data25" name="txt_data25" value= "<?=$result_seData['DATA25']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 26</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('26/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data26" name="txt_data26" value= "<?=$result_seData['DATA26']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 27</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('27/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data27" name="txt_data27" value= "<?=$result_seData['DATA27']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 28</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('28/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data28" name="txt_data28" value= "<?=$result_seData['DATA28']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 29</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('29/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data29" name="txt_data29" value= "<?=$result_seData['DATA29']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 30</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('30/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data30" name="txt_data30" value= "<?=$result_seData['DATA30']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 31</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('31/<?=$monthnumeric?>/<?=$years?>',this.value,'Alcohol','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data31" name="txt_data31" value= "<?=$result_seData['DATA31']?>" autocomplete="off">
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

        <?php
        }else if($truckdatachk == 'Resttimeless6hrs') {
        ?>
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
                                $sql_seData = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA13',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA14',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA15',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA16',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA17',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA18',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA19',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA20',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA21',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA22',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA23',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA24',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA25',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA26',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA27',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA28',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA29',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA30',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
                                AND REMARK ='Resttime_6hrs' 
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
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('01/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 2</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('02/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 3</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('03/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 4</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('04/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 5</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('05/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 6</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('06/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 7</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('07/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 8</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('08/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 9</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('09/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 10</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('10/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 11</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('11/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 12</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('12/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //OK Driver colunm2  -->
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >วันที่ 13</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('13/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data13" name="txt_data13" value= "<?=$result_seData['DATA13']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 14</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('14/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data14" name="txt_data14" value= "<?=$result_seData['DATA14']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 15</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('15/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data15" name="txt_data15" value= "<?=$result_seData['DATA15']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 16</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('16/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data16" name="txt_data16" value= "<?=$result_seData['DATA16']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 17</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('17/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data17" name="txt_data17" value= "<?=$result_seData['DATA17']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 18</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('18/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data18" name="txt_data18" value= "<?=$result_seData['DATA18']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 19</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('19/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data19" name="txt_data19" value= "<?=$result_seData['DATA19']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 20</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('20/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data20" name="txt_data20" value= "<?=$result_seData['DATA20']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 21</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('21/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data21" name="txt_data21" value= "<?=$result_seData['DATA21']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 22</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('22/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data22" name="txt_data22" value= "<?=$result_seData['DATA22']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 23</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('23/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data23" name="txt_data23" value= "<?=$result_seData['DATA23']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 24</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('24/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data24" name="txt_data24" value= "<?=$result_seData['DATA24']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //OK Driver colunm3  -->
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >วันที่ 25</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('25/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data25" name="txt_data25" value= "<?=$result_seData['DATA25']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 26</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('26/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data26" name="txt_data26" value= "<?=$result_seData['DATA26']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 27</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('27/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data27" name="txt_data27" value= "<?=$result_seData['DATA27']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 28</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('28/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data28" name="txt_data28" value= "<?=$result_seData['DATA28']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 29</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('29/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data29" name="txt_data29" value= "<?=$result_seData['DATA29']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 30</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('30/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data30" name="txt_data30" value= "<?=$result_seData['DATA30']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 31</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('31/<?=$monthnumeric?>/<?=$years?>',this.value,'Resttime_6hrs','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data31" name="txt_data31" value= "<?=$result_seData['DATA31']?>" autocomplete="off">
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

        <?php
        }else if($truckdatachk == 'HealthProblem') {
        ?>
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
                                $sql_seData = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA13',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA14',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA15',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA16',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA17',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA18',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA19',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA20',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA21',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA22',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA23',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA24',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA25',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA26',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA27',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA28',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA29',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
                                AND REMARK_MONTH ='".$month."' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA30',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_KPI]
                                WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
                                AND REMARK ='Health_Problem' 
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
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('01/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 2</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('02/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 3</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('03/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 4</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('04/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 5</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('05/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 6</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('06/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 7</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('07/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 8</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('08/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 9</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('09/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 10</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('10/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 11</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('11/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 12</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('12/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //OK Driver colunm2  -->
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >วันที่ 13</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('13/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data13" name="txt_data13" value= "<?=$result_seData['DATA13']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 14</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('14/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data14" name="txt_data14" value= "<?=$result_seData['DATA14']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 15</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('15/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data15" name="txt_data15" value= "<?=$result_seData['DATA15']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 16</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('16/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data16" name="txt_data16" value= "<?=$result_seData['DATA16']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 17</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('17/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data17" name="txt_data17" value= "<?=$result_seData['DATA17']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 18</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('18/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data18" name="txt_data18" value= "<?=$result_seData['DATA18']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 19</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('19/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data19" name="txt_data19" value= "<?=$result_seData['DATA19']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 20</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('20/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data20" name="txt_data20" value= "<?=$result_seData['DATA20']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 21</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('21/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data21" name="txt_data21" value= "<?=$result_seData['DATA21']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 22</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('22/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data22" name="txt_data22" value= "<?=$result_seData['DATA22']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 23</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('23/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data23" name="txt_data23" value= "<?=$result_seData['DATA23']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 24</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('24/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data24" name="txt_data24" value= "<?=$result_seData['DATA24']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //OK Driver colunm3  -->
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >วันที่ 25</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('25/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data25" name="txt_data25" value= "<?=$result_seData['DATA25']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 26</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('26/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data26" name="txt_data26" value= "<?=$result_seData['DATA26']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 27</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('27/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data27" name="txt_data27" value= "<?=$result_seData['DATA27']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 28</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('28/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data28" name="txt_data28" value= "<?=$result_seData['DATA28']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 29</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('29/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data29" name="txt_data29" value= "<?=$result_seData['DATA29']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 30</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('30/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data30" name="txt_data30" value= "<?=$result_seData['DATA30']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >วันที่ 31</label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('31/<?=$monthnumeric?>/<?=$years?>',this.value,'Health_Problem','<?=$month?>','<?=$years?>');}" class="form-control" id="txt_data31" name="txt_data31" value= "<?=$result_seData['DATA31']?>" autocomplete="off">
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

        <?php
        }else {
        ?>


        <?php
        }
        ?>

        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
        <script src="../dist/js/sb-admin-2.js"></script>
        <script src="../js/jquery.datetimepicker.full.js"></script>
        <script src="../dist/js/jquery.autocomplete.js"></script>
        <script src="../dist/js/bootstrap-select.js"></script>

        <?php
        
        $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employeeehr2', " ");
        ?>

        <script type="text/javascript">

        var txt_copydiagramemployeename1 = [<?= $emp ?>];
            $("#txt_copydiagramemployeename1").autocomplete({
            source: [txt_copydiagramemployeename1]
        });

        </script>
        <!-- <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
        <script src="../js/jquery.datetimepicker.full.js"></script>
        <script src="../dist/js/jquery.autocomplete.js"></script>
        
        <script src="../js/bootstrap-datepicker.min.js"></script>
        <script src="../js/bootstrap-datepicker.th.min.js"></script> -->

        