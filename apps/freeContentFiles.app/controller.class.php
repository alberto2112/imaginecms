<?php
  global $_CURRENT;
  class webApp extends appController{
  /*
    function __construct($NAME){
      global $_CURRENT;
      parent::__construct($NAME);
      //$this->set_info('DATA_DIR',PUBLIC_ROOT.DATA_DIR.$_CURRENT['SECTION']['NAME'].'/');
      //$this->set_info('DATA_PATH',SYSTEM_ROOT.DATA_DIR.$_CURRENT['SECTION']['NAME'].'/');
    }
*/
    function load_headers(){
      global $_CURRENT, $PAGE;
      $PAGE->add_css($this->get_info('DATA_DIR').'styles.css');
    }

    function get_content(){
      //TODO
      global $_CURRENT;
      $file2read = SYSTEM_ROOT.DATA_DIR.$_CURRENT['SECTION']['NAME'].'/3k_body.html';
      if(file_exists($file2read))
        if(is_readable($file2read))
          $content = file_get_contents($file2read);
        else
          $content = '<p style="text-align:center;><strong>Error:</strong> <span style="color:#A22">'.PUBLIC_ROOT.DATA_DIR.$_CURRENT['SECTION']['NAME'].'/3k_body.html </span> is not accessible</p>';
      else
        $content = '<p style="text-align:center;"><strong>Error:</strong> <span style="color:#A22">'.PUBLIC_ROOT.DATA_DIR.$_CURRENT['SECTION']['NAME'].'/3k_body.html</span> not exists</p>';

      $content = str_replace('{@DATA_DIR}', PUBLIC_ROOT.DATA_DIR.$_CURRENT['SECTION']['NAME'], $content);
      return $content;

      //return '<h1>Hola mundo</h1><p>Section: '.$_CURRENT['SECTION']['NAME'].'</p><p><strong>APP INFO:</strong></p><pre>'.print_r(parent::get_info(), true).'</pre>';
    }
  }
?>