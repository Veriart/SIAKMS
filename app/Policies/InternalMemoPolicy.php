<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\InternalMemo;
use Illuminate\Auth\Access\HandlesAuthorization;

class InternalMemoPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:InternalMemo');
    }

    public function view(AuthUser $authUser, InternalMemo $internalMemo): bool
    {
        return $authUser->can('View:InternalMemo');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:InternalMemo');
    }

    public function update(AuthUser $authUser, InternalMemo $internalMemo): bool
    {
        return $authUser->can('Update:InternalMemo');
    }

    public function delete(AuthUser $authUser, InternalMemo $internalMemo): bool
    {
        return $authUser->can('Delete:InternalMemo');
    }

}