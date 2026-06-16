<?php

namespace App\Filament\Widgets;

use App\Enums\LoanStatus;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LibraryStatsOverview extends StatsOverviewWidget
{
    protected ?string $heading = 'Statistik Perpustakaan';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Buku', Book::query()->count())
                ->description('Jumlah judul koleksi')
                ->color('primary'),
            Stat::make('Total Anggota', Member::query()->count())
                ->description('Anggota aktif terdaftar')
                ->color('success'),
            Stat::make('Total Peminjaman', Loan::query()->count())
                ->description('Semua transaksi peminjaman')
                ->color('info'),
            Stat::make('Total Pengembalian', Loan::query()->where('status', LoanStatus::Returned->value)->count())
                ->description('Transaksi sudah dikembalikan')
                ->color('warning'),
            Stat::make('Buku Tersedia', Book::query()->where('stock', '>', 0)->sum('stock'))
                ->description('Total eksemplar tersedia')
                ->color('success'),
        ];
    }
}
