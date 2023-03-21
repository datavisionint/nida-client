<?php

namespace SoftwareGalaxy\NIDAClient\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SoftwareGalaxy\NIDAClient\NIDAClient
 */
class NIDAClient extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \SoftwareGalaxy\NIDAClient\NIDAClient::class;
    }
}
