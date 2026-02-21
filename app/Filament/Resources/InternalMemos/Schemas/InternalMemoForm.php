<?php

namespace App\Filament\Resources\InternalMemos\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class InternalMemoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('ref')
                    ->label('No. Surat Referensi')
                    ->required(),
                TextInput::make('pic_name')
                    ->label('Nama PIC')
                    ->default(fn () => Auth::user()?->name)
                    ->required(),
                TextInput::make('reason')
                    ->label('Keterangan/Perihal')
                    ->required(),
                DatePicker::make('date')
                    ->label('Hari, Tanggal')
                    ->native(false) // WAJIB agar format bisa diubah
                    ->displayFormat('l, d F Y')
                    ->required(),
                TimePicker::make('time')
                    ->label('Waktu')
                    ->seconds(false)
                    ->required(),
                TextInput::make('place')
                    ->label('Tempat Pelaksanaan')
                    ->required(),
                TextInput::make('note')
                    ->label('Catatan')
                    ->required(),
                FileUpload::make('ref_file')
                    ->label('Referensi File')
                    ->directory('internal-memos')
                    ->disk('public')
                    ->required(),
            ]);
    }
}
