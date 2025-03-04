<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Church extends Model
{
    use SoftDeletes;

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

    public function transactions()
    {
        return $this->hasMany(Transactions::class);
    }

    // Método para obtener el resumen de la iglesia
    public function getSummary()
    {
        return DB::table('vw_church_transaction_summary')
            ->where('church_id', $this->id)
            ->first();
    }
}
