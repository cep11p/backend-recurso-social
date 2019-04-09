<?php 

class recursoCest
{
    /**
     *
     * @var Helper\Api
     */    
    protected $api;
    
//    public function _before(ApiTester $I,Api $api)
//    {
//        $I->wantTo('Login');
//        $token = $api->generarToken();
//        $I->amBearerAuthenticated($token);
//    }
    
    public function _fixtures()
    {
        return [
            'recursos' => app\tests\fixtures\RecursoFixture::className(),
        ];
    }
    
    

    /**
     * @param ApiTester $I
     */
    public function  listarRecursos(ApiTester $I)
    {
        $I->wantTo('Se listan los recurso');
        
        $I->sendGET('/api/recursos');
        
        $I->seeResponseContainsJson([
            "pagesize"=> 20,
            "pages"=> 4,
            "total_filtrado"=> 71,
            "monto_acreditado"=> 549345.03,
            "monto_baja"=> 543897.16,
            "monto_sin_acreditar"=> 250641.33,
            "recurso_acreditado_cantidad"=> 32,
            "recurso_baja_cantidad"=> 27,
            "resultado"=> [
                [
                    'id' => 61,
                    'fecha_inicial' => '2043-09-01',
                    'fecha_alta' => '2019-03-20',
                    'monto' => 19789.799999999999,
                    'observacion' => 'Observacion Fixture 61',
                    'proposito' => 'Un proposito hecho con fixtures 61',
                    "programaid"=> 3,
                    'tipo_recursoid' => 3,
                    'personaid' => 12,
                    'fecha_baja' => null,
                    'fecha_acreditacion' => null,
                    "descripcion_baja"=> null,
                    "programa"=> "Emprender",
                    "tipo_recurso"=> "Mejora Habitacional",
                    "persona"=> [
                        'id' => 12,
                        'nombre' => 'Sandra Sofía',
                        'apellido' => 'Sosa',
                        'nro_documento' => '24187541',
                        'fecha_nacimiento' => '1980-10-15',
                        'estado_civilid' => 4,
                        'telefono' => '2920430011',
                        'celular' => '2920412238',
                        "sexoid"=> 2,
                        "tipo_documentoid"=> 3,
                        "nucleoid"=> 12,
                        "situacion_laboralid"=> 3,
                        "generoid"=> 2,
                        "email"=> "email22@correo.com",
                        "cuil"=> "15241875413",
                        "red_social"=> "redsocial12",
                        "lugar"=> [
                            "id"=> 12,
                            "calle"=> "calle12",
                            "altura"=> "",
                            'localidadid' => 2549,
                            'latitud' => '-1234112',
                            'longitud' => '21314135',
                            'barrio' => 'barrio3',
                            'piso' => '11º',
                            'depto' => '7',
                            'escalera' => 'escalera12',
                            'entre_calle_1' => 'Entrecalle12',
                            'entre_calle_2' => 'Entrecalle-92'
                        ]
                    ]
                ],
                [
                    'id' => 62,
                    'fecha_inicial' => '2043-09-02',
                    'fecha_alta' => '2019-03-19',
                    'monto' => 23123.119999999999,
                    'observacion' => 'Observacion Fixture 62',
                    'proposito' => 'Un proposito hecho con fixtures 62',
                    "programaid"=> 1,
                    "tipo_recursoid"=> 1,
                    "personaid"=> 13,
                    "fecha_baja"=> null,
                    "fecha_acreditacion"=> null,
                    "descripcion_baja"=> null,
                    "programa"=> "Subsidio",
                    "tipo_recurso"=> "Alimentación",
                    "persona"=> [
                        'id' => 13,
                        'nombre' => 'Oriana Alejandra',
                        'apellido' => 'Torres',
                        'nro_documento' => '6078131',
                        'fecha_nacimiento' => '1980-10-14',
                        'estado_civilid' => 1,
                        'telefono' => '2920430012',
                        "celular"=> "",
                        "sexoid"=> 2,
                        "tipo_documentoid"=> 1,
                        "nucleoid"=> 13,
                        "situacion_laboralid"=> 1,
                        "generoid"=> 2,
                        "email"=> "email22@correo.com",
                        "cuil"=> "1560781313",
                        "red_social"=> "redsocial13",
                        "lugar"=> [
                            "id"=> 13,
                            "calle"=> "calle13",
                            "altura"=> "",
                            'localidadid' => 2550,
                            'latitud' => '-1234111',
                            'longitud' => '21314136',
                            'barrio' => 'barrio4',
                            'piso' => '12º',
                            'depto' => '8',
                            'escalera' => 'escalera13',
                            'entre_calle_1' => 'Entrecalle13',
                            'entre_calle_2' => 'Entrecalle-91',
                        ]
                    ]
                ]
            ]
        ]);
        
        $I->seeResponseCodeIs(200);
        
        
    }
}
