<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Data;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DataResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DataResource\RelationManagers;
use App\Models\Desa;
use App\Models\Kecamatan;

use function Laravel\Prompts\select;

class DataResource extends Resource
{
    protected static ?string $model = Data::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(4)
            ->schema([
                Section::make('Data Diri')
                    ->columnSpan(2)
                    ->schema([
                        TextInput::make('no_kk')
                            ->label('Nomor KK')
                            ->numeric()
                            ->required(),
                        TextInput::make('nik')
                            ->label('Nomor Induk Kependudukan')
                            ->numeric()
                            ->required(),
                        TextInput::make('tempat_lahir')
                            ->label('Tempat Lahir')
                            ->required(),
                        DatePicker::make('tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->required(),
                        Select::make('jenis_kelamin')
                            ->label('Jenis Kelamin')
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan'
                            ])
                            ->required(),
                        Select::make('agama')
                            ->label('Agama')
                            ->options([
                                'islam' => 'Islam',
                                'kristen protestan' => 'Kristen Protestan',
                                'kristen katolik' => 'Kristen Katolik',
                                'hindu' => 'Hindu',
                                'buddha' => 'Buddha',
                                'khonghucu' => 'Khonghucu'
                            ])
                            ->required(),
                    ]),
                Section::make('Alamat Asal')
                    ->columnSpan(1)
                    ->schema([
                        TextInput::make('kabupaten_asal')
                            ->label('Kabupaten Asal')
                            ->default('Kepulauan Meranti')
                            ->disabled()
                            ->required(),
                        Select::make('kecamatan_asal_id')
                            ->label('Kecamatan Asal')
                            ->dehydrated()
                            ->required()
                            ->options(fn(Get $get): Collection => Kecamatan::query()
                                ->orderBy('name')
                                ->pluck('name', 'id')),
                        Select::make('desa_asal_id')
                            ->label('Desa Asal')
                            ->dehydrated()
                            ->required()
                            ->options(fn(Get $get): Collection => Desa::query()
                                ->where('kecamatan_id', $get('kecamatan_asal_id'))
                                ->orderBy('name')
                                ->pluck('name', 'id')),
                    ]),
                Section::make('Alamat Tujuan')
                    ->columnSpan(1)
                    ->schema([
                        TextInput::make('kabupaten_tujuan')
                            ->label('Kabupaten Tujuan')
                            ->default('Kepulauan Meranti')
                            ->disabled()
                            ->required()
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListData::route('/'),
            'create' => Pages\CreateData::route('/create'),
            'edit' => Pages\EditData::route('/{record}/edit'),
        ];
    }
}
