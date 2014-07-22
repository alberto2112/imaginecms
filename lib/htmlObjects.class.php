<?php
/*****************************************
** TABLE By ALBERTO HERNANDEZ: 01/12/2008
******************************************/
  class obj_table {
    public $link;
    public $sql;

    public $caption;
    public $class_table;
    public $class_thead;
    public $class_tbody;
    public $class_th;
    public $class_tr;
    public $class_td;
    //var $class_form_paging;
    //var $class_form_buttons;

    public $style_table;
    public $style_thead;
    public $style_tbody;
    public $style_th;
    public $style_tr;
    public $style_td;
    public $style_content;
    public $style_form_paging;
    public $style_form_buttons;
    public $style_cols;

//TODO:
/*
    var $a_page_rel;
    var $a_table_rel;
    var $a_th_rel;
    var $a_td_rel;
*/

    public $enable_paging;
    public $enable_search;
    public $form;
    //var $form_id; --> $id_form
    public $form_name;
    public $form_action;
    public $form_searchbar;
    public $form_button_submit;
    public $form_button_reset;
    public $form_hiddenobjects;
    public $form_onSubmit;
    public $hidden_objects;
    public $paging_from;
    public $paging_pageregs;
    private $r;

    public $id_content;
    public $id_form;
    public $id_table;
    public $id_tr;
    public $id_td;

    public $colnames;
    public $colstyle;
    public $rowcode;
    public $hidden_rows;
    public $startcols;
    public $endcols;

    function set_sql($a) {
      $this->sql = $a;
    }

    function set_link($db) {
      $this->link = $db;
    }

    function set_rowcode($a) {
      $this->rowcode = $a;
    }

    function set_hidden_rows($a) {
      $this->hidden_rows = $a;
    }

    function set_colnames($a) {
      $this->colnames = $this->replace_chars($a);
    }

    function set_startcol($a) {
      $this->startcol = "   <td_STYLE-TD_CLASS-TD_ID-TD>$a</td>\n";
    }

    function set_endcol($a) {
      $this->endcol = "   <td_STYLE-TD_CLASS-TD_ID-TD>$a</td>\n";
    }
/*
+-----------------+
|  FORM           |
+-----------------+ */
    function set_form_action($a) {
      $this->form_action = $a;
    }

    function set_form_id($a) {
      $this->id_form = ($a=='') ? null : ' id="'. $a .'"';
    }

    function set_form_name($a) {
      $this->form_name = $a;
    }

    function set_form_onSubmit($a) {
      $this->form_onSubmit = $a;
    }

    function set_form_button_submit($a) {
      $this->form_button_submit = $a;
    }

    function set_form_button_reset($a) {
      $this->form_button_reset = $a;
    }

    function add_form_hiddenobject($a) {
      $atributos=explode(',',$this->replace_chars($a));

      foreach ($atributos as $index=>$atributo) {
        $trozos=explode(':',$atributo,2);
        $this->hidden_objects.='<input type="hidden" name="'. $trozos[0] .'" value="'. $trozos[1] .'" />'."\n";
      }
    }

    function set_form_searchbar($a) {
      $this->form_searchbar = $this->replace_chars($a);
    }
/*
+-----------------+
| R               |
+-----------------+ */
    function set_r($a) {
      $this->r = $a;
    }
/*
+-----------------+
| ID              |
+-----------------+ */
    function set_id($a) {
      $a=str_replace("\n",'',$a);
      $a=str_replace(' ','',$a);

      $propiedades=explode(',',$a);

      foreach ($propiedades as $index=>$propiedad) {
        $trozos=explode(':',$propiedad);
        $trozos[0]='id_'. $trozos[0];
        $this->$trozos[0]=' id="'. $trozos[1] .'"';
      }
    }
/*
+-----------------+
| CLASS           |
+-----------------+ */
    function set_class($a) {
      $propiedades=explode(',',$this->replace_chars($a));

      foreach ($propiedades as $index=>$propiedad) {
        $trozos=explode(':',$propiedad);
        $trozos[0]='class_'. $trozos[0];
        $this->$trozos[0]=' class="'. $trozos[1] .'"';
      }
    }

    function set_style($a) {
      $propiedades=explode(',',$this->replace_chars($a));

      foreach ($propiedades as $index=>$propiedad) {
        $trozos=explode(':',$propiedad,2);
        $trozos[0]='style_'. $trozos[0];
        $this->$trozos[0]=' style="'. $trozos[1] .'"';
      }
    }

    function set_style_cols($a) {
      $this->style_cols = $this->replace_chars($a);
    }

/*
+-----------------+
| ENABLE          |
+-----------------+ */
    function enable($a){
      $propiedades=explode(',',$this->replace_chars($a));

      foreach ($propiedades as $index=>$propiedad) {
        $trozos=explode(':',$propiedad);
        $trozos[0]='enable_'.$trozos[0];
        $this->$trozos[0]=$trozos[1];
      }
    }

/*
+-----------------+
| SET GENERICO    |
+-----------------+ */
    function set($a) {
      $propiedades=explode(',',$this->replace_chars($a));

      foreach ($propiedades as $index=>$propiedad) {
        $trozos=explode(':',$propiedad);
        $this->$trozos[0]=$trozos[1];
      }
    }
/* OTRAS FUNCIONES */
    function replace_vars($a) {
      $a=str_replace('_STYLE-TD',$this->style_td,$a);
      $a=str_replace('_CLASS-TD',$this->class_td,$a);
      $a=str_replace('_ID-TD',$this->id_td,$a);

      return $a;
    }

    function replace_chars($a){
      $a=str_replace("\n",'',$a);
      $a=str_replace('  ','',$a);
      $a=str_replace(', ',',',$a);
      $a=str_replace(': ',':',$a);
      //$a=str_replace("\n",'',$a);
      //$a=str_replace(' ','',$a);

      return $a;
    }
/*
+-----------------+
| RENDER          |
+-----------------+ */
    function Render($return=false) {
//      if (strlen($this->sql)>0 && $this->link) {
      //DIBUJAR CONTENEDOR Y TITULO
        $cache = '<div class="htmloc_listcontent"'. $this->style_content . $this->id_content.'>'. "\n";
        $cache .= '<h3 class="htmloc_caption"><span>'. $this->caption .'</span></h3>'."\n";

      //INICIAR VARIABLES
        if ($this->enable_search!==NULL) {
          $this->form_name            = ($this->form_name=='')          ? 'htmloc_search'                         : $this->form_name;
          $this->form_action          = ($this->form_action=='')        ? '#'                                     : $this->form_action;
          $this->form_onSubmit        = ($this->form_onSubmit=='')      ? ''                                      : ' onSubmit="'.$this->form_onSubmit.'"';
          $this->form_button_submit   = ($this->form_button_submit=='') ? '<button type="submit">Buscar</button>' : $this->form_button_submit;
          $this->form_button_reset    = ($this->form_button_reset=='')  ? '<button type="reset">Limpiar</button>' : $this->form_button_reset;

        //DIBUJAR FORMULARIO
          $cache .= '<form'. $this->id_form .' name="'.$this->form_name.'" action="'. $this->form_action .'"'.$this->form_onSubmit.' method="post">'."\n";
          $cache .= $this->hidden_objects;
          $cache .= '<div'. $this->style_form_buttons .' class="htmloc_searchbuttons">'. $this->form_button_reset . $this->form_button_submit . "</div>\n";
        }

        if ($this->class_table===NULL) {
          $this->class_table=' class="htmloc_grid"';
        }

        if ($this->class_tr===NULL) {
          $this->class_tr=' class="_TR-SHADOW"'; //MAS TARDE SERA REEMPLAZADO
        }

        if ($this->paging_pageregs<=0 || is_numeric($this->paging_pageregs)==false) {
          $this->paging_pageregs=50;
        }

        if ($this->paging_from<=0 || is_numeric($this->paging_from)==false) {
          $this->paging_from=1;
        }

      //DEBUG
      //  print $this->sql;

      //REALIZAR LA CONSULTA SQL DE NUMERO DE RESULTADOS
        if(strpos($this->sql,' LIMIT')>0) {
          $this->link->query(substr($this->sql,0,strpos($this->sql,' LIMIT')).';');
          $num_registros = $this->link->affected_rows;
        //REALIZAR LA CONSULTA SQL QUE POSTERIORMENTE SE MOSTRARA
          $result=$this->link->query($this->sql);
        } elseif (strlen($this->sql)>0) {
        //REALIZAR LA CONSULTA SQL QUE POSTERIORMENTE SE MOSTRARA
          $result=$this->link->query($this->sql);
          $num_registros = $this->link->affected_rows;
        } else {
          $result=null;
          $num_registros=0;
        }

      //DIBUJAR PAGINACION
        if ($this->enable_paging!=NULL) {
          $paging_from=($paging_from=='') ? '1' : $paging_from;
          if ($num_registros < $this->paging_pageregs) {
            $cache .= '
              <div'. $this->style_form_paging .' class="htmloc_paging">Encontrados '. $num_registros .'</div><input name="htmloc_frompage" id="htmloc_frompage" value="1" type="hidden" /><input name="htmloc_numregs" id="htmloc_numregs" value="'.$this->paging_pageregs.'" type="hidden" />'."\n";
          } else {
            $cache .= '<div'. $this->style_form_paging .' class="htmloc_paging">Encontrados '. $num_registros .' | Pagina <input type="text" name="htmloc_frompage" id="htmloc_frompage" value="'. $this->paging_from .'" style="width:2em;text-align:center;" /> de <strong>'. ceil($num_registros / $this->paging_pageregs) .'</strong> | Mostrar <select name="htmloc_numregs" id="htmloc_numregs"><option value="25">25</option><option value="50" selected>50</option><option value="75">75</option><option value="100">100</option></select> resultados por pagina'."</div>\n";
          }
        }

      //DIBUJAR TABLA
        $cache .= '<table'. $this->style_table . $this->class_table .' rules="all"'. $this->id_table .'>'. "\n";
        //print ' <caption>'. $this->caption .'</caption>'. "\n";

      //DIBUJAR ETIQUETAS: COL
        if (strlen($this->style_cols)>0) {
          $estilos=explode(',',$this->style_cols);
          $cache .= ' <colgroup>'. "\n";
          foreach ($estilos as $index=>$estilo) {
            if(strlen($estilo)>0) {
              $cache .= '  <col style="'. $estilo .'" />'. "\n";
            } else {

              $cache .= '  <col />'. "\n";
            }
          }
          $cache .= ' </colgroup>'. "\n";
        }

      //DIBUJAR NOMBRES DE COLUMNA
        if (strlen($this->colnames)>0) {
          $nombres=explode(',',$this->colnames);

          $cache .= ' <thead'. $this->style_thead . $this->class_thead. '>' . "\n";
          $cache .= '  <tr'. $this->style_tr ." class=\"htmloc_coltitle\">\n";
          foreach ($nombres as $index=>$nombre) {
            $cache .= '   <th'. $this->style_th . $this->class_th .'><span>'. $nombre .'</span></th>'. "\n";
          }
          $cache .= "  </tr>\n";

        //DIBUJAR BARRA DE BUSQUEDA...
          if ($this->enable_search==true) {
            $cache .= '  <tr class="htmloc_searchform">'. "\n";
            if (strlen($this->form_searchbar)>0) {
            //...PERSONALIZADA
              $cstm_sb=explode(',',$this->form_searchbar);
              $buffer='';
              foreach ($cstm_sb as $index=>$value) {
                $buffer.='   <th>'. $value .'</th>'. "\n";
              }
              //REEMPLAZAR VARIABLES
              foreach ($cstm_sb as $index=>$value) {
                $buffer=str_replace("_R[$index]",$this->r[$index],$buffer);
              }
              $cache .= $buffer;
            } else {
            //...ESTANDAR
              foreach ($nombres as $index=>$value) {
                $cache .= '   <th><input type="text" name="r['. $index .']" value="'. $this->r[$index] .'" /></th>'. "\n";
              }
            }
            $cache .= "  </tr>\n";
          }

          $cache .= " </thead>\n";
        }

        $cache .= ' <tbody'. $this->style_tbody . $this->class_tbody. '>' . "\n";

        $cont_tr=0;
        $pointer_shadow=0;

        $shadow_class[0]='';
        $shadow_class[1]='htmloc_shadow';

      //DIBUJAR RESULTADOS OBTENIDOS DE LA CONSULTA SQL
        if ($num_registros > 0) {
          while($row=$result->fetch_row())
          {
            $cont_tr++;
            $cont_td=1;
            $pointer_shadow=($pointer_shadow==1) ? 0 : 1;

          //AÑADIR STARTCOL SI EXISTIERA Y SUSTITUIR INDICES, CLASES, ESTILOS E IDS
            $td_inicio=$this->replace_vars($this->startcol);
            $td_fin=$this->replace_vars($this->endcol);

            $buffer='  <tr'. $this->style_tr . str_replace('_TR-SHADOW', $shadow_class[$pointer_shadow],$this->class_tr) . $this->id_tr .'>' . "\n";
            $buffer.=str_replace('_NUM-TD','0',$td_inicio);

            foreach ($row as $index=>$valor) {
              if (stripos($this->hidden_rows, "$index")===false){
              //SUSTITUIR INDICES, CLASES, ESTILOS, ID Y VALORES
                $buffer.=str_replace('_NUM-TD',$cont_td,'   <td'. $this->style_td . $this->class_td . $this->id_td .'>'. $valor .'</td>'. "\n");
                $cont_td++;
              }
            }

          //AÑADIR ENDCOL SI EXISTIERA
            $buffer.=$this->replace_vars($td_fin);

          //SUSTITUIR ROW[x] POR EL VALOR CORRESPONDIENTE
            foreach ($row as $index=>$valor) {
              $buffer=str_replace('_ROW['.$index.']',$valor,$buffer);
            }

            $buffer.='  </tr>'. "\n";

          //SUSTITUIR OTROS INDICES
            $buffer=str_replace('_NUM-TR',$cont_tr,$buffer);
            $buffer=str_replace('_NUM-TD',$cont_td,$buffer);
            $buffer=str_replace('_ROWCODE',$row[$this->rowcode],$buffer);

          //VOLCAR BUFFER EN CACHE
            $cache .= $buffer;
          }
          $cache .= ' </tbody>'. "\n";
          $cache .= '</table>'. "\n";
        } else {
        //IMPRIMIR MENSAJE DE ERROR
          $cache .= ' </tbody>'. "\n";
          $cache .= '</table>'. "\n";

          if ($result===null) {
           //SI $result ES NULO ES PORQUE LA VARIABLE $sql ESTÁ VACÍA Y NO HA PODIDO HACERSE LA CONSULTA SQL
            $cache .= '<div class="htmloc_msg_querynoresult">Realice su b&uacute;squeda</div>'."\n";
          } else {
            $cache .= '<div class="htmloc_msg_querynoresult">No se ha obtenido ning&uacute;n resultado</div>'."\n";
          }
        }

        if ($this->enable_search==true) {
          $cache .= '</form>'. "\n";
        }
        $cache .= '</div>'. "\n";
//      }

       //IMPRIMIR RESULTADO FINAL
        if ($return===false && $return!='return') {
          print $cache;
        } else {
          return $cache;
        }
    }
  }

/************************************************
** DropDownList By ALBERTO HERNANDEZ: 28/10/2008
*************************************************/

  class obj_ddl {
    public $link;
    public $sql;

    public $name;
    public $id;
    public $class;
    public $style;

    public $selected_value;
    public $selected_name;

    public $id_option;
    public $options;
//---------------------------------------------------------------------------------------------
    function __construct( $name=null, $id=null )
    {
        $this->name = $name;
        $this->id = $id;
    }
//---------------------------------------------------------------------------------------------
    function add_option( $options )
    /**
     * @param $options: String [caption1=value1;caption2=value2;...] | Array('caption'=>'value',...)
     * @return null
     */
    {
        if(is_array($options))
            foreach($options as $caption=>$value)
                $this->options .= "$caption=$value;";
        else
            $this->options .= rtrim($options,';').';';
    }
//---------------------------------------------------------------------------------------------
    function set_sql($a) {
      $this->sql = $a;
    }
//---------------------------------------------------------------------------------------------
    function set_link($db) {
      $this->link = $db;
    }
//---------------------------------------------------------------------------------------------
    function set_class($a) {
      $this->class = ' class="'.$a.'"';
    }
//---------------------------------------------------------------------------------------------
    function set_style($a) {
      $this->style = $a;
    }
//---------------------------------------------------------------------------------------------
    function set_selected_value($a) {
      $this->selected_value = $a;
    }
//---------------------------------------------------------------------------------------------
    function set_selected_name($a) {
      $this->selected_name = $a;
    }
//---------------------------------------------------------------------------------------------
    function set($a) {
      $a=str_replace("\n",'',$a);
      $a=str_replace('  ','',$a);
      $a=str_replace(', ',',',$a);
      $a=str_replace(': ',':',$a);

      $propiedades=explode(',',$a);

      foreach ($propiedades as $index=>$propiedad) {
        $trozos=explode(':',$propiedad);
        $this->$trozos[0]=$trozos[1];
      }
    }
//---------------------------------------------------------------------------------------------
    function Render($return=false) {
      $indxsel=0;
      $selected_item=$this->selected_value;

      if (strlen($this->selected_name)>0) {
          $indxsel=1;
          $selected_item=$this->selected_name;
      }

      $cache = '<select name="'. $this->name .'" id="'. $this->id .'"'. $this->class .'>'. "\n";
      if(empty($selected_item))
          $cache .= ' <option value="">Seleccione ...</option>'. "\n";

      if(!empty($this->options))
      {
        $sw=false;
        foreach(explode(';',$this->options,128) as $option)
        {
            list($caption,$value) = explode('=',$option,2);
            if(!empty($value))
            {
                if ($sw===false && ($caption==$selected_item || $value==$selected_item)){
                    $cache .= ' <option selected="selected" value="'. $value .'" style="font-weight:bold;">'. $caption .'</option>'. "\n";
                    $sw=true;
                } else {
                    $cache .= ' <option value="'. $value .'">'. $caption .'</option>'. "\n";
                }
            }
        }
      }

      if (strlen($this->sql)>0 && $this->link) {
        $result=$this->link->query($this->sql);

        while($row=$result->fetch_row()) {
          if ($sw===false && $row[$indxsel]==$selected_item){
            $cache .= ' <option selected="selected" value="'. $row[0] .'" style="font-weight:bold;">'. $row[1] .'</option>'. "\n";
            $sw=true;
          } else {
            $cache .= ' <option value="'. $row[0] .'">'. $row[1] .'</option>'. "\n";
          }
        }
      }
      $cache .= '</select>';

      //IMPRIMIR RESULTADO FINAL
      if ($return===false && $return!='return') {
        echo $cache;
      } else {
        return $cache;
      }
    }
  }
?>
