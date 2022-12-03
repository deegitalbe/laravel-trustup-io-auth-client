<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Traits\Resource;

use Illuminate\Support\Collection;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\TrustupUserContract;
use Illuminate\Http\Resources\MissingValue;

trait IsTrustupUserRelatedResource
{
    /**
     * Retrieve a relationship if it has been loaded.
     * 
     * @param string $relationName Relation name to potentially retrieve
     * @return MissingValue|Collection<int, TrustupUserContract>|?TrustupUserContract
     */
    public function whenTrustupUsersLoaded(string $relationName): mixed
    {
        return $this->resource->trustupUsersRelationLoaded($relationName)
            ? $this->resource->getTrustupUsers($relationName)
            : new MissingValue;
    }
}