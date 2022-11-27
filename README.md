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
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\UserContract;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Api\Endpoints\Auth\UserEndpointContract;

$endpoint = app()->make(UserEndpointContract::class);
$devs = $endpoint->developers();   // Collection<int, UserContract>
$devs->first()->getFirstName(); // Mathieu
$devs->first()->hasRole(Role::TRANSLATOR) // false
```
