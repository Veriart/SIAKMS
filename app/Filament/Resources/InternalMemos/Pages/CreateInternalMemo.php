<?php

namespace App\Filament\Resources\InternalMemos\Pages;

use App\Filament\Resources\InternalMemos\InternalMemoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInternalMemo extends CreateRecord
{
    protected static string $resource = InternalMemoResource::class;
}
