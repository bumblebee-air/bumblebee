<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractorBidding extends Model
{
    protected $table = 'contractors_bidding';

    protected $fillable = [
        'job_id',
        'contractor_id',
        'estimated_quote'
    ];

    public function job() {
        return $this->belongsTo(Customer::class, 'job_id');
    }

    public function contractor() {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }
}
