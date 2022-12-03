<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Providers;

use Deegitalbe\LaravelTrustupIoAuthClient\Package;
use Deegitalbe\LaravelTrustupIoAuthClient\Models\User;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\UserContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Api\Endpoints\Auth\UserEndpoint;
use Deegitalbe\LaravelTrustupIoAuthClient\Collections\TrustupUserRelatedCollection;
use Deegitalbe\LaravelTrustupIoAuthClient\Models\Relations\User\TrustupUserRelation;
use Deegitalbe\LaravelTrustupIoAuthClient\Models\Relations\User\TrustupUserRelationLoader;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Api\Endpoints\Auth\UserEndpointContract;
use Henrotaym\LaravelPackageVersioning\Providers\Abstracts\VersionablePackageServiceProvider;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Collections\TrustupUserRelatedCollectionContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\Relations\User\TrustupUserRelationContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\Relations\User\TrustupUserRelationLoaderContract;

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
        $this->app->bind(TrustupUserRelationContract::class, TrustupUserRelation::class);
        $this->app->bind(TrustupUserRelationLoaderContract::class, TrustupUserRelationLoader::class);
        $this->app->bind(TrustupUserRelatedCollectionContract::class, TrustupUserRelatedCollection::class);
    }

    protected function addToBoot(): void
    {
        //
    }
}