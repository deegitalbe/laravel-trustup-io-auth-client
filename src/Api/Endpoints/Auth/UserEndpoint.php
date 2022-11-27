<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Api\Endpoints\Auth;

use Illuminate\Support\Collection;
use Deegitalbe\LaravelTrustupIoAuthClient\Enums\Role;
use Henrotaym\LaravelApiClient\Contracts\ClientContract;
use Henrotaym\LaravelApiClient\Contracts\RequestContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\UserContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Api\Credentials\Auth\AuthCredential;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Api\Endpoints\Auth\UserEndpointContract;

class UserEndpoint implements UserEndpointContract
{
    protected ClientContract $client;

    public function __construct(ClientContract $client, AuthCredential $credential)
    {
        $this->client = $client->setCredential($credential);
    }

    /**
     * Getting trustup employees.
     * 
     * @return Collection<int, UserContract>
     */
    public function employees(): Collection
    {
        return $this->users(collect(Role::EMPLOYEE));
    }

    /**
     * Getting trustup developers.
     * 
     * @return Collection<int, UserContract>
     */ 
    public function developers(): Collection
    {
        return $this->users(collect(Role::DEVELOPER));
    }

    /**
     * Getting trustup users matching given roles.
     * 
     * @param Collection<int, Role>
     * @return Collection<int, UserContract>
     */
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

        $users = $response->response()->get(true)->users;

        return collect($users)->map(function (array $attributes) {
            /** @var UserContract */
            $user = app()->make(UserContract::class);
            
            return $user->fill($attributes);
        });
    }
}