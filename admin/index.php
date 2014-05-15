<?php
  //TODO ALL
  include('../config.inc');
  include(SYSTEM_ROOT.LIB_DIR.'system.php');
  //include(SYSTEM_ROOT.LIB_DIR.'txtDB.php');
  $_CURRENT = array();

  $_DB['SECTIONS'] = getSystem_FileDB(SYSTEM_ROOT.DB_DIR.'admin_sections.db');//getSections();//SYSTEM_ROOT.'sections.develtmp.inc';
  //$_DB['SITECONFIG'] = ; //TODO

  #Get site config
  $_CURRENT['LAYOUT'] = SYSTEM_ROOT.LAYOUTS_DIR.'imagine_admin'; //TODO

  #Calcular seccion que se esta consultando
  $_CURRENT['SECTION'] = getCurrentSection(URI_QUERY_MODULE, $_DB['SECTIONS']);
  $_CURRENT['APP'] = $_CURRENT['SECTION']['APP'];

  #Definir ruta absoluta PRIVADA de la aplicacion
  define('CURRENT_APP_PATH',SYSTEM_ROOT.APP_DIR.$_CURRENT['APP'].'/');
  #Definir directorio PUBLICO relativo de la aplicacion
  define('CURRENT_APP_URL',PUBLIC_ROOT.APP_DIR.$_CURRENT['APP'].'/');
  #Definir URL absoluta de la aplicacion
  define('CURRENT_URL','http://'.SITE_DOMAIN.PUBLIC_ROOT.$_CURRENT['SECTION']['NAME']);
  #Definir URL relativa de la aplicacion
  define('CURRENT_REL_URL',PUBLIC_ROOT.$_CURRENT['SECTION']['NAME']);

  #Parasit PreLoad actions
  //TODO

  includeClass("webMaker");
  includeClass('appController');
  includeFile(CURRENT_APP_PATH.'controller.php');

  if(!includeFile($_CURRENT['LAYOUT'].'/navbar.php'))
    includeClass('navbarMaker');

  $APP = new webApp($_CURRENT['SECTION']['APP']);
  $PAGE = new webMaker(); //'XHTML_1.0_STRICT'
  $NAVBAR = new navbarMaker();

  #Parasit PostLoad actions
  //TODO

  #Cargar layout
  $PAGE->set_layout($_CURRENT['LAYOUT'].'/layout.html');

  #Crear Navbar
  foreach($_DB['SECTIONS'] as $key=>$items){
    /**
    *   'ENABLED' = 0  => DISABLED
    *   'ENABLED' = 1  => ENABLED AND VISIBLE
    *   'ENABLED' = 2  => ENABLED AND HIDDEN
    */
    $item_type = 'STD';
    if($key != '__DEFAULT' && $items[TXTBD_INDEX_ENABLED]==ITEM_ENABLED){
      #DETERMINAR TIPO DE ENLACE
      if(substr($key,0,6)=='__LINK'){
        $item_type = 'EXTERNAL';
        $NAVBAR->add_item($items[TXTBD_INDEX_LABEL],$items[TXTBD_INDEX_LINK],$item_type);
      }elseif($key==$_CURRENT['SECTION']['NAME']){
        $item_type = 'ACTIVE';
        $NAVBAR->add_item($items[TXTBD_INDEX_LABEL],PUBLIC_ROOT.$key,$item_type);
      } else
        $NAVBAR->add_item($items[TXTBD_INDEX_LABEL],PUBLIC_ROOT.ADMIN_DIR.'?'.URI_QUERY_MODULE.'='.$key,$item_type);
      }
  }

  @$PAGE->set_title('ImagineCMS'); //TODO
  $PAGE->body = $APP->get_content($_CURRENT['SECTION']);

  #APP PreRender actions
  $APP->load_headers();
  $APP->pre_render_actions();

  #Parasit PreRender actions
  //TODO

  $PAGE->replace_document_vars('{@NAVBAR}', $NAVBAR->get_navbar());
  $PAGE->render();

  #APP PostRender actions
  $APP->post_render_actions();

  #Parasit PostRender actions
  //TODO
 ?>