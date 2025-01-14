<?php $title_page = "Management"; ?>

<?php if (require_once '../master.php') { ?>

    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">

            <?php require_once '../menu_bar.php'; ?>

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <?php require_once '../top_bar.php'; ?>

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Management</h1>
                        </div>

                        <!-- Content Row -->
                        <div class="row">

                            <div class="col-xl-12 col-lg-12">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                                        <h6 class="m-0 font-weight-bold text-light">Search Data</h6>
                                    </div>

                                    <!-- Card Body -->
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <form name="day" method="POST" action="<?= $oop->appmanagement . "/frm_report_manage.php" ?>">
                                                    <input type="hidden" name="search_data_by" value="dayly">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">วันที่</span>
                                                        </div>
                                                        <input type="date" name="date_value" class="form-control" value="<?= date("Y-m-d") ?>" aria-label="Search" aria-describedby="basic-addon2" required>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-success" type="submit">
                                                                <i class="fas fa-search fa-sm"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>

                                            <div class="col-lg-6">
                                                <form name="week" method="POST" action="<?= $oop->appmanagement . "/frm_report_manage.php" ?>">
                                                    <input type="hidden" name="search_data_by" value="weekly">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">สัปดาห์</span>
                                                        </div>
                                                        <select name="date_value" class="form-control" required>
                                                            <option value="">เลือกสัปดาห์</option>
                                                            <?php
                                                            for ($w = 1; $w < (int) date("W"); $w++) {
                                                                $year = date("Y");
                                                                if ($w < 10) {
                                                                    $week = "0" . $w;
                                                                } else {
                                                                    $week = $w;
                                                                }

                                                                $date1 = date("d-m-Y", strtotime($year . "W" . $week . "1")); // First day of week
                                                                $date2 = date("d-m-Y", strtotime($year . "W" . $week . "7")); // Last day of week
                                                                ?> 
                                                                <option value="<?= $week ?>" <?php
                                                                if ($_POST['date_value'] == $week) {
                                                                    echo 'selected';
                                                                }
                                                                ?>><?= "สัปดาห์ที่" . $w . " >> " . $date1 . " -- " . $date2 ?></option>
                                                                    <?php } ?>
                                                        </select>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-success" type="submit">
                                                                <i class="fas fa-search fa-sm"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <?php if ($_POST['search_data_by'] != '') { ?>
                                <div class="col-xl-12 col-lg-12">
                                    <div class="card shadow mb-4">
                                        <!-- Card Header - Dropdown -->
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                                            <h6 class="m-0 font-weight-bold text-light">Report</h6>
                                        </div>

                                        <?php
                                        if ($_POST['search_data_by'] == 'dayly') {
                                            $date_search = $_POST['date_value'];
                                            $condition = "WHERE [ITEM_STATUS] = 0 AND CONVERT(DATE,[WORK_END]) = '$date_search'";
                                        } else if ($_POST['search_data_by'] == 'weekly') {
                                            $week = $_POST['date_value'];
                                            $date1 = date("Y-m-d", strtotime($year . "W" . $week . "1")); // First day of week
                                            $date2 = date("Y-m-d", strtotime($year . "W" . $week . "7")); // Last day of week
                                            $condition = "WHERE [ITEM_STATUS] = 0 AND (CONVERT(DATE,[WORK_END]) BETWEEN '$date1' AND '$date2')";
                                        }

                                        $chart_type = "stackedColumn";
                                        $i = 0;
                                        $para = set_stored_para("SELECT", $oop->tbtype, "[TYPE_CODE], [TYPE_NAME]", "WHERE [TYPE_CODE] LIKE 'IT%'");
                                        $qry = db_query_stored($oop->rkadb, $oop->sp1, $para);
                                        while ($item = sqlsrv_fetch_object($qry)) {
                                            $type = " AND [WORK_TYPE] = '$item->TYPE_CODE'";
                                            $para_o = set_stored_para("COUNT", $oop->tbwork, "[WORK_ID]", $condition . $type);
                                            $qry_o = db_query_stored($oop->rkadb, $oop->sp1, $para_o);
                                            while ($item_o = sqlsrv_fetch_object($qry_o)) {
                                                $WORK[$i++] = array("label" => $item->TYPE_NAME, "y" => $item_o->COUNT_NUMBER);
                                            }
                                        }
                                        ?>

                                        <!-- Card Body -->
                                        <div class="card-body">
                                            <div class="container" id="chartContainer" style="height: 370px; width: 100%;"></div>
                                            <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- Content Row -->
                        </div>
                        <!-- Content Row -->
                    </div>

                    <!-- /.container-fluid -->
                </div>
                <!-- End of Main Content -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <script>
            window.onload = function () {

                var chart = new CanvasJS.Chart("chartContainer", {
                    animationEnabled: false,
                    exportEnabled: true,
                    title: {
                        text: "JOB Requestment"
                    },
                    theme: "light1",
                    animationEnabled: true,
                    toolTip: {
                        shared: true,
                        reversed: true
                    },
                    axisY: {
                        title: "JOB",
                        suffix: "",
                        maximum: 10,
                        includeZero: false
                    },
                    legend: {
                        cursor: "pointer",
                        itemclick: toggleDataSeries
                    },
                    data: [
                        {
                            type: <?php echo json_encode($chart_type); ?>,
                            name: "ITMHW",
                            color: "#000000",
                            showInLegend: true,
                            yValueFormatString: "#,##0 Job",
                            dataPoints: <?php echo json_encode($ITMHW, JSON_NUMERIC_CHECK); ?>
                        }, {
                            type: <?php echo json_encode($chart_type); ?>,
                            name: "ITMSW",
                            color: "#3c3c3c",
                            showInLegend: true,
                            yValueFormatString: "#,##0 Job",
                            dataPoints: <?php echo json_encode($ITMSW, JSON_NUMERIC_CHECK); ?>
                        }, {
                            type: <?php echo json_encode($chart_type); ?>,
                            name: "ITRHW",
                            color: "#787878",
                            showInLegend: true,
                            yValueFormatString: "#,##0 Job",
                            dataPoints: <?php echo json_encode($ITRHW, JSON_NUMERIC_CHECK); ?>
                        }, {
                            type: <?php echo json_encode($chart_type); ?>,
                            name: "ITRSW",
                            color: "#b4b4b4",
                            showInLegend: true,
                            yValueFormatString: "#,##0 Job",
                            dataPoints: <?php echo json_encode($ITRSW, JSON_NUMERIC_CHECK); ?>
                        }, {
                            type: <?php echo json_encode($chart_type); ?>,
                            name: "ITO",
                            color: "#f0f0f0",
                            showInLegend: true,
                            yValueFormatString: "#,##0 Job",
                            dataPoints: <?php echo json_encode($ITO, JSON_NUMERIC_CHECK); ?>
                        }, {
                            type: <?php echo json_encode($chart_type); ?>,
                            name: "WORK",
                            color: "#ff0f0f",
                            showInLegend: true,
                            yValueFormatString: "#,##0 Job",
                            dataPoints: <?php echo json_encode($WORK, JSON_NUMERIC_CHECK); ?>
                        }
                    ]
                });

                chart.render();

                function toggleDataSeries(e) {
                    if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                        e.dataSeries.visible = false;
                    } else {
                        e.dataSeries.visible = true;
                    }
                    e.chart.render();
                }

            }
        </script>
    </body>
    </html>
    <?php
} else {
    header("refresh: 0; url=$oop->apphome/page_error.php");
    exit(0);
}
?>