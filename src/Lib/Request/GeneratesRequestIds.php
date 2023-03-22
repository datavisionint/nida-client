<?php

namespace SoftwareGalaxy\NidaClient\Lib\Request;

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
