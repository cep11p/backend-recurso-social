<?php

/**** obtener lista de Personas ***
@url ejemplo http://recurso-social.local/api/personas?global_param=gonzalez
@Method GET
{
    "success": true,
    "total_filtrado": 6,
    "pages": 1,
    "pagesize": 20,
    "resultado": [
        {
            "id": 1,
            "nombre": "Victoria Margarita",
            "apellido": "González",
            "apodo": "",
            "nro_documento": "23851266",
            "fecha_nacimiento": "0000-00-00",
            "estado_civilid": null,
            "telefono": "",
            "celular": "2920412227",
            "sexoid": 2,
            "tipo_documentoid": null,
            "nucleoid": 1,
            "situacion_laboralid": null,
            "generoid": null,
            "email": "",
            "cuil": "20238512669",
            "red_social": "",
            "hogar": {
                "id": 1,
                "tiene_gas": 1,
                "tiene_luz": 1,
                "tiene_agua": 1,
                "condicion_ocupacionid": 1,
                "obtencion_aguaid": 1,
                "tipo_desagueid": 1,
                "cocina_combustibleid": 1,
                "tipo_viviendaid": 1,
                "jefeid": null,
                "habitacion_dormir": 2,
                "banioid": 1,
                "lugarid": 1,
                "observacion": null,
                "nucleos": [
                    {
                        "id": 1,
                        "hogarid": 1,
                        "jefeid": null,
                        "nombre": "Familia Rodriguez"
                    }
                ]
            },
            "estudios": [],
            "lista_red_social": [
                {
                    "id": 32,
                    "personaid": 1,
                    "tipo_red_socialid": 1,
                    "perfil": "https://www.facebook.com/cep11p",
                    "icon_class": "fab fa-facebook-square",
                    "tipo_red_social": "Facebook"
                }
            ],
            "sexo": "Mujer",
            "genero": "",
            "estado_civil": "",
            "lugar": {
                "id": 1,
                "nombre": "",
                "calle": "calle1",
                "altura": "100",
                "localidadid": 1,
                "latitud": "-1234123",
                "longitud": "21314124",
                "barrio": "barrio1",
                "piso": "0º",
                "depto": "A",
                "escalera": "",
                "entre_calle_1": "",
                "entre_calle_2": "",
                "localidad": "Capital Federal"
            }
        },
        {
            "id": 21,
            "nombre": "Oliva Jazmín",
            "apellido": "González",
            "apodo": "",
            "nro_documento": "24792390",
            "fecha_nacimiento": "0000-00-00",
            "estado_civilid": null,
            "telefono": "",
            "celular": "",
            "sexoid": 2,
            "tipo_documentoid": null,
            "nucleoid": 21,
            "situacion_laboralid": null,
            "generoid": null,
            "email": "",
            "cuil": "14247923903",
            "red_social": "",
            "hogar": {
                "id": 21,
                "tiene_gas": 1,
                "tiene_luz": 1,
                "tiene_agua": 1,
                "condicion_ocupacionid": 1,
                "obtencion_aguaid": 1,
                "tipo_desagueid": 1,
                "cocina_combustibleid": 1,
                "tipo_viviendaid": 1,
                "jefeid": null,
                "habitacion_dormir": 2,
                "banioid": 1,
                "lugarid": 21,
                "observacion": null,
                "nucleos": [
                    {
                        "id": 21,
                        "hogarid": 21,
                        "jefeid": null,
                        "nombre": "Predeterminado"
                    }
                ]
            },
            "estudios": [],
            "lista_red_social": [
                {
                    "id": 32,
                    "personaid": 1,
                    "tipo_red_socialid": 1,
                    "perfil": "https://www.facebook.com/cep11p",
                    "icon_class": "fab fa-facebook-square",
                    "tipo_red_social": "Facebook"
                }
            ],
            "sexo": "Mujer",
            "genero": "",
            "estado_civil": "",
            "lugar": {
                "id": 21,
                "nombre": "",
                "calle": "calle1",
                "altura": "",
                "localidadid": 2,
                "latitud": "-1234103",
                "longitud": "21314144",
                "barrio": "barrio3",
                "piso": "20º",
                "depto": "4",
                "escalera": "",
                "entre_calle_1": "",
                "entre_calle_2": "",
                "localidad": "Villa Lugano"
            }
        },
        {
        ...
        }
    ]
}
**/

/***** Para crear****
 * Esto registra una persona nueva en el sistema registral (interoperabilidad)
 * En el caso de que vaya id como parametro, el sistema aplica un actualizacion 
 * sobre la persona que tenga ese id
 * @url http://recurso-social.local/api/personas
 * @method POST
 * @param
 
    {    
        "nombre": "Romina",
        "apellido": "Rodríguez",
        "nro_documento": "29890098",
        "fecha_nacimiento":"1980-12-12",
        "apodo":"rominochi",
        "telefono": "2920430690",
        "celular": "2920412127",
        "situacion_laboralid": 1,
        "estado_civilid": 1,
        "sexoid": 2,
        "tipo_documentoid": 1,
        "generoid": 1,
        "email":"algo@correo.com.ar",
        "red_social":"algodesocial",
        "cuil":"20367655678",
        "estudios": [{
            "nivel_educativoid":4,
            "titulo":"tecnico en desarrollo web",
            "completo":1,
            "en_curso":0,
            "anio":"2014"
        }],
        "lista_red_social": [
            {
            "tipo_red_socialid":1,
            "perfil":"cep11p"
            },
            {
            "tipo_red_socialid":2,
            "perfil":"kar2000"
            }
        ]
        "lugar": {
            "barrio":"Don bosco",
            "calle":"Mitre",
            "altura":"327",
            "piso":"A",
            "depto":"",
            "escalera":"",
            "localidadid":1,
            "latitud":"-123123",
            "longitud":"321123"
        }    
    }
**/


/***** Para Modificar/Actualizar Persona****
 * Esta funcion actualiza/modifica una persona que ya existe en el sistema registral (interoperabilidad)
 * Es obligatorio que el parametro id vaya en la url
 * @url http://recurso-social.local/api/personas/1
 * @method PUT
 * @param
 
    {    
        "nombre": "Romina",
        "apellido": "Rodríguez",
        "nro_documento": "29890098",
        "fecha_nacimiento":"1980-12-12",
        "apodo":"rominochi",
        "telefono": "2920430690",
        "celular": "2920412127",
        "situacion_laboralid": 1,
        "estado_civilid": 1,
        "sexoid": 2,
        "tipo_documentoid": 1,
        "generoid": 1,
        "email":"algo@correo.com.ar",
        "red_social":"algodesocial",
        "cuil":"20367655678",
        "estudios": [{
            "nivel_educativoid":4,
            "titulo":"tecnico en desarrollo web",
            "completo":1,
            "en_curso":0,
            "anio":"2014"
        }],
        "lista_red_social": [
            {
            "tipo_red_socialid":1,
            "perfil":"cep11p"
            },
            {
            "tipo_red_socialid":2,
            "perfil":"kar2000"
            }
        ]
        "lugar": {
            "barrio":"Don bosco",
            "calle":"Mitre",
            "altura":"327",
            "piso":"A",
            "depto":"",
            "escalera":"",
            "localidadid":1,
            "latitud":"-123123",
            "longitud":"321123"
        }    
    }
**/

/***** Para Modificar/Actualizar el contacto de la Persona****
 * Esta funcion actualiza/modifica los datos de contacto de una persona que ya existe en el sistema registral (interoperabilidad)
 * Es obligatorio que el parametro id vaya en la url
 * @url http://recurso-social.local/api/personas/contacto/1
 * @method PUT
 * @param
 
    {    
        "email": "Romina@correo.com",
        "lista_red_social": [
            {
                "tipo_red_socialid": 1,
                "perfil": "https://www.facebook.com/cep11p",
            },
            {
                "tipo_red_socialid": 2,
                "perfil": "https://twitter.com/kar2000",
            }
        ],
        "telefono": "29890098",
        "celular":"(2920) 15 412129"
    }
**/

/**** obtener Persona por nro_documento ***
@url ejemplo http://recurso-social.local/api/personas/buscar-por-documento/29800100
@Method GET
{
    "success": true,
    "resultado": [
        {
            "id": 1,
            "nombre": "Romina Belen",
            "apellido": "Rodríguez",
            "apodo": "rominochi",
            "nro_documento": "29800100",
            "fecha_nacimiento": "1980-12-12",
            "estado_civilid": 1,
            "telefono": "2920430690",
            "celular": "2920412127",
            "sexoid": 2,
            "tipo_documentoid": 1,
            "nucleoid": 1,
            "situacion_laboralid": 1,
            "generoid": 1,
            "email": null,
            "cuil": "21298001007",
            ...,
        }
    ]
}
**/

/**** obtener Persona por id ***
@url ejemplo http://recurso-social.local/api/personas/1
@Method GET
{
    "id": 1,
    "nombre": "Victoria Margarita",
    "apellido": "González",
    "apodo": "",
    "nro_documento": "23851266",
    "fecha_nacimiento": "0000-00-00",
    "estado_civilid": null,
    "telefono": "",
    "celular": "2920412227",
    "sexoid": 2,
    "tipo_documentoid": null,
    "nucleoid": 1,
    "situacion_laboralid": null,
    "generoid": null,
    "email": "",
    "cuil": "20238512669",
    "red_social": "",
    "hogar": {
        "id": 1,
        "tiene_gas": 1,
        "tiene_luz": 1,
        "tiene_agua": 1,
        "condicion_ocupacionid": 1,
        "obtencion_aguaid": 1,
        "tipo_desagueid": 1,
        "cocina_combustibleid": 1,
        "tipo_viviendaid": 1,
        "jefeid": null,
        "habitacion_dormir": 2,
        "banioid": 1,
        "lugarid": 1,
        "observacion": null,
        "nucleos": [
            {
                "id": 1,
                "hogarid": 1,
                "jefeid": null,
                "nombre": "Familia Rodriguez"
            }
        ]
    },
    "estudios": [],
    "lista_red_social": [
        {
            "id": 32,
            "personaid": 1,
            "tipo_red_socialid": 1,
            "perfil": "https://www.facebook.com/cep11p",
            "icon_class": "fab fa-facebook-square",
            "tipo_red_social": "Facebook"
        }
    ],
    "sexo": "Mujer",
    "genero": "",
    "estado_civil": "",
    "lugar": {
        "id": 1,
        "nombre": "",
        "calle": "calle1",
        "altura": "100",
        "localidadid": 1,
        "latitud": "-1234123",
        "longitud": "21314124",
        "barrio": "barrio1",
        "piso": "0º",
        "depto": "A",
        "escalera": "",
        "entre_calle_1": "",
        "entre_calle_2": "",
        "localidad": "Capital Federal"
    }
}
**/