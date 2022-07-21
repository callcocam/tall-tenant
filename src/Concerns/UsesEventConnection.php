<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace Tall\Tenant\Concerns;


use Tall\Tenant\Concerns\Config\UsesMultitenancyConfig;

trait UsesEventConnection
{
    use UsesMultitenancyConfig;

    public function getConnectionName()
    {
        return $this->eventDatabaseConnectionName();
    }
}
