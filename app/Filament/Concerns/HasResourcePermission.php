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
        return auth()->user()?->can('ViewAny:' . static::permissionBase()) ?? false;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canViewAny();
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('Create:' . static::permissionBase()) ?? false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('Update:' . static::permissionBase()) ?? false; 
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('Delete:' . static::permissionBase()) ?? false;
    }
    
}
