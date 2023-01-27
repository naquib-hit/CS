<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use App\Traits\CalculationHelperTrait;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    use CalculationHelperTrait;
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
        // Set Paginator Template
        Paginator::useBootstrap();
        // CalculationHelper Blade Directives
        Blade::directive('arithmethic', function ($a, $b, $operator) {
            return "<?={$this->arithmethic($a, $b, $operator)}?>";
        });

        Blade::directive('percentOf', function ($amount, $num) {
            return "<?={$this->percentOf($amount, $num)}?>";
        });

    }
}
