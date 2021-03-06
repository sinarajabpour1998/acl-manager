<?php

namespace Sinarajabpour1998\AclManager;

use Sinarajabpour1998\AclManager\Facades\UserFacade;
use Sinarajabpour1998\AclManager\Repositories\UserRepository;
use Sinarajabpour1998\AclManager\View\Components\AclMenu;
use Illuminate\Support\ServiceProvider;

class AclManagerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        UserFacade::shouldProxyTo(UserRepository::class);
    }


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/views','aclManager');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->mergeConfigFrom(__DIR__ . '/config/acl-manager.php', 'acl-manager');
        $this->publishes([
            __DIR__.'/config/acl-manager.php' =>config_path('acl-manager.php'),
            __DIR__.'/views/' => resource_path('views/vendor/AclManager'),
        ], 'acl-manager');
        $this->loadViewComponentsAs('', [
            AclMenu::class
        ]);
    }
}
