<?php

namespace app\models;

use app\components\Help;
use Yii;
use \app\models\base\Recurso as BaseRecurso;
use yii\db\Query;
use yii\helpers\ArrayHelper;

use \yii\web\HttpException;

/**
 * This is the model class for table "recurso".
 */
class Recurso extends BaseRecurso
{
    const SCENARIO_BAJA = 'baja';
    const SCENARIO_ACREDITACION = 'acreditacion';
    const PRESTACION_MODULO_ALIMENTAR_ID = 6;
    const PRESTACION_MODULO_ALIMENTAR = 6;
    const TIPO_RESPONSABLE_MUNICIPIO= 1;
    const TIPO_RESPONSABLE_DELEGACION= 2;
    const TIPO_RESPONSABLE_COMISION_FOMENTO= 3;
    
    /**
     * Atributo correspondiente a la tabla responsable, esto nos permite hacer un join con responsable y poder filtrar prestaciones de tipo reponsable
     * @var int 
     */
    public $tipo_responsableid;
    
    /**
     * variable auxiliar
     * cuantifica la cantidad de recursos que tiene un beneficiario
     * @var int 
     */
    public $recurso_cantidad;    
    /**
     * Variable auxiliar para filtrado
     * Es el monto total del filtrado aplicado en ese momento
     * @var double 
     */
    public $monto_total;    
    /**
     * Variable auxiliar para filtrado
     * Es el monto acreditado
     * @var double 
     */
    public $monto_acreditado;
    /**
     * Variable auxiliar para filtrado
     * Es el monto baja
     * @var double 
     */
    public $monto_baja;
    /**
     * Variable auxiliar para filtrado
     * Es la cantidad de recursos baja
     * @var int
     */
    public $recurso_baja_cantidad;
    /**
     * Variable auxiliar para filtrado
     * Es la cantidad de recursos acreditado
     * @var int
     */
    public $recurso_acreditado_cantidad;


    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # vinculamos el audit
                'bedezign\yii2\audit\AuditTrailBehavior',
            ]
        );
    }
    
    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                ['monto', 'double'],
                [['localidadid'], 'required','message' =>'No hay localidad asignada a la prestación'],
                [['cant_modulo','personaid'], 'required', 'on' => self::PRESTACION_MODULO_ALIMENTAR],
                [['descripcion_baja', 'fecha_baja'], 'required', 'on' => self::SCENARIO_BAJA],
                [['fecha_baja','fecha_acreditacion','fecha_inicial','fecha_alta'], 'date', 'format' => 'php:Y-m-d'],
                ['fecha_baja', 'validarFechaBaja'],
                ['fecha_alta', 'validarFechaAlta'],
                ['fecha_acreditacion', 'validarFechaAcreditacion'],
                ['personaid', 'existePersonaEnRegistral'],
                ['localidadid', 'existeLocalidadEnLugar'],
                ['personaid', 'compare','compareValue'=>0,'operator'=>'!=','message' => 'No se pudo registrar la persona correctamente en el Sistema Registral.'],
                ['monto_mensual', 'compare','compareAttribute'=>'monto','operator'=>'<','message' => 'El monto mensual no debe ser mayo al monto total','type' => 'number']
            ]
        );
    }

    static function bajaAlumno($param){

        if(!isset($param['alumnoid']) || empty($param['alumnoid'])){
            throw new HttpException(400,"Falta el alumno para realizar la baja/alta");
        }

        if(!isset($param['recursoid']) || empty($param['recursoid'])){
            throw new HttpException(400,"Falta el recurso");
        }

        $model = Recurso::findOne(['id'=>$param['recursoid']]);            
        if($model==NULL){
            throw new \yii\web\HttpException(400, 'El recurso con el id '.$param['recursoid'].' no existe!');
        }

        #Chequeamos el permiso
        if (!\Yii::$app->user->can('prestacion_crear', ['prestacion' => ['programaid'=>$model->programaid]])) {
            throw new \yii\web\HttpException(403, 'No se tienen permisos necesarios para ejecutar esta acción');
        }

        $alumno = Aula::findOne(['recursoid' => $param['recursoid'], "alumnoid" => $param['alumnoid']]);
        
        if($param['baja'] == 1){
            
            if(!isset($param['motivo_baja']) || empty($param['motivo_baja'])){
                throw new HttpException(400,json_encode(['error' =>['Falta motivo']]));
            }

            $alumno->baja = 1;
            $alumno->motivo_baja = $param["motivo_baja"];

            $resultado = "Alumno dado de baja";
        }else{
            $alumno->baja = 0;
            $alumno->motivo_baja = "";
            $resultado = "Alumno dado de alta";
        }

        if(!$alumno->save()){
            throw new HttpException(400,Help::ArrayErrorsToString($alumno->getErrors()));
        }        

        return $resultado;
    }
    
    public function setAttributesCustom($values, $safeOnly = true) {
        parent::setAttributes($values, $safeOnly);
        $this->fecha_inicial = date('Y-m-d');
        $this->lugar_capacitacion = "";

        if(isset($this->programaid) && $this->programa->id == $this::PRESTACION_MODULO_ALIMENTAR_ID){
            $this->fecha_alta = (!empty($this->fecha_alta))?\DateTime::createFromFormat('Y-m-d', $this->fecha_alta)->format('Y-m-d'): date('Y-m-d');
            $this->fecha_acreditacion = $this->fecha_alta;
        }

        #Lugar de capacitacion para el programa Emprender y/o Recrear
        if(isset($this->programaid) && ($this->programa->id == Programa::EMPRENDER || $this->programa->id == Programa::RECREAR)){
            $this->lugar_capacitacion = (isset($values['lugar_capacitacion']) && !empty($values['lugar_capacitacion']))?$values['lugar_capacitacion']:""; 
        }

        #Validamos que hayan taller caducados(Programa Emprender). Un tallerista puede tener un taller cada 4 meses
        if(isset($this->programaid) && ($this->programa->id == Programa::EMPRENDER)){
            $taller = Recurso::findByCondition([
                'personaid' => $this->personaid, 
                'programaid' => $this->programaid])
                ->andWhere(['fecha_baja' => null])
                ->andWhere(['<', 'fecha_alta', $this->fecha_alta])
                ->andWhere(['>', 'fecha_final', $this->fecha_alta])
                ->asArray()->all();
            if($taller != null){
                $this->addError('error','El beneficiario ya tiene un taller vigente.');
                throw new HttpException(400,json_encode($this->errors));
            }
        }
        
        #si cuota = False
        if($this->cuota==0){
            $this->monto_mensual=0;
        }
    }
    
    /**
     * Realizamos el registro de un reponsable
     * @param array $param atributos de la tabla responsable
     * @throws HttpException
     */
    public function setResponsableEntrega($param) {
        if(isset($this->programaid) && $this->programa->id == $this::PRESTACION_MODULO_ALIMENTAR_ID){
            $model = new ResponsableEntrega();
            $model->setAttributes($param);
            $model->recursoid = $this->id;

            if(!$model->save()){
                throw new HttpException(json_encode($model->getErrors()));
            }
        }
    }


    public function validarFechaBaja(){          
        if(date('Y-m-d') < $this->fecha_baja){
            $this->addError('fecha_baja', 'La fecha de baja no puede ser mayor a la fecha de hoy '.date('d/m/Y'));
        }
    }
    
    public function validarFechaAlta(){          
        
       #Se borra la validacion de fecha_alta
    }
    
    public function validarFechaAcreditacion(){          
        
        if(date('Y-m-d') < $this->fecha_acreditacion){
            $this->addError('fecha_acreditacion', 'La fecha de acreditacion no puede ser mayor a la de hoy '.date('d/m/Y'));
        }
        
        if($this->fecha_alta > $this->fecha_acreditacion){
            $fechaAMostrar = \DateTime::createFromFormat("Y-m-d", $this->fecha_alta);
            $this->addError('fecha_acreditacion', 'La fecha de acreditacion no puede ser menor a la fecha de alta '.$fechaAMostrar->format('d/m/Y'));
        }        
    }
    
    public function existePersonaEnRegistral(){
        // $response = \Yii::$app->registral->buscarPersonaPorId($this->personaid);     
        $response = \Yii::$app->registral->viewPersona($this->personaid);     
        #Chequeamos si la persona existe
        if(!isset($response) || empty($response)){
            $this->addError('id', 'La persona con el id '.$this->personaid.' no existe!');
        }

        #Calle
        if(!isset($response['lugar']['calle']) || empty($response['lugar']['calle'])){
            $this->addError('calle', 'La persona debe tener calle');
        }
        #Altura
        if(!isset($response['lugar']['altura']) || empty($response['lugar']['altura'])){
            $this->addError('altura', 'La persona debe tener la altura de su domicilio');
        }
        #Localidad
        if(!isset($response['lugar']['localidadid']) && empty($response['lugar']['localidadid'])){
            $this->addError('localidad', 'Falta la localidad de la persona');       
        }
    }
    
    public function existeLocalidadEnLugar(){
        $response = \Yii::$app->lugar->buscarLocalidadPorId($this->localidadid); 
        if(!isset($response['nombre'])){
            $this->addError('localidadid', 'La localidad con el id '.$this->localidadid.' no existe!');
        }
    }
    
    public function setAttributesAcreditar($values) {

        #Chequeamos que el monto sea mayor a 0
        if(!isset($values['monto']) || empty($values['monto']) || $values['monto']==0){
            throw new \yii\web\HttpException(400,'El monto debe ser mayor a 0 para acreditar');
        }
        #Chequeamos que la prestacion que no esté paga
        if($this->getMontoTotalAcreaditado() == $this->monto){
            throw new \yii\web\HttpException(400,'La prestacion ya esta totalmente acreditada');
        }
        #Chequeamos que el monto de cuota no sea mayor al monto de prestacion
        if(($this->getMontoTotalAcreaditado() + $values['monto'])>$this->monto){
            throw new \yii\web\HttpException(400,'El monto de la cuota supera al monto de la prestacion ($'.$this->monto.') monto restante:($'.$this->getMontoResto().')');
        }
        
        
        
        $cuota = new Cuota();
        #Si cuota es falso, pagamos el monto total de un solo pago(sin cuotas)
        $cuota->monto = ($this->cuota==0)?$this->monto:$values['monto'];
        $cuota->recursoid = $this->id;
        $cuota->fecha_pago = (isset($values['fecha_acreditacion']) || !empty($values['fecha_acreditacion']))?$values['fecha_acreditacion']:date('Y-m-d');
        
        if(!$cuota->save()){
            throw new \yii\web\HttpException(400,json_encode($cuota->getErrors()));
        }
        
        if($this->monto == $this->sumarCuotasDeUnaPrestacion()){
            $this->fecha_acreditacion = date('Y-m-d');
        }
    }

    /**
     * Se suma el monto de todas las cuotas de una prestacion
     *
     * @return double
     */
    public function sumarCuotasDeUnaPrestacion(){
        $query = new Query();
        
        $query->select([
                'monto_acreditado'=>'sum(c.monto)'
            ]);
        $query->from('cuota as c');
        $query->leftJoin('recurso r','r.id=c.recursoid');
        $query->where(['r.id'=>$this->id]);

        $command = $query->createCommand();
        $rows = $command->queryAll();
        
        $resultado = ($rows[0]['monto_acreditado']=='')?0:$rows[0]['monto_acreditado'];
        return doubleval($resultado);       
    }
    
    public function setAttributesBaja($values) {
        if(isset($values['fecha_baja'])){
            $this->fecha_baja = $values['fecha_baja']; 
        }
        if(isset($values['descripcion_baja'])){
            $this->descripcion_baja = $values['descripcion_baja']; 
        }
    }

    /**
     * Se vinculan los alumnos(Persona) a la capacitación que brinda el programa Emprender y/o Recrear, En otras palabras
     * se vinculan alumnos con el recurso_social
     * @throws HttpException
     */
    public function vincularAlumnosAEmprender($param){
        if(!is_array($param['alumno_lista'])){
            throw new HttpException("La lista de alumnos es invalida");
        }

        foreach ($param['alumno_lista'] as $vAula) { 
            if(!isset($vAula['alumnoid'])){
                throw new HttpException("La lista de alumnos es invalida");
            }                   

            $aula = new Aula();
            $aula->setAttributes([
                'recursoid'=>$this->id,
                'alumnoid'=>$vAula['alumnoid']
            ]);

            if(!$aula->save()){
                $arrayErrors = $aula->getErrors();
                throw new HttpException(json_encode($arrayErrors));
            }
        }
    }
    

    /**
     * Se obtiene los datos de una persona
     * para obtener este dato se requiere hacer una interoperabilidad con el sistema Registral
     * @return type
     */
    public function getPersona(){
        $resultado = null;
        $model = new PersonaForm();
        $arrayPersona = $model->obtenerPersonaConLugarYEstudios($this->personaid);

        if($arrayPersona){
            $resultado = $arrayPersona;
        }        
        
        return $resultado;       
        
    }
    
    /**
     * Se obtiene la localidad
     * para obtener este dato se requiere hacer una interoperabilidad con el sistema Lugar
     * @return array
     */
    public function getLocalidad(){
        $resultado = null;
        $model = new LugarForm();
        $arrayResultado = $model->buscarLocalidadPorIdEnSistemaLugar($this->localidadid);
        
        if($arrayResultado){
            $resultado = $arrayResultado['nombre'];
        }        
        
        return $resultado;       
        
    }
    
    /**
     * Se obtiene el nombre del responsable por interoperabilidad
     * @return string
     */
    public function getResponsableEntregaNombre() {
        $resultado = '';
        $model = new LugarForm();
        
        /**Delegacion**/
        if($this->responsableEntrega->tipo_responsableid == $this::TIPO_RESPONSABLE_DELEGACION){
            $array = $model->buscarDelegacionPorId($this->responsableEntrega->responsable_entregaid);
            $resultado = (isset($array['nombre']))?$array['nombre']:'';
        }
        /**Municipio**/
        if($this->responsableEntrega->tipo_responsableid == $this::TIPO_RESPONSABLE_MUNICIPIO){
            $array = $model->buscarMunicipioPorId($this->responsableEntrega->responsable_entregaid);
            $resultado = (isset($array['nombre']))?$array['nombre']:'';
        }
        /**ComisionFomento**/
        if($this->responsableEntrega->tipo_responsableid == $this::TIPO_RESPONSABLE_COMISION_FOMENTO){
            $array = $model->buscarMunicipioPorId($this->responsableEntrega->responsable_entregaid);
            $resultado = (isset($array['nombre']))?$array['nombre']:'';
        }

        return $resultado;
    }
    
    /**
     * Se obtiene una lista de alumnos si es que el recurso tiene esa coleccion
     * @return array
     */
    public function getAlumnos(){
        $resultado = array();
        $lista_alumno = array();
        $lista_persona = array();
        $personaForm = new PersonaForm();
        $ids='';

        #Pendiente agregar los atributos del aula
        foreach ($this->aulas as $value) {
            $ids .= (empty($ids))?$value->alumnoid:','.$value->alumnoid;
            $lista_alumno[] = $value->toArray();
        }
        
        #Se van a obtener una lista de personas con la variable $ids
        if(!empty($ids)){
            $lista_persona = $personaForm->buscarPersonaEnRegistral(array("ids"=>$ids));
        }
        
        foreach ($lista_alumno as $alumno) {
            foreach ($lista_persona as $persona) {
                if($persona['id'] == $alumno['alumnoid']){
                    $persona['baja'] = $alumno['baja'];
                    $persona['motivo'] = (isset($alumno['motivo']))?$alumno['motivo']:"";
                    $resultado[] = $persona;
                }
            }
        }

        return $resultado;       
    }

    /**
     * Se calcula el el monto total acreditado
     *
     * @return double
     */
    public function getMontoTotalAcreaditado(){
        $query = new Query();
        $query->select('sum(monto) as monto_total_acreditado');
        $query->from('cuota');
        $query->where(['recursoid'=>$this->id]);

        $row = $query->createCommand()->queryAll();
        $resultado = ($row[0]['monto_total_acreditado']=='')?0:$row[0]['monto_total_acreditado'];

        return $resultado;
    }

    /**
     * Se calcula el el monto mensual acreditado
     *
     * @return array
     */
    public function getMontoMensualAcreaditado($fecha = ''){
        $fecha = empty($fecha) ? date('Y-m-d') : $fecha;
        $query = new Query();
        $query->select('sum(monto) as monto_mensual_acreditado');
        $query->from('cuota');
        $query->where(['recursoid'=>$this->id]);

        $criterio1 = "EXTRACT( YEAR_MONTH FROM '$fecha'";
        $query->andWhere(['fecha_pago'=>$criterio1]);

        $row = $query->createCommand()->queryAll();
        $resultado = ($row[0]['monto_mensual_acreditado']=='')?0:$row[0]['monto_mensual_acreditado'];

        return $resultado;
    }

    /**
     * Se calcula el monto restante a pagar
     *
     * @return int
     */
    public function getMontoResto(){
        $resultado = $this->monto - $this->getMontoTotalAcreaditado();

        return $resultado;
    }

    /**
     * Se obtiene la cantidad de cuotas pagas
     *
     * @return int void
     */
    public function getCantCuota(){
        $query = new Query();
        $query->select('count(id) as cant_cuota');
        $query->from('cuota');
        $query->where(['recursoid'=>$this->id]);

        $row = $query->createCommand()->queryAll();
        $resultado = ($row[0]['cant_cuota']=='')?0:$row[0]['cant_cuota'];

        return intval($resultado);
    }
    
    public function fields()
    {
        return ArrayHelper::merge(parent::fields(), [
            'programa'=> function($model){
                return $model->programa->nombre;
            },
            'tipo_recurso'=> function($model){
                return $model->tipoRecurso->nombre;
            },
            'responsable_entrega_data'=> function($model){
                return $model->responsableEntrega;
            },
            #Flags para injectar botones 
            'baja'=> function($model){
                $resultado = false;
                if(isset($model->fecha_baja)){
                    $resultado = true;
                }
                return $resultado;
            },
            #Flags para injectar botones
            'acreditacion'=> function($model){
                $resultado = false;
                if($model->getMontoResto() == 0){
                    $resultado = true;
                }
                return $resultado;
            },

            #Cuotas pagas
            'cuota'=> function($model){
                return ($model->cuota)?true:false;
            },
        ]);
        
    }
}
