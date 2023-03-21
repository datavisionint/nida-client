<?php

namespace SoftwareGalaxy\NidaClient\DTOs;

use SoftwareGalaxy\NidaClient\Traits\GeneratesRequestIds;

class NidaRequest
{
    use GeneratesRequestIds;

    public NidaRequestBody $body = null;

    public NidaRequestHeader $headers = null;

    /**
     * Create NidaRequest instance
     *
     * @return NidaRequest
     */
    public function make()
    {
        return new self();
    }

    /**
     * Set NidaRequest body
     *
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
}
