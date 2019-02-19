<?php

namespace app\models;

use Yii;
use \app\models\base\Recurso as BaseRecurso;
use yii\helpers\ArrayHelper;

use yii\base\Exception;

/**
 * This is the model class for table "recurso".
 */
class Recurso extends BaseRecurso
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                [['fecha_baja','fecha_acreditacion','fecha_inicial','fecha_alta'], 'date', 'format' => 'php:Y-m-d'],
                ['fecha_baja', 'validarFechaBaja'],
                ['personaid', 'existePersonaEnRegistral'],
                ['personaid', 'compare','compareValue'=>0,'operator'=>'!=','message' => 'No se pudo registrar la persona correctamente en el Sistema Registral.']
            ]
        );
    }
    
    public function validarFechaBaja(){          
        
        if(date('Y-m-d') < $this->fecha_baja){
            $this->addError('fecha_baja', 'La fecha de baja no puede ser mayor a la de hoy '.date('Y-m-d'));
        }
        
        if($this->fecha_alta > $this->fecha_baja){
            $this->addError('fecha_baja', 'La fecha de baja no puede ser menor a la fecha de alta '.$this->fecha_alta);
        }
    }
    
    public function existePersonaEnRegistral(){
        $response = \Yii::$app->registral->buscarPersonaPorId($this->personaid);     
        
        if(isset($response['estado']) && $response['estado']!=true){
            $this->addError('id', 'La persona con el id '.$this->personaid.' no existe!');
        }
    }
    
    /**
     * Se vinculan los alumnos(Persona) con la capación que bringa el programa Emprender, En otras palabras
     * se vinculan alumnos con el recurso_social
     * @throws Exception
     */
    public function vincularAlumnosAEmprender($param){
        if(!is_array($param['alumno_lista'])){
            throw new Exception("La lista de alumnos es invalida");
        }

        foreach ($param['alumno_lista'] as $vAula) { 
            if(!isset($vAula['alumnoid'])){
                throw new Exception("La lista de alumnos es invalida");
            }                   

            $aula = new Aula();
            $aula->setAttributes([
                'recursoid'=>$this->id,
                'alumnoid'=>$vAula['alumnoid']
            ]);

            if(!$aula->save()){
                $arrayErrors['aula'][] = $aula->getErrors();
                throw new Exception(json_encode($arrayErrors));
            }
        }
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
        ]);
        
    }
}
