<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Transactions extends Model
{
    protected $fillable = ['amount', 'description','concept_id', 'transaction_date' ,'attachments'];

    protected $casts = [
        'attachments' => 'array',
    ];

    protected static function booted(): void
    {
        static::deleted(function (Transactions $transactions){
            foreach($transactions->attachments as $attachment){
                Storage::disk('public')->delete($attachment);
            }
        });

        static::updating(function (Transactions $transactions){
           $attachmentsToDelete = array_diff($transactions->getOriginal('attachments'), $transactions->attachments);
           foreach($attachmentsToDelete as $attachment){
            Storage::disk('public')->delete($attachment);
           }
        });

    }

    public function team(){
        return $this->belongsTo(Team::class);
    }

    public function transactionConcept()
    {
        return $this->belongsTo(TransactionConcepts::class, 'concept_id');  // 'concept_id' es la clave foránea en 'transactions'
    }
}
