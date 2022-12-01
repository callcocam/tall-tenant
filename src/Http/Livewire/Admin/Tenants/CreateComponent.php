<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Tall\Tenant\Http\Livewire\Admin\Tenants;

use Tall\Tenant\Models\Tenant;
use Tall\Tenant\Http\Livewire\FormComponent;
use Tall\Form\Fields\Field;
use Tall\Theme\Models\Status;
use Tall\Tenant\Models\Tenant\Tenant as TenantTenant;

class CreateComponent extends FormComponent
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
        abort_if(isTenant(), '403');
        
        $this->setFormProperties($model); // $tenant from hereon, called $this->model
        data_set($this->form_data,'prefix','admin');
        data_set($this->form_data,'database','tenants');
        data_set($this->form_data,'middleware','tenants');
        data_set($this->form_data,'provider','tenants');
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
            Field::radio('Status','status_id', Status::query()->pluck('name','id')->toArray()),
            Field::date('Data de criação','created_at')->span(6),
            Field::date('Última atualização', 'updated_at')->span(6),
        ];
    }

       /**
     * @param $callback uma função anonima para dar um retorno perssonalizado
     * Função de sucesso ou seja passou por todas as validações e agora pode ser salva no banco
     * Voce pode sobrescrever essas informações no component filho
     */
    protected function success($callback=null)
    {
        return parent::success(function($model, $result=true){
                TenantTenant::query()->firstOrCreate([
                     'id'=>$model->id
                ]);
        });
    }

    /*
    |--------------------------------------------------------------------------
    |  Features saveAndGoBackResponse
    |--------------------------------------------------------------------------
    | Rota de redirecionamento apos a criação bem sucedida de um novo registro
    |
    */
     /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveAndGoBackResponse()
    {
        return redirect()->route('admin.tenants.edit', $this->model);
    }

     /*
    |--------------------------------------------------------------------------
    |  Features view
    |--------------------------------------------------------------------------
    | Inicia as configurações basica do de nomes e rotas
    |
    */
    protected function view($component="-component"){
        return "tall::admin.tenants.create-component";
     }
}
