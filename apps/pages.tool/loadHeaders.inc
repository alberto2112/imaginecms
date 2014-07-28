<?php
  global $PAGE;
  include __DIR__.'/vars.inc';

  if($this->LEVEL == L_GENERAL){
    $PAGE->add_css($this->get_info('URL').'css/styles.css');
    $PAGE->add_js($this->get_info('URL').'js/general.js');
  }
?>