<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Api\Endpoints\Auth;

use Illuminate\Support\Collection;
use Deegitalbe\LaravelTrustupIoAuthClient\Enums\Role;
use Henrotaym\LaravelApiClient\Contracts\ClientContract;
use Henrotaym\LaravelApiClient\Contracts\RequestContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\UserContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Api\Credentials\Auth\AuthCredential;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Api\Endpoints\Auth\UserEndpointContract;
use Henrotaym\LaravelApiClient\Contracts\TryResponseContract;

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
        return $this->byRoles(collect(Role::EMPLOYEE));
    }

    /**
     * Getting trustup developers.
     * 
     * @return Collection<int, UserContract>
     */ 
    public function developers(): Collection
    {
        return $this->byRoles(collect(Role::DEVELOPER));
    }

    /**
     * Getting trustup users matching given roles.
     * 
     * @param Collection<int, Role>
     * @return Collection<int, UserContract>
     */
    public function byRoles(Collection $roles): Collection
    {
        /** @var RequestContract */
        $request = app()->make(RequestContract::class);

        $request->setVerb('GET')
            ->setUrl('users')
            ->addQuery(['role' => 
                $roles->map(fn (Role $role) => $role->value)->all()
            ]);

        return $this->formatResponse($this->client->try($request, "Could not retrieve users by roles."));
    }

    /**
     * Getting trustup users matching given ids.
     * 
     * @param Collection<int, Role>
     * @return Collection<int, int>
     */
    public function byIds(Collection $ids): Collection
    {
        /** @var RequestContract */
        $request = app()->make(RequestContract::class);

        $request->setVerb('GET')
            ->setUrl('users/by-ids')
            ->addQuery(['ids' => $ids->all()]);

        return $this->formatResponse($this->client->try($request, "Could not retrieve users by ids."));

    }

    /**
     * Formating given response.
     * 
     * @param TryResponseContract $response
     * @return Collection<int, UserContract>
     */
    protected function formatResponse(TryResponseContract $response): Collection
    {
        if ($response->failed()):
            report($response->error());
            return collect();
        endif;

        $users = $response->response()->get(true)['users'];

        return collect($users)->map(function (array $attributes) {
            /** @var UserContract */
            $user = app()->make(UserContract::class);
            
            return $user->fill($attributes);
        });
    }
}