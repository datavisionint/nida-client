<?php

namespace SoftwareGalaxy\NidaClient\Lib\Configuration;

use SoftwareGalaxy\NidaClient\Exceptions\NidaConfigurationNotFoundException;

trait VerifiesNidaConfiguration
{
    /**
     * Verify Nida configuration exists
     *
     * @return void
     *
     * @throws NidaConfigurationNotFoundException
     */
    public function verifyNidaConfiguration()
    {
        $nidaConfigurations = config('nida-client');
        $keyExceptions = ['key_size', 'cipher'];
        foreach ($nidaConfigurations as $key => $value) {
            throw_if(
                $value == null && ! in_array($key, $keyExceptions),
                $this->getError(str()->of($key)->upper(), $key)
            );
        }
    }

    /**
     * Return error
     *
     * @param  mixed  $variableName
     * @param  mixed  $configurationKeyName
     * @return NidaConfigurationNotFoundException
     */
    private function getError($variableName, $configurationKeyName)
    {
        return new NidaConfigurationNotFoundException("The configuration {$variableName} is not set. Either define the variable {$variableName} in your .env file, or publish nida-client configuration and add value for {$configurationKeyName} key");
    }
}
