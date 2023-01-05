<?php
namespace Deegitalbe\LaravelTrustupIoAuthClient\Exceptions;

use Deegitalbe\LaravelTrustupIoAuthClient\Facades\Package;
use Exception;

class MissingNewRoleException extends Exception
{
    protected string $message = "Package [Deegitalbe\LaravelTrustupIoAuthClient] is missing a new role.";
    
    /**
     * Role missing.
     * 
     * @return string
     */
    protected string $missingRole;

    /**
     * Setting missing role.
     * 
     * @param string $role
     * @return self
     */
    public function setRole(string $missingRole): self
    {
        $this->missingRole = $missingRole;

        return $this;
    }

    /**
     * Getting related context.
     * 
     * @return array
     */
    public function context(): array
    {
        return [
            'missing_role' => $this->missingRole,
            'package_version' => Package::getVersion()
        ];
    }
}