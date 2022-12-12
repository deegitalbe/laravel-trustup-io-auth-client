<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Traits\Models;

use Deegitalbe\LaravelTrustupIoAuthClient\Models\Relations\TrustupUserRelationLoadingCallback;
use Deegitalbe\LaravelTrustupIoExternalModelRelations\Contracts\Models\Relations\ExternalModelRelationContract;
use Deegitalbe\LaravelTrustupIoExternalModelRelations\Traits\Models\IsExternalModelRelatedModel;

trait IsTrustupUserRelatedModel
{
    use IsExternalModelRelatedModel;

    /**
     * Creating a new belongs to external models relation.
     * 
     * @param ExternalModelRelationLoadingCallbackContract $callback Callback able to load related models
     * @param string $idProperty Model property containing related id.
     * @param ?string $name Name where related model should be stored.
     * @return ExternalModelRelationContract
     */
    public function belongsToTrustupUser(string $idProperty, string $name = null): ExternalModelRelationContract
    {
        return $this->belongsToExternalModel(
            app()->make(TrustupUserRelationLoadingCallback::class),
            $idProperty,
            $name
        );
    }

    /**
     * Creating a new has many external models relation.
     * 
     * @param ExternalModelRelationLoadingCallbackContract $callback Callback able to load related models
     * @param string $idsProperty Model property containing external model ids.
     * @param ?string $name Name where related models should be stored.
     * @return ExternalModelRelationContract
     */
    public function hasManyTrustupUsers(string $idsProperty, string $name = null): ExternalModelRelationContract
    {
        return $this->hasManyExternalModels(
            app()->make(TrustupUserRelationLoadingCallback::class),
            $idsProperty,
            $name
        );
    }
}