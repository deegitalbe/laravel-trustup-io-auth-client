<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Collections\TrustupUserRelatedCollection;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\UserContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Api\Endpoints\Auth\UserEndpointContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Collections\TrustupUserRelatedCollection\UserRelationContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Collections\TrustupUserRelatedCollection\UserRelationLoaderContract;

class UserRelationLoader implements UserRelationLoaderContract
{
    protected UserEndpointContract $endpoint;

    /** @var Collection<int, UserRelationContract> */
    protected Collection $relations;

    /** @var Collection<int, Model> */
    protected Collection $models;

    /**
     * User ids related to this collection as a map.
     * 
     * Key is user id and value is boolean.
     * 
     * @var Collection<int, bool>
     */
    protected Collection $userIdsMap;

    /**
     * Users related to this collection as a map.
     * 
     * Key is user id and value is user.
     * 
     * @var Collection<int, UserContract>
     */
    protected Collection $usersMap;

    public function __construct(UserEndpointContract $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /** @return static */
    public function addRelation(UserRelationContract $relation): UserRelationLoaderContract
    {
        $this->getRelations()->push($relation);

        return $this;
    }

    /**
     * Loading several user relations at once.
     * 
     * @param Collection<int, UserRelationContract> $relations
     * @return static
     */
    public function addRelations(Collection $relations): UserRelationLoaderContract
    {
        $this->getRelations()->push(...$relations);
        
        return $this;
    }

    /**
     * @param Collection<int, Model>
     * @return static
     */
    public function setModels(Collection $models): UserRelationLoaderContract
    {
        $this->models = $models;

        return $this;
    }

    /** @return static */
    public function load(): UserRelationLoaderContract
    {
        $this->models->each(fn (Model $model) =>
            $this->getRelations()->each(fn (UserRelationContract $relation) =>
                $this->setModelRelation($model, $relation)    
            )
        );

        return $this;
    }

    /** @return Collection<int UserRelationContract> */
    public function getRelations(): Collection
    {
        return $this->relations ??
            $this->relations = collect();
    }

    /**
     * @return Collection<int, Model>
     */
    public function getModels(): Collection
    {
        return $this->models;
    }

    protected function setModelRelation(Model $model, UserRelationContract $relation): void
    {
        $users = $this->getModelRelationIds($model, $relation)
            ->reduce(fn (Collection $users, int $userId) =>
                ($user = $this->getUsersMap()[$userId] ?? null) ?
                    $users->push($user)
                    : $users,
                collect()
            );
        
        $model->{$relation->getUsersProperty()} = $relation->isMultiple() ?
            $users
            : $users->first();
    }

    /** @return Collection<int, int> */
    protected function getModelRelationIds(Model $model, UserRelationContract $relation): Collection
    {
        $ids = $model->{$relation->getIdsProperty()};

        if (!$ids) return collect();

        if (!$relation->isMultiple()):
            return collect([$ids]);
        endif;

        return $ids instanceof Collection ?
            $ids
            : collect($ids);
    }

    /**
     * Getting users id map.
     * 
     * Key is user id and value is boolean.
     * 
     * @return Collection<int, bool>
     */
    protected function getUserIdsMap(): Collection
    {
        if (isset($this->userIdsMap)) return $this->userIdsMap;

        return $this->userIdsMap = $this->models->reduce(fn (Collection $map, Model $model) =>
            tap($map, fn () =>
                $this->getRelations()->each(fn (UserRelationContract $relation) => 
                    $this->getModelRelationIds($model, $relation)
                        ->each(fn (int $userId) => $map[$userId] = true)
                )
            ),
            collect()
        );
    }

    protected function getUsersMap(): Collection
    {
        if (isset($this->usersMap)) return $this->usersMap;

        $users = $this->endpoint->byIds(
            $this->getUserIdsMap()->keys()
        );

        return $this->usersMap = $users->reduce(fn (Collection $map, UserContract $user) =>
            tap($map, fn () =>
                $map[$user->getId()] = $user
            ),
            collect()
        );
    }
}