<?php

namespace App\Models;

use App\Enums\userStatus;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable implements FilamentUser, HasAvatar
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'status',
        'email_personal',
        'church_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => userStatus::class
        ];
    }

    // Relación con la Iglesia
    public function church()
    {
        return $this->belongsTo(Church::class, 'church_id');
    }

    public function transactions () {
        return $this->hasMany(Transactions::class, 'concept_id');
    }
    public function transactionConcept () {
        return $this->hasMany(Transactions::class, 'concept_id');
    }


    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar; // Retorna null si el avatar no existe
    }
    
    public function isApproved(): bool
    {
        return $this->status === userStatus::APPROVED;}


    public function canAccessPanel(Panel $panel): bool
    {
        //   // Verificar si el usuario está aprobado antes de acceder al panel
        //   if (!$this->isApproved()) {
        //     return false; // El usuario no tiene acceso si no está aprobado
        // }
        
        return true; // Si está aprobado, puede acceder
    }
}
