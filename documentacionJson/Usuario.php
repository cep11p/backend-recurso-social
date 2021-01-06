<?php

/**** Para mostrar listado ****/
/**
* @url http://prestaciones-sociales.local/api/usuarios
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
**/

/**** Para modificar*****
* @url http://prestaciones-sociales.local/api/usuarios/{$id} 
* @method PUT
* @param arrayJson
**/

/****** Para visualizar*****
* @url http://prestaciones-sociales.local/api/usuarios/{$id} 
* @method GET
* @return arrayJson
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
    "last_login_at": 1609850883
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
