<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Traits\Collections;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Deegitalbe\LaravelTrustupIoAuthClient\Traits\IsTrustupUserRelated;

trait IsTrustupUserRelatedCollection
{
    use IsTrustupUserRelated;

    /**
     * Getting related models.
     * 
     * @return Collection<int, Model>
     */
    public function getTrustupUserRelatedModels(): Collection
    {
        return $this;
    }
}