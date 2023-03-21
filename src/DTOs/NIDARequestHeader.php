<?php

namespace SoftwareGalaxy\NidaClient\DTOs;

use DateTime;
use Exception;

class NIDARequestHeader
{

    public function __construct(
        public string $id = "",
        public mixed $timeStamp = "",
        public string $clientNameOrIp = "",
        public string $userId = ""
    ) {}


    public const PROPERTIES = [
        "id",
        "time_stamp",
        "client_name_or_ip",
        "user_id"
    ];


    public static function isValid(array $body)
    {
        foreach (self::PROPERTIES as $property) {
            throw_if(
                in_array($property, array_keys($body)),
                new Exception("$property is not defined in the headers")
            );
        }
    }
}
