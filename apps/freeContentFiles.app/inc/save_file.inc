<?php
/*
<h2>Save file!</h2>
<p>File: <?php echo get_request_param('dirname', 'null').basename(get_request_param('filename', 'null')); ?></p>
<pre style="border:2px #CCC solid;background-color:#FFF4D8;padding:3px;">
<?php print htmlentities($_REQUEST['file_content']); ?>
</pre>
*/
    $dirname = get_request_param('dir_name', 'null');
    $filename = basename(get_request_param('file_name', 'null'));  # Se utiliza basename para proteger de posibles ataques

    # Protecciones
    $filename = clean_file_name( $filename);
    $dirname = clean_file_name( $dirname);

    # Escribir fichero
    if($filename && is_writable($iME['PATH_appdatadir'].$dirname))
    {
        //print 'Escribir en: '.$iME['PATH_appdatadir'].$dirname.$filename;
            
        # Escribir archivo
        $fp = fopen($iME['PATH_appdatadir'].ltrim($dirname,'/').ltrim($filename,'/'), 'w+');
        if (get_magic_quotes_gpc())
            fwrite($fp,stripslashes( $_REQUEST['file_content'] ));
        else
            fwrite($fp, $_REQUEST['file_content'] );
        
        fclose($fp);
    }

    run_redirect(PATH_public.DIR_admin.'?'.$iME['URL'].'&dirname='.$dirname.'&filename='.$filename);
?>