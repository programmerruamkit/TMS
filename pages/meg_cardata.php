<div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        <a href="meg_car.php?type=car">จัดการรถ</a> / <a href="meg_car.php?type=car&vehicleinfoid=<?= $result_info['VEHICLEINFOID'] ?>">เลขทะเบียน : <?= $result_info['VEHICLEREGISNUMBER'] ?></a>
                                    </div>
                                    <div class="panel-body" style="background-color: #f8f8f8;">
                                        <div class="row" >
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>เลขทะเบียนรถ : <font style="font-size: 16px"><?= $result_info['VEHICLEREGISNUMBER'] ?></font></label>

                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>กลุ่มรถ : <font style="font-size: 16px"><?= $result_info['VEHICLEGROUPDESC'] ?></font></label>

                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>ประเภทรถ : <font style="font-size: 16px"><?= $result_info['VEHICLETYPEDESC'] ?></font></label>

                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>ยี่ห้อรถ : <font style="font-size: 16px"><?= $result_info['BRANDDESC'] ?></font></label>

                                                </div>

                                            </div>

                                        </div>
                                        <div class="row" >




                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>ประเภทเกียร์รถ : <font style="font-size: 16px"><?= $result_info['GEARTYPEDESC'] ?></font></label>

                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>สีรถ : <font style="font-size: 16px"><?= $result_info['COLORDESC'] ?></font></label>

                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>ซีรีส์/รุ่น : <font style="font-size: 16px"><?= $result_info['SERIES'] ?></font></label>

                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>ชื่อรถ(ไทย) : <font style="font-size: 16px"><?= $result_info['THAINAME'] ?></font></label>

                                                </div>

                                            </div>

                                        </div>


                                        <div class="row" >



                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>ชื่อรถ(อังกฤษ) : <font style="font-size: 16px"><?= $result_info['ENGNAME'] ?></font></label>

                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>แรงม้า : <font style="font-size: 16px"><?= $result_info['HORSEPOWER'] ?></font></label>

                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>CC : <font style="font-size: 16px"><?= $result_info['CC'] ?></font></label>

                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>เลขเครื่องยนต์ : <font style="font-size: 16px"><?= $result_info['MACHINENUMBER'] ?></font></label>

                                                </div>

                                            </div>


                                        </div>
                                        <div class="row" >



                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>เลขตัวถัง : <font style="font-size: 16px"><?= $result_info['CHASSISNUMBER'] ?></font></label>

                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>ประเภทพลังงาน : <font style="font-size: 16px"><?= $result_info['ENERGY'] ?></font></label>


                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>น้ำหนักรถ(กิโลกรัม) : <font style="font-size: 16px"><?= $result_info['WEIGHT'] ?></font></label>

                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>ประเภทเพลา : <font style="font-size: 16px"><?= $result_info['AXLETYPE'] ?></font></label>

                                                </div>

                                            </div>

                                        </div>
                                        <div class="row" >


                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>ลูกสูบ : <font style="font-size: 16px"><?= $result_info['PISTON'] ?></font></label>

                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>น้ำหนักบรรทุกสูงสุด : <font style="font-size: 16px"><?= $result_info['MAXIMUMLOAD'] ?></font></label>

                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>วันที่เพิ่มข้อมูล : <font style="font-size: 16px"><?= $result_info['DATEOFREGISTRATION'] ?></font></label>

                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>การใช้งาน (ปี) : <font style="font-size: 16px"><?= $result_info['USED'] ?></font></label>

                                                </div>

                                            </div>


                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>สถานะ : <font style="font-size: 16px"><?php echo ($result_info['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></font></label>

                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>หมายเหตุ : <font style="font-size: 16px"><?= $result_info['REMARK'] ?></font></label>

                                                </div>

                                            </div>

                                        </div>



                                        <!-- /.row (nested) -->
                                    </div>
                                    <!-- /.panel-body -->
                                </div>
                                <!-- /.panel -->
                            </div>
                            <!-- /.col-lg-12 -->
                        </div>