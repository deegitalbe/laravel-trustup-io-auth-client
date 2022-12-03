<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Collections;

/**
 * Representing a collection containing trustup users.
 */
interface TrustupUserRelatedCollectionContract
{
    /**
     * Loading given user relations.
     * @param string $relationNames relation names to load.
     * @return static
     */
    public function loadTrustupUsers(...$relationNames): TrustupUserRelatedCollectionContract;
}