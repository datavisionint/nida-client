<?php

namespace SoftwareGalaxy\NidaClient\Lib\Response;

class NidaResponseBody
{
    /**
     * NidaResponseBody class
     *
     * @param  array<string>  $payload
     */
    public function __construct(
        public array $payload
    ) {
    }
}
