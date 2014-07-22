<?xml version="1.0" encoding="iso-8859-1" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    {@HEAD(META)}
    <link rel="stylesheet" type="text/css" media="projection, screen" href="{@LAYOUT(PATH)}/css/reset.css" />
    <link rel="stylesheet" type="text/css" media="projection, screen" href="{@LAYOUT(PATH)}/css/styles.css" />
<!--[if IE 7]>
    <link rel="stylesheet" type="text/css" media="projection, screen" href="{@LAYOUT(PATH)}/css/styles.ie7.css" />
<![endif]-->
    {@HEAD(LINK)}
    {@HEAD(SCRIPT)}
    {@HEAD(TITLE)}
  </head>
<body>
    {@BODY[HEADER]}
    <div class="sys-container_960">
        <div class="sys-pagetitle">
            <h1>{@TITLE}</h1>
        </div>
        <div class="sys-pagetop">
            <h2 class="slogan">{@SLOGAN}</h2>
            {@NAVBAR}
        </div>
        <div class="sys-pagecontent">
        {@PARASIT-PRELOAD-CNT}
        {@BODY}
        {@PARASIT-POSTLOAD-CNT}
        </div>
        <address id="pagefooter" class="sys-pagefooter tx-center">photods.fr | 2014 | D&eacute;velopp&eacute; par Alberto Hern&aacute;ndez</address>
    </div>
    {@BODY[FOOTER]}
</body>
</html>