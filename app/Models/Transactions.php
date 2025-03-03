<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Transactions extends Model
{
    use SoftDeletes;
    protected $fillable = ['amount', 'description', 'concept_id', 'transaction_date', 'attachments', 'church_id', 'user_id'];

    protected $casts = [
        'attachments' => 'array',
    ];
    /* Solo para disk Local */
    // protected static function booted(): void
    // {
    //     static::deleted(function (Transactions $transactions){
    //         foreach($transactions->attachments as $attachment){
    //             Storage::disk('public')->delete($attachment);
    //         }
    //     });

    //     static::updating(function (Transactions $transactions){
    //        $attachmentsToDelete = array_diff($transactions->getOriginal('attachments'), $transactions->attachments);
    //        foreach($attachmentsToDelete as $attachment){
    //         Storage::disk('public')->delete($attachment);
    //        }
    //     });

    // }


    /* boot para Cloudflare r2 */
    protected static function booted(): void
    {
        static::deleted(function (Transactions $transactions) {
            $attachments = is_string($transactions->attachments)
                ? explode(',', $transactions->attachments)
                : ($transactions->attachments ?? []);

            foreach ($attachments as $attachment) {
                Storage::disk('r2')->delete($attachment);
            }
        });

        static::updating(function (Transactions $transactions) {
            $originalAttachments = is_string($transactions->getOriginal('attachments'))
                ? explode(',', $transactions->getOriginal('attachments'))
                : ($transactions->getOriginal('attachments') ?? []);

            $currentAttachments = is_string($transactions->attachments)
                ? explode(',', $transactions->attachments)
                : ($transactions->attachments ?? []);

            $attachmentsToDelete = array_diff($originalAttachments, $currentAttachments);

            foreach ($attachmentsToDelete as $attachment) {
                Storage::disk('r2')->delete($attachment);
            }
        });
    }


    public function church()
    {
        return $this->belongsTo(Church::class, 'church_id')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function transactionConcept()
    {
        return $this->belongsTo(TransactionConcepts::class, 'concept_id')->withTrashed();  // 'concept_id' es la clave foránea en 'transactions'
    }
}
