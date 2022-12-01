<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Tall\Tenant\Models\Landlord;

use App\Models\User as ModelsUser;
use Tall\Acl\Concerns\HasRolesAndPermissions;
use Tall\Acl\Contracts\IUser;
use Tall\Tenant\Concerns\UsesLandlordConnection;

class User extends ModelsUser implements IUser
{
    use UsesLandlordConnection;
    use HasRolesAndPermissions;


}
