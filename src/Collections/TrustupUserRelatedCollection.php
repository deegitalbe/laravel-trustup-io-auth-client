<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Collections;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Deegitalbe\LaravelTrustupIoAuthClient\Traits\Collections\IsTrustupUserRelatedCollection;

/**
 * A custom model collection related to trustup users.
 */
class TrustupUserRelatedCollection extends EloquentCollection
{
    use IsTrustupUserRelatedCollection;
}