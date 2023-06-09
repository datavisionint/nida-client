<?php

namespace SoftwareGalaxy\NidaClient\Lib\Encryption;

trait EncryptsNidaRequest
{
    /**
     * Generate aes encryption
     */
    public function generateAesEncryption(mixed $message): AesEncryptionResponse
    {
        $message = is_array($message) ? serialize($message) : $message;
        $cipher = config('nida-client.cipher');
        $key = random_bytes(config('nida-client.key_size'));
        $iv = random_bytes(
            max(1, openssl_cipher_iv_length(strtolower($cipher)) ?:
                32)
        );

        $value = openssl_encrypt(
            $message,
            strtolower($cipher),
            $key,
            0,
            $iv,
            $tag
        ) ?: '';

        return new AesEncryptionResponse(
            key: $key,
            iv: $iv,
            encryptedValue: $value
        );
    }

    /**
     * Generate RSAES_PKCS1_V1_5 Encryption
     */
    public function generateRSAES_PKCS1_V1_5Encryption(mixed $message, string|null $rsaPublicKeyPath): string
    {
        if (is_array($message)) {
            $message = serialize($message);
        }

        $publicKey = openssl_pkey_get_public(
            file_get_contents($rsaPublicKeyPath ?? '') ?: ''
        ) ?: '';

        openssl_public_encrypt(
            $message,
            $encrypted,
            $publicKey,
            OPENSSL_PKCS1_PADDING
        );
        $encrypted = base64_encode($encrypted);

        return $encrypted;
    }

    /**
     * Generate RSASSA_PKCS1_V1_5 Encryption
     */
    public function generateRSASSA_PKCS1_V1_5Encryption(mixed $payload, string $rsaPrivateKeyPath): string
    {
        if (is_array($payload)) {
            $payload = serialize($payload);
        }

        // Load the private key of the stakeholder into a variable
        $privateKey = openssl_pkey_get_private(
            file_get_contents($rsaPrivateKeyPath) ?: ''
        ) ?: '';

        // Generate the SHA1 hash of the encrypted payload
        $hash = hash('sha1', $payload);

        // Sign the hash using the private key and RSASSA-PKCS1-V1_5 signature scheme
        openssl_sign($hash, $signature, $privateKey, OPENSSL_ALGO_SHA1);

        // Encode the signature using base64 encoding
        $encodedSignature = base64_encode($signature);

        return $encodedSignature;
    }
}
