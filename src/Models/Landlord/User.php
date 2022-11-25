<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Tall\Tenant\Models\Landlord;

use Laravel\Jetstream\HasTeams;
use Tall\Team\Contracts\IUser;
use App\Models\User as ModelsUser;
use Tall\Team\Concerns\HasRolesAndPermissions;
use Tall\Tenant\Concerns\UsesLandlordConnection;

class User extends ModelsUser implements IUser
{
    use UsesLandlordConnection;
    use HasTeams;
    use HasRolesAndPermissions;


}
