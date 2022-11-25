<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/

return [
    /*
   |--------------------------------------------------------------------------
   | Tenant Column
   |--------------------------------------------------------------------------
   |
   | Every model that needs to be scoped by tenant (company, user, etc.)
   | should have one or more columns that reference the `id` of a tenant in the tenant
   | table.
   |
   | For example, if you are scoping by company, you should have a
   | `companies` table that stores all your companies, and your other tables
   | should each have a `company_id` column that references an `id` on the
   | `companies` table.
   |
   */

    'default_tenant_columns' => [
        'id' => 'tenant_id'
    ],
    /*
   * These fields are used by tenant:artisan command to match one or more tenant
   */
    'tenant_artisan_search_fields' => [
        'id',
    ],
    /*
    * These tasks will be performed when switching tenants.
    *
    * A valid task is any class that implements Tall\Tasks\SwitchTenantTask
    */
    'switch_tenant_tasks' => [
        // add tasks here
        \Tall\Tenant\Tasks\SwitchTenantDatabaseTask::class
    ],
    /*
   * This class is responsible for determining which tenant should be current
   * for the given request.
   *
   * This class should extend `Tall\Tenant\Tenant`
   *
   */
    'tenant_finder' => \Tall\Tenant\DomainTenantFinder::class,
    /*
      * Se houver um inquilino atual ao despachar um trabalho, a id do inquilino atual
      * será definido automaticamente no trabalho. Quando o trabalho é executado, o conjunto
      * o inquilino no trabalho será atualizado.
      */
    'queues_are_tenant_aware_by_default' => true,

    /*
     * This class is the model used for storing configuration on tenants.
     *
     * It must be or extend `Tall\Models\Tenant::class`
     */
    'tenant_model' => \Tall\Tenant\Models\Landlord\Tenant::class,
    /*
    * This class is the model used for storing configuration on tenants.
    *
    * It must be or extend `Tall\Models\Tenant::class`
    */
    'user' => [
        'model' => [
            'mysql' => \Tall\Tenant\Models\Landlord\User::class,
            'landlord' => \Tall\Tenant\Models\Landlord\User::class,
            'tenants' => \Tall\Tenant\Models\Tenant\User::class
        ]
    ],
    /*
         * The connection name to reach the tenant database.
         *
         * Set to `null` to use the default connection.
         */
    'tenant_database_connection_name' => "tenants",

    /*
     * The connection name to reach the landlord database
     */
    'landlord_database_connection_name' => 'mysql',

    /*
     * This key will be used to bind the current tenant in the container.
     */
    'current_tenant_container_key' => 'currentTenant',

    'database' => [
        'connections' => [
            'tenants' => [
                'driver' => 'mysql',
                'host' => env('DB_TENANT_HOST', '127.0.0.1'),
                'port' => env('DB_TENANT_PORT', '3306'),
                'database' => env('DB_TENANT_DATABASE', 'tenants'),
                'username' => env('DB_TENANT_USERNAME', 'sail'),
                'password' => env('DB_TENANT_PASSWORD', 'password'),
            ],
        ]
    ],
    'default-connection' => 'UsesTenantConnection',
];
