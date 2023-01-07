<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
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
        Carbon::setLocale('id');

        Blade::directive('admin', function () {
            return "<?php if(auth()->check() && auth()->user()->role_id == 1): ?>";
        });

        Blade::directive('endadmin', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('pegawai', function () {
            return "<?php if(auth()->check() && auth()->user()->role_id == 2): ?>";
        });

        Blade::directive('endpegawai', function () {
            return "<?php endif; ?>";
        });
    }
}
