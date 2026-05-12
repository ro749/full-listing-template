<?php

namespace Ro749\FullListingTemplate\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Ro749\FullListingTemplate\Models\Asesor;
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
        File::put(storage_path('logs/laravel.log'), '');
        if (!file_exists(app_path('Mail/CotizationMail.php'))) {
            $this->error('Falta el correo.');
            return self::FAILURE;
        }

        $this->call('check');
        $packageConfig = require __DIR__.'/../../config/full-listing-template.php';
        $packageConfig = $packageConfig['overrides'];
        $config = require config_path('overrides.php');
        
        Config::set('overrides', $this->mergeConfigs($packageConfig, $config));
        $packageConfig = require __DIR__.'/../../../listing-utils/config/listing-utils.php';
        $packageConfig = $packageConfig['overrides'];
        $config = config('overrides');
        Config::set('overrides', $this->mergeConfigs($packageConfig, $config));

        if(Asesor::instance()->count() == 0){
            Asesor::instance()->create([
                'name' => 'test',
                'mail' => 'test@example.com',
                'phone' => '3337811700',
                'number' => '0000',
                'password' => '1111'
            ]);
        }
        Auth::guard('asesor')->loginUsingId(1);

        $ans = self::SUCCESS;

        if(!$this->check_controllers()){
            $ans = self::FAILURE;
        }
        
        if(!$this->check_tables()){
            $ans = self::FAILURE;
        }

        if(!$this->check_forms()){
            $ans = self::FAILURE;
        }

        $logPath = storage_path('logs/laravel.log');

        if (!(!file_exists($logPath) || filesize($logPath) === 0)) {
            $this->error('The log file is not empty.');  
            $ans = self::FAILURE; 
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

    function check_controllers(){
        $controllers = config('overrides.controllers');
        $ans = true;
        foreach($controllers as $controller){
            $control = $controller::instance();
            $reflection = new \ReflectionClass($control);
            foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                if ($method->isConstructor() || $method->getDeclaringClass()->getName() !== get_class($control) || str_contains($method->getName(), 'get_default_args')) {
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
                    if(is_string($view) && (str_contains($view, 'Exception') || str_contains($view, '<x-'))){
                    $this->info('showing error');    
                    $this->error('error in '.$controller.' method '.$methodName);
                        $this->error($view);
                        $ans = false;
                    }
                }
                catch(\Throwable $e){
                    $this->error('error in '.$controller.' method '.$methodName);
                    $this->error($e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
                    $this->error($e->getTraceAsString());
                    $ans = false;
                }
            }
        }
        return $ans;
    }

    function check_tables(){
        $tables = config('overrides.tables');
        $ans = true;
        foreach($tables as $table){
            try{
                $this->info('check table '.$table);
                $t = $table::instance();
                $args = $t->get_default_args();
                call_user_func_array([$t, 'get'], $args);
            }catch(\Throwable $e){
                $this->error('error in '.$table);
                $this->error($e->getMessage());
                $ans = false;
            }
        }
        return $ans;
    }

    function check_forms(){
        DB::beginTransaction();
        Storage::fake('public');
        $forms = config('overrides.forms');
        $ans = true;
        foreach($forms as $key => $form){
            if($key == 'AdminLogin') continue;
            try{
                $this->info('check form '.$form);
                $f = $form::instanciate();
                $args = $f->get_default_args();
                call_user_func_array([$f, 'prosses'], $args);
            }catch(\Exception $e){
                $this->error('error in '.$form);
                $this->error($e->getMessage());
                $ans = false;
            }
            catch(\Error $er){
                $this->error('fatal error in '.$form);
                $this->error($er->getMessage());
                $ans = false;
            }
        }
        DB::rollBack();
        return $ans;
    }
}
