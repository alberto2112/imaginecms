<?php
    $sysNAVBAR->set_block('<ul class="navbar">{@NAVBAR(ITEMS-CONTENT)}'."\n</ul>");
    //$sysNAVBAR->set_items_content('{@NAVBAR(ITEM-STRUCTURE)}');

    $sysNAVBAR->set_item_structure('ENABLED', "\n".'  <li><a href="{@NAVBAR(ITEM)(LINK)}">{@NAVBAR(ITEM)(TEXT)}</a></li>');
    $sysNAVBAR->set_item_structure('DISABLED', "\n".'  <li><a href="{@NAVBAR(ITEM)(LINK)}">{@NAVBAR(ITEM)(TEXT)}</a></li>');
    $sysNAVBAR->set_item_structure('ACTIVE', "\n".'  <li class="navbar-active"><a href="{@NAVBAR(ITEM)(LINK)}">{@NAVBAR(ITEM)(TEXT)}</a></li>');
/*
    $sysNAVBAR->set_item_structure(
        array(
            'ENABLED'   => "\n".'  <li><a href="{@NAVBAR(ITEM)(LINK)}">{@NAVBAR(ITEM)(TEXT)}</a></li>',
            'DISABLED'  => "\n".'  <li><a href="{@NAVBAR(ITEM)(LINK)}">{@NAVBAR(ITEM)(TEXT)}</a></li>',
            'ACTIVE'    => "\n".'  <li class="navbar-active"><a href="{@NAVBAR(ITEM)(LINK)}">{@NAVBAR(ITEM)(TEXT)}</a></li>'
        )
    );
*/
?>