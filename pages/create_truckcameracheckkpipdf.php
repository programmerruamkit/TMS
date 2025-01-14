<?php

//create_pdf.php

date_default_timezone_set("Asia/Bangkok");


include('pdf.php');

// echo $_POST["hidden_html"];

if(isset($_POST["hidden_html"]) && $_POST["hidden_html"] != '')
{
 
// $name = $_GET['empname'];
//  $dateyear = $_GET['dateyear'];
// $file_name = 'HealthDataGraph_'.$name.'.pdf';
$file_name = 'TruckRedinessKPI.pdf';
// $html = '
//             <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
//           ';


$html .= $_POST["hidden_html"];
$pdf = new Pdf();
$pdf->load_html($html);
$pdf->setPaper('A3', 'Landscape');
// $pdf->setPaper(array(0,0,612,500));
$pdf->render();
$pdf->stream($file_name, array("Attachment" => false));
 
}


//create_pdf.php

// date_default_timezone_set("Asia/Bangkok");
// header('Content-Type: text/html; charset=UTF-8');
// include('pdf.php');

// if(isset($_POST["hidden_html"]) && $_POST["hidden_html"] != '')
// {
    
//  $file_name = 'google_chart.pdf';
//  $html = '
//  <head>
//  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
//  <link rel="stylesheet" href="bootstrap.min.css">
//  <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
//  <style>
//      @font-face {
//          font-family: THSarabunNew;
//          font-size: 12pt;
//          font-style: normal;
//          font-weight: normal;
//          src: url("{{ asset(../dompdf/lib/fonts/THSarabunNew.ttf) }}") format(truetype);
//      }

    

//  </style>
//  <body>
//      <h1>ทดสอบ</h1>
//  </body>
// </head>
          
//           ';


// // $html .= $_POST["hidden_html"];
// $pdf = new Pdf();
// $pdf->load_html($html);
// $pdf->setPaper('A3', 'Landscape');
// // $pdf->setPaper(array(0,0,612,500));
// $pdf->render();
// $pdf->stream($file_name, array("Attachment" => false));
 
// }
?>



