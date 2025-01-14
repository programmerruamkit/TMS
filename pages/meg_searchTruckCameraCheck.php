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

    $yearsub = substr($years,2);

if ($truckdatachk == 'Topic') {
    $truckdata = 'Topic';
}else if ($truckdatachk == 'FrontCamera') {
    $truckdata = 'Front Camera';
}else if ($truckdatachk == 'CabinCamera') {
    $truckdata = 'Cabin Camera';
}else{
    $truckdata = 'Out of Data';
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
                &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_searchTruckReadiness('Topic')">Topic</button>
                &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_searchTruckReadiness('FrontCamera')">Font Camera</button>
                &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_searchTruckReadiness('CabinCamera')">Cabin Camera</button>
            </div>
            <div class="col-lg-12">&nbsp;</div>

              


        <!-- START ROW1 Topic -->
        <div class="row" >
            <div class="col-lg-12" >
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: #ffc400;">
                        <label><font style="font-size: 20px"><b><u><?=$truckdata?></u></b>&nbsp;&nbsp;Years:</font> <font style="font-size: 20px">&nbsp;<b><u><?= $years ?></u></b></font></label>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                            <div class = "row">
                                <!-- //OK Driver colunm1  -->
                            
                                <?php
                                if ($truckdatachk == 'Topic') {
                                ?>
                                <!-- QueryData -->
                                <?php
                                $sql_seData1 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='WorkingJan".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jan' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='WorkingFeb".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Feb' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='WorkingMar".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Mar' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='WorkingApr".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Apr' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='WorkingMay".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='May' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='WorkingJun".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jun' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='WorkingJul".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jul' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='WorkingAug".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Aug' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='WorkingSep".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Sep' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='WorkingOct".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Oct' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='WorkingNov".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Nov' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='WorkingDec".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Dec' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                $params_seData1  = array();
                                $query_seData1 = sqlsrv_query($conn, $sql_seData1, $params_seData1);
                                $result_seData1 = sqlsrv_fetch_array($query_seData1, SQLSRV_FETCH_ASSOC);

                                ?>
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label ><b><u>Working Day</u></b></label><br>
                                            <label >Jan'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('WorkingJan<?=$years?>',this.value,'<?=$truckdatachk?>','Jan','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData1['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Feb'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('WorkingFeb<?=$years?>',this.value,'<?=$truckdatachk?>','Feb','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData1['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Mar'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('WorkingMar<?=$years?>',this.value,'<?=$truckdatachk?>','Mar','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData1['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Apr'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('WorkingApr<?=$years?>',this.value,'<?=$truckdatachk?>','Apr','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData1['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >May'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('WorkingMay<?=$years?>',this.value,'<?=$truckdatachk?>','May','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData1['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>   
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('WorkingJun<?=$years?>',this.value,'<?=$truckdatachk?>','Jun','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData1['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Jul'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('WorkingJul<?=$years?>',this.value,'<?=$truckdatachk?>','Jul','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData1['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Aug'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('WorkingAug<?=$years?>',this.value,'<?=$truckdatachk?>','Aug','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData1['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Sep'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('WorkingSep<?=$years?>',this.value,'<?=$truckdatachk?>','Sep','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData1['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Oct'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('WorkingOct<?=$years?>',this.value,'<?=$truckdatachk?>','Oct','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData1['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Nov'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('WorkingNov<?=$years?>',this.value,'<?=$truckdatachk?>','Nov','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData1['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Dec'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('WorkingDec<?=$years?>',this.value,'<?=$truckdatachk?>','Dec','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData1['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //Total Driver colunm2  -->
                                <?php
                                $sql_seData2 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='TotalDriverJan".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jan' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='TotalDriverFeb".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Feb' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='TotalDriverMar".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Mar' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='TotalDriverApr".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Apr' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='TotalDriverMay".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='May' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='TotalDriverJun".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jun' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='TotalDriverJul".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jul' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='TotalDriverAug".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Aug' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='TotalDriverSep".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Sep' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='TotalDriverOct".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Oct' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='TotalDriverNov".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Nov' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='TotalDriverDec".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Dec' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                $params_seData2  = array();
                                $query_seData2 = sqlsrv_query($conn, $sql_seData2, $params_seData2);
                                $result_seData2 = sqlsrv_fetch_array($query_seData2, SQLSRV_FETCH_ASSOC);

                                ?>
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label ><b><u>Total Driver</u></b></label><br>
                                            <label >Jan'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TotalDriverJan<?=$years?>',this.value,'<?=$truckdatachk?>','Jan','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData2['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Feb'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TotalDriverFeb<?=$years?>',this.value,'<?=$truckdatachk?>','Feb','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData2['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Mar'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TotalDriverMar<?=$years?>',this.value,'<?=$truckdatachk?>','Mar','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData2['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Apr'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TotalDriverApr<?=$years?>',this.value,'<?=$truckdatachk?>','Apr','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData2['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >May'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TotalDriverMay<?=$years?>',this.value,'<?=$truckdatachk?>','May','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData2['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>   
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TotalDriverJun<?=$years?>',this.value,'<?=$truckdatachk?>','Jun','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData2['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Jul'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TotalDriverJul<?=$years?>',this.value,'<?=$truckdatachk?>','Jul','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData2['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Aug'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TotalDriverAug<?=$years?>',this.value,'<?=$truckdatachk?>','Aug','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData2['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Sep'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TotalDriverSep<?=$years?>',this.value,'<?=$truckdatachk?>','Sep','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData2['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Oct'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TotalDriverOct<?=$years?>',this.value,'<?=$truckdatachk?>','Oct','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData2['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Nov'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TotalDriverNov<?=$years?>',this.value,'<?=$truckdatachk?>','Nov','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData2['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Dec'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TotalDriverDec<?=$years?>',this.value,'<?=$truckdatachk?>','Dec','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData2['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //Plan Checking  colunm3  -->
                                <?php
                                $sql_seData3 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='PlanCheckJan".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jan' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='PlanCheckFeb".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Feb' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='PlanCheckMar".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Mar' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='PlanCheckApr".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Apr' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='PlanCheckMay".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='May' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='PlanCheckJun".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jun' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='PlanCheckJul".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jul' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='PlanCheckAug".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Aug' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='PlanCheckSep".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Sep' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='PlanCheckOct".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Oct' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='PlanCheckNov".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Nov' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='PlanCheckDec".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Dec' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                $params_seData3  = array();
                                $query_seData3 = sqlsrv_query($conn, $sql_seData3, $params_seData3);
                                $result_seData3 = sqlsrv_fetch_array($query_seData3, SQLSRV_FETCH_ASSOC);

                                ?>
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label ><b><u>Plan Checking</u></b></label><br>
                                            <label >Jan'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('PlanCheckJan<?=$years?>',this.value,'<?=$truckdatachk?>','Jan','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData3['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Feb'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('PlanCheckFeb<?=$years?>',this.value,'<?=$truckdatachk?>','Feb','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData3['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Mar'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('PlanCheckMar<?=$years?>',this.value,'<?=$truckdatachk?>','Mar','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData3['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Apr'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('PlanCheckApr<?=$years?>',this.value,'<?=$truckdatachk?>','Apr','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData3['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >May'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('PlanCheckMay<?=$years?>',this.value,'<?=$truckdatachk?>','May','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData3['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>   
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('PlanCheckJun<?=$years?>',this.value,'<?=$truckdatachk?>','Jun','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData3['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Jul'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('PlanCheckJul<?=$years?>',this.value,'<?=$truckdatachk?>','Jul','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData3['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Aug'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('PlanCheckAug<?=$years?>',this.value,'<?=$truckdatachk?>','Aug','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData3['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Sep'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('PlanCheckSep<?=$years?>',this.value,'<?=$truckdatachk?>','Sep','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData3['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Oct'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('PlanCheckOct<?=$years?>',this.value,'<?=$truckdatachk?>','Oct','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData3['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Nov'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('PlanCheckNov<?=$years?>',this.value,'<?=$truckdatachk?>','Nov','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData3['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Dec'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('PlanCheckDec<?=$years?>',this.value,'<?=$truckdatachk?>','Dec','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData3['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!--  Actual Checking-->
                                <?php
                                $sql_seData4 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='ActualCheckJan".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jan' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='ActualCheckFeb".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Feb' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='ActualCheckMar".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Mar' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='ActualCheckApr".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Apr' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='ActualCheckMay".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='May' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='ActualCheckJun".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jun' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='ActualCheckJul".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jul' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='ActualCheckAug".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Aug' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='ActualCheckSep".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Sep' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='ActualCheckOct".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Oct' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='ActualCheckNov".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Nov' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='ActualCheckDec".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Dec' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                $params_seData4  = array();
                                $query_seData4 = sqlsrv_query($conn, $sql_seData4, $params_seData4);
                                $result_seData4 = sqlsrv_fetch_array($query_seData4, SQLSRV_FETCH_ASSOC);

                                ?>
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label ><b><u>Actual Checking</u></b></label><br>
                                            <label >Jan'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('ActualCheckJan<?=$years?>',this.value,'<?=$truckdatachk?>','Jan','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData4['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Feb'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('ActualCheckFeb<?=$years?>',this.value,'<?=$truckdatachk?>','Feb','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData4['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Mar'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('ActualCheckMar<?=$years?>',this.value,'<?=$truckdatachk?>','Mar','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData4['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Apr'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('ActualCheckApr<?=$years?>',this.value,'<?=$truckdatachk?>','Apr','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData4['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >May'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('ActualCheckMay<?=$years?>',this.value,'<?=$truckdatachk?>','May','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData4['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>   
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('ActualCheckJun<?=$years?>',this.value,'<?=$truckdatachk?>','Jun','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData4['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Jul'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('ActualCheckJul<?=$years?>',this.value,'<?=$truckdatachk?>','Jul','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData4['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Aug'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('ActualCheckAug<?=$years?>',this.value,'<?=$truckdatachk?>','Aug','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData4['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Sep'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('ActualCheckSep<?=$years?>',this.value,'<?=$truckdatachk?>','Sep','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData4['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Oct'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('ActualCheckOct<?=$years?>',this.value,'<?=$truckdatachk?>','Oct','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData4['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Nov'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('ActualCheckNov<?=$years?>',this.value,'<?=$truckdatachk?>','Nov','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData4['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Dec'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('ActualCheckDec<?=$years?>',this.value,'<?=$truckdatachk?>','Dec','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData4['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- NG result -->
                                <?php
                                $sql_seData5 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NGResultJan".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jan' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NGResultFeb".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Feb' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NGResultMar".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Mar' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NGResultApr".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Apr' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NGResultMay".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='May' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NGResultJun".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jun' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NGResultJul".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jul' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NGResultAug".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Aug' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NGResultSep".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Sep' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NGResultOct".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Oct' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NGResultNov".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Nov' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NGResultDec".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Dec' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                $params_seData5  = array();
                                $query_seData5 = sqlsrv_query($conn, $sql_seData5, $params_seData5);
                                $result_seData5 = sqlsrv_fetch_array($query_seData5, SQLSRV_FETCH_ASSOC);

                                ?>
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label ><b><u>NG result</u></b></label><br>
                                            <label >Jan'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NGResultJan<?=$years?>',this.value,'<?=$truckdatachk?>','Jan','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData5['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Feb'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NGResultFeb<?=$years?>',this.value,'<?=$truckdatachk?>','Feb','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData5['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Mar'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NGResultMar<?=$years?>',this.value,'<?=$truckdatachk?>','Mar','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData5['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Apr'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NGResultApr<?=$years?>',this.value,'<?=$truckdatachk?>','Apr','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData5['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >May'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NGResultMay<?=$years?>',this.value,'<?=$truckdatachk?>','May','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData5['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>   
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NGResultJun<?=$years?>',this.value,'<?=$truckdatachk?>','Jun','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData5['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Jul'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NGResultJul<?=$years?>',this.value,'<?=$truckdatachk?>','Jul','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData5['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Aug'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NGResultAug<?=$years?>',this.value,'<?=$truckdatachk?>','Aug','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData5['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Sep'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NGResultSep<?=$years?>',this.value,'<?=$truckdatachk?>','Sep','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData5['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Oct'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NGResultOct<?=$years?>',this.value,'<?=$truckdatachk?>','Oct','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData5['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Nov'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NGResultNov<?=$years?>',this.value,'<?=$truckdatachk?>','Nov','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData5['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Dec'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NGResultDec<?=$years?>',this.value,'<?=$truckdatachk?>','Dec','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData5['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>

                                <?php
                                }else if ($truckdatachk == 'FrontCamera') {
                                ?>
                                <?php
                                $sql_seData6 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotKeepFrontJan".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jan' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotKeepFrontFeb".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Feb' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotKeepFrontMar".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Mar' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotKeepFrontApr".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Apr' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotKeepFrontMay".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='May' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotKeepFrontJun".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jun' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotKeepFrontJul".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jul' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotKeepFrontAug".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Aug' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotKeepFrontSep".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Sep' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotKeepFrontOct".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Oct' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotKeepFrontNov".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Nov' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotKeepFrontDec".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Dec' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                $params_seData6  = array();
                                $query_seData6 = sqlsrv_query($conn, $sql_seData6, $params_seData6);
                                $result_seData6 = sqlsrv_fetch_array($query_seData6, SQLSRV_FETCH_ASSOC);

                                ?>
                                <div class="scol-lg-2">
                                <label ><b><u>Not keep safe distance from front vehicle</u></b></label><br>
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >Jan'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotKeepFrontJan<?=$years?>',this.value,'<?=$truckdatachk?>','Jan','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData6['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Feb'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotKeepFrontFeb<?=$years?>',this.value,'<?=$truckdatachk?>','Feb','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData6['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Mar'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotKeepFrontMar<?=$years?>',this.value,'<?=$truckdatachk?>','Mar','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData6['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Apr'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotKeepFrontApr<?=$years?>',this.value,'<?=$truckdatachk?>','Apr','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData6['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >May'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotKeepFrontMay<?=$years?>',this.value,'<?=$truckdatachk?>','May','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData6['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">  
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotKeepFrontJun<?=$years?>',this.value,'<?=$truckdatachk?>','Jun','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData6['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Jul'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotKeepFrontJul<?=$years?>',this.value,'<?=$truckdatachk?>','Jul','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData6['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Aug'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotKeepFrontAug<?=$years?>',this.value,'<?=$truckdatachk?>','Aug','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData6['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Sep'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotKeepFrontSep<?=$years?>',this.value,'<?=$truckdatachk?>','Sep','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData6['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Oct'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotKeepFrontOct<?=$years?>',this.value,'<?=$truckdatachk?>','Oct','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData6['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Nov'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotKeepFrontNov<?=$years?>',this.value,'<?=$truckdatachk?>','Nov','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData6['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Dec'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotKeepFrontDec<?=$years?>',this.value,'<?=$truckdatachk?>','Dec','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData6['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //Total Driver colunm2  -->
                                <?php
                                $sql_seData7 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='DrivingRightJan".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jan' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='DrivingRightFeb".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Feb' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='DrivingRightMar".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Mar' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='DrivingRightApr".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Apr' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='DrivingRightMay".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='May' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='DrivingRightJun".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jun' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='DrivingRightJul".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jul' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='DrivingRightAug".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Aug' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='DrivingRightSep".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Sep' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='DrivingRightOct".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Oct' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='DrivingRightNov".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Nov' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='DrivingRightDec".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Dec' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                $params_seData7  = array();
                                $query_seData7 = sqlsrv_query($conn, $sql_seData7, $params_seData7);
                                $result_seData7 = sqlsrv_fetch_array($query_seData7, SQLSRV_FETCH_ASSOC);

                                ?>
                                <div class="scol-lg-2">
                                    <label ><b><u>Driving on right lane (ไม่ขวาสุด)</u></b></label><br>
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('DrivingRightJan<?=$years?>',this.value,'<?=$truckdatachk?>','Jan','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData7['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Feb'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('DrivingRightFeb<?=$years?>',this.value,'<?=$truckdatachk?>','Feb','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData7['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Mar'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('DrivingRightMar<?=$years?>',this.value,'<?=$truckdatachk?>','Mar','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData7['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Apr'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('DrivingRightApr<?=$years?>',this.value,'<?=$truckdatachk?>','Apr','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData7['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >May'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('DrivingRightMay<?=$years?>',this.value,'<?=$truckdatachk?>','May','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData7['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">  
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('DrivingRightJun<?=$years?>',this.value,'<?=$truckdatachk?>','Jun','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData7['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Jul'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('DrivingRightJul<?=$years?>',this.value,'<?=$truckdatachk?>','Jul','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData6['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Aug'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('DrivingRightAug<?=$years?>',this.value,'<?=$truckdatachk?>','Aug','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData7['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Sep'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('DrivingRightSep<?=$years?>',this.value,'<?=$truckdatachk?>','Sep','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData7['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Oct'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('DrivingRightOct<?=$years?>',this.value,'<?=$truckdatachk?>','Oct','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData7['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Nov'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('DrivingRightNov<?=$years?>',this.value,'<?=$truckdatachk?>','Nov','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData7['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Dec'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('DrivingRightDec<?=$years?>',this.value,'<?=$truckdatachk?>','Dec','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData7['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //Plan Checking  colunm3  -->
                                <?php
                                $sql_seData8 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='TrafficLightJan".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jan' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='TrafficLightFeb".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Feb' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='TrafficLightMar".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Mar' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='TrafficLightApr".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Apr' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='TrafficLightMay".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='May' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='TrafficLightJun".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jun' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='TrafficLightJul".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jul' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='TrafficLightAug".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Aug' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='TrafficLightSep".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Sep' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='TrafficLightOct".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Oct' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='TrafficLightNov".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Nov' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='TrafficLightDec".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Dec' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                $params_seData8  = array();
                                $query_seData8 = sqlsrv_query($conn, $sql_seData8, $params_seData8);
                                $result_seData8 = sqlsrv_fetch_array($query_seData8, SQLSRV_FETCH_ASSOC);

                                ?>
                                <div class="scol-lg-2">
                                    <label ><b><u>Traffic light, Construction area</u></b></label><br>
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TrafficLightJan<?=$years?>',this.value,'<?=$truckdatachk?>','Jan','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData8['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Feb'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TrafficLightFeb<?=$years?>',this.value,'<?=$truckdatachk?>','Feb','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData8['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Mar'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TrafficLightMar<?=$years?>',this.value,'<?=$truckdatachk?>','Mar','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData8['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Apr'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TrafficLightApr<?=$years?>',this.value,'<?=$truckdatachk?>','Apr','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData8['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >May'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TrafficLightMay<?=$years?>',this.value,'<?=$truckdatachk?>','May','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData8['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">  
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TrafficLightJun<?=$years?>',this.value,'<?=$truckdatachk?>','Jun','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData8['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Jul'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TrafficLightJul<?=$years?>',this.value,'<?=$truckdatachk?>','Jul','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData8['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Aug'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TrafficLightAug<?=$years?>',this.value,'<?=$truckdatachk?>','Aug','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData8['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Sep'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TrafficLightSep<?=$years?>',this.value,'<?=$truckdatachk?>','Sep','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData8['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Oct'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TrafficLightOct<?=$years?>',this.value,'<?=$truckdatachk?>','Oct','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData8['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Nov'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TrafficLightNov<?=$years?>',this.value,'<?=$truckdatachk?>','Nov','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData8['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Dec'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TrafficLightDec<?=$years?>',this.value,'<?=$truckdatachk?>','Dec','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData8['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!--  Actual Checking-->
                                <?php
                                $sql_seData9 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='AgainstTrafJan".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jan' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='AgainstTrafFeb".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Feb' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='AgainstTrafMar".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Mar' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='AgainstTrafApr".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Apr' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='AgainstTrafMay".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='May' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='AgainstTrafJun".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jun' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='AgainstTrafJul".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jul' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='AgainstTrafAug".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Aug' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='AgainstTrafSep".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Sep' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='AgainstTrafOct".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Oct' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='AgainstTrafNov".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Nov' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='AgainstTrafDec".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Dec' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                $params_seData9  = array();
                                $query_seData9 = sqlsrv_query($conn, $sql_seData9, $params_seData9);
                                $result_seData9 = sqlsrv_fetch_array($query_seData9, SQLSRV_FETCH_ASSOC);

                                ?>
                                <div class="scol-lg-2">
                                    <label ><b><u>Against traffic law/TMT driving rules</u></b></label><br>
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AgainstTrafJan<?=$years?>',this.value,'<?=$truckdatachk?>','Jan','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData9['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Feb'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AgainstTrafFeb<?=$years?>',this.value,'<?=$truckdatachk?>','Feb','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData9['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Mar'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AgainstTrafMar<?=$years?>',this.value,'<?=$truckdatachk?>','Mar','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData9['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Apr'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AgainstTrafApr<?=$years?>',this.value,'<?=$truckdatachk?>','Apr','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData9['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >May'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AgainstTrafMay<?=$years?>',this.value,'<?=$truckdatachk?>','May','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData9['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">  
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AgainstTrafJun<?=$years?>',this.value,'<?=$truckdatachk?>','Jun','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData9['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Jul'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AgainstTrafJul<?=$years?>',this.value,'<?=$truckdatachk?>','Jul','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData9['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Aug'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AgainstTrafAug<?=$years?>',this.value,'<?=$truckdatachk?>','Aug','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData9['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Sep'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AgainstTrafSep<?=$years?>',this.value,'<?=$truckdatachk?>','Sep','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData9['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Oct'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AgainstTrafOct<?=$years?>',this.value,'<?=$truckdatachk?>','Oct','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData9['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Nov'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AgainstTrafNov<?=$years?>',this.value,'<?=$truckdatachk?>','Nov','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData9['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Dec'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AgainstTrafDec<?=$years?>',this.value,'<?=$truckdatachk?>','Dec','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData9['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- NG result -->
                                <div class="scol-lg-2">
                                <?php
                                $sql_seData10 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='RunOnShoulderJan".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jan' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='RunOnShoulderFeb".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Feb' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='RunOnShoulderMar".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Mar' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='RunOnShoulderApr".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Apr' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='RunOnShoulderMay".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='May' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='RunOnShoulderJun".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jun' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='RunOnShoulderJul".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jul' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='RunOnShoulderAug".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Aug' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='RunOnShoulderSep".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Sep' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='RunOnShoulderOct".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Oct' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='RunOnShoulderNov".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Nov' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='RunOnShoulderDec".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Dec' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                $params_seData10  = array();
                                $query_seData10 = sqlsrv_query($conn, $sql_seData10, $params_seData10);
                                $result_seData10 = sqlsrv_fetch_array($query_seData10, SQLSRV_FETCH_ASSOC);

                                ?>
                                <label ><b><u>Run on the shoulder</u></b></label><br>
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('RunOnShoulderJan<?=$years?>',this.value,'<?=$truckdatachk?>','Jan','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData10['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Feb'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('RunOnShoulderFeb<?=$years?>',this.value,'<?=$truckdatachk?>','Feb','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData10['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Mar'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('RunOnShoulderMar<?=$years?>',this.value,'<?=$truckdatachk?>','Mar','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData10['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Apr'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('RunOnShoulderApr<?=$years?>',this.value,'<?=$truckdatachk?>','Apr','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData10['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >May'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('RunOnShoulderMay<?=$years?>',this.value,'<?=$truckdatachk?>','May','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData10['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">  
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('RunOnShoulderJun<?=$years?>',this.value,'<?=$truckdatachk?>','Jun','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData10['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Jul'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('RunOnShoulderJul<?=$years?>',this.value,'<?=$truckdatachk?>','Jul','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData10['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Aug'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('RunOnShoulderAug<?=$years?>',this.value,'<?=$truckdatachk?>','Aug','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData10['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Sep'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('RunOnShoulderSep<?=$years?>',this.value,'<?=$truckdatachk?>','Sep','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData10['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Oct'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('RunOnShoulderOct<?=$years?>',this.value,'<?=$truckdatachk?>','Oct','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData10['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Nov'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('RunOnShoulderNov<?=$years?>',this.value,'<?=$truckdatachk?>','Nov','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData10['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Dec'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('RunOnShoulderDec<?=$years?>',this.value,'<?=$truckdatachk?>','Dec','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData10['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <?php
                                }else if ($truckdatachk == 'CabinCamera') {
                                ?>
                                <?php
                                $sql_seData11 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotFastSBJan".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jan' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotFastSBFeb".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Feb' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotFastSBMar".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Mar' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotFastSBApr".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Apr' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotFastSBMay".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='May' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotFastSBJun".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jun' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotFastSBJul".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jul' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotFastSBAug".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Aug' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotFastSBSep".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Sep' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotFastSBOct".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Oct' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotFastSBNov".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Nov' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotFastSBDec".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Dec' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                $params_seData11  = array();
                                $query_seData11 = sqlsrv_query($conn, $sql_seData11, $params_seData11);
                                $result_seData11 = sqlsrv_fetch_array($query_seData11, SQLSRV_FETCH_ASSOC);

                                ?>
                                <div class="scol-lg-2">  
                                    <label ><b><u>Not fasten seat belt</u></b></label><br>
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >Jan'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotFastSBJan<?=$years?>',this.value,'<?=$truckdatachk?>','Jan','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData11['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Feb'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotFastSBFeb<?=$years?>',this.value,'<?=$truckdatachk?>','Feb','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData11['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Mar'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotFastSBMar<?=$years?>',this.value,'<?=$truckdatachk?>','Mar','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData11['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Apr'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotFastSBApr<?=$years?>',this.value,'<?=$truckdatachk?>','Apr','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData11['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >May'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotFastSBMay<?=$years?>',this.value,'<?=$truckdatachk?>','May','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData11['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">  
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotFastSBJun<?=$years?>',this.value,'<?=$truckdatachk?>','Jun','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData11['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Jul'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotFastSBJul<?=$years?>',this.value,'<?=$truckdatachk?>','Jul','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData11['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Aug'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotFastSBAug<?=$years?>',this.value,'<?=$truckdatachk?>','Aug','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData11['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Sep'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotFastSBSep<?=$years?>',this.value,'<?=$truckdatachk?>','Sep','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData11['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Oct'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotFastSBOct<?=$years?>',this.value,'<?=$truckdatachk?>','Oct','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData11['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Nov'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotFastSBNov<?=$years?>',this.value,'<?=$truckdatachk?>','Nov','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData11['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Dec'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotFastSBDec<?=$years?>',this.value,'<?=$truckdatachk?>','Dec','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData11['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //Total Driver colunm2  -->
                                <?php
                                $sql_seData12 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='UseMobileJan".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jan' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='UseMobileFeb".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Feb' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='UseMobileMar".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Mar' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='UseMobileApr".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Apr' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='UseMobileMay".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='May' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='UseMobileJun".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jun' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='UseMobileJul".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jul' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='UseMobileAug".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Aug' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='UseMobileSep".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Sep' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='UseMobileOct".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Oct' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='UseMobileNov".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Nov' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='UseMobileDec".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Dec' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                $params_seData12  = array();
                                $query_seData12 = sqlsrv_query($conn, $sql_seData12, $params_seData12);
                                $result_seData12 = sqlsrv_fetch_array($query_seData12, SQLSRV_FETCH_ASSOC);

                                ?>
                                <div class="scol-lg-2">
                                    <label ><b><u>Use mobile phone while driving</u></b></label><br>
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('UseMobileJan<?=$years?>',this.value,'<?=$truckdatachk?>','Jan','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData12['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Feb'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('UseMobileFeb<?=$years?>',this.value,'<?=$truckdatachk?>','Feb','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData12['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Mar'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('UseMobileMar<?=$years?>',this.value,'<?=$truckdatachk?>','Mar','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData12['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Apr'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('UseMobileApr<?=$years?>',this.value,'<?=$truckdatachk?>','Apr','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData12['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >May'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('UseMobileMay<?=$years?>',this.value,'<?=$truckdatachk?>','May','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData12['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">   
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('UseMobileJun<?=$years?>',this.value,'<?=$truckdatachk?>','Jun','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData12['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Jul'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('UseMobileJul<?=$years?>',this.value,'<?=$truckdatachk?>','Jul','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData12['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Aug'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('UseMobileAug<?=$years?>',this.value,'<?=$truckdatachk?>','Aug','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData12['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Sep'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('UseMobileSep<?=$years?>',this.value,'<?=$truckdatachk?>','Sep','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData12['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Oct'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('UseMobileOct<?=$years?>',this.value,'<?=$truckdatachk?>','Oct','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData12['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Nov'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('UseMobileNov<?=$years?>',this.value,'<?=$truckdatachk?>','Nov','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData12['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Dec'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('UseMobileDec<?=$years?>',this.value,'<?=$truckdatachk?>','Dec','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData12['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //Plan Checking  colunm3  -->
                                <?php
                                $sql_seData13 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='FeelDrowsyJan".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jan' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='FeelDrowsyFeb".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Feb' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='FeelDrowsyMar".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Mar' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='FeelDrowsyApr".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Apr' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='FeelDrowsyMay".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='May' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='FeelDrowsyJun".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jun' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='FeelDrowsyJul".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jul' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='FeelDrowsyAug".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Aug' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='FeelDrowsySep".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Sep' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='FeelDrowsyOct".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Oct' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='FeelDrowsyNov".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Nov' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='FeelDrowsyDec".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Dec' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                $params_seData13  = array();
                                $query_seData13 = sqlsrv_query($conn, $sql_seData13, $params_seData13);
                                $result_seData13 = sqlsrv_fetch_array($query_seData13, SQLSRV_FETCH_ASSOC);

                                ?>
                                <div class="scol-lg-2">
                                    <label ><b><u>Feel drowsy</u></b></label><br>
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('FeelDrowsyJan<?=$years?>',this.value,'<?=$truckdatachk?>','Jan','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData13['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Feb'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('FeelDrowsyFeb<?=$years?>',this.value,'<?=$truckdatachk?>','Feb','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData13['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Mar'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('FeelDrowsyMar<?=$years?>',this.value,'<?=$truckdatachk?>','Mar','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData13['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Apr'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('FeelDrowsyApr<?=$years?>',this.value,'<?=$truckdatachk?>','Apr','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData13['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >May'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('FeelDrowsyMay<?=$years?>',this.value,'<?=$truckdatachk?>','May','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData13['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">  
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('FeelDrowsyJun<?=$years?>',this.value,'<?=$truckdatachk?>','Jun','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData13['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Jul'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('FeelDrowsyJul<?=$years?>',this.value,'<?=$truckdatachk?>','Jul','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData13['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Aug'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('FeelDrowsyAug<?=$years?>',this.value,'<?=$truckdatachk?>','Aug','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData13['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Sep'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('FeelDrowsySep<?=$years?>',this.value,'<?=$truckdatachk?>','Sep','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData13['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Oct'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('FeelDrowsyOct<?=$years?>',this.value,'<?=$truckdatachk?>','Oct','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData13['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Nov'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('FeelDrowsyNov<?=$years?>',this.value,'<?=$truckdatachk?>','Nov','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData13['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Dec'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('FeelDrowsyDec<?=$years?>',this.value,'<?=$truckdatachk?>','Dec','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData13['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!--  Actual Checking-->
                                <?php
                                $sql_seData14 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotConcenJan".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jan' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotConcenFeb".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Feb' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotConcenMar".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Mar' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotConcenApr".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Apr' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotConcenMay".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='May' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotConcenJun".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jun' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotConcenJul".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jul' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotConcenAug".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Aug' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotConcenSep".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Sep' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotConcenOct".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Oct' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotConcenNov".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Nov' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotConcenDec".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Dec' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                $params_seData14 = array();
                                $query_seData14 = sqlsrv_query($conn, $sql_seData14, $params_seData14);
                                $result_seData14 = sqlsrv_fetch_array($query_seData14, SQLSRV_FETCH_ASSOC);

                                ?>
                                <div class="scol-lg-2">
                                    <label ><b><u>Not concentrate</u></b></label><br>
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotConcenJan<?=$years?>',this.value,'<?=$truckdatachk?>','Jan','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData14['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Feb'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotConcenFeb<?=$years?>',this.value,'<?=$truckdatachk?>','Feb','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData14['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Mar'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotConcenMar<?=$years?>',this.value,'<?=$truckdatachk?>','Mar','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData14['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Apr'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotConcenApr<?=$years?>',this.value,'<?=$truckdatachk?>','Apr','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData14['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >May'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotConcenMay<?=$years?>',this.value,'<?=$truckdatachk?>','May','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData14['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">  
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotConcenJun<?=$years?>',this.value,'<?=$truckdatachk?>','Jun','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData14['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Jul'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotConcenJul<?=$years?>',this.value,'<?=$truckdatachk?>','Jul','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData14['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Aug'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotConcenAug<?=$years?>',this.value,'<?=$truckdatachk?>','Aug','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData14['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Sep'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotConcenSep<?=$years?>',this.value,'<?=$truckdatachk?>','Sep','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData14['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Oct'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotConcenOct<?=$years?>',this.value,'<?=$truckdatachk?>','Oct','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData14['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Nov'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotConcenNov<?=$years?>',this.value,'<?=$truckdatachk?>','Nov','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData14['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Dec'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotConcenDec<?=$years?>',this.value,'<?=$truckdatachk?>','Dec','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData14['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- NG result -->
                                <?php
                                $sql_seData15 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotKeep5SJan".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jan' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotKeep5SFeb".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Feb' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotKeep5SMar".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Mar' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotKeep5SApr".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Apr' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotKeep5SMay".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='May' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotKeep5SJun".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jun' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotKeep5SJul".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jul' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotKeep5SAug".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Aug' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotKeep5SSep".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Sep' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotKeep5SOct".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Oct' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotKeep5SNov".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Nov' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='NotKeep5SDec".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Dec' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                $params_seData15  = array();
                                $query_seData15 = sqlsrv_query($conn, $sql_seData15, $params_seData15);
                                $result_seData15 = sqlsrv_fetch_array($query_seData15, SQLSRV_FETCH_ASSOC);

                                ?>
                                <div class="scol-lg-2">
                                    <label ><b><u>Not keep 5S in cabin</u></b></label><br>
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >Jan'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotKeep5SJan<?=$years?>',this.value,'<?=$truckdatachk?>','Jan','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData15['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Feb'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotKeep5SFeb<?=$years?>',this.value,'<?=$truckdatachk?>','Feb','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData15['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Mar'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotKeep5SMar<?=$years?>',this.value,'<?=$truckdatachk?>','Mar','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData15['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Apr'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotKeep5SApr<?=$years?>',this.value,'<?=$truckdatachk?>','Apr','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData15['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >May'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotKeep5SMay<?=$years?>',this.value,'<?=$truckdatachk?>','May','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData15['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">   
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotKeep5SJun<?=$years?>',this.value,'<?=$truckdatachk?>','Jun','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData15['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Jul'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotKeep5SJul<?=$years?>',this.value,'<?=$truckdatachk?>','Jul','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData15['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Aug'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotKeep5SAug<?=$years?>',this.value,'<?=$truckdatachk?>','Aug','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData15['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Sep'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotKeep5SSep<?=$years?>',this.value,'<?=$truckdatachk?>','Sep','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData15['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Oct'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotKeep5SOct<?=$years?>',this.value,'<?=$truckdatachk?>','Oct','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData15['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Nov'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotKeep5SNov<?=$years?>',this.value,'<?=$truckdatachk?>','Nov','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData15['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Dec'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('NotKeep5SDec<?=$years?>',this.value,'<?=$truckdatachk?>','Dec','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData15['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- NG result -->
                                <?php
                                $sql_seData16 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='HoldSteeringJan".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jan' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='HoldSteeringFeb".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Feb' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='HoldSteeringMar".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Mar' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='HoldSteeringApr".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Apr' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='HoldSteeringMay".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='May' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='HoldSteeringJun".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jun' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='HoldSteeringJul".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jul' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='HoldSteeringAug".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Aug' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='HoldSteeringSep".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Sep' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='HoldSteeringOct".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Oct' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='HoldSteeringNov".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Nov' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                WHERE DATE_PROCESS ='HoldSteeringDec".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Dec' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                $params_seData16  = array();
                                $query_seData16 = sqlsrv_query($conn, $sql_seData16, $params_seData16);
                                $result_seData16 = sqlsrv_fetch_array($query_seData16, SQLSRV_FETCH_ASSOC);

                                ?>
                                <div class="scol-lg-2">
                                    <label ><b><u>Hold the steering wheel and correct sitting position</u></b></label><br>
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('HoldSteeringJan<?=$years?>',this.value,'<?=$truckdatachk?>','Jan','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData16['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Feb'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('HoldSteeringFeb<?=$years?>',this.value,'<?=$truckdatachk?>','Feb','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData16['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Mar'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('HoldSteeringMar<?=$years?>',this.value,'<?=$truckdatachk?>','Mar','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData16['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Apr'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('HoldSteeringApr<?=$years?>',this.value,'<?=$truckdatachk?>','Apr','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData16['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >May'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('HoldSteeringMay<?=$years?>',this.value,'<?=$truckdatachk?>','May','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData16['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">  
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('HoldSteeringJun<?=$years?>',this.value,'<?=$truckdatachk?>','Jun','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData16['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Jul'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('HoldSteeringJul<?=$years?>',this.value,'<?=$truckdatachk?>','Jul','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData16['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Aug'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('HoldSteeringAug<?=$years?>',this.value,'<?=$truckdatachk?>','Aug','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData16['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Sep'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('HoldSteeringSep<?=$years?>',this.value,'<?=$truckdatachk?>','Sep','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData16['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Oct'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('HoldSteeringOct<?=$years?>',this.value,'<?=$truckdatachk?>','Oct','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData16['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Nov'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('HoldSteeringNov<?=$years?>',this.value,'<?=$truckdatachk?>','Nov','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData16['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Dec'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('HoldSteeringDec<?=$years?>',this.value,'<?=$truckdatachk?>','Dec','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData16['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <?php
                                }else{
                                ?>
                                <label ><b><u>Out Of Data</u></b></label><br>
                                <?php
                                }
                                ?>         
                                
                            </div> <!-- END TOP ROW-->

                        </div>
                    </div>
                    <!-- .panel-body -->
                </div>
                <!-- /.panel -->
            </div>
        </div>
            <!-- END ROW2 OK Driver -->
