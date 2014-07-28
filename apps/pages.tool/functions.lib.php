<?php
  function get_list(){
    $s = getSections(true);
    print '<table width="80%" class="pt_table">
            <tr>
              <th>Page</th>
              <th>Code</th>
              <th>Type</th>
            </tr>';
    foreach($s as $value){
      print '<tr onclick="javascript:manage(\''.$value['CODSECTION'].'\');"><td>'.$value['LABEL'].'</td><td>'.$value['CODSECTION'].'</td><td>'.$value['APP'].'</td></tr>';
    }
    print '</table>';
/*
    print '<table width="80%" class="pt_table"><tr>';
    // Get headers
    foreach($s[ key($s) ] as $key=>$value){
      print "<th>$key</th>";
    }
    print '</tr>';

    foreach($s as $value){
      print '<tr>';
      foreach($value as $item)
        print "<td>$item</td>";

      print '</tr>';
    }
    print '</table>';
*/
  }
// ----------------------------------------------------
  function get_app_adminContent($codSection){
    global $_CURRENT,$PAGE;
    $s = getSections(true);

    $appname = $s[ $codSection ]['APP'];
    $_CURRENT['QUERY_STRING'] .= '&action=manage&code='.$codSection;
    //includeClass('appController');
    //include(SYSTEM_ROOT.APP_DIR.$appname.'.app/controller.class.php');
    $app = new appController(
      $s[ $codSection ]['LABEL'], //NAME
      SYSTEM_ROOT.APP_DIR.$appname.'/', //PATH
      PUBLIC_ROOT.APP_DIR.$appname.'/', //URL
      PUBLIC_ROOT.DATA_DIR.$s[ $codSection ]['CODSECTION'], //DATA_DIR
      SYSTEM_ROOT.DATA_DIR.$s[ $codSection ]['CODSECTION'] //DATA_PATH
    );
    $app->load_headers($PAGE);
    $app->admin_get_cPanel();
  }
?>