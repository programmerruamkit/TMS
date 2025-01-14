<?php
require_once("./meg_function.php");
$conn = connect("RTMS");
try {
        $rs = insAdjust(
                'save_adjust', $_POST['ID'],$_POST['fieldname'], $_POST['editableObj']);
        switch ($rs) {
            case 'complete': {
                    echo "บันทึกข้อมูลเรียบร้อย...";
                }
                break;
            case 'error': {
                    echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล !!!";
                }
                break;
            default : {
                    echo $rs;
                }
                break;
        }  
} catch (Exception $ex) {
    echo $rs;
}
?>
<?php
sqlsrv_close($conn);
?>