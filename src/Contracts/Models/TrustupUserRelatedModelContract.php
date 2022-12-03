<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models;

use Illuminate\Support\Collection;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\UserContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Collections\TrustupUserRelatedCollectionContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\Relations\User\TrustupUserRelationContract;

/**
 * Representing a model related to trustup users.
 */
interface TrustupUserRelatedModelContract
{
    /**
     * Getting user relation.
     * 
     * You can expect UserContract|null for non-multiple relation or Collection<int, UserContract> for multiple relation.
     * 
     * @param string $relation Relation name to get
     * @return ?UserContract|Collection<int, UserContract>
     */
    public function getTrustupUsers(string $relationName): mixed;

    /**
     * Loading given user relations.
     * @param string $relationNames relation names to load.
     * @return static
     */
    public function loadTrustupUsers(...$relationNames);

    /**
     * Creating an empty trustup user relation.
     * 
     * Do not forget to use setters to register your relation correctly.
     * 
     * @return TrustupUserRelationContract
     */
    public function newTrustupUsersRelation(): TrustupUserRelationContract;

    /**
     * Getting trustup relations from given names.
     * 
     * @param array $relationNames Relation names to get
     * @return Collection<int, TrustupUserRelationContract>
     */
    public function getTrustupUserRelationCollection(array $relationNames): Collection;

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return TrustupUserRelatedCollectionContract
     */
    public function newCollection(array $models = []);
}