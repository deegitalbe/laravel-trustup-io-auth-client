<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Deegitalbe\LaravelTrustupIoAuthClient\Traits\Resource\IsTrustupUserRelatedResource;

class TrustupUserRelatedResource extends JsonResource
{
    use IsTrustupUserRelatedResource;
}