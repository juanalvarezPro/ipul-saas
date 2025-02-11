<?php

namespace App\Filament\Admin\Resources;

use App\Enums\userStatus;
use App\Filament\Admin\Resources\UserResource\Pages;
use App\Filament\Admin\Resources\UserResource\RelationManagers;
use Filament\Forms\Components\Actions\Action;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationLabel = 'Feligreses';
    protected static ?string $modelLabel = "Feligrés";
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Gestión del Sistema';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Sección de Información Personal
                Section::make('Información Personal')
                    ->columns(3) // Título de la sección
                    ->schema([
                        Section::make('')
                            ->columnSpan(1)
                            ->schema([
                                FileUpload::make('avatar')
                                    ->hiddenLabel()
                                    ->image()
                                    ->previewable()
                                    ->alignCenter()
                                    ->disk('r2')
                                    ->directory('avatars')
                                    ->imageEditor()
                                    ->maxSize(500)
                                    ->circleCropper()
                                    ->avatar(),
                                TextInput::make('name')
                                    ->label('Nombre')
                                    ->required()
                                    ->maxLength(20),
                                Select::make('role_id')
                                    ->label('Rol')
                                    ->relationship('role', 'name')
                                    ->default(2) // Default a "Usuario"
                                    ->required(),
                                Select::make('status')
                                    ->label('Estado')
                                    ->options(userStatus::class)
                                    ->default(userStatus::PENDING)
                                    ->required(),

                            ]),

                        Section::make('')
                            ->columnSpan(2)
                            ->schema(
                                [    // Campo para seleccionar la iglesia
                                    Select::make('church_id')
                                        ->label('Iglesia a la que se congrega')
                                        ->relationship('church', 'name')
                                        ->searchable()
                                        ->optionsLimit(5)
                                        ->preload()
                                        ->required()
                                        ->placeholder('Seleccione una iglesia'),

                                    // Campo para el correo electrónico
                                    TextInput::make('email')
                                        ->label('Correo Corporativo')
                                        ->email()
                                        ->required(),

                                    // Campo para el correo electrónico personal (opcional)
                                    TextInput::make('email_personal')
                                        ->label('Correo Personal')
                                        ->email()
                                        ->nullable(),

                                    TextInput::make('password')
                                        ->label('Nueva Contraseña')
                                        ->password()
                                        ->revealable()
                                        ->currentPassword()
                                        ->dehydrateStateUsing(
                                            fn($state) =>
                                            filled($state) ? Hash::make($state) : Auth::user()->password // Si hay nueva, la encripta; si no, deja la actual
                                        )
                                        ->suffixAction(
                                            Action::make('generatePassword')
                                                ->icon('heroicon-o-key')
                                                ->tooltip('Generar contraseña segura')
                                                ->action(fn($state, callable $set) => $set('password', Str::random(12))) // Genera y llena el campo
                                        )
                                        ->minLength(8)
                                        ->helperText('Déjalo vacío si no deseas cambiar tu contraseña.'),
                                ]
                            ),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_personal')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')->badge(),
                Tables\Columns\ImageColumn::make('avatar'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
