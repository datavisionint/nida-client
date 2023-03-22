<?php

namespace SoftwareGalaxy\NidaClient\Tests\Lib\Encryption;

use SoftwareGalaxy\NidaClient\Lib\Encryption\AesEncryptionResponse;
use SoftwareGalaxy\NidaClient\Lib\Encryption\EncryptsNidaRequest;

beforeEach(function () {
    $this->testPublicKeyPath = __DIR__.'/test_keys/test.crt';
    $this->testPrivateKeyPath = __DIR__.'/test_keys/test.key';
    $this->testCsrPath = __DIR__.'/test_keys/test.csr';

    $this->encryptNidaRequest = new class
    {
        use EncryptsNidaRequest;
    };
});

it('generates the aes encryption for message', function () {
    $encryptedMessage = $this->encryptNidaRequest->generateAesEncryption('hello');
    expect($encryptedMessage)->toBeInstanceOf(AesEncryptionResponse::class);
    expect($encryptedMessage->iv)->toBeString();
    expect($encryptedMessage->key)->toBeString();
    expect(mb_strlen($encryptedMessage->iv, '8bit'))->toEqual(
        max(
            1,
            openssl_cipher_iv_length(
                strtolower(
                    config('nida-client.cipher')
                )
            )
        )
    );
    expect(mb_strlen($encryptedMessage->key, '8bit'))->toEqual(config('nida-client.key_size'));
    expect($encryptedMessage->encryptedValue)->toBeString();
});

it('generates the RSAES_PKCS1_V1_5 encryption', function () {
    $encryptedMessage = $this->encryptNidaRequest->generateRSAES_PKCS1_V1_5Encryption('hello', $this->testPublicKeyPath);
    expect($encryptedMessage)->toBeString();
});

it('generates the RSASSA_PKCS1_V1_5 encryption', function () {
    $encryptedMessage = $this->encryptNidaRequest->generateRSASSA_PKCS1_V1_5Encryption('hello', $this->testPrivateKeyPath);
    expect($encryptedMessage)->toBeString();
});
