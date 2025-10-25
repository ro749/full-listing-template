<?php

namespace Ro749\FullListingTemplate\Commands;

use Illuminate\Console\Command;

class FullListingTemplateCommand extends Command
{
    public $signature = 'full-listing-template';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
