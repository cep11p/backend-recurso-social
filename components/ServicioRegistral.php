<?php

/*
 * Clase para interactuar con el servicio de solicitudes de la oficina judicial
 *
 */

namespace app\components;
use yii\base\Component;
use GuzzleHttp\Client;
use app\models\PersonaForm;
use Exception;


/**
 * Description of ServicioSolicitudComponent
 *
 * @author mboisselier
 */
class ServicioRegistral extends Component implements IServicioRegistral
{
    public $base_uri;
    private $_client;
   
    public function __construct(Client $guzzleClient, $config=[])
    {
        parent::__construct($config);
        $this->_client = $guzzleClient;
    }
   
    /**
     *
     * @param string $legajo
     * @param string $organismo
     * @param string $fiscalAnterior
     * @param string $fiscalActual
     * @return string $id Es el id de la persona
     */
    public function crearPersona($data)
    {
        $client =   $this->_client;
        try{
            \Yii::error(json_encode($data));
            $headers = [
                'Authorization' => 'Bearer ' .\Yii::$app->params['JWT_REGISTRAL'], 
           ];          
            
            
            $response = $client->request('POST', 'http://registral/api/personas', ['json' => $data,'headers' => $headers]);
            $respuesta = json_decode($response->getBody()->getContents(), true);
            \Yii::error($respuesta);
            return $respuesta['data']['id'];
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
                \Yii::$app->getModule('audit')->data('catchedexc', \yii\helpers\VarDumper::dumpAsString($e->getResponse()->getBody()));
                \Yii::error('Error de integración:'.$e->getResponse()->getBody(), $category='apioj');
                return false;
        } catch (Exception $e) {
                \Yii::$app->getModule('audit')->data('catchedexc', \yii\helpers\VarDumper::dumpAsString($e));
                \Yii::error('Error inesperado: se produjo:'.$e->getMessage(), $category='apioj');
                return false;
        }
       
    }
    
    public function actualizarPersona($data)
    {        
        $client =   $this->_client;
        try{
            \Yii::error(json_encode($data));
            $headers = [
                'Authorization' => 'Bearer ' .\Yii::$app->params['JWT_REGISTRAL'],
            ];          
            
            
            $response = $client->request('PUT', 'http://registral/api/personas/'.$data['id'], ['json' => $data,'headers' => $headers]);
            $respuesta = json_decode($response->getBody()->getContents(), true);
            \Yii::error($respuesta);
            
            return $respuesta['data']['id'];
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
                \Yii::$app->getModule('audit')->data('catchedexc', \yii\helpers\VarDumper::dumpAsString($e->getResponse()->getBody()));
                \Yii::error('Error de integración:'.$e->getResponse()->getBody(), $category='apioj');
                return false;
        } catch (Exception $e) {
                \Yii::$app->getModule('audit')->data('catchedexc', \yii\helpers\VarDumper::dumpAsString($e));
                \Yii::error('Error inesperado: se produjo:'.$e->getMessage(), $category='apioj');
                return false;
        }
       
    }
    
    public function buscarPersonaPorNroDocumento($nro_documento)
    {
       
        $client =   $this->_client;
        try{
            $headers = [
                'Authorization' => 'Bearer ' .\Yii::$app->params['JWT_REGISTRAL'],
                'Content-Type'=>'application/json'
            ];          
            
            $response = $client->request('GET', 'http://registral/api/personas/buscar-por-documento/'.$nro_documento, ['headers' => $headers]);
            $respuesta = json_decode($response->getBody()->getContents(), true);
            \Yii::error($respuesta);
            
            return $respuesta;
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
                \Yii::$app->getModule('audit')->data('catchedexc', \yii\helpers\VarDumper::dumpAsString($e->getResponse()->getBody()));
                \Yii::error('Error de integración:'.$e->getResponse()->getBody(), $category='apioj');
                return false;
        } catch (Exception $e) {
                \Yii::$app->getModule('audit')->data('catchedexc', \yii\helpers\VarDumper::dumpAsString($e));
                \Yii::error('Error inesperado: se produjo:'.$e->getMessage(), $category='apioj');
                return false;
        }
       
    }
    
    public function buscarPersonaPorId($id)
    {
        $client =   $this->_client;
        try{
            $headers = [
                'Authorization' => 'Bearer ' .\Yii::$app->params['JWT_REGISTRAL'],
                'Content-Type'=>'application/json'
            ];          
            
            $response = $client->request('GET', 'http://registral/api/personas?id='.$id, ['headers' => $headers]);
            $respuesta = json_decode($response->getBody()->getContents(), true);
            \Yii::info($respuesta);
            
            return $respuesta;
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
                \Yii::$app->getModule('audit')->data('catchedexc', \yii\helpers\VarDumper::dumpAsString($e->getResponse()->getBody()));
                \Yii::error('Error de integración:'.$e->getResponse()->getBody(), $category='apioj');
                return false;
        } catch (Exception $e) {
                \Yii::$app->getModule('audit')->data('catchedexc', \yii\helpers\VarDumper::dumpAsString($e));
                \Yii::error('Error inesperado: se produjo:'.$e->getMessage(), $category='apioj');
                return false;
        }
       
    }
    
    
    /**
     * Busca el nucleo que tengan los atributos que viene por $param
     * @param array $param un array de atributos del nucleoForm
     * @param string $nombre
     * @return obtenemos una respuesta de registral
     */
    public function buscarNucleo($param)
    {
        $criterio = $this->crearCriterioBusquedad($param);
        $client =   $this->_client;
        try{
            $headers = [
                'Authorization' => 'Bearer ' .\Yii::$app->params['JWT_REGISTRAL'],
                'Content-Type'=>'application/json'
            ];          
            
            $response = $client->request('GET', 'http://registral/api/nucleos?'.$criterio, ['headers' => $headers]);
            $respuesta = json_decode($response->getBody()->getContents(), true);
            \Yii::info($respuesta);
            
            return $respuesta;
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
                \Yii::$app->getModule('audit')->data('catchedexc', \yii\helpers\VarDumper::dumpAsString($e->getResponse()->getBody()));
                \Yii::error('Error de integración:'.$e->getResponse()->getBody(), $category='apioj');
                return false;
        } catch (Exception $e) {
                \Yii::$app->getModule('audit')->data('catchedexc', \yii\helpers\VarDumper::dumpAsString($e));
                \Yii::error('Error inesperado: se produjo:'.$e->getMessage(), $category='apioj');
                return false;
        }
       
    }
    
    public function buscarNucleoPorId($id)
    {
        $client =   $this->_client;
        try{
            $headers = [
                'Authorization' => 'Bearer ' .\Yii::$app->params['JWT_REGISTRAL'],
                'Content-Type'=>'application/json'
            ];          
            
            $response = $client->request('GET', 'http://registral/api/nucleos?id='.$id, ['headers' => $headers]);
            $respuesta = json_decode($response->getBody()->getContents(), true);
            \Yii::info($respuesta);
            
            return $respuesta;
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
                \Yii::$app->getModule('audit')->data('catchedexc', \yii\helpers\VarDumper::dumpAsString($e->getResponse()->getBody()));
                \Yii::error('Error de integración:'.$e->getResponse()->getBody(), $category='apioj');
                return false;
        } catch (Exception $e) {
                \Yii::$app->getModule('audit')->data('catchedexc', \yii\helpers\VarDumper::dumpAsString($e));
                \Yii::error('Error inesperado: se produjo:'.$e->getMessage(), $category='apioj');
                return false;
        }
       
    }
    
    public function buscarNivelEducativoPorId($id)
    {
        $client =   $this->_client;
        try{
            $headers = [
                'Authorization' => 'Bearer ' .\Yii::$app->params['JWT_REGISTRAL'],
                'Content-Type'=>'application/json'
            ];          
            
            $response = $client->request('GET', 'http://registral/api/nivel-educativo?id='.$id, ['headers' => $headers]);
            $respuesta = json_decode($response->getBody()->getContents(), true);
            \Yii::info($respuesta);
            
            return $respuesta;
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
                \Yii::$app->getModule('audit')->data('catchedexc', \yii\helpers\VarDumper::dumpAsString($e->getResponse()->getBody()));
                \Yii::error('Error de integración:'.$e->getResponse()->getBody(), $category='apioj');
                return false;
        } catch (Exception $e) {
                \Yii::$app->getModule('audit')->data('catchedexc', \yii\helpers\VarDumper::dumpAsString($e));
                \Yii::error('Error inesperado: se produjo:'.$e->getMessage(), $category='apioj');
                return false;
        }
       
    }
    
    

    public function buscarHogar($param)
    {
//        $paramLimpio = \app\components\Help::extraerArrayDeArrayAsociativo($param,['localidadid','calle','altura','depto','piso','barrio']);
        $criterio = $this->crearCriterioBusquedad($param);
        $client =   $this->_client;
        try{
            $headers = [
                'Authorization' => 'Bearer ' .\Yii::$app->params['JWT_REGISTRAL'],
                'Content-Type'=>'application/json'
            ];          
            
            $response = $client->request('GET', 'http://registral/api/hogar?'.$criterio, ['headers' => $headers]);
            $respuesta = json_decode($response->getBody()->getContents(), true);
            \Yii::info($respuesta);
            
            return $respuesta;
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
                \Yii::$app->getModule('audit')->data('catchedexc', \yii\helpers\VarDumper::dumpAsString($e->getResponse()->getBody()));
                \Yii::error('Error de integración:'.$e->getResponse()->getBody(), $category='apioj');
                return false;
        } catch (Exception $e) {
                \Yii::$app->getModule('audit')->data('catchedexc', \yii\helpers\VarDumper::dumpAsString($e));
                \Yii::error('Error inesperado: se produjo:'.$e->getMessage(), $category='apioj');
                return false;
        }
       
    }
    
    public function buscarPersona($param)
    {
        $criterio = $this->crearCriterioBusquedad($param);
        $client =   $this->_client;
        try{
            $headers = [
                'Authorization' => 'Bearer ' .\Yii::$app->params['JWT_REGISTRAL'],
                'Content-Type'=>'application/json'
            ];          
            
            $response = $client->request('GET', 'http://registral/api/personas?'.$criterio, ['headers' => $headers]);
            $respuesta = json_decode($response->getBody()->getContents(), true);
            \Yii::info($respuesta);
            
            return $respuesta;
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
                \Yii::$app->getModule('audit')->data('catchedexc', \yii\helpers\VarDumper::dumpAsString($e->getResponse()->getBody()));
                \Yii::error('Error de integración:'.$e->getResponse()->getBody(), $category='apioj');
                return false;
        } catch (Exception $e) {
                \Yii::$app->getModule('audit')->data('catchedexc', \yii\helpers\VarDumper::dumpAsString($e));
                \Yii::error('Error inesperado: se produjo:'.$e->getMessage(), $category='apioj');
                return false;
        }
       
    }
    
    /**
     * Se devuelve una coleccion de Sexos.
     * NOTA!... Hay que tener en cuenta que el SexoController del sistema Registral no soporta filtrado, es decir que los parametros enviados va a ser inrrelevantes
     * @param array $param
     * @return boolean
     */
    public function buscarSexo($param)
    {
        
        $criterio = $this->crearCriterioBusquedad($param);
        $client =   $this->_client;
        try{
            $headers = [
                'Authorization' => 'Bearer ' .\Yii::$app->params['JWT_REGISTRAL'],
//                'Content-Type'=>'application/json'
            ];          
            
            $response = $client->request('GET', 'http://registral/api/sexo?'.$criterio, ['headers' => $headers]);
            $respuesta = json_decode($response->getBody()->getContents(), true);
            \Yii::error($respuesta);
            
            return $respuesta;
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
                \Yii::$app->getModule('audit')->data('catchedexc', \yii\helpers\VarDumper::dumpAsString($e->getResponse()->getBody()));
                \Yii::error('Error de integración:'.$e->getResponse()->getBody(), $category='apioj');
                return false;
        } catch (Exception $e) {
                \Yii::$app->getModule('audit')->data('catchedexc', \yii\helpers\VarDumper::dumpAsString($e));
                \Yii::error('Error inesperado: se produjo:'.$e->getMessage(), $category='apioj');
                return false;
        }
       
    }
    
    /**
     * Se devuelve una coleccion de Genero.
     * NOTA!... Hay que tener en cuenta que el GeneroController del sistema Registral no soporta filtrado, es decir que los parametros enviados van a ser inrrelevantes
     * @param array $param
     * @return boolean
     */
    public function buscarGenero($param)
    {
        
        $criterio = $this->crearCriterioBusquedad($param);
        $client =   $this->_client;
        try{
            $headers = [
                'Authorization' => 'Bearer ' .\Yii::$app->params['JWT_REGISTRAL'],
//                'Content-Type'=>'application/json'
            ];          
            
            $response = $client->request('GET', 'http://registral/api/genero?'.$criterio, ['headers' => $headers]);
            $respuesta = json_decode($response->getBody()->getContents(), true);
            \Yii::error($respuesta);
            
            return $respuesta;
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
                \Yii::$app->getModule('audit')->data('catchedexc', \yii\helpers\VarDumper::dumpAsString($e->getResponse()->getBody()));
                \Yii::error('Error de integración:'.$e->getResponse()->getBody(), $category='apioj');
                return false;
        } catch (Exception $e) {
                \Yii::$app->getModule('audit')->data('catchedexc', \yii\helpers\VarDumper::dumpAsString($e));
                \Yii::error('Error inesperado: se produjo:'.$e->getMessage(), $category='apioj');
                return false;
        }
       
    }
    
    /**
     * Se devuelve una coleccion de Estados Civiles.
     * NOTA!... Hay que tener en cuenta que el EstadoCivilController del sistema Registral no soporta filtrado, es decir que los parametros enviados van a ser inrrelevantes
     * @param array $param
     * @return boolean
     */
    public function buscarEstadoCivil($param)
    {
        
        $criterio = $this->crearCriterioBusquedad($param);
        $client =   $this->_client;
        try{
            $headers = [
                'Authorization' => 'Bearer ' .\Yii::$app->params['JWT_REGISTRAL'],
//                'Content-Type'=>'application/json'
            ];          
            
            $response = $client->request('GET', 'http://registral/api/estado-civil?'.$criterio, ['headers' => $headers]);
            $respuesta = json_decode($response->getBody()->getContents(), true);
            \Yii::error($respuesta);
            
            return $respuesta;
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
                \Yii::$app->getModule('audit')->data('catchedexc', \yii\helpers\VarDumper::dumpAsString($e->getResponse()->getBody()));
                \Yii::error('Error de integración:'.$e->getResponse()->getBody(), $category='apioj');
                return false;
        } catch (Exception $e) {
                \Yii::$app->getModule('audit')->data('catchedexc', \yii\helpers\VarDumper::dumpAsString($e));
                \Yii::error('Error inesperado: se produjo:'.$e->getMessage(), $category='apioj');
                return false;
        }
       
    }
    
    public function buscarNivelEducativo($param)
    {
        $criterio = $this->crearCriterioBusquedad($param);
        $client =   $this->_client;
        try{
            $headers = [
                'Authorization' => 'Bearer ' .\Yii::$app->params['JWT_REGISTRAL'],
//                'Content-Type'=>'application/json'
            ];          
            
            $response = $client->request('GET', 'http://registral/api/nivel-educativos?'.$criterio, ['headers' => $headers]);
            $respuesta = json_decode($response->getBody()->getContents(), true);
            \Yii::error($respuesta);
            
            return $respuesta;
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
                \Yii::$app->getModule('audit')->data('catchedexc', \yii\helpers\VarDumper::dumpAsString($e->getResponse()->getBody()));
                \Yii::error('Error de integración:'.$e->getResponse()->getBody(), $category='apioj');
                return false;
        } catch (Exception $e) {
                \Yii::$app->getModule('audit')->data('catchedexc', \yii\helpers\VarDumper::dumpAsString($e));
                \Yii::error('Error inesperado: se produjo:'.$e->getMessage(), $category='apioj');
                return false;
        }
       
    }
    
    /**
     * crear un string con los criterio de busquedad por ejemplo: localidadid=1&calle=mata negra&altura=123
     * @param array $param
     * @return string
     */
    public function crearCriterioBusquedad($param){
        $criterio = '';
        $primeraVez = true;
        foreach ($param as $key => $value) {
            if($primeraVez){
                $criterio.=$key.'='.$value;
                $primeraVez = false;
            }else{
                $criterio.='&'.$key.'='.$value;
            }            
        }
        
        return $criterio;
    }
    
    
    
    /**
     * 
     * @param int $nro_documento
     * @return int personaid
     */
    public static function buscarPersonaEnRegistralPorNumeroDocuemento($nro_documento)
    {
        $resultado = null;
        
        return $resultado;
    }
   
   
   
       
}