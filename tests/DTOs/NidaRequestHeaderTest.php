<?php

use SoftwareGalaxy\NidaClient\DTOs\NidaRequestHeader;

it("validates and throws error when the header doesn't have all required properties", function () {
    expect(fn () => NidaRequestHeader::isValid([]))->toThrow("id is not defined in the headers");
    expect(fn () => NidaRequestHeader::isValid([]))->toThrow("id is not defined in the headers");
    expect(fn () => NidaRequestHeader::isValid([
        "id" => 12,
    ]))->toThrow("time_stamp is not defined in the headers");
    expect(fn () => NidaRequestHeader::isValid([
        "id" => 12,
        "time_stamp" => "123K123J123"
    ]))->toThrow("client_name_or_ip is not defined in the headers");
    expect(fn () => NidaRequestHeader::isValid([
        "id" => 12,
        "time_stamp" => "123K123J123",
        "client_name_or_ip" => "KOPAFASTA"
    ]))->toThrow("user_id is not defined in the headers");
});
