<?php
  class webApp extends appController{
    //function __construct(){}
    function get_content(){
      return "<h1>CODSECTION: ".$this->info['CODSECTION'].'</h1>';
    }
  }
?>