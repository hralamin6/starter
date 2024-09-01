<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;





Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('app', \App\Livewire\App\DashboardComponent::class)->name('app.dashboard');
    Route::get('app/roles', \App\Livewire\App\RoleComponent::class)->name('app.roles');
    Route::get('app/backups', \App\Livewire\App\BackupComponent::class)->name('app.backups');
    Route::get('app/users', \App\Livewire\App\UserComponent::class)->name('app.users');
    Route::get('app/profile', \App\Livewire\App\ProfileComponent::class)->name('app.profile');
    Route::get('app/setting', \App\Livewire\App\SettingComponent::class)->name('app.setting');
    Route::get('app/chat', \App\Livewire\App\ChatComponent::class)->name('app.chat');
    Route::get('app/pages', \App\Livewire\App\PageComponent::class)->name('app.pages');

});

require __DIR__.'/auth.php';


Route::post('/subscribe', function (Request $request) {
    $user = \Illuminate\Support\Facades\Auth::user();
    $user->updatePushSubscription(
        $request->endpoint,
        $request->keys['p256dh'],
        $request->keys['auth']
    );
    return response()->json(['success' => true], 200);
});
Route::get('{slug}', \App\Livewire\App\NotificationComponent::class)->name('page');


