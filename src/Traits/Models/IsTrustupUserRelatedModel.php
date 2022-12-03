<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Traits\Models;

use Illuminate\Support\Str;
use Henrotaym\LaravelHelpers\Facades\Helpers;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\UserContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Collections\TrustupUserRelatedCollection\UserRelationContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Collections\TrustupUserRelatedCollection\UserRelationLoaderContract;
use Illuminate\Support\Collection;

trait IsTrustupUserRelatedModel
{
    /**
     * Getting trustup user relation.
     * 
     * @param string $userIdProperty Model property containing user id.
     * @param string $userProperty Model property where you would like to set related user.
     * @return ?UserContract
     */
    public function getTrustupUserRelation(string $userIdProperty, string $userProperty = null): ?UserContract
    {
        return $this->getTrustupUsersRelationCommon($userIdProperty, $userProperty, false);
    }

    /**
     * Getting trustup users relation.
     * 
     * @param string $userIdsProperty Model property containing user ids.
     * @param string $usersProperty Model property where you would like to set related users collection.
     * @return Collection<int, UserContract>
     */
    public function getTrustupUsersRelation(string $userIdsProperty, string $usersProperty = null): Collection
    {
        return $this->getTrustupUsersRelationCommon($userIdsProperty, $usersProperty, true);
    }

    /**
     * Getting trustup user relation.
     * 
     * @param string $userIdsProperty Property containing user ids.
     * @param bool $isMultiple Telling if relation is expecting a collection or a single user.
     * @param string $usersProperty Property where you would like to set users.
     * @return UserContract|null|Collection<int, UserContract>
     */
    public function getTrustupUsersRelationCommon(string $userIdsProperty, ?string $usersProperty, bool $isMultiple): mixed
    {
        $usersProperty = $usersProperty ?:
            Str::plural(str_replace("_id" . ($isMultiple ? "s": ""), "", $userIdsProperty));

        [$error, $value] = Helpers::try(fn () => $this->{$usersProperty});

        if (!$error):
            return $value;
        endif;

        /** @var UserRelationContract */
        $relation = app()->make(UserRelationContract::class);
        $relation->setIdsProperty($userIdsProperty)
            ->setUsersProperty($usersProperty)
            ->setAsMultiple($isMultiple);

        /** @var UserRelationLoaderContract */
        $relationLoader = app()->make(UserRelationLoaderContract::class);
        $relationLoader->addRelation($relation)
            ->setModels(collect([$this]))
            ->load();

        return $this->{$usersProperty};
    }
}