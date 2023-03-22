<?php

namespace SoftwareGalaxy\NidaClient\Lib\Response;

class NidaResponseStatus
{
    /**
     * NidaResponseStatus class
     */
    public function __construct(
        public string $component,
        public string $code
    ) {
    }
}
