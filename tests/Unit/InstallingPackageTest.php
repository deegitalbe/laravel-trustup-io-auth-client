<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Tests\Unit;

use Deegitalbe\LaravelTrustupIoAuthClient\Api\Endpoints\Auth\UserEndpoint;
use Deegitalbe\LaravelTrustupIoAuthClient\Tests\TestCase;
use Henrotaym\LaravelPackageVersioning\Testing\Traits\InstallPackageTest;

class InstallingPackageTest extends TestCase
{
    use InstallPackageTest;

    public function test_it_can_instanciate()
    {
        app(UserEndpoint::class);
        $this->assertTrue(true);
    }
}