<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Tall\Tenant;


use Tall\Tenant\Concerns\UsesTenantModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DomainTenantFinder extends TenantFinder
{
    use UsesTenantModel;

    public function findForRequest(Request $request)
    {

        $host = Str::replace("www.", '', $request->getHost());
        $host = Str::replace("new.", '', $host);

        $tenant = $this->getTenantModel()::whereDomain($host)->first();
  
        if ($tenant)
            return $tenant;

        $host = $request->getPort();
        $tenant = $this->getTenantModel()::whereDomain($host)->first();
        return $tenant;
    }
}
