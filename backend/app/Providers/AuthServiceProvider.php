<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\VirtualMachine;
use App\Policies\VirtualMachinePolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        VirtualMachine::class => VirtualMachinePolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}