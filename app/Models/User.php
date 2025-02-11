<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\userStatus;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;


class User extends Authenticatable implements FilamentUser, HasTenants, HasAvatar
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
        'email_personal'
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
        return $this->belongsTo(Church::class);
    }

    public function role () {
        return $this->belongsTo(Role::class);
    }

    public function getFilamentAvatarUrl(): ?string
    {
        $url_R2 = env('R2_URL');
        
        // Verifica si el avatar existe antes de generar la URL
        if ($this->avatar) {
            return $url_R2 . '/' . $this->avatar;
        }
    
        return null; // Retorna null si el avatar no existe
    }
    
    public function isApproved(): bool
    {
        return $this->status === userStatus::APPROVED;}

    public function workspaces(): BelongsToMany
    {
        return $this->belongsToMany(Workspace::class);
    }

    public function getTenants(Panel $panel): Collection
    {
        return $this->workspaces;
    }



    public function canAccessTenant(Model $tenant): bool
    {
        return $this->workspaces()->whereKey($tenant)->exists();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        //   // Verificar si el usuario está aprobado antes de acceder al panel
        //   if (!$this->isApproved()) {
        //     return false; // El usuario no tiene acceso si no está aprobado
        // }
        
        return true; // Si está aprobado, puede acceder
    }
}
