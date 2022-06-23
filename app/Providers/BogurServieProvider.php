<?php

namespace App\Providers;

use App\Bogur\BogurFacade;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

class BogurServieProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('bogur', function () {
            return BogurFacade::class;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
