<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/

if(!function_exists('routeTenant')){

    function routeTenant()
    {
        return config('tenant.routes.tenant.list');
    }
}


if(!function_exists('routeTenantCreate')){

    function routeTenantCreate()
    {
        return config('tenant.routes.tenant.create');
    }
}


if(!function_exists('routeTenantEdit')){

    function routeTenantEdit()
    {
        return config('tenant.routes.tenant.edit');
    }
}


if(!function_exists('routeTenantShow')){

    function routeTenantShow()
    {
        return config('tenant.routes.tenant.show');
    }
}