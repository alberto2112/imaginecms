<?php
  define('SITE_DOMAIN','localhost');
  define('PUBLIC_ROOT','/imaginecms/');

  define('DATA_DIR','data/');
  define('LIB_DIR','lib/');
  define('FDB_DIR','imagine_db/');
  define('APP_DIR','apps/');
  define('LAYOUTS_DIR','layout/');
  define('ADMIN_DIR','admin/');
  define('WORKSPACE_DIR','data/workspace/');
  define('SOFTWARE_DIR','software/');

  define('FDB_PUBLIC_SECTIONS','public_sections.db');
  define('FDB_ADMIN_SECTIONS','admin_sections.db');
  define('FDB_APPS','apps.db');
  define('FDB_SITE_CONF','site.conf.db');
  define('FDB_ADMIN_CONF','admin.conf.db');

  define('DB_server','localhost');
  define('DB_user','pruebas');
  define('DB_password','privado');
  define('DB_database','mycms');
  define('DB_port','3306');

  define('OPT_HTACCESS_SUPPORT',true);
  define('OPT_DEVELOPPING',true);

  define('URI_QUERY_SECTION','s');
  //define('URI_QUERY_MODULE','mod');

# ======================================================= #
  define('SYSTEM_ROOT',realpath( dirname(__FILE__)).'/');

  $PHP_SELF = $_SERVER['PHP_SELF'];
  if ( empty($PHP_SELF) )
      $_SERVER['PHP_SELF'] = $PHP_SELF = preg_replace( "/(\?.*)?$/", '', $_SERVER["REQUEST_URI"] );

  define('SYSTEM_PATH',SYSTEM_ROOT);
  define('SYSTEM_DIR',SYSTEM_ROOT);
  define('PUBLIC_PATH',PUBLIC_ROOT);
  define('PUBLIC_DIR',PUBLIC_ROOT);

  define('TXTBD_INDEX_CODSECTION','CODSECTION');
  define('TXTBD_DEFAULT_INDEX_MARK','*');
  define('TXTBD_INDEX_LABEL',0);
  define('TXTBD_INDEX_NAME',0);
  define('TXTBD_INDEX_APP',1);
  define('TXTBD_INDEX_LINK','APP');
  define('TXTBD_INDEX_ENABLED',2);

  define('ITEM_DISABLED','0');
  define('ITEM_ENABLED','1');
  define('ITEM_HIDDEN','2');

  //WORKSPACES
  define('WS_PUBLIC',0);
  define('WS_ADMIN',1);
?>