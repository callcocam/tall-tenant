<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->prefix('admin')->group(function () {
    Route::get('/tenants',\Tall\Tenant\Http\Livewire\Admin\Tenants\ListComponent::class)->name(config('tenant.routes.tenant.list'));    
    Route::get('/tenant/cadastrar',\Tall\Tenant\Http\Livewire\Admin\Tenants\CreateComponent::class)->name(config('tenant.routes.tenant.create'));    
    Route::get('/tenant/{model}/editar',\Tall\Tenant\Http\Livewire\Admin\Tenants\EditComponent::class)->name(config('tenant.routes.tenant.edit'));    
    Route::get('/tenant/{model}/show',\Tall\Tenant\Http\Livewire\Admin\Tenants\ShowComponent::class)->name(config('tenant.routes.tenant.show'));    
});
