<?php

namespace App\Filament\Resources\HewanResource\RelationManagers;

use App\Models\DetailHewan;
use App\Components\Actions;
use App\Filament\Resources\HewanResource;
use Filament\Notifications\Actions\Action;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;

class DetailHewanRelationManager extends RelationManager
{
    protected static string $relationship = 'details';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\TextInput::make('nama')->required(),
                        Forms\Components\RichEditor::make('keterangan')->required()
                        ->disableToolbarButtons([
                                'attachFiles',
                                'codeBlock',
                            ]),
                        Forms\Components\FileUpload::make('objek')->image()->maxSize(2048)
                            ->disk('public')->directory('img')->required(),
                        Forms\Components\MarkdownEditor::make('editor')->toolbarButtons([
                            'edit',
                            'preview'
                        ]),
                        // Forms\Components\Toggle::make('vr')->label('VR'),
                        Forms\Components\Toggle::make('status')->label('Aktif'),
                    ])->columnSpan(['lg' => fn (?DetailHewan $record) => $record === null ? 3 : 2]),
                    Forms\Components\Card::make()
                            ->schema([
                                Forms\Components\Placeholder::make('created_at')
                                    ->label(__('Tanggal Buat'))
                                    ->content(fn (DetailHewan $record): string => $record->created_at->diffForHumans()),

                                Forms\Components\Placeholder::make('updated_at')
                                    ->label(__('Tanggal Modifikasi'))
                                    ->content(fn (DetailHewan $record): string => $record->updated_at->diffForHumans()),
                            ])
                            ->columnSpan(['lg' => 1])
                            ->hidden(fn (?DetailHewan $record) => $record === null),
            ])->columns([
                'sm' => 3,
                'lg' => null,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('objek')->rounded(),
                Tables\Columns\TextColumn::make('nama')->sortable()->searchable(),
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
                Actions\EditAction::make()->after(function ($record) {
                        Notification::make()
                            ->title("Detail Hewan {$record->hewan->nama} Diubah")
                            ->icon('heroicon-o-annotation')
                            ->body("**Detail {$record->nama} telah ditambahkan pada hewan ({$record->hewan->nama}).**")
                            ->actions([
                                Action::make('View')
                                    ->url(HewanResource::getUrl('edit', ['record' => $record->id_hewan])),
                            ])
                            ->sendToDatabase(auth()->user());
                    }),
                Tables\Actions\ActionGroup::make([
                    Actions\ViewAction::make()->icon('heroicon-o-eye'),
                    Actions\DeleteAction::make()->icon('heroicon-o-trash')->after(function ($record) {
                        Notification::make()
                            ->title("Detail Hewan {$record->hewan->nama} dihapus")
                            ->icon('heroicon-o-annotation')
                            ->body("**Detail {$record->nama} telah dihapus pada hewan ({$record->hewan->nama}).**")
                            ->sendToDatabase(auth()->user());
                    }),
                ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label("Buat Detail")->after(function ($record) {
                        Notification::make()
                            ->title("Detail Hewan {$record->hewan->name} Baru")
                            ->icon('heroicon-o-annotation')
                            ->body("**Detail {$record->name} telah ditambahkan pada hewan ({$record->hewan->name}).**")
                            ->actions([
                                Action::make('View')
                                    ->url(HewanResource::getUrl('edit', ['record' => $record->id_hewan])),
                            ])
                            ->sendToDatabase(auth()->user());
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at');
        // return $table
        //     ->columns([
        //         Tables\Columns\TextColumn::make('title')
        //             ->label('Title')
        //             ->searchable()
        //             ->sortable(),

        //         Tables\Columns\TextColumn::make('customer.name')
        //             ->label('Customer')
        //             ->searchable()
        //             ->sortable(),

        //         Tables\Columns\BooleanColumn::make('is_visible')
        //             ->label('Visibility')
        //             ->sortable(),
        //     ])
        //     ->filters([
        //         //
        //     ])
        //     ->headerActions([
        //         Tables\Actions\CreateAction::make(),
        //     ])
        //     ->actions([
        //         Tables\Actions\EditAction::make(),
        //         Tables\Actions\DeleteAction::make(),
        //     ])
        //     ->bulkActions([
        //         Tables\Actions\DeleteBulkAction::make(),
        //     ]);
    }
}
