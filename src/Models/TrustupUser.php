<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Models;

use Illuminate\Support\Collection;
use Deegitalbe\LaravelTrustupIoAuthClient\Enums\Role;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\TrustupUserContract;

class TrustupUser implements TrustupUserContract
{
    protected int $id;
    protected string $avatar;
    protected string $avatar_base64;
    protected string $first_name;
    protected string $last_name;
    protected string $email;
    protected ?string $phone;
    protected string $locale;
    protected Collection $roles;

    /**
     * Getting user id.
     * 
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Getting avatar as url.
     * 
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->avatar;
    }

    /**
     * Getting avatar as base64.
     * 
     * @return string
     */
    public function getBase64Avatar(): string
    {
        return $this->avatar_base64;
    }

    /**
     * Getting first name.
     * 
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * Getting last name.
     * 
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * Getting email.
     * 
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Getting phone number (international format without country prefix)
     * 
     * @return string
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phone;
    }

    /**
     * Getting user locale.
     * 
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * Getting user roles.
     * 
     * @return Collection<int, Role>
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    /**
     * Telling if user is containing given role.
     * 
     * @param Role $role Role to check for
     * @return bool
     */
    public function hasRole(Role $role): bool
    {
        return !!$this->roles->first(fn (Role $role) => $role === $role);
    }

    /**
     * Telling if user is containing any of given roles.
     * 
     * @param Collection<int, Role> $roles Roles to check for
     * @return bool
     */
    public function hasAnyRole(Collection $roles): bool
    {
        return !!$roles->first(fn (Role $role) => $this->hasRole($role));
    }

    /**
     * Telling if user is containing all given roles.
     * 
     * @param Collection<int, Role> $roles Roles to check for
     * @return bool
     */
    public function hasRoles(Collection $roles): bool
    {
        foreach ($roles as $role):
            if (!$this->hasRole($role)):
                return false;
            endif;
        endforeach;

        return true;
    }

    /**
     * Filling up model attributes.
     * 
     * @param array<string, mixed> $attributes
     * @return static
     */
    public function fill(array $attributes): TrustupUserContract
    {
        $this->id = $attributes['id'];
        $this->avatar = $attributes['avatar'];
        $this->avatar_base64 = $attributes['avatar_base64'];
        $this->first_name = $attributes['first_name'];
        $this->last_name = $attributes['last_name'];
        $this->email = $attributes['email'];
        $this->phone = $attributes['phone'];
        $this->locale = $attributes['locale'];
        $this->roles = collect($attributes['roles'])->map(fn (string $role) => Role::from($role));

        return $this;
    }
}