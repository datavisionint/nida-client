<?php

namespace SoftwareGalaxy\NidaClient\Lib\Response;

class NidaResponse
{
    public ?NidaResponseHeader $header = null;

    public ?NidaResponseBody $body = null;

    public ?NidaResponseStatus $status = null;

    /**
     * Makke a NidaResponse from a mixed response
     */
    public static function make(mixed $nidaResponse): self
    {
        return new self;
    }
}
