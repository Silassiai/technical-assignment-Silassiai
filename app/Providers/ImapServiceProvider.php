<?php

namespace App\Providers;

use App\Adapters\PhpImapMailboxClient;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class ImapServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PhpImapMailboxClient::class, function ($app) {
            return new PhpImapMailboxClient(
                getenv('IMAP_HOST'),
                getenv('IMAP_PORT'),
                getenv('IMAP_USERNAME'),
                getenv('IMAP_PASSWORD'),
            );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [PhpImapMailboxClient::class];
    }
}
