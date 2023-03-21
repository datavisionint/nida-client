<?php

namespace SoftwareGalaxy\NidaClient\Commands;

use Illuminate\Console\Command;

class NidaClientCommand extends Command
{
    public $signature = 'nida-client';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
