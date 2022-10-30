<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HewanResource\Pages;
use App\Components\Actions;
use App\Filament\Resources\HewanResource\RelationManagers;
use App\Filament\Resources\HewanResource\Widgets\StatsOverview;
use App\Models\Genre;
use App\Models\Hewan;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HewanResource extends Resource
{
    protected static ?string $model = Hewan::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationLabel = 'Hewan';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $recordTitleAttribute = 'nama';

    protected static ?string $modelLabel = 'Hewan';

    protected static ?string $breadcrumb = 'Hewan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Card::make()
                            ->schema([
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('nama')->required(),
                                        Forms\Components\Select::make('id_genre')->label('Genre')
                                            ->options(Genre::all()->pluck('genre', 'id'))->required(),
                                ]),
                                Forms\Components\RichEditor::make('keterangan')->required()
                                ->disableToolbarButtons([
                                        'attachFiles',
                                        'codeBlock',
                                    ]),
                                Forms\Components\FileUpload::make('objek')->image()
                                    ->imageCropAspectRatio('16:9')
                                    ->maxSize(2048)
                                    ->imageResizeTargetWidth('1920')
                                    ->imageResizeTargetHeight('1080')
                                    ->disk('public')->directory('img')->required(),
                                Forms\Components\MarkdownEditor::make('editor')->toolbarButtons([
                                    'edit',
                                    'preview'
                                ]),
                                Forms\Components\Toggle::make('vr')->label('VR'),
                                Forms\Components\Toggle::make('status')->label('Aktif'),
                        ]),
                    ])->columnSpan(['lg' => fn (?Hewan $record) => $record === null ? 3 : 2]),
                    Forms\Components\Card::make()
                            ->schema([
                                Forms\Components\Placeholder::make('created_at')
                                    ->label(__('Tanggal Buat'))
                                    ->content(fn (Hewan $record): string => $record->created_at->diffForHumans()),

                                Forms\Components\Placeholder::make('updated_at')
                                    ->label(__('Tanggal Modifikasi'))
                                    ->content(fn (Hewan $record): string => $record->updated_at->diffForHumans()),
                            ])
                            ->columnSpan(['lg' => 1])
                            ->hidden(fn (?Hewan $record) => $record === null),
            ])->columns([
                'sm' => 3,
                'lg' => null,
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('objek')->size(40),
                Tables\Columns\TextColumn::make('nama')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('genre.genre')->sortable()->searchable(),
                Tables\Columns\IconColumn::make('status')->label('Aktif')->boolean()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Tanggal Buat')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('genre')->relationship('genre', 'genre'),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')->label('Tanggal Buat Dari'),
                        Forms\Components\DatePicker::make('created_until')->label('Tanggal Buat Sampai'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
                Tables\Filters\Filter::make('status')->label('Aktif') ->query(fn (Builder $query): Builder => $query->where('status', true))
            ])
            ->actions([
                Actions\EditAction::make(),
                Tables\Actions\ActionGroup::make([
                    Actions\ViewAction::make()->icon('heroicon-o-eye'),
                    Actions\DeleteAction::make()->icon('heroicon-o-trash')->after(function($record){
                        Storage::disk('public')->delete($record->objek);
                    }),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->action(function ($records) {
                    return $records->map(function($record){
                        Storage::disk('public')->delete($record->objek);
                        return $record;
                    })->each->delete();
                })
            ])
            ->defaultSort('created_at');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\DetailHewanRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHewans::route('/'),
            'create' => Pages\CreateHewan::route('/create'),
            'view' => Pages\ViewHewan::route('/{record}'),
            'edit' => Pages\EditHewan::route('/{record}/edit'),
        ];
    }

    protected static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['nama', 'keterangan'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->nama;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->genre)
            $details['Genre'] = $record->genre->genre;

        $details['keterangan'] = $record->keterangan;

        return $details;
    }

}

