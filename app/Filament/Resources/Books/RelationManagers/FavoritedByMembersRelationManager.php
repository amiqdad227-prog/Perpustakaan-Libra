<?php

namespace App\Filament\Resources\Books\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FavoritedByMembersRelationManager extends RelationManager
{
    protected static string $relationship = 'favoritedByMembers';

    protected static ?string $title = 'Member Favorit';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('member_code')->label('Kode')->searchable()->sortable(),
                TextColumn::make('name')->label('Nama Member')->searchable()->sortable(),
                TextColumn::make('phone')->label('Telepon')->searchable(),
            ])
            ->headerActions([
                AttachAction::make()->preloadRecordSelect()->recordSelectSearchColumns(['member_code', 'name']),
            ])
            ->recordActions([
                DetachAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
