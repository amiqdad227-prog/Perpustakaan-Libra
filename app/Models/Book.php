<?php

namespace App\Models;

use Database\Factories\BookFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
   
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'title',
        'author',
        'publisher',
        'publication_year',
        'stock',
        'cover_image',
    ];

    protected function casts(): array
    {
        return [
            'publication_year' => 'integer',
            'stock' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function loanDetails(): HasMany
    {
        return $this->hasMany(LoanDetail::class);
    }

    public function favoritedByMembers(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'book_member_favorites')->withTimestamps();
    }
}
