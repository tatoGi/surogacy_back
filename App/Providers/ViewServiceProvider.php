<?php

namespace App\Providers;

use App\Http\View\Composers\DashboardComposer;
use App\Http\View\Composers\WebsiteComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
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

        // Using closure based composers...
        View::composer('admin.*', DashboardComposer::class);

        // Using closure based composers...
        View::composer('website.*', WebsiteComposer::class);
    }
}
