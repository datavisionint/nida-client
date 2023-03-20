<?php

namespace SoftwareGalaxy\NidaClient;

class NidaClient
{
    public function test()
    {
        dump("pong", config("nida-client.base_wsdl"));
    }
}
