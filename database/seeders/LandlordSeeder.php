<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Tall\Tenant\Contracts\ITenant;

class LandlordSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        // $clone = config('database.connections.mysql');
        // $clone['database'] = 'landlord';
        // Config::set("database.connections.landlord", $clone);
        // Config::set("database.default", 'landlord');

        $host = \Illuminate\Support\Str::replace("www.",'',request()->getHost());
     
        $connection = config("tenant.landlord_database_connection_name","mysql");
         /**
         *@var $tenantModel Builder
         */
        $tenantModel = app( config("tenant.tenant_model","mysql"));

        DB::connection($connection)->table('tenants')->delete();

        $id =  \Ramsey\Uuid\Uuid::uuid4();

        DB::connection($connection)->table('tenants')->insert(   $tenantModel->factory()->make([
            'id' => $id,
            'name' => "Sistema Integrado De Gerenciamento E Administração",
            'slug' => "sistema-integrado-de-gerenciamento-e-administracao",
            'domain'=> $host,
            'email' => "contato@sigasmart.com.br",
            'description' => 'Sistema Integrado De Gerenciamento E Administração',
            'database'=>$connection,
            'prefix'=>'admin',
            'middleware'=>$connection,
            'provider'=>$connection,
        ])->toArray());
    }
}
