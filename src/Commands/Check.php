<?php

namespace Ro749\FullListingTemplate\Commands;

use Illuminate\Console\Command;

class Check extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:listing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if this project is ready to uplad, and autofixes what it can';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        if (!file_exists(app_path('Mail/CotizationMail.php'))) {
            $this->error('Falta el correo.');
            return self::FAILURE;
        }

        $this->call('check');
        return self::SUCCESS;
    }
}
