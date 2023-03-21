<?php

namespace SoftwareGalaxy\NIDAClient;

use SoftwareGalaxy\NIDAClient\DTOs\NIDARequest;
use SoftwareGalaxy\NIDAClient\DTOs\NIDARequestBody;
use SoftwareGalaxy\NIDAClient\DTOs\NIDARequestHeader;
use SoftwareGalaxy\NIDAClient\Exceptions\NIDARequestBodyMissingException;
use SoftwareGalaxy\NIDAClient\Traits\EncryptsNIDARequest;
use SoftwareGalaxy\NIDAClient\Traits\VerifiesNIDAConfiguration;
use Spatie\ArrayToXml\ArrayToXml;

class NIDARequestManager
{
    use EncryptsNIDARequest;
    use VerifiesNIDAConfiguration;

    /**
     * The content model to send WSDL data
     */
    private string $contentModel;

    /**
     * NIDARequestManager
     */
    public function __construct(
        private NIDARequest $nidaRequest
    ) {
        $this->verifyNIDAConfiguration();
    }

    /**
     * Send the request to NIDA
     */
    public function send(): mixed
    {
        $this->validateRequest();
        $this->prepareContentModel();

        return null;
    }

    /**
     * Validate the NIDARequest object
     *
     * @return void
     *
     * @throws NIDARequestBodyMissingException
     */
    public function validateRequest()
    {
        if (! ($this->nidaRequest->headers instanceof NIDARequestHeader)) {
            $this->nidaRequest->generateDefaultHeaders();
        }
        throw_unless(
            $this->nidaRequest->body instanceof NIDARequestBody,
            new NIDARequestBodyMissingException('The NIDA request body is missing!')
        );
    }

    /**
     * Prepare the content model
     *
     * @return void
     */
    public function prepareContentModel()
    {
        $encryptedPayload = $this->generateAesEncryption(
            $this->nidaRequest->body->payload
        )->setMessageSecurityPublicKeyPath(
            config('nida-client.nida_message_security_ca_path')
        );

        $payloadSignature = $this->generateRSASSA_PKCS1_V1_5Encryption(
            $encryptedPayload->encryptedValue,
            config('nida-client.stake_holder_certificate_path')
        );

        $root = [
            'rootElementName' => 'soap:Envelope',
            '_attributes' => [
                'xmlns:soap' => 'http://www.w3.org/2003/05/soap-envelope/',
            ],
        ];

        $array = [
            'soap:Header' => [
                'Id' => $this->nidaRequest->headers->id,
                'TimeStamp' => $this->nidaRequest->headers->timeStamp,
                'ClientNameOrIp' => $this->nidaRequest->headers->clientNameOrIp,
                'UserId' => $this->nidaRequest->headers->userId,
            ],
            'soap:Body' => [
                'CryptoInfo' => [
                    'EncryptedCryptoKey' => $encryptedPayload->getEncryptedKey(),
                    'EncryptedCryptoIV' => $encryptedPayload->getEncryptedIv(),
                ],
                'Payload' => $encryptedPayload->encryptedValue,
                'Signature' => $payloadSignature,
            ],
        ];
        $this->contentModel = (new ArrayToXml($array, $root))
            ->dropXmlDeclaration()
            ->toXml();
    }
}
