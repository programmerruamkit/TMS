<?php
require_once("../class/meg_function.php");
?>
<html lang="en">

    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>

    </head>

    <body>
        <div id="wrap">
            <div class="container">
                <div class="row">

                    <form class="form-horizontal" action="" method="post" name="upload_excel" enctype="multipart/form-data">
                        <fieldset>

                            <!-- Form Name -->
                            <legend>Form Name</legend>

                            <!-- File Button -->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="filebutton">Select File</label>
                                <div class="col-md-4">
                                    <input type="file" name="file" id="file" class="input-large">
                                </div>
                            </div>

                            <!-- Button -->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="singlebutton">Import data</label>
                                <div class="col-md-4">
                                    <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
                                </div>
                            </div>

                        </fieldset>
                    </form>

                </div>
                <?php
                get_all_records();
                ?>
            </div>
        </div>

    </body>

</html>
<?php
/*
  function getdb() {
  $servername = "localhost";
  $username = "root";
  $password = "123456789";
  $db = "employee";

  try {

  $conn = mysqli_connect($servername, $username, $password, $db);
  //echo "Connected successfully";
  } catch (exception $e) {
  echo "Connection failed: " . $e->getMessage();
  }
  return $conn;
  }
 */
if (isset($_POST["Import"])) {
//$con = getdb();
    $filename = $_FILES["file"]["tmp_name"];
    if ($_FILES["file"]["size"] > 0) {
        $file = fopen($filename, "r");
        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {

            $conn = connect("RTMS");
            $sql_seEmployee = "INSERT into employeeinfo (emp_id,firstname,lastname,email,reg_date) 
                   values ('" . $getData[0] . "','" . $getData[1] . "','" . $getData[2] . "','" . $getData[3] . "','" . $getData[4] . "')";
            $params_seEmployee = array('');
            $query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
        }
        fclose($file);
    }
}

function get_all_records() {
    $conn = connect("RTMS");
    $sql_seEmployee = "select * from dbo.employeeinfo ";
    $params_seEmployee = array('');
    $query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
    
    echo "<div class='table-responsive'><table id='myTable' class='table table-striped table-bordered'>
             <thead><tr><th>EMP ID</th>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>Email</th>
                          <th>Registration Date</th>
                        </tr></thead><tbody>";

    while ($row = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC)) {


        echo "<tr><td>" . $row['emp_id'] . "</td>
                   <td>" . $row['firstname'] . "</td>
                   <td>" . $row['lastname'] . "</td>
                   <td>" . $row['email'] . "</td>
                   <td>" . $row['reg_date'] . "</td></tr>";
    }

    echo "</tbody></table></div>";
}
?>