<?php

namespace SoftwareGalaxy\NidaClient;

use SoftwareGalaxy\NidaClient\Lib\QueryMethods\QueryMethod;
use SoftwareGalaxy\NidaClient\Lib\Request\NidaRequest;

class NidaClient
{
    /**
     * NidaRequest instance
     */
    private ?NidaRequest $nidaRequest;

    public function __construct()
    {
        $this->nidaRequest = new NidaRequest();
    }

    /**
     * Instantiate NidaClient
     *
     * @return NidaClient
     */
    public function make()
    {
        return new self;
    }

    /**
     * Set the headers
     *
     * @param  array<string,string>  $headers
     * @return NidaClient
     */
    public function setHeaders(array $headers)
    {
        $this->nidaRequest->setHeaders($headers);

        return $this;
    }

    /**
     * Set the body
     *
     * @param  array<string, mixed>  $body
     * @return NidaClient
     */
    public function setBody(array $body)
    {
        $this->nidaRequest->setBody($body);

        return $this;
    }

    /**
     * Set method
     *
     * @return NidaClient
     */
    public function setMethod(QueryMethod $queryMethod)
    {
        $this->nidaRequest->setMethod($queryMethod);
        return $this;
    }

    /**
     * Send the request to Nida
     *
     * @return void
     */
    public function send()
    {
        $nidaRequestManager = new NidaRequestManager($this->nidaRequest);
        $requestContent = $nidaRequestManager->send();
        // return
    }
}
