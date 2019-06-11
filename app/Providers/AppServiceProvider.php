<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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
        //
        Validator::extend('mobile_indonesia', function($attribute, $value, $parameters, $validator) {
            return preg_match('/^(^\+62\s?|^0)(\d{3,4}-?){2}\d{3,4}$/', $value);
        });

        Validator::replacer('mobile_indonesia', function($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute',$attribute, 'Please Enter Valid Indonesian Phone Number');
        });
    }
}
