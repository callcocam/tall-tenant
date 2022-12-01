<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Tall\Tenant\Http\Livewire\Admin\Tenants;

use Tall\Tenant\Http\Livewire\FormComponent;
use Illuminate\Support\Facades\Route;
use Tall\Acl\Contracts\IRole;
use Tall\Form\Fields\Field;
use Tall\Tenant\Models\Landlord\Tenant;
use Tall\Tenant\Models\Tenant\Tenant as TenantTenant;
use Tall\Theme\Models\Status;

class EditComponent extends FormComponent
{

    /*
    |--------------------------------------------------------------------------
    |  Features mount
    |--------------------------------------------------------------------------
    | Inicia o formulario com um cadastro selecionado
    |
    */
    public function mount(?Tenant $model)
    {
        
        $this->setFormProperties($model, Route::currentRouteName()); // $tenant from hereon, called $this->model
       
    }


    protected function fields()
    {
        return [
            Field::make('Nome do tenant', 'name')->rules('required')->span(8),
            Field::make('Dominio', 'domain')->rules('required')->span(4),
            Field::make('E-Mail', 'email')->span(6),
            Field::make('Prefix', 'prefix')->span(3),
            Field::make('Database', 'database')->span(3),
            Field::make('Middleware', 'middleware')->span(6),
            Field::make('Provider', 'provider')->span(6),
            Field::quill('Description', 'description'),
            Field::radio('Status','status_id', Status::query()->pluck('name','id')->toArray()),
            Field::date('Data de criação','created_at')->span(6),
            Field::date('Última atualização', 'updated_at')->span(6),
            Field::checkbox('Roles', 'access', app(IRole::class)->pluck('name', 'id')->toArray())->multiple(true),
        ];
    }
    
    /**
     * @param $callback uma função anonima para dar um retorno perssonalizado
     * Função de sucesso ou seja passou por todas as validações e agora pode ser salva no banco
     * Voce pode sobrescrever essas informações no component filho
     */
    protected function success($callback=null)
    {
        return parent::success(function($model, $result=false){

               $this->model->hasHoles()->sync(data_get($this->form_data, 'access'));

                TenantTenant::query()->updateOrCreate([
                     'id'=>$model->id
                ],
                [
                    'id'=>$model->id,
                    'name'=>$model->name,
                    'description'=>$model->description,
                ]
            );
        });
    }
    /*
    |--------------------------------------------------------------------------
    |  Features view
    |--------------------------------------------------------------------------
    | Inicia as configurações basica do de nomes e rotas
    |
    */
    protected function view($component="-component"){
        return "tall::admin.tenants.edit-component";
     }
}
