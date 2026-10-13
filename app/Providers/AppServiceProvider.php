<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Branch;

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
        require_once app_path('helpers.php');

        $branches = Branch::where('status', 'A')
        ->select('id', 'slug', 'branch_name', 'capture_code')
        ->get();

        view()->share('branches', $branches);
    }
}
