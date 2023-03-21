<?php

namespace SoftwareGalaxy\NidaClient\DTOs;
use Spatie\ArrayToXml\ArrayToXml;

/**
 * Summary of NIDARequestBodyPayload
 */
class NIDARequestBodyPayload
{
    /**
     * Summary of make
     *
     * @return $this
     */
    public static function make(array $data){

        $root = [
            'rootElementName' => 'Payload'
        ];
        $arrayToXml = new ArrayToXml($data, $root);

        $result = $arrayToXml->dropXmlDeclaration()->toXml();
        dump($result);
        return new self;
    }
}
