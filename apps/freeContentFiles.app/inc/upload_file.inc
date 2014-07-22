<?php
    $dirname = get_request_param('dirname');

    # Protecciones
    $dirname = clean_file_name( '/'.$dirname );
    #Comprobar que el directorio de destino es escribible
    //TODO
    if(!empty($_FILES['file']['tmp_name']) && strlen($dirname)>0 ){
        $workpath = clean_file_name($iME['PATH_appdatadir'].$dirname.'/');
        $counter = 0;$file_sufix='';
        $file_basename  = substr($_FILES['file']['name'],0,(stripos($_FILES['file']['name'],'.')));
        $file_extension = substr($_FILES['file']['name'], strlen($file_basename));
        while (false !== (file_exists($workpath.$file_basename.$file_sufix.$file_extension))) {
            $counter++;
            $file_sufix='_'.substr('00',strlen("$counter")).$counter;
        }
        copy($_FILES['file']['tmp_name'], $workpath.string2friendly($file_basename.$file_sufix.$file_extension));
        run_redirect(PATH_public.DIR_admin.'?'.$iME['URL'].'&err=ok&dirname='.$dirname);
    }
    else
        run_redirect(PATH_public.DIR_admin.'?'.$iME['URL'].'&err=upload_error&dirname='.$dirname);
?>