 <?php
  include('./config.inc');
  include(SYSTEM_ROOT.LIB_DIR.'system.php');
  //include(SYSTEM_ROOT.LIB_DIR.'txtDB.php');
  $_CURRENT = $_DB = array();
  $_ERROR = array('CODE'=>'200','CONTENT'=>'OK');

  $_DB['SECTIONS'] = getSections();//SYSTEM_ROOT.'sections.develtmp.inc';
  $_DB['SITECONFIG'] = getSystem_FileDB(SYSTEM_ROOT.DB_DIR.'site.db');

  #Get site config
  $_CURRENT['LAYOUT'] = SYSTEM_ROOT.LAYOUTS_DIR.$_DB['SITECONFIG']['LAYOUT']; //TODO -> Comprobar que el layout existe y es accesible

  #Calcular seccion que se esta consultando
  $_CURRENT['SECTION'] = getCurrentSection(URI_QUERY_SECTION, $_DB['SECTIONS']); # => array()
  $_CURRENT['URL'] = 'http://'.SITE_DOMAIN.PUBLIC_ROOT.$_CURRENT['SECTION']['NAME'];
  $_CURRENT['RELATIVE_URL'] = PUBLIC_ROOT.$_CURRENT['SECTION']['NAME'];
  $_CURRENT['APP'] = array(
    'NAME'=>$_CURRENT['SECTION']['APP'],
    'PATH'=>SYSTEM_ROOT.APP_DIR.$_CURRENT['SECTION']['APP'].'/',
    'URL'=>PUBLIC_ROOT.APP_DIR.$_CURRENT['SECTION']['APP'].'/'
    );
  #Definir URL absoluta de la aplicacion
  define('CURRENT_URL',$_CURRENT['URL']);
  #Definir URL relativa de la aplicacion
  define('CURRENT_REL_URL',$_CURRENT['RELATIVE_URL']);

  #Parasit PreLoad actions
  //TODO

  includeClass("webMaker");
//TODO
  if(includeClass('appController')===false){
    echo "ERROR including class appController";
    break;
  }

//TODO
  if(includeFile($_CURRENT['APP']['PATH'].'controller.php')===false){
    #Clear $_CURRENT['APP'] array
    $_CURRENT['APP']['PATH'] = $_CURRENT['APP']['URL'] = '';

    $APP = new appController(null);
    $APP->set_content("<p><strong>ERROR</strong> including APP class controller: ".$_CURRENT['APP']['NAME'].'</p>');
  }else{
    #Definir ruta absoluta PRIVADA de la aplicacion
    define('CURRENT_APP_PATH',$_CURRENT['APP']['PATH']);
    #Definir directorio PUBLICO relativo de la aplicacion
    define('CURRENT_APP_URL',$_CURRENT['APP']['URL']);
    $APP = new webApp(
      $_CURRENT['APP']['NAME'],
      SYSTEM_ROOT.APP_DIR.$_CURRENT['APP']['NAME'].'/',
      PUBLIC_ROOT.APP_DIR.$_CURRENT['APP']['NAME'].'/',
      PUBLIC_ROOT.DATA_DIR.$_CURRENT['SECTION']['NAME'].'/',
      SYSTEM_ROOT.DATA_DIR.$_CURRENT['SECTION']['NAME'].'/'
    );
  }

//TODO
  if(includeFile($_CURRENT['LAYOUT'].'/navbar.php')===false)
    includeClass('navbarMaker');


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
      if(substr($key,0,2)=='__'){
        $NAVBAR->add_item($items[TXTBD_INDEX_LABEL],$items[TXTBD_INDEX_LINK],substr($key,2,4));
      }
/*
      if(substr($key,0,6)=='__LINK'){
        $item_type = 'LINK';
        $NAVBAR->add_item($items[TXTBD_INDEX_LABEL],$items[TXTBD_INDEX_LINK],$item_type);
      }elseif(substr($key,0,6)=='__TEXT'){
        $item_type = 'TEXT';
        $NAVBAR->add_item($items[TXTBD_INDEX_LABEL],$items[TXTBD_INDEX_LINK],$item_type);
      }
*/
      elseif($key==$_CURRENT['SECTION']['NAME']){
        $item_type = 'ACTIVE';
        $NAVBAR->add_item($items[TXTBD_INDEX_LABEL],PUBLIC_ROOT.$key,$item_type);
      } else
        $NAVBAR->add_item($items[TXTBD_INDEX_LABEL],PUBLIC_ROOT.$key,$item_type);
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