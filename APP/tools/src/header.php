<!DOCTYPE html>
<html lang="en">

    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?= $title_page ?></title>

        <!-- Custom fonts for this template -->
        <link href="/app/tools/template/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="/app/tools/template/css/sb-admin-2.min.css" rel="stylesheet">

        <!-- Custom styles for this page -->
        <link href="/app/tools/template/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

        <link rel="shortcut icon" href="/app/picture/logo/title-icon.ico" />

        <?php require_once 'footer.php'; ?>
    </head>

    <style type="text/css" media="print">
        @media print {
            html,body{height:100%;width:100%;margin:0;padding:0;}
            @page {
                size: A4 landscape;
                max-height:100%;
                max-width:100%;
            }
        };
        @font-face {
            font-family: myFont;
            src: url(<?= $oop->temp . "vendor/font/SukhumvitSet/SukhumvitSet.ttf" ?>);
        }

        body{
            font-family: myFont;
        };
    </style>
