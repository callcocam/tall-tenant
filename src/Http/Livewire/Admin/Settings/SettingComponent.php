<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Tall\Tenant\Http\Livewire\Admin\Settings;

use Tall\Tenant\Http\Livewire\FormComponent;
use Illuminate\Support\Facades\Route;
use Tall\Form\Fields\Field;
use Tall\Theme\Models\Status;

class SettingComponent extends FormComponent
{

    /*
    |--------------------------------------------------------------------------
    |  Features mount
    |--------------------------------------------------------------------------
    | Inicia o formulario com um cadastro selecionado
    |
    */
    public function mount()
    {
        
        $this->setFormProperties(app('currentTenant')); // $tenant from hereon, called $this->model
    }


    protected function fields()
    {
        return [
            Field::make('Nome do tenant', 'name')->rules('required'),
            Field::make('Dominio', 'domain')
            ->attribute('readonly',true)->rules('required')->span(6),
            Field::make('E-Mail', 'email')->span(6),
            Field::quill('Description', 'description'),
            // Field::make('Prefix', 'prefix')->span(3),
            // Field::make('Database', 'database')->span(3),
            // Field::make('Middleware', 'middleware')->span(6),
            // Field::make('Provider', 'provider')->span(6),
            Field::radio('Status','status_id', Status::query()->pluck('name','id')->toArray()),
            Field::date('Data de criação','created_at')->span(6),
            Field::date('Última atualização', 'updated_at')->span(6),
        ];
    }

     /**
     * Rota para editar um registro
     * Voce deve sobrescrever essas informações no component filho (opcional)
     */
    protected function route_list()
    {
        return route('admin');
    }

    /*
    |--------------------------------------------------------------------------
    |  Features view
    |--------------------------------------------------------------------------
    | Inicia as configurações basica do de nomes e rotas
    |
    */
    protected function view($component="-component"){
        return "tall::admin.settings.setting-component";
     }
}
