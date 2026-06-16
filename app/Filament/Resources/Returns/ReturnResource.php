<?php

namespace App\Filament\Resources\Returns;

use App\Enums\LoanStatus;
use App\Filament\Resources\Returns\Pages\CreateReturn;
use App\Filament\Resources\Returns\Pages\EditReturn;
use App\Filament\Resources\Returns\Pages\ListReturns;
use App\Models\BookReturn;
use App\Models\Loan;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ReturnResource extends Resource
{
    protected static ?string $model = BookReturn::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-arrow-uturn-left';

    protected static ?string $navigationLabel = 'Pengembalian';

    protected static ?string $modelLabel = 'Pengembalian';

    protected static ?string $pluralModelLabel = 'Pengembalian';

    protected static string | \UnitEnum | null $navigationGroup = 'Transaksi';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Data Pengembalian')
                ->schema([
                    Select::make('loan_id')
                        ->label('Peminjaman')
                        ->options(function () {
                            return Loan::with('member')
                                ->whereIn('status', [LoanStatus::Borrowed->value, LoanStatus::Late->value])
                                ->whereDoesntHave('bookReturn')
                                ->get()
                                ->mapWithKeys(fn ($loan) => [
                                    $loan->id => ($loan->member->name ?? '-') . ' — Jatuh tempo: ' . $loan->due_date->format('d M Y'),
                                ]);
                        })
                        ->searchable()
                        ->preload()
                        ->required()
                        ->live()
                        ->afterStateUpdated(function (Get $get, Set $set, $state) {
                            if (!$state) return;
                            $loan = Loan::find($state);
                            if (!$loan) return;
                            $returnDate = $get('return_date') ?? now()->toDateString();
                            $lateDays = max(0, \Carbon\Carbon::parse($returnDate)->diffInDays($loan->due_date, false) * -1);
                            $set('late_days', $lateDays);
                            $set('fine_amount', BookReturn::calculateFine($lateDays));
                        })
                        ->helperText('Hanya peminjaman aktif yang belum dikembalikan.'),

                    DatePicker::make('return_date')
                        ->label('Tanggal Kembali')
                        ->required()
                        ->default(now())
                        ->live()
                        ->afterStateUpdated(function (Get $get, Set $set, $state) {
                            $loanId = $get('loan_id');
                            if (!$loanId || !$state) return;
                            $loan = Loan::find($loanId);
                            if (!$loan) return;
                            $lateDays = max(0, \Carbon\Carbon::parse($state)->diffInDays($loan->due_date, false) * -1);
                            $set('late_days', $lateDays);
                            $set('fine_amount', BookReturn::calculateFine($lateDays));
                        }),

                    Select::make('book_condition')
                        ->label('Kondisi Buku')
                        ->options([
                            'Baik'         => 'Baik',
                            'Rusak Ringan' => 'Rusak Ringan',
                            'Rusak Berat'  => 'Rusak Berat',
                            'Hilang'       => 'Hilang',
                        ])
                        ->default('Baik')
                        ->required(),

                    TextInput::make('late_days')
                        ->label('Hari Terlambat')
                        ->numeric()
                        ->default(0)
                        ->readOnly()
                        ->suffix('hari'),

                    TextInput::make('fine_amount')
                        ->label('Denda')
                        ->numeric()
                        ->default(0)
                        ->readOnly()
                        ->prefix('Rp')
                        ->helperText('Dihitung otomatis: hari terlambat × Rp 5.000'),

                    Textarea::make('notes')
                        ->label('Catatan')
                        ->placeholder('Catatan tambahan (opsional)')
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')->label('No.')->rowIndex(),
                TextColumn::make('loan.member.name')
                    ->label('Anggota')
                    ->searchable(),
                TextColumn::make('loan.due_date')
                    ->label('Jatuh Tempo')
                    ->date('d M Y'),
                TextColumn::make('return_date')
                    ->label('Tgl Kembali')
                    ->date('d M Y'),
                TextColumn::make('book_condition')
                    ->label('Kondisi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Baik'         => 'success',
                        'Rusak Ringan' => 'warning',
                        'Rusak Berat'  => 'danger',
                        'Hilang'       => 'danger',
                        default        => 'gray',
                    }),
                TextColumn::make('late_days')
                    ->label('Terlambat')
                    ->suffix(' hari')
                    ->color(fn (int $state): string => $state > 0 ? 'danger' : 'success'),
                TextColumn::make('fine_amount')
                    ->label('Denda')
                    ->money('IDR')
                    ->color(fn ($state): string => $state > 0 ? 'danger' : 'success'),
            ])
            ->filters([
                SelectFilter::make('book_condition')
                    ->label('Kondisi')
                    ->options([
                        'Baik'         => 'Baik',
                        'Rusak Ringan' => 'Rusak Ringan',
                        'Rusak Berat'  => 'Rusak Berat',
                        'Hilang'       => 'Hilang',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('return_date', 'desc')
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListReturns::route('/'),
            'create' => CreateReturn::route('/create'),
            'edit'   => EditReturn::route('/{record}/edit'),
        ];
    }
}