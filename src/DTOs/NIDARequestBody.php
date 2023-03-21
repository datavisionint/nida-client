<?php

namespace SoftwareGalaxy\NidaClient\DTOs;

use Exception;

class NIDARequestBody
{

    public const PROPERTIES = ["crypto_info", "payload", "signature"];

    public function __construct(
        public mixed $cryptoInfo = null,
        public NIDARequestBodyPayload $payload,
        public string $signature = null
    ) {
    }

    public static function isValid(array $body)
    {
        foreach (self::PROPERTIES as $property) {
            throw_if(
                in_array($property, array_keys($body)),
                new Exception("$property is not defined in the body")
            );
        }
    }
}
