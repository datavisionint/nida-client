<?php

namespace SoftwareGalaxy\NidaClient\DTOs;

class NIDARequest
{
    public NIDARequestBody $body;
    public NIDARequestHeader $headers;

    public function make()
    {
        return new self();
    }

    public function setBody(array $body)
    {
        NIDARequestBody::isValid($body);
        $payload = NIDARequestBodyPayload::make($body["payload"]);
        $this->body = new NIDARequestBody(
            cryptoInfo: $body["crypto_info"],
            signature: $body["signature"],
            payload: $payload
        );
        return $this;
    }

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

    public function validate()
    {

    }
}
