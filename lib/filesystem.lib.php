<?php
    function catch_include( $filename, $catch_error=false )
    /**
     * @desc    Incluye un archivo si este existe, si no existe devuelve la variable $catch_error
     * @param   $filename     string: Ruta absoluta del fichero a incluir
     * @param   $catch_error  string | integer | boolean
     * @return  include( $filename ) | $catch_error
     */
    {
        if(file_exists( $filename ) && is_readable( $filename ))
            return include( $filename );
        else
            return $catch_error;
    }

# ------------------------------------------------------------------------------------
    function read_dir($dir,$filetypes='',$approot2webroot=false,$banderas=null,$recursive=false,$n_recurses=0) {
    /**
     * GLOB_MARK        - Agrega una barra a cada elemento devuelto
     * GLOB_NOSORT      - Devuelve los archivos como aparecen en el directorio (sin ordenar)
     * GLOB_NOCHECK     - Devuelve el patron de busqueda si no se han encontrado archivos coincidentes
     * GLOB_NOESCAPE    - Las barras invertidas no son usadas para escapar metacaracteres
     * GLOB_BRACE       - Expande {a,b,c} para que coincida con 'a', 'b', o 'c'
     * GLOB_ONLYDIR     - Devuelve unicamente entradas de directorios que coinciden con el patron
     * GLOB_ERR         - Detenerse en errores de lectura (como directorios inaccesibles), los errores son ignorados por omision.
     */
        if( empty( $dir ) || $n_recurses > 64){
            return false;
        } else {
            $arbol=array();
            $n_recurses++;
            $dir=(substr($dir,-1)!='/')? $dir.'/' : $dir;
            if( empty( $filetypes ) || $filetypes == '*'){
                foreach (glob($dir.'*',$banderas) as $filename) {
                  $arbol[] = $filename;
                  //array_push($arbol, $filename);
                  if(is_dir($filename) && $recursive == true)
                      $arbol= array_merge($arbol, read_dir($filename,$filetypes,$approot2webroot,$banderas,$recursive,$n_recurses));
                }
            } else {
                foreach (glob($dir.'*',$banderas) as $filename) {
                  if(preg_match($filetypes, $filename))
                      $arbol[] = $filename;
                      //array_push($arbol, $filename);

                  if(is_dir($filename) && $recursive == true)
                    $arbol = array_merge($arbol, read_dir($filename,$filetypes,$approot2webroot,$banderas,$recursive,$n_recurses));
                }
            }

            if ($approot2webroot===true) {
                foreach($arbol as $i=>$a){
                    //$arbol[$i] = str_replace(PATH_private,PATH_public,$a);
                    $arbol[$i] = PATH_public.substr($a,strlen(PATH_private));
                }
            }

            # Ordenar arbol
            sort($arbol);
            reset($arbol);

            return $arbol;
        }
    }

# ------------------------------------------------------------------------------------

    function rmdir_recurse($d,$savethis=false) {
        $d= rtrim($d, '/').'/';
        $result=true;
        if(file_exists($d)) {
            $handle = opendir($d);
            for (;false !== ($file = readdir($handle));)
                if($file != "." and $file != ".." )
                {
                    $fullpath= $d.$file;
                    if( is_dir($fullpath) )
                    {
                        $result *= rmdir_recurse($fullpath);
                        (file_exists($fullpath)) ? rmdir($fullpath) : null;
                    }
                    else
                      unlink($fullpath);
                }
            closedir($handle);
            ($savethis==false && $result)?rmdir($d) : null;
            return $result;
         }
         else
             return false;
    }
# ------------------------------------------------------------------------------------

    function clean_file_name($file_name)
    /**
     * @desc    Limpia un nombre de fichero o directorio a fin de evitar problemas de tipo: /home//fichero.txt ; /home/../../.././\/\///etc/passwd
     * @param   $file_name   String: Nombre del fichero o directorio. No tiene por que ser un nombre absoluto
     * @return  String
     */
    {
        $file_name = str_replace('\\','', $file_name);
/*
        $file_name = str_replace('..','', $file_name);
        while(strpos($filename, '//')){
            $filename = str_replace('//','/', $filename);
        }
*/
        return preg_replace(array('/(\.+)/','/(\/+)/'), array('.','/'),$file_name);
    }

#--------------------------------------------------------------------------------------------------------

    function count_files( $folder )
    {
        if(is_readable( $folder ))
            return count(read_dir($folder));
        else
            return 0;
    }
?>
