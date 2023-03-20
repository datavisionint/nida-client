<?php

namespace SoftwareGalaxy\NidaClient\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SoftwareGalaxy\NidaClient\NidaClient
 */
class NidaClient extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \SoftwareGalaxy\NidaClient\NidaClient::class;
    }
}
