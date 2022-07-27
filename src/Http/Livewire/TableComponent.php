<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/

namespace Tall\Tenant\Http\Livewire;

use Livewire\{Component, WithPagination};
use Illuminate\Support\{Collection as BaseCollection, Str};
use WireUi\Traits\Actions;
use Illuminate\Database\Eloquent\Builder;

abstract class TableComponent extends Component
{
    use Actions, WithPagination;

    public $perPage = 12;

    public $field = 'name';

    public $search;
    
    public string $sort = 'id';

    public string $direction = 'asc';


    protected $queryString = [
        'direction' => ['except' => 'asc'],
        'sort' => ['except' => 'id'],
        'search' => ['except' => ''],
        'page' => ['except' => 1],
        'perPage' => ['except' => 12],
    ];

    abstract protected function view();
    

    abstract protected function query();


    protected function layout(){
        if(config("tenant.layout")){
            return config("tenant.layout");
        }
        return config('livewire.layout');
    }

    public function sortBy(string $field, string $direction = 'asc'): void
    {
        $this->direction = $this->sort === $field ? $this->reverseSort() : $direction;

        $this->sort = $field;
    }

       
    public function render(){      
        return view($this->view())->layout($this->layout())->with('models', $this->models());
    }  
    
    /**
     * @return AbstractPaginator|BaseCollection
     * @throws Exception
     */
    protected function models(){

        /** @var Builder|BaseCollection|\Illuminate\Database\Eloquent\Collection $datasource */
        $builder = $this->applySorting($this->query());

        return $this->applyFilter($builder)
        ->paginate($this->perPage);
    }

        

    public function kill($value)
    {
        if($value){
            if($this->query()->where('id', $value)->delete()){
                $this->reset(['search','perPage']);            
                $this->notification()->success(
                    $title = __('Deleted'),
                    $description = __("Registro excluido com sucesso :)")
                );
            }
       }
    }

    public function updateOrder($data){

    }

    protected function applyFilter(Builder $query): Builder
    {
        if($search = $this->search){
            return  $query->where($this->field, 'LIKE', "%{$search}%");
        }
       return  $query;
    }

    protected function applySorting(Builder $query): Builder
    {
       return $query->orderBy($this->sort, $this->direction);
    }
    
    protected function reverseSort(): string
    {
        return $this->direction === 'asc' ? 'desc' : 'asc';
    }

}
