<?php

namespace App\Filament\Resources\Loans;

use App\Enums\LoanStatus;
use App\Filament\Resources\Loans\Pages\CreateLoan;
use App\Filament\Resources\Loans\Pages\EditLoan;
use App\Filament\Resources\Loans\Pages\ListLoans;
use App\Filament\Resources\Loans\RelationManagers\DetailsRelationManager;
use App\Models\Loan;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LoanResource extends Resource
{
    protected static ?string $model = Loan::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    protected static ?string $navigationLabel = 'Peminjaman';

    protected static ?string $modelLabel = 'Peminjaman';

    protected static ?string $pluralModelLabel = 'Peminjaman';

    protected static string | \UnitEnum | null $navigationGroup = 'Transaksi';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Data Peminjaman')
                ->schema([
                    Select::make('member_id')
                        ->label('Anggota')
                        ->relationship('member', 'name')
                        ->searchable()
                        ->preload()
                        ->placeholder('Pilih anggota')
                        ->helperText('Anggota yang melakukan peminjaman.')
                        ->required(),
                    DatePicker::make('loan_date')
                        ->label('Tanggal Pinjam')
                        ->placeholder('Pilih tanggal pinjam')
                        ->helperText('Tanggal transaksi peminjaman.')
                        ->required()
                        ->default(now()),
                    DatePicker::make('due_date')
                        ->label('Tanggal Jatuh Tempo')
                        ->placeholder('Pilih tanggal jatuh tempo')
                        ->required()
                        ->afterOrEqual('loan_date'),
                    Select::make('status')
                        ->label('Status')
                        ->options([
                            LoanStatus::Borrowed->value => 'Dipinjam',
                            LoanStatus::Returned->value => 'Dikembalikan',
                            LoanStatus::Late->value => 'Terlambat',
                        ])
                        ->default(LoanStatus::Borrowed->value)
                        ->required(),
                ])
                ->columns(2),
            Section::make('Detail Buku')
                ->schema([
                    Repeater::make('details')
                        ->label('Buku Dipinjam')
                        ->relationship()
                        ->schema([
                            Select::make('book_id')
                                ->label('Buku')
                                ->relationship('book', 'title')
                                ->searchable()
                                ->preload()
                                ->placeholder('Pilih buku')
                                ->helperText('Pilih buku yang masih memiliki stok.')
                                ->required(),
                            TextInput::make('quantity')
                                ->label('Jumlah')
                                ->placeholder('Contoh: 1')
                                ->required()
                                ->numeric()
                                ->minValue(1)
                                ->default(1),
                        ])
                        ->columns(2)
                        ->minItems(1)
                        ->required()
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')->label('No.')->rowIndex(),
                TextColumn::make('member.member_code')->label('Kode')->searchable(),
                TextColumn::make('member.name')->label('Anggota')->searchable(),
                TextColumn::make('loan_date')->label('Pinjam')->date('d M Y'),
                TextColumn::make('due_date')->label('Jatuh Tempo')->date('d M Y'),
                TextColumn::make('status')->label('Status')->badge(),
                TextColumn::make('details_sum_quantity')->label('Total Buku')->sum('details', 'quantity'),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options([
                    LoanStatus::Borrowed->value => 'Dipinjam',
                    LoanStatus::Returned->value => 'Dikembalikan',
                    LoanStatus::Late->value => 'Terlambat',
                ]),
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ])
            ->paginated(false);
    }

    public static function getRelations(): array
    {
        return [
            DetailsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLoans::route('/'),
            'create' => CreateLoan::route('/create'),
            'edit' => EditLoan::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([
            SoftDeletingScope::class,
        ]);
    }
}