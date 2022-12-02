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
use Tall\Theme\Contracts\IMenu;
use Tall\Theme\Contracts\IMenuSub;

class Tenant extends ModelsTenant implements ITenant
{
    use UsesLandlordConnection; 

    protected $appends = ['roles','permissions','menus','menus_sub'];

    public function getRolesAttribute()
    {
            return array_values($this->hasHoles()->pluck('id','id')->toArray());
    }

    public function getPermissionsAttribute()
    {
            return array_values($this->hasPermissions()->pluck('id','id')->toArray());
    }

    public function getMenusAttribute()
    {
            return array_values($this->hasMenus()->pluck('id','id')->toArray());
    }

    public function getMenusSubAttribute()
    {
            return array_values($this->hasMenusSub()->pluck('id','id')->toArray());
    }


    public function hasHoles()
    {
        return $this->belongsToMany(app(IRole::class))->withTimestamps();
    }

    public function hasPermissions()
    {
        return $this->belongsToMany(app(IPermission::class))->withTimestamps();
    }

    public function hasMenus()
    {
        return $this->belongsToMany(app(IMenu::class))->withTimestamps();
    }

    public function hasMenusSub()
    {
        return $this->belongsToMany(app(IMenuSub::class))->withTimestamps();
    }
}
