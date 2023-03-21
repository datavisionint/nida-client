<?php

namespace SoftwareGalaxy\NIDAClient\DTOs;

use SoftwareGalaxy\NIDAClient\Exceptions\NIDARequestHeaderPropertyNotDefinedException;

class NIDARequestHeader
{
    /**
     * NIDA Class
     */
    public function __construct(
        public string $id = '',
        public mixed $timeStamp = '',
        public string $clientNameOrIp = '',
        public string $userId = ''
    ) {
    }

    /**
     * NIDARequestHeader Compulsory properties
     *
     * @var array
     */
    public const PROPERTIES = [
        'id',
        'time_stamp',
        'client_name_or_ip',
        'user_id',
    ];

    /**
     * Check if the $body is valid
     *
     * @return void
     *
     * @throws NIDARequestHeaderPropertyNotDefinedException
     */
    public static function isValid(array $body)
    {
        foreach (self::PROPERTIES as $property) {
            throw_if(
                in_array($property, array_keys($body)),
                new NIDARequestHeaderPropertyNotDefinedException("$property is not defined in the headers")
            );
        }
    }
}
