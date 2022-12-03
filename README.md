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

use Illuminate\Database\Eloquent\Model;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\TrustupUserRelatedModelContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Traits\Models\IsTrustupUserRelatedModel;
use Illuminate\Support\Collection;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\TrustupUserContract;
use Illuminate\Database\Eloquent\Casts\AsCollection;
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

### Exposing your models by creating a resource(optional)
If you wanna expose your model, here is an example resource based on previous section model
```php
<?php

namespace App\Http\Resources;

use App\Models\Post;
use Deegitalbe\LaravelTrustupIoAuthClient\Resources\TrustupUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends TrustupUserRelatedResource
{
    /** @var Post */
    public $resource;

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
            'contributors' => TrustupUserResource::collection($this->resource->getContributors()),
            'creator' => $this->whenTrustupUsersLoaded('trustupCreator', fn () => $this->resource->getCreator())
        ];
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
