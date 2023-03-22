<?php

namespace SoftwareGalaxy\NidaClient\Lib\QueryMethods;

interface QueryMethod
{
    /**
     * Send the query
     *
     * @param array<string, string> $data
     */
    public function send(array $data): mixed;
}
