<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Classroom;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClassroomPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Classroom');
    }

    public function view(AuthUser $authUser, Classroom $classroom): bool
    {
        return $authUser->can('View:Classroom');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Classroom');
    }

    public function update(AuthUser $authUser, Classroom $classroom): bool
    {
        return $authUser->can('Update:Classroom');
    }

    public function delete(AuthUser $authUser, Classroom $classroom): bool
    {
        return $authUser->can('Delete:Classroom');
    }

}