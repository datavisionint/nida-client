<?php

namespace SoftwareGalaxy\NIDAClient\Commands;

use Illuminate\Console\Command;

class NIDAClientCommand extends Command
{
    public $signature = 'nida-client';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
