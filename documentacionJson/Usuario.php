<?php

/**** Para mostrar listado ****/
/**
* @url http://prestaciones-sociales.local/api/usuarios?[@urlparam]&[@urlparam]
* @urlparam sort=-create_at
* @urlparam sort=-last_login_at
* @method GET
* @arrayReturn
{
    "pagesize": 20,
    "pages": 1,
    "total_filtrado": 2,
    "resultado": [
        {
            "id": 2,
            "username": "admin",
            "email": "admin@correo.com",
            "password_hash": "$2y$10$MnF9LJCnya.NrXIQBN4YGuRIdIuGtOSsGqqZTpby9RnFp7Chb4qEm",
            "auth_key": "maXx0ibz2Br9UEfP06TVcltr0uOiWl4B",
            "confirmed_at": 1556894840,
            "unconfirmed_email": null,
            "blocked_at": null,
            "registration_ip": "172.18.0.2",
            "created_at": 1556894840,
            "updated_at": 1607700159,
            "flags": 0,
            "last_login_at": 1609766087
        },
        {
            "id": 3,
            "username": "pepe",
            "email": "pepe@correo.com",
            "password_hash": "$2y$10$MnF9LJCnya.NrXIQBN4YGuRIdIuGtOSsGqqZTpby9RnFp7Chb4qEm",
            "auth_key": "maXx0ibz2Br9UEfP06TVcltr0uOiWl4B",
            "confirmed_at": 1556894840,
            "unconfirmed_email": null,
            "blocked_at": null,
            "registration_ip": "172.18.0.2",
            "created_at": 1556894840,
            "updated_at": 1607700159,
            "flags": 0,
            "last_login_at": 1609766087
        }
    ]
}
*/

/*****Para crear****
* @url http://prestaciones-sociales.local/api/usuarios 
* @method POST
* @param arrayJson
#Persona existente
{
    "apellido": "Chucho",
    "cuil": "12123456782",
    "cuil_fin": "2",
    "cuil_prin": "12",
    "nombre": "pepe",
    "nro_documento": "12345678",
    "usuario":{
        "username":"cep11p",
        "password":"carlos",
        "email":"cep11p@correo.com",
        "personaid":1,
        "localidadid":2626,
        "rol":"admin"
    }
}
#Persona no existente
{
    apellido: "Chucho"
    cuil: "12123456782"
    cuil_fin: "2"
    cuil_prin: "12"
    nombre: "pepe"
    nro_documento: "12345678"
    usuario:{
        "username":"cep11p",
        "password":"carlos",
        "email":"cep11p@correo.com",
        "personaid":"",
        "localidadid":2626,
        "rol":"admin"
    }
}
**/

/**** Para modificar*****
* @url http://prestaciones-sociales.local/api/usuarios/{$id} 
* @method PUT
* @param arrayJson
{
    "username": "andres",
    "email": "uncorreo1@correo.com",
    "descripcion_baja": "",
    "password": "newpass"
    "localidadid": 2626
}
**/

/****** Para visualizar*****
* @url http://prestaciones-sociales.local/api/usuarios/{$id} 
* @method GET
* @return arrayJson
{
    "id": 2,
    "username": "admin",
    "email": "admin@correo.com",
    "confirmed_at": 1556894840,
    "unconfirmed_email": null,
    "blocked_at": null,
    "registration_ip": "172.18.0.2",
    "created_at": 1556894840,
    "updated_at": 1607700159,
    "flags": 0,
    "last_login_at": 1610453141,
    "personaid": 1,
    "fecha_baja": "",
    "baja": false,
    "descripcion_baja": "",
    "localidadid": 2626,
    "nombre": "Victoria Margarita",
    "apellido": "González",
    "nro_documento": "23851266",
    "cuil": "20068512669",
    "localidad": "Rio Colorado"
}
*/

/****** Listar asignaciones del usuarios (programa, permiso, rol)*****
* @url http://prestaciones-sociales.local/api/usuarios/listar-asignacion/{$id} 
* @method GET
* @return arrayJson
[
    {
        "programa": "Modulo Alimenticio",
        "programaid": "6",
        "lista_permiso": [
            "prestacion_ver",
            "prestacion_baja",
            "prestacion_acreditar"
        ],
        "usuarioid": 2
    },
    {
        "programa": "Subsidio",
        "programaid": "1",
        "lista_permiso": [
            "prestacion_crear",
            "prestacion_ver"
        ],
        "usuarioid": 2
    }
]
*/

/**** Crear Asignaciones a Usuarios*****
* @url http://prestaciones-sociales.local/api/usuarios/crear-asignacion 
* @method POST
* @param arrayJson
{
	"usuarioid": 15,
	"programaid": "2",
	"lista_permiso":[
		{"name":"prestacion_ver"},
		{"name":"prestacion_crear"}
    ]
}

/**** Borrar Asignaciones a Usuarios*****
* @url http://prestaciones-sociales.local/api/usuarios/borrar-asignacion 
* @method POST
* @param arrayJson
{
    "programaid": "1",
    "lista_permiso": [
        "prestacion_crear",
        "prestacion_ver"
    ],
    "usuarioid": 2
}
**/

/**** Dar de baja un Usuarios*****
* @url http://prestaciones-sociales.local/api/usuarios/baja/47 
* @method PUT
* @param arrayJson
{
	"descripcion_baja":"Esto es una descripcion de baja de usuario"
}
**/

/**** Para buscar un persona con usuario*****
* Se busca una persona con usuario, si no se encuentra el usuario, solo se devuelve la persona, si no se encuentra una persona se devuelve vacio
* @url http://prestaciones-sociales.local/api/usuarios/buscar-persona-por-cuil/20068512669
* @method GET
* @param arrayJson
{
    "success": true,
    "resultado": {
        "id": 1,
        "nro_documento": "23851266",
        "cuil": "20068512669",
        "nombre": "Victoria Margarita",
        "apellido": "González",
        "usuario": {
            "id": 2,
            "username": "admin",
            "email": "admin@correo.com",
            "auth_key": "maXx0ibz2Br9UEfP06TVcltr0uOiWl4B",
            "confirmed_at": 1556894840,
            "unconfirmed_email": null,
            "blocked_at": null,
            "registration_ip": "172.18.0.2",
            "created_at": 1556894840,
            "updated_at": 1607700159,
            "flags": 0,
            "last_login_at": 1610453141,
            "baja": 0,
            "descripcion_baja": null,
            "localidadid": 2626,
            "personaid": 1
        }
    }
}
**/

/**** Login *****
 * Autenticacion de usuario
 * @url http://prestaciones-sociales.local/api/usuarios/login
 * @method POST
 * {
        "username":"admin",
        "password_hash":"123456789"
    }
 * @return mixed
    {
        "nombre": "Isabel Sofía",
        "apellido": "Rodríguez",
        "nro_documento": "32054238",
        "cuil": "20320542389",
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2MTUyMzYxNzQsInVzdWFyaW8iOiJhZG1pbiIsInVpZCI6Mn0.4d7j-fconqv0ZL2dcXn17VRHBaHAPwjyRAhWnrvXR7c",
        "username": "admin",
        "programaids": [
            1,
            2,
            3,
            4,
            5,
            6
        ],
        "rol": "admin"
    }
 */