<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Tall\Tenant\Models\Tenant;

use Laravel\Jetstream\HasTeams;
use Tall\Team\Contracts\IUser;
use App\Models\User as ModelsUser;
use Tall\Team\Concerns\HasRolesAndPermissions;
use Tall\Tenant\BelongsToTenants;
use Tall\Tenant\Concerns\UsesTenantConnection;

class User extends ModelsUser implements IUser
{
    use UsesTenantConnection, BelongsToTenants;
    use HasTeams;
    use HasRolesAndPermissions;


    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d',
    ];
}
