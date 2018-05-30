<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Blade::directive('script', function ($path) {
            $path = str_replace("'", '"', $path);
            return "<?php echo '<script type=\'text/javascript\' src=$path></script>'; ?>";
        });
        Blade::directive('style', function ($path) {
            $path = str_replace("'", '"', $path);
            return "<?php echo '<link rel=\'stylesheet\' type=\'text/css\' href=$path />'; ?>";
        });
        Blade::directive('babelinit', function () {
            return "<?php echo '<script src=\'https://unpkg.com/babel-standalone@6/babel.min.js\'></script>'; ?>";
        });
        Blade::directive('babelscript', function ($path) {
            $path = str_replace("'", '"', $path);
            return "<?php echo '<script type=\'text/babel\' src=$path></script>'; ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }
}
