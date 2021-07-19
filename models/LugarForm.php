<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "Lugar".
 */
class LugarForm extends Model
{
    public $id;
    public $nombre;
    public $calle;
    public $altura;
    public $localidadid;
    public $latitud;
    public $longitud;
    public $barrio;
    public $piso;
    public $depto;
    public $escalera;
    
    public function rules()
    {
        return [
            [['calle', 'localidadid'], 'required'],
            [['localidadid','id'], 'integer'],
            [['nombre', 'calle', 'altura', 'latitud', 'longitud', 'barrio', 'piso', 'depto', 'escalera'], 'string', 'max' => 200],
        ];
    }
    
    /**
     * Se registra un lugar con el sistemaLugar (interoperabilidad)
     * @return boolean
     */
    public function save(){
        $resultado = null;
        
        if($this->validate()){
            $id = intval(\Yii::$app->lugar->crearLugar($this->toArray()));
            $resultado = $this->id = $id;
            
        }else{
            $resultado = false;
        } 
        
        return $resultado;
    }
    
    /**
     * Vamos a filtrar lugares según el criterio, es decir
     * que vamos a chequear si coinciden los atributos
     * @return LugarForm $lugarEncontrado;
     */
    public function buscarLugarEnSistemaLugar($params = null) {
        
        $resultado = null;
        if(isset($params)){
            $response = \Yii::$app->lugar->buscarLugar($params);   
        }else{
            $response = \Yii::$app->lugar->buscarLugar($this->attributes);
        }
        
        if(isset($response['success']) && $response['success']==true){

            $resultado = $response['resultado'];
        }
        
        return $resultado;
    }
    
    /**
     * Vamos a filtrar localidades según el criterio, es decir
     * que vamos a chequear si coinciden los atributos
     * @return array $resultado se devuelve una coleccion de localidades;
     */
    public function buscarLocalidadEnSistemaLugar($params = null) {
        
        $resultado = null;
        if(isset($params)){
            $response = \Yii::$app->lugar->buscarLocalidad($params);   
        }
        
        if(isset($response['resultado']) && count($response['resultado'])>0){

            $resultado = $response['resultado'];
        }
        
        return $resultado;
    }
    
    /**
     * Vamos a filtrar delegaciones según el criterio, es decir
     * que vamos a chequear si coinciden los atributos
     * @return array $resultado se devuelve una coleccion de delegaciones;
     */
    public function buscarDelegacionEnSistemaLugar($params = array()) {
        $resultado = [];
        $response = \Yii::$app->lugar->buscarDelegacion($params);   
        
        if(count($response)>0){

            $resultado = $response;
        }

        return $resultado;
    }
    
    /**
     * Vamos a filtrar municipios según el criterio, es decir
     * que vamos a chequear si coinciden los atributos
     * @return array $resultado se devuelve una coleccion de municipios;
     */
    public function buscarMunicipioEnSistemaLugar($params = array()) {
        
        $resultado = null;
        $response = \Yii::$app->lugar->buscarMunicipio($params);   
        
        if(count($response)>0){

            $resultado = $response;
        }
        
        return $resultado;
    }
    
    /**
     * Vamos a filtrar comisiones de fomento según el criterio, es decir
     * que vamos a chequear si coinciden los atributos
     * @return array $resultado se devuelve una coleccion de comisiones de fomento;
     */
    public function buscarComisionFomentoEnSistemaLugar($params = array()) {
        
        $resultado = null;
        $response = \Yii::$app->lugar->buscarComisionFomento($params);   
        
        
        if(count($response)>0){

            $resultado = $response;
        }
//        print_r($resultado);die();
        return $resultado;
    }
    
    /**
     * Vamos a filtrar un localidad por id
     * @return array $resultado se devuelve una localidad;
     */
    public function buscarLocalidadPorIdEnSistemaLugar($params = null) {
        
        $resultado = null;
        if(isset($params)){
            $response = \Yii::$app->lugar->buscarLocalidadPorId($params);   
        }
        
        if(isset($response['nombre'])){

            $resultado = $response;
        }
        
        return $resultado;
    }
    
    /**
     * Buscamos la delegacion por id y obtenemos el nombre
     * @param int $id
     * @return array
     */
    public function buscarDelegacionPorId($id = '') {
        $resultado = [];
        $response = \Yii::$app->lugar->buscarDelegacionPorId($id);   
        
        if(count($response)>0){
            $resultado = $response;
        }
        return $resultado;
    }
    
    /**
     * Buscamos el municipio por id
     * @param int $id
     * @return array
     */
    public function buscarMunicipioPorId($id = '') {
        $resultado = [];
        $response = \Yii::$app->lugar->buscarMunicipioPorId($id);   
        
        if(count($response)>0){
            $resultado = $response;
        }
        return $resultado;
    }
    
    /**
     * Buscamos la comision de fomento por id
     * @param int id
     * @return array
     */
    public function buscarComisionFomentoPorId($id = '') {
        $resultado = [];
        $response = \Yii::$app->lugar->buscarComisionFomentoPorId($id);   
        
        if(count($response)>0){
            $resultado = $response;
        }
        return $resultado;
    }
    
    /**
     * Vamos a ver si existe un lugar identico en el sistema lugar, es decir
     * que vamos a buscar un lugar unico
     * @return LugarForm $lugarEncontrado;
     */
    public function buscarLugarIdenticoEnSistemaLugar($params = null) {
        
        $response = array();
        if(isset($params)){
            $response = \Yii::$app->lugar->buscarLugarIdentico($params);   
        }else{
            $response = \Yii::$app->lugar->buscarLugarIdentico($this->attributes);
        }
        
        return $response;
    }
    
    public function buscarLugarPorIdEnSistemaLugar($id) {
        
        $resultado = null;
        $response = \Yii::$app->lugar->buscarLugarPorId($id);   
        
        if(isset($response['success']) && $response['success']==true){

            if(count($response['resultado'])>0){            
                foreach ($response['resultado'] as $modeloEncontrado){
                    $resultado = $modeloEncontrado;
                }
            }
        }
        
        return $resultado;
    }
    
    
}
