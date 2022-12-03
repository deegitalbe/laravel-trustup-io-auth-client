<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Models\Relations\User;

use Illuminate\Support\Str;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\Relations\User\TrustupUserRelationContract;

class TrustupUserRelation implements TrustupUserRelationContract
{
    protected string $idsProperty;
    protected string $usersProperty;
    protected bool $multiple = true;

    public function getIdsProperty(): string
    {
        return $this->idsProperty;
    }
    
    /** @return static */
    public function setIdsProperty(string $property): TrustupUserRelationContract
    {
        $this->idsProperty = $property;

        return $this;
    }
    
    public function getUsersProperty(): string
    {
        return $this->usersProperty ??
            $this->usersProperty = Str::plural(str_replace("_id" . ($this->multiple ? "s": ""), "", $this->idsProperty));
    }

    /** @return static */
    public function setUsersProperty(string $property): TrustupUserRelationContract
    {
        $this->usersProperty = $property;

        return $this;
    }

    /** @return static */
    public function setMultiple(bool $isMultiple = true): TrustupUserRelationContract
    {
        $this->multiple = $isMultiple;

        return $this;
    }

    public function isMultiple(): bool
    {
        return $this->multiple;
    }
}