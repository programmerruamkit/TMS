<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");

if ($_POST['txt_flg'] == "select_vehicletransportprice") {
    ?>
    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer" >
      <table  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example" >
        <?php
        if ($_POST['companycode'] == 'RCC' || $_POST['companycode'] == 'RATC') {
          ?>
          <thead >
            <?php
            if ($_POST['worktype'] == 'sh') {
              ?>
              <tr>
                <th rowspan="2"  title="ID" style="text-align: center;width: 100px">ID</th>
                <th rowspan="2"  title="จัดการ" style="text-align: center;width: 100px">จัดการ</th>
                <th rowspan="2"  title="VEHICLEDESCCODE" style="text-align: center;width: 200px">VEHICLEDESCCODE</th>
                <th rowspan="2"  title="COMPANYCODE" style="text-align: center;width: 200px">COMPANYCODE</th>
                <th rowspan="2"  title="CUSTOMERCODE" style="text-align: center;width: 200px">CUSTOMERCODE</th>
                <th rowspan="2"  title="REGION" style="text-align: center;width: 200px">REGION</th>
                <th rowspan="2"  title="TO" style="text-align: center;width: 200px">TO</th>
                <th colspan="2" style="text-align: center;width: 100px">&nbsp;</th>
                <th colspan="2" style="text-align: center;width: 100px">LC</th>
                <th rowspan="2"  title="E1" style="text-align: center;width: 200px">E1</th>
                <th rowspan="2"  title="E2" style="text-align: center;width: 200px">E2</th>
                <th rowspan="2"  title="PRICE" style="text-align: center;width: 200px">PRICE</th>
                <th rowspan="2"  title="ไตรมาส" style="text-align: center;width: 200px">ไตรมาส</th>
                <th rowspan="2"  title="STARTDATE" style="text-align: center;width: 200px">STARTDATE</th>
                <th rowspan="2"  title="ENDDATE" style="text-align: center;width: 200px">ENDDATE</th>
                <th rowspan="2"  title="ACTIVESTATUS" style="text-align: center;width: 200px">ACTIVESTATUS</th>
                <th rowspan="2"  title="REMARK" style="text-align: center;width: 200px">REMARK</th>
                <th rowspan="2"  title="CREATEBY" style="text-align: center;width: 200px">CREATEBY</th>
                <th rowspan="2"  title="CREATEDATE" style="text-align: center;width: 200px">CREATEDATE</th>
                <th rowspan="2"  title="MODIFIEDBY" style="text-align: center;width: 200px">MODIFIEDBY</th>
                <th rowspan="2"  title="MODIFIEDDATE" style="text-align: center;width: 200px">MODIFIEDDATE</th>
                <tr>
                  <th title="SRBASE4L" style="text-align: center;width: 200px">BASE4L</th>
                  <th title="SRBASE8L" style="text-align: center;width: 200px">BASE8L</th>
                  <th title="LOCATIONBASE4L" style="text-align: center;width: 200px">LOCATIONBASE4L</th>
                  <th title="LOCATIONBASE8L" style="text-align: center;width: 200px">LOCATIONBASE8L</th>
                </tr>
              </tr>
              <?php
            } else {
              ?>
              <tr>
                <th rowspan="2" title="ID" style="text-align: center;width: 100px">ID6</th>
                <th rowspan="2" title="จัดการ" style="text-align: center;width: 100px">จัดการ</th>
                <th rowspan="2" title="VEHICLEDESCCODE" style="text-align: center;width: 200px">VEHICLEDESCCODE</th>
                <th rowspan="2" title="COMPANYCODE" style="text-align: center;width: 200px">COMPANYCODE</th>
                <th rowspan="2" title="CUSTOMERCODE" style="text-align: center;width: 200px">CUSTOMERCODE</th>
                <th rowspan="2" title="REGION" style="text-align: center;width: 200px">REGION</th>
                <th rowspan="2" title="CLUSTER" style="text-align: center;width: 200px">CLUSTER</th>
                <th rowspan="2" title="CLUSTER_TH" style="text-align: center;width: 200px">CLUSTER_TH</th>
                <!--<th rowspan="2" title="DEALERCODE" style="text-align: center;width: 200px">DEALERCODE</th>-->
                <th rowspan="2" title="BEGINJOB" style="text-align: center;width: 200px">BEGINJOB</th>
                <th rowspan="2" title="NAME" style="text-align: center;width: 200px">NAME</th>
                <!--<th colspan="2" style="text-align: center;width: 100px">&nbsp;</th>-->
                <th colspan="2" style="text-align: center;width: 100px">SR </th>
                <th colspan="2" style="text-align: center;width: 100px">GW</th>
                <th colspan="4" style="text-align: center;width: 100px">BP</th>
                <th colspan="2" style="text-align: center;width: 100px">SP</th>
                <th colspan="2" style="text-align: center;width: 100px">TAC</th>
                <th colspan="2" style="text-align: center;width: 100px">OTH</th>
                <th rowspan="2" title="E1" style="text-align: center;width: 200px">E1</th>
                <th rowspan="2" title="E1" style="text-align: center;width: 200px">E2</th>
                <th rowspan="2" title="PRICE" style="text-align: center;width: 200px">PRICE</th>
                <th rowspan="2" title="ไตรมาส" style="text-align: center;width: 200px">ไตรมาส</th>
                <th rowspan="2" title="STARTDATE" style="text-align: center;width: 200px">STARTDATE</th>
                <th rowspan="2" title="ENDDATE" style="text-align: center;width: 200px">ENDDATE</th>
                <th rowspan="2" title="ACTIVESTATUS" style="text-align: center;width: 200px">ACTIVESTATUS</th>
                <th rowspan="2" title="REMARK" style="text-align: center;width: 200px">REMARK</th>
                <th rowspan="2" title="CREATEBY" style="text-align: center;width: 200px">CREATEBY</th>
                <th rowspan="2" title="CREATEDATE" style="text-align: center;width: 200px">CREATEDATE</th>
                <th rowspan="2" title="MODIFIEDBY" style="text-align: center;width: 200px">MODIFIEDBY</th>
                <th rowspan="2" title="MODIFIEDDATE" style="text-align: center;width: 200px">MODIFIEDDATE</th>
                  <tr>
                    <!--<th title="BASE4L" style="text-align: center;width: 200px">BASE4L</th>
                    <th title="BASE8L" style="text-align: center;width: 200px">BASE8L</th>-->
                    <th title="SRBASE4L" style="text-align: center;width: 200px">SRBASE4L</th>
                    <th title="SRBASE8L" style="text-align: center;width: 200px">SRBASE8L</th>
                    <th title="GWBASE4L" style="text-align: center;width: 200px">GWBASE4L</th>
                    <th title="GWBASE8L" style="text-align: center;width: 200px">GWBASE8L</th>
                    <th title="BPBASE4L" style="text-align: center;width: 200px">BPBASE4L</th>
                    <th title="BPBASE8L" style="text-align: center;width: 200px">BPBASE8L</th>
                    <th title="BPBASE4L" style="text-align: center;width: 200px">BP25BASE4L</th>
                    <th title="BPBASE8L" style="text-align: center;width: 200px">BP25BASE8L</th>
                    <th title="BPBASE4L" style="text-align: center;width: 200px">SPBASE4L</th>
                    <th title="BPBASE8L" style="text-align: center;width: 200px">SPBASE8L</th>
                    <th title="TACBASE4L" style="text-align: center;width: 200px">TACBASE4L</th>
                    <th title="TACBASE8L" style="text-align: center;width: 200px">TACBASE8L</th>
                    <th title="OTHBASE4L" style="text-align: center;width: 200px">OTHBASE4L</th>
                    <th title="OTHBASE8L" style="text-align: center;width: 200px">OTHBASE8L</th>
                  </tr>
              </tr>
                <?php
              }
              ?>
            </thead>
            <?php
          } else {
            if ($_POST['companycode'] == 'RKL' && $_POST['customercode'] == 'SKB') {
              ?>
              <thead >
                <tr>
                  <th title="ID" style="text-align: center;width: 100px">ID</th>
                  <th title="VEHICLETYPE" style="text-align: center;width: 200px">VEHICLETYPE</th>
                  <th title="BILLING1" style="text-align: center;width: 200px">BILLING1</th>
                  <th title="BILLING2" style="text-align: center;width: 200px">BILLING2</th>
                  <th title="ZONE" style="text-align: center;width: 200px">ZONE</th>
                  <th title="LOCATION" style="text-align: center;width: 200px">LOCATION</th>
                  <th title="E1" style="text-align: center;width: 200px">E1</th>
                  <th title="E2" style="text-align: center;width: 200px">E2</th>
                  <th title="MONTHST" style="text-align: center;width: 200px">ไตรมาส</th>
                  <th title="STARTDATE" style="text-align: center;width: 200px">STARTDATE</th>
                  <th title="ENDDATE" style="text-align: center;width: 200px">ENDDATE</th>
                  <th title="จัดการ" style="text-align: center;width: 100px">จัดการ</th>
                </tr>
              </thead>
              <?php
            } else {
              ?>
              <thead >
                <tr>
                  <th title="ID" style="text-align: center;width: 100px">ID</th>
                  <th title="จัดการ" style="text-align: center;width: 100px">จัดการ</th>
                  <th title="VEHICLEDESCCODE" style="text-align: center;width: 200px">VEHICLEDESCCODE</th>
                  <th title="COMPANYCODE" style="text-align: center;width: 200px">COMPANYCODE</th>
                  <th title="CUSTOMERCODE" style="text-align: center;width: 200px">CUSTOMERCODE</th>
                  <th title="REGION" style="text-align: center;width: 200px">REGION</th>
                  <?php
                  if ($_POST['companycode'] == 'RRC') {
                    if ($_POST['customercode'] == 'GMT-IB'|| $_POST['customercode'] == 'GMT' || $_POST['customercode'] == 'TTTC' 
                    || $_POST['customercode'] == 'TTAST'  || $_POST['customercode'] == 'BP'  || $_POST['customercode'] == 'HDK'
                    || $_POST['customercode'] == 'THAIDAISEN') {
                      ?>
                      <th title="VEHICLETYPE" style="text-align: center;width: 200px">VEHICLETYPE</th>
                      <?php
                    }
                  }
                  if ($_POST['companycode'] == 'RKS') {
                    if ($_POST['customercode'] == 'DAIKI'      || $_POST['customercode'] == 'TAW' || $_POST['customercode'] == 'STM' 
                    || $_POST['customercode'] == 'DENSO-THAI'  || $_POST['customercode'] == 'GMT' || $_POST['customercode'] == 'TTAT' 
                    || $_POST['customercode'] == 'TMT'         || $_POST['customercode'] == 'TGT' || $_POST['customercode'] == 'TKT' 
                    || $_POST['customercode'] == 'TDEM'        || $_POST['customercode'] == 'HINO'|| $_POST['customercode'] == 'TTTC' 
                    || $_POST['customercode'] == 'NITTSUSHOJI' || $_POST['customercode'] == 'SWN' || $_POST['customercode'] == 'THAITOHKEN'
                    || $_POST['customercode'] == 'COPPERCORD'  || $_POST['customercode'] == 'TSAT') {
                      ?>
                      <th title="VEHICLETYPE" style="text-align: center;width: 200px">VEHICLETYPE</th>
                      <?php
                    }
                  }

                  if ($_POST['companycode'] == 'RKR') {
                    if ($_POST['customercode'] == 'TID'     || $_POST['customercode'] == 'DAIKI'   || $_POST['customercode'] == 'TTTC'    
                    || $_POST['customercode'] == 'TTPRO'    || $_POST['customercode'] == 'TTAST'   || $_POST['customercode'] == 'TTAT' 
                    || $_POST['customercode'] == 'TGT'      || $_POST['customercode'] == 'SUTT'    || $_POST['customercode'] == 'HINO' 
                    || $_POST['customercode'] == 'ACSE'     || $_POST['customercode'] == 'PARAGON' || $_POST['customercode'] == 'TKT'     
                    || $_POST['customercode'] == 'TTASTSTC' || $_POST['customercode'] == 'TTASTCS' || $_POST['customercode'] == 'TTPROSTC' 
                    || $_POST['customercode'] == 'TTPROSTC' || $_POST['customercode'] == 'TTTCSTC' || $_POST['customercode'] == 'TDEM'        
                    || $_POST['customercode'] == 'YNP'      || $_POST['customercode'] == 'PARAGON' || $_POST['customercode'] == 'NITTSUSHOJI' 
                    || $_POST['customercode'] == 'TSPT'     || $_POST['customercode'] == 'GMT'     || $_POST['customercode'] == 'TMT' 
                    || $_POST['customercode'] == 'CH-AUTO'  || $_POST['customercode'] == 'RNSTEEL' || $_POST['customercode'] == 'PJW'
                    || $_POST['customercode'] == 'TSAT') {
                      ?>
                      <th title="VEHICLETYPE" style="text-align: center;width: 200px">VEHICLETYPE</th>
                      <?php
                    }
                  }
                  if ($_POST['companycode'] == 'RKL') {
                    if ($_POST['customercode'] == 'TID'       || $_POST['customercode'] == 'DAIKI'   || $_POST['customercode'] == 'TTTC' 
                    || $_POST['customercode'] == 'AMT'        || $_POST['customercode'] == 'TTPRO'   || $_POST['customercode'] == 'TTAST' 
                    || $_POST['customercode'] == 'SUTT'       || $_POST['customercode'] == 'HINO'    || $_POST['customercode'] == 'SKB'  
                    || $_POST['customercode'] == 'TTASTSTC'   || $_POST['customercode'] == 'TTASTCS' || $_POST['customercode'] == 'TTPROSTC' 
                    || $_POST['customercode'] == 'TTPROSTC'   || $_POST['customercode'] == 'ACSE'    || $_POST['customercode'] == 'TKT' 
                    || $_POST['customercode'] == 'GMT'        || $_POST['customercode'] == 'TDEM'    || $_POST['customercode'] == 'TTAT' 
                    || $_POST['customercode'] == 'TSAT'       || $_POST['customercode'] == 'TSPT'    || $_POST['customercode'] == 'WSBT' 
                    || $_POST['customercode'] == 'YNP'        || $_POST['customercode'] == 'PARAGON' || $_POST['customercode'] == 'NITTSUSHOJI' 
                    || $_POST['customercode'] == 'CH-AUTO'    || $_POST['customercode'] == 'TTTCSTC' || $_POST['customercode'] == 'OLT' 
                    || $_POST['customercode'] == 'COPPERCORD' || $_POST['customercode'] == 'RNSTEEL' || $_POST['customercode'] == 'VUTEQ'
                    || $_POST['customercode'] == 'PJW') {
                      ?>
                      <th title="VEHICLETYPE" style="text-align: center;width: 200px">VEHICLETYPE</th>
                      <?php
                    }
                  }
                  if ($_POST['companycode'] == 'RCC' || $_POST['companycode'] == 'RATC') {
                    if ($_POST['customercode'] == 'TTT') {
                      if ($_POST['worktype'] == 'sh') {
                        ?>
                        <th title="FROM" style="text-align: center;width: 200px">FROM</th>
                        <?php
                      }
                    }
                  }
                  if ($_POST['companycode'] == 'RRC') {
                    if ($_POST['customercode'] == 'GMT-IB' || $_POST['customercode'] == 'GMT' || $_POST['customercode'] == 'TTTC' 
                    || $_POST['customercode'] == 'TTAST'   || $_POST['customercode'] == 'BP'  || $_POST['customercode'] == 'HDK'
                    || $_POST['customercode'] == 'THAIDAISEN') {
                      ?>
                      <th title="FROM" style="text-align: center;width: 200px">FROM</th>
                      <?php
                    }
                  }
                  if ($_POST['companycode'] == 'RKS') {
                    if ($_POST['customercode'] == 'DAIKI' || $_POST['customercode'] == 'TAW'        || $_POST['customercode'] == 'STM' 
                    || $_POST['customercode'] == 'GMT'    || $_POST['customercode'] == 'TTAT'       || $_POST['customercode'] == 'TMT' 
                    || $_POST['customercode'] == 'TGT'    || $_POST['customercode'] == 'TKT'        || $_POST['customercode'] == 'TDEM' 
                    || $_POST['customercode'] == 'HINO'   || $_POST['customercode'] == 'TTTC'       || $_POST['customercode'] == 'NITTSUSHOJI'
                    || $_POST['customercode'] == 'SWN'    || $_POST['customercode'] == 'THAITOHKEN' || $_POST['customercode'] == 'COPPERCORD'
                    || $_POST['customercode'] == 'TSAT') {
                      ?>
                      <th title="FROM" style="text-align: center;width: 200px">FROM</th>
                      <?php
                    }
                  }
                  if ($_POST['companycode'] == 'RKR') {
                    if ($_POST['customercode'] == 'TID'     || $_POST['customercode'] == 'DAIKI'   || $_POST['customercode'] == 'TTTC' 
                    || $_POST['customercode'] == 'TTPRO'    || $_POST['customercode'] == 'TTAST'   || $_POST['customercode'] == 'TTAT' 
                    || $_POST['customercode'] == 'TGT'      || $_POST['customercode'] == 'SUTT'    || $_POST['customercode'] == 'HINO' 
                    || $_POST['customercode'] == 'ACSE'     || $_POST['customercode'] == 'PARAGON' || $_POST['customercode'] == 'TKT' 
                    || $_POST['customercode'] == 'TTASTSTC' || $_POST['customercode'] == 'TTASTCS' || $_POST['customercode'] == 'TTPROSTC' 
                    || $_POST['customercode'] == 'TTPROSTC' || $_POST['customercode'] == 'TTTCSTC' || $_POST['customercode'] == 'TDEM' 
                    || $_POST['customercode'] == 'YNP'      || $_POST['customercode'] == 'PARAGON' || $_POST['customercode'] == 'NITTSUSHOJI' 
                    || $_POST['customercode'] == 'TSPT'     || $_POST['customercode'] == 'GMT'     || $_POST['customercode'] == 'TMT'
                    || $_POST['customercode'] == 'CH-AUTO'  || $_POST['customercode'] == 'RNSTEEL' || $_POST['customercode'] == 'PJW'
                    || $_POST['customercode'] == 'TSAT') {
                      ?>
                      <th title="FROM" style="text-align: center;width: 200px">FROM</th>
                      <?php
                    }
                  }
                  if ($_POST['companycode'] == 'RKL') {
                    if ($_POST['customercode'] == 'TID'       || $_POST['customercode'] == 'DAIKI'   || $_POST['customercode'] == 'TTTC' 
                    || $_POST['customercode'] == 'AMT'        || $_POST['customercode'] == 'TTPRO'   || $_POST['customercode'] == 'TTAST' 
                    || $_POST['customercode'] == 'SUTT'       || $_POST['customercode'] == 'HINO'    || $_POST['customercode'] == 'SKB' 
                    || $_POST['customercode'] == 'TTASTSTC'   || $_POST['customercode'] == 'TTASTCS' || $_POST['customercode'] == 'TTPROSTC' 
                    || $_POST['customercode'] == 'TTPROSTC'   || $_POST['customercode'] == 'ACSE'    || $_POST['customercode'] == 'TKT' 
                    || $_POST['customercode'] == 'GMT'        || $_POST['customercode'] == 'TDEM'    || $_POST['customercode'] == 'TTAT' 
                    || $_POST['customercode'] == 'TSAT'       || $_POST['customercode'] == 'TSPT'    || $_POST['customercode'] == 'WSBT' 
                    || $_POST['customercode'] == 'YNP'        || $_POST['customercode'] == 'PARAGON' || $_POST['customercode'] == 'NITTSUSHOJI' 
                    || $_POST['customercode'] == 'CH-AUTO'    || $_POST['customercode'] == 'TTTCSTC' || $_POST['customercode'] == 'OLT' 
                    || $_POST['customercode'] == 'COPPERCORD' || $_POST['customercode'] == 'RNSTEEL' || $_POST['customercode'] == 'VUTEQ' 
                    || $_POST['customercode'] == 'PJW') {
                      ?>
                      <th title="FROM" style="text-align: center;width: 200px">FROM</th>
                      <?php
                    }
                  }
                  if ($_POST['companycode'] == 'RCC' || $_POST['companycode'] == 'RATC') {
                    if ($_POST['customercode'] == 'TTT') {
                      if ($_POST['worktype'] == 'sh') {
                        ?>
                        <th title="TO" style="text-align: center;width: 200px">TO</th>
                        <?php
                      }
                    }
                  }
                  if ($_POST['companycode'] == 'RRC') {
                    if ($_POST['customercode'] == 'GMT-IB' || $_POST['customercode'] == 'GMT' || $_POST['customercode'] == 'TTTC' 
                    || $_POST['customercode'] == 'TTAST'   || $_POST['customercode'] == 'BP'  || $_POST['customercode'] == 'HDK'
                    || $_POST['customercode'] == 'THAIDAISEN') {
                      ?>
                      <th title="TO" style="text-align: center;width: 200px">TO</th>
                      <?php
                    }
                  }
                  if ($_POST['companycode'] == 'RKS') {
                    if ($_POST['customercode'] == 'DAIKI' || $_POST['customercode'] == 'GMT'        || $_POST['customercode'] == 'TTAT' 
                    || $_POST['customercode'] == 'TGT'    || $_POST['customercode'] == 'TKT'        || $_POST['customercode'] == 'TDEM' 
                    || $_POST['customercode'] == 'HINO'   || $_POST['customercode'] == 'TTTC'       || $_POST['customercode'] == 'NITTSUSHOJI'
                    || $_POST['customercode'] == 'SWN'    || $_POST['customercode'] == 'THAITOHKEN' || $_POST['customercode'] == 'COPPERCORD'
                    || $_POST['customercode'] == 'TSAT') {
                      ?>
                      <th title="TO" style="text-align: center;width: 200px">TO</th>
                      <?php
                    }
                  }
                  if ($_POST['companycode'] == 'RKR') {
                    if ($_POST['customercode'] == 'TID'     || $_POST['customercode'] == 'DAIKI'   || $_POST['customercode'] == 'TTTC' 
                    || $_POST['customercode'] == 'TTPRO'    || $_POST['customercode'] == 'TTAST'   || $_POST['customercode'] == 'TTAT'     
                    || $_POST['customercode'] == 'TGT'      || $_POST['customercode'] == 'SUTT'    || $_POST['customercode'] == 'HINO' 
                    || $_POST['customercode'] == 'ACSE'     || $_POST['customercode'] == 'PARAGON' || $_POST['customercode'] == 'TKT'      
                    || $_POST['customercode'] == 'TTASTSTC' || $_POST['customercode'] == 'TTASTCS' || $_POST['customercode'] == 'TTPROSTC' 
                    || $_POST['customercode'] == 'TTPROSTC' || $_POST['customercode'] == 'TTTCSTC' || $_POST['customercode'] == 'TDEM'     
                    || $_POST['customercode'] == 'YNP'      || $_POST['customercode'] == 'PARAGON' || $_POST['customercode'] == 'NITTSUSHOJI' 
                    || $_POST['customercode'] == 'TSPT'     || $_POST['customercode'] == 'GMT'     || $_POST['customercode'] == 'TMT' 
                    || $_POST['customercode'] == 'CH-AUTO'  || $_POST['customercode'] == 'RNSTEEL' || $_POST['customercode'] == 'PJW'
                    || $_POST['customercode'] == 'TSAT') {
                      ?>
                      <th title="TO" style="text-align: center;width: 200px">TO</th>
                      <?php
                    }
                  }
                  if ($_POST['companycode'] == 'RKL') {
                    if ($_POST['customercode'] == 'TID'       || $_POST['customercode'] == 'DAIKI'   || $_POST['customercode'] == 'TTTC' 
                    || $_POST['customercode'] == 'AMT'        || $_POST['customercode'] == 'TTPRO'   || $_POST['customercode'] == 'TTAST' 
                    || $_POST['customercode'] == 'SUTT'       || $_POST['customercode'] == 'HINO'    || $_POST['customercode'] == 'SKB' 
                    || $_POST['customercode'] == 'TTASTSTC'   || $_POST['customercode'] == 'TTASTCS' || $_POST['customercode'] == 'TTPROSTC'    
                    || $_POST['customercode'] == 'TTPROSTC'   || $_POST['customercode'] == 'ACSE'    || $_POST['customercode'] == 'TKT'         
                    || $_POST['customercode'] == 'GMT'        || $_POST['customercode'] == 'TDEM'    || $_POST['customercode'] == 'TTAT'        
                    || $_POST['customercode'] == 'TSAT'       || $_POST['customercode'] == 'TSPT'    || $_POST['customercode'] == 'WSBT'        
                    || $_POST['customercode'] == 'YNP'        || $_POST['customercode'] == 'PARAGON' || $_POST['customercode'] == 'NITTSUSHOJI' 
                    || $_POST['customercode'] == 'CH-AUTO'    || $_POST['customercode'] == 'TTTCSTC' || $_POST['customercode'] == 'OLT'        
                    || $_POST['customercode'] == 'COPPERCORD' || $_POST['customercode'] == 'RNSTEEL' || $_POST['customercode'] == 'VUTEQ'       
                    || $_POST['customercode'] == 'PJW') {
                      ?>
                      <th title="TO" style="text-align: center;width: 200px">TO</th>
                      <?php
                    }
                  }
                  ?>
                  <?php
                  if ($_POST['companycode'] == 'RKR' || $_POST['companycode'] == 'RKL') {
                    ?>
                    <th title="ZONE" style="text-align: center;width: 200px">ZONE</th>
                    <th title="LOCATION" style="text-align: center;width: 200px">LOCATION</th>
                    <?php
                  }
                  ?>
                  <?php
                  if ($_POST['companycode'] == 'RKR' || $_POST['companycode'] == 'RKL') {
                    ?>
                    <th title = "BILLING1" style = "text-align: center;width: 200px">BILLING1</th>
                    <th title = "BILLING2" style = "text-align: center;width: 200px">BILLING2</th>
                    <th title = "BILLING3" style = "text-align: center;width: 200px">BILLING3</th>
                    <?php
                  }
                  ?>
                  <?php
                  if ($_POST['companycode'] == 'RRC') {
                    if ($_POST['customercode'] == 'GMT-IB' || $_POST['customercode'] == 'GMT' || $_POST['customercode'] == 'TTTC' 
                    || $_POST['customercode'] == 'TTAST'   || $_POST['customercode'] == 'BP'  || $_POST['customercode'] == 'HDK'
                    || $_POST['customercode'] == 'THAIDAISEN') {
                      ?>
                      <th title="LOCATION" style="text-align: center;width: 200px">LOCATION</th>
                      <?php
                    }
                  }
                  if ($_POST['companycode'] == 'RKS') {
                    if ($_POST['customercode'] == 'DENSO-THAI') {
                      ?>
                      <th title="WORKTYPE" style="text-align: center;width: 200px">WORKTYPE</th>
                      <th title="ROUTENO" style="text-align: center;width: 200px">ROUTENO</th>
                      <th title="ROUTEDESCRIPTION" style="text-align: center;width: 400px">ROUTEDESCRIPTION</th>
                      <th title="ROUTETYPE" style="text-align: center;width: 200px">ROUTETYPE</th>
                      <?php
                    }
                  }
                  ?>
                  <th title="E1" style="text-align: center;width: 200px">E1</th>
                  <th title="E2" style="text-align: center;width: 200px">E2</th>
                  <th title="PRICE" style="text-align: center;width: 200px">PRICE</th>
                  <?php
                  if ($_POST['companycode'] == 'RKS' || $_POST['companycode'] == 'RKR' || $_POST['companycode'] == 'RKL') {
                    if ($_POST['customercode'] == 'DENSO-THAI' && $_POST['worktype'] == 'Tulip Delivery') {
                      ?>
                      <th title="BILLINGDENSO1" style="text-align: center;width: 200px">ADTH</th>
                      <th title="BILLINGDENSO2" style="text-align: center;width: 200px">BPK(K'จำนงค์)</th>
                      <th title="BILLINGDENSO3" style="text-align: center;width: 200px">BPK(K'อรจิตรา)</th>
                      <th title="BILLINGDENSO4" style="text-align: center;width: 200px">ASTH</th>
                      <th title="BILLINGDENSO5" style="text-align: center;width: 200px">DSTH</th>
                      <th title="LOCATIONAVG" style="text-align: center;width: 200px">LOCATIONAVG</th>
                      <th title="LOCATIONAVGMIX" style="text-align: center;width: 200px">LOCATIONAVGMIX</th>
                      <?php
                    } else {
                      ?>
                      <th title="LOCATIONAVG" style="text-align: center;width: 200px">LOCATIONAVG</th>
                      <th title="LOCATIONAVGMIX" style="text-align: center;width: 200px">LOCATIONAVGMIX</th>
                      <?php
                    }
                  }
                  ?>
                  <!--<th title="O4" style="text-align: center;width: 200px">O4</th>-->
                  <th title="ไตรมาส" style="text-align: center;width: 200px">ไตรมาส</th>
                  <th title="STARTDATE" style="text-align: center;width: 200px">STARTDATE</th>
                  <th title="ENDDATE" style="text-align: center;width: 200px">ENDDATE</th>
                  <th title="ACTIVESTATUS" style="text-align: center;width: 200px">ACTIVESTATUS</th>
                  <th title="REMARK" style="text-align: center;width: 200px">REMARK</th>
                  <th title="CREATEBY" style="text-align: center;width: 200px">CREATEBY</th>
                  <th title="CREATEDATE" style="text-align: center;width: 200px">CREATEDATE</th>
                  <th title="MODIFIEDBY" style="text-align: center;width: 200px">MODIFIEDBY</th>
                  <th title="MODIFIEDDATE" style="text-align: center;width: 200px">MODIFIEDDATE</th>
                </tr>
              </thead>
              <?php
            }
          }
          ?>
          <tbody>
            <?php
            if ($_POST['companycode'] == 'RKL' && $_POST['customercode'] == 'SKB') {
              $data = explode(",",$_POST['monthst']);
              // echo $data[0];
              // echo $data[1];
              $condVehicletransportprice1 = " AND COMPANYCODE ='RKL' AND CUSTOMERCODE ='SKB' 
                AND MONTHST ='" . $data[1] . "' AND CARRYTYPE = '" . $_POST['carrytype'] . "'
                AND CONVERT(NVARCHAR(4),STARTDATE,111) = '".$data[0]."'
                ORDER BY [ZONE],[LOCATION],[VEHICLETYPE] ASC";
              $condVehicletransportprice2 = "";
              $condVehicletransportprice3 = "";
              $sql_seVehicletransportprice = "{call megVehicletransportpriceavgkm_v2(?,?,?,?)}";
              $params_seVehicletransportprice = array(
              array('select_vehicletransportpriceskb', SQLSRV_PARAM_IN),
              array($condVehicletransportprice1, SQLSRV_PARAM_IN),
              array($condVehicletransportprice2, SQLSRV_PARAM_IN),
              array($condVehicletransportprice3, SQLSRV_PARAM_IN)
              );

              $query_seVehicletransportprice = sqlsrv_query($conn, $sql_seVehicletransportprice, $params_seVehicletransportprice);
              while ($result_seVehicletransportprice = sqlsrv_fetch_array($query_seVehicletransportprice, SQLSRV_FETCH_ASSOC)) {
                ?>
                <tr >
                  <td style="text-align: center;">
                    <?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>
                  </td>
                  <td>
                    <?= $result_seVehicletransportprice['VEHICLETYPE'] ?>
                  </td>
                  <td>
                    <?= $result_seVehicletransportprice['BILLING1'] ?>
                  </td>
                  <td>
                    <?= $result_seVehicletransportprice['BILLING2'] ?>
                  </td>
                  <td>
                    <?= $result_seVehicletransportprice['ZONE'] ?>
                  </td>
                  <td>
                    <?= $result_seVehicletransportprice['LOCATION'] ?>
                  </td>
                  <td>
                    <input type="text" class="form-control" value="<?= $result_seVehicletransportprice['E1'] ?>" onchange="edit_vehicletransportpriceavgkm(this.value, 'E1', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>', '<?= $result_seVehicletransportprice['VEHICLETYPE'] ?>')">
                  </td>
                  <td>
                    <input type="text" class="form-control" value="<?= $result_seVehicletransportprice['E2'] ?>" onchange="edit_vehicletransportpriceavgkm(this.value, 'E2', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>', '<?= $result_seVehicletransportprice['VEHICLETYPE'] ?>')">
                  </td>
                  <td style="text-align: center;">
                    <?= $result_seVehicletransportprice['MONTHST'] ?>
                  </td>
                  <td style="text-align: center;">
                    <?= $result_seVehicletransportprice['STARTDATE'] ?>
                  </td>
                  <td style="text-align: center;">
                    <?= $result_seVehicletransportprice['ENDDATE'] ?>
                  </td>
                  <td style="text-align: center;">
                    <button onclick="delete_vehicletransportpriceavgkm('<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                  </td>
                </tr>
                <?php
              }
            } else {
              $data = explode(",",$_POST['monthst']);
              $condVehicletransportprice1 = " AND COMPANYCODE ='" . $_POST['companycode'] . "' AND CUSTOMERCODE = '" . $_POST['customercode'] . "'";
              $condVehicletransportprice2 = " AND MONTHST ='" . $data[1] . "' AND ACTIVESTATUS = 1 AND CARRYTYPE = '" . $_POST['carrytype'] . "'
              AND CONVERT(NVARCHAR(4),STARTDATE,111) = '".$data[0]."'";
              if ($_POST['companycode'] == 'RCC' || $_POST['companycode'] == 'RATC') {
                $condVehicletransportprice3 = " AND WORKTYPE = '".$_POST['worktype']."'";
              } else if ($_POST['companycode'] == 'RRC') {
                if ($_POST['worktype'] == 'other') {
                  $condVehicletransportprice3 = " AND WORKTYPE = 'other'";
                } else {
                  $condVehicletransportprice3 = " AND WORKTYPE IS NULL";
                }
              } else if ($_POST['companycode'] == 'RKS') {
                if ($_POST['worktype'] == 'Tulip Delivery') {
                  $condVehicletransportprice3 = " AND WORKTYPE = 'Tulip Delivery'";
                } else if ($_POST['worktype'] == 'Customer Delivery') {
                  $condVehicletransportprice3 = " AND WORKTYPE = 'Customer Delivery'";
                } else if ($_POST['worktype'] == 'other') {
                  $condVehicletransportprice3 = " AND WORKTYPE = 'other'";
                } else {
                  $condVehicletransportprice3 = " AND WORKTYPE IS NULL";
                }
              } else if ($_POST['companycode'] == 'RKR') {
                if ($_POST['worktype'] == 'other') {
                  $condVehicletransportprice3 = " AND WORKTYPE = 'other'";
                } else {
                  $condVehicletransportprice3 = " AND WORKTYPE IS NULL";
                }
              } else if ($_POST['companycode'] == 'RKL') {
                if ($_POST['worktype'] == 'other') {
                  $condVehicletransportprice3 = " AND WORKTYPE = 'other'";
                } else {
                  $condVehicletransportprice3 = " AND WORKTYPE IS NULL";
                }
              } else {
                $condVehicletransportprice3 = "";
              }

              if ($_POST['companycode'] == 'RKS' && $_POST['customercode'] == 'DENSO-THAI' && $_POST['worktype'] == 'Tulip Delivery') {
                $sql_seVehicletransportprice = "{call megVehicletransportprice_v2(?,?,?,?)}";
                $params_seVehicletransportprice = array(
                array('select_vehicletransportprice-denso', SQLSRV_PARAM_IN),
                array($condVehicletransportprice1, SQLSRV_PARAM_IN),
                array($condVehicletransportprice2, SQLSRV_PARAM_IN),
                array($condVehicletransportprice3, SQLSRV_PARAM_IN)
                );
              } else {
                $condVehicletransportprice1;
                $condVehicletransportprice2;
                $condVehicletransportprice3;
                $sql_seVehicletransportprice = "{call megVehicletransportprice_v2(?,?,?,?)}";
                $params_seVehicletransportprice = array(
                array('select_vehicletransportprice', SQLSRV_PARAM_IN),
                array($condVehicletransportprice1, SQLSRV_PARAM_IN),
                array($condVehicletransportprice2, SQLSRV_PARAM_IN),
                array($condVehicletransportprice3, SQLSRV_PARAM_IN)
                );
              }

              $query_seVehicletransportprice = sqlsrv_query($conn, $sql_seVehicletransportprice, $params_seVehicletransportprice);
              while ($result_seVehicletransportprice = sqlsrv_fetch_array($query_seVehicletransportprice, SQLSRV_FETCH_ASSOC)) {
                ?>
                <tr >
                  <td style="text-align: center;">
                    <?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>
                  </td>
                  <td style="text-align: center;">
                    <button onclick="delete_vehicletransportprice('<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                    <?php
                    if ($_POST['companycode'] == 'RRC') {
                      ?>
                      <button onclick="edit_rrc('<?= $result_seVehicletransportprice['COMPANYCODE'] ?>', '<?= $result_seVehicletransportprice['CUSTOMERCODE'] ?>', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>', '<?= $result_seVehicletransportprice['VEHICLETYPE'] ?>', '<?= $result_seVehicletransportprice['FROM'] ?>', '<?= $result_seVehicletransportprice['TO'] ?>')" title="แก้ไขข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></span></button>
                      <?php
                    } else if ($_POST['companycode'] == 'RCC' || $_POST['companycode'] == 'RATC') {
                      if ($_POST['worktype'] != 'sh') {
                        ?>
                        <button onclick="edit_rccttt('<?= $result_seVehicletransportprice['COMPANYCODE'] ?>', '<?= $result_seVehicletransportprice['CUSTOMERCODE'] ?>', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>', '<?= $result_seVehicletransportprice['CLUSTER'] ?>', '<?= $result_seVehicletransportprice['BEGINJOB'] ?>', '<?= $result_seVehicletransportprice['NAME'] ?>')" title="แก้ไขข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></span></button>
                        <?php
                      } else if ($_POST['worktype'] == 'sh') {
                        ?>
                        <button onclick="edit_rcctttsh('<?= $result_seVehicletransportprice['COMPANYCODE'] ?>', '<?= $result_seVehicletransportprice['CUSTOMERCODE'] ?>', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>', '<?= $result_seVehicletransportprice['TO'] ?>')" title="แก้ไขข้อมูล" type="button" class="btn btn-default btn-circle" ><span class="glyphicon glyphicon-wrench"></span></button>
                        <?php
                      }
                    } else if ($_POST['companycode'] == 'RKS') {
                      ?>
                      <button onclick="edit_rks('<?= $result_seVehicletransportprice['COMPANYCODE'] ?>', '<?= $result_seVehicletransportprice['CUSTOMERCODE'] ?>', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>', '<?= $result_seVehicletransportprice['VEHICLETYPE'] ?>', '<?= $result_seVehicletransportprice['FROM'] ?>', '<?= $result_seVehicletransportprice['TO'] ?>')" title="แก้ไขข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></span></button>
                      <?php
                    } else if ($_POST['companycode'] == 'RKR') {
                      ?>
                      <button onclick="edit_rkr('<?= $result_seVehicletransportprice['COMPANYCODE'] ?>', '<?= $result_seVehicletransportprice['CUSTOMERCODE'] ?>', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>', '<?= $result_seVehicletransportprice['VEHICLETYPE'] ?>', '<?= $result_seVehicletransportprice['FROM'] ?>', '<?= $result_seVehicletransportprice['TO'] ?>', '<?= $result_seVehicletransportprice['ZONE'] ?>', '<?= $result_seVehicletransportprice['LOCATION'] ?>', '<?= $result_seVehicletransportprice['BILLING1'] ?>', '<?= $result_seVehicletransportprice['BILLING2'] ?>', '<?= $result_seVehicletransportprice['BILLING3'] ?>')" title="แก้ไขข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></span></button>
                      <?php
                    } else if ($_POST['companycode'] == 'RKL') {
                      ?>
                      <button onclick="edit_rkl('<?= $result_seVehicletransportprice['COMPANYCODE'] ?>', '<?= $result_seVehicletransportprice['CUSTOMERCODE'] ?>', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>', '<?= $result_seVehicletransportprice['VEHICLETYPE'] ?>', '<?= $result_seVehicletransportprice['FROM'] ?>', '<?= $result_seVehicletransportprice['TO'] ?>', '<?= $result_seVehicletransportprice['ZONE'] ?>', '<?= $result_seVehicletransportprice['LOCATION'] ?>', '<?= $result_seVehicletransportprice['BILLING1'] ?>', '<?= $result_seVehicletransportprice['BILLING2'] ?>', '<?= $result_seVehicletransportprice['BILLING3'] ?>')" title="แก้ไขข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></span></button>
                      <?php
                    }
                    ?>
                  </td>
                  <td style="background-color:#f080802e "><?= $result_seVehicletransportprice['VEHICLEDESCCODE'] ?></td>
                  <td style="background-color:#f080802e "><?= $result_seVehicletransportprice['COMPANYCODE'] ?></td>
                  <td style="background-color:#f080802e "><?= $result_seVehicletransportprice['CUSTOMERCODE'] ?></td>
                  <td style="background-color:#f080802e "><?= $result_seVehicletransportprice['REGION'] ?></td>
                  <?php
                  if ($_POST['companycode'] == 'RRC') {
                    if ($_POST['customercode'] == 'GMT-IB' || $_POST['customercode'] == 'GMT' || $_POST['customercode'] == 'TTTC' 
                    || $_POST['customercode'] == 'TTAST'   || $_POST['customercode'] == 'BP'  || $_POST['customercode'] == 'HDK'
                    || $_POST['customercode'] == 'THAIDAISEN') {
                      ?>
                      <td>
                        <select disabled=""  class="form-control" id="cb_vehicletypedef<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" name="cb_vehicletypedef<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" onchange="edit_vehicletransportprice(this.value, 'VEHICLETYPE', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')">
                          <option value ="<?= $result_seVehicletransportprice['VEHICLETYPE'] ?>"><?= $result_seVehicletransportprice['VEHICLETYPE'] ?></option>
                        </select>
                        <div id="div_vehicletypesr<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>">
                        </div>
                      </td>
                      <?php
                    }
                  }
                  if ($_POST['companycode'] == 'RKS') {
                    if ($_POST['customercode'] == 'DAIKI'      || $_POST['customercode'] == 'TAW' || $_POST['customercode'] == 'STM' 
                    || $_POST['customercode'] == 'DENSO-THAI'  || $_POST['customercode'] == 'GMT' || $_POST['customercode'] == 'TTAT' 
                    || $_POST['customercode'] == 'TMT'         || $_POST['customercode'] == 'TGT' || $_POST['customercode'] == 'TKT' 
                    || $_POST['customercode'] == 'TDEM'        || $_POST['customercode'] == 'HINO'|| $_POST['customercode'] == 'TTTC' 
                    || $_POST['customercode'] == 'NITTSUSHOJI' || $_POST['customercode'] == 'SWN' || $_POST['customercode'] == 'THAITOHKEN'
                    || $_POST['customercode'] == 'COPPERCORD'  || $_POST['customercode'] == 'TSAT') {
                      ?>
                      <td>
                        <select disabled=""  class="form-control" id="cb_vehicletypedef<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" name="cb_vehicletypedef<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" onchange="edit_vehicletransportprice(this.value, 'VEHICLETYPE', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')">
                          <option value ="<?= $result_seVehicletransportprice['VEHICLETYPE'] ?>"><?= $result_seVehicletransportprice['VEHICLETYPE'] ?></option>
                        </select>
                        <div id="div_vehicletypesr<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>">
                        </div>
                      </td>
                      <?php
                    }
                  }
                  if ($_POST['companycode'] == 'RKR') {
                    if ($_POST['customercode'] == 'TID'     || $_POST['customercode'] == 'DAIKI'       || $_POST['customercode'] == 'TTTC' 
                    || $_POST['customercode'] == 'TTPRO'    || $_POST['customercode'] == 'TTAST'       || $_POST['customercode'] == 'TTAT'        
                    || $_POST['customercode'] == 'TGT'      || $_POST['customercode'] == 'SUTT'        || $_POST['customercode'] == 'HINO' 
                    || $_POST['customercode'] == 'ACSE'     || $_POST['customercode'] == 'PARAGON'     || $_POST['customercode'] == 'TKT'     
                    || $_POST['customercode'] == 'TTASTSTC' || $_POST['customercode'] == 'TTASTCS'     || $_POST['customercode'] == 'TTPROSTC' 
                    || $_POST['customercode'] == 'TTPROSTC' || $_POST['customercode'] == 'TTTCSTC'     || $_POST['customercode'] == 'TDEM' 
                    || $_POST['customercode'] == 'YNP'      || $_POST['customercode'] == 'NITTSUSHOJI' || $_POST['customercode'] == 'TSPT'    
                    || $_POST['customercode'] == 'GMT'      || $_POST['customercode'] == 'TMT'         || $_POST['customercode'] == 'CH-AUTO'
                    || $_POST['customercode'] == 'RNSTEEL'  || $_POST['customercode'] == 'PJW'         || $_POST['customercode'] == 'TSAT') {
                      ?>
                      <td>
                        <select disabled=""  class="form-control" id="cb_vehicletypedef<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" name="cb_vehicletypedef<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" onchange="edit_vehicletransportprice(this.value, 'VEHICLETYPE', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')">
                          <option value ="<?= $result_seVehicletransportprice['VEHICLETYPE'] ?>"><?= $result_seVehicletransportprice['VEHICLETYPE'] ?></option>
                        </select>
                        <div id="div_vehicletypesr<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>">
                        </div>
                      </td>
                      <?php
                    }
                  }
                  if ($_POST['companycode'] == 'RKL') {
                    if ($_POST['customercode'] == 'TID'        || $_POST['customercode'] == 'DAIKI'       || $_POST['customercode'] == 'TTTC' 
                    || $_POST['customercode'] == 'AMT'         || $_POST['customercode'] == 'TTPRO'       || $_POST['customercode'] == 'TTAST' 
                    || $_POST['customercode'] == 'SUTT'        || $_POST['customercode'] == 'HINO'        || $_POST['customercode'] == 'SKB' 
                    || $_POST['customercode'] == 'TTASTSTC'    || $_POST['customercode'] == 'TTASTCS'     || $_POST['customercode'] == 'TTPROSTC' 
                    || $_POST['customercode'] == 'TTPROSTC'    || $_POST['customercode'] == 'SKB'         || $_POST['customercode'] == 'ACSE' 
                    || $_POST['customercode'] == 'TKT'         || $_POST['customercode'] == 'GMT'         || $_POST['customercode'] == 'TDEM' 
                    || $_POST['customercode'] == 'TTAT'        || $_POST['customercode'] == 'TSAT'        || $_POST['customercode'] == 'TSPT' 
                    || $_POST['customercode'] == 'WSBT'        || $_POST['customercode'] == 'YNP'         || $_POST['customercode'] == 'PARAGON' 
                    || $_POST['customercode'] == 'NITTSUSHOJI' || $_POST['customercode'] == 'CH-AUTO'     || $_POST['customercode'] == 'TTTCSTC' 
                    || $_POST['customercode'] == 'OLT'         || $_POST['customercode'] == 'COPPERCORD'  || $_POST['customercode'] == 'RNSTEEL' 
                    || $_POST['customercode'] == 'VUTEQ'       || $_POST['customercode'] == 'PJW') {
                      ?>
                      <td>
                        <select disabled=""  class="form-control" id="cb_vehicletypedef<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" name="cb_vehicletypedef<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" onchange="edit_vehicletransportprice(this.value, 'VEHICLETYPE', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')">
                          <option value ="<?= $result_seVehicletransportprice['VEHICLETYPE'] ?>"><?= $result_seVehicletransportprice['VEHICLETYPE'] ?></option>
                        </select>
                        <div id="div_vehicletypesr<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>">
                        </div>
                      </td>
                      <?php
                    }
                  }
                  if ($_POST['companycode'] == 'RKL') {
                    if ($_POST['customercode'] == 'TID'        || $_POST['customercode'] == 'DAIKI'      || $_POST['customercode'] == 'TTTC' 
                    || $_POST['customercode'] == 'AMT'         || $_POST['customercode'] == 'TTPRO'      || $_POST['customercode'] == 'TTAST' 
                    || $_POST['customercode'] == 'SUTT'        || $_POST['customercode'] == 'HINO'       || $_POST['customercode'] == 'SKB' 
                    || $_POST['customercode'] == 'TTASTSTC'    || $_POST['customercode'] == 'TTASTCS'    || $_POST['customercode'] == 'TTPROSTC' 
                    || $_POST['customercode'] == 'TTPROSTC'    || $_POST['customercode'] == 'SKB'        || $_POST['customercode'] == 'ACSE' 
                    || $_POST['customercode'] == 'TKT'         || $_POST['customercode'] == 'GMT'        || $_POST['customercode'] == 'TDEM' 
                    || $_POST['customercode'] == 'TTAT'        || $_POST['customercode'] == 'TSAT'       || $_POST['customercode'] == 'TSPT' 
                    || $_POST['customercode'] == 'WSBT'        || $_POST['customercode'] == 'YNP'        || $_POST['customercode'] == 'PARAGON' 
                    || $_POST['customercode'] == 'NITTSUSHOJI' || $_POST['customercode'] == 'CH-AUTO'    || $_POST['customercode'] == 'TTTCSTC' 
                    || $_POST['customercode'] == 'OLT'         || $_POST['customercode'] == 'COPPERCORD' || $_POST['customercode'] == 'RNSTEEL' 
                    || $_POST['customercode'] == 'VUTEQ'       || $_POST['customercode'] == 'PJW') {
                      ?>
                      <td>
                        <select disabled="" class="form-control" id="cb_fromdef<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" name="cb_fromdef<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" >
                          <option value ="<?= $result_seVehicletransportprice['FROM'] ?>"><?= $result_seVehicletransportprice['FROM'] ?></option>
                        </select>
                        <div id="div_fromsr<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>"></div>
                      </td>
                      <?php
                    }
                  }
                  if ($_POST['companycode'] == 'RRC') {
                    if ($_POST['customercode'] == 'GMT-IB' || $_POST['customercode'] == 'GMT' || $_POST['customercode'] == 'TTTC' 
                    || $_POST['customercode'] == 'TTAST'   || $_POST['customercode'] == 'BP'  || $_POST['customercode'] == 'HDK'
                    || $_POST['customercode'] == 'THAIDAISEN') {
                      ?>
                      <td>
                        <select disabled="" class="form-control" id="cb_fromdef<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" name="cb_fromdef<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" >
                          <option value ="<?= $result_seVehicletransportprice['FROM'] ?>"><?= $result_seVehicletransportprice['FROM'] ?></option>
                        </select>
                        <div id="div_fromsr<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>"></div>
                      </td>
                      <?php
                    }
                  }
                  if ($_POST['companycode'] == 'RKS') {
                    if ($_POST['customercode'] == 'DAIKI' || $_POST['customercode'] == 'TAW'        || $_POST['customercode'] == 'STM' 
                    || $_POST['customercode'] == 'GMT'    || $_POST['customercode'] == 'TTAT'       || $_POST['customercode'] == 'TMT' 
                    || $_POST['customercode'] == 'TGT'    || $_POST['customercode'] == 'TKT'        || $_POST['customercode'] == 'TDEM' 
                    || $_POST['customercode'] == 'HINO'   || $_POST['customercode'] == 'TTTC'       || $_POST['customercode'] == 'NITTSUSHOJI'
                    || $_POST['customercode'] == 'SWN'    || $_POST['customercode'] == 'THAITOHKEN' || $_POST['customercode'] == 'COPPERCORD'
                    || $_POST['customercode'] == 'TSAT') {
                      ?>
                      <td>
                        <select disabled="" class="form-control" id="cb_fromdef<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" name="cb_fromdef<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" >
                          <option value ="<?= $result_seVehicletransportprice['FROM'] ?>"><?= $result_seVehicletransportprice['FROM'] ?></option>
                        </select>
                        <div id="div_fromsr<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>"></div>
                      </td>
                      <?php
                    }
                  }
                  if ($_POST['companycode'] == 'RKR') {
                    if ($_POST['customercode'] == 'TID'     || $_POST['customercode'] == 'DAIKI'    || $_POST['customercode'] == 'TTTC' 
                    || $_POST['customercode'] == 'TTPRO'    || $_POST['customercode'] == 'TTAST'    || $_POST['customercode'] == 'TTAT' 
                    || $_POST['customercode'] == 'TGT'      || $_POST['customercode'] == 'SUTT'     || $_POST['customercode'] == 'HINO' 
                    || $_POST['customercode'] == 'ACSE'     || $_POST['customercode'] == 'PARAGON'  || $_POST['customercode'] == 'TKT'  
                    || $_POST['customercode'] == 'TTASTSTC' || $_POST['customercode'] == 'TTASTCS'  || $_POST['customercode'] == 'TTPROSTC' 
                    || $_POST['customercode'] == 'TTPROSTC' || $_POST['customercode'] == 'TTTCSTC'  || $_POST['customercode'] == 'TDEM' 
                    || $_POST['customercode'] == 'YNP'      || $_POST['customercode'] == 'PARAGON'  || $_POST['customercode'] == 'NITTSUSHOJI' 
                    || $_POST['customercode'] == 'TSPT'     || $_POST['customercode'] == 'GMT'      || $_POST['customercode'] == 'TMT' 
                    || $_POST['customercode'] == 'CH-AUTO'  || $_POST['customercode'] == 'RNSTEEL'  || $_POST['customercode'] == 'PJW'
                    || $_POST['customercode'] == 'TSAT') {
                      ?>
                      <td>
                        <select disabled="" class="form-control" id="cb_fromdef<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" name="cb_fromdef<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" >
                          <option value ="<?= $result_seVehicletransportprice['FROM'] ?>"><?= $result_seVehicletransportprice['FROM'] ?></option>
                        </select>
                        <div id="div_fromsr<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>"></div>
                      </td>
                      <?php
                    }
                  }
                  if ($_POST['companycode'] == 'RKS') {
                    if ($_POST['customercode'] == 'DAIKI' || $_POST['customercode'] == 'GMT'        || $_POST['customercode'] == 'TTAT' 
                    || $_POST['customercode'] == 'TGT'    || $_POST['customercode'] == 'TKT'        || $_POST['customercode'] == 'TDEM' 
                    || $_POST['customercode'] == 'HINO'   || $_POST['customercode'] == 'TTTC'       || $_POST['customercode'] == 'NITTSUSHOJI'
                    || $_POST['customercode'] == 'SWN'    || $_POST['customercode'] == 'THAITOHKEN' || $_POST['customercode'] == 'COPPERCORD'
                    || $_POST['customercode'] == 'TSAT') {
                      ?>
                      <td>
                        <select disabled="" class="form-control" id="cb_todef<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" name="cb_todef<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" >
                          <option value ="<?= $result_seVehicletransportprice['TO'] ?>"><?= $result_seVehicletransportprice['TO'] ?></option>
                        </select>
                        <div id="div_tosr<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>"></div>
                      </td>
                      <?php
                    }
                  }
                  if ($_POST['companycode'] == 'RCC' || $_POST['companycode'] == 'RATC') {
                    if ($_POST['customercode'] == 'TTT') {
                      if ($_POST['worktype'] == 'sh') {
                        ?>
                        <td>
                          <select disabled="" class="form-control" id="cb_tosh<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" name="cb_tosh<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" >
                            <option value ="<?= $result_seVehicletransportprice['TO'] ?>"><?= $result_seVehicletransportprice['TO'] ?></option>
                          </select>
                          <div id="div_toshsr<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>"></div>
                        </td>
                      </td>
                      <?php
                    }
                  }
                }
                if ($_POST['companycode'] == 'RRC') {
                  if ($_POST['customercode'] == 'GMT-IB' || $_POST['customercode'] == 'GMT' || $_POST['customercode'] == 'TTTC' 
                  || $_POST['customercode'] == 'TTAST'   || $_POST['customercode'] == 'BP'  || $_POST['customercode'] == 'HDK'
                  || $_POST['customercode'] == 'THAIDAISEN') {
                    ?>
                    <td>
                      <select disabled="" class="form-control" id="cb_todef<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" name="cb_todef<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" >
                        <option value ="<?= $result_seVehicletransportprice['TO'] ?>"><?= $result_seVehicletransportprice['TO'] ?></option>
                      </select>
                      <div id="div_tosr<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>"></div>
                    </td>
                    <?php
                  }
                }
                if ($_POST['companycode'] == 'RKR') {
                  if ($_POST['customercode'] == 'TID'        || $_POST['customercode'] == 'DAIKI'    || $_POST['customercode'] == 'TTTC' 
                  || $_POST['customercode'] == 'TTPRO'       || $_POST['customercode'] == 'TTAST'    || $_POST['customercode'] == 'TTAT' 
                  || $_POST['customercode'] == 'TGT'         || $_POST['customercode'] == 'SUTT'     || $_POST['customercode'] == 'HINO' 
                  || $_POST['customercode'] == 'HINO'        || $_POST['customercode'] == 'ACSE'     || $_POST['customercode'] == 'PARAGON' 
                  || $_POST['customercode'] == 'TKT'         || $_POST['customercode'] == 'TTASTSTC' || $_POST['customercode'] == 'TTASTCS' 
                  || $_POST['customercode'] == 'TTPROSTC'    || $_POST['customercode'] == 'TTPROSTC' || $_POST['customercode'] == 'TTTCSTC' 
                  || $_POST['customercode'] == 'TDEM'        || $_POST['customercode'] == 'YNP'      || $_POST['customercode'] == 'PARAGON' 
                  || $_POST['customercode'] == 'NITTSUSHOJI' || $_POST['customercode'] == 'TSPT'     || $_POST['customercode'] == 'GMT' 
                  || $_POST['customercode'] == 'CH-AUTO'     || $_POST['customercode'] == 'RNSTEEL'  || $_POST['customercode'] == 'PJW'
                  || $_POST['customercode'] == 'TSAT') {
                    ?>
                    <td>
                      <select disabled="" class="form-control" id="cb_todef<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" name="cb_todef<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" >
                        <option value ="<?= $result_seVehicletransportprice['TO'] ?>"><?= $result_seVehicletransportprice['TO'] ?></option>
                      </select>
                      <div id="div_tosr<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>"></div>
                    </td>
                    <?php
                  }
                }
                if ($_POST['companycode'] == 'RKL') {
                  if ($_POST['customercode'] == 'TID'        || $_POST['customercode'] == 'DAIKI'      || $_POST['customercode'] == 'TTTC' 
                  || $_POST['customercode'] == 'AMT'         || $_POST['customercode'] == 'TTPRO'      || $_POST['customercode'] == 'TTAST' 
                  || $_POST['customercode'] == 'SUTT'        || $_POST['customercode'] == 'HINO'       || $_POST['customercode'] == 'SKB' 
                  || $_POST['customercode'] == 'TTASTSTC'    || $_POST['customercode'] == 'TTASTCS'    || $_POST['customercode'] == 'TTPROSTC' 
                  || $_POST['customercode'] == 'TTPROSTC'    || $_POST['customercode'] == 'SKB'        || $_POST['customercode'] == 'ACSE' 
                  || $_POST['customercode'] == 'TKT'         || $_POST['customercode'] == 'GMT'        || $_POST['customercode'] == 'TDEM' 
                  || $_POST['customercode'] == 'TTAT'        || $_POST['customercode'] == 'TSAT'       || $_POST['customercode'] == 'TSPT' 
                  || $_POST['customercode'] == 'WSBT'        || $_POST['customercode'] == 'YNP'        || $_POST['customercode'] == 'PARAGON' 
                  || $_POST['customercode'] == 'NITTSUSHOJI' || $_POST['customercode'] == 'CH-AUTO'    || $_POST['customercode'] == 'TTTCSTC' 
                  || $_POST['customercode'] == 'OLT'         || $_POST['customercode'] == 'COPPERCORD' || $_POST['customercode'] == 'RNSTEEL'
                  || $_POST['customercode'] == 'VUTEQ'       || $_POST['customercode'] == 'PJW') {
                    ?>
                    <td>
                      <select disabled="" class="form-control" id="cb_todef<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" name="cb_todef<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" >
                        <option value ="<?= $result_seVehicletransportprice['TO'] ?>"><?= $result_seVehicletransportprice['TO'] ?></option>
                      </select>
                      <div id="div_tosr<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>"></div>
                    </td>
                    <?php
                  }
                }
                if ($_POST['companycode'] == 'RRC') {
                  if ($_POST['customercode'] == 'GMT-IB' || $_POST['customercode'] == 'GMT' || $_POST['customercode'] == 'TTTC' 
                  || $_POST['customercode'] == 'TTAST'   || $_POST['customercode'] == 'BP'  || $_POST['customercode'] == 'HDK'
                  || $_POST['customercode'] == 'THAIDAISEN') {
                    ?>
                    <td contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'LOCATION', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['LOCATION'] ?></td>
                    <?php
                  }
                }
                if ($_POST['companycode'] == 'RKS') {
                  if ($_POST['customercode'] == 'DENSO-THAI') {
                    ?>
                    <td contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'WORKTYPE', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['WORKTYPE'] ?></td>
                    <td contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'ROUTENO', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['ROUTENO'] ?></td>
                    <td contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'ROUTEDESCRIPTION', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['ROUTEDESCRIPTION'] ?></td>
                    <td contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'ROUTETYPE', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['ROUTETYPE'] ?></td>
                    <?php
                  }
                }
                if ($_POST['companycode'] == 'RCC' || $_POST['companycode'] == 'RATC') {
                  if ($_POST['customercode'] == 'TTT') {
                    if ($_POST['worktype'] != 'sh') {
                      ?>
                      <td>
                        <select disabled=""  class="form-control" id="cb_cluster<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" name="cb_cluster<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>">
                          <option value ="<?= $result_seVehicletransportprice['CLUSTER'] ?>"><?= $result_seVehicletransportprice['CLUSTER'] ?></option>
                        </select>
                        <div id="div_clustersr<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>"></div>
                      </td>
                      <?php
                    }
                  }
                }
                ?>
                <?php
                if ($_POST['companycode'] == 'RCC' || $_POST['companycode'] == 'RATC') {
                  if ($_POST['customercode'] == 'TTT') {
                    if ($_POST['worktype'] != 'sh') {
                      ?>
                      <td style="background-color:#f080802e "><?= $result_seVehicletransportprice['CLUSTER_TH'] ?></td>
                      <?php
                    }
                  }
                }
                ?>
                <!--
                  <td><?//= $result_seVehicletransportprice['BEGINJOB'] ?></td>
                -->

                <?php
                if ($_POST['companycode'] == 'RCC' || $_POST['companycode'] == 'RATC') {
                  if ($_POST['customercode'] == 'TTT') {
                    if ($_POST['worktype'] != 'sh') {
                      ?>
                      <td>
                        <select disabled="" class="form-control" id="cb_from<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" name="cb_from<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" >
                          <option value ="<?= $result_seVehicletransportprice['BEGINJOB'] ?>"><?= $result_seVehicletransportprice['BEGINJOB'] ?></option>
                        </select>
                        <div id="div_fromsr<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>"></div>
                      </td>
                      <td>
                        <select disabled="" class="form-control" id="cb_to<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" name="cb_to<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>">
                          <option value ="<?= $result_seVehicletransportprice['NAME'] ?>"><?= $result_seVehicletransportprice['NAME'] ?></option>
                        </select>
                        <div id="div_tosr<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>"></div>
                      </td>
                      <?php
                    }
                  }
                }
                ?>

                <?php
                if ($_POST['companycode'] == 'RCC' || $_POST['companycode'] == 'RATC') {
                  if ($_POST['customercode'] == 'TTT') {
                    if ($_POST['worktype'] == 'sh') {
                      ?>
                      <td  contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'BASE4L', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['BASE4L'] ?></td>
                      <td  contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'BASE8L', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['BASE8L'] ?></td>
                      <td  contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'LOCATIONBASE4L', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['LOCATIONBASE4L'] ?></td>
                      <td  contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'LOCATIONBASE8L', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['LOCATIONBASE8L'] ?></td>
                      <?php
                    } else {
                      ?>
                      <td  contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'SRBASE4L', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['SRBASE4L'] ?></td>
                      <td  contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'SRBASE8L', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['SRBASE8L'] ?></td>
                      <td  contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'GWBASE4L', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['GWBASE4L'] ?></td>
                      <td  contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'GWBASE8L', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['GWBASE8L'] ?></td>
                      <td  contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'BPBASE4L', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['BPBASE4L'] ?></td>
                      <td  contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'BPBASE8L', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['BPBASE8L'] ?></td>
                      <td  contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'BP25BASE4L', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['BP25BASE4L'] ?></td>
                      <td  contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'BP25BASE8L', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['BP25BASE8L'] ?></td>
                      <td  contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'SPBASE4L', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['SPBASE4L'] ?></td>
                      <td  contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'SPBASE8L', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['SPBASE8L'] ?></td>
                      <td  contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'TACBASE4L', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['TACBASE4L'] ?></td>
                      <td  contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'TACBASE8L', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['TACBASE8L'] ?></td>
                      <td  contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'OTHBASE4L', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['OTHBASE4L'] ?></td>
                      <td  contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'OTHBASE8L', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['OTHBASE8L'] ?></td>

                      <?php
                    }
                  }
                }

                if ($_POST['companycode'] == 'RKR' || $_POST['companycode'] == 'RKL') {
                  ?>
                  <td>
                    <select disabled="" class="form-control" id="cb_zonedef<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" name="cb_zonedef<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" >
                      <option value ="<?= $result_seVehicletransportprice['ZONE'] ?>"><?= $result_seVehicletransportprice['ZONE'] ?></option>
                    </select>
                    <div id="div_zonesr<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>"></div>
                  </td>
                  <td>
                    <select disabled="" class="form-control" id="cb_locationdef<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" name="cb_locationdef<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" >
                      <option value ="<?= $result_seVehicletransportprice['LOCATION'] ?>"><?= $result_seVehicletransportprice['LOCATION'] ?></option>
                    </select>
                    <div id="div_locationsr<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>"></div>
                  </td>
                  <?php
                }
                if ($_POST['companycode'] == 'RKR' || $_POST['companycode'] == 'RKL') {
                  ?>
                  <td>
                    <select disabled="" class="form-control" id="cb_billing1def<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" name="cb_billing1def<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" >
                      <option value ="<?= $result_seVehicletransportprice['BILLING1'] ?>"><?= $result_seVehicletransportprice['BILLING1'] ?></option>
                    </select>
                    <div id="div_billing1sr<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>"></div>
                  </td>
                  <td>
                    <select disabled="" class="form-control" id="cb_billing2def<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" name="cb_billing2def<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" >
                      <option value ="<?= $result_seVehicletransportprice['BILLING2'] ?>"><?= $result_seVehicletransportprice['BILLING2'] ?></option>
                    </select>
                    <div id="div_billing2sr<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>"></div>
                  </td>
                  <td>
                    <select disabled="" class="form-control" id="cb_billing3def<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" name="cb_billing3def<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>" >
                      <option value ="<?= $result_seVehicletransportprice['BILLING3'] ?>"><?= $result_seVehicletransportprice['BILLING3'] ?></option>
                    </select>
                    <div id="div_billing3sr<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>"></div>
                  </td>
                  <?php
                }
                ?>
                <?php
                if ($_POST['companycode'] == 'RATC' || $_POST['companycode'] == 'RCC') {
                  ?>
                  <td><?= $result_seVehicletransportprice['E1'] ?></td>
                  <?php
                } else {
                  ?>
                  <td contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'E1', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['E1'] ?></td>
                  <?php
                }
                ?>
                <td contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'E2', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['E2'] ?></td>
                <!-- <td><?= $result_seVehicletransportprice['E2'] ?></td> -->
                <!-- <td style="text-align: center"><input type="text" class="form-control" id="txt_vehicletransportprice" onchange="update_megtransportprice(this.value, 'PRICES', '<?=$result_seVehicletransportprice['VEHICLETRANSPORTPRICEID']?>', '')" value="<?= $result_seVehicletransportprice['PRICE'] ?>">555</td> -->
                <td contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'PRICE', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['PRICE'] ?></td>
                <?php
                if ($_POST['companycode'] == 'RKS' || $_POST['companycode'] == 'RKR' || $_POST['companycode'] == 'RKL') {
                  if ($_POST['customercode'] == 'DENSO-THAI' && $_POST['worktype'] == 'Tulip Delivery') {
                    ?>
                    <td contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'BILLINGDENSO1', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['BILLINGDENSO1'] ?></td>
                    <td contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'BILLINGDENSO2', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['BILLINGDENSO2'] ?></td>
                    <td contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'BILLINGDENSO3', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['BILLINGDENSO3'] ?></td>
                    <td contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'BILLINGDENSO4', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['BILLINGDENSO4'] ?></td>
                    <td contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'BILLINGDENSO5', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['BILLINGDENSO5'] ?></td>
                    <td contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'LOCATIONAVG', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['LOCATIONAVG'] ?></td>
                    <td contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'LOCATIONAVGMIX', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['LOCATIONAVGMIX'] ?></td>
                    <?php
                  } else {
                    ?>
                    <td contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'LOCATIONAVG', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['LOCATIONAVG'] ?></td>
                    <td contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'LOCATIONAVGMIX', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['LOCATIONAVGMIX'] ?></td>
                    <?php
                  }
                }
                ?>
                <td style="background-color:#f080802e "><?= $result_seVehicletransportprice['MONTHST'] ?></td>
                <td style="background-color:#f080802e " title="คลิก" data-toggle="modal"  data-target="#modal_startenddate" onclick="editvar_startenddate('<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>','<?= $result_seVehicletransportprice['STARTDATE'] ?>','<?= $result_seVehicletransportprice['ENDDATE'] ?>')"><?= $result_seVehicletransportprice['STARTDATE'] ?></td>
                <td style="background-color:#f080802e " title="คลิก" data-toggle="modal"  data-target="#modal_startenddate" onclick="editvar_startenddate('<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>','<?= $result_seVehicletransportprice['STARTDATE'] ?>','<?= $result_seVehicletransportprice['ENDDATE'] ?>')"><?= $result_seVehicletransportprice['ENDDATE'] ?></td>
                <td style="background-color:#f080802e " ><?= $result_seVehicletransportprice['ACTIVESTATUS'] ?></td>
                <td contenteditable="true"  onkeyup="editvar_vehicletransportprice(this, 'REMARK', '<?= $result_seVehicletransportprice['VEHICLETRANSPORTPRICEID'] ?>')"><?= $result_seVehicletransportprice['REMARK'] ?></td>
                <td style="background-color:#f080802e "><?= $result_seVehicletransportprice['CREATEBY'] ?></td>
                <td style="background-color:#f080802e "><?= $result_seVehicletransportprice['CREATEDATE'] ?></td>
                <td style="background-color:#f080802e "><?= $result_seVehicletransportprice['MODIFIEDBY'] ?></td>
                <td style="background-color:#f080802e "><?= $result_seVehicletransportprice['MODIFIEDDATE'] ?></td>
              </tr>
              <?php
            }
          }
          ?>
        </tbody>
      </table>
    </div>
    <?php
  }



 
?>
<?php
sqlsrv_close($conn);
?>
