<?php

namespace App\Filament\Resources\Returns\Pages;

use App\Enums\LoanStatus;
use App\Filament\Resources\Returns\ReturnResource;
use App\Models\Loan;
use Filament\Resources\Pages\CreateRecord;

class CreateReturn extends CreateRecord
{
    protected static string $resource = ReturnResource::class;

    protected function afterCreate(): void
    {
        $return = $this->record;
        $loan = Loan::find($return->loan_id);
        if ($loan) {
            $loan->update([
                'status'      => LoanStatus::Returned->value,
                'returned_at' => now(),
            ]);
        }
    }
}