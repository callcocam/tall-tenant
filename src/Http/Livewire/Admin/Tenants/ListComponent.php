<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Tall\Tenant\Http\Livewire\Admin\Tenants;

use Tall\Tenant\Models\Tenant;
use Tall\Tenant\Http\Livewire\TableComponent;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

final class ListComponent extends TableComponent
{
    use AuthorizesRequests;
    
    public function mount()
    {
        $this->authorize(Route::currentRouteName());
    
    }
    
    /*
    |--------------------------------------------------------------------------
    |  Features route
    |--------------------------------------------------------------------------
    | Rota create do crud, cadastrar um novo registro
    |
    */
    public function getCreateProperty()
    {
        return config("tenant.routes.tenants.create");
    }
    /*
    |--------------------------------------------------------------------------
    |  Features view
    |--------------------------------------------------------------------------
    | Inicia as configurações basica do de nomes e rotas
    |
    */
    public function view(){
        return "tenant::livewire.admin.tenants.list-component";
     }
    /*
    |--------------------------------------------------------------------------
    |  Features query
    |--------------------------------------------------------------------------
    | Inicia a consulta ao banco de dados
    |
    */
    protected function query(){
        return Tenant::query();
    }
    
    /*
    |--------------------------------------------------------------------------
    |  Features tableAttr
    |--------------------------------------------------------------------------
    | Inicia as configurações basica do table
    |
    */
    protected function tableAttr(): array
    {
        return [
           'tableTitle' => __('Tenants'),
       ];
    }

}
