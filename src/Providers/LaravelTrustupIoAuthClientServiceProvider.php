<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Providers;

use Deegitalbe\LaravelTrustupIoAuthClient\Package;
use Deegitalbe\LaravelTrustupIoAuthClient\Models\User;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\UserContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Api\Endpoints\Auth\UserEndpoint;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Api\Endpoints\Auth\UserEndpointContract;
use Henrotaym\LaravelPackageVersioning\Providers\Abstracts\VersionablePackageServiceProvider;
use Deegitalbe\LaravelTrustupIoAuthClient\Collections\TrustupUserRelatedCollection\UserRelation;
use Deegitalbe\LaravelTrustupIoAuthClient\Collections\TrustupUserRelatedCollection\UserRelationLoader;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Collections\TrustupUserRelatedCollection\UserRelationContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Collections\TrustupUserRelatedCollection\UserRelationLoaderContract;

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
        $this->app->bind(UserRelationContract::class, UserRelation::class);
        $this->app->bind(UserRelationLoaderContract::class, UserRelationLoader::class);
    }

    protected function addToBoot(): void
    {
        //
    }
}