<?php

namespace SoftwareGalaxy\NidaClient\DTOs;

use SoftwareGalaxy\NidaClient\Exceptions\NidaRequestBodyPropertyNotDefinedException;

class NidaRequestBody
{
    /**
     * Compulsorury Request Body properties
     *
     * @var array
     */
    public const PROPERTIES = ['payload'];

    /**
     * NidaRequestBody class
     */
    public function __construct(
        public mixed $payload
    ) {
    }

    /**
     * Check if the request body is valid
     *
     * @return void
     *
     * @throws NidaRequestBodyPropertyNotDefinedException
     */
    public static function isValid(array $body)
    {
        foreach (self::PROPERTIES as $property) {
            throw_if(
                in_array($property, array_keys($body)),
                new NidaRequestBodyPropertyNotDefinedException("$property is not defined in the body")
            );
        }
    }
}
