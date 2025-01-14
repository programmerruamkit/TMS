<?php
    //create_pdf.php
    date_default_timezone_set("Asia/Bangkok");
    include('pdf.php');
    $adddate = date('YmdHis');
    if(isset($_POST["hidden_html"]) && $_POST["hidden_html"] != '')    {
    $file_name = 'PUNCTUALITY_MONTH_'.$adddate.'.pdf';
    $html .= $_POST["hidden_html"];
    $pdf = new Pdf();
    $pdf->load_html($html);
    $pdf->setPaper('A2', 'PORTRAIT');
    // $pdf->setPaper(array(0,0,612,500));
    $pdf->render();
    $pdf->stream($file_name, array("Attachment" => false));
    }
?>