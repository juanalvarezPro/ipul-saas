<?php

namespace App\Filament\Admin\Resources;

use App\Enums\userStatus;
use App\Filament\Admin\Resources\UserResource\Pages;
use App\Filament\Admin\Resources\UserResource\RelationManagers;
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
                    ->columns(4) // Título de la sección
                    ->schema([
                        // Campo para el nombre
                        TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255),

                        // Campo para el correo electrónico
                        TextInput::make('email')
                            ->label('Correo Coorporativo')
                            ->email()
                            ->required()
                            ->helperText('Este correo es utilizado para acceder al panel'),

                        // Campo para el correo electrónico personal (opcional)
                        TextInput::make('email_personal')
                            ->label('Correo Electrónico Personal')
                            ->email()
                            ->nullable()
                            ->helperText('Este correo (opcional) se usará para notificaciones y alertas importantes.'),
                        // Campo para seleccionar la iglesia
                        Select::make('church_id')
                            ->label('Iglesia')
                            ->relationship('church', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ]),

                // Sección de Contraseña y Estado
                Section::make('Contraseña y Estado')
                    ->columns(2)
                    ->schema([
                        // Campo para la contraseña
                        TextInput::make('password')
                            ->label('Contraseña')
                            ->password()
                            ->required()
                            ->minLength(8),

                        // Selección del estado
                        Select::make('status')
                            ->options(userStatus::class)
                            ->default(userStatus::PENDING)
                            ->required()
                    ]),

                    Section::make('Configuración del Rol')
                    ->schema([
                        // Selección de Rol
                        Select::make('role_id')
                            ->label('Rol')
                            ->relationship('role', 'name')
                            ->default(2) // Default a "Usuario"
                            ->required(),
                    ]),

                // Sección de Avatar y Datos de la Iglesia
                Section::make('Avatar')
                    ->schema([

                        // Campo para subir el avatar (imagen de perfil)
                        FileUpload::make('avatar')
                            ->label('Avatar')
                            ->image()
                            ->disk('r2')  // Define el disco de almacenamiento en 'public'
                            ->directory('avatars') // Carpeta donde se guardarán las imágenes
                            ->maxSize(1024) // Tamaño máximo en KB
                            ->helperText('Sube una imagen para el avatar, solo se permiten archivos de tipo imagen.')
                            ->preserveFilenames(),
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
