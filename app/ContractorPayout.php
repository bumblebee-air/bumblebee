<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractorPayout extends Model
{
    protected $table = 'contractors_payout_history';

    protected $casts = [
        'jobs_ids' => 'array'
    ];

    protected $fillable = [
        'contractor_id',
        'transaction_id',
        'jobs_ids',
        'subtotal',
        'original_subtotal',
        'charged_amount',
        'additional',
        'notes',
    ];

    public function contractor_profile() {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }
}
