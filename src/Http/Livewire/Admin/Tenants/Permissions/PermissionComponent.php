<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Tall\Tenant\Http\Livewire\Admin\Tenants\Permissions;

use Illuminate\Support\Facades\Route;
use Tall\Acl\Contracts\IPermission;
use Tall\Form\Fields\Field;
use Tall\Orm\Http\Livewire\FormComponent;
use Tall\Tenant\Models\Landlord\Tenant;

class PermissionComponent extends FormComponent
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
        $this->setFormProperties($model, Route::currentRouteName());  // $tenant from hereon, called $this->model
    }

     

    protected function fields()
    {
        return [
            Field::checkbox('Roles', 'permissions', app(IPermission::class)
            ->pluck('name', 'id')->toArray())->multiple(true),
        ];
    }

     /**
     * @param $callback uma função anonima para dar um retorno perssonalizado
     * Função de sucesso ou seja passou por todas as validações e agora pode ser salva no banco
     * Voce pode sobrescrever essas informações no component filho
     */
    protected function success($callback=null)
    {
        $this->model->hasPermissions()->sync(data_get($this->form_data, 'permissions'));

        return true;
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
          return route("admin");
    }
    
    /*
    |--------------------------------------------------------------------------
    |  Features view
    |--------------------------------------------------------------------------
    | Inicia as configurações basica do de nomes e rotas
    |
    */
    protected function view($component="-component"){
        return "tall::admin.tenants.permissions.show-component";
     }
}
