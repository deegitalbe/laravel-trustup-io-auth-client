<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Traits\Collections;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Deegitalbe\LaravelTrustupIoAuthClient\Traits\IsTrustupUserRelated;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Collections\TrustupUserRelatedCollectionContract;

trait IsTrustupUserRelatedCollection
{
    use IsTrustupUserRelated;

    /**
     * Loading given user relations.
     * @param string $relationNames relation names to load.
     * @return static
     */
    public function loadTrustupUsers(...$relationNames): TrustupUserRelatedCollectionContract
    {
        if ($this->isEmpty()) return $this;

        return $this->loadTrustupUserRelations($this->first()->getTrustupUserRelationCollection($relationNames));
    }

    /**
     * Getting related models.
     * 
     * @return Collection<int, Model>
     */
    protected function getTrustupUserRelatedModels(): Collection
    {
        return $this;
    }
}