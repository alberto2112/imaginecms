<?php
//TODO
# If user navigates with a little screen, load mobile theme
/*
  global $NAVBAR;
  $NAVBAR->clean();

  $document = file_get_contents('layout.html', true);
  $navbar = $NAVBAR->get_navbar();

  return str_replace('{@NAVBAR}', $navbar, $document);
*/
  return file_get_contents('layout.html', true);
?>