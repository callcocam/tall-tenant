<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Tall\Tenant\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class TallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tall:install  {--force}  {--m}  {--j}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configuração e Intalação do pacote';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        if ($this->option('force')) {
        $path=database_path('migrations');
        foreach ((new \Symfony\Component\Finder\Finder)->in($path)->files()->name('*.php') as $file) {
            File::delete($file->getRealPath());
        }  
        $path=database_path('factories');
        foreach ((new \Symfony\Component\Finder\Finder)->in($path)->files()->name('*.php') as $file) {
            File::delete($file->getRealPath());
        }
        
        $path=database_path('seeders');
        foreach ((new \Symfony\Component\Finder\Finder)->in($path)->files()->name('*.php') as $file) {
            File::delete($file->getRealPath());
        }


        $this->call('vendor:publish',[
            '--tag' => 'tall',
            '--force' => true
        ]);


        $this->call('vendor:publish',[
            '--tag' => 'tenant-database',
            '--force' => true
        ]);

        $this->call('vendor:publish',[
            '--tag' => 'theme-database',
            '--force' => true
        ]);

        $this->call('vendor:publish',[
            '--tag' => 'cms-database',
            '--force' => true
        ]);

        $this->call('vendor:publish',[
            '--tag' => 'acl-database',
            '--force' => true
        ]);

        if(!is_dir(resource_path('views/vendor'))){
            mkdir(resource_path('views/vendor'));
        }
        if(!is_dir(resource_path('views/vendor/livewire'))){
            mkdir(resource_path('views/vendor/livewire'));
        }

        if ($this->option('m')) {
            $this->call('migrate:fresh',[
                '--seed' => true
            ]);
        }

    }else{
        // $this->call('vendor:publish',[
        //     '--tag' => 'tall'
        // ]);
    }

    $this->line("<options=bold,reverse;fg=green> WHOOPS-IE-TOOTLES </> 😳 \n");
    }
}
