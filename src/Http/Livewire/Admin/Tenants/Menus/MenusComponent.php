<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Tall\Tenant\Http\Livewire\Admin\Tenants\Menus;

use Illuminate\Support\Facades\Route;
use Tall\Form\Fields\Field;
use Tall\Orm\Http\Livewire\FormComponent;
use Tall\Tenant\Models\Landlord\Tenant;
use Tall\Theme\Contracts\IMenu;

class MenusComponent extends FormComponent
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
        $this->setFormProperties($model);  // $tenant from hereon, called $this->model
    }

     

    protected function fields()
    {
        return [
            Field::checkbox('Menus', 'menus', app(IMenu::class)
            ->pluck('name', 'id')->toArray())->multiple(true)->format(function($model, $field, $key, $value){
                $route = 'admin.tenants.menus.sub';
                return  view('tall::link', compact('model','field','key','value', 'route'));
            }),
        ];
    }

     /**
     * @param $callback uma função anonima para dar um retorno perssonalizado
     * Função de sucesso ou seja passou por todas as validações e agora pode ser salva no banco
     * Voce pode sobrescrever essas informações no component filho
     */
    protected function success($callback=null)
    {
        $this->model->hasMenus()->sync(data_get($this->form_data, 'menus'));

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
        return "tall::admin.tenants.menus.menus-component";
     }

     
    protected function ignoreActions()
    {
        return ['.create','.edit','.show','.delete','.permissions','.menus','.menus.sub'];
    }
}
