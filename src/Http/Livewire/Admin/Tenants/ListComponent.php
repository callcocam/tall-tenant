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
use Tall\Table\Fields\Column;

final class ListComponent extends TableComponent
{
    
    public function mount()
    {

        $this->setUp(Route::currentRouteName());
    }
     
    /**
     * Função para trazer uma lista de colunas (opcional)
     * Geralmente usada com um component de table dinamicas
     * Voce pode sobrescrever essas informações no component filho 
     */
    public function columns(){
        return [
            Column::make('Name'),
            Column::actions([
                Column::make('Edit')->icon('pencil')->route('admin.tenants.edit'),
                Column::make('Permissões')->icon('lock-open')->route('admin.tenants.permissions'),
                Column::make('Menus')->icon('lock-open')->route('admin.tenants.menus'),
            ]),

        ];
    }


    /*
    |--------------------------------------------------------------------------
    |  Features view
    |--------------------------------------------------------------------------
    | Inicia as configurações basica do de nomes e rotas
    |
    */
    protected function view($component="-component"){
        return "tall::admin.tenants.list-component";
     }
    /*
    |--------------------------------------------------------------------------
    |  Features query
    |--------------------------------------------------------------------------
    | Inicia a consulta ao banco de dados
    |
    */
    protected function query(){
        return Tenant::query() ->when(isTenant(), function($builder){
            return $builder->where('id',get_tenant_id());
        });
    }

  /**
     * Rota para cadastra um novo registro
     * Voce deve sobrescrever essas informações no component filho (opcional)
     */
    protected function route_create()
    {

        if(isTenant()) return null;

        return parent::route_create();
    }

}
