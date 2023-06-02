<?php

namespace App\Providers;

use App\Models\Subscription;
use App\Models\SubscriptionItem;
use Laravel\Cashier\Cashier;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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
        Paginator::useBootstrapFive();

        Blade::directive('capacity', function($expr){
            return "<?php echo byte_to_unit($expr); ?>";
        });


        Password::defaults(function(){
            $password = Password::min(config('password.min'));
            if(config('password.mixed_case')){
                $password->mixedCase();
            }
            if(config('password.letters')){
                $password->letters();
            }
            if(config('password.number')){
                $password->numbers();
            }
            if(config('password.uncompromised')){
                $password->uncompromised();
            }
            return $password;
        });

        Cashier::useSubscriptionModel(Subscription::class);
        Cashier::useSubscriptionItemModel(SubscriptionItem::class);
    }
}
