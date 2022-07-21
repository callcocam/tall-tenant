<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace Tall\Tenant;

use Illuminate\Http\Request;

abstract class TenantFinder
{
    abstract public function findForRequest(Request $request);
}
