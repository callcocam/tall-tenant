<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Tall\Tenant\Http\Livewire\Admin\Tenants\Import;

use Livewire\WithFileUploads;
use League\Csv\Reader;
use League\Csv\Statement;
use Tall\Cms\Helpers\ChunkIterator;
use Tall\Tenant\Contracts\ITenant;
use Illuminate\Support\Str;
use Tall\Cms\Models\Make;
use Tall\Orm\Http\Livewire\ImportComponent;

class CsvComponent extends ImportComponent
{
    use WithFileUploads;
    /**
     * @var $file Illuminate\Http\UploadedFile
     */
    public $file;

    /*
    |--------------------------------------------------------------------------
    |  Features mount
    |--------------------------------------------------------------------------
    | Inicia o formulario com um cadastro selecionado
    |
    */
    public function mount(?Make $model)
    {
        $this->setFormProperties($model); // $tenant from hereon, called $this->model
    }

     
    public function updatedFile()
    {
        $this->validateOnly('file');

        $csv = $this->readCsv;

        $this->fileHeaders = $csv->getHeader();

        // $headers = $csv->getHeader();

        // $this->fileHeaders = collect($headers)->filter(function($header){

        //     return !in_array($header, ['deleted_at','created_at','updated_at','slug']);

        // })->toArray();


        $this->setColumnsProperties();

        $this->resetValidation();

    }

    public function readCsv($path)
    {
      $strem = fopen($path, 'r');
  
      $csv = Reader::createFromStream($strem);
  
      $csv->setHeaderOffset(0);
  
      return $csv;
  
    }

    public function getReadCsvProperty()
    {
      return $this->readCsv($this->file->getRealPath());
    }
  
    public function getCsvRecordsProperty()
    {
      return Statement::create()->process($this->readCsv);
    }
  
      public function rules()
      {
          $columnRules = collect($this->requiredColumnMaps)->mapWithKeys(fn($column)=>[sprintf('columnMaps.%s',$column)=>['required']])->toArray();
        
          return array_merge($columnRules, [
  
              'file'=>['required','mimes:csv','max:51200']
  
          ]);
      }
  
      public  function array_not_unique( $a = array() )
      {
        return array_diff_key( $a , array_unique( $a ) );
      }
  
      public function import()
      {
          
           $columnMaps = array_filter($this->columnMaps);
  
          if($dupliacates = $this->array_not_unique($columnMaps)){
              foreach ($dupliacates as $key => $value) {
                  $this->addError(sprintf("columnMaps.%s",$key), sprintf("O %s esta selecionado em %s", $value, $key));
              }
              return false;
          }
          $this->validate();
  
  
          $batches = collect(

            (new ChunkIterator($this->csvRecords->getRecords(), 10))->get()

        )->map(function($chunk) {
           
            return $chunk;

        })->toArray();

        $connection = config("tenant.tenant_database_connection_name","tenants");
        

        foreach ($batches as $batche) {
         
          foreach ($batche as $value) {
            $domain = data_get($value, 'assets');
            $domain = Str::afterLast($domain, 'www.');
            $domain = Str::beforeLast($domain, '.');
            $domain = Str::beforeLast($domain, '.');

              app()->make(ITenant::class)->firstOrCreate([
                'name' => data_get($value, 'name'),
              ],[
                'slug' => data_get($value, 'slug'),
                'domain'=> sprintf("%s.test", $domain),
                'email' => data_get($value, 'email'),
                'description' => data_get($value, 'description'),
                'database'=>$connection,
                'prefix'=>'admin',
                'middleware'=>$connection,
                'provider'=>$connection,
              ]);
            }
          }
          
          $this->reset(['file','fileHeaders', 'columnMaps','requiredColumnMaps']);
  
          $this->showDrawer = false;
  
          $this->emit('refreshImport', null);
          
      }
    

      public function getColumnsProperty()
      {   
          return $this->columnMaps;
      }
  
  

    /*
    |--------------------------------------------------------------------------
    |  Features view
    |--------------------------------------------------------------------------
    | Inicia as configurações basica do de nomes e rotas
    |
    */
    protected function view($component="-component"){
        return "tall::admin.tenants.import.csv-component";
     }

     
    protected function ignoreColumns(){
      return ['updated_at','domain','prefix','provider','database','middleware'];
    }

}
