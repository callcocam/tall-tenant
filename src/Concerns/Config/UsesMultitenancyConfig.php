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
    public function eventDatabaseConnectionName()
    {
        $newConection = config('database.connections');

        $connection = config('tenant.event_database_connection_name', config('database.default'));
        if ($connection)
            $newConection[$connection] = array_merge(config('database.connections.mysql'), config(sprintf('tenant.database.connections.%s', $connection)));

        config([
            'database.connections' => $newConection
        ]);

        return $connection;
    }
    public function tenantDatabaseConnectionName()
    {
        $newConection = config('database.connections');

        $connection = config('tenant.tenant_database_connection_name', config('database.default'));
        if ($connection)
            $newConection[$connection] = array_merge(config('database.connections.mysql'), config(sprintf('tenant.database.connections.%s', $connection)));

        config([
            'database.connections' => $newConection
        ]);

        return $connection;
    }
    public function landlordDatabaseConnectionName()
    {
        $newConection = config('database.connections');

        $connection = config('tenant.landlord_database_connection_name', config('database.default'));

        if ($connection)
            $newConection[$connection] = array_merge(config('database.connections.mysql'), config(sprintf('tenant.database.connections.%s', $connection),[]));


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
