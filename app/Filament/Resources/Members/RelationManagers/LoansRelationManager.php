<?php

namespace App\Filament\Resources\Members\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LoansRelationManager extends RelationManager
{
    protected static string $relationship = 'loans';

    protected static ?string $title = 'Riwayat Peminjaman';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('loan_date')->label('Tanggal Pinjam')->date('d M Y'),
                TextColumn::make('due_date')->label('Jatuh Tempo')->date('d M Y'),
                TextColumn::make('status')->label('Status')->badge(),
            ])
            ->paginated(false);
    }
}