<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\Relations\User;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\Relations\User\TrustupUserRelationContract;

interface TrustupUserRelationLoaderContract
{
    /**
     * Adding a relation.
     * 
     * @param TrustupUserRelationContract $relation
     * @return static
     */
    public function addRelation(TrustupUserRelationContract $relation): TrustupUserRelationLoaderContract;

    /**
     * Loading several user relations at once.
     * 
     * @param Collection<int, TrustupUserRelationContract> $relations
     * @return static
     */
    public function addRelations(Collection $relations): TrustupUserRelationLoaderContract;

    /**
     * Getting configured relations.
     * 
     * @return Collection<int TrustupUserRelationContract>
     */
    public function getRelations(): Collection;

    /**
     * Setting related models.
     * 
     * @param Collection<int, Model>
     * @return static
     */
    public function setModels(Collection $models): TrustupUserRelationLoaderContract;

    /**
     * Getting related models.
     * 
     * @return Collection<int, Model>
     */
    public function getModels(): Collection;

    /**
     * Loading configured relations.
     * 
     * @return static
     */
    public function load(): TrustupUserRelationLoaderContract;
}