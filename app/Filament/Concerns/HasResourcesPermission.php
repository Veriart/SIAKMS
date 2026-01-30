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
        return auth()->user()?->can('view_any ' . static::permissionBase()) ?? false;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canViewAny();
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create ' . static::permissionBase()) ?? false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('update ' . static::permissionBase()) ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete ' . static::permissionBase()) ?? false;
    }
}
