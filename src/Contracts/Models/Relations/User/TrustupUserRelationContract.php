<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\Relations\User;

interface TrustupUserRelationContract
{
    /**
     * Getting model property name where user ids are stored.
     * 
     * @return string
     */
    public function getIdsProperty(): string;
    
    /**
     * Setting model property name where user ids are stored.
     * 
     * @param string $property
     * @return static
     */
    public function setIdsProperty(string $property): TrustupUserRelationContract;
    
    /**
     * Getting model property name where users are stored.
     * 
     * @return string
     */
    public function getUsersProperty(): string;

    /**
     * Setting model property name where user are stored.
     * 
     * @param string $property
     * @return static
     */
    public function setUsersProperty(string $property): TrustupUserRelationContract;

    /**
     * Setting if related users are a collection or a single model.
     * 
     * @param bool $isMultiple if true => collection, else => single user
     * @return static
     */
    public function setMultiple(bool $isMultiple = true): TrustupUserRelationContract;

    /**
     * Telling if related users is a collection or a single user.
     */
    public function isMultiple(): bool;
}