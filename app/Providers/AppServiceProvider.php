<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Record;
use App\Observers\RecordObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Record::observe(RecordObserver::class);
    }
}
