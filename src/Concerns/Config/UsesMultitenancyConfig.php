<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasiga.com.br
 * https://www.sigasiga.com.br
 */

namespace Tall\Tenant\Concerns\Config;


use Illuminate\Support\Arr;
use Tall\Tenant\Exceptions\InvalidConfiguration;

trait UsesMultitenancyConfig
{
    private function connections(){
        return config('database.connections');
    }

    private function connection($connection){
        return array_merge(config('database.connections.mysql'), config(sprintf('tenant.database.connections.%s', $connection),[]));
    }

    private function connectionName($connection){
        return config(sprintf('tenant.%s', $connection), config('database.default'));
    }

    public function tenantDatabaseConnectionName()
    {
        $newConection = $this->connections();

        $connection = $this->connectionName('tenant_database_connection_name');

        if ($connection)
            $newConection[$connection] = $this->connection($connection);

        config([
            'database.connections' => $newConection
        ]);

        return $connection;
    }
    public function landlordDatabaseConnectionName()
    {
        $newConection = $this->connections();

        $connection = $this->connectionName('landlord_database_connection_name');
        
        if ($connection)
            $newConection[$connection] = $this->connection($connection);


        config([
            'database.connections' => $newConection
        ]);

        return $connection;
    }

    public function currentTenantContainerKey()
    {
        return config('tenant.current_tenant_container_key');
    }

    public function getMultitenancyActionClass(string $actionName, string $actionClass)
    {

        $configuredClass = config("tenant.actions.{$actionName}");

        if (is_null($configuredClass)) {
            $configuredClass = $actionClass;
        }

        if (!is_a($configuredClass, $actionClass, true)) {
            throw InvalidConfiguration::invalidAction($actionName, $configuredClass ?? '', $actionClass);
        }
      
        return app($configuredClass);
    }

    public function getTenantArtisanSearchFields()
    {
        return Arr::wrap(config('tenant.tenant_artisan_search_fields'));
    }
}
