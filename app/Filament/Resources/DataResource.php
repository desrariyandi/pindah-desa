<?php

namespace App\Filament\Resources;

use stdClass;
use Filament\Forms;
use App\Models\Data;
use App\Models\Desa;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use App\Models\Kecamatan;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use function Laravel\Prompts\select;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use function Laravel\Prompts\textarea;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;

use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DataResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DataResource\RelationManagers;

class DataResource extends Resource
{
    protected static ?string $model = Data::class;
    protected static ?string $modelLabel = 'Pindah Alamat';
    protected static ?string $navigationLabel = 'Pindah Alamat';
    protected static ?string $slug = 'pindah-alamat';
    protected static ?string $recordTitleAttribute = 'nama';
    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';
    protected static ?int $navigationSort = 1;

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
                        TextInput::make('nama')
                            ->label('Nama')
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
                            ->readOnly()
                            ->required(),
                        Select::make('kecamatan_asal_id')
                            ->label('Kecamatan Asal')
                            ->dehydrated()
                            ->required()
                            ->live()
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
                        Textarea::make('alamat_asal')
                            ->label('Alamat Asal')
                            ->rows(12)
                            ->required()
                    ]),
                Section::make('Alamat Tujuan')
                    ->columnSpan(1)
                    ->schema([
                        TextInput::make('kabupaten_tujuan')
                            ->label('Kabupaten Tujuan')
                            ->default('Kepulauan Meranti')
                            ->readOnly()
                            ->required(),
                        Select::make('kecamatan_tujuan_id')
                            ->label('Kecamatan Tujuan')
                            ->dehydrated()
                            ->required()
                            ->live()
                            ->options(fn(Get $get): Collection => Kecamatan::query()
                                ->orderBy('name')
                                ->pluck('name', 'id')),
                        Select::make('desa_tujuan_id')
                            ->label('Desa Tujuan')
                            ->dehydrated()
                            ->required()
                            ->options(fn(Get $get): Collection => Desa::query()
                                ->where('kecamatan_id', $get('kecamatan_tujuan_id'))
                                ->orderBy('name')
                                ->pluck('name', 'id')),
                        Textarea::make('alamat_tujuan')
                            ->label('Alamat Tujuan')
                            ->required()
                            ->rows(12)
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')->state(
                    static function (HasTable $livewire, stdClass $rowLoop): string {
                        return (string) ($rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * ($livewire->getTablePage() - 1
                            ))
                        );
                    }
                ),
                TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->forceSearchCaseInsensitive(),
                TextColumn::make('alamat_asal')
                    ->label('Alamat Asal')
                    ->wrap()
                    ->formatStateUsing(function ($record) {
                        return "Kecamatan {$record->kecamatan_asal->name}, Desa/Kelurahan {$record->desa_asal->name}, {$record->alamat_asal}";
                    }),
                TextColumn::make('alamat_tujuan')
                    ->label('Alamat Tujuan')
                    ->wrap()
                    ->formatStateUsing(function ($record) {
                        return "Kecamatan {$record->kecamatan_tujuan->name}, Desa/Kelurahan {$record->desa_tujuan->name}, {$record->alamat_asal}";
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
