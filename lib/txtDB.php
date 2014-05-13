<?php
  #Requires /config.inc
  if(!defined("SYSTEM_ROOT"))
    require(realpath( dirname(__FILE__).'/../config.inc'));

  function getSections($dbFile)
  {
  /**
   * @return array();
   */
    #Si existe fichero, leer, parsear y devolver
    if(file_exists($dbFile)){
      $txtDB = array();
      $fh = fopen($dbFile, "rb");

      while (!feof($fh) ) {
        $line = fgets($fh);
        if(substr($line,0,1)!='#'){
          $items = explode(':|:', $line);
          $txtDB[$items[0]] = array_shift($items);
        }
      }

      fclose($fh);
      return $txtDB;
    } else
      return false;
  }
?>