# Laravel trustup io auth client

## Installation

### Require package

```shell
composer require deegitalbe/laravel-trustup-io-auth-client
```

### Add environment variables

```shell
TRUSTUP_IO_AUTHENTIFICATION_URL=
TRUSTUP_SERVER_AUTHORIZATION=
```

### Preparing your models (optional)
If you have relationships with trustup users, your model should look like this
```php
<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\TrustupUserContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Traits\Models\IsTrustupUserRelatedModel;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\TrustupUserRelatedModelContract;
use Deegitalbe\LaravelTrustupIoExternalModelRelations\Contracts\Models\Relations\ExternalModelRelationContract;

class Post extends Model implements TrustupUserRelatedModelContract
{
    use IsTrustupUserRelatedModel;

    /**
     * Getting external relation names.
     * 
     * @return array<int, string>
     */
    public function getExternalRelationNames(): array
    {
        return [
            'contributors',
            'creator'
        ]
    }

    /**
     * Defining contributors relation.
     * 
     * @return ExternalRelation
     */
    public function contributors(): ExternalModelRelationContract
    {
        return $this->hasManyTrustupUsers('contributor_ids');
    }

    /**
     * Defining contributors relation.
     * 
     * @return ExternalRelation
     */
    public function creator(): ExternalModelRelationContract
    {
        return $this->belongsToTrustupUser('creator_id');
    }

    /**
     * Getting related contributors.
     * 
     * @return Collection<int, TrustupUserContract>
     */
    public function getContributors(): Collection
    {
        return $this->getExternalModels('contributors');
    }

    /**
     * Getting related contributors.
     * 
     * @return ?UserContract
     */
    public function getCreator(): ?UserContract
    {
        return $this->getExternalModels('creator');
    }
}
```

### Exposing your models by creating a resource (optional)
If you wanna expose your model, here is an example resource based on previous section model
```php
<?php

namespace App\Http\Resources;

use Deegitalbe\LaravelTrustupIoAuthClient\Resources\TrustupUserResource;
use Deegitalbe\LaravelTrustupIoExternalModelRelations\Resources\ExternalModelRelatedResource;

class PostResource extends ExternalModelRelatedResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'text' => $this->text,
            'created_at' => $this->created_at,
            'contributors' => TrustupUserResource::collection($this->whenExternalRelationLoaded('trustupContributors')),
            'creator' => new TrustupUserResource($this->whenExternalRelationLoaded('trustupCreator'))
        ];
    }
}
```

### Eager load collections

Only one request will be performed even if you load multiple relations ⚡⚡⚡⚡

```php
use Illuminate\Routing\Controller;

class PostController extends Controller
{
    public function index() 
    {
        return PostResource::collection(Post::all()->loadTrustupUsers('trustupContributors', 'trustupCreator'));
    }
}
```


## Usage

### Endpoint
```php
<?php
use Illuminate\Support\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Deegitalbe\LaravelTrustupIoAuthClient\Enums\Role;
use Deegitalbe\LaravelTrustupIoAuthClient\Resources\TrustupUserResource;


$endpoint = app()->make(UserEndpointContract::class);
$devs = $endpoint->developers();   // Collection<int, TrustupUserContract>
$resources = TrustupUserResource::collection($devs) // AnonymousResourceCollection<int, TrustupUserResource> (API resource for your responses)
$devs->first()->getFirstName(); // Mathieu
$devs->first()->hasRole(Role::TRANSLATOR) // false
```

## References
### Endpoint

```php
interface UserEndpointContract
{
    /**
     * Getting trustup employees.
     * 
     * @return Collection<int, TrustupUserContract>
     */
    public function employees(): Collection;

    /**
     * Getting trustup developers.
     * 
     * @return Collection<int, TrustupUserContract>
     */
    public function developers(): Collection;

    /**
     * Getting trustup users matching given roles.
     * 
     * @param Collection<int, Role>
     * @return Collection<int, TrustupUserContract>
     */
    public function byRoles(Collection $roles): Collection;

    /**
     * Getting trustup users matching given ids.
     * 
     * @param Collection<int, Role>
     * @return Collection<int, int>
     */
    public function byIds(Collection $ids): Collection;
}
```

### Trustup user model
```php
interface TrustupUserContract extends ExternalModelContract, SlackNotifiableContract
{
    /**
     * Getting user key.
     * 
     * @return int
     */
    public function getKey(): int;

    /**
     * Getting user id.
     * 
     * @return int
     */
    public function getId(): int;

    /**
     * Getting avatar as url.
     * 
     * @return string
     */
    public function getAvatar(): string;

    /**
     * Getting avatar as base64.
     * 
     * @return string
     */
    public function getBase64Avatar(): string;

    /**
     * Getting first name.
     * 
     * @return string
     */
    public function getFirstName(): string;

    /**
     * Getting last name.
     * 
     * @return string
     */
    public function getLastName(): string;

    /**
     * Getting email.
     * 
     * @return string
     */
    public function getEmail(): string;

    /**
     * Getting phone number (international format without country prefix)
     * 
     * @return string
     */
    public function getPhoneNumber(): ?string;

    /**
     * Getting user locale.
     * 
     * @return string
     */
    public function getLocale(): string;

    /**
     * Getting user slack id.
     * 
     * @return ?string
     */
    public function getSlackId(): ?string;

    /**
     * Telling if having slack id.
     * 
     * @return bool
     */
    public function hasSlackId(): bool;

    /**
     * Getting user roles.
     * 
     * @return Collection<int, Role>
     */
    public function getRoles(): Collection;

    /**
     * Getting user raw roles (string directly returned by API)
     * 
     * @return Collection<int, string>
     */
    public function getRawRoles(): Collection;

    /**
     * Telling if user is containing given role.
     * 
     * @param Role $role Role to check for
     * @return bool
     */
    public function hasRole(Role $role): bool;

    /**
     * Telling if user is containing any of given roles.
     * 
     * @param Collection<int, Role> $roles Roles to check for
     * @return bool
     */
    public function hasAnyRole(Collection $roles): bool;

    /**
     * Telling if user is containing all given roles.
     * 
     * @param Collection<int, Role> $roles Roles to check for
     * @return bool
     */
    public function hasRoles(Collection $roles): bool;

    /**
     * Getting all attributes of user.
     * 
     * @return array
     */
    public function getAttributes(): array;

    /**
     * Filling up model attributes.
     * 
     * @param array<string, mixed> $attributes
     * @return static
     */
    public function fill(array $attributes): TrustupUserContract;
}
```

### Model related to trustup users
```php
<?php
/**
 * Representing a model related to trustup users.
 */
interface TrustupUserRelatedModelContract
{
    /**
     * Creating a new belongs to trustup user relation.
     * 
     * @param string $idProperty Model property containing related id.
     * @param string $userProperty Model property where related user should be stored.
     * @return ExternalModelRelationContract
     */
    public function belongsToTrustupUser(string $idProperty, string $userProperty = null): ExternalModelRelationContract;

     /**
     * Creating a new has many trustup users relation.
     * 
     * @param string $idsProperty Model property containing related ids.
     * @param string $usersProperty Model property where related users should be stored.
     * @return ExternalModelRelationContract
     */
    public function hasManyTrustupUsers(string $idsProperty, string $usersProperty = null): ExternalModelRelationContract;

    /**
     * Getting external models relation based on given relation name.
     * 
     * You can expect ExternalModelContract|null for non-multiple relation or Collection<int, ExternalModelContract> for multiple relation.
     * 
     * @param string $relation Relation name to get
     * @return ?ExternalModelContract|Collection<int, ExternalModelContract>
     */
    public function getExternalModels(string $relationName): mixed;

    /**
     * Loading external relations based on given relation names.
     * 
     * @param string $relationNames relation names to load.
     * @return static
     */
    public function loadExternalRelations(...$relationNames): ExternalModelRelatedModelContract;

    /**
     * Creating a new belongs to external models relation.
     * 
     * @param ExternalModelRelationLoadingCallbackContract $callback Callback able to load related models
     * @param string $idProperty Model property containing related id.
     * @param string $externalModelProperty Model property where related user should be stored.
     * @return ExternalModelRelationContract
     */
    public function belongsToExternalModel(ExternalModelRelationLoadingCallbackContract $callback, string $idProperty, string $externalModelProperty = null): ExternalModelRelationContract;

     /**
     * Creating a new has many external models relation.
     * 
     * @param ExternalModelRelationLoadingCallbackContract $callback Callback able to load related models
     * @param string $idsProperty Model property containing external model ids.
     * @param string $externalModelsProperty Model property where related users should be stored.
     * @return ExternalModelRelationContract
     */
    public function hasManyExternalModels(ExternalModelRelationLoadingCallbackContract $callback, string $idsProperty, string $externalModelsProperty = null): ExternalModelRelationContract;

    /**
     * Telling if given external relation is loaded.
     * 
     * @param string $relationName Relation name to check.
     * @return bool
     */
    public function externalRelationLoaded(string $relationName): bool;

    /**
     * Getting external relations from given names.
     * 
     * @param array $relationNames Relation names to get
     * @return Collection<int, ExternalModelRelationContract>
     */
    public function getExternalRelationsCollection(array $relationNames): Collection;

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return ExternalModelRelatedCollectionContract
     */
    public function newCollection(array $models = []);
}
```
