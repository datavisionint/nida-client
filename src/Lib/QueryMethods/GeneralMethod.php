<?php

namespace SoftwareGalaxy\NidaClient\Lib\QueryMethods;

use SoapClient;

abstract class GeneralMethod implements QueryMethod
{

    protected string|null $component = null;

    protected mixed $soapClient;

    /**
     * Options
     *
     * @var array<string, string>
     */
    protected array $options = [];

    /**
     * Send query data
     *
     * @param array $data
     */
    public function send(array $data): mixed
    {
        $data["Component"] = $this->component;
        $response = $this->soapClient->__soapCall($this->component, $data);
        return $response;
    }

    protected function initializeClient()
    {
        $this->soapClient = new SoapClient(
            config("nida-client.nida_base_wsdl_path"),
            $this->options
        );
    }

    public function __construct()
    {
        $this->initializeClient();
    }
}
