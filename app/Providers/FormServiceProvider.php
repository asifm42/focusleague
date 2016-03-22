<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Collective\Html\HtmlServiceProvider;

class FormServiceProvider extends HtmlServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Macros must be loaded after the HTMLServiceProvider's
        // register method is called. Otherwise, csrf tokens
        // will not be generated
        parent::register();

        // Load macros
        require base_path() . '/app/Forms/macros.php';
    }
}