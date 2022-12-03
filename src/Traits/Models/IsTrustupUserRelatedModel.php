<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Traits\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Deegitalbe\LaravelTrustupIoAuthClient\Traits\IsTrustupUserRelated;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Collections\TrustupUserRelatedCollection\UserRelationContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\UserContract;
use Henrotaym\LaravelHelpers\Facades\Helpers;

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
     * Getting single user relation.
     * 
     * @param UserRelationContract $relation Relation to load
     * @return ?UserContract
     */
    public function getTrustupUserRelation(UserRelationContract $relation): ?UserContract
    {
        return $this->getTrustupUserRelationCommon($relation); 
    }

    /**
     * Getting users collection relation.
     * 
     * @param UserRelationContract $relation Relation to load
     * @return Collection<int, UserContract>
     */
    public function getTrustupUsersRelation(UserRelationContract $relation): Collection
    {
        return $this->getTrustupUserRelationCommon($relation); 
    }

    /**
     * Loading user relation.
     * 
     * @param UserRelationContract $relation Relation to load
     * @return UserContract|null|Collection<int, UserContract>
     */
    protected function getTrustupUserRelationCommon(UserRelationContract $relation): mixed
    {
        [$error, $value] = Helpers::try(fn () => $this->{$relation->getUsersProperty()});

        if (!$error):
            return $value;
        endif;

        $this->loadTrustupUserRelation($relation);

        return $this->{$relation->getUsersProperty()};
    }
}