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

use Laravel\Dusk\Browser;
use Laravel\Dusk\Chrome\ChromeProcess;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

use Ro749\FullListingTemplate\Models\Asesor;
use Ro749\FullListingTemplate\Models\Client;
use Ro749\FullListingTemplate\Models\Quotation;
use Ro749\FullListingTemplate\Models\Unit;
use Ro749\ListingUtils\Plans\PlansBase;

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
    protected $description = 'Check if this project is ready to upload, and autofixes what it can';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->info('Checking if the project is ready to upload...');
        config('database.connections.mysql.database', 'test');
        DB::purge('mysql');
        DB::reconnect('mysql');
        Artisan::call('migrate:fresh', ['--force' => true]);
        File::put(storage_path('logs/laravel.log'), '');
        if (!file_exists(app_path('Mail/CotizationMail.php'))) {
            $this->error('Falta el correo.');
            $this->error('A fatal error encountered, please fix it before uploading.');
            return self::FAILURE;
        }
        $this->info('checking');
        $this->call('check');
        $packageConfig = require base_path('vendor/ro749/full-listing-template/config/full-listing-template.php');
        $packageConfig = $packageConfig['overrides'];
        $config = require config_path('overrides.php');
        
        Config::set('overrides', $this->mergeConfigs($packageConfig, $config));
        $packageConfig = require base_path('vendor/ro749/listing-utils/config/listing-utils.php');
        $packageConfig = $packageConfig['overrides'];
        $config = config('overrides');
        Config::set('overrides', $this->mergeConfigs($packageConfig, $config));
        if(Asesor::instance()->count() == 0){
            $asesor_id = Asesor::instance()->insertGetId([
                'name' => 'test',
                'category' => '0',
                'mail' => 'test@example.com',
                'phone' => '3337811700',
                'number' => '1111',
                'password' => Hash::make('1111')
            ]);
        }
        else{
            $asesor_id = Asesor::instance()->first()->id;
        }
        Auth::guard('asesor')->loginUsingId($asesor_id);
        if(Client::instance()->count() == 0){
            $client_id = Client::instance()->insertGetId([
                'name' => 'test',
                'mail' => 'test@example.com',
                'phone' => '3337811700',
                'asesor_id' => $asesor_id
            ]);
        }
        else{
            $client_id = Client::instance()->first()->id;
        }

        if(Quotation::instance()->count() == 0){
            $quotation_id = Quotation::instance()->insertGetId([
                'asesor_id' => $asesor_id,
                'client_id' => $client_id,
                'unit_id' => Unit::instance()->where('status', '0')->first()->id,
                'status' => 0,
            ]);
        }
        DB::table('users')->insert(['name' => 'admin', 'email' => 'admin@example.com', 'password' => Hash::make('admin'), ]);
        

        $errorCount = 0;
        $ans = self::SUCCESS;

        if(!$this->check_controllers($errorCount)){
            $ans = self::FAILURE;
        }

        if(!$this->check_forms($errorCount)){
            $ans = self::FAILURE;
        }

        if(!$this->check_tables($errorCount)){
            $ans = self::FAILURE;
        }

        if(!$this->check_db($errorCount)){
            $ans = self::FAILURE;
        }
        
        
        if(!$this->check_listing_utils($errorCount)){
            $ans = self::FAILURE;
        }



        $logPath = storage_path('logs/laravel.log');

        if (!(!file_exists($logPath) || filesize($logPath) === 0)) {
            $this->error('The log file is not empty.');  
            $this->error(file_get_contents($logPath));
            $errorCount += 1;
            $ans = self::FAILURE; 
        }

        if ($errorCount > 0) {
            $this->error($errorCount . ' error(s) found, please fix them before uploading.');
        } else {
            $this->info('No errors found, your project is ready to upload!');
        }

        return $ans;
    }

    protected function mergeConfigs(array $package, array $project): array
    {
        foreach ($project as $key => $value) {
            $package[$key] = (is_array($value) && isset($package[$key]) && is_array($package[$key]))
                ? $this->mergeConfigs($package[$key], $value)
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

    function check_tables(int& $errorCount){
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

    function mock_form_data($form){
        $form = $form::instanciate();
        foreach($form->fields as $field){
            
        }
    }

    function check_forms(int& $errorCount){
        Storage::fake('public');
        $forms = config('overrides.forms');
        $ans = true;
        foreach($forms as $key => $form){
            if($key == 'AdminLogin') continue;
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
            }
        }
        
    }

    function check_in_browser(){

        //$process = (new ChromeProcess(9515))->toProcess();
        //$process->start();
        Browser::$baseUrl = 'http://127.0.0.1:8000';
        $driver = RemoteWebDriver::create('http://localhost:50727', DesiredCapabilities::chrome());
        $browser = new Browser($driver);
        $browser->visit('/');
        $logs = $driver->manage()->getLog('browser');
        $browser->quit();
        $this->info(json_encode($logs, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        //$process->stop();
    }
}
