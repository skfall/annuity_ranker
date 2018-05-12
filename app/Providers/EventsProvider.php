<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EventsProvider extends ServiceProvider {

    public function boot() {
        \App\Models\User::observe(\App\Observers\UserObserver::class);
        \App\Models\UserCard::observe(\App\Observers\UserCardObserver::class);
        \App\Models\Project::observe(\App\Observers\ProjectObserver::class);
    }

    public function register() {

    }
}
