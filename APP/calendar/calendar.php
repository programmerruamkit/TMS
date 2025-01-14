<?php
$month_set = date("m");
$day_set = 1;
$year_set = date("Y");
$now = date("d");

if (isset($_POST['console'])) {
    if ($_POST['console'] == "<<" && $_POST['month'] == "1") {
        $month_set = 12;
        $year_set = --$_POST['year'];
    } else if ($_POST['console'] == "<<") {
        $month_set = --$_POST['month'];
        $year_set = $_POST['year'];
    } else if ($_POST['console'] == ">>" && $_POST['month'] == "12") {
        $month_set = 1;
        $year_set = ++$_POST['year'];
    } else if ($_POST['console'] == ">>") {
        $month_set = ++$_POST['month'];
        $year_set = $_POST['year'];
    }
} else if (isset($_POST['today'])) {
    $month_set = date("m");
    $day_set = 1;
    $year_set = date("Y");
}
$day_count = cal_days_in_month(CAL_GREGORIAN, $month_set, $year_set);
$format = date("l", mktime(0, 0, 0, $month_set, $day_set, $year_set));
if ($format == 'Saturday') {
    $day_start = 7;
} else if ($format == 'Sunday') {
    $day_start = 1;
} else if ($format == 'Monday') {
    $day_start = 2;
} else if ($format == 'Tuesday') {
    $day_start = 3;
} else if ($format == 'Wednesday') {
    $day_start = 4;
} else if ($format == 'Thursday') {
    $day_start = 5;
} else {
    $day_start = 6;
}
?>

<!-- Content Row -->
<div class="row">

    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                <h6 class="m-0 font-weight-bold text-light">Calendar</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Head Menu:</div>
                        <a class="dropdown-item" href="#">Menu 1</a>
                        <a class="dropdown-item" href="#">Menu 2</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Menu 3</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">

                <div class="container-fluid">

                    <div class="row justify-content-center">
                        <form method="POST" action="/app/index.php">
                            <center><?php echo date("F-Y", mktime(0, 0, 0, $month_set, $day_set, $year_set)); ?></center>
                            <hr>
                            <input type="hidden" name="month" value="<?php echo $month_set; ?>">
                            <input type="hidden" name="year" value="<?php echo $year_set; ?>">
                            <input class="btn" type="submit" name="console" value="<<">
                            <input class="btn btn-light" type="submit" name="today" value="TODAY">
                            <input class="btn" type="submit" name="console" value=">>">
                        </form>
                    </div>

                    <hr>

                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <table class="table">
                                <thead class="bg-dark text-light text-center">
                                    <tr>
                                        <th> Sunday </th>
                                        <th> Monday </th>
                                        <th> Tuesday </th>
                                        <th> Wednesday </th>
                                        <th> Thursday </th>
                                        <th> Friday </th>
                                        <th> Saturday </th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php
                                    $count = 1;
                                    $day = 1;
                                    if ($day_start >= 6 && $day_count >= 31) {
                                        $row = 0;
                                    } else if ($day_start == 1 && $day_count <= 28) {
                                        $row = 2;
                                    } else {
                                        $row = 1;
                                    }

                                    for ($row; $row <= 5; $row++) {
                                        echo "<tr>";
                                        for ($col = 0; $col <= 6; $col++) {
                                            echo '<td>';
                                            if ($day_start <= $count && $day <= $day_count) {
                                                if ($month_set == date("m") && $year_set == date("Y") && $day == $now) {
                                                    echo "<span class='text-danger'><b>[" . $day++ . "]</b></span> ";
                                                } else {
                                                    echo $day++;
                                                }
                                            }
                                            $count++;
                                            echo "</td>";
                                        }

                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>