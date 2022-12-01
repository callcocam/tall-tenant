<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/

if (!function_exists('isTenant')) {
    
    function isTenant(){

        return get_tenant()->provider == config('tenant.tenant_database_connection_name');
   
    }
}

if (!function_exists('get_tenant_id')) {
    
    function get_tenant_id(){

        return get_tenant()->id;

    }
}

if (!function_exists('get_tenant')) {
    
    function get_tenant(){

        $tenant = app(config('tenant.current_tenant_container_key'));

        return $tenant;
    }
}