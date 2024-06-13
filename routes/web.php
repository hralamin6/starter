<?php

use Illuminate\Support\Facades\Route;
Route::get('backup' , function (){
    \Illuminate\Support\Facades\Artisan::call('backup:run');
    return \Illuminate\Support\Facades\Artisan::output();
});
Route::get('put', function() {
    $filename = 'images.png';
    $filePath = public_path('images/icons/i.png');
    $fileData = \Illuminate\Support\Facades\File::get($filePath);
    \Illuminate\Support\Facades\Storage::disk('google')->put($filename, $fileData);
    return 'File was saved to Google Drive';
});
Route::view('/', 'welcome')->name('home');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('app', \App\Livewire\App\DashboardComponent::class)->name('app.dashboard');
    Route::get('app/roles', \App\Livewire\App\RoleComponent::class)->name('app.roles');
    Route::get('app/backups', \App\Livewire\App\BackupComponent::class)->name('app.backups');
    Route::get('app/users', \App\Livewire\App\UserComponent::class)->name('app.users');

});


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
Route::view('asdf', 'profile')
    ->middleware(['auth'])
    ->name('products');
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('users');

require __DIR__.'/auth.php';
