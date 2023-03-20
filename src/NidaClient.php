<?php

namespace SoftwareGalaxy\NidaClient;
use CodeDredd\Soap\Facades\Soap;

class NidaClient
{
    public function test()
    {
        // $response = Soap::baseWsdl(config("nida-client.base_wsdl"))
        dump("pong", config("nida-client.base_wsdl"));
    }
}
