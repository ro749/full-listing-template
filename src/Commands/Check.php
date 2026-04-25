<?php

namespace Ro749\FullListingTemplate\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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
        $packageConfig = require __DIR__.'/../../config/full-listing-template.php';
        $packageConfig = $packageConfig['overrides'];
        $config = require config_path('overrides.php');
        
        Config::set('overrides', $this->mergeConfigs($packageConfig, $config));

        Auth::guard('asesor')->loginUsingId(1);

        $this->check_controllers();
        
        $this->check_tables();

        $this->check_forms();

        return self::SUCCESS;
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

        foreach($controllers as $controller){
            $control = $controller::instance();
            $reflection = new \ReflectionClass($control);
            foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                if ($method->isConstructor() || $method->getDeclaringClass()->getName() !== get_class($control) || str_contains($method->getName(), 'get_default_args')) {
                    continue;
                }

                $methodName = $method->getName();
                $args = $control->get_default_args($methodName);
                $this->info('check controller '.$controller.' method '.$methodName);
                try{
                    $view = $method->invokeArgs($control, $args);
                    if(is_string($view) && str_contains($view, 'ErrorException')){
                        $this->error('error in '.$controller.' method '.$methodName);
                        $this->error($view);
                    }
                }
                catch(\Exception $e){
                    $this->error('error in '.$controller.' method '.$methodName);
                    $this->error($e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
                    $this->error($e->getTraceAsString());
                }
            }
        }
    }

    function check_tables(){
        $tables = config('overrides.tables');
        foreach($tables as $table){
            try{
                $this->info('check table '.$table);
                $t = $table::instance();
                $args = $t->get_default_args();
                call_user_func_array([$t, 'get'], $args);
            }catch(\Exception $e){
                $this->error('error in '.$table);
                $this->error($e->getMessage());
                return;
            }
            
        }
    }

    function check_forms(){
        DB::beginTransaction();
        Storage::fake('public');
        $forms = config('overrides.forms');
        foreach($forms as $key => $form){
            if($key == 'AdminLogin') continue;
            try{
                $this->info('check form '.$form);
                $f = $form::instanciate();
                $args = $f->get_default_args();
                call_user_func_array([$f, 'prosses'], $args);
            }catch(\Exception $e){
                DB::rollBack();
                $this->error('error in '.$form);
                $this->error($e->getMessage());
                return;
            }
        }
        DB::rollBack();
    }
}
