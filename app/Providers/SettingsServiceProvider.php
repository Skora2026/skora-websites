<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind settings to container (full object jaise user())
        $this->app->singleton('company_settings', function () {
            return \App\Models\CompanySetting::allData();
        });
    }

    public function boot()
    {
        // Nothing needed
    }
}