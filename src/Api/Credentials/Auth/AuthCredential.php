<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Api\Credentials\Auth;

use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\PackageContract;
use Henrotaym\LaravelApiClient\Contracts\RequestContract;
use Deegitalbe\ServerAuthorization\Credential\AuthorizedServerCredential;

class AuthCredential extends AuthorizedServerCredential
{
    public function __construct(
        protected PackageContract $package
    ){}

    public function prepare(RequestContract &$request)
    {
        parent::prepare($request);
        $apiUrl = "{$this->getCorrectBaseUrl()}/api";

        $request->setBaseUrl($apiUrl);
    }

    protected function getCorrectBaseUrl(): string
    {
        $isUsingDocker = filter_var(
            $this->package->getConfig("docker.activated"),
            FILTER_VALIDATE_BOOLEAN
        );

        return $isUsingDocker
            ? $this->package->getConfig('docker.service')
            : $this->package->getConfig('url');
    }
}