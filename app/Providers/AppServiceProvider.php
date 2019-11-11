<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        // BladeX::components('components.*');
        Blade::component('components.modal', 'modal');
        Blade::component('components.select-menu', 'selectMenu');
        Blade::component('components.inputbox', 'inputbox');
        Carbon::setToStringFormat('m-d-y');
    }
}
