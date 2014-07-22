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
        'DIR'=>$url,
        'DATA_DIR'=>$ddir,
        'DATA_PATH'=>$dpath
      );
    }
    public function run(){
      return null;
    }
    public function get(){
      return null;
    }
    public function load_headers($page_obj){}
    public function pre_render_actions($page_obj){}
    public function post_render_actions($page_obj){}

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

    //Admin functions
    function admin_get_content(){
      return null;
    }

    function admin_action($action='default'){
      return null;
    }

    //Alias of admin_action()
    function admin_run(){ $this->admin_action('run'); }
    function admin_get(){ $this->admin_action('get'); }
    function admin_push(){ $this->admin_action('push'); }
  }
?>