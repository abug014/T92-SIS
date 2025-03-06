<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('check:admin {email}', function ($email) {
    $user = \App\Models\User::where('email', $email)->first();
    if ($user) {
        $this->info("User found:");
        $this->info("Name: " . $user->name);
        $this->info("Email: " . $user->email);
        $this->info("Is Admin: " . ($user->is_admin ? 'Yes' : 'No'));
    } else {
        $this->error("User not found");
    }
})->purpose('Check if a user is admin');
