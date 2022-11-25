<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient;

use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\PackageContract;
use Henrotaym\LaravelPackageVersioning\Services\Versioning\VersionablePackage;

class Package extends VersionablePackage implements PackageContract
{
    public static function prefix(): string
    {
        return "laravel-trustup-io-auth-client";
    }
}