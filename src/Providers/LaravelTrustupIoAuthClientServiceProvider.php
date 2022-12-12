<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Providers;

use Deegitalbe\LaravelTrustupIoAuthClient\Package;
use Deegitalbe\LaravelTrustupIoAuthClient\Models\TrustupUser;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\TrustupUserContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Api\Endpoints\Auth\UserEndpoint;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Api\Endpoints\Auth\UserEndpointContract;
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
        $this->app->bind(TrustupUserContract::class, TrustupUser::class);
    }

    protected function addToBoot(): void
    {
        //
    }
}