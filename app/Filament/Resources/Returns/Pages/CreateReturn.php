<?php

namespace App\Filament\Resources\Returns\Pages;

use App\Filament\Resources\Returns\ReturnResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateReturn extends CreateRecord
{
    protected static string $resource = ReturnResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali')
                ->icon('heroicon-o-arrow-left')
                ->color('secondary')
                ->outlined()
                ->url($this->getResource()::getUrl('index')),
        ];
    }
}