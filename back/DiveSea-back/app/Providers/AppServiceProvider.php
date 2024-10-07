<?php

namespace App\Providers;

use App\Models\AuctionBid;
use App\Models\ApproveAuthorship;
use App\Models\approveNft;
use App\Models\Nft;
use App\Models\User;
use App\Policies\ActionBidPolicy;
use App\Policies\ApproveAuthorshipPolicy;
use App\Policies\ApproveNftPolicy;
use App\Policies\NftPolicy;
use App\Policies\UserPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Log::info('AppServiceProvider booted, registering policies');
        Gate::policy(Nft::class, NftPolicy::class);
        Gate::policy(approveNft::class, ApproveNftPolicy::class);
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(ApproveAuthorship::class, ApproveAuthorshipPolicy::class);
        Gate::policy(AuctionBid::class, ActionBidPolicy::class);

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
