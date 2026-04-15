<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\AcademicAdministration;
use Illuminate\Auth\Access\HandlesAuthorization;

class AcademicAdministrationPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:AcademicAdministration');
    }

    public function view(AuthUser $authUser, AcademicAdministration $academicAdministration): bool
    {
        return $authUser->can('View:AcademicAdministration');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:AcademicAdministration');
    }

    public function update(AuthUser $authUser, AcademicAdministration $academicAdministration): bool
    {
        return $authUser->can('Update:AcademicAdministration');
    }

    public function delete(AuthUser $authUser, AcademicAdministration $academicAdministration): bool
    {
        return $authUser->can('Delete:AcademicAdministration');
    }

}