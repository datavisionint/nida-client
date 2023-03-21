<?php

namespace SoftwareGalaxy\NIDAClient\Traits;

trait GeneratesRequestIds
{
    /**
     * Generate request ID using uuid
     */
    public function generateId(): string
    {
        return (string) str()->uuid();
    }
}
