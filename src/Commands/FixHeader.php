<?php

namespace Ro749\FullListingTemplate\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
class FixHeader extends Command
{
    protected $signature = 'fix:header';

    protected $description = 'Fixes the header to have the dinamic texts and button links';

    public function handle(): void
    {
        $this->call('fix:view',['view'=>'header']);
        $content = File::get(base_path('resources\views\header.blade.php'));
        $content = str_replace('Iknaton Ortega', '{{ $asesor }}', $content);
        $content = str_replace('Test Sistema', '{{ $client }}', $content);
        $content = preg_replace(
            '/<a(.*)href="#section-contact"><span>(Cerrar Sesión|Volver a inicio)<\/span><\/a>/', 
            '@if(!empty($menu))'.PHP_EOL.'<a$1href="{{ route(\'client-login\') }}"><span>Cambiar Cliente</span></a>'.PHP_EOL.'@endif'
            , $content);
        
        $content = preg_replace(
            '/<a(.*)href="(.*)"><span>Disponibilidad/', 
            '@if(!empty($menu) || !empty($is_open))'.PHP_EOL.'<a$1href="{{ empty($is_open) ? route(\'disponibilidad\') : route(\'open\') }}"><span>Disponibilidad'
            , $content);
        
        $content = preg_replace(
            '/href="(#.*)"><span>Listado<\/span><\/a>/', 
            'href="{{ empty($is_open) ? route(\'torre\') : route(\'listado\') }}"><span>Listado</span></a>'.PHP_EOL.'@endif', 
            $content);
        $content = preg_replace('/<ul(.*)>([\s\S]*)<\/ul>/', '<ul$1>@if(isset($asesor) && isset($client))$2@endif'.PHP_EOL.'</ul>', $content);
        File::put(base_path('resources\views\header.blade.php'), $content);
    }
}