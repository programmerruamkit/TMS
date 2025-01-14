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

if ($truckdatachk == 'Personal') {
    $truckdata = 'Personal issue';
}else if ($truckdatachk == 'External') {
    $truckdata = 'External issue';
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
                &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_searchTruckReadiness('Personal')">Personal issue</button>
                &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_searchTruckReadiness('External')">External issue</button>
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
                                if ($truckdatachk == 'Personal') {
                                ?>
                                <!-- QueryData -->
                                <?php
                                $sql_seData1 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='TenkoPerJan".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jan' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='TenkoPerFeb".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Feb' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='TenkoPerMar".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Mar' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='TenkoPerApr".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Apr' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='TenkoPerMay".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='May' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='TenkoPerJun".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jun' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='TenkoPerJul".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jul' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='TenkoPerAug".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Aug' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='TenkoPerSep".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Sep' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='TenkoPerOct".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Oct' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='TenkoPerNov".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Nov' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='TenkoPerDec".$years."' 
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
                                            <label ><b><u>Tenko</u></b></label><br>
                                            <label >Jan'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TenkoPerJan<?=$years?>',this.value,'<?=$truckdatachk?>','Jan','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData1['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Feb'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TenkoPerFeb<?=$years?>',this.value,'<?=$truckdatachk?>','Feb','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData1['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Mar'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TenkoPerMar<?=$years?>',this.value,'<?=$truckdatachk?>','Mar','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData1['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Apr'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TenkoPerApr<?=$years?>',this.value,'<?=$truckdatachk?>','Apr','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData1['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >May'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TenkoPerMay<?=$years?>',this.value,'<?=$truckdatachk?>','May','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData1['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>   
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TenkoPerJun<?=$years?>',this.value,'<?=$truckdatachk?>','Jun','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData1['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Jul'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TenkoPerJul<?=$years?>',this.value,'<?=$truckdatachk?>','Jul','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData1['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Aug'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TenkoPerAug<?=$years?>',this.value,'<?=$truckdatachk?>','Aug','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData1['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Sep'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TenkoPerSep<?=$years?>',this.value,'<?=$truckdatachk?>','Sep','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData1['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Oct'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TenkoPerOct<?=$years?>',this.value,'<?=$truckdatachk?>','Oct','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData1['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Nov'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TenkoPerNov<?=$years?>',this.value,'<?=$truckdatachk?>','Nov','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData1['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Dec'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TenkoPerDec<?=$years?>',this.value,'<?=$truckdatachk?>','Dec','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData1['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //Total Driver colunm2  -->
                                <?php
                                $sql_seData2 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='OnthewayPerJan".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jan' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='OnthewayPerFeb".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Feb' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='OnthewayPerMar".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Mar' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='OnthewayPerApr".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Apr' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='OnthewayPerMay".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='May' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='OnthewayPerJun".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jun' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='OnthewayPerJul".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jul' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='OnthewayPerAug".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Aug' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='OnthewayPerSep".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Sep' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='OnthewayPerOct".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Oct' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='OnthewayPerNov".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Nov' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='OnthewayPerDec".$years."' 
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
                                            <label ><b><u>On the way</u></b></label><br>
                                            <label >Jan'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('OnthewayPerJan<?=$years?>',this.value,'<?=$truckdatachk?>','Jan','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData2['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Feb'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('OnthewayPerFeb<?=$years?>',this.value,'<?=$truckdatachk?>','Feb','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData2['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Mar'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('OnthewayPerMar<?=$years?>',this.value,'<?=$truckdatachk?>','Mar','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData2['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Apr'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('OnthewayPerApr<?=$years?>',this.value,'<?=$truckdatachk?>','Apr','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData2['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >May'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('OnthewayPerMay<?=$years?>',this.value,'<?=$truckdatachk?>','May','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData2['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>   
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('OnthewayPerJun<?=$years?>',this.value,'<?=$truckdatachk?>','Jun','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData2['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Jul'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('OnthewayPerJul<?=$years?>',this.value,'<?=$truckdatachk?>','Jul','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData2['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Aug'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('OnthewayPerAug<?=$years?>',this.value,'<?=$truckdatachk?>','Aug','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData2['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Sep'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('OnthewayPerSep<?=$years?>',this.value,'<?=$truckdatachk?>','Sep','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData2['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Oct'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('OnthewayPerOct<?=$years?>',this.value,'<?=$truckdatachk?>','Oct','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData2['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Nov'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('OnthewayPerNov<?=$years?>',this.value,'<?=$truckdatachk?>','Nov','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData2['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Dec'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('OnthewayPerDec<?=$years?>',this.value,'<?=$truckdatachk?>','Dec','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData2['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //Plan Checking  colunm3  -->
                                <?php
                                $sql_seData3 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AtplantPerJan".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jan' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AtplantPerFeb".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Feb' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AtplantPerMar".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Mar' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AtplantPerApr".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Apr' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AtplantPerMay".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='May' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AtplantPerJun".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jun' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AtplantPerJul".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jul' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AtplantPerAug".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Aug' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AtplantPerSep".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Sep' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AtplantPerOct".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Oct' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AtplantPerNov".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Nov' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AtplantPerDec".$years."' 
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
                                            <label ><b><u>at Supplier Plant</u></b></label><br>
                                            <label >Jan'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AtplantPerJan<?=$years?>',this.value,'<?=$truckdatachk?>','Jan','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData3['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Feb'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AtplantPerFeb<?=$years?>',this.value,'<?=$truckdatachk?>','Feb','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData3['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Mar'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AtplantPerMar<?=$years?>',this.value,'<?=$truckdatachk?>','Mar','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData3['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Apr'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AtplantPerApr<?=$years?>',this.value,'<?=$truckdatachk?>','Apr','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData3['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >May'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AtplantPerMay<?=$years?>',this.value,'<?=$truckdatachk?>','May','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData3['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>   
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AtplantPerJun<?=$years?>',this.value,'<?=$truckdatachk?>','Jun','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData3['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Jul'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AtplantPerJul<?=$years?>',this.value,'<?=$truckdatachk?>','Jul','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData3['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Aug'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AtplantPerAug<?=$years?>',this.value,'<?=$truckdatachk?>','Aug','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData3['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Sep'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AtplantPerSep<?=$years?>',this.value,'<?=$truckdatachk?>','Sep','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData3['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Oct'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AtplantPerOct<?=$years?>',this.value,'<?=$truckdatachk?>','Oct','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData3['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Nov'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AtplantPerNov<?=$years?>',this.value,'<?=$truckdatachk?>','Nov','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData3['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Dec'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AtplantPerDec<?=$years?>',this.value,'<?=$truckdatachk?>','Dec','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData3['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!--  Actual Checking-->
                                <?php
                                $sql_seData4 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttoyotaPerJan".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jan' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttoyotaPerFeb".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Feb' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttoyotaPerMar".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Mar' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttoyotaPerApr".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Apr' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttoyotaPerMay".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='May' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttoyotaPerJun".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jun' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttoyotaPerJul".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jul' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttoyotaPerAug".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Aug' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttoyotaPerSep".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Sep' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttoyotaPerOct".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Oct' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttoyotaPerNov".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Nov' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttoyotaPerDec".$years."' 
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
                                            <label ><b><u>at TOYOTA</u></b></label><br>
                                            <label >Jan'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttoyotaPerJan<?=$years?>',this.value,'<?=$truckdatachk?>','Jan','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData4['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Feb'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttoyotaPerFeb<?=$years?>',this.value,'<?=$truckdatachk?>','Feb','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData4['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Mar'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttoyotaPerMar<?=$years?>',this.value,'<?=$truckdatachk?>','Mar','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData4['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Apr'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttoyotaPerApr<?=$years?>',this.value,'<?=$truckdatachk?>','Apr','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData4['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >May'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttoyotaPerMay<?=$years?>',this.value,'<?=$truckdatachk?>','May','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData4['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>   
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttoyotaPerJun<?=$years?>',this.value,'<?=$truckdatachk?>','Jun','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData4['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Jul'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttoyotaPerJul<?=$years?>',this.value,'<?=$truckdatachk?>','Jul','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData4['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Aug'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttoyotaPerAug<?=$years?>',this.value,'<?=$truckdatachk?>','Aug','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData4['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Sep'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttoyotaPerSep<?=$years?>',this.value,'<?=$truckdatachk?>','Sep','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData4['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Oct'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttoyotaPerOct<?=$years?>',this.value,'<?=$truckdatachk?>','Oct','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData4['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Nov'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttoyotaPerNov<?=$years?>',this.value,'<?=$truckdatachk?>','Nov','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData4['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Dec'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttoyotaPerDec<?=$years?>',this.value,'<?=$truckdatachk?>','Dec','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData4['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- NG result -->
                                <?php
                                $sql_seData5 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='SubtotalPerJan".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jan' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='SubtotalPerFeb".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Feb' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='SubtotalPerMar".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Mar' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='SubtotalPerApr".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Apr' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='SubtotalPerMay".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='May' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='SubtotalPerJun".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jun' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='SubtotalPerJul".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jul' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='SubtotalPerAug".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Aug' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='SubtotalPerSep".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Sep' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='SubtotalPerOct".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Oct' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='SubtotalPerNov".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Nov' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='SubtotalPerDec".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Dec' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                $params_seData5  = array();
                                $query_seData5 = sqlsrv_query($conn, $sql_seData5, $params_seData5);
                                $result_seData5 = sqlsrv_fetch_array($query_seData5, SQLSRV_FETCH_ASSOC);
                                
                                $subper1 = $result_seData1['DATA1']+$result_seData2['DATA1']+$result_seData3['DATA1']+$result_seData4['DATA1'];
                                $subper2 = $result_seData1['DATA2']+$result_seData2['DATA2']+$result_seData3['DATA2']+$result_seData4['DATA2'];
                                $subper3 = $result_seData1['DATA3']+$result_seData2['DATA3']+$result_seData3['DATA3']+$result_seData4['DATA3'];
                                $subper4 = $result_seData1['DATA4']+$result_seData2['DATA4']+$result_seData3['DATA4']+$result_seData4['DATA4'];
                                $subper5 = $result_seData1['DATA5']+$result_seData2['DATA5']+$result_seData3['DATA5']+$result_seData4['DATA5'];
                                $subper6 = $result_seData1['DATA6']+$result_seData2['DATA6']+$result_seData3['DATA6']+$result_seData4['DATA6'];
                                $subper7 = $result_seData1['DATA7']+$result_seData2['DATA7']+$result_seData3['DATA7']+$result_seData4['DATA7'];
                                $subper8 = $result_seData1['DATA8']+$result_seData2['DATA8']+$result_seData3['DATA8']+$result_seData4['DATA8'];
                                $subper9 = $result_seData1['DATA9']+$result_seData2['DATA9']+$result_seData3['DATA9']+$result_seData4['DATA9'];
                                $subper10 = $result_seData1['DATA10']+$result_seData2['DATA10']+$result_seData3['DATA10']+$result_seData4['DATA10'];
                                $subper11 = $result_seData1['DATA11']+$result_seData2['DATA11']+$result_seData3['DATA11']+$result_seData4['DATA11'];
                                $subper12 = $result_seData1['DATA12']+$result_seData2['DATA12']+$result_seData3['DATA12']+$result_seData4['DATA12'];

                                ?>
                                <div class="scol-lg-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label ><u>Subtotal</u></label><br>
                                            <label >Jan'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input disabled size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('SubtotalPerJan<?=$years?>',this.value,'<?=$truckdatachk?>','Jan','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$subper1?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Feb'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input disabled size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('SubtotalPerFeb<?=$years?>',this.value,'<?=$truckdatachk?>','Feb','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$subper2?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Mar'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input disabled size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('SubtotalPerMar<?=$years?>',this.value,'<?=$truckdatachk?>','Mar','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$subper3?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Apr'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input disabled size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('SubtotalPerApr<?=$years?>',this.value,'<?=$truckdatachk?>','Apr','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$subper4?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >May'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input disabled size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('SubtotalPerMay<?=$years?>',this.value,'<?=$truckdatachk?>','May','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$subper5?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>   
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input disabled size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('SubtotalPerJun<?=$years?>',this.value,'<?=$truckdatachk?>','Jun','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$subper6?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Jul'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input disabled size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('SubtotalPerJul<?=$years?>',this.value,'<?=$truckdatachk?>','Jul','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$subper7?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Aug'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input disabled size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('SubtotalPerAug<?=$years?>',this.value,'<?=$truckdatachk?>','Aug','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$subper8?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Sep'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input disabled size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('SubtotalPerSep<?=$years?>',this.value,'<?=$truckdatachk?>','Sep','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$subper9?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Oct'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input disabled size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('SubtotalPerOct<?=$years?>',this.value,'<?=$truckdatachk?>','Oct','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$subper10?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Nov'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input disabled size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('SubtotalPerNov<?=$years?>',this.value,'<?=$truckdatachk?>','Nov','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$subper11?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label ></label><br>
                                            <label >Dec'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input disabled size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('SubtotalPerDec<?=$years?>',this.value,'<?=$truckdatachk?>','Dec','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$subper12?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>

                                <?php
                                }else if ($truckdatachk == 'External') {
                                ?>
                                <?php
                                $sql_seData6 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='TenkoExtJan".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jan' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='TenkoExtFeb".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Feb' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='TenkoExtMar".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Mar' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='TenkoExtApr".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Apr' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='TenkoExtMay".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='May' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='TenkoExtJun".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jun' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='TenkoExtJul".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jul' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='TenkoExtAug".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Aug' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='TenkoExtSep".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Sep' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='TenkoExtOct".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Oct' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='TenkoExtNov".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Nov' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='TenkoExtDec".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Dec' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                $params_seData6  = array();
                                $query_seData6 = sqlsrv_query($conn, $sql_seData6, $params_seData6);
                                $result_seData6 = sqlsrv_fetch_array($query_seData6, SQLSRV_FETCH_ASSOC);

                                ?>
                                <div class="scol-lg-2">
                                <label ><b><u>Tenko</u></b></label><br>
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >Jan'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TenkoExtJan<?=$years?>',this.value,'<?=$truckdatachk?>','Jan','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData6['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Feb'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TenkoExtFeb<?=$years?>',this.value,'<?=$truckdatachk?>','Feb','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData6['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Mar'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TenkoExtMar<?=$years?>',this.value,'<?=$truckdatachk?>','Mar','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData6['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Apr'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TenkoExtApr<?=$years?>',this.value,'<?=$truckdatachk?>','Apr','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData6['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >May'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TenkoExtMay<?=$years?>',this.value,'<?=$truckdatachk?>','May','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData6['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">  
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TenkoExtJun<?=$years?>',this.value,'<?=$truckdatachk?>','Jun','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData6['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Jul'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TenkoExtJul<?=$years?>',this.value,'<?=$truckdatachk?>','Jul','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData6['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Aug'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TenkoExtAug<?=$years?>',this.value,'<?=$truckdatachk?>','Aug','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData6['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Sep'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TenkoExtSep<?=$years?>',this.value,'<?=$truckdatachk?>','Sep','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData6['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Oct'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TenkoExtOct<?=$years?>',this.value,'<?=$truckdatachk?>','Oct','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData6['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Nov'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TenkoExtNov<?=$years?>',this.value,'<?=$truckdatachk?>','Nov','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData6['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Dec'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('TenkoExtDec<?=$years?>',this.value,'<?=$truckdatachk?>','Dec','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData6['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //Total Driver colunm2  -->
                                <?php
                                $sql_seData7 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='OnthewayExtJan".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jan' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='OnthewayExtFeb".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Feb' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='OnthewayExtMar".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Mar' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='OnthewayExtApr".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Apr' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='OnthewayExtMay".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='May' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='OnthewayExtJun".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jun' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='OnthewayExtJul".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jul' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='OnthewayExtAug".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Aug' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='OnthewayExtSep".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Sep' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='OnthewayExtOct".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Oct' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='OnthewayExtNov".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Nov' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='OnthewayExtDec".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Dec' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                $params_seData7  = array();
                                $query_seData7 = sqlsrv_query($conn, $sql_seData7, $params_seData7);
                                $result_seData7 = sqlsrv_fetch_array($query_seData7, SQLSRV_FETCH_ASSOC);

                                ?>
                                <div class="scol-lg-2">
                                    <label ><b><u>On the way</u></b></label><br>
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >Jan'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('OnthewayExtJan<?=$years?>',this.value,'<?=$truckdatachk?>','Jan','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData7['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Feb'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('OnthewayExtFeb<?=$years?>',this.value,'<?=$truckdatachk?>','Feb','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData7['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Mar'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('OnthewayExtMar<?=$years?>',this.value,'<?=$truckdatachk?>','Mar','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData7['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Apr'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('OnthewayExtApr<?=$years?>',this.value,'<?=$truckdatachk?>','Apr','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData7['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >May'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('OnthewayExtMay<?=$years?>',this.value,'<?=$truckdatachk?>','May','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData7['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">  
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('OnthewayExtJun<?=$years?>',this.value,'<?=$truckdatachk?>','Jun','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData7['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Jul'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('OnthewayExtJul<?=$years?>',this.value,'<?=$truckdatachk?>','Jul','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData6['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Aug'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('OnthewayExtAug<?=$years?>',this.value,'<?=$truckdatachk?>','Aug','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData7['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Sep'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('OnthewayExtSep<?=$years?>',this.value,'<?=$truckdatachk?>','Sep','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData7['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Oct'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('OnthewayExtOct<?=$years?>',this.value,'<?=$truckdatachk?>','Oct','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData7['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Nov'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('OnthewayExtNov<?=$years?>',this.value,'<?=$truckdatachk?>','Nov','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData7['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Dec'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('OnthewayExtDec<?=$years?>',this.value,'<?=$truckdatachk?>','Dec','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData7['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- //Plan Checking  colunm3  -->
                                <?php
                                $sql_seData8 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttplantExtJan".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jan' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttplantExtFeb".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Feb' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttplantExtMar".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Mar' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttplantExtApr".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Apr' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttplantExtMay".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='May' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttplantExtJun".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jun' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttplantExtJul".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jul' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttplantExtAug".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Aug' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttplantExtSep".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Sep' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttplantExtOct".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Oct' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttplantExtNov".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Nov' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttplantExtDec".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Dec' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                $params_seData8  = array();
                                $query_seData8 = sqlsrv_query($conn, $sql_seData8, $params_seData8);
                                $result_seData8 = sqlsrv_fetch_array($query_seData8, SQLSRV_FETCH_ASSOC);

                                ?>
                                <div class="scol-lg-2">
                                    <label ><b><u>at Supplier Plant</u></b></label><br>
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >Jan'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttplantExtJan<?=$years?>',this.value,'<?=$truckdatachk?>','Jan','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData8['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Feb'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttplantExtFeb<?=$years?>',this.value,'<?=$truckdatachk?>','Feb','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData8['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Mar'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttplantExtMar<?=$years?>',this.value,'<?=$truckdatachk?>','Mar','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData8['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Apr'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttplantExtApr<?=$years?>',this.value,'<?=$truckdatachk?>','Apr','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData8['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >May'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttplantExtMay<?=$years?>',this.value,'<?=$truckdatachk?>','May','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData8['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">  
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttplantExtJun<?=$years?>',this.value,'<?=$truckdatachk?>','Jun','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData8['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Jul'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttplantExtJul<?=$years?>',this.value,'<?=$truckdatachk?>','Jul','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData8['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Aug'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttplantExtAug<?=$years?>',this.value,'<?=$truckdatachk?>','Aug','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData8['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Sep'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttplantExtSep<?=$years?>',this.value,'<?=$truckdatachk?>','Sep','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData8['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Oct'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttplantExtOct<?=$years?>',this.value,'<?=$truckdatachk?>','Oct','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData8['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Nov'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttplantExtNov<?=$years?>',this.value,'<?=$truckdatachk?>','Nov','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData8['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Dec'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttplantExtDec<?=$years?>',this.value,'<?=$truckdatachk?>','Dec','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData8['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!--  Actual Checking-->
                                <?php
                                $sql_seData9 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttoyotaExtJan".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jan' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttoyotaExtFeb".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Feb' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttoyotaExtMar".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Mar' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttoyotaExtApr".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Apr' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttoyotaExtMay".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='May' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttoyotaExtJun".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jun' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttoyotaExtJul".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jul' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttoyotaExtAug".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Aug' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttoyotaExtSep".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Sep' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttoyotaExtOct".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Oct' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttoyotaExtNov".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Nov' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='AttoyotaExtDec".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Dec' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                $params_seData9  = array();
                                $query_seData9 = sqlsrv_query($conn, $sql_seData9, $params_seData9);
                                $result_seData9 = sqlsrv_fetch_array($query_seData9, SQLSRV_FETCH_ASSOC);

                                ?>
                                <div class="scol-lg-2">
                                    <label ><b><u>at TOYOTA</u></b></label><br>
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >Jan'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttoyotaExtJan<?=$years?>',this.value,'<?=$truckdatachk?>','Jan','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$result_seData9['DATA1']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Feb'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttoyotaExtFeb<?=$years?>',this.value,'<?=$truckdatachk?>','Feb','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$result_seData9['DATA2']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Mar'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttoyotaExtMar<?=$years?>',this.value,'<?=$truckdatachk?>','Mar','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$result_seData9['DATA3']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Apr'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttoyotaExtApr<?=$years?>',this.value,'<?=$truckdatachk?>','Apr','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$result_seData9['DATA4']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >May'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttoyotaExtMay<?=$years?>',this.value,'<?=$truckdatachk?>','May','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$result_seData9['DATA5']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">  
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttoyotaExtJun<?=$years?>',this.value,'<?=$truckdatachk?>','Jun','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$result_seData9['DATA6']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Jul'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttoyotaExtJul<?=$years?>',this.value,'<?=$truckdatachk?>','Jul','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$result_seData9['DATA7']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Aug'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttoyotaExtAug<?=$years?>',this.value,'<?=$truckdatachk?>','Aug','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$result_seData9['DATA8']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Sep'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttoyotaExtSep<?=$years?>',this.value,'<?=$truckdatachk?>','Sep','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$result_seData9['DATA9']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Oct'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttoyotaExtOct<?=$years?>',this.value,'<?=$truckdatachk?>','Oct','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$result_seData9['DATA10']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Nov'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttoyotaExtNov<?=$years?>',this.value,'<?=$truckdatachk?>','Nov','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$result_seData9['DATA11']?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Dec'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('AttoyotaExtDec<?=$years?>',this.value,'<?=$truckdatachk?>','Dec','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$result_seData9['DATA12']?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <!-- NG result -->
                                <div class="scol-lg-2">
                                <?php
                                $sql_seData10 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='SubtotalExtJan".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jan' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='SubtotalExtFeb".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Feb' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='SubtotalExtMar".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Mar' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='SubtotalExtApr".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Apr' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='SubtotalExtMay".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='May' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='SubtotalExtJun".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jun' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='SubtotalExtJul".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Jul' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='SubtotalExtAug".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Aug' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='SubtotalExtSep".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Sep' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='SubtotalExtOct".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Oct' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='SubtotalExtNov".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Nov' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                WHERE DATE_PROCESS ='SubtotalExtDec".$years."' 
                                AND REMARK ='".$truckdatachk."' 
                                AND REMARK_MONTH ='Dec' 
                                AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                $params_seData10  = array();
                                $query_seData10 = sqlsrv_query($conn, $sql_seData10, $params_seData10);
                                $result_seData10 = sqlsrv_fetch_array($query_seData10, SQLSRV_FETCH_ASSOC);
                                    
                                $subext1 = $result_seData6['DATA1']+$result_seData7['DATA1']+$result_seData8['DATA1']+$result_seData9['DATA1'];
                                $subext2 = $result_seData6['DATA2']+$result_seData7['DATA2']+$result_seData8['DATA2']+$result_seData9['DATA2'];
                                $subext3 = $result_seData6['DATA3']+$result_seData7['DATA3']+$result_seData8['DATA3']+$result_seData9['DATA3'];
                                $subext4 = $result_seData6['DATA4']+$result_seData7['DATA4']+$result_seData8['DATA4']+$result_seData9['DATA4'];
                                $subext5 = $result_seData6['DATA5']+$result_seData7['DATA5']+$result_seData8['DATA5']+$result_seData9['DATA5'];
                                $subext6 = $result_seData6['DATA6']+$result_seData7['DATA6']+$result_seData8['DATA6']+$result_seData9['DATA6'];
                                $subext7 = $result_seData6['DATA7']+$result_seData7['DATA7']+$result_seData8['DATA7']+$result_seData9['DATA7'];
                                $subext8 = $result_seData6['DATA8']+$result_seData7['DATA8']+$result_seData8['DATA8']+$result_seData9['DATA8'];
                                $subext9 = $result_seData6['DATA9']+$result_seData7['DATA9']+$result_seData8['DATA9']+$result_seData9['DATA9'];
                                $subext10 = $result_seData6['DATA10']+$result_seData7['DATA10']+$result_seData8['DATA10']+$result_seData9['DATA10'];
                                $subext11 = $result_seData6['DATA11']+$result_seData7['DATA11']+$result_seData8['DATA11']+$result_seData9['DATA11'];
                                $subext12 = $result_seData6['DATA12']+$result_seData7['DATA12']+$result_seData8['DATA12']+$result_seData9['DATA12'];    

                                ?>
                                <label ><b><u>Subtotal</u></b></label><br>
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label >Jan'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input disabled size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('SubtotalExtJan<?=$years?>',this.value,'<?=$truckdatachk?>','Jan','<?=$years?>');}" class="form-control" id="txt_data1" name="txt_data1" value= "<?=$subext1?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Feb'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input disabled size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('SubtotalExtFeb<?=$years?>',this.value,'<?=$truckdatachk?>','Feb','<?=$years?>');}" class="form-control" id="txt_data2" name="txt_data2" value= "<?=$subext2?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Mar'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input disabled size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('SubtotalExtMar<?=$years?>',this.value,'<?=$truckdatachk?>','Mar','<?=$years?>');}" class="form-control" id="txt_data3" name="txt_data3" value= "<?=$subext3?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Apr'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input disabled size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('SubtotalExtApr<?=$years?>',this.value,'<?=$truckdatachk?>','Apr','<?=$years?>');}" class="form-control" id="txt_data4" name="txt_data4" value= "<?=$subext4?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >May'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input disabled size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('SubtotalExtMay<?=$years?>',this.value,'<?=$truckdatachk?>','May','<?=$years?>');}" class="form-control" id="txt_data5" name="txt_data5" value= "<?=$subext5?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">  
                                            <label >Jun'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input disabled size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('SubtotalExtJun<?=$years?>',this.value,'<?=$truckdatachk?>','Jun','<?=$years?>');}" class="form-control" id="txt_data6" name="txt_data6" value= "<?=$subext6?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Jul'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input disabled size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('SubtotalExtJul<?=$years?>',this.value,'<?=$truckdatachk?>','Jul','<?=$years?>');}" class="form-control" id="txt_data7" name="txt_data7" value= "<?=$subext7?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Aug'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input disabled size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('SubtotalExtAug<?=$years?>',this.value,'<?=$truckdatachk?>','Aug','<?=$years?>');}" class="form-control" id="txt_data8" name="txt_data8" value= "<?=$subext8?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Sep'<?=$yearsub?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input disabled size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('SubtotalExtSep<?=$years?>',this.value,'<?=$truckdatachk?>','Sep','<?=$years?>');}" class="form-control" id="txt_data9" name="txt_data9" value= "<?=$subext9?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Oct'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input disabled size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('SubtotalExtOct<?=$years?>',this.value,'<?=$truckdatachk?>','Oct','<?=$years?>');}" class="form-control" id="txt_data10" name="txt_data10" value= "<?=$subext10?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Nov'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input disabled size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('SubtotalExtNov<?=$years?>',this.value,'<?=$truckdatachk?>','Nov','<?=$years?>');}" class="form-control" id="txt_data11" name="txt_data11" value= "<?=$subext11?>" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label >Dec'<?=$yearsub?></label>&nbsp;&nbsp;
                                            <input disabled size="2" type="text" onchange="if(this.value*1!=this.value){this.value=''; alert('กรุณากรอกตัวเลข');}else{save_data('SubtotalExtDec<?=$years?>',this.value,'<?=$truckdatachk?>','Dec','<?=$years?>');}" class="form-control" id="txt_data12" name="txt_data12" value= "<?=$subext12?>" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                                <br>
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
