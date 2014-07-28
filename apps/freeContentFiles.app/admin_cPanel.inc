<?php
  $action = getRequest_param('fcfa', 'workspace');
  switch($action){
    case 'save_file':
        include('inc/save_file.inc');
        break;
    case 'create_file':
        include('inc/create_file.inc');
        break;
    case 'create_folder':
        include('inc/create_folder.inc');
        break;
    case 'delete':
        include('inc/delete.inc');
        break;
    case 'delete_file':
        include('inc/delete_file.inc');
        break;
    case 'delete_folder':
        include('inc/delete_folder.inc');
        break;
    case 'rename_folder':
    case 'rename_file':
        include('inc/rename.inc');  # Sirve para directorios y ficheros, el proceso es el mismo
        break;
    case 'upload_file':
        include('inc/upload_file.inc');
        break;
    case 'install_packet':
        include('inc/install_package.inc');
        break;
    default:        # view_workspace
        include('workspace.inc');
  }
?>