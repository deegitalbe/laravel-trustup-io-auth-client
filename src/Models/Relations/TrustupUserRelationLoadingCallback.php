<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Models\Relations;

use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Api\Endpoints\Auth\UserEndpointContract;
use Deegitalbe\LaravelTrustupIoExternalModelRelations\Contracts\Models\Relations\ExternalModelRelationLoadingCallbackContract;
use Illuminate\Support\Collection;

class TrustupUserRelationLoadingCallback implements ExternalModelRelationLoadingCallbackContract
{
    /**
     * User endpoint.
     * 
     * @var UserEndpointContract
     */
    protected UserEndpointContract $endpoint;

    /**
     * Constructing instance.
     * 
     * @param UserEndpointContract $endpoint
     * @return void
     */
    public function __construct(UserEndpointContract $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    public function load(Collection $identifiers): Collection
    {
        return $this->endpoint->byIds($identifiers);
    }
}