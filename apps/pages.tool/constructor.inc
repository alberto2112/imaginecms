<?php
  include __DIR__.'/vars.inc';

  switch(getRequest_param('action', 'default')){
  case 'manage':
    $this->LEVEL = L_EDIT;
    break;
  default:
    $this->LEVEL = L_GENERAL;
}
?>