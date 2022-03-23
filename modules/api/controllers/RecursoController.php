<?php
namespace app\modules\api\controllers;

use app\models\Programa;
use yii\rest\ActiveController;
use yii\web\Response;

use Yii;
use yii\base\Exception;

use app\models\Recurso;
use PHPUnit\Framework\Constraint\ExceptionCode;

class RecursoController extends ActiveController{
    
    public $modelClass = 'app\models\Recurso';
    
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
            'only' => ['index', 'view', 'create','baja','acreditar'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index'],
                    'roles' => ['usuario'],
                ],
                [
                    'allow' => true,
                    'actions' => ['view'],
                    'roles' => ['usuario'],
                ],
                [
                    'allow' => true,
                    'actions' => ['create'],
                    'roles' => ['usuario'],
                ],
                [
                    'allow' => true,
                    'actions' => ['baja'],
                    'roles' => ['usuario'],
                ],
                [
                    'allow' => true,
                    'actions' => ['acreditar'],
                    'roles' => ['usuario'],
                ]
            ]
        ];

        return $behaviors;
    }
    
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['view']);
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    
    }
    
    public function prepareDataProvider() 
    {
        $searchModel = new \app\models\RecursoSearch();
        $params = \Yii::$app->request->queryParams;
        $resultado = $searchModel->busquedadGeneral($params);

        return $resultado;
    }
    
    public function actionFiltrarPrestacion()
    {
        $searchModel = new \app\models\RecursoSearch();
        $params = \Yii::$app->request->post();
        
        $resultado = $searchModel->busquedadGeneral($params);

        return $resultado;
    }
    
    public function actionCreate()
    {
        $resultado['message']='Se guarda una prestacion';
        $param = Yii::$app->request->post();

        #Chequeamos el permiso
        if (!\Yii::$app->user->can('prestacion_crear', ['prestacion' => ['programaid'=>$param['programaid']]])) {
            throw new \yii\web\HttpException(403, 'No se tienen permisos necesarios para ejecutar esta acción');
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
       
            $model = new Recurso();
            $model->setAttributesCustom($param);

            if(!$model->save()){
                throw new \yii\web\HttpException(400,json_encode($model->getErrors()));
            }
            
            $model->setResponsableEntrega($param);
            
            /*****  Guardamos coleccion de alumnos si el pregroma es "Emprender" o "Recrear" *****/

            #Validamos que el programa emprender deba tener una lista de alumnos
            if((!isset($param['alumno_lista']) || (count($param['alumno_lista'])==0)) &&  $model->programa->nombre == 'Emprender'){
                throw new \yii\web\HttpException(400, 'Falta la lista de alumnos para el programa Emprender');
            }

            if(isset($param['alumno_lista']) && (count($param['alumno_lista'])>0) &&  ($model->programaid == Programa::EMPRENDER || $model->programaid == Programa::RECREAR)){
                $model->vincularAlumnosAEmprender($param);
            }

            $transaction->commit();
            
            $resultado['success']=true;
            $resultado['data']['id']=$model->id;
            
            return  $resultado;
           
        }catch (\yii\web\HttpException $exc) {
            $transaction->rollBack();
            $mensaje =$exc->getMessage();
            $statuCode =$exc->statusCode;
            throw new \yii\web\HttpException($statuCode, $mensaje);
        }

    }
    
    public function actionView($id)
    {
        $resultado['message']='Se visualiza una prestacion';
        $model = Recurso::findOne(['id'=>$id]);            
        if($model==NULL){
            throw new \yii\web\HttpException(400, 'El recurso con el id '.$id.' no existe!');
        }

        #Chequeamos permiso
        if(!Yii::$app->user->can('prestacion_ver',['prestacion' => ['programaid'=>$model->programaid]])){
            throw new \yii\web\HttpException(403, 'No se tienen permisos necesarios para ejecutar esta acción');
        }
        
        $resultado = $model->toArray();
        $resultado['lista_cuota'] = $model->cuotas;
        $resultado['cant_cuota'] = $model->getCantCuota();
        $resultado['monto_mensual_acreditado'] = $model->getMontoMensualAcreaditado();
        $resultado['monto_total_acreditado'] = $model->getMontoTotalAcreaditado();
        $resultado['monto_resto'] = $model->monto - $model->getMontoTotalAcreaditado();
        $resultado['localidad'] = $model->getLocalidad();
        $resultado['persona'] = $model->getPersona();
        $resultado['responsable_entrega'] = $model->getResponsableEntregaNombre().' ('.ucfirst($model->responsableEntrega->tipoResponsable->nombre).')';
        
        if(count($model->getAlumnos())!=0){
            $resultado['alumno_lista'] = $model->getAlumnos();
        }
        
        return $resultado;
    }
    
    /**
     * Esta función permite registrar la baja de un recurso social (prestacion)
     * @param int $id
     * @return array
     * @throws \yii\web\HttpException
     * @throws Exception
     */
    public function actionBaja($id)
    {
        $resultado['message']='Se da de baja un recurso';
        $param = Yii::$app->request->post();
        $transaction = Yii::$app->db->beginTransaction();
        try{
            $model = Recurso::findOne(['id'=>$id]);            
            
            if($model==NULL){
                $msj = 'El recurso con el id '.$id.' no existe!';
                throw new \yii\web\HttpException(400,$msj);
            }

            #Chequeamos Permiso
            if (!Yii::$app->user->can('prestacion_baja',['prestacion' => ['programaid'=>$model->programaid]])) {
                throw new \yii\web\HttpException(403, 'No se tienen permisos necesarios para ejecutar esta acción');
            }
            
            $model->setScenario(Recurso::SCENARIO_BAJA);
            $model->setAttributesBaja($param);
            if(!$model->save()){
                throw new \yii\web\HttpException(400,json_encode($model->getErrors()));
            }
            
            $resultado['success']=true;
            $resultado['message']=$resultado['message'];
            $resultado['data']['id']=$model->id;
            
            $transaction->commit();
            
            return $resultado;
           
        }catch (\yii\web\HttpException $exc) {
            $transaction->rollBack();
            $mensaje = $exc->getMessage();
            $statuCode = $exc->statusCode;
            throw new \yii\web\HttpException($statuCode, $mensaje);
        }

    }
    
    /**
     * Se realiza setea el atributo baja de la tabla aula, para indicarnos si el alumno está o no dado de baja
     *
     * @return void
     */
    public function actionBajaAlumno()
    {
        $param = Yii::$app->request->post();
        $transaction = Yii::$app->db->beginTransaction();

        #Chequeamos el permiso
        if (!\Yii::$app->user->can('prestacion_crear', ['prestacion' => ['programaid'=>$param['programaid']]])) {
            throw new \yii\web\HttpException(403, 'No se tienen permisos necesarios para ejecutar esta acción');
        }


        try{
            
            $msj = Recurso::bajaAlumno($param);            
            
            $resultado['success'] = true;
            $resultado['message'] = $msj;
            
            $transaction->commit();
            
            return $resultado;
           
        }catch (\yii\web\HttpException $exc) {
            $transaction->rollBack();
            $mensaje = $exc->getMessage();
            $statuCode = $exc->statusCode;
            throw new \yii\web\HttpException($statuCode, $mensaje);
        }

    }

    public function actionAcreditar($id)
    {
        $resultado['message']='Se acredita la prestacion';
        $param = Yii::$app->request->post();
        $transaction = Yii::$app->db->beginTransaction();
        try{
            
            $model = Recurso::findOne(['id'=>$id]);            
            if($model==NULL){
                $msj = 'El recurso con el id '.$id.' no existe!';
                throw new \yii\web\HttpException(400,$msj);
            }

            #Chequeamos Permiso
            if (!Yii::$app->user->can('prestacion_acreditar',['prestacion' => ['programaid'=>$model->programaid]])) {
                throw new \yii\web\HttpException(403, 'No se tienen permisos necesarios para ejecutar esta acción');
            }
            
            $model->setAttributesAcreditar($param);
            
            if(!$model->save()){
                throw new \yii\web\HttpException(400,json_encode($model->getErrors()));
            }
            

            $resultado['success']=true;
            $resultado['message']=$resultado['message'];
            $resultado['data']['id']=$model->id;
            
            $transaction->commit();
            
            return $resultado;
           
        }catch (\yii\web\HttpException $exc) {
            $transaction->rollBack();
            $mensaje =$exc->getMessage();
            $statuCode = $exc->statusCode;
            throw new \yii\web\HttpException($statuCode, $mensaje);
        }

    }
    
}