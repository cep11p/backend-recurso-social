<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\api\models;

use dektrium\user\models\User;

class ApiUser extends User {

    use \msheng\JWT\UserTrait;
}