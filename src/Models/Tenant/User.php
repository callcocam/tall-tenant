<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Tall\Tenant\Models\Tenant;



use App\Models\User as ModelsUser;
use Tall\Acl\Contracts\IUser;
use Tall\Tenant\BelongsToTenants;
use Tall\Tenant\Concerns\UsesTenantConnection;

class User extends ModelsUser implements IUser
{
    use UsesTenantConnection, BelongsToTenants;

}
