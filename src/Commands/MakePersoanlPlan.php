<?php

namespace Ro749\FullListingTemplate\Commands;
use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;

class MakePersoanlPlan extends Command
{
    protected $signature = 'make:personal_plan';

    protected $description = 'makes the files nesesary for the personal plan';

    public function handle(): int
    {
        if(config('listing.plans.personalized_plan')){
            $this->info('Personal plan already exists');
            return self::SUCCESS;
        }
        $listing = config('listing');
        $listing['plans']['personalized_plan'] = true;
        File::put(config_path('listing.php'), '<?php return ' . array_export($listing) . ';');
        $migrationFile = database_path('migrations') . DIRECTORY_SEPARATOR . 'create_personal_plan_table.php';
        if(!File::exists($migrationFile)){
            File::put($migrationFile, str_replace('%%DATE%%', date('Y_m_d'), file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'PersonalPlanMigration.stub')));
        }

        return self::SUCCESS;
    } 
}