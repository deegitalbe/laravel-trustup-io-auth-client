<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Tests\Unit;

use Deegitalbe\LaravelTrustupIoAuthClient\Tests\TestCase;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\UserContract;
use Henrotaym\LaravelPackageVersioning\Testing\Traits\InstallPackageTest;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Api\Endpoints\Auth\UserEndpointContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Collections\TrustupUserRelatedCollection\UserRelationContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Collections\TrustupUserRelatedCollection\UserRelationLoaderContract;

class InstallingPackageTest extends TestCase
{
    use InstallPackageTest;

    public function test_it_can_instanciate()
    {
        $this->app->make(UserEndpointContract::class);
        $this->app->make(UserContract::class);
        $this->app->make(UserRelationContract::class);
        $this->app->make(UserRelationLoaderContract::class);

        $this->assertTrue(true);
    }
}