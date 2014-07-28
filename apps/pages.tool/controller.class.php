<?php
//  global $PAGE;
  class webTool extends appController{
    const L_GENERAL = 0;
    const L_EDIT = 1;
    const L_SAVE = 2;
    const L_DELETE = 3;

    private $LEVEL = self::L_GENERAL;

    function __construct($a, $b, $c, $d, $e){
      parent::__construct($a, $b, $c, $d, $e);

      switch(getRequest_param('action', 'default')){
        case 'manage':
          $this->LEVEL = self::L_EDIT;
          break;
        default:
          $this->LEVEL = self::L_GENERAL;
      }
    }
// -----------------------------------------------
    function admin_get_content(){
      //$action = getRequest_param('action', false);
      switch($this->LEVEL){
        case self::L_EDIT:
          $code = getRequest_param('code', false);
          $this->LEVEL = self::L_EDIT;
          if($code===false){
            print '<h2>ERROR</h2>'; //TODO
          } else {
            print '<h1>Editting: '.$code.'</h1>';
            get_app_adminContent($code);
          }
          break;

        default:
          $this->LEVEL = self::L_GENERAL;
          print '<h1>List of pages</h1>';
          get_list();
      }
    }
// -----------------------------------------------
    function load_headers($oPage){
      if($this->LEVEL == self::L_GENERAL){
        $oPage->add_css($this->get_info('URL').'css/styles.css');
        $oPage->add_js($this->get_info('URL').'js/general.js');
      }
    }
  } # CLASS />
// ======================================================
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
    include(SYSTEM_ROOT.APP_DIR.$appname.'.app/controller.class.php');
    $app = new webApp(
      $s[ $codSection ]['LABEL'], //NAME
      null, //PATH
      PUBLIC_ROOT.APP_DIR.$appname.'.app/', //URL
      PUBLIC_ROOT.DATA_DIR.$s[ $codSection ]['CODSECTION'], //DATA_DIR
      SYSTEM_ROOT.DATA_DIR.$s[ $codSection ]['CODSECTION'] //DATA_PATH
    );
    $app->load_headers($PAGE);
    print $app->admin_get_content();
  }
?>