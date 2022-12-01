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
    Route::get('/tenants',\Tall\Tenant\Http\Livewire\Admin\Tenants\ListComponent::class)->name('admin.tenants');    
    Route::get('/minha/empresa',\Tall\Tenant\Http\Livewire\Admin\Settings\SettingComponent::class)->name('admin.tenants.setting');    
    Route::get('/tenant/cadastrar',\Tall\Tenant\Http\Livewire\Admin\Tenants\CreateComponent::class)->name('admin.tenants.create');    
    Route::get('/tenant/{model}/editar',\Tall\Tenant\Http\Livewire\Admin\Tenants\EditComponent::class)->name('admin.tenants.edit');    
    Route::get('/tenant/{model}/show',\Tall\Tenant\Http\Livewire\Admin\Tenants\ShowComponent::class)->name('admin.tenants.show');    
    Route::get('/tenant/{model}/permissoes',\Tall\Tenant\Http\Livewire\Admin\Tenants\Permissions\PermissionComponent::class)->name('admin.tenants.permissions');    
    Route::get('/tenants/importar',\Tall\Tenant\Http\Livewire\Admin\Tenants\Import\CsvComponent::class)->name('admin.tenants.import');    
});
