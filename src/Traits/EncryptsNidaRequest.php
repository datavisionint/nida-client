<?php

namespace SoftwareGalaxy\NidaClient\Traits;

use SoftwareGalaxy\NidaClient\DTOs\AesEncryptionResponse;

trait EncryptsNidaRequest
{
    /**
     * Generate aes encryption
     */
    private function generateAesEncryption(mixed $message): AesEncryptionResponse
    {
        $message = is_string($message) ?: serialize($message);
        $cipher = config('nida-client.cipher');
        $key = random_bytes(config('nida-client.key_size'));
        $iv = random_bytes(openssl_cipher_iv_length(strtolower($cipher)));

        $value = \openssl_encrypt(
            $message,
            strtolower($cipher),
            $key,
            0,
            $iv,
            $tag
        );

        return new AesEncryptionResponse(
            key: $key,
            iv: $iv,
            encryptedValue: $value
        );
    }

    /**
     * Generate RSAES_PKCS1_V1_5 Encryption
     */
    private function generateRSAES_PKCS1_V1_5Encryption(mixed $message, string $rsaKeyPath): string
    {
        if (is_array($message)) {
            $message = serialize($message);
        }

        $publicKey = openssl_pkey_get_public(
            file_get_contents(
                "/" . base_path($rsaKeyPath), true
            )
        );
        openssl_public_encrypt($message, $encrypted, $publicKey, OPENSSL_PKCS1_PADDING);
        $encrypted = base64_encode($encrypted);

        return $encrypted;
    }

    /**
     * Generate RSASSA_PKCS1_V1_5 Encryption
     */
    private function generateRSASSA_PKCS1_V1_5Encryption(mixed $payload, string $rsaKeyPath): string
    {
        if (is_array($payload)) {
            $payload = serialize($payload);
        }

        // Load the private key of the stakeholder into a variable
        $privateKey = openssl_pkey_get_private($rsaKeyPath);

        // Generate the SHA1 hash of the encrypted payload
        $hash = hash('sha1', $payload);

        // Sign the hash using the private key and RSASSA-PKCS1-V1_5 signature scheme
        openssl_sign($hash, $signature, $privateKey, OPENSSL_ALGO_SHA1);

        // Encode the signature using base64 encoding
        $encodedSignature = base64_encode($signature);

        // // The encoded signature can now be appended to the encrypted payload and sent to the recipient
        // $signedPayload = $payload . '.' . $encodedSignature;
        return $encodedSignature;
    }
}
