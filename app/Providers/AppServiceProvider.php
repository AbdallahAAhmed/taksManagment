<?php

namespace App\Providers;

use App\Models\About_us;
use App\Models\Setting;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $id = Auth::id();
        $myTasks = DB::table('tasks')->select(['tasks.*'])->whereId($id)->get();
        view()->share('settings',Setting::orderBy('id','desc')->first());
        view()->share('about',About_us::orderBy('id','desc')->first());
        view()->share('myTasks', $myTasks);

    }
}
