<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Forms;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Concerns\UsesResourceForm;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;

class Profile extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;
    use InteractsWithRecord;
    use UsesResourceForm;

    public $name = '';
    public $alamat = '';
    public $email = '';

    protected static ?string $title = 'Profile Pengguna';

    protected static ?string $navigationLabel = 'Profile Pengguna';

    protected static ?string $recordTitleAttribute = 'nama';

    protected static ?string $modelLabel = 'Profile Pengguna';

    protected static string $resource = UserResource::class;

    protected static string $view = 'filament.resources.user-resource.pages.users-profile';

    public User $user;

    public function mount(): void
    {
        $this->user = Auth::user();
        $this->form->fill([
            'name' => $this->user->name,
            'alamat' => $this->user->alamat,
            'email' => $this->user->email,
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Card::make()
                            ->schema([
                Forms\Components\TextInput::make('name')->label('Nama')
                    ->required(),
                Forms\Components\TextInput::make('email')
                                    ->required()
                                    ->email()
                                    ->unique(User::class, 'email', ignoreRecord: true),
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->password()->confirmed(),
                        Forms\Components\TextInput::make('password_confirmation')->label('Konfirmasi Password'),
                ]),
                Forms\Components\Textarea::make('alamat')
                    ->required(),
            ])
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($data['password'] === null && $data['password_confirmation'] === null){
            unset($data['password']);
            unset($data['password_confirmation']);
        }

        return $data;
    }

    protected function getFormModel(): User
    {
        return $this->user;
    }

    public function save(){
        $data = $this->form->getState();
        $data = $this->mutateFormDataBeforeSave($data);
        $this->user->update($data);

        $this->notify('success', 'Berhasil mengubah Profil Pengguna.');
    }
}
