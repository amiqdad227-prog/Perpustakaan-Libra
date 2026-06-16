<?php

namespace App\Services;

use App\Enums\LoanStatus;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LoanInventoryService
{
    public function reserveStockForLoan(Loan $loan): void
    {
        DB::transaction(function () use ($loan) {
            $loan->loadMissing('details.book');

            foreach ($loan->details as $detail) {
                $book = Book::query()->lockForUpdate()->findOrFail($detail->book_id);

                if ($book->stock < $detail->quantity) {
                    throw ValidationException::withMessages([
                        'details' => "Stok buku \"{$book->title}\" tidak cukup. Tersedia {$book->stock}, diminta {$detail->quantity}.",
                    ]);
                }

                $book->decrement('stock', $detail->quantity);
            }
        });
    }

    public function restoreStockForReturnedLoan(Loan $loan): void
    {
        DB::transaction(function () use ($loan) {
            $loan->loadMissing('details');

            foreach ($loan->details as $detail) {
                Book::query()
                    ->whereKey($detail->book_id)
                    ->lockForUpdate()
                    ->increment('stock', $detail->quantity);
            }

            $loan->forceFill(['returned_at' => now()])->saveQuietly();
        });
    }

    public function markReturnedIfNeeded(Loan $loan): void
    {
        if (
            $loan->wasChanged('status')
            && $loan->getOriginal('status') !== LoanStatus::Returned->value
            && $loan->status === LoanStatus::Returned
        ) {
            $this->restoreStockForReturnedLoan($loan);
        }
    }
}
