<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Api\Endpoints\Auth;

use Illuminate\Support\Collection;
use Deegitalbe\LaravelTrustupIoAuthClient\Enums\Role;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\TrustupUserContract;

interface UserEndpointContract
{
    /**
     * Getting trustup employees.
     * 
     * @return Collection<int, TrustupUserContract>
     */
    public function employees(): Collection;

    /**
     * Getting trustup developers.
     * 
     * @return Collection<int, TrustupUserContract>
     */
    public function developers(): Collection;

    /**
     * Getting trustup users matching given roles.
     * 
     * @param Collection<int, Role>
     * @return Collection<int, TrustupUserContract>
     */
    public function byRoles(Collection $roles): Collection;

    /**
     * Getting trustup users matching given ids.
     * 
     * @param Collection<int, Role>
     * @return Collection<int, int>
     */
    public function byIds(Collection $ids): Collection;
}