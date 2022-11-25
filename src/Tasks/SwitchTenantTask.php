<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace Tall\Tenant\Tasks;

use Tall\Tenant\Contracts\ITenant;

interface SwitchTenantTask
{
    public function makeCurrent(ITenant $tenant);

    public function forgetCurrent();
}
