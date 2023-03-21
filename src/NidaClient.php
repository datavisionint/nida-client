<?php

namespace SoftwareGalaxy\NIDAClient;

use SoftwareGalaxy\NIDAClient\DTOs\NIDARequest;

class NIDAClient
{
    /**
     * NIDARequest instance
     * @var NIDARequest
     */
    private NIDARequest $nidaRequest;

    /**
     * Instantiate NIDAClient
     *
     * @return NIDAClient
     */
    public function make()
    {
        return new self;
    }

    /**
     * Set the headers
     *
     * @param array $headers
     * @return NIDAClient
     */
    public function setHeaders(array $headers)
    {
        $this->nidaRequest->setHeaders($headers);
        return $this;
    }

    /**
     * Set the body
     *
     * @param array $body
     * @return NIDAClient
     */
    public function setBody(array $body)
    {
        $this->nidaRequest->setBody($body);
        return $this;
    }

    /**
     * Send the request to NIDA
     *
     * @return void
     */
    public function send()
    {
        $nidaRequestManager = new NIDARequestManager($this->nidaRequest);
        $requestContent = $nidaRequestManager->send();
        // return
    }

}
