<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Api\Endpoints\Auth;

use Illuminate\Support\Collection;
use Henrotaym\LaravelApiClient\Contracts\ClientContract;
use Henrotaym\LaravelApiClient\Contracts\RequestContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Api\Credentials\Auth\AuthCredential;
use Deegitalbe\LaravelTrustupIoAuthClient\Enums\Role;

class UserEndpoint
{
    protected ClientContract $client;

    public function __construct(ClientContract $client, AuthCredential $credential)
    {
        $this->client = $client->setCredential($credential);
    }

    public function employees(): Collection
    {
        return $this->users(collect(Role::EMPLOYEE));
    }

    public function devs(): Collection
    {
        return $this->users(collect(Role::DEVELOPER));
    }

    public function users(Collection $roles): Collection
    {
        /** @var RequestContract */
        $request = app()->make(RequestContract::class);

        $request->setVerb('GET')
            ->setUrl('users')
            ->addQuery(['roles' => 
                $roles->map(fn (Role $role) => $role->value)->all()
            ]);

        $response = $this->client->try($request, "Could not retrieve users by roles.");

        if ($response->failed()) return collect();

        return collect($response->response()->get()->data);
    }
}