<?php
    $force_read = getRequest_param('force_read',false);
    if(!empty($actual_dir))
        $actual_dir = "/$actual_dir";

    if($filename && is_readable($iME['PATH_appdatadir'].$actual_dir.$filename) && is_file($iME['PATH_appdatadir'].$actual_dir.$filename))
    {
        if(filesize($iME['PATH_appdatadir'].$actual_dir.$filename)>524288 && $force_read==false) # 512Ko
            return '<div class="textarea"><a href="'.PATH_public.DIR_admin.'?'.$iME['LINK'].'&dirname='.$dirname.'&filename='.$filename.'&force_read=true" class="button">Forzar lectura de archivo</a></div>';
        else
            return '<textarea name="file_content">'.htmlspecialchars(file_get_contents($iME['PATH_appdatadir'].$actual_dir.$filename,FILE_TEXT)).'</textarea>';
    }
    else
        return '<div class="textarea">&nbsp;</div>';
?>
