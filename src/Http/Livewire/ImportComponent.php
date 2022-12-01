<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/

namespace Tall\Tenant\Http\Livewire;

use Illuminate\Support\Facades\Route;
use Tall\Orm\Http\Livewire\ImportComponent as LivewireImportComponent;

abstract class ImportComponent extends LivewireImportComponent
{
   
     /**
     * importAttr
     * Informação basica da visualização
     * Nome da visualização
     * Uma descrição com detalhes da visualização
     * Uma rota de retorno para a lista ou para outra visualização pré definida
     * Voce pode sobrescrever essas informações no component filho
     */
    protected function importAttr(): array
    {
      
        return [
            'title'=>$this->title(),
            'description'=>$this->description(),
            'routeList'=>session()->get('back'),
            'active'=>$this->active(),
            'span'=>$this->span(),
            'spanLeft'=>$this->spanLeft(),
            'spanRigth'=>$this->spanRigth(),
            'crud'=>[
                'list'=>$this->route_list()
            ]
        ];
    }
    /**
     * Data
     * Informação que serão passsadas para view template
     * Coloque todos dado que prentende passar para a view
     * Voce pode sobrescrever essas informações no component filho
     */
    protected function data(){

        $fields['fields']= $this->fields();
        $fields['importAttr']= $this->importAttr();
        return $fields;

    }
  
    /**
     * Monta um array de campos (opcional)
     * Voce pode sobrescrever essas informações no component filho
     * Uma opção e trazer essas informações do banco
     * @return array
     */
    protected function fields()
    {
        return [];
    }

    
    public function span()
    {
        return '12';
    }
  
    public function spanLeft()
    {
        return '4';
    }
  
    public function spanRigth()
    {
        return '4';
    }
    
    
     /**
     * Rota para editar um registro
     * Voce deve sobrescrever essas informações no component filho (opcional)
     */
    protected function route_list()
    {
        if($config = $this->config){
            if(Route::has($config->route)){
                $params =$this->path;
                return route($config->route, $params);
            }              
         }
        return null;
    }

}
