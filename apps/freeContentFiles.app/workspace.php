<?php
    require_once(SYSTEM_ROOT.LIB_DIR.'filesystem.lib.php');

    global $_CURRENT;

    define('RUN_admin', PUBLIC_ROOT.ADMIN_DIR.'run.php'.$_CURRENT['QUERY_STRING']);


    $actual_dir = getRequest_param('dirname','/');
    $filename   = getRequest_param('filename');
    $dirs       = array();
    $files      = array();

    $actual_dir         = clean_file_name($actual_dir); //str_replace('..','', $actual_dir);
    $base_actual_dir    = basename($actual_dir);
    $parent_actual_dir  = substr($actual_dir,0,(strlen($base_actual_dir)*(-1))-1 );
    //$actual_dir = str_replace('//','', $actual_dir);
?>
<!-- DIALOGOS -->
<div class="u-dialog dark hidden" id="dlg-uploading">
    <h3>Uploading...</h3>
    <p>Uploading dialog...</p>
    <p style="text-align:center;"><img src="<?php print PUBLIC_ROOT; ?>images/ajax-loader-bar.gif" alt="" /></p>
</div>
<div class="u-dialog dark" id="dlg-upload-file">
    <h3>Subir archivo</h3>
    <form action="<?php echo RUN_admin.'&amp;fcfa=upload_file'; ?>" method="post" enctype="multipart/form-data" onsubmit="javascript:showDialog('dlg-uploading')">
        <input type="hidden" name="dirname" value="<?php echo $actual_dir; ?>" />
        <input type="file" name="file" />
        <input type="submit" value="Enviar" />
    </form>
</div>
<div class="u-dialog dark" id="dlg-install-packet">
    <h3>Instalar archivos</h3>
    <form action="<?php echo RUN_admin.'&amp;fcfa=install_packet'; ?>" method="post" enctype="multipart/form-data" onsubmit="javascript:showDialog('dlg-uploading')">
        <input type="hidden" name="dirname" value="<?php echo $actual_dir; ?>" />
        <input type="file" name="file" />
        <input type="submit" value="Enviar" />
    </form>
</div>
<div class="u-dialog dark" id="dlg-new-file">
    <h3>Crear archivo</h3>
    <p>Escriba en nombre del nuevo archivo. Evite de escribir caracteres complicados como acentos, e&ntilde;es, signos, s&iacute;mbolos o espacios.</p>
    <form action="<?php echo RUN_admin.'&amp;fcfa=create_file'; ?>" method="post">
        <input type="hidden" name="dirname" value="<?php echo $actual_dir; ?>" />
        <input type="text" name="filename" value="new_file.html" />
        <input type="submit" value="Crear archivo" />
    </form>
</div>
<div class="u-dialog dark" id="dlg-new-folder">
    <h3>Crear carpeta</h3>
    <p>Escriba en nombre del nuevo archivo. Evite de escribir caracteres complicados como acentos o e&ntilde;es.</p>
    <form action="<?php echo RUN_admin.'&amp;fcfa=create_folder'; ?>" method="post">
        <input type="hidden" name="dirname" value="<?php echo $actual_dir; ?>" />
        <input type="text" name="foldername" value="new_folder" />
        <input type="submit" value="Crear carpeta" />
    </form>
</div>
<div class="u-dialog" id="dlg-rename">
    <h3>Cambiar nombre</h3>
    <form action="<?php echo RUN_admin; ?>" method="post">
        <input type="hidden" name="parent_dirname" value="<?php echo $parent_actual_dir; ?>" />
        <input type="hidden" name="dirname" value="<?php echo $actual_dir; ?>" />
        <input type="hidden" name="filename_a" value="<?php echo $filename; ?>" />
        <input type="hidden" name="foldername_a" value="<?php echo $base_actual_dir; ?>" />
        <div style="display:block;float:left;width:50%">
            <input type="radio" name="fcfa" value="rename_file" checked="checked" /><img src="<?php echo PUBLIC_ROOT.'images/doc_text.png'; ?>" alt="Rename file" />&nbsp;<?php echo $filename; ?>
        </div>
        <div>
            <input type="radio" name="fcfa" value="rename_folder" /><img src="<?php echo PUBLIC_ROOT.'images/folder.png'; ?>" alt="Rename folder" />&nbsp;<?php echo $actual_dir; ?>
        </div>
        <hr />
        <input type="text" name="new_name" value="" />
        <input type="submit" value="Cambiar nombre" />
    </form>
</div>
<!-- ESPACIO DE TRABAJO -->
<div class="toolbar">
    <a href="javascript:showDialog('dlg-upload-file')" id="ajax-upload-file" class="button" ><span>Subir archivo</span></a>
    <a href="javascript:showDialog('dlg-install-packet')" id="ajax-install-packet" class="button" ><span>Instalar archivos</span></a>
    <span class="toolbar-separator" class="button">|</span>
    <a href="javascript:showDialog('dlg-new-file')" id="ajax-new-file" class="button" ><span>Nuevo fichero</span></a>
    <a href="javascript:showDialog('dlg-new-folder')" id="ajax-new-folder" class="button"><span>Nueva carpeta</span></a>
    <a href="javascript:showDialog('dlg-rename')" id="ajax-rename" class="button"><span>Cambiar nombre</span></a>
    <span class="toolbar-separator" class="button">|</span>
    <a href="javascript:showDialog('dlg-delete',355,425)" id="ajax-delete" class="button"><span>Eliminar</span></a>
</div>
<div class="file_list">
    <ul>
<?php

    $cache_del_dialog = '';
    $my_data_path = SYSTEM_ROOT.DATA_DIR.$this->get_info('NAME').'/';
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
        print '<li class="back"><a href="'.$_CURRENT['QUERY_STRING'].'&amp;dirname='.$parent_actual_dir.'">[..]</a></li>';

    # Imprimir directorios
    foreach($dirs as $dir)
    {
        if(strlen($dir)>15)
            $easy_name = substr($dir,0,4).'...'.substr($dir,-10);
        else
            $easy_name = $dir;
        print '<li class="folder"><a href="'.$_CURRENT['QUERY_STRING'].'&amp;dirname='.$actual_dir.$dir.'/" title="'.$dir.'">['.$easy_name.']</a></li>';
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

        print '<li class="'.$template.'"><a href="'.$_CURRENT['QUERY_STRING'].'&amp;dirname='.$actual_dir.'&amp;filename='.$file.'" title="'.$file.'">'.$easy_name.'</a></li>';
        $cache_del_dialog .= '<li class="'.$template.'"><input type="checkbox" name="file_delme['.$i.']" value="'.$file.'" />&nbsp;'.$file.'</li>';
        $i++;
    }
?>
    </ul>
</div>

<div class="file_editor">
<form action="<?php echo RUN_admin.'&amp;fcfa=save_file'; ?>" method="post">
    <input type="hidden" name="dir_name" value="<?php echo $actual_dir ?>" />
    <input type="text" name="file_name" value="<?php echo $filename ?>" />
    <?php print include('inc/read_file.inc');?>
    <input type="submit" value="Guardar cambios" />
</form>
</div>

<?php
    echo '
<div class="u-dialog dark" id="dlg-delete">
    <h3>Eliminar</h3>
    <p>Seleccione en la lista los elementos que desee eliminar.</p>
    <form action="'.RUN_admin.'&amp;fcfa=delete'.'" method="post">
        <input type="hidden" name="dirname" value="'.$actual_dir.'" />
        <div class="file_list">
            <ul>'.$cache_del_dialog.'</ul>
        </div>
        <input type="submit" value="Suprimir definitivamente" />
    </form>
</div>';
?>
