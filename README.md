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
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\Relations\User\TrustupUserRelationContract;

class Post extends Model implements TrustupUserRelatedModelContract
{
    use IsTrustupUserRelatedModel;

    /**
     * Related contributors.
     * 
     * @return Collection<int, TrustupUserContract>
     */
    public Collection $contributors;

    /**
     * Related creator.
     * 
     * @return ?UserContract
     */
    public ?UserContract $creator;

    protected $fillable = [
        'contributor_ids'
        'creator_id'
    ];

    protected $casts =[
        'contributor_ids' => AsCollection::class,
    ];

    /**
     * Defining contributors relation.
     * 
     * @return TrustupUserRelationContract
     */
    public function trustupContributors(): TrustupUserRelationContract
    {
        return $this->hasManyTrustupUsers('contributor_ids');
    }

    /**
     * Defining contributors relation.
     * 
     * @return TrustupUserRelationContract
     */
    public function trustupCreator(): TrustupUserRelationContract
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
        return $this->getTrustupUsers('trustupContributors');
    }

    /**
     * Getting related contributors.
     * 
     * @return ?UserContract
     */
    public function getCreator(): ?UserContract
    {
        return $this->getTrustupUsers('trustupCreator');
    }
}
```

### Exposing your models by creating a resource (optional)
If you wanna expose your model, here is an example resource based on previous section model
```php
<?php

namespace App\Http\Resources;

use Deegitalbe\LaravelTrustupIoAuthClient\Resources\TrustupUserResource;
use Deegitalbe\LaravelTrustupIoAuthClient\Resources\TrustupUserRelatedResource;

class PostResource extends TrustupUserRelatedResource
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
            'contributors' => TrustupUserResource::collection($this->whenTrustupUsersLoaded('trustupContributors')),
            'creator' => new TrustupUserResource($this->whenTrustupUsersLoaded('trustupCreator'))
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
interface TrustupUserContract
{
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
```
