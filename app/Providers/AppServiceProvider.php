<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\EmailMarketing\EmailMarketingService;
use App\Services\EmailMarketing\EmailBlasterUKService;

use Livewire\Livewire;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(EmailMarketingService::class, function () {
            $service = client_setting('email.marketing.service.name');
    
            return match ($service) {
                'emailblaster' => new EmailBlasterUKService(),
                // 'mailchimp' => new MailchimpService(),
                default => throw new \Exception("Unsupported email marketing service: {$service}")
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
