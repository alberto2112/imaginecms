<?php
  #Requires /config.inc
  if(!defined("SYSTEM_ROOT"))
    require(realpath( dirname(__FILE__).'/../config.inc'));
//=======================================================
  function includeClass($className, $sysClass = true){
//TODO
    if($sysClass)
      $className = SYSTEM_ROOT.LIB_DIR.$className.'.class.php';
    return includeFile($className);
  }

//-------------------------------------------------------

  function includeInterface($interfaceName, $sysInterface = true){
//TODO
    if($sysInterface)
      $interfaceName = SYSTEM_ROOT.LIB_DIR.$interfaceName.'.interface.php';
    return includeFile($interfaceName);
  }

//-------------------------------------------------------

  function includeAPI($app_name){
//TODO
    if($app_name)
      $interfaceName = SYSTEM_ROOT.APP_DIR.$app_name.'/api.php';
    return includeFile($interfaceName);
  }

//-------------------------------------------------------

  function includeFile($fileName){
  #Si existe, incluir y devolver: True
    if(file_exists($fileName))
    {
      include $fileName;
      return true;
    } else {
    #En caso contrario, devolver: False
      return false;
    }
  }
//-------------------------------------------------------
  function first_array_key($a) { foreach ($a as $k => $v) return $k; }

//-------------------------------------------------------
//TODO
  function sort_FileDB($dbfile, array $index, $key=null){
  /**
   * - Abrir fichero $dbfile
   * - Ordenar columnas segun $key. Si $key == null, ordenar segun la primera columna
   * - Ir volcando nuevo fichero generado en $dbfile.new
   * - Eliminar (si existe) $dbfile.old y renombrar $dbfile a $dbfile.old
   * - Renombrar $dbfile.new a $dbfile
   */
  }

/**
 * GETTERS
 ***********/
//-------------------------------------------------------
  function getRequest_param( $query_string, $return_if_false = null )
    {
        return (@(isset( $_REQUEST[$query_string] ) &&  $_REQUEST[$query_string] !=='' || $_REQUEST[$query_string]===0 ) ? trim(strip_tags($_REQUEST[$query_string])) : $return_if_false);
    }
//-------------------------------------------------------
  function getSystem_FileDB($DBFile, $del_default_marker = false){
    #Si existe fichero, leer, parsear y devolver
    if(file_exists("$DBFile")){
      $arrDB = array();
      $headers = array();
      $fh = fopen($DBFile, "rb");
      //$i=0;

      while (!feof($fh) ) {
        $line = fgets($fh);
        $line = preg_replace('#[\r\n]#', '', $line);
        if(substr($line,0,1) == '#')
          $headers = explode(' ', substr($line,1));
        //elseif(substr($line,0,1) !='!') -> lo que hay dentro del siguiente if
        elseif(substr($line,0,1)!='!'){
          $items = explode(':|:', $line);
          if(count($items) > 2){
            $master_header = ($del_default_marker && strpos($items[0],TXTBD_DEFAULT_INDEX_MARK)===0)? substr($items[0],1) : $items[0]; //$items[0];
            foreach($items as $key=>$value){
              $arrDB[$master_header][$headers[$key]] = (strpos($value,TXTBD_DEFAULT_INDEX_MARK)===0)? substr($value,1) : $value;
              //$arrDB[$i][$headers[$key]] = $value;
            }
            //$i++;
          }elseif(count($items) == 2)
            $arrDB[$items[0]]=$items[1];
          elseif(count($items) == 1)
            $arrDB[$items[0]]='';
        }
      }

      fclose($fh);
      return $arrDB;
    } else
      return false;
  }
//-------------------------------------------------------
  function getSections($del_default_marker = false){
  /**
  * %alias of self::getSystem_FileDB
  */
    return getSystem_FileDB(SYSTEM_ROOT.DB_DIR.'sections.db', $del_default_marker);
  }
//-------------------------------------------------------
  function getAdminSections($del_default_marker = false){
  /**
  * %alias of self::getSystem_FileDB
  */
    return getSystem_FileDB(SYSTEM_ROOT.DB_DIR.'admin_sections.db', $del_default_marker);
  }
//-------------------------------------------------------
//TODO
  function getDevice(){
  /**
   * return int
  */
  }

//-------------------------------------------------------

  function getCurrentSection($codSection=false, $db_sections = false){
  /**
  * @require self::getSections();
  * @return array()
  */
    if(!$codSection)
      $codSection = getRequest_Param(URI_QUERY_SECTION, '__DEFAULT');

    $dbs = (is_array($db_sections))? $db_sections : getSections();

    if($codSection=='__DEFAULT'){
      foreach($dbs as $key => $value){
        if(substr($key,0,1)==TXTBD_DEFAULT_INDEX_MARK)
          return $dbs[ $key ];
      }
/*
      $hd=(in_admin)? $dbs['__DEFAULT'][TXTBD_INDEX_CODTOOL] : $dbs['__DEFAULT'][TXTBD_INDEX_CODSECTION];
      return $dbs[ $hd ];
*/
    }elseif(array_key_exists($codSection, $dbs)){
      return $dbs[ $codSection ];
    }elseif(array_key_exists(TXTBD_DEFAULT_INDEX_MARK.$codSection, $dbs)){
      return $dbs[ TXTBD_DEFAULT_INDEX_MARK.$codSection ];
    } else
      return false;
  }
?>