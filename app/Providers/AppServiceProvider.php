<?php

namespace App\Providers;

use App\Http\Controllers\Controller;
use App\Services\Layout;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Services\Menu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Menu::class, function (){
            $menu = new Menu();

            $menu->addSection('Dashboard', 'fas fa-tachometer-alt')
                ->setAlias('dashboard')
                ->setRoute('admin/dashboard');
            $menu->addSection('Admins', 'fa-solid fa-users')
                ->setAlias('admins')
                ->setRoute('admin/admins.index');
            $menu->addSection('Logout', 'fa-solid fa-right-from-bracket')
                ->setAlias('logout')
                ->setRoute('logout');
            return $menu;
        });
        $this->app->afterResolving(Controller::class, function (Controller $controller, Application $app) {
            $controller->setLayout($app->make(Menu::class));
            $controller->boot();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Guard $auth): void
    {


        View::composer('*', function ($view) {
            $view->with('menu', app(Menu::class));
        });

        View::composer('*', function ($view) use ($auth) {
            $view->with('user', $auth->user());
        });
    }
}
