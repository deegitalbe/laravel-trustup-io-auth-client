<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Traits\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Henrotaym\LaravelHelpers\Facades\Helpers;
use Deegitalbe\LaravelTrustupIoAuthClient\Traits\IsTrustupUserRelated;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\UserContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Collections\TrustupUserRelatedCollection;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Collections\TrustupUserRelatedCollection\UserRelationContract;

trait IsTrustupUserRelatedModel
{
    use IsTrustupUserRelated;

    /**
     * Getting related models.
     * 
     * @return Collection<int, Model>
     */
    public function getTrustupUserRelatedModels(): Collection
    {
        return collect([$this]);
    }

    /**
     * Getting user relation.
     * 
     * You can expect UserContract|null for non-multiple relation or Collection<int, UserContract> for multiple relation.
     * 
     * @param UserRelationContract $relation Relation to load
     * @return mixed
     */
    public function getTrustupUserRelation(UserRelationContract $relation)
    {
        [$error, $value] = Helpers::try(fn () => $this->{$relation->getUsersProperty()});

        if (!$error):
            return $value;
        endif;

        $this->loadTrustupUserRelation($relation);

        return $this->{$relation->getUsersProperty()};
    }

    /**
     * Getting user relation.
     * 
     * You can expect UserContract|null for non-multiple relation or Collection<int, UserContract> for multiple relation.
     * 
     * @param string $relation Relation name to get
     * @return mixed
     */
    public function getTrustupUsers(string $relationName)
    {
        return $this->getTrustupUserRelation($this->{$relationName}());
    }

    /**
     * Loading given user relations.
     * @param string $relationNames relation names to load.
     * @return static
     */
    public function loadTrustupUsers(...$relationNames)
    {
        return $this->loadTrustupUserRelations($this->getTrustupUserRelationCollection($relationNames));
    }

    /**
     * Getting trustup relations from given names.
     * 
     * @param array $relationNames Relation names to get
     * @return Collection<int, UserRelationContract>
     */
    public function getTrustupUserRelationCollection(array $relationNames)
    {
        return collect($relationNames)->map(fn (string $relation) => $this->{$relation}());
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return TrustupUserRelatedCollection
     */
    public function newCollection(array $models = [])
    {
        return new TrustupUserRelatedCollection($models);
    }
}