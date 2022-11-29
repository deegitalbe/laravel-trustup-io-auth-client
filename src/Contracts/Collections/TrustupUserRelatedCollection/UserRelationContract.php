<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Collections\TrustupUserRelatedCollection;

interface UserRelationContract
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
    public function setUserIdsProperty(string $property): UserRelationContract;
    
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
    public function setUsersProperty(string $property): UserRelationContract;

    /**
     * Setting if related users are a collection or single.
     * 
     * @param bool $isMultiple if true => collection, else => single user
     * @return static
     */
    public function setAsMultiple(bool $isMultiple = true): UserRelationContract;

    /**
     * Telling if related users is a collection or a single user.
     */
    public function isMultiple(): bool;
}