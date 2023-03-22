<?php

namespace SoftwareGalaxy\NidaClient\Lib\Response;

class NidaResponseStatus
{

    /**
     * NidaResponseStatus class
     *
     * @param  array<string>  $payload
     */
    public function __construct(
        public string $component,
        public string $code
    ) {
    }
}
