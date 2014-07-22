<?php
    require_once(PATH_private.'lib/pclzip.lib.php');

    $dirname = get_request_param('dirname');

    # Protecciones
    $dirname  = clean_file_name( '/'.$dirname );
    $workpath = clean_file_name($iME['PATH_appdatadir'].$dirname.'/');
    #Comprobar que el directorio de destino es escribible
    //TODO
    if(!empty($_FILES['file']['tmp_name']) && strlen( $dirname ) > 0 && is_writable( $workpath ) && $_FILES['file']['type']=='application/zip'){
        $file = new PclZip($_FILES['file']['tmp_name']);
        if ($file->extract(PCLZIP_OPT_PATH,$workpath) == 0) die("Error : ".$file->errorInfo(true));
        $file = null;
        run_redirect(PATH_public.DIR_admin.'?'.$iME['URL'].'&err=ok&dirname='.$dirname);
    }
    else
        run_redirect(PATH_public.DIR_admin.'?'.$iME['URL'].'&err=upload_error&dirname='.$dirname);
?>