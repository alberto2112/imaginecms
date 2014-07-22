<?php
//-------------------------------------------------------------------------------------

    function complet_with_default_addon_params( &$array )
    {
        if(empty($array['DATADIR']) || !isset($array['DATADIR']))
            $array['DATADIR'] = 'freeapp';

        return $array;
    }

//-------------------------------------------------------------------------------------
/*
    function complet_with_default_section_params( &$array )
    {
        if(!isset($array['CLR-THEME']))
            $array['CLR-THEME'] = '';

        if(!isset($array['CLR-VIEWER-CONTROLS']))
            $array['CLR-VIEWER-CONTROLS'] = '';

        if(!isset($array['CNT-SIZE']))
            $array['CNT-SIZE'] = '';

        if(empty($array['SHOWMODE']) || !isset($array['SHOWMODE']))
            $array['SHOWMODE'] = 'LARGE';

        return $array;
    }
*/
?>
