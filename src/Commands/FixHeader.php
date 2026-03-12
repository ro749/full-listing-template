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
        $content = str_replace('href="#section-contact"><span>Cerrar Sesión', 'href="{{ route(\'client-login\') }}"><span>Cambiar Cliente', $content);
        $content = str_replace('href="#section-contact"><span>Disponibilidad', 'href="{{ route(\'disponibilidad\') }}"><span>Disponibilidad', $content);
        $content = str_replace('#section-about', "{{ route('torre') }}", $content);
        File::put(base_path('resources\views\header.blade.php'), $content);
    }
}