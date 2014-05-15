<?php
  class webMaker
  {
    public $document = '';
    public $doctype = '';
    public $layout  = array();
    public $head    = array
    (
        'META'   => array(),
        'LINK'   => array(),
        'SCRIPT' => array(),
        'OTHER'  => array()
    );
    public $body    = '';
    public $objects = array();

//--------------------------------------------------------------------------------------
    function __construct($doctype='')
    {
        $this->set_doctype($doctype);
        $this->head['OTHER']['TITLE']  = array('content'=>'403 Forbriden', 'tag'=>'<title>403 Forbriden</title>');
        $this->layout['NAME']       = '';
        $this->layout['CONTENT']    = "{@DOCTYPE}\n<html>\n<head>{@HEAD}</head>\n<body>{@BODY}</body>\n</html>";
        $this->body                 = '<h1>403 Frbriden</h1>';
    }

//--------------------------------------------------------------------------------------
    function set_doctype($type='')
    /**
      * @desc    Configura la especificacion DOCTYPE del documento
      * @param   $type   String: ( HTML_4.01_STRICT | HTML_4.01_TRASITIONAL | HTML_4.01_FRAMESET
      *                          | XHTML_1.0_STRICT | XHTML_1.0_TRANSITIONAL | XHTML_1.0_FRAMESET | XHTML_1.1 | XHTML_1.1_BASIC )
      * @return  null
      */
    {
        switch(strtoupper($type))
        {
            case 'HTML_4.01_STRICT':
                $this->doctype = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">';
                break;
            case 'HTML_4.01_TRANSITIONAL':
                $this->doctype = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">';
                break;
            case 'HTML_4.01_FRAMESET':
                $this->doctype = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
"http://www.w3.org/TR/html4/frameset.dtd">';
                break;
            case 'XHTML_1.0_STRICT':
                $this->doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
                break;
            case 'XHTML_1.0_TRANSITIONAL':
                $this->doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
                break;
            case 'XHTML_1.0_FRAMESET':
                $this->doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">';
                break;
            case 'XHTML_1.1':
                $this->doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">';
                break;
            case 'XHTML_1.1_BASIC':
                $this->doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML Basic 1.1//EN"
"http://www.w3.org/TR/xhtml-basic/xhtml-basic11.dtd">';
                break;
            default:
                $this->doctype = '';
        }
    }
//--------------------------------------------------------------------------------------
    function set_title($title)
    {
        $this->head['OTHER']['TITLE'] = array('content'=>$title, 'tag'=>'<title>'.$title.'</title>');
/*
        $index = -1;
        if(isset($this->head))
        {
            do
            {
                $index++;
                $this->head[$index]['htag'] == 'title';
            } while($index >= count($this->head));
        }

        if($index < 0)
            $this->head[] = array('htype'=>'title', 'content'=>$title, 'tag'=>'<title>'.$title.'</title>');
        else
            $this->head[$index] = array('htype'=>'title', 'content'=>$title, 'tag'=>'<title>'.$title.'</title>');
*/
    }
//--------------------------------------------------------------------------------------
    function add_head_tag( $tag, $type='OTHER' )
    /**
      * @param  $tag     string | array
      *
      */
    {
        if(!empty($tag))
            $this->head[$type] = $tag;
        else
            return false;
    }
//--------------------------------------------------------------------------------------
    function add_head_meta($name, $content='', $ref_name='')
    /**
      * @desc    Agrega una etiqueta meta en el array $head()
      *
      * @return  True | False
      */
    {
        if(!empty($name))
        {
            $a = array(
                'name'      => $name,
                'content'   => $content,
                'tag'       => '<meta name="'.$name.'" content="'.$content.'" />'
            );

            if( $ref_name=='' || isset( $this->head['META'][$ref_name] ))
                $this->head['META'][] = $a;
            else
                $this->head['META'][$ref_name] = $a;

            return true;
        }
        else
            return false;
    }
//--------------------------------------------------------------------------------------
    function update_head_meta($name, $content='',$arr_key='')
    {
        if($arr_key!='' && $this->validate_index_on_array($arr_key, $this->head['META']))
        {
                $this->head['META'][$arr_key]['name']     = $name;
                $this->head['META'][$arr_key]['content']  = $content;
                $this->head['META'][$arr_key]['tag']      = '<meta name="'.$name.'" content="'.$content.'" />';
                return  true;
        }
        else
        {
            $item_updated = false;
            foreach($this->head['META'] as $key=>$meta)
            {
                if($meta['name']==$name)
                {
                    $this->head['META'][$key]['content']  = $content;
                    $this->head['META'][$key]['tag']  = '<meta name="'.$name.'" content="'.$content.'" />';
                    $item_updated = true;
                    break;
                }
            }
            return (($item_updated)? true : add_head_meta($name, $content, $arr_key));
        }
    }
//--------------------------------------------------------------------------------------
    function add_head_link($href, $type, $rel, $media='', $title='', $ref_name='')
    /**
      * @desc    Agrega una etiqueta link en el array $head()
      *
      * @param   $path       Ruta relativa del fichero
      * @param   $type       Tipo de datos
      * @param   $rel        Relacion del documento
      * @param   $media      Especifica el contexto
      *
      * @return  True | False
      */
    {
        if(!empty($href))
        {
            $a = array(
                'htype' => 'link',
                'href'  => $href,
                'type'  => $type,
                'media' => $media,
                'rel'   => $rel,
                'title' => $title,
                'tag'   => '<link rel="'.$rel.'" type="'.$type.'"'.(( $media!='' )? ' media="'.$media.'"' : null).' href="'.$href.'"'.(( $title != '' )? ' title="'.$title.'"' : null).' />'
            );

            if(!$this->exists_head_tag('LINK', $a['tag']))
            {
                if( $ref_name=='' || isset( $this->head['LINK'][$ref_name] ))
                    $this->head['LINK'][] = $a;
                else
                    $this->head['LINK'][$ref_name] = $a;
            }

            return true;
        }
        else
            return false;
    }
//--------------------------------------------------------------------------------------
    function update_head_link($index, $href, $type, $rel, $media='', $title='')
    {
        if($this->validate_index_on_array($index, $this->head['LINK']))
        {
                $this->head['LINK'][$index]['href']     = $href;
                $this->head['LINK'][$index]['type']     = $type;
                $this->head['LINK'][$index]['media']    = $media;
                $this->head['LINK'][$index]['rel']      = $rel;
                $this->head['LINK'][$index]['title']    = $title;
                $this->head['LINK'][$index]['tag']      = '<link rel="'.$rel.'" type="'.$type.'" href="'.$href.'"'.(( $media!='' )? ' media="'.$media.'"' : null).(( $title != '' )? ' title="'.$title.'"' : null).' />';
                return true;
        }
        else
            return false;
    }
//--------------------------------------------------------------------------------------
    function add_head_script($src, $type='text/javascript', $language='',$defer='', $content='', $ref_name='')
    {
        if(!empty($src) || !empty($content))
        {
            $a = array(
                'htype'     => 'script',
                'src'       => $src,
                'type'      => $type,
                'language'  => $language,
                'defer'     => $defer,
                'content'   => $content,
                'tag'       => '<script '.(( $src!='' )? 'src="'.$src.'"' : null).' type="'.$type.'"'.(( $language!='' )? ' language="'.$language.'"' : null).(( $defer != '' )? ' defer="'.$defer.'"' : null).'>'.$content.'</script>'
            );

            if(!$this->exists_head_tag('SCRIPT', $a['tag']))
            {
                if($ref_name=='' || isset( $this->head['SCRIPT'][$ref_name]))
                    $this->head['SCRIPT'][] = $a;
                else
                    $this->head['SCRIPT'][$ref_name] = $a;
            }
            return true;
        }
        else
            return false;
    }
//--------------------------------------------------------------------------------------
    function update_head_script($index, $src, $type='text/javascript', $language='', $defer='', $content='', $ref_name='')
    {
        if($this->validate_index_on_array($index, $this->head))
        {
                $this->head['SCRIPT'][$index]['src']      = $src;
                $this->head['SCRIPT'][$index]['type']     = $type;
                $this->head['SCRIPT'][$index]['type']     = $type;
                $this->head['SCRIPT'][$index]['language'] = $language;
                $this->head['SCRIPT'][$index]['content'] = $content;
                $this->head['SCRIPT'][$index]['tag']      = '<script '.(( $src!='' )? 'src="'.$src.'"' : null).' type="'.$type.'"'.(( $language!='' )? ' language="'.$language.'"' : null).(( $defer != '' )? ' defer="'.$defer.'"' : null).'>'.$content.'</script>';

                return true;
        }
        else
            return false;
    }

//--------------------------------------------------------------------------------------
    function exists_head_tag( $type, $tag)
    {
        $result = false;
        if(count($this->head[$type])>0)
        {
            foreach($this->head[$type] as $head_tag)
            {
                if($head_tag['tag'] == $tag)
                {
                    $result = true;
                    break;
                }
            }
        }

        return $result;
    }
//--------------------------------------------------------------------------------------
// EASY FUNCTIONS
//--------------------------------------------------------------------------------------
    function add_css($href, $media="screen", $title='')
    /**
      * @desc    Agrega una etiqueta de enlace CSS en el array $head()
      *
      * @param   $path       Ruta relativa del fichero css
      * @param   $type       Tipo de datos
      * @param   $rel        Relacion del documento
      * @param   $media      Especifica el medio del fichero css
      *
      * @return  True | False
      */
    {
        return $this->add_head_link($href, "text/css", "stylesheet", $media, $title);
    }
//--------------------------------------------------------------------------------------
    function update_css($index, $href, $media="screen", $title='')
    /**
      * @return True | False
      */
    {
        return $this->update_head_link($index, $href, "text/css", "stylesheet", $media, $title);
    }
//--------------------------------------------------------------------------------------
    function add_js($scr, $content='', $language='',$defer='')
    /**
      * @desc    Agrega una etiqueta de enlace CSS en el array $head()
      *
      * @param   $path       Ruta relativa del fichero css
      * @param   $type       Tipo de datos
      * @param   $rel        Relacion del documento
      *
      * @return  True | False
      */
    {
        return $this->add_head_script($scr, 'text/javascript', $language, $defer, $content);
    }
//--------------------------------------------------------------------------------------
    function update_js($index, $content='', $scr, $language='',$defer='')
    /**
      * @return True | False
      */
    {
        return $this->update_head_script($index, $scr, 'text/javascript', $language, $defer, $content);
    }
//--------------------------------------------------------------------------------------
    function add_meta($name, $content='')
    {
        return $this->add_head_meta($name,$content);
    }
//--------------------------------------------------------------------------------------
    function update_meta($index, $name, $content='')
    {
        return $this->update_head_meta($index, $name, $content);
    }
//--------------------------------------------------------------------------------------
    function get_header($index)
    /**
      * @return      Array | False
      */
    {
            if($this->validate_index_on_array($index, $this->head))
                    return $this->head[$index];
            else
                    return false;
    }
//--------------------------------------------------------------------------------------
    function get_head_content($type='')
    /**
      * @return  String
      */
    {
        $content = '';
        if(isset($this->head))
        {
            if($type=='')
            {
                foreach($this->head['META'] as $h) $content .= $h['tag']."\n";
                foreach($this->head['LINK'] as $h) $content .= $h['tag']."\n";
                foreach($this->head['SCRIPT'] as $h) $content .= $h['tag']."\n";
                foreach($this->head['OTHER'] as $h) $content .= $h['tag']."\n";
            }
            else
                foreach($this->head[$type] as $h) $content .= $h['tag']."\n";
        }
        return $content;
    }
//---------------------------------------
    function set_body($content)
    {
      $this->body = $content;
    }
//---------------------------------------
    function set_layout($layout_path)
    /**
      * alias of load_layout
      */
    {
        return $this->load_layout( $layout_path );
    }
//--------------------------------------------------------------------------------------
    function load_layout($layout_name, $include_controller=true)
    /**
      * @return  true | false
      **/
    {
        $layout_path = @dirname( $layout_name );

        if(is_readable($layout_path))
        {
            $this->layout['NAME']       = basename( $layout_path );
            $this->layout['PATH']       = $layout_path;
            # Comprobar si tiene controlador de flujo
            $this->layout['CONTENT']    = ($include_controller && file_exists($layout_path.'/controller.php'))?
                                                include($layout_path.'/controller.php')
                                                : ((is_readable($layout_name)?
                                                    file_get_contents($layout_name, true)
                                                    : '<h1>Layout not exists</h1><h3>'.$layout_name.'</h3>'));
            $this->document             = $this->layout['CONTENT'];
            return true;
        }
        else
            return false;
    }
//--------------------------------------------------------------------------------------
    function replace_document_vars( $search, $replace, $option='STR_REPLACE')
    {
    /**
      * @desc    Reemplaza la variable $search por $replace en $this->document
      *          usando la funcion str_replace (por defecto) o preg_replace
      *  @param $search      Cadena buscada en $this->document
      *  @param $replace     Cadena por la que sera deemplazada $search
      *  @param $option      Tipo de funcion utilizada para realizar los cambios: STR_REPLACE | PREG_REPLACE
      *
      *  @return   ???
      */

          if($option=='STR_REPLACE')
              $this->document = str_replace($search, $replace, $this->document);
          else
              $this->document = preg_replace($search, $replace, $this->document);

          return true;
    }
//--------------------------------------------------------------------------------------??
    //function clear_document_vars($a='/\{@(.*)\}/i'){  $this->document = preg_replace( $a, '', $this->document ); }
//--------------------------------------------------------------------------------------
    function validate_index_on_array($index, $array)
    /**
      * @return  true | false
      */
    {
            return (isset($index) && isset($array) && $index <= count($array));
    }
//--------------------------------------------------------------------------------------
    function render( $do_replace=true )
    {
        if( $do_replace===true )
        {
            $this->document = str_replace('{@DOCTYPE}',$this->doctype,$this->document);
            $this->document = str_replace('{@HEAD(LINK)}',$this->get_head_content('LINK'),$this->document);
            $this->document = str_replace('{@HEAD(META)}',$this->get_head_content('META'),$this->document);
            $this->document = str_replace('{@HEAD(SCRIPT)}',$this->get_head_content('SCRIPT'),$this->document);
            $this->document = str_replace('{@HEAD(TITLE)}',$this->head['OTHER']['TITLE']['tag'],$this->document);
            $this->document = str_replace('{@HEAD}',$this->get_head_content(),$this->document);
            $this->document = str_replace('{@BODY}',$this->body,$this->document);
            $this->document = str_replace('{@APP_CONTENT}',$this->body,$this->document);
            $this->document = str_replace('{@LAYOUT(PATH)}',PUBLIC_ROOT.LAYOUTS_DIR.$this->layout['NAME'],$this->document);

            # Limpiar variables no resueltas e imprimir documento
            echo preg_replace( '/\{@(.*)\}/i', '', $this->document );
        }
        else
            echo $this->document;
    }
  }
?>