<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Collections\TrustupUserRelatedCollection;

use Illuminate\Support\Str;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Collections\TrustupUserRelatedCollection\UserRelationContract;

class UserRelation implements UserRelationContract
{
    protected string $idsProperty;
    protected string $usersProperty;
    protected bool $multiple = true;

    public function getIdsProperty(): string
    {
        return $this->idsProperty ??
            $this->idsProperty = Str::plural(str_replace("_id" . ($this->multiple ? "s": ""), "", $this->idsProperty));
    }
    
    /** @return static */
    public function setIdsProperty(string $property): UserRelationContract
    {
        $this->idsProperty = $property;

        return $this;
    }
    
    public function getUsersProperty(): string
    {
        return $this->usersProperty;
    }

    /** @return static */
    public function setUsersProperty(string $property): UserRelationContract
    {
        $this->usersProperty = $property;

        return $this;
    }

    /** @return static */
    public function setAsMultiple(bool $isMultiple = true): UserRelationContract
    {
        $this->multiple = $isMultiple;

        return $this;
    }

    public function isMultiple(): bool
    {
        return $this->multiple;
    }
}