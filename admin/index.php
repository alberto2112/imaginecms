<?php
  //TODO ALL
  include(__DIR__.'/../config.inc');
  include(SYSTEM_ROOT.LIB_DIR.'system.lib.php');
  //include(SYSTEM_ROOT.LIB_DIR.'txtDB.php');

  includeClass('pageMaker');
  includeClass('navbarMaker');

  $_CURRENT = array();
  $_DB = array();
  $_ERROR = array('CODE'=>'200','CONTENT'=>'OK');
  $_CURRENT['WORKSPACE'] = WS_ADMIN;

  $PAGE = new pageMaker(); //'XHTML_1.0_STRICT'
  $PAGE->set_title('Admin page');

#Get site config
  $_DB['SECTIONS'] = getSystem_FileDB(SYSTEM_ROOT.FDB_DIR.FDB_ADMIN_SECTIONS);//getSections();//SYSTEM_ROOT.'sections.develtmp.inc';
  $_DB['ADMINCONFIG'] = getSystem_FileDB(SYSTEM_ROOT.FDB_DIR.FDB_ADMIN_CONF);
  $_CURRENT['LAYOUT'] = SYSTEM_ROOT.ADMIN_DIR.LAYOUTS_DIR.'imagine_admin'; //TODO

  //Algebra de bool, ley de Morgan !A · !B = !(A + B)
  if(!file_exists($_CURRENT['LAYOUT']) || !(file_exists($_CURRENT['LAYOUT'].'controller.php') || file_exists($_CURRENT['LAYOUT'].'layout.inc' )))
    $_CURRENT['LAYOUT'] = SYSTEM_ROOT.ADMIN_DIR.LAYOUTS_DIR.'base/';

  #Calcular seccion que se esta consultando
  $_CURRENT['SECTION'] = getCurrentSection(false, $_DB['SECTIONS']); # => array()
  $_CURRENT['URL'] = 'http://'.SITE_DOMAIN.PUBLIC_ROOT.ADMIN_DIR;//.$_CURRENT['SECTION']['CODSECTION'];
  $_CURRENT['URI'] = PUBLIC_ROOT.ADMIN_DIR.'?'.URI_QUERY_SECTION.'='.$_CURRENT['SECTION']['CODSECTION'];
  $_CURRENT['QUERY_STRING'] = '?'.URI_QUERY_SECTION.'='.$_CURRENT['SECTION']['CODSECTION'];
  $_CURRENT['TOOL'] = array(
    'NAME'=>$_CURRENT['SECTION']['TOOL'],
    'PATH'=>SYSTEM_ROOT.APP_DIR.$_CURRENT['SECTION']['TOOL'].'/',
    'URL'=>PUBLIC_ROOT.APP_DIR.$_CURRENT['SECTION']['TOOL'].'/'
    );

  #Parasit PreLoad actions
  //TODO

  #Definir URL absoluta de la aplicacion
  define('CURRENT_URL',$_CURRENT['URL']);
  #Definir URL relativa de la aplicacion
  define('CURRENT_URI',$_CURRENT['URI']);

//TODO
  if(includeClass('appController')===false){
    echo "ERROR including class appController";
    break;
  }

//TODO
  if(is_readable($_CURRENT['TOOL']['PATH'])===false){
    #Clear $_CURRENT['TOOL'] array
    $_CURRENT['TOOL']['PATH'] = $_CURRENT['TOOL']['URL'] = '';

    $TOOL = new appController(null);
    $TOOL->set_content("<p><strong>ERROR</strong> including TOOL class controller: ".$_CURRENT['TOOL']['NAME'].'</p>');
  }else{
    #Definir ruta absoluta PRIVADA de la aplicacion
    define('CURRENT_TOOL_PATH',$_CURRENT['TOOL']['PATH']);
    #Definir directorio PUBLICO relativo de la aplicacion
    define('CURRENT_TOOL_URL',$_CURRENT['TOOL']['URL']);
    //$TOOL = new webApp($_CURRENT['TOOL']['NAME']);

    $TOOL = new appController(
      $_CURRENT['TOOL']['NAME'],
      $_CURRENT['TOOL']['PATH'],
      $_CURRENT['TOOL']['URL'],
      PUBLIC_ROOT.ADMIN_DIR.DATA_DIR.$_CURRENT['SECTION']['CODSECTION'].'/', //TODO: Buscar un directorio de trabajo correcto
      SYSTEM_ROOT.ADMIN_DIR.DATA_DIR.$_CURRENT['SECTION']['CODSECTION'].'/' //TODO: Buscar un directorio de trabajo correcto
    );
  }

/*
  // Crear objeto navbar aqui para dar la posibilidad a los parasitos de agregar items
  if(includeFile($_CURRENT['LAYOUT'].'/navbar.class.php')===false)
    $NAVBAR = new navbarMaker();
  else
    $NAVBAR = new navbar();
*/

#Cargar layout
  if(file_exists($_CURRENT['LAYOUT'].'controller.php'))
    $PAGE->set_layout($_CURRENT['LAYOUT'].'controller.php');
  else
    $PAGE->set_layout($_CURRENT['LAYOUT'].'layout.html');

  # Load tool html headers
  $TOOL->load_headers($PAGE);

  #Parasit PostLoad actions (??)
//TODO

ob_start();

    $tool_getContent_result = $TOOL->admin_get_cPanel();//include(SYSTEM_ROOT.LIB_DIR.'cpanel.app.php');
    $ob_result = ob_get_contents();

    if(ob_end_clean() == 1)
      $PAGE->body = $ob_result;

    if($ob_result != null)
      $PAGE->body .= $tool_getContent_result;

  #APP PreRender actions
  $TOOL->pre_render_actions($PAGE);

  #Parasit PreRender actions
//TODO

  #Load TOOL actions
//TODO
  //$PAGE->replace_var('{@TOOL_CONTENT}', $TOOL->get_content(WS_ADMIN));
  //or
  //$PAGE->replace_var('{@TOOL_WORLD}', $TOOL->get_content(WS_ADMIN));

  # Render web page
  $PAGE->render();

  #APP PostRender actions
  $TOOL->post_render_actions($PAGE);

  #Parasit PostRender actions
//TODO
?>