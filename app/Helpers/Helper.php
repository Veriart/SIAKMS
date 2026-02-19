<?php

use App\Models\Role;

if(!function_exists('roleName')){
    function roleName($rid){
        $role = Role::find($rid);
        return $role->name;
    }
}