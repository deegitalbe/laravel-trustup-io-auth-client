<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Collections\TrustupUserRelatedCollection;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Collections\TrustupUserRelatedCollection\UserRelationContract;

interface UserRelationLoaderContract
{
    /**
     * Adding a relation.
     * 
     * @param UserRelationContract $relation
     * @return static
     */
    public function addRelation(UserRelationContract $relation): UserRelationLoaderContract;

    /**
     * Loading several user relations at once.
     * 
     * @param Collection<int, UserRelationContract> $relations
     * @return static
     */
    public function addRelations(Collection $relations): UserRelationLoaderContract;

    /**
     * Getting configured relations.
     * 
     * @return Collection<int UserRelationContract>
     */
    public function getRelations(): Collection;

    /**
     * Setting related models.
     * 
     * @param Collection<int, Model>
     * @return static
     */
    public function setModels(Collection $models): UserRelationLoaderContract;

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
    public function load(): UserRelationLoaderContract;
}