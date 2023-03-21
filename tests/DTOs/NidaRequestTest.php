<?php

use SoftwareGalaxy\NidaClient\DTOs\NidaRequest;
use SoftwareGalaxy\NidaClient\DTOs\NidaRequestBody;
use SoftwareGalaxy\NidaClient\DTOs\NidaRequestHeader;

beforeEach(function () {
    $this->NidaRequest = new NidaRequest;
});

it("creates an instance of itself when using make", function () {
    $nidaRequest = NidaRequest::make();

    expect($nidaRequest)->toBeInstanceOf(NidaRequest::class);
});

// set body tests
it("throws error when the body doesn't have all required properties", function () {
    expect(fn () => $this->NidaRequest->setBody([]))->toThrow("payload is not defined in the body");
});

it("returns instance of nida request after setting body", function () {
    $body = [
        "payload" => [
            "NIN" => "23223321-1212"
        ]
    ];
    expect($this->NidaRequest->setBody($body))->toBeInstanceOf(NidaRequest::class);
});

it("has an instance of Nida request body", function () {
    $body = [
        "payload" => [
            "NIN" => "23223321-1212"
        ]
    ];
    expect($this->NidaRequest->setBody($body)->body)->toBeInstanceOf(NidaRequestBody::class);
});

it("has a payload property as an array inside the NidaRequestBody property", function () {
    $body = [
        "payload" => [
            "NIN" => "23223321-1212"
        ]
    ];
    expect($this->NidaRequest->setBody($body)->body->payload)->toEqual([
        "NIN" => "23223321-1212"
    ]);
});

// set header
it("throws error when the header doesn't have all required properties", function () {
    expect(fn () => $this->NidaRequest->setHeaders([]))->toThrow("id is not defined in the headers");
    expect(fn () => $this->NidaRequest->setHeaders([]))->toThrow("id is not defined in the headers");
    expect(fn () => $this->NidaRequest->setHeaders([
        "id" => 12,
    ]))->toThrow("time_stamp is not defined in the headers");
    expect(fn () => $this->NidaRequest->setHeaders([
        "id" => 12,
        "time_stamp" => "123K123J123"
    ]))->toThrow("client_name_or_ip is not defined in the headers");
    expect(fn () => $this->NidaRequest->setHeaders([
        "id" => 12,
        "time_stamp" => "123K123J123",
        "client_name_or_ip" => "KOPAFASTA"
    ]))->toThrow("user_id is not defined in the headers");
});

it("returns instance of nida request after setting headers", function () {
    $headers = [
        "id" => 12,
        "time_stamp" => "123K123J123",
        "client_name_or_ip" => "KOPAFASTA",
        "user_id" => "koapfast"
    ];
    expect($this->NidaRequest->setHeaders($headers))->toBeInstanceOf(NidaRequest::class);
});

it("has an instance of Nida request headers", function () {
    $headers = [
        "id" => 12,
        "time_stamp" => "123K123J123",
        "client_name_or_ip" => "KOPAFASTA",
        "user_id" => "koapfast"
    ];
    expect($this->NidaRequest->setHeaders($headers)->headers)->toBeInstanceOf(NidaRequestHeader::class);
});

it("has a payload property as an array inside the NidaRequestHeader property", function () {
    $headers = [
        "id" => 12,
        "time_stamp" => "123K123J123",
        "client_name_or_ip" => "KOPAFASTA",
        "user_id" => "koapfast"
    ];
    expect($this->NidaRequest->setHeaders($headers)->headers->id)->toEqual(12);
    expect($this->NidaRequest->setHeaders($headers)->headers->timeStamp)->toEqual("123K123J123");
    expect($this->NidaRequest->setHeaders($headers)->headers->clientNameOrIp)->toEqual("KOPAFASTA");
    expect($this->NidaRequest->setHeaders($headers)->headers->userId)->toEqual("koapfast");
});

// create default headers
it("adds headers to a NidaRequest", function(){
    $nidaRequest = NidaRequest::make();
    expect($nidaRequest->headers)->toBe(null);
    config()->set("nida-client.user_id", "KOPAFASTA");
    $nidaRequest->generateDefaultHeaders();
    expect($nidaRequest->headers)->toBeInstanceOf(NidaRequestHeader::class);
});
