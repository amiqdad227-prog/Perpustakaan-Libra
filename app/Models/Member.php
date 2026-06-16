<?php

namespace App\Models;

use Database\Factories\MemberFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'member_code',
        'name',
        'email',
        'gender',
        'address',
        'phone',
    ];

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function favoriteBooks(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_member_favorites')->withTimestamps();
    }

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_member_favorites')->withTimestamps();
    }
}
