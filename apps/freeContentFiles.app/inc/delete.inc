<?php
    $dirname = clean_file_name( get_request_param( 'dirname' ));
    $folders = $_REQUEST['folder_delme'];
    $files   = $_REQUEST['file_delme'];
    $result  = true;
/*
    echo "<pre>$dirname\n<br />";
    print_r($folders);
    echo "\n<br />";
    print_r($files);
    echo '</pre>';
*/

    # Borrar ficheros
    if(is_array($files))
        foreach($files as $file)
            $result *= unlink( clean_file_name( $iME['PATH_appdatadir'].$dirname.$file) );

    # Borrar directorios
    if(is_array($folders))
        foreach($folders as $folder)
            $result *= rmdir_recurse( clean_file_name( $iME['PATH_appdatadir'].$dirname.$folder) );

    # Redireccion usuario
    run_redirect(PATH_public.DIR_admin.'?'.$iME['URL'].'&err='.(($result==true)?'ok':'rm_failed').'&dirname='.$dirname);
    //TODO: Informar al usuario de cuales archivos/directorios no han podido ser eliminados

?>