<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace Tall\Tenant;


use Illuminate\Support\ServiceProvider;
use Tall\Tenant\Concerns\Config\UsesMultitenancyConfig;
use Tall\Tenant\Tasks\Collections\TasksCollection;
use Tall\Tenant\Concerns\UsesTenantModel;
use Tall\Tenant\TenantFinder;
use Illuminate\Support\Facades\Config;
use Tall\Tenant\TenantFinder as TenantFinderAlias;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\Component as LivewireComponent;
use Livewire\Livewire;
use Symfony\Component\Finder\Finder;

class TenantServiceProvider  extends ServiceProvider
{
    use UsesTenantModel,
    UsesMultitenancyConfig;
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (!$this->app->runningInConsole()){
            if(!\Schema::hasTable('tenants')){
                return;
            }
        }
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!$this->app->runningInConsole()){
            if(!\Schema::hasTable('tenants')){
                return;
            }
        }
        include __DIR__.'/Support/helper.php';
        
        
        $this->bootViews();
        $this->publishConfig();
        $this->loadConfigs();
        $this->publishMigrations();
        $this->loadMigrations();
      
         if (!$this->app->runningInConsole())
           $this->registerTenantFinder()->registerTasksCollection()->configureRequests();
    }

    
    protected function registerTasksCollection(): self
    {
        $this->app->singleton(TasksCollection::class, function () {
            $taskClassNames = config('tenant.switch_tenant_tasks');
            return new TasksCollection($taskClassNames);
        });

        return $this;
    }

    protected function registerTenantFinder(): self
    {
     
        if (config('tenant.tenant_finder')) {
            $this->app->bind(TenantFinder::class, config('tenant.tenant_finder'));
        }
        return $this;
    }

    protected function configureRequests(): self
    {
        $this->determineCurrentTenant();

        return $this;
    }
    protected function determineCurrentTenant()
    {

        if (!config('tenant.tenant_finder')) {
            return;
        }

        /** @var TenantFinderAlias $tenantFinder */
        $tenantFinder = app(TenantFinder::class);

        $tenant = $tenantFinder->findForRequest(request());

        if (!$tenant) {
            abort("400", sprintf('Nenhum tenant cadastrado para %s', request()->getHost()));
        }

        Config::set('fortify.home', sprintf("/%s", $tenant->prefix));
        Config::set('database.default', $tenant->provider);
        if($address = $tenant->address){
            Config::set('app.address', $tenant->address);
        }

       // Config::set('auth.providers.users.model', config(sprintf('tenant.user.model.%s', $tenant->provider)));

        optional($tenant)->makeCurrent();
    }
    protected function bootViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'tenant');
        Livewire::component('tenant::tenants',\Tall\Tenant\Http\Livewire\Admin\Tenants\ListComponent::class);
        Livewire::component('tenant::tenant.create',\Tall\Tenant\Http\Livewire\Admin\Tenants\CreateComponent::class);
        Livewire::component('tenant::tenant.edit',\Tall\Tenant\Http\Livewire\Admin\Tenants\EditComponent::class);
        Livewire::component('tenant::tenant.show',\Tall\Tenant\Http\Livewire\Admin\Tenants\ShowComponent::class);
    }
     /**
     * Publish the config file.
     *
     * @return void
     */
    protected function loadConfigs()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/tenant.php','tenant');
    }

     /**
     * Publish the config file.
     *
     * @return void
     */
    protected function publishConfig()
    {
        $this->publishes([
            __DIR__.'/../config/tenant.php' => config_path('tenant.php'),
        ], 'tenant');
    }

    /**
     * Publish the migration files.
     *
     * @return void
     */
    protected function publishMigrations()
    {
        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations'),
        ], 'tenant-migrations');
       
        $this->publishes([
            __DIR__.'/../database/factories/' => database_path('factories'),
            __DIR__.'/../database/seeders/' => database_path('seeders'),
        ], 'tenant-factories');
    }

    /**
     * Load our migration files.
     *
     * @return void
     */
    protected function loadMigrations()
    {
        if (config('report.migrate', true)) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
    }

}
