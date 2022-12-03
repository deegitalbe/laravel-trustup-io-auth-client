<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Traits;

use Illuminate\Support\Collection;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\Relations\User\TrustupUserRelationContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\Relations\User\TrustupUserRelationLoaderContract;

trait IsTrustupUserRelated
{
    /**
     * Getting a new trustup relation loader.
     * 
     * @return TrustupUserRelationLoaderContract
     */
    protected function newTrustupUserRelationLoader(): TrustupUserRelationLoaderContract
    {
        return app()->make(TrustupUserRelationLoaderContract::class);
    }

    /**
     * Loading single user relation.
     * 
     * @param TrustupUserRelationContract $relation Relation to load
     * @return static
     */
    protected function loadTrustupUserRelation(TrustupUserRelationContract $relation)
    {
        $this->newTrustupUserRelationLoader()
            ->addRelation($relation)
            ->setModels($this->getTrustupUserRelatedModels())
            ->load();

        return $this;
    }

    /**
     * Loading several user relations at once.
     * 
     * @param Collection<int, TrustupUserRelationContract> $relations Relations to load
     * @return static
     */
    protected function loadTrustupUserRelations(Collection $relations)
    {
        $this->newTrustupUserRelationLoader()
            ->addRelations($relations)
            ->setModels($this->getTrustupUserRelatedModels())
            ->load();

        return $this;
    }
}