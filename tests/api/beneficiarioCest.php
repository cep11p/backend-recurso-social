<?php 

class beneficiarioCest
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
    public function listarBeneficiarios(ApiTester $I)
    {
        $I->wantTo('Se listan los beneficiarios');
        
        $I->sendGET('/api/beneficiarios');
        
        $I->seeResponseContainsJson([
           'pagesize' => 20,
           'pages' => 2,
           'total_filtrado' => 27,
           "monto_acreditado"=> 549345.03,
           "monto_baja"=> 543897.16,
           "monto_sin_acreditar"=> 250641.33,
           "recurso_acreditado_cantidad"=> 32,
           "recurso_baja_cantidad"=> 27,
           'resultado' => array(
               [
                "personaid"=> 1,
                "monto"=> 64826.61,
                "baja"=> false,
                "acreditacion"=> false,
                "monto_acreditado"=> 35791.47,
                "monto_baja"=> 29035.14,
                "monto_sin_acreditar"=> 0,
                "recurso_cantidad"=> 5,
                "recurso_baja_cantidad"=> 2,
                "recurso_acreditado_cantidad"=> 3,
                "recurso_sin_acreditar_cantidad"=> 0,
                    "persona"=> [
                        "id"=> 1,
                        "nombre"=> "Victoria Margarita",
                        "apellido"=> "González",
                        "nro_documento"=> "23851266",
                        "fecha_nacimiento"=> "1982-12-30",
                        "estado_civilid"=> 1,
                        "telefono"=> "2920430000",
                        "celular"=> "2920412227",
                        "sexoid"=> 2,
                        "tipo_documentoid"=> 1,
                        "nucleoid"=> 1,
                        "situacion_laboralid"=> 1,
                        "generoid"=> 2,
                        "email"=> "email22@correo.com",
                        "cuil"=> "20238512669",
                        "red_social"=> "redsocial1",
                        "lugar"=> [
                            "id"=> 1,
                            "calle"=> "calle1",
                            "altura"=> "100",
                            "localidadid"=> 2538,
                            "latitud"=> "-1234123",
                            "longitud"=> "21314124",
                            "barrio"=> "barrio1",
                            "piso"=> "0º",
                            "depto"=> "A",
                            "escalera"=> "escalera1",
                            "entre_calle_1"=> "Entrecalle1",
                            "entre_calle_2"=> "Entrecalle-103",
                        ]
                    ]
                ],
                [
                    "personaid"=> 2,
                    "monto"=> 123690.15,
                    "baja"=> false,
                    "acreditacion"=> false,
                    "monto_acreditado"=> 99868.16,
                    "monto_baja"=> 23821.99,
                    "monto_sin_acreditar"=> 7.2759576141834e-12,
                    "recurso_cantidad"=> 5,
                    "recurso_baja_cantidad"=> 2,
                    "recurso_acreditado_cantidad"=> 3,
                    "recurso_sin_acreditar_cantidad"=> 0,
                    "persona"=> [
                        "id"=> 2,
                        "nombre"=> "Isabel Sofía",
                        "apellido"=> "Rodríguez",
                        "nro_documento"=> "32054238",
                        "fecha_nacimiento"=> "1982-12-29",
                        "estado_civilid"=> 2,
                        "telefono"=> "2920430001",
                        "celular"=> "2920412228",
                        "sexoid"=> 2,
                        "tipo_documentoid"=> 2,
                        "nucleoid"=> 2,
                        "situacion_laboralid"=> 2,
                        "generoid"=> 2,
                        "email"=> 'email22@correo.com',
                        "cuil"=> "20320542389",
                        "red_social"=> 'redsocial2',
                        "lugar"=> [
                            "id"=> 2,
                            "calle"=> "calle2",
                            "altura"=> "",
                            "localidadid"=> 2539,
                            "latitud"=> "-1234122",
                            "longitud"=> "21314125",
                            "barrio"=> "barrio2",
                            "piso"=> "1º",
                            "depto"=> "B",
                            "escalera"=> "escalera2",
                            "entre_calle_1"=> "Entrecalle2",
                            "entre_calle_2"=> "Entrecalle-102",
                        ]
                    ]
                ]
           )
        ]);
        
        $I->seeResponseCodeIs(200);
        
        
    }
}
