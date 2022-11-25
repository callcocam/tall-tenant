<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace Tall\Tenant\Events;

use Tall\Tenant\Contracts\ITenant;

class ForgettingCurrentTenantEvent
{
    public $tenant;

    public function __construct(ITenant $tenant)
    {
        $this->tenant = $tenant;
    }
}