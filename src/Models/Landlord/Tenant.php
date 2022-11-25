<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Tall\Tenant\Models\Landlord;

use Tall\Tenant\Concerns\UsesLandlordConnection;
use Tall\Tenant\Contracts\ITenant;
use Tall\Tenant\Models\Tenant as ModelsTenant;

class Tenant extends ModelsTenant implements ITenant
{
       use UsesLandlordConnection; 

}
