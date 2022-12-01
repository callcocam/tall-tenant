<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Tall\Tenant\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class TallTenantMigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:migrate {--path=/database/migrations}  {--database=tenants}  {--seed} {--fresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'rodar migrations para os tenants';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Config::set('tenant.database.connections.tenants', array_merge(config('database.connections.mysql'),config('tenant.database.connections.tenants')));
        Config::set('database.connections', array_merge(config('database.connections'),config('tenant.database.connections')));
        Config::set('database.default', $this->option('database'));
       
        $opt = [
        '--seed' => $this->option('seed'),
        '--database' => $this->option('database'),
        '--path' => $this->option('path')
        ];
        if($this->option('fresh')){
            $this->call('migrate:fresh',$opt);
        }else{
            $this->call('migrate',$opt);
        }


        
        // if(!$this->option('seed')){
        //     $this->call('db:seed',[
        //         '--class' => "StatusSeeder",
        //     ]);
        
        //     $this->call('db:seed',[
        //         '--class' => "LandlordSeeder",
        //     ]);
        //     $this->call('db:seed',[
        //         '--class' => "TeamSeeder",
        //     ]);
        // }
        // ./vendor/bin/sail artisan migrate --database=landlord --path=/database/migrations/landlord
        
    $this->line("<options=bold,reverse;fg=green> WHOOPS-IE-TOOTLES </> 😳 \n");

    }
}
