<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Traits\Models;

use Illuminate\Support\Str;
use Henrotaym\LaravelHelpers\Facades\Helpers;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Collections\TrustupUserRelatedCollection\UserRelationContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Collections\TrustupUserRelatedCollection\UserRelationLoaderContract;

trait IsTrustupUserRelatedModel
{
    /**
     * Getting trustup user relation.
     * 
     * @param string $userIdsProperty Property containing user ids.
     * @param string $usersProperty Property where you would like to set users.
     * @return UserContract|null|Collection<int, UserContract>
     */
    public function getTrustupUserRelation(string $userIdsProperty, bool $isMultiple = true, string $usersProperty = null): mixed
    {
        [$error, $value] = Helpers::try(fn () => $this->{$usersProperty});

        if (!$error):
            return $value;
        endif;

        $usersProperty = $usersProperty ?:
            Str::plural(str_replace("_ids", "", $userIdsProperty));

        /** @var UserRelationContract */
        $relation = app()->make(UserRelationContract::class);
        $relation->setIdsProperty($userIdsProperty)
            ->setUsersProperty($usersProperty)
            ->setAsMultiple($isMultiple);

        /** @var UserRelationLoaderContract */
        $relationLoader = app()->make(UserRelationLoaderContract::class);
        $relationLoader->addRelation($relation)
            ->setModels(collect($this))
            ->load();

        return $this->{$usersProperty};
    }
}