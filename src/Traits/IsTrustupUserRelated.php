<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Traits;

use Illuminate\Support\Collection;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Collections\TrustupUserRelatedCollection\UserRelationContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Collections\TrustupUserRelatedCollection\UserRelationLoaderContract;

trait IsTrustupUserRelated
{
    /**
     * Getting a new trustup relation loader.
     * 
     * @return UserRelationLoaderContract
     */
    protected function newTrustupUserRelationLoader(): UserRelationLoaderContract
    {
        return app()->make(UserRelationLoaderContract::class);
    }

    /**
     * Loading single user relation.
     * 
     * @param UserRelationContract $relation Relation to load
     * @return static
     */
    public function loadTrustupUserRelation(UserRelationContract $relation)
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
     * @param Collection<int, UserRelationContract> $relations Relations to load
     * @return static
     */
    public function loadTrustupUserRelations(Collection $relations)
    {
        $this->newTrustupUserRelationLoader()
            ->addRelations($relations)
            ->setModels($this->getTrustupUserRelatedModels())
            ->load();

        return $this;
    }
}