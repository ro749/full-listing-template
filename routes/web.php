<?php
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    
    Route::middleware('auth:web')->group(function () {
        $admin_controller = config('overrides.controllers.AdminController');
        Route::get('/admin/clients', [$admin_controller, 'clients']);
        Route::get('/admin/torre', [$admin_controller, 'torre'])->name('admin-torre');
        Route::get('/admin/ventas', [$admin_controller, 'ventas']);
        Route::get('/admin/actualizar-precios', [$admin_controller, 'precios'])->name('actualizar-precios');
        Route::get('/admin/cotizaciones', [$admin_controller, 'quotations']);
        Route::get('/admin/client-profile', [$admin_controller, 'profile'])->name('admin-client-profile');
        Route::get('/admin/clients-asesor', [$admin_controller, 'get_clients'])->name('clients-asesor');
        Route::post('/admin/reset-password', [$admin_controller, 'reset_password'])->name('reset-password');
        Route::get('/admin/dashboard', [$admin_controller, 'dashboard'])->name('dashboard');
    });
    Route::middleware('auth:asesor')->group(function () {
        $asesor_controller = config('overrides.controllers.AsesorController');
        $dispo_controller = config('overrides.controllers.DispoController');
        Route::get('/client-login', [$asesor_controller, 'index'])->name('client-login');
        Route::get('/clients', [$asesor_controller, 'clients']);
        Route::get('/cotizaciones', [$asesor_controller, 'quotations'])->name('cotizaciones');
        Route::get('/disponibilidad', [$dispo_controller, 'index'])->name('disponibilidad');
        Route::get('/listado', [$dispo_controller, 'torre'])->name('torre');
        Route::get('/view-asesor', [$dispo_controller, 'asesor'])->name('view-asesor');
        Route::get('/client-profile', [$asesor_controller, 'profile'])->name('client-profile');
        Route::post('/update-profile', [$asesor_controller, 'update_profile'])->name('update-profile');
        Route::get('/reset-password', [$asesor_controller, 'reset_password'])->name('reset-password-view');
    });
    $admin_login_controller = config('overrides.controllers.AdminLoginController');
    Route::get('/admin', [$admin_login_controller, 'index']);
    $dispo_controller = config('overrides.controllers.DispoController');
    Route::get('/client-view', [$dispo_controller, 'client'])->name('client-view');
    Route::get('/unavailable', [$dispo_controller, 'unavailable'])->name('unavailable');
    Route::get('/test',function(){
        return 'testing';
    });
});