  <?php
  session_start();
  date_default_timezone_set("Asia/Bangkok");
  require_once("../class/meg_function.php");
  ini_set('max_execution_time', 300); //300 seconds = 5 minutes
  $conn = connect("RTMS");


  if ($_POST['txt_flg'] == "select_reportdailybudgetsummary") {
    ?>
    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-examplesummary2" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
      <thead>
        <tr>
          <th >COMPANY</th>
          <th >CUSTOMER</th>
          <th >TRIP</th>
          <th >TON</th>
          <th >SALE PRICE</th>
          <th >DROP</th>
          <th >FUEL(L)</th>
          <th >FUEL(Bth)</th>
          <th >TOLLFEE</th>
          <th >WORKING INCENTIVE</th>
          <th >FULE INCENTIVE</th>
          <th >REPAIR</th>
          <th >TOTAL</th>
          <th >DEP</th>
          <th >EVA</th>
          <th >PROFIT%</th>
        </tr>
      </thead>
      <tbody>

        <?php
        $company = ($_POST['companycode'] != "") ? " AND a.COMPANYCODE = '" . $_POST['companycode'] . "'" : "";
        $condiReporttransport1 = $sql_seCus = "SELECT DISTINCT CUSTOMERCODE FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE COMPANYCODE = '" . $_POST['companycode'] . "'";

        $query_seCus = sqlsrv_query($conn, $sql_seCus, $params_seCus);
        while ($result_seCus = sqlsrv_fetch_array($query_seCus, SQLSRV_FETCH_ASSOC)) {


          $condiReporttransport1sum = " AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)";
          $condiReporttransport2sum = " AND a.COMPANYCODE = '" . $_POST['companycode'] . "' AND a.CUSTOMERCODE = '" . $result_seCus['CUSTOMERCODE'] . "'";
          $condiReporttransport3sum = " AND a.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''";
          $sql_seReporttransportsum = "{call megVehicletransportplan_v2(?,?,?,?)}";
          $params_seReporttransportsum = array(
            array('select_reportdailybudget', SQLSRV_PARAM_IN),
            array($condiReporttransport1sum, SQLSRV_PARAM_IN),
            array($condiReporttransport2sum, SQLSRV_PARAM_IN),
            array($condiReporttransport3sum, SQLSRV_PARAM_IN)
          );
          $query_seReporttransportsum = sqlsrv_query($conn, $sql_seReporttransportsum, $params_seReporttransportsum);
          $result_seReporttransportsum = sqlsrv_fetch_array($query_seReporttransportsum, SQLSRV_FETCH_ASSOC);

         // ค่าเที่ยวของสายงาน SKB นับคนที่ 1 + คนที่ 2
          if ($result_seReporttransportsum['COMPANYCODE'] == 'RKL' && $result_seCus['CUSTOMERCODE'] == 'SKB') {
              $sql_sumE1 = "SELECT SUM(CONVERT(INT,E1)+CONVERT(INT,E2))  AS 'SUME1'
                FROM [dbo].[VEHICLETRANSPORTPLAN] a WHERE 1 = 1
                AND STATUSNUMBER != '0'
                AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                AND a.COMPANYCODE = '" . $_POST['companycode'] . "' AND a.CUSTOMERCODE = '" . $result_seCus['CUSTOMERCODE'] . "' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != '' ";
              $query_sumE1 = sqlsrv_query($conn, $sql_sumE1, $params_sumE1);
              $result_sumE1 = sqlsrv_fetch_array($query_sumE1, SQLSRV_FETCH_ASSOC);
          }else{
              $sql_sumE1 = "SELECT SUM(CONVERT(INT,E1))  AS 'SUME1'
                FROM [dbo].[VEHICLETRANSPORTPLAN] a WHERE 1 = 1
                AND STATUSNUMBER != '0'
                AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                AND a.COMPANYCODE = '" . $_POST['companycode'] . "' AND a.CUSTOMERCODE = '" . $result_seCus['CUSTOMERCODE'] . "' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != '' ";
              $query_sumE1 = sqlsrv_query($conn, $sql_sumE1, $params_sumE1);
              $result_sumE1 = sqlsrv_fetch_array($query_sumE1, SQLSRV_FETCH_ASSOC);
          }
            


          if ($result_seReporttransportsum['COMPANYCODE'] == 'RKS' && $result_seCus['CUSTOMERCODE'] == 'STM') {
            $sql_sumActualpricestm = "SELECT SUM(ACTUALPRICE * CAST(LEFT(a.ROUNDAMOUNT,PATINDEX('%[^0-9]%',a.ROUNDAMOUNT)-1) AS int)) AS 'SUMPRICESTM'
            FROM [dbo].[VEHICLETRANSPORTPLAN] a WHERE 1 = 1
            AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
            AND a.COMPANYCODE = 'RKS' AND a.CUSTOMERCODE = 'STM' ";
            $query_sumActualpricestm = sqlsrv_query($conn, $sql_sumActualpricestm, $params_sumActualpricestm);
            $result_sumActualpricestm = sqlsrv_fetch_array($query_sumActualpricestm, SQLSRV_FETCH_ASSOC);

            $sql_seTripamountstm = "SELECT  SUM(CAST(LEFT(a.ROUNDAMOUNT,PATINDEX('%[^0-9]%',a.ROUNDAMOUNT)-1) AS int)) AS 'SUMTRIPAMOUNTSTM' FROM [dbo].[VEHICLETRANSPORTPLAN] a
            WHERE a.ROUNDAMOUNT IS NOT NULL
            AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
            AND a.COMPANYCODE = 'RKS' AND a.CUSTOMERCODE = 'STM'
            AND a.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ'";
            $query_seTripamountstm = sqlsrv_query($conn, $sql_seTripamountstm, $params_seTripamountstm);
            $result_seTripamountstm = sqlsrv_fetch_array($query_seTripamountstm, SQLSRV_FETCH_ASSOC);


            // $sql_seWorkincenstm = "SELECT  SUM(CONVERT(INT,E1) * CAST(LEFT(a.ROUNDAMOUNT,PATINDEX('%[^0-9]%',a.ROUNDAMOUNT)-1) AS int))   AS 'SUMWORKINCENSTM'
            // FROM [dbo].[VEHICLETRANSPORTPLAN] a WHERE 1 = 1
            // AND STATUSNUMBER != '0'
            // AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'04/03/2020',103) AND CONVERT(DATE,'04/03/2020',103)
            // AND a.COMPANYCODE = 'RKS' AND a.CUSTOMERCODE = 'STM'";
            // $query_seWorkincenstm = sqlsrv_query($conn, $sql_seWorkincenstm, $params_seWorkincenstm);
            // $result_seWorkincenstm = sqlsrv_fetch_array($query_seWorkincenstm, SQLSRV_FETCH_ASSOC);

            $sql_seWorkincenstm = "SELECT  SUM(CONVERT(INT,E1))   AS 'SUMWORKINCENSTM'
            FROM [dbo].[VEHICLETRANSPORTPLAN] a WHERE 1 = 1
            AND STATUSNUMBER != '0'
            AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
            AND a.COMPANYCODE = 'RKS' AND a.CUSTOMERCODE = 'STM'";
            $query_seWorkincenstm = sqlsrv_query($conn, $sql_seWorkincenstm, $params_seWorkincenstm);
            $result_seWorkincenstm = sqlsrv_fetch_array($query_seWorkincenstm, SQLSRV_FETCH_ASSOC);


          } else {
            // code...
          }


          $sql_seTripamountsum = "SELECT COUNT(*) AS 'SUMTRIPAMOUNT' FROM [dbo].[VEHICLETRANSPORTPLAN] a
          WHERE CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
          AND a.STATUSNUMBER != '0'
          AND a.COMPANYCODE = '" . $_POST['companycode'] . "' AND a.CUSTOMERCODE = '" . $result_seCus['CUSTOMERCODE'] . "'
          AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ'
          AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''";
          $query_seTripamountsum = sqlsrv_query($conn, $sql_seTripamountsum, $params_seTripamountsum);
          $result_seTripamountsum = sqlsrv_fetch_array($query_seTripamountsum, SQLSRV_FETCH_ASSOC);


          $sql_seTonsum = "SELECT SUM(CONVERT(DECIMAL,a.WEIGHTIN)) / 1000 AS 'SUMWEIGHTIN' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
          INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID WHERE a.WEIGHTIN IS NOT NULL AND a.WEIGHTIN !=''
          AND b.STATUSNUMBER != '0'
          AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
          AND a.COMPANYCODE = '" . $_POST['companycode'] . "' AND a.CUSTOMERCODE = '" . $result_seCus['CUSTOMERCODE'] . "'";
          $query_seTonsum = sqlsrv_query($conn, $sql_seTonsum, $params_seTonsum);
          $result_seTonsum = sqlsrv_fetch_array($query_seTonsum, SQLSRV_FETCH_ASSOC);



          $sql_seActualpricesum = "SELECT SUM(CONVERT(INT,CONVERT(DECIMAL(10,3),CASE WHEN a.ACTUALPRICE = '999999' THEN '0.00' ELSE a.ACTUALPRICE END))) AS 'SUMACTUALPRICE'
          FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
          INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
          WHERE CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
          AND a.COMPANYCODE = '" . $_POST['companycode'] . "' AND a.CUSTOMERCODE = '" . $result_seCus['CUSTOMERCODE'] . "' ";
          $query_seActualpricesum = sqlsrv_query($conn, $sql_seActualpricesum, $params_seActualpricesum);
          $result_seActualpricesum = sqlsrv_fetch_array($query_seActualpricesum, SQLSRV_FETCH_ASSOC);

          ////////////////SALEPRICE FOR RKRRKL////////////////////////////////////////

          if ($result_seReporttransportsum['COMPANYCODE'] == 'RKR' || $result_seReporttransportsum['COMPANYCODE'] == 'RKL') {
            if ($result_seCus['CUSTOMERCODE'] == 'TTASTSTC') {
              $sql_sumActualpricerkr = "SELECT SUM(CONVERT(DECIMAL(10,3),a.ACTUALPRICEHEAD)) AS 'SUMACTUALPRICE'
              FROM (SELECT  a.ACTUALPRICEHEAD,a.VEHICLETRANSPORTPLANID
                FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b. VEHICLETRANSPORTPLANID
                WHERE 1 = 1
                AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                AND a.COMPANYCODE = '".$_POST['companycode']."' AND a.CUSTOMERCODE = 'TTASTSTC'
                AND b.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''
                AND a.CUSTOMERCODE !='TTASTCS'
                GROUP BY a.VEHICLETRANSPORTPLANID,a.ACTUALPRICEHEAD,a.JOBEND) a ";
                $query_sumActualpricerkr = sqlsrv_query($conn, $sql_sumActualpricerkr, $params_sumActualpricerkr);
                $result_sumActualpricerkr = sqlsrv_fetch_array($query_sumActualpricerkr, SQLSRV_FETCH_ASSOC);

                $sql_sumCrossprice = "SELECT (a.ROWNUM * 100) AS 'CROSSPRICE'
                  FROM (SELECT TOP 1 a.DESTINATION AS 'DESTINATION',a.VEHICLETRANSPORTPLANID,
                  ROW_NUMBER() OVER(PARTITION BY a.DESTINATION ORDER BY a.VEHICLETRANSPORTPLANID ASC) AS 'ROWNUM'
                  FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                  INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b. VEHICLETRANSPORTPLANID
                  WHERE 1 = 1
                  AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['datestart'] . "',103)
                  AND a.COMPANYCODE = '".$_POST['companycode']."' AND a.CUSTOMERCODE = 'TTASTSTC'
                  AND b.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''
                  AND a.CUSTOMERCODE !='TTASTCS'
                  AND a.DESTINATION ='C'
                  GROUP BY a.VEHICLETRANSPORTPLANID,a.DESTINATION
                  ORDER BY ROWNUM DESC) a ";
                $query_sumCrossprice = sqlsrv_query($conn, $sql_sumCrossprice, $params_sumCrossprice);
                $result_sumCrossprice = sqlsrv_fetch_array($query_sumCrossprice, SQLSRV_FETCH_ASSOC);


                }else if ($result_seCus['CUSTOMERCODE'] == 'TTASTCS') {
                  $sql_sumActualpricerkr = "SELECT SUM(CONVERT(DECIMAL(10,3),a.ACTUALPRICEHEAD)) AS 'SUMACTUALPRICE'
                  FROM (SELECT  a.ACTUALPRICEHEAD,a.VEHICLETRANSPORTPLANID
                    FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                    INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b. VEHICLETRANSPORTPLANID
                    WHERE 1 = 1
                    AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                    AND a.COMPANYCODE = '" . $_POST['companycode'] . "' AND a.CUSTOMERCODE = 'TTASTCS'
                    AND b.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''
                    AND a.CUSTOMERCODE !='TTASTSTC'
                    GROUP BY a.VEHICLETRANSPORTPLANID,a.ACTUALPRICEHEAD,a.JOBEND) a ";
                    $query_sumActualpricerkr = sqlsrv_query($conn, $sql_sumActualpricerkr, $params_sumActualpricerkr);
                    $result_sumActualpricerkr = sqlsrv_fetch_array($query_sumActualpricerkr, SQLSRV_FETCH_ASSOC);
                  }else if ($result_seCus['CUSTOMERCODE'] == 'TSAT') {
                    // งาน RKR,RKL แบ trup จะใช้ ACTUALPRICE ใน ตาราง PLAN 
                    $sql_sumActualpricerkr = "SELECT SUM(CONVERT(DECIMAL(10,3),a.ACTUALPRICE)) AS 'SUMACTUALPRICE'
                        FROM (SELECT  b.ACTUALPRICE,a.VEHICLETRANSPORTPLANID
                        FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b. VEHICLETRANSPORTPLANID
                        WHERE 1 = 1
                        AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                        AND a.COMPANYCODE = '" . $_POST['companycode'] . "' AND a.CUSTOMERCODE = 'TSAT'
                        AND b.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''
                        AND a.CUSTOMERCODE !='TTASTSTC'
                        AND a.CUSTOMERCODE !='TTASTCS'
                        GROUP BY a.VEHICLETRANSPORTPLANID,b.ACTUALPRICE) a ";
                      $query_sumActualpricerkr = sqlsrv_query($conn, $sql_sumActualpricerkr, $params_sumActualpricerkr);
                      $result_sumActualpricerkr = sqlsrv_fetch_array($query_sumActualpricerkr, SQLSRV_FETCH_ASSOC);
                      // echo 'RR';
                  }else {
                    $sql_sumActualpricerkr = "SELECT SUM(CONVERT(DECIMAL(10,3),a.ACTUALPRICEHEAD)) AS 'SUMACTUALPRICE'
                    FROM (SELECT  a.ACTUALPRICEHEAD,a.VEHICLETRANSPORTPLANID
                      FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                      INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b. VEHICLETRANSPORTPLANID
                      WHERE 1 = 1
                      AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                      AND a.COMPANYCODE = '" . $_POST['companycode'] . "' AND a.CUSTOMERCODE = '" . $result_seCus['CUSTOMERCODE'] . "'
                      AND b.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''
                      AND a.CUSTOMERCODE !='TTASTSTC'
                      AND a.CUSTOMERCODE !='TTASTCS'
                      GROUP BY a.VEHICLETRANSPORTPLANID,a.ACTUALPRICEHEAD) a ";
                      $query_sumActualpricerkr = sqlsrv_query($conn, $sql_sumActualpricerkr, $params_sumActualpricerkr);
                      $result_sumActualpricerkr = sqlsrv_fetch_array($query_sumActualpricerkr, SQLSRV_FETCH_ASSOC);
                    }


                  }else {
                    // code...
                  }
                  //////11111



                    $sql_sumActualpricerkrttast = "SELECT SUM(CONVERT(DECIMAL(10,3),a.ACTUALPRICE)) AS 'SUMACTUALPRICE'
                      FROM (SELECT  b.ACTUALPRICE,a.VEHICLETRANSPORTPLANID
                      FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                      INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b. VEHICLETRANSPORTPLANID
                      WHERE 1 = 1
                      AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                      AND a.COMPANYCODE = '" . $_POST['companycode'] . "' AND a.CUSTOMERCODE = 'TTAST'
                      AND b.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''
                      GROUP BY a.VEHICLETRANSPORTPLANID,b.ACTUALPRICE) a";
                    $query_sumActualpricerkrttast = sqlsrv_query($conn, $sql_sumActualpricerkrttast, $params_sumActualpricerkrttast);
                    $result_sumActualpricerkrttast = sqlsrv_fetch_array($query_sumActualpricerkrttast, SQLSRV_FETCH_ASSOC);


                    $sql_sumActualpricerkrtgt = "SELECT SUM(CONVERT(DECIMAL(10,3),a.ACTUALPRICE)) AS 'SUMACTUALPRICE'
                      FROM (SELECT  b.ACTUALPRICE,a.VEHICLETRANSPORTPLANID
                      FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                      INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b. VEHICLETRANSPORTPLANID
                      WHERE 1 = 1
                      AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                      AND a.COMPANYCODE = '" . $_POST['companycode'] . "' AND a.CUSTOMERCODE = 'TGT'
                      AND b.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''
                      GROUP BY a.VEHICLETRANSPORTPLANID,b.ACTUALPRICE) a ";
                    $query_sumActualpricerkrtgt = sqlsrv_query($conn, $sql_sumActualpricerkrtgt, $params_sumActualpricerkrtgt);
                    $result_sumActualpricerkrtgt = sqlsrv_fetch_array($query_sumActualpricerkrtgt, SQLSRV_FETCH_ASSOC);


                      $sql_sumActualpricerkrttat = "SELECT SUM(CONVERT(DECIMAL(10,3),a.ACTUALPRICE)) AS 'SUMACTUALPRICE'
                        FROM (SELECT  b.ACTUALPRICE,a.VEHICLETRANSPORTPLANID
                        FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b. VEHICLETRANSPORTPLANID
                        WHERE 1 = 1
                        AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                        AND a.COMPANYCODE = '" . $_POST['companycode'] . "' AND a.CUSTOMERCODE = 'TTAT'
                        AND b.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''
                        GROUP BY a.VEHICLETRANSPORTPLANID,b.ACTUALPRICE) a ";
                      $query_sumActualpricerkrttat = sqlsrv_query($conn, $sql_sumActualpricerkrttat, $params_sumActualpricerkrttat);
                      $result_sumActualpricerkrttat = sqlsrv_fetch_array($query_sumActualpricerkrttat, SQLSRV_FETCH_ASSOC);


                        $sql_sumActualpricerkrtkt = "SELECT SUM(CONVERT(DECIMAL(10,3),a.ACTUALPRICE)) AS 'SUMACTUALPRICE'
                          FROM (SELECT  b.ACTUALPRICE,a.VEHICLETRANSPORTPLANID
                          FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                          INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b. VEHICLETRANSPORTPLANID
                          WHERE 1 = 1
                          AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                          AND a.COMPANYCODE = '" . $_POST['companycode'] . "' AND a.CUSTOMERCODE = 'TKT'
                          AND b.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''
                          GROUP BY a.VEHICLETRANSPORTPLANID,b.ACTUALPRICE) a";
                        $query_sumActualpricerkrtkt = sqlsrv_query($conn, $sql_sumActualpricerkrtkt, $params_sumActualpricerkrtkt);
                        $result_sumActualpricerkrtkt = sqlsrv_fetch_array($query_sumActualpricerkrtkt, SQLSRV_FETCH_ASSOC);


                        $sql_sumActualpricerkrdaiki = "SELECT SUM(CONVERT(DECIMAL(10,3),a.ACTUALPRICE)) AS 'SUMACTUALPRICE'
                          FROM (SELECT  a.ACTUALPRICE,a.VEHICLETRANSPORTPLANID
                          FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                          INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b. VEHICLETRANSPORTPLANID
                          WHERE 1 = 1
                          AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                          AND a.COMPANYCODE = '" . $_POST['companycode'] . "' AND a.CUSTOMERCODE = 'DAIKI'
                          AND b.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''
                          GROUP BY a.VEHICLETRANSPORTPLANID,a.ACTUALPRICE) a";
                        $query_sumActualpricerkrdaiki = sqlsrv_query($conn, $sql_sumActualpricerkrdaiki, $params_sumActualpricerkrdaiki);
                        $result_sumActualpricerkrdaiki = sqlsrv_fetch_array($query_sumActualpricerkrdaiki, SQLSRV_FETCH_ASSOC);


                        $sql_sumActualpricerkrsutt = "SELECT SUM(CONVERT(DECIMAL(10,3),a.ACTUALPRICE)) AS 'SUMACTUALPRICE'
                          FROM (SELECT  b.ACTUALPRICE,a.VEHICLETRANSPORTPLANID
                          FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                          INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b. VEHICLETRANSPORTPLANID
                          WHERE 1 = 1
                          AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                          AND a.COMPANYCODE = 'RKL' AND a.CUSTOMERCODE = 'SUTT'
                          AND b.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''
                          GROUP BY a.VEHICLETRANSPORTPLANID,b.ACTUALPRICE) a";
                        $query_sumActualpricerkrsutt = sqlsrv_query($conn, $sql_sumActualpricerkrsutt, $params_sumActualpricerkrsutt);
                        $result_sumActualpricerkrsutt = sqlsrv_fetch_array($query_sumActualpricerkrsutt, SQLSRV_FETCH_ASSOC);


                        $sql_sumActualpricerkrnitsu = "SELECT SUM(CONVERT(DECIMAL(10,3),a.ACTUALPRICE)) AS 'SUMACTUALPRICE'
                          FROM (SELECT  b.ACTUALPRICE,a.VEHICLETRANSPORTPLANID
                          FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                          INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b. VEHICLETRANSPORTPLANID
                          WHERE 1 = 1
                          AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                          AND a.COMPANYCODE = '" . $_POST['companycode'] . "' AND a.CUSTOMERCODE = 'NITTSUSHOJI'
                          AND b.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''
                          GROUP BY a.VEHICLETRANSPORTPLANID,b.ACTUALPRICE) a";
                        $query_sumActualpricerkrnitsu = sqlsrv_query($conn, $sql_sumActualpricerkrnitsu, $params_sumActualpricerkrnitsu);
                        $result_sumActualpricerkrnitsu = sqlsrv_fetch_array($query_sumActualpricerkrnitsu, SQLSRV_FETCH_ASSOC);


                        $sql_sumActualpricerkrtdem = "SELECT SUM(CONVERT(DECIMAL(10,3),a.ACTUALPRICE)) AS 'SUMACTUALPRICE'
                          FROM (SELECT  b.ACTUALPRICE,a.VEHICLETRANSPORTPLANID
                          FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                          INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b. VEHICLETRANSPORTPLANID
                          WHERE 1 = 1
                          AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                          AND a.COMPANYCODE = '" . $_POST['companycode'] . "' AND a.CUSTOMERCODE = 'TDEM'
                          AND b.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''
                          GROUP BY a.VEHICLETRANSPORTPLANID,b.ACTUALPRICE) a";
                        $query_sumActualpricerkrtdem = sqlsrv_query($conn, $sql_sumActualpricerkrtdem, $params_sumActualpricerkrtdem);
                        $result_sumActualpricerkrtdem = sqlsrv_fetch_array($query_sumActualpricerkrtdem, SQLSRV_FETCH_ASSOC);


                        $sql_sumActualpricerkrgmt = "SELECT SUM(CONVERT(DECIMAL(10,3),a.ACTUALPRICE)) AS 'SUMACTUALPRICE'
                          FROM (SELECT  b.ACTUALPRICE,a.VEHICLETRANSPORTPLANID
                          FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                          INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b. VEHICLETRANSPORTPLANID
                          WHERE 1 = 1
                          AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                          AND a.COMPANYCODE = '" . $_POST['companycode'] . "' AND a.CUSTOMERCODE = 'GMT'
                          AND b.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''
                          GROUP BY a.VEHICLETRANSPORTPLANID,b.ACTUALPRICE) a";
                        $query_sumActualpricerkrgmt = sqlsrv_query($conn, $sql_sumActualpricerkrgmt, $params_sumActualpricerkrgmt);
                        $result_sumActualpricerkrgmt = sqlsrv_fetch_array($query_sumActualpricerkrgmt, SQLSRV_FETCH_ASSOC);


                        $sql_sumActualpricerkrhino = "SELECT SUM(CONVERT(DECIMAL(10,3),a.ACTUALPRICE)) AS 'SUMACTUALPRICE'
                          FROM (SELECT  b.ACTUALPRICE,a.VEHICLETRANSPORTPLANID
                          FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                          INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b. VEHICLETRANSPORTPLANID
                          WHERE 1 = 1
                          AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                          AND a.COMPANYCODE = '" . $_POST['companycode'] . "' AND a.CUSTOMERCODE = 'HINO'
                          AND b.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''
                          GROUP BY a.VEHICLETRANSPORTPLANID,b.ACTUALPRICE) a";
                        $query_sumActualpricerkrhino = sqlsrv_query($conn, $sql_sumActualpricerkrhino, $params_sumActualpricerkrhino);
                        $result_sumActualpricerkrhino = sqlsrv_fetch_array($query_sumActualpricerkrhino, SQLSRV_FETCH_ASSOC);

                        $sql_sumActualpricerkrtttc = "SELECT SUM(CONVERT(DECIMAL(10,3),a.ACTUALPRICE)) AS 'SUMACTUALPRICE'
                          FROM (SELECT  b.ACTUALPRICE,a.VEHICLETRANSPORTPLANID
                          FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                          INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b. VEHICLETRANSPORTPLANID
                          WHERE 1 = 1
                          AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                          AND a.COMPANYCODE = '" . $_POST['companycode'] . "' AND a.CUSTOMERCODE = 'TTTC'
                          AND b.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''
                          GROUP BY a.VEHICLETRANSPORTPLANID,b.ACTUALPRICE) a";
                        $query_sumActualpricerkrtttc = sqlsrv_query($conn, $sql_sumActualpricerkrtttc, $params_sumActualpricerkrtttc);
                        $result_sumActualpricerkrtttc = sqlsrv_fetch_array($query_sumActualpricerkrtttc, SQLSRV_FETCH_ASSOC);

                        $sql_sumActualpricerkrtsat = "SELECT SUM(CONVERT(DECIMAL(10,3),a.ACTUALPRICE)) AS 'SUMACTUALPRICE'
                          FROM (SELECT  b.ACTUALPRICE,a.VEHICLETRANSPORTPLANID
                          FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                          INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b. VEHICLETRANSPORTPLANID
                          WHERE 1 = 1
                          AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                          AND a.COMPANYCODE = '" . $_POST['companycode'] . "' AND a.CUSTOMERCODE = 'TSAT'
                          AND b.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''
                          GROUP BY a.VEHICLETRANSPORTPLANID,b.ACTUALPRICE) a";
                        $query_sumActualpricerkrtsat = sqlsrv_query($conn, $sql_sumActualpricerkrtsat, $params_sumActualpricerkrtsat);
                        $result_sumActualpricerkrtsat = sqlsrv_fetch_array($query_sumActualpricerkrtsat, SQLSRV_FETCH_ASSOC);


                                        if ($result_seReporttransportsum['COMPANYCODE'] == 'RKL' && $result_seCus['CUSTOMERCODE'] == 'SKB') {
                                          $sql_sumActualpriceskb = "SELECT SUM (CONVERT(DECIMAL(10,3),ACTUALPRICE)) AS 'SUMACTUALPRICESKB'
                                          FROM  [dbo].[VEHICLETRANSPORTPLAN]
                                          WHERE 1 = 1
                                          AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                                          AND COMPANYCODE = '" . $_POST['companycode'] . "' AND CUSTOMERCODE = '" . $result_seCus['CUSTOMERCODE'] . "' ";
                                          $query_sumActualpriceskb = sqlsrv_query($conn, $sql_sumActualpriceskb, $params_sumActualpriceskb);
                                          $result_sumActualpriceskb = sqlsrv_fetch_array($query_sumActualpriceskb, SQLSRV_FETCH_ASSOC);
                                        } else {
                                          // code...
                                        }

                                        $sql_sumActualpricerks = "SELECT SUM(CONVERT(INT,ACTUALPRICE))  AS 'SUMACTUALPRICE'
                                        FROM [dbo].[VEHICLETRANSPORTPLAN] a WHERE 1 = 1
                                        AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                                        AND a.COMPANYCODE = 'RKS' AND a.CUSTOMERCODE = '" . $result_seCus['CUSTOMERCODE'] . "'
                                        AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != '' ";
                                        $query_sumActualpricerks = sqlsrv_query($conn, $sql_sumActualpricerks, $params_sumActualpricerks);
                                        $result_sumActualpricerks = sqlsrv_fetch_array($query_sumActualpricerks, SQLSRV_FETCH_ASSOC);

                                        $sql_sumFuel = "SELECT SUM(CAST(C3 AS DECIMAL(18,2))) AS 'FUELINCEN'
                                        FROM [dbo].[VEHICLETRANSPORTPLAN] a WHERE 1 = 1
                                        AND ACTUALPRICE IS NOT NULL
                                        AND ACTUALPRICE != ''
                                        AND C3 IS NOT NULL
                                        AND C3 != ''
                                        AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                                        AND a.COMPANYCODE = '" . $_POST['companycode'] . "' AND a.CUSTOMERCODE = '" . $result_seCus['CUSTOMERCODE'] . "' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != '' ";
                                        $query_sumFuel = sqlsrv_query($conn, $sql_sumFuel, $params_sumFuel);
                                        $result_sumFuel = sqlsrv_fetch_array($query_sumFuel, SQLSRV_FETCH_ASSOC);

                                        $sql_seExpresswaysum = "SELECT SUM(CONVERT(INT,PAY_EXPRESSWAY15))+
                                        SUM(CONVERT(INT,PAY_EXPRESSWAY25))+
                                        SUM(CONVERT(INT,PAY_EXPRESSWAY45))+
                                        SUM(CONVERT(INT,PAY_EXPRESSWAY45RETURN))+
                                        SUM(CONVERT(INT,PAY_EXPRESSWAY50))+
                                        SUM(CONVERT(INT,PAY_EXPRESSWAY50RETURN))+
                                        SUM(CONVERT(INT,PAY_EXPRESSWAY55))+
                                        SUM(CONVERT(INT,PAY_EXPRESSWAY65))+
                                        SUM(CONVERT(INT,PAY_EXPRESSWAY65RETURN))+
                                        SUM(CONVERT(INT,PAY_EXPRESSWAY75))+
                                        SUM(CONVERT(INT,PAY_EXPRESSWAY100))+
                                        SUM(CONVERT(INT,PAY_EXPRESSWAY105RETURN))+
                                        SUM(CONVERT(INT,PAY_EXPRESSWAY195)) AS 'SUMEXPRESSWAY'
                                        FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
                                        WHERE CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                                        AND a.COMPANYCODE = '" . $_POST['companycode'] . "' AND a.CUSTOMERCODE = '" . $result_seCus['CUSTOMERCODE'] . "'";
                                        $query_seExpresswaysum = sqlsrv_query($conn, $sql_seExpresswaysum, $params_seExpresswaysum);
                                        $result_seExpresswaysum = sqlsrv_fetch_array($query_seExpresswaysum, SQLSRV_FETCH_ASSOC);

                                        /////////////////////PAYOTHER/////////////////////////////////////
                                        $sql_sePayother = "SELECT SUM(CONVERT(INT,PAY_OTHER)) AS 'PAYOTHER'
                                        FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
                                        WHERE CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                                        AND a.COMPANYCODE = '" . $_POST['companycode'] . "' AND a.CUSTOMERCODE = '" . $result_seCus['CUSTOMERCODE'] . "'";
                                        $query_sePayother = sqlsrv_query($conn, $sql_sePayother, $params_sePayother);
                                        $result_sePayother = sqlsrv_fetch_array($query_sePayother, SQLSRV_FETCH_ASSOC);

                                        /////////////////////PAYREPAIR/////////////////////////////////////
                                        $sql_seRepairsum = "SELECT SUM(CONVERT(INT,a.PAY_REPAIR)) AS 'SUMREPAIR' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID WHERE a.ACTUALPRICE IS NOT NULL
                                        AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                                        AND a.COMPANYCODE = '" . $_POST['companycode'] . "' AND a.CUSTOMERCODE = '" . $result_seCus['CUSTOMERCODE'] . "'";
                                        $query_seRepairsum = sqlsrv_query($conn, $sql_seRepairsum, $params_seRepairsum);
                                        $result_seRepairsum = sqlsrv_fetch_array($query_seRepairsum, SQLSRV_FETCH_ASSOC);

                                        /////////////DENSO-THAI PRICE/////////////////////////////////////////////////////
                                        $sql_seDensoPriceSum = "SELECT SUM(a.PRICEAC) AS 'SUMDENSOPRICE'
                                        FROM (SELECT a.JOBNO,a.JOBSTART AS 'JOBSTART',a.JOBEND AS 'JOBEND',
                                          CASE
                                          WHEN (a.JOBSTART = 'EXP-E1' AND a.JOBEND = 'Normal1') THEN a.ACTUALPRICE / 2
                                          WHEN (a.JOBSTART = 'EXP-E1(N)' AND a.JOBEND = 'Normal1') THEN a.ACTUALPRICE / 2
                                          WHEN (a.JOBSTART = 'EXP-E1' AND a.JOBEND = 'Normal5') THEN a.ACTUALPRICE / 2
                                          WHEN (a.JOBSTART = 'EXP-E1(N)' AND a.JOBEND = 'Normal5') THEN a.ACTUALPRICE / 2
                                          WHEN (a.JOBSTART = 'EXP-E1' AND a.JOBEND = 'Normal8') THEN a.ACTUALPRICE / 2
                                          WHEN (a.JOBSTART = 'EXP-E1(N)' AND a.JOBEND = 'Normal8') THEN a.ACTUALPRICE / 2

                                          WHEN (a.JOBSTART = 'EXP-P1' AND a.JOBEND = 'Normal1') THEN a.ACTUALPRICE / 2
                                          WHEN (a.JOBSTART = 'EXP-P1(N)' AND a.JOBEND = 'Normal1') THEN a.ACTUALPRICE / 2
                                          WHEN (a.JOBSTART = 'EXP-P1' AND a.JOBEND = 'Normal2') THEN a.ACTUALPRICE / 2
                                          WHEN (a.JOBSTART = 'EXP-P1(N)' AND a.JOBEND = 'Norma2') THEN a.ACTUALPRICE / 2
                                          WHEN (a.JOBSTART = 'EXP-P1' AND a.JOBEND = 'Normal3') THEN a.ACTUALPRICE / 2
                                          WHEN (a.JOBSTART = 'EXP-P1(N)' AND a.JOBEND = 'Normal3') THEN a.ACTUALPRICE / 2
                                          ELSE a.ACTUALPRICE
                                          END AS 'PRICEAC',
                                          a.ACTUALPRICE AS 'PRICE'
                                          FROM [dbo].[VEHICLETRANSPORTPLAN] a WHERE 1 = 1
                                          AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                                          AND a.COMPANYCODE = 'RKS' AND a.CUSTOMERCODE = 'DENSO-THAI'
                                          AND a.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != '') a";
                                          $query_seDensoPriceSum = sqlsrv_query($conn, $sql_seDensoPriceSum, $params_seDensoPriceSum);
                                          $result_seDensoPriceSum = sqlsrv_fetch_array($query_seDensoPriceSum, SQLSRV_FETCH_ASSOC);


                                          //////////////////////////////////////////////////////////////////////////////////

                                          $sql_seSystimesum = "{call megGetdate_v2(?)}";
                                          $params_seSystimesum = array(
                                            array('select_getdate', SQLSRV_PARAM_IN)
                                          );
                                          $query_seSystimesum = sqlsrv_query($conn, $sql_seSystimesum, $params_seSystimesum);
                                          $result_seSystimesum = sqlsrv_fetch_array($query_seSystimesum, SQLSRV_FETCH_ASSOC);

                                          $mmsum = "";
                                          switch ((int) substr($result_seSystimesum['GETDATE'], 4, 2)) {
                                            case '1': {
                                              $mmsum = "มกราคม";
                                            }
                                            break;
                                            case '2': {
                                              $mmsum = "กุมภาพันธ์";
                                            }
                                            break;
                                            case '3': {
                                              $mmsum = "มีนาคม";
                                            }
                                            break;
                                            case '4': {
                                              $mmsum = "เมษายน";
                                            }
                                            break;
                                            case '5': {
                                              $mmsum = "พฤษภาคม";
                                            }
                                            break;
                                            case '6': {
                                              $mmsum = "มิถุนายน";
                                            }
                                            break;
                                            case '7': {
                                              $mmsum = "กรกฎาคม";
                                            }
                                            break;
                                            case '8': {
                                              $mmsum = "สิงหาคม";
                                            }
                                            break;
                                            case '9': {
                                              $mmsum = "กันยายน";
                                            }
                                            break;
                                            case '10': {
                                              $mmsum = "ตุลาคม";
                                            }
                                            break;
                                            case '11': {
                                              $mmsum = "พฤศจิกายน";
                                            }
                                            break;
                                            default : {
                                              $mm = "ธันวาคม";
                                            }
                                            break;
                                          }
                                          $condOilprice1sum = " AND COMPANYCODE = '" . $result_seReporttransportsum['COMPANYCODE'] . "' AND YEAR = '" . substr($result_seSystimesum['GETDATE'], 0, 4) . "' AND MONTH = '" . $mmsum . "'";
                                          $condOilprice2sum = "";
                                          $condOilprice3sum = "";
                                          $sql_seOilpricesum = "{call megOilprice_v2(?,?,?,?)}";
                                          $params_seOilpricesum = array(
                                            array('select_oilprice', SQLSRV_PARAM_IN),
                                            array($condOilprice1sum, SQLSRV_PARAM_IN),
                                            array($condOilprice2sum, SQLSRV_PARAM_IN),
                                            array($condOilprice3sum, SQLSRV_PARAM_IN)
                                          );
                                          $query_seOilpricesum = sqlsrv_query($conn, $sql_seOilpricesum, $params_seOilpricesum);
                                          $result_seOilpricesum = sqlsrv_fetch_array($query_seOilpricesum, SQLSRV_FETCH_ASSOC);


                                          $i++;
                                          $sum_tripamount = $result_seTripamountsum['SUMTRIPAMOUNT'];
                                          $sum_weightin = $result_seTonsum['SUMWEIGHTIN'];

                                          ////////////////SUM  FOR FOOTER ///////////////////////////


                                          $sum_weightinsum = $sum_weightinsum+$result_seTonsum['SUMWEIGHTIN'];
                                          $sum_o4sum = $sum_o4sum + $result_sumO4['SUMO4'];

                                          //////////////////////////////////////////////////////////
                                          // echo  $sum_weightin = $result_seTonsum['SUMWEIGHTIN'];

                                          $sum_o4pricesum = ($result_seOilpricesum['PRICE'] * $result_sumO4['SUMO4']);
                                          $sum_expresswaysum = $result_seExpresswaysum['SUMEXPRESSWAY']+$result_sePayother['PAYOTHER'];
                                          $sum_e1sum = $sum_e1sum + $result_seReporttransportsum['E1'];
                                          $sum_c3sum = $sum_c3sum + $result_seReporttransportsum['C3'];
                                          $sum_repairsum = $sum_repairsum + $result_seRepairsum['PAY_REPAIR'];


                                          if ($result_seCus['CUSTOMERCODE'] == 'TGT' || $result_seCus['CUSTOMERCODE'] == 'TAW' || $result_seCus['CUSTOMERCODE'] == 'DAIKI' || $result_seCus['CUSTOMERCODE'] == 'TGT' || $result_seCus['CUSTOMERCODE'] == 'DENSO-THAI' || $result_seCus['CUSTOMERCODE'] == 'TMT' || $result_seCus['CUSTOMERCODE'] == 'STM' || $result_seCus['CUSTOMERCODE'] == 'CAMGURU') {
                                            $sql_sumO4 = "SELECT SUM(CAST(O4 AS DECIMAL(18,2))) AS 'SUMO4'
                                            FROM [dbo].[VEHICLETRANSPORTPLAN] a WHERE 1 = 1
                                            AND O4 != ''
                                            AND STATUSNUMBER != '0'
                                            AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                                            AND a.COMPANYCODE = '" . $_POST['companycode'] . "' AND a.CUSTOMERCODE = '" . $result_seCus['CUSTOMERCODE'] . "' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != '' ";
                                            $query_sumO4 = sqlsrv_query($conn, $sql_sumO4, $params_sumO4);
                                            $result_sumO4 = sqlsrv_fetch_array($query_sumO4, SQLSRV_FETCH_ASSOC);
                                          } else {

                                            $sql_sumO4 = "SELECT SUM(CAST(O4 AS DECIMAL(18,2))) AS 'SUMO4'
                                            FROM [dbo].[VEHICLETRANSPORTPLAN] a WHERE 1 = 1
                                            AND O4 != ''
                                            AND STATUSNUMBER != '0'
                                            AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                                            AND a.COMPANYCODE = '" . $_POST['companycode'] . "' AND a.CUSTOMERCODE = '" . $result_seCus['CUSTOMERCODE'] . "' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != '' ";
                                            $query_sumO4 = sqlsrv_query($conn, $sql_sumO4, $params_sumO4);
                                            $result_sumO4 = sqlsrv_fetch_array($query_sumO4, SQLSRV_FETCH_ASSOC);
                                          }


                                          $sql_seCartype = "SELECT DISTINCT CARRYTYPE FROM [dbo].[VEHICLETRANSPORTPRICE] WHERE COMPANYCODE = '" . $_POST['companycode'] . "' AND CUSTOMERCODE = '" . $result_seCus['CUSTOMERCODE'] . "' AND CARRYTYPE IS NOT NULL";
                                          $query_seCartype = sqlsrv_query($conn, $sql_seCartype, $params_seCartype);
                                          $result_seCartype = sqlsrv_fetch_array($query_seCartype, SQLSRV_FETCH_ASSOC);


                                          ///////////////////////////FUEL BATH AND FUEL LIT STM//////////////////////////////////////////////////
                                          if ($result_seReporttransportsum['COMPANYCODE'] == 'RKS' && $result_seCus['CUSTOMERCODE'] == 'STM') {

                                            $sql_seFuel = "SELECT  (COUNT(VEHICLETRANSPORTPLANID)*3.47) AS 'FUELLITSTM',COUNT(VEHICLETRANSPORTPLANID) AS 'COUNT'
                                            FROM [dbo].[VEHICLETRANSPORTPLAN] a WHERE 1 = 1
                                            AND STATUSNUMBER != '0'
                                            AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                                            AND a.COMPANYCODE = 'RKS' AND a.CUSTOMERCODE = 'STM'";
                                            $query_seFuel = sqlsrv_query($conn, $sql_seFuel, $params_seFuel);
                                            $result_seFuel = sqlsrv_fetch_array($query_seFuel, SQLSRV_FETCH_ASSOC);

                                            $FUELLITSTM  = $result_seFuel['FUELLITSTM'];
                                            $FUELBTHSTM = ($result_seOilpricesum['PRICE'] * 3.47)*$result_seFuel['COUNT'];
                                          }else {
                                            // code...
                                          }


                                          if (($result_seReporttransportsum['COMPANYCODE'] == 'RKS' && $result_seCus['CUSTOMERCODE'] == 'STM') && ($result_seReporttransportsum['O4'] == '' || $result_seReporttransportsum['O4'] == '0')) {
                                            $FUELINCENSTM = 0;
                                          } else {
                                            $FUELINCENSTM = $result_sumFuel['FUELINCEN'];
                                          }
                                          ///////////////////////////////////////////////////////////////////////////////////////

                                          // ////////////////////////////TOTALSUM//////////////////////////////////////////////
                                          if ($result_seReporttransportsum['COMPANYCODE'] == 'RKS') {
                                            if ($result_seCus['CUSTOMERCODE'] == 'STM') {
                                              $TOTALSUM = ($result_seOilpricesum['PRICE'] * $result_sumO4['SUMO4']) + $result_seExpresswaysum['SUMEXPRESSWAY'] + $result_seWorkincenstm['SUMWORKINCENSTM'] + $FUELINCENSTM + $result_seRepairsum['PAY_REPAIR']
                                              +$result_sePayother['PAYOTHER'];
                                              $TOTALSTM = $TOTALSUM;
                                            } else {
                                              $TOTALSUM = ($result_seOilpricesum['PRICE'] * $result_sumO4['SUMO4']) + $result_seExpresswaysum['SUMEXPRESSWAY'] + $result_sumE1['SUME1'] + $result_sumFuel['FUELINCEN'] + $result_seRepairsum['PAY_REPAIR']
                                              +$result_sePayother['PAYOTHER'];
                                              $TOTALRKS = $TOTALRKS+$TOTALSUM;
                                            }
                                          } else if ($result_seReporttransportsum['COMPANYCODE'] == 'RKR' || $result_seReporttransportsum['COMPANYCODE'] == 'RKL') {
                                            if ($result_seCus['CUSTOMERCODE'] == 'TTAST') {
                                              $TOTALSUM = ($result_seOilpricesum['PRICE'] * $result_sumO4['SUMO4']) + $result_seExpresswaysum['SUMEXPRESSWAY'] + $result_sumE1['SUME1'] + $result_sumFuel['FUELINCEN'] + $result_seRepairsum['PAY_REPAIR']
                                              +$result_sePayother['PAYOTHER'];
                                            } else if ($result_seCus['CUSTOMERCODE'] == 'TTAT') {
                                              $TOTALSUM = ($result_seOilpricesum['PRICE'] * $result_sumO4['SUMO4']) + $result_seExpresswaysum['SUMEXPRESSWAY'] + $result_sumE1['SUME1'] + $result_sumFuel['FUELINCEN'] + $result_seRepairsum['PAY_REPAIR']
                                              +$result_sePayother['PAYOTHER'];
                                            } else {
                                              $TOTALSUM = ($result_seOilpricesum['PRICE'] * $result_sumO4['SUMO4']) + $result_seExpresswaysum['SUMEXPRESSWAY'] + $result_sumE1['SUME1'] + $result_sumFuel['FUELINCEN'] + $result_seRepairsum['PAY_REPAIR']
                                              +$result_sePayother['PAYOTHER'];
                                            }
                                            $TOTALRKRRKL = $TOTALRKRRKL+$TOTALSUM;
                                          } else {
                                            $TOTALSUM = 0;
                                          }

                                          ///////////SUMTOTAL FOR FOOTER //////////////////////////

                                          if ($_POST['companycode'] == 'RKS') {
                                            $TOTALSUMRKS = $TOTALSTM+$TOTALRKS;
                                            $TOTALSUMALL = $TOTALSUMRKS;
                                          }else {
                                            $TOTALSUMRKRRKL = $TOTALRKRRKL;
                                            $TOTALSUMALL = $TOTALSUMRKRRKL;
                                          }

                                          /////////////////////////////////////////////////////////


                                          // if ($result_seReporttransportsum['COMPANYCODE'] == 'RKS') {
                                          //   if ($result_seCus['CUSTOMERCODE'] == 'STM') {
                                          //     $TOTALSUM = ($result_seOilpricesum['PRICE'] * $result_sumO4['SUMO4']) + $result_seExpresswaysum['SUMEXPRESSWAY'] + $result_seWorkincenstm['SUMWORKINCENSTM'] + $FUELINCENSTM + $result_seRepairsum['PAY_REPAIR'];
                                          //   } else {
                                          //     $TOTALSUM = ($result_seOilpricesum['PRICE'] * $result_sumO4['SUMO4']) + $result_seExpresswaysum['SUMEXPRESSWAY'] + $result_sumE1['SUME1'] + $result_sumFuel['FUELINCEN'] + $result_seRepairsum['PAY_REPAIR'];
                                          //   }
                                          // } else if (($result_seReporttransportsum['COMPANYCODE'] == 'RKR' || $result_seReporttransportsum['COMPANYCODE'] == 'RKL') && $result_seCus['CUSTOMERCODE'] == 'TTAST' || $result_seCus['CUSTOMERCODE'] == 'TTAT') {
                                          //   $TOTALSUM = ($result_seOilpricesum['PRICE'] * $result_sumO4['SUMO4']) + $result_seExpresswaysum['SUMEXPRESSWAY'] + $result_sumE1['SUME1'] + $result_sumFuel['FUELINCEN'] + $result_seRepairsum['PAY_REPAIR'];
                                          // } else {
                                          //   $TOTALSUM = ($result_seOilpricesum['PRICE'] * $result_sumO4['SUMO4']) + $result_seExpresswaysum['SUMEXPRESSWAY'] + $result_sumE1['SUME1'] + $result_sumFuel['FUELINCEN'] + $result_seRepairsum['PAY_REPAIR'];
                                          // }
                                          /////////////////////////////////// EVASUM////////////////////////////////////
                                          if ($result_seReporttransportsum['COMPANYCODE'] == 'RKS') {
                                            if ($result_seCus['CUSTOMERCODE'] == 'STM') {
                                              $EVASUM = ($TOTALSUM < $result_sumActualpricestm['SUMPRICESTM']) ? OK : NG;
                                            } else if($result_seCus['CUSTOMERCODE'] == 'DENSO-THAI'){
                                              $EVASUM = ($TOTALSUM < $result_seDensoPriceSum['SUMDENSOPRICE']) ? OK : NG;
                                            } else {
                                              $EVASUM = ($TOTALSUM < $result_sumActualpricerks['SUMACTUALPRICE']) ? OK : NG;
                                            }
                                          } else if ($result_seReporttransportsum['COMPANYCODE'] == 'RKR' || $result_seReporttransportsum['COMPANYCODE'] == 'RKL') {
                                            if ($result_seCus['CUSTOMERCODE'] == 'SKB') {
                                              $EVASUM = ($TOTALSUM < $result_sumActualpriceskb['SUMACTUALPRICESKB']) ? OK : NG;
                                            } else if ($result_seCus['CUSTOMERCODE'] == 'TTAST') {
                                              $EVASUM = ($TOTALSUM < $result_sumActualpricerkrttast['SUMACTUALPRICE']) ? OK : NG;
                                            } else if ($result_seCus['CUSTOMERCODE'] == 'TGT') {
                                              $EVASUM = ($TOTALSUM < $result_sumActualpricerkrtgt['SUMACTUALPRICE']) ? OK : NG;
                                            } else if ($result_seCus['CUSTOMERCODE'] == 'TTAT') {
                                              $EVASUM = ($TOTALSUM < $result_sumActualpricerkrttat['SUMACTUALPRICE']) ? OK : NG;
                                            } else if ($result_seCus['CUSTOMERCODE'] == 'DAIKI') {
                                              $EVASUM = ($TOTALSUM < $result_sumActualpricerkrdaiki['SUMACTUALPRICE']) ? OK : NG;
                                            } else if ($result_seCus['CUSTOMERCODE'] == 'TKT') {
                                              $EVASUM = ($TOTALSUM < $result_sumActualpricerkrtkt['SUMACTUALPRICE']) ? OK : NG;
                                            } else if ($result_seCus['CUSTOMERCODE'] == 'SUTT') {
                                              $EVASUM = ($TOTALSUM < $result_sumActualpricerkrsutt['SUMACTUALPRICE']) ? OK : NG;
                                            } else if ($result_seCus['CUSTOMERCODE'] == 'NITTSUSHOJI') {
                                              $EVASUM = ($TOTALSUM < $result_sumActualpricerkrnitsu['SUMACTUALPRICE']) ? OK : NG;
                                            } else if ($result_seCus['CUSTOMERCODE'] == 'TDEM') {
                                              $EVASUM = ($TOTALSUM < $result_sumActualpricerkrtdem['SUMACTUALPRICE']) ? OK : NG;
                                            } else if ($result_seCus['CUSTOMERCODE'] == 'GMT') {
                                              $EVASUM = ($TOTALSUM < $result_sumActualpricerkrgmt['SUMACTUALPRICE']) ? OK : NG;
                                            } else if ($result_seCus['CUSTOMERCODE'] == 'HINO') {
                                              $EVASUM = ($TOTALSUM < $result_sumActualpricerkrhino['SUMACTUALPRICE']) ? OK : NG;
                                            } else if ($result_seCus['CUSTOMERCODE'] == 'TTTC') {
                                              $EVASUM = ($TOTALSUM < $result_sumActualpricerkrtttc['SUMACTUALPRICE']) ? OK : NG;
                                            } else {
                                              $EVASUM = ($TOTALSUM < $result_sumActualpricerkr['SUMACTUALPRICE']) ? OK : NG;
                                            }
                                          } else {
                                            $EVASUM = '-';
                                          }


                                          ////////////////////////////////////PROFITSUM///////////////////////////////

                                          if ($result_seReporttransportsum['COMPANYCODE'] == 'RKS') {
                                            if ($result_seCus['CUSTOMERCODE'] == 'TGT' || $result_seCus['CUSTOMERCODE'] == 'TAW' || $result_seCus['CUSTOMERCODE'] == 'DAIKI' || $result_seCus['CUSTOMERCODE'] == 'TGT'  || $result_seCus['CUSTOMERCODE'] == 'TMT' || $result_seCus['CUSTOMERCODE'] == 'CAMGURU') {
                                              $PROFITSUM = (($result_sumActualpricerks['SUMACTUALPRICE'] - $TOTALSUM) * 100) / ($result_sumActualpricerks['SUMACTUALPRICE']);
                                            } else if ($result_seCus['CUSTOMERCODE'] == 'STM') {
                                              $PROFITSUM = (($result_sumActualpricestm['SUMPRICESTM'] - $TOTALSUM) * 100) / ($result_sumActualpricestm['SUMPRICESTM']);
                                            } else if ($result_seCus['CUSTOMERCODE'] == 'DENSO-THAI') {
                                              $PROFITSUM = (($result_seDensoPriceSum['SUMDENSOPRICE'] - $TOTALSUM) * 100) / ($result_seDensoPriceSum['SUMDENSOPRICE']);
                                            } else {
                                              $PROFITSUM = 0;
                                            }
                                          } else if ($result_seReporttransportsum['COMPANYCODE'] == 'RKR' || $result_seReporttransportsum['COMPANYCODE'] == 'RKL') {
                                            if ($result_seCus['CUSTOMERCODE'] == 'SKB') {
                                              $PROFITSUM = (($result_sumActualpriceskb['SUMACTUALPRICESKB'] - $TOTALSUM) * 100) / ($result_sumActualpriceskb['SUMACTUALPRICESKB']);
                                            } else if ($result_seCus['CUSTOMERCODE'] == 'TTAST') {
                                              $PROFITSUM = (($result_sumActualpricerkrttast['SUMACTUALPRICE'] - $TOTALSUM) * 100) / ($result_sumActualpricerkrttast['SUMACTUALPRICE']);
                                            } else if ($result_seCus['CUSTOMERCODE'] == 'TGT') {
                                              $PROFITSUM = (($result_sumActualpricerkrtgt['SUMACTUALPRICE'] - $TOTALSUM) * 100) / ($result_sumActualpricerkrtgt['SUMACTUALPRICE']);
                                            } else if ($result_seCus['CUSTOMERCODE'] == 'TTAT') {
                                              $PROFITSUM = (($result_sumActualpricerkrttat['SUMACTUALPRICE'] - $TOTALSUM) * 100) / ($result_sumActualpricerkrttat['SUMACTUALPRICE']);
                                            } else if ($result_seCus['CUSTOMERCODE'] == 'DAIKI') {
                                              $PROFITSUM = (($result_sumActualpricerkrdaiki['SUMACTUALPRICE'] - $TOTALSUM) * 100) / ($result_sumActualpricerkrdaiki['SUMACTUALPRICE']);
                                            } else if ($result_seCus['CUSTOMERCODE'] == 'TKT') {
                                              $PROFITSUM = (($result_sumActualpricerkrtkt['SUMACTUALPRICE'] - $TOTALSUM) * 100) / ($result_sumActualpricerkrtkt['SUMACTUALPRICE']);
                                            } else if ($result_seCus['CUSTOMERCODE'] == 'SUTT') {
                                              $PROFITSUM = (($result_sumActualpricerkrsutt['SUMACTUALPRICE'] - $TOTALSUM) * 100) / ($result_sumActualpricerkrsutt['SUMACTUALPRICE']);
                                            } else if ($result_seCus['CUSTOMERCODE'] == 'NITTSUSHOJI') {
                                              $PROFITSUM = (($result_sumActualpricerkrnitsu['SUMACTUALPRICE'] - $TOTALSUM) * 100) / ($result_sumActualpricerkrnitsu['SUMACTUALPRICE']);
                                            } else if ($result_seCus['CUSTOMERCODE'] == 'TDEM') {
                                              $PROFITSUM = (($result_sumActualpricerkrtdem['SUMACTUALPRICE'] - $TOTALSUM) * 100) / ($result_sumActualpricerkrtdem['SUMACTUALPRICE']);
                                            } else if ($result_seCus['CUSTOMERCODE'] == 'GMT') {
                                              $PROFITSUM = (($result_sumActualpricerkrgmt['SUMACTUALPRICE'] - $TOTALSUM) * 100) / ($result_sumActualpricerkrgmt['SUMACTUALPRICE']);
                                            }else if ($result_seCus['CUSTOMERCODE'] == 'HINO') {
                                              $PROFITSUM = (($result_sumActualpricerkrhino['SUMACTUALPRICE'] - $TOTALSUM) * 100) / ($result_sumActualpricerkrhino['SUMACTUALPRICE']);
                                            }else if ($result_seCus['CUSTOMERCODE'] == 'TTTC') {
                                              $PROFITSUM = (($result_sumActualpricerkrtttc['SUMACTUALPRICE'] - $TOTALSUM) * 100) / ($result_sumActualpricerkrtttc['SUMACTUALPRICE']);
                                            } else {
                                              $PROFITSUM = (($result_sumActualpricerkr['SUMACTUALPRICE'] - $TOTALSUM) * 100) / ($result_sumActualpricerkr['SUMACTUALPRICE']);
                                            }
                                          } else {
                                            $PROFITSUM = 0;
                                          }



                                          // if ($result_seReporttransportsum['COMPANYCODE'] == 'RKS') {
                                          //   if ($result_seCus['CUSTOMERCODE'] == 'TGT' || $result_seCus['CUSTOMERCODE'] == 'TAW' || $result_seCus['CUSTOMERCODE'] == 'DAIKI' || $result_seCus['CUSTOMERCODE'] == 'TGT' || $result_seCus['CUSTOMERCODE'] == 'DENSO-THAI' || $result_seCus['CUSTOMERCODE'] == 'TMT' || $result_seCus['CUSTOMERCODE'] == 'CAMGURU') {
                                          //     $PROFITSUM = (($result_sumActualpricerks['SUMACTUALPRICE'] - $TOTALSUM) * 100) / ($result_sumActualpricerks['SUMACTUALPRICE']);
                                          //   } else if ($result_seCus['CUSTOMERCODE'] == 'STM') {
                                          //     $PROFITSUM = (($result_sumActualpricestm['SUMPRICESTM'] - $TOTALSUM) * 100) / ($result_sumActualpricestm['SUMPRICESTM']);
                                          //   } else {
                                          //     $PROFITSUM = '-';
                                          //   }
                                          // } else if ($result_seCus['CUSTOMERCODE'] == 'SKB') {
                                          //   $PROFITSUM = (($result_sumActualpriceskb['SUMACTUALPRICESKB'] - $TOTALSUM) * 100) / ($result_sumActualpriceskb['SUMACTUALPRICESKB']);
                                          // } else if (($result_seReporttransportsum['COMPANYCODE'] == 'RKR' || $result_seReporttransportsum['COMPANYCODE'] == 'RKL') && ($result_seCus['CUSTOMERCODE'] == 'TTAST' || $result_seCus['CUSTOMERCODE'] == 'TGT' || $result_seCus['CUSTOMERCODE'] == 'TTAT')) {
                                          //
                                          //   $PROFITSUM = (($result_sumActualpricerkrttat['SUMACTUALPRICETTAST'] - $TOTALSUM) * 100) / ($result_sumActualpricerkrttat['SUMACTUALPRICETTAST']);
                                          // } else {
                                          //
                                          //   $PROFITSUM = (($result_sumActualpricerkr['SUMACTUALPRICE'] - $TOTALSUM) * 100) / ($result_sumActualpricerkr['SUMACTUALPRICE']);
                                          // }
                                          /////////////////////////////////////////////////////////////////////////////
                                          // if ($result_seReporttransportsum['COMPANYCODE'] == 'RKS') {
                                          //
                                          //       $PROFITSUM = (($result_sumActualpricerks['SUMACTUALPRICE']-$TOTALSUM)*100)/($result_sumActualpricerks['SUMACTUALPRICE']);
                                          //
                                          //
                                          // }else if ($result_seReporttransportsum['COMPANYCODE'] != 'RKS') {
                                          //       $PROFITSUM = (($result_seActualpricesum['SUMACTUALPRICE']-$TOTALSUM)*100)/($result_seActualpricesum['SUMACTUALPRICE']);
                                          // }else {
                                          //       $PROFITSUM = '-';
                                          // }
                                          ?>
                                          <tr>
                                            <td style="text-align: center"><label  style="width: 100px"><?= $_POST['companycode'] ?><label></td>
                                              <td><label  style="width: 100px"><a href="#" onclick="report_dailybudgetdetail('<?= $result_seCus['CUSTOMERCODE'] ?>')"><?= $result_seCus['CUSTOMERCODE'] ?><label></a></td>

                                                <!--//////////////////// TRIPAMOUNT ///////////////  -->
                                                <?php
                                                if ($_POST['companycode'] == 'RKS') {
                                                  if ($result_seCus['CUSTOMERCODE'] == 'STM') {
                                                    ?>
                                                    <td ><label  style="width: 100px"><?= number_format($result_seTripamountstm['SUMTRIPAMOUNTSTM']) ?><label></td>
                                                      <?php
                                                    } else {
                                                      ?>
                                                      <td ><label  style="width: 100px"><?= number_format($sum_tripamount) ?><label></td>
                                                        <?php
                                                      }

                                                      ?>
                                                      <?php
                                                    } else if ($_POST['companycode'] == 'RKR' || $_POST['companycode'] == 'RKL') {
                                                      ?>
                                                      <td ><label  style="width: 100px"><?= number_format($sum_tripamount) ?><label></td>
                                                        <?php
                                                      } else {
                                                        ?>
                                                        <td ><label  style="width: 100px">-<label></td>
                                                          <?php
                                                        }
                                                        //Trip Amount
                                                        ?>
                                                        <!-- //////////SUM TRIP FOR FOOTER/////////////////////////////////////// -->
                                                        <?php
                                                        if ($_POST['companycode']  == 'RKS') {

                                                          $sumtrip1 = $sumtrip1 + $sum_tripamount;
                                                          $sumtrip2 = $sumtrip1+$result_seTripamountstm['SUMTRIPAMOUNTSTM'];
                                                          $sum_tripamountsum = $sumtrip2-$result_seFuel['COUNT'];

                                                        }else {
                                                          $sum_tripamountsum = $sum_tripamountsum+$result_seTripamountsum['SUMTRIPAMOUNT'] ;
                                                        }

                                                        ?>

                                                        <!-- /////////////////////////////////////////////////////////////////////// -->

                                                        <!-- /////////////////////////WEIGHTINTON////////////////////////////////// -->
                                                        <?php
                                                        if ($_POST['companycode'] == 'RKS') {
                                                          ?>
                                                          <td ><label  style="width: 100px">-<label></td>
                                                            <?php
                                                          } else {
                                                            ?>
                                                            <td ><label  style="width: 100px"><?= number_format($sum_weightin,2) ?><label></td>
                                                              <?php
                                                            }
                                                            //SUMWEIGHTIN
                                                            ?>

                                                            <!-- ///////////////////////////////////////////////////////////////////// -->

                                                            <!-- /////////////////////////ACTUALPRICE (SALE PRICE)////////////////////////////////// -->
                                                            <?php
                                                            if ($result_seReporttransportsum['COMPANYCODE'] == 'RKS') {
                                                              if ($result_seCus['CUSTOMERCODE'] == 'STM') {
                                                                ?>
                                                                <td ><label  style="width: 100px"><?= number_format($result_sumActualpricestm['SUMPRICESTM'], 2) ?><label></td>

                                                                  <?php

                                                                }else if ($result_seCus['CUSTOMERCODE'] == 'DENSO-THAI') {
                                                                  ?>
                                                                  <td ><label  style="width: 100px"><?=number_format($result_seDensoPriceSum['SUMDENSOPRICE'],2)?><label></td>
                                                                    <?php

                                                                  } else {
                                                                    ?>

                                                                    <td ><label  style="width: 100px"><?= number_format($result_sumActualpricerks['SUMACTUALPRICE'], 2) ?><label></td>
                                                                      <?php
                                                                      $pricerks = $pricerks+$result_sumActualpricerks['SUMACTUALPRICE'];
                                                                    }
                                                                  } else if ($result_seReporttransportsum['COMPANYCODE'] == 'RKR' || $result_seReporttransportsum['COMPANYCODE'] == 'RKL') {
                                                                    if ($result_seReporttransportsum['CUSTOMERCODE'] == 'SKB') {
                                                                      ?>
                                                                      <td ><label  style="width: 100px"><?= number_format($result_sumActualpriceskb['SUMACTUALPRICESKB'], 2) ?><label></td>
                                                                        <?php
                                                                        $priceskb = $result_sumActualpriceskb['SUMACTUALPRICESKB'];
                                                                      } else if ($result_seCus['CUSTOMERCODE'] == 'TTAST') {
                                                                        ?>
                                                                        <td ><label  style="width: 100px"><?= number_format($result_sumActualpricerkrttast['SUMACTUALPRICE'], 2) ?><label></td>
                                                                          <?php
                                                                        } else if ($result_seCus['CUSTOMERCODE'] == 'TGT') {
                                                                          ?>
                                                                          <td ><label  style="width: 100px"><?= number_format($result_sumActualpricerkrtgt['SUMACTUALPRICE'], 2) ?><label></td>
                                                                            <?php
                                                                          } else if ($result_seCus['CUSTOMERCODE'] == 'TTAT') {
                                                                            ?>
                                                                            <td ><label  style="width: 100px"><?= number_format($result_sumActualpricerkrttat['SUMACTUALPRICE'], 2) ?><label></td>
                                                                              <?php
                                                                            } else if ($result_seCus['CUSTOMERCODE'] == 'DAIKI') {
                                                                              ?>
                                                                              <td ><label  style="width: 100px"><?= number_format($result_sumActualpricerkrdaiki['SUMACTUALPRICE'], 2) ?><label></td>
                                                                                <?php
                                                                              } else if ($result_seCus['CUSTOMERCODE'] == 'TKT') {
                                                                                ?>
                                                                                <td ><label  style="width: 100px"><?= number_format($result_sumActualpricerkrtkt['SUMACTUALPRICE'], 2) ?><label></td>
                                                                                  <?php
                                                                                } else if ($result_seCus['CUSTOMERCODE'] == 'SUTT') {
                                                                                  ?>
                                                                                  <td ><label  style="width: 100px"><?= number_format($result_sumActualpricerkrsutt['SUMACTUALPRICE'], 2) ?><label></td>
                                                                                    <?php
                                                                                  } else if ($result_seCus['CUSTOMERCODE'] == 'NITTSUSHOJI') {
                                                                                    ?>
                                                                                    <td ><label  style="width: 100px"><?= number_format($result_sumActualpricerkrnitsu['SUMACTUALPRICE'], 2) ?><label></td>
                                                                                      <?php
                                                                                    } else if ($result_seCus['CUSTOMERCODE'] == 'TDEM') {
                                                                                      ?>
                                                                                      <td ><label  style="width: 100px"><?= number_format($result_sumActualpricerkrtdem['SUMACTUALPRICE'], 2) ?><label></td>
                                                                                        <?php
                                                                                      } else if ($result_seCus['CUSTOMERCODE'] == 'GMT') {
                                                                                        ?>
                                                                                        <td ><label  style="width: 100px"><?= number_format($result_sumActualpricerkrgmt['SUMACTUALPRICE'], 2) ?><label></td>
                                                                                          <?php
                                                                                        }else if ($result_seCus['CUSTOMERCODE'] == 'HINO') {
                                                                                          ?>
                                                                                          <td ><label  style="width: 100px"><?= number_format($result_sumActualpricerkrhino['SUMACTUALPRICE'], 2) ?><label></td>
                                                                                            <?php

                                                                                          }else if ($result_seCus['CUSTOMERCODE'] == 'TTTC') {
                                                                                            ?>
                                                                                            <td ><label  style="width: 100px"><?= number_format($result_sumActualpricerkrtttc['SUMACTUALPRICE'], 2) ?><label></td>
                                                                                              <?php

                                                                                            }else if ($result_seCus['CUSTOMERCODE'] == 'TSAT') {
                                                                                              ?>
                                                                                              <td ><label  style="width: 100px"><?= number_format($result_sumActualpricerkr['SUMACTUALPRICE'], 2) ?><label></td>
                                                                                                <?php
  
                                                                                              }  else { ////// ACTUALPRICE RKRRKl
                                                                                              $pricerkrrkl = $pricerkrrkl + $result_sumActualpricerkr['SUMACTUALPRICE'];

                                                                                              ?>
                                                                                              <td ><label  style="width: 100px"><?= number_format($result_sumActualpricerkr['SUMACTUALPRICE'], 2) ?><label></td>
                                                                                                <?php
                                                                                                $sumpricerkl = $pricerkrrkl + $result_sumActualpricerkrttast['SUMACTUALPRICE']
                                                                                                +$result_sumActualpricerkrtgt['SUMACTUALPRICE']+$result_sumActualpricerkrttat['SUMACTUALPRICE']+$result_sumActualpricerkrdaiki['SUMACTUALPRICE']
                                                                                                +$result_sumActualpricerkrtkt['SUMACTUALPRICE']+$result_sumActualpricerkrsutt['SUMACTUALPRICE']+$result_sumActualpricerkrnitsu['SUMACTUALPRICE']
                                                                                                +$result_sumActualpricerkrtdem['SUMACTUALPRICE']+$result_sumActualpricerkrgmt['SUMACTUALPRICE']+$result_sumActualpricerkrhino['SUMACTUALPRICE']
                                                                                                +$result_sumActualpricerkrtttc['SUMACTUALPRICE']+$result_sumActualpricerkrtsat['SUMACTUALPRICE'];

                                                                                                $sumpricerkr = $pricerkrrkl+$result_sumActualpricerkrttast['SUMACTUALPRICE']
                                                                                                +$result_sumActualpricerkrtgt['SUMACTUALPRICE']+$result_sumActualpricerkrttat['SUMACTUALPRICE']+$result_sumActualpricerkrdaiki['SUMACTUALPRICE']
                                                                                                +$result_sumActualpricerkrtkt['SUMACTUALPRICE']+$result_sumActualpricerkrsutt['SUMACTUALPRICE']+$result_sumActualpricerkrnitsu['SUMACTUALPRICE']
                                                                                                +$result_sumActualpricerkrtdem['SUMACTUALPRICE']+$result_sumActualpricerkrgmt['SUMACTUALPRICE']+$result_sumActualpricerkrhino['SUMACTUALPRICE']
                                                                                                +$result_sumActualpricerkrtttc['SUMACTUALPRICE']+$result_sumActualpricerkrtsat['SUMACTUALPRICE'];


                                                                                              }
                                                                                              ?>
                                                                                              <?php
                                                                                            } else {
                                                                                              ?>
                                                                                              <td ><label  style="width: 100px">-<label></td>
                                                                                                <?php
                                                                                              }
                                                                                              ?>
                                                                                              <!-- ///////////////////SUMPRICE FOR FOOTER//////////////////////////////////// -->
                                                                                              <?php

                                                                                              if ($result_seReporttransportsum['COMPANYCODE'] == 'RKS') {

                                                                                                $sum_actualpricesum = $pricerks+$result_sumActualpricestm['SUMPRICESTM']+$result_seDensoPriceSum['SUMDENSOPRICE'];

                                                                                                ?>

                                                                                                <?php
                                                                                              }else if ($_POST['companycode'] == 'RKR'){
                                                                                                $sum_actualpricesum = $sumpricerkr;
                                                                                                ?>

                                                                                                <?php
                                                                                              }else {
                                                                                                $sum_actualpricesum = $priceskb+$sumpricerkl;
                                                                                                ?>
                                                                                                <?php
                                                                                              }
                                                                                              ?>

                                                                                              <!-- ///////////////////////////////////////////////////////////////////////// -->

                                                                                              <!-- //////////////////////////////////DROP//////////////////////////////////// -->
                                                                                              <?php
                                                                                              if ($result_seReporttransportsum['COMPANYCODE'] == 'RKR' || $result_seReporttransportsum['COMPANYCODE'] == 'RKL') {
                                                                                                if ($result_seCus['CUSTOMERCODE'] == 'TTASTSTC') {
                                                                                                  ?>
                                                                                                  <td ><label  style="width: 100px"><?=$result_sumCrossprice['CROSSPRICE']?><label></td>

                                                                                                    <?php
                                                                                                  }else {
                                                                                                    ?>
                                                                                                    <td ><label  style="width: 100px"><label></td>
                                                                                                      <?php
                                                                                                    }
                                                                                                    ?>

                                                                                                    <?php
                                                                                                  }else {
                                                                                                    ?>
                                                                                                    <td ><label  style="width: 100px"><label></td>
                                                                                                      <?php
                                                                                                    }
                                                                                                    ?>
                                                                                                    <!-- ///////////////////////////////////////////////////////////// -->
                                                                                                    <!-- /////////////////////////FUEL(L)////////////////////////////////// -->
                                                                                                    <?php
                                                                                                    if ($result_seReporttransportsum['COMPANYCODE'] == 'RKS') {
                                                                                                      if ($result_seCus['CUSTOMERCODE'] == 'STM') {

                                                                                                        ?>
                                                                                                        <td ><label  style="width: 100px"><?= $result_seFuel['FUELLITSTM']?><label></td>

                                                                                                          <?php
                                                                                                        } else {
                                                                                                          ?>
                                                                                                          <td ><label  style="width: 100px"><?= number_format($result_sumO4['SUMO4'], 2) ?><label></td>
                                                                                                            <?php
                                                                                                          }
                                                                                                          ?>
                                                                                                          <?php
                                                                                                        } else {
                                                                                                          ?>
                                                                                                          <td ><label  style="width: 100px"><?= number_format($result_sumO4['SUMO4'], 2) ?><label></td>
                                                                                                            <?php

                                                                                                          }
                                                                                                          ?>

                                                                                                          <?php
                                                                                                          ///////////////////SUM O4 (น้ำมันลิตรที่เติม) FOR FOOTER////////////////

                                                                                                          if ($_POST['companycode'] == 'RKS') {
                                                                                                            $fuellit = $fuellit+$result_sumO4['SUMO4'];
                                                                                                            $sumfuellit = $fuellit+$result_seFuel['FUELLITSTM'];
                                                                                                          }else {
                                                                                                            $sumfuellit = $sumfuellit+$result_sumO4['SUMO4'];
                                                                                                          }

                                                                                                          ?>

                                                                                                          <!-- ///////////////////////////////////////////////////////////////////// -->

                                                                                                          <!-- /////////////////////////FUEL(Bth)////////////////////////////////// -->
                                                                                                          <?php
                                                                                                          if ($result_seReporttransportsum['COMPANYCODE'] == 'RKS') {
                                                                                                            if ($result_seCus['CUSTOMERCODE'] == 'STM') {
                                                                                                              ?>
                                                                                                              <td ><label  style="width: 100px"><?= $FUELBTHSTM ?><label></td>

                                                                                                                <?php
                                                                                                              } else {
                                                                                                                ?>
                                                                                                                <td ><label  style="width: 100px"><?= number_format(($result_seOilpricesum['PRICE'] * $result_sumO4['SUMO4']), 2) ?><label></td>
                                                                                                                  <?php
                                                                                                                }
                                                                                                                ?>
                                                                                                                <?php
                                                                                                              } else {
                                                                                                                ?>
                                                                                                                <td ><label  style="width: 100px"><?= number_format(($result_seOilpricesum['PRICE'] * $result_sumO4['SUMO4']), 2) ?><label></td>
                                                                                                                  <?php
                                                                                                                }
                                                                                                                ?>

                                                                                                                <?php
                                                                                                                //////////////////////SUM FUELBTH (จำนวนเงินค่าน้ำมัน)////////////////////////

                                                                                                                if ($_POST['companycode'] == 'RKS') {
                                                                                                                  $fuelbth = ($result_seOilpricesum['PRICE'] * $result_sumO4['SUMO4']);
                                                                                                                  $sumfuelbth = $fuelbth+$FUELBTHSTM;
                                                                                                                }else {
                                                                                                                  $fuelbth = $fuelbth + ($result_seOilpricesum['PRICE'] * $result_sumO4['SUMO4']);
                                                                                                                  $sumfuelbth = $fuelbth;
                                                                                                                }

                                                                                                                ?>
                                                                                                                <!-- ///////////////////////////////////////////////////////////////////// -->

                                                                                                                <!-- /////////////////////////TOLLFEE////////////////////////////////// -->
                                                                                                                <td ><label  style="width: 100px"><?= number_format($sum_expresswaysum, 2) ?><label></td>
                                                                                                                  <?php
                                                                                                                  //////////////////SUM TOLLFEE FOR FOOTER////////////////////
                                                                                                                  $sum_expressway = $sum_expressway+$sum_expresswaysum;

                                                                                                                  ?>


                                                                                                                  <!-- ///////////////////////////////////////////////////////////////////// -->

                                                                                                                  <!-- /////////////////////////WORKING INCENTIVE E1////////////////////////////////// -->
                                                                                                                  <?php
                                                                                                                  if ($result_seReporttransportsum['COMPANYCODE'] == 'RKS') {
                                                                                                                    if ($result_seCus['CUSTOMERCODE'] == 'STM') {
                                                                                                                      ?>
                                                                                                                      <td ><label  style="width: 100px"><?= number_format($result_seWorkincenstm['SUMWORKINCENSTM'], 2) ?><label></td>

                                                                                                                        <?php
                                                                                                                      } else {
                                                                                                                        ?>
                                                                                                                        <td ><label  style="width: 100px"><?= number_format($result_sumE1['SUME1'], 2) ?><label></td>
                                                                                                                          <?php
                                                                                                                        }
                                                                                                                        ?>
                                                                                                                    <?php
                                                                                                                  } else if($result_seReporttransportsum['COMPANYCODE'] == 'RKL' && $result_seReporttransportsum['CUSTOMERCODE'] == 'SKB') {
                                                                                                                    ?>
                                                                                                                      <td ><label  style="width: 100px"><?= number_format($result_sumE1['SUME1'], 2) ?><label></td>
                                                                                                                    <?php
                                                                                                                  } else {
                                                                                                                    ?>
                                                                                                                      <td ><label  style="width: 100px"><?= number_format($result_sumE1['SUME1'], 2) ?><label></td>
                                                                                                                    <?php
                                                                                                                  }
                                                                                                                  ?>

                                                                                                                        <!-- ///////////////////////////////////////////////////////////////////// -->
                                                                                                                        <?php
                                                                                                                        ///////////////////SUM WORKING INCENTIVE  FOR FOOTER////////////////

                                                                                                                        if ($_POST['companycode'] == 'RKS') {
                                                                                                                          $working = $working+$result_sumE1['SUME1'];

                                                                                                                          $sumworking = $working;
                                                                                                                        }else {

                                                                                                                          $sumworking = $sumworking+$result_sumE1['SUME1'];
                                                                                                                        }

                                                                                                                        ?>

                                                                                                                        <!-- ///////////////////////////////////////////////////////////////////// -->


                                                                                                                        <!-- /////////////////////////FUEL INCENTIVE////////////////////////////////// -->
                                                                                                                        <?php
                                                                                                                        if ($result_seReporttransportsum['COMPANYCODE'] == 'RKS' && $result_seCus['CUSTOMERCODE'] == 'STM') {
                                                                                                                          if ($result_seReporttransportsum['O4'] == '' || $result_seReporttransportsum['O4'] == '0') {
                                                                                                                            ?>
                                                                                                                            <td ><label  style="width: 200px">0.00</label></td><!--FUEL INCENTIVE STM -->
                                                                                                                            <?php
                                                                                                                          } else {
                                                                                                                            ?>
                                                                                                                            <td ><label  style="width: 100px"><?= number_format($result_sumFuel['FUELINCEN'], 2) ?><label></td><!--FUEL INCENTIVE  OTHER-->
                                                                                                                              <?php
                                                                                                                            }
                                                                                                                            ?>

                                                                                                                            <?php
                                                                                                                          } else {
                                                                                                                            ?>
                                                                                                                            <td ><label  style="width: 100px"><?= number_format($result_sumFuel['FUELINCEN'], 2) ?><label></td><!--FUEL INCENTIVE  RKR RKL-->
                                                                                                                              <?php
                                                                                                                            }
                                                                                                                            ?>

                                                                                                                            <!-- ///////////////////////////////////////////////////////////////////// -->

                                                                                                                            <?php
                                                                                                                            ///////////////////SUM FUEL INCENTIVE  FOR FOOTER////////////////

                                                                                                                            if ($_POST['companycode'] == 'RKS') {
                                                                                                                              $fuelincen = $fuelincen+$result_sumFuel['FUELINCEN'];


                                                                                                                            }else {

                                                                                                                              $fuelincen = $fuelincen+$result_sumFuel['FUELINCEN'];
                                                                                                                            }

                                                                                                                            ?>

                                                                                                                            <!-- ///////////////////////////////////////////////////////////////////// -->


                                                                                                                            <!-- /////////////////////////REPAIR////////////////////////////////// -->
                                                                                                                            <td ><label  style="width: 100px"><?= number_format($sum_repairsum, 2) ?><label></td>
                                                                                                                              <!-- ///////////////////////////////////////////////////////////////////// -->

                                                                                                                              <!-- /////////////////////////TOTAL////////////////////////////////// -->
                                                                                                                              <td ><label  style="width: 100px"><?= number_format($TOTALSUM, 2) ?><label></td>
                                                                                                                                <!-- ///////////////////////////////////////////////////////////////////// -->

                                                                                                                                <!-- /////////////////////////DEP////////////////////////////////// -->

                                                                                                                                <td ><label  style="width: 100px">-<label></td>


                                                                                                                                  <!-- ///////////////////////////////////////////////////////////////////// -->

                                                                                                                                  <!-- /////////////////////////EVA SUM////////////////////////////////// -->
                                                                                                                                  <td ><label  style="width: 100px"><?= $EVASUM ?><label></td>
                                                                                                                                    <!-- ///////////////////////////////////////////////////////////////////// -->

                                                                                                                                    <!-- /////////////////////////PROFIT%////////////////////////////////// -->
                                                                                                                                    <td ><label  style="width: 100px"><?= number_format($PROFITSUM, 2) . '%' ?><label></td>
                                                                                                                                      <!-- ///////////////////////////////////////////////////////////////////// -->
                                                                                                                                    </tr>
                                                                                                                                    <?php
                                                                                                                                    $isum++;
                                                                                                                                  }
                                                                                                                                  ?>

                                                                                                                                </tbody>
                                                                                                                                <!-- ///////////////////FOOTER/////////////////////////////////////////////////// -->
                                                                                                                                <tfoot>
                                                                                                                                  <tr>
                                                                                                                                    <td colspan="2"></td>
                                                                                                                                    <!-- SUM TRIP AMOUNT-->
                                                                                                                                    <td ><label  style="width: 200px;background-color: #2fbc50"><u><?= number_format($sum_tripamountsum,2) ?></u></label></</td> <!-- จำนวนรอบ TRIPAMOUNT-->
                                                                                                                                    <!-- SUM WEIGHTINTON-->
                                                                                                                                    <td ><label  style="width: 200px;background-color: #2fbc50"><u><?= number_format($sum_weightinsum,2) ?></u></label></td> <!-- ผลรวมน้ำหนัก  WEIGHTINTON-->
                                                                                                                                    <!-- SUM SALE PRICE-->
                                                                                                                                    <td ><label  style="width: 200px;background-color: #2fbc50"><u><?= number_format($sum_actualpricesum,2) ?></u></label></td> <!-- SALE PRICE ของ RKS-->
                                                                                                                                    <!-- DROP-->
                                                                                                                                    <td ><label  style="width: 200px;background-color: #2fbc50"><u><?= number_format($result_sumCrossprice['CROSSPRICE'],2) ?></u></label></td> <!-- ค่า DROP  ของ RKR,RKL-->
                                                                                                                                    <!-- ผลรวมน้ำมันที่เติม  FUEL(L)-->
                                                                                                                                    <td ><label  style="width: 200px;background-color: #2fbc50"><u><?=number_format($sumfuellit,2)?></u></label></td><!-- ผลรวมน้ำมันที่เติม  FUEL(L)-->
                                                                                                                                    <!-- ผลรวมราคาน้ำมัน  FUEL(Bth)-->
                                                                                                                                    <td ><label  style="width: 200px;background-color: #2fbc50"><u><?= number_format($sumfuelbth,2) ?></u></label></td><!-- ผลรวมราคาน้ำมัน  FUEL(Bth)-->
                                                                                                                                    <!-- ผลรวมค่าทางด่วน-->
                                                                                                                                    <td ><label  style="width: 200px;background-color: #2fbc50"><u><?= number_format($sum_expressway,2) ?></u></label></td>
                                                                                                                                    <!-- SUM WORKING INCENTIVE -->
                                                                                                                                    <td ><label  style="width: 200px;background-color: #2fbc50"><u><?= number_format($sumworking,2) ?></u></label></td> <!-- SUM WORKING INCENTIVE -->
                                                                                                                                    <!--  SUM FUEL INCENTIVE -->
                                                                                                                                    <td ><label  style="width: 200px;background-color: #2fbc50"><u><?=number_format($fuelincen,2)?></u></label></td>  <!--  SUM FUEL INCENTIVE -->
                                                                                                                                    <!-- SUM REPAIR -->
                                                                                                                                    <td ><label  style="width: 200px;background-color: #2fbc50"><u><?= number_format($sum_repairsum,2) ?></u></label></td> <!-- SUM REPAIR -->
                                                                                                                                    <!-- SUM TOTAL -->
                                                                                                                                    <td ><label  style="width: 200px;background-color: #2fbc50"><u><?= number_format($TOTALSUMALL,2) ?></u></label></td> <!-- SUM TOTAL -->
                                                                                                                                    <!-- ///////////////////////////////////////////////////////////////-->
                                                                                                                                    <td ><label  style="width: 200px;background-color: #2fbc50">-</label></td> <!-- SUM DEP -->

                                                                                                                                    <!-- ///////////////EVASUM ALL///////////////////////////////////////// -->
                                                                                                                                    <?php
                                                                                                                                    if ($_POST['companycode'] == 'RKS') {
                                                                                                                                      $EVASUMALL   = ($TOTALSUMALL < $sum_actualpricesum) ? OK : NG;
                                                                                                                                      ?>
                                                                                                                                      <?php
                                                                                                                                    }else {
                                                                                                                                      $EVASUMALL   = ($TOTALSUMALL < $sum_actualpricesum) ? OK : NG;
                                                                                                                                      ?>
                                                                                                                                      <?php
                                                                                                                                    }
                                                                                                                                    ?>
                                                                                                                                    <td ><label  style="width: 200px;background-color: #2fbc50"><?=$EVASUMALL?></label></td> <!-- SUM EVA-->
                                                                                                                                    <!-- ////////////////////////////////////////////////////////// -->

                                                                                                                                    <!-- ///////////////////////PROFITSUM ALL//////////////////////////////////// -->
                                                                                                                                    <?php
                                                                                                                                    if ($_POST['companycode'] == 'RKS') {
                                                                                                                                      $PROFITSUMALL   = (($sum_actualpricesum-$TOTALSUMALL)*100)/($sum_actualpricesum);
                                                                                                                                      ?>
                                                                                                                                      <?php
                                                                                                                                    }else {
                                                                                                                                      $PROFITSUMALL   = (($sum_actualpricesum-$TOTALSUMALL)*100)/($sum_actualpricesum);
                                                                                                                                      ?>
                                                                                                                                      <?php
                                                                                                                                    }
                                                                                                                                    ?>
                                                                                                                                    <td ><label  style="width: 200px;background-color: #2fbc50"><?=number_format($PROFITSUMALL,2). '%'?></label></td> <!-- SUM PROFIT%-->
                                                                                                                                    <!-- //////////////////////////////////////////////////////////////// -->
                                                                                                                                  </tr>
                                                                                                                                </tfoot>
                                                                                                                              </table>
                                                                                                                              <?php
                                                                                                                            }
                                                                                                                            if ($_POST['txt_flg'] == "select_reportdailybudgetsummarypallet") {
                                                                                                                              ?>
                                                                                                                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-examplesummary" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                                                                                <thead>
                                                                                                                                  <tr>
                                                                                                                                    <th >COMPANY</th>
                                                                                                                                    <th >CUSTOMER</th>
                                                                                                                                    <th >AMOUNT</th>
                                                                                                                                    <th >SALEPRICE</th>
                                                                                                                                  </tr>
                                                                                                                                </thead>
                                                                                                                                <tbody>
                                                      
                                                                                                                                  <?php
                                                                                                                                  $SUMAMOUNTPALLET = '';
                                                                                                                                  $company = ($_POST['companycode'] != "") ? " AND a.COMPANYCODE = '" . $_POST['companycode'] . "'" : "";
                                                                                                                                  $condiReporttransport1 = $sql_seCus = "SELECT DISTINCT CUSTOMERCODE FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE COMPANYCODE = '" . $_POST['companycode'] . "'";
                                                      
                                                                                                                                  $query_seCus = sqlsrv_query($conn, $sql_seCus, $params_seCus);
                                                                                                                                  while ($result_seCus = sqlsrv_fetch_array($query_seCus, SQLSRV_FETCH_ASSOC)) {
                                                      
                                                      
                                                                                                                                    $condiReporttransport1sum = " AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)";
                                                                                                                                    $condiReporttransport2sum = " AND a.COMPANYCODE = '" . $_POST['companycode'] . "' AND a.CUSTOMERCODE = '" . $result_seCus['CUSTOMERCODE'] . "'";
                                                                                                                                    $condiReporttransport3sum = " AND a.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''";
                                                                                                                                    $sql_seReporttransportsum = "{call megVehicletransportplan_v2(?,?,?,?)}";
                                                                                                                                    $params_seReporttransportsum = array(
                                                                                                                                    array('select_reportdailybudget', SQLSRV_PARAM_IN),
                                                                                                                                    array($condiReporttransport1sum, SQLSRV_PARAM_IN),
                                                                                                                                    array($condiReporttransport2sum, SQLSRV_PARAM_IN),
                                                                                                                                    array($condiReporttransport3sum, SQLSRV_PARAM_IN)
                                                                                                                                    );
                                                                                                                                    $query_seReporttransportsum = sqlsrv_query($conn, $sql_seReporttransportsum, $params_seReporttransportsum);
                                                                                                                                    $result_seReporttransportsum = sqlsrv_fetch_array($query_seReporttransportsum, SQLSRV_FETCH_ASSOC);
                                                      
                                                                                                                                    /////////////////////////SUM AMOUNT/////////////////////////////////////////////////////
                                                                                                                                    $sql_seAmountSum = "SELECT  SUM(CONVERT(INT,TRIPAMOUNT_PALLET))    AS 'SUMAMOUNT'
                                                                                                                                    FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                                                                                                                                    INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
                                                                                                                                    WHERE 1 = 1
                                                                                                                                    AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103)
                                                                                                                                    AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)
                                                                                                                                    AND a.COMPANYCODE = '" . $_POST['companycode'] . "' AND a.CUSTOMERCODE = '" . $result_seCus['CUSTOMERCODE'] . "'
                                                                                                                                    AND b.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ'
                                                                                                                                    AND a.DOCUMENTCODE_PALLET IS NOT NULL AND a.DOCUMENTCODE_PALLET != ''";
                                                                                                                                    $params_seAmountSum = array();
                                                                                                                                    $query_seAmountSum = sqlsrv_query($conn, $sql_seAmountSum, $params_seAmountSum);
                                                                                                                                    $result_seAmountSum = sqlsrv_fetch_array($query_seAmountSum, SQLSRV_FETCH_ASSOC);
                                                      
                                                                                                                                    $ACTUALPRICE = $result_seAmountSum['SUMAMOUNT']*10;
                                                      
                                                                                                                                    ?>
                                                                                                                                    <tr>
                                                                                                                                      <td style="text-align: center"><label  style="width: 100px"><?= $_POST['companycode'] ?><label></td>
                                                                                                                                        <td><label  style="width: 100px"><a href="#" onclick="report_dailybudgetdetailpallet('<?= $result_seCus['CUSTOMERCODE'] ?>')"><?= $result_seCus['CUSTOMERCODE'] ?><label></a></td>
                                                                                                                                          <td style="text-align: left"><label  style="width: 100px"><?=($result_seAmountSum['SUMAMOUNT'] == '' ? '-':$result_seAmountSum['SUMAMOUNT'])?><label></td>
                                                                                                                                            <td style="text-align: left"><label  style="width: 100px"><?=$ACTUALPRICE?><label></td>
                                                                                                                                            </tr>
                                                                                                                                            <?php
                                                                                                                                            $isum++;
                                                                                                                                            $SUMAMOUNT = $SUMAMOUNT + $result_seAmountSum['SUMAMOUNT'];
                                                                                                                                            $SUMPRICE = $SUMPRICE+$ACTUALPRICE;
                                                                                                                                          }
                                                      
                                                                                                                                          ?>
                                                                                                                                        </tbody>
                                                                                                                                        <!-- ///////////////////FOOTER/////////////////////////////////////////////////// -->
                                                                                                                                        <tfoot>
                                                                                                                                          <tr>
                                                                                                                                            <!-- COMPANY-->
                                                                                                                                            <td ></td>
                                                                                                                                            <!-- CUSTOMER-->
                                                                                                                                            <td ></td>
                                                                                                                                            <!-- AMOUNT-->
                                                                                                                                            <td ><label  style="width: 200px;background-color: #2fbc50"><u><?= number_format($SUMAMOUNT,2) ?></u></label></td> <!-- SALE PRICE ของ RKS-->
                                                                                                                                            <!-- SALEPRICE-->
                                                                                                                                            <td ><label  style="width: 200px;background-color: #2fbc50"><u><?=number_format($SUMPRICE,2)?></u></label></td><!-- ผลรวมน้ำมันที่เติม  FUEL(L)-->
                                                      
                                                                                                                                          </tr>
                                                                                                                                        </tfoot>
                                                                                                                                      </table>
                                                      
                                                                                                                                      <?php
                                                                                                                                     
                                                                                                                                    }
                                                                                                                            ?>
<?php
sqlsrv_close($conn);
?>
