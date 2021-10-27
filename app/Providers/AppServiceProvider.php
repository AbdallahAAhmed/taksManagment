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
        view()->share('settings',Setting::orderBy('id','desc')->first());
        view()->share('about',About_us::orderBy('id','desc')->first());
      
        view()->composer('*', function () {
            $id = Auth::id();
            view()->share('myTasks',Task::where('user_id',$id)
                ->where('isDelete',0)
                ->where('status','inProgress')->orderBy('id','desc')
                ->get());
        });

    }
}
