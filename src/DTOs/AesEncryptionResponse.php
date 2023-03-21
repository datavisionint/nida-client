<?php

namespace SoftwareGalaxy\NidaClient\DTOs;

use SoftwareGalaxy\NidaClient\Exceptions\NidaMessageSecurityPublicKeyPathIsInvalid;
use SoftwareGalaxy\NidaClient\Traits\EncryptsNidaRequest;

class AesEncryptionResponse
{
    use EncryptsNidaRequest;

    private string|null $messageSecurityPublicKeyPath = null;

    public function __construct(
        public string $key = '',
        public string $iv = '',
        public string $encryptedValue = ''
    ) {
    }

    /**
     * Get the encrypted IV
     *
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
     *
     * @return string
     */
    public function getEncryptedKey()
    {
        return $this->generateRSAES_PKCS1_V1_5Encryption(
            $this->iv,
            $this->messageSecurityPublicKeyPath
        );
    }

    public function setMessageSecurityPublicKeyPath(string $path): self
    {
        $this->messageSecurityPublicKeyPath = $path;

        return $this;
    }

    public function getMessageSecurityPublicKeyPath(): string|null
    {
        return $this->messageSecurityPublicKeyPath;
    }

    public function checkMessageSecurityPublicKeyPath(): void
    {
        throw_if(
            $this->messageSecurityPublicKeyPath == null,
            new NidaMessageSecurityPublicKeyPathIsInvalid('The message security key is not set')
        );

        throw_if(
            !file_exists($this->messageSecurityPublicKeyPath),
            new NidaMessageSecurityPublicKeyPathIsInvalid("The message security at path {$this->messageSecurityPublicKeyPath} is does not exist!")
        );
    }
}
