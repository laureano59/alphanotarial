<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Menu;


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
          View::composer('layouts.principal', function ($view) {
            $menus = Menu::whereNull('parent_id')
            ->where('activo', 1)
            ->orderBy('orden')
            ->with('childrenRecursive')
            ->get();

            $view->with('menus', $menus);
        });
    }
}
