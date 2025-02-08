<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Church extends Model
{
    protected $fillable = ['name', 'address', 'active'];

        // Relación con los usuarios
        public function users()
        {
            return $this->hasMany(User::class);
        }
}
