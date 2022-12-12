<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models;

use Deegitalbe\LaravelTrustupIoExternalModelRelations\Contracts\Models\ExternalModelRelatedModelContract;
use Deegitalbe\LaravelTrustupIoExternalModelRelations\Contracts\Models\Relations\ExternalModelRelationContract;

/**
 * Representing a model related to trustup users.
 */
interface TrustupUserRelatedModelContract extends ExternalModelRelatedModelContract
{
    /**
     * Creating a new belongs to trustup user relation.
     * 
     * @param string $idProperty Model property containing related id.
     * @param string $name Name where related model should be stored.
     * 
     * @return ExternalModelRelationContract
     */
    public function belongsToTrustupUser(string $idProperty, string $name = null): ExternalModelRelationContract;

     /**
     * Creating a new has many trustup users relation.
     * 
     * @param string $idsProperty Model property containing related ids.
     * @param string $name Name where related models should be stored.
     * 
     * @return ExternalModelRelationContract
     */
    public function hasManyTrustupUsers(string $idsProperty, string $name = null): ExternalModelRelationContract;
}