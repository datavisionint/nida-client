<?php

namespace SoftwareGalaxy\NidaClient;

use SoftwareGalaxy\NidaClient\Exceptions\NidaRequestBodyMissingException;
use SoftwareGalaxy\NidaClient\Lib\Configuration\VerifiesNidaConfiguration;
use SoftwareGalaxy\NidaClient\Lib\Encryption\EncryptsNidaRequest;
use SoftwareGalaxy\NidaClient\Lib\Request\NidaRequest;
use SoftwareGalaxy\NidaClient\Lib\Request\NidaRequestBody;
use SoftwareGalaxy\NidaClient\Lib\Request\NidaRequestHeader;

class NidaRequestManager
{
    use EncryptsNidaRequest;
    use VerifiesNidaConfiguration;

    /**
     * NidaRequestManager
     */
    public function __construct(
        private NidaRequest $nidaRequest
    ) {
        $this->verifyNidaConfiguration();
    }

    /**
     * Send the request to Nida
     */
    public function send(): mixed
    {
        $this->validateRequest();
        $fullRequest = $this->getFullRequest();
        $response = $this->nidaRequest->queryMethod->send([
            "Header" => $fullRequest->header,
            "Body" => $fullRequest->body
        ]);

        return null;
    }

    /**
     * Validate the NidaRequest object
     *
     * @return void
     *
     * @throws NidaRequestBodyMissingException
     */
    private function validateRequest()
    {
        if (!($this->nidaRequest->headers instanceof NidaRequestHeader)) {
            $this->nidaRequest->generateDefaultHeaders();
        }
        throw_unless(
            $this->nidaRequest->body instanceof NidaRequestBody,
            new NidaRequestBodyMissingException('The Nida request body is missing!')
        );
    }

    /**
     * Prepare the content model
     *
     * @return object
     */
    public function getFullRequest(): object
    {
        $encryptedPayload = $this->generateAesEncryption(
            $this->nidaRequest->body?->payload
        )->setMessageSecurityPublicKeyPath(
            base_path(config('nida-client.nida_message_security_ca_path'))
        );

        $payloadSignature = $this->generateRSASSA_PKCS1_V1_5Encryption(
            $encryptedPayload->encryptedValue,
            base_path(config('nida-client.nida_stakeholder_certificate_path'))
        );

        return $this->nidaRequest->prepareRawRequest(
            $encryptedPayload,
            $payloadSignature
        );
    }
}
