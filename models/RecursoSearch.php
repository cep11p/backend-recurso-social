<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Recurso;
use app\rbac\PermisoPrograma;
use yii\db\Query;

/**
* RecursoSearch represents the model behind the search form about `app\models\Recurso`.
*/
class RecursoSearch extends Recurso
{
    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['id', 'programaid', 'tipo_recursoid', 'personaid','localidadid'], 'integer'],
            [['fecha_inicial', 'fecha_alta', 'observacion', 'proposito','recurso_cantidad'], 'safe'],
            [['monto'], 'number'],
        ];
    }

    /**
    * @inheritdoc
    */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
    * Creates data provider instance with search query applied
    *
    * @param array $params
    *
    * @return ActiveDataProvider
    */
    public function search($params)
    {
        $query = Recurso::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'fecha_inicial' => $this->fecha_inicial,
            'fecha_alta' => $this->fecha_alta,
            'monto' => $this->monto,
            'programaid' => $this->programaid,
            'tipo_recursoid' => $this->tipo_recursoid,
            'personaid' => $this->personaid,
        ]);

        $query->andFilterWhere(['like', 'observacion', $this->observacion])
            ->andFilterWhere(['like', 'proposito', $this->proposito]);

        return $dataProvider;
    }
    
    /**
     * Sumamos el monto total acreditado general
     * @param array $params criterio de filtrado
     * @return double
     */
    public function sumarMontoAcreditado($params){
        $query = new Query();
        
        $query->select([
                'monto_acreditado'=>'sum(c.monto)'
            ]);
        $query->from('cuota c');
        $query->leftJoin('recurso r','r.id=c.recursoid');
        $query->where(['c.recursoid' => $params['lista_ids']]);

        if(isset($params['fecha_pago']) && !empty($params['fecha_pago'])){
            $fecha_pago = $params['fecha_pago'];
            $condicion = "EXTRACT( YEAR_MONTH FROM  `c`.`fecha_pago`) = EXTRACT( YEAR_MONTH FROM  '".$fecha_pago."')";
        }else{
            $fecha_pago = date('Y').'-06-01';
            $condicion = "EXTRACT( YEAR_MONTH FROM  `c`.`fecha_pago`) <= EXTRACT( YEAR_MONTH FROM  '".$fecha_pago."')";
        }
        $query->andWhere($condicion);
        $command = $query->createCommand();
        $rows = $command->queryAll();


        $resultado = ($rows[0]['monto_acreditado']=='')?0:$rows[0]['monto_acreditado'];

        return doubleval($resultado);       
    }

     /**
     * Sumamos el monto mensual acreditado general
     * @param array $lista_prestacion 
     * @return double
     */
    public function sumarMontoMensualAcreditado($params){

        $query = new Query();        
        $query->select([
                'monto_mensual_acreditado'=>'sum(c.monto)'
            ]);
        $query->from('cuota c');
        $query->leftJoin('recurso r','r.id=c.recursoid');
        $query->where([
            'c.recursoid' => $params['lista_ids']
            ]);
        $query->andWhere("EXTRACT( YEAR_MONTH FROM  `c`.`fecha_pago`) = EXTRACT( YEAR_MONTH FROM  '".$params['fecha_pago']."')");
        $command = $query->createCommand();
        $rows = $command->queryAll();

        $resultado = ($rows[0]['monto_mensual_acreditado']=='')?0:$rows[0]['monto_mensual_acreditado'];
                
        return doubleval($resultado);       
    }
    

    /**
     * Sumamos el monto baja general
     * @param array $params criterio de filtrado
     * @return double
     */
    public function sumarMontoBaja($params){
        $query = $this->createQuery($params);
        
        $query->select([
                'monto_baja'=>'sum(monto)'
            ]);
        $query->andwhere([
                'not', ['fecha_baja' => null]
            ]);
        
        
        $command = $query->createCommand();
        $rows = $command->queryAll();
        
        $resultado = ($rows[0]['monto_baja']=='')?0:$rows[0]['monto_baja'];
                
        return doubleval($resultado);        
    }

    /**
     * Se suman todos los montos de las cuotas de prestaciones dada de baja
     *
     * @param [array] $params
     * @return double
     */
    public function sumarCuotasDePrestacionBaja($params){
        $query = new Query();
        
        $query->select([
                'monto_acreditado_baja'=>'sum(c.monto)'
            ]);
        $query->from('cuota c');
        $query->leftJoin('recurso r1','r1.id=c.recursoid');
        $query->where(['c.recursoid' => $params['lista_ids']]);
        $query->andwhere([
                'not', ['r1.fecha_baja' => null]
            ]);
        
        $command = $query->createCommand();
        $rows = $command->queryAll();
        
        $resultado = ($rows[0]['monto_acreditado_baja']=='')?0:$rows[0]['monto_acreditado_baja'];

        return doubleval($resultado);        
    }
    
    /**
     * Sumamos el monto general (suma de recursos que no estan acreditados ni dados de baja)
     * @param array $params criterio de filtrado
     * @return double
     */
    public function sumarMontoSinAcreditar($params = array()){
        $query = Recurso::find();
        
        $query->select([
                'monto_general'=>'sum(recurso.monto)'
            ]);

        $query->where(['recurso.id'=>$params['lista_ids']]);

        $command = $query->createCommand();
        $rows = $command->queryAll();
        
        
        $resultado = doubleval(($rows[0]['monto_general']=='')?0:$rows[0]['monto_general']) - $params['monto_total_acreditado'] - $this->sumarCuotasDePrestacionBaja($params);
        
        return (isset($monto_general))?0:$resultado;       

    }
    
    /**
     * Contamos la cantidad de recursos acreditados
     * @param array $params criterio de filtrado
     * @return int
     */
    public function contarRecursoAcreditado($params){
        $query = $this->createQuery($params);
        
        $query->select([
                'recurso_acreditado_cantidad'=>'count(recurso.id)'
            ]);
        $query->andWhere([
                'not', ['fecha_acreditacion' => null]
            ]);
        
        $query->andWhere(['fecha_baja' => null]);
             
        $command = $query->createCommand();
        $rows = $command->queryAll();
        $resultado = ($rows[0]['recurso_acreditado_cantidad']=='')?0:$rows[0]['recurso_acreditado_cantidad'];
                
        return intval($resultado);        
    }
    
    /**
     * Contamos la cantidad de recursos baja
     * @param array $params criterio de filtrado
     * @return int
     */
    public function contarRecursoBaja($params){
        $query = $this->createQuery($params);
        
        $query->select([
                'recurso_baja_cantidad'=>'count(recurso.id)'
            ]);
        $query->andWhere([
                'not', ['fecha_baja' => null]
            ]);
        
        $command = $query->createCommand();
        $rows = $command->queryAll();
        
        $resultado = ($rows[0]['recurso_baja_cantidad']=='')?0:$rows[0]['recurso_baja_cantidad'];
                
        return intval($resultado);        
    }
    
    private function createQuery($params) {
        $query = Recurso::find();

        $this->load($params,'');
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
             $query->where('0=1');
            return $query;
        }
        
        ############ Buscamos por datos de persona ############
        #global search #global param
        $personaForm = new PersonaForm();
        if(isset($params['global_param']) && !empty($params['global_param'])){
            $persona_params["global_param"] = $params['global_param'];
        }
        
        if(isset($params['persona']['localidadid']) && !empty($params['persona']['localidadid'])){
            $persona_params['localidadid'] = $params['persona']['localidadid'];    
        }
        
        if(isset($params['persona']['direccion']) && !empty($params['persona']['direccion'])){
            $persona_params['direccion'] = $params['persona']['direccion'];    
        }
        
        $coleccion_persona = array();
        $lista_personaid = array();
        if (isset($persona_params)) {
            
            $coleccion_persona = $personaForm->buscarPersonaEnRegistral($persona_params);
            $lista_personaid = $this->obtenerListaIds($coleccion_persona);

            if (count($lista_personaid) < 1) {
                $query->where('0=1');
            }
        }

        #Seteamos la condicion adecuada segun los permisos del usuario (Rbac + Rule)
        $query->andWhere(PermisoPrograma::setCondicionPermisoProgramaVer());
        
        #Criterio de recurso social por lista de persona.... lista de personaid
        if(count($lista_personaid)>0){
            $query->andWhere(array('in', 'personaid', $lista_personaid));
        }
        ############ Fin filtrado por Persona ############

        if(isset($this->tipo_responsableid)){
            $query->leftJoin("responsable as r", "responsable_entregaid=r.id");
            
            $query->andFilterWhere(['r.tipo_responsableid' => $this->tipo_responsableid]);
        }
        
        $query->andFilterWhere([
            'id' => $this->id,
            'fecha_inicial' => $this->fecha_inicial,
            'fecha_alta' => $this->fecha_alta,
            'recurso.monto' => $this->monto,
            'programaid' => $this->programaid,
            'tipo_recursoid' => $this->tipo_recursoid,
            'personaid' => $this->personaid,
            'localidadid' => $this->localidadid,
        ]);

        $query->andFilterWhere(['like', 'observacion', $this->observacion])
              ->andFilterWhere(['like', 'proposito', $this->proposito]);
        
        #### Filtro por rango de fecha ####
        if(isset($params['fecha_alta_desde']) && isset($params['fecha_alta_hasta'])){
            $query->andWhere(['between', 'fecha_alta', $params['fecha_alta_desde'], $params['fecha_alta_hasta']]);
        }else if(isset($params['fecha_alta_desde'])){
            $query->andWhere(['between', 'fecha_alta', $params['fecha_alta_desde'], date('Y-m-d')]);
        }else if(isset($params['fecha_alta_hasta'])){
            $query->andWhere(['between', 'fecha_alta', '1970-01-01', $params['fecha_alta_hasta']]);
        }else if(!isset($params['fecha_alta_desde']) && !isset($params['fecha_alta_hasta'])){
            $params['fecha_alta_hasta'] = date('Y').'-06-30';
            $fecha_desde = date('Y').'-06-01';
            $params['fecha_alta_desde'] = date('Y-m-d',strtotime($fecha_desde.' -1 year'));

            $query->andWhere(['between', 'fecha_alta', $params['fecha_alta_desde'], $params['fecha_alta_hasta']]);
        }

        
         #### Filtro por estado ####
        switch ($params['estado']) {
            case 'baja':
                $query->andWhere(['not', ['fecha_baja' => null]]);

                #Filtramos por pagos de cuotas #Cuota #Mes
                if(isset($params['fecha_pago']) && !empty($params['fecha_pago'])){
                    $param_fecha = $params['fecha_pago'];

                    #Buscamos que prestacion dado de baja se pagó en la fecha X
                    $condicion = "(
                        (EXTRACT( YEAR_MONTH FROM(SELECT c.fecha_pago FROM cuota c WHERE c.recursoid = recurso.id ORDER BY fecha_pago desc LIMIT 1)) =  EXTRACT( YEAR_MONTH FROM '$param_fecha' )) -- Condicion busca prestaciones con ultimo pago
                   )";
                    $query->andWhere($condicion);
                }
                break;
            case 'acreditado':                
                $query->andWhere(['not', ['fecha_acreditacion' => null]]);
                $query->andWhere(['fecha_baja' => null]);
                #Filtramos por pagos de cuotas #Cuota #Fecha Pago #Mes
                if(isset($params['fecha_pago']) && !empty($params['fecha_pago'])){
                    $param_fecha = $params['fecha_pago'];

                    #Buscamos que prestacion (acreditada) se pagó en el mes X
                    $condicion = "(SELECT c.fecha_pago 
                    FROM cuota c
                    WHERE c.recursoid = recurso.id and EXTRACT( YEAR_MONTH FROM  c.fecha_pago) = EXTRACT( YEAR_MONTH FROM  '$param_fecha')
                    LIMIT 1
                    )";
                    $query->andWhere(['not', [$condicion => null]]);
                }

                break;
            case 'sin-acreditar':
                $query->andWhere(['fecha_acreditacion' => null]);
                $query->andWhere(['fecha_baja' => null]);
                
                #Filtramos por pagos de cuotas #Cuota #Mes
                if(isset($params['fecha_pago']) && !empty($params['fecha_pago'])){
                    $param_fecha = $params['fecha_pago'];

                    #Buscamos la prestaciones que se puedan pagar en el mes X
                    $condicion = "(
                        ((SELECT count(c.fecha_pago) FROM cuota c WHERE c.recursoid = recurso.id LIMIT 1) = 0 and not (EXTRACT(YEAR_MONTH FROM recurso.fecha_alta ) > EXTRACT(YEAR_MONTH FROM '$param_fecha'))) -- Condicion busca prestaciones sin ningun pago
                         or
                        (EXTRACT( YEAR_MONTH FROM(SELECT c.fecha_pago FROM cuota c WHERE c.recursoid = recurso.id ORDER BY fecha_pago desc LIMIT 1)) <=  EXTRACT( YEAR_MONTH FROM DATE_SUB('$param_fecha', INTERVAL 1 MONTH) ) -- Condicion busca prestaciones con ultimo pago
                            and
                            EXTRACT( YEAR_MONTH FROM recurso.fecha_alta ) < EXTRACT( YEAR_MONTH FROM  '$param_fecha')) 
                   )";
                    $query->andWhere($condicion);
                }
                break;
            default :  
                #Filtramos por pagos de cuotas #Cuota #Mes
                if(isset($params['fecha_pago']) && !empty($params['fecha_pago'])){
                    $param_fecha = $params['fecha_pago'];

                    #Buscamos la prestacion que se pagó en el mes X
                    $condicion = "(SELECT c.fecha_pago 
                    FROM cuota c
                    WHERE c.recursoid = recurso.id and EXTRACT( YEAR_MONTH FROM  c.fecha_pago) = EXTRACT( YEAR_MONTH FROM  '$param_fecha')
                    LIMIT 1
                    )";
                    $query->andWhere(['not', [$condicion => null]]);
                }
                break;
        }
        
        #predeterminadamente vamos a ordenar por fecha_alta
        if(!isset($params['sort']) || empty($params['sort'])){
            $query->orderBy(['fecha_alta' => SORT_DESC]);
        }
        
        return $query;
    }

        /**
     * Se realiza un filtrado avanzado y general
     * @param array $params
     * @return ActiveDataProvider
     */
    public function busquedadGeneral($params)
    {
        $query = $this->createQuery($params);
        $pagesize = (!isset($params['pagesize']) || !is_numeric($params['pagesize']) || $params['pagesize']==0)?20:intval($params['pagesize']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pagesize,
                'page' => (isset($params['page']) && is_numeric($params['page']))?$params['page']:0
            ],
        ]);

        #Cargamos atributos
        $this->load($params,'');

        #fecha_pago
        $fecha_pago = (isset($params['fecha_pago']) || !empty($params['fecha_pago']))?$params['fecha_pago']:date('Y-m-d');
        
        
        $coleccion_recurso = array();
        $lista_ids = [];
        foreach ($dataProvider->getModels() as $value) {
            $coleccion_recurso[] = $value->toArray();
            $lista_ids[] = $value['id'];
        }

        /*******  Calculamos datos de la lista (general) *******/
        
        #Monto mensual Acreditado
        $monto_mensual_acreditado = $this->sumarMontoMensualAcreditado(['lista_ids'=>$lista_ids, 'fecha_pago' => $fecha_pago]);
        #Monto total Acreditado
        $monto_total_acreditado = $this->sumarMontoAcreditado(['lista_ids'=>$lista_ids, 'fecha_pago' => (isset($params['fecha_pago']) || !empty($params['fecha_pago']))?$params['fecha_pago']:null]);
        #Monto sin acreditar
        $monto_sin_acreditar = $this->sumarMontoSinAcreditar(['lista_ids'=>$lista_ids, 'monto_total_acreditado' => $monto_total_acreditado]);

        ######## Calculamos datos de cada prestacion #######
        if(count($coleccion_recurso)>0){

            $coleccion_recurso = $this->setValoresMontosAListaPresciones($coleccion_recurso, $fecha_pago);
        } 
        
        /*** Se obtiene datos de otros sistemas ***/
        if(count($coleccion_recurso)>0){
            #Se vinculan los datos de las personas correspondiente a cada prestacion
            $coleccion_persona = $this->obtenerPersonaVinculada($coleccion_recurso);
            $coleccion_recurso = $this->vincularPersona($coleccion_recurso, $coleccion_persona);
            
            #Vamos a obtener coleccion de ids que hacen referencia a el sistema Lugar
            $coleccion_recurso = \app\components\VinculoInteroperableHelp::obtenerYVincularParametrosDeLugar($coleccion_recurso);
            
        } 

        
        $paginas = ceil($dataProvider->totalCount/$pagesize);           
        $data['pagesize']=$pagesize;            
        $data['pages']=$paginas;            
        $data['total_filtrado']=$dataProvider->totalCount;
        $data['monto_acreditado']=(isset($monto_total_acreditado))?$monto_total_acreditado:0; //este atributo aporta en las estadisticas
        $data['monto_total_acreditado']=(isset($monto_total_acreditado))?$monto_total_acreditado:0;
        $data['monto_mensual_acreditado']=(isset($monto_mensual_acreditado))?$monto_mensual_acreditado:0;
        $data['monto_sin_acreditar']=(isset($monto_sin_acreditar))?$monto_sin_acreditar:0;
        $data['resultado']=$coleccion_recurso;

        return $data;
    }

    public function setValoresMontosAListaPresciones($coleccion_recurso, $fecha_pago){

        $lista_cant_cuota = $this->getCantCuotaPorPrestacion($coleccion_recurso);
        $lista_monto_total_acreditado = $this->getMontoTotalAcreditadoPorPrestacion($coleccion_recurso,$fecha_pago);
        $lista_monto_mensual = $this->getMontoMensualAcreditadoPorPrestacion($coleccion_recurso,$fecha_pago);
        
        $i=0;
        for ($i=0; $i < count($coleccion_recurso); $i++) { 
        
            $coleccion_recurso[$i] = $this->vincularValor($coleccion_recurso[$i], $lista_cant_cuota, 'cant_cuota');
            $coleccion_recurso[$i] = $this->vincularValor($coleccion_recurso[$i], $lista_monto_total_acreditado, 'monto_total_acreditado');
            $coleccion_recurso[$i] = $this->vincularValor($coleccion_recurso[$i], $lista_monto_mensual, 'monto_mensual_acreditado');
            $coleccion_recurso[$i]['monto_resto'] = $coleccion_recurso[$i]['monto'] - $coleccion_recurso[$i]['monto_total_acreditado'];
        }

        return $coleccion_recurso;
    }
    
    public function vincularValor($prestacion, $lista_valores, $key){

        $prestacion[$key] = 0;
        foreach ($lista_valores as $value) {
            if($prestacion['id'] == $value['recursoid']){
                $prestacion[$key] = $value[$key];
            }
        }

        return $prestacion;
    }

    /**
     * Se recibe una lista de prestaciones ids y se calcula el monto de resto de esas mismas
     *
     * @param [array] $coleccion_recurso
     * @return array
     */
    public function getMontoRestoPorPrestacion($coleccion_recurso){
        $i=0;
        foreach ($coleccion_recurso as $value) {
            if(!empty($value)){
                $coleccion_recurso[$i]['monto_resto'] = $value['monto'] - $value['monto_total_acreditado'];
            }else{
                $coleccion_recurso[$i]['monto_resto'] = 0;
            }
            $i++;
        }

        return $coleccion_recurso;
    }

    /**
     * Se recibe una lista de prestaciones ids y se calcula la cantidad de cueotas de esas mismas
     *
     * @param [array] $lista_prestacion
     * @return array
     */
    public function getCantCuotaPorPrestacion($lista_prestacion)
    {
        $lista_ids = [];
        foreach ($lista_prestacion as $value) {
            $lista_ids[] = $value['id'];
        }

        $query = new Query();
        $query->select('recursoid, count(id) as cant_cuota');
        $query->from('cuota');
        $query->where(['recursoid'=>$lista_ids]);
        $query->groupBy('recursoid');

        $row = $query->createCommand()->queryAll();

        return $row;
    }

    /**
     * Se calcula el monto mensual acreditado de cada prestacion de una fecha_pago X
     *
     * @param [array] $lista_prestacion
     * @param string $fecha_pago
     * @return array prestaciones con su monto mensual acreditado
     */
    public function getMontoMensualAcreditadoPorPrestacion($lista_prestacion, $fecha_pago = '')
    {
        $fecha_pago = ($fecha_pago == '')?date('Y-m-d'):$fecha_pago;
        $lista_ids = [];
        foreach ($lista_prestacion as $value) {
            $lista_ids[] = $value['id'];
        }

        $query = new Query();
        $query->select('recursoid, sum(monto) as monto_mensual_acreditado');
        $query->from('cuota');
        $query->where(['recursoid'=>$lista_ids]);
        $condicion = "EXTRACT( YEAR_MONTH FROM  `fecha_pago`) = EXTRACT( YEAR_MONTH FROM  '".$fecha_pago."')";
        $query->andWhere($condicion);
        $query->groupBy('id');

        $row = $query->createCommand()->queryAll();

        return $row;
    }

    /**
     * Se calcula el monto total acreditado de cada prestacion
     *
     * @param [type] $lista_prestacion
     * @return array prestaciones con su monto total acreditado
     */
    public function getMontoTotalAcreditadoPorPrestacion($lista_prestacion)
    {
        $lista_ids = [];
        foreach ($lista_prestacion as $value) {
            $lista_ids[] = $value['id'];
        }

        $query = new Query();
        $query->select('recursoid, sum(monto) as monto_total_acreditado');
        $query->from('cuota');
        $query->where(['recursoid'=>$lista_ids]);
        $query->groupBy('recursoid');

        $row = $query->createCommand()->queryAll();

        return $row;
    }
    
    /**
     * En este criterio los parametros de persona solo son relevantes al filtrado
     * @param type $params
     * @return type
     */
    private function crearSqlListaBeneficiario($params) {
        $query = Recurso::find();

        $this->load($params,'');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
             $query->where('0=1');
            return $query;
        }
        
        ############ Buscamos por datos de persona(PENDIENTE para modularizar) ###################
        #global search #global param
        $personaForm = new PersonaForm();
        if(isset($params['global_param']) && !empty($params['global_param'])){
            $persona_params["global_param"] = $params['global_param'];
        }
        
        if(isset($params['localidadid']) && !empty($params['localidadid'])){
            $persona_params['localidadid'] = $params['localidadid'];
        }
        
        if(isset($params['calle']) && !empty($params['calle'])){
            $persona_params['calle'] = $params['calle'];    
        }
        
        $coleccion_persona = array();
        $lista_personaid = array();
        if (isset($persona_params)) {
            
            $coleccion_persona = $personaForm->buscarPersonaEnRegistral($persona_params);
            $lista_personaid = $this->obtenerListaIds($coleccion_persona);

            if (count($lista_personaid) < 1) {
                $query->where('0=1');
            }
        }
        
        #Criterio de recurso social por lista de persona.... lista de personaid
        if(count($lista_personaid)>0){
            $query->andWhere(array('in', 'personaid', $lista_personaid));
        }
        ############# FIN DEl CRITERIO DE PERSONA ############

        #Obtenemos la lista de programaid de un usuario
        $programa_ids = '';
        foreach (PermisoPrograma::setCondicionPermisoProgramaVer() as $mix) {
            foreach ($mix as  $value) {
                $programa_ids .= (empty($programa_ids))?$value:','.$value;
            }
        }

        
        $query->select([
            'personaid',
            'count(monto) as recurso_cantidad',
            'sum(monto) as monto',
            '(SELECT sum(c2.monto) FROM `cuota` as c2 LEFT JOIN recurso r2 on c2.recursoid = r2.id WHERE r1.personaid=r2.personaid and r2.programaid in ('.$programa_ids.')) as monto_acreditado',
            '(SELECT sum(monto) FROM `recurso` WHERE (NOT (`fecha_baja` IS NULL)) and personaid=r1.personaid and programaid in ('.$programa_ids.')) as monto_baja',
            '(SELECT sum(c2.monto) FROM `cuota` as c2 LEFT JOIN recurso r2 on c2.recursoid = r2.id WHERE (NOT (`fecha_baja` IS NULL)) and r1.personaid=r2.personaid and programaid in ('.$programa_ids.')) as monto_baja_acreditado',
            '(SELECT count(id) AS `recurso_baja_cantidad` FROM `recurso` WHERE NOT (`fecha_baja` IS NULL) and personaid=r1.personaid and programaid in ('.$programa_ids.')) as recurso_baja_cantidad',
            '(SELECT count(id) AS `recurso_acreditado_cantidad` FROM `recurso` WHERE (NOT (`fecha_acreditacion` IS NULL)) AND (`fecha_baja` IS NULL) and personaid=r1.personaid and programaid in ('.$programa_ids.')) as recurso_acreditado_cantidad',
            ]);
        $query->from(['recurso r1']);
        $query->groupBy(['personaid']);
        
        #Ordenamos por recurso_cantidad(variable auxiliar)
        if(isset($params['sort']) && $params['sort']=='-recurso_cantidad'){
            $query->orderBy('recurso_cantidad desc');
        }
        if(isset($params['sort']) && $params['sort']=='recurso_cantidad'){
            $query->orderBy('recurso_cantidad asc');
        }

        #Seteamos la condicion adecuada segun los permisos del usuario (Rbac + Rule)
        $query->andWhere(PermisoPrograma::setCondicionPermisoProgramaVer('r1'));


        // print_r($query->createCommand()->queryAll());die();
        return $query;

    }
    
    /**
     * Se lista una coleccion de beneficiarios
     * @param array $params
     * @return ActiveDataProvider
     */
    public function listaBeneficiarios($params)
    {
        $query = $this->crearSqlListaBeneficiario($params);
        
        #Seteamos paginacion
        $pagesize = (isset($params['pagesize']) && is_numeric($params['pagesize']))?$params['pagesize']:20;
        $total_count = $query->count();
        $pagina = $params['page'];
        if (!$pagina) {
            $inicio = 0;
            $pagina=1;
        }else{
            $inicio = ($pagina) * $pagesize;
        }

        #Antes de setear la paginacion vamos a sumar los montos acreditados y montos sin acreditar
        $rows = $query->createCommand()->queryAll();
        $monto_acreditado = 0;
        $monto_baja = 0;
        $monto_sin_acreditar = 0;
        foreach ($rows as $value) {
            #sumamos los montos
            $monto_acreditado = $monto_acreditado + $value['monto_acreditado'];
            $monto_baja = $monto_baja + $value['monto_baja'];
            $monto_sin_acreditar = $monto_sin_acreditar + $value['monto_sin_acreditar'];
        }
        
        #Configuramos paginacion
        $query->limit($pagesize);
        $query->offset($inicio);
        
        #Estructuramos el array
        $rows = $query->createCommand()->queryAll();
        $coleccion_recurso = array();
        $monto_acreditado = 0;
        $monto_baja = 0;
        $monto_sin_acreditar = 0;
        foreach ($rows as $value) {
            $value['monto_acreditado'] = ($value['monto_acreditado']!=null)? doubleval($value['monto_acreditado']):0;
            $value['monto_baja_acreditado'] = ($value['monto_baja_acreditado']!=null)? doubleval($value['monto_baja_acreditado']):0;            
            $value['monto_baja'] = ($value['monto_baja']!=null)? doubleval($value['monto_baja']) - $value['monto_baja_acreditado']:0;            
            $value['monto_sin_acreditar'] = $value['monto']-$value['monto_acreditado']-$value['monto_baja'];   
            $value['recurso_cantidad'] = intval($value['recurso_cantidad']);
            $value['recurso_baja_cantidad'] = intval($value['recurso_baja_cantidad']);
            $value['recurso_acreditado_cantidad'] = intval($value['recurso_acreditado_cantidad']);
            $value['recurso_sin_acreditar_cantidad'] = $value['recurso_cantidad']-$value['recurso_baja_cantidad']-$value['recurso_acreditado_cantidad'];
            $coleccion_recurso[] = $value;
        }

        if(count($coleccion_recurso)>0){
            $coleccion_persona = $this->obtenerPersonaVinculada($coleccion_recurso);
            $coleccion_recurso = $this->vincularPersona($coleccion_recurso, $coleccion_persona);
        } 
        
        $paginas = ceil($total_count/$pagesize);
                         
        $recurso_acreditado_cantidad = $this->contarRecursoAcreditado($params);
        $recurso_baja_cantidad = $this->contarRecursoBaja($params);

        $data['pagesize']=$pagesize;            
        $data['pages']=$paginas;            
        $data['total_filtrado']=$total_count;
        $data['monto_acreditado']=(isset($monto_acreditado))?$monto_acreditado:0;
        $data['monto_baja']=(isset($monto_baja))?$monto_baja:0;
        $data['monto_sin_acreditar']=(isset($monto_sin_acreditar))?$monto_sin_acreditar:0;
        $data['recurso_acreditado_cantidad']=(isset($recurso_acreditado_cantidad))?$recurso_acreditado_cantidad:0;
        $data['recurso_baja_cantidad']=(isset($recurso_baja_cantidad))?$recurso_baja_cantidad:0;
        $data['resultado']=$coleccion_recurso;

        return $data;
    }
    
    /**
     * Ademas de mostrar los datos de un beneficiario, se buscan todos las prestaciones de la misma y se ordenan por programa y fecha_alta Desc
     * @param array $param
     * @return ActiveDataProvider|array
     */
    public function viewBeneficiario($param)
    {
        $query = Recurso::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($param,'');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        $query->select(['*']);
        $query->where(['personaid'=> $this->personaid]);
        $query->orderBy([
            'programaid'=>SORT_DESC,
            'fecha_alta'=>SORT_DESC
            ]);
        
        #Seteamos la condicion adecuada segun los permisos del usuario (Rbac + Rule)
        $query->andWhere(PermisoPrograma::setCondicionPermisoProgramaVer());

        #### preparamos los datos del beneficiario para mostrar ####
        $personaForm = new PersonaForm();
        $resultado = $personaForm->obtenerPersonaConLugarYEstudios($this->personaid);
        
        #### Obtenemos la lista de recursos que tiene el beneficiario ####
        if($dataProvider->getTotalCount()){
            $resultado['recurso_lista'] = array();
            foreach ($dataProvider->getModels() as $value) {
                $pretacion = $value->toArray();
                $pretacion['lista_cuota'] = $value->cuotas;
                $pretacion['cant_cuota'] = $value->getCantCuota();
                $pretacion['monto_mensual_acreditado'] = $value->getMontoMensualAcreaditado();
                $pretacion['monto_total_acreditado'] = $value->getMontoTotalAcreaditado();
                $pretacion['monto_resto'] = $value->monto - $value->getMontoTotalAcreaditado();
                $pretacion['localidad'] = $value->getLocalidad();
                $pretacion['persona'] = $value->getPersona();
                $pretacion['responsable_entrega'] = $value->getResponsableEntregaNombre().' ('.ucfirst($value->responsableEntrega->tipoResponsable->nombre).')';
                
                #### Si la prestacion tiene alumnos, agregramos una lista de alumnos ####
                if(count($value->alumnos)>0){
                    $pretacion = \yii\helpers\ArrayHelper::merge($pretacion,array("alumno_lista"=>$value->alumnos));
                }
                
                #### Preparamos la prestacion para mostrar ####
                $resultado['recurso_lista'][] = $pretacion;
            }
           
            #Se ordena y se agrupa la lista de recursos por programa y fecha_alta desc
            $programas = array();
            $coleccion_por_programa = array();
            $recurso_lista = array();
            for($i=0;$i<count($resultado['recurso_lista']);$i++){
                $existe=false;
                $programa_old = $resultado['recurso_lista'][$i]['programa'];
                foreach ($programas as $value) {
                    if($programa_old==$value['programa']){
                            $existe = true;
                    }
                }
                #### Se crea listado de prestaciones en programa_grupo ####
                if(!$existe){
                    for($j=0;$j<count($resultado['recurso_lista']);$j++){
                        if($programa_old == $resultado['recurso_lista'][$j]['programa']){                        
                            $coleccion_por_programa[] = $resultado['recurso_lista'][$j];
                        }
                    }
                    $programas[] = array(                        
                        'programa'=>$programa_old,
                        'recurso_cantidad'=>count($coleccion_por_programa),
                        "recursos"=>$coleccion_por_programa
                    );
                    $coleccion_por_programa = array();
                }
            }            
            $recurso_lista = $programas;
            
            #Fin del ordenado
            $resultado['recurso_lista'] = $recurso_lista;
        }       
        
        return $resultado;
    }

    /**
     * De una coleccion de persona, se obtienen una lista de ids
     * @param array $coleccion lista de personas
     * @return array
     */
    private function obtenerListaIds($coleccion = array()) {
        
        $lista_ids = array();
        foreach ($coleccion as $col) {
            $lista_ids[] = $col['id'];
        }
        
        return $lista_ids;    
    }
    
    /**
     * Se vinculan las personas a los recursos
     * @param type $coleccion_recurso
     * @param type $coleccion_personaid
     * @return array
     */
    private function vincularPersona($coleccion_recurso = array(), $coleccion_personaid = array()) {
        $i=0;
        foreach ($coleccion_recurso as $recurso) {
            foreach ($coleccion_personaid as $persona) {
                if(isset($recurso['personaid']) && isset($persona['id']) && $recurso['personaid']==$persona['id']){                    
                    $recurso['persona'] = $persona;
                    $coleccion_recurso[$i] = $recurso;
                }
            }
            $i++;
        }
        
        return $coleccion_recurso;
    }
    
    /**
     * Se obtienen las personas que están vinculadas a la lista de recursos
     * @param array $coleccion_recursos
     * @return array
     */
    private function obtenerPersonaVinculada($coleccion_recursos = array()) {
        $personaForm = new PersonaForm();
        $ids='';
        $pagesize = count($coleccion_recursos); 
        foreach ($coleccion_recursos as $recursos) {
            $ids .= (empty($ids))?$recursos['personaid']:','.$recursos['personaid'];
        }
        
        $coleccionPersona = $personaForm->buscarPersonaEnRegistral(array("ids"=>$ids,"pagesize"=>$pagesize));
        
        return $coleccionPersona;
    }
    
    /**
     * Se vinculan las localidades a la lista de recursos
     * @param array $coleccion_recurso
     * @param array $coleccion_localidadid
     * @return array
     */
    private function vincularLocalidad($coleccion_recurso = array(), $coleccion_localidadid = array()) {
        $i=0;
        foreach ($coleccion_recurso as $recurso) {
            foreach ($coleccion_localidadid as $localidad) {
                if(isset($recurso['localidadid']) && isset($localidad['id']) && $recurso['localidadid']==$localidad['id']){                    
                    $recurso['localidad'] = $localidad['nombre'];
                    $coleccion_recurso[$i] = $recurso;
                }
            }
            $i++;
        }
        
        return $coleccion_recurso;
    }
    
    /**
     * Se obtienen las localidades que están vinculadas a la lista de recursos (localidadid)
     * @param array $coleccion_recursos
     * @return array
     */
    private function obtenerLocalidadVinculada($coleccion_recursos = array()) {
        $lugarForm = new LugarForm();
        $ids='';
        $pagesize = count($coleccion_recursos); 
        foreach ($coleccion_recursos as $recursos) {
            #si esta seteada la localidad
            if(isset($recursos['localidadid'])){
                $ids .= (empty($ids))?$recursos['localidadid']:','.$recursos['localidadid'];
            }
            
        }
        
        $coleccion = $lugarForm->buscarLocalidadEnSistemaLugar(array("ids"=>$ids,"pagesize"=>$pagesize));
        
        return $coleccion;
    }
    
    /**
     * Se obtienen los reponsables mediante interoperabilidad con lugar y se vincula a la prestacion correspondiente.
     * Esta funcion abarca estos 3 tipos de responsables: Delegacion, Municipio y Comision de fomento
     * @param array $coleccion_recursos
     * @return array
     */
    private function asociarResponsablesPorInteroperabilidad($coleccion_recursos = array()) {
        $lugarForm = new LugarForm();
        $pagesize = count($coleccion_recursos);
        
        $coleccion_delegacion = array();
        $coleccion_comision_fomento = array();
        $coleccion_municipio = array();

        /** array con coleccions de ids para solicitar colección **/
        $coleccion_municipio_ids = array();
        $coleccion_comision_fomento_ids = array();
        $coleccion_delegacion_ids = array();
        
        /** Buscamos si un recurso(prestacion) tiene resonsable, si tiene responsable es importante saber el tipo de reposable */
        foreach ($coleccion_recursos as $recurso) {            
            //vamos a chequear cuantas prestaciones fueron entregadas por Delegaciones
            if(isset($recurso['responsable_entrega']['tipo_responsableid']) && ($recurso['responsable_entrega']['tipo_responsableid'] == $this::TIPO_RESPONSABLE_DELEGACION)){
                #chequeamos el tipo de ids responsable
                if(!in_array($recurso['responsable_entrega']['responsableid'], $coleccion_delegacion_ids)){
                    $coleccion_delegacion_ids[] = $recurso['responsable_entrega']['responsable_entregaid'];
                }
            }
            
            ////vamos a chequear cuantas prestaciones fuerona entregadas por comisiones de fomento
            if(isset($recurso['responsable_entrega']['tipo_responsableid']) && ($recurso['responsable_entrega']['tipo_responsableid'] == $this::TIPO_RESPONSABLE_MUNICIPIO)){
                #obtenemos la lista de ids comisiones de fomento
                if(!in_array($recurso['responsable_entrega']['responsableid'], $coleccion_comision_fomento_ids)){
                    $coleccion_comision_fomento_ids[] = $recurso['responsable_entrega']['responsable_entregaid'];
                }
            }
            
            //vamos a chequear cuantas prestaciones fueron entregadas por Municipios
            if(isset($recurso['responsable_entrega']['tipo_responsableid']) && ($recurso['responsable_entrega']['tipo_responsableid'] == $this::TIPO_RESPONSABLE_COMISION_FOMENTO)){
                #obtenemos la lista de ids comisiones de fomento
                if(!in_array($recurso['responsable_entrega']['responsableid'], $coleccion_municipio_ids)){
                    $coleccion_municipio[] = $recurso['responsable_entrega']['responsable_entregaid'];
                }
            }
        }
        
        /** Obtenemos las delegaciones relevantes a un entrega de prestacions **/
        if(count($coleccion_delegacion_ids)>0){
            //obtenemos la coleccion de las delegaciones
            $delegacion_ids = '';
            foreach ($coleccion_delegacion_ids as $id) {
                    $delegacion_ids .= (empty($delegacion_ids))?$id:','.$id;
            }
            //vamos a mapear todas la delegaciones
            $coleccion_delegacion = $lugarForm->buscarDelegacionEnSistemaLugar(array("ids"=>$delegacion_ids,"pagesize"=>$pagesize));
        }
        
        /** Obtenemos las comisiones de fomentos relevantes a un entrega de prestacions **/
        if(count($coleccion_comision_fomento_ids)){
            //obtenemos la coleccion de las comisiones de fomento
            $comision_fomento_ids = '';
            foreach ($coleccion_comision_fomento_ids as $id) {
                    $comision_fomento_ids .= (empty($comision_fomento_ids))?$id:','.$id;
            }
            //vamos a mapear todas la delegaciones
            $coleccion_comision_fomento = $lugarForm->buscarDelegacionEnSistemaLugar(array("ids"=>$comision_fomento_ids,"pagesize"=>$pagesize));
        }
        
        /** Obtenemos los municipios relevantes a un entrega de prestacions **/
        if(count($coleccion_municipio_ids)){
            //obtenemos la coleccion de las comisiones de fomento
            $municipio_ids = '';
            foreach ($coleccion_municipio as $id) {
                    $municipio_ids .= (empty($municipio_ids))?$id:','.$id;
            }
            //vamos a mapear todas la delegaciones
            $coleccion_municipio = $lugarForm->buscarDelegacionEnSistemaLugar(array("ids"=>$coleccion_municipio_ids,"pagesize"=>$pagesize));
        }
        
        
        
        //vinculamos los responsables de entrega a a la coleccion de recursos(Prestaciónes)
        $i=0;
        foreach ($coleccion_recursos as $recurso){
            
            //Vinculamos las delegaciones
            foreach ($coleccion_delegacion as $delegacion) {
                //buscamos al recurso que tenga ese tipo de responsable y el responsable
                if(isset($recurso['responsable_entrega']['responsable_entregaid']) && ($recurso['responsable_entrega']['responsable_entregaid'] == $delegacion['id'])){
                    $recurso['responsable_entrega']=$delegacion['nombre'].' (Delegacion)';
                    $recurso['tipo_responsable']='Delegación';
                    $coleccion_recursos[$i]=$recurso;
                }
            }
            //Vinculamos las comisiones de fomentos
            foreach ($coleccion_comision_fomento as $comision_fomento) {
                //buscamos al recurso que tenga ese tipo de responsable y el responsable
                if(isset($recurso['responsable_entrega']['responsable_entregaid']) && ($recurso['responsable_entrega']['responsable_entregaid'] == $comision_fomento['id'])){
                    $recurso['responsable_entrega']=$comision_fomento['nombre'].' (Comision de Fomento)';
                    $recurso['tipo_responsable']='Comision de Fomento';
                    $coleccion_recursos[$i]=$recurso;
                }
            }  
            //Vinculamos los municipios
            foreach ($coleccion_municipio as $municipio) {
                //buscamos al recurso que tenga ese tipo de responsable y el responsable
                if(isset($recurso['responsable_entrega']['responsable_entregaid']) && ($recurso['responsable_entrega']['responsable_entregaid'] == $municipio['id'])){
                    $recurso['responsable_entrega']=$municipio['nombre'].' (Municipio)';
                    $recurso['tipo_responsable']='Municipio';
                    $coleccion_recursos[$i]=$recurso;
                }
            }              
            $i++;
        }
        
        return $coleccion_recursos;
    }
    
    public function obtenerParametrosLugar() {
        $response = \Yii::$app->lugar->obtenerParametro([]);  
        return $response;
    }

}