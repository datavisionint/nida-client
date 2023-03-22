<?php

namespace SoftwareGalaxy\NidaClient;

use SoftwareGalaxy\NidaClient\Exceptions\NidaRequestBodyMissingException;
use SoftwareGalaxy\NidaClient\Lib\Configuration\VerifiesNidaConfiguration;
use SoftwareGalaxy\NidaClient\Lib\Encryption\EncryptsNidaRequest;
use SoftwareGalaxy\NidaClient\Lib\Request\NidaRequest;
use SoftwareGalaxy\NidaClient\Lib\Request\NidaRequestBody;
use SoftwareGalaxy\NidaClient\Lib\Request\NidaRequestHeader;
use Spatie\ArrayToXml\ArrayToXml;

class NidaRequestManager
{
    use EncryptsNidaRequest;
    use VerifiesNidaConfiguration;

    /**
     * The content model to send WSDL data
     */
    private string $contentModel;

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
        $this->prepareContentModel();

        return null;
    }

    /**
     * Validate the NidaRequest object
     *
     * @return void
     *
     * @throws NidaRequestBodyMissingException
     */
    public function validateRequest()
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
     * @return void
     */
    public function prepareContentModel()
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

        $root = [
            'rootElementName' => 'soap:Envelope',
            '_attributes' => [
                'xmlns:soap' => 'http://www.w3.org/2003/05/soap-envelope/',
            ],
        ];

        $array = [
            'soap:Header' => [
                'Id' => $this->nidaRequest->headers?->id,
                'TimeStamp' => $this->nidaRequest->headers?->timeStamp,
                'ClientNameOrIp' => $this->nidaRequest->headers?->clientNameOrIp,
                'UserId' => $this->nidaRequest->headers?->userId,
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

        dump('Content model: ' . $this->contentModel);
    }
}
