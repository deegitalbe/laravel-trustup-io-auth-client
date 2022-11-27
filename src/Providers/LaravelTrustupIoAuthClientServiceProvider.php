<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Providers;

use Deegitalbe\LaravelTrustupIoAuthClient\Api\Endpoints\Auth\UserEndpoint;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Api\Endpoints\Auth\UserEndpointContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\UserContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Models\User;
use Deegitalbe\LaravelTrustupIoAuthClient\Package;
use Henrotaym\LaravelPackageVersioning\Providers\Abstracts\VersionablePackageServiceProvider;

class LaravelTrustupIoAuthClientServiceProvider extends VersionablePackageServiceProvider
{
    public static function getPackageClass(): string
    {
        return Package::class;
    }

    protected function addToRegister(): void
    {
        $this->app->bind(UserEndpointContract::class, UserEndpoint::class);
        $this->app->bind(UserContract::class, User::class);
    }

    protected function addToBoot(): void
    {
        //
    }
}