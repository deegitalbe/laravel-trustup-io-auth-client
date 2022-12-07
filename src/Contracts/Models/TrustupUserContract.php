<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models;

use Illuminate\Support\Collection;
use Deegitalbe\LaravelTrustupIoAuthClient\Enums\Role;

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