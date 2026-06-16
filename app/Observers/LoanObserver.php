<?php

namespace App\Observers;

use App\Models\Loan;
use App\Services\LoanInventoryService;

class LoanObserver
{
    public function __construct(private readonly LoanInventoryService $inventoryService)
    {
    }

    public function created(Loan $loan): void
    {
        $this->inventoryService->reserveStockForLoan($loan);
    }

    public function updated(Loan $loan): void
    {
        $this->inventoryService->markReturnedIfNeeded($loan);
    }
}
