<?php
  class navbarMaker{
    public $_NAVBAR_ITEMS = array();
//========================================
    function add_item($label,$link,$type='STD',$custom_param=false){
      //array_merge($this->_NAVBAR_ITEMS, array('LABEL'=>$label,'LINK'=>$link));
      array_push($this->_NAVBAR_ITEMS, array('LABEL'=>$label,'LINK'=>$link,'TYPE'=>$type));
      //$this->_NAVBAR_ITEMS += array('LABEL'=>$label,'LINK'=>$link);
    }
//--------------------------------------------------------------------------------------
    function remove_item($label){ //TODO
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