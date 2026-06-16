<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookReturn extends Model
{
    protected $table = 'returns';

    protected $fillable = [
        'loan_id',
        'return_date',
        'book_condition',
        'late_days',
        'fine_amount',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'return_date' => 'date',
            'late_days'   => 'integer',
            'fine_amount' => 'decimal:2',
        ];
    }

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }

    public static function calculateFine(int $lateDays): float
    {
        return $lateDays * 5000;
    }
}