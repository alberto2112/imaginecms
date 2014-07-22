<?php
  global $_CURRENT;
  class webApp extends appController{
  /*
    function __construct($NAME){
      global $_CURRENT;
      parent::__construct($NAME);
      //$this->set_info('DATA_DIR',PUBLIC_ROOT.DATA_DIR.$_CURRENT['SECTION']['CODSECTION'].'/');
      //$this->set_info('DATA_PATH',SYSTEM_ROOT.DATA_DIR.$_CURRENT['SECTION']['CODSECTION'].'/');
    }
*/
    function load_headers($P){
      global $_CURRENT;
      if($_CURRENT['WORKSPACE'] == WS_ADMIN){
        $P->add_css($this->get_info('DIR').'workspace.css');
        $P->add_js($this->get_info('DIR').'js/mootools-core.1.2.3.js');
        $P->add_js($this->get_info('DIR').'js/mootools-dialog.js');
        $P->add_js($this->get_info('DIR').'js/formutils.js');
      }
    }

    function get_content(){
      //TODO
      global $_CURRENT;
      $file2read = SYSTEM_ROOT.DATA_DIR.$_CURRENT['SECTION']['CODSECTION'].'/3k_body.html';
      if(file_exists($file2read))
        if(is_readable($file2read))
          $content = file_get_contents($file2read);
        else
          $content = '<p style="text-align:center;><strong>Error:</strong> <span style="color:#A22">'.PUBLIC_ROOT.DATA_DIR.$_CURRENT['SECTION']['CODSECTION'].'/3k_body.html </span> is not accessible</p>';
      else
        $content = '<p style="text-align:center;"><strong>Error:</strong> <span style="color:#A22">'.PUBLIC_ROOT.DATA_DIR.$_CURRENT['SECTION']['CODSECTION'].'/3k_body.html</span> not exists</p>';

      $content = str_replace('{@DATA_DIR}', PUBLIC_ROOT.DATA_DIR.$_CURRENT['SECTION']['CODSECTION'], $content);
      return $content;

      //return '<h1>Hola mundo</h1><p>Section: '.$_CURRENT['SECTION']['CODSECTION'].'</p><p><strong>APP INFO:</strong></p><pre>'.print_r(parent::get_info(), true).'</pre>';
    }

    function admin_get_content(){
      $action = getRequest_param('fcfa', 'workspace');
      switch($action){
        case 'save_file':
            include('inc/save_file.inc');
            break;
        case 'create_file':
            include('inc/create_file.inc');
            break;
        case 'create_folder':
            include('inc/create_folder.inc');
            break;
        case 'delete':
            include('inc/delete.inc');
            break;
        case 'delete_file':
            include('inc/delete_file.inc');
            break;
        case 'delete_folder':
            include('inc/delete_folder.inc');
            break;
        case 'rename_folder':
        case 'rename_file':
            include('inc/rename.inc');  # Sirve para directorios y ficheros, el proceso es el mismo
            break;
        case 'upload_file':
            include('inc/upload_file.inc');
            break;
        case 'install_packet':
            include('inc/install_package.inc');
            break;
        default:        # view_workspace
            include('workspace.php');
      }
      return '<div style="background-color:#A22;width:350px;padding:1.5em;"><h3>freeContentFiles admin cPanel for: '.$this->get_info('NAME').'</div>';
    }
  }
?>