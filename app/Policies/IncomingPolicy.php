<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IncomingPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function updateStatusDisposisi(User $user)
    {
        return $user->role === 'admin'; // Hanya admin yang diizinkan
    }

    
}
