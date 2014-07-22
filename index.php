<?php
  include('./config.inc');
  include(SYSTEM_ROOT.LIB_DIR.'system.lib.php');

  includeClass("pageMaker");
  includeClass('navbarMaker');

  //include(SYSTEM_ROOT.LIB_DIR.'txtDB.php');
  $_CURRENT = $_DB = array();
  $_ERROR = array('CODE'=>'200','CONTENT'=>'OK');
  $_CURRENT['WORKSPACE'] = WS_PUBLIC;

  $PAGE = new pageMaker(); //'XHTML_1.0_STRICT'

  $_DB['SECTIONS'] = getSections(true);//SYSTEM_ROOT.'sections.develtmp.inc';
  $_DB['SITECONFIG'] = getSystem_FileDB(SYSTEM_ROOT.DB_DIR.'site.conf.db');

//TODO -> Comprobar que el layout existe y es accesible
  $_CURRENT['LAYOUT'] = SYSTEM_ROOT.LAYOUTS_DIR.$_DB['SITECONFIG']['LAYOUT'].'/';

  //Algebra de bool, ley de Morgan !A · !B = !(A + B)
  if(!file_exists($_CURRENT['LAYOUT']) || !(file_exists($_CURRENT['LAYOUT'].'controller.php') || file_exists($_CURRENT['LAYOUT'].'layout.inc' )))
    $_CURRENT['LAYOUT'] = SYSTEM_ROOT.LAYOUTS_DIR.'base/';

  #Calcular seccion que se esta consultando
  $_CURRENT['SECTION'] = getCurrentSection(); # => array()

//TODO
  # Si la seccion que se quiere visitar no existe: muere! o cargar página de error
  if(!$_CURRENT['SECTION'])
    die("Error 404");

  $_CURRENT['URL'] = 'http://'.SITE_DOMAIN.PUBLIC_ROOT.$_CURRENT['SECTION']['CODSECTION'];
  $_CURRENT['URI'] = PUBLIC_ROOT.$_CURRENT['SECTION']['CODSECTION'];
  $_CURRENT['QUERY_STRING'] = '?';
  $_CURRENT['APP'] = array(
    'NAME'=>$_CURRENT['SECTION']['APP'],
    'PATH'=>SYSTEM_ROOT.APP_DIR.$_CURRENT['SECTION']['APP'].'.app/',
    'URL'=>PUBLIC_ROOT.APP_DIR.$_CURRENT['SECTION']['APP'].'.app/'
    );

  #Definir URL absoluta de la aplicacion
  define('CURRENT_URL',$_CURRENT['URL']);
  #Definir URL relativa de la aplicacion
  define('CURRENT_URI',$_CURRENT['URI']);

  #Parasit PreLoad actions
//TODO


//TODO
  if(includeClass('appController')===false){
    echo "ERROR including class appController";
    break;
  }

//TODO
  if(includeFile($_CURRENT['APP']['PATH'].'controller.class.php')===false){
    #Clear $_CURRENT['APP'] array
    $_CURRENT['APP']['PATH'] = $_CURRENT['APP']['URL'] = '';

    $APP = new appController(null);
    $APP->set_content("<p><strong>ERROR</strong> including APP class controller: ".$_CURRENT['APP']['NAME'].'</p>');
  }else{
    #Definir ruta absoluta PRIVADA de la aplicacion
    define('CURRENT_APP_PATH',$_CURRENT['APP']['PATH']);
    #Definir directorio PUBLICO relativo de la aplicacion
    define('CURRENT_APP_URL',$_CURRENT['APP']['URL']);
    //$APP = new webApp($_CURRENT['APP']['NAME']);
    $APP = new webApp(
      $_CURRENT['APP']['NAME'],
      SYSTEM_ROOT.APP_DIR.$_CURRENT['APP']['NAME'].'/',
      PUBLIC_ROOT.APP_DIR.$_CURRENT['APP']['NAME'].'/',
      PUBLIC_ROOT.DATA_DIR.$_CURRENT['SECTION']['CODSECTION'].'/',
      SYSTEM_ROOT.DATA_DIR.$_CURRENT['SECTION']['CODSECTION'].'/'
    );
  }

//TODO
  // Crear objeto navbar aqui para dar la posibilidad a los parasitos de agregar items
  if(includeFile($_CURRENT['LAYOUT'].'/navbar.class.php')===false)
    $NAVBAR = new navbarMaker();
  else
    $NAVBAR = new navbar();

  #Cargar layout
  if(file_exists($_CURRENT['LAYOUT'].'controller.php'))
    $PAGE->set_layout($_CURRENT['LAYOUT'].'controller.php');
  else
    $PAGE->set_layout($_CURRENT['LAYOUT'].'layout.html');

  # Load app html headers
  $APP->load_headers($PAGE);

  $PAGE->body = ''; // Celan document body tag;

  #Parasit PostLoad actions (??)
//TODO

  #Crear borrador de Navbar
  foreach($_DB['SECTIONS'] as $key=>$items){
    /**
    *   'ENABLED' = 0  => DISABLED
    *   'ENABLED' = 1  => ENABLED AND VISIBLE
    *   'ENABLED' = 2  => ENABLED AND HIDDEN
    */
//print_r($items);
//    if(substr($key,0,1)==TXTBD_DEFAULT_INDEX_MARK)
//      $key = substr($key,1);

    $item_type = 'STD';
    if($items['ENABLED']==ITEM_ENABLED){
      #DETERMINAR TIPO DE ENLACE
      if(substr($key,0,2)=='__'){
        $NAVBAR->add_item($items['LABEL'],$items['APP'],substr($key,2,4));
      }
      elseif($key==$_CURRENT['SECTION']['CODSECTION']){
        $item_type = 'ACTIVE';
        $NAVBAR->add_item($items['LABEL'],PUBLIC_ROOT.$key,$item_type);
      } else
        $NAVBAR->add_item($items['LABEL'],PUBLIC_ROOT.$key,$item_type);
      }
  }

//TODO
  $PAGE->set_title('ImagineCMS');

ob_start();
/* Viejo pero que funciona
    $app_getContent_result = null;
    $app_getContent_result = $APP->get_content($_CURRENT['SECTION']);
    if($app_getContent_result != null)
      $PAGE->body = $app_getContent_result;
    else
      $PAGE->body = ob_get_clean();
*/
  // Nuevo 05.07.2014
  $app_getContent_result = $APP->get_content();
  $ob_result = ob_get_contents();

  if(ob_end_clean()==1)
      $PAGE->body .= $ob_result;

  if($app_getContent_result != null)
      $PAGE->body .= $app_getContent_result;
  // Nuevo 05.07.2014 />

  #APP PreRender actions
  $APP->pre_render_actions($PAGE);

  #Parasit PreRender actions
//TODO

  # Navbar auto-rendering
  if($NAVBAR->ALLOW_AUTOMATED_RENDERING)
    $PAGE->replace_document_var('{@NAVBAR}', $NAVBAR->get_navbar());

  # Page rendering
  $PAGE->render();

  #APP PostRender actions
  $APP->post_render_actions($PAGE);

  #Parasit PostRender actions
//TODO
 ?>