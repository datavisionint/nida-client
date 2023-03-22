<?php

namespace SoftwareGalaxy\NidaClient\Tests\Lib\Encryption;

use SoftwareGalaxy\NidaClient\Lib\Encryption\DecryptsNidaResponse;
use SoftwareGalaxy\NidaClient\Lib\Encryption\EncryptsNidaRequest;

beforeEach(function () {
    $this->testPublicKeyPath = __DIR__ . "/test_keys/test.crt";
    $this->testPrivateKeyPath = __DIR__ . "/test_keys/test.key";
    $this->testCsrPath = __DIR__ . "/test_keys/test.csr";

    $this->decryptNidaRequest = new class
    {
        use DecryptsNidaResponse;
    };
    $this->encryptNidaRequest = new class
    {
        use EncryptsNidaRequest;
    };
});

it("verifies RSASSA_PKCS1_V1_5 signature", function () {
    $payload = "hello";
    // create a signature
    $signature = $this->encryptNidaRequest->generateRSASSA_PKCS1_V1_5Encryption($payload, $this->testPrivateKeyPath);

    // verify a signature
    $response = $this->decryptNidaRequest->verifyRSASSA_PKCS1_V1_5Signature($signature, $payload, $this->testPublicKeyPath);

    expect($response)->toBeArray();
    expect($response)->toHaveKeys(["success", "message"]);
    expect($response["success"])->toBeTrue();
    expect($response["message"])->toEqual('Digital signature is valid');

    // verify a signature that is wrong
    $signature = "not real";
    $response = $this->decryptNidaRequest->verifyRSASSA_PKCS1_V1_5Signature($signature, $payload, $this->testPublicKeyPath);

    expect($response)->toBeArray();
    expect($response)->toHaveKeys(["success", "message"]);
    expect($response["success"])->toBeFalse();
    expect($response["message"])->toEqual('Digital signature is not valid');
});

it("decrypts RSAES_PKCS1_V1_5 encryption", function () {

    $payload = "hello";

    // encrypt payload
    $encryptedPayload = $this->encryptNidaRequest->generateRSAES_PKCS1_V1_5Encryption($payload, $this->testPublicKeyPath);

    // decrypt the payload
    $decryptedPayload = $this->decryptNidaRequest->decryptRSAES_PKCS1_V1_5Encryption($encryptedPayload, $this->testPrivateKeyPath);

    expect($decryptedPayload)->toBeString();
    expect($decryptedPayload)->toEqual($payload);
});

it("decrypts AES encryption", function () {

    $payload = "hello";

    // encrypt payload
    $encryptedPayload = $this->encryptNidaRequest->generateAesEncryption($payload);
    $encryptedPayload->setMessageSecurityPublicKeyPath($this->testPublicKeyPath);
    $encryptedIv = $encryptedPayload->getEncryptedIv();
    $encryptedKey = $encryptedPayload->getEncryptedKey();
    $encryptedValue = $encryptedPayload->encryptedValue;

    // decrypt the keys
    $decryptedIv = $this->decryptNidaRequest->decryptRSAES_PKCS1_V1_5Encryption(
        $encryptedIv,
        $this->testPrivateKeyPath
    );
    $decryptedKey = $this->decryptNidaRequest->decryptRSAES_PKCS1_V1_5Encryption(
        $encryptedKey,
        $this->testPrivateKeyPath
    );

    expect($decryptedIv)->toEqual($encryptedPayload->iv);
    expect($decryptedKey)->toEqual($encryptedPayload->key);

    $decryptedPayload = $this->decryptNidaRequest->decryptAesEncryption(
        $encryptedValue,
        $decryptedIv,
        $decryptedKey
    );

    expect($decryptedPayload)->toBeString();
    expect($decryptedPayload)->toEqual($payload);
});
