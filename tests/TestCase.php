<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Tests;

use Deegitalbe\LaravelTrustupIoAuthClient\Package;
use Henrotaym\LaravelPackageVersioning\Testing\VersionablePackageTestCase;
use Deegitalbe\LaravelTrustupIoAuthClient\Providers\LaravelTrustupIoAuthClientServiceProvider;
use Henrotaym\LaravelApiClient\Providers\ClientServiceProvider;

class TestCase extends VersionablePackageTestCase
{
    public static function getPackageClass(): string
    {
        return Package::class;
    }
    
    public function getServiceProviders(): array
    {
        return [
            ClientServiceProvider::class,
            LaravelTrustupIoAuthClientServiceProvider::class,
        ];
    }
}