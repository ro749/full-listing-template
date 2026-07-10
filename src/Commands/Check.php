<?php

namespace Ro749\FullListingTemplate\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
Use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use Ro749\FullListingTemplate\Models\Asesor;
use Ro749\FullListingTemplate\Models\Client;
use Ro749\FullListingTemplate\Models\Quotation;
use Ro749\FullListingTemplate\Models\Unit;
use Ro749\ListingUtils\Plans\PlansBase;


class Check extends Command
{
    protected $signature = 'check:listing';
    protected $description = 'Check if this project is ready to upload, and autofixes what it can';

    protected $table_forms = [];

    public function handle(): int
    {
        $this->info('Checking if the project is ready to upload...');
        Artisan::call('migrate:fresh', ['--force' => true]);
        File::put(storage_path('logs/laravel.log'), '');
        if (!file_exists(app_path('Mail/CotizationMail.php'))) {
            $this->error('Falta el correo.');
            $this->error('A fatal error encountered, please fix it before uploading.');
            return self::FAILURE;
        }
        $this->info('checking');
        $this->call('check');
        $this->set_configs();
        $this->seed();

        $errorCount = 0;
        $this->check_controllers($errorCount);
        
        $this->check_which_forms($errorCount);
        $this->check_forms($errorCount);
        $this->check_table_forms($errorCount);
        $this->check_tables($errorCount);
        
        $this->check_db($errorCount);
        $this->check_listing_utils($errorCount);

        $logPath = storage_path('logs/laravel.log');

        if (!(!file_exists($logPath) || filesize($logPath) === 0)) {
            $this->error('The log file is not empty.');  
            $errorCount += 1;
             
        }

        if ($errorCount > 0) {
            $this->error($errorCount . ' error(s) found, please fix them before uploading.');
            return self::FAILURE;
        } else {
            $this->info('No errors found, your project is ready to upload!');
            //$this->check_in_browser();
            return self::SUCCESS;
        }
    }
    public static function set_configs(){
        $packageConfig = require base_path('vendor/ro749/full-listing-template/config/full-listing-template.php');
        $packageConfig = $packageConfig['overrides'];
        $config = require config_path('overrides.php');
        
        Config::set('overrides', static::mergeConfigs($packageConfig, $config));
        $packageConfig = require base_path('vendor/ro749/listing-utils/config/listing-utils.php');
        $packageConfig = $packageConfig['overrides'];
        $config = config('overrides');
        Config::set('overrides', static::mergeConfigs($packageConfig, $config));
    }
    public static function seed(){
        DB::table('users')->insert(['name' => 'admin', 'email' => 'admin@example.com', 'password' => Hash::make('admin'), ]);
        if(Asesor::instance()->count() == 0){
            $asesor_id = Asesor::instance()->create(Asesor::instance()->get_default_model())->id;
        }
        else{
            $asesor_id = Asesor::instance()->first()->id;
        }
        Auth::guard('asesor')->loginUsingId($asesor_id);
        if(Client::instance()->count() == 0){
            Client::instance()->create(Client::instance()->get_default_model());
        }
        else{
            $client_id = Client::instance()->first()->id;
        }
        if(Quotation::instance()->count() == 0){
            Quotation::instance()->create(Quotation::instance()->get_default_model());
        }
    }

    protected static function mergeConfigs(array $package, array $project): array
    {
        foreach ($project as $key => $value) {
            $package[$key] = (is_array($value) && isset($package[$key]) && is_array($package[$key]))
                ? static::mergeConfigs($package[$key], $value)
                : $value;
        }
        return $package;
    }

    function check_controllers(int& $errorCount){
        $controllers = config('overrides.controllers');
        $ans = true;
        foreach($controllers as $controller){
            $control = $controller::instance();
            $reflection = new \ReflectionClass($control);
            foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                if ($method->isConstructor() || str_contains($method->getName(), 'get_default_args')) {
                    continue;
                }
                $methodName = $method->getName();
                $this->info('check controller '.$controller.' method '.$methodName);
                try{
                    $args = $control->get_default_args($methodName);
                    $view = $method->invokeArgs($control, $args);
                    if($view != null && $view::class == 'Illuminate\View\View'){
                        $view = $view->render();
                    }
                    if(is_string($view)){
                        if (str_contains($view, 'Exception')) {
                            $this->error('error in '.$controller.' method '.$methodName);
                            $this->error('Exception found in view');
                            $errorCount += 1;
                            $ans = false;
                        }
                        
                        else if (str_contains($view, '<x-')) {
                            $this->error('error in '.$controller.' method '.$methodName);
                            $this->error('Unrendered component found in view');
                            $errorCount += 1;
                            $ans = false;
                        }
                        else if (!str_contains($view, 'X-App-Version')) {
                            $this->error('error in '.$controller.' method '.$methodName);
                            $this->error('X-App-Version not found in view, this means the view was not rendered');
                            $this->error('this view is not using x-layout, make sure to extend x-layout in all your views');
                            $errorCount += 1;
                            $ans = false;
                        }
                        else if (str_contains($view, 'console.log')) {
                            $this->error('error in '.$controller.' method '.$methodName);
                            $this->error('console.log found in view, remove all console logs before uploading');
                            $errorCount += 1;
                            $ans = false;
                        }
                        else if (str_contains($view, 'smartTable()')) {
                            $this->error('error in '.$controller.' method '.$methodName);
                            $this->error('a smart table is empty');
                            $errorCount += 1;
                            $ans = false;
                        }
                        //checks all urls
                        //$pattern = '/url\s*:\s*[\'"`]([^\'"`]+)[\'"`]/';
                        $static_pattern = '/url\s*:\s*[\'"`]([^\'"`]+)[\'"`](?!\s*\+)/';
                        preg_match_all($static_pattern, $view, $matches);

                        foreach($matches[1] as $url){
                            if(!$this->isValidProjectUrl($url)){
                                $this->error('error in '.$controller.' method '.$methodName);
                                $this->error('Invalid URL found: '.$url);
                                $errorCount += 1;
                                $ans = false;
                            }
                        }

                        $dynamic_pattern = '/url\s*:\s*[\'"`]\s*\+\s*([^\'"`\s]+)\s*\+\s*[\'"`]/';
                        preg_match_all($dynamic_pattern, $view, $matches);

                        foreach($matches[1] as $url){
                            if(!$this->isValidProjectUrl($url.'1')){
                                $this->error('error in '.$controller.' method '.$methodName);
                                $this->error('Invalid URL found: '.$url);
                                $errorCount += 1;
                                $ans = false;
                            }
                        }

                    }
                }
                catch(\Throwable $e){
                    $this->error('error in '.$controller.' method '.$methodName);
                    $this->error($e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
                    $this->error($e->getTraceAsString());
                    $errorCount += 1;
                    $ans = false;
                }
            }
        }
        return $ans;
    }

    public function check_which_forms(int& $errorCount){
        $tables = config('overrides.tables');
        foreach($tables as $table){
            $t = $table::instance();
            if($t->form != null){
                $this->table_forms[get_class($t->form)] = $table;
            }
        }
    }

    public function check_tables(int& $errorCount){
        $tables = config('overrides.tables');
        $ans = true;
        foreach($tables as $table){
            try{
                $this->info('check table '.$table);
                $t = $table::instance();
                $args = $t->get_default_args();
                call_user_func_array([$t, 'get'], $args);
                $t->get_selectors();
                if($t->delete != null){
                    $id = ($t->getter->model_class)::instance()->value('id');
                    $t->delete($id);
                }
            }catch(\Throwable $e){
                $this->error('error in '.$table);
                $this->error($e->getMessage());
                $this->error($e->getTraceAsString());
                $errorCount += 1;
                $ans = false;
            }
        }
        return $ans;
    }

    function check_forms(int& $errorCount){
        Storage::fake('public');
        $forms = config('overrides.forms');
        $ans = true;
        foreach($forms as $key => $form){
            if($key == 'AdminLogin') continue;
            if(!empty($this->table_forms) && array_key_exists($form, $this->table_forms)){
                continue;
            }
            try{
                $this->info('check form '.$form);
                $f = $form::instanciate();
                $args = $f->get_default_args();
                if($form == 'App\Forms\Contact'){
                    $this->info(json_encode($args));
                }
                call_user_func_array([$f, 'prosses'], $args);
                
            }catch(\Throwable $e){
                $this->error('error in '.$form);
                $this->error($e->getMessage());
                $this->error($e->getTraceAsString());
                $errorCount += 1;
                $ans = false;
            }
        }
        
        return $ans;
    }

    public function check_table_forms(int& $errorCount){
        $ans = true;
        foreach($this->table_forms as $form => $table){
            try{
                $this->info('check table form '.$form);
                $t = $table::instance();
                $args = $t->form->get_default_args();
                call_user_func_array([$t, 'save'], $args);
            }catch(\Throwable $e){
                $this->error('error in '.$form);
                $this->error($e->getMessage());
                $this->error($e->getTraceAsString());
                $errorCount += 1;
                $ans = false;
            }
        }
        return $ans;
    }

    function check_img_map_pro(int& $errorCount){
        $impClass = config('overrides.image_map_pro');

        if($impClass != null){

        }
        else {
            $this->info('No image map pro class found, skipping check');
        }
        return true;
    }

    function check_listing_utils(int& $errorCount){
        return $this->check_personal_plan_quotation($errorCount);
    }

    function check_personal_plan_quotation(int& $errorCount){
        $PlansBase = PlansBase::instance();
        foreach($PlansBase->form->fields as $key => $field){
            if(!Schema::hasColumn('personal_plans', $key)){
                $this->error('error in personalized quotations, execute "php artisan generate:personal-migration" to fix it.');
                $errorCount += 1;
                return false;
            }
        }
        return true;
    }

    function isValidProjectUrl(string $url): bool
    {
        $methods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];

        foreach ($methods as $method) {
            try {
                $request = Request::create($url, $method);
                Route::getRoutes()->match($request);
                return true; // matched!
            } catch (\Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException $e) {
                return true; // route exists, wrong method — still valid
            } catch (\Exception $e) {
                continue; // try next method
            }
        }

        return false;
    }

    function check_db(int& $errorCount){
        $tables = Schema::getTables();

        foreach ($tables as $table) {
            $tableName = $table['name'];
            if($tableName == 'job_batches') continue;
            $columns = Schema::getColumns($tableName);

            foreach ($columns as $column) {
                if(str_contains($column['name'], '_id') && !(str_contains($column['type'], 'bigint') && str_contains($column['type'], 'unsigned'))) {
                    $this->error('error in '.$tableName.', column '.$column['name'].' must be bigint unsigned, it is '.$column['type']);
                    $errorCount += 1;
                    return false;
                }
                if(str_contains($column['name'], '_id')){
                    $indexes = Schema::getIndexes($tableName); 
                    $is_indexed = false;
                    foreach ($indexes as $index) {
                        if(array_search($column['name'], $index["columns"]) !== false){
                            $is_indexed = true;
                            break;
                        }
                    }
                    if(!$is_indexed){
                        $this->error('error in '.$tableName.', column '.$column['name'].' must be indexed');
                        $errorCount += 1;
                    }
                }
            }
        }
        
    }
}
