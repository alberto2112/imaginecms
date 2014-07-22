<?php
    $dirname  = get_request_param('dirname', false);
    $filename = basename(get_request_param('filename', false));  # Se utiliza basename para proteger de posibles ataques

    # Protecciones
    $filename       = clean_file_name( string2friendly( $filename ));
    $dirname        = clean_file_name( $dirname);
    $abs_filename   = $iME['PATH_appdatadir'].ltrim($dirname,'/').ltrim($filename,'/');

    # Escribir fichero
    if($dirname && $filename && !file_exists( $abs_filename ) && is_writable( $iME['PATH_appdatadir'].$dirname ))
    {
        $fp = fopen( $abs_filename, 'w+');
        fwrite($fp, ' ');
        fclose($fp);
    }
    run_redirect(WEB_admin.'?'.$iME['URL'].'&dirname='.$dirname.'&filename='.$filename);
?>
