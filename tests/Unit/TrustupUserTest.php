<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Tests\Unit;

use Deegitalbe\LaravelTrustupIoAuthClient\Tests\TestCase;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\TrustupUserContract;

class TrustupUserTest extends TestCase
{
    public function test_it_fills_a_user_whose_avatar_copy_is_null()
    {
        $user = $this->app->make(TrustupUserContract::class)->fill($this->attributes(['avatar_base64' => null]));

        $this->assertNull($user->getBase64Avatar());
    }

    public function test_it_fills_a_user_without_avatar_copy()
    {
        $attributes = $this->attributes();
        unset($attributes['avatar_base64']);

        $user = $this->app->make(TrustupUserContract::class)->fill($attributes);

        $this->assertNull($user->getBase64Avatar());
    }

    public function test_it_keeps_the_avatar_copy()
    {
        $user = $this->app->make(TrustupUserContract::class)->fill($this->attributes());

        $this->assertSame('data:image/jpeg;base64,YXZhdGFy', $user->getBase64Avatar());
    }

    private function attributes(array $overrides = []): array
    {
        return array_merge([
            'id' => 1,
            'avatar' => 'https://www.trustup.be/images/users/1/avatar',
            'avatar_base64' => 'data:image/jpeg;base64,YXZhdGFy',
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane@example.com',
            'phone' => null,
            'international_phone' => null,
            'locale' => 'be-fr',
            'slack_id' => null,
            'roles' => [],
        ], $overrides);
    }
}
