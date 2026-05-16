<?php

namespace App\Filament\Resources\Teachers\Pages;

use App\Filament\Resources\Teachers\TeacherResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditTeacher extends EditRecord
{
    protected static string $resource = TeacherResource::class;

    /**
     * Pastikan teacher hanya bisa mengedit data dirinya sendiri.
     * Admin dengan permission Update:Teacher tetap bisa edit siapa saja.
     */
    protected function authorizeAccess(): void
    {
        parent::authorizeAccess();

        $user = auth()->user();
        $record = $this->getRecord();

        // Jika user punya permission full Update:Teacher, boleh edit siapa saja
        if ($user->can('Update:Teacher')) {
            return;
        }

        // Jika user adalah teacher, hanya boleh edit data sendiri
        if ($user->hasRole('Teacher')) {
            $teacher = $user->teacher;
            if (!$teacher || $record->getKey() !== $teacher->id) {
                abort(403, 'Anda hanya dapat mengedit data Anda sendiri.');
            }
            return;
        }

        abort(403);
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
