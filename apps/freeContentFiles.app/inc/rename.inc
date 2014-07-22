<?php
    $dirname  = get_request_param('dirname');
    $new_name = get_request_param('new_name','null');
    $fail     = false;
    $name_redirect = '';

    if($action=='rename_file')
    {
        $filename_a     = get_request_param('filename_a','null');
        $name_redirect  = clean_file_name('&filename='.$new_name);

        $old_name       = clean_file_name($iME['PATH_appdatadir'].$dirname.'/'.$filename_a);
        $new_name       = clean_file_name($iME['PATH_appdatadir'].$dirname.'/'.$new_name);
    }
    elseif($action=='rename_folder')
    {
        $dirname        = get_request_param('parent_dirname');
        $foldername_a   = get_request_param('foldername_a','null');
        $name_redirect  = clean_file_name('/'.$new_name);

        $old_name       = clean_file_name($iME['PATH_appdatadir'].$dirname.'/'.$foldername_a);
        $new_name       = clean_file_name($iME['PATH_appdatadir'].$dirname.'/'.$new_name);
    }
    else
        $fail = true;

    if($fail || file_exists($new_name) || !file_exists($old_name))
        run_redirect(WEB_admin.'?'.$iME['URL'].'&err=rename_failed&dirname='.$dirname.$name_redirect);
    else
    {
        if(rename( $old_name, $new_name ))
            run_redirect(WEB_admin.'?'.$iME['URL'].'&err=ok&dirname='.$dirname.$name_redirect);
        else
            run_redirect(WEB_admin.'?'.$iME['URL'].'&err=rename_failed&dirname='.$dirname);
    }
?>