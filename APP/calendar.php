<?php
//var_dump($_POST);

date_default_timezone_set("Asia/Bangkok");

//echo "There was $num days in DEC 2012";
echo "<br>";
//echo " " . date("l", mktime(0, 0, 0, 12, 1, 2012));
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

<form method="POST" action="calendar.php">
    <div style="margin-left: 350px;"><?php echo date("F-Y", mktime(0, 0, 0, $month_set, $day_set, $year_set)); ?></div>
    -----------------------------------------------------------
    <input type="hidden" name="month" value="<?php echo $month_set; ?>" />
    <input type="hidden" name="year" value="<?php echo $year_set; ?>" />
    <input type="submit" name="today" value="TODAY" class="btn text-dark"> 
    <input type="submit" name="console" value="<<" class="btn btn-circle text-dark">
    <input type="submit" name="console" value=">>" class="btn btn-circle text-dark">
    ------------------------------------------------------------ 
</form>


<table class="table_theme" border="2px"  >
    <?php
    echo "<th> Sunday </th>";
    echo "<th> Monday </th>";
    echo "<th> Tuesday </th>";
    echo "<th> Wednesday </th>";
    echo "<th> Thursday </th>";
    echo "<th> Friday </th>";
    echo "<th> Saturday </th>";
    $count = 1;
    $day = 1;
//$day_count=31;
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
            echo '<td class="Td_theme" >';
            if ($day_start <= $count && $day <= $day_count) {
                if ($month_set == date("m") && $year_set == date("Y") && $day == $now) {
                    echo "<div class='now'><h4>*NOW</h4></div>";
                }
                echo $day++;
            }
            $count++;
            echo "</td>";
        }
        /* if()
          {
          echo "<td></td>";
          }else if()
          {
          echo "<td></td>";
          }else if()
          {
          echo "<td></td>";
          }else if()
          {
          echo "<td></td>";
          }else if()
          {
          echo "<td></td>";
          }else if()
          {
          echo "<td></td>";
          }else if()
          {
          echo "<td></td>";
          }
         */

        echo "</tr>";
    }
    ?>
</table>