<?php

namespace App\Filament\Concerns;

trait HasResourcePermission
{
    protected static function permissionBase(): string
    {
        return static::$permissionBase ?? static::getModel()::class;
    }

    public static function canViewAny(): bool
    {
        $user = auth()->user();
        if (!$user) return false;

        // Teacher boleh akses resource Teacher (untuk edit data sendiri via URL)
        if (static::permissionBase() === 'Teacher' && $user->hasRole('Teacher')) {
            return true;
        }


        return $user->can('ViewAny:' . static::permissionBase());
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        if (!$user) return false;

        // Teacher TIDAK perlu melihat menu Teacher di sidebar
        // (akses via tombol "Edit Data Saya" di user menu)
        if (static::permissionBase() === 'Teacher' && $user->hasRole('Teacher')
            && !$user->can('ViewAny:Teacher')) {
            return false;
        }

        return static::canViewAny();
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('Create:' . static::permissionBase()) ?? false;
    }

    public static function canEdit($record): bool
    {
        $user = auth()->user();
        if (!$user) return false;

        // Teacher boleh edit data dirinya sendiri
        if (static::permissionBase() === 'Teacher' && $user->hasRole('Teacher')) {
            $teacher = $user->teacher;
            if ($teacher && $record->getKey() === $teacher->id) {
                return true;
            }
        }

        return $user->can('Update:' . static::permissionBase());
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('Delete:' . static::permissionBase()) ?? false;
    }
    
}
