<?php

namespace App\Filament\Resources\Loans\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'details';

    protected static ?string $title = 'Detail Buku';

    public function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('book.title')->label('Buku')->searchable()->sortable(),
            TextColumn::make('book.author')->label('Penulis')->searchable(),
            TextColumn::make('quantity')->label('Jumlah')->sortable(),
        ]);
    }
}
