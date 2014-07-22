<?php
    global $_CURRENT;
    include $_CURRENT['LAYOUT'].'/navbar.class.php';

    $NAVBAR = new navbar();
    foreach(getAdminSections(true) as $value){
      $icon=PUBLIC_PATH.APP_DIR.$value['TOOL'].'/icons/app_128.png';
      //TODO >> Si la aplicacion no tiene icono, seleccionar un icono estandar
      $NAVBAR->add_item($value['NAME'],$value['CODSECTION'],'STD',$icon);
    }

    $my_layout = file_get_contents('layout.html', true);
    $my_layout = str_replace('{@NAVBAR}', $NAVBAR->get_navbar(),$my_layout);
    //str_replace('{@NAVBAR}', $NAVBAR->get_navbar(),file_get_contents('layout.html', true));
    return $my_layout;
?>