<?php

namespace SoftwareGalaxy\NIDAClient\Traits;

use SoftwareGalaxy\NIDAClient\Exceptions\NIDAConfigurationNotFoundException;

trait VerifiesNIDAConfiguration
{
    /**
     * Verify NIDA configuration exists
     *
     * @return void
     * @throws NIDAConfigurationNotFoundException
     */
    public function verifyNIDAConfiguration()
    {
        $nidaConfigurations = config("nida-client");
        $keyExceptions = ["key_size", "cipher"];
        foreach ($nidaConfigurations as $key => $value) {
            throw_if(
                $value == null && !in_array($key, $keyExceptions),
                $this->getError(str()->of($key)->upper(), $key)
            );
        }
    }

    /**
     * Return error
     *
     * @param mixed $variableName
     * @param mixed $configurationKeyName
     * @return NIDAConfigurationNotFoundException
     */
    private function getError($variableName, $configurationKeyName)
    {
        return new NIDAConfigurationNotFoundException("The configuration {$variableName} is not set. Either define the variable {$variableName} in your .env file, or publish nida-client configuration and add value for {$configurationKeyName} key");
    }
}
