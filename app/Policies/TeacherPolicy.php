<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Teacher;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeacherPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Teacher');
    }

    public function view(AuthUser $authUser, Teacher $teacher): bool
    {
        return $authUser->can('View:Teacher');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Teacher');
    }

    public function update(AuthUser $authUser, Teacher $teacher): bool
    {
        return $authUser->can('Update:Teacher');
    }

    public function delete(AuthUser $authUser, Teacher $teacher): bool
    {
        return $authUser->can('Delete:Teacher');
    }

}