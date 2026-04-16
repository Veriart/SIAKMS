<?php

namespace App\Filament\Resources\ActivityInformations\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ActivityInformationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Kegiatan')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('execution_date')
                    ->label('Tanggal Pelaksanaan')
                    ->native(false)
                    ->displayFormat('l, d F Y')
                    ->required(),
                TextInput::make('execution_place')
                    ->label('Tempat Pelaksanaan')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('document_file')
                    ->label('Dokumen')
                    ->directory('activity-informations')
                    ->disk('public')
                    ->acceptedFileTypes(['application/pdf', 'image/*', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                    ->maxSize(5120),
            ]);
    }
}
