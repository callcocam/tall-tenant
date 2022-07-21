<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace Tall\Tenant\Tasks;


use Tall\Tenant\Models\Tenant;

interface SwitchTenantTask
{
    public function makeCurrent(Tenant $tenant);

    public function forgetCurrent();
}
