<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Tall\Tenant\Models\Tenant;

use Tall\Acl\Contracts\IRole;
use Tall\Tenant\Concerns\UsesTenantConnection;
use Tall\Tenant\Contracts\ITenant;
use Tall\Tenant\Models\Tenant as ModelsTenant;

class Tenant extends ModelsTenant implements ITenant
{
       use UsesTenantConnection; 

    
       protected $guarded = [];
       
       protected $with = ['roles'];
        /**
     * Generate a primary UUID for the model.
     *
     * @return void
     */
    public static function bootHasUuids()
    {
      
        
    }

    public function roles()
    {
        return $this->belongsToMany(app(IRole::class))->withTimestamps();
    }

}
