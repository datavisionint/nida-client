<?php

namespace SoftwareGalaxy\NidaClient\Lib\Request;

use SoftwareGalaxy\NidaClient\Lib\Encryption\AesEncryptionResponse;
use SoftwareGalaxy\NidaClient\Lib\QueryMethods\QueryMethod;
use Spatie\ArrayToXml\ArrayToXml;

class NidaRequest
{
    use GeneratesRequestIds;

    public ?NidaRequestBody $body = null;

    public ?NidaRequestHeader $headers = null;

    public ?QueryMethod $queryMethod = null;

    /**
     * Create NidaRequest instance
     *
     * @return NidaRequest
     */
    public static function make()
    {
        return new self();
    }

    /**
     * Set the query method
     *
     * @return NidaRequest
     */
    public function setMethod(QueryMethod $queryMethod)
    {
        $this->queryMethod = $queryMethod;
        return $this;
    }

    /**
     * Set NidaRequest body
     *
     * @param  array<string, mixed>  $body
     * @return NidaRequest
     */
    public function setBody(array $body)
    {
        NidaRequestBody::isValid($body);
        $this->body = new NidaRequestBody(
            payload: $body['payload']
        );

        return $this;
    }

    /**
     * Set NidaRequest headers
     *
     * @param  array<string, string>  $headers
     * @return NidaRequest
     */
    public function setHeaders(array $headers)
    {
        NidaRequestHeader::isValid($headers);
        $this->headers = new NidaRequestHeader(
            id: $headers['id'],
            clientNameOrIp: $headers['client_name_or_ip'],
            timeStamp: $headers['time_stamp'],
            userId: $headers['user_id']
        );

        return $this;
    }

    /**
     * Generate default headers for current NidaRequest
     *
     * @return void
     */
    public function generateDefaultHeaders()
    {
        $defaultHeaders = [
            'id' => $this->generateId(),
            'client_name_or_ip' => config('nida-client.user_id'),
            'time_stamp' => now(),
            'user_id' => config('nida-client.user_id'),
        ];

        NidaRequestHeader::isValid($defaultHeaders);
        $this->headers = new NidaRequestHeader(
            id: $defaultHeaders['id'],
            clientNameOrIp: $defaultHeaders['client_name_or_ip'],
            timeStamp: $defaultHeaders['time_stamp'],
            userId: $defaultHeaders['user_id']
        );
    }

    /**
     * Prepare full raw request for
     *
     * @param AesEncryptionResponse $encryptedPayload
     * @param string $payloadSignature
     * @return object
     */
    public function prepareRawRequest(AesEncryptionResponse $encryptedPayload, string $payloadSignature): object
    {
        $root = [
            'rootElementName' => 'soap:Envelope',
            '_attributes' => [
                'xmlns:soap' => 'http://www.w3.org/2003/05/soap-envelope/',
            ],
        ];
        $header = [
            'Id' => $this->headers?->id,
            'TimeStamp' => $this->headers?->timeStamp,
            'ClientNameOrIp' => $this->headers?->clientNameOrIp,
            'UserId' => $this->headers?->userId,
        ];
        $body = [
            'CryptoInfo' => [
                'EncryptedCryptoKey' => $encryptedPayload->getEncryptedKey(),
                'EncryptedCryptoIV' => $encryptedPayload->getEncryptedIv(),
            ],
            'Payload' => $encryptedPayload->encryptedValue,
            'Signature' => $payloadSignature,
        ];

        $fullRequest = [
            'soap:Header' => $header,
            'soap:Body' => $body,
        ];

        $xml = (new ArrayToXml($fullRequest, $root))
            ->dropXmlDeclaration()
            ->toXml();

        return (object)[
            "root" => $root,
            "header" => $header,
            "body" => $body,
            "full_request" => $fullRequest,
            "xml" => $xml
        ];
    }
}
