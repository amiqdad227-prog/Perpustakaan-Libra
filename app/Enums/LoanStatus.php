<?php

namespace App\Enums;

enum LoanStatus: string
{
    case Borrowed = 'Dipinjam';
    case Returned = 'Dikembalikan';
    case Late = 'Terlambat';
}
