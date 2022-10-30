<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GenreResource\Pages;
use App\Components\Actions;
use App\Filament\Resources\GenreResource\RelationManagers;
use App\Models\Genre;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class GenreResource extends Resource
{
    protected static ?string $model = Genre::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $recordTitleAttribute = 'genre';

    protected static ?string $modelLabel = 'Genre';

    protected static ?string $navigationLabel = 'Genre';

    protected static ?string $breadcrumb = 'Genre';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([

                            Forms\Components\TextInput::make('genre')->required(),
                            Forms\Components\RichEditor::make('keterangan')->required()
                            ->disableToolbarButtons([
                                    'attachFiles',
                                    'codeBlock',
                                ]),
                            Forms\Components\Toggle::make('status')->label('Aktif'),
                    ])->columnSpan(['lg' => fn (?Genre $record) => $record === null ? 3 : 2]),
                    Forms\Components\Card::make()
                            ->schema([
                                Forms\Components\Placeholder::make('created_at')
                                    ->label(__('Tanggal Buat'))
                                    ->content(fn (Genre $record): string => $record->created_at->diffForHumans()),

                                Forms\Components\Placeholder::make('updated_at')
                                    ->label(__('Tanggal Modifikasi'))
                                    ->content(fn (Genre $record): string => $record->updated_at->diffForHumans()),
                            ])
                            ->columnSpan(['lg' => 1])
                            ->hidden(fn (?Genre $record) => $record === null),
            ])->columns([
                'sm' => 3,
                'lg' => null,
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('genre')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('keterangan')->sortable()->searchable(),
                Tables\Columns\IconColumn::make('status')->label('Aktif')->boolean()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Tanggal Buat')->dateTime()->sortable(),
            ])
            ->filters([
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
                    Actions\DeleteAction::make()->icon('heroicon-o-trash'),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at');
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageGenre::route('/'),
        ];
    }

     protected static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['genre', 'keterangan'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->genre;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];
        $details['Keterangan'] = $record->keterangan;

        return $details;
    }
}
