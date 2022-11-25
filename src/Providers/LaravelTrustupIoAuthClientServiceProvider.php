<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Providers;

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
        //
    }

    protected function addToBoot(): void
    {
        //
    }
}