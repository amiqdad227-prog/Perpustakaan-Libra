<?php

namespace App\Filament\Resources\Books;

use App\Filament\Resources\Books\Pages\CreateBook;
use App\Filament\Resources\Books\Pages\EditBook;
use App\Filament\Resources\Books\Pages\ListBooks;
use App\Filament\Resources\Books\RelationManagers\FavoritedByMembersRelationManager;
use App\Models\Book;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Buku';

    protected static ?string $modelLabel = 'Buku';

    protected static ?string $pluralModelLabel = 'Buku';

    protected static string | \UnitEnum | null $navigationGroup = 'Perpustakaan';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Buku')
                ->schema([
                    Select::make('category_id')
                        ->label('Kategori')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload()
                        ->placeholder('Pilih kategori buku')
                        ->helperText('Kategori membantu pengelompokan koleksi.')
                        ->required(),
                    TextInput::make('title')
                        ->label('Judul')
                        ->placeholder('Contoh: Laravel Enterprise Patterns')
                        ->helperText('Masukkan judul buku sesuai data katalog.')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('author')
                        ->label('Penulis')
                        ->placeholder('Nama penulis')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('publisher')
                        ->label('Penerbit')
                        ->placeholder('Nama penerbit')
                        ->maxLength(255),
                    TextInput::make('publication_year')
                        ->label('Tahun Terbit')
                        ->placeholder('Contoh: 2025')
                        ->numeric()
                        ->minValue(1000)
                        ->maxValue((int) date('Y'))
                        ->helperText('Gunakan format tahun 4 digit.'),
                    TextInput::make('stock')
                        ->label('Stok')
                        ->placeholder('Contoh: 10')
                        ->helperText('Jumlah eksemplar yang tersedia.')
                        ->required()
                        ->numeric()
                        ->minValue(0)
                        ->default(0),
                ])
                ->columns(2),
            Section::make('Cover Buku')
                ->schema([
                    FileUpload::make('cover_image')
                        ->label('Cover')
                        ->placeholder('Unggah cover buku')
                        ->helperText('Format JPG, JPEG, atau PNG. Maksimal 2 MB.')
                        ->disk('public')
                        ->directory('books')
                        ->image()
                        ->imagePreviewHeight('220')
                        ->acceptedFileTypes(['image/jpeg', 'image/png'])
                        ->maxSize(2048)
                        ->deletable()
                        ->downloadable()
                        ->openable()
                        ->reorderable(false)
                        ->panelLayout('integrated'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')
                    ->label('No.')
                    ->rowIndex(),
                ImageColumn::make('cover_image')->label('Cover')->disk('public')->height(64)->square(),
                TextColumn::make('title')->label('Judul')->searchable()->wrap(),
                TextColumn::make('category.name')->label('Kategori')->searchable(),
                TextColumn::make('author')->label('Penulis')->searchable(),
                TextColumn::make('publisher')->label('Penerbit')->searchable()->toggleable(),
                TextColumn::make('publication_year')->label('Tahun'),
                TextColumn::make('stock')->label('Stok')->badge()->color(fn (int $state): string => $state > 0 ? 'success' : 'danger'),
            ])
            ->filters([
                SelectFilter::make('category_id')->label('Kategori')->relationship('category', 'name')->searchable()->preload(),
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
            FavoritedByMembersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBooks::route('/'),
            'create' => CreateBook::route('/create'),
            'edit' => EditBook::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([
            SoftDeletingScope::class,
        ]);
    }
}