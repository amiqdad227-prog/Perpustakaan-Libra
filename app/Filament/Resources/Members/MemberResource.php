<?php

namespace App\Filament\Resources\Members;

use App\Filament\Resources\Members\Pages\CreateMember;
use App\Filament\Resources\Members\Pages\EditMember;
use App\Filament\Resources\Members\Pages\ListMembers;
use App\Filament\Resources\Members\RelationManagers\FavoriteBooksRelationManager;
use App\Filament\Resources\Members\RelationManagers\LoansRelationManager;
use App\Models\Member;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Anggota';

    protected static ?string $modelLabel = 'Anggota';

    protected static ?string $pluralModelLabel = 'Anggota';

    protected static string | \UnitEnum | null $navigationGroup = 'Perpustakaan';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Data Anggota')
                ->schema([
                    TextInput::make('member_code')
                        ->label('Kode Anggota')
                        ->placeholder('Contoh: MBR-0001')
                        ->helperText('Kode unik untuk identitas anggota.')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                    TextInput::make('name')
                        ->label('Nama')
                        ->placeholder('Nama lengkap anggota')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('email')
                        ->label('Email')
                        ->placeholder('Contoh: anggota@email.com')
                        ->email()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),
                    Select::make('gender')
                        ->label('Jenis Kelamin')
                        ->options([
                            'Laki-laki'  => 'Laki-laki',
                            'Perempuan'  => 'Perempuan',
                        ])
                        ->placeholder('Pilih jenis kelamin'),
                    TextInput::make('phone')
                        ->label('Telepon')
                        ->placeholder('Contoh: 081234567890')
                        ->tel()
                        ->maxLength(30),
                    Textarea::make('address')
                        ->label('Alamat')
                        ->placeholder('Alamat anggota')
                        ->helperText('Alamat digunakan untuk keperluan administrasi.')
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
                TextColumn::make('member_code')->label('Kode')->searchable(),
                TextColumn::make('name')->label('Nama')->searchable(),
                TextColumn::make('email')->label('Email')->searchable()->toggleable(),
                TextColumn::make('gender')->label('JK')->badge()->color(fn (?string $state): string => match($state) {
                    'Laki-laki' => 'info',
                    'Perempuan' => 'danger',
                    default => 'gray',
                }),
                TextColumn::make('phone')->label('Telepon')->searchable()->toggleable(),
                TextColumn::make('address')->label('Alamat')->searchable()->wrap()->toggleable(),
                TextColumn::make('loans_count')->label('Total Pinjam')->counts('loans'),
                TextColumn::make('created_at')->label('Terdaftar')->date('d M Y'),
            ])
            ->filters([
                SelectFilter::make('gender')->label('Jenis Kelamin')->options([
                    'Laki-laki' => 'Laki-laki',
                    'Perempuan' => 'Perempuan',
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
            LoansRelationManager::class,
            FavoriteBooksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMembers::route('/'),
            'create' => CreateMember::route('/create'),
            'edit' => EditMember::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([
            SoftDeletingScope::class,
        ]);
    }
}