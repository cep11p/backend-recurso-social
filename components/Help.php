<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;
use yii\helpers\ArrayHelper;

class Help extends \yii\base\Component{

    public static function ArrayErrorsToString($errors = []){
        $oracion = '';
        foreach ($errors as $key => $value) {
            foreach ($value as $msj) {
                $oracion .= (empty($oracion))?$msj:"\r\n ".$msj;
            }
        }

        return $oracion;
    }

    public static function obtenerEdad($fecha_nacimiento)
    {

        list($anioCumple,$mesCumple,$diaCumple)=explode("-", $fecha_nacimiento);
        list($anioHoy,$mesHoy,$diaHoy)=explode("-", date('Y-m-d'));


        $edad = intval($anioHoy) - intval($anioCumple);
        if(intval($diaCumple) >= intval($diaHoy)){//diaCumple mayor
            if(intval($mesCumple) > intval($mesHoy)){
                $edad--;
            }
        }else{ //diaCumple menor
            if(intval($mesCumple) > intval($mesHoy)){
                $edad--;
            }

        }

        return strval($edad);
    }

    /**
     * Vamos a extrar un array de una array por las keys seteadas
     * @param array $arrays_colection es la coleccion de arrays que se obtiene para filtrar
     * @param array $array_search array a buscar
     * @return array
     * @author cep11p
     */
    public static function filtrarArrayAsociativo($arrays_colection, $array_search)
    {

        $resultado = null;
        $array_search = array_filter($array_search);

        foreach ($arrays_colection as $array) {

            $array = array_filter($array);
            $array_found = $array;
            unset($array['id']);

            if($array == $array_search){
                $resultado = $array_found;
            }
        }  

        return $resultado;
    }

    /*
    * filtering an array
    */
    public static function filter_by_value ($array, $index, $value){
        $resultado = array();
        if(is_array($array) && count($array)>0) 
        {
            foreach(array_keys($array) as $key){
                $temp[$key] = $array[$key][$index];

                if ($temp[$key] == $value){
                    $resultado[] = $array[$key];
                }
            }
          }
        return $resultado;
    } 

    /**
     * Se sacan todas las tildes
     * @param string $cadena
     * @return string
     */
    public static function quitar_tildes($cadena) {
        $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
        $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
        $texto = str_replace($no_permitidas, $permitidas ,$cadena);
        return $texto;
    }

    /**
     * Se recibe un lugar para componer la dirección
     * @param array $lugar
     * @return string $direccion
     */
    public static function componerDireccion($lugar) {

        $dir = '';
        $dir .= (!empty($lugar['calle']))?' '.$lugar['calle']:'';
        $dir .= (!empty($lugar['altura']))?' '.$lugar['altura']:'';
        $dir .= (!empty($lugar['piso']))?' piso: '.$lugar['piso']:'';
        $dir .= (!empty($lugar['depto']))?' dpto: '.$lugar['depto']:'';
        $dir .= (!empty($lugar['escalera']))?' esc/mod: '.$lugar['escalera']:'';
        $dir .= (!empty($lugar['barrio']))?', Bº: '.$lugar['barrio']:'';

        return $dir;
    }

    /**
     * Se recibe una array con datos de persona para componer contacto (numeros de telefonos y/o celulares)
     * @param array $persona
     * @return string
     */
    public static function componerContacto($persona) {

        $contacto = '';

        #si existe el télefono lo agregamos
        $contacto .=(isset($persona['telefono']) && !empty($persona['telefono']))?$persona['telefono']:'';
        #Si existe telefono y celular agregamos ', '
        $contacto .=(!empty($contacto) && isset($persona['celular']) && !empty($persona['celular']))?', ':'';
        #Si existe celular lo agregamos 
        $contacto .=(isset($persona['celular']) && !empty($persona['celular']))?$persona['celular']:'';

        return $contacto;
    }

    /**
     * Se recibe una prestacion y se define el estado (Acreditado, Sin Acreditar, Baja)
     * @param array $prestacion
     * @return string
     */
    public static function componerEstadoPrestacion($prestacion) {

        $estado = '';

        #Baja
        if($prestacion['baja']){
            $estado = 'Baja';
        }

        #Sin Acreditar
        if(!$prestacion['baja'] && !$prestacion['acreditacion']){
            $estado = 'Sin Acreditar';
        }

        #Acreditado
        if(!$prestacion['baja'] && $prestacion['acreditacion']){
            $estado = 'Acreditado';
        }

        return $estado;
    }
} 