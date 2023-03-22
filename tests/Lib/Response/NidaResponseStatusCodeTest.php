<?php

use SoftwareGalaxy\NidaClient\Lib\Response\NidaResponseStatusCode;

it("has defined status codes", function () {
    expect(NidaResponseStatusCode::STATUS_CODES)->toBeArray();
    expect(NidaResponseStatusCode::STATUS_CODES)->toHaveCount(64);
});

it("can make an instance of itself by response code", function () {
    $code = "001";
    $description = "Stakeholder Account does not exist";
    $statusCode = NidaResponseStatusCode::make($code);
    expect($statusCode)->toBeInstanceOf(NidaResponseStatusCode::class);

    expect($statusCode->code)->toEqual($code);
    expect($statusCode->description)->toEqual($description);
});

it("throws an error when an invalid response code is passed", function(){
    $code = "83838383";
    expect(fn()=>NidaResponseStatusCode::make($code))->toThrow("The status code {$code} passed, is invalid in accordance to NIDA version 3 API");
});
