<?php
    $dirname    = get_request_param('dirname',false);
    $foldername = basename(get_request_param('foldername',false));

    # Protecciones
    $foldername = string2friendly(clean_file_name( $foldername ));
    $dirname    = clean_file_name( $dirname);

    if($foldername && $dirname)
    {
        //print 'Crear en: '.$iME['PATH_appdatadir'].ltrim($dirname,'/');
        if( @mkdir( $iME['PATH_appdatadir'].ltrim($dirname,'/').$foldername ))
            run_redirect(PATH_public.DIR_admin.'?'.$iME['URL'].'&err='.$foldername.'&dirname='.$dirname);
        else
            run_redirect(PATH_public.DIR_admin.'?'.$iME['URL'].'&err=mkdir_failed&dirname='.$dirname);
    }
    else
        run_redirect(PATH_public.DIR_admin.'?'.$iME['URL'].'&err=empty_name&dirname='.$dirname);
?>