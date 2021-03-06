<?php

/**** obtener lista de Personas ***
@url ejemplo http://recurso-social.local/api/recursos
@url ejemplo http://recurso-social.local/api/recursos?acreditacion=true&baja=true
@url con criterio de busquedad ejemplo http://recurso-social.local/api/recursos?global_param=lopez&localidadid=2
 * global_param : busca por nombre, apellido y nro_documento
 * localidadid : busca por localidad
 * calle : busca por nombre de calle
 * programaid : busca por programa
 * tipo_recursoid : busca por tipo de recursos
 * fecha_hasta : busca por un rango de fecha sobre fecha_inicial
 * fecha_desde : busca por un rango de fecha sobre fecha_inicial
 * acreditacion = true busca los recursos que fueron acreditados
 * baja = true busca los recursos que fueron dados de baja
 * tipo_responsableid = 2 filtro por tipo de responsable
 * sort=-id este parametro ordena en id descendiente, tambien se puede usar otras variebles del modelo como por ejemplo monto
@Method GET

{
    "pagesize": 20,
    "pages": 4,
    "total_filtrado": 71,
    "monto_acreditado": 32247.37,
    "monto_baja": 36457.06,
    "monto_sin_acreditar": 1275179.09,
    "recurso_acreditado_cantidad": 3,
    "recurso_baja_cantidad": 2,
    "resultado": [
        {
            "id": 31858,
            "fecha_inicial": "2020-04-16",
            "fecha_alta": "2020-04-08",
            "monto": 1998,
            "observacion": null,
            "proposito": null,
            "programaid": 6,
            "tipo_recursoid": 4,
            "personaid": 358,
            "fecha_baja": null,
            "fecha_acreditacion": "2020-04-15",
            "descripcion_baja": null,
            "localidadid": 2576,
            "responsable_entregaid": 476,
            "cant_modulo": 1,
            "programa": "Módulo Alimentar",
            "tipo_recurso": "Emergencia",
            "responsable_entrega": "Delegación Zona Alto Valle Centro (Delegacion)",
            "baja": false,
            "acreditacion": true,
            "persona": {
                "id": 358,
                "nombre": "Andrea Soledad",
                "apellido": "Ramirez ",
                "apodo": "",
                "nro_documento": "35595859",
                "fecha_nacimiento": "1950-01-01",
                "estado_civilid": null,
                "telefono": null,
                "celular": null,
                "sexoid": null,
                "tipo_documentoid": null,
                "nucleoid": 342,
                "situacion_laboralid": null,
                "generoid": null,
                "email": null,
                "cuil": null,
                "estudios": [],
                "lista_red_social": [],
                "sexo": "",
                "genero": "",
                "lista_oficio": [],
                "estado_civil": "",
                "lugar": {
                    "id": 2002,
                    "nombre": "",
                    "calle": "libertad 4015 barrio nuevo",
                    "altura": "",
                    "localidadid": 2576,
                    "latitud": "",
                    "longitud": "",
                    "barrio": "",
                    "piso": "",
                    "depto": "",
                    "escalera": "",
                    "entre_calle_1": "",
                    "entre_calle_2": "",
                    "localidad": "General Roca"
                }
            },
            "localidad": "General Roca"
        },
        {
            "id": 1,
            "fecha_inicial": "2016-01-30",
            "fecha_alta": "2014-10-07",
            "monto": 3212.23,
            "observacion": "Observacion Fixture 1",
            "proposito": "Un proposito hecho con fixtures 1",
            "programaid": 3,
            "tipo_recursoid": 1,
            "personaid": 1,
            "programa": "Emprender",
            "tipo_recurso": "Alimentación",
            "persona": {
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
                "estudios": [],
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
        },
        {2...}
        {3...}
        {4...},
        {
            "id": 20,
            "fecha_inicial": "2016-01-11",
            "fecha_alta": "2016-05-19",
            "monto": 16456.9,
            "observacion": "Observacion Fixture 20",
            "proposito": "Un proposito hecho con fixtures 20",
            "programaid": 1,
            "tipo_recursoid": 2,
            "personaid": 10,
            "programa": "Subsidio",
            "tipo_recurso": "Empleo/Formación Laboral",
            "persona": {
                "id": 10,
                "nombre": "Luisa Fernanda",
                "apellido": "Sánchez",
                "apodo": "",
                "nro_documento": "7897018",
                "fecha_nacimiento": "0000-00-00",
                "estado_civilid": null,
                "telefono": "",
                "celular": "2920412236",
                "sexoid": 2,
                "tipo_documentoid": null,
                "nucleoid": 10,
                "situacion_laboralid": null,
                "generoid": null,
                "email": "",
                "cuil": "1578970189",
                "red_social": "",
                "estudios": [],
                "sexo": "Mujer",
                "genero": "",
                "estado_civil": "",
                "lugar": {
                    "id": 10,
                    "nombre": "",
                    "calle": "calle10",
                    "altura": "",
                    "localidadid": 1,
                    "latitud": "-1234114",
                    "longitud": "21314133",
                    "barrio": "barrio1",
                    "piso": "9º",
                    "depto": "5",
                    "escalera": "",
                    "entre_calle_1": "",
                    "entre_calle_2": "",
                    "localidad": "Capital Federal"
                }
            }
        }
    ]
}
**/

/***** Para crear una prestacion de Emprender con sus alumnos****
@url http://recurso-social.local/api/recursos
@method POST
@return array {"message":"Se guarda una prestacion","success":true,"data":{"id":39}}
@param
{
    "personaid": 9,
    "programaid": 3,
    "tipo_recursoid": 3,
    "prosito": "un proposito",
    "fecha_alta": "2011-02-02",
    "monto": 1234.4,
    "observacion": "uuuuuuunaaaaaaaaaaaaa Observacion",
    "alumno_lista":[
    	{"alumnoid":1},
    	{"alumnoid":2},
    	{"alumnoid":4}
    ]
}
 * 
 */


/**
 **** Para crear cualquier otra prestacion****
 * @url http://recurso-social.local/api/recursos
 * @method POST
 * @param
 * {
        "personaid": 9,
        "localidadid": 2530,
        "programaid": 2,
        "tipo_recursoid": 1,
        "prosito": "un proposito",
        "fecha_alta": "2011-02-02",
        "monto": 1234.4,
        "observacion": "uuuuuuunaaaaaaaaaaaaa Observacion"
    }
 */

/**
 **** Para crear cualquier una prestacion del programa Modulo Alimentar****
 * @url http://recurso-social.local/api/recursos
 * @method POST
 * @param
 * {
    "personaid": 9,
    "localidadid": 2530,
    "programaid": 6,
    "tipo_recursoid": 4,
    "prosito": "un proposito",
    "monto": 1998,
    "observacion": "una observación",
    "cant_modulo":1,
    "tipo_responsableid":2,
    "responsable_entregaid":2,
    "fecha_alta":"2020-04-22",
    "fecha_entrega":"2020-04-22"
    }
 */

/**
 **** Para visualizar un Recurso(prestacion)****
 * @url http://recurso-social.local/api/recursos/1
 * @method GET
 * @param
 * {
        "id": 1,
        "fecha_inicial": "2016-01-30",
        "fecha_alta": "2014-10-07",
        "monto": 3212.23,
        "observacion": "Observacion Fixture 1",
        "proposito": "Un proposito hecho con fixtures 1",
        "programaid": 3,
        "tipo_recursoid": 1,
        "personaid": 1,
        "fecha_baja": null,
        "fecha_acreditacion": null,
        "descripcion_baja": null,
        "programa": "Emprender",
        "tipo_recurso": "Alimentación",
        "persona": {
            "id": 1,
            "nombre": "Victoria Margarita",
            "apellido": "González",
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
            "estudios": [],
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
    }
 */

/**
 **** Para visualizar un Recurso(prestacion) del progrma Modulo Alimentar****
 * @url http://recurso-social.local/api/recursos/1
 * @method GET
 * @param
 * 
 * {
    "id": 500,
    "fecha_inicial": "2020-04-22",
    "fecha_alta": "2020-04-22",
    "monto": 1998,
    "observacion": "uuuuuuunaaaaaaaaaaaaa Observacion",
    "proposito": null,
    "programaid": 6,
    "tipo_recursoid": 4,
    "personaid": 9,
    "fecha_baja": null,
    "fecha_acreditacion": "2020-04-22",
    "descripcion_baja": null,
    "localidadid": 2530,
    "responsable_entregaid": 2,
    "cant_modulo": 1,
    "fecha_entrega": null,
    "programa": "Modulo Alimenticio",
    "tipo_recurso": "Emergencia",
    "responsable_entrega": {
        "tipo_responsableid": 2,
        "recursoid": 500,
        "responsable_entregaid": 22
    },
    "responsable_entrega": "Delegación Zona Alto Valle Centro (Delegacion)",
    "baja": false,
    "acreditacion": true,
    "localidad": "Picun Leufu",
    "persona": {
        "id": 9,
        "nombre": "Monica ",
        "apellido": "Arrieagada",
        "nro_documento": "25765559",
        "fecha_nacimiento": "1950-01-01",
        "estado_civilid": null,
        "telefono": null,
        "celular": null,
        "sexoid": null,
        "tipo_documentoid": null,
        "nucleoid": 9,
        "situacion_laboralid": null,
        "generoid": null,
        "email": null,
        "cuil": null,
        "estudios": [],
        "lista_red_social": [],
        "sexo": "",
        "genero": "",
        "lista_oficio": [],
        "estado_civil": "",
        "lugar": {
            "id": 9,
            "nombre": "",
            "calle": "antártida argentina n° 445",
            "altura": "",
            "localidadid": 2629,
            "latitud": "",
            "longitud": "",
            "barrio": "",
            "piso": "",
            "depto": "",
            "escalera": "",
            "entre_calle_1": "",
            "entre_calle_2": "",
            "localidad": "San Antonio Oeste"
        }
    }
}
 */

/**
 **** Realiza una baja de una recurso(prestacion) ****
 * @url http://recurso-social.local/api/recursos/baja/1
 * @method PUT
 * @param
    {
        "fecha_baja":"2019-01-10",
        "descripcion_baja":"una baja de ejemplo"
    }
 */

/**
 **** Realiza una acreditacion de un recurso(prestacion) ****
 * @url http://recurso-social.local/api/recursos/acreditar/1
 * @method PUT
 * @param
    {
        "fecha_acreditacion": "2014-10-06"
    }
 */