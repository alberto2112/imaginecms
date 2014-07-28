<?php
  include(__DIR__.'/config.inc');
  include(SYSTEM_ROOT.LIB_DIR.'system.lib.php');
  //print_r($_REQUEST);

  // Obtener datos de seccion
  $S = getCurrentSection($_REQUEST['app']);

  // Redirigir //TODO
  header('Location: http://'.SITE_DOMAIN.PUBLIC_ROOT.APP_DIR.$S['APP'].'.app/'.$_REQUEST['appres']);
?>