<?php

namespace SoftwareGalaxy\NIDAClient\DTOs;

use SoftwareGalaxy\NIDAClient\Traits\GeneratesRequestIds;

class NIDARequest
{
    use GeneratesRequestIds;

    public NIDARequestBody $body;
    public NIDARequestHeader $headers;

    /**
     * Create NIDARequest instance
     * @return NIDARequest
     */
    public function make()
    {
        return new self();
    }

    /**
     * Set NIDARequest body
     *
     * @param array $body
     * @return NIDARequest
     */
    public function setBody(array $body)
    {
        NIDARequestBody::isValid($body);
        $this->body = new NIDARequestBody(
            payload: $body["payload"]
        );
        return $this;
    }

    /**
     * Set NIDARequest headers
     * @param array $headers
     * @return NIDARequest
     */
    public function setHeaders(array $headers)
    {
        NIDARequestHeader::isValid($headers);
        $this->headers = new NIDARequestHeader(
            id: $headers["id"],
            clientNameOrIp: $headers["client_name_or_ip"],
            timeStamp: $headers["time_stamp"],
            userId: $headers["user_id"]
        );
        return $this;
    }

    /**
     * Generate default headers for current NIDARequest
     *
     * @return void
     */
    public function generateDefaultHeaders()
    {
        $defaultHeaders = [
            "id" => $this->generateId(),
            "client_name_or_ip" => config("nida-client.user_id"),
            "time_stamp" => now(),
            "user_id" => config("nida-client.user_id"),
        ];

        NIDARequestHeader::isValid($defaultHeaders);
        $this->headers = new NIDARequestHeader(
            id: $defaultHeaders["id"],
            clientNameOrIp: $defaultHeaders["client_name_or_ip"],
            timeStamp: $defaultHeaders["time_stamp"],
            userId: $defaultHeaders["user_id"]
        );
    }
}
