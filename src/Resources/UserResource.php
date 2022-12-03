<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Deegitalbe\LaravelTrustupIoAuthClient\Enums\Role;
use Deegitalbe\LaravelTrustupIoAuthClient\Contracts\Models\TrustupUserContract;

class UserResource extends JsonResource
{
    /**
     * Related Resource.
     * 
     * @var TrustupUserContract
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->resource->getId(),
            "avatar" => $this->resource->getAvatar(),
            "avatar_base64" => $this->resource->getBase64Avatar(),
            "first_name" => $this->resource->getFirstName(),
            "last_name" => $this->resource->getLastName(),
            "email" => $this->resource->getEmail(),
            "phone" => $this->resource->getPhoneNumber(),
            "locale" => $this->resource->getLocale(),
            "roles" => $this->resource->getRoles()->map(fn (Role $role) => $role->value)->all(),
        ];
    }
}