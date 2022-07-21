<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/

namespace Tall\Tenant\Http\Livewire;

use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;

abstract class FormComponent extends Component
{
    use Actions, WithFileUploads;    
    public $data = [];
    public $model;
    public $photo_url = "profile_photo_url";
    
    abstract protected function view();

    public function saveAndStay(){
         return $this->submit();
    }

    protected function uploadPhoto()
    {
        if (method_exists($this->model, 'updateProfilePhoto')) {
            foreach ($this->data as $name => $value) {
                if ($value instanceof UploadedFile) {
                    data_set($this->data, $this->photo_url, $value->temporaryUrl());
                    $this->model->updateProfilePhoto($value);
                    unset($this->data[$name]);
                }
            }
        }
         return true;
    
    }

    protected function submit(){
            if ($rules = $this->rules())
            $this->validate($this->format_rules($rules));
            $this->uploadPhoto();
            return $this->success();
    }

    protected function success(){
  
        if ($this->model->exists) {
            try {
                if($this->model->update($this->data)){
                    $this->notification()->success(
                        $title = __('SALVOU'),
                        $description = __("Cadastro atualizado com sucesso!!")
                    );
                    return true;
                }
                return false;
            } catch (\PDOException $PDOException) {
                $this->notification()->error(
                    $title = 'Error !!!',
                    $description = $PDOException->getMessage()
                );
                return false;
            }
        } else {
            try {
                $this->model = $this->model->create($this->data);
                if ($this->model->exists) {
                    $this->notification()->success(
                        $title = __('SALVOU'),
                        $description = __("Cadastro criado com sucesso!!")
                    );              
                    return $this->saveAndGoBackResponse();
                }
                return false;
            } catch (\PDOException $PDOException) {
                $this->notification()->error(
                    $title = 'Error !!!',
                    $description = $PDOException->getMessage()
                );
                return false;
            }

        }

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
    protected function saveAndGoBackResponse()
    {
         return true;
    }

    protected function rules(){

    }

   
    protected function format_rules($rules){
       $validations = [];
        foreach ($rules as $key => $value) {
            $validations[sprintf("data.%s", $key)] = $value;
        }
        return $validations;
    }

    protected function layout(){
        if(config("acl.layout")){
            return config("acl.layout");
        }
        return config('livewire.layout');
    }

    /**
     * @param null $model
     */
    protected function setFormProperties($model = null)
    {
        $this->model = $model;
        if ($model) {
            $this->data = $model->toArray();
        } else if (is_array($model)) {
            $this->data = $model;
        }
    }
       
    public function render(){      
        return view($this->view())
        ->layout($this->layout());
    }

    
    protected function clearIsNull($field, $default = null)
    {
        if($default = \Arr::get($this->data, $field)){
            return $default;
        }

        if($default){
          $this->data[$field] = $default;
          return $this;
        }
        if(\Arr::has($this->data,$field)){
            $default =$this->data[$field];
            unset($this->data[$field]);
        }       
        return  $default;
    }
}
