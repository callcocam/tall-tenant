<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace Tall\Tenant\Actions;

use Illuminate\Support\Facades\Config;
use Tall\Acl\Contracts\IUser;
use Tall\Team\Team\Facades\Team;
use Tall\Tenant\Events\MakingTenantCurrentEvent;
use Tall\Tenant\Tasks\Collections\TasksCollection;
use Tall\Tenant\Tasks\SwitchTenantTask;

use Tall\Tenant\Contracts\ITenant;
use Tall\Tenant\Facades\Tenant;

class MakeCurrentTenantAction
{
    protected $tasksCollection;

    public function __construct(TasksCollection $tasksCollection)
    {
       
        $this->tasksCollection = $tasksCollection;
    }

    public function execute(ITenant $tenant)
    {
        event(new MakingTenantCurrentEvent($tenant));

        $this
            ->performTasksToMakeTenantCurrent($tenant)
            ->bindAsCurrentTenant($tenant);

        event(new MakingTenantCurrentEvent($tenant));

        return $this;
    }

    protected function performTasksToMakeTenantCurrent(ITenant $tenant): self
    {
        $this->tasksCollection->each(function (SwitchTenantTask $task) use ($tenant) {
            return $task->makeCurrent($tenant);
        });

        return $this;
    }

    protected function bindAsCurrentTenant(ITenant $tenant): self
    {
        $containerKey = config('tenant.current_tenant_container_key');
        
        app()->forgetInstance($containerKey);

        // Team::addTeam($tenant->id);
        Tenant::addTenant('tenant_id', $tenant->id);

        app()->instance($containerKey, $tenant);
        //Alteramos a model do user
        if($provider = Config::get("tenant.user.model.{$tenant->provider}")){
            $clone = config('auth.providers.users');
            $clone['model'] = $provider;        
            Config::set("auth.providers.users", $clone);
            app()->singleton(IUser::class, config('auth.providers.users.model'));
        }
        if($provider = Config::get("tenant.tenant.model.{$tenant->provider}")){
            app()->singleton(ITenant::class, $provider);
        }
        Config::set('fortify.home', sprintf("/%s", $tenant->prefix));
        Config::set('database.default', $tenant->provider);
        Config::set('app.name', $tenant->name);
        Config::set('app.tenant.description', $tenant->description);
        if($address = $tenant->address){
            Config::set('app.address', $address);
        }

        return $this;
    }
}
