<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models;

use Illuminate\Support\Collection;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\TrustupUserContract;
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
     * You can expect TrustupUserContract|null for non-multiple relation or Collection<int, TrustupUserContract> for multiple relation.
     * 
     * @param string $relation Relation name to get
     * @return ?TrustupUserContract|Collection<int, TrustupUserContract>
     */
    public function getTrustupUsers(string $relationName): mixed;

    /**
     * Loading given user relations.
     * @param string $relationNames relation names to load.
     * @return static
     */
    public function loadTrustupUsers(...$relationNames): TrustupUserRelatedModelContract;

    /**
     * Creating a new belongs to trustup user relation.
     * 
     * @param string $idProperty Model property containing related id.
     * @param string $userProperty Model property where related user should be stored.
     * @return TrustupUserRelationContract
     */
    public function belongsToTrustupUser(string $idProperty, string $userProperty = null): TrustupUserRelationContract;

     /**
     * Creating a new has many trustup users relation.
     * 
     * @param string $idsProperty Model property containing related ids.
     * @param string $usersProperty Model property where related users should be stored.
     * @return TrustupUserRelationContract
     */
    public function hasManyTrustupUsers(string $idsProperty, string $usersProperty = null): TrustupUserRelationContract;

    /**
     * Telling if trustup users relation is loaded.
     * 
     * @param string $relationName Relation name to check.
     * @return bool
     */
    public function trustupUsersRelationLoaded(string $relationName): bool;

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