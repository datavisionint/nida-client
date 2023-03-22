<?php

namespace SoftwareGalaxy\NidaClient\Lib\Response;

class NidaResponseHeader
{
    public function __construct(
        public string $id = '',
        public mixed $timeStamp = '',
    ) {
    }

}
