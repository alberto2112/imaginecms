<?php
  include __DIR__.'/vars.inc';
  include __DIR__.'/functions.lib.php';

  switch($this->LEVEL){
  case L_EDIT:
    $code = getRequest_param('code', false);
    //$this->LEVEL = L_EDIT;
    if($code===false){
      print '<h2>ERROR</h2>'; //TODO
    } else {
      print '<h1>Editting: '.$code.'</h1>';
      get_app_adminContent($code);
    }
    break;

  default:
    $this->LEVEL = L_GENERAL;
    print '<h1>List of pages</h1>';
    get_list();
}
?>