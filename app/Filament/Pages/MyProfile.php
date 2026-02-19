<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Heroicon;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;

class MyProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-users';
    protected static ?string $title = 'My Profile';

    // INI KUNCI UTAMANYA
    protected string $view = 'filament.pages.my-profile';

    protected function getForms(): array
    {
        return [
            'form',
        ];
    }
    public function mount(): void
    {
        $this->form->fill([
            'name'  => auth()->user()->name,
            'email' => auth()->user()->email,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->model(auth()->user())
            ->schema([
                TextInput::make('name')
                    ->required(),

                TextInput::make('email')
                    ->email()
                    ->required(),

                TextInput::make('password')
                    ->password()
                    ->label('New Password')
                    ->dehydrated(fn ($state) => filled($state))
                    ->dehydrateStateUsing(
                        fn ($state) => filled($state) ? Hash::make($state) : null
                    ),
            ]);
    }

    public function save(): void
    {
        auth()->user()->update(
            array_filter($this->form->getState())
        );

        $this->notify('success', 'Profile updated');
    }
}
