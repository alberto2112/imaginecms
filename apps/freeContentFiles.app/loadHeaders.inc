<?php
  global $_CURRENT, $PAGE;
  if($_CURRENT['WORKSPACE'] == WS_ADMIN){
    $PAGE->add_css($this->get_info('DIR').'workspace.css');
    //$P->add_js($this->get_info('DIR').'js/mootools-core.1.2.3.js');
    //$P->add_js($this->get_info('DIR').'js/mootools-dialog.js');
    //$P->add_js($this->get_info('DIR').'js/formutils.js');
  } else
    $PAGE->add_css($this->get_info('DIR').'culo.css');
?>