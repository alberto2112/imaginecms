<?php
  class appController
  {

    protected $_I = array();
    protected $_C = '';
    private $_VARS = array();

    function __construct($name, $path=null, $url='', $ddir='', $dpath=''){
      $this->_I = array(
        'NAME'=>$name,
        'PATH'=>(($path===null)?realpath( dirname(__FILE__)).'/': $path),
        'URL'=>$url,
        'DIR'=>$url,
        'DATA_DIR'=>$ddir,
        'DATA_PATH'=>$dpath
      );
      $this::include_method('constructor.inc');
    }

    public function __set($name, $value){
      return $this->_VARS[$name] = $value;
    }

    public function __get($name){
      if (array_key_exists($name, $this->_VARS))
          return $this->_VARS[$name];
      else
          return null;
    }

    public function run(){
      return null;
    }
    public function get(){
      return null;
    }

    public function API($args){
      return null;
    }

    public function load_headers($page_obj){
      $this::include_method('loadHeaders.inc');
    }

    public function pre_render_actions($page_obj){
      $this::include_method('preRender.inc');
    }

    public function post_render_actions($page_obj){
      $this::include_method('postRender.inc');
    }

    function set_content($content){
      $this->_C = $content;
    }

    function get_content(){
      //OLD >> return $this->_C;
      $this::include_method('getContent.inc', $this->_C);
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
    function admin_get_content(){ //TOERASE
      $this::include_method('adminContent.inc');
    }

    function admin_get_cPanel(){ //TODO
      $this::include_method('admin_cPanel.inc');
    }

    function admin_action($action='default'){
      return null;
    }

    //Alias of admin_action()
    function admin_run(){ $this->admin_action('run'); }
    function admin_get(){ $this->admin_action('get'); }
    function admin_push(){ $this->admin_action('push'); }

// ------------------------------------------------------------------------

    protected function include_method($method, $returnIfError=false){
      if(file_exists($this->_I['PATH'].$method))
        return include $this->_I['PATH'].$method;
      else
        return $returnIfError;
    }
  }
?>