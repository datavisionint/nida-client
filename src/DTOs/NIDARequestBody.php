<?php

namespace SoftwareGalaxy\NIDAClient\DTOs;

use SoftwareGalaxy\NIDAClient\Exceptions\NIDARequestBodyPropertyNotDefinedException;

class NIDARequestBody
{
    /**
     * Compulsorury Request Body properties
     *
     * @var array
     */
    public const PROPERTIES = ['payload'];

    /**
     * NIDARequestBody class
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
     * @throws NIDARequestBodyPropertyNotDefinedException
     */
    public static function isValid(array $body)
    {
        foreach (self::PROPERTIES as $property) {
            throw_if(
                in_array($property, array_keys($body)),
                new NIDARequestBodyPropertyNotDefinedException("$property is not defined in the body")
            );
        }
    }
}
