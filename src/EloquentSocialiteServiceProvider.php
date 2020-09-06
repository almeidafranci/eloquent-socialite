<?php

namespace AlmeidaFranci\EloquentSocialite;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client as HttpClient;

class EloquentSocialiteServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->configureOAuthIdentitiesTable();
        $this->registerIdentityStore();
        $this->registerOAuthManager();
        $this->registerCommands();
    }

    protected function registerIdentityStore()
    {
        $this->app->singleton('AlmeidaFranci\EloquentSocialite\IdentityStore', function ($app) {
            return new EloquentIdentityStore;
        });
    }

    protected function registerOAuthManager()
    {
        $this->app->singleton('almeidafranci.eloquentsocialite', function ($app) {
            if ($app['config']['eloquent-socialite.model']) {
                $users = new UserStore($app['config']['eloquent-socialite.model']);
            } else {
                if ($app['config']['auth.providers.users.model']) {
                    $users = new UserStore($app['config']['auth.providers.users.model']);
                } else {
                    $users = new UserStore($app['config']['auth.model']);
                }
            }

            $authenticator = new Authenticator(
                $app['Illuminate\Contracts\Auth\Guard'],
                $users,
                $app['AlmeidaFranci\EloquentSocialite\IdentityStore']
            );

            $oauth = new OAuthManager($app['redirect'], $authenticator);
            return $oauth;
        });
    }

    protected function configureOAuthIdentitiesTable()
    {
        OAuthIdentity::configureTable($this->app['config']['eloquent-socialite.table']);
    }

    /**
     * Registers some utility commands with artisan
     * @return void
     */
    public function registerCommands()
    {
        $this->app->bind('command.eloquent-socialite.install', 'AlmeidaFranci\EloquentSocialite\Installation\InstallCommand');
        $this->commands('command.eloquent-socialite.install');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['almeidafranci.eloquentsocialite'];
    }

}
