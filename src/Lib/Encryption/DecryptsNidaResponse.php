<?php

namespace SoftwareGalaxy\NidaClient\Lib\Encryption;

trait DecryptsNidaResponse
{
    /**
     * Verify RSASSA_PKCS1_V1_5
     */
    public function verifyRSASSA_PKCS1_V1_5Signature(
        mixed $signature,
        mixed $payload,
        string|null $rsaPublicKeyPath
    ): array {
        $publicKey = openssl_pkey_get_public(
            file_get_contents($rsaPublicKeyPath ?? '') ?: ''
        ) ?: '';

        // Generate the SHA1 hash of the encrypted payload
        $hash = hash('sha1', $payload);

        // decode the signature using base64 decoding
        $decodedSignature = base64_decode($signature);

        $result = openssl_verify($hash, $decodedSignature, $publicKey, OPENSSL_ALGO_SHA1);

        $response = function ($success, $message) {
            return [
                'success' => $success,
                'message' => $message,
            ];
        };

        return match ($result) {
            1 => $response(true, 'Digital signature is valid'),
            0 => $response(false, 'Digital signature is not valid'),
            default => $response(false, 'An error occurred while verifying the digital signature')
        };
    }

    /**
     * Decrypt RSAES_PKCS1_V1_5
     */
    public function decryptRSAES_PKCS1_V1_5Encryption(
        mixed $encryptedMessage,
        string|null $rsaPrivateKeyPath
    ): string {
        // Load the private key of the stakeholder into a variable
        $privateKey = openssl_pkey_get_private(
            file_get_contents($rsaPrivateKeyPath) ?: ''
        ) ?: '';

        // decode base64 message

        $encryptedMessage = base64_decode($encryptedMessage);

        openssl_private_decrypt(
            $encryptedMessage,
            $decrypted,
            $privateKey,
            OPENSSL_PKCS1_PADDING
        );

        return $decrypted;
    }

    /**
     * Descrypt an aes encryption
     */
    public function decryptAesEncryption(mixed $encryptedPayload, string $iv, string $key): string
    {
        $cipher = config('nida-client.cipher');
        $decryptedMessage = openssl_decrypt(
            $encryptedPayload,
            strtolower($cipher),
            $key,
            0,
            $iv
        ) ?: '';

        return $decryptedMessage;
    }
}
