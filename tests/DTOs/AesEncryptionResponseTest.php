<?php

use SoftwareGalaxy\NidaClient\DTOs\AesEncryptionResponse;

it("allows object instantiation without parameters", fn()=> expect(new AesEncryptionResponse())->toBeInstanceOf(AesEncryptionResponse::class));

it("sets the message security public key path", function () {
    $aesEncryptionResponse = new AesEncryptionResponse();
    $aesEncryptionResponse->setMessageSecurityPublicKeyPath("/some/test/path");

    expect($aesEncryptionResponse->getMessageSecurityPublicKeyPath())->toBe("/some/test/path");
});

it("throws an error if the message security key is not set or the set path does not exist", function () {
    $aesEncryptionResponse = new AesEncryptionResponse();
    expect(fn()=>$aesEncryptionResponse->checkMessageSecurityPublicKeyPath())->toThrow("The message security key is not set");

    $aesEncryptionResponse->setMessageSecurityPublicKeyPath("/some/test/path");

    expect(fn()=>$aesEncryptionResponse->checkMessageSecurityPublicKeyPath())->toThrow("The message security at path /some/test/path is does not exist!");
});
