<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace Tall\Tenant\Concerns;


use Tall\Tenant\Models\Tenant;

trait UsesTenantModel
{
    public function getTenantModel(): Tenant
    {
        $tenantModelClass = config('tenant.tenant_model');

        return new $tenantModelClass;
    }
}
