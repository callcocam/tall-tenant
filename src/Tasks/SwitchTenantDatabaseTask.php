<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace Tall\Tenant\Tasks;


use Illuminate\Support\Facades\DB;
use Tall\Tenant\Exceptions\InvalidConfiguration;
use Tall\Tenant\Models\Tenant;
use Tall\Tenant\Concerns\Config\UsesMultitenancyConfig;

class SwitchTenantDatabaseTask implements SwitchTenantTask
{
    use UsesMultitenancyConfig;

    public function makeCurrent(Tenant $tenant)
    {
        $this->setTenantConnectionDatabaseName($tenant->getDatabaseName());
    }

    public function forgetCurrent()
    {
        $this->setTenantConnectionDatabaseName(null);
    }

    protected function setTenantConnectionDatabaseName( $databaseName)
    {
        $tenantConnectionName = $this->tenantDatabaseConnectionName();

        if ($tenantConnectionName === $this->landlordDatabaseConnectionName()) {
            throw InvalidConfiguration::tenantConnectionIsEmptyOrEqualsToLandlordConnection();
        }

        if (is_null(config("database.connections.{$tenantConnectionName}"))) {
            throw InvalidConfiguration::tenantConnectionDoesNotExist($tenantConnectionName);
        }

        config([
            "database.connections.{$tenantConnectionName}.database" => $databaseName,
        ]);

        DB::purge($tenantConnectionName);
    }
}
