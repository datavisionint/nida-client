<?php

namespace SoftwareGalaxy\NidaClient;

class NIDARequest
{
    public function __construct(
        private array $data
    ) {}

    public static function make(array $data): self
    {
        return new self($data);
    }

    public function prepare()
    {
        // 1. Construct CIG Web Service request payload as per the respective web service
        // method.
        $payload = $this->data;

        // 2. Encrypt the request payload using Rijndael (AES-256) algorithm.
        // Note: AES crypto parameter (i.e. Key and Initial Vector (IV)) shall be randomly
        // generated on each encryption operation.
        // 3. Encrypt AES crypto parameter with Message Security Public Key using
        // RSAES-PKCS1-V1_5 encryption scheme.
        // 4. Digitally sign the encrypted payload with Stakeholder Private Key using
        // RSASSA-PKCS1-V1_5 signature scheme and SHA1 cryptographic hash function.
        // Note: Refer to PKCS #1 v2.1: RSA Cryptography Standard specification for
        // PKCS1-v1.5 Signature and Encryption scheme.

    }
}
