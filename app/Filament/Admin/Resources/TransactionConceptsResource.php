<?php

namespace App\Filament\Admin\Resources;

use App\Enums\transactionStatus;
use App\Filament\Admin\Resources\TransactionConceptsResource\Pages;
use App\Filament\Admin\Resources\TransactionConceptsResource\RelationManagers;
use App\Models\TransactionConcepts;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class TransactionConceptsResource extends Resource
{
    protected static ?string $model = TransactionConcepts::class;
    protected static ?string $tenantOwnershipRelationshipName = 'workspace';
    protected static ?string $tenantRelationshipName = 'transactionConcepts';
    protected static ?string $navigationIcon = 'heroicon-o-square-3-stack-3d';
    protected static ?string $navigationLabel = 'Conceptos Globales';
    protected static ?string $navigationGroup = 'Gestión del Sistema';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = "Concepto";

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('church_id', Auth::user()->church_id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->label('Nombre')->required()->unique(),
                Forms\Components\TextInput::make('description')->label('Descripción'),
                Forms\Components\Select::make('transaction_type')
                    ->label('Movimiento')
                    ->options(transactionStatus::class)
                    ->default(transactionStatus::INCOME)
                    ->required()
            ])
            ->columns(3)
        ;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('transaction_type')
                    ->badge(),
                Tables\Columns\ToggleColumn::make('active')->label('Activo')


            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListTransactionConcepts::route('/'),
            'create' => Pages\CreateTransactionConcepts::route('/create'),
            'edit' => Pages\EditTransactionConcepts::route('/{record}/edit'),
        ];
    }
}
