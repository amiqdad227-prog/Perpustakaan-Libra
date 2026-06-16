<?php

namespace App\Models;

use App\Enums\LoanStatus;
use Database\Factories\LoanFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan extends Model
{
    
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'member_id',
        'loan_date',
        'due_date',
        'status',
        'returned_at',
    ];

    protected function casts(): array
    {
        return [
            'loan_date'   => 'date',
            'due_date'    => 'date',
            'returned_at' => 'datetime',
            'status'      => LoanStatus::class,
        ];
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(LoanDetail::class);
    }

    public function bookReturn(): HasOne
    {
        return $this->hasOne(BookReturn::class, 'loan_id');
    }
}
