<?php
  class navbarMaker{
    public $_NAVBAR_ITEMS = array();
    public $ALLOW_AUTOMATED_RENDERING = true;
//========================================
    function add_item($label,$link,$type='STD',$custom_param=false){
      array_push($this->_NAVBAR_ITEMS, array('LABEL'=>$label,'LINK'=>$link,'TYPE'=>$type));
    }
//--------------------------------------------------------------------------------------
    function remove_item($label){ //TODO
    }
//--------------------------------------------------------------------------------------
    function enable_autorender(){
      $this->ALLOW_AUTOMATED_RENDERING = true;
    }
//--------------------------------------------------------------------------------------
    function disable_autorender(){
      $this->ALLOW_AUTOMATED_RENDERING = false;
    }
//--------------------------------------------------------------------------------------
    function clean(){
      $this->_NAVBAR_ITEMS = array();
    }
//--------------------------------------------------------------------------------------
    function get_navbar($_echo=false){
      $NAVBAR = '<div class="navbar"><ul>';
      foreach($this->_NAVBAR_ITEMS as $key=>$item){
        if($item['TYPE'] == 'TEXT')
          $NAVBAR .= '<li><span>'.$item['LABEL'].'</span></li>';
        else
          $NAVBAR .= '<li><a href="'.$item['LINK'].'">'.$item['LABEL'].'</a></li>';
      }
      $NAVBAR .= '</ul></div>';

      if($_echo)
        print $NAVBAR;
      else
        return $NAVBAR;
    }
//--------------------------------------------------------------------------------------
    function render(){
      $this->get_navbar(true);
    }
  }
?>