<?php
namespace app\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\Response;

use Yii;
use yii\base\Exception;

use \app\models\PersonaForm;

class PersonaController extends ActiveController{
    
    public $modelClass = 'app\models\Programa';
    
    public function behaviors()
    {

        $behaviors = parent::behaviors();     

        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className()
        ];

        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;

        $behaviors['authenticator'] = $auth;

        $behaviors['authenticator'] = [
            'class' => \yii\filters\auth\HttpBearerAuth::className(),
        ];

        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = ['options'];     

        $behaviors['access'] = [
            'class' => \yii\filters\AccessControl::className(),
            'only' => ['index', 'view', 'create','update','contacto','buscar-por-documento'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index'],
                    'roles' => ['consultar_persona'],
                ],
                [
                    'allow' => true,
                    'actions' => ['view'],
                    'roles' => ['consultar_persona'],
                ],
                [
                    'allow' => true,
                    'actions' => ['create'],
                    'roles' => ['crear_modificar_persona'],
                ],
                [
                    'allow' => true,
                    'actions' => ['update'],
                    'roles' => ['crear_modificar_persona'],
                ],
                [
                    'allow' => true,
                    'actions' => ['contacto'],
                    'roles' => ['crear_modificar_persona'],
                ],
                [
                    'allow' => true,
                    'actions' => ['buscar-por-documento'],
                    'roles' => ['consultar_persona'],
                ],
            ]
        ];



        return $behaviors;
    }
    
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['index']);
        unset($actions['view']);
        return $actions;
    
    }
    
    /**
     * Esta accion permite hacer una interoperabilidad con el sistema registral
     * @return array()
     */
    public function actionIndex()
    {
        $resultado['estado']=false;
        $param = Yii::$app->request->queryParams;
        
        
        $resultado = \Yii::$app->registral->buscarPersona($param);
        
        if($resultado['estado']!=true){
            $data['success']=false;
            $data['total_filtrado']=0;            
            $data['resultado']=[];
            $data['message']="No se encontró ninguna persona!";   
        }else{
            $data['success']=true;            
            $data['total_filtrado']=$resultado['total_filtrado'];
            $data['pages']=$resultado['pages'];
            $data['pagesize']=$resultado['pagesize'];
            $data['resultado']=$resultado['resultado'];
        }
        
        return $data;

    }
    
    public function actionView($id)
    {
        $resultado = \Yii::$app->registral->viewPersona($id);
                
        if($resultado['estado']!=true){
            $data = $resultado;       
        }else{
            $data = $resultado;  
        }
        
        return $data;

    }
    
    public function actionCreate()
    {
        $resultado['message']='Se registró una nueva persona';
        $param = Yii::$app->request->post();
        
        try {
            $model = new PersonaForm();
            $model->setAttributesAndSave($param);
            
            $resultado['success']=true;
            $resultado['data']['id']=$model->id;
            
            return $resultado;
           
        }catch (Exception $exc) {
            $mensaje =$exc->getMessage();
            throw new \yii\web\HttpException(400, $mensaje);
        }

    }
    
    /**
     * Este update es necesario que por parametros vengas los datos obligatorios de persona y/o de lugar
     * @param int $id
     * @return array
     * @throws \yii\web\HttpException
     * @throws Exception
     */
    public function actionUpdate($id)
    {
        $resultado['message']='Se modifica una Persona';
        $param = Yii::$app->request->post();
        try {   
            
            if(is_int($id)){
                throw new Exception("El id es invalido.");
            }
                        
            $param['id'] = $id;            
            $model = new PersonaForm();
            $model->setAttributesAndSave($param);
            
            $resultado['success']=true;
            $resultado['data']['id']=$model->id;
            
            return $resultado;
           
        }catch (Exception $exc) {
            $mensaje =$exc->getMessage();
            throw new \yii\web\HttpException(400, $mensaje);
        }

    }
    
    /**
     * Solo se editan los datos de contacto: email, telefono, celular, red social
     * @param int $id
     * @return array 
     * @throws \yii\web\HttpException
     * @throws Exception
     */
    public function actionContacto($id)
    {
        $resultado['message']='Se modifica los datos de contacto de una Persona';
        $param = Yii::$app->request->post();
        try {   
            
            if(is_int($id)){
                throw new Exception("El id es invalido.");
            }
            
            #es necesario concatenar el id
            $param = \yii\helpers\ArrayHelper::merge(['id'=>$id], $param);
            
            $model = new PersonaForm();
            $model->buscarPersonaPorIdEnRegistral($id);
            $model->setContacto($param);
            
            if(!$model->save()){
                throw new Exception(json_encode($model->getErrors()));
            }
            
            $resultado['success']=true;
            $resultado['data']['id']=$model->id;
            
            return $resultado;
           
        }catch (Exception $exc) {
            $mensaje =$exc->getMessage();
            throw new \yii\web\HttpException(400, $mensaje);
        }

    }
    
    /**
     * Se busca una persona por numero documento
     * @param type $nro_documento
     * @Method GET
     * @url ejemplo http://api.pril.local/api/personas/buscar-por-documento/29800100
     * @return array
     */
    public function actionBuscarPorDocumento($nro_documento)
    {
        $resultado['estado']=false;   
        $resultado = \Yii::$app->registral->buscarPersonaPorNroDocumento($nro_documento);
        
//        print_r($resultado);die();
        
        if(isset($resultado['resultado']) && count($resultado['resultado'])>0){
            $data['success']=true;
            $data['resultado']=$resultado['resultado'];
        }else{
            $data['success']=false;  
            $data['message']="No se encontró ninguna persona!";
        }

        return $data;

    }
    
}