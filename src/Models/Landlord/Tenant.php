<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Tall\Tenant\Models\Landlord;

use Tall\Acl\Contracts\IPermission;
use Tall\Acl\Contracts\IRole;
use Tall\Tenant\Concerns\UsesLandlordConnection;
use Tall\Tenant\Contracts\ITenant;
use Tall\Tenant\Models\Tenant as ModelsTenant;

class Tenant extends ModelsTenant implements ITenant
{
       use UsesLandlordConnection; 

       protected $appends = ['access'];

       public function getAccessAttribute()
       {
              return array_values($this->belongsToMany(app(IRole::class))->pluck('id','id')->toArray());
       }

       
    public function hasHoles()
    {
        return $this->belongsToMany(app(IRole::class))->withTimestamps();
    }
       
    public function hasPermissions()
    {
        return $this->belongsToMany(app(IPermission::class))->withTimestamps();
    }
}
