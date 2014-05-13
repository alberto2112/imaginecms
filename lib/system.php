<?php
  #Requires /config.inc
  if(!defined("SYSTEM_ROOT"))
    require(realpath( dirname(__FILE__).'/../config.inc'));
//=======================================================
  function includeClass($className, $sysClass = true){
    if($sysClass)
      $className = SYSTEM_ROOT.LIB_DIR.'class.'.$className.'.php';
    #Si existe, incluir y devolver: True
    return includeFile($className);
  }

//-------------------------------------------------------

  function includeInterface($interfaceName, $sysInterface = true){
    if($sysInterface)
      $interfaceName = SYSTEM_ROOT.LIB_DIR.'interface.'.$interfaceName.'.php';
    return includeFile($interfaceName);
  }

//-------------------------------------------------------

  function includeFile($fileName){
  #Si existe, incluir y devolver: True
    if(file_exists($fileName))
    {
      include($fileName);
      return true;
    } else {
    #En caso contrario, devolver: False
      return false;
    }
  }
//-------------------------------------------------------
  function getRequest_param( $query_string, $return_if_false = null )
    {
        return (@(isset( $_REQUEST[$query_string] ) &&  $_REQUEST[$query_string] !=='' || $_REQUEST[$query_string]===0 ) ? trim(strip_tags($_REQUEST[$query_string])) : $return_if_false);
    }
//-------------------------------------------------------
  function getSystem_FileDB($DBFile){
    #Si existe fichero, leer, parsear y devolver
    if(file_exists("$DBFile")){
      $txtDB = array();
      $fh = fopen($DBFile, "rb");

      while (!feof($fh) ) {
        $line = fgets($fh);
        if(substr($line,0,1)!='#'){
          $items = explode(':|:', $line);
          if(count($items) > 2)
            $txtDB[array_shift($items)] = preg_replace('#[\r\n]#', '', $items);
          elseif(count($items) == 2)
            $txtDB[$items[0]]=preg_replace('#[\r\n]#', '',$items[1]);
          elseif(count($items) == 1)
            $txtDB[$items[0]]='';
        }
      }

      fclose($fh);
      return $txtDB;
    } else
      return false;
  }
//-------------------------------------------------------

  function getSections(){
  /**
  * %alias of self::getSystem_FileDB
  */
    return getSystem_FileDB(SYSTEM_ROOT.DB_DIR.'sections.db');
  }

//-------------------------------------------------------

  function getCurrentSection($uri_query_string, $db_sections = false){
  /**
  * @require self::getSections();
  * @return array()
  */
    $result = getRequest_Param($uri_query_string, '__DEFAULT');
    $dbs = (is_array($db_sections))? $db_sections : getSections();

    if($result=='__DEFAULT'){
      return array('NAME'=>$dbs[$result][TXTBD_INDEX_NAME],
                   'LABEL'=>$dbs[ $dbs[$result][TXTBD_INDEX_NAME] ][TXTBD_INDEX_LABEL],
                   'APP'=>$dbs[ $dbs[$result][TXTBD_INDEX_NAME] ][TXTBD_INDEX_APP],
                   'ENABLED'=>'1'); //FORCE ENABLED
    }else {
      foreach( $dbs as $key=>$items){
        if($key==$result)
        {
          return array('NAME'=>$key, 'LABEL'=>$items[TXTBD_INDEX_LABEL], 'APP'=>$items[TXTBD_INDEX_APP], 'ENABLED'=>"{$items[TXTBD_INDEX_ENABLED]}");
          break;
        }
      }
    }
    return array();
  }
?>