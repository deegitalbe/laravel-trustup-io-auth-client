<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Api\Credentials\Auth;

use Henrotaym\LaravelApiClient\Contracts\RequestContract;
use Deegitalbe\ServerAuthorization\Credential\AuthorizedServerCredential;

class AuthCredential extends AuthorizedServerCredential
{
    public function prepare(RequestContract &$request)
    {
        parent::prepare($request);

        $request->setBaseUrl(env("TRUSTUP_IO_AUTHENTIFICATION_URL"). "/api");
    }
}