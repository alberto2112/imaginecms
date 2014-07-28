<?php
  global $_CURRENT;
  $file2read = SYSTEM_ROOT.DATA_DIR.$_CURRENT['SECTION']['CODSECTION'].'/3k_body.html';

  if(file_exists($file2read))
    if(is_readable($file2read))
      $content = file_get_contents($file2read);
    else
      $content = '<p style="text-align:center;><strong>Error:</strong> <span style="color:#A22">'.PUBLIC_ROOT.DATA_DIR.$_CURRENT['SECTION']['CODSECTION'].'/3k_body.html </span> is not accessible</p>';
  else
    $content = '<p style="text-align:center;"><strong>Error:</strong> <span style="color:#A22">'.PUBLIC_ROOT.DATA_DIR.$_CURRENT['SECTION']['CODSECTION'].'/3k_body.html</span> not exists</p>';

  $content = str_replace('{@DATA_DIR}', PUBLIC_ROOT.DATA_DIR.$_CURRENT['SECTION']['CODSECTION'], $content);
  echo $content;
?>