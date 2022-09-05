<?php

namespace Orizaba\LaravelComponents;

use Illuminate\Support\ServiceProvider;
use Orizaba\LaravelComponents\Providers\LaravelComponents;


class OrizabaServiceProvider extends ServiceProvider
{
    public function register()
    {
//        $this->app->register(LaravelComponents::class);
        parent::register();
    }


    public function boot()
    {
        //parent::boot();
    }
}