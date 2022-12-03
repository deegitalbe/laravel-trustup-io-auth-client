<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Models\Relations\User;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\TrustupUserContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Api\Endpoints\Auth\UserEndpointContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\Relations\User\TrustupUserRelationContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\Relations\User\TrustupUserRelationLoaderContract;

class TrustupUserRelationLoader implements TrustupUserRelationLoaderContract
{
    protected UserEndpointContract $endpoint;

    /** @var Collection<int, TrustupUserRelationContract> */
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
     * @var Collection<int, TrustupUserContract>
     */
    protected Collection $usersMap;

    public function __construct(UserEndpointContract $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /** @return static */
    public function addRelation(TrustupUserRelationContract $relation): TrustupUserRelationLoaderContract
    {
        $this->getRelations()->push($relation);

        return $this;
    }

    /**
     * Loading several user relations at once.
     * 
     * @param Collection<int, TrustupUserRelationContract> $relations
     * @return static
     */
    public function addRelations(Collection $relations): TrustupUserRelationLoaderContract
    {
        $this->getRelations()->push(...$relations);
        
        return $this;
    }

    /**
     * @param Collection<int, Model>
     * @return static
     */
    public function setModels(Collection $models): TrustupUserRelationLoaderContract
    {
        $this->models = $models;

        return $this;
    }

    /** @return static */
    public function load(): TrustupUserRelationLoaderContract
    {
        $this->models->each(fn (Model $model) =>
            $this->getRelations()->each(fn (TrustupUserRelationContract $relation) =>
                $this->setModelRelation($model, $relation)    
            )
        );

        return $this;
    }

    /** @return Collection<int TrustupUserRelationContract> */
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

    protected function setModelRelation(Model $model, TrustupUserRelationContract $relation): void
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
    protected function getModelRelationIds(Model $model, TrustupUserRelationContract $relation): Collection
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
                $this->getRelations()->each(fn (TrustupUserRelationContract $relation) => 
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

        return $this->usersMap = $users->reduce(fn (Collection $map, TrustupUserContract $user) =>
            tap($map, fn () =>
                $map[$user->getId()] = $user
            ),
            collect()
        );
    }
}