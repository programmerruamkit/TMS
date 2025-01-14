<html>
    <head>
        <title>Test</title>
    </head>
    <body>
        <?php
       
        require_once("lib/nusoap.php");
        $client = new nusoap_client("http://203.150.225.30:8080/pages/meg_inputttastrrrservice.php?wsdl", true);
        $params = array(
            'dateinput' => "xx/xx/xxxx",
            'employeecode' => "xxxxxx",
            'vehiclenumber' => "xx-xxxx",
            'vehicletype' => "xx",
            'jobstart' => "xx",
            'jobend' => "xx",
            'zone' => "xx",
            'documentnumber' => "xx",
            'weightin' => "xx",
            'remark' => "xx"
        );
        $data = $client->call("insPlanttastrrr", $params);
        echo $data;
        ?>
    </body>
</html>