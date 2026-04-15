<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\TeacherAdministration;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeacherAdministrationPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:TeacherAdministration');
    }

    public function view(AuthUser $authUser, TeacherAdministration $teacherAdministration): bool
    {
        return $authUser->can('View:TeacherAdministration');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:TeacherAdministration');
    }

    public function update(AuthUser $authUser, TeacherAdministration $teacherAdministration): bool
    {
        return $authUser->can('Update:TeacherAdministration');
    }

    public function delete(AuthUser $authUser, TeacherAdministration $teacherAdministration): bool
    {
        return $authUser->can('Delete:TeacherAdministration');
    }

}