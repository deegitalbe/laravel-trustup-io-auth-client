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

### Usage

```php
<?php
use Deegitalbe\LaravelTrustupIoAuthClient\Enums\Role;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Deegitalbe\LaravelTrustupIoAuthClient\Resources\UserResource;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\TrustupUserContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Api\Endpoints\Auth\UserEndpointContract;

$endpoint = app()->make(UserEndpointContract::class);
$devs = $endpoint->developers();   // Collection<int, TrustupUserContract>
$resources = UserResource::collection($devs) // AnonymousResourceCollection<int, UserResource> (API resource for your responses)
$devs->first()->getFirstName(); // Mathieu
$devs->first()->hasRole(Role::TRANSLATOR) // false
```

### References
#### Endpoint

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

#### Model
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
