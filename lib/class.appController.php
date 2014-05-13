<?php
  class appController
  {

    protected $_I = array();
    protected $_C = '';

    function __construct($name, $path=null, $url='', $ddir='', $dpath=''){
      $this->_I = array(
        'NAME'=>$name,
        'PATH'=>(($path===null)?realpath( dirname(__FILE__)).'/': $path),
        'URL'=>$url,
        'DATA_DIR'=>$ddir,
        'DATA_PATH'=>$dpath
/*
        'PATH'=>(($path===null)?SYSTEM_ROOT.APP_DIR.$name.'/': $path),
        'URL'=>(($url===null)?PUBLIC_ROOT.APP_DIR.$name.'/': $url),
        'DATA_DIR'=>(($ddir===null)?PUBLIC_ROOT.DATA_DIR.$name.'/':$ddir),
        'DATA_PATH'=>(($dpath===null)?SYSTEM_ROOT.DATA_DIR.$name.'/':$dpath)
*/
      );
    }
    public function run(){
      return null;
    }
    public function get(){
      return null;
    }
    public function load_headers(){}
    public function pre_render_actions(){}
    public function post_render_actions(){}

    function set_content($content){
      $this->_C = $content;
    }

    function get_content(){
      return $this->_C;
    }

    function set_info($item, $value){ $this->add_info($item, $value); }
    function add_info($item, $value){
      $this->_I[$item]=$value;
    }

    function get_info($item=null){
      if($item===null)
        return $this->_I;
      else
        if(isset($this->_I[$item]))
          return $this->_I[$item];
        else
          return null;
    }
  }
?>