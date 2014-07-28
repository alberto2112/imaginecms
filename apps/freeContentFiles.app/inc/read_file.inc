<?php
    $force_read = getRequest_param(QS_FORCE_FLREAD,false);
    $filename = $this->get_info('DATA_PATH').$actual_dir.$filename;

    if(!$filename===false && is_readable($filename) && is_file($filename))
    {
        if(filesize($filename)>524288 && $force_read==false) # 512Ko
            echo '<div class="textarea"><a href="'.$_CURRENT['QUERY_STRING'].'&amp;'.QS_DIRNAME.'='.$actual_dir.'&amp;'.QS_FILENAME.'='.$file.'&'.QS_FORCE_FLREAD.'=true" title="'.$file.'">Forzar lectura de archivo</a></div>';
        else
            echo '<textarea name="fcf_file_content">'.htmlspecialchars(file_get_contents($filename,FILE_TEXT)).'</textarea>';
    }
    else
        echo '<div class="textarea">&nbsp;</div>';
?>
