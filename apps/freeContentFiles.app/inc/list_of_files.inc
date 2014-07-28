<?php
  $code = getRequest_param('code',false);
  if($code){
    $actual_dir = getRequest_param(QS_DIRNAME,'/');
    $filename   = getRequest_param(QS_FILENAME, false);
    $dirs       = array();
    $files      = array();

    $actual_dir         = clean_file_name($actual_dir); //str_replace('..','', $actual_dir);
    $base_actual_dir    = basename($actual_dir);
    $parent_actual_dir  = substr($actual_dir,0,(strlen($base_actual_dir)*(-1))-1 );

    $cache_del_dialog = '';
    $my_data_path = SYSTEM_ROOT.DATA_DIR.$code.'/';
    $i=0;

    if(!file_exists($my_data_path))
        @mkdir($my_data_path, 0777, true);

    if(!file_exists($my_data_path.'controller.php')&& is_writable( $my_data_path ))
    {
        $fp = fopen( $my_data_path.'controller.php', 'w');
        fwrite($fp, '<?php echo ""; ?>');
        fclose($fp);
    }

    foreach(read_dir($my_data_path.$actual_dir) as $name)
    {
        if(is_dir($name))
            $dirs[]  = basename($name); //$dirs[]  = PUBLIC_ROOT.substr($name,strlen(SYSTEM_ROOT));
        else
            $files[] = basename($name); //$files[] = PUBLIC_ROOT.substr($name,strlen(SYSTEM_ROOT));
    }

    # Enlace de retorno
    if(strlen($actual_dir)>1)
        print '<li class="back"><a href="'.$_CURRENT['QUERY_STRING'].'&'.QS_DIRNAME.'='.$parent_actual_dir.'">[..]</a></li>';

    # Imprimir directorios
    foreach($dirs as $dir)
    {
        if(strlen($dir)>15)
            $easy_name = substr($dir,0,4).'...'.substr($dir,-10);
        else
            $easy_name = $dir;
        print '<li class="folder"><a href="'.$_CURRENT['QUERY_STRING'].'&amp;'.QS_DIRNAME.'='.$actual_dir.$dir.'/" title="'.$dir.'">['.$easy_name.']</a></li>';
        $cache_del_dialog .= '<li class="folder"><input type="checkbox" name="folder_delme['.$i.']" value="'.$dir.'" />&nbsp;['.$dir.']</li>';
        $i++;
    }

    $i=0;

    # Imprimir ficheros
    foreach($files as $file)
    {
        switch(strtolower(pathinfo($file,PATHINFO_EXTENSION)))
        {
            case 'php':
            case 'php3':
            case 'php4':
            case 'php5':
            case 'php6':
            case 'inc':
                $template = 'php';
                break;

            case 'bmp':
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
                $template = 'image';
                break;

            case 'htm':
            case 'html':
            case 'xhtm':
                $template = 'html';
                break;

            case 'xml':
                $template = 'xml';
                break;

            case 'css':
                $template = 'css';
                break;

            case 'js':
                $template = 'script';
                break;

            case 'pdf':
                $template = 'pdf';
                break;

            case 'txt':
                $template = 'text';
                break;

            case 'mp3':
            case 'wav':
            case 'mid':
            case 'ogg':
                $template = 'audio';
                break;

            case 'avi':
            case 'mpg':
            case 'mpeg':
            case 'ogm':
            case 'flv':
                $template = 'video';
                break;

            case 'zip':
            case 'rar':
            case 'ace':
            case 'tar':
            case 'gz':
            case '7z':
                $template = 'compress';
                break;

            default:
                $template = 'file';
        }

        if(strlen($file)>15)
            $easy_name = substr($file,0,4).'...'.substr($file,-10);
        else
            $easy_name = $file;

        print '<li class="'.$template.'"><a href="'.$_CURRENT['QUERY_STRING'].'&amp;'.QS_DIRNAME.'='.$actual_dir.'&amp;'.QS_FILENAME.'='.$file.'" title="'.$file.'">'.$easy_name.'</a></li>';
        $cache_del_dialog .= '<li class="'.$template.'"><input type="checkbox" name="file_delme['.$i.']" value="'.$file.'" />&nbsp;'.$file.'</li>';
        $i++;
    }

  }
?>