<?php
  class navbar extends navbarMaker{
    public $_NAVBAR_ITEMS = array();
//========================================
    function add_item($label,$link,$type='STD',$icon=false){
      array_push($this->_NAVBAR_ITEMS, array('LABEL'=>$label,'LINK'=>$link, 'TYPE'=>$type, 'ICON'=>$icon));
    }
//--------------------------------------------------------------------------------------
    function remove_item($label){ //TODO
    }
//--------------------------------------------------------------------------------------
    function get_navbar($_echo=false){
      $NAVBAR = '<ul>';
      foreach($this->_NAVBAR_ITEMS as $key=>$item){
        $icon_tag = ($item['ICON']===false)? $item['LABEL'] : '<img width="64" height="64" src="'.$item['ICON'].'" alt="'.$item['LABEL'].'" />';
        if($item['TYPE'] == 'EXTERNAL' || $item['TYPE'] == 'LINK')
          $NAVBAR .= '<li><a class="navbar-external" href="'.$item['LINK'].'">'.$item['LABEL'].'</a></li>';
        elseif($item['TYPE'] == 'TEXT')
          $NAVBAR .= '<li><span>'.$item['LABEL'].'</span></li>';
        elseif($item['TYPE'] == 'ACTIVE')
          $NAVBAR .= '<li class="active">'.$icon_tag.'</li>';
        else
          $NAVBAR .= '<li><a href="?'.URI_QUERY_SECTION.'='.$item['LINK'].'">'.$icon_tag.'</a></li>';
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