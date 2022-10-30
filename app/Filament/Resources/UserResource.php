<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Components\Actions;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Auth;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Pengguna';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $breadcrumb = 'Pengguna';

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
                                        Forms\Components\TextInput::make('name')->required(),
                                        Forms\Components\Select::make('role')->label('Role')
                                            ->relationship('roles', 'name')
                                            ->multiple()
                                            ->disablePlaceholderSelection(false)
                                            ->placeholder('')
                                            ->searchable(false)
                                            ->options(Role::all()->pluck('name', 'id')->map(fn ($item): ?string => ucfirst($item) ))
                                            ->required()
                                            ->getOptionLabelUsing(fn ($value): ?string => ucfirst($value)),
                                ]),
                                Forms\Components\TextInput::make('email')
                                    ->required()
                                    ->email()->unique(User::class, 'email', ignoreRecord: true),
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('password')
                                            ->required(fn (?User $record) => $record === null)
                                            ->password()->confirmed(),
                                        Forms\Components\TextInput::make('password_confirmation')->label('Konfirmasi Password'),
                                ]),
                                Forms\Components\Textarea::make('alamat')
                                    ->required(),
                                // Forms\Components\FileUpload::make('objek')
                                //     ->label('Image')
                                //     ->image()->maxSize(2048)
                                //     ->disk('public')->directory('img'),
                                Forms\Components\Toggle::make('status')->label('Aktif'),
                        ]),
                    ])->columnSpan(['lg' => fn (?User $record) => $record === null ? 3 : 2]),
                    Forms\Components\Card::make()
                            ->schema([
                                Forms\Components\Placeholder::make('created_at')
                                    ->label(__('Tanggal Buat'))
                                    ->content(fn (User $record): string => $record->created_at->diffForHumans()),
                                Forms\Components\Placeholder::make('updated_at')
                                    ->label(__('Tanggal Modifikasi'))
                                    ->content(fn (User $record): string => $record->updated_at->diffForHumans()),
                            ])
                            ->columnSpan(['lg' => 1])
                            ->hidden(fn (?User $record) => $record === null),
            ])->columns([
                'sm' => 3,
                'lg' => null,
            ]);

    }

    public static function table(Table $table): Table
    {
        // dd(\Filament\Facades\Filament::getUserAvatarUrl(Auth::user()));
        // dd(Auth::user()->filament);
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('roles.name')->label('Role')->sortable()->searchable()->formatStateUsing(fn (string $state): string => ucfirst($state)),
                Tables\Columns\TextColumn::make('email')->sortable()->searchable(),
                Tables\Columns\IconColumn::make('status')->label('Aktif')->boolean()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Tanggal Buat')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')->relationship('roles', 'name'),
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
                    Actions\DeleteAction::make()->icon('heroicon-o-trash')->after(function ($record){
                        Storage::disk('public')->delete($record->objek);
                        Notification::make()
                            ->title('Pengguna Dihapus')
                            ->icon('heroicon-o-users')
                            ->body("**Informasi Pengguna <b>{$record->name}</b> berhasil dihapus.**")
                            ->sendToDatabase(auth()->user());
                    }),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'profile' => Pages\Profile::route('/profile'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    protected static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['roles']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'roles.name', 'email'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->roles) {
            $details['Roles'] = $record->roles->pluck('name')->map(fn($value) => ucfirst($value))->implode(',');
        }

        $details['Email'] = $record->email;

        return $details;
    }
}
