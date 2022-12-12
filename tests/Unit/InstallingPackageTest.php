<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Tests\Unit;

use Deegitalbe\LaravelTrustupIoAuthClient\Tests\TestCase;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\TrustupUserContract;
use Henrotaym\LaravelPackageVersioning\Testing\Traits\InstallPackageTest;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Api\Endpoints\Auth\UserEndpointContract;

class InstallingPackageTest extends TestCase
{
    use InstallPackageTest;

    public function test_it_can_instanciate()
    {
        $this->app->make(UserEndpointContract::class);
        $this->app->make(TrustupUserContract::class);

        $this->assertTrue(true);
    }
}