<?php

namespace App\Filament\Components\TransactionConcept;

use App\Enums\transactionStatus;
use App\Models\TransactionConcepts;
use Filament\Forms;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Closure;
use Filament\Forms\Set;

class FormTransactionConcept
{

    public static function nameField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('name')
            ->label('Nombre')
            ->required()
            ->maxLength(255)
            ->rule(self::nameValidationRule());
    }

    private static function nameValidationRule(): Closure
    {
        return function (Forms\Get $get, Forms\Components\Component $component) {
            return static function (string $attribute, $value, Closure $fail) use ($component) {
                $existsConcept = TransactionConcepts::whereRaw("unaccent(name) ILIKE unaccent(?)", [$value])
                    ->where(function ($query) {
                        $query->where('is_global', true)
                            ->orWhere('church_id', Auth::user()->church_id);
                    })
                    ->first();

                if ($existsConcept && $existsConcept->getKey() !== $component->getRecord()?->getKey()) {
                    $fail("El nombre \"{$value}\" ya existe como concepto global o dentro de tu iglesia.");
                }
            };
        };
    }

    public static function parentSelect(): Forms\Components\Select
    {
        return Forms\Components\Select::make('parent_id')
            ->relationship('parent', 'name', fn(Builder $query) => $query->where('is_global', true))
            ->label('Concepto Padre')
            ->afterStateUpdated(fn(Set $set, ?string $state) =>
            $set('transaction_type', TransactionConcepts::find($state)->transaction_type))
            ->searchable()
            ->live()
            ->preload()
            ->required();
    }

    public static function transactionTypeSelect(): Forms\Components\Select
    {
        return Forms\Components\Select::make('transaction_type')
            ->label('Movimiento')
            ->options(transactionStatus::class)
            ->default(transactionStatus::INCOME)
            ->native(false)
            ->required()
            ->disabled(fn(Forms\Get $get): bool => (bool) $get('parent_id'))
            ->dehydrated();
    }

    public static function descriptionField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('description')
            ->label('Descripción');
    }

    public static function searchTransactionConcepts(string $search): array
    {
        return TransactionConcepts::whereRaw(
            "unaccent(lower(name)) ILIKE unaccent(lower(?))",
            ["%{$search}%"]
        )
            ->limit(5)
            ->pluck('name', 'id')
            ->toArray();
    }

    public static function getTransactionConceptLabel($value): ?string
    {
        return TransactionConcepts::find($value)?->name;
    }

    /**
     * Crear un nuevo TransactionConcept y devolver su ID.
     *
     * @param array $data
     * @return int
     */
    public static function createTransactionConcept(array $data): int
    {
        // Agregar el user_id y church_id al $data
        $data['church_id'] = Auth::user()->church_id;
        $data['user_id'] = Auth::user()->id;

        // Crear el nuevo TransactionConcept con los datos proporcionados
        return TransactionConcepts::create($data)->getKey();
    }
}
