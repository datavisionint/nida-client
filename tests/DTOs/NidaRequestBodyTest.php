<?php

use SoftwareGalaxy\NidaClient\DTOs\NidaRequestBody;

it('validates the passed body to check if all required properties are available', function () {
    expect(fn () => NidaRequestBody::isValid([]))->toThrow('payload is not defined in the body');
});
