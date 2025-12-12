<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Application;

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
        View::composer('Admin.AdminLayout', function ($view) {
            $rejectedStudents = Application::where('status', 'rejected')->with('student')->get();
            $view->with('rejectedStudents', $rejectedStudents);
        });
    }
}
