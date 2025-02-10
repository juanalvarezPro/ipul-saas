<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Church extends Model
{
    protected $fillable = [
        'name',
        'country_id',
        'province_id',
        'corregimiento_id',
        'pastor_name',
        'email',
        'phone',
        'street_address',
        'active',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Relación con el país
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function corregimiento()
{
    return $this->belongsTo(City::class, 'corregimiento_id');
}

}
