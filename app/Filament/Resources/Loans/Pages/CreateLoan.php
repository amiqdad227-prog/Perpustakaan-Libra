<?php

namespace App\Filament\Resources\Loans\Pages;

use App\Filament\Resources\Loans\LoanResource;
use App\Services\LoanInventoryService;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateLoan extends CreateRecord
{
    protected static string $resource = LoanResource::class;

    protected function afterCreate(): void
    {
        app(LoanInventoryService::class)->reserveStockForLoan($this->record);

        Notification::make()
            ->title('Peminjaman berhasil dibuat')
            ->body('Stok buku sudah otomatis dikurangi.')
            ->success()
            ->send();
    }
}
