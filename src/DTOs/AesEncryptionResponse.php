<?php

namespace SoftwareGalaxy\NIDAClient\DTOs;

use SoftwareGalaxy\NIDAClient\Traits\EncryptsNIDARequest;

class AesEncryptionResponse
{
    use EncryptsNIDARequest;

    private $messageSecurityPublicKeyPath = null;

    public function __construct(
        public string $key = "",
        public string $iv = "",
        public string $encryptedValue = ""
    ) {
    }

    /**
     * Get the encrypted IV
     * @return string
     */
    public function getEncryptedIv()
    {
        return $this->generateRSAES_PKCS1_V1_5Encryption(
            $this->iv,
            $this->messageSecurityPublicKeyPath
        );
    }

    /**
     * GEt the encrypted IV
     * @return string
     */
    public function getEncryptedKey()
    {
        return $this->generateRSAES_PKCS1_V1_5Encryption(
            $this->iv,
            $this->messageSecurityPublicKeyPath
        );
    }

    public function setMessageSecurityPublicKeyPath(string $path)
    {
        $this->messageSecurityPublicKeyPath = $path;
        return $this;
    }
}
