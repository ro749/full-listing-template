<?php

namespace Ro749\FullListingTemplate\Commands;

use Illuminate\Console\Command;
use Ro749\ListingUtils\Plans\PlansBase;
use Illuminate\Support\Facades\Schema;
use Ro749\SharedUtils\Readers\MigrationHelper;
class GeneratePersonalMigration extends Command
{
    protected $signature = 'generate:personal-migration';

    protected $description = 'Generates the migration for the personal plans';

    public function handle(): void
    {
        $PlansBase = PlansBase::instance();
        $new_columns = [];
        foreach($PlansBase->form->fields as $key => $field){
            $this->info("trying migration for field $key");
            if(!Schema::hasColumn('personal_plans', $key)){
                if($key[0] == 'p'){
                    $new_columns[$key] = [5,2];
                }
                else{
                    $new_columns[$key] = [12,2];
                }
            }
        }
        $this->info("New columns to add: ".json_encode($new_columns));
        $data = MigrationHelper::generate_migration_for_add_rows('personal_plans', $new_columns);
        MigrationHelper::create_migration_file('add_columns_to_personal_plans', $data);
    }
}