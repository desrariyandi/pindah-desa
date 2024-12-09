<?php

namespace App\Filament\Resources;

use stdClass;
use Filament\Forms;
use App\Models\Desa;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Kecamatan;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('kecamatan_id')
                            ->label('Kecamatan')
                            ->searchable()
                            ->live()
                            ->options(fn(Get $get): Collection => Kecamatan::query()
                                ->orderBy('name')
                                ->pluck('name', 'id')),
                        Select::make('desa_id')
                            ->label('Desa/Kelurahan')
                            ->searchable()
                            ->options(fn(Get $get): Collection => Desa::query()
                                ->where('kecamatan_id', $get('kecamatan_id'))
                                ->orderBy('name')
                                ->pluck('name', 'id'))
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                $desa = Desa::find($state);
                                if ($desa) {
                                    $set('name', $desa->name);
                                }
                            }),
                        TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->revealable()
                            ->maxLength(255)
                            ->dehydrated(fn(?string $state): bool => filled($state))
                            ->required(fn(string $operation): bool => $operation === 'create')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(Set $set, ?string $state) => $set('password_string', $state)),
                        TextInput::make('confirmation')
                            ->label('Konfirmasi Password')
                            ->same('password')
                            ->revealable()
                            ->password()
                            ->required(fn(string $operation): bool => $operation === 'create')
                            ->visible(fn(Get $get): bool => filled($get('password')))
                            ->maxLength(255),
                        Select::make('roles')
                            ->label('Level User')
                            ->forceSearchCaseInsensitive()
                            ->required()
                            ->relationship('roles', 'name'),
                        DateTimePicker::make('email_verified_at')
                            ->label('Verifikasi email')
                            ->default(now())
                            ->visibleOn('edit'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')
                    ->label('No')
                    ->state(
                        static function (HasTable $livewire, stdClass $rowLoop): string {
                            return (string) ($rowLoop->iteration +
                                ($livewire->getTableRecordsPerPage() * ($livewire->getTablePage() - 1
                                ))
                            );
                        }
                    ),
                TextColumn::make('name')
                    ->label('Nama')
                    ->sortable()
                    ->forceSearchCaseInsensitive()
                    ->searchable(),
                TextColumn::make('roles.name')
                    ->label('Level User'),
                TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
