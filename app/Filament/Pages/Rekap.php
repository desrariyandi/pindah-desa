<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Rekap extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 2;
    protected static ?string $title = 'Cetak';
    protected ?string $heading = 'Cetak';
    protected static ?string $navigationLabel = 'Cetak';
    protected static string $view = 'filament.pages.rekap';
}
