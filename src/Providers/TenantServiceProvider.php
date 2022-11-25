<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace Tall\Tenant\Providers;

use Illuminate\Support\ServiceProvider;
use Tall\Tenant\Concerns\Config\UsesMultitenancyConfig;
use Tall\Tenant\TenantFinder;
use Tall\Tenant\TenantFinder as TenantFinderAlias;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;
use Tall\Tenant\Concerns\UsesTenantModel;
use Tall\Tenant\Contracts\ITenant;
use Tall\Tenant\Models\Landlord\Tenant;
use Tall\Tenant\Tasks\Collections\TasksCollection;
use Tall\Tenant\TenantManager;
use Tall\Theme\Contracts\IStatus;
use Tall\Theme\Models\Status;
use Tall\Theme\Providers\ThemeServiceProvider;

class TenantServiceProvider  extends ServiceProvider
{
    use UsesTenantModel,
    UsesMultitenancyConfig;
    /**
     * Register any application services.
     *packages\tall-tenant
      *packages\tall-tenant\src\Providers\TenantServiceProvider.php
     * @return void
     */
    public function register()
    {
        if (!$this->app->runningInConsole()){
            if(!Schema::hasTable('tenants')){
                return;
            }
        }
        $this->app->singleton(TenantManager::class, function () {
            return new TenantManager();
        });
        
        if(class_exists('App\Models\Tenant')){
            $this->app->singleton(ITenant::class, 'App\Models\Tenant');
        }
        else{
            $this->app->singleton(ITenant::class, Tenant::class);
        }

        if(class_exists('App\Models\Status')){
            $this->app->singleton(IStatus::class, 'App\Models\Status');
        }
        else{
            $this->app->singleton(IStatus::class, Status::class);
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
            if(!Schema::hasTable('tenants')){
                return;
            }
        }
        
        
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

        // Config::set('fortify.home', sprintf("/%s", $tenant->prefix));
        // Config::set('database.default', $tenant->provider);
        // Config::set('app.name', $tenant->name);
        // Config::set('app.tenant.description', $tenant->description);
        // if($address = $tenant->address){
        //     Config::set('app.address', $tenant->address);
        // }

       // Config::set('auth.providers.users.model', config(sprintf('tenant.user.model.%s', $tenant->provider)));

        optional($tenant)->makeCurrent();
    }
    protected function bootViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'tall');
        if(is_dir(resource_path("views/vendor/tall/tenant"))){
            $this->loadViewsFrom(resource_path("views/vendor/tall/tenant"), 'tall');
        }

        ThemeServiceProvider::configureDynamicComponent(__DIR__."/../../resources/views/components");

        if(is_dir(resource_path("views/vendor/tall/tenant/components"))){
            ThemeServiceProvider::configureDynamicComponent(resource_path("views/vendor/tall/tenant/components"));
        }

        Livewire::component('tall::admin.tenants',\Tall\Tenant\Http\Livewire\Admin\Tenants\ListComponent::class);
        Livewire::component('tall::admin.tenant.create',\Tall\Tenant\Http\Livewire\Admin\Tenants\CreateComponent::class);
        Livewire::component('tall::admin.tenant.edit',\Tall\Tenant\Http\Livewire\Admin\Tenants\EditComponent::class);
        Livewire::component('tall::admin.tenant.show',\Tall\Tenant\Http\Livewire\Admin\Tenants\ShowComponent::class);
        Livewire::component('tall::admin.settings.setting-component',\Tall\Tenant\Http\Livewire\Admin\Settings\SettingComponent::class);
    }
     /**
     * Publish the config file.
     *
     * @return void
     */
    protected function loadConfigs()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/tenant.php','tenant');
    }

     /**
     * Publish the config file.
     *
     * @return void
     */
    protected function publishConfig()
    {
        $this->publishes([
            __DIR__.'/../../config/tenant.php' => config_path('tenant.php'),
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
            __DIR__.'/../../database/' => database_path(),
        ], 'tenant-database');


    }

    /**
     * Load our migration files.
     *
     * @return void
     */
    protected function loadMigrations()
    {
        if (config('tenant.migrate', true)) {
            $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        }
    }

}
