<?php
  class navbar extends navbarMaker{
    public $_NAVBAR_ITEMS = array();
//========================================
    function add_item($label,$link,$type='STD',$custom_param=false){
      array_push($this->_NAVBAR_ITEMS, array('LABEL'=>$label,'LINK'=>$link, 'TYPE'=>$type));
//print_r($this->_NAVBAR_ITEMS);
    }
//--------------------------------------------------------------------------------------
    function remove_item($label){ //TODO
    }
//--------------------------------------------------------------------------------------
    function get_navbar($_echo=false){
//print_r($this->_NAVBAR_ITEMS);
      $NAVBAR = '<ul>';
      foreach($this->_NAVBAR_ITEMS as $key=>$item){
        if($item['TYPE'] == 'LINK')
          $NAVBAR .= '<li><a class="navbar-external" href="'.$item['LINK'].'">'.$item['LABEL'].'</a></li>';
        elseif($item['TYPE'] == 'TEXT')
          $NAVBAR .= '<li><span>'.$item['LABEL'].'</span></li>';
        elseif($item['TYPE'] == 'ACTIVE')
          $NAVBAR .= '<li class="selected"><a href="#">'.$item['LABEL'].'</a></li>';
        else
          $NAVBAR .= '<li><a href="'.$item['LINK'].'">'.$item['LABEL'].'</a></li>';
      }
      $NAVBAR .= '</ul>';

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