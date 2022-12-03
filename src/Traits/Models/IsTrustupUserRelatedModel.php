<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Traits\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Henrotaym\LaravelHelpers\Facades\Helpers;
use Deegitalbe\LaravelTrustupIoAuthClient\Traits\IsTrustupUserRelated;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\TrustupUserContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Collections\TrustupUserRelatedCollection;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\TrustupUserRelatedModelContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Collections\TrustupUserRelatedCollectionContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\Relations\User\TrustupUserRelationContract;

trait IsTrustupUserRelatedModel
{
    use IsTrustupUserRelated;

    /**
     * Getting user relation.
     * 
     * You can expect TrustupUserContract|null for non-multiple relation or Collection<int, TrustupUserContract> for multiple relation.
     * 
     * @param string $relation Relation name to get
     * @return ?TrustupUserContract|Collection<int, TrustupUserContract>
     */
    public function getTrustupUsers(string $relationName): mixed
    {
        return $this->getTrustupUserRelation($this->{$relationName}());
    }

    /**
     * Loading given user relations.
     * @param string $relationNames relation names to load.
     * @return static
     */
    public function loadTrustupUsers(...$relationNames): TrustupUserRelatedModelContract
    {
        return $this->loadTrustupUserRelations($this->getTrustupUserRelationCollection($relationNames));
    }

    /**
     * Creating an empty trustup user relation.
     * 
     * Do not forget to use setters to register your relation correctly.
     * 
     * @return TrustupUserRelationContract
     */
    public function newTrustupUsersRelation(): TrustupUserRelationContract
    {
        return app()->make(TrustupUserRelationContract::class);
    }

    /**
     * Getting trustup relations from given names.
     * 
     * @param array $relationNames Relation names to get
     * @return Collection<int, TrustupUserRelationContract>
     */
    public function getTrustupUserRelationCollection(array $relationNames): Collection
    {
        return collect($relationNames)->map(fn (string $relation) => $this->{$relation}());
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return TrustupUserRelatedCollectionContract
     */
    public function newCollection(array $models = [])
    {
        return app()->make(TrustupUserRelatedCollectionContract::class, ['items' => $models]);
    }

    /**
     * Getting related models.
     * 
     * @return Collection<int, Model>
     */
    protected function getTrustupUserRelatedModels(): Collection
    {
        return collect([$this]);
    }

    /**
     * Getting user relation.
     * 
     * You can expect TrustupUserContract|null for non-multiple relation or Collection<int, TrustupUserContract> for multiple relation.
     * 
     * @param TrustupUserRelationContract $relation Relation to load
     * @return ?TrustupUserContract|Collection<int, TrustupUserContract>
     */
    protected function getTrustupUserRelation(TrustupUserRelationContract $relation): mixed
    {
        [$error, $value] = Helpers::try(fn () => $this->{$relation->getUsersProperty()});

        if (!$error):
            return $value;
        endif;

        $this->loadTrustupUserRelation($relation);

        return $this->{$relation->getUsersProperty()};
    }
}